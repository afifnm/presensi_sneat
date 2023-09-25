<?php

class My404 extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->model('CRUD_model');
        $this->load->model('Absensi_model');
    }
   public function index(){
    $site = $this->Konfigurasi_model->listing();
    $data = array(
        'title'                 => '404 Error - Halaman tidak ditemukan',
        'site'                  => $site,
    );
    $this->template->load('authentication/layout/template', '404', $data);
   }
   public function cari(){
    $this->db->from('user');
    $this->db->like('nama',$this->input->get('nama'));
    $this->db->where('level','Siswa');
    $this->db->limit('100');
    $a = $this->db->get()->result_array();
    $site = $this->Konfigurasi_model->listing();
    $data = array(
        'title'                 => 'Pencarian Siswa | '.$site['nama_website'],
        'site'                  => $site,
        'cari'                  => $a,
        'nama'                  => $this->input->get('nama')
    );
    $this->load->view('cari', $data);
  }
}