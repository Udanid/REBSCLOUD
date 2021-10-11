<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrreport_model extends CI_Model{

  function get_emp_payroll($emp,$payroll_month,$year)
  {
    //get salary details by empid
    $this->db->select("hr_emp_payroll.*,
      hr_payroll_master.status,
      hr_payroll_master.year,
      hr_payroll_master.month");
    $this->db->join('hr_payroll_master','hr_payroll_master.id = hr_emp_payroll.payroll_master_id');
    $this->db->where('hr_payroll_master.status','Y');
    $this->db->where('hr_emp_payroll.emp_record_id',$emp);
    $this->db->where('hr_payroll_master.month',$payroll_month);
    $this->db->where('hr_payroll_master.year',$year);
    $query = $this->db->get('hr_emp_payroll');
    if ($query->num_rows()> 0){
      $result=$query->row();
      return $result;
    }
  }



  function get_emp_allowances($emp,$payroll_id)
  {
    $this->db->select('hr_emp_allowance_for_payroll.allowance_id,
    Sum(hr_emp_allowance_for_payroll.amount) as amount,
    hr_allowances.allowance');
    $this->db->join('hr_allowances','hr_allowances.id = hr_emp_allowance_for_payroll.allowance_id');
    $this->db->where('hr_emp_allowance_for_payroll.payroll_master_id',$payroll_id);
    $this->db->where('hr_emp_allowance_for_payroll.emp_record_id',$emp);
    $this->db->group_by('hr_emp_allowance_for_payroll.allowance_id');
    $query = $this->db->get('hr_emp_allowance_for_payroll');
    $result=$query->result();
    return $result;
  }

  function get_emp_fuel_allowance_payment($emp,$fuel_month,$year)
  {
    $this->db->select('hr_emp_fuel_allowance_payment.total_amount_payable');
    $this->db->join('hr_fuel_allowance_payment_master','hr_fuel_allowance_payment_master.id = hr_emp_fuel_allowance_payment.allowancee_payment_master_id');
    $this->db->where('hr_fuel_allowance_payment_master.status','Y');
    $this->db->where('hr_fuel_allowance_payment_master.year',$year);
    $this->db->where('hr_fuel_allowance_payment_master.month',$fuel_month);
    $this->db->where('hr_emp_fuel_allowance_payment.emp_record_id',$emp);
    $query = $this->db->get('hr_emp_fuel_allowance_payment');
    $result=$query->result();
    return $result;
  }
  function get_emp_phone_bill_payment($emp,$month,$year)
  {
    $this->db->select('hr_emp_phonebill.bill_value');
    $this->db->join('hr_phonebill_master','hr_phonebill_master.id = hr_emp_phonebill.phonebill_master_id');
    $this->db->where('hr_phonebill_master.status','Y');
    $this->db->where('hr_phonebill_master.year',$year);
    $this->db->where('hr_phonebill_master.month',$month);
    $this->db->where('hr_emp_phonebill.emp_record_id',$emp);
    $query = $this->db->get('hr_emp_phonebill');
    $result=$query->result();
    return $result;
  }



}
