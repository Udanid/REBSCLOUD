<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {

	/**
	 * Index Page for this controller.intorducer
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

		$this->load->model("reservation_model");
		$this->load->model("common_model");
		$this->load->model("project_model");
		$this->load->model("salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
		$this->load->model("dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("eploan_model");
		$this->load->model("accountinterface_model");
		$this->load->model("deedtransfer_model");
		$this->load->model("report_model");
		$this->load->model("sales_model");
		$this->load->model("reservationdiscount_model");
		$this->load->model("financialtransfer_model");
		$this->load->model("dicalculate_model");
		$this->load->model("hr/employee_model");


		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('re/reservation/newreservation');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('add_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}

		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->reservation_model->get_all__not_complete_reservation_summery($this->session->userdata('branchid'));

				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/showall';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);

				$this->load->view('re/reservation/reservation_list',$data);


	}
	function payments()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}

		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->reservation_model->get_all__not_complete_reservation_summery($this->session->userdata('branchid'));

				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/showall';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);

				$this->load->view('re/reservation/payments',$data);

	}
	public function newreservation()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/');
			return;
		}

			//	$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/reservation/search';
				$data['tag']='Search reservation';
				if($this->uri->segment(4))
				$data['cus_code']=$this->uri->segment(4);
				else $data['cus_code']="";
				 if($this->session->userdata('usertype')=='Sales_officer')
				 {
					 $data['prjlist']=$this->salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					//$data['prjlist']=$this->salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
					$data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();

				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				 	$data['searchlist']='';
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
				$data['tab']='';
					if ( !$page_count)
					$page_count = 0;
					if($page_count)
						$data['tab']='list';


				$data['datalist']=$this->reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/newreservation';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);

				$this->load->view('re/reservation/reservation_data',$data);



	}
	function get_blocklist()
	{
		$data['lotlist']=$this->lotdata_model->get_project_pending_lots_byprjid($this->uri->segment(4));
		$this->load->view('re/reservation/blocklist',$data);

	}

	//Ticket No:3331 Added By Madushan 2021-08-24
	function get_blocklist_search()
	{
		$data['lotlist']=$this->lotdata_model->get_project_reserved_lots_byprjid($this->uri->segment(4));
		$this->load->view('re/reservation/blocklist_search',$data);

	}

	//Ticket No:3331 Added By Madushan 2021-08-24
	function seach_reservation()
	{	
		$prj_id = $this->uri->segment(4);
		$lot = $this->uri->segment(5);
		$cus_nic = $this->uri->segment(6);
		
		$data['datalist']=$this->reservation_model->search_all_reservation_details_withpending($prj_id,$lot,$cus_nic,$this->session->userdata('branchid'));

		$this->load->view('re/reservation/res_data_search',$data);
		

	}

	function get_fulldata()
	{
		$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['loan_officer']=$this->sales_model->get_sales_officerlist($this->uri->segment(6));
		$data['saletype']=$this->reservation_model->get_purchase_type();
		$data['mindp']=30;//$this->reservation_model->get_mindp_level();
		 $data['dplevel']=$this->dplevels_model->get_dplevels();
		 $data['banklist']=$this->common_model->getbanklist();

		$this->load->view('re/reservation/full_details',$data);
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/');
			return;
		}
		$data['bankdata']=$this->reservation_model->get_reservation_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$data['details']=$this->reservation_model->get_resevationdata($this->uri->segment(4));
		$this->load->view('re/reservation/search',$data);

	}


	public function add()
	{
		if ( ! check_access('add_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}
		$id=$this->reservation_model->add();

		$this->common_model->add_notification('re_resevation','reservations','re/reservation',$id);
		$this->session->set_flashdata('msg', 'Land reservation Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		//redirect("re/reservation/add_data/".$id);
		redirect('re/reservation/newreservation');

	}
	public function add_data()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/');
			return;
		}
		$res_code=$this->uri->segment(4);

			//	$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/reservation/search';
				$data['tag']='Search reservation';



				 if($this->session->userdata('usertype')=='Sales_officer')
				 {
					 $data['prjlist']=$this->salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					$data['prjlist']=$this->salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();

				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				 $data['resdata']=$resdata=$this->reservation_model->get_resevationdata($res_code);
				 $data['saledata']=$this->reservation_model->get_advance_data($res_code);
				 $data['loandata']=$this->reservation_model->get_eploan_data($res_code);
				 $data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($resdata->lot_id);
				$data['projectdata']=$this->reservation_model->get_project_bycode($resdata->prj_id);
				$data['loan_officer']=$this->sales_model->get_sales_officerlist($resdata->branch_code);
				$data['lotlist']=$this->lotdata_model->get_project_pending_onhold_lots_byprjid($resdata->prj_id);
				$data['saletype']=$this->reservation_model->get_purchase_type();
				$data['mindp']=$this->reservation_model->get_mindp_level();
				$data['dplevel']=$this->dplevels_model->get_dplevels();
		 		$data['banklist']=$this->common_model->getbanklist();
		 		/*Ticket No:2889 Added By Madushan 2021.06.14*/
		 		$data['advance_schedule']=$this->reservation_model->get_advance_shedule($res_code);
				$this->load->view('re/reservation/reservation_addata',$data);



	}
	function get_settlments()
	{
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->reservation_model->get_purchase_type();
				$data['loan_officer']=$this->salesmen_model->get_project_officerlist($resdata->prj_id);
				$data['banklist']=$this->common_model->getbanklist();//ticket 2985
				//Ticket No:3067 Added By Madushan 2021-07-12
				$data['emp_list']=$this->employee_model->get_employee_list();
				$this->load->view('re/reservation/settlement_data',$data);
	}
	function add_settlement()
	{
		if ( ! check_access('add_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}

		$id=$this->reservation_model->add_settilemt();

		$paytype=trim($this->input->post('pay_type'));
		if($paytype=='Outright')
			$this->common_model->add_notification('re_settlement','Outright Land sale','re/reservation/sold',$this->input->post('res_code_set'));
		else
			$this->common_model->add_notification('re_eploan','New EP Loan','re/reservation/eploans',$this->input->post('res_code_set'));
		$this->session->set_flashdata('msg', 'Reservation Completed ');

		$this->logger->write_message("success", $this->input->post('res_code').' Reservation Completed');
		if($paytype=='Outright')
		redirect("re/reservation/sold/");
		else
		redirect("re/reservation/eploans/");
	}
	function get_advancedata()
	{			$res_code=$this->uri->segment(4);
				$pay_amount=$this->uri->segment(6);
				$data['paydate']=$pay_date=$this->uri->segment(5);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
				$paid_amount = $resdata->down_payment;
				$discounted_price = $resdata->discounted_price;
				$reservation_date = date_create($resdata->res_date);
				$payment_date = date_create($pay_date);
				$diff = date_diff($reservation_date,$payment_date);
				$days = $diff->format("%a");
				$data['system_discounts'] = $system_discounts =$this->reservationdiscount_model->get_total_discounts_system($res_code);
				$discounted_price = $discounted_price + $system_discounts;
				$data['discount'] = $this->calculate_scheme_discount($res_code,$resdata->prj_id,$days,$pay_amount,$paid_amount,$discounted_price);
				$data['discount_schemes'] = $this->get_current_discounts($resdata->prj_id,$days);
				/*Ticket No:2889 Added By Madushan 2021.06.14*/
				$data['due_amount'] = $this->reservation_model->get_advance_payments_due($res_code,Date('Y-m-d'));
				$this->load->view('re/reservation/advance_data',$data);
	}

	function get_current_discounts($prj_id,$paydays){
		if($data = $this->reservationdiscount_model->get_scheme($prj_id)){
			foreach($data as $row){
				$days = $row->days;

				for($x=0;$x <= $days; $x++){
					if($x == $paydays){
						return $this->reservationdiscount_model->get_scheme_days($prj_id,$days);
					}
				}
			}
		}else{
			return false;
		}
	}

	function remaining_discount_percentage($res_code,$paydays,$thispayment,$paid_amount){
		$system_discounts =$this->reservationdiscount_model->get_total_discounts_system($res_code);
		$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
		$discounts_percentage = ($system_discounts / ($resdata->discounted_price+$system_discounts)) * 100;
		$discount_schemes = $this->get_current_discounts($resdata->prj_id,$paydays);
		$tobe_paid = $resdata->discounted_price - $system_discounts - $paid_amount;
		if($discount_schemes){
		  foreach($discount_schemes as $row){
			  if($discounts_percentage < $row->discount){
				  $discount_remain = $row->discount - $discounts_percentage;
				  $payment = (($resdata->discounted_price+$system_discounts)/100)*$row->payrate;
				  $payment_need = $payment - $resdata->down_payment;
				  if($row->payrate == 100){
					  $current_discount = ($payment/100)*$discount_remain;
					  $payment_need = $payment_need - $current_discount;
					  $payment_need = $payment_need - $system_discounts;
				  }
				  if($thispayment >= $payment_need && $tobe_paid <= $thispayment){
					  return $row->discount - $discounts_percentage;
				  }

			  }
		  }
		}else{
			return 0;
		}
	}

	function calculate_scheme_discount($res_code,$prj_id,$paydays,$pay_amount,$paid_amount,$discounted_price){
		//get completion percentage
		$completion = 0;
		$previous_discounts = 0;
		$discount_completion = 0;
		$completion = (($pay_amount + $paid_amount) / $discounted_price) *100;
		$previous_discounts = $this->reservationdiscount_model->get_total_discounts_system($res_code);
		$remaining_discount_percentage = $this->remaining_discount_percentage($res_code,$paydays,$pay_amount,$paid_amount);
		$discount_completion = ($previous_discounts / $discounted_price) *100;
		$completion = $completion + $remaining_discount_percentage + $discount_completion;

		if($pay_amount){
			if($data = $this->reservationdiscount_model->get_scheme($prj_id)){

				foreach($data as $row){
					$days = $row->days;

					for($x=0;$x <= $days; $x++){
						if($x == $paydays){
							//check rate when matching the days
							$data2 = $this->reservationdiscount_model->get_scheme_days($prj_id,$days);

							foreach ($data2 as $row){

								$rate = $row->payrate;
								if($completion > 60 ){
									$completion = $completion + $row->discount;
								}
								if($completion >= $rate){


									$discount = ($discounted_price/100)*$row->discount;
									$discount = $discount - $previous_discounts;
									if($discount > 0){
										return $discount;
									}else{
										return 0;
									}
									//return $remaining_discount_percentage;
								}
							}
						}
					}
				}

			}else{
				return '0.00';
			}
		}else{
			return '0.00';
		}
	}

	function add_advance()
	{
		if ( ! check_access('add_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}

		$id=$this->reservation_model->add_advance();


		$this->session->set_flashdata('msg', 'Advance payment successfully Inserted ');

		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		redirect("re/reservation/payments/");
	}
	function delete_advance()
	{
		if ( ! check_access('delete_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}
		$id=$this->reservation_model->delete_advance($this->uri->segment(4));
				$this->session->set_flashdata('msg', 'advance payment Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance payment  successfully Deleted');
		redirect("re/reservation/payments");
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}
		$data['details']=$this->reservation_model->get_reservation_bycode($this->uri->segment(4));
		$data['bankdata']=$this->reservation_model->get_resevationdata($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('re_resevation',$this->uri->segment(4),'res_code');
		$session = array('activtable'=>'re_reservationms');
		$this->session->set_userdata($session);
		$this->load->view('re/reservation/edit',$data);

	}
	function editdata()
	{
		if ( ! check_access('edit_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}

		$id=$this->reservation_model->edit();


		$this->session->set_flashdata('msg', 'reservation Details Successfully Updated ');

		//$this->common_model->delete_activflag('re_reservationms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('res_code').' reservation Details successfully Updated');
		redirect("re/reservation/add_data/".$id);

	}

	public function confirm()
	{
		if ( ! check_access('confirm_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/newreservation');
			return;
		}
		$data['details']=$res_data=$this->reservation_model->get_resevationdata($this->uri->segment(4));
		if($res_data->res_status=='PENDING')
		{
			$lotdetail=$this->lotdata_model->get_project_lotdata_id($res_data->lot_id);
			if(floatval($lotdetail->sale_val) > floatval($res_data->discounted_price))
			{
				if ( ! check_access('confirm_discountedreservation'))
				{
					$this->session->set_flashdata('error', 'Please Contact Head of Customer care to Confirm this reservation');
					redirect("re/reservation/newreservation");
					return;
	
				}
				else
				{
					$id=$this->reservation_model->confirm($this->uri->segment(4));
					$this->common_model->delete_notification('re_resevation',$this->uri->segment(4));
					$this->session->set_flashdata('msg', $this->uri->segment(4).' reservation Successfully Confirmed ');
					$this->logger->write_message("success", $this->uri->segment(4).'  reservation id successfully Confirmed');
					redirect("re/reservation/newreservation");
				}
	
			}
			else{
			$id=$this->reservation_model->confirm($this->uri->segment(4));
	
			$this->common_model->delete_notification('re_resevation',$this->uri->segment(4));
			$this->session->set_flashdata('msg', $this->uri->segment(4).' reservation Successfully Confirmed ');
			$this->logger->write_message("success", $this->uri->segment(4).'  reservation id successfully Confirmed');
			redirect("re/reservation/newreservation");
			}
		}
		else
		{
				$this->session->set_flashdata('error', $this->uri->segment(4).' reservation Already COnfirmed ');
				redirect("re/reservation/newreservation");
		}


	}
	public function delete()
	{
		if ( ! check_access('delete_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}
		$id=$this->reservation_model->delete_reservation_new($this->uri->segment(4));

		$this->common_model->delete_notification('re_resevation',$this->uri->segment(4));
		$this->session->set_flashdata('msg', $this->uri->segment(4). ' reservation Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' reservation id successfully Deleted');
		redirect("re/reservation/newreservation");

	}
	public function sold()
	{
		$data=NULL;
		if ( ! check_access('view_outright_list'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_settlments_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_settlments($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/sold';
				$tablename='re_settlement';
				$statusfield='res_status';
				$status='COMPLETE';
				$this->pagination($page_count,$siteurl,$tablename);

				$this->load->view('re/reservation/complete_list',$data);



	}
	public function eploans()
	{
		$data=NULL;
		if ( ! check_access('view_pending_loanlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_eploan_pending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/eploans';
				$tablename='re_eploan';
				$this->pagination_status($page_count,$siteurl,$tablename,'loan_status','PENDING');

				$this->load->view('re/reservation/loan_list',$data);



	}



function edit_complete()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->reservation_model->get_purchase_type();
				 $data['loandata']=$this->reservation_model->get_eploan_data($res_code);
				  $data['settledata']=$this->reservation_model->get_settlemnt_data($res_code);
				  $data['loan_officer']=$this->salesmen_model->get_project_officerlist($resdata->prj_id);
		$this->common_model->add_activeflag('re_resevation',$this->uri->segment(4),'res_code');
		$session = array('activtable'=>'re_resevation');
		$this->session->set_userdata($session);
		$this->load->view('re/reservation/edit_complete',$data);

	}
	function editdata_compete()
	{
		if ( ! check_access('edit_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}

		$id=$this->reservation_model->edit_settlment();
		$data=$this->reservation_model->get_all_reservation_details_bycode($this->input->post('res_code_set'));

		$this->session->set_flashdata('msg', 'reservation Details Successfully Updated ');
		$this->common_model->delete_activflag('re_resevation',$this->input->post('res_code_set'),'res_code');
		//$this->common_model->delete_activflag('re_reservationms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('res_code_set').' reservation Details successfully Updated');
		if($data->pay_type=='Outright')
		redirect("re/reservation/sold/");
		else
		redirect("re/reservation/eploans/");

	}

	public function confirm_settlement()
	{
		if ( ! check_access('confirm_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}

		$id=$this->reservation_model->confirm_settlment($this->uri->segment(4));

		$this->common_model->delete_notification('re_settlement',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Land successfully Soldout ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Land successfully Sold out');
		redirect("re/reservation/sold");

	}
	public function delete_settlement()
	{
		if ( ! check_access('delete_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}

		$id=$this->reservation_model->delete_settlment($this->uri->segment(4));

		$this->common_model->delete_notification('re_settlement',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Settlement Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Settlement Successfully Deleted');
		redirect("re/reservation/sold");

	}
	public function delete_loan()
	{
		if ( ! check_access('delete_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}

		$id=$this->reservation_model->delete_loan_rescode($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Settlement Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Settlement Successfully Deleted');
		redirect("re/reservation/eploans");

	}
	public function confirm_loan()
	{
		if ( ! check_access('confirm_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}




		$loandata=$this->reservation_model->get_eploan_data($this->uri->segment(4));
		if($loandata->loan_status=='PENDING')
		{
			$resdata=$this->reservation_model->get_all_reservation_details_bycode($this->uri->segment(4));
			$lot_data=$this->accountinterface_model->get_lotdata($resdata->lot_id);
			//Realized Sale value Transfers
			if($resdata->profit_status!='TRANSFERD')
			{
				$res_code=$this->uri->segment(4);
				initial_profit_transfer($res_code,0,'Agreement Creation',date('Y-m-d'));
				$entry=1;
	
	
			}
			else
			{
							$unrealised_sale=$resdata->discounted_price-$resdata->down_payment;
							if($resdata->pay_type=='EPB'){
								$ledgerset=$this->accountinterface_model->get_account_set('EPB Creation');
								$draccount=$ledgerset['Dr_account'];
							}
							if($resdata->pay_type=='ZEP'){
								$ledgerset=$this->accountinterface_model->get_account_set('ZEP Creation');
								$draccount=$ledgerset['Dr_account'];
							}
							if($resdata->pay_type=='NEP'){
								$ledgerset=$this->accountinterface_model->get_account_set('EP creation');
								$draccount=$ledgerset['Dr_account'];
							}
							$ledgerset=get_account_set('Advance Payment After Profit');
	
			//transfer Unrealized Sale
							$drlist=NULL;
							$crlist=NULL;
						$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
						$crlist[0]['amount']=$crtot=$unrealised_sale;
						$drlist[0]['ledgerid']=$draccount;
						$drlist[0]['amount']=$drtot=$unrealised_sale;
						$narration = $resdata->res_code.' Unrialized Sale  Trasnfer  '  ;
						$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
							//NEP Interest Transfer
	
	
			}
			if($resdata->pay_type=='NEP')
			{
				$ledgerset=$this->accountinterface_model->get_account_set('EP Creation Interest');
					$totint=$this->eploan_model->get_int_total($loandata->loan_code);
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$totint;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$totint;
					$narration = $loandata->loan_code.' EP Loan Interest transfer on Creation';
					$entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id,$resdata->res_code);
	
			}
	
	
	
			if($entry)
			{
			$id=$this->reservation_model->confirm_loan($this->uri->segment(4));
			$msg=' Your Loan  successfully Approved and your loan number is'.$loandata->loan_code;
			if($resdata->pay_type=='NEP')
			{
			create_letter($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$loandata->loan_code,'','02',$msg,$loandata->loan_amount);
			}
			else
			{
			//create_letter($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$loandata->loan_code,'','03',$msg,$loandata->loan_amount);
			}
	
			// if on backdated loan creatiion previous instalmetn should transfer to the debtor account
			//following function is used for that purpose;
			$this->financialtransfer_model->capital_and_interest_transfer_on_startloan(date("Y-m-d"),$resdata->res_code);
	
			$this->common_model->delete_notification('re_eploan',$this->uri->segment(4));
			$this->session->set_flashdata('msg', 'Loan successfully Confirmed ');
			$this->logger->write_message("success", $this->uri->segment(4).'  Loan successfully Confirmed');
			}
			else
			{
				$this->session->set_flashdata('error', 'Error updating Confirmation Entry ');
			}
		}
		else
		{
				$this->session->set_flashdata('error', 'Loan Aleady Confirmed ');
		}
		redirect("re/reservation/eploans");

	}

function repayment_schedule()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$this->load->view('re/reservation/loan_schedule',$data);
}
function resale()
{
	if ( ! check_access('view_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}

					$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_summery_resale($this->session->userdata('branchid'));


				$courseSelectList="";
				 $count=0;

				$data['searchpath']='re/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				 foreach($inventory as $c)
      			 {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchlist']=$courseSelectList;
				$data['tab']='list';

					if($page_count)
						$data['tab']='list';
				$siteurl='re/reservation/resale';
				$tablename='re_adresale';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->reservation_model->get_resale($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$this->load->view('re/reservation/resale_main',$data);
}
function add_resale()
	{
		if ( ! check_access('add_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}
		///image upload added by nadee 2020-09-16//
		$file_name="";
				$config['upload_path'] = 'uploads/resale/documents/';
								$config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc';
								$config['max_size'] = '3500';

								$this->load->library('image_lib');
								$this->load->library('upload', $config);
						$this->upload->do_upload('documents');
							$error = $this->upload->display_errors();

							$image_data = $this->upload->data();
				$documents="";
							//$this->session->set_flashdata('error',  $error );
				if($error=="")
							$documents = $image_data['file_name'];
				else
				$this->session->set_flashdata('error',  $error );
		///image upload added by nadee 2020-09-16 end//

		$id=$this->reservation_model->add_resale($documents);

		$this->common_model->add_notification('re_adresale',' Advance Repossess Request','re/reservation/resale',$id);

		$this->session->set_flashdata('msg', ' Advance Reprocess Request Sent ');
		$this->logger->write_message("success", $this->input->post('res_code').' Advance Repossess Request Sent');

		redirect("re/reservation/resale/");
	}
	function delete_resale()
	{
		if ( ! check_access('delete_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/resale');
			return;
		}
		$id=$this->reservation_model->delete_resale($this->uri->segment(4));

		$this->common_model->delete_notification('re_adresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Advance Reprocess Request Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance Repossess Request successfully Deleted');
		redirect("re/reservation/resale");
	}
	function edit_resale()
	{
	$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
		$data['relsaledata']=$this->reservation_model->get_resale_bycode($this->uri->segment(5));
		$this->common_model->add_activeflag('re_epresale',$this->uri->segment(5),'resale_code');

	$this->load->view('re/reservation/resale_editdata',$data);
	}
	function editdata_resale()
	{
		if ( ! check_access('edit_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedule');

			return;
		}
		$id=$this->reservation_model->edit_resale();


		$this->session->set_flashdata('msg', 'Reprocess Details  Successfully Updated ');

		$this->common_model->delete_activflag('re_adresale',$this->input->post('resale_code'),'resale_code');
		$this->logger->write_message("success", $this->input->post('resale_code').' Reprocess Details  Updated');
		redirect("re/reservation/resale");

	}
	function confirm_resale()
	{
		if ( ! check_access('confirm_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/resale');
			return;
		}
		$id=$this->reservation_model->confirm_resale($this->uri->segment(4));

		$this->common_model->delete_notification('re_adresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Advance Repossess Request Confirmed');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance Reprocess Request successfully Confirmed');
		redirect("re/reservation/resale");
	}
function get_resaledata()
{
				$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['deed_data']=$this->deedtransfer_model->get_deedtranfers_data_res_code($res_code);

				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
				//$this->load->view('re/reservation/advance_data',$data);

	$this->load->view('re/reservation/resale_data',$data);
}
//reservation chargets
function chargers()
	{
		$data=NULL;
		if ( ! check_access('view_charges'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}

		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->reservation_model->get_all_reservation_summery_withoutreprocess($this->session->userdata('branchid'));

		/*Ticket No:2975 Added By Madushan 2021.06.28*/
		$data['resale_lots'] = $this->reservation_model->get_resale_lots();
		$data['transfer_list'] = $this->reservation_model->get_transfer_list();
		/*End Of Ticket No:2975*/

				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/showall';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);

				$this->load->view('re/reservation/chargers',$data);

	}
function get_chargelist()
	{			$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['charge_data']=$this->reservation_model->get_charge_data($res_code);
				$data['charge_payment']=$this->reservation_model->get_charge_payments($res_code);

				$this->load->view('re/reservation/charge_data',$data);
	}
	function add_charges()
	{
		if ( ! check_access('add_charges'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/payments');

			return;
		}

		$id=$this->reservation_model->add_charges();
		$this->session->set_flashdata('msg', 'Reservation Charges successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		redirect("re/reservation/chargers/");
	}
	function get_chargerfulldata($id)
	{			$res_code=$id;
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['charge_data']=$this->reservation_model->get_charge_data($res_code);
				$data['charge_payment']=$this->reservation_model->get_charge_payments($res_code);

				$this->load->view('re/reservation/charge_fulldata',$data);
	}
	public function Update_reciepting_customer()
	{


		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_summery_withoutreprocess($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->reservation_model->get_all__not_complete_reservation_summery($this->session->userdata('branchid'));

				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/showall';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);

				$this->load->view('re/reservation/receipt_customer',$data);


	}
	function get_customer_list($res_code)
	{
		$data['cuslist']=$this->customer_model->get_all_customer_summery();
		$data['rescode']=$this->reservation_model->get_all_reservation_details_bycode($this->uri->segment(4));
		$this->load->view('re/reservation/get_customer_list',$data);
	}
	function update_customer_data()
	{
		$res_code=$this->input->post('res_code_charge');;

		$cuscode=$this->input->post('cus_code2');
		$data['cuslist']=$this->reservation_model->update_receipt_customer($res_code,$cuscode);
		$this->session->set_flashdata('msg', 'Receipting Customer successfully Inserted ');
		redirect("re/reservation/Update_reciepting_customer/");
	}
	function get_branch_projectlist()
	{

		$branchid=explode(',',$this->uri->segment(4));
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid[0]);
		$this->load->view('re/reservation/project_list',$data);

	}
	function new_discount()
	{$res_code=$this->uri->segment(4);
	$pay_date=$this->uri->segment(5);
	$amount=$this->uri->segment(6);
	$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
	$newdown=$res_code->down_payment+$amount;
		$data['prjlist']=$prjlist=$this->reservationdiscount_model->get_new_discount_rate($resdata->res_date,$pay_date,$rate);
	}

	function get_updated_date(){
		$date = $this->input->post('date');
		$days = $this->input->post('days');
		$futureDate = date('Y-m-d',strtotime('+'.$days.'days',strtotime($date)));
		echo trim($futureDate);
	}

	function test_discount(){
		$res_code = 'HED00024';
		$prj_id = 1;
		$paydays = 1;
		$pay_amount = 3157500.00;
		$paid_amount = 150000;
		$discounted_price = 5512500;
		echo $this->calculate_scheme_discount($res_code,$prj_id,$paydays,$pay_amount,$paid_amount,$discounted_price);
	}

	function test()
	{
		$this->dicalculate_model->generate_advance_schedule_today_delaint('2021-06-15');
	}

	/*Ticket No:2975 Added By Madushan 2021.06.28*/
function get_resale_chargelist()
{	$res_code=$this->uri->segment(4);
	$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
	$data['charge_data']=$this->reservation_model->get_charge_data($res_code);
    $data['charge_payment']=$this->reservation_model->get_charge_payments($res_code);

    $this->load->view('re/reservation/transfer_data',$data);
}

function check_transfer()
{
	$res_code = $this->input->get('res_code');
	$type = $this->input->get('type');

	$result = $this->reservation_model->allow_to_transfer($res_code,$type);
	if($result)
		echo 'True';
	else
		echo 'False';
	//echo $result;

}

function transfer_chargers()
{
	$from_res_code = $this->input->post('resale_lots');
	$to_res_code = $this->input->post('reservation_data');

	// echo $from_res_code;
	// echo $to_res_code;
	// exit;
	$stamp_duty_val = $this->input->post('stamp_duty_val');
	$leagal_fee_val = $this->input->post('leagal_fee_val');
	$document_fee_val = $this->input->post('document_fee_val');
	$other_charges_val = $this->input->post('other_charges_val');
	$other_charges2_val = $this->input->post('other_charges2_val');
	$opinion_fee_val = $this->input->post('opinion_fee_val');
	$document_chargers_val = $this->input->post('document_chargers_val');
	$ep_document_val = $this->input->post('ep_document_val');

	$stamp_check = $this->input->post('stamp_check');
	$leagal_fee_check = $this->input->post('leagal_fee_check');
	$document_fee_check = $this->input->post('document_fee_check');
	$other_charges_check = $this->input->post('other_charges_check');
	$other_charge2_check = $this->input->post('other_charge2_check');
	$opinion_fee_check = $this->input->post('opinion_fee_check');
	$document_chargers_check = $this->input->post('document_chargers_check');
	$ep_document_chargers_check = $this->input->post('ep_document_chargers_check');

	if($stamp_check || $leagal_fee_check || $document_fee_check || $other_charges_check || $other_charge2_check || $opinion_fee_check || $document_chargers_check || $ep_document_chargers_check)
	{
		$transfer_id = $this->reservation_model->add_transfer_data($from_res_code,$to_res_code);
	}

	if($stamp_check)
	{
		//$this->reservation_model->trasfer_chargers($stamp_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($stamp_check,$from_res_code,$to_res_code,$stamp_duty_val,$transfer_id);
	}
	if($leagal_fee_check)
	{
		//$this->reservation_model->trasfer_chargers($leagal_fee_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($leagal_fee_check,$from_res_code,$to_res_code,$leagal_fee_val,$transfer_id);
	}
	if($document_fee_check)
	{
		//$this->reservation_model->trasfer_chargers($document_fee_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($document_fee_check,$from_res_code,$to_res_code,$document_fee_val,$transfer_id);
	}
	if($other_charges_check)
	{
		//$this->reservation_model->trasfer_chargers($other_charges_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($other_charges_check,$from_res_code,$to_res_code,$other_charges_val,$transfer_id);
	}
	if($other_charge2_check)
	{
		//$this->reservation_model->trasfer_chargers($other_charge2_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($other_charge2_check,$from_res_code,$to_res_code,$other_charges2_val,$transfer_id);
	}
	if($opinion_fee_check)
	{
		//$this->reservation_model->trasfer_chargers($opinion_fee_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($opinion_fee_check,$from_res_code,$to_res_code,$opinion_fee_val,$transfer_id);
	}
	if($document_chargers_check)
	{
		//$this->reservation_model->trasfer_chargers($document_chargers_check,$from_res_code,$to_res_code)
		;
		$this->reservation_model->add_transfer($document_chargers_check,$from_res_code,$to_res_code,$document_chargers_val,$transfer_id);
	}
	if($ep_document_chargers_check)
	{
		//$this->reservation_model->trasfer_chargers($ep_document_chargers_check,$from_res_code,$to_res_code);
		$this->reservation_model->add_transfer($ep_document_chargers_check,$from_res_code,$to_res_code,$ep_document_val,$transfer_id);
	}

	//Add Notification
	$table = 're_transferchargersms';
	$notification = 'Transfer Chargers '.$from_res_code.' To '.$to_res_code;
	$module = 're/reservation/chargers';
	$record_key = 'id';
	$this->common_model->add_notification($table,$notification,$module,$record_key);
	$this->session->set_flashdata('msg', 'Transfered successfully');
	redirect('re/reservation/chargers');


}

function view_chargers_transfer()
{
	$transfer_id = $this->uri->segment(4);
	$data['transfer_data'] = $this->reservation_model->get_transfer_data($transfer_id);
	$this->load->view('re/reservation/view_chargers_transfer',$data);
}

function confirm_transfer()
{
	$transfer_id = $this->uri->segment(4);
	$transfer_data = $this->reservation_model->get_transfer_data($transfer_id);
	if($transfer_data){
		foreach($transfer_data as $row)
		{
			if($row->charge_type == 'stamp_duty')
			{
				//$this->reservation_model->trasfer_chargers($stamp_check,$from_res_code,$to_res_code);
				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'leagal_fee')
			{
				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'document_fee')
			{

				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'other_charges')
			{

				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'other_charge2')
			{

				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'opinion_fee')
			{

				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'document_chargers')
			{

				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
			if($row->charge_type == 'ep_document_chargers')
			{

				$this->reservation_model->trasfer_chargers($row->charge_type,$row->from,$row->to);
			}
		}
	}

	$table = 're_transferchargersms';
	$record_key = 'id';
	$this->common_model->delete_notification($table,$record_key);
	$this->reservation_model->confirm_transfer($transfer_id);
	$this->session->set_flashdata('msg', 'Confirmed successfully');
	redirect('re/reservation/chargers');

}

function delete_transfer()
{
	$transfer_id = $this->uri->segment(4);
	$this->reservation_model->delete_transfer($transfer_id);

	$table = 're_transferchargersms';
	$record_key = 'id';
	$this->common_model->delete_notification($table,$record_key);

	$this->session->set_flashdata('msg', 'Deleted successfully');
	redirect('re/reservation/chargers');
}
/*End Of Ticket No:2975*/
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
