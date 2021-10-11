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

if ( ! function_exists('check_recordflag'))
{
	function check_recordflag($table,$id,$fieldname)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$new_type = $CI->common_model->check_common_activeflag($table,$id,$fieldname);

			return $new_type;

			//return $new_type;
	}
}

if ( ! function_exists('get_rate'))
{
	function get_rate($name)
	{
		$CI =& get_instance();
		$CI->load->model('rates_model');
		$new_type = $CI->rates_model->get_rate_name($name);

			return $new_type;

			//return $new_type;
	}
}



/**
 * Floating Point Operations
 *
 * Multiply the float by 100, convert it to integer,
 * Perform the integer operation and then divide the result
 * by 100 and return the result
 *
 * @access	public
 * @param	float	number 1
 * @param	float	number 2
 * @param	string	operation to be performed
 * @return	float	result of the operation
 */


/* End of file custom_helper.php */
/* Location: ./system/application/helpers/custom_helper.php */

if ( ! function_exists('convert_dc'))
{
	function convert_dc($label)
	{
		if ($label == "D")
			return "Dr";
		else if ($label == "C")
			return "Cr";
		else
			return "Error";
	}
}

/**
 * Converts amount to Dr or Cr Value
 *
 * Covnerts the amount to 0 or Dr or Cr value for display
 *
 * @access	public
 * @param	float	amount for display
 * @return	string
 */
if ( ! function_exists('convert_amount_dc'))
{
	function convert_amount_dc($amount)
	{
		if ($amount == "D")
			return "0";
		else if ($amount < 0)
			return "Cr " . number_format(convert_cur(-$amount), 2, '.', ',');
		else
			return "Dr " . number_format(convert_cur($amount), 2, '.', ',');
	}
}
//added by Eranga
if ( ! function_exists('convert_amount_dc2'))
{
	function convert_amount_dc2($amount)
	{
		if ($amount == "D")
			return "0";
		else if ($amount < 0)
			return  "-" . number_format(convert_cur(-$amount), 2, '.', ',');
		else
			return number_format(convert_cur($amount), 2, '.', ',');
	}
}

/**
 * Converts Opening balance amount to Dr or Cr Value
 *
 * Covnerts the Opening balance amount to 0 or Dr or Cr value for display
 *
 * @access	public
 * @param	amount
 * @param	debit or credit
 * @return	string
 */
if ( ! function_exists('convert_opening'))
{
	function convert_opening($amount, $dc)
	{
		if ($amount == 0)
			return "0";
		else if ($dc == 'D')
			return "Dr " . number_format(convert_cur($amount), 2, '.', ',');
		else
			return "Cr " . number_format(convert_cur($amount), 2, '.', ',');
	}
}

if ( ! function_exists('convert_cur'))
{
	function convert_cur($amount)
	{
		return number_format($amount, 2, '.', '');
	}
}

if ( ! function_exists('convert_account'))
{
	function convert_account($amount)
	{
		return number_format($amount, 2, '.', ',');
	}
}
/**
 * Return the value of variable is set
 *
 * Return the value of varaible is set else return empty string
 *
 * @access	public
 * @param	a varaible
 * @return	string value
 */
if ( ! function_exists('print_value'))
{
	function print_value($value = NULL, $default = "")
	{
		if (isset($value))
			return $value;
		else
			return $default;
	}
}

/**
 * Return Entry Type information
 *
 * @access	public
 * @param	int entry type id
 * @return	array
 */
