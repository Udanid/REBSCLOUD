<?php
// Created by Eranga on 06/06/2018
class Reconciliation extends CI_Controller {

	function Reconciliation()
	{
		parent::__construct();
		$this->load->model('reconciliation_model');
		$this->load->model('common_model');
		$this->load->model('ledger_model');
		$this->load->helper('custom_helper');
		$this->is_logged_in();
		return;
	}

	function getAlldebit($limitmonth = '')
	{
		//get all debit transactions depend on selections
		$transactions = $this->reconciliation_model->getAlldebit($this->input->post('ledger_id'),$this->input->post('showall'),$limitmonth,$this->input->post('fromdate'),$this->input->post('todate'));
		
		//create Debit transactions table
		echo "<table width='100%' border=0 cellpadding=5 class=\"simple-table reconciliation-table\">";

		echo "<thead><tr><th><i class='fa fa-check-square'></i></th><th>Date</th><th>Receipt NO</th><th>Payer</th><th>CHQ NO</th><th>Debit Amount</th></tr></thead>";
		$odd_even = "odd";

		foreach ($transactions as $row)
		{
			$current_entry_type = entry_type_info($row->ac_entries_entry_type);

			echo "<tr class=\"tr-" . $odd_even;
			if ($row->ac_entry_items_reconciliation_date) //add class tr-reconciled for reconsiled transactions
				echo " tr-reconciled";
			echo "\">";
			
				echo "<td>";
				//disable check boxes if transaction has a reconciliation date
				if ($row->ac_entry_items_reconciliation_date){
					echo form_checkbox(array(
						'name' => 'checked',
						//'id' => $row->ac_entries_id,
						'id' => $row->ac_entry_items_id,
						'value' => $row->ac_entry_items_checked,
						'checked' => ($row->ac_entry_items_checked == 1 ),
						'onclick' => 'javascript:updateCheckedval('.$row->ac_entry_items_id.')',
						'disabled' => '' //disable check boxes
					));
				}else{
					echo form_checkbox(array(
						'name' => 'checked',
						//'id' => $row->ac_entries_id,
						'id' => $row->ac_entry_items_id,
						'value' => $row->ac_entry_items_checked,
						'checked' => ($row->ac_entry_items_checked == 1 ),
						'onclick' => 'javascript:updateCheckedval('.$row->ac_entry_items_id.')'
					));	
				}
				echo "</td>";
				
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				echo date('Y-m-d', strtotime($row->ac_entries_date));
				echo "</td>";
				
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				echo $row->RCTNO;
				echo "</td>";
	
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				if ($row->rcvname){
					echo '<p title="'.$row->rcvname.'">'.$this->substrwords($row->rcvname,30).'</p>'; //if receipt name available
				}else{
					echo '<p title="'.$row->ac_entries_narration.'">'.$this->substrwords($row->ac_entries_narration,30).'</p>';	//if receipt name not available print entry narration
				}
				echo "</td>";
	
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				echo $row->RCVCHK;
				echo "</td>";
				
				echo "<td align='right' ";
				  if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					  echo " style=color:#3399ff;";
				  echo ">";
				echo convert_account($row->ac_entry_items_amount);
				echo "</td>";
			
			echo "</tr>";
			$odd_even = ($odd_even == "odd") ? "even" : "odd";
		}

		echo "</table>";
	}
	
