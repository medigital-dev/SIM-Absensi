<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            redirect('presensi/');
        }
        $this->load->model('Admin_model');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('form_validation');
        $this->notifikasi();
    }

    public function notifikasi()
    {
        $dataAktifvasi = $this->Admin_model->getReqAktivasiAll();
        $this->session->set_userdata('notif', $dataAktifvasi);
    }

    public function index()
    {
        $id             = $_SESSION['user']['id'];
        $bulan          = date('n');
        $tahun          = date('Y');
        $jumlahHari     = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tglAwal        = $tahun . '-' . $bulan . '-' . 1;
        $tglAkhir       = $tahun . '-' . $bulan . '-' . $jumlahHari;
        $absenAll       = $this->getLogAbsen($id, $tglAwal, $tglAkhir);
        $jumlahHari     = $this->getTanggalHadir($id, $bulan, $tahun);
        $hariEfektif    = $this->getTanggalSelainLibur($bulan, $tahun);

        $jamDatang = '';
        $jamPulang = '';
        $jamHadir = '';
        for ($i = 1; $i <= count($jumlahHari); $i++) {
            $tanggal = $tahun . '-' . $bulan . '-' . $i;
            $dataPresensi = $this->getJamAbsen($id, $tanggal);
            if ($dataPresensi) {
                $datang = $this->toSatuan(substr($dataPresensi['awal'], 0, 2));
                $pulang = $this->toSatuan(substr($dataPresensi['akhir'], 0, 2));
                $selisih = $pulang - $datang;
                $jamDatang .= $datang . '|';
                $jamPulang .= $pulang . '|';
                $jamHadir .= $selisih . '|';
            } else {
                $jamDatang .= 0 . '|';
                $jamPulang .= 0 . '|';
                $jamHadir .= 0 . '|';
            }
        }
        $this->session->set_flashdata('jamDatang', $jamDatang);
        $this->session->set_flashdata('jamPulang', $jamPulang);
        $this->session->set_flashdata('jamHadir', $jamHadir);

        $dataAbsensi = $this->hitungAbsensi($id, $bulan, $tahun);
        $persenPresensi = [
            'hadir' => number_format(count($jumlahHari) / $hariEfektif['jumlah'] * 100, 0),
            'absen' => number_format(($hariEfektif['jumlah'] - count($jumlahHari) - $dataAbsensi['izin'] - $dataAbsensi['sakit'] - $dataAbsensi['cuti'] - $dataAbsensi['dinasLuar']) * 100 / $hariEfektif['jumlah'], 0),
            'izin' => number_format($dataAbsensi['izin'] / $hariEfektif['jumlah'] * 100, 0),
            'sakit' => number_format($dataAbsensi['sakit'] / $hariEfektif['jumlah'] * 100, 0),
            'cuti' => number_format($dataAbsensi['cuti'] / $hariEfektif['jumlah'] * 100, 0),
            'dinasLuar' => number_format($dataAbsensi['dinasLuar'] / $hariEfektif['jumlah'] * 100, 0)
        ];

        $chartPresensi = $persenPresensi['hadir'] . '|' . $persenPresensi['absen'] . '|' . $persenPresensi['izin'] . '|' . $persenPresensi['sakit'] . '|' . $persenPresensi['cuti'] . '|' . $persenPresensi['dinasLuar'];

        $this->session->set_flashdata('chart-presensi', $chartPresensi);

        $data           = [
            'title'             => 'Admin - ePresensi',
            'sidebar'           => 'dashboard',
            'presensi'          => $absenAll,
            'jumlahHari'        => count($jumlahHari),
            'jumlahHariEfektif' => $hariEfektif['jumlah'],
            'persenHadir'       => number_format(count($jumlahHari) / $hariEfektif['jumlah'] * 100, 0)
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/index');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/chart-jam-presensi');
        $this->load->view('template/sbadmin2/chart-presensi');
        $this->load->view('template/sbadmin2/footer');

        $this->session->unset_userdata('message');
    }

    public function getLogAbsen($id, $tglAwal, $tglAkhir)
    {
        $data = $this->Admin_model->getPresensi($id, $tglAwal, $tglAkhir);
        return $data;
    }

    public function getTanggalHadir($id, $bulan, $tahun)
    {
        if ($bulan == 'all') {
            $tglAwal = $tahun . '-' . $this->toPuluhan(1) . '-' . $this->toPuluhan(1);
            $tglAkhir = $tahun . '-' . $this->toPuluhan(12) . '-' . $this->toPuluhan(31);
        } else {
            $jumlahBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $tglAwal = $tahun . '-' . $this->toPuluhan($bulan) . '-' . $this->toPuluhan(1);
            $tglAkhir = $tahun . '-' . $this->toPuluhan($bulan) . '-' . $jumlahBulan;
        }

        $data = $this->Admin_model->getTanggalHadir($id, $tglAwal, $tglAkhir);
        $jml    = count($data);
        $a = [];
        for ($i = 1; $i < $jml; $i++) {
            array_push($a, $data[$i]['tanggal']);
        }
        return array_unique($a);
    }

    public function kehadiran()
    {
        $id             = $_SESSION['user']['id'];
        $bulan          = date('m');
        $tahun          = date('Y');
        $jumlahHari     = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tglAwal        = $tahun . '-' . $bulan . '-' . 1;
        $tglAkhir       = $tahun . '-' . $bulan . '-' . $jumlahHari;
        $presensi       = $this->getLogAbsen($id, $tglAwal, $tglAkhir);
        $jumlahHari     = $this->getTanggalHadir($id, $bulan, $tahun);
        $hariEfektif    = $this->getTanggalSelainLibur($bulan, $tahun);

        $data           = [
            'title'         => 'Log - ePresensi',
            'sidebar'       => 'logKehadiran',
            'presensi'      => $presensi,
            'jmlHari'       => count($jumlahHari),
            'hariEfektif'   => count($hariEfektif)
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/data_hadir');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('message');
    }

    public function laporan()
    {
        $id             = $_SESSION['user']['id'];
        $jamKerja       = $this->Admin_model->getJamKerja();
        $kodeBulan      = date('n');
        $namaBulan      = $this->namaBulan($kodeBulan);
        $tahun          = date('Y');

        $data           = [
            'title'         => 'Laporan - ePresensi',
            'sidebar'       => 'laporan',
            'bulan'         => $kodeBulan,
            'namaBulan'     => $namaBulan,
            'tahun'         => $tahun,
            'jamMasuk'      => $jamKerja['jam_masuk'],
            'jamPulang'     => $jamKerja['jam_pulang'],
            'jamKerja'      => $jamKerja['jumlah_jam']
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/laporan');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('message');
    }

    public function rekapKehadiran($data)
    {
        $id             = $_SESSION['user']['id'];
        $tahun          = substr($data, 0, 4);
        $end            = strlen($data,);
        $bulan          = substr($data, 4, $end);
        $hitungTerlambatPulangCepat = $this->hitungPresensi($id, $bulan, $tahun);

        if ($bulan == 'all') {
            $tglAwal        = $tahun . '-' . 1 . '-' . 1;
            $tglAkhir       = $tahun . '-' . 12 . '-' . 31;
            $tglAwalC       = date_create($tglAwal);
            $tglAkhirC      = date_create($tglAkhir);
            $selisihHari    = date_diff($tglAwalC, $tglAkhirC);
            $jumlahHari     = $selisihHari->days;
        } else {
            $jumlahHari     = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $tglAwal        = $tahun . '-' . $bulan . '-' . 1;
            $tglAkhir       = $tahun . '-' . $bulan . '-' . $jumlahHari;
        }

        $presensi       = $this->getLogAbsen($id, $tglAwal, $tglAkhir);
        $dataHariLibur  = $this->getTanggalSelainLibur($bulan, $tahun);
        $kehadiran      = $this->getTanggalHadir($id, $bulan, $tahun);
        $dataAbsensi    = $this->hitungAbsensi($id, $bulan, $tahun);
        $jamKerja       = $this->Admin_model->getJamKerja();
        $jumlahHariLibur = $jumlahHari - $dataHariLibur['jumlah'];

        $data = [
            'totalHari'         => $jumlahHari,
            'jumlahhari'        => $jumlahHari,
            'namaBulan'         => $this->namaBulan($bulan),
            'tahun'             => $tahun,
            'jumlahHari'        => $dataHariLibur['jumlah'],
            'daftarTanggal'     => $dataHariLibur['daftarTanggalAktif'],
            'log'               => count($presensi),
            'jumlahKehadiran'   => count($kehadiran),
            'jumlahTerlambat'   => $hitungTerlambatPulangCepat['jumlahTerlambat'],
            'jumlahPulangCepat' => $hitungTerlambatPulangCepat['jumlahPulangCepat'],
            'jumlahHariLibur'   => $jumlahHariLibur,
            'jumlahSakit'       => $dataAbsensi['sakit'],
            'jumlahIzin'        => $dataAbsensi['izin'],
            'jumlahCuti'        => $dataAbsensi['cuti'],
            'jumlahDinasLuar'   => $dataAbsensi['dinasLuar'],
            'jumlahAbsen'       => $dataHariLibur['jumlah'] - count($kehadiran),
            'persenKehadiran'   => number_format(count($kehadiran) / $dataHariLibur['jumlah'] * 100, 2)
        ];

        $this->load->view('presensi/admin/kehadiran/data-rekap.php', $data);
    }

    public function getAbsensi($id, $tglAwal, $tglAkhir)
    {
        $dataAbsensi = $this->Admin_model->getAbsensi($id, $tglAwal, $tglAkhir);
        return $dataAbsensi;
    }

    public function hariKehadiran($data)
    {
        $data               = explode('_', $data);
        $id                 = $data[0];
        $tahun              = $data[1];
        $bulan              = $data[2];

        if ($bulan == 'all') {
            $awalBulan = 1;
            $akhirBulan = 12;
        } else {
            $awalBulan = $bulan;
            $akhirBulan = $bulan;
        }

        $infoPresensi       = [];

        $nomor = 1;
        for ($j = $awalBulan; $j <= $akhirBulan; $j++) {
            $jumlahHari         = cal_days_in_month(CAL_GREGORIAN, $j, $tahun);
            $tahunbulanString   = $tahun . '-' . $j . '-';

            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggal        = $tahunbulanString . $i;
                $tanggalC       = date_create_from_format('Y-n-j', $tanggal);
                $namaHari       = $this->namaHari($tanggalC->format('N'));

                $jamAbsen       = $this->getJamAbsen($id, $tanggal);

                if ($jamAbsen == false) {
                    $jamKehadiran   = '';
                    $absenAwal      = '';
                    $absenAkhir     = '';
                    $jamHadir       = '';

                    $absen = [
                        'absenAwal'     => $absenAwal,
                        'absenAkhir'    => $absenAkhir,
                    ];
                } else {
                    $absenAwal      = $tanggal . ' ' . $jamAbsen['awal'];
                    $absenAkhir     = $tanggal . ' ' . $jamAbsen['akhir'];

                    $absenAwalC     = date_create_from_format('Y-m-d H:i:s', $absenAwal);
                    $absenAkhirC    = date_create_from_format('Y-m-d H:i:s', $absenAkhir);
                    $jamKehadiran   = date_diff($absenAwalC, $absenAkhirC);
                    $jamHadir       = $jamKehadiran->format("%H Jam, %i Menit");

                    $absen = [
                        'absenAwal'     => $absenAwalC->format('H:i:s'),
                        'absenAkhir'    => $absenAkhirC->format('H:i:s'),
                    ];
                }
                $statusAbsen        = $this->cekStatusAbsen($id, $tanggal);
                $info = [
                    'nomor'         => $nomor,
                    'tanggal'       => $tanggalC->format('d-m-Y'),
                    'namaHari'      => $namaHari,
                    'absenAwal'     => $absen['absenAwal'],
                    'absenAkhir'    => $absen['absenAkhir'],
                    'jamHadir'      => $jamHadir,
                    'statusAbsen'   => $statusAbsen
                ];
                array_push($infoPresensi, $info);
                $nomor++;
            }
        }


        $data = [
            'jumlahhari'    => $jumlahHari,
            'namaBulan'     => $this->namaBulan($bulan),
            'tahun'         => $tahun,
            'infoPresensi'  => $infoPresensi
        ];

        $this->load->view('presensi/admin/kehadiran/data-rinci.php', $data);
    }

    public function getJamAbsen($id, $tanggal)
    {
        $result         = $this->Admin_model->getJamAbsen($id, $tanggal);
        $jumlahResult   = count($result);

        if ($jumlahResult == 0) {
            return false;
        } else {
            $jamAbsenAll = [];
            for ($i = 0; $i < $jumlahResult; $i++) {
                $jam = $result[$i]['waktu'];
                array_push($jamAbsenAll, $jam);
            }

            $jamAbsen = [
                'awal' => min($jamAbsenAll),
                'akhir' => max($jamAbsenAll)
            ];

            return $jamAbsen;
        }
    }

    public function deletePresensi($data)
    {
        $data = explode('_', $data);
        $id = $data[0];
        $tanggal = $data[1];
        $result = $this->Admin_model->detelePresensi($id, $tanggal);

        if ($result) {
            $this->session->set_flashdata('pegawai', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Kehadiran berhasil di hapus!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            $this->session->set_flashdata('tanggal', $tanggal);
            redirect('admin/kehadiranPegawai');
        }
    }

    public function editPresensi()
    {
        $id = $this->input->post('id');
        $tanggal = $this->input->post('tanggal');
        $awal = $this->input->post('waktuDatang');
        $akhir = $this->input->post('waktuPulang');

        $result = $this->Admin_model->detelePresensi($id, $tanggal);

        if ($result) {
            $data = [
                'id'            => null,
                'latitude'      => null,
                'longitude'     => null,
                'tanggal'       => $tanggal,
                'waktu'         => $awal,
                'id_peg'        => $id,
                'ip_addr'       => '',
                'browser'       => '',
                'device_type'   => '',
                'os'            => '',
                'device_name'   => ''
            ];

            $this->Admin_model->setPresensi($data);

            $data = [
                'id'            => null,
                'latitude'      => null,
                'longitude'     => null,
                'tanggal'       => $tanggal,
                'waktu'         => $akhir,
                'id_peg'        => $id,
                'ip_addr'       => '',
                'browser'       => '',
                'device_type'   => '',
                'os'            => '',
                'device_name'   => ''
            ];

            $this->Admin_model->setPresensi($data);
        }
        $this->session->set_flashdata('pegawai', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Kehadiran berhasil di ubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        $this->session->set_flashdata('tanggal', $tanggal);
        redirect('admin/kehadiranPegawai');
    }

    public function lihatPresensi($data)
    {
        $data = explode('_', $data);
        $id = $data[0];
        $tanggal = $data[1];

        $dataPresensi = $this->getJamAbsen($id, $tanggal);

        $data = [
            'id' => $id,
            'tanggal' => $tanggal,
            'presensi' => $dataPresensi
        ];

        $this->load->view('presensi/admin/administrator/jam_presensi.php', $data);
    }

    public function hitungPresensi($id, $bulan, $tahun)
    {
        if ($bulan == 'all') {
            $jumlahBulan    = 12;
            $awal           = 1;
        } else {
            $jumlahBulan    = $bulan;
            $awal           = $bulan;
        }
        $jamKerja           = $this->Admin_model->getJamKerja();

        $jumlahTerlambat    = [];
        $jumlahPulangCepat  = [];

        for ($i = $awal; $i <= $jumlahBulan; $i++) {
            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
            for ($j = 1; $j <= $jumlahHari; $j++) {
                $tanggal = $tahun . '-' . $i . '-' . $j;
                $presensi = $this->getJamAbsen($id, $tanggal);

                if ($presensi) {
                    if ($presensi['awal'] > $jamKerja['jam_masuk']) {
                        array_push($jumlahTerlambat, $presensi['awal']);
                    }

                    if ($presensi['akhir'] < $jamKerja['jam_pulang']) {
                        array_push($jumlahPulangCepat, $presensi['akhir']);
                    }
                }
            }
        }

        $data = [
            'jumlahTerlambat'   => count($jumlahTerlambat),
            'jumlahPulangCepat' => count($jumlahPulangCepat)
        ];

        return $data;
    }

    public function cekStatusAbsen($id, $tanggal)
    {
        $this->db->select('first_name');
        $this->db->select('last_name');
        $user = $this->Admin_model->getDataPegawai($id);

        $namaPegawai        = $user['first_name'] . ' ' . $user['last_name'];
        $jamPresensi        = $this->getJamAbsen($id, $tanggal);
        $jamKerja           = $this->Admin_model->getJamKerja();
        $kodeHariNonAktif   = $this->getKodeHariNonAktif();
        $tanggalC           = date_create_from_format('Y-m-d', $tanggal);
        $kodeHariIni        = $tanggalC->format('N');
        $namaHariIni        = $this->namaHari($kodeHariIni);
        $dataAbsensi        = $this->Admin_model->getAbsensiByTanggal($id, $tanggal);
        $dataHariLibur      = $this->getTanggalLibur($tanggal);
        $aktifDay           = in_array($tanggalC->format('N'), $kodeHariNonAktif);
        $logicHariLibur     = $dataAbsensi || $dataHariLibur || $aktifDay;

        if ($jamPresensi) {
            $jamPresensiDatang = $jamPresensi['awal'];
            $jamPresensiPulang = $jamPresensi['akhir'];
            $jamPresensiDatangC = date_create_from_format('H:i:s', $jamPresensiDatang);
            $jamPresensiPulangC = date_create_from_format('H:i:s', $jamPresensiPulang);
            $selisihJam = date_diff($jamPresensiDatangC, $jamPresensiPulangC);
            $jamKehadiran = $selisihJam->format('%H Jam, %i Menit');
        } else {
            $jamPresensiDatang = '';
            $jamPresensiPulang = '';
            $jamKehadiran = '';
        }

        if ($logicHariLibur == true) {
            if ($dataHariLibur) {
                $statusAbsenAwal    = $statusAbsenAkhir = $statusJamKehadiran   = 'text-success';
                $iconAbsenAwal      = $iconAbsenAkhir   = $iconJamKehadiran     = '<i class="fas fa-check-circle fa-fw"></i>';
                $statusAbsenTotal                                               = 'text-success';
                $iconStatusAbsenTotal                                           = '<i class="fas fa-check-circle fa-fw"></i>';
                $keterangan                                                     = $dataHariLibur[0]['jenis_libur'];
            } else if (in_array($kodeHariIni, $kodeHariNonAktif)) {
                $statusAbsenAwal    = $statusAbsenAkhir = $statusJamKehadiran   = 'text-success';
                $iconAbsenAwal      = $iconAbsenAkhir   = $iconJamKehadiran     = '<i class="fas fa-check-circle fa-fw"></i>';
                $statusAbsenTotal                                               = 'text-success';
                $iconStatusAbsenTotal                                           = '<i class="fas fa-check-circle fa-fw"></i>';
                $keterangan                                                     = $namaHariIni;
            } else if ($dataAbsensi) {
                $statusAbsenAwal    = $statusAbsenAkhir = $statusJamKehadiran   = 'text-primary';
                $iconAbsenAwal      = $iconAbsenAkhir   = $iconJamKehadiran     = '<i class="fas fa-check-circle fa-fw"></i>';
                $statusAbsenTotal                                               = 'text-primary';
                $iconStatusAbsenTotal                                           = '<i class="fas fa-check-circle fa-fw"></i>';
                $keterangan                                                     = $dataAbsensi['jenis'];
            } else {
                $statusAbsenAwal    = $statusAbsenAkhir = $statusJamKehadiran   = 'text-danger';
                $iconAbsenAwal      = $iconAbsenAkhir   = $iconJamKehadiran     = '<i class="fas fa-times-circle fa-fw"></i>';
                $statusAbsenTotal                                               = 'text-danger';
                $iconStatusAbsenTotal                                           = '<i class="fas fa-times-circle fa-fw"></i>';
                $keterangan                                                     = 'Tidak Presensi!';
            }
        } else {

            if (!$jamPresensi) {
                $statusAbsenAwal    = $statusAbsenAkhir = $statusJamKehadiran       = '';
                $iconAbsenAwal      = $iconAbsenAkhir   = $iconJamKehadiran         = '<i class="fas fa-clock fa-fw"></i>';
                $statusAbsenTotal                                                   = 'text-danger';
                $iconStatusAbsenTotal                                               = '<i class="fas fa-times-circle fa-fw"></i>';
                $keterangan                                                         = 'Tidak Presensi';
            } else if ($jamPresensi['awal'] == $jamPresensi['akhir']) {
                $statusAbsenAwal    = $statusAbsenAkhir = $statusJamKehadiran       = 'text-warning';
                $iconAbsenAwal      = $iconAbsenAkhir   = $iconJamKehadiran         = '<i class="fas fa-clock fa-fw"></i>';
                $statusAbsenTotal                                                   = 'text-danger';
                $iconStatusAbsenTotal                                               = '<i class="fas fa-times-circle fa-fw"></i>';
                $keterangan                                                         = 'Absen hanya 1 kali';
            } else if ($jamPresensi['awal'] != $jamPresensi['akhir']) {
                $tahunBulanTanggalMasuk     = $tanggal . ' ' . $jamKerja['jam_masuk'];
                $tahunBulanTanggalPulang    = $tanggal . ' ' . $jamKerja['jam_pulang'];
                $tahunBulanTanggalJumlah    = $tanggal . ' '  . $jamKerja['jumlah_jam'];

                $jamMasuk                   = date_create($tahunBulanTanggalMasuk);
                $jamPulang                  = date_create($tahunBulanTanggalPulang);
                $jumlahJamKerja             = date_create($tahunBulanTanggalJumlah);
                $absenMasuk                 = date_create_from_format('Y-m-d H:i:s', $tanggal . ' ' . $jamPresensi['awal']);
                $absenPulang                = date_create_from_format('Y-m-d H:i:s', $tanggal . ' ' . $jamPresensi['akhir']);

                $selisihAbsenAwal           = date_diff($jamMasuk, $absenMasuk);

                $selisihAbsenAkhir          = date_diff($absenPulang, $jamPulang);

                $selisihJamMasuk            = date_diff($absenMasuk, $absenPulang);

                $selisihJamMasuk            = $selisihJamMasuk->format("%Y-%m-%d %H:%i:%s");
                $tahunBulanTanggalJumlah    = '0-0-0 ' . $jamKerja['jumlah_jam'];

                $jumlahJamKerja             = date_create($tahunBulanTanggalJumlah);
                $selisihJamMasuk            = date_create($selisihJamMasuk);
                $selisihJamMasuk            = date_diff($jumlahJamKerja, $selisihJamMasuk);

                if ($selisihAbsenAwal->invert == 1) {
                    $statusAbsenAwal        = 'text-success';
                    $iconAbsenAwal          = '<i class="fas fa-check-circle fa-fw"></i>';
                } else {
                    $statusAbsenAwal        = 'text-warning';
                    $iconAbsenAwal          = '<i class="fas fa-clock fa-fw"></i>';
                }

                if ($selisihAbsenAkhir->invert == 1) {
                    $statusAbsenAkhir       = 'text-success';
                    $iconAbsenAkhir         = '<i class="fas fa-check-circle fa-fw"></i>';
                } else {
                    $statusAbsenAkhir       = 'text-info';
                    $iconAbsenAkhir         = '<i class="fas fa-history fa-fw"></i>';
                }

                if (($selisihAbsenAwal->invert == 1 && $selisihAbsenAkhir->invert == 1) == true) {
                    $statusAbsenTotal       = 'text-success';
                    $iconStatusAbsenTotal   = '<i class="fas fa-check-circle fa-fw"></i>';
                    $keterangan             = 'Terpenuhi';
                } else {
                    $statusAbsenTotal       = 'text-warning';
                    $iconStatusAbsenTotal   = '<i class="fas fa-clock fa-fw"></i>';

                    if ($selisihAbsenAwal->invert == 0) {
                        $statusAbsenTotal       = 'text-warning';
                        $keterangan             = 'Terlambat';
                    }

                    if ($selisihAbsenAkhir->invert == 0) {
                        $statusAbsenTotal       = 'text-info';
                        $keterangan             = 'Pulang Cepat';
                    }
                }

                if ($selisihJamMasuk->invert == 0) {
                    $iconJamKehadiran = '<i class="fas fa-check-circle fa-fw"></i>';
                    $statusJamKehadiran     = 'text-success';
                } else {
                    $statusAbsenTotal   = 'text-danger';
                    $statusJamKehadiran = 'text-danger';
                    $iconJamKehadiran   = $iconStatusAbsenTotal = '<i class="fas fa-times-circle fa-fw"></i>';
                    $keterangan         = 'Jam Kerja Kurang!';
                }
            }
        }

        $data = [
            'nama'                  => $namaPegawai,
            'jamDatang'             => $jamPresensiDatang,
            'jamPulang'             => $jamPresensiPulang,
            'jamHadir'              => $jamKehadiran,
            'statusAbsenAwal'       => $statusAbsenAwal,
            'statusAbsenAkhir'      => $statusAbsenAkhir,
            'statusJamHadir'        => $statusJamKehadiran,
            'iconAbsenAwal'         => $iconAbsenAwal,
            'iconAbsenAkhir'        => $iconAbsenAkhir,
            'iconJamHadir'          => $iconJamKehadiran,
            'statusAbsenTotal'      => $statusAbsenTotal,
            'iconStatusAbsenTotal'  => $iconStatusAbsenTotal,
            'keterangan'            => $keterangan,
        ];

        return $data;
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
            case 'all';
                return 'Januari - Desember';
                break;
            default:
                return false;
                break;
        }
    }

    public function namaHari($data)
    {
        switch ($data) {
            case 'Mon':
                return 'Senin';
                break;
            case 'Tue':
                return 'Selasa';
                break;
            case 'Wed':
                return 'Rabu';
                break;
            case 'Thu':
                return 'Kamis';
                break;
            case 'Fri':
                return 'Jumat';
                break;
            case 'Sat':
                return 'Sabtu';
                break;
            case 'Sun':
                return 'Minggu';
                break;
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

    public function getTanggalLibur($tanggal)
    {
        return $this->Admin_model->getHariLibur($tanggal);
    }

    public function getKodeHariNonAktif()
    {
        $hariNonAktif   = $this->Admin_model->getHariNonAktif();
        $data = [];

        for ($i = 0; $i < count($hariNonAktif); $i++) {
            array_push($data, $hariNonAktif[$i]['id']);
        }

        return $data;
    }

    public function getTanggalSelainLibur($bulan, $tahun)
    {
        if ($bulan == 'all') {
            $awalBulan      = 1;
            $akhirBulan     = 12;
            $tglAwal        = $tahun . '-' . 1 . '-' . 1;
            $tanggalAkhir   = $tahun . '-' . 12 . '-' . 31;
            $jumlahHari     = 0;

            for ($i = 1; $i <= 12; $i++) {
                $jumlahHariPerBulan = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
                $jumlahHari         = $jumlahHari + $jumlahHariPerBulan;
            }

            $tglAkhir = $jumlahHari;
        } else {
            $jumlahHari     = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $tglAkhir       = $jumlahHari;
            $awalBulan      = $bulan;
            $akhirBulan     = $bulan;
            $tglAwal        = $tahun . '-' . $this->toPuluhan($bulan) . '-' . $this->toPuluhan(1);
            $tanggalAkhir   = $tahun . '-' . $this->toPuluhan($bulan) . '-' . $tglAkhir;
        }

        $hariNonAktif = $this->Admin_model->getHariNonAktif();

        $daftarHari = [];
        for ($i = 0; $i < count($hariNonAktif); $i++) {
            array_push($daftarHari, $hariNonAktif[$i]['id']);
        }

        $daftarTanggalAktif = [];
        for ($j = $awalBulan; $j <= $akhirBulan; $j++) {
            $tglAkhir = cal_days_in_month(CAL_GREGORIAN, $j, $tahun);
            for ($i = 1; $i <= $tglAkhir; $i++) {
                $tanggal = $tahun . '-' . $j . '-' . $this->toPuluhan($i);
                $tanggalC = date_create_from_format('Y-m-d', $tanggal);
                $tglOK = $tanggalC->format('N');
                $hariLibur = $this->Admin_model->getHariLibur($tanggal);
                $dataHari = in_array($tglOK, $daftarHari);
                $logic = $hariLibur || $dataHari;

                if ($logic == false) {
                    array_push($daftarTanggalAktif, $tanggal);
                }
            }
        }

        $data = [
            'jumlah'                => count($daftarTanggalAktif),
            'daftarTanggalAktif'    => $daftarTanggalAktif
        ];

        return $data;
    }

    public function hitungAbsensi($id, $bulan, $tahun)
    {
        if ($bulan == 'all') {
            $tglAwal            = $tahun . '-' . 1 . '-' . 1;
            $tglAkhir           = $tahun . '-' . 12 . '-' . 31;
        } else {
            $jumlahHari     = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $tglAwal            = $tahun . '-' . $bulan . '-' . 1;
            $tglAkhir           = $tahun . '-' . $bulan . '-' . $jumlahHari;
        }
        $jumlahIzin         = $this->Admin_model->getAbsensiByJenis($id, 'Izin', $tglAwal, $tglAkhir);
        $jumlahSakit        = $this->Admin_model->getAbsensiByJenis($id, 'Sakit', $tglAwal, $tglAkhir);
        $jumlahDinasLuar    = $this->Admin_model->getAbsensiByJenis($id, 'Dinas Luar', $tglAwal, $tglAkhir);
        $jumlahCuti         = $this->Admin_model->getAbsensiByJenis($id, 'Cuti', $tglAwal, $tglAkhir);

        $jumlah = [
            'izin' => count($jumlahIzin),
            'sakit' => count($jumlahSakit),
            'dinasLuar' => count($jumlahDinasLuar),
            'cuti' => count($jumlahCuti),
        ];

        return $jumlah;
    }

    public function toPuluhan($nomor)
    {
        $jmlKarakter = strlen($nomor);
        if ($jmlKarakter == 2) {
            return $nomor;
        } else if ($jmlKarakter == 1) {
            $no = '0' . $nomor;
            return $no;
        }
    }

    public function toSatuan($nomor)
    {
        if ($nomor < 10) {
            return substr($nomor, 1, 1);
        } else {
            return $nomor;
        }
    }

    public function profil()
    {
        $id                 = $_SESSION['user']['id'];
        $dataPegawai = $this->Admin_model->getDataPegawai($id);
        $tahun = substr($dataPegawai['tanggal_lahir'], 0, 4);
        $bulan = substr($dataPegawai['tanggal_lahir'], 5, 2);
        $bulan = $this->toSatuan($bulan);
        $tgl    = substr($dataPegawai['tanggal_lahir'], 8, 2);
        $tgl    = $this->toSatuan($tgl);
        $tanggalLahir = $tgl . ' ' . $this->namaBulan($bulan) . ' ' . $tahun;
        $alamat = $dataPegawai['nama_dusun'] . ' ' . $this->toPuluhan($dataPegawai['rt']) . '/' . $this->toPuluhan($dataPegawai['rw']) . ', ' . $dataPegawai['nama_desa'] . ', ' . $dataPegawai['nama_kecamatan'] . ', ' . $dataPegawai['nama_kabupaten'] . ', ' . $dataPegawai['nama_provinsi'];
        if ($dataPegawai['aktif_peg'] == 1) {
            $is_active = '<div class="spinner-grow spinner-grow-sm text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <a class="text-success">Aktif</a>';
        } else {
            $is_active = '<div class="spinner-grow spinner-grow-sm text-danger" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <a class="text-danger">Tidak</a>';
        }

        $data = [
            'id'        => $id,
            'title'             => 'Admin - ePresensi',
            'sidebar'           => 'profil',
            'id_peg'            => $id,
            'foto'      => $dataPegawai['foto'],
            'nama'      => $dataPegawai['first_name'] . ' ' . $dataPegawai['last_name'],
            'jabatan'   => $dataPegawai['jabatan'],
            'email'     => $dataPegawai['email'],
            'jk'        => $dataPegawai['jk'],
            'ttl'       => $dataPegawai['tempat_lahir'] . ', ' . $tanggalLahir,
            'alamat'    => $alamat,
            'telp'      => $dataPegawai['no_telp'],
            'jabatan'   => $dataPegawai['jabatan'],
            'nip'     => $dataPegawai['nip'],
            'is_active' => $is_active,
            'aktif'     => $dataPegawai['aktif_peg'],
            'data'      => $dataPegawai
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/profil');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('pegawai');
    }

    public function ubahPassword()
    {
        $email = $this->input->post('email');
        $oldPassword = $this->input->post('oldPass');
        $newPassword = $this->input->post('newPassword');
        $newPassword2 = $this->input->post('newPassword2');

        $user = $this->Admin_model->getDataPegawaibyEmail($email);

        if ($newPassword == '' || $newPassword2 == '') {
            $this->session->set_flashdata('pegawai', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Password baru tidak boleh kosong!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/profil');
        }

        if (!password_verify($oldPassword, $user['password'])) {
            $this->session->set_flashdata('pegawai', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Ganti password gagal! Password lama salah!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/profil');
        } else {
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $this->db->where('email', $email);
            $result = $this->db->update('data_pegawai', ['password' => $passwordHash]);

            if ($result) {
                $this->session->set_flashdata('pegawai', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Ganti password Sukses! Password baru anda: ' . $newPassword . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                redirect('admin/profil');
            } else {
                $this->session->set_flashdata('pegawai', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Ganti password gagal! Kesalahan sistem!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                redirect('admin/profil');
            }
        }
    }

    public function reqAktif($id)
    {
        $dataAktivasi = $this->Admin_model->getReqAktivasi($id);

        if ($dataAktivasi) {
            $this->session->set_flashdata('pegawai', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Request aktivasi belum di Approve, silahkan segera menghubungi admin!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/profil');
        } else {
            $data = [
                'id'    => null,
                'id_peg'    => $id,
                'date'      => date('Y-m-d H:i:s', time())
            ];

            $result = $this->Admin_model->reqAktif($data);

            if ($result) {
                $this->session->set_flashdata('pegawai', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Request aktivasi berhasil, silahkan tunggu beberapa saat.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('admin/profil');
            } else {
                $this->session->set_flashdata('pegawai', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Request aktivasi gagak! silahkan coba lagi.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('admin/profil');
            }
        }
    }

    public function dataprofil($id)
    {
        $dataPegawai = $this->Admin_model->getDataPegawai($id);

        $tahun = substr($dataPegawai['tanggal_lahir'], 0, 4);
        $bulan = substr($dataPegawai['tanggal_lahir'], 5, 2);
        $bulan = $this->toSatuan($bulan);
        $tgl    = substr($dataPegawai['tanggal_lahir'], 8, 2);
        $tgl    = $this->toSatuan($tgl);
        $tanggalLahir = $tgl . ' ' . $this->namaBulan($bulan) . ' ' . $tahun;
        $alamat = $dataPegawai['nama_dusun'] . ' ' . $this->toPuluhan($dataPegawai['rt']) . '/' . $this->toPuluhan($dataPegawai['rw']) . ', ' . $dataPegawai['nama_desa'] . ', ' . $dataPegawai['nama_kecamatan'] . ', ' . $dataPegawai['nama_kabupaten'] . ', ' . $dataPegawai['nama_provinsi'];
        if ($dataPegawai['aktif_peg'] == 1) {
            $is_active = '<div class="spinner-grow spinner-grow-sm text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <a class="text-success">Aktif</a>';
        } else {
            $is_active = '<div class="spinner-grow spinner-grow-sm text-danger" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <a class="text-danger">Tidak</a>';
        }

        $data = [
            'id'        => $id,
            'foto'      => $dataPegawai['foto'],
            'nama'      => $dataPegawai['first_name'] . ' ' . $dataPegawai['last_name'],
            'jabatan'   => $dataPegawai['jabatan'],
            'email'     => $dataPegawai['email'],
            'jk'        => $dataPegawai['jk'],
            'ttl'       => $dataPegawai['tempat_lahir'] . ', ' . $tanggalLahir,
            'alamat'    => $alamat,
            'telp'      => $dataPegawai['no_telp'],
            'jabatan'   => $dataPegawai['jabatan'],
            'nip'     => $dataPegawai['nip'],
            'is_active' => $is_active,
            'data'      => $dataPegawai
        ];

        $this->load->view('presensi/admin/profil/data', $data);
    }

    public function pegawai()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Leader' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $id                 = $_SESSION['user']['id'];
            $dataPegawai        = $this->db->get('data_pegawai')->result_array();

            $data           = [
                'title'             => 'Admin - ePresensi',
                'sidebar'           => 'pegawai',
                'id_peg'            => $id,
                'dataPegawai'       => $dataPegawai
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/pegawai');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
        }
    }

    public function tambahpegawai()
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
        $this->form_validation->set_rules('nip', 'ID pegawai', 'required');

        if ($this->form_validation->run() == false) {
            $id                 = $_SESSION['user']['id'];
            $data           = [
                'title'             => 'Admin - ePresensi',
                'sidebar'           => 'pegawai',
                'id_peg'            => $id
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/pegawai/tambah.php');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
        } else {
            if (isset($_POST['submit'])) {
                if ($this->_tambahPegawai() == true) {
                    redirect('admin/pegawai');
                }
            }
        }
    }

    private function _tambahPegawai()
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
            'id'            => null,
            'email'         => $email,
            'password'      => $passhash,
            'first_name'    => $fname,
            'last_name'     => $lname,
            'jk'            => $jk,
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
            'nip'        => $nip,
            'aktif_peg'         => 1,
        ];

        $this->session->set_flashdata('pegawai', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Pegawai sukses ditambahkan.
                        <table class="table table-bordered table-sm text-dark" style="width: 900px;">
                            <tr>
                                <td style="width: 70px;">Username</td>
                                <td colspan="2">' . $data['email'] . '</td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td id="copytext">' . $password . '<button class="btn btn-info ml-3 btn-sm" onclick="CopyToClipboard()">Copy</button></td>
                            </tr>
                        </table>                    
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

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

    public function detailPegawai($id)
    {
        $dataPegawai = $this->Admin_model->getDataPegawai($id);

        if ($dataPegawai['last_name'] != '') {
            $nama       = $dataPegawai['first_name'] . ' ' . $dataPegawai['last_name'];
        } else {
            $nama       = $dataPegawai['first_name'];
        }

        $tahunLahir     = substr($dataPegawai['tanggal_lahir'], 0, 4);
        $bulanLahir     = substr($dataPegawai['tanggal_lahir'], 5, 2);
        $tanggalLahir   = substr($dataPegawai['tanggal_lahir'], 8, 2);

        $ttl            = $dataPegawai['tempat_lahir'] . ', ' . $tanggalLahir . ' ' . $this->namaBulan($bulanLahir) . ' ' . $tahunLahir;
        $alamat         = $dataPegawai['nama_dusun'] . ' ' . $this->toPuluhan($dataPegawai['rt']) . '/' . $this->toPuluhan($dataPegawai['rw']) . ', ' . $dataPegawai['nama_desa'] . ', ' . $dataPegawai['nama_kecamatan'] . ', ' . $dataPegawai['nama_kabupaten'] . ', ' .  $dataPegawai['nama_provinsi'];
        if ($dataPegawai['aktif_peg'] == 1) {
            $is_active = '<div class="spinner-grow spinner-grow-sm text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <a class="text-success">Aktif</a>';
        } else {
            $is_active = '<div class="spinner-grow spinner-grow-sm text-danger" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <a class="text-danger">Tidak</a>';
        }

        $data           = [
            'title'             => 'Detail Pegawai - ePresensi',
            'sidebar'           => 'pegawai',
            'id_peg'            => $id,
            'dataPegawai'       => [
                'email'         => $dataPegawai['email'],
                'nama'          => $nama,
                'jk'            => $dataPegawai['jk'],
                'ttl'           => $ttl,
                'lat'           => $dataPegawai['latitude'],
                'long'          => $dataPegawai['longitude'],
                'alamat'        => $alamat,
                'telp'          => $dataPegawai['no_telp'],
                'jabatan'       => $dataPegawai['jabatan'],
                'foto'          => $dataPegawai['foto'],
                'nip'         => $dataPegawai['nip'],
                'is_active'     => $is_active
            ]
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/pegawai/detail');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('pegawai');
    }

    public function editPegawai($id)
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
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
        $this->form_validation->set_rules('nip', 'NIP User', 'required');

        if ($this->form_validation->run() == false) {
            $user = $this->Admin_model->getDataPegawai($id);

            $data           = [
                'title'             => 'Admin - ePresensi',
                'sidebar'           => 'pegawai',
                'user'              => $user
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/pegawai/edit.php');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
        } else {
            if (isset($_POST['edit'])) {
                if ($this->_editPegawai($id) == true) {
                    redirect('admin/pegawai');
                }
            }
        }
    }

    private function _editPegawai($id)
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
        $foto = $this->input->post('foto');

        $upload_file = $_FILES['passfoto']['name'];

        if ($upload_file) {
            $nama_file = $this->_upload($tipe);
        } else {
            $nama_file = $foto;
        }

        $data = [
            'id'            => $id,
            'email'         => $email,
            'first_name'    => $fname,
            'last_name'     => $lname,
            'jk'            => $jk,
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
            'nip'        => $nip
        ];

        $this->session->set_flashdata('pegawai', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Pegawai sukses diedit.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

        $this->db->where('id', $id);
        return $this->db->update('data_pegawai', $data);
    }

    public function tombolAktif($id)
    {
        $data   = $this->Admin_model->getDataPegawai($id);
        $dataReqAktif = $this->Admin_model->getReqAktivasi($id);
        $status = $data['aktif_peg'];

        if ($status == 1) {
            $i = 0;
            $ket = 'di Non Aktifkan';
        } else {
            $i = 1;
            $ket = 'di Aktifkan';

            if ($dataReqAktif) {
                $this->Admin_model->deleteRequestAktivasi($id);
            }
        }

        $result = $this->Admin_model->tombolAktif($id, $i);

        if ($result == true) {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                User an ' . $data['first_name'] . ' berhasil ' . $ket . '!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pegawai');
        } else {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                User an ' . $data['first_name'] . ' keaktifan gagal diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pegawai');
        }
    }
    public function resetPassword($id)
    {
        $data       = $this->Admin_model->getDataPegawai($id);
        $password   = random_string('alnum', 6);
        $passhash   = password_hash($password, PASSWORD_DEFAULT);

        $result     = $this->db->update('data_pegawai', ['password' => $passhash], ['id' => $id]);

        if ($result == true) {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Password user an ' . $data['first_name'] . ' berhasil di reset!
                <table class="table table-bordered table-sm text-dark" style="width: 900px;">
                    <tr>
                        <td style="width: 70px;">Username</td>
                        <td colspan="2">' . $data['email'] . '</td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td id="copytext">' . $password . '<button class="btn btn-info ml-3 btn-sm" onclick="CopyToClipboard()">Copy</button></td>
                    </tr>
                </table>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pegawai');
        } else {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Password user an ' . $data['first_name'] . ' gagal di reset!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pegawai');
        }
    }

    public function hapusPermanen($id)
    {
        $data               = $this->Admin_model->getDataPegawai($id);
        $fileName           = $data['foto'];
        $target             = base_url() . 'assets/images/pegawai' . $fileName;
        unlink($target);

        $tableDataPegawai   = $this->db->delete('data_pegawai', ['id' => $id]);
        $tablePresensi      = $this->db->delete('presensi', ['id_peg' => $id]);
        $tableAbsensi       = $this->db->delete('absensi', ['id_peg' => $id]);

        $cek = $tableDataPegawai == true and $tablePresensi == true and $tableAbsensi == true;

        if ($cek == true) {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                User an ' . $data['first_name'] . ' berhasil di hapus permanent!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pegawai');
        } else {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                User an ' . $data['first_name'] . ' gagal di hapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pegawai');
        }
    }

    public function kehadiranPegawai()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Leader' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $this->db->order_by('first_name', 'ASC');
            $this->db->select('id');
            $this->db->select('first_name');
            $this->db->select('last_name');
            $user = $this->Admin_model->getDataPegawaiAll();

            $data           = [
                'title'             => 'Kehadiran Pegawai - ePresensi',
                'sidebar'           => 'kehadiranPegawai',
                'user'              => $user
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/index');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
            $this->session->unset_userdata('tanggal');
        }
    }

    public function presensiPegawai($tanggal)
    {
        $this->db->order_by('first_name', 'ASC');
        $user = $this->Admin_model->getDataPegawaiAll();
        $hari = date_create_from_format('Y-m-d', $tanggal);

        $namaHari = $this->namaHari($hari->format('N'));
        $kodeWeekend = $this->getKodeHariNonAktif();
        $a = [];

        for ($i = 0; $i < count($user); $i++) {
            $id = $user[$i]['id'];

            $hariLibur = $this->Admin_model->getHariLibur($tanggal);
            $absenPegawai = $this->Admin_model->getAbsensiByTanggal($id, $tanggal);
            $jamPresensi = $this->getJamAbsen($id, $tanggal);

            if ($jamPresensi) {
                $presensiAwal = $jamPresensi['awal'];
                $presensiAkhir = $jamPresensi['akhir'];
                $presensiAwalC = date_create_from_format('H:i:s', $presensiAwal);
                $presensiAkhirC = date_create_from_format('H:i:s', $presensiAkhir);
                $jamHadir = date_diff($presensiAwalC, $presensiAkhirC);
                $jumlahJamKerhadiran = $jamHadir->format("%H Jam, %i Menit");
            } else {
                $presensiAwal = $presensiAkhir = $jumlahJamKerhadiran = 'tidak absen';
            }

            if ($hariLibur) {
                $keterangan = $hariLibur[0]['keterangan'];
            } else if ($absenPegawai) {
                $keterangan = $absenPegawai['jenis'] . ' (' . $absenPegawai['keterangan'] . ')';
                $presensiAwal = $presensiAkhir = $jumlahJamKerhadiran = '( ' . $absenPegawai['kode_absen'] . ' )';
            } else if (in_array($hari->format('N'), $kodeWeekend)) {
                $keterangan = $namaHari;
            } else {
                $keterangan = '';
            }

            $userTampil = [
                'id' => $id,
                'nama' => $user[$i]['first_name'] . ' ' . $user[$i]['last_name'],
                'jamMasuk' => $presensiAwal,
                'jamPulang' => $presensiAkhir,
                'jamHadir' => $jumlahJamKerhadiran,
                'keterangan' => $keterangan
            ];
            array_push($a, $userTampil);
        }

        $data = [
            'tanggal'   => $namaHari . ', ' . $hari->format('j') . ' ' . $this->namaBulan($hari->format('n')) . ' ' . $hari->format('Y'),
            'user'      => $a
        ];

        $this->load->view('presensi/admin/administrator/presensi_all.php', $data);
    }

    public function getTahunAll()
    {
        return $this->Admin_model->getTahun();
    }

    public function laporanAdmin()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Admin' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $this->db->order_by('first_name', 'ASC');
            $this->db->select('id');
            $this->db->select('first_name');
            $this->db->select('last_name');
            $user   = $this->Admin_model->getDataPegawaiAll();

            $bulan = date('n');
            $tahun = $this->getTahunAll();
            $tahunNow = date('Y');

            $data           = [
                'title'     => 'Kehadiran Pegawai - ePresensi',
                'sidebar'   => 'laporanAdmin',
                'bulan'     => $bulan,
                'tahun'     => $tahun,
                'tahunNow'  => $tahunNow,
                'user'      => $user
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/laporan');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
            $this->session->unset_userdata('tanggal');
        }
    }

    public function individulaporanAdmin($data)
    {
        $this->hariKehadiran($data);
        // redirect('admin/hariKehadiran/' . $data);
    }

    public function rincilaporanAdmin($data)
    {
        $data = explode('_', $data);
        $tanggal = $data[0];
        $idPegawai = $data[1];

        $this->db->order_by('first_name', 'ASC');
        $this->db->select('id');
        $this->db->select('first_name');
        $this->db->select('last_name');

        $tanggalC = date_create_from_format('Y-m-d', $tanggal);
        $hariTanggal = $this->namaHari($tanggalC->format('N')) . ', ' . $tanggalC->format('j') . ' ' . $this->namaBulan($tanggalC->format('n')) . ' ' . $tanggalC->format('Y');

        $tampil = array();

        if ($idPegawai == 'all') {
            $user = $this->Admin_model->getDataPegawaiAll();
            for ($i = 0; $i < count($user); $i++) {
                $statusPresensi = $this->cekStatusAbsen($user[$i]['id'], $tanggal);
                array_push($tampil, $statusPresensi);
            }
        } else {
            $statusPresensi = $this->cekStatusAbsen($idPegawai, $tanggal);
            array_push($tampil, $statusPresensi);
        }

        $dataTampil = [
            'tanggal' => $hariTanggal,
            'tampil' => $tampil
        ];

        $this->load->view('presensi/admin/administrator/laporanAdmin/rinci', $dataTampil);
    }

    public function getHariLibur($bulan, $tahun)
    {
        if ($bulan == 'all') {
            $awalBulan = 1;
            $akhirBulan = 12;
        } else {
            $awalBulan = $bulan;
            $akhirBulan = $bulan;
        }

        $dataWeekend = $this->getKodeHariNonAktif();
        $dataHariLibur = [];

        for ($j = $awalBulan; $j <= $akhirBulan; $j++) {
            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $j, $tahun);
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggal = $tahun . '-' . $this->toPuluhan($j) . '-' . $this->toPuluhan($i);
                $tanggalCreate = date_create_from_format('Y-m-d', $tanggal);
                $kodeHari = $tanggalCreate->format('N');
                $is_hariLibur = $this->Admin_model->getHariLibur($tanggal);

                if (in_array($kodeHari, $dataWeekend)) {
                    array_push($dataHariLibur, $tanggal);
                }

                if ($is_hariLibur) {
                    array_push($dataHariLibur, $is_hariLibur[0]['tanggal']);
                }
            }
        }

        $data = [
            'jumlah' => count(array_unique($dataHariLibur)),
            'daftar' => $dataHariLibur
        ];

        return $data;
    }

    public function hitungJumlahHari($bulan, $tahun)
    {
        $jumlahHari = 0;
        if ($bulan == 'all') {
            $awalBulan = 1;
            $akhirBulan = 12;
        } else {
            $awalBulan = $bulan;
            $akhirBulan = $bulan;
        }

        for ($i = $awalBulan; $i <= $akhirBulan; $i++) {
            $jumlahHariPerBulan = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
            for ($j = 1; $j <= $jumlahHariPerBulan; $j++) {
                $jumlahHari = $jumlahHari + 1;
            }
        }

        return $jumlahHari;
    }

    public function getLogPresensi($id, $bulan, $tahun)
    {
        if ($bulan == 'all') {
            $tanggalAwal = $tahun . '-' . $this->toPuluhan(1) . '-' . $this->toPuluhan(1);
            $tanggalAkhir = $tahun . '-' . $this->toPuluhan(12) . '-' . $this->toPuluhan(31);
        } else {
            $jumlahBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $tanggalAwal = $tahun . '-' . $this->toPuluhan($bulan) . '-' . $this->toPuluhan(1);
            $tanggalAkhir = $tahun . '-' . $this->toPuluhan($bulan) . '-' . $jumlahBulan;
        }

        $data = $this->Admin_model->getPresensi($id, $tanggalAwal, $tanggalAkhir);
        return $data;
    }

    public function rekaplaporanAdmin($data)
    {
        $data = explode('_', $data);
        $idPegawai = $data[0];
        $tahun = $data[1];
        $bulan = $data[2];
        // $dataHariLibur  = $this->getTanggalSelainLibur($bulan, $tahun);

        $hariAktif = $this->getTanggalSelainLibur($bulan, $tahun);
        $jumlahHari = $this->hitungJumlahHari($bulan, $tahun);
        $hariLibur = $this->getHariLibur($bulan, $tahun);

        $dataTampil = [];

        if ($idPegawai == 'all') {
            $user = $this->Admin_model->getDataPegawaiAll();
            for ($i = 0; $i < count($user); $i++) {
                $id = $user[$i]['id'];
                $nama = $user[$i]['first_name'] . ' ' . $user[$i]['last_name'];
                $jumlahLog = count($this->getLogPresensi($id, $bulan, $tahun));
                $kehadiran = $this->getTanggalHadir($id, $bulan, $tahun);
                $hitungPresensi = $this->hitungPresensi($id, $bulan, $tahun);
                $dataAbsensi = $this->hitungAbsensi($id, $bulan, $tahun);
                $tidakHadir = $jumlahHari - count($kehadiran);
                $prosentaseHadir = number_format(count($kehadiran) / $hariAktif['jumlah'] * 100, 2);

                $data = [
                    'nama' => $nama,
                    'jumlahHari' => $jumlahHari,
                    'jumlahHariAktif' => $hariAktif['jumlah'],
                    'jumlahHariLibur' => $hariLibur['jumlah'],
                    'jumlahLogPresensi' => $jumlahLog,
                    'jumlahKehadiran' => count($kehadiran),
                    'jumlahTerlambat' => $hitungPresensi['jumlahTerlambat'],
                    'jumlahPulangCepat' => $hitungPresensi['jumlahPulangCepat'],
                    'jumlahSakit' => $dataAbsensi['sakit'],
                    'jumlahIzin' => $dataAbsensi['izin'],
                    'jumlahCuti' => $dataAbsensi['cuti'],
                    'jumlahDinasLuar' => $dataAbsensi['dinasLuar'],
                    'jumlahTidakHadir' => $tidakHadir,
                    'prosentaseKehadiran' => $prosentaseHadir
                ];

                array_push($dataTampil, $data);
            }
        } else {
            $id = $idPegawai;
            $user = $this->Admin_model->getDataPegawai($id);
            $nama = $user['first_name'] . ' ' . $user['last_name'];
            $jumlahLog = count($this->getLogPresensi($id, $bulan, $tahun));
            $kehadiran = $this->getTanggalHadir($id, $bulan, $tahun);
            $hitungPresensi = $this->hitungPresensi($id, $bulan, $tahun);
            $dataAbsensi = $this->hitungAbsensi($id, $bulan, $tahun);
            $tidakHadir = $jumlahHari - count($kehadiran);
            $prosentaseHadir = number_format(count($kehadiran) / $hariAktif['jumlah'] * 100, 2);

            $data = [
                'nama' => $nama,
                'jumlahHari' => $jumlahHari,
                'jumlahHariAktif' => $hariAktif['jumlah'],
                'jumlahHariLibur' => $hariLibur['jumlah'],
                'jumlahLogPresensi' => $jumlahLog,
                'jumlahKehadiran' => count($kehadiran),
                'jumlahTerlambat' => $hitungPresensi['jumlahTerlambat'],
                'jumlahPulangCepat' => $hitungPresensi['jumlahPulangCepat'],
                'jumlahSakit' => $dataAbsensi['sakit'],
                'jumlahIzin' => $dataAbsensi['izin'],
                'jumlahCuti' => $dataAbsensi['cuti'],
                'jumlahDinasLuar' => $dataAbsensi['dinasLuar'],
                'jumlahTidakHadir' => $tidakHadir,
                'prosentaseKehadiran' => $prosentaseHadir
            ];
            array_push($dataTampil, $data);
        }

        $kirim = [
            'namaBulan' => $this->namaBulan($bulan),
            'tahun' => $tahun,
            'data' => $dataTampil
        ];

        $this->load->view('presensi/admin/administrator/laporanAdmin/rekap', $kirim);
    }

    public function daftarAbsensi()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Leader' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $user = $this->Admin_model->getDataPegawaiAll();
            $dataAbsensi = [];
            for ($i = 0; $i < count($user); $i++) {
                $id = $user[$i]['id'];
                $nama = $user[$i]['first_name'] . ' ' . $user[$i]['last_name'];
                $data = $this->Admin_model->getAbsensiById($id);

                for ($j = 0; $j < count($data); $j++) {
                    $tglAwal = $data[$j]['tanggal'];
                    $lama = $data[$j]['lama'];
                    $strTglAwal = strtotime($tglAwal);
                    $tglAwalTampil = date('d-m-Y', $strTglAwal);
                    $strTglAkhir = strtotime('+' . $lama - 1 . ' days', $strTglAwal);
                    $tglAkhir = date('d-m-Y', $strTglAkhir);

                    $absen = [
                        'id' => $data[$j]['id'],
                        'nama' => $nama,
                        'tanggalMulai' => $tglAwalTampil,
                        'tanggalSelesai' => $tglAkhir,
                        'jumlahHari' => $lama . ' hari',
                        'jenisAbsen' => $data[$j]['jenis'],
                        'keterangan' => $data[$j]['keterangan']
                    ];

                    array_push($dataAbsensi, $absen);
                }
            }

            $data           = [
                'title'     => 'Daftar Absensi Pegawai - ePresensi',
                'sidebar'   => 'absensiPegawai',
                'data'      => $dataAbsensi
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/absensi');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
        }
    }

    public function hapusAbsensi($id)
    {
        $result = $this->Admin_model->hapusAbsensi($id);

        if ($result == true) {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data absensi berhasil di hapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/daftarAbsensi');
        } else {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data absensi berhasil di hapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/daftarAbsensi');
        }
    }

    public function tambahAbsensi()
    {
        $this->form_validation->set_rules('pegawai', 'Pegawai', 'required|trim');
        $this->form_validation->set_rules('tanggalMulai', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('jumlahHari', 'Jumlah hari', 'required|trim|numeric');
        $this->form_validation->set_rules('jenisAbsensi', 'Jenis Absen', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan Absensi', 'required');

        if ($this->form_validation->run() == false) {
            $this->db->order_by('first_name', 'ASC');
            $this->db->select('id');
            $this->db->select('first_name');
            $this->db->select('last_name');
            $user = $this->Admin_model->getDataPegawaiAll();
            $data           = [
                'title'     => 'Tambah Absensi Pegawai - ePresensi',
                'sidebar'   => 'absensiPegawai',
                'user'      => $user
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/absensi/tambah');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
        } else {
            $this->_tambahAbsensi();
        }
    }

    private function _tambahAbsensi()
    {
        $idPegawai = $this->input->post('pegawai');
        $tanggalMulai = $this->input->post('tanggalMulai');
        $jumlahHari = $this->input->post('jumlahHari');
        $jenisAbsensi = $this->input->post('jenisAbsensi');
        $keterangan = $this->input->post('keterangan');
        if ($jenisAbsensi == 'Izin') {
            $kode = 'i';
        } else if ($jenisAbsensi == 'Sakit') {
            $kode = 's';
        } else if ($jenisAbsensi == 'Cuti') {
            $kode = 'c';
        } else if ($jenisAbsensi == 'Dinas Luar') {
            $kode = 'dl';
        }

        $data = [
            'id' => null,
            'tanggal' => $tanggalMulai,
            'lama' => $jumlahHari,
            'jenis' => $jenisAbsensi,
            'kode_absen' => $kode,
            'keterangan' => $keterangan,
            'id_peg' => $idPegawai
        ];

        $result = $this->Admin_model->setAbsensi($data);

        if ($result == true) {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data absensi berhasil di tambah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/daftarAbsensi');
        } else {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data absensi gagal ditambah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/daftarAbsensi');
        }
    }

    public function editAbsensi($id)
    {
        $absensi = $this->Admin_model->getAbsensiId($id);
        $this->db->select('first_name');
        $this->db->select('last_name');
        $dataUser = $this->Admin_model->getDataPegawai($absensi['id_peg']);

        $daftarAbsensi = [
            'id' => $id,
            'id_peg' => $absensi['id_peg'],
            'nama' => $dataUser['first_name'] . ' ' . $dataUser['last_name'],
            'tanggal' => $absensi['tanggal'],
            'lama' => $absensi['lama'],
            'jenisAbsensi' => $absensi['jenis'],
            'keterangan' => $absensi['keterangan']
        ];

        $data           = [
            'title'     => 'Tambah Absensi Pegawai - ePresensi',
            'sidebar'   => 'absensiPegawai',
            'absensi'      => $daftarAbsensi
        ];

        $this->form_validation->set_rules('pegawai', 'Pegawai', 'required|trim');
        $this->form_validation->set_rules('tanggalMulai', 'Tanggal Mulai', 'required|trim');
        $this->form_validation->set_rules('jumlahHari', 'Jumlah hari', 'required|trim|numeric');
        $this->form_validation->set_rules('jenisAbsensi', 'Jenis Absen', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan Absensi', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/absensi/edit');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('pegawai');
        } else {
            $this->_editAbsensi();
        }
    }

    private function _editAbsensi()
    {
        $id = $this->input->post('id');
        $idPegawai = $this->input->post('pegawai');
        $tanggalMulai = $this->input->post('tanggalMulai');
        $jumlahHari = $this->input->post('jumlahHari');
        $jenisAbsensi = $this->input->post('jenisAbsensi');
        $keterangan = $this->input->post('keterangan');
        if ($jenisAbsensi == 'Izin') {
            $kode = 'i';
        } else if ($jenisAbsensi == 'Sakit') {
            $kode = 's';
        } else if ($jenisAbsensi == 'Cuti') {
            $kode = 'c';
        } else if ($jenisAbsensi == 'Dinas Luar') {
            $kode = 'dl';
        }

        $data = [
            'tanggal' => $tanggalMulai,
            'lama' => $jumlahHari,
            'jenis' => $jenisAbsensi,
            'kode_absen' => $kode,
            'keterangan' => $keterangan,
            'id_peg' => $idPegawai
        ];

        $result = $this->Admin_model->updateAbsensi($id, $data);

        if ($result == true) {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data absensi berhasil diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/daftarAbsensi');
        } else {
            $this->session->set_flashdata('pegawai', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data absensi gagal diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/daftarAbsensi');
        }
    }

    public function company()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Leader' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $this->form_validation->set_rules('nama', 'nama perusahaan', 'required');
            $this->form_validation->set_rules('alamat', 'alamat perusahaan', 'required');
            $this->form_validation->set_rules('lat', 'koordinat latitude perusahaan', 'trim');
            $this->form_validation->set_rules('long', 'koordinat longitude perusahaan', 'trim');
            $this->form_validation->set_rules('telepon', 'nomor telepon perusahaan', 'required');
            $this->form_validation->set_rules('email', 'email perusahaan', 'required');
            $this->form_validation->set_rules('website', 'website perusahaan', 'required');

            if ($this->form_validation->run() == false) {
                $company = $this->Admin_model->getCompany();
                $data           = [
                    'title'     => 'Pengaturan - ePresensi',
                    'sidebar'   => 'company',
                    'company'   => $company
                ];

                $this->load->view('template/sbadmin2/header', $data);
                $this->load->view('template/sbadmin2/sidebar');
                $this->load->view('template/sbadmin2/navbar');
                $this->load->view('presensi/admin/administrator/setting/company');
                $this->load->view('template/sbadmin2/copyright');
                $this->load->view('template/sbadmin2/modal-logout');
                $this->load->view('template/sbadmin2/script');
                $this->load->view('template/sbadmin2/footer');
                $this->session->unset_userdata('company');
            } else {
                $this->_editCompany();
            }
        }
    }

    public function logo()
    {
        $company = $this->Admin_model->getCompany();
        $data           = [
            'title'     => 'Pengaturan - ePresensi',
            'sidebar'   => 'company',
            'company'   => $company
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/administrator/setting/logo');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('company');
    }

    public function uploadLogo()
    {
        $config['upload_path']          = './assets/images/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 1000;
        $config['file_name']            = 'logo.png';
        $config['overwrite']            = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('company', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Upload error, ' . $this->upload->display_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/logo');
        } else {
            $this->session->set_flashdata('company', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Logo berhasil di ubah! Tekan Ctrl + F5 untuk me-refresh ulang logo aplikasi ini.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('admin/logo', 'refresh');
        }
    }

    private function _editCompany()
    {
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $lat = $this->input->post('lat');
        $long = $this->input->post('long');
        $telepon = $this->input->post('telepon');
        $email = $this->input->post('email');
        $website = $this->input->post('website');

        $data = [
            'nama' => $nama,
            'alamat' => $alamat,
            'latitude' => $lat,
            'longitude' => $long,
            'telepon' => $telepon,
            'email' => $email,
            'website' => $website
        ];

        $result = $this->Admin_model->updateCompany($email, $data);

        if ($result == true) {
            $this->session->set_flashdata('company', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data perusahaan berhasil diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/company');
        } else {
            $this->session->set_flashdata('company', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data perusahaan gagal diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/company');
        }
    }

    public function user()
    {
        $this->form_validation->set_rules('pegawai', 'pegawai', 'required');
        $this->form_validation->set_rules('level', 'level', 'required');

        $this->db->select('id');
        $this->db->select('first_name');
        $this->db->select('last_name');
        $user = $this->Admin_model->getDataPegawaiAll();

        $pejabat = $this->Admin_model->getPejabatAll();
        $data           = [
            'title'     => 'Pengaturan - ePresensi',
            'sidebar'   => 'user',
            'pejabat'   => $pejabat,
            'user'      => $user
        ];

        if ($this->form_validation->run() == false) {
            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/setting/user');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('company');
        } else {
            $this->_tambahPejabat();
        }
    }

    private function _tambahPejabat()
    {
        $idPegawai = $this->input->post('pegawai');
        $pejabat = $this->Admin_model->getPejabatByIdPegawai($idPegawai);

        $pegawai = $this->Admin_model->getDataPegawai($idPegawai);
        $namaPegawai = $pegawai['first_name'] . ' ' . $pegawai['last_name'];
        $level = $this->input->post('level');

        $data = [
            'id' => null,
            'nama' => $namaPegawai,
            'id_pegawai' => $idPegawai,
            'level' => $level
        ];

        if (!$pejabat) {
            $result = $this->Admin_model->setPejabat($data);
            if ($result == true) {
                $this->session->set_flashdata('company', '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Pejabat perusahaan berhasil ditambahkan!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('admin/pejabat');
            } else {
                $this->session->set_flashdata('company', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Pejabat perusahaan gagal ditambahkan!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('admin/pejabat');
            }
        } else {
            $this->session->set_flashdata('company', '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Maaf, pejabat tidak boleh merangkap!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            redirect('admin/pejabat');
        }
    }

    public function aplikasi()
    {
        $data           = [
            'title'     => 'Pengaturan - ePresensi',
            'sidebar'   => 'aplikasi'
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/administrator/setting/aplikasi');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('company');
    }

    public function hapusPejabat($id)
    {
        $result = $this->Admin_model->hapusPejabat($id);

        if ($result == true) {
            $this->session->set_flashdata('company', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data Pejabat berhasil di hapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pejabat');
        } else {
            $this->session->set_flashdata('company', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data Pejabat gagal di hapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/pejabat');
        }
    }

    public function presensi()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Leader' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $hari = $this->Admin_model->getHariAll();
            $tahun = $this->Admin_model->getTahun();

            $data           = [
                'title'     => 'Pengaturan - ePresensi',
                'sidebar'   => 'company',
                'dataHari'  => $hari,
                'dataTahun' => $tahun
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/setting/presensi');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('company');
        }
    }

    public function setJamKerja()
    {
        $idSenin = $this->input->post('idSenin');
        $idSelasa = $this->input->post('idSelasa');
        $idRabu = $this->input->post('idRabu');
        $idKamis = $this->input->post('idKamis');
        $idJumat = $this->input->post('idJumat');
        $idSabtu = $this->input->post('idSabtu');
        $idMinggu = $this->input->post('idMinggu');

        $namaHariSenin = $this->input->post('namaHariSenin');
        $namaHariSelasa = $this->input->post('namaHariSelasa');
        $namaHariRabu = $this->input->post('namaHariRabu');
        $namaHariKamis = $this->input->post('namaHariKamis');
        $namaHariJumat = $this->input->post('namaHariJumat');
        $namaHariSabtu = $this->input->post('namaHariSabtu');
        $namaHariMinggu = $this->input->post('namaHariMinggu');

        $checkSenin = $this->input->post('checkSenin');
        $checkSelasa = $this->input->post('checkSelasa');
        $checkRabu = $this->input->post('checkRabu');
        $checkKamis = $this->input->post('checkKamis');
        $checkJumat = $this->input->post('checkJumat');
        $checkSabtu = $this->input->post('checkSabtu');
        $checkMinggu = $this->input->post('checkMinggu');

        $jamMasukSenin = $this->input->post('jamMasukSenin');
        $jamMasukSelasa = $this->input->post('jamMasukSelasa');
        $jamMasukRabu = $this->input->post('jamMasukRabu');
        $jamMasukKamis = $this->input->post('jamMasukKamis');
        $jamMasukJumat = $this->input->post('jamMasukJumat');
        $jamMasukSabtu = $this->input->post('jamMasukSabtu');
        $jamMasukMinggu = $this->input->post('jamMasukMinggu');

        $jamPulangSenin = $this->input->post('jamPulangSenin');
        $jamPulangSelasa = $this->input->post('jamPulangSelasa');
        $jamPulangRabu = $this->input->post('jamPulangRabu');
        $jamPulangKamis = $this->input->post('jamPulangKamis');
        $jamPulangJumat = $this->input->post('jamPulangJumat');
        $jamPulangSabtu = $this->input->post('jamPulangSabtu');
        $jamPulangMinggu = $this->input->post('jamPulangMinggu');

        $toleransiSenin = $this->input->post('toleransiSenin');
        $toleransiSelasa = $this->input->post('toleransiSelasa');
        $toleransiRabu = $this->input->post('toleransiRabu');
        $toleransiKamis = $this->input->post('toleransiKamis');
        $toleransiJumat = $this->input->post('toleransiJumat');
        $toleransiSabtu = $this->input->post('toleransiSabtu');
        $toleransiMinggu = $this->input->post('toleransiMinggu');

        $jumlahJamSenin = $this->input->post('jumlahJamSenin');
        $jumlahJamSelasa = $this->input->post('jumlahJamSelasa');
        $jumlahJamRabu = $this->input->post('jumlahJamRabu');
        $jumlahJamKamis = $this->input->post('jumlahJamKamis');
        $jumlahJamJumat = $this->input->post('jumlahJamJumat');
        $jumlahJamSabtu = $this->input->post('jumlahJamSabtu');
        $jumlahJamMinggu = $this->input->post('jumlahJamMinggu');

        $data = [
            0 => [
                'id' => $idSenin,
                'nama' => $namaHariSenin,
                'jam_masuk' => $jamMasukSenin,
                'jam_pulang' => $jamPulangSenin,
                'jumlah_jam' => $jumlahJamSenin,
                'toleransi' => $toleransiSenin,
                'is_active' => $checkSenin
            ],
            1 => [
                'id' => $idSelasa,
                'nama' => $namaHariSelasa,
                'jam_masuk' => $jamMasukSelasa,
                'jam_pulang' => $jamPulangSelasa,
                'jumlah_jam' => $jumlahJamSelasa,
                'toleransi' => $toleransiSelasa,
                'is_active' => $checkSelasa
            ],
            2 => [
                'id' => $idRabu,
                'nama' => $namaHariRabu,
                'jam_masuk' => $jamMasukRabu,
                'jam_pulang' => $jamPulangRabu,
                'jumlah_jam' => $jumlahJamRabu,
                'toleransi' => $toleransiRabu,
                'is_active' => $checkRabu
            ],
            3 => [
                'id' => $idKamis,
                'nama' => $namaHariKamis,
                'jam_masuk' => $jamMasukKamis,
                'jam_pulang' => $jamPulangKamis,
                'jumlah_jam' => $jumlahJamKamis,
                'toleransi' => $toleransiKamis,
                'is_active' => $checkKamis
            ],
            4 => [
                'id' => $idJumat,
                'nama' => $namaHariJumat,
                'jam_masuk' => $jamMasukJumat,
                'jam_pulang' => $jamPulangJumat,
                'jumlah_jam' => $jumlahJamJumat,
                'toleransi' => $toleransiJumat,
                'is_active' => $checkJumat
            ],
            5 => [
                'id' => $idSabtu,
                'nama' => $namaHariSabtu,
                'jam_masuk' => $jamMasukSabtu,
                'jam_pulang' => $jamPulangSabtu,
                'jumlah_jam' => $jumlahJamSabtu,
                'toleransi' => $toleransiSabtu,
                'is_active' => $checkSabtu
            ],
            6 => [
                'id' => $idMinggu,
                'nama' => $namaHariMinggu,
                'jam_masuk' => $jamMasukMinggu,
                'jam_pulang' => $jamPulangMinggu,
                'jumlah_jam' => $jumlahJamMinggu,
                'toleransi' => $toleransiMinggu,
                'is_active' => $checkMinggu
            ]
        ];
        for ($i = 0; $i < count($data); $i++) {
            $id = $data[$i]['id'];
            $jamMasuk = $this->toHIS($data[$i]['jam_masuk']);
            $jamPulang = $this->toHIS($data[$i]['jam_pulang']);

            $jamMasukC = date_create_from_format('H:i:s', $jamMasuk);
            $jamPulangC = date_create_from_format('H:i:s', $jamPulang);
            $perhitungan = date_diff($jamMasukC, $jamPulangC);
            $durasiHadir = $perhitungan->format('%H:%i:%s');

            if ($data[$i]['is_active'] == 'on') {
                $aktif = 1;
            } else {
                $aktif = 0;
            }
            $setHari = [
                'nama' => $data[$i]['nama'],
                'jam_masuk' => $data[$i]['jam_masuk'],
                'jam_pulang' => $data[$i]['jam_pulang'],
                'jumlah_jam' => $durasiHadir,
                'toleransi' => $data[$i]['toleransi'],
                'is_active' => $aktif
            ];
            $this->Admin_model->updateHari($id, $setHari);
        }
        $this->session->set_flashdata('company', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berhasil disimpan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        redirect('admin/presensi');
    }

    public function toHIS($data)
    {
        if (strlen($data) == 5) {
            return $data . ':00';
        } else {
            return $data;
        }
    }

    public function toggleTahun($data)
    {
        $data = explode('_', $data);
        $id = $data[0];
        if ($data[1] == 0) {
            $toggle = 1;
        } else if ($data[1] == 1) {
            $toggle = 0;
        }

        $result = $this->Admin_model->toggleTahun($id, $toggle);

        if ($result) {
            $this->session->set_flashdata('company', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Success!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/kalender');
        }
    }

    public function hapusTahun($id)
    {
        $result = $this->Admin_model->hapusTahun($id);
        if ($result) {
            $this->session->set_flashdata('company', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Success!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/presensi');
        }
    }

    public function setTahun()
    {
        $data = [
            'id' => null,
            'tahun' => $this->input->post('tahun'),
            'is_active' => 1
        ];
        $result = $this->Admin_model->setTahun($data);
        if ($result) {
            $this->session->set_flashdata('company', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Tahun berhasil ditambahkan!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/kalender');
        }
    }

    public function about()
    {
        $data           = [
            'title'     => 'Pengaturan - ePresensi',
            'sidebar'   => 'about'
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/administrator/about/index');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
        $this->session->unset_userdata('company');
    }

    public function kalender()
    {
        $levelUser = $_SESSION['user']['level_user'];
        if ($levelUser == 'Leader' || $levelUser == 'Pegawai') {
            $this->forbidden();
        } else {
            $hari = $this->Admin_model->getHariLiburAll();
            $tahun = $this->Admin_model->getTahun();

            $data           = [
                'title'     => 'Pengaturan - ePresensi',
                'sidebar'   => 'kalender',
                'dataHari'  => $hari,
                'dataTahun' => $tahun
            ];

            $this->load->view('template/sbadmin2/header', $data);
            $this->load->view('template/sbadmin2/sidebar');
            $this->load->view('template/sbadmin2/navbar');
            $this->load->view('presensi/admin/administrator/setting/kalender');
            $this->load->view('template/sbadmin2/copyright');
            $this->load->view('template/sbadmin2/modal-logout');
            $this->load->view('template/sbadmin2/script');
            $this->load->view('template/sbadmin2/footer');
            $this->session->unset_userdata('company');
        }
    }

    public function forbidden()
    {
        $data           = [
            'title'     => 'Forbidden - ePresensi',
            'sidebar'   => 'forbidden'
        ];

        $this->load->view('template/sbadmin2/header', $data);
        $this->load->view('template/sbadmin2/sidebar');
        $this->load->view('template/sbadmin2/navbar');
        $this->load->view('presensi/admin/forbidden');
        $this->load->view('template/sbadmin2/copyright');
        $this->load->view('template/sbadmin2/modal-logout');
        $this->load->view('template/sbadmin2/script');
        $this->load->view('template/sbadmin2/footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->set_flashdata('message', 'success|Logout Sukses|Terimakasih sudah menggunakan layanan ini');
        redirect('presensi/');
    }
}
