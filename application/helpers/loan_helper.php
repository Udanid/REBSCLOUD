<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('cal_tot_amount'))
{
	function cal_tot_amount($res_code,$date)
	{	
		$total_amount = 0;
		$CI =& get_instance();
		$CI->load->model("loan_model");
	 	$data = $CI->loan_model->total_capital_amount($res_code,$date);
	 	if($data)
	 	{
	 		foreach($data as $row)
	 		{
	 		$total_amount += floatval($row->cap_amount);
	 		$down_payment = $row->down_payment;
	 		}

	 	 	return ($total_amount + floatval($down_payment));
	 	}
	 	else
	 	{
	 		$data = $CI->common_model->get_advancepayment_as_at_date($res_code,$date);
	 		if($data)
	 		{
	 		foreach($data as $row)
	 		{
	 		$total_amount += floatval($row->pay_amount);
	 		}

	 	 	return $total_amount;
	 	 	}
	 	}
	 	
	 }
	
}

//Ticket No-2683 |Added By Uvini 
if ( ! function_exists('cal_tot_cap_amount'))
{
	function cal_tot_cap_amount($loan_code)
	{	
		$total_amount = 0;
		$CI =& get_instance();
		$CI->load->model("loan_model");
	 	$data = $CI->loan_model->cal_total_capital_amount($loan_code);
	 	if($data)
	 	{
	 		foreach($data as $row)
	 		{
	 		$total_amount += floatval($row->cap_amount);
	 		}

	 	}
	 	return ($total_amount);
	 }
	
}