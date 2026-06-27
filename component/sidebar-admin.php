<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="admin-sidebar">
    <div>
        <div class="admin-user mb-4">
            <i class="fa-regular fa-circle-user"></i>
            <span>Admin</span>
        </div>
        <ul class="list-unstyled">
            <li>
                <a href="dashboard.php"
                   class="sidebar-link <?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-column"></i>
                    Dashboard Admin
                </a>
            </li>
            <li>
                <a href="wisata.php"
                   class="sidebar-link <?= ($currentPage == 'wisata.php') ? 'active' : ''; ?>">

                    <i class="fa-regular fa-image"></i>
                    Kelola Wisata
                </a>
            </li>
            <li>
                <a href="budaya.php"
                   class="sidebar-link <?= ($currentPage == 'budaya.php') ? 'active' : ''; ?>">

                    <i class="fa-solid fa-book-open"></i>
                    Kelola Budaya
                </a>
            </li>

            <li>
                <a href="kuliner.php"
                   class="sidebar-link <?= ($currentPage == 'kuliner.php') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-utensils"></i>
                    Kelola Kuliner
                </a>
            </li>

            <li>
                <a href="ulasan.php"
                   class="sidebar-link <?= ($currentPage == 'ulasan.php') ? 'active' : ''; ?>">

                    <i class="fa-regular fa-comment-dots"></i>
                    Kelola Ulasan

                </a>
            </li>

            <li>
                <a href="berita.php"
                   class="sidebar-link <?= ($currentPage == 'berita.php') ? 'active' : ''; ?>">

                    <i class="fa-regular fa-calendar"></i>
                    Kelola Event & Berita

                </a>
            </li>

        </ul>

    </div>

    <div>

        <div class="admin-profile">

            <i class="fa-regular fa-circle-user me-2"></i>

            Admin Kolut

        </div>

        <a href="../admin/auth/logout.php"
           class="logout-btn">

            <i class="fa-solid fa-right-from-bracket me-2"></i>

            Logout

        </a>

    </div>

</div>