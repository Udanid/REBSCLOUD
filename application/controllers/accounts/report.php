<?php

class Report extends CI_Controller {
    var $acc_array;
    var $account_counter;
    function Report()
    {
        parent::__construct();
        $this->load->model('Ledger_model');
        $this->load->helper(array('form', 'url'));
		$this->load->model('common_model');
		$this->load->model('paymentvoucher_model');
		$this->load->model('reciept_model');
    $this->load->model('supplier_model');
    $this->load->model('project_model');
     $this->load->model('employee_model');
     $this->load->model("supplier_model");
       $this->load->model("pettycashpayments_model");
		$this->is_logged_in();

        /* Check access */
        if ( ! check_access('view reports'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user/');
            return;
        }

        return;
    }

    function index()
    {
        //$this->template->set('page_title', 'Reports');
        //$this->template->load('template', 'report/index');
        $this->load->view('accounts/report/index');
        return;
    }
// 	function ac_ledgerst($ledger_id = "",$month = "00",$fromdate = "",$todate = "",$amount="",$project="",$rctno="",$chequeno="")
// 	{
// 		$this->load->helper('text');
// 	//	$this->template->set('nav_links', array('report/download/ac_ledgerstall'  => 'Download General Ledger CSV','report/printledgerall'  => 'Print General Ledger CSV'));
// 		/* Pagination setup */
// 		$this->load->library('pagination');
//
// 	////	$this->template->set('page_title', 'Ledger Statement');
// 		//if ($ledger_id != "")
// 		//	$this->template->set('nav_links', array('report/download/ac_ledgerst/' . $ledger_id  => 'Download CSV', 'report/printpreview/ac_ledgerst/' . $ledger_id => 'Print Preview'));
//  //$fromdate="";$todate="";
// 		if ($_POST)
// 		{
// 			$ledger_id = $this->input->post('ledger_id', TRUE);
// 			$month = $this->input->post('month', TRUE);
// 			$fromdate = $this->input->post('fromdate', TRUE);
// 			$todate = $this->input->post('todate', TRUE);
// 			$amount = $this->input->post('amount');
// 			$project = $this->input->post('project');
// 			$rctno = $this->input->post('rctno');
// 			$chequeno = $this->input->post('chequeno');
// 			//redirect('accounts/report/ac_ledgerst/'.$ledger_id.'/'.$month.'/'.$fromdate.'/'.$todate.'/'.$amount.'/'.$project.'/'.$rctno);
// 		}
// 		//echo $ledger_id.'ssss';
// 		$data['print_preview'] = FALSE;
// 		$data['ledger_id'] = $ledger_id;
// 		$data['month'] = $month;
// 		$data['fromdate'] = $fromdate;
// 		$data['todate'] = $todate;
// 		$data['amount'] = $amount;
// 		$data['project'] = $project;
// 		$data['rctno'] = $rctno;
// 		$data['chequeno'] = $chequeno;
// 		//echo $amount;
// 		/* Checking for valid ledger id */
// 		if ($data['ledger_id'] != "")
// 		{
// 			$this->db->from('ac_ledgers')->where('id', $data['ledger_id'])->limit(1);
// 			if ($this->db->get()->num_rows() < 1)
// 			{
// 				$this->messages->add('Invalid Ledger account.', 'error');
// 				redirect('accounts/report/ac_ledgerst');
// 				return;
// 			}
// 		}
// //echo "sss".$data['ledger_id'];
// 		$this->load->view('accounts/report/ledgerst', $data);
// 		return;
// 	}
	function generalledger($month = "00",$fromdate = "",$todate = "")
	{
		$this->load->helper('text');

		if ($_POST)
		{
			$data['month'] = $this->input->post('month', TRUE);
			$data['fromdate'] = $this->input->post('fromdate', TRUE);
			$data['todate'] = $this->input->post('todate', TRUE);
			$this->load->view('accounts/report/generalledger',$data);
		}else{
			$data['month'] = '';
			$data['fromdate'] = '';
			$data['todate'] = '';
			$this->load->view('accounts/report/generalledger',$data);
		}
	}
	function balancesheet($period = NULL)
	{
		//$this->template->set('page_title', 'Balance Sheet');
		//$this->template->set('nav_links', array('report/download/balancesheet' => 'Download CSV', 'report/printpreview/balancesheet' => 'Print Preview'));
		$data['left_width'] = "450";
		$data['right_width'] = "450";
		$data['todate']= "";
		$this->load->view('accounts/report/balancesheet', $data);
		//$this->template->load('template', 'report/balancesheet', $data);
		return;
	}
	function balancesheet_period($period = NULL)
	{
		//$this->template->set('page_title', 'Balance Sheet');
		//$this->template->set('nav_links', array('report/download/balancesheet' => 'Download CSV', 'report/printpreview/balancesheet' => 'Print Preview'));
		if ($_POST)
		{
			$month = $this->input->post('month', TRUE);
			$fromdate = $this->input->post('fromdate', TRUE);
			$todate = $this->input->post('todate', TRUE);
		}
		if($month=="" && $fromdate=="" && $todate=="")
		{
			redirect('accounts/report/balancesheet');
		}
		$data['month']=$month;
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$data['left_width'] = "450";
		$data['right_width'] = "450";
		$this->load->view('accounts/report/balancesheet', $data);
		//$this->template->load('template', 'report/balancesheet', $data);
		return;
	}
	function trialbalance($period = NULL)
	{
		//$this->template->set('page_title', 'Trial Balance');
	//	$this->template->set('nav_links', array('report/trialbalance_report' => 'Download CSV', 'report/printpreview/trialbalance' => 'Print Preview'));
$data=NULL;
		$this->load->library('accountlist');
		$this->load->view('accounts/report/trialbalance', $data);
		//$this->template->load('template', 'report/trialbalance');
		return;
	}
	function trialbalance_period($period = NULL)
	{
	$month="";
		if ($_POST)
		{
			$month = $this->input->post('month', TRUE);
			$fromdate = $this->input->post('fromdate', TRUE);
			$todate = $this->input->post('todate', TRUE);
		}
		if($month=="" && $fromdate=="" && $todate=="")
		{
			redirect('accounts/report/trialbalance');
		}


		$data['month']=$month;
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;

		$this->load->library('accountlist');
		$this->load->view('accounts/report/trialbalance_period', $data);
		//$this->template->load('template', 'report/trialbalance');
		return;
	}
	function profitandloss($period = NULL)
	{
	//	$this->template->set('page_title', 'Profit And Loss Statement');
		//$this->template->set('nav_links', array('report/download/profitandloss' => 'Download CSV', 'report/printpreview/profitandloss' => 'Print Preview'));
		$data['left_width'] = "450";
		$data['right_width'] = "450";
		$this->load->view('accounts/report/profitandloss', $data);
		//$this->template->load('template', 'report/profitandloss', $data);
		return;
	}
function profitandloss_period($period = NULL)
	{
	if ($_POST)
		{
			$month = $this->input->post('month', TRUE);
			$fromdate = $this->input->post('fromdate', TRUE);
			$todate = $this->input->post('todate', TRUE);
		}
		if($month=="" && $fromdate=="" && $todate=="")
		{
			redirect('accounts/report/profitandloss');
		}
		$data['month']=$month;
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;

			$data['left_width'] = "450";
		$data['right_width'] = "450";
		$this->load->view('accounts/report/profitandloss_period', $data);
		//$this->template->load('template', 'report/profitandloss', $data);
		return;
	}
	function cashflow(){
		$data['left_width'] = "450";
		$data['right_width'] = "450";
		$this->load->view('accounts/report/cashflow', $data);
	}
	function cashflow_period($period = NULL)
	{
	if ($_POST)
		{
			$month = $this->input->post('month', TRUE);
			$fromdate = $this->input->post('fromdate', TRUE);
			$todate = $this->input->post('todate', TRUE);
		}
		if($month=="" && $fromdate=="" && $todate=="")
		{
			redirect('accounts/report/cashflow');
		}
		$data['month']=$month;
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;

			$data['left_width'] = "450";
		$data['right_width'] = "450";
		$this->load->view('accounts/report/cashflow_period', $data);
		//$this->template->load('template', 'report/profitandloss', $data);
		return;
	}
function reconciliation($reconciliation_type = '', $ledger_id = 0)
	{
		//$this->load->helper('text');

		/* Pagination setup */
		//$this->load->library('pagination');

		//$this->template->set('page_title', 'Reconciliation');
		//$this->template->set('nav_links', array('entry/add/recon' => 'Add Entry'));

		/* Check if path is 'all' or 'pending' */
		$data['show_all'] = FALSE;
		$data['print_preview'] = FALSE;
		$data['ledger_id'] = $ledger_id;
		if ($reconciliation_type == 'all')
		{
			$data['reconciliation_type'] = 'all';
			$data['show_all'] = TRUE;
			//if ($ledger_id != '0')
				//$this->template->set('nav_links', array('report/download/reconciliation/' . $ledger_id . '/all'  => 'Download CSV', 'report/printpreview/reconciliation/' . $ledger_id . '/all' => 'Print Preview'));
		} else if ($reconciliation_type == 'pending') {
			$data['reconciliation_type'] = 'pending';
			$data['show_all'] = FALSE;
			//if ($ledger_id != '0')
				//$this->template->set('nav_links', array('report/download/reconciliation/' . $ledger_id . '/pending'  => 'Download CSV', 'report/printpreview/reconciliation/' . $ledger_id . '/pending'  => 'Print Preview'));
		} else {
			$this->messages->add('Invalid path.', 'error');
			redirect('report/reconciliation/pending');
			return;
		}

		/* Checking for valid ledger id and reconciliation status */
		if ($data['ledger_id'] > 0)
		{
			$this->db->from('ac_ledgers')->where('id', $data['ledger_id'])->where('reconciliation', 1)->limit(1);
			if ($this->db->get()->num_rows() < 1)
			{
				$this->messages->add('Invalid Ledger account or Reconciliation is not enabled for the Ledger account.', 'error');
				redirect('accounts/report/reconciliation/' . $reconciliation_type);
				return;
			}
		} else if ($data['ledger_id'] < 0) {
			$this->messages->add('Invalid Ledger account.', 'error');
			redirect('accounts/reconciliation/' . $reconciliation_type);
			return;
		}

		if ($_POST)
		{
			/* Check if Ledger account is changed or reconciliation is updated */
			if ($_POST['submit'] == 'Submit')
			{
				$ledger_id = $this->input->post('ledger_id', TRUE);
				if ($this->input->post('show_all', TRUE))
				{
					redirect('accounts/report/reconciliation/all/' . $ledger_id);
					return;
				} else {
					redirect('accounts/report/reconciliation/pending/' . $ledger_id);
					return;
				}
			} else if ($_POST['submit'] == 'Update') {

				$data_reconciliation_date = $this->input->post('reconciliation_date', TRUE);

				/* Form validations */
				foreach ($data_reconciliation_date as $id => $row)
				{
					/* If reconciliation date is present then check for valid date else only trim */
					//if ($row)
					//	$this->form_validation->set_rules('reconciliation_date[' . $id . ']', 'Reconciliation date', 'trim|required|is_date|is_date_within_range_reconcil');
					//else
						//$this->form_validation->set_rules('reconciliation_date[' . $id . ']', 'Reconciliation date', 'trim');
				}


					/* Updating reconciliation date */
					foreach ($data_reconciliation_date as $id => $row)
					{
						$this->db->trans_start();
						//echo $row;
						if ($row)
						{
							$update_data = array(
								'reconciliation_date' => $row,
							);
						} else {
							$update_data = array(
								'reconciliation_date' => NULL,
							);
						}
						if ( ! $this->db->where('id', $id)->update('ac_entry_items', $update_data))
						{
							$this->db->trans_rollback();
							$this->messages->add('Error updating reconciliation.', 'error');
							$this->logger->write_message("error", "Error updating reconciliation for entry item [id:" . $id . "]");
						} else {
							$this->db->trans_complete();
						}
					}
					$this->messages->add('Updated reconciliation.', 'success');
					$this->logger->write_message("success", 'Updated reconciliation.');
				}

		}
		$this->load->view('accounts/report/reconciliation', $data);
		return;
	}
 	function do_upload(){
         //$config['max_width']  = '1024';
        //$config['max_height']  = '768';

				$config['upload_path'] = 'uploads/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '1024';

              $this->load->library('image_lib');
                $this->load->library('upload', $config);


        if ( ! $this->upload->do_upload("userfile"))
        {
            //$error = array('error' => $this->upload->display_errors());
            $error = $this->upload->display_errors();
			//echo $error;
          //  $this->messages->add($error, 'error');
		  	$this->session->set_flashdata('error', $error);
            redirect('accounts/report/reconciliation/pending');
        }
        else
        {
            $data = $this->upload->data();

            //Import CSV data to MYSQL DB
            $csvfile = fopen("uploads/".$data['file_name'],"r");
            $theData = fgets($csvfile);
            $i = 0;
			$this->load->library('Spreadsheet_Excel_Reader');
// Read the spreadsheet via a relative path to the document
// for example $this->excel_reader->read('./uploads/file.xls');
			$excel = new Spreadsheet_Excel_Reader();


			$excel->read("uploads/".$data['file_name']); // set the excel file name here
			$counter=0;
			$data['data_excell']=$data_excell=$excel->sheets[0]['cells'];//echo $data['file_name'];
			if($this->input->post('bank_code')=='7278'){
					for ($i = 6; $i <= $excel->sheets[0]['numRows']; $i++) {
					//$newid=$prifix.str_pad($counter, 6, "0", STR_PAD_LEFT);
					$banckdate=$excel->sheets[0]['cells'][$i][1];
					$chqno=$excel->sheets[0]['cells'][$i][2];
					$amount=$excel->sheets[0]['cells'][$i][6];
					$type=$excel->sheets[0]['cells'][$i][5];
					$bankdate=explode('/',$banckdate);
					if($type=='DR')
					$type='C';
					else $type='D';
					$recdate=$bankdate[2].'-'.$bankdate[1].'-'.$bankdate[0];

						if(strlen($chqno)==6)
						{
							$amount=str_replace(",", "", $amount);
						//	echo $recdate.'-'.$chqno."<br>" ;
							 $test = $this->Ledger_model->update_reconcile($recdate,$chqno,$type,$amount);
							 if($test)
							 $counter++;
						}
					}
			}
				if($this->input->post('bank_code')=='7010'){
					for ($i = 7; $i <= $excel->sheets[0]['numRows']; $i++) {
					//$newid=$prifix.str_pad($counter, 6, "0", STR_PAD_LEFT);
					$banckdate=$excel->sheets[0]['cells'][$i][1];
					$chqno=$excel->sheets[0]['cells'][$i][2];
					$cramount=$excel->sheets[0]['cells'][$i][4];
					$dramount=$excel->sheets[0]['cells'][$i][3];
					//$type=$excel->sheets[0]['cells'][$i][5];
					//$bankdate=explode('/',$banckdate);
					if($dramount!='')
					{
					$type='C';
					$amount=$dramount;
					}
					if($cramount!='')
					{
					$type='D';
					$amount=$cramount;
					}
					$recdate=$banckdate;
				//	echo $recdate.'-'.$type.'-'.$amount."<br>" ;
						if(strlen($chqno)==6)
						{
							$amount=str_replace(",", "", $amount);

							 $test = $this->Ledger_model->update_reconcile($recdate,$chqno,$type,$amount);
							 if($test)
							 $counter++;
						}
					}
			}
			if($this->input->post('bank_code')=='7287'){
					for ($i = 10; $i <= $excel->sheets[0]['numRows']; $i++) {
					//$newid=$prifix.str_pad($counter, 6, "0", STR_PAD_LEFT);
					$banckdate=$excel->sheets[0]['cells'][$i][2];
					$chqno="";
					if($excel->sheets[0]['cells'][$i][5])
					$chqno=$excel->sheets[0]['cells'][$i][5];
					$amount=$excel->sheets[0]['cells'][$i][8];
					$type=$excel->sheets[0]['cells'][$i][6];
					$bankdate=explode('/',$banckdate);
					if($type=='DR')
					$type='C';
					else $type='D';
					$recdate=$bankdate[2].'-'.$bankdate[1].'-'.$bankdate[0];
			//	echo $recdate.'-'.$type.'-'.$amount."<br>" ;
						if(strlen($chqno)==6)
						{
							$amount=str_replace(",", "", $amount);
						//	echo $recdate.'-'.$chqno."<br>" ;
							 $test = $this->Ledger_model->update_reconcile($recdate,$chqno,$type,$amount);
							 if($test)
							 $counter++;
						}
					}
			}

            unlink("uploads/".$data['file_name']);
         	$this->session->set_flashdata('msg', $counter.' Recordes  Successfully Reconsiled ');
            $this->logger->write_message("success", 'Uploaded a bank statement.');
          redirect('accounts/report/reconciliation/pending');
        }
    }
function download($statement, $id = '')
	{
		/********************** TRIAL BALANCE *************************/
		if ($statement == "trialbalance")
		{
			$this->load->model('Ledger_model');
			$all_ac_ledgers = $this->Ledger_model->get_all_ac_ledgers();
			$counter = 0;
			$trialbalance = array();
			$temp_dr_total = 0;
			$temp_cr_total = 0;

			$trialbalance[$counter] = array ("TRIAL BALANCE", "", "", "", "", "", "", "", "");
			$counter++;
			$trialbalance[$counter] = array ("as at " . date("jS F Y"), "", "", "", "", "", "", "", "");
			$counter++;

			$trialbalance[$counter][0]= "Ledger";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "Opening";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "Closing";
			$trialbalance[$counter][5]= "";
			$trialbalance[$counter][6]= "Dr(Rs) Total";
			$trialbalance[$counter][7]= "";
			$trialbalance[$counter][8]= "Cr(Rs) Total";
			$counter++;

			foreach ($all_ac_ledgers as $ledger_id => $ledger_name)
			{
				if ($ledger_id == '') continue;
				$array=explode('#',$ledger_name);
				$name = trim($array[0]);
				$trialbalance[$counter][0] = $name;

				list ($opbal_amount, $opbal_type) = $this->Ledger_model->get_op_balance($ledger_id);
				if (float_ops($opbal_amount, 0, '=='))
				{
					$trialbalance[$counter][1] = "";
					$trialbalance[$counter][2] = 0;
				} else {
					$trialbalance[$counter][1] = convert_dc($opbal_type);
					$trialbalance[$counter][2] = $opbal_amount;
				}

				$clbal_amount = $this->Ledger_model->get_ledger_balance($ledger_id);

				if (float_ops($clbal_amount, 0, '=='))
				{
					$trialbalance[$counter][3] = "";
					$trialbalance[$counter][4] = 0;
				} else if ($clbal_amount < 0) {
					$trialbalance[$counter][3] = "Cr";
					$trialbalance[$counter][4] = convert_cur(-$clbal_amount);
				} else {
					$trialbalance[$counter][3] = "Dr";
					$trialbalance[$counter][4] = convert_cur($clbal_amount);
				}

				$dr_total = $this->Ledger_model->get_dr_total($ledger_id);
				if ($dr_total)
				{
					$trialbalance[$counter][5] = "Dr";
					$trialbalance[$counter][6] = convert_cur($dr_total);
					$temp_dr_total = float_ops($temp_dr_total, $dr_total, '+');
				} else {
					$trialbalance[$counter][5] = "";
					$trialbalance[$counter][6] = 0;
				}

				$cr_total = $this->Ledger_model->get_cr_total($ledger_id);
				if ($cr_total)
				{
					$trialbalance[$counter][7] = "Cr";
					$trialbalance[$counter][8] = convert_cur($cr_total);
					$temp_cr_total = float_ops($temp_cr_total, $cr_total, '+');
				} else {
					$trialbalance[$counter][7] = "";
					$trialbalance[$counter][8] = 0;
				}
				$counter++;
			}

			$trialbalance[$counter][0]= "";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$trialbalance[$counter][5]= "";
			$trialbalance[$counter][6]= "";
			$trialbalance[$counter][7]= "";
			$trialbalance[$counter][8]= "";
			$counter++;

			$trialbalance[$counter][0]= "Total";
			$trialbalance[$counter][1]= "";
			$trialbalance[$counter][2]= "";
			$trialbalance[$counter][3]= "";
			$trialbalance[$counter][4]= "";
			$trialbalance[$counter][5]= "Dr";
			$trialbalance[$counter][6]= convert_cur($temp_dr_total);
			$trialbalance[$counter][7]= "Cr";
			$trialbalance[$counter][8]= convert_cur($temp_cr_total);

			$this->load->helper('csv');
			echo array_to_csv($trialbalance, "trialbalance.csv");
			return;
		}

		/********************** LEDGER STATEMENT **********************/
		if ($statement == "ac_ledgerst")
		{
			$this->load->helper('text');
			$ledger_id = $this->uri->segment(5);
			if ($ledger_id =='')
				redirect('accounts/report/ac_ledgerst');

			$this->load->model('Ledger_model');
			$cur_balance = 0;
			$counter = 0;
			$ac_ledgerst = array();

			$ac_ledgerst[$counter] = array ("", "", "LEDGER STATEMENT FOR " . strtoupper($this->Ledger_model->get_name($ledger_id)), "", "", "", "", "", "", "", "");
			$counter++;
			$ac_ledgerst[$counter] = array ("", "", "FY " . date_mysql_to_php($this->config->item('account_fy_start')) . " - " . date_mysql_to_php($this->config->item('account_fy_end')), "", "", "", "", "", "", "", "");
			$counter++;

			$ac_ledgerst[$counter][0]= "Date";
			$ac_ledgerst[$counter][1]= "Number";
			$ac_ledgerst[$counter][2]= "Ledger Name";
			$ac_ledgerst[$counter][3]= "Narration";
			$ac_ledgerst[$counter][4]= "Type";
			$ac_ledgerst[$counter][5]= "RCT/CHQ No";
			$ac_ledgerst[$counter][6]= "";
			$ac_ledgerst[$counter][7]= "Dr Amount";
			$ac_ledgerst[$counter][8]= "";
			$ac_ledgerst[$counter][9]= "Cr Amount";
			$ac_ledgerst[$counter][10]= "";
			$ac_ledgerst[$counter][11]= "Balance";
			$counter++;

			/* Opening Balance */
			list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
			$ac_ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", "", convert_dc($optype), $opbalance);
			if ($optype == "D")
				$cur_balance = float_ops($cur_balance, $opbalance, '+');
			else
				$cur_balance = float_ops($cur_balance, $opbalance, '-');
			$counter++;

			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO');
			$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
			$ac_ledgerst_q = $this->db->get();
			foreach ($ac_ledgerst_q->result() as $row)
			{
				/* Entry Type */
				$current_entry_type = entry_type_info($row->ac_entries_entry_type);

				$ac_ledgerst[$counter][0] = date_mysql_to_php($row->ac_entries_date);
				$ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);

				/* Opposite entry name */
				$ac_ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'text');
				$ac_ledgerst[$counter][3] = $row->ac_entries_narration;
				$ac_ledgerst[$counter][4] = $current_entry_type['name'];
				$ac_ledgerst[$counter][5] = $row->CHQNO.$row->RCTNO;

				if ($row->ac_entry_items_dc == "D")
				{
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
					$ac_ledgerst[$counter][6] = convert_dc($row->ac_entry_items_dc);
					$ac_ledgerst[$counter][7] = $row->ac_entry_items_amount;
					$ac_ledgerst[$counter][8] = "";
					$ac_ledgerst[$counter][9] = "";

				} else {
					$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
					$ac_ledgerst[$counter][6] = "";
					$ac_ledgerst[$counter][7] = "";
					$ac_ledgerst[$counter][8] = convert_dc($row->ac_entry_items_dc);
					$ac_ledgerst[$counter][9] = $row->ac_entry_items_amount;
				}

				if (float_ops($cur_balance, 0, '=='))
				{
					$ac_ledgerst[$counter][10] = "";
					$ac_ledgerst[$counter][11] = 0;
				} else if (float_ops($cur_balance, 0, '<')) {
					$ac_ledgerst[$counter][10] = "Cr";
					$ac_ledgerst[$counter][11] = convert_cur(-$cur_balance);
				} else {
					$ac_ledgerst[$counter][10] = "Dr";
					$ac_ledgerst[$counter][11] =  convert_cur($cur_balance);
				}
				$counter++;
			}

			$ac_ledgerst[$counter][0]= "Closing Balance";
			$ac_ledgerst[$counter][1]= "";
			$ac_ledgerst[$counter][2]= "";
			$ac_ledgerst[$counter][3]= "";
			$ac_ledgerst[$counter][4]= "";
			$ac_ledgerst[$counter][5]= "";
			$ac_ledgerst[$counter][6]= "";
			$ac_ledgerst[$counter][7]= "";
			$ac_ledgerst[$counter][8]= "";
			$ac_ledgerst[$counter][9]= "";
			if (float_ops($cur_balance, 0, '<'))
			{
				$ac_ledgerst[$counter][10]= "Cr";
				$ac_ledgerst[$counter][11]= convert_cur(-$cur_balance);
			} else {
				$ac_ledgerst[$counter][10]= "Dr";
				$ac_ledgerst[$counter][11]= convert_cur($cur_balance);
			}
			$counter++;

			$ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
			$counter++;

			/* Final Opening and Closing Balance */
			$clbalance = $this->Ledger_model->get_ledger_balance($ledger_id);

			$ac_ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "", "");
			$counter++;

