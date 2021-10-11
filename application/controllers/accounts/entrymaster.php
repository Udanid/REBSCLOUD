<?php
//modications done by Udani - Function :-add() Edit()  Date : 11-09-2013

class Entrymaster extends CI_Controller {

    function Entrymaster()
    {
        parent::__construct();
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('reciept_model');
        $this->load->model('ac_projects_model');
        $this->load->model('custom_model');
		$this->load->model('accresupport_model');
			$this->load->model('cashadvance_model');
	
        $this->load->model('Setting_model');
		 $this->load->model('common_model');
		$this->is_logged_in();
        return;
    }

    function index()
    {
        redirect('accounts/entrymaster/show/receipt');
        return;
    }

    function show($entry_type)
    {

        $data['tag_id'] = 0;
        $entry_type_id = 0;

        if ($entry_type == 'tag')
        {
            $tag_id = (int)$this->uri->segment(4);
            if ($tag_id < 1)
            {
                //$this->messages->add('Invalid Tag.', 'error');
                $this->session->set_flashdata('error', 'Invalid Tag.');
                redirect('accounts/entrymaster/show/all');
                return;
            }
            $data['tag_id'] = $tag_id;
            $tag_name = $this->Tag_model->tag_name($tag_id);
            //$this->template->set('page_title', 'ac_entries Tagged "' . $tag_name . '"');
        } else if ($entry_type == 'all') {
            $entry_type_id = 0;
            //$this->template->set('page_title', 'All ac_entries');
        } else {
            $entry_type_id = entry_type_name_to_id($entry_type);
            if ( ! $entry_type_id)
            {
                //$this->messages->add('Invalid Entry type specified. Showing all ac_entries.', 'error');
                $this->session->set_flashdata('error', 'Invalid Entry type specified. Showing all ac_entries.');
                redirect('accounts/entrymaster/show/all');
                return;
            } else {
                $current_entry_type = entry_type_info($entry_type_id);

                //$this->template->set('page_title', $current_entry_type['name'] . ' ac_entries');
                //$this->template->set('nav_links', array('entrymaster/add/' . $current_entry_type['label'] => 'New ' . $current_entry_type['name'] . ' Entry','entrymaster/printQueue/' . $current_entry_type['label'] => 'Receipt Printer Queue'));
            }
        }

        $entry_q = NULL;

        /* Pagination setup */
      //  $this->load->library('pagination');

        if ($entry_type == "tag")
            $page_count = (int)$this->uri->segment(6);
        else
            $page_count = (int)$this->uri->segment(5);

//        var_dump($page_count);
//        die();
        //$page_count = $this->input->xss_clean($page_count);

        /* Pagination configuration */
        if ($entry_type == 'tag')
        {
            $config['base_url'] = site_url('accounts/entrymaster/show/tag' . $tag_id);
            $config['uri_segment'] = 5;
        } else if ($entry_type == 'all') {
            $config['base_url'] = site_url('accounts/entrymaster/show/all');
            $config['uri_segment'] = 4;
        } else {
            $config['base_url'] = site_url('accounts/entrymaster/show/' . $current_entry_type['label']);
            $config['uri_segment'] = 4;
        }
  		$pagination_counter =RAW_COUNT;
        if ($entry_type == "tag") {
            $this->db->from('ac_entries')->where('tag_id', $tag_id)->order_by('date', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
            $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->where('tag_id', $tag_id)->get()->num_rows();
        } else if ($entry_type_id > 0) {
             //  $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->join('ac_trnreceipts','ac_trnreceipts.entryid=ac_entries.id')->order_by('date', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');


			$this->db->select('ac_entries.id,ac_entries.date,ac_entries.tag_id,ac_entries.cr_total,ac_entries.number,ac_entries.entry_type,ac_recieptdata.RCTNO,ac_recieptdata.RCTSTATUS,ac_recieptdata.CNBY,ac_recieptdata.CRBY,ac_trnreceipts.rcvmode,ac_trnreceipts.temp_rctno,ac_chqdata.CHQNO,ac_chqdata.CHQSTATUS');
			//$this->db->where('entry_type', $entry_type_id)->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->join('ac_trnreceipts','ac_trnreceipts.entryid=ac_entries.id')->order_by('date', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
			$this->db->where('ac_entries.entry_type', $entry_type_id)->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->join('ac_trnreceipts','ac_trnreceipts.RCTID=ac_recieptdata.RCTID')->order_by('date', 'desc')->join('ac_chqdata','ac_entries.id=ac_chqdata.ENTRYCODE','left')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
			$entry_q = $this->db->get('ac_entries');
          // $entry_q = $this->db->get();

            $config['total_rows'] = $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->get()->num_rows();
        } else {
            $this->db->from('ac_entries')->order_by('date', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
            $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->count_all('ac_entries');
        }

        /* Pagination initializing */

        /* Show entry add actions *///dks dskfkkkjdkuleswomin lks kkdhnbnn

        $data['entry_data'] = $entry_q;
        $entry_q1 = NULL;




        if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('RCTSTATUS', 'CONFIRM')->order_by('date', 'desc')->order_by('number')->limit($pagination_counter, $page_count);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q1 = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('RCTSTATUS', 'CONFIRM')->order_by('date', 'desc')->order_by('number')->get()->num_rows();
        }
      //  $this->pagination->initialize($config);
        $data['entry_printdata'] = $entry_q1;
 		  if ( ! $page_count)
            $page_count = "0";

        $siteurl='accounts/entrymaster/show/receipt';
        $type_id='1';
        $data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();
        $this->pagination_entries($page_count,$siteurl,$type_id);
		//echo $this->pagination->create_links();
        //$this->template->load('template', 'entrymaster/index', $data);
      $this->load->view('accounts/entrymaster/index',$data);
        return;

    }


    function view($entry_type, $entry_id = 0)
    {

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        //$this->template->set('page_title', 'View ' . $current_entry_type['name'] . ' Entry');

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }
        /* Load current entry details */
        $this->db->from('ac_entry_items')->where('entry_id', $entry_id)->order_by('id', 'asc');
        $cur_entry_ac_ledgers = $this->db->get();
        if ($cur_entry_ac_ledgers->num_rows() < 1)
        {
            //$this->messages->add('Entry has no associated Ledger accounts.', 'error');
            $this->session->set_flashdata('error', 'Entry has no associated Ledger accounts.');
        }
			$data['project'] = $this->Entry_model->get_project_deials_by_id($cur_entry->prj_id);
			$data['lotdata'] = $this->Entry_model->get_lot_deials_by_id($cur_entry->lot_id);
        $data['cur_entry'] = $cur_entry;
        $data['cur_entry_ac_ledgers'] = $cur_entry_ac_ledgers;
        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        //$this->template->load('template', 'entrymaster/view', $data);
        $this->load->view('accounts/entrymaster/view',$data);
        return;
    }
    function addreceipt($entry_type)
    {

        $data=NULL;
        if ( ! check_access('add receipt entry'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'Account is locked');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/entrymaster/add/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/add/receipt');
            return;
        }
        else
        {
            $current_entry_type = entry_type_info($entry_type_id);

        }
       // $shortcode = $this->session->userdata('shortcode');
        //$this->template->set('page_title', 'New ' . $current_entry_type['name'] . ' Entry');
        $isstart=$this->reciept_model->get_start_recipt_bundle($this->session->userdata('branchid'));
        $bookid=$isstart->RCTBID;
        if($isstart)
        {
            $recieptid=$this->reciept_model->is_max_reciept_id($isstart->RCTBID);
            if($recieptid->RCTNO!=0)
                $nextid=intval($recieptid->RCTNO)+1;
            else
                $nextid=$isstart->RCTBSNO;
            $nextid=str_pad($nextid, 7, "0", STR_PAD_LEFT);
        }
        else{
            //$this->messages->add('Reciept Boundle Not Assigned.', 'error');
            $this->session->set_flashdata('error', 'Reciept Boundle Not Assigned.');
            redirect('accounts/entrymaster/add/receipt');
            return;
        }
        //fundtypetype
        $recievables=$this->reciept_model->get_ac_recievabletype();
        $arr['']="Select Project";
        foreach ($recievables as $raw)
        {
            $arr[$raw->typeid]=$raw->type;
        }
        $ac_projects = $this->ac_projects_model->get_all_ac_projects();
        $data['subac_projects']=$this->ac_projects_model->get_all__sub_ac_projects();
		$data['advancelist']=$this->cashadvance_model->get_cashadvancedata_for_reciept();
        $data['subprjid']='';
        $arr2['']="Select Project";
        if($ac_projects){
            foreach ($ac_projects as $raw)
            {
                $arr2[$raw->prjid]=new_ac_reference_code($raw->ref_id);
            }
        }
        /* Form fields */
        $votenumber='';
		$data['banklist']=$this->common_model->getbanklist();
        $data['projectlist']=$arr2;
        $data['recievblatype']=$arr;
        $data['recievableid']='';
        $data['fundtype']='';
        $data['expendituretype']='';
        $data['votenumber']=$votenumber;
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'maxlength' => '11',
            'readonly'=>'readonly',
            'size' => '11',
            'value' => $nextid,
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date('Y-m-d'),
        );

            //Ticket No:3107 Added By Madushan 2021-07-15
          $data['payment_date'] = array(
            'name' => 'payment_date',
            'id' => 'payment_date',
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
            'value' => '',
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
            'required'=>'required',
        );
        $data['bank_name'] = array(
            'name' => 'bank_name',
            'id' => 'bank_name',
            'maxlength' => '11',
            'size' => '11',
            'value' => '',
            'required'=>'required',
        );
        $data['branch_name'] = array(
            'name' => 'branch_name',
            'id' => 'bank_name',
            'maxlength' => '11',
            'size' => '11',
            'value' => '',
        );
        $data['amount'] = array(
            'name' => 'amount',
			'class' => 'form-control number-separator',
            'id' => 'amount',
            'maxlength' => '11',
            'onblur' => 'javascript:getDramount()',
            'size' => '11',
            'value' => '',
            'type'=>'text',
        );
        $data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'maxlength' => '100',
            'size' => '40',
            'value' => '',
            'required'=>'required',
        );
        $data['confirm'] = array(
            'name' => 'confirm',
            'id' => 'confirm',
            'maxlength' => '11',
            'size' => '11',
            'value' => 0,
        );
		$data['temp_rctno'] = array(
            'name' => 'temp_rctno',
            'id' => 'temp_rctno',
            'maxlength' => '50',
            'size' => '20',
            'value' => '',

        );
        $data['ref_no'] = array(
            'name' => 'ref_no',
            'id' => 'ref_no',
            'maxlength' => '50',
            'size' => '20',
            'value' => '',

        );
        $data['payment_mode']="CHQ";

        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entry_ac_tags'] = $this->Tag_model->get_all_ac_tags();
        $data['entry_tag'] = 0;

        /* Form validations */