	function getAllcredit($limitmonth = '')
	{
		//get all credit transactions depend on selections
		$transactions = $this->reconciliation_model->getAllcredit($this->input->post('ledger_id'),$this->input->post('showall'),$limitmonth,$this->input->post('fromdate'),$this->input->post('todate'));
		
		//create credit transactions table using data
		echo "<table width='100%' border=0 cellpadding=5 class=\"simple-table reconciliation-table\">";

		echo "<thead><tr><th><i class='fa fa-check-square'></i></th><th>Date</th><th>Voucher NO</th><th>Payee</th><th>CHQ NO</th><th>Credit Amount</th></tr></thead>";
		$odd_even = "odd";

		foreach ($transactions as $row)
		{
			$current_entry_type = entry_type_info($row->ac_entries_entry_type);

			echo "<tr class=\"tr-" . $odd_even;
			if ($row->ac_entry_items_reconciliation_date) //add class tr-reconciled for reconsiled transactions
				echo " tr-reconciled";
			echo "\">";
			
				echo "<td>";
				if ($row->ac_entry_items_reconciliation_date){
					echo form_checkbox(array(
						'name' => 'checked',
						//'id' => $row->ac_entries_id,
						'id' => $row->ac_entry_items_id,
						'value' => $row->ac_entry_items_checked,
						'checked' => ($row->ac_entry_items_checked == 1 ),
						'onclick' => 'javascript:updateCheckedval('.$row->ac_entry_items_id.')',
						'disabled' => '' //disable checkbox if reconsiliation date is available
					));
				}else{
					echo form_checkbox(array(
						'name' => 'checked',
						//'id' => $row->ac_entries_id,
						'id' => $row->ac_entry_items_id,
						'value' => $row->ac_entry_items_checked,
						'checked' => ($row->ac_entry_items_checked == 1 ),
						'onclick' => 'javascript:updateCheckedval('.$row->ac_entry_items_id.')'
					));	
				}
				echo "</td>";
				
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				echo date('Y-m-d', strtotime($row->ac_entries_date));
				echo "</td>";
				
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				$result = get_voucher_no($row->ac_entries_id);
				echo $result;
				echo "</td>";
	
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				if ($row->CHQNAME){
					echo '<p title="'.$row->CHQNAME.'">'.$this->substrwords($row->CHQNAME,30).'</p>'; //print name of the checque if available
				}else{
					echo '<p title="'.$row->ac_entries_narration.'">'.$this->substrwords($row->ac_entries_narration,30).'</p>';	//print narration of the transaction if cheque name is unavailable
				}
				echo "</td>";
	
				echo "<td ";
				if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					echo " style=color:#3399ff;";
				echo ">";
				echo $row->CHQNO;
				echo "</td>";
				
				echo "<td align='right' ";
				 if ($row->ac_entry_items_checked == 1 && $row->ac_entry_items_reconciliation_date == NULL) //change the color of transactions upon checked status (if not reconsiled)
					  echo " style=color:#3399ff;";
				  echo ">";
				echo  convert_account($row->ac_entry_items_amount);
				echo "</td>";

			echo "</tr>";
			$odd_even = ($odd_even == "odd") ? "even" : "odd";
		}

		echo "</table>";
	}
	
