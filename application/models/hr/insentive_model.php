<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insentive_model extends CI_Model{

  function get_employee_list($id = "all",$branch = "all",$division = 'all'){
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
  function get_incentive()

  {

          $query=$this->db->get("hr_insentive");
          return $query->result();
  }

  	function insentive_submit()
  	{


  		$insentive=$this->input->post("incentive");
  		$data['insentive_type']=$insentive;
  		$year = $this->input->post('year', TRUE);
  		$data['year'] = $year;
  		$month = $this->input->post('month', TRUE);
  		$data['month'] = $month;
  		$data['status']="P";
  		$data['generated_by'] = $this->session->userdata('username');

  		$this->db->trans_start();
  		$this->db->insert('hr_insentive_master', $data);
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
    function insentive_submit_details($last_insert_id)
    {
      $employee_list = $this->get_employee_list();


      foreach($employee_list as $employee){
        if($employee->status == 'A' && $employee->salary_confirmation=='Y'){

          $insentive_data['insentive_master_id'] = $last_insert_id;
          $insentive_data['emp_record_id'] = $employee->id;
          $insentive_data['status']="P";
          $insentive_data['amount']=$this->input->post("amount_".$employee->id);



          $insentive_data['created'] = date('Y-m-d H:i:s');

          $this->db->trans_start();
          $this->db->insert('hr_emp_payroll_insentive', $insentive_data);
          $this->db->trans_complete();
        }
      }
    }

    function insentive_submit_upload($last_insert_id,$employeeid,$amount)
    {

          $insentive_data['insentive_master_id'] = $last_insert_id;
          $insentive_data['emp_record_id'] = $employeeid;
          $insentive_data['status']="P";
          $insentive_data['amount']=$amount;
          $insentive_data['created'] = date('Y-m-d H:i:s');

          $this->db->trans_start();
          $this->db->insert('hr_emp_payroll_insentive', $insentive_data);
          $this->db->trans_complete();

    }


  		function get_incentive_master_list($pagination_counter, $page_count){
  		$this->db->select('hr_insentive_master.*,hr_insentive.allowance');
      $this->db->join('hr_insentive','hr_insentive_master.insentive_type=hr_insentive.id');
  		$this->db->order_by('id', 'desc');
  		$this->db->limit($pagination_counter, $page_count);
  		$query = $this->db->get('hr_insentive_master');
  		return $query->result();
  	}

  	function get_incentive_list($id){
  		$this->db->select('*');
  		$this->db->where('insentive_master_id', $id);
  		$query = $this->db->get('hr_emp_payroll_insentive');
  		return $query->result();
  	}

  	function get_incentive_master_details($id){
  		$this->db->select('*');
  		$this->db->where('id', $id);
  		$query = $this->db->get('hr_insentive_master');
  		return $query->row_array();
  	}

  		public function check_incentive_payment($id){
  		$data['status'] = "C";
  		$data['confirmed_by'] = $this->session->userdata('username');
  		$data['confirmed_date'] = date('Y-m-d H:i:s');
  		$this->db->trans_start();
  		$this->db->where('id', $id);
  		$this->db->update('hr_insentive_master',$data);
  		$this->db->trans_complete();
  	}


  	public function confirm_incentive_payment($id){
  		$data['status'] = "Y";
  		$data['confirmed_by'] = $this->session->userdata('username');
  		$data['confirmed_date'] = date('Y-m-d H:i:s');
  		$this->db->trans_start();
  		$this->db->where('id', $id);
  		$this->db->update('hr_insentive_master',$data);
  		$this->db->trans_complete();
  	}

  		function check_incentive_master_year_month($year, $month,$type){
  		$this->db->select('*');
  		$this->db->where('year', $year);
  		$this->db->where('month', $month);
      $this->db->where('insentive_type', $type);
  		$this->db->where('status !=', 'N');
  		$query = $this->db->get('hr_insentive_master');
  		return $query->row_array();
  	}



  	function decline_incentive($id){
  		$incentive_master['status'] = "N";
  		$incentive_master['confirmed_by'] = $this->session->userdata('username');
  		$incentive_master['confirmed_date'] = date('Y-m-d H:i:s');

  		$this->db->trans_start();
  		$this->db->where('id', $id);
  		$this->db->update('hr_insentive_master', $incentive_master);
  		$this->db->trans_complete();

  		$incentive_data['status'] = "N";

  		$this->db->trans_start();
  		$this->db->where('insentive_master_id', $id);
  		$this->db->update('hr_emp_payroll_insentive', $incentive_data);
  		$this->db->trans_complete();
  	}

    function get_all_incentive_fields($pagination_counter, $page_count){
  		$this->db->select('*');
  		$this->db->order_by('id');
  		$this->db->limit($pagination_counter, $page_count);
  		$query = $this->db->get('hr_insentive');
  		return $query->result();
      }





  	public function add_incentive_field(){
  		$data['allowance'] = $this->input->post('incentive', TRUE);
  		$data['updated_by'] = $this->session->userdata('username');
  		$data['last_updated']=date('Y-m-d H:i:s');
  		$this->db->trans_start();
      	$this->db->insert('hr_insentive', $data);
  		$this->db->trans_complete();
  		if($this->db->trans_status() === FALSE){
  			$this->db->trans_rollback();
  			return false;
  		}else{
  			$this->db->trans_commit();
  			return true;
  		}
  	}



  	function get_incentive_details($id){
  		$this->db->select('*');
  		$this->db->where('id', $id);
  		$query = $this->db->get('hr_insentive');
  		return $query->row_array();
      }


      public function update_incentive_details(){
  		$ID = $this->input->post('id', TRUE);
  		$data['allowance'] = $this->input->post('incentive', TRUE);
  		$data['updated_by'] = $this->session->userdata('username');
  		$this->db->trans_start();
  		$this->db->update('hr_insentive', $data, "id = $ID");
  		$this->db->trans_complete();

  		if($this->db->trans_status() === FALSE){
  			$this->db->trans_rollback();
  			return false;
  		}else{
  			$this->db->trans_commit();
  			return true;
  		}
  	}

    function hr_temp_data_id($emp,$amount)
    {
      $data = array('emp_no' =>$emp ,'amount' =>$amount ,  );
      $this->db->insert('hr_temp_data',$data);
    }









}
