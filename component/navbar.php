<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/project-bootstrap/pengguna/beranda.php">
      <div>
         <img src="../image/logo.png" alt="Logo Kolaka Utara" class="brand-logo" style="width: 50px; height: 50px; object-fit: cover;">
      </div>
      <div class="brand-text-wrapper">
        <span class="brand-title fw-bold">PESONA</span>
        <span class="brand-subtitle text-uppercase">Kolaka Utara</span>
      </div>
    </a>

    <button class="navbar-toggler border-0" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

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

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= ($currentPage == 'informasi.php' || $currentPage == 'berita.php' || $currentPage == 'event.php' || strpos($_SERVER['PHP_SELF'], 'detail-berita') !== false) ? 'active fw-bold' : ''; ?>"
             href="/project-bootstrap/pengguna/informasi.php"
             id="navDropdownInformasi"
             role="button"
             data-bs-toggle="dropdown"
             aria-expanded="false">
            Informasi
          </a>
          <ul class="dropdown-menu navbar-dropdown-menu" aria-labelledby="navDropdownInformasi">
            <li>
              <a class="dropdown-item navbar-dropdown-item <?= $currentPage == 'berita.php' ? 'active' : ''; ?>"
                 href="/project-bootstrap/pengguna/berita.php">
                <i class="fas fa-newspaper me-2"></i>Berita
              </a>
            </li>
            <li>
              <a class="dropdown-item navbar-dropdown-item <?= $currentPage == 'event.php' ? 'active' : ''; ?>"
                 href="/project-bootstrap/pengguna/event.php">
                <i class="fas fa-calendar-check me-2"></i>Event
              </a>
            </li>
            <li><hr class="dropdown-divider my-1" style="border-color: rgba(255,255,255,0.1);"></li>
            <li>
              <a class="dropdown-item navbar-dropdown-item <?= $currentPage == 'informasi.php' ? 'active' : ''; ?>"
                 href="/project-bootstrap/pengguna/informasi.php">
                <i class="fas fa-circle-info me-2"></i>Tentang Informasi
              </a>
            </li>
          </ul>
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