<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Perusahaan</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Notif -->
    <div class="row">
        <div class="col-md-12">
            <div id="notif">
                <?= $this->session->flashdata('company'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url(); ?>admin/company">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>admin/logo">Logo</a>
                        </li>
                    </ul>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="nama">Nama Perusahaan</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $company['nama']; ?>">
                            <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" name="alamat" id="alamat" rows="3"><?= $company['alamat']; ?></textarea>
                            <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="lat">Latitude <small>* opsional</small></label>
                                <input type="text" class="form-control" name="lat" id="lat" value="<?= $company['latitude']; ?>">
                                <?= form_error('lat', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="long">Longitude <small>* opsional</small></label>
                                <input type="text" class="form-control" name="long" id="long" value="<?= $company['longitude']; ?>">
                                <?= form_error('long', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="telepon">Telepon</label>
                                <input type="text" class="form-control" name="telepon" id="telepon" value="<?= $company['telepon']; ?>">
                                <?= form_error('telepon', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= $company['email']; ?>">
                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="website">Website</label>
                                <input type="text" class="form-control" name="website" id="website" value="<?= $company['website']; ?>">
                                <?= form_error('website', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->