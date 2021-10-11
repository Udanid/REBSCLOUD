<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ledgerbalance_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	
	function get_available_stock($todate,$prj_id)
	{
		$this->db->select('SUM(sale_val) as totsale,SUM(costof_sale) as totcost,SUM(housing_cost) as hm_totcost');
		$this->db->where('status','PENDING');
			$this->db->where('prj_id',$prj_id);
		$query = $this->db->get('re_prjaclotdata');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data;
		}
		else
		return false;
	}
	function update_project_price()
	{
		$current_budget=0;
		$this->db->select('*');
		$this->db->where('re_projectms.prj_id >',30);
		$query = $this->db->get('re_projectms');
		if ($query->num_rows() > 0){
		$data= $query->result();
				foreach($data as $raw)
				{
				$prj_id=$raw->prj_id;
						
						$get_cost=$this->tot_costofsale($prj_id);
					$insert_data = array(
						'prj_id' =>  $prj_id,
						'task_id' =>'1',
						'estimate_budget' =>$get_cost,
							'new_budget' =>$get_cost,
								'tot_payments' =>$get_cost,
					
						
					);
					if ( ! $this->db->insert('re_prjacpaymentms', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
		
						return;
					}
				}
		}
		
		
		
	}
	function tot_costofsale($prj_id)
	{
		$this->db->select('SUM(sale_val) as totsale,SUM(costof_sale) as totcost,SUM(housing_cost) as hm_totcost');
			$this->db->where('prj_id',$prj_id);
		$query = $this->db->get('re_prjaclotdata');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->totcost;
		}
		else
		return 0;
	}
	function get_advance_stock($todate,$prj_id) { //get all stock
		$this->db->select('SUM(re_prjaclotdata.costof_sale) as totcost,SUM(re_prjaclotdata.housing_cost) as hm_totcost,SUM(re_resevation.down_payment) as totsale' );
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.init_costtrn_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_status ',"PENDING");
		$this->db->where('re_resevation.init_costtrn_date <=',$todate);
			$this->db->where('re_resevation.prj_id',$prj_id);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_settled_stock($todate,$prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.re_discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) as totcost,SUM(re_prjaclotdata.housing_cost) as hm_totcost,SUM(re_resevation.hm_discounted_price) as hm_totsale' );
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.res_status ',"SETTLED");
		$this->db->where('re_resevation.prj_id',$prj_id);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }

	
		function get_NEP_reservation_data($todate,$prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.re_discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost,SUM(re_prjaclotdata.housing_cost) as hm_totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_eploan.loan_amount) as totepstock,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost,SUM(re_unrealized.hm_unrealized_sale) as hm_unsale,SUM(re_unrealized.hm_unrealized_cost) as hm_uncost,SUM(re_resevation.hm_discounted_price) as hm_totsale');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_eploan.loan_type',"NEP");
		
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function loan_paid_totals($loan_type,$date,$prj_id)
	{
		
		$this->db->select('SUM(re_eploanpayment.cap_amount) as paid_cap,SUM(re_eploanpayment.int_amount) as paid_int,SUM(re_eploanpayment.di_amount) as paid_di');
			$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
			$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
			if($date!='')
			$this->db->where('re_eploanpayment.pay_date <=',$date);
			$this->db->where('re_eploan.loan_type',$loan_type);
			$this->db->where('re_resevation.prj_id',$prj_id);
			$query = $this->db->get('re_eploanpayment');
		
		
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}
	function loan_due_totals($loan_type,$date,$prj_id)
	{
		
		$this->db->select('SUM(re_eploanshedule.cap_amount) as due_cap,SUM(re_eploanshedule.int_amount) as due_int');
			$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
			$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
			if($date!='')
			$this->db->where('re_eploanshedule.deu_date <=',$date);
			$this->db->where('re_eploan.loan_type',$loan_type);
			$this->db->where('re_resevation.prj_id',$prj_id);
			$query = $this->db->get('re_eploanshedule');
		
		
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}

	function get_EPB_reservation_data($todate,$prj_id) { //get all stock
	$this->db->select('SUM(re_resevation.re_discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost,SUM(re_prjaclotdata.housing_cost) as hm_totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_eploan.loan_amount) as totepstock,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost,SUM(re_unrealized.hm_unrealized_sale) as hm_unsale,SUM(re_unrealized.hm_unrealized_cost) as hm_uncost,SUM(re_resevation.hm_discounted_price) as hm_totsale');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_eploan.loan_type',"EPB");
		
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_ZEP_reservation_data($todate,$prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.re_discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost,SUM(re_prjaclotdata.housing_cost) as hm_totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_eploan.loan_amount) as totepstock,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost,SUM(re_unrealized.hm_unrealized_sale) as hm_unsale,SUM(re_unrealized.hm_unrealized_cost) as hm_uncost,SUM(re_resevation.hm_discounted_price) as hm_totsale');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_eploan.loan_type',"ZEP");
	
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	
	
	
	function get_dpcomplete_reservation_data($todate,$prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.re_discounted_price) as totsale,SUM(re_resevation.down_payment) as totpaid,SUM(re_prjaclotdata.costof_sale) totcost,SUM(re_prjaclotdata.housing_cost) as hm_totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost,SUM(re_unrealized.hm_unrealized_sale) as hm_unsale,SUM(re_unrealized.hm_unrealized_cost) as hm_uncost,SUM(re_resevation.hm_discounted_price) as hm_totsale');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		$this->db->where('re_resevation.prj_id',$prj_id);
		//$this->db->where('re_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	
	/*Ticket No:3049 Updated By Madushan 2021-07-07*/
	function loan_paid_totals_loancode($loancode,$date,$resqn)
	{
		
		$this->db->select('SUM(re_eploanpayment.cap_amount) as paid_cap,SUM(re_eploanpayment.int_amount) as paid_int');
			$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
			if($date!='')
			$this->db->where('re_eploanpayment.pay_date <=',$date);
			$this->db->where('re_eploan.loan_code',$loancode);
			if($resqn != '')
				$this->db->where('re_eploanpayment.reschdue_sqn',$resqn);
			$query = $this->db->get('re_eploanpayment');
		
		
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}

	/*Ticket No:3049 Updated By Madushan 2021-07-07*/
	function loan_due_totals_loancode($loancode,$date,$resqn)
	{
		
		$this->db->select('SUM(re_eploanshedule.cap_amount) as due_cap,SUM(re_eploanshedule.int_amount) as due_int');
			$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
			if($date!='')
			$this->db->where('re_eploanshedule.deu_date <=',$date);
			if($resqn != '')
				$this->db->where('re_eploanshedule.reschdue_sqn',$resqn);
			$this->db->where('re_eploan.loan_code',$loancode);
			$query = $this->db->get('re_eploanshedule');
		
		
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}
	function get_charge_payment($todate,$prj_id) { //get all stock
		$this->db->select('SUM(re_chargepayments.pay_amount) as charge_payment,chage_dis');
			$this->db->join('re_resevation','re_resevation.res_code=re_chargepayments.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->group_by('chage_dis');
		$query = $this->db->get('re_chargepayments');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_total_income($todate,$prj_id) { //get all stock
		$this->db->select('SUM(amount) as tot_amount');
		$this->db->where('re_prjacincome.pri_id',$prj_id);
		$query = $this->db->get('re_prjacincome');
		
		if ($query->num_rows() > 0){
		$data= $query->row();
	//	echo $this->db->last_query();
		return $data->tot_amount;
		
		}
		else
		return 0;
    }
	function get_task_balance($todate,$prj_id,$task_id) { //get all stock
		$this->db->select('*');
		$this->db->where('re_prjacpaymentms.prj_id',$prj_id);
		$this->db->where('re_prjacpaymentms.task_id',$task_id);
		$query = $this->db->get('re_prjacpaymentms');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_task_balance_hm($todate,$prj_id,$task_id) { //get all stock
		$this->db->select('SUM(estimate_budget) as estimate,SUM(tot_payments) as payment');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_hmacpaymentms.lot_id');
	
		$this->db->where('re_prjaclotdata.prj_id',$prj_id);
		$this->db->where('re_hmacpaymentms.task_id',$task_id);
		$query = $this->db->get('re_hmacpaymentms');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	
	function task_list() { //get all stock
		$this->db->select('*');
		$query = $this->db->get('cm_tasktype');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function task_list_hm() { //get all stock
		$this->db->select('*');
		$query = $this->db->get('hm_config_task');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function migration_entry_check() { //get all stock
		$this->db->select('*');
		$this->db->like('narration','Migration Entry','both');
		$query = $this->db->get('ac_entries');
		if ($query->num_rows() > 0){
		return false;
		}
		else
		return true;
    }
	
	function update_settlement() { //get all stock
		$this->db->select('*');
			$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$dataset= $query->result();
			foreach($dataset as $raw)
			{
				if($raw->down_payment>=$raw->discounted_price)
				{
					$insert_data=array('status'=>'SOLD');
					$this->db->where('lot_id',$raw->lot_id);
						if ( ! $this->db->update('re_prjaclotdata', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
							 $insert_data=array('profit_status'=>'TRANSFERD','profit_date'=>$raw->last_dpdate,'res_status'=>'SETTLED');
						$this->db->where('res_code',$raw->res_code);
						if ( ! $this->db->update('re_resevation', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
					
					
				}
			}
		}
		else
		return false;
    }
	
	function update_leagal_fee()
	{
		$this->db->select('*');
		$this->db->where('chage_type','leagal_fee');
			$query = $this->db->get('re_chargepayments');
			if ($query->num_rows() > 0){
			$dataset= $query->result();
				foreach($dataset as $raw)
				{
					 $insert_data=array('leagal_fee'=>$raw->pay_amount);
					 $this->db->where('res_code',$raw->res_code);
						if ( ! $this->db->update('re_charges', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
				}
			}
	}
}
