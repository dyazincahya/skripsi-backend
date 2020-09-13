<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

    public function index()
    {
        /// type your code here
        echo "API Users";
    }

	public function signin()
	{
        $email = get_raw_body("email");
        $password = md5(get_raw_body("password"));

        $resp = default_response("Data akun " . $email . " tidak di temukan atau tidak punya akses!");

        $users_where = "u_email='" . $email . "' AND u_password='" . $password . "'";
        $users = $this->db->get_where("users", $users_where);

        if($users->num_rows() != 0){
            $dataset = $users->row_array();
            $resp = [
                "success" => true,
                "message" => "berhasil",
                "data" => [
                    "user_id" => $dataset['u_id'],
                    "user_role" => strtoupper($dataset['u_role']),
                    "user_nik" => $dataset['u_nik'],
                    "user_fullname" => $dataset['u_fullname'],
                    "user_tgl_lahir" => $dataset['u_tgl_lahir'],
                    "user_jk" => $dataset['u_jk'],
                    "user_alamat" => $dataset['u_alamat'],
                    "user_nohp" => $dataset['u_nohp'],
                    "user_email" => $dataset['u_email'],
                    "user_password" => $dataset['u_password'],
                    "user_last_strata" => $dataset['u_last_strata'],
                    "user_created" => $dataset['u_created'],
                ],
                "total" => $users->num_rows()
            ];
        }

        j_encode($resp, "raw");
    }

    public function update_password()
    {
        $resp = default_response("Terjadi kesalahan, data gagal di perbaharui!");

        $user_id = get_raw_body("user_id");
        $password = get_raw_body("password"); 


        $this->db->where("u_id", $user_id);
        $this->db->update("users", ["u_password" => md5($password)]);

        $resp = [
            "success" => true,
            "message" => "Password berhasil di perbaharui"
        ];
        

        j_encode($resp, "raw");
    }

    public function forgot_password()
    {
        $email = get_raw_body("email");
        $new_password_rand = zrandstr(3);

        $users_where = "u_email='" . $email . "'";
        $users = $this->db->get_where("users", $users_where);

        if($users->num_rows() == 0)
        {
            $resp = default_response("Email tidak ditemukan!");
        } else 
        {
            $mail_send = zmailer([
                "to"        => str_to_arr($email),
                "subject"   => "Password baru user aplikasi Presensi Apps Universitas Kuningan",
                "message"   => "Password barunya adalah <b>". $new_password_rand ."</b>"
            ]);
            if($mail_send){
                $this->db->where("u_email", $email);
                $this->db->update("users", ["u_password" => md5($new_password_rand)]);
                $dataset = $users->row_array();
                $resp = [
                    "success" => true,
                    "message" => "Password baru sudah di kirim ke email ". $email .", cek inbox/folder spam di email kamu!"
                ];
            }
        }

        j_encode($resp, "raw");
    }
}
