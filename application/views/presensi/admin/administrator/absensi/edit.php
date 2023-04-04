<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Absensi Pegawai</h1>
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
                    <input type="hidden" name="id" id="id" value="<?= $absensi['id']; ?>">
                    <input type="hidden" name="pegawai" id="pegawai" value="<?= $absensi['id_peg']; ?>">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Absensi Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="namaPegawai">Nama Pegawai</label>
                            <input class="form-control" type="text" name="namaPegawai" id="namaPegawai" value="<?= $absensi['nama']; ?>" readonly>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-7">
                                <label for="tanggalMulai">Tanggal Mulai</label>
                                <input type="date" class="form-control mb-2" name="tanggalMulai" id="tanggalMulai" value="<?= $absensi['tanggal']; ?>">
                                <?= form_error('tanggalMulai', '<small class="text-danger mb-2">', '</small>'); ?>
                            </div>
                            <div class="col-sm-5">
                                <label for="jumlahHari">Jumlah Hari</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlahHari" id="jumlahHari" aria-describedby="satuan" value="<?= $absensi['lama']; ?>">
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
                                <option value="Izin" <?php if ($absensi['jenisAbsensi'] == 'Izin') {
                                                            echo 'selected';
                                                        } ?>>Izin</option>
                                <option value="Sakit" <?php if ($absensi['jenisAbsensi'] == 'Sakit') {
                                                            echo 'selected';
                                                        } ?>>Sakit</option>
                                <option value="Cuti" <?php if ($absensi['jenisAbsensi'] == 'Cuti') {
                                                            echo 'selected';
                                                        } ?>>Cuti</option>
                                <option value="Dinas Luar" <?php if ($absensi['jenisAbsensi'] == 'Dinas Luar') {
                                                                echo 'selected';
                                                            } ?>>Dinas Luar</option>
                            </select>
                            <?= form_error('jenisAbsensi', '<small class="text-danger mb-2">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control mb-1" rows="5" name="keterangan" id="keterangan" placeholder="Keterangan"><?= $absensi['keterangan']; ?></textarea>
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