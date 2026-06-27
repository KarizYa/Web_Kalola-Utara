<?php

include __DIR__ . '/../config/koneksi.php';

$queryBerita = mysqli_query($conn, "SELECT * FROM informasi WHERE status='Publish' ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita dan Event Kolaka Utara</title>
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
                Berita dan Event
            </h1>

            <p class="budaya-desc">
                Informasi terbaru dan kegiatan seru yang berlangsung di Kolaka Utara.
            </p>

        </div>
    </section>

    <!-- Konten Berita -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">
                <?php if(mysqli_num_rows($queryBerita) > 0): ?>
                    <?php while($item = mysqli_fetch_assoc($queryBerita)): ?>
                        <div class="col-lg-6">
                            <div class="budaya-card">
                                <img src="../image/uploads/informasi/<?= htmlspecialchars($item['foto']); ?>" class="budaya-img" alt="<?= htmlspecialchars($item['judul']); ?>">
                                <div class="budaya-content">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h4 class="budaya-card-title mb-0">
                                            <?= htmlspecialchars($item['judul']); ?>
                                        </h4>
                                        <span class="badge bg-<?= $item['jenis'] === 'Event' ? 'primary' : 'info'; ?> text-white">
                                            <?= htmlspecialchars($item['jenis']); ?>
                                        </span>
                                    </div>
                                    <p class="budaya-card-desc">
                                        <?= nl2br(htmlspecialchars($item['ringkasan'])); ?>
                                    </p>
                                    <?php if($item['jenis'] === 'Event'): ?>
                                        <p class="mb-2"><i class="fas fa-location-dot me-2"></i><?= htmlspecialchars($item['lokasi']); ?></p>
                                        <p class="mb-2"><i class="fas fa-calendar-days me-2"></i><?= htmlspecialchars($item['tanggal_event']); ?> <?= htmlspecialchars($item['waktu_event']); ?></p>
                                    <?php endif; ?>
                                    <a href="detail-berita/detail-berita.php?id=<?= $item['id']; ?>" class="budaya-link">
                                        <i class="fa-regular fa-circle-info"></i>
                                        Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada berita atau event yang dipublish.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
