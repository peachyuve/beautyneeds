<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sales extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_produk');
        $this->load->model('m_user');
        $this->load->model('m_pembayaran');
        $this->load->model('m_pendapatansales');
    }

    public function index()
    {

        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Dashboard';

        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_user->getUserByUsername($sess_username);

        $data['jml_produk'] = $this->m_produk->getProdukCountSales($data['user']['idUser']);
        $data['jml_pendapatanS'] = $this->m_pendapatansales->hitungpendapatancount($data['user']['idUser']);
        
      	// print_r($data['jml_pendapatanS']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_sales', $data);
        $this->load->view('sales/index', $data);
    
    }

    public function produk(){


        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
    	$data['user'] = $this->m_user->getUserByUsername($sess_username);


        $data['allproduk'] = $this->m_produk->getAllProdukAndJenisSales($data['user']['idUser']);


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
        $config['base_url']     = 'http://localhost/beautyneeds/sales/produk';
        $config['total_rows']   = $this->m_produk->totalRowsPagination($data['keyword']);
        $config['per_page']     = 9;
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

        $data['produkpagination'] = $this->m_produk->getProdukPaginationSales($config['per_page'], $data['start'],$data['user']['idUser'],$data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_sales', $data);
        $this->load->view('sales/produk', $data);
    }

    public function hapusProduk($id)
    {
        // var_dump($id);die;
       	$data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
    	$data['user'] = $this->m_user->getUserByUsername($sess_username);

        $data['getproduk'] = $this->m_produk->getProdukById($id);
        $data['getjenis'] = $this->m_produk->getAllJenis();
        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();

        $this->m_produk->hapusProdukSales($id);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data produk berhasil dihapus!</div>');
        redirect('sales/produk');
    }

    public function tambahproduk()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
    	$data['user'] = $this->m_user->getUserByUsername($sess_username);

        $data['produk'] = $this->m_produk->getAllproduk();
        $data['getjenis'] = $this->m_produk->getAllJenis();
        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();


        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|is_unique[produk.nama]', [
            'is_unique' => 'Produk ini telah terdaftar!'
        ]);
        $this->form_validation->set_rules('warna', 'Aturan', 'trim|min_length[5]');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim|numeric');
        $this->form_validation->set_rules('gambar', 'Fungsi', 'trim|min_length[5]');
        $this->form_validation->set_rules('deskripsi', 'Aturan', 'trim|min_length[5]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim|numeric');

        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_sales', $data);
            $this->load->view('sales/tambahproduk', $data);

        } else {
            
            //cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['gambar']['name'];

            if ($upload_image){
                
                $config['upload_path']          = './assets/img/produk/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')){ //jika berhasil upload
                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    $this->m_produk->addProduk($data['user']['idUser'],$new_image);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/tambahproduk');
                }
            } else{
                $new_image = 'default.png';
                $this->m_produk->addProduk($data['user']['idUser'],$new_image);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk baru berhasil ditambah!</div>');
            redirect('sales/produk');
        }
    }

    public function editproduk($id)
    {
        // var_dump($id);die;
       	$data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
    	$data['user'] = $this->m_user->getUserByUsername($sess_username);

        $data['produk'] = $this->m_produk->getProdukById($id);
        $data['getjenis'] = $this->m_produk->getAllJenis();
        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();




        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('warna', 'Aturan', 'trim|min_length[5]');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim|numeric');
        $this->form_validation->set_rules('gambar', 'Fungsi', 'trim|min_length[5]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|min_length[5]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|trim|numeric');

            
        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_sales', $data);
            $this->load->view('sales/editproduk', $data);

        } else {
            
            //cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['gambar']['name'];

            if ($upload_image){
                
                $config['upload_path']          = './assets/img/produk/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')){ //jika berhasil upload
                    //mengecek gambar produk yg lama
                    $old_image = $data['produk']['gambar'];
                    // var_dump($old_image); die;
                    //cek apakah gambar default, apabila gambar default tidak akan dihapus
                    if ($old_image != 'default.png'){ 
                        //apabila gambar bukan default akan dihapus dengan unlink
                        unlink(FCPATH . 'assets/img/produk' . $old_image); 
                    }

                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    $data = $this->m_produk->editdataproduk($new_image);
                    $this->m_produk->updateProduk($data, $id);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/editproduk'.$id);
                }
            } else{
                $old_image = $data['produk']['gambar'];
                $data = $this->m_produk->editdataproduk($old_image);
                $this->m_produk->updateProduk($data, $id);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data produk berhasil diubah!</div>');
            redirect('sales/produk');
        }
    }

    public function pendapatan()
    {
    	$data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
    	$data['user'] = $this->m_user->getUserByUsername($sess_username);

    	$data['allproduk'] = $this->m_produk->getAllProdukAndJenisSales($data['user']['idUser']);
    	$data['allpendapatan'] = $this->m_pendapatansales->getAllPendapatanByUser($data['user']['idUser']);

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
        $config['base_url']     = 'http://localhost/beautyneeds/sales/pendapatan';
        $config['total_rows']   = $this->m_produk->totalRowsPagination($data['keyword']);
        $config['per_page']     = 9;
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

        $data['pendapatanpagination'] = $this->m_pendapatansales->getPendapatanPaginationSales($config['per_page'], $data['start'],$data['user']['idUser'],$data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_sales', $data);
        $this->load->view('sales/pendapatan', $data);
    }

    public function memintapermohonan($id){//mengacc permohonan sales untuk dikirimkan uang pendapatan sales
        //mengubah status menjadi = ..
        $cek = $this->m_pendapatansales->meminta();
        //update ke database
        $this->m_pendapatansales->ubahstatuspendapatan($id,$cek);
        redirect('sales/pendapatan');
    }
    

}