//        $this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//        $this->form_validation->set_rules('payment_mode', 'Entry Date', 'trim|required');
//        $this->form_validation->set_rules('name', 'Doner Name', 'trim|required');
//        $this->form_validation->set_rules('entry_narration', 'trim');
//        $this->form_validation->set_rules('entry_tag', 'Tag', 'trim|is_natural');
//        $this->form_validation->set_rules('amount', 'Cheque Amount', 'trim|currency|required');
//        $this->form_validation->set_rules('fundtype', 'Fund Type', 'trim|required');
//        $this->form_validation->set_rules('expendituretype', 'Expenditure Type', 'trim|required');

        /* Debit and Credit amount validation */
        if ($_POST)
        {
            foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
            {
                //$this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
                //$this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
            }
            if($this->input->post('expendituretype', TRUE)=="CAP")
            {
                //$this->form_validation->set_rules('capitalvote', 'Vote Nomber', 'trim|required');
                $votenumber=$this->input->post('capitalvote', TRUE);
            }
            if($this->input->post('expendituretype', TRUE)=="REC")
            {
                //$this->form_validation->set_rules('recurrentvote', 'Vote Nomber', 'trim|required');
                $votenumber=$this->input->post('recurrentvote', TRUE);
            }
            if($this->input->post('payment_mode', TRUE)=="CHQ")
            {
                //$this->form_validation->set_rules('cheque_no', 'Cheque Nomber', 'trim|required');
                //$this->form_validation->set_rules('cheque_date', 'Cheque Date', 'trim|required');
                //$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
                //$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
            }
        }

        /* Repopulating form */
        if ($_POST)
        {
            $data['entry_number']['value'] = $this->input->post('entry_number', TRUE);
            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
            $data['entry_narration']['value'] = $this->input->post('entry_narration', TRUE);
            $data['cheque_no']['value'] = $this->input->post('cheque_no', TRUE);
            $data['cheque_date']['value'] = $this->input->post('cheque_date', TRUE);
            $data['bank_name']['value'] = $this->input->post('bank_name', TRUE);
            $data['branch_name']['value'] = $this->input->post('branch_name', TRUE);
            $data['amount']['value'] = $this->input->post('amount', TRUE);
            $data['name']['value'] = $this->input->post('name', TRUE);
            $data['confirm']['value'] = $this->input->post('confirm', TRUE);
            $data['payment_mode']=$this->input->post('payment_mode', TRUE);
            $data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
            $data['ledger_id'] = $this->input->post('ledger_id', TRUE);
            $data['dr_amount'] = $this->input->post('dr_amount', TRUE);
            $data['cr_amount'] = $this->input->post('cr_amount', TRUE);
            $data['fundtype'] = $this->input->post('fundtype', TRUE);
            $data['expendituretype'] = $this->input->post('expendituretype', TRUE);
            $data['votenumber'] = $votenumber;
        } else {
            for ($count = 0; $count <= 3; $count++)
            {
                if ($count == 0 )
                {
                    $data['ledger_dc'][$count] = "D";
                    $data['ledger_id'][$count] = $this->session->userdata('accshortcode')."BA17240000";
                }
                else if ($count > 0)
                    $data['ledger_dc'][$count] = "C";


                $data['dr_amount'][$count] = "";
                $data['cr_amount'][$count] = "";
            }
        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//          //  $this->template->load('template', 'entrymaster/add', $data);
//            $this->load->view('accounts/entrymaster/add',$data);
//            return;
//        }

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
                        //$this->template->load('template', 'entrymaster/add', $data);
                        $this->load->view('accounts/entrymaster/add', $data);
                        return;
                    } else {
                        /* Check for valid ledger type */
                        $valid_ledger = $valid_ledger_q->row();
                        if ($data_all_ledger_dc[$id] == 'D' && $valid_ledger->type == 1) {
                            $bank_cash_present = TRUE;
                        }
                        if ($valid_ledger->type != 1)
                            $non_bank_cash_present = TRUE;

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
                //$this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);
                return;
            } else if (float_ops($dr_total, 0, '==') && float_ops($cr_total, 0, '==')) {
                //echo $dr_total;
                //$this->messages->add('Cannot save empty Entry.', 'error');
                $this->session->set_flashdata('error', 'Cannot save empty Entry.');
                //$this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);
                return;
            }


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
            //$data_date = $data_date; // Converting date to MySQL
            $entry_id = NULL;

            $this->db->trans_start();
            $insert_data = array(
                'number' => $nextid,
                'date' => $data_date,
                'narration' => $data_narration,
                'entry_type' => $data_type,
                'tag_id' => $data_tag,
            );
            if ( ! $this->db->insert('ac_entries', $insert_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error addding Entry.', 'error');
                $this->session->set_flashdata('error', 'Error addding Entry.');
                $this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed inserting entry");
                //$this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);
                return;
            } else {
                $entry_id = $this->db->insert_id();
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
              //  echo $data_ledger_id ;
                $data_amount = 0;
                if ($data_all_ledger_dc[$id] == "D")
                {   $debit_account =  $data_ledger_id;//Ticket No:3116
                    $data_amount = $data_all_dr_amount[$id];
                    $dr_total = float_ops($data_all_dr_amount[$id], $dr_total, '+');
                } else {
                    $data_amount = $data_all_cr_amount[$id];
                    $cr_total = float_ops($data_all_cr_amount[$id], $cr_total, '+');
                }
                $insert_ledger_data = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $data_ledger_id,
                    'amount' => $data_amount,
                    'dc' => $data_ledger_dc,
                );
                if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
                {
                    $this->db->trans_rollback();
                   // $this->messages->add('Error adding Ledger account - ' . $data_ledger_id . ' to Entry.', 'error');
                    $this->session->set_flashdata('error','Error adding Ledger account - '. $data_ledger_id . ' to Entry.');
                    $this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed inserting entry ledger item " . "[id:" . $data_ledger_id . "]");
                    //$this->template->load('template', 'entrymaster/add', $data);
                    $this->load->view('accounts/entrymaster/add',$data);
                    return;
                }
                else{
                }

            }

            /* Updating Debit and Credit Total in ac_entries table */
            $update_data = array(
                'dr_total' => $dr_total,
                'cr_total' => $cr_total,
            );
            if ( ! $this->db->where('id', $entry_id)->update('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry total.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry total.');
                $this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
//                $this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);
                return;
            }
            $chequeid="";
            if($this->input->post('payment_mode', TRUE)=="CHQ")
            {
                $datacheque=array(
                    'CHQNO'=>$this->input->post('cheque_no', TRUE),
                    'ENTRYCODE'=>$entry_id,
                    'CHQDETAIL'=>$this->input->post('name', TRUE),
                    'CHQDATE'=>$this->input->post('cheque_date', TRUE),
                    'BNKNAME'=>$this->input->post('bank_name', TRUE),
                    'BRNNAME'=>$this->input->post('branch_name', TRUE),
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
                    $this->load->view('accounts/entrymaster/add',$data);
                }
                else{
                    $chequeid=$this->db->insert_id();
                    $this->logger->write_message("success", "Added Cheque No".$this->input->post('cheque_no', TRUE));
                }

            }

            $reciptdata=array ('RCTBID'=>$bookid,
                'RCTNO'=>$nextid,
				'RTCBRN'=>$this->session->userdata('shortcode'), /*Ticket No:3116 Updated By Madushan 2021-07-16*/
                'RCTREFNO'=>$entry_id,
                'RCTSTATUS'=>"QUEUE",
                'CRBY'=>$this->session->userdata('userid'),
                'CRDATE'=>date("Y-m-d H:i:s"),
            );
            if(!$this->db->insert('ac_recieptdata',$reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error Inserting Reciept', 'error');
                $this->session->set_flashdata('error', 'Error Inserting Receipt');
                $this->logger->write_message("error", "Error Inserting Reciept Data");
//                $this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);
            }
            else{
                $recieptid=$this->db->insert_id();
                $this->logger->write_message("success", "Added Reciept".$nextid);
            }
            //cheque reciept number is the last number of the bundle
            $reciptid=intval($nextid);
            if($this->reciept_model->is_last_reciept($reciptid,$bookid))
        {
            $rcdnewdata=array (
                'RCTSTATUS'=>'FINISH',
                'RCTENDDATE'=>date("Y-m-d H:i:s"),
            );
            if ( !$this->db->where('RCTBID',$bookid)->update('ac_recieptbookdata', $rcdnewdata))
            {
                $this->db->trans_rollback();
                // $this->messages->add('Error Updating Reciept Boundle Status', 'error');
                $this->session->set_flashdata('error', 'Error Updating Receipt Boundle Status');
                //$this->logger->write_message("error", "Error Inserting Reciept Data");
//                    $this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);

            }
        }
            //trnid`, `entryid`, `rcvmode`, `rcvamount`, `RCTID`, `CHQID`, `recdate`, `receivuser`SELECT * FROM `trnreceives` WHERE 1

            /*Ticket No:3279 Updated By Madushan 2021.08.10*/
        if($this->input->post('payment_mode', TRUE)=="CREDIT CARD" || $this->input->post('payment_mode', TRUE)=="DEBIT CARD" || $this->input->post('payment_mode', TRUE)=="DD" || $this->input->post('payment_mode', TRUE)=="FT")
        {
            $trndata=array (
            'rcvmode'=>$this->input->post('payment_mode', TRUE),
            'entryid'=>$entry_id,
            'rcvamount'=>$dr_total,
            'rcvname'=>$this->input->post('name', TRUE),
            'RCTID'=>$recieptid,
            'fundtype'=>'RE',
            'expendituretype'=>'RE',
            'votenumber'=>'0',
            'CHQID'=>$chequeid,
            'recdate'=>date("Y-m-d H:i:s"),
             'temp_rctno'=>$this->input->post('temp_rctno', TRUE),
             'ref_no'=>$this->input->post('ref_no', TRUE),
              'payment_date'=>$this->input->post('payment_date', TRUE),
        );
        }
        else
        {
           $trndata=array (
            'rcvmode'=>$this->input->post('payment_mode', TRUE),
            'entryid'=>$entry_id,
            'rcvamount'=>$dr_total,
            'rcvname'=>$this->input->post('name', TRUE),
            'RCTID'=>$recieptid,
            'fundtype'=>'RE',
            'expendituretype'=>'RE',
            'votenumber'=>'0',
            'CHQID'=>$chequeid,
            'recdate'=>date("Y-m-d H:i:s"),
             'temp_rctno'=>$this->input->post('temp_rctno', TRUE),
              'payment_date'=>$this->input->post('payment_date', TRUE),
        );
        }
            if ( ! $this->db->insert('ac_trnreceipts', $trndata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error Inserting Transaction', 'error');
                $this->session->set_flashdata('error', 'Error Inserting Transaction');
//                $this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/add',$data);
            }
            if($this->input->post('expendituretype', TRUE)=="CAP" & $this->input->post('fundtype', TRUE)!=3)
            {
                $grantdata=array(
                    'projectid'=>$votenumber,
                    'entryid'=>$entry_id,
                    'amount'=>$dr_total,
                    'recieptid'=>$recieptid,
                    'updatedate'=>date("Y-m-d H:i:s"),
                );
                if ( ! $this->db->insert('project_grants', $grantdata))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error Inserting Project Grants', 'error');
                    $this->session->set_flashdata('error', 'Error Inserting Project Grants');
//                    $this->template->load('template', 'entrymaster/add', $data);
                    $this->load->view('accounts/entrymaster/add',$data);
                }
                $projectdata=$this->ac_projects_model->get_project_byprojectid($votenumber);
                $newwal=(float)$projectdata->fund_release+(float)$dr_total;
                $udate=array('fund_release'=>$newwal);
                if ( ! $this->db->where('prjid', $votenumber)->update('ac_projects', $udate))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error updating ac_projects table.', 'error');
                    $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                }
            }
			//cash Advance refund new addion on commercial reality database
			if($this->input->post('advance_id', TRUE)!="")
			{
					$advid=explode('-', $this->input->post('advance_id'));
					$advance_id=$advid['0'];

					$advancedata=$this->cashadvance_model->get_Paid_advacne_full_databy_id($advance_id);
					if($advancedata)
					{	 $total=$advancedata->amount;
						$paid=$advancedata->totpay;
						$balance=$total-$paid;
						if($balance>0)
						{
							if($balance==$dr_total){
							//$dr_total
								$status='SETTLED';

								 $dataaa=array(
								'refund_amount' =>$balance,
								'status' =>$status,
								'refund_entryid'=>$entry_id,
								'refund_rctnumber'=>$nextid,
								'refund_date' =>date('Y-m-d'),
								'settled_date' =>date('Y-m-d'),


								);
								$this->db->where('adv_id',$advance_id);
								$insert = $this->db->Update('ac_cashadvance', $dataaa);
							}
						}


					}


			}
            /* Success */
            $this->db->trans_complete();

             //Ticket No:3116 Added By Madushan 2021-07-16
              if($this->session->userdata('usertype') == 'Branch_Cashier'){
            if(get_ledger_name($debit_account) == 'Cash in Hand Lands' || $this->input->post('payment_mode', TRUE) == 'CSH')
                 redirect('accounts/entrymaster/printreciepts/' .$entry_id);
            else
                redirect('accounts/entrymaster/show/receipt');
        }
        else
            redirect('accounts/entrymaster/printreciepts/' .$entry_id);
