<?php

class Budgeting_model extends CI_Model {

    function Budgeting_model()
    {
        parent::__construct();

    }


    function get_anual_budget($year)
    {
        $this->db->select('*');
        $this->db->from('annualbudget');
        $this->db->where('year',$year);
        $this->db->order_by('type');
        $this->db->order_by('refid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function is_anual_budget_set($year)
    {
        $this->db->select('*');
        $this->db->from('annualbudget');
        $this->db->where('year',$year);
        $this->db->order_by('type');
        $this->db->order_by('refid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return true;
        }else
            return false;
    }
    function get_sum_budget($year)
    {
        $this->db->select('SUM(annualbudget.budget) as tot,type');
        $this->db->from('annualbudget');
        $this->db->where('year',$year);
        $this->db->group_by('type');
        $this->db->order_by('type','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_group_sum_budget($year)
    {
        $this->db->select('SUM(annualbudget.budget) as tot,ac_groups.name as gname,ac_groups.id as gid');
        $this->db->from('annualbudget');
        $this->db->join('ac_groups','ac_groups.id=annualbudget.groupid');
        $this->db->where('year',$year);
        $this->db->order_by('type');
        $this->db->group_by('groupid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_recurent_sum_budget($year,$type)
    {
        $this->db->select('SUM(annualbudget.budget) as tot,ac_groups.name as gname,ac_groups.id as gid');
        $this->db->from('annualbudget');
        $this->db->join('ac_groups','ac_groups.id=annualbudget.groupid');
        $this->db->where('year',$year);
        $this->db->where('type',$type);
        $this->db->group_by('groupid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_capital_buget($year,$type)
    {
        $this->db->select('annualbudget.budget,annualbudget.id,annualbudget.name,annualbudget.refid as refid,ac_ledgers.id as glcode');
        $this->db->from('annualbudget');
        //$this->db->join('ac_groups','ac_groups.id=annualbudget.groupid');
        $this->db->join('ac_ledgers','ac_ledgers.id=annualbudget.ledgerid');
        $this->db->where('year',$year);
        $this->db->where('annualbudget.type',$type);
        $this->db->order_by('refid');

        $query = $this->db->get();
        //echo $this->db->last_query();

        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_buget_by_groupid($year,$groupid)
    {
        $this->db->select('');
        $this->db->from('annualbudget');
        $this->db->where('year',$year);
        $this->db->where('groupid',$groupid);
        $this->db->order_by('refid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_ac_ledgerset()
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->select('ac_ledgers.*,ac_groups.name as gname,ac_groups.id as gid');
        $this->db->join('ac_groups','ac_groups.id = ac_ledgers.group_id');
        //,ac_projects.prj_status
        //$this->db->join('ac_projects','ac_ledgers.ref_id=ac_projects.ref_id','left');
        $this->db->order_by('ac_ledgers.id','asc');
        $this->db->where('ref_id !=','');
        $this->db->group_by('ac_ledgers.ref_id');
        $ledger_q = $this->db->get('ac_ledgers');
        foreach ($ledger_q->result() as $row)
        {
            //Modified code to set there uniformity

            $options[$row->id] = $row->id.'.'.$row->name.'.'.$row->gname.'.'.$row->ref_id.'.'.$row->gid;
        }
        return $options;
    }

    function getmonth_forcast($year,$month)
    {
        $this->db->select('monthlyforcast.refid,monthlyforcast.amount,monthlyforcast.id,annualbudget.ledgerid,annualbudget.name,annualbudget.type');
        $this->db->from('monthlyforcast');
        //$this->db->join('ac_groups','ac_groups.id=annualbudget.groupid');
        $this->db->join('annualbudget','annualbudget.refid=monthlyforcast.refid');
        $this->db->where('monthlyforcast.year',$year);
        $this->db->where('monthlyforcast.month',$month);
        $this->db->order_by('annualbudget.type', 'DESC');
        $this->db->order_by('monthlyforcast.refid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function getmonth_budgetac_ledgerset($year,$month)
    {
        $this->db->select('annualbudget.refid,annualbudget.ledgerid,annualbudget.name,annualbudget.type');
        $this->db->from('annualbudget');
        $this->db->where('annualbudget.year',$year);
        $this->db->order_by('annualbudget.type', 'DESC');
        $this->db->order_by('annualbudget.refid');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }

    function get_capital_grouplist()
    {
        $options = array();
        $options[0] = "12";
        $this->db->select('ac_groups.id');
        $this->db->where('parent_id',12);
        $ledger_q = $this->db->get('ac_groups');
        $counter=1;
        foreach ($ledger_q->result() as $row)
        {
            //Modified code to set there uniformity

            $options[$counter] = $row->id;
            $counter++;
        }
        return $options;
    }
    /*function get_canceled_reciepts($school_id){
        $this->db->select('accrctdata.*,tchdata.TCHFNAME,tchdata.TCHLNAME,accrctbook.RCTBNO');
        $this->db->join('accrctbook','accrctbook.RCTBID =accrctdata.RCTBID');
        $this->db->join('tchdata','tchdata.TCHID=accrctdata.CNBY');
        $this->db->where('accrctdata.SCHID',$school_id);
        $this->db->where('tchdata.SCHID',$school_id);
        $this->db->where('accrctdata.RCTSTATUS','CANCELED');
        $this->db->order_by('accrctdata.CNDATE','DESC');

        $query = $this->db->get('accrctdata');
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }*/
}
