<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
    {
        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Home';
        

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('welcome', $data);
        $this->load->view('templates/footer_customer', $data);
    }
}
