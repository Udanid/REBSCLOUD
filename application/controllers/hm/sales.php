<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends CI_Controller {

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
		
		$this->load->model("hm_salesmen_model");
		$this->load->model("hm_sales_model");
		$this->load->model("common_model");
		$this->load->model("hm_project_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home');
			return;
		}
		redirect('hm/sales/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/sales/');
			return;
		}
	
				$data['searchlist']='';
				$data['searchpath']='hm/salesmen/search';
				$data['tag']='Search salesmen';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['prjlist']=$this->hm_sales_model->get_officer_projectlist($this->session->userdata('userid'));
				$siteurl='hm/salesmen/showall';
				$tablename='hm_salesman';
			//	$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/sales/sales_main',$data);
		
		
		
	}
	public function po()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/sales/');
			return;
		}
	
				$data['searchlist']='';
				$data['searchpath']='hm/salesmen/search';
				$data['tag']='Search salesmen';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['prjlist']=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));
				$siteurl='hm/salesmen/showall';
				$tablename='hm_salesman';
			//	$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/sales/po_main',$data);
		
		
		
		
	}
	function get_po()
	{
		$prj_id=$this->uri->segment(4);
		
		$details=$this->hm_project_model->get_project_bycode($prj_id);
		
		$data['details']=$details;
		$data['officerlist']=$this->hm_project_model->get_project_officer_list($this->session->userdata('branchid'));
				
		$this->load->view('hm/sales/po_data',$data);
	}
	function edit_po()
	{
		$this->hm_project_model->edit_po();
		$this->session->set_flashdata('msg', 'Project Officers Successfully Updated ');
		$this->logger->write_message("success",' Project Officers Successfully Updated');
		redirect("hm/sales/po");
	}
	function get_target(){
		//$this->load->model("config_model");
		$prj_id=$this->uri->segment(4);
		$month=$this->uri->segment(5);
		$year=$this->uri->segment(6);
		$salselist=$this->hm_sales_model->get_project_salespersonlist($prj_id);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->user_id]=$this->hm_sales_model->get_month_target($prj_id,$month,$year,$raw->user_id);

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$this->load->view('hm/sales/target_sheet',$data);
	
	}
	
	function get_target_po(){
		//$this->load->model("config_model");
		$month=$this->uri->segment(4);
		$year=$this->uri->segment(5);
		$salselist=$this->hm_sales_model->get_all_projectlist($this->session->userdata('branchid'));
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->prj_id]=$this->hm_sales_model->get_month_target($raw->prj_id,$month,$year,$raw->officer_code);
				// echo $month;

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$this->load->view('hm/sales/target_sheet',$data);
	
	}
	public function add_target_po()
	{
		if ( ! check_access('add_target'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}		
		$prj_id=$this->input->post('prj_id');
		$month=$this->input->post('month');
		$year=$this->input->post('year');	
		$salselist=$this->hm_sales_model->get_all_projectlist($this->session->userdata('branchid'));
		//$this->hm_sales_model->delete_target($prj_id,$month,$year);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				$this->hm_sales_model->delete_target($raw->prj_id,$month,$year);
				  $target=str_replace(',', '', $this->input->post('target'.$raw->prj_id));
				//cho $target;
				$this->hm_sales_model->add_target($raw->prj_id,$month,$year,$raw->officer_code,$target);
			} 
		}	
		$this->session->set_flashdata('msg', 'Monthly Sales Target Successfully Updated ');
		$this->logger->write_message("success",' Monthly Sales Target Successfully Updated');
		redirect("hm/sales/showall");
	}
	
	public function add_target()
	{
		if ( ! check_access('add_target'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}		
		$prj_id=$this->input->post('prj_id');
		$month=$this->input->post('month');
		$year=$this->input->post('year');	
		$salselist=$this->hm_sales_model->get_project_salespersonlist($prj_id);
		$this->hm_sales_model->delete_target($prj_id,$month,$year);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $target=str_replace(',', '', $this->input->post('target'.$raw->user_id));
				// echo $target;
				$this->hm_sales_model->add_target($prj_id,$month,$year,$raw->user_id,$target);
			} 
		}	
		$this->session->set_flashdata('msg', 'Monthly Sales Target Successfully Updated ');
		$this->logger->write_message("success",' Monthly Sales Target Successfully Updated');
		redirect("hm/sales/showall");
	}
	function get_forcast(){
		//$this->load->model("config_model");
		$prj_id=$this->uri->segment(4);
		$month=$this->uri->segment(5);
		$year=$this->uri->segment(6);
		$salselist=$this->hm_sales_model->get_all_reservation_details($prj_id);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->res_code]=$this->hm_sales_model->get_month_forcast($prj_id,$month,$year,$raw->res_code);

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$this->load->view('hm/sales/forcast_sheet',$data);
	
	}
	
	public function add_forcast()
	{
		if ( ! check_access('add_target'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}		
		$prj_id=$this->input->post('prj_idf');
		$month=$this->input->post('monthf');
		$year=$this->input->post('yearf');	
		$salselist=$this->hm_sales_model->get_all_reservation_details($prj_id);
		$this->hm_sales_model->delete_forcast($prj_id,$month,$year);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $week1=str_replace(',', '', $this->input->post('week1'.$raw->res_code));
				 $week2=str_replace(',', '', $this->input->post('week2'.$raw->res_code));
				 $week3=str_replace(',', '', $this->input->post('week3'.$raw->res_code));
				 $week4=str_replace(',', '', $this->input->post('week4'.$raw->res_code));
				 $week5=str_replace(',', '', $this->input->post('week5'.$raw->res_code));
				// echo  $week1;
				$this->hm_sales_model->add_forcast($prj_id,$month,$year,$raw->res_code,$week1,$week2,$week3,$week4,$week5,$raw->sales_person);
			} 
		}	
		$this->session->set_flashdata('msg', 'Monthly Sales Forcast Successfully Updated ');
		$this->logger->write_message("success",' Monthly Sales Forcast Successfully Updated');
		redirect("hm/sales/showall");
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}
		$id=$this->hm_salesmen_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_salesman',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'salesmen Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  salesmen id successfully Confirmed');
		redirect("hm/salesmen/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}
		$id=$this->hm_salesmen_model->delete($this->uri->segment(4));
		if($id)
		{
		$this->session->set_flashdata('msg', 'salesmen Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' salesmen id successfully Deleted');
		}
		else
			$this->session->set_flashdata('error', 'This Sales person already sold some blocks');
		redirect("hm/salesmen/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */