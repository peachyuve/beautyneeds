<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembeli extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pemesanan');
        $this->load->model('m_pembayaran');
    }

    public function index(){
        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Home';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_user->getUserByUsername($sess_username);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('pembeli/index', $data);
    }


}