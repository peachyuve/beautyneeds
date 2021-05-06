<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_karyawan extends CI_Model
{
	// mendapatkan array karyawan dengan semua atribut dengan kata kunci username
    public function getKaryawanByUsername($username)
    {
        return $this->db->get_where('karyawan', ['username' => $username])->row_array();
    }

}
