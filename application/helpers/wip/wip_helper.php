<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_holidays'))
{
	function get_holidays()
	{
		$CI =& get_instance();
		$CI->load->model('hr/employee_model');
		$holidays = $CI->employee_model->get_holidays();
		return $holidays;
	
	}
}

if ( ! function_exists('get_task_progress'))
{
	function get_task_progress($task_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$progress = $CI->task_model->get_task_progress($task_id);
		return $progress;
	
	}
}

if ( ! function_exists('get_task_remaining_days'))
{
	function get_task_remaining_days($start_date,$end_date)
	{
		$CI =& get_instance();
		$CI->load->model('wip/sub_task_model');
		$remaining_days = $CI->sub_task_model->get_task_remaining_days($start_date,$end_date);
		return $remaining_days;
	
	}
}

if ( ! function_exists('sub_task_skip_holiday_count'))
{
	function sub_task_skip_holiday_count($start_date,$requested_duration)
	{
		$CI =& get_instance();
		$CI->load->model('wip/sub_task_model');
		$remaining_days = $CI->sub_task_model->sub_task_skip_holiday_count($start_date,$requested_duration);
		return $remaining_days;
	
	}
}

if ( ! function_exists('is_project_owner'))
{
	function is_project_owner($checkuser,$prj_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$is_user = $CI->task_model->is_project_owner($checkuser,$prj_id);
		return $is_user;
	
	}
}

if ( ! function_exists('get_pending_tasks'))
{
	function get_pending_tasks($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$count = $CI->task_model->get_pending_tasks($user_id);
		return $count;
	
	}
}

if ( ! function_exists('get_pending_task_aaprovals'))
{
	function get_pending_task_aaprovals($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$count = $CI->task_model->get_pending_task_aaprovals($user_id);
		return $count;
	
	}
}

if ( ! function_exists('get_task_status_percentage'))
{
	function get_task_status_percentage($user_id,$type)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$count = $CI->task_model->get_task_status_percentage($user_id,$type);
		return $count;
	
	}
}

if ( ! function_exists('get_expired_tasks'))
{
	function get_expired_tasks($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$count = $CI->task_model->get_expired_tasks($user_id);
		return $count;
	
	}
}

if ( ! function_exists('get_project_task_completion'))
{
	function get_project_task_completion($user_id,$project_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/task_model');
		$completion = $CI->task_model->get_project_task_completion($user_id,$project_id);
		return $completion;
	
	}
}

if ( ! function_exists('get_subtasks_by_taskid'))
{
	function get_subtasks_by_taskid($task_id,$user_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/sub_task_model');
		$sub_tasks = $CI->sub_task_model->get_subtasks_by_taskid($task_id,$user_id);
		return $sub_tasks;
	
	}
}

if ( ! function_exists('is_user_have_subtasks'))
{
	function is_user_have_subtasks($user_id,$task_id)
	{
		$CI =& get_instance();
		$CI->load->model('wip/sub_task_model');
		$sub_tasks = $CI->sub_task_model->is_user_have_subtasks($user_id,$task_id);
		return $sub_tasks;
	
	}
}