	//reconsile selected transactions and create report
	function reconsileSelected($limitmonth = ''){

		//get checked transacrions
		$transactions = $this->reconciliation_model->getChecked($this->input->post('ledger_id'));
		
		//get date and define file name
		if($this->input->post('date')){
			$reconcilie_date = $this->input->post('date');
			$date = $this->input->post('date').date('_H-i-s');
			$filename = $this->input->post('ledger_id').'_'.$date.'_reconciliation_report.pdf';
			$filename_excel = $this->input->post('ledger_id').'_'.$date.'_reconciliation_report.xls';
			$filename_summary = $this->input->post('ledger_id').'_'.$date.'_reconciliation_report_summary.xls';
		}else{
			$reconcilie_date = '';
			$date = date('Y-m-d_H-i-s');
			$filename = $this->input->post('ledger_id').'_'.$date.'_reconciliation_report.pdf';
			$filename_excel = $this->input->post('ledger_id').'_'.$date.'_reconciliation_report.xls';
			$filename_summary = $this->input->post('ledger_id').'_'.$date.'_reconciliation_report_summary.xls';
		}

		//path to save the file
		//$pdfroot = "./bankrec/pdfs/".$filename;
		$excelroot = "./bankrec/excel/".$filename_excel;
		$summaryroot = "./bankrec/summary/".$filename_summary;
	
		// Load all views as normal
		//$this->load->view('accounts/report/reconciliationreport',$data);
		
		$currentledger = $this->ledger_model->getLedgerbyID($this->input->post('ledger_id'));
		$opbalance = $this->ledger_model->get_op_balance($this->input->post('ledger_id'));
		$newcreditbalance = 0;
		$newdebitbalance = 0;
		$newcreditbalance_un = 0;
		$newdebitbalance_un = 0;
		$new_newcreditbalance_un = 0;
		$new_newdebitbalance_un = 0;
		$bank_op_balance = $this->getbank_op_balance($this->input->post('ledger_id'));
		$bank_closing_balance = $this->getbank_cl_balance($this->input->post('ledger_id'));
		
		
		// Get output html
		$html = ''.$date.'
			<h3 style="margin-top:0; margin-bottom:0;" class="title1">Bank Reconciliation Report - '.$currentledger->name.' ('.$currentledger->id.')</h3>';
		if($this->input->post('date')){
			$html .= '<h4 style="margin-top:10px; border-bottom:3px solid #000;">Report ending on '.$this->input->post('date').'</h4>';
		}else{
			$html .= '<h4 style="margin-top:10px; border-bottom:3px solid #000;">Report ending on '.date('Y-m-d', strtotime('last day of previous month')).'</h4>';
		}
		
		$html .= "<table cellspacing='0' cellpadding='0' style='font-family:Verdana, Geneva, sans-serif; font-size:12px;' width='100%' border=0 cellpadding=5 class=\"simple-table reconciliation-table\">";
		$html .= "<thead><tr><th>Date</th><th>Number</th><th>Name</th><th>Amount</th><th>Balance</th></tr></thead>";
		$html .= "<tr style='font-weight:bold;'><td colspan='4'>Opening Balance</td><td align='right'>".convert_account($this->getbank_op_balance($this->input->post('ledger_id')))."</td></tr>";
		$html .= "<tr style='font-weight:bold;'><td colspan='5'><h4 style='margin:0; border-bottom:2px solid #000'>Cleared Transactions</h4></td></tr>";
		
		
		//payments	
		$credittransactions = $this->reconciliation_model->get_selected('credit',$this->input->post('ledger_id'));
		
		
		$html .= "<tr style='font-weight:bold;'><td colspan='5 '>Payements and Cheques</td></tr>";
		foreach ($credittransactions as $data){
			$voucher = $this->reconciliation_model->getVoucherbyentryID($this->input->post('ledger_id'));
			$newcreditbalance = float_ops($newcreditbalance, $data->ac_entry_items_amount, '-');
			$html .= "<tr>
						<td>".date('Y-m-d', strtotime($data->ac_entries_date))."</td>
						<td>".$data->CHQNO." ".$voucher."</td>
						<td>";
						
						if($data->CHQNAME){
							$html .= $this->substrwords($data->CHQNAME,30);
						}else{
							$html .= $this->substrwords($data->ac_entries_narration,30);
						}
			$html .=   "</td>
						<td align='right'>-".convert_account($data->ac_entry_items_amount)."</td>
						<td align='right'>".convert_account($newcreditbalance)."</td>
					</tr>";
		}
		$html .= "<tr><td></td><td colspan='2'>Payments and Cheques Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance)."</td></tr>";
		
		$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
		//end payments
	
		//deposits
		$debittransactions = $this->reconciliation_model->get_selected('debit',$this->input->post('ledger_id'));

		
		$html .= "<tr style='font-weight:bold;'><td colspan='5'>Credit Items and Deposits</td></tr>";
		
		foreach ($debittransactions as $data){
			$newdebitbalance = float_ops($newdebitbalance, $data->ac_entry_items_amount, '+');
			$html .= "<tr>
						<td>".date('Y-m-d', strtotime($data->ac_entries_date))."</td>
						<td>".$data->CHQNO." ".$data->RCTNO."</td>
						<td>";
						if($data->CHQNAME){
							$html .= $this->substrwords($data->CHQNAME,30);
						}else{
							$html .= $this->substrwords($data->ac_entries_narration,30);
						}
			$html .= 	"</td>
						<td align='right'>".convert_account($data->ac_entry_items_amount)."</td>
						<td align='right'>".convert_account($newdebitbalance)."</td>
					</tr>";
		}
		$html .= "<tr><td></td><td colspan='2'>Deposits Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newdebitbalance)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newdebitbalance)."</td></tr>";
		//end deposits
		
		$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
		
		//calculate cleared total
		$html .= "<tr style='font-weight:bold;'><td></td><td colspan='2'>Cleared Transactions Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance+$newdebitbalance)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance+$newdebitbalance)."</td></tr>";
		
		//calculate cleared balance
		$html .= "<tr style='font-weight:bold;'><td colspan='3'>Cleared Balance</td><td align='right'>".convert_account($newcreditbalance+$newdebitbalance)."</td><td align='right'>".convert_account($this->getbank_cl_balance($this->input->post('ledger_id')))."</td></tr>";
		
		$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
		
		if($this->reconciliation_model->reconsileSelected($this->input->post('ledger_id'),$this->input->post('bankBalance'))){ //reconsile selected debit transactions
			$this->getAlldebit($limitmonth);
			//uncleared transactions
	
			//payments	
			$credittransactions_un = $this->reconciliation_model->getAllcreditnew($this->input->post('ledger_id'),$this->session->userdata('fy_start'),$reconcilie_date);//Ticket No-2806 | Added By Uvini
			//deposits
			$debittransactions_un = $this->reconciliation_model->getAlldebitnew($this->input->post('ledger_id'),$this->session->userdata('fy_start'),$reconcilie_date);//Ticket No-2806 | Added By Uvini
			
			if($credittransactions_un || $debittransactions_un){
			
				$html .= "<tr style='font-weight:bold;'><td colspan='5'><h4 style='margin:0; border-bottom:2px solid #000'>Uncleared Transactions</h4></td></tr>";
				
				$html .= "<tr style='font-weight:bold;'><td colspan='5 '>Payements and Cheques</td></tr>";
				foreach ($credittransactions_un as $data){
					$voucher = $this->reconciliation_model->getVoucherbyentryID($this->input->post('ledger_id'));
					$newcreditbalance_un = float_ops($newcreditbalance_un, $data->ac_entry_items_amount, '-');
					$html .= "<tr>
								<td>".date('Y-m-d', strtotime($data->ac_entries_date))."</td>
								<td>".$data->CHQNO." ".$voucher."</td>
								<td>";
								
								if($data->CHQNAME){
									$html .= $this->substrwords($data->CHQNAME,30);
								}else{
									$html .= $this->substrwords($data->ac_entries_narration,30);
								}
					$html .=   "</td>
								<td align='right'>-".convert_account($data->ac_entry_items_amount)."</td>
								<td align='right'>".convert_account($newcreditbalance_un)."</td>
							</tr>";
				}
				$html .= "<tr><td></td><td colspan='2'>Payments and Cheques Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance_un)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance_un)."</td></tr>";
				
				$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
				//end payments
				
				$html .= "<tr style='font-weight:bold;'><td colspan='5'>Credit Items and Deposits</td></tr>";
				
				foreach ($debittransactions_un as $data){
					$newdebitbalance_un = float_ops($newdebitbalance_un, $data->ac_entry_items_amount, '+');
					$html .= "<tr>
								<td>".date('Y-m-d', strtotime($data->ac_entries_date))."</td>
								<td>".$data->CHQNO." ".$data->RCTNO."</td>
								<td>";
								if($data->CHQNAME){
									$html .= $this->substrwords($data->CHQNAME,30);
								}else{
									$html .= $this->substrwords($data->ac_entries_narration,30);
								}
					$html .= 	"</td>
								<td align='right'>".convert_account($data->ac_entry_items_amount)."</td>
								<td align='right'>".convert_account($newdebitbalance_un)."</td>
							</tr>";
				}
				$html .= "<tr><td></td><td colspan='2'>Deposits Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newdebitbalance_un)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newdebitbalance_un)."</td></tr>";
				//end deposits
			
				$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
					
				//calculate uncleared total
				$html .= "<tr style='font-weight:bold;'><td></td><td colspan='2'>Uncleared Transactions Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance_un+$newdebitbalance_un)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($newcreditbalance_un+$newdebitbalance_un)."</td></tr>";
			}
			
			
			//balances
		  $newbalances = $newcreditbalance+$newdebitbalance;
		  $newbalanceces_un = $newcreditbalance_un+$newdebitbalance_un;
		  
		  if($newbalanceces_un < 0)
			  //$register = float_ops($newbalances,$newbalanceces_un, '+');
			  $register = bcadd ($newbalances,$newbalanceces_un,2);
		  else
			  //$register = float_ops($newbalances,$newbalanceces_un, '-');
			  $register = bcsub ($newbalances,$newbalanceces_un,2);
		 
		  		  
		  $ledger_balance = $this->ledger_model->get_ledger_balance_todate($currentledger->id,$reconcilie_date);//Uvini
			if($this->input->post('date')){
				$html .= "<tr><td colspan='3'>Register Balance as at ".$this->input->post('date')."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($register)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($ledger_balance)."</td></tr>";
			}else{
				$html .= "<tr><td colspan='3'>Register Balance as at ".date('Y-m-d', strtotime('last day of previous month'))."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($register)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($ledger_balance)."</td></tr>";
			}
			$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
			
			//New transactions
			//payments	
			$new_credittransactions_un = $this->reconciliation_model->getAllcreditnew($this->input->post('ledger_id'),date('Y-m-01'),date('Y-m-d'));
			//deposits
			$new_debittransactions_un = $this->reconciliation_model->getAlldebitnew($this->input->post('ledger_id'),date('Y-m-01'),date('Y-m-d'));
			
			if($new_credittransactions_un || $new_debittransactions_un){
			
				$html .= "<tr style='font-weight:bold;'><td colspan='5'><h4 style='margin:0; border-bottom:2px solid #000'>New Transactions</h4></td></tr>";
				
				$html .= "<tr style='font-weight:bold;'><td colspan='5 '>Payements and Cheques</td></tr>";
				foreach ($new_credittransactions_un as $data){
					$voucher = $this->reconciliation_model->getVoucherbyentryID($this->input->post('ledger_id'));
					$new_newcreditbalance_un = float_ops($new_newcreditbalance_un, $data->ac_entry_items_amount, '-');
					$html .= "<tr>
								<td>".date('Y-m-d', strtotime($data->ac_entries_date))."</td>
								<td>".$data->CHQNO." ".$voucher."</td>
								<td>";
								
								if($data->CHQNAME){
									$html .= $this->substrwords($data->CHQNAME,30);
								}else{
									$html .= $this->substrwords($data->ac_entries_narration,30);
								}
					$html .=   "</td>
								<td align='right'>-".convert_account($data->ac_entry_items_amount)."</td>
								<td align='right'>".convert_account($new_newcreditbalance_un)."</td>
							</tr>";
				}
				$html .= "<tr><td></td><td colspan='2'>Payments and Cheques Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($new_newcreditbalance_un)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($new_newcreditbalance_un)."</td></tr>";
				
				$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
				//end payments
				
				$html .= "<tr style='font-weight:bold;'><td colspan='5'>Credit Items and Deposits</td></tr>";
				
				foreach ($new_debittransactions_un as $data){
					$new_newdebitbalance_un = float_ops($new_newdebitbalance_un, $data->ac_entry_items_amount, '+');
					$html .= "<tr>
								<td>".date('Y-m-d', strtotime($data->ac_entries_date))."</td>
								<td>".$data->CHQNO." ".$data->RCTNO."</td>
								<td>";
								if($data->CHQNAME){
									$html .= $this->substrwords($data->CHQNAME,30);
								}else{
									$html .= $this->substrwords($data->ac_entries_narration,30);
								}
					$html .= 	"</td>
								<td align='right'>".convert_account($data->ac_entry_items_amount)."</td>
								<td align='right'>".convert_account($new_newdebitbalance_un)."</td>
							</tr>";
				}
				$html .= "<tr><td></td><td colspan='2'>Deposits Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($new_newdebitbalance_un)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($new_newdebitbalance_un)."</td></tr>";
				//end deposits
			
				$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
					
				//calculate uncleared total
				$html .= "<tr style='font-weight:bold;'><td></td><td colspan='2'>New Transactions Total</td><td align='right' style='border-top:1px solid #000;'>".convert_account($new_newcreditbalance_un+$new_newdebitbalance_un)."</td><td align='right' style='border-top:1px solid #000;'>".convert_account($new_newcreditbalance_un+$new_newdebitbalance_un)."</td></tr>";
			}
		}
		
		$new_newbalance_un = $new_newcreditbalance_un+$new_newdebitbalance_un;
		//balances
		if($register < 0)
			//$ending = float_ops($register,$new_newbalance_un, '+');
			$ending = bcadd ($register,$new_newbalance_un,2);
		else
			//$ending = float_ops($register,$new_newbalance_un, '-');
			$ending = bcadd  ($register,$new_newbalance_un,2);
		
		if($ledger_balance < 0)
			//$ending_balance = float_ops($ledger_balance,$new_newbalance_un, '+');
			$ending_balance = bcadd ($ledger_balance,$new_newbalance_un,2);
		else
			//$ending_balance = float_ops($ledger_balance,$new_newbalance_un, '-');
			$ending_balance = bcadd  ($ledger_balance,$new_newbalance_un,2);

		$html .= "<tr style='font-weight:bold;'><td colspan='5'>&nbsp;</td></tr>";
		
		
		$html .= "<tr style='font-weight:bold;'><td colspan='3'>Ending Balance</td><td style='border-bottom:2px solid #000; border-top:1px solid #000;' align='right'>".convert_account($ending)."</td><td style='border-bottom:2px solid #000; border-top:1px solid #000;' align='right'>".convert_account($ending_balance)."</td></tr>";
		
		$html .= "</table>";
		
		//Create Summary
		$summary = '';
		$summary = ''.$date.'
			<h3 style="margin-top:0; margin-bottom:0;" class="title1">'.companyname.'<br>RECONCILATION  SUMMARY	 - '.$currentledger->name.' ('.$currentledger->id.')</h3>';
		if($reconcilie_date != ''){
			$summary .= '<h4 style="margin-top:10px; border-bottom:3px solid #000;">Report ending on '.$reconcilie_date.'</h4>';
		}else{
			$summary .= '<h4 style="margin-top:10px; border-bottom:3px solid #000;">Report ending on '.date('Y-m-d', strtotime('last day of previous month')).'</h4>';
		}

		$summary .= '<table width="600" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td><strong>Opening Balance (Bank)</strong></td>
						<td></td>
						<td align="right"><strong>'.number_format($bank_op_balance,2).'</strong></td>
					  </tr>
					  <tr>
						<td>&nbsp;&nbsp;&nbsp;<strong><u>Cleared Transactions</u></strong></td>
						<td></td>
						<td align="right"></td>
					  </tr>
					  <tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;Payments and Cheques - Total</td>
						<td align="right">'.number_format($newcreditbalance,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;Credit Items and Deposits - Total</td>
						<td align="right">'.number_format($newdebitbalance,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td>&nbsp;&nbsp;&nbsp;Cleared Transactions - Total</td>
						<td align="right" style="border-top:1px solid #000; border-bottom:1px double #000;">'.number_format($newcreditbalance+$newdebitbalance,2).'</td>
						<td>'.number_format($newcreditbalance+$newdebitbalance,2).'</td>
					  </tr>
					  <tr>
						<td><strong>Cleared Balance (Bank)</strong></td>
						<td></td>
						<td align="right" style="border-top:1px solid #000;">'.number_format($bank_closing_balance,2).'</td>
					  </tr>
					  <tr>
						<td><strong><u>Uncleared Transactions ('.$reconcilie_date.')</u></strong></td> 
						<td></td>
						<td align="right" style="border-top:1px solid #000;;"></td>
					  </tr>
					  <tr>
						<td>Payments and Cheques  - Total</td>
						<td>'.number_format($newcreditbalance_un,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td>Credit Items and Deposits - Total</td>
						<td>'.number_format($newdebitbalance_un,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td>Un-Cleared Transactions  - Total		</td>
						<td align="right" style="border-top:1px solid #000; border-bottom:1px double #000;">'.number_format($newcreditbalance_un+$newdebitbalance_un,2).'</td>
						<td></td>
					  </tr>';
					  
					  if($reconcilie_date != ''){
						 // $ledger_balance = $this->ledger_model->get_ledger_balance_todate($currentledger->id,$date);
						  $summary .= '<tr>
										<td><strong>Register Balance as at '.$reconcilie_date.' (Ledger)</strong></td>
										<td></td>
										<td align="right"><strong>'.number_format($ledger_balance,2).'</strong></td>
					  				   </tr>';
					  }else{
						  $ledger_balance = $this->ledger_model->get_ledger_balance_todate($currentledger->id,$reconcilie_date);
						  $summary .= '<tr>
										<td><strong>Register Balance as at '.date('Y-m-d', strtotime('last day of previous month')).' (Ledger)</strong></td>
										<td></td>
										<td align="right"><strong>'.number_format($ledger_balance,2).'</strong></td>
					  				   </tr>';
					  }
					  $summary .= '<tr>
						<td><strong><u>New Transactions</u></strong></td>
						<td></td>
						<td align="right" style="border-top:1px solid #000;;"></td>
					  </tr>
					  <tr>
						<td>Payments and Cheques  - Total</td>
						<td>'.number_format($new_newcreditbalance_un,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td>Credit Items and Deposits - Total</td>
						<td>'.number_format($new_newdebitbalance_un,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td>New Transactions - Total		</td>
						<td align="right" style="border-top:1px solid #000; border-bottom:1px double #000;">'.number_format($new_newcreditbalance_un+$new_newdebitbalance_un,2).'</td>
						<td></td>
					  </tr>
					  <tr>
						<td><strong>Ending Balance (Ledger)</strong></td>
						<td></td>
						<td><strong>'.number_format($ending_balance,2).'</strong></td>
						
					  </tr>';
					  
		
							

		// Load library
		//$this->load->library('dompdf_gen');
		// Convert to PDF
		//$this->dompdf->load_html($html);
		//$this->dompdf->render();
		//$pdf_string =   $this->dompdf->output();
       // file_put_contents($pdfroot, $pdf_string );
		file_put_contents($excelroot.'', $html);
		file_put_contents($summaryroot.'', $summary);

		
	}
	
