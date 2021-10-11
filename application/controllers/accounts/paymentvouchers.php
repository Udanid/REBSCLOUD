<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paymentvouchers extends CI_Controller {

    function Paymentvouchers()
    {
        parent::__construct();
        $this->load->model('paymentvoucher_model');
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('ac_projects_model');
        $this->load->model('cheque_model');
		//$this->load->model("project_model");
		$this->load->model('common_model');
		$this->load->model("branch_model");
		$this->is_logged_in();
    }
    function index()
    {
        $data=NULL;
		if ( ! check_access('view_voucherlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/');
			return;
		}
		//$data['searchpath']='';

        /* Calculating difference in Opening Balance */
        $ac_projects = $this->paymentvoucher_model->get_pending_payment_vouchers($this->session->userdata('branchid'));
        if (!$ac_projects)
        {
           // $this->messages->add('No Pending Payment Vouchers', 'message');
        }
        $data['ac_projects'] = $ac_projects;
        $data['employee']=$this->paymentvoucher_model->get_employeedata();
        $prjlist=$this->ac_projects_model->get_all_ac_projects();
        if($prjlist)
        {
            foreach($prjlist as $raw)
            {
                $balance=$this->Ledger_model->get_ledger_balance($raw->gl_code);
                $udate=array('fund_district'=>$balance);
                if ( ! $this->db->where('gl_code', $raw->gl_code)->update('ac_projects', $udate))
                {
                    $this->db->trans_rollback();
                    $this->messages->add('Error updating ac_projects table.', 'error');
                }
            }
        }
        $employee=$this->paymentvoucher_model->get_employeedata();
        $data['employee']=$employee;
        $data['empid']="";

        $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
        $data['projectdata']=$this->ac_projects_model->get_all_ac_projects();
 		$data['branchlist']=$this->branch_model->get_all_branches_summery();
        //$projectdata=

        $data['vouchertypes']=$vouchertypes;
        $data['typeid']="";
        $data['refnumber'] = array(
            'name' => 'refnumber',
            'id' => 'refnumber',
            'maxlength' => '250',
            'size' => '40',
            'value' => '',
        );

        $data['payeename'] = array(
            'name' => 'payeename',
            'id' => 'payeename',
            'maxlength' => '100',
            'size' => '40',
            'value' => '',
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date_today_php(),
        );
        $data['paymentdes'] = array(
            'name' => 'paymentdes',
            'id' => 'paymentdes',
            'rows' => '4',
            'cols' => '60',
            'value' => '',
        );
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'maxlength' => '100',
            'size' => '20',
            'value' => '',
        );
        $data['prjid']='';
        $data['subprjid']='';
        $data['applymonth']='';
        $data['name'] = '';
        //print_r($data['employee']);
        //$this->load->view('layout_acountant',$data);

        //$this->template->load('template', 'paymentvouchers/index',$data);
        // $data=NULL;

        $entry_type='payment';
        $data['tag_id'] = 0;
        $entry_type_id = 0;


        $entry_type_id = entry_type_name_to_id($entry_type);
        $entry_q = NULL;

        /* Pagination setup */
        $this->load->library('pagination');

        /*if ($entry_type_id > 0) {
           $this->db->select('ac_entries.*, SUM(ac_payvoucherdata.amount) as amount')->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')
		   ->where('ac_entries.entry_type', '2')->where('ac_chqprint.CHQSTATUS', 'PRINT')
		   ->where('ac_payvoucherdata.printflag', 'NO')->group_by('ac_payvoucherdata.entryid')->order_by('ac_payvoucherdata.voucherid','DESC')->limit(0,10);
             $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->group_by('entryid')->order_by('voucherid','DESC')->get()->num_rows();
        }*/
if ($entry_type_id > 0) {
            $this->db->select('ac_entries.*, SUM(ac_payvoucherdata.amount) as amount,ac_chqprint.CHQNO,ac_chqprint.CHQSTATUS,ac_payvoucherdata.entryid')->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_chqprint.PAYREFNO')
			->where('ac_entries.entry_type', '2')->where('ac_chqprint.CHQSTATUS', 'PRINT')->where('ac_payvoucherdata.printflag', 'NO')
			->group_by('ac_payvoucherdata.entryid')->order_by('ac_payvoucherdata.voucherid','DESC');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_chqprint.PAYREFNO')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->group_by('entryid')->order_by('voucherid','DESC')->get()->num_rows();
        }


        $data['entry_data'] = $entry_q;

        $data['entry_data'] = $entry_q;


		  if ($entry_type_id > 0) {
            $this->db->select('ac_entries.*,ac_chqprint.CHQSTATUS,,ac_chqprint.CHQBID')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('CHQSTATUS', 'CONFIRM')->order_by('CRDATE','DESC')->limit(50, 0);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q1 = $this->db->get('ac_entries');
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('CHQSTATUS', 'CONFIRM')->order_by('CRDATE')->get()->num_rows();
        }

// print_r($entry_q);
      //  $isstart=$this->cheque_model->get_start_cheque_bundle($this->session->userdata('branchid'));
       // $bookid=$isstart->CHQBID;
       // if($isstart)
       // {
            $this->pagination->initialize($config);
            $data['entry_pdata'] = $entry_q1;

        //}
       // else
       // {

        //    $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');

       // }
        $this->load->view('accounts/paymentvouchers/index',$data);
        return;
    }
function reprint_newlist()
    {
        $data=NULL;
		if ( ! check_access('view_voucherlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/');
			return;
		}
		//$data['searchpath']='';

        /* Calculating difference in Opening Balance */
        $ac_projects = $this->paymentvoucher_model->get_pending_payment_vouchers($this->session->userdata('branchid'));
        if (!$ac_projects)
        {
           // $this->messages->add('No Pending Payment Vouchers', 'message');
        }
        $data['ac_projects'] = $ac_projects;
        $data['employee']=$this->paymentvoucher_model->get_employeedata();
        $prjlist=$this->ac_projects_model->get_all_ac_projects();
        if($prjlist)
        {
            foreach($prjlist as $raw)
            {
                $balance=$this->Ledger_model->get_ledger_balance($raw->gl_code);
                $udate=array('fund_district'=>$balance);
                if ( ! $this->db->where('gl_code', $raw->gl_code)->update('ac_projects', $udate))
                {
                    $this->db->trans_rollback();
                    $this->messages->add('Error updating ac_projects table.', 'error');
                }
            }
        }
        $employee=$this->paymentvoucher_model->get_employeedata();
        $data['employee']=$employee;
        $data['empid']="";

        $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
        $data['projectdata']=$this->ac_projects_model->get_all_ac_projects();

        //$projectdata=

        $data['vouchertypes']=$vouchertypes;
        $data['typeid']="";
        $data['refnumber'] = array(
            'name' => 'refnumber',
            'id' => 'refnumber',
            'maxlength' => '250',
            'size' => '40',
            'value' => '',
        );

        $data['payeename'] = array(
            'name' => 'payeename',
            'id' => 'payeename',
            'maxlength' => '100',
            'size' => '40',
            'value' => '',
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date_today_php(),
        );
        $data['paymentdes'] = array(
            'name' => 'paymentdes',
            'id' => 'paymentdes',
            'rows' => '4',
            'cols' => '60',
            'value' => '',
        );
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'maxlength' => '100',
            'size' => '20',
            'value' => '',
        );
        $data['prjid']='';
        $data['subprjid']='';
        $data['applymonth']='';
        $data['name'] = '';
        //print_r($data['employee']);
        //$this->load->view('layout_acountant',$data);

        //$this->template->load('template', 'paymentvouchers/index',$data);
        // $data=NULL;

        $entry_type='payment';
        $data['tag_id'] = 0;
        $entry_type_id = 0;


        $entry_type_id = entry_type_name_to_id($entry_type);
        $entry_q = NULL;

        /* Pagination setup */
        $this->load->library('pagination');

        if ($entry_type_id > 0) {
            $this->db->select('ac_entries.*, SUM(ac_payvoucherdata.amount) as amount,ac_chqprint.CHQNO,ac_chqprint.CHQSTATUS,ac_payvoucherdata.entryid')->from('ac_entries')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid')
			->where('ac_entries.entry_type', '2')->where('ac_chqprint.CHQSTATUS', 'PRINT')->where('ac_payvoucherdata.printflag', 'YES')
			->group_by('ac_payvoucherdata.entryid')->order_by('ac_payvoucherdata.voucherid','DESC')->limit(30,0);
			  $entry_rq = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->group_by('entryid')->order_by('voucherid','DESC')->get()->num_rows();
        }


        $data['entry_datar'] = $entry_rq;


		if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->where('CHQSTATUS', 'PRINT')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc')->limit(30,0);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_reprint = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->get()->num_rows();
        }
 $data['entry_reprint'] = $entry_reprint;
