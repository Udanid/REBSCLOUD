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


if ( ! function_exists('cashbook_ledger_balance'))
{
	function cashbook_ledger_balance($ledger_id)
	{
		$CI =& get_instance();
		$CI->load->model('Ledger_model');
		$new_type = $CI->Ledger_model->ledger_balance($ledger_id);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_cashbook_balance'))
{
	function get_cashbook_balance($book_id)
	{
		$CI =& get_instance();
		$CI->load->model('cashadvance_model');
		$new_type = $CI->cashadvance_model->get_cashbook_balance($book_id);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('get_cashbook_outstanding'))
{
	function get_cashbook_outstanding($book_id)
	{
		$CI =& get_instance();
		$CI->load->model('cashadvance_model');
		$new_type = $CI->cashadvance_model->get_cashbook_outstanding($book_id);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('chaeck_pending_settlements_officer'))
{
	function chaeck_pending_settlements_officer($officer_id,$date)
	{
		$CI =& get_instance();
		$CI->load->model('cashadvance_model');
		$new_type = $CI->cashadvance_model->chaeck_pending_settlements_officer($officer_id,$date);

			return $new_type;

			//return $new_type;
	}


}

if ( ! function_exists('get_booktype_by_advanceid'))
{
	function get_booktype_by_advanceid($advance_id)
	{
		$CI =& get_instance();
		$CI->load->model('cashadvance_model');
		$new_type = $CI->cashadvance_model->get_booktype_by_advanceid($advance_id);

			return $new_type;

			//return $new_type;
	}

}
if ( ! function_exists('check_officer_unsettled_advance'))
{
	function check_officer_unsettled_advance($officer_id)
	{
		$CI =& get_instance();
		$CI->load->model('cashadvance_model');
		$new_type = $CI->cashadvance_model->check_officer_unsettled_advance($officer_id);

			return $new_type;

			//return $new_type;
	}

}

//Ticket No:3153 Added By Madushan 2021-07-21
if ( ! function_exists('get_ontimepayment_serial'))
{
	function get_ontimepayment_serial($direct_pay_id)
	{
		$CI =& get_instance();
		$CI->load->model('pettycashpayments_model');
		$serail_no = $CI->pettycashpayments_model->get_ontimepayment_serial($direct_pay_id);

			return $serail_no;

			//return $new_type;
	}

}

//Ticket No:3298 Added By Madushan 2021-08-16
if ( ! function_exists('get_officer_branch'))
{
	function get_officer_branch($id)
	{
		$CI =& get_instance();
		$CI->load->model('pettycashpayments_model');
		$branch = $CI->pettycashpayments_model->get_officer_branch($id);

			return $branch;

			//return $new_type;
	}

}

if ( ! function_exists('check_voucher_statues'))
{
	//ticket number 3318 updated by nadee 2021-08-19
	function check_voucher_statues($vou_id)
	{
		$CI =& get_instance();
		$CI->load->model('cashadvance_model');
		$new_type = $CI->cashadvance_model->check_voucher_statues($vou_id);

			return $new_type;

			//return $new_type;
	}

}
