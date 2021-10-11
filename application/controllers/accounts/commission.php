<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commission extends CI_Controller {

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
		
		$this->load->model("commission_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("project_model");
		$this->load->model("projectpayment_model");
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		
		redirect('accounts/commission/config');
		
		
		
	}
	public function config()
	{
		//$this->output->delete_cache();
		$data=NULL;
		
	if ( ! check_access('view commissionrates'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		$data['searchdata']=$inventory=$this->commission_model->get_commission_cat();
		$data['usertype']=$usertype=$this->commission_model->get_commission_cat();
		
	$this->load->view('accounts/commission/config_main',$data);
		
		
		
	}

	
	
	public function add_range()
	{
		if ( ! check_access('add commissionrates'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		
		$id=$this->commission_model->add_range();
		
		$this->session->set_flashdata('msg', 'Category range Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('type_name').'  successfully Inserted');
		redirect("accounts/commission/config");
		
	}
	
	public function delete_range()
	{
		
		if ( ! check_access('add commissionrates'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		$id=$this->commission_model->delete_range($this->uri->segment(4));
		
			$this->session->set_flashdata('msg', 'category Type Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  successfully Deleted');
		redirect("accounts/commission/config");
		
	}
	function get_categodtylist()
	{
		if ( ! check_access('add commissionrates'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		$data['tableid']=$tableid=$this->uri->segment(4);
		$data['year']=$year=$this->uri->segment(5);
		$data['catlist']=$this->commission_model->get_commission_cat_year($year);
		$this->load->view('accounts/commission/config_catlist',$data);
	}
	
	public function add_rate()
	{
		
		if ( ! check_access('add commissionrates'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		$data['tableid']=$tableid=$this->input->post('table_id');
		$year=$this->input->post('year_cat');
		$data['catlist']=$catlist=$this->commission_model->get_commission_cat_year($year);
		if($catlist)
		{
			foreach($catlist as $raw)
			{
				 $rate=get_commission_rate_by_catid_tableid($raw->id,$tableid,$year);
				 $amount=str_replace(',', '', $this->input->post('amount'.$raw->id));
				  $rate_type=$this->input->post('rate_type'.$raw->id);
				  $status='PENDING';
							  if($rate)
							  {
							 
							  $status=$rate->status;
							  }
							  if($status=='PENDING')
							  {
							  $this->commission_model->delete_cat_rate($raw->id,$tableid);
							  $this->commission_model->insert_cat_rate($amount,$raw->id,$tableid,$year,$rate_type);
							  
							  }
							  
			}
			$this->commission_model->update_cat_status($year);
		}
		$this->session->set_flashdata('msg', 'Cash Book  Successfully Inserted ');
		$this->logger->write_message("success", 'Commision Rates  successfully Inserted');
		redirect("accounts/commission/config");
		
	}
	public function commission_main()
	{
		//$this->output->delete_cache();
		$data=NULL;
		
	if ( ! check_access('view Commision list'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		$data['searchdata']=$inventory=$this->commission_model->get_commission_master();
		
	$this->load->view('accounts/commission/commission_main',$data);
		
		
		
	}
	function generate_commission()
	{
		if ( ! check_access('generate_commision'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
			$data['year']=$year=$this->input->post('year');
			$data['month']=$month=$this->input->post('month');
			$checkgenerated=$this->commission_model->get_checkgenerated($year,$month);
			if($checkgenerated)
			{	
			
				 $startdate=$year.'-'.$month.'-01';
				 $enddate=$year.'-'.$month.'-31';
				$currentmonthpayment=$this->commission_model->get_current_month_payment($startdate,$enddate);
				$runid=$this->commission_model->add_commision_master($year,$month);
				if($currentmonthpayment)
				{
					foreach($currentmonthpayment as $raw)
					{
						$res_code=$raw->res_code;
						$pastpaydate=$raw->pay_date;
						$resdata=$this->commission_model->get_all_reservation_details_bycode($res_code);
						
							$price=$resdata->discounted_price;
							$downpayment=$downpayment=$this->commission_model->tot_month_payment($res_code,$enddate);
							$discount=$resdata->discount;
						
							$cost=$resdata->costof_sale;
							$presentage=($downpayment/$price)*100;
							$profit=(($price-$cost)/$cost)*100;
							// Staff
							$team_leader=$resdata->team_leader;
							$officer_code=$resdata->officer_code;
							if($resdata->sales_person)
							$officer_code=$resdata->sales_person;
							$officer_code2=$resdata->officer_code2;
							$tpo=2;
							//$divition=$resdata->sale_type;
							$branch=$resdata->branch_code;
							if($presentage>=40)
							{
									
									
										$is_commigiv=$this->commission_model->is_commission_given($resdata->lot_id);
										if($is_commigiv)
										{
											$prev_givcomm=$is_commigiv->res_code;
											if($prev_givcomm==$res_code)
											{
												//echo "No COmmission Allow";
											}
											else
											{
												$dataid=$this->run_commission($res_code,$resdata->lot_id,$resdata->prj_id,$price,$discount,$cost,$pastpaydate,$resdata->res_date,$resdata->period,$resdata->date_proposal,$downpayment,$year,$runid,$team_leader,$tpo,$officer_code,$officer_code2);
												if($dataid!='0')
												{
												$this->reduce_prev_commission($is_commigiv->id,$is_commigiv->run_id,$runid,$dataid);
												
												}
											}
										}
										else
										{
											$dataid=$this->run_commission($res_code,$resdata->lot_id,$resdata->prj_id,$price,$discount,$cost,$pastpaydate,$resdata->res_date,$resdata->period,$resdata->date_proposal,$downpayment,$year,$runid,$team_leader,$tpo,$officer_code,$officer_code2);
											
										}
									
							}
						}
				}
				
				
				
				
					$this->session->set_flashdata('msg', 'Monthly Commission Successfully  Generated ');
					redirect("accounts/commission/commission_main");
			}
			else
			{
					$this->session->set_flashdata('error', 'Commission Already Generated For given month');
					redirect("accounts/commission/commission_main");
			}
	}
	function run_commission($res_code,$lot_id,$prj_id,$price,$discount,$cost,$pastpaydate,$res_date,$period,$date_proposal,$downpayment,$year,$runid,$team_leader,$tpo,$officer_code,$officer_code2)
	{
			$d1 =  date_create($res_date);
			$d2 = date_create($pastpaydate);
			$futureDate=date('Y-m-d',strtotime('+'.$period.' months',strtotime($date_proposal)));
// @link http://www.php.net/manual/en/class.dateinterval.php
			$diff=date_diff($d1,$d2);
			 $months= $diff->format('%m');
			  $days= $diff->format('%a');
			$presentage=($downpayment/$price)*100;
			//$category=$this->commission_model->get_price_category($year,$price);
			$commision=0;
		//	echo $category.'ssss'.number_format($price,2);
			//$commision=$this->commission_model->get_commission_rate_focal($category,$table);
		$tableid=0;
		$dataid=0;
		if($futureDate >= $pastpaydate)
		{
			 if($days<=21)
			 {
			 if($presentage>=100)
			 {
				 $commision=$this->commission_model->get_commission_rate_focal($runid,$res_code,$lot_id,$prj_id,$year,2,$price,$team_leader,$tpo,$officer_code,$officer_code2,$pastpaydate,$presentage);
				 $tableid=2;
				 // echo $price.'-'.$commision.'-'.$months.' withing one month table 01 <br>';
			 }
			 else if($presentage>=40 & $presentage<100)
			 {
				  $tableid=1;
				  $commision=$this->commission_model->get_commission_rate_focal($runid,$res_code,$lot_id,$prj_id,$year,1,$price,$team_leader,$tpo,$officer_code,$officer_code2,$pastpaydate,$presentage);
				 // echo $price.'-'.$commision.'-'.$months.'  withing one month table 02 <br>';
			 }
			 else
			 { $commision=0;;
				// echo $price.'-'.$commision.'-'.$months.'  withing one month commission 0 <br>';
			 }
		 }
		
		}
		 else
		 {
			  if($days<=21 & $presentage>=40 )
			 {
				  $tableid=3;
				  $commision=$this->commission_model->get_commission_rate_focal($runid,$res_code,$lot_id,$prj_id,$year,3,$price,$team_leader,$tpo,$officer_code,$officer_code2,$pastpaydate,$presentage);
				// echo $res_code.'-'.$commision.'-'.$months.'without period table 06 <br>';
			 }
			 else
			 {
				  $commision=0;
				// echo $res_code.'-'.$commision.'-'.$months.' without period commission 0 <br>';
			 }
		 }
		
		return  $commision;

	}
	
	function reduce_prev_commission($previd,$prevrun_id,$runid,$dataid)
	{
		$dataset=$this->commission_model->commission_staff_data($prevrun_id,$previd);
		if($dataset)
		{
			foreach($dataset as $raw)
			{
				$emp_id=$raw->emp_id;
				$deduct_amount=$raw->amount;
				$deduct_runid=$prevrun_id;
				$deduct_data_id=$previd;
				$amount=0;
				$this->commission_model->add_commision_staff_data($runid,$dataid,$emp_id,$amount,$deduct_amount,$deduct_runid,$deduct_data_id);
				
			}
		}
	}
	public function delete_commission()
	{
		
		$id=$this->commission_model->delete_commission($this->uri->segment(4));
		
			$this->session->set_flashdata('msg', 'category Type Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  successfully Deleted');
		redirect("accounts/commission/commission_main");
		
	}
	function get_commisiondata()
	{
		$data['month']=$month=$this->uri->segment(4);
		$data['year']=$year=$this->uri->segment(5);
		$data['commisiondata']=NULL;
		$data['staffsummery']=NULL;
		$data['projectsummery']=NULL;
		$staffdata=NULL;
		$tpodata=NULL;
		$data['rundata']=$rundata=$this->commission_model->get_commission_year_month($year,$month);
		if($rundata){
		$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id($rundata->id);
		$data['staffsummery']=$staffsummery=$this->commission_model->get_current_month_staffsummery($rundata->id);
			$data['projectsummery']=$projectsummery=$this->commission_model->get_current_month_projectsummery($rundata->id);
			
		//	$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id_prjid($runid,$projectid); a
		if($staffsummery)
		{ foreach ($staffsummery as $staffraw){
		if($projectsummery)
		{
			foreach($projectsummery as $row)
			{
				
			//	
				$staffdata[$staffraw->emp_id][$row->project_id]=$this->commission_model->commission_staff_prjid_sum($rundata->id,$row->project_id,$staffraw->emp_id);
				
				$tpodata[$row->project_id]=$this->commission_model->commission_tpo_prjid_sum($rundata->id,$row->project_id);
			//	print_r($staffdata[$staffraw->emp_id][$row->project_id]);
				
			}
		}
		}
		}
		$data['staffdata']=$staffdata;
		$data['tpodata']=$tpodata;
		$this->load->view('accounts/commission/commission_data',$data);
		}
	}
	function get_commision_staff()
	{
		$data['runid']=$runid=$this->uri->segment(4);
		$data['projectid']=$projectid=$this->uri->segment(5);
		$data['commisiondata']=NULL;
		$data['staffdata']=NULL;
		$tpodata=NULL;
		$data['rundata']=$rundata=$this->commission_model->get_commission_runid($runid);
		$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id_prjid($runid,$projectid);
		if($commisiondata)
		{
			foreach($commisiondata as $row)
			{
				
				$staffdata[$row->id]=$this->commission_model->commission_staff_prjid($row->id);
				$tpodata[$row->id]=$this->commission_model->commission_tpo_prjid($row->id);
				
			}
		}
		$data['prjdata']=$prjdata=$this->commission_model->get_project_master_data($projectid);
		$data['allstaff']=$allstaff=$this->commission_model->get_all_sales_staff($prjdata->branch_code);
		$data['staffdata']=$staffdata;
		$data['tpodata']=$tpodata;
		$this->load->view('accounts/commission/commission_staffdata',$data);
	}
	function staff_commission_update()
	{
		$data['runid']=$runid=$this->input->post('runid');
		$data['projectid']=$projectid=$this->input->post('projectid');
		$data['commisiondata']=NULL;
		$data['staffdata']=NULL;
		$data['prjdata']=$prjdata=$this->commission_model->get_project_master_data($projectid);
		$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_update_staffamount($runid,$projectid,$prjdata->branch_code);
		
		$this->session->set_flashdata('msg', 'Monthly Commission Successfully  Updated ');
					redirect("accounts/commission/commission_main");
	}
	
	public function confirm_commission()
	{
		if ( ! check_access('confirm_commision'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		
		$id=$this->commission_model->confirm_commission($this->uri->segment(4));
		
			$this->session->set_flashdata('msg', 'Commission Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  successfully Confirmed');
		redirect("accounts/commission/commission_main");
		
	}
	function commission_details_excel()
	{
		$data['month']=$month=$this->uri->segment(4);
		$data['year']=$year=$this->uri->segment(5);
		$data['commisiondata']=NULL;
		$data['staffsummery']=NULL;
		$data['projectsummery']=NULL;
		$staffdata=NULL;
		$tpodata=NULL;
		$data['rundata']=$rundata=$this->commission_model->get_commission_year_month($year,$month);
		if($rundata){
		$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id($rundata->id);
		$data['staffsummery']=$staffsummery=$this->commission_model->get_current_month_staffsummery($rundata->id);
			$data['projectsummery']=$projectsummery=$this->commission_model->get_current_month_projectsummery($rundata->id);
			
		//	$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id_prjid($runid,$projectid); a
		if($staffsummery)
		{ foreach ($staffsummery as $staffraw){
		if($projectsummery)
		{
			foreach($projectsummery as $row)
			{
				
			//	
				$staffdata[$staffraw->emp_id][$row->project_id]=$this->commission_model->commission_staff_prjid_sum($rundata->id,$row->project_id,$staffraw->emp_id);
				
				$tpodata[$row->project_id]=$this->commission_model->commission_tpo_prjid_sum($rundata->id,$row->project_id);
			//	print_r($staffdata[$staffraw->emp_id][$row->project_id]);
				
			}
		}
		}
		}
		$data['staffdata']=$staffdata;
		$data['tpodata']=$tpodata;
		$this->load->view('accounts/commission/commission_data_excel',$data);
		}
	}
		function commission_details_staff_excel()
	{
		$data['month']=$month=$this->uri->segment(4);
		$data['year']=$year=$this->uri->segment(5);
		$data['commisiondata']=NULL;
		$data['staffsummery']=NULL;
		$data['projectsummery']=NULL;
		$staffdata=NULL;
		$tpodata=NULL;
		$data['rundata']=$rundata=$this->commission_model->get_commission_year_month($year,$month);
		if($rundata){
		$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id($rundata->id);
		$data['staffsummery']=$staffsummery=$this->commission_model->get_current_month_staffsummery($rundata->id);
			$data['projectsummery']=$projectsummery=$this->commission_model->get_current_month_projectsummery($rundata->id);
			
		//	$data['commisiondata']=$commisiondata=$this->commission_model->commission_lot_run_id_prjid($runid,$projectid); a
		if($staffsummery)
		{ foreach ($staffsummery as $staffraw){
		if($projectsummery)
		{
			foreach($projectsummery as $row)
			{
				
			//	
				$staffdata[$staffraw->emp_id][$row->project_id]=$this->commission_model->commission_staff_prjid_sum($rundata->id,$row->project_id,$staffraw->emp_id);
				
				$tpodata[$row->project_id]=$this->commission_model->commission_tpo_prjid_sum($rundata->id,$row->project_id);
			//	print_r($staffdata[$staffraw->emp_id][$row->project_id]);
				
			}
		}
		}
		}
		$data['staffdata']=$staffdata;
		$data['tpodata']=$tpodata;
		$this->load->view('accounts/commission/commission_data_staff_excel',$data);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */