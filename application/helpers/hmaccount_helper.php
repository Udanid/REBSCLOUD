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

if ( ! function_exists('hm_jurnal_entry'))
{
	function hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('hm_fundtransfer_entry'))
{
	function hm_fundtransfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->fundtransfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('hm_get_account_set'))
{
	function hm_get_account_set($name)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->get_account_set($name);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('hm_reciept_entry'))
{
	function hm_reciept_entry($crlist,$drlist,$crtot,$drtot,$date,$paytype,$name,$bnk,$branch,$chequnumber,$trntype)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->reciept_entry($crlist,$drlist,$crtot,$drtot,$date,$paytype,$name,$bnk,$branch,$chequnumber,$trntype);
		return $entry_id;
	}
}

if(! function_exists('hm_update_jurnal_entry_insert'))
{
	function hm_update_jurnal_entry_insert($type,$id,$date)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->update_jurnal_entry_insert($type,$id,$date);
	
			return $new_type;
	
			//return $new_type;
	}
}
if(! function_exists('hm_update_jurnal_entry_delete'))
{
	function hm_update_jurnal_entry_delete($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->update_jurnal_entry_delete($entry_id);
	
			return $new_type;
	
			//return $new_type;
	}
}
if(! function_exists('hm_update_jurnal_entry_cancel'))
{
	function hm_update_jurnal_entry_cancel($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->update_jurnal_entry_cancel($entry_id);
	
			return $new_type;
	
			//return $new_type;
	}
}
//
if(! function_exists('hm_get_master_acclist'))
{
	function hm_get_master_acclist()
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->get_master_acclist();
	
			return $new_type;
	
			//return $new_type;
	}
}
if(! function_exists('hm_project_confirm_entires'))
{
	function hm_project_confirm_entires($prj_id,$prj_code)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->project_confirm_entires($prj_id,$prj_code);
	
			return $new_type;
	
	}
}
if(! function_exists('hm_project_price_entires'))
{
	function hm_project_price_entires($prj_id,$prj_code,$exp)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->project_price_entires($prj_id,$prj_code,$exp);
	
			return $new_type;
	
	}
}
if(! function_exists('hm_project_expence'))
{
	function hm_project_expence($prj_id)
	{
		$CI =& get_instance();
		$CI->load->model('hm_project_model');
		$new_type = $CI->hm_project_model->project_expence($prj_id);
	
			return $new_type;
	
	}
}
if ( ! function_exists('hm_get_thismonth_payment'))
{
	function hm_get_thismonth_payment($loancode,$prvdate,$futureDate)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('hm_eploan_model');
		$new_type = $CI->hm_eploan_model->get_thismonth_payment($loancode,$prvdate,$futureDate);
	
			return $new_type;
	}
}
if ( ! function_exists('hm_customer_letter'))
{
	function hm_create_letter($branch_code,$cus_code,$res_code,$loan_code,$ins_id,$letter_type,$msg,$amount)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('hm_message_model');
		$new_type = $CI->hm_message_model->create_letter($branch_code,$cus_code,$res_code,$loan_code,$ins_id,$letter_type,$msg,$amount);
	
			return $new_type;
	}
}
if ( ! function_exists('hm_get_letter_type'))
{
	function hm_get_letter_type($id)
	{
		$CI =& get_instance();
		$new_type=0;
		$CI->load->model('hm_message_model');
		$new_type = $CI->hm_message_model->get_letter_type($id);
	
			return $new_type;
	}
}

if ( ! function_exists('hm_transfer_todayint'))
{
	function hm_transfer_todayint($date)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->transfer_todayint($date);
		return $new_type;
	}
}
if ( ! function_exists('hm_customer_arreaspayment'))
{
	function hm_customer_arreaspayment($branch_code,$cus_code,$res_code,$lot_id,$loan_code,$amount,$ledger_account,$arreas_date,$payid)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->customer_arreaspayment($branch_code,$cus_code,$res_code,$lot_id,$loan_code,$amount,$ledger_account,$arreas_date,$payid);
		return $new_type;
	}
}
if ( ! function_exists('hm_get_pending_payments'))
{
	function hm_get_pending_payments($temp_code)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->get_pending_payments($temp_code);
		return $new_type;
	}
}

