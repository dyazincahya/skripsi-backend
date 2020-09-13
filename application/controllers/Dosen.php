<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
        echo "API dosen";
    }

    public function getList()
    {
        $resp = default_response();

        $data = $this->db->where("u_role", "DOSEN")->order_by("u_id", "DESC")->get("users");

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

        $nik = get_raw_body("nik");
        $fullname = get_raw_body("fullname");
        $tgl_lahir = get_raw_body("tgl_lahir");
        $jk = get_raw_body("jk");
        $alamat = get_raw_body("alamat");
        $nohp = get_raw_body("nohp");
        $email = get_raw_body("email");
        $last_strata = get_raw_body("last_strata");

        if($nik != null && $fullname != null && $tgl_lahir != null && $jk != null && $alamat != null && $nohp != null && $email != null && $last_strata != null){
            $users = $this->db->get_where("users", "u_email='" . $email . "'");
            if($users->num_rows() == 0){
                $data = [
                    "u_role"        => "DOSEN",
                    "u_nik"         => $nik,
                    "u_fullname"    => $fullname,
                    "u_tgl_lahir"   => rfdate($tgl_lahir, "Y-m-d"),
                    "u_jk"          => $jk,
                    "u_alamat"      => $alamat,
                    "u_nohp"        => $nohp,
                    "u_email"       => $email,
                    "u_password"    => md5(rfdate($tgl_lahir, "dmY")),
                    "u_last_strata" => $last_strata,
                ];
                $this->db->insert("users", $data);

                $resp = [
                    "success" => true,
                    "message" => "Data dosen berhasil disimpan",
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
        $nik = get_raw_body("nik");
        $fullname = get_raw_body("fullname");
        $tgl_lahir = get_raw_body("tgl_lahir");
        $jk = get_raw_body("jk");
        $alamat = get_raw_body("alamat");
        $nohp = get_raw_body("nohp");
        $email = get_raw_body("email");
        $last_strata = get_raw_body("last_strata");

        if($nik != null && $fullname != null && $tgl_lahir != null && $jk != null && $alamat != null && $nohp != null && $email != null && $last_strata != null){
            $users = $this->db->get_where("users", "u_email='" . $email . "'");
            if($users->num_rows() == 0 || $users->num_rows() == 1){
                $data = [
                    "u_nik"         => $nik,
                    "u_fullname"    => $fullname,
                    "u_tgl_lahir"   => rfdate($tgl_lahir, "Y-m-d"),
                    "u_jk"          => $jk,
                    "u_alamat"      => $alamat,
                    "u_nohp"        => $nohp,
                    "u_email"       => $email,
                    "u_last_strata" => $last_strata,
                ];
                $this->db->where("u_id", $id);
                $this->db->update("users", $data);

                $resp = [
                    "success" => true,
                    "message" => "Data dosen berhasil diperbaharui",
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
            $this->db->where("u_id", $id);
            $this->db->where("u_role", "DOSEN");
            $this->db->delete("users");

            $resp = [
                "success" => true,
                "message" => "Data dosen berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }

    public function resetpassword(){
        $resp = default_response("Gagal menghapus data!");

        $id = get_raw_body("id");

        if($id != null){
            $users = $this->db->where("u_id", $id)->get("users");
            if($users->num_rows() != 0){
                $user = $users->row_array();
                $this->db->where("u_id", $id);
                $this->db->update("users", ["u_password" => md5(rfdate($user['u_tgl_lahir'], "dmY"))]);

                $resp = [
                    "success" => true,
                    "message" => "Password dosen berhasil direset",
                    "data" => $data,
                    "total" => 1
                ]; 
            }
             
        }

        j_encode($resp, "raw");
    }
}
