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

if ( ! function_exists('check_available_lot'))
{
	function check_available_lot($lot_id,$todate)
	{
		$CI =& get_instance();
		$CI->load->model('stockreport_model');
		$new_type = $CI->stockreport_model->check_available_lot($lot_id,$todate);

			return $new_type;

			//return $new_type;
	}
}
if ( ! function_exists('check_advance_lot'))
{
	function check_advance_lot($lot_id,$todate)
	{
		$CI =& get_instance();
		$CI->load->model('stockreport_model');
		$new_type = $CI->stockreport_model->check_advance_lot($lot_id,$todate);

			return $new_type;

			//return $new_type;
	}
}

if ( ! function_exists('check_priclist_confirm'))
{
	function check_priclist_confirm($prjid,$todate)
	{
		$CI =& get_instance();
		$CI->load->model('stockreport_model');
		$new_type = $CI->stockreport_model->check_priclist_confirm($prjid,$todate);

			return $new_type;

			//return $new_type;
	}
}
//updated by nadee 2021-06-08
if ( ! function_exists('resale_lot_period'))
{
	function resale_lot_period($prjid,$from_date,$todate)
	{
		$CI =& get_instance();
		$CI->load->model('stockreport_model');
		$new_type = $CI->stockreport_model->resale_lot_period($prjid,$from_date,$todate);

			return $new_type;

			//return $new_type;
	}
}

if ( ! function_exists('check_advance_lot_period'))
{
	function check_advance_lot_period($prjid,$from_date,$todate)
	{
		$CI =& get_instance();
		$CI->load->model('stockreport_model');
		$new_type = $CI->stockreport_model->check_advance_lot_period($prjid,$from_date,$todate);

			return $new_type;

			//return $new_type;
	}
}
