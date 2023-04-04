<?php


?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Kehadiran</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 mx-auto">
            <div class="card-header py-3">
                <!-- <button type="button" class="btn btn-sm btn-success"><i class="fas fa-file-excel fa-fw me-1"></i>Export Excel</button>
                <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print fa-fw me-1"></i>Print</button> -->
                <h6 class="m-0 font-weight-bold text-primary">Log Kehadiran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Lokasi</th>
                                <th>IP Address</th>
                                <th>Browser</th>
                                <th>System Operasi</th>
                                <th>Device Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($presensi as $row) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $row['tanggal']; ?></td>
                                    <td><?= $row['waktu']; ?></td>
                                    <td>
                                        <a class="text-decoration-none" target="blank" href="https://www.google.com/maps/search/<?= $row['latitude']; ?>,<?= $row['longitude']; ?>">
                                            <?= $row['latitude']; ?>,<?= $row['longitude']; ?>
                                        </a>
                                    </td>
                                    <td><?= $row['ip_addr']; ?></td>
                                    <td><?= $row['browser']; ?></td>
                                    <td><?= $row['os']; ?></td>
                                    <td><?= $row['device_name']; ?></td>
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
<!-- /.container-fluid -->