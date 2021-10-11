<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banktrn_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_bank_trnlist($branchid) { //get all st ock
		$this->db->select('SUM(re_banktransfers.trn_amount) as amount,ac_entries.narration,re_banktransfers.trn_bank,re_banktransfers.trn_entryid,ac_entries.date');
		if(! check_access('all_branch'))
		$this->db->where('re_banktransfers.branch_code',$branchid);
		$this->db->join('ac_entries','ac_entries.id=re_banktransfers.trn_entryid');
		$this->db->group_by('re_banktransfers.trn_entryid');
		$this->db->group_by('re_banktransfers.trn_bank');

		$query = $this->db->get('re_banktransfers');
		if ($query->num_rows >0) {
           return $query->result();
        }
		else
		return false;

    }
	function get_pending_trnlist($branchid) { //get all stock
		$this->db->select('re_prjacincome.*');
		//Ticket No:3086 Updated By Madushan 2021-07-13
		if($branchid != 'all')
			$this->db->where('re_prjacincome.branch_code',$branchid);
		$this->db->where('re_prjacincome.trn_status !=','COMPLETE');
		$this->db->where('re_prjacincome.pay_status','PAID');
			$this->db->join('ac_entry_items','ac_entry_items.entry_id=re_prjacincome.entry_id and ac_entry_items.ledger_id="HEDBA15002100" and ac_entry_items.dc="D"');
			$this->db->limit(100,0);
		//$this->db->order_by('income_date','DESC');
    $this->db->order_by('re_prjacincome.entry_date','DESC');
    $this->db->order_by('ac_entry_items.entry_id','DESC');

		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows >0) {
           return $query->result();
        }
		else
		return false;
    }
	function search_bank_trnlist($branchid) { //get all stock
		$this->db->select('SUM(re_banktransfers.trn_amount) as amount,ac_entries.narration,re_banktransfers.trn_bank,re_banktransfers.trn_entryid,ac_entries.date');
		$this->db->where('re_banktransfers.branch_code',$branchid);
		$this->db->join('ac_entries','ac_entries.id=re_banktransfers.trn_entryid');
		$this->db->group_by('re_banktransfers.trn_entryid');
		$this->db->group_by('re_banktransfers.trn_bank');

		$query = $this->db->get('re_banktransfers');
		if ($query->num_rows >0) {
           return $query->result();
        }
		else
		return false;
    }
		function search_entry($trn_entryid) { //get all stock
		$this->db->select('re_banktransfers.*,re_prjacincome.rct_no,re_prjacincome.amount,re_prjacincome.trn_amount as fulltrn,re_prjacincome.bal_amount,re_prjacincome.trn_status');
		$this->db->where('re_banktransfers.trn_entryid',$trn_entryid);
		$this->db->join('re_prjacincome','re_prjacincome.id=re_banktransfers.income_id');

		$query = $this->db->get('re_banktransfers');
		if ($query->num_rows >0) {
           return $query->result();
        }
		else
		return false;
    }

	function add_transfer($branch_code,$income_id,$trn_bank,$trn_amount,$trn_entryid,$trn_date)
	{
		//$tot=$bprice*$quontity;
		$data=array(
		'branch_code'=>$branch_code,
		'income_id' =>$income_id,
		'trn_bank' => $trn_bank,
		'trn_amount' => $trn_amount,
		'trn_entryid' =>$trn_entryid,
		'trn_date' => $trn_date,
		'trn_by' => $this->session->userdata('username'),

		);
		$insert = $this->db->insert('re_banktransfers', $data);
		return $insert;

	}
	function update_incometable($pay_id,$trn_amount,$bal_amount,$trn_status)
	{
		//$tot=$bprice*$quontity;
			$data=array(

		'trn_amount' => $trn_amount,
		'bal_amount' => $bal_amount,
		'trn_status' => $trn_status,


		);
		$this->db->where('id', $pay_id);
		$insert = $this->db->update('re_prjacincome', $data);
		return $insert;

	}
	function get_incommedata($id) { //get all stock
		$this->db->select('*');
		$this->db->where('id',$trn_entryid);

		$query = $this->db->get('id');
		if ($query->num_rows >0) {
           return $query->result();
        }
		else
		return false;
    }
	function delete_transfer($id)
	{
		if($id)
		{
			$datalist=$this->search_entry($id);
			if($datalist){
				foreach($datalist as $raw)
				{
					$trn_amount=$raw->trn_amount;
					$fulltrn=$raw->fulltrn;
					$bal_amount=$raw->bal_amount;
					$amount=$raw->amount;
					if($fulltrn>=$trn_amount)
					{
						$new_trn=$fulltrn-$trn_amount;
					}
					else
					$new_trn=0;
					$newbal=$amount-$new_trn;
					$status='PROCESSING';
					$this->update_incometable($raw->income_id,$new_trn,$newbal,$status);
				}
				$this->db->where('trn_entryid',$id);
				$this->db->delete('re_banktransfers');
			}
			$this->db->where('entry_id',$id);
				$this->db->delete('ac_entry_items');
				$this->db->where('id',$id);
				$this->db->delete('ac_entries');
				return true;
		}
		return false;
	}

	/*Ticket No:2943 Added By Madushan 2021.06.21*/
	  function get_pending_trnlist_by_receiptno($branchid,$receiptno){ //get all stock

		$this->db->select('re_prjacincome.*');
		if($branchid != 'all')
			$this->db->where('re_prjacincome.branch_code',$branchid);
		$this->db->where('re_prjacincome.trn_status !=','COMPLETE');
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->like('rct_no',$receiptno);
			$this->db->join('ac_entry_items','ac_entry_items.entry_id=re_prjacincome.entry_id and ac_entry_items.ledger_id="HEDBA15002100" and ac_entry_items.dc="D"');
			//$this->db->limit(100,0);
		$this->db->order_by('income_date','DESC');

		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows >0) {
           return $query->result();
        }
		else
		return false;
    }
    /*End of Ticket No:2943*/

}
