<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>admin">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user-cog"></i>
        </div>
        <div class="sidebar-brand-text mx-3">e<strong>Presensi</strong></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if ($sidebar == 'dashboard') {
                            echo 'active';
                        } ?>">
        <a class="nav-link" href="<?= base_url(); ?>admin/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kehadiran
    </div>
    <!-- Menu kehadiran -->
    <!-- Nav Item - Charts -->
    <li class="nav-item <?php if ($sidebar == 'logKehadiran') {
                            echo 'active';
                        } ?>">
        <a class="nav-link" href="<?= base_url(); ?>admin/kehadiran">
            <i class="fas fa-building fa-fw"></i>
            <span>Log Kehadiran</span>
        </a>
    </li>
    <li class="nav-item <?php if ($sidebar == 'laporan') {
                            echo 'active';
                        } ?>">
        <a class="nav-link" href="<?= base_url(); ?>admin/laporan"" >
            <i class=" fas fa-tasks fa-fw"></i>
            <span>Laporan Kehadiran</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Profil Pengguna
    </div>

    <!-- Nav Item -->
    <li class="nav-item <?php if ($sidebar == 'profil') {
                            echo 'active';
                        } ?>">
        <a class="nav-link" href="<?= base_url(); ?>admin/profil">
            <i class="fas fa-user-alt fa-fw"></i>
            <span>Data Pengguna</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <?php if ($_SESSION['user']['level_user'] == 'Root' || $_SESSION['user']['level_user'] == 'Admin' || $_SESSION['user']['level_user'] == 'Leader') : ?>
        <div class="sidebar-heading">
            Admin
        </div>
        <?php if ($_SESSION['user']['level_user'] == 'Root' || $_SESSION['user']['level_user'] == 'Admin') : ?>
            <li class="nav-item <?php if ($sidebar == 'pegawai') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link" href="<?= base_url(); ?>admin/pegawai">
                    <i class="fas fa-users fa-fw"></i>
                    <span>Data Pegawai</span>
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item <?php if ($sidebar == 'kehadiranPegawai' || $sidebar == 'laporanAdmin' || $sidebar == 'absensiPegawai') {
                                echo 'active';
                            } ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-user-clock fa-fw"></i>
                <span>Kehadiran Pegawai</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <?php if ($_SESSION['user']['level_user'] == 'Root' || $_SESSION['user']['level_user'] == 'Leader') : ?>
                        <a class="collapse-item" href="<?= base_url(); ?>admin/kehadiranPegawai">Lihat Presensi</a>
                        <a class="collapse-item" href="<?= base_url(); ?>admin/laporanAdmin">Laporan</a>
                    <?php endif; ?>
                    <?php if ($_SESSION['user']['level_user'] == 'Root' || $_SESSION['user']['level_user'] == 'Admin') : ?>
                        <a class="collapse-item" href="<?= base_url(); ?>admin/daftarAbsensi">Absensi Pegawai</a>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <?php if ($_SESSION['user']['level_user'] == 'Root' || $_SESSION['user']['level_user'] == 'Admin') : ?>
            <li class="nav-item <?php if ($sidebar == 'company' || $sidebar == 'presensi' || $sidebar == 'aplikasi' || $sidebar == 'user' || $sidebar == 'kalender') {
                                    echo 'active';
                                } ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true" aria-controls="collapseAdmin">
                    <i class="fas fa-cog fa-fw"></i>
                    <span>Pengaturan</span>
                </a>
                <div id="collapseAdmin" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <a class="collapse-item" href="<?= base_url(); ?>admin/apps">Aplikasi</a> -->
                        <a class="collapse-item" href="<?= base_url(); ?>admin/aplikasi">Aplikasi</a>
                        <a class="collapse-item" href="<?= base_url(); ?>admin/company">Perusahaan</a>
                        <a class="collapse-item" href="<?= base_url(); ?>admin/presensi">Presensi</a>
                        <a class="collapse-item" href="<?= base_url(); ?>admin/kalender">Kalender</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>


        <!-- Divider -->
        <hr class="sidebar-divider">
    <?php endif; ?>

    <div class="sidebar-heading">
        About
    </div>

    <li class="nav-item <?php if ($sidebar == 'about') {
                            echo 'active';
                        } ?>">
        <a class="nav-link" href="<?= base_url(); ?>admin/about">
            <i class="fas fa-copyright fa-fw"></i>
            <span>About Us</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Halaman Presensi
    </div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>presensi/">
            <i class="fas fa-arrow-left fa-fw"></i>
            <span>Kembali</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->