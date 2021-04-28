<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajerkeuangan extends CI_Controller
{
	public function __construct()
    {
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

        if (!$this->session->userdata('username')) {
            redirect(base_url('login/karyawan'));
        } else {
            $data['appname'] = 'BeautyNeeds';
            $data['title'] = 'Dashboard';

            $data['jml_pemesanan'] = $this->m_pemesanan->getPemesananCount();
            $data['jml_sales'] = $this->m_user->getSalesCount();
            
            $sess_username = $this->session->userdata('username');
            $data['nama'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_manajerkeuangan', $data);
            $this->load->view('manajerkeuangan/index', $data);
        }
    }

    public function laba()
    {
    	$data['appname'] = 'Beautyneeds';
        $data['title'] = 'Laba';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

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
        $data['labapagination'] = $this->m_laba->getLabaPagination($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_manajerkeuangan', $data);
        $this->load->view('manajerkeuangan/laba', $data);
    }
    public function tambahlaba()
    {
    	$data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Tambah Laba';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['allProduk'] = $this->m_produk->getAllProduk();
        $data['allSales'] = $this->m_user->getAllSales();

        $this->form_validation->set_rules('jumlahLaba', 'jumlahLaba', 'required|trim|numeric');

        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
	        $this->load->view('templates/sidebar_manajerkeuangan', $data);
	        $this->load->view('manajerkeuangan/tambahlaba', $data);

        }else{
        	$this->m_laba->addlaba();
        	redirect('manajerkeuangan/laba');
        }
    }

    public function hapuslaba($id){
        $this->m_laba->hapuslaba($id);
        redirect('manajerkeuangan/laba');
    }

    public function pendapatansales(){
    	$data['appname'] = 'Beautyneeds';
        $data['title'] = 'Pendapatan Sales';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

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
        $data['pendapatanpagination'] = $this->m_pendapatansales->getPendapatanPagination($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_manajerkeuangan', $data);
        $this->load->view('manajerkeuangan/pendapatansales', $data);
    }

    public function hapuspendapatan($id){
        $this->m_pendapatansales->hapuspendapatan($id);
        redirect('manajerkeuangan/pendapatansales');
    }
    public function accpermohonan($id){
        $cek = $this->m_pendapatansales->acc();
        $this->m_pendapatansales->ubahstatuspendapatan($id,$cek);
        redirect('manajerkeuangan/pendapatansales');
    }

}