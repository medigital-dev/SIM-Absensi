<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Kehadiran</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-md-2">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <!-- <button type="button" class="btn btn-sm btn-success"><i class="fas fa-file-excel fa-fw me-1"></i>Export Excel</button>
                <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print fa-fw me-1"></i>Print</button> -->
                    <h6 class="m-0 font-weight-bold text-primary">Pilih data</h6>
                </div>
                <div class="card-body">
                    <input type="hidden" name="idPegawai" id="idPegawai" value="<?= $_SESSION['user']['id']; ?>">
                    <div class="form-group">
                        <select class="form-control" name="jenis" id="jenis" onchange="setBulan()">
                            <option value="0">Jenis laporan</option>
                            <option value="rinci">Rincian</option>
                            <option value="rekap">Rekapitulasi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="bulan" name="bulan">
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
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="tahun" name="tahun">
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021" selected>2021</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" onclick="laporan_submit()">Tampilkan</button>
                </div>
            </div>
            <div class="card shadow mb-2" id="keterangan">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keterangan</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><button class="btn btn-sm btn-primary mr-2"><i class="fas fa-user-clock"></i></button><?= date('H:i', strtotime($jamMasuk)) . '-' . date('H:i', strtotime($jamPulang)); ?></li>
                    <li class="list-group-item"><button class="btn btn-sm btn-primary mr-2"><i class="fas fa-hourglass-start fa-fw"></i></button><?= date('G', strtotime($jamKerja)); ?> jam</li>
                    <li class="list-group-item"><button class="btn btn-sm btn-warning mr-2"><i class="fas fa-clock fa-fw"></i></button>Terlambat</li>
                    <li class="list-group-item"><button class="btn btn-sm btn-info mr-2"><i class="fas fa-history fa-fw"></i></button>Pulang Cepat</li>
                    <li class="list-group-item"><button class="btn btn-sm btn-success mr-2"><i class="fas fa-check-circle fa-fw"></i></button>Terpenuhi</li>
                    <li class="list-group-item"><button class="btn btn-sm btn-danger mr-2"><i class="fas fa-times-circle fa-fw"></i></button>Kurang</li>
                </ul>
            </div>
        </div>
        <div class="col-md-10">

            <div id="notif"></div>

            <div id="result"></div>


        </div>

    </div>

</div>
<!-- /.container-fluid -->