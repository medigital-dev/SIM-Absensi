<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Absensi Pegawai</h1>
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
        <div class="col-md-4 mx-auto">
            <div class="card shadow mb-1">
                <form action="" method="POST">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Absensi Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="pegawai">Pilih pegawai</label>
                            <select type="text" class="form-control mb-2" name="pegawai" id="pegawai">
                                <option></option>
                                <?php foreach ($user as $row) : ?>
                                    <option value="<?= $row['id']; ?>" <?php if (set_value('pegawai') == $row['id']) {
                                                                            echo 'selected';
                                                                        } ?>><?= $row['first_name'] . ' ' . $row['last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('pegawai', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-7">
                                <label for="tanggalMulai">Tanggal Mulai</label>
                                <input type="date" class="form-control mb-2" name="tanggalMulai" id="tanggalMulai" value="<?= set_value('tanggalMulai'); ?>">
                                <?= form_error('tanggalMulai', '<small class="text-danger mb-2">', '</small>'); ?>
                            </div>
                            <div class="col-sm-5">
                                <label for="jumlahHari">Jumlah Hari</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlahHari" id="jumlahHari" aria-describedby="satuan" value="<?php if (set_value('jumlahHari')) {
                                                                                                                                                        echo set_value('jumlahHari');
                                                                                                                                                    } else {
                                                                                                                                                        echo 1;
                                                                                                                                                    }; ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="satuan">Hari</span>
                                    </div>
                                </div>
                                <?= form_error('jumlahHari', '<small class="text-danger mb-2">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenisAbsensi">Jenis Absensi</label>
                            <select type="text" class="form-control mb-1" name="jenisAbsensi" id="jenisAbsensi">
                                <option></option>
                                <option value="Izin" <?php if (set_value('jenisAbsensi') == 'Izin') {
                                                            echo 'selected';
                                                        } ?>>Izin</option>
                                <option value="Sakit" <?php if (set_value('jenisAbsensi') == 'Sakit') {
                                                            echo 'selected';
                                                        } ?>>Sakit</option>
                                <option value="Cuti" <?php if (set_value('jenisAbsensi') == 'Cuti') {
                                                            echo 'selected';
                                                        } ?>>Cuti</option>
                                <option value="Dinas Luar" <?php if (set_value('jenisAbsensi') == 'Dinas Luar') {
                                                                echo 'selected';
                                                            } ?>>Dinas Luar</option>
                            </select>
                            <?= form_error('jenisAbsensi', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control mb-1" rows="5" name="keterangan" id="keterangan" placeholder="Keterangan"><?= set_value('keterangan'); ?></textarea>
                            <?= form_error('keterangan', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-around">
                            <a href="<?= base_url(); ?>admin/daftarAbsensi" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->