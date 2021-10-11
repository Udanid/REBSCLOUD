<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('check_previousyear_lock'))
{
	function check_previousyear_lock()
	{
		$CI =& get_instance();
		$CI->load->model('yearend_model');
		$locked_status = $CI->yearend_model->check_previousyear_lock();
		return $locked_status;
	
	}
}

if ( ! function_exists('check_user_lock'))
{
	function check_user_lock($user_type)
	{
		$types_array = array('Finance','Managing Director','admin');
		
		if (in_array($user_type, $types_array)){
			return true;
		}else{
			return false;
		}
	}
}

if ( ! function_exists('get_last_year'))
{
	function get_last_year($thisyear)
	{
		$CI =& get_instance();
		$CI->load->model('yearend_model');
		$year = $CI->yearend_model->get_last_year($thisyear);
		return $year;
	}
}
