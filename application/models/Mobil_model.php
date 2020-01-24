<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobil_model extends CI_Model
{
    public function getStatusMobil()
    {
        return array(
            'out' => 'Keluar',
            'ready' => 'Ready',
        );
    }

    public function listMobil($where = array(), $where_like = array(), $where_status = null, $orderBy = array())
    {
        $this->db->from('mobil');

        if ($where) {
            $this->db->where($where);
        }

        if ($where_status) {
            $is_not = $where_status == 'ready' ? 'NOT IN' : 'IN';

            $this->db->where('mobil.id ' . $is_not . ' (SELECT mobil_id FROM pesanan WHERE pesanan.mobil_id = mobil.id AND status = 2)');
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

    public function totalMobil($where = array(), $where_like = array(), $where_status = null)
    {
        $this->db->from('mobil');

        if ($where) {
            $this->db->where($where);
        }

        if ($where_status) {
            $is_not = $where_status == 'ready' ? 'NOT IN' : 'IN';

            $this->db->where("mobil.id " . $is_not . " (SELECT pesanan.mobil_id FROM pesanan WHERE status = 2)");
        }

        if ($where_like) {
            $this->db->group_start();
            foreach ($where_like as $kolom => $keyword) {
                $this->db->or_like($kolom, $keyword);
            }
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function cekKode($kode)
    {
        $this->db->from('mobil');
        return $this->db->where('kode', $kode)->count_all_results();
    }

    public function addMobil($data)
    {
        $this->db->insert('mobil', $data);
    }

    public function getMobil($id)
    {
        $query = $this->db->get_where('mobil', array('id' => $id));
        return $query->row();
    }

    public function updateMobil($id, $data)
    {
        return $this->db->update('mobil', $data, array('id' => $id));
    }

    public function deleteMobil($id)
    {
        return $this->db->where('id', $id)->delete('mobil');
    }
}
