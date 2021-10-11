<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class accountinterface_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function create_branchaccluntlist()
	{
		$this->db->select('*');
		$this->db->where('status','CONFIRMED');
		
		
		$query = $this->db->get('ac_config_ledgers'); 
		 if ($query->num_rows >0) {
            $data= $query->result();
			
			foreach($data as $raw)
			{
				$insert_data = array(
				'id' => $this->session->userdata('accshortcode').$raw->id,
				'group_id' => $raw->group_id,
				'ref_id' =>$raw->ref_id,
				'name' => $raw->name,
				'op_balance_dc' =>$raw->op_balance_dc,
				'type' =>$raw->type,
				'reconciliation' =>$raw->reconciliation,
			);
			if ( ! $this->db->insert('ac_ledgers', $insert_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
			}
			}
			return true;
        }
		else
		return false; 
	}
	function get_account_set($name)
	{
		$this->db->select('*');
		$this->db->where('Description',$name);
		
		
		$query = $this->db->get('re_lederset'); 
		 if ($query->num_rows >0) {
            $data= $query->row();
			$acc=array('Cr_account'=>$this->session->userdata('accshortcode').$data->Cr_account,
			'Dr_account'=>$this->session->userdata('accshortcode').$data->Dr_account);
			return $acc;
        }
		else
		return false; 
	}
	function get_master_acclist()
	{
		$this->db->select('ac_config_ledgers.*,ac_groups.name as group_name ');
		$this->db->where('status','CONFIRMED');
		$this->db->join('ac_groups','ac_groups.id=ac_config_ledgers.group_id');
		$this->db->order_by('ac_config_ledgers.id');
		$query = $this->db->get('ac_config_ledgers'); 
		 if ($query->num_rows >0) {
            $data= $query->result();
			return $data;
        }
		else
		return false; 
	}
	function next_entry_number($entry_type_id)
 	{
 		 $last_no_q = $this->db->query("SELECT MAX(CONVERT(number, SIGNED)) as lastno  FROM  ac_entries where entry_type='".$entry_type_id."'");
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
	function jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id,$res_code)
	{
		$data_number=$this->next_entry_number(4);
		if($prj_id=='')
		$prj_id=0;
		if($lot_id=='')
		$lot_id=0;
		if($res_code=='')
		$res_code=0;
		$this->db->trans_start();
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
			if ( ! $this->db->insert('ac_entries', $insert_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
			} else {
				$entry_id = $this->db->insert_id();
			}
				
			for($i=0; $i<count($crlist); $i++)
			{
				$insert_ledger_data = array(
					'entry_id' => $entry_id,
					'ledger_id' => $crlist[$i]['ledgerid'],
					'amount' => $crlist[$i]['amount'],
					'dc' => 'C',
				);
				if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
				{
					$this->db->trans_rollback();
					$this->logger->write_message("error", $narration."Error adding since failed inserting entry Items");
				
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
				if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
				{
					$this->db->trans_rollback();
					$this->logger->write_message("error", $narration."Error adding since failed inserting entry Items");
				
					return false;
				}
			}
			/* Adding ledger accounts */
			

			/* Updating Debit and Credit Total in ac_entries table */
			$update_data = array(
				'dr_total' => $crtot,
				'cr_total' => $drtot,
			);
			if ( ! $this->db->where('id', $entry_id)->update('ac_entries', $update_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error Updating since failed inserting entry Items");
				$this->template->load('template', 'entry/add', $data);
				return false;
			}
			$insert_status = array(
				'entry_id' => $entry_id,
				'status' => 'CONFIRM',
			);
			if ( ! $this->db->insert('ac_entry_status', $insert_status))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error Inserting Entry Status.', 'error');
				$this->logger->write_message("error", "Error Entry Status " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
				$this->template->load('template', 'entry/add', $data);
				return false;
			}
			
			/* Success */
			$this->db->trans_complete();
			return $entry_id;
	}
	function fundtransfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration)
	{
		$data_number=$this->next_entry_number(9);
		$this->db->trans_start();
			$insert_data = array(
				'number' => $data_number,
				'date' => $date,
				'narration' => $narration,
				'entry_type' => 9,
				'tag_id' => 1,
				'module'=>'R',
			);
			if ( ! $this->db->insert('ac_entries', $insert_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
			} else {
				$entry_id = $this->db->insert_id();
			}
				
			for($i=0; $i<count($crlist); $i++)
			{
				$insert_ledger_data = array(
					'entry_id' => $entry_id,
					'ledger_id' => $crlist[$i]['ledgerid'],
					'amount' => $crlist[$i]['amount'],
					'dc' => 'C',
				);
				if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
				{
					$this->db->trans_rollback();
					$this->logger->write_message("error", $narration."Error adding since failed inserting entry Items");
				
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
				if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
				{
					$this->db->trans_rollback();
					$this->logger->write_message("error", $narration."Error adding since failed inserting entry Items");
				
					return false;
				}
			}
			/* Adding ledger accounts */
			

			/* Updating Debit and Credit Total in ac_entries table */
			$update_data = array(
				'dr_total' => $crtot,
				'cr_total' => $drtot,
			);
			if ( ! $this->db->where('id', $entry_id)->update('ac_entries', $update_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error Updating since failed inserting entry Items");
				$this->template->load('template', 'entry/add', $data);
				return false;
			}
			$insert_status = array(
				'entry_id' => $entry_id,
				'status' => 'CONFIRM',
			);
			if ( ! $this->db->insert('ac_entry_status', $insert_status))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error Inserting Entry Status.', 'error');
				$this->logger->write_message("error", "Error Entry Status " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
				$this->template->load('template', 'entry/add', $data);
				return false;
			}
			
			/* Success */
			$this->db->trans_complete();
			return $entry_id;
	}
	function get_paid_list($rct_id) { //get all stock
		$this->db->select('re_eploanpayment.*,re_eploanshedule.deu_date,re_eploanshedule.instalment,re_eploanshedule.paid_cap,re_eploanshedule.paid_int,re_eploanshedule.tot_payment,re_eploanshedule.balance_di');
		$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->where('rct_id',$rct_id);
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_today_int_transfer_list($date) { //get all stock
		$this->db->select('re_eploanpayment.*,re_eploanshedule.deu_date,re_eploanshedule.instalment,re_eploan.res_code,re_eploan.reschdue_sqn as current_squ');
		$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
			$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
			$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->where('re_eploanshedule.deu_date',$date);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	
	function transfer_todayint($date)
	{
		$ledgerset=get_account_set('EP Interest');
				 $data= $this->get_today_int_transfer_list($date);
				
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
								$resdata=$this->get_resevation($res_code);
								if($totint>0){
										$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
										$crlist[0]['amount']=$crtot=$totint;
										$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
										$drlist[0]['amount']=$drtot=$totint;
										$narration = $loancode.'-'.$raw->instalment.' EP Loan Interest Payment  '  ;
										$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);	insert_change_transactions($int_entry,'',$raw->loan_code,$resdata->prj_id,$resdata->lot_id,date('Y-m-d'),'Interest Transfer');
										$this->insert_pay_enties($raw->rct_id,$int_entry,'EP Interest');
										$insert_data = array(
											'int_entry'=>$int_entry,
											);
										$this->db->where('pay_id',$raw->pay_id);
												if ( ! $this->db->update('re_eploanpayment', $insert_data))
												{
												 $this->db->trans_rollback();
												 $this->messages->add('Error addding Entry.', 'error');
							  
												 return;
												 }
								
								
								}
							}
					}
					}
		}
	}
	function get_paid_list_epb($rct_id) { //get all stock
		$this->db->select('*');
		$this->db->where('rct_id',$rct_id);
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function get_payment($id) { //get all stock
		$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('re_prjacincome'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
		function get_payment_by_entyid($id) { //get all stock
		$this->db->select('*');
		$this->db->where('entry_id',$id);
		$query = $this->db->get('re_prjacincome'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function get_resevation($id) { //get all stock
		$this->db->select('*');
		$this->db->where('res_code',$id);
		$query = $this->db->get('re_resevation'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function get_lotdata($id) { //get all stock
		$this->db->select('*');
		$this->db->where('lot_id',$id);
		$query = $this->db->get('re_prjaclotdata'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function get_loandata($id)
	{
		$this->db->select('*');
		$this->db->where('loan_code',$id);
		$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	function get_paid_capital($id)
	{
		$this->db->select('SUM(cap_amount) as tot');
		$this->db->where('loan_code',$id);
		$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return $data->tot;
		}
		else
		return false;
	}
	function insert_pay_enties($pay_id,$entry_id,$type)
	{//
	
			$insert_status = array(
				'pay_id ' => $pay_id,
				'entry_id' => $entry_id,
				'type' => $type,	
			);
			if ( ! $this->db->insert('re_paymententries', $insert_status))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", "Error Entry Status " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
			}
	
	}
	function get_salesadvance_onreciptid($id)
	{
		$this->db->select('pay_amount');
		$this->db->where('rct_id',$id);
		$query = $this->db->get('re_saleadvance'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return $data->pay_amount;
		}
		else
		return 0;
		
	}
	//
	function update_jurnal_entry_insert($type,$id,$date)
	{
		$paymentdata=$this->get_payment($id);
		$outright_profitmode=profit_outright_method();//companyconfig helper function
		$loan_profitmode=profit_agreement_method();//companyconfig helper function
		if($type=='Rental Payment')
		{
				 $loandata=$this->get_loandata($paymentdata->temp_code);
			  $reseavation_data=$this->get_resevation($loandata->res_code);
			  $lot_data=$this->get_lotdata($reseavation_data->lot_id);
			  $reservation_code=$loandata->res_code;
			  $totdi=0;
			$totint=0;
			$loancode='';
			  if($loandata->loan_type!='EPB'){
				  $ledgerset=get_account_set('EP Interest');
				 $data= $this->get_paid_list($id);
				 foreach($data as $raw)
					{
						if($date >= $raw->deu_date)
						{
						$totdi=$raw->di_amount;
						$totint=$raw->int_amount;
						$loancode=$raw->loan_code;
						if($totint>0){
						$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$totint;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$totint;
						$narration = $loancode.'-'.$raw->instalment.' EP Loan Interest Payment  '  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						//	insert_change_transactions($int_entry,$reseavation_data->res_code,$raw->loan_code,$reseavation_data->prj_id,$reseavation_data->lot_id,date('Y-m-d'),'Interest Transfer');
						$this->insert_pay_enties($id,$int_entry,'EP Interest');
						$insert_data = array(
							'int_entry'=>$int_entry,
							);
						$this->db->where('pay_id',$raw->pay_id);
							if ( ! $this->db->update('re_eploanpayment', $insert_data))
							{
						 	 $this->db->trans_rollback();
							 $this->messages->add('Error addding Entry.', 'error');
		  
							 return;
							 }
						
						}
						}
					}
				 
			  }
			  
			
			
			
			
			// if($loandata->loan_type!='NEP')
			// {
				$lot_data=$this->get_lotdata($reseavation_data->lot_id);
				$get_amount=$this->loan_payment_capital_income($id);
				if($loan_profitmode==2)//acctual basic profit transfer mode
				{
			  		update_unrealized_sale_on_income($id,$get_amount,$reseavation_data->res_code,$date);
				//financial transfer helper function
				}
				
			// }
				
			
			
		}
		if($type=='Advance Payment' || $type=='Balance Payment')
		{
			  $reseavation_data=$this->get_resevation($paymentdata->temp_code);
			  $reservation_code=$paymentdata->temp_code;
			$lot_data=$this->get_lotdata($reseavation_data->lot_id);
			//$current_payment=$paymentdata->get_lotdata();
			if($lot_data->status!='SOLD')
			{
				
				initial_profit_transfer($paymentdata->temp_code,$id,$type,$date);
			
				
			}
			else
			{
				$amount=$this->get_salesadvance_onreciptid($id);
				if($outright_profitmode==2)//acctual basic profit transfer mode
				{
				update_unrealized_sale_on_income($id,$amount,$reseavation_data->res_code,$date);
				// financial transfer helper funciton		
				}
			}
		}
		if($type=='EP Settlement')
		{
			
				 $loandata=$this->get_loandata($paymentdata->temp_code);
				   $reservation_code=$loandata->res_code;
				 $reseavation_data=$this->get_resevation($loandata->res_code);
			   	$lot_data=$this->get_lotdata($reseavation_data->lot_id);
				$data=$this->get_loan_settlement_details($id);
				if($loan_profitmode==2) //acctual basic profit transfer mode
				{
					 update_unrealized_sale_on_income($id,$data->balance_capital,$loandata->res_code,$date);
				}
				 early_settlement_entries($id,$paymentdata->temp_code,$loandata->res_code,$date);//financialtransfer helper function
				
			
			
					
			  
		
		}
		$this->transfer_excess_amount($id, $reservation_code,$date);
		update_pending_cheque_charge($reseavation_data->cus_code,$id);
	}
	function transfer_excess_amount($id,$reservation_code,$date)
	{
		$this->db->select('*');
		$this->db->where('pay_id',$id);
		$query = $this->db->get('re_arreaspayment'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		
		  $ledgerset=get_account_set('Customer Excess Payments');
		   $reseavation_data=$this->get_resevation($reservation_code);
						  $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$data->amount;
						$drlist[0]['ledgerid']=$data->ledger_account;
						$drlist[0]['amount']=$drtot=$data->amount;
						$narration = $reseavation_data->res_code.'- Customer Excess Payment Transfer'  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
					
						$this->insert_pay_enties($id,$int_entry,'EP Interest');
		  
		  
		}
		else
		return true;
		
	}
	function get_loan_settlement_details($id)
	{
		$this->db->select('*');
		$this->db->where('rct_id',$id);
		$query = $this->db->get('re_eprebate'); 
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return true;
   
	
	}
	function get_check_fenceletter($res_code)
	{
		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$this->db->where('letter_type','03');
		$query = $this->db->get('re_cusletter'); 
		if ($query->num_rows() > 0){
		return false;
		}
		else
		return true;
   
	
	}
	function loan_payment_capital_income($id)
	{
		$this->db->select('SUM(cap_amount) paycap');
		$this->db->where('rct_id',$id);
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return $data->paycap;
		}
		else
		return 0;
   
	
	}
	function get_payment_entires($id)
	{
		$this->db->select('*');
		$this->db->where('pay_id',$id);
		$query = $this->db->get('re_paymententries'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
   
	
	}
	function update_jurnal_entry_delete($enty_id)
	{
		if($enty_id)
		{
			$paymentdata=$this->get_payment_by_entyid($enty_id);
			if($paymentdata)
			{
			revert_cheque_charge_payment($paymentdata->id);
			if($paymentdata->income_type=='Rental Payment')
			{
				 $loandata=$this->get_loandata($paymentdata->temp_code);
				 $rescoode=$loandata->res_code;
				 $reseavation_data=$this->get_resevation($rescoode);
				 $this->delete_loanpayment($loandata->loan_code,$loandata->loan_type,$paymentdata->id);
				  $this->delete_unrealized_sale($rescoode,$paymentdata->id);
			}
			if($paymentdata->income_type=='Advance Payment' || $paymentdata->income_type=='Balance Payment')
			{
				 $rescoode=$paymentdata->temp_code;
				$reseavation_data=$this->get_resevation($rescoode);
				$this->delete_other_payment($paymentdata->income_type,$paymentdata->id);
				$this->delete_unrealized_sale($rescoode,$paymentdata->id);
			}
			if($paymentdata->income_type=='EP Settlement')
			{
					 $loandata=$this->get_loandata($paymentdata->temp_code);
					 $reseavation_data=$this->get_resevation($loandata->res_code);
					$lot_data=$this->get_lotdata($reseavation_data->lot_id);
					$this->delete_unrealized_sale($loandata->res_code,$paymentdata->id);
					delete_futrecapital_and_int_transfers_on_settlment($paymentdata->id,$paymentdata->temp_code);//financial transfer helper function
						 $insert_data=array('loan_status'=>'CONFIRMED');
						$this->db->where('loan_code',$paymentdata->temp_code);
						if ( ! $this->db->update('re_eploan', $insert_data))
							{
								 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
				
						 return;
							 } 
								$this->db->where('rct_id',$paymentdata->id);
							  $this->db->delete('re_eprebate'); 
			}
		
					$data=$this->get_payment_entires($paymentdata->id);
				//echo $paymentdata->id;
				$this->db->trans_start();
				if($data){
				foreach($data as $raw)
				{
						
					$entry_id=$raw->entry_id;
					if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
					{
					   $this->db->trans_rollback();
					}
					if ( ! $this->db->delete('ac_entries', array('id' => $entry_id)))
					{
					  $this->db->trans_rollback();
					}
					if($raw->type=='Cost Trasnfer')
					{
							$insert_data=array('status'=>'RESERVED');
							$this->db->where('lot_id',$reseavation_data->lot_id);
							if ( ! $this->db->update('re_prjaclotdata', $insert_data))
							{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
							} 
							
								 $insert_data=array('profit_status'=>'PENDING','profit_date'=>NULL);
							$this->db->where('res_code',$reseavation_data->res_code);
							if ( ! $this->db->update('re_resevation', $insert_data))
								{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
								 } 
						
					}
					if($raw->type=='Initial Transfer from first advance')
					{
							
							
								 $insert_data=array('init_costtrn_status'=>'PENDING','init_costtrn_date'=>NULL);
							$this->db->where('res_code',$reseavation_data->res_code);
							if ( ! $this->db->update('re_resevation', $insert_data))
								{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
								 } 
						
					}
					if($raw->type=='EP Interest')
					{
						//insert_delete_transactions($entry_id,date('Y-m-d'));
					}
					
				}
				}
				$this->delete_payment_entry($paymentdata->id);
				 $this->db->trans_complete();
			}// check payment data exist
			
		}// check entryid exist
		
	}
		function update_jurnal_entry_cancel($enty_id)
	{
		if($enty_id)
		{
				$paymentdata=$this->get_payment_by_entyid($enty_id);
			if($paymentdata)
			{	
			revert_cheque_charge_payment($paymentdata->id);
			if($paymentdata->income_type=='Rental Payment')
			{
				 $loandata=$this->get_loandata($paymentdata->temp_code);
				 $rescoode=$loandata->res_code;
				 $reseavation_data=$this->get_resevation($rescoode);
				 $this->delete_loanpayment($loandata->loan_code,$loandata->loan_type,$paymentdata->id);
				 $this->delete_unrealized_sale($rescoode,$paymentdata->id);
			}
			if($paymentdata->income_type=='Advance Payment' || $paymentdata->income_type=='Balance Payment')
			{
				 $rescoode=$paymentdata->temp_code;
				$reseavation_data=$this->get_resevation($rescoode);
				$this->delete_other_payment($paymentdata->income_type,$paymentdata->id);
				$this->delete_unrealized_sale($rescoode,$paymentdata->id);
			}
			if($paymentdata->income_type=='EP Settlement')
			{
					 $loandata=$this->get_loandata($paymentdata->temp_code);
					 $reseavation_data=$this->get_resevation($loandata->res_code);
					$lot_data=$this->get_lotdata($reseavation_data->lot_id);
					
					 $this->delete_unrealized_sale($loandata->res_code,$paymentdata->id);
					 delete_futrecapital_and_int_transfers_on_settlment($paymentdata->id,$paymentdata->temp_code);//financial transfer helper function
					
					 $insert_data=array('loan_status'=>'CONFIRMED');
					
					$this->db->where('loan_code',$paymentdata->temp_code);
							if ( ! $this->db->update('re_eploan', $insert_data))
								{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
								 } 
									$this->db->where('rct_id',$paymentdata->id);
								  $this->db->delete('re_eprebate'); 
						
			}
			
			if ( ! $this->db->delete('re_chargepayments', array('rct_id' => $paymentdata->id)))
			{
					  $this->db->trans_rollback();
			}
				$data=$this->get_payment_entires($paymentdata->id);
				//echo $paymentdata->id;
				$this->db->trans_start();
				if($data){
				foreach($data as $raw)
				{
						
					$entry_id=$raw->entry_id;
					if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
					{
					   $this->db->trans_rollback();
					}
					if ( ! $this->db->delete('ac_entries', array('id' => $entry_id)))
					{
					  $this->db->trans_rollback();
					}
					if($raw->type=='Cost Trasnfer')
					{
							$insert_data=array('status'=>'RESERVED');
							$this->db->where('lot_id',$reseavation_data->lot_id);
							if ( ! $this->db->update('re_prjaclotdata', $insert_data))
							{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
							} 
							
								 $insert_data=array('profit_status'=>'PENDING');
							$this->db->where('res_code',$reseavation_data->res_code);
							if ( ! $this->db->update('re_resevation', $insert_data))
								{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
								 } 
						
					}
					if($raw->type=='Initial Transfer from first advance')
					{
							
							
								 $insert_data=array('init_costtrn_status'=>'PENDING','init_costtrn_date'=>NULL);
							$this->db->where('res_code',$reseavation_data->res_code);
							if ( ! $this->db->update('re_resevation', $insert_data))
								{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
							 return;
								 } 
						
					}
					if($raw->type=='EP Interest')
					{
						//insert_delete_transactions($entry_id,date('Y-m-d'));
					}
				}
				}
				$this->delete_payment_entry($paymentdata->id);
				 $this->db->trans_complete();
			}
			
		}
		
	}
	function  delete_loanpayment($loan_code,$loan_type,$id)
	{
		if($id)
		{
		if($loan_type!='EPB')
		{
			//echo $id;
			$data=$this->get_paid_list($id);
			if($data){
			//	echo print_r($data);
			foreach($data  as $raw)
			{
				$curentcap=$raw->cap_amount;
				$curentint=$raw->int_amount;
				$curentdi=$raw->di_amount;
				$thisdata=$this->get_this_instalment($raw->ins_id);
				if($raw->cap_amount>0)
				$paidcap=round($thisdata->paid_cap-$raw->cap_amount,2);
				else $paidcap=$thisdata->paid_cap;
				if($raw->int_amount>0)
				$paidint=round($thisdata->paid_int-$raw->int_amount,2);
				else
				$paidint=$thisdata->paid_int;
				if($raw->di_amount>0)
				$paiddi=round($thisdata->balance_di-$raw->di_amount,2);
				else $paiddi=$thisdata->balance_di;
				$paidtot=round($paidint+$paidcap,2);
				if($raw->paid_cap<0)
				{
					$paidcap=0;
				}
				
				if($paidint<0)$paidint=0;
				if($paiddi<0)$paiddi=0;
				if($paidtot<0)$paidtot=0;
				$status='PENDING';
				
				//echo $paidint.'--'.$paidtot.$status.$raw->ins_id.'sss';
				//if()
				 $insert_data = array(
									'paid_cap' => $paidcap,
									'paid_int' =>$paidint,
									'tot_payment' => $paidtot,
									'balance_di' => $paiddi,
									'pay_status'=>$status,
									'pay_date'=>$thisdata->deu_date,
									);
								$this->db->where('id',$raw->ins_id);
								if ( ! $this->db->Update('re_eploanshedule', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');
				
									return;
								}
				
				
			}
		}
	}
							 $insert_data = array(
									'loan_status' => 'CONFIRMED',
									);
								$this->db->where('loan_code',$loan_code);
								if ( ! $this->db->Update('re_eploan', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');
				
									return;
								}
								//echo '========'.$id;
		$this->db->where('rct_id',$id);
		$this->db->delete('re_eploanpayment');
		}
	}
	
	function get_advance_byrct_id($id) { //get all stock
		$this->db->select('re_saleadvance.*');
		$this->db->where('re_saleadvance.rct_id',$id);
		
		$query = $this->db->get('re_saleadvance'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function delete_arrears_paymentdata($pay_id)
	{
		if($pay_id)
		{
			$this->db->select('*');
			$this->db->where('pay_id', $pay_id);
			
			$query = $this->db->get('re_arreaspayment'); 
			if ($query->num_rows() > 0){
				$data= $query->row(); 
				if($data->voucher_id)
				{
					$this->db->where('voucherid', $data->voucher_id);
					$insert = $this->db->delete('ac_payvoucherdata');
				}
			}
		}
		else
		return false;
	}
	function delete_payment_entry($id)
	{
		if($id)
		{
			$this->delete_arrears_paymentdata($id);
			$this->db->where('id', $id);
			$insert = $this->db->delete('re_prjacincome');
			$this->db->where('income_id', $id);
			$insert = $this->db->delete('re_incomentires');
			$this->db->where('pay_id', $id);
			$insert = $this->db->delete('re_arreaspayment');
				$this->db->where('rct_id', $id);
			$insert = $this->db->delete('re_hm_addtionaldp_income');
		}
	}
	
	function delete_other_payment($income_type,$id)
	{
		if($income_type=='Advance Payment' )
		{
			$addata=$this->get_advance_byrct_id($id);
			if($addata)
			delete_advance($addata->id);
		}
		
	}
	function get_ledgerid_set($task_id)
	{
		$this->db->select('ledger_id,adv_ledgerid');
		
		$this->db->where('task_id',$task_id);
		$this->db->where('status','CONFIRMED');
		$query = $this->db->get('cm_tasktype'); 
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;
		
	}
	
	function project_confirm_entires($prj_id,$prj_code)
	{
		
		$this->db->select('*');
		
		$this->db->where('prj_id',$prj_id);
		$query = $this->db->get('re_prjacpaymentms'); 
		if ($query->num_rows() > 0){
			$data= $query->result();
			$tot=0;
			$count=0;
			foreach($data as $raw)
			{
				if($raw->estimate_budget>0)
				{   
					$ledgerdata=$this->get_ledgerid_set($raw->task_id);
					$crlist[$count]['ledgerid']=$this->session->userdata('accshortcode').$ledgerdata->ledger_id;
					$crlist[$count]['amount']=$raw->estimate_budget;
					$tot=$tot+$raw->estimate_budget;
					if($raw->tot_payments>0)
					{
						$cracc[0]['ledgerid']=$this->session->userdata('accshortcode').$ledgerdata->adv_ledgerid;
						$cracc[0]['amount']=$crtot=$raw->tot_payments;
						$dracc[0]['ledgerid']=$this->session->userdata('accshortcode').$ledgerdata->ledger_id;
						$dracc[0]['amount']=$drtot=$raw->tot_payments;
						$narration = $prj_code.' Advance Expences Transfer  '  ;
						$int_entry=jurnal_entry($cracc,$dracc,$crtot,$drtot,date('Y-m-d'),$narration,$prj_id,'','');
						insert_change_transactions($int_entry,'','',$prj_id,'',date('Y-m-d'),'Budget Confirmation Advance');
			
					}
					$count++;
				}
			}
			$ledgerset=get_account_set('Project Conformation');
			$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
			$drlist[0]['amount']=$crtot=$drtot=$tot;
			$narration = $prj_code.' Project Conformation '  ;
			$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$prj_id,'','');
			insert_oumit_transactions($int_entry,'','',$prj_id,'',date('Y-m-d'),'Budget Confirmation');
			return $int_entry;
		}
		else
		return 0;
	}
	function project_price_entires($prj_id,$prj_code,$exp)
	{
			$ledgerset=get_account_set('Price List Confirmation');
			$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
			$crlist[0]['amount']=$crtot=$exp;
			$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
			$drlist[0]['amount']=$crtot=$drtot=$exp;
			$narration = $prj_code.' Project Price List Conformation '  ;
			$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$prj_id,'','');
				insert_oumit_transactions($int_entry,'','',$prj_id,'',date('Y-m-d'),'Price Confirmation');
			return $int_entry;
		
	}
	function confirm_count($tablenames)
	{
				$this->db->select('*');
				$this->db->where('status',CONFIRMKEY);
					$query = $this->db->get($tablenames); 
				 if ($query->num_rows >0) {
           			 return $query->num_rows();
       			 }
					else
				return 0; 
	}
	function get_maxid($idfield,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table );
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=1;
		

			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			// echo
			 $id=intval($prjid);
			 $newid=$id+1;
			 
			
			
			 }
        }
		else
		{
		
		$newid=1;
		$newid=$newid;
		}
	return $newid;
	
	}
	
	function get_finance_year()
	{
			$this->db->select('*');
			$this->db->where('id',1);
	
		$query = $this->db->get('cm_settings'); 
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false; 
}
function get_customerdata($id)
	{
		$this->db->select('*');
		$this->db->where('cus_code',$id);
		$query = $this->db->get('cm_customerms'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
function customer_arreaspayment($branch_code,$cus_code,$res_code,$lot_id,$loan_code,$amount,$ledger_account,$arreas_date,$payid)
{
	$cusdata=$this->get_customerdata($cus_code);
	 $ledgerset=get_account_set('Customer Excess Payments');
		$idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
			$id=$idlist[0];
		$data=array( 
		'voucherid'=>$id,
		'vouchercode'=>$idlist[1],
		'refnumber'=>$payid,
		'branch_code' =>$branch_code,
		'ledger_id' => $ledgerset['Dr_account'],
		'payeename' => $cusdata->first_name." ".$cusdata->last_name ,
		'vouchertype' => '6',
		'paymentdes' => 'Excess Payment Refund',
		'amount' => $amount,
		'applydate' =>$arreas_date,
		'status' => 'CONFIRMED',
		
		);
		if(!$this->db->insert('ac_payvoucherdata', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
	
	$insert_data = array(
				'cus_code' => $cus_code,
				'res_code' =>$res_code,
				'lot_id' => $lot_id,
				'loan_code' =>$loan_code,
				'amount' =>$amount,
				'voucher_id' =>$id,
				'pay_id' =>$payid,
				'ledger_account' =>$ledger_account,
			);
			if ( ! $this->db->insert('re_arreaspayment', $insert_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
			}
	
}

function get_pending_payments($temp_code)
	{
		$this->db->select('*');
		$this->db->where('temp_code',$temp_code);
		$this->db->where('pay_status','PENDING');
		$query = $this->db->get('re_prjacincome'); 
		if ($query->num_rows() > 0){
		return true;
		}
		else
		return false;
   
	
	}
	function get_vaouchercode($idfield,$prifix,$table,$datemount)
    {
       // $date=$this->config->item('account_fy_start');
	  // echo $this->session->userdata('shortcode');
	  
	  $query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table);

        $newid="";
		$voucherid=0;
        if ($query->num_rows > 0) {
            $data = $query->row();
            $prjid=$data->id;
			 $voucherid=intval($prjid)+1;
		}
		else
		$voucherid=1;
	  
	  
		$prifix='HED'.$prifix;
		//echo  $prifix;
        $year= substr($datemount,0,4);
        $myyear=substr($datemount,2,2);
        $mymont=substr($datemount,5,2);
        $prifix=$prifix.$myyear.$mymont."-";
        $fromdate=$year."-".$mymont."-01";
        $todate=$year."-".$mymont."-31";
        $query = $this->db->query("SELECT MAX(vouchercode) as id  FROM ".$table." where    applydate  between '".$fromdate."' and '".$todate."'");
//echo $this->db->last_query();
        $newid="";

        if ($query->num_rows > 0) {
            $data = $query->row();
            $prjid=$data->id;
           // echo $prjid;
            if($data->id==NULL)
            {
                $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);


            }
            else{
                $prjid=substr($prjid,10,5);
                $id=intval($prjid);
                $newid=$id+1;
                $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);


            }
        }
        else
        {

            $newid=str_pad(1, 5, "0", STR_PAD_LEFT);
            $newid=$prifix.$newid;
        }
		$idfields=array($voucherid,$newid);
        return $idfields;
     

    }
	function get_account_set_config($name,$type)
	{
		$this->db->select('*');
		$this->db->where('Description',$name);
		
		
		$query = $this->db->get($type.'_lederset'); 
		 if ($query->num_rows >0) {
         		return $query->row();
        }
		else
		return false; 
	}
	function get_this_instalment($insid) { //get all stock
		$this->db->select('re_eploanshedule.*');
		$this->db->where('id',$insid);
		$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	
	function get_reservation_list_forcompleteadvance($date) { //get all stock
		$this->db->select('re_resevation.*');
				$this->db->where('re_resevation.res_status','PROCESSING');
					$query = $this->db->get('re_resevation'); 
		if ($query->num_rows() > 0){
				$dataset=$query->result();
				foreach($dataset as $raw)
				{
					if($raw->discounted_price<=$raw->down_payment)
					{
						if($this->check_pending_payments_forsettlements($raw->res_code))
						{
							$insert_data = array(
							'res_code' =>  $raw->res_code,
							'settle_seq' =>'000',
							'amount' => 0,
							'settle_date' =>$date,
							'settle_status' => 'CONFIRMED',
							
				
							);
							
							if ( ! $this->db->insert('re_settlement', $insert_data))
							{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');
				
								return;
							}
							$data=array( 
							'pay_type' =>'Outright',
							'res_status' => 'SETTLED',
							);
							$this->db->where('res_code', $raw->res_code);
							//$this->db->where('res_code', $res_code);
							$insert = $this->db->update('re_resevation', $data);
								
							 /*2019-10-11 nadee ticket number 752*/
							//if($raw->profit_status=='PENDING'){
							  $this->db->select('re_prjacincome.id,re_prjacincome.income_type,re_prjacincome.income_date');
							  $this->db->where('re_prjacincome.temp_code',$raw->res_code);
							  $this->db->where('re_prjacincome.pay_status','PAID');
							  $this->db->where('re_prjacincome.income_type','Advance Payment');
							  $this->db->order_by('re_prjacincome.id','DESC');
							  $this->db->limit('1');
							  $query3 = $this->db->get('re_prjacincome');
							  if($query3->result()>0){
								$result3=$query3->row();
								update_jurnal_entry_insert($result3->income_type,$result3->id,$date);
							//  }
				
							}
						}
					}
				}
		}
		else
		return false;
    }
	function check_pending_payments_forsettlements($res_code)
	{
		$this->db->select('*');
		$this->db->where('temp_code',$res_code);
		$this->db->where('pay_status','PENDING');
		$query = $this->db->get('re_prjacincome'); 
		if ($query->num_rows() > 0){
		return false;
		}
		else
		return true;
	}
	
	
	//added functions from commercial reality - odiliya modification 
	//added by udani 2019-03-19
	
	function get_unrealized_data($res_code)
	{
		$this->db->select('*');
		$this->db->where('res_code',$res_code);


		$query = $this->db->get('re_unrealized');
		 if ($query->num_rows >0) {
         		return $query->row();
        }
		else
		return false;
	}
	//metrolan spacific unrealize transffer funcitions
function insert_unrealizedsale($prj_id,$res_code,$full_sale,$full_cost,$unrealized_sale,$unrealized_cost,$first_trndate,$method,$hm_full_sale,$hm_full_cost,$hm_unrealized_sale,$unrealized_cost_hm)
{

//hm_full_sale, 	hm_full_cost,hm_unrealized_sale, 	hm_unrealized_cost
	if($res_code)
	{
	$this->db->where('res_code',$res_code);
	$this->db->delete('re_unrealized');
	$totunrealized=$unrealized_sale+$hm_unrealized_sale;
	if($totunrealized<1)
	$status='COMPLETE';
	else
	$status='PARTIAL';
	$insert_data = array(
				'prj_id' => $prj_id,
				'res_code' =>$res_code,
				'full_sale' => $full_sale,
				'full_cost' =>$full_cost,
				
				'unrealized_sale' =>$unrealized_sale,
				'unrealized_cost' =>$unrealized_cost,
				
				'hm_full_sale' => $hm_full_sale,
				'hm_full_cost' =>$hm_full_cost,
				
				'hm_unrealized_sale' =>$hm_unrealized_sale,
				'hm_unrealized_cost' =>$unrealized_cost_hm,
				'first_trndate' =>$first_trndate,
				'method' =>$method,
				'status' =>$status,
			);
			if ( ! $this->db->insert('re_unrealized', $insert_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");

				return false;
			}
	}

}

function insert_unrdata($res_code,$income_id,$rct_no,$date,$trn_sale,$trn_cost,$discription,$hm_trnsale=0,$hm_trncost=0)
{



	$insert_data = array(
				'res_code' => $res_code,
				'income_id' =>$income_id,
				'rct_no' => $rct_no,
				'date' =>$date,
				'trn_sale' =>$trn_sale,
				'trn_cost' =>$trn_cost,
				'hm_trn_sale' =>$hm_trnsale,
				'hm_trn_cost' =>$hm_trncost,
				'discription' =>$discription,

			);
			if ( ! $this->db->insert('re_unrealizeddata', $insert_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");

				return false;
			}

}

function delete_unrealized_sale($res_code,$income_id)
{
			$unrealized_data=$this->get_unrealized_data($res_code);
	// print_r($unrealized_data);
	 if($unrealized_data)
	 {
			$un_cost_priv=$unrealized_data->unrealized_cost;
			$un_sale_priv=$unrealized_data->unrealized_sale;
			$hm_unrealized_sale_prev=$unrealized_data->hm_unrealized_sale;
			$hm_unrealized_cost_prev=$unrealized_data->hm_unrealized_cost;
			$dataset=$this->get_undata_on_income_id($income_id);
			if($dataset)
			{
				foreach($dataset as $dataraw)
				{
				$un_cost_priv=$un_cost_priv+$dataraw->trn_cost;
				$un_sale_priv=$un_sale_priv+$dataraw->trn_sale;
				$hm_unrealized_cost_prev=$hm_unrealized_cost_prev+$dataraw->hm_trn_cost;
				$hm_unrealized_sale_prev=$hm_unrealized_sale_prev+$dataraw->hm_trn_sale;
				
				}
			}
			$this->db->where('income_id',$income_id);
			$this->db->delete('re_unrealizeddata');
			 $insert_data = array(
			 			'unrealized_sale' =>$un_sale_priv,
							'unrealized_cost' =>$un_cost_priv,
							'hm_unrealized_sale' =>$hm_unrealized_sale_prev,
							'hm_unrealized_cost' =>$hm_unrealized_cost_prev,
							
						'last_incomeid' =>'',
						'status' =>'PARTIAL',
			);
			$this->db->where('res_code',$res_code);
				if ( ! $this->db->Update('re_unrealized', $insert_data))
				{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");

				return false;
			}
	 }


}
/// unrealized check on dayend procees on loan settlemetns
	function get_paid_capital_for_settlement($id,$reshed)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount) as tot');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
		$this->db->where('re_eploanpayment.loan_code',$id);
		$this->db->where('re_eploanpayment.reschdue_sqn',$reshed);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return $data->tot;
		}
		else
		return false;
	}
	
	function get_myloanlist_forupdetesettlement_NEP($date) { //get all stock
		$this->db->select('re_eploan.*');
				$this->db->where('re_eploan.loan_status','CONFIRMED');
					$this->db->where('re_eploan.loan_type','NEP');
			$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
				$dataset=$query->result();
				foreach($dataset as $raw)
				{
					$this->update_eploan_settlements($raw->loan_code,$raw->reschdue_sqn,$date,$raw->res_code);
				}
		}
		else
		return false;
    }
	function get_this_instalment_byinstalment($insid,$loancode,$reshed) { //get all stock
		$this->db->select('re_eploanshedule.*');
		$this->db->where('instalment',$insid);
		$this->db->where('loan_code',$loancode);
		$this->db->where('reschdue_sqn',$reshed);
		$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function update_eploan_settlements($loancode,$reshed,$date,$rescode) { //get all stock
		$this->db->select('MAX(re_eploanshedule.instalment) as MSXID'); 
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reshed);
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		$maxid= $data->MSXID;
		$insdata=$this->get_this_instalment_byinstalment($maxid,$loancode,$reshed);
		if($insdata){
			if($insdata->pay_status=='PAID')
			{
				if($insdata->deu_date<=$date)
				{
							$insert_data = array(
								
							'loan_status' =>'SETTLED',
							'end_date' => date('Y-m-d'),
						);
					$this->db->where('loan_code',$loancode);
					if ( ! $this->db->Update('re_eploan', $insert_data))
					{
					$this->db->trans_rollback();
					$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
				
					return false;
					}
				}
			}
		}
		}
		else
		return false;
    }

// transfer capital to debtor account
function get_today_capital_transfer_list($date) { //get all stock
		$this->db->select('re_eploanshedule.*,re_eploan.res_code,re_eploan.reschdue_sqn as current_squ');
		//$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		//$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
			$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
			$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->where('re_eploanshedule.deu_date',$date);
		//$this->db->where('re_prjacincome.pay_status','PAID');
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	
	function transfer_todaycapital($date)
	{
	
	}
	function get_lastpayment_data($id,$reshed)
	{
		$this->db->select('MAX(rct_id) as myrct_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
			$this->db->where('re_eploanpayment.loan_code',$id);
		$this->db->where('re_eploanpayment.reschdue_sqn',$reshed);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->group_by('re_eploanpayment.loan_code');
			$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return $data->myrct_id; 
		}
		else
		return 0;
	}
	



	function get_undata_on_income_id($income_id)
	{		
			$this->db->where('income_id',$income_id);


		$query = $this->db->get('re_unrealizeddata');
		 if ($query->num_rows >0) {
         		return $query->result();
        }
		else
		return false;
		
	}


	
	function get_loandata_by_rescode($id)
	{
		$this->db->select('loan_code,reschdue_sqn,loan_amount');
		$this->db->where('res_code',$id);
		$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return $query->row();
		}
		else
		return false;
   
	
	}


function get_reservation_list_not_transferdd_profit($date) { //get all stock
		$this->db->select('re_resevation.*');
		$this->db->where('re_resevation.res_status','SETTLED');
						$query = $this->db->get('re_resevation'); 
		if ($query->num_rows() > 0){
				$dataset=$query->result();
				foreach($dataset as $raw)
				{
					if($raw->discounted_price<=$raw->down_payment)
					{
						if($this->check_pending_payments_forsettlements($raw->res_code))
						{
							
								
							
							  $this->db->select('re_prjacincome.id,re_prjacincome.income_type,re_prjacincome.income_date,re_prjacincome.entry_date');
							  $this->db->where('re_prjacincome.temp_code',$raw->res_code);
							  $this->db->where('re_prjacincome.pay_status','PAID');
							  $this->db->where('re_prjacincome.income_type','Advance Payment');
							  $this->db->order_by('re_prjacincome.id','DESC');
							  $this->db->limit('1');
							  $query3 = $this->db->get('re_prjacincome');
							  if($query3->result()>0){
								$result3=$query3->row();
								update_jurnal_entry_insert($result3->income_type,$result3->id,$result3->entry_date);
							
				
							}
						}
					}
				}
		}
		else
		return false;
    }
	

}
