<?php

$id = $_GET['id'] ?? '';

$dataBudaya = [

    'lulo' => [
        'judul' => 'Tari Lulo',
        'deskripsi' => 'Tari Lulo merupakan tarian tradisional masyarakat suku Tolaki yang berasal dari wilayah Sulawesi Tenggara. Tarian ini telah diwariskan secara turun-temurun dan menjadi salah satu simbol persatuan, kebersamaan, serta rasa syukur masyarakat setempat.

Pada awalnya, Tari Lulo dilakukan sebagai bagian dari ritual adat dan kegiatan pertanian, terutama setelah panen padi berhasil dilakukan.

Secara historis, kata "Lulo" berasal dari gerakan menginjak-injak padi yang dilakukan masyarakat Tolaki setelah panen untuk memisahkan bulir padi dari tangkainya.

Gerakan tersebut kemudian berkembang menjadi sebuah tarian tradisional yang dilakukan secara berkelompok dengan saling bergandengan tangan membentuk lingkaran.

Pola lingkaran dalam Tari Lulo melambangkan persaudaraan, persatuan, hubungan sosial tanpa membedakan status sosial, usia, maupun latar belakang.

Dalam perkembangannya, Tari Lulo tidak hanya digunakan dalam upacara adat, tetapi juga ditampilkan pada acara pernikahan, penyambutan tamu, festival budaya, dan berbagai kegiatan masyarakat lainnya.

Saat ini Tari Lulo menjadi salah satu identitas budaya Sulawesi Tenggara yang terus dilestarikan sebagai warisan budaya dan sarana mempererat hubungan sosial antarwarga.',

        'catatan' => 'Anda dapat melihat langsung Tari Lulo pada acara pernikahan adat, festival budaya, maupun event tahunan Kabupaten Kolaka Utara.',

        'gallery' => [
            'img/lulo1.jpg',
            'img/lulo2.jpg',
            'img/lulo3.jpg'
        ]
    ],

    'rumah-adat' => [
        'judul' => 'Rumah Adat Mekongga',

        'deskripsi' => 'Rumah Adat Mekongga merupakan salah satu warisan budaya masyarakat Kolaka Utara yang mencerminkan nilai-nilai kehidupan, gotong royong, dan penghormatan kepada leluhur.

Rumah adat ini berbentuk rumah panggung yang dibangun menggunakan kayu pilihan dan dirancang agar mampu bertahan terhadap kondisi alam setempat.

Selain sebagai tempat tinggal, rumah adat juga berfungsi sebagai tempat pelaksanaan upacara adat, musyawarah, serta kegiatan sosial masyarakat.

Arsitektur Rumah Adat Mekongga memiliki filosofi yang menggambarkan hubungan harmonis antara manusia, alam, dan Sang Pencipta.

Hingga saat ini, keberadaan rumah adat tetap dijaga dan menjadi simbol identitas budaya masyarakat Mekongga.',

        'catatan' => 'Rumah Adat Mekongga masih dapat ditemukan pada beberapa kawasan budaya dan digunakan dalam kegiatan adat tertentu.',

        'gallery' => [
            'img/rumah1.jpg',
            'img/rumah2.jpg',
            'img/rumah3.jpg'
        ]
    ]
];

if (!isset($dataBudaya[$id])) {
    header("Location: budaya.php");
    exit;
}

$budaya = $dataBudaya[$id];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danau Biru Kolaka Utara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../pengguna.css">
</head>
<body>

    <!-- Navbar -->
<?php include __DIR__ . '/../../component/navbar.php'; ?>

    <!-- Header Detail Budaya -->
    <section class="detail-budaya-header">
        <div class="container text-center">

            <h1 class="detail-budaya-title">
                <?= $budaya['judul']; ?>
            </h1>

            <div class="detail-budaya-line"></div>

        </div>
    </section>

    <!-- Konten -->
    <section class="pb-5">

        <div class="container">

            <!-- Sejarah -->
            <h3 class="sejarah-title">
                Sejarah Budaya
            </h3>

            <div class="sejarah-card">

                <p>
                    <?= nl2br($budaya['deskripsi']); ?>
                </p>

            </div>

            <!-- Catatan -->
            <div class="catatan-box">

                <h6 class="catatan-title">
                    Catatan:
                </h6>

                <p class="catatan-text">
                    <?= $budaya['catatan']; ?>
                </p>

            </div>

            <!-- Gallery -->
            <h3 class="gallery-title">
                Foto/Gallery
            </h3>

            <div class="row g-4">

                <?php foreach ($budaya['gallery'] as $gambar): ?>

                    <div class="col-md-4">

                        <div class="gallery-card">

                            <img src="<?= $gambar; ?>"
                                 alt="<?= $budaya['judul']; ?>"
                                 class="img-fluid">

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <!-- Tombol Kembali -->
            <div class="text-center mt-5">

                <a href="../budaya.php"
                   class="btn btn-dark rounded-pill px-4">

                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Budaya

                </a>

            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>