	function getbank_op_balance($ledger_id){
		$bank_balance = $this->reconciliation_model->getBankopBalance($ledger_id);
/*		$credittransactions = $this->reconciliation_model->get_selected('credit',$ledger_id);
		$credit_total = 0;
		foreach($credittransactions as $data){
			$credit_total = $credit_total+$data->ac_entry_items_amount;
		}
		$debittransactions = $this->reconciliation_model->get_selected('debit',$ledger_id);
		$debit_total = 0;
		foreach($debittransactions as $data){
			$debit_total = $debit_total+$data->ac_entry_items_amount;
		}
		$op_bank_balance = (int)$bank_balance-((int)$credit_total-(int)$debit_total);*/
		return $bank_balance;
	}
	
	function getbank_cl_balance($ledger_id){
		$bank_clbalance = $this->reconciliation_model->getBankBalance($ledger_id);
		return $bank_clbalance;
	}
	
	function getBalances(){
		$ledger_id = $this->input->post('ledger_id');
		$showall = $this->input->post('showall');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		//list ($opbalance, $optype) = $this->ledger_model->get_op_balance($ledger_id); /* Opening Balance */
		//$clbalance = $this->ledger_model->get_ledger_balance($ledger_id); /* Final Closing Balance */
		//$clbalance = $this->ledger_model->get_opledger_balance_period($ledger_id,$fromdate,$todate); /* Final Closing Balance */
		
		if($showall=='1'){
			$opbalance = $this->ledger_model->get_opledger_balance_period($ledger_id,$fromdate,$todate); 
			$clbalance = $this->ledger_model->get_ledger_balance_period($ledger_id,$fromdate,$todate);
			/* Reconciliation Balance - Dr */
			$this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D')->where('ac_entry_items.reconciliation_date IS NOT NULL')->where('ac_entries.date >=', $fromdate)->where('ac_entries.date <=', $todate);
			$dr_total_q = $this->db->get();
			if ($dr_total = $dr_total_q->row())
				$reconciliation_dr_total = $dr_total->drtotal;
			else
				$reconciliation_dr_total = 0;
	
			/* Reconciliation Balance - Cr */
			$this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C')->where('ac_entry_items.reconciliation_date IS NOT NULL')->where('ac_entries.date >=', $fromdate)->where('ac_entries.date <=', $todate);
			$cr_total_q = $this->db->get();
			if ($cr_total = $cr_total_q->row())
				$reconciliation_cr_total = $cr_total->crtotal;
			else
				$reconciliation_cr_total = 0;
				
			/* Pending Reconciliation Balance - Dr */
			$this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D')->where('ac_entry_items.reconciliation_date IS NULL')->where('ac_entries.date >=', $fromdate)->where('ac_entries.date <=', $todate);
			$dr_total_q = $this->db->get();
			if ($dr_total = $dr_total_q->row())
				$reconciliation_pend_dr_total = $dr_total->drtotal;
			else
				$reconciliation_pend_dr_total = 0;
	
			/* Pending Reconciliation Balance - Cr */
			$this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C')->where('ac_entry_items.reconciliation_date IS NULL')->where('ac_entries.date >=', $fromdate)->where('ac_entries.date <=', $todate);
			$cr_total_q = $this->db->get();
			if ($cr_total = $cr_total_q->row())
				$reconciliation_pend_cr_total = $cr_total->crtotal;
			else
				$reconciliation_pend_cr_total = 0;
			
			$reconciliation_total = float_ops($reconciliation_dr_total, $reconciliation_cr_total, '-');
			$reconciliation_pending = float_ops($clbalance, $reconciliation_total, '-');
			$opening = float_ops($reconciliation_pend_dr_total, $reconciliation_pend_cr_total, '-');
			
			/* Cleared Balance - Dr */
			$this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D')->where('ac_entry_items.reconciliation_date IS NULL')->where('ac_entry_items.checked =', '1')->where('ac_entries.date >=', $fromdate)->where('ac_entries.date <=', $todate);
			$dr_total_q = $this->db->get();
			if ($dr_total = $dr_total_q->row())
				$cleared_dr_total = $dr_total->drtotal;
			else
				$cleared_dr_total = 0;
	
			/* Cleared Balance - Cr */
			$this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C')->where('ac_entry_items.reconciliation_date IS NULL')->where('ac_entry_items.checked =', '1')->where('ac_entries.date >=', $fromdate)->where('ac_entries.date <=', $todate);
			$cr_total_q = $this->db->get();
			if ($cr_total = $cr_total_q->row())
				$cleared_cr_total = $cr_total->crtotal;
			else
				$_cr_total = 0;
			
			$cleared_total = float_ops($cleared_dr_total, $cleared_cr_total, '-');
		}else{
			list ($opbalance, $optype) = $this->ledger_model->get_op_balance($ledger_id); /* Opening Balance */
			$clbalance = $this->ledger_model->get_ledger_balance($ledger_id); /* Final Closing Balance */
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
			$opening = ($opbalance-$clbalance) + $reconciliation_total;
			
			/* Cleared Balance - Dr */
			$this->db->select_sum('amount', 'drtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'D')->where('ac_entry_items.reconciliation_date IS NULL')->where('ac_entry_items.checked =', '1');
			$dr_total_q = $this->db->get();
			if ($dr_total = $dr_total_q->row())
				$cleared_dr_total = $dr_total->drtotal;
			else
				$cleared_dr_total = 0;
	
			/* Cleared Balance - Cr */
			$this->db->select_sum('amount', 'crtotal')->from('ac_entry_items')->join('ac_entries', 'ac_entries.id = ac_entry_items.entry_id')->where('ac_entry_items.ledger_id', $ledger_id)->where('ac_entry_items.dc', 'C')->where('ac_entry_items.reconciliation_date IS NULL')->where('ac_entry_items.checked =', '1');
			$cr_total_q = $this->db->get();
			if ($cr_total = $cr_total_q->row())
				$cleared_cr_total = $cr_total->crtotal;
			else
				$cleared_cr_total = 0;
			
			$cleared_total = float_ops($cleared_dr_total, $cleared_cr_total, '-');
		}
		
		$cleared_total = number_format($cleared_total,2,'.','');
		$bankbalance = $this->reconciliation_model->getBankBalance($ledger_id);
		$bankopbalance = $this->reconciliation_model->getBankopBalance($ledger_id);
		$totaltoclear = bcsub ($bankbalance,$bankopbalance,2);
		/*if($bankbalance < 0 && $bankopbalance < 0){
			$totaltoclear = number_format(float_ops($bankopbalance, $bankbalance, '-'),2,'.','');
			$totaltoclear = $totaltoclear * -1;
		}else{
			$totaltoclear = number_format(float_ops($bankopbalance, $bankbalance,  '-'),2,'.','');
		}*/
		//$totaltoclear = number_format($totaltoclear,2,'.','');
		//echo "<div style='float:right;' class='col-sm-2'>
			
		//</div>";	

		/* Ledger and Reconciliation Summary */
		echo "<table class=\"reconciliation-summary\">";
		echo "<tr>";
		echo "<td><b>Opening Balance</b></td><td>" . convert_amount_dc($opbalance) . "</td>";
		echo "<td width=\"20px\"></td>";
		//echo "<td><b>Reconciliation Pending</b></td><td>" . convert_amount_dc($reconciliation_pending) . "</td>";
		echo "<td><b>Reconciliation Pending</b></td><td>" . convert_amount_dc($opening) . "</td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Cleared Total</b></td><td>" . convert_amount_dc($cleared_total) . "<input type='hidden' name='clearedtotal' value='".$cleared_total."' id='clearedtotal'></td>";
		echo "<td width=\"20px\"></td>";
		echo "<td></td><td><span id='complete'><button id='reconsile_butn' class='btn btn-primary' title='Reconcile Selected Transactions!' onclick='javascript:recosiletransactions()'>Reconcile</button></span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><b>Closing Balance</b></td><td>" . convert_amount_dc($clbalance) . "</td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Reconciliation Total</b></td><td>" . convert_amount_dc($reconciliation_total) . "</td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Total to Clear</b></td><td><input type='text' value='".$totaltoclear."' name='totaltoclear' readonly='readonly' id='totaltoclear'></td>";
		echo "<td width=\"20px\"></td>";
		echo "<td></td><td>";
		//echo anchor('accounts/report/reconciliation', 'Reconcile', array('title' => 'Reconcile Selected Transactions!','class'=>'btn btn-primary'));
		echo "<a href='".base_url()."accounts/entry/add/journal' target='_blank' class='btn btn-success' title='Add New Transactions!'>Add Transactions</a>";
		echo "</td>";
		echo "</tr>";
;echo "<tr>";
		echo "<td></td><td></td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Bank Closing Balance</b></td><td><input type='text' name='bankbalance' value='".convert_account ($bankbalance)."' id='bankbalance' placeholder='Input format: 12000' onchange='javascript:updateBankbalance()'></td>";
		echo "<td width=\"20px\"></td>";
		echo "<td><b>Bank Opening Balance</b></td><td>" . convert_amount_dc($bankopbalance) . "<input type='hidden' name='bankopbalance' value='".$bankopbalance."' id='bankopbalance'></td>";
		echo "<td width=\"20px\"></td>";
		echo "<td></td><td>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "";	
		
		
	}
	
	//update cheked status when click on checkbox
	function updateCheckedval(){
		$this->reconciliation_model->updateCheck($this->input->post('entry_item_id'),$this->input->post('ledger_id'),$this->input->post('checkedval'));	
	}
	
	//update bankbalance for selected ledger account
	function updateBankbalance(){
		echo $this->reconciliation_model->updateBankbalance($this->input->post('ledger_id'),$this->input->post('bankbalance'));	
	}
	
	//this function will shorten strings, only break from a word after given length
	function substrwords($text, $maxchar, $end='...') {
		if (strlen($text) > $maxchar || $text == '') {
			$words = preg_split('/\s/', $text);      
			$output = '';
			$i      = 0;
			while (1) {
				$length = strlen($output)+strlen($words[$i]);
				if ($length > $maxchar) {
					break;
				} 
				else {
					$output .= " " . $words[$i];
					++$i;
				}
			}
			$output .= $end;
		} 
		else {
			$output = $text;
		}
		return $output;
	}
}

/* End of file reconciliation.php */