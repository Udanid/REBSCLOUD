<?php

class Project_model extends CI_Model {

    function Entry_model()
    {
        parent::__construct();
    }


    function get_all_project_names(){
		$this->db->select('prj_id,prj_name');
		$this->db->order_by('prj_id','DESC');
		$query = $this->db->get('wip_project'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
	}

    function add(){
    	
    	$prj_createby=$this->session->userdata('userid');
    	$prj_create_date=date("Y-m-d");

    	$data['prj_name'] = $this->input->post('project_mame', TRUE);
    	$data['prj_description'] = $this->input->post('prj_description', TRUE);
    	$data['prj_client']=0;
    	$data['prj_create_date']=$prj_create_date;
    	$data['prj_createby']=$prj_createby;


    	$this->db->select('*');
		$this->db->where('prj_name',$data['prj_name']);
		$query = $this->db->get('wip_project');

		if ($query->num_rows() > 0){			
			return false; 		
		}else{
			if($prj_createby){
	    		$this->db->trans_start();
				$insert=$this->db->insert('wip_project', $data);
				$this->db->trans_complete();

				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				}else{
					$this->db->trans_commit();
					return $insert;
				}
    		}
		}   	    	   	
    }

    function get_all_project_summery(){
    	$this->db->select('prj_id,prj_name,prj_createby,prj_create_date');
		$this->db->order_by('prj_id','DESC');
		$query = $this->db->get('wip_project'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }  

    function get_all_project_details($pagination_counter, $page_count){
    	$this->db->select('*');
		$this->db->order_by('prj_id','DESC');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('wip_project'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
    } 


    function get_project_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$code);
		$query = $this->db->get('wip_project'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}
		
		else
		return false;
    }

    function edit(){
    	
    	$prj_createby=$this->session->userdata('userid');
    	$prj_updated_date=date("Y-m-d");
    	$prj_id = $this->input->post('prj_id', TRUE);
    	$project_name=$this->input->post('project_mame', TRUE);

    	$this->db->select('*');
		$this->db->where('prj_name',$project_name);
		$this->db->where('prj_id !=',$prj_id);
		$query = $this->db->get('wip_project');

		if ($query->num_rows() > 0){			
			return false; 		
		
		}else{
			if($prj_id){
	    		$data=array( 
					'prj_name' => $this->input->post('project_mame', TRUE),
		    		'prj_description' => $this->input->post('prj_description', TRUE),
		    		'prj_updated_date'=> $prj_updated_date,
				);

				$this->db->where('prj_id',$prj_id);
				$insert = $this->db->update('wip_project', $data);
				return $insert;
    		}
		}    	   	
    }

    function delete($id){
		
		$this->db->select('wip_project.prj_id,wip_task.task_id,wip_sub_task.subt_id');
    	$this->db->join('wip_task','wip_task.prj_id=wip_project.prj_id');
    	$this->db->join('wip_sub_task','wip_sub_task.task_id=wip_task.task_id','left');
    	$this->db->where('wip_project.prj_id',$id); 	
		$this->db->group_by('wip_task.task_id','DESC');
		$query = $this->db->get('wip_project'); 

		$result=$query->result();

		// if($result){
		// 	foreach ($result as $raw){

		// 		if($raw->task_id){
		// 			$this->db->where('task_id',$raw->task_id);
		//         	$this->db->delete('wip_task');
		// 		}

		// 		if($raw->subt_id){
		// 			$this->db->where('subt_id',$raw->subt_id);
		//         	$this->db->delete('wip_sub_task');
		// 		}

		// 	}
		// }

		if($result){
		  return false;
		}else{
			$this->db->where('prj_id', $id);
			$insert = $this->db->delete('wip_project');
			return $insert;
		}						
	}
	
	function get_user_projects($user_id){
		$this->db->select('prj_id,prj_name');
		$this->db->order_by('prj_id','DESC');
		$this->db->limit(10);
		$query = $this->db->get('wip_project');
		if ($query->num_rows() > 0){			
			return $query->result(); 		
		}else{
			return false;	
		}
	}
}
