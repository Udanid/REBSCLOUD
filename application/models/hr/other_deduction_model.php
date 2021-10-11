<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class other_deduction_model extends CI_Model{

	function get_employee_list_new($id = "all",$branch = "all",$division = 'all')
	{
			$this->db->select('*');
			$this->db->where('status !=', 'D');
			if($id != 'all')
				$this->db->where('id',$id);
			if($branch != 'all')
				$this->db->where('branch',$branch);
			if($division != 'all')
				$this->db->where('division',$division);
			$this->db->order_by('epf_no');
			$query = $this->db->get('hr_empmastr');
			if($query->num_rows()>0)
				return $query->result();
			else
				return false;
		}






function get_other_deduction()

{

        $query=$this->db->get("hr_otherdeduction");
        return $query->result();
}





function otherdeduct_submit()
	{


		$deduction=$this->input->post("deduction");
		$data['deduction_type']=$deduction;
		$year = $this->input->post('year', TRUE);
		$data['year'] = $year;
		$month = $this->input->post('month', TRUE);
		$data['month'] = $month;
		$data['status']="P";
		$data['generated_by'] = $this->session->userdata('username');

		$this->db->trans_start();
		$this->db->insert('hr_otherdeduction_master', $data);
		$last_insert_id = $this->db->insert_id();
		$this->db->trans_complete();


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $last_insert_id;
		}
	}
	function otherdeduct_submit_details($last_insert_id)
	{
		$employee_list = $this->other_deduction_model->get_employee_list_new();


		foreach($employee_list as $employee){
			if($employee->status == 'A' && $employee->salary_confirmation=='Y'){

				$deductdata['deduction_master_id'] = $last_insert_id;
				$deductdata['emp_record_id'] = $employee->id;
				$deductdata['status']="P";
				$deductdata['amount']=$this->input->post("amount_".$employee->id);
				$deductdata['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_payroll_otherdeduction',$deductdata);
				$this->db->trans_complete();
			}
		}
	}
	function otherdeduct_submit_uploads($last_insert_id,$employeeid,$amount)
	{

				$deductdata['deduction_master_id'] = $last_insert_id;
				$deductdata['emp_record_id'] = $employeeid;
				$deductdata['status']="P";
				$deductdata['amount']=$amount;
				$deductdata['created'] = date('Y-m-d H:i:s');

				$this->db->trans_start();
				$this->db->insert('hr_emp_payroll_otherdeduction',$deductdata);
				$this->db->trans_complete();
		
	}


	function get_otherdeduction_master_list($pagination_counter, $page_count){
		$this->db->select('hr_otherdeduction_master.*,hr_otherdeduction.deduction');
		$this->db->join('hr_otherdeduction','hr_otherdeduction_master.deduction_type = hr_otherdeduction.id','left');
		$this->db->order_by('id', 'desc');

		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_otherdeduction_master');
		return $query->result();
	}

	function get_otherdeduction_list($id){
		$this->db->select('*');
		$this->db->where('deduction_master_id', $id);
		$query = $this->db->get('hr_emp_payroll_otherdeduction');
		return $query->result();
	}

	function get_otherdeduction_master_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_otherdeduction_master');
		return $query->row_array();
	}

		public function check_otherdeduction_payment($id){
		$data['status'] = "C";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_otherdeduction_master',$data);
		$this->db->trans_complete();
	}


	public function confirm_otherdeduction_payment($id){
		$data['status'] = "Y";
		$data['confirmed_by'] = $this->session->userdata('username');
		$data['confirmed_date'] = date('Y-m-d H:i:s');
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_otherdeduction_master',$data);
		$this->db->trans_complete();
	}

		function check_other_deduction_master_year_month($year, $month,$deduction){
		$this->db->select('*');
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$this->db->where('deduction_type',$deduction);
		$this->db->where('status !=', 'N');
		$query = $this->db->get('hr_otherdeduction_master');
		return $query->row_array();
	}



	function decline_other_deduction($id){
		$otherdeduction_master['status'] = "N";
		$otherdeduction_master['confirmed_by'] = $this->session->userdata('username');
		$otherdeduction_master['confirmed_date'] = date('Y-m-d H:i:s');

		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update('hr_otherdeduction_master',$otherdeduction_master);
		$this->db->trans_complete();

		$otherdeduction_data['status'] = "N";

		$this->db->trans_start();
		$this->db->where('deduction_master_id', $id);
		$this->db->update('hr_emp_payroll_otherdeduction', $otherdeduction_data);
		$this->db->trans_complete();
	}









}


?>
