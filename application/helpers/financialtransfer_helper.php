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

if ( ! function_exists('initial_profit_transfer'))
{
	function initial_profit_transfer($res_code,$pay_id,$method,$date)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->initial_profit_transfer($res_code,$pay_id,$method,$date);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('update_unrealized_sale_on_income'))
{
	function update_unrealized_sale_on_income($income_id,$amount,$res_code,$date)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->update_unrealized_sale_on_income($income_id,$amount,$res_code,$date);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('update_unrealized_sale_on_reshedule'))
{
	function update_unrealized_sale_on_reshedule($amount,$res_code)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->update_unrealized_sale_on_reshedule($amount,$res_code);
	
			return $new_type;
	
			//return $new_type;
	}
}
if ( ! function_exists('update_unrealized_data_on_discount'))
{
	function update_unrealized_data_on_discount($res_code,$discount_recieved,$entry_id,$date,$hm_discount)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->update_unrealized_data_on_discount($res_code,$discount_recieved,$entry_id,$date,$hm_discount);
	
			return $new_type;
	
			
	}
}
if ( ! function_exists('advance_resale_transfers'))
{
	function advance_resale_transfers($resale_code)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->advance_resale_transfers($resale_code);
	
			return $new_type;
	
	}
}
if ( ! function_exists('early_settlement_entries'))
{
	function  early_settlement_entries($id,$loan_code,$res_code,$date)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->early_settlement_entries($id,$loan_code,$res_code,$date);
	
			return $new_type;
	
	}
}
if ( ! function_exists('delete_futrecapital_and_int_transfers_on_settlment'))
{
	function  delete_futrecapital_and_int_transfers_on_settlment($id,$loan_code)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->delete_futrecapital_and_int_transfers_on_settlment($id,$loan_code);
	
			return $new_type;
	
	}
}

if ( ! function_exists('loan_resale_transfers'))
{
	function  loan_resale_transfers($rsch_code)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->loan_resale_transfers($rsch_code);
	
			return $new_type;
	
	}
}

if ( ! function_exists('reschedule_account_transfers'))
{
	function  reschedule_account_transfers($rsch_code)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->reschedule_account_transfers($rsch_code);
	
			return $new_type;
	
	}
}

if ( ! function_exists('capital_and_interest_transfer_onduedate'))
{
	function  capital_and_interest_transfer_onduedate($deutate)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->capital_and_interest_transfer_onduedate($deutate);
	
			return $new_type;
	
	}
}
if ( ! function_exists('capital_and_interest_transfer_on_reschudyle'))
{
	function  capital_and_interest_transfer_on_reschudyle($date,$res_code)
	{
		$CI =& get_instance();
		$CI->load->model('financialtransfer_model');
		$new_type = $CI->financialtransfer_model->capital_and_interest_transfer_on_reschudyle($date,$res_code);
	
			return $new_type;
	
	}
}
