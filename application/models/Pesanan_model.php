<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan_model extends CI_Model
{
    public function getStatus()
    {
        return [
            1 => 'Selesai',
            2 => 'Proses',
            3 => 'Terlambat',
        ];
    }

    public function listPesanan($where = array(), $where_like = array(), $orderBy = array())
    {
        $this->db->select('pesanan.*, mobil.kode as kode_mobil, mobil.no_polisi');
        $this->db->from('pesanan');
        $this->db->join('mobil', 'pesanan.mobil_id = mobil.id', 'inner');

        if ($where) {
            $this->db->where($where);
        }

        if ($where_like) {
            $this->db->group_start();
            foreach ($where_like as $kolom => $keyword) {
                $this->db->or_like($kolom, $keyword);
            }
            $this->db->group_end();
        }

        $this->db->order_by("tanggal_input", "DESC");

        $query = $this->db->get();
        return $query->result();
    }

    public function addPesanan($data)
    {
        $this->db->insert("pesanan", $data);
    }

    public function getPesanan($id)
    {
        $query = $this->db->get_where('pesanan', array('id' => $id));
        return $query->row();
    }

    public function updatePesanan($id, $data)
    {
        return $this->db->update('pesanan', $data, array('id' => $id));
    }
}
