<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#isinya buat login karyawan aja
class Karyawan extends CI_Controller
{
    public function __construct()
    {
        //load model yang diperlukan 
        parent::__construct();
        $this->load->model('m_karyawan');
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pemesanan');
        $this->load->model('m_pembayaran');
    }


    public function index()
    {
        //mengecek apa ada session data yang login
        if (!$this->session->userdata('username')) {
            //apabila tidak masuk ke login karyawan
            redirect(base_url('karyawan/login'));
        }
            #$this->load->view('templates/footer', $data);
        
    }

    public function login()//halaman login
    {

        //form validasi
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        //apabila false load view karyawan login
        if ( $this->form_validation->run() == FALSE ){
            $data['appname'] = 'BeautyNeeds';
            $data['title'] = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('karyawan/login', $data);
        } else {//apabila true dilangsungkan ke login 
            $this->_login();
        }
    }

    private function _login()//mengecek inputan user di halaman login
    {
        //mengambil data input username
        $username = $this->input->post('username');
        //mengambil data input password
        $password = $this->input->post('password');
        //mencari baris data di database tabel karyawan sesuai username yang diinput
        $karyawan = $this->m_karyawan->getKaryawanByUsername($this->input->post('username', true));

        //apabila ada datanya
        if ( $karyawan ){
            //cek role
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
                    redirect('admin');//masuk ke halaman admin
                } else if ( $karyawan['role'] == 2 ){
                    redirect('manajerkeuangan');//masuk ke halaman manajer keuangan
                }

            } else{

                $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
                Password Salah!</div>');
                redirect('karyawan');

            }
        } else{//apabila tidak ada
            $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
            Username belum terdaftar.</div>');
            redirect('karyawan');
        }
    }



    //fungsi logout
    public function logout()
    {
        session_destroy();
        redirect(base_url('karyawan'));
    }


}