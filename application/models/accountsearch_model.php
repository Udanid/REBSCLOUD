<?php

class Accountsearch_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
     
    }
	function get_parent_groupid($groupid)
	{
		 $this->db->select('parent_id');
      	$this->db->where("id",$groupid);
     
        $ledger_q = $this->db->get('ac_groups');
       if($ledger_q->num_rows() > 0){
		$data=$ledger_q->row();
			return $data->parent_id;
		}
		else
		return false;
		
	}
	function check_income_expence_ledger($ledgerid)
	{
		
		 $this->db->select('group_id');
 		$this->db->where("id",$ledgerid);
        $ledger_q = $this->db->get('ac_ledgers');
       if($ledger_q->num_rows() > 0){
			$data=$ledger_q->row();
			$groupid=$data->group_id;
			$parentid=$this->get_parent_groupid($data->group_id);
			while($parentid)
			{
				$groupid=$parentid;
				$parentid=$this->get_parent_groupid($groupid);
			}
			echo $groupid;
			if($groupid=='3' || $groupid=='4')
			{
				
				return false;
			}
			else 
			return true;
		}
		return false;
	}

    function get_all_ac_ledgers()
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
		$this->db->where("ac_ledgers.active",1);
        //$this->db->order_by('ac_groups.name','asc');
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
    
        $this->db->order_by('ac_ledgers.id','asc');
        $ledger_q = $this->db->get('ac_ledgers');
       if($ledger_q->num_rows() > 0){
		
			return $ledger_q->result();
		}
		else
		return false;
    }
	 function get_entry_type()
    {

        $options = array();
        $options[0] = "";
        $this->db->select('*');
          $ledger_q = $this->db->get('ac_entry_types');
       if($ledger_q->num_rows() > 0){
		
			return $ledger_q->result();
		}
		else
		return false;
    }
	 function get_project()
    {

        $options = array();
        $options[0] = "";
        $this->db->select('*');
		$this->db->where('status !=','DELETED');
          $ledger_q = $this->db->get(' 	re_projectms');
       if($ledger_q->num_rows() > 0){
		
			return $ledger_q->result();
		}
		else
		return false;
    }
	 function get_project_lots($prj_id)
    {

        $options = array();
        $options[0] = "";
        $this->db->select('*');
		$this->db->where('prj_id',$prj_id);
          $ledger_q = $this->db->get('re_prjaclotdata');
       if($ledger_q->num_rows() > 0){
		
			return $ledger_q->result();
		}
		else
		return false;
    }
	function get_recipet_data($ledgers)
	{			$amount=0;
				if($this->input->post('amount')!='')
				$amount=(float)$this->input->post('amount');
	$this->db->select('ac_entries.id,ac_entries.date,ac_entries.tag_id,ac_entries.cr_total,ac_entries.number,ac_entries.entry_type,ac_recieptdata.RCTNO,ac_recieptdata.RCTSTATUS,ac_recieptdata.CNBY,ac_recieptdata.CRBY,ac_trnreceipts.rcvname,ac_trnreceipts.temp_rctno,re_projectms.project_name,re_prjaclotdata.lot_number,ac_entry_items.amount');
			if(empty($ledgers))
			{
				
				$this->db->from('ac_entries');
				 $this->db->join('ac_entry_items',"ac_entries.id=ac_entry_items.entry_id");
				 
				
			}
			else
			{//echo 'test';
				$this->db->from('ac_entry_items');
				$this->db->join('ac_entries',"ac_entry_items.entry_id=ac_entries.id");
				
			 	
				$this->db->where_in('ac_entry_items.ledger_id',$ledgers);
				
			}
			  $this->db->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id');
		    $this->db->join('ac_trnreceipts','ac_trnreceipts.entryid=ac_entries.id');
			 $this->db->join('re_projectms','re_projectms.prj_id=ac_entries.prj_id','left');
			  $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=ac_entries.lot_id','left');
		//date Search
		
		 if($amount!=0 )
			  $this->db->where('ac_entry_items.amount',$amount);
			  
			  
			if($this->input->post('fromdate') != '' && $this->input->post('todate') != ''){
			$this->db->where('ac_entries.date >=',$this->input->post('fromdate'));
			$this->db->where('ac_entries.date <=',$this->input->post('todate'));
			}
			
			
			 if($this->input->post('rctno')!='')
			   $this->db->where('ac_recieptdata.RCTNO',$this->input->post('rctno'));
			
			
			
			  
			   if($this->input->post('project')!="" )
			  $this->db->where('ac_entries.prj_id',$this->input->post('project'));
			  
			   if($this->input->post('lot') !="" )
			  $this->db->where('ac_entries.lot_id',$this->input->post('lot'));
			  
			
			    if($this->input->post('payeename')!='')
			   $this->db->LIKE('ac_trnreceipts.rcvname',$this->input->post('payeename'));
			   if($this->input->post('entrynumber')!='')
			   $this->db->where('ac_entries.number',$this->input->post('entrynumber'));
		 
			$this->db ->order_by('date', 'desc');
		  	 $this->db->order_by('number', 'desc');
			   if(empty($ledgers))
			{
				$this->db->group_by('ac_entry_items.entry_id');
			}
			 
			 
			  $entry_q = $this->db->get();
			
		//	echo $this->db->last_query();
			
         	if ($entry_q->num_rows() > 0){
				
			
				$dataset= $entry_q->result();
				return $dataset;
				
			}
			else
			return false;
		   //$this->db->limit(30,0);
		
		
	}
	function get_payment_data()
	{
		$amount=0;
				if($this->input->post('amount')!='')
				$amount=(float)$this->input->post('amount');
		
		$this->db->select('ac_entries.id,ac_entries.date,ac_entries.tag_id,ac_entries.cr_total,ac_entries.number,ac_entries.entry_type,re_projectms.project_name,ac_entry_items.amount,ac_chqprint.CHQNO,ac_payvoucherdata.payeename');
			if(empty($ledgers))
			{
				
				$this->db->from('ac_entries');
				 $this->db->join('ac_entry_items',"ac_entries.id=ac_entry_items.entry_id");
				$this->db->group_by('ac_entry_items.entry_id');
				
			}
			else
			{//echo 'test';
				$this->db->from('ac_entry_items');
				$this->db->join('ac_entries',"ac_entry_items.entry_id=ac_entries.id");
				$this->db->where_in('ac_entry_items.ledger_id',$ledgers);
			}
			  $this->db->join('ac_chqprint','ac_entries.id=ac_chqprint.PAYREFNO');
		    $this->db->join('ac_payvoucherdata','ac_entries.id=ac_payvoucherdata.entryid');
			 $this->db->join('re_projectms','re_projectms.prj_id=ac_payvoucherdata.prj_id','left');
		//date Search
			if($this->input->post('fromdate') != '' && $this->input->post('todate') != ''){
			$this->db->where('ac_entries.date >=',$this->input->post('fromdate'));
			$this->db->where('ac_entries.date <=',$this->input->post('todate'));
			}
		
			 if($amount!=0 )
			  $this->db->where('ac_entry_items.amount',$amount);
			  
			   if($this->input->post('project')!="" )
			  $this->db->where('ac_payvoucherdata.prj_id',$this->input->post('project'));
			  
			  
			 if($this->input->post('chequeno')!='')
			   $this->db->where('ac_chqprint.CHQNO',$this->input->post('chequeno'));
			    if($this->input->post('payeename')!='')
			   $this->db->LIKE('ac_payvoucherdata.payeename',$this->input->post('payeename'));
			   if($this->input->post('entrynumber')!='')
			   $this->db->where('ac_entries.number',$this->input->post('entrynumber'));
		 
			$this->db ->order_by('date', 'desc');
		  	 $this->db->order_by('number', 'desc');
			  $entry_q = $this->db->get();
		
			
         	if ($entry_q->num_rows() > 0){
					// echo $this->db->last_query();
				$dataset= $entry_q->result();
				return $dataset;
				
			}
			else
			return false;
		   //$this->db->limit(30,0);
	}
	function get_other_data()
	{
	$amount=0;
				if($this->input->post('amount')!='')
				$amount=(float)$this->input->post('amount');
	$types=array('1,2');	
		$this->db->select('ac_entries.id,ac_entries.date,ac_entries.tag_id,ac_entries.cr_total,ac_entries.number,ac_entries.entry_type,re_projectms.project_name,ac_entry_items.amount,re_prjaclotdata.lot_number,ac_entry_types.name');
			if(empty($ledgers))
			{
				
				$this->db->from('ac_entries');
				 $this->db->join('ac_entry_items',"ac_entries.id=ac_entry_items.entry_id");
				$this->db->group_by('ac_entry_items.entry_id');
				
			}
			else
			{//echo 'test';
				$this->db->from('ac_entry_items');
				$this->db->join('ac_entries',"ac_entry_items.entry_id=ac_entries.id");
				$this->db->where_in('ac_entry_items.ledger_id',$ledgers);
			}
		 
			 if($this->input->post('type')!="")
			 $this->db->where('ac_entries.entry_type',$this->input->post('type'));
			 else
			 $this->db->where_not_in('ac_entries.entry_type',$types);
		//date Search
			if($this->input->post('fromdate') != '' && $this->input->post('todate') != ''){
			$this->db->where('ac_entries.date >=',$this->input->post('fromdate'));
			$this->db->where('ac_entries.date <=',$this->input->post('todate'));
			}
		
			 $this->db->join('ac_entry_types','ac_entry_types.id=ac_entries.entry_type','left');
		 	$this->db->join('re_projectms','re_projectms.prj_id=ac_entries.prj_id','left');
			 $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=ac_entries.lot_id','left');
			if($amount!=0 )
			  $this->db->where('ac_entry_items.amount',$amount);
			  
			   if($this->input->post('project')!="" )
			  $this->db->where('ac_entries.prj_id',$this->input->post('project'));
			  
			  
			   if($this->input->post('entrynumber')!='')
			   $this->db->where('ac_entries.number',$this->input->post('entrynumber'));
		 
			$this->db ->order_by('date', 'desc');
		  	 $this->db->order_by('number', 'desc');
			  $entry_q = $this->db->get();
			
			
         	if ($entry_q->num_rows() > 0){
				
				$dataset= $entry_q->result();
				return $dataset;
				
			}
			else
			return false;
		   //$this->db->limit(30,0);
	}
	
	
	
}
