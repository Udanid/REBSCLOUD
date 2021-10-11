<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hm_housing extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("hm_models/housing_model");
		$this->load->model("salesmen_model");
		$this->load->model("common_model");
		$this->load->model("hm_config_model");
		$this->load->model("Hm_design_model");
		$this->is_logged_in();

	}

	public function index()
	{
		if ( ! check_access('view_housing'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/hm_housing/showall');

	}

	function showall()
	{
		if ( ! check_access('view_housing'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['datalist']=$datalist=$this->housing_model->get_all_housing($pagination_counter,$page_count,$this->session->userdata('branchid'));
		if($this->session->userdata('usertype')=='Sales_officer')
	   {
		   $data['prjlist']=$this->salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
	   }
	   else
	   {
		  $data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
	   }

		$siteurl='hm/hm_housing/showall';
		$tablename='re_hmaclot_floordata';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		$this->load->view('hm/housing/housing_data',$data);
	}

	function get_designlist($lot_id){
		$data['datalist']=$this->housing_model->get_all_designs();	
		$data['current_design']=$this->housing_model->get_current_design($lot_id);	
		$this->load->view('hm/housing/designlist',$data);
	}
	
	function get_tasklist($id,$lot_id){
		$data['tasklist']=$this->housing_model->get_all_tasks();	
		$data['prjtypes']=$this->hm_config_model->get_prjtypes();
		$data['details']=$datalist=$this->hm_config_model->get_designtypes_byid($id);
		$data['designtypeimgs'] = $this->hm_config_model->get_designtype_related_images($id);
		$data['floors'] =$floors= $this->Hm_design_model->get_designtype_rooms($id);
		$data['current_design']=$this->housing_model->get_current_design($lot_id);	
		$rooms=Null;
		$floorimages=Null;
		if($floors)
		{
			foreach ($floors as $key => $value) {
				$rooms[$value->floor_id] = $this->Hm_design_model->get_floor_related_rooms($value->floor_id);
				$floorimages[$value->floor_id] =$floors= $this->hm_config_model->get_floor_related_images($value->floor_id);
			}
		}
		$data['rooms']=$rooms;
		$data['floorimages']=$floorimages;
		$this->load->view('hm/housing/tasklist',$data);
	}
	
	function add(){
		if ( ! check_access('add_housing'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		if($lot_id = $this->housing_model->add_housing()){
			$this->common_model->add_notification('re_hmacpaymentms','housing','hm/housing',$lot_id);
			$this->logger->write_message("success", 'Successfully Inserted the Housing');
			$this->session->set_flashdata('msg', 'Successfully Inserted');
			redirect('hm/hm_housing/showall');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong');
			redirect('hm/hm_housing/showall');
		}
		
	}
	
	function get_blocklist($project_id){
		$data['lotlist']=$this->housing_model->get_all_blocks($project_id);	
		$this->load->view('hm/housing/blocklist',$data);
	}
		
	function delete($lot_id){
		if ( ! check_access('delete_housing'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		if($this->housing_model->delete_housing($lot_id)){
			$this->common_model->delete_notification('re_hmacpaymentms',$lot_id);
			$this->session->set_flashdata('msg', 'Successfully Deleted');
			redirect('hm/hm_housing/showall');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong');
			redirect('hm/hm_housing/showall');
		}
	}
	
	function confirm($lot_id){
		if ( ! check_access('confirm_housing'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		if($this->housing_model->confirm_housing($lot_id)){
			$this->session->set_flashdata('msg', 'Successfully Confirmed');
			redirect('hm/hm_housing/showall');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong');
			redirect('hm/hm_housing/showall');
		}	
	}
	
	function update(){
		if ( ! check_access('edit_housing'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		if($this->housing_model->update_housing()){
			$this->session->set_flashdata('msg', 'Successfully Updated');
			redirect('hm/hm_housing/showall');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong');
			redirect('hm/hm_housing/showall');
		}
	}
	
	//Ticket 2733 by Eranga
	function get_blocklist_reserved($project_id){
		$data['lotlist']=$this->housing_model->get_all_blocks_reserved($project_id);	
		$this->load->view('hm/housing/blocklist_reserved',$data);
	}
	
	function search_housing($lot_id){
		$data['tab']='list';
		$data['datalist']=$datalist=$this->housing_model->get_search_housing($lot_id,$this->session->userdata('branchid'));
		if($this->session->userdata('usertype')=='Sales_officer')
	   {
		   $data['prjlist']=$this->salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
	   }
	   else
	   {
		  $data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
	   }
		$this->load->view('hm/housing/housing_data_search',$data);
	}

}
