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

include __DIR__ . '/../config/koneksi.php';

$queryBerita = mysqli_query($conn, "SELECT * FROM informasi WHERE status='Publish' ORDER BY created_at DESC LIMIT 3");

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

        <a href="berita.php" class="text-dark text-decoration-none fw-bold">
            Lihat semua >
        </a>
    </div>

    <div class="row g-4">
        <?php if(mysqli_num_rows($queryBerita) > 0): ?>
            <?php while($item = mysqli_fetch_assoc($queryBerita)): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="../image/uploads/informasi/<?= htmlspecialchars($item['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($item['judul']); ?>">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0"><?= htmlspecialchars($item['judul']); ?></h6>
                                <span class="badge bg-<?= $item['jenis'] === 'Event' ? 'primary' : 'info'; ?> text-white">
                                    <?= htmlspecialchars($item['jenis']); ?>
                                </span>
                            </div>
                            <p class="small text-muted">
                                <?= nl2br(htmlspecialchars($item['ringkasan'])); ?>
                            </p>
                            <?php if($item['jenis'] === 'Event'): ?>
                                <p class="small text-muted mb-2"><i class="fas fa-calendar-days me-2"></i><?= htmlspecialchars($item['tanggal_event']); ?> <?= htmlspecialchars($item['waktu_event']); ?></p>
                                <p class="small text-muted mb-2"><i class="fas fa-location-dot me-2"></i><?= htmlspecialchars($item['lokasi']); ?></p>
                            <?php endif; ?>
                            <a href="detail-berita/detail-berita.php?id=<?= $item['id']; ?>" class="text-dark text-decoration-none mt-auto">
                                Selengkapnya >
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>