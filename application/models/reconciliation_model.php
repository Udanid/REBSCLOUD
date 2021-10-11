<?php
// Created by Eranga on 06/06/2018
class Reconciliation_model extends CI_Model {

    function Reconciliation_model()
    {
        parent::__construct();

    }
	
	
    function getAlldebit($ledger_id,$showall,$limitmonth = '',$startdate='',$enddate='')
    {
		if($limitmonth=='thismonth') //if hihdeh trahnsachtions checkbox is checked
		{
			$firstdate = date("Y-m-01 00:00:00"); //fisrt date of the month
			
			$lastdate = date("Y-m-t 00:00:00"); //last date of the month
			
			
			if($showall=='1'){
				 
				//if show all checkbox is checked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_chqdata.CHQNO as RCVCHK');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('ac_trnreceipts', 'ac_trnreceipts.entryid =ac_entries.id','left')->join('ac_chqdata', 'ac_chqdata.ENTRYCODE =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','D')->where('ac_entries.date >=', $firstdate)->where('ac_entries.date <=', $lastdate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
				
			}else{
				
				//if show all checkbox is unchecked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_chqdata.CHQNO as RCVCHK');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('ac_trnreceipts', 'ac_trnreceipts.entryid =ac_entries.id','left')->join('ac_chqdata', 'ac_chqdata.ENTRYCODE =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','D')->where('ac_entry_items.reconciliation_date',NULL)->where('ac_entries.date >=', $firstdate)->where('ac_entries.date <=', $lastdate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
			}
			
		}else{ //if hidden trahnsachtions checkbox is unchecked
			
			if($showall=='1'){
				
				//if show all checkbox is checked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_chqdata.CHQNO as RCVCHK');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('ac_trnreceipts', 'ac_trnreceipts.entryid =ac_entries.id','left')->join('ac_chqdata', 'ac_chqdata.ENTRYCODE =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','D')->where('ac_entries.date >=', $startdate)->where('ac_entries.date <=', $enddate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
				
			}else{
				
				//if show all checkbox is unchecked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_chqdata.CHQNO as RCVCHK');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('ac_trnreceipts', 'ac_trnreceipts.entryid =ac_entries.id','left')->join('ac_chqdata', 'ac_chqdata.ENTRYCODE =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','D')->where('ac_entry_items.reconciliation_date',NULL)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
			}		
		}

    }
	
