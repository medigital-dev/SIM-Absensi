<?php

class Login_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ceklogin($email, $pass)
    {
        $this->db->select('id');
        $this->db->select('first_name');
        $this->db->select('last_name');
        $this->db->select('email');
        $this->db->select('nip');
        $this->db->select('aktif_peg');
        $this->db->select('password');

        $user = $this->db->get_where('data_pegawai', ['email' => $email])->row_array();

        if ($user) {
            if (password_verify($pass, $user['password'])) {

                $level = $this->getLevelUser($user['id']);
                if ($level) {
                    $levelUser = $level['level'];
                } else {
                    $levelUser = 'Pegawai';
                }

                $data = [
                    'id'            => $user['id'],
                    'first_name'    => $user['first_name'],
                    'last_name'     => $user['last_name'],
                    'email'         => $user['email'],
                    'level_user'    => $levelUser
                ];

                $this->session->set_userdata('user', $data);
                return true;
            } else {
                //  notif password salah
                $this->session->set_flashdata('message', 'error|Wrong Password|Password tidak sesuai database');
                return false;
            }
        } else {
            // notif user tidak ada
            $this->session->set_flashdata('message', 'error|User not found|User tidak ada dalam database');
            return false;
        }
    }

    public function getLevel($data)
    {
        $result = $this->db->get_where('level_user', ['id_level' => $data])->row_array();
        return $result['nama_level'];
    }

    public function getLevelUser($id)
    {
        $this->db->select('level');
        return $this->db->get_where('pejabat', ['id_pegawai' => $id])->row_array();
    }
}
