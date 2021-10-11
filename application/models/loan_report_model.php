<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class loan_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
function get_eploan_data($rescode) { //get all stock
		$this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.pay_type,re_resevation.discounted_price,re_resevation.profit_status,re_resevation.lot_id,re_customerms.first_name,re_customerms.last_name,re_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.lot_id');
		$this->db->where('re_eploan.loan_code',$rescode);
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
    function get_project_loan_lots($prj_id)
    {
      $this->db->select('re_prjaclotdata.*');
      $this->db->join('re_resevation','re_eploan.res_code = re_resevation.res_code');
      $this->db->join('re_prjaclotdata','re_resevation.lot_id = re_prjaclotdata.lot_id');

      //$this->db->where('re_resevation.prj_id',$prjid);
      $this->db->where('re_prjaclotdata.prj_id',$prj_id);
      $query=$this->db->get('re_eploan');
      if($query->num_rows()>0){
        return $query->result();
      }else{
        return false;
      }
    }
    function get_loan_list($prjid,$date,$lot_id)
    {
      $this->db->select('re_eploan.*,
      re_resevation.prj_id,
      re_prjaclotdata.lot_number,SUM(re_eploanshedule.cap_amount) AS cap_amount,
      SUM(re_eploanshedule.int_amount) AS int_amount');
      $this->db->join('re_resevation','re_eploan.res_code = re_resevation.res_code');
      $this->db->join('re_prjaclotdata','re_resevation.lot_id = re_prjaclotdata.lot_id');
      $this->db->join('re_eploanshedule','re_eploan.loan_code = re_eploanshedule.loan_code','left');
      if($lot_id!="")
      {
        $this->db->where('re_prjaclotdata.lot_id',$lot_id);
      }
      $this->db->where('re_resevation.prj_id',$prjid);
      $this->db->where('re_eploan.start_date <=',$date);
      $this->db->group_by('re_eploan.loan_code');
	    $this->db->order_by('re_eploan.start_date');
      $query=$this->db->get('re_eploan');
      if($query->num_rows()>0){
        return $query->result();
      }else{
        return false;
      }
    }
	function get_reshedule_data($loancode,$date)
    {
      $this->db->select('*');
      $this->db->where('re_epreschedule.loan_code',$loancode);
	  $this->db->order_by('re_epreschedule.rsch_code');
   //   $this->db->where('re_epreschedule.confirm_date <',$date);
   	  $query=$this->db->get('re_epreschedule');
      if($query->num_rows()>0){
		
       $data= $query->row();
	     if($data->confirm_date >$date)
		 {
			 $dataval['cap']=$data->loan_stcap;
		 	 $dataval['int']=$data->loan_stinttot;
		 }
		 else
		 {
			  $dataval['cap']=$data->new_cap;
		 	 $dataval['int']=$data->new_totint;
		 }
		 return $dataval;
      }else{
        return false;
      }
    }
    function get_loan_payment_data($loan_code,$date)
    {
		$resdata=$this->get_eploan_data($loan_code);
		
      $this->db->select('SUM(re_eploanpayment.cap_amount+re_eploanpayment.int_amount) AS pay_amount,
SUM(re_eploanpayment.cap_amount) AS cap_amount,
SUM(re_eploanpayment.int_amount) AS int_amount,
SUM(re_eploanpayment.di_amount) AS di_amount,');
	$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
		$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
	
$this->db->where('re_eploanpayment.loan_code',$loan_code);
//	$this->db->where('re_eploanpayment.reschdue_sqn',$resdata->reschdue_sqn);
$this->db->where('ac_entries.date <=',$date);
$query=$this->db->get('re_eploanpayment');
if($query->num_rows()>0){
	//echo $this->db->last_query();
  return $query->row();
}else{
  return false;
}
}
function get_loan_settleddata($loan_code,$date)
{
      $this->db->select('
	re_eprebate.balance_capital AS cap_amount,
	re_eprebate.int_paidamount AS int_amount,
	re_eprebate.delay_int AS di_amount,re_eprebate.apply_date');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
			$this->db->join('ac_entries','ac_entries.id=re_prjacincome.entry_id','left');
		
	$this->db->where('re_eprebate.loan_code',$loan_code);

	$this->db->where('ac_entries.date <=',$date);
	$query=$this->db->get('re_eprebate');
	if($query->num_rows()>0){
	  return $query->row();
	}else{
	  return false;
	}
 }
function get_nonrefund_amount($loan_code,$date)
    {
			  $this->db->select('re_arreaspayment.amount');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_arreaspayment.voucher_id','left');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_arreaspayment.pay_id');
			
		$this->db->where('re_arreaspayment.loan_code',$loan_code);
		
		$this->db->where('ac_payvoucherdata.applydate <=',$date);
		$this->db->where('ac_payvoucherdata.paymentdate ',NULL);
		$this->db->or_where('ac_payvoucherdata.paymentdate >',$date);
		$query=$this->db->get('re_arreaspayment');
		if($query->num_rows()>0){
		  $data=$query->row();
		  return $data->amount; 
		}else{
		  return 0;
		}
	}
    function get_loan_unrelized_data($res_code,$date)
    {
      $this->db->select('*');
      $this->db->where('re_unrealized.res_code',$res_code);
      $query=$this->db->get('re_unrealized');
	 
      if($query->num_rows()>0){
		//   echo $this->db->last_query().'<br>';
        return $query->row();
      }else{
        return false;
      }
    }
	
	 function update_all_loan_confirmation_entires()
    {
      $this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.lot_id');
   	 $this->db->join('re_resevation','re_eploan.res_code = re_resevation.res_code');
     
      $query=$this->db->get('re_eploan');
	 
      if($query->num_rows()>0){
		//   echo $this->db->last_query().'<br>';
        $data=$query->result();
		foreach($data as $raw)
		{
			$naration = $raw->res_code.' Transfer Sale';
			$insert_data1=array('date'=>$raw->start_date.' 00:00:00');
			$this->db->where('prj_id',$raw->prj_id);
			$this->db->where('lot_id',$raw->lot_id);
			$this->db->where('narration',$naration);
			$this->db->where('date',$raw->confirm_date.' 00:00:00');
			$this->db->update('ac_entries', $insert_data1);
			$naration = $raw->res_code.' Cost  Trasnfer  '  ;
			$insert_data2=array('date'=>$raw->start_date.' 00:00:00');
			$this->db->where('prj_id',$raw->prj_id);
			$this->db->where('lot_id',$raw->lot_id);
			$this->db->where('narration',$naration);
			$this->db->where('date',$raw->confirm_date.' 00:00:00');
			$this->db->update('ac_entries', $insert_data2);
			$naration = $raw->res_code.' Unrialized Sale  Trasnfer  '  ;
			$insert_data3=array('date'=>$raw->start_date.' 00:00:00');
			$this->db->where('prj_id',$raw->prj_id);
			$this->db->where('lot_id',$raw->lot_id);
			$this->db->where('narration',$naration);
			$this->db->where('date',$raw->confirm_date.' 00:00:00');
			$this->db->update('ac_entries', $insert_data3);
			$naration = $raw->loan_code.' EP Loan Interest transfer';
			$insert_data4=array('date'=>$raw->start_date.' 00:00:00');
			$this->db->where('prj_id',$raw->prj_id);
			$this->db->where('lot_id',$raw->lot_id);
			$this->db->where('narration',$naration);
			$this->db->where('date',$raw->confirm_date.' 00:00:00');
			$this->db->update('ac_entries', $insert_data4);
			echo $raw->loan_code.'---'.$raw->confirm_date.'---'.$raw->start_date;
			
			
			 $insert_data=array('resale_date'=>$raw->start_date);
						$this->db->where('res_code',$raw->res_code);
						$this->db->update('re_resevation', $insert_data);
		}
		
      }else{
        return false;
      }
    }
	
	function update_cancelation_entry_prj()
	{
		$this->db->select('*');
		$this->db->where('RCTSTATUS','CANCEL');
		$query2 = $this->db->get('ac_recieptdata');
		if ($query2->num_rows() > 0){
							
			$dataset2=$query2->result();
			foreach ($dataset2 as $raw2)
			{
				if($raw2->CNREFNO)
				{
					 $this->db->select('*');
					// $this->db->where_in('prj_id',$status);
					 $this->db->where('id',$raw2->RCTREFNO);
					 $query3 = $this->db->get('ac_entries');
					// echo $this->db->last_query();
					 if ($query3->num_rows() > 0){
						 $data4=$query3->row();
						  $dataaa=array(
								
								
								'prj_id' =>$data4->prj_id,
								'lot_id' =>$data4->lot_id,
							
		
								);
								echo $data4->date.'-'.$data4->number.'<br>';
								$this->db->where('id',$raw2->CNREFNO);
								$insert = $this->db->Update('ac_entries', $dataaa);
						
						 
					 }
				}
			}
		}

	}
	function update_ZEP_reciepts()
	{
		 $this->db->select('re_prjacincome.*');
       $this->db->join('ac_entry_items','ac_entry_items.entry_id = re_prjacincome.entry_id');
	    $this->db->where('re_prjacincome.income_type','Rental Payment');
		  $this->db->where('ac_entry_items.ledger_id','HEDBL34000100');
      $query=$this->db->get('re_prjacincome');
      if($query->num_rows()>0){
        $data=$query->result();
		foreach($data as $raw)
		{
			 $dataaa=array(
				'ledger_id' =>'HEDBA16020000',
				
				);
				$this->db->where('entry_id',$raw->entry_id);
				$this->db->where('ledger_id','HEDBL34000100');
				echo $raw->temp_code.'-'.$raw->income_date.'<br>';
				$insert = $this->db->Update('ac_entry_items', $dataaa);
		}
      }else{
        return false;
      }
	}
}
