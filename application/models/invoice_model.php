<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class invoice_model extends CI_Model {

    function __construct() {
		
        parent::__construct();
		$this->load->model("accountinterface_model");
    }
	function get_all_invoices() { //get all stock
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		$this->db->order_by('date','DESC');
			$this->db->group_by('ac_invoices.id');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$query = $this->db->get('ac_invoices'); 
		return $query->result(); 
    }
		function get_not_paid_invoices_project() { //get all stock
		$type=array('P','O');
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		$this->db->where_in('ac_invoices.type ',$type);
		$this->db->where('ac_invoices.paystatus !=','PAID');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$this->db->group_by('ac_invoices.id');
		$this->db->order_by('date','DESC');
		$query = $this->db->get('ac_invoices'); 
		return $query->result(); 
    }
	function get_not_paid_invoices() { //get all stock
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		$this->db->where('ac_invoices.paystatus !=','PAID');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$this->db->group_by('ac_invoices.id');
		$this->db->order_by('date','DESC');
		$query = $this->db->get('ac_invoices'); 
		return $query->result(); 
    }
	
	function get_not_paid_invoices_confirmed() { //get all stock
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		$this->db->where('ac_invoices.paystatus !=','PAID');
		$this->db->where('ac_invoices.status','CONFIRMED');
		//$this->db->where('ac_invoicepayments.type !=','Retention');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$this->db->group_by('ac_invoices.id');
		$this->db->order_by('date','DESC');
		$query = $this->db->get('ac_invoices'); 
		return $query->result(); 
    }
	
	function get_retention_total_by_id($id){
		$this->db->select('SUM(ac_invoicepayments.pay_amount) as retention');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id');
		$this->db->where('ac_invoices.id',$id);
		$this->db->where('ac_invoicepayments.type','Retention');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$this->db->group_by('ac_invoices.id');
		$query = $this->db->get('ac_invoices'); 
		if($query->num_rows() > 0){
			return $query->row()->retention;
		}
	}
	
	 function get_invoice_by_id($id)
  { //get leger name by code
    $this->db->select('ac_invoices.*,,cm_supplierms.first_name,cm_supplierms.last_name,');
	$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		
    $this->db->where('ac_invoices.id',$id);

    $query = $this->db->get('ac_invoices');
    if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->row();
    }
    else
    return 0;
  }
	 function get_leger_names($leger_code)
  { //get leger name by code
    $this->db->select('name,type,id,ref_id');
    $this->db->where('id',$leger_code);

    $query = $this->db->get('ac_ledgers');
    if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->row();
    }
    else
    return 0;
  }

  function get_all_legers()
  { //get all asset
    $this->db->select('id,name,ref_id');
    $this->db->order_by('name');
    $query = $this->db->get('ac_ledgers');
	  if ($query->num_rows() > 0){
      //$data= $query->row();
        return $query->result();
    }
    else
    return false;
  
  }