	function getAlldebitnew($ledger_id,$startdate='',$enddate=''){
		$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,ac_trnreceipts.rcvname,ac_chqdata.CHQNO as RCVCHK');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('ac_trnreceipts', 'ac_trnreceipts.entryid =ac_entries.id','left')->join('ac_chqdata', 'ac_chqdata.ENTRYCODE =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','D')->where('ac_entry_items.reconciliation_date',NULL)->where('ac_entries.date >=', $startdate)->where('ac_entries.date <=', $enddate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function getAllcredit($ledger_id,$showall,$limitmonth = '',$startdate='',$enddate='')
    {
		if($limitmonth=='thismonth') //if hihdeh trahnsachtions checkbox is checked
		{
			$firstdate = date("Y-m-01 00:00:00"); //first date of the month
			
			$lastdate = date("Y-m-t 00:00:00"); //last date of the month
			
			if($showall=='1'){
				
				//if show all checkbox is checked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','C')->where('ac_entries.date >=', $firstdate)->where('ac_entries.date <=', $lastdate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
				
			}else{
				
				//if show all checkbox is unchecked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','C')->where('ac_entry_items.reconciliation_date',NULL)->where('ac_entries.date >=', $firstdate)->where('ac_entries.date <=', $lastdate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
				
			}
		}else{
			//if hihdeh trahnsachtions checkbox is unchecked
			
			if($showall=='1'){
				
				//if show all checkbox is checked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','C')->where('ac_entries.date >=', $startdate)->where('ac_entries.date <=', $enddate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
				
			}else{
				
				//if show all checkbox is unchecked
				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','C')->where('ac_entry_items.reconciliation_date',NULL)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$query = $this->db->get();
				return $query->result();
				
			}
			
		}

    }
	
	function getAllcreditnew($ledger_id,$startdate='',$enddate=''){
		$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','C')->where('ac_entry_items.reconciliation_date',NULL)->where('ac_entries.date >=', $startdate)->where('ac_entries.date <=', $enddate)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	//get voucher number for entry_id
	function getVoucherbyentryID($entry_id){
		$this->db->select('ac_payvoucherdata.voucherid as voucher_ncode');
		$this->db->from('ac_payvoucherdata')->where('ac_payvoucherdata.entryid', $entry_id)->group_by('ac_payvoucherdata.entryid');
		$query = $this->db->get();
		if ($query->num_rows >0) {
            $data= $query->row();
					return $data->voucher_ncode;
        }
		else
		return ''; 
	}
	
	//update checked field in ac_entry_items table upon checked box action
	function updateCheck($entry_item_id,$ledger_id,$checkedval){
		
		$bankbalance = $this->getBankBalance($ledger_id); //get the value of bank balance column for the ledger id
		
		if ($checkedval=='true'){
			
			$data = array(
               'checked' => '1'
            );

			$this->db->where('id', $entry_item_id);
			$this->db->where('ledger_id', $ledger_id);
			$this->db->update('ac_entry_items', $data);
			
			//get amount and dc status
			$this->db->select('ac_entry_items.amount,ac_entry_items.dc');
			  $this->db->from('ac_entry_items')->where('ledger_id', $ledger_id)->where('ac_entry_items.id', $entry_item_id)->limit(1);
			  $query = $this->db->get();
			  if ($query->num_rows >0) {
				  $data= $query->row();
				  //$bankbalance = str_replace("-", "", $bankbalance);
				  	if ($data->dc == 'D'){
					  	$bankbalance = float_ops($bankbalance,$data->amount, '-'); //deduct amount if the transactions is Creditted
					}else{
						$bankbalance = float_ops($bankbalance,$data->amount,  '+'); //add amount if the gtransaction is debitted
					}
			  }
			 
			 //update bank balance field
			 //$this->updateBankbalance($ledger_id,$bankbalance); 
			
			
		}else{
			$data = array(
               'checked' => '0'
            );

			$this->db->where('id', $entry_item_id);
			$this->db->where('ledger_id', $ledger_id);
			$this->db->update('ac_entry_items', $data);
			
			//get amount and dc status
			$this->db->select('ac_entry_items.amount,ac_entry_items.dc');
			  $this->db->from('ac_entry_items')->where('ledger_id', $ledger_id)->where('ac_entry_items.id', $entry_item_id)->limit(1);
			  $query = $this->db->get();
			  if ($query->num_rows >0) {
				  $data= $query->row();
				  //$bankbalance = str_replace("-", "", $bankbalance);
				  	if ($data->dc == 'C'){
					  	$bankbalance = float_ops($bankbalance,$data->amount,  '-'); //add amount if the transactions is Creditted
					}else{
						$bankbalance = float_ops($bankbalance,$data->amount,  '+'); //deduct amount if the gtransaction is debitted
					}
			  }
			 
			 //update bank balance field
			 //$this->updateBankbalance($ledger_id,$bankbalance);
		}
		
	}
	
	//update bankbalance for ledger account
	function updateBankbalance($ledger_id,$bankbalance){
		$data = array(
		   'bankbalance' => $bankbalance
		);
		$this->db->where('id', $ledger_id);
		$this->db->update('ac_ledgers', $data);
		
		//get the ledger entry
		$this->db->select('ac_ledgers.bank_opbalance,ac_ledgers.bankbalance');
		$this->db->from('ac_ledgers')->where('ac_ledgers.id', $ledger_id);
		$query = $this->db->get();
		if ($query->num_rows >0) {
            $data= $query->row();
			//Runs when bank balance changed
			return bcsub ($data->bankbalance,$data->bank_opbalance,2);
			/*if($data->bankbalance < 0 && $data->bank_opbalance < 0){
				$amount =  number_format(float_ops( $data->bank_opbalance, $data->bankbalance,'+'),2,'.','');
				return $amount * -1;
			}else if($data->bankbalance < 0 && $data->bank_opbalance >= 0){
				$amount =  number_format(float_ops($data->bank_opbalance,$data->bankbalance, '-'),2,'.','');
				return  $amount;
			}*/
        }
	}
	
	//reconsile selected transactions
	function reconsileSelected($ledger_id,$bankbalance){
			
		//Update transactions with checked 1
		$data = array(
		   'reconciliation_date' => date('Y-m-d')
		);
		$this->db->trans_start();
		$this->db->where('checked', '1');
		$this->db->where('ledger_id', $ledger_id);
		$this->db->update('ac_entry_items', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}else{
			//update bank balances
			$data = array(
		   		'bank_opbalance' => $bankbalance,
				'bankbalance' => 0
			);
			$this->db->where('id', $ledger_id);
			$this->db->update('ac_ledgers', $data);
			return true;	
		}

	}
	
	//return all checked transactions
	function get_selected($type,$ledger_id){
		if($type=='debit'){
			
			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
			$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','D')->where('ac_entry_items.checked', '1')->where('ac_entry_items.reconciliation_date',NULL)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
			$query = $this->db->get();
			return $query->result();
			
		}else if($type=='credit'){
			
			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.id as ac_entry_items_id,ac_entry_items.checked as ac_entry_items_checked, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date,ac_chqprint.CHQNO,ac_chqprint.CHQNAME ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
			$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc','C')->where('ac_entry_items.checked', '1')->where('ac_entry_items.reconciliation_date',NULL)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
			$query = $this->db->get();
			return $query->result();
		
		}
	}
	
	//get the value of bank balance column in ledger accounts
	function getBankBalance($ledger_id){
		$this->db->select('ac_ledgers.bankbalance');
		$this->db->from('ac_ledgers')->where('ac_ledgers.id', $ledger_id);
		$query = $this->db->get();
		if ($query->num_rows >0) {
            $data= $query->row();
					return $data->bankbalance;
        }
		else
		return '';	
	}
	
	function getBankopBalance($ledger_id){
		$this->db->select('ac_ledgers.bank_opbalance');
		$this->db->from('ac_ledgers')->where('ac_ledgers.id', $ledger_id);
		$query = $this->db->get();
		if ($query->num_rows >0) {
            $data= $query->row();
					return $data->bank_opbalance;
        }
		else
		return '';	
	}

	
	function getChecked($ledger_id){
		$this->db->select('ac_entry_items.amount,ac_entry_items.dc');
		$this->db->from('ac_entry_items')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.checked', '1');
		$query = $this->db->get();
		if ($query->num_rows >0) {
            return $query->result();
					
        }
	}

}
