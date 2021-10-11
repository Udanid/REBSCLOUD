<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('generateEmpID')){
  function generateEmpID($index){
    $baseVal = "00";
    $zeroBase = "";
    $lenghtUID = strlen($index);
    for($x=0; $x<(4-$lenghtUID); $x++){
      $zeroBase = $zeroBase."0";
    }
    $employeeID = $baseVal.$zeroBase.$index;
    return $employeeID;
  }
}

?>
