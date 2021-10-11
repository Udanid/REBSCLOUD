<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discounts extends CI_Controller {

	 function __construct() {
        parent::__construct();
		$this->load->model("project_model");
		$this->load->model("discounts_model");
		$this->load->model("common_model");
		$this->is_logged_in();
    }

	public function index()
	{
		if ( ! check_access('project_discounts'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('home');
			return;
		}
		
		if($this->discounts_model->check_discount_schemes()){
			$this->session->set_flashdata('error', 'Discount Scheme Available for this Project');
			redirect("re/discounts/index");
		}
		
		
		if($_POST){
			if($id = $this->discounts_model->add_discount_scheme()){
				$this->common_model->add_notification('re_discountschedule','Discount Check','re/discounts',$this->input->post('prj_id'),'check_project_discounts');
				$this->session->set_flashdata('msg', 'Discount Scheme Successfully Inserted');
				$this->logger->write_message("success", $this->input->post('name').'  successfully Inserted');
				redirect("re/discounts/index");
			}else{
				$this->session->set_flashdata('error', 'Unable to Add the Discount Scheme');
				redirect('re/discounts/index');
				return;
			}
		}
		$data['datalist']=$this->discounts_model->get_all_project_confirmed();
		$data['tab']='list';
		$data['project_discounts'] = $this->discounts_model->get_all_project_discounts();
		$this->load->view("re/discounts/index",$data);	

	}
	
	function create_list(){
		$periods = $this->input->post('periods');	
		$levels = $this->input->post('levels');
		$html = '<h4>Add Scheme</h4>';
		$html .= '<table class="table">';
		
		for($x=0 ; $x <= $periods;$x++){
			$html .= '<tr>';
			if($x == 0){
				$html .= '<td></td>';
				for($y=1 ; $y <= $levels;$y++){
				  	$html .= '<td><input type="number" required onkeypress="return isNumber(event)" placeholder="Completetion (%)" name="level'.$y.'" id="level'.$y.'" class="form-control" /></td>';		
			  	}		
			}else{
			  $html .= '<td><input type="number" onkeypress="return isNumber(event)" required placeholder="Within (Days)" name="period'.$x.'" id="period'.$x.'" class="form-control" /></td>';		
			  for($y=1 ; $y <= $levels;$y++){
				  $html .= '<td><input type="number" onkeypress="return isNumber(event)" step="0.01" name="rate'.$x.$y.'" placeholder="Rate (%)" id="rate'.$x.$y.'" class="form-control" /></td>';		
			  }
			}
			$html .= '</tr>';
		}
		$colspan = $levels+1;
		$html .= '<tr><td align="right" colspan="'.$colspan.'"><button type="submit" class="btn btn-primary disabled" >Submit</button></td></tr>';
		$html .= '</table>';
		
		echo $html;
	}
	
	function view(){
		$data['project_discount'] = $this->discounts_model->get_project_discount($this->uri->segment(4));
		$data['project'] = $this->project_model->get_project_bycode($this->uri->segment(4));
		$this->load->view("re/discounts/view",$data);	
	}
	
	function edit(){
		
		if($_POST){
			
			if ( ! check_access('edit_project_discounts'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('home');
				return;
			}
			
			if($this->discounts_model->update_discount_scheme($this->uri->segment(4))){
				$this->session->set_flashdata('msg', 'Discount Scheme Successfully Updated');
				$this->logger->write_message("success", $this->input->post('name').'  successfully Updated');
				redirect("re/discounts/index");
			}else{
				$this->session->set_flashdata('error', 'Unable to Update the Discount Scheme');
				redirect('re/discounts/index');
				return;
			}
		}
		
		$data['project_discount'] = $this->discounts_model->get_project_discount($this->uri->segment(4));
		$data['project'] = $this->project_model->get_project_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('re_discountschedule',$this->uri->segment(4),'prj_id');
		$this->load->view("re/discounts/edit",$data);	
	}
	
	function delete(){
		if ( ! check_access('delete_project_discounts'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('home');
			return;
		}
		
		if($this->discounts_model->delete_discount_scheme($this->uri->segment(4))){
			$this->common_model->delete_notification('re_discountschedule',$this->uri->segment(4));
			$this->session->set_flashdata('msg', 'Discount Scheme Successfully Deleted');
			$this->logger->write_message("success", 'Discount Scheme successfully Deleted');
			redirect("re/discounts/index");
		}else{
			$this->session->set_flashdata('error', 'Unable to Update the Discount Scheme');
			redirect('re/discounts/index');
			return;
		}
	}
	
	function confirm(){
		$action = $this->uri->segment(5);
		if ( ! check_access($action.'_project_discounts'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('home');
			return;
		}
		
		if($this->discounts_model->confirm_discount_scheme($this->uri->segment(4),$action)){
			if($action == 'check'){
				$this->common_model->delete_notification('re_discountschedule',$this->uri->segment(4));
				$this->common_model->add_notification('re_discountschedule','Discount Confirmation','re/discounts',$this->uri->segment(4),'confirm_project_discounts');
				$this->session->set_flashdata('msg', 'Discount Scheme Successfully Checked');
				$this->logger->write_message("success", 'Discount Scheme successfully Checked');
			}else{
				$this->common_model->delete_notification('re_discountschedule',$this->uri->segment(4));
				$this->session->set_flashdata('msg', 'Discount Scheme Successfully Confirmed');
				$this->logger->write_message("success", 'Discount Scheme successfully Confirmed');
			}
			redirect("re/discounts/index");
		}else{
			$this->session->set_flashdata('error', 'Unable to '.$action.' the Discount Scheme');
			redirect('re/discounts/index');
			return;
		}
	}

		//Ticket No:2689 Added By Madushan 2021.04.20
	function seach_project_data(){
		$prj_id = $this->uri->segment(4);
		$data['project_discounts']=$this->discounts_model->get_all_project_discounts_search($prj_id);
		$this->load->view('re/discounts/prj_discount_search',$data);
	}

}
