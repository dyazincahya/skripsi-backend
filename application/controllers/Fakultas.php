<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fakultas extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

    public function index()
    {
        echo "API fakultas";
    }

	public function getList()
	{
        $resp = default_response();

        $data = $this->db->order_by("f_id", "DESC")->get("fakultas");

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

        $strata = get_raw_body("strata");
        $fakultas = get_raw_body("fakultas");
        $fakultas_name = get_raw_body("fakultas_name");

        if($strata != null && $fakultas != null && $fakultas_name != null){
            $data = [
                "f_strata" => $strata, 
                "f_fakultas" => $fakultas, 
                "f_fakultas_name" => $fakultas_name
            ];
            $this->db->insert("fakultas", $data);

            $resp = [
                "success" => true,
                "message" => "Data fakultas berhasil disimpan",
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
        $strata = get_raw_body("strata");
        $fakultas = get_raw_body("fakultas");
        $fakultas_name = get_raw_body("fakultas_name");

        if($id != null && $strata != null && $fakultas != null && $fakultas_name != null){
            $data = [
                "f_strata" => $strata, 
                "f_fakultas" => $fakultas, 
                "f_fakultas_name" => $fakultas_name
            ];
            $this->db->where("f_id", $id);
            $this->db->update("fakultas", $data);

            $resp = [
                "success" => true,
                "message" => "Data fakultas berhasil diperbaharui",
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
            $this->db->where("f_id", $id);
            $this->db->delete("fakultas");

            $resp = [
                "success" => true,
                "message" => "Data fakultas berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }
}
