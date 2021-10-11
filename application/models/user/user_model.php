<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{

	function get_employee_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_empmastr');
		return $query->row_array();
	}

	function emp_attendance_last_record($emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('date !=', date('Y-m-d'));
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('hr_emp_attendance');
		return $query->row_array();
	}

	function emp_duty_out_flag_status($emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('status', 'F');
		$query = $this->db->get('hr_duty_out_flagged_users');
		return $query->result();
	}

	function employee_flag_for_duty_out($user_id, $attendance_id){
		$data['active_flag'] = 0;

		$this->db->trans_start();
		$this->db->where('USRID', $user_id);
		$this->db->update('cm_userdata', $data);
		$this->db->trans_complete();

		$data1['emp_record_id'] = $user_id;
		$data1['attendance_id'] = $attendance_id;

		$this->db->trans_start();
		$this->db->insert('hr_duty_out_flagged_users', $data1);
		$this->db->trans_complete();
	}

	function get_attendance_details($emp_id){
		date_default_timezone_set('Asia/Colombo');
		$this->db->select('*');
		$this->db->where('date', date('Y-m-d'));
		$this->db->where('emp_record_id', $emp_id);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('hr_emp_attendance');
		return $query->row_array();
	}

	function mark_employee_duty_in($emp_id, $username,$latitute,$longtiute){
		date_default_timezone_set('Asia/Colombo');
		$date = date('Y-m-d');
		$data['emp_record_id'] = $emp_id;
		$data['username'] = $username;
		$data['date'] = $date;
		$duty_in = date('Y-m-d H:i:s');
		$data['duty_in'] = $duty_in;
		$data['duty_in_lati'] = $latitute;
		$data['duty_in_long'] = $longtiute;

		$this->db->trans_start();
		$this->db->insert('hr_emp_attendance', $data);
		$this->db->trans_complete();

		$time = date("H:i:s",strtotime($duty_in));
		$morning_short_leave_start = '08:46:00';
		$morning_short_leave_end = '10:45:00';
		$morning_half_day_leave_start = '10:46:00';
		$morning_half_day_leave_end = '12:45:00';
		if($time >= $morning_short_leave_start && $time <= $morning_short_leave_end){
			$leave_type = "short_leave";
			$check_leaves_for_the_day = $this->check_leaves_for_the_day($leave_type, $date, $emp_id);
			if(count($check_leaves_for_the_day)>0){
				return $check_leaves_for_the_day;
			}else{
				$employee_details = $this->get_employee_details($emp_id);
				if($employee_details['maternity_leave'] == 'N'){
					$mark_leaves_by_attendance = $this->mark_leaves_by_attendance($leave_type, $date, $emp_id);
				}
			}
		}else if($time >= $morning_half_day_leave_start && $time <= $morning_half_day_leave_end){
			$leave_type = "half_day";
			$check_leaves_for_the_day = $this->check_leaves_for_the_day($leave_type, $date, $emp_id);
			if(count($check_leaves_for_the_day)>0){
				return $check_leaves_for_the_day;
			}else{
				$mark_leaves_by_attendance = $this->mark_leaves_by_attendance($leave_type, $date, $emp_id);
			}

		}
	}

	function mark_employee_duty_out($id,$latitute,$longtiute){
		date_default_timezone_set('Asia/Colombo');
		$date = date('Y-m-d');

		$duty_out = date('Y-m-d H:i:s');
		$data['duty_out'] = $duty_out;
		$data['duty_out_lati'] = $latitute;
		$data['duty_out_long'] = $longtiute;

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_attendance', $data);
		$this->db->trans_complete();

		$time = date("H:i:s",strtotime($duty_out));
		$evening_short_leave_start = '15:01:00';
		$evening_short_leave_end = '16:59:00';
		$evening_half_day_leave_start = '13:01:00';
		$evening_half_day_leave_end = '15:00:00';
		$emp_id = $this->session->userdata('userid');
		if($time >= $evening_short_leave_start && $time <= $evening_short_leave_end){
			$leave_type = "short_leave";
			$check_leaves_for_the_day = $this->check_leaves_for_the_day($leave_type, $date, $emp_id);
			if(count($check_leaves_for_the_day)>0){
				return $check_leaves_for_the_day;
			}else{
				$employee_details = $this->get_employee_details($emp_id);
				if($employee_details['maternity_leave'] == 'N'){
					$mark_leaves_by_attendance = $this->mark_leaves_by_attendance($leave_type, $date, $emp_id);
				}
			}
		}else if($time >= $evening_half_day_leave_start && $time <= $evening_half_day_leave_end){
			$leave_type = "half_day";
			$check_leaves_for_the_day = $this->check_leaves_for_the_day($leave_type, $date, $emp_id);
			if(count($check_leaves_for_the_day)>0){
				return $check_leaves_for_the_day;
			}else{
				$mark_leaves_by_attendance = $this->mark_leaves_by_attendance($leave_type, $date, $emp_id);
			}
		}
		$mark_leaves_by_go_out_go_in = $this->mark_leaves_by_go_out_go_in($duty_out, $emp_id);
	}

	function check_leaves_for_the_day($leave_type, $date, $emp_id){
		if($leave_type == "half_day"){
			$leave_duration = 0.5;
		}else if($leave_type == "short_leave"){
			$leave_duration = 0.25;
		}
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('start_date', $date);
		$this->db->where('no_of_days', $leave_duration);
		$this->db->where('approval', 'A');
		$this->db->where('active_record', 'Y');
		$query = $this->db->get('hr_emp_leave_records');
		return $query->row_array();
	}

	function mark_leaves_by_attendance($leave_type, $date, $emp_id){
		date_default_timezone_set('Asia/Colombo');

		if($leave_type == "half_day"){
			$leave_duration = 0.5;
			$leave_reason = "Half Day";
		}else if($leave_type == "short_leave"){
			$leave_duration = 0.25;
			$leave_reason = "Short Leave";
		}

		$this->db->select('*');
		$this->db->where('status !=', 'D');
		$this->db->where('id', $emp_id);
		$query = $this->db->get('hr_empmastr');
		$employee_details = $query->row_array();

		$leave_category_id = $employee_details['leave_category'];

		$leave_category_details = $this->get_leave_category_details($leave_category_id);
		$active_user_leave_records = $this->get_user_active_leave_records($emp_id);

		$annual_leave_count = 0;
		$cassual_leave_count = 0;

		$entitled_annual_leave = $leave_category_details['annual_leave'];
		$entitled_cassual_leave  = $leave_category_details['cassual_leave'];

		if(count($active_user_leave_records)>0){
			foreach($active_user_leave_records as $user_leave_record){
				if($user_leave_record->approval == "A" && $user_leave_record->active_record == "Y"){
					if($user_leave_record->leave_type == "annual"){
						$annual_leave_count = $annual_leave_count + $user_leave_record->no_of_days;
					}else if($user_leave_record->leave_type == "cassual"){
						$cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
					}
				}
			}
		}

		if(($annual_leave_count + $leave_duration) < $entitled_annual_leave){
			$data['leave_type'] = "annual";
		}else if(($cassual_leave_count + $leave_duration) < $entitled_cassual_leave){
			$data['leave_type'] = "cassual";
		}else{
			$data['leave_type'] = "no_pay";
			$data['no_pay_status'] = "Y";
			$data['no_pay_days'] = $leave_duration;
		}

		$data['emp_record_id'] = $emp_id;
		$start_end_date = strtotime($date);
		$data['start_date'] = date('Y-m-d', $start_end_date);
		$data['end_date'] = date('Y-m-d', $start_end_date);
		$data['no_of_days'] = $leave_duration;
		$data['reason'] = $leave_reason;
		$data['approval'] = "A";
		$data['active_record'] = "Y";
		$data['created'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->insert('hr_emp_leave_records', $data);
		$this->db->trans_complete();
	}

	function mark_leaves_by_go_out_go_in($date_time, $emp_id){
		date_default_timezone_set('Asia/Colombo');
		$date = date('Y-m-d', strtotime($date_time));

		$this->db->select('*');
		$this->db->where('date', $date);
		$this->db->where('emp_record_id', $emp_id);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query_last_row = $this->db->get('hr_emp_go_in_out_attendance');
		$query_last_row = $query_last_row->row_array();

		if(count($query_last_row)>0){
			$go_in = $query_last_row['go_in'];
			$id = $query_last_row['id'];
			if(empty($go_in)){
				$go_in['go_in'] = $date_time;
				$this->db->trans_start();
				$this->db->where('id', $id);
				$this->db->update('hr_emp_go_in_out_attendance', $go_in);
				$this->db->trans_complete();
			}
		}

		$this->db->select('*');
		$this->db->where('date', $date);
		$this->db->where('emp_record_id', $emp_id);
		$query = $this->db->get('hr_emp_go_in_out_attendance');
		$result = $query->result();

		if(count($result)>0){
			$time_difference_total = 0;
			foreach($result as $result_row){
				$time_difference = 0;
				$go_in_time = $result_row->go_in;
				$go_in_time = strtotime($go_in_time);
				$go_out_time = $result_row->go_out;;
				$go_out_time = strtotime($go_out_time);
				$time_difference = $go_in_time - $go_out_time;
				$time_difference_total = $time_difference_total + $time_difference;
			}
			$time_difference_total = $time_difference_total/60;
			if($time_difference_total >= 240){
				$leave_duration = 0.5;
				$leave_reason = "Half Day";
			}else if($time_difference_total >= 120){
				$leave_duration = 0.25;
				$leave_reason = "Short Leave";
			}
			if($time_difference_total >= 120){
				$this->db->select('*');
				$this->db->where('status !=', 'D');
				$this->db->where('id', $emp_id);
				$query = $this->db->get('hr_empmastr');
				$employee_details = $query->row_array();

				$leave_category_id = $employee_details['leave_category'];

				$leave_category_details = $this->get_leave_category_details($leave_category_id);
				$active_user_leave_records = $this->get_user_active_leave_records($emp_id);

				$annual_leave_count = 0;
				$cassual_leave_count = 0;

				$entitled_annual_leave = $leave_category_details['annual_leave'];
				$entitled_cassual_leave  = $leave_category_details['cassual_leave'];

				if(count($active_user_leave_records)>0){
					foreach($active_user_leave_records as $user_leave_record){
						if($user_leave_record->approval == "A" && $user_leave_record->active_record == "Y"){
							if($user_leave_record->leave_type == "annual"){
								$annual_leave_count = $annual_leave_count + $user_leave_record->no_of_days;
							}else if($user_leave_record->leave_type == "cassual"){
								$cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
							}
						}
					}
				}

				if(($annual_leave_count + $leave_duration) < $entitled_annual_leave){
					$data['leave_type'] = "annual";
				}else if(($cassual_leave_count + $leave_duration) < $entitled_cassual_leave){
					$data['leave_type'] = "cassual";
				}else{
					$data['leave_type'] = "no_pay";
					$data['no_pay_status'] = "Y";
					$data['no_pay_days'] = $leave_duration;
				}

				$data['emp_record_id'] = $emp_id;
				$start_end_date = strtotime($date_time);
				$data['start_date'] = date('Y-m-d', $start_end_date);
				$data['end_date'] = date('Y-m-d', $start_end_date);
				$data['no_of_days'] = $leave_duration;
				$data['reason'] = $leave_reason;
				$data['approval'] = "A";
				$data['active_record'] = "Y";
				$data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_leave_records', $data);
				$this->db->trans_complete();
			}
		}
	}

	function get_go_in_out_attendance_details($emp_id){
		date_default_timezone_set('Asia/Colombo');
		$this->db->select('*');
		$this->db->where('date', date('Y-m-d'));
		$this->db->where('emp_record_id', $emp_id);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('hr_emp_go_in_out_attendance');
		return $query->row_array();
	}

	function mark_employee_go_out($emp_id, $username){
		date_default_timezone_set('Asia/Colombo');
		$data['emp_record_id'] = $emp_id;
		$data['username'] = $username;
		$data['date'] = date('Y-m-d');

		$this->db->trans_start();
		$this->db->insert('hr_emp_go_in_out_attendance', $data);
		$this->db->trans_complete();
	}

	function mark_employee_go_in($id){
		date_default_timezone_set('Asia/Colombo');
		$data['go_in'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_go_in_out_attendance', $data);
		$this->db->trans_complete();
	}

	function get_leave_category_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_leave_categories');
		return $query->row_array();
	}

	function get_user_active_leave_records($emp_id){
		$this->db->select('*');
		$this->db->where('active_record !=', 'N');
		$this->db->where('emp_record_id', $emp_id);
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function leave_submit(){
		date_default_timezone_set('Asia/Colombo');
		$emp_id = $this->input->post('emp_id', TRUE);
		$leave_type = $this->input->post('leave_type', TRUE);
		$start_date = $this->input->post('start_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		//added by nadee 2018-08-27
		$system_record="N";
		$this->db->select('id');
		$this->db->where("emp_record_id",$emp_id);
		$this->db->where("start_date >= ",$start_date);
		$this->db->where("start_date <= ",$end_date);
		$query = $this->db->get('hr_emp_leave_records_pending');
		if ($query->num_rows()> 0){
			$system_record="Y";
			$result=$query->result();
			foreach ($result as $key => $value) {
				$this->db->trans_start();
				$this->db->where('id', $value->id);
				$this->db->delete('hr_emp_leave_records_pending');
				$this->db->trans_complete();
			}
		}
		//added by nadee end
		if($leave_type != "half_day" && $leave_type != "short_leave"){
			$data['emp_record_id'] = $emp_id;
			$data['leave_type'] = $this->input->post('leave_type', TRUE);
			$start_date = $this->input->post('start_date', TRUE);
			$data['start_date'] = date('Y-m-d', strtotime($start_date));
			$end_date = $this->input->post('end_date', TRUE);
			$data['end_date'] = date('Y-m-d', strtotime($end_date));
			$data['no_of_days'] = $this->input->post('no_of_days', TRUE);
			$data['officer_in_charge'] = $this->input->post('officer_in_charge', TRUE);
			$data['approval']='W';
			$data['reason'] = $this->input->post('reason', TRUE);
			$data['created'] = date('Y-m-d H:i:s');
			$data['sytem_record']=$system_record;

			$this->db->trans_start();
			$this->db->insert('hr_emp_leave_records', $data);
			$this->db->trans_complete();
		}else{
			if($leave_type == "half_day"){
				$leave_duration = 0.5;
				$leave_reason = "Half Day";
			}else if($leave_type == "short_leave"){
				$leave_duration = 0.25;
				$leave_reason = "Short Leave";
			}

			$this->db->select('*');
			$this->db->where('id', $emp_id);
			$query = $this->db->get('hr_empmastr');
			$employee_details = $query->row_array();

			$leave_category_id = $employee_details['leave_category'];
			$leave_category_details = $this->get_leave_category_details($leave_category_id);
			$active_user_leave_records = $this->get_user_active_leave_records($emp_id);

			$annual_leave_count = 0;
			$cassual_leave_count = 0;

			$entitled_annual_leave = $leave_category_details['annual_leave'];
			$entitled_cassual_leave  = $leave_category_details['cassual_leave'];

			if(count($active_user_leave_records)>0){
				foreach($active_user_leave_records as $user_leave_record){
					if($user_leave_record->approval == "A" && $user_leave_record->active_record == "Y"){
						if($user_leave_record->leave_type == "annual"){
							$annual_leave_count = $annual_leave_count + $user_leave_record->no_of_days;
						}else if($user_leave_record->leave_type == "cassual"){
							$cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
						}
					}
				}
			}

			if(($annual_leave_count + $leave_duration) < $entitled_annual_leave){
				$data1['leave_type'] = "annual";
			}else if(($cassual_leave_count + $leave_duration) < $entitled_cassual_leave){
				$data1['leave_type'] = "cassual";
			}else{
				$data1['leave_type'] = "no_pay";
				$data1['no_pay_status'] = "Y";
				$data1['no_pay_days'] = $leave_duration;
			}

			$data1['emp_record_id'] = $emp_id;
			$start_date = $this->input->post('start_date', TRUE);
			$start_date = strtotime($start_date);
			$data1['start_date'] = date('Y-m-d', $start_date);
			$end_date = $this->input->post('end_date', TRUE);
			$end_date = strtotime($end_date);
			$data1['end_date'] = date('Y-m-d', $end_date);
			$data1['no_of_days'] = $leave_duration;
			$data1['officer_in_charge'] = $this->input->post('officer_in_charge', TRUE);
			$data1['approval']='W';
			$data1['reason'] = $this->input->post('reason', TRUE);
			$data1['created'] = date('Y-m-d H:i:s');
			$data1['sytem_record']=$system_record;

			$this->db->trans_start();
			$this->db->insert('hr_emp_leave_records', $data1);
			$this->db->trans_complete();
		}

	}

	function get_all_emp_leave_records($pagination_counter, $page_count, $emp_id){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function check_immediate_manager($emp_id){
		$this->db->select('*');
		$this->db->where('status !=', 'D');
		$this->db->where('immediate_manager_1', $emp_id)->or_where('immediate_manager_2', $emp_id);
		$this->db->order_by('epf_no');
		$query = $this->db->get('hr_empmastr');
		return $query->result();
	}

	function get_team_employees($branch, $division){
		$this->db->select('*');
		$this->db->where('status !=', 'D');
		$this->db->where('branch', $branch);
		$this->db->where_in('division', $division['division']);
		$this->db->order_by('epf_no');

		$query = $this->db->get('hr_empmastr');
		//		echo $this->db->last_query();
		//		die;
		return $query->result();
	}

	function get_team_employees_leave_records($employee_list){
		$this->db->select('*');
		$this->db->where_in('emp_record_id', $employee_list['employee_id']);
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function get_all_get_team_employees_leave_records($pagination_counter, $page_count, $employee_list){
		$this->db->select('*');
		//$this->db->order_by('id', 'desc');
		$this->db->order_by('start_date','desc');
		$this->db->where_in('emp_record_id', $employee_list['employee_id']);
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function get_team_employees_leave_records_for_notificaton(){
		$userid = $this->session->userdata('userid');

		$team_employees_details = $this->check_immediate_manager($userid);

		$j = 0;
		$employee_list = array();
		foreach($team_employees_details as $team_employee){
			$employee_list['employee_id'][$j] = $team_employee->id;
			$j++;
		}
		if(count($employee_list)>0){
			$this->db->select('*');
			$this->db->where_in('emp_record_id', $employee_list['employee_id']);
			$this->db->where('approval', 'P');
			$query = $this->db->get('hr_emp_leave_records');
			$team_employees_leave_records = $query->result();
		}else{
			$team_employees_leave_records = null;
		}

		return $team_employees_leave_records;
	}

	function user_leave_confirm($record_id){

		$this->db->select('*');
		$this->db->where('id', $record_id);
		$query = $this->db->get('hr_emp_leave_records');
		$active_leave_details = $query->row_array();

		$emp_id = $_REQUEST['emp_id'];

		$this->db->select('*');
		$this->db->where('status !=', 'D');
		$this->db->where('id', $emp_id);
		$query = $this->db->get('hr_empmastr');
		$employee_details = $query->row_array();

		$leave_category_id = $employee_details['leave_category'];

		$leave_category_details = $this->get_leave_category_details($leave_category_id);
		$active_user_leave_records = $this->get_user_active_leave_records($emp_id);

		$annual_leave_count = 0;
		$cassual_leave_count = 0;
		$sick_leave_count = 0;

		$entitled_annual_leave = $leave_category_details['annual_leave'];
		$entitled_cassual_leave  = $leave_category_details['cassual_leave'];
		$entitled_sick_leave = $leave_category_details['sick_leave'];

		if(count($active_user_leave_records)>0){
			foreach($active_user_leave_records as $user_leave_record){
				if($user_leave_record->approval == "A" && $user_leave_record->active_record == "Y"){
					if($user_leave_record->leave_type == "annual"){
						$annual_leave_count = $annual_leave_count + $user_leave_record->no_of_days;
					}else if($user_leave_record->leave_type == "cassual"){
						$cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
					}else if($user_leave_record->leave_type == "sick"){
						$sick_leave_count = $sick_leave_count + $user_leave_record->no_of_days;
					}
				}
			}
		}


		if($active_leave_details['leave_type'] == "annual"){
			if($annual_leave_count >= $entitled_annual_leave){
				$data['no_pay_status'] = "Y";
				$data['no_pay_days'] = $active_leave_details['no_of_days'];
			}else if($annual_leave_count < $entitled_annual_leave){
				if(($annual_leave_count + $active_leave_details['no_of_days']) > $entitled_annual_leave){
					$no_pay_days = ($annual_leave_count + $active_leave_details['no_of_days']) - $entitled_annual_leave;
					$data['no_pay_status'] = "Y";
					$data['no_pay_days'] = $no_pay_days;
				}
			}
		}else if($active_leave_details['leave_type'] == "cassual"){

			if($cassual_leave_count >= $entitled_cassual_leave){
				$data['no_pay_status'] = "Y";
				$data['no_pay_days'] = $active_leave_details['no_of_days'];
			}else if($cassual_leave_count < $entitled_cassual_leave){

				if(($cassual_leave_count + $active_leave_details['no_of_days']) > $entitled_cassual_leave){
					$no_pay_days = ($cassual_leave_count + $active_leave_details['no_of_days']) - $entitled_cassual_leave;
					$data['no_pay_status'] = "Y";
					$data['no_pay_days'] = $no_pay_days;
				}
			}
		}else if($active_leave_details['leave_type'] == "sick"){
			if($sick_leave_count >= $entitled_sick_leave){
				$data['no_pay_status'] = "Y";
				$data['no_pay_days'] = $active_leave_details['no_of_days'];
			}else if($sick_leave_count < $entitled_sick_leave){
				if(($sick_leave_count  + $active_leave_details['no_of_days']) > $entitled_sick_leave){
					$no_pay_days = ($sick_leave_count + $active_leave_details['no_of_days']) - $entitled_sick_leave;
					$data['no_pay_status'] = "Y";
					$data['no_pay_days'] = $no_pay_days;
				}
			}
		}else if($active_leave_details['leave_type'] == "no_pay"){
			$data['no_pay_status'] = "Y";
			$data['no_pay_days'] = $active_leave_details['no_of_days'];
		}

		$data['approval_by'] = $this->session->userdata('username');
		$data['approval'] = "A";
		$data['active_record'] = "Y";
		$this->db->trans_start();
		$this->db->where('id', $record_id);
		$this->db->update('hr_emp_leave_records', $data);
		$this->db->trans_complete();

	}

	function decline_user_leave($id){
		$data['approval'] = "D";
		$data['approval_by'] = $this->session->userdata('username');
		$data['active_record'] = "Y";

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_leave_records', $data);
		$this->db->trans_complete();
	}

	function validate_current_password($emp_id){
		$this->db->select('*');
		$this->db->where('USRID', $emp_id);
		$query = $this->db->get('cm_userdata');
		return $query->row_array();
	}

	function reset_password($emp_id){
		date_default_timezone_set('Asia/Colombo');
		$new_password = $this->input->post('new_password', TRUE);
		$new_password = $this->encryption->encode($new_password);
		$data['USRPW'] = $new_password;
		$data['ATTEMPT'] = 0;
		$effectiveDate = date('Y-m-d');
		$effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($effectiveDate)));
		$data['EXPDATE'] = $effectiveDate;
		$data['active_flag'] = 1;

		$this->db->trans_start();
		$this->db->where('USRID', $emp_id);
		$this->db->update('cm_userdata', $data);
		$this->db->trans_complete();
	}

	function validate_password_attempts($user_name){
		$this->db->select('*');
		$this->db->where('USRNAME', $user_name);
		$query = $this->db->get('cm_userdata');
		$query = $query->row_array();

		if($query['ATTEMPT'] == 2){
			$data['active_flag'] = 0;
			$this->db->set('ATTEMPT', 'ATTEMPT+1', FALSE);
			$this->db->trans_start();
			$this->db->where('USRNAME', $user_name);
			$this->db->update('cm_userdata', $data);
			$this->db->trans_complete();
		}else{
			$this->db->set('ATTEMPT', 'ATTEMPT+1', FALSE);
			$this->db->trans_start();
			$this->db->where('USRNAME', $user_name);
			$this->db->update('cm_userdata');
			$this->db->trans_complete();
		}
	}

	function reset_login_attempt_count($userid){
		$data['ATTEMPT'] = 0;

		$this->db->trans_start();
		$this->db->where('USRID', $userid);
		$this->db->update('cm_userdata', $data);
		$this->db->trans_complete();
	}

	function validate_user_by_user_name($user_name){
		$this->db->select('*');
		$this->db->where('USRNAME', $user_name);
		$query = $this->db->get('cm_userdata');
		return $query->row_array();
	}

	function get_user_meter_reading_last_record($emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('end_reading !=', 'NULL');
		$this->db->order_by('id',"desc")->limit(1);
		$query = $this->db->get('hr_emp_meter_reading');
		return $query->row_array();
	}

	function get_fuel_allowance_rate($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_fuel_allowance_rates');
		return $query->row_array();
	}

	function get_fuel_allowance_rate_updates($id,$date){
		$this->db->select('hr_fuel_allowance_rates_updates.id,
		hr_fuel_allowance_rates_updates.vehicle_type,
		hr_fuel_allowance_rates_updates.rate_per_km,
		hr_fuel_allowance_rates_updates.start_date,
		hr_fuel_allowance_rates_updates.to_date,
		hr_fuel_allowance_rates_updates.updated_by,
		hr_fuel_allowance_rates_updates.last_updated');
		$this->db->where('hr_fuel_allowance_rates_updates.vehicle_type', $id);
		$this->db->where('hr_fuel_allowance_rates_updates.start_date <= ',$date);
		$this->db->where('hr_fuel_allowance_rates_updates.to_date >= ',$date);
		$query = $this->db->get('hr_fuel_allowance_rates_updates');
		return $query->row_array();
	}

	function meter_reading_submit(){
		date_default_timezone_set('Asia/Colombo');
		$emp_id = $this->input->post('emp_id', TRUE);

		$data['emp_record_id'] = $emp_id;
		$data['date'] = date('Y-m-d');
		$effective_date = $this->input->post('effective_date', TRUE);
		$data['effective_date'] = date('Y-m-d', strtotime($effective_date));
		$data['start_reading'] = $this->input->post('start_reading', TRUE);
		$data['end_reading'] = $this->input->post('end_reading', TRUE);
		$data['difference'] = $this->input->post('difference', TRUE);
		$data['private'] = $this->input->post('private', TRUE);
		$data['official'] = $this->input->post('official', TRUE);
		$amount = $this->input->post('amount', TRUE);
		$amount = round($amount, 2);
		$data['amount'] = $amount;
		$exceed_status = $this->input->post('exceed_status', TRUE);
		$data['exceed_status'] = $exceed_status;
		if($exceed_status == "Y"){
			$data['exceeded_amount'] = $this->input->post('exceeded_amount', TRUE);
		}
		$data['location1'] = $this->input->post('location1', TRUE);
		$data['description1'] = $this->input->post('description1', TRUE);
		$data['location2'] = $this->input->post('location2', TRUE);
		$data['description2'] = $this->input->post('description2', TRUE);
		$data['location3'] = $this->input->post('location3', TRUE);
		$data['description3'] = $this->input->post('description3', TRUE);
		$data['location4'] = $this->input->post('location4', TRUE);
		$data['description4'] = $this->input->post('description4', TRUE);
		$data['location5'] = $this->input->post('location5', TRUE);
		$data['description5'] = $this->input->post('description5', TRUE);
		$data['created'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->insert('hr_emp_meter_reading', $data);
		$this->db->trans_complete();
	}

	function submit_additional_fuel_request(){
		date_default_timezone_set('Asia/Colombo');
		$data['emp_record_id'] = $this->input->post('emp_id', TRUE);;
		$data['requested_amount'] = $this->input->post('requested_amount', TRUE);;
		$data['date'] = date('Y-m-d');

		$this->db->trans_start();
		$this->db->insert('hr_emp_fuel_allowance_additional', $data);
		$this->db->trans_complete();
	}

	function get_fuel_allowance_additional($emp_id){
		date_default_timezone_set('Asia/Colombo');
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('MONTH(date)', date('m'));
		$this->db->where('YEAR(date)', date('Y'));
		$this->db->where('status', 'Y');
		$query = $this->db->get('hr_emp_fuel_allowance_additional');
		return $query->result();
	}

	function get_user_meter_reading_for_month($emp_id){
		date_default_timezone_set('Asia/Colombo');
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('MONTH(effective_date)', date('m'));
		$this->db->where('YEAR(effective_date)', date('Y'));
		$query = $this->db->get('hr_emp_meter_reading');
		return $query->result();
	}

	// add by nadee
	function check_officer_in_charge($emp_id){
		$this->db->select('emp_record_id');
		$this->db->where('officer_in_charge', $emp_id);
		$this->db->where('approval', 'W');
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function get_all_team_employees_leave_records($employee_list){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->where_in('emp_record_id', $employee_list['employee_id']);
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}
	function user_oic_confirm($id)
	{
		$data['office_approval_by'] = $this->session->userdata('username');
		$data['approval'] = "P";
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_leave_records', $data);
		$this->db->trans_complete();
	}

	function get_oic_records_for_notificaton($userid){
		//$userid = $this->session->userdata('userid');

		$team_employees_details = $this->check_officer_in_charge($userid);

		$j = 0;
		$employee_list = array();
		foreach($team_employees_details as $team_employee){
			$employee_list['employee_id'][$j] = $team_employee->emp_record_id;
			$j++;
		}
		if(count($employee_list)>0){
			$this->db->select('*');
			$this->db->where_in('emp_record_id', $employee_list['employee_id']);
			$this->db->where('approval', 'W');
			$query = $this->db->get('hr_emp_leave_records');
			$team_employees_leave_records = $query->result();
		}else{
			$team_employees_leave_records = null;
		}

		return $team_employees_leave_records;
	}

	function get_system_pending_leave_records($userid){
		$this->db->select('*');
		$this->db->order_by('start_date', 'desc');
		$this->db->where_in('emp_record_id', $userid);
		$query = $this->db->get('hr_emp_leave_records_pending');
		return $query->result();
	}
	function check_pending_system_leave()
	{
		$emp_id = $this->input->post('emp_id', TRUE);
		$start_date = $this->input->post('start_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		$this->db->select('id');
		$this->db->where("emp_record_id",$emp_id);
		$this->db->where("start_date >= ",$start_date);
		$this->db->where("start_date <= ",$end_date);
		$query = $this->db->get('hr_emp_leave_records_pending');
		if ($query->num_rows()> 0){
			return "allow_leave_apply";
		}else{
			$this->db->select('id');
			$this->db->where("emp_record_id",$emp_id);
			$query = $this->db->get('hr_emp_leave_records_pending');
			if ($query->num_rows()<= 0){
				return "allow_leave_apply";
			}else{
				return false;
			}

		}
	}
	function check_pending_leave()
	{
		$emp_id = $this->input->post('emp_id', TRUE);
		$start_date = $this->input->post('start_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		$this->db->select('id');
		$this->db->where("emp_record_id",$emp_id);
		$this->db->where('hr_emp_leave_records.start_date >=',$start_date);
		$this->db->where('hr_emp_leave_records.start_date <=',$end_date);
		$this->db->where_in('hr_emp_leave_records.approval', array('A','P','W'));
		$query = $this->db->get('hr_emp_leave_records');
		if ($query->num_rows()> 0 ){
			return "have_pending_leave";

		}else{
				return "allow_leave_apply";
			}
	}

	function reset_password_resetrequests($userid){

		//remove all password reset notification for this user
		$this->db->where('record_key',$userid)->where('table_name','cm_passwordreset');
		$this->db->delete('cm_notification');

		$this->db->where('USRID',$userid);
		$this->db->delete('cm_passwordreset');
	}

	function get_allpassword_reset_requests(){
		$this->db->select('hr_empmastr.id,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('cm_passwordreset','cm_passwordreset.USRID = hr_empmastr.id');
		$query = $this->db->get('hr_empmastr');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

}
?>