if ( ! function_exists('hm_delete_advance'))
{
	function hm_delete_advance($id)
	{
		$CI =& get_instance();
		$CI->load->model('hm_reservation_model');
		$new_type = $CI->hm_reservation_model->delete_advance($id);
		return $new_type;
	}
}




if ( ! function_exists('hm_get_loan_date_di'))
{
	function hm_get_loan_date_di($loancode,$date)
	{
		$CI =& get_instance();
		$CI->load->model('hm_message_model');
		$new_type = $CI->hm_message_model->get_loan_date_di($loancode,$date);
	
			return $new_type;
	
			//return $new_type;
	}
	
}

if ( ! function_exists('hm_projectname_by_voucherid'))
{
	function hm_projectname_by_voucherid($loancode)
	{
		$CI =& get_instance();
		$CI->load->model('hm_projectpayment_model');
		$new_type = $CI->hm_projectpayment_model->projectname_by_voucherid($loancode);
	
			return $new_type;
	
			//return $new_type;
	}
	
}
if ( ! function_exists('hm_get_advance_date_di'))
{
	function hm_get_advance_date_di($rescode,$date)
	{
		$CI =& get_instance();
		$CI->load->model('hm_dicalculate_model');
		$new_type = $CI->hm_dicalculate_model->get_advance_date_di($rescode,$date);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_update_today_di'))
{
	function hm_update_today_di($rescode,$date,$di)
	{
		$CI =& get_instance();
		$CI->load->model('hm_dicalculate_model');
		$new_type = $CI->hm_dicalculate_model->update_today_di($rescode,$date,$di);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_insert_unrealizedsale'))
{
	function hm_insert_unrealizedsale($prj_id,$res_code,$full_sale,$full_cost,$unrealized_sale,$unrealized_cost,$first_trndate,$method)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->insert_unrealizedsale($prj_id,$res_code,$full_sale,$full_cost,$unrealized_sale,$unrealized_cost,$first_trndate,$method);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_insert_unrdata'))
{
	function hm_insert_unrdata($res_code,$income_id,$rct_no,$date,$trn_sale,$trn_cost,$discription)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->insert_unrdata($res_code,$income_id,$rct_no,$date,$trn_sale,$trn_cost,$discription);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_update_unrealized_sale'))
{
	function hm_update_unrealized_sale($res_code,$incomeid)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->insert_unrdata($res_code,$incomeid);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_get_unrealized_data'))
{
	function hm_get_unrealized_data($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('hm_accountinterface_model');
		$new_type = $CI->hm_accountinterface_model->get_unrealized_data($res_code);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_project_name_and_lot_bymodule'))
{
	function get_project_name_and_lot_bymodule($module,$prj_id,$lot_id)
	{
		$CI =& get_instance();
		$CI->load->model('entry_model');
		$new_type = $CI->entry_model->get_project_name_and_lot_bymodule($module,$prj_id,$lot_id);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_get_reciept_customer'))
{
	function hm_get_reciept_customer($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('hm_reservation_model');
		$new_type = $CI->hm_reservation_model->get_reciept_customer($res_code);

			return $new_type;

			//return $new_type;
	}

}

if ( ! function_exists('hm_get_next_instalmant'))
{
	function hm_get_next_instalmant($loan_code,$date)
	{
		$CI =& get_instance();
		$CI->load->model('hm_eploan_model');
		$new_type = $CI->hm_eploan_model->get_next_instalmant($loan_code,$date);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_get_first_advance'))
{
	function hm_get_first_advance($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('hm_report_model');
		$new_type = $CI->hm_report_model->get_first_advance($res_code);

			return $new_type;

			//return $new_type;
	}

}
//new function on summery report
if ( ! function_exists('hm_get_last_payment_date'))
{
	function hm_get_last_payment_date($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('hm_report_model');
		$new_type = $CI->hm_report_model->get_last_payment_date($res_code);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('hm_uptodate_arrears'))
{
	function hm_uptodate_arrears($res_code,$date)
	{
		$CI =& get_instance();
		$CI->load->model('hm_report_model');
		$new_type = $CI->hm_report_model->uptodate_arrears($res_code,$date);

			return $new_type;

			//return $new_type;
	}

}