<?php
$page = "wisata";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danau Biru Kolaka Utara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

 <div class="container py-5">

        <!-- Judul -->
        <div class="text-center mb-5">

            <h1 class="detail-title">
                Danau Biru Kolaka Utara
            </h1>

            <p class="detail-desc">
                Danau unik yang hanya berjarak beberapa meter dari laut
                dengan air berwarna biru pekat yang menyegarkan,
                dikelilingi tebing karang yang eksotis.
            </p>

        </div>

        <!-- Gambar Utama -->
        <div class="text-center mb-5">

            <img src="../img/danau-biru.jpg"
                 class="img-fluid rounded-4 detail-hero"
                 alt="Danau Biru">

        </div>

        <!-- Informasi Wisata -->
        <h5 class="fw-bold mb-3">
            Informasi Wisata
        </h5>

        <div class="info-card mb-5">

            <div class="row text-center">

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Jenis Wisata
                    </h6>

                    <p class="fw-semibold">
                        Danau
                    </p>

                </div>

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Alamat
                    </h6>

                    <p class="fw-semibold">
                        <i class="fas fa-location-dot"></i>
                        Kecamatan Wawo
                    </p>

                </div>

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Tarif/Harga
                    </h6>

                    <p class="fw-semibold mb-1">
                        15.000 - 25.000 rb
                    </p>

                    <p class="fw-semibold">
                        Per Orang
                    </p>

                    <small>
                        Tarif bisa berubah kapan saja
                    </small>

                </div>

            </div>

        </div>

        <!-- Gallery -->
        <h5 class="fw-bold mb-3">
            Foto/Gallery
        </h5>

        <div class="row g-4">

            <div class="col-md-4">
                <img src="../img/danau1.jpg"
                     class="img-fluid gallery-img"
                     alt="">
            </div>

            <div class="col-md-4">
                <img src="../img/danau2.jpg"
                     class="img-fluid gallery-img"
                     alt="">
            </div>

            <div class="col-md-4">
                <img src="../img/danau3.jpg"
                     class="img-fluid gallery-img"
                     alt="">
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>