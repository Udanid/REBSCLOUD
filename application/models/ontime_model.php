<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Financialtransfer_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->model("reservation_model");
		$this->load->model("eploan_model");
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
	function re_epreschedule() { //get all stock
		$this->db->select('re_resevation.*,re_resevation.prj_id,re_resevation.lot_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_epreschedule.res_code');
		$query = $this->db->get('re_epreschedule'); 
		if ($query->num_rows() > 0){
		$dataset= $query->result();
			foreach($dataset as $raw)
			{
			//	$eploannedata=$this->eploan_model->get_eploan_data($raw->loan_code);
				$ptype = $raw->new_type; //keep the reference for ZEPCs

				if($ptype == 'ZEPC'){
					$paytype='ZEP';
				}else{
					$paytype=$ptype;
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
				if($raw->prev_type=='ZEP'){
				$ledgerset=get_account_set('ZEP Creation');
				$craccount=$ledgerset['Dr_account'];
				}
				if($raw->prev_type=='EPB'){
				$ledgerset=get_account_set('EPB Creation');
				$craccount=$ledgerset['Dr_account'];
				}
				if($raw->prev_type=='NEP'){
				$ledgerset=get_account_set('EP creation');
				$craccount=$ledgerset['Dr_account'];
				}
				$this->db->select('ac_entry_items.*,ac_entries.narration');
				$this->db->join('ac_entries','ac_entries.id=ac_entries.entry_id');
				$this->db->where('ac_entries.date',$raw->confirm_date.' 00:00:00');
				$this->db->where('ac_entries.narration','Rechedule sale  Trasnfer','both');
				$this->db->where('ac_entries.prj_id',$raw->prj_id);
				$this->db->where('ac_entries.lot_id',$raw->lot_id);
				$query = $this->db->get('ac_entry_items'); 	
				if ($query->num_rows() > 0){
				$dataset1= $query->result();
					foreach($dataset1 as $raw1)
					{ 
					  echo $raw1->narration.'--'.$raw->loan_code.'--'.$paytype.'---'.$raw->prev_type.'<br>';
					   echo $draccount.'-----'.$craccount.'<br><br>';
					}
				}
				
			}
		}
		else
		return false;
    }
}