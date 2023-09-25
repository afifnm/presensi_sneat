<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Peringatan extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $level = $this->session->userdata('level');
        $this->load->model('CRUD_model');
        $this->load->model('Auth_model');
        $this->load->model('Absensi_model');
        $this->load->helper('tgl_indo');
        $this->check_login();
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Kesiswaan")
         AND ($this->session->userdata('level') != "BK")){
            redirect('', 'refresh');
        }
    }

    public function index(){
        $site = $this->Konfigurasi_model->listing();
        $this->db->select('distinct(a.username),b.nama,b.tahun_masuk,b.kelas')->from('pelanggaran a');
        $this->db->join('user b','a.username=b.username','left');
        $this->db->order_by('a.tanggal','DESC');
        $data = array(
            'title'                 => 'Pelanggaran Siswa | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'pelanggaran'           => $this->db->get()->result_array(),
            'nav'                   => '
            <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->template->load('layout/template', 'admin/laporan/peringatan', array_merge($data));
    }
}