<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Branch_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_branches_summery() { //get all stock
		$this->db->select('branch_code,branch_name,shortcode');
		$this->db->order_by('branch_code');
		$query = $this->db->get('cm_branchms'); 
		return $query->result(); 
    }
	function get_all_branches_details($pagination_counter, $page_count) { //get all stock
		$this->db->select('*');
		$this->db->order_by('branch_code');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_branchms'); 
		return $query->result(); 
    }
	function get_branchdata_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('branch_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_branchms'); 
		return $query->row(); 
    }
	function get_branch_name($code) { //get all stock
		$this->db->select('*');
		$this->db->where('branch_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_branchms'); 
		
		$data=$query->row(); 
		return $data->branch_name;
    }
	function check_shortcode($code)
	{
		$this->db->select('*');
		$this->db->order_by('branch_code');
		$this->db->where('shortcode',$code);
		$query = $this->db->get('cm_branchms'); 
		 if ($query->num_rows >0) {
            return true;
        }
		else
		return false; 
	}
	
	function add()
	{
		//$tot=$bprice*$quontity; 
		$id=$this->getmaincode('branch_code','BRN','cm_branchms');
		$data=array( 
		'branch_code'=>$id,
		'create_date' => date("Y-m-d"),
		'branch_name' => $this->input->post('branch_name'),
		'shortcode' => $this->input->post('shortcode'),
		'short_description' => $this->input->post('short_description'),
		'location_map' => $this->input->post('location_map'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'Contact_number' => $this->input->post('Contact_number'),
		'fax' => $this->input->post('fax'),
		'email' => $this->input->post('email'),
		'create_by' => $this->session->userdata('username'),
		
		);
		$insert = $this->db->insert('cm_branchms', $data);
		return $id;
		
	}
	function edit()
	{
		//$tot=$bprice*$quontity; 
		$id=$this->getmaincode('branch_code','BRN','cm_branchms');
		$data=array( 
		
		'branch_name' => $this->input->post('branch_name'),
	
		'short_description' => $this->input->post('short_description'),
		'location_map' => $this->input->post('location_map'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'Contact_number' => $this->input->post('Contact_number'),
		'fax' => $this->input->post('fax'),
		'email' => $this->input->post('email'),
		'create_by' => $this->session->userdata('username'),
		
		);
		$this->db->where('branch_code', $this->input->post('branch_code'));
		$insert = $this->db->update('cm_branchms', $data);
		return $insert;
		
	}
	function get_order_by_code($pocode) { //get all stock
		$this->db->select('pomaster.*,dlrms.DLRFNAME ,dlrms.DLRLNAME');
		$this->db->join('dlrms ', 'dlrms.DLRCODE = pomaster.DLRCODE','left');
	//	$this->db->where('inventory.BRNCODE',$this->session->userdata('branchid'));
		$this->db->where('pomaster.POCODE',$pocode);
		$query = $this->db->get('pomaster'); 
		return $query->row(); 
    }
	function get_supplier_po_for_return($dlrcode) { //get all stock
		$this->db->select('pomaster.*');
		
	//	$this->db->where('inventory.BRNCODE',$this->session->userdata('branchid'));
		$this->db->where('pomaster.DLRCODE',$dlrcode);
		$this->db->where('pomaster.POSTATUS !=','PENDING');
		$query = $this->db->get('pomaster'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
    }
	function get_current_po($pocode)
	{
			$this->db->select('podata.*,itmms.ITMDIS');
			$this->db->join('itmms ', 'itmms.ITMCODE = podata.ITMCODE','left');
			$this->db->where('podata.POCODE ',$pocode);
		//$this->db->order_by('pomaster.PODATE','DESC');
		$query = $this->db->get('podata'); 
		return $query->result();
	}
	function get_po_price($pocode)
	{
		$this->db->select('ITMCODE,QTPRICE');
		$this->db->where('podata.POCODE ',$pocode);
		//$this->db->order_by('pomaster.PODATE','DESC');
		$query = $this->db->get('podata');
		$price=NULL; 
		 if ($query->num_rows >0) {
            $dataset= $query->result();
			foreach($dataset as $raw)
			{
				$price[$raw->ITMCODE]=$raw->QTPRICE;
			}
			return $price;
        }
		else
		return false; 
		
	}
	
	function insert_po($tot)
	{
		//$tot=$bprice*$quontity; 
		$id=$this->getmaincode('POCODE','PUR','pomaster');
		$data=array( 
		'POCODE'=>$id,
		'PODATE' => date("Y-m-d H:i:s"),
		'DLRCODE' => $this->input->post('DLRCODE'),
		'TOTAMOUNT' => $tot,
		'BRNCODE' => $this->session->userdata('branchid'),
		'CRBY' => $this->session->userdata('username'),
		'POSTATUS' => 'PENDING',
		);
		$insert = $this->db->insert('pomaster', $data);
		return $insert;
		
	}
	function insert_po_data($id,$itemcode,$qnt,$price)
	{
		$data=array( 
		'POCODE'=>$id,
		'ITMCODE' => $itemcode,
		'QTPRICE' =>$price,
		'POQNT' => $qnt,
		'STATUS' => 'PENDING',
		);
		$insert = $this->db->insert('podata', $data);
		return $insert;
		
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
			 $newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		

			 }
			 else{
			// $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=str_pad($newid, 4, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;
	
	}
}