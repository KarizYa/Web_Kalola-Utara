<?php
// Navbar component — included in pages
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- start navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
  <div class="container">

    <!-- Logo / Brand -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="/project-bootstrap/pengguna/beranda.php">
      <div class="brand-logo-wrapper">
        <i class="fas fa-compass brand-icon"></i>
      </div>
      <div class="brand-text-wrapper">
        <span class="brand-title fw-bold">PESONA</span>
        <span class="brand-subtitle text-uppercase">Kolaka Utara</span>
      </div>
    </a>

    <!-- Tombol Hamburger -->
    <button class="navbar-toggler border-0" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto gap-1">

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'beranda.php') ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/beranda.php">
            Beranda
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'wisata.php' || strpos($_SERVER['PHP_SELF'], 'detail-wisata') !== false) ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/wisata.php">
            Wisata
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'budaya.php' || strpos($_SERVER['PHP_SELF'], 'detail-budaya') !== false) ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/budaya.php">
            Budaya
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'kuliner.php' || strpos($_SERVER['PHP_SELF'], 'detail-kuliner') !== false) ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/kuliner.php">
            Kuliner
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'informasi.php' || $currentPage == 'berita.php' || strpos($_SERVER['PHP_SELF'], 'detail-berita') !== false) ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/informasi.php">
            Informasi
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'tentang.php') ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/tentang.php">
            Tentang
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>
<!-- ending navbar -->