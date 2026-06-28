<?php
$informasi = [
    [
        'icon' => 'fa-map-marked-alt',
        'judul' => 'Ibu Kota Lasusua',
        'deskripsi' => 'Pusat pemerintahan dan perekonomian yang terus berkembang pesat.'
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
        'deskripsi' => 'Kombinasi pantai indah, dataran rendah, hingga pegunungan hijau.'
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<!-- Header -->
<section class="hero-page text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Informasi Kolaka Utara</h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
        <p class="lead text-white-50">
            Kabupaten yang menyimpan sejuta pesona, berpadu harmonis antara alam bahari dan pegunungan, serta berhiaskan kearifan lokal yang terjaga lestari.
        </p>
    </div>
</section>

<!-- Informasi Stats -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-4 justify-content-center">
            <?php foreach($informasi as $item): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="info-stat-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="info-stat-icon">
                                <i class="fa-solid <?= $item['icon']; ?>"></i>
                            </div>
                            <h5><?= $item['judul']; ?></h5>
                            <p><?= $item['deskripsi']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Berita dan Event -->
<div class="container py-5 mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold display-5 text-primary-color mb-1">Berita dan Event</h2>
            <p class="text-muted mb-0">Informasi terbaru dan kegiatan seru yang berlangsung di Kolaka Utara.</p>
        </div>
        <a href="berita.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
            Lihat semua <i class="fas fa-arrow-right ms-1" style="font-size: 0.8rem;"></i>
        </a>
    </div>

    <div class="row g-4">
        <?php if(mysqli_num_rows($queryBerita) > 0): ?>
            <?php while($item = mysqli_fetch_assoc($queryBerita)): ?>
                <div class="col-md-4">
                    <div class="card wisata-card-modern">
                        <div class="wisata-img-wrapper">
                            <?php 
                            $foto_path = "../image/uploads/informasi/" . $item['foto'];
                            $foto_url = (!empty($item['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../image/default-berita.png';
                            ?>
                            <img src="<?= $foto_url; ?>" class="img-fluid" alt="<?= htmlspecialchars($item['judul']); ?>" style="height: 220px; width: 100%; object-fit: cover;">
                            <span class="badge-tag <?= $item['jenis'] === 'Event' ? 'bg-warning text-dark' : 'bg-info text-white'; ?>">
                                <?= htmlspecialchars($item['jenis']); ?>
                            </span>
                        </div>
                        <div class="wisata-info-body d-flex flex-column">
                            <h5 class="mb-2">
                                <a href="detail-berita/detail-berita.php?id=<?= $item['id']; ?>" class="wisata-title-link">
                                    <?= htmlspecialchars($item['judul']); ?>
                                </a>
                            </h5>
                            <p class="desc text-muted mb-3">
                                <?= htmlspecialchars(substr($item['ringkasan'], 0, 100)); ?>...
                            </p>
                            
                            <?php if($item['jenis'] === 'Event'): ?>
                                <div class="mb-3 p-2 bg-light rounded-3" style="font-size: 0.85rem;">
                                    <p class="text-muted mb-1"><i class="fas fa-calendar-days me-2 text-accent"></i><?= htmlspecialchars($item['tanggal_event']); ?> (<?= htmlspecialchars($item['waktu_event']); ?>)</p>
                                    <p class="text-muted mb-0"><i class="fas fa-location-dot me-2 text-accent"></i><?= htmlspecialchars($item['lokasi']); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light">
                                <span class="text-muted small"><i class="far fa-clock me-1"></i> <?= date('d M Y', strtotime($item['created_at'])); ?></span>
                                <a href="detail-berita/detail-berita.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary-custom py-1 px-3" style="font-size: 0.85rem;">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-secondary border-0 rounded-4 p-4 text-center">
                    <i class="fas fa-newspaper fa-2x mb-2 text-muted"></i>
                    <p class="mb-0">Belum ada berita atau event yang dipublish.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../component/footer.php'; ?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>