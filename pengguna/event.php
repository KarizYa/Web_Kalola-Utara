<?php
include __DIR__ . '/../config/koneksi.php';

$queryEvent = mysqli_query($conn, "SELECT * FROM informasi WHERE status='Publish' AND jenis='Event' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Kolaka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<section class="hero-page text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Event & Kegiatan</h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
        <p class="lead text-white-50">
            Temukan berbagai event seru, festival budaya, dan kegiatan menarik yang berlangsung di Kolaka Utara.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-primary-color h4 mb-1">Daftar Event</h2>
                <p class="text-muted small mb-0">Kegiatan dan festival terjadwal di Kolaka Utara</p>
            </div>
            <div>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold">
                    Total: <?= mysqli_num_rows($queryEvent) ?> Event
                </span>
            </div>
        </div>

        <div class="row g-4">
            <?php if(mysqli_num_rows($queryEvent) > 0): ?>
                <?php while($item = mysqli_fetch_assoc($queryEvent)): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card wisata-card-modern h-100 d-flex flex-column">
                            <div class="wisata-img-wrapper">
                                <?php 
                                $foto_path = "../image/uploads/informasi/" . $item['foto'];
                                $foto_url = (!empty($item['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../image/default-berita.png';
                                ?>
                                <img src="<?= $foto_url; ?>" class="img-fluid" alt="<?= htmlspecialchars($item['judul']); ?>" style="height: 220px; width: 100%; object-fit: cover;">
                                <span class="badge-tag bg-warning text-dark">
                                    Event
                                </span>
                            </div>
                            <div class="wisata-info-body d-flex flex-column flex-grow-1">
                                <h5 class="mb-2">
                                    <a href="detail-berita/detail-berita.php?id=<?= $item['id']; ?>" class="wisata-title-link">
                                        <?= htmlspecialchars($item['judul']); ?>
                                    </a>
                                </h5>
                                <p class="desc text-muted small mb-3">
                                    <?= htmlspecialchars(substr($item['ringkasan'], 0, 120)); ?>...
                                </p>
                                
                                <div class="mb-3 p-2 bg-light rounded-3 text-muted" style="font-size: 0.8rem;">
                                    <p class="mb-1"><i class="fas fa-calendar-days me-2 text-accent"></i><?= htmlspecialchars($item['tanggal_event']); ?> (<?= htmlspecialchars($item['waktu_event']); ?>)</p>
                                    <p class="mb-0"><i class="fas fa-location-dot me-2 text-accent"></i><?= htmlspecialchars($item['lokasi']); ?></p>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light">
                                    <div class="d-flex flex-column gap-1">
                                        <span class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-clock me-1"></i> <?= date('d M Y', strtotime($item['created_at'])); ?></span>
                                        <?php if(!empty($item['penulis'])): ?>
                                        <span class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-user me-1"></i> <?= htmlspecialchars($item['penulis']); ?></span>
                                        <?php endif; ?>
                                    </div>
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
                    <div class="alert alert-secondary border-0 rounded-4 p-5 text-center">
                        <i class="fas fa-calendar-xmark fa-3x mb-3 text-muted"></i>
                        <h5 class="fw-bold">Belum Ada Event</h5>
                        <p class="text-muted mb-0">Belum ada event yang dipublish. Pantau terus untuk update terbaru!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../component/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
