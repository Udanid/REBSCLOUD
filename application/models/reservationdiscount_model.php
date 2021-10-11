<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reservationdiscount_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_not_complete_reservation_summery($branchid) {
		$status = array('PROCESSING'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
				$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		$query = $this->db->get('re_resevation'); 
		return $query->result(); 
    }
	
	function get_all_reservation_details_bycode($rescode) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.sale_val,re_prjaclotdata.lot_type');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.res_code',$rescode);
		$query = $this->db->get('re_resevation'); 
		return $query->row(); 
    }
	function disocunt_list($branchid) {
		$status = array('PROCESSING'); //get all stock
		$this->db->select('re_reservdicount.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.sale_val');
		$this->db->join('re_projectms','re_projectms.prj_id=re_reservdicount.prj_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_reservdicount.cus_code');
				$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_reservdicount.lot_id');

		//if(! check_access('all_branch'))
	//	$this->db->where('re_reservdicount.branch_code',$branchid);
		$this->db->order_by('re_reservdicount.id','DESC');
		$query = $this->db->get('re_reservdicount'); 
		return $query->result(); 
    }
	
	function disocunt_list_all($branchid,$res_code) {
		$this->db->from('re_reservdicount');
		$this->db->join('re_resevation','re_resevation.res_code=re_reservdicount.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		if($res_code != '')
		$this->db->where('re_reservdicount.res_code',$res_code);
		$count = $this->db->count_all_results();
		return $count; 
    }
	
	
	function disocunt_list_paging($branchid,$res_code,$pagination_counter, $page_count) {
		$status = array('PROCESSING'); //get all stock
		$this->db->select('re_reservdicount.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.sale_val');
		$this->db->join('re_projectms','re_projectms.prj_id=re_reservdicount.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_reservdicount.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_reservdicount.lot_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_reservdicount.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		if($res_code != '')
		$this->db->where('re_reservdicount.res_code',$res_code);
		$this->db->order_by('re_reservdicount.id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_reservdicount'); 
		return $query->result(); 
    }
	
	function get_discountdata_bycode($id) { //get all stock
		$this->db->select('re_reservdicount.*');
			$this->db->where('re_reservdicount.id',$id);
		$query = $this->db->get('re_reservdicount'); 
		return $query->row(); 
    }
	function add()
	{
		$resdata=$this->get_all_reservation_details_bycode($this->input->post('res_code_set')); 
		$data=array( 
		'res_code'=>$resdata->res_code,
		'prj_id'=>$resdata->prj_id,
		'lot_id'=>$resdata->lot_id,
		'cus_code'=>$resdata->cus_code,
		'old_saleprice'=>$resdata->seling_price,
		'old_discount'=>$resdata->discount,
		'old_discountedprice'=>$resdata->discounted_price,
		'new_discount'=>$this->input->post('new_discount'),
		'new_discountedprice'=>$this->input->post('new_discountedprice'),
		'repay_amount'=>$this->input->post('repay_amount'),
		'create_date'=>date('Y-m-d'),
		'discount_type' => 'Manual',
		'discount_rate' => number_format(($this->input->post('new_discount') / $resdata->discounted_price) * 100,2),
		'user_id'=>$this->session->userdata('userid'),
		'resdis_comment'=>$this->input->post('txtComment'),
		
		);
		$insert = $this->db->insert('re_reservdicount', $data);
		$entry_id = $this->db->insert_id();
		return $entry_id;
		//echo $letter_type;
	}
	
	function delete($id)
	{
		if($id)
		{
		$this->db->where('id',$id);
		$insert = $this->db->delete('re_reservdicount');
		}
		return $id;
	}
	function confirm($id)
	{
		$disdata=$this->get_discountdata_bycode($id);
		$resdata=$this->get_all_reservation_details_bycode($disdata->res_code); 
		$lot_type=$resdata->lot_type;
				
				$discount=$disdata->new_discount;
				$totprice=$resdata->discounted_price;
				$new_discounted_price=$resdata->discounted_price-$discount;
				$hm_discount=0;
				if($lot_type=='H')
				{
					if($resdata->re_discounted_price <=$resdata->down_payment)
					{
						$re_discounted_price=$resdata->re_discounted_price;
						$hm_discount=$discount;
						$hm_discounted_price=$resdata->hm_discounted_price-$hm_discount;
					}
					else{
						$hm_seling_price=$resdata->hm_discounted_price;
						$hm_discount=$hm_seling_price*$discount/$totprice;
						$hm_discounted_price=$hm_seling_price-$hm_discount;
						$re_discounted_price=$new_discounted_price-$hm_discounted_price;
					}
				}
				else
				{
					$hm_seling_price=0;
					$hm_discount=0;
					$hm_discounted_price=0;
					$re_discounted_price=$new_discounted_price-$hm_discounted_price;
				}	
		
		
		if($resdata->profit_status=='PENDING')
		$ledgerset=get_account_set('Advanced Payment');
		else
		$ledgerset=get_account_set('Advance Payment After Profit');
		if($resdata->profit_status!='PENDING')
		{
				update_unrealized_data_on_discount($disdata->res_code,$discount,0,date('Y-m-d'),$hm_discount);	
		}
		if($disdata->repay_amount>0)
		{
				 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
					$voucherid=$idlist[0];
				$data=array( 
				'voucherid'=>$voucherid,
				'vouchercode'=>$idlist[1],
				'branch_code' => $resdata->branch_code,
				'ledger_id' =>$ledgerset['Cr_account'],
				'payeename' => $resdata->first_name." ".$resdata->last_name ,
				'vouchertype' => '6',
				'paymentdes' => 'Loan Reprocess Refund',
				'amount' => $disdata->repay_amount,
				'applydate' =>date('Y-m-d'),
				'status' => 'CONFIRMED',
				
				);
				if(!$this->db->insert('ac_payvoucherdata', $data))
				{
						$this->db->trans_rollback();
							$this->logger->write_message("error", "Error confirming Project");
					return false;
				}
		}
		$newdownpayment=$resdata->down_payment-$disdata->repay_amount;
		$newdiscount=$resdata->discount+$disdata->new_discount;
		$price=$disdata->new_discountedprice;
		
		$data=array( 
			'discount' =>$newdiscount,
			'discounted_price' =>$price,
			'down_payment' =>$newdownpayment,
			're_discounted_price' =>$re_discounted_price,
			'hm_discounted_price' =>$hm_discounted_price,
			
		);
		$this->db->where('res_code', $disdata->res_code);
		$insert = $this->db->update('re_resevation', $data);
		$data=array( 
			'status' => 'CONFIRMED',
			'voucher_id' =>$voucherid,
			'confirmed_by' => $this->session->userdata('userid'),
			'confirmed_date' => date('Y-m-d'),
		);
		$this->db->where('id', $id);
		$insert = $this->db->update('re_reservdicount', $data);
		//$insert = $this->db->delete('re_reservdicount');
		return $insert;
	}

	//2019-12-19 Ticket 943 B.K.Dissanayake
	function get_reservationDiscount_by_lotid_prjid($current_rescode){
		$this->db->select('*');
		$this->db->where('res_code',$current_rescode);
		$this->db->where('status','CONFIRMED');
		$query = $this->db->get('re_reservdicount');
		if($query->num_rows()>0)
			return $query->result(); 
		else
			return FALSE;
	}
	function get_new_discount_rate($res_date,$pay_date,$rate){
		if($rate>=100)
		$rate=100;
		else if($rate<100 & $rate>=60)
		$rate=60;
		else if($rate<60 & $rate>=40)
		$rate=40;
		else
		$rate=0;
		 $date1=date_create($pay_date);
		  $date2=date_create($res_date);
		  $diff=date_diff($date1,$date2);
		  $dates=$diff->format("%a ");
		  if($dates <=7)
		  $dates=7;
		  else if($dates>7 & $dates <=14)
			$dates=14;
			else if($dates>14 & $dates <=21)
			$dates=21;
			else if($dates>21 & $dates <=28)
			$dates=28;
			else
			$dates=0; 
			
		$dates=$diff->format("%a ");
		$this->db->select('*');
		$this->db->where('days',$dates);
		$this->db->where('payrate',$rate);
		$query = $this->db->get('re_discountschedule');
		if($query->num_rows()>0)
		{
			$data = $query->row(); 
			return $data->discount;
		}
		else
			return 0;
	}
	
	function get_scheme($prj_id){
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('status','CONFIRMED');
		$this->db->order_by('days');
		$query = $this->db->get('re_discountschedule');
		if($query->num_rows()>0)
			return $query->result(); 
		else
			return false;	
	}
	
	function get_scheme_days($prj_id,$days){
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('days',$days);
		$this->db->where('status','CONFIRMED');
		$this->db->order_by('payrate','DESC');
		$query = $this->db->get('re_discountschedule');
		if($query->num_rows()>0)
			return $query->result(); 
		else
			return false;
	}
	
	function get_total_discounts_system($res_code){
		$this->db->select_sum('new_discount');
		$this->db->where('res_code',$res_code);
		$this->db->where('discount_type','System');
		$query = $this->db->get('re_reservdicount');
		if($query->num_rows()>0)
			return $query->row()->new_discount; 
		else
			return false;	
	}
	

}