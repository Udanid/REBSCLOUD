<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by terance perera
//date:2019-12-02

class Hm_inventry_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insert_meterial_requests($metreqarr){
    	$this->db->trans_start();
        $this->db->insert('hm_po_request',$metreqarr);
        $this->db->trans_complete();
        if ($this->db->affected_rows() > 0) {
           return TRUE;
        }else {
           // any trans error?
           if ($this->db->trans_status() === FALSE) {
               return false;
           }
           return true;
       }
    }

    function get_meterial_request($pagination_counter,$page_count,$stts){
    	$this->db->trans_start();
    	$this->db->select("hmpor.req_id,hmpor.prj_id,hmpor.lot_id,hmcm.mat_name,hmpor.qty,hmpor.req_date,hremp.initial as reqini,hremp.surname as reqsurname,hmpor.status,hremp2.initial as confini,hremp2.surname as confsurname,hm_projectms.project_name,hm_config_messuretype.mt_name");
    	$this->db->from("hm_po_request as hmpor");
    	$this->db->join("hm_config_material as hmcm","hmpor.mat_id=hmcm.mat_id");
    	$this->db->join("hr_empmastr as hremp","hmpor.request_by=hremp.id","left");
    	$this->db->join("hr_empmastr as hremp2","hmpor.confirm_by=hremp2.id","left");
      $this->db->join("hm_projectms","hmpor.prj_id=hm_projectms.prj_id");
      $this->db->join("hm_config_messuretype","hmcm.mt_id=hm_config_messuretype.mt_id");
    	if($stts!==""){
    	  $this->db->where("hmpor.status","PENDING");	
    	}
       // $this->db->order_by('hmpor.req_id','DESC');
      $this->db->order_by('hmpor.req_date','DESC');
    	$this->db->limit($pagination_counter, $page_count);

        $query=$this->db->get();
        $this->db->trans_complete();
    	if ($query->result() > 0) {
        return $query->result();
        }else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
               return false;
            }
            return true;
       }

    }

    function update_meterial_request_status($reqid,$updarr){
    	$this->db->where('req_id',$reqid);
    	$this->db->update('hm_po_request',$updarr);
      if ($this->db->affected_rows() > 0) {
        return true;
      }else{
        return false;
      }
    }

    function get_all_project_summery($branchid) { //get all stock
      $this->db->select('prj_id,project_name,branch_code');
      if(! check_access('all_branch')){
      $this->db->where('branch_code',$branchid);}
      $this->db->where('status','CONFIRMED');
      $this->db->order_by('prj_id');
      $query = $this->db->get('hm_projectms');
      if(count($query->result())>0){
         return $query->result();
      }else{
         return false;
      }
      
      }

     // 2020-1-9 created by terance = table search function..
     function get_searchkey_related_data($keyvalue,$stts){
      $this->db->select("hmpor.req_id,hmpor.prj_id,hmpor.lot_id,hmcm.mat_name,hmpor.qty,hmpor.req_date,hremp.initial as reqini,hremp.surname as reqsurname,hmpor.status,hremp2.initial as confini,hremp2.surname as confsurname,hm_projectms.project_name,hm_config_messuretype.mt_name");
      $this->db->from("hm_po_request as hmpor");
      $this->db->join("hm_config_material as hmcm","hmpor.mat_id=hmcm.mat_id");
      $this->db->join("hr_empmastr as hremp","hmpor.request_by=hremp.id","left");
      $this->db->join("hr_empmastr as hremp2","hmpor.confirm_by=hremp2.id","left");
      $this->db->join("hm_projectms","hmpor.prj_id=hm_projectms.prj_id");
      $this->db->join("hm_config_messuretype","hmcm.mt_id=hm_config_messuretype.mt_id");
      
        if($stts==1){
          $this->db->where("hmpor.status","PENDING");
          $this->db->like("hm_projectms.project_name",$keyvalue);
          $this->db->or_like("hmcm.mat_name",$keyvalue);
          $this->db->or_like("hmpor.req_date",$keyvalue);
        } else{
          $this->db->like("hm_projectms.project_name",$keyvalue);
          $this->db->or_like("hmcm.mat_name",$keyvalue);
          $this->db->or_like("hmpor.req_date",$keyvalue);
        } 
     
      $this->db->order_by("hmpor.req_date","DESC");
    
      $query=$this->db->get();
      //return $this->db->last_query();
        if ($query->result() > 0) {
         return $query->result();
        }else {
         return true;
        }
      }
}    