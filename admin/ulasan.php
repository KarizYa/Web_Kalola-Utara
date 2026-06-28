<?php
include '../config/koneksi.php';

if(isset($_GET['hapus'])){
    $id = (int) $_GET['hapus'];
    $q = mysqli_query($conn, "SELECT * FROM ulasan WHERE id='$id'");
    if(mysqli_num_rows($q) > 0){
        mysqli_query($conn, "DELETE FROM ulasan WHERE id='$id'");
    }
    $redirect = 'ulasan.php';
    header('Location: ' . $redirect);
    exit;
}

$wisata_filter = isset($_GET['wisata_id']) ? (int) $_GET['wisata_id'] : 0;
$rating_filter = isset($_GET['rating']) ? (int) $_GET['rating'] : 0;
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$where = [];
if($wisata_filter > 0) $where[] = "u.wisata_id='{$wisata_filter}'";
if($rating_filter > 0) $where[] = "u.rating='{$rating_filter}'";
$where_sql = '';
if(count($where) > 0) $where_sql = 'WHERE ' . implode(' AND ', $where);

$totalQ = mysqli_query($conn, "SELECT COUNT(*) AS total FROM ulasan u {$where_sql}");
$totalRow = mysqli_fetch_assoc($totalQ);
$total = (int) ($totalRow['total'] ?? 0);
$totalPages = $total > 0 ? ceil($total / $perPage) : 0;

$query = mysqli_query($conn, "SELECT u.*, w.nama AS wisata_name FROM ulasan u LEFT JOIN wisata w ON w.id = u.wisata_id {$where_sql} ORDER BY u.created_at DESC LIMIT {$perPage} OFFSET {$offset}");

$wisataList = mysqli_query($conn, "SELECT id, nama FROM wisata ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ulasan — Admin Pesona Kolaka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css?v=2">
</head>
<body>
<?php include '../component/navbar-admin.php'; ?>
<div class="admin-wrapper">
    <?php include '../component/sidebar-admin.php'; ?>
    <main class="admin-main">
    <div class="admin-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="font-family: var(--font);">
                <i class="fas fa-star" style="color: var(--accent);"></i> Kelola Ulasan
            </h2>
        </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <form method="GET" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label>Filter Wisata</label>
                            <select name="wisata_id" class="form-select">
                                <option value="0">Semua Wisata</option>
                                <?php while($w = mysqli_fetch_assoc($wisataList)): ?>
                                    <option value="<?= $w['id'] ?>" <?= $w['id'] == $wisata_filter ? 'selected' : ''?>><?= htmlspecialchars($w['nama']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Filter Rating</label>
                            <select name="rating" class="form-select">
                                <option value="0">Semua Rating</option>
                                <?php for($r=5;$r>=1;$r--): ?>
                                    <option value="<?= $r ?>" <?= $r == $rating_filter ? 'selected' : ''?>><?= $r ?> &nbsp; bintang</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-cari">Terapkan</button>
                        </div>
                        <div class="col-md-3 text-end">
                            <small class="text-muted">Total: <?= $total ?> ulasan</small>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="60">No</th>
                                <th>Wisata</th>
                                <th>Nama</th>
                                <th>Rating</th>
                                <th>Komentar</th>
                                <th>Tanggal</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = $offset + 1; ?>
                        <?php while($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['wisata_name'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td>
                                    <?php for($i=1;$i<=5;$i++): ?>
                                        <?php if($i <= (int)$row['rating']): ?>
                                            <i class="fa-solid fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="fa-regular fa-star text-muted"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </td>
                                <td style="max-width:300px;"><?= nl2br(htmlspecialchars(strlen($row['komentar']) > 180 ? substr($row['komentar'],0,180) . '...' : $row['komentar'])); ?></td>
                                <td><?= htmlspecialchars(date('d M Y H:i', strtotime($row['created_at']))); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#view<?= $row['id'] ?>" title="Lihat">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <a href="?hapus=<?= $row['id']; ?>&wisata_id=<?= $wisata_filter ?>&rating=<?= $rating_filter ?>&page=<?= $page ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus ulasan ini?');" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="view<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ulasan oleh <?= htmlspecialchars($row['nama']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Wisata:</strong> <?= htmlspecialchars($row['wisata_name'] ?? '-') ?></p>
                                            <p><strong>Rating:</strong>
                                                <?php for($s=1;$s<=5;$s++): ?>
                                                    <?php if($s <= (int)$row['rating']): ?>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="fa-regular fa-star text-muted"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </p>
                                            <p><strong>Waktu:</strong> <?= htmlspecialchars(date('d M Y H:i', strtotime($row['created_at']))) ?></p>
                                            <hr>
                                            <p><?= nl2br(htmlspecialchars($row['komentar'])) ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                        </tbody>
                    </table>

                    <?php if($totalPages >= 1): ?>
                        <div class="pagination-wrapper">
                            <span class="pagination-info">
                                <?php $from = $total > 0 ? $offset + 1 : 0; $to = min($offset + $perPage, $total); ?>
                                Menampilkan <strong><?= $from ?>–<?= $to ?></strong> dari <strong><?= $total ?></strong> ulasan
                            </span>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?wisata_id=<?= $wisata_filter ?>&rating=<?= $rating_filter ?>&page=<?= $page-1 ?>" <?= $page <= 1 ? 'tabindex="-1"' : '' ?>>
                                            <i class="fas fa-chevron-left me-1"></i> Prev
                                        </a>
                                    </li>
                                    <?php
                                    $range = 2;
                                    for($p=1;$p<=$totalPages;$p++):
                                        if($p == 1 || $p == $totalPages || ($p >= $page - $range && $p <= $page + $range)):
                                    ?>
                                    <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?wisata_id=<?= $wisata_filter ?>&rating=<?= $rating_filter ?>&page=<?= $p ?>"><?= $p ?></a>
                                    </li>
                                    <?php elseif($p == $page - $range - 1 || $p == $page + $range + 1): ?>
                                    <li class="page-item dots"><a class="page-link">…</a></li>
                                    <?php endif; endfor; ?>
                                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?wisata_id=<?= $wisata_filter ?>&rating=<?= $rating_filter ?>&page=<?= $page+1 ?>" <?= $page >= $totalPages ? 'tabindex="-1"' : '' ?>>
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    </div>
    </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
