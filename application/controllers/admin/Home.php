<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->model('CRUD_model');
        $this->load->model('Absensi_model');
        $this->check_login();
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Guru")
         AND ($this->session->userdata('level') != "BK")){
            redirect('', 'refresh');
        }
    }

    public function index(){

        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Dashboard | '.$site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <a href="../home" class="navigasi-link">Dashboard</a>
            '
        );
        $this->template->load('layout/template', 'admin/dashboard', array_merge($data));
    }
}
 