<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Presensi_model');
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $tanggal        = date('N');
        $namaHari       = $this->namaHari($tanggal);
        $namaBulan      = $this->namaBulan(date('n'));
        $tanggalLengkap = date('Y') . date('m') . date('d');
        $hariTanggal    = $namaHari . ', ' . date('j') . ' ' . $namaBulan . ' ' . date('Y');
        $dataCompany    = $this->Presensi_model->getCompany();

        $hari           = $this->Presensi_model->getHariAktif($tanggal);
        if ($hari['is_active'] == 0) {
            $statusHari     = 'danger';
            $keteranganHari = '<i class="fas fa-exclamation-triangle fa-fw"></i> Hari ini tidak aktif!!! <i class="fas fa-exclamation-triangle fa-fw"></i>';
        } else {
            $statusHari     = 'success';
            $keteranganHari = '';
        }

        $hariLibur      = $this->Presensi_model->getHariLibur($tanggalLengkap);
        if ($hariLibur) {
            $statusHari     = 'danger';
            $keteranganHari = '<i class="fas fa-exclamation-triangle fa-fw"></i> ' . $hariLibur['jenis_libur'] . ': ' . $hariLibur['keterangan'] . ' <i class="fas fa-exclamation-triangle fa-fw"></i>';
        }

        $data   = [
            'title'         => 'ePresensi',
            'statusHari'    => $statusHari,
            'kethari'       => $keteranganHari,
            'hariTanggal'   => $hariTanggal,
            'dataCompany'   => $dataCompany
        ];

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/presensi/header', $data);
            $this->load->view('template/presensi/navbar');
            $this->load->view('presensi/index');
            $this->load->view('template/presensi/modals');
            $this->load->view('template/presensi/script');
            $this->load->view('template/presensi/footer');
            $this->session->unset_userdata('message');
        } else {
            if (isset($_POST['absen'])) {
                if ($this->loginCheck() == true) {
                    // if ($this->_cekLoc() == true) {
                    if ($this->_cekAktif() == true) {
                        $this->_presensi();
                    }
                    // }
                } else {
                    redirect('presensi/');
                }
            }

            if (isset($_POST['login'])) {
                if ($this->loginCheck() == true) {
                    $this->session->set_flashdata('message', 'success|Login sukses|Username dan password sesuai!');
                    redirect('admin');
                } else {
                    redirect('presensi/');
                }
            }
        }
    }

    public function directLogin()
    {
        $email  = $this->input->post('email');
        $pass   = $this->input->post('password');

        $result = $this->Login_model->ceklogin($email, $pass);
        if ($result) {
            $this->session->set_flashdata('message', 'success|Login sukses|Username dan password sesuai!');
            redirect('admin');
        } else {
            redirect('presensi/');
        }
    }

    public function loginCheck()
    {
        $email  = $this->input->post('email');
        $pass   = $this->input->post('password');

        return $this->Login_model->ceklogin($email, $pass);
    }

    private function _cekLoc()
    {
        $lat            = $this->input->post('latitude');
        $long           = $this->input->post('longitude');

        if ($lat or $long == 0) {
            return true;
        } else {
            $this->session->set_flashdata('message', '
            error|Lokasi tidak ditemukan!|
            Lokasi dari perangkat anda tidak terdeteksi' . "<br>" .
                'Hidupkan GPS dan ijinkan browser ini mengakses lokasi anda, 
                atau ganti dengan protokol https dengan cara edit di address bar. (ganti http:// dengan https://)');
            // $this->session->unset_userdata('user');
            redirect('presensi/');
        }
    }

    private function _cekAktif()
    {
        $id             = $_SESSION['user']['id'];
        $user           = $this->Presensi_model->getDataPegawai($id);

        if ($user['aktif_peg'] == 0) {
            $this->session->set_flashdata('message', 'error|User tidak Aktif|Silahkan mengajukan keaktifan akun melalui Admin Page pada pojok kanan atas, kemudian pilih menu data pengguna');
            redirect('presensi/');
        } else {
            return true;
        }
    }

    private function _presensi()
    {
        $id             = $_SESSION['user']['id'];
        $nama           = $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'];
        $lat            = $this->input->post('latitude');
        $long           = $this->input->post('longitude');
        $now            = now();
        $date           = date('Y-n-j', $now);
        $time           = date('G:i:s', $now);
        $ip             = $this->getIPAddress();
        $browser        = $this->getBrowser();
        $device         = $this->getSystemInfo()['device'];
        $os             = $this->getSystemInfo()['os'];
        $deviceName     = $this->getDeviceName();
        $tanggal        = date('N');
        $namaHari       = $this->namaHari($tanggal);
        $namaBulan      = $this->namaBulan(date('n'));
        $tanggalLong    = $namaHari . ', ' . date('j') . ' ' . $namaBulan . ' ' . date('Y');

        $data = [
            'id'            => null,
            'latitude'      => $lat,
            'longitude'     => $long,
            'tanggal'       => $date,
            'waktu'         => $time,
            'id_peg'        => $id,
            'ip_addr'       => $ip,
            'browser'       => $browser,
            'device_type'   => $device,
            'os'            => $os,
            'device_name'   => $deviceName
        ];

        $result = $this->Presensi_model->setPresensi($data);

        if ($result) {
            $this->session->set_flashdata('message', 'success|Presensi berhasil di simpan|' . $nama . "<br><br>" . $tanggalLong . "<br>" . $time . "<br>" .
                "<i class='fas fa-map-marked-alt fa-fw me-1'></i>" .
                "<a class='text-decoration-none' target='blank' href='https://www.google.com/maps/search/" .
                $lat . "," . $long . "'>" .
                $lat . "," . $long . "</a>");
            redirect('presensi');
        }
    }

    public function registrasi()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[data_pegawai.email]');
        $this->form_validation->set_rules('telp', 'Telephone', 'required|trim');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempatLahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggalLahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required');
        $this->form_validation->set_rules('rt', 'RT', 'required');
        $this->form_validation->set_rules('rw', 'RW', 'required');
        $this->form_validation->set_rules('desa', 'Desa', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'required');

        $dataCompany = $this->Presensi_model->getCompany();
        $data   = [
            'title' => 'Registrasi -  ePresensi',
            'dataCompany' => $dataCompany
        ];

        if ($this->form_validation->run() == false) {
            $this->load->view('template/presensi/header', $data);
            $this->load->view('template/presensi/navbar');
            $this->load->view('presensi/registrasi');
            $this->load->view('template/presensi/modals');
            $this->load->view('template/presensi/script');
            $this->load->view('template/presensi/footer');
            $this->session->unset_userdata('message');
        } else {
            if ($this->_registrasi() == true) {
                redirect('presensi');
            }
        }
    }

    private function _registrasi()
    {
        $tipe = 'pegawai';
        $email = $this->input->post('email');
        $telp = $this->input->post('telp');
        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $jk = $this->input->post('jenisKelamin');
        $tempatLahir = $this->input->post('tempatLahir');
        $tanggalLahir = $this->input->post('tanggalLahir');
        $lat = $this->input->post('latitude');
        $long = $this->input->post('longitude');
        $dusun = $this->input->post('dusun');
        $rt = $this->input->post('rt');
        $rw = $this->input->post('rw');
        $desa = $this->input->post('desa');
        $kecamatan = $this->input->post('kecamatan');
        $kabupaten = $this->input->post('kabupaten');
        $provinsi = $this->input->post('provinsi');
        $jabatan = $this->input->post('jabatan');
        $nip = $this->input->post('nip');

        $password = random_string('alnum', 6);
        $passhash = password_hash($password, PASSWORD_DEFAULT);

        $upload_file = $_FILES['passfoto']['name'];

        if ($upload_file) {
            $nama_file = $this->_upload($tipe);
        } else {
            $nama_file = 'default.jpg';
        }

        $data = [
            'id' => null,
            'email' => $email,
            'password' => $passhash,
            'first_name' => $fname,
            'last_name' => $lname,
            'jk' => $jk,
            'tempat_lahir'  => $tempatLahir,
            'tanggal_lahir' => $tanggalLahir,
            'latitude'      => $lat,
            'longitude'     => $long,
            'nama_dusun'    => $dusun,
            'rt'            => $rt,
            'rw'            => $rw,
            'nama_desa'     => $desa,
            'nama_kecamatan'    => $kecamatan,
            'nama_kabupaten'    => $kabupaten,
            'nama_provinsi'     => $provinsi,
            'no_telp'           => $telp,
            'jabatan'           => $jabatan,
            'foto'              => $nama_file,
            'nip' => $nip,
            'aktif_peg'         => 1,
        ];

        $this->session->set_flashdata('message', 'success|Data pegawai berhasil ditambah!|' .
            "
        <table class='table table-sm table-borderless table-hover text-start'>
            <tr><td>Nama</td><td>" . $fname . " " . $lname . "</td></tr>
            <tr><td>Email</td><td>" . $email . "</td></tr>
            <tr><td>Password</td><td>" . $password . "</td></tr>
        </table>
        ");

        return $this->db->insert('data_pegawai', $data);
    }

    private function _upload($data)
    {
        $config['upload_path']          = './assets/images/' . $data . '/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 2048;
        $config['remove_spaces']        = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('passfoto')) {
            $nama_file = $this->upload->data('file_name');
            return $nama_file;
        } else {
            $this->session->set_flashdata('pegawai', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Upload error, ' . $this->upload->display_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/tambahpegawai');
        }
    }

    public static function getSystemInfo()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform    = "Unknown OS Platform";
        $os_array       = array(
            '/windows phone 8/i'    =>  'Windows Phone 8',
            '/windows phone os 7/i' =>  'Windows Phone 7',
            '/Windows NT 10.0/i'    =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        $found = false;
        $device = '';
        foreach ($os_array as $regex => $value) {
            if ($found)
                break;
            else if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
                $device = !preg_match('/(windows|mac|linux|ubuntu)/i', $os_platform)
                    ? 'Mobile' : (preg_match('/phone/i', $os_platform) ? 'Mobile' : 'OS');
            }
        }
        $device = !$device ? 'OS' : $device;
        return array('os' => $os_platform, 'device' => $device);
    }

    public static function getBrowser()
    {
        $found = false;

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        =   "Unknown Browser";

        $browser_array  = array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Mobile Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if ($found)
                break;
            else if (preg_match($regex, $user_agent, $result)) {
                $browser    =   $value;
            }
        }
        return $browser;
    }

    public function getDeviceName()
    {
        $device = $this->getSystemInfo()['device'];

        if ($device == 'OS') {
            return gethostbyaddr($_SERVER['REMOTE_ADDR']);
        } else if ($device == 'Mobile') {
            $str        = $_SERVER['HTTP_USER_AGENT'];
            $mula       = strpos($str, '(');
            $akhir      = strpos($str, ')');
            $jumlah     = $akhir - $mula;
            $device     = substr($str, $mula + 1, $jumlah - 1);
            $device     = explode(';', $device);
            $infoDevice = $device[2];

            return $infoDevice;
        }
    }

    public function getIPAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function namaBulan($data)
    {

        switch ($data) {
            case 1:
                return 'Januari';
                break;
            case 2:
                return 'Februari';
                break;
            case 3;
                return 'Maret';
                break;
            case 4;
                return 'April';
                break;
            case 5;
                return 'Mei';
                break;
            case 6;
                return 'Juni';
                break;
            case 7;
                return 'Juli';
                break;
            case 8;
                return 'Agustus';
                break;
            case 9;
                return 'September';
                break;
            case 10;
                return 'Oktober';
                break;
            case 11;
                return 'November';
                break;
            case 12;
                return 'Desember';
                break;
            default:
                return false;
                break;
        }
    }

    public function namaHari($data)
    {
        switch ($data) {
            case 1:
                return 'Senin';
                break;
            case 2:
                return 'Selasa';
                break;
            case 3:
                return 'Rabu';
                break;
            case 4:
                return 'Kamis';
                break;
            case 5:
                return 'Jumat';
                break;
            case 6:
                return 'Sabtu';
                break;
            case 7:
                return 'Minggu';
                break;

            default:
                return false;
                break;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->set_flashdata('message', 'success|Logout Sukses|Terimakasih sudah menggunakan layanan ini');
        redirect('presensi/');
    }
}
