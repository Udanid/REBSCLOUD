<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by nadee_randeniya
//date:18/05/2018

class Fixedasset_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }
  function get_asset_category()
  { //get all asset category
    $this->db->select('*');
    $this->db->order_by('asset_category');
    $query = $this->db->get('ac_fixedasset_cat');
    return $query->result();
  }

  function get_leger_names($leger_code)
  { //get leger name by code
    $this->db->select('name,type,id,ref_id');
    $this->db->where('id',$leger_code);

    $query = $this->db->get('ac_ledgers');
    if ($query->num_rows() > 0){
      //$data= $query->row();
      return $query->row();
    }
    else
    return 0;
  }

  function get_all_legers()
  { //get all asset
    $this->db->select('id,name');
    $this->db->order_by('name');
    $query = $this->db->get('ac_ledgers');
    return $query->result();
  }

  function get_all_branches()
  { //get all asset
    $this->db->select('branch_code,branch_name');
    $this->db->order_by('branch_code');
    $query = $this->db->get('cm_branchms');
    return $query->result();
  }

  function add()
  {
    $dep_amount=$this->input->post('dep_presantage');
    if(!$dep_amount){
      $dep_amount=0;
    }
    $data=array(
      'asset_category' => $this->input->post('asset_cat_name'),
      'intangible_flag' => $this->input->post('asset_type'),
      'depreciation_presantage' => $dep_amount,
      'leger_acc' => $this->input->post('leger_acc'),
      'depreciation_acc' => $this->input->post('depre_acc'),
      'provision_acc' => $this->input->post('provi_acc'),
      'disposal_acc' => $this->input->post('dispo_acc'),
      'create_at' => date("Y-m-d"),
      'create_by' => $this->session->userdata('username'),

    );

    $insert = $this->db->insert('ac_fixedasset_cat', $data);
    return $this->db->insert_id();
  }
  function get_assets()
  { //get all assets
    $this->db->select('*');
    $this->db->order_by('asset_name');
    $this->db->where_not_in('statues','DISPOSAL');
    $query = $this->db->get('ac_fixedassets');
    return $query->result();
  }
  function get_assets_all()
  { //get all assets
    $this->db->select('*');
    $this->db->order_by('asset_name');
    $query = $this->db->get('ac_fixedassets');
    return $query->result();
  }
  function get_dispoassets()
  { //get all assets
    $this->db->select('*');
    $this->db->order_by('asset_name');
    $this->db->where('statues','DISPOSAL');
    $this->db->or_where('statues','DISPOSAL PENDING');
    $query = $this->db->get('ac_fixedassets');
    return $query->result();
  }

  function get_asset_category_byid($id)
  {
    $this->db->select('id,asset_category,
    intangible_flag,
    depreciation_presantage,
    leger_acc,
    depreciation_acc,
    provision_acc,
    disposal_acc
    ');
    $this->db->where('id',$id);

    $query = $this->db->get('ac_fixedasset_cat');
    if ($query->num_rows() > 0){
      return $query->row();
    }
    else
    return 0;
  }

  function add_asset($file_name)
  {
    $year=$this->input->post('year');
    if(!$year){
      $year=date("Y-m-d");
    }
    $data=array(

      'category_id' => $this->input->post('asset_cat'),
      'sub_cat_id'=> $this->input->post('assetsub_cat'),
      'branch' => $this->input->post('branch_code'),
      'brand'=> $this->input->post('asset_brand'),
      'serial_no'=> $this->input->post('serial_no'),
      'division'=> $this->input->post('division_code'),
      'user'=> $this->input->post('user_code'),
      'asset_name' => $this->input->post('asset_name'),
      'asset_code' => $this->input->post('asset_code'),
      'asset_value' => $this->input->post('asset_val'),
      'purches_value'=> $this->input->post('asset_val'),
      'year' => $year,
      'quantity'=>'1',
      'remarks' => $this->input->post('remarks'),
      'purchase_by' => $this->input->post('purchase'),
      'attachments'=>$file_name,
      'create_at' => date("Y-m-d"),
      'create_by' => $this->session->userdata('username'),
    );

    $insert = $this->db->insert('ac_fixedassets', $data);
    if($insert){
      return $this->db->insert_id();
    }
    else
    return 0;
  }
  function get_asset_byid($id)
  {
    $this->db->select('*');
    $this->db->where('id',$id);
    $query = $this->db->get('ac_fixedassets');
    return $query->row();
  }

  function edit_asset()
  {
    $year=$this->input->post('year');
    if(!$year){
      $year=date("Y-m-d");
    }
    $data=array(
      'category_id' => $this->input->post('asset_cat'),
      'asset_name' => $this->input->post('asset_name'),
      'branch' => $this->input->post('branch_code'),
      'brand'=> $this->input->post('asset_brand'),
      'serial_no'=> $this->input->post('serial_no'),
      'division'=> $this->input->post('division_code'),
      'user'=> $this->input->post('user_code'),
      'asset_code' => $this->input->post('asset_code'),
      'asset_value' => $this->input->post('asset_val'),
      'purches_value'=> $this->input->post('asset_val'),
      'year' => $year,
      'remarks' => $this->input->post('remarks'),
      'purchase_by' => $this->input->post('purchase'),
      'modify_at' => date("Y-m-d"),
      'modify_by' => $this->session->userdata('username'),

    );
    $this->db->where('id', $this->input->post('asset_id'));
    $update = $this->db->update('ac_fixedassets', $data);
    if($update){
      return true;
    }
    else
    return 0;

  }

  function edit_category()
  {
    $dep_amount=$this->input->post('dep_presantage');
    if(!$dep_amount){
      $dep_amount=0;
    }
    $data=array(
      'asset_category' => $this->input->post('asset_cat_name'),
      'intangible_flag' => $this->input->post('asset_type'),
      'depreciation_presantage' => $dep_amount,
      'leger_acc' => $this->input->post('leger_acc'),
      'depreciation_acc' => $this->input->post('depre_acc'),
      'provision_acc' => $this->input->post('provi_acc'),
      'disposal_acc' => $this->input->post('dispo_acc'),
      'modify_at' => date("Y-m-d"),
      'modify_by' => $this->session->userdata('username'),

    );

    $this->db->where('id', $this->input->post('asset_cat_id'));
    $update = $this->db->update('ac_fixedasset_cat', $data);
    if($update){
      return true;
    }
    else
    return 0;
  }
  function delete($id)
  {
	  if($id)
	  {
    //should check assigned to loan or invoised
		$this->db->where('id', $id);
		$insert = $this->db->delete('ac_fixedassets');
		return $insert;
	  }

  }
  function confirm($id)
  {
    $data=array(
      'statues' => 'CONFIRMED',
      'modify_at' => date("Y-m-d"),
      'modify_by' => $this->session->userdata('username'),
    );
    $this->db->where('id', $id);
    $insert = $this->db->update('ac_fixedassets', $data);
    return $insert;

  }
  function get_remarks_byid($id)
  {
    $this->db->select('id,asset_name,remarks');
    $this->db->where('id',$id);
    $query = $this->db->get('ac_fixedassets');
    return $query->row();
  }
  function add_subasset()
  {
    $hiddensub_cat_code= $this->input->post('hiddensub_cat_code');
    $last_code=$hiddensub_cat_code.$this->input->post('assetsub_cat_name')."-000";
    $data=array(
      'cat_id' => $this->input->post('assetcat_type'),
      'sub_cat_name' => $this->input->post('assetsub_cat_name'),
      'sub_cat_code' => $this->input->post('assetsub_cat_code'),
      'sub_cat_lastid' => $last_code,
      'created_by' => $this->session->userdata('username'),
      'created_at' => date("Y-m-d"),

    );

    $insert = $this->db->insert('ac_fixedasset_subcat', $data);
    return $this->db->insert_id();
  }

  function get_sub_assets($sub_asset)
  {
    $this->db->select('*');
    $this->db->where('cat_id',$sub_asset);
    $this->db->order_by('sub_cat_name');
    $query = $this->db->get('ac_fixedasset_subcat');
    return $query->result();
  }
  function get_sub_assets_byid($id)
  {
    $this->db->select('*');
    $this->db->where('sub_cat_id',$id);
    $this->db->order_by('sub_cat_name');
    $query = $this->db->get('ac_fixedasset_subcat');
    return $query->row();
  }

  function disposal_asset()
  {
    $year=$this->input->post('year');
    if(!$year){
      $year=date("Y-m-d");
    }
    $i='';
    $x='';
    $id=$this->input->post('disposal_id');
    $data=array(
        'statues' => 'DISPOSAL PENDING',//disposal
        'disposal_value'=>$this->input->post('disposal_value'),
        'disposal_at' => date("Y-m-d"),
        'disposal_by' => $this->session->userdata('username'),

      );
      $this->db->where('id', $id);
      $update = $this->db->update('ac_fixedassets', $data);
      if($update){
        return true;
      }

  }

  function confirm_disposal($id)
  {
    $year=date("Y-m-d");
    $i='';
    $x='';
    $query1=$this->get_asset_byid($id);
    if($query1){
      $catid=$query1->category_id;
      $value=$query1->asset_value;
      $query2=$this->get_asset_category_byid($catid);
      if($query2){
        $leger_id=$query2->leger_acc;
        $depre_acc_id=$query2->depreciation_acc;
        $dispo_acc_id=$query2->disposal_acc;
        if($depre_acc_id){
          $this->db->select('SUM(depreciation_value) AS depreciation_value');
          $this->db->where('asset_id',$id);
          $this->db->where('depreciation_leger_id',$depre_acc_id);
          $this->db->where('leger_id',$leger_id);
          $query2 = $this->db->get('ac_fixedasset_depreciation');
          $val = $query2->row();
          $amount=0.00;
          if($val->depreciation_value==''){
            $amount=0.00;
          }else{
            $amount=$val->depreciation_value;
          }
          $crlist[0]['ledgerid']=$dispo_acc_id;
          $crlist[0]['amount']=$amount;
          $drlist[0]['ledgerid']=$depre_acc_id;
          $drlist[0]['amount']=$amount;
          $crtot=$drtot=$amount;
          $date=date("Y-m-d");
          $narration=$id.' -  Asset  disposal-'.$leger_id.' depreciation value Transfers to Acc-'.$dispo_acc_id;
          $entryid=$this->asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
          if(!$entryid){
            $x=0;
          }else{
            $x=1;
          }
        }
        if($dispo_acc_id){
          $crlist[0]['ledgerid']=$leger_id;
          $crlist[0]['amount']=$value;
          $drlist[0]['ledgerid']=$dispo_acc_id;
          $drlist[0]['amount']=$value;
          $crtot=$drtot=$value;
          $date=date("Y-m-d");
          $narration=$id.' -  Asset  disposal-'.$leger_id.' value Transfers to Acc-'.$dispo_acc_id;
          $entryid=$this->asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
          if(!$entryid){
            $i=0;
          }else{
            $i=1;
          }
        }

      }
    }
    if ($i==1 && $x==1) {
      $data=array(
        'statues' => 'DISPOSAL',//disposal
        'disposal_approve_at' => date("Y-m-d"),
        'disposal_approve_by' => $this->session->userdata('username'),

      );
      $this->db->where('id', $id);
      $update = $this->db->update('ac_fixedassets', $data);
      if($update){
        return true;
      }
    }
    else
    return 0;
  }
  function delete_disposal($id){
    $data=array(
      'statues' => 'CONFIRMED',//disposal
      'disposal_approve_at' => date("Y-m-d"),
      'disposal_approve_by' => $this->session->userdata('username'),

    );
    $this->db->where('id', $id);
    $update = $this->db->update('ac_fixedassets', $data);
    if($update){
      return true;
    }
  else
  return 0;
  }

  function transfer_asset()
  {
    $type=$this->input->post('tranfer_type');
    if($type!="Category"){
      $oldval='';
      $newval='';
      if($type=="Branch"){
        $oldval=$this->input->post('old_branchval');
        $newval=$this->input->post('new_branch');
      }
      if($type=="Division"){
        $oldval=$this->input->post('old_divisionval');
        $newval=$this->input->post('new_division');
      }
      if($type=="User"){
        $oldval=$this->input->post('old_userval');
        $newval=$this->input->post('new_user');
      }
      $datarray=array(  'asset_id'=>$this->input->post('tranfer_id'),
      'tranfer_category'=>$type,
      'tranfer_date'=>date("Y-m-d"),
      'old_value'=>$oldval,
      'new_value'=>$newval,
      'statues' => 'PENDING',
      'created_by'=>$this->session->userdata('username'),
      'created_at'=> date("Y-m-d"));
      $insert = $this->db->insert('ac_fixedassets_tranfers_other', $datarray);
      return $this->db->insert_id();
    }else{
      $data = array('asset_id' =>$this->input->post('tranfer_id') ,
      'old_category_id' => $this->input->post('old_categoryval'),
      'old_subcategory_id' => $this->input->post('old_subcategoryval'),
      'transferto_category_id' =>$this->input->post('asset_cat') ,
      'transferto_subcategory_id' => $this->input->post('assetsub_cat'),
      'statues' => 'PENDING',
      'transfer_by' => $this->session->userdata('username'),
      'tranfer_at' => date("Y-m-d") );

      $insert = $this->db->insert('ac_fixedassets_tranfers', $data);
      return $this->db->insert_id();
    }

  }

  function get_tranfer_asset()
  {
    $this->db->select('*');
    $this->db->order_by('tranfer_at');
    $this->db->where_not_in('statues','CANCEL');
    $query = $this->db->get('ac_fixedassets_tranfers');
    return $query->result();
  }
  function delete_transfer($id)
  {

    $data=array(
      'statues' => "CANCEL",
      'confirm_at' => date("Y-m-d"),
      'confirm_by' => $this->session->userdata('username'),
    );
    $this->db->where('tranfer_id', $id);
    $update = $this->db->update('ac_fixedassets_tranfers', $data);
    if($update){
      return true;
    }
    else
    return 0;
  }

  function delete_transfer_other($id)
  {

    $data=array(
      'statues' => "CANCEL",
      'confirmed_at' => date("Y-m-d"),
      'confirmed_by' => $this->session->userdata('username'),
    );
    $this->db->where('tranfer_id', $id);
    $update = $this->db->update('ac_fixedassets_tranfers_other', $data);
    if($update){
      return true;
    }
    else
    return 0;
  }

  function confirm_transfer($id)
  {
    $tranfer_legers=$this->tranfer_legers($id);
    $update_asset_table=$this->update_asset_table($id);
    if($tranfer_legers=="true" && $update_asset_table=="true"){
      $data=array(
        'statues' => 'CONFIRM',
        'confirm_at' => date("Y-m-d"),
        'confirm_by' => $this->session->userdata('username'),
      );
      $this->db->where('tranfer_id', $id);
      $update = $this->db->update('ac_fixedassets_tranfers', $data);
      if($update){

        return true;
      }
      else
      return 0;
    }else{
      return 0;
    }


  }
  function confirm_transfer_other($id)
  {
    $update_asset_table=$this->update_asset_table_byother($id);
    if($update_asset_table=="true"){
      $data=array(
        'statues' => 'CONFIRM',
        'confirmed_at' => date("Y-m-d"),
        'confirmed_by' => $this->session->userdata('username'),
      );
      $this->db->where('tranfer_id', $id);
      $update = $this->db->update('ac_fixedassets_tranfers_other', $data);
      if($update){

        return true;
      }
      else
      return 0;
    }else{
      return 0;
    }


  }
  function update_asset_table($id)
  {
    $query =$this->fixedassets_tranfers_byid($id);
    if($query)
    {
      $old_category_id=$query->old_category_id;
      $transferto_category_id=$query->transferto_category_id;
      $old_subcategory_id=$query->old_subcategory_id;
      $transferto_subcategory_id=$query->transferto_subcategory_id;
      $asset=$query->asset_id;
      $data = array('category_id' =>$transferto_category_id ,
      'sub_cat_id' =>$transferto_subcategory_id );
      $this->db->where('id', $asset);
      $update = $this->db->update('ac_fixedassets', $data);
      if($update){
        return true;
      }
      else
      return 0;

    }
  }
  function update_asset_table_byother($id)
  {
    $query =$this->get_tranfer_others_byid($id);
    if($query)
    {
      $type=$query->tranfer_category;
      $data=[];
      if($type=="Branch"){
        $data=array('branch'=>$query->new_value);
      }
      if($type=="Division"){
        $data=array('division'=>$query->new_value);
      }
      if($type=="User"){
        $data=array('user'=>$query->new_value);
      }

      $asset=$query->asset_id;
      $this->db->where('id', $asset);
      $update = $this->db->update('ac_fixedassets', $data);
      if($update){
        return true;
      }
      else
      return 0;

    }
  }

  function fixedassets_tranfers_byid($id)
  {
    $this->db->select('asset_id,old_category_id,old_subcategory_id,transferto_category_id,
    transferto_subcategory_id,statues');
    $this->db->where('tranfer_id', $id);
    $query = $this->db->get('ac_fixedassets_tranfers');
    return $query->row();
  }
  function tranfer_legers($id){
    $query =$this->fixedassets_tranfers_byid($id);
    if($query){

      $old_category_id=$query->old_category_id;
      $old_data=$this->get_asset_category_byid($old_category_id);
      $transferto_category_id=$query->transferto_category_id;
      $tranfer_data=$this->get_asset_category_byid($transferto_category_id);

      $old_leger=$old_data->leger_acc;
      $old_depreciation_acc=$old_data->depreciation_acc;
      $tranfer_leger=$tranfer_data->leger_acc;
      $tranfer_depreciation_acc=$tranfer_data->depreciation_acc;
      $this->db->select('SUM(depreciation_value) AS depreciation_value');
      $this->db->where('asset_id',$query->asset_id);
      $this->db->where('depreciation_leger_id',$old_depreciation_acc);
      $this->db->where('leger_id',$old_leger);
      $query2 = $this->db->get('ac_fixedasset_depreciation');
      $val = $query2->row();
      $amount=0.00;
      if($val->depreciation_value==''){
        $amount=0.00;
      }else{
        $amount=$val->depreciation_value;
      }
      $i='';
      $x='';
      if($old_depreciation_acc){
        $crlist[0]['ledgerid']=$old_depreciation_acc;
        $crlist[0]['amount']=$amount;
        $drlist[0]['ledgerid']=$tranfer_depreciation_acc;
        $drlist[0]['amount']=$amount;
        $crtot=$drtot=$amount;
        $date=date("Y-m-d");
        $narration=$query->asset_id.' -  Asset depreciation Acc-'.$old_depreciation_acc.' Account Transfers to Acc-'.$tranfer_depreciation_acc;
        $entryid=$this->asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
        if(!$entryid){
          $i=0;
        }else{
          $i=1;
        }
      }
      if($old_leger){
        $crlist[0]['ledgerid']=$old_leger;
        $crlist[0]['amount']=$amount;
        $drlist[0]['ledgerid']=$tranfer_leger;
        $drlist[0]['amount']=$amount;
        $crtot=$drtot=$amount;
        $date=date("Y-m-d");
        $narration=$query->asset_id.' -  Asset depreciation '.$old_leger.' Account Transfers to'.$tranfer_leger;
        $entryid=$this->asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
        if(!$entryid){
          $x=0;
        }else{
          $x=1;
        }

      }
      if($i=='1' && $x=='1'){
        return true;
      }else{
        return false;
      }
    }
  }
  function asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id)
  {
    $data_number=$this->next_entry_number(4);
	if($prj_id=='')
		$prj_id=0;
		if($lot_id=='')
		$lot_id=0;
    $this->db->trans_start();
    $insert_data = array(
      'number' => $data_number,
      'date' => $date,
      'narration' => $narration,
      'entry_type' => 4,
      'lot_id' =>$lot_id,
      'prj_id' =>$prj_id,
    );
    if ( ! $this->db->insert('ac_entries', $insert_data))
    {
      $this->db->trans_rollback();
      $this->logger->write_message("error", $narration."Error adding since failed inserting entry");

      return false;
    } else {
      $entry_id = $this->db->insert_id();
    }

    for($i=0; $i<count($crlist); $i++)
    {
      $insert_ledger_data = array(
        'entry_id' => $entry_id,
        'ledger_id' => $crlist[$i]['ledgerid'],
        'amount' => $crlist[$i]['amount'],
        'dc' => 'C',
      );
      if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
      {
        $this->db->trans_rollback();
        $this->logger->write_message("error", $narration."Error adding since failed inserting entry Items");

        return false;
      }
    }
    for($i=0; $i<count($drlist); $i++)
    {
      $insert_ledger_data = array(
        'entry_id' => $entry_id,
        'ledger_id' => $drlist[$i]['ledgerid'],
        'amount' => $drlist[$i]['amount'],
        'dc' => 'D',
      );
      if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
      {
        $this->db->trans_rollback();
        $this->logger->write_message("error", $narration."Error adding since failed inserting entry Items");

        return false;
      }
    }
    /* Adding ledger accounts */


    /* Updating Debit and Credit Total in ac_entries table */
    $update_data = array(
      'dr_total' => $crtot,
      'cr_total' => $drtot,
    );
    if ( ! $this->db->where('id', $entry_id)->update('ac_entries', $update_data))
    {
      $this->db->trans_rollback();
      $this->logger->write_message("error", $narration."Error Updating since failed inserting entry Items");
      $this->template->load('template', 'entry/add', $data);
      return false;
    }
    $insert_status = array(
      'entry_id' => $entry_id,
      'status' => 'CONFIRM',
    );
    if ( ! $this->db->insert('ac_entry_status', $insert_status))
    {
      $this->db->trans_rollback();
      $this->messages->add('Error Inserting Entry Status.', 'error');
      $this->logger->write_message("error", "Error Entry Status " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
      $this->template->load('template', 'entry/add', $data);
      return false;
    }

    /* Success */
    $this->db->trans_complete();
    return $entry_id;
  }

  ///leger accounts Details
  function next_entry_number($entry_type_id)
  {
    $last_no_q = $this->db->query("SELECT MAX(CONVERT(number, SIGNED)) as lastno  FROM  ac_entries where entry_type='".$entry_type_id."'");
    //$last_no_q = $this->db->get();
    if ($row = $last_no_q->row())
    {
      $last_no = $row->lastno;
      $last_no++;
      return $last_no;
    } else {
      return 1;
    }
  }

  /////////////////////////////////
  //monthly depreciation backend process
  function depreciation(){
    $this->db->trans_start();
    $date=date("Y-m-d");
    $this->db->select("ac_fixedassets.category_id,
    ac_fixedassets.id,
    ac_fixedasset_cat.leger_acc,
    ac_fixedasset_cat.depreciation_acc,
    ac_fixedasset_cat.depreciation_presantage,
    ac_fixedassets.asset_value");
    $this->db->where_not_in('statues','PENDING');
    $this->db->where_not_in('statues','DISPOSAL');
    $this->db->join("ac_fixedasset_cat","ac_fixedassets.category_id = ac_fixedasset_cat.id","INNER");
    $query = $this->db->get('ac_fixedassets');
    $query=$query->result();
    if($query){

      foreach ($query as $key => $value) {
        $dep_val=(($value->depreciation_presantage/100)/12)*$value->asset_value;
        $dep_old_val=$this->get_depreciation_byid($value->id);
        $dep_balance=$value->asset_value-$dep_old_val->depreciation_value-$dep_val;
        $data = array('asset_id'=>$value->id,
        'depreciation_value'=>$dep_val,
        'depreciation_date'=>$date,
        'balance'=>$dep_balance,
        'leger_id'=>$value->leger_acc,
        'depreciation_leger_id' => $value->depreciation_acc );

        $insert = $this->db->insert('ac_fixedasset_depreciation', $data);

      }
    }
    $this->db->select('Sum(ac_fixedasset_depreciation.depreciation_value) AS amount,ac_fixedasset_depreciation.depreciation_date,
    ac_fixedassets.category_id,ac_fixedasset_cat.leger_acc,ac_fixedasset_cat.depreciation_acc,ac_fixedasset_cat.provision_acc');

    $this->db->join('ac_fixedassets','ac_fixedassets.id=ac_fixedasset_depreciation.asset_id');
    $this->db->join('ac_fixedasset_cat','ac_fixedassets.category_id=ac_fixedasset_cat.id');
    $this->db->where('ac_fixedasset_depreciation.depreciation_date',$date);
    $this->db->group_by('ac_fixedassets.category_id');
    $query2=$this->db->get('ac_fixedasset_depreciation');
    $query2=$query2->result();
    if($query2)
    {
      foreach ($query2 as $key => $value) {
        $amount=$value->amount;
        $crlist[0]['ledgerid']=$value->depreciation_acc;
        $crlist[0]['amount']=$amount;
        $drlist[0]['ledgerid']=$value->provision_acc;
        $drlist[0]['amount']=$amount;
        $crtot=$drtot=$amount;
        $date=date("Y-m-d");
        $narration=$value->depreciation_acc.' -  Monthly depreciation Transfers to'.$value->provision_acc;
        $entryid=$this->asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
      }
    }
    $this->db->trans_complete();
    return true;

  }
  ///////////////////////////////////////////

  function get_hr_division()
  { //get all asset category
    $this->db->select('*');
    $this->db->order_by('id');
    $query = $this->db->get('hr_division');
    return $query->result();
  }

  function get_hr_empolyees()
  { //get all asset category
    $this->db->select('*');
    $this->db->order_by('id');
    $query = $this->db->get('hr_empmastr');
    return $query->result();
  }

  function get_hr_division_byid($id)
  {
    $this->db->select('*');
    $this->db->where('id',$id);
    $query = $this->db->get('hr_division');
    return $query->row();
  }

  function get_hr_empolyees_byid($id)
  {
    $this->db->select('*');
    $this->db->where('id',$id);
    $query = $this->db->get('hr_empmastr');
    return $query->row();
  }
  function get_branch_byid($id)
  { //get all asset
    $this->db->select('branch_code,branch_name');
    $this->db->where('branch_code',$id);
    $query = $this->db->get('cm_branchms');
    return $query->row();
  }
  function get_tranfer_others()
  { //get all asset category
    $this->db->select('*');
    $this->db->order_by('tranfer_id');
    $this->db->where_not_in('statues','CANCEL');
    $query = $this->db->get('ac_fixedassets_tranfers_other');
    return $query->result();
  }
  function get_tranfer_others_byid($id)
  { //get all asset category
    $this->db->select('*');
    $this->db->where('tranfer_id',$id);
    $query = $this->db->get('ac_fixedassets_tranfers_other');
    return $query->row();
  }
  function get_tranfer_others_count($id)
  { //get all asset category
    $this->db->select('count(tranfer_id) as tranfercount');
    $this->db->where('asset_id',$id);
    $this->db->where('statues','CONFIRM');
    $query = $this->db->get('ac_fixedassets_tranfers_other');
    return $query->row();
  }

  function get_invoice_byid($id){
    $this->db->select('ac_invoices.*,ac_invoice_fixeditems.*,cm_supplierms.first_name,cm_supplierms.last_name');
    $this->db->where('ac_invoice_fixeditems.asset_id',$id);
    $this->db->join('ac_invoices','ac_invoices.id=ac_invoice_fixeditems.invoice_id');
    $this->db->join('cm_supplierms','cm_supplierms.sup_code=ac_invoices.supplier_id');
    $query = $this->db->get('ac_invoice_fixeditems');
    return $query->row();
  }
  function get_tranfer_others_confirm(){
    $this->db->select('*');
    $this->db->where('statues','CONFIRM');
    $query = $this->db->get('ac_fixedassets_tranfers_other');
    return $query->result();
  }
  function get_depreciation_byid($id)
  {
    $this->db->select('SUM(depreciation_value) AS depreciation_value');
    $this->db->where('asset_id',$id);

    $query = $this->db->get('ac_fixedasset_depreciation');
    return $query->row();
  }
  function get_asset_data_bycat($id)
  {
    $this->db->select('*');
    $this->db->where('ac_fixedassets.category_id',$id);

    $query = $this->db->get('ac_fixedassets');
    return $query->result();
  }
  function get_asset_alldata_byid($id)
  {
    $old_data=$this->check_revaluation_exist($id);
    if(!$old_data){
      $this->db->select('ac_fixedassets.id,
      ac_fixedassets.category_id,
      ac_fixedassets.sub_cat_id,
      ac_fixedassets.asset_code,
      ac_fixedassets.asset_name,
      ac_fixedassets.branch,
      ac_fixedassets.asset_value,
      ac_fixedassets.purches_value,
      ac_fixedassets.`year`,
      ac_fixedassets.quantity,
      ac_fixedassets.remarks,
      ac_fixedassets.attachments,
      ac_fixedassets.disposal_value,
      ac_fixedassets.purchase_by,
      ac_fixedassets.statues,
      ac_fixedassets.brand,
      ac_fixedassets.serial_no,
      ac_fixedassets.division,
      ac_fixedassets.`user`,
      ac_fixedasset_cat.asset_category,
      ac_fixedasset_cat.intangible_flag,
      ac_fixedasset_cat.depreciation_presantage,
      ac_fixedasset_cat.leger_acc,
      ac_fixedasset_cat.depreciation_acc,
      ac_fixedasset_cat.provision_acc,
      ac_fixedasset_cat.disposal_acc,
      SUM(ac_fixedasset_depreciation.depreciation_value) AS dep_val,
      MAX(ac_fixedasset_depreciation.depreciation_date) AS last_date');
      $this->db->join('ac_fixedasset_cat','ac_fixedassets.category_id = ac_fixedasset_cat.id');
      $this->db->join('ac_fixedasset_depreciation','ac_fixedassets.id = ac_fixedasset_depreciation.asset_id','left');
      $this->db->where('ac_fixedassets.id',$id);
      $query = $this->db->get('ac_fixedassets');
      return $query->row();
    }



  }
  function check_revaluation_exist($id)
  {
    $this->db->select('revaluation_val,revaluation_date');
    $this->db->where('revalution_id',$id);
    $query = $this->db->get('ac_fixedasset_revaluation');
    return $query->result();
  }

  function asset_revaluation_add()
  {
    $data=array(

      'asset_id'=> $this->input->post('asset'),
      'revaluation_val'=> $this->input->post('amount'),
      'asset_value'=> $this->input->post('old_val'),
      'revaluation_date'=> $this->input->post('revaluation_date'),
      'added_by'=> $this->session->userdata('username'),
      'added_at'=> date("Y-m-d"),
    );

    $insert = $this->db->insert('ac_fixedasset_revaluation', $data);
    return $this->db->insert_id();
  }

  function get_revaluation_data()
  {
    $this->db->select('ac_fixedasset_revaluation.revalution_id,
    ac_fixedasset_revaluation.asset_id,
    ac_fixedasset_revaluation.revaluation_val,
    ac_fixedasset_revaluation.asset_value,
    ac_fixedasset_revaluation.revaluation_date,
    ac_fixedasset_revaluation.added_by,
    ac_fixedasset_revaluation.added_at,
    ac_fixedasset_revaluation.confirm_by,
    ac_fixedasset_revaluation.confirm_at,
    ac_fixedasset_revaluation.statues,
    ac_fixedassets.asset_code,
    ac_fixedassets.asset_name,
    ac_fixedassets.category_id,
    ac_fixedassets.sub_cat_id,
    ac_fixedassets.asset_value,
    ac_fixedassets.purches_value');
    $this->db->join('ac_fixedassets','ac_fixedasset_revaluation.asset_id = ac_fixedassets.id');
    $query = $this->db->get('ac_fixedasset_revaluation');
    return $query->result();
  }

  function delete_revaluation($id)
  {

    $data=array(
      'statues' => 'CANCEL',//disposal
      'confirm_at' => date("Y-m-d"),
      'confirm_by' => $this->session->userdata('username'),

    );
    $this->db->where('revalution_id', $id);
    $update = $this->db->update('ac_fixedasset_revaluation', $data);
    if($update){
      return true;
    }
    else
    return 0;
  }
  function confirm_revaluation($id)
  {
    $this->db->select('*');
    $this->db->where('revalution_id',$id);
    $query = $this->db->get('ac_fixedasset_revaluation');
    $result=$query->row();
    $asset_details=$this->get_asset_byid($result->asset_id);
    $asset_legers=$this->get_asset_category_byid($asset_details->category_id);
    $amount=$result->revaluation_val-$result->asset_value;
    //hardcode for winrose
    $acc_id=$asset_legers->leger_acc;
    $dracc='';
    $cracc='';
    if($amount<0){
      $dracc=$asset_legers->leger_acc;
      $cracc=$acc_id;
    }else{
      $cracc=$asset_legers->leger_acc;
      $dracc=$acc_id;
    }



    $crlist[0]['ledgerid']=$cracc;
    $crlist[0]['amount']=$amount;
    $drlist[0]['ledgerid']=$dracc;
    $drlist[0]['amount']=$amount;
    $crtot=$drtot=$amount;
    $date=date("Y-m-d");
    $narration=$id.' -  Asset Revalution-'.$asset_legers->leger_acc.' value Transfers to Acc-'.$acc_id;
    $entryid=$this->asset_tranfer_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,'','');
    if(!$entryid){
      return false;
    }else{
      $data=array(
        'statues' => 'CONFIRM',//disposal
        'confirm_at' => date("Y-m-d"),
        'confirm_by' => $this->session->userdata('username'),

      );
      $this->db->where('revalution_id', $id);
      $update = $this->db->update('ac_fixedasset_revaluation', $data);
      return true;
    }
  }
}
