<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hari, tanggal: <?= $tanggal; ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr>
                        <td>No</td>
                        <td>Nama Pegawai</td>
                        <td>Masuk</td>
                        <td>Pulang</td>
                        <td>Jam Kehadiran</td>
                        <td>Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($user as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $i; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td class="text-center"><?= $row['jamMasuk']; ?></td>
                            <td class="text-center"><?= $row['jamPulang']; ?></td>
                            <td class="text-center"><?= $row['jamHadir']; ?></td>
                            <td><?= $row['keterangan']; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>