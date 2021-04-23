<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_produk extends CI_Model
{
 public function cariproduk($keyword)
    {
        $this->db->like('idProduk', $keyword);
        $this->db->or_like('nama', $keyword);
        $this->db->or_like('warna', $keyword);
        $this->db->or_like('harga', $keyword);
        $this->db->or_like('namaJenis', $keyword);
    }
    public function totalRowsPagination($keyword)
    {
        $this->cariproduk($keyword);
        $this->db->where('status', '1');
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $this->db->from('produk');
        return $this->db->count_all_results();
    }
    public function getProdukPagination($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->cariproduk($keyword);
        }
        $this->db->where('status', 1);
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $query = $this->db->get('produk', $limit, $start);
        return $query->result_array();
    }

    public function getProdukPembeliPagination($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->cariproduk($keyword);
        }
        $this->db->where('status', '1');
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $query = $this->db->get('produk', $limit, $start);
        return $query->result_array();
    }

    public function getAllProduk()
    {
        return $this->db->get('produk')->result_array();
    }
    
    public function getProdukCount()
    {
        $this->db->where('status', '1');
        $this->db->from('produk');
        return $this->db->count_all_results();
    }

    public function getAllProdukAndJenis()
    {
      $this->db->select('*');
      $this->db->from('produk');
      $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
      $query = $this->db->get();
      return $query->result_array();
    }

    public function getProdukById($idProduk)
    {
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $this->db->where('idProduk', $idProduk);
        return $this->db->get('produk')->row_array();
    }

    public function getAllJenis()
    {
        $this->db->select('*');
        $this->db->from('jenisproduk');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function findColumn(){
        $this->db->get('produk')->result_array();
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
        $idFirstName = 'UP';
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

    public function addProduk($new_image)
    {
        $data = [
            'idProduk'         => $this->random_id(),
            'idKaryawan'        => 'K001',
            'idUser'        => 'abcde',
            'idJenisProduk'    => $this->input->post('idJenisProduk'),
            'nama'             => $this->input->post('nama'),
            'warna'            => $this->input->post('warna'),
            'harga'            => $this->input->post('harga'),
            'gambar'            => $new_image,
            'deskripsi'            => $this->input->post('deskripsi'),
            'status'            => $this->input->post('status'),
            'stok'             => $this->input->post('stok')
        ];
        $this->db->insert('produk', $data);
    }

    public function updateProduk($data,$idProduk)
    {
        $this->db->set($data);
        $this->db->where('idProduk', $idProduk);
        $this->db->update('produk');
    }

    public function editdataproduk($new_image)
    {
        return $data = [
            'idJenisProduk'    => $this->input->post('idJenisProduk'),
            'nama'             => $this->input->post('nama'),
            'warna'            => $this->input->post('warna'),
            'harga'            => $this->input->post('harga'),
            'gambar'            => $new_image,
            'deskripsi'         => $this->input->post('deskripsi'),
            'status'            => $this->input->post('status'),
            'stok'             => $this->input->post('stok')
        ];
    }

    public function hapusProduk()
    {
        return $data = ['status'       => 0];
    }
}