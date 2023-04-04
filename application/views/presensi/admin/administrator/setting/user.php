<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Aplikasi</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Notif -->
    <div class="row">
        <div class="col-md-12">
            <div id="notif">
                <?= $this->session->flashdata('company'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>admin/aplikasi">Aplikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url(); ?>admin/user">Administrator</a>
                        </li>
                    </ul>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-success text-left btn-block mb-2" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus-circle fa-fw mr-2"></i>Tambah Admin</button>
                                <table class="table table-sm table-hover table-borderless">
                                    <tr class="text-center bg-secondary text-light">
                                        <th class="align-middle">Level User</th>
                                        <th colspan="2" class="align-middle">Hak Akses</th>
                                    </tr>
                                    <tr>
                                        <td>Root</td>
                                        <td>:</td>
                                        <td>Full Akses</td>
                                    </tr>
                                    <tr>
                                        <td>Admin</td>
                                        <td>:</td>
                                        <td>Presensi, Laporan Pribadi, Pengaturan, Data Pegawai, Absensi Pegawai</td>
                                    </tr>
                                    <tr>
                                        <td>Leader</td>
                                        <td>:</td>
                                        <td>Presensi, Laporan Pribadi, Laporan Pegawai</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Pegawai</th>
                                                <th>Level User</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($pejabat as $row) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $i; ?></td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td class="text-center"><?= $row['level']; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" onclick="hapusPejabat(<?= $row['id']; ?>)" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash-alt fa-fw"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pegawai">Pilih Pegawai:</label>
                            <select class="custom-select" name="pegawai" id="pegawai">
                                <option selected></option>
                                <?php foreach ($user as $row) : ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['first_name'] . ' ' . $row['last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('pegawai', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="level">Level User:</label>
                            <select type="text" class="custom-select" name="level" id="level">
                                <option selected></option>
                                <option value="Root">Root</option>
                                <option value="Admin">Admin</option>
                                <option value="Leader">Leader</option>
                            </select>
                            <?= form_error('level', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->