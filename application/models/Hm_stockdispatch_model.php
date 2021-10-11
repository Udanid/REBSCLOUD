<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_stockdispatch_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }



  function get_grn_all() { //get all stock
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

  function get_stock_dataset($mat_id)
  {
    $this->db->select('hm_mainstock.*,hm_stockbatch.batch_code');
    $this->db->join('hm_stockbatch','hm_stockbatch.batch_id = hm_mainstock.batch_id');
    $this->db->where('(hm_mainstock.rcv_qty-IFNULL(hm_mainstock.ussed_qty, 0)) >',0);
    $this->db->where('hm_mainstock.mat_id',$mat_id);
    $query = $this->db->get('hm_mainstock');
    if(count($query->result())>0){
      return $query->result();
    }else{
      return false;
    }
  }

  function add_dispatch($data,$stock_id,$amount)
  {
    $insert=$this->db->insert('hm_sitestock',$data);
    if($insert)
    {
      $update_data = array('ussed_qty' =>$amount );
      $this->db->where('stock_id',$stock_id);
      $update=$this->db->update('hm_mainstock',$update_data);
      if($update)
      {
        return true;
      }else{
        return false;
      }
    }
  }

  function get_site_stock_transfers($pagination_counter, $page_count)
  {
    $this->db->select("*");
    $this->db->order_by('site_stockid','DESC');
    $this->db->limit($pagination_counter, $page_count);
    $query=$this->db->get('hm_sitestock');

    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }

  function get_site_stock_transfers_byid($site_stockid)
  {
    $this->db->select("hm_sitestock.*,hm_mainstock.ussed_qty AS mainstock_qty");
    $this->db->join('hm_mainstock','hm_sitestock.stock_id = hm_mainstock.stock_id');
    $this->db->where('site_stockid',$site_stockid);
    $query=$this->db->get('hm_sitestock');


    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }

  function confirm_dispatch($site_stockid)
  {
    $update_data = array('status' =>'RECEIVED','dispatch_date'=>date("Y-m-d H:i:s") );
    $this->db->where('site_stockid',$site_stockid);
    $update=$this->db->update('hm_sitestock',$update_data);
    if($update)
    {
      return true;
    }else{
      return false;
    }
  }

  function delete_dispatch($site_stockid)
  {
    $stock_data=$this->get_site_stock_transfers_byid($site_stockid);
    $amount=$stock_data->mainstock_qty-$stock_data->rcv_qty;
    $update_data = array('ussed_qty' =>$amount );
    $this->db->where('stock_id',$stock_data->stock_id);
    $update=$this->db->update('hm_mainstock',$update_data);
    if($update)
    {
      $this->db->where('site_stockid',$site_stockid);
      $delete=$this->db->delete('hm_sitestock');
      if($delete){
        return true;
      }
    }else{
      return false;
    }

  }

  function get_all_pending_purchaserequest($prj_id,$lot_id)
  {
    $this->db->select('*');
    $this->db->where('prj_id',$prj_id);
    if($lot_id)
    {
      $this->db->where('lot_id',$lot_id);
    }
    $this->db->where('status','APPROVED');
    $query=$this->db->get('hm_po_request');
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }
  function get_all_pendingandused_purchaserequest($prj_id,$lot_id)
  {
    $this->db->select('*');
    $this->db->where('prj_id',$prj_id);
    if($lot_id)
    {
      $this->db->where('lot_id',$lot_id);
    }
    $statues_ary=array('APPROVED','USED');
    $this->db->where_in('status',$statues_ary);
    $this->db->where('(qty-dispatched_qty)>',0);
    $query=$this->db->get('hm_po_request');
    if(count($query->result())>0)
    {
      return $query->result();
    }else{
      return false;
    }
  }
  function get_all_pending_purchaserequestby_id($req_id)
  {
    $this->db->select('*');
    $this->db->where('req_id',$req_id);
    $query=$this->db->get('hm_po_request');
    if(count($query->result())>0)
    {
      return $query->row();
    }else{
      return false;
    }
  }



  function request_update($req_id,$amount)
  {
    $req_data=$this->get_all_pending_purchaserequestby_id($req_id);
    $new_dispatch=$req_data->dispatched_qty+$amount;
    $new_statues=$req_data->status;
    if($new_dispatch==$req_data->qty){
      $new_statues="DISPATCHED";
    }
    $data = array('dispatched_qty' =>$new_dispatch ,
      'dispatch_date'=>date('Y-m-d'),
      'status'=>$new_statues);
    $this->db->where('req_id',$req_id);
    $update=$this->db->update('hm_po_request',$data);
    if($update)
    {
      return true;
    }else{
      return false;
    }
  }




}
