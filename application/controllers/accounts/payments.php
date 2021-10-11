<?php
// file use for create edit ac_projects
class Payments extends CI_Controller {

    function Payments()
    {
        parent::__construct();
        $this->load->model('paymentvoucher_model');
		  $this->load->model('cashadvance_model');
        $this->load->model('Entry_model');
        $this->load->model('Ledger_model');
        $this->load->model('Tag_model');
        $this->load->model('ac_projects_model');
        $this->load->model('cheque_model');
        $this->load->model('budgeting_model');
        $this->load->model('setting_model');
		$this->load->model('common_model');
		$this->load->model("branch_model");
		$this->load->model("generalpayment_model");
		$this->is_logged_in();



    }
    function index()
    {
        $data = NULL;

        $data['myentryid'] = 1;
        if ($this->uri->segment(3)) {
            $data['myentryid'] = $this->uri->segment(3);


        }

        $this->showpaymententry('payment');

        return;
//        $this->load->view('accounts/payments/index',$data);
//        return;
    }

    function add()
    {
        //$this->template->set('page_title', 'New Payment Entry');

        /* Check access */

        /* Form fields */
        $vouchertypes=$this->paymentvoucher_model->get_vouchertypes();
		$data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();
		$data['branchlist']=$this->branch_model->get_all_branches_summery();
        $data['vouchertypes']=$vouchertypes;
        $data['typeid']="";
		 $data['name'] = '';
        $this->messages->add(validation_errors(), 'error');
        //$this->template->load('template', 'payments/add', $data);
        $this->load->view('accounts/payments/add',$data);
        return;


    }

    function supplier_list()
    {
        $data['suplier']=$this->paymentvoucher_model->get_supplierData();
        $data['supid']="";
        $this->load->view('accounts/payments/supplier_list',$data);
    }
    function voucher_data($id)
    {

       $branchid= $this->session->userdata('branchid');
        $data['voucherdata']=$this->paymentvoucher_model->get_paymentvouchres_by_type($id,$branchid);
        $data['typeid']=$id;
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'readonly'=>'readonly',
            'maxlength' => '100',
            'size' => '20',
            'value' => '',
        );
        $this->load->view('accounts/payments/voucher_list',$data);
    }

	function searchReprint(){
		$this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->where('CHQSTATUS', 'PRINT')
		->where('ac_chqprint.CHQNO', $this->input->post('string'))->or_where('ac_entries.date', $this->input->post('string'))
		->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc')->limit(30,0);
		$entry_q = $this->db->get();
		if ($entry_q->num_rows >0) {
            $data = $entry_q->result();

			echo '<table border=0 cellpadding=5 class="table">
			  <thead>
			  <tr>
                <th>Date</th>
                <th>No</th>
                <th>Narration</th>
                <th>Cheque No</th>
                <th>Amount</th>
                <th>New Cheque No</th>
               </tr>
			  </thead>
			  <tbody>';
			$c = 0;
			foreach ($data as $row){
				$current_entry_type = entry_type_info($row->entry_type);

				$ledger=$this->Ledger_model->get_current_entry_bank_account($row->id);
				$nextid=0;
			   if($ledger)
			   {
					$isstart=$this->cheque_model->get_start_cheque_bundle($ledger);


					if($isstart)
					{
						 $bookid=$isstart->CHQBID;
						$recieptid=$this->cheque_model->is_max_cheque_id($isstart->CHQBID);
						if($recieptid->CHQNO!=0){
							$nextid=intval($recieptid->CHQNO);
							$nextid++;
						}
						else{
							$nextid=$isstart->CHQBSNO;


						}
						$nextid=str_pad($nextid, 6, "0", STR_PAD_LEFT);
					 }
					 else
					 {
						  echo "Please Assign Cheque Bundle befor Print";
					 }
			   }


				echo "<tr class=";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo ">";

				echo "<td>" . date('Y-m-d',strtotime($row->date)) . "</td>";

				echo "<td>";
				echo anchor('accounts/payments/view/' . $current_entry_type['label'] . "/" . $row->id, full_entry_number($row->entry_type, $row->number), array('title' => 'View ' . $current_entry_type['name'] . ' Entry', 'class' => 'anchor-link-a'));
				echo "</td>";
				echo "<td>";
				echo $this->Tag_model->show_entry_tag($row->tag_id);
                echo  $row->narration;
				echo "</td>";
				echo "<td>" . $row->CHQNO . "</td>";
				echo "<td>" . number_format($row->dr_total, 2, '.', ','). "</td>";
				if(check_access('change_chequenum')){
				echo '<td>
				<input  type="hidden"   maxlength="6"  value="'.$row->id.'"  name="entryid" size="1" class="form-control" id="entryid" required="required" />
				<input  type="hidden" maxlength="6"  value="'.$nextid.'"  name="maxnumber'.$row->id.'" size="1" class="form-control" id="maxnumber'.$row->id.'" required="required" />
				<input  type="hidden" maxlength="6"  value="'.$row->CHQID.'"  name="CHQID" size="1" class="form-control" id="CHQID" required="required" />

				<input  type="text"  maxlength="6"   name="chqno'.$row->id.'" size="1" class="form-control" id="chqno'.$row->id.'" required="required" />
				<button  type="button" class="btn btn-primary " onclick="change_chequenumber('.$row->id.','.$row->CHQID.','.$nextid.');">Change Number</button>

				</td>' ;
					}
				echo"<td>";
				echo "<a href='javascript:reprintprintlist_cheque(".$row->id.",".$row->CHQNO.")'><i class='fa fa-print nav_icon icon_blue'></i></a></td>";


				echo "</tr>";

			}

			echo '</tbody>
			</table>';

		}else{
			echo '<table border=0 cellpadding=5 class="simple-table">
			  <thead>
			  <tr>
				<th>Date</th>
                <th>No</th>
                <th>Narration</th>
                <th>Cheque No</th>
                <th>Amount</th>
                <th>Cheque Status</th>
                <th></th>
			  </tr>
			  </thead>
			  <tbody>';
			echo "<tr>";
			echo "<td colspan='7'>Nothing Found!</td>";
			echo '</tbody>
			</table>';
		}
	}

    function make_payment()
    {
        //->template->set('page_title', 'New Payment Entry');

        if ( ! check_access('add payment'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('payments');
            return;
        }
        if ($this->config->item('account_locked') == 1)
        {
            $this->messages->add('Account is locked.', 'error');
            redirect('payments');
            return;
        }
        $isstart=$this->cheque_model->get_start_cheque_bundle($this->input->post('banks'));
        $bookid=$isstart->CHQBID;
        if($isstart)
        {
            $recieptid=$this->cheque_model->is_max_cheque_id($isstart->CHQBID);
            if($recieptid->CHQNO!=0)
                $nextid=intval($recieptid->CHQNO)+1;
            else
                $nextid=$isstart->CHQBSNO;
            $nextid=str_pad($nextid, 6, "0", STR_PAD_LEFT);

        }
        else{

            //$this->messages->add('Cheque Boundle Not Assigned.', 'error');
            $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');
            redirect('accounts/payments/add');
            return;
        }
        $data['entrytype']=$entrytype=$this->input->post('vouchertypes',true);
       /* if($entrytype==4)
            $list=array('24','32','34','44','45','46','47','48','49','50','51','52','53','54','55');
        else if($entrytype==1)
            $list=array('70');
        else if($entrytype==6)
            $list=$this->budgeting_model->get_capital_grouplist();
        else*/
            $list='';
        $data['list']=$list;
        $suplierdata="";
        $rowmatcount=$this->input->post('rawmatcount', TRUE);
        $voucherlist=NULL;
        $counter=0;
		if($this->input->post('banks')!="")
		$bank=$this->input->post('banks');
		else
		$bank=$this->session->userdata('accshortcode')."BA17240000";

		$data['bank']=$bank;
		$paymentdes='';
        for($i=1; $i<=$rowmatcount; $i++)//get selected voucher list
        {
            if($this->input->post('isselect'.$i)=="Yes")
            {$counter++;
                $voucherlist[$counter]['voucherid']=$this->input->post('voucherid'.$i);
                $voucherlist[$counter]['refnumber']=$this->input->post('refnumber'.$i);
                $voucherlist[$counter]['payeename']=$this->input->post('payeename'.$i);
                $voucherlist[$counter]['invoiceamount']=$this->input->post('invoiceamount'.$i);

                $ref_code=$this->input->post('payeecode'.$i);
				$paymentdes=$this->input->post('paymentdes'.$i).' '.$paymentdes;
            }
        }
        if($entrytype==2)
        {
            $data['ledger_dc'][0] = "C";
            $data['ledger_id'][0] = $bank;
            $data['dr_amount'][0] = "";
            $data['cr_amount'][0] = $this->input->post('amount',true);
            $data['ledger_dc'][1] = "D";
            $data['ledger_id'][1] = 'PE50010400';
            $data['dr_amount'][1] = $this->input->post('amount',true);
            $data['cr_amount'][1] = "";
        }
        else if($entrytype==6 || $entrytype==3 || $entrytype==9 || $entrytype==10 || $entrytype=='ALL'  || $entrytype==11 ||   $entrytype==14)
        {
          //  $prjdata=$this->ac_projects_model->get_project_by_refid($ref_code);
            //echo $prjdata->gl_code;
            $data['ledger_dc'][0] = "C";
            $data['ledger_id'][0] = $bank;
            $data['dr_amount'][0] = "";
            $data['cr_amount'][0] = $this->input->post('amount',true);
			  for($i=1; $i<=$rowmatcount; $i++)//get selected voucher list
      		  { // echo "sss".$this->input->post('ledger_id'.$i);
         			   if($this->input->post('isselect'.$i)=="Yes")
           				 {

           				 $data['ledger_dc'][$i] = "D";
           				 $data['ledger_id'][$i] = $this->input->post('ledger_id'.$i);
           				 $data['dr_amount'][$i] =$this->input->post('invoiceamount'.$i);
           				 $data['cr_amount'][$i] = "";
				 }
       		 }
        }
		else if($entrytype==7)
        {
          //  $prjdata=$this->ac_projects_model->get_project_by_refid($ref_code);
            //echo $prjdata->gl_code;
            $data['ledger_dc'][0] = "C";
            $data['ledger_id'][0] = $bank;
            $data['dr_amount'][0] = "";
            $data['cr_amount'][0] = $this->input->post('amount',true);
			  for($i=1; $i<=$rowmatcount; $i++)//get selected voucher list
      		  { //echo "sss";
         			   if($this->input->post('isselect'.$i)=="Yes")
           				 {

           				 $data['ledger_dc'][$i] = "D";
           				 $data['ledger_id'][$i] = $this->input->post('ledger_id'.$i);
           				 $data['dr_amount'][$i] =$this->input->post('invoiceamount'.$i);
           				 $data['cr_amount'][$i] = "";
				 }
       		 }
        }
        else
        {
            for ($count = 0; $count <= 1; $count++)
            {
                if ($count == 0 )
                {
                    $data['ledger_dc'][$count] = "C";
                    $data['ledger_id'][$count] = $bank;
                    $data['dr_amount'][$count] = "";
                    $data['cr_amount'][$count] = $this->input->post('amount',true);;
                }
                else if ($count > 0)
                {
                    $data['ledger_dc'][$count] = "D";
                    $data['dr_amount'][$count] = "";
                    $data['cr_amount'][$count] = "";
                }
            }
        }

        $entry_type_id = entry_type_name_to_id('payment');
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/payments/add');
            return;
        }
        else
        {
            $current_entry_type = entry_type_info($entry_type_id);
        }
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'class' => 'form-control',
            'maxlength' => '11',
            'readonly'=>'readonly',
            'size' => '11',
            'value' =>$nextid,
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'class' => 'form-control',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => date_today_php(),
        );
        $data['entry_narration'] = array(
            'name' => 'entry_narration',
            'id' => 'entry_narration',
            'cols' => '50',
            'rows' => '4',
            'value' => $paymentdes,
        );
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'class' => 'form-control',
            'maxlength' => '11',
            'size' => '11',
            'value' => $this->input->post('amount',true),
        );
        $data['current_entry_type'] = $current_entry_type;
        $data['count']=$counter;
        $data['payment_mode']='CHQ';
        $data['voucherlist']=$voucherlist;
        $data['suplierdata']=$suplierdata;
        $data['addtype']=$entrytype;
        //$this->template->load('template', 'payments/make_payment', $data);
        $this->load->view('accounts/payments/make_payment',$data);
        return;
    }

    function newentry($entry_type)
    {
        if ( ! check_access('add payment'))
        {
            $this->messages->add('Permission denied.', 'error');
            redirect('accounts/payments/add');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            $this->messages->add('Account is locked.', 'error');
            redirect('accounts/payments/add');
            return;
        }
		$ledger=$this->input->post('ledger_id[0]');
		 $ledger = $this->input->post('ledger_id', TRUE);
		$bank_ledger=$ledger[0];
		 $isstart=$this->cheque_model->get_start_cheque_bundle($bank_ledger);
        $bookid=$isstart->CHQBID;

        if($isstart)
        {
            $recieptid=$this->cheque_model->is_max_cheque_id($isstart->CHQBID);
            if($recieptid->CHQNO!=0){
                $nextid=intval($recieptid->CHQNO)+1;
            }
            else{
                $nextid=$isstart->CHQBSNO;
            $nextid=str_pad($nextid, 6, "0", STR_PAD_LEFT);

        }
        }
        else{
            //$this->messages->add('Cheque Boundle Not Assigned.', 'error');
            $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');
            redirect('accounts/payments/add');
            return;
        }
        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        $nextid=$this->Entry_model->next_entry_number($entry_type_id);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/payments/add');
            return;
        }
        else
        {
            $current_entry_type = entry_type_info($entry_type_id);
        }
        //$this->template->set('page_title', 'New ' . $current_entry_type['name'] . ' Entry');

        $data['payment_mode']="CHQ";

        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entrytype']=$entrytype=$this->input->post('vouchertypes',true);
        $data['addtype']=$entrytype;
        $suplierdata="";
        if($entrytype==4)
            $list=array('24','32','34','44','45','46','47','48','49','50','51','52','53','54','55');
        else if($entrytype==1)
            $list=array('70');
        else if($entrytype==6)
            $list=$this->budgeting_model->get_capital_grouplist();
        else
            $list='';
        $data['list']=$list;

        $rowmatcount=$this->input->post('rawmatcount', TRUE);
        $voucherlist=NULL;
        $count=0;

        for($i=1; $i<=$rowmatcount; $i++)//get selected voucher list
        {

            $voucherlist[$i]['voucherid']=$this->input->post('voucherid'.$i);
            $voucherlist[$i]['refnumber']=$this->input->post('refnumber'.$i);
            $voucherlist[$i]['payeename']=$this->input->post('payeename'.$i);
            $voucherlist[$i]['invoiceamount']=$this->input->post('invoiceamount'.$i);


        }
        $data['count']=$rowmatcount;
        $data['payment_mode']='CHQ';
        $data['voucherlist']=$voucherlist;
        $data['suplierdata']=$suplierdata;
        $data['entry_number'] = array(
            'name' => 'entry_number',
            'id' => 'entry_number',
            'maxlength' => '11',
            'readonly'=>'readonly',
            'size' => '11',
            'value' =>$nextid,
        );
        $data['entry_date'] = array(
            'name' => 'entry_date',
            'id' => 'entry_date',
            'readonly'=>'readonly',
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
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'readonly'=>'readonly',
            'maxlength' => '11',
            'size' => '11',
            'value' => $this->input->post('amount',true),
        );
        /* Form validations */
