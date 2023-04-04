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
                            <a class="nav-link" href="<?= base_url(); ?>admin/company">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url(); ?>admin/logo">Logo</a>
                        </li>
                    </ul>
                    <?php echo form_open_multipart('admin/uploadLogo'); ?>
                    <input type="hidden" name="email" value="<?= $company['email']; ?>">
                    <div class="row mb-3">
                        <div class="col-md-6 text-center mb-3">
                            <img class="img-fluid img-preview" src="<?= base_url(); ?>assets/images/logo.png" alt="Logo" width="60%">
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" aria-describedby="inputGroupFileAddon01" name="file" onchange="imgPreview()" accept="image/*">
                                    <label class="custom-file-label" for="file">Choose file</label>
                                </div>
                            </div>
                            <small class="text-danger error"></small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Ubah Logo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->