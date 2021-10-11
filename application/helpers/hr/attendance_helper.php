<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_emp_duty_in_out'))

{

	function get_emp_duty_in_out($type)

	{

		$CI =& get_instance();
		$CI->load->model('hr/common_hr_model');
		$data = $CI->common_hr_model->get_emp_duty_in_out($type);
	
			return $data;
	}

}


if ( ! function_exists('cal_avg_attendance_time'))

{

	function cal_avg_attendance_time($emp_id,$from,$to,$type)

	{

		$CI =& get_instance();
		$CI->load->model('hr/common_hr_model');
		$data = $CI->common_hr_model->get_emp_attendance_details_range($emp_id,$from,$to);
		$tot_time = 0.0;
		$avg = 0.0;
		$i = 1;
		$seconds = 0;
		if($data){
			foreach($data as $row){
				if($type == 'IN')
				{
					$time = new DateTime($row->duty_in);
					$seconds = intval($time->format('H')*3600)+intval($time->format('i')*60)+intval($time->format('s'));
					$tot_time = $tot_time + $seconds;
				}
				elseif($type == 'OUT')
				{
					$time = new DateTime($row->duty_out);
					$seconds = intval($time->format('H')*3600)+intval($time->format('i')*60)+intval($time->format('s'));
					$tot_time = $tot_time + $seconds;
				}

				$i++;
			}

			$avg = $tot_time/($i-1);

			$avg_hours = intval($avg/3600);
			$avg_min = intval(($avg%3600)/60);
			$time = strval($avg_hours).'.'.strval($avg_min);

			$avg_time = new DateTime($time);


			return $avg_time->format('H:i');
			//return strpos(strrev((strval($avg))),'.');

		}
		else
		 return '0';
	}

}

if ( ! function_exists('cal_avg_working_hours'))

{

	function cal_avg_working_hours($emp_id,$from,$to)

	{

		$CI =& get_instance();
		$CI->load->model('hr/common_hr_model');
		$data = $CI->common_hr_model->get_emp_attendance_details_range($emp_id,$from,$to);
		$tot_time = 0.0;
		$avg = 0.0;
		$i = 1;
		$seconds_in = $seconds_out = 0;
		if($data){
			foreach($data as $row){
				
				$time_in = new DateTime($row->duty_in);
				$seconds_in = intval($time_in->format('H')*3600)+intval($time_in->format('i')*60)+intval($time_in->format('s'));
				$time_out = new DateTime($row->duty_out);
				$seconds_out = intval($time_out->format('H')*3600)+intval($time_out->format('i')*60)+intval($time_out->format('s'));

				$wk_seconds = $seconds_out - $seconds_in;
				
				$tot_time = $tot_time + $wk_seconds;
				

				$i++;
			}

			$avg = $tot_time/($i-1);

			$avg_hours = intval($avg/3600);
			$avg_min = intval(($avg%3600)/60);
			$time = strval($avg_hours).'.'.strval($avg_min);

			$avg_time = new DateTime($time);


			return $avg_time->format('H:i');
			//return strpos(strrev((strval($avg))),'.');

		}
		else
		 return '0';
	}

}



if ( ! function_exists('time_to_sec'))

{

	function time_to_sec($time) {
    	
    	$time = new DateTime($time);
		$seconds = intval($time->format('H')*3600)+intval($time->format('i')*60)+intval($time->format('s'));
		return $seconds;
}
}


