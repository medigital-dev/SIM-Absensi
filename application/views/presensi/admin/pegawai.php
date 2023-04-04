<?php




?>

<style>
    .card table tr th {
        vertical-align: middle;
        text-align: center;
    }

    .card table tr td {
        vertical-align: middle;
    }
</style>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pegawai</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <a href="<?= base_url(); ?>admin/pegawai" class="btn btn-primary btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="text">Daftar</span>
                    </a>
                    <a href="<?= base_url(); ?>admin/tambahpegawai" class="btn btn-success btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                    <!-- <a class="btn btn-info btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="text">Import</span>
                    </a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="notif">
                <?= $this->session->flashdata('pegawai'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar pegawai</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="bg-primary text-light">
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Email</th>
                                    <th>Nama</th>
                                    <th>No. Telepon</th>
                                    <th>Jabatan</th>
                                    <th>Keaktifan</th>
                                    <th style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($dataPegawai as $row) : ?>
                                    <?php

                                    if ($row['aktif_peg'] == 1) {
                                        $is_active  = '<div class="spinner-grow spinner-grow-sm text-success" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <a class="text-success text-decoration-none">Aktif</a>';
                                        $icon       = '<i class="fas fa-user-check fa-fw"></i>';
                                        $buttonTitle = 'Non Aktifkan';
                                        $color      = 'success';
                                    } else {
                                        $is_active = '<div class="spinner-grow spinner-grow-sm text-danger" role="status">
                                        <span class="sr-only">Loading...</span>
                                        </div>
                                        <a class="text-danger text-decoration-none">Tidak</a>';
                                        $icon       = '<i class="fas fa-user-slash fa-fw"></i>';
                                        $buttonTitle = 'Aktifkan';
                                        $color      = 'danger';
                                    }

                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                        <td class="text-center"><?= $row['no_telp']; ?></td>
                                        <td><?= $row['jabatan']; ?></td>
                                        <td><?= $is_active; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>admin/detailPegawai/<?= $row['id']; ?>" class="btn btn-sm btn-primary" title="Detail"><i class="fas fa-eye fa-fw"></i></a>
                                            <a href="<?= base_url(); ?>admin/editPegawai/<?= $row['id']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                                            <button class="btn btn-sm btn-<?= $color; ?>" title="<?= $buttonTitle; ?>" onclick="tombolAktif('<?= $row['id']; ?>')"><?= $icon; ?></button>
                                            <button class="btn btn-sm btn-secondary" title="Reset Password" onclick="resetPassword('<?= $row['id']; ?>')"><i class="fas fa-key fa-fw"></i></button>
                                            <button class="btn btn-sm btn-danger" title="Hapus Permanen" onclick="hapusPermanen('<?= $row['id']; ?>')"><i class="fas fa-trash-alt fa-fw"></i></button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="result">

</div>