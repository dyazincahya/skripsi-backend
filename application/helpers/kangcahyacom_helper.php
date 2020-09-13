<?php
    function j_encode($arr, $mode="pass"){
        header('Content-type: text/html; charset=utf-8');
        if($mode == "pass"){
	        $counter = count($arr);
	        $resp = [
	        	"success" => true,
	        	"message" => "Request Successfully",
	        	"data" => ($counter != 0) ? $arr : [],
	        	"total" => $counter
	        ];
        	echo json_encode($resp, JSON_UNESCAPED_UNICODE);
	    } else {
	    	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	    }
        exit();
    }

    function raw_body($returnType = "array"){
    	$rawBody = file_get_contents('php://input');
        $decodeBody = json_decode($rawBody);

        if($returnType == "array"){
        	return (array)$decodeBody;
        } else { return $decodeBody; }
    }

    function get_raw_body($key=null){
    	$rawBody = file_get_contents('php://input');
        $decodeBody = json_decode($rawBody);

        if($key == null){
        	return $key; 
        } else { 
        	if(count((array)$decodeBody) > 0){
                $z = (array)$decodeBody;
                if(isset($z[$key])){
                    if(empty($z[$key])){
                        return null;
                    } else {
                        return $z[$key];
                    }
                } else {
                    return null;
                }
            } else {
                return null;
            }
        	
        }
    }

    function default_response($message=""){
    	return [
            "success" => false,
            "message" => (empty($message) ? "Data not found!" : $message ),
            "data" => [],
            "total" => 0
        ];
    }

    function zmailer($m=[]) {
        require_once(APPPATH.'libraries/PHPMailerAutoload.php');

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'lumineon.sg.rapidplex.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'skripsicahya@vuspicture.com';
        $mail->Password = 'i6eepzthk1gv';
        $mail->Port = 587; // 465 | 587

        $mail->setFrom('skripsicahya@vuspicture.com', 'skripsicahya');

        $to = $m['to'];
        if(is_array($to)){
            if(count($to) > 0){
                for ($i=0; $i < count($to); $i++) { 
                    $mail->addAddress($to[$i]);
                }
            }
        } else {
            $mail->addAddress($m["to"]);
        }

        if(isset($m['cc'])){
            $cc = $m['cc'];
            if(is_array($cc)){
                if(count($cc) > 0){
                    for ($i=0; $i < count($cc); $i++) { 
                        $mail->addCC($cc[$i]);
                    }
                }
            } else {
                $mail->addCC($m["cc"]);
            }
        }

        if(isset($m['bcc'])){
            $bcc = $m['bcc'];
            if(is_array($bcc)){
                if(count($bcc) > 0){
                    for ($i=0; $i < count($bcc); $i++) { 
                        $mail->addBCC($bcc[$i]);
                    }
                }
            } else {
                $mail->addBCC($m["bcc"]);
            }
        }

        if(isset($m['attachments'])){
            $att = $m['attachments'];
            if(count($att) > 0){
                for ($i=0; $i < count($att); $i++) { 
                    $mail->addAttachment($att[$i]);
                }
            }
        }

        $mail->isHTML(true);

        $mail->Subject = $m["subject"];
        $mail->Body    = $m["message"];

        if(!$mail->send()) {
            /*echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;*/
            return false;
        } else {
            // echo 'Message has been sent';
            return true;
        }
    }

    function rfdate($vdate, $format="d/m/Y H:i:s"){
        return date($format, strtotime($vdate));
    }

    function dayNameId($vdate){
        $hari = date ("D", strtotime($vdate));
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;

            case 'Mon':         
                $hari_ini = "Senin";
            break;

            case 'Tue':
                $hari_ini = "Selasa";
            break;

            case 'Wed':
                $hari_ini = "Rabu";
            break;

            case 'Thu':
                $hari_ini = "Kamis";
            break;

            case 'Fri':
                $hari_ini = "Jumat";
            break;

            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";     
            break;
        }

        return $hari_ini;
    }

    function zempty($string, $message="Kosong"){
        if(isset($string)){
            if(!empty($string)){
                return $string;
            } else {
                return $message;
            }
        } else {
            return $message;
        }
    }

    function str_to_arr($string="", $delimiter = ";"){
        if(!empty($string)){
            return explode($delimiter, $string);
        } else {
            return [];
        }
    }

    function zstatus($numb){
        if($numb == 1){
            return "ACTIVE";
        } else if($numb == 2){
            return "PENDING";
        } else {
            return "NON ACTIVE";
        }
    }

    function zrandstr($n=5) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    } 

    function dateidn() {
        date_default_timezone_set('Asia/Jakarta');
        $bulan = date("m");
        if($bulan == "01"){
            $m = "Januari";
        }

        if($bulan == "02"){
            $m = "Februari";
        }

        if($bulan == "03"){
            $m = "Maret";
        }

        if($bulan == "04"){
            $m = "April";
        }

        if($bulan == "05"){
            $m = "Mei";
        }

        if($bulan == "06"){
            $m = "Juni";
        }

        if($bulan == "07"){
            $m = "Juli";
        }

        if($bulan == "08"){
            $m = "Agustus";
        }

        if($bulan == "09"){
            $m = "September";
        }

        if($bulan == "10"){
            $m = "Oktober";
        }

        if($bulan == "11"){
            $m = "November";
        }

        if($bulan == "12"){
            $m = "Desember";
        }

        $tanggal = date("d");
        $tahun = date("Y");

        return $tanggal . " " . $m . " " . $tahun;
    }

    function getDayName() {
        $dayOfWeek=date('w');
        switch ($dayOfWeek){
            case 0:
                return 'senin';
                break;
            case 1:
                return 'selasa';
                break;
            case 2:
                return 'rabu';
                break;
            case 3:
                return 'kamis';
                break;
            case 4:
                return 'jumat';
                break;
            case 5:
                return 'sabtu';
                break;
            case 6:
                return 'minggu';
                break;
            default:
                return '';
                break;
        }
    }

    function getMonthName($datenya) {
        $bulan = date("m", strtotime($datenya));

        if($bulan == "01"){
            $m = "Januari";
        }

        if($bulan == "02"){
            $m = "Februari";
        }

        if($bulan == "03"){
            $m = "Maret";
        }

        if($bulan == "04"){
            $m = "April";
        }

        if($bulan == "05"){
            $m = "Mei";
        }

        if($bulan == "06"){
            $m = "Juni";
        }

        if($bulan == "07"){
            $m = "Juli";
        }

        if($bulan == "08"){
            $m = "Agustus";
        }

        if($bulan == "09"){
            $m = "September";
        }

        if($bulan == "10"){
            $m = "Oktober";
        }

        if($bulan == "11"){
            $m = "November";
        }

        if($bulan == "12"){
            $m = "Desember";
        }

        return $m;
    }

    function cahya_getview($view_name, $data=[], $return=true){
        $ci =& get_instance();
        if($return){
            return $ci->load->view($view_name, $data, $return);
        } else {
            $ci->load->view($view_name, $data, $return);
        }
    }

