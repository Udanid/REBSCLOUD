<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_sales_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_officer_projectlist($userid) { //get all stock
		$this->db->select('project_name,prj_id');
		$this->db->where('officer_code2',$userid);
		$this->db->where('price_status',CONFIRMKEY);
		$this->db->order_by('prj_id');
		$query = $this->db->get('hm_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_all_projectlist($branchid) { //get all stock
		$this->db->select('hm_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
		//$this->db->where('officer_code',$userid);
			if(! check_access('all_branch'))
		$this->db->where('branch_code',$branchid);
		$this->db->where('price_status',CONFIRMKEY);
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code');
		
		$this->db->order_by('officer_code');
		$query = $this->db->get('hm_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_salespersonlist($prjid) { //get all stock
		$this->db->select('hm_salesman.user_id,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->where('hm_salesman.prj_id',$prjid);
		$this->db->where('hm_salesman.status','Active');
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_salesman.user_id');
		$this->db->order_by('hr_empmastr.user_id');
		
			$query = $this->db->get('hm_salesman'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_all_reservation_details($prj_id) {
		$status = array('PROCESSING', 'COMPLETE'); //get all stock
		$this->db->select('hm_resevation.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.plan_sqid');
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where_in('hm_resevation.res_status',$status);
		$this->db->where('hm_resevation.pay_type !=','NEP');
		$query = $this->db->get('hm_resevation'); 
		return $query->result(); 
    }
	function get_month_target($prj_id,$month,$year,$salsment)
	{
		$this->db->select('target');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('officer_id',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('hm_salestarget'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $data->target;
        }
		else
		return 0; 
	}
	
	function delete_target($prj_id,$month,$year)
	{
		
			$this->db->where('prj_id',$prj_id);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$insert = $this->db->delete('hm_salestarget');
		return $insert;
	
		
	}
	function add_target($prj_id,$month,$year,$salsment,$target)
	{
		//$tot=$bprice*$quontity; 
		//$id=$this->getmaincode('cus_code','CUS','hm_salesman');
		$data=array( 
		'prj_id'=>$prj_id,
		'officer_id' => $salsment,
		'month' => $month,
		'year' => $year,
		'target' => $target,
		'create_date' => date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),
	
		);
		$insert = $this->db->insert('hm_salestarget', $data);
		
		
		
	}
	
	function get_month_forcast($prj_id,$month,$year,$salsment)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('res_code',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('hm_salesforcast'); 
		 if ($query->num_rows >0) {
			// $data=$query->row();
            return $query->row();
        }
		else
		return 0; 
	}
	function delete_forcast($prj_id,$month,$year)
	{
		
			$this->db->where('prj_id',$prj_id);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$insert = $this->db->delete('hm_salesforcast');
		return $insert;
	
		
	}
	function add_forcast($prj_id,$month,$year,$res_code,$week1,$week2,$week3,$week4,$week5,$sales_officer)
	{
		//$tot=$bprice*$quontity; 
		//$id=$this->getmaincode('cus_code','CUS','hm_salesman');
		$data=array( 
		'prj_id'=>$prj_id,
		'res_code' => $res_code,
		'month' => $month,
		'year' => $year,
		'week1' => $week1,
		'week2' => $week2,
		'week3' => $week3,
		'week4' => $week4,
		'week5' => $week5,
		'sales_officer'=>'sales_officer',
		
		'create_date' => date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),
	
		);
		$insert = $this->db->insert('hm_salesforcast', $data);
		
		
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('cus_code', $id);
		$insert = $this->db->update('hm_salesman', $data);
		return $insert;
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		$data=$this->get_salesmen_bycode($id);
		if($this->check_sales_active($data->prj_id,$data->user_id))
		{
		
		 return false;
		}
		else{
		$this->db->where('id', $id);
		$insert = $this->db->delete('hm_salesman');
		return $insert;
		}
		
	}
 function getmaincode($idfield,$prifix,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table);
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 4, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 4, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;
	
	}
}