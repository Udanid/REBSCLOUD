<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_document_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_document($pagination_counter=100, $page_count=0) { //get all stock
		$this->db->select('*');
		$this->db->order_by('doctype_id');
			$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_doctypes'); 
		return $query->result(); 
    }

	
	function get_document_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('doctype_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_doctypes'); 
		return $query->row(); 
    }
		function get_document_bycategory($code) { //get all stock
		$this->db->select('*');
		$this->db->where('category',$code);
		$this->db->where('status',CONFIRMKEY);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_doctypes'); 
		return $query->result(); 
    }
	
	
	function add()
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		'category' => $this->input->post('category'),
		'document_name' => $this->input->post('document_name'),
		'create_by' => $this->session->userdata('username'),
		
		);
		$insert = $this->db->insert('cm_doctypes', $data);
		$row = $this->db->query('SELECT MAX(doctype_id) AS `maxid` FROM `cm_doctypes`')->row();
		return $row->maxid;
		
	}
	function edit()
	{
		//$tot=$bprice*$quontity; 
		$thisdata=$this->get_document_bycode($this->input->post('doctype_id'));
		if($thisdata->status==CONFIRMKEY)
		{
		  $data=array( 
		  
		
		  'document_name' => $this->input->post('document_name'),
		  'create_by' => $this->session->userdata('username'),
		  );
		}
		else
		{
			 $data=array( 
		  
		  'category' => $this->input->post('category'),
		  'document_name' => $this->input->post('document_name'),
		  'create_by' => $this->session->userdata('username'),
		  );
		}
		$this->db->where('doctype_id', $this->input->post('doctype_id'));
		$insert = $this->db->update('cm_doctypes', $data);
		return $insert;
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('doctype_id', $id);
		$insert = $this->db->update('cm_doctypes', $data);
		return $insert;
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		
		$this->db->where('doctype_id', $id);
		$insert = $this->db->delete('cm_doctypes');
		return $insert;
		
	}
	function get_project_list() { //get all stock
		$this->db->select('prj_id,project_code,project_name,town,branch_code');
		$this->db->order_by('project_name');
		$query = $this->db->get('hm_projectms'); 
		return $query->result(); 
    }
    function get_land_list()
    {
       $this->db->select('land_code,property_name,town');
		$this->db->order_by('property_name');
		$query = $this->db->get('hm_landms'); 
        if ($query->num_rows() > 0) {
           
            return $query->result(); 

        } else{
            return false;
        }
    }
		function get_land_documents($code) { //get all stock
		$this->db->select('*');
		$this->db->where('land_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hm_landdoc'); 
		return $query->result(); 
    }
	function update_land_documents($id,$plan_no,$deed_no,$drawn_by,$drawn_date,$attest_by,$attest_date,$plan_copy,$deed_copy)
	{
		$data=array( 
		'plan_no' => $plan_no,
		'deed_no' => $deed_no,
		'drawn_by' => $drawn_by,
		'drawn_date' => $drawn_date,
		'attest_by' => $attest_by,
		'attest_date' => $attest_date,
		'plan_copy' => $plan_copy,
		'deed_copy' => $deed_copy,
			);
		$this->db->where('id',$id);
		$insert = $this->db->update('hm_landdoc', $data);
		
	}
	function delete_project_documents($prjid,$docid)
	{
		$this->db->where('prj_id', $prjid);
		$this->db->where('doc_id', $docid);
		$insert = $this->db->delete('hm_projectdoc');
		return $insert;
	}
	function add_project_documents($prjid,$docid,$document)
	{
		$data=array( 
		'prj_id' =>$prjid,
		'doc_id' =>$docid,
		'document' =>$document,
		
		);
		
		$insert = $this->db->insert('hm_projectdoc',$data);
	}
	 function get_project_documents($prjid,$docid)
    {
       $this->db->select('*');
		$this->db->where('prj_id', $prjid);
		$this->db->where('doc_id', $docid);
		$query = $this->db->get('hm_projectdoc'); 
        if ($query->num_rows() > 0) {
           
            return $query->row(); 

        } else{
            return 0;
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