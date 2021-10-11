<?php
// file use for create edit ac_projects
class mobilepay extends CI_Controller {

    function mobilepay()
    {
        parent::__construct();
        $this->load->model('paymentvoucher_model');
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('ac_projects_model');
        $this->load->model('cheque_model');
        $this->load->model('budgeting_model');
        $this->load->model('reciept_model');
		 $this->load->model('common_model');
		  $this->load->model('eploan_model');
		  $this->load->model('reservation_model');
		   $this->load->model('lotdata_model');
		    $this->load->model('mobilepay_model');
	$this->is_logged_in();



    }
    function index()
    {
        $data=NULL;
        if ( ! check_access('add_advance'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
        //$data['searchpath']='';

        /* Calculating difference in Opening Balance */
        //$ac_projects = $this->paymentvoucher_model->get_pending_payment_vouchers($this->session->userdata('branchid'));
        $ac_incomes = $this->mobilepay_model->get_pending_incomes();
		$datalist=NULL;
        if (!$ac_incomes)
        {
            $this->session->set_flashdata('error', 'No Data');
        }
		$data['prjlist']=$this->Entry_model->get_all_project_confirmed($this->session->userdata('branchid'));
        $data['ac_incomes'] = $ac_incomes;
        
        $this->load->view('accounts/mobilepay/index',$data);
        return;
    }


function advancepay($tid)
{
	
	$paymentdata=$this->mobilepay_model->get_mobilepaydata_id($tid);
	if($paymentdata){
	$id=$this->mobilepay_model->add_advance($paymentdata->amt,$paymentdata->loanId);
	
		$this->mobilepay_model->update_mobile_pay($tid,$id);
		
		$this->session->set_flashdata('msg', 'Advance payment successfully Inserted ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		//redirect("re/reservation/showall/");
		redirect("accounts/income/add/".$id);
	}
	else
	{
		$this->session->set_flashdata('error', 'Invalid payment');
		redirect("accounts/mobilepay/");
	}
	
}
function rentalpay($tid)
{
	
	$paymentdata=$this->mobilepay_model->get_mobilepaydata_id($tid);
	if($paymentdata){
		$this->mobilepay_model->update_mobile_pay($tid,'');
			$data['mobdetails']= $this->mobilepay_model->get_project_payment_data_by_code($paymentdata->loanId);
		$data['loan_code']=$loancode=$paymentdata->loanId;
		$mydate=date('Y-m-d',$paymentdata->timestmp);
		$data['paydate']=$paydate=$mydate;
		$data['amount']=$amount=$paymentdata->amt;
		$data['details']=$loan_data=$this->eploan_model->get_eploan_data($loancode);
		$data['dataset']=$this->eploan_model->get_repayment_shedeule($loancode);
		$data['totset']=$this->eploan_model->get_paid_totals($loancode);
		$data['ariastot']=$this->eploan_model->get_arrias_instalments($loancode,$paydate);
		$data['totint']=$this->eploan_model->get_int_total($loancode);
		$data['currentins']=$this->eploan_model->get_current_instalment($loancode);
		$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);
		if($loan_data->loan_type!='EPB')
		$this->load->view('accounts/mobilepay/rentaldata',$data);
		else
		{
			$data['paylist']=$this->eploan_model->get_paid_list_epb($loancode);
			$data['dipayment']=$this->eploan_model->get_thismonth_payment_di($loancode);
			$this->load->view('accounts/mobilepay/rentaldata_epb',$data);
		}
	}
	else
	{
		$this->session->set_flashdata('error', 'Invalid payment');
		redirect("accounts/mobilepay/");
	}
	
}
function get_fulldata_project($id)
{$data['ac_incomes2']=NULL;
	$data['ac_incomes']=$this->Entry_model->get_pending_incomes_by_project($id);
	//echo $id;
	$this->load->view('accounts/income/fulldata',$data);
}
function get_fulldata()
{$data['ac_incomes2']=NULL;
	$data['ac_incomes']=$this->Entry_model->get_pending_incomes($this->session->userdata('branchid'));
	$this->load->view('accounts/income/fulldata',$data);
}
    function add($entry_id)
    {


        if ( ! check_access('edit paymententry'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/income');
            return;
        }
        $entry_type='receipt';
        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/income');
            return;
        }
        $data['entry_id']=$entry_id;
        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);

        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/income');
            return;
        }
        else
        {
            $current_entry_type = entry_type_info($entry_type_id);

        }

        $isstart=$this->reciept_model->get_start_recipt_bundle($this->session->userdata('branchid'));
        
        if($isstart)
        {$bookid=$isstart->RCTBID;
            $recieptid=$this->reciept_model->is_max_reciept_id($isstart->RCTBID);
			//echo   $recieptid->RCTNO;
            if($recieptid->RCTNO!=0)
                $nextid=intval($recieptid->RCTNO)+1;
            else
                $nextid=$isstart->RCTBSNO;
            $nextid=str_pad($nextid, 7, "0", STR_PAD_LEFT);
			//echo  $nextid;
        }
        else{
			$bookid=0;
            //$this->messages->add('Reciept Boundle Not Assigned.', 'error');
            $this->session->set_flashdata('error', 'Reciept Boundle Not Assigned.');
            redirect('accounts/income/');
            return;
        }
//        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
//        {
//            $this->session->set_flashdata('error', 'Invalid Entry.');
//            redirect('accounts/income');
//            return;
//        }
        //$cheque_entry = $this->paymentvoucher_model->get_chequedata_by_entryid($entry_id);
        $data['income_entry'] = $this->paymentvoucher_model->get_incomedata_by_entryid($entry_id);


        /*	$this->messages->add('Invalid Entry.', 'error');
            redirect('entrymaster/show/' . $current_entry_type['label']);
            return;*/

        //$this->template->set('page_title', 'New ' . $current_entry_type['name'] . ' Entry');

        $data['payment_mode']="CSH";

        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        //$datalist=$this->paymentvoucher_model->get_paymentvouchres_by_entryid($entry_id);
        $datalist=$this->paymentvoucher_model->get_incomes_by_entryid($entry_id);
        $cur_entry=$this->paymentvoucher_model->get_incomesByEntryid($entry_id);

        $chequename="";
        $count=0;
        foreach($datalist as $row)//get selected voucher list
        {$count++;

            $voucherlist[$count]['voucherid']=$row->id;
            $voucherlist[$count]['refnumber']=$row->temp_code;
            $voucherlist[$count]['payeename']=$row->income_type;
            $voucherlist[$count]['invoiceamount']=$row->amount;
          //  $data['payment_mode']=$row->income_type;
            //$chequename=$row->payeename;
          //  $nextid=$row->id;
        }
        //if($cheque_entry) $chequename=$cheque_entry->CHQNAME;
        //$nextid=$cur_entry->number;

        $data['count']=$count;
		$data['banklist']=$this->common_model->getbanklist();
        $data['voucherlist']=$voucherlist;
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'maxlength' => '11',
            'readonly'=>'readonly',
            'size' => '11',
            'value' =>'',
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date('Y-m-d'),
        );
        $data['entry_narration'] = array(
            'name' => 'entry_narration',
            'id' => 'entry_narration',
            'cols' => '50',
            'rows' => '4',
            'value' => $cur_entry->income_type,
        );
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => $cur_entry->amount,
        );

        $data['chequename'] = array(
            'name' => 'chequename',
            'id' => 'chequename',
            'maxlength' => '100',
            'size' => '50',
            'value' => $cur_entry->first_name.' '.$cur_entry->last_name,
        );
		   $data['cheque_date'] = array(
            'name' => 'cheque_date',
            'id' => 'cheque_date',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date_today_php(),
        );
        $data['cheque_no'] = array(
            'name' => 'cheque_no',
            'id' => 'cheque_no',
            'maxlength' => '11',
            'size' => '11',
            'value' => '',
           
        );
        $data['bank_name'] = array(
            'name' => 'bank_name',
            'id' => 'bank_name',
            'maxlength' => '11',
            'size' => '11',
            'value' => '',
            
        );
        $data['branch_name'] = array(
            'name' => 'branch_name',
            'id' => 'bank_name',
            'maxlength' => '11',
            'size' => '11',
            'value' => '',
        );
        /* Form validations */