if ( ! function_exists('entry_type_info'))
{
	function entry_type_info($entry_type_id)
	{

		///********** Old
//		$CI =& get_instance();
//		$entry_type_all = $CI->config->item('account_ac_entry_types');
//
//		if ($entry_type_all[$entry_type_id])
//		{
//
//
//			return array(
//				'id' => $entry_type_all[$entry_type_id],
//				'label' => $entry_type_all[$entry_type_id]['label'],
//				'name' => $entry_type_all[$entry_type_id]['name'],
//				'numbering' => $entry_type_all[$entry_type_id]['numbering'],
//				'prefix' => $entry_type_all[$entry_type_id]['prefix'],
//				'suffix' => $entry_type_all[$entry_type_id]['suffix'],
//				'zero_padding' => $entry_type_all[$entry_type_id]['zero_padding'],
//				'bank_cash_ledger_restriction' => $entry_type_all[$entry_type_id]['bank_cash_ledger_restriction'],
//			);
//		} else {
//			return array(
//				'id' => $entry_type_all[$entry_type_id],
//				'label' => '',
//				'name' => '(Unkonwn)',
//				'numbering' => 1,
//				'prefix' => '',
//				'suffix' => '',
//				'zero_padding' => 0,
//				'bank_cash_ledger_restriction' => 5,
//			);
//		}


		//********** New
		$CI =& get_instance();
		$CI->load->model('custom_model');
		$entry_type_all = $CI->custom_model->get_entry_name($entry_type_id);

		if ($entry_type_all)
		{
			return array(
				'id' => $entry_type_all->id,
				'label' => $entry_type_all->label,
				'name' => $entry_type_all->name,
				'numbering' => $entry_type_all->numbering,
				'prefix' => $entry_type_all->prefix,
				'suffix' => $entry_type_all->suffix,
				'zero_padding' => $entry_type_all->zero_padding,
				'bank_cash_ledger_restriction' => $entry_type_all->bank_cash_ledger_restriction,
			);
		} else {
			return array(
				'id' => '',
				'label' => '',
				'name' => '(Unkonwn)',
				'numbering' => 1,
				'prefix' => '',
				'suffix' => '',
				'zero_padding' => 0,
				'bank_cash_ledger_restriction' => 5,
			);
		}
	}
}

/**
 * Return Entry Type Id from Entry Type Name
 *
 * @access	public
 * @param	string entry type name
 * @return	int entry type id
 */
if ( ! function_exists('entry_type_name_to_id'))
{
	function entry_type_name_to_id($entry_type_name)
	{
		$CI =& get_instance();
		$CI->load->model('custom_model');
		//$this->load->model('custom_model');
		$id = $CI->custom_model->get_entry_id($entry_type_name);

		return $id;


//		$entry_type_all = $CI->config->item('account_ac_entry_types');
//		foreach ($entry_type_all as $id => $row)
//		{
//			if ($row['label'] == $entry_type_name)
//			{
//				return $id;
//				break;
//			}
//		}
//		return FALSE;
	}
}
/**
 * Converts Entry number to proper entry prefix formats
 *
 * @access	public
 * @param	int entry type id
 * @return	string
 */
if ( ! function_exists('full_entry_number'))
{
	function full_entry_number($entry_type_id, $entry_number)
	{
		$CI =& get_instance();
		$entry_type_all = $CI->config->item('account_ac_entry_types');
		$return_html = "";
		if ( ! $entry_type_all[$entry_type_id])
		{
			$return_html = $entry_number;
		} else {
			$return_html = $entry_type_all[$entry_type_id]['prefix'] . str_pad($entry_number, $entry_type_all[$entry_type_id]['zero_padding'], '0', STR_PAD_LEFT) . $entry_type_all[$entry_type_id]['suffix'];
		}
		if ($return_html)
			return $return_html;
		else
			return " ";
	}
}
if ( ! function_exists('new_ac_reference_code'))
{
	function new_ac_reference_code($ref_id)
	{
		$CI =& get_instance();
		$CI->load->model('ac_projects_model');
		$new_type = $CI->ac_projects_model->new_refcode($ref_id);

			return $new_type;
	}
}
if ( ! function_exists('check_is_issue'))
{
	function check_is_issue($id,$type)
	{
		$CI =& get_instance();
		$CI->load->model('Inventory_model');
		$new_type = $CI->Inventory_model->cheque_issue($id,$type);

			return $new_type;
	}
}

/**
 * Floating Point Operations
 *
 * Multiply the float by 100, convert it to integer,
 * Perform the integer operation and then divide the result
 * by 100 and return the result
 *
 * @access	public
 * @param	float	number 1
 * @param	float	number 2
 * @param	string	operation to be performed
 * @return	float	result of the operation
 */
