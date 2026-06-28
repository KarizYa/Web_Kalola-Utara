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
    <title><?= htmlspecialchars($data['nama']); ?> - Detail Budaya</title>
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
                <li class="breadcrumb-item"><a href="../budaya.php" class="text-decoration-none text-muted">Budaya</a></li>
                <li class="breadcrumb-item active text-primary-color fw-semibold" aria-current="page"><?= htmlspecialchars($data['nama']); ?></li>
            </ol>
        </nav>
        <a href="../budaya.php" class="btn btn-outline-dark rounded-pill px-3 py-1 btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Judul & Deskripsi -->
    <div class="text-center mb-5">
        <span class="badge bg-category px-3 py-2 mb-2">WARISAN SEJARAH</span>
        <h1 class="display-4 fw-bold text-primary-color mb-3">
            <?= htmlspecialchars($data['nama']); ?>
        </h1>
        <div class="garis-aesthetic mx-auto"></div>
    </div>

    <div class="row g-5 justify-content-center">
        <div class="col-lg-10">
            
            <!-- Foto Utama Sejarah -->
            <div class="detail-hero-wrapper mb-5">
                <?php 
                $foto_path = "../../image/uploads/budaya/" . $data['foto'];
                $foto_url = (!empty($data['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../../image/default-budaya.png';
                ?>
                <img src="<?= $foto_url; ?>"
                     class="img-fluid w-100"
                     alt="<?= htmlspecialchars($data['nama']); ?>">
            </div>

            <!-- Sejarah Budaya -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <h3 class="fw-bold text-primary-color mb-4 font-serif"><i class="fas fa-scroll text-accent me-2"></i>Sejarah & Tradisi</h3>
                <p class="text-muted" style="line-height: 1.9; text-align: justify; font-size: 1.05rem;">
                    <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>
                </p>
            </div>

            <!-- Catatan Budaya -->
            <?php if(!empty($data['catatan'])): ?>
                <div class="blockquote-custom mb-5">
                    <h6 class="fw-bold text-primary-color mb-2"><i class="fas fa-info-circle text-secondary-color me-2"></i>Catatan Tambahan:</h6>
                    <p class="mb-0 text-muted" style="line-height: 1.7; font-style: italic;">
                        <?= nl2br(htmlspecialchars($data['catatan'])); ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Galeri Foto Budaya -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <h3 class="fw-bold text-primary-color mb-4 font-serif"><i class="fas fa-images text-accent me-2"></i>Galeri Budaya</h3>
                <div class="row g-4">
                    <?php if(mysqli_num_rows($gallery) > 0): ?>
                        <?php while($gambar = mysqli_fetch_assoc($gallery)): ?>
                            <div class="col-md-4 col-6">
                                <img src="../../image/galeri/budaya/<?= htmlspecialchars($gambar['foto']); ?>" 
                                     alt="Galeri <?= htmlspecialchars($data['nama']); ?>" 
                                     class="img-fluid gallery-grid-img">
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-4">
                            <i class="far fa-images fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada foto galeri untuk budaya ini.</p>
                        </div>
                    <?php endif; ?>
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
