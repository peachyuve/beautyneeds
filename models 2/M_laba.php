<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laba extends CI_Model
{
    // mereturn semua data laba dalam array
    public function getAllLaba()
    {
        return $this->db->get('laba')->result_array();
    }


    public function getAllProdukSales()
    {
    	$this->db->select('*');
    	$this->db->from('user');
        $this->db->where('role', 1);
    	$query = $this->db->get();
    	return $query->result_array();
    }


    #mencari baris pada database dengan kata kunci nama sales, dan nama user
    public function carilaba($keyword)
    {
        $this->db->like('nama', $keyword);
        $this->db->or_like('nama_user', $keyword);    
   	}
    // mengambil semua baris data dari laba yang di join dengan produk dan user. apabila ada keyword, 
    // hanya mengambil baris data dengan kata kunci keyword. 
    public function getLabaPagination($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->carilaba($keyword);
        }
        $this->db->join('produk','produk.idProduk=laba.idProduk','LEFT OUTER');
        $this->db->join('user','user.idUser=produk.idUser','LEFT OUTER');
        $query = $this->db->get('laba', $limit, $start);
        return $query->result_array();
    }

    #menghapus data laba dengan kata kunci idlaba yang diinpu tuser
    public function hapuslaba($idlaba)
    {
        $this->db->where('idLaba', $idlaba);
        return $this->db->delete('laba');
    }

    // untuk random generator id 

    //mereturn semua kolom dari laba
    public function findColumn(){
        $this->db->get('laba')->result_array();
    }

    //merandom angka dan huruf
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
    //fungsi utama random id pada data yang baru diinput
    public function random_id(){
        $idFirstName = 'L';
        $idList = $this->findColumn();
        if ($idList) {
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if(!in_array($id, $idList['idLaba'])){
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

    //menambahkan baris data ke laba
    public function addLaba()
    {
        $data = [
            'idLaba'        => $this->random_id(),
            'idKaryawan'    => 'K002',
            'idProduk' => $this->input->post('idProduk'),
            'jumlahLaba'        => $this->input->post('jumlahLaba'),
        ];

        $this->db->insert('laba', $data);
    }



}