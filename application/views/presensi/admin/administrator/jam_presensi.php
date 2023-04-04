<?php
if (isset($presensi['awal'])) {
    $awal = $presensi['awal'];
} else {
    $awal = '';
}

if (isset($presensi['akhir'])) {
    $akhir = $presensi['akhir'];
} else {
    $akhir = '';
}

?>
<form action="<?= base_url(); ?>admin/editPresensi" method="POST">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <input type="hidden" name="tanggal" value="<?= $tanggal; ?>">
    <!-- <div class="card-body"> -->
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="form-group">
                <label for="waktuDatang">Datang</label>
                <input type="time" class="form-control" id="waktuDatang" name="waktuDatang" value="<?= $awal; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="waktuPulang">Pulang</label>
                <input type="time" class="form-control" id="waktuPulang" name="waktuPulang" value="<?= $akhir; ?>">
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!-- <div class="row"> -->
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success btn-sm mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
        <a href="<?= base_url(); ?>admin/deletePresensi/<?= $id . '_' . $tanggal; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin untuk menghapus data presensi ini?')"><i class="fas fa-trash-alt mr-1"></i>Hapus?</a>
        <!-- </div> -->
    </div>
</form>