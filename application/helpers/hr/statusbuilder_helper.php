<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//return the error type message (JSON)
if (!function_exists('errorStatus')){

  function errorStatus($errorCode, $errorMsg){
    $ci =& get_instance();
    return $ci->output
        ->set_content_type('application/json')
        ->set_status_header($errorCode)
        ->set_output(json_encode(array('errorMsg' => $errorMsg)));
  }
}

//return the success message (JSON)
if(!function_exists('successStatus')){
  function successStatus($successMsg){
    $ci =& get_instance();
    return $ci->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array('successMsg' => $successMsg)));
  }
}

?>
