<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";
// use namespace
use chriskacerguis\RestServer\RestController;
class Api extends RestController {
    public function __construct(){
        parent::__construct();
        // Membatasi Jumlah akses sesuai kebutuhan
        $this->methods['index_get']['limit'] = 200;
    }
    public function login_post(){
        $username = $this->post('username');
        $password = $this->post('password');
        $this->db->select('*')->from('user')->where('username',$username);
        $query = $this->db->get()->row();
        //jika bernilai 1 maka user tidak ditemukan
        if (!$query) {
            $this->response([
                'status' => false,
                'message' => 'Username tidak ada'
            ], RestController::HTTP_BAD_REQUEST);
        }
        //jika bernilai 3 maka password salah
        if (!hash_verified($this->input->post('password'), $query->password)) {
            $this->response([
                'status' => false,
                'message' => 'Password salah'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->response([
                'status' => true,
                'message' => 'Berhasil login'
            ], RestController::HTTP_OK);
        }
    }
    public function index_get(){
        $id = $this->get('username');
        if ($id === null) {
            $this->db->select('*')->from('user')->order_by('username','ASC');
            $users = $this->db->get()->result_array();
        } else {
            $this->db->select('*')->from('user')->where('username',$id);
            $users = $this->db->get()->result_array();
            $this->db->select('*')->from('izin')->where('username',$id);
            $this->db->order_by('tanggal','DESC');
            $izin = $this->db->get()->result_array();
            $this->db->select('*')->from('pelanggaran a')->where('a.username',$id);
            $this->db->join('daftar_pelanggaran b','a.id_daftar_pelanggaran=b.id_daftar_pelanggaran','LEFT');
            $this->db->order_by('tanggal','DESC');
            $pelanggaran = $this->db->get()->result_array();
            $this->db->select('*')->from('prestasi')->where('username',$id);
            $this->db->order_by('tanggal','DESC');
            $prestasi = $this->db->get()->result_array();
        }
        if ($users) {
            $this->response([
                'status' => true,
                'user' => $users,
                'izin' => $izin,
                'pelanggaran' => $pelanggaran,
                'prestasi' => $prestasi,
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'username tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        }
    }
    public function index_post(){
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date("Y-m-d");
        $jam = date("H:i:s");
        $username = $this->post('username');
        $this->db->from('absen')->where("username", $username)->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
        $cek =  $this->db->count_all_results();
        if ($username== NULL){
            $this->response([
                'status' => false,
                'message' => 'Username not found'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($cek>0){
            $this->response([
                'status' => false,
                'message' => 'Sudah melakukan absen'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $data = [
                'username' => $username,
                'tanggal' => $tanggal,
                'masuk' => $jam,
            ];
            $this->db->Insert('absen', $data);
            $this->response([
                'status' => true,
                'message' => 'Berhasil melakukan absen'
            ], RestController::HTTP_CREATED);
        } 
    }
    public function index_put(){
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date("Y-m-d");
        $jam = date("H:i:s");
        $username = $this->put('username');
        $this->db->from('absen')->where("username", $username)->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
        $cek =  $this->db->count_all_results();
        if ($cek>0){
            $data = array('pulang' => $jam); 
            $where = array(
                'username' => $username,
                'tanggal' => $tanggal,
            );
            $data = $this->db->Update('absen', $data, $where);
            $this->response([
                'status' => false,
                'message' => 'berhasil melakukan absen pulang'
            ], RestController::HTTP_OK);
        } else {
            $data = [
                'username' => $username,
                'tanggal' => $tanggal,
                'pulang' => $jam,
            ];
            $this->db->Insert('absen', $data);
            $this->response([
                'status' => true,
                'message' => 'Berhasil melakukan absen pulang tanpa absen masuk sebelumnya'
            ], RestController::HTTP_CREATED);
        } 
    }
}
