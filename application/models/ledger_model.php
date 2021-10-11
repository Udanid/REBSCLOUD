<?php

class Ledger_model extends CI_Model {

    function Ledger_model()
    {
        parent::__construct();
        define("shortcode",$this->session->userdata('accshortcode'));
		define("FYST",$this->session->userdata('fy_start'));
		define("FYEND",$this->session->userdata('fy_end'));

    }

    function get_all_ac_ledgers()
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
		$this->db->where("ac_ledgers.active",1);
        //$this->db->order_by('ac_groups.name','asc');
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);

        $this->db->order_by('ac_ledgers.id','asc');
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname;
        }
        return $options;
    }

	function get_all_ac_ledgers_fortb()
    {

        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname,ac_groups.id as gid');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        //$this->db->order_by('ac_groups.name','asc');
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
		$this->db->order_by('ac_groups.id','desc');
		$this->db->where("ac_ledgers.active",1);
		$this->db->order_by('ac_ledgers.id','asc');
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname.'-'.$row->gid;
        }
        return $options;
    }

    function get_all_Advance_ac_ledgers($list)
    {
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->where_in('group_id',$list);
		$this->db->where("ac_ledgers.active",1);
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        $this->db->order_by('ac_groups.name','asc');
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname;
        }
        return $options;
    }

    function get_all_ac_ledgers_bankcash()
    {
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_groups.name','asc');
        $this->db->where('type', 1);
		$this->db->where("ac_ledgers.active",1);
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname;
        }
        return $options;
    }

 function get_all_ac_ledgers_tomake_payment()
    {
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_groups.name','asc');
        $this->db->where('type', 1);
		$this->db->where("ac_ledgers.active",1);
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        $ledger_q = $this->db->get('ac_ledgers');

        return $ledger_q->result();
    }
    function get_all_ac_ledgers_nobankcash()
    {
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_groups.name','asc');
		$this->db->where("ac_ledgers.active",1);
        $this->db->where('type !=', 1);
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname;
        }
        return $options;
    }

    function get_all_ac_ledgers_bankcharge(){
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_groups.name','asc');
        $this->db->where('ac_ledgers.group_id', '17');
        $this->db->or_where('ac_ledgers.group_id', '75');
		$this->db->where("ac_ledgers.active",1);
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname;
        }
        return $options;
    }

    function get_all_ac_ledgers_reconciliation()
    {
        $options = array();
        $options[0] = "";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_groups.name','asc');
        $this->db->where('reconciliation', 1);
		$this->db->where("ac_ledgers.active",1);
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            $options[$row->id] = $row->ref_id.' '.$row->name.' '.$row->id.'#'.$row->gname;
        }
        return $options;
    }

    function get_name($ledger_id)
    {
        $this->db->from('ac_ledgers')->where('id', $ledger_id)->limit(1);
        $ledger_q = $this->db->get();
        if ($ledger = $ledger_q->row())
            return $ledger->name;
        else
            return "(Error)";
    }

    function get_entry_name($entry_id, $entry_type_id)
    {
        /* Selecting whether to show debit side Ledger or credit side Ledger */
        $current_entry_type = entry_type_info($entry_type_id);
        $ledger_type = 'C';

        if ($current_entry_type['bank_cash_ledger_restriction'] == 3)
            $ledger_type = 'C';

        $this->db->select('ac_ledgers.name as name');
        $this->db->from('ac_entry_items')->join('ac_ledgers', 'ac_entry_items.ledger_id = ac_ledgers.id')->where('ac_entry_items.entry_id', $entry_id)->where('ac_entry_items.dc', $ledger_type);
        $ledger_q = $this->db->get();
        if ( ! $ledger = $ledger_q->row())
        {
            return "(Invalid)";
        } else {
            $ledger_multiple = ($ledger_q->num_rows() > 1) ? TRUE : FALSE;
            $html = '';
            if ($ledger_multiple)
                $html .= $ledger->name;
            else
                $html .= $ledger->name;
            return $html;
        }
        return;
    }

    function get_opp_ledger_name($entry_id, $entry_type_label, $ledger_type, $output_type)
    {
        $output = '';
        if ($ledger_type == 'D')
            $opp_ledger_type = 'C';
        else
            $opp_ledger_type = 'D';
        $this->db->from('ac_entry_items')->where('entry_id', $entry_id)->where('dc', $opp_ledger_type);
        $opp_entry_name_q = $this->db->get();
        if ($opp_entry_name_d = $opp_entry_name_q->row())
        {
            $opp_ledger_name = $this->get_name($opp_entry_name_d->ledger_id);
            if ($opp_entry_name_q->num_rows() > 1)
            {
                if ($output_type == 'html')
                    $output = anchor('accounts/report/ac_ledgerst/'.$opp_entry_name_d->ledger_id, "(" . $opp_ledger_name . ")", array('title' => 'View ' . ' Ledger', 'class' => 'anchor-link-a'));
                else
                    $output = "(" . $opp_ledger_name . ")";
            } else {
                if ($output_type == 'html')
                    $output = anchor('accounts/report/ac_ledgerst/'.$opp_entry_name_d->ledger_id, $opp_ledger_name, array('title' => 'View ' . ' Ledger', 'class' => 'anchor-link-a'));
                else
                    $output = $opp_ledger_name;
            }
        }
        return $output;
    }

    function get_ledger_balance($ledger_id)
    {
        list ($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);

        $dr_total = $this->get_dr_total($ledger_id);
        $cr_total = $this->get_cr_total($ledger_id);

        $total = float_ops($dr_total, $cr_total, '-');
        if ($op_bal_type == "D")
            $total = float_ops($total, $op_bal, '+');
        else
            $total = float_ops($total, $op_bal, '-');

        return $total;
    }

    function get_ledger_config_balance($ledger_id)
    {
        list ($op_bal, $op_bal_type) = $this->get_config_op_balance($ledger_id);

        $dr_total = $this->get_dr_total($ledger_id);
        $cr_total = $this->get_cr_total($ledger_id);

        $total = float_ops($dr_total, $cr_total, '-');
        if ($op_bal_type == "D")
            $total = float_ops($total, $op_bal, '+');
        else
            $total = float_ops($total, $op_bal, '-');

        return $total;
    }

    function get_op_balance($ledger_id)
    {
        $this->db->from('ac_ledgers')->where('id', $ledger_id)->limit(1);
        $op_bal_q = $this->db->get();
        if ($op_bal = $op_bal_q->row())
            return array($op_bal->op_balance, $op_bal->op_balance_dc);
        else
            return array(0, "D");
    }
    function get_config_op_balance($ledger_id)
    {
        $this->db->from('ac_config_ledgers')->where('id', $ledger_id)->limit(1);
        $op_bal_q = $this->db->get();
        if ($op_bal = $op_bal_q->row())
            return array($op_bal->op_balance, $op_bal->op_balance_dc);
        else
            return array(0, "D");
    }

    function get_configledger_byid($id)
    {
        $this->db->from('ac_config_ledgers')->where('id',$id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }

    function get_diff_op_balance()
    {
        /* Calculating difference in Opening Balance */
        $total_op = 0;
        $this->db->from('ac_ledgers')->LIKE('ac_ledgers.id',shortcode)->order_by('id', 'asc');
        $ac_ledgers_q = $this->db->get();
        foreach ($ac_ledgers_q->result() as $row)
        {
            list ($opbalance, $optype) = $this->get_op_balance($row->id);
            if ($optype == "D")
            {
                $total_op = float_ops($total_op, $opbalance, '+');
            } else {
                $total_op = float_ops($total_op, $opbalance, '-');
            }
        }
        return $total_op;
    }

    /* Return debit total as positive value */
    function get_dr_total($ledger_id)
    {
        $this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D');
       $this->db->where('ac_entries.date >=', FYST);
		$this->db->where('ac_entries.date <=', FYEND);
	    $dr_total_q = $this->db->get();
        if ($dr_total = $dr_total_q->row())
            return $dr_total->drtotal;
        else
            return 0;
    }

    /* Return credit total as positive value */
    function get_cr_total($ledger_id)
    {
        $this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C');
		$this->db->where('ac_entries.date >=', FYST);
		$this->db->where('ac_entries.date <=', FYEND);;
        $cr_total_q = $this->db->get();
        if ($cr_total = $cr_total_q->row())
            return $cr_total->crtotal;
        else
            return 0;
    }

    /* Delete reconciliation ac_entries for a Ledger account */
    function delete_reconciliation($ledger_id)
    {
        $update_data = array(
            'reconciliation_date' => NULL,
        );
        $this->db->where('ledger_id', $ledger_id)->update('ac_entry_items', $update_data);
        return;
    }

    function update_reconcile($date,$cheque_no,$type,$amount){
		if($type=='C'){
     	   $this->db->select('ac_chqprint.PAYREFNO')->from('ac_chqprint')->join('ac_entries','ac_entries.id=ac_chqprint.PAYREFNO')->where('ac_chqprint.CHQNO',$cheque_no)->where('ac_entries.dr_total',$amount);
     		$query = $this->db->get();
        	if ($query->num_rows() > 0){
            $result = $query->row();
            $data = array(
                'reconciliation_date' => $date,
            );
            $this->db->where('entry_id',$result->PAYREFNO);
            $this->db->where('dc','C');
            $this->db->update('ac_entry_items',$data);
            return $result;
       	 }
		 else
		 return false;
		}
		if($type=='D')
		{
			$this->db->select('ENTRYCODE')->from('ac_chqdata')->where('CHQNO',$cheque_no)->where('CHQAMOUNT',$amount);
     		$query = $this->db->get();
        	if ($query->num_rows() > 0){
            $result = $query->row();
            $data = array(
                'reconciliation_date' => $date,
            );
            $this->db->where('entry_id',$result->ENTRYCODE);
            $this->db->where('dc','D');
            $this->db->update('ac_entry_items',$data);
            return $result;
       	 }
		 else
		  return false;
		}

    }
    function get_ac_ledgers_list_all()
    {
        $this->db->select('ac_ledgers.*,ac_groups.name as gname');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        $this->db->order_by('ac_ledgers.id','asc');
        //$this->db->where("ac_ledgers.id LIKE '%HED%'");
        $this->db->LIKE('ac_ledgers.id',shortcode);
        //	$this->db->order_by('ac_groups.name','asc');
        $ledger_q = $this->db->get('ac_ledgers');
        return $ledger_q->result();
    }
    function get_ledgerdata_for_vouchers($entry_id, $entry_type_id)
    {
        /* Selecting whether to show debit side Ledger or credit side Ledger */
        $current_entry_type = entry_type_info($entry_type_id);
        $ledger_type = 'C';

        if ($current_entry_type['bank_cash_ledger_restriction'] == 3)
            $ledger_type = 'D';

        $this->db->select('ac_ledgers.name as name,ac_entry_items.amount as amount,ac_entry_items.ledger_id as ledger_id');
        $this->db->from('ac_entry_items')->join('ac_ledgers', 'ac_entry_items.ledger_id = ac_ledgers.id')->where('ac_entry_items.entry_id', $entry_id)->where('ac_entry_items.dc', $ledger_type);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() >0 )
        {
            return $ledger_q->result();
        } else {
            return false;
        }
        return;
    }

    function getAdvances($parent_id = 24){
        $this->db->select('*');
        $this->db->from('ac_groups')->where('parent_id',$parent_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }
    }

    function getSupplers(){
        $this->db->select('*');
        $this->db->from('ac_suppliers_data');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }
    }

    function get_group($id){
        $this->db->select('name,parent_id');
        $this->db->from('ac_groups')->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }
    }

	//period function set
	function get_opledger_balance_period($ledger_id,$stdate,$enddate)
	{
		 list ($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);
		$cur_balance = 0;
		if ($op_bal_type == "D")
			{
				$cur_balance = float_ops($cur_balance, $op_bal, '+');
			} else {
				$cur_balance = float_ops($cur_balance, $op_bal, '-');
			}

		$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc');
			$this->db->where('ac_entries.date <',$stdate);
			$this->db->where('ac_entries.date >=',FYST);
		$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');

			$prevbal_q = $this->db->get();
			foreach ($prevbal_q->result() as $row )
			{
				if ($row->ac_entry_items_dc == "D")
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
				else
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
			}
		 return $cur_balance;
	}
	function get_ledger_balance_period($ledger_id,$stdate,$enddate)
    {
        $opbalance =  $this->get_opledger_balance_period($ledger_id,$stdate,$enddate);
		$transactions = $this->get_ledger_balance_period_without_op($ledger_id,$stdate,$enddate);

		list ($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);
        return float_ops($opbalance, $transactions, '+');

    }

	function get_ledger_balance_period_without_op($ledger_id,$stdate,$enddate)
    {
        list ($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);
		$cur_balance = 0;



        $dr_total = $this->get_dr_total_period($ledger_id,$stdate,$enddate);
        $cr_total = $this->get_cr_total_period($ledger_id,$stdate,$enddate);

        $total = float_ops($dr_total, $cr_total, '-');
        if ($op_bal_type == "D")
            $total = float_ops($total, $cur_balance, '+');
        else
            $total = float_ops($total, $cur_balance, '-');

        return $total;
    }
	function get_dr_total_period($ledger_id,$stdate,$enddate)
    {
        $this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D');
       $this->db->where('ac_entries.date >=', $stdate);
		$this->db->where('ac_entries.date <=', $enddate);
	    $dr_total_q = $this->db->get();
        if ($dr_total = $dr_total_q->row())
            return $dr_total->drtotal;
        else
            return 0;
    }

    /* Return credit total as positive value */
    function get_cr_total_period($ledger_id,$stdate,$enddate)
    {
        $this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C');
		$this->db->where('ac_entries.date >=', $stdate);
		$this->db->where('ac_entries.date <=',$enddate);;
        $cr_total_q = $this->db->get();
        if ($cr_total = $cr_total_q->row())
            return $cr_total->crtotal;
        else
            return 0;
    }

	function getLedgerbyID($ledger_id){
		$this->db->select('*');
        $this->db->from('ac_ledgers')->where('id',$ledger_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }
	}

	function getAccgroups($parent_id){
        $this->db->select('*');
        $this->db->from('ac_groups')->where('parent_id',$parent_id)->order_by('group_order','ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }
    }

	function checkLedgersBygroup($groupid){
		$this->db->select('id');
        $this->db->from('ac_ledgers')->where('group_id',$groupid);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->num_rows();
        }
	}
	function get_ledgers_by_groupid($groupid){
		$this->db->select('id');
        $this->db->from('ac_ledgers')->where('group_id',$groupid);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }
	}

	function get_transactions_by_ledgerid($ledger_id,$startdate,$enddate){
		$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO,re_projectms.project_name,re_prjaclotdata.lot_number');
	  	$this->db->where('ac_entries.date >=', $startdate);
	  	$this->db->where('ac_entries.date <=', $enddate);
	  	$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->join('re_projectms', 're_projectms.prj_id =ac_entries.prj_id','left')->join('re_prjaclotdata', 're_prjaclotdata.lot_id =ac_entries.lot_id','left')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
	  	$query = $this->db->get();
		if ($query->num_rows() > 0){
            return $query->result();
        }
	}

	function get_previous_balance_byledger($ledger_id,$startdate,$enddate){
		$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc');
		$this->db->where('ac_entries.date <', $startdate);
		$this->db->where('ac_entries.date >=',$enddate);
		$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
            return $query->result();
        }
	}
	function get_current_entry_bank_account($entry_id)
    {
        /* Selecting whether to show debit side Ledger or credit side Ledger */
        $ledger_type = 'C';


        $this->db->select('ac_entry_items.ledger_id');
        $this->db->from('ac_entry_items')->where('ac_entry_items.entry_id', $entry_id)->where('ac_entry_items.dc', $ledger_type);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            $data= $ledger_q->row();
			return $data->ledger_id;

        }
		else
			return false;
    }

	function ledger_deletable($ledger_id){
		$id = substr($ledger_id, 3);

		$count = 0;

		$this->db->select('*');
		$this->db->where('Cr_account', $id);
		$this->db->or_where('Dr_account', $id);
		$query = $this->db->get('re_lederset');
		if($query->num_rows() > 0){
			$count++;
		}

		$this->db->select('*');
		$this->db->where('ledger_id', $id);
		$this->db->or_where('adv_ledgerid', $id);
		$query = $this->db->get('cm_tasktype');
		if($query->num_rows() > 0){
			$count++;
		}

		$this->db->select('*');
		$this->db->where('ledger_id', $ledger_id);
		$query = $this->db->get('ac_entry_items');
		if($query->num_rows() > 0){
			$count++;
		}

		$this->db->select('*');
		$this->db->where('id', $ledger_id);
		$this->db->where('op_balance !=', '0');
		$query = $this->db->get('ac_ledgers');
		if($query->num_rows() > 0){
			$count++;
		}

		$check_acc = array('HEDBL31000000','HEDBL23002400','HEDPE61002000','HEDPE61000200','HEDPE61000100','HEDPE62000100');
		if (in_array($ledger_id, $check_acc))
		{
			$count++;
		}

		if($count > 0){
			return false;
		}else{
			return true;
		}
	}

	function delete_ledger($id){
		if($id)
		{
			$this->db->select('name');
			$this->db->where('id',$id);
			$query = $this->db->get('ac_ledgers');
			if($query->num_rows() > 0){
				$this->db->where('id',$id);
				$this->db->delete('ac_ledgers');
				if ($this->db->affected_rows() > 0){
					$id = substr($id, 3);
					$this->db->where('id',$id);
					$this->db->delete('ac_config_ledgers');
					return $query->row()->name;
				}
			}else{
				return false;
			}
		}
	}

  //updated  by nadee 2020-12-16
  function get_refid($ledger_id)
  {
      $this->db->from('ac_ledgers')->where('id', $ledger_id)->limit(1);
      $ledger_q = $this->db->get();
      if ($ledger = $ledger_q->row())
          return $ledger->ref_id;
      else
          return "(Error)";
  }
  
  //added by Eranga 06-08-2021
  function get_ledger_balance_todate($ledger_id,$enddate)
    {
		
        list ($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);

        $dr_total = $this->get_dr_total_todate($ledger_id,$enddate);
        $cr_total = $this->get_cr_total_todate($ledger_id,$enddate);

        $total = float_ops($dr_total, $cr_total, '-');
        if ($op_bal_type == "D")
            $total = float_ops($total, $op_bal, '+');
        else
            $total = float_ops($total, $op_bal, '-');

        return $total;
    }
	
	function get_dr_total_todate($ledger_id,$enddate)
    {
        $this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D');
       $this->db->where('ac_entries.date >=', FYST);
		$this->db->where('ac_entries.date <=',$enddate);
	    $dr_total_q = $this->db->get();
        if ($dr_total = $dr_total_q->row())
            return $dr_total->drtotal;
        else
            return 0;
    }

    /* Return credit total as positive value */
    function get_cr_total_todate($ledger_id,$enddate)
    {
        $this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C');
		$this->db->where('ac_entries.date >=', FYST);
		$this->db->where('ac_entries.date <=', $enddate);;
        $cr_total_q = $this->db->get();
        if ($cr_total = $cr_total_q->row())
            return $cr_total->crtotal;
        else
            return 0;
    }
// auto generate ledgerid
function check_ledgerid_exist($id)
{
	 $this->db->from('ac_ledgers')->where('id', $id);
      $ledger_q = $this->db->get();
	    if ($ledger_q->num_rows() > 0){
			return true;
		}
		return false;
	
}
function get_next_ledgerid($data_group_id)
{
	 $this->db->select('*');
        $this->db->from('ac_groups')->where('id',$data_group_id)->order_by('group_order','ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            $dataset= $query->row();
			$groupcode=trim($dataset->group_code);
			$currentid=intval(substr($groupcode, 5));
		//	echo $currentid ;
		//	exit;
			$code=substr($groupcode, 0, 5);
			
			$newid=$currentid+1;
			
			
			$newcode=$code.$newid;
			while($this->check_ledgerid_exist($newcode))
			{
				$newid++;
				$newcode=$code.$newid;
			}
			return $newcode;
			
        }
}
}
