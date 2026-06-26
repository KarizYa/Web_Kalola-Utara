<?php
$page = "budaya";
include __DIR__ . '/../config/koneksi.php';

$queryBudaya = mysqli_query(
    $conn,
    "SELECT * FROM budaya ORDER BY id DESC"
);
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
                <?php if(mysqli_num_rows($queryBudaya) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($queryBudaya)): ?>
                        <div class="col-lg-6">
                            <div class="budaya-card">
                                <img src="../image/uploads/budaya/<?= $row['foto']; ?>" class="budaya-img" alt="<?= htmlspecialchars($row['nama']); ?>">
                                <div class="budaya-content">
                                    <h4 class="budaya-card-title">
                                        <?= htmlspecialchars($row['nama']); ?>
                                    </h4>
                                    <p class="budaya-card-desc">
                                        <?= nl2br(htmlspecialchars(substr($row['deskripsi'], 0, 200))); ?>
                                        <?= strlen($row['deskripsi']) > 200 ? '...' : ''; ?>
                                    </p>
                                    <a href="detail-budaya/detail-budaya.php?id=<?= $row['id']; ?>" class="budaya-link">
                                        <i class="fa-regular fa-circle-info"></i>
                                        Jelajahi Kisahnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada data budaya. Silakan tambahkan dari halaman admin.</div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
