<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Converts D/C to Dr / Cr
 *
 * Covnerts the D/C received from database to corresponding
 * Dr/Cr value for display.
 *
 * @access	public
 * @param	string	'd' or 'c' from database table
 * @return	string
 */

if ( ! function_exists('get_company_project_count'))
{
	function get_company_project_count()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->get_company_project_count();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('get_company_user_count'))
{
	function get_company_user_count()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->get_company_user_count();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('profit_outright_method'))
{
	function profit_outright_method()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->profit_outright_method();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('profit_agreement_method'))
{
	function profit_agreement_method()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->profit_agreement_method();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('sms_status'))
{
	function sms_status()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->sms_status();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('check_project_count'))
{
	function check_project_count()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->check_project_count();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('check_user_count'))
{
	function check_user_count()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->check_user_count();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('get_voucher_configuration'))
{
	function get_voucher_configuration()
	{
		$CI =& get_instance();
		$CI->load->model('rates_model');
		$new_type = $CI->rates_model->get_voucher_configuration();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('get_recipet_configuration'))
{
	function get_recipet_configuration()
	{
		$CI =& get_instance();
		$CI->load->model('rates_model');
		$new_type = $CI->rates_model->get_recipet_configuration();

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('get_company_all_data'))
{
	function get_company_all_data()
	{
		$CI =& get_instance();
		$CI->load->model('company_model');
		$new_type = $CI->company_model->get_company_all_data();

			return $new_type;

			//return $new_type;
	}
}


