<?php

class Entry_model extends CI_Model {

    function Entry_model()
    {
        parent::__construct();
    }

    function next_entry_number($entry_type_id)
    {
        $last_no_q = $this->db->query("SELECT MAX(CONVERT(number, SIGNED)) as lastno  FROM  ac_entries where entry_type='".$entry_type_id."'");
        //$last_no_q = $this->db->get();
        if ($row = $last_no_q->row())
        {
            $last_no = $row->lastno;
            $last_no++;
            return $last_no;
        } else {
            return 1;
        }
    }

    function get_entry($entry_id, $entry_type_id)
    {
   		$this->db->select('ac_entries.*,re_projectms.project_name,re_prjaclotdata.lot_number');
		$this->db->join('re_projectms','re_projectms.prj_id=ac_entries.prj_id','left');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=ac_entries.lot_id','left');
		$this->db->where('ac_entries.id',$entry_id);
		$entry_q = $this->db->get('ac_entries'); 
         if ($entry_q->num_rows() > 0){
        return $entry_q->row();
		 }else
            return false;

    }
	

    function get_pending_incomes($branchid)
    {
        $options = array();
        $options[0] = "(Please Select)";
		$this->db->select('re_prjacincome.*,re_projectms.project_name,re_prjaclotdata.lot_number');
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacincome.pri_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_prjacincome.lot_id','left');
		if(! check_access('all_branch'))
		$this->db->where('re_prjacincome.branch_code',$branchid);
		$this->db->where('re_prjacincome.pay_status',"PENDING");
		$this->db->order_by('re_prjacincome.id', 'DESC');
		$ledger_q = $this->db->get('re_prjacincome'); 
   //     $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	function get_pending_incomes_by_project($id)
    {
        $options = array();
        $options[0] = "(Please Select)";
		 // $this->db->from('re_prjacincome')->where('pay_status =',"PENDING")->order_by('id', 'DESC');
      
  $this->db->from('re_prjacincome')->where('pay_status',"PENDING")->where('pri_id',$id)->order_by('id', 'DESC');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	function get_pending_incomes_by_tempcode($id)
    {
        $options = array();
        $options[0] = "(Please Select)";
		 // $this->db->from('re_prjacincome')->where('pay_status =',"PENDING")->order_by('id', 'DESC');
      
 		 $this->db->from('re_prjacincome')->where('pay_status',"PENDING")->where('temp_code',$id)->order_by('id', 'DESC');
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;

    }
	
	
	function get_project_notpending_lots_byprjid($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		
		$this->db->where('status !=','PENDING');
		$this->db->order_by('lot_number');
		
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_prjaclotdata'); 
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
	
	function get_journal($entry_type_id,$limit, $start){
		$this->db->from('ac_entries')->where('entry_type', $entry_type_id)->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->join('ac_chqprint','ac_chqprint.CANFERNO=ac_entries.id','left')->order_by('date', 'desc')->order_by('number', 'desc')->limit($limit, $start);
		return $this->db->get();
	}
	
	function get_project_deials_by_id($project_id){
		$this->db->from('re_projectms')->where('prj_id', $project_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		else
		return false;
	}

    // new module function created by terance 2019-12-19.. 
    function get_project_deials_by_id_and_module($project_id,$moduletyp){
		if($moduletyp=='H'){
          $this->db->from('hm_projectms')->where('prj_id', $project_id);
		}else{
		  $this->db->from('re_projectms')->where('prj_id', $project_id);	
		}
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	function get_lot_deials_by_id($lot_id){
		$this->db->from('re_prjaclotdata')->where('lot_id', $lot_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		else
		return false;
	}
	function get_project_name_and_lot_bymodule($module,$prj_id,$lot_id)
	{ 
		$myarr=array('','');
		if($module=='R'){
			if($prj_id){
				$this->db->from('re_projectms')->where('prj_id', $prj_id);
				$query = $this->db->get();
				if($query->num_rows() > 0){
					$data=$query->row();
					$myarr[0]=$data->project_name;
				}
			}
			if($lot_id)
			{
				$this->db->from('re_prjaclotdata')->where('lot_id', $lot_id);
				$query = $this->db->get();
				if($query->num_rows() > 0){
					$data= $query->row();
					$myarr[1]=$data->lot_number;
				}
			}
		}
		if($module=='H'){
			if($prj_id){
				$this->db->from('hm_projectms')->where('prj_id', $prj_id);
				$query = $this->db->get();
				if($query->num_rows() > 0){
					$data=$query->row();
					$myarr[0]=$data->project_name;
				}
			}
			if($lot_id)
			{
				$this->db->from('hm_prjaclotdata')->where('lot_id', $lot_id);
				$query = $this->db->get();
				if($query->num_rows() > 0){
					$data= $query->row();
					$myarr[1]=$data->lot_number;
				}
			}
		}
		return $myarr;
	}

// aded by udani - restric reciept cancelation  2020-05-15
  function check_loan_create($res_code){
		$this->db->from('re_eploan')->where('res_code', $res_code);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return true;
		}
		else
		return false;
	}
	function max_incomeid($temp_code){
		$this->db->select('MAX(id) as Maxid');
		$this->db->from('re_prjacincome')->where('temp_code', $temp_code);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$data= $query->row();
			return $data->Maxid;
		}
		else
		return 0;;
	}
	function hm_check_loan_create($res_code){
		$this->db->from('hm_eploan')->where('res_code', $res_code);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return true;
		}
		else
		return false;
	}
	function hm_max_incomeid($temp_code){
		$this->db->select('MAX(id) as Maxid');
		$this->db->from('hm_prjacincome')->where('temp_code', $temp_code);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$data= $query->row();
			return $data->Maxid;
		}
		else
		return 0;;
	}
	function check_chancel_true($entryid)
	{
		$this->db->select('re_prjacincome.*');
		$this->db->where('re_prjacincome.entry_id',$entryid);
		$ledger_q = $this->db->get('re_prjacincome'); 
   //     $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            $data= $ledger_q->row();
			if($data->income_type=='Advance Payment')
			{
				$loanexist=$this->check_loan_create($data->temp_code);
				if($loanexist)
				{
					return false;
				}
				else
				{
					/*Ticket No:2889 Added By Madushan 2021.06.16*/
					$sheduleexist=$this->check_shedule_create($data->temp_code);
					if($sheduleexist){
						$maxincomeid=$this->max_incomeid($data->temp_code);
						if($maxincomeid==$data->id)
						return true;
						else 
						return false;
					}
					else
					{
						return true;
					}

				}
				
			}
			else if($data->income_type=="Rental Payment")
			{
				$maxincomeid=$this->max_incomeid($data->temp_code);
				if($maxincomeid==$data->id)
				return true;
				else 
				return false;
			}
			else
			{
				return true;
			}
        }else 
		{
			
				$this->db->select('hm_prjacincome.*');
			$this->db->where('hm_prjacincome.entry_id',$entryid);
			$ledger_q = $this->db->get('hm_prjacincome'); 
	   //     $ledger_q = $this->db->get();
			if ($ledger_q->num_rows() > 0){
				$data= $ledger_q->row();
				if($data->income_type=='Advance Payment')
				{
					$loanexist=$this->hm_check_loan_create($data->temp_code);
					if($loanexist)
					{
						return false;
					}
					else
					return true;
				}
				else if($data->income_type=="Rental Payment")
				{
					$maxincomeid=$this->hm_max_incomeid($data->temp_code);
					if($maxincomeid==$data->id)
					return true;
					else 
					return false;
				}
				else
				{
					return true;
				}
			}
			else
			{
				return true;
			}
			
		}
            
	}

 /*Ticket No:2889 Added By Madushan 2021.06.16*/

 	function check_advance_cancel_true($id)
	{
		$this->db->select('re_saleadvance.*');
		$this->db->where('re_saleadvance.id',$id);
		$ledger_q = $this->db->get('re_saleadvance');
		if ($ledger_q->num_rows() > 0){
           $data= $ledger_q->row();

			$loanexist=$this->check_loan_create($data->res_code);
			if($loanexist)
			{
				return false;
			}
			else
			{
					
				$sheduleexist=$this->check_shedule_create($data->res_code);
				if($sheduleexist){
				$max_advanceid=$this->max_advanceid($data->res_code);
				if($max_advanceid==$data->id)
					return true;
				else 
					return false;
				}
				else
				{
					return true;
				}

			}
		}
		return false;
				
			
	}

	function check_shedule_create($res_code)
	{
		$this->db->select('*');
		$this->db->where('res_code',$res_code);
		$query = $this->db->get('re_salesadvanceshedule');
		if($query->num_rows>0)
			return true;
		else
			return false;
	}

	function max_advanceid($temp_code){
		$this->db->select('MAX(id) as Maxid');
		$this->db->from('re_saleadvance')->where('res_code', $temp_code);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$data= $query->row();
			return $data->Maxid;
		}
		else
		return 0;;
	}
 /*End of Ticket No:2889*/
}
