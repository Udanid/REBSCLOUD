<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

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
	function validate_username($username) { //validate exsiting for usernames
		$this->db->select('USRNAME');
		$this->db->where('USRNAME', $username);
		$query = $this->db->get('cm_userdata');
		if ($query->num_rows >0) {
				return TRUE;
		}
       
		else
		return false; //if no matching records
}
	//Added by Eranga
	function validate_password($password) { //validate passowrd
		$password = $this->encryption->encode($password);
		//echo $password;
		$this->db->select('cm_userdata.USRNAME,cm_userdata.USRID,cm_userdata.USRPW,cm_userdata.USRTYPE,cm_userdata.BRNCODE,cm_usertype.module,cm_branchms.branch_name,cm_branchms.shortcode');
		$this->db->where('USRNAME', $this->session->userdata('username'));
		$this->db->join('cm_usertype','cm_userdata.USRTYPE =cm_usertype.usertype','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code =cm_userdata.BRNCODE','left');
		$this->db->where('USRPW',$password );   
		$query = $this->db->get('cm_userdata');
		$result = $query->result();
		return $result;
	}
	
	function validate_ip() {
		$host= gethostname();
		$ip = gethostbyname($host);
		$this->db->select('CSHID');
		$this->db->where('CSHIP', $ip);  
		$this->db->where('STATUS', '1');
		$query = $this->db->get('cshms');
		if ($query->num_rows >0) {
			return $query; //if passowrd match return the values
		}
	}
	
	function recover(){
		$query = $this->db->select('USRID,BRNCODE')->where('USRNAME', $this->input->post('username'))->get('cm_userdata');
		$result = $query->row();
		if ($query->num_rows() > 0) {
			$data = array(
				'USRID' => $result->USRID
			);
			$this->db->insert('cm_passwordreset',$data);
			
			//$newpassword = $this->generateRandomString();
			//$newpassword = 'Admin1';
			//$data = array( // get feild values to an array
				//'password'=>$this->encryption->encode($newpassword),
			  //);
			//$this->db->where('id',$result->id );
			//$this->db->update('admins', $data);
			
			//$send = array($result->email,$newpassword);
			return $result;
		}
		else
		{	
			return false; //if no matching records
		}
	}
//Ticket No-2502 | Added By Uvini
	function getdisplayname($username)
	{
		$this->db->select('USRID');
		$this->db->where('USRNAME', $username);
		$query = $this->db->get('cm_userdata');
		if ($query->num_rows >0) {
			foreach ($query->result_array () as $row)
			{
				$usrid = $row['USRID'];
			}
			$this->db->select('display_name,initial,surname');
			$this->db->where('id',$usrid);
			$this->db->from('hr_empmastr');
			return $this->db->get()->result_array();
		}

	}
}