//            $this->template->load('template', 'entrymaster/add', $data);
          //  $this->load->view('accounts/entrymaster/add',$data);


        return;
    }

    function add($entry_type)
    {
//        var_dump($entry_type);
//        die();


        /* Check access */
        $data=NULL;
        if ( ! check_access('add receipt entry'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('re/project/');
            return;
        }

        /* Check for account lock */
//        if ($this->config->item('account_locked') == 1)
//        {
//            //$this->messages->add('Account is locked.', 'error');
//            $this->session->set_flashdata('error', 'Account is locked.');
//            redirect('accounts/entrymaster/show/'.$entry_type);
//            return;
//        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
//            var_dump($entry_type);
//            die();
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
            redirect('accounts/entrymaster/add'.$entry_type.'/'.$entry_type);
        }


    }

    function edit($entry_type, $entry_id = 0)
    {
        /* Check access */
        if ( ! check_access('edit receipt entry'))
        {
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        //$this->template->set('page_title', 'Edit ' . $current_entry_type['name'] . ' Entry');

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }
        if ( ! $rct_entry = $this->reciept_model->get_reciepttransaction($entry_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }
        $chq_entry=array('CHQNO'=>'','BNKNAME'=>'','BRNNAME'=>'');
        if($rct_entry->rcvmode=="CHQ")
        {
            if ( ! $chq_entry = $this->reciept_model->get_Chequedata($entry_id))
            {
                //$this->messages->add('Invalid Entry.', 'error');
                $this->session->set_flashdata('error', 'Invalid Entry.');
                redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
                return;
            }

            $data['cheque_date'] = array(
                'name' => 'cheque_date',
                'id' => 'cheque_date',
                'readonly'=>'readonly',
                'maxlength' => '11',
                'size' => '11',
                'value' => $chq_entry->CHQDATE,
            );
            $data['cheque_no'] = array(
                'name' => 'cheque_no',
                'id' => 'cheque_no',
                'maxlength' => '11',
                'size' => '11',
                'value' => $chq_entry->CHQNO,
            );
            $data['bank_name'] = array(
                'name' => 'bank_name',
                'id' => 'bank_name',
                'maxlength' => '11',
                'size' => '11',
                'value' => $chq_entry->BNKNAME,
            );
            $data['branch_name'] = array(
                'name' => 'branch_name',
                'id' => 'bank_name',
                'maxlength' => '11',
                'size' => '11',
                'value' => $chq_entry->BRNNAME,
            );

        }
        $recievables=$this->reciept_model->get_ac_recievabletype();
        $arr['']="Select Project";
        foreach ($recievables as $raw)
        {
            $arr[$raw->typeid]=$raw->type;
        }

        /* Form fields */
        $data['payment_mode']=$rct_entry->rcvmode;
        $votenumber=$rct_entry->votenumber;
      //  $data['projectlist']=$arr2;
        $data['recievblatype']=$arr;
        $data['recievableid']=$rct_entry->fundtype;
        $data['fundtype']=$rct_entry->fundtype;
        $data['expendituretype']=$rct_entry->expendituretype;
        $data['votenumber']=$rct_entry->votenumber;
        /* Form fields - Entry */
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'maxlength' => '11',
            'readonly' => 'readonly',
            'size' => '11',
            'value' => $cur_entry->number,
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'maxlength' => '11',
            'size' => '11',
            'value' => $cur_entry->date,
        );
        $data['entry_narration'] = array(
            'name' => 'entry_narration',
            'id' => 'entry_narration',
            'cols' => '50',
            'rows' => '4',
            'value' => $cur_entry->narration,
        );

        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'maxlength' => '11',
            'size' => '11',
            'value' => $rct_entry->rcvamount
        );
        $data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'maxlength' => '100',
            'size' => '40',
            'value' => $rct_entry->rcvname
        );
        $data['entry_id'] = $entry_id;
        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entry_tag'] = $cur_entry->tag_id;
        $data['entry_ac_tags'] = $this->Tag_model->get_all_ac_tags();
        $data['has_reconciliation'] = FALSE;

        /* Load current ledger details if not $_POST */
        if ( ! $_POST)
        {
            $this->db->from('ac_entry_items')->where('entry_id', $entry_id);
            $cur_ac_ledgers_q = $this->db->get();
            if ($cur_ac_ledgers_q->num_rows <= 0)
            {
                //$this->messages->add('No Ledger accounts found!', 'error');
                $this->session->set_flashdata('error', 'No Ledger accounts found!');
            }
            $counter = 0;

            foreach ($cur_ac_ledgers_q->result() as $row)
            {
                $data['ledger_dc'][$counter] = $row->dc;
                $data['ledger_id'][$counter] = $row->ledger_id;
                if ($row->dc == "D")
                {
                    $data['dr_amount'][$counter] = $row->amount;
                    $data['cr_amount'][$counter] = "";
                } else {
                    $data['dr_amount'][$counter] = "";
                    $data['cr_amount'][$counter] = $row->amount;
                }
                if ($row->reconciliation_date)
                    $data['has_reconciliation'] = TRUE;
                $counter++;
            }
            /* Two extra rows */
            $data['ledger_dc'][$counter] = 'D';
            $data['ledger_id'][$counter] = 0;
            $data['dr_amount'][$counter] = "";
            $data['cr_amount'][$counter] = "";
            $counter++;
            $data['ledger_dc'][$counter] = 'D';
            $data['ledger_id'][$counter] = 0;
            $data['dr_amount'][$counter] = "";
            $data['cr_amount'][$counter] = "";
            $counter++;
        }

        /* Form validations */
//        if ($current_entry_type['numbering'] == '3')
//            $this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//        else
//            $this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|required|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//        $this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//        $this->form_validation->set_rules('name', 'Doner Name', 'trim|required');
//        $this->form_validation->set_rules('entry_narration', 'trim');
//        $this->form_validation->set_rules('entry_tag', 'Tag', 'trim|is_natural');

        /* Debit and Credit amount validation */
//        if ($_POST)
//        {
//            foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
//            {
//                $this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
//                $this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
//            }
//            if($this->input->post('expendituretype', TRUE)=="CAP")
//            {
//                $this->form_validation->set_rules('capitalvote', 'Vote Nomber', 'trim|required');
//                $votenumber=$this->input->post('capitalvote', TRUE);
//            }
//            if($this->input->post('expendituretype', TRUE)=="REC")
//            {
//                $this->form_validation->set_rules('recurrentvote', 'Vote Nomber', 'trim|required');
//                $votenumber=$this->input->post('recurrentvote', TRUE);
//            }
//            if($this->input->post('payment_mode', TRUE)=="CHQ")
//            {
//                $this->form_validation->set_rules('cheque_no', 'Cheque Nomber', 'trim|required');
//                $this->form_validation->set_rules('cheque_date', 'Cheque Date', 'trim|required');
//                $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
//                $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
//            }
//        }

        /* Repopulating form */
        if ($_POST)
        {
            $data['entry_number']['value'] = $this->input->post('entry_number', TRUE);
            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
            $data['entry_narration']['value'] = $this->input->post('entry_narration', TRUE);
            $data['entry_tag'] = $this->input->post('entry_tag', TRUE);
            $data['has_reconciliation'] = $this->input->post('has_reconciliation', TRUE);

            $data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
            $data['ledger_id'] = $this->input->post('ledger_id', TRUE);
            $data['dr_amount'] = $this->input->post('dr_amount', TRUE);
            $data['cr_amount'] = $this->input->post('cr_amount', TRUE);

            $data['cheque_no']['value'] = $this->input->post('cheque_no', TRUE);
            $data['cheque_date']['value'] = $this->input->post('cheque_date', TRUE);
            $data['bank_name']['value'] = $this->input->post('bank_name', TRUE);
            $data['branch_name']['value'] = $this->input->post('branch_name', TRUE);
            $data['amount']['value'] = $this->input->post('amount', TRUE);
            $data['name']['value'] = $this->input->post('name', TRUE);
            $data['confirm']['value'] = $this->input->post('confirm', TRUE);
            $data['payment_mode']=$this->input->post('payment_mode', TRUE);
            $data['fundtype'] = $this->input->post('fundtype', TRUE);
            $data['expendituretype'] = $this->input->post('expendituretype', TRUE);
            $data['votenumber'] = $votenumber;
       }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'entrymaster/edit', $data);
