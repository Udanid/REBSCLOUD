<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class emp_app_model extends CI_Model{
  public function get_employment_attendence(){
    $date=date('Y-m-d');
    $this->db->select('max(`timestamp`) as outtime,MIN(`timestamp`) as intime,user_id,date');
    $this->db->where('date',$date);
    $this->db->where('timestamp <> ""');
    $this->db->group_by('user_id');
    $query = $this->db->get('re_attendance_app');
    return $data = $query->result();
  }
  function select_username($emp_id)
  {
    $this->db->select('USRNAME');
    $this->db->where('USRID',$emp_id);
    $query=$this->db->get('cm_userdata');
    if ($query->num_rows() > 0){
      return $query->row();
    }
    else {
      return 0;
    }
  }
  function insert_attendent($data)
  {
    $insert = $this->db->insert('hr_emp_attendance', $data);
    return $this->db->insert_id();
  }

  public function index()
  {
    $user_name='';
    $data=$this->get_employment_attendence();
    foreach ($data as $key => $value) {
      $out_time=date('Y-m-d H:i:s', $value->outtime);
      $in_time=date('Y-m-d H:i:s', $value->intime);
      $date=date('Y-m-d', $value->intime);
      $user=$this->select_username($value->user_id);
      if($user){
        $user_name=$user->USRNAME;
      }
      $data = array('emp_record_id' =>$value->user_id ,
      'username' => $user_name,
      'date' =>$date ,
      'duty_in' =>$in_time ,
      'duty_out' => $out_time);
      $id=$this->insert_attendent($data);
    }

  }



}
