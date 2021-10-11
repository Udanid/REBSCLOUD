<?php
class Insentive extends CI_Controller{


	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
		$this->load->model('paymentvoucher_model');
		$this->load->model("hr/letter_model");
		$this->load->model("hr/salary_advance_model");
			$this->load->model("hr/insentive_model");
			$this->load->library('Spreadsheet_Excel_Reader');
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}


		public function incentives(){
			if ( ! check_access('incentive_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$this->load->library('pagination');
			$page_count = (int)$this->uri->segment(4);

			if(!$page_count)
			$page_count = 0;

			/* Pagination configuration */
			$config['base_url'] = site_url('hr/insentive/incentives');
			$config['uri_segment'] = 4;

			$pagination_counter = RAW_COUNT;
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
			$startcounter = ($page_count)*$pagination_counter;
			$data['datalist'] = $this->insentive_model->get_all_incentive_fields($pagination_counter,$page_count);
			$config['total_rows'] = $this->db->count_all('hr_insentive');
			$this->pagination->initialize($config);

	      	$data1['title'] = "incentive_view";
	      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
			$this->load->view('includes/topbar_notsearch');
	      	$this->load->view('hr/config/incentive_view',$data);
	      	$this->load->view('includes/footer');



	      	/*$data['datalist'] = $this->insentive_model->get_all_incentive_fields($pagination_counter,$page_count);

	      	print_r($data['datalist']);
	      	die();*/



		}



		public function add_incentive(){
			if ( ! check_access('incentive_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$this->insentive_model->add_incentive_field();
			$this->session->set_flashdata('msg', 'Incentive Field Successfully Added');
			redirect("hr/insentive/incentives");
		}


		public function edit_incentive(){

			$id = (int)$this->uri->segment(4);
			$data['details'] = $this->insentive_model->get_incentive_details($id);


			$this->load->view('hr/config/incentive_view_edit',$data);
		}


		public function update_incentive(){

			$this->insentive_model->update_incentive_details();

			$this->session->set_flashdata('msg', 'Incentive Successfully Updated');
			redirect("hr/insentive/incentives");
		}
		public function incentive_upload(){
			if ( ! check_access('incentive_upload'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}

			$data['title'] = "Employee Incentive";

		$viewData['employee_list'] = $this->insentive_model->get_employee_list();

		$viewData['incentivelist']=$this->insentive_model->get_incentive();

		/*print_r($viewdata['incetivelist']);
		die();*/

		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(4);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('hr/insentive/incentive_upload');
		$config['uri_segment'] = 4;

		$pagination_counter = RAW_COUNT;
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
		$startcounter = ($page_count)*$pagination_counter;
		$viewData['datalist'] = $this->insentive_model->get_incentive_master_list($pagination_counter, $page_count);
		$config['total_rows'] = $this->db->count_all('hr_insentive_master');
		$this->pagination->initialize($config);

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/payroll/upload_incentive_view', $viewData);
			$this->load->view('includes/footer');
		}


		function add_incentives()
		{
			if ( ! check_access('incentive_upload'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}

			$this->form_validation->set_rules('incentive', 'Incentive', 'required');


	$this->form_validation->set_rules('year', 'Year', 'required');
			$this->form_validation->set_rules('month', 'Month', 'required');

			if($this->form_validation->run()){
				$year = $this->input->post('year', TRUE);
				$month = $this->input->post('month', TRUE);
				$type = $this->input->post('incentive', TRUE);
				$date = $year."-".$month;
				if(date("Y-m", strtotime($date)) > date("Y-m")){
					$errors = "<br>System does not allow to generate salary advance sheet for future months";
								echo json_encode(['error'=>$errors]);
								$this->session->set_flashdata('error',$errors);
					die();
				}

				$year_month_validation = $this->insentive_model->check_incentive_master_year_month($year, $month,$type);
				if(count($year_month_validation)>0){
					$errors = "<br>System does not allow to regenerate incentive for same month";
								echo json_encode(['error'=>$errors]);
								$this->session->set_flashdata('error',$errors);
					die();
				}
				$last_insert_id = $this->insentive_model->insentive_submit();//submit master data
				//if($this->input->post('file', TRUE))
				//{
					$config['upload_path'] = './uploads/insentive/';
					if ( ! file_exists($config['upload_path']) )
					{
						$create = mkdir($config['upload_path'], 0777);

					}
			$config['allowed_types'] = 'xls|xlsx|csv';
			$this->load->library('upload', $config);
			$attendance_sheet_upload_records_insertId='';

        if($this->upload->do_upload('file')){

			$data = $this->upload->data();
			//print_r($data);
			if($data['file_ext']!='.xls'){
				$this->session->set_flashdata('msg',"Please Select Correct File Format");

				redirect('hr/employee/upload_attendance');
			}
			$file_attendance_name = $data['file_name'];
			$count = 1;
		$data_excel = array();
		$attendance_array = array();
		$branch = $this->input->post('branch', TRUE);

		$excel = new Spreadsheet_Excel_Reader();
		$excelread=$excel->read($config['upload_path'].'/'.$file_attendance_name);

		If($excelread){
			$this->session->set_flashdata('error', 'Excel sheet format error, Please download the format and upload again');
			redirect("user");
		}
		$data['data_excell']=$data_excell=$excel->sheets[0]['cells'];
		$row_count = count($data_excell);
		if($data_excell){
			$top_row=($data_excell[1][1]);
			$a=1;
			while ($a <= 3) {
				array_shift($data_excell);
				$a++;
			}


			foreach ($data_excell as $key => $value) {
					//echo $value[1];
					$emp_no = $value[2];
					$amount = $value[8];
					$monthly_no_pay_count = $this->insentive_model->insentive_submit_upload($last_insert_id,$emp_no,$amount);
				}
				}
			}else{
				$monthly_no_pay_count = $this->insentive_model->insentive_submit_details($last_insert_id);
			}
	//	}

				$this->session->set_flashdata('msg',"incentive successfully Inserted");
				echo json_encode(['success'=>'incentive successfully Inserted']);
			}else{
				$errors = validation_errors();
				$this->session->set_flashdata('error',$errors);
							echo json_encode(['error'=>$errors]);
					}

			}



		 function incentive_list(){
			if ( ! check_access('incentive_upload'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$id = (int)$this->uri->segment(4);
			$viewData['employee_list'] = $this->insentive_model->get_employee_list();
			$viewData['details'] = $this->insentive_model->get_incentive_master_details($id);
			$viewData['incentive_advance_list'] = $this->insentive_model->get_incentive_list($id);


			/*print_r($viewData['details']);
			die();*/

			$this->load->view('hr/payroll/incentive_list_view', $viewData);
		}



		public function check_incentive(){
				if ( ! check_access('incentive_check'))
				{
					$this->session->set_flashdata('error', 'Permission Denied');
					redirect('menu_call/showdata/hr');
					return;
				}
			$record_id = $_REQUEST['record_id'];
			$this->insentive_model->check_incentive_payment($record_id);
			$this->session->set_flashdata('msg',"Incentive Checked Successfully");
			echo json_encode(['success'=>'Incentive Checked Successfully']);
			die();
		}


		public function incentive_confirm(){
				if ( ! check_access('incentive_conformed'))
				{
					$this->session->set_flashdata('error', 'Permission Denied');
					redirect('menu_call/showdata/hr');
					return;
				}
			$record_id = $_REQUEST['record_id'];
			$this->insentive_model->confirm_incentive_payment($record_id);
			$this->session->set_flashdata('msg',"Incentive Confirmed Successfully");
			echo json_encode(['success'=>'Incentive Checked Successfully']);
			die();
		}



		public function delete_incentive(){
			if ( ! check_access('decline_incentive'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$id = $this->uri->segment(4);
			$this->insentive_model->decline_incentive($id);
			$this->session->set_flashdata('msg',"incentive  decline successfully");
			redirect('hr/insentive/incentive_upload');
		}




}
?>
