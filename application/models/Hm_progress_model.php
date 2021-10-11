<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by terance perera
//date:2019-12-02

class Hm_progress_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_current_progress($prjid,$lotid,$stageid){
    	$this->db->select('hm_progress_master.progress,hm_progress_master.prj_id,hm_progress_master.lot_id,hm_config_shortcode.description');
    	$this->db->from('hm_progress_master');
    	$this->db->join('hm_config_shortcode','hm_progress_master.stage_id=hm_config_shortcode.code_id');
    	$this->db->where('hm_progress_master.prj_id',$prjid);
    	$this->db->where('hm_progress_master.lot_id',$lotid);
    	$this->db->where('hm_progress_master.stage_id',$stageid);

    	$query = $this->db->get();
        if(count($query->result())>0){
            return $query->row();
        }else{
            return false;
        }
    	
    }

    function get_current_data($prjid,$lotid,$related_code){
    	$this->db->select('*');
    	$this->db->from('hm_progress_master');
    	$this->db->where('hm_progress_master.prj_id',$prjid);
    	$this->db->where('hm_progress_master.lot_id',$lotid);
    	$this->db->where('hm_progress_master.stage_id',$related_code);
    	$query = $this->db->get();
        if(count($query->result())>0){
    	return $query->row();
        }else{
        return false;    
        }
    }

    function insert_progress_master($insertprogressmsterarr,$tblname){
        $this->db->insert($tblname,$insertprogressmsterarr);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function update_progress_master($updarr,$recid){
    	$this->db->where('id',$recid);
    	$this->db->update('hm_progress_master',$updarr);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        } 
        //return $this->db->last_query();
    }

    

    function get_progerss_rel_actions($prjid,$lotid,$stageid){
    	$this->db->where('prj_id',$prjid);
    	$this->db->where('lot_id',$lotid);
    	$this->db->where('stage_id',$stageid);
    	$this->db->order_by('id','ASC');
    	$query = $this->db->get('hm_prjprogress');
        if(count($query->result())>0){
           return $query->result(); 
       }else{
           return false;
       }
    	
    }

    function get_project_progress_images($prj_prgress_id,$stts){
    	$this->db->select('*,hm_prjprogress.id as progid');
    	$this->db->from('hm_prjprogress_img');
    	$this->db->join('hm_prjprogress','hm_prjprogress_img.progress_id=hm_prjprogress.id');
    	$this->db->join('hm_config_shortcode','hm_prjprogress.stage_id=hm_config_shortcode.code_id');
    	if($prj_prgress_id){
    	  $this->db->where('hm_prjprogress_img.progress_id',$prj_prgress_id);
    	}

    	if($stts){
    	  $this->db->where('hm_prjprogress.progress_status',$stts);	
    	}
        
       /* if($prj_prgress_id==""){
           $this->db->group_by('hm_prjprogress_img.progress_id');
        } */

    	$this->db->order_by('hm_prjprogress.id','ASC');
    	
    	$query = $this->db->get();
        if(count($query->result())>0){
    	return $query->result();
        }else{
        return false;    
        }
    }

    function update_project_progress_tbl($id,$updprogressstts){
    	$this->db->where('id',$id);
    	$this->db->update('hm_prjprogress',$updprogressstts);
        if($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    function get_project_progreses($id){
    	//$this->db->where('id',$id);
    	/*$sql = "SELECT * FROM hm_progress_master WHERE 
prj_id IN (SELECT prj_id FROM hm_prjprogress WHERE id='$id') AND 
lot_id IN (SELECT lot_id FROM hm_prjprogress WHERE id='$id') AND 
stage_id IN (select stage_id FROM hm_prjprogress WHERE id='$id')"; */
        $sql = "SELECT hm_progress_master.id AS masterprogid,hm_progress_master.progress AS masterprogress FROM hm_prjprogress,hm_progress_master WHERE 
hm_prjprogress.prj_id=hm_progress_master.prj_id AND hm_prjprogress.lot_id=hm_progress_master.lot_id AND hm_prjprogress.stage_id=hm_progress_master.stage_id AND hm_prjprogress.id='$id'";   

    	$query = $this->db->query($sql);
        if(count($query->result())>0){
            return $query->row(); 
        }else{
            return false;
        }
    }

    function get_lotwise_progress($prjid,$lotid,$codeid){
        $this->db->select('progress');
        $this->db->where('prj_id',$prjid);
        $this->db->where('lot_id',$lotid);
        $this->db->where('stage_id',$codeid);
        $query = $this->db->get('hm_progress_master');
        if(count($query->result())>0){
        return $query->row();
        }else{
        return false;    
        }
    }


    function get_working_progress($prjid,$lotid){
       $sql = "SELECT * FROM hm_progress_master AS hmpm,hm_config_shortcode AS hmsc WHERE hmpm.stage_id=hmsc.code_id AND hmpm.prj_id='$prjid' AND hmpm.lot_id='$lotid'";
       $query = $this->db->query($sql);
       if(count($query->result())>0){
        return $query->result();
       }else{
        return false;
       }
    }

    function get_lotwise_progress_for_project($prjid,$lotid,$stageid){
        $this->db->select('*');
        $this->db->from('hm_prjprogress');
        $this->db->where('prj_id',$prjid);
        $this->db->where('lot_id',$lotid);
        $this->db->where('stage_id',$stageid);
        $this->db->where('progress_status','APPROVED');
        $this->db->order_by('id','DESC');

        $query = $this->db->get();
        if(count($query->result())>0){
        return $query->result();
        }else{
        return false;    
        }
    }

    
}