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
		
		$this->load->model("reservationdiscount_model");
		$this->load->model("reservation_model");
		$this->load->model("common_model");
		$this->load->model("project_model");
		$this->load->model("salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
		$this->load->model("dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("eploan_model");
		$this->load->model("accountinterface_model");
		
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
		redirect('re/reservationdiscount/showall');
		
		
		
	}
	public function showall($page = '', $res_code = '')
	{
		$this->load->library("pagination");
		$data=NULL;
		if ( ! check_access('view_discountlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user/home');
			return;
		}
	
			$data['searchdata']=$inventory=$this->reservationdiscount_model->get_all_not_complete_reservation_summery($this->session->userdata('branchid'));
			//$data['datalist']=$inventory=$this->reservationdiscount_model->disocunt_list_paging($this->session->userdata('branchid'),$res_code,$pagination_counter,$page_count);
			$data['searchlist']="";
			$data['searchpath']='re/customer/search';
			$data['tag']='Search customer';
			//$data['banklist']=$this->common_model->getbanklist();
			$config = array();
			$config["base_url"] = base_url() . "re/reservationdiscount/showall";
			$config["total_rows"] = $total = $this->reservationdiscount_model->disocunt_list_all($this->session->userdata('branchid'),$res_code);
			$config["per_page"] = RAW_COUNT;
			$config["uri_segment"] = 4;
			$config['full_tag_open'] = '<ul id="pagination-flickr">';
			$config['full_close_open'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active">';
			$config['cur_tag_close'] = '</li>';
			$config['next_link'] = 'Next &#187;';
			$config['next_tag_open'] = '<li class="next">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&#171; Previous';
			$config['prev_tag_open'] = '<li class="previous">';
			$config['prev_tag_close'] = '</li>';
			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li class="first">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li class="last">';
			$config['last_tag_close'] = '</li>';
			$this->pagination->initialize($config);
	
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$data['page'] = $page;
			$data['datalist']=$inventory=$this->reservationdiscount_model->disocunt_list_paging($this->session->userdata('branchid'),$res_code,$config["per_page"],$page);
			//$data["links"] = $this->pagination->create_links();
			$this->load->view('re/reservationdiscount/reservation_list',$data);		
	}
	function get_details()
	{
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservationdiscount_model->get_all_reservation_details_bycode($res_code);
				$data['lotdata']=$resdata=$this->lotdata_model->get_project_lotdata_id($resdata->lot_id);
				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->reservation_model->get_purchase_type();
				$data['loan_officer']=$this->salesmen_model->get_project_officerlist($resdata->prj_id);
			
				$this->load->view('re/reservationdiscount/reservation_data',$data);
	}
	public function add()
	{
		if ( ! check_access('add_discount'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}		
		$id=$this->reservationdiscount_model->add();
		
		$this->common_model->add_notification('re_reservdicount','Reservation Discount','re/reservationdiscount',$id);
		$this->session->set_flashdata('msg', 'Land Resevation Discount Successfully Inserted ');
	//	$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/reservationdiscount/showall/");
		
	}
	public function delete()
	{
		if ( ! check_access('add_discount'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}		
		$id=$this->reservationdiscount_model->delete($this->uri->segment(4));
			$this->common_model->delete_notification('re_reservdicount',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Land Resevation Discount Successfully Deleted');
	// //	$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/reservationdiscount/showall/");
		
	}
	public function confirm()
	{
		if ( ! check_access('confirm_discount'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}		
		
		$id=$this->reservationdiscount_model->confirm($this->uri->segment(4));
		$this->common_model->delete_notification('re_reservdicount',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Land Resevation Discount Successfully Confirmed');
	//  $this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/reservationdiscount/showall/");
		
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */