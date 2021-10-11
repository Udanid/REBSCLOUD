<?php

class Paymentvoucher_model extends CI_Model {

    function ac_projects_model()
    {
        parent::__construct();
    }

    function get_pending_payment_vouchers($branchid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata')->where('status ',"PENDING")->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')->order_by('voucherid', 'DESC');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	function get_approved_payment_vouchers($branchid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata')->where('status ',"CONFIRMED")->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')->order_by('voucherid', 'DESC');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	//Edited by eranga to add supplier name Ticket 2735
	function get_approved_payments_range($branchid,$start_date,$end_date,$supplier_name,$entry_type_id)
    {
		$supplier_name=urldecode($supplier_name);
		/*$this->db->select('ac_payvoucherdata.*,ac_chqprint.*,ac_payvoucher_type.typename,ac_entries.entry_type,ac_ledgers.name');
		$this->db->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid');
		$this->db->join('ac_ledgers','ac_ledgers.id=ac_payvoucherdata.ledger_id');
		$this->db->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid');
		$this->db->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype');
		$this->db->where('ac_payvoucherdata.status',"PAID")->where('ac_payvoucherdata.branch_code',$branchid)->where('ac_entries.date <=',$end_date)->where('ac_entries.date >=',$start_date);
		$this->db->order_by('ac_payvoucherdata.paymentdate', 'ASC');
        $query = $this->db->get('ac_payvoucherdata');*/
		$this->db->from('ac_entries')->where('ac_entries.date <=',$end_date)->where('ac_entries.date >=',$start_date)->where('status !=','PENDING');
		if($supplier_name != ''){ //added by Eranga Ticket 2735
			$this->db->like('ac_chqprint.CHQNAME',$supplier_name,'both');
		}
		$this->db->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->where('entry_type', $entry_type_id)->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'asc');
		$query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;

    }

    function get_payment_voucher_byid($id)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata')->where('voucherid',$id)->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }
    function get_confirm_payment_vouchers()
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata')->where('status',"CONFIRMED")->order_by('confirmdate', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
    function get_employeedata()
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_employees_data')->order_by('name', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
    function get_supplierData()
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_suppliers_data')->order_by('name', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
    function get_vouchertypes()
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucher_type')->where('entry_flag', 'M')->order_by('typeid', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
    function get_invoicelist($id)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_invoices')->where('supplier_id',$id)->where('paystatus',"PENDING")->order_by('date', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
    function get_notpaid_invoicelist($id)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_invoices')->where('supplier_id',$id)->where('paystatus !=',"PAID")->order_by('date', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
    function get_supplierdata_byid($id)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_suppliers_data')->where('id',$id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }
