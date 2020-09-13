<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $resp = default_response();

        $ruangan = get_raw_body("ruangan");
        $matakuliah = get_raw_body("matakuliah");

        $data = $this->db->select("a.*, b.*")
                ->from("mahasiswa a")
                ->join("ruangan b", "b.r_id=a.m_ruangan", "LEFT")
                ->where("b.r_name", $ruangan)
                ->group_by("m_fullname")
                ->order_by("m_fullname", "ASC")->get();

        $new_data = [];
        foreach ($data->result_array() as $key => $val) {
            $new_data[$key]["m_id"] = $val["m_id"];
            $new_data[$key]["m_fullname"] = $val["m_fullname"];
            $new_data[$key]["has_absen"] = $this->cek_absen_hari_ini($val["m_id"], $matakuliah);
            $new_data[$key]["kehadiran"] = $this->cek_kehadiran_hari_ini($val["m_id"], $matakuliah);
            $new_data[$key]["total_hadir"] = $this->total_hadir($val["m_id"], $matakuliah);
            $new_data[$key]["total_alpha"] = $this->total_alpha($val["m_id"], $matakuliah);
            $new_data[$key]["total_absen"] = $this->total_absen($val["m_id"], $matakuliah);
        }

        $resp = [
            "success" => true,
            "message" => "Request Berhasil",
            "data" => $new_data,
            "total" => $data->num_rows()
        ];

        j_encode($resp, "raw");
    }

    private function cek_absen_hari_ini($id_mahasiswa, $id_matakuliah){
        $hari_ini = date("Y-m-d");
        $data = $this->db->where("dp_presensi_date", $hari_ini)
                ->where("dp_mahasiswa", $id_mahasiswa)
                ->where("dp_matakuliah", $id_matakuliah)
                ->get("data_presensi");

        if($data->num_rows() == 0){
            return 0;
        } else {
            return 1;
        }
    }

    private function cek_kehadiran_hari_ini($id_mahasiswa, $id_matakuliah){
        $hari_ini = date("Y-m-d");
        $data = $this->db->where("dp_presensi_date", $hari_ini)
                ->where("dp_mahasiswa", $id_mahasiswa)
                ->where("dp_matakuliah", $id_matakuliah)
                ->where("dp_status", "hadir")
                ->get("data_presensi");

        if($data->num_rows() == 0){
            return 0;
        } else {
            return 1;
        }
    }

    private function total_absen($id_mahasiswa, $id_matakuliah){
        return $this->db->where("dp_mahasiswa", $id_mahasiswa)
            ->where("dp_matakuliah", $id_matakuliah)
            ->get("data_presensi")->num_rows();
    }

    private function total_hadir($id_mahasiswa, $id_matakuliah){
        return $this->db->where("dp_mahasiswa", $id_mahasiswa)
                ->where("dp_matakuliah", $id_matakuliah)
                ->where("dp_status", "hadir")
                ->get("data_presensi")->num_rows();
    }

    private function total_alpha($id_mahasiswa, $id_matakuliah){
        return $this->db->where("dp_mahasiswa", $id_mahasiswa)
                ->where("dp_matakuliah", $id_matakuliah)
                ->where("dp_status", "alpha")
                ->get("data_presensi")->num_rows();
    }

    public function getList()
    {
        $resp = default_response();

        $data = $this->db->order_by("m_id", "DESC")->get("mahasiswa");

        $resp = [
            "success" => true,
            "message" => "Request Berhasil",
            "data" => $data->result_array(),
            "total" => $data->num_rows()
        ];

        j_encode($resp, "raw");
    }

    public function add(){
        $resp = default_response("Gagal menyimpan data!");

        $nim = get_raw_body("nim");
        $strata = get_raw_body("strata");
        $semester = get_raw_body("semester");
        $fullname = get_raw_body("fullname");
        $tgl_lahir = get_raw_body("tgl_lahir");
        $jk = get_raw_body("jk");
        $alamat = get_raw_body("alamat");
        $email = get_raw_body("email");
        $nohp = get_raw_body("nohp");
        $ruangan = get_raw_body("ruangan");

        if($nim != null && $strata != null && $semester != null && $fullname != null && $tgl_lahir != null && $jk != null && $alamat != null && $email != null && $nohp != null && $ruangan != null){
            $mahasiswa = $this->db->get_where("mahasiswa", "m_email='" . $email . "'");
            if($mahasiswa->num_rows() == 0){
                $data = [
                    "m_nim"         => $nim,
                    "m_strata"      => $strata,
                    "m_semester"      => $semester,
                    "m_fullname"    => $fullname,
                    "m_tgl_lahir"   => rfdate($tgl_lahir, "Y-m-d"),
                    "m_jk"          => $jk,
                    "m_alamat"      => $alamat,
                    "m_email"       => $email,
                    "m_nohp"        => $nohp,
                    "m_ruangan"     => $ruangan
                ];
                $this->db->insert("mahasiswa", $data);

                $resp = [
                    "success" => true,
                    "message" => "Data mahasiswa berhasil disimpan",
                    "data" => $data,
                    "total" => 1
                ];
            } else {
                $resp = default_response("Maaf email sudah terdaftar, silahkan ganti dengan email lain!");
            }  
        } else {
            $resp = default_response("Inputan tidak boleh kosong!");
        }

        j_encode($resp, "raw");
    }

    public function edit(){
        $resp = default_response("Gagal menyimpan data!");

        $id = get_raw_body("id");
        $nim = get_raw_body("nim");
        $strata = get_raw_body("strata");
        $semester = get_raw_body("semester");
        $fullname = get_raw_body("fullname");
        $tgl_lahir = get_raw_body("tgl_lahir");
        $jk = get_raw_body("jk");
        $alamat = get_raw_body("alamat");
        $email = get_raw_body("email");
        $nohp = get_raw_body("nohp");
        $ruangan = get_raw_body("ruangan");

        if($id != null && $nim != null && $strata != null && $semester != null && $fullname != null && $tgl_lahir != null && $jk != null && $alamat != null && $email != null && $nohp != null && $ruangan != null){
            $mahasiswa = $this->db->get_where("mahasiswa", "m_email='" . $email . "'");
            if($mahasiswa->num_rows() == 0 || $mahasiswa->num_rows() == 1){
                $data = [
                    "m_nim"         => $nim,
                    "m_strata"      => $strata,
                    "m_semester"      => $semester,
                    "m_fullname"    => $fullname,
                    "m_tgl_lahir"   => rfdate($tgl_lahir, "Y-m-d"),
                    "m_jk"          => $jk,
                    "m_alamat"      => $alamat,
                    "m_email"       => $email,
                    "m_nohp"        => $nohp,
                    "m_ruangan"     => $ruangan
                ];
                $this->db->where("m_id", $id);
                $this->db->update("mahasiswa", $data);

                $resp = [
                    "success" => true,
                    "message" => "Data mahasiswa berhasil diperbaharui",
                    "data" => $data,
                    "total" => 1
                ]; 
            } else {
                $resp = default_response("Maaf email sudah terdaftar, silahkan ganti dengan email lain!");
            }  
        } else {
            $resp = default_response("Inputan tidak boleh kosong!");
        }

        j_encode($resp, "raw");
    }

    public function delete(){
        $resp = default_response("Gagal menghapus data!");

        $id = get_raw_body("id");

        if($id != null){
            $this->db->where("m_id", $id);
            $this->db->delete("mahasiswa");

            $resp = [
                "success" => true,
                "message" => "Data mahasiswa berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }
}
