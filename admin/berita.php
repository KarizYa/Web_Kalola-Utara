<?php

include '../config/koneksi.php';

function generateSlug($text, $conn, $excludeId = null) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    if(empty($slug)) {
        $slug = 'event-' . time();
    }

    $baseSlug = $slug;
    $count = 1;
    while(true) {
        $slugEscaped = mysqli_real_escape_string($conn, $slug);
        $query = "SELECT id FROM informasi WHERE slug='$slugEscaped'";
        if($excludeId !== null) {
            $query .= " AND id!='" . (int)$excludeId . "'";
        }
        $check = mysqli_query($conn, $query);
        if(mysqli_num_rows($check) === 0) {
            break;
        }
        $slug = $baseSlug . '-' . $count;
        $count++;
    }

    return $slug;
}

function uploadFoto($file) {
    $uploadDir = __DIR__ . '/../image/uploads/informasi/';
    if(!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if(empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK || empty($file['tmp_name'])) {
        return '';
    }

    $filename = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $filename;
    if(move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $filename;
    }

    return '';
}

function deleteFotoFile($filename) {
    if(empty($filename)) {
        return;
    }
    $path = __DIR__ . '/../image/uploads/informasi/' . $filename;
    if(file_exists($path)) {
        unlink($path);
    }
}

if(isset($_POST['tambah'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $slug = generateSlug($judul, $conn);
    $jenis = isset($_POST['jenis']) && $_POST['jenis'] === 'Berita' ? 'Berita' : 'Event';
    $ringkasan = mysqli_real_escape_string($conn, $_POST['ringkasan']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $status = $_POST['status'] === 'Draft' ? 'Draft' : 'Publish';
    $foto = uploadFoto($_FILES['foto']);

    if($jenis === 'Event') {
        $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
        $tanggal_event = $_POST['tanggal_event'] ?: null;
        $waktu_event = $_POST['waktu_event'] ?: null;
    } else {
        $lokasi = '';
        $tanggal_event = null;
        $waktu_event = null;
    }

    mysqli_query($conn, "INSERT INTO informasi(
        judul, slug, jenis, ringkasan, isi, foto, lokasi, tanggal_event, waktu_event, penulis, status
    ) VALUES(
        '$judul', '$slug', '$jenis', '$ringkasan', '$isi', '$foto', '$lokasi', " . ($tanggal_event ? "'$tanggal_event'" : 'NULL') . ", " . ($waktu_event ? "'$waktu_event'" : 'NULL') . ", '$penulis', '$status'
    )");

    header('Location: berita.php');
    exit;
}

if(isset($_POST['edit'])) {
    $id = (int) $_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $slug = generateSlug($judul, $conn, $id);
    $jenis = isset($_POST['jenis']) && $_POST['jenis'] === 'Berita' ? 'Berita' : 'Event';
    $ringkasan = mysqli_real_escape_string($conn, $_POST['ringkasan']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $status = $_POST['status'] === 'Draft' ? 'Draft' : 'Publish';

    if($jenis === 'Event') {
        $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
        $tanggal_event = $_POST['tanggal_event'] ?: null;
        $waktu_event = $_POST['waktu_event'] ?: null;
    } else {
        $lokasi = '';
        $tanggal_event = null;
        $waktu_event = null;
    }

    $query = mysqli_query($conn, "SELECT foto FROM informasi WHERE id='$id'");
    $oldData = mysqli_fetch_assoc($query);
    $foto = $oldData['foto'] ?? '';

    if(isset($_FILES['foto']) && $_FILES['foto']['name'] !== '') {
        deleteFotoFile($foto);
        $foto = uploadFoto($_FILES['foto']);
    }

    mysqli_query($conn, "UPDATE informasi SET
        judul='$judul',
        slug='$slug',
        jenis='$jenis',
        ringkasan='$ringkasan',
        isi='$isi',
        foto='$foto',
        lokasi='$lokasi',
        tanggal_event=" . ($tanggal_event ? "'$tanggal_event'" : 'NULL') . ",
        waktu_event=" . ($waktu_event ? "'$waktu_event'" : 'NULL') . ",
        penulis='$penulis',
        status='$status'
        WHERE id='$id'");

    header('Location: berita.php');
    exit;
}

if(isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $query = mysqli_query($conn, "SELECT foto FROM informasi WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    if($data) {
        deleteFotoFile($data['foto']);
        mysqli_query($conn, "DELETE FROM informasi WHERE id='$id'");
    }
    header('Location: berita.php');
    exit;
}

$keyword = $_GET['keyword'] ?? '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;
$keyword_sql = mysqli_real_escape_string($conn, $keyword);

$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM informasi WHERE (judul LIKE '%$keyword_sql%' OR lokasi LIKE '%$keyword_sql%' OR jenis LIKE '%$keyword_sql%')");
$totalRow = mysqli_fetch_assoc($totalResult);
$total = (int) ($totalRow['total'] ?? 0);
$totalPages = $total > 0 ? ceil($total / $perPage) : 0;

$queryEvent = mysqli_query($conn, "SELECT * FROM informasi WHERE (judul LIKE '%$keyword_sql%' OR lokasi LIKE '%$keyword_sql%' OR jenis LIKE '%$keyword_sql%') ORDER BY id DESC LIMIT $perPage OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Informasi — Admin Pesona Kolaka Utara</title>
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
                <i class="fas fa-newspaper" style="color: var(--accent);"></i> Kelola Informasi
            </h2>
            <button class="btn-admin" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Informasi
            </button>
        </div>

            <form method="GET">
                <div class="row mb-4">
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari judul atau lokasi..." value="<?= htmlspecialchars($keyword) ?>">
                            <button class="btn btn-dark">Cari</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="60">No</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $offset + 1; ?>
                            <?php while($row = mysqli_fetch_assoc($queryEvent)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if(!empty($row['foto'])): ?>
                                            <img src="../image/uploads/informasi/<?= $row['foto']; ?>" width="70" height="70" class="rounded me-3" style="object-fit:cover">
                                        <?php else: ?>
                                            <div class="rounded bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width:70px; height:70px;">No Img</div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= htmlspecialchars($row['judul']); ?></strong><br>
                                            <small><?= htmlspecialchars(substr($row['ringkasan'], 0, 80)); ?>...</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $row['jenis'] === 'Event' ? 'primary' : 'info' ?> text-white">
                                        <?= htmlspecialchars($row['jenis']); ?>
                                    </span>
                                </td>
                                <td><?= $row['jenis'] === 'Event' ? htmlspecialchars($row['lokasi']) : '-'; ?></td>
                                <td>
                                    <?php if($row['jenis'] === 'Event'): ?>
                                        <?= htmlspecialchars($row['tanggal_event']); ?> <?= htmlspecialchars($row['waktu_event']); ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $row['status'] === 'Publish' ? 'success' : 'secondary' ?>">
                                        <?= htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#view<?= $row['id']; ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id']; ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <a href="?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus event ini?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="view<?= $row['id']; ?>">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Detail Informasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <?php if(!empty($row['foto'])): ?>
                                                        <img src="../image/uploads/informasi/<?= $row['foto']; ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($row['judul']); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-7">
                                                    <h4><?= htmlspecialchars($row['judul']); ?></h4>
                                                    <p><strong>Jenis:</strong> <?= htmlspecialchars($row['jenis']); ?></p>
                                                    <?php if($row['jenis'] === 'Event'): ?>
                                                        <p><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']); ?></p>
                                                        <p><strong>Tanggal:</strong> <?= htmlspecialchars($row['tanggal_event']); ?> <?= htmlspecialchars($row['waktu_event']); ?></p>
                                                    <?php endif; ?>
                                                    <p><strong>Penulis:</strong> <?= htmlspecialchars($row['penulis']); ?></p>
                                                    <p><strong>Status:</strong> <?= htmlspecialchars($row['status']); ?></p>
                                                    <p><strong>Ringkasan:</strong><br> <?= nl2br(htmlspecialchars($row['ringkasan'])); ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <h6>Isi Informasi</h6>
                                                <p><?= nl2br(htmlspecialchars($row['isi'])); ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="edit<?= $row['id']; ?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5>Edit Informasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" name="judul" value="<?= htmlspecialchars($row['judul']); ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label>Jenis</label>
                                                        <select name="jenis" class="form-select edit-info-type-select">
                                                            <option value="Event" <?= $row['jenis'] === 'Event' ? 'selected' : '' ?>>Event</option>
                                                            <option value="Berita" <?= $row['jenis'] === 'Berita' ? 'selected' : '' ?>>Berita</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label>Penulis</label>
                                                        <input type="text" name="penulis" value="<?= htmlspecialchars($row['penulis']); ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Ringkasan</label>
                                                    <textarea name="ringkasan" class="form-control" rows="3"><?= htmlspecialchars($row['ringkasan']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Isi Informasi</label>
                                                    <textarea name="isi" class="form-control" rows="5" required><?= htmlspecialchars($row['isi']); ?></textarea>
                                                </div>
                                                <div class="event-fields edit-event-fields" style="<?= $row['jenis'] === 'Event' ? '' : 'display:none;' ?>">
                                                    <div class="row g-3">
                                                        <div class="col-md-4 mb-3">
                                                            <label>Lokasi</label>
                                                            <input type="text" name="lokasi" value="<?= htmlspecialchars($row['lokasi']); ?>" class="form-control">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label>Tanggal</label>
                                                            <input type="date" name="tanggal_event" value="<?= htmlspecialchars($row['tanggal_event']); ?>" class="form-control">
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label>Waktu</label>
                                                            <input type="time" name="waktu_event" value="<?= htmlspecialchars($row['waktu_event']); ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="Publish" <?= $row['status'] === 'Publish' ? 'selected' : '' ?>>Publish</option>
                                                            <option value="Draft" <?= $row['status'] === 'Draft' ? 'selected' : '' ?>>Draft</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Foto Baru</label>
                                                        <input type="file" name="foto" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="edit" class="btn btn-warning">Update</button>
                                            </div>
                                        </form>
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
                            Menampilkan <strong><?= $from ?>–<?= $to ?></strong> dari <strong><?= $total ?></strong> data
                        </span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="berita.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>" <?= $page <= 1 ? 'tabindex="-1"' : '' ?>>
                                        <i class="fas fa-chevron-left me-1"></i> Prev
                                    </a>
                                </li>
                                <?php
                                $range = 2;
                                for($i = 1; $i <= $totalPages; $i++):
                                    if($i == 1 || $i == $totalPages || ($i >= $page - $range && $i <= $page + $range)):
                                ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="berita.php?keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                                <?php elseif($i == $page - $range - 1 || $i == $page + $range + 1): ?>
                                <li class="page-item dots"><a class="page-link">…</a></li>
                                <?php endif; endfor; ?>
                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="berita.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>" <?= $page >= $totalPages ? 'tabindex="-1"' : '' ?>>
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
    </div><!-- .admin-content -->
    </main><!-- .admin-main -->
</div><!-- .admin-wrapper -->

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5>Tambah Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis</label>
                            <select name="jenis" class="form-select info-type-select">
                                <option value="Event">Event</option>
                                <option value="Berita">Berita</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Penulis</label>
                            <input type="text" name="penulis" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="Publish">Publish</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Ringkasan</label>
                        <textarea name="ringkasan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Isi Informasi</label>
                        <textarea name="isi" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="event-fields">
                        <div class="row g-3">
                            <div class="col-md-4 mb-3">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal_event" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Waktu</label>
                                <input type="time" name="waktu_event" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleEventFields(selectElement) {
        var wrapper = selectElement.closest('form').querySelector('.event-fields');
        if(!wrapper) return;
        wrapper.style.display = selectElement.value === 'Event' ? '' : 'none';
    }

    document.querySelectorAll('.info-type-select').forEach(function(select) {
        select.addEventListener('change', function() {
            toggleEventFields(select);
        });
        toggleEventFields(select);
    });

    document.querySelectorAll('.edit-info-type-select').forEach(function(select) {
        select.addEventListener('change', function() {
            var form = select.closest('form');
            var wrapper = form.querySelector('.edit-event-fields');
            if(!wrapper) return;
            wrapper.style.display = select.value === 'Event' ? '' : 'none';
        });
    });
</script>
</body>
</html>