//        $this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//        $this->form_validation->set_rules('payment_mode', 'Entry Date', 'trim|required');
//        $this->form_validation->set_rules('chequename', 'Cheque Drawn name', 'trim|required');
//        $this->form_validation->set_rules('entry_narration', 'trim|required');
//        $this->form_validation->set_rules('amount', 'Cheque Amount', 'trim|currency');

        /* Debit and Credit amount validation */
        if ($_POST)
        {
            foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
            {
//                $this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
//                $this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
            }

        }
        if ( ! $_POST)
        {
            //$this->db->from('ac_entry_items')->where('entry_id', $entry_id);
            $this->db->from('re_incomentires')->where('income_id', $entry_id)->order_by('dc_type','desc');
            $cur_ac_ledgers_q = $this->db->get();
            if ($cur_ac_ledgers_q->num_rows <= 0)
            {
                //$this->messages->add('No Ledger accounts found!', 'error');
                $this->session->set_flashdata('error', 'No Ledger accounts found!');
            }
            $counter = 0;
            foreach ($cur_ac_ledgers_q->result() as $row)
            {


                $data['ledger_dc'][$counter] = $row->dc_type;
                $data['ledger_id'][$counter] = $row->ledger_id;
                if ($row->dc_type == "D")
                {
                    $data['dr_amount'][$counter] = $row->amount;

                    $data['cr_amount'][$counter] = "";
                } else {
                    $data['dr_amount'][$counter] = "";
                    $data['cr_amount'][$counter] = $row->amount;
                }
//                if ($row->reconciliation_date)
//                    $data['has_reconciliation'] = TRUE;
                $counter++;

            }
            /* Two extra rows */
         
        }

        /* Repopulating form */
        if ($_POST)
        {

            $data['entry_number']['value'] = $this->input->post('entry_number', TRUE);
            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
            $data['entry_narration']['value'] = $this->input->post('entry_narration', TRUE);
            $data['amount']['value'] = $amount=$this->input->post('amount', TRUE);
            $data['payment_mode']=$payment_mode=$this->input->post('payment_mode', TRUE);
            $data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
            $data['ledger_id'] = $this->input->post('ledger_id', TRUE);
            $data['dr_amount'] = $this->input->post('dr_amount', TRUE);
            $data['cr_amount'] = $this->input->post('cr_amount', TRUE);
            $data['chequename']['value']=$this->input->post('chequename', TRUE);
        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            //$this->messages->add(validation_errors(), 'error');
//            $this->session->set_flashdata('error', 'Invalid Entry.');
//            //$this->template->load('template', 'payments/edit', $data);
//            $this->load->view('accounts/payments/edit',$data);
//            return;
//        }
//        else
//        {
        /* Checking for Valid ac_ledgers account and Debit and Credit Total */
        $data_all_ledger_id = $this->input->post('ledger_id', TRUE);
        $data_all_ledger_dc = $this->input->post('ledger_dc', TRUE);
        $data_all_dr_amount = $this->input->post('dr_amount', TRUE);
        $data_all_cr_amount = $this->input->post('cr_amount', TRUE);
        $dr_total = 0;
        $cr_total = 0;
        $bank_cash_present = FALSE; /* Whether atleast one Ledger account is Bank or Cash account */
        $non_bank_cash_present = FALSE;  /* Whether atleast one Ledger account is NOT a Bank or Cash account */

        if($data_all_ledger_dc) {


            foreach ($data_all_ledger_dc as $id => $ledger_data) {

                if ($data_all_ledger_id[$id] == "0") // modaification done by udani . Reasone : allow string ladger ids
                    continue;

                /* Check for valid ledger id */
                $this->db->from('ac_ledgers')->where('id', $data_all_ledger_id[$id]);
                $valid_ledger_q = $this->db->get();
                //echo "ss";
                if ($valid_ledger_q->num_rows() < 1) {

                    //$this->messages->add('Invalid Ledger account.', 'error');
                    $this->session->set_flashdata('error', 'Invalid Ledger account.');
                    //$this->template->load('template', 'payments/edit', $data);
                    $this->load->view('accounts/income/add', $data);
                    return;
                } else {
                    /* Check for valid ledger type */
                    $valid_ledger = $valid_ledger_q->row();

//                    if ($data_all_ledger_dc[$id] == 'D' && $valid_ledger->type == 1) {
//
//                        $bank_cash_present = TRUE;
//                    }
//                    if ($valid_ledger->type != 1)
//                        $non_bank_cash_present = TRUE;

                    if ($current_entry_type['bank_cash_ledger_restriction'] == '2') {
                        if ($data_all_ledger_dc[$id] == 'D' && $valid_ledger->type == 1) {
                            $bank_cash_present = TRUE;

                        }
                        if ($valid_ledger->type != 1)
                            $non_bank_cash_present = TRUE;
                    } else if ($current_entry_type['bank_cash_ledger_restriction'] == '3') {
                        if ($data_all_ledger_dc[$id] == 'C' && $valid_ledger->type == 1) {
                            $bank_cash_present = TRUE;
                        }
                        if ($valid_ledger->type != 1)
                            $non_bank_cash_present = TRUE;
                    } else if ($current_entry_type['bank_cash_ledger_restriction'] == '4') {
                        if ($valid_ledger->type != 1) {
                            //$this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries can have only Bank and Cash ac_ledgers accounts.', 'error');
                            $this->session->set_flashdata('error', 'Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries can have only Bank and Cash ac_ledgers accounts.');

                            //$this->template->load('template', 'entrymaster/edit', $data);
                            $this->load->view('accounts/income/add', $data);
                            return;
                        }
                    } else if ($current_entry_type['bank_cash_ledger_restriction'] == '5') {
                        if ($valid_ledger->type == 1) {
                            //$this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.', 'error');
                            $this->session->set_flashdata('error', 'Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.');
                            //$this->template->load('template', 'entrymaster/edit', $data);
                            $this->load->view('accounts/income/add', $data);
                            return;
                        }
                    }

                }

                if ($data_all_ledger_dc[$id] == "D") {
                    $dr_total = float_ops($data_all_dr_amount[$id], $dr_total, '+');

                } else {

                    $cr_total = float_ops($data_all_cr_amount[$id], $cr_total, '+');
                }
            }
        }


        if (float_ops($dr_total, $cr_total, '!='))
        {

            //$this->messages->add('Debit and Credit Total does not match!', 'error');
            $this->session->set_flashdata('error', 'Debit and Credit Total does not match!');
            //$this->template->load('template', 'payments/edit', $data);
            $this->load->view('accounts/income/add',$data);
            return;
            //}else if (float_ops($dr_total, $amount, '!='))
        }else if (float_ops($dr_total, '!='))
        {
            //$this->messages->add('Debit and Credit Total and voucher total does not match!', 'error');
            $this->session->set_flashdata('error', 'Debit and Credit Total and voucher total does not match!');
            //$this->template->load('template', 'payments/edit', $data);
            $this->load->view('accounts/income/add',$data);
            return;
        }

        else if (float_ops($dr_total, 0, '==') && float_ops($cr_total, 0, '==')) {

            $this->session->set_flashdata('error', 'Cannot save empty Entry.');
            $this->load->view('accounts/income/add',$data);
            return;
        }
        /* Check if atleast one Bank or Cash Ledger account is present */




        /* Adding main entry */
        if ($current_entry_type['numbering'] == '2')
        {
            $data_number = $this->input->post('entry_number', TRUE);
        } else if ($current_entry_type['numbering'] == '3') {
            $data_number = $this->input->post('entry_number', TRUE);
            if ( ! $data_number)
                $data_number = NULL;
        } else {
            if ($this->input->post('entry_number', TRUE))
                $data_number = $this->input->post('entry_number', TRUE);
            else
                $data_number = $this->Entry_model->next_entry_number($entry_type_id);
        }

        $data_date = $this->input->post('entry_date', TRUE);
        $data_narration = $this->input->post('entry_narration', TRUE);
        $data_tag = $this->input->post('entry_tag', TRUE);
        if ($data_tag < 1)
            $data_tag = NULL;
        $data_type = $entry_type_id;
        //$data_date = date_php_to_mysql($data_date); // Converting date to MySQL
        $data_date = $data_date; // Converting date to MySQL
        $data_has_reconciliation = $this->input->post('has_reconciliation', TRUE);

        $this->db->trans_start();
        $insert_data = array(
            'number' => $nextid,
            'date' => $data_date,
            'narration' => $data_narration,
            'entry_type' => $data_type,
            'tag_id' => $data_tag,
			'prj_id' =>$cur_entry->pri_id,
			'lot_id'=>$cur_entry->lot_id
			
        );
        if ( ! $this->db->insert('ac_entries', $insert_data))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error addding Entry.', 'error');
            $this->session->set_flashdata('error', 'Error addding Entry.');
            $this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed inserting entry");
            //$this->template->load('template', 'entrymaster/add', $data);
            $this->load->view('accounts/income/add',$data);
            return;
        } else {
            $new_entry_id = $this->db->insert_id();
        }
        $update_data = array(
            'rct_no'=>$nextid,
			'entry_id'=>$new_entry_id,
            'pay_status' => 'PAID',
        );

        if(! $this->db->where('id',$entry_id)->update('re_prjacincome',$update_data))
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
            $this->load->view('accounts/income/add',$data);
            return;
        }


        /* Adding ledger accounts */
        $data_all_ledger_dc = $this->input->post('ledger_dc', TRUE);
        $data_all_ledger_id = $this->input->post('ledger_id', TRUE);
        $data_all_dr_amount = $this->input->post('dr_amount', TRUE);
        $data_all_cr_amount = $this->input->post('cr_amount', TRUE);

        $dr_total = 0;
        $cr_total = 0;
        foreach ($data_all_ledger_dc as $id => $ledger_data)
        {
            $data_ledger_dc = $data_all_ledger_dc[$id];
            $data_ledger_id = $data_all_ledger_id[$id];
            if ($data_ledger_id  =="0")// modaification done by udani . Reasone : allow string ladger ids
                continue;
           // echo $data_ledger_id ;
            $data_amount = 0;
            if ($data_all_ledger_dc[$id] == "D")
            {
                $data_amount = $data_all_dr_amount[$id];
                $dr_total = float_ops($data_all_dr_amount[$id], $dr_total, '+');
            } else {
                $data_amount = $data_all_cr_amount[$id];
                $cr_total = float_ops($data_all_cr_amount[$id], $cr_total, '+');
            }
            $insert_ledger_data = array(
                'entry_id' => $new_entry_id,
                'ledger_id' => $data_ledger_id,
                'amount' => $data_amount,
                'dc' => $data_ledger_dc,
            );
            if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error adding Ledger account - ' . $data_ledger_id . ' to Entry.', 'error');
                $this->session->set_flashdata('error', 'Error adding Ledger account - ' . $data_ledger_id . ' to Entry.');
                $this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed inserting entry ledger item " . "[id:" . $data_ledger_id . "]");
                //$this->template->load('template', 'payments/edit', $data);
                $this->load->view('accounts/income/add',$data);

                return;
            }
            
        }

        /* Updating Debit and Credit Total in ac_entries table */
        $update_data = array(
            'dr_total' => $dr_total,
            'cr_total' => $cr_total,
        );
        if ( ! $this->db->where('id', $new_entry_id)->update('ac_entries', $update_data))
        {

            $this->db->trans_rollback();
            //$this->messages->add('Error updating Entry total.', 'error');
            $this->session->set_flashdata('error', 'Error updating Entry total.');
            $this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
            //$this->template->load('template', 'payments/edit', $data);
            $this->load->view('accounts/income/add',$data);
            return;
        }

        $chequeid="";
        if($this->input->post('payment_mode', TRUE)=="CHQ")
        {
            $datacheque=array(
                'CHQNO'=>$this->input->post('cheque_no', TRUE),
                'ENTRYCODE'=>$new_entry_id,
                'CHQDETAIL'=>$this->input->post('name', TRUE),
                'CHQDATE'=>$this->input->post('entry_date', TRUE),
                'BNKNAME'=>$this->input->post('bank_name', TRUE),
                'BRNNAME'=>$this->input->post('branch1', TRUE),
                'CHQAMOUNT'=> $dr_total,
                'CHQSTATUS'=>'PD',
                'CHQMODE'=>'IN',
            );
            if(!$this->db->insert('ac_chqdata',$datacheque))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error Inserting Cheque Data', 'error');
                $this->session->set_flashdata('error', 'Error Inserting Cheque Data');
                $this->logger->write_message("error", "Error Inserting Cheque Data");
//                    $this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/income/add',$data);
            }
            else{
                $chequeid=$this->db->insert_id();
                $this->logger->write_message("success", "Added Cheque No".$this->input->post('cheque_no', TRUE));
            }
        }

        $reciptdata=array ('RCTBID'=>$bookid,
            'RCTNO'=>$nextid,
            'RCTREFNO'=>$new_entry_id,
            'RCTSTATUS'=>"QUEUE",
            'CRDATE'=>date("Y-m-d H:i:s"),
        );
        if(!$this->db->insert('ac_recieptdata',$reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error Inserting Reciept', 'error');
            $this->session->set_flashdata('error', 'Error Inserting Receipt');
            $this->logger->write_message("error", "Error Inserting Reciept Data");
//                $this->template->load('template', 'entrymaster/add', $data);
            $this->load->view('accounts/income/add',$data);
        }
        else{
            $recieptid=$this->db->insert_id();
            $this->logger->write_message("success", "Added Receipt".$nextid);
        }
        $reciptid=intval($nextid);

        if($this->reciept_model->is_last_reciept($reciptid))
        {
            $rcdnewdata=array (
                'RCTSTATUS'=>'FINISH',
                'RCTENDDATE'=>date("Y-m-d H:i:s"),
            );
            if ( !$this->db->where('RCTBID',$bookid)->update('recieptbookdata', $rcdnewdata))
            {
                $this->db->trans_rollback();
                // $this->messages->add('Error Updating Reciept Boundle Status', 'error');
                $this->session->set_flashdata('error', 'Error Updating Receipt Boundle Status');
                //$this->logger->write_message("error", "Error Inserting Reciept Data");
//                    $this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);

            }
        }
        $trndata=array (
            'rcvmode'=>$this->input->post('payment_mode', TRUE),
            'entryid'=>$new_entry_id,
            'rcvamount'=>$dr_total,
            'rcvname'=>$this->input->post('chequename', TRUE),
            'RCTID'=>$recieptid,
            'fundtype'=>'RE',
            'expendituretype'=>'RE',
            'votenumber'=>'0',
            'CHQID'=>$chequeid,
            'recdate'=>date("Y-m-d H:i:s"),
        );
		  if ( ! $this->db->insert('ac_trnreceipts', $trndata))
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error Inserting Transaction');
            $this->load->view('accounts/income/add',$data);
        }
	update_jurnal_entry_insert($cur_entry->income_type,$cur_entry->id,date('Y-m-d'));
      


        /* Success */
        $this->db->trans_complete();

       

        /* Showing success message in show() method since message is too long for storing it in session */
     //   $this->logger->write_message("success", "Added Income Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
        
       // $this->session->set_flashdata('msg', "Added Income Entry number ");
      //  redirect('accounts/entrymaster/show/receipt');
		redirect('accounts/entrymaster/printreciepts/' .$new_entry_id);
        //$this->template->load('template', 'payments/make_payment', $data);
       return;
        //}
        ///return;
    }

    function search()
    {
        $entry_type='receipt';
        //$search=$this->input->post('search');
        $amountsearch=$this->input->post('amountsearch');
        $voucher_no=$this->input->post('voucher_no');

//        var_dump($amountsearch);
//        die();


        $data['tag_id'] = 0;
        $entry_type_id = 0;

        if ($entry_type == 'tag')
        {
            $tag_id = (int)$this->uri->segment(4);
            if ($tag_id < 1)
            {
                $this->session->set_flashdata('error', 'Invalid Tag.');
                redirect('accounts/income');
                return;
            }
            $data['tag_id'] = $tag_id;
            $tag_name = $this->Tag_model->tag_name($tag_id);
        } else if ($entry_type == 'all') {
            $entry_type_id = 0;
        } else {
            $entry_type_id = entry_type_name_to_id($entry_type);
            if ( ! $entry_type_id)
            {
                $this->session->set_flashdata('error', 'Invalid Entry type specified. Showing all ac_entries.');
                redirect('accounts/income');
                return;
            } else {
                $current_entry_type = entry_type_info($entry_type_id);
                //$this->template->set('page_title', $current_entry_type['name'] . ' ac_entries');
                //$this->template->set('nav_links', array('entrymaster/add/' . $current_entry_type['label'] => 'New ' . $current_entry_type['name'] . ' Entry','entrymaster/printQueue/' . $current_entry_type['label'] => 'Receipt Printer Queue'));
            }
        }

        $entry_q = NULL;

        /* Pagination setup */
        $this->load->library('pagination');

        if ($entry_type == "tag")
            $page_count = (int)$this->uri->segment(6);
        else
            $page_count = (int)$this->uri->segment(5);

        //$page_count = $this->input->xss_clean($page_count);

        if ( ! $page_count)
            $page_count = "0";

        $siteurl='accounts/income/search';
        $type_id='1';
        $pagination_counter =RAW_COUNT;
        $this->pagination_entries($page_count,$siteurl,$type_id);

        /* Pagination configuration */
//        if ($entry_type == 'tag')
//        {
//            $config['base_url'] = site_url('accounts/entrymaster/show/tag' . $tag_id);
//            $config['uri_segment'] = 5;
//        } else if ($entry_type == 'all') {
//            $config['base_url'] = site_url('accounts/entrymaster/show/all');
//            $config['uri_segment'] = 4;
//        } else {
//            $config['base_url'] = site_url('accounts/entrymaster/show/' . $current_entry_type['label']);
//            $config['uri_segment'] = 4;
//        }

        //$amount=$this->input->post('amount');
        if($amountsearch!="" && $voucher_no != "" ){
            $amountsearch=number_format($amountsearch, 2, '.', '');
            $this->db->from('re_prjacincome')->where('id', $voucher_no)->where('amount',$amountsearch);
            $entry_q = $this->db->get();
            $rowcount = $this->db->from('re_prjacincome')->where('id', $voucher_no)->where('amount',$amountsearch)->get()->num_rows();
            if($rowcount<1)
            {
                //$this->messages->add('Receipt number not exist ', 'error');
                $this->session->set_flashdata('error', 'Voucher number not exist ');
                redirect('accounts/income');
                return;
            }
        }
        else if($amountsearch!="" && $voucher_no=="" )
        {
            //$amountsearch=number_format($amountsearch, 2, '.', '');
            $this->db->from('re_prjacincome')->where('amount', $amountsearch)->where('pay_status','PENDING')->order_by('income_date', 'desc');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
            $rowcount = $this->db->from('re_prjacincome')->where('amount', $amountsearch)->where('pay_status','PENDING')->order_by('income_date', 'desc')->get()->num_rows();
            if($rowcount<1)
            {
                //$this->messages->add('Receipt number not exist ', 'error');
                $this->session->set_flashdata('error', 'This amount not exist ');
                redirect('accounts/income');
                return;
            }
        }
        else if($amountsearch=="" && $voucher_no!="" )
        {

            $this->db->from('re_prjacincome')->where('id', $voucher_no);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
            $rowcount = 	$this->db->from('re_prjacincome')->where('id', $voucher_no)->get()->num_rows();
            if($rowcount<1)
            {
                //$this->messages->add('Receipt number not exist ', 'error');
                $this->session->set_flashdata('error', 'Voucher number not exist');
                redirect('accounts/income');
                return;
            }
        }
        else{
            $this->session->set_flashdata('error', 'Search string could not be blank');
            redirect('accounts/income');
            return;
        }



        $data['entry_data'] = $entry_q;

        //$this->template->load('template', 'entrymaster/search', $data);
        $this->load->view('accounts/income/search',$data);
        return;

    }

 function get_reservations()
    {
        $data=NULL;
        if ( ! check_access('add_advance'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }
        //$data['searchpath']='';

        /* Calculating difference in Opening Balance */
        //$ac_projects = $this->paymentvoucher_model->get_pending_payment_vouchers($this->session->userdata('branchid'));
       $data['searchdata']= $ac_incomes = $this->mobilepay_model->get_pending_reservations();
			$data['searchlist']='';
				$data['searchpath']='';
			
		$datalist=NULL;
        if (!$ac_incomes)
        {
            $this->session->set_flashdata('error', 'No Data');
        }
		$data['prjlist']=$this->Entry_model->get_all_project_confirmed($this->session->userdata('branchid'));
        $data['ac_incomes'] = $ac_incomes;
        
        $this->load->view('accounts/mobilepay/reservation_list',$data);
        return;
    }
 function confirm_res($id)
 {
	
		$this->mobilepay_model->confirm_res($id);
		$mobdata=$this->mobilepay_model->confirm_data_byid($id);
		$this->session->set_flashdata('customername', $mobdata->customer_name);
		$this->session->set_flashdata('cusnic', $mobdata->nic);
		
			//redirect("re/reservation/showall/");
		redirect("re/customer/showall/");
 }

}
