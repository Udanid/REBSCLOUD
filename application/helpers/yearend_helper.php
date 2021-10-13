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
//Start Ticket:3350:Divyanjala 2021/08/30 
if ( ! function_exists('get_finance_year'))
{
	function get_finance_year(){
	
		$CI =& get_instance();
		$CI->load->model('common_model');
		$final_year = $CI->common_model->get_finance_year();
		return $final_year;
	}
}
//end end ticket

if ( ! function_exists('check_user_lock'))
{
	function check_user_lock($user_type)
	{
		$types_array = array('SENIOR ACCOUNTANT','Audit','admin');
		
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

if ( ! function_exists('get_financial_years'))
{
	function get_financial_years()
	{
		$CI =& get_instance();
		$CI->load->model('yearend_model');
		$years = $CI->yearend_model->get_years();
		return $years;
	}
}
