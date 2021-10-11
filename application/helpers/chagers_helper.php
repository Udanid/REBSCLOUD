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

if ( ! function_exists('other_chargers_data'))
{
	function other_chargers_data($id)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$data = $CI->report_model->get_other_chargers($id);
		return $data;
	}
}
