$(document).ready(function () {
    const flashData = $('#flash-data').data('flashdata');
    const tanggal = $('#data-tanggal').data('flashdata');
    var inputTanggal = document.getElementById('tanggal');

    if (flashData) {
        var trimmed = flashData.split('|');
        Swal.fire({
            icon: trimmed[0],
            title: trimmed[1],
            html: trimmed[2]
        });
    }

    if(tanggal) {
        inputTanggal.value = tanggal;
        presensiAll();
    }

    $(function () {
        bsCustomFileInput.init();
    });

    var jenisLaporanAdmin = document.getElementById('jenisLaporanAdmin');
    var tanggalLaporanAdmin = document.getElementById('tanggalLaporanAdmin');
    var listPegawaiAdmin = document.getElementById('listPegawaiAdmin');
    var bulanLaporanAdmin = document.getElementById('bulanLaporanAdmin');
    var tahunLaporanAdmin = document.getElementById('tahunLaporanAdmin');
    var tombolTampil = document.getElementById('tombolTampil');
   
    tanggalLaporanAdmin.readOnly = true;
    $('#listPegawaiAdmin').attr('disabled', true);
    $('#bulanLaporanAdmin').attr('disabled', true);
    $('#tahunLaporanAdmin').attr('disabled', true);
    $('#tombolTampil').attr('disabled', true);
    
    jenisLaporanAdmin.addEventListener('change', function() {
        if(jenisLaporanAdmin.value === 'rinci') {
            tanggalLaporanAdmin.readOnly = false;
            $('#listPegawaiAdmin').attr('disabled', false);
            $('#bulanLaporanAdmin').attr('disabled', true);
            $('#tahunLaporanAdmin').attr('disabled', true);
            $('#tombolTampil').attr('disabled', false);
            var pegawaiAll = $('#listPegawaiAdmin option[value="all"]').length;
            if(pegawaiAll == 0) {
                listPegawaiAdmin.options.add(new Option("Pegawai: All", "all"));
            }
        } else if(jenisLaporanAdmin.value === 'rekap') {
            tanggalLaporanAdmin.readOnly = true;
            $('#listPegawaiAdmin').attr('disabled', false);
            $('#bulanLaporanAdmin').attr('disabled', false);
            $('#tahunLaporanAdmin').attr('disabled', false);
            $('#tombolTampil').attr('disabled', false);
            var pegawaiAll = $('#listPegawaiAdmin option[value="all"]').length;
            if(pegawaiAll == 0) {
                listPegawaiAdmin.options.add(new Option("Pegawai: All", "all"));
            }
        } else if(jenisLaporanAdmin.value === 'individu') {
            tanggalLaporanAdmin.readOnly = true;
            $('#listPegawaiAdmin').attr('disabled', false);
            $('#bulanLaporanAdmin').attr('disabled', false);
            $('#tahunLaporanAdmin').attr('disabled', false);
            $('#tombolTampil').attr('disabled', false);
            $('#listPegawaiAdmin option[value="all"]').each(function () {
                $(this).remove();
            });
        }
    });
    tombolTampil.addEventListener('click', function() {
        if(jenisLaporanAdmin.value == 'rinci') {
            var data = tanggalLaporanAdmin.value + '_' + listPegawaiAdmin.value;
        } else {
            var data = listPegawaiAdmin.value + '_' + tahunLaporanAdmin.value + '_' + bulanLaporanAdmin.value;
        }
        showLaporanAdmin(jenisLaporanAdmin.value, data);
    });

});

function imgPreview() {
    const file = document.querySelector('#file');
    const imgPreview = document.querySelector('.img-preview');
    
    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(file.files[0]);

    fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
    }
}

function showLaporanAdmin(jenis, data) {

    var resultlaporanAdmin = document.getElementById('resultLaporanAdmin');

    resultlaporanAdmin.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Mengambil data...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>';
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            resultlaporanAdmin.innerHTML = xhr.responseText;
        }
    }
    xhr.open('GET', jenis + 'laporanAdmin/' + data, true);
    xhr.send();
    
}

function tombolAktif(data) {
    var notif = document.getElementById('notif');
    notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div></div>';
    window.location.href = 'tombolAktif/' + data;
}

