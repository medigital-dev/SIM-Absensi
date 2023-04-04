<?php

class Presensi_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataPegawai($id)
    {
        return $this->db->get_where('data_pegawai', ['id' => $id])->row_array();
    }

    public function setPresensi($data)
    {
        return $this->db->insert('presensi', $data);
    }

    public function getKehadiranAll($id)
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get_where('presensi', ['id' => $id])->result_array();
    }

    public function getJumlahHariHadir($id)
    {
        $data   = $this->db->get_where('presensi', ['id' => $id])->result_array();

        $jml    = count($data);
        $a = [];
        for ($i = 1; $i < $jml; $i++) {
            array_push($a, $data[$i]['tanggal']);
        }
        return array_unique($a);
    }

    public function getHariLibur($tgl)
    {
        return $this->db->get_where('hari_libur', ['tanggal' => $tgl])->row_array();
    }

    public function getHariAktif($data)
    {
        return $this->db->get_where('hari_aktif', ['id' => $data])->row_array();
    }

    public function getCompany()
    {
        return $this->db->get('company')->row_array();
    }
}
