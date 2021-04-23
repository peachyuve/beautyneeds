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

    public function produk()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Daftar Produk';
        $sess_username = $this->session->userdata('username');
        if (!$sess_username){
            $data['user'] = null;
        }else {
            $data['user'] = $this->m_user->getUserByUsername($sess_username);
        }
        //cek keyword di dalam kolom pencarian
        if ( $this->input->post('keyword') ){
            //jika ada keyword masuk ke dalam data keyword
            $data['keyword'] = $this->input->post('keyword');
            //masukan data keyword ke dalam session agar dapat diakses di setiap page di pagination
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = null;
        }

        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();

        // PAGINATION
        $config['base_url']     = 'http://localhost/beautyneeds/pembeli/produk';
        $config['total_rows']   = $this->m_produk->totalRowsPagination($data['keyword']);
        $config['per_page']     = 8;
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
        
        $data['produkpagination'] = $this->m_produk->getProdukPembeliPagination($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        #$this->load->view('templates/slider', $data);
        $this->load->view('pembeli/produk', $data);
        $this->load->view('templates/footer', $data);
    }

    public function addtocart($idProduk)
    {
        $produk = $this->m_produk->getprodukById($idProduk);

        $data = array(
            'id'      => $produk['idProduk'],
            'qty'     => 1,
            'price'   => $produk['harga'],
            'name'    => $produk['nama']
        );
        
        $this->cart->insert($data);
        redirect('pembeli/produk');
    }

    public function riwayatPemesanan()
    {
        $data['appname'] = 'produk Online App';
        $data['title'] = 'Riwayat Pemesanan';

        $data['jml_produk'] = $this->m_produk->getProdukCount();
        $data['jml_pemesanan'] = $this->m_pemesanan->getPemesananCount();

        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_user->getUserByUsername($sess_username);
        $id_user = $data['user']['idUser'];
        
        $data['getproduk'] = $this->m_produk->getAllproduk();
        
        $data['allPemesanan'] = $this->m_pemesanan->getAllPemesanan();

        $rows = count($data['allPemesanan']);
        for ($x = 0; $x < $rows; $x++)
        {
            $idPemesanan = $data['allPemesanan'][$x]['idPemesanan'];
            $data['allPemesanan'][$x]['itemPemesanan'] = $this->m_pemesanan->getDetailPemesanan($idPemesanan);
            
        }
        //cek keyword di dalam kolom pencarian
        if ( $this->input->post('keyword') ){
            //jika ada keyword masuk ke dalam data keyword
            $data['keyword'] = $this->input->post('keyword');
            //masukan data keyword ke dalam session agar dapat diakses di setiap page di pagination
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = null;
        }
        // PAGINATION
        $config['base_url']     = 'http://localhost/beautyneeds/pembeli/riwayatPemesanan';
        $config['total_rows']   = $this->m_pemesanan->totalRowsPaginationByUser($data['keyword'],$id_user);
        $config['per_page']     = 6;
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
        
        $data['pemesananPagination'] = $this->m_pemesanan->getPemesananPaginationByUser($config['per_page'], $data['start'], $id_user, $data['keyword']);
       
        $rows = count($data['pemesananPagination']);
        for ($x = 0; $x < $rows; $x++)
        {
            $idPemesanan = $data['pemesananPagination'][$x]['idPemesanan'];
            $data['pemesananPagination'][$x]['itemPemesanan'] = $this->m_pemesanan->getDetailPemesanan($idPemesanan);
            
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('pembeli/riwayatPemesanan', $data);
        $this->load->view('templates/footer', $data);
    }

}