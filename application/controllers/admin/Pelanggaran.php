<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggaran extends MY_Controller{
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
            'title'                 => 'Daftar Pelanggaran | '.$site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <a href="../home" class="navigasi-link">Dashboard</a>
                    &nbsp; / &nbsp; <b> <i>Daftar Pelanggaran</i></b>
            '
        );
        $this->db->from('daftar_pelanggaran');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/pelanggaran', array_merge($data,$data2));
    } 
    public function simpan(){
        $data = array(
            'pelanggaran' => $this->input->post('pelanggaran'),
            'poin' => $this->input->post('poin')
         );  
        $this->CRUD_model->Insert('daftar_pelanggaran', $data);
        $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Jenis pelanggaran berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
        redirect('admin/pelanggaran/');       
    }
    public function update(){
        $data = array(
            'pelanggaran' => $this->input->post('pelanggaran'),
            'poin' => $this->input->post('poin')
         );  
        $where = array(
            'id_daftar_pelanggaran' => $this->input->post('id_daftar_pelanggaran')
        );
        $this->CRUD_model->Update('daftar_pelanggaran', $data, $where);
        $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Jenis pelanggaran berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
        redirect('admin/pelanggaran/');       
    }
    public function delete_data($id){
        $id = array('id_daftar_pelanggaran' => $id);
        $this->CRUD_model->Delete('daftar_pelanggaran', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Jenis pelanggaran berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/pelanggaran/');
    }

}