function resetPassword(data) {
    var notif = document.getElementById('notif');
    notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div></div>';
    window.location.href = 'resetPassword/' + data;
}

function hapusPermanen(data) {
    var notif = document.getElementById('notif');
    var konfirmasi = confirm('Yakin hapus permanen?');

    if(konfirmasi == true) {
        notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div></div>';
        window.location.href = 'hapusPermanen/' + data;
    } else {
        return;
    }
}

function hapusAbsensi(data) {
    var notif = document.getElementById('notif');
    var konfirmasi = confirm('Yakin hapus permanen?');

    if(konfirmasi == true) {
        notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div></div>';
        window.location.href = 'hapusAbsensi/' + data;
    } else {
        return;
    }
}

function hapusPejabat(data) {
    var notif = document.getElementById('notif');
    var konfirmasi = confirm('Yakin hapus permanen?');
    if(konfirmasi == true) {
        notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div></div>';
        window.location.href = 'hapusPejabat/' + data;
    } else {
        return;
    }
}

function pegdawai(data) {
    var result = document.getElementById('result');
    result.innerHTML = 'ok';
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            result.innerHTML = xhr.responseText;
        }
    }

    xhr.open('GET', data + 'Pegawai/', true);

    xhr.send();
}

function showProfil(data) {
    var result = document.getElementById('resultProfil');
    var idPeg = document.getElementById('idPeg').value;
    result.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Mengambil data...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>';

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            result.innerHTML = xhr.responseText;
        }
    }

    xhr.open('GET', data + 'profil/' + idPeg, true);

    xhr.send();

}

function laporan_submit() {
    var idPegawai = document.getElementById('idPegawai').value;
    var jenis = document.getElementById('jenis').value;
    var bulan = document.getElementById('bulan').value;
    var tahun = document.getElementById('tahun').value;
    var ket = document.getElementById('keterangan');
    var result = document.getElementById('result');
    var notif = document.getElementById('notif');

    if (jenis == 0) {
        result.innerHTML = '<div class="alert alert-danger" role="alert">Pilih jenis laporan terlebih dahulu!</div>';
        return false;
    } else if (jenis == 'rinci') {
        if (bulan == 'all') {
            result.innerHTML = '<div class="alert alert-danger" role="alert">Pilihan bulan harus selain "All"!</div>';
            return false;
        } else {
            result.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Mengambil data...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>';
        }
    } else {
        result.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Mengambil data...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>';
    }

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            result.innerHTML = xhr.responseText;
        }
    }

    if (jenis == 'rinci') {
        // ket.style.display = 'block';
        xhr.open('GET', 'hariKehadiran/' + idPegawai + '_' + tahun + '_' + bulan, true);
    } else if (jenis == 'rekap') {
        // ket.style.display = 'none';
        xhr.open('GET', 'rekapKehadiran/' + tahun + bulan, true)
    } else {
        result.innerHTML = 'System Error';
    }

    xhr.send();

}

function setBulan() {
    var bulan = document.getElementById('bulan');
    var jenispilihan = document.getElementById('jenis');
    var ket = document.getElementById('keterangan');
    var bulanAll = $('#bulan option[value="all"]').length;

    if (jenispilihan.value == 'rekap') {
        ket.style.display = 'none';
        bulan.options.add(new Option("All", "all"));
    } else if (jenispilihan.value == 'rinci') {
        ket.style.display = 'block';
        if (bulanAll == 1) {
            $('#bulan option[value="all"]').each(function () {
                $(this).remove();
            });
        }
    }

}

function previewImg() {
    const passfoto = document.querySelector('#passfoto');
    const imgPreview = document.querySelector('.img-preview');
    
    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(passfoto.files[0]);

    fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
    }

}

function CopyToClipboard() {
    if (document.selection) {
      var range = document.body.createTextRange();
      range.moveToElementText(document.getElementById('copytext'));
      range.select().createTextRange();
      document.execCommand("copy");
    } else if (window.getSelection) {
      var range = document.createRange();
      range.selectNode(document.getElementById('copytext'));
      window.getSelection().addRange(range);
      document.execCommand("copy");
      alert("Password berhasil di salin.")
    }
}

const form = document.getElementById('formGantiPassword');
const oldPassword = document.getElementById('oldPass');
const newPassword = document.getElementById('newPassword');
var newPassword2 = document.getElementById('newPassword2');