//    function getmaincode($idfield,$prifix,$table,$datemount)
//    {
//        $date=$this->config->item('account_fy_start');
//        $year= substr($datemount,0,4);
//        $myyear=substr($datemount,2,2);
//        $mymont=substr($datemount,5,2);
//        $prifix="PV".$myyear.$mymont."-";
//        $fromdate=$year."-".$mymont."-01";
//        $todate=$year."-".$mymont."-31";
//        $query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where applydate between '".$fromdate."' and '".$todate."'");
//
//
//
//        $newid="";
//
//        if ($query->num_rows > 0) {
//            $data = $query->row();
//            $prjid=$data->id;
//
//            echo $prjid;
//            if($data->id==NULL)
//            {
//                $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);
//
//
//            }
//            else{
//                $prjid=substr($prjid,7,5);
//                $id=intval($prjid);
//                $newid=$id+1;
//                $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);
//
//
//            }
//        }
//        else
//        {
//
//            $newid=str_pad(1, 5, "0", STR_PAD_LEFT);
//            $newid=$prifix.$newid;
//        }
//        return $newid;
//
//    }
    /// functions added while developing payment entry

    function getmaincode($idfield,$prifix,$table,$datemount)
    {
        // $date=$this->config->item('account_fy_start');
        // echo $this->session->userdata('shortcode');
        $prifix=$this->session->userdata('accshortcode').$prifix;
        //echo  $prifix;
        $year= substr($datemount,0,4);
        $myyear=substr($datemount,2,2);
        $mymont=substr($datemount,5,2);
        $prifix=$prifix.$myyear.$mymont."-";
        $fromdate=$year."-".$mymont."-01";
        $todate=$year."-".$mymont."-31";
        $query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where applydate  between '".$fromdate."' and '".$todate."'");

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
        return $newid;

    }
    function get_paymentvouchres_by_type($id,$branchid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata');
		if($id!='ALL')
		 $this->db->where('vouchertype',$id);
		 $this->db->where('status',"CONFIRMED")->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')->order_by('voucherid', 'desc')->limit(120, 0);;//updated by nadee 2748
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;
    }
    function get_paymentvouchres_by_supid($typeid,$supid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata')->where('payeecode',$supid)->where('vouchertype',$typeid)->where('status',"CONFIRMED")->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')->order_by('applydate', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;
    }
    function get_paymentvouchres_by_entryid($entryid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_payvoucherdata')->where('entryid',$entryid)->where('status',"PAID")->order_by('applydate', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;
    }

    function get_paymentvouchres_ledgers_by_entryid($entryid){
        $this->db->from('ac_payvoucherdata')->join('ac_ledgers', 'ac_payvoucherdata.ledger_id = ac_ledgers.id', 'left')->where('entryid',$entryid)->order_by('applydate', 'asc');
        $ledger_q = $this->db->get();
        if($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else{
			return null;
		}
    }

    function get_incomes_by_entryid($entryid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('re_prjacincome')->where('id',$entryid)->where('pay_status',"PENDING")->order_by('income_date', 'asc');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;
    }
    function get_incomesByEntryid($entryid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->select('re_prjacincome.*,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->where('re_prjacincome.id',$entryid);
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_prjacincome.cus_code');
		$this->db->where('re_prjacincome.pay_status',"PENDING")->order_by('re_prjacincome.income_date', 'asc');
        $ledger_q = $this->db->get('re_prjacincome');
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;
    }
    function get_chequedata_by_entryid($entryid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('ac_chqprint')->where('PAYREFNO',$entryid);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;
    }
    function get_incomedata_by_entryid($entryid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('re_incomentires')->where('income_id',$entryid);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;
    }

    function check_new(){
        $this->db->select('COUNT( * ) as payments')->from('ac_payvoucherdata')->where('status','PENDING');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }

    function edit()
    {
        //$tot=$bprice*$quontity;
        //$id=$this->getmaincode('voucherid','PV','ac_payvoucherdata');
        $arr=explode(',',$this->input->post('payeename', TRUE));
       //         $payeecode=$arr[0];
       //         $payeename=$arr[1];
        $data=array(

            'refnumber' => $this->input->post('refnumber'),
            'vouchertype' => $this->input->post('vouchertype'),
          //  'applydate' => $this->input->post('entry_date'),
            'applymonth' => $this->input->post('applymonth'),
            'amount' => $this->input->post('amount'),
            'payeename'=> $this->input->post('payeename'),
			   'branch_code'=> $this->input->post('branch_code'),
       //     'payeecode'=>$this->input->post('payeename'),
            'paymentdes' => $this->input->post('paymentdes'),
        );
        $this->db->where('voucherid', $this->input->post('voucherid'));
        $insert = $this->db->update('ac_payvoucherdata', $data);

        // //added by nadee to update vochher data for projectpayment 2020_05_22
        // if($insert){
        //   $this->db->select('*');
        //   $this->db->where('voucherid', $this->input->post('voucherid'));
        //   $query=$this->db->get('re_prjacpaymentdata');
        //   if($query->num_rows()>0){
        //     $querydata=$query->row();
        //     if($querydata->amount!=$this->input->post('amount')){
        //       $project_data=array(
        //         'amount'=>$this->input->post('amount'),
        //       );
        //       $this->db->where('voucherid', $this->input->post('voucherid'));
        //       $insert2 = $this->db->update('re_prjacpaymentdata', $project_data);
        //
        //
        //       //update project data
        //       $this->db->select('*');
        //
        //   		$this->db->where('re_prjacpaymentms.prj_id',$querydata->prj_id);
        //   		$this->db->where('re_prjacpaymentms.task_id',$querydata->task_id);
        //   		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
        //
        //   		$query2 = $this->db->get('re_prjacpaymentms');
        //   		 if ($query2->num_rows >0) {
        //               $masterpaydata=$query2->row();
        //               $totpayments=(floatval($masterpaydata->tot_payments)- floatval($querydata->amount))+floatval($this->input->post('amount'));
        //     					$data=array(
        //     					'tot_payments'=>$totpayments,
        //     					);
        //     					$this->db->where('prj_id',$querydata->prj_id);
        //     					$this->db->where('task_id',$querydata->task_id);
        //     					$update3=$this->db->update('re_prjacpaymentms', $data);
        //           }
        //
        //
        //     }
        //
        //   }
        //
        //   //added by nadee to update vochher data for projectpayment 2020_05_22 end
        // }

        if($insert){
        return $insert;

    }
	}
	function delete_payvoucher_check($voucherid)
	{
		$flag=true;
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('ac_invoicepayments');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('payvoucher_id',$voucherid);
			$query = $this->db->get('ac_cashadvance');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('ac_cashsettlement');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_code',$voucherid);
			$query = $this->db->get('re_adresalepayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_code',$voucherid);
			$query = $this->db->get('hm_adresalepayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('re_arreaspayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('hm_arreaspayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_code',$voucherid);
			$query = $this->db->get('re_epresalepayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_code',$voucherid);
			$query = $this->db->get('hm_epresalepayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucherid',$voucherid);
			$query = $this->db->get('re_prjacpaymentdata');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucherid',$voucherid);
			$query = $this->db->get('hm_prjacpaymentdata');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('re_charge_stampfee');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('hm_charge_stampfee');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('ac_outside_loanspayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('ac_outside_loanspayment');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}
			$this->db->select('*');
			$this->db->where('voucher_id',$voucherid);
			$query = $this->db->get('hr_fuel_allowance_payment_master');
        	if ($query->num_rows() > 0) {
				$flag=false;
			}

			return $flag;


	}

  //2020-12-16 updated by nadee
function get_vouchers_by_entryid($entry_id,$ledger_id)
{//Ticket No:3153 Updated By Madushan 2021-07-21
  $this->db->select('ac_payvoucherdata.voucherid,ac_payvoucherdata.payeecode,ac_payvoucherdata.direct_payid,ac_payvoucherdata.voucherid as voucher_ncode');//ticket number 653
  $this->db->where('ac_payvoucherdata.ledger_id',$ledger_id);
  $this->db->where('ac_payvoucherdata.entryid',$entry_id);
  $query = $this->db->get('ac_payvoucherdata');
   if ($query->num_rows >0) {
      return $query->result();
    }
  else
    return false;
  
  
}

//Ticket No:3426 Added By Madushan 2021-09-13
function get_invoice_vouchers_by_entryid($entry_id,$ledger_id)
{//Ticket No:3153 Updated By Madushan 2021-07-21
  $this->db->select('ac_payvoucherdata.voucherid,ac_payvoucherdata.payeecode,ac_payvoucherdata.direct_payid,ac_payvoucherdata.voucherid as voucher_ncode');
   
    $this->db->join('ac_invoicepayments','ac_invoicepayments.voucher_id = ac_payvoucherdata.voucherid ');
    $this->db->join('ac_invoices','ac_invoices.id = ac_invoicepayments.invoice_id');
   $this->db->where('ac_invoices.entry_id',$entry_id);
    $query = $this->db->get('ac_payvoucherdata');
    if ($query->num_rows >0) {
      return $query->result();
    }
    else
        return false;
  
}

function get_inv_payment_details($entry_id)
{//Ticket No:3153 Updated By Madushan 2021-07-21
  $this->db->select('ac_chqprint.CHQNO,ac_chqprint.CHQNAME');
   $this->db->join('ac_payvoucherdata','ac_payvoucherdata.entryid = ac_chqprint.PAYREFNO');

    $this->db->join('ac_invoicepayments','ac_invoicepayments.voucher_id = ac_payvoucherdata.voucherid ');
    $this->db->join('ac_invoices','ac_invoices.id = ac_invoicepayments.invoice_id');
     
   $this->db->where('ac_invoices.entry_id',$entry_id);
    $query = $this->db->get('ac_chqprint');
    if ($query->num_rows >0) {
      return $query->row();
    }
    else
        return false;
  
}

//End of Ticket No:3426

// added by udani ticket number 2637
//2021-04-06
function get_voucher_stampfeelist($id)
	{
		$this->db->select('re_projectms.project_name,re_prjaclotdata.lot_number,re_charge_stampfee.paid_amount');
			$this->db->join('re_resevation','re_resevation.res_code=re_charge_stampfee.res_code');
			$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_charge_stampfee.voucher_id');
			  $this->db->where('ac_payvoucherdata.voucherid',$id);

		$query = $this->db->get('re_charge_stampfee');
		 if ($query->num_rows >0) {
		$data= $query->result();
		$list='';
			foreach($data as $raw)
			{
				$list=$list.$raw->project_name.' - '.$raw->lot_number .' - Rs .'.number_format($raw->paid_amount).'<br>';
			}
			return $list;
        }
		else
		return false;
	}

}
