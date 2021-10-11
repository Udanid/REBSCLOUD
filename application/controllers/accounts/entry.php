<?php
//modications done by Udani - Function :-add() Edit()  Date : 11-09-2013

class Entry extends CI_Controller {

	function Entry()
	{
		 parent::__construct();
		$this->load->model('Entry_model');
		$this->load->model('Ledger_model');
		$this->load->model('Tag_model');
		$this->load->model('ac_projects_model');
		$this->load->model('common_model');
		$this->load->model('lotdata_model');
		$this->load->model('project_model');
		$this->load->model('projectpayment_model');
		$this->load->model('projectpayment_model');
			$this->load->model('accresupport_model');
		

		$this->load->model("report_model");//2020-03-02

		$this->is_logged_in();
		return;
	}

	function index($type)
	{
		redirect('accounts/entry/show/'.$type);
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
				$this->session->set_flashdata('error', 'Invalid Tag.');
				redirect('accounts/entry/show/all');
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
				redirect('accounts/entry/show/all');
				return;
			} else {
				$current_entry_type = entry_type_info($entry_type_id);
				//$this->template->set('page_title', $current_entry_type['name'] . ' ac_entries');
				//if($current_entry_type['label']=='journal' || $current_entry_type['label']=='recon' )
				//$this->template->set('nav_links', array('entry/add/' . $current_entry_type['label'] => 'New ' . $current_entry_type['name'] . ' Entry'));
				//if($current_entry_type['label']=='cancel')
				//$this->template->set('nav_links', array('entry/add/' . $current_entry_type['label'] => 'Previous Year Payment Cancelation '));
			}
		}

		$entry_q = NULL;

		/* Pagination setup */
		$this->load->library('pagination');

		if ($entry_type == "tag")
			$page_count = (int)$this->uri->segment(6);
		else
			$page_count = (int)$this->uri->segment(5);

		if ( ! $page_count)
			$page_count = "0";

		$siteurl='accounts/entry/show/journal';
		$type_id='1';
		$pagination_counter =RAW_COUNT;
		$this->pagination_entries($page_count,$siteurl,$type_id);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		/* Pagination configuration */
		if ($entry_type == 'tag')
		{
			$config['base_url'] = site_url('accounts/entry/show/tag' . $tag_id);
			$config['uri_segment'] = 5;
		} else if ($entry_type == 'all') {
			$config['base_url'] = site_url('accounts/entry/show/all');
			$config['uri_segment'] = 4;
		} else {
			$config['base_url'] = site_url('accounts/entry/show/' . $current_entry_type['label']);
			$config['uri_segment'] = 5;
		}
		$pagination_counter = $this->config->item('row_count');
		$config['num_links'] = 10;
		$config['per_page'] = 20;
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
		
		if ($entry_type == "tag") {
			$this->db->from('ac_entries')->where('tag_id', $tag_id)->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('ac_entries.id', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
			$entry_q = $this->db->get();
			$config['total_rows'] = $this->db->from('ac_entries')->where('tag_id', $tag_id)->get()->num_rows();
		} else if ($entry_type_id > 0) {
			
			//$this->db->from('ac_entries')->where('entry_type', $entry_type_id)->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('number', 'desc');
			$entry_q = $this->Entry_model->get_journal($entry_type_id,$config['per_page'] ,$page);
			$config['total_rows'] = $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->get()->num_rows();
//			var_dump($entry_q);
//			die();
		} else {

			$this->db->from('ac_entries')->order_by('date', 'desc')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
			$entry_q = $this->db->get();
			$config['total_rows'] = $this->db->count_all('ac_entries');
		}

		/* Pagination initializing */


		/* Show entry add actions */
		if ($this->session->userdata('entry_added_show_action'))
		{
			$entry_added_id_temp = $this->session->userdata('entry_added_id');
			$entry_added_type_id_temp = $this->session->userdata('entry_added_type_id');
			$entry_added_type_label_temp = $this->session->userdata('entry_added_type_label');
			$entry_added_type_name_temp = $this->session->userdata('entry_added_type_name');
			$entry_added_number_temp = $this->session->userdata('entry_added_number');
			$entry_added_message = 'Added ' . $entry_added_type_name_temp . ' Entry number ' . full_entry_number($entry_added_type_id_temp, $entry_added_number_temp) . ".";
			
			//$this->messages->add($entry_added_message, 'success');
			$this->session->set_flashdata('msg', $entry_added_message);
			$this->session->unset_userdata('entry_added_show_action');
			$this->session->unset_userdata('entry_added_id');
			$this->session->unset_userdata('entry_added_type_id');
			$this->session->unset_userdata('entry_added_type_label');
			$this->session->unset_userdata('entry_added_type_name');
			$this->session->unset_userdata('entry_added_number');
		}

		/* Show entry edit actions */
		if ($this->session->userdata('entry_updated_show_action'))
		{
			$entry_updated_id_temp = $this->session->userdata('entry_updated_id');
			$entry_updated_type_id_temp = $this->session->userdata('entry_updated_type_id');
			$entry_updated_type_label_temp = $this->session->userdata('entry_updated_type_label');
			$entry_updated_type_name_temp = $this->session->userdata('entry_updated_type_name');
			$entry_updated_number_temp = $this->session->userdata('entry_updated_number');
			$entry_updated_message = 'Updated ' . $entry_updated_type_name_temp . ' Entry number ' . full_entry_number($entry_updated_type_id_temp, $entry_updated_number_temp) . ".";
			
			//$this->messages->add($entry_updated_message, 'success');
			$this->session->set_flashdata('msg', $entry_updated_message);

			if ($this->session->userdata('entry_updated_has_reconciliation'))
				//$this->messages->add('Previous reconciliations for this entry are no longer valid. You need to redo the reconciliations for this entry.', 'success');
			$this->session->set_flashdata('msg', 'Previous reconciliations for this entry are no longer valid. You need to redo the reconciliations for this entry.');

			$this->session->unset_userdata('entry_updated_show_action');
			$this->session->unset_userdata('entry_updated_id');
			$this->session->unset_userdata('entry_updated_type_id');
			$this->session->unset_userdata('entry_updated_type_label');
			$this->session->unset_userdata('entry_updated_type_name');
			$this->session->unset_userdata('entry_updated_number');
			$this->session->unset_userdata('entry_updated_has_reconciliation');
		}
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		$data['entry_data'] = $entry_q;
		$data['entry_type_id'] = $entry_type_id;
		$data['entry_type'] = $entry_type;
//		var_dump($data['entry_data']);
//		die();
		$data['prjlist']=$this->projectpayment_model->get_all_payto_projectlist($this->session->userdata('branchid'));
		$data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();
		//$this->template->load('template', 'entry/index', $data);
		$this->load->view('accounts/entry/index',$data);
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
			redirect('accounts/entry/show/all');
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
			redirect('accounts/entry/show/' . $current_entry_type['label']);
			return;
		}
		/* Load current entry details */
		$this->db->from('ac_entry_items')->where('ac_entry_items.entry_id', $entry_id)->order_by('ac_entry_items.id', 'asc');
		$cur_entry_ac_ledgers = $this->db->get();
		if ($cur_entry_ac_ledgers->num_rows() < 1)
		{
			//$this->messages->add('Entry has no associated Ledger accounts.', 'error');
			$this->session->set_flashdata('error', 'Entry has no associated Ledger accounts.');
		}
		$data['project'] = $this->Entry_model->get_project_deials_by_id($cur_entry->prj_id);
		$data['cur_entry'] = $cur_entry;
		$data['cur_entry_ac_ledgers'] = $cur_entry_ac_ledgers;
		$data['entry_type_id'] = $entry_type_id;
		$data['current_entry_type'] = $current_entry_type;
		//$this->template->load('template', 'entry/view', $data);
		$this->load->view('accounts/entry/view',$data);
		return;
	}

	function add($entry_type)
	{
		/* Check access */
		if ( ! check_access('create entry'))
		{
			//$this->messages->add('Permission denied.', 'error');
			$this->session->set_flashdata('error', 'Permission denied.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			//$this->messages->add('Account is locked.', 'error');
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		//2020-03-02 Ticket 1200  Bilani
		$data['prjlist']=$this->Entry_model->get_all_project_confirmed($this->session->userdata('branchid'));

		//$this->template->set('page_title', 'New ' . $current_entry_type['name'] . ' Entry');
		$data['subac_projects']=$this->ac_projects_model->get_all__sub_ac_projects();
		$data['subprjid']='';
		/* Form fields */
		$data['entry_number'] = array(
			'name' => 'entry_number',
			'id' => 'entry_number',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);
		$data['cheque_no'] = array(
			'name' => 'cheque_no',
			'id' => 'cheque_no',
			'maxlength' => '11',
			'size' => '11',
			'value' => '',
		);
		$data['entry_date'] = array(
			'name' => 'entry_date',
			'id' => 'entry_date',
			'maxlength' => '11',
			'size' => '11',
			'value' => date_today_php(),
		);
		$data['entry_narration'] = array(
			'name' => 'entry_narration',
			'id' => 'entry_narration',
			'cols' => '50',
			'rows' => '4',
			'value' => '',
		);
		$data['entry_type_id'] = $entry_type_id;
		$data['current_entry_type'] = $current_entry_type;
		$data['entry_ac_tags'] = $this->Tag_model->get_all_ac_tags();
		$data['entry_tag'] = 0;

		/* Form validations */
//			if($entry_type=="cancel")
//			{
//				$this->form_validation->set_rules('cheque_no', 'Cheque Number', 'trim|required');
//			}
//		if ($current_entry_type['numbering'] == '2')
//			$this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|required|is_natural_no_zero|uniqueentryno[' . $entry_type_id . ']');
//		else if ($current_entry_type['numbering'] == '3')
//			$this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|is_natural_no_zero|uniqueentryno[' . $entry_type_id . ']');
//		else
//			$this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|is_natural_no_zero|uniqueentryno[' . $entry_type_id . ']');
//		$this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//		$this->form_validation->set_rules('entry_narration', 'trim');
//		$this->form_validation->set_rules('entry_tag', 'Tag', 'trim|is_natural');

		/* Debit and Credit amount validation */
		if ($_POST)
		{
			foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
			{
//				$this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
//				$this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
			}
		}

		/* Repopulating form */
		if ($_POST)
		{
			$data['entry_number']['value'] = $this->input->post('entry_number', TRUE);
			$data['entry_date']['value'] = $this->input->post('entry_date', TRUE);
			$data['entry_narration']['value'] = $this->input->post('entry_narration', TRUE);
			$data['entry_tag'] = $this->input->post('entry_tag', TRUE);

			$data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
			$data['ledger_id'] = $this->input->post('ledger_id', TRUE);
			$data['dr_amount'] = $this->input->post('dr_amount', TRUE);
			$data['cr_amount'] = $this->input->post('cr_amount', TRUE);
		} else {
			for ($count = 0; $count <= 3; $count++)
			{
				if ($count == 0 && $entry_type == "payment")
					$data['ledger_dc'][$count] = "C";
				else if ($count == 1 && $entry_type != "payment")
					$data['ledger_dc'][$count] = "C";
				else
					$data['ledger_dc'][$count] = "D";
				 if ($count == 0 && $entry_type == "cancel")
				 {
					$data['ledger_id'][$count] = "BA11070100";
					//echo $entry_type ;
				 }
					else
					$data['ledger_id'][$count] = 0;
					
				$data['dr_amount'][$count] = "";
				$data['cr_amount'][$count] = "";
				if ($count == 1 && $entry_type == "recon"){
					$data['ledger_id'][$count] = $this->uri->segment(5);
				}
			}
		}

//		if ($this->form_validation->run() == FALSE)
//		{
//			$this->messages->add(validation_errors(), 'error');
//			$this->template->load('template', 'entry/add', $data);
//			return;
//		}
//		else
//		{
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
						//$this->template->load('template', 'entry/add', $data);
						$this->load->view('accounts/entry/add', $data);
						return;
					} else {
						/* Check for valid ledger type */
						$valid_ledger = $valid_ledger_q->row();
						
						
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
				//$this->template->load('template', 'entry/add', $data);
				$this->load->view('accounts/entry/add',$data);
				return;
			} else if (float_ops($dr_total, 0, '==') && float_ops($cr_total, 0, '==')) {
				//echo $dr_total;
				//$this->messages->add('Cannot save empty Entry.', 'error');
				$this->session->set_flashdata('error', 'Cannot save empty Entry.');
				//$this->template->load('template', 'entry/add', $data);
				$this->load->view('accounts/entry/add',$data);
				return;
			}
			/* Check if atleast one Bank or Cash Ledger account is present */
			/*if ($current_entry_type['bank_cash_ledger_restriction'] == '2')
			{
				if ( ! $bank_cash_present)
				{
					//$this->messages->add('Need to Debit atleast one Bank or Cash account.', 'error');
					$this->session->set_flashdata('error', 'Need to Debit atleast one Bank or Cash account.');
					//$this->template->load('template', 'entry/add', $data);
					$this->load->view('accounts/entry/add',$data);
					return;
				}
				if ( ! $non_bank_cash_present)
				{
					//$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
					$this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');
					//$this->template->load('template', 'entry/add', $data);
					$this->load->view('accounts/entry/add',$data);
					return;
				}
			} else if ($current_entry_type['bank_cash_ledger_restriction'] == '3')
			{
				if ( ! $bank_cash_present)
				{
					//$this->messages->add('Need to Credit atleast one Bank or Cash account.', 'error');
					$this->session->set_flashdata('error', 'Need to Credit atleast one Bank or Cash account.');
					//$this->template->load('template', 'entry/add', $data);
					$this->load->view('accounts/entry/add',$data);
					return;
				}
				if ( ! $non_bank_cash_present)
				{
					//$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
					$this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');
					//$this->template->load('template', 'entry/add', $data);
					$this->load->view('accounts/entry/add',$data);
					return;
				}
			}*/

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
			$data_date = $data_date; // Converting date to MySQL
			$entry_id = NULL;

			//Ticket 1200 Bilani 2020-03-03
			$data_prj_id = $this->input->post('prj_id', TRUE);
			$data_lot_id = $this->input->post('lot_id', TRUE);
			
			if($data_prj_id==""){
				$data_prj_id=0;
			}
			if($data_lot_id==""){
			 	$data_lot_id=0;
			}
			//Ticket 1200 Bilani 2020-03-03 -end

			$this->db->trans_start();
			$insert_data = array(
				'number' => $data_number,
				'date' => $data_date,
				'narration' => $data_narration,
				'entry_type' => $data_type,
				'tag_id' => $data_tag,
				'prj_id' => $data_prj_id,//Ticket 1200 Bilani 2020-03-03
				'lot_id' => $data_lot_id,//Ticket 1200 Bilani 2020-03-03
			);


			if ( ! $this->db->insert('ac_entries', $insert_data))
			{
				$this->db->trans_rollback();
				//$this->messages->add('Error adding Entry.', 'error');
				$this->session->set_flashdata('error', 'Error adding Entry.');
				$this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed inserting entry");
				//$this->template->load('template', 'entry/add', $data);

				$this->load->view('accounts/entry/add',$data);
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
					//echo $data_ledger_id ;
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
					$this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed inserting entry ledger item " . "[id:" . $data_ledger_id . "]");
					//$this->template->load('template', 'entry/add', $data);
					$this->load->view('accounts/entry/add',$data);
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
				$this->logger->write_message("error", "Error adding " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
				//$this->template->load('template', 'entry/add', $data);
				$this->load->view('accounts/entry/add',$data);
				return;
			}
			$insert_status = array(
				'entry_id' => $entry_id,
				'status' => 'PENDING',
				'added_by'=> $this->session->userdata('userid'),
				
			);
			if ( ! $this->db->insert('ac_entry_status', $insert_status))
			{
				$this->db->trans_rollback();
				//$this->messages->add('Error Inserting Entry Status.', 'error');
				$this->session->set_flashdata('error', 'Error Inserting Entry Status.');
				$this->logger->write_message("error", "Error Entry Status " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " since failed updating debit and credit total");
				//$this->template->load('template', 'entry/add', $data);
				$this->load->view('accounts/entry/add',$data);
				return;
			}
			if($entry_type=="cancel")
			{
				$cheque_no=$this->input->post('cheque_no', TRUE);
				$datacheque=array('CHQBID'=>0,'CHQNO'=>$cheque_no,"CANFERNO"=>$entry_id,"CHQSTATUS"=>"CANCELED","CNDATE"=>date("Y-m-d") );
			if(! $this->db->insert('ac_chqprint',$datacheque ))
					{
						$this->db->trans_rollback();
						//$this->messages->add('error Inserting Cheque.', 'error');
						$this->session->set_flashdata('error', 'Error Inserting Cheque.');
						//$this->template->load('template', 'entry/add', $data);
						$this->load->view('accounts/entry/add',$data);
						return;
					}
				
			}
//			if($entry_type=="journal" & $this->input->post('subprjid', TRUE)!='')
//			{
//				$subprjid=$this->input->post('subprjid', TRUE);
//				$datacheque=array('subpojectid'=>$subprjid,"documentNo"=>$entry_id,"amount"=>$dr_total,"updatedate"=>date("Y-m-d") );
//				if(! $this->db->insert('project_expenditure',$datacheque ))
//					{
//						$this->db->trans_rollback();
//						//$this->messages->add('error Inserting Subproject Expences.', 'error');
//						$this->session->set_flashdata('error', 'Error Inserting Subproject Expences.');
//						//$this->template->load('template', 'entry/add', $data);
//						$this->load->view('accounts/entry/add',$data);
//						return;
//					}
//
//			}

			/* Success */
			$this->db->trans_complete();

			$this->session->set_userdata('entry_added_show_action', TRUE);
			$this->session->set_userdata('entry_added_id', $entry_id);
			$this->session->set_userdata('entry_added_type_id', $entry_type_id);
			$this->session->set_userdata('entry_added_type_label', $current_entry_type['label']);
			$this->session->set_userdata('entry_added_type_name', $current_entry_type['name']);
			$this->session->set_userdata('entry_added_number', $data_number);

			/* Showing success message in show() method since message is too long for storing it in session */
			$this->logger->write_message("success", "Added " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
			redirect('accounts/entry/show/' . $current_entry_type['label']);
			//$this->template->load('template', 'entry/add', $data);
			$this->load->view('accounts/entry/add',$data);
			return;
//		}
//		return;
	}

	function edit($entry_type, $entry_id = 0)
	{
		/* Check access */
		if ( ! check_access('edit entry'))
		{
			//$this->messages->add('Permission denied.', 'error');
			$this->session->set_flashdata('error', 'Permission denied.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			//$this->messages->add('Account is locked.', 'error');
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		//$this->template->set('page_title', 'Edit ' . $current_entry_type['name'] . ' Entry');

		/* Load current entry details */
		if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
		{
			var_dump($entry_id, $entry_type_id);
			die();
			//$this->messages->add('Invalid Entry.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry.');
			redirect('accounts/entry/show/' . $current_entry_type['label']);
			return;
		}

		//$data['subac_projects']=$this->ac_projects_model->get_all__sub_ac_projects();
		//$prjdata=$this->ac_projects_model->get_projectexpenditure_byentyid($entry_id);
		//$data['subprjid']=$prjdata->subpojectid;
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
//		if ($current_entry_type['numbering'] == '3')
//			$this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//		else
//			$this->form_validation->set_rules('entry_number', 'Entry Number', 'trim|required|is_natural_no_zero|uniqueentrynowithid[' . $entry_type_id . '.' . $entry_id . ']');
//		$this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//		$this->form_validation->set_rules('entry_narration', 'trim');
//		$this->form_validation->set_rules('entry_tag', 'Tag', 'trim|is_natural');

		/* Debit and Credit amount validation */
		if ($_POST)
		{
			foreach ($this->input->post('ledger_dc', TRUE) as $id => $ledger_data)
			{
//				$this->form_validation->set_rules('dr_amount[' . $id . ']', 'Debit Amount', 'trim|currency');
//				$this->form_validation->set_rules('cr_amount[' . $id . ']', 'Credit Amount', 'trim|currency');
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

//		if ($this->form_validation->run() == FALSE)
//		{
//			$this->messages->add(validation_errors(), 'error');
//			$this->template->load('template', 'entry/edit', $data);
//		} else	{
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
						//$this->template->load('template', 'entry/edit', $data);
						$this->load->view('accounts/entry/edit', $data);
						return;
					} else {
						/* Check for valid ledger type */
						$valid_ledger = $valid_ledger_q->row();
						
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
				//$this->template->load('template', 'entry/edit', $data);
				$this->load->view('accounts/entry/edit',$data);
				return;
			} else if (float_ops($dr_total, 0, '==') || float_ops($cr_total, 0, '==')) {
				//$this->messages->add('Cannot save empty Entry.', 'error');
				$this->session->set_flashdata('error', 'Cannot save empty Entry.');
				//$this->template->load('template', 'entry/edit', $data);
				$this->load->view('accounts/entry/edit',$data);
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
				//$this->template->load('template', 'entry/edit', $data);
				$this->load->view('accounts/entry/edit',$data);
				return;
			}

			/* TODO : Deleting all old ledger data, Bad solution */
			if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
			{
				$this->db->trans_rollback();
				//$this->messages->add('Error deleting previous Ledger accounts from Entry.', 'error');
				$this->session->set_flashdata('error', 'Error deleting previous Ledger accounts from Entry.');
				$this->logger->write_message("error", "Error deleting previous entry items for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
				//$this->template->load('template', 'entry/edit', $data);
				$this->load->view('accounts/entry/edit',$data);
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
					$this->load->view('accounts/entry/edit',$data);
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
				$this->load->view('accounts/entry/edit',$data);
				return;
			}
				//$subprjid=$this->input->post('subprjid', TRUE);
				//$datacheque=array('subpojectid'=>$subprjid,"amount"=>$dr_total,"updatedate"=>date("Y-m-d") );
//				if(! $this->db->where('documentNo', $entry_id)->update('project_expenditure',$datacheque ))
//					{
//						$this->db->trans_rollback();
//						//$this->messages->add('error Inserting Subproject Expences.', 'error');
//						$this->session->set_flashdata('error', 'Error Inserting Subproject Expences.');
//						//$this->template->load('template', 'entry/add', $data);
//						$this->load->view('accounts/entry/edit',$data);
//						return;
//					}

			/* Success */
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
		$this->session->set_flashdata('msg', 'Journal Entry Updated');
			/* Showing success message in show() method since message is too long for storing it in session */
			$this->logger->write_message("success", "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");

			redirect('accounts/entry/show/' . $current_entry_type['label']);
			return;
//		}
//		return;
	}

	function delete($entry_type, $entry_id = 0)
	{

		/* Check access */
		if ( ! check_access('delete entry'))
		{
			//$this->messages->add('Permission denied.', 'error');
			$this->session->set_flashdata('error', 'Permission denied.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			//$this->messages->add('Account is locked.', 'error');
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		/* Load current entry details */
		if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
		{
			//$this->messages->add('Invalid Entry.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry.');
			redirect('accounts/entry/show/' . $current_entry_type['label']);
			return;
		}

		$this->db->trans_start();
		if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
		{
			$this->db->trans_rollback();
			//$this->messages->add('Error deleting Entry - Ledger accounts.', 'error');
			$this->session->set_flashdata('error', 'Error deleting Entry - Ledger accounts.');
			$this->logger->write_message("error", "Error deleting ledger ac_entries for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
			redirect('accounts/entry/view/' . $current_entry_type['label'] . '/' . $entry_id);
			return;
		}
		if ( ! $this->db->delete('ac_entries', array('id' => $entry_id)))
		{
			$this->db->trans_rollback();
			//$this->messages->add('Error deleting Entry entry.', 'error');
			$this->session->set_flashdata('error', 'Error deleting Entry entry.');
			$this->logger->write_message("error", "Error deleting Entry entry for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
			redirect('accounts/entry/view/' . $current_entry_type['label'] . '/' . $entry_id);
			return;
		}
//			if ( ! $this->db->delete('project_expenditure', array('documentNo' => $entry_id)))
//		{
//			$this->db->trans_rollback();
//			$this->messages->add('Error deleting Entry entry.', 'error');
//
//			redirect('entry/view/' . $current_entry_type['label'] . '/' . $entry_id);
//			return;
//		}
		
		$this->db->trans_complete();
		//$this->messages->add('Deleted ' . $current_entry_type['name'] . ' Entry.', 'success');
		$this->session->set_flashdata('msg', 'Deleted ' . $current_entry_type['name'] . ' Entry.');
		$this->logger->write_message("success", "Deleted " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
		redirect('accounts/entry/show/' . $current_entry_type['label']);
		return;
	}

	function download($entry_type, $entry_id = 0)
	{
		$this->load->helper('download');
		$this->load->model('Setting_model');
		$this->load->model('Ledger_model');

		/* Check access */
		if ( ! check_access('download entry'))
		{
			$this->messages->add('Permission denied.', 'error');
			redirect('entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			$this->messages->add('Invalid Entry type.', 'error');
			redirect('entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		/* Load current entry details */
		if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
		{
			$this->messages->add('Invalid Entry.', 'error');
			redirect('entry/show/' . $current_entry_type['label']);
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

		/* Download Entry */
		$file_name = $current_entry_type['name'] . '_entry_' . $cur_entry->number . ".html";
		$download_data = $this->load->view('entry/downloadpreview', $data, TRUE);
		force_download($file_name, $download_data);
		return;
	}

	function printpreview($entry_type, $entry_id = 0)
	{
		$this->load->model('Setting_model');
		$this->load->model('Ledger_model');

		/* Check access */
		if ( ! check_access('print entry'))
		{
			$this->messages->add('Permission denied.', 'error');
			redirect('entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			$this->messages->add('Invalid Entry type.', 'error');
			redirect('entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		/* Load current entry details */
		if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
		{
			$this->messages->add('Invalid Entry.', 'error');
			redirect('entry/show/' . $current_entry_type['label']);
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

		$this->load->view('entry/printpreview', $data);
		return;
	}

	function email($entry_type, $entry_id = 0)
	{
		$this->load->model('Setting_model');
		$this->load->model('Ledger_model');
		$this->load->library('email');

		/* Check access */
		if ( ! check_access('email entry'))
		{
			$this->messages->add('Permission denied.', 'error');
			redirect('entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			$this->messages->add('Invalid Entry type.', 'error');
			redirect('entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		$account_data = $this->Setting_model->get_current();

		/* Load current entry details */
		if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
		{
			$this->messages->add('Invalid Entry.', 'error');
			redirect('entry/show/' . $current_entry_type['label']);
			return;
		}

		$data['entry_type_id'] = $entry_type_id;
		$data['current_entry_type'] = $current_entry_type;
		$data['entry_id'] = $entry_id;
		$data['entry_number'] = $cur_entry->number;
		$data['email_to'] = array(
			'name' => 'email_to',
			'id' => 'email_to',
			'size' => '40',
			'value' => '',
		);

		/* Form validations */
		$this->form_validation->set_rules('email_to', 'Email to', 'trim|valid_emails|required');

		/* Repopulating form */
		if ($_POST)
		{
			$data['email_to']['value'] = $this->input->post('email_to', TRUE);
		}

		if ($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			$this->load->view('entry/email', $data);
			return;
		}
		else
		{
			$entry_data['entry_type_id'] = $entry_type_id;
			$entry_data['current_entry_type'] = $current_entry_type;
			$entry_data['entry_number'] =  $cur_entry->number;
			$entry_data['entry_date'] = date_mysql_to_php_display($cur_entry->date);
			$entry_data['entry_dr_total'] =  $cur_entry->dr_total;
			$entry_data['entry_cr_total'] =  $cur_entry->cr_total;
			$entry_data['entry_narration'] = $cur_entry->narration;
	
			/* Getting Ledger details */
			$this->db->from('ac_entry_items')->where('entry_id', $entry_id)->order_by('dc', 'desc');
			$ledger_q = $this->db->get();
			$counter = 0;
			$entry_data['ledger_data'] = array();
			if ($ledger_q->num_rows() > 0)
			{
				foreach ($ledger_q->result() as $row)
				{
					$entry_data['ledger_data'][$counter] = array(
						'id' => $row->ledger_id,
						'name' => $this->Ledger_model->get_name($row->ledger_id),
						'dc' => $row->dc,
						'amount' => $row->amount,
					);
					$counter++;
				}
			}

			/* Preparing message */
			$message = $this->load->view('entry/emailpreview', $entry_data, TRUE);

			/* Getting email configuration */
			$config['smtp_timeout'] = '30';
			$config['charset'] = 'utf-8';
			$config['newline'] = "\r\n";
			$config['mailtype'] = "html";
			if ($account_data)
			{
				$config['protocol'] = $account_data->email_protocol;
				$config['smtp_host'] = $account_data->email_host;
				$config['smtp_port'] = $account_data->email_port;
				$config['smtp_user'] = $account_data->email_username;
				$config['smtp_pass'] = $account_data->email_password;
			} else {
				$data['error'] = 'Invalid account ac_settings.';
			}
			$this->email->initialize($config);

			/* Sending email */
			$this->email->from('', 'Webzash');
			$this->email->to($this->input->post('email_to', TRUE));
			$this->email->subject($current_entry_type['name'] . ' Entry No. ' . full_entry_number($entry_type_id, $cur_entry->number));
			$this->email->message($message);
			if ($this->email->send())
			{
				$data['message'] = "Email sent.";
				$this->logger->write_message("success", "Emailed " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
			} else {
				$data['error'] = "Error sending email. Check you email ac_settings.";
				$this->logger->write_message("error", "Error emailing " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
			}
			$this->load->view('entry/email', $data);
			return;
		}
		return;
	}

	function addrow($add_type = 'all')
	{
		if($add_type == '4')
		$list=array('24','32','34','44','45','46','47','48','49','50','51','52','53','54','55');
		if($add_type == '1')
		$list=array('70');
		if($add_type == '6')
		$list=array('12');

		$i = time() + rand  (0, time()) + rand  (0, time()) + rand  (0, time());
		$dr_amount = array(
			'name' => 'dr_amount[' . $i . ']',
			'id' => 'dr_amount[' . $i . ']',
			'maxlength' => '15',
			'size' => '15',
			'value' => '',
			'class' => 'dr-item number-separator',
			'disabled' => 'disabled',
		);
		$cr_amount = array(
			'name' => 'cr_amount[' . $i . ']',
			'id' => 'cr_amount[' . $i . ']',
			'maxlength' => '15',
			'size' => '15',
			'value' => '',
			'class' => 'cr-item number-separator',
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
		else if ($add_type == '4' ||$add_type == '6' || $add_type=='1' )
			echo form_input_ledger_advance('ledger_id[' . $i . ']', 0, '', '',$list);
		else if ($add_type == 'bankcharge')
			echo form_input_ledger('ledger_id[' . $i . ']', 0, '', $type = 'bankcharge');
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
	
	function confirm($entry_type, $entry_id = 0)
	{

		/* Check access */
		if ( ! check_access('confirm entry'))
		{
			//$this->messages->add('Permission denied.', 'error');
			$this->session->set_flashdata('error', 'Permission denied.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Check for account lock */
		if ($this->config->item('account_locked') == 1)
		{
			//$this->messages->add('Account is locked.', 'error');
			$this->session->set_flashdata('error', 'Account is locked.');
			redirect('accounts/entry/show/' . $entry_type);
			return;
		}

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
			return;
		} else {
			$current_entry_type = entry_type_info($entry_type_id);
		}

		/* Load current entry details */
		if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
		{
			//$this->messages->add('Invalid Entry.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry.');
			redirect('accounts/entry/show/' . $current_entry_type['label']);
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
				//$this->load->view('accounts/entry/cancel',$data);
				redirect('accounts/entry/show/' . $current_entry_type['label']);
				return;
			}
			
		$this->db->trans_complete();
		//$this->messages->add('Confirmed ' . $current_entry_type['name'] . ' Entry.', 'success');
		$this->session->set_flashdata('msg', 'Confirmed ' . $current_entry_type['name'] . ' Entry.');
		$this->logger->write_message("success", "Confirmed " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
		redirect('accounts/entry/show/' . $current_entry_type['label']);
		return;
	}
	function search()
	{
		$entry_type=$this->input->post('entry_type');

		
		


		$data['tag_id'] = 0;
		$entry_type_id = 0;

		if ($entry_type == 'tag')
		{
			$tag_id = (int)$this->uri->segment(4);
			if ($tag_id < 1)
			{
				//$this->messages->add('Invalid Tag.', 'error');
				$this->session->set_flashdata('error', 'Invalid Tag.');
				redirect('accounts/entry/show/'.$entry_type);
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
				redirect('accounts/entry/show/'.$entry_type);
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
		$siteurl='accounts/entry/search';
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
		$amountsearch = $this->input->post('amountsearch');
		$entry_no = $this->input->post('entry_no');
		$project_id = $this->input->post('project_id');
		$lot_id = $this->input->post('lot_id');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$bank_data='ALL';
		if($this->input->post('bank_data'))
		$bank_data = $this->input->post('bank_data');
	
		$entry_type_id = $this->input->post('entry_type_id');
		$allsearch=$amountsearch.$entry_no.$project_id.$lot_id.$fromdate.$todate.$bank_data;
		if($allsearch=="")
		{
			//$this->messages->add('entry number not exist ', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry');
			
				redirect('accounts/entry/show/'.$entry_type);
				return;
		}
		
		$this->db->select('ac_entries.*,ac_entry_status.status,ac_chqprint.CHQNO');
			$this->db->from('ac_entries');
			$this->db->where('entry_type', $entry_type_id);
			if($amountsearch!="" )
			$this->db->where('dr_total',$amountsearch);
			if($entry_no!="")
			$this->db->like('number',$entry_no);
			if($project_id!="")
			$this->db->where('prj_id',$project_id);
			if($lot_id!="")
			$this->db->where('lot_id',$lot_id);
			$this->db->order_by('date', 'desc');
			$this->db->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left');
			$this->db->join('ac_chqprint','ac_chqprint.CANFERNO=ac_entries.id','left');
			$this->db->join('ac_entry_items','ac_entry_items.entry_id=ac_entries.id','left');
			if($bank_data!="ALL")
			$this->db->where('ac_entry_items.ledger_id',$bank_data);
			if($fromdate!="")
			$this->db->where('date >=',$fromdate);
			if($todate!="")
			$this->db->where('date <=',$todate);
			$this->db->order_by('number', 'desc');
			$this->db->group_by('ac_entry_items.entry_id');
			
			
			//echo $entry_type_id."ssss".$entry_no;
			//$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
			$entry_q = $this->db->get();
		//	echo $this->db->last_query();
			$rowcount = 	$entry_q->num_rows();
			if($rowcount<1)
			{
				//$this->messages->add('Receipt number not exist ', 'error');
				$this->session->set_flashdata('error', 'Nothing Found');
				
				redirect('accounts/entry/show/'.$entry_type);
				return;
			}
		

		$data['entry_type_id'] = $entry_type_id;
		$data['entry_type'] = $entry_type;
//		var_dump($data['entry_data']);
//		die();
		$data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();
	
		$data['prjlist']=$this->projectpayment_model->get_all_payto_projectlist($this->session->userdata('branchid'));
		$data['entry_data'] = $entry_q;

		//$this->template->load('template', 'entry/search', $data);
		$this->load->view('accounts/entry/search',$data);
		return;

	}
	function print_entry($entry_type, $entry_id = 0)
	{

		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
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
			redirect('accounts/entry/show/' . $current_entry_type['label']);
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
		$this->db->from('ac_entries')->where('id', $entry_id);
		$entry_fulldata = $this->db->get();
		$entry=$entry_fulldata ->row();
		$data['cur_entry'] = $cur_entry;
		$data['entry_fulldata']=$entry;
		$data['cur_entry_ac_ledgers'] = $cur_entry_ac_ledgers;
		$data['entry_type_id'] = $entry_type_id;
		$data['current_entry_type'] = $current_entry_type;
		$this->load->view('accounts/entry/print', $data);
		return;
	}


	//2020-03-02 Ticket 1200  Bilani
	function get_blocklist(){
		$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('accounts/entry/blocklist',$data);
	}

	function get_lot_payment(){
		$data=NULL;
		$prj_id=NULL;
		$lot_id=NULL;
		$entry_type_payment_id = entry_type_name_to_id('payment');
		$entry_type_journal_id = entry_type_name_to_id('journal');
		$prj_id=$this->uri->segment(4);
        $lot_id=$this->uri->segment(5);


  		//$type= array($entry_type_payment_id, $entry_type_journal_id);

        
  		//$this->db->from('ac_entries')->or_where_in('entry_type', $type)->where('prj_id', $prj_id)->where('lot_id', $lot_id)->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc');
       	
		//  $entry_q = $this->db->get();


		// //check blank result
		// if($entry_q->num_rows() > 0){
		// 	$data['entry_data'] = $entry_q;
		// 	$this->load->view('accounts/entry/popup_lot_payment',$data);
		// }
		// else{
		// 	$data['entry_data'] = NULL;
		// 	$this->load->view('accounts/entry/popup_lot_payment',$data);
		// }

		$data['res_his']=$res_his=$this->lotdata_model->get_reservation_historty($this->uri->segment(5));
		$resolelist=NULL;
		$paylist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$resaledata=$this->lotdata_model->get_resale_by_res_code($raw->res_code);
					$paylist[$resaledata->resale_code]=$this->common_model->get_resale_payment($resaledata->resale_code);	
				}
				else{
					$resolelist[$raw->res_code]=$resaledata=$this->lotdata_model->get_epresale_res_code($raw->res_code);
					$paylist[$resaledata->resale_code]=$this->common_model->get_epresale_payment($resaledata->resale_code);		
				}
			}
		}
		$data['resolelist']=$resolelist;
		$data["paylist"]=$paylist;

		$this->load->view('accounts/entry/popup_lot_payment',$data);
	}
	//2020-03-02 Ticket 1200  Bilani - End
	function view_popup($entry_type, $entry_id = 0)
	{
		$entry_type_id = entry_type_name_to_id($entry_type);
		
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
			return;
		} 
		if($entry_type_id==1)
		{
			$this->view_popup_reciept($entry_id);
		}
		else if($entry_type_id==2)
		{
			$this->view_popup_payment($entry_id);
		}
		else
		$this->view_popup_entry($entry_type, $entry_id);
	}
	function view_popup_payment($id)
	{
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
		$voucher_ncode='';
		//voucher new code generate funtion
		if($dataset->voucher_ncode)
		{
			$voucher_ncode=$dataset->voucher_ncode;
		}
		
		
		
		if($bank_code!='')
		$data['bank_name'] = $this->common_model->getbank_details($bank_code);
		else
		$data['bank_name']=$this->Ledger_model->get_entry_name($id, '2');

        $data['entry_data'] = $entry_q->result();
		
		  $data['id'] = $id;
		 $data['voucher_ncode'] = $voucher_ncode;
		
        $this->load->view('accounts/entry/payment_popup', $data);
        return;
	}
	function view_popup_reciept($entrynumber)
	{
		$this->load->model('Tag_model');

        if ( ! check_access('print receipt'))
        {
            $this->session->set_flashdata('error', 'Permission denied.');
            //$this->messages->add('Permission denied.', 'error');


            return false;
        }
       
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
					$this->load->view('accounts/entry/reciept_popup', $data);
					}
			}
			
			else
			{
					 $data['entry_data'] = $entry_q->result();
					 $data['ledgers'] = $ledgers->result();
						$data['entrynumber'] = $entrynumber;
           			 $this->load->view('accounts/entrymaster/preciept_popup_other', $data);
			}
            return;
       
	}
	function view_popup_entry($entry_type, $entry_id = 0)
	{
		/* Entry Type */
		$entry_type_id = entry_type_name_to_id($entry_type);
		if ( ! $entry_type_id)
		{
			//$this->messages->add('Invalid Entry type.', 'error');
			$this->session->set_flashdata('error', 'Invalid Entry type.');
			redirect('accounts/entry/show/all');
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
			redirect('accounts/entry/show/' . $current_entry_type['label']);
			return;
		}
		/* Load current entry details */
		$this->db->from('ac_entry_items')->where('ac_entry_items.entry_id', $entry_id)->order_by('ac_entry_items.id', 'asc');
		$cur_entry_ac_ledgers = $this->db->get();
		if ($cur_entry_ac_ledgers->num_rows() < 1)
		{
			//$this->messages->add('Entry has no associated Ledger accounts.', 'error');
			$this->session->set_flashdata('error', 'Entry has no associated Ledger accounts.');
		}
		
		$data['project'] = $this->Entry_model->get_project_deials_by_id($cur_entry->prj_id);
		$data['cur_entry'] = $cur_entry;
		$data['cur_entry_ac_ledgers'] = $cur_entry_ac_ledgers;
		$data['entry_type_id'] = $entry_type_id;
		$data['current_entry_type'] = $current_entry_type;
		//$this->template->load('template', 'entry/view', $data);
		$this->load->view('accounts/entry/view_popup',$data);
		return;
	
	}
	
	
	function get_blocklist_search()
	{
		//echo $this->uri->segment(4);
		$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('accounts/entry/get_blocklist_search',$data);
		
	}
}

/* End of file entry.php */
/* Location: ./system/application/controllers/entry.php */
