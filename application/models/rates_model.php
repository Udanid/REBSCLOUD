<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class rates_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_rates()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');

		$query = $this->db->get('cm_rates');
		return $query->result();
	}

		function get_rates_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('rate_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_rates');
		return $query->row();
    }
		function edit()
	{

			 $data=array(

		  'rate' => $this->input->post('rate'),
		 'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,


		  );

		$this->db->where('rate_id', $this->input->post('rate_id'));
		$insert = $this->db->update('cm_rates', $data);
		return $insert;

	}
function get_rate_name($name)
{
	$this->db->select('rate');
		$this->db->where('name',$name);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_rates');
		$data= $query->row();
		return  $data->rate;
}
function get_loan_rates()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');

		$query = $this->db->get('re_saletype');
		return $query->result();
	}

		function get_loan_rates_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_saletype');
		return $query->row();
    }
		function edit_loan_rates()
	{

			 $data=array(
		  'delay_int' => $this->input->post('delay_int'),
			 'grace_period' =>$this->input->post('grace_period'),
			'default_int' =>$this->input->post('default_int'),
		  );

		$this->db->where('id', $this->input->post('id'));
		$insert = $this->db->update('re_saletype', $data);
		return $insert;

	}
	function update_reledgers($type)
	{
		$this->db->select('*');
		$query = $this->db->get($type.'_lederset');
			if ($query->num_rows() > 0){
				$dataset=$query->result();
				foreach($dataset as $raw)
				{
					$craccount=$this->input->post('selectCr'.$raw->id);
					$draccount=$this->input->post('selectDr'.$raw->id);
				//	echo $craccount;
					if($craccount!="" & $draccount!="")
					{
						 $data=array(
						  'Cr_account' => $craccount,
							 'Dr_account' =>$draccount,

						  );

						$this->db->where('id', $raw->id);
							$insert = $this->db->update($type.'_lederset', $data);
					}

				}
				return true;
			}
			else
			return false;


	}
 function getmaincode($idfield,$prifix,$table,$fildname)
	{

 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table ."  where ".$fildname."='".$prifix."'");

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			  $id=intval($data->id);
			 if($data->id==NULL)
			 {
				 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);


			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			 $id=intval($id);
			 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 3, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;

	}
  function add_grace_period($type,$statues)
  {
    $data = array('grace_period_effectto_di' =>$statues , );
    $this->db->where('type',$type);
    $this->db->update('re_saletype',$data);
    return true;
  }
  function edit_rate_special($id,$value)
	{
	//echo $value;
			 $data=array( 
		  
		  'rate' => $value,
		 'update_by' =>$this->session->userdata('username'),
		'last_update' =>date("Y-m-d") ,
		
		
		  );
		
		$this->db->where('rate_id', $id);
		$insert = $this->db->update('cm_rates', $data);
		return $insert;
		
	}
	function get_recipet_configuration()
	{
		$this->db->select('*');
		  $this->db->where('type','RECEIPT');
		$query = $this->db->get('cm_printconfig');
		if ($query->num_rows >0) {
           return $query->row();
        }
		else
		return false;
	}
	function get_voucher_configuration()
	{
		$this->db->select('*');
		  $this->db->where('type','VOUCHER');
		$query = $this->db->get('cm_printconfig');
		if ($query->num_rows >0) {
           return $query->row();
        }
		else
		return false;
	}
	function update_printconfig()
	{
	//echo $value;
			 $data=array( 
		  
		  'include_logo' => $this->input->post('v_include_logo'),
		 'include_header' =>$this->input->post('v_include_header'),
		'include_acknowledge' =>$this->input->post('v_include_acknowledge') ,
		
		
		  );
		
		$this->db->where('type', 'VOUCHER');
		$insert = $this->db->update('cm_printconfig', $data);
		
		
		
		 $data=array( 
		  
		  'include_logo' => $this->input->post('r_include_logo'),
		 'include_header' =>$this->input->post('r_include_header'),
		'nonrefund_include' =>$this->input->post('r_nonrefund_include') ,
		'loan_balanceinclude' =>$this->input->post('r_loan_balanceinclude') ,
		
		
		  );
		
		$this->db->where('type', 'RECEIPT');
		$insert = $this->db->update('cm_printconfig', $data);
		return $insert;
		
	}
	
}
