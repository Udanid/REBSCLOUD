<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class purchase_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }



  function get_purchase_item() { //get all stock
    $this->db->select('ac_purchase_orders.*,cm_supplierms.first_name,cm_supplierms.last_name');
    $this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_purchase_orders.supplier');
    $this->db->order_by('ac_purchase_orders.purchase_id','DESC');
    $query = $this->db->get('ac_purchase_orders');
    return $query->result();
  }

  public function add_purchase()
  {
    $data=array(
      'purchase_number' => $this->input->post('number'),
      'supplier' => $this->input->post('supplier_id'),
      'purchase_type' => $this->input->post('type'),
      'purchase_date' => $this->input->post('date'),
      'tot_price' => $this->input->post('tot_tot_price'),
      //'description' => $this->input->post('note'),
      'statues' => 'PENDING',
      'added_by' => $this->session->userdata('username'),
      'added_at' =>date("Y-m-d"),
    );

    if ( ! $this->db->insert('ac_purchase_orders', $data))
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
      $name_count=count($name);
      $i=0;
      while($i<$name_count){
        $data2 =array(
            'purchase_id' => $entry_id ,
            'item_name'=>$name[$i],
            'unit_price'=>$price[$i],
            'quantity'=>$quantity[$i],
            'tot_price'=>$tot_price[$i],

          );
          $this->db->insert('ac_purchase_item', $data2);
        $i=$i+1;
      }
    }
  }
  function delete_purchase($id)
  {
	  if($id)
	  {

			$this->db->where('purchase_id',$id);
			$insert = $this->db->delete('ac_purchase_orders');
			$this->db->where('purchase_id',$id);
			$insert = $this->db->delete('ac_purchase_item');
	  }

  }
  function get_purchase_item_byid($id)
  {
    $this->db->select('SUM(ac_purchase_item.unit_price) AS tot_unit_price,SUM(ac_purchase_item.quantity) AS tot_quantity,
    SUM(ac_purchase_item.tot_price) AS tot_tot_price,ac_purchase_orders.*,cm_supplierms.first_name,cm_supplierms.last_name');
    $this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_purchase_orders.supplier');
    $this->db->join('ac_purchase_item','ac_purchase_item.purchase_id=ac_purchase_orders.purchase_id');
 		$this->db->where('ac_purchase_orders.purchase_id',$id);
    $query = $this->db->get('ac_purchase_orders');
     if ($query->num_rows() > 0){
      $data= $query->row();
        return $data;
    }
    else
    return false;
  }

  function get_purchase_item_list_byid($id)
  {
    $this->db->select('ac_purchase_item.*');
    $this->db->where('ac_purchase_item.purchase_id',$id);
    $query = $this->db->get('ac_purchase_item');
     if ($query->num_rows() > 0){
      $data= $query->result();
        return $data;
    }
    else
    return false;
  }
  function approve_purchase()
  {
    $id=$this->input->post('number');
    $data = array('statues' => 'CONFIRMED', );
    $this->db->where('purchase_id',$id);
  	$insert = $this->db->update('ac_purchase_orders',$data);
  }
  function edit_purchase()
  {
    //update purchase order total price
    $entry_id = $this->input->post('number');
    $data = array('tot_price' => $this->input->post('tot_tot_price'));
    $this->db->where('purchase_id',$entry_id);
  	$update = $this->db->update('ac_purchase_orders',$data);

    //delete old purchase order item details
    $this->db->where('purchase_id',$entry_id);
  	$insert = $this->db->delete('ac_purchase_item');

    //update new oder details
    if($update){
      $name=$this->input->post('name');
      $quantity=$this->input->post('quantity');
      $price=$this->input->post('price');
      $tot_price=$this->input->post('tot_price');
      $name_count=count($name);
      $i=0;
      while($i<$name_count){
        $data2 =array(
            'purchase_id' => $entry_id ,
            'item_name'=>$name[$i],
            'unit_price'=>$price[$i],
            'quantity'=>$quantity[$i],
            'tot_price'=>$tot_price[$i],

          );
          $this->db->insert('ac_purchase_item', $data2);
        $i=$i+1;
      }
    }

  }

  //Ticket No-2861 | Added By Uvini
  function get_confirmed_po_list($sup_code){
    $this->db->select('*');
    $this->db->where('supplier',$sup_code);
    $this->db->where('statues','CONFIRMED');
    $query = $this->db->get('ac_purchase_orders');
     if ($query->num_rows() > 0){
        return $query->result();
    }
    else
    return false;
  }


}
