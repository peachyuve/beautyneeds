<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pendapatansales extends CI_Model
{   
    //mereturn semua data pendapatan dalam array
    public function getAllPendapatan()
    {
        return $this->db->get('pendapatansales')->result_array();
    }
    //mereturn semua data pendapatan dalam array dan melakukan join
     public function getPendapatanPagination($limit, $start, $keyword = null)
    {
        if ($keyword){
            $this->carilaba($keyword);
        }
        $this->db->join('produk','produk.idProduk=pendapatansales.idProduk','LEFT OUTER');
        $this->db->join('user','user.idUser=produk.idUser','LEFT OUTER');
        $query = $this->db->get('pendapatansales', $limit, $start);
        return $query->result_array();
    }

    //menghapus semua pendapatan
    public function hapuspendapatan($id)
    {
        $this->db->where('idPendapatanS', $id);
        return $this->db->delete('pendapatansales');
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

}