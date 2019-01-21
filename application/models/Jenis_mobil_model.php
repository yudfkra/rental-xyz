<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_mobil_model extends CI_Model
{
    /**
     * Fungsi untuk mendapatkan semua jenis mobil
     *
     * @return array
     */
    public function listJenis()
    {
        $query = $this->db->get('jenis_mobil')->result();
        
        $list_jenis = [];
        foreach ($query as $jenis) {
            $list_jenis[$jenis->id] = $jenis->jenis;
        }

        return $list_jenis;
    }

    /**
     * Undocumented function
     *
     * @param int $id_jenis
     *
     * @return array
     */
    public function getKodeByJenis($id_jenis)
    {
        $jenis = $this->db->get_where('jenis_mobil', array('id' => $id_jenis))->row();

        return $jenis ? $jenis->kode : array();
    }
}
