<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by terance perera
//date:2019-12-02

class Hm_helper_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_meterial_site($matid,$prjid){
        $this->db->select('SUM(rcv_qty) as totqty,SUM(trans_qty) trnqty');
        $this->db->from('hm_sitestock');
        $this->db->where('hm_sitestock.prj_id',$prjid);
		 $this->db->where('hm_sitestock.mat_id',$matid);
     
         $query = $this->db->get();
		// echo $this->db->last_query();
		 if ($query->num_rows() > 0){
			$data= $query->row();
			$qty= $data->totqty - $data->trnqty;
			return $qty;
		} 
		else
		{
			return 0;
		}
    }
	function get_meterial_boq($matid,$prjid){
        $this->db->select('SUM(value) as totqty');
        $this->db->from('hm_prjfboqmaterial');
        $this->db->where('hm_prjfboqmaterial.prj_id',$prjid);
		 $this->db->where('hm_prjfboqmaterial.mat_id',$matid);
     
         $query = $this->db->get();
		 if ($query->num_rows() > 0){
			$data= $query->row();
			$qty= $data->totqty;
			return $qty;
		} 
		else
		{
			return 0;
		}
    }
function get_project_progress_images($prjid,$lot_id){
    	$this->db->select('hm_prjprogress_img.*,hm_prjprogress.id as progid');
    	$this->db->join('hm_prjprogress','hm_prjprogress_img.progress_id=hm_prjprogress.id');
    	 $this->db->where('hm_prjprogress.prj_id',$prjid);	
		 $this->db->where('hm_prjprogress.lot_id',$lot_id);	
    	$this->db->order_by('hm_prjprogress.id','ASC');
    	
    	$query = $this->db->get('hm_prjprogress_img');
    	 if ($query->num_rows() > 0){
			return $query->result();
		} 
		else
		{
			return false;
		}
    }
function get_meterial_list(){
        $this->db->select('*');
        $this->db->from('hm_config_material');
         $query = $this->db->get();
		 if ($query->num_rows() > 0){
			return $query->result();
		} 
		else
		{
			return false;
		}
    }
	 function get_subboq_by_designid($design_id)
  {
    $this->db->select("hm_config_boqsubcat.*,hm_config_boqcat.cat_name");
     $this->db->join('hm_config_boqcat','hm_config_boqcat.boqcat_id=hm_config_boqsubcat.boqcat_id');
    $this->db->where('hm_config_boqcat.design_id',$design_id);
     $query=$this->db->get("hm_config_boqsubcat");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }
   function get_tasklit_prj_lot_saubcatid($prj_id,$lot_id,$subcatid)
  {
    $this->db->select("hm_prjfboq.*,hm_config_boqtask.description");
     $this->db->join('hm_config_boqtask','hm_config_boqtask.boqtask_id=hm_prjfboq.boqtask_id');
    $this->db->where('hm_prjfboq.boqsubcat_id',$subcatid);
	  $this->db->where('hm_prjfboq.prj_id',$prj_id);
	    $this->db->where('hm_prjfboq.lot_id ',$lot_id );
     $query=$this->db->get("hm_prjfboq");
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }
  
  function get_meterial_cost($prjid,$unitid,$subcatid)
  {
	$this->db->select("hm_stockusage.qty,hm_sitestock.price");
     $this->db->join('hm_prjfboqmaterial','hm_prjfboqmaterial.id=hm_stockusage.task_id');
	  $this->db->join('hm_prjfboq','hm_prjfboq.id=hm_prjfboqmaterial.fboq_id');
	    $this->db->join('hm_sitestock','hm_sitestock.site_stockid=hm_stockusage.site_stockid');
    $this->db->where('hm_prjfboq.prj_id',$prjid);
	 $this->db->where('hm_prjfboq.lot_id',$unitid);
	  $this->db->where('hm_prjfboq.boqsubcat_id',$subcatid);
	 //
     $query=$this->db->get("hm_stockusage");
	 
    if(count($query->result())>0)
    {
		$tot=0;
		$dataset=$query->result();
		foreach($dataset as $raw)
		{
			$tot=$tot+ ($raw->price*$raw->qty);
		}
		return $tot;
     
    }else{
      return 0;
    }  
  }
  
   function get_service_cost($prjid,$unitid,$subcatid)
  {
	$this->db->select("SUM(pay_amount) as tot");
       $this->db->where('hm_service_payments.prj_id',$prjid);
	 $this->db->where('hm_service_payments.lot_id',$unitid);
	  $this->db->where('hm_service_payments.subcat_id',$subcatid);
	 //
     $query=$this->db->get("hm_service_payments");
	 
    if(count($query->result())>0)
    {
		$tot=0;
		$dataset=$query->row();
		
		return $dataset->tot;
     
    }else{
      return 0;
    }  
  }
  function get_subcat_total($prjid,$unitid,$subcatid)
  {
	$this->db->select("SUM(amount) as tot");
       $this->db->where('hm_prjfboq.prj_id',$prjid);
	 $this->db->where('hm_prjfboq.lot_id',$unitid);
	  $this->db->where('hm_prjfboq.boqsubcat_id',$subcatid);
	 //
     $query=$this->db->get("hm_prjfboq");
	 
    if(count($query->result())>0)
    {
		$tot=0;
		$dataset=$query->row();
		
		return $dataset->tot;
     
    }else{
      return 0;
    }  
  }
  function get_used_meterial_list($prjid,$unitid,$subcatid)
  {
	$this->db->select("hm_stockusage.qty,hm_sitestock.price,hm_config_material.mat_name");
     $this->db->join('hm_prjfboqmaterial','hm_prjfboqmaterial.id=hm_stockusage.task_id');
	  $this->db->join('hm_prjfboq','hm_prjfboq.id=hm_prjfboqmaterial.fboq_id');
	    $this->db->join('hm_sitestock','hm_sitestock.site_stockid=hm_stockusage.site_stockid');
		$this->db->join('hm_config_material','hm_config_material.mat_id=hm_sitestock.mat_id');
    $this->db->where('hm_prjfboq.prj_id',$prjid);
	 $this->db->where('hm_prjfboq.lot_id',$unitid);
	  $this->db->where('hm_prjfboq.boqsubcat_id',$subcatid);
	 //
     $query=$this->db->get("hm_stockusage");
	 
    if(count($query->result())>0)
    {
		$tot=0;
		return $query->result();
		
     
    }else{
      return false;
    }  
  }
   function get_service_list($prjid,$unitid,$subcatid)
  {
	$this->db->select("hm_config_services.service_name,hm_service_payments.*");
		$this->db->join('hm_config_services','hm_config_services.service_id=hm_service_payments.service_id');
   
       $this->db->where('hm_service_payments.prj_id',$prjid);
	 $this->db->where('hm_service_payments.lot_id',$unitid);
	  $this->db->where('hm_service_payments.subcat_id',$subcatid);
	 //
     $query=$this->db->get("hm_service_payments");
	 
    if(count($query->result())>0)
    {
		
		return $query->result();
     
    }else{
      return 0;
    }  
  }
  function get_task_labor($prjid,$lot_id,$boq_taskid){
        $this->db->select('amount');
        $this->db->from('hm_prjfboq_labor');
        $this->db->where('prj_id',$prjid);
		   $this->db->where('lot_id',$lot_id);
		      $this->db->where('boq_taskid',$boq_taskid);
	     $query = $this->db->get();
		 if ($query->num_rows() > 0){
			$data= $query->row();
			$qty= $data->amount;
			return $qty;
		} 
		else
		{
			return 0;
		}
    }
}
