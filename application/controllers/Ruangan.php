<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

    public function index()
    {
        echo "API ruangan";
    }

	public function getList()
	{
        $resp = default_response();

        $data = $this->db->select("a.*,b.*")->from("ruangan a")->join("kampus b", "b.k_id=a.r_kampus", "LEFT")->order_by("a.r_id", "DESC")->get();

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

        $kampus = get_raw_body("kampus");
        $name = get_raw_body("name");

        if($name != null && $kampus != null){
            $data = [
                "r_kampus" => $kampus,
                "r_name" => $name
            ];
            $this->db->insert("ruangan", $data);

            $resp = [
                "success" => true,
                "message" => "Data ruangan berhasil disimpan",
                "data" => $data,
                "total" => 1
            ];  
        } else {
            $resp = default_response("Inputan tidak boleh kosong!");
        }

        j_encode($resp, "raw");
    }

    public function edit(){
        $resp = default_response("Gagal menyimpan data!");

        $id = get_raw_body("id");
        $name = get_raw_body("name");
        $kampus = get_raw_body("kampus");

        if($id != null && $name != null && $kampus != null){
            $data = [
                "r_kampus" => $kampus,
                "r_name" => $name
            ];
            $this->db->where("r_id", $id);
            $this->db->update("ruangan", $data);

            $resp = [
                "success" => true,
                "message" => "Data ruangan berhasil diperbaharui",
                "data" => $data,
                "total" => 1
            ];  
        } else {
            $resp = default_response("Inputan tidak boleh kosong!");
        }

        j_encode($resp, "raw");
    }

    public function delete(){
        $resp = default_response("Gagal menghapus data!");

        $id = get_raw_body("id");

        if($id != null){
            $this->db->where("r_id", $id);
            $this->db->delete("ruangan");

            $resp = [
                "success" => true,
                "message" => "Data ruangan berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }
}
