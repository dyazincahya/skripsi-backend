<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kampus extends CI_Controller {

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

        $data = $this->db->order_by("k_id", "DESC")->get("kampus");

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

        $name = get_raw_body("name");
        $alamat = get_raw_body("alamat");

        if($name != null && $alamat != null){
            $data = [
                "k_name" => $name, 
                "k_alamat" => $alamat
            ];
            $this->db->insert("kampus", $data);

            $resp = [
                "success" => true,
                "message" => "Data kampus berhasil disimpan",
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
        $alamat = get_raw_body("alamat");

        if($id != null && $name != null && $alamat != null){
            $data = [
                "k_name" => $name, 
                "k_alamat" => $alamat
            ];
            $this->db->where("k_id", $id);
            $this->db->update("kampus", $data);

            $resp = [
                "success" => true,
                "message" => "Data kampus berhasil diperbaharui",
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
            $this->db->where("k_id", $id);
            $this->db->delete("kampus");

            $resp = [
                "success" => true,
                "message" => "Data kampus berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }
}
