<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_report extends CI_Controller {

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

		$this->load->model("loan_report_model");
    $this->load->model("report_model");
    $this->load->model("branch_model");
		$this->load->model("project_model");
		$this->load->model("common_model");

		$this->is_logged_in();

    }

    function index()
    {
      $lebal=NULL;
      $estimate=NULL;
      $actual=NULL;
      $color=NULL;
      $counter=0;
       $data['branchlist']=$this->branch_model->get_all_branches_summery();
       $data['searchpath']='re/lotdata/search';
   		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
   					$this->load->view('re/loan_report/loan_report_main',$data);

    }


    function get_branch_projectlist()
    {

      $branchid=$this->uri->segment(4);
      $data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
      $this->load->view('re/loan_report/project_list',$data);

    }
		function get_projectlots()
		{
			$prjid=$this->uri->segment(4);
      $data['lotlist']=$prjlist=$this->loan_report_model->get_project_loan_lots($prjid);
      $this->load->view('re/loan_report/blocklist',$data);
		}

    function report_data()
    {
      $projectid=$this->uri->segment(4);
			$data['reportdata']=$date=$this->uri->segment(5);
			$data['lot_id']=$lot_id=$this->uri->segment(6);
			$data['details']=$this->project_model->get_project_bycode($projectid)	;
      $data['report_data']=$loanlist=$this->loan_report_model->get_loan_list($projectid,$date,$lot_id);
			$paid_data=Null;
			$unrelized_data=Null;
			$unrelized_sales=Null;
			$unrelized_costs=Null;
			
			if($loanlist)
			{
				foreach ($loanlist as $key => $value) {
					$paid_data[$value->loan_code]=$this->loan_report_model->get_loan_payment_data($value->loan_code,$date);
					$unrelized_data[$value->loan_code]=$unrelized_datas=$this->loan_report_model->get_loan_unrelized_data($value->res_code,$date);
					$nonerefund[$value->loan_code]=$this->loan_report_model->get_nonrefund_amount($value->loan_code,$date);
					
					$resheduledata[$value->loan_code]=$this->loan_report_model->get_reshedule_data($value->loan_code,$date);
					$earlysettle[$value->loan_code]=$this->loan_report_model->get_loan_settleddata($value->loan_code,$date);
					
					//echo $value->loan_code.'<br>';
					
					
						$unrelized_sale[$value->loan_code]='0';
						$unrelized_cost[$value->loan_code]='0';
					if($value->loan_status=="SETTLED" && $unrelized_datas->status=="COMPLETE")
					{
							$unrelized_sales[$value->loan_code]=0;
						$unrelized_costs[$value->loan_code]=0;
					}else{
						$unrelized_sales[$value->loan_code]=$unrelized_datas->unrealized_sale;
						$unrelized_costs[$value->loan_code]=$unrelized_datas->unrealized_cost;
					}
				
				}
			}
			$data['nonerefund']=$nonerefund;
			$data['resheduledata']=$resheduledata;
			$data['earlysettle']=$earlysettle;
			$data['unrelized_sale']=$unrelized_sales;
			$data['unrelized_cost']=$unrelized_costs;
			$data['paid_data']=$paid_data;
      $this->load->view('re/loan_report/loan_reportdata_prj',$data);
    }

		function report_data_all_projects()
    {
			$branchid=$this->uri->segment(5);
			$data['reportdata']=$date=$this->uri->segment(4);
			if($branchid==""){
				$branchid=$this->session->userdata('branchid');
			}
			$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);

			$paid_data=Null;
			$unrelized_data=Null;
			$unrelized_sales=Null;
			$unrelized_costs=Null;
			$details=Null;
			$report_data=Null;
			$lot_id="";
			if($prjlist){
				foreach ($prjlist as $key => $branchval) {
				$projectid=$branchval->prj_id;
				$details[$projectid]=$this->project_model->get_project_bycode($projectid)	;
				$report_data[$projectid]=$loanlist=$this->loan_report_model->get_loan_list($projectid,$date,$lot_id);

				if($loanlist)
				{
					foreach ($loanlist as $key => $value) {
						$paid_data[$value->loan_code]=$this->loan_report_model->get_loan_payment_data($value->loan_code,$date);
						
						$resheduledata[$value->loan_code]=$this->loan_report_model->get_reshedule_data($value->loan_code,$date);
						$earlysettle[$value->loan_code]=$this->loan_report_model->get_loan_settleddata($value->loan_code,$date);
						$nonerefund[$value->loan_code]=$this->loan_report_model->get_nonrefund_amount($value->loan_code,$date);
					
						$unrelized_data[$value->loan_code]=$unrelized_datas=$this->loan_report_model->get_loan_unrelized_data($value->res_code,$date);
						$unrelized_sale[$value->loan_code]=0;
						$unrelized_cost[$value->loan_code]=0;
						if($value->loan_status=="SETTLED" && $unrelized_datas->status=="COMPLETE")
						{
							$unrelized_sales[$value->loan_code]=0;
							$unrelized_costs[$value->loan_code]=0;
						}else{
							$unrelized_sales[$value->loan_code]=$unrelized_datas->unrealized_sale;
							$unrelized_costs[$value->loan_code]=$unrelized_datas->unrealized_cost;
							//echo $unrelized_costs[$value->loan_code];
						}
					}
				}
				}
			}

			//print_r($unrelized_sales);
			$data['nonerefund']=$nonerefund;
			$data['earlysettle']=$earlysettle;
			$data['details']=$details;
			$data['resheduledata']=$resheduledata;
			$data['report_data']=$report_data;
			$data['unrelized_sale']=$unrelized_sales;
			$data['unrelized_cost']=$unrelized_costs;
			$data['paid_data']=$paid_data;
      $this->load->view('re/loan_report/loan_reportdata_all',$data);
    }

  }
