<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class message_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_letters_all($branch) {
		$this->db->select('re_cusletter.id,re_cusletter.amount,re_cusletter.letter_type,re_cusletter.loan_code, re_cusletter.create_date,re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_cuslettype.type');
		$this->db->join('re_resevation','re_resevation.res_code=re_cusletter.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_cuslettype','re_cuslettype.type_id=re_cusletter.letter_type');

		if(! check_access('all_branch'))
		$this->db->where('re_cusletter.branch_code',$branch);
		//$this->db->where_in('re_cusletter.letter_type',$type);
			$this->db->where_in('re_cusletter.print_status','PENDING');
			$this->db->order_by('re_cusletter.id','DESC');
		$query = $this->db->get('re_cusletter'); 
	//	echo $this->db->last_query();
		return $query->result(); 
    }
	function get_letters_by_type($type,$branch) {
		$this->db->select('re_cusletter.id,re_cusletter.amount,re_cusletter.letter_type,re_cusletter.loan_code, re_cusletter.create_date,re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_cusletter.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if(! check_access('all_branch'))
		$this->db->where('re_cusletter.branch_code',$branch);
		$this->db->where_in('re_cusletter.letter_type',$type);
			$this->db->where_in('re_cusletter.print_status','PENDING');
			$this->db->order_by('re_cusletter.id','DESC');
		$query = $this->db->get('re_cusletter'); 
	//	echo $this->db->last_query();
		return $query->result(); 
    }
	function get_letters_printed_lettets($type,$cucode) {
		$this->db->select('re_cusletter.id,re_cusletter.amount,re_cusletter.letter_type, re_cusletter.create_date, re_cusletter.print_status, re_cusletter.print_date,re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_cusletter.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		
		$this->db->where('re_resevation.prj_id',$cucode);
		$this->db->where_in('re_cusletter.letter_type',$type);
		$this->db->where_in('re_cusletter.print_status','PRINT');
		$this->db->order_by('re_cusletter.create_date','DESC');
		$query = $this->db->get('re_cusletter'); 
		return $query->result(); 
    }
	function eploanlist() { //get all stock
		$this->db->select('*');
				$this->db->where('loan_status','CONFIRMED');
		$query = $this->db->get('re_eploan'); 
		return $query->result(); 
    }
	function check_letter_generated($loan_code,$minid,$type)
	{
		$this->db->select('*');
		
		$this->db->where('letter_type',$type);
		$this->db->where('loan_code',$loan_code);
		$this->db->where('ins_id',$minid);
		$query = $this->db->get('re_cusletter'); 
		 if ($query->num_rows >0) {
          	return 0;
        }
		else
		return 1; 
	}
	function get_arrias_instalments($rescode,$date) { //get all stock
		$this->db->select('count(instalment) as instal,SUM(tot_instalment) as totins,SUM(balance_di) totdi,SUM(tot_payment) as totpay');
		$this->db->where('loan_code',$rescode);
		$this->db->where('pay_status','PENDING');
		$this->db->where('deu_date >=',$date);
		$this->db->where('deu_date <',date('Y-m-d'));
	//	$this->db->order_by('deu_date');
	$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanshedule'); 
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function get_instalmentdata($id)
	{
		$this->db->select('*');
		$this->db->where('id',$id);

		$query = $this->db->get('re_eploanshedule'); 
//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
	}
	function get_arrias_instalments_fordi($rescode,$date) { //get all stock
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
	function get_paid_totals_for_di($rescode,$reshedulesq) { 
	//$resdata=$this->get_eploan_data($rescode);
		$this->db->select('*');
		$this->db->where('loan_code',$rescode);
		$this->db->where('reschdue_sqn',$reshedulesq);
		$query = $this->db->get('re_eploanpayment'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
		function  generate_today_delaint($date)
	{
			$loanlist=$this->eploanlist();
			//print_r($loanlist);
			if($loanlist){
				foreach($loanlist as $loanraw)
				{
					//print_r($loanraw);
					if($loanraw->loan_type=='NEP'){
						 $ariastot= $this->get_arrias_instalments_fordi($loanraw->loan_code,$date);
						 $delaintot=0;
						 if($ariastot)
						 {	$paidtotals=0;$delaintot=0;$inslist="";$tot=0;$thisdelayint=0;
							 foreach($ariastot as $row)
							  {
								  
					 			 $paydate=$date;
								   if(get_last_payment_date_current_instalment($row->id)){
									$grace=0;
									if(get_last_payment_date_current_instalment($row->id) > $row->deu_date){
										$date1=date_create(get_last_payment_date_current_instalment($row->id)); //This function is in loan helper
									}else{
										$date1=date_create($row->deu_date);
										$grace=intval($loanraw->grase_period);;
									}						
									$date2=date_create($paydate);
			
									$diff=date_diff($date1,$date2);
									$dates=$diff->format("%a ");
									$delay_date=intval($dates)-$grace;
					  			}
					 			else
								 {
					 				 $date1=date_create($row->deu_date);
									  $date2=date_create($paydate);
									  $diff=date_diff($date1,$date2);
						     			$dates=$diff->format("%a ");
							   			 $delay_date=intval($dates)-intval($loanraw->grase_period);
								}
					//		      $date1=date_create($row->deu_date);
							    
						         $paidtotals=$row->paid_cap+$row->paid_int;
					 // echo $paidtotals.'sss';
						     	
							    $dalay_int=0;
								if($delay_date >0)
									{
										$thypedata=$this->get_saletype_by_type($loanraw->loan_type);
										if($thypedata->grace_period_effectto_di=='YES')
										$dates=$dates;
										else
										$dates=$delay_date;
										
										
										$dalay_int=(floatval($row->tot_instalment-$paidtotals))*floatval($thypedata->delay_int)*$dates/(100*30);
										$thisdelayint=$thisdelayint+$dalay_int;
					 	
					 			 	//$arieasins++;
					
									}
					//echo $thisdelayint;
								$inslist=$row->id.','.$inslist;
							//	 $delaintot= $delaintot+$dalay_int-$row->balance_di;
					 //echo $row->balance_di;
								 $currentdi=round($dalay_int,2);
								 if($currentdi<0)
								  $currentdi=0;
					 			  $delaintot=$delaintot+$currentdi;
					
					 //$thisdibalance=$dalay_int-$row->balance_di
									 $thispayment=($row->tot_instalment)-$row->tot_payment+$currentdi;
									 if($delay_date >0)
									{
									  $tot=$thispayment+$tot;
								 
									}
							  	}
							 }
							 if($delaintot<0)
									 $delaintot=0;
							 if( $delaintot>0){
							 	$data=array( 
									'loan_code'=>$loanraw->loan_code,
								'di_amount' => $delaintot,
								'last_update'=>$date,
								);
								$insert = $this->db->insert('re_eploandi', $data);
							 }
							//return $insert;
							 
					}
					else
					{
						 	$current_date=date('Y-m-d');
							 $futureDate=$loanstart_date=$loanraw->start_date;
							 $thypedata=$this->get_saletype_by_type($loanraw->loan_type);
 							$end_date1=$end_date=date('Y-m-d',strtotime('+'.intval($loanraw->period).' months',strtotime($futureDate)));
							if($end_date>$current_date)
							{
								$delaintot=0;
							}
							else
							{
								$paymentdata=$this->get_paid_totals_for_di($loanraw->loan_code,$loanraw->reschdue_sqn);
								$loancap=$loanraw->loan_amount;$loandi=0;
								 
								if($paymentdata){
									foreach($paymentdata as $payraw){
										$paydate=date('Y-m-d',strtotime($payraw->pay_date));
										
										if($paydate>$end_date1)
										{
											if($end_date1>$end_date){
											 $date1=date_create($end_date1);
											  $date2=date_create($paydate);
											 $diff=date_diff($date1,$date2);
											 $dates=$diff->format("%a ");
											  $delaintot=$delay_int=($dates*$loancap*$thypedata->delay_int)/(30*100);
											}
										}
										$end_date1=$paydate;
										$loancap=$loancap-$payraw->cap_amount;
										//$loandi=$loandi+$delaintot-$payraw->di_amount;
									
									}
								
								}
								
										$currentdate=$date;
										if($currentdate>$end_date1)
										{
											if($end_date>$end_date1){
											 $date1=date_create($end_date);
											  $date2=date_create($currentdate);
											 $diff=date_diff($date1,$date2);
											 $dates=$diff->format("%a ");
											  $delaintot=$delay_int=($dates*$loancap*$thypedata->delay_int)/(30*100);
											  $loandi=$loandi+$delaintot;
											}
											else
											{
												 $date1=date_create($end_date1);
											  $date2=date_create($currentdate);
											 $diff=date_diff($date1,$date2);
											 $dates=$diff->format("%a ");
											  $delaintot=$delay_int=($dates*$loancap*$thypedata->delay_int)/(30*100);
											  $loandi=$loandi+$delaintot;
											}
											
											
											
												
										}
										
										if($loancap>0){
											//$loandi=$loandi-$this->get_waveoffdi_for_di($loanraw->loan_code);
										 if($loandi<0)
											 $loandi=0;
											 if( $loandi>0){
												 	$data=array( 
													'loan_code'=>$loanraw->loan_code,
													'di_amount' => $loandi,
													'last_update'=>$date,
													);
										$insert = $this->db->insert('re_eploandi', $data);
											 }
							 }
								
							}
					}
				}
			}
		
		
	}
	function is_generate_di($date)
	{
		$this->db->select('*');
		$this->db->where('last_update',$date);
		$query = $this->db->get('re_eploandi'); 
		if ($query->num_rows() > 0){
		return false;
		}
		else
		return true;
	}
	function get_loan_date_di($loan,$date)
	{
		$this->db->select('*');
		$this->db->where('last_update',$date);
			$this->db->where('loan_code',$loan);
		$query = $this->db->get('re_eploandi'); 
		if ($query->num_rows() > 0){
		$raw=$query->row();
		 $di=$raw->di_amount;
		 return $di;
		}
		else
		return 0;
	}
	function generate_first_remind()
	{
		$duedata_my=date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
		$loanlist=$this->eploanlist();
		foreach($loanlist as $raw)
		{
		$this->db->select('MIN(id) as minid');
		$this->db->where('pay_status','PENDING');
		$this->db->where('loan_code',$raw->loan_code);
		$this->db->where('deu_date ',$duedata_my);
		$this->db->where('tot_payment <=',0);
		//$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
//
		if ($query->num_rows() > 0){
				
		$data= $query->row();
		$minid=$data->minid;
		if($minid)
		{
			
		//echo  $minid;
				if($this->check_letter_generated($raw->loan_code,$minid,'04'))
				{$msg='';
				$instata=$this->get_instalmentdata($minid);
				if($instata){
			
				$duedata=$instata->deu_date;
				//echo  $duedata;
					if($raw->loan_type!='EPB'){
					$getarreas=$this->get_arrias_instalments($raw->loan_code,$duedata);
					$amount=$arrs_amount=0;
					if($getarreas){
					$arrs_ins=$getarreas->instal;
					$amount=$arrs_amount=$getarreas->totins-$getarreas->totpay;
					if($amount >= $instata->tot_instalment)
					{
						$delay_int=$this->get_loan_date_di($raw->loan_code,date('Y-m-d'));
						if($delay_int==0){
							$delay_int=($arrs_amount*$raw->delay_interest/100)-$getarreas->totdi;
							if($delay_int<0) $delay_int=0;
						}
						$due_date=date('Y-m-d',strtotime('+7 days',strtotime(date('Y-m-d'))));
						$this->create_letter_ep($raw->branch_code,$raw->cus_code,$raw->res_code,$raw->loan_code,$minid,'04',$msg,$amount,$arrs_ins,$arrs_amount,$delay_int,$due_date);
					}
					}
					}
				}
				}
		}
			
		}
		
		}
	}
	function generate_second_remind()
	{
		$duedata_my=date('Y-m-d',strtotime('-40 days',strtotime(date('Y-m-d'))));
		$loanlist=$this->eploanlist();
		foreach($loanlist as $raw)
		{
		$this->db->select('MIN(id) as minid');
		$this->db->where('pay_status','PENDING');
		$this->db->where('loan_code',$raw->loan_code);
		$this->db->where('deu_date ',$duedata_my);
		$this->db->where('tot_payment <=',0);
		//$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
//
		if ($query->num_rows() > 0){
				
		$data= $query->row();
		$minid=$data->minid;
		if($minid)
		{
			$duedata=date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
		
				if($this->check_letter_generated($raw->loan_code,$minid,'05'))
				{	$msg='';
				$instata=$this->get_instalmentdata($minid);
				if($instata){
			
				$duedata=$instata->deu_date;
					if($raw->loan_type!='EPB'){
					$getarreas=$this->get_arrias_instalments($raw->loan_code,$duedata);
					$amount=$arrs_amount=0;
					if($getarreas){
						//print_r($getarreas);
					$arrs_ins=$getarreas->instal;
					$amount=$arrs_amount=$getarreas->totins-$getarreas->totpay;
					$tobearrars=$instata->tot_instalment*2;
						if($amount >= $tobearrars)
						{
							$delay_int=($arrs_amount*$raw->delay_interest/100)-$getarreas->totdi;
							if($delay_int<0) $delay_int=0;
							$due_date=date('Y-m-d',strtotime('+7 days',strtotime(date('Y-m-d'))));
							$this->create_letter_ep($raw->branch_code,$raw->cus_code,$raw->res_code,$raw->loan_code,$minid,'05',$msg,$amount,$arrs_ins,$arrs_amount,$delay_int,$due_date);
						}
					}
					}
				}
				}
		}
			
		}
		
		}
	}
	function generate_third_remind()
	{
		$duedata_my=date('Y-m-d',strtotime('-70 days',strtotime(date('Y-m-d'))));
		$loanlist=$this->eploanlist();
		foreach($loanlist as $raw)
		{
		$this->db->select('MIN(id) as minid');
		$this->db->where('pay_status','PENDING');
		$this->db->where('loan_code',$raw->loan_code);
		$this->db->where('deu_date ',$duedata_my);
		$this->db->where('tot_payment <=',0);
		//$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
//
		if ($query->num_rows() > 0){
				
		$data= $query->row();
		$minid=$data->minid;
		if($minid)
		{
			$duedata=date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
		//echo  $minid;
				if($this->check_letter_generated($raw->loan_code,$minid,'06'))
				{$msg='';
				$instata=$this->get_instalmentdata($minid);
				if($instata){
			
				$duedata=$instata->deu_date;
					if($raw->loan_type!='EPB'){
					$getarreas=$this->get_arrias_instalments($raw->loan_code,$duedata);
					if($getarreas){
					$arrs_ins=$getarreas->instal;
					$amount=$arrs_amount=$getarreas->totins-$getarreas->totpay;
					$tobearrars=$instata->tot_instalment*3;
						if($amount >= $tobearrars)
						{
						$delay_int=($arrs_amount*$raw->delay_interest/100)-$getarreas->totdi;
						if($delay_int<0) $delay_int=0;
						$due_date=date('Y-m-d',strtotime('+7 days',strtotime(date('Y-m-d'))));
						$this->create_letter_ep($raw->branch_code,$raw->cus_code,$raw->res_code,$raw->loan_code,$minid,'06',$msg,$amount,$arrs_ins,$arrs_amount,$delay_int,$due_date);
						}
					}
					}
				}
				}
		}
			
		}
		
		}
	}
	
	function generate_termination_letter()
	{
		$duedata_my=date('Y-m-d',strtotime('-75 days',strtotime(date('Y-m-d'))));
		$loanlist=$this->eploanlist();
		foreach($loanlist as $raw)
		{
		$this->db->select('MIN(id) as minid');
		$this->db->where('pay_status','PENDING');
		$this->db->where('loan_code',$raw->loan_code);
		$this->db->where('deu_date',$duedata_my);
		$this->db->where('tot_payment <=',0);
		//$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
//
		if ($query->num_rows() > 0){
				
		$data= $query->row();
		$minid=$data->minid;
		if($minid)
		{
		//echo  $minid;
		$duedata=date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
				if($this->check_letter_generated($raw->loan_code,$minid,'07'))
				{$msg='';
					$instata=$this->get_instalmentdata($minid);
					if($instata){
			
				$duedata=$instata->deu_date;
					if($raw->loan_type!='EPB'){
					$getarreas=$this->get_arrias_instalments($raw->loan_code,$duedata);
					if($getarreas){
					$arrs_ins=$getarreas->instal;
					$amount=$arrs_amount=$getarreas->totins-$getarreas->totpay;
					$tobearrars=$instata->tot_instalment*3;
						if($amount >= $tobearrars)
						{
							$delay_int=($arrs_amount*$raw->delay_interest/100)-$getarreas->totdi;
							if($delay_int<0) $delay_int=0;
							$due_date=date('Y-m-d',strtotime('+7 days',strtotime(date('Y-m-d'))));
							$this->create_letter_ep($raw->branch_code,$raw->cus_code,$raw->res_code,$raw->loan_code,$minid,'07',$msg,$amount,$arrs_ins,$arrs_amount,$delay_int,$due_date);
						}
					}
					}
				}
				}
		}
			
		}
		
		}
	}
	function generate_resale_letter()
	{
		$duedata_my=date('Y-m-d',strtotime('-80 days',strtotime(date('Y-m-d'))));
		$loanlist=$this->eploanlist();
		foreach($loanlist as $raw)
		{
		$this->db->select('MIN(id) as minid');
		$this->db->where('pay_status','PENDING');
		$this->db->where('loan_code',$raw->loan_code);
		$this->db->where('deu_date ',$duedata_my);
		$this->db->where('tot_payment <=',0);
		//$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
//
		if ($query->num_rows() > 0){
				
		$data= $query->row();
		$minid=$data->minid;
		if($minid)
		{
		//echo  $minid;
		$duedata=date('Y-m-d',strtotime('-5 days',strtotime(date('Y-m-d'))));
				if($this->check_letter_generated($raw->loan_code,$minid,'08'))
				{$msg='';
					$instata=$this->get_instalmentdata($minid);
					if($instata){
			
				$duedata=$instata->deu_date;
					if($raw->loan_type!='EPB'){
					$getarreas=$this->get_arrias_instalments($raw->loan_code,$duedata);
					if($getarreas){
					$arrs_ins=$getarreas->instal;
					$amount=$arrs_amount=$getarreas->totins-$getarreas->totpay;
					$tobearrars=$instata->tot_instalment*3;
						if($amount >= $tobearrars)
						{
					$delay_int=($arrs_amount*$raw->delay_interest/100)-$getarreas->totdi;
					
					if($delay_int<0) $delay_int=0;
					$due_date=date('Y-m-d',strtotime('+7 days',strtotime(date('Y-m-d'))));
					$this->create_letter_ep($raw->branch_code,$raw->cus_code,$raw->res_code,$raw->loan_code,$minid,'08',$msg,$amount,$arrs_ins,$arrs_amount,$delay_int,$due_date);
						}
					}
					}
				}
				}
		}
			
		}
		
		}
	}
	
	function get_letter_types()
	{
		$this->db->select('*');
		
	$query = $this->db->get('re_cuslettype'); 
		 if ($query->num_rows >0) {
             //$data=$query->row();
			 return $query->result();
        }
		else
		return false; 
	}
	function get_letter_byid($id)
	{
		$this->db->select('*');
		
		$this->db->where('id',$id);
		$query = $this->db->get('re_cusletter'); 
		 if ($query->num_rows >0) {
          	 return $query->row();
        }
		else
		return false; 
	}
	function get_letter_type($id)
	{
		$this->db->select('*');
		
		$this->db->where('type_id',$id);
		$query = $this->db->get('re_cuslettype'); 
		 if ($query->num_rows >0) {
             $data=$query->row();
			 return $data->type;
        }
		else
		return false; 
	}
	function get_customer_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('cus_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_customerms'); 
		return $query->row(); 
    }
	function create_letter_ep($branch_code,$cus_code,$res_code,$loan_code,$ins_id,$letter_type,$msg,$amount,$arrs_ins,$arrs_amount,$delay_int,$due_date)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'branch_code'=>$branch_code,
		'cus_code' => $cus_code,
		'res_code' => $res_code,
		'loan_code' => $loan_code,
		'ins_id' => $ins_id,
		'letter_type' => $letter_type,
		'amount' => $amount,
		'arrs_ins' => $arrs_ins,
		'arrs_amount' => $arrs_amount,
		'delay_int' => $delay_int,
		'due_date' => $due_date,
		'create_date'=>date('Y-m-d'),
		'creat_by'=>$this->session->userdata('userid'),
		
		);
		$insert = $this->db->insert('re_cusletter', $data);
		$cusdata=$this->get_customer_bycode($cus_code);
		$this->send_sms($cusdata->mobile,$msg);
		return $insert;
		//echo $letter_type;
	}
	function create_letter($branch_code,$cus_code,$res_code,$loan_code,$ins_id,$letter_type,$msg,$amount)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'branch_code'=>$branch_code,
		'cus_code' => $cus_code,
		'res_code' => $res_code,
		'loan_code' => $loan_code,
		'ins_id' => $ins_id,
		'letter_type' => $letter_type,
		'amount' => $amount,
		'create_date'=>date('Y-m-d'),
		'creat_by'=>$this->session->userdata('userid'),
		
		);
		$insert = $this->db->insert('re_cusletter', $data);
		$cusdata=$this->get_customer_bycode($cus_code);
		$this->send_sms($cusdata->mobile,$msg);
		return $insert;
		//echo $letter_type;
	}
	function send_sms($number,$msg)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'number'=>$number,
		'text' => $msg,
		'create_date'=>date('Y-m-d'),
		);
		//$insert = $this->db->insert('cm_outbox', $data);
	//	return $insert;
		
	}
	
	function add_cronjob($start)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'cron_date'=>$start,
		'status' => 'RUN',
		
		);
		$insert = $this->db->insert('cm_crontest', $data);
		return $insert;
		
	}
	function get_last_cron() { //get all stock
		$this->db->select('MAX(cron_date) as lastupdate');
		//$this->db->where('cus_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_crontest'); 
		return $query->row(); 
    }
	function update_print_status($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'print_status'=>'PRINT',
		'print_date'=>date('Y-m-d'),
		'print_by'=>$this->session->userdata('userid'),
		);
		$this->db->where('id',$id);
		$insert = $this->db->update('re_cusletter', $data);
		return $insert;
		
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
	function eploanlist_sms() { //get all stock
		$this->db->select('re_eploan.*,cm_customerms.mobile,re_projectms.project_name,re_prjaclotdata.lot_number,');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->where('loan_status','CONFIRMED');
				$this->db->where('loan_type !=','EPB');
		$query = $this->db->get('re_eploan'); 
		return $query->result(); 
    }
	function get_arrias_totals_sms($rescode,$date) { //get all stock
		$this->db->select('count(instalment) as instal,SUM(tot_instalment) as totins,SUM(balance_di) totdi,SUM(tot_payment) as totpay');
		$this->db->where('loan_code',$rescode);
		$this->db->where('pay_status','PENDING');
		$this->db->where('deu_date <',$date);
	//	$this->db->order_by('deu_date');
		$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanshedule'); 
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function send_sms_reminder($number,$msg,$date,$status)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'number'=>$number,
		'text' => $msg,
		'create_date'=>$date,
		'status'=>$status
		);
		$insert = $this->db->insert('cm_outbox', $data);
		return $insert;
		
	}
	function generate_sms_alert($stdate)
	{
		$duedata_my=date('Y-m-d',strtotime('-1 days',strtotime($stdate)));
		$loanlist=$this->eploanlist_sms();
		foreach($loanlist as $raw)
		{
		$this->db->select('MIN(id) as minid');
		$this->db->where('pay_status','PENDING');
		$this->db->where('loan_code',$raw->loan_code);
		$this->db->where('deu_date ',$duedata_my);
		
		//$this->db->group_by('id');
		$query = $this->db->get('re_eploanshedule'); 
//
		if ($query->num_rows() > 0){
				
		$data= $query->row();
		$minid=$data->minid;
		if($minid)
		{
			
		//echo  $minid;
				$msg='';
				$instata=$this->get_instalmentdata($minid);
				if($instata){
			
				$duedata=$instata->deu_date;
				//echo  $duedata;
					$mobile=$raw->mobile;
					$number="";
					 if($mobile){
						$mobarr=explode('/', $mobile);
						 $number=$mobarr[0];
						
					 }
					$getarreas=$this->get_arrias_totals_sms($raw->loan_code,$stdate);
					$amount=$arrs_amount=0;
					if($getarreas){
					$arrs_ins=$getarreas->instal;
					$amount=$arrs_amount=$getarreas->totins-$getarreas->totpay;
					$date=date("j F",strtotime($duedata_my));
					$msg='Your arrears rental as at '.$date.' for '.$raw->project_name.' land lot No.'.$raw->lot_number.' is Rs. '.number_format($amount,2).'. Please settle immediately to avoid delay interest.';
					
							//	$number='0778630800';					
							$MSISDN = $number;
							$MESSAGE =$msg;
							$USERNAME = "winrose";
							$PWD = "win2020";
							$SRC = "WINROSE";
							
							
							$url = 'http://203.153.222.25:5000/sms/send_sms.php';
							$myvars = 'username=' . $USERNAME . '&password=' . $PWD . '&src=' . $SRC . '&dst=' . $MSISDN . '&msg=' . $MESSAGE;
							
							$ch = curl_init( $url );
							
							curl_setopt( $ch, CURLOPT_POST, 1);
							curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
							curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt( $ch, CURLOPT_HEADER, 0);
							curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
							
							$response = curl_exec( $ch );
							if($response!='no_routes')
							$status='SUCCESS';
							else
							$status='FAIL';
							$this->send_sms_reminder($number,$msg,$stdate,$status);
					
					}
				}
			}
		}
		
			
		
		
	}
}
	
	
	function get_letternotification()
	{
		
		 if ( check_access('print_customerletter '))
        {
			$this->db->select('COUNT(id) as counter');
			$this->db->where_in('re_cusletter.print_status','PENDING');
			$query = $this->db->get('re_cusletter'); 
			
			if ($query->num_rows() > 0){
					
			$data= $query->row();
			 return $data->counter;
			}
			else
			return 0;
		}
		else
		return 0;
	
	}
	
}