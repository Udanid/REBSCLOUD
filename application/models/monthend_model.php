<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Monthend_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_active_period()
	{
		$this->db->select('*');
		$this->db->where('status', 'ACTIVE');
		$query = $this->db->get('cm_monthendprocess'); 
		 if ($query->num_rows > 0) 
		return $query->row(); 
		else
		return false;
	}
	function previous_list()
	{
		$this->db->select('*');
		$query = $this->db->get('cm_monthendprocess'); 
		 if ($query->num_rows > 0) 
		return $query->result(); 
		else
		return false;
	}
	function get_current_period()
	{
		$this->db->select('*');
		$query = $this->db->get('cm_monthactive'); 
		 if ($query->num_rows > 0) 
		return $query->row(); 
		else
		return false;
	}
	function close_period($id)
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
		$this->db->where('id', $id);
		$query = $this->db->get('cm_monthendprocess'); 
		 if ($query->num_rows > 0) 
		 {
			$data= $query->row(); 
			$next_start_date=date('Y-m-d',strtotime('+1 days',strtotime($data->period_end)));
			$next_end_date=date("Y-m-t", strtotime($next_start_date));
			$next_month=date("m", strtotime($next_start_date));
			$next_year=date("Y", strtotime($next_start_date));
					
					$data2=array( 
				'month'=>$next_month,
				'year' => $next_year,
				'period_start'=>$next_start_date,
				'period_end'=>$next_end_date,
				'start_date'=>date('Y-m-d'),
				'start_by'=>$this->session->userdata('userid'),
				);
				$insert = $this->db->insert('cm_monthendprocess', $data2);
				$data1=array( 
				'status'=>'CLOSE',
				'end_date'=>date('Y-m-d'),
				'end_by'=>$this->session->userdata('userid'),
				);
				$this->db->where('id', $id);
				$insert = $this->db->update('cm_monthendprocess', $data1);
				
				$data3=array( 
				'start_date'=>$next_start_date,
				'end_date' => $next_end_date,
				
				'last_update'=>date('Y-m-d'),
				
				);
				$this->db->where('id',1);
				$insert = $this->db->update('cm_monthactive', $data3);
				
				return true;
		
		
		 }
		else
		return false;
	}
	function init_period()
	{
		$next_start_date=$this->uri->segment('4');
		$enddate=$this->uri->segment('5');
		$next_end_date=date("Y-m-t", strtotime($enddate));
		$next_month=date("m", strtotime($next_start_date));
			$next_year=date("Y", strtotime($next_start_date));
			$this->db->where('status','ACTIVE');
				$insert = $this->db->delete('cm_monthendprocess');
			$data2=array( 
				'month'=>$next_month,
				'year' => $next_year,
				'period_start'=>$next_start_date,
				'period_end'=>$next_end_date,
				'start_date'=>date('Y-m-d'),
				'start_by'=>$this->session->userdata('userid'),
				);
				$insert = $this->db->insert('cm_monthendprocess', $data2);
				
				
				$data3=array( 
				
				'start_date'=>$next_start_date,
				'end_date' => $next_end_date,
				
				'last_update'=>date('Y-m-d'),
				'init_update_status'=>'1'
				
				);
			$this->db->where('id',1);
				$insert = $this->db->update('cm_monthactive', $data3);
		
	}
	function get_finace_year()
	{
		$this->db->select('year,start_date,end_date');
			$query = $this->db->get('ac_finance_year');
			
			 if ($query->num_rows > 0) 
		return $query->row(); 
		else
		return false;
	}
	 function init_finance_year($year,$start_date,$end_date)
	{
		//add year to ac_finance_year table
		$data = array(
			'year'			=>	$year,
			'start_date'	=>	$start_date,
			'end_date'		=> 	$end_date,
			'op_balance'		=> 	1
		);
		
		$this->db->insert('ac_finance_year', $data);	
		
		
		$data3=array( 
				
				'fy_start'=>$start_date,
				'fy_end' => $end_date,
				
				
				);
			$this->db->where('id',1);
			$insert = $this->db->update('cm_settings', $data3);
	}
}