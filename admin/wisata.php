<?php

include '../config/koneksi.php';

function uploadGalleryFiles($wisataId, $files, $conn){
    $uploadDir = __DIR__ . '/../image/galeri/wisata/';
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0755, true);
    }

    for($i = 0; $i < count($files['name']); $i++){
        if(
            empty($files['name'][$i]) ||
            $files['error'][$i] !== UPLOAD_ERR_OK ||
            empty($files['tmp_name'][$i])
        ){
            continue;
        }

        $galleryName = time().'_'.$i.'_'.basename($files['name'][$i]);

        if(move_uploaded_file($files['tmp_name'][$i], $uploadDir.$galleryName)){
            mysqli_query(
                $conn,
                "INSERT INTO wisata_galeri(wisata_id, foto) VALUES('$wisataId','$galleryName')"
            );
        }
    }
}

function deleteGalleryFiles($wisataId, $conn){
    $galleryResult = mysqli_query(
        $conn,
        "SELECT * FROM wisata_galeri WHERE wisata_id='$wisataId'"
    );

    while($gallery = mysqli_fetch_assoc($galleryResult)){
        $galleryPath = __DIR__ . '/../image/galeri/wisata/'.$gallery['foto'];

        if(file_exists($galleryPath) && $gallery['foto'] != ''){
            unlink($galleryPath);
        }
    }

    mysqli_query(
        $conn,
        "DELETE FROM wisata_galeri WHERE wisata_id='$wisataId'"
    );
}

function deleteGalleryItem($galleryId, $conn){
    $query = mysqli_query(
        $conn,
        "SELECT * FROM wisata_galeri WHERE id='$galleryId'"
    );

    if($gallery = mysqli_fetch_assoc($query)){
        $galleryPath = __DIR__ . '/../image/galeri/wisata/'.$gallery['foto'];
        if(file_exists($galleryPath) && $gallery['foto'] != ''){
            unlink($galleryPath);
        }

        mysqli_query(
            $conn,
            "DELETE FROM wisata_galeri WHERE id='$galleryId'"
        );

        return $gallery['wisata_id'];
    }

    return 0;
}

if(isset($_GET['hapus_galeri'])){
    $galleryId = (int) $_GET['hapus_galeri'];
    $wisataId = deleteGalleryItem($galleryId, $conn);
    header("Location: wisata.php?show_edit=".$wisataId);
    exit;
}

if(isset($_POST['tambah'])){

    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi']);
    $jenis = mysqli_real_escape_string($conn,$_POST['jenis_wisata']);
    $alamat = mysqli_real_escape_string($conn,$_POST['alamat']);
    $harga = mysqli_real_escape_string($conn,$_POST['harga']);

    $foto = '';

    if($_FILES['foto']['name'] != ''){

        $foto = time().'_'.$_FILES['foto']['name'];

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            __DIR__ . '/../image/uploads/wisata/'.$foto
        );
    }

    mysqli_query(
        $conn,
        "INSERT INTO wisata(
            nama,
            deskripsi,
            jenis_wisata,
            alamat,
            harga,
            foto
        )
        VALUES(
            '$nama',
            '$deskripsi',
            '$jenis',
            '$alamat',
            '$harga',
            '$foto'
        )"
    );

    $insertId = mysqli_insert_id($conn);

    if(isset($_FILES['galeri']) && !empty($_FILES['galeri']['name'][0])){
        uploadGalleryFiles($insertId, $_FILES['galeri'], $conn);
    }

    header("Location: wisata.php");
    exit;
}

if(isset($_POST['edit'])){

    $id = $_POST['id'];

    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi']);
    $jenis = mysqli_real_escape_string($conn,$_POST['jenis_wisata']);
    $alamat = mysqli_real_escape_string($conn,$_POST['alamat']);
    $harga = mysqli_real_escape_string($conn,$_POST['harga']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM wisata WHERE id='$id'"
    );

    $oldData = mysqli_fetch_assoc($query);

    $foto = $oldData['foto'];

    if($_FILES['foto']['name'] != ''){

        if(
            file_exists(__DIR__ . '/../image/uploads/wisata/'.$foto)
            &&
            $foto != ''
        ){
            unlink(__DIR__ . '/../image/uploads/wisata/'.$foto);
        }

        $foto = time().'_'.$_FILES['foto']['name'];

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            __DIR__ . '/../image/uploads/wisata/'.$foto
        );
    }

    if(isset($_FILES['galeri']) && !empty($_FILES['galeri']['name'][0])){
        uploadGalleryFiles($id, $_FILES['galeri'], $conn);
    }

    mysqli_query(
        $conn,
        "UPDATE wisata SET
            nama='$nama',
            deskripsi='$deskripsi',
            jenis_wisata='$jenis',
            alamat='$alamat',
            harga='$harga',
            foto='$foto'
        WHERE id='$id'"
    );

    header("Location: wisata.php");
    exit;
}

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM wisata WHERE id='$id'"
    );

    $data = mysqli_fetch_assoc($query);

    if(
        file_exists(__DIR__ . '/../image/uploads/wisata/'.$data['foto'])
        &&
        $data['foto'] != ''
    ){
        unlink(__DIR__ . '/../image/uploads/wisata/'.$data['foto']);
    }

    deleteGalleryFiles($id, $conn);

    mysqli_query(
        $conn,
        "DELETE FROM wisata WHERE id='$id'"
    );

    header("Location: wisata.php");
    exit;
}

