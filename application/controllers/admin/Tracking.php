<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tracking extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->model('CRUD_model');
        $this->load->model('Absensi_model');
        $this->check_login();
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Kesiswaan")
         AND ($this->session->userdata('level') != "BK")  AND ($this->session->userdata('level') != "Guru")){
            redirect('', 'refresh');
        }
    }
    public function index(){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Daftar Tracking | '.$site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <a href="../home" class="navigasi-link">Dashboard</a>
                    &nbsp; / &nbsp; <b> <i>Daftar Tracking</i></b>
            '
        );
        $this->db->order_by('tanggal','DESC');
        $this->db->from('tracking a');
        $this->db->join('user b','a.username=b.username','left');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/tracking', array_merge($data,$data2));
    } 
}
