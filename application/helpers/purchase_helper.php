<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Ticket No-2861 | Added By Uvini 

if ( ! function_exists('cal_po_balance'))
{
	function cal_po_balance($purchase_id,$po_amount)
	{		
		
		$CI =& get_instance();
		$CI->load->model('invoice_model');
		$tot = $CI->invoice_model->get_po_payment($purchase_id);
		$balance = floatval($po_amount) - floatval($tot);
		return $balance;
	}
}
