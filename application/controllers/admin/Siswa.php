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
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Guru")
         AND ($this->session->userdata('level') != "BK")){
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
    public function lihat_bulan(){
        $tahun_masuk = $_GET['tahun_masuk'];
        $kelas = $_GET['kelas'];
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Lihat Presensiku | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'bulan'                 => $_GET['tanggal'],
            'tahun_masuk'           => $tahun_masuk,
            'kelas'                 => $kelas,
            'nav'                   => '
                      <a class="navigasi-link">Aplikasi Presensi</a>
              '
          );
          $this->db->select('*')->from('user');
        $this->db->where('tahun_masuk',$tahun_masuk);
        $this->db->where('kelas',$kelas);
        $this->db->order_by('nama','ASC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
          $this->load->view('admin/pengguna/rekap_bulan', array_merge($data, $data2));
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
        $this->db->select('*')->from('izin')->where('username',$username);
        $this->db->order_by('tanggal','DESC');
        $data3 = $this->db->get()->result_array();
        $data3 = array('data3' => $data3);
        $this->template->load('layout/template', 'admin/pengguna/profil', array_merge($data, $data2, $data3));
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
    public function reset($id,$tahun_masuk,$kelas){
        $data = array(
            'password' => get_hash('1234')
         ); 
        $where = array(
            'id' => $id,
        );
        $data = $this->CRUD_model->Update('user', $data, $where);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Password berhasil direset menjadi 1234.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/siswa/absen/'.$tahun_masuk.'/'.$kelas);
    }
    public function simpan_izin(){
        $data = array(
            'username' => $this->input->post('username'),
            'keterangan' => $this->input->post('keterangan'),
            'alasan' => $this->input->post('alasan'),
            'tanggal' => $this->input->post('tanggal'),
         );  
        $this->CRUD_model->Insert('izin', $data);
        $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Izin berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
        redirect('admin/siswa/profil/'.$this->input->post('username'));       
    }
        public function hapus_izin($id,$username){
        $id = array('id_izin' => $id);
        $this->CRUD_model->Delete('izin', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Izin siswa telah dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/siswa/profil/'.$username);
    }

}