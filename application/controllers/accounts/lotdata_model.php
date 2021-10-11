<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lotdata_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_project_blockplans($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		$this->db->order_by('plan_sq');
		$query = $this->db->get('re_prjacblockplane'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
		
    }
	
	function get_project_pending_lots($code,$sq) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		$this->db->where('plan_sqid',$sq);
		$this->db->where('status','PENDING');
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	function get_project_pending_onhold_lots_byprjid($code) { 
	$status = array('ONHOLD', 'PENDING'); //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		
		$this->db->where_in('status',$status);
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	function get_project_pending_lots_byprjid($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		
		$this->db->where('status','PENDING');
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	function get_project_all_lots_byprjid($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		$this->db->order_by('lot_number');
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	function get_project_lotdata_id($code) { //get all stock
		$this->db->select('*');
		$this->db->where('lot_id',$code);
	
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->row(); 
    }
		function get_project_lots($code,$sq) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		$this->db->where('plan_sqid',$sq);
	
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	function get_project_lots_report($code,$sq) { //get all stock
		$this->db->select('re_prjaclotdata.*,re_resevation.pay_type,re_resevation.pay_type,re_resevation.res_status');
		$this->db->where('re_prjaclotdata.prj_id',$code);
		$this->db->where('re_prjaclotdata.plan_sqid',$sq);
		$this->db->join('re_resevation','re_resevation.lot_id=re_prjaclotdata.lot_id and re_resevation.res_status != "REPROCESS" ','left');
		//$this->db->where('re_resevation.res_status !=','REPROCESS');
	
		$this->db->order_by('re_prjaclotdata.lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	
	function get_feasibility_price($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		
		$query = $this->db->get('re_prjfprice');
		$totalpric=0;
		if ($query->num_rows() > 0){
			$dataset= $query->result();
			foreach($dataset as $raw)
			{
				$totalpric=$totalpric+($raw->perches_count*$raw->price);
			}
			return $totalpric;
		}
		else
		return $totalpric;
		
    }
	function get_project_officer_list($code) { //get all stock
		$this->db->select('re_prjofficers.*,hr_empmastr.surname,hr_empmastr.initial');
		$this->db->where('re_prjofficers.branch_code',$code);
		$this->db->join('hr_empmastr','hr_empmastr.id=re_prjofficers.empid');
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjofficers'); 
		return $query->result(); 
    }
	function add_blockoutplan($plan)
	{
		//$tot=$bprice*$quontity; getmaincode($idfield,$prifix,$table)
		$id=$this->getmaincode('plan_sq', $this->input->post('prj_id'),'re_prjacblockplane');
		$data=array( 
		'plan_sq'=>$id,
		'prj_id' => $this->input->post('prj_id'),
		'plan_no' => $this->input->post('plan_no'),
		'drown_by' => $this->input->post('drown_by'),
		'drown_date' => $this->input->post('drown_date'),
		'document ' => $plan,
	
		'blockout_count' => $this->input->post('blockout_count'),
		'update_date' =>date("Y-m-d"),
		'update_by ' => $this->session->userdata('username'),
		
		);
		$insert = $this->db->insert('re_prjacblockplane', $data);
		

		return $id;
		
	}
	function check_blockout($prj_id,$plan)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('plan_no',$plan);
		
		$query = $this->db->get('re_prjacblockplane');
		$totalpric=0;
		if ($query->num_rows() > 0){
			return true;
		}
		else
		return false;
		
	}
	function get_plansq($prj_id,$plan)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('plan_no',$plan);
		
		$query = $this->db->get('re_prjacblockplane');
		$totalpric=0;
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return false;
		
	}
	function add_lotdata($prj_id,$plan_sqid,$lot_number,$extend_perch,$price_perch,$sale_val)
	{
		$data=array( 
		'prj_id' =>$prj_id,
		'plan_sqid' =>$plan_sqid,
		'lot_number' =>$lot_number,
		'extend_perch' =>$extend_perch,
		'price_perch' =>$price_perch,
		'sale_val' =>$sale_val,
		'create_date' =>date("Y-m-d"),
		'create_by ' => $this->session->userdata('username'),
		//sale_val
		
		);
		
		$insert = $this->db->insert('re_prjaclotdata',$data);
	}
	function get_sold_cost($prj_id)
	{
		$this->db->select('SUM(costof_sale) as totext');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('status','SOLD');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata'); 
			if ($query->num_rows() > 0){
				$data= $query->row();
			$saleval=$data->totext;
			return $saleval;
			}
			else return 0;
	}
	function cost_adjustment($prj_id)
	{
		$currentprjex=project_expence($prj_id);
		$soldcost=$this->get_sold_cost($prj_id);
		$currentprjex=$currentprjex-$soldcost;
		
		$totpuerch=0;
		$this->db->select('SUM(sale_val) as totext');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('price_perch >',0.00);
		$this->db->where('status !=','SOLD');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata'); 
			if ($query->num_rows() > 0){
				$data= $query->row();
			$saleval=$data->totext;
			//$perchcost=$currentprjex/$saleval;
			//echo $perchcost;
			//$perchcost=round($perchcost, 2);
			
			$this->db->select('*');
			$this->db->where('prj_id',$prj_id);
			$this->db->where('price_perch >',0.00);
			$this->db->where('status !=','SOLD');
			$query = $this->db->get('re_prjaclotdata'); 
			$data=$query->result();
			$totesp=0;
			$lastid=0;
			$lastidval=0;
			foreach($data as $raw)
			{
				$adcost=($currentprjex*$raw->sale_val)/$saleval;
				$necost=$adcost;
				$necost=round($necost, 2);
				if($raw->sale_val>0)
				{
				$lastid=$raw->lot_id;
				$lastidval=$necost;
				}
				
				$totesp=$totesp+$necost;
				$inst=array('costof_sale'=>$necost);
				$this->db->where('lot_id', $raw->lot_id);
				$insert = $this->db->update('re_prjaclotdata', $inst);
			}
			$adjestment=$currentprjex-$totesp;
			//echo $adjestment;
			if($adjestment>0)
			{
				$lastidval=$lastidval+$adjestment;
			}
			else
			$lastidval=$lastidval-((-1)*$adjestment);
			$inst=array('costof_sale'=>$lastidval);
			$this->db->where('lot_id', $lastid);
				$insert = $this->db->update('re_prjaclotdata', $inst);
			
		}
		
		
		
	}
	function update_finance_cost($cost,$pfjid)
	{
		$inst=array('new_budget'=>$cost);
			$this->db->where('task_id', '39');
			$this->db->where('prj_id', $pfjid);
				$insert = $this->db->update('re_prjacpaymentms', $inst);
	}
	function get_finance_cost($pfjid)
	{
		$this->db->select('new_budget');
		$this->db->where('prj_id',$pfjid);
		$this->db->where('task_id', '39');
		$query = $this->db->get('re_prjacpaymentms'); 
			if ($query->num_rows() > 0){
				$data= $query->row();
			$saleval=$data->new_budget;
			return $saleval;
			}
			else return 0;
	}
	function delete_pendinglot($id)
	{
		//$tot=$bprice*$quontity; 
		$this->db->where('prj_id', $id);
		$this->db->where('status', 'PENDING');
		$insert = $this->db->delete('re_prjaclotdata');
	
		return $insert;
		
	}
	function commetnadd()
	{
		$this->db->where('project_code', $this->input->post('project_code'));
		$insert = $this->db->delete('re_projectcomment');
		
			$data=array( 
			  
			  'project_code' => $this->input->post('project_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Higer Auth',
			  'comment' => $this->input->post('high_auth'),
			  'comment_date' => date("Y-m-d"),	
			  
			  );
			  $this->db->insert('re_projectcomment', $data);
		
			  $data=array( 
			  
			  'project_code' => $this->input->post('project_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Managers',
			  'comment' => $this->input->post('manager'),
			  'comment_date' => date("Y-m-d"),
			  
			  
			  );
			  $this->db->insert('re_projectcomment', $data);
	
		
	}
	function get_max_resid($id)
	{
		$this->db->select('MAX(res_code) as res_code');
		$this->db->where('lot_id',$id);
		$this->db->where('res_status !=','REPROCESS');
		$query = $this->db->get('re_resevation');
		$totalpric=0;
		if ($query->num_rows() > 0){
			$dataset= $query->row();
			return $dataset->res_code;
			
		}
		else
		return 0;
		
    
	}
	function get_reservation_historty($id)
	{
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->where('lot_id',$id);
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		
		$this->db->where('res_status','REPROCESS');
		$query = $this->db->get('re_resevation');
		$totalpric=0;
		if ($query->num_rows() > 0){
		//	$dataset= $query->re();
			return  $query->result();
			
		}
		else
		return 0;
		
    
	}
	function get_resale_by_res_code($res_code)
	{
		$this->db->select('re_adresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.costof_sale,re_prjaclotdata.lot_id,re_resevation.discounted_price ');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		
		$this->db->where('re_adresale.res_code',$res_code);
		
			$query = $this->db->get('re_adresale'); 
		if ($query->num_rows() > 0){
	 
		return $query->row(); 
		}
		else
		return 0;
	}
	function get_epresale_res_code($branchid)
	{
		$this->db->select('re_epresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.costof_sale,re_prjaclotdata.lot_id,re_resevation.discounted_price ');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		
		$this->db->where('re_epresale.res_code',$branchid);
		
			$query = $this->db->get('re_epresale'); 
		if ($query->num_rows() > 0){
	 
		return $query->row(); 
		}
		else
		return 0;
	}
	function get_reservation_lot($prj_id)
	{
		$this->db->select('MAX(lot_id) as maxid,extend_perch');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('price_perch',0);
		$this->db->group_by('lot_id');
		$query = $this->db->get('re_prjaclotdata'); 
			if ($query->num_rows() > 0){
				$data= $query->row();
			
			return $data;
			}
			else return 0;
	}
	function edit_rslot()
	{
		$prj_id=$this->input->post('prj_id');
		$lot_id=$this->input->post('lot_id');
		$new_ex=$this->input->post('new_ex');
		
		$lotdetail=$this->get_project_lotdata_id($lot_id);
		$curent_rescode=$this->get_max_resid($lot_id);
		$current_lot=$lotdetail->extend_perch;
		$current_res=$this->reservation_model->get_all_reservation_details_bycode($curent_rescode);
		$rs_lot=$this->get_reservation_lot($prj_id);
		$res_ex=$rs_lot->extend_perch;
		if($current_lot>$new_ex)
		{
			$dif=$current_lot-$new_ex;
			$res_ex=$res_ex+$dif;
		}
		else
		{
			$dif=$new_ex-$current_lot;
			$res_ex=$res_ex-$dif;
		}
		//print_r($rs_lot);
		$newsalval=$lotdetail->price_perch*$new_ex;
		$discount=0;
		if(floatval($current_res->discount)>0 & floatval($current_res->discount)<50)
		$discount=$newsalval*$current_res->discount/100;
		if(floatval($current_res->discount)>50)
		$discount=$newsalval-$current_res->discount;
		
		$newdscountval=$newsalval-$discount;
		$inst=array('seling_price'=>$newsalval,
		'discounted_price'=>$newdscountval,);
			$this->db->where('res_code', $curent_rescode);
			$this->db->update('re_resevation', $inst);
			$inst=array('extend_perch'=>$new_ex,
			'sale_val'=>$newsalval,);
			$this->db->where('lot_id', $lot_id);
			$this->db->update('re_prjaclotdata', $inst);
			$inst=array('extend_perch'=>$res_ex,
			);
			$this->db->where('lot_id', $rs_lot->maxid);
			$this->db->update('re_prjaclotdata', $inst);
			
		$this->cost_adjustment($prj_id);
		return ;
		
	}
 function getmaincode($idfield,$prifix,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table ." where prj_id=".$prifix."");
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=str_pad(1, 2, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			// echo
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=str_pad($newid, 2, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 2, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;
	
	}
}