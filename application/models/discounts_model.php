<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discounts_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_all_project_discounts(){
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_discountschedule.*');
		$this->db->join('re_projectms','re_projectms.prj_id = re_discountschedule.prj_id');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$this->session->userdata('branchid'));
		$this->db->group_by('re_discountschedule.prj_id');
		$query = $this->db->get('re_discountschedule'); 
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;
	}
	
	function get_project_discount($prj_id){
		$this->db->select('*');
		$this->db->where('re_discountschedule.prj_id',$prj_id);
		$this->db->order_by('re_discountschedule.id');
		$this->db->order_by('re_discountschedule.days');
		$this->db->order_by('re_discountschedule.payrate');
		$this->db->order_by('re_discountschedule.discount');
		$query = $this->db->get('re_discountschedule'); 
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;
	}
	
	function check_discount_schemes(){
		$this->db->select('*');
		$this->db->where('prj_id',$this->input->post('prj_id'));
		$query = $this->db->get('re_discountschedule'); 
		if ($query->num_rows() > 0){
			return true;
		}
		else
		return false;	
	}
	
	function add_discount_scheme(){
		$periods = $this->input->post('periods');	
		$levels = $this->input->post('levels');
		$project = $this->input->post('prj_id');
		$this->db->trans_start();
		for($x=1 ; $x <= $periods;$x++){
			for($y=1 ; $y <= $levels;$y++){
				$data = array(
					'days'		=> $this->input->post('period'.$x),
					'payrate'	=> $this->input->post('level'.$y),
					'discount'	=> $this->input->post('rate'.$x.$y),
					'prj_id'	=> $project,
					'created_by'	=> $this->session->userdata('username'),
				);
				$this->db->insert('re_discountschedule',$data);	  
		  	}		
		}
		$id = $this->db->insert_id();
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		} 
		else {
			$this->db->trans_commit();
			return $id;
		}
	}
	
	function update_discount_scheme($prj_id){
		if($prj_id)
		{
		$this->db->select('created_by');
		$this->db->where('prj_id',$prj_id);
		$this->db->limit(1);
		$query = $this->db->get('re_discountschedule'); 
		$created_by = $query->row()->created_by;
		
		$periods = $this->input->post('periods');	
		$levels = $this->input->post('levels');
		$project = $prj_id;
		$this->db->trans_start();
		$this->db->where('prj_id',$prj_id);
		$this->db->delete('re_discountschedule');
		for($x=1 ; $x <= $periods;$x++){
			for($y=1 ; $y <= $levels;$y++){
				$data = array(
					'days'		=> $this->input->post('period'.$x),
					'payrate'	=> $this->input->post('level'.$y),
					'discount'	=> $this->input->post('rate'.$x.$y),
					'prj_id'	=> $project,
					'created_by'	=> $created_by,
					'updated_by'	=> $this->session->userdata('username'),
				);
				$this->db->insert('re_discountschedule',$data);	  
		  	}		
		}
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		} 
		else {
			$this->db->trans_commit();
			return true;
		}
		}
		else
		return false;
	}
	
	function delete_discount_scheme($prj_id){
		if($prj_id)
		{
		$this->db->trans_start();	
		$this->db->where('prj_id',$prj_id);
		$this->db->delete('re_discountschedule');
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		} 
		else {
			$this->db->trans_commit();
			return true;
		}
		}
		else
		return false;
	}
	
	function get_all_project_confirmed() {
		
		$projects = array();
		
		$this->db->select('prj_id');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_discountschedule'); 
		if ($query->num_rows() > 0){
			foreach($query->result() as $data){
				array_push($projects,$data->prj_id);
			}
		}
		
		$this->db->select('re_projectms.project_name,re_projectms.prj_id');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$this->session->userdata('branchid'));
		$this->db->where('re_projectms.status',CONFIRMKEY);
		if($projects)
		$this->db->where_not_in('re_projectms.prj_id',$projects);
		$this->db->order_by('re_projectms.prj_id','DESC');
		$query = $this->db->get('re_projectms'); 
		return $query->result(); 
    }

    //Ticket No:2689 Added By Madushan 2021.04.20
    function get_all_project_discounts_search($prj_id) {
		
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_discountschedule.*');
		$this->db->join('re_projectms','re_projectms.prj_id = re_discountschedule.prj_id');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$this->session->userdata('branchid'));
		$this->db->where('re_projectms.prj_id',$prj_id);
		$this->db->group_by('re_discountschedule.prj_id');
		$query = $this->db->get('re_discountschedule'); 
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;
    }
	
	function confirm_discount_scheme($prj_id,$action){
		
		if($action == 'check'){
			$data = array(
				'status' => 'CHECKED',
				'checked_by' => $this->session->userdata('username'),
			);
		}else{
			$data = array(
				'status' => 'CONFIRMED',
				'confirmed_by'	=> $this->session->userdata('username'),
			);	
		}
		$this->db->trans_start();	
		$this->db->where('prj_id',$prj_id);
		$this->db->update('re_discountschedule',$data);
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		} 
		else {
			$this->db->trans_commit();
			return true;
		}
	}
}