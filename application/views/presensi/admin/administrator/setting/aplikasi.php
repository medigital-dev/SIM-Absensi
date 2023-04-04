<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Aplikasi</h1>
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
                            <a class="nav-link active" href="<?= base_url(); ?>admin/aplikasi">Aplikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>admin/user">Administrator</a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-4 mx-auto">
                            <div class="form-group">
                                <label>Koordinat Presensi</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="geoloc" id="geoloc1" value="1">
                                            <label class="form-check-label" for="geoloc1">
                                                Aktif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="geoloc" id="geoloc2" value="0">
                                            <label class="form-check-label" for="geoloc2">
                                                Tidak Aktif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Kata Kunci Presensi</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keyword" id="keyword1" value="nip">
                                            <label class="form-check-label" for="keyword1">
                                                NIP
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keyword" id="keyword2" value="email">
                                            <label class="form-check-label" for="keyword2">
                                                Email
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keyword" id="keyword3" value="nip">
                                            <label class="form-check-label" for="keyword3">
                                                Nomor Telepon
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->