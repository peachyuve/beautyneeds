<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembayaran extends CI_Model
{
	public function getPemesananCount()
    {
        return $this->db->count_all('pemesanan');
    }

    public function getAllPemesanan()
    {
        $this->db->select("*");
        $this->db->from('pemesanan');
        $this->db->join('user','user.idUser=pemesanan.idUser','LEFT OUTER');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDetailPemesanan($idPemesanan)
    {
        $this->db->where('idPemesanan', $idPemesanan);
        $this->db->from('detail_pemesanan');
        $this->db->join('produk','produk.idProduk=detail_pemesanan.idProduk','LEFT OUTER');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function totalRowsPagination($keyword)
    {
        $this->cariPemesanan($keyword);
        $this->db->from('pemesanan');
        return $this->db->count_all_results();
    }

    public function getPemesananPagination($limit, $start, $keyword = null){
        if ($keyword){
            $this->caripemesanan($keyword);
        }
        
        $this->db->join('user','user.idUser=pemesanan.idUser','LEFT OUTER');
        $query = $this->db->get('pemesanan', $limit, $start);
        return $query->result_array();
    }

    public function cariPemesanan($keyword)
    {
        $this->db->or_like('tgl_pemesanan', $keyword);
        $this->db->or_like('total', $keyword);
        $this->db->or_like('status', $keyword);
    }

    public function getAllJenis()
    {
        $this->db->select('*');
        $this->db->from('jenisbayar');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function findColumn(){
        $this->db->get('pembayaran')->result_array();
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
        $idFirstName = 'PB';
        $idList = $this->findColumn();
        if ($idList) {
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if(!in_array($id, $idList['idPembayaran'])){
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

    public function addPembayaran(){

        $dataPembayaran = array(
            'idPembayaran'  => $this->random_id(),
            'tanggalBayar' => date('Y-m-d'),
            'idKaryawan'         => 'K001',
            'idJenisBayar' => $this->input->post('idJenisBayar'),
            'status'        => 0
        );

        $this->db->insert('pembayaran', $dataPembayaran);
        return $dataPembayaran['idPembayaran'];
    }

    public function uploadbukti($idPembayaran,$image){

        $data = ['bukti' => $image];
        $this->db->set($data);
        $this->db->where('idPembayaran', $idPembayaran);
        $this->db->update('pembayaran');
    }
}