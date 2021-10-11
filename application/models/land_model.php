<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Land_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_land_summery() { //get all stock
		$this->db->select('land_code,district,property_name');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->order_by('land_code');
		$query = $this->db->get('re_landms');
		return $query->result();
    }
	function get_all_unused_land_summery() { //get all stock
		$this->db->select('land_code,district,property_name');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->where('status',CONFIRMKEY);
		$this->db->order_by('land_code','DESC');
		$query = $this->db->get('re_landms');
		return $query->result();
    }
	function get_all_land_details($pagination_counter, $page_count) { //get all stock
		$this->db->select('*');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->order_by('land_code','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_landms');
		return $query->result();
    }
	function get_land_bycode($code) { //get all stock
		$this->db->select('re_landms.*,re_introducerms.first_name,re_introducerms.last_name');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->join('re_introducerms','re_introducerms.intro_code=re_landms.intro_code','left');
		$this->db->where('land_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_landms');
		return $query->row();
    }

	function get_land_comments($code) { //get all stock
		$this->db->select('*');
		$this->db->where('land_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_landcomment');
		return $query->result();
    }
	function add($plan,$deed)
	{
		//$tot=$bprice*$quontity;
		$id=$this->getmaincode('land_code','LND','re_landms');
		$data=array(
		'land_code'=>$id,
		'branch_code' => $this->input->post('branch_code'),
		'product_code' => $this->input->post('product_code'),
		'intro_code' => $this->input->post('intro_code'),
    'intro_code2' => $this->input->post('intro_code2'),
		'intro_date' => $this->input->post('intro_date'),
		'owner_name' => $this->input->post('owner_name'),
		'property_name' => $this->input->post('property_name'),
		'address3' => $this->input->post('address3'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'district' => $this->input->post('district'),
		'procouncil' => $this->input->post('procouncil'),
		'town' => $this->input->post('town'),
		'extendperch' => $this->input->post('extendperch'),
		'perch_price ' => $this->input->post('perch_price'),
		'plan_no' => $this->input->post('plan_no'),
		'deed_no' => $this->input->post('deed_no'),
		'drawn_by' => $this->input->post('drawn_by'),
		'drawn_date' => $this->input->post('drawn_date'),
		'attest_by' => $this->input->post('attest_by'),
		'attest_date' => $this->input->post('attest_date'),
		'envirronment_data' => $this->input->post('envirronment_data'),
		'company_code' => $this->input->post('company_code'),
		//company_code
		'remarks' => $this->input->post('remarks'),
		'plan_copy' =>$plan,
		'deed_copy' =>$deed,
		'remarks' => $this->input->post('remarks'),
		'create_date' =>date("Y-m-d"),
		'create_by' => $this->session->userdata('username'),

		);
		$insert = $this->db->insert('re_landms', $data);

		return $id;

	}
	function add_owners($land_code,$name,$address,$nic)
	{
		$data=array(
		'land_code'=>$land_code,
		'owner_name' => $name,
		'address' => $address,
		'nic' => $nic,
		'create_date' => date('Y-m-d'),
		);
		$insert = $this->db->insert('re_landowner', $data);
	}
	function get_land_owners($code) { //get all stock
		$this->db->select('*');
		$this->db->where('land_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_landowner');
		return $query->result();
    }
	function get_land_documents($code) { //get all stock
		$this->db->select('*');
		$this->db->where('land_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_landdoc');
		return $query->result();
    }
	function add_documents($land_code,$plan_no,$deed_no,$drawn_by,$drawn_date,$attest_by,$attest_date,$plan_copy,$deed_copy )
	{
		$data=array(
		'land_code'=>$land_code,
		'plan_no' => $plan_no,
		'deed_no' => $deed_no,
		'drawn_by' => $drawn_by,
		'drawn_date' => $drawn_date,
		'attest_by' => $attest_by,
		'attest_date' => $attest_date,
		'plan_copy' => $plan_copy,
		'deed_copy' => $deed_copy,
		'create_date' => date('Y-m-d'),
		'create_by' => $this->session->userdata('username'),
		);
		$insert = $this->db->insert('re_landdoc', $data);

	}
	function delete_owners($id)
	{
		//$tot=$bprice*$quontity;
		$this->db->where('land_code', $id);
		$insert = $this->db->delete('re_landowner');

		return $insert;

	}
	function delete_documents($id)
	{
		//$tot=$bprice*$quontity;
		$this->db->where('land_code', $id);
		$insert = $this->db->delete('re_landdoc');

		return $insert;

	}
	function edit($plan,$deed)
	{
		//$tot=$bprice*$quontity;
		$data=array(

		'intro_code' => $this->input->post('intro_code'),
    'intro_code2' => $this->input->post('intro_code2'),
		'intro_date' => $this->input->post('intro_date'),
		'owner_name' => $this->input->post('owner_name1'),
		'property_name' => $this->input->post('property_name'),
		'address3' => $this->input->post('address3'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'district' => $this->input->post('district'),
		'procouncil' => $this->input->post('procouncil'),
		'town' => $this->input->post('town'),
		'extendperch' => $this->input->post('extendperch'),
		'perch_price ' => $this->input->post('perch_price'),
	//	'plan_no' => $this->input->post('plan_no'),
	//	'deed_no' => $this->input->post('deed_no'),
	//	'drawn_by' => $this->input->post('drawn_by'),
	//	'drawn_date' => $this->input->post('drawn_date'),
	//	'attest_by' => $this->input->post('attest_by'),
	//	'attest_date' => $this->input->post('attest_date'),
		'envirronment_data' => $this->input->post('envirronment_data'),
		'company_code' => $this->input->post('company_code'),

		'remarks' => $this->input->post('remarks'),
		'plan_copy' =>$plan,
		'deed_copy' =>$deed,
		'remarks' => $this->input->post('remarks'),

		);
		$this->db->where('land_code', $this->input->post('land_code'));
		$insert = $this->db->update('re_landms', $data);

		return $insert;

	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity;
		$data=array(


		'status' => CONFIRMKEY,
		);
		$this->db->where('land_code', $id);
		$insert = $this->db->update('re_landms', $data);
		return $insert;

	}
	function delete($id)
	{
		//$tot=$bprice*$quontity;
		$this->db->where('land_code', $id);
		$insert = $this->db->delete('re_landcomment');
		$this->db->where('land_code', $id);
		$insert = $this->db->delete('re_landdoc');
		$this->db->where('land_code', $id);
		$insert = $this->db->delete('re_landowner');
		$this->db->where('land_code', $id);
		$insert = $this->db->delete('re_landms');
		return $insert;

	}
	function commetnadd()
	{
		$this->db->where('land_code', $this->input->post('land_code'));
		$insert = $this->db->delete('re_landcomment');

			$data=array(

			  'land_code' => $this->input->post('land_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Higer Auth',
			  'comment' => $this->input->post('high_auth'),
			  'comment_date' => date("Y-m-d"),

			  );
			  $this->db->insert('re_landcomment', $data);

			  $data=array(

			  'land_code' => $this->input->post('land_code'),
			  'userid' => $this->session->userdata('userid'),
			  'comment_type' => 'Managers',
			  'comment' => $this->input->post('manager'),
			  'comment_date' => date("Y-m-d"),


			  );
			  $this->db->insert('re_landcomment', $data);


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
	function get_all_land_names(){
		$this->db->select('property_name');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->order_by('land_code','DESC');
		$query = $this->db->get('re_landms');
		return $query->result();
	}

		//Ticket No:2689 Added By Madushan 2021.04.20
	function get_all_land_details_search($land_code){
		$this->db->select('*');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->where('land_code',$land_code);
		$this->db->order_by('land_code','DESC');
		$query = $this->db->get('re_landms');
		return $query->result();
	}
}
