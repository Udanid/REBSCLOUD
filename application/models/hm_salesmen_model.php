<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_salesmen_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_salesmen_summery($branchid) { //get all stock
		$this->db->select('hm_salesman.id,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_salesman.user_id');
		$this->db->join('cm_userdata','cm_userdata.USRID=hm_salesman.user_id');
		if(! check_access('all_branch'))
		$this->db->where('cm_userdata.BRNCODE',$branchid);
	$this->db->where('hr_empmastr.division','4');
		$this->db->order_by('initial');
		$query = $this->db->get('hm_salesman'); 
		return $query->result(); 
    }
	function get_all_salesmen_list($branchid) { //get all stock
		$this->db->select('hr_empmastr.id,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('cm_userdata','cm_userdata.USRID=hr_empmastr.id');
		if(! check_access('all_branch'))
		$this->db->where('cm_userdata.BRNCODE',$branchid);
		$this->db->where('hr_empmastr.division','4');
			$this->db->where('hr_empmastr.status','A');
		$this->db->order_by('initial');
		$query = $this->db->get('hr_empmastr'); 
		return $query->result(); 
    }
	function get_all_salesmen_details($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('hm_salesman.id,hr_empmastr.emp_no,hr_empmastr.initial,hr_empmastr.surname,hm_projectms.project_name,hm_salesman.status');
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_salesman.user_id');
		$this->db->join('cm_userdata','cm_userdata.USRID=hm_salesman.user_id');
		$this->db->join('hm_projectms','hm_projectms.prj_id=hm_salesman.prj_id');
		if(! check_access('all_branch'))
		$this->db->where('cm_userdata.BRNCODE',$branchid);
	$this->db->where('hr_empmastr.division','4');
		$this->db->order_by('initial');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_salesman'); 
		return $query->result(); 
    }
	function get_officer_projectlist($userid) { //get all stock
		$this->db->select('project_name,prj_id');
		$this->db->where('officer_code',$userid);
		$this->db->where('price_status',CONFIRMKEY);
		$this->db->order_by('prj_id');
		$query = $this->db->get('hm_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_manager_projectlist() { //get all stock
	if($this->session->userdata('usertype')=='Assistant Manager'){
		$this->db->select('project_name,prj_id');
			$this->db->where('price_status',CONFIRMKEY);
		$this->db->order_by('prj_id');
		$query = $this->db->get('hm_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
		}
		else return false;
		
    }
	function get_all_projectlist($userid) { //get all stock
		$this->db->select('project_name,prj_id');
		//$this->db->where('officer_code',$userid);
		$this->db->where('price_status',CONFIRMKEY);
		$this->db->order_by('prj_id');
		$query = $this->db->get('hm_projectms'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_project_officerlist($prjid) { //get all stock
		$this->db->select('hr_empmastr.id as user_id,hr_empmastr.initial,hr_empmastr.surname');
	//	$this->db->where('hm_salesman.prj_id',$prjid);
	//	$this->db->where('hm_salesman.status','Active');
	//	$this->db->join('hr_empmastr','hr_empmastr.id=hm_salesman.user_id');
		$this->db->where('hr_empmastr.status','A');
			$query = $this->db->get('hr_empmastr'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	
	function get_salesmen_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_salesman'); 
		return $query->row(); 
    }
	
	function check_already_excist($prj_id,$id)
	{
		$this->db->select('id');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('user_id',$id);
	
		
		$query = $this->db->get('hm_salesman'); 
		 if ($query->num_rows >0) {
            return true;
        }
		else
		return false; 
	}
	function check_sales_active($prj_id,$id)
	{
		$this->db->select('res_code');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('sales_person',$id);
		$query = $this->db->get('hm_resevation'); 
		 if ($query->num_rows >0) {
            return true;
        }
		else
		return false; 
	}
	function add($prj_id,$user_id)
	{
		//$tot=$bprice*$quontity; 
		//$id=$this->getmaincode('cus_code','CUS','hm_salesman');
		$data=array( 
		'prj_id'=>$prj_id,
		'user_id' => $user_id,
		'create_date' => date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),
		'status' => 'Active',
		
		
		);
		$insert = $this->db->insert('hm_salesman', $data);
		
		
		
	}
	function edit($filename)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'title' => $this->input->post('title'),
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'landphone' => $this->input->post('landphone'),
		'mobile' => $this->input->post('mobile'),
		'email' => $this->input->post('email'),
		'address3' => $this->input->post('address3'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'id_type' => $this->input->post('id_type'),
		'id_number' => $this->input->post('id_number'),
		'id_copy' => $filename,
		
		);
		$this->db->where('cus_code', $this->input->post('cus_code'));
		$insert = $this->db->update('hm_salesman', $data);
		
		return $insert;
		
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