<?php

class ac_projects_model extends CI_Model {

    function ac_projects_model()
    {
        parent::__construct();
    }

    function get_all_ac_projects()
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->select('ac_projects.*')->where('prj_status','Active')->order_by('gl_code');
        $ledger_q = $this->db->get('ac_projects');
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;


    }
    function get_grants()
    {
        $options[0] = "(Please Select)";
        $this->db->select('ac_projects.*')->where('prj_status','Active')->order_by('gl_code');
        $ledger_q = $this->db->get('ac_projects');
        if ($ledger_q->num_rows() > 0){
            $ac_projects=$ledger_q->result();
            foreach($ac_projects as $rowdata)
            {
                $this->db->select('sum(project_grants.amount) as mysum')->where('projectid',$rowdata->prjid);
                $ledger_q = $this->db->get('project_grants');
                if($ledger_q->num_rows() > 0)
                {
                    //print_r($ledger_q->row());
                    $grantdata=$ledger_q->row();
                    $options[$rowdata->prjid] =$grantdata->mysum;
                    $insert_data1=array('fund_release'=>$grantdata->mysum);
                    $this->db->where('prjid',$rowdata->prjid)->update('ac_projects', $insert_data1);

                }
                else
                {
                    $options[$rowdata->prjid]=0;
                }
            }
            return $options;

        }else
            return false;

    }
    function new_refcode($refcode)
    {
        $this->db->from('ac_reference_code')->where('old_ref',$refcode);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            $data= $ledger_q->row();
            return $data->new_ref;
        }else
            return $refcode;
    }
    function get_all__sub_ac_projects()
    {

        return false;


    }


    function get_project_byledgerid($id)
    {
        $options = array();

        $this->db->from('ac_projects')->where('gl_code', $id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }
    function get_project_by_refid($id)
    {
        $options = array();

        $this->db->from('ac_projects')->where('ref_id', $id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }

    function get_project_byprojectid($id)
    {
        $options = array();

        $this->db->from('ac_projects')->where('prjid', $id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }
    function get_subprojectt_byprojectid($id)
    {
        $options = array();

        $this->db->from('project_sub')->where('id', $id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;

    }

    function is_subprojectt_payments($id)
    {
        $options = array();

        $this->db->from('project_subpayments')->where('subprjid', $id);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return true;
        }else
            return false;

    }
    function get_subprojectt_payments($id)
    {
        $options = array();

        $this->db->select('*')->from('project_subpayments')->where('subprjid', $id);
        $ledger_q = $this->db->get();
        //echo $this->db->last_query();
        if ($ledger_q->num_rows() > 0){
            //echo "eee";
            return $ledger_q->result();
        }else
            return false;



    }
    function get_subprojectt_payments_by_voucherid($id)
    {
        $options = array();

        $this->db->select('*')->from('project_subpayments')->where('document_refno', $id);
        $ledger_q = $this->db->get();
        //echo $this->db->last_query();
        if ($ledger_q->num_rows() > 0){
            //echo "eee";
            return $ledger_q->row();
        }else
            return false;



    }

    function get_projectexpenditure($id)
    {
        $options = array();

        $this->db->select('*')->from('project_expenditure')->where('projectid', $id);
        $ledger_q = $this->db->get();
        //echo $this->db->last_query();
        if ($ledger_q->num_rows() > 0){
            //echo "eee";
            return $ledger_q->result();
        }else
            return false;



    }
    function get_projectexpenditure_byentyid($id)
    {
        $options = array();

        $this->db->select('*')->from('project_expenditure')->where('documentNo', $id);
        $ledger_q = $this->db->get();
        //echo $this->db->last_query();
        if ($ledger_q->num_rows() > 0){
            //echo "eee";
            return $ledger_q->row();
        }else
            return false;



    }
    function get_governmentgrants($id)
    {
        $options = array();

        $this->db->select('project_grants.*,ac_recieptdata.RCTNO,ac_entries.narration')
            ->from('project_grants')
            ->join('ac_recieptdata','ac_recieptdata.RCTID=project_grants.recieptid')->join('ac_entries','ac_entries.id=project_grants.entryid')
            ->where('project_grants.projectid', $id);
        $ledger_q = $this->db->get();
        //echo $this->db->last_query();
        if ($ledger_q->num_rows() > 0){
            //echo "eee";
            return $ledger_q->result();
        }else
            return false;



    }
    function get_search__sub_ac_projects()
    {
        $options = array();
        $options[0] = "(Please Select)";
        if($this->input->post('prjname')!="" & $this->input->post('disname')!="" )
            $this->db->select('project_sub.*,ac_projects.ref_id')->from('project_sub')->where('project_sub.projectid',$this->input->post('prjname'))->like('project_sub.District', $this->input->post('disname'))->join('ac_projects','ac_projects.prjid=project_sub.projectid')->order_by('project_sub.name');
        else if($this->input->post('prjname')!="" & $this->input->post('disname')=="" )
            $this->db->select('project_sub.*,ac_projects.ref_id')->from('project_sub')->where('project_sub.projectid',$this->input->post('prjname'))->join('ac_projects','ac_projects.prjid=project_sub.projectid')->order_by('project_sub.name');
        else if($this->input->post('prjname')=="" & $this->input->post('disname')!="" )
            $this->db->select('project_sub.*,ac_projects.ref_id')->from('project_sub')->like('project_sub.District', $this->input->post('disname'))->join('ac_projects','ac_projects.prjid=project_sub.projectid')->order_by('project_sub.name');
        else
            $this->db->select('project_sub.*,ac_projects.ref_id')->from('project_sub')->join('ac_projects','ac_projects.prjid=project_sub.projectid')->order_by('project_sub.name');

        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;


    }

}