if ( ! function_exists('float_ops'))
{
	function float_ops($param1 = 0, $param2 = 0, $op = '')
	{
		$result = 0;
		$param1 = (float)$param1 * 100;
		$param2 = (float)$param2 * 100;
		$param1 = (float)round($param1, 0);
		$param2 = (float)round($param2, 0);
		switch ($op)
		{
		case '+':
			$result = $param1 + $param2;
			break;
		case '-':
			$result = $param1 - $param2;
			break;
		case '==':
			if ($param1 == $param2)
				return TRUE;
			else
				return FALSE;
			break;
		case '!=':
			if ($param1 != $param2)
				return TRUE;
			else
				return FALSE;
			break;
		case '<':
			if ($param1 < $param2)
				return TRUE;
			else
				return FALSE;
			break;
		case '>':
			if ($param1 > $param2)
				return TRUE;
			else
				return FALSE;
			break;

		}
		$result = $result/100;
		return $result;
	}

	if ( ! function_exists('get_voucher_no'))
	  {
		  function get_voucher_no($entry_id)
		  {
			  $CI =& get_instance();
			  $CI->load->model('reconciliation_model');
			  $voucher_no = $CI->reconciliation_model->getVoucherbyentryID($entry_id);

			  return $voucher_no;
		  }
	  }
}
if ( ! function_exists('getbank_details'))
{

	  function getbank_details($bank_code)

	  {

		  $CI =& get_instance();

		  $CI->load->model('common_model');

		  $bank_code = $CI->common_model->getbank_details($bank_code);



		  return $bank_code;

	  }

}

if ( ! function_exists('ledger_deletable'))
{
	function ledger_deletable($id)
	{
		$CI =& get_instance();
		$CI->load->model('Ledger_model');
		$checked = $CI->Ledger_model->ledger_deletable($id);
		return $checked;
	}
}

if ( ! function_exists('get_branchcode_by_empid'))
{
	function get_branchcode_by_empid($id)
	{
		$CI =& get_instance();
		$CI->load->model('hr/employee_model');
		$branch_code = $CI->employee_model->get_branchcode_by_empid($id);
		return $branch_code;
	}
}

if ( ! function_exists('calculate_netprofit'))
{
	function calculate_netprofit($stdate,$enddate)
	{
		$CI =& get_instance();
		$CI->load->model('Ledger_model');
		$CI->load->library('Accountlistpnlbs');

		//Net Income (Group 19)
		$net_income_total = '';
		$net_income = new Accountlistpnlbs();
		$net_income->init(19,$stdate,$enddate);
		$net_income_total = float_ops($net_income_total, $net_income->total, '+');

		//Cost of Goods Sold (Group 21)
		$cost_of_goods_total = '';
		$cost_of_goods = new Accountlistpnlbs();
		$cost_of_goods->init(21,$stdate,$enddate);
		$cost_of_goods_total = float_ops($cost_of_goods_total, $cost_of_goods->total, '-');

		$gross_income = $net_income_total - $cost_of_goods_total;

		//Other Income (Group 20)
		$other_income_total = '';
		$other_income = new Accountlistpnlbs();
		$other_income->init(20,$stdate,$enddate);
		$other_income_total = float_ops($other_income_total, $other_income->total, '+');

		//Other Income + Gross Income
		$gross_profit = $gross_income + $other_income_total;

		//Administrative Expenses (Group 23)
		$admin_expenses_total = '';
		$admin_expenses = new Accountlistpnlbs();
		$admin_expenses->init(23,$stdate,$enddate);
		$admin_expenses_total = float_ops($admin_expenses_total, $admin_expenses->total, '-');

		//Staff Expenses (Group 41)
		$staff_expenses_total = '';
		$staff_expenses = new Accountlistpnlbs();
		$staff_expenses->init(41,$stdate,$enddate);
		$staff_expenses_total = float_ops($staff_expenses_total, $staff_expenses->total, '-');

		//Admin & staff expenses
		$adminstaff_expenses = $admin_expenses_total+$staff_expenses_total;

		//Selling & Distribution Expenses (Group 24)
		$selling_expenses_total = '';
		$selling_expenses = new Accountlistpnlbs();
		$selling_expenses->init(24,$stdate,$enddate);
		$selling_expenses_total = float_ops($selling_expenses_total, $selling_expenses->total, '-');

		//other expenses
		$other_expenses = $adminstaff_expenses+$selling_expenses_total;

		 //Other Expenses (Group 27)
		//$other_expenses_total = '';
		//$ot_expenses = new Accountlistpnlbs();
		//$ot_expenses->init(27,$stdate,$enddate);
		//$other_expenses_total = float_ops($other_expenses_total, $ot_expenses->total, '-');

		//other expenses
		//$other_expenses = $other_expenses+$other_expenses_total;

		$netprofit_beforedep = $gross_profit - $other_expenses;

		//Depreciations (Group 40)
		$depreciations_total = '';
		$depreciations = new Accountlistpnlbs();
		$depreciations->init(40,$stdate,$enddate);
		$depreciations_total = float_ops($depreciations_total, $depreciations->total, '-');

		//net profit from operations
		$net_profit_operations = $netprofit_beforedep-$depreciations_total;

		//Financial Expenses (Group 26)
		$financial_expenses_total = '';
		$financial_expenses = new Accountlistpnlbs();
		$financial_expenses->init(26,$stdate,$enddate);
		$financial_expenses_total = float_ops($financial_expenses_total, $financial_expenses->total, '-');

		//net profit before tax
		$netprifit_before = $net_profit_operations-$financial_expenses_total;

		//tax Expenses (Group 42)
		$tax_expenses_total = '';
		$tax_expenses = new Accountlistpnlbs();
		$tax_expenses->init(27,$stdate,$enddate);
		$tax_expenses_total = float_ops($tax_expenses_total, $tax_expenses->total, '-');

		//net profit before tax
		$netprifit_after = $netprifit_before-$tax_expenses_total;

		return $netprifit_after;
	}
}
if ( ! function_exists('get_voucher_ncode'))
{
	function get_voucher_ncode($entryid)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$branch_code = $CI->common_model->get_voucher_ncode($entryid);
		return $branch_code;
	}
}
if ( ! function_exists('get_current_period'))
{
	function get_current_period()
	{
		$CI =& get_instance();
		$CI->load->model('monthend_model');
		$branch_code = $CI->monthend_model->get_current_period();
		return $branch_code;
	}
}

