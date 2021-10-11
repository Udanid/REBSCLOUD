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

if ( ! function_exists('jurnal_entry'))
{
	function jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('fundtransfer_entry'))
{
	function fundtransfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->fundtransfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('get_account_set'))
{
	function get_account_set($name)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_account_set($name);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('reciept_entry'))
{
	function reciept_entry($crlist,$drlist,$crtot,$drtot,$date,$paytype,$name,$bnk,$branch,$chequnumber,$trntype)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->reciept_entry($crlist,$drlist,$crtot,$drtot,$date,$paytype,$name,$bnk,$branch,$chequnumber,$trntype);
		return $entry_id;
	}
}

if(! function_exists('update_jurnal_entry_insert'))
{
	function update_jurnal_entry_insert($type,$id,$date)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->update_jurnal_entry_insert($type,$id,$date);
	
			return $new_type;
	
			//return $new_type;
	}
}
if(! function_exists('update_jurnal_entry_delete'))
{
	function update_jurnal_entry_delete($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->update_jurnal_entry_delete($entry_id);
	
			return $new_type;
	
			//return $new_type;
	}
}
if(! function_exists('update_jurnal_entry_cancel'))
{
	function update_jurnal_entry_cancel($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->update_jurnal_entry_cancel($entry_id);
	
			return $new_type;
	
			//return $new_type;
	}
}
//
if(! function_exists('get_master_acclist'))
{
	function get_master_acclist()
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_master_acclist();
	
			return $new_type;
	
			//return $new_type;
	}
}
if(! function_exists('project_confirm_entires'))
{
	function project_confirm_entires($prj_id,$prj_code)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->project_confirm_entires($prj_id,$prj_code);
	
			return $new_type;
	
	}
}
if(! function_exists('project_price_entires'))
{
	function project_price_entires($prj_id,$prj_code,$exp)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->project_price_entires($prj_id,$prj_code,$exp);
	
			return $new_type;
	
	}
}
if(! function_exists('project_expence'))
{
	function project_expence($prj_id)
	{
		$CI =& get_instance();
		$CI->load->model('project_model');
		$new_type = $CI->project_model->project_expence($prj_id);
	
			return $new_type;
	
	}
}
if ( ! function_exists('get_thismonth_payment'))
{
	function get_thismonth_payment($loancode,$prvdate,$futureDate)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('eploan_model');
		$new_type = $CI->eploan_model->get_thismonth_payment($loancode,$prvdate,$futureDate);
	
			return $new_type;
	}
}
if ( ! function_exists('get_vaouchercode'))
{
	function get_vaouchercode($idfield,$prifix,$table,$datemount)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_vaouchercode($idfield,$prifix,$table,$datemount);
	
			return $new_type;
	}
}
if ( ! function_exists('create_branchaccluntlist'))
{
	function create_branchaccluntlist()
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->create_branchaccluntlist();
	
			return $new_type;
	}
}
if ( ! function_exists('customer_letter'))
{
	function create_letter($branch_code,$cus_code,$res_code,$loan_code,$ins_id,$letter_type,$msg,$amount)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('message_model');
		$new_type = $CI->message_model->create_letter($branch_code,$cus_code,$res_code,$loan_code,$ins_id,$letter_type,$msg,$amount);
	
			return $new_type;
	}
}
if ( ! function_exists('get_letter_type'))
{
	function get_letter_type($id)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('message_model');
		$new_type = $CI->message_model->get_letter_type($id);
	
			return $new_type;
	}
}
if ( ! function_exists('send_sms'))
{
	function send_sms($number,$msg)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('message_model');
		$new_type = $CI->message_model->send_sms($number,$msg);
	
			return $new_type;
	}
}
if ( ! function_exists('transfer_todayint'))
{
	function transfer_todayint($date)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->transfer_todayint($date);
		return $new_type;
	}
}
if ( ! function_exists('customer_arreaspayment'))
{
	function customer_arreaspayment($branch_code,$cus_code,$res_code,$lot_id,$loan_code,$amount,$ledger_account,$arreas_date,$payid)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->customer_arreaspayment($branch_code,$cus_code,$res_code,$lot_id,$loan_code,$amount,$ledger_account,$arreas_date,$payid);
		return $new_type;
	}
}
if ( ! function_exists('get_pending_payments'))
{
	function get_pending_payments($temp_code)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_pending_payments($temp_code);
		return $new_type;
	}
}

if ( ! function_exists('delete_advance'))
{
	function delete_advance($id)
	{
		$CI =& get_instance();
		$CI->load->model('reservation_model');
		$new_type = $CI->reservation_model->delete_advance($id);
		return $new_type;
	}
}

if ( ! function_exists('get_account_bank_code'))
{
	function get_account_bank_code($id)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$new_type = $CI->common_model->get_account_bank_code($id);
		return $new_type;
	}
}
if ( ! function_exists('get_account_set_config'))
{
	function get_account_set_config($name)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_account_set_config($name);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('get_taskname'))
{
	function get_taskname($name)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$new_type = $CI->common_model->get_taskname($name);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('get_pending_return_charge'))
{
	function get_pending_return_charge($cus_code)
	{
		$CI =& get_instance();
		$CI->load->model('returncharge_model');
		$new_type = $CI->returncharge_model->get_pending_return_charge($cus_code);
	
			return $new_type;
	
			//return $new_type;
	}
	
}
if ( ! function_exists('update_pending_cheque_charge'))
{
	function update_pending_cheque_charge($cus_code,$incomeid)
	{
		$CI =& get_instance();
		$CI->load->model('returncharge_model');
		$new_type = $CI->returncharge_model->update_pending_cheque_charge($cus_code,$incomeid);
	
			return $new_type;
	
			//return $new_type;
	}
	
}
if ( ! function_exists('revert_cheque_charge_payment'))
{
	function revert_cheque_charge_payment($incomeid)
	{
		$CI =& get_instance();
		$CI->load->model('returncharge_model');
		$new_type = $CI->returncharge_model->revert_cheque_charge_payment($incomeid);
	
			return $new_type;
	
			//return $new_type;
	}
	
}
if ( ! function_exists('get_branch_name'))
{
	function get_branch_name($branch_code)
	{
		$CI =& get_instance();
		$CI->load->model('branch_model');
		$new_type = $CI->branch_model->get_branch_name($branch_code);
	
			return $new_type;
	
			//return $new_type;
	}
	
}