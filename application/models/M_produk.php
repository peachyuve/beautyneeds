<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_produk extends CI_Model
{
//fungsi untuk pencarian produk
 public function cariproduk($keyword)
    {
        $this->db->like('idProduk', $keyword);
        $this->db->or_like('nama', $keyword);
        $this->db->or_like('warna', $keyword);
        $this->db->or_like('harga', $keyword);
        $this->db->or_like('namaJenis', $keyword);
    }
    //melakukan join dan mereturn total produk
    public function totalRowsPagination($keyword)
    {
        $this->cariproduk($keyword);
        $this->db->where('status', '1');
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $this->db->from('produk');
        return $this->db->count_all_results();
    }

    //melakukan join dan mereturn produk sesuai keyword
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

    //melakukan join dan mereturn produk sesuai keyword
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

     public function getProdukPaginationSales($limit, $start,$idUser,$keyword = null)
    {
        if ($keyword){
            $this->cariproduk($keyword);
        }
        $this->db->where('idUser', $idUser);
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $query = $this->db->get('produk', $limit, $start);
        return $query->result_array();
    }

    //mereturn semua data produk dalam array
    public function getAllProduk()
    {
        return $this->db->get('produk')->result_array();
    }

    //mereturn jumlah data produk
    
    public function getProdukCount()
    {
        $this->db->where('status', '1');
        $this->db->from('produk');
        return $this->db->count_all_results();
    }
    public function getProdukCountSales($id)
    {
        $this->db->where('idUser', $id);
        $this->db->where('status', '1');
        $this->db->from('produk');
        return $this->db->count_all_results();
    }

    //mereturn semua data produk beserta jenisnya
    public function getAllProdukAndJenis()
    {
      $this->db->select('*');
      $this->db->from('produk');
      $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
      $query = $this->db->get();
      return $query->result_array();
    }

    //mereturn semua data produk berdasarkan id
    public function getProdukById($idProduk)
    {
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $this->db->where('idProduk', $idProduk);
        return $this->db->get('produk')->row_array();
    }

    public function getAllProdukAndJenisSales($id)
    {
        $this->db->join('jenisproduk','jenisproduk.idJenisProduk=produk.idJenisProduk','LEFT OUTER');
        $this->db->where('idUser', $id);
        return $this->db->get('produk')->result_array();
    }

    //mereturn jenis produk
    public function getAllJenis()
    {
        $this->db->select('*');
        $this->db->from('jenisproduk');
        $query = $this->db->get();
        return $query->result_array();
    }

     //mereturn semua kolom dari produk
    public function findColumn(){
        $this->db->get('produk')->result_array();
    }

    //untuk random angka dan huruf
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

    //fungsi untuk menambahkan produk
    public function addProduk($idUser, $new_image)
    {
        $data = [
            'idProduk'         => $this->random_id(),
            'idKaryawan'        => 'K001',
            'idUser'        => $idUser,
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

    //fungsi untuk memperbarui produk
    public function updateProduk($data,$idProduk)
    {
        $this->db->set($data);
        $this->db->where('idProduk', $idProduk);
        $this->db->update('produk');
    }

    //fungsi untuk edit data produk

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

    // fungsi untuk menghapus produk

    public function hapusProduk()
    {
        return $data = ['status'       => 0];
    }

    public function hapusprodukSales($id)
    {
        $this->db->where('idProduk', $id);
        return $this->db->delete('produk');
    }

    public function kurangiproduk($detail)
    {
        foreach ($detail as $d){
            $this->penguranganproduk($d['idProduk']);
        }
    }

    public function penguranganproduk($id)
    {
        $produk = $this->getProdukById($id);
        $data = [
            'stok' => $produk['stok'] - 1
        ];
        $this->db->set($data);
        $this->db->where('idProduk', $id);
        $this->db->update('produk');
    }
}