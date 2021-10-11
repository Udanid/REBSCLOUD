<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//model create by nadee_randeniya
//date:18/05/2018

class institute_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_all_banks()
  {
    $this->db->select('BANKCODE,BANKNAME');
    $this->db->order_by('BANKNAME');
    $query = $this->db->get('cm_banklist');
    return $query->result();
  }
  function get_branch_names($code)
  {
    $this->db->select('BRANCHCODE,BRANCHNAME');
    $this->db->where('BANKCODE',$code);
    $query = $this->db->get('cm_bnkbrnch');
    return $query->result();
  }
  function add()
  {
    $bank_code=$this->input->post('bank_code');
    $this->db->select('BANKCODE');
    $this->db->where('BANKCODE',$bank_code);
    $query = $this->db->get('cm_banklist');
    if ($query->num_rows() == 0){

    $data=array(
      'BANKCODE' => $this->input->post('bank_code'),
      'BANKNAME' => $this->input->post('bank_name')
    );

    $insert = $this->db->insert('cm_banklist', $data);
    return true;
  }
  else{
    return false;
  }
}
function addbranch()
{
  $branch_code=$this->input->post('branch_code');
  $bank=$this->input->post('bank');
  $this->db->select('BRANCHCODE');
  $this->db->where('BRANCHCODE',$branch_code);
  $this->db->where('BANKCODE',$bank);
  $query = $this->db->get('cm_bnkbrnch');
  if ($query->num_rows() == 0){

  $data=array(
    'BANKCODE' => $this->input->post('bank'),
    'BRANCHCODE' => $this->input->post('branch_code'),
    'BRANCHNAME' => $this->input->post('branch_name')
  );

  $insert = $this->db->insert('cm_bnkbrnch', $data);
  return true;
}
else{
  return false;
}
}

}
