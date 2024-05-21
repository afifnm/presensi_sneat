<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tracking extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $level = $this->session->userdata('level');
        $this->load->model('CRUD_model');
        $this->load->model('Auth_model');
        $this->load->model('Absensi_model');
        $this->load->helper('tgl_indo');
        $this->check_login();
        if ($this->session->userdata('level') != "Siswa"){
            redirect('', 'refresh');
        }
    }
    public function index(){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => $site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->db->select('*')->from('tracking');
        $this->db->where('username',$this->session->userdata('username'));
        $this->db->order_by('tanggal','DESC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'siswa/tracking', array_merge($data,$data2));
    } 
    public function simpan(){
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        tracking berhasil ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        $data = array(
            'username'  => $this->session->userdata('username'),
            'keterangan'  => $this->input->post('keterangan'),
            'karir'  => $this->input->post('karir'),
        );
        $this->db->insert('tracking',$data);
        redirect('siswa/tracking'); 
    }
    public function delete_data($id){
        $id = array('id_tracking' => $id);
        $this->CRUD_model->Delete('tracking', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        tracking berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('siswa/tracking/');
    }
}