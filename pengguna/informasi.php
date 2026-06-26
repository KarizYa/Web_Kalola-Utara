<?php

$informasi = [
    [
        'icon' => 'fa-map',
        'judul' => 'Ibu Kota Lasusua',
        'deskripsi' => 'Pusat pemerintahan dan perekonomian yang terus berkembang.'
    ],
    [
        'icon' => 'fa-users',
        'judul' => 'Populasi',
        'deskripsi' => 'Mayoritas dihuni oleh suku Tolaki dan Mekongga yang ramah.'
    ],
    [
        'icon' => 'fa-anchor',
        'judul' => 'Potensi Maritim',
        'deskripsi' => 'Berada di pesisir Teluk Bone dengan hasil laut berlimpah.'
    ],
    [
        'icon' => 'fa-mountain-sun',
        'judul' => 'Geografis Unik',
        'deskripsi' => 'Kombinasi pantai, dataran rendah, hingga pegunungan hijau.'
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kaloka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

    <!-- Header -->
    <section class="informasi-header">

        <div class="container text-center">

            <h1 class="informasi-title">
                Informasi Seputar Kolaka Utara
            </h1>

            <div class="informasi-line"></div>

            <p class="informasi-desc">
                Kabupaten yang menyimpan sejuta pesona, berpadu harmonis antara
                alam bahari dan pegunungan, serta berhiasakan kearifan lokal yang
                terjaga lestari.
            </p>

        </div>

    </section>

    <!-- Informasi -->
    <section class="pb-5">

        <div class="container">

            <div class="row g-4 justify-content-center">

                <?php foreach($informasi as $item): ?>

                    <div class="col-lg-3 col-md-6">

                        <div class="informasi-card">

                            <div class="informasi-icon">

                                <i class="fa-solid <?= $item['icon']; ?>"></i>

                            </div>

                            <h5 class="informasi-card-title">
                                <?= $item['judul']; ?>
                            </h5>

                            <p class="informasi-card-desc">
                                <?= $item['deskripsi']; ?>
                            </p>

                            <a href="#"
                               class="informasi-link">

                                Selengkapnya >

                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </section>
<!-- Destinasi Populer -->
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Berita dan Event</h3>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>