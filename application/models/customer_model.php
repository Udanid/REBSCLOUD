<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_customer_summery() { //get all stock
		$this->db->select('cus_code,cus_number,first_name,last_name,id_number,mobile,address2,landphone,workphone,email');
		$this->db->order_by('cus_code');
		
		$query = $this->db->get('cm_customerms');
		return $query->result();
    }
	function get_all_customer_details($pagination_counter, $page_count) { //get all stock
		$this->db->select('*');
		$this->db->order_by('cus_code','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_customerms');
		return $query->result();
    }
	function get_all_customer_summery_approved(){
		$this->db->select('cus_code,cus_number,first_name,last_name,address1,address2,address3,id_number,mobile,landphone');
		$this->db->where('status','CONFIRMED');
		$this->db->order_by('first_name');
		$query = $this->db->get('cm_customerms');
		return $query->result();
	}
	function get_all_customer_details_excel() { 
		/*Ticket no:2841 Updated by Madushan 2021.05.17*/
		$status = array('PROCESSING','COMPLETE','SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,cm_customerms.address2,cm_customerms.landphone,cm_customerms.workphone,cm_customerms.email,cm_customerms.address1,cm_customerms.address3,cm_customerms.raddress1,cm_customerms.raddress2,cm_customerms.raddress3,cm_customerms.otheraddress1,cm_customerms.otheraddress2,cm_customerms.otheraddress3');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where_in('re_resevation.res_status',$status);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_customer_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('cus_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_customerms');
		return $query->row();
    }

	function get_customer_bankdata_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('cus_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_customerbank');
		return $query->result();
    }
	function add()
	{
		$number=$this->getmaincode('cus_number','CUS','cm_customerms');

		if ($this->input->post('custtype') == 'individual'){
			if($this->input->post('customer_photo')){
				$photo = $this->input->post('customer_photo');
			}else if($this->input->post('webcamimage')){
				$photo = $this->input->post('webcamimage');
			}
			$data=array(
			'cus_number'=>$number,
			'cus_type'=>$this->input->post('custtype'),
			'cus_branch'=>$this->session->userdata('branchid'),
			'create_date' => date("Y-m-d"),
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'full_name' => $this->input->post('full_name'),
			'other_names' => $this->input->post('other_names'),
			'unicode_name' => $this->input->post('unicode_name'),
			'gender' => $this->input->post('gender'),
			'dob' => $this->input->post('dob'),
			'pob' => $this->input->post('pob'),
			'civil_status' => $this->input->post('civil_status'),
			'spouse_name' => $this->input->post('spouse_name'),
			'spouse_employer' => $this->input->post('spouse_employer'),
			'spouse_designation' => $this->input->post('spouse_designation'),
			'spouse_income' => $this->input->post('spouse_income'),
			'dependent' => $this->input->post('dependent'),
			'citizenship' => $this->input->post('citizenship'),
			'id_type' => $this->input->post('id_type'),
			'id_number' => $this->input->post('id_number'),
			'id_doi' => $this->input->post('id_doi'),
			'customer_photo' => $photo,
			'signature' => $this->input->post('signature'),
			'id_copy_front' => $this->input->post('id_copy_front'),
			'id_copy_back' => $this->input->post('id_copy_back'),
			'occupation' => $this->input->post('occupation'),
			'employer' => $this->input->post('employer'),
			'employer_address' => $this->input->post('employer_address'),
			'employer_phone' => $this->input->post('employer_phone'),
			'monthly_income' => $this->input->post('monthly_income'),
			'income_source' => $this->input->post('income_source'),
			'monthly_expence' => $this->input->post('monthly_expence'),
			'savings' => $this->input->post('savings'),
			'moveable_property' => $this->input->post('moveable_property'),
			'imovable_property' => $this->input->post('imovable_property'),
			'raddress1' => $this->input->post('raddress1'),
			'raddress2' => $this->input->post('raddress2'),
			'raddress3' => $this->input->post('raddress3'),
      'rpostal_code' => $this->input->post('rpostal_code'),
			'otheraddress1' => $this->input->post('otheraddress1'),
			'otheraddress2' => $this->input->post('otheraddress2'),
			'otheraddress3' => $this->input->post('otheraddress3'),
			'otheraddress4' => $this->input->post('otheraddress4'),
      'otherpostal_code'=> $this->input->post('otherpostal_code'),
			'raddress_duration' => $this->input->post('raddress_duration'),
			'raddress_ownership' => $this->input->post('raddress_ownership'),
			'address1' => $this->input->post('address1'),
			'address2' => $this->input->post('address2'),
			'address3' => $this->input->post('address3'),
      'postal_code' => $this->input->post('postal_code'),
			'gsword' => $this->input->post('gsword'),
			'landphone' => $this->input->post('landphone'),
			'workphone' => $this->input->post('workphone'),
			'mobile' => $this->input->post('mobile'),
			'fax' => $this->input->post('fax'),
			'email' => $this->input->post('email'),
			'create_by' => $this->session->userdata('username'),
			);
		}else if($this->input->post('custtype') == 'business'){
			$data=array(
			'cus_number'=>$number,
			'cus_type'=>$this->input->post('custtype'),
			'cus_branch'=>$this->session->userdata('branchid'),
			'create_date' => date("Y-m-d"),
			'last_name' => $this->input->post('business_name'),
			'occupation' => $this->input->post('business_type'),
			'unicode_name' => $this->input->post('unicode_bname'),
			'tin' => $this->input->post('tin'),
			'vat' => $this->input->post('vat'),
			'monthly_income' => $this->input->post('monthly_bincome'),
			'income_source' => $this->input->post('bincome_source'),
			'monthly_expence' => $this->input->post('monthly_bexpence'),
			'savings' => $this->input->post('bsavings'),
			'moveable_property' => $this->input->post('moveable_bproperty'),
			'imovable_property' => $this->input->post('imovable_bproperty'),
			'id_type' => $this->input->post('id_type'),
			'id_number' => $this->input->post('id_number'),
			'id_doi' => $this->input->post('id_doi'),
			'id_copy_front' => $this->input->post('id_copy_front'),
			'id_copy_back' => $this->input->post('id_copy_back'),
			'address1' => $this->input->post('address1'),
			'address2' => $this->input->post('address2'),
			'address3' => $this->input->post('address3'),
      'postal_code' => $this->input->post('postal_code'),
			'otheraddress1' => $this->input->post('otheraddress1'),
			'otheraddress2' => $this->input->post('otheraddress2'),
			'otheraddress3' => $this->input->post('otheraddress3'),
			'otheraddress4' => $this->input->post('otheraddress4'),
      'otherpostal_code'=> $this->input->post('otherpostal_code'),
			'gsword' => $this->input->post('gsword'),
			'landphone' => $this->input->post('landphone'),
			'mobile' => $this->input->post('mobile'),
			'fax' => $this->input->post('fax'),
			'email' => $this->input->post('email'),
			'create_by' => $this->session->userdata('username'),
			);
		}

		$insert = $this->db->insert('cm_customerms', $data);
		$insert_id = $this->db->insert_id(); //get inserted id

		//now move files from temp to customer Ids
		$this->db->select('customer_photo,signature,id_copy_front,id_copy_back');
		$this->db->where('cus_code',$insert_id);
		$query = $this->db->get('cm_customerms');
		$customer = $query->row();
		$files = array($customer->customer_photo,$customer->signature,$customer->id_copy_front,$customer->id_copy_back);

		foreach ($files as $key => $raw){
			if (file_exists('uploads/temp/'.$raw)) {
				rename('uploads/temp/'.$raw, 'uploads/customer_ids/'.$raw);
			}
			if (file_exists('uploads/temp/thumbnail/'.$raw)) {
				rename('uploads/temp/thumbnail/'.$raw, 'uploads/customer_ids/thumbnail/'.$raw);
			}
		}

		//get added customer code
		$cust_id = $insert_id;

		//insert bank details
		if($this->input->post('bank1')!=""  ){
		$data2=array(
		'cus_code'=>$cust_id,
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('cm_customerbank', $data2);

		}
		if($this->input->post('bank2')!=""  ){
		$data2=array(
		'cus_code'=>$cust_id,
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('cm_customerbank', $data2);

		}
		return $cust_id;

	}
	function edit()
	{
		//check pending customer
		$this->db->select('status');
		$this->db->where('cus_code',$this->input->post('cus_code'));
		$query = $this->db->get('cm_customerms');
		$result = $query->row();
		$criticalkey=false;

		//if the customer status is pending we will update all critical and non critical data
		if($result->status == 'PENDING'){

			if ($this->input->post('custtype') == 'individual'){

				//array from post data
				$data=array(
					'title' => $this->input->post('title'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'full_name' => $this->input->post('full_name'),
					'other_names' => $this->input->post('other_names'),
					'unicode_name' => $this->input->post('unicode_name'),
					'gender' => $this->input->post('gender'),
					'dob' => $this->input->post('dob'),
					'pob' => $this->input->post('pob'),
					'civil_status' => $this->input->post('civil_status'),
					'spouse_name' => $this->input->post('spouse_name'),
					'spouse_employer' => $this->input->post('spouse_employer'),
					'spouse_designation' => $this->input->post('spouse_designation'),
					'spouse_income' => $this->input->post('spouse_income'),
					'dependent' => $this->input->post('dependent'),
					'citizenship' => $this->input->post('citizenship'),
					'id_type' => $this->input->post('id_type'),
					'id_number' => $this->input->post('id_number'),
					'id_doi' => $this->input->post('id_doi'),
					'customer_photo' => $this->input->post('customer_photo'),
					'signature' => $this->input->post('signature'),
					'id_copy_front' => $this->input->post('id_copy_front'),
					'id_copy_back' => $this->input->post('id_copy_back'),
					'occupation' => $this->input->post('occupation'),
					'employer' => $this->input->post('employer'),
					'employer_address' => $this->input->post('employer_address'),
					'employer_phone' => $this->input->post('employer_phone'),
					'monthly_income' => $this->input->post('monthly_income'),
					'income_source' => $this->input->post('income_source'),
					'monthly_expence' => $this->input->post('monthly_expence'),
					'savings' => $this->input->post('savings'),
					'moveable_property' => $this->input->post('moveable_property'),
					'imovable_property' => $this->input->post('imovable_property'),
					'raddress1' => $this->input->post('raddress1'),
					'raddress2' => $this->input->post('raddress2'),
					'raddress3' => $this->input->post('raddress3'),
          'rpostal_code' => $this->input->post('rpostal_code'),
					'raddress_duration' => $this->input->post('raddress_duration'),
					'raddress_ownership' => $this->input->post('raddress_ownership'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'address3' => $this->input->post('address3'),
          'postal_code' => $this->input->post('postal_code'),
					'otheraddress1' => $this->input->post('otheraddress1'),
					'otheraddress2' => $this->input->post('otheraddress2'),
					'otheraddress3' => $this->input->post('otheraddress3'),
					'otheraddress4' => $this->input->post('otheraddress4'),
          'otherpostal_code' => $this->input->post('otherpostal_code'),
					'gsword' => $this->input->post('gsword'),
					'landphone' => $this->input->post('landphone'),
					'workphone' => $this->input->post('workphone'),
					'mobile' => $this->input->post('mobile'),
					'fax' => $this->input->post('fax'),
					'email' => $this->input->post('email')
				);
			}else if($this->input->post('custtype') == 'business'){

				$data=array(
					'last_name' => $this->input->post('last_name'),
					'occupation' => $this->input->post('business_type'),
					'unicode_name' => $this->input->post('unicode_name'),
					'tin' => $this->input->post('tin'),
					'vat' => $this->input->post('vat'),
					'monthly_income' => $this->input->post('monthly_income'),
					'income_source' => $this->input->post('income_source'),
					'monthly_expence' => $this->input->post('monthly_expence'),
					'savings' => $this->input->post('savings'),
					'moveable_property' => $this->input->post('moveable_property'),
					'imovable_property' => $this->input->post('imovable_property'),
					'id_type' => $this->input->post('id_type'),
					'id_number' => $this->input->post('id_number'),
					'id_doi' => $this->input->post('id_doi'),
					'id_copy_front' => $this->input->post('id_copy_front'),
					'id_copy_back' => $this->input->post('id_copy_back'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'address3' => $this->input->post('address3'),
          'postal_code' => $this->input->post('postal_code'),
					'otheraddress1' => $this->input->post('otheraddress1'),
					'otheraddress2' => $this->input->post('otheraddress2'),
					'otheraddress3' => $this->input->post('otheraddress3'),
					'otheraddress4' => $this->input->post('otheraddress4'),
          'otherpostal_code' => $this->input->post('otherpostal_code'),
					'gsword' => $this->input->post('gsword'),
					'landphone' => $this->input->post('landphone'),
					'mobile' => $this->input->post('mobile'),
					'fax' => $this->input->post('fax'),
					'email' => $this->input->post('email')
				);
			}
			$this->db->where('cus_code',$this->input->post('cus_code'));
			$this->db->update('cm_customerms', $data);
			//now move files from temp to customer Ids
			$this->db->select('customer_photo,signature,id_copy_front,id_copy_back');
			$this->db->where('cus_code',$this->input->post('cus_code'));
			$query = $this->db->get('cm_customerms');
			$customer = $query->row();
			$files = array($customer->customer_photo,$customer->signature,$customer->id_copy_front,$customer->id_copy_back);

			foreach ($files as $key => $raw){
				if (file_exists('uploads/temp/'.$raw)) {
					rename('uploads/temp/'.$raw, 'uploads/customer_ids/'.$raw);
				}
				if (file_exists('uploads/temp/thumbnail/'.$raw)) {
					rename('uploads/temp/thumbnail/'.$raw, 'uploads/customer_ids/thumbnail/'.$raw);
				}
			}

		//otherwise we seperate critical and non critical data
		}else{

			if ($this->input->post('custtype') == 'individual'){
				//get required fields to check from customer tabel
				$this->db->select('*');
				$this->db->where('cus_code',$this->input->post('cus_code'));
				$query = $this->db->get('cm_customerms');
				$customer = $query->row();

				//create an array using data
				 $data2=array(
					'title' => $customer->title,
					'first_name' => $customer->first_name,
					'last_name' => $customer->last_name,
					'full_name' => $customer->full_name,
					'other_names' => $customer->other_names,
					'unicode_name' => $customer->unicode_name,
					'gender' => $customer->gender,
					'dob' => $customer->dob,
					'pob' => $customer->pob,
					'civil_status' => $customer->civil_status,
					'spouse_name' => $customer->spouse_name,
					'spouse_employer' => $customer->spouse_employer,
					'spouse_designation' => $customer->spouse_designation,
					'spouse_income' => $customer->spouse_income,
					'dependent' => $customer->dependent,
					'citizenship' => $customer->citizenship,
					'id_type' => $customer->id_type,
					'id_number' => $customer->id_number,
					'id_doi' => $customer->id_doi,
					'customer_photo' => $customer->customer_photo,
					'signature' => $customer->signature,
					'id_copy_front' => $customer->id_copy_front,
					'id_copy_back' => $customer->id_copy_back,
					'occupation' => $customer->occupation,
					'employer' => $customer->employer,
					'employer_address' => $customer->employer_address,
					'employer_phone' => $customer->employer_phone,
					'monthly_income' => $customer->monthly_income,
					'income_source' => $customer->income_source,
					'monthly_expence' => $customer->monthly_expence,
					'savings' => $customer->savings,
					'moveable_property' => $customer->moveable_property,
					'imovable_property' => $customer->imovable_property,
					'raddress1' => $customer->raddress1,
					'raddress2' => $customer->raddress2,
					'raddress3' => $customer->raddress3,
          'rpostal_code' => $customer->rpostal_code,
					'raddress_duration' => $customer->raddress_duration,
					'raddress_ownership' => $customer->raddress_ownership,
					'address1' => $customer->address1,
					'address2' => $customer->address2,
					'address3' => $customer->address3,
          'postal_code' => $customer->postal_code,
					'otheraddress1' => $customer->otheraddress1,
					'otheraddress2' => $customer->otheraddress2,
					'otheraddress3' => $customer->otheraddress3,
					'otheraddress4' => $customer->otheraddress4,
          'otherpostal_code' => $customer->otherpostal_code,
					'gsword' => $customer->gsword,
					'landphone' => $customer->landphone,
					'workphone' => $customer->workphone,
					'mobile' => $customer->mobile,
					'fax' => $customer->fax,
					'email' => $customer->email
				);

				//array from post data
				$data=array(
					'title' => $this->input->post('title'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'full_name' => $this->input->post('full_name'),
					'other_names' => $this->input->post('other_names'),
					'unicode_name' => $this->input->post('unicode_name'),
					'gender' => $this->input->post('gender'),
					'dob' => $this->input->post('dob'),
					'pob' => $this->input->post('pob'),
					'civil_status' => $this->input->post('civil_status'),
					'spouse_name' => $this->input->post('spouse_name'),
					'spouse_employer' => $this->input->post('spouse_employer'),
					'spouse_designation' => $this->input->post('spouse_designation'),
					'spouse_income' => $this->input->post('spouse_income'),
					'dependent' => $this->input->post('dependent'),
					'citizenship' => $this->input->post('citizenship'),
					'id_type' => $this->input->post('id_type'),
					'id_number' => $this->input->post('id_number'),
					'id_doi' => $this->input->post('id_doi'),
					'customer_photo' => $this->input->post('customer_photo'),
					'signature' => $this->input->post('signature'),
					'id_copy_front' => $this->input->post('id_copy_front'),
					'id_copy_back' => $this->input->post('id_copy_back'),
					'occupation' => $this->input->post('occupation'),
					'employer' => $this->input->post('employer'),
					'employer_address' => $this->input->post('employer_address'),
					'employer_phone' => $this->input->post('employer_phone'),
					'monthly_income' => $this->input->post('monthly_income'),
					'income_source' => $this->input->post('income_source'),
					'monthly_expence' => $this->input->post('monthly_expence'),
					'savings' => $this->input->post('savings'),
					'moveable_property' => $this->input->post('moveable_property'),
					'imovable_property' => $this->input->post('imovable_property'),
					'raddress1' => $this->input->post('raddress1'),
					'raddress2' => $this->input->post('raddress2'),
					'raddress3' => $this->input->post('raddress3'),
          'rpostal_code' => $this->input->post('rpostal_code'),
					'raddress_duration' => $this->input->post('raddress_duration'),
					'raddress_ownership' => $this->input->post('raddress_ownership'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'address3' => $this->input->post('address3'),
          'postal_code' => $this->input->post('postal_code'),
					'otheraddress1' => $this->input->post('otheraddress1'),
					'otheraddress2' => $this->input->post('otheraddress2'),
					'otheraddress3' => $this->input->post('otheraddress3'),
					'otheraddress4' => $this->input->post('otheraddress4'),
          'otherpostal_code' => $this->input->post('otherpostal_code'),
					'gsword' => $this->input->post('gsword'),
					'landphone' => $this->input->post('landphone'),
					'workphone' => $this->input->post('workphone'),
					'mobile' => $this->input->post('mobile'),
					'fax' => $this->input->post('fax'),
					'email' => $this->input->post('email')
				);
			}else if($this->input->post('custtype') == 'business'){
				//get required fields to check from customer tabel
				$this->db->select('*');
				$this->db->where('cus_code',$this->input->post('cus_code'));
				$query = $this->db->get('cm_customerms');
				$customer = $query->row();

				//create an array using data
				 $data2=array(
					'last_name' => $customer->last_name,
					'occupation' => $customer->occupation,
					'unicode_name' => $customer->unicode_name,
					'tin' => $customer->tin,
					'vat' => $customer->vat,
					'monthly_income' => $customer->monthly_income,
					'income_source' => $customer->income_source,
					'monthly_expence' => $customer->monthly_expence,
					'savings' => $customer->savings,
					'moveable_property' => $customer->moveable_property,
					'imovable_property' => $customer->imovable_property,
					'id_type' => $customer->id_type,
					'id_number' => $customer->id_number,
					'id_doi' => $customer->id_doi,
					'id_copy_front' => $customer->id_copy_front,
					'id_copy_back' => $customer->id_copy_back,
					'address1' => $customer->address1,
					'address2' => $customer->address2,
					'address3' => $customer->address3,
          'postal_code' => $customer->postal_code,
					'otheraddress1' => $customer->otheraddress1,
					'otheraddress2' => $customer->otheraddress2,
					'otheraddress3' => $customer->otheraddress3,
					'otheraddress4' => $customer->otheraddress4,
          'otherpostal_code' => $customer->otherpostal_code,
					'gsword' => $customer->gsword,
					'landphone' => $customer->landphone,
					'mobile' => $customer->mobile,
					'fax' => $customer->fax,
					'email' => $customer->email
				);

				//array from post data
				$data=array(
					'last_name' => $this->input->post('last_name'),
					'occupation' => $this->input->post('occupation'),
					'unicode_name' => $this->input->post('unicode_name'),
					'tin' => $this->input->post('tin'),
					'vat' => $this->input->post('vat'),
					'monthly_income' => $this->input->post('monthly_income'),
					'income_source' => $this->input->post('income_source'),
					'monthly_expence' => $this->input->post('monthly_expence'),
					'savings' => $this->input->post('savings'),
					'moveable_property' => $this->input->post('moveable_property'),
					'imovable_property' => $this->input->post('imovable_property'),
					'id_type' => $this->input->post('id_type'),
					'id_number' => $this->input->post('id_number'),
					'id_doi' => $this->input->post('id_doi'),
					'id_copy_front' => $this->input->post('id_copy_front'),
					'id_copy_back' => $this->input->post('id_copy_back'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'address3' => $this->input->post('address3'),
          'postal_code' => $this->input->post('postal_code'),
					'otheraddress1' => $this->input->post('otheraddress1'),
					'otheraddress2' => $this->input->post('otheraddress2'),
					'otheraddress3' => $this->input->post('otheraddress3'),
					'otheraddress4' => $this->input->post('otheraddress4'),
          'otherpostal_code' => $this->input->post('otherpostal_code'),
					'gsword' => $this->input->post('gsword'),
					'landphone' => $this->input->post('landphone'),
					'mobile' => $this->input->post('mobile'),
					'fax' => $this->input->post('fax'),
					'email' => $this->input->post('email')
				);
			}


			$changed = array();
			$criticalsupdates = array();
			$noncriticalsupdates = array();
			//check changes in both arrays
			$changed_fields=array_diff($data,$data2);

			if($changed_fields){
				//create an array using key value of changed fields
				foreach ($changed_fields as $key=>$data){
					$changed[] = $key;
				}
			}

			//get critical data fields
			$this->db->select('field');
			$query = $this->db->get('cm_customercritical');
			$critical = $query->result();

			if($critical){
				foreach ($critical as $keys => $value){
					$criticals[$keys] = $value->field;

				}
			}


			//get matches in both arrays
			$changed_critical=array_intersect($criticals,$changed);

			//create data array with critical updates
			foreach ($changed_critical as $matches){
				$criticalsupdates[$matches] = $this->input->post($matches);
			}

			if($criticalsupdates){
				//create appropriate array to insert into cm_customerchangelog
				foreach ($criticalsupdates as $key => $newdata){

					$newdataarray = array(
						'cus_code' 		=> $this->input->post('cus_code'),
						'changed_field'	=> $key,
						'prv_val'		=> $customer->$key,
						'new_val' 		=> $newdata,
						'changed_by' 	=> $this->session->userdata('username'),
						'changed_date' 	=> date('Y-m-d')
					);
					$criticalkey=true;
					//adding values to customer critical data
					$this->db->insert('cm_customerchangelog', $newdataarray);
					//echo 'pending';

				}
			}

			//get non critical data
			$changed_noncritical=array_diff($changed,$changed_critical);
			print_r($changed_noncritical);
			if($changed_noncritical){
				//create data array to add onto data base
				foreach ($changed_noncritical as $matches2){
					$noncriticalsupdates[$matches2] = $this->input->post($matches2);
				}
			}

			if($noncriticalsupdates){
				//update customer table with non critical data.
				$this->db->where('cus_code',$this->input->post('cus_code'));
				$this->db->update('cm_customerms', $noncriticalsupdates);
				//echo 'done';
				//now move files from temp to customer Ids
				$this->db->select('customer_photo,signature,id_copy_front,id_copy_back');
				$this->db->where('cus_code',$this->input->post('cus_code'));
				$query = $this->db->get('cm_customerms');
				$customer = $query->row();
				$files = array($customer->customer_photo,$customer->signature,$customer->id_copy_front,$customer->id_copy_back);

				foreach ($files as $key => $raw){
					if (file_exists('uploads/temp/'.$raw)) {
						rename('uploads/temp/'.$raw, 'uploads/customer_ids/'.$raw);
					}
					if (file_exists('uploads/temp/thumbnail/'.$raw)) {
						rename('uploads/temp/thumbnail/'.$raw, 'uploads/customer_ids/thumbnail/'.$raw);
					}
				}
			}
		}


		$this->db->where('cus_code',$this->input->post('cus_code'));
		$insert = $this->db->delete('cm_customerbank');

		if($this->input->post('bank1')!=""  ){
		$data2=array(
		'cus_code'=>$this->input->post('cus_code'),
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('cm_customerbank', $data2);

		}
		if($this->input->post('bank2')!=""  ){
		$data2=array(
		'cus_code'=>$this->input->post('cus_code'),
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('cm_customerbank', $data2);

		}
		return $criticalkey;

	}
	function edit_loan($filename)
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
		'permenant_address' => $this->input->post('permenant_address'),
		'id_type' => $this->input->post('id_type'),
		'id_number' => $this->input->post('id_number'),
		'profession' => $this->input->post('profession'),
		'occupation' => $this->input->post('occupation'),
		'business_add' => $this->input->post('business_add'),
		'bussiness_tell' => $this->input->post('bussiness_tell'),
		'monthly_incom' => $this->input->post('monthly_incom'),
		'monthly_expence' => $this->input->post('monthly_expence'),
		'civil_status' => $this->input->post('civil_status'),
		'spause_name' => $this->input->post('spause_name'),
		'spause_income' => $this->input->post('spause_income'),
		'savings' => $this->input->post('savings'),
		'moveable_property' => $this->input->post('moveable_property'),
		'imovable_property' => $this->input->post('imovable_property'),
		'tax_details' => $this->input->post('tax_details'),
		'popose_facility' => $this->input->post('popose_facility'),
		'additional_facility' => $this->input->post('additional_facility'),
		'cus_type' => 'LOAN',



		);
		$this->db->where('cus_code', $this->input->post('cus_code'));
		$insert = $this->db->update('cm_customerms', $data);
		$this->db->where('cus_code',$this->input->post('cus_code'));
		$insert = $this->db->delete('cm_customerbank');
		if($this->input->post('bank1')!=""  ){
		$data2=array(
		'cus_code'=>$this->input->post('cus_code'),
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('cm_customerbank', $data2);

		}
		if($this->input->post('bank2')!=""  ){
		$data2=array(
		'cus_code'=>$this->input->post('cus_code'),
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('cm_customerbank', $data2);

		}
		return $insert;

	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity;
		if($id)
		{
		$data=array(


		'status' => CONFIRMKEY,
		);
		$this->db->where('cus_code', $id);
		$insert = $this->db->update('cm_customerms', $data);
		return $insert;
		}

	}
	function delete($id)
	{
		
		
		if($id)
		{
			$this->db->select('*');
			$this->db->where('cus_code',$id);
			$query = $this->db->get('re_resevation');
			if ($query->num_rows >0) {
					$this->session->set_flashdata('error', 'Already Have Reservations');
					redirect('cm/customer/showall');
				return false;
			}
		
		$this->db->select('id_copy_front,id_copy_back,customer_photo,signature');
		$this->db->where('cus_code',$id);
		$query = $this->db->get('cm_customerms');
		$customer = $query->row();

		$files = array(
			'uploads/customer_ids/'.$customer->id_copy_front,
			'uploads/customer_ids/thumbnail/'.$customer->id_copy_front,
			'uploads/customer_ids/'.$customer->id_copy_back,
			'uploads/customer_ids/thumbnail/'.$customer->id_copy_back,
			'uploads/customer_ids/'.$customer->customer_photo,
			'uploads/customer_ids/thumbnail/'.$customer->customer_photo,
			'uploads/customer_ids/'.$customer->signature,
			'uploads/customer_ids/thumbnail/'.$customer->signature,

		);
		foreach ($files as $file) {
		  if (file_exists($file)) {
			  unlink($file);
			  echo 'Image has been deleted successfully';
		  } else {
			  // File not found.
		  }
		}

		$this->db->where('cus_code', $id);
		$insert = $this->db->delete('cm_customerbank');
		$this->db->where('cus_code', $id);
		$insert = $this->db->delete('cm_customerms');
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
			 $newid=$prifix.str_pad(1, 6, "0", STR_PAD_LEFT);


			 }
			 else{
			 $prjid=substr($prjid,3,6);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 6, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 6, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;


	}

	function checkPendingcritical($customer_id){
		$this->db->select('cus_code');
		$this->db->where('cus_code', $customer_id)->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		$query = $this->db->get('cm_customerchangelog');

		if ($query->num_rows > 0 ){
			return $query->result();
		}else{
			return false;
		}
	}

	function count_all_pendings(){
		$this->db->select('cm_customerchangelog.id');
		$this->db->join('cm_customerms','cm_customerms.cus_code = cm_customerchangelog.cus_code');
		$this->db->where('approved_date IS NULL', NULL, FALSE)->group_by('cm_customerchangelog.cus_code');
		if(! check_access('all_branch')){
			$this->db->where('cm_customerms.cus_branch',$this->session->userdata('branchid'));
		}
		$query = $this->db->get('cm_customerchangelog');

		return $query->num_rows();

	}

	function get_pendings($per_page,$start){
		$this->db->select('cm_customerchangelog.cus_code,cm_customerms.cus_number,cm_customerms.cus_type,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.dob,cm_customerms.mobile,cm_customerms.id_number');
		$this->db->join('cm_customerms','cm_customerms.cus_code = cm_customerchangelog.cus_code');
		$this->db->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		if(! check_access('all_branch')){
			$this->db->where('cm_customerms.cus_branch',$this->session->userdata('branchid'));
		}
		$this->db->order_by('changed_date', 'desc')->group_by('cm_customerchangelog.cus_code')->limit($per_page, $start);
		$query = $this->db->get('cm_customerchangelog');
		return $query->result();

	}

	function cancel_changes($cus_code){

		//get new changhes
		$this->db->select('*');
		$this->db->where('cus_code', $cus_code)->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		$query = $this->db->get('cm_customerchangelog');

		foreach ($query->result() as $raw){


			//delete new images
			if ($raw->changed_field == 'id_copy_back' || $raw->changed_field == 'id_copy_front'){
				$files = array(
				  'uploads/customer_ids/'.$raw->new_val,
				  'uploads/customer_ids/thumbnail/'.$raw->new_val
				);

				foreach ($files as $file) {
				  if (file_exists($file)) {
					  unlink($file);

				  } else {
					  // File not found.
				  }
				}
			}
		}


		$this->db->where('cus_code',$cus_code)->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		$insert = $this->db->delete('cm_customerchangelog');
	}

	function get_pendingsbycustomer($cus_code){
		$this->db->select('*');
		$this->db->where('cus_code', $cus_code)->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		$query = $this->db->get('cm_customerchangelog');

		return $query->result();
	}

	function approve_all($cus_code){

		//get changes from cm_customerchangelog table and update cm_customerms table
		$this->db->select('*');
		$this->db->where('cus_code', $cus_code)->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		$query = $this->db->get('cm_customerchangelog');

		foreach ($query->result() as $raw){

			$changes[$raw->changed_field] = $raw->new_val;

			//delete old images
			if ($raw->changed_field == 'id_copy_back' || $raw->changed_field == 'id_copy_front' || $raw->changed_field == 'customer_photo' || $raw->changed_field == 'signature'){
				$files = array(
				  'uploads/customer_ids/'.$raw->prv_val,
				  'uploads/customer_ids/thumbnail/'.$raw->prv_val
				);

				foreach ($files as $file) {
				  if (file_exists($file)) {
					  unlink($file);

				  } else {
					  // File not found.
				  }
				}

				if (file_exists('uploads/temp/'.$raw->new_val)) {
					rename('uploads/temp/'.$raw->new_val, 'uploads/customer_ids/'.$raw->new_val);
				}
				if (file_exists('uploads/temp/thumbnail/'.$raw->new_val)) {
					rename('uploads/temp/thumbnail/'.$raw->new_val, 'uploads/customer_ids/thumbnail/'.$raw->new_val);
				}
			}
		}

		$this->db->where('cus_code',$cus_code);
		$this->db->update('cm_customerms',$changes);

		//Updated arroval user data
		$data = array(
			'approved_by' 	=> $this->session->userdata('username'),
			'approved_date' => date('Y-m-d')
		);
		$this->db->where('cm_customerchangelog.approved_date IS NULL', NULL, FALSE);
		$this->db->update('cm_customerchangelog',$data);
	}

	function deleteDoc($field,$cus_code){
		$data = array(
			$field 	=> ''
		);
		$this->db->where('cus_code',$cus_code);
		$this->db->update('cm_customerms',$data);
		echo 'deleted';
	}

	function check_id_number($id_type,$id_number){
		$this->db->select('cus_code');
		if($id_type!=''){
			$this->db->where('id_type', $id_type);
		}
		$this->db->where('id_number',$id_number);
		$query = $this->db->get('cm_customerms');

		if ($query->num_rows > 0 ){
			return true;
		}else{
			return false;
		}
	}

	//2019/10/22 Ticket 807 B.K.Dissanayake
	function updateMetOfficer($cus_id,$checkedVal){
		$data = array(
			'met_officer' => $checkedVal
		);
		$this->db->where('cus_code',$cus_id);
		$this->db->update('cm_customerms',$data);
	}


	//created by terance perera 2020-3-6 for call sheet
	function get_call_sheets($prj_id,$pagination_counter,$page_count){
    $this->db->select("re_call_sheet.*,re_projectms.project_name,hr_empmastr.initial,hr_empmastr.surname");
   	$this->db->from("re_call_sheet");
   	$this->db->join("hr_empmastr","re_call_sheet.added_by=hr_empmastr.id");
	 	$this->db->join("re_projectms","re_projectms.prj_id=re_call_sheet.project_id");
	if($prj_id!='ALL')
   	$this->db->where("re_call_sheet.project_id",$prj_id);
   	$this->db->order_by("call_sheet_id","DESC");
   	$this->db->limit($pagination_counter, $page_count);
     $query = $this->db->get();
	 if ($query->num_rows > 0 ){
			return $query->result();
		}else{
			return false;
		} 
	}

	function get_remarks($callsheetid){
    $this->db->select("re_call_sheet.*,re_projectms.project_name,hr_empmastr.initial,hr_empmastr.surname");
   	$this->db->from("re_call_sheet");
		$this->db->join("hr_empmastr","re_call_sheet.added_by=hr_empmastr.id");
	 	$this->db->join("re_projectms","re_projectms.prj_id=re_call_sheet.project_id");
	
   	$this->db->where("call_sheet_id",$callsheetid);
   	$query = $this->db->get();
	 if ($query->num_rows > 0 ){
			return $query->row();
		}else{
			return false;
		} 
	}
	function get_callsheetfollowlist($callsheetid)
	{
		$this->db->select("*");
   	$this->db->from("re_callsheetfollowups");
   	$this->db->where("call_sheet_id",$callsheetid);
   	$query = $this->db->get();
	 if ($query->num_rows > 0 ){
			return $query->result();
		}else{
			return false;
		} 
	}
		function add_followups()
	{
			 $insert_data = array(
			'call_sheet_id' => $this->input->post('call_sheet_id'),
			'emp_code' =>$this->session->userdata('username'),
			'follow_date' =>date('Y-m-d'),
			'contact_media' => $this->input->post('contact_media'),
			
			'cus_feedback' => $this->input->post('cus_feedback'),
			'sales_feedback' => $this->input->post('sales_feedback'),
			'create_date'=>date('Y-m-d'),
			'create_by '=>$this->session->userdata('username'),
		
			);
							//	$this->db->where('id',$thisdata->id);
			if ( ! $this->db->insert('re_callsheetfollowups', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			else 
			return true;
			
			 
	}
	function delete_callsheet($id)
	{
		if($id)
		{
			$this->db->where('call_sheet_id', $id);
			$insert = $this->db->delete('re_call_sheet');
			return $insert;
		}
	}
}
