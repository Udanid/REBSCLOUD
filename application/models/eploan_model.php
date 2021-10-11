	<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Eploan_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->model("accountinterface_model");
			//$this->load->model("financialtransfer_model");

    }
	function get_all_reservation_eploan_summery($branchid) { //get all stock
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.id_number,cm_customerms.last_name,re_eploan.loan_status,re_eploan.loan_code,re_eploan.start_date,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
	//	Ticket No:3231 Updated by Madushan 2021-08-03
		//$this->db->where('re_eploan.loan_status <>','PENDING');
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->order_by('re_eploan.start_date','DESC');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_eploan_summery_all($branchid) { //get all stock
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.id_number,cm_customerms.last_name,re_eploan.loan_status,re_eploan.loan_code,re_eploan.loan_type,re_eploan.start_date,re_eploan.unique_code,re_eploan.loan_amount');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_eploan.loan_status !=','PENDING');
		$this->db->order_by('re_eploan.start_date','DESC');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_eploan_summery_officer($userid) { //get all stock
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.id_number,cm_customerms.last_name,re_eploan.loan_status,re_eploan.loan_code,re_eploan.loan_type,re_eploan.start_date,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		$this->db->where('re_eploan.collection_officer',$userid);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->order_by('re_eploan.start_date','DESC');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }


	function get_all_reservation_eploan($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_status,re_eploan.loan_code,re_eploan.loan_type,re_eploan.start_date,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
			$this->db->where('re_eploan.loan_status','CONFIRMED');
			$this->db->order_by('re_eploan.start_date','DESC');

		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_eploan_all($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_status,re_eploan.loan_code,re_eploan.loan_type,re_eploan.start_date,re_eploan.unique_code,re_eploan.loan_amount');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
	$this->db->where('re_eploan.loan_status !=','PENDING');
			$this->db->order_by('re_eploan.loan_code','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_eploan_officer($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_status,re_eploan.loan_code,re_eploan.loan_type,re_eploan.start_date,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
			$this->db->where('re_eploan.collection_officer',$userid);
			$this->db->where('re_eploan.loan_status','CONFIRMED');

		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_eploan_data($rescode) { //get all stock
		$this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.pay_type,re_resevation.discounted_price,re_resevation.profit_status,re_resevation.lot_id,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.lot_id');
		$this->db->where('re_eploan.loan_code',$rescode);
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_repayment_shedeule($rescode) { //get all stock
		$this->db->select('*');
		$this->db->where('loan_code',$rescode);
		$this->db->order_by('reschdue_sqn,deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_paid_totals($rescode) { //get all stock
	$resdata=$this->get_eploan_data($rescode);
		$this->db->select('SUM(cap_amount)as totpaidcap,SUM(int_amount) as totpaidint,SUM(di_amount) as totpaiddi');
		$this->db->where('loan_code',$rescode);
		$this->db->where('reschdue_sqn',$resdata->reschdue_sqn);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_balanc_cap_epb($rescode) { //get all stock
	$resdata=$this->get_eploan_data($rescode);
	$paidtot=$this->get_paid_totals($rescode);
	$balcap=$resdata->loan_amount;
	if($paidtot)
	{
		$balcap=$resdata->loan_amount-$paidtot->totpaidcap;
	}
	return $balcap;

    }
	function get_int_total($rescode) { //get all stock

	$resdata=$this->eploan_model->get_eploan_data($rescode);
	//echo $rescode;
		if($resdata->loan_type!='EPB')
		{
			$this->db->select('SUM(int_amount)as totpaidint');
			$this->db->where('loan_code',$rescode);
			$this->db->where('reschdue_sqn',$resdata->reschdue_sqn);
			$query = $this->db->get('re_eploanshedule');
			if ($query->num_rows() > 0){
			$data= $query->row();
			return $data->totpaidint;
			}
			else
				return 0;
		}
		else {
			  $date1=date_create($resdata->start_date);
			  $date2=date_create( date("Y-m-d"));
			  $totint=0;
				if($date1< $date2)
				{
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					$totint=($resdata->loan_amount*$resdata->interest*$dates)/(100*12*365);
				}
				return 0;
		}

    }

	function get_paid_list($rescode) { //get all stock
	$resdata=$this->eploan_model->get_eploan_data($rescode);
		$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.delay_int,re_eploanshedule.cap_amount as ins_cap,re_eploanshedule.int_amount as ins_int,re_eploanshedule.tot_payment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
		$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$this->db->where('re_eploanpayment.reschdue_sqn',$resdata->reschdue_sqn);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
    }

    //Ticket No:3087 Added By Madushan 2021-07-12
    function get_last_payment_date_to_date_range($fromdate,$todate,$loan_code)
    {
    	$this->db->select_max('pay_date');
    	$this->db->where('loan_code',$loan_code);
    	$this->db->where('pay_date >=',$fromdate);
    	$this->db->where('pay_date <=',$todate);
    	$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->row()->pay_date;
		}
		else
		return 0;

    }

	function get_paid_list_epb($rescode) { //get all stock

		$this->db->select('re_eploanpayment.*,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;

    }

	function get_thismonth_payment($loancode,$prvdate,$futureDate) { //get all stock
		$this->db->select('SUM(re_eploanpayment.cap_amount) as mysum, SUM(re_eploanpayment.int_amount) as intsum');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->where('re_eploanpayment.loan_code',$loancode);
		$this->db->where('re_eploanpayment.pay_date >=',$prvdate);
		$this->db->where('re_eploanpayment.pay_date <=',$futureDate);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->group_by('re_eploanpayment.loan_code');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		$data= $query->row();
		$tot=$data->mysum+$data->intsum;
		return $tot;
		}
		else
		return 0;
    }
	function get_thismonth_payment_di($loancode) { //get all stock
		$this->db->select('SUM(re_eploanpayment.cap_amount) as mysum, SUM(re_eploanpayment.di_amount) as disum');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->where('re_eploanpayment.loan_code',$loancode);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->group_by('re_eploanpayment.loan_code');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		$data= $query->row();
		$tot=$data->disum;
		return $tot;
		}
		else
		return 0;
    }
		function get_arrias_instalments($rescode,$date) { //get all stock
		$this->db->select('re_eploanshedule.*');
		$this->db->where('loan_code',$rescode);
		$this->db->where('pay_status','PENDING');
		$this->db->where('deu_date <',$date);
		$this->db->order_by('deu_date','DESC');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

		function get_current_instalment($rescode) { //get all stock
		$this->db->select('MIN(id),re_eploanshedule.*');
		$this->db->where('loan_code',$rescode);
		$this->db->where('pay_status','PENDING');
		$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
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
	function get_paid_instalment($rescode) { //get all stock
		$this->db->select('COUNT(id) as paidtot');
		$this->db->where('loan_code',$rescode);
		$this->db->where('pay_status','PAID');
		$query = $this->db->get('re_eploanshedule');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data=$query->row();
		return  $data->paidtot;
		}
		else
		return 0;
    }
	function rental_payment()
	{
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
		$retruncharge=get_pending_return_charge($resdata->cus_code);
		$intpaytot=0;

		$ledgerset=get_account_set('EP Rental');
		 if($resdata->loan_type=='ZEP'){
			$ledgerset=$this->accountinterface_model->get_account_set('ZEP Rental');

		}
		if($resdata->loan_type=='EPB'){
			$ledgerset=$this->accountinterface_model->get_account_set('EPB Rental');

		}
		if($resdata->loan_type=='NEP'){
			$ledgerset=$this->accountinterface_model->get_account_set('EP Rental');

		}

		$this->db->trans_start();
			$insert_data = array(
				'temp_code' =>  $resdata->loan_code,
					'res_code' =>  $resdata->res_code,
				'pri_id' =>$resdata->prj_id,
				'lot_id' =>$resdata->lot_id,
				'cus_code' =>$resdata->cus_code,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Rental Payment',
				'amount' => $this->input->post('payment'),
				'income_date' =>$this->input->post('paydate'),
				 'temp_rct_no'=>$this->input->post('temp_receipt'),
       			 'temp_income_date'=>$this->input->post('temp_receipt_date'),
			);
			if ( ! $this->db->insert('re_prjacincome', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}
			//Document Fee insert



				$paylist=$this->input->post('inslist');
				$paytot=$this->input->post('payment');
				$paytot=$paytot-$retruncharge;
				$totdi=$this->input->post('totdelayint');
				$wave_off_total=$this->input->post('wave_off_total');

				$payarray=explode(',',$paylist);
				$$delaypaytot=0; $thiswaveoff=0;

	for($k=0; $k<count($payarray); $k++)
				{
					$thiswaveoff=0;
					$currentdi=$instalmentdi=floatval($this->input->post('raw_delayint'.$payarray[$k]));


					if($currentdi < $wave_off_total)
					{

						$thiswaveoff=$currentdi;
						$wave_off_total=$wave_off_total-$currentdi;
						$currentdi=0;

					}
					else
					{
						$currentdi=$currentdi-$wave_off_total;
						$thiswaveoff=$wave_off_total;
						$wave_off_total=0;
					}

					$thisdata=$this->get_this_instalment($payarray[$k]);
					$current_paiddi=0;$paid_cap=0;$paid_int=0;
					if($instalmentdi>0 && $paytot>0)
					{

						if($paytot>$currentdi)
						{
						$current_paiddi=$currentdi;
						$paytot=$paytot-$currentdi;
						}
						else
						{
							$current_paiddi=$paytot;
							$paytot=0;
						}

						$delaypaytot=$current_paiddi+$delaypaytot;
						$balancedi=floatval($thisdata->balance_di)+$current_paiddi;

								//$delaytot=$delaytot+$paid_delayint;
								if($thiswaveoff>0){


									$balancedi=floatval($thisdata->balance_di)+$thiswaveoff;
									$uptodate_balancedi=0;
									 $insert_data = array(
									'pay_date' => $this->input->post('paydate'),
									'delay_int' =>$thiswaveoff,
									'balance_di' => $balancedi,
									'uptodate_balancedi' =>$uptodate_balancedi,
									);
								$this->db->where('id',$thisdata->id);
								if ( ! $this->db->Update('re_eploanshedule', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}

									 $insert_data = array(
									'loan_code' => $resdata->loan_code,
									'reschdue_sqn' => $resdata->reschdue_sqn,
									'ins_id' =>$thisdata->id,
									'di_amount' => $thiswaveoff,
									'rct_id'=>$entry_id,
									//'cap_entry'=>'',
									'pay_date'=>$this->input->post('paydate'),
									'create_by'=>$this->session->userdata('userid'),
									);
							//	$this->db->where('id',$thisdata->id);
								if ( ! $this->db->insert('re_epdiwaveoff', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}

								//$paytot=$paytot+$current_paiddi;
							//	$delaypaytot=$delaypaytot-$current_paiddi;

							}
							if($current_paiddi>0)
							{

								$uptodate_balancedi=$currentdi-$current_paiddi;
								 $insert_data = array(
									'pay_date' => $this->input->post('paydate'),
									'delay_int' =>$currentdi,
									'balance_di' => $balancedi,
									'uptodate_balancedi' =>$uptodate_balancedi,
									);
								$this->db->where('id',$thisdata->id);
								if ( ! $this->db->Update('re_eploanshedule', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
								 $insert_data = array(
									'loan_code' => $resdata->loan_code,
									'reschdue_sqn' => $resdata->reschdue_sqn,
									'ins_id' =>$thisdata->id,
									'di_amount' => $current_paiddi,
									'rct_id'=>$entry_id,
									//'cap_entry'=>'',
									'pay_date'=>$this->input->post('paydate'),
									);
							//	$this->db->where('id',$thisdata->id);
								if ( ! $this->db->insert('re_eploanpayment', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
							}

					}
				}		/*}*/
				/**/
				for($k=0; $k<count($payarray); $k++)
				{
					$thisdata=$this->get_this_instalment($payarray[$k]);
					if($thisdata){
					$curren_int=$thisdata->int_amount-$thisdata->paid_int;
					$curren_cap=$thisdata->cap_amount-$thisdata->paid_cap;
					$balance_tot=$curren_int+$curren_cap;
					$current_paidint=0;
					$current_paidcap=0;
					if($balance_tot>0 && $paytot>0)
					{
						if($thisdata->cap_amount<0)
						{ //
							$balanceins=$thisdata->tot_instalment-($thisdata->paid_int+$thisdata->cap_amount);
						//	echo  'balanace instalment :'.$balanceins.'payment tatal'.$paytot;
							if(round($balanceins,2)<=round($paytot,2))
							{
								//echo 'full payment done true';
								$current_paidint=$curren_int;
								$paytot=$paytot-($curren_int+$thisdata->cap_amount);
								$current_paidcap=$thisdata->cap_amount;
							}
							else
							{
								//	echo 'pr elsecome to this'.$current_paidcap;
								$current_paidint=$paytot;
								$paytot=0;
							}
						}
						else{
							$curren_cap=$thisdata->cap_amount-$thisdata->paid_cap;
							$balance_tot=$curren_int+$curren_cap;
							//echo 'come to this'.$current_paidcap;
								if(round($paytot,2)>=round($balance_tot,2))
									{
									$current_paidint=$curren_int;
									$current_paidcap=$curren_cap;
									$paytot=$paytot-$balance_tot;
									}
								else
									{
										if($paytot>$curren_int)
										{
											$current_paidint=$curren_int;
											$paytot=$paytot-$curren_int;
											$current_paidcap=$paytot;
											$paytot=0;
										}
										else
										{
											$current_paidint=$paytot;
											$current_paidcap=0;
											$paytot=0;
										}
									}
						}
					//	echo 'currentpaidcap _int'.$current_paidcap;
						$paidtot=$thisdata->paid_int+$current_paidint;
						$paidtotcap=$thisdata->paid_cap+$current_paidcap;
						$tot_payment=$thisdata->tot_payment+$current_paidint+$current_paidcap;
						$currenttotpay=$current_paidint+$current_paidcap;;
						$intpaytot=$intpaytot+$current_paidint;
						//echo 'mypendings _int'.$paidtot;
						if($paidtotcap==$thisdata->cap_amount)
								$status='PAID';
								else $status='PENDING';
						 $insert_data = array(
									'pay_date' => $this->input->post('paydate'),
									'paid_int' =>$paidtot,
									'paid_cap' =>$paidtotcap,
									'tot_payment'=>$tot_payment,
									'pay_status'=>$status,
									);
								$this->db->where('id',$thisdata->id);
								if ( ! $this->db->Update('re_eploanshedule', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
								//$delaytot=$delaytot+$paid_delayint;
								 $insert_data = array(
									'loan_code' => $resdata->loan_code,
									'reschdue_sqn' => $resdata->reschdue_sqn,
									'ins_id' =>$thisdata->id,
										'pay_amount' =>$currenttotpay,
									'int_amount' => $current_paidint,
									'cap_amount' => $current_paidcap,
									'rct_id'=>$entry_id,
									//'cap_entry'=>'',
									'pay_date'=>$this->input->post('paydate'),
									);
							//	$this->db->where('id',$thisdata->id);
								if ( ! $this->db->insert('re_eploanpayment', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
					}
					}
				}

				 $currentpaydate=date_create($this->input->post('paydate'));
				$delaytot=0;
			while($paytot>0)
				{ //echo 'while loop';
					$delay_date=0;
						$thisdata=$this->get_current_instalment($resdata->loan_code);
						if($thisdata){
						$balance_total=$thisdata->tot_instalment-($thisdata->paid_cap+$thisdata->paid_int);
							$dalay_int=0;
						$paid_delayint=0;
						$paid_int=0;
						$paid_cap=0;
						$delay_entry=0;
						$int_entry=0;
						$balance_di=$thisdata->balance_di;


							$current_cap=$thisdata->cap_amount-$thisdata->paid_cap;
							if($current_cap<0)
							{

								$paid_cap=$current_cap;
								//$paid_int=$paid_int-$current_cap;
								$current_int=$thisdata->int_amount-$thisdata->paid_int;

							//	echo "after Delay int".$paytot;
								if($current_int>0)
								{
									if(round($paytot,2)>=round($current_int,2))
									{
										//echo 'This value paytpt wishalayi ***'.$paytot;
										$paid_int=$current_int;
										$paytot=$paytot-($current_int+$current_cap);
										$paid_cap=$current_cap;
									}
									else
									{ //echo 'This value***'.$paytot;
										if(round($thisdata->tot_instalment,2)<=round($paytot,2))
										{
											$paid_int=$current_int;
											$paytot=$paytot-($current_int+$current_cap);
											$paid_cap=$current_cap;
											//echo 'This value intalment kudai condition'.$paytot;
										}
										else{
										$paid_int=$paytot;
										$paytot=0;
										$paid_cap=0;
										}
									}


								}

							}
							else{
									//echo 'This value---'.$paytot;
							if($paytot>0)
							{
								$current_int=$thisdata->int_amount-$thisdata->paid_int;


								if($current_int>0)
								{
									if($paytot>=$current_int)
									{
										$paid_int=$current_int;
										$paytot=$paytot-$current_int;
									}
									else
									{

										$paid_int=$paytot;
										$paytot=0;

									}


								}
							}
							if($paytot>0)
							{
								//echo "after  int".$paytot;
								$current_cap=$thisdata->cap_amount-$thisdata->paid_cap;
								if($current_cap>0)
								{
									if($paytot>=$current_cap)
									{
										$paid_cap=$current_cap;
										$paytot=$paytot-$current_cap;
									}
									else
									{
										$paid_cap=$paytot;
										$paytot=0;
									}


								}

								//echo "after Delay int".$paytot;

							}
							}
							//$paytot=0;
								//echo "current cap".$paytot;
								$paidamount=$paid_cap+$paid_delayint+$paid_int;
								$paidins=$paid_cap+$paid_int;
								$this_paytot=$thisdata->tot_payment+$paid_cap+$paid_int;
								$newcap=$thisdata->paid_cap+$paid_cap;
								$newint=$thisdata->paid_int+$paid_int;
								$paidtotal=$newcap+$newint;
								$newdelay=$thisdata->delay_int+$paid_delayint;
								//echo '-'.floatval($paidtotal).'++'.$thisdata->tot_instalment;
								$totalinstalment=$thisdata->tot_instalment;
								$dif=round(floatval($paidtotal)-$totalinstalment,2);
								$intpaytot=$intpaytot+$paid_int;
							//	echo "ffff".$dif;
								if($newcap==$thisdata->cap_amount)
								$status='PAID';
								else $status='PENDING';

								// echo $status;
								$insert_data = array(
									'pay_date' => $this->input->post('paydate'),
									'tot_payment' => $this_paytot,
									'paid_int' =>$newint,
									'paid_cap' => $newcap,
									'pay_status'=>$status
									);
								$this->db->where('id',$thisdata->id);
								if ( ! $this->db->Update('re_eploanshedule', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
								$delaytot=$delaytot+$paid_delayint;
								 $insert_data = array(
									'loan_code' => $resdata->loan_code,
									'reschdue_sqn' => $resdata->reschdue_sqn,
									'ins_id' =>$thisdata->id,
									'pay_amount' => $paidamount,
									'cap_amount' =>$paid_cap,
									'int_amount' => $paid_int,
									'di_amount' => $paid_delayint,
									'rct_id'=>$entry_id,
									//'cap_entry'=>'',
									'pay_date'=>$this->input->post('paydate'),

									);
							//	$this->db->where('id',$thisdata->id);
								if ( ! $this->db->insert('re_eploanpayment', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
							//	echo  $paytot;
						}
						else {
							$arrears=$paytot;
							if($arrears>0)
								{
									customer_arreaspayment($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$resdata->lot_id,$resdata->loan_code,$arrears,$ledgerset['Cr_account'],date('Y-m-d'),$entry_id);
								}
							$paytot=0;

						}
				}
				$payamount=$this->input->post('payment');
				if($retruncharge>0)
				{
					$payamount=$payamount-$retruncharge;
					$diledger=get_account_set('Checque Return Charge');
					//echo $diledger['Cr_account'];
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$retruncharge,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}
				}
				if($delaypaytot>0)
				{
					$payamount=$payamount-$delaypaytot;
					$diledger=get_account_set('EP DI Income');
					//echo $diledger['Cr_account'];
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$delaypaytot,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}

				}
				
				$payamount=round($payamount,2);
				if($payamount>0){
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$ledgerset['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$payamount,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				}
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$ledgerset['Dr_account'],
					'dc_type' => 'D',
					'amount' =>$this->input->post('payment'),
				);

				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				if($this->input->post('payment')>=$this->input->post('balance_val'))
				{

					 $insert_data = array(
									'loan_status' => 'SETTLED',
									'end_date' => date('Y-m-d'),
									);
								$this->db->where('loan_code',$resdata->loan_code);
								if ( ! $this->db->Update('re_eploan', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}

				}

		return $entry_id;
	}
	function rental_payment_epb()
	{
		$current_date=$this->input->post('paydate');
		$delaytot=$this->input->post('delay_int_val');
			$int_val=$this->input->post('int_val');
		//int_val
		$total_out=$this->input->post('totl_out');
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
		$retruncharge=get_pending_return_charge($resdata->cus_code);
		$ledgerset=get_account_set('EPB Rental');

		$this->db->trans_start();
			$insert_data = array(
				'temp_code' =>  $resdata->loan_code,
				'res_code' =>  $resdata->res_code,
				'pri_id' =>$resdata->prj_id,
				'cus_code' =>$resdata->cus_code,
				'lot_id' =>$resdata->lot_id,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Rental Payment',
				'amount' => $this->input->post('payment'),
				'income_date' =>$this->input->post('paydate'),
				 'temp_rct_no'=>$this->input->post('temp_receipt'),
       			 'temp_income_date'=>$this->input->post('temp_receipt_date'),
			);
			if ( ! $this->db->insert('re_prjacincome', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}
			//Document Fee insert


			$paytot=$this->input->post('payment');
			$loan_amount=$resdata->loan_amount;
			if($this->input->post('delay_int_waveoffval')>0)
           		{

							
								 $insert_data = array(
									'loan_code' => $resdata->loan_code,
									'reschdue_sqn' => $resdata->reschdue_sqn,
									'di_amount' => $this->input->post('delay_int_waveoffval'),
									'rct_id'=>$entry_id,
									//'cap_entry'=>'',
									'pay_date'=>$this->input->post('paydate'),
									'create_by'=>$this->session->userdata('userid'),
									);
							//	$this->db->where('id',$thisdata->id);
								if ( ! $this->db->insert('re_epdiwaveoff', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}

					$delaytot=$delaytot-$this->input->post('delay_int_waveoffval');
					$paydelay=0;
				}
			$current_interest=$int_val;
			$balance_pay=$paytot-$delaytot-$retruncharge;
			$balance_pay=$paytot;$payreturn=0;$paydelay=0;$int_pay=0;
			if($retruncharge>0)
				{
					if($paytot>$retruncharge)
					{
					$payreturn=$retruncharge;
					$balance_pay=$paytot-$retruncharge;
					}
					else
					{
						$payreturn=$paytot;
						$balance_pay=0;
					}

				}
				if($delaytot>0){
					if($balance_pay>$delaytot)
					{
						$paydelay=$delaytot;
					$balance_pay=$balance_pay-$delaytot;
					}
					else
					{
						$paydelay=$balance_pay;
						$balance_pay=0;
					}
				}
			if($balance_pay > 0)
			{
					if($current_interest>= $balance_pay)
					{
						$int_pay=$balance_pay;
						$cap_pay=0;
					}
						else
					{
						$int_pay=$current_interest;
						$cap_pay=$balance_pay-$current_interest;
					}
					if($this->input->post('payment')>$this->input->post('balance_val'))
					{
						$cap_pay=$this->get_balanc_cap_epb($resdata->loan_code);

					}

			}
			else
			{
				$cap_pay=0;
				$int_pay=0;
			}

				 $currentpaydate=date_create($this->input->post('paydate'));

				//$paid_cap= $this->input->post('payment')-$delaytot;
				 $insert_data = array(
									'loan_code' => $resdata->loan_code,
								'reschdue_sqn' => $resdata->reschdue_sqn,
									'pay_amount' => $this->input->post('payment'),
									'cap_amount' =>$cap_pay,
									'int_amount' => $int_pay,
									'di_amount' => $paydelay,
									'rct_id'=>$entry_id,
									//'cap_entry'=>'',
									'pay_date'=>$this->input->post('paydate'),
									);
							//	$this->db->where('id',$thisdata->id);
								if ( ! $this->db->insert('re_eploanpayment', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}


				$payamount=$this->input->post('payment');
				if($payreturn>0)
				{
					$payamount=$payamount-$payreturn;
					$diledger=get_account_set('Checque Return Charge');
					//echo $diledger['Cr_account'];
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$payreturn,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}
				}
				if($paydelay>0)
				{
					$payamount=$payamount-$paydelay;
					$diledger=get_account_set('EP DI Income');
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$paydelay,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}

				}
				if($intpaytot>0)
				{
					$payamount=$payamount-$intpaytot;
					$intledger=get_account_set('EP Creation Interest');
					//echo $diledger['Cr_account'];
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$intledger['Dr_account'],
					'dc_type' => 'C',
					'amount' =>$intpaytot,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}

				}
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$ledgerset['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$payamount,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$ledgerset['Dr_account'],
					'dc_type' => 'D',
					'amount' =>$this->input->post('payment'),
				);

		if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
$balance_val=$this->input->post('balance_val')-$this->input->post('delay_int_waveoffval');
		if($this->input->post('payment')>=$balance_val)
				{

					 $insert_data = array(
									'loan_status' => 'SETTLED',
									'end_date' => date('Y-m-d'),
									);
								$this->db->where('loan_code',$resdata->loan_code);
								if ( ! $this->db->Update('re_eploan', $insert_data))
								{
									$this->db->trans_rollback();
									$this->messages->add('Error addding Entry.', 'error');

									return;
								}
								
								if($this->input->post('payment')>$balance_val)
								{
									$arrears=round($this->input->post('payment')-$balance_val,2);
									if($arrears>0)
									{
										customer_arreaspayment($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$resdata->lot_id,$resdata->loan_code,$arrears,$ledgerset['Cr_account'],date('Y-m-d'),$entry_id);
									}
								}


				}
		return $entry_id;
	}
	function add_followups()
	{
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
			 $insert_data = array(
			'loan_code' => $resdata->loan_code,
			'cus_code' =>$resdata->cus_code,
			'emp_code' => $resdata->collection_officer,
			'follow_date' =>$this->input->post('searchdate'),
			'cus_feedback' => $this->input->post('cus_feedback'),
			'sales_feedback' => $this->input->post('sales_feedback'),
			'todate_arreas'=>$this->input->post('todate_arreas'),
			'contact_media'=>$this->input->post('contact_media'),
			'promissed_date'=>$this->input->post('promissed_date'),
			'promissed_amount'=>$this->input->post('promissed_amount'),
			'create_date'=>date('Y-m-d'),
			'create_by '=>$this->session->userdata('username'),

			);
							//	$this->db->where('id',$thisdata->id);
			if ( ! $this->db->insert('re_epfollowups', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			else
			{	
				
			   	return $loan_code;
			}
			


	}

	//Ticket No:3067 Added By Madushan 2021-07-12
	function update_bank_details($insert_data,$loan_code)
	{
		$this->db->where('loan_code',$loan_code);
		$this->db->update('re_eploan',$insert_data);
	}

	function get_followups()
	{
		//get all stock
		$this->db->select('re_epfollowups.*,hr_empmastr.initial,hr_empmastr.surname');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_epfollowups.emp_code','left');
			$query = $this->db->get('re_epfollowups');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;

	}
	function get_followups_by_id($id)
	{
		//get all stock
		$this->db->select('re_epfollowups.*,hr_empmastr.initial,hr_empmastr.surname');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_epfollowups.emp_code','left');
		$this->db->where('re_epfollowups.id',$id);
			$query = $this->db->get('re_epfollowups');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;

	}
	function get_followups_by_loancode($id)
	{
		//get all stock
		$this->db->select('re_epfollowups.*,hr_empmastr.initial,hr_empmastr.surname');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_epfollowups.emp_code','left');
		$this->db->where('re_epfollowups.loan_code',$id);
			$query = $this->db->get('re_epfollowups');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;

	}
	function delete_feedback($id)
	{
		if($id)
		{
		$this->db->where('id', $id);
		 $update= $this->db->delete('re_epfollowups');
		 return  $update;
		}
		return false;



	}
	function get_reschedule($pagination_counter, $page_count,$branchid)
	{
		$this->db->select('re_epreschedule.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epreschedule.cus_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epreschedule.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if(! check_access('all_branch'))
		$this->db->where('re_epreschedule.branch_code',$branchid);

		$this->db->limit($pagination_counter, $page_count);
		$this->db->order_by('re_epreschedule.apply_date', 'DESC');
		$query = $this->db->get('re_epreschedule');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function add_reschedule()
	{
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
		$rsch_code=$this->getmaincode('rsch_code','RSL','re_epreschedule');
		$oldrescode=$resdata->reschdue_sqn;
		 $id=intval($oldrescode);
		$newid=$id+1;
		$res_sq=str_pad($newid, 3, "0", STR_PAD_LEFT);
		//$res_sq=$this->getsequense('res_sq',$loan_code,'re_epreschedule');
		$paindins=intval($this->get_paid_instalment($loan_code));

		$balins=$resdata->instalments-$paindins;
		if($this->input->post('pay_type')=="EPB")
		$new_instalment =1;
		else
		$new_instalment=$this->input->post('period');
		$lastpayment=str_replace( ',', '', $this->input->post('lastpayment') );
			 $insert_data = array(
			'rsch_code' =>$rsch_code,
			'res_sq'=> $res_sq,
			'loan_code' =>$resdata->loan_code,
			'branch_code' => $resdata->branch_code,
			'res_code' => $resdata->res_code,
			'cus_code' => $resdata->cus_code,
			'loan_stdate' => $resdata->start_date,
			'loan_stcap' => $resdata->loan_amount,
			'loan_stinttot' =>$this->input->post('loan_stinttot'),
			'loan_previntrate' => $resdata->interest,
			'loan_previnstalments' => $resdata->instalments,
			'loan_prevrental' => $resdata->montly_rental,
			'loan_paidins' => $paindins,
			'loan_balins' =>$balins,
			'loan_paidcap' => $this->input->post('loan_paidcap'),
			'loan_paidint' => $this->input->post('loan_paidint'),
			'loan_paidcrint' => $this->input->post('loan_paidcrint'),
			'prev_type'=> $resdata->loan_type,
			'new_type'=>$this->input->post('pay_type'),
			'new_cap'=>$this->input->post('new_cap'),
			'new_intrate'=>$this->input->post('interest'),
			'new_totint'=>$this->input->post('new_totint'),
			'new_rental'=>$this->input->post('instalments_val'),
			'new_instalment'=>$new_instalment,
			'di_amount'=>$this->input->post('di_amount'),
			'new_period'=>$this->input->post('period'),
			'resch_date'=>$this->input->post('settldate'),
			'apply_date'=>date('Y-m-d'),
			'status'=>'PENDING',
			'apply_by '=>$this->session->userdata('username'),
			'lastinstalment_ZEP'=>$lastpayment,
			'final_instalment'=>$this->input->post('final_amount'),
				'final_instalmentdate'=>$this->input->post('final_date'),
				'arrears_cap'=>$this->input->post('arrears_cap'),
				'arrears_int'=>$this->input->post('arrears_int'),
				'loan_subtype'=>$this->input->post('loan_subtype'),
			);
							//	$this->db->where('id',$thisdata->id);
			if ( ! $this->db->insert('re_epreschedule', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			else{
				if($this->input->post('pay_type') == 'ZEPC'){
					$n=intval($this->input->post('period'));
					for($t=1; $t <= $n; $t++){
						$instalment = $this->input->post('instalment'.$t);
						$futureDate = $this->input->post('instdate'.$t);
						$insert_data = array(
						'rsch_code' =>  $rsch_code,
						'date' =>$futureDate,
						'amount' => $instalment,
						);
						$this->db->insert('re_epreschedule_payments', $insert_data);
					}
				}
				return $loan_code;
			}
	}
	function get_reschedule_data($code)
	{
		$this->db->select('re_epreschedule.*');
			$this->db->where('re_epreschedule.rsch_code',$code);

			$query = $this->db->get('re_epreschedule');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
	}
	function edit_reschedule()
	{
		$rsch_code=$this->input->post('rsch_code');
		$reschdata=$this->eploan_model->get_reschedule_data($rsch_code);
		$resdata=$this->eploan_model->get_eploan_data($reschdata->loan_code);
		$paindins=intval($this->get_paid_instalment($reschdata->loan_code));
		//echo $reschdata->loan_code;
		$balins=$resdata->instalments-$paindins;
		if($this->input->post('pay_type')=="EPB")
		$new_instalment =1;
		else
		$new_instalment=$this->input->post('period');
			 $insert_data = array(
				'loan_stinttot' =>$this->input->post('loan_stinttot'),
			'loan_previntrate' => $resdata->interest,
			'loan_previnstalments' => $resdata->instalments,
			'loan_prevrental' => $resdata->montly_rental,
			'loan_paidins' => $paindins,
			'loan_balins' =>$balins,
			'loan_paidcap' => $this->input->post('loan_paidcap'),
			'loan_paidint' => $this->input->post('loan_paidint'),
			'loan_paidcrint' => $this->input->post('loan_paidcrint'),
			'prev_type'=> $resdata->loan_type,
			'new_type'=>$this->input->post('pay_type'),
			'new_cap'=>$this->input->post('new_cap'),
			'new_intrate'=>$this->input->post('interest'),
			'new_totint'=>$this->input->post('new_totint'),
			'new_rental'=>$this->input->post('instalments_val'),
			'new_instalment'=>$new_instalment,
			'new_period'=>$this->input->post('period'),
			'resch_date'=>$this->input->post('settldate'),
			'apply_date'=>date('Y-m-d'),
			'status'=>'PENDING',
			'apply_by '=>$this->session->userdata('username'),
			//'lastinstalment_ZEP'=>$this->input->post('lastpayment'),
			);
			$this->db->where('rsch_code',$rsch_code);
			if ( ! $this->db->update('re_epreschedule', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			else
			return $rsch_code;
	}
	function delete_reschedule($rsch_code)
	{
		if($rsch_code)
		{
		$this->db->where('rsch_code',$rsch_code);
		$this->db->delete('re_epreschedule');
		return $rsch_code;
		}
		return 0;
	}
	function calculatePeriodInt($n,$instalment,$fn,$balfinance)
	{
		$rate=excel_rate($n,$instalment,$fn);


		$int=$balfinance*$rate/12;
		return $int;

	}
	function calculatePeriodPrince($periodInt,$EMI)
	{
		$principle=$EMI-$periodInt;
		return $principle;
	}
	function get_saletype_by_type($type) { //get all stock
		$this->db->select('*');
		$this->db->where('type',$type);
		$query = $this->db->get('re_saletype');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_reshedule_details($rsch_code)
	{
		$this->db->select('*');
		$this->db->where('loan_code',$rsch_code);
		$query = $this->db->get('re_epreschedule');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;

	}
	function delete_pendingshcdule($rsch_code)
	{
		if($rsch_code)
		{
			$this->db->where('pay_status','PENDING');
			$this->db->where('loan_code',$rsch_code);
			$this->db->delete('re_eploanshedule');
			return $rsch_code;
		}
	}
	function confirm_reshedule($rsch_code)
	{

		$reschdata=$this->eploan_model->get_reschedule_data($rsch_code);
		if($reschdata->status=='PENDING')
		{
		$eploannedata=$this->eploan_model->get_eploan_data($reschdata->loan_code);

		$aarrcapital=$this->uptodate_arrears_capital($eploannedata->loan_code,date("Y-m-d"));
			reschedule_account_transfers($rsch_code);//finacial transfes helper

		//$paytype=$reschdata->new_type;
		$ptype = $reschdata->new_type; //keep the reference for ZEPCs

		if($ptype == 'ZEPC'){
			$paytype='ZEP';
		}else{
			$paytype=$ptype;
		}
		$this->delete_pendingshcdule($reschdata->loan_code);
		$typedata=$this->get_saletype_by_type($paytype);
		if($paytype!='EPB')
			{
				$n=intval($reschdata->new_instalment);
				$fn=$reschdata->new_cap-intval($reschdata->final_instalment);
				$fn=round($fn,2);
				$totint=0;
				if(floatval($reschdata->new_intrate)>0)
				{
					$i=floatval($reschdata->new_intrate);
				$years=$n/12;
				$totint=$fn*$years*$i/100;
				$instalment=($fn+$totint)/$n;
				}
				else $instalment=$fn/$n;
				$paidca=0;
				$balfinance=$fn;
				$futureDate=$reschdata->resch_date;
				$last_payment = $reschdata->lastinstalment_ZEP;//$this->input->post('lastpayment');
				if($paytype=='ZEP' && $ptype!='ZEPC'){
					for($t=1; $t<=$n; $t++)
					{
						$thisint=0;//$this->calculatePeriodInt($totint,$t,$n);
						$thiscap=$this->calculatePeriodPrince($thisint,$instalment);
						$paidca=$paidca+$thiscap;
					//	$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						//$futureDate=date('Y-m-d',strtotime('+'.$t.' months',strtotime($agreement_date)));
					

						/*if($t==$n){
						  echo $last_payment.'ssss'.$instalment;

						  $insert_data = array(
						  'loan_code' =>  $reschdata->loan_code,
						  'instalment ' =>$t+$reschdata->loan_paidins,
						   'reschdue_sqn' =>$reschdata->res_sq,
						  'cap_amount' => $last_payment,
						  'int_amount' =>$thisint,
						  'tot_instalment' => $last_payment ,
						  'deu_date' =>$futureDate,
						  );
						}else{*/
						 // $instalment=$this->input->post('instalments');
						 $instalment =$reschdata->new_rental;
						  $insert_data = array(
						  'loan_code' =>  $reschdata->loan_code,
						  'instalment ' =>$t+$reschdata->loan_paidins,
						  'reschdue_sqn' =>$reschdata->res_sq,
						  'cap_amount' => $instalment,
						  'int_amount' =>$thisint,
						  'tot_instalment' => $instalment,
						  'deu_date' =>$futureDate,
						  );
						//}
							
						$this->db->insert('re_eploanshedule', $insert_data);
						$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
					}

				}else if($ptype=='ZEPC'){
					//get schedule from re_epreschedule_payments
					$this->db->select('*');
					$this->db->where('rsch_code',$rsch_code);
					$this->db->order_by('date','asc');
					$query = $this->db->get('re_epreschedule_payments');
					if($query->num_rows() > 0){
						$t=1;
						$thisint = '0.00';
						foreach($query->result() as $installment){
							$insert_data = array(
								'loan_code' =>  $reschdata->loan_code,
								'instalment ' =>$t+$reschdata->loan_paidins,
								'reschdue_sqn' =>$reschdata->res_sq,
								'cap_amount' => $installment->amount,
								'int_amount' =>$thisint,
								'tot_instalment' => $installment->amount,
								'deu_date' =>$installment->date,
							);
							$this->db->insert('re_eploanshedule', $insert_data);

							//remove schedule data
							$this->db->where('id',$installment->id);
							$this->db->delete('re_epreschedule_payments');
							$t++;
						}
					}
				}else{
				for($t=1; $t<=$n; $t++)
				{
					$thisint=$this->calculatePeriodInt($n,$instalment,$fn,$balfinance);
					//echo $thisint;
					$thiscap=$this->calculatePeriodPrince($thisint,$instalment);
					$balfinance=$balfinance-$thiscap;
					$paidca=$paidca+$thiscap;
					
					$insert_data = array(
					'loan_code' =>  $reschdata->loan_code,
					'instalment ' =>$t+$reschdata->loan_paidins,
					'reschdue_sqn' =>$reschdata->res_sq,
					'cap_amount' => $thiscap,
					'int_amount' =>$thisint,
					'tot_instalment' => $instalment,
					'deu_date' =>$futureDate,
					);
					$this->db->insert('re_eploanshedule', $insert_data);
					$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
				}

				}
				 if($ptype=='NEP' ||$ptype=='ZEP' ){

						if($reschdata->final_instalment>0)
						{
							//$t++;
							if($reschdata->final_instalmentdate)
							$futureDate=$reschdata->final_instalmentdate;
							else
							$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
							$insert_data = array(
								'loan_code' =>  $reschdata->loan_code,
								'instalment ' =>$t+$reschdata->loan_paidins,
								'cap_amount' => $reschdata->final_instalment,
								'reschdue_sqn' =>$reschdata->res_sq,
								'int_amount' =>0,
								'tot_instalment' => $reschdata->final_instalment,
								'deu_date' =>$futureDate,
								);
								$this->db->insert('re_eploanshedule', $insert_data);
						}
					}

			}
			if($reschdata->loan_subtype)
			$codetype=$reschdata->loan_subtype;
			else
			$codetype=$paytype;
			$unique_code=$this->getmaincode_loan($eploannedata->res_code,'',$codetype);
			$insert_data = array(
			'unique_code' =>  $unique_code,
				'loan_amount' =>$reschdata->new_cap,
				'period' =>$reschdata->new_period ,
				'interest' =>$reschdata->new_intrate,
				'instalments' =>$reschdata->new_instalment+$reschdata->loan_paidins,
				'grase_period' =>$typedata->grace_period,
				'delay_interest' =>$typedata->delay_int,
				'loan_type'=>$paytype,
				'montly_rental'=>$instalment,
				'end_date' =>$futureDate,
				'cap_out' =>$reschdata->new_cap,
				'reschdue_sqn' =>$reschdata->res_sq,
				'final_instalment'=>$reschdata->final_instalment,
				'final_instalmentdate'=>$reschdata->final_instalmentdate,
				'loan_subtype'=>$reschdata->loan_subtype,

			);
			$this->db->where('loan_code',$reschdata->loan_code);
			if ( ! $this->db->update('re_eploan', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}






			$insert_data = array(
				'status' =>'CONFIRMED',
				'confirm_date'=>date('Y-m-d'),
				'confirm_by '=>$this->session->userdata('username'),
			);
			$this->db->where('rsch_code',$rsch_code);
			if ( ! $this->db->update('re_epreschedule', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
			capital_and_interest_transfer_on_reschudyle(date('Y-m-d'),$eploannedata->res_code);
		}

	}
	function get_rebate($pagination_counter, $page_count,$branchid)
	{
		$this->db->select('re_eprebate.*,re_projectms.project_name,cm_customerms.cus_code,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjacincome.pay_status');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if(! check_access('all_branch'))
		$this->db->where('re_eprebate.branch_code',$branchid);
		$this->db->order_by('re_eprebate.apply_date', 'DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_rebate_bycode($branchid)
	{
		$this->db->select('re_eprebate.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjacincome.pay_status');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		$this->db->where('re_eprebate.rebate_code',$branchid);

			$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
	}
	function get_rebate_by_loancode($branchid)
	{
		$this->db->select('re_eprebate.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjacincome.rct_no,re_prjacincome.pay_status,re_prjacincome.entry_date');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		$this->db->where('re_eprebate.loan_code',$branchid);

			$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
	}
	function add_rebate()
	{
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
		$rebate_code=$this->getmaincode('rebate_code','RBT','re_eprebate');
		$intrate=floatval($this->input->post('int_paidrate'));
		$int_release=floatval($this->input->post('balance_int'))+floatval($this->input->post('arrears_int'))-floatval($this->input->post('int_paidamount'));
		if($intrate>90)
		$status='PENDING';
		else
		$status='CONFIRMED';
		$this->db->trans_start();
		$insert_data = array(
			'rebate_code' =>$rebate_code,
			'loan_code' =>$resdata->loan_code,
			'branch_code' => $resdata->branch_code,
			'res_code' => $resdata->res_code,
			'loan_amount' => $resdata->loan_amount,
			'balance_capital' =>$this->input->post('balance_capital'),
			'balance_int' => $this->input->post('balance_int'),
			'int_paidrate' => $this->input->post('int_paidrate'),
			'int_paidamount' => $this->input->post('int_paidamount'),
			'int_release' => $int_release,
			'delay_int' =>$this->input->post('delay_int'),
			'credit_cap' =>$this->input->post('credit_cap'),
			'credit_int' =>$this->input->post('credit_int'),
			'credit_tot' =>$this->input->post('credit_tot'),
			'apply_date'=>$this->input->post('settldate'),
			'new_discount'=>$this->input->post('new_discount'),
			'request_date'=>$this->input->post('request_date'),
			'rct_id'=>0,
			'status'=>$status,
			'apply_by '=>$this->session->userdata('username'),
			);
			if ( ! $this->db->insert('re_eprebate', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			$totpayment=floatval($this->input->post('balance_capital'))+floatval($this->input->post('int_paidamount'))+floatval($this->input->post('delay_int'))-floatval($this->input->post('credit_tot'))-floatval($this->input->post('new_discount'));
			if($status=='CONFIRMED')
			{
					 if($resdata->loan_type=='ZEP'){
						$ledgerset=$this->accountinterface_model->get_account_set('ZEP Rental');

					}
					if($resdata->loan_type=='EPB'){
						$ledgerset=$this->accountinterface_model->get_account_set('EPB Rental');

					}
					if($resdata->loan_type=='NEP'){
						$ledgerset=$this->accountinterface_model->get_account_set('EP Rental');

					}
					$insert_data = array(
					'temp_code' =>  $resdata->loan_code,
					'res_code' =>  $resdata->res_code,
					'pri_id' =>$resdata->prj_id,
					'lot_id' =>$resdata->lot_id,
					'cus_code' =>$resdata->cus_code,
					'branch_code' => $resdata->branch_code,
					'income_type' =>'EP Settlement',
					'amount' => $totpayment,
					'income_date' =>$this->input->post('settldate'),
					);
					if ( ! $this->db->insert('re_prjacincome', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

						return;
					} else {
						$entry_id = $this->db->insert_id();
					}
					$delaytot=$this->input->post('delay_int');
					$eppayment=round($totpayment-$delaytot,2);
					if($delaytot>0)
					{
					$eppayment=round($totpayment-$delaytot,2);
					$diledger=get_account_set('EP DI Income');
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$delaytot,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}

					}
					//Document Fee insert
						$insert_data = array(
						'income_id' => $entry_id,
						'ledger_id' =>$ledgerset['Cr_account'],
						'dc_type' => 'C',
						'amount' =>$eppayment,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
					{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

					return;
					}
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$ledgerset['Dr_account'],
					'dc_type' => 'D',
					'amount' =>$totpayment,
					);
						if ( ! $this->db->insert('re_incomentires', $insert_data))
					{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

					return;
					}
					$insert_data = array(

						'rct_id'=>$entry_id,
						'confirm_date'=>$this->input->post('settldate'),
						'confirm_by '=>$this->session->userdata('username'),
					);
					 $this->db->where('rebate_code', $rebate_code);
					if ( ! $this->db->update('re_eprebate', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						return false;
					}


			}
			$insert_data = array(

						'loan_status'=>'SETTLED',

					);
					 $this->db->where('loan_code', $loan_code);
					if ( ! $this->db->update('re_eploan', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						return false;
					}
			$insert_data = array(

						'res_status'=>'SETTLED',

					);
					 $this->db->where('res_code', $resdata->res_code);
					if ( ! $this->db->update('re_resevation', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						return false;

					}

			$this->db->trans_complete();
			return $rebate_code;
	}
	function delete_rebate($code)
	{
		if($code)
		{
		$rebare_data=$this->get_rebate_bycode($code);
		if($rebare_data->rct_id)
		{
			$this->db->where('id',$rebare_data->rct_id);
			$this->db->delete('re_prjacincome');
			$this->db->where('income_id',$rebare_data->rct_id);
			$this->db->delete('re_incomentires');
		}
		$this->db->where('rebate_code',$code);
		$this->db->delete('re_eprebate');
		$insert_data = array(

						'loan_status'=>'CONFIRMED',

					);
					 $this->db->where('loan_code', $rebare_data->loan_code);
					if ( ! $this->db->update('re_eploan', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						return false;
					}
		$insert_data = array(

						'res_status'=>'COMPLETE',

					);
					 $this->db->where('res_code', $rebare_data->res_code);
					if ( ! $this->db->update('re_resevation', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						return false;
					}
		}
	}
	function confirm_rebate($code)
	{
			$rebare_data=$this->get_rebate_bycode($code);
			if($rebare_data->status=='PENDING')
			{
			$resdata=$this->eploan_model->get_eploan_data($rebare_data->loan_code);
			$totpayment=$rebare_data->balance_capital+$rebare_data->int_paidamount+$rebare_data->delay_int-$rebare_data->credit_tot-$rebare_data->new_discount;
			//	$totpayment=floatval($this->input->post('balance_capital'))+floatval($this->input->post('int_paidamount'))+floatval($this->input->post('delay_int'))-floatval($this->input->post('credit_tot'));

						//	$ledgerset=get_account_set('EP Rental');
				 if($resdata->loan_type=='ZEP'){
						$ledgerset=$this->accountinterface_model->get_account_set('ZEP Rental');

					}
					if($resdata->loan_type=='EPB'){
						$ledgerset=$this->accountinterface_model->get_account_set('EPB Rental');

					}
					if($resdata->loan_type=='NEP'){
						$ledgerset=$this->accountinterface_model->get_account_set('EP Rental');

					}
					$insert_data = array(
					'temp_code' =>  $resdata->loan_code,
					'res_code' =>  $resdata->res_code,
					'pri_id' =>$resdata->prj_id,
					'cus_code' =>$resdata->cus_code,
					'lot_id' =>$resdata->lot_id,
					'branch_code' => $resdata->branch_code,
					'income_type' =>'EP Settlement',
					'amount' => $totpayment,
					'income_date' =>date('Y-m-d'),
					);
					if ( ! $this->db->insert('re_prjacincome', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

						return;
					} else {
						$entry_id = $this->db->insert_id();
					}
					$delaytot=$rebare_data->delay_int;
					$eppayment=round($totpayment-$delaytot,2);
					if($delaytot>0)
					{
						$eppayment=round($totpayment-$delaytot,2);
						$diledger=get_account_set('EP DI Income');
						$insert_data = array(
						'income_id' => $entry_id,
						'ledger_id' =>$diledger['Cr_account'],
						'dc_type' => 'C',
						'amount' =>$delaytot,
						);
						if ( ! $this->db->insert('re_incomentires', $insert_data))
							{
							$this->db->trans_rollback();
							$this->messages->add('Error addding Entry.', 'error');

						return;
						}

					}
					//Document Fee insert
						$insert_data = array(
						'income_id' => $entry_id,
						'ledger_id' =>$ledgerset['Cr_account'],
						'dc_type' => 'C',
						'amount' =>$eppayment,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
					{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

					return;
					}
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$ledgerset['Dr_account'],
					'dc_type' => 'D',
					'amount' =>$totpayment,
					);
						if ( ! $this->db->insert('re_incomentires', $insert_data))
					{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

					return;
					}
					$insert_data = array(

						'rct_id'=>$entry_id,
						'confirm_date'=>date('Y-m-d'),
						'confirm_by '=>$this->session->userdata('username'),
						'status'=>'CONFIRMED',
					);
					 $this->db->where('rebate_code', $code);
					if ( ! $this->db->update('re_eprebate', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
						return false;
					}
			}

	}
	function get_resale($pagination_counter, $page_count,$branchid)
	{
		$this->db->select('re_epresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
	//	$this->db->join('re_prjacincome','re_prjacincome.id=re_epresale.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if(! check_access('all_branch'))
		$this->db->where('re_epresale.branch_code',$branchid);
		$this->db->order_by('re_epresale.apply_date', 'DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function add_resale($documents)
	{
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
		$resale_code=$this->getmaincode('resale_code','RSL','re_epresale');
			$this->db->trans_start();
		$insert_data = array(
			'resale_code' =>$resale_code,
			'loan_code' =>$resdata->loan_code,
			'branch_code' => $resdata->branch_code,
			'res_code' => $resdata->res_code,
			'cus_code' => $resdata->cus_code,
			'loan_amount' => $resdata->loan_amount,
			'paid_capital' =>$this->input->post('paid_capital'),
			'down_payment' => $this->input->post('down_payment'),
			'balance_int' => $this->input->post('balance_int'),
			'paid_int' => $this->input->post('paid_int'),
			'delay_int' => $this->input->post('delay_int'),
			'repay_capital' =>$this->input->post('repay_capital'),
			'repay_int' =>$this->input->post('repay_int'),
			'apply_date'=>$this->input->post('settldate'),
			'credit_int'=>$this->input->post('credit_int'),
			'arrears_int'=>$this->input->post('arrears_int'),
			'remark'=>$this->input->post('remark'),
			'documents'=>$documents,
			'status'=>'PENDING',
			'apply_by '=>$this->session->userdata('username'),
			);
			if ( ! $this->db->insert('re_epresale', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}


			$this->db->trans_complete();
			return $resale_code;
	}
	function delete_resale($code)
	{
		if($code)
		{
			$this->db->where('resale_code',$code);
			$this->db->delete('re_epresale');
		}

	}
	function get_resale_bycode($branchid)
	{
		$this->db->select('re_epresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.costof_sale,re_prjaclotdata.lot_id,re_resevation.discounted_price ');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		$this->db->where('re_epresale.resale_code',$branchid);

			$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
	}
	function edit_resale()
	{
		$loan_code=$this->input->post('loan_code');
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
		$resale_code=$this->input->post('resale_code');
			$this->db->trans_start();
		$insert_data = array(
			'paid_capital' =>$this->input->post('paid_capital'),
			'down_payment' => $this->input->post('down_payment'),
			'balance_int' => $this->input->post('balance_int'),
			'paid_int' => $this->input->post('paid_int'),
			'delay_int' => $this->input->post('delay_int'),
			'repay_capital' =>$this->input->post('repay_capital'),
			'repay_int' =>$this->input->post('repay_int'),
			'apply_date'=>$this->input->post('settldate'),
			'remark'=>$this->input->post('remark'),
			'status'=>'PENDING',
			'apply_by '=>$this->session->userdata('username'),
			);
			$this->db->where('resale_code',$resale_code);
			if ( ! $this->db->update('re_epresale', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}


			$this->db->trans_complete();
			return $resale_code;
	}
	function confirm_resale($rsch_code)
	{
		$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
		$reschdata=$this->eploan_model->get_resale_bycode($rsch_code);
		if($reschdata->status=='PENDING')
		{
	
			$loandata=$this->eploan_model->get_eploan_data($reschdata->loan_code);
		$amount=$reschdata->repay_capital +$reschdata->repay_int;
		$id=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
		$refundledhger=$crledger['Cr_account'];

			loan_resale_transfers($rsch_code);//financialtransfers Helper function


		$insert_data = array(

				'resale_code' =>$reschdata->resale_code ,
				//'voucher_code' =>$id,
				'capital_payment' =>$reschdata->repay_capital,
				'int_payment' =>$reschdata->repay_int,
				'total_payment' =>$amount,
				'send_date'=>date('Y-m-d'),

			);
			if ( ! $this->db->insert('re_epresalepayment', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}

			



			$insert_data = array(
				'status' =>'CONFIRMED',
				'confirm_date'=>date('Y-m-d'),
				'confirm_by '=>$this->session->userdata('username'),
			);
			$this->db->where('resale_code',$rsch_code);
			if ( ! $this->db->update('re_epresale', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
			$insert_data = array(
				'loan_status' =>'SETTLED',
        'end_date'=>date('Y-m-d'),
			);
			$this->db->where('loan_code',$reschdata->loan_code);
			if ( ! $this->db->update('re_eploan', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
			$insert_data = array(
				'res_status' =>'REPROCESS',
				'resale_date'=>date('Y-m-d')
			);
			$this->db->where('res_code',$reschdata->res_code);
			if ( ! $this->db->update('re_resevation', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
			$insert_data = array(
				'status' =>'PENDING',
			);
			$this->db->where('lot_id',$reschdata->lot_id);
			if ( ! $this->db->update('re_prjaclotdata', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
		}
	}

	function get_all_reservation_details_bycode($rescode) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,re_projectms.project_code,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.res_code',$rescode);
		$query = $this->db->get('re_resevation');
		return $query->row();
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

	 function getmaincode_branchshortcode($idfield,$prifix,$table,$branchcode)
    {
       // $date=$this->config->item('account_fy_start');
	  // echo $this->session->userdata('shortcode');

        $query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table." where branch_code='".$branchcode."'");

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
                $prjid=substr($prjid,3,5);
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

	function getsequense($res_seq,$where,$table)
	{
		 $query = $this->db->query("SELECT MAX(".$res_seq.") as id  FROM ".$table." where  	loan_code='".$where."'");

        $newid="";

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=str_pad(1, 3, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 3, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;
	}
		function getsequense_pay($res_seq,$where,$table)
	{
		 $query = $this->db->query("SELECT MAX(".$res_seq.") as id  FROM ".$table." where  	res_code='".$where."'");

        $newid="";

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=str_pad(1, 3, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=str_pad(1, 3, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;
	}
	function rechange_code() { //get all stock
		$this->db->select('*');
	//	$this->db->where('loan_code',$rescode);
		$this->db->order_by('deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		//$data=$query->result();
		//foreach()
		}
		else
		return false;
    }
	function get_eploan_data_lot_id($rescode) { //get all stock
		$this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.pay_type,re_resevation.discounted_price,re_resevation.profit_status,re_resevation.lot_id,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.lot_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.lot_id',$rescode);

		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_eploan_data_project($rescode) { //get all stock
		$this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.pay_type,re_resevation.discounted_price,re_resevation.profit_status,re_resevation.lot_id,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.lot_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$rescode);

		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_paid_list_inquary($rescode) { //get all stock

	   $resdata=$this->eploan_model->get_eploan_data($rescode);
	   $this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date,SUM(re_eploanpayment.pay_amount) as pay_tot,re_eploanpayment.pay_date,re_prjacincome.enty_type');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
	//	$this->db->join('re_paymententries','re_paymententries.pay_id=re_prjacincome.id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$this->db->where('re_eploanpayment.reschdue_sqn',$resdata->reschdue_sqn);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
    }
	function get_paid_list_inquary_oldloan($rescode) { //get all stock
	$resdata=$this->eploan_model->get_eploan_data($rescode);
		$this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount  ) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
	//	$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);

		$this->db->where('re_eploanpayment.reschdue_sqn !=',$resdata->reschdue_sqn);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
    }
	function add_followups_popup($loancode,$date,$cus_feedback,$sales_feedback,$todate_arreas,$contact_media,$promissed_date,$promissed_amount)
	{
		$loan_code=$loancode;
		$resdata=$this->eploan_model->get_eploan_data($loan_code);
			 $insert_data = array(
			'loan_code' => $resdata->loan_code,
			'cus_code' =>$resdata->cus_code,
			'emp_code' => $resdata->officer_code2,
			'follow_date' =>$date,
			'cus_feedback' => $cus_feedback,
			'sales_feedback' => $sales_feedback,
			'todate_arreas'=>$todate_arreas,
			'contact_media'=>$contact_media,
			'promissed_date'=>$promissed_date,
			'promissed_amount'=>$promissed_amount,
			'create_date'=>date('Y-m-d'),
			'create_by '=>$this->session->userdata('username'),
			);
							//	$this->db->where('id',$thisdata->id);
							$this->db->insert('re_epfollowups', $insert_data);

				$entry_id = $this->db->insert_id();
							//echo $this->db->last_query();
			/*if ( ! $this->db->insert('re_epfollowups', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			else
			return $loan_code;*/


	}
	function get_next_instalmant($loan_code,$date)
	{
		$this->db->select('*');
		$this->db->where('loan_code',$loan_code);
			$this->db->where('deu_date >',$date);
		$this->db->order_by('deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $query->row();
		}
		else
		return false;
	}
	function uptodate_arrears_capital($loancode,$deu_date)
	{
		$loandata=$this->get_eploan_data($loancode);
		$this->db->select('SUM(re_eploanshedule.cap_amount) as cap,SUM(re_eploanshedule.paid_int) as inttot,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$loandata->reschdue_sqn);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
		$this->db->where('re_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){


		$data= $query->row();
		$paidtot=0;
		$paiddata=$this->get_paid_totals($loancode);
		if($paiddata)
		$paidtot=$paiddata->totpaidcap;
		$arr= $data->cap-$paidtot;


		return $arr;
		}
		else
		return 0;

	}

	function get_repayment_shedeule_ledger_card($rescode,$reschdue_sqn) { //get all stock
		$this->db->select('*');
		$this->db->where('loan_code',$rescode);
		$this->db->where('reschdue_sqn',$reschdue_sqn);
		$this->db->order_by('reschdue_sqn,deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	 function get_next_due_date($rescode,$instalment) { //get all stock
		$this->db->select('deu_date');
		$this->db->where('loan_code',$rescode);
		$this->db->where('instalment',$instalment);
		$this->db->order_by('reschdue_sqn,deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->deu_date;
		}
		else
		return '';
    }

	 function get_paid_list_Period($rescode,$fromdata,$todate) { //get all stock
		$resdata=$this->eploan_model->get_eploan_data($rescode);
		$this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount  ) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
	  //	$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$this->db->where('re_eploanpayment.pay_date >=',$fromdata);
		$this->db->where('re_eploanpayment.pay_date <',$todate);
		$this->db->where('re_eploanpayment.reschdue_sqn',$resdata->reschdue_sqn);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return false;
	}
	function get_last_payment_date_current_instalment($instalment_id){
		$this->db->select_max('pay_date','max_date');
		$this->db->where('re_eploanpayment.ins_id',$instalment_id);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			return $query->row()->max_date;
		}
		else
			return false;
	}
	function getmaincode_loan($res_code,$branch_code,$loan_type)
	{$newid=0;
		$query=NULL;
			$res_data=$this->get_all_reservation_details_bycode($res_code);
			//echo $this->db->last_query();
			$lotnumber1=explode('-',$res_data->lot_number);
			$counter=count($lotnumber1)-1;
			$lot=$lotnumber1[$counter];

			$newid="";
			$res_sequance=str_pad(intval($res_data->res_seq), 2, "0", STR_PAD_LEFT);
			$lotnumber=str_pad($lot, 4, "0", STR_PAD_LEFT);
			$newcode='HL/'.$loan_type.'/'.$res_data->project_code.'/'.$lotnumber.'/'.$res_sequance;

		return $newcode;

	}


function get_deu_data($loan_code,$date,$loan_type,$reshedule_seq)
	{
	//echo $date;
		$array=array('due_cap'=>0,'due_int'=>0,'duedate'=>$date);
		if($loan_type!='EPB')
		{
			$this->db->select('SUM(cap_amount)as totcap,SUM(int_amount) as totint,max(deu_date) as duedate');
			$this->db->where('loan_code',$loan_code);
			$this->db->where('reschdue_sqn',$reshedule_seq);
			$this->db->where('deu_date <=',$date);
			$query = $this->db->get('re_eploanshedule');
			if ($query->num_rows() > 0){
			$data= $query->row();
			$array['due_cap']=$data->totcap;
			$array['due_int']=$data->totint;
			$array['duedate']=$data->duedate;
			}

		}
		else
		{
			$this->db->select('*');
			$this->db->where('loan_code',$loan_code);
			$query = $this->db->get('re_eploan');
			if ($query->num_rows() > 0){
				$data= $query->row();
				$futureDate=date('Y-m-d',strtotime('+'.$data->period,strtotime($data->start_date)));
				if($futureDate<$date)
				$array['due_cap']=$data->loan_amount;


			}

		}
		return $array;


	}
function loan_inquary_paid_totals($loancode,$date,$reshedule_seq)
	{
		$array=array('paid_cap'=>0,'paid_int'=>0,'paid_di'=>0);
		$this->db->select('SUM(re_eploanpayment.cap_amount) as paid_cap,SUM(re_eploanpayment.int_amount) as paid_int,SUM(re_eploanpayment.di_amount) as paid_di');
			if($date!='')
			$this->db->where('re_eploanpayment.pay_date <=',$date);
			$this->db->where('re_eploanpayment.reschdue_sqn',$reshedule_seq);

			$this->db->where('re_eploanpayment.loan_code',$loancode);
			$query = $this->db->get('re_eploanpayment');


		if ($query->num_rows() > 0){
		$data= $query->row();
		$array['paid_cap']=$data->paid_cap;
			$array['paid_int']=$data->paid_int;
			$array['paid_di']=$data->paid_di;
		}
		return $array;
	}

	function get_actual_loantype($loan_code)
	{
		$this->db->select('*');
		$this->db->where('re_eploan.loan_code',$loan_code);
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
			$data=$query->row();
		//	print_r($data);
			if($data->loan_subtype)
			return  $data->loan_subtype;
			else
			return  $data->loan_type;
		}
		else
			return false;
	}
//update by nadee 2021-03-30 ticket number 2582
	function get_next_interest_data($loan_code,$date,$loan_type,$reshedule_seq)
  	{
  	//echo $date;
  		$array=array('due_cap'=>0,'due_int'=>0,'duedate'=>$date);
  		if($loan_type!='EPB')
  		{
  			$this->db->select('int_amount');
  			$this->db->where('loan_code',$loan_code);
  			$this->db->where('reschdue_sqn',$reshedule_seq);
  			$this->db->where('deu_date >',$date);
 			$this->db->order_by('deu_date');
 			$this->db->limit(1);
  			$query = $this->db->get('re_eploanshedule');
  			if ($query->num_rows() > 0){
  			return $query->row()->int_amount;
  			}

  		}else{
 			return 0;
 		}

  }

  /*Ticket No:2817 Added by Madushan 2021.05.12*/
	function get_paidlist_before_first_instalment($rescode,$reshedule_seq,$reshedule_first_due_date){
		//$resdata=$this->eploan_model->get_eploan_data($rescode);
		$this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount  ) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
	  //	$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$this->db->where('re_eploanpayment.pay_date <',$reshedule_first_due_date);
		//$this->db->where('re_eploanpayment.pay_date <',$todate);
		$this->db->where('re_eploanpayment.reschdue_sqn',$reshedule_seq);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return false;
	}

	/*Ticket No:3082 Added By Madushan 2021.07.13*/
	function get_paidlist_after_last_instalment($rescode,$reshedule_seq,$reshedule_last_due_date){
		//$resdata=$this->eploan_model->get_eploan_data($rescode);
		$this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount  ) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
	  //	$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$this->db->where('re_eploanpayment.pay_date >',$reshedule_last_due_date);
		//$this->db->where('re_eploanpayment.pay_date <',$todate);
		$this->db->where('re_eploanpayment.reschdue_sqn',$reshedule_seq);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return false;
	}

	function get_reshedule_first_due_date($loan_code,$reshedule_seq){
		
		$this->db->select_min('deu_date');
		$this->db->where('loan_code',$loan_code);
		$this->db->where('reschdue_sqn',$reshedule_seq);
		//$this->db->where('instalment');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
			return $query->row()->deu_date;
		}
		else
			return false;
	}

	/*Ticket No:3082 Added By Madushan 2021.07.13*/
	function get_reshedule_last_due_date($loan_code,$reshedule_seq){
		
		$this->db->select_max('deu_date');
		$this->db->where('loan_code',$loan_code);
		$this->db->where('reschdue_sqn',$reshedule_seq);
		//$this->db->where('instalment');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
			return $query->row()->deu_date;
		}
		else
			return false;
	}
	
	function get_paid_list_inquary_all($rescode) { //get all stock

	   $resdata=$this->eploan_model->get_eploan_data($rescode);
	   $this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date,SUM(re_eploanpayment.pay_amount) as pay_tot,re_eploanpayment.pay_date,re_prjacincome.enty_type');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
	//	$this->db->join('re_paymententries','re_paymententries.pay_id=re_prjacincome.id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		//$this->db->where('re_eploanpayment.reschdue_sqn',$resdata->reschdue_sqn);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
    }
	function update_instalment_number()
	{
		$this->db->select('*');
		
		$query = $this->db->get('re_eploan');
		//print_r($query->result());
		if ($query->num_rows() > 0){
			
			$data=$query->result();
			foreach($data as $raw)
			{
				echo $raw->loan_code;
				echo '<br>';
				$this->db->select('*');
				$this->db->where('loan_code',$raw->loan_code);
				$this->db->order_by('reschdue_sqn,deu_date');
					$query1= $this->db->get('re_eploanshedule');
					if ($query1->num_rows() > 0){
						$i=1;
						$data2=$query1->result();
						foreach($data2 as $raw2)
						{
						 		$insert_data = array(
								'instalment' =>$i,
									);
								$this->db->where('id',$raw2->id);
							$this->db->update('re_eploanshedule', $insert_data);
							echo $raw2->deu_date.$raw2->instalment. '--'.$i.'<br>';
							$i++;
						}
					}
					//else
					//return false;			
			}
		}
	}

	//End of Ticket No:2817

 /*Ticket No:2889 Added By Madushan 2021.06.18*/
	function get_next_advance_due_date($res_code,$instalment)
	{
		$this->db->select('due_date');
		$this->db->where('res_code',$res_code);
		$this->db->where('installment_number',$instalment);
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
			return $query->row()->due_date;
		else
			return false;

	}

	function get_advance_paid_list_Period($rescode,$fromdata,$todate) { //get all stock
		$this->db->select('re_prjacincome.*');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
	  //	$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		$this->db->where('re_prjacincome.temp_code',$rescode);
		$this->db->where('re_prjacincome.income_date >=',$fromdata);
		$this->db->where('re_prjacincome.income_date <',$todate);
		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return false;
	}

	function get_advance_paidlist_before_first_instalment($rescode,$firstdate)
	{
		$this->db->select('re_prjacincome.*');
		//$this->db->select('re_eploanpayment.*,re_eploanshedule.instalment,re_eploanshedule.tot_instalment,re_eploanshedule.deu_date, ');
	  //	$this->db->join('re_eploanshedule','re_eploanshedule.id=re_eploanpayment.ins_id');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		$this->db->where('re_prjacincome.temp_code',$rescode);
		$this->db->where('re_prjacincome.income_date <',$firstdate);
		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return false;
	}

	function get_loan_code($res_code)
	{
		$this->db->select('loan_code');
		$this->db->where('res_code',$res_code);
		$query = $this->db->get('re_eploan');
		if($query->num_rows>0)
			return $query->row()->loan_code;
		else
			return false;

	}

	function get_advance_arrias_instalments($lot_id,$date)
	{
		$this->db->select('SUM(re_salesadvanceshedule.amount) as tot_amount');
		$this->db->join('re_salesadvanceshedule','re_salesadvanceshedule.res_code = re_resevation.res_code');
		$this->db->where('re_salesadvanceshedule.status <>','PAID');
		$this->db->where('re_resevation.lot_id',$lot_id);
		$this->db->where('re_salesadvanceshedule.due_date <=',$date);
		$query = $this->db->get('re_resevation');
		if($query->num_rows>0)
			return $query->row()->tot_amount;
		else
			return 0;
	}

	function get_advance_paid_amount($lot_id,$date)
	{
		$this->db->select('SUM(re_salesadvanceshedule.paid_amount) as tot_paidamount');
		$this->db->join('re_salesadvanceshedule','re_salesadvanceshedule.res_code = re_resevation.res_code');
		$this->db->where('re_salesadvanceshedule.status <>','PAID');
		$this->db->where('re_resevation.lot_id',$lot_id);
		$this->db->where('re_salesadvanceshedule.paid_date <=',$date);
		$query = $this->db->get('re_resevation');
		if($query->num_rows>0)
			return $query->row()->tot_paidamount;
		else
			return 0;
	}

	function add_followups_advance()
	{
		$data=$this->get_res_data($this->input->post('advance_lot_id'));
			 $insert_data = array(
			'loan_code' => $data->res_code,
			'cus_code' =>$data->cus_code,
			'emp_code' => '',
			'follow_date' =>$this->input->post('searchdateadvance'),
			'cus_feedback' => $this->input->post('cus_feedback'),
			'sales_feedback' => $this->input->post('sales_feedback'),
			'todate_arreas'=>$this->input->post('todate_arreas'),
			'contact_media'=>$this->input->post('contact_media'),
			'promissed_date'=>$this->input->post('promissed_date'),
			'promissed_amount'=>$this->input->post('promissed_amount'),
			'create_date'=>date('Y-m-d'),
			'create_by '=>$this->session->userdata('username'),
			'type'=>'Advance',

			);
							//	$this->db->where('id',$thisdata->id);
			if ( ! $this->db->insert('re_epfollowups', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}
			else
			return $data->res_code;
	}

	function get_res_data($lot_id)
	{
		$this->db->select('*');
		$this->db->where('lot_id',$lot_id);
		$query = $this->db->get('re_resevation');
		if($query->num_rows > 0)
			return $query->row();
		else
			return 0;
	}

	function get_followups_by_lot_id($lot_id)
	{
		$this->db->select('re_epfollowups.*');
		$this->db->join('re_epfollowups','re_epfollowups.loan_code = re_resevation.res_code');
		$this->db->where('re_resevation.lot_id',$lot_id);
		$this->db->where('re_epfollowups.type','Advance');
		$query = $this->db->get('re_resevation');
		if($query->num_rows > 0)
			return $query->result();
		else
			return false;
	}

	/*End Of Ticket No:2889*/

	/*Ticket No:2952 Added By Madushan 2021.06.23*/
	function get_rebate_print($rebate_code)
	{
		$this->db->select('re_eprebate.*,re_projectms.project_name,cm_customerms.cus_code,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjacincome.pay_status,cm_customerms.id_number');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->where('re_eprebate.rebate_code',$rebate_code);
		$this->db->order_by('re_eprebate.apply_date', 'DESC');
		$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return false;
	}
	/*End Of Ticket No:2952*/

	//Ticket No:3375 Added By Madushan 2021-09-01
		function first_renatl_due_date($loan_code){

		$loan_data = $this->get_loandata_loancode($loan_code);
		$this->db->select('MIN(deu_date) as first_rental_date');
		$this->db->where('loan_code',$loan_code);
		$this->db->where('reschdue_sqn',$loan_data->reschdue_sqn);
		$query = $this->db->get('re_eploanshedule');
		if($query->num_rows>0)
			return $query->row()->first_rental_date;
		else
			return '';
	}

	function get_loandata_loancode($id)
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

	//End of Ticket No:3375
	
}
