<?php
$page = "kuliner";
include __DIR__ . '/../config/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM kuliner ORDER BY id DESC");
$kuliner = [];
while ($row = mysqli_fetch_assoc($query)) {
    $kuliner[] = $row;
}
function formatJam($time) {
    return $time ? date('H:i', strtotime($time)) : '-';
}
function formatHarga($harga) {
    return 'Rp ' . number_format((int)$harga, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner Khas Kolaka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<section class="hero-page text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Kuliner Tradisional</h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
        <p class="lead text-white-50">
            Temukan hidangan autentik dengan cita rasa lokal khas Kolaka Utara yang disajikan dari pegunungan hingga pesisir pantai.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-primary-color h4 mb-1">Daftar Kuliner</h2>
                <p class="text-muted small mb-0">Cita rasa tradisional yang menggugah selera</p>
            </div>
            <div>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold">
                    Total: <?= count($kuliner) ?> Menu
                </span>
            </div>
        </div>

        <?php if(empty($kuliner)): ?>
            <div class="alert alert-secondary border-0 rounded-4 p-5 text-center">
                <i class="fas fa-utensils fa-3x mb-3 text-muted"></i>
                <h5 class="fw-bold">Belum Ada Data Kuliner</h5>
                <p class="text-muted mb-0">Silakan kembali lagi nanti untuk melihat daftar kuliner khas kami.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($kuliner as $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-kuliner-modern h-100 d-flex flex-column">
                            <div class="kuliner-img-wrapper">
                                <?php 
                                $foto_path = "../image/uploads/kuliner/" . $item['foto'];
                                $has_foto = (!empty($item['foto']) && file_exists(__DIR__ . '/' . $foto_path));
                                $foto_url = $has_foto ? $foto_path : '../image/default-kuliner.png';
                                ?>
                                <img src="<?= $foto_url ?>" alt="<?= htmlspecialchars($item['nama']) ?>">
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold text-primary-color mb-2"><?= htmlspecialchars($item['nama']) ?></h5>
                                <p class="text-muted small mb-3"><?= htmlspecialchars(substr($item['deskripsi'], 0, 120)); ?>...</p>
                                
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="badge-kuliner-pill"><i class="fa-solid fa-map-marker-alt me-1 text-accent"></i> <?= htmlspecialchars($item['lokasi']) ?></span>
                                    <span class="badge-kuliner-pill"><i class="fa-solid fa-clock me-1 text-accent"></i> <?= formatJam($item['jam_operasional']) ?></span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light">
                                    <span class="fw-bold text-primary-color" style="font-size: 1.1rem;"><?= formatHarga($item['harga']) ?></span>
                                    <a href="detail-kuliner/detail-kuliner.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-primary-custom py-2 px-3" style="font-size: 0.85rem;">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../component/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
