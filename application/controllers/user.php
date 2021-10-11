<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	 function __construct() {
        parent::__construct();
		$this->load->model("summery_model");
		$this->load->model("customer_model");
		$this->load->model("redashboard_model");
		$this->load->model("projectpayment_model");
		$this->load->model("report_model");
			$this->load->model("message_model");
	    $this->load->model("user/user_model");

		//$this->is_logged_in();

    }
	public function index()
	{
		
		if ( ! check_access('md_dashboard'))
		{

			redirect('menu_call/showdata/'.$this->session->userdata('usermodule'));
			
		}
		redirect('dashboard/managing_director');

		

	}

	public function meter_reading(){
		date_default_timezone_set('Asia/Colombo');
		$userid = $this->session->userdata('userid');
		$employee_details = $this->user_model->get_employee_details($userid);
		$data['employee_details'] = $employee_details;

		$user_meter_reading_last_record = $this->user_model->get_user_meter_reading_last_record($userid);
		$data['user_meter_reading_last_record'] = $user_meter_reading_last_record;

		if($employee_details['fuel_allowance_status'] == 'N'){
			redirect(base_url()."user");
		}

		if(!empty($user_meter_reading_last_record) && $user_meter_reading_last_record['date'] == date('Y-m-d')){
			redirect(base_url()."user");
		}

		$vehicle_type = $employee_details['vehicle_type'];
		$fuel_allowance_rate = $this->user_model->get_fuel_allowance_rate($vehicle_type);
		$data['fuel_allowance_rate'] = $fuel_allowance_rate;

		$fuel_allowance_additional = $this->user_model->get_fuel_allowance_additional($userid);
		$fuel_allowance_additional_total = 0;
		foreach($fuel_allowance_additional as $fuel_allowance_additional_row){
			$fuel_allowance_additional_total = $fuel_allowance_additional_total + $fuel_allowance_additional_row->approved_amount;
		}
		$data['fuel_allowance_additional_total'] = $fuel_allowance_additional_total;

		$user_meter_reading_for_month = $this->user_model->get_user_meter_reading_for_month($userid);
		$amount_count_per_month = 0;
		$exceeded_amount = 0;
		foreach($user_meter_reading_for_month as $meter_reading_for_month_row){
			if($meter_reading_for_month_row->exceed_status == 'Y'){
				$exceeded_amount = $meter_reading_for_month_row->exceeded_amount;
			}
			$amount_count_per_month = $amount_count_per_month + $meter_reading_for_month_row->amount;
		}
		$amount_count_per_month = $amount_count_per_month - $exceeded_amount;
		$data['amount_count_per_month'] = $amount_count_per_month;
		$data['exceeded_amount_per_month'] = $exceeded_amount;

		$data['main_content'] = '';
		$data["msgu"]="";
		$this->load->view('user/meter_reading_view', $data);
	}

	public function request_additional_fuel_allowance(){
		$emp_id = (int)$this->uri->segment(3);
		$data['emp_id'] = $emp_id;
		$this->load->view('user/request_additional_fuel_allowance_view', $data);
	}

  	public function submit_additional_fuel_request(){
		$this->user_model->submit_additional_fuel_request();
		$this->session->set_flashdata('msg',"Request submitted successfully");
		redirect('user/meter_reading');
	}

  	public function meter_reading_submit(){
		$this->user_model->meter_reading_submit();
		redirect('user');
	}

	public function mychart()
	{
		$counter=0;

				$outflolist=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));

				if($outflolist){
					foreach($outflolist as $row)
					{
					  if($row->new_budget>0 & $row->task_name!='Purchase Price'){
					//	  echo $row->task_name.'-'. $row->new_budget,'**';
					  $lebal[$counter]=substr( $row->task_name,0,4);
					  $estimate[$counter]=$row->estimate_budget;
					  $actual[$counter]= $row->tot_payments;
					    $budget[$counter]= $row->new_budget;
					  if($row->estimate_budget> $row->tot_payments)
					  $color[$counter]= 'rgb(126, 213, 84)';
					  else if($row->estimate_budget== $row->tot_payments)
						  $color[$counter]= 'rgb(255, 159, 64)';
					  else
					  $color[$counter]= 'rgb(255, 46, 65)';
					  $counter++;
				  	}

				  }

				$data['js_label']=json_encode($lebal);
				$data['js_estimate']=json_encode($estimate);
				$data['js_actual']=json_encode($actual);
				$data['js_colors']=json_encode($color);
				$data['js_budget']=json_encode($budget);
			}
			$this->load->view('re/mychart',$data);
	}
	public function form()
	{
		/*$data['newordercount']=$this->order_model->new_order_count();
		$data['todayordercount']=$this->order_model->today_order_count();
		$data['totalorder']=$this->order_model->total_orders_count();
		$data['totalinvoice']=$this->order_model->new_invoice_count();
		$data['newcustomer']=$this->order_model->new_customer_count();
		$data['allcustomer']=$this->order_model->all_customer_count();*/
		$data=NULL;
		if ( ! check_access('forms'))
		{

			redirect('home');
			return;
		}

		$this->load->view('forms',$data);

	}
		public function tables()
	{
		/*$data['newordercount']=$this->order_model->new_order_count();
		$data['todayordercount']=$this->order_model->today_order_count();
		$data['totalorder']=$this->order_model->total_orders_count();
		$data['totalinvoice']=$this->order_model->new_invoice_count();
		$data['newcustomer']=$this->order_model->new_customer_count();
		$data['allcustomer']=$this->order_model->all_customer_count();*/
		$data=NULL;

		$this->load->view('tables',$data);

	}

	function is_logged_in() {

        $is_logged_in = $this->session->userdata('login_name');
        if ((!isset($is_logged_in) || $is_logged_in == "")) {
            redirect('login/index');
        }
		else
		{
			$this->session->set_flashdata('return_url', current_url());
		}
    }

	function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

	function customerByID($id){
		$customer = $this->customer_model->customerByID($id);

	}

	function get_fuel_allowance_rate_updates()
	{
		$id=$this->input->post('vehicle_type');
    $date=$this->input->post('date');
		$user_meter_reading_todate = $this->user_model->get_fuel_allowance_rate_updates($id,$date);
		if($user_meter_reading_todate){
      echo json_encode($user_meter_reading_todate);
    }else{
      echo json_encode("empty_data");
    }
	}
	
	function test(){
		echo check_access('view_branch');
		echo 'TEsgtS';
	}
}
