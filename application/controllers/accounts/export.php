<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class export extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
        parent::__construct();
		
		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("export_model");
		$this->load->model("project_model");
		$this->load->model("projectpayment_model");
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		
		redirect('accounts/invoice/showall');
		
		
		
	}

	
	function reports()
	{
		$data=NULL;
		
		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
		$data['datalist']=$inventory=NULL;
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
				
				$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/invoice/invoice_main';
				
				
				$data['tag']='Search Document Types';
		
		$this->load->view('accounts/export/export_main',$data);
	}
	function report_data()
	{
		$data=NULL;
		
			$fromdate=$this->input->post('fromdate');
			$todate=$this->input->post('todate');
			$type=$this->input->post('type');
			if($type=='01')
			$this->report_data_01($fromdate,$todate);
			if($type=='02')
			$this->report_data_02($fromdate,$todate);
			if($type=='03')
			$this->report_data_03($fromdate,$todate);
			if($type=='04')
			$this->report_data_04($fromdate,$todate);
		
		
	}
	function report_data_all($fromdate,$todate)
	{
			$category="";
			$reciept_nu="";
			$customer_name='';
			$credit_gl="";
			$date="";
			$amount="";
			$project_Lot="";
			$debit_gl="";
			$payment_method="";
			$project="";
			$payeename="";
			$cheque_no="";
			$credit_memo="";
			$debit_memo="";
			$supplierr_name="";
			$entry_number="";
			$naration="";
			//			Credit Memo					GL Name	 & Lot No.

			$allentires=$this->export_model->get_entires($fromdate,$todate);
			$b='';
			
			$b=$b. '<table border="1"><tr>
				<td>Catogary</td>
			<td>Receipt No</td>
			<td>Customer Name</td>
			<td>Credit GL Name</td>
			<td>Date</td>
			<td>Amount</td>
			<td>Project & Lot No</td>
			<td>Debit GL Name</td>
			<td>Payment Method</td>
				<td>Project</td>
			<td>Payee Name</td>
			<td>Cheque Number</td>
			<td>Credit Amount</td>
			<td>Credit Memo</td>
			<td>Debit Amount</td>
			<td>Debit Memo</td>
			<td>Customer/ Supplier Name</td>
			<td>Entry Number</td>
			<td>Narration</td>
			</tr>';
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->entry_type==1)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R'; $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M';  $b=$b. '<tr bgcolor="#ff96ff">';}
									
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									$b=$b. '
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
									
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->entry_type==2)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									$b=$b. '<tr bgcolor="#ffd37c">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							else 
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
							 		}
									
							 $type='J';
						 		}
								if($credit_gl!='Audit Dummy Account'){
								$b=$b. '<tr bgcolor="#b1ff9d">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw->cr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw->dr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
								}
							
						 	}
							
					 }
					
					 
				}
			}
			echo '<tr bgcolor="#0033CC">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>';
			// Payment Entires
			$allentires=$this->export_model->get_Payment_entires($fromdate,$todate);
			
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot='';//$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu='';
					 $customer_name=$raw->payeename;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->paymenttype;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 
							//payment entryes
							if($raw->entry_type==2)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='P';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									$b=$b. '<tr bgcolor="#ffd37c">
									<td>'.$type.'</td>
										<td>'.$reciept_nu.'</td>
									<td>'.$customer_name.'</td>
								<td>'.$credit_gl.'</td>
								<td>'.$raw->date.'</td>
								<td>'.$raw2->amount.'</td>
								<td>'.$project_Lot.'</td>
								<td>'.$debit_gl.'</td>
								<td>'.$payment_method.'</td>
									<td>'.$project.'</td>
								<td>'.$supplierr_name.'</td>
								<td>'.$cheque_no.'</td>
								<td>'.$raw2->amount.'</td>
								<td>'.$raw->narration.'</td>
								<td>'.$raw2->amount.'</td>
								<td>'.$raw->narration.'</td>
								<td>'.$supplierr_name.'</td>
								<td>'.$raw->number.'</td>
								<td>'.$raw->narration.'</td>
									</tr>';
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							
							
					 }
					
					 
				}
			}
			echo '<tr bgcolor="#0033CC">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
										<td></td>
										<td></td>

									</tr>';
			$allentires=$this->export_model->get_entires_cancel($fromdate,$todate);
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->RCTNO)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R'; $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M';  $b=$b.'<tr bgcolor="#ff96ff">';}
									
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									//echo '<tr>';
				$b=$b. '<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->CHQNO)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									 $type='C';
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									$b=$b.'<tr  bgcolor="#a6b0d9">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							else 
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
							 		}
									
							 $type='J';
						 		}
								if($credit_gl!='Audit Dummy Account'){
								$b=$b. '<tr bgcolor="#b1ff9d">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw->cr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw->dr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
								}
							
						 	}
							
					 }
					
					 
				}
			}
			header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Data_migration.xls");
	echo $b;
	}
	function report_data_01($fromdate,$todate)
	{
			$category="";
			$reciept_nu="";
			$customer_name='';
			$credit_gl="";
			$date="";
			$amount="";
			$project_Lot="";
			$debit_gl="";
			$payment_method="";
			$project="";
			$payeename="";
			$cheque_no="";
			$credit_memo="";
			$debit_memo="";
			$supplierr_name="";
			$entry_number="";
			$naration="";
			//			Credit Memo					GL Name	 & Lot No.

			$allentires=$this->export_model->get_entires($fromdate,$todate);
			$b='';
			
			$b=$b. '<table border="1"><tr>
				<td>Catogary</td>
			<td>Receipt No</td>
			<td>Customer Name</td>
			<td>Credit GL Name</td>
			<td>Date</td>
			<td>Amount</td>
			<td>Project & Lot No</td>
			<td>Debit GL Name</td>
			<td>Payment Method</td>
				<td>Project</td>
			<td>Payee Name</td>
			<td>Cheque Number</td>
			<td>Credit Amount</td>
			<td>Credit Memo</td>
			<td>Debit Amount</td>
			<td>Debit Memo</td>
			<td>Customer/ Supplier Name</td>
			<td>Entry Number</td>
			<td>Narration</td>
			</tr>';
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->entry_type==1)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R'; $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M';  //$b=$b. '<tr bgcolor="#ff96ff">';
									}
									
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									if($type=='R'){
									$b=$b. '
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';}
									
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->entry_type==2)
							 {
							 
						 	}
							//Jurnal entryes
							else 
							 {
							 
								
							
						 	 }
							
					 }
					
					 
				}
			}
			echo '<tr bgcolor="#0033CC">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>';
			// Payment Entires
			
			$allentires=$this->export_model->get_entires_cancel($fromdate,$todate);
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->RCTNO)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R'; $b=$b. '<tr bgcolor="#ff96ff">';
									}
									else {$type='M'; // $b=$b.'<tr bgcolor="#ff96ff">';
									}
									
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									//echo '<tr>';
									if($type=='R'){
				$b=$b. '<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';}
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->CHQNO)
							 {
							 
							
						 	}
							//Jurnal entryes
							else 
							 {
							 
							
						 	}
							
					 }
					
					 
				}
			}
			header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Data_migration.xls");
	echo $b;
	}
		function report_data_02($fromdate,$todate)
	{
			$category="";
			$reciept_nu="";
			$customer_name='';
			$credit_gl="";
			$date="";
			$amount="";
			$project_Lot="";
			$debit_gl="";
			$payment_method="";
			$project="";
			$payeename="";
			$cheque_no="";
			$credit_memo="";
			$debit_memo="";
			$supplierr_name="";
			$entry_number="";
			$naration="";
			//			Credit Memo					GL Name	 & Lot No.

			$allentires=$this->export_model->get_entires($fromdate,$todate);
			$b='';
			
			$b=$b. '<table border="1"><tr>
				<td>Catogary</td>
			<td>Receipt No</td>
			<td>Customer Name</td>
			<td>Credit GL Name</td>
			<td>Date</td>
			<td>Amount</td>
			<td>Project & Lot No</td>
			<td>Debit GL Name</td>
			<td>Payment Method</td>
				<td>Project</td>
			<td>Payee Name</td>
			<td>Cheque Number</td>
			<td>Credit Amount</td>
			<td>Credit Memo</td>
			<td>Debit Amount</td>
			<td>Debit Memo</td>
			<td>Customer/ Supplier Name</td>
			<td>Entry Number</td>
			<td>Narration</td>
			</tr>';
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->entry_type==1)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R';// $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M';  $b=$b. '<tr bgcolor="#ff96ff">';
									}
									
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									if($type=='M'){
									$b=$b. '
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';}
									
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->entry_type==2)
							 {
							 
						 	}
							//Jurnal entryes
							else 
							 {
							 
								
							
						 	 }
							
					 }
					
					 
				}
			}
			echo '<tr bgcolor="#0033CC">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>';
			// Payment Entires
			
			$allentires=$this->export_model->get_entires_cancel($fromdate,$todate);
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->RCTNO)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R';// $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M';  $b=$b.'<tr bgcolor="#ff96ff">';
									}
									
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									//echo '<tr>';
									if($type=='M'){
				$b=$b. '<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';}
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->CHQNO)
							 {
							 
							
						 	}
							//Jurnal entryes
							else 
							 {
							 
							
						 	}
							
					 }
					
					 
				}
			}
			header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Data_migration.xls");
	echo $b;
	}
	function report_data_03($fromdate,$todate)
	{
			$category="";
			$reciept_nu="";
			$customer_name='';
			$credit_gl="";
			$date="";
			$amount="";
			$project_Lot="";
			$debit_gl="";
			$payment_method="";
			$project="";
			$payeename="";
			$cheque_no="";
			$credit_memo="";
			$debit_memo="";
			$supplierr_name="";
			$entry_number="";
			$naration="";
			//			Credit Memo					GL Name	 & Lot No.

			$allentires=$this->export_model->get_entires($fromdate,$todate);
			$b='';
			
			$b=$b. '<table border="1"><tr>
				<td>Catogary</td>
			<td>Receipt No</td>
			<td>Customer Name</td>
			<td>Credit GL Name</td>
			<td>Date</td>
			<td>Amount</td>
			<td>Project & Lot No</td>
			<td>Debit GL Name</td>
			<td>Payment Method</td>
				<td>Project</td>
			<td>Payee Name</td>
			<td>Cheque Number</td>
			<td>Credit Amount</td>
			<td>Credit Memo</td>
			<td>Debit Amount</td>
			<td>Debit Memo</td>
			<td>Customer/ Supplier Name</td>
			<td>Entry Number</td>
			<td>Narration</td>
			</tr>';
		
			$allentires=$this->export_model->get_Payment_entires($fromdate,$todate);
			
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot='';//$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu='';
					 $customer_name=$raw->payeename;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->paymenttype;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 
							//payment entryes
							if($raw->entry_type==2)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='P';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									$b=$b. '<tr bgcolor="#ffd37c">
									<td>'.$type.'</td>
										<td>'.$reciept_nu.'</td>
									<td>'.$customer_name.'</td>
								<td>'.$credit_gl.'</td>
								<td>'.$raw->date.'</td>
								<td>'.$raw2->amount.'</td>
								<td>'.$project_Lot.'</td>
								<td>'.$debit_gl.'</td>
								<td>'.$payment_method.'</td>
									<td>'.$project.'</td>
								<td>'.$supplierr_name.'</td>
								<td>'.$cheque_no.'</td>
								<td>'.$raw2->amount.'</td>
								<td>'.$raw->narration.'</td>
								<td>'.$raw2->amount.'</td>
								<td>'.$raw->narration.'</td>
								<td>'.$supplierr_name.'</td>
								<td>'.$raw->number.'</td>
								<td>'.$raw->narration.'</td>
									</tr>';
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							
							
					 }
					
					 
				}
			}
			echo '<tr bgcolor="#0033CC">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
										<td></td>
										<td></td>

									</tr>';
			$allentires=$this->export_model->get_entires_cancel($fromdate,$todate);
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->RCTNO)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R'; ;
									}
									else {$type='M'; }
									
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->CHQNO)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									 $type='C';
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									$b=$b.'<tr  bgcolor="#a6b0d9">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							else 
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
							 		}
									
							 $type='J';
						 		}
								if($credit_gl!='Audit Dummy Account'){
								
								}
							
						 	}
							
					 }
					
					 
				}
			}
			header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Data_migration.xls");
	echo $b;
	}
	function report_data_04($fromdate,$todate)
	{
			
			$category="";
			$reciept_nu="";
			$customer_name='';
			$credit_gl="";
			$date="";
			$amount="";
			$project_Lot="";
			$debit_gl="";
			$payment_method="";
			$project="";
			$payeename="";
			$cheque_no="";
			$credit_memo="";
			$debit_memo="";
			$supplierr_name="";
			$entry_number="";
			$naration="";
			//			Credit Memo					GL Name	 & Lot No.

			$allentires=$this->export_model->get_entires($fromdate,$todate);
			$b='';
			
			$b=$b. '<table border="1"><tr>
				<td>Catogary</td>
			<td>Receipt No</td>
			<td>Customer Name</td>
			<td>Credit GL Name</td>
			<td>Date</td>
			<td>Amount</td>
			<td>Project & Lot No</td>
			<td>Debit GL Name</td>
			<td>Payment Method</td>
				<td>Project</td>
			<td>Payee Name</td>
			<td>Cheque Number</td>
			<td>Credit Amount</td>
			<td>Credit Memo</td>
			<td>Debit Amount</td>
			<td>Debit Memo</td>
			<td>Customer/ Supplier Name</td>
			<td>Entry Number</td>
			<td>Narration</td>
			</tr>';
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->entry_type==1)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R';// $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M'; // $b=$b. '<tr bgcolor="#ff96ff">';
									}
									
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->entry_type==2)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
					
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							else 
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
							 		}
									
							 $type='J';
						 		}
								if($credit_gl!='Audit Dummy Account'){
								$b=$b. '<tr bgcolor="#b1ff9d">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw->cr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw->dr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
								}
							
						 	}
							
					 }
					
					 
				}
			}
			echo '<tr bgcolor="#0033CC">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
									<td></td>
									<td></td>
									<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>';
			// Payment Entires
			$allentires=$this->export_model->get_Payment_entires($fromdate,$todate);
			
		
			
			$allentires=$this->export_model->get_entires_cancel($fromdate,$todate);
			if($allentires)
			{
				foreach($allentires as $raw)
				{ 	$entry_type=$raw->entry_type;
					 $date=$raw->date;
					 $project_Lot=$raw->project_name.'-'.$raw->lot_number;
					 $reciept_nu=$raw->RCTNO;
					 $customer_name=$raw->rcvname;
					 $supplierr_name=$raw->CHQNAME;
					  $cheque_no=$raw->CHQNO;
					 $project=$raw->project_name;
					 $payment_method=$raw->rcvmode;
					 $entryset=$this->export_model->get_entires_items($raw->id);
					 if($entryset)
					 {
						 if($raw->RCTNO)
						 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									if($raw2->ledger_id=='HEDBA16010000' || $raw2->ledger_id=='HEDBA16020000')
									{
									$type='R';// $b=$b. '<tr bgcolor="#9ef0e5">';
									}
									else {$type='M'; // $b=$b.'<tr bgcolor="#ff96ff">';
									}
									
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									//echo '<tr>';
				
									
							 		}
							 
						 		}
							
						 	}
							//payment entryes
							else if($raw->CHQNO)
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='D')
							 		{
									 $debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='C')
							 		{
									 $type='C';
								 	$credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
				
									
							 		}
							 
						 		}
							
						 	}
							//Jurnal entryes
							else 
							 {
							 $debit_count=0;
							  $credit_count=0;
							 foreach ($entryset as $raw2){
							 
								 if($raw2->dc=='C')
							 		{
									 $credit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
									 $debit_count++;
									 }
							
									 if($raw2->dc=='D')
							 		{
									 $type='C';
								 	$debit_gl=$this->export_model->get_all_ac_ledgersfull_name($raw2->ledger_id);
								  	$credit_count++;;
									//amount$type='M';
									
									
							 		}
									
							 $type='J';
						 		}
								if($credit_gl!='Audit Dummy Account'){
								$b=$b. '<tr bgcolor="#b1ff9d">
				<td>'.$type.'</td>
			<td>'.$reciept_nu.'</td>
			<td>'.$customer_name.'</td>
			<td>'.$credit_gl.'</td>
			<td>'.$raw->date.'</td>
			<td>'.$raw2->amount.'</td>
			<td>'.$project_Lot.'</td>
			<td>'.$debit_gl.'</td>
			<td>'.$payment_method.'</td>
				<td>'.$project.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$cheque_no.'</td>
			<td>'.$raw->cr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$raw->dr_total.'</td>
			<td>'.$raw->narration.'</td>
			<td>'.$supplierr_name.'</td>
			<td>'.$raw->number.'</td>
			<td>'.$raw->narration.'</td>
			</tr>';
								}
							
						 	}
							
					 }
					
					 
				}
			}
			header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Data_migration.xls");
	echo $b;
	}
	function get_group_name()
	{
		$debit_gl=$this->export_model->get_all_groups();
		foreach($debit_gl as $raw)
		{
			$name=$this->export_model->get_full_group_name_all($raw->id);
			echo $name.'<br>';
		}
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */