<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matakuliah extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
        echo "API Matakuliah";
    }

    public function getList()
    {
        $resp = default_response();

        $data = $this->db->select("a.*,b.*")->from("matakuliah a")->join("fakultas b", "b.f_id=a.mk_fakultas", "LEFT")->order_by("a.mk_id", "DESC")->get();

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

        $fakultas = get_raw_body("fakultas");
        $kategori = get_raw_body("kategori");
        $tipe = get_raw_body("tipe");
        $semester = get_raw_body("semester");
        $name = get_raw_body("name");

        if($fakultas != null && $kategori != null && $tipe != null && $semester != null && $name != null){
            $data = [
                "mk_fakultas"   => $fakultas,
                "mk_kategori"   => $kategori,
                "mk_tipe"       => $tipe,
                "mk_semester"   => $semester,
                "mk_name"       => $name
            ];
            $this->db->insert("matakuliah", $data);

            $resp = [
                "success" => true,
                "message" => "Data matakuliah berhasil disimpan",
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
        $fakultas = get_raw_body("fakultas");
        $kategori = get_raw_body("kategori");
        $tipe = get_raw_body("tipe");
        $semester = get_raw_body("semester");
        $name = get_raw_body("name");

        if($id != null && $fakultas != null && $kategori != null && $tipe != null && $semester != null && $name != null){
            $data = [
                "mk_fakultas"   => $fakultas,
                "mk_kategori"   => $kategori,
                "mk_tipe"       => $tipe,
                "mk_semester"   => $semester,
                "mk_name"       => $name
            ];
            $this->db->where("mk_id", $id);
            $this->db->update("matakuliah", $data);

            $resp = [
                "success" => true,
                "message" => "Data matakuliah berhasil disimpan",
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
            $this->db->where("mk_id", $id);
            $this->db->delete("matakuliah");

            $resp = [
                "success" => true,
                "message" => "Data matakuliah berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }
}
