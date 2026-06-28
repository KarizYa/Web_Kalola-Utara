<?php

include '../config/koneksi.php';

function uploadFoto($file) {
    $uploadDir = __DIR__ . '/../image/uploads/kuliner/';
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
    $path = __DIR__ . '/../image/uploads/kuliner/' . $filename;
    if(file_exists($path)) {
        unlink($path);
    }
}

if(isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $sejarah = mysqli_real_escape_string($conn, $_POST['sejarah']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $harga = isset($_POST['harga']) ? (int) $_POST['harga'] : 0;
    $jam_operasional = mysqli_real_escape_string($conn, $_POST['jam_operasional']);
    $foto = uploadFoto($_FILES['foto']);

    mysqli_query($conn, "INSERT INTO kuliner(
        nama,
        deskripsi,
        sejarah,
        lokasi,
        harga,
        jam_operasional,
        foto
    ) VALUES(
        '$nama',
        '$deskripsi',
        '$sejarah',
        '$lokasi',
        $harga,
        '$jam_operasional',
        '$foto'
    )");

    header('Location: kuliner.php');
    exit;
}

if(isset($_POST['edit'])) {
    $id = (int) $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $sejarah = mysqli_real_escape_string($conn, $_POST['sejarah']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $harga = isset($_POST['harga']) ? (int) $_POST['harga'] : 0;
    $jam_operasional = mysqli_real_escape_string($conn, $_POST['jam_operasional']);

    $query = mysqli_query($conn, "SELECT foto FROM kuliner WHERE id='$id'");
    $oldData = mysqli_fetch_assoc($query);
    $foto = $oldData['foto'] ?? '';

    if(isset($_FILES['foto']) && $_FILES['foto']['name'] !== '') {
        deleteFotoFile($foto);
        $foto = uploadFoto($_FILES['foto']);
    }

    mysqli_query($conn, "UPDATE kuliner SET
        nama='$nama',
        deskripsi='$deskripsi',
        sejarah='$sejarah',
        lokasi='$lokasi',
        harga=$harga,
        jam_operasional='$jam_operasional',
        foto='$foto'
        WHERE id='$id'");

    header('Location: kuliner.php');
    exit;
}

if(isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $query = mysqli_query($conn, "SELECT foto FROM kuliner WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    if($data) {
        deleteFotoFile($data['foto']);
        mysqli_query($conn, "DELETE FROM kuliner WHERE id='$id'");
    }
    header('Location: kuliner.php');
    exit;
}

$keyword = $_GET['keyword'] ?? '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;
$keyword_sql = mysqli_real_escape_string($conn, $keyword);

$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kuliner WHERE nama LIKE '%$keyword_sql%' OR lokasi LIKE '%$keyword_sql%'");
$totalRow = mysqli_fetch_assoc($totalResult);
$total = (int) ($totalRow['total'] ?? 0);
$totalPages = $total > 0 ? ceil($total / $perPage) : 0;

$queryKuliner = mysqli_query($conn, "SELECT * FROM kuliner WHERE nama LIKE '%$keyword_sql%' OR lokasi LIKE '%$keyword_sql%' ORDER BY id DESC LIMIT $perPage OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kuliner — Admin Pesona Kolaka Utara</title>
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
                <i class="fas fa-utensils" style="color: var(--accent);"></i> Kelola Kuliner
            </h2>
            <button class="btn-admin" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Kuliner
            </button>
        </div>

            <form method="GET">
                <div class="row mb-4">
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($keyword) ?>">
                            <button class="btn btn-cari"><i class="fas fa-search me-1"></i>Cari</button>
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
                                <th>Nama Kuliner</th>
                                <th>Lokasi</th>
                                <th>Harga</th>
                                <th>Jam Operasional</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $offset + 1; ?>
                            <?php while($row = mysqli_fetch_assoc($queryKuliner)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if(!empty($row['foto'])): ?>
                                            <img src="../image/uploads/kuliner/<?= htmlspecialchars($row['foto']); ?>" width="70" height="70" class="rounded me-3" style="object-fit:cover">
                                        <?php else: ?>
                                            <div class="rounded bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width:70px; height:70px;">No Img</div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= htmlspecialchars($row['nama']); ?></strong><br>
                                            <small><?= htmlspecialchars(substr($row['deskripsi'], 0, 80)); ?>...</small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                <td>Rp <?= number_format((int)$row['harga'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($row['jam_operasional']); ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#view<?= $row['id']; ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id']; ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <a href="?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kuliner ini?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="view<?= $row['id']; ?>">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Detail Kuliner</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <?php if(!empty($row['foto'])): ?>
                                                        <img src="../image/uploads/kuliner/<?= htmlspecialchars($row['foto']); ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($row['nama']); ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-7">
                                                    <h4><?= htmlspecialchars($row['nama']); ?></h4>
                                                    <p><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']); ?></p>
                                                    <p><strong>Harga:</strong> Rp <?= number_format((int)$row['harga'], 0, ',', '.'); ?></p>
                                                    <p><strong>Jam Operasional:</strong> <?= htmlspecialchars($row['jam_operasional']); ?></p>
                                                    <p><strong>Deskripsi:</strong><br> <?= nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                                                </div>
                                            </div>
                                            <?php if(!empty($row['sejarah'])): ?>
                                            <hr>
                                            <div>
                                                <h6>Sejarah Kuliner</h6>
                                                <p><?= nl2br(htmlspecialchars($row['sejarah'])); ?></p>
                                            </div>
                                            <?php endif; ?>
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
                                                <h5>Edit Kuliner</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Nama Kuliner</label>
                                                        <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Harga</label>
                                                        <input type="number" min="0" step="1" name="harga" value="<?= htmlspecialchars($row['harga']); ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($row['deskripsi']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Sejarah</label>
                                                    <textarea name="sejarah" class="form-control" rows="3"><?= htmlspecialchars($row['sejarah']); ?></textarea>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Lokasi</label>
                                                        <input type="text" name="lokasi" value="<?= htmlspecialchars($row['lokasi']); ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Jam Operasional</label>
                                                        <input type="time" name="jam_operasional" value="<?= htmlspecialchars($row['jam_operasional']); ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Foto Baru</label>
                                                    <input type="file" name="foto" class="form-control">
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
                                    <a class="page-link" href="kuliner.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>" <?= $page <= 1 ? 'tabindex="-1"' : '' ?>>
                                        <i class="fas fa-chevron-left me-1"></i> Prev
                                    </a>
                                </li>
                                <?php
                                $range = 2;
                                for($i = 1; $i <= $totalPages; $i++):
                                    if($i == 1 || $i == $totalPages || ($i >= $page - $range && $i <= $page + $range)):
                                ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="kuliner.php?keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                                <?php elseif($i == $page - $range - 1 || $i == $page + $range + 1): ?>
                                <li class="page-item dots"><a class="page-link">…</a></li>
                                <?php endif; endfor; ?>
                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="kuliner.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>" <?= $page >= $totalPages ? 'tabindex="-1"' : '' ?>>
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
                    <h5>Tambah Kuliner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Kuliner</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Harga</label>
                            <input type="number" min="0" step="1" name="harga" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Sejarah</label>
                        <textarea name="sejarah" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jam Operasional</label>
                            <input type="time" name="jam_operasional" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" required>
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
</body>
</html>
