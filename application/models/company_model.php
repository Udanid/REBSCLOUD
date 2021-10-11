<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->library('encryption');
	}
	function validate_company($companycode)
	{
		$this->db->select('*');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
			return	$query->row();
		}
       
		else
		return false;
	}
	function get_company_project_count() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('project_count');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
				$data=$query->row();
				return $data->project_count;
		}
       
		else
		return 0; //if no matching records
	}
	function get_company_user_count() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('user_count');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
				$data=$query->row();
				return $data->user_count;
		}
       
		else
		return 0; //if no matching records
	}
	function profit_outright_method() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('profit_outright');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
				$data=$query->row();
				return $data->profit_outright;
		}
       
		else
		return 0; //if no matching records
	}
	function  	profit_agreement_method() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('profit_agreement');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
				$data=$query->row();
				return $data->profit_agreement;
		}
       
		else
		return 0; //if no matching records
	}
	function  	sms_status() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('sms_include');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
				$data=$query->row();
				return $data->sms_include;
		}
       
		else
		return 0; //if no matching records
	}
	function  	check_project_count() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('COUNT(prj_id) as project_count');
		$this->db->where('status', 'CONFIRMED');
		$this->db->where('sales_cml_status', 'PENDING');
		$query = $this->db->get('re_projectms');
		if ($query->num_rows >0) {
				$data=$query->row();
				$count=$data->project_count;
				$maxlimit=0;
				$this->db->select('project_count ');
				$this->db->where('company_code', $companycode);
				$query = $this->db->get('cld_company_data');
				if ($query->num_rows >0) {
					$data=$query->row();
				$maxlimit= $data->project_count ;
				}
				if($maxlimit>$count)
				return true;
				else
				return false;
				
				
		}
       
		else
		return true; //if no matching records
	}
	function  	check_user_count() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('COUNT(USRID) as usercount');
		$this->db->where('sys_flg', '1');
		$query = $this->db->get('cm_userdata');
		if ($query->num_rows >0) {
				$data=$query->row();
				$count=$data->usercount;
				$maxlimit=0;
				$this->db->select('user_count');
				$this->db->where('company_code', $companycode);
				$query = $this->db->get('cld_company_data');
				if ($query->num_rows >0) {
					$data=$query->row();
				$maxlimit= $data->user_count +1;
				}
				if($maxlimit>$count)
				return true;
				else
				return false;
				
				
		}
       
		else
		return true; //if no matching records
	}
	function get_company_all_data() { 
		$companycode=$this->session->userdata('companycode');
		$this->db->select('*');
		$this->db->where('company_code', $companycode);
		$query = $this->db->get('cld_company_data');
		if ($query->num_rows >0) {
				$data=$query->row();
				return $query->row();;
		}
       
		else
		return false; //if no matching records
	}
}