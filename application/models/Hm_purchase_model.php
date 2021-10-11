<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_purchase_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }



  function get_purchase_item() { //get all stock
    $this->db->select('hm_pomain.*,cm_supplierms.first_name,cm_supplierms.last_name');
    $this->db->join('cm_supplierms','cm_supplierms.sup_code=hm_pomain.sup_id');
    $this->db->order_by('hm_pomain.poid','DESC');
    $query = $this->db->get('hm_pomain');
    if(count($query->result())>0){
       return $query->result();
    }else{
       return false;
    }
    
  }

  public function add_purchase()
  {
    $data=array('po_code'=>$this->input->post('number'),
    'sup_id'=>$this->input->post('supplier_id'),
    'tot_items'=>$this->input->post('tot_quantity'),
    'tot_price'=>$this->input->post('tot_tot_price'),
    'create_date'=>date('Y-m-d'),
    'send_date'=>$this->input->post('date'),
    'create_by'=>$this->session->userdata('userid'),
    'status'=>"PENDING",);

    if ( ! $this->db->insert('hm_pomain', $data))
    {
      $this->db->trans_rollback();
      $this->messages->add('Error addding Entry.', 'error');

      return;
    } else {
      $entry_id = $this->db->insert_id();
      $name=$this->input->post('name');
      $quantity=$this->input->post('quantity');
      $price=$this->input->post('price');
      $tot_price=$this->input->post('tot_price');
      $prj_id=$this->input->post('prj_id');
      $lot_id=$this->input->post('lot_id');
      $item_id=$this->input->post('itemid');
      $mat_id=$this->input->post('mat_id');
      $req_qty=$this->input->post('req_qty');
      $name_count=count($name);
      $i=0;
      while($i<$name_count){
        if($price[$i]>0){
          $data2 = array('po_id'=>$entry_id,
          'mat_id'=>$mat_id[$i],
          'qty'=>$quantity[$i],
          'buying_price'=>$price[$i],
          'prj_id'=>$prj_id[$i],
          'lot_id'=>$lot_id[$i],
          'rec_qty' =>0, );

            $insert2=$this->db->insert('hm_podata', $data2);
            if($insert2){
              $uparray = array('status' =>'USED' ,
              'poid'=>$entry_id,
              'po_itemid'=>$this->db->insert_id(),);
              $this->db->where('req_id',$item_id[$i]);
              $update=$this->db->update('hm_po_request',$uparray);
            }
        }

        $i=$i+1;
      }
    }
  }
  function delete_purchase($id)
  {
    //update to pending po_request tables
    $data_update = array('status' => 'APPROVED','poid'=>'','po_itemid'=>'');
    $this->db->where('poid',$id);
  	$update = $this->db->update('hm_po_request',$data_update);

    //delete main po
  	$this->db->where('poid',$id);
  	$insert = $this->db->delete('hm_pomain');

    //delete po items
  	$this->db->where('po_itemid',$id);
  	$insert2 = $this->db->delete('hm_podata');

    if($update && $insert && $insert2){
      return true;
    }else{
      $this->db->trans_rollback();
      return false;
    }

  }
  function get_purchase_item_byid($id)
  {
    $this->db->select('SUM(hm_podata.buying_price) AS tot_unit_price,SUM(hm_podata.qty) AS tot_quantity,
    SUM(hm_pomain.tot_price) AS tot_tot_price,hm_pomain.*,cm_supplierms.first_name,cm_supplierms.last_name');
    $this->db->join('cm_supplierms','cm_supplierms.sup_code=hm_pomain.sup_id');
    $this->db->join('hm_podata','hm_podata.po_id=hm_pomain.poid');
 		$this->db->where('hm_pomain.poid',$id);
    $query = $this->db->get('hm_pomain');
     if ($query->num_rows() > 0){
        $data= $query->row();
        return $data;
    }
		else
		{
			return false;
		}
  }

  function get_purchase_item_list_byid($id)
  {
    $this->db->select('hm_podata.*,hm_config_material.mat_name,hm_config_material.mat_code,hm_po_request.req_id,hm_config_messuretype.mt_name,hm_po_request.req_date');
    $this->db->join('hm_config_material','hm_podata.mat_id = hm_config_material.mat_id');
    $this->db->join('hm_config_messuretype','hm_config_messuretype.mt_id = hm_config_material.mt_id');
    $this->db->join('hm_po_request','hm_po_request.po_itemid = hm_podata.po_itemid');
    $this->db->where('hm_podata.po_id',$id);
    $query = $this->db->get('hm_podata');
     if ($query->num_rows() > 0){
      $data= $query->result();
        return $data;
    }
		else
		{
			return false;
		}
  }
  function approve_purchase()
  {
    $id=$this->input->post('number');
    $data = array('status' => 'CONFIRMED', 'confirmed_by'=>$this->session->userdata('userid') );
    $this->db->where('poid',$id);
  	$insert = $this->db->update('hm_pomain',$data);
    if ($this->db->affected_rows() > 0) {
       return true;
    }else{
       return false;
    }
  }
  function edit_purchase()
  {
    //update purchase order total price
    $entry_id = $this->input->post('number');
    $data = array('tot_price' => $this->input->post('tot_tot_price'),'tot_items' => $this->input->post('tot_quantity'));
    $this->db->where('poid',$entry_id);
  	$update = $this->db->update('hm_pomain',$data);

    //update to pending po_request tables
    $data_update = array('status' => 'APPROVED','poid'=>'','po_itemid'=>'');
    $this->db->where('poid',$entry_id);
  	$update = $this->db->update('hm_po_request',$data_update);

    //delete old purchase order item details
    $this->db->where('po_id',$entry_id);
  	$insert = $this->db->delete('hm_podata');

    //update new oder details
    if($update){
      $name=$this->input->post('name');
      $quantity=$this->input->post('quantity');
      $price=$this->input->post('price');
      $tot_price=$this->input->post('tot_price');
      $prj_id=$this->input->post('prj_id');
      $lot_id=$this->input->post('lot_id');
      $item_id=$this->input->post('itemid');
      $mat_id=$this->input->post('mat_id');
      $req_qty=$this->input->post('req_qty');
      $name_count=count($name);
      $i=0;
      while($i<$name_count){
        if($price[$i]>0){
          $data2 = array('po_id'=>$entry_id,
          'mat_id'=>$mat_id[$i],
          'qty'=>$quantity[$i],
          'buying_price'=>$price[$i],
          'prj_id'=>$prj_id[$i],
          'lot_id'=>$lot_id[$i],
          'rec_qty' =>0, );

            $insert2=$this->db->insert('hm_podata', $data2);
            if($insert2){
              $uparray = array('status' =>'USED' ,
              'poid'=>$entry_id,
              'po_itemid'=>$this->db->insert_id(),);
              $this->db->where('req_id',$item_id[$i]);
              $update=$this->db->update('hm_po_request',$uparray);
            }
        }
        $i=$i+1;
      }
    }

  }

  //2019-12-02 purchase purchase_orders
  function get_po_request_data(){
    $this->db->select('hm_po_request.*,hm_config_material.mat_name,hm_config_material.mat_code,hm_config_messuretype.mt_name');
    $this->db->join('hm_config_material','hm_po_request.mat_id = hm_config_material.mat_id');
    $this->db->join('hm_config_messuretype','hm_config_messuretype.mt_id = hm_config_material.mt_id');
    $this->db->where('hm_po_request.status',"APPROVED");
    $this->db->order_by('hm_po_request.req_date',"ASC");
    $query=$this->db->get('hm_po_request');
    if(count($query->result())>0){
      return $query->result();
    }else{
      return false;
    }

  }

  function get_suplier_orders($supid)
  {
    $this->db->select('hm_po_request.*,hm_config_material.mat_name,hm_config_material.mat_code');
    $this->db->join('hm_config_material','hm_po_request.mat_id = hm_config_material.mat_id');
    $this->db->join('cm_suppliermaterial','cm_suppliermaterial.mat_id = hm_config_material.mat_id');
    $this->db->where('hm_po_request.status',"APPROVED");
    $this->db->where('cm_suppliermaterial.sup_code',$supid);
    $this->db->order_by('hm_po_request.req_date',"ASC");
    $query=$this->db->get('hm_po_request');
    if(count($query->result())>0){
      return $query->result();
    }else{
      return false;
    }
  }

  /* new code added 2019-12-24 by terance perera.. */
  function get_last_po_nmbr(){
    $this->db->select('po_code');
    $this->db->from('hm_pomain');
    $this->db->order_by('poid','DESC');
    $this->db->limit(1);

    $query = $this->db->get();
    if(count($query->result())>0){
      return $query->row();
    }else{
      return false;
    }
    
  }
  /* new code added 2019-12-24 by terance perera.. */

  //created by terance 2020-1-09.
   function get_searchkey_related_data($keyvalue){
        $this->db->select('hm_pomain.*,cm_supplierms.first_name,cm_supplierms.last_name');
        $this->db->from('hm_pomain');
        $this->db->join('cm_supplierms','hm_pomain.sup_id=cm_supplierms.sup_code');
        $this->db->like('cm_supplierms.first_name',urldecode($keyvalue));
        $this->db->or_like('cm_supplierms.last_name',urldecode($keyvalue));
        $this->db->or_like('hm_pomain.send_date',urldecode($keyvalue));
        $this->db->or_like('hm_pomain.po_code',urldecode($keyvalue));
    
     $this->db->order_by('hm_pomain.poid','DESC');
     $query = $this->db->get();
     //return $this->db->last_query();
     if(count($query->result())>0){
       return $query->result();
     }else{
       return false;
     }
   }

}
