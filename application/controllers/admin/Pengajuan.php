<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends MY_Controller{
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
            'title'                 => 'Daftar Pengajuan | '.$site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <a href="../home" class="navigasi-link">Dashboard</a>
                    &nbsp; / &nbsp; <b> <i>Daftar Pengajuan</i></b>
            '
        );
        $this->db->order_by('tanggal_keperluan','DESC');
        $this->db->from('pengajuan a');
        $this->db->join('user b','a.username=b.username','left');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/pengajuan', array_merge($data,$data2));
    } 
    public function delete_data($id){
        $id = array('id_pengajuan' => $id);
        $this->CRUD_model->Delete('pengajuan', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Pengajuan berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/pengajuan/');
    }
    public function edit($id){
        $id = array('id_pengajuan' => $id);
        $data = array('status' => 1);
        $this->CRUD_model->Update('pengajuan',$data, $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Pengajuan berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/pengajuan/');
    }
}
