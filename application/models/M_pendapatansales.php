<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pendapatansales extends CI_Model
{   

     public function caripendapatan($keyword)
    {
        $this->db->or_like('nama', $keyword);
        $this->db->or_like('nama_user', $keyword);
    }
    //mereturn semua data pendapatan dalam array
    public function getAllPendapatan()
    {
        return $this->db->get('pendapatansales')->result_array();
    }
    //mereturn semua data pendapatan dalam array dan melakukan join
     public function getPendapatanPagination($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->caripendapatan($keyword);
        }
        $this->db->join('produk','produk.idProduk=pendapatansales.idProduk','LEFT OUTER');
        $this->db->join('user','user.idUser=produk.idUser','LEFT OUTER');
        $query = $this->db->get('pendapatansales', $limit, $start);
        return $query->result_array();
    }

     public function getPendapatanPaginationSales($limit, $start,$idUser,$keyword = null)
    {
        if ($keyword){
            $this->caripendapatan($keyword);
        }
        
        $this->db->join('produk','produk.idProduk=pendapatansales.idProduk','LEFT OUTER');
        $this->db->where('pendapatansales.idUser', $idUser);
        $query = $this->db->get('pendapatansales', $limit, $start);
        return $query->result_array();
    }

    //menghapus semua pendapatan
    public function hapuspendapatan($id)
    {
        $this->db->where('idPendapatanS', $id);
        return $this->db->delete('pendapatansales');
    }

    public function meminta()
    {
        return $data = ['statuspes'       => 1];
    }
    //melakukan acc pendapatan
    public function acc(){
        return $data = ['statuspes'       => 0,
                        'jumlahPendapatan' => 0];
    }
    //melakukan ubah status pendapatan
    public function ubahstatuspendapatan($id,$data)
    {
        $this->db->set($data);
        $this->db->where('idPendapatanS', $id);
        $this->db->update('pendapatansales');
    }

    public function getPendapatanByProduk($pemesanan)
    {
        $this->db->where('idProduk', $pemesanan['idProduk']);
        return $this->db->get('pendapatansales')->row_array();
    }

    public function getAllPendapatanByUser($user)
    {

        
        $this->db->where('idUser', $user);
        return $this->db->get('pendapatansales')->result_array();
    }

    
    public function hitungpendapatan($pendapatan,$pemesanan)
    {
         $data = [
            'jumlahPendapatan' => $pendapatan['jumlahPendapatan'] + ($pemesanan['subtotal'] - ($pemesanan['subtotal']*(10/100)))
        ];
        $this->db->set($data);
        $this->db->where('idPendapatanS', $pendapatan['idPendapatanS']);
        $this->db->update('pendapatansales');


    }

}