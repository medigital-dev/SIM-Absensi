<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hari, tanggal: <?= $tanggal; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="text-center bg-primary text-light">
                    <tr>
                        <td class="align-middle">Nama Pegawai</td>
                        <td class="align-middle">Presensi<br>Masuk</td>
                        <td class="align-middle">Presensi<br>Pulang</td>
                        <td class="align-middle">Jam<br>Kehadiran</td>
                        <td class="align-middle">Status</td>
                        <td class="align-middle">Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tampil as $row) : ?>
                        <tr>
                            <td><?= $row['nama']; ?></td>
                            <td class="text-center <?= $row['statusAbsenAwal'] ?>"><?= $row['jamDatang'] . ' ' . $row['iconAbsenAwal']; ?></td>
                            <td class="text-center <?= $row['statusAbsenAkhir'] ?>"><?= $row['jamPulang'] . ' ' . $row['iconAbsenAkhir']; ?></td>
                            <td class="text-center <?= $row['statusJamHadir']; ?>"><?= $row['jamHadir'] . ' ' . $row['iconJamHadir']; ?></td>
                            <td class="text-center <?= $row['statusAbsenTotal']; ?>"><?= $row['iconStatusAbsenTotal']; ?></td>
                            <td><?= $row['keterangan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>