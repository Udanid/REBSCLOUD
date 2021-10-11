<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_model extends CI_Model{

	function get_all_loans($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('ac_outside_loans');
		return $query->result();
	}
	function getbank_byid($id)
	{
		$this->db->select('BANKCODE,BANKNAME');
		$this->db->where('BANKCODE', $id);

		$query = $this->db->get('cm_banklist');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return 0;
	}

	function get_all_projects(){
		$this->db->select('*');
		$this->db->order_by('project_name', 'desc');
		$query = $this->db->get('re_projectms');
		return $query->result();
	}

	function get_blocks_by_projects($prjid)
	{
		$this->db->select('lot_number,extend_perch,price_perch');
		$this->db->order_by('lot_number', 'desc');
		$this->db->where('prj_id',$prjid);
		$query = $this->db->get('re_prjaclotdata');
		return $query->result();
	}

	function get_all_assets(){
		$this->db->select('id,asset_code,asset_name');
		$this->db->order_by('asset_name', 'Asc');
		$this->db->where_not_in('statues','PENDING');
    $this->db->where_not_in('statues','DISPOSAL');
		$this->db->where_not_in('statues','USED');
		$query = $this->db->get('ac_fixedassets');
		return $query->result();
	}

	function get_all_legers(){
		$this->db->select('id,name');
		$this->db->order_by('id', 'Asc');
		$query = $this->db->get('ac_ledgers');
		return $query->result();
	}

	function add(){
		$assets=Null;
		$project=$this->input->post('project');
		$fasset=$this->input->post('assets');
		$lot_no=$this->input->post('lots');
		$m_assets=$this->input->post('m_assets');
		$sub_type=Null;
		$pymethod=$this->input->post('method');
		if(!$this->input->post('sub_type')){
			$sub_type=$this->input->post('sub_type');
		}
		if($project){
			$assets=$project;
			$sub_type="inventory";
		}
		if($fasset){
			$assets=$fasset;
			$sub_type="fixed_assets";
			//block asset
		}
		if($m_assets){
			$assets=$m_assets;

		}
		if($this->input->post('loan_type')=="free"){
			$sub_type='free';
			$assets=Null;
		}
		if(!$pymethod){
			$pymethod="0";
		}
		$data=array(
			'loan_type' => $this->input->post('loan_type'),
			'sub_loan_type' => $sub_type,
			'asset_id' =>$assets,
			'loan_number' => $this->input->post('loan_number'),
			'loan_amount' => $this->input->post('loan_amount'),
			'interest_rate' => $this->input->post('interest_rate'),
			'loan_date' => $this->input->post('loan_date'),
			'monthly_or_maturity' => $this->input->post('monthly_or_maturity'),
			'payment_start_date' => $this->input->post('loan_paymentdate'),
			'fixed_vary_installments' => $this->input->post('fixed_vary_installments'),
			'grace_period' => $this->input->post('grace_period'),
			'total_period' => $this->input->post('total_period'),
			'grace_period_installment_value' => $this->input->post('grace_period_installment_value'),
			'loan_installment_value' => $this->input->post('loan_installment_value'),
			'onetime_charges' => $this->input->post('onetime_charges'),
			'bank_code' => $this->input->post('bank1'),
			'branch_id' => $this->input->post('branch1'),
			'bank_account_no' => $this->input->post('acc1'),
			'leger_account_no' => $this->input->post('leger_acc'),
			'credit_leger_acc' => $this->input->post('credit_leger_acc'),
			'payment_method' => $pymethod,
			//'loan_status' => $this->input->post(''),
			'created_by' => $this->session->userdata('username'),
			'created_at' => date("Y-m-d"),


		);

		$insert = $this->db->insert('ac_outside_loans', $data);
		$id = $this->db->insert_id();
		if($insert){
			if($this->input->post('loan_type')!="free"){
				foreach ($lot_no as $key) {
					$get_perchval=$this->get_perch_val($project,$key);
					$data1 = array('loan_id' =>$id,
					'prj_id' =>$project,
					'lot_no' => $key,
					'value_per_perch'=>$this->input->post('lotperch'),
					'mortgage_extend'=>$get_perchval->extend_perch);
					$insert = $this->db->insert('ac_outside_loansprjs', $data1);
				}
			}
		}
		return $id;
	}
	function get_perch_val($project,$key){
		$this->db->select('lot_number,extend_perch,price_perch');
		$this->db->where('prj_id',$project);
		$this->db->where('lot_number',$key);
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return 0;
	}
	function get_loan_byid($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);

		$query = $this->db->get('ac_outside_loans');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return 0;
	}

	function getlot_no_byid($id)
	{
		$this->db->select('lot_no');
		$this->db->where('loan_id', $id);

		$query = $this->db->get('ac_outside_loansprjs');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return 0;
	}
	function getasset_byid($id)
	{
		$this->db->select('id,asset_name,asset_code');
		$this->db->where('id', $id);

		$query = $this->db->get('ac_fixedassets');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return 0;
	}
	function getprj_byid($id)
	{
		$this->db->select('land_code,project_name');
		$this->db->where('prj_id', $id);

		$query = $this->db->get('re_projectms');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
		return 0;
	}

	function edit($id){
		$assets=Null;
		$project=$this->input->post('project');
		$fasset=$this->input->post('assets');
		$lot_no=$this->input->post('lots2');
		$m_assets=$this->input->post('m_assets');
		$sub_type=Null;
		if($this->input->post('sub_type')){
			$sub_type=$this->input->post('sub_type');
		}

		if($fasset){
			$assets=$fasset;
			$sub_type="fixed_assets";
		}
		if($project){
			$assets=$project;
			$sub_type="inventory";
		}
		if($m_assets){
			$assets=$m_assets;

		}
		if($this->input->post('loan_type')=="free"){
			$sub_type='free';
			$assets=Null;
		}
		$data=array(
			'loan_type' => $this->input->post('loan_type'),
			'sub_loan_type' => $sub_type,
			'asset_id' =>$assets,
			'loan_number' => $this->input->post('loan_number'),
			'loan_amount' => $this->input->post('loan_amount'),
			'interest_rate' => $this->input->post('interest_rate'),
			'loan_date' => $this->input->post('loan_date'),
			'monthly_or_maturity' => $this->input->post('monthly_or_maturity'),
			'payment_start_date' => $this->input->post('loan_paymentdate'),
			'fixed_vary_installments' => $this->input->post('fixed_vary_installments'),
			'grace_period' => $this->input->post('grace_period'),
			'total_period' => $this->input->post('total_period'),
			'grace_period_installment_value' => $this->input->post('grace_period_installment_value'),
			'loan_installment_value' => $this->input->post('loan_installment_value'),
			'onetime_charges' => $this->input->post('onetime_charges'),
			'bank_code' => $this->input->post('bank1'),
			'branch_id' => $this->input->post('branch1'),
			'bank_account_no' => $this->input->post('acc1'),
			'leger_account_no' => $this->input->post('leger_acc'),
			'credit_leger_acc' => $this->input->post('credit_leger_acc'),
			'payment_method' => $this->input->post('method'),
			//'payment_status' => $this->input->post(''),
			//'loan_status' => $this->input->post(''),
		);
		$this->db->where('id', $id);
		$update = $this->db->update('ac_outside_loans', $data);
		if($update){
			if($this->input->post('loan_type')!="free"){
				$this->db->where('loan_id',$id);
				$this->db->delete('ac_outside_loansprjs');

				foreach ($lot_no as $key) {
					$get_perchval=$this->get_perch_val($project,$key);
					$data1 = array('loan_id' =>$id,
					'prj_id' =>$project,
					'lot_no' => $key,
					'value_per_perch'=>$this->input->post('lotperch'),
					'mortgage_extend'=>$get_perchval->extend_perch);
					$insert = $this->db->insert('ac_outside_loansprjs', $data1);
		}
	}

			return true;
		}
		else
		return 0;

	}

	function get_pending_loans()
	{
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->where('loan_status','pending');
		$query = $this->db->get('ac_outside_loans');
		return $query->result();
	}
	function confirm($id)
	{
		$data=array('loan_status'=>'approved',
		'approved_by'=>$this->session->userdata('username'),
		'approved_at'=>date("Y-m-d"),
	);

	$this->db->where('id', $id);
	$update = $this->db->update('ac_outside_loans', $data);
	if($update){
		$this->db->select('leger_account_no,credit_leger_acc,loan_amount,loan_type,asset_id,loan_date');
		$this->db->where('id', $id);
		$query = $this->db->get('ac_outside_loans');
		if ($query->num_rows() > 0){
			$result=$query->row();
			$amount=$result->loan_amount;
			$crlist[0]['ledgerid']=$result->leger_account_no;
			$crlist[0]['amount']=$amount;
			$drlist[0]['ledgerid']=$result->credit_leger_acc;
			$drlist[0]['amount']=$amount;
			$crtot=$drtot=$amount;
			$date=$result->loan_date;
			$narration='Loan id:'.$id.' -  Loan Amount '.$amount.'Transfers';
			$entryid=$this->loan_interest_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
			if($result->loan_type="lease"){
				$asset_id=$result->asset_id;
				$updatearr=array(
			'statues' =>'USED'
			);
				$this->db->where('id',$asset_id);
			$insert = $this->db->Update('ac_fixedassets', $updatearr);
			}

		}
		return true;
	}
	else
	return 0;
}
function get_loans_numbers()
{
	$this->db->select('id,loan_number');
	$this->db->order_by('id', 'desc');
	$this->db->where('loan_status','approved');
	$query = $this->db->get('ac_outside_loans');
	return $query->result();
}
function get_sheduleloans_numbers()
{
	$this->db->select('ac_outside_loans.id,ac_outside_loans.loan_number');
	$this->db->join('ac_outside_loansshedule','ac_outside_loans.id = ac_outside_loansshedule.loan_id','INNER');
	$this->db->group_by('ac_outside_loans.id');
	$query = $this->db->get('ac_outside_loans');
	return $query->result();
}
function addshedule_filename($file_name)
{
	$data=array(
		'loan_no'=> $this->input->post('loan_no'),
		'file_name'=>$file_name,
		'add_by'=>$this->session->userdata('username'),
	);
	$insert = $this->db->insert('ac_outside_loanuploads', $data);
	$id = $this->db->insert_id();

	return $id;
}
function addshedule($data)
{

	$insert = $this->db->insert('ac_outside_loansshedule', $data);
	$id = $this->db->insert_id();

	return $id;
}
function delete_ex_shedule()
{
	$this->db->where('loan_id',$this->input->post('loan_no'));
	$this->db->where('pay_status !=','PAID');
	$this->db->delete('ac_outside_loansshedule');
	return true;
}
function get_shedule_by_loans($sheduleid)
{
	$this->db->select('id,loan_id,instalment,cap_amount,int_amount,tot_instalment,deu_date,pay_date,pay_status,cheque_no');
	$this->db->order_by('instalment', 'ASC');
	$this->db->where('loan_id',$sheduleid);
	$query = $this->db->get('ac_outside_loansshedule');
	return $query->result();
}

