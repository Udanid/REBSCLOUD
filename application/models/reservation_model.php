<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reservation_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all__not_complete_reservation_summery($branchid) {
		$status = array('PROCESSING', 'COMPLETE'); //get all stock
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
	function get_all_reservation_summery_withoutreprocess($branchid) {
		$status = array('PROCESSING', 'COMPLETE','SETTLED'); //get all stock
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
	function get_all_reservation_summery($branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
				$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','PROCESSING');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
    //Ticket No:3305 Updated By Madushan 2021-08-17
	function get_all_reservation_details_withpending($pagination_counter, $page_count,$branchid) { //get all stock
	$status = array('PROCESSING', 'PENDING'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.sale_val,re_prjaclotdata.price_perch');
//	$this->db->select('re_resevation.*,re_projectms.project_name');

		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
	$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->order_by('re_resevation.res_status');
		$this->db->order_by('re_resevation.res_date','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

    //Ticket No:3331 Added By Madushan 2021-08-24
    function search_all_reservation_details_withpending($prj_id,$lot,$cus_nic,$branchid) { //get all stock
	$status = array('PROCESSING', 'PENDING'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.sale_val,re_prjaclotdata.price_perch');
//	$this->db->select('re_resevation.*,re_projectms.project_name');

		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
	$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
	if($prj_id != 'all')
		$this->db->where('re_projectms.prj_id',$prj_id);
	if($lot != 'all')
		$this->db->where('re_prjaclotdata.lot_id',$lot);
	if($cus_nic != 'all')
		$this->db->where('cm_customerms.id_number',$cus_nic);

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->order_by('re_resevation.res_status');
		$this->db->order_by('re_resevation.res_date','DESC');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_all_reservation_details($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','PROCESSING');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_complete_summery($branchid) { //get all stock
		$this->db->select('re_resevation.*');
		//$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		//	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','COMPLETE');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_all_reservation_complete_details($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','COMPLETE');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_settlments_summery($branchid) { //get all stock
	$status = array('SETTLED', 'COMPLETE');
		$this->db->select('re_resevation.*');
		//$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		//	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->where('re_resevation.pay_type','Outright');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_all_reservation_settlments($pagination_counter, $page_count,$branchid) {
		$status = array('SETTLED', 'COMPLETE');  //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_settlement.amount,re_settlement.settle_date,,re_settlement.settle_status');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_settlement','re_settlement.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
	$this->db->where_in('re_resevation.res_status',$status);
		$this->db->where('re_resevation.pay_type','Outright');
		$this->db->order_by('re_settlement.settle_date','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function get_all_reservation_eploan_summery($branchid) { //get all stock
		$this->db->select('re_resevation.*');
		//$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		//	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','COMPLETE');
		$this->db->where('re_resevation.pay_type !=','Outright');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_all_reservation_eploan($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_status,re_eploan.loan_code,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','COMPLETE');
		$this->db->where('re_resevation.pay_type !=','Outright');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
		function get_all_reservation_eploan_pending($pagination_counter, $page_count,$branchid) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_status,re_eploan.loan_code,re_eploan.unique_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.res_status','COMPLETE');
		$this->db->where('re_resevation.pay_type !=','Outright');
			$this->db->where('re_eploan.loan_status ','PENDING');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_resevation');
		return $query->result();
    }

	function get_all_reservation_details_bycode($rescode) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,re_projectms.project_code,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.lot_type');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.res_code',$rescode);
		$query = $this->db->get('re_resevation');
		return $query->row();
    }
	function get_officer_projectlist($userid) { //get all stock
		$this->db->select('project_name,prj_id');
		$this->db->where('officer_code',$userid);
		$this->db->where('status',CONFIRMKEY);
		$this->db->order_by('prj_id');
		$query = $this->db->get('re_projectms');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function get_salesmen_projectlist($userid) { //get all stock
		$this->db->select('re_projectms.prj_id,re_projectms.project_name');
		$this->db->where('re_salesman.user_id',$userid);
		$this->db->join('re_projectms','re_projectms.prj_id=re_salesman.prj_id');
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_salesman');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_project_bycode($code) { //get all stock
		$this->db->select('re_projectms.*');
		$this->db->where('re_projectms.prj_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_projectms');
		return $query->row();
    }
		function get_purchase_type() { //get all stock
		$this->db->select('*');

		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_saletype');
		return $query->result();
    }
	function get_mindp_level()
	{
		$this->db->select('MIN(dp_rate) as dprate');

		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_dplevels');
		$data=$query->row();
		return $data->dprate;
	}

	function get_salesmen_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_salesman');
		return $query->row();
    }

	function check_already_excist($prj_id,$id)
	{
		$this->db->select('id');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('user_id',$id);


		$query = $this->db->get('re_salesman');
		 if ($query->num_rows >0) {
            return true;
        }
		else
		return false;
	}
	function check_sales_active($prj_id,$id)
	{
		$this->db->select('res_code');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('sales_person',$id);
		$query = $this->db->get('re_resevation');
		 if ($query->num_rows >0) {
            return true;
        }
		else
		return false;
	}
	function add()
	{
		if( $this->input->post('branch_code'))
		{
			$branchdata=explode(',',$this->input->post('branch_code'));
			$branc_code=$branchdata[0];
			$shortcode=$branchdata[1];
		}
		else
		{
			$branc_code=$this->session->userdata('branchid');
			$shortcode=$this->session->userdata('shortcode');
		}
		if($this->input->post('sales_person')=="")
		{
			$prjdata=$this->get_project_bycode($this->input->post('prj_id'));
			$salsmen=$prjdata->officer_code;
		}
		else $salsmen=$this->input->post('sales_person');
		$idfield=$this->getmaincode_branchshortcode('res_code',$shortcode,'re_resevation',$branc_code);
		$res_code=$idfield[0];
		$loan_code=$this->getmaincode('loan_code','LND','re_eploan');
		$res_seq=$this->getsequense('res_seq',$this->input->post('lot_id'),'re_resevation');
		$this->db->trans_start();
		$outstad=floatval($this->input->post('discounted_price'))-floatval($this->input->post('down_payment'));
		$lot_type=$this->input->post('lot_type');

		$discount=$this->input->post('totprice') - $this->input->post('discounted_price');
		$totprice=$this->input->post('totprice');

		/*Ticket No 2889 Added By Madushan 2021.06.14*/
		$period = intval(trim($this->input->post('r_period')));
		//echo $period;
		if($period > 0)
		{
		 	for($i = 1 ; $i<=$period;$i++)
		 	{
		 		$due_date = $this->input->post('instdate'.$i);
		 		$installmet_amount = $this->input->post('instalment'.$i);
		 		$shedule = array(
		 			'res_code'=>$res_code,
		 			'installment_number'=>$i,
		 			'amount'=>$installmet_amount,
		 			'due_date'=>$due_date,
		 			'status'=>'PENDING',
		 		);
		 		// echo $due_date.' - '.$installmet_amount.'<br>';

		 		$this->db->insert('re_salesadvanceshedule',$shedule);
		 	}
		}

		//Add First Payment
		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$this->db->where('status <>','PAID');
		$this->db->order_by('installment_number');
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
		{
			$pay_amount = $this->input->post('pay_amount');

			foreach($query->result() as $row)
			{
				$balance_amount = $existing_paid_amount = $paid_amount = 0;
				$status = "PENDING";
				if($pay_amount == 0.0 || $pay_amount < 0)
					break;

				$balance_amount = floatval($row->amount);
				$existing_paid_amount = floatval($row->paid_amount);
				if($row->paid_amount){
					$balance_amount = floatval($row->amount) - $existing_paid_amount;
				}

				if($pay_amount >= $balance_amount)
				{
					$paid_amount = $existing_paid_amount + $balance_amount;
					$status = 'PAID';
				}
				else
				{
					$paid_amount = $existing_paid_amount + floatval($pay_amount);
					$status = 'PENDING';
				}

				$data = array(

					'paid_amount'=>$paid_amount,
					'paid_date'=>$this->input->post('res_date'),
					'status'=>$status,
				);

				$this->db->where('res_code',$res_code);
				$this->db->where('installment_number',$row->installment_number);
				$this->db->update('re_salesadvanceshedule',$data);

				$pay_amount = $pay_amount - $balance_amount;
			}
		}
		/*End of Ticket No 2889*/

		if($lot_type=='H')
		{
			$hm_seling_price=$this->input->post('hm_seling_price');
			$hm_discounted_price=$hm_seling_price-($hm_seling_price*$discount/$totprice);
			$re_discounted_price=$this->input->post('discounted_price')-$hm_discounted_price;
		}
		else
		{
			$hm_seling_price=0;
			$hm_discounted_price=0;
			$re_discounted_price=$this->input->post('discounted_price')-$hm_discounted_price;
		}
		$data=array(
		'res_code'=>$res_code,
		'res_number'=>$idfield[1],
		'res_seq'=>$res_seq,
		'branch_code'=>$branc_code,
		'prj_id' =>$this->input->post('prj_id'),
		'lot_id' =>$this->input->post('lot_id'),
		'cus_code' =>$this->input->post('cus_code'),
		'seling_price' =>$this->input->post('totprice'),
		'legal_fee' =>$this->input->post('legal_fee'),
		'document_fee' =>$this->input->post('document_fee'),
		'plan_copy' =>$this->input->post('plan_charge'),
		'other_charges' =>$this->input->post('other_charges'),
		'dp_level' =>$this->input->post('dp_level'),
		'non_refund' =>$this->input->post('non_refund'),
		'min_down' =>$this->input->post('min_down'),
		'tot_cost' =>$this->input->post('discounted_price'),
		'discount' =>$discount,
		'discounted_price' =>$this->input->post('discounted_price'),
		'pay_amount' =>$this->input->post('pay_amount'),
		'pay_type' =>$this->input->post('pay_type'),
		'down_payment' =>$this->input->post('down_payment'),
		'dp_cmpldate' =>$this->input->post('dp_cmpldate'),
      	'dp_fulcmpdate' =>$this->input->post('dp_fulcmpdate'),
      	'discount_remarks' =>$this->input->post('discount_reason'),

		're_discounted_price' =>$re_discounted_price,
		'hm_discounted_price' =>$hm_discounted_price,
		'hm_seling_price' =>$hm_seling_price,
		'total_out' =>$outstad,
		'res_date' =>$this->input->post('res_date'),
		'sales_person' =>$salsmen,
		'res_status'=>'PENDING',
		'apply_by '=>$this->session->userdata('username'),
		);
		if(!$this->db->insert('re_resevation', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error On Update Resevation");
			return false;
		}
		$data=array(
			'status' => 'ONHOLD',

		);
		$this->db->where('lot_id', $this->input->post('lot_id'));
		$insert = $this->db->update('re_prjaclotdata', $data);


		$this->db->trans_complete();

		return $res_code;



	}
	function get_resevationdata($rescode) { //get all stock
		$this->db->select('*');
		$this->db->where('res_code',$rescode);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }

    /*Ticket No:3106 Updated By Madushan 2021-07-15*/
	function get_advance_data($rescode) { //get all stock
		$this->db->select('re_saleadvance.*,re_prjacincome.pay_status as status,re_prjacincome.rct_no,re_paymententries.type,re_prjacincome.enty_type,re_prjacincome.entry_date');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->join('re_paymententries','re_paymententries.pay_id=re_prjacincome.id and re_paymententries.type="Cost Trasnfer"','left');
		$this->db->where('re_saleadvance.res_code',$rescode);
		$this->db->order_by('re_saleadvance.id');

		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }


	function get_advance_byid($id) { //get all stock
    /*2019-10-10 nadee ticket number 750*/
    /*update to get res_statues and pay_type*/
		$this->db->select('re_saleadvance.*,re_resevation.down_payment,re_resevation.discounted_price,
    re_resevation.total_out,re_resevation.pay_type,re_resevation.res_status,re_resevation.discount,re_resevation.hm_discounted_price,re_resevation.re_discounted_price');
		$this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code');
		$this->db->where('re_saleadvance.id',$id);

		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_eploan_data($rescode) { //get all stock
		$this->db->select('*');
		$this->db->where('res_code',$rescode);
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_settlemnt_data($rescode) { //get all stock
		$this->db->select('*');

		$this->db->where('res_code',$rescode);

		$query = $this->db->get('re_settlement');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_settlemnt_data_with_payment($rescode) { //get all stock
		$this->db->select('re_settlement.*,re_prjacincome.pay_status as status,re_prjacincome.rct_no,re_paymententries.type');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_settlement.entry_id');
		$this->db->join('re_paymententries','re_paymententries.pay_id=re_prjacincome.id and re_paymententries.type="Cost Trasnfer"','left');


		$this->db->where('res_code',$rescode);

		$query = $this->db->get('re_settlement');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
		function get_re_ledgerset() { //get all stock
		$this->db->select('*');
			$query = $this->db->get('re_lederset');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function edit()
	{
		if( $this->input->post('branch_code'))
		{
			$branchdata=explode(',',$this->input->post('branch_code'));
			$branc_code=$branchdata[0];
			$shortcode=$branchdata[1];
		}
		else
		{
			$branc_code=$this->session->userdata('branchid');
			$shortcode=$this->session->userdata('shortcode');
		}
		if($this->input->post('sales_person')=="")
		{
			$prjdata=$this->get_project_bycode($this->input->post('prj_id'));
			$salsmen=$prjdata->officer_code;
		}
		else $salsmen=$this->input->post('sales_person');

		$res_code=$this->input->post('res_code');
		$outstad=floatval($this->input->post('totprice'))-floatval($this->input->post('down_payment'));
		$this->db->trans_start();


		$lot_type=$this->input->post('lot_type');

		$discount=$this->input->post('totprice') - $this->input->post('discounted_price');
		$totprice=$this->input->post('totprice');
		if($lot_type=='H')
		{
			$hm_seling_price=$this->input->post('hm_seling_price');
			$hm_discounted_price=$hm_seling_price-($hm_seling_price*$discount/$totprice);
			$re_discounted_price=$this->input->post('discounted_price')-$hm_discounted_price;
		}
		else
		{
			$hm_seling_price=0;
			$hm_discounted_price=0;
			$re_discounted_price=$this->input->post('discounted_price')-$hm_discounted_price;
		}

		$data=array(
		'seling_price' =>$this->input->post('totprice'),
		'legal_fee' =>$this->input->post('legal_fee'),
		'document_fee' =>$this->input->post('document_fee'),
		'plan_copy' =>$this->input->post('plan_charge'),
		'other_charges' =>$this->input->post('other_charges'),
		'sales_vat' =>$this->input->post('vat'),
		'tot_cost' =>$this->input->post('discounted_price'),
		'discount' =>$this->input->post('discount'),
		'discounted_price' =>$this->input->post('discounted_price'),
		'pay_amount' =>$this->input->post('pay_amount'),
		'pay_type' =>$this->input->post('pay_type'),
		'down_payment' =>$this->input->post('down_payment'),
		'dp_cmpldate' =>$this->input->post('dp_cmpldate'),
		're_discounted_price' =>$re_discounted_price,
		'hm_discounted_price' =>$hm_discounted_price,
		'hm_seling_price' =>$hm_seling_price,
		'total_out' =>$outstad,
		'res_date' =>$this->input->post('res_date'),
		'sales_person' =>$salsmen,
		'res_status'=>'PENDING'


		);
		$this->db->where('res_code',$res_code);
		if(!$this->db->update('re_resevation', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error On Update Resevation");
			return false;
		}

		/*Ticket No:2889 Added By Madushan 2021.06.14*/
		$this->db->where('res_code',$res_code);
		$this->db->delete('re_salesadvanceshedule');


		$period = intval(trim($this->input->post('r_period')));
		//echo $period;
		if($period > 0)
		{
		 	for($i = 1 ; $i<=$period;$i++)
		 	{
		 		$due_date = $this->input->post('instdate'.$i);
		 		$installmet_amount = $this->input->post('instalment'.$i);
		 		$shedule = array(
		 			'res_code'=>$res_code,
		 			'installment_number'=>$i,
		 			'amount'=>$installmet_amount,
		 			'due_date'=>$due_date,
		 			'status'=>'PENDING',
		 		);
		 		// echo $due_date.' - '.$installmet_amount.'<br>';

		 		$this->db->insert('re_salesadvanceshedule',$shedule);
		 	}
		}

		//Add First Payment
		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$this->db->where('status <>','PAID');
		$this->db->order_by('installment_number');
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
		{
			$pay_amount = $this->input->post('pay_amount');

			foreach($query->result() as $row)
			{
				$balance_amount = $existing_paid_amount = $paid_amount = 0;
				$status = "PENDING";
				if($pay_amount == 0.0 || $pay_amount < 0)
					break;

				$balance_amount = floatval($row->amount);
				$existing_paid_amount = floatval($row->paid_amount);
				if($row->paid_amount){
					$balance_amount = floatval($row->amount) - $existing_paid_amount;
				}

				if($pay_amount >= $balance_amount)
				{
					$paid_amount = $existing_paid_amount + $balance_amount;
					$status = 'PAID';
				}
				else
				{
					$paid_amount = $existing_paid_amount + floatval($pay_amount);
					$status = 'PENDING';
				}

				$data = array(

					'paid_amount'=>$paid_amount,
					'paid_date'=>$this->input->post('res_date'),
					'status'=>$status,
				);

				$this->db->where('res_code',$res_code);
				$this->db->where('installment_number',$row->installment_number);
				$this->db->update('re_salesadvanceshedule',$data);

				$pay_amount = $pay_amount - $balance_amount;
			}
		}
		/*End of Ticket No 2889*/

		/*End of Ticket No:2889*/
		return $res_code;

	}
	function confirm($res_code)
	{
		$resdata=$this->get_resevationdata($res_code);
		$fullresdata=$this->get_all_reservation_details_bycode($res_code);
		$saledata=$this->get_advance_data($res_code);
		$loandata=$this->get_eploan_data($res_code);
		$lederset=$this->get_re_ledgerset();
		foreach($lederset as $myacc)
		{
			if($myacc->Description=='Advanced Payment')
			{
				$advanceCr=$this->session->userdata('accshortcode').$myacc->Cr_account;
				$advanceDr=$this->session->userdata('accshortcode').$myacc->Dr_account;
			}
			if($myacc->Description=='Documentation Charge')
			{
				$docfeeCr=$this->session->userdata('accshortcode').$myacc->Cr_account;
				$docfeeDr=$this->session->userdata('accshortcode').$myacc->Dr_account;
			}
			if($myacc->Description=='Legal Fee')
			{
				$legfeeCr=$this->session->userdata('accshortcode').$myacc->Cr_account;
				$legfeeDr=$this->session->userdata('accshortcode').$myacc->Dr_account;
			}

		}

		$this->db->trans_start();
		$advance_fee=0;
		if($resdata->pay_amount>0)
		{
			$insert_data = array(
				'temp_code' =>  $resdata->res_code,
				'res_code' =>  $resdata->res_code,
				'pri_id' =>$resdata->prj_id,
				'lot_id' =>$resdata->lot_id,
				'cus_code' =>$resdata->cus_code,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Advance Payment',
				'amount' => $resdata->pay_amount,
				'income_date' => $resdata->res_date,
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
			$doc_fee=floatval($resdata->document_fee)+floatval($resdata->plan_copy)+floatval($resdata->other_charges);
			if($doc_fee>0){
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$docfeeCr,
					'dc_type' => 'C',
					'amount' =>$doc_fee,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
			}
			if(floatval($resdata->legal_fee)>0)
			{
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$legfeeCr,
					'dc_type' => 'C',
					'amount' =>$resdata->legal_fee,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
			}
			$advance_fee=floatval($resdata->pay_amount)-(floatval($doc_fee)+floatval($resdata->legal_fee));
			$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>$advance_fee,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceDr,
					'dc_type' => 'D',
					'amount' =>$resdata->pay_amount,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$pay_seq=$this->getsequense_pay('pay_seq',$resdata->res_code,'re_saleadvance');
				$insert_data = array(
				    'pay_seq'=>$pay_seq,
					'res_code' =>$resdata->res_code,
					'pay_amount' =>$advance_fee,
					'rct_id' => $entry_id,
					'pay_date' =>$resdata->res_date,
				);
				if ( ! $this->db->insert('re_saleadvance', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
		}

		$data=array(
			'res_status' => 'PROCESSING',
			'down_payment' => $advance_fee,
			'last_dpdate'=>$resdata->res_date,
			'confirm_by '=>$this->session->userdata('username'),
		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_resevation', $data);

		$data=array(
			'status' => 'RESERVED',

		);
		$this->db->where('lot_id', $resdata->lot_id);
		$insert = $this->db->update('re_prjaclotdata', $data);
		$msg='Thank you for your reservation . Lot No :'.$fullresdata->lot_number;
		if($resdata->min_down>$advance_fee){
		create_letter($resdata->branch_code,$resdata->cus_code,$res_code,'','','01',$msg,$advance_fee);

		}
		if($resdata->discount >0)
			$this->update_discount($res_code);

		return $insert;

	}
	function add_advance()
	{
		$res_code=$this->input->post('res_code');
		$resdata=$this->get_resevationdata($res_code);
		$lederset=$this->get_re_ledgerset();

		if($resdata->profit_status=='PENDING')
		$ledgerset=get_account_set('Advanced Payment');
		else
		$ledgerset=get_account_set('Advance Payment After Profit');
		$advanceCr=$ledgerset['Cr_account'];
		$advanceDr=$ledgerset['Dr_account'];


		$this->db->trans_start();
			$insert_data = array(
				'temp_code' =>  $resdata->res_code,
				'res_code' =>  $resdata->res_code,
				
				'pri_id' =>$resdata->prj_id,
				'cus_code' =>$resdata->cus_code,
				'lot_id' =>$resdata->lot_id,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Advance Payment',
				'amount' => $this->input->post('pay_amount'),
				'income_date' =>$this->input->post('paydate1'),
			);
			if ( ! $this->db->insert('re_prjacincome', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}$retruncharge=get_pending_return_charge($resdata->cus_code);
			$payamount=$this->input->post('pay_amount');
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
				$diamount=$this->input->post('di_val');
				$divaweoff=$this->input->post('di_vaivamount');
				$paydi=$diamount-$divaweoff;
				if($paydi>0){
					if($paydi < $payamount)
					$payamount=$payamount-$paydi;
					else{
					$paydi=$payamount;
					$payamount=0;
					}
					$diledger=get_account_set('Delay Interest');
					//echo $diledger['Cr_account'];
					$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$diledger['Cr_account'],
					'dc_type' => 'C',
					'amount' =>$paydi,
					);
					if ( ! $this->db->insert('re_incomentires', $insert_data))
						{
						$this->db->trans_rollback();
						$this->messages->add('Error addding Entry.', 'error');

					return;
					}

				}
				$balancedi=$diamount-($paydi+$divaweoff);
				update_today_di($resdata->res_code,date('Y-m-d'),$balancedi);
			//Document Fee insert

				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
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
					'ledger_id' =>$advanceDr,
					'dc_type' => 'D',
					'amount' =>$this->input->post('pay_amount'),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

				$discount_recieved = preg_replace('#(\d),(\d)#','$1$2',$this->input->post('discount'));

				$new_down=floatval($payamount)+floatval($resdata->down_payment);
				$outstad=floatval($resdata->total_out) - floatval($payamount);
				$excess=round($new_down-($resdata->discounted_price-$discount_recieved),2);
				if($excess>0)
				{
					$advancepay=$payamount-$excess;
					$new_down=$resdata->discounted_price-$discount_recieved;
					$outstad=0;

				}
				else
				$advancepay=$payamount;

				$pay_seq=$this->getsequense_pay('pay_seq',$resdata->res_code,'re_saleadvance');
				$insert_data = array(
				    'pay_seq'=>$pay_seq,
					'res_code' =>$resdata->res_code,
					'di_amount' =>$paydi,
					'tot_amount' =>$this->input->post('pay_amount'),
					'waiveoff_amount' =>$divaweoff,
					'pay_amount' =>$advancepay,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('paydate1'),
				);
				if ( ! $this->db->insert('re_saleadvance', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

		$data=array(
			'down_payment' => $new_down,
			'last_dpdate'=>$this->input->post('paydate1'),
			'total_out' =>$outstad,
		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_resevation', $data);
		$arrears=round($new_down-($resdata->discounted_price-$discount_recieved),2);
		if($excess>0)
		{
			customer_arreaspayment($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$resdata->lot_id,'',$excess,$advanceCr,date('Y-m-d'),$entry_id);
		}

		//add to re_reservdicount and update re_resevation
		$resdata=$this->get_all_reservation_details_bycode($res_code);
		$discount_recieved = preg_replace('#(\d),(\d)#','$1$2',$this->input->post('discount'));



		if($discount_recieved>0)
		{
		//	get_all_reservation_details_bycode


				$lot_type=$resdata->lot_type;

				$discount=$discount_recieved;
				$totprice=$resdata->discounted_price;
				$new_discounted_price=$resdata->discounted_price-$discount_recieved;
				$hm_discount=0;
				if($lot_type=='H')
				{
					if($resdata->re_discounted_price <=$resdata->down_payment)
					{
						$re_discounted_price=$resdata->re_discounted_price;
						$hm_discount=$discount_recieved;
						$hm_discounted_price=$resdata->hm_discounted_price-$hm_discount;
					}
					else
					{
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


			$data=array(
			'res_code'=>$resdata->res_code,
			'prj_id'=>$resdata->prj_id,
			'lot_id'=>$resdata->lot_id,
			'cus_code'=>$resdata->cus_code,
			'old_saleprice'=>$resdata->seling_price,
			'old_discount'=>$resdata->discount,
			'old_discountedprice'=>$resdata->discounted_price,
			'new_discount'=>$discount_recieved,
			'new_discountedprice'=>$resdata->discounted_price - $discount_recieved,
			//'repay_amount'=>$this->input->post('repay_amount'),
			'create_date'=>date('Y-m-d'),
			'discount_type' => 'System',
			'discount_rate' => number_format(($discount_recieved / $resdata->discounted_price) * 100,2),
			'user_id'=>$this->session->userdata('userid'),
			'resdis_comment'=>'System created discount on payment',
			'status'  => 'CONFIRMED',
			'pay_id' => $entry_id,
			'hm_discount' => $hm_discount,
			);
			$insert = $this->db->insert('re_reservdicount', $data);






			//update reservation table
			$data = array(
				//'seling_price'		=> $resdata->discounted_price,
				'discount'	    	=> $resdata->discount + $discount_recieved,
				'discounted_price'  => $new_discounted_price,
				'hm_discounted_price'  => $hm_discounted_price,
				're_discounted_price'  => $re_discounted_price,
			);
			$this->db->where('res_code',$resdata->res_code);
			$this->db->update('re_resevation', $data);


			update_unrealized_data_on_discount($resdata->res_code,$discount_recieved,$entry_id,$this->input->post('paydate1'),$hm_discount);


		}

		/*Ticket No:2889 Added By Maduhan 2021.06.14*/

		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$this->db->where('status <>','PAID');
		$this->db->order_by('installment_number');
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
		{
			$pay_amount = $advancepay;

			foreach($query->result() as $row)
			{
				$balance_amount = $existing_paid_amount = $paid_amount = 0;
				$status = "PENDING";
				if($pay_amount == 0.0 || $pay_amount < 0)
					break;

				$balance_amount = floatval($row->amount);
				$existing_paid_amount = floatval($row->paid_amount);
				if($row->paid_amount){
					$balance_amount = floatval($row->amount) - $existing_paid_amount;
				}

				if($pay_amount >= $balance_amount)
				{
					$paid_amount = $existing_paid_amount + $balance_amount;
					$status = 'PAID';
				}
				else
				{
					$paid_amount = $existing_paid_amount + floatval($pay_amount);
					$status = 'PENDING';
				}

				$data = array(

					'paid_amount'=>$paid_amount,
					'paid_date'=>$this->input->post('paydate1'),
					'status'=>$status,
				);

				$this->db->where('res_code',$res_code);
				$this->db->where('installment_number',$row->installment_number);
				$this->db->update('re_salesadvanceshedule',$data);

				$pay_amount = $pay_amount - $balance_amount;
			}
		}

		/*End of Ticket No:2889*/
		return $entry_id;

	}
	function delete_advance($id)
	{ 
		if($id)
		{
			$advancedata=$this->get_advance_byid($id);
			$discountdata=$this->get_discount_data_by_pay_id($advancedata->rct_id);
			$discount=0;
			if($discountdata)
			{
				$discount=$discountdata->new_discount;
			}
				$new_down=floatval($advancedata->down_payment)-floatval($advancedata->pay_amount);
					$outstad=floatval($advancedata->total_out)-floatval($advancedata->pay_amount);
	
					$newdiscount=$advancedata->discount-$discount;
					$new_discounted_price=$advancedata->discounted_price+$discount;
					$re_discount=$discount-$discountdata->hm_discount;
					$re_discounted_price=$advancedata->re_discounted_price+$re_discount;
					$hm_discounted_price=$advancedata->hm_discounted_price+$discountdata->hm_discount;
			/*2019-10-10 nadee ticket number 750*/
			/* update back to pending statues when receipt cancel*/
			$pay_type=$advancedata->pay_type;
			$res_status=$advancedata->res_status;
			if(round($advancedata->discounted_price)>round($new_down))
			{
			  $pay_type='Pending';
			  $res_status='PROCESSING';
			}
	
			$data=array(
				'down_payment' => $new_down,
				'total_out' =>$outstad,
				'discount' => $newdiscount,
				'discounted_price' =>$new_discounted_price,
				're_discounted_price' =>$re_discounted_price,
				'hm_discounted_price' =>$hm_discounted_price,
				 'pay_type' =>$pay_type,
				 'res_status' =>$res_status,
			);
			$this->db->where('res_code', $advancedata->res_code);
			$insert = $this->db->update('re_resevation', $data);
	
			$this->db->where('pay_id', $advancedata->rct_id);
			$insert = $this->db->delete('re_reservdicount');
			$this->db->where('id', $id);
			$insert = $this->db->delete('re_saleadvance');
			$this->db->where('id', $advancedata->rct_id);
			$insert = $this->db->delete('re_prjacincome');
			$this->db->where('pay_id', $advancedata->rct_id);
			$insert = $this->db->delete('re_arreaspayment');
			$this->db->where('refnumber', $advancedata->rct_id);
			$insert = $this->db->delete('ac_payvoucherdata');
			$this->db->where('income_id', $advancedata->rct_id);
			$insert = $this->db->delete('re_incomentires');
	
			$this->delete_pay_entires($advancedata->res_code,$advancedata->rct_id);
			$this->detelet_advance_schedule($advancedata->res_code,$advancedata->pay_amount);
		}
	}

	/*Ticket No:2889 Added By Madushan 2021.06.15*/
	function detelet_advance_schedule($res_code,$new_amount)
	{
		$advance_shedule = $this->get_advance_shedule($res_code);

		if($advance_shedule)
		{	$count = 0;
			$status = 'PENDING';
			$advance_shedule = array_reverse($advance_shedule);
			$pay_amount = $new_amount;

			foreach($advance_shedule as $row)
			{
				if($pay_amount == 0 || $pay_amount<0)
					break;
				$existing_paid_amount = floatval($row->paid_amount);
				if($existing_paid_amount){
					if($existing_paid_amount>=$pay_amount)
					   $new_paid_amount = $existing_paid_amount - $pay_amount;
					else
					   $new_paid_amount = '';
					if($row->status == 'PAID')
						$status = 'PENDING'	;

				$data = array(

					'paid_amount'=>$new_paid_amount,
					'status'=>$status,
				);

				$this->db->where('res_code',$res_code);
				$this->db->where('installment_number',$row->installment_number);
				$this->db->update('re_salesadvanceshedule',$data);

				$pay_amount = $pay_amount - $existing_paid_amount;
				}
			}
		}
	}

	/*End Of Ticket No:2889*/

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
	function get_discount_data_by_pay_id($pay_id) { //get all stock
		$this->db->select('*');
		$this->db->where('pay_id',$pay_id);
		$query = $this->db->get('re_reservdicount');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	/*function calculatePeriodInt($i,$fn,$paidca)
	{

		$balence=$fn-$paidca;
		$int=$balence*$i;
		return $int;

	}*/
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
	function add_settilemt()
	{
		$ptype = $this->input->post('pay_type'); //keep the reference for ZEPCs


		if($this->input->post('loan_subtype')!="")
		$codetype=$this->input->post('loan_subtype');
		if($this->input->post('pay_type') == 'ZEPC'){
			$paytype='ZEP';
		}else{
			$paytype=trim($this->input->post('pay_type'));
		}
		if($this->input->post('loan_subtype'))
		$codetype=$this->input->post('loan_subtype');
		else
		$codetype=$paytype;
		$res_code=$this->input->post('res_code_set');
		$resdata=$this->get_resevationdata($res_code);
		$this->db->trans_start();
		$loan_code=$this->getmaincode_loan($res_code,$resdata->branch_code,$codetype);
		if($paytype!='Outright' )
		{
			$typedata=$this->get_saletype_by_type($paytype);
			if($paytype=='EPB')
			$install=1;
			else
			$install=$this->input->post('period');
		    $futureDate=date('Y-m-d',strtotime('+'.intval($install).' months',strtotime($this->input->post('settldate'))));
			$futureDate=$this->input->post('settldate');
			$loanamount=$resdata->discounted_price-$resdata->down_payment;
			$insert_data = array(
					'unique_code' =>  $loan_code,
				'branch_code' =>$resdata->branch_code,
				'cus_code' => $resdata->cus_code,
				'res_code' =>$resdata->res_code,
				'loan_amount' => $loanamount,
				'period' =>$this->input->post('period'),
				'interest' =>$this->input->post('interest'),
				'instalments' =>$install,
				'grase_period' =>$typedata->grace_period,
				'delay_interest' =>$typedata->delay_int,
				'loan_type'=>$paytype,
				'start_date' =>$this->input->post('settldate'),
				'montly_rental'=>$this->input->post('instalments_val'),
				'collection_officer'=>$this->input->post('collection_officer'),
				'apply_date'=>date('Y-m-d'),
				'apply_by '=>$this->session->userdata('username'),
				'final_instalment'=>$this->input->post('final_amount'),
				'final_instalmentdate'=>$this->input->post('final_date'),
				'loan_subtype'=>$this->input->post('loan_subtype'),

				'end_date' =>$futureDate,
				'cap_out' =>$loanamount,
				'int_paid' =>0,

        'epb_bank' =>$this->input->post('bank1'),
				'epb_branch' =>$this->input->post('branch1'),
				'epb_contact' =>$this->input->post('contact_name'),//ticket 2985
				'epb_officer' =>$this->input->post('contact_officer'),//Ticket No:3067
			);
			if ( ! $this->db->insert('re_eploan', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return;
			}
			$loan_code = $this->db->insert_id();
			if($paytype!='EPB')
			{
				$n=intval($install);
				$fn=$loanamount-$this->input->post('final_amount');
				$totint=0;
				if(floatval($this->input->post('interest'))>0)
				{
				$i=floatval($this->input->post('interest'));
				$years=$n/12;
				$totint=$fn*$years*$i/100;
				$instalment=($fn+$totint)/$n;
			//	$instalment = $fn * $i * (pow(1 + $i, $n) / (pow(1 + $i, $n) - 1));
				}
				else $instalment=$fn/$n;
				$paidca=0;
				$balfinance=$fn;
				$futureDate=$this->input->post('settldate');
				$agreement_date=$this->input->post('settldate');
				$last_payment = $this->input->post('lastpayment');
				if($ptype=='ZEP' ){
					for($t=1; $t<=$n; $t++)
					{
						$thisint=0;//$this->calculatePeriodInt($totint,$t,$n);
						$thiscap=$this->calculatePeriodPrince($thisint,$instalment);
						$paidca=$paidca+$thiscap;
					//	$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						if($this->input->post('due_date')!='')
						{
							$datecal=$t-1;
							$newdeu_date=$this->input->post('due_date');
							$futureDate=date('Y-m-d',strtotime('+'.$datecal.' months',strtotime($newdeu_date)));

						}
						else
						$futureDate=date('Y-m-d',strtotime('+'.$t.' months',strtotime($agreement_date)));

						/*if($t==$n){

						  $insert_data = array(
						  'loan_code' =>  $loan_code,
						  'instalment ' =>$t,
						  'cap_amount' => str_replace( ',', '', $last_payment ),
						  'int_amount' =>$thisint,
						  'tot_instalment' => str_replace( ',', '', $last_payment ),
						  'deu_date' =>$futureDate,
						  );
						}else{*/
						  $instalment=$this->input->post('instalments');
						  $instalment = str_replace( ',', '', $instalment );
						  $insert_data = array(
						  'loan_code' =>  $loan_code,
						  'instalment ' =>$t,
						  'cap_amount' => $instalment,
						  'int_amount' =>$thisint,
						  'tot_instalment' => $instalment,
						  'deu_date' =>$futureDate,
						  );
						//}

						$this->db->insert('re_eploanshedule', $insert_data);
					}

				}else if($ptype=='ZEPC'){
					for($t=1; $t <= $n; $t++){
						$thiscap = $this->input->post('instalment'.$t);
						$thisint = '0.00';
						$instalment = $this->input->post('instalment'.$t);
						//$futureDate=date('Y-m-d',strtotime('+'.$t.' months',strtotime($agreement_date)));
						$futureDate = $this->input->post('instdate'.$t);
						$insert_data = array(
						'loan_code' =>  $loan_code,
						'instalment ' =>$t,
						'cap_amount' => $thiscap,
						'int_amount' =>$thisint,
						'tot_instalment' => $instalment,
						'deu_date' =>$futureDate,
						);
						$this->db->insert('re_eploanshedule', $insert_data);
					}
				}else{
					for($t=1; $t<=$n; $t++)
					{
						$thisint=$this->calculatePeriodInt($n,$instalment,$fn,$balfinance);
						$thiscap=$this->calculatePeriodPrince($thisint,$instalment);
						$balfinance=$balfinance-$thiscap;
						$paidca=$paidca+$thiscap;
					//	$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						if($this->input->post('due_date')!='')
						{
							$datecal=$t-1;
							$newdeu_date=$this->input->post('due_date');
							$futureDate=date('Y-m-d',strtotime('+'.$datecal.' months',strtotime($newdeu_date)));

						}
						else
						$futureDate=date('Y-m-d',strtotime('+'.$t.' months',strtotime($agreement_date)));

						$insert_data = array(
						'loan_code' =>  $loan_code,
						'instalment ' =>$t,
						'cap_amount' => $thiscap,
						'int_amount' =>$thisint,
						'tot_instalment' => $instalment,
						'deu_date' =>$futureDate,
						);
						$this->db->insert('re_eploanshedule', $insert_data);
					}
				}
				if($this->input->post('final_amount')>0)
				{
					//$t++;
					if($this->input->post('final_date'))
					$futureDate=$this->input->post('final_date');
					else
					$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
					$insert_data = array(
						'loan_code' =>  $loan_code,
						'instalment ' =>$t,
						'cap_amount' => $this->input->post('final_amount'),
						'int_amount' =>0,
						'tot_instalment' => $this->input->post('final_amount'),
						'deu_date' =>$futureDate,
						);
						$this->db->insert('re_eploanshedule', $insert_data);
				}

			}

		}
		else{
			$pay_seq=$this->getsequense_pay('pay_seq',$resdata->res_code,'re_saleadvance');
			$loanamount=$resdata->discounted_price-$resdata->down_payment;
			$insert_data = array(
				'res_code' =>  $resdata->res_code,
				'settle_seq' =>$pay_seq,
				'amount' => $loanamount,
				'settle_date' =>$this->input->post('settldate'),
				'create_by' => $this->session->userdata('username'),

			);
			if ( ! $this->db->insert('re_settlement', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			}

		}

		$data=array(
			'res_status' => 'COMPLETE',
			'pay_type' =>$paytype,
		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_resevation', $data);


		return $insert;
	}
	function delete_loan($id)
	{
		//$tot=$bprice*$quontity;
		if($id)
		{
			$this->db->where('loan_code', $id);
			$insert = $this->db->delete('re_eploan');
			$this->db->where('loan_code', $id);
			$insert = $this->db->delete('re_eploanshedule');
		}
		return $id;



	}
	function delete_settlment($id)
	{
		//$tot=$bprice*$quontity;
		if($id)
		{
			$settledata=$this->get_settlemnt_data($id);
			$this->db->where('res_code', $id);
			$insert = $this->db->delete('re_settlement');
			$data=array(
				'res_status' => 'PROCESSING',
				'pay_type' =>'Pending',
			);
	
			$this->db->where('res_code', $id);
			$insert = $this->db->update('re_resevation', $data);
			return $settledata->id;
		}
		else 
		return false;
		
	}
	function edit_settlment()
	{
		$paytype=trim($this->input->post('pay_type'));
		$res_code=$this->input->post('res_code_set');
		$resdata=$this->get_resevationdata($res_code);
		$loandata=$this->get_eploan_data($res_code);
		$settledata=$this->get_settlemnt_data($res_code);
		$this->db->trans_start();



		$loan_code=$loandata->loan_code;
		if($paytype!='Outright' )
		{$this->delete_loan($loandata->loan_code);
		$unique_code=$this->getmaincode_loan($res_code,$resdata->branch_code,$this->input->post('pay_type'),$this->input->post('settldate'));

			$typedata=$this->get_saletype_by_type($paytype);
			if($paytype=='EPB')
			$install=1;
			else
			$install=$this->input->post('period');
			$futureDate=date('Y-m-d',strtotime('+'.intval($install).' months',strtotime($this->input->post('settldate'))));
			$futureDate=$this->input->post('settldate');
			$loanamount=$resdata->discounted_price-$resdata->down_payment;
			$insert_data = array(
				'unique_code' =>  $unique_code,
				'branch_code' =>$resdata->branch_code,
				'cus_code' => $resdata->cus_code,
				'res_code' =>$resdata->res_code,
				'loan_amount' => $loanamount,
				'period' =>$this->input->post('period'),
				'interest' =>$this->input->post('interest'),
				'instalments' =>$install,
				'grase_period' =>$typedata->grace_period,
				'delay_interest' =>$typedata->delay_int,
				'start_date' =>$this->input->post('settldate'),
				'loan_type'=>$this->input->post('pay_type'),
				'montly_rental'=>$this->input->post('instalments_val'),
				'collection_officer'=>$this->input->post('collection_officer'),
				'end_date' =>$futureDate,
				'cap_out' =>$loanamount,
				'apply_date'=>date('Y-m-d'),
				'apply_by '=>$this->session->userdata('username'),
				'int_paid' =>0,
			);
			if ( ! $this->db->insert('re_eploan', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return;
			}
			$loan_code = $this->db->insert_id();
			if($paytype!='EPB')
			{
				$n=intval($install);
				$fn=$loanamount;
				$totint=0;
				if(floatval($this->input->post('interest'))>0)
				{
				$i=floatval($this->input->post('interest'));
				$years=$n/12;
				$totint=$fn*$years*$i/100;
				$instalment=($fn+$totint)/$n;
				}
				else $instalment=$fn/$n;
				$paidca=0;
				$futureDate=$this->input->post('settldate');
				$agreement_date=$this->input->post('settldate');
				for($t=1; $t<=$n; $t++)
				{
					$thisint=$this->calculatePeriodInt($totint,$t,$n);
					$thiscap=$this->calculatePeriodPrince($thisint,$instalment);
					$paidca=$paidca+$thiscap;
					//$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						$futureDate=date('Y-m-d',strtotime('+'.$t.' months',strtotime($agreement_date)));
					$insert_data = array(
					'loan_code' =>  $loan_code,
					'instalment ' =>$t,
					'cap_amount' => $thiscap,
					'int_amount' =>$thisint,
					'tot_instalment' => $instalment,
					'deu_date' =>$futureDate,
					);
					$this->db->insert('re_eploanshedule', $insert_data);
				}


			}

		}
		else{
			$this->delete_settlment($settledata->id);
			$pay_seq=$this->getsequense_pay('pay_seq',$resdata->res_code,'re_saleadvance');
			$loanamount=$resdata->discounted_price-$resdata->down_payment;
			$insert_data = array(
				'res_code' =>  $resdata->res_code,
				'settle_seq' =>$pay_seq,
				'amount' => $loanamount,
				'settle_date' =>$this->input->post('settldate'),
				'create_by' => $this->session->userdata('username'),

			);
			if ( ! $this->db->insert('re_settlement', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			}

		}

		$data=array(
			'res_status' => 'COMPLETE',
			'pay_type' =>$this->input->post('pay_type'),
		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_resevation', $data);


		return $insert;
	}
	function confirm_settlment($res_code)
	{
		$entry_id="";
		$settldata=$this->get_settlemnt_data($res_code);
		$resdata=$this->get_resevationdata($res_code);
		if($resdata->profit_status=='PENDING')
		$ledgerset=get_account_set('Advanced Payment');
		else
		$ledgerset=get_account_set('Advance Payment After Profit');
		$advanceCr=$ledgerset['Cr_account'];
		$advanceDr=$ledgerset['Dr_account'];

		$this->db->trans_start();
		if($settldata->amount>0)
		{
			$insert_data = array(
				'temp_code' =>  $resdata->res_code,
				'res_code' =>  $resdata->res_code,
				'pri_id' =>$resdata->prj_id,
				'cus_code' =>$resdata->cus_code,
				'lot_id' =>$resdata->lot_id,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Balance Payment',
				'amount' => $settldata->amount,
				'income_date' =>$settldata->settle_date,
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
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>$settldata->amount,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceDr,
					'dc_type' => 'D',
					'amount' =>$settldata->amount,
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
		}
				$new_down=floatval($settldata->amount)+floatval($resdata->down_payment);
				$outstad=floatval($resdata->total_out) - floatval($new_down);
		$data=array(
			'down_payment' => $new_down,
			'last_dpdate'=>$settldata->settle_date,
			'total_out' =>$outstad,
			'res_status' => 'SETTLED',
		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_resevation', $data);
			$data=array(
			'settle_status' => 'CONFIRMED',
			'entry_id'=>$entry_id

		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_settlement', $data);
	}
	function confirm_loan($res_code)
	{
		$data=array(
			'loan_status' => 'CONFIRMED',
			'confirm_date'=>date('Y-m-d'),
				'confirm_by '=>$this->session->userdata('username'),


		);
		$this->db->where('res_code', $res_code);
		$insert = $this->db->update('re_eploan', $data);
	}
	function delete_reservation_new($id)
	{
		if($id)
		{
		$resdata=$this->get_resevationdata($id);
			$this->db->where('res_code', $id);
			$insert = $this->db->delete('re_resevation');
			$this->db->where('res_code', $id);
			$insert = $this->db->delete('re_salesadvanceshedule');
			$data=array(
				'status' => 'PENDING',
	
			);
			$this->db->where('lot_id', $resdata->lot_id);
			$insert = $this->db->update('re_prjaclotdata', $data);
		}
		return $insert;


	}

/**************************************************************************************************************/
function get_resale($pagination_counter, $page_count,$branchid)
	{
		$this->db->select('re_adresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		//$this->db->join('re_prjacincome','re_prjacincome.id=re_epresale.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_adresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if(! check_access('all_branch'))
		$this->db->where('re_adresale.branch_code',$branchid);

		$this->db->limit($pagination_counter, $page_count);
			$this->db->order_by('re_adresale.apply_date','DESC');
		$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function add_resale($documents)
	{
		$res_code=$this->input->post('res_code');
		$resdata=$this->get_all_reservation_details_bycode($res_code);
		$resale_code=$this->getmaincode('resale_code','RSL','re_adresale');
			$this->db->trans_start();
		$insert_data = array(
			'resale_code' =>$resale_code,
			'branch_code' => $resdata->branch_code,
			'res_code' => $resdata->res_code,
			'cus_code' => $resdata->cus_code,
			'article_value' => $resdata->discounted_price,
			'down_payment' => $resdata->down_payment,
			'repay_total' =>$this->input->post('repay_total'),
			'apply_date'=>$this->input->post('settldate'),
			'remark'=>$this->input->post('remark'),
      'documents'=>$documents,
			'status'=>'PENDING',
			'apply_by '=>$this->session->userdata('username'),
			);
			if ( ! $this->db->insert('re_adresale', $insert_data))
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
		$this->db->delete('re_adresale');
		}

	}
	function get_resale_bycode($branchid)
	{
		$this->db->select('re_adresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.costof_sale,re_prjaclotdata.lot_id,re_resevation.discounted_price ');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		$this->db->where('re_adresale.resale_code',$branchid);

			$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		return $query->row();
		}
		else
		return 0;
	}

	function edit_resale()
	{
		$res_code=$this->input->post('res_code');
		$resdata=$this->get_all_reservation_details_bycode($res_code);

		$resale_code=$this->input->post('resale_code');
			$this->db->trans_start();
		$insert_data = array(
			'repay_total' =>$this->input->post('repay_total'),
			'remark'=>$this->input->post('remark'),
			'status'=>'PENDING',
			'apply_by '=>$this->session->userdata('username'),
			);
			$this->db->where('resale_code',$resale_code);
			if ( ! $this->db->update('re_adresale', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}


			$this->db->trans_complete();
			return $resale_code;
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
	function confirm_resale($rsch_code)
	{
		$crledger=get_account_set('EP Reprocess Pay Capital Reversal');
		$reschdata=$this->reservation_model->get_resale_bycode($rsch_code);
		$resdata=$this->get_all_reservation_details_bycode($reschdata->res_code);
		$amount=$reschdata->repay_total;
		if($reschdata->status=='PENDING')
		{
		// advance resela account transactions
		advance_resale_transfers($rsch_code);//this fucntion is in financialtransfer helper

		$insert_data = array(

				'resale_code' =>$reschdata->resale_code ,
				'total_payment' =>$amount,
				'send_date'=>date('Y-m-d'),

			);
			if ( ! $this->db->insert('re_adresalepayment', $insert_data))
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
			if ( ! $this->db->update('re_adresale', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}

			$insert_data = array(
				'res_status' =>'REPROCESS',
				'resale_date'=>date('Y-m-d')
			);
			$this->db->where('res_code',$resdata->res_code);
			if ( ! $this->db->update('re_resevation', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
			$insert_data = array(
				'status' =>'PENDING',
			);
			$this->db->where('lot_id',$resdata->lot_id);
			if ( ! $this->db->update('re_prjaclotdata', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Loan Enty.', 'error');

				return false;
			}
		}

	}
// reservation charges function list
function get_charge_list($branchid)
	{
		$this->db->select('*');
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_charges.res_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);

		$query = $this->db->get('re_charges');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}
function get_charge_data($res_code)
	{
		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$query = $this->db->get('re_charges');
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false;
	}
	function get_charge_payments($res_code)
	{

		$this->db->select('re_chargepayments.*,re_prjacincome.pay_status as status,re_prjacincome.rct_no');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_chargepayments.rct_id');
		$this->db->where('re_chargepayments.res_code',$res_code);
		$query = $this->db->get('re_chargepayments');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}

	function add_charges()
	{
		$res_code=$this->input->post('res_code_charge');
		$this->delete_charges($res_code);
		$this->db->trans_start();
		$insert_data = array(
			'res_code' =>$res_code,
			'leagal_fee' => $this->input->post('leagal_fee'),
			'document_fee' => $this->input->post('document_fee'),
			'stamp_duty' => $this->input->post('stamp_duty'),
			'other_charges' =>$this->input->post('other_charges'),
			'other_charge2' =>$this->input->post('other_charge2'),
			'opinion_fee' =>$this->input->post('opinion_fee'),
			'document_chargers' => $this->input->post('document_charge'),
			'ep_document_chargers' => $this->input->post('ep_document_chargers'),
			'added_date'=>date('Y-m-d'),
			'added_by '=>$this->session->userdata('username'),
			);
			if ( ! $this->db->insert('re_charges', $insert_data))
			{
			$this->db->trans_rollback();
			$this->messages->add('Error addding Entry.', 'error');
			return false;
			}


			$this->db->trans_complete();
			return $res_code;
	}
	function delete_charges($res_code)
	{
		if($res_code)
		{
		$this->db->where('res_code',$res_code);
		$this->db->delete('re_charges');
		}

	}
		function add_charge_payments()
	{
		$res_code=$this->input->post('res_code');
		$chage_type=$this->input->post('chage_type');
		$document_fee=$this->input->post('document_fee');
		$stamp_duty=$this->input->post('stamp_duty');
		$other_charges=$this->input->post('other_charges');
		$other_charge2=$this->input->post('other_charge2');
		$leagal_fee=$this->input->post('leagal_fee');
		$opinion_fee=$this->input->post('opinion_fee');
		$document_charge=$this->input->post('document_charge');
		$ep_document_charge=$this->input->post('ep_document_charge');

		$resdata=$this->get_resevationdata($res_code);
		$lederset=$this->get_re_ledgerset();

			$this->db->trans_start();
			$insert_data = array(
				'temp_code' =>  $resdata->res_code,
				'res_code' =>  $resdata->res_code,
				'pri_id' =>$resdata->prj_id,
				'cus_code' =>$resdata->cus_code,
				'lot_id' =>$resdata->lot_id,
				'branch_code' => $resdata->branch_code,
				'income_type' =>'Reservation Chargers',
				'amount' => $this->input->post('pay_amount'),
				'income_date' =>$this->input->post('pay_date'),
			);
			if ( ! $this->db->insert('re_prjacincome', $insert_data))
			{
				$this->db->trans_rollback();
				$this->messages->add('Error addding Entry.', 'error');

				return;
			} else {
				$entry_id = $this->db->insert_id();
			}

	 if(floatval($leagal_fee)>0){ $discrip='Legal Fee';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($leagal_fee),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'leagal_fee',
					'chage_dis' =>'Legal Fee',
					'pay_amount' =>$leagal_fee,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }
	  if(floatval($stamp_duty)>0){ $discrip='Stamp Duty';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($stamp_duty),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'stamp_duty',
					'chage_dis' =>'Stamp Duty',
					'pay_amount' =>$stamp_duty,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }
	   if(floatval($document_fee)>0){ $discrip='Draft Checking Fee';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($document_fee),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'document_fee',
					'chage_dis' =>'Draft Checking Fee',
					'pay_amount' =>$document_fee,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }
	  if(floatval($other_charges)>0){ $discrip='Plan Fee';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($other_charges),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'other_charges',
					'chage_dis' =>'Plan Fee',
					'pay_amount' =>$other_charges,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }
	   if(floatval($other_charge2)>0){ $discrip='PR Fee';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($other_charge2),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'other_charge2',
					'chage_dis' =>'P/R Fee',
					'pay_amount' =>$other_charge2,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }
		if(floatval($opinion_fee)>0){ $discrip='Opinion Fee';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($opinion_fee),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'opinion_fee',
					'chage_dis' =>'Opinion Fee',
					'pay_amount' =>$opinion_fee,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }

	 /*Ticket No:2740 Added By Madushan 2021.05.03*/
	    if(floatval($document_charge)>0){ $discrip='Documentation Charge';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($document_charge),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'document_chargers',
					'chage_dis' =>'Document Chargers',
					'pay_amount' =>$document_charge,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }

	   /*Ticket No:2740 Added By Madushan 2021.05.03*/
	    if(floatval($ep_document_charge)>0){ $discrip='EP Documentation Charge';
		 $ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceCr,
					'dc_type' => 'C',
					'amount' =>floatval($ep_document_charge),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}
				$insert_data = array(

					'res_code' =>$resdata->res_code,
					'chage_type' =>'ep_document_chargers',
					'chage_dis' =>'EP Document Chargers',
					'pay_amount' =>$ep_document_charge,
					'rct_id' => $entry_id,
					'pay_date' =>$this->input->post('pay_date'),
				);
				if ( ! $this->db->insert('re_chargepayments', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}

	 }

	 $discrip='Documentation Charge';
		$ledgerset=get_account_set($discrip);
		$advanceCr=$ledgerset['Cr_account'];
		$advanceDr=$ledgerset['Dr_account'];



			//Document Fee insert

				$insert_data = array(
					'income_id' => $entry_id,
					'ledger_id' =>$advanceDr,
					'dc_type' => 'D',
					'amount' =>$this->input->post('pay_amount'),
				);
				if ( ! $this->db->insert('re_incomentires', $insert_data))
				{
					$this->db->trans_rollback();
					$this->messages->add('Error addding Entry.', 'error');

				return;
				}




		return $entry_id;
	}
	function get_charge_payment_byid($res_code)
	{
		$this->db->select('*');
		$this->db->where('id',$res_code);
		$query = $this->db->get('re_chargepayments');
		 if ($query->num_rows >0) {
            return $query->row();
        }
		else
		return false;
	}
	function delete_charge_payment($id)
	{
		$advancedata=$this->get_charge_payment_byid($id);
				$this->db->where('id', $id);
		$insert = $this->db->delete('re_chargepayments');
		$this->db->where('id', $advancedata->rct_id);
		$insert = $this->db->delete('re_prjacincome');
		$this->db->where('income_id', $advancedata->rct_id);
		$insert = $this->db->delete('re_incomentires');

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


	 function getmaincode_branchshortcode($idfield,$prifix,$table,$branchcode)
    {
       // $date=$this->config->item('account_fy_start');
	  // echo $this->session->userdata('shortcode');
	  
	   $query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table);

        $newid="";
		$resid=0;
        if ($query->num_rows > 0) {
            $data = $query->row();
            $prjid=$data->id;
			 $resid=intval($prjid)+1;
		}
		else
		$resid=1;
	  
	  
		$prifix='HED';
        $query = $this->db->query("SELECT MAX(res_number) as id  FROM ".$table);

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
		$idfields=array($resid,$newid);
        return $idfields;
   }

	function getsequense($res_seq,$where,$table)
	{
		 $query = $this->db->query("SELECT MAX(".$res_seq.") as id  FROM ".$table." where  	lot_id='".$where."'");

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
	function delete_loan_rescode($id)
	{
		$data=$this->get_eploan_data($id);
		$this->delete_loan($data->loan_code);
		$data=array(
			'res_status' => 'PROCESSING',
			'pay_type' =>'Pending',
		);
		$this->db->where('res_code', $id);
		$insert = $this->db->update('re_resevation', $data);
	}
	function get_all_reservation_summery_resale($branchid) { //get all stock
	$status = array('PROCESSING','SETTLED');
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code','left');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		//$this->db->where('re_resevation.pay_type','Pending');    //Ticket No-2753|Added By Uvini
		//$this->db->or_where('re_resevation.pay_type','Outright'); //Ticket No-2753|Added By Uvini
		//$this->db->where('re_resevation.res_status !=','COMPLETE');
		$query = $this->db->get('re_resevation');
		return $query->result();
    }
	function update_receipt_customer($id,$cus_code2)
	{
		$data=array(
			'cus_code2' => $cus_code2,

		);
		$this->db->where('res_code', $id);
		$insert = $this->db->update('re_resevation', $data);
	}
	function get_reciept_customer($res_code)
	{
		$resdata=$this->get_all_reservation_details_bycode($res_code);
		$cus_code=$resdata->cus_code;
		if($resdata->cus_code2)
		$cus_code=$resdata->cus_code2;
		return $cus_code;
	}
	function get_customer_refund($res_code)
	{
		$this->db->select('re_arreaspayment.*,ac_payvoucherdata.status,ac_payvoucherdata.applydate,ac_chqprint.CHQNO');
		$this->db->where('res_code',$res_code);
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_arreaspayment.voucher_id');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');

		$query = $this->db->get('re_arreaspayment');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}

	function update_discount($res_code)
	{

		$resdata=$this->get_all_reservation_details_bycode($res_code);
		$data=array(
		'res_code'=>$resdata->res_code,
		'prj_id'=>$resdata->prj_id,
		'lot_id'=>$resdata->lot_id,
		'cus_code'=>$resdata->cus_code,
		'old_saleprice'=>$resdata->seling_price,
		'old_discount'=>0,
		'old_discountedprice'=>$resdata->seling_price,
		'new_discount'=>$resdata->discount,
		'new_discountedprice'=>$resdata->discounted_price,
		'repay_amount'=>0,
		'create_date'=>date('Y-m-d'),
		'discount_type' => 'Manual',
		'discount_rate' => number_format(($resdata->discount/ $resdata->discounted_price) * 100,2),
		'user_id'=>$this->session->userdata('userid'),
		'resdis_comment'=>$resdata->discount_remarks,
		'status' => 'CONFIRMED',

		);
		$insert = $this->db->insert('re_reservdicount', $data);
		$entry_id = $this->db->insert_id();
		return $entry_id;
	}


	function get_payment_entires($id)
	{
		$this->db->select('*');
		$this->db->where('pay_id',$id);
		$query = $this->db->get('re_paymententries');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;


	}
	function delete_pay_entires($res_code,$id)
	{

		$data=$this->get_payment_entires($id);
		$reseavation_data=$this->get_all_reservation_details_bycode($res_code);
		delete_unrealized_sale($res_code,$id);
			//echo $paymentdata->id;
			$this->db->trans_start();
			if($data){
			foreach($data as $raw)
			{

				$entry_id=$raw->entry_id;
				if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
       			{
         		   $this->db->trans_rollback();
            	}
		   		if ( ! $this->db->delete('ac_entries', array('id' => $entry_id)))
        		{
          		  $this->db->trans_rollback();
          		}
				if($raw->type=='Cost Trasnfer')
				{
						$insert_data=array('status'=>'RESERVED');
						$this->db->where('lot_id',$reseavation_data->lot_id);
						if ( ! $this->db->update('re_prjaclotdata', $insert_data))
						{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');

						 return;
						}

							 $insert_data=array('profit_status'=>'PENDING');
						$this->db->where('res_code',$reseavation_data->res_code);
						if ( ! $this->db->update('re_resevation', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');

						 return;
							 }

				}

			}
			}
	}

	/*Ticket No:2901 Added By Madushan 2021.06.09*/
	function updateDeedTransfer($rescode,$checkedVal)
	{
		$data = array(
			'deed_transfer_status' => $checkedVal
		);
		$this->db->where('res_code',$rescode);
		$this->db->update('re_resevation',$data);
	}

	/*Ticket No:2889 Added by Madushan 2021.06.14*/
	function get_advance_payments_due($res_code,$date)
	{
		$this->db->select_sum('amount');
		$this->db->where('res_code',$res_code);
		$this->db->where('due_date <=',$date);
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
			return $query->row()->amount;
		else
			return 0;


	}

	function get_advance_shedule($res_code)
	{
		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$this->db->order_by('installment_number');
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
			return $query->result();
		else
			return false;
	}
	/*End of Ticket No:2889*/

	/*Ticket No:2975 Added By Madushan 2021.06.28*/
function get_resale_lots()
{
	$this->db->select('re_resevation.*,re_projectms.project_name,re_prjaclotdata.lot_number');
	$this->db->join('re_projectms','re_projectms.prj_id = re_resevation.prj_id');
	$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = re_resevation.lot_id');
	$this->db->where('res_status','REPROCESS');
	$query = $this->db->get('re_resevation');
	if($query->num_rows>0)
		return $query->result();
	else
		return false;
}

function allow_to_transfer($res_code,$type)
{
	$this->db->select($type);
	$this->db->where('res_code',$res_code);
	$query = $this->db->get('re_charges');
	if($query->num_rows >0){
		
			$this->db->select('pay_amount');
			$this->db->where('chage_type',$type);
			$this->db->where('res_code',$res_code);
			$query2 = $this->db->get('re_chargepayments');
			if($query2->num_rows>0)
				return false;
			else
				return true;
		
	}
	else
	{
		return false;
	}
}

function trasfer_chargers($type,$from_res_code,$to_res_code){
	$data = array(
		'res_code'=>$to_res_code
	);
	$this->db->where('res_code',$from_res_code);
	$this->db->where('chage_type',$type);
	$this->db->update('re_chargepayments',$data);
}

function add_transfer($type,$from_res_code,$to_res_code,$val,$transfer_id)
{
	$data = array(
		'transfer_id'=>$transfer_id,
		'to'=>$to_res_code,
		'from'=>$from_res_code,
		'charge_type'=>$type,
		'value'=>$val,
		'date'=>date('Y-m-d')
	);

	$this->db->insert('re_transferchargers',$data);
}

function add_transfer_data($from_res_code,$to_res_code)
{
	$data = array(
		'from_res'=>$from_res_code,
		'to_res'=>$to_res_code,
		'date'=>date('Y-m-d'),
		'transfer_by'=>$this->session->userdata('username'),
		'status'=>'PENDING'
	);

	$this->db->insert('re_transferchargersms',$data);
	$id = $this->db->insert_id();
	return $id;
}

function get_transfer_list(){
	$this->db->select('*');
	$this->db->order_by('date','DESC');
	$query = $this->db->get('re_transferchargersms');
	if($query->num_rows>0)
		return $query->result();
	else
		return false;
}

function get_transfer_data($transfer_id){
	$this->db->select('*');
	$this->db->where('transfer_id',$transfer_id);
	$query = $this->db->get('re_transferchargers');
	if($query->num_rows>0)
		return $query->result();
	else
		return false;
}

function confirm_transfer($transfer_id)
{
	$data = array(
		'confirm_by'=>$this->session->userdata('username'),
		'confirm_date'=>date('Y-m-d'),
		'status'=>'CONFIRMED'
	);
	$this->db->where('id',$transfer_id);
	$this->db->update('re_transferchargersms',$data);
}

function delete_transfer($transfer_id)
{
	$this->db->where('transfer_id',$transfer_id);
	$this->db->delete('re_transferchargers');

	$this->db->where('id',$transfer_id);
	$this->db->delete('re_transferchargersms');
}
/*End Of Ticket No:2975*/
}
