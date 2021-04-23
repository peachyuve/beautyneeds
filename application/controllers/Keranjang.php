<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#isinya buat login karyawan aja
class Keranjang extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pembayaran');
    }

    public function index()
    {
        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Keranjang';
        $data['user'] = $this->db->get_where('user',
        ['username' => $this->session->userdata('username')])->row_array();

        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('keranjang/index', $data);
        $this->load->view('templates/footer', $data);
    }

        public function hapus()
    {
        $this->cart->destroy();
        redirect('pembeli/produk');
    }
}