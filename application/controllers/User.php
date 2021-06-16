<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#isinya buat login user aja
class User extends CI_Controller
{
    public function __construct()
    {
        //load model yang diperlukan 
        parent::__construct();
        $this->load->model('m_user');
    }


    public function index()
    {
        //mengecek apa ada session data yang login
        if (!$this->session->userdata('username')) {
            //apabila tidak masuk ke login user
            redirect(base_url('user/login'));
        } 
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
            $this->load->view('templates/navbar_customer', $data);
            $this->load->view('templates/auth_header', $data);
            $this->load->view('user/login', $data);
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
        //mencari baris data di database tabel user sesuai username yang diinput
        $user = $this->m_user->getUserByUsername($this->input->post('username', true));

        //apabila ada datanya
        if ( $user ){
            //cek role
            if ( $user['role'] == 0 ){
                $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
                Akun Anda sudah tidak aktif!</div>');
                redirect('user');
            }
            // cek password
            if ( password_verify($password, $user['password']) ){
                $data = [
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                $this->session->set_userdata($data);
                
                //cek role id
                if ( $user['role'] == 1 ){
                    redirect('sales');
                } else if ( $user['role'] == 2 ){
                    redirect('pembeli');
                }

            } else{

                $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
                Password Salah!</div>');
                redirect('user');

            }
        } else{//apabila tidak ada
            $this->session->set_flashdata('message', '<div class="alert alert-danger " role="alert">
            Username belum terdaftar.</div>');
            redirect('user');
        }
    }


    public function register()//halaman register pembeli
    {
        //cek sessiondata login
        if ($this->session->userdata('username')){
            //cek role
            if ($this->session->userdata('role') == 1){
                redirect('sales');
            } else if ($this->session->userdata('role') == 2){
                redirect('pembeli');
            } else{
                redirect('customer');
            }
        }
        
        //form validasi
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
        $this->form_validation->set_rules('jenisKelamin', 'jenisKelamin', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('noHp', 'noHP', 'required|trim|min_length[10]|numeric');
        
        //cek form validasi    
        if ( $this->form_validation->run() == FALSE ){
            //false = load view register pembeli
            $data['appname'] = 'Beautyneeds';
            $data['title'] = 'Daftar';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('templates/navbar_customer', $data);
            $this->load->view('user/register');

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
                    //registrasi dengan foto yang diupload
                    $this->m_auth->regdata($new_image);

                } else{
                    //menampilkan pesan error khusus upload
                    $this->session->set_flashdata('message', '<small class="text-danger">' . 
                    $this->upload->display_errors() . '</small>');
                    redirect('user/register');
                }
            } else{
                //register dengan foto default (karena tidak ada foto upload)
                $this->m_user->regdata2();
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Akun Anda berhasil dibuat! Silahkan Login.</div>');
            redirect('welcome');
        }
    }

    public function profile()//halaman profile 
    {
        $data['appname'] = 'BeautyNeeds';
        $data['title'] = 'Profil Saya';

        //mengambil session dari data user login
        $username = $this->session->userdata('username');
        //mencari baris data di database tabel user sesuai session username
        $data['user'] = $this->m_user->getProfile($username);

        //load view profile user
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar_customer', $data);
        $this->load->view('user/profile', $data);
        #$this->load->view('templates/footer', $data);
    }

    public function logout()//logout 
    {
        session_destroy();
        redirect(base_url(''));
    }


}