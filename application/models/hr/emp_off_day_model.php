<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class emp_off_day_model extends CI_Model{



function dayoff_request_details($pagination_counter, $page_count){
  $this->db->select('*');
  $this->db->order_by('hr_emp_leave_offdays.start_date','DESC');
  $this->db->limit($pagination_counter, $page_count);
  $query = $this->db->get('hr_emp_leave_offdays');
  return $query->result();
}

 function submit_day_off(){
   $data2['emp_record_id'] = $this->input->post('emp_id', TRUE);
   $data2['start_date'] = $this->input->post('from_date', TRUE);
   $data2['end_date'] = $this->input->post('to_date', TRUE);
   $data2['request_date'] = date("Y-m-d");
   $this->db->trans_start();
     $this->db->insert('hr_emp_leave_offdays', $data2);
   $this->db->trans_complete();
 }
 function confirm_cancel_day_off($day_off_id,$statues){
   $data['statues'] = $statues;
   $this->db->trans_start();
   $this->db->where('id', $day_off_id);
   $this->db->update('hr_emp_leave_offdays', $data);
   $this->db->trans_complete();
 }

 function day_off_count($year,$month,$emp_record_id){
   $sql_q="SELECT SUM(DATEDIFF(end_date,start_date)+1) as date_diff
FROM hr_emp_leave_offdays
where MONTH(start_date)='".$month."'
AND YEAR(start_date)='".$year."'
AND emp_record_id='".$emp_record_id."'
AND statues='Approved'
GROUP BY emp_record_id";

   $query=$this->db->query($sql_q);
   $day_off_count_records_all = $query->row();


  if( $query->result()!=Null){
    $day_off_count_records=$day_off_count_records_all->date_diff;
    return $day_off_count_records;
 }else {
   return 0;
 }
 }

 function leave_delete($id)
 {
   $this->db->where('id', $id);
   $this->db->delete('hr_emp_leave_records');
   return true;
 }
 function get_employee_leave_search($emp_id)
 {

     $this->db->select('hr_emp_leave_records.*');

     $this->db->join('hr_empmastr','hr_emp_leave_records.emp_record_id=hr_empmastr.id');
     $this->db->where('hr_emp_leave_records.emp_record_id',$emp_id);
     $query = $this->db->get('hr_emp_leave_records');
     return $query->result();

 }
}
