<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getUser($where = array())
    {
        if ($where) {
            $this->db->where($where);
        }

        return $this->db->get('user');
    }
}
