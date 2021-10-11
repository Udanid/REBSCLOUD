<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hm_subcontract extends CI_Controller {


	 function __construct() {
        parent::__construct();

		$this->load->model("hm_land_model");
		$this->load->model("common_model");
		$this->load->model("supplier_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_lotdata_model");
		$this->load->model("hm_subcontract_model");
		$this->load->model("hm_config_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('subcontract'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/hm_subcontract/showall');
	}

/*2020-01-13 create by nadee */
	function showall()
	{
		$data=NULL;
		if ( ! check_access('subcontract'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$data['services']=$services=$this->hm_config_model->get_services_all();
		$data['prjlist']=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));

		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['datalist']=$datalist=$this->hm_subcontract_model->get_subcontractdata($pagination_counter,$page_count);
		$unit_data=Null;
		if($datalist){
			foreach ($datalist as $key => $value) {
				$unit_data[$value->contract_id]=$lotdata=$this->hm_subcontract_model->get_subcontract_lotdata($value->contract_id);
			}
		}
		$data['unit_data']=$unit_data;
		$siteurl='hm/hm_subcontract/showall';
		$tablename='hm_subcontractmain';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		$this->load->view('hm/subcontract/subcontract_main',$data);
	}

	/*dev Nadee*/
	function get_blocklist()
	{
		/*main view in subcontract_main view*/
		$data['prj_id']=$this->uri->segment(4);
		$data['new_lotview']=$this->uri->segment(5);//get only for view perpose
		$data['lotlist']=$this->hm_lotdata_model->get_project_all_lots_byprjid_boq($this->uri->segment(4));
		$this->load->view('hm/subcontract/blocklist',$data);

	}

	/*dev Nadee*/
	function get_category_list()
	{
		/*main view in subcontract_main view*/
		$data['lot_id']=$this->uri->segment(4);
		$data['new_lotview']=$this->uri->segment(5);//get only for view perpose
		$data['new_subcatview']=$this->uri->segment(6);//get only for view perpose
		$data['category_data']=$this->hm_subcontract_model->get_subcat_bylotid($this->uri->segment(4));
		$this->load->view('hm/subcontract/categorylist',$data);
	}

	/*dev Nadee*/
	function get_task_list_bysubcat()
	{
		/*main view in subcontract_main view*/
		$data['lot_id']=$this->uri->segment(4);
		$data['new_lotview']=$this->uri->segment(5);//get only for view perpose
		$data['new_subcatview']=$this->uri->segment(6);//get only for view perpose
		$data['category_data']=$this->hm_subcontract_model->get_subcat_bylotid($this->uri->segment(4));
		$this->load->view('hm/subcontract/categorylist',$data);
	}

	function get_task_list()
	{
		/*main view in subcontract_main view*/
		$data['subcat_id']=$this->uri->segment(4);
		$data['new_lotview']=$this->uri->segment(5);//get only for view perpose
		$data['new_subcatview']=$this->uri->segment(6);//get only for view perpose
		$data['lot_id']=$this->uri->segment(7);
		$data['task_list']=$this->hm_subcontract_model->get_task_bysubcat($this->uri->segment(4),$this->uri->segment(7));
		$this->load->view('hm/subcontract/task_table',$data);
	}

	/*dev nadee*/
	function add_subcontract()
	{
		if($this->input->post('agreed_amount')<=0){
      $this->db->trans_rollback();
      $this->session->set_flashdata('error','Please Add Value Contracts.' );

    }else{
			$suplier_data=$this->supplier_model->get_supplier_bycode($this->input->post('supplier_id'));

			$id=$this->hm_subcontract_model->add_subcontract($suplier_data);
			if($id){
				$this->session->set_flashdata('msg', 'Sub Contracts Successfully Inserted ');
				$this->logger->write_message("success", 'Sub Contracts successfully Inserted');
			}
		}

		redirect("hm/hm_subcontract/showall");
	}

	/*dev nadee*/
	function view_task_data()
	{
		$data['contract_id']=$contract_id=$this->uri->segment(4);
		$data['lot_id']=$lot_id=$this->uri->segment(5);
		$data['contractdata_id']=$contractdata_id=$this->uri->segment(6);
		$data['task_data']=$this->hm_subcontract_model->get_task_bycontract($contractdata_id);
		$this->load->view('hm/subcontract/contract_data',$data);

	}

	/*dev nadee*/
	function payment_view()
	{
		$data=NULL;
		if ( ! check_access('subcontract_payment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['services']=$services=$this->hm_config_model->get_services_all();
		$data['prjlist']=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));

		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['datalist']=$datalist=$this->hm_subcontract_model->get_subcontract_payment($pagination_counter,$page_count);

		$siteurl='hm/hm_subcontract/showall';
		$tablename='hm_subcontractmain';
		$data['tab']='';

		if($page_count){
			$data['tab']='list';
		}

		$this->pagination($page_count,$siteurl,$tablename);

		$this->load->view('hm/subcontract/payment_view',$data);
	}

	/*dev nadee*/
	 function get_contractsuppliers()
	 {
		 $data['prj_id']=$prj_id=$this->uri->segment(4);
 		 $data['service_id']=$service_id=$this->uri->segment(5);
		 $data['subcontract_list']=$subcontract_list=$this->hm_subcontract_model->get_subcontrac_supliers($prj_id,$service_id);

		 $this->load->view('hm/subcontract/subcontract_list',$data);
	 }

	 /*dev nadee*/
	 function add_subcontract_payment()
	 {

 			$id=$this->hm_subcontract_model->add_subcontract_payment();
 			if($id){
 				$this->session->set_flashdata('msg', 'Sub Contracts Successfully Inserted ');
 				$this->logger->write_message("success", 'Sub Contracts successfully Inserted');
 			}else {
				$this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

 			}
			redirect("hm/hm_subcontract/payment_view");
	 }

	 /*dev nadee*/
	 function confirm_subcontract_payment($id)
	 {
		 //$suplier_data=$this->supplier_model->get_supplier_bycode($this->input->post('supplier_id'));
		 $id=$this->hm_subcontract_model->confirm_subcontract_payment($id);
		 if($id){
			 $this->session->set_flashdata('msg', 'Sub Contracts Successfully Confirmed ');
			 $this->logger->write_message("success", 'Sub Contracts successfully Confirmed');
		 }else {
			 $this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

		 }
		 redirect("hm/hm_subcontract/payment_view");
	 }

	 /*dev nadee*/
	 function delete_subcontract_payment($id)
	 {
		 $id=$this->hm_subcontract_model->delete_subcontract_payment($id);
		 if($id){
			 $this->session->set_flashdata('msg', 'Sub Contracts Successfully Deleted ');
			 $this->logger->write_message("success", 'Sub Contracts successfully Deleted');
		 }else {
			 $this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

		 }
		 redirect("hm/hm_subcontract/payment_view");
	 }

	 function edit_subcontract_payment($id)
	 {
		 $data['pay_data']=$pay_data=$this->hm_subcontract_model->get_subcontract_payment_bypayid($id);

		$this->load->view('hm/subcontract/payment_edit',$data);
	 }

	 /*dev nadee*/
	function update_subcontract_payment()
	{
		$id=$this->hm_subcontract_model->update_subcontract_payment();
		if($id){
			$this->session->set_flashdata('msg', 'Sub Contracts Successfully Updated ');
			$this->logger->write_message("success", 'Sub Contracts successfully Updated');
		}else {
			$this->logger->write_message("error", 'Something went wrong ..! Please Try Again');

		}
		redirect("hm/hm_subcontract/payment_view");
	}
}
