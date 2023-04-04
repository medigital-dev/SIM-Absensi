<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Kehadiran Pegawai</h1>
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
        <div class="col-md-3">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pilih tanggal</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="date" class="form-control" name="tanggal" id="tanggal" aria-describedby="tanggalFeedback" value="<?= set_value('tanggal'); ?>" onchange="presensiAll()">
                        <div id="tanggalFeedback" class="invalid-feedback"></div>
                        <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu <small>(Edit/hapus Presensi)</small></h6>
                </div>
                <div class="card-body">
                    <div class="form-goup mb-2">
                        <label for="nama">Pilih pegawai:</label>
                        <select class="form-control" name="namaPegawai" id="namaPegawai" onchange="lihatPresensi()">
                            <option value="0">Nama Pegawai</option>
                            <?php if (isset($user)) : ?>
                                <?php foreach ($user as $row) : ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['first_name'] . ' ' . $row['last_name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <!-- <div class="row"> -->
                    <div id="jamPresensi"></div>
                    <!-- </div> -->
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div id="result"></div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->