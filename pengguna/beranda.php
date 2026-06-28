<?php
$page = "beranda";
include __DIR__ . '/../config/koneksi.php';

// Query untuk 3 destinasi dengan rating tertinggi
$queryTopWisata = mysqli_query($conn, "
    SELECT w.*, 
           COALESCE(AVG(u.rating), 0) AS avg_rating,
           COUNT(u.id) AS total_reviews
    FROM wisata w
    LEFT JOIN ulasan u ON u.wisata_id = w.id
    GROUP BY w.id
    ORDER BY avg_rating DESC, w.id DESC
    LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Kaloka Utara</title>
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

<!-- Banner -->
<div class="container-fluid banner" id="beranda">
    <div class="container text-center">
        <span class="badge rounded-pill px-4 py-2 mb-3 bg-transparent">
            <i class="fas fa-sparkles text-accent me-2"></i>JELAJAH SURGA TERSEMBUNYI
        </span>
        <h1 class="display-3 fw-bold mt-2">Pesona Kaloka Utara</h1>
        <p class="lead text-white-50 max-width-600 mx-auto mt-3" style="font-size: 1.2rem;">
            Temukan harmoni alam yang megah, kebudayaan yang luhur, dan keramahan yang menanti Anda di setiap sudut Kolaka Utara.
        </p>
        <!-- Tombol dalam Banner -->
        <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
            <a href="wisata.php" class="btn btn-accent-custom px-4 py-3">
                Mulai Petualangan
                <i class="fas fa-compass ms-2"></i>
            </a>
            <a href="budaya.php" class="btn btn-primary-custom px-4 py-3">
                Mengenal Budaya
                <i class="fas fa-book-open ms-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Pengalaman Menanti Anda -->
<div class="container py-5 mt-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5 text-primary-color">Pengalaman Menanti Anda</h2>
        <p class="text-muted">Ragam petualangan terbaik yang dirancang khusus untuk perjalanan Anda</p>
        <div class="garis-aesthetic mx-auto"></div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card fitur-card h-100 border-0">
                <div class="card-body p-0">
                    <div class="fitur-icon-box">
                        <i class="fas fa-camera-retro"></i>
                    </div>
                    <h5 class="fw-bold fs-4">Destinasi Alam</h5>
                    <p>
                        Mulai dari Danau Biru yang misterius hingga air terjun tersembunyi, alam Kolut siap memanjakan mata Anda dengan lanskap menakjawankan.
                    </p>
                    <a href="wisata.php" class="fitur-link">
                        Jelajahi Wisata <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card fitur-card h-100 border-0">
                <div class="card-body p-0">
                    <div class="fitur-icon-box">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h5 class="fw-bold fs-4">Warisan Budaya</h5>
                    <p>
                        Saksikan keindahan Tarian Lulo dan sisa-sisa peninggalan kebesaran sejarah serta budaya Tolaki-Mekongga yang sarat makna.
                    </p>
                    <a href="budaya.php" class="fitur-link">
                        Pelajari Budaya <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card fitur-card h-100 border-0">
                <div class="card-body p-0">
                    <div class="fitur-icon-box">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h5 class="fw-bold fs-4">Kuliner Khas</h5>
                    <p>
                        Cicipi lezatnya Sinonggi yang autentik dan menghangatkan suasana, dipadu dengan hidangan laut segar khas pesisir Teluk Bone.
                    </p>
                    <a href="kuliner.php" class="fitur-link">
                        Lihat Kuliner <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Destinasi Populer -->
<div class="container py-5 mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold display-5 text-primary-color mb-1">Destinasi Populer</h2>
            <p class="text-muted mb-0">
                Beberapa lokasi wisata paling diminati yang wajib Anda kunjungi di Kolaka Utara.
            </p>
        </div>
        <a href="wisata.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
            Lihat semua <i class="fas fa-arrow-right ms-1" style="font-size: 0.8rem;"></i>
        </a>
    </div>

    <div class="row g-4">
        <?php if(mysqli_num_rows($queryTopWisata) > 0): ?>
            <?php while($wisata = mysqli_fetch_assoc($queryTopWisata)): ?>
                <div class="col-md-4">
                    <div class="card wisata-card-modern">
                        <div class="wisata-img-wrapper">
                            <?php 
                            $foto_path = "../image/uploads/wisata/" . $wisata['foto'];
                            $foto_url = (!empty($wisata['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../image/default-wisata.png';
                            ?>
                            <img src="<?= $foto_url ?>" alt="<?= htmlspecialchars($wisata['nama']) ?>" style="height: 240px; object-fit: cover;">
                            <span class="badge-harga">Rp <?= number_format($wisata['harga'], 0, ',', '.') ?></span>
                            <span class="badge-tag"><?= htmlspecialchars($wisata['jenis_wisata']) ?></span>
                        </div>
                        <div class="wisata-info-body d-flex flex-column">
                            <div class="wisata-meta">
                                <i class="fas fa-location-dot"></i>
                                <span><?= htmlspecialchars(substr($wisata['alamat'], 0, 30)) ?><?= strlen($wisata['alamat']) > 30 ? '...' : '' ?></span>
                            </div>
                            <h5 class="mb-2">
                                <a href="detail-wisata/detail-wisata.php?id=<?= $wisata['id'] ?>" class="wisata-title-link">
                                    <?= htmlspecialchars($wisata['nama']) ?>
                                </a>
                            </h5>
                            <p class="desc mb-3">
                                <?= htmlspecialchars(substr($wisata['deskripsi'], 0, 100)) ?>...
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-light">
                                <div class="rating-box">
                                    <small class="text-warning">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <?php if($i <= round($wisata['avg_rating'])): ?>
                                                <i class="fa-solid fa-star"></i>
                                            <?php else: ?>
                                                <i class="fa-regular fa-star text-muted"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </small>
                                    <span class="small text-muted ms-1" style="font-size: 0.8rem;">(<?= (int)$wisata['total_reviews'] ?>)</span>
                                </div>
                                <a href="detail-wisata/detail-wisata.php?id=<?= $wisata['id'] ?>" class="btn btn-sm btn-primary-custom py-1 px-3" style="font-size: 0.85rem;">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary border-0 rounded-4 p-4 text-center">
                    <i class="fas fa-info-circle fa-2x mb-2 text-muted"></i>
                    <p class="mb-0">Belum ada data wisata tersedia.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../component/footer.php'; ?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
