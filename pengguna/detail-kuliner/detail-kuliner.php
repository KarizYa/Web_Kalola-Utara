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
    <title><?= htmlspecialchars($item['nama']); ?> - Detail Kuliner</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../pengguna.css?v=2">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

<div class="container py-5 detail-body-padding">
    
    <!-- Breadcrumb & Back Button -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="../beranda.php" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="../kuliner.php" class="text-decoration-none text-muted">Kuliner</a></li>
                <li class="breadcrumb-item active text-primary-color fw-semibold" aria-current="page"><?= htmlspecialchars($item['nama']); ?></li>
            </ol>
        </nav>
        <a href="../kuliner.php" class="btn btn-outline-dark rounded-pill px-3 py-1 btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Judul & Deskripsi -->
    <div class="text-center mb-5">
        <span class="badge bg-category px-3 py-2 mb-2">KULINER KHAS</span>
        <h1 class="display-4 fw-bold text-primary-color mb-3">
            <?= htmlspecialchars($item['nama']); ?>
        </h1>
        <div class="garis-aesthetic mx-auto"></div>
    </div>

    <div class="row g-5">
        <!-- Kolom Kiri: Foto Utama & Deskripsi -->
        <div class="col-lg-8">
            <div class="detail-hero-wrapper mb-5">
                <?php 
                $foto_path = "../../image/uploads/kuliner/" . $item['foto'];
                $foto_url = (!empty($item['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../../image/default-kuliner.png';
                ?>
                <img src="<?= $foto_url; ?>" class="img-fluid w-100" alt="<?= htmlspecialchars($item['nama']); ?>">
            </div>

            <!-- Deskripsi Kuliner -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <h3 class="fw-bold text-primary-color mb-4 font-serif"><i class="fas fa-utensils text-accent me-2"></i>Mengenai Kuliner</h3>
                <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                    <?= nl2br(htmlspecialchars($item['deskripsi'])); ?>
                </p>
            </div>
            
            <!-- Sejarah Singkat Kuliner -->
            <?php if (!empty($item['sejarah'])): ?>
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                    <h3 class="fw-bold text-primary-color mb-4 font-serif"><i class="fas fa-history text-accent me-2"></i>Sejarah Singkat</h3>
                    <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                        <?= nl2br(htmlspecialchars($item['sejarah'])); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Kolom Kanan: Detail Informasi (Sticky) -->
        <div class="col-lg-4">
            <div class="position-sticky" style="top: 100px;">
                <div class="detail-info-card">
                    <h5 class="fw-bold text-primary-color mb-4 font-serif border-bottom pb-2">Informasi Kuliner</h5>
                    <div class="d-flex flex-column gap-3">
                        <div class="detail-info-item">
                            <h6>Estimasi Harga</h6>
                            <p class="text-accent fw-bold" style="font-size: 1.25rem;"><?= formatHarga($item['harga']); ?></p>
                        </div>
                        <div class="detail-info-item">
                            <h6>Lokasi Penyajian</h6>
                            <p><i class="fas fa-location-dot me-2 text-accent"></i><?= htmlspecialchars($item['lokasi']); ?></p>
                        </div>
                        <div class="detail-info-item">
                            <h6>Jam Operasional</h6>
                            <p><i class="fas fa-clock me-2 text-accent"></i><?= formatJam($item['jam_operasional']); ?> <span class="small text-muted">WITA</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../component/footer.php'; ?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
