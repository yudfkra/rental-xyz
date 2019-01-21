<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobil extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('mobil_model', 'jenis_mobil_model'));

        // Cek jika user belum login.
        $this->redirectIfNotLoggedIn();
    }

    /**
     * Fungsi dari controller untuk menampilkan daftar mobil.
     *
     * @return void
     */
    public function index()
    {
        $status_mobil = $this->mobil_model->getStatusMobil();

        $where = array();
        // cek jika ada input pencarian jenis mobil.
        if ($jenis = $this->input->get('id_jenis')) {
            $where['id_jenis'] = $jenis;
        }

        $where_like = array();
        // cek jika ada input pencarian dengan kata kunci
        if ($keyword = $this->input->get('keyword')) {
            $where_like['kode'] = $keyword;
            $where_like['no_polisi'] = $keyword;
            $where_like['tahun'] = $keyword;
            $where_like['harga'] = $keyword;
        }

        // cek jika ada input pencarian status mobil
        if ($where_status = $this->input->get('status')) {
            // jika input pencarian status mobil tidak terdaftar dalam list maka set menjadi kosong.
            if (!array_key_exists($where_status, $status_mobil)) $where_status = null;
        }

        // mengambil data status mobil
        $data['status_mobil'] = $status_mobil;

        // mengambil data jenis mobil
        $data['jenis_mobil'] = $this->jenis_mobil_model->listJenis();

        // mengambil data daftar mobil dari database.
        $data['list_mobil'] = $this->mobil_model->listMobil($where, $where_like, $where_status);

        // set tampilan menggunakan view yang berada di views/mobil/list.php
        $data['view'] = 'mobil/list';

        // set judul halaman
        $data['title'] = 'Mobil';
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
            $this->doAddMobil();
        }

        // mengambil data jenis mobil
        $data['jenis_mobil'] = $this->jenis_mobil_model->listJenis();

        // beritahu ke view views/mobil/form bahwa form adalah tambah.
        $data['form_edit'] = false;

        // set tampillan menggunakan view yang erada di views/mobil/form.php
        $data['view'] = 'mobil/form';

        // set judul halaman
        $data['title'] = 'Tambah Mobil';
        $this->load->view('layout', $data);
    }

    /**
     * Fungsi untuk menambahkan data mobil.
     *
     * @return void
     */
    protected function doAddMobil()
    {
        // cek jika data yang diinput user telah valid
        if ($this->validasiInput()) {
            // mengumpulkan data yang diinput user untuk disimpan ke database.
            $data = array(
                'kode' => $this->generateKodeMobil($this->input->post('id_jenis')),
                'id_jenis' => $this->input->post('id_jenis'),
                'no_polisi' => $this->input->post('no_polisi'),
                'harga' => $this->input->post('harga'),
                'tahun' => $this->input->post('tahun'),
                'tanggal_input' => date('Y-m-d H:i:s'),
            );

            // memanggil fungsi model untuk menyimpan data.
            $this->mobil_model->addMobil($data);

            // set pesan success ke list mobil.
            $this->session->set_flashdata('success_message', 'Mobil berhasil ditambahkan.');
            redirect('mobil');
        }
    }

    /**
     * Fungsi dari controller untuk menampilkan dan merubah data mobil.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        // mengambil data mobil dari database
        $mobil = $this->mobil_model->getMobil($id);
        // jika data mobil tidak ada di database, arahkan user kembali ke halaman daftar mobil
        if (empty($mobil)) {
            // set pesan error ke user.
            $this->session->set_flashdata('error_message', 'Mobil tidak ditemukan');
            redirect('mobil');
        }

        // jika pada user mengklik submit
        if ($this->input->method() == 'post') {
            // lakukan edit mobil.
            $this->doEditMobil($mobil);
        }
        
        $data['mobil'] = $mobil;

        // mengambil data jenis mobil
        $data['jenis_mobil'] = $this->jenis_mobil_model->listJenis();

        // beritahu ke view views/mobil/form bahwa form adalah edit.
        $data['form_edit'] = true;

        // set tampillan menggunakan view yang erada di views/mobil/form.php
        $data['view'] = 'mobil/form';

        // set judul halaman
        $data['title'] = 'Edit Mobil';
        $this->load->view('layout', $data);
    }

    protected function doEditMobil($mobil)
    {
        // cek jika data yang diinput user telah valid
        if ($this->validasiInput()) {
            // mengumpulkan data yang diinput user untuk disimpan ke database.
            $data = array(
                'id_jenis' => $this->input->post('id_jenis') ?: $mobil->id_jenis,
                'no_polisi' => $this->input->post('no_polisi') ?: $mobil->no_polisi,
                'harga' => $this->input->post('harga') ?: $mobil->harga,
                'tahun' => $this->input->post('tahun') ?: $mobil->tahun,
                'tanggal_update' => date('Y-m-d H:i:s'),
            );

            // jika id jenis dari mobil diganti, maka generate kode mobil yang baru.
            if ($data['id_jenis'] != $mobil->id_jenis) {
                $data['kode'] = $this->generateKodeMobil($data['id_jenis']);
            }

            // memanggil fungsi model untuk menyimpan data mobil.
            $this->mobil_model->updateMobil($mobil->id, $data);

            // set pesan success ke list mobil.
            $this->session->set_flashdata('success_message', 'Mobil berhasil diubah.');
            redirect('mobil');
        }
    }

    /**
     * Fungsi controller untuk menghapus data mobil
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        $mobil = $this->mobil_model->getMobil($id);
        // Mengecek apakah data mobil ada di database.
        if (!empty($mobil)) {
            // jika ada hapus data mobil dengan id "$id"
            $this->mobil_model->deleteMobil($id);

            // set pesan sukses ke user.
            $this->session->set_flashdata('success_message', 'Mobil Berhasil dihapus!');
        } else {

            // jika tidak ada data mobil set pesan error ke user.
            $this->session->set_flashdata('error_message', 'Mobil tidak ditemukan');
        }

        // arahkan user kembali ke halaman list mobil.
        redirect('mobil');
    }

    /**
     * Fungsi memvalidasi data yang diinput user
     *
     * @return boolean
     */
    protected function validasiInput()
    {
        // $this->form_validation->set_rules('kode', 'Kode', 'required');
        $this->form_validation->set_rules('id_jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('no_polisi', 'No Polisi', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|exact_length[4]');

        return $this->form_validation->run();
    }

    /**
     * Fungsi untuk membuat kode mobil dari id jenis mobil yang dipilih.
     *
     * @param int $id_jenis
     *
     * @return string
     */
    protected function generateKodeMobil($id_jenis)
    {
        $jenis = $this->jenis_mobil_model->getKodeByJenis($id_jenis);
        $total = (int) $this->mobil_model->totalMobil(array('id_jenis' => $id_jenis)) + 1;

        while ($this->mobil_model->cekKode($kode = sprintf("%s%04d", $jenis, $total))) {
            $total += 1;
        }

        return $kode;
    }
}
