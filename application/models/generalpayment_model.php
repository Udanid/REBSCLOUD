<?php

class Generalpayment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function get_resale_advance()
	{
		$this->db->select('re_adresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		//$this->db->join('re_prjacincome','re_prjacincome.id=re_epresale.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_adresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

				$this->db->order_by('re_adresale.apply_date','DESC');
		$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_resale_loan()
	{
		$this->db->select('re_epresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
	//	$this->db->join('re_prjacincome','re_prjacincome.id=re_epresale.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		$this->db->order_by('re_epresale.apply_date', 'DESC');
		$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_resale_loan_data($code)
	{
		$this->db->select('re_epresalepayment.*,re_resevation.prj_id,re_resevation.lot_id,re_resevation.res_code');
		$this->db->join('re_epresalepayment','re_epresalepayment.resale_code=re_epresale.resale_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
		$this->db->where('re_epresale.resale_code',$code);
		$this->db->order_by('re_epresale.apply_date', 'DESC');
		$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
	}
	function get_resale_advance_data($code)
	{
		$this->db->select('re_adresalepayment.*,re_resevation.res_code,re_resevation.prj_id,re_resevation.lot_id');
		$this->db->join('re_adresalepayment','re_adresalepayment.resale_code=re_adresale.resale_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		
		$this->db->where('re_adresale.resale_code',$code);
		$this->db->order_by('re_adresale.apply_date', 'DESC');
		$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
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
    function add_payment()
    {
			$refnumber = $this->input->post('refnumber');
            $branch_code = $this->session->userdata('branchid');
            $applymonth=$this->input->post('applymonth');
            $payeename=$this->input->post('payeename');
            $vouchertype = $this->input->post('vouchertype');
            $paymentdes = $this->input->post('paymentdes');
            $amount = str_replace(',','',$this->input->post('amount'));
            $data_date = $this->input->post('entry_date');
			$bank_account = $this->input->post('bank_account');
			$draccount = $this->input->post('draccount');
			$payment_mode = $this->input->post('payment_mode');
			$pay_mode = $this->input->post('pay_mode');
			$resale_code = $this->input->post('resale_code');
			$payarr=explode('-',$payeename);
			if(count($payarr)>1)
			{
				$payeecode=$payarr[0];
				$payeename=$payarr[1];
			}
			else
			{
				$payeecode=$this->add_supplier($payeename);
			}
			$resaletype='';
			$prj_id=0;$lot_id=0;
			if($vouchertype==101)
			{
				$vouchertype=6;
				$resaletype='Loan';
				$resaldata=$this->get_resale_loan_data($resale_code);
				$prj_id=$resaldata->prj_id;
				$lot_id=$resaldata->lot_id;
			}
			if($vouchertype==102)
			{
				$vouchertype=6;
				$resaletype='Advance';
				$resaldata=$this->get_resale_advance_data($resale_code);
				$prj_id=$resaldata->prj_id;
				$lot_id=$resaldata->lot_id;
			}
			echo $amount.$resale_code.$resaletype;
			
			 $this->db->trans_start();
			// $id=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$data_date);
			 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$data_date);
		$id=$idlist[0];
			 $data_narration=$paymentdes;
			 $data_tag=0;
			 $data_type=2;
			 $nextid=$this->next_entry_number($data_type);
			  $insert_data = array(
                'number' => $nextid,
                'date' => $data_date,
                'narration' => $data_narration,
                'entry_type' => $data_type,
                'tag_id' => $data_tag,
				'dr_total' => $amount,
				'cr_total' => $amount,
				'prj_id' => $prj_id,
				'lot_id' => $lot_id,
				
            );
            if ( ! $this->db->insert('ac_entries', $insert_data))
            {
                $this->db->trans_rollback();
               return false;
            } else {
                $entry_id = $this->db->insert_id();
            }
			 
	       $insert_data1 = array(
                'voucherid'=>$id,
				'vouchercode'=>$idlist[1],
                'refnumber' => $refnumber,
                'branch_code'=> $branch_code,
                'applymonth'=>$applymonth,
                'payeecode' => $payeecode,
                'payeename' => $payeename,
                'vouchertype' => $vouchertype,
                'paymentdes' => $paymentdes,
                'amount' => $amount,
				'paymenttype'=>$payment_mode,
                //'applydate' => date_php_to_mysql($data_date),
                'applydate' => $data_date,
                'status' =>'PAID',
				'entryid'=>$entry_id

            );
			
       		 if ( ! $this->db->insert('ac_payvoucherdata', $insert_data1))
            {
                $this->db->trans_rollback();
				return false;
			}
			 $insert_ledger_data = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $bank_account,
                    'amount' => $amount,
                    'dc' => 'C',
                );
                if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
				{
					 $this->db->trans_rollback();
				return false;
				}
				$insert_ledger_data = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $draccount,
                    'amount' => $amount,
                    'dc' => 'D',
                );
                if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
				{
					 $this->db->trans_rollback();
				return false;
				}
         
			 if($payment_mode=="CHQ")
			 {
				 if($pay_mode=='YES')
				 $chequedrownto=$payeename;
				 else
				 $chequedrownto='CASH';
              	  $datacheque=array('CHQBID'=>1	,'CHQNAME'=>$chequedrownto,"PAYREFNO"=>$entry_id,"CHQSTATUS"=>"QUEUE","CRDATE"=>date("Y-m-d H:i:s") ,'ac_pay' =>$pay_mode);
             	  if(! $this->db->insert('ac_chqprint',$datacheque ))
                {
                    $this->db->trans_rollback();
                  	 return false;
               	 }


            }
            $entrystat=array (
                'entry_id'=>$entry_id,
                'status'=>"PENDING",
				'added_by'=> $this->session->userdata('userid')
            );
			
            $this->db->insert('ac_entry_status', $entrystat);
			if($resaletype!='')
			{
				$vouchertype=6;
				//$resaletype='Loan';
				$resaldata=$this->update_resale_refund($resaletype,$resale_code,$entry_id,$id,$amount,$data_date);
				//$prj_id=$resaldata->prj_id;
				//$lot_id=$resaldata->lot_id;
			}
			
			
			
			 $this->db->trans_complete();
			 return true;
			
    }
	function update_resale_refund($resaletype,$resale_code,$entry_id,$id,$amount,$data_date)
	{
		if($resaletype=='Advance')
		{
			
			$resaledata=$this->get_resale_advance_data($resale_code);
			print_r($resaledata);
			
			 		 $newactual=$resaledata->actual_paidamount+$amount;
					 $transferamount=0;
					 if($resaledata->total_payment<= $resaledata->actual_paidamount)
					 {
						 $transferamount=$amount;
					 }
					 else
					 {
						 if( $newactual>$resaledata->total_payment)
						 {
							 $transferamount=$newactual-$resaledata->total_payment;
						 }
						 else
						 $transferamount=0;
					 }
			//$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
					$int_entry=0;
					if($transferamount>0)
					{
						$incomleddger=get_account_set('Block Resale Income');
						$crlist[0]['ledgerid']=$incomleddger['Dr_account'];
						$crlist[0]['amount']=$crtot=$transferamount;
						$drlist[0]['ledgerid']=$incomleddger['Cr_account'];
						$drlist[0]['amount']=$drtot=$transferamount;
						$narration = $resaledata->res_code.'Additional Paymetn Expence Resale refund '  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$data_date,$narration,$resaledata->prj_id,$resaledata->lot_id,$resaledata->res_code);
					}
			
					 $insert_data1 = array(
					'res_code'=>$resaledata->res_code,
					'type' => 'Advance',
					'resale_code'=>$resaledata->resale_code,
					'voucher_id'=>$id,
					'payentry_id' =>$entry_id,
					'trnentry_id' =>$int_entry,
					 'amount' =>$amount,
					 'refund_date'=>$data_date
					 );
				
					 $this->db->insert('re_resalerefund', $insert_data1);
					
					 
					  $updatedata1 = array(
				
					 'actual_paidamount' => $newactual,
					 );
						$this->db->where('id', $resaledata->id);
					 $this->db->update('re_adresalepayment', $updatedata1);
			
		}
		if($resaletype=='Loan')
		{
			$resaledata=$this->get_resale_loan_data($resale_code);
			$newactual=$resaledata->actual_paidamount+$amount;
			echo $newactual;
					 $transferamount=0;
					 if($resaledata->total_payment<= $resaledata->actual_paidamount)
					 {
						 $transferamount=$amount;
					 }
					 else
					 {
						 if( $newactual>$resaledata->total_payment)
						 {
							 $transferamount=$newactual-$resaledata->total_payment;
						 }
						 else
						 $transferamount=0;
					 }
			//$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
					$int_entry=0;
					if($transferamount>0)
					{
						$incomleddger=get_account_set('Block Resale Income');
						$crlist[0]['ledgerid']=$incomleddger['Dr_account'];
						$crlist[0]['amount']=$crtot=$transferamount;
						$drlist[0]['ledgerid']=$incomleddger['Cr_account'];
						$drlist[0]['amount']=$drtot=$transferamount;
						$narration = $resaledata->res_code.'Additional Paymetn Expence Resale refund '  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$data_date,$narration,$resaledata->prj_id,$resaledata->lot_id,$resaledata->res_code);
					}
			
					 $insert_data1 = array(
					'res_code'=>$resaledata->res_code,
					'type' => 'Loan',
					'resale_code'=>$resaledata->resale_code,
					'voucher_id'=>$id,
					'payentry_id' =>$entry_id,
					'trnentry_id' =>$int_entry,
					 'amount' =>$amount,
					 'refund_date'=>$data_date
					 );
				
					 $this->db->insert('re_resalerefund', $insert_data1);
					
					 
					  $updatedata1 = array(
				
					 'actual_paidamount' => $newactual,
					 );
						$this->db->where('id', $resaledata->id);
					 $this->db->update('re_epresalepayment', $updatedata1);
			
			
		}
	}
	function delete_resale_refund($entryid)
	{
		if($entryid)
		{
		$this->db->select('*');
			$this->db->where('payentry_id', $entryid);
		$query = $this->db->get('re_resalerefund');
			if ($query->num_rows() > 0){
				
				$data=$query->row();
				if($data->type=='Advance')
				{
					$resaledata=$this->get_resale_advance_data($data->resale_code);
					$newactual=$resaledata->actual_paidamount-$data->amount;
					 $updatedata1 = array(
					
						 'actual_paidamount' => $newactual,
						 );
							$this->db->where('id', $resaledata->id);
						 $this->db->update('re_adresalepayment', $updatedata1);
				}
				if($data->type=='Loan')
				{
					$resaledata=$this->get_resale_loan_data($data->resale_code);
					$newactual=$resaledata->actual_paidamount-$data->amount;
					 $updatedata1 = array(
					
						 'actual_paidamount' => $newactual,
						 );
							$this->db->where('id', $resaledata->id);
						 $this->db->update('re_epresalepayment', $updatedata1);
				}
				$this->db->where('payentry_id', $entryid);
				$this->db->delete('re_resalerefund');
				$this->db->where('id',$data->trnentry_id);
				$this->db->delete('ac_entries');
				$this->db->where('entry_id',$data->trnentry_id);
				$this->db->delete('ac_entry_items');
				$suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
				 $this->db->where('voucherid',$data->voucher_id)->update('ac_payvoucherdata',$suparray );
				
			}
		}

		
	}
	function add_supplier($fist_name)
	{
		//$tot=$bprice*$quontity; 
		$id=$this->getmaincode('sup_code','SUP','cm_supplierms');
		$data=array( 
		'sup_code'=>$id,
		'create_date' => date("Y-m-d"),
		'first_name' => $fist_name,
		
		'create_by' => $this->session->userdata('username'),
		
		);
		$insert = $this->db->insert('cm_supplierms', $data);
		
		return $id;
		
	}
	
	function get_resale_loan_data_update()
	{
		$this->db->select('re_epresalepayment.*,re_resevation.prj_id,re_resevation.lot_id,re_resevation.res_code,ac_payvoucherdata.status,ac_payvoucherdata.entryid');
		$this->db->join('re_epresalepayment','re_epresalepayment.resale_code=re_epresale.resale_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_epresalepayment.voucher_code');
			$this->db->order_by('re_epresale.apply_date', 'DESC');
		$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

			$dataset=$query->result();
			foreach($dataset as $raw)
			{
				if($raw->status=='PAID')
				{
					 $insert_data1 = array(
					'res_code'=>$raw->res_code,
					'type' => 'Loan',
					'resale_code'=>$raw->resale_code,
					'voucher_id'=>$raw->voucher_code,
					'payentry_id' => $raw->entryid,
					 'amount' => $raw->total_payment,
					 );
				
					 $this->db->insert('re_resalerefund', $insert_data1);
					 
					  $updatedata1 = array(
				
					 'actual_paidamount' => $raw->total_payment,
					 );
						$this->db->where('id', $raw->id);
					 $this->db->update('re_epresalepayment', $updatedata1);
					 echo 'Loan'.$raw->res_code.'-'.$raw->voucher_code.'-'.$raw->total_payment.'<br>';
            
				}
				else
				{
					$updatedata1 = array(
				
					 'status' => 'SYSTEM CANCEL',
					 );
						$this->db->where('voucherid', $raw->voucher_code);
					 $this->db->update('ac_payvoucherdata', $updatedata1);
					  echo 'Loan'.$raw->voucher_code.'- Cancelled '.'<br>';
				}
			}
		}
		else
		return 0;
	}
	function get_resale_advance_data_update()
	{
		$this->db->select('re_adresalepayment.*,re_resevation.prj_id,re_resevation.lot_id,re_resevation.res_code,ac_payvoucherdata.status,ac_payvoucherdata.entryid');
		$this->db->join('re_adresalepayment','re_adresalepayment.resale_code=re_adresale.resale_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_adresalepayment.voucher_code');
		$this->db->order_by('re_adresale.apply_date', 'DESC');
		$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		$dataset=$query->result();
		foreach($dataset as $raw)
			{
				if($raw->status=='PAID')
				{
					 $insert_data1 = array(
					'res_code'=>$raw->res_code,
					'type' => 'Advance',
					'resale_code'=>$raw->resale_code,
					'voucher_id'=>$raw->voucher_code,
					'payentry_id' => $raw->entryid,
					 'amount' => $raw->total_payment,
					 );
				
					 $this->db->insert('re_resalerefund', $insert_data1);
					 
					  $updatedata1 = array(
				
					 'actual_paidamount' => $raw->total_payment,
					 );
						$this->db->where('id', $raw->id);
					 $this->db->update('re_adresalepayment', $updatedata1);
					  echo 'Advance'.$raw->res_code.'-'.$raw->voucher_code.'-'.$raw->total_payment.'<br>';
            
				}
				else
				{
					$updatedata1 = array(
				
					 'status' => 'SYSTEM CANCEL',
					 );
						$this->db->where('voucherid', $raw->voucher_code);
					 $this->db->update('ac_payvoucherdata', $updatedata1);
					  echo 'Advance'.$raw->voucher_code.'- Cancelled '.'<br>';
				}
			}
		
		}
		else
		return 0;
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
			 $newid=$prifix.str_pad(1, 4, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 4, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;
	
	}
}
