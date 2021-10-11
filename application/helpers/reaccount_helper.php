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
	function jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id,$res_code)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id,$res_code);

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
	function get_account_set_config($name,$type)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_account_set_config($name,$type);

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
if ( ! function_exists('get_month_count'))
{

function get_month_count($date1, $date2)
{
    $ts1=strtotime($date1);
$ts2=strtotime($date2);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

$day1 = date('d', $ts1); /* I'VE ADDED THE DAY VARIABLE OF DATE1 AND DATE2 */
$day2 = date('d', $ts2);

$diff = (($year2 - $year1) * 12) + ($month2 - $month1);


    return $diff;
}
}
if ( ! function_exists('get_loan_date_di'))
{
	function get_loan_date_di($loancode,$date)
	{
		$CI =& get_instance();
		$CI->load->model('message_model');
		$new_type = $CI->message_model->get_loan_date_di($loancode,$date);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_user_fullname'))
{
	function get_user_fullname($loancode)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$new_type = $CI->common_model->get_user_fullname($loancode);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_user_fullname_id'))
{
	function get_user_fullname_id($loancode)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$new_type = $CI->common_model->get_user_fullname_id($loancode);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('projectname_by_voucherid'))
{
	function projectname_by_voucherid($loancode)
	{
		$CI =& get_instance();
		$CI->load->model('projectpayment_model');
		$new_type = $CI->projectpayment_model->projectname_by_voucherid($loancode);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('insert_oumit_transactions'))
{
	function insert_oumit_transactions($entry_id,$res_code,$loan_code,$prj_id,$lot_id,$date,$reason)
	{
		$CI =& get_instance();
		$CI->load->model('audit_model');
		$new_type = $CI->audit_model->insert_oumit_transactions($entry_id,$res_code,$loan_code,$prj_id,$lot_id,$date,$reason);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('insert_change_transactions'))
{
	function insert_change_transactions($entry_id,$res_code,$loan_code,$prj_id,$lot_id,$date,$reason)
	{
		$CI =& get_instance();
		$CI->load->model('audit_model');
		$new_type = $CI->audit_model->insert_change_transactions($entry_id,$res_code,$loan_code,$prj_id,$lot_id,$date,$reason);

			return $new_type;

			//return $new_type;
	}

}

if ( ! function_exists('insert_settle_transactions'))
{
	function insert_settle_transactions($res_code,$prj_id,$lot_id,$date)
	{
		$CI =& get_instance();
		$CI->load->model('audit_model');
		$new_type = $CI->audit_model->insert_settle_transactions($res_code,$prj_id,$lot_id,$date);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_commission_rate_by_catid_tableid'))
{
	function get_commission_rate_by_catid_tableid($catid,$tableid,$year)
	{
		$CI =& get_instance();
		$CI->load->model('commission_model');
		$new_type = $CI->commission_model->get_commission_rate_by_catid_tableid($catid,$tableid,$year);

			return $new_type;

			//return $new_type;
	}

}
/// odiliya modification update by udani 2019-03-19
if ( ! function_exists('get_advance_date_di'))
{
	function get_advance_date_di($rescode,$date)
	{
		$CI =& get_instance();
		$CI->load->model('dicalculate_model');
		$new_type = $CI->dicalculate_model->get_advance_date_di($rescode,$date);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('update_today_di'))
{
	function update_today_di($rescode,$date,$di)
	{
		$CI =& get_instance();
		$CI->load->model('dicalculate_model');
		$new_type = $CI->dicalculate_model->update_today_di($rescode,$date,$di);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('insert_unrealizedsale'))
{
	function insert_unrealizedsale($prj_id,$res_code,$full_sale,$full_cost,$unrealized_sale,$unrealized_cost,$first_trndate,$method,$hm_discounted_price,$housing_cost,$unrealised_sale_hm,$unrealised_cost_hm)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->insert_unrealizedsale($prj_id,$res_code,$full_sale,$full_cost,$unrealized_sale,$unrealized_cost,$first_trndate,$method,$hm_discounted_price,$housing_cost,$unrealised_sale_hm,$unrealised_cost_hm);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('insert_unrdata'))
{
	function insert_unrdata($res_code,$income_id,$rct_no,$date,$trn_sale,$trn_cost,$discription,$realized_sale_hm,$realized_cost_hm)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->insert_unrdata($res_code,$income_id,$rct_no,$date,$trn_sale,$trn_cost,$discription,$realized_sale_hm,$realized_cost_hm);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('update_unrealized_sale'))
{
	function update_unrealized_sale($res_code,$incomeid)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->insert_unrdata($res_code,$incomeid);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('delete_unrealized_sale'))
{
	function delete_unrealized_sale($res_code,$incomeid)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->delete_unrealized_sale($res_code,$incomeid);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_unrealized_data'))
{
	function get_unrealized_data($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('accountinterface_model');
		$new_type = $CI->accountinterface_model->get_unrealized_data($res_code);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_reciept_customer'))
{
	function get_reciept_customer($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('reservation_model');
		$new_type = $CI->reservation_model->get_reciept_customer($res_code);

			return $new_type;

			//return $new_type;
	}

}

if ( ! function_exists('get_next_instalmant'))
{
	function get_next_instalmant($loan_code,$date)
	{
		$CI =& get_instance();
		$CI->load->model('eploan_model');
		$new_type = $CI->eploan_model->get_next_instalmant($loan_code,$date);

			return $new_type;

			//return $new_type;
	}

}

//new function on summery report
if ( ! function_exists('get_first_advance'))
{
	function get_first_advance($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$new_type = $CI->report_model->get_first_advance($res_code);

			return $new_type;

			//return $new_type;
	}

}

//new function on summery report
if ( ! function_exists('get_last_payment_date'))
{
	function get_last_payment_date($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$new_type = $CI->report_model->get_last_payment_date($res_code);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('uptodate_arrears'))
{
	function uptodate_arrears($res_code,$date)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$new_type = $CI->report_model->uptodate_arrears($res_code,$date);

			return $new_type;

			//return $new_type;
	}

}

//sales forcast helper functions

if ( ! function_exists('check_pending_lots'))
{
	function check_pending_lots($type)
	{
		$CI =& get_instance();
		$CI->load->model('sales_model');
		$new_type = $CI->sales_model->check_pending_lots($type);

			return $new_type;

			//return $new_type;
	}

}

if ( ! function_exists('get_eploan_last_date'))
{
	function get_eploan_last_date($loancode,$seque)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$new_type = $CI->report_model->get_eploan_last_date($loancode,$seque);

			return $new_type;

			//return $new_type;
	}

}

if ( ! function_exists('get_eploan_first_date'))
{
	function get_eploan_first_date($loancode,$seque)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$new_type = $CI->report_model->get_eploan_first_date($loancode,$seque);

			return $new_type;

			//return $new_type;
	}

}

if ( ! function_exists('get_eploan_tot'))
{
	function get_eploan_tot($loancode,$date,$seque)
	{
		$CI =& get_instance();
		$CI->load->model('report_model');
		$new_type = $CI->report_model->get_eploan_tot($loancode,$date,$seque);

			return $new_type;

			//return $new_type;
	}

}

// aded by udani - restric reciept cancelation  2020-05-15
if ( ! function_exists('check_chancel_true'))
{
    function check_chancel_true($entryid)
    {
        $CI =& get_instance();
        $CI->load->model('entry_model');
        $result = $CI->entry_model->check_chancel_true($entryid);

            return $result;


    }

}
// aded by udani - restric reciept cancelation  2020-05-15
if ( ! function_exists('get_loan_paid_cap_amount_customerseach'))
{
    function get_loan_paid_cap_amount_customerseach($code_type,$rescode)
    {
        $CI =& get_instance();
        $CI->load->model('customer_model');
        $result = $CI->customer_model->get_loan_paid_cap_amount_customerseach($code_type,$rescode);

            return $result;


    }

}
// aded by udani - restric payment voucher cancelation  2020-05-15
if ( ! function_exists('delete_payvoucher_check'))
{
    function delete_payvoucher_check($voucherid)
    {
        $CI =& get_instance();
        $CI->load->model('paymentvoucher_model');
        $result = $CI->paymentvoucher_model->delete_payvoucher_check($voucherid);

            return $result;


    }

}
// added by udani as futureland new customization
if ( ! function_exists('get_letternotification'))
{
    function get_letternotification()
    {
        $CI =& get_instance();
        $CI->load->model('message_model');
        $result = $CI->message_model->get_letternotification();

            return $result;


    }

}
if ( ! function_exists('get_new_discount_rate'))
{
    function get_new_discount_rate($res_date,$pay_date,$rate)
    {
        $CI =& get_instance();
        $CI->load->model('reservationdiscount_model');
        $result = $CI->reservationdiscount_model->get_new_discount_rate($res_date,$pay_date,$rate);

            return $result;


    }

}
if ( ! function_exists('get_last_payment_date_current_instalment'))
{
    function get_last_payment_date_current_instalment($ins_id)
    {
        $CI =& get_instance();
        $CI->load->model('eploan_model');
        $result = $CI->eploan_model->get_last_payment_date_current_instalment($ins_id);

            return $result;


    }

}

if(! function_exists('excel_rate'))
{
	function excel_rate($month, $payment, $amount)
	{
		// make an initial guess
		$error = 0.0000001; $high = 1.00; $low = 0.00;
		$rate = (2.0 * ($month * $payment - $amount)) / ($amount * $month);

		while(true)
		{
		// check for error margin
		$calc = pow(1 + $rate, $month);
		$calc = ($rate * $calc) / ($calc - 1.0);
		$calc -= $payment / $amount;

			if ($calc > $error) {
			// guess too high, lower the guess
			$high = $rate;
			$rate = ($high + $low) / 2;
			} elseif ($calc < -$error)
			{
			// guess too low, higher the guess
			$low = $rate;
			$rate = ($high + $low) / 2;
			} else
			 {
		// acceptable guess
			break;
			}
		}

		return $rate * 12;
	}


}

if ( ! function_exists('loan_paid_totals'))
{
    function loan_paid_totals($type,$date,$prj_id)
    {
        $CI =& get_instance();
        $CI->load->model('ledgerbalance_report_model');
        $result = $CI->ledgerbalance_report_model->loan_paid_totals($type,$date,$prj_id);

            return $result;


    }

}


if ( ! function_exists('loan_due_totals'))
{
    function loan_due_totals($loan_type,$date,$prj_id)
    {
        $CI =& get_instance();
        $CI->load->model('ledgerbalance_report_model');
        $result = $CI->ledgerbalance_report_model->loan_due_totals($loan_type,$date,$prj_id);

            return $result;


    }

}
/*Ticket No:3049 Updated By Madushan 2021-07-07*/
if ( ! function_exists('loan_paid_totals_loancode'))
{
    function loan_paid_totals_loancode($loancode,$date,$resqn = '')
    {
        $CI =& get_instance();
        $CI->load->model('ledgerbalance_report_model');
        $result = $CI->ledgerbalance_report_model->loan_paid_totals_loancode($loancode,$date,$resqn);

            return $result;


    }

}

/*Ticket No:3049 Updated By Madushan 2021-07-07*/
if ( ! function_exists('loan_due_totals_loancode'))
{
    function loan_due_totals_loancode($loancode,$date,$resqn = '')
    {
        $CI =& get_instance();
        $CI->load->model('ledgerbalance_report_model');
        $result = $CI->ledgerbalance_report_model->loan_due_totals_loancode($loancode,$date,$resqn);

            return $result;


    }

}

//updated by nadee 2020-12-16

if ( ! function_exists('get_vouchers_by_entryid'))
{
	function get_vouchers_by_entryid($entry_id,$ledger_id)
	{
		$CI =& get_instance();
		$CI->load->model('paymentvoucher_model');
		$result = $CI->paymentvoucher_model->get_vouchers_by_entryid($entry_id,$ledger_id);
		$html = '';
		if($result){
			return $result;
		}else
			return false;


	}
}

//Ticket No:3426 Added By Madushan 2021-09-13
if ( ! function_exists('get_invoice_vouchers_by_entryid'))
{
	function get_invoice_vouchers_by_entryid($entry_id,$ledger_id)
	{
		$CI =& get_instance();
		$CI->load->model('paymentvoucher_model');
		$result = $CI->paymentvoucher_model->get_invoice_vouchers_by_entryid($entry_id,$ledger_id);
		$html = '';
		if($result){
			return $result;
		}else
			return false;


	}
}

if ( ! function_exists('get_inv_payment_details'))
{
	function get_inv_payment_details($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('paymentvoucher_model');
		$result = $CI->paymentvoucher_model->get_inv_payment_details($entry_id);
		$html = '';
		if($result){
			return $result;
		}else
			return false;


	}
}

//End of Ticket No:3426

if ( ! function_exists('get_entry_projectlist'))
{
    function get_entry_projectlist($entryid)
    {
        $CI =& get_instance();
        $CI->load->model('accresupport_model');
        $result = $CI->accresupport_model->get_entry_projectlist($entryid);

            return $result ;


    }

}

if ( ! function_exists('get_paid_amount_code'))
{
    function get_paid_amount_code($id)
    {
        $CI =& get_instance();
        $CI->load->model('additional_development_model');
        $result = $CI->additional_development_model->get_paid_amount_code($id);

            return $result ;


    }

}

if ( ! function_exists('get_paid_capital_byrescode'))
{
    function get_paid_capital_byrescode($id,$todate)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('search_model');
        $result = $CI->search_model->get_paid_capital_byrescode($id,$todate);

            return $result;


    }

}

if ( ! function_exists('remaining_interest_byrescode'))
{
    function remaining_interest_byrescode($id,$todate)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('search_model');
        $result = $CI->search_model->remaining_interest_byrescode($id,$todate);

            return $result;


    }

}

if ( ! function_exists('get_reshedule_data'))
{
    function get_reshedule_data($id)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('search_model');
        $result = $CI->search_model->get_reshedule_data($id);

            return $result;


    }

}
//added by udani requestd modification on 2021-02-12
if ( ! function_exists('get_deu_data'))
{
    function get_deu_data($loan_code,$date,$loan_type,$reshedule_seq)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('eploan_model');
        $result = $CI->eploan_model->get_deu_data($loan_code,$date,$loan_type,$reshedule_seq);

            return $result;


    }

}
if ( ! function_exists('loan_inquary_paid_totals'))
{
    function loan_inquary_paid_totals($loan_code,$date,$reshedule_seq)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('eploan_model');
        $result = $CI->eploan_model->loan_inquary_paid_totals($loan_code,$date,$reshedule_seq);

            return $result;


    }

}

if ( ! function_exists('get_excess_byincomeid'))
{
    function get_excess_byincomeid($incomeid)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('accresupport_model');
        $result = $CI->accresupport_model->get_excess_byincomeid($incomeid);

            return $result;


    }

}

//Ticket No-2774 | Added By Uvini
if ( ! function_exists('get_excess_byrescode'))
{
    function get_excess_byrescode($res_code)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('accresupport_model');
        $result = $CI->accresupport_model->get_excess_byrescode($res_code);

            return $result;


    }

}


if ( ! function_exists('getbank_details'))
{
    function getbank_details($code)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('common_model');
        $result = $CI->common_model->getbank_details($code);

            return $result;


    }

}
//added by udani ticket number 2591
if ( ! function_exists('get_realized_sale_andcost_date'))
{
    function get_realized_sale_andcost_date($res_code,$date)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('report_model');
        $result = $CI->report_model->get_realized_sale_andcost_date($res_code,$date);

            return $result;


    }

}
//added by udani ticket number 2564
if ( ! function_exists('get_actual_loantype'))
{
    function get_actual_loantype($loan_code)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('eploan_model');
        $result = $CI->eploan_model->get_actual_loantype($loan_code);

            return $result;


    }

}

//updated by nadee 2021-03-30 ticket number 2582
if ( ! function_exists('get_next_interest_data'))
{
    function get_next_interest_data($loan_code,$date,$loan_type,$reshedule_seq)
    {
		 $result =false;
        $CI =& get_instance();
        $CI->load->model('eploan_model');
        $result = $CI->eploan_model->get_next_interest_data($loan_code,$date,$loan_type,$reshedule_seq);

				            return $result;


	}

}

/*Ticket No:2889 Added By Madushan 2021.06.16*/
if ( ! function_exists('check_advance_chancel_true'))
{
	function check_advance_chancel_true($advanceid)
	{
		$CI =& get_instance();
		$CI->load->model('entry_model');
		$result = $CI->entry_model->check_advance_cancel_true($advanceid);

			return $result;


	}

}
/*End Of Ticket No:2889*/
if ( ! function_exists('get_next_ledgerid'))
{
	function get_next_ledgerid($groupid)
	{
		$CI =& get_instance();
		$CI->load->model('ledger_model');
		$result = $CI->ledger_model->get_next_ledgerid($groupid);

			return $result;


	}

}


