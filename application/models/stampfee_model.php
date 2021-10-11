<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class stampfee_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
		function get_stampfee_request_list() {
		$this->db->select('re_charge_stampfee.*,re_resevation.discounted_price,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_projectms.prj_id,re_resevation.lot_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_charge_stampfee.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->where('re_charge_stampfee.status','PENDING');
        $this->db->order_by('re_resevation.prj_id');
		

		$query = $this->db->get('re_charge_stampfee'); 
		return $query->result(); 
    }
	function get_stampfee_paidlist_list() {
		$this->db->select('re_charge_stampfee.*,re_resevation.discounted_price,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_projectms.prj_id,re_resevation.lot_id,ac_payvoucherdata.status as paystatus,ac_chqprint.CHQNO');
		$this->db->join('re_resevation','re_resevation.res_code=re_charge_stampfee.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_charge_stampfee.voucher_id');
		$this->db->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid','left');
		$this->db->where('re_charge_stampfee.status','APPROVED');
        $this->db->order_by('re_charge_stampfee.id','DESC');
		

		$query = $this->db->get('re_charge_stampfee'); 
		return $query->result(); 
    }
	function get_stampfeeoaidlist_list($branchid)
	{
		$this->db->select('*');
		$this->db->select('re_charges.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,SUM(re_chargepayments.pay_amount) as stampfee_paidtot,re_resevation.branch_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_charges.res_code');
		$this->db->join('re_chargepayments','re_chargepayments.res_code=re_charges.res_code and re_chargepayments.chage_type="stamp_duty"','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->group_by('re_chargepayments.res_code');

	//	if(! check_access('all_branch'))
		$this->db->where('re_resevation.prj_id',$branchid);
	
		$query = $this->db->get('re_charges'); 
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false; 
	}
	function get_leagal_officer_list() { 
	$status = array('13', '14','32');//get all stock
		$this->db->select('hr_empmastr.*');
	
		$this->db->order_by('initial');
		$this->db->where('hr_empmastr.status','A');
		$this->db->where_in('hr_empmastr.designation',$status);
		$query = $this->db->get('hr_empmastr'); 
		return $query->result(); 
    
		
    }
	function get_all_project_confirmed($branchid) { //get all stock
		$this->db->select('re_projectms.project_name,re_projectms.prj_id,re_projectms.project_code,re_projectms.selable_area,re_projectms.price_status,re_projectms.status,hr_empmastr.surname,hr_empmastr.initial');
		if(! check_access('all_branch'))
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_projectms.status',CONFIRMKEY);;
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code','left');
		$this->db->order_by('re_projectms.prj_id');
		$query = $this->db->get('re_projectms'); 
		return $query->result(); 
    }
	function get_stampfee_request($res_code)
	{
		$this->db->select('*');
		
		$this->db->where('res_code',$res_code);
		$query = $this->db->get('re_charge_stampfee'); 
		 if ($query->num_rows >0) {
          	 return $query->row();
        }
		else
		return false; 
	}
	function approved_request()
	{	 $total=0;
			$ledgerset=get_account_set('Stamp Duty');
			$advanceCr=$ledgerset['Cr_account'];
			$advanceDr=$ledgerset['Dr_account'];
			$list=$this->get_stampfee_request_list();
			$amount=$this->input->post('total');
			$paymentdes=$this->input->post('paymentdes');
		 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
					$voucherid=$idlist[0];
		$data=array( 
		'voucherid'=>$voucherid,
		'vouchercode'=>$idlist[1],
		'branch_code' => $this->session->userdata('branchid'),
		'ledger_id' =>$advanceCr,
		'payeename' => 'Cash' ,
		'vouchertype' => '9',
		'paymentdes' => $paymentdes,
		'amount' => $amount,
		'applydate' =>date('Y-m-d'),
		'status' => 'CONFIRMED',
		
		);
		if(!$this->db->insert('ac_payvoucherdata', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
			if($list)
			{
				foreach($list as $raw)
				{
					if($this->input->post('isselect'.$raw->id)=="Yes")
					{
						
						$data=array( 
						'status'=>'APPROVED' ,
							'paid_rctno'=>$this->input->post('paid_rctno'),
							'voucher_id'=>$voucherid,
						'approve_date'=>date('Y-m-d'),
						'approved_by'=>$this->session->userdata('userid'),
		
							);
						$this->db->where('id',$raw->id);
						$insert = $this->db->update('re_charge_stampfee', $data);
						$this->common_model->delete_notification('re_charge_stampfee',$raw->id);
					}
				}
			}
		
		
		// if($this->input->post('isselect'.$i)=="Yes")
	}
	function delete_request($id)
	{
		//$tot=$bprice*$quontity; 
		
		$this->db->where('id',$id);
		$insert = $this->db->delete('re_charge_stampfee', $data);
		return $insert;
		//echo $letter_type;
	}
	
	function add()
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'res_code'=>$this->input->post('res_code'),
		'cus_code'=>$this->input->post('cus_code'),
		
		'full_amount'=>$this->input->post('full_amount'),
		'paid_amount'=>$this->input->post('paid_amount'),
		'paid_date'=>$this->input->post('paid_date'),
		'paid_rctno'=>$this->input->post('paid_rctno'),
		'need_date'=>$this->input->post('need_date'),
		'request_date'=>date('Y-m-d'),
		'request_by'=>$this->session->userdata('userid'),
		
		);
		$insert = $this->db->insert('re_charge_stampfee', $data);
		$entry_id = $this->db->insert_id();
		return $entry_id;
		//echo $letter_type;
	}
		
	function loan_paid_amounts($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->where('loan_code',$loancode);
		$this->db->where('pay_date <=',$deu_date);
			$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
	function get_all_blocklist($prj_id) {
		$this->db->select('re_prjaclotdata.lot_number,re_projectms.project_name,re_charge_stampfee.full_amount,re_charge_stampfee.need_date,re_charge_stampfee.approve_date,cm_customerms.last_name,re_deedtrn.form_confirm_date,re_deedtrn.attest_by,re_deedtrn.deed_date,re_deedtrn.deed_number,re_deedtrn.landr_date,re_deedtrn.day_book_no,re_deedtrn.register_portfolio,re_deedtrn.rcv_date,re_deedtrn.inform_by,re_deedtrn.informed_date,re_deedtrn.informed_method,re_deedtrn.issue_date,re_deedtrn.issue_to,re_deedtrn.legal_officer,re_deedtrn.remark,ac_chqprint.CRDATE as paymend_dondate,re_charges.stamp_duty');
			$this->db->join('re_resevation','re_resevation.lot_id=re_prjaclotdata.lot_id and re_resevation.res_status != "REPROCESS"','left');
		$this->db->join('re_deedtrn','re_deedtrn.res_code=re_resevation.res_code','left');
		$this->db->join('re_charge_stampfee','re_charge_stampfee.res_code=re_resevation.res_code','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code','left');
			$this->db->join('re_charges','re_charges.res_code=re_resevation.res_code','left');
			$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_charge_stampfee.voucher_id','left');
		$this->db->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid','left');
	
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjaclotdata.prj_id');
	if($prj_id!='ALL')
		$this->db->where('re_prjaclotdata.prj_id',$prj_id);
		
        $this->db->order_by('re_prjaclotdata.prj_id,re_prjaclotdata.lot_id');
		

		$query = $this->db->get('re_prjaclotdata'); 
		return $query->result(); 
    }
	
}