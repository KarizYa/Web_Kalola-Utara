<?php
$page = "beranda";
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

            <button class="btn btn-dark rounded-pill px-4 py-2">
                Mulai Petualangan
                <i class="fas fa-compass ms-2"></i>
            </button>

            <button class="btn btn-dark rounded-pill px-4 py-2">
                Mengenal Budaya
                <i class="fas fa-book-open ms-2"></i>
            </button>

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

                    <a href="#" class="text-dark text-decoration-none fw-semibold">
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

                    <a href="#" class="text-dark text-decoration-none fw-semibold">
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

        <a href="#" class="text-dark text-decoration-none fw-bold">
            Lihat semua >
        </a>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="/project bootstrap/img/danau.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h6 class="fw-bold">Danau Biru Kolaka Utara</h6>
                    <p class="small text-muted">
                        Danau unik dengan warna biru jernih yang menjadi daya tarik wisata.
                    </p>

                    <a href="#" class="text-dark text-decoration-none">
                        Selengkapnya >
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="/project bootstrap/img/pantai.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h6 class="fw-bold">Pantai Berova</h6>
                    <p class="small text-muted">
                        Pantai pesisir dengan panorama laut yang indah.
                    </p>

                    <a href="#" class="text-dark text-decoration-none">
                        Selengkapnya >
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="/project bootstrap/img/pulau.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h6 class="fw-bold">Pulau Bintang</h6>
                    <p class="small text-muted">
                        Pulau eksotis dengan pasir putih dan laut biru.
                    </p>

                    <a href="#" class="text-dark text-decoration-none">
                        Selengkapnya >
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
