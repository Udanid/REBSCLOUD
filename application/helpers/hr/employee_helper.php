<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_employee_info'))

{

	function get_employee_info($id,$branch)

	{

		$CI =& get_instance();
		$CI->load->model('search_model');
		$data = $CI->search_model->get_qlft_employee($id,$branch);
	
			return $data;
	}

}

if ( ! function_exists('cal_age'))

{

	function cal_age($dob)

	{

		$dob = date("Y-m-d",strtotime($dob));

        $dobObject = new DateTime($dob);
        $nowObject = new DateTime();

        $diff = $dobObject->diff($nowObject);

        return $diff->y;
	}

}

/*Ticket No:2863 Added By Madushan 2021.05.21*/
if ( ! function_exists('get_employee_info_by_id'))

{

	function get_employee_info_by_id($id)

	{

		$CI =& get_instance();
		$CI->load->model('search_model');
		$data = $CI->search_model->get_employee_info_by_id($id);
	
			return $data;
	}

}