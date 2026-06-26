<?php
$page = "wisata";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pariwisata Kaloka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<!-- Judul -->
    <section class="hero">
        <div class="container text-center">

            <h1>Destinasi Kolaka Utara</h1>

            <p>
                Jelajahi keajaiban alam dan tempat-tempat ikonik di
                Kolaka Utara yang menawarkan pengalaman visual dan
                batin tak tergantikan.
            </p>

        </div>
    </section>

    <!-- Daftar Wisata -->
    <section class="pb-5">
        <div class="container">

            <div class="row g-5">

                <!-- CARD 1 -->
                <div class="col-lg-6">
                    <div class="wisata-card">

                        <div class="row g-0">

                            <div class="col-4">
                                  <img src="/project bootstrap/img/danau-biru.jpg"
                                     class="wisata-img"
                                     alt="Danau Biru">
                            </div>

                            <div class="col-8">
                                <div class="card-body-custom">

                                    <div class="lokasi">
                                        <i class="fas fa-location-dot"></i>
                                        Kecamatan Wawo
                                    </div>

                                    <div class="judul-wisata mt-2">
                                        Danau Biru Kolaka Utara
                                    </div>

                                    <p class="deskripsi mt-2">
                                        Danau unik yang hanya berjarak beberapa
                                        meter dari laut dengan air berwarna biru
                                        pekat yang menyegarkan, dikelilingi tebing
                                        karang yang eksotis.
                                    </p>

                                    <a href="detail-wisata/danau-biru.php" class="detail-link">
                                    <i class="fa-regular fa-circle-info"></i>
                                      Lihat Detail
                                    </a>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="col-lg-6">
                    <div class="wisata-card">

                        <div class="row g-0">

                            <div class="col-4">
                                  <img src="/project bootstrap/img/pantai-berova.jpg"
                                     class="wisata-img"
                                     alt="Pantai Berova">
                            </div>

                            <div class="col-8">
                                <div class="card-body-custom">

                                    <div class="lokasi">
                                        <i class="fas fa-location-dot"></i>
                                        Kecamatan Lasusua
                                    </div>

                                    <div class="judul-wisata mt-2">
                                        Pantai Berova
                                    </div>

                                    <p class="deskripsi mt-2">
                                        Pantai berpasir putih yang indah dengan
                                        pemandangan laut lepas Teluk Bone.
                                        Tempat yang sempurna untuk menikmati
                                        matahari terbenam bersama keluarga.
                                    </p>

                                    <a href="detail-wisata/pantai-berova.php" class="detail-link">
                                        <i class="fa-regular fa-circle-info"></i>
                                        Lihat Detail
                                    </a>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="col-lg-6">
                    <div class="wisata-card">

                        <div class="row g-0">

                            <div class="col-4">
                                  <img src="/project bootstrap/img/pulau-bintang.jpg"
                                     class="wisata-img"
                                     alt="Pulau Bintang">
                            </div>

                            <div class="col-8">
                                <div class="card-body-custom">

                                    <div class="lokasi">
                                        <i class="fas fa-location-dot"></i>
                                        Kecamatan Tolala
                                    </div>

                                    <div class="judul-wisata mt-2">
                                        Pulau Bintang Kolaka Utara
                                    </div>

                                    <p class="deskripsi mt-2">
                                        Pulau Bintang menawarkan banyak
                                        keindahan panorama. Mulai dari
                                        gugusan pulau kecil, keindahan
                                        alam bawah laut, biota laut
                                        bervariasi, pasir putih serta
                                        perairan jernih.
                                    </p>

                                    <a href="detail-wisata/pulau-bintang.php    " class="detail-link">
                                        <i class="fa-regular fa-circle-info"></i>
                                        Lihat Detail
                                    </a>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- CARD 4 -->
                <div class="col-lg-6">
                    <div class="wisata-card">

                        <div class="row g-0">

                            <div class="col-4">
                                  <img src="/project bootstrap/img/mekongga.jpg"
                                     class="wisata-img"
                                     alt="Gunung Mekongga">
                            </div>

                            <div class="col-8">
                                <div class="card-body-custom">

                                    <div class="lokasi">
                                        <i class="fas fa-location-dot"></i>
                                        Kecamatan Wawo
                                    </div>

                                    <div class="judul-wisata mt-2">
                                        Gunung Mekongga Kolaka Utara
                                    </div>

                                    <p class="deskripsi mt-2">
                                        Gunung Mekongga di Kolaka Utara
                                        berada di wilayah Provinsi Sulawesi
                                        Tenggara dan merupakan kawasan
                                        pegunungan yang tertinggi di kawasan
                                        pegunungan Mekongga.
                                    </p>

                                    <a href="#" class="detail-link">
                                        <i class="fa-regular fa-circle-info"></i>
                                        Lihat Detail
                                    </a>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>