			if (float_ops($clbalance, 0, '=='))
				$ac_ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
			else if ($clbalance < 0)
				$ac_ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "", "");
			else
				$ac_ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "", "");

			$this->load->helper('csv');
			echo array_to_csv($ac_ledgerst, "ac_ledgerst.csv");
			return;
		}

		/************************** General Ledger Statement *****************/
		if ($statement == "ac_ledgerstall")
		{
			$this->load->helper('text');
			$this->load->model('Ledger_model');
			$ac_ledgers = $this->Ledger_model->get_ac_ledgers_list_all();
			ob_start();
			foreach ($ac_ledgers as $row){
				$group = $row->gname;
				$ledger_id = $row->id;
				$cur_balance = 0;
				$counter = 0;
				$ac_ledgerst = array();

				$ac_ledgerst[$counter] = array ("", "", "LEDGER STATEMENT FOR " .$ledger_id."  ". strtoupper($this->Ledger_model->get_name($ledger_id)." - ".$group)."", "", "", "", "", "", "", "", "");
				$counter++;
				$ac_ledgerst[$counter] = array ("", "", "FY " . date_mysql_to_php($this->config->item('account_fy_start')) . " - " . date_mysql_to_php($this->config->item('account_fy_end')), "", "", "", "", "", "", "", "");
				$counter++;

				$ac_ledgerst[$counter][0]= "Date";
				$ac_ledgerst[$counter][1]= "Number";
				$ac_ledgerst[$counter][2]= "Ledger Name";
				$ac_ledgerst[$counter][3]= "Narration";
				$ac_ledgerst[$counter][4]= "Type";
				$ac_ledgerst[$counter][5]= "";
				$ac_ledgerst[$counter][6]= "Dr Amount";
				$ac_ledgerst[$counter][7]= "";
				$ac_ledgerst[$counter][8]= "Cr Amount";
				$ac_ledgerst[$counter][9]= "";
				$ac_ledgerst[$counter][10]= "Balance";
				$counter++;

				/* Opening Balance */
				list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
				$ac_ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", convert_dc($optype), $opbalance);
				if ($optype == "D")
					$cur_balance = float_ops($cur_balance, $opbalance, '+');
				else
					$cur_balance = float_ops($cur_balance, $opbalance, '-');
				$counter++;

				$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc');
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
				$ac_ledgerst_q = $this->db->get();
				foreach ($ac_ledgerst_q->result() as $row)
				{
					/* Entry Type */
					$current_entry_type = entry_type_info($row->ac_entries_entry_type);

					$ac_ledgerst[$counter][0] = date_mysql_to_php($row->ac_entries_date);
					//$ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
					if ($row->ac_entries_entry_type==2){
						$this->db->select('id')->from('ac_entries')->where('number',$row->ac_entries_number);
						$result = $this->db->get();
						$entry = $result->row();

						$this->db->select('voucherid')->from('ac_payvoucherdata')->where('entryid',$entry->id);
						$result = $this->db->get();
						$voucher = $result->row();
						if ($voucher){
							$ac_ledgerst[$counter][1]	= $voucher->voucherid;
						}else{
							$ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
						}
					}else{
						$ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
					}

					/* Opposite entry name */
					$ac_ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'text');
					$ac_ledgerst[$counter][3] = $row->ac_entries_narration;
					$ac_ledgerst[$counter][4] = $current_entry_type['name'];

					if ($row->ac_entry_items_dc == "D")
					{
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
						$ac_ledgerst[$counter][5] = convert_dc($row->ac_entry_items_dc);
						$ac_ledgerst[$counter][6] = $row->ac_entry_items_amount;
						$ac_ledgerst[$counter][7] = "";
						$ac_ledgerst[$counter][8] = "";

					} else {
						$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
						$ac_ledgerst[$counter][5] = "";
						$ac_ledgerst[$counter][6] = "";
						$ac_ledgerst[$counter][7] = convert_dc($row->ac_entry_items_dc);
						$ac_ledgerst[$counter][8] = $row->ac_entry_items_amount;
					}

					if (float_ops($cur_balance, 0, '=='))
					{
						$ac_ledgerst[$counter][9] = "";
						$ac_ledgerst[$counter][10] = 0;
					} else if (float_ops($cur_balance, 0, '<')) {
						$ac_ledgerst[$counter][9] = "Cr";
						$ac_ledgerst[$counter][10] = convert_cur(-$cur_balance);
					} else {
						$ac_ledgerst[$counter][9] = "Dr";
						$ac_ledgerst[$counter][10] =  convert_cur($cur_balance);
					}
					$counter++;
				}

				$ac_ledgerst[$counter][0]= "Closing Balance";
				$ac_ledgerst[$counter][1]= "";
				$ac_ledgerst[$counter][2]= "";
				$ac_ledgerst[$counter][3]= "";
				$ac_ledgerst[$counter][4]= "";
				$ac_ledgerst[$counter][5]= "";
				$ac_ledgerst[$counter][6]= "";
				$ac_ledgerst[$counter][7]= "";
				$ac_ledgerst[$counter][8]= "";
				if (float_ops($cur_balance, 0, '<'))
				{
					$ac_ledgerst[$counter][9]= "Cr";
					$ac_ledgerst[$counter][10]= convert_cur(-$cur_balance);
				} else {
					$ac_ledgerst[$counter][9]= "Dr";
					$ac_ledgerst[$counter][10]= convert_cur($cur_balance);
				}
				$counter++;

				$ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
				$counter++;

				/* Final Opening and Closing Balance */
				$clbalance = $this->Ledger_model->get_ledger_balance($ledger_id);

				$ac_ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "", "");
				$counter++;

				if (float_ops($clbalance, 0, '=='))
					$ac_ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
				else if ($clbalance < 0)
					$ac_ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "", "");
				else
					$ac_ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "", "");


				$counter++;
				$ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");

				$this->load->helper('csv');
				echo array_to_csv($ac_ledgerst, "ac_ledgerst.csv");
			}

			return;
		}

		/********************** RECONCILIATION ************************/
		if ($statement == "reconciliation")
		{
			$ledger_id = $this->uri->segment(4);
			$reconciliation_type = $this->uri->segment(5);

			if ($ledger_id == '')
				return;
			if ( ! (($reconciliation_type == 'all') or ($reconciliation_type == 'pending')))
				return;

			$this->load->model('Ledger_model');
			$cur_balance = 0;
			$counter = 0;
			$ac_ledgerst = array();

			$ac_ledgerst[$counter] = array ("", "", "RECONCILIATION STATEMENT FOR " . strtoupper($this->Ledger_model->get_name($ledger_id)), "", "", "", "", "", "", "");
			$counter++;
			$ac_ledgerst[$counter] = array ("", "", "FY " . date_mysql_to_php($this->config->item('account_fy_start')) . " - " . date_mysql_to_php($this->config->item('account_fy_end')), "", "", "", "", "", "", "");
			$counter++;

			$ac_ledgerst[$counter][0]= "Date";
			$ac_ledgerst[$counter][1]= "Number";
			$ac_ledgerst[$counter][2]= "Ledger Name";
			$ac_ledgerst[$counter][3]= "Narration";
			$ac_ledgerst[$counter][4]= "Type";
			$ac_ledgerst[$counter][5]= "";
			$ac_ledgerst[$counter][6]= "Dr Amount";
			$ac_ledgerst[$counter][7]= "";
			$ac_ledgerst[$counter][8]= "Cr Amount";
			$ac_ledgerst[$counter][9]= "Reconciliation Date";
			$counter++;

			/* Opening Balance */
			list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);

			$this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date');
			if ($reconciliation_type == 'all')
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
			else
				$this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.reconciliation_date', NULL)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
			$ac_ledgerst_q = $this->db->get();
			foreach ($ac_ledgerst_q->result() as $row)
			{
				/* Entry Type */
				$current_entry_type = entry_type_info($row->ac_entries_entry_type);

				$ac_ledgerst[$counter][0] = date_mysql_to_php($row->ac_entries_date);
				$ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);

				/* Opposite entry name */
				$ac_ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'text');
				$ac_ledgerst[$counter][3] = $row->ac_entries_narration;
				$ac_ledgerst[$counter][4] = $current_entry_type['name'];

				if ($row->ac_entry_items_dc == "D")
				{
					$ac_ledgerst[$counter][5] = convert_dc($row->ac_entry_items_dc);
					$ac_ledgerst[$counter][6] = $row->ac_entry_items_amount;
					$ac_ledgerst[$counter][7] = "";
					$ac_ledgerst[$counter][8] = "";

				} else {
					$ac_ledgerst[$counter][5] = "";
					$ac_ledgerst[$counter][6] = "";
					$ac_ledgerst[$counter][7] = convert_dc($row->ac_entry_items_dc);
					$ac_ledgerst[$counter][8] = $row->ac_entry_items_amount;
				}

				if ($row->ac_entry_items_reconciliation_date)
				{
					$ac_ledgerst[$counter][9] = date_mysql_to_php($row->ac_entry_items_reconciliation_date);
				} else {
					$ac_ledgerst[$counter][9] = "";
				}
				$counter++;
			}

			$counter++;
			$ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "");
			$counter++;

			/* Final Opening and Closing Balance */
			$clbalance = $this->Ledger_model->get_ledger_balance($ledger_id);

			$ac_ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "");
			$counter++;

			if (float_ops($clbalance, 0, '=='))
				$ac_ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "");
			else if (float_ops($clbalance, 0, '<'))
				$ac_ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "");
			else
				$ac_ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "");

			/************* Final Reconciliation Balance ***********/

			/* Reconciliation Balance - Dr */
			$this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D')->where('ac_entry_items.reconciliation_date IS NOT NULL');
			$dr_total_q = $this->db->get();
			if ($dr_total = $dr_total_q->row())
				$reconciliation_dr_total = $dr_total->drtotal;
			else
				$reconciliation_dr_total = 0;

			/* Reconciliation Balance - Cr */
			$this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C')->where('ac_entry_items.reconciliation_date IS NOT NULL');
			$cr_total_q = $this->db->get();
			if ($cr_total = $cr_total_q->row())
				$reconciliation_cr_total = $cr_total->crtotal;
			else
				$reconciliation_cr_total = 0;

			$reconciliation_total = float_ops($reconciliation_dr_total, $reconciliation_cr_total, '-');
			$reconciliation_pending = float_ops($clbalance, $reconciliation_total, '-');

			$counter++;
			if (float_ops($reconciliation_pending, 0, '=='))
				$ac_ledgerst[$counter] = array ("Reconciliation Pending", "", 0, "", "", "", "", "", "", "");
			else if (float_ops($reconciliation_pending, 0, '<'))
				$ac_ledgerst[$counter] = array ("Reconciliation Pending", "Cr", convert_cur(-$reconciliation_pending), "", "", "", "", "", "", "");
			else
				$ac_ledgerst[$counter] = array ("Reconciliation Pending", "Dr", convert_cur($reconciliation_pending), "", "", "", "", "", "", "");

			$counter++;
			if (float_ops($reconciliation_total, 0, '=='))
				$ac_ledgerst[$counter] = array ("Reconciliation Total", "", 0, "", "", "", "", "", "", "");
			else if (float_ops($reconciliation_total, 0, '<'))
				$ac_ledgerst[$counter] = array ("Reconciliation Total", "Cr", convert_cur(-$reconciliation_total), "", "", "", "", "", "", "");
			else
				$ac_ledgerst[$counter] = array ("Reconciliation Total", "Dr", convert_cur($reconciliation_total), "", "", "", "", "", "", "");

			$this->load->helper('csv');
			echo array_to_csv($ac_ledgerst, "reconciliation.csv");
			return;
		}

		/************************ BALANCE SHEET ***********************/
		if ($statement == "balancesheet")
		{
			$this->load->library('accountlist');
			$this->load->model('Ledger_model');

			$liability = new Accountlist();
			$liability->init(2);
			$liability_array = $liability->build_array();
			$liability_depth = Accountlist::$max_depth;
			$liability_total = -$liability->total;

			Accountlist::reset_max_depth();

			$asset = new Accountlist();
			$asset->init(1);
			$asset_array = $asset->build_array();
			$asset_depth = Accountlist::$max_depth;
			$asset_total = $asset->total;

			$liability->to_csv($liability_array);
			Accountlist::add_blank_csv();
			$asset->to_csv($asset_array);

			$income = new Accountlist();
			$income->init(3);
			$expense = new Accountlist();
			$expense->init(4);
			$income_total = -$income->total;
			$expense_total = $expense->total;
			$pandl = float_ops($income_total, $expense_total, '-');
			$diffop = $this->Ledger_model->get_diff_op_balance();

			Accountlist::add_blank_csv();
			/* Liability side */
			$total = $liability_total;
			Accountlist::add_row_csv(array("Liabilities and Owners Equity Total", convert_cur($liability_total)));

			/* If Profit then Liability side, If Loss then Asset side */
			if (float_ops($pandl, 0, '!='))
			{
				if (float_ops($pandl, 0, '>'))
				{
					$total = float_ops($total, $pandl, '+');
					Accountlist::add_row_csv(array("Profit & Loss Account (Net Profit)", convert_cur($pandl)));
				}
			}

			/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
			if (float_ops($diffop, 0, '!='))
			{
				if (float_ops($diffop, 0, '>'))
				{
					$total = float_ops($total, $diffop, '+');
					Accountlist::add_row_csv(array("Diff in O/P Balance", "Dr " . convert_cur($diffop)));
				}
			}

			Accountlist::add_row_csv(array("Total - Liabilities and Owners Equity", convert_cur($total)));

			/* Asset side */
			$total = $asset_total;
			Accountlist::add_row_csv(array("Asset Total", convert_cur($asset_total)));

			/* If Profit then Liability side, If Loss then Asset side */
			if (float_ops($pandl, 0, '!='))
			{
				if (float_ops($pandl, 0, '<'))
				{
					$total = float_ops($total, -$pandl, '+');
					Accountlist::add_row_csv(array("Profit & Loss Account (Net Loss)", convert_cur(-$pandl)));
				}
			}

			/* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
			if (float_ops($diffop, 0, '!='))
			{
				if (float_ops($diffop, 0, '<'))
				{
					$total = float_ops($total, -$diffop, '+');
					Accountlist::add_row_csv(array("Diff in O/P Balance", "Cr " . convert_cur(-$diffop)));
				}
			}

			Accountlist::add_row_csv(array("Total - Assets", convert_cur($total)));

			$balancesheet = Accountlist::get_csv();
			$this->load->helper('csv');
			echo array_to_csv($balancesheet, "balancesheet.csv");
			return;
		}

		/********************** PROFIT AND LOSS ***********************/
		if ($statement == "profitandloss")
		{
			$this->load->library('accountlist');
			$this->load->model('Ledger_model');

			/***************** GROSS CALCULATION ******************/

			/* Gross P/L : Expenses */
			$gross_expense_total = 0;
			$this->db->from('ac_groups')->where('parent_id', 4)->where('affects_gross', 1);
			$gross_expense_list_q = $this->db->get();
			foreach ($gross_expense_list_q->result() as $row)
			{
				$gross_expense = new Accountlist();
				$gross_expense->init($row->id);
				$gross_expense_total = float_ops($gross_expense_total, $gross_expense->total, '+');
				$gross_exp_array = $gross_expense->build_array();
				$gross_expense->to_csv($gross_exp_array);
			}
			Accountlist::add_blank_csv();

			/* Gross P/L : Incomes */
			$gross_income_total = 0;
			$this->db->from('ac_groups')->where('parent_id', 3)->where('affects_gross', 1);
			$gross_income_list_q = $this->db->get();
			foreach ($gross_income_list_q->result() as $row)
			{
				$gross_income = new Accountlist();
				$gross_income->init($row->id);
				$gross_income_total = float_ops($gross_income_total, $gross_income->total, '+');
				$gross_inc_array = $gross_income->build_array();
				$gross_income->to_csv($gross_inc_array);
			}

			Accountlist::add_blank_csv();
			Accountlist::add_blank_csv();

			/* Converting to positive value since Cr */
			$gross_income_total = -$gross_income_total;

			/* Calculating Gross P/L */
			$grosspl = float_ops($gross_income_total, $gross_expense_total, '-');

			/* Showing Gross P/L : Expenses */
			$grosstotal = $gross_expense_total;
			Accountlist::add_row_csv(array("Total Gross Expenses", convert_cur($gross_expense_total)));
			if (float_ops($grosspl, 0, '>'))
			{
				$grosstotal = float_ops($grosstotal, $grosspl, '+');
				Accountlist::add_row_csv(array("Gross Profit C/O", convert_cur($grosspl)));
			}
			Accountlist::add_row_csv(array("Total Expenses - Gross", convert_cur($grosstotal)));

			/* Showing Gross P/L : Incomes  */
			$grosstotal = $gross_income_total;
			Accountlist::add_row_csv(array("Total Gross Incomes", convert_cur($gross_income_total)));

			if (float_ops($grosspl, 0, '>'))
			{

			} else if (float_ops($grosspl, 0, '<')) {
				$grosstotal = float_ops($grosstotal, -$grosspl, '+');
				Accountlist::add_row_csv(array("Gross Loss C/O", convert_cur(-$grosspl)));
			}
			Accountlist::add_row_csv(array("Total Incomes - Gross", convert_cur($grosstotal)));

			/************************* NET CALCULATIONS ***************************/

			Accountlist::add_blank_csv();
			Accountlist::add_blank_csv();

			/* Net P/L : Expenses */
			$net_expense_total = 0;
			$this->db->from('ac_groups')->where('parent_id', 4)->where('affects_gross !=', 1);
			$net_expense_list_q = $this->db->get();
			foreach ($net_expense_list_q->result() as $row)
			{
				$net_expense = new Accountlist();
				$net_expense->init($row->id);
				$net_expense_total = float_ops($net_expense_total, $net_expense->total, '+');
				$net_exp_array = $net_expense->build_array();
				$net_expense->to_csv($net_exp_array);
			}
			Accountlist::add_blank_csv();

			/* Net P/L : Incomes */
			$net_income_total = 0;
			$this->db->from('ac_groups')->where('parent_id', 3)->where('affects_gross !=', 1);
			$net_income_list_q = $this->db->get();
			foreach ($net_income_list_q->result() as $row)
			{
				$net_income = new Accountlist();
				$net_income->init($row->id);
				$net_income_total = float_ops($net_income_total, $net_income->total, '+');
				$net_inc_array = $net_income->build_array();
				$net_income->to_csv($net_inc_array);
			}

			Accountlist::add_blank_csv();
			Accountlist::add_blank_csv();

			/* Converting to positive value since Cr */
			$net_income_total = -$net_income_total;

			/* Calculating Net P/L */
			$netpl = float_ops(float_ops($net_income_total, $net_expense_total, '-'), $grosspl, '+');

			/* Showing Net P/L : Expenses */
			$nettotal = $net_expense_total;
			Accountlist::add_row_csv(array("Total Expenses", convert_cur($nettotal)));

			if (float_ops($grosspl, 0, '>'))
			{
			} else if (float_ops($grosspl, 0, '<')) {
				$nettotal = float_ops($nettotal, -$grosspl, '+');
				Accountlist::add_row_csv(array("Gross Loss B/F", convert_cur(-$grosspl)));
			}
			if (float_ops($netpl, 0, '>'))
			{
				$nettotal = float_ops($nettotal, $netpl, '+');
				Accountlist::add_row_csv(array("Net Profit", convert_cur($netpl)));
			}
			Accountlist::add_row_csv(array("Total - Net Expenses", convert_cur($nettotal)));

			/* Showing Net P/L : Incomes */
			$nettotal = $net_income_total;
			Accountlist::add_row_csv(array("Total Incomes", convert_cur($nettotal)));

			if ($grosspl > 0)
			{
				$nettotal = float_ops($nettotal, $grosspl, '+');
				Accountlist::add_row_csv(array("Gross Profit B/F", convert_cur($grosspl)));
			}

			if ($netpl > 0)
			{

			} else if ($netpl < 0) {
				$nettotal = float_ops($nettotal, -$netpl, '+');
				Accountlist::add_row_csv(array("Net Loss", convert_cur(-$netpl)));
			}
			Accountlist::add_row_csv(array("Total - Net Incomes", convert_cur($nettotal)));

			$balancesheet = Accountlist::get_csv();
			$this->load->helper('csv');
			echo array_to_csv($balancesheet, "profitandloss.csv");
			return;
		}
		if ($statement == "payments"){
			$start_date = $this->uri->segment(5);
			$end_date = $this->uri->segment(6);
			$supplier_name = $this->uri->segment(7);
			if($start_date == "" || $end_date == ""){
				$this->session->set_flashdata('error','Please fill start date and end date.');
				$this->load->library('user_agent');
				redirect($this->agent->referrer(), 'refresh');
			}else{
				$cur_balance = 0;
				$counter = 0;
				$ac_ledgerst = array();

				$ac_ledgerst[$counter] = array ("", "", "Payment Report from ".$start_date." to ".$end_date, "", "", "", "", "", "", "");
				$counter++;

				$ac_ledgerst[$counter][0]= "Date";
				$ac_ledgerst[$counter][1]= "Entry No";
				$ac_ledgerst[$counter][2]= "Payee Name";
				$ac_ledgerst[$counter][3]= "Project Name";
				$ac_ledgerst[$counter][4]= "Narration";
				$ac_ledgerst[$counter][5]= "Bank";
				$ac_ledgerst[$counter][6]= "Cheque No";
				$ac_ledgerst[$counter][7]= "Amount";
				$ac_ledgerst[$counter][8]= "Confirmed By";
				$ac_ledgerst[$counter][9]= "Cheque Status";
				$counter++;

				$ac_vouchers = $this->paymentvoucher_model->get_approved_payments_range($this->session->userdata('branchid'),$start_date,$end_date,$supplier_name,2);
				if($ac_vouchers)
				foreach ($ac_vouchers as $row)
				{

					$ac_ledgerst[$counter][0] = $row->date;
					$ac_ledgerst[$counter][1] = full_entry_number($row->entry_type, $row->number);
					$ac_ledgerst[$counter][2] = $row->CHQNAME;
					$ac_ledgerst[$counter][3] = get_voucher_by_entry($row->id);
					$ac_ledgerst[$counter][4] = $row->narration;
					$ac_ledgerst[$counter][5] = $this->Ledger_model->get_entry_name($row->id, $row->entry_type);
					$ac_ledgerst[$counter][6] = $row->CHQNO;
					$ac_ledgerst[$counter][7] = number_format($row->dr_total, 2, '.', ',');
					$ac_ledgerst[$counter][8] = get_user_fullname_id($row->confirm_by);
					$ac_ledgerst[$counter][9] = $row->CHQSTATUS;
					$counter++;
				}
				$this->load->helper('csv');
				echo array_to_csv($ac_ledgerst, "payment_report_".$start_date."_".$end_date.".csv");
				return;
			}
		}
		if ($statement == "receipts"){
			$start_date = $this->uri->segment(5);
			$end_date = $this->uri->segment(6);
			$payment_mode = $this->uri->segment(7);
			if($start_date == "" || $end_date == ""){
				$this->session->set_flashdata('error','Please fill start date and end date.');
				$this->load->library('user_agent');
				redirect($this->agent->referrer(), 'refresh');
			}else{
				/*Ticket No:3098 Updated By Madushan 2021-07-14*/
				$cur_balance = 0;
				$counter = 0;
				$receipt_total=0.0;
				$ac_ledgerst = array();

				$ac_ledgerst[$counter] = array ("", "", "Receipt Report from ".$start_date." to ".$end_date, "", "", "", "", "", "", "");
				$counter++;
					//ticket no 2900
				$ac_ledgerst[$counter][0]= "Date";
				$ac_ledgerst[$counter][1]= "Receipting Branch Code";
				$ac_ledgerst[$counter][2]= "Receipt Number";
				$ac_ledgerst[$counter][3]= "temporary Receipt Number";
				$ac_ledgerst[$counter][4]= "Customer Name";
				$ac_ledgerst[$counter][5]= "Project Name";
				$ac_ledgerst[$counter][6]= "Lot No";
				$ac_ledgerst[$counter][7]= "Narration";
				$ac_ledgerst[$counter][8]= "Payment Mode";
				$ac_ledgerst[$counter][9]= "Amount";
				$ac_ledgerst[$counter][10]= "CHQ Number";
				$ac_ledgerst[$counter][11]= "User ID";
				$counter++;

				$ac_receipts = $this->reciept_model->get_receipt_range($this->session->userdata('branchid'),$start_date,$end_date,$payment_mode);
				if($ac_receipts)
				foreach ($ac_receipts as $row)
				{
					$projectarr=get_project_name_and_lot_bymodule($row->module,$row->prj_id,$row->lot_id);
						//ticket no 2900
            $br_name=get_branch_name($row->branch_code);
					$ac_ledgerst[$counter][0] = date('Y-m-d',strtotime($row->date));
					$ac_ledgerst[$counter][1] = $row->branch_code.'-'.$br_name;
					$ac_ledgerst[$counter][2] = $row->RCTNO;
					$ac_ledgerst[$counter][3] = $row->temp_rctno;
					$ac_ledgerst[$counter][4] = $row->rcvname;
					$ac_ledgerst[$counter][5] = $projectarr[0];
					$ac_ledgerst[$counter][6] = $projectarr[1];
					$ac_ledgerst[$counter][7] = $row->narration;
					$ac_ledgerst[$counter][8] = $row->rcvmode;
					$ac_ledgerst[$counter][9] = floatval($row->dr_total);
					$ac_ledgerst[$counter][10]= $row->CHQNO;
					$ac_ledgerst[$counter][11]= $row->display_name.'('.$row->USRNAME.')';

					$receipt_total = $receipt_total + floatval($row->dr_total);
					$counter++;
				}
					$ac_ledgerst[$counter][0] = '';
					$ac_ledgerst[$counter][1] = '';
					$ac_ledgerst[$counter][2] = '';
					$ac_ledgerst[$counter][3] = '';
					$ac_ledgerst[$counter][4] =	'';
					$ac_ledgerst[$counter][5] = '';
					$ac_ledgerst[$counter][6] = '';
					$ac_ledgerst[$counter][7] = '';
					$ac_ledgerst[$counter][8] = '';					
					$ac_ledgerst[$counter][9] = $receipt_total;
				$this->load->helper('csv');
				echo array_to_csv($ac_ledgerst, "receipt_report_".$start_date."_".$end_date.".csv");
				return;
			}
		}

		return;
	}
