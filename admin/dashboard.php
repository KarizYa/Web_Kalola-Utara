<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: auth/login.php');
    exit;
}

$totalWisata = 3;
$totalBudaya = 1;
$totalKuliner = 2;
$totalUlasan = 2;

$ulasanTerbaru = [
    [
        "nama" => "Budi Santoso",
        "tempat" => "Danau Biru Kolaka Utara",
        "ulasan" => "Danau Biru sangat indah dan airnya segar! Tempatnya cukup bersih.",
        "rating" => 5,
        "tanggal" => "15/10/2023"
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php include '../component/navbar-admin.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-3 p-0">
                <?php include '../component/sidebar-admin.php'; ?>
            </div>
            <!-- Content -->
            <div class="col-lg-9 col-xl-9 admin-content">
                <!-- Header -->
                <div class="content-header">
                    <h2 class="fw-bold">
                        <i class="fa-solid fa-chart-column me-2"></i>
                        Dashboard Admin
                    </h2>
                </div>

                <!-- Statistik -->
                <div class="row g-4 mb-4">
                    <!-- Wisata -->
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <i class="fa-regular fa-image dashboard-icon"></i>
                            <h3><?= $totalWisata ?></h3>
                            <p>Total Wisata</p>
                        </div>
                    </div>
                    <!-- Budaya -->
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <i class="fa-solid fa-book-open dashboard-icon"></i>
                            <h3><?= $totalBudaya ?></h3>
                            <p>Data Budaya</p>
                        </div>
                    </div>
                    <!-- Kuliner -->
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <i class="fa-solid fa-utensils dashboard-icon"></i>
                            <h3><?= $totalKuliner ?></h3>
                            <p>Item Kuliner</p>
                        </div>
                    </div>
                    <!-- Ulasan -->
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <i class="fa-regular fa-comment-dots dashboard-icon"></i>
                            <h3><?= $totalUlasan ?></h3>
                            <p>Ulasan Baru</p>
                        </div>
                    </div>
                </div>
                <!-- Ulasan Terbaru -->
                <div class="review-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold mb-0">
                            Ulasan Pengunjung Terbaru
                        </h2>
                        <a href="ulasan.php" class="lihat-semua">
                            Lihat Semua >
                        </a>
                    </div>
                    <?php foreach($ulasanTerbaru as $ulasan): ?>
                        <div class="review-item">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <h4 class="fw-bold mb-1">
                                        <?= $ulasan['nama']; ?>
                                    </h4>
                                    <h5 class="mb-0">
                                        <?= $ulasan['tempat']; ?>
                                    </h5>
                                </div>
                                <strong>
                                    <?= $ulasan['tanggal']; ?>
                                </strong>
                            </div>
                            <p class="review-text mt-3">
                                "<?= $ulasan['ulasan']; ?>"
                            </p>
                            <div class="rating">
                                <?php for($i = 1; $i <= $ulasan['rating']; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
