<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $level = $this->session->userdata('level');
        $this->load->model('CRUD_model');
        $this->load->model('Auth_model');
        $this->load->model('Absensi_model');
        $this->load->helper('tgl_indo');
        $this->check_login();
        if (($this->session->userdata('level') != "Admin") AND ($this->session->userdata('level') != "Guru")){
            redirect('', 'refresh');
        }
    }
    public function absen($tahun_masuk,$kelas){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => $site['nama_website'],
            'site'                  => $site,
            'tahun_masuk'           => $tahun_masuk,
            'kelas'                 => $kelas,
            'nav'                   => '
                    <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->db->select('*')->from('user');
        $this->db->where('tahun_masuk',$tahun_masuk);
        $this->db->where('kelas',$kelas);
        $this->db->order_by('nama','ASC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/pengguna/index', array_merge($data,$data2));
    } 
    public function lihat(){
        $tahun_masuk = $_GET['tahun_masuk'];
        $kelas = $_GET['kelas'];
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Rekap Presensi | '.$site['nama_website'],
            'site'                  => $site,
            'tahun_masuk'           => $tahun_masuk,
            'kelas'                 => $kelas,
            'tanggal'               => $_GET['tanggal'],
            'nav'                   => '
                    <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $this->db->select('*')->from('user');
        $this->db->where('tahun_masuk',$tahun_masuk);
        $this->db->where('kelas',$kelas);
        $this->db->order_by('nama','ASC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
        $this->template->load('layout/template', 'admin/rekap_absensi', array_merge($data,$data2));
    } 
    public function lihat_bulan(){
        $tahun_masuk = $_GET['tahun_masuk'];
        $kelas = $_GET['kelas'];
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Lihat Presensiku | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'bulan'                 => $_GET['tanggal'],
            'tahun_masuk'           => $tahun_masuk,
            'kelas'                 => $kelas,
            'nav'                   => '
                      <a class="navigasi-link">Aplikasi Presensi</a>
              '
          );
          $this->db->select('*')->from('user');
        $this->db->where('tahun_masuk',$tahun_masuk);
        $this->db->where('kelas',$kelas);
        $this->db->order_by('nama','ASC');
        $data2 = $this->db->get()->result_array();
        $data2 = array('data2' => $data2);
          $this->load->view('admin/pengguna/rekap_bulan', array_merge($data, $data2));
      }
    public function cek_absen_bulan(){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Lihat Presensiku | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'bulan'                 => $_GET['bulan'],
            'username'              => $_GET['username'],
            'nav'                   => '
                      <a class="navigasi-link">Aplikasi Presensi</a>
              '
          );
          $where = array('username' => $_GET['username']);
          $data2['profil'] = $this->CRUD_model->edit_data($where,'user')->result();
          $this->template->load('layout/template', 'admin/absen_bulan', array_merge($data,$data2));
      }
    public function profil($username){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Profil '.$username.' | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
            'nav'                   => '
            <b> <i>Aplikasi Presensi Siswa</i></b>
            '
        );
        $where = array('username' => $username);
        $data2['profil'] = $this->CRUD_model->edit_data($where,'user')->result();
        $this->template->load('layout/template', 'admin/pengguna/profil', array_merge($data, $data2));
    }
    public function tambah(){
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Tambah Kader | '.$site['judul'],
            'site'                  => $site,
        );
        $this->template->load('layout/template', 'admin/pengguna/tambah', $data);
    }
    public function simpan(){
        $username = $this->input->post('username');
        $cekusername = $this->db->where('username', $username)->count_all_results('user');
        if ($cekusername > 0) {
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            NIS/NIP telah digunakan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
             redirect('admin/pengguna'); 
        } else{
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Pengguna berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
            $this->Auth_model->register(); 
            redirect('admin/pengguna'); 
        } 
    }
    public function delete_data($id,$tahun_masuk,$kelas){
        $id = array('id' => $id);
        $this->CRUD_model->Delete('user', $id);
        $this->session->set_flashdata('alert', '
        <div class="alert alert-primary alert-dismissible" role="alert">
        Siswa berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            ');
        redirect('admin/siswa/absen/'.$tahun_masuk.'/'.$kelas);
    }
    public function reset($id,$tahun_masuk,$kelas){
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
        redirect('admin/siswa/absen/'.$tahun_masuk.'/'.$kelas);
    }
    public function import_excel()
    {
        if(isset($_FILES["file"]["name"])){
              // upload
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_type=$_FILES['file']['type'];
            // move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads
            
            $object = PHPExcel_IOFactory::load($file_tmp);
    
            foreach($object->getWorksheetIterator() as $worksheet){
    
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
    
                for($row=4; $row<=$highestRow; $row++){
    
                    $password = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $kelas = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $nis = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $tahun_masuk = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

                    $data[] = array(
                        'username'          => $nis,
                        'password'          =>get_hash($password),
                        'level'         =>'Siswa',
                        'nama'         =>$nama,
                        'kelas'         =>$kelas,
                        'tahun_masuk'         =>$tahun_masuk,
                    );
    
                } 
    
            }
    
            $this->db->insert_batch('user', $data);
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Import data dari excel berhasil.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
            redirect('admin/home');
        }
        else
        {
            $this->session->set_flashdata('alert', '
            <div class="alert alert-primary alert-dismissible" role="alert">
            Import data dari excel gagal.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                ');
            redirect('admin/home');
        }
    }

}