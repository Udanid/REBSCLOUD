<?php
// file use for create edit ac_projects
class Institute extends CI_Controller {

  function Institute()
  {
    parent::__construct();

    $this->load->model('institute_model');
    $this->load->model('common_model');
    $this->is_logged_in();

  }
  function index()
  {

    $data['bankname']=$bankname=$this->institute_model->get_all_banks();
    $this->load->view('accounts/Institute/institute',$data);
  }
  function addbranch()
  {
    $id=$this->institute_model->addbranch();
    if($id==true){
    //$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
    $this->session->set_flashdata('msg', 'New Branch Successfully Inserted ');
    $this->logger->write_message("success", $this->input->post('branch_code').'  successfully Inserted');
    redirect("accounts/Institute");
  }else{
    //$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
    $this->session->set_flashdata('msg', 'Something went wrong! please try again');
    $this->logger->write_message("success", $this->input->post('branch_code').'  Something went wrong! please try again');
    redirect("accounts/Institute");
  }
  }
  function add()
  {
    $id=$this->institute_model->add();
    if($id==true){
      //$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
      $this->session->set_flashdata('msg', 'New institute Successfully Inserted ');
      $this->logger->write_message("success", $this->input->post('bank_code').'  successfully Inserted');
      redirect("accounts/Institute");
    }else{
      //$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
      $this->session->set_flashdata('msg', 'Something went wrong! please try again');
      $this->logger->write_message("success", $this->input->post('bank_code').'  Something went wrong! please try again');
      redirect("accounts/Institute");
    }
  }
    function branch_data()
    {
      $id=$this->input->post('id');
      $branch=$this->institute_model->get_branch_names($id);
      if($branch){
        echo json_encode($branch);
      }
    }

}
