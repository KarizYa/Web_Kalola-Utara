<?php
// Navbar component — included in pages
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!-- start navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg fixed-top">
  <div class="container">

    <!-- Logo / Brand -->
    <a class="navbar-brand fw-bold" href="/project bootstrap/index.php">
      PESONA <br>
      <small>KOLAKA UTARA</small>
    </a>

    <!-- Tombol Hamburger -->
    <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'beranda.php') ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/beranda.php">
            Beranda
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'wisata.php') ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/wisata.php">
            Wisata
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'budaya.php') ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/budaya.php">
            Budaya
          </a>
        </li>

        <li class="nav-item">
           <a class="nav-link <?= ($currentPage == 'informasi.php') ? 'active fw-bold' : ''; ?>"
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