<?php


?>

<style>
    .card table tr th {
        vertical-align: middle;
        text-align: center;
    }

    .card table tr td {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="card shadow mb-2">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Bulan: <?= $namaBulan . ' ' . $tahun; ?></h6>
        <div>
            <!-- <button class="btn btn-sm btn-warning" title="Copy Tabel"><i class="fas fa-copy fa-fw"></i></button>
            <button class="btn btn-sm btn-success" title="Print Tabel"><i class="fas fa-print fa-fw"></i></button> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="dataTable">
                <thead class="bg-primary text-light">
                    <tr class="text-center">
                        <th rowspan="2">Nama pegawai</th>
                        <th rowspan="2">Jumlah Hari</th>
                        <th rowspan="2">Jumlah Hari Efektif</th>
                        <th rowspan="2">Hari Libur</th>
                        <th colspan="8">Jumlah</th>
                        <th rowspan="2">Tidak Hadir</th>
                        <th rowspan="2">% Kehadiran</th>
                    </tr>
                    <tr>

                        <th>Log</th>
                        <th>Kehadiran</th>
                        <th>Terlambat</th>
                        <th>Pulang Cepat</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Cuti</th>
                        <th>Dinas Luar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['jumlahHari']; ?></td>
                            <td><?= $row['jumlahHariAktif']; ?></td>
                            <td><?= $row['jumlahHariLibur']; ?></td>
                            <td><?= $row['jumlahLogPresensi']; ?></td>
                            <td><?= $row['jumlahKehadiran']; ?></td>
                            <td><?= $row['jumlahTerlambat']; ?></td>
                            <td><?= $row['jumlahPulangCepat']; ?></td>
                            <td><?= $row['jumlahSakit']; ?></td>
                            <td><?= $row['jumlahIzin']; ?></td>
                            <td><?= $row['jumlahCuti']; ?></td>
                            <td><?= $row['jumlahDinasLuar']; ?></td>
                            <td><?= $row['jumlahTidakHadir']; ?></td>
                            <td><?= $row['prosentaseKehadiran']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>