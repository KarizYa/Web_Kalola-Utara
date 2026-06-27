<?php

include __DIR__ . '/../../config/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if($id <= 0){
    header('Location: ../berita.php');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM informasi WHERE id='$id' AND status='Publish'");
$selected = mysqli_fetch_assoc($query);

if(!$selected){
    header('Location: ../berita.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selected['judul']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

<?php include __DIR__ . '/../../component/navbar.php'; ?>

    <section class="detail-budaya-header py-5">
        <div class="container text-center">
            <h1 class="detail-budaya-title">
                <?= htmlspecialchars($selected['judul']); ?>
            </h1>
            <div class="detail-budaya-line"></div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">

            <div class="text-center mb-5">
                <img src="../../image/uploads/informasi/<?= htmlspecialchars($selected['foto']); ?>"
                     class="img-fluid rounded-4 detail-hero"
                     alt="<?= htmlspecialchars($selected['judul']); ?>">
            </div>

            <div class="sejarah-card mb-4">
                <h3 class="sejarah-title">Ringkasan</h3>
                <p><?= nl2br(htmlspecialchars($selected['ringkasan'])); ?></p>
            </div>

            <?php if($selected['jenis'] === 'Event'): ?>
                <div class="sejarah-card mb-4">
                    <h3 class="sejarah-title">Detail Event</h3>
                    <p><strong>Lokasi:</strong> <?= htmlspecialchars($selected['lokasi']); ?></p>
                    <p><strong>Tanggal:</strong> <?= htmlspecialchars($selected['tanggal_event']); ?> <?= htmlspecialchars($selected['waktu_event']); ?></p>
                </div>
            <?php endif; ?>

            <div class="sejarah-card mb-4">
                <h3 class="sejarah-title"><?= $selected['jenis'] === 'Event' ? 'Isi Event' : 'Isi Berita'; ?></h3>
                <p><?= nl2br(htmlspecialchars($selected['isi'])); ?></p>
            </div>

            <div class="text-center mt-5">
                <a href="../berita.php" class="btn btn-dark rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Berita
                </a>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
