<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Ticket No:2385
class Landpayment_agreement extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('land_payment_model');
	}
	public function index()
	{	
		$data=NULL;
		if ( ! check_access('view_landagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$data = array();
		$data['alllands'] = $this->land_payment_model->getlanddetails();
		$data['allagreements'] = $this->land_payment_model->getagreementdetails();
		$this->load->view('re/land/landpayment_agreement',$data);
	}

	public function getspecificland()
	{	
		$str = $this->input->post('land_code');
		$strArray = explode("-",$str);
		$land_code = $strArray[0];
		//check already existing agreements
		if($this->land_payment_model->check($land_code))
		{
			echo'This land agreement is already created-2';
		}
		else
		{
			$property_name = $strArray[1];
			$data = array();
			$data = $this->land_payment_model->getspecificland($land_code);
			$landvalue = 0.0;
			  foreach($data as $row)
			  {	
			  	if($row['tot_payments'] == "")
			  	{
			  	  $available_amount = intval($row['new_budget']);
			  	}
			  	else
			  	{
			  	  $available_amount = intval($row['new_budget'])-intval($row['tot_payments']);
			  	}

			  	if($available_amount == 0) //check available amout is 0 or no
			  	{	

			  		echo'Your available budget is execeeded';
			  	}
			  	else
			  	{
				  	echo $land_code.'-';
				  	echo $property_name.'-';
				  	echo $row['new_budget'].'-';
				  	echo $available_amount;
			  	}
			  	
			  }
			
		}
		
	}

	public function addpaymentplan()
	{	
		$data=NULL;
		if ( ! check_access('add_agreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$formArray = array();
		$formArray['land_id'] = $this->input->post('temp_landcode');
		$formArray['agreement_date'] = $this->input->post('agreementdate');
		$formArray['agreement_no'] = $this->input->post('agreementno');
		$formArray['created_by'] =  $this->session->userdata('username');
		$formArray['created_at'] =  date("F j, Y, g:i a");
		$formArray['status'] =  'PENDING';
		$agreement_id = $this->land_payment_model->addagreement($formArray);


		$installement = $this->input->post('installement');
		$date = $this->input->post('date');
		$installement_date = array_combine($date, $installement);
		foreach($installement_date as $due_date=>$installement_amount)
		{
			$formArray2['installment_amount'] = $installement_amount;
			$formArray2['due_date'] = $due_date;
			$formArray2['agreement_id'] = $agreement_id;
			$this->land_payment_model->addinstallements($formArray2);
			// echo $installement_amount;
			// echo $due_date;

		}
		$this->session->set_flashdata('msg','Agreement created successfully');
		redirect('re/landpayment_agreement');
		
	}

	public function confirm($agreement_id)
	{	
		$data=NULL;
		if ( ! check_access('confirm_agreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$formArray = array();
		$formArray['status'] = 'CONFIRMED';
		$formArray['confirmed_by'] = $this->session->userdata('username');
		$formArray['confirmed_at'] = date("F j, Y, g:i a");
		$this->land_payment_model->confirm($agreement_id,$formArray);
		redirect('re/landpayment_agreement');
	}

	public function delete($agreement_id)
	{	
		$data=NULL;
		if ( ! check_access('delete_agreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$this->land_payment_model->delete($agreement_id);
		redirect('re/landpayment_agreement');
	}

	public function view($agreement_id){

		$data=NULL;
		if ( ! check_access('view_schedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		
		$land_id = $this->land_payment_model->getlandcode($agreement_id);
		$landprice = $this->land_payment_model->getspecificland($land_id['land_id']);
		$totval = 0;
		foreach($landprice as $row)
		{
			if($row['tot_payments'] == "")
		  	{
		  	  $data['totval'] = intval($row['new_budget']);
		  	}
		  	else
		  	{
		  	  $data['totval'] = intval($row['new_budget'])-intval($row['tot_payments']);
		  	}
		}
		$data['installementdetails'] = $this->land_payment_model->installementview($agreement_id);
		$this->load->view('re/land/installementview',$data);
	}

	public function edit($agreement_id){

		$data=NULL;
		if ( ! check_access('edit_schedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		
		$land_id = $this->land_payment_model->getlandcode($agreement_id);
		$landprice = $this->land_payment_model->getspecificland($land_id['land_id']);
		$totval = 0;
		foreach($landprice as $row)
		{	
			if($row['tot_payments'] == "")
		  	{
		  	  $data['totval'] = intval($row['new_budget']);
		  	}
		  	else
		  	{
		  	  $data['totval'] = intval($row['new_budget'])-intval($row['tot_payments']);
		  	}
		}
		$data['installementdetails'] = $this->land_payment_model->installementview($agreement_id);
		$data['agreement_id'] = $agreement_id;
		$this->load->view('re/land/installementedit',$data);
	}

	public function update(){
			
			$installement_amount = $this->input->post('installment');
			$due_date = $this->input->post('date');
			$installement_amount_new = $this->input->post('installment_new');
			$due_date_new = $this->input->post('date_new');
			$agreement_id = $this->input->post('agreement_id');
			$installment_id = $this->input->post('installment_id');

			// foreach ($formArray['installement_amount'] as $installment) {
			// 	echo $installment.'<br>';
			// }

			if($installement_amount != '')
			{
				$installment_date_new = array_combine($due_date_new, $installement_amount_new);
				foreach ($installment_date_new as $date=>$installment)
				{
					$formArray2['installment_amount'] = $installment;
					$formArray2['due_date'] = $date;
					$formArray2['agreement_id'] = $agreement_id;
					$this->land_payment_model->addinstallements($formArray2);					
				}
			}

			//$installment_date = array_combine($due_date, $installement_amount);
			$count = 0;
			$formArray = array();
			foreach($installment_id as $id)
			{	
				$formArray['installment_amount'] = $installement_amount[$count];
				$formArray['due_date'] = $due_date[$count];

				$this->land_payment_model->update($formArray,$id);
				$count += 1;
				// echo $installment.'<br>';
			}

			
			//echo $agreement_id;
			$this->session->set_flashdata('msg','Updated successfully');
			redirect('re/landpayment_agreement');
	}

	public function search()
	{
		$data = array();
		$formArray['land_id'] = $this->input->post('search_landid');
		$formArray['agreement_no'] = $this->input->post('search_agno');
		$formArray['agreement_date'] = $this->input->post('search_agdate');

		
		$data['allagreements'] = $this->land_payment_model->search($formArray);
		$data['alllands'] = $this->land_payment_model->getlanddetails();
		$this->load->view('re/land/landpayment_agreement',$data);
		// foreach($data as $row)
		// {
		// 	echo $row['land_id'];
		// }
		
	}
	
	public function dueNotification()
	{	
		$formArray = array();
		$formArray['table_name'] = 're_landinstallmentplan';
		$formArray['notification'] = 'Project Payments';
		$today = date_create(date('Y-m-d'));
		$installments = $this->land_payment_model->getallinstallments();
		foreach ($installments as $row) {
			$duedate = date_create($row['due_date']);
			$interval = date_diff($duedate,$today);
			// echo intval($interval->format('%a'));
			// exit;
			if(intval($interval->format('%a')) == 7)
			{
				$land = $this->land_payment_model->getspecificagreement($row['agreement_id']);
				$branch = $this->land_payment_model->getbranchcode($land['land_id']);
				$formArray['branch_code'] = $branch['branch_code'];
				$formArray['record_key'] = $row['installment_id'];
				$formArray['create_date'] = date("Y-n-j");
				$formArray['module'] = "re/landpayment_agreement";
				$this->land_payment_model->insertnotification($formArray);
				//echo $branch['branch_code'].'<br>';
			}
			//echo $row['due_date'].'-'.$interval->format('%a').'<br>';
			//echo $row['due_date'].'<br>';
		}
		
		//$this->land_payment_model->
	}

}

?>