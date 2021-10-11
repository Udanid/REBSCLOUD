<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Financialtransfer_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->model("reservation_model");
		$this->load->model("eploan_model");
    }
	function get_resevation($id) { //get all stock
		$this->db->select('re_resevation.*');
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
			}
	
	}
	function initial_profit_transfer($res_code,$pay_id=0,$initialized_mode,$date)
	{
		$reseavation_data=$this->get_resevation($res_code);
		$lot_data=$this->get_lotdata($reseavation_data->lot_id);
		$lot_type=$lot_data->lot_type;
		 $id=$pay_id;
		if($lot_type=='R')
		$rate=get_rate('Profit Transfer Rate');
		else
		$rate=get_rate('Profit Transfer Rate housing');
		$current_payment=$reseavation_data->down_payment;
		if($current_payment>$reseavation_data->discounted_price)
		{// when customer made excess payment for the reservation excess amount not take to profit transfer
			$current_payment=$reseavation_data->discounted_price;
		}
		
		$outright_profitmode=profit_outright_method();
		$loan_profitmode=profit_agreement_method();
				
				$presentage= ($current_payment/$reseavation_data->discounted_price)*100;
			//	echo $presentage.'--'.$rate;
				$flag=false;
				if($initialized_mode=='Advance Payment')
				{ 
					
					if($outright_profitmode==2 || $outright_profitmode==3)
					{
						if($presentage >= $rate)
						$flag=true;
						else
						$flag=false;
						if($outright_profitmode==3)
						{
							$current_payment=$reseavation_data->discounted_price;// full profit transfer on downpaymen completion
						}
					}
					else
					{ // profit transfer only on current payid amount ==1000
						if($presentage==100)
						$flag=true;
						else
						$flag =false;
					}
				}
				else
				{
					
					if($loan_profitmode==1)
						$current_payment= $reseavation_data->discounted_price;
					$flag=true;
				}
				if($flag)
				{
					//check profit relized amount real estate and housing
					
					
					if($current_payment >= $reseavation_data->re_discounted_price)
					{
					$realized_sale_re=$reseavation_data->re_discounted_price;
					$realized_sale_hm=$current_payment-$reseavation_data->re_discounted_price;
					
					}
					else
					{
						$realized_sale_re=$current_payment;
						$realized_sale_hm=0;
						
					}
					$realized_cost_re=($realized_sale_re/$reseavation_data->re_discounted_price)*$lot_data->costof_sale;					
				
					$unrealised_sale_re=round($reseavation_data->re_discounted_price-$realized_sale_re,2);
					$unrealized_cost_re=round($lot_data->costof_sale-$realized_cost_re,2);
					$realized_cost_hm=0;$unrealised_sale_hm=0;$unrealized_cost_hm=0;
					
					$unrealised_sale_hm=$reseavation_data->hm_discounted_price-$realized_sale_hm;
					if($lot_type=='H')
					{
							if($realized_sale_hm>0)
							{
								$realized_cost_hm=($realized_sale_hm/$reseavation_data->hm_discounted_price)*$lot_data->housing_cost;
							}
								$unrealized_cost_hm=$lot_data->housing_cost-$realized_cost_hm;
								
							//housing cost and sale transfer funcion
							
								$ledgerset=get_account_set('Cost Transfer Hm');
								$uncost=get_account_set('Unrealized Cost Hm');
								$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
								$crlist[0]['amount']=$crtot=$lot_data->housing_cost;
								$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
								$drlist[0]['amount']=$drtot=$realized_cost_hm;
								$drlist[1]['ledgerid']=$uncost['Dr_account'];
								$drlist[1]['amount']=$drtot=$unrealized_cost_hm;
								$drtot=$lot_data->housing_cost;
								$narration = $reseavation_data->res_code.' Cost  Trasnfer Housing  '  ;
								$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
								$this->insert_pay_enties($id,$int_entry,'Cost  Trasnfer Housing');
								$drlist=NULL;
								$crlist=NULL;
								if($realized_sale_hm>0)
								{
								$ledgerset=get_account_set('Sale Transfer Hm');
								$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
								$crlist[0]['amount']=$crtot=$realized_sale_hm;
								$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
								$drlist[0]['amount']=$drtot=$realized_sale_hm;
								$narration = $reseavation_data->res_code.'  sale Trasnfer Housing  '  ;
								$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id);
								$this->insert_pay_enties($id,$int_entry,'Sale Trasnfer Housing');
								}
							
							
					
					}
					//realised land sale income transfer
					$drlist=NULL;
					$crlist=NULL;
					$ledgerset=get_account_set('Transfer Sale');
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$realized_sale_re;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$realized_sale_re;
					$narration = $reseavation_data->res_code.'  sale Trasnfer  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
					$this->insert_pay_enties($id,$int_entry,'Sale Trasnfer');
					
					
					//Land sale Cost Transfer
					$drlist=NULL;
					$crlist=NULL;
					
						$ledgerset=get_account_set('Transfer Cost');
						$crledger=$ledgerset['Cr_account'];
						$drleger=$ledgerset['Dr_account'];
					if($reseavation_data->init_costtrn_status!='PENDING')
					{	$ledgerset=get_account_set('Initial cost transfer');
						$crledger=$ledgerset['Dr_account'];
					}
					
					$drlist=NULL;
					$crlist=NULL;
					$uncost=get_account_set('Unrealized Cost');
					$crlist[0]['ledgerid']=$crledger;
					$crlist[0]['amount']=$crtot=$lot_data->costof_sale;
					$drlist[0]['ledgerid']=$drleger;
					$drlist[0]['amount']=$drtot=$realized_cost_re;
					$drlist[1]['ledgerid']=$uncost['Dr_account'];
					$drlist[1]['amount']=$drtot=$unrealized_cost_re;
					$drtot=$lot_data->costof_sale;
					$narration = $reseavation_data->res_code.' Cost  Trasnfer  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
			
					$this->insert_pay_enties($id,$int_entry,'Cost Trasnfer');
					// Unrealized sale transfer both land and housing value;
					// This part checks calling method : if calling method is payment, balance amount transfer to the trade debtor account			//if the calling method is agrrement creation, balance amount transfer to the loan capital account;
					if($initialized_mode=='Advance Payment')
					{
							$ledgerset=get_account_set('Advance Payment After Profit');
							$draccount=$ledgerset['Cr_account'];
					}
					else
					{
						if($reseavation_data->pay_type=='NEP'){
							$ledgerset=get_account_set('EP creation');
							$draccount=$ledgerset['Dr_account'];
						}
						if($reseavation_data->pay_type=='EPB'){
							$ledgerset=get_account_set('EPB Creation');
							$draccount=$ledgerset['Dr_account'];
						}
						if($reseavation_data->pay_type=='ZEP'){
							$ledgerset=get_account_set('ZEP Creation');
							$draccount=$ledgerset['Dr_account'];
						}
					}
					$drlist=NULL;
					$crlist=NULL;
					$balance_amount=$unrealised_sale_re+$unrealised_sale_hm;
					if($balance_amount>0)
					{
						$unsale=get_account_set('Unrealized Sale');
						$unsale_hm=get_account_set('Unrealized Sale Hm');
					
						$crlist[0]['ledgerid']=$unsale['Cr_account'];
						$crlist[0]['amount']=$crtot=$unrealised_sale_re;
						if($unrealised_sale_hm>0)
						{
							$crlist[1]['ledgerid']=$unsale_hm['Cr_account'];
							$crlist[1]['amount']=$crtot=$unrealised_sale_hm;
						}
						$drlist[0]['ledgerid']=$draccount;
						$drlist[0]['amount']=$drtot=$balance_amount;
						$crtot=$drtot=$balance_amount;
						$narration = $reseavation_data->res_code.' Unrialized Sale  Trasnfer  '  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						
						$this->insert_pay_enties($id,$int_entry,'Sale Trasnfer');
					}
					
					
					$insert_data=array('status'=>'SOLD');
					$this->db->where('lot_id',$reseavation_data->lot_id);
						if ( ! $this->db->update('re_prjaclotdata', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
							 $insert_data=array('profit_status'=>'TRANSFERD','profit_date'=>$date);
						$this->db->where('res_code',$reseavation_data->res_code);
						if ( ! $this->db->update('re_resevation', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
							$method='Transfer On Payment';
							insert_unrealizedsale($reseavation_data->prj_id,$reseavation_data->res_code,$reseavation_data->discounted_price,$lot_data->costof_sale,$unrealised_sale_re,$unrealized_cost_re,$date,$method,$reseavation_data->hm_discounted_price,$lot_data->housing_cost,$unrealised_sale_hm,$unrealized_cost_hm);
						insert_unrdata($reseavation_data->res_code,$id,'',$date,$realized_sale_re,$realized_cost_re,$method,$realized_sale_hm,$realized_cost_hm);
					
					
					
				}
				else
				{
					//inital cost transfer on stock to advance;
					
					if($initialized_mode=='Advance Payment')
					{
							if($reseavation_data->init_costtrn_status=='PENDING')
							{
								$drlist=NULL;
								$crlist=NULL;
							$ledgerset=get_account_set('Initial cost transfer');
							$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
							$crlist[0]['amount']=$crtot=$lot_data->costof_sale;
							$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
							$drlist[0]['amount']=$drtot=$lot_data->costof_sale;;
							
							$drtot=$lot_data->costof_sale;
							$narration = $reseavation_data->res_code.' Initial Transfer from first advance '  ;
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
							
							$insert_data=array('init_costtrn_status'=>'TRANSFERD','init_costtrn_date'=>$date);
							$this->db->where('res_code',$reseavation_data->res_code);
							if ( ! $this->db->update('re_resevation', $insert_data))
								{
									 $this->db->trans_rollback();
									 $this->messages->add('Error addding Entry.', 'error');
					
									 return;
								 } 
					
							$this->insert_pay_enties($id,$int_entry,'Initial Transfer from first advance');
						}
					}
					
				}
	}
	
	
	// sales transfer function on payment
	
function update_unrealized_sale_on_income($income_id,$amount,$res_code,$date)
{
	$reseavation_data=$this->get_resevation($res_code);
		 $unrealized_data=get_unrealized_data($res_code);
			   
		$uncost=get_account_set('Unrealized Cost');
		$unsale=get_account_set('Unrealized Sale');
		 if($unrealized_data){
			if($unrealized_data->status!='COMPLETE')
			 {
				// echo $res_code.'<br>';
				 $hm_full_sale=$unrealized_data->hm_full_sale;
				 $hm_full_cost=$unrealized_data->hm_full_cost;
				 $hm_un_cost_priv=$unrealized_data->hm_unrealized_cost;
				 $hm_un_sale_priv=$unrealized_data->hm_unrealized_sale;
				 $re_un_cost_priv=$unrealized_data->unrealized_cost;
				 $re_un_sale_priv=$unrealized_data->unrealized_sale;
				 $re_full_cost=$unrealized_data->full_cost;
				 $re_full_sale=$unrealized_data->full_sale-$hm_full_sale;
				 if($re_un_sale_priv>0)
				 {
					 if($re_un_sale_priv>=$amount)
					 {
					 $re_un_sale=$amount;
					 $hm_un_sale=0;
					 }
					 else
					 {
						  $re_un_sale=$re_un_sale_priv;
						 $newamount=$amount-$re_un_sale_priv;
							  if($hm_un_sale_priv >=$newamount)
					 	 		 $hm_un_sale=$newamount;
							 else
								  $hm_un_sale=$hm_un_sale_priv;
						  
						 
					 }
				 }
				 else
				 {
					 $re_un_sale=0;
					 if($hm_un_sale_priv >=$amount)
					 	 	$hm_un_sale=$amount;
					 else
							$hm_un_sale=$hm_un_sale_priv;
					
				 }
				 $re_un_cost=0; $hm_un_cost=0;
				 if($re_un_sale>0)
				 $re_un_cost=($re_un_sale/$re_full_sale)* $re_full_cost;
				 if( $hm_un_sale>0)
				 $hm_un_cost=($hm_un_sale/$hm_full_sale)* $hm_full_cost;
				 
				 
				 $re_new_uncost=$re_un_cost_priv-$re_un_cost;
				 $re_new_unsale=$re_un_sale_priv-$re_un_sale;
				 
				 $hm_new_uncost=$hm_un_cost_priv-$hm_un_cost;
				 $hm_new_unsale=$hm_un_sale_priv-$hm_un_sale;
				// echo $re_un_sale.'---'.$hm_un_sale;
				// exit;
				 //transfer unrealized cost -lands
				 if($re_un_cost>0)
				 {
					
				 }
				 if($re_un_sale>0)
				 {
					 
					 $ledgerset=get_account_set('Transfer Cost');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$re_un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$re_un_cost;
						$narration = $res_code.' Unrealized Cost Transfer on Payment';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Cost Transfer on Payment');
				//transfer unrealized Sale -lands
				
						$ledgerset=get_account_set('Transfer Sale');
						 $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$re_un_sale;
						$drlist[0]['ledgerid']=$unsale['Dr_account'];
						$drlist[0]['amount']=$drtot=$re_un_sale;
						$narration = $res_code.' Unrealized Sale on Payment ';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Sale on Payment ');
				 }
				 
				  if($hm_un_cost>0)
				 {
					
				 }
				 if($hm_un_sale>0)
				 {
				//transfer unrealized Sale -lands
						$unsale_hm=get_account_set('Unrealized Sale Hm');
						$ledgerset=get_account_set('Sale Transfer Hm');
						 $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$hm_un_sale;
						$drlist[0]['ledgerid']=$unsale_hm['Dr_account'];
						$drlist[0]['amount']=$drtot=$hm_un_sale;
						$narration = $res_code.' Unrealized Sale on Payment ';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Sale on Payment ');
						
						  //transfer unrealized cost -Housing
					$ledgerset=get_account_set('Cost Transfer Hm');
					$uncost=get_account_set('Unrealized Cost Hm');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$hm_un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$hm_un_cost;
						$narration = $res_code.' Unrealized Cost Transfer housing on Payment';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Cost Transfer on Payment');
				 }
				 
				 $new_unsale_tot= $hm_new_unsale+ $re_new_unsale;
						if($new_unsale_tot<=1)
						$status='COMPLETE';
						else 
						$status='PARTIAL';
						$insert_data = array(
							'last_incomeid' =>$income_id,
							'unrealized_sale' =>$re_new_unsale,
							'unrealized_cost' =>$re_new_uncost,
							'hm_unrealized_sale' =>$hm_new_unsale,
							'hm_unrealized_cost' =>$hm_new_uncost,
								'last_trndate' =>$date,
							'status' =>$status,
								);
					$this->db->where('res_code',$res_code);
				if ( ! $this->db->Update('re_unrealized', $insert_data))
				{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
				}
				insert_unrdata($reseavation_data->res_code,$income_id,'',date("Y-m-d"),$re_un_sale,$re_un_cost,'On Payment',$hm_un_sale,$hm_un_cost);
				
			}
					
	}
}
function update_unrealized_sale_on_reshedule($amount,$res_code)
{
	$reseavation_data=$this->get_resevation($res_code);
		 $unrealized_data=$this->get_unrealized_data($res_code);
		// echo $this->db->last_query();
			$date=date('Y-m-d');   
		$uncost=get_account_set('Unrealized Cost');
		$unsale=get_account_set('Unrealized Sale');
		//echo "call funtion  :" .$amount;
		 if($unrealized_data){
			if($unrealized_data->status!='COMPLETE')
			 {
				 $un_cost_priv=$unrealized_data->unrealized_cost;
				 $un_sale_priv=$unrealized_data->unrealized_sale;
				 $fullcost=$unrealized_data->full_cost;
				 $fullsale=$unrealized_data->full_sale;
				 $un_cost=($amount/$fullsale)* $fullcost;
				 $un_sale=$amount;
				 $new_uncost=$un_cost_priv-$un_cost;
				 $new_unsale=$un_sale_priv-$amount;
			// echo "into funcion :" .$amount;
				 //echo transfer unrealized cost
					$ledgerset=get_account_set('Transfer Cost');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$un_cost;
						$narration = $res_code.' Unrealized Cost Transfer  on Reshedule Credit Interest';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						//$this->insert_pay_enties($income_id,$int_entry,'Unrealized Cost Re-Transfer on Settlement');
						
				//transfer unrealized Sale
				$ledgerset=get_account_set('Transfer Sale');
						 $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$un_sale;
						$drlist[0]['ledgerid']=$unsale['Dr_account'];
						$drlist[0]['amount']=$drtot=$un_sale;
						$narration = $res_code.' Unrealized Sale Transfer  on Reshedule Credit Interest';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						//$this->insert_pay_enties($income_id,$int_entry,'Unrealized Sale Re-Transfer on Settlement');
						if($new_unsale<=1)
						$status='COMPLETE';
						else 
						$status='PARTIAL';
						$insert_data = array(
							'last_incomeid' =>'',
							'unrealized_sale' =>$new_unsale,
							'unrealized_cost' =>$new_uncost,
								'last_trndate' =>date("Y-m-d"),
							'status' =>$status,
								);
			$this->db->where('res_code',$res_code);
				if ( ! $this->db->Update('re_unrealized', $insert_data))
				{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
				}
				insert_unrdata($reseavation_data->res_code,'','',date("Y-m-d"),$un_sale,$un_cost,'On Reschedule');
			}
					
	}
}	
//this fuction used to adjest profit transfer cost amount after discount
function update_unrealized_data_on_discount($res_code,$discount_recieved,$entry_id,$date,$hm_discount)
	{
		$reseavation_data=$this->get_resevation($res_code);
		$unrealized_data=get_unrealized_data($res_code);
		$this->load->model("accountinterface_model");
		if($reseavation_data->profit_status=='TRANSFERD')
		{
			//calculate discount portion of land sale
			
			
			
		 		$re_discount=$discount_recieved-$hm_discount;
				$amount=$discount_recieved;
					
				 $un_cost_priv=$unrealized_data->unrealized_cost;
				 $un_sale_priv=$unrealized_data->unrealized_sale;
				 $hm_un_cost_priv=$unrealized_data->hm_unrealized_cost;
				 $hm_un_sale_priv=$unrealized_data->hm_unrealized_sale;
				
				 $fullcost=$unrealized_data->full_cost;
				 $fullsale=$unrealized_data->full_sale;
				 
				 if($un_sale_priv < $re_discount)
				 {
				 $re_discount=$un_sale_priv;
				 $hm_discount=$discount_recieved-$re_discount;
				 }
			
			$unsale=get_account_set('Unrealized Sale');
			$unsale_hm=get_account_set('Unrealized Sale Hm');
			$ledgerset=get_account_set('Advance Payment After Profit');
			$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
			$crlist[0]['amount']=$crtot=$discount_recieved;
			$drlist[0]['ledgerid']=$unsale['Cr_account'];
			$drlist[0]['amount']=$drtot=$re_discount;
			$drlist[1]['ledgerid']=$unsale_hm['Cr_account'];
			$drlist[1]['amount']=$drtot=$hm_discount;
			$narration = $res_code.'Reduce Discount Amount ';
			$drtot=$crtot=$discount_recieved;
			$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
			$this->insert_pay_enties($entry_id,$int_entry,'Reduce Discount Amount');
			$drlist=NULL;
			$crlist=NULL;
				
				
				
				
				 // calculate land sale value and land sale cost value
				 $hm_full_sale=$unrealized_data->hm_full_sale;
				 $hm_full_cost=$unrealized_data->hm_full_cost;
				 $re_full_sale=$fullsale- $hm_full_sale;
				 $re_full_cost=$fullcost;
				 
				 //calculate discount portion of land sale
				  $new_uncost_hm=$hm_un_cost_priv;
				  $new_unsale_hm=$hm_un_sale_priv;
				  $new_uncost_re=$un_cost_priv;
				  $new_unsale_re=$un_sale_priv;
				  $hm_un_sale=0;$hm_un_cost=0;
				 if($re_discount>0)
				 {
					 $un_cost=($re_discount/$re_full_sale)* $re_full_cost;
					 $un_sale=$re_discount;
					  //calculate real estete unrealized new value
					 $new_uncost_re=$un_cost_priv-$un_cost;
					 $new_unsale_re=$un_sale_priv-$re_discount;
					 
					 
						$ledgerset=get_account_set('Transfer Cost');
						$uncost=get_account_set('Unrealized Cost');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$un_cost;
						$narration = $res_code.' Unrealized Cost Transfer on Discount';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($entry_id,$int_entry,'Unrealized Cost Transfer on Discount');
				 }
				 if( $hm_discount>0)
				 {
					 $hm_un_cost=($hm_discount/$hm_full_sale)* $hm_full_cost;
				 	 $hm_un_sale=$hm_discount;
					   //calculate Homes  unrealized new value
					  $new_uncost_hm=$hm_un_cost_priv-$hm_un_cost;
					  $new_unsale_hm=$hm_un_sale_priv-$hm_discount;
					  
					  $ledgerset=get_account_set('Cost Transfer Hm');
						$uncost=get_account_set('Unrealized Cost Hm');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$hm_un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$hm_un_cost;
						$narration = $res_code.' Unrealized Cost Transfer on Discount';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($entry_id,$int_entry,'Unrealized Cost Transfer on Discount');
					  
					  
				 }
				
				
				 
				 //transfer unrealized cost
				
						$tot_new_unsale=$new_unsale_re+$new_unsale_hm;
						if($tot_new_unsale<=1)
						$status='COMPLETE';
						else 
						$status='PARTIAL';
						$insert_data = array(
							'last_incomeid' =>$entry_id,
							'unrealized_sale' =>$new_unsale_re,
							'unrealized_cost' =>$new_uncost_re,
							'hm_unrealized_cost' =>$new_uncost_hm,
							'hm_unrealized_sale' =>$new_unsale_hm,
							'last_trndate' =>date("Y-m-d"),
							'status' =>$status,
								);
							$this->db->where('res_code',$res_code);
							if ( ! $this->db->Update('re_unrealized', $insert_data))
							{
							$this->db->trans_rollback();
							$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
						
							return false;
							}
							insert_unrdata($reseavation_data->res_code,$entry_id,'',$date,$un_sale,$un_cost,'On Discount',$hm_un_sale,$hm_un_cost);
							
								
		}
		
	}
	
	
	function advance_resale_transfers($rsch_code)
	{
		
		$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
		$reschdata=$this->reservation_model->get_resale_bycode($rsch_code);
		$resdata=$this->get_resevation($reschdata->res_code);
		$res_code=$reschdata->res_code;
		$amount=$reschdata->repay_total;
		
		
			if($resdata->profit_status!='PENDING')
			{
							
						$this->sale_and_cost_reversal($res_code,$resdata->down_payment,'Advance','');
				

			}
			else
			{
				$paymentledge=get_account_set('Advanced Payment');
				$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
				$balanceint=$reschdata->down_payment ;
				$crlist[0]['ledgerid']=$crledger['Cr_account'];
				$crlist[0]['amount']=$crtot=$balanceint;
				$drlist[0]['ledgerid']=$paymentledge['Cr_account'];
				$drlist[0]['amount']=$drtot=$balanceint;
				$narration = $reschdata->res_code.' Advance Sale Reversal '  ;
				$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
				
			}
			$nonpayamount=floatval($reschdata->down_payment)-floatval($reschdata->repay_total);
			$this->none_refundable_income_transfer($nonpayamount,$reschdata->res_code,$resdata->prj_id,$resdata->lot_id);
		
			
	}
	
	//nonerefundable income transfre on resle
	function none_refundable_income_transfer($nonpayamount,$res_code,$prj_id,$lot_id)
	{
		
			$drlist=NULL;
			$crlist=NULL;
			$incomleddger=get_account_set('Block Resale Income');
			$crlist[0]['ledgerid']=$incomleddger['Cr_account'];
			$crlist[0]['amount']=$crtot=$nonpayamount;
			$drlist[0]['ledgerid']=$incomleddger['Dr_account'];
			$drlist[0]['amount']=$drtot=$nonpayamount;
			$narration = $res_code.' Non Refundable amount transfer on resale '  ;
			$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$prj_id,$lot_id,$res_code);
	}
	//sale and cost reversal function on resale
	function sale_and_cost_reversal($res_code,$pay_total,$type,$loan_type)
	{
		$drlist=NULL;
		$crlist=NULL;
		
		$nonrealized_capital=0;
					$resdata=$this->get_resevation($res_code);
					$undata=get_unrealized_data($res_code);
					$outright_profitmode=profit_outright_method();//companyconfig helper function
					$loan_profitmode=profit_agreement_method();//companyconfig helper function
					if($type=='Advance')
					{
						if($outright_profitmode==1)
						$pay_total=$resdata->discounted_price;
					}
					
					if($undata)
					{
						$unsalevalue_re=$undata->unrealized_sale;	
						$unsalevalue_hm=$undata->hm_unrealized_sale;	
						$unrealized_cost=$undata->unrealized_cost;
						$hm_unrealized_cost=$undata->hm_unrealized_cost;
						$realiszed_sale_hous=$undata->hm_full_sale-$unsalevalue_hm;
						if($realiszed_sale_hous<0)
						$realiszed_sale_hous=0;
						$discounted_price_re=$resdata->discounted_price-$undata->hm_full_sale;
						
						$realiszed_sale_re=$discounted_price_re-$unsalevalue_re;
						if($realiszed_sale_re<0)
						$realiszed_sale_re=0;
						if($type=='Loan')
						{
							$nonrealized_capital=$pay_total-($realiszed_sale_re+$realiszed_sale_hous);
						}
						//$undata->unrealized_sale
					}
					else
					{
						$unsalevalue_re=0;	
						$unsalevalue_hm=0;	
						$unrealized_cost=0;
						$hm_unrealized_cost=0;
						$realiszed_sale_hous=0;
						$realiszed_sale_re=0;
						
						
					}
					$pay_total=$realiszed_sale_re+$realiszed_sale_hous;
					$uncost=get_account_set('Unrealized Cost');
					$unsale=get_account_set('Unrealized Sale');
					
					$lot_data=$this->get_lotdata($resdata->lot_id);
					
				//	echo $pay_total;
				//	exit;
					// transfer sale reversal 
					if($pay_total>0)// if unrealized sale value available 
					{
						$ledgerset_hm=get_account_set('Sale Transfer Hm');
						$ledgerset=get_account_set('Ep Reprocess Sale Revesal');
						$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$pay_total;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$pay_total-$realiszed_sale_hous;
						if($realiszed_sale_hous>0)
						{
						$drlist[1]['ledgerid']=$ledgerset_hm['Cr_account'];
						$drlist[1]['amount']=$drtot=$realiszed_sale_hous;
						}
						$drtot=$pay_total;
						$narration = $resdata->res_code.'  sale Trasnfer reversal on resale '  ;
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
						$drlist=NULL;
						$crlist=NULL;
							// balance amount reversal
								if($type=='Advance')
								{
										$ledgerset=get_account_set('Advance Payment After Profit');
										$draccount=$ledgerset['Cr_account'];
								}
								else
								{
									if($loan_type=='NEP'){
										$ledgerset=get_account_set('EP creation');
										$draccount=$ledgerset['Dr_account'];
									}
									if($loan_type=='EPB'){
										$ledgerset=get_account_set('EPB Creation');
										$draccount=$ledgerset['Dr_account'];
									}
									if($loan_type=='ZEP'){
										$ledgerset=get_account_set('ZEP Creation');
										$draccount=$ledgerset['Dr_account'];
									}
								}
								$drlist=NULL;
								$crlist=NULL;
								$unsale_hm=get_account_set('Unrealized Sale Hm');
								$balance_total=$unsalevalue_re+$unsalevalue_hm;
								if($balance_total>0)
								{
									//$unsalevalue=$undata->unrealized_sale;
									$crlist[0]['ledgerid']=$draccount;
									$crlist[0]['amount']=$crtot=$balance_total;
									$drlist[0]['ledgerid']=$unsale['Cr_account'];
									$drlist[0]['amount']=$drtot=$unsalevalue_re;
									if($unsalevalue_hm>0)
									{
										$drlist[1]['ledgerid']=$unsale_hm['Cr_account'];
										$drlist[1]['amount']=$drtot=$unsalevalue_hm;
									}
									$drtot=$crtot=$balance_total;
									$narration = $resdata->res_code.' Unrialized Sale  Trasnfer reversal on resale'  ;
									$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
								}
								//Real estate Cost Transfer  reversal
								$ledgerset=get_account_set('Transfer Cost');
							$drlist=NULL;
							$crlist=NULL;
								//$unrealized_cost=$undata->unrealized_cost;
								$realized_cost=$lot_data->costof_sale -$unrealized_cost ;
								$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
								$drlist[0]['amount']=$crtot=$lot_data->costof_sale;
								$crlist[0]['ledgerid']=$ledgerset['Dr_account'];
								$crlist[0]['amount']=$drtot=$realized_cost;
								$crlist[1]['ledgerid']=$uncost['Dr_account'];
								$crlist[1]['amount']=$drtot=$unrealized_cost;
								$drtot=$lot_data->costof_sale;
								$narration = $resdata->res_code.' Cost  Trasnfer  reversal on resale Lands '  ;
								$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);		
								//Housing Cost Transfer  reversal
								
								$drlist=NULL;
								$crlist=NULL;
								if($lot_data->housing_cost>0)
								{
									$ledgerset=get_account_set('Cost Transfer Hm');
									$uncost=get_account_set('Unrealized Cost Hm');
									//$hm_unrealized_cost=$undata->hm_unrealized_cost;
									$realized_cost=$lot_data->housing_cost -$hm_unrealized_cost ;
									$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
									$drlist[0]['amount']=$crtot=$lot_data->housing_cost;
									$crlist[0]['ledgerid']=$ledgerset['Dr_account'];
									$crlist[0]['amount']=$drtot=$realized_cost;
									$crlist[1]['ledgerid']=$uncost['Dr_account'];
									$crlist[1]['amount']=$drtot=$hm_unrealized_cost;
									$drtot=$lot_data->housing_cost;
									$narration = $resdata->res_code.' Cost  Trasnfer  reversal on resale Housing '  ;
									$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);		
								}
								
								$status='COMPLETE';
						
								$insert_data = array(
									'last_trndate' =>date("Y-m-d"),
									'method'=>'Complete on Resale',
								'status' =>$status,
									);
								$this->db->where('res_code',$resdata->res_code);
								if ( ! $this->db->Update('re_unrealized', $insert_data))
								{
								$this->db->trans_rollback();
								$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
							
								return false;
								}
					}
					return $nonrealized_capital;
							
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
	function early_settlement_entries($id,$loan_code,$res_code,$date)
	{
		$loandata=$this->eploan_model->get_eploan_data($loan_code);
		$reseavation_data=$this->get_resevation($res_code);
		 if($loandata->loan_type!='EPB')
				  $ledgerset=get_account_set('EP Interest');
				  else
				   $ledgerset=get_account_set('EPB Interest');
			$bal_entry=0;
			$int_entry=0;
				 
			//  echo $id;
				  $data=$this->get_loan_settlement_details($id);
				   if($data)
					{
						
						if($loandata->loan_type=='ZEP'){
							$ledgerset_loanaccount=get_account_set('ZEP Rental');
							$loan_stockaccount=get_account_set('ZEP Creation');
				
						}
						if($loandata->loan_type=='EPB'){
							$ledgerset_loanaccount=get_account_set('EPB Rental');
							$loan_stockaccount=get_account_set('EPB Creation');
				
						}
						if($loandata->loan_type=='NEP'){
							$ledgerset_loanaccount=get_account_set('EP Rental');
							$loan_stockaccount=get_account_set('EP creation');
				
						}

						$newdiscount=$data->new_discount;
						//finacial transaction of aditional discount
						if($newdiscount!=0)
						{
							$ledgerset_discount=get_account_set('New Discount Rebate');
							if($newdiscount>0){
								$crlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
								$drlist[0]['ledgerid']=$ledgerset_discount['Dr_account'];
							}
							if($newdiscount<0){
								$crlist[0]['ledgerid']=$ledgerset_discount['Dr_account'];
								$drlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
								
								$newdiscount=$newdiscount*(-1);

							}
						
							$crlist[0]['amount']=$crtot=$newdiscount;
							$drlist[0]['amount']=$drtot=$newdiscount;
							$narration = $res_code.'Aditional Discount on settlement';
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
							$this->insert_pay_enties($id,$int_entry,'Aditional Discount on settlement');
						}
						
						
						$totint=$data->int_paidamount;
						$loancode=$loandata->loan_code;
						if($totint>0){
						$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$totint;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$totint;
						$narration = $res_code.' EP Loan Interest Payment  On Settlement';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($id,$int_entry,'EP Interest');
					
						}
						$bal_entry=0;
						$balint=$data->int_release;
						 if($loandata->loan_type=='NEP'){
						if($balint>0){
							//full interest potrion transfer to loan debter account on early settlement
							// therefor balance interst portion deduct form loan debeter account
						$ledgerset=get_account_set('EP Reschedule Balance Int');
						$crlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
						$crlist[0]['amount']=$crtot=$balint;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$balint;
						$narration = $res_code.' EP Balance Interest Transfer On Settlement';
						$bal_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($id,$bal_entry,'EP Balance Interest');
						
						}
					}
					//future interest transfre to debtor account
					$cap_entry=NULL;$interest_entry=NULL;
					$futureint=$this->get_not_transferd_interest_on_settlement($loan_code);
					if($futureint>0)
					{
						$ledgerset=get_account_set('EP Creation Interest');
						$crlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$crlist[0]['amount']=$crtot=$futureint;
						$drlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
						$drlist[0]['amount']=$drtot=$futureint;
						$narration = $res_code.' Transfer Future Interest On Settlement';
						$interest_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($id,$interest_entry,'Transfer Future Interest');
					}
					//future Capital transfre to debtor account
					$drlist=NULL;
					$crlist=NULL;
					$futurecap=$this->get_not_transferd_capital_on_settlement($loan_code);
					if($futurecap>0)
					{
						$ledgerset=get_account_set('EP Creation Interest');
						$crlist[0]['ledgerid']=$loan_stockaccount['Dr_account'];
						$crlist[0]['amount']=$crtot=$futurecap;
						$drlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
						$drlist[0]['amount']=$drtot=$futurecap;
						$narration = $res_code.' Transfer Future Capital On Settlement';
						$cap_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($id,$cap_entry,'Transfer Future Capital');
					}
					$this->update_capital_and_interest_transfers_on_settlement($loan_code,$cap_entry,$interest_entry);
					//loan_stockaccount
					
					$insert_data = array(
							'paid_intentry'=>$int_entry,
							'balanint_enty'=>$bal_entry,
							);
							$this->db->where('rct_id',$id);
							if ( ! $this->db->update('re_eprebate', $insert_data))
							{
						 	 $this->db->trans_rollback();
							 $this->messages->add('Error addding Entry.', 'error');
		  
							 return;
							 }
					}
	}
	function get_not_transferd_capital_on_settlement($loancode)
	{
		$this->db->select('SUM(re_eploanshedule.cap_amount) as tot_cap');
		$this->db->where('loan_code',$loancode);
		$this->db->where('cap_entry',NULL);
		$query = $this->db->get('re_eploanshedule'); 
		echo $this->db->last_query();
		if ($query->num_rows() > 0){
			
		$data= $query->row();
		return  $data->tot_cap;
		}
		else
		return 0;
	}
	function get_not_transferd_interest_on_settlement($loancode)
	{
		$this->db->select('SUM(re_eploanshedule.int_amount) as tot_int');
		$this->db->where('loan_code',$loancode);
		$this->db->where('cap_entry',NULL);
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $data->tot_int;
		}
		else
		return 0;
	}
	
	function update_capital_and_interest_transfers_on_settlement($loancode,$cap_entry,$int_entry)
	{
		
		$dataset=array('cap_entry'=>$cap_entry);
		$this->db->where('loan_code',$loancode);
		$this->db->where('cap_entry',NULL);
		 $this->db->update('re_eploanshedule',$dataset); 
		$dataset=NULL;
		$dataset=array('int_entry'=>$int_entry);
		$this->db->where('loan_code',$loancode);
		$this->db->where('int_entry',NULL);
		$this->db->update('re_eploanshedule',$dataset); 
		
	}
	function delete_futrecapital_and_int_transfers_on_settlment($id,$loancode)
	{
		
		
		$cap_entry=$this->get_payment_entires_id_type($id,'Transfer Future Capital');
		$dataset=NULL;
		$dataset=array('cap_entry'=>NULL);
		$this->db->where('loan_code',$loancode);
		$this->db->where('cap_entry',$cap_entry);
		$this->db->update('re_eploanshedule',$dataset); 
		$dataset=NULL;
		
		$int_entry=$this->get_payment_entires_id_type($id,'Transfer Future Interest');
		$dataset1=array('int_entry'=>NULL);
		$this->db->where('loan_code',$loancode);
		$this->db->where('int_entry',$int_entry);
		$this->db->update('re_eploanshedule',$dataset1); 
		
	}
	function get_payment_entires_id_type($id,$type)
	{
		$this->db->select('*');
		$this->db->where('pay_id',$id);
		$this->db->where('type',$type);
		$query = $this->db->get('re_paymententries'); 
		if ($query->num_rows() > 0){
		$data=$query->row(); 
		return $data->entry_id;
		}
		else
		return NULL;
   
	
	}
	//loan resale account transfers
	function loan_resale_transfers($rsch_code)
	{
		
		$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
		$reschdata=$this->eploan_model->get_resale_bycode($rsch_code);
		$loandata=$this->eploan_model->get_eploan_data($reschdata->loan_code);
		$res_code=$loandata->res_code;
		$resdata=$this->get_resevation($res_code);
		$amount=$reschdata->repay_total;
		$refundledhger=$crledger['Cr_account'];
		
		if($loandata->loan_type=='ZEP'){
			$loanledgerset=$this->accountinterface_model->get_account_set('ZEP Rental');
			$craccount=$loanledgerset['Cr_account'];
			$loan_stockaccount=get_account_set('ZEP Creation');
		}
		if($loandata->loan_type=='EPB'){
			$loanledgerset=$this->accountinterface_model->get_account_set('EPB Rental');
			$craccount=$loanledgerset['Cr_account'];
			$loan_stockaccount=get_account_set('EPB Creation');
		}
		if($loandata->loan_type=='NEP'){
			$loanledgerset=$this->accountinterface_model->get_account_set('EP Rental');
			$craccount=$loanledgerset['Cr_account'];
			$loan_stockaccount=get_account_set('EP creation');
		}
		$paid_total=$reschdata->paid_capital+$reschdata->down_payment;
		//cost and sale reversal function
		$nonrealized_capital=$this->sale_and_cost_reversal($res_code,$paid_total,'Loan',$loandata->loan_type);
		
	//	exit;
		
		if($loandata->loan_type!='EPB')
		{
					$ledgerset=get_account_set('EP Reschedule Balance Int');
					$balanceint=$reschdata->balance_int;
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$balanceint;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$balanceint;
					$narration = $reschdata->loan_code.' EP Resale  Balance Int  Reversal '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
					if($reschdata->repay_int>0)
					{
							$ledgerset=get_account_set('EP Interest');
							$balanceint=$reschdata->repay_int;
							$crledgerset=get_account_set('Ep Reprocess Sale Revesal');
							$crlist[0]['ledgerid']=$refundledhger;
							$crlist[0]['amount']=$crtot=$balanceint;
							$drlist[0]['ledgerid']=$ledgerset['Cr_account'];
							$drlist[0]['amount']=$drtot=$balanceint;
							$narration = $reschdata->loan_code.' EP Resale Repay Interest Reversal  '  ;
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);

					}
		}
		
		
		if($reschdata->credit_int>0)
		{
			$ledgersetCr=get_account_set('EP Reprocess Pay Capital Reversal');
			$ledgersetDr=get_account_set('EP Creation Interest');
			$credit_int=$reschdata->credit_int;
			$crlist[0]['ledgerid']=$ledgersetCr['Cr_account'];
			$crlist[0]['amount']=$crtot=$credit_int;
			$drlist[0]['ledgerid']=$craccount;
			$drlist[0]['amount']=$drtot=$credit_int;
			$narration = $reschdata->loan_code.' EP Reprocess Credit Interest and not realized capital Reversal '  ;
			$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
		}
		
		if($nonrealized_capital>0)
		{
			$ledgersetCr=get_account_set('EP Reprocess Pay Capital Reversal');
		
			$credit_int=$nonrealized_capital;
			$crlist[0]['ledgerid']=$ledgersetCr['Cr_account'];
			$crlist[0]['amount']=$crtot=$credit_int;
			$drlist[0]['ledgerid']=$loan_stockaccount['Dr_account'];
			$drlist[0]['amount']=$drtot=$credit_int;
			$narration = $reschdata->loan_code.' EP Reprocess  none-realized capital Reversal '  ;
			$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
		}
						
		$nonrefund=round(($reschdata->paid_capital+$reschdata->down_payment+$reschdata->credit_int)- $reschdata->repay_capital,2);
				if($reschdata->arrears_int>0){
						$nonrefund=$nonrefund-$reschdata->arrears_int;
						
									$crlist=NULL;
									$drlist=NULL;
									$incomleddger=get_account_set('Block Resale Income');
									$ledgerset=get_account_set('EP Interest');
										$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
										$crlist[0]['amount']=$crtot=$reschdata->arrears_int;
										$drlist[0]['ledgerid']=$incomleddger['Dr_account'];
										$drlist[0]['amount']=$drtot=$reschdata->arrears_int;
										$narration = $reschdata->loan_code.' EP  Resale  Arrears Interest Income  '  ;
										$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
										$ledgerset=get_account_set('EP Creation Interest');
										$crlist[0]['ledgerid']=$craccount;
										$crlist[0]['amount']=$crtot=$reschdata->arrears_int;
										$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
										$drlist[0]['amount']=$drtot=$reschdata->arrears_int;
										$narration = $reschdata->loan_code.' EP  Arrears Interest Reversal  on resale  '  ;
										$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
							insert_change_transactions($int_entry,'',$loandata->loan_code,$loandata->prj_id,$loandata->lot_id,date('Y-m-d'),'Resale Arrears Int');
										
										
					}
					if($reschdata->delay_int>0){
							$nonrefund=$nonrefund-$reschdata->delay_int;
							$incomleddger=get_account_set('Block Resale Income');
							$ledgerset=get_account_set('Delay Interest');
							$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
							$crlist[0]['amount']=$crtot=$reschdata->delay_int;
							$drlist[0]['ledgerid']=$incomleddger['Dr_account'];
							$drlist[0]['amount']=$drtot=$reschdata->delay_int;
							$narration = $reschdata->loan_code.' EP  Resale Delay Interest  Income  '  ;
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
							insert_change_transactions($int_entry,'',$loandata->loan_code,$loandata->prj_id,$loandata->lot_id,date('Y-m-d'),'Resale Arrears Int');

					}
					if($nonrefund>0)
					{
							$this->none_refundable_income_transfer($nonrefund,$reschdata->res_code,$resdata->prj_id,$resdata->lot_id);
					}
					
					$aarrcapital=$this->eploan_model->uptodate_arrears_capital($loandata->loan_code,date("Y-m-d"));
					if($aarrcapital>0)
					{
							$crlist[0]['ledgerid']=$craccount;
							$crlist[0]['amount']=$crtot=$aarrcapital;
							$drlist[0]['ledgerid']=$loan_stockaccount['Dr_account'];
							$drlist[0]['amount']=$drtot=$aarrcapital;
							$narration = $reschdata->loan_code.' EP  Arrears Capital Reversal  on resale  '  ;
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
						
						
					}
					if($aarrcapital<0)
					{
						$creditcap=(-1)*$aarrcapital;
						$crlist[0]['ledgerid']=$loan_stockaccount['Dr_account'];
							$crlist[0]['amount']=$crtot=$creditcap;
							$drlist[0]['ledgerid']=$craccount;
							$drlist[0]['amount']=$drtot=$creditcap;
							$narration = $reschdata->loan_code.' EP  Credit Capital Reversal  on resale  '  ;
							$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$loandata->prj_id,$loandata->lot_id,$loandata->res_code);
							insert_change_transactions($int_entry,'',$loandata->loan_code,$loandata->prj_id,$loandata->lot_id,date('Y-m-d'),'Resale Arrears Int');
					}
					
					

		
			
		
		
			
	}
	
	
	//loan Rechsedule account transfers
	function reschedule_account_transfers($rsch_code)
	{
		$reschdata=$this->eploan_model->get_reschedule_data($rsch_code);
		$eploannedata=$this->eploan_model->get_eploan_data($reschdata->loan_code);

		$aarrcapital=$this->eploan_model->uptodate_arrears_capital($eploannedata->loan_code,date("Y-m-d"));
		$deu_data=get_deu_data($eploannedata->loan_code,date("Y-m-d"),$eploannedata->loan_type,$eploannedata->reschdue_sqn);
		$paiddata= loan_inquary_paid_totals($eploannedata->loan_code,date("Y-m-d"),$eploannedata->reschdue_sqn);
		$aarrcapital= $deu_data['due_cap']-$paiddata['paid_cap'];
		$arr_int= $deu_data['due_int']-$paiddata['paid_int'];
		$ptype = $reschdata->new_type; //keep the reference for ZEPCs

		if($ptype == 'ZEPC'){
			$paytype='ZEP';
		}else{
			$paytype=$ptype;
		}
		
		
			if($reschdata->prev_type=='ZEP'){
			$ledgersetDr=get_account_set('ZEP Rental');
			$ledgersetCR=get_account_set('ZEP Creation');
			}
			if($reschdata->prev_type=='EPB'){
			$ledgersetDr=get_account_set('EPB Rental');
			$ledgersetCR=get_account_set('EPB Creation');
			
			}
			if($reschdata->prev_type=='NEP'){
				$ledgersetDr=get_account_set('EP Rental');
				$ledgersetCR=get_account_set('EP creation');
			}
			if($aarrcapital>0)
			{
				
				
							
								$capamount=$aarrcapital;
						
						
						
								$crlist[0]['ledgerid']=$ledgersetDr['Cr_account'];
								$crlist[0]['amount']=$crtot=$capamount;
								$drlist[0]['ledgerid']=$ledgersetCR['Dr_account'];
								$drlist[0]['amount']=$drtot=$capamount;
								$narration = $eploannedata->loan_code.' EP Loan Relsale Arrears Capital Transfer  Ep Stock '  ;
								$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);	
			}
			if($arr_int>0)
			{
				
				
							
								$capamount=$aarrcapital;
						
								$ledgerset_int=get_account_set('EP Reschedule New Int');
						
								$crlist[0]['ledgerid']=$ledgersetDr['Cr_account'];
								$crlist[0]['amount']=$crtot=$arr_int;
								$drlist[0]['ledgerid']=$ledgerset_int['Dr_account'];
								$drlist[0]['amount']=$drtot=$arr_int;
								$narration = $eploannedata->loan_code.' EP Loan Relsale Arrears Intesest Transfer  Unrealizes int '  ;
								$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);	
			}
			if($reschdata->loan_paidcrint>0)
			{
				// credit total should trnasfer form debtor account to stock account
				$creditcap=0;
				if($aarrcapital<0)
				$creditcap=(-1)*$aarrcapital;//calculate credit capital
				$total=$creditcap+$reschdata->loan_paidcrint;
				$ledgerset=get_account_set('EP creation');
				$craccount=$ledgerset['Dr_account'];
				$amount=$reschdata->loan_paidcrint;
					$crlist[0]['ledgerid']=$ledgersetCR['Dr_account'];
					$crlist[0]['amount']=$crtot=$total;
					$drlist[0]['ledgerid']=$ledgersetDr['Cr_account'];
					$drlist[0]['amount']=$drtot=$total;
					$narration = $reschdata->loan_code.' Rechedule Credit Rental  Trasnfer  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);
					$loan_profitmode=profit_agreement_method();//companyconfig helper function
					if($loan_profitmode==2)//acctual basic profit transfer mode
					{
					//credit interest take as a capital payment and income tranfer agains to the capital payment
					update_unrealized_sale_on_income(0,$amount,$eploannedata->res_code,date("Y-m-d"));
					}
					 
					
			}
			
			if($paytype=='NEP'){
					$ledgerset=get_account_set('EP Reschedule Balance Int');
					$balanceint=$reschdata->loan_stinttot-$reschdata->loan_paidint-$reschdata->loan_paidcrint;
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$balanceint;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$balanceint;
					$narration = $reschdata->loan_code.' EP Reschedule Balance Int  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);
				
					$ledgerset=get_account_set('EP Reschedule New Int');
					$balanceint=$reschdata->new_totint;
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$balanceint;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$balanceint;
					$narration = $reschdata->loan_code.' EP Reschedule New Int '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);
			
			}
			
				if($paytype=='ZEP'){
				$ledgerset1=get_account_set('ZEP Creation');
				$draccount=$ledgerset1['Dr_account'];
				}
				if($paytype=='EPB'){
				$ledgerset1=get_account_set('EPB Creation');
				$draccount=$ledgerset1['Dr_account'];
				}
				if($paytype=='NEP'){
				$ledgerset1=get_account_set('EP creation');
				$draccount=$ledgerset1['Dr_account'];
				}
				if($reschdata->prev_type=='ZEP'){
				$ledgerset=get_account_set('ZEP Creation');
				$craccount=$ledgerset['Dr_account'];
				}
				if($reschdata->prev_type=='EPB'){
				$ledgerset=get_account_set('EPB Creation');
				$craccount=$ledgerset['Dr_account'];
				}
				if($reschdata->prev_type=='NEP'){
				$ledgerset=get_account_set('EP creation');
				$craccount=$ledgerset['Dr_account'];
				}
					$crlist[0]['ledgerid']=$craccount;
					$crlist[0]['amount']=$crtot=$reschdata->new_cap;
					$drlist[0]['ledgerid']=$draccount;
					$drlist[0]['amount']=$drtot=$reschdata->new_cap;
					$narration = $reschdata->loan_code.' Rechedule sale  Trasnfer  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);
			
			
			
			if($reschdata->di_amount>0)
			{
				 
				$intincome=get_account_set('Delay Interest');
				$balanceint=$reschdata->new_totint;
				$crlist[0]['ledgerid']=$intincome['Cr_account'];
				$crlist[0]['amount']=$crtot=$reschdata->di_amount;
				$drlist[0]['ledgerid']=$ledgersetCR['Dr_account'];
				$drlist[0]['amount']=$drtot=$reschdata->di_amount;
				$narration = $reschdata->loan_code.' EP Delay Interest Transfer to Income  on reschedule'  ;
				$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);
		//	insert_oumit_transactions($int_entry,'',$reschdata->loan_code,$eploannedata->prj_id,$eploannedata->lot_id,date('Y-m-d'),'Reshedule New Int');

			}
			if($reschdata->arrears_int>0)
			{
				 
				$intincome=get_account_set('EP Interest');
				$balanceint=$reschdata->new_totint;
				$crlist[0]['ledgerid']=$intincome['Cr_account'];
				$crlist[0]['amount']=$crtot=$reschdata->arrears_int;
				$drlist[0]['ledgerid']=$ledgersetCR['Dr_account'];
				$drlist[0]['amount']=$drtot=$reschdata->arrears_int;
				$narration = $reschdata->loan_code.' EP Arrears  Interest  Transfer to Income on reschedule'  ;
				$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$eploannedata->prj_id,$eploannedata->lot_id,$eploannedata->res_code);
		//	insert_oumit_transactions($int_entry,'',$reschdata->loan_code,$eploannedata->prj_id,$eploannedata->lot_id,date('Y-m-d'),'Reshedule New Int');

			}
			
			
			
	}
	function get_today_int_transfer_list($date) { //get all stock
		$this->db->select('re_eploanshedule.*,re_eploan.loan_type,re_eploan.res_code,re_eploan.reschdue_sqn as currentsq');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
		$this->db->where('re_eploanshedule.deu_date',$date);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function capital_and_interest_transfer_onduedate($date)
	{
		$intledgerset=get_account_set('EP Creation Interest');
		$intledger=$intledgerset['Dr_account'];
		$dataset=$this->get_today_int_transfer_list($date);
		if($dataset)
		{
			foreach($dataset as $raw)
			{
				if(intval($raw->currentsq)==intval($raw->reschdue_sqn))//check current reshedule sequwnce
				{
					if($raw->loan_type=='ZEP'){
					$ledgersetDr=get_account_set('ZEP Rental');
					$ledgersetCR=get_account_set('ZEP Creation');
					}
					if($raw->loan_type=='EPB'){
					$ledgersetDr=get_account_set('EPB Rental');
					$ledgersetCR=get_account_set('EPB Creation');
					
					}
					if($raw->loan_type=='NEP'){
						$ledgersetDr=get_account_set('EP Rental');
						$ledgersetCR=get_account_set('EP creation');
					}
					$totalrental=$raw->cap_amount+$raw->int_amount;
					$flag=true;
					if($raw->cap_entry)
					$flag=false;
					if($flag)
					{
							$reseavation_data=$this->get_resevation($raw->res_code);
							$crlist[0]['ledgerid']=$ledgersetCR['Dr_account']; //stock account
							$crlist[0]['amount']=$crtot=$raw->cap_amount;
							$crlist[1]['ledgerid']=$intledger;					// unrealized interest account
							$crlist[1]['amount']=$crtot=$raw->int_amount;
							$drlist[0]['ledgerid']=$ledgersetDr['Cr_account'];//debtor account
							$drlist[0]['amount']=$drtot=$totalrental;
							$crtot=$drtot=$totalrental;
							$narration = $raw->res_code.' Transfer Today Capital and interest';
							$cap_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
							
							// update eploan shedule table
							$dataset1=array('int_entry'=>$cap_entry,'cap_entry'=>$cap_entry);
							$this->db->where('id',$raw->id);
						
							$this->db->update('re_eploanshedule',$dataset1); 
					}
				}
				
			}
		}
		
	}
	function get_inital_int_transfer_list($date,$res_code) { //get all stock
		$this->db->select('re_eploanshedule.*,re_eploan.loan_type,re_eploan.res_code');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
		$this->db->where('re_eploanshedule.deu_date <=',$date);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->where('re_eploan.res_code',$res_code);
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function capital_and_interest_transfer_on_startloan($date,$res_code)
	{
		$intledgerset=get_account_set('EP Creation Interest');
		$intledger=$intledgerset['Dr_account'];
		$dataset=$this->get_inital_int_transfer_list($date,$res_code);
		if($dataset)
		{
			foreach($dataset as $raw)
			{
				
				if($raw->loan_type=='ZEP'){
				$ledgersetDr=get_account_set('ZEP Rental');
				$ledgersetCR=get_account_set('ZEP Creation');
				}
				if($raw->loan_type=='EPB'){
				$ledgersetDr=get_account_set('EPB Rental');
				$ledgersetCR=get_account_set('EPB Creation');
				
				}
				if($raw->loan_type=='NEP'){
					$ledgersetDr=get_account_set('EP Rental');
					$ledgersetCR=get_account_set('EP creation');
				}
				$totalrental=$raw->cap_amount+$raw->int_amount;
				$reseavation_data=$this->get_resevation($raw->res_code);
						$crlist[0]['ledgerid']=$ledgersetCR['Dr_account']; //stock account
						$crlist[0]['amount']=$crtot=$raw->cap_amount;
						$crlist[1]['ledgerid']=$intledger;					// unrealized interest account
						$crlist[1]['amount']=$crtot=$raw->int_amount;
						$drlist[0]['ledgerid']=$ledgersetDr['Cr_account'];//debtor account
						$drlist[0]['amount']=$drtot=$totalrental;
						$crtot=$drtot=$totalrental;
						$narration = $raw->res_code.' Transfer Today Capital and interest';
						$cap_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						
						// update eploan shedule table
						$dataset1=array('int_entry'=>$cap_entry,'cap_entry'=>$cap_entry);
						$this->db->where('id',$raw->id);
					
						$this->db->update('re_eploanshedule',$dataset1); 
				
				
			}
		}
		
	}
	function get_reshudel_int_transfer_list($date,$res_code) { //get all stock
		$this->db->select('re_eploanshedule.*,re_eploan.loan_type,re_eploan.res_code');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
		$this->db->where('re_eploanshedule.deu_date <=',$date);
		$this->db->where('re_eploanshedule.pay_status ','PENDING');
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->where('re_eploan.res_code',$res_code);
		$query = $this->db->get('re_eploanshedule'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
    }
	function capital_and_interest_transfer_on_reschudyle($date,$res_code)
	{
		$intledgerset=get_account_set('EP Creation Interest');
		$intledger=$intledgerset['Dr_account'];
		$dataset=$this->get_reshudel_int_transfer_list($date,$res_code);
		if($dataset)
		{
			foreach($dataset as $raw)
			{
				
				if($raw->loan_type=='ZEP'){
				$ledgersetDr=get_account_set('ZEP Rental');
				$ledgersetCR=get_account_set('ZEP Creation');
				}
				if($raw->loan_type=='EPB'){
				$ledgersetDr=get_account_set('EPB Rental');
				$ledgersetCR=get_account_set('EPB Creation');
				
				}
				if($raw->loan_type=='NEP'){
					$ledgersetDr=get_account_set('EP Rental');
					$ledgersetCR=get_account_set('EP creation');
				}
				$totalrental=$raw->cap_amount+$raw->int_amount;
				$reseavation_data=$this->get_resevation($raw->res_code);
						$crlist[0]['ledgerid']=$ledgersetCR['Dr_account']; //stock account
						$crlist[0]['amount']=$crtot=$raw->cap_amount;
						$crlist[1]['ledgerid']=$intledger;					// unrealized interest account
						$crlist[1]['amount']=$crtot=$raw->int_amount;
						$drlist[0]['ledgerid']=$ledgersetDr['Cr_account'];//debtor account
						$drlist[0]['amount']=$drtot=$totalrental;
						$crtot=$drtot=$totalrental;
						$narration = $raw->res_code.' Transfer Today Capital and interest';
						$cap_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						
						// update eploan shedule table
						$dataset1=array('int_entry'=>$cap_entry,'cap_entry'=>$cap_entry);
						$this->db->where('id',$raw->id);
					
						$this->db->update('re_eploanshedule',$dataset1); 
				
				
			}
		}
		
	}
	
	function last_income_details($id)
	{
		$this->db->select('MAX(rct_id) as myrct_id');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
			$this->db->where('re_eploanpayment.loan_code',$id);
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
	function update_settled_loans_ondayend()
	{
		$this->db->select('re_eploan.*');
		$this->db->join('re_unrealized','re_unrealized.res_code=re_eploan.res_code');
		$this->db->where('re_eploan.loan_status','SETTLED');
		$this->db->where('re_unrealized.status !=','COMPLETE');

		
		$this->db->group_by('re_eploan.loan_code');
			$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
		$data= $query->result(); 
		 foreach($data as $raw)
		 {
			 echo $raw->loan_code.'settlement transfers<br>'.
			 $this->update_unrealized_sale_on_settlement(date('Y-m-d'),$raw->loan_code,$raw->res_code);
		 }
		}
		else
		return 0;
	}
	function update_unrealized_sale_on_settlement($date,$loan_code,$res_code)
{
	$income_id=$this->last_income_details($loan_code);
	$reseavation_data=$this->get_resevation($res_code);
		 $unrealized_data=get_unrealized_data($res_code);
			   
		$uncost=get_account_set('Unrealized Cost');
		$unsale=get_account_set('Unrealized Sale');
		 if($unrealized_data){
			if($unrealized_data->status!='COMPLETE')
			 {
				 $hm_full_sale=$unrealized_data->hm_full_sale;
				 $hm_full_cost=$unrealized_data->hm_full_cost;
				 $hm_un_cost_priv=$unrealized_data->hm_unrealized_cost;
				 $hm_un_sale_priv=$unrealized_data->hm_unrealized_sale;
				 $re_un_cost_priv=$unrealized_data->unrealized_cost;
				 $re_un_sale_priv=$unrealized_data->unrealized_sale;
				 $re_full_cost=$unrealized_data->full_cost;
				 $re_full_sale=$unrealized_data->full_sale-$hm_full_sale;
				 
				 $re_un_sale= $re_un_sale_priv;
				 $hm_un_sale=$hm_un_sale_priv;
				$hm_un_cost=0;  $re_un_cost=0;
				 if($re_un_sale>0)
				 $re_un_cost=($re_un_sale/$re_full_sale)* $re_full_cost;
				 if( $hm_un_sale>0)
				 $hm_un_cost=($hm_un_sale/$hm_full_sale)* $hm_full_cost;
				 
				 
				 $re_new_uncost=$re_un_cost_priv-$re_un_cost;
				 $re_new_unsale=$re_un_sale_priv-$re_un_sale;
				 
				 $hm_new_uncost=$hm_un_cost_priv-$hm_un_cost;
				 $hm_new_unsale=$hm_un_sale_priv-$hm_un_sale;
				// echo $re_un_sale.'---'.$hm_un_sale;
				// exit;
				 //transfer unrealized cost -lands
				 if($re_un_cost>0)
				 {
					
				 }
				 if($re_un_sale>0)
				 {
				//transfer unrealized Sale -lands
						$ledgerset=get_account_set('Transfer Cost');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$re_un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$re_un_cost;
						$narration = $res_code.' Unrealized Cost Transfer on Payment';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Cost Transfer on Settlement');
				
						$ledgerset=get_account_set('Transfer Sale');
						 $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$re_un_sale;
						$drlist[0]['ledgerid']=$unsale['Dr_account'];
						$drlist[0]['amount']=$drtot=$re_un_sale;
						$narration = $res_code.' Unrealized Sale on Settlement ';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Sale on Settlement ');
				 }
				 
				  if($hm_un_cost>0)
				 {
					
				 }
				 if($hm_un_sale>0)
				 {
				//transfer unrealized Sale -lands
						$unsale_hm=get_account_set('Unrealized Sale Hm');
						$ledgerset=get_account_set('Sale Transfer Hm');
						 $crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$hm_un_sale;
						$drlist[0]['ledgerid']=$unsale_hm['Dr_account'];
						$drlist[0]['amount']=$drtot=$hm_un_sale;
						$narration = $res_code.' Unrealized Sale on Settlement ';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Sale on Settlement ');
						  //transfer unrealized cost -Housing
					$ledgerset=get_account_set('Cost Transfer Hm');
					$uncost=get_account_set('Unrealized Cost Hm');
						$crlist[0]['ledgerid']=$uncost['Dr_account'];
						$crlist[0]['amount']=$crtot=$hm_un_cost;
						$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$drlist[0]['amount']=$drtot=$hm_un_cost;
						$narration = $res_code.' Unrealized Cost Transfer housing on Settlement';
						$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						$this->insert_pay_enties($income_id,$int_entry,'Unrealized Cost Transfer on Settlement');
				 }
				 
				 $new_unsale_tot= $hm_new_unsale+ $re_new_unsale;
						//if($new_unsale_tot<=1)
						$status='COMPLETE';
						//else 
						//$status='PARTIAL';
						$insert_data = array(
							'last_incomeid' =>$income_id,
							'unrealized_sale' =>$re_new_unsale,
							'unrealized_cost' =>$re_new_uncost,
							'hm_unrealized_sale' =>$hm_new_unsale,
							'hm_unrealized_cost' =>$hm_new_uncost,
								'last_trndate' =>$date,
							'status' =>$status,
								);
					$this->db->where('res_code',$res_code);
				if ( ! $this->db->Update('re_unrealized', $insert_data))
				{
				$this->db->trans_rollback();
				$this->logger->write_message("error", $narration."Error adding since failed inserting entry");
			
				return false;
				}
				insert_unrdata($reseavation_data->res_code,$income_id,'',date("Y-m-d"),$re_un_sale,$re_un_cost,'On Payment',$hm_un_sale,$hm_un_cost);
				
			}
					
	}
}

function update_lotdata_floor()
{
	$this->db->select('re_prjaclotdata.*');
		$this->db->where('re_prjaclotdata.lot_type','H');

				$query = $this->db->get('re_prjaclotdata'); 
		if ($query->num_rows() > 0){
		$data= $query->result(); 
			 foreach($data as $raw)
			 {
		
		$data = array(
				'prj_id'	 	=> $raw->prj_id,
				'lot_id' 		=> $raw->lot_id,
				'design_id' 	=> $raw->design_id
			);
			$this->db->insert('re_hmaclot_floordata',$data);
			 }
		}
}

function update_settled_one_time()
	{
		$reseavation_data=$this->get_resevation($res_code);
	
		$this->db->select('re_eploan.*');
	//	$this->db->join('re_unrealized','re_unrealized.res_code=re_eploan.res_code');
		$this->db->where('re_eploan.loan_status','SETTLED');
	//$this->db->where('re_unrealized.status !=','COMPLETE');

		
		$this->db->group_by('re_eploan.loan_code');
			$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
		$data= $query->result(); 
		 foreach($data as $raw)
		 {
			 echo $raw->loan_code.'settlement transfers<br>'.
			 $this->update_settled_loan_capital_inerest($raw->loan_code,$raw->res_code,$raw->loan_type);
		 }
		}
		else
		return 0;
	}
function update_settled_loan_capital_inerest($loan_code,$res_code,$loan_type)
{
	
	if($loan_type=='ZEP'){
							$ledgerset_loanaccount=get_account_set('ZEP Rental');
							$loan_stockaccount=get_account_set('ZEP Creation');
				
						}
						if($loan_type=='EPB'){
							$ledgerset_loanaccount=get_account_set('EPB Rental');
							$loan_stockaccount=get_account_set('EPB Creation');
				
						}
						if($loan_type=='NEP'){
							$ledgerset_loanaccount=get_account_set('EP Rental');
							$loan_stockaccount=get_account_set('EP creation');
				
						}
	$cap_entry=NULL;$interest_entry=NULL;
					$futureint=$this->get_not_transferd_interest_on_settlement($loan_code);
					if($futureint>0)
					{
						$ledgerset=get_account_set('EP Creation Interest');
						$crlist[0]['ledgerid']=$ledgerset['Dr_account'];
						$crlist[0]['amount']=$crtot=$futureint;
						$drlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
						$drlist[0]['amount']=$drtot=$futureint;
						$narration = $res_code.' Transfer Future Interest On Settlement';
						$interest_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						//$this->insert_pay_enties($id,$interest_entry,'Transfer Future Interest');
					}
					//future Capital transfre to debtor account
					$drlist=NULL;
					$crlist=NULL;
					$futurecap=$this->get_not_transferd_capital_on_settlement($loan_code);
					if($futurecap>0)
					{
						echo $res_code.'-'.$futurecap.'<br>';
						$ledgerset=get_account_set('EP Creation Interest');
						$crlist[0]['ledgerid']=$loan_stockaccount['Dr_account'];
						$crlist[0]['amount']=$crtot=$futurecap;
						$drlist[0]['ledgerid']=$ledgerset_loanaccount['Cr_account'];
						$drlist[0]['amount']=$drtot=$futurecap;
						$narration = $res_code.' Transfer Future Capital On Settlement';
						$cap_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date('Y-m-d'),$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
						//$this->insert_pay_enties($id,$cap_entry,'Transfer Future Capital');
					}
					$this->update_capital_and_interest_transfers_on_settlement($loan_code,$cap_entry,$interest_entry);
					
}
}