<div class="card shadow mb-2">
    <div class="card-header py-3">
        <!-- <button type="button" class="btn btn-sm btn-success"><i class="fas fa-file-excel fa-fw me-1"></i>Export Excel</button>
                <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print fa-fw me-1"></i>Print</button> -->
        <h6 class="m-0 font-weight-bold text-primary">Data Anda</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3 text-center">
                    <img class="card-img-top rounded-circle" src="<?= base_url(); ?>assets/images/pegawai/<?= $foto; ?>" alt="Foto Profil" style="width: 100%;">
                </div>
                <div class="row">
                    <div class="col text-center">
                        <h4><?= $nama; ?></h4>
                        <h6><?= $jabatan; ?></h6>
                        <h6><?= $email; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h5><strong>Identitas Pribadi</strong></h5>
                <hr>
                <table class="table table-borderless table-hover table-sm">
                    <tr>
                        <td style="width: 125px;">Nama</td>
                        <td><?= $nama; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis kelamin</td>
                        <td><?= $jk; ?></td>
                    </tr>
                    <tr>
                        <td>TTL</td>
                        <td><?= $ttl; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?= $alamat; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?= $email; ?></td>
                    </tr>
                    <tr>
                        <td>No Telepon</td>
                        <td><?= $telp; ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td><?= $jabatan; ?></td>
                    </tr>
                    <tr>
                        <td>Level User</td>
                        <td><?= $level; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td class="align-bottom">
                            <?= $is_active; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>