//        $this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required|is_date|is_date_within_range');
//        $this->form_validation->set_rules('payment_mode', 'Entry Date', 'trim|required');
//        $this->form_validation->set_rules('chequedrawnto', 'Cheque Drawn name', 'trim|required');
//        $this->form_validation->set_rules('entry_narration', 'trim|required');
        //$this->form_validation->set_rules('amount', 'Cheque Amount', 'trim|currency');

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
            $data['amount']['value'] = $amount=$this->input->post('amount', TRUE);
            $data['payment_mode']=$payment_mode=$this->input->post('payment_mode', TRUE);
            $data['ledger_dc'] = $this->input->post('ledger_dc', TRUE);
            $data['ledger_id'] = $this->input->post('ledger_id', TRUE);
            $data['dr_amount'] = $this->input->post('dr_amount', TRUE);
            $data['cr_amount'] = $this->input->post('cr_amount', TRUE);
			 $data['pay_mode'] =$pay_mode= $this->input->post('pay_mode', TRUE);
			 $data['authorized_only'] =$authorized_only= $this->input->post('authorized_only', TRUE);
            $chequedrownto=$this->input->post('chequedrawnto', TRUE);

        }

        //if ($this->form_validation->run() == FALSE)
        //{

            //$this->session->set_flashdata('error', 'Invalid Supplier id.');
            //$this->load->view('accounts/payments/make_payment',$data);
            //return;
        //}
        //else
        //{
            /* Checking for Valid ac_ledgers account and Debit and Credit Total */
            $data_all_ledger_id = $this->input->post('ledger_id', TRUE);
            $data_all_ledger_dc = $this->input->post('ledger_dc', TRUE);
            $data_all_dr_amount = $this->input->post('dr_amount', TRUE);
            $data_all_cr_amount = $this->input->post('cr_amount', TRUE);
            $dr_total = 0;
            $cr_total = 0;
            $bank_cash_present = FALSE; /* Whether atleast one Ledger account is Bank or Cash account */
            $non_bank_cash_present = FALSE;  /* Whether atleast one Ledger account is NOT a Bank or Cash account */


            foreach ($data_all_ledger_dc as $id => $ledger_data)
            {
                if ($data_all_ledger_id[$id] =="0") // modaification done by udani . Reasone : allow string ladger ids
                    continue;

                /* Check for valid ledger id */
                $this->db->from('ac_ledgers')->where('id', $data_all_ledger_id[$id]);
                $valid_ledger_q = $this->db->get();

                //echo "ss";
                if ($valid_ledger_q->num_rows() < 1)
                {
                    //$this->messages->add('Invalid Ledger account.', 'error');
                    $this->session->set_flashdata('error', 'Invalid Ledger account.');
                    //$this->template->load('template', 'payments/make_payment', $data);
                    $this->load->view('accounts/payments/make_payment',$data);
                    return;
                } else {
                    /* Check for valid ledger type */
                    $valid_ledger = $valid_ledger_q->row();
                    if ($data_all_ledger_dc[$id] == 'C' && $valid_ledger->type == 1)
                    {
                        $bank_cash_present = TRUE;
                    }
                    if ($valid_ledger->type != 1)
                        $non_bank_cash_present = TRUE;

                }

                if ($data_all_ledger_dc[$id] == "D")
                {
                    $dr_total = float_ops($data_all_dr_amount[$id], $dr_total, '+');

                } else {

                    $cr_total = float_ops($data_all_cr_amount[$id], $cr_total, '+');
                }
            }
            if (float_ops($dr_total, $cr_total, '!='))
            {
                //$this->messages->add('Debit and Credit Total does not match!', 'error');
                $this->session->set_flashdata('error', 'Debit and Credit Total does not match!');
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/make_payment',$data);
                return;
            }else if (float_ops($dr_total, $amount, '!='))
            {
                //$this->messages->add('Debit and Credit Total and voucher total does not match!', 'error');
                $this->session->set_flashdata('error', 'Debit and Credit Total and voucher total does not match!');
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/make_payment',$data);
                return;
            }

            else if (float_ops($dr_total, 0, '==') && float_ops($cr_total, 0, '==')) {
                //echo $dr_total;
                //$this->messages->add('Cannot save empty Entry.', 'error');
                $this->session->set_flashdata('error', 'Cannot save empty Entry.');
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/make_payment',$data);
                return;
            }
            /* Check if atleast one Bank or Cash Ledger account is present */
            /*if ( ! $bank_cash_present)
            {
                //$this->messages->add('Need to Credit atleast one Bank or Cash account.', 'error');
                $this->session->set_flashdata('error', 'Need to Credit atleast one Bank or Cash account.');
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/make_payment',$data);
                return;
            }
            if ( ! $non_bank_cash_present)
            {
                //$this->messages->add('Need to Debit or Credit atleast one NON - Bank or Cash account.', 'error');
                $this->session->set_flashdata('error', 'Need to Debit or Credit atleast one NON - Bank or Cash account.');
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/make_payment',$data);
                return;
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
            //$data_date = date_php_to_mysql($data_date); // Converting date to MySQL
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
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/add',$data);
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
			$cr_ledger=0;
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
					$cr_ledger=$data_ledger_id;
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
                    //$this->template->load('template', 'payments/make_payment', $data);
                    $this->load->view('accounts/payments/add',$data);
                    return;
                }
                //update Project Table



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
                //$this->template->load('template', 'payments/make_payment', $data);
                $this->load->view('accounts/payments/add',$data);
                return;
            }
            /*updating payment voucher table*/
            for($i=1; $i<=$rowmatcount; $i++)//get selected voucher list
            {

                $voucherlist[$i]['voucherid']=$this->input->post('voucherid'.$i);
                $voucherlist[$i]['refnumber']=$this->input->post('refnumber'.$i);
                $voucherlist[$i]['payeename']=$this->input->post('payeename'.$i);
                $voucherlist[$i]['invoiceamount']=$this->input->post('invoiceamount'.$i);

                $voucherdata=$this->paymentvoucher_model->get_payment_voucher_byid($this->input->post('voucherid'.$i));

                if($voucherdata->status=="PAID")
                {
                    $this->db->trans_rollback();
                    //$this->messages->add($this->input->post('voucherid'.$i).' This Voucher Already taken by another entry', 'error');
                    $this->session->set_flashdata('error', $this->input->post('voucherid'.$i).'Error updating Entry total.');
                    redirect('accounts/payments/add');
                    return;
                }
                $updatevoucher=array("entryid"=>$entry_id,"paymentdate"=>date("Y-m-d"),"paymenttype"=>$payment_mode,"status"=>"PAID");

                //********************//updated - 2014-08-11/ Sub project paymetn add modification done- Fixed invoice statuse change moduel

                //if($entrytype==6 )
                //{
                $suparray=array('status'=>'PAID');
//                if( ! $this->db->where('document_refno', $this->input->post('voucherid'.$i))->update('project_subpayments',$suparray ))
//                {
//                    $this->db->trans_rollback();
//                    $this->session->set_flashdata('error', 'Error updating Project Subpayment Status.');
//                    $this->load->view('accounts/payments/add',$data);
//
//                    return;
//                }
                //}
                //**************************************************************************************************************************
                if( ! $this->db->where('voucherid', $this->input->post('voucherid'.$i))->update('ac_payvoucherdata',$updatevoucher ))
                {// echo "***************",$this->input->post('voucherid'.$i);
                    $this->db->trans_rollback();
                    //$this->messages->add('Error updating Voucher Status.', 'error');
                    $this->session->set_flashdata('error', 'Error updating Voucher Status.');
                    //$this->template->load('template', 'payments/make_payment', $data);
                    $this->load->view('accounts/payments/add',$data);
                    return;
                }
				//$this->update_cashadvance_cashbook($this->input->post('voucherid'.$i));
				$this->cashadvance_model->update_cashadvance_onpayment($this->input->post('voucherid'.$i));


            }
            /* add new cheque*/
            if($payment_mode=="CHQ"){
             //   echo $bookid."ssss".$chequedrownto."---".$entry_id;
                $datacheque=array('CHQBID'=>$bookid,'CHQNAME'=>$chequedrownto,"PAYREFNO"=>$entry_id,"CHQSTATUS"=>"QUEUE","CRDATE"=>date("Y-m-d H:i:s"),'ac_pay' =>$pay_mode,'authorized_only'=>$authorized_only);
                // $this->db->insert('ac_chqprint',$datacheque );
                //echo  $this->db->last_query();
                if(! $this->db->insert('ac_chqprint',$datacheque ))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('error Inserting Cheque.', 'error');
                    $this->session->set_flashdata('error', 'Error Inserting Cheque.');
                    //$this->template->load('template', 'payments/make_payment', $data);
                    $this->load->view('accounts/payments/add',$data);
                    return;
                }


            }elseif($payment_mode=="ONLINE" || $payment_mode=="BDRAFTS" || $payment_mode=="SLIP"){
              /*ticket 1050 update by nadee*/
              $transaction_no=$this->input->post('transaction_num');
              $datacheque=array('CHQBID'=>0,'CHQNAME'=>$chequedrownto,"PAYREFNO"=>$entry_id,"CHQSTATUS"=>"PRINT","CRDATE"=>date("Y-m-d H:i:s"),"CHQNO"=>$transaction_no,"TRANS_TYPE"=>$payment_mode,'ac_pay' =>$pay_mode,'authorized_only'=>$authorized_only );

              if(! $this->db->insert('ac_chqprint',$datacheque ))
              {
                  $this->db->trans_rollback();
                  //$this->messages->add('error Inserting Cheque.', 'error');
                  $this->session->set_flashdata('error', 'Error Inserting Online Payment.');
                  //$this->template->load('template', 'payments/make_payment', $data);
                  $this->load->view('accounts/payments/add',$data);
                  return;
              }
            }
            //	$total_rows = $this->db->from('ac_entry_status')->where('entry_id', $entry_id)->get()->num_rows();
            //if($total_rows==0)
            //{
            $entrystat=array (
                'entry_id'=>$entry_id,
                'status'=>"PENDING",
            );
            $this->db->insert('ac_entry_status', $entrystat);
            //$rctdata=$this->reciept_model->get_ac_recieptdata($entry_id);



            /* Success */
            $this->db->trans_complete();

         /*   $this->session->set_userdata('entry_added_show_action', TRUE);
            $this->session->set_userdata('entry_added_id', $entry_id);
            $this->session->set_userdata('entry_added_type_id', $entry_type_id);
            $this->session->set_userdata('entry_added_type_label', $current_entry_type['label']);
            $this->session->set_userdata('entry_added_type_name', $current_entry_type['name']);
            $this->session->set_userdata('entry_added_number', $nextid);

             $this->logger->write_message("success", "Added " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
          */
    $this->session->set_flashdata('msg', 'Added Successful!');
            redirect('accounts/payments/');
            //$this->template->load('template', 'payments/make_payment', $data);
            return;
        //}
        //return;
    }

    function supplier_voucher_data($id)
    {

        $data['voucherdata']=$this->paymentvoucher_model->get_paymentvouchres_by_supid($this->uri->segment(3),$this->uri->segment(4));
        $data['typeid']=$id;
        $data['amount'] = array(
            'name' => 'amount',
            'id' => 'amount',
            'readonly'=>'readonly',
            'maxlength' => '100',
            'size' => '20',
            'value' => '',
        );
        $this->load->view('accounts/payments/voucher_list',$data);
    }

    function showpaymententry($entry_type)
    {
        $data['tag_id'] = 0;
        $entry_type_id = 0;
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            $this->session->set_flashdata('error', 'Invalid Entry type specified. Showing all ac_entries.');

            redirect('accounts/entrymaster/show/all');
            return;
        } else
        {
            $current_entry_type = entry_type_info($entry_type_id);
            //$this->template->set('page_title', 'Payments');
            //$this->template->set('nav_links', array('payments/add' => 'New Payment entry','payments/printQueue/' => 'Cheque Printer Queue'));
        }

        $entry_q = NULL;

        /* Pagination setup */
        $this->load->library('pagination');


        $page_count = (int)$this->uri->segment(5);

       //$page_count = $this->input->xss_clean($page_count);
        if ( ! $page_count)
            $page_count = "0";

        /* Pagination configuration */

        $config['base_url'] = site_url('accounts/payments/showpaymententry/'. $current_entry_type['label']);
        $config['uri_segment'] = 5;

        $pagination_counter = 30;//$this->config->item('row_count');
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

        if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->where('status','PENDING')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->get()->num_rows();
        }

        /* Pagination initializing */
        $this->pagination->initialize($config);
        $data['entry_added_id_temp']=NULL;
        /* Show entry add actions *///dks dskfkkkjdkuleswomin lks kkdhnbnn



        $data['entry_data'] = $entry_q;
        /*Ticket No:2771 Added By Madushan 2021.05.05*/
        $data['prj_list'] = $this->common_model->get_all_projects();
        $data['tag_id'] = 0;
        $entry_type_id = 0;


        $entry_type_id = entry_type_name_to_id($entry_type);
        $entry_q1 = NULL;

        /* Pagination setup */

