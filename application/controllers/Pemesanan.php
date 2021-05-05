<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller
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
      
    }

    public function pembayaran()
    {

        $data['appname'] = 'Beautyneeds';
        $data['title'] = 'Pembayaran';
        //mengambil session dari data user login
        $sess_username = $this->session->userdata('username');
        //mencari baris data di database tabel user sesuai session username
        $data['user'] = $this->m_user->getUserByUsername($sess_username);
        //mengambil semua baris data di database tabel jenis produk 
        $data['getjenis'] = $this->m_pembayaran->getAllJenis();
        //mengambil semua baris data di database tabel jenis produk dan produk
        $data['allproduk'] = $this->m_produk->getAllprodukAndJenis();

        //cek ada data di keranjang
        if ($this->cart->contents()){
            //cek id jenis bayar
            if($this->input->post('idJenisBayar')){
                //add data pembayaran ke database
                $idPembayaran = $this->m_pembayaran->addPembayaran();
                //add data pemesanan dan detail pemesanan
                if ( $this->m_pemesanan->proses($data['user']['idUser'],$idPembayaran) ){
                    //menghapus isi cart 
                    $this->cart->destroy();
                    $this->session->set_flashdata('message', 
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Pesanan Anda sedang diproses, silahkan kembali lagi nanti.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                    redirect('pembeli/riwayatPemesanan');
                } else{
                    $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Gagal memproses pemesanan, silahkan ulangi kembali.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                    redirect('keranjang');
                }
            }
        } 
        //load view riwayat pemesanan dari pembeli
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('pemesanan/pembayaran', $data);
        $this->load->view('templates/footer', $data);

    }

}