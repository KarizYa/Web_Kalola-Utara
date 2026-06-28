<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kaloka Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="pengguna.css?v=3">
</head>
<body>

<?php include __DIR__ . '/../component/navbar.php'; ?>

<section class="hero-page text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Tentang Kami</h1>
        <div class="garis-aesthetic mx-auto mb-3"></div>
        <p class="lead text-white-50">
            Profil singkat Kabupaten Kolaka Utara, sejarah pembentukan, serta jajaran kepemimpinan daerah.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container py-4">
        <div class="card border-0 shadow-sm overflow-hidden rounded-4" style="background: var(--bg-card);">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6">
                    <div class="p-4 p-md-5">
                        <h2 class="fw-bold text-primary-color mb-4" style="font-size: 2.2rem;">
                            Sejarah Singkat
                        </h2>
                        <p class="text-muted" style="line-height: 1.8;">
                            Kabupaten Kolaka Utara (sering disingkat Kolut) resmi dibentuk berdasarkan Undang-Undang Nomor 29 Tahun 2003, hasil pemekaran dari Kabupaten Kolaka. 
                        </p>
                        <p class="text-muted" style="line-height: 1.8;">
                            Dengan wilayah yang berbatasan langsung dengan Teluk Bone, kabupaten ini memiliki potensi alam yang luar biasa mulai dari sektor pertambangan, pertanian (terutama cokelat/kakao), hingga pariwisata bahari dan pegunungan.
                        </p>
                        <p class="text-muted" style="line-height: 1.8;">
                            Visi Kolaka Utara yang dikembangkan selaras dengan pariwisata berkelanjutan, menjaga keseimbangan ekologi sekaligus memperkenalkan warisan budaya Mekongga kepada dunia.
                        </p>
                        <div class="d-flex align-items-center gap-2 mt-4 text-secondary fw-semibold">
                            <i class="fa-solid fa-circle-check text-accent"></i>
                            <span>Diresmikan Sejak Tahun 2003</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4">
                        <!-- <img src="../image/Masjid_Lasusua_Kolaka_Utara.jpg"
                             class="img-fluid rounded-4 shadow-sm"
                             alt="Masjid Lasusua"
                             style="width: 100%; height: 400px; object-fit: cover;"> -->
                             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d840488.0735568989!2d120.50106150252655!3d-3.261524976841307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d9733ebf15cf45f%3A0x3030bfbcaf771a0!2sKabupaten%20Kolaka%20Utara%2C%20Sulawesi%20Tenggara!5e1!3m2!1sid!2sid!4v1782631899706!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light-subtle mb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary-color display-5">Kepemimpinan Daerah</h2>
            <p class="text-muted">Bupati dan Wakil Bupati Kabupaten Kolaka Utara 2026</p>
            <div class="garis-aesthetic mx-auto"></div>
        </div>

        <div class="row g-4 justify-content-center mt-2">
            <div class="col-md-5 text-center">
                <div class="bupati-card">
                    <div class="bupati-img-frame">
                        <img src="https://kolutkab.go.id/wp-content/uploads/Bupati-Kolaka-Utara-Periode-2017-2022-0-Nur-Rahman-Umar-750.webp" alt="Bupati Kolaka Utara">
                    </div>
                    <h4 class="fw-bold text-primary-color mb-1">
                        Drs. H. Nur Rahman Umar, MH
                    </h4>
                    <p class="text-accent fw-semibold mb-2">Bupati Kolaka Utara</p>
                    <p class="text-muted small px-3">
                        Memimpin koordinasi pemerintahan dan mendorong percepatan pembangunan di Kolaka Utara.
                    </p>
                </div>
            </div>

            <div class="col-md-5 text-center">
                <div class="bupati-card">
                    <div class="bupati-img-frame">
                        <img src="https://kolutkab.go.id/wp-content/uploads/2025/04/Wakil-Bupati-Kolaka-Utara-Periode-2025-2030-Jumarding.webp" alt="Wakil Bupati Kolaka Utara">
                    </div>
                    <h4 class="fw-bold text-primary-color mb-1">
                        H. Jumarding, S.E
                    </h4>
                    <p class="text-accent fw-semibold mb-2">Wakil Bupati Kolaka Utara</p>
                    <p class="text-muted small px-3">
                        Mendampingi jalannya roda pemerintahan, fokus pada kesejahteraan sosial dan pembinaan kemasyarakatan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../component/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>