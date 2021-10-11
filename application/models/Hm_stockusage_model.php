<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_stockusage_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }



  function get_boq_task() { //get all boq task
    $this->db->select('hm_grnmain.*');
    $this->db->where('status','CONFIRMED');
    $this->db->order_by('hm_grnmain.grn_id','DESC');
    $query = $this->db->get('hm_grnmain');
    if(count($query->result())>0){
      return $query->result();
    }else{
      return false;
    }

  }

  function get_boqunitlots_material($prj_id,$lot_id,$task_id)
  {
    $this->db->select('hm_config_material.mat_code,
      hm_config_material.mat_name,
      hm_config_messuretype.mt_name,
      hm_prjfboqmaterial.*,SUM(hm_stockusage.qty) AS used_qty');
    $this->db->from('hm_prjfboqmaterial');
    $this->db->join('hm_config_material','hm_prjfboqmaterial.mat_id = hm_config_material.mat_id');
    $this->db->join('hm_config_messuretype','hm_config_material.mt_id = hm_config_messuretype.mt_id');
    $this->db->join('hm_stockusage','hm_prjfboqmaterial.id = hm_stockusage.task_id','left');
    $this->db->where('prj_id',$prj_id);
    $this->db->where('fboq_id',$task_id);
    if($lot_id){
      $this->db->where('lot_id',$lot_id);
    }
    $this->db->where('hm_prjfboqmaterial.value >','0');
    $this->db->group_by('hm_prjfboqmaterial.id');

    $query=$this->db->get();
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }


  //function get_met_rel_sitestocks($prjid,$metid){
  function get_mat_already_usage($prjid,$lot_id,$metid){

//      $where = "SELECT hm_sitestock.*,hm_stockbatch.*,((hm_sitestock.rcv_qty-hm_sitestock.ussed_qty)-hm_sitestock.trans_qty) as balqty,hm_sitestock.site_stockid,hm_sitestock.price as sitestockunitprice FROM
// hm_sitestock,hm_mainstock,hm_stockbatch,hm_grnmain
// WHERE
// hm_sitestock.stock_id=hm_mainstock.stock_id AND hm_mainstock.batch_id=hm_stockbatch.batch_id AND hm_stockbatch.grn_id=hm_grnmain.grn_id AND hm_sitestock.mat_id='$metid' AND hm_sitestock.prj_id='$prjid'";

  $this->db->select('hm_sitestock.*,((hm_sitestock.rcv_qty-hm_sitestock.ussed_qty)-hm_sitestock.trans_qty) as balqty,
  hm_stockbatch.batch_code');
  $this->db->join('hm_mainstock','hm_sitestock.stock_id = hm_mainstock.stock_id');
  $this->db->join('hm_stockbatch','hm_stockbatch.batch_id = hm_mainstock.batch_id');
  $this->db->where('hm_sitestock.prj_id',$prjid);
  if($lot_id){
    $value = array($lot_id, 0,'');
    $this->db->where_in('hm_sitestock.lot_id', $value);

  }

  $this->db->where('hm_sitestock.mat_id',$metid);
  $query = $this->db->get('hm_sitestock');
  if(count($query->result())>0){
    return $query->result();
  }else{
    return false;
  }




   }

   function add_meterial_usage($data,$stock_id,$total_usage)
 	{
    $insert=$this->db->insert('hm_stockusage',$data);
    if($insert){
      $data2 = array('ussed_qty' =>$total_usage , );
      $this->db->where('site_stockid',$stock_id);
      $update=$this->db->update('hm_sitestock',$data2);
      if($update){
        return true;
      }else{
        return false;
      }
    }


 	}




}