$keyword = $_GET['keyword'] ?? '';

$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

$keyword_sql = mysqli_real_escape_string($conn, $keyword);

$totalResult = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM wisata WHERE nama LIKE '%$keyword_sql%'");
$totalRow = mysqli_fetch_assoc($totalResult);
$total = (int) ($totalRow['total'] ?? 0);
$totalPages = $total > 0 ? ceil($total / $perPage) : 0;

$queryWisata = mysqli_query(
    $conn,
    "SELECT *
     FROM wisata
     WHERE nama LIKE '%$keyword_sql%'
     ORDER BY id DESC
     LIMIT $perPage OFFSET $offset"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Wisata — Admin Pesona Kolaka Utara</title>
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
        <i class="fas fa-mountain-sun" style="color: var(--accent);"></i> Kelola Wisata
    </h2>
    <button class="btn-admin" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus"></i> Tambah Wisata
    </button>
</div>

<form method="GET">
<div class="row mb-4">
<div class="col-lg-5">
<div class="input-group">
<input
type="text"
name="keyword"
class="form-control"
placeholder="Search..."
value="<?= $keyword ?>">
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
<th>Nama Wisata</th>
<th>Jenis</th>
<th>Alamat</th>
<th>Harga</th>
<th width="120">Aksi</th>
</tr>
</thead>
<tbody>

<?php $no = $offset + 1; ?>
<?php while($row = mysqli_fetch_assoc($queryWisata)): ?>

<tr>
<td><?= $no++; ?></td>
<td>
<div class="d-flex align-items-center">
<img
src="../image/uploads/wisata/<?= $row['foto']; ?>"
width="70"
height="70"
class="rounded me-3"
style="object-fit:cover">
<div>

<strong>
<?= $row['nama']; ?>
</strong>
<br>

<small>
<?= substr($row['deskripsi'],0,60); ?>
...
</small>
</div>
</div>
</td>
<td>
<span class="badge bg-dark">
<?= $row['jenis_wisata']; ?>
</span>
</td>
<td>
<?= $row['alamat']; ?>
</td>

<td>
Rp <?= number_format($row['harga'],0,',','.'); ?>
</td>

<td>
    <div class="d-flex gap-1">
        <button
            class="btn btn-primary btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#view<?= $row['id']; ?>">
            <i class="fa-solid fa-eye"></i>
        </button>

        <button
            class="btn btn-warning btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#edit<?= $row['id']; ?>">
            <i class="fa-solid fa-pen"></i>
        </button>

        <a
            href="?hapus=<?= $row['id']; ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Yakin hapus data?')">
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
</td>

</tr>

<?php $galleryResult = mysqli_query($conn, "SELECT * FROM wisata_galeri WHERE wisata_id='{$row['id']}'"); ?>

<div
class="modal fade"
id="edit<?= $row['id']; ?>">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<form
method="POST"
enctype="multipart/form-data">

<div class="modal-header">

<h5>Edit Wisata</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<input
type="hidden"
name="id"
value="<?= $row['id']; ?>">

<div class="mb-3">

<label>Nama Wisata</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= $row['nama']; ?>">

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-control"
rows="4"><?= $row['deskripsi']; ?></textarea>

</div>

<div class="mb-3">

<label>Jenis Wisata</label>

<input
type="text"
name="jenis_wisata"
class="form-control"
value="<?= $row['jenis_wisata']; ?>">

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"><?= $row['alamat']; ?></textarea>

</div>

<div class="mb-3">

<label>Harga</label>

<input
type="number"
name="harga"
class="form-control"
value="<?= $row['harga']; ?>">

</div>

<div class="mb-3">

<label>Foto Baru</label>

<input
type="file"
name="foto"
class="form-control">

</div>

<div class="mb-3">
    <label>Galeri Wisata Saat Ini</label>
    <div class="d-flex flex-wrap gap-2">
        <?php if(mysqli_num_rows($galleryResult) > 0): ?>
            <?php while($galleryItem = mysqli_fetch_assoc($galleryResult)): ?>
                <div class="position-relative" style="width:70px; height:70px;">
                    <img
                        src="../image/galeri/wisata/<?= $galleryItem['foto']; ?>"
                        width="70"
                        height="70"
                        class="rounded"
                        style="object-fit:cover;">
                    <a
                        href="?hapus_galeri=<?= $galleryItem['id']; ?>&wisata_id=<?= $row['id']; ?>"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0"
                        style="padding:0.25rem; line-height:1;"
                        onclick="return confirm('Hapus foto galeri ini?');">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="text-muted">Belum ada foto galeri.</div>
        <?php endif; ?>
    </div>
</div>

<div class="mb-3">

<label>Tambah Galeri Wisata</label>

<input
	type="file"
	name="galeri[]"
	class="form-control"
	multiple>

<small class="text-muted">Opsional, bisa pilih lebih dari satu foto.</small>

</div>

</div>

<div class="modal-footer">
    <button
        type="submit"
        name="edit"
        class="btn btn-warning">
        Update
    </button>
</div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="view<?= $row['id']; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Wisata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="../image/uploads/wisata/<?= $row['foto']; ?>" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8">
                        <h4><?= $row['nama']; ?></h4>
                        <p><strong>Jenis:</strong> <?= $row['jenis_wisata']; ?></p>
                        <p><strong>Alamat:</strong> <?= $row['alamat']; ?></p>
                        <p><strong>Harga:</strong> Rp <?= number_format($row['harga'],0,',','.'); ?></p>
                        <p><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></p>

                        <?php $viewGallery = mysqli_query($conn, "SELECT * FROM wisata_galeri WHERE wisata_id='{$row['id']}'"); ?>
                        <?php if(mysqli_num_rows($viewGallery) > 0): ?>
                            <div class="mt-3">
                                <h6>Galeri Wisata</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php while($galleryItem = mysqli_fetch_assoc($viewGallery)): ?>
                                        <img
                                            src="../image/galeri/wisata/<?= $galleryItem['foto']; ?>"
                                            class="img-fluid rounded"
                                            style="width:120px; height:120px; object-fit:cover;">
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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
        Menampilkan <strong><?= $from ?>–<?= $to ?></strong> dari <strong><?= $total ?></strong> data
    </span>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="wisata.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page-1 ?>" <?= $page <= 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                    <i class="fas fa-chevron-left me-1"></i> Prev
                </a>
            </li>

            <?php
            $range = 2;
            for($i = 1; $i <= $totalPages; $i++):
                if($i == 1 || $i == $totalPages || ($i >= $page - $range && $i <= $page + $range)):
            ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="wisata.php?keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php
                elseif($i == $page - $range - 1 || $i == $page + $range + 1):
            ?>
            <li class="page-item dots"><a class="page-link">…</a></li>
            <?php endif; endfor; ?>

            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="wisata.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page+1 ?>" <?= $page >= $totalPages ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                    Next <i class="fas fa-chevron-right ms-1"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>

    </div>
    </div>
    </main>
</div>

<div
class="modal fade"
id="modalTambah">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<form
method="POST"
enctype="multipart/form-data">

<div class="modal-header">

<h5>Tambah Wisata</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<div class="mb-3">

<label>Nama Wisata</label>

<input
type="text"
name="nama"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="4"
class="form-control"
required></textarea>

</div>

<div class="mb-3">

<label>Jenis Wisata</label>

<input
type="text"
name="jenis_wisata"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"
required></textarea>

</div>

<div class="mb-3">

<label>Harga</label>

<input
type="number"
name="harga"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Foto</label>

<input
type="file"
name="foto"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Galeri Wisata</label>

<input
	type="file"
	name="galeri[]"
	class="form-control"
	multiple>

<small class="text-muted">Opsional, bisa pilih lebih dari satu foto.</small>

</div>

</div>

<div class="modal-footer">
    <button
        type="submit"
        name="tambah"
        class="btn btn-dark">
        Simpan
    </button>
</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<?php if(isset($_GET['show_edit']) && is_numeric($_GET['show_edit'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        var modalEl = document.getElementById('edit<?= (int) $_GET['show_edit']; ?>');
        if(modalEl){
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });
</script>
<?php endif; ?>

</body>
</html>