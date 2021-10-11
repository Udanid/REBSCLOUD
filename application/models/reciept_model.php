<?php

class Reciept_model extends CI_Model {

    function Reciept_model()
    {
        parent::__construct();
    }

    function add_recieptbook()
    {
        $CI =& get_instance();
        $data=array(
            "RCTBNO"=>$this->input->post('RCTBNO'),
            "RCTBSNO"=>$this->input->post('RCTBSNO'),
            "RCTBNNO"=>$this->input->post('RCTBNNO'),
            "RCTBCRDATE"=>date("Y-m-d"),
            "RCTSTATUS"=>$this->input->post('RCTSTATUS'),
            "CRBY"=>$CI->session->userdata('user_name'),
            "branch_code"=>$this->input->post('branch_code'));
        $this->db->insert('ac_recieptbookdata', $data);
    }
    function edit_recieptbook()
    {
        $data=array(

            'RCTBNO' => $this->input->post('RCTBNO'),
            'RCTBSNO' => $this->input->post('RCTBSNO'),
            'RCTBNNO' => $this->input->post('RCTBNNO'),
            'RCTSTATUS' => $this->input->post('RCTSTATUS'),
            "RCTBCRDATE"=>date("Y-m-d"),
            "CRBY"=>$this->session->userdata('userid'));

        $this->db->where('RCTBID', $this->input->post('RCTBID'));
        $insert = $this->db->update('ac_recieptbookdata', $data);
        return $insert;

    }
    function delete_recieptbook($id)
    {
		if($id)
		{
			$this->db->where('RCTBID',$id);
	
			$this->db->delete('ac_recieptbookdata');
		}
    }
    function get_recieptbook($branchid)
    {
        $this->db->select('*');
        $this->db->from('ac_recieptbookdata');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$branchid);
         $this->db->where('RCTSTATUS !=','FINISH');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_recieptbook_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('ac_recieptbookdata');
        $this->db->where('RCTBID',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
    function get_recipt_sequence($no,$branch)
    {
        $this->db->select('RCTBNNO');
        $this->db->from('ac_recieptbookdata');
        $this->db->where("RCTBNNO >= '".$no."' ");
		$this->db->where("branch_code",$branch);



        $query = $this->db->get();

        if ($query->num_rows() > 0){

            return true;
        }else
            return false;
    }
    function get_recipt_bundle($no)
    {
        $this->db->select('*');
        $this->db->from('ac_recieptbookdata');
        $this->db->where('RCTBNO',$no);

        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return true;
        }else
            return false;
    }
    function get_start_recipt_bundle($branch_code)
    {
        $this->db->select('*');
        $this->db->from('ac_recieptbookdata');
        $this->db->where('RCTSTATUS','START');
        $this->db->where('branch_code',$branch_code);

        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
    function change_bookstat($id,$stat,$statby)
    {
        if($stat=="START")
        {
            $data=array(
                "RCTSTATUS"=>$stat,
                "RCTSNBY"=>$statby,
                "RCTSTDATE"=>date("Y-m-d H:i:s"));
        }
        else
        {
            $data=array(
                "RCTSTATUS"=>$stat,
                "RCTEBY"=>$statby,
                "RCTENDDATE"=>date("Y-m-d H:i:s"));
        }
        $this->db->where('RCTBID',$id);

        $this->db->update('ac_recieptbookdata', $data);
    }
    function is_max_reciept_id($book_id){
        $this->db->select_max('RCTNO');
        $this->db->where('RCTBID',$book_id);
        $query = $this->db->get('ac_recieptdata');
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
    function is_last_reciept($no,$bookid)
    {
        $this->db->select('RCTBNNO');
        $this->db->where('RCTBNNO',$no);
		 $this->db->where('RCTBID',$bookid);
        $query = $this->db->get('ac_recieptbookdata');
        if ($query->num_rows() > 0){
            return true;
        }else
            return false;
    }
    function get_ac_recieptdata($ref_id){
        $this->db->select('*');
        $this->db->where('RCTREFNO',$ref_id);
        $query = $this->db->get('ac_recieptdata');
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
	 function get_ac_incomedata($ref_id){
        $this->db->select('*');
        $this->db->where('entry_id',$ref_id);
        $query = $this->db->get('re_prjacincome');
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
    function add_reciept($data)
    {
        $data=$this->db->insert('ac_recieptdata', $data);
        return $data;
    }
    function get_ac_recievabletype()
    {
        $this->db->select('*');
        $this->db->from('ac_recievabletype');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_reciepttransaction($entryid)
    {
        $this->db->select('*');
        $this->db->from('ac_trnreceipts');
        $this->db->where('entryid',$entryid);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
    function get_Chequedata($entryid)
    {
        $this->db->select('*');

        $this->db->from('ac_chqdata');
        $this->db->where('ENTRYCODE',$entryid);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }

    //ticket no:2900
	/*Ticket No:3098 Updated By Madushan 2021-07-14*/
	function get_receipt_range($branch_id,$start_date,$end_date,$payment_mode = 'all'){
		$this->db->select('ac_recieptdata.RCTNO,ac_recieptdata.RCTSTATUS,ac_recieptdata.CRDATE,ac_entries.dr_total,ac_recieptdata.RCTREFNO,ac_entries.entry_type,ac_entries.date,ac_entries.narration,ac_entries.prj_id,ac_entries.lot_id,ac_trnreceipts.rcvname,ac_entries.module,ac_trnreceipts.temp_rctno,ac_trnreceipts.rcvmode,ac_chqdata.CHQNO,ac_recieptbookdata.branch_code,cm_userdata.USRNAME,hr_empmastr.display_name');
        $this->db->join('cm_userdata','cm_userdata.USRID=ac_recieptdata.CRBY','left');
         $this->db->join('hr_empmastr','hr_empmastr.id=ac_recieptdata.CRBY','left');
		$this->db->join('ac_trnreceipts','ac_trnreceipts.RCTID=ac_recieptdata.RCTID');
        $this->db->join('ac_chqdata','ac_chqdata.CHQID=ac_trnreceipts.CHQID','left');
		$this->db->join('ac_entries','ac_entries.id=ac_recieptdata.RCTREFNO');
		$this->db->join('ac_recieptbookdata','ac_recieptbookdata.RCTBID=ac_recieptdata.RCTBID');
        if($payment_mode != 'all')
             $this->db->where('ac_trnreceipts.rcvmode',$payment_mode);
       $this->db->where('ac_recieptdata.RCTSTATUS !=','CANCEL');
	    $this->db->where('ac_entries.date <=',$end_date);
		$this->db->where('ac_entries.date >=',$start_date);
		$this->db->where('ac_recieptbookdata.branch_code',$branch_id);
        $query = $this->db->get('ac_recieptdata');
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
	}
}