//        } else	{
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
                    if ($data_all_ledger_id[$id] == "0")// modaification done by udani . Reasone : allow string ladger ids
                        continue;

                    /* Check for valid ledger id */
                    $this->db->from('ac_ledgers')->where('id', $data_all_ledger_id[$id]);
                    $valid_ledger_q = $this->db->get();
                    if ($valid_ledger_q->num_rows() < 1) {
                        //$this->messages->add('Invalid Ledger account.', 'error');
                        $this->session->set_flashdata('error', 'Invalid Ledger account.');
                        //$this->template->load('template', 'entrymaster/edit', $data);
                        $this->load->view('accounts/entrymaster/edit', $data);
                        return;
                    } else {
                        /* Check for valid ledger type */
                        $valid_ledger = $valid_ledger_q->row();
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
                                $this->load->view('accounts/entrymaster/edit', $data);
                                return;
                            }
                        } else if ($current_entry_type['bank_cash_ledger_restriction'] == '5') {
                            if ($valid_ledger->type == 1) {
                                //$this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.', 'error');
                                $this->session->set_flashdata('error', 'Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.');
                                //$this->template->load('template', 'entrymaster/edit', $data);
                                $this->load->view('accounts/entrymaster/edit', $data);
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
                //$this->template->load('template', 'entrymaster/edit', $data);
                $this->load->view('accounts/entrymaster/edit',$data);
                return;
            } else if (float_ops($dr_total, 0, '==') || float_ops($cr_total, 0, '==')) {
                //$this->messages->add('Cannot save empty Entry.', 'error');
                $this->session->set_flashdata('error', 'Cannot save empty Entry.');
                //$this->template->load('template', 'entrymaster/edit', $data);
                $this->load->view('accounts/entrymaster/edit',$data);
                return;
            }
            /* Check if atleast one Bank or Cash Ledger account is present */
            if ($current_entry_type['bank_cash_ledger_restriction'] == '2')
            {
                if ( ! $bank_cash_present)
                {
                    //$this->messages->add('Need to Debit atleast one Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Debit atleast one Bank or Cash account.');
                    //$this->template->load('template', 'entrymaster/edit', $data);
                    $this->load->view('accounts/entrymaster/edit',$data);
                    return;
                }
                if ( ! $non_bank_cash_present)
                {
                    //$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');
                    //$this->template->load('template', 'entrymaster/edit', $data);
                    $this->load->view('accounts/entrymaster/edit',$data);
                    return;
                }
            } else if ($current_entry_type['bank_cash_ledger_restriction'] == '3')
            {
                if ( ! $bank_cash_present)
                {
                    //$this->messages->add('Need to Credit atleast one Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Credit atleast one Bank or Cash account.');
                    //$this->template->load('template', 'entrymaster/edit', $data);
                    $this->load->view('accounts/entrymaster/edit',$data);
                    return;
                }
                if ( ! $non_bank_cash_present)
                {
                    //$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');

                    //$this->template->load('template', 'entrymaster/edit', $data);
                    $this->load->view('accounts/entrymaster/edit',$data);
                    return;
                }
            }

            /* Updating main entry */
            if ($current_entry_type['numbering'] == '3') {
                $data_number = $this->input->post('entry_number', TRUE);
                if ( ! $data_number)
                    $data_number = NULL;
            } else {
                $data_number = $this->input->post('entry_number', TRUE);
            }

            $data_date = $this->input->post('entry_date', TRUE);
            $data_narration = $this->input->post('entry_narration', TRUE);
            $data_tag = $this->input->post('entry_tag', TRUE);
            if ($data_tag < 1)
                $data_tag = NULL;
            $data_type = $entry_type_id;
            //$data_date = date_php_to_mysql($data_date); // Converting date to MySQL
            $data_has_reconciliation = $this->input->post('has_reconciliation', TRUE);

            $this->db->trans_start();
            $update_data = array(
                'number' => $data_number,
                'date' => $data_date,
                'narration' => $data_narration,
                'tag_id' => $data_tag,
            );
            if ( ! $this->db->where('id', $entry_id)->update('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry account.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry account.');
                $this->logger->write_message("error", "Error updating entry details for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                //$this->template->load('template', 'entrymaster/edit', $data);
                $this->load->view('accounts/entrymaster/edit',$data);
                return;
            }

            /* TODO : Deleting all old ledger data, Bad solution */
            if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error deleting previous Ledger accounts from Entry.', 'error');
                $this->session->set_flashdata('error', 'Error deleting previous Ledger accounts from Entry.');
                $this->logger->write_message("error", "Error deleting previous entry items for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                //$this->template->load('template', 'entrymaster/edit', $data);
                $this->load->view('accounts/entrymaster/edit',$data);
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
                    'entry_id' => $entry_id,
                    'ledger_id' => $data_ledger_id,
                    'amount' => $data_amount,
                    'dc' => $data_ledger_dc,
                );
                if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error adding Ledger account - ' . $data_ledger_id . ' to Entry.', 'error');
                    $this->session->set_flashdata('error', 'Error adding Ledger account - ' . $data_ledger_id . ' to Entry.');
                    $this->logger->write_message("error", "Error adding Ledger account item [id:" . $data_ledger_id . "] for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                    //$this->template->load('template', 'entry/edit', $data);
                    $this->load->view('accounts/entrymaster/edit',$data);
                    return;
                }
            }

            /* Updating Debit and Credit Total in ac_entries table */
            $update_data = array(
                'dr_total' => $dr_total,
                'cr_total' => $cr_total,
            );
            if ( ! $this->db->where('id', $entry_id)->update('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry total.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry total.');
                $this->logger->write_message("error", "Error updating entry total for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                //$this->template->load('template', 'entry/edit', $data);
                $this->load->view('accounts/entrymaster/edit',$data);
                return;
            }

            /* Updating Debit and Credit Total in ac_entries table */


            if($this->input->post('payment_mode', TRUE)=="CHQ")
            {
                $datacheque=array(
                    'CHQNO'=>$this->input->post('cheque_no', TRUE),
                    'CHQDETAIL'=>$this->input->post('name', TRUE),
                    'CHQDATE'=>$this->input->post('cheque_date', TRUE),
                    'BNKNAME'=>$this->input->post('bank_name', TRUE),
                    'BRNNAME'=>$this->input->post('branch_name', TRUE),
                    'CHQAMOUNT'=> $dr_total,

                );
                if(!$this->db->where('ENTRYCODE', $entry_id)->update('ac_chqdata',$datacheque))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error Inserting Cheque Data', 'error');
                    $this->session->set_flashdata('error', 'Error Inserting Cheque Data');
                    $this->logger->write_message("error", "Error Inserting Cheque Data");
                    //$this->template->load('template', 'entrymaster/add', $data);
                    $this->load->view('accounts/entrymaster/edit',$data);
                }
                else{
                    $chequeid=$this->db->insert_id();
                    $this->logger->write_message("success", "Added Cheque No".$this->input->post('cheque_no', TRUE));
                }

            }

            $trndata=array (
                'rcvmode'=>$this->input->post('payment_mode', TRUE),
                'rcvamount'=>$dr_total,
                'rcvname'=>$this->input->post('name', TRUE),
                'fundtype'=>$this->input->post('fundtype', TRUE),
                'expendituretype'=>$this->input->post('expendituretype', TRUE),
                'votenumber'=>$votenumber,
                'recdate'=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('entryid', $entry_id)->update('ac_trnreceipts', $trndata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error Inserting Transaction', 'error');
                $this->session->set_flashdata('error', 'Error Inserting Transaction');
                //$this->logger->write_message("error", "Error Inserting Reciept Data");
                //$this->template->load('template', 'entrymaster/add', $data);
                $this->load->view('accounts/entrymaster/edit',$data);
            }
            if($this->input->post('expendituretype', TRUE)=="CAP" & $this->input->post('fundtype', TRUE)!=3)
            {
                //select pre
                if($rct_entry->expendituretype=="CAP")
                {
                    $grantdata=array(
                        'projectid'=>$votenumber,
                        'amount'=>$dr_total,
                        'updatedate'=>date("Y-m-d H:i:s"),
                    );
                    if ( ! $this->db->where('entryid', $entry_id)->update('project_grants', $grantdata))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error Inserting Project Grants', 'error');
                        $this->session->set_flashdata('error', 'Error Inserting Project Grants');
                        //$this->template->load('template', 'entrymaster/add', $data);
                        $this->load->view('accounts/entrymaster/edit',$data);
                    }
                    if($rct_entry->votenumber==$votenumber)
                    {
                        $projectdata=$this->ac_projects_model->get_project_byprojectid($votenumber);
                        $newwal=(float)$projectdata->fund_release+(float)$dr_total-(float)$rct_entry->rcvamount;
                        $udate=array('fund_release'=>$newwal);
                        if ( ! $this->db->where('prjid', $votenumber)->update('ac_projects', $udate))
                        {
                            $this->db->trans_rollback();
                            //$this->messages->add('Error updating ac_projects table.', 'error');
                            $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                        }
                    }
                    else
                    {
                        $projectdata=$this->ac_projects_model->get_project_byprojectid($rct_entry->votenumber);
                        $newwal=(float)$projectdata->fund_release-(float)$rct_entry->rcvamount;
                        $udate=array('fund_release'=>$newwal);
                        if ( ! $this->db->where('prjid', $rct_entry->votenumber)->update('ac_projects', $udate))
                        {
                            $this->db->trans_rollback();
                            //$this->messages->add('Error updating ac_projects table.', 'error');
                            $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                        }
                        $projectdata=$this->ac_projects_model->get_project_byprojectid($votenumber);
                        $newwal=(float)$projectdata->fund_release+(float)$dr_total;
                        $udate=array('fund_release'=>$newwal);
                        if ( ! $this->db->where('prjid', $votenumber)->update('ac_projects', $udate))
                        {
                            $this->db->trans_rollback();
                            //$this->messages->add('Error updating ac_projects table.', 'error');
                            $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                        }

                    }

                }
                else
                {
                    $grantdata=array(
                        'projectid'=>$votenumber,
                        'entryid'=>$entry_id,
                        'amount'=>$dr_total,
                        'recieptid'=>$recieptid,
                        'updatedate'=>date("Y-m-d H:i:s"),
                    );
                    if ( ! $this->db->insert('project_grants', $grantdata))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error Inserting Project Grants', 'error');
                        $this->session->set_flashdata('error', 'Error Inserting Project Grants');
                        //$this->logger->write_message("error", "Error Inserting Reciept Data");
                        //$this->template->load('template', 'entrymaster/add', $data);
                        $this->load->view('accounts/entrymaster/edit',$data);
                    }
                    $projectdata=$this->ac_projects_model->get_project_byprojectid($votenumber);
                    $newwal=(float)$projectdata->fund_release+(float)$dr_total;
                    $udate=array('fund_release'=>$newwal);
                    if ( ! $this->db->where('prjid', $votenumber)->update('ac_projects', $udate))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating ac_projects table.', 'error');
                        $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                    }

                }
            }
            else{
                if($rct_entry->expendituretype=="CAP" & $this->input->post('fundtype', TRUE)!=3)
                {

                    $projectdata=$this->ac_projects_model->get_project_byprojectid($rct_entry->votenumber);
                    $newwal=(float)$projectdata->fund_release-(float)$rct_entry->rcvamount;
                    $udate=array('fund_release'=>$newwal);
                    if ( ! $this->db->where('prjid', $rct_entry->votenumber)->update('ac_projects', $udate))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating ac_projects table.', 'error');
                        $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                    }
                    $this->db->where('entryid', $entry_id)->delete('project_grants');
                }


            }

            /* Success */
            $this->db->trans_complete();


            /* Showing success message in show() method since message is too long for storing it in session */
            $this->logger->write_message("success", "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");

            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
       // }
        //return;
    }
    function cancel($entry_id = 0)
    {
//        var_dump($entry_id);
//        die();
        $entry_type ='Receipt';
        /* Check access */
        if ( ! check_access('cancel receipt entry'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        }
		else {

            $current_entry_type = entry_type_info($entry_type_id);
        }

        //$this->template->set('page_title', 'Cancel ' . $current_entry_type['name'] . ' Entry');

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }

        /* Form fields - Entry */
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'maxlength' => '11',
            'size' => '11',
            'value' => $cur_entry->number,
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'maxlength' => '11',
            'size' => '11',
            'value' => $cur_entry->date,
        );
        $data['entry_narration'] = array(
            'name' => 'entry_narration',
            'id' => 'entry_narration',
            'cols' => '50',
            'rows' => '4',
            'value' => $cur_entry->narration,
        );
        $data['entry_id'] = $entry_id;
        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entry_tag'] = $cur_entry->tag_id;
        $data['entry_ac_tags'] = $this->Tag_model->get_all_ac_tags();
        $data['has_reconciliation'] = FALSE;

        /* Load current ledger details if not $_POST */
        if ( ! $_POST)
        {
            $this->db->from('ac_entry_items')->where('entry_id', $entry_id);
            $cur_ac_ledgers_q = $this->db->get();
            if ($cur_ac_ledgers_q->num_rows <= 0)
            {
                //$this->messages->add('No Ledger accounts found!', 'error');
                $this->session->set_flashdata('error', 'No Ledger accounts found!');
            }
            $counter = 0;
            foreach ($cur_ac_ledgers_q->result() as $row)
            {
                $data['ledger_dc'][$counter] = $row->dc;
                $data['ledger_id'][$counter] = $row->ledger_id;
                if ($row->dc == "D")
                {
                    $data['dr_amount'][$counter] = $row->amount;
                    $data['cr_amount'][$counter] = "";
                } else {
                    $data['dr_amount'][$counter] = "";
                    $data['cr_amount'][$counter] = $row->amount;
                }
                if ($row->reconciliation_date)
                    $data['has_reconciliation'] = TRUE;
                $counter++;
            }
            /* Two extra rows */
            $data['ledger_dc'][$counter] = 'D';
            $data['ledger_id'][$counter] = 0;
            $data['dr_amount'][$counter] = "";
            $data['cr_amount'][$counter] = "";
            $counter++;
            $data['ledger_dc'][$counter] = 'D';
            $data['ledger_id'][$counter] = 0;
            $data['dr_amount'][$counter] = "";
            $data['cr_amount'][$counter] = "";
            $counter++;
        }

        /* Form validations */
//        if ($current_entry_type['numbering'] == '3')
//            $this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//        else
//            $this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|required|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//        $this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//        $this->form_validation->set_rules('entry_narration', 'trim');
//        $this->form_validation->set_rules('entry_tag', 'Tag', 'trim|is_natural');

        /* Debit and Credit amount validation */
        if ($_POST)
        {
            foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
            {
//                $this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
//                $this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
            }
        }

        /* Repopulating form */
        if ($_POST)
        {
            $data['entry_number']['value'] = $this->input->post('entry_number', TRUE);
            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
            $data['entry_narration']['value'] = $this->input->post('entry_narration', TRUE);
            $data['entry_tag'] = $this->input->post('entry_tag', TRUE);
            $data['has_reconciliation'] = $this->input->post('has_reconciliation', TRUE);

            $data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
            $data['ledger_id'] = $this->input->post('ledger_id', TRUE);
            $data['dr_amount'] = $this->input->post('dr_amount', TRUE);
            $data['cr_amount'] = $this->input->post('cr_amount', TRUE);
        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'entrymaster/cancel', $data);
