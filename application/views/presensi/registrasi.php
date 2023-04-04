<?php


?>

<section class="content-header"></section>

<section id="content">
    <div class="container mb-5 mb-4 col-lg-5">
        <div class="card shadow mx-auto">
            <div id="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
            <form action="" method="POST">
                <div class="card-body">
                    <h4 class="text-center">Registrasi Pegawai - e<strong>Presensi</strong></h4>
                    <h6 class="text-center"><?= $dataCompany['nama']; ?></h6>
                    <hr>
                    <div class="container">
                        <?php echo form_open_multipart(); ?>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control <?php if (form_error('email')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="Email">
                                <?= form_error('email', '<small id="email" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="telp">Nomor Telepon</label>
                                <input type="text" class="form-control <?php if (form_error('telp')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="telp" name="telp" value="<?= set_value('telp'); ?>" placeholder="No. Telepon">
                                <?= form_error('telp', '<small id="telp" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="fname">Nama Depan</label>
                                <input type="text" class="form-control <?php if (form_error('fname')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="fname" name="fname" value="<?= set_value('fname'); ?>">
                                <?= form_error('fname', '<small id="fname" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="lname">Nama Belakang <small class="text-muted">*Opsional</small></label>
                                <input type="text" class="form-control <?php if (form_error('lname')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="lname" name="lname" value="<?= set_value('lname'); ?>">
                                <?= form_error('lname', '<small id="lname" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-2">
                                <label class="form-label" for="jenisKelamin">JK</label>
                                <select id="jenisKelamin" class="form-select <?php if (form_error('jenisKelamin')) {
                                                                                    echo 'is-invalid';
                                                                                } ?>" name="jenisKelamin">
                                    <option value="" disabled selected>JK</option>
                                    <option value="Laki-laki" <?php if (set_value('jenisKelamin') == 'Laki-laki') {
                                                                    echo 'selected';
                                                                } ?>>L</option>
                                    <option value="Perempuan" <?php if (set_value('jenisKelamin') == 'Perempuan') {
                                                                    echo 'selected';
                                                                } ?>>P</option>
                                </select>
                                <?= form_error('jenisKelamin', '<small id="jenisKelamin" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                <input type="text" class="form-control <?php if (form_error('tempatLahir')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="tempatLahir" name="tempatLahir" value="<?= set_value('tempatLahir'); ?>">
                                <?= form_error('tempatLahir', '<small id="tempatLahir" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label" for="tanggalLahir">Tanggal Lahir</label>
                                <input type="date" class="form-control <?php if (form_error('tanggalLahir')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="tanggalLahir" name="tanggalLahir" value="<?= set_value('tanggalLahir'); ?>">
                                <?= form_error('tanggalLahir', '<small id="tanggalLahir" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <label class="form-label">Alamat</label>
                        <div class="row mb-2">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control <?php if (form_error('dusun')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="dusun" name="dusun" value="<?= set_value('dusun'); ?>" placeholder="Nama dusun">
                                <?= form_error('dusun', '<small id="dusun" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control <?php if (form_error('rt')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="rt" name="rt" value="<?= set_value('rt'); ?>" placeholder="RT">
                                <?= form_error('rt', '<small id="rt" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control <?php if (form_error('rw')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="rw" name="rw" value="<?= set_value('rw'); ?>" placeholder="RW">
                                <?= form_error('rw', '<small id="rw" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control <?php if (form_error('desa')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="desa" name="desa" value="<?= set_value('desa'); ?>" placeholder="Nama Desa">
                                <?= form_error('desa', '<small id="desa" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control <?php if (form_error('kecamatan')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="kecamatan" name="kecamatan" value="<?= set_value('kecamatan'); ?>" placeholder="Nama Kecamatan">
                                <?= form_error('kecamatan', '<small id="kecamatan" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control <?php if (form_error('kabupaten')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="kabupaten" name="kabupaten" value="<?= set_value('kabupaten'); ?>" placeholder="Nama Kabupaten">
                                <?= form_error('kabupaten', '<small id="kabupaten" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control <?php if (form_error('provinsi')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="provinsi" name="provinsi" value="<?= set_value('provinsi'); ?>" placeholder="Nama Provinsi">
                                <?= form_error('provinsi', '<small id="provinsi" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <small id="emailHelp" class="form-text text-muted">Latitude *Opsional</small>
                                <input type="text" class="form-control <?php if (form_error('latitude')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="latitude" placeholder="Latitude" value="<?= set_value('latitude'); ?>">
                                <?= form_error('latitude', '<small id="latitude" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <small id="emailHelp" class="form-text text-muted">Longitude *Opsional</small>
                                <input type="text" class="form-control <?php if (form_error('longitude')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="longitude" placeholder="Longitude" value="<?= set_value('longitude'); ?>">
                                <?= form_error('longitude', '<small id="longitude" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <input type="text" class="form-control <?php if (form_error('jabatan')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" id="jabatan" name="jabatan" value="<?= set_value('jabatan'); ?>">
                                <?= form_error('jabatan', '<small id="jabatan" class="form-text text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nip">Nomor Induk Pegawai</label>
                                <input type="text" class="form-control <?php if (form_error('jabatan')) {
                                                                            echo 'is-invalid';
                                                                        } ?>" name="nip" id="nip" value="<?= set_value('nip'); ?>">
                                <?= form_error('nip', '<small id="level" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="form-group col-md-4">
                                <img class="img-thumbnail img-preview" src="<?= base_url(); ?>assets/images/pegawai/default.jpg" alt="Pass Foto">
                            </div>
                            <div class="form-group col-md-8">
                                <label class="form-label" for="passfoto">Pass Foto
                                    <small class="text-muted">*Opsional</small>
                                </label>
                                <div class="input-group">
                                    <input type="file" class="form-control <?php if (form_error('passfoto')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="passfoto" name="passfoto" onchange="previewImg()">
                                    <label class="input-group-text" for="passfoto">Pilih file</label>
                                </div>
                                <small class="form-text text-muted">Pass Foto berwarna</small>
                                <?= form_error('passfoto', '<small id="passfoto" class="form-text text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 d-md-block">
                        <div class="d-flex justify-content-evenly">
                            <a href="<?= base_url(); ?>" class="btn btn-warning">Kembali</a>
                            <button class="btn btn-primary" type="submit">
                                Registrasi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>