<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pemesanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_pembayaran');
    }
	public function getPemesananCount()
    {
        
        $this->db->where('statuspm', 1);
        return $this->db->count_all('pemesanan');
    }

    public function getAllPemesanan()
    {
        $this->db->select("*");
        $this->db->from('pemesanan');
        $this->db->join('user','user.idUser=pemesanan.idUser','LEFT OUTER');
        $this->db->join('pembayaran','pembayaran.idPembayaran=pemesanan.idPembayaran','LEFT OUTER');
        $this->db->join('jenisbayar','jenisbayar.idJenisBayar=pembayaran.idJenisBayar','LEFT OUTER');
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
        
        $this->db->like('idPemesanan', $keyword);
        $this->db->or_like('tgl_pemesanan', $keyword);
        $this->db->or_like('total', $keyword);
        $this->db->or_like('statuspm', $keyword);   
    }

    public function hapusDetailPemesanan($idPemesanan)
    {
        $this->db->where('idPemesanan', $idPemesanan);
        return $this->db->delete('detail_pemesanan');
    }
    public function hapusPemesanan($idPemesanan)
    {
        $this->db->where('idPemesanan', $idPemesanan);
        return $this->db->delete('pemesanan');
    }

    public function getPemesananPaginationByUser($limit, $start, $id_user, $keyword = null)
    {
        if ($keyword){
            $this->caripemesanan($keyword);
        }
        $this->db->where('user.idUser',$id_user);
        $this->db->join('user','user.idUser=pemesanan.idUser','LEFT OUTER');
        $this->db->join('pembayaran','pembayaran.idPembayaran = pemesanan.idPembayaran', 'LEFT OUTER');
        $this->db->join('jenisbayar','pembayaran.idJenisBayar = jenisbayar.idJenisBayar', 'LEFT OUTER');
        $query = $this->db->get('pemesanan', $limit, $start);
        return $query->result_array();
    }

    public function totalRowsPaginationByUser($keyword, $idUser)
    {
        if ($keyword){
            $this->caripemesanan($keyword);
        }
        $this->db->where('idUser',$idUser);
        $this->db->from('pemesanan');
        return $this->db->count_all_results();
    }

    public function findColumn(){
        $this->db->get('pemesanan')->result_array();
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
        $idFirstName = 'PM';
        $idList = $this->findColumn();
        if ($idList) {
            $isUnique = false;
            while(!$isUnique) { 
                $id = $this->randomGenerator(5);
                $id = $id;
                if(!in_array($id, $idList['idPemesanan'])){
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
    public function proses($idUser, $idPembayaran)
    {
        // INSERT DATA KE TABEL PEMESANAN
        $dataPemesanan = array(
            'idPemesanan'  => $this->random_id(),
            'idUser'       => $idUser,
            'tgl_pemesanan' => date('Y-m-d'),
            'total'         => $this->cart->total(),
            'idPembayaran' => $idPembayaran,
            'statuspm'        => 0,
            'idKaryawan'    => 'K001'
        );

        $this->db->insert('pemesanan', $dataPemesanan);
        
        $idPemesanan = $dataPemesanan['idPemesanan'];

        // INSERT DATA KE TABEL DETAIL_PEMESANAN
        foreach ($this->cart->contents() as $items)
        {
            $dataDetailPemesanan = array(
                'idPemesanan'  => $idPemesanan,
                'idProduk'       => $items['id'],
                'jumlah'        => $items['qty'],
                'subtotal'      => $items['subtotal']
            );

            $this->db->insert('detail_pemesanan', $dataDetailPemesanan);
        }

        return true;
    }
    public function selesai()
    {
        return $data = ['statuspm'       => 1];
    }
    public function sudahbayar()
    {
        return $data = ['statuspm'       => 2];
    }
    public function ubahstatuspemesanan($idPemesanan,$data)
    {
        $this->db->set($data);
        $this->db->where('idPemesanan', $idPemesanan);
        $this->db->update('pemesanan');
    }
     

}