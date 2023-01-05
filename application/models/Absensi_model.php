<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model{
 	public function GetWhere($table){
        $res=$this->db->get($table); // Kode ini berfungsi untuk memilih tabel yang akan ditampilkan
        return $res->result_array(); // Kode ini digunakan untuk mengembalikan hasil operasi $res menjadi sebuah array
    }
    public function edit_data($where,$table){      
        return $this->db->get_where($table,$where);
    }
    public function Insert($table,$data){
        $res = $this->db->insert($table, $data); // Kode ini digunakan untuk memasukan record baru kedalam sebuah tabel
        return $res; // Kode ini digunakan untuk mengembalikan hasil $res
    }
    public function Update($table, $data, $where){
        $res = $this->db->update($table, $data, $where); // Kode ini digunakan untuk merubah record yang sudah ada dalam sebuah tabel
        return $res;
    }
    public function Delete($table, $where){
        $res = $this->db->delete($table, $where); // Kode ini digunakan untuk menghapus record yang sudah ada
        return $res;
    }
    public function cek_absen_masuk_now(){ // cek apakah sudah absen masuk
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date("Y-m-d");
        $this->db->select('*')->from('absen');
        $this->db->where("username", $this->session->userdata('username'));
        $this->db->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
        return $this->db->count_all_results();
    }
    public function cek_absen_pulang_now(){ // cek apakah sudah absen pulang
        date_default_timezone_set("Asia/Jakarta");
        $tanggal = date("Y-m-d");
        $jam = date("10:15");
        $this->db->select('*')->from('absen');
        $this->db->where("username", $this->session->userdata('username'));
        $this->db->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
        $this->db->where("DATE_FORMAT(pulang,'%H-%i') >=", $jam);
        return $this->db->count_all_results();
    }
    public function get_masuk($username,$tanggal){ //menampilkan skor koding
        $this->db->select('masuk')->from('absen');
        $this->db->where("username",$username);
        $this->db->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
        $res = $this->db->count_all_results();
        if ($res==NULL) {
            return 'A';
        } elseif ($res==date("00:00:00")) {
            return 'A';
        } else {
            $this->db->select('masuk')->from('absen');
            $this->db->where("username",$username);
            $this->db->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
            return DATE_FORMAT(date_create($this->db->get()->row()->masuk),"H:i");
        }
   }
   public function get_pulang($username,$tanggal){ //menampilkan skor koding
        $this->db->select('pulang')->from('absen');
        $this->db->where("username",$username);
        $this->db->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
        $res = $this->db->count_all_results();
        if ($res==NULL) {
            return 'A';
        } elseif ($res==strtotime("00:00:00")) {
            return 'A';
        } else {
            $this->db->select('pulang')->from('absen'); 
            $this->db->where("username",$username);
            $this->db->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $tanggal);
            return DATE_FORMAT(date_create($this->db->get()->row()->pulang),"H:i");
        }
   }
    public function cek_kelas($angkatan){ //gapakai kelas
        $angkatan = substr($angkatan,0,4);
        $kelas1=date('Y')-$angkatan; 
        $kelas2=date('Y')-$angkatan-1; 
        $bulan=date('m'); //cek bulan ke 7 apa bukan?
        if($bulan>6){
            if($kelas1==0) {
                $kelas ="X";
            } elseif($kelas1==1) {
                $kelas = "XI";
            } elseif($kelas1==2) {
                $kelas = "XII";
            } else {
                $angkatan = $angkatan+3;
                $kelas = 'Alumni '.$angkatan;
            }
        } else {
            if($kelas2==0) {
                $kelas = "X";
            } elseif($kelas2==1) {
                $kelas = "XI";
            } elseif($kelas2==2) {
                $kelas = "XII";
            } else {
                $angkatan = $angkatan+3;
                $kelas = 'Alumni '.$angkatan;
            }
        }
        return $kelas;
    }
    public function get_ip(){
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
    
        return $ip;
    }
}
 