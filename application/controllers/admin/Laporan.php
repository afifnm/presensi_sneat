<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller{
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

    public function izin(){
        $site = $this->Konfigurasi_model->listing();
        $this->db->select('a.*,b.nama,b.kelas,b.tahun_masuk')->from('izin a');
        $this->db->join('user b','a.username=b.username','left');
        $this->db->order_by('tanggal','DESC');
        $data = array(
            'title'                 => 'Rekap Izin Siswa | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'izin'                  => $this->db->get()->result_array(),
            'nav'                   => '
            <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->template->load('layout/template', 'admin/laporan/izin', array_merge($data));
    }
    public function pelanggaran(){
        $site = $this->Konfigurasi_model->listing();
        $this->db->select('a.*,b.nama,b.kelas,b.tahun_masuk,c.pelanggaran,c.poin')->from('pelanggaran a');
        $this->db->join('user b','a.username=b.username','left');
        $this->db->join('daftar_pelanggaran c','c.id_daftar_pelanggaran=a.id_daftar_pelanggaran','left');
        $this->db->order_by('tanggal','DESC');
        $data = array(
            'title'                 => 'Pelanggaran Siswa | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'pelanggaran'           => $this->db->get()->result_array(),
            'nav'                   => '
            <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->template->load('layout/template', 'admin/laporan/pelanggaran', array_merge($data));
    }
    public function prestasi(){
        $site = $this->Konfigurasi_model->listing();
        $this->db->select('a.*,b.nama as nama_siswa,b.kelas,b.tahun_masuk')->from('prestasi a');
        $this->db->join('user b','a.username=b.username','left');
        $this->db->order_by('tanggal','DESC');
        $data = array(
            'title'                 => 'Pelanggaran Siswa | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'prestasi'              => $this->db->get()->result_array(),
            'nav'                   => '
            <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->template->load('layout/template', 'admin/laporan/prestasi', array_merge($data));
    }

}