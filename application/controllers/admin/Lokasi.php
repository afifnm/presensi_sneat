<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lokasi extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $level = $this->session->userdata('level');
        $this->load->model('CRUD_model');
        $this->load->model('Absensi_model');
        $this->load->model('Auth_model');
        $this->check_login();
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Kesiswaan")
         AND ($this->session->userdata('level') != "BK")  AND ($this->session->userdata('level') != "Guru")){
            redirect('', 'refresh');
        }
    }
    public function index(){
        $level = $this->session->userdata('level');
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Titik Lokasi | '.$site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <a href="../home" class="navigasi-link">Dashboard</a>
                    &nbsp; / &nbsp; <b> <i>Titik Lokasi</i></b>
            '
        );
        $this->template->load('layout/template', 'admin/lokasi', array_merge($data));
    } 

    public function update(){
        // Ambil data dari form
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $jangkauan = $this->input->post('jangkauan');
        // Validasi input
        if (empty($latitude) || empty($longitude) || empty($jangkauan)) {
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Semua field wajib diiisi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
            redirect('admin/lokasi');
        }
        // Data yang akan diupdate
        $data = [
            'latitude' => $latitude,
            'longtitude' => $longitude,
            'jangkauan' => $jangkauan,
        ];
        // Update data menggunakan this->db
        $this->db->where('id', 1); // ID=1 adalah contoh, sesuaikan dengan kebutuhan
        $update = $this->db->update('konfigurasi', $data);    
        // Redirect kembali ke halaman edit atau lokasi utama
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Titik lokasi berhasil ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/lokasi');
    }
    

}
