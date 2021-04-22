<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#isinya buat login karyawan aja
class Sales extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pembayaran');
    }
}