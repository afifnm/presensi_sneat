<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $level = $this->session->userdata('level');
        $this->load->model('CRUD_model');
        $this->load->model('Auth_model');
        $this->load->model('Absensi_model');
        $this->load->helper('tgl_indo');
        $this->check_login();
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Guru")){
            redirect('', 'refresh');
        }
    }
    public function absen($tahun_masuk,$kelas){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => $site['nama_website'],
            'site'                  => $site,
            'tahun_masuk'           => $tahun_masuk,
            'kelas'                 => $kelas,
            'nav'                   => '
                    <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->db->select('*')->from('user');
        $this->db->where('tahun_masuk',$tahun_masuk);
        $this->db->where('kelas',$kelas);
        $this->db->order_by('nama','ASC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/pengguna/index', array_merge($data,$data2));
    } 
    public function lihat(){
        $tahun_masuk = $_GET['tahun_masuk'];
        $kelas = $_GET['kelas'];
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Rekap Presensi | '.$site['nama_website'],
            'site'                  => $site,
            'tahun_masuk'           => $tahun_masuk,
            'kelas'                 => $kelas,
            'tanggal'               => $_GET['tanggal'],
            'nav'                   => '
                    <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->db->select('*')->from('user');
        $this->db->where('tahun_masuk',$tahun_masuk);
        $this->db->where('kelas',$kelas);
        $this->db->order_by('nama','ASC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/rekap_absensi', array_merge($data,$data2));
    } 
    public function cek_absen_bulan(){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Lihat Presensiku | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'bulan'                 => $_GET['bulan'],
            'username'              => $_GET['username'],
            'nav'                   => '
                      <a class="navigasi-link">Aplikasi Presensi</a>
              '
          );
          $where = array('username' => $_GET['username']);
          $data2['profil'] = $this->CRUD_model->edit_data($where,'user')->result();
          $this->template->load('layout/template', 'admin/absen_bulan', array_merge($data,$data2));
      }
    public function profil($username){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Profil '.$username.' | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'nav'                   => '
            <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $where = array('username' => $username);
        $data2['profil'] = $this->CRUD_model->edit_data($where,'user')->result();
        $this->template->load('layout/template', 'admin/pengguna/profil', array_merge($data, $data2));
    }
    public function tambah(){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Tambah Kader | '.$site['judul'],
            'site'                  => $site,
        );
        $this->template->load('layout/template', 'admin/pengguna/tambah', $data);
    }
    public function simpan(){
        $username = $this->input->post('username');
        $cekusername = $this->db->where('username', $username)->count_all_results('user');
        if ($cekusername > 0) {
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            NIS/NIP telah digunakan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
             redirect('admin/pengguna'); 
        } else{
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Pengguna berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
            $this->Auth_model->register(); 
            redirect('admin/pengguna'); 
        } 
    }
    public function delete_data($id,$tahun_masuk,$kelas){
        $id = array('id' => $id);
        $this->CRUD_model->Delete('user', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Siswa berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/siswa/absen/'.$tahun_masuk.'/'.$kelas);
    }

}
