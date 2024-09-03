<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $level = $this->session->userdata('level');
        $this->load->model('CRUD_model');
        $this->load->model('Absensi_model');
        $this->load->model('Auth_model');
        $this->check_login();
        if ($this->session->userdata('level') != "Admin"){
            redirect('', 'refresh');
        }
    }
    public function index(){
        $level = $this->session->userdata('level');
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Data Admin | '.$site['nama_website'],
            'site'                  => $site,
            'nav'                   => '
                    <a href="../home" class="navigasi-link">Dashboard</a>
                    &nbsp; / &nbsp; <b> <i>Data Admin</i></b>
            '
        );
        $this->db->select('*')->from('user');
        $this->db->or_where('level','BK');
        $this->db->or_where('level','Kurikulum');
        $this->db->or_where('level','Kesiswaan');
        $this->db->or_where('level','Guru');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/admin', array_merge($data,$data2));
    } 

    public function simpan(){
        $username = $this->input->post('username');
        $cekusername = $this->db->where('username', $username)->count_all_results('user');
        if ($cekusername > 0) {
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Username/NIS/NIP telah digunakan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
             redirect('admin/admin'); 
        } else{
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Admin berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
                $data = array(
                    'username' => $this->input->post('username'),
                    'foto' => 'root.jpg',
                    'password' => get_hash($this->input->post('password')),
                    'nama' => $this->input->post('nama'),
                    'level' => $this->input->post('level'),
                    'active' => 1,
                  );
                  $this->db->insert('user', $data);
            redirect('admin/admin'); 
        } 
    }
    public function delete_data($id){
        $id = array('id' => $id);
        $this->CRUD_model->Delete('user', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Pengguna berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/admin/');
    }
    public function reset($id){
        $data = array(
            'password' => get_hash('1234')
         ); 
        $where = array(
            'id' => $id,
        );
        $data = $this->CRUD_model->Update('user', $data, $where);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Password berhasil direset menjadi 1234.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/admin/');
    }
    public function import_data() {
        $postData = $this->input->post('data');
        $data = json_decode($postData, true);
        if (!empty($data)) {
            foreach ($data as $row) {
                $insertData = array(
                    'username' => $row['username'],
                    'password' => password_hash($row['password'], PASSWORD_DEFAULT),
                    'level' => $row['level'],
                    'nama' => $row['nama'],
                    'kelas' => $row['kelas'],
                    'tahun_masuk' => $row['tahun_masuk']
                );
                // Insert into the database
                $this->db->insert('user',$insertData);
            }
            $this->session->set_flashdata('alert', '<div class="alert alert-success">Data berhasil diimport!</div>');
        } else {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger">Gagal mengimport data.</div>');
        }
        // Send a JSON response
        echo json_encode(['status' => 'success']);
    }  
}
