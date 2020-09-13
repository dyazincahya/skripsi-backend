<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
        echo "This is report module";
    }

    public function preview($start_date, $end_date){
        $email = "dyazincahya@gmail.com";
        $data = [];
        $data["user"] = explode("@",$email)[0];
        $data["report_type"] = "semua presensi hadir dan tidak hadir";
        $data["start_date"] = rfdate($start_date, "d") . " " . getMonthName($start_date) . " " . rfdate($start_date, "Y");
        $data["end_date"] = rfdate($end_date, "d") . " " . getMonthName($end_date) . " " . rfdate($end_date, "Y");
        $this->load->view("report/body_mail", $data);
    }

    public function xprint($start_date, $end_date){
        /*$data = $this->get_r0($star_date, $end_date, true);
        $this->pdf->load_view('report/r0', $data);
        $this->pdf->render();
        $this->pdf->stream("LAPORAN SEMUA PRESENSI HADIR DAN ALPHA " . $star_date . " sampai " . $end_date);
        $this->pdf->output();*/

        /*$data = $this->get_r0($star_date, $end_date, true);
        $this->pdf->load_view('report/r1', $data);
        $this->pdf->render();
        $this->pdf->stream("LAPORAN PRESENSI MAHASISWA YANG TIDAK PERNAH BOLOS " . $star_date . " sampai " . $end_date);
        $this->pdf->output();*/

        $data = $this->get_r4($start_date, $end_date, true);
        $this->pdf->load_view('report/r4', $data);
        $this->pdf->render();
        $this->pdf->stream("LAPORAN PRESENSI MAHASISWA YANG BOLOS > 2X " . $start_date . " sampai " . $end_date);
        $this->pdf->output();
    }

    public function download_pdf($start_date, $end_date, $report_options){

        $ro_arr = [
            "semua presensi hadir dan tidak hadir",
            "presensi mahasiswa yang 100% hadir",
            "presensi mahasiswa yang bolos > 2x",
            "persentase kehadiran per bulan",
            "persentase kehadiran per tahun"
        ];

        $subject = "Laporan ".$ro_arr[intval($report_options)]." periode (".rfdate($start_date, "d-m-Y")." sampai ".rfdate($end_date, "d-m-Y").")";

        switch ($report_options) {
            case '0':
                $this->pdf->load_view('report/r0', $this->get_r0($start_date, $end_date, $ro_arr[intval($report_options)], true));
                $this->pdf->render();
                $this->pdf->stream($subject);
                $this->pdf->output();
                break;
            
            case '1':
                $this->pdf->load_view('report/r1', $this->get_r1($start_date, $end_date, $ro_arr[intval($report_options)], true));
                $this->pdf->render();
                $this->pdf->stream($subject);
                $this->pdf->output();
                break;

            case '2':
                $this->pdf->load_view('report/r2', $this->get_r2($start_date, $end_date, $ro_arr[intval($report_options)], true));
                $this->pdf->render();
                $this->pdf->stream($subject);
                $this->pdf->output();
                break;

            case '3':
                $this->pdf->load_view('report/r3', $this->get_r3($start_date, $end_date, $ro_arr[intval($report_options)], true));
                $this->pdf->render();
                $this->pdf->stream($subject);
                $this->pdf->output();
                break;

            case '4':
                $this->pdf->load_view('report/r4', $this->get_r4($start_date, $end_date, $ro_arr[intval($report_options)], true));
                $this->pdf->render();
                $this->pdf->stream($subject);
                $this->pdf->output();
                break;

            default:
                echo "Laporan Tidak Ditemukan!";
                break;
        }
        
    }

    public function send_mail()
    {
        $resp = default_response("Terjadi kesalahan, email laporan tidak terkirim!");

        $start_date = get_raw_body("start_date");
        $end_date = get_raw_body("end_date");
        $report_options = get_raw_body("report_options");

        $to = get_raw_body("to");
        $cc = get_raw_body("cc");
        $bcc = get_raw_body("bcc");

        $ro_arr = [
            "semua presensi hadir dan tidak hadir",
            "presensi mahasiswa yang 100% hadir", //presensi mahasiswa yang tidak pernah bolos
            "presensi mahasiswa yang bolos > 2x",
            "persentase kehadiran per bulan",
            "persentase kehadiran per tahun"
        ];

        $subject = "Laporan ".$ro_arr[intval($report_options)]." periode (" . rfdate($start_date, "d/m/Y") . " sampai " . rfdate($end_date, "d/m/Y") . ")";
        
        $data = [];
        $data["user"] = explode("@", $to)[0];
        $data["report_type"] = "semua presensi hadir dan tidak hadir";
        $data["start_date"] = rfdate($start_date, "d") . " " . getMonthName($start_date) . " " . rfdate($start_date, "Y");
        $data["end_date"] = rfdate($end_date, "d") . " " . getMonthName($end_date) . " " . rfdate($end_date, "Y");
        $data["site_url"] = site_url("report/download_pdf/").$start_date."/".$end_date."/".intval($report_options);

        $message = $this->load->view("report/body_mail", $data, true);

        $mail_config = [
            "to"        => str_to_arr($to),
            "cc"        => str_to_arr($cc),
            "bcc"        => str_to_arr($bcc),
            "subject"   => $subject,
            "message"   => $message
        ];
        $mail_send = zmailer($mail_config);
        if($mail_send){
            $resp = [
                "success" => true,
                "message" => "Email laporan sudah terkirim",
                "data" => $mail_config,
                "total" => 1
            ];
        }

        j_encode($resp, "raw");
    }

    private function get_r0($start_date, $end_date, $report_name, $return=false){
        $new_data = [];
        $matkul = $this->db->order_by("mk_name", "ASC")->get("matakuliah");
        foreach ($matkul->result_array() as $k => $v) {
            $new_data[$k]['mk_name'] = $v['mk_name'];
            $new_data[$k]['mk_tipe'] = $v['mk_tipe'];
            $new_data[$k]['mk_kategori'] = $v['mk_kategori'];

            $dp = $this->db->select("dp_mahasiswa, m_fullname")->from("data_presensi a")
                    ->join("mahasiswa b", "b.m_id=a.dp_mahasiswa", "LEFT")
                    ->where("dp_matakuliah", $v['mk_id'])
                    ->where("(dp_presensi_date >= CAST('". $start_date ."' AS DATE) AND dp_presensi_date <= CAST('". $end_date ."' AS DATE))", null)
                    ->group_by("dp_mahasiswa, m_fullname")->get();
            if($dp->num_rows() != 0){
                foreach ($dp->result_array() as $k2 => $v2) {
                    $new_data[$k]['dp'][$k2]['fullname'] = $v2['m_fullname'];
                    $new_data[$k]['dp'][$k2]['hadir'] = $this->get_mhs_hadir($v['mk_id'], $v2['dp_mahasiswa'], $start_date, $end_date);
                    $new_data[$k]['dp'][$k2]['alpha'] = $this->get_mhs_alpha($v['mk_id'], $v2['dp_mahasiswa'], $start_date, $end_date);
                }
            } else {
                $new_data[$k]['dp'] = [];
            }
        }

        $data['absen'] = $new_data;
        $data['xstart'] = rfdate($start_date,"d/m/Y");
        $data['xend'] = rfdate($end_date,"d/m/Y");
        $data['report_name'] = $report_name;

        if($return===false){
            $this->load->view("report/r0", $data);
        } else {
            return $data;
        }
    }

    private function get_r1($start_date, $end_date, $report_name, $return=false){
        $new_data = [];
        $matkul = $this->db->order_by("mk_name", "ASC")->get("matakuliah");
        foreach ($matkul->result_array() as $k => $v) {
            $new_data[$k]['mk_name'] = $v['mk_name'];
            $new_data[$k]['mk_tipe'] = $v['mk_tipe'];
            $new_data[$k]['mk_kategori'] = $v['mk_kategori'];

            $dp = $this->db->select("dp_mahasiswa, m_fullname")->from("data_presensi a")
                    ->join("mahasiswa b", "b.m_id=a.dp_mahasiswa", "LEFT")
                    ->where("dp_matakuliah", $v['mk_id'])
                    ->where("(dp_presensi_date >= CAST('". $start_date ."' AS DATE) AND dp_presensi_date <= CAST('". $end_date ."' AS DATE))", null)
                    ->group_by("dp_mahasiswa, m_fullname")->get();
            if($dp->num_rows() != 0){
                foreach ($dp->result_array() as $k2 => $v2) {
                    $new_data[$k]['dp'][$k2]['fullname'] = $v2['m_fullname'];
                    $new_data[$k]['dp'][$k2]['hadir'] = $this->get_mhs_hadir($v['mk_id'], $v2['dp_mahasiswa'], $start_date, $end_date);
                    $new_data[$k]['dp'][$k2]['alpha'] = $this->get_mhs_alpha($v['mk_id'], $v2['dp_mahasiswa'], $start_date, $end_date);
                }
            } else {
                $new_data[$k]['dp'] = [];
            }
        }

        $data['absen'] = $new_data;
        $data['xstart'] = rfdate($start_date,"d/m/Y");
        $data['xend'] = rfdate($end_date,"d/m/Y");
        $data['report_name'] = $report_name;

        if($return===false){
            $this->load->view("report/r1", $data);
        } else {
            return $data;
        }
    }

    private function get_r2($start_date, $end_date, $report_name, $return=false){
        $new_data = [];
        $matkul = $this->db->order_by("mk_name", "ASC")->get("matakuliah");
        foreach ($matkul->result_array() as $k => $v) {
            $new_data[$k]['mk_name'] = $v['mk_name'];
            $new_data[$k]['mk_tipe'] = $v['mk_tipe'];
            $new_data[$k]['mk_kategori'] = $v['mk_kategori'];

            $dp = $this->db->select("dp_mahasiswa, m_fullname")->from("data_presensi a")
                    ->join("mahasiswa b", "b.m_id=a.dp_mahasiswa", "LEFT")
                    ->where("dp_matakuliah", $v['mk_id'])
                    ->where("(dp_presensi_date >= CAST('". $start_date ."' AS DATE) AND dp_presensi_date <= CAST('". $end_date ."' AS DATE))", null)
                    ->group_by("dp_mahasiswa, m_fullname")->get();
            if($dp->num_rows() != 0){
                foreach ($dp->result_array() as $k2 => $v2) {
                    $new_data[$k]['dp'][$k2]['fullname'] = $v2['m_fullname'];
                    $new_data[$k]['dp'][$k2]['hadir'] = $this->get_mhs_hadir($v['mk_id'], $v2['dp_mahasiswa'], $start_date, $end_date);
                    $new_data[$k]['dp'][$k2]['alpha'] = $this->get_mhs_alpha($v['mk_id'], $v2['dp_mahasiswa'], $start_date, $end_date);
                }
            } else {
                $new_data[$k]['dp'] = [];
            }
        }

        $data['absen'] = $new_data;
        $data['xstart'] = rfdate($start_date,"d/m/Y");
        $data['xend'] = rfdate($end_date,"d/m/Y");
        $data['report_name'] = $report_name;

        if($return===false){
            $this->load->view("report/r2", $data);
        } else {
            return $data;
        }
    }

    private function get_r3($start_date, $end_date, $report_name, $return=false){
        $dp = $this->db->select("DATE_FORMAT(dp_presensi_date, '%Y-%m-%d') as presensi_date, count(dp_presensi_date) as ttl_presensi")->from("data_presensi")
                ->where("dp_status", "hadir")
                ->where("(dp_created >= CAST('". $start_date ."' AS DATE) AND dp_created <= CAST('". $end_date ."' AS DATE))", null)
                ->group_by("MONTH(dp_presensi_date), YEAR(dp_presensi_date)")->get();
        $dp_alpha = $this->db->select("DATE_FORMAT(dp_presensi_date, '%Y-%m-%d') as presensi_date, count(dp_presensi_date) as ttl_presensi")->from("data_presensi")
                ->where("dp_status", "alpha")
                ->where("(dp_created >= CAST('". $start_date ."' AS DATE) AND dp_created <= CAST('". $end_date ."' AS DATE))", null)
                ->group_by("MONTH(dp_presensi_date), YEAR(dp_presensi_date)")->get();

        $data['absen'] = array_merge(["hadir" => $dp->result_array()], ["alpha" => $dp_alpha->result_array()]);
        $data['xstart'] = rfdate($start_date,"d/m/Y");
        $data['xend'] = rfdate($end_date,"d/m/Y");
        $data['report_name'] = $report_name;

        if($return===false){
            $this->load->view("report/r3", $data);
        } else {
            return $data;
        }
    }

    private function get_r4($start_date, $end_date, $report_name, $return=false){
        $dp = $this->db->select("DATE_FORMAT(dp_presensi_date, '%Y-%m-%d') as presensi_date, count(dp_presensi_date) as ttl_presensi")->from("data_presensi")
                ->where("dp_status", "hadir")
                ->where("(dp_created >= CAST('". $start_date ."' AS DATE) AND dp_created <= CAST('". $end_date ."' AS DATE))", null)
                ->group_by("YEAR(dp_presensi_date)")->get();
        $dp_alpha = $this->db->select("DATE_FORMAT(dp_presensi_date, '%Y-%m-%d') as presensi_date, count(dp_presensi_date) as ttl_presensi")->from("data_presensi")
                ->where("dp_status", "alpha")
                ->where("(dp_created >= CAST('". $start_date ."' AS DATE) AND dp_created <= CAST('". $end_date ."' AS DATE))", null)
                ->group_by("YEAR(dp_presensi_date)")->get();

        $data['absen'] = array_merge(["hadir" => $dp->result_array()], ["alpha" => $dp_alpha->result_array()]);
        $data['xstart'] = rfdate($start_date,"d/m/Y");
        $data['xend'] = rfdate($end_date,"d/m/Y");
        $data['report_name'] = $report_name;

        if($return===false){
            $this->load->view("report/r4", $data);
        } else {
            return $data;
        }
    }

    private function get_mhs_hadir($matkul, $mhs, $start_date, $end_date){
        return $this->db->where("dp_matakuliah", $matkul)->where("dp_mahasiswa", $mhs)->where("dp_status", "hadir")
            ->where("(dp_presensi_date >= CAST('". $start_date ."' AS DATE) AND dp_presensi_date <= CAST('". $end_date ."' AS DATE))", null)
            ->get("data_presensi")->num_rows();
    }

    private function get_mhs_alpha($matkul, $mhs, $start_date, $end_date){
        return $this->db->where("dp_matakuliah", $matkul)->where("dp_mahasiswa", $mhs)->where("dp_status", "alpha")
            ->where("(dp_presensi_date >= CAST('". $start_date ."' AS DATE) AND dp_presensi_date <= CAST('". $end_date ."' AS DATE))", null)
            ->get("data_presensi")->num_rows();
    }
}
