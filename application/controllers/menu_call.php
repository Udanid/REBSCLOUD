<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_call extends CI_Controller {

	 function __construct() {
        parent::__construct();
			$this->load->model("common_model");
			$this->load->model("summery_model");
		$this->load->model("customer_model");
		$this->load->model("redashboard_model");
		$this->load->model("projectpayment_model");
		$this->load->model("report_model");
		$this->load->model("wip/Tasknotification_model");
		$this->load->model("wip/Project_model");
		$this->load->model("user/user_model");
		//$this->is_logged_in();
		
    }
	public function index()
	{
		$data=NULL;
		  $session = array('usermodule'=>$this->uri->segment(3));
		    $this->session->set_userdata($session);
		// redirect(base_url()."user");
		
	}
	public function showdata()
	{
		$data=NULL;
		//echo $this->uri->segment(3);
		  $session = array('usermodule'=>$this->uri->segment(3));
		    $this->session->set_userdata($session);
			//echo $this->uri->segment(3);
			// echo $this->session->userdata('usermodule');
			$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->projectpayment_model->get_all_payto_projectlist($this->session->userdata('branchid'));
		$maxid=$this->projectpayment_model->get_all_max_project($this->session->userdata('branchid'));
		$prjidlist="";
		$year=date('Y');
		$month=date('m');
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					$currentweek=intval(date('d'))/7;//+1;
					$currentweek=intval($currentweek)+1;
					//echo $currentweek;
				$currentproject=$maxid;
				$prjlist=$this->redashboard_model->get_user_prjlist();
				if($prjlist)
				{
					foreach($prjlist as $prjraw)
					{
						 $lebal[$counter]=$prjraw->project_name;
					$target[$prjraw->prj_id]=$this->report_model->get_month_target($prjraw->prj_id,$month,$year,$prjraw->officer_code);
					$totadvance[$prjraw->prj_id]=$this->report_model->get_month_advance($prjraw->prj_id,$stdate,$enddate);
					$totcapital[$prjraw->prj_id]=$this->report_model->get_month_capital($prjraw->prj_id,$stdate,$enddate);
					  $estimate[$counter]=$this->report_model->get_month_target($prjraw->prj_id,$month,$year,$prjraw->officer_code);
					 $profitlist[$prjraw->prj_id]=$this->redashboard_model->get_profittransfer_data_period($prjraw->prj_id,$stdate,$enddate);
					  if($totadvance[$prjraw->prj_id])
					   $actual[$counter]= $totadvance[$prjraw->prj_id]->tot;
					   else   $actual[$counter]=0;
					   if($totcapital[$prjraw->prj_id])
					   {
						   $actual[$counter]= $actual[$counter]+$totcapital[$prjraw->prj_id]->captot+$totcapital[$prjraw->prj_id]->inttot;
					   }
					   if($estimate[$counter] > $actual[$counter])
					    $color[$counter]= 'rgb(255, 46, 65)';
						else
						 $color[$counter]= 'rgb(255, 159, 64)';
				$counter++;
				}
			}
			
			
			if($prjlist){
				$data['js_label']=json_encode($lebal);
				$data['js_estimate']=json_encode($estimate);
				$data['js_actual']=json_encode($actual);
				$data['js_colors']=json_encode($color);
					$data['profitlist']=$profitlist;
			}
		$array=array("Jan","Feb","March","April","May","June","July","Jan","Feb","March","April","May","June","July");
		$array1=array("10","20","90","60","10","50","30");
		$js_array = json_encode($array);
		$data['prjlist']=$prjlist;


		// WIP notifications

		$userid = $this->session->userdata('userid');

		$data['get_all_notification_count']=$get_all_notification_count = $this->Tasknotification_model->get_all_notification_count($userid);

		$data['get_task_count']=$get_task_count = $this->Tasknotification_model->get_task_notification_count($userid);

	  $data['get_subtask_count']=$get_subtask_count = $this->Tasknotification_model->get_sub_task_notification_count($userid);

	  $data['get_complted_task_notification_count']=$get_complted_task_notification_count=$this->Tasknotification_model->get_complted_task_notification_count($userid);

	  $data['get_task_notification']=$get_task_notification = $this->Tasknotification_model->get_task_notification($userid);

	  $data['get_subtask_notification']=$get_subtask_notification = $this->Tasknotification_model->get_sub_task_notification($userid);

	  $data['get_task_completed_notification']=$get_task_completed_notification = $this->Tasknotification_model->get_task_completed_notification($userid);

	  $data['get_task_extend_notification']=$get_task_extend_notification = $this->Tasknotification_model->get_task_extend_notification($userid);

	  $data['get_main_task_extend_notification']=$get_main_task_extend_notification = $this->Tasknotification_model->get_main_task_extend_notification($userid);

	  $data['get_sub_task_completed_notification']=$get_sub_task_completed_notification = $this->Tasknotification_model->get_sub_task_completed_notification($userid);

	  $data['get_sub_task_extend_accept_notification']=$get_sub_task_extend_accept_notification = $this->Tasknotification_model->get_sub_task_extend_accept_notification($userid);

	  $data['get_main_task_extend_accept_notification']=$get_main_task_extend_accept_notification = $this->Tasknotification_model->get_main_task_extend_accept_notification($userid);

	  $data['get_sub_task_prograss_update_notification']=$get_sub_task_prograss_update_notification = $this->Tasknotification_model->get_sub_task_prograss_update_notification($userid);

	  $data['accepted_task_notification_view_task_createor']=$accepted_task_notification_view_task_createor = $this->Tasknotification_model->accepted_task_notification_view_task_createor($userid);

	  $data['get_sub_task_accepted_notification__task_assigner']=$get_sub_task_accepted_notification__task_assigner = $this->Tasknotification_model->get_sub_task_accepted_notification__task_assigner($userid);

	  $data['get_sub_task_extention_reject_notification']=$get_sub_task_extention_reject_notification = $this->Tasknotification_model->get_sub_task_extention_reject_notification($userid);

	  $data['get_main_task_extention_reject_notification']=$get_main_task_extention_reject_notification = $this->Tasknotification_model->get_main_task_extention_reject_notification($userid);	

	  // end WIP Notification section
		if($this->uri->segment(3) == 'wip'){
			$data['task_projects'] = $this->Project_model->get_user_projects($userid);
			$this->load->view('wip/dashboard',$data);
		}else{	
			$this->load->view('user/home_view',$data);
		}
				
	}	
}