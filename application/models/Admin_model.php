<?php

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPresensi($id, $tglAwal, $tglAkhir)
    {
        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('waktu', 'DESC');
        return $this->db->get_where('presensi', ['id_peg' => $id, 'tanggal >=' => $tglAwal, 'tanggal <=' => $tglAkhir])->result_array();
    }

    public function getTanggalHadir($id, $tglAwal, $tglAkhir)
    {
        $this->db->select('tanggal');
        return $this->getPresensi($id, $tglAwal, $tglAkhir);
    }

    // public function getTanggalHadirBulanTahun($bulan, $tahun)
    // {
    //     $data = $this->db->get_where('presensi', ['tahun' => $tahun, 'bulan' => $bulan]);
    //     return $data;
    // }

    public function getJamAbsen($id, $tanggal)
    {
        return $this->db->get_where('presensi', ['id_peg' => $id, 'tanggal' => $tanggal])->result_array();
    }

    public function getJamKerja()
    {
        return $this->db->get('jam_kerja')->row_array();
    }

    public function getHariAktif()
    {
        return $this->db->get_where('hari_aktif', ['is_active' => 1])->result_array();
    }

    public function getHariAll()
    {
        return $this->db->get('hari_aktif')->result_array();
    }

    public function updateHari($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('hari_aktif', $data);
    }

    public function getHariNonAktif()
    {
        return $this->db->get_where('hari_aktif', ['is_active' => 0])->result_array();
    }

    public function getHariLibur($tanggal)
    {
        return $this->db->get_where('hari_libur', ['tanggal' => $tanggal])->result_array();
    }

    public function getHariLiburAll()
    {
        return $this->db->get('hari_libur')->result_array();
    }

    public function getAbsensiId($id)
    {
        // $this->db->where('id', $id);
        // $this->db->select('tanggal');
        // $this->db->select('lama');
        // $this->db->select('jenis');
        // $this->db->select('kode_absen');
        // $this->db->select('keterangan');
        // $this->db->select('first_name');
        // $this->db->select('last_name');
        // $this->db->from('absensi');
        // $this->db->join('data_pegawai', 'data_pegawai.id = absensi.id_peg');
        // return $this->db->get()->result_array();

        return $this->db->get_where('absensi', ['id' => $id])->row_array();
    }

    public function getAbsensiById($id)
    {
        return $this->db->get_where('absensi', ['id_peg' => $id])->result_array();
    }

    public function getAbsensiBulan($id, $tglAwal, $tglAkhir)
    {
        return $this->db->get_where('absensi', ['id_peg' => $id, 'tanggal >=' => $tglAwal, 'tanggal <=' => $tglAkhir])->result_array();
    }

    public function getAbsensiByJenis($id, $jenis, $tglAwal, $tglAkhir)
    {
        return $this->db->get_where('absensi', ['id_peg' => $id, 'jenis' => $jenis, 'tanggal >=' => $tglAwal, 'tanggal <=' => $tglAkhir])->result_array();
    }

    public function getAbsensiByTanggal($id, $tanggal)
    {
        $this->db->where('id_peg', $id);
        $this->db->where('tanggal', $tanggal);
        return $this->db->get('absensi')->row_array();
    }

    public function getPresensiLate($id, $tglAwal, $tglAkhir, $jam)
    {
        return $this->db->get_where('presensi', ['id_peg' => $id, 'tanggal >=' => $tglAwal, 'tanggal <=' => $tglAkhir, 'waktu >' => $jam])->result_array();
    }

    public function getPresensiEarly($id, $tglAwal, $tglAkhir, $jam)
    {
        return $this->db->get_where('presensi', ['id_peg' => $id, 'tanggal >=' => $tglAwal, 'tanggal <=' => $tglAkhir, 'waktu <' => $jam])->result_array();
    }

    public function getDataPegawaiAll()
    {
        return $this->db->get('data_pegawai')->result_array();
    }

    public function getDataPegawai($id)
    {
        return $this->db->get_where('data_pegawai', ['id' => $id])->row_array();
    }

    public function getDataPegawaibyEmail($email)
    {
        $this->db->select('password');
        return $this->db->get_where('data_pegawai', ['email' => $email])->row_array();
    }

    public function tombolAktif($id, $i)
    {
        return $this->db->update('data_pegawai', ['aktif_peg' => $i], ['id' => $id]);
    }

    public function getReqAktivasiAll()
    {
        $this->db->select('date');
        $this->db->select('email');
        $this->db->select('first_name');
        $this->db->select('last_name');
        $this->db->from('user_request_activation');
        $this->db->join('data_pegawai', 'data_pegawai.id = user_request_activation.id_peg');
        return $this->db->get()->result_array();
    }

    public function getReqAktivasi($id)
    {
        return $this->db->get_where('user_request_activation', ['id_peg' => $id])->row_array();
    }

    public function reqAktif($data)
    {
        return $this->db->insert('user_request_activation', $data);
    }

    public function deleteRequestAktivasi($id)
    {
        return $this->db->delete('user_request_activation', ['id_peg' => $id]);
    }

    public function setPresensi($data)
    {
        return $this->db->insert('presensi', $data);
    }

    public function detelePresensi($id, $tanggal)
    {
        return $this->db->delete('presensi', ['id_peg' => $id, 'tanggal' => $tanggal]);
    }

    public function getTahun()
    {
        return $this->db->get('tahun')->result_array();
    }

    public function hapusAbsensi($id)
    {
        return $this->db->delete('absensi', ['id' => $id]);
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('absensi', $data);
    }

    public function updateAbsensi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('absensi', $data);
    }

    public function getCompany()
    {
        return $this->db->get('company')->row_array();
    }

    public function updateCompany($email, $data)
    {
        $this->db->where('email', $email);
        return $this->db->update('company', $data);
    }

    public function getPejabatAll()
    {
        return $this->db->get('pejabat')->result_array();
    }

    public function getPejabatByIdPegawai($idPegawai)
    {
        return $this->db->get_where('pejabat', ['id_pegawai' => $idPegawai])->row_array();
    }

    public function hapusPejabat($id)
    {
        return $this->db->delete('pejabat', ['id' => $id]);
    }

    public function setPejabat($data)
    {
        return $this->db->insert('pejabat', $data);
    }

    public function toggleTahun($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tahun', ['is_active' => $data]);
    }

    public function hapusTahun($id)
    {
        return $this->db->delete('tahun', ['id' => $id]);
    }

    public function setTahun($data)
    {
        return $this->db->insert('tahun', $data);
    }
}
