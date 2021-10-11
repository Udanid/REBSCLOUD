<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class projectpayment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	function get_get_paymentlist($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_prjacpaymentdata.*,re_projectms.project_name,re_projectms.project_code,cm_tasktype.task_name,cm_subtask.subtask_name,ac_payvoucherdata.status');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacpaymentdata.prj_id');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentdata.task_id');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid','left');
		$this->db->order_by('re_prjacpaymentdata.id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;

    }
	function count_search_paymentlist_all($branchid,$string){
		$this->db->select('re_prjacpaymentdata.*');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->like('re_projectms.project_name',$string,'both');
		$this->db->or_like('re_prjacpaymentdata.amount',$string, 'none');
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacpaymentdata.prj_id');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentdata.task_id');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid');
		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->num_rows();
		}
		else
		return false;
	}
	function get_search_paymentlist($pagination_counter, $page_count,$branchid,$string) { //get all stock
		$this->db->select('re_prjacpaymentdata.*,re_projectms.project_name,re_projectms.project_code,cm_tasktype.task_name,cm_subtask.subtask_name,ac_payvoucherdata.status');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->like('re_projectms.project_name',$string,'both');
		$this->db->or_like('re_prjacpaymentdata.amount',$string, 'none');
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacpaymentdata.prj_id');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentdata.task_id');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid','left');
		$this->db->order_by('re_prjacpaymentdata.voucherid','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;

    }
	function get_project_paymeny_task($id)
	{
		$this->db->select('re_prjacpaymentms.*,cm_tasktype.task_name');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
		$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}
	function get_project_paymeny_task_data($id,$taskid)
	{
		$this->db->select('re_prjacpaymentms.*,cm_tasktype.task_name');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false;
	}


	function check_paymentledger_set()
	{
		$this->db->select('*');

		$this->db->where('ledger_id',NULL);
		$this->db->where('status','CONFIRMED');
		$query = $this->db->get('cm_tasktype');
		if ($query->num_rows() > 0){
		//echo $query->num_rows();
			return 1;
		}
		else
		return 0;

	}
	function get_all_payto_projectlist($branchid) { //get all stock
		$this->db->select('re_projectms.prj_id,re_projectms.project_name,re_projectms.project_code,re_projectms.status');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		//$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->where('re_projectms.dp_cmp_status','PENDING');;
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
	function get_all_budget_confirm_projectlist($branchid) { //get all stock
		$this->db->select('re_projectms.prj_id,re_projectms.project_name,re_projectms.project_code,re_projectms.status');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_projectms.budgut_status',CONFIRMKEY);;
		$this->db->where('re_projectms.dp_cmp_status','PENDING');;
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
	function get_projectstatus($prj_id) { //get all stock
		$this->db->select('re_projectms.status,re_projectms.budgut_status,re_projectms.price_status');
		$this->db->where('re_projectms.prj_id',$prj_id);
		//$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms');
		return $query->row();
    }
		function get_all_max_project($branchid) { //get all stock
		$this->db->select('MAX(prj_id) as maxid');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$branchid);
		$this->db->where('status',CONFIRMKEY);;

		$query = $this->db->get('re_projectms');
		$data= $query->row();
		return  $data->maxid;
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
	function get_payment_data($voucherid)
	{
		$this->db->select('*');

		$this->db->where('voucherid',$voucherid);

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
		//$data= $query->row();
			return $query->row();
		}
		else
		return 0;

	}
	function get_payment_details($voucherid){
		$this->db->select('*');
		$this->db->where('voucherid', $voucherid);
		$query = $this->db->get('re_prjacpaymentdata');
		if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return null;
		}
	}
	function get_cashadvancedata($id)
	{
		$this->db->select('ac_cashadvance.*,hr_empmastr.initial,hr_empmastr.surname');
			$this->db->where('ac_cashadvance.adv_id',$id);
			$this->db->join('hr_empmastr','hr_empmastr.id=ac_cashadvance.officer_id');
			 $query = $this->db->get('ac_cashadvance');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function get_cashbook_data($book_id)
	{

			 $this->db->select('ac_cashbook.*,ac_cashbooktypes.type_name,ac_ledgers.name,cm_branchms.branch_name ');
		$this->db->join('ac_cashbooktypes','ac_cashbooktypes.type_id=ac_cashbook.type_id');
		$this->db->join('ac_ledgers','ac_cashbook.ledger_id=ac_ledgers.id');
		$this->db->join('cm_branchms','cm_branchms.branch_code=ac_cashbook.branch_code');
			 $this->db->where('ac_cashbook.id',$book_id);
			 $query = $this->db->get('ac_cashbook');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function add_project_payment($task_id,$subtask_id,$date,$amount,$payeename,$payeecode,$prj_id)
	{
		//$tot=$bprice*$quontity; getmaincode($idfield,$prifix,$table)
		$this->db->trans_start();
		$taskdata=$this->get_ledgerid_set($task_id);

		$prjdata=$this->get_projectstatus($prj_id);
		if($prjdata->budgut_status=='PENDING')
		$ledreid=$taskdata->adv_ledgerid;
		else
		$ledreid=$taskdata->ledger_id;
        $type=6;
		$pf_invoice_number='';
		if($this->input->post('invoice_id')!='')
		{
		$invoiceid=explode('-', $this->input->post('invoice_id'));
		$invdata=$this->get_invoicedata($invoiceid[0]);
		$pf_invoice_number=$invdata->inv_no;
		}
		//echo 'kkkkk'. $this->input->post('adv_id1');
        if($this->input->post('adv_id1')=='') //direct Payment
		{
			$idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$date);
			$id=$idlist[0];
			if(get_rate('Payment Voucher confirmation'))
			$status='PENDING';
			else
			$status='CONFIRMED';
					$data=array(
					'voucherid'=>$id,
					'vouchercode'=>$idlist[1],
					'branch_code' => $this->session->userdata('branchid'),
					'ledger_id' => $this->session->userdata('accshortcode').$ledreid,
					'payeecode' => $payeecode,
					'payeename' => $payeename,
					'vouchertype' => $type,
						'prj_id' => $prj_id,
					'paymentdes' => 'Project Payments -'.$this->input->post('description'),//updated by nadee ticket 2916
					'amount' => $amount,
					'applydate' =>$date,
					'status' => $status,
					'pf_invoice_number'=>$pf_invoice_number,

					);
					if(!$this->db->insert('ac_payvoucherdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}
					
					$data=array(
					'voucherid'=>$id,
					'prj_id' =>$prj_id,
					'task_id' => $task_id,
					'subtask_id' => $subtask_id,
					'name' => $payeename,
					'amount' =>$amount,
					'create_date' =>$date,
					'create_by' =>$this->session->userdata('username'),
          'description'=>$this->input->post('description'),//updated by nadee ticket 2916


					);
					if(!$this->db->insert('re_prjacpaymentdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}
					$masterpaydata=$this->get_project_paymeny_task_data($prj_id,$task_id);
					$totpayments=floatval($masterpaydata->tot_payments)+ floatval($amount);
					$data=array(
					'tot_payments'=>$totpayments,
					);
					$this->db->where('prj_id',$prj_id);
					$this->db->where('task_id',$task_id);
					if(!$this->db->update('re_prjacpaymentms', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}


					if($this->input->post('invoice_id')!='')
					{
						$advid=explode('-', $this->input->post('adv_id'));
						$invoiceid=explode('-', $this->input->post('invoice_id'));
						 $data=array(
									'invoice_id' => $invoiceid[0],
									'voucher_id' => $id,
									'pay_amount' => $amount,
									'pay_date' => $date,
									'pay_status' => 'CONFIRMED',
									'type'		=> 'Project',
									'create_by'	=> $this->session->userdata('userid'),
									'create_date' => date('Y-m-d'),

									);
									$insert = $this->db->insert('ac_invoicepayments', $data);
									$entry_id = $this->db->insert_id();

									$invdata=$this->get_invoicedata($invoiceid[0]);
									if($invdata)
									{
										$newpay=$invdata->paidtot+$amount;
										if(round($newpay,2)>=round($invdata->total,2)){
											$status='PAID';
											$retention_status = 'PAID';
										}else{
											$status='PENDING';
											$retention_status = 'PENDING';
										}
										 $dataaa=array(
											'paidtot' =>$newpay,
											'paystatus' =>$status,
											'retention_status' =>$retention_status,
										);
										$this->db->where('id',$invoiceid[0]);
										$insert = $this->db->Update('ac_invoices', $dataaa);
									}

					}

					$this->db->trans_complete();
        }
		else
		{

			$advid=explode('-', $this->input->post('adv_id1'));
			$adv_id=$advid['0'];
			$advancedata=$this->get_cashadvancedata($adv_id);
			$id=$advancedata->payvoucher_id;
			if($advancedata){


						$bookdata=$this->get_cashbook_data($advancedata->book_id);

						if($bookdata->pay_type=='CSH')
						$boolkedger=$bookdata->advance_ledger;
						else
						$boolkedger=$bookdata->ledger_id;
						$crlist[0]['ledgerid']=$boolkedger;
						$crlist[0]['amount']=$amount;
						$drlist[0]['ledgerid']=$this->session->userdata('accshortcode').$ledreid;
						$drlist[0]['amount']=$amount;
						$crtot=$drtot=$amount;
						$narration = $prj_id.'Project Payment with Cash Advance Settlement '  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,'','');

					//	$advid=explode('-', $this->input->post('adv_id'));
						$invoiceid=explode('-', $this->input->post('invoice_id'));
						 $data=array(
							'voucher_id' =>$advancedata->payvoucher_id,
							'adv_id' =>$adv_id,
							'invoice_id' => $invoiceid['0'],
							'settledate' => $date,
							'settleamount' => $amount,
							'note' => '',
							'status' => 'APPROVED',
							'settle_entry_id'=>$int_entry,
							'apply_by'=>$this->session->userdata('userid'),
							'apply_date'=>date('Y-m-d'),
							'approved_by'=>$this->session->userdata('userid'),
							'approved_date'=>date('Y-m-d')


							);
							$insert = $this->db->insert('ac_cashsettlement', $data);
							$entry_id = $this->db->insert_id();


								$tot=$advancedata->settled_amount+$amount;
								if($tot>=$advancedata->amount)
								{
									$status='SETTLED';
								}
								else
								$status='PAID';


									 $dataaa=array(
									'settled_amount' =>$tot,
									'status' =>$status,
									'settled_date' =>date('Y-m-d'),


									);
								$this->db->where('adv_id',$advancedata->adv_id);
								$insert = $this->db->Update('ac_cashadvance', $dataaa);


							if($this->input->post('invoice_id')!='')
							{
								$advid=explode('-', $this->input->post('adv_id'));
								$invoiceid=explode('-', $this->input->post('invoice_id'));
								 $data=array(
									'invoice_id' => $invoiceid[0],
									'voucher_id' => $advancedata->payvoucher_id,
									'pay_amount' => $amount,
									'pay_date' => $date,
									'pay_status' => 'CONFIRMED',


									);
									$insert = $this->db->insert('ac_invoicepayments', $data);
									$entry_id = $this->db->insert_id();

									$invdata=$this->get_invoicedata($invoiceid[0]);
									if($invdata)
									{
										$newpay=$invdata->paidtot+$amount;
										if(round($newpay,2)>=round($invdata->total,2)){
											$status='PAID';
											$retention_status = 'PAID';
										}else{
											$status='PENDING';
											$retention_status = 'PENDING';
										}
										 $dataaa=array(
											'paidtot' =>$newpay,
											'paystatus' =>$status,
											'retention_status' =>$retention_status,

										);
										$this->db->where('id',$invoiceid[0]);
										$insert = $this->db->Update('ac_invoices', $dataaa);
									}

							}


					$data=array(
					'voucherid'=>$advancedata->payvoucher_id,
					'prj_id' =>$prj_id,
					'task_id' => $task_id,
					'subtask_id' => $subtask_id,
					'name' => $payeename,
					'amount' =>$amount,
					'create_date' =>$date,
					'pay_type'=>'ADVANCE',
					'advance_id'=>$adv_id,
					'entry_id'=>$int_entry,

					'create_by' =>$this->session->userdata('username'),


					);
					if(!$this->db->insert('re_prjacpaymentdata', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}
					$masterpaydata=$this->get_project_paymeny_task_data($prj_id,$task_id);
					$totpayments=floatval($masterpaydata->tot_payments)+ floatval($amount);
					$data=array(
					'tot_payments'=>$totpayments,
					);
					$this->db->where('prj_id',$prj_id);
					$this->db->where('task_id',$task_id);
					if(!$this->db->update('re_prjacpaymentms', $data))
					{
							$this->db->trans_rollback();
								$this->logger->write_message("error", "Error confirming Project");
						return false;
					}


			}


		}

		return true;

	}
	function get_invoicedata($id)
	{
		$this->db->select('ac_invoices.*');
			$this->db->where('ac_invoices.id',$id);
			 $query = $this->db->get('ac_invoices');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function update_budget($prj_id,$task_id,$new_estimate,$new_budget)
	{
		$data=array(


		'estimate_budget' => $new_estimate,
		'new_budget' => $new_budget,
		);
		$this->db->where('prj_id', $prj_id);
		$this->db->where('task_id', $task_id);
		$insert = $this->db->update('re_prjacpaymentms', $data);
		return $insert;
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity;
		$data=array(


		'status' => CONFIRMKEY,
		);
		$this->db->where('voucherid', $id);
		$insert = $this->db->update('ac_payvoucherdata', $data);
		return $insert;

	}
	function get_invoicedata_payment($voucher)
	{
		$this->db->select('ac_invoicepayments.*');
			$this->db->where('ac_invoicepayments.voucher_id',$voucher);
			 $query = $this->db->get('ac_invoicepayments');
        if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
	}
	function delete($id)
	{
		//echo $id;
		//$tot=$bprice*$quontity;
		if($id)
		{
			$data=$this->get_payment_data($id);
	
			$invoicepayment=$this->get_invoicedata_payment($id);
			$masterpaydata=$this->get_project_paymeny_task_data($data->prj_id,$data->task_id);
			$totpayments=floatval($masterpaydata->tot_payments)- floatval($data->amount);
			$data2=array(
			'tot_payments'=>$totpayments,
			);
			$this->db->where('prj_id',$data->prj_id);
			$this->db->where('task_id',$data->task_id);
			if(!$this->db->update('re_prjacpaymentms', $data2))
			{
					$this->db->trans_rollback();
						$this->logger->write_message("error", "Error confirming Project");
				return false;
			}
			 if($data->pay_type=='DIRECT'){
				$this->db->where('voucherid', $id);
				$insert = $this->db->delete('ac_payvoucherdata');
			 }
			 else
			 {
				 $advancedata=$this->get_cashadvancedata($data->advance_id);
		
				 $tot=$advancedata->settled_amount-$data->amount;
										$status='PAID';
											 $dataaa=array(
											'settled_amount' =>$tot,
											'status' =>$status,
											'settled_date' =>date('Y-m-d'),
											);
										$this->db->where('adv_id',$advancedata->adv_id);
										$insert = $this->db->Update('ac_cashadvance', $dataaa);
					if($data->entry_id)
					{
					 $this->db->where('id', $data->entry_id);
					 $insert = $this->db->delete('ac_entries');
					 $this->db->where('entry_id', $data->entry_id);
					 $insert = $this->db->delete('ac_entry_items');
					}
				 $this->db->where('voucher_id', $id);
				 $insert = $this->db->delete('ac_cashsettlement');
			 }
			 if($invoicepayment)
			 {
					$invoicedata= $this->get_invoicedata($invoicepayment->invoice_id);
					$newpay=$invoicedata->paidtot-$data->amount;;
					$status='PENDING';
						 $dataaa=array(
						'paidtot' =>$newpay,
						'paystatus' =>$status,
		
		
						);
						$this->db->where('id',$invoicepayment->invoice_id);
						$insert = $this->db->Update('ac_invoices', $dataaa);
		
			 }
			if($id)
			{
				$this->db->where('voucherid', $id);
				$insert = $this->db->delete('re_prjacpaymentdata'); 
			}

			$this->db->where('voucher_id', $id);
			$insert = $this->db->delete('ac_invoicepayments');


		}
		return $insert;

	}
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
        $query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where   applydate  between '".$fromdate."' and '".$todate."'");

        $newid="";

        if ($query->num_rows > 0) {
            $data = $query->row();
            $prjid=$data->id;
            //echo $prjid;
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
    //Ticket No:3352 Updated By Madushan 2021-08-30
	function projectname_by_voucherid($voucherid) { //get all stock
		$this->db->select('re_prjacpaymentdata.*,re_projectms.project_name');
		$this->db->where('re_prjacpaymentdata.voucherid',$voucherid);
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacpaymentdata.prj_id');
		$this->db->order_by('re_prjacpaymentdata.voucherid','DESC');
		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			$date= $query->row();
			return $date->project_name;
		}
		else
		{
			$this->db->select('re_projectms.project_name');
			$this->db->where('re_hmacpaymentdata.voucherid',$voucherid);
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_hmacpaymentdata.lot_id');
			$this->db->join('re_projectms','re_projectms.prj_id=re_prjaclotdata.prj_id');
			$this->db->order_by('re_hmacpaymentdata.voucherid','DESC');
			$query = $this->db->get('re_hmacpaymentdata');
			if ($query->num_rows() > 0){
				$date= $query->row();
				return $date->project_name;
			}
			else
				return '';
		}

    }
    function get_project_details($prj_id){
		$this->db->select('*');
		$this->db->where('prj_id', $prj_id);
		$query = $this->db->get('re_projectms');
		return $query->row_array();
    }
}
