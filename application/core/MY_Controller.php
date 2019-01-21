<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // load model mobil, jenis_mobil
        $this->load->model(array('user_model'));
        // load helper
        $this->load->helper(array('my_helper', 'form_helper'));
        // load library untuk input validasi.
        $this->load->library(array('form_validation'));
    }

    /**
     * Funsgi untuk mendapatkan data user yang sedang login.
     * jika tidak ada user yang login maka akan mengembalikan nilai false.
     *
     * @return object|boolean
     */
    protected function getUserSession()
    {
        $where = array(
            'id' => $this->session->userdata('user_id'),
        );

        $user = $this->user_model->getUser($where)->row();
        return $user ? $user : false;
    }

    /**
     * Fungsi untuk mengecek user sudah login/belum.
     * jika belum login maka akan dilempar ke halaman login.
     * 
     * @return void
     */
    protected function redirectIfNotLoggedIn()
    {
        if (!$this->getUserSession()) {
            $this->session->set_flashdata('error_message', 'Silahkan login untuk melanjutkan.');

            redirect('auth/login');
        }
    }
}
