<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Housing_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->model("accountinterface_model");
    }
	
	function get_all_housing($pagination_counter, $page_count,$branchid) {
		$this->db->select('re_hmaclot_floordata.*,re_projectms.project_name,re_prjaclotdata.lot_number,re_hmacpaymentms.estimate_budget,hm_config_designtype.design_name,re_hmacpaymentms.selling_price,re_hmacpaymentms.status,re_hmacpaymentms.id as pid');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->join('re_projectms','re_projectms.prj_id=re_hmaclot_floordata.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_hmaclot_floordata.lot_id');
		$this->db->join('re_hmacpaymentms','re_hmacpaymentms.lot_id=re_hmaclot_floordata.lot_id');
		$this->db->join('hm_config_designtype','hm_config_designtype.design_id=re_hmaclot_floordata.design_id');
		$this->db->order_by('re_hmaclot_floordata.id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_hmaclot_floordata'); 
		return $query->result(); 
    }
	
	function get_all_designs(){
		$this->db->select('*');
		$query = $this->db->get('hm_config_designtype'); 
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
		
	}
	
	function get_all_tasks(){
		$this->db->select('*');
		$this->db->where('task_type','BOQ');
		$query = $this->db->get('hm_config_task'); 
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function update_housing(){
		$lot_id = $this->input->post('lot_id');
		$design_id = $this->input->post('design_id');
		$amount = $this->input->post('amount');
		$selling = $this->input->post('selling');
		$task_id = $this->input->post('task');	
		
		$this->db->trans_begin();
		
		$this->db->select('*');
		$this->db->where('lot_id',$lot_id);
		$query = $this->db->get('re_hmacpaymentms'); 
		if($query->num_rows() > 0){
			//adjust cost
			if($query->row()->status == 'CONFIRMED'){
				$old_cost = $query->row()->estimate_budget;
				
				$this->db->select('re_prjaclotdata.lot_number,re_projectms.project_name,re_prjaclotdata.lot_id,re_prjaclotdata.prj_id');
				$this->db->join('re_projectms','re_projectms.prj_id = re_prjaclotdata.prj_id');
				$this->db->where('lot_id',$lot_id);
				$query = $this->db->get('re_prjaclotdata'); 
				if($query->num_rows() > 0){
					$prj_data = $query->row();
				}else{
					return false;	
				}
				
				if($old_cost > $amount){
					
					$balance_cost = $old_cost - $amount;
						
					$ledgerset=$this->accountinterface_model->get_account_set('Cost Confirmation Hm');
					$crlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$crlist[0]['amount']=$crtot=$balance_cost;
					$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$drlist[0]['amount']=$drtot=$balance_cost;
					$narration = $prj_data->project_name. ' ' .$prj_data->lot_number.' Housing Cost Adjustments ';
					$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$prj_data->prj_id,$prj_data->lot_id,'');
					
				}else if($amount > $old_cost){
					
					$balance_cost = $amount - $old_cost;
						
					$ledgerset=$this->accountinterface_model->get_account_set('Cost Confirmation Hm');
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$balance_cost;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$balance_cost;
					$narration = $prj_data->project_name. ' ' .$prj_data->lot_number.' Housing Cost Adjustments ';
					$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$prj_data->prj_id,$prj_data->lot_id,'');
				}
				
				$data = array(
							'housing_cost' => $amount,
							'housing_sale' => $selling,
							'design_id' => $design_id,
						);
				$this->db->where('lot_id',$lot_id);
				$this->db->update('re_prjaclotdata',$data);
			}
			/*End cost adjustment*/
			
			$data = array(
				'estimate_budget' => $amount,
				'new_budget' => $amount,
				'selling_price' => $selling,
			);
			$this->db->where('lot_id',$lot_id);
			$this->db->where('task_id',$task_id);
			$this->db->update('re_hmacpaymentms',$data);
			
			$data = array(
				'design_id' 	=> $design_id
			);
			$this->db->where('lot_id',$lot_id);
			$this->db->update('re_hmaclot_floordata',$data);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return $lot_id;
			}
		}else{
			return false;	
		}
		
	}
	
	function add_housing(){
		$prj_id = $this->input->post('project');
		$lot_id = $this->input->post('lot_id');
		$design_id = $this->input->post('design_id');
		$amount = $this->input->post('amount');
		$selling = $this->input->post('selling');
		$task_id = $this->input->post('task');
		
		$this->db->select('*');
		$this->db->where('lot_id',$lot_id);
		$query = $this->db->get('re_hmacpaymentms'); 
		if($query->num_rows() > 0){
			return false;
		}
		
		
		$this->db->trans_begin();
		
		$data = array(
			'lot_id' => $lot_id,
			'task_id' => $task_id,
			'estimate_budget' => $amount,
			'new_budget' => $amount,
			'selling_price' => $selling,
		);
		$this->db->insert('re_hmacpaymentms',$data);
		$insert_id = $this->db->insert_id();
		$data = array(
			'prj_id'	 	=> $prj_id,
			'lot_id' 		=> $lot_id,
			'design_id' 	=> $design_id
		);
		$this->db->insert('re_hmaclot_floordata',$data);
		
		$data = array(
			'prj_id'	 	=> $prj_id,
			'lot_id' 		=> $lot_id,
		);
		$this->db->insert('re_hmac_floorrooms',$data);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return $lot_id;
		}
	}
	
	function get_all_blocks($project_id){
		/*$list = array();
		$this->db->select('lot_id');
		$query = $this->db->get('re_hmacpaymentms');
		if($query->num_rows() > 0){
			foreach($query->result() as $data){
				array_push($list,$data->lot_id);
			}
		} */
		$this->db->select('re_prjaclotdata.*,re_prjacblockplane.plan_no');
		$this->db->where('re_prjaclotdata.prj_id',$project_id);
		$this->db->join('re_prjacblockplane','re_prjacblockplane.prj_id=re_prjaclotdata.prj_id and  re_prjacblockplane.plan_sq=re_prjaclotdata.plan_sqid');
		/*if($list)
		$this->db->where_not_in('re_prjaclotdata.lot_id',$list);*/
		$this->db->where('re_prjaclotdata.status','PENDING');
		$this->db->order_by('CAST(re_prjaclotdata.lot_number AS SIGNED INTEGER)');
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    
	}
	
	function delete_housing($lot_id){
		$this->db->where('lot_id',$lot_id);
		$this->db->delete('re_hmacpaymentms');
		if (!$this->db->affected_rows()) {
			return false;
		} else {
			$this->db->where('lot_id',$lot_id);
			$this->db->delete('re_hmac_floorrooms');
			$this->db->where('lot_id',$lot_id);
			$this->db->delete('re_hmaclot_floordata');
			return true;
		}	
	}
	
	function get_housing_by_lotid($lot_id){
		$this->db->select('re_hmacpaymentms.*,re_hmaclot_floordata.design_id');
		$this->db->join('re_hmaclot_floordata','re_hmaclot_floordata.lot_id = re_hmacpaymentms.lot_id');
		$this->db->where('re_hmacpaymentms.lot_id',$lot_id);
		$query = $this->db->get('re_hmacpaymentms'); 
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	function confirm_housing($lot_id){
		$data = array('status' => 'CONFIRMED');
		$this->db->where('lot_id',$lot_id);
		$this->db->update('re_hmacpaymentms',$data);
		if (!$this->db->affected_rows()) {
			return false;
		} else {
			$housing = $this->get_housing_by_lotid($lot_id);
			$data = array(
						'lot_type' => 'H',
						'housing_cost' => $housing->estimate_budget,
						'housing_sale' => $housing->selling_price,
						'design_id' => $housing->design_id,
					);
			$this->db->where('lot_id',$lot_id);
			$this->db->update('re_prjaclotdata',$data);
			
			$this->db->select('re_prjaclotdata.lot_number,re_projectms.project_name,re_prjaclotdata.lot_id,re_prjaclotdata.prj_id');
			$this->db->join('re_projectms','re_projectms.prj_id = re_prjaclotdata.prj_id');
			$this->db->where('re_prjaclotdata.lot_id',$lot_id);
			$query = $this->db->get('re_prjaclotdata'); 
			if($query->num_rows() > 0){
				$prj_data = $query->row();
			}else{
				return false;	
			}
			
			//add cost to ledgers
			$ledgerset=$this->accountinterface_model->get_account_set('Cost Confirmation Hm');
			$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
			$crlist[0]['amount']=$crtot=$housing->estimate_budget;
			$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
			$drlist[0]['amount']=$drtot=$housing->estimate_budget;
			$narration = $prj_data->project_name. ' ' .$prj_data->lot_number.' Housing Cost Confirmation ';
			$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$prj_data->prj_id,$prj_data->lot_id);
			return true;
		}
	}
	
	function get_current_design($lot_id){
		$this->db->select('re_hmacpaymentms.*,re_hmaclot_floordata.design_id');
		$this->db->join('re_hmaclot_floordata','re_hmaclot_floordata.lot_id = re_hmacpaymentms.lot_id');
		$this->db->where('re_hmacpaymentms.lot_id',$lot_id);
		$query = $this->db->get('re_hmacpaymentms'); 
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;	
		}
	}
	
	//Ticket 2733 by Eranga
	function get_all_blocks_reserved($project_id){
		/*$list = array();
		$this->db->select('lot_id');
		$query = $this->db->get('re_hmacpaymentms');
		if($query->num_rows() > 0){
			foreach($query->result() as $data){
				array_push($list,$data->lot_id);
			}
		} */
		$this->db->select('re_prjaclotdata.*,re_prjacblockplane.plan_no');
		$this->db->where('re_prjaclotdata.prj_id',$project_id);
		$this->db->join('re_prjacblockplane','re_prjacblockplane.prj_id=re_prjaclotdata.prj_id and  re_prjacblockplane.plan_sq=re_prjaclotdata.plan_sqid');
		/*if($list)
		$this->db->where_not_in('re_prjaclotdata.lot_id',$list);*/
		//$this->db->where('re_prjaclotdata.status','PENDING');
		$this->db->where('re_prjaclotdata.lot_type','H');
		$this->db->order_by('CAST(re_prjaclotdata.lot_number AS SIGNED INTEGER)');
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    
	}
	
	function get_search_housing($lot_id,$branchid) {
		$this->db->select('re_hmaclot_floordata.*,re_projectms.project_name,re_prjaclotdata.lot_number,re_hmacpaymentms.estimate_budget,hm_config_designtype.design_name,re_hmacpaymentms.selling_price,re_hmacpaymentms.status,re_hmacpaymentms.id as pid');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->join('re_projectms','re_projectms.prj_id=re_hmaclot_floordata.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_hmaclot_floordata.lot_id');
		$this->db->join('re_hmacpaymentms','re_hmacpaymentms.lot_id=re_hmaclot_floordata.lot_id');
		$this->db->join('hm_config_designtype','hm_config_designtype.design_id=re_hmaclot_floordata.design_id');
		$this->db->where('re_prjaclotdata.lot_id',$lot_id);
		$this->db->order_by('re_hmaclot_floordata.id','DESC');
		$query = $this->db->get('re_hmaclot_floordata'); 
		return $query->result(); 
    }
}