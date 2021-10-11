<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_officer_projectlist($userid) { //get all stock
		$this->db->select('project_name,prj_id');
		$this->db->where('officer_code2',$userid);
		$this->db->where('price_status',CONFIRMKEY);
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_all_projectlist($branchid) { //get all stock
		$this->db->select('re_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
		//$this->db->where('officer_code',$userid);
		if($branchid!='ALL')
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_projectms.price_status',CONFIRMKEY);
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code');
		
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_salespersonlist($prjid) { //get all stock
		$this->db->select('re_salesman.user_id,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->where('re_salesman.prj_id',$prjid);
		$this->db->where('re_salesman.status','Active');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_salesman.user_id');
			$query = $this->db->get('re_salesman'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_all_reservation_details($prj_id) {
		$status = array('PROCESSING', 'COMPLETE'); //get all stock
		$this->db->select('re_resevation.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->where('re_resevation.pay_type !=','NEP');
		$query = $this->db->get('re_resevation'); 
		return $query->result(); 
    }
	function get_month_target($prj_id,$month,$year,$salsment)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('officer_id',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('re_salestarget'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $query->row();
        }
		else
		return false; 
	}
	
	function delete_target($prj_id,$month,$year)
	{
		
			$this->db->where('prj_id',$prj_id);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$insert = $this->db->delete('re_salestarget');
		return $insert;
	
		
	}
	function add_target($prj_id,$month,$year,$salsment,$target,$blocks,$sales,$income)
	{
		//$tot=$bprice*$quontity; 
		//$id=$this->getmaincode('cus_code','CUS','re_salesman');
		$data=array( 
		'prj_id'=>$prj_id,
		'officer_id' => $salsment,
		'month' => $month,
		'year' => $year,
		'target' => $target,
		'sales' => $sales,
		'income' => $income,
		'blocks' => $blocks,
		'create_date' => date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),
	
		);
		$insert = $this->db->insert('re_salestarget', $data);
		
		
		
	}
	
	function get_month_forcast($prj_id,$month,$year,$salsment)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('res_code',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('re_salesforcast'); 
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
		$insert = $this->db->delete('re_salesforcast');
		return $insert;
	
		
	}
	function delete_forcast_new($prj_id,$month,$year,$res_code)
	{
		
			$this->db->where('prj_id',$prj_id);
			$this->db->where('res_code',$res_code);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$insert = $this->db->delete('re_salesforcast');
		return $insert;
	
		
	}
	function add_forcast($prj_id,$month,$year,$res_code,$collection,$Collection_date,$sales_officer)
	{
		//$tot=$bprice*$quontity; 
		//$id=$this->getmaincode('cus_code','CUS','re_salesman');
		$data=array( 
		'prj_id'=>$prj_id,
		'res_code' => $res_code,
		'month' => $month,
		'year' => $year,
		'collection' => $collection,
		'Collection_date' => $Collection_date,
		'sales_officer'=>$sales_officer,
		
		'create_date' => date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),
	
		);
		$insert = $this->db->insert('re_salesforcast', $data);
		
		
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('cus_code', $id);
		$insert = $this->db->update('re_salesman', $data);
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
		$insert = $this->db->delete('re_salesman');
		return $insert;
		}
		
	}
	function check_pending_lots($prj_id) {
		$status = array('PENDING', 'RESERVED'); //get all stock
		$this->db->select('re_prjaclotdata.lot_id');
		$this->db->where('re_prjaclotdata.prj_id',$prj_id);
		$this->db->where_in('re_prjaclotdata.status',$status);
		$query = $this->db->get('re_prjaclotdata'); 
		 if ($query->num_rows >0) {
			// $data=$query->row();
            return true;
        }
		else
		return false; 
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
	function get_all_loan_details_type($prj_id,$type) {
		$this->db->select('re_eploan.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
	
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('hr_empmastr','hr_empmastr.id=re_eploan.collection_officer','left');
	
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->where('re_eploan.loan_type',$type);
		$query = $this->db->get('re_eploan'); 
		 if ($query->num_rows >0) {
			// $data=$query->row();
          return $query->result(); 
        }
		else
		return false; 
		
    }
	function get_sales_officerlist($branch) { //get all stock
		$this->db->select('*');
		$this->db->where('division','4');
		$this->db->where('status','A');
		if($branch!='ALL')
		$this->db->where('branch',$branch);
		$query = $this->db->get('hr_empmastr'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_month_officer_target($month,$year,$salsment)
	{
		$this->db->select('*');
		$this->db->where('officer_id',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('re_salesofficertarget'); 
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $query->row();
        }
		else
		return false; 
	}
	function add_officer_target($month,$year,$salsment,$sales,$block)
	{
		//$tot=$bprice*$quontity; 
		//$id=$this->getmaincode('cus_code','CUS','re_salesman');
		$data=array( 
			'officer_id' => $salsment,
		'month' => $month,
		'year' => $year,
		'sales' => $sales,
		'block' => $block,
		'create_date' => date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),
	
		);
		$insert = $this->db->insert('re_salesofficertarget', $data);
		
		
		
	}
	function delete_officer_target($officer_id,$month,$year)
	{
		
			$this->db->where('officer_id',$officer_id);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$insert = $this->db->delete('re_salesofficertarget');
		return $insert;
	
		
	}
	function get_tot_sale_reservationlist($id,$fromdate,$todate) { //get all stock
	$this->db->select('re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_prjaclotdata.extend_perch,re_prjaclotdata.price_perch,re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,re_projectms.project_name');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		$this->db->where('re_resevation.sales_person',$id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date >=',$fromdate);
		$this->db->where('re_resevation.res_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
}