<input type="hidden" name="idPeg" id="idPeg" value="<?= $id_peg; ?>">
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Profil Pengguna</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <!-- <a href="<?= base_url(); ?>admin/profil" class="btn btn-primary btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-eye"></i>
                        </span>
                        <span class="text">Lihat Profil</span>
                    </a> -->
                    <button data-toggle="modal" data-target="#gantiPassword" class="btn btn-danger btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-key"></i>
                        </span>
                        <span class="text">Ganti Password</span>
                    </button>
                    <?php if ($aktif == 0) : ?>
                        <button onclick="reqAktif('<?= $id; ?>')" class="btn btn-success btn-icon-split btn-sm mb-1">
                            <span class="icon text-white-50">
                                <i class="fas fa-user-check"></i>
                            </span>
                            <span class="text">Request aktivasi Akun</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <!-- <div class="row">
        <div class="col-md-3">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu</h6>
                </div>
                <div class="card-body text-left">
                    <button class="btn btn-primary btn-block mb-2" onclick="showProfil('data')">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Data
                    </button>
                    <button class="btn btn-warning btn-block mb-2" onclick="showProfil('edit')">
                        <i class="fas fa-user-edit mr-1 fa-fw"></i>
                        Edit
                    </button>
                    <button class="btn btn-danger btn-block mb-2" onclick="showProfil('gantiPassword')">
                        <i class="fas fa-key mr-1 fa-fw"></i>
                        Ganti password
                    </button>
                    <button class="btn btn-success btn-block mb-2" onclick="showProfil('aktikan')">
                        <i class="fas fa-user-check mr-1 fa-fw"></i>
                        Aktifkan Akun
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="resultProfil"></div>
        </div>
    </div> -->

    <!-- Notif -->
    <div class="row">
        <div class="col-md-12">
            <div id="notif">
                <?= $this->session->flashdata('pegawai'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <!-- <button type="button" class="btn btn-sm btn-success"><i class="fas fa-file-excel fa-fw me-1"></i>Export Excel</button>
                <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print fa-fw me-1"></i>Print</button> -->
                    <h6 class="m-0 font-weight-bold text-primary">Data Anda</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="mb-3 text-center">
                                <img class="card-img-top rounded-circle" src="<?= base_url(); ?>assets/images/pegawai/<?= $foto; ?>" alt="Foto Profil" style="width: 100%;">
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <h4><?= $nama; ?></h4>
                                    <h6><?= $jabatan; ?></h6>
                                    <h6><?= $email; ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mb-2">
                            <h5><strong>Identitas Pribadi</strong></h5>
                            <hr>
                            <table class="table table-borderless table-hover table-sm">
                                <tr>
                                    <td style="width: 125px;">Nama</td>
                                    <td><?= $nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis kelamin</td>
                                    <td><?= $jk; ?></td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td><?= $ttl; ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><?= $alamat; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?= $email; ?></td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td><?= $telp; ?></td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td><?= $jabatan; ?></td>
                                </tr>
                                <tr>
                                    <td>ID Pegawai</td>
                                    <td><?= $nip; ?></td>
                                </tr>
                                <tr>
                                    <td>Aktif?</td>
                                    <td class="align-bottom">
                                        <?= $is_active; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Ganti password -->
<div class="modal fade" id="gantiPassword" tabindex="-1" aria-labelledby="gantiPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url(); ?>admin/ubahPassword" method="POST" id="formGantiPassword">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gantiPasswordLabel">Form Ganti Password Individu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Username</label>
                        <input class="form-control" type="text" name="email" id="email" readonly value="<?= $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="oldPass">Password Lama</label>
                        <input type="password" class="form-control" name="oldPass" id="oldPass" aria-describedby="oldPasswordFeedback">
                        <small id="oldPasswordFeedback" class="invalid-feedback"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newPassword">Password Baru</label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" aria-describedby="newPasswordFeedback">
                                <small id="newPasswordFeedback" class="invalid-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newPassword2">Verifikasi Password Baru</label>
                                <input type="password" class="form-control" name="newPassword2" id="newPassword2" aria-describedby="newPassword2Feedback">
                                <small id="newPassword2Feedback" class="invalid-feedback"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="simpan" name="simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>