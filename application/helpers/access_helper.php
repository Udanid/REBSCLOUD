<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Check if the currently logger in user has the necessary permissions
 * to permform the given action
 *
 * Valid permissions strings are given below :
 *
 * 'view entry'
 * 'create entry'
 * 'edit entry'
 * 'delete entry'
 * 'print entry'
 * 'email entry'
 * 'download entry'
 * 'create ledger'
 * 'edit ledger'
 * 'delete ledger'
 * 'create group'
 * 'edit group'
 * 'delete group'
 * 'create tag'
 * 'edit tag'
 * 'delete tag'
 * 'view reports'
 * 'view log'
 * 'clear log'
 * 'change account settings'
 * 'cf account'
 * 'backup account'
 * 'administer'
 */

if ( ! function_exists('check_access'))
{
	function check_access($action_name)
	{
		if($action_name!='all_branch'){
			$CI =& get_instance();
			$user_role = $CI->session->userdata('usertype');
			$CI->load->model('accesshelper_model');
			$usernotifylist=NULL;


				$user_notify = $CI->accesshelper_model->get_controller_1($action_name,$user_role);
				return $user_notify;
		}
		else
		{
			$CI =& get_instance();
			$access = $CI->session->userdata('all_branch');
			if($access)
			return true;
			else
			return false;
		}
			return true;//$user_notify;
	}
}
if ( ! function_exists('check_notification'))
{
	function check_notification()
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		$permissions['Directors'] = array(
			'cm_tasktype',
			'cm_subtask',
			'cm_doctypes',
			're_introducerms',
			're_landms',
			're_projectms',
			're_eprebate',
			're_prjaclotdata',
			're_epresale',
			're_epreschedule',
			're_adresale',
			're_deedtrn',
			're_reservdicount',
				're_resevation',
			'cm_customerms',
			're_eploan',
			
			'housing',
			're_transferchargersms',
		);
		
		$permissions['Assistant Manager'] = array(
			're_introducerms',
			're_prjaclotdata',
			're_landms',
			're_projectms',
			're_eprebate',
			're_epresale',
			're_epreschedule',
			're_adresale',
			're_eploan',
			're_resevation',
			'cm_customerms',
			're_deedtrn',
			're_reservdicount','cm_passwordreset',
			're_transferchargersms',

		);
		$permissions['SENIOR ACCOUNTANT'] = array(
			'ac_entries',
			'ac_payvoucherdata',
			'Payroll',
			're_transferchargersms',
			
		);
		$permissions['Account_Executive And HR'] = array(
			'cm_passwordreset'

		);
		$permissions['Assistant Account'] = array(
			'cm_passwordreset'

		);
		$permissions['Recovery Officer'] = array(
			're_eprebate',
			're_epresale',
			're_epreschedule',
			're_adresale',
			're_eploan',
			're_transferchargersms',

		);
		
		$permissions['admin'] = array(
			'cm_passwordreset',
			'housing',
			're_transferchargersms',

		);

		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */


		if ( ! isset($permissions[$user_role]))
			return FALSE;

		else
		{
			$CI =& get_instance();
			$CI->load->model('common_model');
			$notifilist=NULL;


				$new_type = $CI->common_model->get_notification_count($permissions[$user_role]);

			return $new_type;


		}
	}
}
if ( ! function_exists('check_notification_counter'))
{
	function check_notification_counter()
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		$permissions['Directors'] = array(
			'cm_tasktype',
			'cm_subtask',
			'cm_doctypes',
			're_introducerms',
			're_landms',
			're_projectms',
			're_eprebate',
			're_epresale',
			'cm_customerms',
			're_epreschedule',
			're_deedtrn',
			're_eploan',
			're_resevation',
			
			'housing',
			're_transferchargersms',
		);
				
		$permissions['Manager'] = array(
			're_introducerms',
			're_landms',
			're_projectms',
			're_eprebate',
			're_epresale',
			're_epreschedule',
			're_adresale',
			're_eploan',
			're_resevation',
			'cm_customerms',
			're_deedtrn',
			're_reservdicount','cm_passwordreset',
			're_transferchargersms',

		);
		$permissions['SENIOR ACCOUNTANT'] = array(
			'ac_entries',
			'ac_payvoucherdata',
			'Payroll',
		
		);
		$permissions['Account_Executive And HR'] = array(
		
			'cm_passwordreset'

		);
$permissions['Recovery Officer'] = array(
			're_eprebate',
			're_epresale',
			're_epreschedule',
			're_adresale',
			're_eploan',
			're_transferchargersms',

		);
		
		$permissions['admin'] = array(
			'cm_passwordreset',
			'housing',
			'ac_cashpayment_ontime',
			'ac_cashreimbursement',
			'ac_cashsettelment_ontime',
			're_transferchargersms',


		);
		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */


		if ( ! isset($permissions[$user_role]))
			return FALSE;

		else
		{
			$CI =& get_instance();
			$CI->load->model('common_model');
			$notifilist=NULL;


				$new_type = $CI->common_model->get_notification_alert($permissions[$user_role]);

			return $new_type;


		}
	}
}

if ( ! function_exists('check_mainmenu'))
{
	function check_mainmenu($action_name)
	{
		$CI =& get_instance();
			$CI->load->model('accesshelper_model');
			$usernotifylist=NULL;
$user_role = $CI->session->userdata('usertype');

				$user_notify = $CI->accesshelper_model->get_main_active($action_name,$user_role);

			return $user_notify;

	}
}

if ( ! function_exists('check_submenu'))
{
	function check_submenu($action_name)
	{
				$CI =& get_instance();
			$CI->load->model('accesshelper_model');
			$user_role = $CI->session->userdata('usertype');

			$usernotifylist=NULL;


				$user_notify = $CI->accesshelper_model->get_sub_active($action_name,$user_role);

			return $user_notify;
	}
}
if ( ! function_exists('get_controller_active'))
{
	function get_controller_active($controlerid,$userid)
	{
		
			$CI =& get_instance();
			$CI->load->model('accesshelper_model');
			$usernotifylist=NULL;


				$user_notify = $CI->accesshelper_model->get_controller_active($controlerid,$userid);

			return $user_notify;


		

	}
}

if ( ! function_exists('check_user_usage'))
{
	function check_user_usage($usertype_id)
	{
		
			$CI =& get_instance();
			$CI->load->model('accesshelper_model');
			$user_notify = $CI->accesshelper_model->check_user_usage($usertype_id);
			return $user_notify;
	}
}
if ( ! function_exists('get_user_modules'))
{
	function get_user_modules($usertype)
	{
		
			$CI =& get_instance();
			$CI->load->model('accesshelper_model');
			$usernotifylist=NULL;


				$user_notify = $CI->accesshelper_model->get_user_modules($usertype);

			return $user_notify;


		

	}
}

// new function added by udani to get users notification counts
if ( ! function_exists('check_notification_user'))
{
	function check_notification_user()
	{
		$CI =& get_instance();
		$user_role = $CI->session->userdata('usertype');
		

		if ( ! isset($user_role))
			return FALSE;

		/* If user is administrator then always allow access */


		
		else
		{
			$CI =& get_instance();
			$CI->load->model('common_model');
			$notifilist=NULL;


				$new_type = $CI->common_model->get_notification_count_user();

			return $new_type;


		}
	}
}
/* End of file access_helper.php */
/* Location: ./system/application/helpers/access_helper.php */
