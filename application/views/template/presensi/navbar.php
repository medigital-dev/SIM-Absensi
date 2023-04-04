<section id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <img src="<?= base_url(); ?>assets/images/logo.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top">
                e<strong>Presensi</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (isset($_SESSION['user'])) : ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active">
                                <i class="fas fa-user-alt fa-fw"></i>
                                <?= $this->session->userdata('user')['first_name'] . ' ' . $this->session->userdata('user')['last_name']; ?>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <li>
                            <a class="nav-link text-success" href="<?= base_url(); ?>presensi/registrasi" type="button" title="Registrasi">
                                <i class="fas fa-user-plus fa-fw"></i>
                                <span id="desktop_hide">Registrasi</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link text-primary" type="button" title="Cek Location GPS" data-bs-toggle="modal" data-bs-target="#modalMaps">
                                <i class="fas fa-map-marker-alt fa-fw"></i>
                                <span id="desktop_hide">Cek Koordinat Lokasi</span>
                            </a>
                        </li>
                        <li>
                            <a type="button" class="nav-link" title="Login" data-bs-toggle="modal" data-bs-target="#modalLogin">
                                <i class="fas fa-sign-in-alt fa-fw"></i>
                                <span id="desktop_hide">Login</span>
                            </a>
                        </li>
                    <?php else : ?>
                        <li>
                            <a class="nav-link text-primary" type="button" title="Cek Location GPS" data-bs-toggle="modal" data-bs-target="#modalMaps">
                                <i class="fas fa-map-marker-alt fa-fw"></i>
                                <span id="desktop_hide">Cek Koordinat Lokasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=" <?= base_url(); ?>admin" title="Admin Page">
                                <i class="fas fa-user-cog fa-fw"></i>
                                <span id="desktop_hide">Admin Page</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link text-danger" href="<?= base_url(); ?>presensi/logout" title="Logout">
                                <i class="fas fa-sign-out-alt fa-fw"></i>
                                <span id="desktop_hide">Logout</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</section>