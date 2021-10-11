<?php

class Loan extends CI_Controller {

  function Loan(){
    parent::__construct();
    $this->load->model('loan_model');
    $this->load->model('common_model');
    $this->load->library('Spreadsheet_Excel_Reader');
    $this->load->model('paymentvoucher_model');
    $this->load->model('salesmen_model');
    $this->is_logged_in();
  }

  function index(){
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $this->load->library('pagination');
    $page_count = (int)$this->uri->segment(4);

    if(!$page_count)
    $page_count = 0;

    if($page_count>29){
      $viewData['home_class']='Active'; //redirect to pending loan page
    }else{
      $viewData['home_class']='Hide';
    }

    /* Pagination configuration */
    $config['base_url'] = site_url('accounts/loan/index');
    $config['uri_segment'] = 4;

    $pagination_counter = RAW_COUNT;
    $config['num_links'] = 10;
    $config['per_page'] = $pagination_counter;
    $config['full_tag_open'] = '<ul id="pagination-flickr">';
    $config['full_close_open'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active">';
    $config['cur_tag_close'] = '</li>';
    $config['next_link'] = 'Next &#187;';
    $config['next_tag_open'] = '<li class="next">';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&#171; Previous';
    $config['prev_tag_open'] = '<li class="previous">';
    $config['prev_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li class="first">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li class="last">';
    $config['last_tag_close'] = '</li>';
    $startcounter = ($page_count)*$pagination_counter;
    $viewData['datalist'] =$datalist= $this->loan_model->get_all_loans($pagination_counter, $page_count);
    $config['total_rows'] = $this->db->count_all('ac_outside_loans');
    $this->pagination->initialize($config);

    $viewData['prjlist'] = $this->loan_model->get_all_projects();
    $viewData['assetlist'] = $this->loan_model->get_all_assets();
    $viewData['banklist']=$this->common_model->getbanklist();
    $viewData['legers']=$this->loan_model->get_all_legers();
    $banknames=Null;
    $paid_details=Null;
    $paid_shedule=Null;
    $pending_shedule=Null;
    if($datalist){
      foreach ($datalist as $key => $value) {
        $banknames[$value->bank_code]=$this->loan_model->getbank_byid($value->bank_code);
        $paid_details[$value->id]=$this->loan_model->getpaid_details_byid($value->id);
        $paid_shedule[$value->id]=$this->loan_model->getpaid_shedule_byid($value->id);
        $pending_shedule[$value->id]=$this->loan_model->getpending_shedule_byid($value->id);
      }
    }
    $viewData['banknames']=$banknames;
    $viewData['paid_details']=$paid_details;
    $viewData['paid_shedule']=$paid_shedule;
    $viewData['pending_shedule']=$pending_shedule;


    $this->load->view('accounts/loan/index',$viewData);
  }

  function load_acclist(){
    $data=NULL;
    $this->load->view('accounts/account/index',$data);
    return;
  }

  function get_blocks()
  {
    $prjid=$this->input->post('id');
    $blocks_prj=$this->loan_model->get_blocks_by_projects($prjid);
    if($blocks_prj){
      echo json_encode($blocks_prj);
    }

  }

  function add()
  {
    //$this->form_validation->set_rules('leger_acc', 'Leger Account', 'required');
		//$this->form_validation->set_rules('credit_leger_acc', 'Other Leger Account', 'required');
    if($this->input->post('leger_acc')!="" && $this->input->post('credit_leger_acc')!=""){
      if($this->input->post('bank1')!="" && $this->input->post('acc1')!=""){

    $id=$this->loan_model->add();
    if($id){
      $this->session->set_flashdata('msg', 'New Loan Successfully Inserted ');
      $this->logger->write_message("success", $this->input->post('loan_number').' Loan successfully Inserted');
      redirect("accounts/loan");
    }else{
      $this->session->set_flashdata('msg', 'Something Went wrong..! please try again.. ');
      $this->logger->write_message("success", 'Something Went wrong..! please try again..');
      redirect("accounts/loan");
    }}else{
      $this->session->set_flashdata('msg', 'You Have Not Select Bank Accounts. Please Enter Loan Again..');
      $this->logger->write_message("success", 'Something Went wrong..! please try again..');
      redirect("accounts/loan");
    }}else{
      $this->session->set_flashdata('msg', 'You Have Not Select Leger Accounts. Please Enter Loan Again..');
      $this->logger->write_message("success", 'Something Went wrong..! please try again..');
      redirect("accounts/loan");
    }

  }

  function editloan()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $session = array('activtable'=>'ac_outside_loans');
    $this->session->set_userdata($session);
    $viewData['loan_byid'] =$loan_byid= $this->loan_model->get_loan_byid($this->uri->segment(4));
    $viewData['prjlist'] = $this->loan_model->get_all_projects();
    $viewData['assetlist'] = $this->loan_model->get_all_assets();
    $viewData['banklist']=$this->common_model->getbanklist();
    $viewData['legers']=$this->loan_model->get_all_legers();

    $banknames=Null;
    $lots_no=Null;
    if($loan_byid){
      $banknames[$loan_byid->bank_code]=$this->loan_model->getbank_byid($loan_byid->bank_code);
    }
    if($loan_byid->loan_type=='mortgage'){
      if(!$loan_byid->sub_loan_type)
      {
        if($loan_byid->sub_loan_type=='inventory')
        {
          //$lots_no[$loan_byid->id]=$this->loan_model->getlot_no_byid($loan_byid->id);
          $viewData['blocks_prj']=$blocks_prj=$this->loan_model->get_blocks_by_projects($loan_byid->asset_id);
          $lots_no[$loan_byid->asset_id]=$this->loan_model->get_prj_lotlist($loan_byid->asset_id,$loan_byid->id);
        }
      }

    }
    $viewData['banknames']=$banknames;
    $viewData['lots_no']=$lots_no;
    $this->load->view('accounts/loan/editloan',$viewData);
  }

  function editloan_update($id)
  {

    $id=$this->loan_model->edit($id);

    $this->session->set_flashdata('msg', 'Loan Successfully updated ');
    $this->logger->write_message("success", $this->input->post('loan_number').' Loan successfully Inserted');
    redirect("accounts/loan");
  }

  function approval()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $viewData['datalist'] =$datalist= $this->loan_model->get_pending_loans();
    $banknames=Null;
    if($datalist){
      foreach ($datalist as $key => $value) {
        $banknames[$value->bank_code]=$this->loan_model->getbank_byid($value->bank_code);
      }

    }
    $viewData['banknames']=$banknames;

    $this->load->view('accounts/loan/loanapprovals',$viewData);
  }

