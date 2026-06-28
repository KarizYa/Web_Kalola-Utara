<?php
include __DIR__ . '/../../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    header('Location: ../berita.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM informasi WHERE id='$id' AND status='Publish'");
$selected = mysqli_fetch_assoc($query);

if(!$selected){
    header('Location: ../berita.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selected['judul']); ?> - Detail Informasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <li class="breadcrumb-item"><a href="../informasi.php" class="text-decoration-none text-muted">Informasi</a></li>
                <li class="breadcrumb-item active text-primary-color fw-semibold" aria-current="page"><?= htmlspecialchars(substr($selected['judul'], 0, 30)); ?>...</li>
            </ol>
        </nav>
        <a href="../berita.php" class="btn btn-outline-dark rounded-pill px-3 py-1 btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Berita
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Judul & Metadata -->
            <div class="mb-4">
                <span class="badge <?= $selected['jenis'] === 'Event' ? 'badge-event-type' : 'badge-category'; ?> px-3 py-2 mb-2">
                    <?= htmlspecialchars($selected['jenis']); ?>
                </span>
                <h1 class="fw-bold text-primary-color font-serif mb-3" style="font-size: 2.5rem; line-height: 1.3;">
                    <?= htmlspecialchars($selected['judul']); ?>
                </h1>
                <div class="d-flex align-items-center gap-3 text-muted small pb-3 border-bottom flex-wrap">
                    <span><i class="far fa-calendar me-1 text-accent"></i> Diterbitkan: <?= date('d M Y', strtotime($selected['created_at'])); ?></span>
                    <?php if(!empty($selected['penulis'])): ?>
                    <span><i class="far fa-user me-1 text-accent"></i> Penulis: <?= htmlspecialchars($selected['penulis']); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Banner / Gambar Utama -->
            <div class="detail-hero-wrapper mb-4">
                <?php 
                $foto_path = "../../image/uploads/informasi/" . $selected['foto'];
                $foto_url = (!empty($selected['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../../image/default-berita.png';
                ?>
                <img src="<?= $foto_url; ?>"
                     class="img-fluid w-100"
                     alt="<?= htmlspecialchars($selected['judul']); ?>">
            </div>

            <!-- Ringkasan / Intro -->
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-4 border-secondary-color">
                <h5 class="fw-bold text-primary-color mb-2 font-serif">Ringkasan</h5>
                <p class="mb-0 text-muted" style="line-height: 1.7; font-size: 1.05rem;">
                    <?= nl2br(htmlspecialchars($selected['ringkasan'])); ?>
                </p>
            </div>

            <!-- Detail Event (Jika jenisnya Event) -->
            <?php if($selected['jenis'] === 'Event'): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: rgba(217, 160, 91, 0.08); border: 1px solid rgba(217, 160, 91, 0.15) !important;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-primary-color mb-3 font-serif"><i class="fas fa-calendar-check text-accent me-2"></i>Detail Acara / Kegiatan</h5>
                        <div class="row g-3">
                            <div class="col-md-6 d-flex align-items-start gap-2">
                                <i class="fas fa-location-dot text-accent mt-1"></i>
                                <div>
                                    <strong class="d-block text-primary-color small">Lokasi</strong>
                                    <span class="text-muted small"><?= htmlspecialchars($selected['lokasi']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-start gap-2">
                                <i class="fas fa-clock text-accent mt-1"></i>
                                <div>
                                    <strong class="d-block text-primary-color small">Waktu Pelaksanaan</strong>
                                    <span class="text-muted small"><?= htmlspecialchars($selected['tanggal_event']); ?> - <?= htmlspecialchars($selected['waktu_event']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Isi Berita / Artikel -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <div class="article-content text-muted" style="line-height: 1.9; font-size: 1.05rem; text-align: justify;">
                    <?= nl2br(htmlspecialchars($selected['isi'])); ?>
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
