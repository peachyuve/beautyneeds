<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

     public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');

    }
	public function index()
    {
        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Home';
        $sess_username = $this->session->userdata('username');
        if (!$sess_username){
            $data['user'] = null;
        }else {
            $data['user'] = $this->m_user->getUserByUsername($sess_username);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('welcome', $data);
        $this->load->view('templates/footer_customer', $data);
    }
}
