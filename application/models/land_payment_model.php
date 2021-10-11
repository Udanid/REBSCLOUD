<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//Ticket No:2385
class Land_payment_model extends CI_Model {

	function getlanddetails() 
	{	
		$this->db->select('property_name');
		$this->db->select('re_landms.land_code');
		//$this->db->where('budgut_status','CONFIRMED');
		$this->db->from('re_landms');
		$this->db->where('re_projectms.budgut_status','CONFIRMED');
		//$this->db->where('re_projectms.budgut_status','CONFIRMED');
		$this->db->join('re_projectms','re_projectms.land_code = re_landms.land_code');
		return $this->db->get()->result_array();
		
	}

	function getspecificland($land_code)
	{	
		$this->db->select('new_budget');
		$this->db->select('tot_payments');
		$this->db->from('re_prjacpaymentms');
		$this->db->where('re_projectms.land_code',$land_code);
		$this->db->where('re_prjacpaymentms.task_id',1);
		$this->db->join('re_projectms','re_projectms.prj_id = re_prjacpaymentms.prj_id');
		return $this->db->get()->result_array();
	}

	function addagreement($formArray)
	{
		$this->db->insert('re_landpaymentplan',$formArray);
		$insertId = $this->db->insert_id();
  		return  $insertId;
	}

	function addinstallements($formArray)
	{
		$this->db->insert('re_landinstallmentplan',$formArray);
		
	}

	function getagreementdetails()
	{
		$this->db->select('*');
		$this->db->from('re_landpaymentplan');
		return $this->db->get()->result_array();
	}


	function confirm($agreement_id,$formArray)
	{	
		$this->db->set($formArray);
		$this->db->where('agreement_id',$agreement_id);
		$this->db->update('re_landpaymentplan');
	}

	function delete($agreement_id)
	{	
	  if($agreement_id)
	  {
		$this->db->where('agreement_id',$agreement_id);
		$this->db->delete('re_landpaymentplan');
		
		$this->db->where('agreement_id',$agreement_id);
		$this->db->delete('re_landinstallmentplan');
	  }
		
	}

	function installementview($agreement_id)
	{
		$this->db->select('*');
		$this->db->from('re_landinstallmentplan');
		$this->db->where('agreement_id',$agreement_id);
		return $this->db->get()->result_array();

	}

	function update($formArray,$id)
	{
		$this->db->set($formArray);
		$this->db->where('installment_id',$id);
		$this->db->update('re_landinstallmentplan');
	}

	function getlandcode($agreement_id)
	{
		$this->db->select('land_id');
		$this->db->where('agreement_id',$agreement_id);
		$this->db->from('re_landpaymentplan');
		return $this->db->get()->row_array();
	}

	// function getlandprice($land_code)
	// {
	// 	$this->db->select('new_budget');
	// 	$this->db->select('tot_payments');
	// 	$this->db->from('re_prjacpaymentms');
	// 	$this->db->where('re_projectms.land_code',$land_code);
	// 	$this->db->where('re_prjacpaymentms.task_id',1);
	// 	$this->db->join('re_projectms','re_projectms.prj_id = re_prjacpaymentms.prj_id');
	// 	return $this->db->get()->result_array();
	// }

	function search($formArray)
	{
		$this->db->select('*');
		$this->db->from('re_landpaymentplan');
		if($formArray['land_id'] != '')
		{
			$this->db->where('land_id',$formArray['land_id']);
		}
		if($formArray['agreement_no'] != '')
		{
			$this->db->where('agreement_no',$formArray['agreement_no']);
		}
		if($formArray['agreement_date'] != '')
		{
			$this->db->where('agreement_date',$formArray['agreement_date']);
		}
		return $this->db->get()->result_array();
	}
 	
 	function getallinstallments()
 	{
 		$this->db->select('*');
 		$this->db->from('re_landinstallmentplan');
 		return $this->db->get()->result_array();
 	}

 	function getspecificagreement($agreement_id)
 	{
 		$this->db->select('land_id');
 		$this->db->from('re_landpaymentplan');
 		$this->db->where('agreement_id',$agreement_id);
 		return $this->db->get()->row_array();
 	}

 	function getbranchcode($landcode)
 	{
 		$this->db->select('branch_code');
 		$this->db->where('land_code',$landcode);
 		$this->db->from('re_landms');
 		return $this->db->get()->row_array();
 	}

 	function insertnotification($formArray)
 	{
 		$this->db->insert('cm_notification',$formArray);
 		
 	}

 	function check($land_code)
 	{
 		$this->db->select('*');
 		$this->db->from('re_landpaymentplan');
 		$this->db->where('land_id',$land_code);
 		$this->db->get();
 		if ($this->db->affected_rows() > 0)
		  return TRUE;
		else
		  return FALSE;
 	}


}
?>