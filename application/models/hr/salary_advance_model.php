<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class salary_advance_model extends CI_Model{

function salary_advance_submit(){
  date_default_timezone_set('Asia/Colombo');
  $amount = $this->input->post('amount', TRUE);
  $reason = $this->input->post('reason', TRUE);

  $data1['year'] = date('Y');
  $data1['month'] = date('m');
  $data1['amount'] = $amount;
  $data1['user_id'] = $this->session->userdata('userid');
  $data1['request_date'] = date('Y-m-d H:i:s');
  $data1['reason']=$reason;

  $insert=$this->db->insert('hr_emp_salary_advance_request', $data1);
  if($insert){
    return true;
  }


}

function get_salary_advance_request($emp_id,$month){
  $this->db->select('SUM(amount) as amount');
  $this->db->where('user_id',$emp_id);
  $this->db->where('month',$month);
  $this->db->where('year',date("Y"));
  $this->db->where('Statues',"Pending");
  $this->db->group_by('month');
  $query = $this->db->get('hr_emp_salary_advance_request');
  return $query->row();
}

//get for check exceed salaries deductions in phone bill, salary advance
function check_basic_salary($emp_id){

  $this->db->select('*');
  $this->db->where('emp_record_id',$emp_id);
  $this->db->where('status',"Y");
  $query = $this->db->get('hr_emp_salary');
  return $query->row();
}
}
