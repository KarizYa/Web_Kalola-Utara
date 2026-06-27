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

// Ensure reviews table exists
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS ulasan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    wisata_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    rating TINYINT NOT NULL,
    komentar TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Handle review submission (guest reviews with random name)
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ulasan'])){
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar'] ?? '');
    // generate simple random guest name
    $nama = 'Pengunjung' . substr(md5(uniqid('', true)), 0, 6);
    $wisata_id = $id;
    mysqli_query($conn, "INSERT INTO ulasan (wisata_id, nama, rating, komentar) VALUES ('{$wisata_id}', '{$nama}', '{$rating}', '{$komentar}')");
    header("Location: ?id={$id}");
    exit;
}

// Load reviews and stats
$avgResult = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM ulasan WHERE wisata_id='$id'");
$avgRow = mysqli_fetch_assoc($avgResult);
$avg_rating = $avgRow && $avgRow['avg_rating'] ? round($avgRow['avg_rating'],1) : 0;
$total_reviews = $avgRow ? (int)$avgRow['total'] : 0;
$reviews = mysqli_query($conn, "SELECT * FROM ulasan WHERE wisata_id='$id' ORDER BY created_at DESC");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['nama']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

 <div class="container py-5 detail-page">

        <!-- Judul -->
        <div class="text-center mb-5">

            <h1 class="detail-title">
                <?= htmlspecialchars($data['nama']); ?>
            </h1>

            <p class="detail-desc">
                <?= nl2br(htmlspecialchars(substr($data['deskripsi'],0,200))); ?>
            </p>

        </div>

        <!-- Gambar Utama -->
        <div class="text-center mb-5">

            <img src="../../image/uploads/wisata/<?= $data['foto']; ?>"
                 class="img-fluid rounded-4 detail-hero"
                 alt="<?= htmlspecialchars($data['nama']); ?>">

        </div>

        <!-- Informasi Wisata -->
        <h5 class="fw-bold mb-3">
            Informasi Wisata
        </h5>

        <div class="info-card mb-5">

            <div class="row text-center">

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Jenis Wisata
                    </h6>

                    <p class="fw-semibold">
                        <?= htmlspecialchars($data['jenis_wisata']); ?>
                    </p>

                </div>

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Alamat
                    </h6>

                    <p class="fw-semibold">
                        <i class="fas fa-location-dot"></i>
                        <?= htmlspecialchars($data['alamat']); ?>
                    </p>

                </div>

                <div class="col-md-4">

                    <h6 class="info-heading">
                        Tarif/Harga
                    </h6>

                    <p class="fw-semibold mb-1">
                        Rp <?= number_format($data['harga'],0,',','.'); ?>
                    </p>

                    <p class="fw-semibold">
                        Per Orang
                    </p>

                </div>

            </div>

        </div>

        <!-- Gallery -->
        <h5 class="fw-bold mb-3">
            Foto/Gallery
        </h5>

        <div class="row g-4">

            <?php if(mysqli_num_rows($gallery) > 0): ?>
                <?php while($g = mysqli_fetch_assoc($gallery)): ?>
                    <div class="col-md-4">
                        <img src="../../image/galeri/wisata/<?= $g['foto']; ?>"
                             class="img-fluid gallery-img"
                             alt="">
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-muted">Belum ada foto galeri.</div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Ulasan Pengunjung -->
        <h5 class="fw-bold mt-5 mb-3">Ulasan Pengunjung</h5>

        <div class="sejarah-card mb-4">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <h3 class="mb-0"><?= $avg_rating ?> <small class="text-muted">/5</small></h3>
                    <div>
                        <?php for($i=1;$i<=5;$i++): ?>
                            <?php if($i <= round($avg_rating)): ?>
                                <i class="fa-solid fa-star text-warning"></i>
                            <?php else: ?>
                                <i class="fa-regular fa-star text-muted"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-warning text-dark px-3 py-2"><?= $total_reviews ?> Ulasan</span>
                </div>
            </div>

            <?php if(mysqli_num_rows($reviews) === 0): ?>
                <div class="text-muted">Belum ada ulasan. Jadilah yang pertama!</div>
            <?php else: ?>
                <?php while($r = mysqli_fetch_assoc($reviews)): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <div><strong><?= htmlspecialchars($r['nama']) ?></strong></div>
                            <div class="text-muted small"><?= date('d M Y H:i', strtotime($r['created_at'])) ?></div>
                        </div>
                        <div class="mb-1">
                            <?php for($s=1;$s<=5;$s++): ?>
                                <?php if($s <= $r['rating']): ?>
                                    <i class="fa-solid fa-star text-warning"></i>
                                <?php else: ?>
                                    <i class="fa-regular fa-star text-muted"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($r['komentar'])) ?></p>
                    </div>
                    <hr>
                <?php endwhile; ?>
            <?php endif; ?>

            <div class="mt-4">
                <h6>Tambahkan Ulasan</h6>
                <form method="POST">
                    <div class="row g-2 align-items-center">
                        <div class="col-auto">
                            <label class="form-label mb-0">Rating</label>
                            <select name="rating" class="form-select">
                                <option value="5">5 - Sangat Baik</option>
                                <option value="4">4 - Baik</option>
                                <option value="3">3 - Cukup</option>
                                <option value="2">2 - Kurang</option>
                                <option value="1">1 - Buruk</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label mb-0">Ulasan</label>
                            <textarea name="komentar" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" name="submit_ulasan" class="btn btn-dark">Kirim Ulasan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>