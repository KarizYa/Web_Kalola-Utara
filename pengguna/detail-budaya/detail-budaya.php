<?php

$page = "budaya";
include __DIR__ . '/../../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    header('Location: ../budaya.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM budaya WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    header('Location: ../budaya.php');
    exit;
}

$gallery = mysqli_query($conn, "SELECT * FROM budaya_galeri WHERE budaya_id='$id'");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama']); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

    <section class="detail-budaya-header py-5">
        <div class="container text-center">
            <h1 class="detail-budaya-title">
                <?= htmlspecialchars($data['nama']); ?>
            </h1>
            <div class="detail-budaya-line"></div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">

            <h3 class="sejarah-title">Sejarah Budaya</h3>
            <div class="sejarah-card">
                <p><?= nl2br(htmlspecialchars($data['deskripsi'])); ?></p>
            </div>

            <div class="catatan-box">
                <h6 class="catatan-title">Catatan:</h6>
                <p class="catatan-text"><?= nl2br(htmlspecialchars($data['catatan'])); ?></p>
            </div>

            <h3 class="gallery-title">Foto/Gallery</h3>
            <div class="row g-4">
                <?php if(mysqli_num_rows($gallery) > 0): ?>
                    <?php while($gambar = mysqli_fetch_assoc($gallery)): ?>
                        <div class="col-md-4">
                            <div class="gallery-card">
                                <img src="../../image/galeri/budaya/<?= $gambar['foto']; ?>" alt="<?= htmlspecialchars($data['nama']); ?>" class="img-fluid">
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada foto galeri untuk budaya ini.</div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-5">
                <a href="../budaya.php" class="btn btn-dark rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Budaya
                </a>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
