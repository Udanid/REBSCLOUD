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
		$this->load->model("hm_redashboard_model");
		$this->load->model("hm_projectpayment_model");
		//$this->is_logged_in();
		
    }
	public function index()
	{
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		$data['searchpath']='hm/lotdata/search';
		$data['prjlist']=$prjlist=$this->hm_projectpayment_model->get_all_payto_projectlist($this->session->userdata('branchid'));
		$maxid=$this->hm_projectpayment_model->get_all_max_project($this->session->userdata('branchid'));
		$prjidlist="";
		$currentproject=$maxid;
				$outflolist=$this->hm_projectpayment_model->get_project_paymeny_task($currentproject);
				if($outflolist){
					foreach($outflolist as $row)
					{
					  if($row->new_budget>0 & $row->task_name!='Purchase Price'){
					  $lebal[$counter]=substr( $row->task_name,0,4);
					  $estimate[$counter]=$row->estimate_budget;
					  $actual[$counter]= $row->tot_payments;
					  $budget[$counter]= $row->new_budget;
					  if($row->estimate_budget> $row->tot_payments)
					  $color[$counter]= 'rgb(126, 213, 84)';
					  else if($row->estimate_budget== $row->tot_payments)
						  $color[$counter]= 'rgb(255, 159, 64)';
					  else
					  $color[$counter]= 'rgb(255, 46, 65)';
					  $counter++;
				  	}
				
				  }
				  
				$js_label[$currentproject]=json_encode($lebal);
				$js_estimate[$currentproject]=json_encode($estimate);
				$js_actual[$currentproject]=json_encode($actual);
				$js_colors[$currentproject]=json_encode($color);
				$js_budget[$currentproject]=json_encode($budget);
			}
			if($outflolist){
				$data['js_label']=$js_label;
				$data['js_estimate']=$js_estimate;
				$data['js_actual']=$js_actual;
				$data['js_colors']=$js_colors;
				$data['js_budget']=$js_budget;}
		$array=array("Jan","Feb","March","April","May","June","July","Jan","Feb","March","April","May","June","July");
		$array1=array("10","20","90","60","10","50","30");
		$js_array = json_encode($array);
		$data['prjidlist']=$prjidlist;
		$data['currentproject']=$currentproject;
		$data['js_creditsales']=json_encode($array1);//json_encode($this->summery_model->get_month_sales_credit('CAT00002'));
		
		$data['ongingprojects']=$this->hm_redashboard_model->ongoing_projects($this->session->userdata('branchid'));
		$data['outflow']=$this->hm_redashboard_model->today_payments($this->session->userdata('shortcode'));
		$data['inflow']=$this->hm_redashboard_model->today_income($this->session->userdata('branchid'));
		
		/*$data['totalinvoice']=$this->order_model->new_invoice_count();
		$data['newcustomer']=$this->order_model->new_customer_count();
		$data['allcustomer']=$this->order_model->all_customer_count();*/
		//$data=NULL;
		//print_r($data['js_creditsales']);
		$this->load->view('hm/home',$data);
		
	}
	public function mychart()
	{
		$counter=0;
				
				$outflolist=$this->hm_projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
				
				if($outflolist){
					foreach($outflolist as $row)
					{
					  if($row->new_budget>0 & $row->task_name!='Purchase Price'){
					//	  echo $row->task_name.'-'. $row->new_budget,'**';
					  $lebal[$counter]=substr( $row->task_name,0,4);
					  $estimate[$counter]=$row->estimate_budget;
					  $actual[$counter]= $row->tot_payments;
					    $budget[$counter]= $row->new_budget;
					  if($row->estimate_budget> $row->tot_payments)
					  $color[$counter]= 'rgb(126, 213, 84)';
					  else if($row->estimate_budget== $row->tot_payments)
						  $color[$counter]= 'rgb(255, 159, 64)';
					  else
					  $color[$counter]= 'rgb(255, 46, 65)';
					  $counter++;
				  	}
				
				  }
				  
				$data['js_label']=json_encode($lebal);
				$data['js_estimate']=json_encode($estimate);
				$data['js_actual']=json_encode($actual);
				$data['js_colors']=json_encode($color);
				$data['js_budget']=json_encode($budget);
			}
			$this->load->view('hm/mychart',$data);
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