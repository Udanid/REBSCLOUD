<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservationdiscount extends CI_Controller {

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
		
		$this->load->model("hm_reservationdiscount_model");
		$this->load->model("hm_reservation_model");
		$this->load->model("common_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("hm_lotdata_model");
		$this->load->model("hm_dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("hm_eploan_model");
		$this->load->model("hm_accountinterface_model");
			
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_discountlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user/home');
			return;
		}
		redirect('hm/reservationdiscount/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_discountlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user/home');
			return;
		}
		
				$data['searchdata']=$inventory=$this->hm_reservationdiscount_model->get_all_not_complete_reservation_summery($this->session->userdata('branchid'));
				$data['datalist']=$inventory=$this->hm_reservationdiscount_model->disocunt_list($this->session->userdata('branchid'));
				$data['searchlist']="";
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				//$data['banklist']=$this->common_model->getbanklist();
			
				
					
				$this->load->view('hm/reservationdiscount/reservation_list',$data);
		
		
	}
	function get_details()
	{
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservationdiscount_model->get_all_reservation_details_bycode($res_code);
				$data['lotdata']=$resdata=$this->hm_lotdata_model->get_project_lotdata_id($resdata->lot_id);
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->hm_reservation_model->get_purchase_type();
				$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
			
				$this->load->view('hm/reservationdiscount/reservation_data',$data);
	}
	public function add()
	{
		if ( ! check_access('add_discount'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}		
		$id=$this->hm_reservationdiscount_model->add();
		
		$this->common_model->add_notification('hm_reservdicount','Reservation Discount','hm/reservationdiscount',$id);
		$this->session->set_flashdata('msg', 'Land Resevation Discount Successfully Inserted ');
	//	$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("hm/reservationdiscount/showall/");
		
	}
	public function delete()
	{
		if ( ! check_access('add_discount'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}		
		$id=$this->hm_reservationdiscount_model->delete($this->uri->segment(4));
			$this->common_model->delete_notification('hm_reservdicount',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Land Resevation Discount Successfully Deleted');
	// //	$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("hm/reservationdiscount/showall/");
		
	}
	public function confirm()
	{
		if ( ! check_access('confirm_discount'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}		
		
		$id=$this->hm_reservationdiscount_model->confirm($this->uri->segment(4));
		$this->common_model->delete_notification('hm_reservdicount',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Land Resevation Discount Successfully Confirmed');
	//  $this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("hm/reservationdiscount/showall/");
		
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */