<?php


?>

<section class="content-header"></section>

<section id="content">
    <div class="container">
        <div class="card shadow mx-auto" style="width: 350px;">
            <div id="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
            <form action="" method="POST" id="form">
                <div class="text-center">
                    <!-- <img src="<?= base_url(); ?>assets/images/logo.png" style="width: 200px;" class="card-img-top" alt="Logo"> -->
                </div>
                <div class="card-body">
                    <h4 class="text-center">e<strong>Presensi</strong> Pegawai</h4>
                    <h6 class="text-center"><?= $dataCompany['nama']; ?></h6>
                    <hr>
                    <div class="container">
                        <div class="row text-center">
                            <div class="col fw-bold fs-1">
                                <span id="jam"></span>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col fs-5 text-<?= $statusHari; ?>"><?= $hariTanggal; ?></div>
                        </div>
                        <div class="row text-center">
                            <small class="text-mute text-<?= $statusHari; ?>"><?= $kethari; ?></small>
                        </div>
                    </div>
                    <hr>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <div class="form-text mb-3">Anda sudah login, silahkan klik tombol dibawah, masukkan password anda kemudian klik Absen</div>
                        <div class="form-group">
                            <input type="text" class="form-control mb-1" id="email" name="email" value="<?= $_SESSION['user']['email']; ?>" readonly aria-describedby="email" placeholder="Email anda">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control mb-1" id="password" name="password" aria-describedby="email" placeholder="Password anda">
                        </div>
                        <div class="row mb-2">
                            <?= form_error('password', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                    <?php else : ?>
                        <div class="form-text mb-3">Masukkan akun berupa email berserta password, kemudian klik Absen.</div>
                        <input type="text" class="form-control mb-1" id="email" name="email" value="<?= set_value('email'); ?>" aria-describedby="email" placeholder="Email anda">
                        <div class="row mb-2">
                            <?= form_error('email', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                        <input type="password" class="form-control mb-1" id="password" name="password" aria-describedby="email" placeholder="Password anda">
                        <div class="row mb-2">
                            <?= form_error('password', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    <?php endif; ?>

                    <div id="notif_go"></div>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 d-md-block">
                        <div class="d-flex justify-content-evenly">
                            <button class="btn btn-<?= $statusHari; ?>" type="submit" id="absen" name="absen">
                                <i class="fas fa-check-circle me-1"></i>
                                Absen
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>