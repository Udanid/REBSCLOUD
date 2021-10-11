<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_calandar_notification'))
{
	function get_calandar_notification($userid)
	{
		$CI =& get_instance();
		$CI->load->model('wip/calendar_model');
		$holidays = $CI->calendar_model->get_calandar_notification($userid);
		return $holidays;
	
	}
}

