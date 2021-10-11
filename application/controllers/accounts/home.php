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
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	function is_logged_in() {


		if($this->session->userdata('activtable')!=NULL)
		{
			$this->common_model->delete_curent_tabactivflag($this->session->userdata('activtable'));
		}
        $is_logged_in = $this->session->userdata('username');
		$is_usertype = $this->session->userdata('usertype');
        if ((!isset($is_logged_in) || $is_logged_in == "")) {
            $this->session->set_flashdata('return_url', current_url());
			$this->common_model->release_user_activeflag($this->session->userdata('userid'));
            redirect('login/index');
        }
		else if($is_usertype=="user")
		{
			$this->session->set_flashdata('return_url', current_url());
			  redirect('login/index');
		}
		else
		{
			$this->session->set_flashdata('return_url', current_url());
		}
    }
	public function index()
	{
		$data['searchlist']=NULL;
				$data['searchpath']='purchasing/search';
				$data['tag']='Search PO';
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
		$array=array("Jan","Feb","March","April","May","June","July");
		$array1=array("10","20","90","60","10","50","30");
		$js_array = json_encode($array);
		$data['js_months']=json_encode($array);//json_encode($this->summery_model->get_months());
		$data['js_cat1data']=json_encode($array1);//json_encode($this->summery_model->get_month_sales_category('CAT00001'));
		$data['js_cat2data']=json_encode($array1);//json_encode($this->summery_model->get_month_sales_category('CAT00002'));
		$data['js_chashsales']=json_encode($array1);//json_encode($this->summery_model->get_month_sales_cash('CAT00002'));
		$data['js_creditsales']=json_encode($array1);//json_encode($this->summery_model->get_month_sales_credit('CAT00002'));
		
		/*$data['todayordercount']=$this->order_model->today_order_count();
		$data['totalorder']=$this->order_model->total_orders_count();
		$data['totalinvoice']=$this->order_model->new_invoice_count();
		$data['newcustomer']=$this->order_model->new_customer_count();
		$data['allcustomer']=$this->order_model->all_customer_count();*/
		//$data=NULL;
		//print_r($data['js_creditsales']);
		$this->load->view('admin/home',$data);
		
	}
	public function branch_details()
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
		
		$this->load->view('admin/branch/branch_data',$data);
		
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