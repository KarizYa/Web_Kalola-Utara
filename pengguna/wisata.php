<?php
$page = "wisata";
include __DIR__ . '/../config/koneksi.php';

$queryWisata = mysqli_query(
    $conn,
    "SELECT * FROM wisata ORDER BY id DESC"
);
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
                <?php if(mysqli_num_rows($queryWisata) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($queryWisata)): ?>
                        <div class="col-lg-6">
                            <div class="wisata-card">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <img src="../image/uploads/wisata/<?= $row['foto']; ?>"
                                            class="wisata-img"
                                            alt="<?= htmlspecialchars($row['nama']); ?>">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body-custom">
                                            <div class="lokasi">
                                                <i class="fas fa-location-dot"></i>
                                                <?= htmlspecialchars($row['alamat']); ?>
                                            </div>
                                            <div class="judul-wisata mt-2">
                                                <?= htmlspecialchars($row['nama']); ?>
                                            </div>
                                            <p class="deskripsi mt-2">
                                                <?= nl2br(htmlspecialchars(substr($row['deskripsi'], 0, 140))); ?>
                                                <?= strlen($row['deskripsi']) > 140 ? '...' : ''; ?>
                                            </p>
                                            <a href="detail-wisata/detail-wisata.php?id=<?= $row['id'] ?>" class="detail-link">
                                                <i class="fa-regular fa-circle-info"></i>
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada data wisata. Silakan tambahkan dari halaman admin.</div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>



