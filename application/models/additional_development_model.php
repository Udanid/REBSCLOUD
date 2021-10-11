<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Additional_development_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_all_housing_reservation_summery($branchid) { //get all stock
	$status = array('PROCESSING', 'COMPLETE','SETTLED');
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_prjaclotdata.lot_type','H');
		$this->db->where_in('re_resevation.res_status',$status);
		$query = $this->db->get('re_resevation');
	
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	
	function get_additional_develpment_list($branchid) { //get all stock
		$this->db->select('re_hm_addtionaldp.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_hm_addtionaldp.res_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
				$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
	
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_hm_addtionaldp');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_additional_develpment_On_payment($userid) { //get all stock
		$this->db->select('re_hm_addtionaldp.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_hm_addtionaldp.res_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
				$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
	
		$this->db->order_by('re_projectms.prj_id');
			$this->db->group_by('re_hm_addtionaldp.res_code');
		$query = $this->db->get('re_hm_addtionaldp');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_reservation_data($res_code) { //get all stock
		$this->db->select('re_resevation.*');
		$this->db->where('re_resevation.res_code',$res_code);
		$query = $this->db->get('re_resevation');
	
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	
	function add_development()
	{
		$res_code=$this->input->post('res_code');
		$resdata=$this->get_reservation_data($res_code);
		
			$insert_data = array(
				'res_code' =>  $resdata->res_code,
				'prj_id' =>$resdata->prj_id,
				'lot_id' =>$resdata->lot_id,
			
				'description' =>$this->input->post('description'),
				'cost' =>$this->input->post('cost'),
				'sale_value' =>$this->input->post('sale_value'),
				'create_date' => date('Y-m-d'),
					'create_by' => $this->session->userdata('userid'),
				'status' => 'PENDING',
			);
			if ( ! $this->db->insert('re_hm_addtionaldp', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}
			return $entry_id;
	}
	
	function delete_development($code) { //get all stock
		if($code)
		{
		$this->db->where('id',$code);
			$query = $this->db->delete('re_hm_addtionaldp');
		}
		return $code ;
    }
	function get_development_data($id) { //get all stock
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('re_hm_addtionaldp');
	
		if ($query->num_rows() > 0){
			return $query->row();
		
		}
		else
		return false;
    }
	function get_task_data_addtional_dp() { //get all stock
		$this->db->select('*');
		$this->db->where('task_name','Additional Development');
		$this->db->where('task_type','SYSTEM');
		$query = $this->db->get('hm_config_task');
	
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function confirm_development($code) { //get all stock
		$dpdata=$this->get_development_data($code);
		$task_data=$this->get_task_data_addtional_dp();
	
		$this->db->where('lot_id',$dpdata->lot_id);
		$this->db->where('task_id',$task_data->task_id);
		$query = $this->db->get('re_hmacpaymentms');
		
		if ($query->num_rows() > 0)
		{
			$data =$query->row();
			$new_budget=$data->estimate_budget+$dpdata->cost;
			$new_selling_price=$data->selling_price+$dpdata->sale_value;
			$dataset=array('estimate_budget'=>$new_budget,
			'new_budget'=>$new_budget,
			'selling_price'=>$new_selling_price);
			$this->db->where('lot_id',$dpdata->lot_id);
	 		$this->db->update('re_hmacpaymentms',$dataset);
		}
		else
		{
			$new_budget=$dpdata->cost;
			$dataset=array('estimate_budget'=>$new_budget,
			'new_budget'=>$new_budget,
			'lot_id'=>$dpdata->lot_id,
			'task_id'=>$task_data->task_id,
			'selling_price'=>$dpdata->sale_value,
			'status'=>'CONFIRMED');
			$this->db->insert('re_hmacpaymentms',$dataset);
			
		}
		
		
		
		
		$data=array(
			'status' => 'CONFIRMED',
			'confirm_date' => date('Y-m-d'),
			'condfirm_by' => $this->session->userdata('userid'),

		);
		$this->db->where('id', $code);
		$insert = $this->db->update('re_hm_addtionaldp', $data);
		return $code;
    }
	function get_development_data_by_res_code($res_code) { //get all stock
		$this->db->select('re_hm_addtionaldp.*,cm_customerms.cus_code,re_resevation.branch_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_hm_addtionaldp.res_code');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->where('re_hm_addtionaldp.res_code',$res_code);
		$query = $this->db->get('re_hm_addtionaldp');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
function get_development_payment_by_res_code($res_code)
	{

		$this->db->select('re_hm_addtionaldp_income.*,re_prjacincome.pay_status as status,re_prjacincome.rct_no,re_hm_addtionaldp.description');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_hm_addtionaldp_income.rct_id');
				$this->db->join('re_hm_addtionaldp','re_hm_addtionaldp.id=re_hm_addtionaldp_income.addition_id');

		$this->db->where('re_hm_addtionaldp.res_code',$res_code);
		$query = $this->db->get('re_hm_addtionaldp_income');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}
	function get_paid_amount_code($id)
	{

		$this->db->select('SUM(amount) as totpay');
		
		$this->db->where('re_hm_addtionaldp_income.addition_id',$id);
		$query = $this->db->get('re_hm_addtionaldp_income');
		 if ($query->num_rows >0) {
            $data= $query->row();
			return $data->totpay;
        }
		else
		return false;
	}
	
		function add_development_payments()
	{
		$res_code=$this->input->post('res_code');
		
	 		$paymentlist=$this->get_development_data_by_res_code($res_code);
			$totpay=0;
			if($paymentlist)
			{
				
				foreach ($paymentlist as $raw)
				{
					$prj_id=$raw->prj_id;
					$lot_id=$raw->lot_id;
					$cus_code=$raw->cus_code;
					$branch_code=$raw->branch_code;
					$payamunt=$this->input->post('pay_amount_val'.$raw->id);
					if($payamunt>0)
					$totpay=$totpay+$payamunt;
				}
				if($totpay >0)
				{
					
						$insert_data = array(
						'temp_code' =>  $res_code,
						'res_code' =>  $res_code,
						'pri_id' =>$prj_id,
						'cus_code' =>$cus_code,
						'lot_id' =>$lot_id,
						'branch_code' => $branch_code,
						'income_type' =>'Additional Development - Housing',
						'amount' => $totpay,
						'income_date' =>$this->input->post('pay_date'),
					);
					if ( ! $this->db->insert('re_prjacincome', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
		
						return;
					} else {
						$entry_id = $this->db->insert_id();
					}
					
					$ledgerset=get_account_set('Construction Additions');
				 $advanceCr=$ledgerset['Cr_account'];
				  $ledgerset=get_account_set('Advanced Payment');
				 $advanceDr=$ledgerset['Dr_account'];
				 
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>$totpay,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
	
					return;
					}
					$insert_data = array(
						'income_id' => $entry_id,
						'ledger_id' =>$advanceDr,
						'dc_type' => 'D',
						'amount' =>$totpay,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
	
					return;
					}
				
					
				}
				foreach ($paymentlist as $raw)
				{
					$prj_id=$raw->prj_id;
					$lot_id=$raw->lot_id;
					$cus_code=$raw->cus_code;
					$branch_code=$raw->branch_code;
					$payamunt=$this->input->post('pay_amount_val'.$raw->id);
					if($payamunt>0)
					{
						$insert_data = array(
						'addition_id' =>  $raw->id,
						'amount' =>$payamunt,
						'income_date' =>$this->input->post('pay_date'),
						'rct_id' =>$entry_id,
						'create_by' => $this->session->userdata('userid'),
						'create_date' =>date('Y-m-d'),
							);
						if ( ! $this->db->insert('re_hm_addtionaldp_income', $insert_data))
						{
							$this->db->trans_rollback();
							$this->messages->add('Error addding Entry.', 'error');
			
							return;
						}
					}
				}
				 
							
					
			}
			
		

		return $entry_id;
	}
}