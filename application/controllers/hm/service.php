<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {


	 function __construct() {
        parent::__construct();

		$this->load->model("hm_land_model");
		$this->load->model("common_model");
		$this->load->model("supplier_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_lotdata_model");
		$this->load->model("hm_subcontract_model");
		$this->load->model("hm_service_model");
		$this->load->model("hm_config_model");
		$this->load->model("cashadvance_model");

		$this->is_logged_in();

    }
 //full funtion list developed by udani
	public function index()
	{
		$data=NULL;
		if ( ! check_access('service_payment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/service/showall');
	}

	function showall()
	{
		$data=NULL;
		if ( ! check_access('service_payment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$data['services']=$services=$this->hm_config_model->get_services_all();
		$data['prjlist']=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['advlist']=$this->cashadvance_model->get_Paid_advancedata();
			

		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['datalist']=$datalist=$this->hm_service_model->service_paymetnlist($pagination_counter,$page_count);
		$unit_data=Null;
		
		$siteurl='hm/hm_service/showall';
		$tablename='hm_service_payments';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		$this->load->view('hm/service/service_main',$data);
	}

	function get_blocklist()
	{
		$data['prj_id']=$this->uri->segment(4);
		$data['lotlist']=$this->hm_lotdata_model->get_project_all_lots_byprjid_boq($this->uri->segment(4));//this will take only boq related lots
		$this->load->view('hm/service/blocklist',$data);

	}

	function get_category_list()
	{
		$data['lot_id']=$this->uri->segment(4);
			$data['category_data']=$this->hm_service_model->get_subcat_bylotid($this->uri->segment(4));
		$this->load->view('hm/service/categorylist',$data);
	}
	function add_servicepayment()
	{
		$id=$this->hm_service_model->add_service_payment();
 			if($id){
 				$this->session->set_flashdata('msg', 'Service Payments Successfully Inserted ');
 			}else {
				$this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

 			}
			redirect("hm/service/showall");
	}
	
	function delete()
	{
		$id=$this->hm_service_model->delete($this->uri->segment(4));
 			if($id){
 				$this->session->set_flashdata('msg', 'Service Payments Successfully Deleted ');
 			}else {
				$this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

 			}
			redirect("hm/service/showall");
	}

	function confirm()
	{
		$id=$this->hm_service_model->confirm($this->uri->segment(4));
 			if($id){
 				$this->session->set_flashdata('msg', 'Service Payments Successfully Deleted ');
 			}else {
				$this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

 			}
			redirect("hm/service/showall");
	}

	
}
