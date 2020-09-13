<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwalkuliah extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $resp = default_response();
        $dosen_id = get_raw_body("dosen_id");

        $today = date("Y-m-d");
        $today_dayname = strtoupper(dayNameId($today));

        if($dosen_id == "STAFF"){
            $data = $this->db->select("a.*, b.*, c.*, d.*")
                ->from("jadwal_kuliah a")
                ->join("users b", "b.u_id=a.jk_dosen", "LEFT")
                ->join("ruangan c", "c.r_id=a.jk_ruangan", "LEFT")
                ->join("matakuliah d", "d.mk_id=jk_matakuliah", "LEFT")
                ->where("(a.jk_active_from <= CAST('". $today ."' AS DATE) AND a.jk_active_until >= CAST('". $today ."' AS DATE))", null)
                ->where("a.jk_day", $today_dayname)
                ->order_by("jk_id", "DESC")->get();
        } else {
            $data = $this->db->select("a.*, b.*, c.*, d.*")
                ->from("jadwal_kuliah a")
                ->join("users b", "b.u_id=a.jk_dosen", "LEFT")
                ->join("ruangan c", "c.r_id=a.jk_ruangan", "LEFT")
                ->join("matakuliah d", "d.mk_id=jk_matakuliah", "LEFT")
                ->where("a.jk_dosen", $dosen_id)
                ->where("(a.jk_active_from <= CAST('". $today ."' AS DATE) AND a.jk_active_until >= CAST('". $today ."' AS DATE))", null)
                ->where("a.jk_day", $today_dayname)
                ->order_by("a.jk_id", "DESC")->get();
        }

        $new_data = [];
        foreach ($data->result_array() as $key => $val) {
            $new_data[$key]['jk_id'] = $val['jk_id']; 
            $new_data[$key]['jk_date'] = date("d/m/Y");
            $new_data[$key]['mk_id'] = $val['mk_id'];
            $new_data[$key]['mk_name'] = $val['mk_name'];
            $new_data[$key]['jk_day'] = $val['jk_day'];
            $new_data[$key]['jk_start_kuliah'] = rfdate($val['jk_start_kuliah'], "H:i");
            $new_data[$key]['jk_end_kuliah'] = rfdate($val['jk_end_kuliah'], "H:i");
            $new_data[$key]['r_kampus'] = $val['r_kampus'];
            $new_data[$key]['r_id'] = $val['r_id'];
            $new_data[$key]['r_name'] = $val['r_name'];
        }

        $resp = [
            "success" => true,
            "message" => "Berhasil",
            "data" => $new_data,
            "total" => $data->num_rows()
        ];

        j_encode($resp, "raw");
    }

    public function getList()
    {
        $data = $this->db->select("a.*, b.*, c.*, d.*")
            ->from("jadwal_kuliah a")
            ->join("users b", "b.u_id=a.jk_dosen", "LEFT")
            ->join("ruangan c", "c.r_id=a.jk_ruangan", "LEFT")
            ->join("matakuliah d", "d.mk_id=jk_matakuliah", "LEFT")
            ->order_by("a.jk_id", "DESC")->get();

        $new_data = [];
        foreach ($data->result_array() as $key => $val) {
            $new_data[$key]['jk_id'] = $val['jk_id'];            
            $new_data[$key]['jk_date'] = date("d/m/Y");
            $new_data[$key]['u_id'] = $val['u_id'];            
            $new_data[$key]['u_fullname'] = $val['u_fullname'];            
            $new_data[$key]['mk_id'] = $val['mk_id'];
            $new_data[$key]['mk_name'] = $val['mk_name'];
            $new_data[$key]['jk_day'] = $val['jk_day'];
            $new_data[$key]['jk_start_kuliah'] = rfdate($val['jk_start_kuliah'], "H:i");
            $new_data[$key]['jk_end_kuliah'] = rfdate($val['jk_end_kuliah'], "H:i");
            $new_data[$key]['jk_active_from'] = $val['jk_active_from'];
            $new_data[$key]['jk_active_until'] = $val['jk_active_until'];
            $new_data[$key]['r_kampus'] = $val['r_kampus'];
            $new_data[$key]['r_id'] = $val['r_id'];
            $new_data[$key]['r_name'] = $val['r_name'];
        }

        $resp = [
            "success" => true,
            "message" => "Berhasil",
            "data" => $new_data,
            "total" => $data->num_rows()
        ];

        j_encode($resp, "raw");
    }

    public function add()
    {
        $resp = default_response("Gagal menyimpan data!");

        $dosen = get_raw_body("dosen");
        $ruangan = get_raw_body("ruangan");
        $matakuliah = get_raw_body("matakuliah");
        $day = get_raw_body("day");
        $start_kuliah = get_raw_body("start_kuliah");
        $end_kuliah = get_raw_body("end_kuliah");
        $active_from = get_raw_body("active_from");
        $active_until = get_raw_body("active_until");

        if($dosen != null && $ruangan != null && $matakuliah != null && $day != null && $start_kuliah != null && $end_kuliah != null && $active_from != null && $active_until != null)
        {
            $data = [
                "jk_dosen"          => $dosen,
                "jk_ruangan"        => $ruangan,
                "jk_matakuliah"     => $matakuliah,
                "jk_day"            => $day,
                "jk_start_kuliah"   => $start_kuliah,
                "jk_end_kuliah"     => $end_kuliah,
                "jk_active_from"    => rfdate($active_from, "Y-m-d"),
                "jk_active_until"   => rfdate($active_until, "Y-m-d")
            ];
            $this->db->insert("jadwal_kuliah", $data);

            $resp = [
                "success" => true,
                "message" => "Data jadwal kuliah berhasil disimpan",
                "data" => $data,
                "total" => 1
            ];  
        } else 
        {
            $resp = default_response("Form harus terisi semua!");
        }

        j_encode($resp, "raw");
    }

    public function edit()
    {
        $resp = default_response("Gagal menyimpan data!");

        $id = get_raw_body("id");
        $dosen = get_raw_body("dosen");
        $ruangan = get_raw_body("ruangan");
        $matakuliah = get_raw_body("matakuliah");
        $day = get_raw_body("day");
        $start_kuliah = get_raw_body("start_kuliah");
        $end_kuliah = get_raw_body("end_kuliah");
        $active_from = get_raw_body("active_from");
        $active_until = get_raw_body("active_until");

        if($id != null && $dosen != null && $ruangan != null && $matakuliah != null && $day != null && $start_kuliah != null && $end_kuliah != null && $active_from != null && $active_until != null)
        {
            $data = [
                "jk_dosen"          => $dosen,
                "jk_ruangan"        => $ruangan,
                "jk_matakuliah"     => $matakuliah,
                "jk_day"            => $day,
                "jk_start_kuliah"   => $start_kuliah,
                "jk_end_kuliah"     => $end_kuliah,
                "jk_active_from"    => rfdate($active_from, "Y-m-d"),
                "jk_active_until"   => rfdate($active_until, "Y-m-d")
            ];
            $this->db->where("jk_id", $id);
            $this->db->update("jadwal_kuliah", $data);

            $resp = [
                "success" => true,
                "message" => "Data jadwal kuliah berhasil diupdate",
                "data" => $data,
                "total" => 1
            ];  
        } else 
        {
            $resp = default_response("Form harus terisi semua!");
        }

        j_encode($resp, "raw");
    }

    public function delete(){
        $resp = default_response("Gagal menghapus data!");

        $id = get_raw_body("id");

        if($id != null)
        {
            $this->db->where("jk_id", $id);
            $this->db->delete("jadwal_kuliah");

            $resp = [
                "success" => true,
                "message" => "Data jadwal kuliah berhasil dihapus",
                "data" => $data,
                "total" => 1
            ];  
        }

        j_encode($resp, "raw");
    }
}
