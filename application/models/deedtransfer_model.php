<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class deedtransfer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_deedtranfers_by_type() {
		$this->db->select('re_deedtrn.id,re_deedtrn.form_status,re_deedtrn.deed_status,re_deedtrn.handover_status,re_resevation.discounted_price,re_projectms.project_name,cm_customerms.id_number,cm_customerms.cus_code,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_projectms.prj_id,re_resevation.lot_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_deedtrn.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
        $this->db->order_by('re_deedtrn.create_date','DESC');

		$query = $this->db->get('re_deedtrn');
		return $query->result();
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
	function get_project_sold_lots($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		/*Ticket No:2901 Updated By Madushan 2021.06.09*/
		$this->db->where('status <>','PENDING');
		$this->db->order_by('lot_number');

		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata');
		return $query->result();
    }
	function get_leagal_officer_list() {
	$status = array('13', '14','32');//get all stock
		$this->db->select('hr_empmastr.*');

		$this->db->order_by('initial');
		$this->db->where('hr_empmastr.status','A');
		//$this->db->where_in('hr_empmastr.designation',$status);
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
	function get_deedtranfers_data_byid($prj_id,$lot_id)
	{
		$this->db->select('*');

		$this->db->where('prj_id',$prj_id);
		$this->db->where('lot_id',$lot_id);
		$query = $this->db->get('re_deedtrn');
		 if ($query->num_rows >0) {
          	 return $query->row();
        }
		else
		return false;
	}
	function get_project_plannumber($code,$plan_sq) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		$this->db->where('plan_sq',$plan_sq);
			$query = $this->db->get('re_prjacblockplane');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;

    }


	function add($file_name)
	{
		//$tot=$bprice*$quontity;
		$outside_lawyer='NO';
		if($this->input->post('outside_lawyer'))
		$outside_lawyer='YES';
		$data=array(
		'res_code'=>$this->input->post('res_code'),
		'prj_id'=>$this->input->post('prj_id'),
		'lot_id'=>$this->input->post('lot_id'),
		'cus_code'=>$this->input->post('cus_code'),
		'trn_name1'=>$this->input->post('trn_name1'),
		'trn_name2'=>$this->input->post('trn_name2'),
		'trn_name3'=>$this->input->post('trn_name3'),
    'trn_nic1'=>$this->input->post('trn_nic1'),
		'trn_nic2'=>$this->input->post('trn_nic2'),
		'trn_nic3'=>$this->input->post('trn_nic3'),
		'address1'=>$this->input->post('address1'),
		'address2'=>$this->input->post('address2'),
		'address3'=>$this->input->post('address3'),
		'legal_officer'=>$this->input->post('legal_officer'),
		'language'=>$this->input->post('language'),
		'Affidavit'=>$file_name,
		'outside_lawyer'=>$outside_lawyer,
		'create_date'=>date('Y-m-d'),
		'create_by'=>$this->session->userdata('userid'),

		);
		$insert = $this->db->insert('re_deedtrn', $data);
		$entry_id = $this->db->insert_id();
		return $entry_id;
		//echo $letter_type;
	}
	function update_transfer($file_name)
	{
		//$tot=$bprice*$quontity;
		$outside_lawyer='NO';
		if($this->input->post('outside_lawyer'))
		$outside_lawyer='YES';
		$data=array(
		'trn_name1'=>$this->input->post('trn_name1'),
		'trn_name2'=>$this->input->post('trn_name2'),
		'trn_name3'=>$this->input->post('trn_name3'),
    'trn_nic1'=>$this->input->post('trn_nic1'),
		'trn_nic2'=>$this->input->post('trn_nic2'),
		'trn_nic3'=>$this->input->post('trn_nic3'),
		'address1'=>$this->input->post('address1'),
		'address2'=>$this->input->post('address2'),
		'address3'=>$this->input->post('address3'),
		'language'=>$this->input->post('language'),
		'fin_remark'=>$this->input->post('fin_remark'),
		'outside_lawyer'=>$outside_lawyer,
		'Affidavit'=>$file_name,
		'legal_officer'=>$this->input->post('legal_officer'),

		);
		$this->db->where('id',$this->input->post('id'));
		$insert = $this->db->update('re_deedtrn', $data);
		return $insert;
		//echo $letter_type;
	}
	function upload_cuscopy($file)
	{
		//$tot=$bprice*$quontity;
		$data=array(
		'scan_copy'=>$file,

		);
		$this->db->where('id',$this->input->post('id'));
		$insert = $this->db->update('re_deedtrn', $data);
		return $insert;
		//echo $letter_type;
	}

	function confirm_transfer($id)
	{
		//$tot=$bprice*$quontity;
		$data=array(

		'form_confirm_date'=>date('Y-m-d'),
		'form_confirm_by'=>$this->session->userdata('userid'),
		'form_status'=>'CONFIRMED',

		);
		$this->db->where('id',$id);
		$insert = $this->db->update('re_deedtrn', $data);
		return $insert;
		//echo $letter_type;
	}

		function update_deeddata()
	{
		//$tot=$bprice*$quontity;
		$data=array(
		'deed_number'=>$this->input->post('deed_number'),
		'plan_number'=>$this->input->post('plan_number'),
		'deed_date'=>$this->input->post('deed_date'),
		'landr_date'=>$this->input->post('landr_date'),
		'rcv_date'=>$this->input->post('rcv_date'),
		'handover_date'=>$this->input->post('handover_date'),
		'attest_by'=>$this->input->post('attest_by'),
		'day_book_no'=>$this->input->post('day_book_no'),
		'register_portfolio'=>$this->input->post('register_portfolio'),
		'informed_method'=>$this->input->post('informed_method'),
		'informed_date'=>$this->input->post('informed_date'),
		'issue_date'=>$this->input->post('issue_date'),
		'issue_to'=>$this->input->post('issue_to'),
		'remark'=>$this->input->post('remark'),
		'inform_by'=>$this->session->userdata('userid'),

		'deed_status'=>'UPDATED',

		);
		$this->db->where('id',$this->input->post('id'));
		$insert = $this->db->update('re_deedtrn', $data);
		return $insert;
		//echo $letter_type;
	}
	function confirm_deed($id)
	{
		//$tot=$bprice*$quontity;
		$data=array(

		'deed_status'=>'CONFIRMED',

		);
		$this->db->where('id',$id);
		$insert = $this->db->update('re_deedtrn', $data);
		return $insert;
		//echo $letter_type;
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

	function get_deedtranfers_data_res_code($res_code)
	{
		$this->db->select('*');

		$this->db->where('res_code',$res_code);

		$query = $this->db->get('re_deedtrn');
		 if ($query->num_rows >0) {
          	 return $query->row();
        }
		else
		return false;
	}
}