//        } else	{
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
                    if ($data_all_ledger_id[$id] == "0")// modaification done by udani . Reasone : allow string ladger ids
                        continue;

                    /* Check for valid ledger id */
                    $this->db->from('ac_ledgers')->where('id', $data_all_ledger_id[$id]);
                    $valid_ledger_q = $this->db->get();
                    if ($valid_ledger_q->num_rows() < 1) {
                        //$this->messages->add('Invalid Ledger account.', 'error');
                        $this->session->set_flashdata('error', 'Invalid Ledger account.');
                        //$this->template->load('template', 'entrymaster/cancel', $data);
                        $this->load->view('accounts/entrymaster/cancel', $data);
                        return;
                    } else {
                        /* Check for valid ledger type */
                        $valid_ledger = $valid_ledger_q->row();
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
                                //$this->template->load('template', 'entrymaster/cancel', $data);
                                $this->load->view('accounts/entrymaster/cancel', $data);
                                return;
                            }
                        } else if ($current_entry_type['bank_cash_ledger_restriction'] == '5') {
                            if ($valid_ledger->type == 1) {
                                $this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.', 'error');
                                $this->session->set_flashdata('error', 'Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.');
                                //$this->template->load('template', 'entrymaster/cancel', $data);
                                $this->load->view('accounts/entrymaster/cancel', $data);
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
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            } else if (float_ops($dr_total, 0, '==') || float_ops($cr_total, 0, '==')) {
                //$this->messages->add('Cannot save empty Entry.', 'error');
                $this->session->set_flashdata('error', 'Cannot save empty Entry.');
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }
            /* Check if atleast one Bank or Cash Ledger account is present */
            if ($current_entry_type['bank_cash_ledger_restriction'] == '2')
            {
                if ( ! $bank_cash_present)
                {
                    //$this->messages->add('Need to Debit atleast one Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Debit atleast one Bank or Cash account.');
                    //$this->template->load('template', 'entrymaster/cancel', $data);
                    $this->load->view('accounts/entrymaster/cancel',$data);
                    return;
                }
                if ( ! $non_bank_cash_present)
                {
                    //$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');
                    //$this->template->load('template', 'entrymaster/cancel', $data);
                    $this->load->view('accounts/entrymaster/cancel',$data);
                    return;
                }
            } else if ($current_entry_type['bank_cash_ledger_restriction'] == '3')
            {
                if ( ! $bank_cash_present)
                {
                    //$this->messages->add('Need to Credit atleast one Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Credit atleast one Bank or Cash account.');
                    $this->load->view('accounts/entrymaster/cancel',$data);
                    return;
                }
                if ( ! $non_bank_cash_present)
                {
                    //$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
                    $this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');
                    $this->load->view('accounts/entrymaster/cancel',$data);
                    return;
                }
            }

            /* Updating main entry */
            if ($current_entry_type['numbering'] == '3') {
                $data_number = $this->input->post('entry_number', TRUE);
                if ( ! $data_number)
                    $data_number = NULL;
            } else {
                $data_number = $this->input->post('entry_number', TRUE);
            }
            if ( ! $rct_entry = $this->reciept_model->get_reciepttransaction($entry_id))
            {
                //$this->messages->add('Invalid Entry.', 'error');
                $this->session->set_flashdata('error', 'nvalid Entry.');
                redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
                return;
            }
            $data_date = $this->input->post('entry_date', TRUE);
            $data_narration = $this->input->post('entry_narration', TRUE);
            $data_tag = $this->input->post('entry_tag', TRUE);
            if ($data_tag < 1)
                $data_tag = NULL;
            $data_type = $entry_type_id;
            //$data_date = date_php_to_mysql($data_date); // Converting date to MySQL
            $data_has_reconciliation = $this->input->post('has_reconciliation', TRUE);

            $this->db->trans_start();

            /*Check before hit cancellation entry
            Ticket No:3160 Added By Madushan 2021-07-23*/
            $this->db->select('RCTSTATUS');
            $this->db->where('RCTREFNO',$entry_id);
            $query = $this->db->get('ac_recieptdata');
            if($query->num_rows>0)
                $check_entry = $query->row()->RCTSTATUS;
            else
                $check_entry = false;

            if($check_entry != 'CANCEL'){
                $update_data = array(
                    'number' => $data_number,
                    'date' => $data_date,
                    'narration' => $data_narration,
                    'entry_type' => '5',
                    'tag_id' => $data_tag,
                    'prj_id' => $cur_entry->prj_id,
                    'lot_id' => $cur_entry->lot_id,
					'res_code' => $cur_entry->lot_id,
            );
            if ( ! $this->db->insert('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry account.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry account.');
                $this->logger->write_message("error", "Error updating entry details for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }
            else
            {
                $entry_idnew = $this->db->insert_id();
            }

            /* TODO : Deleting all old ledger data, Bad solution */
            /*if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
            {
                $this->db->trans_rollback();
                $this->messages->add('Error deleting previous Ledger accounts from Entry.', 'error');
                $this->logger->write_message("error", "Error deleting previous entry items for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                $this->template->load('template', 'entrymaster/edit', $data);
                return;
            }*/

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
                $data_amount = 0;
                if ($data_all_ledger_dc[$id] == "D")
                {
                    $data_ledger_dc="C";
                    $data_amount = $data_all_dr_amount[$id];
                    $dr_total = float_ops($data_all_dr_amount[$id], $dr_total, '+');
                } else {
                    $data_ledger_dc="D";
                    $data_amount = $data_all_cr_amount[$id];
                    $cr_total = float_ops($data_all_cr_amount[$id], $cr_total, '+');
                }

                $insert_ledger_data = array(
                    'entry_id' => $entry_idnew,
                    'ledger_id' => $data_ledger_id,
                    'amount' => $data_amount,
                    'dc' => $data_ledger_dc,
                );
                if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error adding Ledger account - ' . $data_ledger_id . ' to Entry.', 'error');
                    $this->session->set_flashdata('error', 'Error adding Ledger account - ' . $data_ledger_id . ' to Entry.');
                    $this->logger->write_message("error", "Error adding Ledger account item [id:" . $data_ledger_id . "] for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                    //$this->template->load('template', 'entrymaster/cancel', $data);
                    $this->load->view('accounts/entrymaster/cancel',$data);
                    return;
                }
            }

            /* Updating Debit and Credit Total in ac_entries table */
            $update_data = array(
                'dr_total' => $dr_total,
                'cr_total' => $cr_total,
            );
            if ( ! $this->db->where('id', $entry_idnew)->update('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry total.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry total.');
                $this->logger->write_message("error", "Error updating entry total for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }
            $entrystat=array (
                'entry_id'=>$entry_idnew,
                'status'=>"CONFIRM",
            );
            $this->db->insert('ac_entry_status', $entrystat);
            $rctdata=$this->reciept_model->get_ac_recieptdata($entry_id);
            $reciptdata=array (
                'CNRES'=>$data_narration,
                'CNREFNO'=>$entry_idnew,
                'CNBY'=>$this->session->userdata('username'),
                'RCTSTATUS'=>"CANCEL",
                'CNDATE'=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('RCTREFNO', $entry_id)->update('ac_recieptdata', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Receipt Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Receipt Cancelation.');
                $this->logger->write_message("error", "Error updating Receipt Cancelation");
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }
            $reciptdata=array (
                'CHQSTATUS'=>"DL",
                'UPDATEDATE '=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('ENTRYCODE', $entry_id)->update('ac_chqdata', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Cancelation.');
                $this->logger->write_message("error", "Error updating Cheque Cancelation");
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }

                 $this->db->from('re_prjacincome')->where('entry_id', $entry_id);
        $entry_q = $this->db->get();
        $rowcount =     $entry_q->num_rows();
//        var_dump($rowcount);
//        die();
        if($rowcount>0){
            $trndata=$this->reciept_model->get_reciepttransaction($entry_id);
            //echo $trndata->rcvmode;




            update_jurnal_entry_cancel($entry_id);
            $update_data = array(
                'rct_no'=>'',
                'entry_id'=>'',
                'pay_status' => 'PENDING',
            );

            if(! $this->db->where('entry_id',$entry_id)->update('re_prjacincome',$update_data))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
                $this->load->view('accounts/entrymaster');
                return;
            }

        }
            $this->db->from('hm_prjacincome')->where('entry_id', $entry_id);
        $entry_q = $this->db->get();
        $rowcount =     $entry_q->num_rows();
        if($rowcount>0){

                hm_update_jurnal_entry_cancel($entry_id);
            $update_data = array(
                'rct_no'=>'',
                'entry_id'=>'',
                'pay_status' => 'PENDING',
            );

            if(! $this->db->where('entry_id',$entry_id)->update('re_prjacincome',$update_data))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
                $this->load->view('accounts/entrymaster');
                return;
            }

        }
            $reciptdata=array (
                'tag'=>"CANCEL",

            );
            if ( ! $this->db->where('entryid', $entry_id)->update('ac_trnreceipts', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Reciept Transaction Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Reciept Transaction Cancelation.');
                $this->logger->write_message("error", "Error updating Reciept Transaction");
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }

            /* Success */
            $this->cashadvance_model->delete_defunddata($entry_id);
            $this->db->trans_complete();

            $this->session->set_userdata('entry_updated_show_action', TRUE);
            $this->session->set_userdata('entry_updated_id', $entry_id);
            $this->session->set_userdata('entry_updated_type_id', $entry_type_id);
            $this->session->set_userdata('entry_updated_type_label', $current_entry_type['label']);
            $this->session->set_userdata('entry_updated_type_name', $current_entry_type['name']);
            $this->session->set_userdata('entry_updated_number', $data_number);
            if ($data_has_reconciliation)
                $this->session->set_userdata('entry_updated_has_reconciliation', TRUE);
            else
                $this->session->set_userdata('entry_updated_has_reconciliation', FALSE);

             $this->logger->write_message("success", "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
            }
            else
            {
               $this->session->set_flashdata('error', 'Already Cancelled');
            }


            /* Showing success message in show() method since message is too long for storing it in session */
           

            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
      }
	function return_cheque($entry_id = 0)
    {
//        var_dump($entry_id);
//        die();
        $entry_type ='Receipt';
        /* Check access */
        if ( ! check_access('return cheque'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        //$this->template->set('page_title', 'Cancel ' . $current_entry_type['name'] . ' Entry');

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }

        /* Form fields - Entry */
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'maxlength' => '11',
            'size' => '11',
            'value' => $cur_entry->number,
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'maxlength' => '11',
            'size' => '11',
            'value' => $cur_entry->date,
        );
        $data['entry_narration'] = array(
            'name' => 'entry_narration',
            'id' => 'entry_narration',
            'cols' => '50',
            'rows' => '4',
            'value' => $cur_entry->narration,
        );
        $data['entry_id'] = $entry_id;
        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entry_tag'] = $cur_entry->tag_id;
        $data['entry_ac_tags'] = $this->Tag_model->get_all_ac_tags();
        $data['has_reconciliation'] = FALSE;

        /* Load current ledger details if not $_POST */
        if ( ! $_POST)
        {
            $this->db->from('ac_entry_items')->where('entry_id', $entry_id);
            $cur_ac_ledgers_q = $this->db->get();
            if ($cur_ac_ledgers_q->num_rows <= 0)
            {
                //$this->messages->add('No Ledger accounts found!', 'error');
                $this->session->set_flashdata('error', 'No Ledger accounts found!');
            }
            $counter = 0;
            foreach ($cur_ac_ledgers_q->result() as $row)
            {
                $data['ledger_dc'][$counter] = $row->dc;
                $data['ledger_id'][$counter] = $row->ledger_id;
                if ($row->dc == "D")
                {
                    $data['dr_amount'][$counter] = $row->amount;
                    $data['cr_amount'][$counter] = "";
                } else {
                    $data['dr_amount'][$counter] = "";
                    $data['cr_amount'][$counter] = $row->amount;
                }
                if ($row->reconciliation_date)
                    $data['has_reconciliation'] = TRUE;
                $counter++;
            }
            /* Two extra rows */
            $data['ledger_dc'][$counter] = 'D';
            $data['ledger_id'][$counter] = 0;
            $data['dr_amount'][$counter] = "";
            $data['cr_amount'][$counter] = "";
            $counter++;
            $data['ledger_dc'][$counter] = 'D';
            $data['ledger_id'][$counter] = 0;
            $data['dr_amount'][$counter] = "";
            $data['cr_amount'][$counter] = "";
            $counter++;
        }

        /* Form validations */
//        if ($current_entry_type['numbering'] == '3')
//            $this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//        else
//            $this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|required|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//        $this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//        $this->form_validation->set_rules('entry_narration', 'trim');
//        $this->form_validation->set_rules('entry_tag', 'Tag', 'trim|is_natural');

        /* Debit and Credit amount validation */
        if ($_POST)
        {
            foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
            {
//                $this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
//                $this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
            }
        }

        /* Repopulating form */
        if ($_POST)
        {
            $data['entry_number']['value'] = $this->input->post('entry_number', TRUE);
            $data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
            $data['entry_narration']['value'] = $this->input->post('entry_narration', TRUE);
            $data['entry_tag'] = $this->input->post('entry_tag', TRUE);
            $data['has_reconciliation'] = $this->input->post('has_reconciliation', TRUE);

            $data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
            $data['ledger_id'] = $this->input->post('ledger_id', TRUE);
            $data['dr_amount'] = $this->input->post('dr_amount', TRUE);
            $data['cr_amount'] = $this->input->post('cr_amount', TRUE);
        }

//        if ($this->form_validation->run() == FALSE)
//        {
//            $this->messages->add(validation_errors(), 'error');
//            $this->template->load('template', 'entrymaster/cancel', $data);
//        } else	{
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
                    if ($data_all_ledger_id[$id] == "0")// modaification done by udani . Reasone : allow string ladger ids
                        continue;

                    /* Check for valid ledger id */
                    $this->db->from('ac_ledgers')->where('id', $data_all_ledger_id[$id]);
                    $valid_ledger_q = $this->db->get();
                    if ($valid_ledger_q->num_rows() < 1) {
                        //$this->messages->add('Invalid Ledger account.', 'error');
                        $this->session->set_flashdata('error', 'Invalid Ledger account.');
                        //$this->template->load('template', 'entrymaster/cancel', $data);
                        $this->load->view('accounts/entrymaster/cancel', $data);
                        return;
                    } else {
                        /* Check for valid ledger type */
                        $valid_ledger = $valid_ledger_q->row();
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
                                //$this->template->load('template', 'entrymaster/cancel', $data);
                                $this->load->view('accounts/entrymaster/cancel', $data);
                                return;
                            }
                        } else if ($current_entry_type['bank_cash_ledger_restriction'] == '5') {
                            if ($valid_ledger->type == 1) {
                                $this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.', 'error');
                                $this->session->set_flashdata('error', 'Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.');
                                //$this->template->load('template', 'entrymaster/cancel', $data);
                                $this->load->view('accounts/entrymaster/return', $data);
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
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/return',$data);
                return;
            } else if (float_ops($dr_total, 0, '==') || float_ops($cr_total, 0, '==')) {
                //$this->messages->add('Cannot save empty Entry.', 'error');
                $this->session->set_flashdata('error', 'Cannot save empty Entry.');
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/return',$data);
                return;
            }
            /* Check if atleast one Bank or Cash Ledger account is present */


            /* Updating main entry */
            if ($current_entry_type['numbering'] == '3') {
                $data_number = $this->input->post('entry_number', TRUE);
                if ( ! $data_number)
                    $data_number = NULL;
            } else {
                $data_number = $this->input->post('entry_number', TRUE);
            }
            if ( ! $rct_entry = $this->reciept_model->get_reciepttransaction($entry_id))
            {
                //$this->messages->add('Invalid Entry.', 'error');
                $this->session->set_flashdata('error', 'nvalid Entry.');
                redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
                return;
            }
            $data_date = $this->input->post('entry_date', TRUE);
            $data_narration = $this->input->post('entry_narration', TRUE);
            $data_tag = $this->input->post('entry_tag', TRUE);
            if ($data_tag < 1)
                $data_tag = NULL;
            $data_type = $entry_type_id;
            //$data_date = date_php_to_mysql($data_date); // Converting date to MySQL
            $data_has_reconciliation = $this->input->post('has_reconciliation', TRUE);

            $this->db->trans_start();




            $update_data = array(
                'number' => $data_number,
                'date' => $data_date,
                'narration' => $data_narration,
                'entry_type' => '5',
                'tag_id' => $data_tag,
				'prj_id' => $cur_entry->prj_id,
				'lot_id' => $cur_entry->lot_id,
            );
            if ( ! $this->db->insert('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry account.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry account.');
                $this->logger->write_message("error", "Error updating entry details for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                $this->load->view('accounts/entrymaster/return',$data);
                return;
            }
            else
            {
                $entry_idnew = $this->db->insert_id();
            }

            /* TODO : Deleting all old ledger data, Bad solution */
            /*if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
            {
                $this->db->trans_rollback();
                $this->messages->add('Error deleting previous Ledger accounts from Entry.', 'error');
                $this->logger->write_message("error", "Error deleting previous entry items for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                $this->template->load('template', 'entrymaster/edit', $data);
                return;
            }*/

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
                $data_amount = 0;
                if ($data_all_ledger_dc[$id] == "D")
                {
                    $data_ledger_dc="C";
                    $data_amount = $data_all_dr_amount[$id];
                    $dr_total = float_ops($data_all_dr_amount[$id], $dr_total, '+');
                } else {
                    $data_ledger_dc="D";
                    $data_amount = $data_all_cr_amount[$id];
                    $cr_total = float_ops($data_all_cr_amount[$id], $cr_total, '+');
                }

                $insert_ledger_data = array(
                    'entry_id' => $entry_idnew,
                    'ledger_id' => $data_ledger_id,
                    'amount' => $data_amount,
                    'dc' => $data_ledger_dc,
                );
                if ( ! $this->db->insert('ac_entry_items', $insert_ledger_data))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error adding Ledger account - ' . $data_ledger_id . ' to Entry.', 'error');
                    $this->session->set_flashdata('error', 'Error adding Ledger account - ' . $data_ledger_id . ' to Entry.');
                    $this->logger->write_message("error", "Error adding Ledger account item [id:" . $data_ledger_id . "] for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                    //$this->template->load('template', 'entrymaster/cancel', $data);
                    $this->load->view('accounts/entrymaster/return',$data);
                    return;
                }
            }

            /* Updating Debit and Credit Total in ac_entries table */
            $update_data = array(
                'dr_total' => $dr_total,
                'cr_total' => $cr_total,
            );
            if ( ! $this->db->where('id', $entry_idnew)->update('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry total.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry total.');
                $this->logger->write_message("error", "Error updating entry total for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/return',$data);
                return;
            }
            $entrystat=array (
                'entry_id'=>$entry_idnew,
                'status'=>"CONFIRM",
				'added_by'=> $this->session->userdata('userid'),
				'confirm_by'=> $this->session->userdata('userid'),
				'confirm_date'=>date('Y-m-d'),
            );
            $this->db->insert('ac_entry_status', $entrystat);
            $rctdata=$this->reciept_model->get_ac_recieptdata($entry_id);
            $reciptdata=array (
                'CNRES'=>$data_narration,
                'CNREFNO'=>$entry_idnew,
                'RCTSTATUS'=>"CANCEL",
                'CNDATE'=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('RCTREFNO', $entry_id)->update('ac_recieptdata', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Receipt Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Receipt Cancelation.');
                $this->logger->write_message("error", "Error updating Receipt Cancelation");
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }
            $reciptdata=array (
                'CHQSTATUS'=>"RT",
                'UPDATEDATE '=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('ENTRYCODE', $entry_id)->update('ac_chqdata', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Cancelation.');
                $this->logger->write_message("error", "Error updating Cheque Cancelation");
                //$this->template->load('template', 'entrymaster/cancel', $data);
                $this->load->view('accounts/entrymaster/return',$data);
                return;
            }

	  $this->db->from('re_prjacincome')->where('entry_id', $entry_id);
        $entry_q = $this->db->get();
        $rowcount = 	$entry_q->num_rows();
        if($rowcount>0){



			$trndata=$this->reciept_model->get_reciepttransaction($entry_id);
			//echo $trndata->rcvmode;
			if($trndata->rcvmode=='CHQ')
			{
				//echo 'inthis';
				//get_ac_incomedata
						 $incomeddata=$this->reciept_model->get_ac_incomedata($entry_id);
						  $bouncedata=array (
						'cus_code'=>$incomeddata->cus_code,
						'can_entry'=>$entry_idnew,
						'income_id'=>$incomeddata->id,
						'entry_no'=>$entry_id,
						'amount'=>get_rate('Cheque Return Amount'),
						'can_date'=>$data_date

					);
					if ( ! $this->db->insert('re_chequecancel', $bouncedata))
					{
						//echo $this->db->last_query();
						$this->db->trans_rollback();
						//$this->messages->add('Error updating Receipt Cancelation.', 'error');
						$this->session->set_flashdata('error', 'Error updating Receipt Cancelation.');
						$this->logger->write_message("error", "Error updating Receipt Cancelation");
						$this->load->view('accounts/entrymaster/return',$data);
						return;
					}
			}


				update_jurnal_entry_cancel($entry_id);
            $update_data = array(
				'rct_no'=>'',
                'entry_id'=>'',
                'pay_status' => 'PENDING',
            );

            if(! $this->db->where('entry_id',$entry_id)->update('re_prjacincome',$update_data))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
                $this->load->view('accounts/entrymaster');
                return;
            }

        }
          //home Module cancelation
		   $this->db->from('hm_prjacincome')->where('entry_id', $entry_id);
        $entry_q = $this->db->get();
        $rowcount = 	$entry_q->num_rows();
        if($rowcount>0){

			if($trndata->rcvmode=='CHQ')
			{
				//echo 'inthis';
				//get_ac_incomedata
						 $incomeddata=$this->reciept_model->get_ac_incomedata($entry_id);
						  $bouncedata=array (
						'cus_code'=>$incomeddata->cus_code,
						'can_entry'=>$entry_idnew,
						'income_id'=>$incomeddata->id,
						'entry_no'=>$entry_id,
						'amount'=>get_rate('Cheque Return Amount'),
						'can_date'=>$data_date

					);
					if ( ! $this->db->insert('re_chequecancel', $bouncedata))
					{
						//echo $this->db->last_query();
						$this->db->trans_rollback();
						//$this->messages->add('Error updating Receipt Cancelation.', 'error');
						$this->session->set_flashdata('error', 'Error updating Receipt Cancelation.');
						$this->logger->write_message("error", "Error updating Receipt Cancelation");
						$this->load->view('accounts/entrymaster/return',$data);
						return;
					}
			}




			hm_update_jurnal_entry_cancel($entry_id);
            $update_data = array(
				'rct_no'=>'',
                'entry_id'=>'',
                'pay_status' => 'PENDING',
            );

            if(! $this->db->where('entry_id',$entry_id)->update('re_prjacincome',$update_data))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
                $this->load->view('accounts/entrymaster');
                return;
            }

        }

            $reciptdata=array (
                'tag'=>"CANCEL",

            );
            if ( ! $this->db->where('entryid', $entry_id)->update('ac_trnreceipts', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Reciept Transaction Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Reciept Transaction Cancelation.');
                $this->logger->write_message("error", "Error updating Reciept Transaction");
                $this->load->view('accounts/entrymaster/return',$data);
                return;
            }

            /* Success */
            $this->db->trans_complete();

			$this->cashadvance_model->delete_defunddata($entry_id);
            $this->session->set_userdata('entry_updated_show_action', TRUE);
            $this->session->set_userdata('entry_updated_id', $entry_id);
            $this->session->set_userdata('entry_updated_type_id', $entry_type_id);
            $this->session->set_userdata('entry_updated_type_label', $current_entry_type['label']);
            $this->session->set_userdata('entry_updated_type_name', $current_entry_type['name']);
            $this->session->set_userdata('entry_updated_number', $data_number);
            if ($data_has_reconciliation)
                $this->session->set_userdata('entry_updated_has_reconciliation', TRUE);
            else
                $this->session->set_userdata('entry_updated_has_reconciliation', FALSE);

            /* Showing success message in show() method since message is too long for storing it in session */
            $this->logger->write_message("success", "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");

            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        //}
        //return;
    }
    function delete($entry_id = 0)
    {
       $entry_type ='Receipt';

//        var_dump($entry_id);
//        die();
        /* Check access */
        if ( ! check_access('delete receipt entry'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
//        var_dump($entry_type_id);
//        die();
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }
        if ( ! $rct_entry = $this->reciept_model->get_reciepttransaction($entry_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.tttt');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }

        $this->db->trans_start();

        $this->db->from('re_prjacincome')->where('entry_id', $entry_id);
        $entry_q = $this->db->get();
        $rowcount = 	$entry_q->num_rows();
//        var_dump($rowcount);
//        die();
        if($rowcount>0){
		update_jurnal_entry_delete($entry_id);
            $update_data = array(
				'rct_no'=>'',
                'entry_id'=>'',
                'pay_status' => 'PENDING',
            );

            if(! $this->db->where('entry_id',$entry_id)->update('re_prjacincome',$update_data))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
                $this->load->view('accounts/entrymaster');
                return;
            }

        }
		// home module cancelateion
		$this->db->from('hm_prjacincome')->where('entry_id', $entry_id);
        $entry_q = $this->db->get();
        $rowcount = 	$entry_q->num_rows();
        if($rowcount>0){
			hm_update_jurnal_entry_delete($entry_id);
            $update_data = array(
				'rct_no'=>'',
                'entry_id'=>'',
                'pay_status' => 'PENDING',
            );

            if(! $this->db->where('entry_id',$entry_id)->update('re_prjacincome',$update_data))
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error updating re_prjacincome.');
                $this->load->view('accounts/entrymaster');
                return;
            }

        }

        if($rct_entry->expendituretype=="CAP"  & $rct_entry->fundtype!=3)
        {

            $projectdata=$this->ac_projects_model->get_project_byprojectid($rct_entry->votenumber);
            $newwal=(float)$projectdata->fund_release-(float)$rct_entry->rcvamount;
            $udate=array('fund_release'=>$newwal);
            if ( ! $this->db->where('prjid', $rct_entry->votenumber)->update('ac_projects', $udate))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating ac_projects table.', 'error');
                $this->session->set_flashdata('error', 'Error updating ac_projects table.');
            }
            //$this->db->where('entryid', $entry_id)->delete('project_grants');
        }
        if ( ! $this->db->delete('ac_trnreceipts', array('entryid' => $entry_id)))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error deleting Entry - Reciept Transaction Entry Delete.', 'error');
            $this->session->set_flashdata('error', 'Error deleting Entry - Reciept Transaction Entry Delete.');
            redirect('accounts/entrymaster');
            return;
        }
		$rctdata=$this->reciept_model->get_ac_recieptdata($entry_id);
            $reciptdata=array (
                'CNRES'=>'Reciept Deleted',
                'RCTREFNO'=>NULL,
                'RCTSTATUS'=>"DELETE",
                'CNDATE'=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('RCTREFNO', $entry_id)->update('ac_recieptdata', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Receipt Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Receipt Cancelation.');
                $this->logger->write_message("error", "Error updating Receipt Cancelation");
                $this->load->view('accounts/entrymaster/cancel',$data);
                return;
            }

        if ( ! $this->db->delete('ac_chqdata', array('ENTRYCODE' => $entry_id)))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error deleting Entry - Reciept  Delete.', 'error');
            $this->session->set_flashdata('error', 'Error deleting Entry - Receipt  Delete.');
            redirect('accounts/entrymaster');
            return;
        }
        if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error deleting Entry - Ledger accounts.', 'error');
            $this->session->set_flashdata('error', 'Error deleting Entry - Ledger accounts.');
            $this->logger->write_message("error", "Error deleting ledger ac_entries for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
            redirect('accounts/entrymaster/view/' . $current_entry_type['label'] . '/' . $entry_id);
            return;
        }
        if ( ! $this->db->delete('ac_entries', array('id' => $entry_id)))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error deleting Entry.', 'error');
            $this->session->set_flashdata('error', 'Error deleting Entry.');
            $this->logger->write_message("error", "Error deleting Entry entry for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
            redirect('accounts/entrymaster/view/' . $current_entry_type['label'] . '/' . $entry_id);
            return;
        }
$this->cashadvance_model->delete_defunddata($entry_id);
        $this->db->trans_complete();
        //$this->messages->add('Deleted ' . $current_entry_type['name'] . ' Entry.', 'success');
        $this->session->set_flashdata('msg', 'Deleted ' . $current_entry_type['name'] . ' Entry.');
        $this->logger->write_message("success", "Deleted " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
        redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
        return;
    }

    function confirm($entry_id = 0)
    {

        $entry_type ='Receipt';
        /* Check access */
        if ( ! check_access('confirm reciept'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }

        $this->db->trans_start();

        $total_rows = $this->db->from('ac_entry_status')->where('entry_id', $entry_id)->get()->num_rows();
        if($total_rows==0)
        {	$entrystat=array (
            'entry_id'=>$entry_id,
            'status'=>"CONFIRM",
			'added_by'=> $this->session->userdata('userid'),
			'confirm_by'=> $this->session->userdata('userid'),
				'confirm_date'=>date('Y-m-d'),
        );
            $this->db->insert('ac_entry_status', $entrystat);
            //$rctdata=$this->reciept_model->get_ac_recieptdata($entry_id);

        }	$entrystat=array (
        'status'=>"CONFIRM",
			'confirm_by'=> $this->session->userdata('userid'),
				'confirm_date'=>date('Y-m-d'),
    );
        if ( ! $this->db->where('entry_id', $entry_id)->update('ac_entry_status', $entrystat))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Entry Confirmation.', 'error');
            $this->session->set_flashdata('error', 'Error updating Entry Confirmation.');
            $this->logger->write_message("error", "Error updating Entry Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            $this->load->view('accounts/entrymaster/cancel',$data);
            return;
        }

        $rctdata=$this->reciept_model->get_ac_recieptdata($entry_id);
        $reciptdata=array (
            'RCTSTATUS'=>"CONFIRM",
        );
        if ( ! $this->db->where('RCTREFNO', $entry_id)->update('ac_recieptdata', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            $this->session->set_flashdata('error', 'Error updating Receipt Confirmation.');
            $this->logger->write_message("error", "Error updating Reciept Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            $this->load->view('accounts/entrymaster/cancel',$data);
            return;
        }
        $this->db->trans_complete();
        //$this->messages->add('Confirmed ' . $current_entry_type['name'] . ' Entry.', 'success');
      //  $this->session->set_flashdata('msg', 'Confirmed ' . $current_entry_type['name'] . ' Entry.');
        $this->logger->write_message("success", "Confirmed " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
        redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
        return;
    }


    function printpreview($entry_type, $entry_id = 0)
    {

        /* Check access */
        if ( ! check_access('print receipt'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/entrymaster/show/all');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }

        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entry_number'] =  $cur_entry->number;
        $data['entry_date'] = date_mysql_to_php_display($cur_entry->date);
        $data['entry_dr_total'] =  $cur_entry->dr_total;
        $data['entry_cr_total'] =  $cur_entry->cr_total;
        $data['entry_narration'] = $cur_entry->narration;

        /* Getting Ledger details */
        $this->db->from('ac_entry_items')->where('entry_id', $entry_id)->order_by('dc', 'desc');
        $ledger_q = $this->db->get();
        $counter = 0;
        $data['ledger_data'] = array();
        if ($ledger_q->num_rows() > 0)
        {
            foreach ($ledger_q->result() as $row)
            {
                $data['ledger_data'][$counter] = array(
                    'id' => $row->ledger_id,
                    'name' => $this->Ledger_model->get_name($row->ledger_id),
                    'dc' => $row->dc,
                    'amount' => $row->amount,
                );
                $counter++;
            }
        }

        $this->load->view('accounts/entrymaster/printpreview', $data);
        return;
    }

//    function printQueue()
//    {
//        if ( ! check_access('print entry'))
//        {
//            $this->messages->add('Permission denied.', 'error');
//            redirect('entrymaster/show/receipt');
//            return;
//        }
//
//
//        $data['tag_id'] = 0;
//        $entry_type_id = 0;
//        $entry_type='receipt';
//
//        $entry_type_id = entry_type_name_to_id($entry_type);
//        $entry_q1 = NULL;
//
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
//        $pagination_counter =1000;// $this->config->item('row_count');
//        $config['num_links'] = 10;
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
//
//        if ($entry_type_id > 0) {
//            $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('RCTSTATUS', 'CONFIRM')->order_by('date', 'desc')->order_by('number')->limit($pagination_counter, $page_count);
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q1 = $this->db->get();
//            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('RCTSTATUS', 'CONFIRM')->order_by('date', 'desc')->order_by('number')->get()->num_rows();
//        }
//        $this->pagination->initialize($config);
//        $data['entry_printdata'] = $entry_q1;
//
//        //$this->template->load('template', 'entrymaster/printqueue', $data);
//        return;
//
//    }

    function printlist()
    {
        $entry_type = 'receipt';
        if ( ! check_access('print receipt'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/entrymaster/show/' . $entry_type);
            return;
        }

        $data['tag_id'] = 0;
        $entry_type_id = 0;
        $entry_type='receipt';
        //$this->template->set('page_title', 'Receipt Print');
        $entry_type_id = entry_type_name_to_id($entry_type);

        if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->join('ac_trnreceipts','ac_trnreceipts.entryid 	=ac_entries.id')->join('ac_chqdata','ac_chqdata.ENTRYCODE=ac_entries.id','left')->where('entry_type', $entry_type_id)->where('RCTSTATUS', 'CONFIRM')->order_by('number');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
        }

        $data['entry_data'] = $entry_q->result();

        $this->load->view('accounts/entrymaster/printpreview', $data);
        return;

    }

	function printreciepts_duplicate($entrynumber)
    {
        $this->load->model('Tag_model');

        if ( ! check_access('print receipt'))
        {
            $this->session->set_flashdata('error', 'Permission denied.');
            //$this->messages->add('Permission denied.', 'error');


            return;
        }
        else
        {
            $data['tag_id'] = 0;
            $entry_type_id = 0;
            $entry_type='receipt';
            //$this->template->set('page_title', 'Receipt Print');
            $entry_type_id = entry_type_name_to_id($entry_type);
            /*Ticket No:2792 Added By Madushan 2021.05.07*/
            $data['payment_mode'] = $this->accresupport_model->get_payment_mode($entrynumber);

            if ($entry_type_id > 0) {
                $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->join('ac_trnreceipts','ac_trnreceipts.entryid 	=ac_entries.id')->join('ac_chqdata','ac_chqdata.ENTRYCODE=ac_entries.id','left')->where('entry_type', $entry_type_id)->where('id', $entrynumber)->order_by('number');
                //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
                $entry_q = $this->db->get();
            }
			 if ($entry_type_id > 0) {
               $this->db->select('SUM(ac_entry_items.amount)as amount,ac_entry_items.dc,ac_ledgers.name,ac_entry_items.ledger_id')->join('ac_ledgers','ac_ledgers.id=ac_entry_items.ledger_id')->where('entry_id', $entrynumber)->group_by('ac_entry_items.ledger_id');
                //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
                $ledgers = $this->db->get('ac_entry_items');
            }
			$entry_data = $entry_q->result();
			$module='C';
			foreach ($entry_data as $row)
			{
				$module= $row->module;
			}
			if($module=='R'){
					$data['incomdedata'] = $incomdedata=$this->accresupport_model->get_incomes_by_entryid($entrynumber);
					if($incomdedata){
							$fulldata=NULL;
							$loanbalancedata=NULL;
							$advcount=0;
						$data['branchdata']=$this->accresupport_model->get_branchdata_bycode($incomdedata->branch_code);
					//	//echo  $incomdedata->income_type;
					$res_code='';
						if($incomdedata->income_type=='Rental Payment' || $incomdedata->income_type=='EP Settlement' )
						{
							$data['fulldata']=$fulldata=$this->accresupport_model->get_eploan_data($incomdedata->temp_code);
							$loanbalancedata=$this->accresupport_model->get_recipt_loan_data($incomdedata->temp_code,$fulldata->loan_type,$fulldata->reschdue_sqn,$fulldata->loan_amount,$fulldata->montly_rental,$incomdedata->income_date);
							$res_code=$fulldata->res_code;
						}
						else
						{
							$advcount=$this->accresupport_model->get_advance_count($incomdedata->temp_code);

							$data['fulldata']=$fulldata=$this->accresupport_model->get_all_reservation_details_bycode($incomdedata->temp_code);
							$res_code=$fulldata->res_code;

						}
						$cus_code=get_reciept_customer($res_code);
						$data['cusdata']=$cusdata=$this->accresupport_model->get_customer_bycode($cus_code);

						$data['loanbalancedata']=$loanbalancedata;
						 $data['advcount']=$advcount;
						$data['resdata']=$this->accresupport_model->get_customer_bycode($incomdedata->cus_code);
						$data['entry_data']=$entry_data = $entry_q->result();
						 $data['ledgers'] = $ledgers->result();
						 $data['mobile'] =  $mobile=$cusdata->mobile;

						  $data['number']=$number="";
						   $data['message'] ="";
						 if($mobile){
						$mobarr=explode('/', $mobile);
						$data['number']=$number="";
						if($mobile!='')
							 $data['number']=$number=$mobarr[0];
							  $data['message'] =  $message="";
							if($fulldata){
								  $data['message'] =  $message='Thank you for your payment of LKR '.number_format($incomdedata->amount,2).' made to '.$fulldata->project_name.' Land Block number '.$fulldata->lot_number.' on '.date('d-M-Y H:i:s');
								}
						 }
						  //$data['number2'] =  $number=$mobarr[0];
              //updated by nadee ticket number 2022
        $data['second_cus']=Null;
        if($fulldata->cus_code2!="")
        {
          $cus2data=$this->accresupport_model->get_customer_bycode($fulldata->cus_code2);
          $data['second_cus']=$cus2data;
        }


					$data['entrynumber'] = $entrynumber;
				//echo  $this->session->userdata('branchid');
					$this->load->view('accounts/entrymaster/printreciepts_duplicate', $data);
					}
			}
			
			else
			{
					 $data['entry_data'] = $entry_q->result();
					 $data['ledgers'] = $ledgers->result();
						$data['entrynumber'] = $entrynumber;
           			 $this->load->view('accounts/entrymaster/printreciepts_other_duplicate', $data);
			}
            return;
        }

    }

    function printreciepts($entrynumber)
    {
        $this->load->model('Tag_model');

        if ( ! check_access('print receipt'))
        {
            $this->session->set_flashdata('error', 'Permission denied.');
            //$this->messages->add('Permission denied.', 'error');


            return;
        }
        else
        {
            $data['tag_id'] = 0;
            $entry_type_id = 0;
            $entry_type='receipt';
            //$this->template->set('page_title', 'Receipt Print');
            $entry_type_id = entry_type_name_to_id($entry_type);
            /*Ticket No:2792 Added by Madushan 2021-05-07*/
            $data['payment_mode'] = $this->accresupport_model->get_payment_mode($entrynumber);

            if ($entry_type_id > 0) {
                $this->db->from('ac_entries')->join('ac_recieptdata','ac_recieptdata.RCTREFNO=ac_entries.id')->join('ac_trnreceipts','ac_trnreceipts.entryid 	=ac_entries.id')->join('ac_chqdata','ac_chqdata.ENTRYCODE=ac_entries.id','left')->where('entry_type', $entry_type_id)->where('id', $entrynumber)->order_by('number');
                //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
                $entry_q = $this->db->get();
            }
			 if ($entry_type_id > 0) {
                $this->db->select('SUM(ac_entry_items.amount)as amount,ac_ledgers.name,ac_entry_items.dc,ac_entry_items.ledger_id')->join('ac_ledgers','ac_ledgers.id=ac_entry_items.ledger_id')->where('entry_id', $entrynumber)->group_by('ac_entry_items.ledger_id');
                //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
                $ledgers = $this->db->get('ac_entry_items');
            }
			$entry_data = $entry_q->result();
			$module='C';
			foreach ($entry_data as $row)
			{
				$module= $row->module;
			}
			if($module=='R'){
					$data['incomdedata'] = $incomdedata=$this->accresupport_model->get_incomes_by_entryid($entrynumber);
					if($incomdedata){
							$fulldata=NULL;
							$loanbalancedata=NULL;
							$advcount=0;
						$data['branchdata']=$this->accresupport_model->get_branchdata_bycode($incomdedata->branch_code);
					//	//echo  $incomdedata->income_type;
					$res_code='';
						if($incomdedata->income_type=='Rental Payment' || $incomdedata->income_type=='EP Settlement' )
						{
							$data['fulldata']=$fulldata=$this->accresupport_model->get_eploan_data($incomdedata->temp_code);
							$loanbalancedata=$this->accresupport_model->get_recipt_loan_data($incomdedata->temp_code,$fulldata->loan_type,$fulldata->reschdue_sqn,$fulldata->loan_amount,$fulldata->montly_rental,$incomdedata->income_date);
							$res_code=$fulldata->res_code;
						}
						else
						{
							$advcount=$this->accresupport_model->get_advance_count($incomdedata->temp_code);

							$data['fulldata']=$fulldata=$this->accresupport_model->get_all_reservation_details_bycode($incomdedata->temp_code);
							$res_code=$fulldata->res_code;

						}
						$cus_code=get_reciept_customer($res_code);
						$data['cusdata']=$cusdata=$this->accresupport_model->get_customer_bycode($cus_code);

						$data['loanbalancedata']=$loanbalancedata;
						 $data['advcount']=$advcount;
						$data['resdata']=$this->accresupport_model->get_customer_bycode($incomdedata->cus_code);
						$data['entry_data']=$entry_data = $entry_q->result();
						 $data['ledgers'] = $ledgers->result();
						 $data['mobile'] =  $mobile=$cusdata->mobile;

						  $data['number']=$number="";
						   $data['message'] ="";
						 if($mobile){
						$mobarr=explode('/', $mobile);
						$data['number']=$number="";
						if($mobile!='')
							 $data['number']=$number=$mobarr[0];
							  $data['message'] =  $message="";
							if($fulldata){
								  $data['message'] =  $message='Thank you for your payment of LKR '.number_format($incomdedata->amount,2).' made to '.$fulldata->project_name.' Land Block number '.$fulldata->lot_number.' on '.date('d-M-Y H:i:s');
								}
						 }
						  //$data['number2'] =  $number=$mobarr[0];
              //updated by nadee ticket number 2022
        $data['second_cus']=Null;
        if($fulldata->cus_code2!="")
        {
          $cus2data=$this->accresupport_model->get_customer_bycode($fulldata->cus_code2);
          $data['second_cus']=$cus2data;
        }


					$data['entrynumber'] = $entrynumber;
				//echo  $this->session->userdata('branchid');
					$this->load->view('accounts/entrymaster/printreciepts', $data);
					}
			}
			
			else
			{
					 $data['entry_data'] = $entry_q->result();
					 $data['ledgers'] = $ledgers->result();
						$data['entrynumber'] = $entrynumber;
           			 $this->load->view('accounts/entrymaster/printreciepts_other', $data);
			}
            return;
        }

    }
	function update_print($entryid)
    {
        $reciptdata=array (
            'RCTSTATUS'=>"PRINT",
        );
        if ( ! $this->db->where('RCTREFNO', $entryid)->update('ac_recieptdata', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            $this->session->set_flashdata('error', 'Error updating Receipt Confirmation.');
            $this->logger->write_message("error", "Error updating Receipt Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            $this->load->view('accounts/entrymaster/cancel',$data);
            return;
        }
        $this->db->trans_complete();
        //$this->messages->add('Receipt Queue Printed Successfuly', 'success');
        $this->session->set_flashdata('msg', 'Receipt  Printed Successfuly');
        $this->logger->write_message("success", "Receipt Queue Printed Successfuly");
        redirect('accounts/entrymaster/');


    }
	function cancel_print($entryid)
    {
        $reciptdata=array (
            'RCTSTATUS'=>"PRINT",
        );
        if ( ! $this->db->where('RCTREFNO', $entryid)->update('ac_recieptdata', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            $this->session->set_flashdata('error', 'Error updating Receipt Confirmation.');
            $this->logger->write_message("error", "Error updating Receipt Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            $this->load->view('accounts/entrymaster/cancel',$data);
            return;
        }
        $this->db->trans_complete();
        //$this->messages->add('Receipt Queue Printed Successfuly', 'success');
        $this->session->set_flashdata('error', 'Receipt Queue Printed Successfuly');
        $this->logger->write_message("success", "Receipt Queue Printed Successfuly");
        redirect('accounts/entrymaster/');


    }

    function updateprintlist()
    {
        $reciptdata=array (
            'RCTSTATUS'=>"PRINT",
        );
        if ( ! $this->db->where('RCTSTATUS', "CONFIRM")->update('ac_recieptdata', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            $this->session->set_flashdata('error', 'Error updating Receipt Confirmation.');
            $this->logger->write_message("error", "Error updating Receipt Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            $this->load->view('accounts/entrymaster/cancel',$data);
            return;
        }
        $this->db->trans_complete();
        //$this->messages->add('Receipt Queue Printed Successfuly', 'success');
        $this->session->set_flashdata('error', 'Receipt Queue Printed Successfuly');
        $this->logger->write_message("success", "Receipt Queue Printed Successfuly");
        redirect('accounts/entrymaster/');


    }

    function addrow($add_type = 'all')
    {
        $i = time() + rand  (0, time()) + rand  (0, time()) + rand  (0, time());
        $dr_amount = array(
            'name' => 'dr_amount[' . $i . ']',
            'id' => 'dr_amount[' . $i . ']',
            'maxlength' => '15',
            'size' => '15',
            'value' => '',
            'class' => 'dr-item',
            'disabled' => 'disabled',
        );
        $cr_amount = array(
            'name' => 'cr_amount[' . $i . ']',
            'id' => 'cr_amount[' . $i . ']',
            'maxlength' => '15',
            'size' => '15',
            'value' => '',
            'class' => 'cr-item',
            'disabled' => 'disabled',
        );

        echo '<tr class="new-row">';
        echo '<td>';
        echo form_dropdown_dc('ledger_dc[' . $i . ']');
        echo '</td>';

        echo '<td>';
        if ($add_type == 'bankcash')
            echo form_input_ledger('ledger_id[' . $i . ']', 0, '', $type = 'bankcash');
        else if ($add_type == 'nobankcash')
            echo form_input_ledger('ledger_id[' . $i . ']', 0, '', $type = 'nobankcash');
        else
            echo form_input_ledger('ledger_id[' . $i . ']');
        echo '</td>';

        echo '<td>';
        echo form_input($dr_amount);
        echo '</td>';
        echo '<td>';
        echo form_input($cr_amount);
        echo '</td>';
        echo '<td>';
        echo img(array('src' => asset_url() . "images/icons/add.png", 'border' => '0', 'alt' => 'Add Ledger', 'class' => 'addrow'));
        echo '</td>';
        echo '<td>';
        echo img(array('src' => asset_url() . "images/icons/delete.png", 'border' => '0', 'alt' => 'Remove Ledger', 'class' => 'deleterow'));
        echo '</td>';
        echo '<td class="ledger-balance"><div></div>';
        echo '</td>';
        echo '</tr>';
        return;
    }

    function search()
    {
        $entry_type='receipt';
        //$search=$this->input->post('search');
        $amountsearch=$this->input->post('amountsearch');
       $receipt_no=$this->input->post('receipt_no');
        $payment_mode=$this->input->post('payment_mode');
//        var_dump($amountsearch,$receipt_no);
//        die();


        $data['tag_id'] = 0;
        $entry_type_id = 0;

        if ($entry_type == 'tag')
        {
            $tag_id = (int)$this->uri->segment(4);
            if ($tag_id < 1)
            {
                //$this->messages->add('Invalid Tag.', 'error');
                $this->session->set_flashdata('error', 'Invalid Tag.');
                redirect('accounts/entrymaster/show/all');
                return;
            }
            $data['tag_id'] = $tag_id;
            $tag_name = $this->Tag_model->tag_name($tag_id);
            //$this->template->set('page_title', 'ac_entries Tagged "' . $tag_name . '"');
        } else if ($entry_type == 'all') {
            $entry_type_id = 0;
            //$this->template->set('page_title', 'All ac_entries');
        } else {
            $entry_type_id = entry_type_name_to_id($entry_type);
            if ( ! $entry_type_id)
            {
                //$this->messages->add('Invalid Entry type specified. Showing all ac_entries.', 'error');
                $this->session->set_flashdata('error', 'Invalid Entry type specified. Showing all ac_entries.');
                redirect('accounts/entrymaster/show/all');
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

        $siteurl='accounts/entrymaster/search';
        $type_id='1';
        $pagination_counter =RAW_COUNT;
        $this->pagination_entries($page_count,$siteurl,$type_id);

        /* Pagination configuration */
        if ($entry_type == 'tag')
        {
            $config['base_url'] = site_url('accounts/entrymaster/show/tag' . $tag_id);
            $config['uri_segment'] = 5;
        } else if ($entry_type == 'all') {
            $config['base_url'] = site_url('accounts/entrymaster/show/all');
            $config['uri_segment'] = 4;
        } else {
            $config['base_url'] = site_url('accounts/entrymaster/show/' . $current_entry_type['label']);
            $config['uri_segment'] = 4;
        }



		if($amountsearch!="" )

            $amountsearch=number_format($amountsearch, 2, '.', '');
			//echo $this->input->post('trn');
        //$amount=$this->input->post('amount');
		 $bank=$this->input->post('bank_data');
		$chequesearch=false;
		if($this->input->post('chq_rtn')=='YES')
		$chequesearch=true;
		if($this->input->post('chq')=='YES')
		$chequesearch=true;
		if(!$chequesearch)
		{
			$trnarr=array('NULL','');
			$this->db->select('ac_entries.id,ac_entries.date,ac_entries.tag_id,ac_entries.cr_total,ac_entries.number,ac_entries.entry_type,ac_recieptdata.RCTNO,ac_recieptdata.RCTSTATUS,ac_recieptdata.CNBY,ac_recieptdata.CRBY,ac_trnreceipts.rcvmode,ac_trnreceipts.temp_rctno,ac_chqdata.CHQNO,cm_banklist.BANKNAME,ac_chqdata.BRNNAME,ac_chqdata.CHQSTATUS');
		 $this->db->from('ac_recieptdata');
	//	  $this->db->where('entry_type', $entry_type_id);
		  $this->db->join('ac_entries','ac_entries.id=ac_recieptdata.RCTREFNO','left');
		   $this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id and ac_entry_items.dc="D"','left');
		    $this->db->join('ac_trnreceipts','ac_entries.id=ac_trnreceipts.entryid','left');
			$this->db->join('ac_chqdata','ac_entries.id=ac_chqdata.ENTRYCODE','left');
				 $this->db->join('cm_banklist','cm_banklist.BANKCODE=ac_chqdata.BNKNAME','left');
		  //date Search
		if($this->input->post('fromdate') != '' && $this->input->post('todate') != ''){
			$this->db->where('ac_entries.date >=',$this->input->post('fromdate'));
			$this->db->where('ac_entries.date <=',$this->input->post('todate'));
		}
		  if($amountsearch!="" )
		  $this->db->where('dr_total',$amountsearch);
		 if($this->input->post('trn')=='YES')
		 {
		   $this->db->where('ac_trnreceipts.temp_rctno !=','NULL');
		    $this->db->where('ac_trnreceipts.temp_rctno !=','');
		 }

         //Ticket No:3117 Added By Madushan 2021-07-16
          if($payment_mode != 'all'){
             $this->db->where('ac_trnreceipts.rcvmode',$payment_mode);
             if($receipt_no == "" && $amountsearch == "" && $this->input->post('fromdate') == '' && $this->input->post('todate') == '' && $this->input->post('trn')!='YES' ){
                    $this->db->limit(100);
             }
         }

		  if($receipt_no!="" )
			$this->db->Like('RCTNO',$receipt_no);
			if($bank!='ALL')
			{
				  $this->db->where('ac_entry_items.ledger_id',$bank);
			}
			$this->db ->order_by('date', 'desc');
		   $this->db->order_by('number', 'desc');
		}
		else
		{
			$this->db->select('ac_entries.id,ac_entries.date,ac_entries.tag_id,ac_entries.cr_total,ac_entries.number,ac_entries.entry_type,ac_recieptdata.RCTNO,ac_recieptdata.RCTSTATUS,ac_recieptdata.CNBY,ac_recieptdata.CRBY,ac_trnreceipts.rcvmode,ac_trnreceipts.temp_rctno,ac_chqdata.CHQNO,cm_banklist.BANKNAME,ac_chqdata.BRNNAME,ac_chqdata.CHQSTATUS');
			$this->db->from('ac_chqdata');
			 $this->db->join('ac_entries','ac_entries.id=ac_chqdata.ENTRYCODE');
			  $this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id and ac_entry_items.dc="D"','left');

		  $this->db->where('entry_type', $entry_type_id);
		  $this->db->join('ac_recieptdata','ac_entries.id=ac_recieptdata.RCTREFNO');
		    $this->db->join('ac_trnreceipts','ac_entries.id=ac_trnreceipts.entryid');
			 $this->db->join('cm_banklist','cm_banklist.BANKCODE=ac_chqdata.BNKNAME','left');
		//date Search
		if($this->input->post('fromdate') != '' && $this->input->post('todate') != ''){
			$this->db->where('ac_entries.date >=',$this->input->post('fromdate'));
			$this->db->where('ac_entries.date <=',$this->input->post('todate'));
		}
		//	BNKCODE
		  if($amountsearch!="" )
		  $this->db->where('dr_total',$amountsearch);
		 if($this->input->post('trn')=='YES')
		   $this->db->where('ac_trnreceipts.temp_rctno !=','NULL');
		    if($this->input->post('chq_rtn')=='YES')
		   $this->db->where('ac_chqdata.CHQSTATUS','RT');
		     if($this->input->post('chq')=='YES')
			   $this->db->where('ac_chqdata.CHQSTATUS','PD');
		  if($receipt_no!="" )
			$this->db->Like('RCTNO',$receipt_no);

			if($bank!='ALL')
			{
				  $this->db->where('ac_entry_items.ledger_id',$bank);
			}
			$this->db ->order_by('date', 'desc');
		   $this->db->order_by('number', 'desc');
		   //$this->db->limit(30,0);
		}
            $entry_q = $this->db->get();
         	if ($entry_q->num_rows() < 1){
				 //$this->messages->add('Receipt number not exist ', 'error');
                $this->session->set_flashdata('error', 'Receipt number not exist ');
               // redirect('accounts/entrymaster');
              //  return;
			}




        $data['entry_data'] = $entry_q;
		$data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();

        //$this->template->load('template', 'entrymaster/search', $data);
        $this->load->view('accounts/entrymaster/search',$data);
        return;

    }

	function get_advanceledger()
	{
		$drldger=$this->uri->segment(4);
		$crldger=$this->uri->segment(5);
		$amount=$this->uri->segment(6);

					$data['ledger_dc'][0] = "D";
                    $data['ledger_id'][0] = $drldger;
            	  	 $data['dr_amount'][0] = $amount;
              		  $data['cr_amount'][0] = "";

					  $data['ledger_dc'][1] = "C";
                    $data['ledger_id'][1] = $crldger;
            	  	 $data['dr_amount'][1] ="";
              		  $data['cr_amount'][1] =  $amount;

                  $this->load->view('accounts/entrymaster/add_advancelist',$data);
	}
}



/* End of file entry.php */
/* Location: ./system/application/controllers/entry.php */