//    function balancesheet($period = NULL)
//    {
//        $this->template->set('page_title', 'Balance Sheet');
//        $this->template->set('nav_links', array('report/download/balancesheet' => 'Download CSV', 'report/printpreview/balancesheet' => 'Print Preview'));
//        $data['left_width'] = "450";
//        $data['right_width'] = "450";
//        $this->template->load('template', 'report/balancesheet', $data);
//        return;
//    }
//
//    function profitandloss($period = NULL)
//    {
//        $this->template->set('page_title', 'Profit And Loss Statement');
//        $this->template->set('nav_links', array('report/download/profitandloss' => 'Download CSV', 'report/printpreview/profitandloss' => 'Print Preview'));
//        $data['left_width'] = "450";
//        $data['right_width'] = "450";
//        $this->template->load('template', 'report/profitandloss', $data);
//        return;
//    }

//    function trialbalance($period = NULL)
//    {
//        $this->template->set('page_title', 'Trial Balance');
//        $this->template->set('nav_links', array('report/trialbalance_report' => 'Download CSV', 'report/printpreview/trialbalance' => 'Print Preview'));
//
//        $this->load->library('accountlist');
//        $this->template->load('template', 'report/trialbalance');
//        return;
//    }
//    function trialbalance_report($period = NULL)
//    {
//        $this->template->set('page_title', 'Trial Balance');
//        $this->template->set('nav_links', array('report/download/trialbalance' => 'Download CSV', 'report/printpreview/trialbalance' => 'Print Preview'));
//
//        $this->load->library('accountlist');
//        $this->load->view('report/trialbalance_report');
//        return;
//    }

    function ac_config_ledgerst($ledger_id = "")
    {
//        var_dump($ledger_id);
//        die();
        $this->load->helper('text');
       // $this->template->set('nav_links', array('report/download/ac_ledgerstall'  => 'Download General Ledger CSV','report/printledgerall'  => 'Print General Ledger CSV'));
        /* Pagination setup */
        $this->load->library('pagination');

        //$this->template->set('page_title', 'Ledger Statement');
        if ($ledger_id != "")
            //$this->template->set('nav_links', array('report/download/ac_ledgerst/' . $ledger_id  => 'Download CSV', 'report/printpreview/ac_ledgerst/' . $ledger_id => 'Print Preview'));

        if ($_POST)
        {
            $ledger_id = $this->input->post('ledger_id', TRUE);
            redirect('accounts/report/ac_config_ledgerst/' . $ledger_id);
        }
        $data['print_preview'] = FALSE;
        $data['ledger_id'] = $ledger_id;

        /* Checking for valid ledger id */
        if ($data['ledger_id'] != "")
        {
            $this->db->from('ac_config_ledgers')->where('id', $data['ledger_id'])->limit(1);
            if ($this->db->get()->num_rows() < 1)
            {
                //$this->messages->add('Invalid Ledger account.', 'error');
                $this->session->set_flashdata('error', 'Invalid Ledger account.');
                redirect('accounts/report/ac_config_ledgerst');
                return;
            }
        }
//echo "sss".$data['ledger_id'];
        //$this->template->load('template', 'report/ac_ledgerst', $data);
        $this->load->view('accounts/report/ac_config_ledgerst',$data);
        return;
    }

