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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="pengguna.css">
    <style>
        .kuliner-hero { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); color: #fff; }
        .kuliner-hero .informasi-line { width: 80px; height: 4px; background: #ffc107; margin: 1.5rem auto; }
        .card-kuliner:hover { transform: translateY(-5px); transition: transform .25s ease; }
        .card-kuliner .card-img-top { min-height: 200px; object-fit: cover; }
        .badge-kuliner { background: rgba(0,0,0,.7); }
    </style>
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<section class="kuliner-hero py-5">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Rasakan Kuliner Autentik Kolaka Utara</h1>
        <div class="informasi-line mx-auto"></div>
        <p class="lead text-white-75 mb-4">
            Temukan hidangan tradisional dengan cita rasa lokal, disajikan dari desa hingga pesisir.
            Pilih kuliner favoritmu dan lihat detail lengkap tiap sajian khas daerah.
        </p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 fw-bold mb-1">Daftar Kuliner</h2>
                <p class="text-muted mb-0">Kuliner populer dan khas Kolaka Utara.</p>
            </div>
            <div>
                <span class="badge bg-warning text-dark px-3 py-2">Total: <?= count($kuliner) ?></span>
            </div>
        </div>

        <?php if(empty($kuliner)): ?>
            <div class="alert alert-secondary">Belum ada data kuliner. Silakan kembali lagi nanti.</div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($kuliner as $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-kuliner border-0 shadow-sm h-100 overflow-hidden">
                            <?php if(!empty($item['foto'])): ?>
                                <img src="../image/uploads/kuliner/<?= htmlspecialchars($item['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['nama']) ?>">
                            <?php else: ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">Tanpa Foto</div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($item['nama']) ?></h5>
                                <p class="text-muted mb-3"><?= htmlspecialchars(substr($item['deskripsi'], 0, 110)); ?><?= strlen($item['deskripsi']) > 110 ? '...' : '' ?></p>
                                <div class="mb-3">
                                    <span class="badge badge-kuliner text-white me-1"><i class="fa-solid fa-map-marker-alt me-1"></i> <?= htmlspecialchars($item['lokasi']) ?></span>
                                    <span class="badge badge-kuliner text-white"><i class="fa-solid fa-clock me-1"></i> <?= formatJam($item['jam_operasional']) ?></span>
                                </div>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-warning fw-semibold"><?= formatHarga($item['harga']) ?></span>
                                        <a href="detail-kuliner/detail-kuliner.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-dark">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
