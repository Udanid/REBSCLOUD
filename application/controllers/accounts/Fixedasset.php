<?php
// file use for create edit ac_projects
class Fixedasset extends CI_Controller {

  function Fixedasset()
  {
    parent::__construct();

    $this->load->model('common_model');
    $this->load->model('fixedasset_model');
    $this->load->model("supplier_model");
    $this->is_logged_in();

  }
  function index()
  {
    $data=NULL;
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/home');
      return;
    }
    redirect('accounts/Fixedasset/showall');
  }

  public function showall()
  {
    $data=NULL;
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/home');
      return;
    }
    $data['asset_cat_data']=$asset_cat_data=$this->fixedasset_model->get_asset_category();
    $leger_acc=NULL;
    $depre_acc=NULL;
    $provi_acc=NULL;
    $dispo_acc=NULL;
    if($asset_cat_data){
      foreach ($asset_cat_data as $key => $value) {
        $leger_acc[$value->leger_acc]=$this->fixedasset_model->get_leger_names($value->leger_acc);
        $depre_acc[$value->depreciation_acc]=$this->fixedasset_model->get_leger_names($value->depreciation_acc);
        $provi_acc[$value->provision_acc]=$this->fixedasset_model->get_leger_names($value->provision_acc);
        $dispo_acc[$value->disposal_acc]=$this->fixedasset_model->get_leger_names($value->disposal_acc);

      }
    }
    $data['leger_acc']=$leger_acc;
    $data['depre_acc']=$depre_acc;
    $data['provi_acc']=$provi_acc;
    $data['dispo_acc']=$dispo_acc;
    $data['legers']=$legers=$this->fixedasset_model->get_all_legers();
    $this->load->view('accounts/fixed_asset/fixedasset',$data);

  }

  //add fixed asset category
  public function add()
  {
    if ( ! check_access('add_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/showall');
      return;
    }
    $id=$this->fixedasset_model->add();

    //$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
    $this->session->set_flashdata('msg', 'New Category Successfully Inserted ');
    $this->logger->write_message("success", $this->input->post('asset_cat_name').'  successfully Inserted');
    redirect("accounts/Fixedasset/showall");

  }

  public function fixedasset_item()
  {
    $data=NULL;
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/home');
      return;
    }

    $data['assets']=$assets=$asset_cat_data=$this->fixedasset_model->get_assets();

    $category_name=NULL;
    $subcategory_name=Null;
    if($assets)
    {
      foreach ($assets as $key => $value) {
        $category_name[$value->category_id]=$this->fixedasset_model->get_asset_category_byid($value->category_id);
        $subcategory_name[$value->sub_cat_id]=$this->fixedasset_model->get_sub_assets_byid($value->sub_cat_id);
      }

    }
    $data['category_name']=$category_name;
    $data['subcategory_name']=$subcategory_name;
    $data['categories']=$this->fixedasset_model->get_asset_category();
    $data['branches']=$this->fixedasset_model->get_all_branches();
    $data['division']=$this->fixedasset_model->get_hr_division();
    $data['employees']=$this->fixedasset_model->get_hr_empolyees();

    $this->load->view('accounts/fixed_asset/fixedasset_item',$data);

  }

  function add_asset()
  {
    if ( ! check_access('add_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $file_name="";

    $today = date("Y-m-d H:i:s");
    $uploadmonth=date("F", strtotime($today));
    $uploadyear=date("Y", strtotime($today));
    $config['upload_path'] = 'uploads/fixed_asset/'.$uploadmonth.$uploadyear;
    if ( ! file_exists($config['upload_path']) )
    {
      $create = mkdir($config['upload_path'], 0777);
      if ( ! $create)
      return;
    }
    $config['allowed_types'] = '*';
    $config['max_size'] = '5000';


    $this->load->library('upload', $config);
    $this->upload->do_upload('asset_attach');
    $error = $this->upload->display_errors();

    $image_data = $this->upload->data();
    //$this->session->set_flashdata('error',  $error );
    if($error=="")
    $file_name = $image_data['file_name'];
    else
    {

      $this->session->set_flashdata('error',  $error );
    }
    $id=$this->fixedasset_model->add_asset($file_name);
    if($id==0){
      $this->session->set_flashdata('msg', 'Something Went Wrong..! Please Try Again.. ');
      redirect("accounts/Fixedasset/fixedasset_item");

    }else{
      $this->session->set_flashdata('msg', 'New Asset Successfully Inserted ');
      $this->logger->write_message("success", $this->input->post('asset_name').'  successfully Inserted');
      redirect("accounts/Fixedasset/fixedasset_item");
    }
  }

  public function edit()
  {
    $data=NULL;
    if ( ! check_access('edit_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $data['details']=$details=$this->fixedasset_model->get_asset_byid($this->uri->segment(4));
    $data['category_name']=0;
    if($details->category_id!=""){
      $data['category_name']=$this->fixedasset_model->get_asset_category_byid($details->category_id);
    }

    $session = array('activtable'=>'ac_fixedassets');
    $this->session->set_userdata($session);
    $data['categories']=$this->fixedasset_model->get_asset_category();
    $data['branches']=$this->fixedasset_model->get_all_branches();
    $data['division']=$this->fixedasset_model->get_hr_division();
    $data['employees']=$this->fixedasset_model->get_hr_empolyees();
    $this->load->view('accounts/fixed_asset/edit',$data);

  }

  function edit_asset()
  {
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }

    $id=$this->fixedasset_model->edit_asset();
    if($id==0){
      $this->session->set_flashdata('msg', 'Something Went Wrong..! Please Try Again.. ');
      redirect("accounts/Fixedasset/fixedasset_item");

    }else{
      $this->session->set_flashdata('msg', 'New Details Successfully Updated.');
      $this->logger->write_message("success", $this->input->post('asset_name').'  Details successfully Updated.');
      redirect("accounts/Fixedasset/fixedasset_item");
    }
  }

  function edit_category()
  {
    $data=NULL;
    if ( ! check_access('edit_category'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/showall');
      return;
    }
    $data['details']=$details=$this->fixedasset_model->get_asset_category_byid($this->uri->segment(4));
    $leger_acc=NULL;
    $depre_acc=NULL;
    $provi_acc=NULL;
    $dispo_acc=NULL;
    if($details){
      $leger_acc[$details->leger_acc]=$this->fixedasset_model->get_leger_names($details->leger_acc);
      $depre_acc[$details->depreciation_acc]=$this->fixedasset_model->get_leger_names($details->depreciation_acc);
      $provi_acc[$details->provision_acc]=$this->fixedasset_model->get_leger_names($details->provision_acc);
      $dispo_acc[$details->disposal_acc]=$this->fixedasset_model->get_leger_names($details->disposal_acc);

    }
    $data['leger_acc']=$leger_acc;
    $data['depre_acc']=$depre_acc;
    $data['provi_acc']=$provi_acc;
    $data['dispo_acc']=$dispo_acc;
    $session = array('activtable'=>'ac_fixedassets');
    $this->session->set_userdata($session);
    $data['categories']=$this->fixedasset_model->get_asset_category();
    $data['legers']=$legers=$this->fixedasset_model->get_all_legers();
    $this->load->view('accounts/fixed_asset/edit_cat',$data);
  }

  function update_category()
  {
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/showall');
      return;
    }

    $id=$this->fixedasset_model->edit_category();
    if($id==0){
      $this->session->set_flashdata('msg', 'Something Went Wrong..! Please Try Again.. ');
      redirect("accounts/Fixedasset/showall");

    }else{
      $this->session->set_flashdata('msg', 'Asset Category Successfully Updated.');
      $this->logger->write_message("success", $this->input->post('asset_cat_name').' category successfully Updated.');
      redirect("accounts/Fixedasset/showall");
    }
  }
  function delete()
  {
    if ( ! check_access('delete_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $id=$this->fixedasset_model->delete($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Asset Item Successfully Deleted ');
    $this->logger->write_message("success", $this->uri->segment(4).' Asset Item Successfully Deleted');
    redirect("accounts/Fixedasset/fixedasset_item");
  }

  public function confirm()
  {
    if ( ! check_access('confirm_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $id=$this->fixedasset_model->confirm($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Asset Item Successfully Confirmed ');
    $this->logger->write_message("success", $this->uri->segment(4).'  Asset Item successfully Confirmed');
    redirect("accounts/Fixedasset/fixedasset_item");

  }
  public function remarks()
  {
    $data=NULL;
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $data['remarks']=$this->fixedasset_model->get_remarks_byid($this->uri->segment(4));
    $this->load->view('accounts/fixed_asset/remarks',$data);

  }
  function addSub_cat()
  {
    $id=$this->fixedasset_model->add_subasset();
    if($id==0){
      $this->session->set_flashdata('msg', 'Something Went Wrong..! Please Try Again.. ');
      redirect("accounts/Fixedasset/showall");

    }else{
      $this->session->set_flashdata('msg', 'New Sub Asset Category Successfully Inserted ');
      $this->logger->write_message("success", $this->input->post('asset_name').'  successfully Inserted');
      redirect("accounts/Fixedasset/showall");
    }
  }
  function sub_asset_data()
  {
    $sub_asset=$this->input->post('id');
    $sub_assets=$this->fixedasset_model->get_sub_assets($sub_asset);
    if($sub_assets){
      echo json_encode($sub_assets);
    }
  }
  function disposal()
  {
    $data=NULL;
    if ( ! check_access('view_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/home');
      return;
    }

    $data['assets']=$assets=$asset_cat_data=$this->fixedasset_model->get_assets();
    $data['dispo_assets']=$dispo_assets=$asset_cat_data=$this->fixedasset_model->get_dispoassets();

    $category_name=NULL;
    $subcategory_name=Null;
    if($dispo_assets)
    {
      foreach ($dispo_assets as $key => $value) {
        $category_name[$value->category_id]=$this->fixedasset_model->get_asset_category_byid($value->category_id);
        $subcategory_name[$value->sub_cat_id]=$this->fixedasset_model->get_sub_assets_byid($value->sub_cat_id);
      }

    }
    $data['category_name']=$category_name;
    $data['subcategory_name']=$subcategory_name;
    $data['categories']=$this->fixedasset_model->get_asset_category();
    $data['branches']=$this->fixedasset_model->get_all_branches();

    $this->load->view('accounts/fixed_asset/disposal',$data);
  }
  function disposal_asset()
  {
    if ( ! check_access('dispose_fixed_asset'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/disposal');
      return;
    }

    $id=$this->fixedasset_model->disposal_asset();
    if($id==0){
      $this->session->set_flashdata('msg', 'Something Went Wrong..! Please Try Again.. ');
      redirect("accounts/Fixedasset/disposal");

    }else{
      $this->session->set_flashdata('msg', 'Fixed Asset Successfully Disposed.');
      $this->logger->write_message("success",  'Fixed Asset Successfully Disposed.');
      redirect("accounts/Fixedasset/disposal");
    }
  }
  function transfers()
  {
    $data=NULL;
    if ( ! check_access('fixed_asset_transfers'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/home');
      return;
    }

    $data['assets']=$assets=$this->fixedasset_model->get_assets();
    $data['transfers']=$transfers=$this->fixedasset_model->get_tranfer_asset();
    $data['transfer_other']=$transfer_other=$this->fixedasset_model->get_tranfer_others();
    $category_name=NULL;
    $asset_name=NULL;
    $subcategory_name=NULL;
    $category_name_old=Null;
    $Subcategory_name_old=Null;
    $category_name_new=Null;
    $Subcategory_name_new=Null;
    $branch_name=Null;
    $division_name=Null;
    $user_name=Null;
    $oldval=Null;
    $newval=Null;
    if($assets)
    {
      foreach ($assets as $key => $value) {
        $category_name[$value->category_id]=$this->fixedasset_model->get_asset_category_byid($value->category_id);
        $subcategory_name[$value->sub_cat_id]=$this->fixedasset_model->get_sub_assets_byid($value->sub_cat_id);
        $branch_name[$value->branch]=$this->fixedasset_model->get_branch_byid($value->branch);
        $division_name[$value->division]=$this->fixedasset_model->get_hr_division_byid($value->division);
        $user_name[$value->user]=$this->fixedasset_model->get_hr_empolyees_byid($value->user);
      }
    }
    if($transfers)
    {
      foreach ($transfers as $key => $value) {
        $asset_name[$value->asset_id]=$this->fixedasset_model->get_asset_byid($value->asset_id);
        $category_name_old[$value->old_category_id]=$this->fixedasset_model->get_asset_category_byid($value->old_category_id);
        $Subcategory_name_old[$value->old_subcategory_id]=$this->fixedasset_model->get_sub_assets_byid($value->old_subcategory_id);
        $category_name_new[$value->transferto_category_id]=$this->fixedasset_model->get_asset_category_byid($value->transferto_category_id);
        $Subcategory_name_new[$value->transferto_subcategory_id]=$this->fixedasset_model->get_sub_assets_byid($value->transferto_subcategory_id);
      }
    }
    if($transfer_other)
    {
      foreach ($transfer_other as $key => $value) {
        $type=$value->tranfer_category;
        if($type=="Branch"){
          $oldval[$value->old_value]=$this->fixedasset_model->get_branch_byid($value->old_value);
          $newval[$value->new_value]=$this->fixedasset_model->get_branch_byid($value->new_value);
        }
        if($type=="Division"){
          $oldval[$value->old_value]=$this->fixedasset_model->get_hr_division_byid($value->old_value);
          $newval[$value->new_value]=$this->fixedasset_model->get_hr_division_byid($value->new_value);
        }
        if($type=="User"){
          $oldval[$value->old_value]=$this->fixedasset_model->get_hr_empolyees_byid($value->old_value);
          $newval[$value->new_value]=$this->fixedasset_model->get_hr_empolyees_byid($value->new_value);
        }
      }
    }
    $data['category_name_old']=$category_name_old;
    $data['Subcategory_name_old']=$Subcategory_name_old;
    $data['category_name_new']=$category_name_new;
    $data['Subcategory_name_new']=$Subcategory_name_new;
    $data['category_name']=$category_name;
    $data['asset_name']=$asset_name;
    $data['subcategory_name']=$subcategory_name;
    $data['branch_name']=$branch_name;
    $data['division_name']=$division_name;
    $data['user_name']=$user_name;
    $data['oldval']=$oldval;
    $data['newval']=$newval;
    $data['categories']=$this->fixedasset_model->get_asset_category();
    $data['branches']=$this->fixedasset_model->get_all_branches();
    $data['division']=$this->fixedasset_model->get_hr_division();
    $data['employees']=$this->fixedasset_model->get_hr_empolyees();


    $this->load->view('accounts/fixed_asset/transfers',$data);
  }

  function transfer_asset()
  {
    if ( ! check_access('fixed_asset_transfers'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/transfers');
      return;
    }

    $id=$this->fixedasset_model->transfer_asset();
    if($id==0){
      $this->session->set_flashdata('msg', 'Something Went Wrong..! Please Try Again.. ');
      redirect("accounts/Fixedasset/transfers");

    }else{
      $this->session->set_flashdata('msg', 'Fixed Asset Successfully Transfered.');
      $this->logger->write_message("success",  'Fixed Asset Successfully Transfered.');
      redirect("accounts/Fixedasset/transfers");
    }
  }
  function confirm_transfer()
  {
    if ( ! check_access('confirm_fixed_asset_transfers'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/transfers');
      return;
    }
    $id=$this->fixedasset_model->confirm_transfer($this->uri->segment(4));
    if($id=="0"){
      $this->session->set_flashdata('msg', 'Something went wrong while confirmation');
      $this->logger->write_message("success", $this->uri->segment(4).' Something went wrong while confirmation');
      redirect("accounts/Fixedasset/transfers");
    }else{
      $this->session->set_flashdata('msg', 'Asset Item Tranfer Successfully Confirmed ');
      $this->logger->write_message("success", $this->uri->segment(4).' Asset Item Tranfer Successfully Confirmed');
      redirect("accounts/Fixedasset/transfers");
    }

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));

  }
  function confirm_transfer_other()
  {
    if ( ! check_access('confirm_fixed_asset_transfers'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/transfers');
      return;
    }
    $id=$this->fixedasset_model->confirm_transfer_other($this->uri->segment(4));
    if($id=="0"){
      $this->session->set_flashdata('msg', 'Something went wrong while confirmation');
      $this->logger->write_message("success", $this->uri->segment(4).' Something went wrong while confirmation');
      redirect("accounts/Fixedasset/transfers");
    }else{
      $this->session->set_flashdata('msg', 'Asset Item Tranfer Successfully Confirmed ');
      $this->logger->write_message("success", $this->uri->segment(4).' Asset Item Tranfer Successfully Confirmed');
      redirect("accounts/Fixedasset/transfers");
    }

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));

  }
  function delete_transfer()
  {
    if ( ! check_access('delete_fixed_asset_transfers'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/transfers');
      return;
    }
    $id=$this->fixedasset_model->delete_transfer($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Asset Item Tranfer Deleted ');
    $this->logger->write_message("success", $this->uri->segment(4).' Asset Item Tranfer Successfully Deleted');
    redirect("accounts/Fixedasset/transfers");
  }
  function delete_transfer_other()
  {
    if ( ! check_access('delete_fixed_asset_transfers'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/transfers');
      return;
    }
    $id=$this->fixedasset_model->delete_transfer_other($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Asset Item Tranfer Deleted ');
    $this->logger->write_message("success", $this->uri->segment(4).' Asset Item Tranfer Successfully Deleted');
    redirect("accounts/Fixedasset/transfers");
  }

  function register(){
    $data=NULL;
    if ( ! check_access('view_asset_registre'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }

    $data['assets']=$assets=$this->fixedasset_model->get_assets_all();
    $data['transfers']=$transfers=$this->fixedasset_model->get_tranfer_asset();
    $data['transfer_other']=$transfer_other=$this->fixedasset_model->get_tranfer_others_confirm();
    $category_name=NULL;
    $asset_name=NULL;
    $subcategory_name=NULL;
    $category_name_old=Null;
    $Subcategory_name_old=Null;
    $category_name_new=Null;
    $Subcategory_name_new=Null;
    $branch_name=Null;
    $division_name=Null;
    $user_name=Null;
    $oldval=Null;
    $newval=Null;
    $tranfercount=Null;
    $other_tranfer_data=Null;
    $invoice=Null;
    $depreciation=Null;
    if($assets)
    {
      foreach ($assets as $key => $value) {
        $category_name[$value->category_id]=$this->fixedasset_model->get_asset_category_byid($value->category_id);
        $subcategory_name[$value->sub_cat_id]=$this->fixedasset_model->get_sub_assets_byid($value->sub_cat_id);
        $branch_name[$value->branch]=$this->fixedasset_model->get_branch_byid($value->branch);
        $division_name[$value->division]=$this->fixedasset_model->get_hr_division_byid($value->division);
        $user_name[$value->user]=$this->fixedasset_model->get_hr_empolyees_byid($value->user);
        $tranfercount[$value->id]=$this->fixedasset_model->get_tranfer_others_count($value->id);
        $invoice[$value->id]=$this->fixedasset_model->get_invoice_byid($value->id);
        $depreciation[$value->id]=$this->fixedasset_model->get_depreciation_byid($value->id);

      }
    }
    if($transfers)
    {
      foreach ($transfers as $key => $value) {
        $asset_name[$value->asset_id]=$this->fixedasset_model->get_asset_byid($value->asset_id);
        $category_name_old[$value->old_category_id]=$this->fixedasset_model->get_asset_category_byid($value->old_category_id);
        $Subcategory_name_old[$value->old_subcategory_id]=$this->fixedasset_model->get_sub_assets_byid($value->old_subcategory_id);
        $category_name_new[$value->transferto_category_id]=$this->fixedasset_model->get_asset_category_byid($value->transferto_category_id);
        $Subcategory_name_new[$value->transferto_subcategory_id]=$this->fixedasset_model->get_sub_assets_byid($value->transferto_subcategory_id);
      }
    }
    if($transfer_other)
    {
      foreach ($transfer_other as $key => $value) {
        $type=$value->tranfer_category;
        if($type=="Branch"){
          $oldval[$value->old_value]=$this->fixedasset_model->get_branch_byid($value->old_value);
          $newval[$value->new_value]=$this->fixedasset_model->get_branch_byid($value->new_value);
        }
        if($type=="Division"){
          $oldval[$value->old_value]=$this->fixedasset_model->get_hr_division_byid($value->old_value);
          $newval[$value->new_value]=$this->fixedasset_model->get_hr_division_byid($value->new_value);
        }
        if($type=="User"){
          $oldval[$value->old_value]=$this->fixedasset_model->get_hr_empolyees_byid($value->old_value);
          $newval[$value->new_value]=$this->fixedasset_model->get_hr_empolyees_byid($value->new_value);
        }
      }
    }
    $data['category_name_old']=$category_name_old;
    $data['Subcategory_name_old']=$Subcategory_name_old;
    $data['category_name_new']=$category_name_new;
    $data['Subcategory_name_new']=$Subcategory_name_new;
    $data['category_name']=$category_name;
    $data['asset_name']=$asset_name;
    $data['subcategory_name']=$subcategory_name;
    $data['branch_name']=$branch_name;
    $data['division_name']=$division_name;
    $data['user_name']=$user_name;
    $data['oldval']=$oldval;
    $data['newval']=$newval;
    $data['tranfercount']=$tranfercount;
    $data['invoice']=$invoice;
    $data['depreciation']=$depreciation;
    $data['categories']=$this->fixedasset_model->get_asset_category();
    $data['branches']=$this->fixedasset_model->get_all_branches();
    $data['division']=$this->fixedasset_model->get_hr_division();
    $data['employees']=$this->fixedasset_model->get_hr_empolyees();


    $this->load->view('accounts/fixed_asset/register',$data);
  }
  public function depreciation()
  {
    $id=$this->fixedasset_model->depreciation();
    echo $id;
  }
  function delete_disposal()
  {
    if ( ! check_access('delete_disposal'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $id=$this->fixedasset_model->delete_disposal($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Disposal Item Canceled');
    $this->logger->write_message("success", $this->uri->segment(4).'Disposal Item Canceled');
    redirect("accounts/Fixedasset/disposal");
  }
  function confirm_disposal()
  {
    if ( ! check_access('confirm_disposal'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $id=$this->fixedasset_model->confirm_disposal($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Asset Item Successfully Disposaled');
    $this->logger->write_message("success", $this->uri->segment(4).'Asset Item Successfully Disposaled');
    redirect("accounts/Fixedasset/disposal");
  }
  public function revaluation()
  {
    $data=NULL;
    if ( ! check_access('add_revalueation'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $data['all_assets']=$all_assets=$this->fixedasset_model->get_assets();
    $data['assets']=$assets=$this->fixedasset_model->get_revaluation_data();
    $category_name=NULL;
    $subcategory_name=Null;
    if($assets)
    {
      foreach ($assets as $key => $value) {
        $category_name[$value->category_id]=$this->fixedasset_model->get_asset_category_byid($value->category_id);
        $subcategory_name[$value->sub_cat_id]=$this->fixedasset_model->get_sub_assets_byid($value->sub_cat_id);
      }

    }
    $data['category_name']=$category_name;
    $data['subcategory_name']=$subcategory_name;

    $data['categories']=$this->fixedasset_model->get_asset_category();
    $this->load->view('accounts/fixed_asset/revaluation',$data);
  }
  function get_asset_data_bycat()
  {
    $categories=$this->input->post('id');
    $assets=$this->fixedasset_model->get_asset_data_bycat($categories);
    if($assets){
      echo json_encode($assets);
    }
  }
  function get_asset_alldata_byid()
  {
    $id=$this->input->post('id');
    $assets_data=$this->fixedasset_model->get_asset_alldata_byid($id);
    if($assets_data){
      echo json_encode($assets_data);
    }
  }

  function asset_revaluation_add()
  {
    if ( ! check_access('add_revalueation'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/showall');
      return;
    }
    $id=$this->fixedasset_model->asset_revaluation_add();

    //$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
    $this->session->set_flashdata('msg', 'New Value Successfully Updated ');
    $this->logger->write_message("success", '  successfully Updated');
    redirect("accounts/Fixedasset/revaluation");
  }
  function confirm_revaluation()
  {
    if ( ! check_access('confirm_revaluation'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/showall');
      return;
    }
    $id=$this->fixedasset_model->confirm_revaluation($this->uri->segment(4));
    if($id=="0"){
      $this->session->set_flashdata('error', 'Something went wrong while confirmation');
      $this->logger->write_message("success", ' Something went wrong while confirmation');
      redirect("accounts/Fixedasset/revaluation");
    }else{
      $this->session->set_flashdata('msg', 'New Value Successfully Confirmed ');
      $this->logger->write_message("success", ' Asset Value Successfully Confirmed');
      redirect("accounts/Fixedasset/revaluation");
    }
  }
  function delete_revaluation()
  {
    if ( ! check_access('delete_revaluation'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/Fixedasset/fixedasset_item');
      return;
    }
    $id=$this->fixedasset_model->delete_revaluation($this->uri->segment(4));
    if($id){
      $this->session->set_flashdata('msg', 'Asset Revalution Successfully Canceled ');
      $this->logger->write_message("success", $this->uri->segment(4).' Asset Item Successfully Deleted');
      redirect("accounts/Fixedasset/revaluation");
    }else{
      $this->session->set_flashdata('error', 'Something went wrong while confirmation');
      $this->logger->write_message("success", ' Something went wrong while confirmation');
      redirect("accounts/Fixedasset/revaluation");
    }

  }

}
