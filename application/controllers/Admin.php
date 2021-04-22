<?php
defined('BASEPATH') OR exit('No direct script access allowed');


#isi admin
class Admin extends CI_Controller
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
            redirect(base_url('login/karyawan'));
        } else {
            $data['appname'] = 'BeautyNeeds';
            $data['title'] = 'Dashboard';

            $data['jml_produk'] = $this->m_produk->getProdukCount();
            
            $sess_username = $this->session->userdata('username');
            $data['nama'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/index', $data);
        }
    }
    public function userpembeli()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getAllUser();

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
        $config['base_url']     = 'http://localhost/beautyneeds/admin/userpembeli';
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
        
        $data['userpagination'] = $this->m_user->getUserPaginationPembeli($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/userpembeli', $data);
    }

    public function tambahuserpembeli()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getAllUser();

        $this->form_validation->set_rules('idUser', 'idUser', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini telah terdaftar!'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username ini telah terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]|matches[password2]', [
            'matches' => "Password tidak sama",
            'min_length' => "Password minimal 4 karakter."
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('noHp', 'Nomor Telepon', 'required|trim|min_length[10]|numeric');
            
        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/tambahuserpembeli', $data);

        } else {
            
            //cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['foto']['name'];

            if ($upload_image){
                
                $config['upload_path']          = './assets/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')){ //jika berhasil upload
                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    $this->m_user->adddatapembeli($new_image);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/tambahuserpembeli');
                }
            } else{
                $new_image = 'default.jpg';
                $this->m_user->adddatapembeli($new_image);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Akun user baru berhasil dibuat!</div>');
            redirect('admin/userpembeli');
        }
    }

    public function edituserpembeli($id)
    {   
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getUserById($id);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('noHp', 'Nomor Telepon', 'required|trim|min_length[10]|numeric');
        
        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/edituserpembeli', $data);

        } else {
            
            //cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['foto']['name'];

            if ($upload_image){
                
                $config['upload_path']          = './assets/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')){ //jika berhasil upload
                    
                    //mengecek gambar profil yg lama
                    $old_image = $data['getuser']['foto'];
                    // var_dump($old_image); die;
                    //cek apakah gambar default, apabila gambar default tidak akan dihapus
                    if ($old_image != 'default.jpg'){ 
                        //apabila gambar bukan default akan dihapus dengan unlink
                        unlink(FCPATH . 'assets/img/profile' . $old_image); 
                    }

                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    $data = $this->m_user->editdatafromadmin($new_image);
                    $this->m_user->updateUser($data, $id);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('msgUpload', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/userpembeli');
                }
            } else{
                $old_image = $data['getuser']['foto'];
                $data = $this->m_user->editdatafromadmin($old_image);
                $this->m_user->updateUser($data, $id);
            }
            
            $this->session->set_flashdata('message', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data User berhasil diupdate!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/userpembeli');
        }
    }

    public function hapususerpembeli($id)
    {   
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getUserById($id);
        
        $data = $this->m_user->hapususer();
        $this->m_user->updateUser($data, $id);
        
        $this->session->set_flashdata('message', 
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data User berhasil dihapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('admin/userpembeli');
    }


    public function usersales()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getAllUser();

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
        $config['base_url']     = 'http://localhost/beautyneeds/admin/usersales';
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
        
        $data['userpagination'] = $this->m_user->getUserPaginationSales($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/usersales', $data);
    }

    public function tambahusersales()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getAllUser();

        $this->form_validation->set_rules('idUser', 'idUser', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini telah terdaftar!'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username ini telah terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]|matches[password2]', [
            'matches' => "Password tidak sama",
            'min_length' => "Password minimal 4 karakter."
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('noHp', 'Nomor Telepon', 'required|trim|min_length[10]|numeric');
            
        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/tambahusersales', $data);

        } else {
            
            //cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['foto']['name'];

            if ($upload_image){
                
                $config['upload_path']          = './assets/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')){ //jika berhasil upload
                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    $this->m_user->adddatasales($new_image);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/tambahusersales');
                }
            } else{
                $new_image = 'default.jpg';
                $this->m_user->adddatasales($new_image);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Akun user baru berhasil dibuat!</div>');
            redirect('admin/usersales');
        }
    }

    public function editusersales($id)
    {   
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getUserById($id);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('jenisKelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('noHp', 'Nomor Telepon', 'required|trim|min_length[10]|numeric');
        
        if ( $this->form_validation->run() == FALSE ){
            // echo "gamasuk"; die;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/editusersales', $data);

        } else {
            
            //cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['foto']['name'];

            if ($upload_image){
                
                $config['upload_path']          = './assets/img/profile/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')){ //jika berhasil upload
                    
                    //mengecek gambar profil yg lama
                    $old_image = $data['getuser']['foto'];
                    // var_dump($old_image); die;
                    //cek apakah gambar default, apabila gambar default tidak akan dihapus
                    if ($old_image != 'default.jpg'){ 
                        //apabila gambar bukan default akan dihapus dengan unlink
                        unlink(FCPATH . 'assets/img/profile' . $old_image); 
                    }

                    //upload gambar yg baru
                    $new_image = $this->upload->data('file_name');
                    $data = $this->m_user->editdatafromadmin($new_image);
                    $this->m_user->updateUser($data, $id);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('msgUpload', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/usersales');
                }
            } else{
                $old_image = $data['getuser']['foto'];
                $data = $this->m_user->editdatafromadmin($old_image);
                $this->m_user->updateUser($data, $id);
            }
            
            $this->session->set_flashdata('message', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data User berhasil diupdate!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('admin/usersales');
        }
    }

    public function hapususersales($id)
    {   
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'User';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getuser'] = $this->m_user->getUserById($id);
        
        $data = $this->m_user->hapususer();
        $this->m_user->updateUser($data, $id);
        
        $this->session->set_flashdata('message', 
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data User berhasil dihapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('admin/usersales');
    }
    public function produk(){

        $data['produk'] = $this->m_produk->getAllproduk();

        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getjenis'] = $this->m_produk->getAllJenis();
        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();


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
        $config['base_url']     = 'http://localhost/beautyneeds/admin/produk';
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

        $data['produkpagination'] = $this->m_produk->getProdukPagination($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/produk', $data);
    }

    public function hapusProduk($id)
    {
        // var_dump($id);die;
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';

        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['getproduk'] = $this->m_produk->getProdukById($id);
        $data['getjenis'] = $this->m_produk->getAllJenis();
        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();

        $data = $this->m_produk->hapusProduk();
        $this->m_produk->updateProduk($data, $id);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data produk berhasil dihapus boongan!</div>');
        redirect('admin/produk');
    }

    public function tambahproduk()
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['produk'] = $this->m_produk->getAllproduk();
        $data['getjenis'] = $this->m_produk->getAllJenis();
        $data['allproduk'] = $this->m_produk->getAllProdukAndJenis();

        $this->form_validation->set_rules('idProduk', 'idProduk', 'required|trim|min_length[5]');
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
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/tambahproduk', $data);

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
                    $this->m_produk->addProduk($new_image);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('admin/tambahproduk');
                }
            } else{
                $new_image = 'default.png';
                $this->m_produk->addProduk($new_image);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Produk baru berhasil ditambah!</div>');
            redirect('admin/produk');
        }
    }

    public function editproduk($id)
    {
        // var_dump($id);die;
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Kelola Produk';
        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

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
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/editproduk', $data);

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
            redirect('admin/produk');
        }
    }

    public function pemesanan(){

        $data['produk'] = $this->m_produk->getAllproduk();

        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Pemesanan Produk';

        $sess_username = $this->session->userdata('username');
        $data['user'] = $this->m_karyawan->getKaryawanByUsername($sess_username);

        $data['jml_produk'] = $this->m_produk->getProdukCount();
        $data['jml_pemesanan'] = $this->m_pemesanan->getPemesananCount();
    
        $data['allPemesanan'] = $this->m_pemesanan->getAllPemesanan();

        //cek keyword di dalam kolom pencarian
        if ( $this->input->post('keyword') ){
            //jika ada keyword masuk ke dalam data keyword
            $data['keyword'] = $this->input->post('keyword');
            //masukan data keyword ke dalam session agar dapat diakses di setiap page di pagination
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = null;
        }

        $rows = count($data['allPemesanan']);
        for ($x = 0; $x < $rows; $x++)
        {
            $id_pemesanan = $data['allPemesanan'][$x]['idPemesanan'];
            $data['allPemesanan'][$x]['itemPemesanan'] = $this->m_pemesanan->getDetailPemesanan($id_pemesanan);
            
        }
        // PAGINATION
        $config['base_url']     = 'http://localhost/beautyneeds/admin/pemesanan';
        $config['total_rows']   = $this->m_pemesanan->totalRowsPagination($data['keyword']);
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

        $data['produkpagination'] = $this->m_pemesanan->getPemesananPagination($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/pemesanan', $data);
    }

    public function hapusPemesanan($id){
        $this->m_pemesanan->hapusDetailPemesanan($id);
        $this->m_pemesanan->hapusPemesanan($id);
        $this->session->set_flashdata('message', 
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Pemesanan berhasil dihapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('admin/pemesanan');
    }
}