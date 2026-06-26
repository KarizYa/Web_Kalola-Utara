<?php
include __DIR__ . '/../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    header('Location: ../pengguna/wisata.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM wisata WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    header('Location: ../pengguna/wisata.php');
    exit;
}

$gallery = mysqli_query($conn, "SELECT * FROM wisata_galeri WHERE wisata_id='$id'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

 <div class="container py-5 detail-page">

        <!-- Judul -->
        <div class="text-center mb-5">

            <h1 class="detail-title">
                <?= htmlspecialchars($data['nama']); ?>
            </h1>

            <p class="detail-desc">
                <?= nl2br(htmlspecialchars(substr($data['deskripsi'],0,200))); ?>
            </p>

        </div>

        <!-- Gambar Utama -->
        <div class="text-center mb-5">

            <img src="../image/uploads/wisata/<?= $data['foto']; ?>"
                 class="img-fluid rounded-4 detail-hero"
                 alt="<?= htmlspecialchars($data['nama']); ?>">

        </div>

        <!-- Informasi Wisata -->
        <h5 class="fw-bold mb-3">
            Informasi Wisata
        </h5>

        <div class="info-card mb-5">

            <div class="row text-center">

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Jenis Wisata
                    </h6>

                    <p class="fw-semibold">
                        <?= htmlspecialchars($data['jenis_wisata']); ?>
                    </p>

                </div>

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Alamat
                    </h6>

                    <p class="fw-semibold">
                        <i class="fas fa-location-dot"></i>
                        <?= htmlspecialchars($data['alamat']); ?>
                    </p>

                </div>

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Tarif/Harga
                    </h6>

                    <p class="fw-semibold mb-1">
                        Rp <?= number_format($data['harga'],0,',','.'); ?>
                    </p>

                    <p class="fw-semibold">
                        Per Orang
                    </p>

                </div>

            </div>

        </div>

        <!-- Gallery -->
        <h5 class="fw-bold mb-3">
            Foto/Gallery
        </h5>

        <div class="row g-4">

            <?php if(mysqli_num_rows($gallery) > 0): ?>
                <?php while($g = mysqli_fetch_assoc($gallery)): ?>
                    <div class="col-md-4">
                        <img src="../image/galeri/wisata/<?= $g['foto']; ?>"
                             class="img-fluid gallery-img"
                             alt="">
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-muted">Belum ada foto galeri.</div>
                </div>
            <?php endif; ?>

        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
