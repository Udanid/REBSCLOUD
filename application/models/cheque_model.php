<?php

class Cheque_model extends CI_Model {

    function Cheque_model()
    {
        parent::__construct();

    }

    function add_chequebook()
    {
        //$CI =& get_instance();
        $data=array(
		   "ledger_id"=>$this->input->post('ledger_id'),
            "CHQBNO"=>$this->input->post('CHQBNO'),
            "CHQBSNO"=>$this->input->post('CHQBSNO'),
            "CHQBNNO"=>$this->input->post('CHQBNNO'),
            "CHQBCRDATE"=>date("Y-m-d"),
            "CHQBSTATUS"=>$this->input->post('CHQBSTATUS'),
            "CRBY"=>$this->session->userdata('user_name'),
            "branch_code" => $this->session->userdata('branchid') );
        $this->db->insert('ac_chequebookdata', $data);
    }
    function edit_chequebook($id){
        $CHQBSTATUS=$this->input->post('CHQBSTATUS');
        $ledger_id=$this->input->post('ledger_id');

        // Added By Kalum 2020.02.07 Ticket No 1140

        if($CHQBSTATUS=="START"){
            $this->db->select('CHQBID');
            $this->db->where('ledger_id',$ledger_id);
            $this->db->where('CHQBSTATUS','START');
            $query = $this->db->get('ac_chequebookdata');

            $result=$query->row();

            if($result){
                $data=array(        
                    'CHQBSTATUS' => 'PAUSE',
                );

                $this->db->where('CHQBID',$result->CHQBID);
                $this->db->update('ac_chequebookdata', $data);
            }
        }

        // End Ticket No 1140

        $CI =& get_instance();
        $data=array(
		    "ledger_id"=>$this->input->post('ledger_id'),
            "CHQBSNO"=>$this->input->post('CHQBSNO'),
            "CHQBNNO"=>$this->input->post('CHQBNNO'),
            "CHQBCRDATE"=>date("Y-m-d"),
            "CHQBSTATUS"=>$this->input->post('CHQBSTATUS'),
            "CRBY"=>$CI->session->userdata('user_name'));
        $this->db->where('CHQBID', $id);
        $this->db->update('ac_chequebookdata', $data);      
    }
    
    function delete_chequebook($id)
    {
		if($id)
		{
        $this->db->where('CHQBID',$id);
        $this->db->delete('ac_chequebookdata');
		}
    }
    function get_chequebooks($branchid)
    {
        $this->db->select('ac_chequebookdata.*,ac_ledgers.name');
        $this->db->from('ac_chequebookdata');
        $this->db->where('branch_code',$branchid);
		$this->db->join('ac_ledgers','ac_ledgers.id=ac_chequebookdata.ledger_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else
            return false;
    }
    function get_chequebooks_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('ac_chequebookdata');
        $this->db->where('CHQBID',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }

    function get_cheque_sequence($no)
    {
        $this->db->select('CHQBNNO');
        $this->db->from('ac_chequebookdata');
        $this->db->where("CHQBNNO = '".$no."' ");



        $query = $this->db->get();

        if ($query->num_rows() > 0){

            return true;
        }else
            return false;
    }

    function get_cheque_bundle($no)
    {
        $this->db->select('*');
        $this->db->from('ac_chequebookdata');
        $this->db->where('CHQBNO',$no);

        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return true;
        }else
            return false;
    }
    function get_start_cheque_bundle($branchid)
    {
        $this->db->select('*');
        $this->db->from('ac_chequebookdata');
        $this->db->where('CHQBSTATUS','START');
        $this->db->where('ledger_id',$branchid);
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

        $this->db->update('recieptbookdata', $data);
    }
    //`CHQBID`, `CHQBNO`, `CHQBSNO`, `CHQBNNO`, `CHQBCRDATE`, `CHQBSTDATE`, `CHQBENDDATE`, `CHQBSNBY`, `CHQBSTATUS`, `CRBY`, `CHQBEBY`SELECT * FROM `ac_chequebookdata` WHERE 1
    function is_max_cheque_id($book_id){
        $this->db->select_max('CHQNO');
        $this->db->where('CHQBID',$book_id);
        $query = $this->db->get('ac_chqprint');
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
    }
    function is_last_chequeno($bookno,$last)
    {  $last=intval($last);
        $this->db->select('CHQBNNO');
        $this->db->where('CHQBNNO',$last);
        $this->db->where('CHQBID',$bookno);
        $query = $this->db->get('ac_chequebookdata');
        if ($query->num_rows() > 0){
            return true;
        }else
            return false;
    }
    function get_chequedata_by_entryid($ref_id){
        $this->db->select('*');
        $this->db->where('PAYREFNO',$ref_id);
        $query = $this->db->get('ac_chqprint');
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
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

    function check_new(){
        $this->db->select('COUNT( * ) as cheques')->from('ac_chqprint')->where('CHQSTATUS','QUEUE');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else
            return false;
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
       if ($ledger_q->num_rows() > 0){
            return $ledger_q->result();
        }else
            return false;
    }
	function get_cheque_sequence_ledgerid($no,$id)
    {
        $this->db->select('CHQBNNO');
        $this->db->from('ac_chequebookdata');
        $this->db->where("CHQBSNO",$no);
		$this->db->where('ledger_id',$id);

        $query = $this->db->get();

        if ($query->num_rows() > 0){
            return true;
        }else
        return false;
    }

    // Added By Kalum 2020.02.06 Ticket No 1140

    function pause_bundle($CHQBID,$ledger_id){

       // $CHQBID = $_POST['CHQBID'];
       // $ledger_id = $_POST['ledger_id'];

        // Start QUEUE bundle

        $this->db->select('CHQBID');
        $this->db->where('ledger_id',$ledger_id);
        $this->db->where('CHQBSTATUS','PAUSE');
        $query = $this->db->get('ac_chequebookdata'); 

        $result=$query->row();

        $this->db->select('CHQBID');
        $this->db->where('ledger_id',$ledger_id);
        $this->db->where('CHQBSTATUS','START');
        $this->db->where('CHQBID !=',$CHQBID);
        $query = $this->db->get('ac_chequebookdata');
        $result1=$query->row();

        if($result || $result1){
            $data=array(        
                'CHQBSTATUS' => 'START',
            );

            $this->db->where('CHQBID',$result->CHQBID);
            $this->db->update('ac_chequebookdata', $data);

            $data=array(        
                'CHQBSTATUS' => 'PAUSE',
            );

            $this->db->where('CHQBID',$CHQBID);
            $update=$this->db->update('ac_chequebookdata', $data);
           
            return true;

        }else{
            return false; 
        }      
    }

    function start_bundle($CHQBID,$ledger_id){

        //$CHQBID = $_POST['CHQBID'];
       // $ledger_id = $_POST['ledger_id'];

        // Puase bundle

        $this->db->select('CHQBID');
        $this->db->where('ledger_id',$ledger_id);
        $this->db->where('CHQBSTATUS','START');
        $query = $this->db->get('ac_chequebookdata');

        $result=$query->row();

        if($result){
            $data=array(        
                'CHQBSTATUS' => 'PAUSE',
            );

            $this->db->where('CHQBID',$result->CHQBID);
            $this->db->update('ac_chequebookdata', $data);
        }

        // Start bundle

        $data=array(        
          'CHQBSTATUS' => 'START',
        );

        $this->db->where('CHQBID',$CHQBID);
        $update=$this->db->update('ac_chequebookdata', $data);
       
        return $update;
    }

    // End Ticket 1140
}
