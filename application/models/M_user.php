<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
	public function getAllUser()
    {
        return $this->db->get('user')->result_array();
    }

    public function getUserCount()
    {
        $this->db->where('status', '1');
        $this->db->from('user');
        return $this->db->count_all_results();
    }

    public function getUserById($idUser)
    {
        $this->db->where('idUser', $idUser);
        return $this->db->get('user')->row_array();
    }

    public function totalRowsPagination($keyword)
    {
        $this->cariuser($keyword);
        $this->db->from('user');
        return $this->db->count_all_results();
    }

    public function cariuser($keyword)
    {
        $this->db->like('nama', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('username', $keyword);
        $this->db->or_like('jenisKelamin', $keyword);
        $this->db->or_like('tgl_lahir', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('noHp', $keyword);
    }

    public function getUserPaginationPembeli($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->cariuser($keyword);
        }
        $this->db->where('role', 2);
		$query = $this->db->get('user', $limit, $start);
        return $query->result_array();
    }

    public function getUserPaginationSales($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->cariuser($keyword);
        }
        $this->db->where('role', 1);
        $query = $this->db->get('user', $limit, $start);
        return $query->result_array();
    }

    public function getUserByUsername($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }

    public function adddatapembeli($new_image)
    {
        $data = [
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'email'         => htmlspecialchars($this->input->post('email', true)),
            'username'      => htmlspecialchars($this->input->post('username', true)),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'jenisKelamin' => $this->input->post('jenisKelamin'),
            'tgl_lahir'     => $this->input->post('tgl_lahir'),
            'alamat'        => $this->input->post('alamat'),
            'noHp'       => $this->input->post('noHp'),
            'foto'          => $new_image,
            'role'          =>2,
            'status'        =>1
        ];
        $this->db->insert('user', $data);
    }
    public function adddatasales($new_image)
    {
        $data = [
            'idUser'        => $this->input->post('idUser'),
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'email'         => htmlspecialchars($this->input->post('email', true)),
            'username'      => htmlspecialchars($this->input->post('username', true)),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'jenisKelamin' => $this->input->post('jenisKelamin'),
            'tgl_lahir'     => $this->input->post('tgl_lahir'),
            'alamat'        => $this->input->post('alamat'),
            'noHp'       => $this->input->post('noHp'),
            'foto'          => $new_image,
            'role'          =>1,
            'status'        =>1
        ];
        $this->db->insert('user', $data);
    }

    public function editdatafromadmin($new_image)
    {
        return $data = [
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'email'         => htmlspecialchars($this->input->post('email', true)),
            'username'      => htmlspecialchars($this->input->post('username', true)),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'jenisKelamin' => $this->input->post('jenisKelamin'),
            'tgl_lahir'     => $this->input->post('tgl_lahir'),
            'alamat'        => $this->input->post('alamat'),
            'noHp'       => $this->input->post('noHp'),
            'foto'          => $new_image,
        ];
    }

    public function findColumn(){
        $this->db->get('user')->result_array();
    }

 

    public function randomGenerator($len, $isAngka=true, $isUppercase=true, $isLowecase=true)
    {
        $rand='';
        for ($i=0; $i < $len; $i++) { 
            $random = [];
            ($isAngka)?array_push($random, rand(48,57)):null;
            ($isUppercase)?array_push($random, rand(65,90)):null;
            ($isLowecase)?array_push($random, rand(97,122)):null;
            if (count($random) == 3) {
                $rand = $rand.chr($random[rand(0,2)]);
            }elseif (count($random) == 2) {
                $rand = $rand.chr($random[rand(0,1)]);
            }elseif (count($random) == 1) {
                $rand = $rand.chr($random[rand(0,0)]);
            }else{
                return '';
            }
        }
        return $rand;
    }

    public function random_id(){
        $idFirstName = 'US';
        $idList = $this->findColumn();
        if ($idList) {
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if(!in_array($id, $idList['idUser'])){
                    $isUnique = true;
                }
            }
            $id = $idFirstName.$id;
        }else {
            $id = $this->randomGenerator(5);
            $id = $idFirstName.$id;
        }
        return $id;

    }


    public function regdata($new_image)
    {
        $data = [
            'idUser'        => $this->random_id(),
            'idKaryawan'    => 'K001',
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'email'         => htmlspecialchars($this->input->post('email', true)),
            'username'      => htmlspecialchars($this->input->post('username', true)),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'jenisKelamin' => $this->input->post('jenisKelamin'),
            'tgl_lahir'     => $this->input->post('tgl_lahir'),
            'alamat'        => $this->input->post('alamat'),
            'noHp'       => $this->input->post('noHp'),
            'foto'          => $new_image,
            'role'       => 2
        ];

        $this->db->insert('user', $data);
    }

    public function regdata2()
    {
        $data = [
            'idUser'        => $this->random_id(),
            'idKaryawan'    => 'K001',
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'email'         => htmlspecialchars($this->input->post('email', true)),
            'username'      => htmlspecialchars($this->input->post('username', true)),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'jenisKelamin' => $this->input->post('jenisKelamin'),
            'tgl_lahir'     => $this->input->post('tgl_lahir'),
            'alamat'        => $this->input->post('alamat'),
            'noHp'       => $this->input->post('noHp'),
            'foto'          => 'default.jpg',
            'role'       => 2
        ];

        $this->db->insert('user', $data);
    }

    public function hapususer()
    {
        return $data = ['status'       => 0];
    }

    public function updateUser($data,$idUser)
    {
        $this->db->set($data);
        $this->db->where('idUser', $idUser);
        $this->db->update('user');
    }
}