<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pemesanan extends CI_Model
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
        $this->db->or_like('tgl_pemesanan', $keyword);
        $this->db->or_like('total', $keyword);
        $this->db->or_like('status', $keyword);
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
}