<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Kalender</h1>
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
        <div class="col-md-7">
            <div class="card shadow mb-3">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Hari Libur dan Cuti Bersama</h6>
                </div>
                <div class="card-body">
                    <button class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#modalLibur"><i class="fas fa-plus-circle fa-fw"></i>Tambah</button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr class="text-center border-bottom bg-primary text-light">
                                <th class="align-middle">Tanggal</th>
                                <th class="align-middle">Jenis Libur</th>
                                <th class="align-middle">Keterangan</th>
                                <th class="align-middle">Aksi</th>
                            </tr>

                            <?php foreach ($dataHari as $row) : ?>
                                <tr>
                                    <td class="align-middle text-center"><?= $row['tanggal']; ?></td>
                                    <td class="align-middle"><?= $row['jenis_libur']; ?></td>
                                    <td class="align-middle"><?= $row['keterangan']; ?></td>
                                    <td class="align-middle text-center"><button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt fa-fw"></i></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow mb-3">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Tahun Aktif</h6>
                </div>
                <div class="card-body">
                    <button class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#modalTambah"><i class="fas fa-plus-circle fa-fw"></i>Tambah</button>
                    <table class="table table-bordered table-hover">
                        <tr class="text-center bg-primary text-light">
                            <th style="width: 50px">No</th>
                            <th>Tahun</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>

                        <?php $i = 1; ?>
                        <?php foreach ($dataTahun as $row) : ?>
                            <?php
                            $id = $row['id'];
                            $toggle = $row['is_active'];
                            $data = $id . '_' . $toggle;
                            ?>

                            <?php if ($row['is_active'] == 1) {
                                $status = '<i class="fas text-success fa-toggle-on fa-lg fa-fw"></i>';
                            } else {
                                $status = '<i class="fas text-danger fa-toggle-off fa-lg fa-fw"></i>';
                            } ?>
                            <tr>
                                <td class="text-center"><?= $i; ?></td>
                                <td><?= $row['tahun']; ?></td>
                                <td class="text-center"><a type="button" onclick="toggleTahun('<?= $data; ?>')"><?= $status; ?></a></i></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger" onclick="deleteTahun('<?= $id; ?>')" title="Hapus?"><i class="fas fa-trash-alt fa-fw"></i></button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?= base_url(); ?>admin/setTahun" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Tahun Aktif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahun">Tahun aktif</label>
                            <input type="number" class="form-control text-center" name="tahun" id="tahun" value="<?= date('Y', now()); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Hari Libuar -->
    <div class="modal fade" id="modalLibur" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url(); ?>admin/setTahun" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Hari Libur/Cuti Bersama</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahun">Tahun aktif</label>
                            <input type="number" class="form-control text-center" name="tahun" id="tahun" value="<?= date('Y', now()); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->