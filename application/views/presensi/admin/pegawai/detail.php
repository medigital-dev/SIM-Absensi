<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pegawai</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

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

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-8 mx-auto">

            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <!-- <button type="button" class="btn btn-sm btn-success"><i class="fas fa-file-excel fa-fw me-1"></i>Export Excel</button>
                <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print fa-fw me-1"></i>Print</button> -->
                    <h6 class="m-0 font-weight-bold text-primary">Identitas Pegawai</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 text-center">
                                <img class="card-img-top rounded-circle" src="<?= base_url(); ?>assets/images/pegawai/<?= $dataPegawai['foto']; ?>" alt="Foto Profil" style="width: 100%;">
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <h4><?= $dataPegawai['nama']; ?></h4>
                                    <h6><?= $dataPegawai['jabatan']; ?></h6>
                                    <h6><?= $dataPegawai['email']; ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5><strong>Identitas Pribadi</strong></h5>
                            <hr>
                            <table class="table table-borderless table-hover table-sm">
                                <tr>
                                    <td style="width: 125px;">Nama</td>
                                    <td><?= $dataPegawai['nama']; ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis kelamin</td>
                                    <td><?= $dataPegawai['jk']; ?></td>
                                </tr>
                                <tr>
                                    <td>TTL</td>
                                    <td><?= $dataPegawai['ttl']; ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><?= $dataPegawai['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?= $dataPegawai['email']; ?></td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td><?= $dataPegawai['telp']; ?></td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td><?= $dataPegawai['jabatan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nomor Induk Pegawai</td>
                                    <td><?= $dataPegawai['nip']; ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td class="align-bottom">
                                        <?= $dataPegawai['is_active']; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url(); ?>admin/pegawai" class="btn btn-warning btn-sm"><i class="fas fa-arrow-left fa-fw"></i></a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->