// print_r($entry_q);
       // $isstart=$this->cheque_model->get_start_cheque_bundle($this->session->userdata('branchid'));
        //$bookid=$isstart->CHQBID;

		$this->pagination->initialize($config);
        $this->load->view('accounts/paymentvouchers/reprint_list',$data);
        return;
    }

    function add()
    {
        $data=NULL;

        /* Check access */
        if ( ! check_access('add voucher'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
        /* Form fields */
        $employee=$this->paymentvoucher_model->get_employeedata();
        $data['employee']=$employee;
        $data['empid']="";

        $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
        $data['projectdata']=$this->ac_projects_model->get_all_ac_projects();
        $data['subac_projects']=$this->ac_projects_model->get_all__sub_ac_projects();
        //$projectdata=

        $data['vouchertypes']=$vouchertypes;
        $data['typeid']="";
        $data['refnumber'] = array(
            'name' => 'refnumber',
            'id' => 'refnumber',
            'maxlength' => '250',
            'size' => '40',
            'value' => '',
        );

        $data['payeename'] = array(
            'name' => 'payeename',
            'id' => 'payeename',
            'maxlength' => '100',
            'size' => '40',
            'value' => '',
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date_today_php(),
        );
        $data['paymentdes'] = array(
            'name' => 'paymentdes',
            'id' => 'paymentdes',
            'rows' => '4',
            'cols' => '60',
            'value' => '',
        );
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'maxlength' => '100',
            'size' => '20',
            'value' => '',
        );
        $data['prjid']='';
        $data['subprjid']='';
        $data['applymonth']='';
        $data['name'] = '';
        /* Form validations */
//        $this->form_validation->set_rules('refnumber', 'Document Reference Number', 'trim|required|min_length[2]|max_length[100]');
//        $this->form_validation->set_rules('vouchertype', 'Voucher Type', 'trim|required');
//        $this->form_validation->set_rules('payeename', 'Payee Name', 'trim|required');
//
//        $this->form_validation->set_rules('paymentdes', 'Payment Description', 'trim||required');
//        $this->form_validation->set_rules('amount', 'Amount', 'trim|currency|required');

        /* Re-populating form */
        if ($_POST)
        {
            $payeecode="";$payeename="";
            if($this->input->post('employeename', TRUE)!=''){

                $arr=explode(',',$this->input->post('employeename', TRUE));
                $payeecode=$arr[0];
                $payeename=$arr[1];
//                var_dump($payeecode,$payeename);
//                die();
            }


//            if($this->input->post('vouchertype', TRUE)=="6")
//            {
//                $payeecode=$this->input->post('projectvote', TRUE);
//                $this->form_validation->set_rules('projectvote', 'Project Code', 'trim|required');
//
//            }
            if($this->input->post('vouchertype', TRUE)=="1" ||$this->input->post('vouchertype', TRUE)=="2")
              //  $this->form_validation->set_rules('applymonth', 'Month', 'trim|required');
            $data['empid']=$this->input->post('employeename', TRUE);
            $data['refnumber']['value'] = $this->input->post('refnumber', TRUE);
            $data['branch_code']['value'] =$this->input->post('branch_code');
            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
            $data['typeid'] = $this->input->post('vouchertype', TRUE);
            $data['payeename']['value'] =$this->input->post('payeename', TRUE);
            $data['name'] =  $payeename;
            $data['prjid']=$this->input->post('projectvote', TRUE);
            $data['subprjid']=$this->input->post('subprojectid', TRUE);
            $data['applymonth']=$this->input->post('applymonth', TRUE);
            $data['paymentdes']['value'] = $this->input->post('paymentdes', TRUE);
            $data['amount']['value'] = $this->input->post('amount', TRUE);

        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//           // $this->load->view('accounts/paymentvouchers/add', $data);
//            return;
//        }
        if ( ! check_access('add voucher'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('accounts/paymentvouchers/');
            return;
        }
        else
        {//echo "test";
//            if($this->input->post('vouchertype', TRUE)=="6")
//            {
//                $prjdata=$this->ac_projects_model->get_project_by_refid($payeecode);
//                $recievid=(float)$prjdata->fund_release;
//                $fund_district 	=$prjdata->fund_district ;
//                $total=(float)$fund_district+(float)$this->input->post('amount', TRUE);
//            }

            $refnumber = $this->input->post('refnumber', TRUE);
            $branch_code =$this->input->post('branch_code');
            $applymonth=$this->input->post('applymonth', TRUE);
            $payeecode = $payeecode;
            $payeename=$this->input->post('payeename', TRUE);
            $vouchertype = $this->input->post('vouchertype', TRUE);
            $paymentdes = $this->input->post('paymentdes', TRUE);
            $amount = $this->input->post('amount', TRUE);
            $data_date = $this->input->post('entry_date', TRUE);
//            var_dump($data_date);
//            die();

            $this->db->trans_start();
           $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',$data_date);
			$id=$idlist[0];
			if(get_rate('Payment Voucher confirmation'))
			$status='PENDING';
			else
			$status='CONFIRMED';

            $insert_data1 = array(
                'voucherid'=>$id,
				'vouchercode'=>$idlist[1],
                'refnumber' => $refnumber,
                'branch_code'=> $branch_code,
                'applymonth'=>$applymonth,
                'payeecode' => $payeecode,
                'payeename' => $payeename,
                'vouchertype' => $vouchertype,
                'paymentdes' => $paymentdes,
                'amount' => $amount,
                //'applydate' => date_php_to_mysql($data_date),
                'applydate' => $data_date,
                'status' =>$status,

            );
//            if( $this->input->post('subprojectid', TRUE)!="")
//            {
//
//                $insert_data2 = array(
//                    'subprjid'=>$this->input->post('subprojectid', TRUE),
//                    'document_refno' => $id,
//                    'amount'=>$amount,
//                    'createdate' => date_php_to_mysql($data_date),
//                    'status' =>'PENDING',);
//                $this->db->insert('project_subpayments', $insert_data2);
//            }
            if ( ! $this->db->insert('ac_payvoucherdata', $insert_data1))
            {
                $this->db->trans_rollback();
                $this->messages->add('Error addding Payment Voucher sss-  ' .$id. $refnumber . '.', 'error');
                $this->logger->write_message("error", "Error adding Payment Voucher " . $id);
                $this->load->view('accounts/paymentvouchers/index', $data);
                return;
            } else {
                $this->db->trans_complete();
                $this->messages->add('Added Payment Voucher  - ' . $refnumber . '.', 'success');
                $this->logger->write_message("success", "Added Payment Voucher " . $id);
                 $this->session->set_flashdata('tab', 'voucher');
				redirect('accounts/payments/index');
                return;
            }
        }
        return;
    }
//    function supplier_invices($supplier_id)
//    {
//        $data['amount'] = array(
//            'name' => 'amount',
//            'id' => 'amount',
//            'readonly'=>'readonly',
//            'maxlength' => '100',
//            'size' => '20',
//            'value' => '',
//        );
//        $data['paymentdes'] = array(
//            'name' => 'paymentdes',
//            'id' => 'paymentdes',
//            'rows' => '4',
//            'cols' => '60',
//            'value' => '',
//        );
//        $data['invoicelist']=$this->paymentvoucher_model->get_invoicelist($supplier_id);
//        $this->load->view('paymentvouchers/invoice_list',$data);
//    }
//
//    function addsupp()
//    {
//        $this->template->set('page_title', 'New Payment Voucher');
//
//        /* Check access */
//        if ( ! check_access('add vouchers'))
//        {
//            $this->messages->add('Permission denied.', 'error');
//            redirect('paymentvouchers');
//            return;
//        }
//        /* Form fields */
//        //get_supplierData
//
//
//        $suplier=$this->paymentvoucher_model->get_supplierData();
//        $data['entry_date'] = array(
//            'name' => 'entry_date',
//            'id' => 'entry_date',
//            'readonly'=>'readonly',
//            'maxlength' => '11',
//            'size' => '11',
//            'value' => date_today_php(),
//        );
//
//        $data['suplier']=$suplier;
//        $data['supid']="";
//        $data['amount'] = array(
//            'name' => 'amount',
//            'id' => 'amount',
//            'readonly'=>'readonly',
//            'maxlength' => '100',
//            'size' => '20',
//            'value' => '',
//        );
//        $data['paymentdes'] = array(
//            'name' => 'paymentdes',
//            'id' => 'paymentdes',
//            'rows' => '4',
//            'cols' => '60',
//            'value' => '',
//        );
//
//        $data['name'] = '';
//        /* Form validations */
//
//        $this->form_validation->set_rules('suppliername', 'Supplier Name', 'trim||required');
//        $this->form_validation->set_rules('paymentdes', 'Payment Description', 'trim');
//        $this->form_validation->set_rules('amount', 'Amount', 'trim|currency|required');
//
//        /* Re-populating form */
//        if ($_POST)
//        {
//
//
//
//            $supid=$data['supid']=$this->input->post('suppliername', TRUE);
//
//            if($this->input->post('suppliername', TRUE)!="")
//            {
//                $data['invoicelist']=$this->paymentvoucher_model->get_invoicelist($this->input->post('suppliername', TRUE));
//            }
//            $data['paymentdes']['value'] = $this->input->post('paymentdes', TRUE);
//            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
//        }
//
//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'paymentvouchers/addsupp', $data);
//            return;
//        }
//        else
//        {
//            $suplier=$this->paymentvoucher_model->get_supplierdata_byid($supid);
//
//            $refnumber = "";
//            $payeecode = $supid;
//            $payeename=$suplier->name;
//            $vouchertype = 3;
//            $paymentdes = $this->input->post('paymentdes', TRUE);
//            $amount = $this->input->post('amount', TRUE);
//            $data_date = $this->input->post('entry_date', TRUE);
//
//            //	$id=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata');
//            $id=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata',date_php_to_mysql($data_date));
//            $this->db->trans_start();
//            $rowmatcount=$this->input->post('rawmatcount', TRUE);
//            $invoceilist="";
//            for($i=1; $i<=$rowmatcount; $i++)
//            {
//                if($this->input->post('isselect'.$i)=="Yes")
//                {
//                    $invoceilist=$this->input->post('invoicenumber'.$i).",".$invoceilist;
//                    $invoiceno=$this->input->post('invoicenumber'.$i);
//                    $dataupdate=array("voucherid"=>$id,"paystatus"=>"CONFIRMED");
//                    $this->db->where('inv_no', $invoiceno)->where('supplier_id', $supid)->update('ac_invoices', $dataupdate);
//
//                }
//            }
//
//            $insert_data1 = array(
//                'voucherid'=>$id,
//                'refnumber' => $invoceilist,
//                'payeecode' => $payeecode,
//                'payeename' => $payeename,
//                'vouchertype' => $vouchertype,
//                'paymentdes' => $paymentdes,
//                'amount' => $amount,
//                'applydate' => date_php_to_mysql($data_date),
//                'status' =>'PENDING',
//
//            );
//            if ( ! $this->db->insert('ac_payvoucherdata', $insert_data1))
//            {
//                $this->db->trans_rollback();
//                $this->messages->add('Error addding Payment Voucher - ' . $id . '.', 'error');
//                $this->logger->write_message("error", "Error adding Payment Voucher " . $id);
//                redirect('paymentvouchers');
//                return;
//            } else {
//                $this->db->trans_complete();
//                $this->messages->add('Added Payment Voucher  - ' . $id . '.', 'success');
//                $this->logger->write_message("success", "Added Payment Voucher " . $id);
//                $voucherid = $this->db->insert_id();
//                redirect('paymentvouchers');
//            }
//
//
//
//        }
//        return;
//    }
//
//    function edit($id)
//    {
//
//
//        /* Check access */
//        if ( ! check_access('edit vouchers'))
//        {
//            $this->messages->add('Permission denied.', 'error');
//            redirect('paymentvouchers');
//            return;
//        }
//        /* Checking for valid data */
//
//        $data['id']=$id;
//        //	$id = (int)$id;
//        if ($id == "")// edited by Udani 10-09-2013
//        {
//            $this->messages->add('Invalid Payment Voucher.', 'error');
//            redirect('paymentvouchers');
//            return;
//        }
//        $payvoucher=$this->paymentvoucher_model->get_payment_voucher_byid($id);
//
//        //echo print_r($payvoucher);
//        if ($payvoucher==false)
//        {
//            $this->messages->add('Invalid Payment Voucher.....', 'error');
//            //	echo $id;
//            redirect('paymentvouchers');
//            return;
//        }
//        if($payvoucher->status=='PENDING'){
//            $employee=$this->paymentvoucher_model->get_employeedata();
//            $data['employee']=$employee;
//            $data['empid']="";
//            $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
//            $data['projectdata']=$this->ac_projects_model->get_all_ac_projects();
//            $data['subac_projects']=$this->ac_projects_model->get_all__sub_ac_projects();
//
//            $data['vouchertypes']=$vouchertypes;
//            $data['typeid']=$payvoucher->vouchertype;
//            $data['entry_date'] = array(
//                'name' => 'entry_date',
//                'id' => 'entry_date',
//                'readonly'=>'readonly',
//                'maxlength' => '11',
//                'size' => '11',
//                'value' => date_today_php(),
//            );
//            $data['refnumber'] = array(
//                'name' => 'refnumber',
//                'id' => 'refnumber',
//                'maxlength' => '250',
//                'size' => '40',
//                'value' => $payvoucher->refnumber,
//            );
//
//
//            $payeename=$payvoucher->payeecode.','.$payvoucher->payeename;
//
//            $data['payeename'] = array(
//                'name' => 'payeename',
//                'id' => 'payeename',
//                'maxlength' => '100',
//                'size' => '40',
//                'value' => $payeename,
//            );
//
//
//            $data['paymentdes'] = array(
//                'name' => 'paymentdes',
//                'id' => 'paymentdes',
//                'rows' => '4',
//                'cols' => '60',
//                'value' => $payvoucher->paymentdes,
//            );
//
//            $data['amount'] = array(
//                'name' => 'amount',
//                'id' => 'amount',
//                'maxlength' => '100',
//                'size' => '20',
//                'value' => $payvoucher->amount,
//            );
//            $data['subprjid']="";
//            $datasub=$this->ac_projects_model->get_subprojectt_payments_by_voucherid($id);
//            if($datasub)
//            {
//                $data['subprjid']=$datasub->subprjid;
//
//            }
//
//            $data['name'] = $payvoucher->payeename;
//            $data['prjid'] = $payvoucher->payeecode;
//            $data['applymonth']=$payvoucher->applymonth;
//
//            /* Form validations */
//            $this->form_validation->set_rules('refnumber', 'Document Reference Number', 'trim|required|min_length[2]|max_length[100]');
//            //$this->form_validation->set_rules('refnumber', 'Document Reference Number', 'trim|required|min_length[2]|max_length[100]|uniquewithid_new[ac_payvoucherdata.refnumber.'. $id.'.voucherid]');
//            $this->form_validation->set_rules('vouchertype', 'Voucher Type', 'trim|required');
//            $this->form_validation->set_rules('payeename', 'Payee Name', 'trim|required');
//            $this->form_validation->set_rules('paymentdes', 'Payment Description', 'trim||required');
//            $this->form_validation->set_rules('amount', 'Amount', 'trim|currency|required');
//
//            /* Re-populating form */
//            if ($_POST)
//            {
//
//                $arr=explode(',',$this->input->post('payeename', TRUE));
//                $payeecode=$arr[0];
//                $payeename=$arr[1];
//
//
//                if($this->input->post('vouchertype', TRUE)=="6")
//                {
//                    $payeecode=$this->input->post('projectvote', TRUE);
//                    $this->form_validation->set_rules('projectvote', 'Project Code', 'trim|required');
//                }
//                $data['empid']=$this->input->post('employeename', TRUE);
//                $data['refnumber']['value'] = $this->input->post('refnumber', TRUE);
//                $data['typeid'] = $this->input->post('vouchertype', TRUE);
//                $data['payeename']['value'] =$this->input->post('payeename', TRUE);
//                $data['subprjid']=$this->input->post('subprojectid', TRUE);
//                $data['name'] =  $payeename;
//                $data['applymonth']=$this->input->post('applymonth', TRUE);
//                $data['paymentdes']['value'] = $this->input->post('paymentdes', TRUE);
//                $data['amount']['value'] = $this->input->post('amount', TRUE);
//                $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
//                $data['prjid']=$this->input->post('projectvote', TRUE);
//
//            }
//            if ($this->form_validation->run() == FALSE)
//            {
//                $this->messages->add(validation_errors(), 'error');
//                $this->template->load('template', 'paymentvouchers/edit', $data);
//                return;
//            }
//            else
//            {
//
//                if($this->input->post('vouchertype', TRUE)=="6")
//                {
//                    $prjdata=$this->ac_projects_model->get_project_by_refid($payeecode);
//                    $recievid=(float)$prjdata->fund_release;
//                    $fund_district 	=$prjdata->fund_district ;
//                    $total=(float)$fund_district+(float)$this->input->post('amount', TRUE);
//                    /*if($total > $recievid)
//                    {
//                        $this->messages->add('Requested Amount is higher than the vote balance', 'error');
//                        $this->template->load('template', 'paymentvouchers/edit', $data);
//                        return;
//                    }*/
//                }
//                $refnumber = $this->input->post('refnumber', TRUE);
//                $payeecode = $payeecode;
//                $payeename=$payeename;
//                $applymonth=$this->input->post('applymonth', TRUE);
//                $vouchertype = $this->input->post('vouchertype', TRUE);
//                $paymentdes = $this->input->post('paymentdes', TRUE);
//                $amount = $this->input->post('amount', TRUE);
//                $data_date=$this->input->post('entry_date', TRUE);
//                //	echo  $this->input->post('vouchertype', TRUE);
//                $this->db->trans_start();
//                $insert_data1 = array(
//                    'refnumber' => $refnumber,
//                    'applymonth'=>$applymonth,
//                    'payeecode' => $payeecode,
//                    'payeename' => $payeename,
//                    'vouchertype' => $vouchertype,
//                    'paymentdes' => $paymentdes,
//                    'amount' => $amount,
//                    //	'applydate' => date_php_to_mysql($data_date),
//                    'status' =>'PENDING',
//
//                );
//                $this->db->delete('project_subpayments', array('document_refno' => $id));
//                if($this->input->post('subprojectid', TRUE)!="")
//                {
//
//
//                    $insert_data2 = array(
//                        'subprjid'=>$this->input->post('subprojectid', TRUE),
//                        'document_refno' => $id,
//                        'amount'=>$amount,
//                        'createdate' => date_php_to_mysql($data_date),
//                        'status' =>'PENDING',);
//                    $this->db->insert('project_subpayments', $insert_data2);
//                }
//                if ( ! $this->db->where('voucherid', $id)->update('ac_payvoucherdata', $insert_data1))
//                {
//                    $this->db->trans_rollback();
//                    $this->messages->add('Error Updating Payment Voucher - ' . $id . '.', 'error');
//                    $this->logger->write_message("error", "Error Updating Payment Voucher" . $id);
//                    $this->template->load('template', 'paymentvouchers', $data);
//                    return;
//                } else {
//                    $this->db->trans_complete();
//                    $this->messages->add('Edit Payment Voucher - ' . $id . '.', 'success');
//                    $this->logger->write_message("success", "Edit Payment Voucher " . $id);
//                    redirect('paymentvouchers');
//                    return;
//                }
//            }
//        }
//        else// edited by Udani 10-09-2013
//        {
//            $this->messages->add('voucher already confirmed.', 'error');
//            redirect('paymentvouchers');
//            //	return;
//        }
//        return;
//    }
//    function editsupp($id)
//    {
//        $this->template->set('page_title', 'New Payment Voucher');
//
//        /* Check access */
//        if ( ! check_access('edit vouchers'))
//        {
//            $this->messages->add('Permission denied.', 'error');
//            redirect('paymentvouchers');
//            return;
//        }
//        /* Form fields */
//        //get_supplierData
//        $payvoucher=$this->paymentvoucher_model->get_payment_voucher_byid($id);
//        if($payvoucher->status=='PENDING'){
//            //	echo print_r($payvoucher);
//            if ($payvoucher==false)
//            {
//                $this->messages->add('Invalid Payment Voucher.....', 'error');
//                //	echo $id;
//                redirect('paymentvouchers');
//                return;
//            }
//
//            //$suplier=$this->paymentvoucher_model->get_supplierData();
//            $data['id']=$id;
//            $data['suplier']=$payvoucher->payeename;
//            $data['supid']=$payvoucher->payeecode;
//            $data['amount'] = array(
//                'name' => 'amount',
//                'id' => 'amount',
//                'readonly'=>'readonly',
//                'maxlength' => '100',
//                'size' => '20',
//                'value' => $payvoucher->amount,
//            );
//            $data['entry_date'] = array(
//                'name' => 'entry_date',
//                'id' => 'entry_date',
//                'readonly'=>'readonly',
//                'maxlength' => '11',
//                'size' => '11',
//                'value' => date_today_php(),
//            );
//            $data['paymentdes'] = array(
//                'name' => 'paymentdes',
//                'id' => 'paymentdes',
//                'rows' => '4',
//                'cols' => '60',
//                'value' => $payvoucher->paymentdes,
//            );
//            $data['invoicelist']=$this->paymentvoucher_model->get_notpaid_invoicelist($payvoucher->payeecode);
//            $data['selectedlist']=$payvoucher->refnumber;
//
//            $this->form_validation->set_rules('paymentdes', 'Payment Description', 'trim');
//            $this->form_validation->set_rules('amount', 'Amount', 'trim|currency|required');
//
//            /* Re-populating form */
//            if ($_POST)
//            {
//                $invoceilist="";
//                for($i=1; $i<=$rowmatcount; $i++)
//                {
//                    if($this->input->post('isselect'.$i)=="Yes")
//                    {
//                        $invoceilist=$this->input->post('invoicenumber'.$i).",".$invoceilist;
//                    }
//                }
//                $data['selectedlist']=$invoceilist;
//                $data['paymentdes']['amount'] = $this->input->post('amount', TRUE);
//                $data['paymentdes']['value'] = $this->input->post('paymentdes', TRUE);
//                $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
//
//            }
//
//            if ($this->form_validation->run() == FALSE)
//            {
//                $this->messages->add(validation_errors(), 'error');
//                $this->template->load('template', 'paymentvouchers/editsupp', $data);
//                return;
//            }
//            else
//            {
//                $suplier=$this->paymentvoucher_model->get_supplierdata_byid($payvoucher->payeecode);
//
//                $refnumber = "";
//                $payeecode = $payvoucher->payeecode;
//                $payeename=$suplier->name;
//                $vouchertype = 3;
//                $paymentdes = $this->input->post('paymentdes', TRUE);
//                $amount = $this->input->post('amount', TRUE);
//                $data_date=$this->input->post('entry_date', TRUE);
//
//                $this->db->trans_start();
//                $rowmatcount=$this->input->post('rawmatcount', TRUE);
//                $invoceilist="";
//                for($i=1; $i<=$rowmatcount; $i++)
//                {
//                    $invoiceno=$this->input->post('invoicenumber'.$i);
//                    if($this->input->post('isselect'.$i)=="Yes")
//                    {
//                        $invoceilist=$this->input->post('invoicenumber'.$i).",".$invoceilist;
//
//                        $dataupdate=array("voucherid"=>$id,"paystatus"=>"CONFIRMED");
//                        $this->db->where('inv_no', $invoiceno)->where('supplier_id', $payvoucher->payeecode)->update('ac_invoices', $dataupdate);
//
//                    }
//                    else
//                    {
//                        $dataupdate=array("voucherid"=>'',"paystatus"=>"PENDING");
//                        $this->db->where('inv_no', $invoiceno)->where('supplier_id',$payvoucher->payeecode)->update('ac_invoices', $dataupdate);
//                    }
//                }
//
//                $insert_data1 = array(
//
//                    'refnumber' => $invoceilist,
//                    'payeecode' => $payeecode,
//                    'payeename' => $payeename,
//                    'vouchertype' => $vouchertype,
//                    'paymentdes' => $paymentdes,
//                    'amount' => $amount,
//                    //'applydate' => date_php_to_mysql($data_date),
//                    'status' =>'PENDING',
//
//                );
//                if ( ! $this->db->where('voucherid',$id)->update('ac_payvoucherdata', $insert_data1))
//                {
//                    $this->db->trans_rollback();
//                    $this->messages->add('Error addding Payment Voucher - ' . $id . '.', 'error');
//                    $this->logger->write_message("error", "Error adding Payment Voucher " . $id);
//                    $this->template->load('template', 'paymentvouchers', $data);
//                    return;
//                } else {
//                    $this->db->trans_complete();
//                    $this->messages->add('Added Payment Voucher  - ' . $id . '.', 'success');
//                    $this->logger->write_message("success", "Added ayment Voucher " . $id);
//                    $voucherid = $this->db->insert_id();
//                    redirect('paymentvouchers');
//                }
//
//
//
//            }
//        }
//        else
//        {
//            $this->messages->add('voucher already confirmed.', 'error');
//            redirect('paymentvouchers');
//            return;
//        }
//        return;
//    }
    function delete($id)
    {
       // $id=$this->input->post('id');

        /* Check access */
        if ( ! check_access('delete vouchers'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/paymentvouchers/index');
            return;
        }
        /* Checking for valid data */

        $data['id']=$id;

        if ($id == "")
        {

			redirect('accounts/paymentvouchers/index');

        }
        $this->db->trans_start();
        $payvoucher=$this->paymentvoucher_model->get_payment_voucher_byid($id);

      // print_r($payvoucher);

	    if($payvoucher->status=='PENDING')
        {
			$suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
          		
            if ( ! $this->db->where('voucherid',$id)->update('ac_payvoucherdata',$suparray ))
            {
                $this->db->trans_rollback();

                if($data){
                   // echo 'Error Deleting Payment Voucher'.$id;
				   redirect('accounts/paymentvouchers/index');
                }
            } else {
                $this->db->trans_complete();
                $this->common_model->delete_notification('ac_payvoucherdata',$id);
                $this->messages->add('Delete Payment Voucher - ' . $id . '.', 'success');
                $this->logger->write_message("success", "Deletes Payment Voucher " . $id);
                if($data){
                    //echo 'Delete Payment Voucher' . $id . 'success';
					 $this->session->set_flashdata('tab', 'voucher');
				redirect('accounts/payments/index');
                }
            }
        }
        else if($payvoucher->status=='CONFIRMED')
        {

			if ( ! check_access('delete_vouchers_confirm'))
       		 {
            $this->messages->add('Permission denied.', 'error');
        	   redirect('accounts/payments/showpaymententry_approve');
            return;
        	}
            $suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
          		
            if ( ! $this->db->where('voucherid',$id)->update('ac_payvoucherdata',$suparray ))
            {
             
                $this->db->trans_rollback();
                $this->messages->add('Error Deleting Payment Voucher - ' . $id . '.', 'error');
                $this->logger->write_message("error", "Error Updating Payment Voucher" . $id);
                if($data){
                  //  echo 'Error Deleting Payment Voucher' . $id;
					redirect('accounts/payments/showpaymententry_approve');
                }
            } else {

				$this->db->where('voucher_id',$id);
					$query = $this->db->delete('re_arreaspayment');

                $this->db->trans_complete();
                $this->common_model->delete_notification('ac_payvoucherdata',$id);
                $this->messages->add('Delete Payment Voucher - ' . $id . '.', 'success');
                $this->logger->write_message("success", "Deletes Payment Voucher " . $id);
                if($data){
                    //echo 'Delete Payment Voucher - ' . $id .  'success';
					 $this->session->set_flashdata('tab', 'voucher');
						redirect('accounts/payments/showpaymententry_approve');

                }
            }
        }
        else {
            $this->messages->add('voucher already confirmed.', 'error');
            if($data){
              //  echo 'Voucher already confirmed';
				redirect('accounts/paymentvouchers/index');
            }
        }
    }
    function confirm($id)
    {
       // $id=$this->input->post('id');


        /* Check access */
        if ( ! check_access('confirm vouchers'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/paymentvouchers/index');
            return;
        }
        /* Checking for valid data */

        $data['id']=$id;
        //	$id = (int)$id;
        if ($id == "")
        {
            if($data){
				redirect('accounts/paymentvouchers/index');
              //  echo 'error';
            }
        }
        $CI =& get_instance();
        $this->db->trans_start();
        $payvoucher=$this->paymentvoucher_model->get_payment_voucher_byid($id);
        $dataupdate=array("confirmdate"=>date("Y-m-d"),"confirmby"=>$CI->session->userdata('user_name'),"status"=>"CONFIRMED");



        if ( ! $this->db->where('voucherid', $id)->update('ac_payvoucherdata', $dataupdate))
        {
            $this->db->trans_rollback();
            $this->messages->add('Error Confirming Payment Voucher - ' . $id . '.', 'error');
            $this->logger->write_message("error", "Error Confirming Payment Voucher" . $id);

            if($data){
				redirect('accounts/paymentvouchers/index');
               // echo 'Error Confirming Payment Voucher'.$id;
            }
        } else {

            $this->db->trans_complete();
            $this->common_model->delete_notification('ac_payvoucherdata',$id);
            $this->messages->add('Confirmed Payment Voucher - ' . $id . '.', 'success');
            $this->logger->write_message("success", "Confirmed Payment Voucher " . $id);
            if($data){
				   $this->session->set_flashdata('msg', 'payment Voucher Successfully Confirmed.');
				    $this->session->set_flashdata('tab', 'voucher');
				redirect('accounts/payments/index');
                //echo 'Confirmed Payment Voucher - ' . $id . 'success';
            }
        }
    }

    public function edit()
    {
        $data=NULL;
        //$id = $this->input->get('id');
        if ( ! check_access('add voucher'))
        {
            //redirect('accounts/paymentvouchers/index');
            return false;
        }
        //$data['details']=$this->branch_model->get_branchdata_bycode($this->uri->segment(4));
        $employee=$this->paymentvoucher_model->get_employeedata();
        $data['employee']=$employee;
        $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
        $data['vouchertypes']=$vouchertypes;
        $data['details']=$this->paymentvoucher_model->get_payment_voucher_byid($this->uri->segment(4));
		$data['branchlist']=$this->branch_model->get_all_branches_summery();
        $this->common_model->add_activeflag('ac_payvoucherdata',$this->uri->segment(4),'voucherid');
        $session = array('activtable'=>'ac_payvoucherdata');
        $this->session->set_userdata($session);

        $this->load->view('accounts/paymentvouchers/edit',$data);
    }

    function editdata()
    {
        if ( ! check_access('add voucher'))
        {

            redirect('accounts/payments/index');
            return;
        }
        $id=$this->paymentvoucher_model->edit();


        $this->session->set_flashdata('msg', 'Payment Voucher Successfully Updated ');
        $this->common_model->delete_activflag('ac_payvoucherdata',$this->input->post('voucherid'),'voucherid');
        $this->logger->write_message("success", $this->input->post('voucherid').'Payment Voucher successfully Updated');
        redirect('accounts/payments/');

    }

    function printQueue()
    {
        $entry_type='payment';
        $data['tag_id'] = 0;
        $entry_type_id = 0;


        $entry_type_id = entry_type_name_to_id($entry_type);
        $entry_q = NULL;

        /* Pagination setup */
        $this->load->library('pagination');

        //if ($entry_type == "tag")
           // $page_count = (int)$this->uri->segment(5);
        //else
           // $page_count = (int)$this->uri->segment(4);

        //$page_count = $this->input->xss_clean($page_count);
        //if ( ! $page_count)
            $page_count = "0";

        /* Pagination configuration */

        $pagination_counter =$this->config->item('row_count');
        $config['num_links'] = 100;
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

        if ($entry_type_id > 0) {
            $this->db->select('*, SUM(amount) as amount')->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->where('printflag', 'NO')->group_by('entryid')->order_by('voucherid','DESC');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->group_by('entryid')->order_by('voucherid','DESC')->get()->num_rows();
        }

        //$this->pagination->initialize($config);
        $data['entry_data'] = $entry_q;

        //$this->template->load('template', 'paymentvouchers/printqueue', $data);
        $this->load->view('accounts/paymentvouchers/printqueue', $data);
        return;

    }

//    function reprintqueue()
//    {
//        $this->load->model('Tag_model');
//        $entry_type='payment';
//        $data['tag_id'] = 0;
//        $entry_type_id = 0;
//
//
//        $entry_type_id = entry_type_name_to_id($entry_type);
//        $entry_q = NULL;
//        $this->template->set('page_title', 'Payment Voucher Print Queue');
//        /* Pagination setup */
//        $this->load->library('pagination');
//
//        if ($entry_type == "tag")
//            $page_count = (int)$this->uri->segment(5);
//        else
//            $page_count = (int)$this->uri->segment(4);
//
//        $page_count = $this->input->xss_clean($page_count);
//        if ( ! $page_count)
//            $page_count = "0";
//
//        /* Pagination configuration */
//
//        $pagination_counter =$this->config->item('row_count');
//        $config['num_links'] = 100;
//        $config['per_page'] = $pagination_counter;
//        $config['full_tag_open'] = '<ul id="pagination-flickr">';
//        $config['full_close_open'] = '</ul>';
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
//        $config['cur_tag_open'] = '<li class="active">';
//        $config['cur_tag_close'] = '</li>';
//        $config['next_link'] = 'Next &#187;';
//        $config['next_tag_open'] = '<li class="next">';
//        $config['next_tag_close'] = '</li>';
//        $config['prev_link'] = '&#171; Previous';
//        $config['prev_tag_open'] = '<li class="previous">';
//        $config['prev_tag_close'] = '</li>';
//        $config['first_link'] = 'First';
//        $config['first_tag_open'] = '<li class="first">';
//        $config['first_tag_close'] = '</li>';
//        $config['last_link'] = 'Last';
//        $config['last_tag_open'] = '<li class="last">';
//        $config['last_tag_close'] = '</li>';
//        $month=date('m');
//        if($month=='01')
//        {
//            $lastmonth=12;
//            $year=intval(date("Y"))-1;
//        }
//        else
//        {
//            $lastmonth=intval($month)-1;
//            $year=date("Y");
//        }
//        $fromdate=$year."-".str_pad($lastmonth, 2, "0", STR_PAD_LEFT)."-01";
//
//        if ($entry_type_id > 0) {
//            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->where('printflag', 'YES')->where('date >=', $fromdate)->order_by('voucherid','DESC');
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get();
//            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->order_by('voucherid','DESC')->get()->num_rows();
//        }
//        $this->pagination->initialize($config);
//        $data['entry_data'] = $entry_q;
//
//        $this->template->load('template', 'paymentvouchers/reprintqueue', $data);
//        return;
//
//    }
//
//
//    function reprintlist()
//    {
//        $this->load->model('Tag_model');
//        $month=date('m');
//        if($month=='01')
//        {
//            $lastmonth=12;
//            $year=intval(date("Y"))-1;
//        }
//        else
//        {
//            $lastmonth=intval($month)-1;
//            $year=date("Y");
//        }
//        $fromdate=$year."-".str_pad($lastmonth, 2, "0", STR_PAD_LEFT)."-01";
//        $fromdate="2014-06-10";
//
//        $schqno=$this->input->post('stsearch');
//        $chqno=$this->input->post('search');
//        $entry_type='payment';
//        $this->template->set('page_title', 'Cheque Print');
//        $entry_type_id = entry_type_name_to_id($entry_type);
//
//        if ($entry_type_id > 0) {
//            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->where('printflag', 'YES')->where('CHQNO >=',$schqno)->where('CHQNO <=',$chqno)->order_by('voucherid','DESC');
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get();
//        }
//
//        $data['entry_data'] = $entry_q->result();
//
//        $this->load->view('paymentvouchers/printlist', $data);
//        return;
//
//    }
    function printlist()
    {
        $data['tag_id'] = 0;
        $entry_type_id = 0;
        $entry_type='payment';
        //$this->template->set('page_title', 'Cheque Print');
        $entry_type_id = entry_type_name_to_id($entry_type);

        if ($entry_type_id > 0) {
            $this->db->select('*, SUM(amount) as amount')->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->where('printflag', 'NO')->group_by('entryid')->order_by('voucherid','DESC');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
        }

        $data['entry_data'] = $entry_q->result();

        $this->load->view('accounts/paymentvouchers/printlist', $data);
        return;

    }

//    function reprint($id)
//    {
//        $this->load->model('Tag_model');
//
//        $data['tag_id'] = 0;
//        $entry_type_id = 0;
//        $entry_type='payment';
//        $this->template->set('page_title', 'Voucher Print');
//        $entry_type_id = entry_type_name_to_id($entry_type);
//
//        if ($entry_type_id > 0) {
//            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('voucherid', $id)->order_by('voucherid','DESC');
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get();
//        }
//
//        $data['entry_data'] = $entry_q->result();
//
//        $this->load->view('paymentvouchers/reprint', $data);
//        return;
//
//    }
	function printone($id){

		$data['tag_id'] = 0;
		$entry_type_id = 0;
       	$entry_type = 'payment';
        $entry_type_id = 2;

       	if($entry_type_id > 0){
        	$this->db->select('*, SUM(amount) as amount')->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('entryid', $id)->group_by('entryid')->order_by('voucherid','DESC');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
        }
		$dataset=$entry_q->row();
		$ledger_id_for_bank_code = $this->common_model->get_entry_bank_account($id);
		$bank_code =$this->common_model->get_account_bank_code($ledger_id_for_bank_code);
		
		$bank_data=$this->common_model->get_account_bankdata($ledger_id_for_bank_code);
		//voucher new code generate funtion
		if($dataset->voucher_ncode)
		{
			$voucher_ncode=$dataset->voucher_ncode;
		}
		else{
			
			if($bank_data)
			{
				$shortcode=$this->common_model->getbank_short_code($bank_data->bank_code);
				$voucher_ncode=$shortcode.$bank_data->prefix_sequance.'-'.$bank_data->next_number;
				$nextcode=$bank_data->next_number+1;
				$this->common_model->update_nextvoucher_number($ledger_id_for_bank_code,$nextcode);
			}
		}
		
		
		if($bank_code!='')
		$data['bank_name'] = $this->common_model->getbank_details($bank_code);
		else
		$data['bank_name']=$this->Ledger_model->get_entry_name($id, '2');

        $data['entry_data'] = $entry_q->result();
		
		  $data['id'] = $id;
		 $data['voucher_ncode'] = $voucher_ncode;
		$this->updateprintone($id,$voucher_ncode);
        $this->load->view('accounts/paymentvouchers/printone', $data);
        return;
   }

    function updateprintlist()
    {
        $reciptdata=array (
            'printflag'=>"YES",
			
        );
        if ( ! $this->db->where('printflag', "NO")->where('status', "PAID")->update('ac_payvoucherdata', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            //$this->logger->write_message("error", "Error updating Reciept Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            return;
        }
        $this->db->trans_complete();
        $this->session->set_flashdata('msg', 'Payment Voucher Queue Printed Successfuly');
        //$this->messages->add('Payment Voucher Queue Printed Successfuly', 'success');
        $this->logger->write_message("success", "Payment Voucher Queue Printed Successfuly");
        redirect('accounts/paymentvouchers/printQueue/');


    }

    function updateprintone($id,$voucher_ncode)
    {
        $reciptdata=array (
            'printflag'=>"YES",
			'voucher_ncode'=>$voucher_ncode
        );
        if ( ! $this->db->where('entryid', $id)->update('ac_payvoucherdata', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            //$this->logger->write_message("error", "Error updating Reciept Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            return;
        }
        $this->db->trans_complete();
        $this->session->set_flashdata('msg', 'Payment Voucher '.$id.' Printed Successfuly');
        //$this->messages->add('Payment Voucher '.$id.' Printed Successfuly', 'success');
        $this->logger->write_message("success", "Payment Voucher Queue Printed Successfuly");
      //  redirect('accounts/paymentvouchers/printQueue/');
//

    }
//    function preview($id)
//    {
//        $this->load->model('Tag_model');
//
//        $data['tag_id'] = 0;
//        $entry_type_id = 0;
//        $entry_type='payment';
//        //$this->template->set('page_title', 'Cheque Print');
//        $entry_type_id = entry_type_name_to_id($entry_type);
//
//        if ($entry_type_id > 0) {
//            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->where('voucherid', $id)->order_by('voucherid','DESC');
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get();
//        }
//
//        $data['entry_data'] = $entry_q->result();
//        $data['id']=$id;
//        $this->load->view('accounts/paymentvouchers/view', $data);
//        return;
//
//    }
//
    function search()
    {


        $empsearch=$this->input->post('empsearch');
        $amountsearch=$this->input->post('amountsearch');
        $search=$this->input->post('search');

        $branchid = $this->session->userdata('branchid');




        $data['employee']=$this->paymentvoucher_model->get_employeedata();
        if ($search != "") {

            $this->db->from('ac_payvoucherdata')
                ->where('voucherid', $search)
                ->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')
                ->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid','left')
                ->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            //$entry_q = $this->db->get()->result();

           // $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('ac_payvoucherdata.voucherid', $search)->get()->num_rows();
            $data['ac_projects']=$entry_q = $this->db->get()->result();

            $data['searchtype']='number';
            $data['search']=$search=$this->input->post('search');
            $this->load->view('accounts/paymentvouchers/search',$data);

//                        var_dump($data['search']);
//            die();
        }
       else if ($empsearch!= "") {

            $this->db->from('ac_payvoucherdata')
                ->where('branch_code',$branchid)
                ->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')
                ->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid','left')
                ->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left'	)->where('payeename', $empsearch);

            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $data['ac_projects']=$entry_q = $this->db->get()->result();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->order_by('voucherid','DESC')->get()->num_rows();
           $data['ac_projects']=$entry_q;
            $data['searchtype']='emp';
            $data['search']=$search=$this->input->post('empsearch');
            $this->load->view('accounts/paymentvouchers/search',$data);
            //$ac_projects = $data['ac_projects'];



        }
        else if ($amountsearch != "") {
            $amountsearch=number_format($amountsearch, 2, '.', '');
            // echo $amountsearch;
            $this->db->from('ac_payvoucherdata')
                ->where('branch_code',$branchid)
                ->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')
                ->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid','left')
                ->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left'	)->where('ac_payvoucherdata.amount', $amountsearch);

            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get()->result();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->order_by('voucherid','DESC')->get()->num_rows();
            $data['ac_projects']=$entry_q;
            $data['searchtype']='amount';
            $data['search']=$search=$this->input->post('amountsearch');
            $this->load->view('accounts/paymentvouchers/search',$data);


        }
        else
        {
            $this->session->set_flashdata('error', 'Search string could not be blank');
            redirect('accounts/paymentvouchers');
            return;
           //redirect('accounts/paymentvouchers');
        }




    }
//    function print_search($searchtype,$search)
//    {
//
//        $data['employee']=$this->paymentvoucher_model->get_employeedata();
//        if ($searchtype == "number") {
//            $this->db->from('ac_payvoucherdata')->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid','left')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left'	)->like('voucherid', $search);
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get()->result();
//            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->order_by('voucherid','DESC')->get()->num_rows();
//            $data['ac_projects']=$entry_q;
//            $data['searchtype']='number';
//            $data['search']=$search=$this->input->post('search');
//            $this->load->view('paymentvouchers/print_search', $data);
//            //$this->template->load('template', 'paymentvouchers/search_print', $data);
//            return;
//        }
//        if ($searchtype == "emp") {
//            $this->db->from('ac_payvoucherdata')
//                ->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')
//                ->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid','left')
//                ->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left'	)->where('payeename', $search);
//
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get()->result();
//            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->order_by('voucherid','DESC')->get()->num_rows();
//            $data['ac_projects']=$entry_q;
//            $data['searchtype']='emp';
//            $data['search']=$search=$this->input->post('empsearch');
//            $this->load->view('paymentvouchers/print_search', $data);
//            return;
//        }
//        if ($searchtype == "amount") {
//            // echo $amountsearch;
//            $this->db->from('ac_payvoucherdata')
//                ->join('ac_payvoucher_type','ac_payvoucher_type.typeid=ac_payvoucherdata.vouchertype')
//                ->join('ac_entries','ac_entries.id=ac_payvoucherdata.entryid','left')
//                ->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left'	)->where('ac_payvoucherdata.amount', $search);
//
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get()->result();
//            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('CHQSTATUS', 'PRINT')->order_by('voucherid','DESC')->get()->num_rows();
//            $data['ac_projects']=$entry_q;
//            $data['searchtype']='amount';
//            $data['search']=$search=$this->input->post('empsearch');
//            $this->load->view('paymentvouchers/print_search', $data);
//            return;
//        }
//        else
//        {
//            redirect('paymentvouchers');
//        }
//
//
//
//
//    }
//    function updateid()
//    {
//        $this->db->from('ac_payvoucherdata')->where('applydate >=', '2014-04-01')->order_by('voucherid');
//        //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//        $entry_q = $this->db->get()->result();
//        $count=0;
//        foreach($entry_q  as $row)
//        { $count++;
//            $prifix="PV1404"."-";
//            $newid=$prifix.str_pad($count, 5, "0", STR_PAD_LEFT);
//            $dataupdate=array("voucherid"=>$newid);
//            $this->db->where('voucherid', $row->voucherid)->update('ac_payvoucherdata', $dataupdate);
//        }
//
//
//        $data['ac_projects']=$entry_q;
//        $this->template->load('template', 'paymentvouchers/search', $data);
//        return;
//
//
//
//
//
//
//    }
//2020_03_11 update by nadee
function searchReprint()
{
  $this->db->select('ac_entries.*, SUM(ac_payvoucherdata.amount) as amount,ac_chqprint.CHQNO,ac_chqprint.CHQSTATUS,ac_payvoucherdata.entryid');
  $this->db->from('ac_entries');
  $this->db->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id');
  $this->db->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid');
  $this->db->where('ac_entries.entry_type', '2');
  $this->db->where('ac_chqprint.CHQSTATUS', 'PRINT');
  $this->db->where('ac_payvoucherdata.printflag', 'YES');
  $this->db->where('ac_chqprint.CHQNO', $this->input->post('string'));
  $this->db->or_where('ac_entries.date', $this->input->post('string'));
  $this->db->or_where('ac_payvoucherdata.voucherid', $this->input->post('string'));
  $this->db->group_by('ac_payvoucherdata.entryid');
  $this->db->order_by('ac_payvoucherdata.voucherid','DESC');
  $this->db->limit(30,0);
  $entry_rq = $this->db->get();

  if ($entry_rq->num_rows >0) {
          $data = $entry_rq->result();

    echo '<table border=0 cellpadding=5 class="table">
      <thead>
      <tr>
      <th>Date</th>
      <th>Ledger Account</th>
      <th>Cheque No</th>
      <th>Cheque Status</th>
      <th>Voucher Amount</th>
      <th></th>
      </tr>
      </thead>
      <tbody>';
    $c = 0;
    foreach ($data as $row){
      $current_entry_type = entry_type_info($row->entry_type);
      echo "<tr>";

      echo "<td>" . date('Y-m-d',strtotime($row->date)) . "</td>";

      echo "<td>";
      echo $this->Tag_model->show_entry_tag($row->tag_id);
      echo $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
      echo "</td>";

      echo "<td>". $row->CHQNO."</td>";
      echo "<td>" . $row->CHQSTATUS . "</td>";
      echo "<td>" . number_format($row->amount, 2, '.', ','). "</td>";

      echo"<td>";
      echo "" . anchor('accounts/paymentvouchers/printone/'. $row->entryid , img(array('src' => asset_url() . "images/icons/print.png", 'border' => '0', 'alt' => 'Re Print ' . $current_entry_type['name'] . ' Entry')), array('title' => 'rint  Voucher ' . $row->entryid, 'target' => '_blank')) . "</td> ";


      echo "</tr>";

    }

    echo '</tbody>
    </table>';

  }else{
    echo '<table border=0 cellpadding=5 class="simple-table">
      <thead>
      <tr>
      <th>Date</th>
      <th>Ledger Account</th>
      <th>Cheque No</th>
      <th>Cheque Status</th>
      <th>Voucher Amount</th>
      <th></th>
      </tr>
      </thead>
      <tbody>';
    echo "<tr>";
    echo "<td colspan='6'>Nothing Found!</td>";
    echo '</tbody>
    </table>';
  }


}//2020_03_11 update by nadee end
}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */
