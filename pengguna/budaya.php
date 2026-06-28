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
    <title>Warisan Budaya Kaloka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<section class="hero-page text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Warisan Budaya</h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
        <p class="lead text-white-50">
            Pelajari sejarah panjang, tradisi luhur, dan kearifan lokal yang membentuk identitas masyarakat Kolaka Utara dari masa ke masa.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-primary-color h4 mb-1">Daftar Warisan Budaya</h2>
                <p class="text-muted small mb-0">Menjaga kelestarian sejarah dan tradisi leluhur</p>
            </div>
            <div>
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold">
                    Total: <?= mysqli_num_rows($queryBudaya) ?> Budaya
                </span>
            </div>
        </div>

        <div class="row g-4">
            <?php if(mysqli_num_rows($queryBudaya) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($queryBudaya)): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card budaya-card-modern h-100 d-flex flex-column">
                            <div class="budaya-img-wrapper">
                                <?php 
                                $foto_path = "../image/uploads/budaya/" . $row['foto'];
                                $foto_url = (!empty($row['foto']) && file_exists(__DIR__ . '/' . $foto_path)) ? $foto_path : '../image/default-budaya.png';
                                ?>
                                <img src="<?= $foto_url; ?>" 
                                     class="img-fluid" 
                                     alt="<?= htmlspecialchars($row['nama']); ?>"
                                     style="height: 250px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="budaya-info-body d-flex flex-column flex-grow-1">
                                <h4 class="h5 fw-bold text-primary-color mb-2">
                                    <?= htmlspecialchars($row['nama']); ?>
                                </h4>
                                <p class="text-muted small mb-4">
                                    <?= htmlspecialchars(substr($row['deskripsi'], 0, 150)); ?>...
                                </p>
                                <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center">
                                    <a href="detail-budaya/detail-budaya.php?id=<?= $row['id']; ?>" class="fitur-link fw-bold">
                                        Jelajahi Kisahnya <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-secondary border-0 rounded-4 p-5 text-center">
                        <i class="fas fa-landmark fa-3x mb-3 text-muted"></i>
                        <h5 class="fw-bold">Belum Ada Data Budaya</h5>
                        <p class="text-muted mb-0">Silakan tambahkan data budaya baru dari halaman admin.</p>
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
