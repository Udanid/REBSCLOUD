	<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Di_return_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->model("accountinterface_model");
		
    }
	function get_all_reservation_summery($branchid) { //get all stock
	$status = array('PROCESSING', 'COMPLETE'); 
		$this->db->select('re_resevation.res_code,cm_customerms.first_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,cm_customerms.last_name,re_eploan.loan_status,re_eploan.loan_code,re_eploan.start_date,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code','left');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	
	function get_eploan_data($rescode) { //get all stock
		$this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.pay_type,re_resevation.discounted_price,re_resevation.profit_status,re_resevation.lot_id,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.lot_id');
		$this->db->where('re_eploan.res_code',$rescode);
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
	function get_all_reservation_details_bycode($rescode) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.res_code',$rescode);
		$query = $this->db->get('re_resevation');
		return $query->row();
    }
	function get_adance_payment_data($rescode) { //get all stock
		$this->db->select('re_saleadvance.*,re_prjacincome.pay_status as status,re_prjacincome.rct_no');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
			$this->db->where('re_saleadvance.res_code',$rescode);
			$this->db->where('re_saleadvance.di_amount >',0);
		$this->db->order_by('re_saleadvance.id');

		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	
	function get_loan_payment($rescode) { //get all stock

	   $this->db->select('SUM(re_eploanpayment.cap_amount) as tot_cap,SUM(re_eploanpayment.int_amount ) as tot_int,SUM(re_eploanpayment.di_amount) as tot_di,re_prjacincome.income_date ,re_prjacincome.rct_no as RCT ,re_prjacincome.pay_status as actual_status,ac_entries.date as rct_date,SUM(re_eploanpayment.pay_amount) as pay_tot,re_eploanpayment.pay_date');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
	//	$this->db->join('re_paymententries','re_paymententries.pay_id=re_prjacincome.id','left');
		$this->db->where('re_eploanpayment.loan_code',$rescode);
		$this->db->group_by('re_eploanpayment.rct_id');
		$query = $this->db->get('re_eploanpayment');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
    }
	function get_resevationdata($rescode) { //get all stock
		$this->db->select('re_resevation.*');
		$this->db->where('re_resevation.res_code',$rescode);
			$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_entry_data($id) { //get all stock
		$this->db->select('');
		$this->db->where('ac_entries.id',$id);
			$query = $this->db->get('ac_entries');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_di_return_list($pagination_counter,$page_count,$branchid) { //get all stock
		$this->db->select('re_direturn.*,re_resevation.res_code,cm_customerms.first_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,cm_customerms.last_name');
		
		$this->db->join('re_resevation','re_resevation.res_code=re_direturn.res_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->limit($pagination_counter,$page_count);
		$query = $this->db->get('re_direturn');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	
	function add_di_return($amount,$paydate,$res_code,$tot_di,$remark)
	{
		$insert_data = array(
				'res_code' =>  $res_code,
				'total_di' =>$tot_di,
				'return_amount' =>$amount,
					'apply_date' =>$paydate,
						'remark' =>$remark,
				'create_date' => date('Y-m-d'),
				'creat_by' =>$this->session->userdata('userid'),
				
				
			);
			if ( ! $this->db->insert('re_direturn', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}
			return $entry_id;
	}
	function get_di_return_total($res_code) { //get all stock
		$this->db->select('SUM(return_amount)  as tot');
		$this->db->where('re_direturn.res_code',$res_code);
			$query = $this->db->get('re_direturn');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->tot;
		}
		else
		return 0;
    } 
	function get_di_return_data($id) { //get all stock
		$this->db->select('');
		$this->db->where('re_direturn.return_id',$id);
			$query = $this->db->get('re_direturn');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    } 
	function delete_pending_return($id)
	{
		if($id)
		{
			$return_data=$this->get_di_return_data($id);
			if($return_data->status=='PENDING')
			{
				$this->db->where('return_id',$id);
				$this->db->delete('re_direturn');
				return true;
			}
		}
		return false;
	}
	function delete_confirm_return($id)
	{
		if($id)
		{
			$return_data=$this->get_di_return_data($id);
			if($return_data->status=='CONFIRMED')
			{
				
				
				update_jurnal_entry_delete($return_data->return_entry);
				$this->db->where('id',$return_data->return_entry);
				$this->db->delete('ac_entries');
				$this->db->where('entry_id',$return_data->return_entry);
				$this->db->delete('ac_entry_items');
				
				$this->db->where('return_id',$id);
				$this->db->delete('re_direturn');
				return true;
			}
			return false;
		}
		else
		{
		return false;
		}
	}
	
	function confirm_di_return($id)
	{
		$return_data=$this->get_di_return_data($id);
		if($return_data)
		{
			$res_code=$return_data->res_code;
			$amount=$return_data->return_amount;
			$paydate=date('Y-m-d');
			$current_res=$this->get_all_reservation_details_bycode($res_code);
			$loandata=$this->di_return_model->get_eploan_data($res_code);
			if($loandata)
			{
				if($loandata->loan_type!='EPB')
				$this->rental_payment($amount,$paydate,$res_code,$return_data->remark,$id);
				else
				$this->rental_payment_epb($amount,$paydate,$res_code,$return_data->remark,$id);
			}
			else
			{
				$this->add_advance($amount,$paydate,$res_code,$return_data->remark,$id);
			}
			$insert_data = array(
				'status' =>'CONFIRMED',
				'confirm_date'=>date('Y-m-d'),
				'confirm_by '=>$this->session->userdata('userid'),
			);
			$this->db->where('return_id',$id);
			$this->db->update('re_direturn', $insert_data);
			
		}
		
	}
	function add_advance($amount,$paydate,$res_code,$remark,$return_id)
	{
		
		$resdata=$this->get_resevationdata($res_code);
		
		if($resdata->profit_status=='PENDING')
		$ledgerset=get_account_set('Advanced Payment');
		else
		$ledgerset=get_account_set('Advance Payment After Profit');
		$advanceCr=$ledgerset['Cr_account'];
		$advanceDr=$ledgerset['Dr_account'];


			$this->db->trans_start();
			
			$payamount=$amount;
			
					$ledgerset=get_account_set('Delay Interest');
					$crlist[0]['ledgerid']=$advanceCr;
					$crlist[0]['amount']=$crtot=$payamount;
					$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$drlist[0]['amount']=$drtot=$payamount;
					$narration = $resdata->res_code.'Delay Interest Return '.$remark  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
					$get_entrydata=$this->get_entry_data($int_entry);
					$insert_data = array(
						'temp_code' =>  $resdata->res_code,
						'res_code' =>  $resdata->res_code,
						'pri_id' =>$resdata->prj_id,
						'cus_code' =>$resdata->cus_code,
						'lot_id' =>$resdata->lot_id,
						'branch_code' => $resdata->branch_code,
						'income_type' =>'Advance Payment',
						'amount' => $payamount,
						'income_date' =>$paydate,
						'entry_id'=>$int_entry,
						'rct_no'=>$get_entrydata->number,
						'enty_type'=>4,
						'return_entry_narration'=>$remark,
						'pay_status'=>'PAID',
						'trn_status'=>'COMPLETE'
							
					);
					if ( ! $this->db->insert('re_prjacincome', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
		
						return;
					} else {
						$entry_id = $this->db->insert_id();
					}
					
					$data=array(
					'return_entry' =>$int_entry,
					'pay_id'=>$entry_id,
					
						);
				$this->db->where('return_id', $return_id);
				$insert = $this->db->update('re_direturn', $data);
					
					
			
				$pay_seq=$this->getsequense_pay('pay_seq',$resdata->res_code,'re_saleadvance');
				$insert_data = array(
				    'pay_seq'=>$pay_seq,
					'res_code' =>$res_code,
					'di_amount' =>0,
					'tot_amount' =>$payamount,
					'waiveoff_amount' =>0,
					'pay_amount' =>$payamount,
					'rct_id' => $entry_id,
					'pay_date' =>$paydate,
				);
				if ( ! $this->db->insert('re_saleadvance', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$new_down=floatval($payamount)+floatval($resdata->down_payment);
				$outstad=floatval($resdata->total_out) - floatval($payamount);
				$data=array(
					'down_payment' => $new_down,
					'last_dpdate'=>$paydate,
					'total_out' =>$outstad,
				);
				$this->db->where('res_code', $res_code);
				$insert = $this->db->update('re_resevation', $data);
				
				
				
				update_jurnal_entry_insert('Advance Payment',$entry_id,$paydate);
		
		
		
		//add to re_reservdicount and update re_resevation
		
		return $entry_id;
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
	
	function get_arrias_instalments($rescode,$date) { //get all stock
		$this->db->select('re_eploanshedule.*');
		$this->db->where('loan_code',$rescode);
		$this->db->where('pay_status','PENDING');
		$this->db->where('deu_date <',$date);
		$this->db->order_by('deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		return $query->result();
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
	function rental_payment($amount,$paydate,$res_code,$remark,$return_id)
	{
		
		
	//	$loan_data=$this->get_eploan_data($loan_code);
	$resdata=$this->get_eploan_data($res_code);
		$arrins=$this->get_arrias_instalments($resdata->loan_code,$paydate);
		
			$intpaytot=0;

		$ledgerset=get_account_set('EP Rental');
		 if($resdata->loan_type=='ZEP'){
			$ledgerset_pay=get_account_set('ZEP Rental');

		}
		if($resdata->loan_type=='EPB'){
			$ledgerset_pay=get_account_set('EPB Rental');

		}
		if($resdata->loan_type=='NEP'){
			$ledgerset_pay=get_account_set('EP Rental');

		}

		$this->db->trans_start();
		
		
		$this->db->trans_start();
			
			$payamount=$amount;
			
					$ledgerset=get_account_set('Delay Interest');
					$crlist[0]['ledgerid']=$ledgerset_pay['Cr_account'];
					$crlist[0]['amount']=$crtot=$payamount;
					$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$drlist[0]['amount']=$drtot=$payamount;
					$narration = $resdata->res_code.'Delay Interest Return '.$remark  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
					$get_entrydata=$this->get_entry_data($int_entry);
					$insert_data = array(
						'temp_code' =>  $resdata->loan_code,
						'res_code' =>  $resdata->res_code,
						'pri_id' =>$resdata->prj_id,
						'cus_code' =>$resdata->cus_code,
						'lot_id' =>$resdata->lot_id,
						'branch_code' => $resdata->branch_code,
						'income_type' =>'Rental Payment',
						'amount' => $payamount,
						'income_date' =>$paydate,
						'entry_id'=>$int_entry,
						'rct_no'=>$get_entrydata->number,
						'enty_type'=>4,
						'return_entry_narration'=>$remark,
						'pay_status'=>'PAID',
						'trn_status'=>'COMPLETE'
							
					);
					if ( ! $this->db->insert('re_prjacincome', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
		
						return;
					} else {
						$entry_id = $this->db->insert_id();
					}
		
					$data=array(
					'return_entry' =>$int_entry,
					'pay_id'=>$entry_id,
					
						);
				$this->db->where('return_id', $return_id);
				$insert = $this->db->update('re_direturn', $data);
		
			
			//Document Fee insert


				$paylist=$this->input->post('inslist');
				$paytot=$payamount;
				$paytot=$paytot;
				$totdi=0;

				$payarray=explode(',',$paylist);
				$delaypaytot=0;
		 if($arrins)
		 {
			 foreach($arrins as $raw)
			 {
				 $thisdata=$this->get_this_instalment($raw->id);
					if($thisdata){
						$curren_int=$thisdata->int_amount-$thisdata->paid_int;
						$current_paidint=0;
						$current_paidcap=0;
						
						if($curren_int>0 && $paytot>0)
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
									'pay_date' => $paydate,
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
									'pay_date'=>$paydate,
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
		 }
				

				 $currentpaydate=date_create($paydate);
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
									'pay_date' =>$paydate,
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
									'pay_date'=>$paydate,

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
							
							$paytot=0;

						}
				}
				
				update_jurnal_entry_insert('Rental Payment',$entry_id,$paydate);
		return $entry_id;
	}
	function rental_payment_epb($amount,$paydate,$loan_code,$remark,$return_id)
	{
		$current_date=$paydate;
		$ledgerset_pay=get_account_set('EPB Rental');
		
		
		
		$resdata=$this->get_eploan_data($loan_code);
			$intpaytot=0;

	
		$this->db->trans_start();
			
			$payamount=$amount;
			
					$ledgerset=get_account_set('Delay Interest');
					$crlist[0]['ledgerid']=$ledgerset_pay['Cr_account'];
					$crlist[0]['amount']=$crtot=$payamount;
					$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$drlist[0]['amount']=$drtot=$payamount;
					$narration = $resdata->res_code.'Delay Interest Return '.$remark  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
					$get_entrydata=$this->get_entry_data($int_entry);
					$insert_data = array(
						'temp_code' =>  $resdata->loan_code,
						'res_code' =>  $resdata->res_code,
						'pri_id' =>$resdata->prj_id,
						'cus_code' =>$resdata->cus_code,
						'lot_id' =>$resdata->lot_id,
						'branch_code' => $resdata->branch_code,
						'income_type' =>'Rental Payment',
						'amount' => $payamount,
						'income_date' =>$paydate,
						'entry_id'=>$int_entry,
						'rct_no'=>$get_entrydata->number,
						'enty_type'=>4,
						'return_entry_narration'=>$remark,
						'pay_status'=>'PAID',
						'trn_status'=>'COMPLETE'
							
					);
					if ( ! $this->db->insert('re_prjacincome', $insert_data))
					{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');
		
						return;
					} else {
						$entry_id = $this->db->insert_id();
					}
					
					$data=array(
					'return_entry' =>$int_entry,
					'pay_id'=>$entry_id,
					
						);
				$this->db->where('return_id', $return_id);
				$insert = $this->db->update('re_direturn', $data);
					
					
			$paytot=$payamount;
			$loan_amount=$resdata->loan_amount;
			 $currentpaydate=date_create($paydate);

				//$paid_cap= $this->input->post('payment')-$delaytot;
				 $insert_data = array(
					'loan_code' => $resdata->loan_code,
				'reschdue_sqn' => $resdata->reschdue_sqn,
					'pay_amount' => $paytot,
					'cap_amount' =>$paytot,
					'int_amount' => 0,
					'di_amount' => 0,
					'rct_id'=>$entry_id,
					//'cap_entry'=>'',
					'pay_date'=>$paydate,
					);
			//	$this->db->where('id',$thisdata->id);
				if ( ! $this->db->insert('re_eploanpayment', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

					return;
				}
				update_jurnal_entry_insert('Rental Payment',$entry_id,$paydate);

			
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
}
