<?php
$page = "kuliner";
include __DIR__ . '/../../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: ../kuliner.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM kuliner WHERE id='$id'");
$item = mysqli_fetch_assoc($query);
if (!$item) {
    header('Location: ../kuliner.php');
    exit;
}

function formatJam($time) {
    return $time ? date('H:i', strtotime($time)) : '-';
}
function formatHarga($harga) {
    return 'Rp ' . number_format((int)$harga, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item['nama']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

<section class="detail-budaya-header py-5 bg-light">
    <div class="container text-center">
        <h1 class="detail-budaya-title"><?= htmlspecialchars($item['nama']); ?></h1>
        <div class="detail-budaya-line mx-auto"></div>
        <p class="mt-4 text-muted">Detail lengkap kuliner khas Kolaka Utara dengan informasi lokasi, harga, jam operasional, dan sejarah singkatnya.</p>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <?php if (!empty($item['foto'])): ?>
                    <img src="../../image/uploads/kuliner/<?= htmlspecialchars($item['foto']); ?>" class="img-fluid rounded-4 detail-hero" alt="<?= htmlspecialchars($item['nama']); ?>">
                <?php else: ?>
                    <div class="bg-secondary rounded-4 text-white d-flex align-items-center justify-content-center" style="min-height: 350px;">Tanpa Foto Kuliner</div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="sejarah-card">
                    <h3 class="sejarah-title">Info Kuliner</h3>
                    <p><strong>Harga:</strong> <?= formatHarga($item['harga']); ?></p>
                    <p><strong>Lokasi:</strong> <?= htmlspecialchars($item['lokasi']); ?></p>
                    <p><strong>Jam Operasional:</strong> <?= formatJam($item['jam_operasional']); ?></p>
                    <?php if (!empty($item['sejarah'])): ?>
                        <hr>
                        <h5 class="fw-bold">Sejarah Singkat</h5>
                        <p><?= nl2br(htmlspecialchars($item['sejarah'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="sejarah-card mt-5">
            <h3 class="sejarah-title">Deskripsi Kuliner</h3>
            <p><?= nl2br(htmlspecialchars($item['deskripsi'])); ?></p>
        </div>

        <div class="text-center mt-5">
            <a href="../kuliner.php" class="btn btn-dark rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Kuliner
            </a>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
