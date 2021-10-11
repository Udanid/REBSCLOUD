<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Market_surveyor_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
    function add()
	{
		if(count($this->market_surveyor_model->getLastID()) == 0){
			$lasd_id = 1;
		}else{
			$lasd_id = $this->market_surveyor_model->getLastID()[0]['id'] + 1;
		}	

		// print($lasd_id);
		
		// exit;

        $data=array(
            'land_code' => $this->input->post('land_code'),
            'branch_code' => $this->session->userdata('branchid'),
            'market_survey_code' => $this->input->post('land_code') ."_MS0". $lasd_id,
            'pipe_born_water' => $this->input->post('pipe_born_water'),
            'distance_to_main_pipe_line' => $this->input->post('distance_to_main_pipe_line'),
			'water_source_informarion' => $this->input->post('water_supply_project_necessity'),
			'used_water_level_type' => $this->input->post('used_water_level_type'),
            'soil_condition' => $this->input->post('soil_condition'),
            'population_data' => $this->input->post('population_factor'),
            'distance_electricity_post' => $this->input->post('distance_electricity'),
            'distance_to_transformer' => $this->input->post('distance_transformer'),
            'land_factors_positive' => $this->input->post('land_positive_factor'),
            'land_factors_negative' => $this->input->post('land_negative_factor'),
            'recommended_sale_price' => $this->input->post('sale_price_per_perch'),
            'marketability_descriptions' => json_encode($this->input->post('marketability_item_desc')),
			'marketability_values' => json_encode($this->input->post('marketability_item_value')),  
			'status' => 'PENDING', 
        );

        // print_r($data);
        // exit;
        		
		$insert = $this->db->insert('re_market_surveyor', $data);

		return $insert;

	}

	function edit()
	{
		
		
		$data=array(            
            'branch_code' => $this->session->userdata('branchid'),
            'pipe_born_water' => $this->input->post('pipe_born_water'),
            'distance_to_main_pipe_line' => $this->input->post('distance_to_main_pipe_line'),
			'water_source_informarion' => $this->input->post('water_supply_project_necessity'),
			'used_water_level_type' => $this->input->post('used_water_level_type'),
            'soil_condition' => $this->input->post('soil_condition'),
            'population_data' => $this->input->post('population_factor'),
            'distance_electricity_post' => $this->input->post('distance_electricity'),
            'distance_to_transformer' => $this->input->post('distance_transformer'),
            'land_factors_positive' => $this->input->post('land_positive_factor'),
            'land_factors_negative' => $this->input->post('land_negative_factor'),
            'recommended_sale_price' => $this->input->post('sale_price_per_perch'),
            'marketability_descriptions' => json_encode($this->input->post('marketability_item_desc')),
			'marketability_values' => json_encode($this->input->post('marketability_item_value')),  
			);
			
			$updated = $this->db->set($data)->where('market_survey_code ', $_POST['market_survey_code'])
			->update('re_market_surveyor');


        // print_r($data);
        // exit;
		return $updated;

	}



	function get_all_market_servay_report($branch_id){
		$this->db->select('*');		
		if(! check_access('all_branch'))
		$this->db->where('re_market_surveyor.branch_code',$branch_id);
		$query = $this->db->get('re_market_surveyor'); 
		return $query->result();
	}
	
	function get_all_market_servay_reports($branch_id){
		$this->db->select('re_market_surveyor.*, re_landms.property_name, re_landms.district');
		$this->db->where('re_landms.branch_code = re_market_surveyor.branch_code AND re_landms.land_code = re_market_surveyor.land_code');
		if(! check_access('all_branch'))
		$this->db->where('re_market_surveyor.branch_code',$branch_id);
		$query = $this->db->get('re_landms , re_market_surveyor'); 
		return $query->result();
	}
		
	function confirm($id)
	{
		$data=array( 
			'confirm_by' =>$this->session->userdata('userid'),
		);
		$this->db->where('prj_id', $id);
		$insert = $this->db->update('re_prjfstimestamp', $data);
		$data=array( 		
		'status' => CONFIRMKEY,
		);
		$this->db->where('market_survey_code', $id);
		$insert = $this->db->update('re_market_surveyor', $data);
		return $insert;
		
	}

	function delete($id)
	{
		if($id)
		{
		//$tot=$bprice*$quontity; 
		$this->db->where('market_survey_code', $id);
		$result = $this->db->delete('re_market_surveyor');
		}
		return $id;
		
		
	}

	function getLastID(){
		$query = $this->db->query("SELECT * FROM re_market_surveyor ORDER BY id DESC LIMIT 1");
		$result = $query->result_array();
		return $result;
	}

	function get_market_servay_by_code($survey_id){
		$this->db->select('*');		
		$this->db->where('re_market_surveyor.market_survey_code',$survey_id);
		$query = $this->db->get('re_market_surveyor'); 
		return $query->result();
	}

	function get_market_servay_comments($survey_id) { 
		$this->db->select('*');
		$this->db->where('market_survey_code',$survey_id);
		$query = $this->db->get('re_market_survey_comment');
		return $query->result();
	}

	function comment_add()
	{
		$this->db->where('market_survey_code', $this->input->post('market_survey_code'));
		$insert = $this->db->delete('re_market_survey_comment');

		$data=array(

			'market_survey_code' => $this->input->post('land_code'),
			'userid' => $this->session->userdata('userid'),
			'comment_type' => 'Higer Auth',
			'comment' => $this->input->post('high_auth'),
			'comment_date' => date("Y-m-d"),

			);
			$this->db->insert('re_market_survey_comment', $data);

			$data=array(

			'market_survey_code' => $this->input->post('market_survey_code'),
			'userid' => $this->session->userdata('userid'),
			'comment_type' => 'Managers',
			'comment' => $this->input->post('manager'),
			'comment_date' => date("Y-m-d"),


			);
			$this->db->insert('re_market_survey_comment', $data);


	}
	
	function get_project_by_land_code($land_code) { //get all stock
		$this->db->select('re_projectms.*');
		$this->db->where('re_projectms.land_code',$land_code);
		$query = $this->db->get('re_projectms'); 
		return $query->row(); 
	}
	
	
	
}