<?php
$page = "budaya";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budaya Kaloka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

    <!-- Header -->
    <section class="budaya-header py-5">
        <div class="container text-center">

            <h1 class="budaya-title">
                Kekayaan Budaya
            </h1>

            <p class="budaya-desc">
                Pelajari sejarah panjang, tradisi luhur, dan kearifan lokal yang
                membentuk identitas masyarakat Kolaka Utara dari masa ke masa.
            </p>

        </div>
    </section>

    <!-- Konten Budaya -->
    <section class="pb-5">
        <div class="container">

            <div class="row g-4">

                <!-- Tari Lulo -->
                <div class="col-lg-6">

                    <div class="budaya-card">

                        <img src="img/tari-lulo.jpg"
                             class="budaya-img"
                             alt="Tari Lulo">

                        <div class="budaya-content">

                            <h4 class="budaya-card-title">
                                Tari Lulo
                            </h4>

                            <p class="budaya-card-desc">
                                Tari pergaulan tradisional masyarakat suku Tolaki
                                di Kolaka Utara yang melambangkan persatuan dan
                                kebersamaan antar sesama manusia.
                            </p>

                            <a href="detail-budaya/detail-budaya.php?id=lulo"
                            class="budaya-link">
                                <i class="fa-regular fa-circle-info"></i>
                                Jelajahi Kisahnya
                            </a>

                        </div>

                    </div>

                </div>

                <!-- Rumah Adat Mekongga -->
                <div class="col-lg-6">

                    <div class="budaya-card">

                        <img src="img/rumah-adat.jpg"
                             class="budaya-img"
                             alt="Rumah Adat Mekongga">

                        <div class="budaya-content">

                            <h4 class="budaya-card-title">
                                Rumah Adat Mekongga
                            </h4>

                            <p class="budaya-card-desc">
                                Arsitektur khas peninggalan Kerajaan Mekongga
                                dengan bentuk panggung dari kayu ulin yang
                                melambangkan status sosial dan kearifan lokal
                                dalam membangun rumah yang tahan gempa.
                            </p>

                            <a href="detail-budaya/detail-budaya.php?id=rumah-adat"
                            class="budaya-link">
                                <i class="fa-regular fa-circle-info"></i>
                                Jelajahi Kisahnya
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>