<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketsurveyor extends CI_Controller {

	/**
	 * Index Page for this controller.intorducer
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
        parent::__construct();
		
		$this->load->model("land_model");
		$this->load->model("common_model");		
		$this->load->model("project_model");		
		$this->load->model("branch_model");
		$this->load->model("branch_model");
		$this->load->model("market_surveyor_model");
		$this->load->model("introducer_model");
		$this->load->model("document_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('home');
			return;
		}

		$inventory=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
        
		redirect('re/marketsurveyor/view');		
		
	}
	
	public function add(){

		$data=NULL;
		if ( ! check_access('add_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/index');
			return;
		}

		$data = "";
		$data['market_servay_data'] = $this->market_surveyor_model->get_all_market_servay_reports($this->session->userdata('branchid'));
		
		$data['searchdata']= $this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['branchlist']= $this->branch_model->get_all_branches_summery();
		$data['land_list']= $this->land_model->get_all_unused_land_summery();
		$data['searchpath']='re/market_surveyor/search';

		
		if(count($data['market_servay_data']) > 0)
		{
			foreach($data['market_servay_data'] as $row){	
				$iCount = 0;
				foreach($data['land_list'] as $lnd_row)
				{
					if($lnd_row->land_code == $row->land_code){						
						unset($data['land_list'][$iCount]);
					}
					$iCount++;
				}
			}
		}
		
		$this->load->view('re/market_surveyor/survey_data',$data);
		 
	}

	public function add_action()
	{
		if ( ! check_access('add_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/view');
			return;
		}	
		
		$result = $this->market_surveyor_model->add();
		redirect("re/marketsurveyor/add");

	}

	public function view($survey_id){

		$data=NULL;
		if ( ! check_access('view_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/add');
			return;
		}		

		$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$data['market_servay_data'] = $this->market_surveyor_model->get_market_servay_by_code($survey_id);
		$land_code = $data['market_servay_data'][0]->land_code;		
		$data['project_details']=$this->market_surveyor_model->get_project_by_land_code($land_code);
		$data['land_details']=$this->land_model->get_land_bycode($land_code);
		$data['land_owner_details']=$this->land_model->get_land_owners($land_code);
		
        $this->load->view('re/market_surveyor/view',$data);		
		 
	}


	public function edit($survey_id){
		
		$data=NULL;
		if ( ! check_access('edit_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/market_surveyor/add');
			return;
		}	

				
		$data['market_servay_data'] = $this->market_surveyor_model->get_market_servay_by_code($survey_id);
		$land_code = $data['market_servay_data'][0]->land_code;		
		$data['project_details']=$this->market_surveyor_model->get_project_by_land_code($land_code);
		$data['land_details']=$this->land_model->get_land_bycode($land_code);
		$data['land_owner_details']=$this->land_model->get_land_owners($land_code);

		$data['searchdata']= $this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['branchlist']= $this->branch_model->get_all_branches_summery();
		$data['land_list']= $this->land_model->get_all_unused_land_summery();
		$data['searchpath']='re/market_surveyor/search';
		
        $this->load->view('re/market_surveyor/edit',$data);		
	}

	public function edit_action()
	{
		if ( ! check_access('edit_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/add');
			return;
		}
		
		$result = $this->market_surveyor_model->edit();
		

		if($result){
			$this->session->set_flashdata('msg', 'Market Surveyour Details Successfully Updated ');	
			redirect("re/marketsurveyor/add");
		}else{
			$this->session->set_flashdata('msg', 'Market Surveyour Details Not Updated ');
			redirect("re/marketsurveyor/add");
		}
		
	}

	public function confirm()
	{
		if ( ! check_access('confirm_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/add');
			return;
		}


		$id=$this->market_surveyor_model->confirm($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Market Surveyor Successfully Confirmed ');
		$this->logger->write_message("error", $this->uri->segment(4).'  Market Surveyor successfully Confirmed');
		redirect("re/marketsurveyor/add");

	}

	public function delete()
	{
		if(! check_access('delete_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/add');
			return;
		}

		$id=$this->market_surveyor_model->delete($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Market Survey Successfully Deleted ');
		$this->logger->write_message("error", $this->uri->segment(4).' Market Survey Successfully Deleted ');
		redirect("re/marketsurveyor/add");

	}

	function comments()
	{

		
		$data=NULL;

		if ( ! check_access('view_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/add');
			return;
		}	
		
		$survey_id = $this->uri->segment(4);
		
		$data['market_servay_data'] = $this->market_surveyor_model->get_market_servay_by_code($survey_id);
		$land_code = $data['market_servay_data'][0]->land_code;		
		$data['project_details']=$this->market_surveyor_model->get_project_by_land_code($land_code);
		$data['land_details']=$this->land_model->get_land_bycode($land_code);
		$data['comments']=$this->market_surveyor_model->get_market_servay_comments($survey_id);
		

        $this->load->view('re/market_surveyor/comments',$data);		

	}

	function comment_action(){

		if ( ! check_access('view_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/market_surveyor/add');
			return;
		}
		$id=$this->market_surveyor_model->comment_add();
		redirect('re/market_surveyor/add');

	}

	
	public function print_report($survey_id){
		// echo("survey view");

		$data=NULL;
		if ( ! check_access('view_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/marketsurveyor/add');
			return;
		}		

		$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$data['market_servay_data'] = $this->market_surveyor_model->get_market_servay_by_code($survey_id);
		$land_code = $data['market_servay_data'][0]->land_code;		
		$data['project_details']=$this->market_surveyor_model->get_project_by_land_code($land_code);
		$data['land_details']=$this->land_model->get_land_bycode($land_code);
		$data['land_owner_details']=$this->land_model->get_land_owners($land_code);
		
        $this->load->view('re/market_surveyor/print_survey_report',$data);		
		 
	}
	
	function landinformationdata()
	{
			$data=NULL;
		if ( ! check_access('view_surveyor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}

		$data['details']=$this->land_model->get_land_bycode($this->uri->segment(4));
		$data['project_details']=$this->market_surveyor_model->get_project_by_land_code($this->uri->segment(4));
		$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$data['doctypes']=$this->document_model->get_document_bycategory('Projects');
		$this->common_model->add_activeflag('re_landms',$this->uri->segment(4),'land_code');
		$session = array('activtable'=>'re_landms');
		$this->session->set_userdata($session);

		
		// print("<pre>".print_r($data['project_details'],true)."</pre>");
		// exit;
		$this->load->view('re/market_surveyor/landinformationdata',$data);
		
	}
	
	
}
