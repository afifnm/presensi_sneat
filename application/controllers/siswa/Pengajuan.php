<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends MY_Controller{
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
        $this->db->select('*')->from('pengajuan');
        $this->db->where('username',$this->session->userdata('username'));
        $this->db->order_by('tanggal_submit','DESC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'siswa/pengajuan', array_merge($data,$data2));
    } 
    public function simpan(){
        $this->db->where('tanggal_keperluan',$this->input->post('tanggal_keperluan'));
        $cek = $this->db->where('username', $this->session->userdata('username'))->count_all_results('pengajuan');
        if ($cek > 0) {
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Kamu telah mengajuakan pengajuan pada hari itu, silahkan pilih hari lain.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
             redirect('siswa/pengajuan'); 
        } else{
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Pengajuan berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
            $data = array(
                'username'  => $this->session->userdata('username'),
                'tanggal_keperluan'  => $this->input->post('tanggal_keperluan'),
                'keperluan'  => $this->input->post('keperluan'),
            );
            $this->db->insert('pengajuan',$data);
            redirect('siswa/pengajuan'); 
        } 
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
        redirect('siswa/pengajuan/');
    }
}