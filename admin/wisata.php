<?php

include '../config/koneksi.php';

//tambah data
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

    header("Location: wisata.php");
    exit;
}

//edit data

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

//hapus data

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

    mysqli_query(
        $conn,
        "DELETE FROM wisata WHERE id='$id'"
    );

    header("Location: wisata.php");
    exit;
}

//cari data

$keyword = $_GET['keyword'] ?? '';

// Pagination settings
$page = isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

$keyword_sql = mysqli_real_escape_string($conn, $keyword);

// total rows for pagination
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

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Kelola Wisata</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
      href="admin.css">

</head>

<body>

<?php include '../component/navbar-admin.php'; ?>

<div class="container-fluid">

<div class="row">

<div class="col-lg-3 p-0">

<?php include '../component/sidebar-admin.php'; ?>

</div>

<div class="col-lg-9 admin-content">

<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="fw-bold">

<i class="fa-regular fa-image"></i>

Kelola Wisata

</h2>

<button
class="btn btn-dark"
data-bs-toggle="modal"
data-bs-target="#modalTambah">

<i class="fa-solid fa-plus"></i>

Tambah Wisata

</button>

</div>

<!-- SEARCH -->

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

<button
class="btn btn-dark">

Cari

</button>

</div>

</div>

</div>

</form>

<!-- TABLE -->

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

<!-- MODAL EDIT -->

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

<!-- MODAL VIEW -->
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

<?php if($totalPages > 1): ?>
<div class="mt-3">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="wisata.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page-1 ?>">&laquo; Prev</a>
            </li>
            <?php endif; ?>

            <?php for($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="wisata.php?keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <?php if($page < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="wisata.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page+1 ?>">Next &raquo;</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php endif; ?>

</div>

</div>

</div>

</div>

</div>

<!-- MODAL TAMBAH -->

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

</body>
</html>