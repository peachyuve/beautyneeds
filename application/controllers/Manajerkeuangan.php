<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajerkeuangan extends CI_Controller
{
	public function __construct()
    {
        //load model yang diperlukan 
        parent::__construct();
        $this->load->model('m_karyawan');
        $this->load->model('m_user');
        $this->load->model('m_pemesanan');
        $this->load->model('m_pembayaran');
        $this->load->model('m_pendapatansales');
        $this->load->model('m_laba');
        $this->load->model('m_produk');
    }

    public function index()
    {
        //mengecek apa ada session data yang login
        if (!$this->session->userdata('username')) {
            //apabila tidak masuk ke login karyawan
            redirect(base_url('login/karyawan'));
        } else {
            //load view dashboard manajer keuangan
            $data['appname'] = 'BeautyNeeds';
            $data['title'] = 'Dashboard';

            //menghitung jumlah baris data di tabel pemesanan
            $data['jml_pemesanan'] = $this->m_pemesanan->getPemesananCount();
            //menghitung jumlah baris data di tabel sales
            $data['jml_sales'] = $this->m_user->getSalesCount();
            
            //mengambil session dari data user login
            $sess_username = $this->session->userdata('username'); 
            //mencari baris data di database tabel karyawan sesuai session username
            $data['nama'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

            //load view dashboard manajer keuangan
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_manajerkeuangan', $data);
            $this->load->view('manajerkeuangan/index', $data);
        }
    }

    public function laba() //halaman laba
    {

    	$data['appname'] = 'Beautyneeds';
        $data['title'] = 'Laba';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel karyawan sesuai session username
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);
        //mengambil semua baris data di database tabel laba 
        $data['getlaba'] = $this->m_laba->getAllLaba();

        //cek keyword di dalam kolom pencarian
        if ( $this->input->post('keyword') ){
            //jika ada keyword masuk ke dalam data keyword
            $data['keyword'] = $this->input->post('keyword');
            //masukan data keyword ke dalam session agar dapat diakses di setiap page di pagination
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = null;
        }

        //PAGINATION 
        $config['base_url']     = 'http://localhost/beautyneeds/manajerkeuangan/laba';
        $config['total_rows']   = $this->m_user->totalRowsPagination($data['keyword']);
        $config['per_page']     = 5;
        $data['start']          = $this->uri->segment(3);

        //STYLING PAGINATION
        $config['full_tag_open']    = '<nav><ul class="pagination pagination-sm justify-content-center">';
        $config['full_tag_close']   = '</ul></nav>';
        
        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';
        
        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';
        
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';
        
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';
        
        $config['cur_tag_open']     = '<li class="page-item"><a class="page-link bg-secondary text-light" href="#">';
        $config['cur_tag_close']    = '</a></li>';
        
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';

        $config['attributes']       = array('class' => 'page-link text-dark');
        
        $this->pagination->initialize($config);
        //mengambil semua baris data di database tabel laba. apabila ada keyword maka pengambilan dilakukan sesuai keyword yang diinput
        $data['labapagination'] = $this->m_laba->getLabaPagination($config['per_page'], $data['start'], $data['keyword']);

        //load view laba dari manajer keuangan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_manajerkeuangan', $data);
        $this->load->view('manajerkeuangan/laba', $data);
    }
    public function tambahlaba()//halaman tambah laba 
    {
    	$data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Tambah Laba';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel karyawan sesuai session username
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

         //mengambil semua baris data di database tabel Produk 
        $data['allProduk'] = $this->m_produk->getAllProduk();
         //mengambil semua baris data di database tabel Sales 
        $data['allSales'] = $this->m_user->getAllSales();

        //form validation
        $this->form_validation->set_rules('jumlahLaba', 'jumlahLaba', 'required|trim|numeric');

        //cek form validasi
        if ( $this->form_validation->run() == FALSE ){
            //false = load view tambah laba
            $this->load->view('templates/header', $data);
	        $this->load->view('templates/sidebar_manajerkeuangan', $data);
	        $this->load->view('manajerkeuangan/tambahlaba', $data);

        }else{
            //menambah data laba ke database
        	$this->m_laba->addlaba();
        	redirect('manajerkeuangan/laba');
        }
    }


    public function hapuslaba($id)//hapus laba dari database sesuai yg dipilih manajer
    {
        $this->m_laba->hapuslaba($id);
        redirect('manajerkeuangan/laba');
    }

    public function pendapatansales(){//halaman pendapatan sales di manajer keuangan
    	$data['appname'] = 'Beautyneeds';
        $data['title'] = 'Pendapatan Sales';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel karyawan sesuai session username
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);
        //mengambil semua baris data di database tabel pendapatan
        $data['getpendapatan'] = $this->m_pendapatansales->getAllPendapatan();

        //cek keyword di dalam kolom pencarian
        if ( $this->input->post('keyword') ){
            //jika ada keyword masuk ke dalam data keyword
            $data['keyword'] = $this->input->post('keyword');
            //masukan data keyword ke dalam session agar dapat diakses di setiap page di pagination
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = null;
        }

        //PAGINATION
        $config['base_url']     = 'http://localhost/beautyneeds/manajerkeuangan/pendapatansales';
        $config['total_rows']   = $this->m_user->totalRowsPagination($data['keyword']);
        $config['per_page']     = 5;
        $data['start']          = $this->uri->segment(3);

        //STYLING PAGINATION
        $config['full_tag_open']    = '<nav><ul class="pagination pagination-sm justify-content-center">';
        $config['full_tag_close']   = '</ul></nav>';
        
        $config['first_link']       = 'First';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';
        
        $config['last_link']        = 'Last';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';
        
        $config['next_link']        = '&raquo';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';
        
        $config['prev_link']        = '&laquo';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';
        
        $config['cur_tag_open']     = '<li class="page-item"><a class="page-link bg-secondary text-light" href="#">';
        $config['cur_tag_close']    = '</a></li>';
        
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';

        $config['attributes']       = array('class' => 'page-link text-dark');
        
        $this->pagination->initialize($config);
        //mengambil semua baris data di database tabel pendapatan juga joinnya. apabila ada keyword maka pengambilan dilakukan sesuai keyword yang diinput
        $data['pendapatanpagination'] = $this->m_pendapatansales->getPendapatanPagination($config['per_page'], $data['start'], $data['keyword']);

        //load view pendapatan dari manajer keuangan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_manajerkeuangan', $data);
        $this->load->view('manajerkeuangan/pendapatansales', $data);
    }

    public function hapuspendapatan($id){//hapus pendapatan dari database sesuai yg dipilih manajer
        $this->m_pendapatansales->hapuspendapatan($id);
        redirect('manajerkeuangan/pendapatansales');
    }
    public function accpermohonan($id){//mengacc permohonan sales untuk dikirimkan uang pendapatan sales
        //mengubah status menjadi = ..
        $cek = $this->m_pendapatansales->acc();
        //update ke database
        $this->m_pendapatansales->ubahstatuspendapatan($id,$cek);
        redirect('manajerkeuangan/pendapatansales');
    }

}