function get_confiremed_assets()
  { //get all assets
    $this->db->select('ac_fixedassets.*,ac_fixedasset_cat.asset_category,ac_fixedasset_cat.leger_acc');
	 $this->db->where('ac_fixedassets.statues','CONFIRMED');
	 $this->db->join('ac_fixedasset_cat','ac_fixedasset_cat.id=ac_fixedassets.category_id');
	
    $this->db->order_by('ac_fixedassets.asset_name');
    $query = $this->db->get('ac_fixedassets');
     if ($query->num_rows() > 0){
      //$data= $query->row();
        return $query->result();
    }
    else
    return false;
  }
  function get_invoice_assets($inv_id)
  { //get all assets
    $this->db->select('ac_fixedassets.*,ac_fixedasset_cat.asset_category,ac_fixedasset_cat.leger_acc');
	 $this->db->join('ac_fixedassets','ac_fixedassets.id=ac_invoice_fixeditems.asset_id');
	 $this->db->join('ac_fixedasset_cat','ac_fixedasset_cat.id=ac_fixedassets.category_id');
 		$this->db->where('ac_invoice_fixeditems.invoice_id',$inv_id);
    $query = $this->db->get('ac_invoice_fixeditems');
     if ($query->num_rows() > 0){
      //$data= $query->row();
        return $query->result();
    }
    else
    return false;
  }
  
  	function add_invoice()
	{
		$retention = 0;
		if($this->input->post('retention') == 'YES'){
			$retention_rate = 0;
			$amount = 0;
			$amount = $this->input->post('amount');
			$retention_rate = get_rate('Invoice Retention');
			$retention = ($amount/100)*$retention_rate;
		}
		 $data=array( 
			'type' => $this->input->post('type'),
			'supplier_id' => $this->input->post('supplier_id'),
			'ledger_id' => $this->input->post('ledger_id'),
			'prj_id' => $this->input->post('project_id'),
			'date' => $this->input->post('date'),
			'inv_no' => $this->input->post('inv_no'),
			'total' => $this->input->post('amount'),
			'retention_amount' => $retention,
			'note' => $this->input->post('note'),
			'isvat' => $this->input->post('isvat'),
			'vat_amount' => $this->input->post('vat_amount'),
			'status' => 'PENDING',
			//Ticket No-2861 | Added By Uvini
			'purchase_id'=> $this->input->post('purchase_order'),
			
			
		
				);
				if ( ! $this->db->insert('ac_invoices', $data))
				{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
				
						return;
				} else {
				$entry_id = $this->db->insert_id();
				}
				if($this->input->post('type')=='F')
				{
					$assetlist=$this->get_confiremed_assets();
					$counter=0;$drtot=0;
					if($assetlist)
					{
							 foreach($assetlist as $dataraw)
							 {
								  if($this->input->post('isselect'.$dataraw->id)=="Yes"){
											 $data=array( 
											'invoice_id' => $entry_id,
											'asset_id' => $dataraw->id,
								
									);
									$insert = $this->db->insert('ac_invoice_fixeditems', $data); 
									$drlist[$counter]['ledgerid']=$dataraw->leger_acc;;
									$drlist[$counter]['amount']=$dataraw->asset_value;
									$drtot=$drtot+$dataraw->asset_value;
									$counter++;
											  $updatearr=array( 
											'statues' =>'USED'
							
		
											);
												$this->db->where('id',$dataraw->id);
											$insert = $this->db->Update('ac_fixedassets', $updatearr);
								  }
								 	
							 }
					}
						
				}
				if($this->input->post('type')=='O')
				{
									$drlist[0]['ledgerid']= $this->input->post('ledger_id');
									$drlist[0]['amount']=$this->input->post('amount');
									$drtot=$this->input->post('amount');
				}
				if($this->input->post('type')=='O' || $this->input->post('type')=='F')
				{
									$ledgerset=$this->accountinterface_model->get_account_set('Accounts Payable');
									$crlist[0]['ledgerid']= $ledgerset['Dr_account'];
									$crlist[0]['amount']=$this->input->post('amount');
									$crtot=$this->input->post('amount');
								 $enty_keu=$this->invoice_interest_entry($crlist,$drlist,$crtot,$drtot,$this->input->post('date'),$this->input->post('note'),'','');
								  $updatearr=array( 
								'entry_id' =>$enty_keu,
							
		
							);
							$this->db->where('id',$entry_id);
							$insert = $this->db->Update('ac_invoices', $updatearr);
				}
}
function delete_invoice($inv_id)
{
	if($inv_id)
	{
		$invociedata=$this->get_invoice_by_id($inv_id);
		$assetlist=$this->get_invoice_assets($inv_id);
		if($assetlist)
		{
			foreach($assetlist as $dataraw)
				{		$updatearr=array( 
						'statues' =>'CONFIRMED'
							);
								$this->db->where('id',$dataraw->id);
						$insert = $this->db->Update('ac_fixedassets', $updatearr);
									 
										
				}
		}
		$this->db->where('invoice_id',$inv_id);
		$insert = $this->db->delete('ac_invoice_fixeditems');
		if($invociedata->entry_id)
		{
			$this->db->where('id',$invociedata->entry_id);
			$insert = $this->db->delete('ac_entries');
			$this->db->where('entry_id',$invociedata->entry_id);
			$insert = $this->db->delete('ac_entry_items');
			$this->db->where('entry_id',$invociedata->entry_id);
			$insert = $this->db->delete('ac_entry_status');
		}
		$this->db->where('id',$inv_id);
		$insert = $this->db->delete('ac_invoices');
	}
	
	
}
function confirm_invoice($id)
	{
		 $data=array( 
			'status' => 'CONFIRMED',
			'aprove_by' =>  $this->session->userdata('userid'),
			'approve_date' => date('Y-m-d'),
		
		
				);
				$this->db->where('id',$id);
				$insert = $this->db->Update('ac_invoices', $data); 
				
	}
	function make_payment()
	{
		$invoiceid=explode('-', $this->input->post('invoice_id'));
		
						$data=array( 
						'invoice_id' => $invoiceid[0],
						'pay_amount' => $this->input->post('settleamount'),
						'pay_date' => $this->input->post('settledate'),
						'note' => $this->input->post('note'),
						'type' => $this->input->post('payment_type'),
						'create_by' => $this->session->userdata('userid'),
						'create_date' =>  date('Y-m-d'),
						'pay_status' => 'PENDING',
			
			
						);
						$insert = $this->db->insert('ac_invoicepayments', $data); 
						$entry_id = $this->db->insert_id();	
				
	}
  function payment_list()
  { //get all assets
   $this->db->select('ac_invoices.inv_no,ac_invoices.date,ac_invoices.type,ac_invoices.total,ac_invoicepayments.*,cm_supplierms.first_name,cm_supplierms.last_name');	
   $this->db->join('ac_invoices','ac_invoices.id=ac_invoicepayments.invoice_id','left');
	
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->order_by('ac_invoicepayments.pay_date','DESC');
			$query = $this->db->get('ac_invoicepayments'); 
		
     if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->result(); 
    }
    else
    return false;
  }

  //Ticket No:3440 Added By Madushan 2021-09-14
  function search_payment_list($sup_code,$inv_no)
  { //get all assets
   $this->db->select('ac_invoices.inv_no,ac_invoices.date,ac_invoices.type,ac_invoices.total,ac_invoicepayments.*,cm_supplierms.first_name,cm_supplierms.last_name');	
   $this->db->join('ac_invoices','ac_invoices.id=ac_invoicepayments.invoice_id','left');
	
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		if($sup_code != 'all')
			$this->db->where('ac_invoices.supplier_id',$sup_code);
		if($inv_no != 'all')
			$this->db->where('ac_invoices.inv_no',$inv_no);
		$this->db->order_by('ac_invoicepayments.pay_date','DESC');
			$query = $this->db->get('ac_invoicepayments'); 
		
     if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->result(); 
    }
    else
    return false;
  }
  //End of Ticket No:3440

   function payment_data($id)
  { //get all assets
   $this->db->select('ac_invoicepayments.*,ac_invoices.inv_no,cm_supplierms.first_name,cm_supplierms.last_name,cm_supplierms.sup_code');	
    $this->db->join('ac_invoices','ac_invoices.id=ac_invoicepayments.invoice_id','left');
	
	
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
    $this->db->where('ac_invoicepayments.id',$id);	
			$query = $this->db->get('ac_invoicepayments'); 
		
     if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->row(); 
    }
    else
    return false;
  }
  function delete_payment($id)
  {
	  if($id)
	  {
	  $this->db->where('id',$id);
		$insert = $this->db->delete('ac_invoicepayments');
	  }
  }
 function confirm_payment($id)
  {
	  
	 $advancedata=$this->payment_data($id);
	 if($advancedata->type != 'Deduction'){
	  $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
		$vaouchercode=$idlist[0];
		$ledgerset=$this->accountinterface_model->get_account_set('Accounts Payable');
		$data=array( 
		'voucherid'=>$vaouchercode,
		'vouchercode'=>$idlist[1],
		'branch_code' => $this->session->userdata('branchid'),
		'ledger_id' => $ledgerset['Dr_account'],
		'payeecode' => $advancedata->sup_code,
		'payeename' => $advancedata->first_name.' '.$advancedata->last_name,
		'vouchertype' => '3',
		'paymentdes' => $advancedata->note,
		'amount' => $advancedata->pay_amount,
		'applydate' =>$advancedata->pay_date,
		'refnumber'=>'',
		'confirmdate' =>date('Y-m-d'),
		'status' => 'CONFIRMED',
		'pf_invoice_number'=>$advancedata->inv_no,
		
		);
		if(!$this->db->insert('ac_payvoucherdata', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	 }
		
		 $data=array( 
			'voucher_id' => $vaouchercode,
			'pay_status' => 'CONFIRMED',
			'aproved_by' => $this->session->userdata('userid'),
	 		'aproved_date' =>  date('Y-m-d'),
		
				);
				$this->db->where('id',$id);
				$insert = $this->db->update('ac_invoicepayments', $data); 
				
				$invdata=$this->get_invoice_by_id($advancedata->invoice_id);
			if($invdata)
			{
				$newpay=$invdata->paidtot+$advancedata->pay_amount;
				if(round($newpay,2)==round($invdata->total,2)){
					$status='PAID';
					$retention_status = 'PAID';
				}else{
					$status='PENDING';
					$retention_status = 'PENDING';
				}
				/*$retention_paid = $this->get_retention_total_by_id($advancedata->invoice_id);
				$invoice_data = $this->get_invoice_by_id($advancedata->invoice_id);
				$retention_amount = $invoice_data->retention_amount;
				$retention_balance = $retention_amount - $retention_paid;
				if($advancedata->type == 'Retention' && $retention_balance == $advancedata->pay_amount){
					
				}*/
				 $dataaa=array( 
				'paidtot' =>$newpay,
				'paystatus' =>$status,
				'retention_status' =>$retention_status,
		
				);
				$this->db->where('id',$advancedata->invoice_id);
				$insert = $this->db->update('ac_invoices', $dataaa);
			}
  }
	
  function invoice_interest_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id)
	{
		$data_number=$this->next_entry_number(4);
		if($prj_id=='')
		$prj_id=0;
		if($lot_id=='')
		$lot_id=0;
		$this->db->trans_start();
			$insert_data = array(
				'number' => $data_number,
				'date' => $date,
				'narration' => $narration,
				'entry_type' => 4,
				'lot_id' =>$lot_id,
				'prj_id' =>$prj_id,
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
	function get_oustanding_list($sup_code,$fromdate,$todate)
	{
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		if($sup_code!='')
		$this->db->where('ac_invoices.supplier_id ',$sup_code);
		$this->db->where('ac_invoices.paystatus !=','PAID');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$this->db->group_by('ac_invoices.id');
		$this->db->order_by('supplier_id,date');
		$query = $this->db->get('ac_invoices'); 
		return $query->result(); 
	}
 function get_payment_data($sup_code,$fromdate,$todate)
  { //get all assets
 	 	$this->db->select('ac_invoicepayments.*,cm_supplierms.first_name,cm_supplierms.last_name,
   cm_supplierms.sup_code,ac_chqprint.CHQNO,ac_invoices.inv_no,ac_invoices.type,ac_invoices.date,ac_invoices.total');	
    	$this->db->join('ac_invoices','ac_invoices.id=ac_invoicepayments.invoice_id','left');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=ac_invoicepayments.voucher_id');
		$this->db->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid','left');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->where('ac_invoices.supplier_id',$sup_code);
		
			$query = $this->db->get('ac_invoicepayments'); 
		
     if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->result(); 
    }
    else
    return false;
  }
  
  	function check_pending_payments_by_invoiceid($inv_id){
		$this->db->select('ac_invoicepayments.*');
		$this->db->where('ac_invoicepayments.invoice_id',$inv_id);
		$this->db->where('ac_invoicepayments.pay_status','PENDING');
	  	$query = $this->db->get('ac_invoicepayments');
	   	if ($query->num_rows() > 0){
		  return true;
	  	}
	  	else
	  	return false;
	}
	
	function check_project_invoice($inv_id){
		$this->db->select('ac_invoices.*');
		$this->db->where('ac_invoices.id',$inv_id);
		$this->db->where('ac_invoices.prj_id !=','NULL');
	  	$query = $this->db->get('ac_invoices');
	   	if ($query->num_rows() > 0){
		  return true;
	  	}
	  	else
	  	return false;
	}
	
	function get_invoices_by_projectid($prj_id){
		$this->db->select('ac_invoices.*,cm_supplierms.first_name,cm_supplierms.last_name,SUM(ac_invoicepayments.pay_amount) as totpay');
		$this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
		$this->db->join('ac_invoicepayments','ac_invoicepayments.invoice_id=ac_invoices.id','left');
		$this->db->where('ac_invoices.paystatus !=','PAID');
		$this->db->where('ac_invoices.prj_id',$prj_id);
		$this->db->where('ac_invoices.status','CONFIRMED');
		$this->db->group_by('ac_invoicepayments.invoice_id');
		$this->db->group_by('ac_invoices.id');
		$this->db->order_by('date','DESC');
		$query = $this->db->get('ac_invoices'); 
	   	if ($query->num_rows() > 0){
		  return $query->result(); 
	  	}
	  	else
	  	return false;
	}
	
	function get_tot_confirmed_payments($inv_id){
		$this->db->select('SUM(ac_invoicepayments.pay_amount) AS total');
		$this->db->where('ac_invoicepayments.invoice_id',$inv_id);
		$this->db->where('ac_invoicepayments.pay_status','CONFIRMED');
	  	$query = $this->db->get('ac_invoicepayments');
	   	if ($query->num_rows() > 0){
		  	if($query->row()->total > 0){
		  		return $query->row()->total;
			}else{
				return 0;
			}
	  	}
	  	else
	  	return false;
	}
	
	function get_tot_pending_payments($inv_id){
		$this->db->select('SUM(ac_invoicepayments.pay_amount) AS total');
		$this->db->where('ac_invoicepayments.invoice_id',$inv_id);
		$this->db->where('ac_invoicepayments.pay_status','PENDING');
	  	$query = $this->db->get('ac_invoicepayments');
	   	if ($query->num_rows() > 0){
		  	if($query->row()->total > 0){
		  		return $query->row()->total;
			}else{
				return 0;
			}
	  	}
	  	else
	  	return false;
	}

	//Ticket No-2861 | Added By Uvini
	function get_po_payment($purchase_id)
	{
		$this->db->select('SUM(total) as tot');
		$this->db->where('purchase_id',$purchase_id);
		$this->db->where('status','CONFIRMED');
		$query = $this->db->get('ac_invoices');
	   	if ($query->num_rows() > 0){
		  	return $query->row()->tot;
	  	}
	  	else
	  	return false;
	}
  
}

