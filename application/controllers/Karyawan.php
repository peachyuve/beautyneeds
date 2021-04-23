<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#isinya buat login karyawan aja
class Karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_karyawan');
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pemesanan');
        $this->load->model('m_pembayaran');
    }


    public function index()
    {
        if (!$this->session->userdata('username')) {
            redirect(base_url('karyawan/login'));
        } 
            #$this->load->view('templates/footer', $data);
        
    }

    public function login()
    {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ( $this->form_validation->run() == FALSE ){
            $data['appname'] = 'BeautyNeeds';
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('karyawan/login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $karyawan = $this->m_karyawan->getKaryawanByUsername($this->input->post('username', true));

        if ( $karyawan ){
            if ( $karyawan['role'] == 0 ){
                $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
                Akun Anda sudah tidak aktif!</div>');
                redirect('karyawan');
            }
            // cek password
            if ( password_verify($password, $karyawan['password']) ){
                $data = [
                    'username' => $karyawan['username'],
                    'role' => $karyawan['role']
                ];
                $this->session->set_userdata($data);
                
                //cek role id
                if ( $karyawan['role'] == 1 ){
                    redirect('admin');
                } else if ( $karyawan['role'] == 2 ){
                    redirect('manajerkeuangan');
                }

            } else{

                $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
                Password Salah!</div>');
                redirect('karyawan');

            }
        } else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
            Username belum terdaftar.</div>');
            redirect('karyawan');
        }
    }



    public function logout()
    {
        session_destroy();
        redirect(base_url('karyawan'));
    }


}