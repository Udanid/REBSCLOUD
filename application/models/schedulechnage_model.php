<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schedulechnage_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function shift_shedule() { //get all stock
	
		$data =array('shift_date'=>$this->input->post('shift_date'),
		'months'=>$this->input->post('months'),
		'create_by'=>$this->session->userdata('userid'),
		'create_date'=>date('Y-m-d'));
		$holiday=$this->input->post('shift_date');
		$month=$this->input->post('months');
		$insert = $this->db->insert('re_scheduleshift', $data);
	   $insertid=$this->db->insert_id();
	   $shedulellist=$this->get_futurre_instalments($holiday);
	   if($shedulellist){
		   foreach($shedulellist as $raw)
		   {
			   $duedate=$raw->deu_date;
			   $duedate=date('Y-m-d',strtotime('+'.$month.' months',strtotime($duedate))
			   );
			  
						 
			   $dataarr=array('deu_date'=>$duedate);
			   $this->db->where('id',$raw->id);
			   $this->db->update('re_eploanshedule', $dataarr);
		   }
   	 }
	 return $insertid;
	}
	function get_futurre_instalments($date) { //get all stock
		$this->db->select('re_eploanshedule.*');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
		$this->db->where('re_eploanshedule.deu_date >=',$date);
		$this->db->where('re_eploan.loan_status ','CONFIRMED');
		$query = $this->db->get('re_eploanshedule');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_update_reciept_entires() { //get all stock
		$this->db->select('ac_entry_items.*');
		$this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id');
		$this->db->where('ac_entry_items.ledger_id','HEDBA16010000');
		$this->db->where('ac_entries.entry_type',1);
		$query = $this->db->get('ac_entries');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->result();
			foreach($data as $raw)
			{
				$dataarr=array('ledger_id'=>'HEDBA16020000');
			   $this->db->where('id',$raw->id);
			   $this->db->update('ac_entry_items', $dataarr);
			}
		}
		else
		return false;
    }
	function get_update_cancel_entires() { //get all stock
		$this->db->select('ac_entry_items.*');
		$this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id');
		$this->db->where('ac_entry_items.ledger_id','HEDBA16010000');
		$this->db->where('ac_entries.entry_type',5);
		$query = $this->db->get('ac_entries');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->result();
			foreach($data as $raw)
			{
				$dataarr=array('ledger_id'=>'HEDBA16020000');
			   $this->db->where('id',$raw->id);
			   $this->db->update('ac_entry_items', $dataarr);
			}
		}
		else
		return false;
    }
	function get_update_jurnal_entires() { //get all stock
		$this->db->select('ac_entry_items.*');
		$this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id');
		$this->db->where('ac_entry_items.ledger_id','HEDBA16010000');
		$this->db->where('ac_entries.entry_type',4);
		$query = $this->db->get('ac_entries');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->result();
			foreach($data as $raw)
			{
				$dataarr=array('ledger_id'=>'HEDBL34000100');
			   $this->db->where('id',$raw->id);
			   $this->db->update('ac_entry_items', $dataarr);
			}
		}
		else
		return false;
    }
	function get_last_payment_date($loan_code)
	{	$this->db->select('MAX(income_date) as lastdate');
		$this->db->where('re_prjacincome.temp_code',$loan_code);

		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return $data->lastdate;

		}
		else
		return 0;
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
function untreansfer_settlement() { //get all stock

		$this->db->select('re_resevation.*');
				$this->db->where('re_resevation.res_status','SETTLED');
					$query = $this->db->get('re_resevation'); 
		if ($query->num_rows() > 0){
				$dataset=$query->result();
				foreach($dataset as $reseavation_data)
				{
					$date=$this->get_last_payment_date($reseavation_data->res_code);
					if($reseavation_data->profit_status=='PENDING')
					{
						//sale Transfer
						echo $reseavation_data->res_code.'<br>';
						$lot_data=$this->get_lotdata($reseavation_data->lot_id);
					$ledgerset=get_account_set('Transfer Sale');
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$reseavation_data->discounted_price;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$reseavation_data->discounted_price;
					$narration = $reseavation_data->res_code.'  sale Trasnfer  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
							//$this->insert_pay_enties($id,$int_entry,'Sale Trasnfer');
					//Cost Transfer
					$ledgerset=get_account_set('Transfer Cost');
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$lot_data->costof_sale;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$lot_data->costof_sale;
					$narration = $reseavation_data->res_code.' Cost  Trasnfer  '  ;
					$int_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$reseavation_data->prj_id,$reseavation_data->lot_id,$reseavation_data->res_code);
							 $insert_data=array('profit_status'=>'TRANSFERD','profit_date'=>date('Y-m-d'));
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
		else
		return false;
    }
}
