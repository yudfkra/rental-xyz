<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends MY_Controller
{
    /**
     * Nilai denda
     *
     * @var integer
     */
    public $denda = 50000;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('pesanan_model', 'mobil_model'));

        // Cek jika user belum login.
        $this->redirectIfNotLoggedIn();
    }

    /**
     * Fungsi dari controller untuk menampilkan list pesanan
     *
     * @return void
     */
    public function index()
    {
        $data['status'] = $this->pesanan_model->getStatus();

        // mengambil data daftar mobil dari database.
        $data['list_pesanan'] = $this->pesanan_model->listPesanan();

        // set tampilan menggunakan view yang berada di views/pesanan/list.php
        $data['view'] = 'pesanan/list';

        // set judul halaman
        $data['title'] = 'Pesanan';
        $this->load->view('layout', $data);
    }

    /**
     * Fungsi dari controller untuk menampilkan view.
     *
     * @return void
     */
    public function add()
    {
        // cek jika user menglik submit
        if ($this->input->method() == 'post') {
            // lakukan penambahan data mobil
            $this->doAddPesanan();
        }

        // mengambil data mobil
        $list_mobil = $this->mobil_model->listMobil(array(), array(), 'ready');
        $mobil = [];
        foreach ($list_mobil as $_mobil) {
            $mobil[$_mobil->id] = "{$_mobil->kode} - {$_mobil->no_polisi}";
        }

        // mengecek jika tidak ada data mobil yang tersedia
        if (empty($mobil)) {
            // jika data mobil kosong beri pesan ke admin untuk menambahkan data mobil
            $data['warning_message'] = 'Saat ini tidak ada mobil yang tersedia. silahkan menambahkan <a href="' . site_url('mobil/add') . '">data mobil</a> terlebih dahulu.';
        }

        // set data mobil ke view
        $data['mobil'] = $mobil;


        // set tampillan menggunakan view yang erada di views/pesanan/form.php
        $data['view'] = 'pesanan/form';

        // set judul halaman
        $data['title'] = 'Tambah Pesanan';
        $this->load->view('layout', $data);
    }

    /**
     * Funsgi dari controller untuk merubah status pesanan.
     *
     * @param int $id
     * @param int $status
     *
     * @return void
     */
    public function update($id, $status)
    {
        // mengambil data pesanan dari database
        $pesanan = $this->pesanan_model->getPesanan($id);
        // jika data pesanan tidak ada di database, arahkan user kembali ke halaman daftar pesanan
        if (empty($pesanan) && $pesanan->status != 2) {
            // set pesan error ke user.
            $this->session->set_flashdata('error_message', 'Pesanan tidak ditemukan');
        } else {
            if (array_key_exists($status, $this->pesanan_model->getStatus())) {
                // siapkan data untuk di update.
                $tanggal_kembali = date('Y-m-d H:i:s');

                $data = array(
                    'status' => $status,
                    'tanggal_kembali' => $tanggal_kembali,
                );

                if ($status == 3) {
                    $batas = new DateTime($pesanan->tanggal_batas_kembali);
                    
                    $data['denda'] = $this->denda * $batas->diff(new DateTime($tanggal_kembali))->days;
                }

                $this->pesanan_model->updatePesanan($id, $data);
                // set pesan sukses ke user
                $this->session->set_flashdata('success_message', 'Status Pesanan berhasil diubah.');
            } else {
                // set pesan error ke user.
                $this->session->set_flashdata('error_message', 'Aksi tidak ditemukan');
            }
        }
        redirect('pesanan');
    }

    /**
     * Fungsi untuk menambahkan data mobil.
     *
     * @return void
     */
    protected function doAddPesanan()
    {
        // cek jika data yang diinput user telah valid
        if ($this->validasiInput()) {
            // mengumpulkan data yang diinput user untuk disimpan ke database.
            $data = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'mobil_id' => $this->input->post('mobil_id'),
                'total_harga' => $this->mobil_model->getMobil($this->input->post('mobil_id'))->harga,
                'denda' => 0,
                'tanggal_batas_kembali' => $this->input->post('tanggal_batas_kembali'),
                'tanggal_input' => date('Y-m-d H:i:s'),
                'status' => 2, // proses
            );

            // memanggil fungsi model untuk menyimpan data.
            $this->pesanan_model->addPesanan($data);

            // set pesan success ke list pesanan.
            $this->session->set_flashdata('success_message', 'Pesanan berhasil ditambahkan.');
            redirect('pesanan');
        }
    }

    /**
     * Fungsi memvalidasi data yang diinput user
     *
     * @return boolean
     */
    protected function validasiInput()
    {
        $list_mobil = $this->mobil_model->listMobil(array(), array(), 'ready');

        $mobil = [];
        foreach ($list_mobil as $_mobil) {
            $mobil[] = $_mobil->id;
        }

        // $this->form_validation->set_rules('kode', 'Kode', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('mobil_id', 'Mobil', 'required|in_list[' . implode(',', $mobil) . ']');
        $this->form_validation->set_rules('tanggal_batas_kembali', 'Tanggal Batas Kembali', 'required');

        return $this->form_validation->run();
    }
}