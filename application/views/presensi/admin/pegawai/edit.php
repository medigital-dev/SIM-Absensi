<?php



?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit data pegawai</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <a href="<?= base_url(); ?>admin/pegawai" class="btn btn-primary btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="text">Daftar</span>
                    </a>
                    <a href="<?= base_url(); ?>admin/tambahpegawai" class="btn btn-success btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                    <!-- <a class="btn btn-info btn-icon-split btn-sm mb-1">
                        <span class="icon text-white-50">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="text">Import</span>
                    </a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $this->session->flashdata('pegawai'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow mb-2">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit data pegawai</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_open_multipart(); ?>
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <input type="hidden" name="foto" value="<?= $user['foto']; ?>">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control <?php if (form_error('email')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="email" name="email" value="<?= $user['email']; ?>" placeholder="Email">
                                    <?= form_error('email', '<small id="email" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telp">Nomor Telepon</label>
                                    <input type="text" class="form-control <?php if (form_error('telp')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="telp" name="telp" value="<?= $user['no_telp']; ?>" placeholder="No. Telepon">
                                    <?= form_error('telp', '<small id="telp" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fname">Nama Depan</label>
                                    <input type="text" class="form-control <?php if (form_error('fname')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="fname" name="fname" value="<?= $user['first_name']; ?>">
                                    <?= form_error('fname', '<small id="fname" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lname">Nama Belakang <small class="text-muted">*Opsional</small></label>
                                    <input type="text" class="form-control <?php if (form_error('lname')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="lname" name="lname" value="<?= $user['last_name']; ?>">
                                    <?= form_error('lname', '<small id="lname" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="jenisKelamin">JK</label>
                                    <select id="jenisKelamin" class="custom-select <?php if (form_error('jenisKelamin')) {
                                                                                        echo 'is-invalid';
                                                                                    } ?>" name="jenisKelamin">
                                        <option value="" disabled selected>JK</option>
                                        <option value="Laki-laki" <?php if ($user['jk'] == 'Laki-laki') {
                                                                        echo 'selected';
                                                                    } ?>>L</option>
                                        <option value="Perempuan" <?php if ($user['jk'] == 'Perempuan') {
                                                                        echo 'selected';
                                                                    } ?>>P</option>
                                    </select>
                                    <?= form_error('jenisKelamin', '<small id="jenisKelamin" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tempatLahir">Tempat Lahir</label>
                                    <input type="text" class="form-control <?php if (form_error('tempatLahir')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="tempatLahir" name="tempatLahir" value="<?= $user['tempat_lahir']; ?>">
                                    <?= form_error('tempatLahir', '<small id="tempatLahir" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tanggalLahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control <?php if (form_error('tanggalLahir')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="tanggalLahir" name="tanggalLahir" value="<?= $user['tanggal_lahir']; ?>">
                                    <?= form_error('tanggalLahir', '<small id="tanggalLahir" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <label>Alamat</label>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control <?php if (form_error('dusun')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="dusun" name="dusun" value="<?= $user['nama_dusun']; ?>" placeholder="Nama dusun">
                                    <?= form_error('dusun', '<small id="dusun" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control <?php if (form_error('rt')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="rt" name="rt" value="<?= $user['rt']; ?>" placeholder="RT">
                                    <?= form_error('rt', '<small id="rt" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control <?php if (form_error('rw')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="rw" name="rw" value="<?= $user['rw']; ?>" placeholder="RW">
                                    <?= form_error('rw', '<small id="rw" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control <?php if (form_error('desa')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="desa" name="desa" value="<?= $user['nama_desa']; ?>" placeholder="Nama Desa">
                                    <?= form_error('desa', '<small id="desa" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control <?php if (form_error('kecamatan')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="kecamatan" name="kecamatan" value="<?= $user['nama_kecamatan']; ?>" placeholder="Nama Kecamatan">
                                    <?= form_error('kecamatan', '<small id="kecamatan" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control <?php if (form_error('kabupaten')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="kabupaten" name="kabupaten" value="<?= $user['nama_kabupaten']; ?>" placeholder="Nama Kabupaten">
                                    <?= form_error('kabupaten', '<small id="kabupaten" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control <?php if (form_error('provinsi')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="provinsi" name="provinsi" value="<?= $user['nama_provinsi']; ?>" placeholder="Nama Provinsi">
                                    <?= form_error('provinsi', '<small id="provinsi" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <small id="emailHelp" class="form-text text-muted">*Opsional</small>
                                    <input type="text" class="form-control <?php if (form_error('latitude')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="latitude" placeholder="Latitude" value="<?= $user['latitude']; ?>">
                                    <?= form_error('latitude', '<small id="latitude" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <small id="emailHelp" class="form-text text-muted">*Opsional</small>
                                    <input type="text" class="form-control <?php if (form_error('longitude')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="longitude" placeholder="Longitude" value="<?= $user['longitude']; ?>">
                                    <?= form_error('longitude', '<small id="longitude" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control <?php if (form_error('jabatan')) {
                                                                                echo 'is-invalid';
                                                                            } ?>" id="jabatan" name="jabatan" value="<?= $user['jabatan']; ?>">
                                    <?= form_error('jabatan', '<small id="jabatan" class="form-text text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nip">Nomor Induk Pegawai</label>
                                    <input type="text" name="nip" id="nip" class="form-control" value="<?= $user['nip']; ?>">
                                    <?= form_error('nip', '<small id="level" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <img class="img-thumbnail img-preview" src="<?= base_url(); ?>assets/images/pegawai/<?= $user['foto']; ?>" alt="Pass Foto">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="passfoto">Pass Foto
                                        <small class="text-muted">*Opsional</small>
                                    </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input <?php if (form_error('passfoto')) {
                                                                                            echo 'is-invalid';
                                                                                        } ?>" id="passfoto" name="passfoto" onchange="previewImg()">
                                            <label class="custom-file-label" for="passfoto">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Pass Foto berwarna</small>
                                    <?= form_error('passfoto', '<small id="passfoto" class="form-text text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row justify-content-end">

                                <button type="submit" class="btn btn-success" id="edit" name="edit">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>