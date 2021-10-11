<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model{

	public function add_employee(){

		$this->db->trans_start();
		$this->db->select('emp_no');
		$this->db->where('id >','0');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('hr_empmastr');
		$this->db->trans_complete();

		$data_last_record = $query->row_array();
		if(!isset($data_last_record['emp_no'])){
			$last_emp_no = "";
			$new_emp_no = 0;
		}else{
			$last_emp_no = $data_last_record['emp_no'];
			$pieces = explode("-", $last_emp_no);
			$new_emp_no = $pieces[1];
		}

		$new_emp_no = $new_emp_no+1;
		$emp_code = "EMP";
		$noofstring = strlen($new_emp_no);
		if($noofstring == 1){
			$new_emp_no = "00".$new_emp_no;
		}else if($noofstring == 2){
			$new_emp_no = "0".$new_emp_no;
		}else{
			$new_emp_no = $new_emp_no;
		}
		$emp_no = $emp_code.'-'.$new_emp_no;

		if(!empty($_FILES['profile_pic']['name'])){
			$restlarge = "ProPic".date("YmdHis");
			$imagelarge = $this->do_uploadfile($restlarge,'profile_pic');
			if(!empty($imagelarge['upload_data']['file_name'])){
				$profile_pic = $imagelarge['upload_data']['file_name'];
				$data['profile_pic'] = $profile_pic;
			}else{
				$this->session->set_flashdata('error',$imagelarge['upload_data_failed']);
			}
		}

		$data['emp_no'] = $this->input->post('emp_no',TRUE); //Ticket No-2502 | Added By Uvini
		$data['title'] = $this->input->post('title', TRUE);
		$data['initial'] = strtoupper($this->input->post('initials', TRUE));
		$data['surname'] = $this->input->post('surname', TRUE);
		$data['initials_full'] = $this->input->post('inifull', TRUE);
		$data['display_name'] = $this->input->post('system_dis_name', TRUE);
		//Ticket No-2877 | Added By Uvini
		$data['app_permission'] = $this->input->post('app_permission', TRUE);
		$data['nationality'] = $this->input->post('nationality', TRUE);
		$data['living_status'] = $this->input->post('martialStatus', TRUE);
		$data['religion'] = $this->input->post('religion', TRUE);
		$data['race'] = $this->input->post('race', TRUE);
		$data['nic_no'] = $this->input->post('nic', TRUE);
		$data['passport_no'] = $this->input->post('passport_no', TRUE);
		$data['driving_license_no'] = $this->input->post('driving_lic', TRUE);
		$data['blood_group'] = $this->input->post('blood_group', TRUE);
		$old_date = $this->input->post('employeeDoB', TRUE);
		$data['dob'] = date('Y-m-d', strtotime($old_date));
		$data['employment_type'] = $this->input->post('employment_type', TRUE);
		$joining_date = $this->input->post('emp_joining_date', TRUE);
		$data['joining_date'] = date('Y-m-d', strtotime($joining_date));
		$data['gender'] = $this->input->post('gender', TRUE);//ticket no 2839
		$duration = $this->input->post('duration', TRUE);
		if($duration != ""){
			$duration = $this->input->post('duration', TRUE);
		}else if($duration == ""){
			$duration = null;
		}
		$data['duration'] = $duration;
		$data['epf_no'] = $this->input->post('epf_no', TRUE);
		$data['designation'] = $this->input->post('designation', TRUE);
		$data['branch'] = $this->input->post('branch', TRUE);
		$data['division'] = $this->input->post('division', TRUE);
		$data['leave_category'] = $this->input->post('leave_category', TRUE);
		$data['working_days_per_week'] = $this->input->post('employment_working_days', TRUE);
		$data['maternity_leave'] = $this->input->post('maternity_leave', TRUE);
		$data['immediate_manager_1'] = $this->input->post('immediate_manager_1', TRUE);
		$data['immediate_manager_2'] = $this->input->post('immediate_manager_2', TRUE);
		$data['attendance_type'] = $this->input->post('attendance_type', TRUE);
		$fuel_allowance_status = $this->input->post('fuel_allowance_status', TRUE);
		$data['fuel_allowance_status'] = $fuel_allowance_status;
		if($fuel_allowance_status == "Y"){
			$data['vehicle_type'] = $this->input->post('vehicle_type', TRUE);
			$data['initial_meter_reading'] = $this->input->post('initial_meter_reading', TRUE);
			$data['fuel_allowance_maximum_limit'] = $this->input->post('fuel_allowance_maximum_limit', TRUE);
		}else{
			$data['vehicle_type'] = NULL;
			$data['initial_meter_reading'] = NULL;
			$data['fuel_allowance_maximum_limit'] = NULL;
		}
		$data['user_privilege'] = $this->input->post('user_privilege', TRUE);
		$data['tel_mob'] = $this->input->post('emp_mobile', TRUE);
		$data['tel_home'] = $this->input->post('emp_tel', TRUE);
		$data['email'] = $this->input->post('userEmail', TRUE);
		$data['office_tel'] = $this->input->post('emp_office_tel', TRUE);
		$data['office_mobile'] = $this->input->post('emp_office_mobile', TRUE);
		$data['office_email'] = $this->input->post('office_email', TRUE);
		$data['addr1'] = $this->input->post('address1', TRUE);
		$data['addr2'] = $this->input->post('address2', TRUE);
		$data['town'] = $this->input->post('town', TRUE);
		$data['province'] = $this->input->post('province', TRUE);
		$data['phone_bill']= $this->input->post('emp_phone_charges', TRUE);
		$data['contrat_start_date']= $this->input->post('contrac_start_date', TRUE);
		$data['contrat_end_date']= $this->input->post('contrac_end_date', TRUE);
		$this->db->trans_start();
		$this->db->insert('hr_empmastr', $data);
		$employeeMasterID = $this->db->insert_id();
		$this->db->trans_complete();



		$log['emp_record_id'] = $employeeMasterID;
		$log['activity'] = "Employee Created";
		$log['relevant_table'] = "hr_empmastr";
		$log['record_id'] = $employeeMasterID;
		$this->db->trans_start();
		$this->db->insert('hr_emp_log', $log);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $employeeMasterID;
		}
	}

	/*2019-10-09 nadee function added*/
	function add_employee_otherdata()
	{
		$employeeMasterID=$this->input->post('employeeMasterID', TRUE);

		$data1['emp_record_id'] = $employeeMasterID;
		$data1['person_name'] = $this->input->post('name_emg_person', TRUE);
		$data1['relationship'] = $this->input->post('relationship_emg', TRUE);
		$data1['tel_home'] = $this->input->post('contact_tel_emg', TRUE);
		$data1['tel_mobile'] = $this->input->post('contact_mob_emg', TRUE);
		$data1['add_1'] = $this->input->post('addr1_emg', TRUE);
		$data1['addr_2'] = $this->input->post('addr2_emg', TRUE);
		$data1['town'] = $this->input->post('town_emg', TRUE);
		$this->db->trans_start();
		$check=$this->checktable('hr_emergcnt','emp_record_id',$employeeMasterID);
		/*check employee data already exit */
		if($check==true){
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->update('hr_emergcnt', $data1);
		}else{
			$this->db->insert('hr_emergcnt', $data1);
		}
		$this->db->trans_complete();

		$data2['emp_record_id'] = $employeeMasterID;
		$data2['name_in_account'] = $this->input->post('bank_given_name', TRUE);
		$data2['bank_name'] = $this->input->post('bank_name', TRUE);
		$data2['bank_code'] = $this->input->post('bank_code', TRUE);
		$data2['branch_name'] = $this->input->post('bank_branch_name', TRUE);
		$data2['branch_code'] = $this->input->post('bank_branch', TRUE);
		$data2['account_no'] = $this->input->post('account_no', TRUE);
		$data2['account_type'] = $this->input->post('account_type', TRUE);
		$this->db->trans_start();
		$check=$this->checktable('hr_bankdtls','emp_record_id',$employeeMasterID);
		/*check employee data already exit */
		if($check==true){
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->update('hr_bankdtls', $data2);
		}else{
			$this->db->insert('hr_bankdtls', $data2);
		}

		$this->db->trans_complete();

		$data3['emp_record_id'] = $employeeMasterID;
		$data3['company_name'] = $this->input->post('insCompany', TRUE);
		$data3['shcheme_name '] = $this->input->post('insScheme', TRUE);
		$data3['policy_no'] = $this->input->post('policynumber', TRUE);
		$this->db->trans_start();
		$check=$this->checktable('hr_insurnce','emp_record_id',$employeeMasterID);
		/*check employee data already exit */
		if($check==true){
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->update('hr_insurnce', $data3);
		}else{
			$this->db->insert('hr_insurnce', $data3);
		}

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $employeeMasterID;
		}
	}
	function update_edudatasubmit($data_set)
	{
		$employeeMasterID=$this->input->post('employeeMasterID', TRUE);
		$data4['emp_record_id'] = $employeeMasterID;
		$data4['school'] = $this->input->post('olschoolname', TRUE);
		$check=$this->checktable('hr_olresults','emp_record_id',$employeeMasterID);
		/*check employee data already exit */

		if(!empty($_FILES['oldocument']['name']))
		{
			$config['upload_path'] = './uploads/documents/OL';
			$config['allowed_types'] = '*';
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if(!($this->upload->do_upload('oldocument')))
			{

				echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
			}
			else
			{
				$dataol = $this->upload->data();
				$data4['document'] = base_url().'uploads/documents/OL/'.$dataol['file_name'];
			}
		}

		foreach($data_set['ordinary_level'] as $key=>$value){
			$subject_trim = trim($value['subject']);
			$grade_trim = trim($value['grade']);
			if(empty($subject_trim) || empty($grade_trim)){
					unset($data_set['ordinary_level'][$key]);//remove empty ol fields
				}
			}
			if(sizeof($data_set['ordinary_level']) > 0){
				$data_set['ordinary_level'] = array_values($data_set['ordinary_level']);
				$data4['result'] = serialize($data_set['ordinary_level']);


				$this->db->trans_start();
				if($check==true){
					$this->db->where('emp_record_id', $employeeMasterID);
					$this->db->update('hr_olresults', $data4);
				}else{
					$this->db->insert('hr_olresults', $data4);
				}
				$this->db->trans_complete();

			}elseif ($check==true) {
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->delete('hr_olresults');
			}



			$data5['emp_record_id'] = $employeeMasterID;
			$data5['school'] = $this->input->post('alschoolname', TRUE);
			$check=$this->checktable('hr_alresults','emp_record_id',$employeeMasterID);
			/*check employee data already exit */

			if(!empty($_FILES['aldocument']['name']))
		{
			$config['upload_path'] = './uploads/documents/AL';
			$config['allowed_types'] = '*';
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if(!($this->upload->do_upload('aldocument')))
			{

				echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
			}
			else
			{
				$dataal = $this->upload->data();
				$data5['document'] = base_url().'uploads/documents/AL/'.$dataal['file_name'];
			}
		}

			foreach($data_set['advance_level'] as $key=>$value){
				$subject_trim = trim($value['subject']);
				$grade_trim = trim($value['grade']);
				if(empty($subject_trim) || empty($grade_trim)){
					unset($data_set['advance_level'][$key]);//remove empty ol fields
				}
			}
			if(sizeof($data_set['advance_level']) > 0){
				$data_set['advance_level'] = array_values($data_set['advance_level']);
				$data5['result'] = serialize($data_set['advance_level']);
				$this->db->trans_start();
				if($check==true){
					$this->db->where('emp_record_id', $employeeMasterID);
					$this->db->update('hr_alresults', $data5);
				}else{
					$this->db->insert('hr_alresults', $data5);
				}
				$this->db->trans_complete();
			}
			elseif ($check==true) {
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->delete('hr_alresults');
			}

			$data6['emp_record_id'] = $employeeMasterID;
			$check=$this->checktable('hr_empqlfct','emp_record_id',$employeeMasterID);

			$this->load->library('upload');

        $files_transcript = $_FILES;
        $path_transcript = array();
				$hqtranscript_path="";
        $cpt = count($_FILES['hqtranscript']['name']);
        $higher_education_transcript = $this->employee_new_model->get_higher_education_transcript($employeeMasterID);
                if($higher_education_transcript)
                    $hqtranscript_path = unserialize($higher_education_transcript['document']);

        for($i=0; $i<$cpt; $i++)
        {
            $path_transcript[$i] = $hqtranscript_path[$i];

            $_FILES['hqtranscript']['name']= $files_transcript['hqtranscript']['name'][$i];
            $_FILES['hqtranscript']['type']= $files_transcript['hqtranscript']['type'][$i];
            $_FILES['hqtranscript']['tmp_name']= $files_transcript['hqtranscript']['tmp_name'][$i];
            $_FILES['hqtranscript']['error']= $files_transcript['hqtranscript']['error'][$i];
            $_FILES['hqtranscript']['size']= $files_transcript['hqtranscript']['size'][$i];

            $config['upload_path'] = './uploads/documents/HQ';
            $config['allowed_types'] = '*';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(!($this->upload->do_upload('hqtranscript')))
            {

                echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
            }

            if(!empty($_FILES['hqtranscript']['name']))
            {
                $datahq = $this->upload->data();
                $path_transcript[$i] = base_url().'uploads/documents/HQ/'.$datahq['file_name'];

            }


        }

        $this->load->library('upload');

        $files = $_FILES;
        $path = array();
				$hqdocument_path="";
        $cpt = count($_FILES['hqdocument']['name']);
        $higher_education_details = $this->employee_new_model->get_higher_education_document($employeeMasterID);
                if($higher_education_details)
                    $hqdocument_path = unserialize($higher_education_details['document1']);

        for($i=0; $i<$cpt; $i++)
        {
            $path[$i] = $hqdocument_path[$i];

            $_FILES['hqdocument']['name']= $files['hqdocument']['name'][$i];
            $_FILES['hqdocument']['type']= $files['hqdocument']['type'][$i];
            $_FILES['hqdocument']['tmp_name']= $files['hqdocument']['tmp_name'][$i];
            $_FILES['hqdocument']['error']= $files['hqdocument']['error'][$i];
            $_FILES['hqdocument']['size']= $files['hqdocument']['size'][$i];

            $config['upload_path'] = './uploads/documents/Document';
            $config['allowed_types'] = '*';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if(!($this->upload->do_upload('hqdocument')))
            {

                echo "<div class='alert alert-danger'>".$this->upload->display_errors()."</div>";
            }

            if(!empty($_FILES['hqdocument']['name']))
            {
                $datahq = $this->upload->data();
                $path[$i] = base_url().'uploads/documents/Document/'.$datahq['file_name'];

            }


        }

			foreach($data_set['higher_education'] as $key=>$value){
				$name_trim = trim($value['name']);
				$field_trim = trim($value['field']);
				$institute_trim = trim($value['institute']);
				//$grade_trim = trim($value['grade']);
				$from_trim = trim($value['from']);
				//$to_trim = trim($value['to']);// Ticket 2879 edit by dileep

				if(empty($name_trim) || empty($field_trim) || empty($institute_trim) || empty($from_trim)){
					unset($data_set['higher_education'][$key]);
				}
			}
			if(sizeof($data_set['higher_education']) > 0){
				$data_set['higher_education'] = array_values($data_set['higher_education']);
				$data6['qualification_details'] = serialize($data_set['higher_education']);
				$doc_path = array_values($path);
            	$data6['document1'] = serialize($doc_path);
            	$doc_path_transcript = array_values($path_transcript);
            	$data6['document'] = serialize($doc_path_transcript);
				$this->db->trans_start();

				/*check employee data already exit */
				if($check==true){
					$this->db->where('emp_record_id', $employeeMasterID);
					$this->db->update('hr_empqlfct', $data6);
				}else{
					$this->db->insert('hr_empqlfct', $data6);
				}


				$this->db->trans_complete();
			}elseif ($check==true) {
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->delete('hr_empqlfct');
			}


			$data7['emp_record_id'] = $employeeMasterID;
			$check=$this->checktable('hr_workexpr','emp_record_id',$employeeMasterID);

			foreach($data_set['work_experience'] as $key=>$value){
				$job_trim = trim($value['job']);
				$company_trim = trim($value['company']);
				$location_trim = trim($value['location']);
				$from_trim = trim($value['from']);
				$to_trim = trim($value['to']);
				if(empty($job_trim) || empty($company_trim) || empty($location_trim)) {
					unset($data_set['work_experience'][$key]);
				}
			}
			if(sizeof($data_set['work_experience']) > 0){
				$data_set['work_experience'] = array_values($data_set['work_experience']);
				$data7['experience_details'] = serialize($data_set['work_experience']);

				$this->db->trans_start();

				/*check employee data already exit */
				if($check==true){
					$this->db->where('emp_record_id', $employeeMasterID);
					$this->db->update('hr_workexpr', $data7);
				}else{
					$this->db->insert('hr_workexpr', $data7);
				}

				$this->db->trans_complete();
			}elseif ($check==true) {
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->delete('hr_workexpr');
			}

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return $employeeMasterID;
			}

		}
		function get_all_employee_details($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->where('id !=', 1);
		//	$this->db->where('id !=', 2);
		//	$this->db->order_by('cast(emp_no AS INT)',"DESC");
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_empmastr');
			return $query->result();
		}

		function get_employee_list(){
			$this->db->select('*');
			$this->db->where('status !=', 'D');
			$this->db->order_by('epf_no');
			$query = $this->db->get('hr_empmastr');
			return $query->result();
		}

		function get_employee_details($id){
		// $this->db->select('hr_empmastr.*,hr_bankdtls.account_no,hr_bankdtls.bank_code');
		// $this->db->join('hr_bankdtls','hr_bankdtls.emp_record_id=hr_empmastr.id');
		// $this->db->where('hr_empmastr.id', $id);
		// $query = $this->db->get('hr_empmastr');
		// return $query->row_array();
			// return $query->row_array();


		//2019-10-07 Nadee ticket number 735
			$this->db->select('hr_empmastr.*,hr_bankdtls.account_no,hr_bankdtls.bank_code');
			$this->db->join('hr_bankdtls','hr_bankdtls.emp_record_id=hr_empmastr.id','left');
			$this->db->where('hr_empmastr.id', $id);
			$query = $this->db->get('hr_empmastr');
			if($query->result()>0){
				return $query->row_array();
			}else{
				return false;
			}
		//end ticket number 735

		}

		public function delete_employee($emp_id){
			$this->db->trans_start();
			$this->db->where('id', $emp_id);
			$this->db->delete('hr_empmastr');
			$this->db->trans_complete();

			$tables = array('hr_emergcnt', 'hr_bankdtls', 'hr_insurnce', 'hr_olresults', 'hr_alresults', 'hr_empqlfct', 'hr_workexpr');
			$this->db->trans_start();
			$this->db->where('emp_record_id', $emp_id);
			$this->db->delete($tables);
			$this->db->trans_complete();

			$log['emp_record_id'] = $emp_id;
			$log['activity'] = "Employee Deleted";
			$log['relevant_table'] = "hr_empmastr";
			$log['record_id'] = $emp_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		function get_emergnecy_contact_details($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_emergcnt');
			return $query->row_array();
		}

		function get_bank_details($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_bankdtls');
			return $query->row_array();
		}

		function get_insurance_details($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_insurnce');
			return $query->row_array();
		}

		function get_ol_results($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_olresults');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}

		function get_al_results($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_alresults');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}

		function get_higher_education($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_empqlfct');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}

		function get_work_experience($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_workexpr');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}

		public function update_employee_details(){

			if(!empty($_FILES['profile_pic']['name'])){
				$restlarge = "ProPic".date("YmdHis");
				$imagelarge = $this->do_uploadfile($restlarge,'profile_pic');
				if(!empty($imagelarge['upload_data']['file_name'])){
					$profile_pic = $imagelarge['upload_data']['file_name'];
					$data['profile_pic'] = $profile_pic;
				}else{

					$this->session->set_flashdata('error',$imagelarge['upload_data_failed']);
				}
			}

			$employeeMasterID = $this->input->post('employeeMasterID', TRUE);
		$data['emp_no'] = $this->input->post('emp_no',TRUE); //Ticket No-2502 | Added By Uvini
		$data['title'] = $this->input->post('title', TRUE);
		$data['initial'] = strtoupper($this->input->post('initials', TRUE));
		$data['surname'] = $this->input->post('surname', TRUE);
		$data['initials_full'] = $this->input->post('inifull', TRUE);
		$data['display_name'] = $this->input->post('system_dis_name', TRUE);
		//Ticket No-2877 | Added By Uvini
		$data['app_permission'] = $this->input->post('app_permission', TRUE);
		$data['nationality'] = $this->input->post('nationality', TRUE);
		$data['living_status'] = $this->input->post('martialStatus', TRUE);
		$data['religion'] = $this->input->post('religion', TRUE);
		$data['race'] = $this->input->post('race', TRUE);
		$data['nic_no'] = $this->input->post('nic', TRUE);
		$data['passport_no'] = $this->input->post('passport_no', TRUE);
		$data['driving_license_no'] = $this->input->post('driving_lic', TRUE);
		$data['blood_group'] = $this->input->post('blood_group', TRUE);
		$old_date = $this->input->post('employeeDoB', TRUE);
		$data['dob'] = date('Y-m-d', strtotime($old_date));
		$data['employment_type'] = $this->input->post('employment_type', TRUE);
		$joining_date = $this->input->post('emp_joining_date', TRUE);
		$data['joining_date'] = date('Y-m-d', strtotime($joining_date));
		$data['gender'] = $this->input->post('gender', TRUE);//ticket no 2839
		$duration = $this->input->post('duration', TRUE);
		if($duration != ""){
			$duration = $this->input->post('duration', TRUE);
		}else if($duration == ""){
			$duration = null;
		}
		$data['duration'] = $duration;
		$data['epf_no'] = $this->input->post('epf_no', TRUE);
		$data['designation'] = $this->input->post('designation', TRUE);
		$data['branch'] = $this->input->post('branch', TRUE);
		$data['division'] = $this->input->post('division', TRUE);
		$data['leave_category'] = $this->input->post('leave_category', TRUE);
		$data['working_days_per_week'] = $this->input->post('employment_working_days', TRUE);
		$data['maternity_leave'] = $this->input->post('maternity_leave', TRUE);
		$data['immediate_manager_1'] = $this->input->post('immediate_manager_1', TRUE);
		$data['immediate_manager_2'] = $this->input->post('immediate_manager_2', TRUE);
		$data['attendance_type'] = $this->input->post('attendance_type', TRUE);
		$fuel_allowance_status = $this->input->post('fuel_allowance_status', TRUE);
		$data['fuel_allowance_status'] = $fuel_allowance_status;
		if($fuel_allowance_status == "Y"){
			$data['vehicle_type'] = $this->input->post('vehicle_type', TRUE);
			$data['initial_meter_reading'] = $this->input->post('initial_meter_reading', TRUE);
			$data['fuel_allowance_maximum_limit'] = $this->input->post('fuel_allowance_maximum_limit', TRUE);
		}else{
			$data['vehicle_type'] = NULL;
			$data['initial_meter_reading'] = NULL;
			$data['fuel_allowance_maximum_limit'] = NULL;
		}
		$data['user_privilege'] = $this->input->post('user_privilege', TRUE);
		$data['tel_mob'] = $this->input->post('emp_mobile', TRUE);
		$data['tel_home'] = $this->input->post('emp_tel', TRUE);
		$data['email'] = $this->input->post('userEmail', TRUE);
		$data['office_tel'] = $this->input->post('emp_office_tel', TRUE);
		$data['office_mobile'] = $this->input->post('emp_office_mobile', TRUE);
		$data['office_email'] = $this->input->post('office_email', TRUE);
		$data['addr1'] = $this->input->post('address1', TRUE);
		$data['addr2'] = $this->input->post('address2', TRUE);
		$data['town'] = $this->input->post('town', TRUE);
		$data['province'] = $this->input->post('province', TRUE);
		$data['phone_bill']= $this->input->post('emp_phone_charges', TRUE);
		$data['contrat_start_date']= $this->input->post('contrac_start_date', TRUE);
		$data['contrat_end_date']= $this->input->post('contrac_end_date', TRUE);
		$this->db->trans_start();
		$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
		$this->db->trans_complete();

		$this->db->select('*');
		$this->db->where('usertype_id', $this->input->post('user_privilege', TRUE));
		$query = $this->db->get('cm_usertype');
		if($query->num_rows() > 0){
			$user_type=$query->row()->usertype;
			$data2['USRTYPE'] = $user_type;//updated by nadee 2021_05_19
			$data2['AND_FLG'] = $this->input->post('app_permission', TRUE);
			$this->db->trans_start();
			$this->db->update('cm_userdata', $data2, "USRID = $employeeMasterID");
			$this->db->trans_complete();
		}


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $employeeMasterID;
		}
	}

	public function confirm_employee(){

		$employeeMasterID = $this->input->post('employeeMasterID', TRUE);
		$employee_details = $this->get_employee_details($employeeMasterID);
		$joining_date = $employee_details['joining_date'];

		$data['status'] = "A";
		$this->db->trans_start();
		$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
		$this->db->trans_complete();

		$user_privilege_details = $this->get_user_privilege_details($employee_details['user_privilege']);
		$user_privilege_cheker = $this->get_user_data($employee_details['id']);
		if($user_privilege_details ){
			if($user_privilege_cheker==false){
				$user_data['USRID'] = $employee_details['id'];
				$user_data['USRTYPE'] = $user_privilege_details['usertype'];
				$user_data['BRNCODE'] = $employee_details['branch'];
				$user_data['USRNAME'] = $employee_details['nic_no'];
				//Ticket No-2877 | Added By Uvini
				$user_data['AND_FLG'] = $employee_details['app_permission'];
				$user_data['USRPW'] = $this->encryption->encode($employee_details['nic_no']);
				$user_data['EXPDATE'] = date('Y-m-d');
				$user_data['active_flag'] = 1;
				$this->db->trans_start();
				$this->db->insert('cm_userdata', $user_data);
				$this->db->trans_complete();
			}else{
			//$user_data['USRID'] = $employee_details['id'];
				$user_data['USRTYPE'] = $user_privilege_details['usertype'];
				$user_data['BRNCODE'] = $employee_details['branch'];
				$user_data['USRNAME'] = $employee_details['nic_no'];
				//Ticket No-2877 | Added By Uvini
				$user_data['AND_FLG'] = $employee_details['app_permission'];
				$user_data['USRPW'] = $this->encryption->encode($employee_details['nic_no']);
				$user_data['EXPDATE'] = date('Y-m-d');
				$user_data['active_flag'] = 1;
				$this->db->trans_start();
				$this->db->where('USRID',$employee_details['id']);
				$this->db->update('cm_userdata', $user_data);
				$this->db->trans_complete();
			}}


			$transfer['emp_record_id'] = $employeeMasterID;
			$transfer['transfer_type'] = "new_employee";
			$transfer['transferred_from_branch'] = $employee_details['branch'];
			$transfer['transferred_to_branch'] = $employee_details['branch'];
			$transfer['transferred_from_division'] = $employee_details['division'];
			$transfer['transferred_to_division'] = $employee_details['division'];
			$transfer['transfer_date'] = date('Y-m-d', strtotime($joining_date));
			$transfer['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_transfer_trans', $transfer);
			$this->db->trans_complete();

			$designation['emp_record_id'] = $employeeMasterID;
			$designation['previous_designation'] = $employee_details['designation'];
			$designation['new_designation'] = $employee_details['designation'];
			$designation['update_type'] = "N";
			$designation['designation_change_date'] = date('Y-m-d', strtotime($joining_date));
			$designation['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_designation_trans', $designation);
			$this->db->trans_complete();

			$leave_category['emp_record_id'] = $employeeMasterID;
			$leave_category['previous_leave_category'] = $employee_details['leave_category'];
			$leave_category['new_leave_category'] = $employee_details['leave_category'];
			$leave_category['leave_category_change_date'] = date('Y-m-d', strtotime($joining_date));
			$leave_category['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_leave_category_trans', $leave_category);
			$this->db->trans_complete();

			$emp_type['emp_record_id'] = $employeeMasterID;
			$emp_type['transaction_type'] = "new_employee";
			$emp_type['previous_employment_type'] = $employee_details['employment_type'];
			$emp_type['new_employment_type'] = $employee_details['employment_type'];
			$emp_type['previous_duration'] = $employee_details['duration'];
			$emp_type['new_duration'] = $employee_details['duration'];
			$emp_type['valid_from_date'] = date('Y-m-d', strtotime($joining_date));
			$emp_type['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_employment_type_trans', $emp_type);
			$this->db->trans_complete();

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employee Confirmed";
			$log['relevant_table'] = "hr_empmastr";
			$log['record_id'] = $employeeMasterID;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			$emp_trans['emp_record_id'] = $employeeMasterID;
			$emp_trans['emp_no'] = $employee_details['emp_no'];
			$emp_trans['branch'] = $employee_details['branch'];
			$emp_trans['division'] = $employee_details['division'];
			$emp_trans['designation'] = $employee_details['designation'];
			$emp_trans['employment_type'] = $employee_details['employment_type'];
			$emp_trans['leave_category'] = $employee_details['leave_category'];
			$emp_trans['start_date'] = date('Y-m-d', strtotime($joining_date));
			$emp_trans['period '] = $employee_details['duration'];
			if($employee_details['duration'] != "" && $employee_details['duration'] != NULL && $employee_details['duration'] != 0){
				$end_date = strtotime("+".$employee_details['duration']." months", strtotime($joining_date));
				$end_date = date("Y-m-d", $end_date);
			}else{
				$end_date = null;
			}
			$emp_trans['end_date'] = $end_date;
			$emp_trans['created_by'] = $this->session->userdata('username');
			$this->db->trans_start();
			$this->db->insert('hr_emp_transaction', $emp_trans);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function get_user_privilege_details($id){
			$this->db->select('*');
			$this->db->where('usertype_id', $id);
			$query = $this->db->get('cm_usertype');
			return $data = $query->row_array();
		}

		public function update_confirmed_employee_details($data_set){

			if(!empty($_FILES['profile_pic']['name'])){
				$restlarge = "ProPic".date("YmdHis");
				$imagelarge = $this->do_uploadfile($restlarge,'profile_pic');
				if(!empty($imagelarge['upload_data']['file_name'])){
					$profile_pic = $imagelarge['upload_data']['file_name'];
					$data['profile_pic'] = $profile_pic;
				}else{
					$this->session->set_flashdata('error',$imagelarge['upload_data_failed']);
				}
			}

			$employeeMasterID = $this->input->post('employeeMasterID', TRUE);

			$user_privilege = $this->input->post('user_privilege', TRUE);
			$user_privilege_details = $this->get_user_privilege_details($user_privilege);

			$user_data['USRTYPE'] = $user_privilege_details['usertype'];
			$user_data['AND_FLG'] = $this->input->post('app_permission', TRUE);//2021_08_28
			$this->db->trans_start();
			$this->db->where('USRID', $employeeMasterID);
			$this->db->update('cm_userdata', $user_data);
			$this->db->trans_complete();


			$data['title'] = $this->input->post('title', TRUE);
			$data['nationality'] = $this->input->post('nationality', TRUE);
			$data['living_status'] = $this->input->post('martialStatus', TRUE);
			$data['religion'] = $this->input->post('religion', TRUE);
			$data['race'] = $this->input->post('race', TRUE);
			$data['passport_no'] = $this->input->post('passport_no', TRUE);
			$data['working_days_per_week'] = $this->input->post('employment_working_days', TRUE);
			$data['driving_license_no'] = $this->input->post('driving_lic', TRUE);
			$data['blood_group'] = $this->input->post('blood_group', TRUE);

			$data['maternity_leave'] = $this->input->post('maternity_leave', TRUE);
			$data['immediate_manager_1'] = $this->input->post('immediate_manager_1', TRUE);
			$data['immediate_manager_2'] = $this->input->post('immediate_manager_2', TRUE);
			$data['attendance_type'] = $this->input->post('attendance_type', TRUE);
			$fuel_allowance_status = $this->input->post('fuel_allowance_status', TRUE);
			$data['fuel_allowance_status'] = $fuel_allowance_status;
			if($fuel_allowance_status == "Y"){
				$data['vehicle_type'] = $this->input->post('vehicle_type', TRUE);
				$data['initial_meter_reading'] = $this->input->post('initial_meter_reading', TRUE);
				$data['fuel_allowance_maximum_limit'] = $this->input->post('fuel_allowance_maximum_limit', TRUE);
			}else{
				$data['vehicle_type'] = NULL;
				$data['initial_meter_reading'] = NULL;
				$data['fuel_allowance_maximum_limit'] = NULL;
			}
			$data['user_privilege'] = $this->input->post('user_privilege', TRUE);

			$data['tel_mob'] = $this->input->post('emp_mobile', TRUE);
			$data['tel_home'] = $this->input->post('emp_tel', TRUE);
			$data['email'] = $this->input->post('userEmail', TRUE);
			$data['office_tel'] = $this->input->post('emp_office_tel', TRUE);
			$data['office_mobile'] = $this->input->post('emp_office_mobile', TRUE);
			$data['office_email'] = $this->input->post('office_email', TRUE);
			$data['addr1'] = $this->input->post('address1', TRUE);
			$data['addr2'] = $this->input->post('address2', TRUE);
			$data['town'] = $this->input->post('town', TRUE);
			$data['province'] = $this->input->post('province', TRUE);
			$data['phone_bill']= $this->input->post('emp_phone_charges', TRUE);
			$data['contrat_start_date']= $this->input->post('contrac_start_date', TRUE);
			$data['contrat_end_date']= $this->input->post('contrac_end_date', TRUE);//2905 ticket updated by nadee
			$this->db->trans_start();
			$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
			$this->db->trans_complete();

			$data1['person_name'] = $this->input->post('name_emg_person', TRUE);
			$data1['relationship'] = $this->input->post('relationship_emg', TRUE);
			$data1['tel_home'] = $this->input->post('contact_tel_emg', TRUE);
			$data1['tel_mobile'] = $this->input->post('contact_mob_emg', TRUE);
			$data1['add_1'] = $this->input->post('addr1_emg', TRUE);
			$data1['addr_2'] = $this->input->post('addr2_emg', TRUE);
			$data1['town'] = $this->input->post('town', TRUE);
			$this->db->trans_start();
			$this->db->update('hr_emergcnt', $data1, "emp_record_id = $employeeMasterID");
			$this->db->trans_complete();

			$data2['name_in_account'] = $this->input->post('bank_given_name', TRUE);
			$data2['bank_name'] = $this->input->post('bank_name', TRUE);
			$data2['bank_code'] = $this->input->post('bank_code', TRUE);
			$data2['branch_name'] = $this->input->post('bank_branch_name', TRUE);
			$data2['branch_code'] = $this->input->post('bank_branch', TRUE);
			$data2['account_no'] = $this->input->post('account_no', TRUE);
			$data2['account_type'] = $this->input->post('account_type', TRUE);
			$this->db->trans_start();
			$this->db->update('hr_bankdtls', $data2, "emp_record_id = $employeeMasterID");
			$this->db->trans_complete();

			$data3['company_name'] = $this->input->post('insCompany', TRUE);
			$data3['shcheme_name '] = $this->input->post('insScheme', TRUE);
			$data3['policy_no'] = $this->input->post('policynumber', TRUE);
			$this->db->trans_start();
			$this->db->update('hr_insurnce', $data3, "emp_record_id = $employeeMasterID");
			$this->db->trans_complete();

			if(count($data_set['ordinary_level']) > 0){
				$data4['school'] = $this->input->post('olschoolname', TRUE);
				$data4['result'] = serialize($data_set['ordinary_level']);
				$this->db->trans_start();
				$this->db->update('hr_olresults', $data4, "emp_record_id = $employeeMasterID");
				$this->db->trans_complete();
			}

			if(count($data_set['advance_level']) > 0){
				$data5['school'] = $this->input->post('alschoolname', TRUE);
				$data5['result'] = serialize($data_set['advance_level']);
				$this->db->trans_start();
				$this->db->update('hr_alresults', $data5, "emp_record_id = $employeeMasterID");
				$this->db->trans_complete();
			}

			if(count($data_set['higher_education']) > 0){
				$data6['qualification_details'] = serialize($data_set['higher_education']);
				$this->db->trans_start();
				$this->db->update('hr_empqlfct', $data6, "emp_record_id = $employeeMasterID");
				$this->db->trans_complete();
			}

			if(count($data_set['work_experience']) > 0){
				$data7['experience_details'] = serialize($data_set['work_experience']);
				$this->db->trans_start();
				$this->db->update('hr_workexpr', $data7, "emp_record_id = $employeeMasterID");
				$this->db->trans_complete();
			}

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function update_employee_transfer($employeeMasterID){

			$this->db->trans_start();
			$this->db->select('id');
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('hr_transfer_trans');
			$this->db->trans_complete();
			$lastrecord = $query->row_array();

			$data1['record_status'] = "P";
			$this->db->trans_start();
			$this->db->where('id', $lastrecord['id']);
			$this->db->update('hr_transfer_trans', $data1);
			$this->db->trans_complete();

			$this->db->trans_start();
			$this->db->select('*');
			$this->db->where('emp_record_id', $employeeMasterID);
			$query = $this->db->get('hr_emp_salary');
			$this->db->trans_complete();
			$lastsalaryrecord = $query->row_array();
			if(count($lastsalaryrecord)>0){
				$basic_salary = $lastsalaryrecord['basic_salary'];
			}else{
				$basic_salary = null;
			}
			$employee_details = $this->get_employee_details($employeeMasterID);

			$data2['emp_record_id'] = $employeeMasterID;
			$transfer_type = $this->input->post('transfer_type', TRUE);
			$data2['transfer_type'] = $transfer_type;
			$transfer_date = $this->input->post('transfer_date', TRUE);
			if($transfer_type == "division_only"){
				$data['division'] = $this->input->post('new_division', TRUE);
				$this->db->trans_start();
				$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
				$this->db->trans_complete();

				$emp_trans['emp_record_id'] = $employeeMasterID;
				$emp_trans['emp_no'] = $employee_details['emp_no'];
				$emp_trans['branch'] = $employee_details['branch'];
				$emp_trans['division'] = $this->input->post('new_division', TRUE);
				$emp_trans['designation'] = $employee_details['designation'];
				$emp_trans['employment_type'] = $employee_details['employment_type'];
				$emp_trans['leave_category'] = $employee_details['leave_category'];
				$emp_trans['start_date'] = date('Y-m-d', strtotime($transfer_date));
				$emp_trans['created_by'] = $this->session->userdata('username');
				$emp_trans['basic_salary'] = $basic_salary;
				$this->db->trans_start();
				$this->db->insert('hr_emp_transaction', $emp_trans);
				$this->db->trans_complete();

				$data2['transferred_from_division'] = $this->input->post('current_division_val', TRUE);
				$data2['transferred_to_division'] = $this->input->post('new_division', TRUE);
				$transfer_log = "Division only";
			}else if($transfer_type == "branch_and_division"){
				$data['division'] = $this->input->post('new_division', TRUE);
				$data['branch'] = $this->input->post('new_branch', TRUE);
				$this->db->trans_start();
				$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
				$this->db->trans_complete();

				$userdata['BRNCODE'] = $this->input->post('new_branch', TRUE);
				$this->db->trans_start();
				$this->db->update('cm_userdata', $userdata, "USRID = $employeeMasterID");
				$this->db->trans_complete();

				$emp_trans['emp_record_id'] = $employeeMasterID;
				$emp_trans['emp_no'] = $employee_details['emp_no'];
				$emp_trans['branch'] = $this->input->post('new_branch', TRUE);
				$emp_trans['division'] = $this->input->post('new_division', TRUE);
				$emp_trans['designation'] = $employee_details['designation'];
				$emp_trans['employment_type'] = $employee_details['employment_type'];
				$emp_trans['leave_category'] = $employee_details['leave_category'];
				$emp_trans['start_date'] = date('Y-m-d', strtotime($transfer_date));
				$emp_trans['created_by'] = $this->session->userdata('username');
				$emp_trans['basic_salary'] = $basic_salary;
				$this->db->trans_start();
				$this->db->insert('hr_emp_transaction', $emp_trans);
				$this->db->trans_complete();

				$data2['transferred_from_branch'] = $this->input->post('current_branch_val', TRUE);
				$data2['transferred_to_branch'] = $this->input->post('new_branch', TRUE);
				$data2['transferred_from_division'] = $this->input->post('current_division_val', TRUE);
				$data2['transferred_to_division'] = $this->input->post('new_division', TRUE);
				$transfer_log = "Branch and Division";
			}else if($transfer_type == "branch_only"){
				$data['branch'] = $this->input->post('new_branch', TRUE);
				$this->db->trans_start();
				$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
				$this->db->trans_complete();

				$userdata['BRNCODE'] = $this->input->post('new_branch', TRUE);
				$this->db->trans_start();
				$this->db->update('cm_userdata', $userdata, "USRID = $employeeMasterID");
				$this->db->trans_complete();

				$emp_trans['emp_record_id'] = $employeeMasterID;
				$emp_trans['emp_no'] = $employee_details['emp_no'];
				$emp_trans['branch'] = $this->input->post('new_branch', TRUE);
				$emp_trans['division'] = $employee_details['division'];
				$emp_trans['designation'] = $employee_details['designation'];
				$emp_trans['employment_type'] = $employee_details['employment_type'];
				$emp_trans['leave_category'] = $employee_details['leave_category'];
				$emp_trans['start_date'] = date('Y-m-d', strtotime($transfer_date));
				$emp_trans['created_by'] = $this->session->userdata('username');
				$emp_trans['basic_salary'] = $basic_salary;
				$this->db->trans_start();
				$this->db->insert('hr_emp_transaction', $emp_trans);
				$this->db->trans_complete();

				$data2['transferred_from_branch'] = $this->input->post('current_branch_val', TRUE);
				$data2['transferred_to_branch'] = $this->input->post('new_branch', TRUE);
				$transfer_log = "Branch only";
			}

			$data2['transfer_date'] = date('Y-m-d', strtotime($transfer_date));
			$data2['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_transfer_trans', $data2);
			$transfer_id = $this->db->insert_id();
			$this->db->trans_complete();

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employee transferred - ".$transfer_log;
			$log['relevant_table'] = "hr_transfer_trans";
			$log['record_id'] = $transfer_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function update_employee_promotion($employeeMasterID){

			$this->db->trans_start();
			$this->db->select('id');
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('hr_designation_trans');
			$this->db->trans_complete();
			$lastrecord = $query->row_array();

			$data['record_status'] = "P";
			$this->db->trans_start();
			$this->db->where('id', $lastrecord['id']);
			$this->db->update('hr_designation_trans', $data);
			$this->db->trans_complete();


			$data1['emp_record_id'] = $employeeMasterID;
			$data1['previous_designation'] = $this->input->post('current_designation_val', TRUE);
			$data1['new_designation'] = $this->input->post('new_designation', TRUE);
			$promotion_type = $this->input->post('promotion_type', TRUE);
			if($promotion_type == "Promotion"){
				$data1['update_type'] = "P";
				$log_note = "promoted";
			}else if($promotion_type == "Demotion"){
				$data1['update_type'] = "D";
				$log_note = "demoted";
			}else if($promotion_type == "Designation Change"){
				$data1['update_type'] = "C";
				$log_note = "designation changed";
			}
			$promotion_date = $this->input->post('promotion_date', TRUE);
			$data1['designation_change_date'] = date('Y-m-d', strtotime($promotion_date));
			$data1['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_designation_trans', $data1);
			$promo_id = $this->db->insert_id();
			$this->db->trans_complete();

			$this->db->trans_start();
			$this->db->select('*');
			$this->db->where('emp_record_id', $employeeMasterID);
			$query = $this->db->get('hr_emp_salary');
			$this->db->trans_complete();
			$lastsalaryrecord = $query->row_array();
			if(count($lastsalaryrecord)>0){
				$basic_salary = $lastsalaryrecord['basic_salary'];
			}else{
				$basic_salary = null;
			}
			$employee_details = $this->get_employee_details($employeeMasterID);

			$emp_trans['emp_record_id'] = $employeeMasterID;
			$emp_trans['emp_no'] = $employee_details['emp_no'];
			$emp_trans['branch'] = $employee_details['branch'];
			$emp_trans['division'] = $employee_details['division'];
			$emp_trans['designation'] = $this->input->post('new_designation', TRUE);
			$emp_trans['employment_type'] = $employee_details['employment_type'];
			$emp_trans['leave_category'] = $employee_details['leave_category'];
			$emp_trans['start_date'] = date('Y-m-d', strtotime($promotion_date));
			$emp_trans['created_by'] = $this->session->userdata('username');
			$emp_trans['basic_salary'] = $basic_salary;
			$this->db->trans_start();
			$this->db->insert('hr_emp_transaction', $emp_trans);
			$this->db->trans_complete();

			$data2['designation'] = $this->input->post('new_designation', TRUE);
			$this->db->trans_start();
			$this->db->where('id', $employeeMasterID);
			$this->db->update('hr_empmastr', $data2);
			$this->db->trans_complete();

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employee - ".$log_note;
			$log['relevant_table'] = "hr_designation_trans";
			$log['record_id'] = $promo_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function update_employee_leave_category($employeeMasterID){

			$this->db->trans_start();
			$this->db->select('id');
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('hr_leave_category_trans');
			$this->db->trans_complete();
			$lastrecord = $query->row_array();

			$data['record_status'] = "P";
			$this->db->trans_start();
			$this->db->where('id', $lastrecord['id']);
			$this->db->update('hr_leave_category_trans', $data);
			$this->db->trans_complete();


			$data1['emp_record_id'] = $employeeMasterID;
			$data1['previous_leave_category'] = $this->input->post('current_leave_profile_val', TRUE);
			$data1['new_leave_category'] = $this->input->post('new_leave_profile', TRUE);
			$leave_trans_date = $this->input->post('leave_trans_date', TRUE);
			$data1['leave_category_change_date'] = date('Y-m-d', strtotime($leave_trans_date));
			$data1['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_leave_category_trans', $data1);
			$leave_category_insert_id = $this->db->insert_id();
			$this->db->trans_complete();

			$this->db->trans_start();
			$this->db->select('*');
			$this->db->where('emp_record_id', $employeeMasterID);
			$query = $this->db->get('hr_emp_salary');
			$this->db->trans_complete();
			$lastsalaryrecord = $query->row_array();
			if(count($lastsalaryrecord)>0){
				$basic_salary = $lastsalaryrecord['basic_salary'];
			}else{
				$basic_salary = null;
			}
			$employee_details = $this->get_employee_details($employeeMasterID);

			$emp_trans['emp_record_id'] = $employeeMasterID;
			$emp_trans['emp_no'] = $employee_details['emp_no'];
			$emp_trans['branch'] = $employee_details['branch'];
			$emp_trans['division'] = $employee_details['division'];
			$emp_trans['designation'] = $employee_details['designation'];
			$emp_trans['employment_type'] = $employee_details['employment_type'];
			$emp_trans['leave_category'] = $this->input->post('new_leave_profile', TRUE);
			$emp_trans['start_date'] = date('Y-m-d', strtotime($leave_trans_date));
			$emp_trans['created_by'] = $this->session->userdata('username');
			$emp_trans['basic_salary'] = $basic_salary;
			$this->db->trans_start();
			$this->db->insert('hr_emp_transaction', $emp_trans);
			$this->db->trans_complete();

			$data2['leave_category'] = $this->input->post('new_leave_profile', TRUE);
			$this->db->trans_start();
			$this->db->where('id', $employeeMasterID);
			$this->db->update('hr_empmastr', $data2);
			$this->db->trans_complete();

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employee - Leave Category Update";
			$log['relevant_table'] = "hr_leave_category_trans";
			$log['record_id'] = $leave_category_insert_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function update_employee_employment_type($employeeMasterID){

			$this->db->trans_start();
			$this->db->select('id');
			$this->db->where('emp_record_id', $employeeMasterID);
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('hr_employment_type_trans');
			$this->db->trans_complete();
			$lastrecord = $query->row_array();

			$data1['record_status'] = "P";
			$this->db->trans_start();
			$this->db->where('id', $lastrecord['id']);
			$this->db->update('hr_employment_type_trans', $data1);
			$this->db->trans_complete();

			$this->db->trans_start();
			$this->db->select('*');
			$this->db->where('emp_record_id', $employeeMasterID);
			$query = $this->db->get('hr_emp_salary');
			$this->db->trans_complete();
			$lastsalaryrecord = $query->row_array();
			if(count($lastsalaryrecord)>0){
				$basic_salary = $lastsalaryrecord['basic_salary'];
			}else{
				$basic_salary = null;
			}
			$employee_details = $this->get_employee_details($employeeMasterID);


			$data2['emp_record_id'] = $employeeMasterID;
			$employment_type_transaction = $this->input->post('employment_type_transaction', TRUE);
			$data2['transaction_type'] = $employment_type_transaction;
			$employment_type_date = $this->input->post('employment_type_date', TRUE);
			if($employment_type_transaction == "employement_type_only"){
				$data['employment_type'] = $this->input->post('new_employement_type', TRUE);
				$this->db->trans_start();
				$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
				$this->db->trans_complete();

				$emp_trans['emp_record_id'] = $employeeMasterID;
				$emp_trans['emp_no'] = $employee_details['emp_no'];
				$emp_trans['branch'] = $employee_details['branch'];
				$emp_trans['division'] = $employee_details['division'];
				$emp_trans['designation'] = $employee_details['designation'];
				$emp_trans['employment_type'] = $this->input->post('new_employement_type', TRUE);
				$emp_trans['leave_category'] = $employee_details['leave_category'];
				$emp_trans['start_date'] = date('Y-m-d', strtotime($employment_type_date));
				$emp_trans['created_by'] = $this->session->userdata('username');
				$emp_trans['basic_salary'] = $basic_salary;
				$this->db->trans_start();
				$this->db->insert('hr_emp_transaction', $emp_trans);
				$this->db->trans_complete();

				$data2['previous_employment_type'] = $this->input->post('current_employement_type_val', TRUE);
				$data2['new_employment_type'] = $this->input->post('new_employement_type', TRUE);
				$log_note = "Employment Type Only";
			}else if($employment_type_transaction == "employement_type_and_duration"){
				$data['employment_type'] = $this->input->post('new_employement_type', TRUE);
				$data['duration'] = $this->input->post('new_duration', TRUE);
				$this->db->trans_start();
				$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
				$this->db->trans_complete();

				$emp_trans['emp_record_id'] = $employeeMasterID;
				$emp_trans['emp_no'] = $employee_details['emp_no'];
				$emp_trans['branch'] = $employee_details['branch'];
				$emp_trans['division'] = $employee_details['division'];
				$emp_trans['designation'] = $employee_details['designation'];
				$emp_trans['employment_type'] = $this->input->post('new_employement_type', TRUE);
				$emp_trans['leave_category'] = $employee_details['leave_category'];
				$emp_trans['start_date'] = date('Y-m-d', strtotime($employment_type_date));

				$new_duration = $this->input->post('new_duration', TRUE);
				$emp_trans['period '] = $new_duration;
				if($new_duration != "" && $new_duration != NULL  && $new_duration != 0){
					$end_date = strtotime("+".$new_duration." months", strtotime($employment_type_date));
					$end_date = date("Y-m-d", $end_date);
				}else{
					$end_date = null;
				}
				$emp_trans['end_date'] = $end_date;

				$emp_trans['created_by'] = $this->session->userdata('username');
				$emp_trans['basic_salary'] = $basic_salary;
				$this->db->trans_start();
				$this->db->insert('hr_emp_transaction', $emp_trans);
				$this->db->trans_complete();

				$data2['previous_employment_type'] = $this->input->post('current_employement_type_val', TRUE);
				$data2['new_employment_type'] = $this->input->post('new_employement_type', TRUE);
				$data2['previous_duration'] = $this->input->post('current_duration', TRUE);
				$data2['new_duration'] = $this->input->post('new_duration', TRUE);
				$log_note = "Employment Type and Duration";
			}else if($employment_type_transaction == "duration_only"){
				$data['duration'] = $this->input->post('new_duration', TRUE);
				$this->db->trans_start();
				$this->db->update('hr_empmastr', $data, "id = $employeeMasterID");
				$this->db->trans_complete();

				$emp_trans['emp_record_id'] = $employeeMasterID;
				$emp_trans['emp_no'] = $employee_details['emp_no'];
				$emp_trans['branch'] = $employee_details['branch'];
				$emp_trans['division'] = $employee_details['division'];
				$emp_trans['designation'] = $employee_details['designation'];
				$emp_trans['employment_type'] = $employee_details['employment_type'];
				$emp_trans['leave_category'] = $employee_details['leave_category'];
				$emp_trans['start_date'] = date('Y-m-d', strtotime($employment_type_date));

				$new_duration = $this->input->post('new_duration', TRUE);
				$emp_trans['period '] = $new_duration;
				if($new_duration != "" && $new_duration != NULL && $new_duration != 0){
					$end_date = strtotime("+".$new_duration." months", strtotime($employment_type_date));
					$end_date = date("Y-m-d", $end_date);
				}else{
					$end_date = null;
				}
				$emp_trans['end_date'] = $end_date;

				$emp_trans['created_by'] = $this->session->userdata('username');
				$emp_trans['basic_salary'] = $basic_salary;
				$this->db->trans_start();
				$this->db->insert('hr_emp_transaction', $emp_trans);
				$this->db->trans_complete();

				$data2['previous_duration'] = $this->input->post('current_duration', TRUE);
				$data2['new_duration'] = $this->input->post('new_duration', TRUE);
				$log_note = "Duration only";
			}

			$data2['valid_from_date'] = date('Y-m-d', strtotime($employment_type_date));
			$data2['record_status'] = "A";
			$this->db->trans_start();
			$this->db->insert('hr_employment_type_trans', $data2);
			$employment_type_trans_id = $this->db->insert_id();
			$this->db->trans_complete();

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employment Type Transaction - ".$log_note;
			$log['relevant_table'] = "hr_employment_type_trans";
			$log['record_id'] = $employment_type_trans_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function update_employee_resignation($employeeMasterID){

			$resignation_trans_date = $this->input->post('resignation_trans_date', TRUE);
			$data['resignation_date'] = date('Y-m-d', strtotime($resignation_trans_date));
			$data['status'] = "D";
			$this->db->trans_start();
			$this->db->where('id', $employeeMasterID);
			$this->db->update('hr_empmastr', $data);
			$this->db->trans_complete();

			$user_data['EXPDATE'] = date('Y-m-d', strtotime($resignation_trans_date));
			$user_data['active_flag'] = 0;
			$this->db->trans_start();
			$this->db->where('USRID', $employeeMasterID);
			$this->db->update('cm_userdata', $user_data);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		function get_all_emp_salary($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->order_by('id');
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_emp_salary');
			return $query->result();
		}

		function get_employee_salary_list(){
			$this->db->select('hr_emp_salary.*');
			$this->db->where_not_in('hr_empmastr.status','D');
			$this->db->join('hr_empmastr','hr_empmastr.id = hr_emp_salary.emp_record_id');
			$this->db->order_by('hr_emp_salary.id');
			$query = $this->db->get('hr_emp_salary');
			return $query->result();
		}

		function get_emp_salary_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_salary');
			return $query->row_array();
		}

		function get_emp_salary_details_by_emp_id($emp_id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $emp_id);
			$query = $this->db->get('hr_emp_salary');
			return $query->row_array();
		}

		public function define_employee_salary($employeeMasterID){
			$employee_details = $this->get_employee_details($employeeMasterID);
			$submit_type = $this->input->post('submit_type', TRUE);
			$salary_id = $this->input->post('salary_id', TRUE);

			$epf = $this->input->post('EPF', TRUE);
			if($epf == 'EPF'){
				$epf_status = "Y";
			}else{
				$epf_status = "N";
			}
			$etf = $this->input->post('ETF', TRUE);
			if($etf == 'ETF'){
				$etf_status = "Y";
			}else{
				$etf_status = "N";
			}
			$paye = $this->input->post('paye', TRUE);
			if($paye == 'paye'){
				$paye_status = "Y";
			}else{
				$paye_status = "N";
			}

			$data['emp_record_id'] = $employeeMasterID;
			$data['basic_salary'] = $this->input->post('basic_salary', TRUE);
			$data['epf'] = $epf_status;
			$data['etf'] = $etf_status;
			$data['payee_tax'] = $paye_status;
			$data['effective_from'] = $employee_details['joining_date'];
			$data['updated_by'] = $this->session->userdata('username');
			$this->db->trans_start();
			if($submit_type == 'insert' && $salary_id == ''){
				$this->db->insert('hr_emp_salary', $data);
				$salary_id = $this->db->insert_id();
				$salary_log = "Employee Salary Defined";
			}else if($submit_type == 'update' && $salary_id != ''){
				$this->db->update('hr_emp_salary', $data, "id = $salary_id");
				$salary_log = "Employee Salary Updated";
			}
			$this->db->trans_complete();

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = $salary_log;
			$log['relevant_table'] = "hr_emp_salary";
			$log['record_id'] = $salary_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			$emp_allowance_list = $this->get_employee_allowances_details($employeeMasterID);

			$check = array();
			if(count($emp_allowance_list)>0){
				foreach ($emp_allowance_list as $one) {
					$check[$one->allowance_id] = true;
				}
			}

			$check2 = array();
			if(isset($_POST['allowance'])){
				foreach ($_POST['allowance'] as $two) {
					$check2[$two] = true;
				}
			}

			$diff = array();
			$diff = (array_diff_assoc($check, $check2));
			foreach ($diff as $key=>$value) {
				$this->db->trans_start();
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->where('allowance_id', $key);
				$this->db->delete('hr_emp_allowances');
				$this->db->trans_complete();

				$log['emp_record_id'] = $employeeMasterID;
				$log['activity'] = "Allowance deleted";
				$log['relevant_table'] = "hr_emp_allowances";
				$log['record_id'] = $key;
				$this->db->trans_start();
				$this->db->insert('hr_emp_log', $log);
				$this->db->trans_complete();
			}

			$diff1 = array();
			$diff1 = (array_diff_assoc($check2, $check));
			foreach ($diff1 as $key=>$value) {
				$data1['emp_record_id'] = $employeeMasterID;
				$data1['allowance_id'] = $key;
				$data1['value'] = $this->input->post('allowance_'.$key, TRUE);
				$data1['effective_from'] = $employee_details['joining_date'];
				$data1['status'] = "Y";
				$this->db->trans_start();
				$this->db->insert('hr_emp_allowances', $data1);
				$allowance_id = $this->db->insert_id();
				$this->db->trans_complete();

				$log['emp_record_id'] = $employeeMasterID;
				$log['activity'] = "Allowance added";
				$log['relevant_table'] = "hr_emp_allowances";
				$log['record_id'] = $allowance_id;
				$this->db->trans_start();
				$this->db->insert('hr_emp_log', $log);
				$this->db->trans_complete();
			}

			$diff2 = array();
			$diff2 = (array_intersect_key($check, $check2));
			foreach ($diff2 as $key=>$value) {
				$data2['value'] = $this->input->post('allowance_'.$key, TRUE);
				$data2['status'] = "Y";
				$this->db->trans_start();
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->where('allowance_id', $key);
				$this->db->update('hr_emp_allowances', $data2);
				$this->db->trans_complete();

				$log['emp_record_id'] = $employeeMasterID;
				$log['activity'] = "Allowance amount updated";
				$log['relevant_table'] = "hr_emp_allowances";
				$log['record_id'] = $key;
				$this->db->trans_start();
				$this->db->insert('hr_emp_log', $log);
				$this->db->trans_complete();
			}


			$emp_deduction_list = $this->get_employee_deductions_details($employeeMasterID);
			$check_deduct = array();
			if(count($emp_deduction_list)>0){
				foreach ($emp_deduction_list as $one) {
					$check_deduct[$one->deduction_id] = true;
				}
			}

			$check_deduct2 = array();
			if(isset($_POST['deduction'])){
				foreach ($_POST['deduction'] as $two) {
					$check_deduct2[$two] = true;
				}
			}

			$diff_deduct = array();
			$diff_deduct = (array_diff_assoc($check_deduct, $check_deduct2));
			foreach ($diff_deduct as $key=>$value) {
				$this->db->trans_start();
				$this->db->where('emp_record_id', $employeeMasterID);
				$this->db->where('deduction_id', $key);
				$this->db->delete('hr_emp_deductions');
				$this->db->trans_complete();

				$log['emp_record_id'] = $employeeMasterID;
				$log['activity'] = "Deduction deleted";
				$log['relevant_table'] = "hr_emp_deductions";
				$log['record_id'] = $key;
				$this->db->trans_start();
				$this->db->insert('hr_emp_log', $log);
				$this->db->trans_complete();
			}

			$diff_deduct1 = array();
			$diff_deduct1 = (array_diff_assoc($check_deduct2, $check_deduct));
			foreach ($diff_deduct1 as $key=>$value) {
				$data3['emp_record_id'] = $employeeMasterID;
				$data3['deduction_id'] = $key;
				$data3['effective_from'] = $employee_details['joining_date'];
				$data3['status'] = "Y";
				$this->db->trans_start();
				$this->db->insert('hr_emp_deductions', $data3);
				$deduction_id = $this->db->insert_id();
				$this->db->trans_complete();

				$log['emp_record_id'] = $employeeMasterID;
				$log['activity'] = "Deduction added";
				$log['relevant_table'] = "hr_emp_deductions";
				$log['record_id'] = $deduction_id;
				$this->db->trans_start();
				$this->db->insert('hr_emp_log', $log);
				$this->db->trans_complete();
			}

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function update_employee_salary($employeeMasterID){

			$salary_id = $this->input->post('salary_id', TRUE);
			$salary_change_type = $this->input->post('salary_change_type', TRUE);

			if($salary_change_type == "salary_increment_decrement_update"){

				$data_emp_sal['pending_salary_changes'] = "Y";
				$this->db->trans_start();
				$this->db->where('id', $salary_id);
				$this->db->update('hr_emp_salary', $data_emp_sal);
				$this->db->trans_complete();

				$basic_salary = $this->input->post('basic_salary', TRUE);
				$salary_increment_decrement_type = $this->input->post('salary_increment_decrement_type', TRUE);

				$salary_change_amount = $this->input->post('salary_change_amount', TRUE);
				if($salary_increment_decrement_type == "salary_increment_update"){
				//$basic_salary = $basic_salary + $salary_change_amount;
					$sal_chng_type = "Increment";
				}else if($salary_increment_decrement_type == "salary_decrement_update"){
				//$basic_salary = $basic_salary - $salary_change_amount;
					$sal_chng_type = "Decrement";
				}

				$data['emp_record_id'] = $employeeMasterID;
				$data['type'] = $sal_chng_type;
				$data['amount'] = $salary_change_amount;
				$effective_from = $this->input->post('effective_from', TRUE);
				$data['effective_from'] = date('Y-m-d', strtotime($effective_from));
				$data['updated_by'] = $this->session->userdata('username');
				$this->db->trans_start();
				$this->db->insert('hr_emp_pending_salary_changes', $data);
				$last_insert_id = $this->db->insert_id();
				$this->db->trans_complete();

				$sal_changes['emp_record_id'] = $employeeMasterID;
				$sal_changes['change_type'] = "salary_increment_decrement_update";
				$sal_changes['relevant_table'] = "hr_emp_pending_salary_changes";
				$sal_changes['relevant_id'] = $last_insert_id;
				$sal_changes['updated_by'] = $this->session->userdata('username');
				$this->db->trans_start();
				$this->db->insert('hr_emp_salary_changes', $sal_changes);
				$this->db->trans_complete();

			}else if($salary_change_type == "allowance_update"){
				$emp_allowance_list = $this->get_employee_allowances_details($employeeMasterID);

				$check = array();
				if(count($emp_allowance_list)>0){
					foreach($emp_allowance_list as $one){
						$check[$one->allowance_id] = true;
					}
				}

				$check2 = array();
				if(isset($_POST['allowance'])){
					foreach($_POST['allowance'] as $two){
						$check2[$two] = true;
					}
				}

				$diff = array();
				$diff = (array_diff_assoc($check, $check2));
				foreach($diff as $key=>$value){
					$data_emp_sal['pending_salary_changes'] = "Y";
					$this->db->trans_start();
					$this->db->where('id', $salary_id);
					$this->db->update('hr_emp_salary', $data_emp_sal);
					$this->db->trans_complete();

					$emp_allowance_details = $this->get_employee_allowances_details_by_emp_id_allowance_id($employeeMasterID, $key);

					$allowance_pending['emp_record_id'] = $emp_allowance_details['emp_record_id'];
					$allowance_pending['emp_allowance_id'] = $emp_allowance_details['id'];
					$allowance_pending['allowance_id'] = $emp_allowance_details['allowance_id'];
					$allowance_pending['value'] = $emp_allowance_details['value'];
					$allowance_pending['status'] = "N";
					$effective_from = $this->input->post('effective_from', TRUE);
					$allowance_pending['effective_from'] = date('Y-m-d', strtotime($effective_from));
					$allowance_pending['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_pending_allowances_changes', $allowance_pending);
					$last_insert_id = $this->db->insert_id();
					$this->db->trans_complete();

					$sal_changes['emp_record_id'] = $employeeMasterID;
					$sal_changes['change_type'] = "allowance_update";
					$sal_changes['relevant_table'] = "hr_emp_pending_allowances_changes";
					$sal_changes['relevant_id'] = $last_insert_id;
					$sal_changes['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_changes', $sal_changes);
					$this->db->trans_complete();
				}

				$diff1 = array();
				$diff1 = (array_diff_assoc($check2, $check));
				foreach($diff1 as $key=>$value){
					$data_emp_sal['pending_salary_changes'] = "Y";
					$this->db->trans_start();
					$this->db->where('id', $salary_id);
					$this->db->update('hr_emp_salary', $data_emp_sal);
					$this->db->trans_complete();

					$allowance_pending1['emp_record_id'] = $employeeMasterID;
					$allowance_pending1['allowance_id'] = $key;
					$allowance_pending1['value'] = $this->input->post('allowance_'.$key, TRUE);
					$allowance_pending1['status'] = "Y";
					$effective_from = $this->input->post('effective_from', TRUE);
					$allowance_pending1['effective_from'] = date('Y-m-d', strtotime($effective_from));
					$allowance_pending1['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_pending_allowances_changes', $allowance_pending1);
					$last_insert_id = $this->db->insert_id();
					$this->db->trans_complete();

					$sal_changes['emp_record_id'] = $employeeMasterID;
					$sal_changes['change_type'] = "allowance_update";
					$sal_changes['relevant_table'] = "hr_emp_pending_allowances_changes";
					$sal_changes['relevant_id'] = $last_insert_id;
					$sal_changes['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_changes', $sal_changes);
					$this->db->trans_complete();
				}

				$diff2 = array();
				$diff2 = (array_intersect_key($check, $check2));
				foreach($diff2 as $key=>$value){
					$emp_allowance_details = $this->get_employee_allowances_details_by_emp_id_allowance_id($employeeMasterID, $key);

					if($emp_allowance_details['value'] != $this->input->post('allowance_'.$key, TRUE)){
						$data_emp_sal['pending_salary_changes'] = "Y";
						$this->db->trans_start();
						$this->db->where('id', $salary_id);
						$this->db->update('hr_emp_salary', $data_emp_sal);
						$this->db->trans_complete();

						$allowance_pending2['emp_record_id'] = $emp_allowance_details['emp_record_id'];
						$allowance_pending2['emp_allowance_id'] = $emp_allowance_details['id'];
						$allowance_pending2['allowance_id'] = $emp_allowance_details['allowance_id'];
						$allowance_pending2['value'] = $this->input->post('allowance_'.$key, TRUE);
						$allowance_pending2['status'] = $emp_allowance_details['status'];
						$effective_from = $this->input->post('effective_from', TRUE);
						$allowance_pending2['effective_from'] = date('Y-m-d', strtotime($effective_from));
						$allowance_pending2['updated_by'] = $this->session->userdata('username');
						$this->db->trans_start();
						$this->db->insert('hr_emp_pending_allowances_changes', $allowance_pending2);
						$last_insert_id = $this->db->insert_id();
						$this->db->trans_complete();

						$sal_changes['emp_record_id'] = $employeeMasterID;
						$sal_changes['change_type'] = "allowance_update";
						$sal_changes['relevant_table'] = "hr_emp_pending_allowances_changes";
						$sal_changes['relevant_id'] = $last_insert_id;
						$sal_changes['updated_by'] = $this->session->userdata('username');
						$this->db->trans_start();
						$this->db->insert('hr_emp_salary_changes', $sal_changes);
						$this->db->trans_complete();
					}
				}
			}else if($salary_change_type == "epf_etf_paye_update"){
				$emp_salary_details = $this->get_employee_salary_details($employeeMasterID);
				$epf = $this->input->post('EPF', TRUE);
				if($epf == 'EPF'){
					$epf_status = "Y";
				}else{
					$epf_status = "N";
				}
				$etf = $this->input->post('ETF', TRUE);
				if($etf == 'ETF'){
					$etf_status = "Y";
				}else{
					$etf_status = "N";
				}
				$paye = $this->input->post('paye', TRUE);
				if($paye == 'paye'){
					$paye_status = "Y";
				}else{
					$paye_status = "N";
				}

				if($emp_salary_details['epf'] != $epf_status || $emp_salary_details['etf'] != $etf_status || $emp_salary_details['payee_tax'] != $paye_status){

					$data_emp_sal['pending_salary_changes'] = "Y";
					$this->db->trans_start();
					$this->db->where('id', $salary_id);
					$this->db->update('hr_emp_salary', $data_emp_sal);
					$this->db->trans_complete();

					$data['emp_record_id'] = $employeeMasterID;
					$data['epf'] = $epf_status;
					$data['etf'] = $etf_status;
					$data['payee_tax'] = $paye_status;
					$effective_from = $this->input->post('effective_from', TRUE);
					$data['effective_from'] = date('Y-m-d', strtotime($effective_from));
					$data['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_pending_epf_etf_paye_changes', $data);
					$last_insert_id = $this->db->insert_id();
					$this->db->trans_complete();

					$sal_changes['emp_record_id'] = $employeeMasterID;
					$sal_changes['change_type'] = "epf_etf_paye_update";
					$sal_changes['relevant_table'] = "hr_emp_pending_epf_etf_paye_changes";
					$sal_changes['relevant_id'] = $last_insert_id;
					$sal_changes['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_changes', $sal_changes);
					$this->db->trans_complete();
				}
			}else if($salary_change_type == "deduction_update"){
				$emp_deduction_list = $this->get_employee_deductions_details($employeeMasterID);

				$check_deduct = array();
				if(count($emp_deduction_list)>0){
					foreach($emp_deduction_list as $one){
						$check_deduct[$one->deduction_id] = true;
					}
				}

				$check_deduct2 = array();
				if(isset($_POST['deduction'])){
					foreach($_POST['deduction'] as $two){
						$check_deduct2[$two] = true;
					}
				}

				$diff_deduct = array();
				$diff_deduct = (array_diff_assoc($check_deduct, $check_deduct2));
				foreach($diff_deduct as $key=>$value){
					$data_emp_sal['pending_salary_changes'] = "Y";
					$this->db->trans_start();
					$this->db->where('id', $salary_id);
					$this->db->update('hr_emp_salary', $data_emp_sal);
					$this->db->trans_complete();

					$emp_deduction_details = $this->get_employee_deduction_details_by_emp_id_allowance_id($employeeMasterID, $key);
					$deduction_pending['emp_record_id'] = $emp_deduction_details['emp_record_id'];
					$deduction_pending['emp_deduction_id'] = $emp_deduction_details['id'];
					$deduction_pending['deduction_id'] = $emp_deduction_details['deduction_id'];
					$deduction_pending['status'] = "N";
					$effective_from = $this->input->post('effective_from', TRUE);
					$deduction_pending['effective_from'] = date('Y-m-d', strtotime($effective_from));
					$deduction_pending['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_pending_deductions_changes', $deduction_pending);
					$last_insert_id = $this->db->insert_id();
					$this->db->trans_complete();

					$sal_changes['emp_record_id'] = $employeeMasterID;
					$sal_changes['change_type'] = "deduction_update";
					$sal_changes['relevant_table'] = "hr_emp_pending_deductions_changes";
					$sal_changes['relevant_id'] = $last_insert_id;
					$sal_changes['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_changes', $sal_changes);
					$this->db->trans_complete();
				}

				$diff_deduct1 = array();
				$diff_deduct1 = (array_diff_assoc($check_deduct2, $check_deduct));
				foreach($diff_deduct1 as $key=>$value){
					$data_emp_sal['pending_salary_changes'] = "Y";
					$this->db->trans_start();
					$this->db->where('id', $salary_id);
					$this->db->update('hr_emp_salary', $data_emp_sal);
					$this->db->trans_complete();

					$deduction_pending1['emp_record_id'] = $employeeMasterID;
					$deduction_pending1['deduction_id'] = $key;
					$deduction_pending1['status'] = "Y";
					$effective_from = $this->input->post('effective_from', TRUE);
					$deduction_pending1['effective_from'] = date('Y-m-d', strtotime($effective_from));
					$deduction_pending1['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_pending_deductions_changes', $deduction_pending1);
					$last_insert_id = $this->db->insert_id();
					$this->db->trans_complete();

					$sal_changes['emp_record_id'] = $employeeMasterID;
					$sal_changes['change_type'] = "deduction_update";
					$sal_changes['relevant_table'] = "hr_emp_pending_deductions_changes";
					$sal_changes['relevant_id'] = $last_insert_id;
					$sal_changes['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_changes', $sal_changes);
					$this->db->trans_complete();
				}

			}

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function validate_employee_salary_effective_from_date(){
			$today_date = date('Y-m-d');
			$increment_decrement_changes_list = $this->get_emp_increment_decrement_changes_list();
			foreach($increment_decrement_changes_list as $increment_decrement_change){
				if($increment_decrement_change->effective_from <= $today_date){
					$employee_salary_details = $this->get_employee_salary_details($increment_decrement_change->emp_record_id);
					$data_history['emp_record_id'] = $employee_salary_details['emp_record_id'];
					$data_history['basic_salary'] = $employee_salary_details['basic_salary'];
					$data_history['epf'] = $employee_salary_details['epf'];
					$data_history['etf'] = $employee_salary_details['etf'];
					$data_history['payee_tax'] = $employee_salary_details['payee_tax'];
					$data_history['effective_from'] = $employee_salary_details['effective_from'];
					$data_history['status'] = $employee_salary_details['status'];
					$data_history['updated_by'] = $employee_salary_details['updated_by'];
					$data_history['last_updated'] = $employee_salary_details['last_updated'];
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_history', $data_history);
					$this->db->trans_complete();

					$basic_salary = $employee_salary_details['basic_salary'];
					$salary_increment_decrement_type = $increment_decrement_change->type;
					$salary_change_amount = $increment_decrement_change->amount;
					if($salary_increment_decrement_type == "Increment"){
						$basic_salary = $basic_salary + $salary_change_amount;
					}else if($salary_increment_decrement_type == "Decrement"){
						$basic_salary = $basic_salary - $salary_change_amount;
					}

					$data['basic_salary'] = $basic_salary;
					$data['effective_from'] = $increment_decrement_change->effective_from;
					$data['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->where('emp_record_id', $increment_decrement_change->emp_record_id);
					$this->db->update('hr_emp_salary', $data);
					$this->db->trans_complete();

					$emp_master['basic_salary'] = $basic_salary;
					$this->db->trans_start();
					$this->db->where('id', $increment_decrement_change->emp_record_id);
					$this->db->update('hr_empmastr', $emp_master);
					$this->db->trans_complete();

					$employee_details = $this->get_employee_details($increment_decrement_change->emp_record_id);

					$emp_trans['emp_record_id'] = $increment_decrement_change->emp_record_id;
					$emp_trans['emp_no'] = $employee_details['emp_no'];
					$emp_trans['branch'] = $employee_details['branch'];
					$emp_trans['division'] = $employee_details['division'];
					$emp_trans['designation'] = $employee_details['designation'];
					$emp_trans['employment_type'] = $employee_details['employment_type'];
					$emp_trans['leave_category'] = $employee_details['leave_category'];
					$emp_trans['start_date'] = $increment_decrement_change->effective_from;
					$emp_trans['created_by'] = $this->session->userdata('username');
					$emp_trans['basic_salary'] = $basic_salary;
					$this->db->trans_start();
					$this->db->insert('hr_emp_transaction', $emp_trans);
					$this->db->trans_complete();

					$active_record['active_record'] = "past";
					$this->db->trans_start();
					$this->db->where('id', $increment_decrement_change->id);
					$this->db->update('hr_emp_pending_salary_changes', $active_record);
					$this->db->trans_complete();

					$log['emp_record_id'] = $increment_decrement_change->emp_record_id;
					$log['activity'] = "Employee Salary - ".$salary_increment_decrement_type." confirmed";
					$log['relevant_table'] = "hr_emp_salary";
					$log['record_id'] = $employee_salary_details['id'];
					$this->db->trans_start();
					$this->db->insert('hr_emp_log', $log);
					$this->db->trans_complete();
				}
			}

			$allowances_changes_list = $this->get_emp_allowances_changes_list();
			foreach($allowances_changes_list as $allowance_change){
				if($allowance_change->effective_from <= $today_date){
					if(!empty($allowance_change->emp_allowance_id)){
						$employee_allowance_details = $this->get_employee_allowance_details_by_id($allowance_change->emp_allowance_id);
						$allowance_history['emp_record_id'] = $employee_allowance_details['emp_record_id'];
						$allowance_history['allowance_id'] = $employee_allowance_details['allowance_id'];
						$allowance_history['value'] = $employee_allowance_details['value'];
						$allowance_history['effective_from'] = $employee_allowance_details['effective_from'];
						$allowance_history['status'] = $allowance_change->status;
						$allowance_history['lastupdate'] = $employee_allowance_details['lastupdate'];
						$this->db->trans_start();
						$this->db->insert('hr_emp_allowances_history', $allowance_history);
						$this->db->trans_complete();

						if($allowance_change->status == "Y"){
							$allowance_data['value'] = $allowance_change->value;
							$allowance_data['effective_from'] = $allowance_change->effective_from;
							$allowance_data['status'] = $allowance_change->status;
							$this->db->trans_start();
							$this->db->where('id', $allowance_change->emp_allowance_id);
							$this->db->update('hr_emp_allowances', $allowance_data);
							$this->db->trans_complete();

							$log['emp_record_id'] = $allowance_change->emp_record_id;
							$log['activity'] = "Employee Allowance Amount Updated";
							$log['relevant_table'] = "hr_emp_allowances";
							$log['record_id'] = $allowance_change->emp_allowance_id;
							$this->db->trans_start();
							$this->db->insert('hr_emp_log', $log);
							$this->db->trans_complete();

						}else if($allowance_change->status == "N"){
							$this->db->trans_start();
							$this->db->where('id', $allowance_change->emp_allowance_id);
							$this->db->delete('hr_emp_allowances');
							$this->db->trans_complete();

							$log['emp_record_id'] = $allowance_change->emp_record_id;
							$log['activity'] = "Employee Allowance Removed";
							$log['relevant_table'] = "hr_emp_allowances";
							$log['record_id'] = $allowance_change->emp_allowance_id;
							$this->db->trans_start();
							$this->db->insert('hr_emp_log', $log);
							$this->db->trans_complete();
						}

						$active_record['active_record'] = "past";
						$this->db->trans_start();
						$this->db->where('id', $allowance_change->id);
						$this->db->update('hr_emp_pending_allowances_changes', $active_record);
						$this->db->trans_complete();

					}else{
						$allowance_data1['emp_record_id'] = $allowance_change->emp_record_id;
						$allowance_data1['allowance_id'] = $allowance_change->allowance_id;
						$allowance_data1['value'] = $allowance_change->value;
						$allowance_data1['effective_from'] = $allowance_change->effective_from;
						$allowance_data1['status'] = $allowance_change->status;
						$this->db->trans_start();
						$this->db->insert('hr_emp_allowances', $allowance_data1);
						$allowance_id = $this->db->insert_id();
						$this->db->trans_complete();

						$active_record['active_record'] = "past";
						$this->db->trans_start();
						$this->db->where('id', $allowance_change->id);
						$this->db->update('hr_emp_pending_allowances_changes', $active_record);
						$this->db->trans_complete();

						$log['emp_record_id'] = $allowance_change->emp_record_id;
						$log['activity'] = "Employee Allowance Added";
						$log['relevant_table'] = "hr_emp_allowances";
						$log['record_id'] = $allowance_id;
						$this->db->trans_start();
						$this->db->insert('hr_emp_log', $log);
						$this->db->trans_complete();
					}
				}
			}

			$epf_etf_paye_changes_list = $this->get_emp_epf_etf_paye_changes_list();
			foreach($epf_etf_paye_changes_list as $epf_etf_paye_change){
				if($epf_etf_paye_change->effective_from <= $today_date){
					$employee_salary_details = $this->get_employee_salary_details($epf_etf_paye_change->emp_record_id);
					$data_history['emp_record_id'] = $employee_salary_details['emp_record_id'];
					$data_history['basic_salary'] = $employee_salary_details['basic_salary'];
					$data_history['epf'] = $employee_salary_details['epf'];
					$data_history['etf'] = $employee_salary_details['etf'];
					$data_history['payee_tax'] = $employee_salary_details['payee_tax'];
					$data_history['effective_from'] = $employee_salary_details['effective_from'];
					$data_history['status'] = $employee_salary_details['status'];
					$data_history['updated_by'] = $employee_salary_details['updated_by'];
					$data_history['last_updated'] = $employee_salary_details['last_updated'];
					$this->db->trans_start();
					$this->db->insert('hr_emp_salary_history', $data_history);
					$this->db->trans_complete();

					$data_epf_etf_paye['epf'] = $epf_etf_paye_change->epf;
					$data_epf_etf_paye['etf'] = $epf_etf_paye_change->etf;
					$data_epf_etf_paye['payee_tax'] = $epf_etf_paye_change->payee_tax;
					$data_epf_etf_paye['updated_by'] = $this->session->userdata('username');
					$this->db->trans_start();
					$this->db->where('id', $epf_etf_paye_change->emp_record_id);
					$this->db->update('hr_emp_salary', $data_epf_etf_paye);
					$this->db->trans_complete();

					$active_record['active_record'] = "past";
					$this->db->trans_start();
					$this->db->where('id', $epf_etf_paye_change->id);
					$this->db->update('hr_emp_pending_epf_etf_paye_changes', $active_record);
					$this->db->trans_complete();

					$log['emp_record_id'] = $epf_etf_paye_change->emp_record_id;
					$log['activity'] = "Employee EPF/ETF/Paye Updated ";
					$log['relevant_table'] = "hr_emp_salary";
					$log['record_id'] = $employee_salary_details['id'];
					$this->db->trans_start();
					$this->db->insert('hr_emp_log', $log);
					$this->db->trans_complete();
				}
			}

			$deductions_changes_list = $this->get_emp_deductions_changes_list();
			foreach($deductions_changes_list as $deduction_change){
				if($deduction_change->effective_from <= $today_date){
					if(!empty($deduction_change->emp_deduction_id)){
						$employee_deduction_details = $this->get_employee_deduction_details_by_id($deduction_change->emp_deduction_id);
						$deduction_history['emp_record_id'] = $employee_deduction_details['emp_record_id'];
						$deduction_history['deduction_id'] = $employee_deduction_details['deduction_id'];
						$deduction_history['effective_from'] = $employee_deduction_details['effective_from'];
						$deduction_history['status'] = $deduction_change->status;
						$deduction_history['lastupdate'] = $employee_deduction_details['lastupdate'];
						$this->db->trans_start();
						$this->db->insert('hr_emp_deductions_history', $deduction_history);
						$this->db->trans_complete();

						if($deduction_change->status == "N"){
							$this->db->trans_start();
							$this->db->where('id', $deduction_change->emp_deduction_id);
							$this->db->delete('hr_emp_deductions');
							$this->db->trans_complete();

							$log['emp_record_id'] = $deduction_change->emp_record_id;
							$log['activity'] = "Employee Deduction Removed";
							$log['relevant_table'] = "hr_emp_deductions";
							$log['record_id'] = $deduction_change->emp_deduction_id;
							$this->db->trans_start();
							$this->db->insert('hr_emp_log', $log);
							$this->db->trans_complete();
						}

						$active_record['active_record'] = "past";
						$this->db->trans_start();
						$this->db->where('id', $deduction_change->id);
						$this->db->update('hr_emp_pending_deductions_changes', $active_record);
						$this->db->trans_complete();

					}else{
						$deduction_data['emp_record_id'] = $deduction_change->emp_record_id;
						$deduction_data['deduction_id'] = $deduction_change->deduction_id;
						$deduction_data['effective_from'] = $deduction_change->effective_from;
						$deduction_data['status'] = $deduction_change->status;
						$this->db->trans_start();
						$this->db->insert('hr_emp_deductions', $deduction_data);
						$deduction_id = $this->db->insert_id();
						$this->db->trans_complete();

						$active_record['active_record'] = "past";
						$this->db->trans_start();
						$this->db->where('id', $deduction_change->id);
						$this->db->update('hr_emp_pending_deductions_changes', $active_record);
						$this->db->trans_complete();

						$log['emp_record_id'] = $deduction_change->emp_record_id;
						$log['activity'] = "Employee Deduction Added";
						$log['relevant_table'] = "hr_emp_deductions";
						$log['record_id'] = $deduction_id;
						$this->db->trans_start();
						$this->db->insert('hr_emp_log', $log);
						$this->db->trans_complete();
					}
				}
			}

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}

		}

		public function confirm_emp_increment_decrement($salary_change_id, $emp_id){
			$emp_pending_changes['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $salary_change_id);
			$this->db->update('hr_emp_pending_salary_changes', $emp_pending_changes);
			$this->db->trans_complete();

			$hr_emp_salary_changes_id = $this->input->post('hr_emp_salary_changes_id', TRUE);
			$hr_emp_salary_changes['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $hr_emp_salary_changes_id);
			$this->db->update('hr_emp_salary_changes', $hr_emp_salary_changes);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function confirm_emp_allowances($allowance_change_id, $emp_id){
			$emp_pending_changes['record_status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $allowance_change_id);
			$this->db->update('hr_emp_pending_allowances_changes', $emp_pending_changes);
			$this->db->trans_complete();

			$hr_emp_salary_changes_id = $this->input->post('hr_emp_salary_changes_id', TRUE);
			$hr_emp_salary_changes['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $hr_emp_salary_changes_id);
			$this->db->update('hr_emp_salary_changes', $hr_emp_salary_changes);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function confirm_emp_epf_etf_paye($epf_etf_paye_change_id, $emp_id){
			$emp_pending_changes['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $epf_etf_paye_change_id);
			$this->db->update('hr_emp_pending_epf_etf_paye_changes', $emp_pending_changes);
			$this->db->trans_complete();

			$hr_emp_salary_changes_id = $this->input->post('hr_emp_salary_changes_id', TRUE);
			$hr_emp_salary_changes['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $hr_emp_salary_changes_id);
			$this->db->update('hr_emp_salary_changes', $hr_emp_salary_changes);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function confirm_emp_deductions($deduction_change_id, $emp_id){
			$emp_pending_changes['record_status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $deduction_change_id);
			$this->db->update('hr_emp_pending_deductions_changes', $emp_pending_changes);
			$this->db->trans_complete();

			$hr_emp_salary_changes_id = $this->input->post('hr_emp_salary_changes_id', TRUE);
			$hr_emp_salary_changes['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $hr_emp_salary_changes_id);
			$this->db->update('hr_emp_salary_changes', $hr_emp_salary_changes);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function confirm_employee_salary($salary_id, $emp_id){

			$employee_details = $this->get_employee_details($emp_id);
			$employee_salary_details = $this->get_employee_salary_details($emp_id);

			$data['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $salary_id);
			$this->db->update('hr_emp_salary', $data);
			$this->db->trans_complete();

			$data1['salary_confirmation'] = "Y";
			$data1['basic_salary'] = $employee_salary_details['basic_salary'];
			$this->db->trans_start();
			$this->db->where('id', $emp_id);
			$this->db->update('hr_empmastr', $data1);
			$this->db->trans_complete();

			$emp_trans['emp_record_id'] = $emp_id;
			$emp_trans['emp_no'] = $employee_details['emp_no'];
			$emp_trans['branch'] = $employee_details['branch'];
			$emp_trans['division'] = $employee_details['division'];
			$emp_trans['designation'] = $employee_details['designation'];
			$emp_trans['employment_type'] = $employee_details['employment_type'];
			$emp_trans['leave_category'] = $employee_details['leave_category'];
			$emp_trans['start_date'] = date('Y-m-d');
			$emp_trans['created_by'] = $this->session->userdata('username');
			$emp_trans['basic_salary'] = $employee_salary_details['basic_salary'];
			$this->db->trans_start();
			$this->db->insert('hr_emp_transaction', $emp_trans);
			$this->db->trans_complete();

			$log['emp_record_id'] = $emp_id;
			$log['activity'] = "Employee salary confirmed";
			$log['relevant_table'] = "hr_emp_salary";
			$log['record_id'] = $salary_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}
		public function delete_employee_salary($salary_id, $emp_id){
		// delete employee pending salary for new update
			$this->db->where('emp_record_id', $emp_id);
			$this->db->where('id', $salary_id);
			$this->db->where('status', "N");
			$this->db->delete('hr_emp_salary');
			return true;
		}
		function get_all_emp_salary_changes($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->order_by('status', 'desc');
			$this->db->order_by('id', 'desc');
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_emp_salary_changes');
			return $query->result();
		}

		public function update_employee_loan($employeeMasterID){
			$loan_type = $this->input->post('loan_type', TRUE);
			if($loan_type == "internal_loan"){
				$data['emp_record_id'] = $employeeMasterID;
				$data['loan_type'] = $this->input->post('loan_type', TRUE);
				$data['loan_id'] = $this->input->post('internal_loan_id', TRUE);
				$data['loan_amount'] = $this->input->post('internal_loan_amount', TRUE);
				$data['instalments'] = $this->input->post('internal_instalments', TRUE);
				$data['monthly_deduction_amount'] = $this->input->post('internal_monthly_deduction_amount', TRUE);
				$start_date = $this->input->post('internal_loan_start_date', TRUE);
				$data['start_date'] = date('Y-m-d', strtotime($start_date));
				$end_date = strtotime("+".$this->input->post('internal_instalments', TRUE)." months", strtotime($start_date));
				$end_date = date("Y-m-d", $end_date);
				$data['end_date'] = $end_date;
				$data['status'] = "P";
				$data['created_by'] = $this->session->userdata('username');
				$loan_log = "Internal Loan";
			}else if($loan_type == "external_loan"){
				$data['emp_record_id'] = $employeeMasterID;
				$data['loan_type'] = $this->input->post('loan_type', TRUE);
				$data['instalments'] = $this->input->post('external_instalments', TRUE);
				$data['monthly_deduction_amount'] = $this->input->post('external_monthly_deduction_amount', TRUE);
				$start_date = $this->input->post('external_loan_start_date', TRUE);
				$data['start_date'] = date('Y-m-d', strtotime($start_date));
				$end_date = strtotime("+".$this->input->post('external_instalments', TRUE)." months", strtotime($start_date));
				$end_date = date("Y-m-d", $end_date);
				$data['end_date'] = $end_date;
				$data['bank_code'] = $this->input->post('bank_code', TRUE);
				$data['bank_name'] = $this->input->post('bank_name', TRUE);
				$data['branch_id'] = $this->input->post('bank_branch', TRUE);
				$data['branch_name'] = $this->input->post('bank_branch_name', TRUE);
				$data['account_no'] = $this->input->post('account_no', TRUE);
				$data['account_type'] = $this->input->post('account_type', TRUE);
				$data['status'] = "P";
				$data['created_by'] = $this->session->userdata('username');
				$loan_log = "External Loan";
			}

			$loan_form_submit_type = $this->input->post('loan_form_submit_type', TRUE);
			if($loan_form_submit_type == "insert"){
				$data['created'] = date('Y-m-d H:i:s');
				$this->db->trans_start();
				$this->db->insert('hr_emp_loans', $data);
				$loan_insert_id = $this->db->insert_id();
				$this->db->trans_complete();
				$loan_submit_log = "Insert";
			}else if($loan_form_submit_type == "update"){
				$loan_record_id = $this->input->post('loan_record_id', TRUE);
				$this->db->trans_start();
				$this->db->where('id', $loan_record_id);
				$this->db->update('hr_emp_loans', $data);
				$this->db->trans_complete();
				$loan_insert_id = $loan_record_id;
				$loan_submit_log = "Update";
			}

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employee - ".$loan_log." - ".$loan_submit_log;
			$log['relevant_table'] = "hr_emp_loans";
			$log['record_id'] = $loan_insert_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();


			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function confirm_employee_loan($loan_id){
			$data['status'] = "Y";
			$this->db->trans_start();
			$this->db->where('id', $loan_id);
			$this->db->update('hr_emp_loans', $data);
			$this->db->trans_complete();
		}

		public function validate_employee_loan_effective_from_date(){
			$today_date = date('Y-m-d');
			$employee_loan_list = $this->get_emp_loan_list();
			foreach($employee_loan_list as $employee_loan){
				if($employee_loan->active_loan == "P" && $employee_loan->start_date <= $today_date){
					$data['active_loan'] = "Y";
					$this->db->trans_start();
					$this->db->where('id', $employee_loan->id);
					$this->db->update('hr_emp_loans', $data);
					$this->db->trans_complete();
				}

				if($employee_loan->instalments == $employee_loan->paid_installmen_count){
					$data1['active_loan'] = "N";
					$this->db->trans_start();
					$this->db->where('id', $employee_loan->id);
					$this->db->update('hr_emp_loans', $data1);
					$this->db->trans_complete();
				}
			}
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}


		function get_all_emp_loan($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->order_by('id');
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_emp_loans');
			return $query->result();
		}

		function get_emp_loan_list(){
			$this->db->select('*');
			$this->db->order_by('id');
			$this->db->where('status', 'Y');
			$query = $this->db->get('hr_emp_loans');
			return $query->result();
		}

		function get_emp_loan_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_loans');
			return $query->row_array();
		}

		function get_employee_salary_details($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_emp_salary');
			return $query->row_array();
		}

		function get_emp_increment_decrement_changes_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_pending_salary_changes');
			return $query->row_array();
		}

		function get_emp_increment_decrement_changes_list(){
			$this->db->select('*');
			$this->db->where('active_record', 'active');
			$this->db->where('status', 'Y');
			$query = $this->db->get('hr_emp_pending_salary_changes');
			return $query->result();
		}

		function get_emp_allowance_changes_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_pending_allowances_changes');
			return $query->row_array();
		}

		function get_emp_allowances_changes_list(){
			$this->db->select('*');
			$this->db->where('active_record', 'active');
			$this->db->where('record_status', 'Y');
			$query = $this->db->get('hr_emp_pending_allowances_changes');
			return $query->result();
		}

		function get_emp_epf_etf_paye_changes_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_pending_epf_etf_paye_changes');
			return $query->row_array();
		}

		function get_emp_epf_etf_paye_changes_list(){
			$this->db->select('*');
			$this->db->where('active_record', 'active');
			$this->db->where('status', 'Y');
			$query = $this->db->get('hr_emp_pending_epf_etf_paye_changes');
			return $query->result();
		}

		function get_emp_eduction_changes_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_pending_deductions_changes');
			return $query->row_array();
		}

		function get_emp_deductions_changes_list(){
			$this->db->select('*');
			$this->db->where('active_record', 'active');
			$this->db->where('record_status', 'Y');
			$query = $this->db->get('hr_emp_pending_deductions_changes');
			return $query->result();
		}

		function get_emp_salary_changes_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_salary_changes');
			return $query->row_array();
		}

		function get_employee_allowances_details($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$this->db->where('status', 'Y');
			$this->db->order_by('id', 'asc');
			$query = $this->db->get('hr_emp_allowances');
			return $query->result();
		}

		function get_employee_allowance_details_by_id($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_allowances');
			return $query->row_array();
		}

		function get_employee_allowances_details_by_emp_id_allowance_id($emp_id, $allowance_id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $emp_id);
			$this->db->where('allowance_id', $allowance_id);
			$query = $this->db->get('hr_emp_allowances');
			return $query->row_array();
		}

		function get_employee_deductions_details($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$this->db->where('status', 'Y');
			$query = $this->db->get('hr_emp_deductions');
			return $query->result();
		}

		function get_employee_deduction_details_by_id($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_deductions');
			return $query->row_array();
		}

		function get_employee_deduction_details_by_emp_id_allowance_id($emp_id, $deduction_id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $emp_id);
			$this->db->where('deduction_id', $deduction_id);
			$this->db->where('status', 'Y');
			$this->db->order_by('id', 'asc');
			$query = $this->db->get('hr_emp_deductions');
			return $query->row_array();
		}

		function get_all_emp_transactions($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->order_by('id', 'desc');
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_emp_transaction');
			return $query->result();
		}

		function get_all_emp_equipment($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->order_by('id');
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_emp_equipment');
			return $query->result();
		}

		public function update_employee_equipment($employeeMasterID){
			$data['emp_record_id'] = $employeeMasterID;
			$data['equipment_category'] = $this->input->post('equipment_category', TRUE);
			$data['equipment_name'] = $this->input->post('equipment_name', TRUE);
			$data['brand'] = $this->input->post('brand', TRUE);
			$data['serial_number'] = $this->input->post('serial_number', TRUE);
			$data['value'] = $this->input->post('value', TRUE);
			$data['inventory_number'] = $this->input->post('inventory_number', TRUE);
			$from_date = $this->input->post('from_date', TRUE);
			$data['from_date'] = date('Y-m-d', strtotime($from_date));
			$data['status'] = "P";
			$data['created_by'] = $this->session->userdata('username');

			$form_submit_type = $this->input->post('form_submit_type', TRUE);
			if($form_submit_type == "insert"){
				$data['created'] = date('Y-m-d H:i:s');
				$this->db->trans_start();
				$this->db->insert('hr_emp_equipment', $data);
				$last_insert_id = $this->db->insert_id();
				$this->db->trans_complete();
				$loan_submit_log = "Added";
			}else if($form_submit_type == "update"){
				$record_id = $this->input->post('record_id', TRUE);
				$this->db->trans_start();
				$this->db->where('id', $record_id);
				$this->db->update('hr_emp_equipment', $data);
				$this->db->trans_complete();
				$last_insert_id = $record_id;
				$loan_submit_log = "Details Updated";
			}

			$log['emp_record_id'] = $employeeMasterID;
			$log['activity'] = "Employee - Equipment ".$loan_submit_log;
			$log['relevant_table'] = "hr_emp_equipment";
			$log['record_id'] = $last_insert_id;
			$this->db->trans_start();
			$this->db->insert('hr_emp_log', $log);
			$this->db->trans_complete();


			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return true;
			}
		}

		public function confirm_employee_equipment($id){
			$data['status'] = "A";
			$this->db->trans_start();
			$this->db->where('id', $id);
			$this->db->update('hr_emp_equipment', $data);
			$this->db->trans_complete();
		}

		function get_emp_equipment_details($id){
			$this->db->select('*');
			$this->db->where('id', $id);
			$query = $this->db->get('hr_emp_equipment');
			return $query->row_array();
		}

		function get_payroll_master_list($pagination_counter, $page_count){
			$this->db->select('*');
			$this->db->order_by('id', 'desc');
			$this->db->limit($pagination_counter, $page_count);
			$query = $this->db->get('hr_payroll_master');
			return $query->result();
		}

		public function run_monthly_payroll(){

			$year = $this->input->post('year', TRUE);
			$month = $this->input->post('month', TRUE);

			$data['year'] = $year;
			$data['month'] = $month;
			$data['generated_by'] = $this->session->userdata('username');

			$this->db->trans_start();
			$this->db->insert('hr_payroll_master', $data);
			$last_insert_id = $this->db->insert_id();
			$this->db->trans_complete();

			$employee_salary_list = $this->get_employee_salary_list();

			foreach($employee_salary_list as $employee_salary){
				if($employee_salary->status == "Y"){
					$basic_salary = $employee_salary->basic_salary;

					$payroll_data['payroll_master_id'] = $last_insert_id;
					$payroll_data['emp_record_id'] = $employee_salary->emp_record_id;
					$payroll_data['basic_salary'] = $basic_salary;


					$employee_allowance_list = $this->get_employee_allowances_details($employee_salary->emp_record_id);
					$allowance_total = 0;
					$emp_tax_free_amount_tot = 0;
				$bra=0;//BRA
				foreach($employee_allowance_list as $employee_allowance){
					$allowance_details = $this->get_allowance_details($employee_allowance->allowance_id);

					if($allowance_details['amount_type'] == "AMOUNT"){
						$alowance_value = $employee_allowance->value;
					}else if($allowance_details['amount_type'] == "PRECENTAGE"){
						$alowance_value = $basic_salary * ($employee_allowance->value/100);
					}
					$allowance_total = $allowance_total + $alowance_value;

					if($employee_allowance->allowance_id==2)
						$bra= $alowance_value;;
					if($allowance_details['tax_applicable'] == "Yes"){
						if(!empty($allowance_details['tax_free_amount'])){
							if($alowance_value >= $allowance_details['tax_free_amount']){
								$emp_tax_free_amount_tot = $emp_tax_free_amount_tot + $allowance_details['tax_free_amount'];
							}else if($alowance_value < $allowance_details['tax_free_amount']){
								$emp_tax_free_amount_tot = $emp_tax_free_amount_tot + $alowance_value;
							}
						}
					}else if($allowance_details['tax_applicable'] == "No"){
						$emp_tax_free_amount_tot = $emp_tax_free_amount_tot + $alowance_value;
					}

					$allowance_for_payroll_data['payroll_master_id'] = $last_insert_id;
					$allowance_for_payroll_data['emp_record_id'] = $employee_salary->emp_record_id;
					$allowance_for_payroll_data['allowance_id'] = $allowance_details['id'];
					$allowance_for_payroll_data['amount'] = $alowance_value;

					$this->db->trans_start();
					$this->db->insert('hr_emp_allowance_for_payroll', $allowance_for_payroll_data);
					$this->db->trans_complete();
				}
				$payroll_data['allowance_total'] = $allowance_total;
				$payroll_data['tax_free_allowance_amount_total'] = $emp_tax_free_amount_tot;

				$gross_salary = $basic_salary + $allowance_total;
				$payroll_data['gross_salary'] = $gross_salary;

				$no_pay_deduction = 0;
				$no_pay_deduction_for_epf_etf = 0;
				$emp_no_pay_leave_master = $this->check_emp_no_pay_leave_master_year_month($year, $month);
				if(count($emp_no_pay_leave_master)>0){
					if($emp_no_pay_leave_master['status'] == "Y"){
						$emp_no_pay_list = $this->get_emp_no_pay_for_payroll($emp_no_pay_leave_master['id'], $employee_salary->emp_record_id);
						$payroll_data['no_pay_count'] = $emp_no_pay_list['no_pay_count_final'];
						$no_pay_deduction = ($gross_salary/26) * $emp_no_pay_list['no_pay_count_final'];
						$no_pay_deduction =  round($no_pay_deduction, 2);
						$payroll_data['no_pay_deduction'] = $no_pay_deduction;

						$payroll_data['no_pay_deduction_for_epf_etf']=$no_pay_deduction_for_epf_etf = ($basic_salary/26) * $emp_no_pay_list['no_pay_count_final'];
						$no_pay_deduction_for_epf_etf =  round($no_pay_deduction_for_epf_etf, 2);
					}
				}
				$payroll_data['no_pay_deduction_for_epf_etf']=$no_pay_deduction_for_epf_etf;

				$epf_etf_details = $this->get_all_epf_etf();
				$epf_employee_contribution = 0;
				$epf_employer_contribution = 0;
				$etf_employee_contribution = 0;
				$etf_employer_contribution = 0;
				foreach($epf_etf_details as $epf_etf){
					if($epf_etf->type == "EPF"){
						if($employee_salary->epf == "Y"){
							//Adding BRA to epf and etf
							$epf_employee_contribution = ($basic_salary - $no_pay_deduction_for_epf_etf +$bra) * ($epf_etf->employee_contribution/100);
							$epf_employee_contribution =  round($epf_employee_contribution, 2);
							$epf_employer_contribution = ($basic_salary - $no_pay_deduction_for_epf_etf +$bra) * ($epf_etf->employer_contribution/100);
							$epf_employer_contribution =  round($epf_employer_contribution, 2);
						}
					}
					if($epf_etf->type == "ETF"){
						if($employee_salary->etf == "Y"){
							//Adding BRA to epf and etf
							$etf_employee_contribution = ($basic_salary - $no_pay_deduction_for_epf_etf +$bra) * ($epf_etf->employee_contribution/100);
							$etf_employee_contribution =  round($etf_employee_contribution, 2);
							$etf_employer_contribution = ($basic_salary - $no_pay_deduction_for_epf_etf +$bra) * ($epf_etf->employer_contribution/100);
							$etf_employer_contribution =  round($etf_employer_contribution, 2);
						}
					}
				}
				$payroll_data['epf_emp'] = $epf_employee_contribution;
				$payroll_data['epf_company'] = $epf_employer_contribution;
				$payroll_data['etf_emp'] = $etf_employee_contribution;
				$payroll_data['etf_company'] = $etf_employer_contribution;


				$paye_amount = 0;
				$taxable_salary = 0;
				$balance_amount = 0;
				$balance_taxable_salary = 0;
				if($employee_salary->payee_tax == "Y"){
					$taxable_salary = $gross_salary - $emp_tax_free_amount_tot;

					$this->db->select('*');
					$this->db->where('from_amount <=', $taxable_salary);
					$this->db->where('to_amount >=', $taxable_salary);
					$query = $this->db->get('hr_paye');
					$paye_row = $query->row_array();
					if(count($paye_row) > 0){
						if($paye_row['tax_plus_percentage'] == "Y"){
							$balance_amount = $taxable_salary - $paye_row['from_amount']+1;
							$paye_amount = $paye_row['tax']+($balance_amount*($paye_row['percentage']/100));
						}else{
							$paye_amount = $paye_row['tax'];
						}
					}
				}
				$payroll_data['paye'] = $paye_amount;


				$employee_deduction_list = $this->get_employee_deductions_details($employee_salary->emp_record_id);
				$deduction_total = 0;
				foreach($employee_deduction_list as $employee_deduction){
					$deduction_details = $this->get_deduction_details($employee_deduction->deduction_id);

					if($deduction_details['amount_type'] == "AMOUNT"){
						$deduction_value = $deduction_details['value'];
						$deduction_total = $deduction_total + $deduction_value;
					}else if($deduction_details['amount_type'] == "PRECENTAGE"){
						$deduction_value = $basic_salary * ($deduction_details['value']/100);
						$deduction_total = $deduction_total + $deduction_value;
					}

					$deduction_for_payroll_data['payroll_master_id'] = $last_insert_id;
					$deduction_for_payroll_data['emp_record_id'] = $employee_salary->emp_record_id;
					$deduction_for_payroll_data['deduction_id'] = $deduction_details['id'];
					$deduction_for_payroll_data['amount'] = $deduction_value;

					$this->db->trans_start();
					$this->db->insert('hr_emp_deductions_for_payroll', $deduction_for_payroll_data);
					$this->db->trans_complete();
				}
				$payroll_data['deduction_total'] = $deduction_total;

				$this->db->select('*');
				$this->db->where('emp_record_id', $employee_salary->emp_record_id);
				$this->db->where('status', 'Y');
				$this->db->where('active_loan', 'Y');
				$query = $this->db->get('hr_emp_loans');
				$emp_loan_list = $query->result();

				$loan_deduction_amount_total = 0;
				foreach($emp_loan_list as $emp_loan){
					$loan_deduction_amount_total = $loan_deduction_amount_total + $emp_loan->monthly_deduction_amount;
				}
				$payroll_data['loan_total'] = $loan_deduction_amount_total;


				$salary_advance_deduction = 0;
				$emp_salary_advance_master = $this->check_emp_salary_advance_master_year_month($year, $month);
				if(count($emp_salary_advance_master)>0){
					if($emp_salary_advance_master['status'] == "Y"){
						$emp_salary_advance = $this->get_emp_salary_advance_for_payroll($emp_salary_advance_master['id'], $employee_salary->emp_record_id);
						$salary_advance_deduction = $emp_salary_advance['salary_advance_amount'];;
						$payroll_data['salary_advance_amount'] = $salary_advance_deduction;
					}
				}

				$emp_phonebill_master = $this->check_emp_phonebill_master_year_month($year, $month);
				if(count($emp_phonebill_master)>0){
					if($emp_phonebill_master['status'] == "Y"){
						$emp_phonebill_list = $this->get_emp_phonebill_for_payroll($emp_phonebill_master['id'], $employee_salary->emp_record_id);
						$phonebill_deduction=$emp_phonebill_list['bill_value'];
						if($emp_phonebill_list){
							$payroll_data['phonebill_deduction'] =$phonebill_deduction;
						}else{
							$payroll_data['phonebill_deduction'] = 0;
						}

					}
				}//updated by nadee ticket id 1636

				$net_salary = $gross_salary - ($deduction_total + $loan_deduction_amount_total + $epf_employee_contribution + $etf_employee_contribution + $paye_amount + $no_pay_deduction + $salary_advance_deduction);
				$net_salary = round($net_salary, 2);
				$payroll_data['net_salary'] = $net_salary;

				$payroll_data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_payroll', $payroll_data);
				$this->db->trans_complete();
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_emp_payroll_list($id){
		$this->db->select('hr_emp_payroll.*');
		$this->db->where('payroll_master_id', $id);
		$this->db->join('hr_empmastr','hr_emp_payroll.emp_record_id=hr_empmastr.id');
		$this->db->order_by('hr_empmastr.epf_no');
		$query = $this->db->get('hr_emp_payroll');
		return $query->result();
	}

	function get_emp_payroll_master_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_payroll_master');
		return $query->row_array();
	}

	function check_emp_payroll_master_year_month($year, $month){
		$this->db->select('*');
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$this->db->where('status !=', 'N');
		$query = $this->db->get('hr_payroll_master');
		return $query->row_array();
	}

	function decline_monthly_payroll($id){
		$payroll_master['status'] = "N";
		$payroll_master['confirmed_by'] = $this->session->userdata('username');
		$payroll_master['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_payroll_master', $payroll_master);
		$this->db->trans_complete();

		$payroll_data['status'] = "N";

		$this->db->trans_start();
		$this->db->where('payroll_master_id', $id);
		$this->db->update('hr_emp_payroll', $payroll_data);
		$this->db->trans_complete();
	}

	public function confirm_employee_payroll_list($id){
		$data['status'] = "Y";
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_payroll_master', $data);
		$this->add_vauchers_payroll($id);
		$this->db->trans_complete();

		$emp_loan_list = $this->get_emp_loan_list();
		foreach($emp_loan_list as $emp_loan){
			if($emp_loan->active_loan == "Y"){
				$loan_data['paid_installmen_count'] = $emp_loan->paid_installmen_count + 1;
				$this->db->trans_start();
				$this->db->where('id', $emp_loan->id);
				$this->db->update('hr_emp_loans', $loan_data);
				$this->db->trans_complete();
			}
		}
	}

	function get_allowance_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_allowances');
		return $query->row_array();
	}

	function get_all_epf_etf(){
		$this->db->select('*');
		$this->db->order_by('id');
		$query = $this->db->get('hr_epf_etf');
		return $query->result();
	}

	function get_deduction_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_deductions');
		return $query->row_array();
	}

	function get_employee_payroll_allowance_list($payroll_master_id, $emp_record_id, $allowance_id){
		$this->db->select('*');
		$this->db->where('payroll_master_id', $payroll_master_id);
		$this->db->where('emp_record_id', $emp_record_id);
		$this->db->where('allowance_id', $allowance_id);
		$query = $this->db->get('hr_emp_allowance_for_payroll');
		return $query->row_array();
	}
	function get_employee_payroll_allowance_list_sum($payroll_master_id, $allowance_id){
		$this->db->select('SUM(amount) total');
		$this->db->where('payroll_master_id', $payroll_master_id);
		$this->db->where('allowance_id', $allowance_id);
		$query = $this->db->get('hr_emp_allowance_for_payroll');
		return $query->row_array();
	}

	function get_employee_payroll_deduction_list($payroll_master_id, $emp_record_id, $allowance_id){
		$this->db->select('hr_emp_deductions_for_payroll.*,hr_deductions.deduction');
		$this->db->join('hr_deductions','hr_deductions.id=hr_emp_deductions_for_payroll.deduction_id');
		$this->db->where('payroll_master_id', $payroll_master_id);
		$this->db->where('emp_record_id', $emp_record_id);
		$this->db->where('deduction_id', $allowance_id);
		$query = $this->db->get('hr_emp_deductions_for_payroll');
		return $query->row_array();
	}

	function get_employee_additional_fuel_allowance_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('status', 'asc');
		$this->db->order_by('date', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_emp_fuel_allowance_additional');
		return $query->result();
	}

	function get_all_pending_employee_additional_fuel_allowance_list(){
		$this->db->select('*');
		$this->db->where('status', 'P');
		$query = $this->db->get('hr_emp_fuel_allowance_additional');
		return $query->result();
	}

	function get_fuel_allowance_additional_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_emp_fuel_allowance_additional');
		return $query->row_array();
	}

	function confirm_additional_fuel_request(){
		$id = $this->input->post('id', TRUE);
		$data['approved_amount'] = $this->input->post('approved_amount', TRUE);
		$data['status'] = "Y";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_fuel_allowance_additional', $data);
		$this->db->trans_complete();
	}

	function decline_additional_fuel_request($id){
		$data['status'] = "N";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_fuel_allowance_additional', $data);
		$this->db->trans_complete();
	}

	function get_fuel_allowance_payment_master_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_fuel_allowance_payment_master');
		return $query->result();
	}

	function get_employee_meter_reading_list($emp_id, $year, $month, $start_date, $end_date){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('YEAR(effective_date)', $year);
		$this->db->where('MONTH(effective_date)', $month);
		$this->db->where('effective_date >=', $start_date);
		$this->db->where('effective_date <=', $end_date);
		$this->db->order_by('id');
		$query = $this->db->get('hr_emp_meter_reading');
		return $query->result();
	}

	function get_employee_fuel_allowance_additional($emp_id, $year, $month){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('YEAR(date)', $year);
		$this->db->where('MONTH(date)', $month);
		$this->db->where('status', 'Y');
		$query = $this->db->get('hr_emp_fuel_allowance_additional');
		return $query->result();
	}

	public function run_monthly_fuel_allowance_payment(){
		date_default_timezone_set('Asia/Colombo');
		$from_date=$this->input->post('from_date', TRUE);
		$todate=$this->input->post('to_date', TRUE);
		$year = date('Y',strtotime($from_date));
		$data['year'] = $year;
		$month = date('m',strtotime($from_date));
		$data['month'] = $month;
		$data['generated_by'] = $this->session->userdata('username');

		$end_date = date('Y-m-d',strtotime($todate));
		$year_month_validation = $this->check_emp_emp_fuel_allowance_payment_year_month($year, $month);
		if(count($year_month_validation)>0){
			foreach($year_month_validation as $year_month_validation_row){
				$last_end_date = $year_month_validation_row->end_date;
			}
			$start_date = date('Y-m-d', strtotime($last_end_date.' +1 day'));
			$year = date('Y',strtotime($start_date));
			$data['year'] = $year;
			$month = date('m',strtotime($start_date));
			$data['month'] = $month;
			if($start_date>$end_date){
				return false;
			}

		}else{
			/*$start_date = date($year.'-'.$month.'-01');
			$end_date = date($year.'-'.$month.'-d');
			//$end_date = date('Y-m-d', strtotime($end_date.' -1 day'));
			if(date('d')=='01'){
				$end_date = date('Y-m-t', strtotime($start_date));
			}

			//$end_date = date('Y-m-t', strtotime($start_date));*/
			$start_date = date('Y-m-d', strtotime($from_date));


		}
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;

		$this->db->trans_start();
		$this->db->insert('hr_fuel_allowance_payment_master', $data);
		$last_insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		$employee_list = $this->get_employee_list();
		$total_amount_payable = 0;
		foreach($employee_list as $employee){
			if($employee->status == 'A' && $employee->fuel_allowance_status == 'Y'){
				$emp_id = $employee->id;
				$employee_meter_reading_list = $this->get_employee_meter_reading_list($emp_id, $year, $month, $start_date, $end_date);
				$employee_fuel_allowance_additional_list = $this->get_employee_fuel_allowance_additional($emp_id, $year, $month);

				$additional_amount = 0;
				foreach($employee_fuel_allowance_additional_list as $employee_fuel_allowance_additional){
					$additional_amount = $additional_amount + $employee_fuel_allowance_additional->approved_amount;
				}

				$exceeded_amount = 0;
				$total_km = 0;
				$official_km = 0;
				$private_km = 0;
				$total_amount = 0;
				$exceeded_amount = 0;
				$total_amount_payable = 0;
				foreach($employee_meter_reading_list as $employee_meter_reading){
					$exceeded_amount = $exceeded_amount + $employee_meter_reading->exceeded_amount;
					$official_km = $official_km + $employee_meter_reading->official;
					$total_km = $total_km + $employee_meter_reading->difference;
					$private_km = $total_km - $official_km;
					$total_amount = $total_amount + $employee_meter_reading->amount;
				}
				$total_amount_payable = $total_amount - $exceeded_amount;

				$allowance_payment_data['allowancee_payment_master_id'] = $last_insert_id;
				$allowance_payment_data['emp_record_id'] = $emp_id;
				$allowance_payment_data['max_limit'] = $employee->fuel_allowance_maximum_limit;
				$allowance_payment_data['additional_fuel'] = $additional_amount;
				$allowance_payment_data['exceeded_amount'] = $exceeded_amount;
				$allowance_payment_data['official_km'] = $official_km;
				$allowance_payment_data['private_km'] = $private_km;
				$allowance_payment_data['total_km'] = $total_km;
				$allowance_payment_data['total_amount'] = $total_amount;
				$allowance_payment_data['total_amount_payable'] = $total_amount_payable;
				$allowance_payment_data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_fuel_allowance_payment', $allowance_payment_data);
				$this->db->trans_complete();
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_emp_fuel_allowance_payment_master_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_fuel_allowance_payment_master');
		return $query->row_array();
	}

	function get_emp_fuel_allowance_payment_list($id){
		$this->db->select('*');
		$this->db->where('allowancee_payment_master_id', $id);
		$query = $this->db->get('hr_emp_fuel_allowance_payment');
		return $query->result();
	}

	function check_emp_emp_fuel_allowance_payment_year_month($year, $month){
		$this->db->select('*');
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$query = $this->db->get('hr_fuel_allowance_payment_master');
		return $query->result();
	}
	function check_emp_emp_fuel_allowance_payment_to_from(){
		$this->db->select('*');
		$this->db->where('status','P');
		$query = $this->db->get('hr_fuel_allowance_payment_master');
		if ($query->num_rows() > 0){
			return true;
		}else
		return false;

	}

	function get_emp_fuel_allowance_payment_sum($id){
		$this->db->select('SUM(total_amount_payable) as tot');
		$this->db->where('allowancee_payment_master_id', $id);
		$query = $this->db->get('hr_emp_fuel_allowance_payment');

		if ($query->num_rows() > 0) {

			$data= $query->row();
			return $data->tot;

		}
		else return 0;

	}
	function get_emp_fuel_allowance_payment_master_details_confirmlist($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->where('status', 'P');
		$query = $this->db->get('hr_fuel_allowance_payment_master');
		return $query->row();
	}
	public function confirm_employee_fuel_allowance_payment($id){

		$dataset=$this->get_emp_fuel_allowance_payment_master_details_confirmlist($id);
		$tot=$this->get_emp_fuel_allowance_payment_sum($id);
		//$monthName = date('F', mktime(0, 0, 0, $dataset->month, 10));
		$ledger=$this->get_hr_ledgers('Fuel allowance');
		$des="Fuel  Allowance  for ".$dataset->start_date. "to ".$dataset->end_date;
		 $idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date('Y-m-d'));
					$voucherid=$idlist[0];
		$data=array(
			'voucherid'=>$voucherid,
			'vouchercode'=>$idlist[1],
			'branch_code' => $this->session->userdata('branchid'),
			'ledger_id' =>$ledger,
			'payeename' => 'Cash' ,
			'vouchertype' => '10',
			'paymentdes' => $des,
			'amount' => number_format($tot,2),
			'applydate' =>date('Y-m-d'),
			'status' => 'CONFIRMED',

		);
		if(!$this->db->insert('ac_payvoucherdata', $data))
		{
			$this->db->trans_rollback();
			$this->logger->write_message("error", "Error confirming Project");
			return false;
		}

		$data1['status'] = "Y";
		$data1['voucher_id'] = $voucherid;
		$data1['confirmed_by'] = $this->session->userdata('username');
		$data1['confirmed_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_fuel_allowance_payment_master', $data1);

		$this->db->trans_complete();
	}

	function get_emp_fuel_allowance_report($start_date, $end_date, $emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('effective_date >=', $start_date);
		$this->db->where('effective_date <=', $end_date);
		$query = $this->db->get('hr_emp_meter_reading');
		return $query->result();
	}

	function get_no_pay_leave_master_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_no_pay_leave_master');
		return $query->result();
	}

	function get_no_pay_list_by_year_month($year, $month){
		$employee_list = $this->get_employee_list();
		$employee_no_pay_details = array();
		$count = 0;
		foreach($employee_list as $employee){
			if($employee->status == 'A'){
				$this->db->select('*');
				$this->db->where('YEAR(start_date)', $year);
				$this->db->where('MONTH(start_date)', $month);
				$this->db->where('approval', 'A');
				$this->db->where('emp_record_id', $employee->id);
				$this->db->order_by('id');
				$query = $this->db->get('hr_emp_leave_records');
				$emp_leave_records = $query->result();
				$emp_no_pay_leave_count = 0;
				if(count($emp_leave_records) > 0){
					foreach($emp_leave_records as $emp_leave_record){
						$emp_no_pay_leave_count = $emp_no_pay_leave_count + $emp_leave_record->no_pay_days;
					}
				}
				array_push($employee_no_pay_details, ['emp_id' => $employee->id, 'no_pay_count' => $emp_no_pay_leave_count]);
				$count++;
			}
		}
		return $employee_no_pay_details;
	}

	function check_emp_no_pay_leave_master_year_month($year, $month){
		$this->db->select('*');
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$this->db->where('status !=','N');
		$query = $this->db->get('hr_no_pay_leave_master');
		return $query->row_array();
	}

	public function submit_no_pay_leave_list(){

		$year = $this->input->post('year', TRUE);
		$data['year'] = $year;
		$month = $this->input->post('month', TRUE);
		$data['month'] = $month;
		$data['generated_by'] = $this->session->userdata('username');

		$this->db->trans_start();
		$this->db->insert('hr_no_pay_leave_master', $data);
		$last_insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		$employee_list = $this->get_employee_list();
		foreach($employee_list as $employee){
			if($employee->status == 'A' && $employee->salary_confirmation == 'Y'){

				$no_pay_data['no_pay_leave_master_id'] = $last_insert_id;
				$no_pay_data['emp_record_id'] = $employee->id;
				$no_pay_data['no_pay_count_system'] = $this->input->post('no_pay_count_'.$employee->id, TRUE);
				$edit_no_pay_count = $this->input->post('edit_no_pay_count_'.$employee->id, TRUE);
				if(!empty($edit_no_pay_count)){
					$no_pay_data['no_pay_count_final'] = $this->input->post('edit_no_pay_count_'.$employee->id, TRUE);
				}else{
					$no_pay_data['no_pay_count_final'] = $this->input->post('no_pay_count_'.$employee->id, TRUE);
				}

				$no_pay_data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_no_pay_leave_counts', $no_pay_data);
				$this->db->trans_complete();
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function edit_no_pay_leave_list(){

		$year = $this->input->post('year', TRUE);
		$data['year'] = $year;
		$month = $this->input->post('month', TRUE);
		$data['month'] = $month;
		$data['generated_by'] = $this->session->userdata('username');


		$employee_list = $this->get_employee_list();
		foreach($employee_list as $employee){
			if($employee->status == 'A'){

				$no_pay_leave_master_id= $this->input->post('no_pay_leave_'.$employee->id, TRUE);;
				$no_pay_data['no_pay_count_system'] = $this->input->post('no_pay_count_'.$employee->id, TRUE);
				$edit_no_pay_count = $this->input->post('edit_no_pay_count_'.$employee->id, TRUE);
				if(!empty($edit_no_pay_count)){
					$no_pay_data['no_pay_count_final'] = $this->input->post('edit_no_pay_count_'.$employee->id, TRUE);
				}else{
					$no_pay_data['no_pay_count_final'] = $this->input->post('no_pay_count_'.$employee->id, TRUE);
				}

				$no_pay_data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->where('no_pay_leave_master_id',$no_pay_leave_master_id);
				$this->db->where('emp_record_id',$employee->id);
				$this->db->update('hr_emp_no_pay_leave_counts', $no_pay_data);

				$this->db->trans_complete();
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_emp_no_pay_master_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_no_pay_leave_master');
		return $query->row_array();
	}

	function get_emp_no_pay_list($id){
		$this->db->select('*');
		$this->db->where('no_pay_leave_master_id', $id);
		$query = $this->db->get('hr_emp_no_pay_leave_counts');
		return $query->result();
	}

	public function confirm_employee_no_pay_leave($id){
		$data['status'] = "Y";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_no_pay_leave_master', $data);
		$this->db->trans_complete();
	}

	function get_emp_no_pay_for_payroll($id, $emp_id){
		$this->db->select('*');
		$this->db->where('no_pay_leave_master_id', $id);
		$this->db->where('emp_record_id', $emp_id);
		$query = $this->db->get('hr_emp_no_pay_leave_counts');
		return $query->row_array();
	}


	function get_salary_advance_master_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_emp_salary_advance_master');
		return $query->result();
	}

	function check_emp_salary_advance_master_year_month($year, $month){
		$this->db->select('*');
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$this->db->where('status !=','N');
		$query = $this->db->get('hr_emp_salary_advance_master');
		return $query->row_array();
	}

	public function submit_salary_advance_list(){

		$year = $this->input->post('year', TRUE);
		$data['year'] = $year;
		$month = $this->input->post('month', TRUE);
		$data['month'] = $month;
		$data['generated_by'] = $this->session->userdata('username');

		$this->db->trans_start();
		$this->db->insert('hr_emp_salary_advance_master', $data);
		$last_insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		$employee_list = $this->get_employee_list();
		foreach($employee_list as $employee){
			if($employee->status == 'A' && $employee->salary_confirmation == 'Y'){

				$salary_advance_data['salary_advance_master_id'] = $last_insert_id;
				$salary_advance_data['emp_record_id'] = $employee->id;
				$salary_advance_amount = 0;
				$salary_advance_amount = $this->input->post('salary_advance_amount_'.$employee->id, TRUE);
				if(!empty($salary_advance_amount)){
					$salary_advance_data['salary_advance_amount'] = $salary_advance_amount;
				}else{
					$salary_advance_data['salary_advance_amount'] = 0;
				}

				$salary_advance_data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_salary_advance', $salary_advance_data);
				$this->db->trans_complete();
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_emp_salary_advance_master_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_emp_salary_advance_master');
		return $query->row_array();
	}

	function get_emp_salary_advance_list($id){
		$this->db->select('*');
		$this->db->where('salary_advance_master_id', $id);
		$query = $this->db->get('hr_emp_salary_advance');
		return $query->result();
	}

	public function confirm_employee_salary_advance($id){
		$data['status'] = "Y";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_salary_advance_master', $data);
		$this->db->trans_complete();
	}

	function get_emp_salary_advance_for_payroll($id, $emp_id){
		$this->db->select('*');
		$this->db->where('salary_advance_master_id', $id);
		$this->db->where('emp_record_id', $emp_id);
		$query = $this->db->get('hr_emp_salary_advance');
		return $query->row_array();
	}

	function get_emp_salary_advance_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_emp_salary_advance');
		return $query->row_array();
	}

	public function update_emp_salary_advance_amount(){
		$ID = $this->input->post('id', TRUE);
		$data['salary_advance_amount'] = $this->input->post('salary_advance_amount', TRUE);
		$this->db->trans_start();
		$this->db->where('id', $ID);
		$this->db->update('hr_emp_salary_advance', $data);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}


	function get_employee_leave_list($pagination_counter, $page_count){
		$this->db->select('hr_emp_leave_records.*');
		$this->db->order_by('epf_no');
		$this->db->join('hr_empmastr','hr_emp_leave_records.emp_record_id=hr_empmastr.id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function get_employee_leave_list_all(){
		$this->db->select('hr_emp_leave_records.*');
		$this->db->order_by('epf_no');
		$this->db->join('hr_empmastr','hr_emp_leave_records.emp_record_id=hr_empmastr.id');
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	function get_leave_report($year){
		$this->db->select('*');
		$this->db->where('YEAR(start_date)', $year);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('hr_emp_leave_records');
		return $query->result();
	}

	public function get_branch_employee_list($branch_code){
		$this->db->select('*');
		$this->db->order_by('epf_no', 'asc');
		if($branch_code != "all"){
			$this->db->where('branch', $branch_code);
		}
		$this->db->where('status !=', 'D');
		$query = $this->db->get('hr_empmastr');

		if($query->num_rows() > 0){
			return $data = $query->result();
		}else{
			return false;
		}
	}

	public function submit_attendance_sheet($data){
		$this->db->insert('hr_emp_attendance', $data);
		return $this->db->insert_id();
	}

	public function mark_employee_go_out_by_attendance_sheet($data){
		$this->db->insert('hr_emp_go_in_out_attendance', $data);
		return $this->db->insert_id();
	}

	function mark_employee_go_in_by_attendance_sheet($id, $go_in_data){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_go_in_out_attendance', $go_in_data);
		$this->db->trans_complete();
	}

	public function attendance_sheet_upload_records($data){
		$this->db->insert('hr_emp_attendance_upload', $data);
		return $this->db->insert_id();
	}

	function get_employee_attendance_upload_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_emp_attendance_upload');
		return $query->result();
	}

	function get_emp_attendance_report($date, $emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('date', $date);
		$query = $this->db->get('hr_emp_attendance');
		return $query->row_array();
	}

	function get_emp_go_in_go_out_attendance_report($date, $emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('date', $date);
		$query = $this->db->get('hr_emp_go_in_out_attendance');
		return $query->result();
	}

	function get_emp_leave_status($date, $emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('start_date <=', $date);
		$this->db->where('end_date >=', $date);
		$this->db->where('approval', 'A');
		$query = $this->db->get('hr_emp_leave_records');
		return $query->row_array();
	}

	function get_emp_leave_status_all($date, $emp_id){
		$this->db->select('*');
		$this->db->where('emp_record_id', $emp_id);
		$this->db->where('start_date <=', $date);
		$this->db->where('end_date >=', $date);
		$this->db->where_not_in('approval', 'D');
		$query = $this->db->get('hr_emp_leave_records');
		return $query->row_array();
	}

	function check_attendance_for_date($date){
		$this->db->select('*');
		$this->db->where('date', $date);
		$query = $this->db->get('hr_emp_attendance');
		return $query->result();
	}

	function check_go_in_go_out_attendance_for_date($date){
		$this->db->select('*');
		$this->db->where('date', $date);
		$query = $this->db->get('hr_emp_go_in_out_attendance');
		return $query->result();
	}

	function get_duty_out_flagged_employee_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('status', 'asc');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_duty_out_flagged_users');
		return $query->result();
	}

	function get_attendance_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_emp_attendance');
		return $query->row_array();
	}

	function get_emp_duty_out_flagged_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_duty_out_flagged_users');
		return $query->row_array();
	}

	public function update_emp_unflag(){

		$attendance_id = $this->input->post('attendance_id', TRUE);
		$attendance_details = $this->get_attendance_details($attendance_id);
		$emp_record_id = $attendance_details['emp_record_id'];
		$duty_date = $attendance_details['date'];
		$hour = $this->input->post('hour', TRUE);
		if(strlen($hour) < 2){
			$hour = "0$hour";
		}
		$minutes = $this->input->post('minutes', TRUE);
		if(strlen($minutes) < 2){
			$minutes = "0$minutes";
		}
		$am_pm = $this->input->post('am_pm', TRUE);

		$duty_out_date_time_in_24_hour = strtotime("$duty_date $hour:$minutes $am_pm");
		$duty_out_date_time_in_24_hour  = date("Y-m-d H:i:s", $duty_out_date_time_in_24_hour);

		$data1['duty_out'] = $duty_out_date_time_in_24_hour;
		$this->db->trans_start();
		$this->db->where('id', $attendance_id);
		$this->db->update('hr_emp_attendance', $data1);
		$this->db->trans_complete();

		$data2['active_flag'] = 1;
		$this->db->trans_start();
		$this->db->where('USRID', $emp_record_id);
		$this->db->update('cm_userdata', $data2);
		$this->db->trans_complete();

		$ID = $this->input->post('id', TRUE);
		$data['status'] = "U";
		$data['updated_by'] = $this->session->userdata('username');
		$data['updated_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $ID);
		$this->db->update('hr_duty_out_flagged_users', $data);
		$this->db->trans_complete();

		$duty_out_date_time = strtotime($duty_out_date_time_in_24_hour);
		$time = date("H:i:s", $duty_out_date_time);
		$evening_short_leave_start = '15:01:00';
		$evening_short_leave_end = '16:59:00';
		$evening_half_day_leave_start = '13:01:00';
		$evening_half_day_leave_end = '15:00:00';
		$this->load->model("user/user_model");
		if($time >= $evening_short_leave_start && $time <= $evening_short_leave_end){
			$leave_type = "short_leave";
			$employee_details = $this->user_model->get_employee_details($emp_record_id);
			if($employee_details['maternity_leave'] == 'N'){
				$mark_leaves_by_attendance = $this->user_model->mark_leaves_by_attendance($leave_type, $duty_date, $emp_record_id);
			}
		}else if($time >= $evening_half_day_leave_start && $time <= $evening_half_day_leave_end){
			$leave_type = "half_day";
			$mark_leaves_by_attendance = $this->user_model->mark_leaves_by_attendance($leave_type, $duty_date, $emp_record_id);
		}
		$mark_leaves_by_go_out_go_in = $this->user_model->mark_leaves_by_go_out_go_in($duty_out_date_time_in_24_hour, $emp_record_id);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_user_data($emp_id){
		$this->db->select('*');
		$this->db->where('USRID', $emp_id);
		$query = $this->db->get('cm_userdata');
		if(count($query->result())>0){
			return $query->row_array();
		}else{
			return false;
		}

	}

	//added by nadee
	function check_fingerprint_user($emp_id){
		$this->db->select('attendance_type');
		$this->db->where('id', $emp_id);
		$query = $this->db->get('hr_empmastr');
		return $query->row_array();
	}

	function employee_flag_unflag($user_id, $flag_status){
		if($flag_status == 'flag'){
			$data['active_flag'] = 0;
		}else if($flag_status == 'unflag'){
			$employee_details = $this->get_employee_details($user_id);
			$data['USRPW'] = $this->encryption->encode($employee_details['nic_no']);
			$data['ATTEMPT'] = 0;
			$data['active_flag'] = 1;
		}

		$this->db->trans_start();
		$this->db->where('USRID', $user_id);
		$this->db->update('cm_userdata', $data);
		$this->db->trans_complete();
	}

	public function do_uploadfile($restlarge,$fieldname){
		$config['upload_path'] = './uploads/propics/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = '1000';
		//		$config['max_width'] = 100;
		//		$config['max_height'] = 100;
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = FALSE;
		$config['remove_spaces'] = TRUE;
		$config['file_name'] = $restlarge.'_'.time();
		if( ! is_dir($config['upload_path']) )
			die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		$this->load->library('upload', $config);
		if( ! $this->upload->do_upload($fieldname)){
			//echo $this->upload->display_errors();
			return array('upload_data_failed' => $this->upload->display_errors());
		}else{
			return array('upload_data' => $this->upload->data());
		}
	}

	// add by nadee

	public function submit_attendance_manual($data){
		$this->db->insert('hr_emp_attendance_manual', $data);
		return true;
	}
	function get_manual_attendance(){
		$this->db->select('*');
		//$this->db->where('statues', 'PENDING');
		$this->db->order_by('id','desc');
		$query = $this->db->get('hr_emp_attendance_manual');
		return $query->result();
	}

	function get_employee_details_attendance($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_empmastr');
		if ($query->num_rows() > 0){
			return $query->row();
		}
		else
			return 0;
	}

	public function manual_attendance_cancel($id)
	{
		$arrayName = array('statues' =>'CANCEL');
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('hr_emp_attendance_manual', $arrayName);
		$this->db->trans_complete();
		return true;
	}

	function manual_attendance_confirm($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_emp_attendance_manual');
		if ($query->num_rows() > 0){
			$result=$query->row();
			$get_emp_attendace_report=$this->get_emp_attendance_report($result->date, $result->emp_record_id);
			$check_leave=$this->get_emp_leave_status_all($result->date, $result->emp_record_id);
			$go_in_go_out=$this->get_emp_go_in_go_out_attendance_report($result->date, $result->emp_record_id);
			$data=array(
				'emp_record_id'=>$result->emp_record_id,
				'username'=>$result->username,
				'date'=>$result->date,
				'duty_in'=>$result->duty_in,
				'duty_out'=>$result->duty_out,
			);
			if(count($get_emp_attendace_report) > 0){
				$attendance_id=$get_emp_attendace_report['id'];
				$this->db->trans_start();
				$this->db->where('id',$attendance_id);
				$this->db->update('hr_emp_attendance', $data);
				$this->db->trans_complete();
			}else{
				$this->db->trans_start();
				$this->db->insert('hr_emp_attendance', $data);
				$this->db->trans_complete();
			}
			if(count($check_leave)>0){
				$check_leave_id=$check_leave['id'];
				$this->db->trans_start();
				$this->db->where('id',$check_leave_id);
				$this->db->delete('hr_emp_leave_records');
				$this->db->trans_complete();

			}
			if(count($go_in_go_out)>0){
				foreach ($go_in_go_out as $key => $value) {
					$go_in_data_id=$value->id;
					$this->db->trans_start();
					$this->db->where('id',$go_in_data_id);
					$this->db->delete('hr_emp_go_in_out_attendance');
					$this->db->trans_complete();
				}

			}
			$arrayName = array('statues' =>'CONFIRM' );
			$this->db->trans_start();
			$this->db->update('hr_emp_attendance_manual', $arrayName, "id = $id");
			$this->db->trans_complete();


			return true;

		}
		else
			return 0;
	}

	function get_holidays(){
		$this->db->select('*');
		$this->db->order_by('holiday_date');
		$query = $this->db->get('ln_config_holiday');
		return $query->result();
	}

	function holidays_add($data,$holiday)
	{
		$this->db->select('*');
		$this->db->where('holiday_date',$holiday);
		$query = $this->db->get('ln_config_holiday');
		if(!$query->result()){
			$insert = $this->db->insert('ln_config_holiday', $data);
			return $this->db->insert_id();
		}else{
			return false;
		}

	}
	function holiday_delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('ln_config_holiday');
		return true;
	}

	function check_holidays($holiday)
	{
		$this->db->select('*');
		$this->db->where('holiday_date',$holiday);
		$query = $this->db->get('ln_config_holiday');
		if ($query->num_rows() > 0){
			return true;
		}
	}
	function emp_pendingleaves_in_monthend($insertId,$branch)
	{
		//run when uploding fingerprint csv
		//add pending leaves for unmarked employees
		$employee_list=$this->get_employee_list();
		$this->db->select('*');
		$this->db->where('id',$insertId);
		$query = $this->db->get('hr_emp_attendance_upload');
		$result=$query->row();

		$count=count($employee_list);
		foreach ($employee_list as $key => $employee) {
			if($employee->status == "A" && $employee->branch==$branch && $employee->attendance_type!="N"){
				$todaydate = date('Y-m-d');
				//$year=date('Y', strtotime($date));
				//$month=date('m', strtotime($date));
				//$stdate=$year.'-'.$month.'-01';
				$stdate=$result->from_date;
				$date=$result->to_date;
				if($todaydate==$date)
				{
					$date=date('Y-m-d', strtotime($date . ' -1 day'));
				}

				while (strtotime($stdate) <= strtotime($date)) {

					$check_holiday_date="N";
					$check_holiday=$this->check_holidays($stdate);
					if($check_holiday){
						$check_holiday_date="Y";
					}
					$pending_records=$this->check_system_pending_records($employee->id,$stdate);
					if($employee->working_days_per_week=='5' && $pending_records=='true'){
						if(!(date('D', strtotime($stdate)) == 'Sun') && $check_holiday_date=="N"){
							$emp_leave_status = $this->get_emp_leave_status_all($stdate,$employee->id);
							$emp_attendance = $this->get_emp_attendance_report($stdate,$employee->id);
							if(count($emp_leave_status)<=0 && count($emp_attendance)<=0){

								$pending_leave=array('emp_record_id'=>$employee->id,
									'start_date'=>$stdate,
									'reason'=>$employee->id.' Empoloyee does not mark leave on '.$stdate);
								//$emp_pendingleaves_for_monthend=$this->employee_model->emp_pendingleaves_in_monthend($pending_leave);
								$this->db->insert('hr_emp_leave_records_pending', $pending_leave);
							}
						}
					}elseif($employee->working_days_per_week=='7' && $pending_records=='true'){
						//sales officers working_days_per_week is 7. They work on Saturday and sundays

						if($check_holiday_date=="N"){
							$emp_leave_status = $this->get_emp_leave_status_all($stdate,$employee->id);
							$emp_attendance = $this->get_emp_attendance_report($stdate,$employee->id);
							if(count($emp_leave_status)<=0 && count($emp_attendance)<=0){

								$pending_leave=array('emp_record_id'=>$employee->id,
									'start_date'=>$stdate,
									'reason'=>$employee->id.' Empoloyee does not mark leave on '.$stdate);
								//$emp_pendingleaves_for_monthend=$this->employee_model->emp_pendingleaves_in_monthend($pending_leave);
								$this->db->insert('hr_emp_leave_records_pending', $pending_leave);
							}
						}
					}

					$stdate = date('Y-m-d', strtotime($stdate . ' +1 day'));
				}
			}$count=$count-1;
		}if($count<=0){
			return true;
		}
	}
	function check_system_pending_records($emp_id,$start_date)
	{
		//called by emp_pendingleaves_in_monthend function
		$this->db->select('id');
		$this->db->where("emp_record_id",$emp_id);
		$this->db->where("start_date",$start_date);
		$query = $this->db->get('hr_emp_leave_records_pending');
		$result=$query->result();
		if($result){
			return false;
		}else{
			return true;
		}

	}

	function detele_system_pending_records($emp_id,$start_date)
	{
		//when apply leave delete pending system records.
		//call when add manual leave in controller
		$this->db->select('id');
		$this->db->where("emp_record_id",$emp_id);
		$this->db->where("start_date",$start_date);
		$query = $this->db->get('hr_emp_leave_records_pending');
		if ($query->num_rows()> 0){
			$result=$query->result();
			foreach ($result as $key => $value) {
				$this->db->trans_start();
				$this->db->where('id', $value->id);
				$this->db->delete('hr_emp_leave_records_pending');
				$this->db->trans_complete();
			}
			return true;
		}else{
			return true;
		}
	}
	//start >>add vouchers for payroll.
	//this function call when payroll running.
	function add_vauchers_payroll($id)
	{

		$allowance=0;
		$allowance_amount=0;
		$vehicle_rent=0;
		$basic_salary=0;
		$gross_salary=0;
		$no_pay_deduction_for_epf_etf=0;
		$no_pay_deduction=0;
		$allowance_total=0;
		$salary=0;
		// get payroll salary details
		$this->db->select('Sum(hr_emp_payroll.basic_salary) as basic_salary,
			Sum(hr_emp_payroll.gross_salary) as gross_salary,
			Sum(hr_emp_payroll.no_pay_deduction_for_epf_etf) as no_pay_deduction_for_epf_etf,
			Sum(hr_emp_payroll.no_pay_deduction) as no_pay_deduction,
			Sum(hr_emp_payroll.allowance_total) as allowance_total');
		$this->db->where('hr_emp_payroll.payroll_master_id',$id);
		$query = $this->db->get('hr_emp_payroll');
		$result=$query->row();

		// get allowance details
		$this->db->select('hr_emp_allowance_for_payroll.allowance_id,
			Sum(hr_emp_allowance_for_payroll.amount) as amount,
			hr_allowances.allowance');
		$this->db->join('hr_allowances','hr_allowances.id = hr_emp_allowance_for_payroll.allowance_id');
		$this->db->where('hr_emp_allowance_for_payroll.payroll_master_id',$id);
		$this->db->group_by('hr_emp_allowance_for_payroll.allowance_id');
		$query2 = $this->db->get('hr_emp_allowance_for_payroll');
		$result1=$query2->result();

		foreach ($result1 as $key => $value) {
			if($value->allowance=='Vehicle Rent'){// vaild only for winrose.
				$vehicle_rent=$value->amount;

			}else{
				$allowance=$allowance+$value->amount;

			}
		}
		$no_pay_deduction_for_epf_etf=$result->no_pay_deduction_for_epf_etf;
		$no_pay_deduction=$result->no_pay_deduction;
		$diff=$no_pay_deduction-$no_pay_deduction_for_epf_etf;
		$basic_salary=$result->basic_salary;
		$allowance_amount=$allowance-$diff;
		$salary=$basic_salary-$no_pay_deduction_for_epf_etf;
		$vr_ledger=$this->get_hr_ledgers('Vehicle Rent');
		$al_ledger=$this->get_hr_ledgers('Allowances');
		$sa_ledger=$this->get_hr_ledgers('Salaries');
		if($result){
			//ledger acc hardcoded for winrose
			if($vehicle_rent!=0){
				$voucherid=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata',date("Y-m-d h:i:s"));
				$this->add_vouchers($voucherid,$vr_ledger,'10','Vehicle Rent',number_format($vehicle_rent,2, '.', ''));

			}
			if($allowance_amount!=0){
				$voucherid=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata',date("Y-m-d h:i:s"));
				$this->add_vouchers($voucherid,$al_ledger,'10','Allowances',number_format($allowance_amount,2, '.', ''));
			}
			if($salary!=0){
				$voucherid=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata',date("Y-m-d h:i:s"));
				$this->add_vouchers($voucherid,$sa_ledger,'10','Salaries',number_format($salary,2, '.', ''));

			}
			return true;
		}



	}
	function add_vouchers($voucherid,$ledger,$vouchertype,$paymentdes,$amount)
	{ 
	
	$idlist=get_vaouchercode('voucherid','PV','ac_payvoucherdata',date("Y-m-d"));
					$voucherid=$idlist[0];
		//called by add_vauchers_payroll
		$data2=array(
			'voucherid'=>$voucherid,
			'vouchercode'=>$idlist[1],
			'branch_code' => $this->session->userdata('branchid'),
			'ledger_id' => $ledger,
			'payeecode' => '',
			'payeename' =>$paymentdes,
			'vouchertype' => $vouchertype,
			'paymentdes' => $paymentdes,
			'amount' => $amount,
			'applydate' =>date("Y-m-d h:i:s"),
			'status' => 'CONFIRMED',
			'confirmdate'=>date("Y-m-d"),

		);
		$this->db->insert('ac_payvoucherdata', $data2);
		$id = $this->db->insert_id();
		return $id;
	}
	//2018-11-13
	/*add phone bill payment*/
	function get_phone_bill_master_list($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id', 'desc');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_phonebill_master');
		return $query->result();
	}

	public function submit_phonebill_list(){

		$year = $this->input->post('year', TRUE);
		$data['year'] = $year;
		$month = $this->input->post('month', TRUE);
		$data['month'] = $month;
		$data['generated_by'] = $this->session->userdata('username');

		$this->db->trans_start();
		$this->db->insert('hr_phonebill_master', $data);
		$last_insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		$employee_list = $this->get_employee_list();
		foreach($employee_list as $employee){
			if($employee->status == 'A'){

				$phonebill_data['phonebill_master_id'] = $last_insert_id;
				$phonebill_data['emp_record_id'] = $employee->id;
				$bill_amount = 0;
				// $bill_amount =$employee->phone_bill;
				// if(!empty($bill_amount)){
				// 	$phonebill_data['bill_value'] = $bill_amount;
				// }else{
				// 	$phonebill_data['bill_value'] = 0;
				// }

				$bill_amount =$this->input->post('salary_phonebill_amount_'.$employee->id);
				if(!empty($bill_amount)){
					$phonebill_data['bill_value'] = $bill_amount;
				}else{
					$phonebill_data['bill_value'] = 0;
				}

				$phonebill_data['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_phonebill', $phonebill_data);
				$this->db->trans_complete();
			}
		}

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	function check_emp_phonebill_master_year_month($year, $month){
		$this->db->select('*');
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$this->db->where('status !=', 'N');
		$query = $this->db->get('hr_phonebill_master');
		return $query->row_array();
	}

	function get_emp_phonebill_for_payroll($id, $emp_id){
		$this->db->select('*');
		$this->db->where('phonebill_master_id', $id);
		$this->db->where('emp_record_id', $emp_id);
		$query = $this->db->get('hr_emp_phonebill');
		return $query->row_array();
	}//updated by nadee 2020_07_29 ticket id 1636

	public function confirm_phone_bill_payment($id){
		$data['status'] = "Y";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_phonebill_master', $data);
		$this->db->trans_complete();
	}

	function get_emp_phonebill_master_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_phonebill_master');
		return $query->row_array();
	}

	function get_emp_phonebill_list($id){
		$this->db->select('*');
		$this->db->where('phonebill_master_id', $id);
		$query = $this->db->get('hr_emp_phonebill');
		return $query->result();
	}

	function decline_monthly_phonebill($id){
		$payroll_master['status'] = "N";
		$payroll_master['confirmed_by'] = $this->session->userdata('username');
		$payroll_master['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_phonebill_master', $payroll_master);
		$this->db->trans_complete();

		$payroll_data['status'] = "N";

		$this->db->trans_start();
		$this->db->where('phonebill_master_id', $id);
		$this->db->update('hr_emp_phonebill', $payroll_data);
		$this->db->trans_complete();
	}
	/*add phone bill payment end*/
	/*emp loan deactivate start*/
	function emp_loan_delete($id)
	{
		$data['status'] = "N";
		$data['active_loan']="N";
		$data['declined_by'] = $this->session->userdata('username');
		$data['declined_at'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_loans', $data);
		return true;
	}
	/*emp loan deactivate end*/
	/*pay slip print*/
	//get payroll active //

	function emp_payroll_master_active(){
		$this->db->select('*');
		$this->db->where('status !=', 'N');
		$query = $this->db->get('hr_payroll_master');
		return $query->result();
	}

	/*pay slip print end*/

	//	function run_paye_script(){
	//		$i = 5006;
	//		for($x = 145857; $x <= 187481 ; $x+=24){
	//			$data['from_amount'] = $x;
	//			$data['to_amount'] = $x+24;
	//			$data['tax'] = $i;
	//			$data['updated_by'] = $this->session->userdata('username');
	//			$this->db->trans_start();
	//			$this->db->insert('hr_paye', $data);
	//			$last_insert_id = $this->db->insert_id();
	//			$this->db->trans_complete();
	//			$x++;
	//			$i+=3;
	//		}

	function get_employee_pendingleave_list()
	{
		$this->db->select('hr_emp_leave_records_pending.*');
		$this->db->order_by('epf_no');
		$this->db->join('hr_empmastr','hr_emp_leave_records_pending.emp_record_id=hr_empmastr.id');
		$query = $this->db->get('hr_emp_leave_records_pending');
		return $query->result();
	}

	function delete_pending_leave($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('hr_emp_leave_records_pending');
		return true;
	}

	function decline_monthly_fuel_payment($id){
		$payroll_master['status'] = "N";
		$payroll_master['confirmed_by'] = $this->session->userdata('username');
		$payroll_master['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_fuel_allowance_payment_master', $payroll_master);
		$this->db->trans_complete();

		$payroll_data['status'] = "N";

		$this->db->trans_start();
		$this->db->where('allowancee_payment_master_id', $id);
		$this->db->update('hr_emp_fuel_allowance_payment', $payroll_data);
		$this->db->trans_complete();
	}

	function checktable($table,$emp_feild,$emp_id)
	{
		$this->db->where($emp_feild,$emp_id);
		$query=$this->db->get($table);
		if(count($query->result())>0){
			return true;
		}else{
			return false;
		}
	}
	/*2020_03_10 updated by nadee*/
	function decline_monthly_nopay_list($id)
	{
		$payroll_master['status'] = "N";
		$payroll_master['confirmed_by'] = $this->session->userdata('username');
		$payroll_master['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_no_pay_leave_master', $payroll_master);
		$this->db->trans_complete();

		$payroll_data['status'] = "N";

		$this->db->trans_start();
		$this->db->where('no_pay_leave_master_id', $id);
		$this->db->update('hr_emp_no_pay_leave_counts', $payroll_data);
		$this->db->trans_complete();
	}

	function decline_monthly_salary_advance($id)
	{
		$payroll_master['status'] = "N";
		$payroll_master['confirmed_by'] = $this->session->userdata('username');
		$payroll_master['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_emp_salary_advance_master', $payroll_master);
		$this->db->trans_complete();

		$payroll_data['status'] = "N";

		$this->db->trans_start();
		$this->db->where('salary_advance_master_id', $id);
		$this->db->update('hr_emp_salary_advance', $payroll_data);
		$this->db->trans_complete();
	}
	/*2020_03_10 updated by nadee end*/

	/*2020_07_30 updated by nadee to add employee appraisal module*/
	function get_performance_category()
	{
		$this->db->select('*');
		$this->db->where('statues','A');
		$result=$this->db->get('hr_performance_category');
		if($result->num_rows()>0)
		{
			return $result->result();

		}else{
			return false;
		}
	}

	function add_employee_appraisal()
	{
		$data = array(
			'emp_no' =>$this->input->post('emp_id', TRUE),
			'review_date' =>$this->input->post('review_date', TRUE),
			'next_review_date' =>$this->input->post('nextreview_date', TRUE),
			'future_goals' =>$this->input->post('future_gols', TRUE),
			'supervise_comment' =>$this->input->post('appraiser_comment', TRUE),
			'salary' =>$this->input->post('basic_salary', TRUE),
			'position' =>$this->input->post('designation_id', TRUE),
			'added_by' =>$this->session->userdata('username'),
			'added_at' =>date('Y-m-d'));

		$insert=$this->db->insert('hr_emp_appraisal',$data);
		$insert_id=$this->db->insert_id();
		if($insert)
		{
			$category=$this->get_performance_category();
			if($category)
			{
				foreach ($category as $key => $value) {
					$data2 = array('appraisal_id'=>$insert_id,
						'category_id'=>$value->id,
						'score'=>$this->input->post('scorefor'.$value->id),
						'remarks' =>$this->input->post('remark'.$value->id),);
					$insert=$this->db->insert('hr_emp_appraisal_data',$data2);
				}
			}
			return true;
		}else{
			return false;
		}
	}

	function get_employee_appraisal_data()
	{
		$this->db->select('hr_emp_appraisal.*,hr_empmastr.surname,hr_empmastr.initial,hr_empmastr.epf_no,hr_empmastr.nic_no,hr_dsgntion.designation');
		$this->db->join('hr_empmastr','hr_empmastr.id=hr_emp_appraisal.emp_no');
		$this->db->join('hr_dsgntion','hr_emp_appraisal.position=hr_dsgntion.id');
		$this->db->where('hr_emp_appraisal.statues !=','canceled');
		$query=$this->db->get('hr_emp_appraisal');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function get_employee_appraisal_data_byemp($id)
	{
		$this->db->select('hr_emp_appraisal.*,hr_empmastr.surname,hr_empmastr.initial,hr_empmastr.epf_no,hr_empmastr.nic_no,hr_dsgntion.designation');
		$this->db->join('hr_empmastr','hr_empmastr.id=hr_emp_appraisal.emp_no');
		$this->db->join('hr_dsgntion','hr_emp_appraisal.position=hr_dsgntion.id');
		$this->db->where('hr_emp_appraisal.id',$id);
		$query=$this->db->get('hr_emp_appraisal');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	function get_employee_appraisal_categorydata($id)
	{
		$this->db->select('hr_emp_appraisal_data.*,hr_performance_category.performance_category,hr_performance_category.performance_number');
		$this->db->join('hr_performance_category','hr_performance_category.id=hr_emp_appraisal_data.category_id');
		$this->db->where('appraisal_id',$id);

		$query=$this->db->get('hr_emp_appraisal_data');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	function add_employee_appraisal_comment()
	{
		$data2 = array('employee_comment'=>$this->input->post('comment'));
		$this->db->where('id',$this->input->post('app_id'));
		$update=$this->db->update('hr_emp_appraisal',$data2);
		if($update)
		{
			return true;
		}else{
			return false;
		}
	}

	function appraisal_statueschange($id,$stues)
	{
		$data2 = array('statues'=>$stues);
		$this->db->where('id',$id);
		$update=$this->db->update('hr_emp_appraisal',$data2);
		if($update)
		{
			return true;
		}else{
			return false;
		}
	}
	/*2020-07_30 appraisal module end*/

		//created by terance 2020-7-28 ticket no 1575
	function get_equipment_name($id){
		$this->db->select('equipment_category');
		$this->db->where('id',$id);
		$query = $this->db->get('hr_equipment_categories');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}else{
			return false;
		}
	}

		//created by Bilani 2020-7-31 ticket no 1575
	function get_all_employee_list(){
		$this->db->select('*');
		$this->db->where('id !=', 1);
		$this->db->where('id !=', 2);
		$this->db->order_by('epf_no');
		$query = $this->db->get('hr_empmastr');
		return $query->result();
	}

		//created by nadee 2020-12-22
	function get_hr_ledgers($name)
	{
		$this->db->select('*');
		$this->db->where('Description', $name);
		$query = $this->db->get('hr_lederset');
		if($query->num_rows()>0){
			return $query->row()->Dr_account;
		}else{
			return false;
		}
	}
    //Created by Eranga on 24.03.2021
	function get_branchcode_by_empid($id){
		$this->db->select('cm_branchms.shortcode');
		$this->db->join('hr_empmastr','hr_empmastr.branch = cm_branchms.branch_code');
		$this->db->where('hr_empmastr.id', $id);
		$query = $this->db->get('cm_branchms');
		if($query->num_rows()>0){
			return $query->row()->shortcode;
		}else{
			return false;
		}
	}

	function update_employees(){
		$this->db->select('*');
		$query = $this->db->get('hr_empmastr');
		if($query->num_rows()>0){
			foreach($query->result() as $raw){
				$code = '';
				$code = 'HL/';
				$code .= $this->get_branchcode_by_empid($raw->id).'/';
				$code .= str_pad($raw->id, 3, '0', STR_PAD_LEFT);

				$data = array(
					'emp_no' => $code,
				);
				$this->db->where('id',$raw->id);
				$this->db->update('hr_empmastr',$data);
			}
			return true;
		}else{
			return false;
		}
	}

		//End update 24.03.2021

//updated by nadee
		function get_all_employee_details_search()
		{
			$search_val=$this->input->post('search_val');
			$branch_id=$this->input->post('branch_id');
			$division_id=$this->input->post('division_id');
			$designation_id=$this->input->post('designation_id');
			$this->db->select('*');
			$this->db->where('id !=', 1);
			$this->db->where('id !=', 2);
			if($search_val){
				$this->db->like('emp_no ',$search_val);
				$this->db->or_like('epf_no ',$search_val);
				$this->db->or_like('nic_no ',$search_val);
				$this->db->or_like('surname ',$search_val);
				$this->db->or_like('initial ',$search_val);
				$this->db->or_like('initials_full ',$search_val);
			}
			if($branch_id)
			{
				$this->db->where('branch', $branch_id);
			}
			if($division_id)
			{
				$this->db->where('division', $division_id);
			}
			if($designation_id)
			{
				$this->db->where('designation',$designation_id);
			}
			$this->db->order_by('epf_no');
			$query = $this->db->get('hr_empmastr');
			return $query->result();
		}

		//updated by nadee 2021-06-15
		function get_employee_payroll_insentive_list($payroll_master_id, $emp_record_id, $allowance_id){
			$this->db->select('hr_emp_payroll_insentive.*');
			$this->db->join('hr_insentive_master','hr_insentive_master.id = hr_emp_payroll_insentive.insentive_master_id');
			$this->db->join('hr_payroll_master','hr_payroll_master.year = hr_insentive_master.year AND hr_payroll_master.month = hr_insentive_master.month');
			$this->db->where('hr_payroll_master.id', $payroll_master_id);
			$this->db->where('hr_emp_payroll_insentive.emp_record_id', $emp_record_id);
			$this->db->where('hr_insentive_master.insentive_type', $allowance_id);
			$this->db->where('hr_insentive_master.status', 'Y');
			$query = $this->db->get('hr_emp_payroll_insentive');
			return $query->row_array();
		}

		function get_employee_payroll_otherdeduction_list($payroll_master_id, $emp_record_id, $allowance_id){
			$this->db->select('hr_emp_payroll_otherdeduction.*');
			$this->db->join('hr_otherdeduction_master','hr_otherdeduction_master.id = hr_emp_payroll_otherdeduction.deduction_master_id');
			$this->db->join('hr_payroll_master','hr_otherdeduction_master.year = hr_payroll_master.year AND hr_payroll_master.month = hr_otherdeduction_master.month');
			$this->db->where('hr_payroll_master.id', $payroll_master_id);
			$this->db->where('hr_emp_payroll_otherdeduction.emp_record_id', $emp_record_id);
			$this->db->where('hr_otherdeduction_master.deduction_type', $allowance_id);
			$this->db->where('hr_otherdeduction_master.status', 'Y');
			$query = $this->db->get('hr_emp_payroll_otherdeduction');
			return $query->row_array();
		}

		// edit by dileep
public function get_higher_education_details(){
 $this->db->select('*');

 $query = $this->db->get('hr_education_qualification');
 return $data = $query->result();
}

public function get_qualification_field_details(){
 $this->db->select('*');

 $query = $this->db->get('hr_qualification_field');
 return $data = $query->result();
}
//end edit by dileep
}
?>
