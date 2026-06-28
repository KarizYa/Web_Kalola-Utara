<?php
$page = "wisata";
include __DIR__ . '/../config/koneksi.php';

// Fetch wisata with average rating and total reviews
$queryWisata = mysqli_query(
    $conn,
    "SELECT w.*, 
            COALESCE(AVG(u.rating), 0) AS avg_rating,
            COUNT(u.id) AS total_reviews
     FROM wisata w
     LEFT JOIN ulasan u ON u.wisata_id = w.id
     GROUP BY w.id
     ORDER BY w.id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi Wisata Kaloka Utara</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<!-- Header -->
<section class="hero-page text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Destinasi Wisata</h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
        <p class="lead text-white-50">
            Jelajahi keajaiban alam dan tempat-tempat ikonik di Kolaka Utara yang menawarkan petualangan visual dan ketenangan batin.
        </p>
    </div>
</section>

<!-- Daftar Wisata -->
<section class="py-5">
    <div class="container py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-primary-color h4 mb-1">Daftar Destinasi</h2>
                <p class="text-muted small mb-0">Temukan keindahan alam tersembunyi Kolaka Utara</p>
            </div>
            <div>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold">
                    Total: <?= mysqli_num_rows($queryWisata) ?> Lokasi
                </span>
            </div>
        </div>

        <div class="row g-4">
            <?php if(mysqli_num_rows($queryWisata) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($queryWisata)): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card wisata-card-modern">
                            <div class="wisata-img-wrapper">
                                <?php 
                                $foto_path = "../image/uploads/wisata/" . $row['foto'];
                                $foto_url = (!empty($row['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../image/default-wisata.png';
                                ?>
                                <img src="<?= $foto_url; ?>"
                                     class="img-fluid"
                                     alt="<?= htmlspecialchars($row['nama']); ?>"
                                     style="height: 240px; width: 100%; object-fit: cover;">
                                <span class="badge-harga">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
                                <span class="badge-tag"><?= htmlspecialchars($row['jenis_wisata']) ?></span>
                            </div>
                            <div class="wisata-info-body d-flex flex-column">
                                <div class="wisata-meta mb-2">
                                    <i class="fas fa-location-dot me-1 text-accent"></i>
                                    <span class="text-truncate" style="max-width: 100%;"><?= htmlspecialchars($row['alamat']); ?></span>
                                </div>
                                <h5 class="mb-2">
                                    <a href="detail-wisata/detail-wisata.php?id=<?= $row['id'] ?>" class="wisata-title-link">
                                        <?= htmlspecialchars($row['nama']); ?>
                                    </a>
                                </h5>
                                <p class="desc text-muted mb-4">
                                    <?= htmlspecialchars(substr($row['deskripsi'], 0, 120)); ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light">
                                    <div class="rating-box">
                                        <small class="text-warning">
                                            <?php for($i=1; $i<=5; $i++): ?>
                                                <?php if($i <= round($row['avg_rating'])): ?>
                                                    <i class="fa-solid fa-star"></i>
                                                <?php else: ?>
                                                    <i class="fa-regular fa-star text-muted"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </small>
                                        <span class="small text-muted ms-1">(<?= (int)$row['total_reviews'] ?>)</span>
                                    </div>
                                    <a href="detail-wisata/detail-wisata.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary-custom py-2 px-3" style="font-size: 0.85rem;">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-secondary border-0 rounded-4 p-5 text-center">
                        <i class="fas fa-compass fa-3x mb-3 text-muted"></i>
                        <h5 class="fw-bold">Belum Ada Data Destinasi</h5>
                        <p class="text-muted mb-0">Silakan tambahkan destinasi baru dari halaman admin.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php include __DIR__ . '/../component/footer.php'; ?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
