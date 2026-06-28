<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: auth/login.php');
    exit;
}

include __DIR__ . '/../config/koneksi.php';

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM wisata"));
$totalWisata = $row ? (int)$row['total'] : 0;

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM budaya"));
$totalBudaya = $row ? (int)$row['total'] : 0;

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kuliner"));
$totalKuliner = $row ? (int)$row['total'] : 0;

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM ulasan"));
$totalUlasan = $row ? (int)$row['total'] : 0;

$ulasanTerbaru = [];
$q = "SELECT u.nama, COALESCE(w.nama, '-') AS tempat, u.komentar AS ulasan, u.rating,
             DATE_FORMAT(u.created_at, '%d/%m/%Y') AS tanggal
      FROM ulasan u
      LEFT JOIN wisata w ON u.wisata_id = w.id
      ORDER BY u.created_at DESC
      LIMIT 2";
$res = mysqli_query($conn, $q);
if ($res) {
    while ($r = mysqli_fetch_assoc($res)) {
        $ulasanTerbaru[] = $r;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Pesona Kolaka Utara</title>
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
                <div class="content-header mb-4">
                    <h2>
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </h2>
                    <p class="page-title-sub">Selamat datang kembali, Administrator!</p>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-mountain-sun"></i>
                            </div>
                            <div class="stat-number"><?= $totalWisata ?></div>
                            <div class="stat-label">Total Wisata</div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card blue">
                            <div class="stat-icon">
                                <i class="fas fa-masks-theater"></i>
                            </div>
                            <div class="stat-number"><?= $totalBudaya ?></div>
                            <div class="stat-label">Data Budaya</div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card amber">
                            <div class="stat-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="stat-number"><?= $totalKuliner ?></div>
                            <div class="stat-label">Item Kuliner</div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card violet">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-number"><?= $totalUlasan ?></div>
                            <div class="stat-label">Total Ulasan</div>
                        </div>
                    </div>
                </div>

                <div class="review-section">
                    <div class="review-header">
                        <h2>
                            <i class="fas fa-comment-dots me-2" style="color: var(--accent);"></i>
                            Ulasan Pengunjung Terbaru
                        </h2>
                        <a href="ulasan.php" class="lihat-semua">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="review-body">
                        <?php if (empty($ulasanTerbaru)): ?>
                            <p class="text-muted py-4 text-center">Belum ada ulasan.</p>
                        <?php else: ?>
                            <?php foreach ($ulasanTerbaru as $ulasan): ?>
                                <div class="review-item">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                        <div>
                                            <div class="review-reviewer"><?= htmlspecialchars($ulasan['nama']) ?></div>
                                            <div class="review-place">
                                                <i class="fas fa-location-dot me-1"></i>
                                                <?= htmlspecialchars($ulasan['tempat']) ?>
                                            </div>
                                        </div>
                                        <div class="review-date">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?= $ulasan['tanggal'] ?>
                                        </div>
                                    </div>
                                    <p class="review-text">"<?= htmlspecialchars($ulasan['ulasan']) ?>"</p>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa-<?= $i <= $ulasan['rating'] ? 'solid' : 'regular' ?> fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