  function loanapprovals_view()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }

    $session = array('activtable'=>'ac_outside_loans');
    $this->session->set_userdata($session);
    $viewData['loan_byid'] =$loan_byid= $this->loan_model->get_loan_byid($this->uri->segment(4));
    $viewData['prjlist'] = $this->loan_model->get_all_projects();
    $viewData['assetlist'] = $this->loan_model->get_all_assets();
    $viewData['banklist']=$this->common_model->getbanklist();
    $banknames=Null;
    $assetName=Null;
    $prjName=Null;
    $blockList=Null;
    if($loan_byid){
      $banknames[$loan_byid->bank_code]=$this->loan_model->getbank_byid($loan_byid->bank_code);
      $assetName[$loan_byid->asset_id]=$this->loan_model->getasset_byid($loan_byid->asset_id);
      $prjName[$loan_byid->asset_id]=$this->loan_model->getprj_byid($loan_byid->asset_id);
    }
    if($loan_byid->loan_type=='mortgage'){
      //$lots_no[$loan_byid->id]=$this->loan_model->getlot_no_byid($loan_byid->id);
      $blockList[$loan_byid->asset_id]=$this->loan_model->get_prj_lotlist($loan_byid->asset_id,$loan_byid->id);

    }
    $viewData['banknames']=$banknames;
    $viewData['blockList']=$blockList;
    $viewData['assetName']=$assetName;
    $viewData['prjName']=$prjName;
    $this->load->view('accounts/loan/loanapprovals_view',$viewData);
  }

  public function confirm()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $id=$this->loan_model->confirm($this->uri->segment(4));

    //$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
    $this->session->set_flashdata('msg', 'Loan Successfully Confirmed ');
    $this->logger->write_message("success", $this->uri->segment(4).'  Loan successfully Confirmed');
    redirect("accounts/loan/approval");

  }
  function shedule(){
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $viewData['datalist'] =$datalist= $this->loan_model->get_loans_numbers();
    $viewData['sheduledatalist'] =$datalist= $this->loan_model->get_sheduleloans_numbers();
    $this->load->view('accounts/loan/loanshedule',$viewData);
  }
  function add_shedule()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $file_name="";
    $data['loan_name']=$loan_name=$loan_no=$this->input->post('loan_name');
    $today = date("Y-m-d H:i:s");
    $uploadmonth=date("F", strtotime($today));
    $uploadyear=date("Y", strtotime($today));
    $config['upload_path'] = 'uploads/loan/external_loan/'.$uploadmonth.$uploadyear;
    if ( ! file_exists($config['upload_path']) )
    {
      $create = mkdir($config['upload_path'], 0777);
      if ( ! $create)
      return;
    }
    $config['allowed_types'] = 'xls|xlsx|csv';
    $config['max_size'] = '5000';


    $this->load->library('upload', $config);
    $this->upload->do_upload('shedule_file');
    $error = $this->upload->display_errors();

    $image_data = $this->upload->data();
    //$this->session->set_flashdata('error',  $error );
    if($error=="")
    $file_name = $image_data['file_name'];
    else
    {

      $this->session->set_flashdata('error',  $error );
    }
    $this->loan_model->addshedule_filename($file_name);


    $excel = new Spreadsheet_Excel_Reader();

    $excelread=$excel->read($config['upload_path'].'/'.$file_name);
    If($excelread){
      $this->session->set_flashdata('error', 'Excel sheet format error, Please download the format and upload again');
      $this->logger->write_message("error", $loan_name.'  Excel sheet format error, Please download the format and upload again');
      redirect("accounts/loan/shedule");
    }
    $data['data_excell']=$data_excell=$excel->sheets[0]['cells'];
    if($data_excell){
      $this->loan_model->delete_ex_shedule();
      $top_row=($data_excell[1][1]);

      if(preg_match('/[a-z]/',$top_row)){
    //  if($top_row=="instalment"){

        array_shift($data_excell);
      }
      foreach ($data_excell as $key => $value) {

        if (is_numeric($value[1]) && isset($value[2]) && isset($value[3]) && isset($value[4]) && isset($value[5])) {
          $date=date("Y-m-d",(strtotime ( '-1 day' ,strtotime(str_replace('/','-',$value[5])))));
          $cheque_no="";
          if(empty($value[6])){
            $cheque_no="";
          }else{
            $cheque_no=$value[6];
          }
          $data=array(
            'loan_id'=>$this->input->post('loan_no'),
            'instalment'=>$value[1],
            'cap_amount'=>$value[2],
            'int_amount'=>$value[3],
            'tot_instalment'=>$value[4],
            'deu_date'=>$date,
            'cheque_no'=>$cheque_no,
            'created_by'=>$this->session->userdata('username'),
            'created_at'=>date("Y-m-d"),
          );

          $id=$this->loan_model->addshedule($data);
        }
        else{
          $this->session->set_flashdata('error', 'Something Wrong In Excel sheet. Please Try Again.');
          $this->logger->write_message("error", $loan_name.'Something Wrong In Excel sheet. Please Try Again.');
          redirect("accounts/loan/shedule");
        }
      }
    }else{
      $this->session->set_flashdata('error', 'Please Check Again Loan Shedule');
      $this->logger->write_message("error", $loan_name.'  Please Check Again Loan Shedule');
      redirect("accounts/loan/shedule");
    }

    $this->session->set_flashdata('msg', 'Loan Shedule Updated');
    $this->logger->write_message("success", $loan_name.'  Loan Shedule Updated');
    redirect("accounts/loan/shedule");

  }

  function get_shedules()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $sheduleid=$this->input->post('id');
    $shedules=$this->loan_model->get_shedule_by_loans($sheduleid);
    if($shedules){
      echo json_encode($shedules);
    }

  }

  function payment()
  {
    if ( ! check_access('outsideloan_paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    if ( ! check_access('paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $loandata="";
    $data['loan_numbers']=$loan_numbers=$this->loan_model->get_sheduleloans_numbers();
    $data['payid_details']=$payid_details=$this->loan_model->payment_details();
    foreach ($payid_details as $key => $value) {
      $loandata[$value->loan_id]=$this->loan_model->get_loan_byid($value->loan_id);
    }
    $data['loandata']=$loandata;
    $this->load->view('accounts/loan/loanpayments',$data);
  }
  function get_rentalpaydata()
  {
    if ( ! check_access('outsideloan_paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $leger_id="";
    $bank_id="";
    $bank_name="";
    $data['loandata']=$loandata=$this->loan_model->get_loan_byid($this->uri->segment(4));

    $bank_id=$loandata->bank_code;
    $leger_id=$loandata->leger_account_no;

    $data['bank']=$bank=$loandata=$this->loan_model->getbank_byid($bank_id);
    $bank_name=$bank->BANKNAME;
    $data['leger_id']=$leger_id;
    $data['bank_id']=$bank_id;
    $data['bankname']=$bank_name;

    $type=$this->uri->segment(6);
    if($type=="installment")
    {
      $data['dataset1']='';
      $data['paydate']=$paydate=$this->uri->segment(5);

      $data['dataset']=$this->loan_model->get_repayment_shedeule($this->uri->segment(4));
      $this->load->view('accounts/loan/paymentshedule',$data);
    }else if($type=="capital_payment")
    {
      $data['dataset1']='';
      $data['paydate']=$paydate=$this->uri->segment(5);

      $this->load->view('accounts/loan/paymentcapital',$data);
    }


  }
  function pay_rental()
  {
    if ( ! check_access('outsideloan_paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $id=$this->loan_model->add_payment();

    $this->session->set_flashdata('msg', 'Payment Successfully Added');
    $this->logger->write_message("success", 'Payment Successfully Added');
    redirect("accounts/loan/payment");
  }
  function pay_rental_confirm()
  {
    if ( ! check_access('outsideloan_paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['paydata']=$paydata=$this->loan_model->get_paydata_byid($this->uri->segment(4));
    $pay_id=$this->uri->segment(4);
    $loan_no=$paydata->loan_id;
    $ins_id=$paydata->ins_id;
    $payamount=$paydata->pay_amount;
    $paydate=$paydata->pay_date;
    $data['loandata']=$loandata=$this->loan_model->get_loan_byid($loan_no);

    $bank_id=$loandata->bank_code;
    $leger_id=$loandata->leger_account_no;

    $data['bank']=$bank=$loandata=$this->loan_model->getbank_byid($bank_id);
    $bank_name=$bank->BANKNAME;
    $data['leger_id']=$leger_id;
    $data['bank_id']=$bank_id;
    $data['bankname']=$bank_name;

    $voucherid=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata',$paydate);
    $arrayName = array($voucherid,$loan_no,$leger_id,$bank_id,$bank_name,$ins_id,$payamount,$paydate,$pay_id);
    $id=$this->loan_model->cornfirm_payment($arrayName);

    $this->session->set_flashdata('msg', 'Payment Successfully Added');
    $this->logger->write_message("success", 'Payment Successfully Added');
    redirect("accounts/loan/payment");
  }
  function loanpaymentedit_view()
  {
    if ( ! check_access('outsideloan_paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['paydata']=$paydata=$this->loan_model->get_paydata_byid($this->uri->segment(4));
    $data['loan_no']=$loan_no=$paydata->loan_id;
    $data['ins_id']=$ins_id=$paydata->ins_id;
    $data['payamount']=$payamount=$paydata->pay_amount;
    $data['paydate']=$paydate=$paydata->pay_date;
    $data['loandata']=$loandata=$this->loan_model->get_loan_byid($loan_no);
    $data['loanname']=$loandata->loan_number;

    $this->load->view('accounts/loan/loanpaymentedit_view',$data);

  }
  function editpayments()
  {
    if ( ! check_access('outsideloan_paymnet'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $id=$this->loan_model->edit_payment($this->uri->segment(4));

    $this->session->set_flashdata('msg', 'Payment Amount Successfully updated ');
    $this->logger->write_message("success", $this->input->post('loan_number').'Payment Amount successfully updated');
    redirect("accounts/loan/payment");
  }

  function shedule_view()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $loanid=$this->uri->segment(4);
    $data['loandata']=$loandata=$this->loan_model->get_loan_byid($loanid);

    $data['sheduleid']=$loanid;
    $data['shedules']=$shedules=$this->loan_model->get_shedule_by_loans($loanid);
    $this->load->view('accounts/loan/shedule',$data);
  }
  function view_otherdetails()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $loanid=$this->uri->segment(4);
    $data['loandata']=$loandata=$this->loan_model->get_loan_byid($loanid);
    $fixed_assets=Null;
    $prjlist=Null;
    $prjName=Null;
    if(!$loandata->asset_id)
    {
      if(!$loandata->sub_loan_type)
      {
        if($loandata->sub_loan_type=="inventory")
        {
          $prjName[$loandata->asset_id]=$this->loan_model->getprj_byid($loandata->asset_id);
          $prjlist[$loandata->asset_id]=$this->loan_model->get_prj_lotlist($loandata->asset_id,$loanid);

        }else if($loandata->sub_loan_type=="fixed_assets")
        {
          $fixed_assets[$loandata->asset_id]=$this->loan_model->get_fixed_asset($loandata->asset_id);
        }

      }else{
        $fixed_assets[$loandata->asset_id]=$this->loan_model->get_fixed_asset($loandata->asset_id);
      }
      $data['fixed_assets']=$fixed_assets;
      $data['prjlist']=$prjlist;
      $data['prjName']=$prjName;
    }
    $this->load->view('accounts/loan/loanother_data',$data);
  }
  function due_installment()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['banklist']=$this->common_model->getbanklist();
    $this->load->view('accounts/loan/due_instalment',$data);
  }
  function get_due_instalment()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['month']=$month=$this->uri->segment(4);
    $year=date('y');
    $stdate=$year.'-'.$month.'-01';
		$endate=$year.'-'.$month.'-31';
    $data['duelist']=$duelist=$this->loan_model->get_due_amounts($stdate,$endate);
    $banknames=Null;
    if($duelist){
      foreach ($duelist as $key => $value) {
        $banknames[$value->bank_code]=$this->loan_model->getbank_byid($value->bank_code);
      }
    }
    $data['banknames']=$banknames;
    $this->load->view('accounts/loan/due_instalment_view',$data);
  }
  function report()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['banklist']=$this->common_model->getbanklist();
    $this->load->view('accounts/loan/report/report_main',$data);
  }
  function get_report()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['code']=$code=$this->uri->segment(4);
    $data['bank']=$bank=$this->uri->segment(5);
    $data['datalist'] =$datalist= $this->loan_model->get_loans();
    $banknames=Null;
    if($datalist){
      foreach ($datalist as $key => $value) {
        $banknames[$value->bank_code]=$this->loan_model->getbank_byid($value->bank_code);
      }
    }
    $data['banknames']=$banknames;

    $this->load->view('accounts/loan/report/ongoing_loan_report',$data);
  }
  function report_excel()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $data['datalist'] =$datalist= $this->loan_model->get_loans();
    $banknames=Null;
    if($datalist){
      foreach ($datalist as $key => $value) {
        $banknames[$value->bank_code]=$this->loan_model->getbank_byid($value->bank_code);
      }
    }
    $data['banknames']=$banknames;

    $this->load->view('accounts/loan/report/ongoing_loan_report_excel',$data);
  }
  function get_loanfulldata()
  {
    if ( ! check_access('outside_loan'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('accounts/loan');
      return;
    }
    $loan_id=$this->uri->segment(4);
    $mode=$this->uri->segment(5);
    $data['loan_id']=$loan_id;
    $data['loan_data']=$loan_data=$this->loan_model->get_loan_byid($loan_id);
    $data['paydata']=$paydata=$this->loan_model->getpaid_details_byid($loan_id);
    $data['paydetails']=$paydetails=$this->loan_model->payment_details_by_loan($loan_id);
    $data['shedetails']=$shedetails=$this->loan_model->get_shedule_by_loans($loan_id);
    if(!$mode){
      $this->load->view('accounts/loan/loan_data',$data);
    }else if($mode=="print_loaninquary"){
      $this->load->view('accounts/loan/print_loaninquary',$data);
    }else if($mode=="excel_loaninquary"){
      $this->load->view('accounts/loan/excel_loaninquary',$data);
    }

  }


}
