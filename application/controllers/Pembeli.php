<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembeli extends CI_Controller
{
 public function __construct()
    {
        //load model yang diperlukan 
        parent::__construct();
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pemesanan');
        $this->load->model('m_pembayaran');
    }

    public function index(){
        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Home';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel user sesuai session username
        $data['user'] = $this->m_user->getUserByUsername($sess_username);

        //load dashboard pembeli
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('templates/slider', $data);
        $this->load->view('welcome', $data);
    }

    public function produk()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Daftar Produk';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //cek data user login 
        if (!$sess_username){
            $data['user'] = null;
        }else {
            //mencari baris data di database tabel user sesuai session username
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

        //mengambil semua baris data di database tabel produk dan jenis
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
        //mengambil semua baris data di database tabel produk. apabila ada keyword maka pengambilan dilakukan sesuai keyword yang diinput
        $data['produkpagination'] = $this->m_produk->getProdukPembeliPagination($config['per_page'], $data['start'], $data['keyword']);

        //load view produk pembeli
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        #$this->load->view('templates/slider', $data);
        $this->load->view('pembeli/produk', $data);
        $this->load->view('templates/footer', $data);
    }


    public function addtocart($idProduk)//memasukkan produk yang dipilih pembeli ke keranjang
    {
        ////mengambil baris data di database tabel produk yang sesuai dengan id yang diinput
        $produk = $this->m_produk->getprodukById($idProduk);

        $data = array(
            'id'      => $produk['idProduk'],
            'qty'     => 1,
            'price'   => $produk['harga'],
            'name'    => $produk['nama']
        );
        
        //memasukkan data produk ke keranjang
        $this->cart->insert($data);
        redirect('pembeli/produk');
    }

    public function riwayatPemesanan()//halaman riwayat pemesanan
    {
        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Riwayat Pemesanan';

        //menghitung jumlah baris data di tabel produk
        $data['jml_produk'] = $this->m_produk->getProdukCount();
        //menghitung jumlah baris data di tabel pemesanan 
        $data['jml_pemesanan'] = $this->m_pemesanan->getPemesananCount();
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel user sesuai session username
        $data['user'] = $this->m_user->getUserByUsername($sess_username);
        $id_user = $data['user']['idUser'];
        
        //mengambil semua baris data di database tabel produk 
        $data['getproduk'] = $this->m_produk->getAllproduk();
        
        //mengambil semua baris data di database tabel pemesanan
        $data['allPemesanan'] = $this->m_pemesanan->getAllPemesanan();

        //get all detail pemesanan dari tiap pemesanan
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
        
        //mengambil semua baris data di database tabel pemesanan. apabila ada keyword maka pengambilan dilakukan sesuai keyword yang diinput
        $data['pemesananPagination'] = $this->m_pemesanan->getPemesananPaginationByUser($config['per_page'], $data['start'], $id_user, $data['keyword']);

        //get all detail pemesanan dari tiap pemesanan pagination
        $rows = count($data['pemesananPagination']);
        for ($x = 0; $x < $rows; $x++)
        {
            $idPemesanan = $data['pemesananPagination'][$x]['idPemesanan'];
            $data['pemesananPagination'][$x]['itemPemesanan'] = $this->m_pemesanan->getDetailPemesanan($idPemesanan);
           
        }
        //load view riwayat pemesanan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('pembeli/riwayatPemesanan', $data);
        $this->load->view('templates/footer', $data);
    }

   

    public function uploadbukti($idPembayaran,$idPemesanan){//upload bukti pembayaran

        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Riwayat Pemesanan';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel user sesuai session username
        $data['user'] = $this->m_user->getUserByUsername($sess_username);
        $data['idPembayaran'] = $idPembayaran;
        $data['idPemesanan'] = $idPemesanan;
        //form validation
        $this->form_validation->set_rules('gambar', 'Fungsi', 'trim|min_length[5]');
        //cek form validation
        if ( $this->form_validation->run() == FALSE ){
            //false = load ke upload bukti pembeli
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar_customer', $data);
            $this->load->view('pembeli/uploadbukti', $data);
        }else{
            $upload_image = $_FILES['gambar']['name'];

            //cek image
            if ($upload_image){
                
                $config['upload_path']          = './assets/img/bukti/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')){ //jika berhasil upload
                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    //upload bukti pembayaran ke tabel pembayaran di database
                    $this->m_pembayaran->uploadbukti($idPembayaran,$new_image);
                    $cek = $this->m_pemesanan->sudahbayar();
                    //ubah status menjadi sudah bayar
                    $this->m_pemesanan->ubahstatuspemesanan($idPemesanan,$cek);
                    redirect('pembeli/riwayatPemesanan');
                }else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');

                }
                // $this->m_produk->penguranganproduk($idPemesanan);
            }else{
                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Tidak Ada Gambar</div>');
                 redirect('pembeli/uploadbukti');
            }
        }
        
        
    }
}