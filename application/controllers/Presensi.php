<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

    public function index(){
        echo "index utama";
    }

    public function today(){
        $resp = default_response("Data belum ada!");

        $data = $this->db->order_by("r_name", "ASC")->get("ruangan");

        $new_data = [];
        foreach ($data->result_array() as $key => $val) {
            $new_data[$key]['r_kampus'] = $val['r_kampus'];
            $new_data[$key]['r_name'] = $val['r_name'];
            $new_data[$key]['total_all'] = $this->get_total_all($val['r_id']);
            $new_data[$key]['total_hadir'] = $this->get_total_hadir($val['r_id']);
            $new_data[$key]['total_alpha'] = $this->get_total_alpha($val['r_id']);
        }

        $resp = [
            "success" => true,
            "message" => "Berhasil",
            "data" => $new_data,
            "total" => $data->num_rows()
        ];

        j_encode($resp, "raw");
    }

    private function get_total_all($id_ruangan){
        $today = date("Y-m-d");

        return $this->db->where("dp_presensi_date", $today)
                    ->where("dp_ruangan", $id_ruangan)
                    ->get("data_presensi")->num_rows();
    }

    private function get_total_hadir($id_ruangan){
        $today = date("Y-m-d");

        return $this->db->where("dp_presensi_date", $today)
                    ->where("dp_ruangan", $id_ruangan)
                    ->where("dp_status", "hadir")
                    ->get("data_presensi")->num_rows();
    }

    private function get_total_alpha($id_ruangan){
        $today = date("Y-m-d");

        return $this->db->where("dp_presensi_date", $today)
                    ->where("dp_ruangan", $id_ruangan)
                    ->where("dp_status", "alpha")
                    ->get("data_presensi")->num_rows();
    }

	public function ambil_data()
	{
        $resp = default_response("Terjadi kesalahan, data presensi belum tersimpan!");

        $mahasiswa = get_raw_body("mahasiswa");
        $dosen = get_raw_body("dosen");
        $matakuliah = get_raw_body("matakuliah");
        $ruangan = get_raw_body("ruangan");
        $status = get_raw_body("status");
        $presensi_date = date("Y-m-d");

        $data = [
            "dp_mahasiswa"      => $mahasiswa,
            "dp_dosen"          => $dosen,
            "dp_matakuliah"     => $matakuliah,
            "dp_ruangan"        => $ruangan,
            "dp_status"         => $status,
            "dp_presensi_date"  => $presensi_date
        ];
        $this->db->insert("data_presensi", $data);

        $resp = [
            "success" => true,
            "message" => "Data presensi berhasil tersimpan"
        ];

        j_encode($resp, "raw");
    }

    public function ubah_data(){
        $resp = default_response("Terjadi kesalahan, data presensi belum tersimpan!");

        $mahasiswa = get_raw_body("mahasiswa");
        $dosen = get_raw_body("dosen");
        $matakuliah = get_raw_body("matakuliah");
        $ruangan = get_raw_body("ruangan");
        $status = get_raw_body("status");
        $presensi_date = date("Y-m-d");

        $find = $this->db->where("dp_mahasiswa", $mahasiswa)
                        ->where("dp_dosen", $dosen)
                        ->where("dp_matakuliah", $matakuliah)
                        ->where("dp_ruangan", $ruangan)
                        ->where("dp_presensi_date", $presensi_date)->get("data_presensi");

        if($find->num_rows() == 0){
            $resp = default_response("Terjadi kesalahan, data tidak ditemukan!");
        } else {
            $this->db->where("dp_mahasiswa", $mahasiswa);
            $this->db->where("dp_dosen", $dosen);
            $this->db->where("dp_matakuliah", $matakuliah);
            $this->db->where("dp_ruangan", $ruangan);
            $this->db->where("dp_presensi_date", $presensi_date);
            $this->db->update("data_presensi", [ "dp_status" => $status ]);

            $resp = [
                "success" => true,
                "message" => "Data presensi berhasil tersimpan"
            ];
        }

        j_encode($resp, "raw");
    }
}
