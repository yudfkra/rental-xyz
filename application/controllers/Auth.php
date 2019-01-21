<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    /**
     * Fungsi untuk menampilkan halaman login.
     *
     * @return void
     */
    public function login()
    {
        // cek jika user sudah login.
        if ($this->getUserSession()) {
            redirect();
        }

        // jika user melakukan login.
        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            // jika validasi berhasiil.
            if ($this->form_validation->run()) {
                // panggil fungsi untuk login.
                $this->doLogin();
            }
        }

        $data['view'] = 'login';

        $data['title'] = 'Login';
        $this->load->view('layout', $data);
    }

    /**
     * Fungsi untuk logout.
     *
     * @return void
     */
    public function logout()
    {
        $this->redirectIfNotLoggedIn();

        // hapus data user pada session.
        $this->session->sess_destroy();

        // $this->session->set_flashdata('success_message', 'Anda telah logout.');

        redirect('auth/login');
    }
    
    /**
     * Fungsi untuk melakukan login
     *
     * @return void
     */
    protected function doLogin()
    {
        // cek ke database untuk mencari user dengan email yang diinput
        $user = $this->user_model->getUser(array('email' => $this->input->post('email')))->row();

        // jika user terdaftar, cek passwordnya.
        if ($user) {
            if (password_verify($this->input->post('password'), $user->password)) {
                // simpan data user yang sedang login di session.
                $this->session->set_userdata('user_id', $user->id);

                // kirim pesan selamat datang ke user.
                $this->session->set_flashdata('success_message', 'Selamat datang ' . $user->nama . '!');
                redirect();
            }
        }

        // kirim pesan ke user jika email atau password nya tidak cocok.
        $this->session->set_flashdata('error_message', 'Email atau Password anda salah!');
    }
}
