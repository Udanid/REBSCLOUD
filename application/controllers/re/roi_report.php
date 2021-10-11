<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roi_report extends CI_Controller {

	/**
	 * Index Page for this controller.land
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


		$this->load->model("common_model");

		$this->load->model("project_model");
	    $this->load->model("lotdata_model");
		$this->load->model("salesmen_model");
		$this->load->model("sales_model");
		$this->load->model("branch_model");
		$this->load->model("reservation_model");
		$this->load->model("eploan_model");
		$this->load->model("report_model");
		$this->load->model("summery_model");
		$this->load->model("customer_model");
		$this->load->model("redashboard_model");
		$this->load->model("roi_model");
		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/home');
			return;
		}
		redirect('re/project/showall');



	}
	
	// Start Profit Report**************************************************************************************************************
	public function roi()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();

		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/roi/roi',$data);



	}
	
	function roi_data()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/roi_report/roi/');
			return;
		}
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['todate']=$todate=$this->uri->segment(5);
		$data['details']=$this->project_model->get_project_bycode($prj_id)	;
		$data['sale']=$this->roi_model->get_reservation_sale_cost($prj_id,$todate)	;
		$data['epincome']=$this->roi_model->interest_income($prj_id,$todate);
		$data['intpay']=$this->roi_model->get_external_loan_payment($prj_id,$todate);
		$data['budgetbal']=$this->roi_model->budget_balance($prj_id,$todate);

		$this->load->view('re/roi/roi_report',$data);
	}
	

	}







/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