//        if ($entry_type == "tag")
//            $page_count = (int)$this->uri->segment(5);
//        else
//            $page_count = (int)$this->uri->segment(4);
//
//        $page_count = $this->input->xss_clean($page_count);
//        if ( ! $page_count)

        $isstart=$this->cheque_model->get_start_cheque_bundle($this->session->userdata('branchid'));

        if($isstart)
        {
			 $bookid=$isstart->CHQBID;
            $this->pagination->initialize($config);
            $data['entry_pdata'] = $entry_q1;

        }
        else
        {

            $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');

        }
 		$ac_projects = $this->paymentvoucher_model->get_pending_payment_vouchers($this->session->userdata('branchid'));
        if (!$ac_projects)
        {
           // $this->messages->add('No Pending Payment Vouchers', 'message');
        }
        $data['ac_projects'] = $ac_projects;
        //$this->template->load('template', 'payments/index', $data);
        $this->load->view('accounts/payments/index',$data);
        return;

    }
function showpaymententry_approve()
    {
      $entry_type='payment';
	    $data['tag_id'] = 0;
        $entry_type_id = 0;
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            $this->session->set_flashdata('error', 'Invalid Entry type specified. Showing all ac_entries.');

            redirect('accounts/entrymaster/show/all');
            return;
        } else
        {
            $current_entry_type = entry_type_info($entry_type_id);
            //$this->template->set('page_title', 'Payments');
            //$this->template->set('nav_links', array('payments/add' => 'New Payment entry','payments/printQueue/' => 'Cheque Printer Queue'));
        }

        $entry_q = NULL;

        /* Pagination setup */
        $this->load->library('pagination');


        $page_count = (int)$this->uri->segment(5);

       //$page_count = $this->input->xss_clean($page_count);
        if ( ! $page_count)
            $page_count = "0";

        /* Pagination configuration */

        $config['base_url'] = site_url('accounts/payments/showpaymententry_approve/'. $current_entry_type['label']);
        $config['uri_segment'] = 5;

        $pagination_counter = 30;//$this->config->item('row_count');
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

        if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->where('status !=','PENDING')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc')->limit($pagination_counter, $page_count);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
            $config['total_rows'] = $this->db->from('ac_entries')->where('entry_type', $entry_type_id)->get()->num_rows();
        }

        /* Pagination initializing */
        $this->pagination->initialize($config);
        $data['entry_added_id_temp']=NULL;
        /* Show entry add actions *///dks dskfkkkjdkuleswomin lks kkdhnbnn



        $data['entry_data'] = $entry_q;

        $data['tag_id'] = 0;
        $entry_type_id = 0;


        $entry_type_id = entry_type_name_to_id($entry_type);
        $entry_q1 = NULL;

        /* Pagination setup */