newPassword2.addEventListener('keyup', function() {
    const newPasswordValue = newPassword.value.trim();
    const newPassword2Value = newPassword2.value.trim();

    if(newPasswordValue != newPassword2Value) {
        setErrorFor(newPassword2, 'Password tidak sama!');
    } else {
        setSuccessFor(newPassword2);
        setSuccessFor(newPassword);
    }
});

form.addEventListener('submit', (e) => {
    e.preventDefault();
    checkInputs();
    form.submit();
});

function checkInputs() {
    const oldPasswordValue = oldPassword.value.trim();
    const newPasswordValue = newPassword.value.trim();
    const newPassword2Value = newPassword2.value.trim();

    if( oldPasswordValue === '' ) {
        setErrorFor(oldPassword, 'Input ini dibutuhkan!');
		return;
    } else {
        setSuccessFor(oldPassword);
    }
    
    if( newPasswordValue === '' ) {
        setErrorFor(newPassword, 'Input ini dibutuhkan!');
		return;
    } else {
        setSuccessFor(newPassword);
    }
    
    if( newPassword2Value === '' ) {
        setErrorFor(newPassword2, 'Input ini dibutuhkan!');
		return;
    } else {
        setSuccessFor(newPassword2);
    }
    
    if(newPasswordValue != newPassword2Value) {
        setErrorFor(newPassword, 'Password tidak sama!');
        setErrorFor(newPassword2, 'Password tidak sama!');
		return;
    } 
}

function setErrorFor(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
   
    input.className = 'form-control is-invalid';
    small.innerText = message;
}

function setSuccessFor(input) {
	const formControl = input.parentElement;
	input.className = 'form-control is-valid';
}

function reqAktif(id) {
    var notif = document.getElementById('notif');
    notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ml-auto" role="status" aria-hidden="true"></div></div></div>';
    window.location.href = 'reqAktif/' + id;
}

function presensiAll() {
    var tanggal = document.getElementById('tanggal');
    var result = document.getElementById('result');
    var error = document.getElementById('tanggalFeedback');
    var idPeg = document.getElementById('namaPegawai');
    var jam = document.getElementById('jamPresensi');

    error.innerText = '';
    tanggal.className = 'form-control is-valid';
    idPeg.value = 0;
    jam.style.display = 'none';

    result.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Mengambil data...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>';
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            result.innerHTML = xhr.responseText;
        }
    }

    xhr.open('GET', 'presensiPegawai/' + tanggal.value, true);

    xhr.send();

    // $("#result").load("presensiPegawai/" + tanggal);

}

function lihatPresensi() {
    var idPeg = document.getElementById('namaPegawai').value;
    var error = document.getElementById('tanggalFeedback');
    var tanggal = document.getElementById('tanggal');
    var jam = document.getElementById('jamPresensi');
    var waktuDatang = document.getElementById('waktuDatang');
    var waktuPulang = document.getElementById('waktuPulang');

    if(!tanggal.value) {
        error.innerText = 'Pilih tanggal terlebih dahulu!';
        tanggal.className = 'form-control is-invalid';
    } else {
        jam.style.display = 'block';

        var xhr = new XMLHttpRequest();
    
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                jam.innerHTML = xhr.responseText;
            }
        }
    
        xhr.open('GET', 'lihatPresensi/' + idPeg + '_' + tanggal.value, true);
    
        xhr.send();
    }
}

function toggleTahun(data) {
    var notif = document.getElementById('notif');
    notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Prosessing...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>'
    window.location.href = 'toggleTahun/' + data;
}

function deleteTahun(data) {
    var notif = document.getElementById('notif');
    notif.innerHTML = '<div class="alert alert-info" role="alert"><div class="d-flex align-items-center"><strong>Prosessing...</strong><div class="spinner-border text-primary ml-auto" role="status" aria-hidden="true"></div></div></div>'
    var konfirm1 = confirm('Apakah anda yakin?');
    if(konfirm1 == true) {
        var konfirm2 = confirm('Data akan dihapus!');
        if(konfirm2 == true) {
            var konfrim3 = confirm('Sudah yakin?');
            if(konfrim3 == true) {
                window.location.href = 'hapusTahun/' + data;
            }
        }
    }
    return
}