//Ticket 2735 by Eranga
if ( ! function_exists('get_voucher_by_entry'))
{
	function get_voucher_by_entry($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$project_name = $CI->common_model->get_voucher_by_entry($entry_id);
		return projectname_by_voucherid($project_name);
	}
}
//added by udani pettycash settlment module Ticket 2761
if ( ! function_exists('get_dr_account_name'))
{
	function get_dr_account_name($entry_id)
	{
		$CI =& get_instance();
		$CI->load->model('settlement_model');
		$ledgername = $CI->settlement_model->get_dr_account_name($entry_id);
		return $ledgername;
	}
}
if ( ! function_exists('get_ledger_name'))
{
	function get_ledger_name($ledgerid)
	{
		$CI =& get_instance();
		$CI->load->model('pettycashpayments_model');
		$ledgername = $CI->pettycashpayments_model->get_ledger_name($ledgerid);
		return $ledgername;
	}
}
if ( ! function_exists('get_advance_data_reciept'))
{
	function get_advance_data_reciept($entryid)
	{
		$CI =& get_instance();
		$CI->load->model('pettycashpayments_model');
		$ledgername = $CI->pettycashpayments_model->get_advance_data_reciept($entryid);
		return $ledgername;
	}
}
/*Ticket No:2889 Added By Madushan 2021.06.18*/
if ( ! function_exists('check_loan_created'))
{
	function check_loan_created($lot_id)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$result = $CI->common_model->check_loan_created($lot_id);
		return $result;
	}
}

/*Ticket No:2975 Added By Madushan 2021.06.28*/
if ( ! function_exists('charges_paid'))
{
	function charges_paid($res_code)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$result = $CI->common_model->check_chargers_paid($res_code);
		return $result;
	}
}

//Ticket No:3153 Added By Madushan 2021-07-21
if ( ! function_exists('get_emp_details'))
{
	function get_emp_details($emp_id)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$result = $CI->common_model->get_emp_details($emp_id);
		return $result;
	}
}

//Ticket No:3269 Added By Madushan 2021-08-07
if ( ! function_exists('check_loan_payment_date_period'))
{
	function check_loan_payment_date_period($loan_code,$startdate,$enddate)
	{
		$CI =& get_instance();
		$CI->load->model('common_model');
		$result = $CI->common_model->check_loan_payment_date_period($loan_code,$startdate,$enddate);
		return $result;
	}
}

//Ticket No:3291 Added By Madushan 2021-08-15
if ( ! function_exists('check_blockout'))
{
	function check_blockout($prj_id)
	{
		$CI =& get_instance();
		$CI->load->model('lotdata_model');
		$result = $CI->lotdata_model->check_available_blocks($prj_id);
		return $result;
	}
}

//Ticket No:3375 Added By Madushan 2021-09-01
if ( ! function_exists('first_renatl_due_date'))
{
	function first_renatl_due_date($loan_code)
	{
		$CI =& get_instance();
		$CI->load->model('eploan_model');
		$result = $CI->eploan_model->first_renatl_due_date($loan_code);
		return $result;
	}
}
