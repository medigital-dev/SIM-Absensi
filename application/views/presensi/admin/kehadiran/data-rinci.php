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
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Bulan: <?= $namaBulan . ' ' . $tahun; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="dataTable">
                <thead class="bg-primary text-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Absen Masuk</th>
                        <th>Absen Pulang</th>
                        <th>Jam Kehadiran</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($infoPresensi as $row) : ?>

                        <tr>
                            <td class="text-center"><?= $row['nomor']; ?></td>
                            <td class="text-center"><?= $row['tanggal']; ?></td>
                            <td class="text-center"><?= $row['namaHari']; ?></td>
                            <td class="text-center <?= $row['statusAbsen']['statusAbsenAwal']; ?>"><?= $row['absenAwal'] . ' ' . $row['statusAbsen']['iconAbsenAwal']; ?></td>
                            <td class="text-center <?= $row['statusAbsen']['statusAbsenAkhir']; ?>"><?= $row['absenAkhir'] . ' ' . $row['statusAbsen']['iconAbsenAkhir']; ?></td>
                            <td class="text-center <?= $row['statusAbsen']['statusJamHadir']; ?>"><?= $row['jamHadir'] . ' ' . $row['statusAbsen']['iconJamHadir']; ?></td>
                            <td class="text-center <?= $row['statusAbsen']['statusAbsenTotal']; ?>"><?= $row['statusAbsen']['iconStatusAbsenTotal']; ?></td>
                            <td><?= $row['statusAbsen']['keterangan']; ?></td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>