<?php

class Export_model extends CI_Model {

    function Export_model()
    {
        parent::__construct();
     
    }

 function get_all_ac_ledgersfull_name($id)
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_qbledgercode.*');
    	$this->db->where("ac_qbledgercode.ledger_id",$id);
      	
         $query = $this->db->get('ac_qbledgercode');
        if ($query->num_rows >0) {
			$data=$query->row();
			
			//$gname=$data->gname;
			$name=$data->name;
            return $name;
        }
		else
		return '';; 
    }
    function get_all_ac_ledgersfull_name_back($id)
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname,ac_groups.id as gid ');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
		$this->db->where("ac_ledgers.id",$id);
      	
        $this->db->order_by('ac_ledgers.id','asc');
        $query = $this->db->get('ac_ledgers');
        if ($query->num_rows >0) {
			$data=$query->row();
			if($data->gid!=0){
				
			$gname=$this->get_full_group_name($data->gid);
			}
			//$gname=$data->gname;
			$name=$gname.':'.$data->name;
            return $name;
        }
		else
		return '';; 
    }
	 function get_full_group_name($id)
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_groups.*');
   //     $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
		$this->db->where("ac_groups.id",$id);
         $query = $this->db->get('ac_groups');
        if ($query->num_rows >0) {
			$data=$query->row();
			if($data->parent_id!=0){
				
			$name=$this->get_full_group_name($data->parent_id).':'.$data->name;
			}
			else 
			{
				$name=$data->name;
			}
            return $name;
        }
		else
		return ''; 
    }
	
	function get_entires($stdate,$enddate)
    {
$types=array(1,3,4,6,7,8,9);
       $this->db->select('ac_entries.*,re_prjaclotdata.lot_number,re_projectms.project_name,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_trnreceipts.rcvmode,ac_chqprint.CHQNAME,ac_chqprint.CHQNO');
    	$this->db->where("ac_entries.date >=",$stdate);
		$this->db->where("ac_entries.date <=",$enddate);
		$this->db->where_in("ac_entries.entry_type",$types);
		  $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = ac_entries.lot_id','left');
		   $this->db->join('re_projectms','re_projectms.prj_id = ac_entries.prj_id','left');
		   $this->db->join('ac_recieptdata','ac_recieptdata.RCTREFNO = ac_entries.id','left');
		    $this->db->join('ac_trnreceipts','ac_trnreceipts.entryid = ac_entries.id','left');
			  $this->db->join('ac_chqprint','ac_chqprint.PAYREFNO = ac_entries.id','left');
	    $query = $this->db->get('ac_entries');
        if ($query->num_rows >0) {
			
            return $query->result();
        }
		else
		return false; 
    }
	function get_Payment_entires($stdate,$enddate)
    {
//$types=array(1,2,4)
       $this->db->select('ac_entries.*,re_projectms.project_name,ac_payvoucherdata.payeename,ac_payvoucherdata.paymenttype,ac_chqprint.CHQNAME,ac_chqprint.CHQNO');
    	$this->db->where("ac_entries.date >=",$stdate);
		$this->db->where("ac_entries.date <=",$enddate);
		$this->db->where("ac_entries.entry_type ",'2');
		    $this->db->join('ac_chqprint','ac_chqprint.PAYREFNO = ac_entries.id','left');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.entryid = ac_entries.id','left');
			$this->db->join('re_prjacpaymentdata','re_prjacpaymentdata.voucherid = ac_payvoucherdata.voucherid','left');
			
			$this->db->join('re_projectms','re_projectms.prj_id = re_prjacpaymentdata.prj_id','left');
			
         $query = $this->db->get('ac_entries');
        if ($query->num_rows >0) {
			
            return $query->result();
        }
		else
		return false; 
    }
	function get_entires_cancel($stdate,$enddate)
    {
//$types=array(1,2,4)
       $this->db->select('ac_entries.*,re_prjaclotdata.lot_number,re_projectms.project_name,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_trnreceipts.rcvmode,ac_chqprint.CHQNAME,ac_chqprint.CHQNO');
    	$this->db->where("ac_entries.date >=",$stdate);
		$this->db->where("ac_entries.date <=",$enddate);
		$this->db->where("ac_entries.entry_type ",'5');
		  $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = ac_entries.lot_id','left');
		   $this->db->join('re_projectms','re_projectms.prj_id = ac_entries.prj_id','left');
		   $this->db->join('ac_recieptdata','ac_recieptdata.CNREFNO = ac_entries.id','left');
		    $this->db->join('ac_trnreceipts','ac_trnreceipts.entryid = ac_recieptdata.RCTREFNO','left');
			  $this->db->join('ac_chqprint','ac_chqprint.CANFERNO = ac_entries.id','left');
         $query = $this->db->get('ac_entries');
        if ($query->num_rows >0) {
			
            return $query->result();
        }
		else
		return false; 
    }
	function get_entires_items($id)
    {

       $this->db->select('ac_entry_items.*');
    	$this->db->where("ac_entry_items.entry_id ",$id);
         $query = $this->db->get('ac_entry_items');
        if ($query->num_rows >0) {
			
            return $query->result();
        }
		else
		return false; 
    }
	
	function get_all_groups()
	{
		 $this->db->select('ac_groups.*');
   //     $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
	//	$this->db->limit(5,0);
         $query = $this->db->get('ac_groups');
        if ($query->num_rows >0) {
			$data=$query->result();
			
            return $query->result();
        }
		else
		return false; 
	}
     function get_full_group_name_all($id)
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_groups.*');
   //     $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
		$this->db->where("ac_groups.id",$id);
         $query = $this->db->get('ac_groups');
        if ($query->num_rows >0) {
			$data=$query->row();
			if($data->parent_id!=0){
				
			$name=$this->get_full_group_name_all($data->parent_id).':'.$data->name;//.$this->get_full_group_name($data->id);
			}
			else 
			{
				$name=$data->name;
			}
            return $name;
        }
		else
		return ''; 
    }
}
