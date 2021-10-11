<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_hr_model extends CI_Model{

	public function get_employment_type_list(){
		$this->db->select('*');
        $this->db->order_by('employment_type', 'DESC');
        $query = $this->db->get('hr_employment_types');
        return $data = $query->result();
	}

	public function get_branch_list(){
		$this->db->select('*');
        $this->db->order_by('branch_name', 'asc');
        $query = $this->db->get('cm_branchms');
        return $data = $query->result();
	}

	public function get_division_list(){
		$this->db->select('*');
        $this->db->order_by('division_name', 'asc');
        $query = $this->db->get('hr_division');
        return $data = $query->result();
	}

	public function get_designation_list(){
		$this->db->select('*');
        $this->db->order_by('designation', 'asc');
        $query = $this->db->get('hr_dsgntion');
        return $data = $query->result();
	}

	public function get_allowance_list(){
		$this->db->select('*');
        $this->db->order_by('allowance', 'asc');
        $query = $this->db->get('hr_allowances');
        return $data = $query->result();
	}

	public function get_epf_etf_list(){
		$this->db->select('*');
        $this->db->order_by('type', 'asc');
        $query = $this->db->get('hr_epf_etf');
        return $data = $query->result();
	}

	public function get_deduction_list(){
		$this->db->select('*');
        $this->db->order_by('deduction', 'asc');
        $query = $this->db->get('hr_deductions');
        return $data = $query->result();
	}

	public function get_loan_list(){
		$this->db->select('*');
        $this->db->order_by('loan', 'asc');
        $query = $this->db->get('hr_loans');
        return $data = $query->result();
	}

	public function get_designation($id){
		$this->db->select('*');
		$this->db->where('id', $id);
        $query = $this->db->get('hr_dsgntion');
        return $data = $query->row_array();
	}

	public function get_bank_list(){
		$this->db->select('*');
        $this->db->order_by('BANKNAME', 'asc');
        $query = $this->db->get('cm_banklist');
        return $data = $query->result();
	}

	public function get_bank_branch_list($bankcode){
		$this->db->select('*');
		$this->db->order_by('BRANCHNAME', 'asc');
        $this->db->where('BANKCODE', $bankcode);
        $query = $this->db->get('cm_bnkbrnch');

        if($query->num_rows() > 0){
            return $data = $query->result();
        }else{
            return false;
        }
    }

	function get_branch_details($id){
		$this->db->select('*');
		$this->db->where('branch_code', $id);
		$query = $this->db->get('cm_branchms');
		return $query->row_array();
    }

	function get_division_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_division');
		return $query->row_array();
    }

	function get_designation_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_dsgntion');
		return $query->row_array();
    }

	function get_employment_type_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_employment_types');
		return $query->row_array();
    }

	public function get_equipment_category_list(){
		$this->db->select('*');
        $this->db->order_by('equipment_category', 'asc');
        $query = $this->db->get('hr_equipment_categories');
        return $data = $query->result();
	}

	public function get_leave_category_list(){
		$this->db->select('*');
        $this->db->order_by('leave_category_name', 'asc');
        $query = $this->db->get('hr_leave_categories');
        return $data = $query->result();
	}

	function get_leave_category_details($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('hr_leave_categories');
		return $query->row_array();
    }

	public function get_fuel_allowance_vehicle_type_list(){
		$this->db->select('*');
        $this->db->order_by('vehicle_type');
        $query = $this->db->get('hr_fuel_allowance_rates');
        return $data = $query->result();
	}

	public function get_user_privilege_list(){
		$this->db->select('*');
        $this->db->order_by('usertype_id');
        $query = $this->db->get('cm_usertype');
        return $data = $query->result();
	}
	public function get_employee_list(){
		$this->db->select('id,initial,surname');
        $this->db->order_by('initial');
        $query = $this->db->get('hr_empmastr');
        return $data = $query->result();
	}

	//updated by nadee 2021-06-15
	function get_insentive(){
		$this->db->select('*');
		$query = $this->db->get('hr_insentive');
		return $query->result();
	}
	function get_otherdeduction_list(){
		$this->db->select('*');
		$query = $this->db->get('hr_otherdeduction');
		return $query->result();
	}

}
?>
