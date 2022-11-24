<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->check_login();
        $this->load->model('Absensi_model');
        $level = $this->session->userdata('level');
        if ($level != "Siswa") {
            redirect('', 'refresh');
        }
    }

    public function index(){
      $site = $this->Konfigurasi_model->listing();
      $data = array(
          'title'                 => 'Dashboard | '.$site['nama_website'],
          'favicon'               => $site['favicon'],
          'site'                  => $site,
          'nav'                   => '
                    <a class="navigasi-link">Aplikasi Presensi</a>
            '
        );
        $this->template->load('layout/template', 'siswa/dashboard', array_merge($data));
    }
    public function lihat(){
      $site = $this->Konfigurasi_model->listing();
      $data = array(
          'title'                 => 'Lihat Presensiku | '.$site['nama_website'],
          'favicon'               => $site['favicon'],
          'site'                  => $site,
          'bulan'                 => $_GET['bulan'],
          'nav'                   => '
                    <a class="navigasi-link">Aplikasi Presensi</a>
            '
        );
        $this->template->load('layout/template', 'siswa/lihat', array_merge($data));
    }
    public function absen(){
      $site = $this->Konfigurasi_model->listing();
      $data = array(
          'title'                 => 'Absensi | '.$site['nama_website'],
          'favicon'               => $site['favicon'],
          'site'                  => $site
        );
        $this->template->load('layout/template', 'siswa/absen', array_merge($data));
    }
    public function masuk(){
      date_default_timezone_set("Asia/Jakarta");
      $tanggal = date("Y-m-d");
      $jam = date("H:i:s");
      $cek = $this->Absensi_model->cek_absen_masuk_now();
      if ($cek>0) {
        $this->session->set_flashdata('alert', '<p class="box-msg">
        <div class="info-box alert-success"><div class="info-box-icon">
        <i class="fa fa-check"></i></div>
        <div class="info-box-content" style="font-size:14">
        <b style="font-size: 20px">SUCCESS</b><br>Kamu sudah melakukan absen masuk.</div>
        </div></p>');
        redirect('siswa/home/'); 
      } else {
        $data2 = array(
            'username' => $this->session->userdata('username'),
            'tanggal' => $tanggal,
            'masuk' => $jam,
            'ip' => $this->Absensi_model->get_ip()
         );  
        $this->Absensi_model->Insert('absen', $data2);
        $this->session->set_flashdata('alert', '<p class="box-msg">
        <div class="info-box alert-success"><div class="info-box-icon">
        <i class="fa fa-check"></i></div>
        <div class="info-box-content" style="font-size:14">
        <b style="font-size: 20px">SUCCESS</b><br>Absen masuk berhasil.</div>
        </div></p>');
        redirect('siswa/home/'); 
      }      
    }

    public function pulang(){
      date_default_timezone_set("Asia/Jakarta");
      $tanggal = date("Y-m-d");
      $jam = date("H:i:s");
      $cek = $this->Absensi_model->cek_absen_masuk_now();
      if ($cek>0) {
        $data = array(
            'pulang' => $jam,
            'ip2' => $this->Absensi_model->get_ip()
         ); 
        $where = array(
            'username' => $this->session->userdata('username'),
            'tanggal' => $tanggal,
        );
        $data = $this->Absensi_model->Update('absen', $data, $where);
      } else {
        $data2 = array(
            'username' => $this->session->userdata('username'),
            'tanggal' => $tanggal,
            'pulang' => $jam,
            'ip2' => $this->Absensi_model->get_ip()
         );  
        $this->Absensi_model->Insert('absen', $data2);
      }
      $this->session->set_flashdata('alert', '<p class="box-msg">
      <div class="info-box alert-success"><div class="info-box-icon">
      <i class="fa fa-check"></i></div>
      <div class="info-box-content" style="font-size:14">
      <b style="font-size: 20px">SUCCESS</b><br>Kamu telah melakukan absen pulang.</div>
      </div></p>');
      redirect('siswa/home/');       
    }

}
