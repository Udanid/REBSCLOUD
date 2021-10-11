<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Document_model extends CI_Model {

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
		if($id)
		{
		$this->db->where('doctype_id', $id);
		$insert = $this->db->delete('cm_doctypes');
		return $insert;
		}

	}
	function get_project_list() { //get all stock
	$branchid=$this->session->userdata('branchid');
		$this->db->select('prj_id,project_code,project_name,town,branch_code');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->order_by('project_name');
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
    function get_land_list()
    {	$branchid=$this->session->userdata('branchid');

       $this->db->select('land_code,property_name,town');
	   	if(! check_access('all_branch'))
		$this->db->where('re_landms.branch_code',$branchid);
		$this->db->order_by('property_name');
		$query = $this->db->get('re_landms');
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
		$query = $this->db->get('re_landdoc');
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
		$insert = $this->db->update('re_landdoc', $data);

	}
	function delete_project_documents($prjid,$docid)
	{
		$this->db->where('prj_id', $prjid);
		$this->db->where('doc_id', $docid);
		$insert = $this->db->delete('re_projectdoc');
		return $insert;
	}
	function add_project_documents($prjid,$docid,$document)
	{
		$data=array(
		'prj_id' =>$prjid,
		'doc_id' =>$docid,
		'document' =>$document,

		);

		$insert = $this->db->insert('re_projectdoc',$data);
	}
	 function get_project_documents($prjid,$docid)
    {
       $this->db->select('*');
		$this->db->where('prj_id', $prjid);
		$this->db->where('doc_id', $docid);
		$query = $this->db->get('re_projectdoc');
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

  //updated by nadee for customer handed over documents module
  function get_customer_handoverdocuments($prjid,$lotid,$cusid,$doc_id)
   {
      $this->db->select('*');
   $this->db->where('prj_id', $prjid);
   $this->db->where('lot_id', $lotid);
   $this->db->where('res_code', $cusid);
   $this->db->where('doc_id', $doc_id);
   $query = $this->db->get('re_customer_handover_doc');
       if ($query->num_rows() > 0) {

           return $query->row();

       } else{
           return 0;
       }
   }

   function get_customer_all_bylotid($lot_id)
   {
     $this->db->select('cm_customerms.first_name,
  cm_customerms.last_name,
  re_resevation.res_code,
  cm_customerms.cus_code');
    $this->db->join('cm_customerms','re_resevation.cus_code = cm_customerms.cus_code');
    $this->db->where('re_resevation.lot_id',$lot_id);
    $query=$this->db->get('re_resevation');
    if ($query->num_rows() > 0) {

        return $query->result();

    } else{
        return 0;
    }
   }

   function add_cusdocuments($doc_type,$file)
   {
     $data = array('prj_id'=>$this->input->post('prj_id'),
     'lot_id'=>$this->input->post('lot_id'),
     'res_code'=>$this->input->post('cus_id'),
     'doc_id'=>$doc_type,
     'document' => $file,
      'added_at'=>date('Y-m-d'),
      'added_by'=>$this->session->userdata('username'));

      $insert=$this->db->insert('re_customer_handover_doc',$data);
      if($insert)
      {
        return true;

      }else{
        return false;
      }
   }

   function cus_hand_overdocsdelete($id)
   {
     $this->db->where('id', $id);
    $insert = $this->db->delete('re_customer_handover_doc');
    return $insert;
   }
   function get_customer_handoverdocuments_byres($cusid)
    {
       $this->db->select('re_customer_handover_doc.*,cm_doctypes.document_name');
    $this->db->where('re_resevation.cus_code', $cusid);
    $this->db->join('re_resevation','re_customer_handover_doc.res_code = re_resevation.res_code');
    $this->db->join('cm_doctypes','re_customer_handover_doc.doc_id = cm_doctypes.doctype_id');
    $query = $this->db->get('re_customer_handover_doc');
        if ($query->num_rows() > 0) {

            return $query->result();

        } else{
            return 0;
        }
    }
}