//    function reconciliation($reconciliation_type = '', $ledger_id = 0)
//    {
//        $this->load->helper('text');
//
//        /* Pagination setup */
//        $this->load->library('pagination');
//
//        $this->template->set('page_title', 'Reconciliation');
//        //$this->template->set('nav_links', array('entry/add/recon' => 'Add Entry'));
//
//        /* Check if path is 'all' or 'pending' */
//        $data['show_all'] = FALSE;
//        $data['print_preview'] = FALSE;
//        $data['ledger_id'] = $ledger_id;
//        if ($reconciliation_type == 'all')
//        {
//            $data['reconciliation_type'] = 'all';
//            $data['show_all'] = TRUE;
//            if ($ledger_id != '0')
//                $this->template->set('nav_links', array('report/download/reconciliation/' . $ledger_id . '/all'  => 'Download CSV', 'report/printpreview/reconciliation/' . $ledger_id . '/all' => 'Print Preview'));
//        } else if ($reconciliation_type == 'pending') {
//            $data['reconciliation_type'] = 'pending';
//            $data['show_all'] = FALSE;
//            if ($ledger_id != '0')
//                $this->template->set('nav_links', array('report/download/reconciliation/' . $ledger_id . '/pending'  => 'Download CSV', 'report/printpreview/reconciliation/' . $ledger_id . '/pending'  => 'Print Preview'));
//        } else {
//            $this->messages->add('Invalid path.', 'error');
//            redirect('report/reconciliation/pending');
//            return;
//        }
//
//        /* Checking for valid ledger id and reconciliation status */
//        if ($data['ledger_id'] > 0)
//        {
//            $this->db->from('ac_ledgers')->where('id', $data['ledger_id'])->where('reconciliation', 1)->limit(1);
//            if ($this->db->get()->num_rows() < 1)
//            {
//                $this->messages->add('Invalid Ledger account or Reconciliation is not enabled for the Ledger account.', 'error');
//                redirect('report/reconciliation/' . $reconciliation_type);
//                return;
//            }
//        } else if ($data['ledger_id'] < 0) {
//            $this->messages->add('Invalid Ledger account.', 'error');
//            redirect('report/reconciliation/' . $reconciliation_type);
//            return;
//        }
//
//        if ($_POST)
//        {
//            /* Check if Ledger account is changed or reconciliation is updated */
//            if ($_POST['submit'] == 'Submit')
//            {
//                $ledger_id = $this->input->post('ledger_id', TRUE);
//                if ($this->input->post('show_all', TRUE))
//                {
//                    redirect('report/reconciliation/all/' . $ledger_id);
//                    return;
//                } else {
//                    redirect('report/reconciliation/pending/' . $ledger_id);
//                    return;
//                }
//            } else if ($_POST['submit'] == 'Update') {
//
//                $data_reconciliation_date = $this->input->post('reconciliation_date', TRUE);
//
//                /* Form validations */
//                foreach ($data_reconciliation_date as $id => $row)
//                {
//                    /* If reconciliation date is present then check for valid date else only trim */
//                    if ($row)
//                        $this->form_validation->set_rules('reconciliation_date[' . $id . ']', 'Reconciliation date', 'trim|required|is_date|is_date_within_range_reconcil');
//                    else
//                        $this->form_validation->set_rules('reconciliation_date[' . $id . ']', 'Reconciliation date', 'trim');
//                }
//
//                if ($this->form_validation->run() == FALSE)
//                {
//                    $this->messages->add(validation_errors(), 'error');
//                    $this->template->load('template', 'report/reconciliation', $data);
//                    return;
//                } else {
//                    /* Updating reconciliation date */
//                    foreach ($data_reconciliation_date as $id => $row)
//                    {
//                        $this->db->trans_start();
//                        if ($row)
//                        {
//                            $update_data = array(
//                                'reconciliation_date' => date_php_to_mysql($row),
//                            );
//                        } else {
//                            $update_data = array(
//                                'reconciliation_date' => NULL,
//                            );
//                        }
//                        if ( ! $this->db->where('id', $id)->update('ac_entry_items', $update_data))
//                        {
//                            $this->db->trans_rollback();
//                            $this->messages->add('Error updating reconciliation.', 'error');
//                            $this->logger->write_message("error", "Error updating reconciliation for entry item [id:" . $id . "]");
//                        } else {
//                            $this->db->trans_complete();
//                        }
//                    }
//                    $this->messages->add('Updated reconciliation.', 'success');
//                    $this->logger->write_message("success", 'Updated reconciliation.');
//                }
//            }
//        }
//        $this->template->load('template', 'report/reconciliation', $data);
//        return;
//    }
//
//    function download($statement, $id = NULL)
//    {
//        /********************** TRIAL BALANCE *************************/
//        if ($statement == "trialbalance")
//        {
//            $this->load->model('Ledger_model');
//            $all_ac_ledgers = $this->Ledger_model->get_all_ac_ledgers();
//            $counter = 0;
//            $trialbalance = array();
//            $temp_dr_total = 0;
//            $temp_cr_total = 0;
//
//            $trialbalance[$counter] = array ("TRIAL BALANCE", "", "", "", "", "", "", "", "");
//            $counter++;
//            $trialbalance[$counter] = array ("as at " . date("jS F Y"), "", "", "", "", "", "", "", "");
//            $counter++;
//
//            $trialbalance[$counter][0]= "Ledger";
//            $trialbalance[$counter][1]= "";
//            $trialbalance[$counter][2]= "Opening";
//            $trialbalance[$counter][3]= "";
//            $trialbalance[$counter][4]= "Closing";
//            $trialbalance[$counter][5]= "";
//            $trialbalance[$counter][6]= "Dr(Rs) Total";
//            $trialbalance[$counter][7]= "";
//            $trialbalance[$counter][8]= "Cr(Rs) Total";
//            $counter++;
//
//            foreach ($all_ac_ledgers as $ledger_id => $ledger_name)
//            {
//                if ($ledger_id == '') continue;
//
//                $trialbalance[$counter][0] = $ledger_name;
//
//                list ($opbal_amount, $opbal_type) = $this->Ledger_model->get_op_balance($ledger_id);
//                if (float_ops($opbal_amount, 0, '=='))
//                {
//                    $trialbalance[$counter][1] = "";
//                    $trialbalance[$counter][2] = 0;
//                } else {
//                    $trialbalance[$counter][1] = convert_dc($opbal_type);
//                    $trialbalance[$counter][2] = $opbal_amount;
//                }
//
//                $clbal_amount = $this->Ledger_model->get_ledger_balance($ledger_id);
//
//                if (float_ops($clbal_amount, 0, '=='))
//                {
//                    $trialbalance[$counter][3] = "";
//                    $trialbalance[$counter][4] = 0;
//                } else if ($clbal_amount < 0) {
//                    $trialbalance[$counter][3] = "Cr";
//                    $trialbalance[$counter][4] = convert_cur(-$clbal_amount);
//                } else {
//                    $trialbalance[$counter][3] = "Dr";
//                    $trialbalance[$counter][4] = convert_cur($clbal_amount);
//                }
//
//                $dr_total = $this->Ledger_model->get_dr_total($ledger_id);
//                if ($dr_total)
//                {
//                    $trialbalance[$counter][5] = "Dr";
//                    $trialbalance[$counter][6] = convert_cur($dr_total);
//                    $temp_dr_total = float_ops($temp_dr_total, $dr_total, '+');
//                } else {
//                    $trialbalance[$counter][5] = "";
//                    $trialbalance[$counter][6] = 0;
//                }
//
//                $cr_total = $this->Ledger_model->get_cr_total($ledger_id);
//                if ($cr_total)
//                {
//                    $trialbalance[$counter][7] = "Cr";
//                    $trialbalance[$counter][8] = convert_cur($cr_total);
//                    $temp_cr_total = float_ops($temp_cr_total, $cr_total, '+');
//                } else {
//                    $trialbalance[$counter][7] = "";
//                    $trialbalance[$counter][8] = 0;
//                }
//                $counter++;
//            }
//
//            $trialbalance[$counter][0]= "";
//            $trialbalance[$counter][1]= "";
//            $trialbalance[$counter][2]= "";
//            $trialbalance[$counter][3]= "";
//            $trialbalance[$counter][4]= "";
//            $trialbalance[$counter][5]= "";
//            $trialbalance[$counter][6]= "";
//            $trialbalance[$counter][7]= "";
//            $trialbalance[$counter][8]= "";
//            $counter++;
//
//            $trialbalance[$counter][0]= "Total";
//            $trialbalance[$counter][1]= "";
//            $trialbalance[$counter][2]= "";
//            $trialbalance[$counter][3]= "";
//            $trialbalance[$counter][4]= "";
//            $trialbalance[$counter][5]= "Dr";
//            $trialbalance[$counter][6]= convert_cur($temp_dr_total);
//            $trialbalance[$counter][7]= "Cr";
//            $trialbalance[$counter][8]= convert_cur($temp_cr_total);
//
//            $this->load->helper('csv');
//            echo array_to_csv($trialbalance, "trialbalance.csv");
//            return;
//        }
//
//        /********************** LEDGER STATEMENT **********************/
//        if ($statement == "ac_ledgerst")
//        {
//            $this->load->helper('text');
//            $ledger_id = $this->uri->segment(4);
//            if ($ledger_id =='')
//                return;
//
//            $this->load->model('Ledger_model');
//            $cur_balance = 0;
//            $counter = 0;
//            $ac_ledgerst = array();
//
//            $ac_ledgerst[$counter] = array ("", "", "LEDGER STATEMENT FOR " . strtoupper($this->Ledger_model->get_name($ledger_id)), "", "", "", "", "", "", "", "");
//            $counter++;
//            $ac_ledgerst[$counter] = array ("", "", "FY " . date_mysql_to_php($this->config->item('account_fy_start')) . " - " . date_mysql_to_php($this->config->item('account_fy_end')), "", "", "", "", "", "", "", "");
//            $counter++;
//
//            $ac_ledgerst[$counter][0]= "Date";
//            $ac_ledgerst[$counter][1]= "Number";
//            $ac_ledgerst[$counter][2]= "Ledger Name";
//            $ac_ledgerst[$counter][3]= "Narration";
//            $ac_ledgerst[$counter][4]= "Type";
//            $ac_ledgerst[$counter][5]= "RCT/CHQ No";
//            $ac_ledgerst[$counter][6]= "";
//            $ac_ledgerst[$counter][7]= "Dr Amount";
//            $ac_ledgerst[$counter][8]= "";
//            $ac_ledgerst[$counter][9]= "Cr Amount";
//            $ac_ledgerst[$counter][10]= "";
//            $ac_ledgerst[$counter][11]= "Balance";
//            $counter++;
//
//            /* Opening Balance */
//            list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
//            $ac_ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", "", convert_dc($optype), $opbalance);
//            if ($optype == "D")
//                $cur_balance = float_ops($cur_balance, $opbalance, '+');
//            else
//                $cur_balance = float_ops($cur_balance, $opbalance, '-');
//            $counter++;
//
//            $this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc,,ac_chqprint.CHQNO ,ac_recieptdata.RCTNO');
//            $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->join('ac_chqprint', 'ac_chqprint.PAYREFNO =ac_entries.id','left')->join('ac_recieptdata', 'ac_recieptdata.RCTREFNO =ac_entries.id','left')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
//            $ac_ledgerst_q = $this->db->get();
//            foreach ($ac_ledgerst_q->result() as $row)
//            {
//                /* Entry Type */
//                $current_entry_type = entry_type_info($row->ac_entries_entry_type);
//
//                $ac_ledgerst[$counter][0] = date_mysql_to_php($row->ac_entries_date);
//                $ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
//
//                /* Opposite entry name */
//                $ac_ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'text');
//                $ac_ledgerst[$counter][3] = $row->ac_entries_narration;
//                $ac_ledgerst[$counter][4] = $current_entry_type['name'];
//                $ac_ledgerst[$counter][5] = $row->CHQNO.$row->RCTNO;
//
//                if ($row->ac_entry_items_dc == "D")
//                {
//                    $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
//                    $ac_ledgerst[$counter][6] = convert_dc($row->ac_entry_items_dc);
//                    $ac_ledgerst[$counter][7] = $row->ac_entry_items_amount;
//                    $ac_ledgerst[$counter][8] = "";
//                    $ac_ledgerst[$counter][9] = "";
//
//                } else {
//                    $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
//                    $ac_ledgerst[$counter][6] = "";
//                    $ac_ledgerst[$counter][7] = "";
//                    $ac_ledgerst[$counter][8] = convert_dc($row->ac_entry_items_dc);
//                    $ac_ledgerst[$counter][9] = $row->ac_entry_items_amount;
//                }
//
//                if (float_ops($cur_balance, 0, '=='))
//                {
//                    $ac_ledgerst[$counter][10] = "";
//                    $ac_ledgerst[$counter][11] = 0;
//                } else if (float_ops($cur_balance, 0, '<')) {
//                    $ac_ledgerst[$counter][10] = "Cr";
//                    $ac_ledgerst[$counter][11] = convert_cur(-$cur_balance);
//                } else {
//                    $ac_ledgerst[$counter][10] = "Dr";
//                    $ac_ledgerst[$counter][11] =  convert_cur($cur_balance);
//                }
//                $counter++;
//            }
//
//            $ac_ledgerst[$counter][0]= "Closing Balance";
//            $ac_ledgerst[$counter][1]= "";
//            $ac_ledgerst[$counter][2]= "";
//            $ac_ledgerst[$counter][3]= "";
//            $ac_ledgerst[$counter][4]= "";
//            $ac_ledgerst[$counter][5]= "";
//            $ac_ledgerst[$counter][6]= "";
//            $ac_ledgerst[$counter][7]= "";
//            $ac_ledgerst[$counter][8]= "";
//            $ac_ledgerst[$counter][9]= "";
//            if (float_ops($cur_balance, 0, '<'))
//            {
//                $ac_ledgerst[$counter][10]= "Cr";
//                $ac_ledgerst[$counter][11]= convert_cur(-$cur_balance);
//            } else {
//                $ac_ledgerst[$counter][10]= "Dr";
//                $ac_ledgerst[$counter][11]= convert_cur($cur_balance);
//            }
//            $counter++;
//
//            $ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
//            $counter++;
//
//            /* Final Opening and Closing Balance */
//            $clbalance = $this->Ledger_model->get_ledger_balance($ledger_id);
//
//            $ac_ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "", "");
//            $counter++;
//
//            if (float_ops($clbalance, 0, '=='))
//                $ac_ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
//            else if ($clbalance < 0)
//                $ac_ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "", "");
//            else
//                $ac_ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "", "");
//
//            $this->load->helper('csv');
//            echo array_to_csv($ac_ledgerst, "ac_ledgerst.csv");
//            return;
//        }
//
//        /************************** General Ledger Statement *****************/
//        if ($statement == "ac_ledgerstall")
//        {
//            $this->load->helper('text');
//            $this->load->model('Ledger_model');
//            $ac_ledgers = $this->Ledger_model->get_ac_ledgers_list_all();
//            ob_start();
//            foreach ($ac_ledgers as $row){
//                $group = $row->gname;
//                $ledger_id = $row->id;
//                $cur_balance = 0;
//                $counter = 0;
//                $ac_ledgerst = array();
//
//                $ac_ledgerst[$counter] = array ("", "", "LEDGER STATEMENT FOR " .$ledger_id."  ". strtoupper($this->Ledger_model->get_name($ledger_id)." - ".$group)."", "", "", "", "", "", "", "", "");
//                $counter++;
//                $ac_ledgerst[$counter] = array ("", "", "FY " . date_mysql_to_php($this->config->item('account_fy_start')) . " - " . date_mysql_to_php($this->config->item('account_fy_end')), "", "", "", "", "", "", "", "");
//                $counter++;
//
//                $ac_ledgerst[$counter][0]= "Date";
//                $ac_ledgerst[$counter][1]= "Number";
//                $ac_ledgerst[$counter][2]= "Ledger Name";
//                $ac_ledgerst[$counter][3]= "Narration";
//                $ac_ledgerst[$counter][4]= "Type";
//                $ac_ledgerst[$counter][5]= "";
//                $ac_ledgerst[$counter][6]= "Dr Amount";
//                $ac_ledgerst[$counter][7]= "";
//                $ac_ledgerst[$counter][8]= "Cr Amount";
//                $ac_ledgerst[$counter][9]= "";
//                $ac_ledgerst[$counter][10]= "Balance";
//                $counter++;
//
//                /* Opening Balance */
//                list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
//                $ac_ledgerst[$counter] = array ("Opening Balance", "", "", "", "", "", "", "", "", convert_dc($optype), $opbalance);
//                if ($optype == "D")
//                    $cur_balance = float_ops($cur_balance, $opbalance, '+');
//                else
//                    $cur_balance = float_ops($cur_balance, $opbalance, '-');
//                $counter++;
//
//                $this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc');
//                $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
//                $ac_ledgerst_q = $this->db->get();
//                foreach ($ac_ledgerst_q->result() as $row)
//                {
//                    /* Entry Type */
//                    $current_entry_type = entry_type_info($row->ac_entries_entry_type);
//
//                    $ac_ledgerst[$counter][0] = date_mysql_to_php($row->ac_entries_date);
//                    //$ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
//                    if ($row->ac_entries_entry_type==2){
//                        $this->db->select('id')->from('ac_entries')->where('number',$row->ac_entries_number);
//                        $result = $this->db->get();
//                        $entry = $result->row();
//
//                        $this->db->select('voucherid')->from('ac_payvoucherdata')->where('entryid',$entry->id);
//                        $result = $this->db->get();
//                        $voucher = $result->row();
//                        if ($voucher){
//                            $ac_ledgerst[$counter][1]	= $voucher->voucherid;
//                        }else{
//                            $ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
//                        }
//                    }else{
//                        $ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
//                    }
//
//                    /* Opposite entry name */
//                    $ac_ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'text');
//                    $ac_ledgerst[$counter][3] = $row->ac_entries_narration;
//                    $ac_ledgerst[$counter][4] = $current_entry_type['name'];
//
//                    if ($row->ac_entry_items_dc == "D")
//                    {
//                        $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
//                        $ac_ledgerst[$counter][5] = convert_dc($row->ac_entry_items_dc);
//                        $ac_ledgerst[$counter][6] = $row->ac_entry_items_amount;
//                        $ac_ledgerst[$counter][7] = "";
//                        $ac_ledgerst[$counter][8] = "";
//
//                    } else {
//                        $cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
//                        $ac_ledgerst[$counter][5] = "";
//                        $ac_ledgerst[$counter][6] = "";
//                        $ac_ledgerst[$counter][7] = convert_dc($row->ac_entry_items_dc);
//                        $ac_ledgerst[$counter][8] = $row->ac_entry_items_amount;
//                    }
//
//                    if (float_ops($cur_balance, 0, '=='))
//                    {
//                        $ac_ledgerst[$counter][9] = "";
//                        $ac_ledgerst[$counter][10] = 0;
//                    } else if (float_ops($cur_balance, 0, '<')) {
//                        $ac_ledgerst[$counter][9] = "Cr";
//                        $ac_ledgerst[$counter][10] = convert_cur(-$cur_balance);
//                    } else {
//                        $ac_ledgerst[$counter][9] = "Dr";
//                        $ac_ledgerst[$counter][10] =  convert_cur($cur_balance);
//                    }
//                    $counter++;
//                }
//
//                $ac_ledgerst[$counter][0]= "Closing Balance";
//                $ac_ledgerst[$counter][1]= "";
//                $ac_ledgerst[$counter][2]= "";
//                $ac_ledgerst[$counter][3]= "";
//                $ac_ledgerst[$counter][4]= "";
//                $ac_ledgerst[$counter][5]= "";
//                $ac_ledgerst[$counter][6]= "";
//                $ac_ledgerst[$counter][7]= "";
//                $ac_ledgerst[$counter][8]= "";
//                if (float_ops($cur_balance, 0, '<'))
//                {
//                    $ac_ledgerst[$counter][9]= "Cr";
//                    $ac_ledgerst[$counter][10]= convert_cur(-$cur_balance);
//                } else {
//                    $ac_ledgerst[$counter][9]= "Dr";
//                    $ac_ledgerst[$counter][10]= convert_cur($cur_balance);
//                }
//                $counter++;
//
//                $ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
//                $counter++;
//
//                /* Final Opening and Closing Balance */
//                $clbalance = $this->Ledger_model->get_ledger_balance($ledger_id);
//
//                $ac_ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "", "");
//                $counter++;
//
//                if (float_ops($clbalance, 0, '=='))
//                    $ac_ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "", "");
//                else if ($clbalance < 0)
//                    $ac_ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "", "");
//                else
//                    $ac_ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "", "");
//
//
//                $counter++;
//                $ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "", "");
//
//                $this->load->helper('csv');
//                echo array_to_csv($ac_ledgerst, "ac_ledgerst.csv");
//            }
//
//            return;
//        }
//
//        /********************** RECONCILIATION ************************/
//        if ($statement == "reconciliation")
//        {
//            $ledger_id = $this->uri->segment(4);
//            $reconciliation_type = $this->uri->segment(5);
//
//            if ($ledger_id == '')
//                return;
//            if ( ! (($reconciliation_type == 'all') or ($reconciliation_type == 'pending')))
//                return;
//
//            $this->load->model('Ledger_model');
//            $cur_balance = 0;
//            $counter = 0;
//            $ac_ledgerst = array();
//
//            $ac_ledgerst[$counter] = array ("", "", "RECONCILIATION STATEMENT FOR " . strtoupper($this->Ledger_model->get_name($ledger_id)), "", "", "", "", "", "", "");
//            $counter++;
//            $ac_ledgerst[$counter] = array ("", "", "FY " . date_mysql_to_php($this->config->item('account_fy_start')) . " - " . date_mysql_to_php($this->config->item('account_fy_end')), "", "", "", "", "", "", "");
//            $counter++;
//
//            $ac_ledgerst[$counter][0]= "Date";
//            $ac_ledgerst[$counter][1]= "Number";
//            $ac_ledgerst[$counter][2]= "Ledger Name";
//            $ac_ledgerst[$counter][3]= "Narration";
//            $ac_ledgerst[$counter][4]= "Type";
//            $ac_ledgerst[$counter][5]= "";
//            $ac_ledgerst[$counter][6]= "Dr Amount";
//            $ac_ledgerst[$counter][7]= "";
//            $ac_ledgerst[$counter][8]= "Cr Amount";
//            $ac_ledgerst[$counter][9]= "Reconciliation Date";
//            $counter++;
//
//            /* Opening Balance */
//            list ($opbalance, $optype) = $this->Ledger_model->get_op_balance($ledger_id);
//
//            $this->db->select('ac_entries.id as ac_entries_id, ac_entries.number as ac_entries_number, ac_entries.date as ac_entries_date, ac_entries.narration as ac_entries_narration, ac_entries.entry_type as ac_entries_entry_type, ac_entry_items.amount as ac_entry_items_amount, ac_entry_items.dc as ac_entry_items_dc, ac_entry_items.reconciliation_date as ac_entry_items_reconciliation_date');
//            if ($reconciliation_type == 'all')
//                $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
//            else
//                $this->db->from('ac_entries')->join('ac_entry_items', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.reconciliation_date', NULL)->order_by('ac_entries.date', 'asc')->order_by('ac_entries.number', 'asc');
//            $ac_ledgerst_q = $this->db->get();
//            foreach ($ac_ledgerst_q->result() as $row)
//            {
//                /* Entry Type */
//                $current_entry_type = entry_type_info($row->ac_entries_entry_type);
//
//                $ac_ledgerst[$counter][0] = date_mysql_to_php($row->ac_entries_date);
//                $ac_ledgerst[$counter][1] = full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number);
//
//                /* Opposite entry name */
//                $ac_ledgerst[$counter][2] = $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'text');
//                $ac_ledgerst[$counter][3] = $row->ac_entries_narration;
//                $ac_ledgerst[$counter][4] = $current_entry_type['name'];
//
//                if ($row->ac_entry_items_dc == "D")
//                {
//                    $ac_ledgerst[$counter][5] = convert_dc($row->ac_entry_items_dc);
//                    $ac_ledgerst[$counter][6] = $row->ac_entry_items_amount;
//                    $ac_ledgerst[$counter][7] = "";
//                    $ac_ledgerst[$counter][8] = "";
//
//                } else {
//                    $ac_ledgerst[$counter][5] = "";
//                    $ac_ledgerst[$counter][6] = "";
//                    $ac_ledgerst[$counter][7] = convert_dc($row->ac_entry_items_dc);
//                    $ac_ledgerst[$counter][8] = $row->ac_entry_items_amount;
//                }
//
//                if ($row->ac_entry_items_reconciliation_date)
//                {
//                    $ac_ledgerst[$counter][9] = date_mysql_to_php($row->ac_entry_items_reconciliation_date);
//                } else {
//                    $ac_ledgerst[$counter][9] = "";
//                }
//                $counter++;
//            }
//
//            $counter++;
//            $ac_ledgerst[$counter] = array ("", "", "", "", "", "", "", "", "", "");
//            $counter++;
//
//            /* Final Opening and Closing Balance */
//            $clbalance = $this->Ledger_model->get_ledger_balance($ledger_id);
//
//            $ac_ledgerst[$counter] = array ("Opening Balance", convert_dc($optype), $opbalance, "", "", "", "", "", "", "");
//            $counter++;
//
//            if (float_ops($clbalance, 0, '=='))
//                $ac_ledgerst[$counter] = array ("Closing Balance", "", 0, "", "", "", "", "", "", "");
//            else if (float_ops($clbalance, 0, '<'))
//                $ac_ledgerst[$counter] = array ("Closing Balance", "Cr", convert_cur(-$clbalance), "", "", "", "", "", "", "");
//            else
//                $ac_ledgerst[$counter] = array ("Closing Balance", "Dr", convert_cur($clbalance), "", "", "", "", "", "", "");
//
//            /************* Final Reconciliation Balance ***********/
//
//            /* Reconciliation Balance - Dr */
//            $this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D')->where('ac_entry_items.reconciliation_date IS NOT NULL');
//            $dr_total_q = $this->db->get();
//            if ($dr_total = $dr_total_q->row())
//                $reconciliation_dr_total = $dr_total->drtotal;
//            else
//                $reconciliation_dr_total = 0;
//
//            /* Reconciliation Balance - Cr */
//            $this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C')->where('ac_entry_items.reconciliation_date IS NOT NULL');
//            $cr_total_q = $this->db->get();
//            if ($cr_total = $cr_total_q->row())
//                $reconciliation_cr_total = $cr_total->crtotal;
//            else
//                $reconciliation_cr_total = 0;
//
//            $reconciliation_total = float_ops($reconciliation_dr_total, $reconciliation_cr_total, '-');
//            $reconciliation_pending = float_ops($clbalance, $reconciliation_total, '-');
//
//            $counter++;
//            if (float_ops($reconciliation_pending, 0, '=='))
//                $ac_ledgerst[$counter] = array ("Reconciliation Pending", "", 0, "", "", "", "", "", "", "");
//            else if (float_ops($reconciliation_pending, 0, '<'))
//                $ac_ledgerst[$counter] = array ("Reconciliation Pending", "Cr", convert_cur(-$reconciliation_pending), "", "", "", "", "", "", "");
//            else
//                $ac_ledgerst[$counter] = array ("Reconciliation Pending", "Dr", convert_cur($reconciliation_pending), "", "", "", "", "", "", "");
//
//            $counter++;
//            if (float_ops($reconciliation_total, 0, '=='))
//                $ac_ledgerst[$counter] = array ("Reconciliation Total", "", 0, "", "", "", "", "", "", "");
//            else if (float_ops($reconciliation_total, 0, '<'))
//                $ac_ledgerst[$counter] = array ("Reconciliation Total", "Cr", convert_cur(-$reconciliation_total), "", "", "", "", "", "", "");
//            else
//                $ac_ledgerst[$counter] = array ("Reconciliation Total", "Dr", convert_cur($reconciliation_total), "", "", "", "", "", "", "");
//
//            $this->load->helper('csv');
//            echo array_to_csv($ac_ledgerst, "reconciliation.csv");
//            return;
//        }
//
//        /************************ BALANCE SHEET ***********************/
//        if ($statement == "balancesheet")
//        {
//            $this->load->library('accountlist');
//            $this->load->model('Ledger_model');
//
//            $liability = new Accountlist();
//            $liability->init(2);
//            $liability_array = $liability->build_array();
//            $liability_depth = Accountlist::$max_depth;
//            $liability_total = -$liability->total;
//
//            Accountlist::reset_max_depth();
//
//            $asset = new Accountlist();
//            $asset->init(1);
//            $asset_array = $asset->build_array();
//            $asset_depth = Accountlist::$max_depth;
//            $asset_total = $asset->total;
//
//            $liability->to_csv($liability_array);
//            Accountlist::add_blank_csv();
//            $asset->to_csv($asset_array);
//
//            $income = new Accountlist();
//            $income->init(3);
//            $expense = new Accountlist();
//            $expense->init(4);
//            $income_total = -$income->total;
//            $expense_total = $expense->total;
//            $pandl = float_ops($income_total, $expense_total, '-');
//            $diffop = $this->Ledger_model->get_diff_op_balance();
//
//            Accountlist::add_blank_csv();
//            /* Liability side */
//            $total = $liability_total;
//            Accountlist::add_row_csv(array("Liabilities and Owners Equity Total", convert_cur($liability_total)));
//
//            /* If Profit then Liability side, If Loss then Asset side */
//            if (float_ops($pandl, 0, '!='))
//            {
//                if (float_ops($pandl, 0, '>'))
//                {
//                    $total = float_ops($total, $pandl, '+');
//                    Accountlist::add_row_csv(array("Profit & Loss Account (Net Profit)", convert_cur($pandl)));
//                }
//            }
//
//            /* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
//            if (float_ops($diffop, 0, '!='))
//            {
//                if (float_ops($diffop, 0, '>'))
//                {
//                    $total = float_ops($total, $diffop, '+');
//                    Accountlist::add_row_csv(array("Diff in O/P Balance", "Dr " . convert_cur($diffop)));
//                }
//            }
//
//            Accountlist::add_row_csv(array("Total - Liabilities and Owners Equity", convert_cur($total)));
//
//            /* Asset side */
//            $total = $asset_total;
//            Accountlist::add_row_csv(array("Asset Total", convert_cur($asset_total)));
//
//            /* If Profit then Liability side, If Loss then Asset side */
//            if (float_ops($pandl, 0, '!='))
//            {
//                if (float_ops($pandl, 0, '<'))
//                {
//                    $total = float_ops($total, -$pandl, '+');
//                    Accountlist::add_row_csv(array("Profit & Loss Account (Net Loss)", convert_cur(-$pandl)));
//                }
//            }
//
//            /* If Op balance Dr then Liability side, If Op balance Cr then Asset side */
//            if (float_ops($diffop, 0, '!='))
//            {
//                if (float_ops($diffop, 0, '<'))
//                {
//                    $total = float_ops($total, -$diffop, '+');
//                    Accountlist::add_row_csv(array("Diff in O/P Balance", "Cr " . convert_cur(-$diffop)));
//                }
//            }
//
//            Accountlist::add_row_csv(array("Total - Assets", convert_cur($total)));
//
//            $balancesheet = Accountlist::get_csv();
//            $this->load->helper('csv');
//            echo array_to_csv($balancesheet, "balancesheet.csv");
//            return;
//        }
//
//        /********************** PROFIT AND LOSS ***********************/
//        if ($statement == "profitandloss")
//        {
//            $this->load->library('accountlist');
//            $this->load->model('Ledger_model');
//
//            /***************** GROSS CALCULATION ******************/
//
//            /* Gross P/L : Expenses */
//            $gross_expense_total = 0;
//            $this->db->from('ac_groups')->where('parent_id', 4)->where('affects_gross', 1);
//            $gross_expense_list_q = $this->db->get();
//            foreach ($gross_expense_list_q->result() as $row)
//            {
//                $gross_expense = new Accountlist();
//                $gross_expense->init($row->id);
//                $gross_expense_total = float_ops($gross_expense_total, $gross_expense->total, '+');
//                $gross_exp_array = $gross_expense->build_array();
//                $gross_expense->to_csv($gross_exp_array);
//            }
//            Accountlist::add_blank_csv();
//
//            /* Gross P/L : Incomes */
//            $gross_income_total = 0;
//            $this->db->from('ac_groups')->where('parent_id', 3)->where('affects_gross', 1);
//            $gross_income_list_q = $this->db->get();
//            foreach ($gross_income_list_q->result() as $row)
//            {
//                $gross_income = new Accountlist();
//                $gross_income->init($row->id);
//                $gross_income_total = float_ops($gross_income_total, $gross_income->total, '+');
//                $gross_inc_array = $gross_income->build_array();
//                $gross_income->to_csv($gross_inc_array);
//            }
//
//            Accountlist::add_blank_csv();
//            Accountlist::add_blank_csv();
//
//            /* Converting to positive value since Cr */
//            $gross_income_total = -$gross_income_total;
//
//            /* Calculating Gross P/L */
//            $grosspl = float_ops($gross_income_total, $gross_expense_total, '-');
//
//            /* Showing Gross P/L : Expenses */
//            $grosstotal = $gross_expense_total;
//            Accountlist::add_row_csv(array("Total Gross Expenses", convert_cur($gross_expense_total)));
//            if (float_ops($grosspl, 0, '>'))
//            {
//                $grosstotal = float_ops($grosstotal, $grosspl, '+');
//                Accountlist::add_row_csv(array("Gross Profit C/O", convert_cur($grosspl)));
//            }
//            Accountlist::add_row_csv(array("Total Expenses - Gross", convert_cur($grosstotal)));
//
//            /* Showing Gross P/L : Incomes  */
//            $grosstotal = $gross_income_total;
//            Accountlist::add_row_csv(array("Total Gross Incomes", convert_cur($gross_income_total)));
//
//            if (float_ops($grosspl, 0, '>'))
//            {
//
//            } else if (float_ops($grosspl, 0, '<')) {
//                $grosstotal = float_ops($grosstotal, -$grosspl, '+');
//                Accountlist::add_row_csv(array("Gross Loss C/O", convert_cur(-$grosspl)));
//            }
//            Accountlist::add_row_csv(array("Total Incomes - Gross", convert_cur($grosstotal)));
//
//            /************************* NET CALCULATIONS ***************************/
//
//            Accountlist::add_blank_csv();
//            Accountlist::add_blank_csv();
//
//            /* Net P/L : Expenses */
//            $net_expense_total = 0;
//            $this->db->from('ac_groups')->where('parent_id', 4)->where('affects_gross !=', 1);
//            $net_expense_list_q = $this->db->get();
//            foreach ($net_expense_list_q->result() as $row)
//            {
//                $net_expense = new Accountlist();
//                $net_expense->init($row->id);
//                $net_expense_total = float_ops($net_expense_total, $net_expense->total, '+');
//                $net_exp_array = $net_expense->build_array();
//                $net_expense->to_csv($net_exp_array);
//            }
//            Accountlist::add_blank_csv();
//
//            /* Net P/L : Incomes */
//            $net_income_total = 0;
//            $this->db->from('ac_groups')->where('parent_id', 3)->where('affects_gross !=', 1);
//            $net_income_list_q = $this->db->get();
//            foreach ($net_income_list_q->result() as $row)
//            {
//                $net_income = new Accountlist();
//                $net_income->init($row->id);
//                $net_income_total = float_ops($net_income_total, $net_income->total, '+');
//                $net_inc_array = $net_income->build_array();
//                $net_income->to_csv($net_inc_array);
//            }
//
//            Accountlist::add_blank_csv();
//            Accountlist::add_blank_csv();
//
//            /* Converting to positive value since Cr */
//            $net_income_total = -$net_income_total;
//
//            /* Calculating Net P/L */
//            $netpl = float_ops(float_ops($net_income_total, $net_expense_total, '-'), $grosspl, '+');
//
//            /* Showing Net P/L : Expenses */
//            $nettotal = $net_expense_total;
//            Accountlist::add_row_csv(array("Total Expenses", convert_cur($nettotal)));
//
//            if (float_ops($grosspl, 0, '>'))
//            {
//            } else if (float_ops($grosspl, 0, '<')) {
//                $nettotal = float_ops($nettotal, -$grosspl, '+');
//                Accountlist::add_row_csv(array("Gross Loss B/F", convert_cur(-$grosspl)));
//            }
//            if (float_ops($netpl, 0, '>'))
//            {
//                $nettotal = float_ops($nettotal, $netpl, '+');
//                Accountlist::add_row_csv(array("Net Profit", convert_cur($netpl)));
//            }
//            Accountlist::add_row_csv(array("Total - Net Expenses", convert_cur($nettotal)));
//
//            /* Showing Net P/L : Incomes */
//            $nettotal = $net_income_total;
//            Accountlist::add_row_csv(array("Total Incomes", convert_cur($nettotal)));
//
//            if ($grosspl > 0)
//            {
//                $nettotal = float_ops($nettotal, $grosspl, '+');
//                Accountlist::add_row_csv(array("Gross Profit B/F", convert_cur($grosspl)));
//            }
//
//            if ($netpl > 0)
//            {
//
//            } else if ($netpl < 0) {
//                $nettotal = float_ops($nettotal, -$netpl, '+');
//                Accountlist::add_row_csv(array("Net Loss", convert_cur(-$netpl)));
//            }
//            Accountlist::add_row_csv(array("Total - Net Incomes", convert_cur($nettotal)));
//
//            $balancesheet = Accountlist::get_csv();
//            $this->load->helper('csv');
//            echo array_to_csv($balancesheet, "profitandloss.csv");
//            return;
//        }
//        return;
//    }
//
//    function printpreview($statement, $id = NULL)
//    {
//        /********************** TRIAL BALANCE *************************/
//        if ($statement == "trialbalance")
//        {
//            $this->load->library('accountlist');
//            $data['report'] = "report/trialbalance";
//            $data['title'] = "Trial Balance";
//            $this->load->view('report/report_template', $data);
//            return;
//        }
//
//        if ($statement == "balancesheet")
//        {
//            $data['report'] = "report/balancesheet";
//            $data['title'] = "Balance Sheet";
//            $data['left_width'] = "";
//            $data['right_width'] = "";
//            $this->load->view('report/report_template', $data);
//            return;
//        }
//
//        if ($statement == "profitandloss")
//        {
//            $data['report'] = "report/profitandloss";
//            $data['title'] = "Profit and Loss Statement";
//            $data['left_width'] = "";
//            $data['right_width'] = "";
//            $this->load->view('report/report_template', $data);
//            return;
//        }
//
//        if ($statement == "ac_ledgerst")
//        {
//            $this->load->helper('text');
//
//            /* Pagination setup */
//            $this->load->library('pagination');
//            $data['ledger_id'] = $this->uri->segment(4);
//            /* Checking for valid ledger id */
//            if ($data['ledger_id'] == '')
//            {
//                $this->messages->add('Invalid Ledger account.', 'error');
//                redirect('report/ac_ledgerst');
//                return;
//            }
//            $this->db->from('ac_ledgers')->where('id', $data['ledger_id'])->limit(1);
//            if ($this->db->get()->num_rows() < 1)
//            {
//                $this->messages->add('Invalid Ledger account.', 'error');
//                redirect('report/ac_ledgerst');
//                return;
//            }
//            $data['report'] = "report/ac_ledgerst";
//            $data['title'] = "Ledger Statement for '" . $this->Ledger_model->get_name($data['ledger_id']) . "'";
//            $data['print_preview'] = TRUE;
//            $this->load->view('report/report_template', $data);
//            return;
//        }
//
//        if ($statement == "reconciliation")
//        {
//            $this->load->helper('text');
//
//            $data['show_all'] = FALSE;
//            $data['ledger_id'] = $this->uri->segment(4);
//
//            /* Check if path is 'all' or 'pending' */
//            if ($this->uri->segment(5) == 'all')
//            {
//                $data['reconciliation_type'] = 'all';
//                $data['show_all'] = TRUE;
//            } else if ($this->uri->segment(5) == 'pending') {
//                $data['reconciliation_type'] = 'pending';
//                $data['show_all'] = FALSE;
//            } else {
//                $this->messages->add('Invalid path.', 'error');
//                redirect('report/reconciliation/pending');
//                return;
//            }
//
//            /* Checking for valid ledger id and reconciliation status */
//            if ($data['ledger_id'] > 0)
//            {
//                $this->db->from('ac_ledgers')->where('id', $data['ledger_id'])->where('reconciliation', 1)->limit(1);
//                if ($this->db->get()->num_rows() < 1)
//                {
//                    $this->messages->add('Invalid Ledger account or Reconciliation is not enabled for the Ledger account.', 'error');
//                    redirect('report/reconciliation/' . $reconciliation_type);
//                    return;
//                }
//            } else if ($data['ledger_id'] < 0) {
//                $this->messages->add('Invalid Ledger account.', 'error');
//                redirect('report/reconciliation/' . $reconciliation_type);
//                return;
//            }
//
//            $data['report'] = "report/reconciliation";
//            $data['title'] = "Reconciliation Statement for '" . $this->Ledger_model->get_name($data['ledger_id']) . "'";
//            $data['print_preview'] = TRUE;
//            $this->load->view('report/report_template', $data);
//            return;
//        }
//        return;
//    }
//

