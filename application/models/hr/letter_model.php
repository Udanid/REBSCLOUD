<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class letter_model extends CI_Model{
 
  function insert_letter($data)
  {
    $insert = $this->db->insert('hr_emp_letters', $data);
    return $this->db->insert_id();
  }

  function get_letter_list(){
    $this->db->select('*');
    $query = $this->db->get('hr_letter_type');
    return $query->result();
  }

  function get_letters_by_empno($emp_id){
    $this->db->select('*');
    $this->db->join('hr_letter_type','hr_letter_type.id=hr_emp_letters.letter_type');
    $this->db->where('emp_id', $emp_id);
    $this->db->order_by('hr_emp_letters.date', 'desc');
    $query = $this->db->get('hr_emp_letters');
    return $query->result();
  }

  function get_letters_by_empno_letter_type($emp_id,$letter_type){
    $this->db->select('*');
    $this->db->join('hr_letter_type','hr_letter_type.id=hr_emp_letters.letter_type');
    $this->db->where('emp_id', $emp_id);
    $this->db->where('letter_type', $letter_type);
    $this->db->order_by('hr_emp_letters.date', 'desc');
    $query = $this->db->get('hr_emp_letters');
    return $query->result();
  }

}