//        if ($entry_type == "tag")
//            $page_count = (int)$this->uri->segment(5);
//        else
//            $page_count = (int)$this->uri->segment(4);
//
//        $page_count = $this->input->xss_clean($page_count);
//        if ( ! $page_count)

        $isstart=$this->cheque_model->get_start_cheque_bundle($this->session->userdata('branchid'));

        if($isstart)
        {
			 $bookid=$isstart->CHQBID;
            $this->pagination->initialize($config);
            $data['entry_pdata'] = $entry_q1;

        }
        else
        {

            $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');

        }
 		$ac_projects = $this->paymentvoucher_model->get_approved_payment_vouchers($this->session->userdata('branchid'));
		//echo $this->db->last_query();
        if (!$ac_projects)
        {
           // $this->messages->add('No Pending Payment Vouchers', 'message');
        }
        $data['ac_projects'] = $ac_projects;
        /*Ticket No:2771 Added By Madushan 2021.05.05*/
        $data['prj_list'] = $this->common_model->get_all_projects();
		//print_r($ac_projects);
        //$this->template->load('template', 'payments/index', $data);
        $this->load->view('accounts/payments/payment_app',$data);
        return;

    }

    function edit($entry_id)
{
    if ( ! check_access('add payment'))
    {
        //$this->messages->add('Permission denied.', 'error');
        $this->session->set_flashdata('error', 'Permission denied.');
        redirect('accounts/payments');
        return;
    }
    $entry_type='payment';
    /* Check for account lock */
    if ($this->config->item('account_locked') == 1)
    {
        //$this->messages->add('Account is locked.', 'error');
        $this->session->set_flashdata('error', 'Account is locked.');
        redirect('accounts/payments');
        return;
    }
    $data['entry_id']=$entry_id;
    /* Entry Type */
    $entry_type_id = entry_type_name_to_id($entry_type);
    if ( ! $entry_type_id)
    {
        //$this->messages->add('Invalid Entry type.', 'error');
        $this->session->set_flashdata('error', 'Invalid Entry type.');
        redirect('accounts/payments');
        return;
    }
    else
    {
        $current_entry_type = entry_type_info($entry_type_id);
    }
    if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
    {
        //echo $entry_type_id.'/'.$entry_id;
        //$this->messages->add('Invalid Entry.', 'error');
        $this->session->set_flashdata('error', 'Invalid Entry.');
        redirect('accounts/payments');
        return;
    }
    $cheque_entry = $this->paymentvoucher_model->get_chequedata_by_entryid($entry_id);

    /*	$this->messages->add('Invalid Entry.', 'error');
        redirect('entrymaster/show/' . $current_entry_type['label']);
        return;*/

    //$this->template->set('page_title', 'New ' . $current_entry_type['name'] . ' Entry');

    $data['payment_mode']="CHQ";

    $data['entry_type_id'] = $entry_type_id;
    $data['current_entry_type'] = $current_entry_type;
    $datalist=$this->paymentvoucher_model->get_paymentvouchres_by_entryid($entry_id);
    $chequename="";
    $count=0;
    foreach($datalist as $row)//get selected voucher list
    {$count++;

        $voucherlist[$count]['voucherid']=$row->voucherid;
        $voucherlist[$count]['refnumber']=$row->refnumber;
        $voucherlist[$count]['payeename']=$row->payeename;
        $voucherlist[$count]['invoiceamount']=$row->amount;
        $data['payment_mode']=$row->paymenttype;
        $chequename=$row->payeename;

    }
	$authorized_only='';
    if($cheque_entry){ $chequename=$cheque_entry->CHQNAME;
	$authorized_only=$cheque_entry->authorized_only;
	$pay_mode=$cheque_entry->ac_pay;
	}

	$data['authorized_only']=$authorized_only;
	$data['pay_mode']=$pay_mode;


    $nextid=$cur_entry->number;
    $data['count']=$count;

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
        'readonly'=>'readonly',
        'maxlength' => '11',
        'size' => '11',
        'value' => $cur_entry->dr_total,
    );

    $data['chequename'] = array(
        'name' => 'chequename',
        'id' => 'chequename',
        'maxlength' => '100',
        'size' => '50',
        'value' => $chequename,
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
        $this->db->from('ac_entry_items')->where('entry_id', $entry_id);
        $cur_ac_ledgers_q = $this->db->get();
        if ($cur_ac_ledgers_q->num_rows <= 0)
        {
            $this->messages->add('No Ledger accounts found!', 'error');
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
			 $data['pay_mode'] =$pay_mode= $this->input->post('pay_mode', TRUE);
			 $data['authorized_only'] =$authorized_only= $this->input->post('authorized_only', TRUE);
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
                $this->load->view('accounts/payments/edit', $data);
                return;
            } else {
                /* Check for valid ledger type */
                $valid_ledger = $valid_ledger_q->row();
                if ($data_all_ledger_dc[$id] == 'C' && $valid_ledger->type == 1) {
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
        //$this->template->load('template', 'payments/edit', $data);
        $this->load->view('accounts/payments/edit',$data);
        return;
        //}else if (float_ops($dr_total, $amount, '!='))
    }else if (float_ops($dr_total, '!='))
    {
        //$this->messages->add('Debit and Credit Total and voucher total does not match!', 'error');
        $this->session->set_flashdata('error', 'Debit and Credit Total and voucher total does not match!');
        //$this->template->load('template', 'payments/edit', $data);
        $this->load->view('accounts/payments/edit',$data);
        return;
    }



    else if (float_ops($dr_total, 0, '==') && float_ops($cr_total, 0, '==')) {

        //echo $dr_total;
        //$this->messages->add('Cannot save empty Entry.', 'error');
        $this->session->set_flashdata('error', 'Cannot save empty Entry.');
        //$this->template->load('template', 'payments/edit', $data);
        $this->load->view('accounts/payments/edit',$data);
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
    $data_date = $data_date; // Converting date to MySQL
    $data_has_reconciliation = $this->input->post('has_reconciliation', TRUE);

    $this->db->trans_start();
    $update_data = array(

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
        //$this->template->load('template', 'payments/edit', $data);
        $this->load->view('accounts/payments/edit',$data);
        return;
    }
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

        if(substr($row->ledger_id,0,4)=="PE61"){
            $fund_releasenew=$row->amount;
            $quaey=$this->ac_projects_model->get_project_byledgerid($row->ledger_id);
            if($quaey)
            {
                $newwal=(float)$quaey->fund_district-(float)$fund_releasenew;
                $udate=array('fund_district'=>$newwal);
                if ( ! $this->db->where('gl_code', $row->ledger_id)->update('ac_projects', $udate))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error updating ac_projects table.', 'error');
                    $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                }
            }
        }
    }

    /* TODO : Deleting all old ledger data, Bad solution */
    if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
    {
        $this->db->trans_rollback();
        //$this->messages->add('Error deleting previous Ledger accounts from Entry.', 'error');
        $this->session->set_flashdata('error', 'Error deleting previous Ledger accounts from Entry.');
        $this->logger->write_message("error", "Error deleting previous entry items for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
        // $this->template->load('template', 'payments/edit', $data);
        $this->load->view('accounts/payments/edit',$data);
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
      //  echo $data_ledger_id ;
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
            //$this->template->load('template', 'payments/edit', $data);
            $this->load->view('accounts/payments/edit',$data);

            return;
        }
        //update Project Table
        if(substr($data_ledger_id,0,4)=="PE61"){
            $fund_releasenew=$data_amount;
            $quaey=$this->ac_projects_model->get_project_byledgerid($data_ledger_id);
            if($quaey)
            {
                $newwal=(float)$quaey->fund_district+(float)$fund_releasenew;
                $udate=array('fund_district'=>$newwal);
                if ( ! $this->db->where('gl_code', $data_ledger_id)->update('ac_projects', $udate))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error updating ac_projects table.', 'error');
                    $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                }
            }
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
        //$this->template->load('template', 'payments/edit', $data);
        $this->load->view('accounts/payments/edit',$data);
        return;
    }
    if($payment_mode=="CHQ"){
        $datacheque=array('CHQNAME'=>$this->input->post('chequename', TRUE),"CRDATE"=>date("Y-m-d"),'ac_pay' =>$pay_mode,'authorized_only'=>$authorized_only );
        if(! $this->db->where('PAYREFNO',$entry_id)->update('ac_chqprint',$datacheque))
        {
            $this->db->trans_rollback();
            //$this->messages->add('error Updating Cheque.', 'error');
            $this->session->set_flashdata('error', 'Error Updating Cheque.');
            //$this->template->load('template', 'payments/edit', $data);
            $this->load->view('accounts/payments/edit',$data);
            return;
        }

    }elseif($payment_mode=="ONLINE" || $payment_mode=="BDRAFTS" || $payment_mode=="SLIP"){
      /*ticket 1050 update by nadee*/
      $transaction_no=$this->input->post('transaction_num');
      $datacheque=array('CHQBID'=>0,'CHQNAME'=>$chequedrownto,"PAYREFNO"=>$entry_id,"CHQSTATUS"=>"PRINT","CRDATE"=>date("Y-m-d H:i:s"),"CHQNO"=>$transaction_no,"TRANS_TYPE"=>$payment_mode,'ac_pay' =>$pay_mode,'authorized_only'=>$authorized_only );

      if(! $this->db->insert('ac_chqprint',$datacheque ))
      {
          $this->db->trans_rollback();
          //$this->messages->add('error Inserting Cheque.', 'error');
          $this->session->set_flashdata('error', 'Error Inserting Online Payment.');
          //$this->template->load('template', 'payments/make_payment', $data);
          $this->load->view('accounts/payments/add',$data);
          return;
      }
    }


    /* Success */
    $this->db->trans_complete();

    $this->session->set_userdata('entry_updated_show_action', TRUE);
    $this->session->set_userdata('entry_updated_id', $entry_id);
    $this->session->set_userdata('entry_updated_type_id', $entry_type_id);
    $this->session->set_userdata('entry_updated_type_label', $current_entry_type['label']);
    $this->session->set_userdata('entry_updated_type_name', $current_entry_type['name']);
    $this->session->set_userdata('entry_updated_number', $nextid.$this->input->post('chequedrownto', TRUE));

    /* Showing success message in show() method since message is too long for storing it in session */
    $this->logger->write_message("success", "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
    ?><script></script><?
    $this->session->set_flashdata('msg', "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
    redirect('accounts/payments');
    //$this->template->load('template', 'payments/make_payment', $data);
    return;
    //}
    ///return;
}

    function delete($entry_id)
    {
//        var_dump($entry_id);
//        die();
        $entry_type='payment';
        if ( ! check_access('delete payment'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/payments');
            return;
        }
        $entry_type='payment';
        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            ///$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/payments');
            return;
        }
        $data['entry_id']=$entry_id;
        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/payments');
            return;
        }
        else
        {
            $current_entry_type = entry_type_info($entry_type_id);
        }
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //echo $entry_type_id.'/'.$entry_id;
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            redirect('accounts/payments');
            return;
        }
        if ( !$this->db->delete('ac_chqprint', array('PAYREFNO' => $entry_id)))
        {
            //$this->messages->add('Error Deleting Cheque Entry.', 'error');
            $this->session->set_flashdata('error', 'Error Deleting Cheque Entry.');
            redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
            return;
        }

        $data['payment_mode']="CHQ";

        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $datalist=$this->paymentvoucher_model->get_paymentvouchres_by_entryid($entry_id);
        $count=0;


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

            if(substr($row->ledger_id,0,4)=="PE61"){
                $fund_releasenew=$row->amount;
                $quaey=$this->ac_projects_model->get_project_byledgerid($row->ledger_id);
                if($quaey)
                {
                    $newwal=(float)$quaey->fund_district-(float)$fund_releasenew;
                    $udate=array('fund_district'=>$newwal);
                    if ( ! $this->db->where('gl_code', $row->ledger_id)->update('ac_projects', $udate))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating ac_projects table.', 'error');
                        $this->session->set_flashdata('error', 'Error updating ac_projects table.');
                    }
                }
            }



        }

		//*******************************************************************************************************************

			
       //********************//updated - 2019-09-06/ udani /Manualy created Vouchers Delete on paymante deleted
        $dataarr=$this->paymentvoucher_model->get_paymentvouchres_by_entryid($entry_id);
        if($dataarr){
            foreach($dataarr as $rowdata)
            {
                if($rowdata->vouchertype==1 || $rowdata->vouchertype==2 || $rowdata->vouchertype==5 || $rowdata->vouchertype==4)
                {

                 	 $suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
          			$this->db->where('voucherid',$rowdata->voucherid)->update('ac_payvoucherdata',$suparray );
                }//updated by udani ticket number 1038
				else if($rowdata->vouchertype==7)
				{
					$suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
          			$this->db->where('voucherid',$rowdata->voucherid)->update('ac_payvoucherdata',$suparray );
					if ( !$this->db->where('voucher_id',$rowdata->voucherid)->delete('ac_outside_loanspayment'))
					{
						//$this->messages->add('Error Deleting Cheque Entry.', 'error');
						$this->session->set_flashdata('error', 'Error Deleting Cheque Entry.');
						redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
						return;
					}

				}
				else
				{
					 $suparray=array('status'=>'CONFIRMED','deleted_by'=>$this->session->userdata('userid'));
                    if( ! $this->db->where('voucherid',$rowdata->voucherid)->update('ac_payvoucherdata',$suparray ))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating Invoice Status.', 'error');
                        $this->session->set_flashdata('error', 'Error updating Invoice Status.');
                    }

				}

            }
        }