//    function printledgerall()
//    {
//        $data['report'] = "report/profitandloss";
//        $data['title'] = "Profit and Loss Statement";
//        $data['left_width'] = "";
//        $data['right_width'] = "";
//        //echo "sss";
//        $this->load->view('report/print_full_ledger', $data);
//        return;
//    }
//Get all pdf reconciliation reports
	function reconciliationReport(){
		if($_POST){
			
			$date = $this->input->post('date');
			$account = $this->input->post('ledger_id');
			
			/*if(file_exists('bankrec/pdfs/'.$account.'_'.$date.'_reconciliation_report.pdf')){
				echo '<a href="'.base_url().'bankrec/pdfs/'.$account.'_'.$date.'_reconciliation_report.pdf" target="_blank" class="btn btn-primary">Download PDF Report</a>';
			}*/
			if(file_exists('bankrec/excel/'.$account.'_'.$date.'_reconciliation_report.xls')){
				echo '<br><br>';
				echo '<a href="'.base_url().'bankrec/excel/'.$account.'_'.$date.'_reconciliation_report.xls" target="_blank" class="btn btn-success">Download Excel Report</a>';
			}
			if(file_exists('bankrec/summary/'.$account.'_'.$date.'_reconciliation_report_summary.xls')){
				echo '<br><br>';
				echo '<a href="'.base_url().'bankrec/summary/'.$account.'_'.$date.'_reconciliation_report_summary.xls" target="_blank" class="btn btn-danger">Download Summary Report</a>';
			}
		}else{
		
		 	$this->load->view('accounts/report/reconciliation_report');
		}
	}

	//get a list of file names from pdf folder
	function getReports(){

		$financialyear = $this->common_model->get_finance_year(); //current financial year
		
		$files = array();
		
		//get names of the files in pdfs directory
		//Get a list of file paths using the glob function.
		  $fileList = glob('bankrec/excel/*.xls');
		  
		  foreach($fileList as $filename){
			  //Use the is_file function to make sure that it is not a directory.
			  if(is_file($filename)){
				  
				  //substr will trim the names and basename will remove folder name from the string.
				  array_push($files,array ("ledger" => substr(basename($filename),0,13), "date" => substr(basename($filename),14,19),"checkdate" => substr(basename($filename),14,10)));
	
	    
			  }   
		  }
		 arsort($files) ;
		 $accounts = array_unique($files, SORT_REGULAR); //remove duplicates
		 
		 
		 
		 $dates = array();
		 $dates[] = '';
		 
		 //get file dates
		 foreach ($accounts as $data){
			 if ($data['ledger'] == $this->input->post('ledger_id') && $data['checkdate'] > $financialyear->fy_start){
				$dates[$data['date']] = $data['date'];
				
			}
		 }
		 
		 $js = 'id="date" class="form-control" placeholder="Select Date" onchange="javascript:getReport(this.value);"';
		 echo form_dropdown('date', $dates, '',$js);
	}
	function getAccgroups($id){
		$data = $this->Ledger_model->getAccgroups($id);
		return $data;
	}

  //updated by nadee 2020-12-16
  function ac_ledgerst($ledger_id = "",$month = "00",$fromdate = "",$todate = "",$amount="",$project="",$rctno="",$chequeno="",$payeename="",$ledger_name = "",$ref_id = "",$project_id="", $lot="",$project_name = '')
{
  $this->load->helper('text');
//	$this->template->set('nav_links', array('report/download/ac_ledgerstall'  => 'Download General Ledger CSV','report/printledgerall'  => 'Print General Ledger CSV'));
  /* Pagination setup */
  $this->load->library('pagination');

////	$this->template->set('page_title', 'Ledger Statement');
  //if ($ledger_id != "")
  //	$this->template->set('nav_links', array('report/download/ac_ledgerst/' . $ledger_id  => 'Download CSV', 'report/printpreview/ac_ledgerst/' . $ledger_id => 'Print Preview'));
//$fromdate="";$todate="";

  if ($_POST)
  {
    $ledger_id = $this->input->post('ledger_id', TRUE);
    $month = $this->input->post('month', TRUE);
    $fromdate = $this->input->post('fromdate', TRUE);
    $todate = $this->input->post('todate', TRUE);
    $amount = $this->input->post('amount');
    $project_id = $this->input->post('project');
    $lot = $this->input->post('lot');
    $rctno = $this->input->post('rctno');
    $chequeno = $this->input->post('chequeno');
    $payeename = $this->input->post('payeename');
    $ledger_name = $this->Ledger_model->get_name($ledger_id);
    $ref_id = $this->Ledger_model->get_refid($ledger_id);
    if($project_id){
      $project  = $this->project_model->get_project_bycode($project_id);
      $project_name = $project->project_name;
    }
    //redirect('accounts/report/ac_ledgerst/'.$ledger_id.'/'.$month.'/'.$fromdate.'/'.$todate);
  }
  //echo $ledger_id.'ssss';
  $data['print_preview'] = FALSE;
  $data['ledger_id'] = $ledger_id;
  $data['month'] = $month;
  $data['fromdate'] = $fromdate;
  $data['todate'] = $todate;
  $data['amount'] = $amount;
  $data['project'] = $project_name;
  $data['lot'] = $lot;
  $data['rctno'] = $rctno;
  $data['chequeno'] = $chequeno;
  $data['payeename'] = $payeename;
  $data['ledger_name'] = $ledger_name;
  $data['ref_id'] = $ref_id;
  $data['project_id'] = $project_id;
  //	echo $fromdate;
  /* Checking for valid ledger id */
  if ($data['ledger_id'] != "")
  {
    $this->db->from('ac_ledgers')->where('id', $data['ledger_id'])->limit(1);
    if ($this->db->get()->num_rows() < 1)
    {
      $this->messages->add('Invalid Ledger account.', 'error');
      redirect('accounts/report/ac_ledgerst');
      return;
    }
  }
//echo "sss".$data['ledger_id'];
  $data['suppliers'] = $this->supplier_model->get_all_supplier_summery();
  $data['projects'] = $this->project_model->get_all_project_summery($this->session->userdata('branchid'));
  $this->load->view('accounts/report/ledgerst', $data);
  return;
}

//Ticket No-3002|Added By Uvini
function direct_payment_report()
{
	$data['emp_list'] = $this->employee_model->get_employee_list();
	$data['suplist']=$this->supplier_model->get_all_supplier_summery();
	$this->load->view('accounts/report/direct__payment_report_main',$data);
}


function direct_payment_report_data()
{
	$sup_code = $this->uri->segment(5);
	$emp_no = $this->uri->segment(4);
	$from_date = $data['from'] = $this->uri->segment(6);
	$to_date = $data['to'] = $this->uri->segment(7);
	$data['data_list'] = $this->pettycashpayments_model->get_payment_list_report($sup_code,$emp_no,$from_date,$to_date);
	$this->load->view('accounts/report/direct_payment_report',$data);
	// echo $sup_code.'<br>';
	// echo $emp_no.'<br>';
	// echo $from_date.'<br>';
	// echo $to_date.'<br>';
}

}

/* End
of file report.php */
/* Location: ./system/application/controllers/report.php */
