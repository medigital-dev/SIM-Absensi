<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Kehadiran Pegawai</h1>
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
        <div class="col-sm-12">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <select name="jenisLaporanAdmin" id="jenisLaporanAdmin" class="form-control">
                                <option value="0">Jenis Laporan:</option>
                                <option value="rinci">Rincian</option>
                                <option value="rekap">Rekap</option>
                                <option value="individu">Individu</option>
                                <!-- <option value="log">Log Kehadiran</option> -->
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control" name="listPegawaiAdmin" id="listPegawaiAdmin">
                                <option value="all">Pegawai: All</option>
                                <?php foreach ($user as $row) : ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['first_name'] . ' ' . $row['last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="date" class="form-control" name="tanggalLaporanAdmin" id="tanggalLaporanAdmin" value="<?php echo date('Y-m-d', now()); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control" id="bulanLaporanAdmin" name="bulanLaporanAdmin">
                                <option value="0">Pilih bulan:</option>
                                <option value="1" <?php if ($bulan == 1) {
                                                        echo 'selected';
                                                    } ?>>Januari</option>
                                <option value="2" <?php if ($bulan == 2) {
                                                        echo 'selected';
                                                    } ?>>Februari</option>
                                <option value="3" <?php if ($bulan == 3) {
                                                        echo 'selected';
                                                    } ?>>Maret</option>
                                <option value="4" <?php if ($bulan == 4) {
                                                        echo 'selected';
                                                    } ?>>April</option>
                                <option value="5" <?php if ($bulan == 5) {
                                                        echo 'selected';
                                                    } ?>>Mei</option>
                                <option value="6" <?php if ($bulan == 6) {
                                                        echo 'selected';
                                                    } ?>>Juni</option>
                                <option value="7" <?php if ($bulan == 7) {
                                                        echo 'selected';
                                                    } ?>>Juli</option>
                                <option value="8" <?php if ($bulan == 8) {
                                                        echo 'selected';
                                                    } ?>>Agustus</option>
                                <option value="9" <?php if ($bulan == 9) {
                                                        echo 'selected';
                                                    } ?>>September</option>
                                <option value="10" <?php if ($bulan == 10) {
                                                        echo 'selected';
                                                    } ?>>Oktober</option>
                                <option value="11" <?php if ($bulan == 11) {
                                                        echo 'selected';
                                                    } ?>>November</option>
                                <option value="12" <?php if ($bulan == 12) {
                                                        echo 'selected';
                                                    } ?>>Desember</option>
                                <option value="all" <?php if ($bulan == 'all') {
                                                        echo 'selected';
                                                    } ?>>All</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control" name="tahunLaporanAdmin" id="tahunLaporanAdmin">
                                <option value="0">Pilih tahun:</option>
                                <?php foreach ($tahun as $row) : ?>
                                    <option value="<?= $row['tahun']; ?>" <?php if ($tahunNow == $row['tahun']) {
                                                                                echo "selected";
                                                                            } ?>><?= $row['tahun']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="button" class="btn btn-primary btn-block" id="tombolTampil">Tampilkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="resultLaporanAdmin"></div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->