function get_repaymentdelay_shedeule($loan_id,$date)
{
	$this->db->select('id,loan_id,instalment,cap_amount,int_amount,tot_instalment,deu_date,pay_date,pay_status,cheque_no');
	$this->db->order_by('instalment', 'ASC');
	$this->db->where('loan_id',$loan_id);
	$this->db->where('deu_date<',$date);
	$this->db->where('pay_status','PENDING');
	$query = $this->db->get('ac_outside_loansshedule');
	return $query->result();
}

function get_repayment_shedeule($loan_id)
{
	$this->db->select('id,loan_id,instalment,cap_amount,int_amount,tot_instalment,deu_date,pay_date,pay_status,cheque_no');
	$this->db->order_by('instalment', 'ASC');
	$this->db->where('loan_id',$loan_id);
	$this->db->where('pay_status','PENDING');
	$this->db->limit(1);
	$query = $this->db->get('ac_outside_loansshedule');
	return $query->result();
}

function add_payment()
{
	$this->db->trans_start();

	$data=array(
		'loan_id'=>$this->input->post('loan_no'),
		'ins_id'=>$this->input->post('instalment_no'),
		'pay_amount'=>$this->input->post('pay_amount'),
		'cap_amount'=>$this->input->post('cap_amount'),
		'int_amount'=>$this->input->post('int_amount'),
		'payment_method'=>'0',
		'voucher_id'=>'',
		'entry_id'=>'0',
		'pay_type'=>$this->input->post('pay_type'),
		'pay_date'=>$this->input->post('paydate'),
		'payment_statues'=>'Pending',
		'created_by'=>$this->session->userdata('username'),
		'created_at'=>date("Y-m-d"),

	);
	$insert = $this->db->insert('ac_outside_loanspayment', $data);
	$id = $this->db->insert_id();

	$this->db->trans_complete();
	return $id;
}
function payment_details()
{
	$this->db->select('pay_id,loan_id,ins_id,pay_amount,cap_amount,int_amount,payment_method,voucher_id,entry_id,pay_date,
	pay_type,payment_statues,created_by,created_at');
	$this->db->order_by('pay_date','DESC');
	$query = $this->db->get('ac_outside_loanspayment');
	return $query->result();
}

function payment_details_by_loan($id)
{
	$this->db->select('pay_id,loan_id,ins_id,pay_amount,cap_amount,int_amount,payment_method,voucher_id,entry_id,pay_date,
	pay_type,payment_statues,created_by,created_at');
	$this->db->order_by('pay_date','DESC');
	$this->db->where('loan_id',$id);
	$this->db->where('payment_statues','Confirmed');
	$query = $this->db->get('ac_outside_loanspayment');
	return $query->result();
}

function get_paydata_byid($id)
{
	$this->db->select('pay_id,loan_id,ins_id,pay_amount,cap_amount,int_amount,payment_method,voucher_id,entry_id,pay_date,
	pay_type,payment_statues,created_by,created_at');
	$this->db->where('pay_id', $id);

	$query = $this->db->get('ac_outside_loanspayment');
	if ($query->num_rows() > 0){
		return $query->row();
	}
	else
	return 0;
}
function cornfirm_payment($arrayName)
{
	 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
	$vaouchercode=$idlist[0];
	$this->db->trans_start();
	$shedule_update=array(
		'pay_status '=>'PAID',
		'pay_date'=>$arrayName[7],

	);
	$this->db->where('loan_id', $arrayName[1]);
	$this->db->where('instalment', $arrayName[5]);
	$update = $this->db->update('ac_outside_loansshedule', $shedule_update);
	$data=array(
		'voucher_id'=>$vaouchercode,
		'payment_statues'=>'Confirmed',
		'confirm_by'=>$this->session->userdata('username'),
		'confirm_at'=>date("Y-m-d"),

	);
	$this->db->where('pay_id', $arrayName[8]);
	$insert = $this->db->update('ac_outside_loanspayment', $data);
	$data2=array(
		'voucherid'=>$vaouchercode,
		'vouchercode'=>$idlist[1],
		'branch_code' => $this->session->userdata('branchid'),
		'ledger_id' => $arrayName[2],
		'payeecode' => $arrayName[3],
		'payeename' =>$arrayName[4],
		'vouchertype' => '7',
		'paymentdes' => 'Outside Loan',
		'amount' => $arrayName[6],
		'applydate' =>$arrayName[7],
		'status' => 'CONFIRMED',
		'confirmdate'=>date("Y-m-d"),

	);
	$this->db->insert('ac_payvoucherdata', $data2);
	$id = $this->db->insert_id();
	$this->db->trans_complete();
	return $id;
}
function edit_payment($id)
{
	;
	$data=array(
		'pay_amount'=>$this->input->post('pay_amount'),
		'cap_amount'=>'0',
		'int_amount'=>'0',
		'pay_type'=>'capital_payment',
		'payment_statues'=>'Pending',
		'created_by'=>$this->session->userdata('username'),
		'created_at'=>date("Y-m-d"),

	);
	$this->db->where('pay_id',$id);
	$insert = $this->db->update('ac_outside_loanspayment', $data);
	if($update){
		return true;
	}
	else
	return 0;
}
function get_loans(){
	$this->db->select('*');
	$this->db->where('loan_status','approved');
	$this->db->order_by('id', 'desc');
	$query = $this->db->get('ac_outside_loans');
	return $query->result();
}
function getpaid_details_byid($id){
	$this->db->select('SUM(pay_amount) AS totpay_amount,SUM(cap_amount) AS totcap_amount,SUM(int_amount) AS totint_amount,COUNT(pay_id) AS tot_pay_count');
	$this->db->where('loan_id', $id);
	$this->db->where('payment_statues', 'Confirmed');
	$query = $this->db->get('ac_outside_loanspayment');
	if ($query->num_rows() > 0){
		return $query->row();
	}
	else
	return 0;
}
function getpaid_shedule_byid($id)
{
	$this->db->select('SUM(tot_instalment) AS tot_instalment,SUM(cap_amount) AS cap_amount,
	SUM(int_amount) AS int_amount,COUNT(instalment) AS instalment_count');
	$this->db->where('loan_id', $id);
	$this->db->where('pay_status', 'PAID');
	$query = $this->db->get('ac_outside_loansshedule');
	if ($query->num_rows() > 0){
		return $query->row();
	}
	else
	return 0;
}
function getpending_shedule_byid($id)
{
	$date=date('Y-m-d');
	$this->db->select('SUM(tot_instalment) AS pendingtot_instalment,SUM(cap_amount) AS pendingcap_amount,
	SUM(int_amount) AS pendingint_amount,COUNT(instalment) AS pendinginstalment_count');
	$this->db->where('loan_id', $id);
	$this->db->where('pay_status', 'PENDING');
	$this->db->where('deu_date <', $date);
	$query = $this->db->get('ac_outside_loansshedule');
	if ($query->num_rows() > 0){
		return $query->row();
	}
	else
	return 0;
}
function get_fixed_asset($id)
{
	$this->db->select('id,category_id,asset_code,asset_name,branch,asset_value,year,quantity,remarks
	');
	$this->db->where('id', $id);
	$query = $this->db->get('ac_fixedassets');
	if ($query->num_rows() > 0){
		return $query->row();
	}
	else
	return 0;

}
function get_prj_lotlist($prj_id,$id)
{
	$this->db->select('*');
	$this->db->where('loan_id',$id);
	$this->db->where('prj_id',$prj_id);
	$query = $this->db->get('ac_outside_loansprjs');
	return $query->result();
}
function get_due_amounts($stdate,$endate)
{
	$this->db->select('ac_outside_loans.id,
ac_outside_loans.loan_number,
ac_outside_loans.loan_amount,
ac_outside_loansshedule.instalment,
ac_outside_loansshedule.id,
ac_outside_loansshedule.cap_amount,
ac_outside_loansshedule.int_amount,
ac_outside_loansshedule.tot_instalment,
ac_outside_loansshedule.deu_date,
ac_outside_loansshedule.pay_status,
ac_outside_loans.bank_code,
ac_outside_loansshedule.cheque_no');
	$this->db->where('deu_date >',$stdate);
	$this->db->where('deu_date <',$endate);
	$this->db->join("ac_outside_loans", "ac_outside_loansshedule.loan_id = ac_outside_loans.id");
	$query = $this->db->get('ac_outside_loansshedule');
	return $query->result();
}

function get_shedule_by_deudate($date)
{
	$this->db->select('id,loan_id,instalment,cap_amount,int_amount,tot_instalment,deu_date,pay_date,pay_status,cheque_no');
	$this->db->order_by('instalment', 'ASC');
	$this->db->where('deu_date',$date);
	$query = $this->db->get('ac_outside_loansshedule');
	if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;

}
function ac_outside_loansacc()
{
	$this->db->select('interest_acc');
	$this->db->where('id', '1');
	$query = $this->db->get('ac_outside_loansacc');
	if ($query->num_rows() > 0){
		$data=$query->row();
		return $data->interest_acc;
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
function transfer_loan_interest($date)
{
	$loanshedhule=$this->get_shedule_by_deudate($date);
	if($loanshedhule){
	foreach($loanshedhule as $raw)
	{

		$loandata=$this->get_loan_byid($raw->loan_id);
		$account=$this->ac_outside_loansacc();
		$intamount=$raw->int_amount;
		$crlist[0]['ledgerid']=$loandata->leger_account_no;
		$crlist[0]['amount']=$intamount;
		$drlist[0]['ledgerid']=$account;
		$drlist[0]['amount']=$intamount;
		$crtot=$drtot=$intamount;
		$date=$date;
		$narration=$loandata->loan_number.' -  Loan Instalment '.$raw->instalment.' Interest Transfers';
		$entryid=$this->loan_interest_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
		$update_data = array(
				'int_entryid' =>$entryid,
			);
			if ( ! $this->db->where('id', $raw->id)->update('ac_outside_loansshedule', $update_data))
			{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error Updating since failed inserting entry Items");
				$this->template->load('template', 'entry/add', $data);
				return false;
			}
	}
	}
}
function loan_interest_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id)
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
	//2018-11-13
	function mortgage_update($id)
	{
		$lot_no=$this->input->post('lots2');

		foreach ($lot_no as $key) {
			$data = array('statues_active' => 0,
			'release_at'=>date("Y-m-d"),
			'release_by'=>$this->session->userdata('username'));
			$this->db->where('loan_id', $this->input->post('loan_id'));
			$this->db->where('prj_id', $this->input->post('prj_id'));
			$this->db->where('lot_no', $key);
			$update = $this->db->update('ac_outside_loansprjs', $data);
		}

	}
	function get_mortage_relese_data_loans()
	{
		$this->db->select('ac_outside_loans.loan_number,ac_outside_loans.id,ac_outside_loans.asset_id,re_projectms.project_name');
		$this->db->join('re_projectms','re_projectms.prj_id = ac_outside_loansprjs.prj_id');
		$this->db->join('ac_outside_loans','ac_outside_loansprjs.loan_id = ac_outside_loans.id');
		$this->db->group_by('ac_outside_loans.loan_number');
		$query = $this->db->get('ac_outside_loansprjs');
		if ($query->num_rows() > 0){
			return $query->result();
			}
			else
			return false;

	}
//Ticket No:2537 Added By Madushan
	function total_capital_amount($res_code,$date)
	{	
		$this->db->select('re_eploanpayment.cap_amount,re_resevation.down_payment');
		$this->db->from('re_eploanpayment');
		$this->db->join('re_eploan','re_eploan.loan_code = re_eploanpayment.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code = re_eploan.res_code');
		$this->db->where('re_eploan.res_code',$res_code);
		$this->db->where('re_eploanpayment.pay_date <=',$date);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
			return false;

	}
	
	//Ticket No-2683 | Added By Uvini
	function cal_total_capital_amount($loan_code)
	{
		$this->db->select('re_eploanpayment.cap_amount');
		$this->db->from('re_eploanpayment');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
			return false;
	}

}
