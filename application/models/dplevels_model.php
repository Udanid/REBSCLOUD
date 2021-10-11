<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dplevels_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_dplevels()
	{
		$this->db->select('*');
		$this->db->order_by('dp_rate','DESC');
		//$this->db->order_by('product_code,task_code');
		
		$query = $this->db->get('cm_dplevels'); 
		
		return $query->result(); 
	}
	
		function get_dplevels_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('dp_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_dplevels'); 
		return $query->row(); 
    }
		function edit()
	{
	
			 $data=array( 
		  
		  'dp_ratio' => $this->input->post('dp_ratio'),
		  'months12' => $this->input->post('months12'),
		  'months24' => $this->input->post('months24'),
		  'months36' => $this->input->post('months36'),
		  'months48' => $this->input->post('months48'),
		  'months60' => $this->input->post('months60'),
		  'months72' => $this->input->post('months72'),
		  'months84' => $this->input->post('months84'),
		  'months96' => $this->input->post('months96'),
		
		
		  );
		
		$this->db->where('dp_id', $this->input->post('dp_id'));
		$insert = $this->db->update('cm_dplevels', $data);
		return $insert;
		
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
}