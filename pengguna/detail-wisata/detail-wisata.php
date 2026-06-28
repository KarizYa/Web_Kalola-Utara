<?php
include __DIR__ . '/../../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    header('Location: ../wisata.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM wisata WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    header('Location: ../wisata.php');
    exit;
}

$gallery = mysqli_query($conn, "SELECT * FROM wisata_galeri WHERE wisata_id='$id'");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS ulasan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    wisata_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    rating TINYINT NOT NULL,
    komentar TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ulasan'])){
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar'] ?? '');
    $nama_input = trim($_POST['nama_pengunjung'] ?? '');
    if (empty($nama_input)) {
        $nama = 'Pengunjung' . substr(md5(uniqid('', true)), 0, 4);
    } else {
        $nama = mysqli_real_escape_string($conn, $nama_input);
    }
    
    $wisata_id = $id;
    mysqli_query($conn, "INSERT INTO ulasan (wisata_id, nama, rating, komentar) VALUES ('{$wisata_id}', '{$nama}', '{$rating}', '{$komentar}')");
    header("Location: ?id={$id}");
    exit;
}

$avgResult = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM ulasan WHERE wisata_id='$id'");
$avgRow = mysqli_fetch_assoc($avgResult);
$avg_rating = $avgRow && $avgRow['avg_rating'] ? round($avgRow['avg_rating'], 1) : 0;
$total_reviews = $avgRow ? (int)$avgRow['total'] : 0;
$reviews = mysqli_query($conn, "SELECT * FROM ulasan WHERE wisata_id='$id' ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama']) ?> - Detail Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

<div class="container py-5 detail-body-padding">
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="../beranda.php" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="../wisata.php" class="text-decoration-none text-muted">Wisata</a></li>
                <li class="breadcrumb-item active text-primary-color fw-semibold" aria-current="page"><?= htmlspecialchars($data['nama']); ?></li>
            </ol>
        </nav>
        <a href="../wisata.php" class="btn btn-outline-dark rounded-pill px-3 py-1 btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="text-center mb-5">
        <span class="badge bg-category text-dark px-3 py-2 mb-2">
            <?= htmlspecialchars($data['jenis_wisata']); ?>
        </span>
        <h1 class="display-4 fw-bold text-primary-color mb-3">
            <?= htmlspecialchars($data['nama']); ?>
        </h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
    </div>

    <div class="detail-hero-wrapper mb-5">
        <?php 
        $foto_path = "../../image/uploads/wisata/" . $data['foto'];
        $foto_url = (!empty($data['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../../image/default-wisata.png';
        ?>
        <img src="<?= $foto_url; ?>"
             class="img-fluid w-100"
             alt="<?= htmlspecialchars($data['nama']); ?>">
    </div>

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <h3 class="fw-bold text-primary-color mb-4 font-serif">Deskripsi Destinasi</h3>
                <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                    <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>
                </p>
            </div>

            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm mb-5">
                <h3 class="fw-bold text-primary-color mb-4 font-serif">Galeri Foto</h3>
                <div class="row g-3">
                    <?php if(mysqli_num_rows($gallery) > 0): ?>
                        <?php while($g = mysqli_fetch_assoc($gallery)): ?>
                            <div class="col-md-4 col-6">
                                <img src="../../image/galeri/wisata/<?= htmlspecialchars($g['foto']); ?>"
                                     class="img-fluid gallery-grid-img"
                                     alt="Galeri <?= htmlspecialchars($data['nama']); ?>">
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-4">
                            <i class="far fa-images fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada foto galeri untuk destinasi ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="position-sticky" style="top: 100px;">
                <div class="detail-info-card mb-4">
                    <h5 class="fw-bold text-primary-color mb-4 font-serif border-bottom pb-2">Detail Informasi</h5>
                    <div class="d-flex flex-column gap-3">
                        <div class="detail-info-item">
                            <h6>Jenis Wisata</h6>
                            <p><i class="fas fa-compass me-2 text-accent"></i><?= htmlspecialchars($data['jenis_wisata']); ?></p>
                        </div>
                        <div class="detail-info-item">
                            <h6>Alamat Lokasi</h6>
                            <p><i class="fas fa-location-dot me-2 text-accent"></i><?= htmlspecialchars($data['alamat']); ?></p>
                        </div>
                        <div class="detail-info-item">
                            <h6>Tarif Tiket Masuk</h6>
                            <p><i class="fas fa-ticket me-2 text-accent"></i>Rp <?= number_format($data['harga'], 0, ',', '.'); ?> <span class="small text-muted">/ orang</span></p>
                        </div>
                    </div>
                </div>

                <div class="reviews-summary-box">
                    <h5 class="fw-bold text-primary-color mb-4 font-serif border-bottom pb-2">Ulasan Pengunjung</h5>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="text-center bg-light p-3 rounded-4" style="min-width: 90px;">
                            <h2 class="fw-bold text-primary-color mb-0" style="font-size: 2.5rem;"><?= $avg_rating ?></h2>
                            <small class="text-muted">dari 5</small>
                        </div>
                        <div>
                            <div class="text-warning mb-1">
                                <?php for($i=1;$i<=5;$i++): ?>
                                    <?php if($i <= round($avg_rating)): ?>
                                        <i class="fa-solid fa-star"></i>
                                    <?php else: ?>
                                        <i class="fa-regular fa-star text-muted"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill fw-semibold"><?= $total_reviews ?> Ulasan</span>
                        </div>
                    </div>

                    <div class="reviews-list-container mb-4" style="max-height: 280px; overflow-y: auto; padding-right: 5px;">
                        <?php if(mysqli_num_rows($reviews) === 0): ?>
                            <p class="text-muted small text-center py-3">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                        <?php else: ?>
                            <?php mysqli_data_seek($reviews, 0); ?>
                            <?php while($r = mysqli_fetch_assoc($reviews)): ?>
                                <div class="review-item mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="user-avatar me-2" style="background-color: var(--secondary-color); width: 32px; height: 32px; font-size: 0.9rem;">
                                            <?= strtoupper(substr($r['nama'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 small fw-bold text-primary-color"><?= htmlspecialchars($r['nama']) ?></h6>
                                            <span class="text-muted" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($r['created_at'])) ?></span>
                                        </div>
                                    </div>
                                    <div class="text-warning mb-1" style="font-size: 0.8rem;">
                                        <?php for($s=1;$s<=5;$s++): ?>
                                            <?php if($s <= $r['rating']): ?>
                                                <i class="fa-solid fa-star"></i>
                                            <?php else: ?>
                                                <i class="fa-regular fa-star text-muted"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="mb-0 text-muted small" style="line-height: 1.5;"><?= nl2br(htmlspecialchars($r['komentar'])) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    <div class="border-top pt-3">
                        <h6 class="fw-bold text-primary-color mb-3">Tulis Ulasan Anda</h6>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Nama Anda (Opsional)</label>
                                <input type="text" name="nama_pengunjung" class="form-control form-control-custom" placeholder="Nama Anda (cth: Budi)">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Rating</label>
                                <select name="rating" class="form-select form-select-custom">
                                    <option value="5">⭐⭐⭐⭐⭐ - Sangat Baik</option>
                                    <option value="4">⭐⭐⭐⭐ - Baik</option>
                                    <option value="3">⭐⭐⭐ - Cukup</option>
                                    <option value="2">⭐⭐ - Kurang</option>
                                    <option value="1">⭐ - Buruk</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted mb-1">Ulasan / Komentar</label>
                                <textarea name="komentar" class="form-control form-control-custom" rows="3" placeholder="Bagikan pengalaman Anda mengunjungi tempat ini..." required></textarea>
                            </div>
                            <button type="submit" name="submit_ulasan" class="btn btn-primary-custom w-100 py-2">
                                Kirim Ulasan <i class="fas fa-paper-plane ms-1" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../component/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>