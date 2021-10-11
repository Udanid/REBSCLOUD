<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends CI_Controller {

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
		
		$this->load->model("salesmen_model");
		$this->load->model("sales_model");
		$this->load->model("common_model");
		$this->load->model("branch_model");
		$this->load->model("project_model");
		$this->load->model("report_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home');
			return;
		}
		redirect('re/sales/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/sales/');
			return;
		}
	
				$data['searchlist']='';
				$data['searchpath']='re/salesmen/search';
				$data['tag']='Search salesmen';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['prjlist']=$this->sales_model->get_all_projectlist('ALL');
				$data['branchlist']=$this->branch_model->get_all_branches_summery();
				$siteurl='re/salesmen/showall';
				$tablename='re_salesman';
			//	$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('re/sales/sales_main',$data);
		
		
		
	}
	public function po()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/sales/');
			return;
		}
	
				$data['searchlist']='';
				$data['searchpath']='re/salesmen/search';
				$data['tag']='Search salesmen';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$siteurl='re/salesmen/showall';
				$tablename='re_salesman';
			//	$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('re/sales/po_main',$data);
		
		
		
		
	}
	function get_po()
	{
		$prj_id=$this->uri->segment(4);
		
		$details=$this->project_model->get_project_bycode($prj_id);
		
		$data['details']=$details;
		$data['officerlist']=$this->project_model->get_project_officer_list($this->session->userdata('branchid'));
				
		$this->load->view('re/sales/po_data',$data);
	}
	function edit_po()
	{
		$this->project_model->edit_po();
		$this->session->set_flashdata('msg', 'Project Officers Successfully Updated ');
		$this->logger->write_message("success",' Project Officers Successfully Updated');
		redirect("re/sales/po");
	}
	function get_target(){
		//$this->load->model("config_model");
		$prj_id=$this->uri->segment(4);
		$month=$this->uri->segment(5);
		$year=$this->uri->segment(6);
		$salselist=$this->sales_model->get_project_salespersonlist($prj_id);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->user_id]=$this->sales_model->get_month_target($prj_id,$month,$year,$raw->user_id);

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$this->load->view('re/sales/target_sheet',$data);
	
	}
	
	function get_target_po(){
		//$this->load->model("config_model");
		$month=$this->uri->segment(4);
		$year=$this->uri->segment(5);
		$branch=$this->uri->segment(6);
		$salselist=$this->sales_model->get_all_projectlist($branch);
		//echo 'sss'. $branch;
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->prj_id]=$this->sales_model->get_month_target($raw->prj_id,$month,$year,$raw->officer_code);
				// echo $month;

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$this->load->view('re/sales/target_sheet',$data);
	
	}
	public function add_target_po()
	{
		if ( ! check_access('add_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/salesmen/showall');
			return;
		}		
		$prj_id=$this->input->post('prj_id');
		$month=$this->input->post('month');
		$year=$this->input->post('year');	
		$branch=$this->input->post('branch_code');	
		$type=$this->input->post('type');	
		if($type=='01')
		{
			$salselist=$this->sales_model->get_all_projectlist($branch);
			//$this->sales_model->delete_target($prj_id,$month,$year);
			$monthtarget=NULL;
			if($salselist)
			{
				foreach($salselist as $raw)
				{if(check_pending_lots($raw->prj_id)){
					$this->sales_model->delete_target($raw->prj_id,$month,$year);
					  $target=str_replace(',', '', $this->input->post('target'.$raw->prj_id));
					   $blocks=str_replace(',', '', $this->input->post('blocks'.$raw->prj_id));
						$sales=str_replace(',', '', $this->input->post('sales'.$raw->prj_id));
						 $income=str_replace(',', '', $this->input->post('income'.$raw->prj_id));
					//cho $target;
					$this->sales_model->add_target($raw->prj_id,$month,$year,$raw->officer_code,$target,$blocks,$sales,$income);
				}
				} 
			}	
		}
		else
		{
			$salselist=$this->sales_model->get_sales_officerlist($branch);
		//echo 'sss'. $branch;
		$monthtarget=NULL;
			if($salselist)
			{
				foreach($salselist as $raw)
				{
						$sales=str_replace(',', '', $this->input->post('sales'.$raw->id));
						$block=str_replace(',', '', $this->input->post('block'.$raw->id));
						$this->sales_model->delete_officer_target($raw->id,$month,$year);
					//cho $target;
					$this->sales_model->add_officer_target($month,$year,$raw->id,$sales,$block);				// echo $month;
	
				} 
			}
		}
			$this->session->set_flashdata('msg', 'Monthly Sales Target Successfully Updated ');
			$this->logger->write_message("success",' Monthly Sales Target Successfully Updated');
			redirect("re/sales/showall");
	}
	
	public function add_target()
	{
		if ( ! check_access('add_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/salesmen/showall');
			return;
		}		
		$prj_id=$this->input->post('prj_id');
		$month=$this->input->post('month');
		$year=$this->input->post('year');	
		$salselist=$this->sales_model->get_project_salespersonlist($prj_id);
		$this->sales_model->delete_target($prj_id,$month,$year);
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $target=str_replace(',', '', $this->input->post('target'.$raw->user_id));
				   $blocks=str_replace(',', '', $this->input->post('blocks'.$raw->prj_id));
				    $sales=str_replace(',', '', $this->input->post('sales'.$raw->prj_id));
			
				// echo $target;
				$this->sales_model->add_target($prj_id,$month,$year,$raw->user_id,$target,$blocks,$sales);
			} 
		}	
		$this->session->set_flashdata('msg', 'Monthly Sales Target Successfully Updated ');
		$this->logger->write_message("success",' Monthly Sales Target Successfully Updated');
		redirect("re/sales/showall");
	}
	function get_forcast(){
		//$this->load->model("config_model");
		$prj_id=$this->uri->segment(4);
		$month=$this->uri->segment(5);
		$year=$this->uri->segment(6);
		$type=$this->uri->segment(7);
		$salselist=$this->sales_model->get_all_loan_details_type($prj_id,$type);
		$monthtarget=NULL;
		$monthtarget=NULL;
		$date=$year.'-'.$month.'-01';
		$arrears=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->loan_code]=$this->sales_model->get_month_forcast($prj_id,$month,$year,$raw->loan_code);
			  	 $paidtots[$raw->loan_code]=$this->report_model->loan_paid_amounts_befordate($raw->loan_code,$date,$raw->reschdue_sqn);
				 $arrears[$raw->loan_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$date,$raw->reschdue_sqn);

			  
			  
			} 
		}
		$data['arrears']=$arrears;
		$data['monthtarget']=$monthtarget;
		$data['paidtots']=$paidtots;
		$data['salselist']=$salselist;
		$this->load->view('re/sales/forcast_sheet',$data);
	
	}
	
	public function add_forcast()
	{
		if ( ! check_access('add_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/salesmen/showall');
			return;
		}		
		$prj_id=$this->input->post('prj_idf');
		$month=$this->input->post('monthf');
		$year=$this->input->post('yearf');
		$type=$this->input->post('loantypef');	
		$salselist=$this->sales_model->get_all_loan_details_type($prj_id,$type);
		
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				$this->sales_model->delete_forcast_new($prj_id,$month,$year,$raw->loan_code);
				 $collection=str_replace(',', '', $this->input->post('collection'.$raw->loan_code));
				 $Collection_date=$this->input->post('Collection_date'.$raw->loan_code);
					// echo $this->input->post('collection'.$raw->loan_code);
					// print_r($_POST);
				$this->sales_model->add_forcast($prj_id,$month,$year,$raw->loan_code,$collection,$Collection_date,$raw->collection_officer);
			} 
		}	
		$this->session->set_flashdata('msg', 'Monthly Collection Forcast Successfully Updated ');
		$this->logger->write_message("success",' Monthly Collection Forcast Successfully Updated');
		redirect("re/sales/showall");
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/salesmen/showall');
			return;
		}
		$id=$this->salesmen_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_salesman',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'salesmen Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  salesmen id successfully Confirmed');
		redirect("re/salesmen/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/salesmen/showall');
			return;
		}
		$id=$this->salesmen_model->delete($this->uri->segment(4));
		if($id)
		{
		$this->session->set_flashdata('msg', 'salesmen Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' salesmen id successfully Deleted');
		}
		else
			$this->session->set_flashdata('error', 'This Sales person already sold some blocks');
		redirect("re/salesmen/showall");
		
	}
		// added new function to odiliya modification
	function get_officer_sales(){
		//$this->load->model("config_model");
		$month=$this->uri->segment(4);
		$year=$this->uri->segment(5);
		$branch=$this->uri->segment(6);
		$salselist=$this->sales_model->get_sales_officerlist($branch);
		//echo 'sss'. $branch;
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->id]=$this->sales_model->get_month_officer_target($month,$year,$raw->id);
				// echo $month;

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$this->load->view('re/sales/officer_sheet',$data);
	
	}
	public function officer_report()
	{
		$data=NULL;
		
	
				$data['searchlist']='';
				$data['searchpath']='re/salesmen/search';
				$data['tag']='Search salesmen';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				//$data['prjlist']=$this->sales_model->get_all_projectlist('ALL');
				$data['branchlist']=$this->branch_model->get_all_branches_summery();
				$siteurl='re/salesmen/showall';
				$tablename='re_salesman';
			//	$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('re/sales/officer_report',$data);
		
		
		
	}
	function officer_report_data(){
		//$this->load->model("config_model");
		$branch=$this->uri->segment(6);
		
			$data['month']=$month=$this->uri->segment(4);

					
					$data['year']=$year=$this->uri->segment(5);
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
		$salselist=$this->sales_model->get_sales_officerlist($branch);
		//echo 'sss'. $branch;
		$monthtarget=NULL;
		if($salselist)
		{
			foreach($salselist as $raw)
			{
				 $monthtarget[$raw->id]=$this->sales_model->get_month_officer_target($month,$year,$raw->id);
				  $sales[$raw->id]=0;
				 if($monthtarget[$raw->id])
				 $sales[$raw->id]=$monthtarget[$raw->id]->sales;
				  $reslist[$raw->id]=$this->sales_model->get_tot_sale_reservationlist($raw->id,$stdate,$enddate);
				 
				// echo $month;

			} 
		}
		$data['monthtarget']=$monthtarget;
		$data['salselist']=$salselist;
		$data['reslist']=$reslist;
		$data['sales']=$sales;
		$this->load->view('re/sales/report_data',$data);
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */