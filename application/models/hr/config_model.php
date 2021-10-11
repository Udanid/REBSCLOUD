<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model{

	function get_all_employment_types($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_employment_types');
		return $query->result();
    }

	public function add_employment_type(){
		$data['employment_type'] = $this->input->post('employment_type', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_employment_types', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_employment_type_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_employment_types');
		return $query->row_array();
    }

	public function update_employment_type(){
		$ID = $this->input->post('id', TRUE);
		$data['employment_type'] = $this->input->post('employment_type', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_employment_types', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_employment_type($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_employment_types');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_designations($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_dsgntion');
		return $query->result();
    }

	public function add_designation(){
		$data['designation'] = $this->input->post('designation', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_dsgntion', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_designation_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_dsgntion');
		return $query->row_array();
    }

	public function update_designation(){
		$ID = $this->input->post('id', TRUE);
		$data['designation'] = $this->input->post('designation', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_dsgntion', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_designation($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_dsgntion');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_divisions($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_division');
		return $query->result();
    }

	public function add_division(){
		$data['division_name'] = $this->input->post('division_name', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_division', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_division_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_division');
		return $query->row_array();
    }

	public function update_division(){
		$ID = $this->input->post('id', TRUE);
		$data['division_name'] = $this->input->post('division_name', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_division', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_division($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_division');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_allowances($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_allowances');
		return $query->result();
    }

	public function add_allowance(){
		$data['allowance'] = $this->input->post('allowance', TRUE);
		$data['amount_type'] = $this->input->post('amount_type', TRUE);
		$data['tax_applicable'] = $this->input->post('tax_applicable', TRUE);
		$tax_free_amount = $this->input->post('tax_free_amount', TRUE);
		if(empty($tax_free_amount)){
			$tax_free_amount = 0;
		}else{
			$tax_free_amount = $this->input->post('tax_free_amount', TRUE);
		}
		$data['tax_free_amount'] = $tax_free_amount;
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_allowances', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_allowance_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_allowances');
		return $query->row_array();
    }

	public function update_allowance(){
		$ID = $this->input->post('id', TRUE);
		$data['allowance'] = $this->input->post('allowance', TRUE);
		$data['amount_type'] = $this->input->post('amount_type', TRUE);
		$data['tax_applicable'] = $this->input->post('tax_applicable', TRUE);
		$tax_free_amount = $this->input->post('tax_free_amount', TRUE);
		if(empty($tax_free_amount)){
			$tax_free_amount = 0;
		}else{
			$tax_free_amount = $this->input->post('tax_free_amount', TRUE);
		}
		$data['tax_free_amount'] = $tax_free_amount;
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_allowances', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_allowance($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_allowances');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_loans($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_loans');
		return $query->result();
    }

	public function add_loan(){
		$data['loan'] = $this->input->post('loan', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_loans', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_loan_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_loans');
		return $query->row_array();
    }

	public function update_loan(){
		$ID = $this->input->post('id', TRUE);
		$data['loan'] = $this->input->post('loan', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_loans', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_loan($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_loans');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_deductions($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_deductions');
		return $query->result();
    }

	public function add_deduction(){
		$data['deduction'] = $this->input->post('deduction', TRUE);
		$data['amount_type'] = $this->input->post('amount_type', TRUE);
		$data['value'] = $this->input->post('value', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_deductions', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_deduction_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_deductions');
		return $query->row_array();
    }

	public function update_deduction(){
		$ID = $this->input->post('id', TRUE);
		$data['deduction'] = $this->input->post('deduction', TRUE);
		$data['amount_type'] = $this->input->post('amount_type', TRUE);
		$data['value'] = $this->input->post('value', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_deductions', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_deduction($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_deductions');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_epf_etf(){
		$this->db->select('*');
		$this->db->order_by('id');
		$query = $this->db->get('hr_epf_etf');
		return $query->result();
    }

	function get_epf_etf_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_epf_etf');
		return $query->row_array();
    }

	public function update_epf_etf(){
		$ID = $this->input->post('id', TRUE);
		$data['employee_contribution'] = $this->input->post('employee_contribution', TRUE);
		$data['employer_contribution'] = $this->input->post('employer_contribution', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_epf_etf', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_equipment_categories($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_equipment_categories');
		return $query->result();
    }

	public function add_equipment_category(){
		$data['equipment_category'] = $this->input->post('equipment_category', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_equipment_categories', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_equipment_category_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_equipment_categories');
		return $query->row_array();
    }

	public function update_equipment_category(){
		$ID = $this->input->post('id', TRUE);
		$data['equipment_category'] = $this->input->post('equipment_category', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_equipment_categories', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_equipment_category($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_equipment_categories');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_paye($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_paye');
		return $query->result();
    }

	public function add_paye(){
		$data['from_amount'] = $this->input->post('from_amount', TRUE);
		$data['to_amount'] = $this->input->post('to_amount', TRUE);
		$data['tax'] = $this->input->post('tax', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_paye', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_paye_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_paye');
		return $query->row_array();
    }

	public function update_paye(){
		$ID = $this->input->post('id', TRUE);
		$data['from_amount'] = $this->input->post('from_amount', TRUE);
		$data['to_amount'] = $this->input->post('to_amount', TRUE);
		$data['tax'] = $this->input->post('tax', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->where('id', $ID);
		$this->db->update('hr_paye', $data);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_paye($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_paye');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_leave_categories($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_leave_categories');
		return $query->result();
    }

	public function add_leave_category(){
		$data['leave_category_name'] = $this->input->post('leave_category_name', TRUE);
		$data['annual_leave'] = $this->input->post('annual_leave', TRUE);
		$data['cassual_leave'] = $this->input->post('cassual_leave', TRUE);
		$data['sick_leave'] = $this->input->post('sick_leave', TRUE);
		$data['maternity_leave'] = $this->input->post('maternity_leave', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_leave_categories', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_leave_category_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_leave_categories');
		return $query->row_array();
    }

	public function update_leave_category(){
		$ID = $this->input->post('id', TRUE);
		$data['leave_category_name'] = $this->input->post('leave_category_name', TRUE);
		$data['annual_leave'] = $this->input->post('annual_leave', TRUE);
		$data['cassual_leave'] = $this->input->post('cassual_leave', TRUE);
		$data['sick_leave'] = $this->input->post('sick_leave', TRUE);
		$data['maternity_leave'] = $this->input->post('maternity_leave', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->where('id', $ID);
		$this->db->update('hr_leave_categories', $data);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_leave_category($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_leave_categories');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_all_fuel_allowance_rates($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_fuel_allowance_rates');
		return $query->result();
    }

	public function add_fuel_allowance_rate(){
		$data['vehicle_type'] = $this->input->post('vehicle_type', TRUE);
		$data['rate_per_km'] = $this->input->post('rate_per_km', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_fuel_allowance_rates', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_fuel_allowance_rate_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_fuel_allowance_rates');
		return $query->row_array();
    }

	public function update_fuel_allowance_rate(){
		$ID = $this->input->post('id', TRUE);
		$data['vehicle_type'] = $this->input->post('vehicle_type', TRUE);
		$data['rate_per_km'] = $this->input->post('rate_per_km', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->where('id', $ID);
		$this->db->update('hr_fuel_allowance_rates', $data);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_fuel_allowance_rate($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_fuel_allowance_rates_updates');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	//added by nadee
	function get_fuel_allowance_rate_updates(){
		$this->db->select('hr_fuel_allowance_rates_updates.id,
		hr_fuel_allowance_rates_updates.vehicle_type,
		hr_fuel_allowance_rates_updates.rate_per_km,
		hr_fuel_allowance_rates_updates.start_date,
		hr_fuel_allowance_rates_updates.to_date,
		hr_fuel_allowance_rates_updates.updated_by,
		hr_fuel_allowance_rates_updates.last_updated,
		hr_fuel_allowance_rates.vehicle_type as vehicle_name');
		$this->db->join('hr_fuel_allowance_rates','hr_fuel_allowance_rates.id=hr_fuel_allowance_rates_updates.vehicle_type');
		$query = $this->db->get('hr_fuel_allowance_rates_updates');
		return $query->result();
	}

	function add_fuel_allowance_rate_period(){
		$vehicle=$this->input->post('vehicle', TRUE);
		$rate_per_km=$this->input->post('rate_per_km', TRUE);
		$start_date=$this->input->post('rate_start_date', TRUE);
		$end_date=$this->input->post('rate_end_date', TRUE);
		$today=date("Y-m-d");

		//start checking same period
		$this->db->select("*");
		$this->db->where('vehicle_type', $vehicle);
		$this->db->where('start_date <=',$start_date);
		$this->db->where('to_date >=',$start_date);
		$query = $this->db->get('hr_fuel_allowance_rates_updates');
		$result= $query->result();
		if($result){
			foreach ($result as $key => $value) {
				if($value->start_date<=$today){
					$data['to_date'] = $today;
					$this->db->update('hr_fuel_allowance_rates_updates', $data, "id = $value->id");
				}else{
					$this->delete_fuel_allowance_rate($value->id);
				}
			}
		}
		$this->db->select("*");
		$this->db->where('vehicle_type', $vehicle);
		$this->db->where('start_date <=',$end_date);
		$this->db->where('to_date >=',$end_date);
		$query = $this->db->get('hr_fuel_allowance_rates_updates');
		$result= $query->result();
		if($result){
			foreach ($result as $key => $value) {
				if($value->start_date<=$today){
					$data['to_date'] = $today;
					$this->db->update('hr_fuel_allowance_rates_updates', $data, "id = $value->id");
				}else{
					$this->delete_fuel_allowance_rate($value->id);
				}
			}
		}
		$this->db->select("*");
		$this->db->where('vehicle_type', $vehicle);
		$this->db->where('start_date <=',$start_date);
		$this->db->where('to_date >=',$end_date);
		$query = $this->db->get('hr_fuel_allowance_rates_updates');
		$result= $query->result();
		if($result){
			foreach ($result as $key => $value) {
				if($value->start_date<=$today){
					$data['to_date'] = $today;
					$this->db->update('hr_fuel_allowance_rates_updates', $data, "id = $value->id");
				}else{
					$this->delete_fuel_allowance_rate($value->id);
				}
			}
		}
		$this->db->select("*");
		$this->db->where('vehicle_type', $vehicle);
		$this->db->where('start_date >=',$start_date);
		$this->db->where('to_date <=',$end_date);
		$query = $this->db->get('hr_fuel_allowance_rates_updates');
		$result= $query->result();
		if($result){
			foreach ($result as $key => $value) {
				if($value->start_date<=$today){
					$data['to_date'] = $today;
					$this->db->update('hr_fuel_allowance_rates_updates', $data, "id = $value->id");
				}else{
					$this->delete_fuel_allowance_rate($value->id);
				}
			}
		}
		//end checking same period

		$data2=array('vehicle_type'=>$vehicle,
		'rate_per_km'=>$rate_per_km,
		'start_date'=>$start_date,
		'to_date'=>$end_date,
		'updated_by'=>date('Y-m-d'));
		$this->db->insert('hr_fuel_allowance_rates_updates',$data2);
		return $this->db->insert_id();
	}

	//hr year end process
	public function hr_year_end()
	{
		$year=date('Y');

		$this->db->select('
emp_record_id,
leave_type,
start_date,
end_date,
no_of_days,
reason,
no_pay_status,
no_pay_days,
officer_in_charge,
office_approval_by,
approval,
approval_by,
active_record,
lastupdate,
created,
sytem_record
');
		$query =$this->db->get('hr_emp_leave_records');
		$result= $query->result();
		if($result){
			foreach ($result as $key => $value) {
		$data=array('year'=>$year,
'emp_record_id'=>$value->emp_record_id,
'leave_type'=>$value->leave_type,
'start_date'=>$value->start_date,
'end_date'=>$value->end_date,
'no_of_days'=>$value->no_of_days,
'reason'=>$value->reason,
'no_pay_status'=>$value->no_pay_status,
'no_pay_days'=>$value->no_pay_days,
'officer_in_charge'=>$value->officer_in_charge,
'office_approval_by'=>$value->office_approval_by,
'approval'=>$value->approval,
'approval_by'=>$value->approval_by,
'active_record'=>$value->active_record,
'lastupdate'=>$value->lastupdate,
'created'=>$value->created,
'sytem_record'=>$value->sytem_record,
'added_at'=>date('Y-m-d'),
'added_by'=>$this->session->userdata('username'),);

				$this->db->trans_start();
				$this->db->insert('hr_emp_leave_pastyears',$data);
				$this->db->where('emp_record_id', $value->emp_record_id);
				$this->db->delete('hr_emp_leave_records');
				$this->db->trans_complete();
			}

		}

		$this->db->trans_start();
		$this->db->truncate('hr_emp_leave_records_pending');
		$this->db->trans_complete();

		return $year;
	}


		function get_performance_category($id)
		{
			$this->db->select('*');
			if($id!=""){
				$this->db->where('id',$id);
			}
			$result=$this->db->get('hr_performance_category');
			if($result->num_rows()>0)
			{
				if($id!=""){
					return $result->row_array();
				}else{
					return $result->result();
				}


			}else{
				return false;
			}
		}

		function add_performance_category()
		{
			$data = array('performance_number'=>$this->input->post('cat_id', TRUE),
			'performance_category' => $this->input->post('cat_name', TRUE), );

			$insert=$this->db->insert('hr_performance_category',$data);
			if($insert)
			{
				return true;
			}else{
				return false;
			}
		}

		function update_performance_category()
		{
			$id=$this->input->post('id', TRUE);
			$data = array('performance_number'=>$this->input->post('cat_id', TRUE),
			'performance_category' => $this->input->post('cat_name', TRUE), );

			$this->db->where('id',$id);
			$insert=$this->db->update('hr_performance_category',$data);
			if($insert)
			{
				return true;
			}else{
				return false;
			}
		}
		/*updated end nadee 2020-07-30*/

		//update by nadee 2020-12-23
		function get_hr_ledgers(){
			$this->db->select('*');
		$result=$this->db->get('hr_lederset');
			if($result->num_rows()>0)
			{
				return $result->result();

			}else{
				return false;
			}

		}
		function update_hr_ledgers(){

			$ledger_set=$this->get_hr_ledgers();

			foreach ($ledger_set as $key => $value) {
				$data = array('Dr_account' => $this->input->post('acd_'.$value->id),
			'Cr_account' => $this->input->post('acc_'.$value->id),
		'last_update'=>date('Y-m-d') );
				$this->db->where('id',$this->input->post('id_'.$value->id));
				$this->db->update('hr_lederset',$data);
			}
			return true;
		}

//2021-06_21 ticket 2908
		public function add_otherdeduct_field(){
		$data['deduction'] = $this->input->post('deduction', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$data['last_updated']=date('Y-m-d H:i:s');
		$this->db->trans_start();
			$this->db->insert('hr_otherdeduction', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

		function get_otherdeduct_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_otherdeduction');
		return $query->row_array();
		}


		public function update_otherdeduct_details(){
		$ID = $this->input->post('id', TRUE);
		$data['deduction'] = $this->input->post('deduction', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_otherdeduction', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	/*qualification Field start by dileep*/
		function get_all_qualification_fields($pagination_counter, $page_count){
		$this->db->select('*');
		$this->db->order_by('id');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('hr_qualification_field');
		return $query->result();
    }

	public function add_qualification_field(){
		$data['qualification_field_name'] = $this->input->post('qualification_field_name', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
    	$this->db->insert('hr_qualification_field', $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	function get_qualification_field_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_qualification_field');
		return $query->row_array();
    }

	public function update_qualification_field(){
		$ID = $this->input->post('id', TRUE);
		$data['qualification_field_name'] = $this->input->post('qualification_field_name', TRUE);
		$data['updated_by'] = $this->session->userdata('username');
		$this->db->trans_start();
		$this->db->update('hr_qualification_field', $data, "id = $ID");
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function delete_qualification_field($id){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('hr_qualification_field');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

/*Qualification end by dileep*/


}
?>
