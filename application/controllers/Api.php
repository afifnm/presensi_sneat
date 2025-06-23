<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "libraries/Format.php";
require APPPATH . "libraries/RestController.php";
// use namespace
use chriskacerguis\RestServer\RestController;
class Api extends RestController {
    public function __construct(){
        parent::__construct();
        $this->load->model('Absensi_model');
        // Membatasi Jumlah akses sesuai kebutuhan
        //$this->methods['index_get']['limit'] = 200;
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
                'message' => 'Berhasil login',
                'user'   => $query
            ], RestController::HTTP_OK);
        }
    }
    public function index_get(){
        $id = $this->get('username');
        if ($id === null) {
            $this->db->select('*')->from('user')->order_by('username','ASC');
            $users = $this->db->get()->result_array();
            $izin = NULL;
            $pelanggaran = NULL;
            $prestasi = NULL;
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
    public function report_get(){
        $username = $this->get('username');
        if ($username === null) {
            $data = NULL;
        } else {
            $tanggal = date('Y-m-d'); // Mendapatkan tanggal hari ini
            $pisah=explode("-",$tanggal);
            $tahun = $pisah[0];
            $month = $pisah[1];
            $this->db->select('LAST_DAY("'.$tanggal.'") as tanggal');
            $end= $this->db->get()->row()->tanggal;
            $pisah=explode("-",$end);
            $date_end = $pisah[2];
            $data = []; // Inisialisasi array kosong
            for ($i=1; $i<=$date_end ; $i++) {
                if($i>10){ $no=$i; } else { $no='0'.$i; }
                $tanggal=$tahun.'-'.$month.'-'.$no; 
                $masuk = $this->Absensi_model->get_masuk($username,$tanggal);
                $pulang = $this->Absensi_model->get_pulang($username,$tanggal);
                $tanggal = $i.'-'.$month.'-'.$tahun;
                // Simpan ke dalam array
                $data[] = [
                    'tanggal' => $tanggal,
                    'masuk' => $masuk,
                    'pulang' => $pulang
                ];
            } 
        }
        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data,
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        }
    }
    public function lokasi_get(){
        $this->db->select('*')->from('konfigurasi');
        $data = $this->db->get()->row();
        if ($data) {
            $this->response([
                'status' => true,
                'latitude' => $data->latitude,
                'longtitude' => $data->longtitude,
                'jangkauan' => $data->jangkauan
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
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
    public function pengajuan_post() {
        header("Access-Control-Allow-Origin: https://alumni.smkn2kra.sch.id");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        $username          = $this->post('username');
        $keperluan         = $this->post('keperluan');
        $tanggal_keperluan = $this->post('tanggal_keperluan');
        // Validasi input
        if (!$username || !$keperluan || !$tanggal_keperluan) {
            return $this->response([
                'status' => false,
                'message' => 'Semua data wajib diisi.'
            ], RestController::HTTP_BAD_REQUEST);
        }
        // Cek apakah username ada di tabel user
        $user = $this->db->get_where('user', ['username' => $username])->row();
        if (!$user) {
            return $this->response([
                'status' => false,
                'message' => 'NIS tidak terdaftar.'
            ], RestController::HTTP_NOT_FOUND);
        }
        // Cek apakah tanggal_keperluan sudah ada untuk username tsb
        $cek_tanggal = $this->db->get_where('pengajuan', [
            'username' => $username,
            'tanggal_keperluan' => $tanggal_keperluan
        ])->row();

        if ($cek_tanggal) {
            return $this->response([
                'status' => false,
                'message' => 'Kamu sudah memberikan pengajuan di tanggal yang sama.'
            ], RestController::HTTP_BAD_REQUEST);
        }

        // Simpan data
        $data = [
            'username' => $username,
            'keperluan' => $keperluan,
            'tanggal_keperluan' => $tanggal_keperluan
        ];

        $this->db->insert('pengajuan', $data);

        return $this->response([
            'status' => true,
            'message' => 'Pengajuan berhasil disimpan.'
        ], RestController::HTTP_CREATED);
    }
    public function tracking_post() {
        header("Access-Control-Allow-Origin: https://alumni.smkn2kra.sch.id");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        $username   = $this->post('username');
        $karir      = $this->post('karir');
        $keterangan = $this->post('keterangan');
        // Validasi input kosong
        if (!$username || !$karir || !$keterangan) {
            return $this->response([
                'status' => false,
                'message' => 'Semua data wajib diisi.'
            ], RestController::HTTP_BAD_REQUEST);
        }
        // Cek apakah username ada di tabel user
        $user = $this->db->get_where('user', ['username' => $username])->row();
        if (!$user) {
            return $this->response([
                'status' => false,
                'message' => 'NIS tidak terdaftar.'
            ], RestController::HTTP_NOT_FOUND);
        }
        // Simpan data ke tabel tracking
        $data = [
            'username'   => $username,
            'karir'      => $karir,
            'keterangan' => $keterangan
        ];
        $this->db->insert('tracking', $data);
        return $this->response([
            'status' => true,
            'message' => 'Data tracking berhasil disimpan.'
        ], RestController::HTTP_CREATED);
    }
    public function riwayat_get($username = null) {
        header("Access-Control-Allow-Origin: https://alumni.smkn2kra.sch.id");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (!$username) {
            return $this->response([
                'status' => false,
                'message' => 'Useraname tidak ditemukan.'
            ], RestController::HTTP_BAD_REQUEST);
        }

        // Cek apakah username ada di tabel user
        $user = $this->db->get_where('user', ['username' => $username])->row();
        if (!$user) {
            return $this->response([
                'status' => false,
                'message' => 'NIS tidak terdaftar.'
            ], RestController::HTTP_NOT_FOUND);
        }

        // Ambil data dari tabel pengajuan
        $pengajuan = $this->db->get_where('pengajuan', ['username' => $username])->result();

        // Ambil data dari tabel tracking
        $tracking = $this->db->get_where('tracking', ['username' => $username])->result();

        return $this->response([
            'status'   => true,
            'username' => $username,
            'pengajuan' => $pengajuan,
            'tracking'  => $tracking
        ], RestController::HTTP_OK);
    }


}