//*******************************************************************************************************************
			$this->cashadvance_model->delete_cashadvance_onpayment($entry_id);
			$this->generalpayment_model->delete_resale_refund($entry_id);


        if ( ! $this->db->delete('ac_entry_items', array('entry_id' => $entry_id)))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error deleting previous Ledger accounts from Entry.', 'error');
            $this->session->set_flashdata('error', 'Error deleting previous Ledger accounts from Entry.');
            $this->logger->write_message("error", "Error deleting previous entry items for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
            //$this->template->load('template', 'payments/edit', $data);
            $this->load->view('accounts/payments/edit',$data);
            return;
        }
        if ( !$this->db->delete('ac_entries', array('id' => $entry_id)))
        {
            //$this->messages->add('Error Deleting Entry.', 'error');
            $this->session->set_flashdata('error', 'Error Deleting Entry.');
            redirect('accounts/payments');
            return;
        }

        $this->db->trans_complete();

        //$this->messages->add('Delete ' . $current_entry_type['name'] . ' Entry.', 'success');
        $this->session->set_flashdata('msg', 'Delete ' . $current_entry_type['name'] . ' Entry.');

        ?><script></script><?
    redirect('accounts/payments');
        //$this->template->load('template', 'payments/make_payment', $data);
        return;

    }

    function confirm( $entry_id = 0)
    {
//        var_dump($entry_id);
//        die();
        $entry_type='payment';
        /* Check access */
        if ( ! check_access('confirm  payment'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/payments');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/payments');
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/payments');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');

            redirect('accounts/payments');
            return;
        }

        $this->db->trans_start();

        $entrystat=array (
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
        $reciptdata=array (
            'CHQSTATUS'=>"CONFIRM",
        );
        if ( ! $this->db->where('PAYREFNO', $entry_id)->update('ac_chqprint', $reciptdata))
        {
            $this->db->trans_rollback();
            //$this->messages->add('Error updating Reciept Confirmation.', 'error');
            $this->session->set_flashdata('error', 'Error updating Entry Confirmation.');
            $this->logger->write_message("error", "Error updating Reciept Confirmation");
            //$this->template->load('template', 'entrymaster/cancel', $data);
            $this->load->view('accounts/entrymaster/cancel',$data);
            return;
        }
        $this->db->trans_complete();
        //$this->messages->add('Confirmed ' . $current_entry_type['name'] . ' Entry.', 'success');
        $this->session->set_flashdata('msg', 'Confirmed ' . $current_entry_type['name'] . ' Entry.');
        $this->logger->write_message("success", "Confirmed " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $cur_entry->number) . " [id:" . $entry_id . "]");
        redirect('accounts/payments');
        return;
    }

    function cancelation($entry_id = 0)
    {
//        var_dump($entry_id);
//        die();
        /* Check access */
        $entry_type="payment";
        if ( ! check_access('cancel payment'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/payments');
            return;
        }

        /* Check for account lock */
        if ($this->config->item('account_locked') == 1)
        {
            //$this->messages->add('Account is locked.', 'error');
            $this->session->set_flashdata('error', 'Account is locked.');
            redirect('accounts/payments');
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');

            redirect('accounts/payments');
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
            redirect('accounts/payments');
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
//            $this->template->load('template', 'payments/cancel', $data);
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

            if($data_all_ledger_dc){
            foreach ($data_all_ledger_dc as $id => $ledger_data)
            {
                if ($data_all_ledger_id[$id]  =="0")// modaification done by udani . Reasone : allow string ladger ids
                    continue;

                /* Check for valid ledger id */
                $this->db->from('ac_ledgers')->where('id', $data_all_ledger_id[$id]);
                $valid_ledger_q = $this->db->get();
                if ($valid_ledger_q->num_rows() < 1)
                {
                    $this->messages->add('Invalid Ledger account.', 'error');
                    $this->template->load('template', 'payments/cancel', $data);
                    return;
                } else {
                    /* Check for valid ledger type */
                    $valid_ledger = $valid_ledger_q->row();
                    if ($current_entry_type['bank_cash_ledger_restriction'] == '2')
                    {
                        if ($data_all_ledger_dc[$id] == 'D' && $valid_ledger->type == 1)
                        {
                            $bank_cash_present = TRUE;
                        }
                        if ($valid_ledger->type != 1)
                            $non_bank_cash_present = TRUE;
                    } else if ($current_entry_type['bank_cash_ledger_restriction'] == '3')
                    {
                        if ($data_all_ledger_dc[$id] == 'C' && $valid_ledger->type == 1)
                        {
                            $bank_cash_present = TRUE;
                        }
                        if ($valid_ledger->type != 1)
                            $non_bank_cash_present = TRUE;
                    } else if ($current_entry_type['bank_cash_ledger_restriction'] == '4')
                    {
                        if ($valid_ledger->type != 1)
                        {
                            $this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries can have only Bank and Cash ac_ledgers accounts.', 'error');
                            $this->template->load('template', 'payments/cancel', $data);
                            return;
                        }
                    } else if ($current_entry_type['bank_cash_ledger_restriction'] == '5')
                    {
                        if ($valid_ledger->type == 1)
                        {
                            $this->messages->add('Invalid Ledger account. ' . $current_entry_type['name'] . ' ac_entries cannot have Bank and Cash ac_ledgers accounts.', 'error');
                            $this->template->load('template', 'payments/cancel', $data);
                            return;
                        }
                    }
                }
                if ($data_all_ledger_dc[$id] == "D")
                {
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
                //$this->template->load('template', 'payments/cancel', $data);
                $this->load->view('accounts/payments/cancel',$data);
                return;
            } else if (float_ops($dr_total, 0, '==') || float_ops($cr_total, 0, '==')) {
                //$this->messages->add('Cannot save empty Entry.', 'error');
               // $this->session->set_flashdata('error', 'Cannot save empty Entry.');
                //$this->template->load('template', 'payments/cancel', $data);
                $this->load->view('accounts/payments/cancel',$data);
                return;
            }
            /* Check if atleast one Bank or Cash Ledger account is present */
            if ($current_entry_type['bank_cash_ledger_restriction'] == '2')
            {

            } else if ($current_entry_type['bank_cash_ledger_restriction'] == '3')
            {

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
            $data_date =$data_date; // Converting date to MySQL
            $data_has_reconciliation = $this->input->post('has_reconciliation', TRUE);

              /*Check before hit cancellation entry
            Ticket No:3160 Added By Madushan 2021-07-23*/
            $this->db->select('CHQSTATUS');
            $this->db->where('PAYREFNO',$entry_id);
            $query = $this->db->get('ac_chqprint');
            if($query->num_rows>0)
                $check_entry = $query->row()->CHQSTATUS;
            else
                $check_entry = false;
            if($check_entry != 'CANCEL'){
                 $this->db->trans_start();
            $update_data = array(
                'number' => $data_number,
                'date' => $data_date,
                'narration' => $data_narration,
                'entry_type' => '5',
                'tag_id' => $data_tag,
            );
            if ( ! $this->db->insert('ac_entries', $update_data))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Entry account.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry account.');
                $this->logger->write_message("error", "Error updating entry details for " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");
                //$this->template->load('template', 'payments/cancel', $data);
                $this->load->view('accounts/payments/cancel',$data);
                return;
            }
            else
            {
                $entry_idnew = $this->db->insert_id();
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
                    //->template->load('template', 'payments/cancel', $data);
                    $this->load->view('accounts/payments/cancel',$data);
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
                //$this->template->load('template', 'payments/cancel', $data);
                $this->load->view('accounts/payments/cancel',$data);
                return;
            }
            $entrystat=array (
                'entry_id'=>$entry_idnew,
                'status'=>"CONFIRM",
            );
            $this->db->insert('ac_entry_status', $entrystat);
            /*updating cheque print data*/
            $rctdata=$this->cheque_model->get_chequedata_by_entryid($entry_id);
            $reciptdata=array (
                'CNRES'=>$data_narration,
                'CANFERNO'=>$entry_idnew,
                'CHQSTATUS'=>"CANCEL",
                'CNDATE'=>date("Y-m-d H:i:s"),
            );
            if ( ! $this->db->where('PAYREFNO',$entry_id)->update('ac_chqprint', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Cancelation.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Cancelation.');
                $this->logger->write_message("error", "Error updating Cheque Cancelation");
                //$this->template->load('template', 'payments/cancel', $data);
                $this->load->view('accounts/payments/cancel',$data);
                return;
            }
            /*updating paymnet voucher data*/


           $this->cashadvance_model->delete_cashadvance_onpayment($entry_id);
            $this->generalpayment_model->delete_resale_refund($entry_id);
          //********************//updated - 2019-09-06/ udani /Manualy created Vouchers Delete on paymante deleted
        $dataarr=$this->paymentvoucher_model->get_paymentvouchres_by_entryid($entry_id);
        if($dataarr){
            foreach($dataarr as $rowdata)
            {
                if($rowdata->vouchertype==1 || $rowdata->vouchertype==2 || $rowdata->vouchertype==5 || $rowdata->vouchertype==4)
                {



                  $suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
                    if( ! $this->db->where('voucherid',$rowdata->voucherid)->update('ac_payvoucherdata',$suparray ))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating Invoice Status.', 'error');
                        $this->session->set_flashdata('error', 'Error updating Invoice Status.');
                    }

                }
                //updated by udani ticket number 1038
                else if($rowdata->vouchertype==7)
                {
                     $suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
                    if( ! $this->db->where('voucherid',$rowdata->voucherid)->update('ac_payvoucherdata',$suparray ))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating Invoice Status.', 'error');
                        $this->session->set_flashdata('error', 'Error updating Invoice Status.');
                    }
                    if ( !$this->db->where('voucher_id',$rowdata->voucherid)->delete('ac_outside_loanspayment'))
                    {
                        //$this->messages->add('Error Deleting Cheque Entry.', 'error');
                        $this->session->set_flashdata('error', 'Error Deleting Cheque Entry.');
                        redirect('accounts/entrymaster/show/' . $current_entry_type['label']);
                        return;
                    }

                }
                else
                {
                     $suparray=array('status'=>'DELETED','deleted_by'=>$this->session->userdata('userid'));
                    if( ! $this->db->where('voucherid',$rowdata->voucherid)->update('ac_payvoucherdata',$suparray ))
                    {
                        $this->db->trans_rollback();
                        //$this->messages->add('Error updating Invoice Status.', 'error');
                        $this->session->set_flashdata('error', 'Error updating Invoice Status.');
                    }

                }

            }
        }

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
            $this->session->set_flashdata('msg', 'success');
            /* Showing success message in show() method since message is too long for storing it in session */
            $this->logger->write_message("success", "Updated " . $current_entry_type['name'] . " Entry number " . full_entry_number($entry_type_id, $data_number) . " [id:" . $entry_id . "]");

            }
            else{
                 $this->session->set_flashdata('error', 'Already Cancelled');
            }
           
            redirect('accounts/payments');
            return;
//        }
//        return;
    }

    function cancelation_cheque($id)
    {

        if ( ! check_access('cancel cheque'))
        {
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/payments');
            return;
        }
		 $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', 2)->where('id', $id)->order_by('CRDATE');

        //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
        $entry_q = $this->db->get();
        foreach($entry_q->result() as $raw)
        {
            //print_r($raw);
            $isstart=$this->cheque_model->get_start_cheque_bundle();
            $reciptdata=array (
                'CHQSTATUS'=>"CANCEL",
                'CNRES'=>'Error On Print',
                'PAYREFNO'=>NULL,
            );
            if ( ! $this->db->where('CHQID', $raw->CHQID)->update('ac_chqprint', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Printing.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Printing.');
                $this->logger->write_message("error", "Error updating Reciept Confirmation");
                //$this->template->load('template', 'payments/printQueue/', $data);
                $this->load->view('accounts/payments/printQueue',$data);
                return;
            }
            $rcdnewdata=array (
                'CHQBID'=>$raw->CHQBID,
                'CHQNAME'=>$raw->CHQNAME,
                'PAYREFNO'=>$raw->PAYREFNO,
                'CRDATE'=>date("Y-m-d H:i:s"),
                'CHQSTATUS'=>'QUEUE');

            if ( ! $this->db->insert('ac_chqprint',$rcdnewdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Printing.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Printing.');
                $this->logger->write_message("error", "Error updating Reciept Confirmation");
                //$this->template->load('template', 'payments/printQueue/', $data);
                $this->load->view('accounts/payments/printQueue',$data);
                return;
            }
			 $voucher=array('status'=>'PENDING');
            if( ! $this->db->where('entry_id',$raw->PAYREFNO)->update('ac_entry_status',$voucher ))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Voucher Status.', 'error');
                $this->session->set_flashdata('error', 'Error updating Entry Status.');
            }
            //$reciptid=intval($nextid);


        }

        $this->db->trans_complete();
        $this->messages->add('Cheque Cancel  Successfuly '.$raw->CHQNO, 'success');
        $this->logger->write_message("success", "Cheque Cancel Successfuly".$raw->CHQNO);
        redirect('accounts/payments');


    }

    function printpreview($entry_id = 0)
    {
        $entry_type="payment";
        /* Check access */
        if ( ! check_access('print cueque'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/payments');
            return;
        }

        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry type.');
            redirect('accounts/payments');
            return;
        } else {
            $current_entry_type = entry_type_info($entry_type_id);
        }

        /* Load current entry details */
        if ( ! $cur_entry = $this->Entry_model->get_entry($entry_id, $entry_type_id))
        {
           // echo $entry_id."______".$entry_type_id;
            //$this->messages->add('Invalid Entry.', 'error');
            $this->session->set_flashdata('error', 'Invalid Entry.');
            //redirect('payments');
            return;
        }

        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        $data['entry_number'] =  $cur_entry->number;
        $data['entry_date'] = date_mysql_to_php_display($cur_entry->date);
        $data['entry_dr_total'] =  $cur_entry->dr_total;
        $data['entry_cr_total'] =  $cur_entry->cr_total;
        $data['entry_narration'] = $cur_entry->narration;

        $this->db->from('ac_entries')->where('id', $entry_id)->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id');
        $ledger_q = $this->db->get();
        $dataset=$ledger_q->row();
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

        $this->logger->write_message("success", "Cheque Re Printed Successfuly".$dataset->CHQNO);
        $data['chqequedata']=$dataset;
        $this->load->view('accounts/payments/printcheque', $data);
        return;
    }

//    function printQueue()
//    {
//        $entry_type='payment';
//        $data['tag_id'] = 0;
//        $entry_type_id = 0;
//
//
//        $entry_type_id = entry_type_name_to_id($entry_type);
//        $entry_q = NULL;
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
//        $pagination_counter =100;// $this->config->item('row_count');
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
//            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('CHQSTATUS', 'CONFIRM')->order_by('CRDATE')->limit(10, 0);
//            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
//            $entry_q = $this->db->get();
//            $config['total_rows'] = $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('CHQSTATUS', 'CONFIRM')->order_by('CRDATE')->get()->num_rows();
//        }
//        $isstart=$this->cheque_model->get_start_cheque_bundle();
//        $bookid=$isstart->CHQBID;
//        if($isstart)
//        {
//            $this->pagination->initialize($config);
//            $data['entry_data'] = $entry_q;
//
//            //$this->template->load('template', 'payments/printqueue', $data);
//            return;
//        }
//        else
//        {
//
//            $this->messages->add('Cheque Boundle Not Assigned.', 'error');
//            redirect('payments');
//            return;
//
//        }
//
//
//    }

    function printone($id,$chqno,$reprint = '')
    {
        $this->load->model('Tag_model');
	//echo $chqno;
        $data['tag_id'] = 0;
        $entry_type_id = 0;
        $entry_type='payment';
        //$this->template->set('page_title', 'Cheque Print');
        $entry_type_id = entry_type_name_to_id($entry_type);

        if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('id', $id)->order_by('CRDATE');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
        }
		$ledger_id=$this->common_model->get_entry_bank_account($id);
        $data['entry_data'] = $entry_q->result();
        $data['id'] = $id;
		$data['chqno'] = $chqno;
		$data['reprint'] = $reprint;
		$bankcode=get_account_bank_code($ledger_id);
		$data['voucher_ncode']=$this->updateprinone($id,$chqno);
        $this->load->view('accounts/payments/printone'.$bankcode, $data);
        return;

    }

    function updateprinone($id,$bookid)
    {



		$ledger=$this->Ledger_model->get_current_entry_bank_account($id);

        $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', 2)->where('id', $id)->order_by('CRDATE');
        //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
        $entry_q = $this->db->get();
        $printlist="";
        foreach($entry_q->result() as $raw)
        {
            //print_r($raw);
           // echo $bookid;

			$isstart=$this->cheque_model->get_start_cheque_bundle($ledger);
			 $bookid=$isstart->CHQBID;
            if($isstart)
            {
			  $recieptid=$this->cheque_model->is_max_cheque_id($bookid);
                if($recieptid->CHQNO!=0)
                    $chqno=intval($recieptid->CHQNO)+1;
                else
                    $chqno=$isstart->CHQBSNO;
                $chqno=str_pad($chqno, 6, "0", STR_PAD_LEFT);

			}
			else
			{
				 $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');
                redirect('accounts/payments');
                return;
			}
			if($raw->CHQNO == NULL || $raw->CHQNO == ''){
				$reciptdata=array (
					'CHQSTATUS'=>"PRINT",
					'CHQNO'=>$chqno,
					'CHQBID'=>$bookid,
				  );
				if ( ! $this->db->where('CHQID', $raw->CHQID)->update('ac_chqprint', $reciptdata))
				{
					$this->db->trans_rollback();
					$this->session->set_flashdata('error', 'Error updating Cheque Printing.');
					$this->logger->write_message("error", "Error updating Receipt Confirmation");
					$this->load->view('accounts/payments/printqueue',$data);
					return;
				}
				if($this->cheque_model->is_last_chequeno($bookid,$chqno))
				{
					$rcdnewdata=array (
						'CHQBSTATUS'=>'FINISH',
						'CHQBENDDATE'=>date("Y-m-d H:i:s"),
						'CHQBEBY'=>$this->session->userdata('username'),
					);
					if ( !$this->db->where('CHQBID',$bookid)->update('ac_chequebookdata', $rcdnewdata))
					{
						$this->db->trans_rollback();
						//$this->messages->add('Error Updating Cheque Boundle Status', 'error');
						$this->session->set_flashdata('error', 'Error Updating Cheque Boundle Status');
						//$this->logger->write_message("error", "Error Inserting Reciept Data");
						//$this->template->load('template', 'payments/printQueue/', $data);
						$this->load->view('accounts/payments/printqueue/',$data);


					}
					$this->logger->write_message("success","End Cheque Book ".$bookid);
				}
			}

            $printlist=$chqno;



        }

        $this->db->trans_complete();

		//vouchercode generate function call checque printing


	   	$this->db->select('*, SUM(amount) as amount')->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id')->where('entry_type', '2')->where('entryid', $id)->group_by('entryid')->order_by('voucherid','DESC');
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();

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


				 $reciptdata=array (
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
			}
		}


        //$this->messages->add('Cheque Queue Printed Successfuly', 'success');
        $this->session->set_flashdata('msg', 'Cheque Queue Printed Successfuly');
        $this->logger->write_message("success", "Cheque  Printed Successfuly".$printlist);
       // redirect('accounts/payments/index');
		return $voucher_ncode;

    }

    function printlist()
    {
        $data['tag_id'] = 0;
        $entry_type_id = 0;
        $entry_type='payment';
        //$this->template->set('page_title', 'Cheque Print');
        $entry_type_id = entry_type_name_to_id($entry_type);

        if ($entry_type_id > 0) {
            $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', $entry_type_id)->where('CHQSTATUS', 'CONFIRM')->order_by('CRDATE')->limit(10, 0);
            //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
            $entry_q = $this->db->get();
        }
        $isstart=$this->cheque_model->get_start_cheque_bundle($this->session->userdata('branchid'));
        $bookid=$isstart->CHQBID;
        if($isstart)
        {
            //echo $isstart;
            $data['entry_data'] = $entry_q->result();

            $this->load->view('accounts/payments/printpreview', $data);
        }
        else
        {
            //$this->messages->add('Cheque Boundle Not Assigned.', 'error');
            $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');
            redirect('accounts/payments');
            return;
        }

        return;

    }

    function updateprintlist()
    {

        $this->db->from('ac_entries')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id')->where('entry_type', 2)->where('CHQSTATUS', 'CONFIRM')->order_by('CRDATE')->limit(10, 0);
        //$this->db->join('tchdata','tchdata.TCHID=accclbook.TCHID');
        $entry_q = $this->db->get();
        $printlist="";
        foreach($entry_q->result() as $raw)
        {
            //print_r($raw);
            $isstart=$this->cheque_model->get_start_cheque_bundle($this->session->userdata('branchid'));
            $bookid=$isstart->CHQBID;
            if($isstart)
            {
                $recieptid=$this->cheque_model->is_max_cheque_id($isstart->CHQBID);
                if($recieptid->CHQNO!=0)
                    $nextid=intval($recieptid->CHQNO)+1;
                else
                    $nextid=$isstart->CHQBSNO;
                $nextid=str_pad($nextid, 6, "0", STR_PAD_LEFT);

            }
            else{
                //$this->messages->add('Cheque Boundle Not Assigned.', 'error');
                $this->session->set_flashdata('error', 'Cheque Boundle Not Assigned.');
                redirect('accounts/payments');
                return;
            }
            $reciptdata=array (
                'CHQSTATUS'=>"PRINT",
                'CHQNO'=>$nextid,
                'CHQBID'=>$bookid,
            );
            if ( ! $this->db->where('CHQID', $raw->CHQID)->update('ac_chqprint', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Printing.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Printing.');
                $this->logger->write_message("error", "Error updating Reciept Confirmation");
                //$this->template->load('template', 'payments/printQueue/', $data);
                $this->load->view('accounts/payments/printqueue',$data);
                return;
            }
            $printlist=$nextid.','.$printlist;
            $reciptid=intval($nextid);
            $CI =& get_instance();
            if($this->cheque_model->is_last_chequeno($bookid,$reciptid))
            {
                $rcdnewdata=array (
                    'CHQBSTATUS'=>'FINISH',
                    'CHQBENDDATE'=>date("Y-m-d H:i:s"),
                    'CHQBEBY'=>$CI->session->userdata('user_name'),
                );
                if ( !$this->db->where('CHQBID',$bookid)->update('ac_chequebookdata', $rcdnewdata))
                {
                    $this->db->trans_rollback();
                    //$this->messages->add('Error Updating Cheque Boundle Status', 'error');
                    $this->session->set_flashdata('error', 'Error Updating Cheque Boundle Status');
                    //$this->logger->write_message("error", "Error Inserting Reciept Data");
                    //$this->template->load('template', 'payments/printQueue/', $data);
                    $this->load->view('accounts/payments/printqueue/',$data);


                }
                $this->logger->write_message("success","End Cheque Book ".$bookid);
            }

        }

        $this->db->trans_complete();
        //$this->messages->add('Cheque Queue Printed Successfuly', 'success');
        $this->session->set_flashdata('error', 'Cheque Queue Printed Successfuly');
        $this->logger->write_message("success", "Cheque Queue Printed Successfuly".$printlist);
        redirect('accounts/payments/');


    }

    function search()
    {

        $entry_no=$this->input->post('entry_no');
        $amountsearch=$this->input->post('amountsearch');
        $cheque_no=$this->input->post('cheque_no');
        $name = $this->input->post('name');
        $project = $this->input->post('prj_id');

        $branchid = $this->session->userdata('branchid');

//        $this->template->set('page_title', 'Cheque Seach Data');
//        $seachdata=trim($this->input->post('search'));
//        $name=trim($this->input->post('search1'));
//        $number=trim($this->input->post('search2'));
//        $amount= trim($this->input->post('search3'));


        //$allsearch=$seachdata.$name.$number.$amount;
        $allsearch = $entry_no.$name.$amountsearch.$cheque_no.$project;
        //echo $allsearch;
        /* Pagination setup */

		$entry_type_id = entry_type_name_to_id('payment');
        if ($allsearch!="" ) {
			if($name!=''){
				$this->db->from('ac_entries')->where('entry_type', $entry_type_id)->like('ac_chqprint.CHQNAME',$name,'both')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc');
			}else if($entry_no!=''){
				$this->db->from('ac_entries')->where('entry_type', $entry_type_id)->like('ac_entries.number',$entry_no,'both')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc');
			}else if($amountsearch!=''){
				$this->db->from('ac_entries')->where('entry_type', $entry_type_id)->where('ac_entries.dr_total',$amountsearch)->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc');
			}else if($cheque_no!=''){
				$this->db->from('ac_entries')->where('entry_type', $entry_type_id)->like('ac_chqprint.CHQNO',$cheque_no,'both')->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc');
			}else if($project!=''){
                /*Ticket No:2771 Added By Madushan 2021.05.05*/
                $this->db->select('ac_entries.*,ac_chqprint.*,ac_entry_status.*')->from('ac_entries')->where('entry_type', $entry_type_id)->join('ac_chqprint','ac_chqprint.PAYREFNO=ac_entries.id','left')->join('ac_entry_status','ac_entry_status.entry_id=ac_entries.id','left')->join('ac_payvoucherdata','ac_payvoucherdata.entryid=ac_entries.id','left')->join('re_prjacpaymentdata','re_prjacpaymentdata.voucherid=ac_payvoucherdata.voucherid')->where('re_prjacpaymentdata.prj_id',$project)->order_by('date', 'desc')->order_by('CHQSTATUS', 'desc')->order_by('number', 'desc');
            }

            $entry_q = $this->db->get();
            /*Ticket No:2771 Added By Madushan 2021.05.05*/
            $data['prj_list'] = $this->common_model->get_all_projects();
            // foreach($entry_q->result() as $row){
            //     echo $row->id.'-'.$row->narration.'<br>';
            // }
            // exit;
			//check blank result
			if($entry_q->num_rows() > 0){
				$data['entry_data'] = $entry_q;
				$this->load->view('accounts/payments/search',$data);
			}else{
				$this->session->set_flashdata('error', 'No matching records found');
          		redirect('accounts/payments');
			}
        }
        else{
            //$this->messages->add('seach string couldnt be blank', 'error');

            $this->session->set_flashdata('error', 'Search string could not be blank');
          redirect('accounts/payments');

        }






    }

    function view($entry_type, $entry_id = 0)
    {
        /* Entry Type */
        $entry_type_id = entry_type_name_to_id($entry_type);
        if ( ! $entry_type_id)
        {
            //$this->messages->add('Invalid Entry type.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('accounts/payments');
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
            redirect('accounts/payments');
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
        $data['cur_entry'] = $cur_entry;
        $data['cur_entry_ac_ledgers'] = $cur_entry_ac_ledgers;
        $data['entry_type_id'] = $entry_type_id;
        $data['current_entry_type'] = $current_entry_type;
        //$this->template->load('template', 'payments/view', $data);
        $this->load->view('accounts/payments/view',$data);
        return;
    }

	function advance_list()
	{
			$data['banks']=$this->cashadvance_model->get_all_advance_tomake_payment();
		 $this->load->view('accounts/payments/bank_list',$data);
	}
	function otherlist_list()
	{
			$data['banks']=$this->Ledger_model->get_all_ac_ledgers_tomake_payment();
		 $this->load->view('accounts/payments/bank_list',$data);
	}
   function check_current_bookactive()
   {
	   $id=$this->input->get('id');
	   $ledger=$this->Ledger_model->get_current_entry_bank_account($id);
	   if($ledger)
	   {
	  		$isstart=$this->cheque_model->get_start_cheque_bundle($ledger);


			if($isstart)
			{
				 $bookid=$isstart->CHQBID;
				$recieptid=$this->cheque_model->is_max_cheque_id($isstart->CHQBID);
				if($recieptid->CHQNO!=0){
					$nextid=intval($recieptid->CHQNO)+1;
				}
				else{
					$nextid=$isstart->CHQBSNO;


				}
				$nextid=str_pad($nextid, 6, "0", STR_PAD_LEFT);
       		 }
			 else
			 {
				  echo "Please Assign Cheque Bundle befor Print";
			 }
	   }
	   else
	   {
		   echo "Ledger Not found";
	   }

   }
   function change_chequenumber()
   {

;	    $reciptdata=array (
                'CHQNO'=>$this->input->post('chqno'),

            );
			//echo $this->input->post('chqno');

            if ( ! $this->db->where('CHQID',$this->input->post('CHQID'))->update('ac_chqprint', $reciptdata))
            {
                $this->db->trans_rollback();
                //$this->messages->add('Error updating Cheque Printing.', 'error');
                $this->session->set_flashdata('error', 'Error updating Cheque Printing.');
                $this->logger->write_message("error", "Error updating Reciept Confirmation");
                //$this->template->load('template', 'payments/printQueue/', $data);
                $this->load->view('accounts/payments/printqueue',$data);
                return;
            }
			echo $this->input->post('chqno');
   }

}
