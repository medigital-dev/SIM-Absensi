<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Absensi Pegawai</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Notif -->
    <div class="row">
        <div class="col-md-12">
            <div id="notif">
                <?= $this->session->flashdata('pegawai'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <a href="<?= base_url(); ?>admin/tambahAbsensi" class="btn btn-sm btn-success"><i class="fas fa-plus-circle fa-fw mr-1"></i>Tambah</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Jenis Absensi</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= $row['tanggalMulai']; ?></td>
                                        <td class="text-center"><?= $row['tanggalSelesai']; ?></td>
                                        <td class="text-center"><?= $row['jumlahHari']; ?></td>
                                        <td class="text-center"><?= $row['jenisAbsen']; ?></td>
                                        <td><?= $row['keterangan']; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>admin/editAbsensi/<?= $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit fa-fw"></i></a>
                                            <button type="button" onclick="hapusAbsensi(<?= $row['id']; ?>)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt fa-fw"></i></button>
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