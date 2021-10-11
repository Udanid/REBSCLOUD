<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
Created by Eranga on 2019-09-19 for Dialog gateway
*/
class Sms
{
    
    function send_sms($number,$message)

	{

		$url = 'https://digitalreachapi.dialog.lk/refresh_token.php';

		// DATA JASON ENCODED
 		$data = array("u_name" => "firstteam_api", "passwd" => "0777543580");
 		$data_json = json_encode($data);

		$ch = curl_init();
 		curl_setopt($ch, CURLOPT_URL, $url);

	   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	   curl_setopt($ch, CURLOPT_POST, 1);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  
	   // DATA ARRAY
	   curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   $response = curl_exec($ch);
	  
	   if ($response === false)
	   $response = curl_error($ch);
	  	$data = json_decode($response);
	  	$token =  $data->access_token;
	   curl_close($ch);
	   
	   $url = 'https://digitalreachapi.dialog.lk/camp_req.php';
	   
	   $number = ltrim($number, '0'); //remove any 0s


	   // DATA JASON ENCODED
	   $data = array(
	   "msisdn" => "94".$number,
	   "channel" => "1",
	   "mt_port" => "First Team",
	   "s_time" => date('Y-m-d H:i:s'),
	   "e_time" => date('Y-m-d H:i:s', strtotime('1 hour')),
	   "msg" => $message,
	   "callback_url" => "https://ft61901.rebserp.com/"
	   );
 
 		$data_json = json_encode($data);
 

 		$ch = curl_init();
 		curl_setopt($ch, CURLOPT_URL, $url);


 		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Accept:application/json','Authorization:'.$token));
 		curl_setopt($ch, CURLOPT_POST, 1);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

 		// DATA ARRAY
 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
 
 		$response = curl_exec($ch);
 		if ($response === false)
 		$response = curl_error($ch);

		curl_close($ch); 	
		return stripslashes($response);

	}
}  
