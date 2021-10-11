<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qualification_model extends CI_Model{



//ticket no:2969
	function get_emp_detailes($id,$branch,$division,$designation)
	{
		

		$this->db->select('hr_empmastr.*,hr_olresults.result as olresults,hr_alresults.result as alresult,hr_empqlfct.qualification_details,hr_workexpr.experience_details','hr_empmastr.joining_date');



		$this->db->join('hr_olresults','hr_olresults.emp_record_id=hr_empmastr.id','left');
		$this->db->join('hr_alresults','hr_alresults.emp_record_id=hr_empmastr.id','left');
		$this->db->join('hr_empqlfct','hr_empqlfct.emp_record_id=hr_empmastr.id','left');
		$this->db->join('hr_workexpr','hr_workexpr.emp_record_id=hr_empmastr.id','left');



			if($id!="all")
			
				$this->db->where('hr_empmastr.id',$id);
			

			if($branch!="all")
			
				$this->db->where('hr_empmastr.branch',$branch);
			
			if($division!="all")
			
				$this->db->where('hr_empmastr.division',$division);
			
			if($designation!="all")
			
				$this->db->where('hr_empmastr.designation',$designation);
			
		
		
		

		$this->db->order_by('epf_no');

		$query = $this->db->get('hr_empmastr');
		return $query->result();








			
			
			
			
			//$this->db->where('hr_empmastr.id',$id);
		//$this->db->order_by('id', 'desc');
		//$this->db->limit($pagination_counter, $page_count);

		//$this->db->limit($pagination_counter, $page_count);
		/*$query = $this->db->get('hr_alresults');
		return $query->result();*/
	}


	function get_ol_results($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_olresults');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}


			function get_higher_education($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_empqlfct');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}


			function get_work_experience($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_workexpr');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}


		function get_al_results($id){
			$this->db->select('*');
			$this->db->where('emp_record_id', $id);
			$query = $this->db->get('hr_alresults');
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return false;
			}
		}



		function get_branch_list()
		{
			$this->db->select('*');
        $this->db->order_by('branch_name', 'asc');
        $query = $this->db->get('cm_branchms');
        return $query->result();
		}


	

}
?>
