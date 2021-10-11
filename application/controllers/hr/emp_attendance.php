<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_attendance extends CI_Controller {


	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
		$this->load->model('paymentvoucher_model');
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}



		public function upload_attendance(){
			if ( ! check_access('attendance_update'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$data['title'] = "Upload Employee Attendance";
		$viewData['branch_list'] = $this->common_hr_model->get_branch_list();

		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(4);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('hr/emp_attendance/upload_attendance');
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
		$viewData['datalist'] = $this->employee_model->get_employee_attendance_upload_list($pagination_counter, $page_count);
		$config['total_rows'] = $this->db->count_all('hr_emp_attendance_upload');
		$this->pagination->initialize($config);

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/attendance/emp_attendance_upload', $viewData);
			$this->load->view('includes/footer');
		}


		public function submit_attendance_sheet(){
		if ( ! check_access('attendance_update'))
		{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
		}
			$config['upload_path'] = './uploads/attendance_sheets/';
				$config['allowed_types'] = 'xls|xlsx|csv';
				$this->load->library('upload', $config);

		 //   $finfo = finfo_open(FILEINFO_MIME_TYPE);
		//	$mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
		//	echo $mime;
		//	die;
		$attendance_sheet_upload_records_insertId='';

				if($this->upload->do_upload('file')){
			$data = $this->upload->data();
			$file_attendance_name = $_FILES['file']['tmp_name'];

			$row_count = file($file_attendance_name);
			$row_count = count($row_count);
			$count = 1;
			$data_excel = array();
			$attendance_array = array();
			$branch = $this->input->post('branch', TRUE);

			$file = fopen($file_attendance_name,"r");
			fgetcsv($file);

			while(($data = fgetcsv($file, 10000, ",")) !== FALSE){
				$duty_in_date_time = $data[2];
				$duty_in_date = date("Y-m-d", strtotime($duty_in_date_time));
				$duty_in_date_time = date('Y-m-d H:i:s', strtotime($duty_in_date_time));



				if($count == 1){
					$first_day = $duty_in_date;
				}else if($count == $row_count-1){
					$last_day = $duty_in_date;
					$username = $this->session->userdata('username');
					$data_record = array(
						'branch' => $branch,
						'from_date' => $first_day,
						'to_date' => $last_day,
						'created_by' => $username
					);
					$attendance_sheet_upload_records_insertId = $this->employee_model->attendance_sheet_upload_records($data_record);
				}
				$count=$count+1;
				$check_holiday_date="N";
				$check_holiday=$this->employee_model->check_holidays($duty_in_date);
				if($check_holiday){
					$check_holiday_date="Y";
				}
				$emp_record_id = $data[0];
				$user_data = $this->employee_model->get_user_data($emp_record_id);
				$fingerprint_user= $this->employee_model->check_fingerprint_user($emp_record_id);
				if($fingerprint_user['attendance_type']=='F' && $check_holiday_date=="N"){
				$elements = array("emp_record_id" => $emp_record_id, "username" => $user_data['USRNAME'], "date" => $duty_in_date, "date_time" => $duty_in_date_time);
						array_push($attendance_array, $elements);
					}
			}
			fclose($file);

			$attendance_details = $this->groupArray($attendance_array, "date", true);
			foreach($attendance_details as $attendance_date_row){

				$attendance_details_row_by_emp_id = "";
				$attendance_details_row_by_emp_id = $this->groupArray($attendance_date_row, "emp_record_id", true);
				foreach($attendance_details_row_by_emp_id as $attendance_details_by_emp_id_row){
					$attendance_i = 0;
					$attendance_len = count($attendance_details_by_emp_id_row);
					$data_excel = "";
					$data_excel = array();
				foreach($attendance_details_by_emp_id_row as $attendance_row){
						$emp_record_id = $attendance_row['emp_record_id'];
						$duty_in_date = $attendance_row['date'];
						$attendance_validation = $this->employee_model->get_emp_attendance_report($duty_in_date, $emp_record_id);
						if(count($attendance_validation) <= 0){
							if($attendance_i == 0){
								$duty_in_date_time = $attendance_row['date_time'];
								$duty_in_time = date("H:i:s",strtotime($duty_in_date_time));
							}else if($attendance_i == $attendance_len - 1){
								$duty_out_date_time = $attendance_row['date_time'];
								$data_excel['emp_record_id'] = $emp_record_id;
								$data_excel['username'] = $attendance_row['username'];
								$data_excel['date'] = $duty_in_date;
								$data_excel['duty_in'] = $duty_in_date_time;
								$data_excel['duty_out'] = $duty_out_date_time;
								$data_excel['branch']=$branch;
								$attendance_sheet_insertId = $this->employee_model->submit_attendance_sheet($data_excel);

								$morning_short_leave_start = '08:46:00';
								$morning_short_leave_end = '10:45:00';
								$morning_half_day_leave_start = '10:46:00';
								$morning_half_day_leave_end = '12:45:00';
								if($duty_in_time >= $morning_short_leave_start && $duty_in_time <= $morning_short_leave_end){
									$leave_type = "short_leave";
									$check_leaves_for_the_day = $this->user_model->check_leaves_for_the_day($leave_type, $duty_in_date, $emp_record_id);
									if(count($check_leaves_for_the_day)>0){
										return $check_leaves_for_the_day;
									}else{
										$employee_details = $this->employee_model->get_employee_details($emp_record_id);
										if($employee_details['maternity_leave'] == 'N'){
											$mark_leaves_by_attendance = $this->user_model->mark_leaves_by_attendance($leave_type, $duty_in_date, $emp_record_id);
										}
									}
								}else if($duty_in_time >= $morning_half_day_leave_start && $duty_in_time <= $morning_half_day_leave_end){
									if(date('N', strtotime($duty_in_date_time)) >= 6){
										//Saturday leave times
									}else{
									$leave_type = "half_day";
									$check_leaves_for_the_day = $this->user_model->check_leaves_for_the_day($leave_type, $duty_in_date, $emp_record_id);
									if(count($check_leaves_for_the_day)>0){
										return $check_leaves_for_the_day;
									}else{
										$mark_leaves_by_attendance = $this->user_model->mark_leaves_by_attendance($leave_type, $duty_in_date, $emp_record_id);
									}
								}
								}

								$duty_out_time = date("H:i:s",strtotime($duty_out_date_time));
								$evening_short_leave_start = '15:01:00';
								$evening_short_leave_end = '16:59:00';
								$evening_half_day_leave_start = '13:01:00';
								$evening_half_day_leave_end = '15:00:00';
								if($duty_out_time >= $evening_short_leave_start && $duty_out_time <= $evening_short_leave_end){
									if(date('N', strtotime($duty_in_date_time)) >= 6){
										//Saturday leave times
									}else{
									$leave_type = "short_leave";
									$check_leaves_for_the_day = $this->user_model->check_leaves_for_the_day($leave_type, $duty_in_date, $emp_record_id);
									if(count($check_leaves_for_the_day)>0){
										return $check_leaves_for_the_day;
									}else{
										$employee_details = $this->employee_model->get_employee_details($emp_record_id);
										if($employee_details['maternity_leave'] == 'N'){
											$mark_leaves_by_attendance = $this->user_model->mark_leaves_by_attendance($leave_type, $duty_in_date, $emp_record_id);
										}
									}
								}
								}else if($duty_out_time >= $evening_half_day_leave_start && $duty_out_time <= $evening_half_day_leave_end){
									if(date('N', strtotime($duty_in_date_time)) >= 6){
										//Saturday leave times
									}else{
									$leave_type = "half_day";
									$check_leaves_for_the_day = $this->user_model->check_leaves_for_the_day($leave_type, $duty_in_date, $emp_record_id);
									if(count($check_leaves_for_the_day)>0){
										return $check_leaves_for_the_day;
									}else{
										$mark_leaves_by_attendance = $this->user_model->mark_leaves_by_attendance($leave_type, $duty_in_date, $emp_record_id);
									}
								}
								}

								$mark_leaves_by_go_out_go_in = $this->user_model->mark_leaves_by_go_out_go_in($duty_out_date_time, $emp_record_id);

							}else{
								if($attendance_i % 2 == 0){
									$go_in_data['go_in'] = $attendance_row['date_time'];
									$go_in_out_attendance_sheet_insertId = $this->employee_model->mark_employee_go_in_by_attendance_sheet($go_out_attendance_sheet_insertId, $go_in_data);
							}else{
									$go_out_data['go_out'] = $attendance_row['date_time'];
									$go_out_data['emp_record_id'] = $emp_record_id;
									$go_out_data['username'] = $attendance_row['username'];
									$go_out_data['date'] = $duty_in_date;
									$go_out_attendance_sheet_insertId = $this->employee_model->mark_employee_go_out_by_attendance_sheet($go_out_data);
								}
							}
						}
						$attendance_i++;
					}

				}

			}
			$emp_pendingleaves_in_monthend = $this->employee_model->emp_pendingleaves_in_monthend($attendance_sheet_upload_records_insertId,$branch);
			$this->session->set_flashdata('msg',"Employee attendance sheet uploaded successfully");
			//echo json_encode(['success'=>'Employee attendance sheet uploaded successfully']);
			//die;
			redirect('hr/emp_attendance/upload_attendance');
		}else{
			$errors = $this->upload->display_errors();
		$this->session->set_flashdata('error',$errors);
		redirect('hr/emp_attendance/upload_attendance');
		//echo json_encode(['error'=>$errors]);
		//die;
		}
		}
		public function groupArray($arr, $group, $preserveGroupKey = false, $preserveSubArrays = false) {
		$temp = array();
		foreach($arr as $key => $value) {
			$groupValue = $value[$group];
			if(!$preserveGroupKey)
			{
				unset($arr[$key][$group]);
			}
			if(!array_key_exists($groupValue, $temp)) {
				$temp[$groupValue] = array();
			}

			if(!$preserveSubArrays){
				$data = count($arr[$key]) == 1? array_pop($arr[$key]) : $arr[$key];
			} else {
				$data = $arr[$key];
			}
			$temp[$groupValue][] = $data;
		}
		return $temp;
		}

		public function attendance_report(){
			if ( ! check_access('hr_report'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$data['title'] = "Employee Attendance Report";
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['branch_list'] = $this->common_hr_model->get_branch_list();

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/attendance/emp_attendance_view', $viewData);
			$this->load->view('includes/footer');
		}

		function get_branch_employee_list(){
		$branch_code = $this->uri->segment(4);
		$data['id'] = $branch_code;

		$data['branch_employee_list'] = $this->employee_model->get_branch_employee_list($branch_code);
		$this->load->view('hr/attendance/branch_employee_list', $data);
		}

		public function view_attendance_report(){
		if ( ! check_access('hr_report'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$viewData['employee_list'] = $this->employee_model->get_employee_list();

		$viewData['from_date'] = $this->input->post('from_date', TRUE);
		$viewData['to_date'] = $this->input->post('to_date', TRUE);
		$branch = $this->input->post('branch', TRUE);
		if($branch == "all"){
			$branch = $this->input->post('branch', TRUE);
		}else{
			$branch_details = $this->common_hr_model->get_branch_details($branch);
			$branch = $branch_details['branch_name'];
		}

		//$viewData['branch'] = $branch;
		$viewData['branch_name'] = $branch;
		$viewData['branch'] = $this->input->post('branch', TRUE);
		$viewData['employee_id'] = $this->input->post('employee', TRUE);

		$emp_attendance_report_filter_view = $this->load->view('hr/employee/emp_attendance_report_filter_view', $viewData, TRUE);
		echo json_encode(['success' => $emp_attendance_report_filter_view]);
		die;
		}

		public function go_in_go_out_report(){
			if ( ! check_access('hr_report'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$data['title'] = "Employee Go In & Go Out Report";
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['branch_list'] = $this->common_hr_model->get_branch_list();

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/attendance/emp_go_in_go_out_view', $viewData);
			$this->load->view('includes/footer');
		}

		public function view_go_in_go_out_report(){
		if ( ! check_access('hr_report'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$viewData['employee_list'] = $this->employee_model->get_employee_list();

		$viewData['from_date'] = $this->input->post('from_date', TRUE);
		$viewData['to_date'] = $this->input->post('to_date', TRUE);
		$branch = $this->input->post('branch', TRUE);
		if($branch == "all"){
			$branch = $this->input->post('branch', TRUE);
		}else{
			$branch_details = $this->common_hr_model->get_branch_details($branch);
			$branch = $branch_details['branch_name'];
		}

		$viewData['branch'] = $branch;
		$viewData['employee_id'] = $this->input->post('employee', TRUE);

		$emp_attendance_report_filter_view = $this->load->view('hr/employee/emp_go_in_go_out_report_filter_view', $viewData, TRUE);
		echo json_encode(['success' => $emp_attendance_report_filter_view]);
		die;
		}

		// add by nadee
		public function attendance_update(){
		if ( ! check_access('attendance_manual_update'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Upload Employee Attendance";
		$viewData['branch_list'] = $this->common_hr_model->get_branch_list();
		$viewData['emp_list']= $this->employee_model->get_employee_list();
		$viewData['temp_list']=$temp_list=$this->employee_model->get_manual_attendance();
		$user_data=Null;
		foreach ($temp_list as $key => $value) {
			$user_data[$value->emp_record_id] = $this->employee_model->get_employee_details_attendance($value->emp_record_id);
		}
		$viewData['user_data']=$user_data;
		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/attendance/attendance_update',$viewData);
		$this->load->view('includes/footer');
		}
		public function submit_attendance_manual()
		{
		if ( ! check_access('attendance_manual_update'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$emp = $this->input->post('employee', TRUE);
		$user_data = $this->employee_model->get_user_data($emp);
		$emp_username=$user_data['USRNAME'];
		$date = $this->input->post('from_date', TRUE);
		$intime = $this->input->post('intime', TRUE);
		$outtime = $this->input->post('outtime', TRUE);
		$data=array(
			'emp_record_id'=>$emp,
			'username'=>$emp_username,
			'date'=>$date,
			'duty_in'=>$date." ".$intime,
			'duty_out'=>$date." ".$outtime,
		);
		$added=$this->employee_model->submit_attendance_manual($data);
		if($added)
		{
			$system_pending_record=$this->employee_model->detele_system_pending_records($emp,$date);
			$this->session->set_flashdata('msg',"Employee attendance added successfully");
			echo json_encode(['success'=>'Employee attendance added successfully']);
			die;
		}else{
			$this->session->set_flashdata('msg',"Error in updating");
			$errors = "Error in updating";
			echo json_encode(['error'=>$errors]);
			die;
		}
		}
		public function attendence_confirm()
		{
		if ( ! check_access('attendance_manual_update'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id=$this->uri->segment(4);
		$update=$this->employee_model->manual_attendance_confirm($id);
			if($update)
			{
				$this->session->set_flashdata('msg',"Employee attendance updated successfully");
				redirect(base_url('hr/emp_attendance/attendance_update'));
			}else{

				$this->session->set_flashdata('msg',"Error in updating");
				redirect(base_url('hr/emp_attendance/attendance_update'));
			}


		}
		public function attendence_cancel()
		{
		if ( ! check_access('attendance_manual_update'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id=$this->uri->segment(4);
		$update=$this->employee_model->manual_attendance_cancel($id);
		if($update)
		{
			$this->session->set_flashdata('msg',"Employee attendance cancel successfully");
			redirect(base_url('hr/emp_attendance/attendance_update'));
		}else{

			$this->session->set_flashdata('msg',"Error in updating");
			redirect(base_url('hr/emp_attendance/attendance_update'));
		}
		}



			public function flagged_user_list(){
				if ( ! check_access('employee_unflag'))
				{
					$this->session->set_flashdata('error', 'Permission Denied');
					redirect('menu_call/showdata/hr');
					return;
				}
				$data['title'] = "Flagged Employee List";

			$viewData['employee_list'] = $this->employee_model->get_employee_list();

			$this->load->library('pagination');
			$page_count = (int)$this->uri->segment(4);

			if(!$page_count)
			$page_count = 0;

			/* Pagination configuration */
			$config['base_url'] = site_url('hr/emp_attendance/flagged_user_list');
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
			$viewData['datalist'] = $this->employee_model->get_duty_out_flagged_employee_list($pagination_counter, $page_count);
			$config['total_rows'] = $this->db->count_all('hr_duty_out_flagged_users');
			$this->pagination->initialize($config);

				$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
			$this->load->view('includes/topbar_notsearch');
				$this->load->view('hr/attendance/emp_duty_out_flagged_list_view', $viewData);
				$this->load->view('includes/footer');
			}

			public function emp_duty_out_unflag(){
			if ( ! check_access('employee_unflag'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$id = (int)$this->uri->segment(4);
			$viewData['emp_duty_out_flagged_details'] = $this->employee_model->get_emp_duty_out_flagged_details($id);
			$this->load->view('hr/attendance/emp_duty_out_unflag_view', $viewData);
			}

			public function update_emp_unflag(){
			if ( ! check_access('employee_unflag'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$this->employee_model->update_emp_unflag();
			$this->session->set_flashdata('msg', 'User successfully unflagged');
			redirect("hr/emp_attendance/flagged_user_list");
			}

}
