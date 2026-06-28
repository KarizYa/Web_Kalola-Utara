<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="admin-sidebar">
    <div>
        <div class="admin-user">
            <div class="admin-avatar">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="admin-user-info">
                <span class="admin-name">Administrator</span>
                <span class="admin-role">Super Admin</span>
            </div>
        </div>

        <div class="sidebar-label">Main Menu</div>

        <ul class="sidebar-menu">

            <li>
                <a href="/project-bootstrap/admin/dashboard.php"
                   class="sidebar-link <?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line sidebar-icon"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/project-bootstrap/admin/wisata.php"
                   class="sidebar-link <?= ($currentPage == 'wisata.php') ? 'active' : ''; ?>">
                    <i class="fas fa-mountain-sun sidebar-icon"></i>
                    Kelola Wisata
                </a>
            </li>

            <li>
                <a href="/project-bootstrap/admin/budaya.php"
                   class="sidebar-link <?= ($currentPage == 'budaya.php') ? 'active' : ''; ?>">
                    <i class="fas fa-masks-theater sidebar-icon"></i>
                    Kelola Budaya
                </a>
            </li>

            <li>
                <a href="/project-bootstrap/admin/kuliner.php"
                   class="sidebar-link <?= ($currentPage == 'kuliner.php') ? 'active' : ''; ?>">
                    <i class="fas fa-utensils sidebar-icon"></i>
                    Kelola Kuliner
                </a>
            </li>

            <li>
                <a href="/project-bootstrap/admin/ulasan.php"
                   class="sidebar-link <?= ($currentPage == 'ulasan.php') ? 'active' : ''; ?>">
                    <i class="fas fa-star sidebar-icon"></i>
                    Kelola Ulasan
                </a>
            </li>

            <li>
                <a href="/project-bootstrap/admin/berita.php"
                   class="sidebar-link <?= ($currentPage == 'berita.php') ? 'active' : ''; ?>">
                    <i class="fas fa-newspaper sidebar-icon"></i>
                    Event &amp; Berita
                </a>
            </li>

        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="/project-bootstrap/admin/auth/logout.php" class="sidebar-logout">
            <i class="fas fa-right-from-bracket sidebar-icon"></i>
            Logout
        </a>
    </div>

</aside>