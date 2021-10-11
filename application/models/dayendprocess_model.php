<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class dayendprocess_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function getcompanylist()
	{
		$otherdb=$this->load->database('default', TRUE);
		$otherdb->select('company_code');
		$otherdb->where('status','Active');
		$query = $otherdb->get('cld_company_data'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
		
	}
	function add_cronjob($start,$database)
	{
		$otherdb=$this->load->database($database, TRUE);
		//$tot=$bprice*$quontity; 
		$data=array( 
		'cron_date'=>$start,
		'status' => 'RUN',
		
		);
		$insert = $otherdb->insert('cm_crontest', $data);
		return $insert;
		
	}
	function get_last_cron($database) { 
		$otherdb=$this->load->database($database, TRUE);
		$otherdb->select('MAX(cron_date) as lastupdate');
			$query = $otherdb->get('cm_crontest'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false; 
    }
	function get_today_int_transfer_list($date,$database) { //get all stock
		$otherdb=$this->load->database($database, TRUE);
		
		$otherdb->select('re_eploanpayment.*,re_eploanshedule.deu_date,re_eploanshedule.instalment,re_eploan.res_code,re_eploan.reschdue_sqn as current_squ');
		$otherdb->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$otherdb->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
		$otherdb->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
		$otherdb->where('re_eploan.loan_status','CONFIRMED');
		$otherdb->where('re_eploanshedule.deu_date',$date);
		$otherdb->where('re_prjacincome.pay_status','PAID');
		$query = $otherdb->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_account_set($name,$database)
	{
		$otherdb=$this->load->database($database, TRUE);
		$otherdb->select('*');
		$otherdb->where('Description',$name);
		
		
		$query = $otherdb->get('re_lederset'); 
		 if ($query->num_rows >0) {
            $data= $query->row();
			$acc=array('Cr_account'=>'HED'.$data->Cr_account,
			'Dr_account'=>'HED'.$data->Dr_account);
			return $acc;
        }
		else
		return false; 
	}
	function get_resevation($id,$database) { //get all stock
		$otherdb=$this->load->database($database, TRUE);
		$otherdb->select('*');
		$otherdb->where('res_code',$id);
		$query = $otherdb->get('re_resevation'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function insert_pay_enties($pay_id,$entry_id,$type,$database)
	{//
		$otherdb=$this->load->database($database, TRUE);
			$insert_status = array(
				'pay_id ' => $pay_id,
				'entry_id' => $entry_id,
				'type' => $type,	
			);
			if ( !$otherdb->insert('re_paymententries', $insert_status))
			{
				$otherdb->trans_rollback();
				
			}
	
	}
	
	function next_entry_number($entry_type_id,$database)
 	{
		$otherdb=$this->load->database($database, TRUE);
 		 $last_no_q = $otherdb->query("SELECT MAX(CONVERT(number, SIGNED)) as lastno  FROM  ac_entries where entry_type='".$entry_type_id."'");
 			 //$last_no_q = $this->db->get();
  			if ($row = $last_no_q->row())
  			{
  				 $last_no = $row->lastno;
  				 $last_no++;
  				 return $last_no;
 			 } else {
  			 return 1;
  			}
 	}
	function jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id,$res_code,$database)
	{
		$otherdb=$this->load->database($database, TRUE);
		$data_number=$this->next_entry_number(4,$database);
		if($prj_id=='')
		$prj_id=0;
		if($lot_id=='')
		$lot_id=0;
		if($res_code=='')
		$res_code=0;
		$$otherdb->trans_start();
			$insert_data = array(
				'number' => $data_number,
				'date' => $date,
				'narration' => $narration,
				'entry_type' => 4,
				'lot_id' =>$lot_id,
				'prj_id' =>$prj_id,
				'res_code' =>$res_code,
				'module'=>'R',
			);
			if ( ! $otherdb->insert('ac_entries', $insert_data))
			{
				$otherdb->trans_rollback();
			
				return false;
			} else {
				$entry_id = $otherdb->insert_id();
			}
				
			for($i=0; $i<count($crlist); $i++)
			{
				$insert_ledger_data = array(
					'entry_id' => $entry_id,
					'ledger_id' => $crlist[$i]['ledgerid'],
					'amount' => $crlist[$i]['amount'],
					'dc' => 'C',
				);
				if ( ! $otherdb->insert('ac_entry_items', $insert_ledger_data))
				{
					$otherdb->trans_rollback();
					
					return false;
				}
			}
			for($i=0; $i<count($drlist); $i++)
			{
				$insert_ledger_data = array(
					'entry_id' => $entry_id,
					'ledger_id' => $drlist[$i]['ledgerid'],
					'amount' => $drlist[$i]['amount'],
					'dc' => 'D',
				);
				if ( !$otherdb->insert('ac_entry_items', $insert_ledger_data))
				{
					$otherdb->trans_rollback();
					
					return false;
				}
			}
			/* Adding ledger accounts */
			

			/* Updating Debit and Credit Total in ac_entries table */
			$update_data = array(
				'dr_total' => $crtot,
				'cr_total' => $drtot,
			);
			if ( ! $otherdb->where('id', $entry_id)->update('ac_entries', $update_data))
			{
				$otherdb->trans_rollback();
				return false;
			}
			$insert_status = array(
				'entry_id' => $entry_id,
				'status' => 'CONFIRM',
			);
			if ( ! $otherdb->insert('ac_entry_status', $insert_status))
			{
				$otherdb->trans_rollback();
					return false;
			}
			
			/* Success */
			$otherdb->trans_complete();
			return $entry_id;
	}
	
	function transfer_todayint($date,$database)
	{
		$otherdb=$this->load->database($database, TRUE);
		$ledgerset=$this->get_account_set('EP Interest',$database);
		$data= $this->get_today_int_transfer_list($date,$database);
				
				 if($data){
					
				 foreach($data as $raw)
					{ 
						if(!$raw->int_entry){
							if($raw->reschdue_sqn==$raw->current_squ)
							{
								$totdi=$raw->di_amount;
								$totint=$raw->int_amount;
								$loancode=$raw->loan_code;
								$res_code=$raw->res_code;
								$resdata=$this->get_resevation($res_code,$database);
								if($totint>0){
										$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
										$crlist[0]['amount']=$crtot=$totint;
										$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
										$drlist[0]['amount']=$drtot=$totint;
										$narration = $loancode.'-'.$raw->instalment.' EP Loan Interest Payment  '  ;
										$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);	
										$this->insert_pay_enties($raw->rct_id,$int_entry,'EP Interest',$database);
										$insert_data = array(
											'int_entry'=>$int_entry,
											);
												$otherdb->where('pay_id',$raw->pay_id);
												if ( ! $this->db->update('re_eploanpayment', $insert_data))
												{
												 $otherdb->trans_rollback();
												 $this->messages->add('Error addding Entry.', 'error');
							  
												 return;
												 }
								
								
								}
							}
					}
					}
		}
	}
	

}
