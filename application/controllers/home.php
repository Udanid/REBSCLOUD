<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
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
		$this->load->model("summery_model");
		$this->load->model("customer_model");
		//$this->is_logged_in();
		
    }
	public function index()
	{ redirect('user');
		
	}
	public function form()
	{
		/*$data['newordercount']=$this->order_model->new_order_count();
		$data['todayordercount']=$this->order_model->today_order_count();
		$data['totalorder']=$this->order_model->total_orders_count();
		$data['totalinvoice']=$this->order_model->new_invoice_count();
		$data['newcustomer']=$this->order_model->new_customer_count();
		$data['allcustomer']=$this->order_model->all_customer_count();*/
		$data=NULL;
		if ( ! check_access('forms'))
		{
			
			redirect('home');
			return;
		}
		
		$this->load->view('forms',$data);
		
	}
		public function tables()
	{
		/*$data['newordercount']=$this->order_model->new_order_count();
		$data['todayordercount']=$this->order_model->today_order_count();
		$data['totalorder']=$this->order_model->total_orders_count();
		$data['totalinvoice']=$this->order_model->new_invoice_count();
		$data['newcustomer']=$this->order_model->new_customer_count();
		$data['allcustomer']=$this->order_model->all_customer_count();*/
		$data=NULL;
		
		$this->load->view('tables',$data);
		
	}
	
	function is_logged_in() {

        $is_logged_in = $this->session->userdata('login_name');
        if ((!isset($is_logged_in) || $is_logged_in == "")) {
            redirect('login/index');
        }
		else
		{
			$this->session->set_flashdata('return_url', current_url());
		}
    }
	
	function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
	
	function customerByID($id){
		$customer = $this->customer_model->customerByID($id);
	
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */