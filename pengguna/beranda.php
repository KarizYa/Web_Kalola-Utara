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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="pengguna.css">
</head>
<body>
<?php include __DIR__ . '/../component/navbar.php'; ?>

<!-- Banner -->
<div class="container-fluid banner" id="beranda">
    <div class="container text-center">
        <span class="badge bg-dark rounded-pill px-3 py-2">
            JELAJAH SURGA TERSEMBUNYI
        </span>

        <h1 class="fw-bold mt-3">Pesona Kaloka Utara</h1>
    </div>
</div>

<!-- Tombol -->
<div class="container-fluid py-4">
    <div class="container text-center">
        <div class="d-flex justify-content-center gap-5 flex-wrap">

            <a href="wisata.php" class="btn btn-dark rounded-pill px-4 py-2">
                Mulai Petualangan
                <i class="fas fa-compass ms-2"></i>
            </a>

            <a href="budaya.php" class="btn btn-dark rounded-pill px-4 py-2">
                Mengenal Budaya
                <i class="fas fa-book-open ms-2"></i>
            </a>

        </div>
    </div>
</div>

<!-- Pengalaman Menanti Anda -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Pengalaman Menanti Anda</h2>
        <div class="garis mx-auto"></div>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card fitur-card h-100 border-0">
                <div class="card-body">
                    <i class="fas fa-camera-retro fa-2x mb-3"></i>
                    <h5 class="fw-bold">Destinasi Alam</h5>
                    <p>
                        Mulai dari Danau Biru yang misterius hingga air terjun tersembunyi,
                        alam Kolut siap memanjakan mata Anda.
                    </p>

                    <a href="wisata.php" class="text-dark text-decoration-none fw-semibold">
                        Jelajahi Wisata >
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card fitur-card h-100 border-0">
                <div class="card-body">
                    <i class="far fa-clone fa-2x mb-3"></i>
                    <h5 class="fw-bold">Warisan Budaya</h5>
                    <p>
                        Saksikan keindahan Tarian Lulo dan sisa-sisa peninggalan
                        kebesaran budaya Tolaki-Mekongga.
                    </p>

                    <a href="budaya.php" class="text-dark text-decoration-none fw-semibold">
                        Pelajari Budaya >
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card fitur-card h-100 border-0">
                <div class="card-body">
                    <i class="fas fa-utensils fa-2x mb-3"></i>
                    <h5 class="fw-bold">Kuliner Khas</h5>
                    <p>
                        Cicipi lezatnya Sinonggi yang menghangatkan suasana bersama
                        hidangan laut pesisir.
                    </p>

                    <a href="kuliner.php" class="text-dark text-decoration-none fw-semibold">
                        Lihat Kuliner >
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Destinasi Populer -->
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Destinasi Populer</h3>
            <p class="text-muted mb-0">
                Beberapa lokasi wisata paling diminati yang wajib Anda kunjungi.
            </p>
        </div>

        <a href="wisata.php" class="text-dark text-decoration-none fw-bold">
            Lihat semua >
        </a>
    </div>

    <div class="row g-4">

        <?php if(mysqli_num_rows($queryTopWisata) > 0): ?>
            <?php while($wisata = mysqli_fetch_assoc($queryTopWisata)): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="../image/uploads/wisata/<?= htmlspecialchars($wisata['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($wisata['nama']) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold"><?= htmlspecialchars($wisata['nama']) ?></h6>
                            <p class="small text-muted"><?= htmlspecialchars(substr($wisata['deskripsi'], 0, 100)) ?>...</p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <?php if($i <= round($wisata['avg_rating'])): ?>
                                            <i class="fa-solid fa-star"></i>
                                        <?php else: ?>
                                            <i class="fa-regular fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </small>
                                <small class="text-muted ms-1">(<?= (int)$wisata['total_reviews'] ?> ulasan)</small>
                            </div>
                            <div class="mt-auto">
                                <a href="detail-wisata/detail-wisata.php?id=<?= $wisata['id'] ?>" class="text-dark text-decoration-none fw-semibold">
                                    Selengkapnya >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary">Belum ada data wisata tersedia.</div>
            </div>
        <?php endif; ?>

    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
