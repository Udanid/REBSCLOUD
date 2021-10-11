<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class feasibility extends CI_Controller {

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
		
		$this->load->model("hm_land_model");
		$this->load->model("hm_common_model");
		$this->load->model("hm_introducer_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_feasibility_model");
		$this->load->model("hm_producttasks_model");
		$this->load->model("hm_dplevels_model");
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/project/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/');
			return;
		}
		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->project_name.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/project/search';
				$data['tag']='Search project';
				$data['product_code']='LNS';
				$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
				$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
				$data['valuse_items']=$this->hm_feasibility_model->get_project_valueitems($prj_id);
				$data['dplist']=$dplist=$this->hm_dplevels_model->get_dplevels();
				$data['officerlist']=$this->hm_project_model->get_project_officer_list($this->session->userdata('branchid'));
				$data['land_list']=$this->hm_land_model->get_all_unused_land_summery();
				$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
				$maintaskdata=NULL;
				$prjduration=$pridata->period;
				$timechart=NULL;
				if($tasklist)
				{
					foreach($tasklist as $raw)
					{
						$maintaskdata[$raw->task_id]['maintask']=$this->hm_feasibility_model->get_project_maintask_forentry($prj_id,$raw->task_id);
						
						$maintaskdata[$raw->task_id]['prjsubtask']=$this->hm_feasibility_model->get_project_subtask($prj_id,$raw->task_id);
						$maintaskdata[$raw->task_id]['subtask']=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);
					
					for($i=1; $i<=$prjduration; $i++)
					{
						$timechart[$raw->task_id][$i]=$this->hm_feasibility_model->get_month_task_percentage($prj_id,$raw->task_id,$i);
						//echo print_r($tasklist);
					}
					}
				}
				$data['timechart']=$timechart;
				$data['maintaskdata']=$maintaskdata;
				$data['tasklist']=$tasklist;
				$dpdata=NULL;
				if($dplist)
				{
					
					foreach($dplist as $dpraw)
					{
						$dpdata[$dpraw->dp_id]=$this->hm_feasibility_model->get_project_dprates_bydpid($prj_id,$dpraw->dp_id);
					}
				}
				$data['dpdata']=$dpdata;
				$data['epchart']=$this->hm_feasibility_model->get_project_epchart($prj_id);
				$data['perch_price']=$this->hm_feasibility_model->get_project_perch_price($prj_id);
				$salestime=NULL;
				$bankloan=NULL;
				for($i=1; $i<=24; $i++)
					{
						$salestime[$i]=$this->hm_feasibility_model->get_salestime_month($prj_id,$i);
						//echo print_r($tasklist);
					}
					for($i=1; $i<=6; $i++)
					{
						$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
						//echo print_r($tasklist);
					}
					$data['bankloan']=$bankloan;
				$data['salestime']=$salestime;
				$data['fsbstatus']=$this->hm_feasibility_model->get_fesibilitystatus($prj_id);
			$this->load->view('hm/feasibility/feasibility_data',$data);
		
		
		
	}
	function edit_project()
	{
			$prj_id=$this->input->post('prj_id');
	$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		//$this->session->set_flashdata('tab', 'value');
		$data['details']=$pridata=$this->hm_project_model->edit();
		$this->hm_feasibility_model->last_update($prj_id);
		$this->session->set_flashdata('msg', 'Project Details Successfully Updated ');
		$this->logger->write_message("success", $prj_id.' ProjectDetails Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
		
	}
	function add_valueitems()
	{ 
	$prj_id=$this->input->post('prj_id');
	$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$count=7;
		$this->hm_feasibility_model->delete_valueitems($prj_id);
		for($i=1; $i<=$count; $i++)
		{
			if($this->input->post('name'.$i)!="")
			{
				$this->hm_feasibility_model->add_valueitems($prj_id,$this->input->post('name'.$i),$this->input->post('quontity'.$i),$this->input->post('value'.$i));
			}
		}
		$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'valueitems');
		$this->hm_feasibility_model->last_update($prj_id);
		$this->session->set_flashdata('tab', 'value');
		$this->session->set_flashdata('msg', 'Project Value Items Successfully Updated ');
		$this->logger->write_message("success", $prj_id.' Project Value Items Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
	}
	
	function add_budgut()
	{
		$prj_id=$this->input->post('prj_id');
		$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$this->hm_feasibility_model->delete_budgut_subtask($prj_id);
		$this->hm_feasibility_model->delete_budgut_task($prj_id);
		$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
		
		$maintaskdata=NULL;
				if($tasklist)
				{
					foreach($tasklist as $raw)
					{ 
					$this->hm_feasibility_model->add_budgut_task($prj_id,$raw->task_id,$this->input->post('total'.$raw->task_id));
						$sublist=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);
						if($sublist)
						{
							foreach($sublist as $subraw)
							{
								if($this->input->post('amount'.$subraw->subtask_id)>0)
								{
									$this->hm_feasibility_model->add_budgut_subtask($prj_id,$raw->task_id,$this->input->post('amount'.$subraw->subtask_id),$subraw->subtask_id);
									echo $this->input->post('amount'.$subraw->subtask_id);
								}
							}
						}
					}
				}
				$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'budget');
				$this->hm_feasibility_model->last_update($prj_id);
				$this->session->set_flashdata('tab', 'budget');
				$this->session->set_flashdata('msg', 'Budget Successfully Updated');
		$this->logger->write_message("success", $prj_id.' Project Budget Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
		
	}
	
	function add_marketdata()
	{
		$prj_id=$this->input->post('prj_id');
		$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$dpdata=NULL;
		$data['dplist']=$dplist=$this->hm_dplevels_model->get_dplevels();
		
		$this->hm_feasibility_model->delete_dprates($prj_id);
		$this->hm_feasibility_model->delete_epchart($prj_id);
		$this->hm_feasibility_model->delete_bankloan($prj_id);
		$this->hm_feasibility_model->update_marketdata($prj_id);
				if($dplist)
				{
					
					foreach($dplist as $dpraw)
					{
						$this->hm_feasibility_model->add_dprates($prj_id,$dpraw->dp_id,$this->input->post('percentage'.$dpraw->dp_id));
					}
				}
				for($i=12; $i<=96; $i=$i+12){
				$this->hm_feasibility_model->add_epchart($prj_id,$i,$this->input->post('eppercentage'.$i));}
				for($i=1; $i<=5; $i++){
				$this->hm_feasibility_model->add_bankloan($prj_id,$i,$this->input->post('landbankmonth'.$i));}
				
				$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'marketing');
				$this->hm_feasibility_model->last_update($prj_id);
				$this->session->set_flashdata('msg', 'Marketing Data Successfully Updated ');
				$this->session->set_flashdata('tab', 'market');
		$this->logger->write_message("success", $prj_id.' Project Marketing Data Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
		
	}
	function add_price()
	{ 
	$prj_id=$this->input->post('prj_id');
	$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$count=7;
		$this->hm_feasibility_model->delete_price($prj_id);
		for($i=1; $i<=$count; $i++)
		{
			if($this->input->post('perches_count'.$i)>0)
			{
				$this->hm_feasibility_model->add_price($prj_id,$this->input->post('perches_count'.$i),$this->input->post('price'.$i));
			}
		}
		$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'price');
		$this->hm_feasibility_model->last_update($prj_id);
		$this->session->set_flashdata('tab', 'price');
		$this->session->set_flashdata('msg', 'Project Perch Price Successfully Updated ');
		$this->logger->write_message("success", $prj_id.' Project Perch Price Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
	}
	function add_time()
	{
		$prj_id=$this->input->post('prj_id');
		$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$this->hm_feasibility_model->delete_time($prj_id);
		$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
		$prjduration=$this->input->post('prjperiod');
		$maintaskdata=NULL;
				if($tasklist)
				{
					foreach($tasklist as $raw)
					{ 
					for($i=1; $i<=$prjduration; $i++)
					{
						if($this->input->post('timerange'.$raw->task_id.$i)!=0)
						$this->hm_feasibility_model->add_time($prj_id,$raw->task_id,$i,$this->input->post('timerange'.$raw->task_id.$i));
						//echo print_r($tasklist);
					}
					}
				}
				$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'dptime');
				$this->hm_feasibility_model->last_update($prj_id);
				$this->session->set_flashdata('tab', 'time');
				$this->session->set_flashdata('msg', 'Development Time Sheet Successfully Updated ');
		$this->logger->write_message("success", $prj_id.' Development Time Sheet Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
		
	}
	function add_salestime()
	{
		$prj_id=$this->input->post('prj_id');
		$encode_id=$this->encryption->encode($prj_id);
	//echo $encode_id;
		if ( ! check_access('add_feasibility'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$this->hm_feasibility_model->delete_salestime($prj_id);
		$maintaskdata=NULL;
					for($i=1; $i<=24; $i++)
					{
						if($this->input->post('salestime'.$i)!=0)
						$this->hm_feasibility_model->add_salestime($prj_id,$i,$this->input->post('salestime'.$i));
						//echo print_r($tasklist);
					}
					
					$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'saletime');
					$this->hm_feasibility_model->last_update($prj_id);
				$this->session->set_flashdata('tab', 'sales');
				$this->session->set_flashdata('msg', 'Sales Time Sheet Successfully Updated');
		$this->logger->write_message("success", $prj_id.' Sales Time Sheet Successfully Updated');
		redirect('hm/feasibility/showall/'.$encode_id);
	}

	function generete_evereport()
	{
		$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
		$encode_id=$this->encryption->encode($prj_id);
		if ( ! check_access('generate_evereport'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$this->uri->segment(4));
			return;
		}
		$pridata=$this->hm_project_model->get_project_bycode($prj_id);
		if($this->hm_feasibility_model->get_lastupdate($prj_id)){	
		$this->hm_feasibility_model->generate_evereport($prj_id,$pridata->epsales);
		
		$avagrates=$this->hm_feasibility_model->get_evereport_avarage_eprates($prj_id);	
		$eprates=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);
		$this->hm_feasibility_model->delete_rentalCalculation($prj_id);
		if($avagrates){
			$avgset=NULL;
			for($i=12; $i<=96; $i=$i+12){ 
			 $avgset[$i]=0;
		 	}
			foreach($avagrates as $raw)
			{
				 for($i=12; $i<=96; $i=$i+12){ $rawname=$i.'M';
					 $avgset[$i]=$avgset[$i]+$raw->$rawname;
		 			}
			}
			if($eprates){
				$rawsum[1]=0;$rawsum[2]=0;$rawsum[3]=0;$rawsum[4]=0;$rawsum[5]=0;$rawsum[6]=0;
				$rawsum[7]=0;$rawsum[8]=0;$rawsum[9]=0; $sale=NULL; 
				$lots=$pridata->selable_area/10;
				$data[1]=array('prj_id'=>$prj_id,
				'raw_name'=>'E/P Sales');
				$data[2]=array('prj_id'=>$prj_id,
				'raw_name'=>'Down Payment');
				$data[3]=array('prj_id'=>$prj_id,
				'raw_name'=>'EP Investment');
				$data[4]=array('prj_id'=>$prj_id,
				'raw_name'=>'Tot Net Interest');
				$data[5]=array('prj_id'=>$prj_id,
				'raw_name'=>'Capital And Interest');
				$data[6]=array('prj_id'=>$prj_id,
				'raw_name'=>'Net Rental');
				$data[7]=array('prj_id'=>$prj_id,
				'raw_name'=>'Income %');
				$data[8]=array('prj_id'=>$prj_id,
				'raw_name'=>'Number of Contracts');
				$data[9]=array('prj_id'=>$prj_id,
				'raw_name'=>'Average Rental');
				for($i=12; $i<=96; $i=$i+12){ $rawname=$i.'M'; 
					if($eprates->$rawname!=0) $sale[$i]=$masterdata->total_sale*$eprates->$rawname/100;
						else $sale[$i]=0;
						$data[1][$rawname]=$sale[$i];
						$rawsum[1]=$rawsum[1]+$sale[$i];
					if($eprates->$rawname!=0) $down[$i]=($sale[$i])*$masterdata->avg_dpcash/100;
								 else $down[$i]=0;
							$data[2][$rawname]=$down[$i];
							$rawsum[2]=$rawsum[2]+$down[$i];
							// Ep Investment Calculation
							$inv[$i]=$sale[$i]-$down[$i];
							$data[3][$rawname]=$inv[$i];
							$rawsum[3]=$rawsum[3]+$inv[$i];
							// Total Net Interest Calculation
							$intrest[$i]=($inv[$i]*$avgset[$i]*($i/12))/100;
							$data[4][$rawname]=$intrest[$i];
							$rawsum[4]=$rawsum[4]+$intrest[$i];
							//Capital + Interest
							$capint[$i]=$inv[$i]+$intrest[$i];
							$data[5][$rawname]=$capint[$i];
							$rawsum[5]=$rawsum[5]+$capint[$i];
							//net Rental
							$netrent[$i]=$capint[$i]/$i;
							$data[6][$rawname]=$netrent[$i];
							$rawsum[6]=$rawsum[6]+$netrent[$i];
							//Income Caluclation
							if($intrest[$i]>0) $income[$i]=$intrest[$i]/$capint[$i]; else $income[$i]=0;
							$data[7][$rawname]=$income[$i];	 
							$rawsum[7]=$rawsum[7]+$income[$i];
							//Number of Contracts Calculation
							if($eprates->$rawname>0) $contract[$i]=$eprates->$rawname*$lots/100; else $contract[$i]=0;
							$data[8][$rawname]=$contract[$i];	 
							$rawsum[8]=$rawsum[8]+$contract[$i];
							//Average Rental Calculation
							if($netrent[$i]>0) $avgrent[$i]=$netrent[$i]/$contract[$i]; else $avgrent[$i]=0;
							$data[9][$rawname]=$avgrent[$i];	 
							$rawsum[9]=$rawsum[9]+$avgrent[$i];
							
				}
				$data[1]['raw_total']=$rawsum[1];
				$data[2]['raw_total']=$rawsum[2];
				$data[3]['raw_total']=$rawsum[3];
				$data[4]['raw_total']=$rawsum[4];
				$data[5]['raw_total']=$rawsum[5];
				$data[6]['raw_total']=$rawsum[6];
				$data[7]['raw_total']=$rawsum[7];
				$data[8]['raw_total']=$rawsum[8];
				$data[9]['raw_total']=$rawsum[9];
				$this->hm_feasibility_model->insert_rentalCalculation($data[1]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[2]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[3]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[4]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[5]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[6]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[7]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[8]);
				$this->hm_feasibility_model->insert_rentalCalculation($data[9]);
				
			}
			$this->calculate_monthcashflow($prj_id);
	
		}
		}
		redirect('hm/feasibility/evaluation_report/'.$encode_id);
	}
	function calculate_monthcashflow($prj_id){
			for($i=1; $i<=12; $i++)
					{$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
						if($bankloan[$i])
						$bankloan[$i]=$bankloan[$i]->amount;
						else $bankloan[$i]=0;
						$rawtot[$i]=0;
						//echo print_r($tasklist);
					}
					//print_r($bankloan);
		$data['bankloan']=$bankloan;
		$data['saleprice']=$this->hm_feasibility_model->get_salesprice_sum($prj_id);
		$data['totdpcost']=$this->hm_feasibility_model->get_developmentcost_sum($prj_id);
		$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
		$data['developmentcost']=$developmentcost=$this->hm_feasibility_model->get_evereport_task($prj_id);	
		$data['eprates']=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
		$data['rentalchart']=$rentalchart=$this->hm_feasibility_model->get_rentalchart($prj_id);	
		$data['monthsales']=$sales=$this->hm_feasibility_model->get_project_sales_time($prj_id);	
		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);
		foreach($developmentcost as $raw) {
			for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;}
		}
		foreach($rentalchart as $rentraw)
		$easylist[$rentraw->raw_name]=$rentraw;
		$mynames[0]=array('prj_id'=>$prj_id,
		'name'=>'Sale %',
		'thiskey'=>'sales');
		$mynames[1]=array('prj_id'=>$prj_id,'name'=>'O/R Sales',
		'thiskey'=>'outright');
		$mynames[2]=array('prj_id'=>$prj_id,'name'=>'E/P D/P',
		'thiskey'=>'epdp');
		$mynames[3]=array('prj_id'=>$prj_id,'name'=>'E/P sales',
		'thiskey'=>'epsales');
		$mynames[4]=array('prj_id'=>$prj_id,'name'=>'Sales Tax',
		'thiskey'=>'salestax');
		$mynames[5]=array('prj_id'=>$prj_id,'name'=>'Rental 12M',
		'thiskey'=>'12rental');
		$mynames[6]=array('prj_id'=>$prj_id,'name'=>'Rental 24M',
		'thiskey'=>'24rental');
		$mynames[7]=array('prj_id'=>$prj_id,'name'=>'Rental 36M',
		'thiskey'=>'36rental');
		$mynames[8]=array('prj_id'=>$prj_id,'name'=>'Rental 48M',
		'thiskey'=>'48rental');
		$mynames[9]=array('prj_id'=>$prj_id,'name'=>'Rental 60M',
		'thiskey'=>'60rental');
		$mynames[9]=array('prj_id'=>$prj_id,'name'=>'Rental 60M',
		'thiskey'=>'60rental');
		$mynames[10]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'rentaltot');
		
		//epcbalf,epccurrentdue,epccurrentcollecr,epcdrcollecr,epctot,epcbalc
		$mynames[11]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'epcbalf');
		$mynames[12]=array('prj_id'=>$prj_id,'name'=>'Current Due',
		'thiskey'=>'epccurrentdue');
		$mynames[13]=array('prj_id'=>$prj_id,'name'=>'Curr. Collection',
		'thiskey'=>'epccurrentcollecr');
		$mynames[14]=array('prj_id'=>$prj_id,'name'=>'DrCollection',
		'thiskey'=>'epcdrcollecr');
		$mynames[15]=array('prj_id'=>$prj_id,'name'=>'Total Collection',
		'thiskey'=>'epctot');
		$mynames[16]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'epcbalc');
		//epsbalf,epsinv,epsdeple,epsbalc
		$mynames[17]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'epsbalf');
		$mynames[18]=array('prj_id'=>$prj_id,'name'=>'E/P Investment',
		'thiskey'=>'epsinv');
		$mynames[19]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Depletion',
		'thiskey'=>'epsdeple');
		$mynames[20]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'epsbalc');
//epinterest*****************************************

		$mynames[21]=array('prj_id'=>$prj_id,'name'=>'E/P Int 12M',
		'thiskey'=>'12interest');
		$mynames[22]=array('prj_id'=>$prj_id,'name'=>'E/P Int 24M',
		'thiskey'=>'24interest');
		$mynames[23]=array('prj_id'=>$prj_id,'name'=>'E/P Int 36M',
		'thiskey'=>'36interest');
		$mynames[24]=array('prj_id'=>$prj_id,'name'=>'E/P Int 48M',
		'thiskey'=>'48interest');
		$mynames[25]=array('prj_id'=>$prj_id,'name'=>'E/P Int 60M',
		'thiskey'=>'60interest');
		$mynames[26]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'interesttot');
		
		$mynames[27]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'fundbalf');
		$mynames[28]=array('prj_id'=>$prj_id,'name'=>'Receipts',
		'thiskey'=>'fundrecipt');
		$mynames[29]=array('prj_id'=>$prj_id,'name'=>'Repayments',
		'thiskey'=>'fundrepayment');
		$mynames[30]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'fundbalc');
		
		$mynames[31]=array('prj_id'=>$prj_id,'name'=>'L/B Loans',
		'thiskey'=>'inflowlbloans');
		$mynames[32]=array('prj_id'=>$prj_id,'name'=>'O/R Sales',
		'thiskey'=>'infloworsales');
		$mynames[33]=array('prj_id'=>$prj_id,'name'=>'E/P D/P',
		'thiskey'=>'inflowepdp');
		$mynames[34]=array('prj_id'=>$prj_id,'name'=>'Rentals',
		'thiskey'=>'inflowrental');
		$mynames[35]=array('prj_id'=>$prj_id,'name'=>'Other',
		'thiskey'=>'inflowother');
		$mynames[36]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'inflowtot');
		//outflowprjx,,,,,outflowtot,cashflowbalf,cashnetflow,cashbalc

		$mynames[37]=array('prj_id'=>$prj_id,'name'=>'Project Ex',
		'thiskey'=>'outflowprjx');
		$mynames[38]=array('prj_id'=>$prj_id,'name'=>'L/B Loan Settl',
		'thiskey'=>'outflowbloanset');
		$mynames[39]=array('prj_id'=>$prj_id,'name'=>'L/B Loan Int. - (LBLI)',
		'thiskey'=>'outflowlbloanint');
		$mynames[40]=array('prj_id'=>$prj_id,'name'=>'Sales Tax',
		'thiskey'=>'outflowsalestax');
		$mynames[41]=array('prj_id'=>$prj_id,'name'=>'Other',
		'thiskey'=>'outflowother');
		$mynames[42]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'outflowtot');
		//outflowprjx,,,,,outflowtot,,,
		$mynames[43]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'cashflowbalf');
		$mynames[44]=array('prj_id'=>$prj_id,'name'=>'Net  Inflow',
		'thiskey'=>'cashnetflow');
		$mynames[45]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'cashbalc');
		
		//,
		$mynames[46]=array('prj_id'=>$prj_id,'name'=>'L/B Interest - (LBLI)',
		'thiskey'=>'intexpLB');
		$mynames[47]=array('prj_id'=>$prj_id,'name'=>'Br Fund Interest - (BFI)',
		'thiskey'=>'intexpBR');	
		// //inalblbal,inabfbal,inarepay
		$mynames[48]=array('prj_id'=>$prj_id,'name'=>'L/B Loan Balance (LBL Bal)',
		'thiskey'=>'inalblbal');
		$mynames[49]=array('prj_id'=>$prj_id,'name'=>'Br.Fund Balance  (BF Bal)',
		'thiskey'=>'inabfbal');
		$mynames[50]=array('prj_id'=>$prj_id,'name'=>'BFBal.Net of LBL Repayt.   ',
		'thiskey'=>'inarepay');
		$mynames[51]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Balance   ',
		'thiskey'=>'inastockbal');
		$mynames[52]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Funded by LBL   ',
		'thiskey'=>'inasfundedLBL');
		$mynames[53]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Funded by BR  ',
		'thiskey'=>'inasfundedBF');
		$mynames[54]=array('prj_id'=>$prj_id,'name'=>'RED Funded by LBL',
		'thiskey'=>'inasfundedRED');
		$mynames[55]=array('prj_id'=>$prj_id,'name'=>'LBLI on E/P',
		'thiskey'=>'lbliEP');
		$mynames[56]=array('prj_id'=>$prj_id,'name'=>'LBLI on RED',
		'thiskey'=>'lbliRED');
		$mynames[57]=array('prj_id'=>$prj_id,'name'=>'BFI on E/P',
		'thiskey'=>'lbliBFI');
		
		for($i=1; $i<=96; $i++)
		{
			$month['sales'][$i]=0;
		}
		foreach($sales as $raw)
		{
			$month['sales'][$raw->month]=$raw->percentage;
		}
		$yeardataset=NULL;
		$count=1;
		
		$yearcal=13;
		//echo $easylist['Net Rental']->$thisraw;
		for($i=1; $i<=96; $i++)
		{
			$t=$j=$i%12;
			
			
			$t=$i;
			//outright sales calculation
			$outright=$pridata->outright*$masterdata->total_sale*$month['sales'][$i];
			if($outright>0)$outright=$outright/10000 ;else $outright=0;
			$month['outright'][$i]=$outright;
			$yeardataset[$count]['outright'][$t.'M']=$outright;
			//Down payment calculation
			$epdp=$easylist['Down Payment']->raw_total*$month['sales'][$i];
			if($outright>0)$epdp=$epdp/100 ;else $epdp=0;
			$month['epdp'][$i]=$epdp;
			$yeardataset[$count]['epdp'][$t.'M']=$epdp;
			// epsales calculation
			$epsales=$masterdata->total_sale*$month['sales'][$i];
			if($outright>0)$epsales=($epsales/100)-$month['outright'][$i] ;else $epdp=0;
			$month['epsales'][$i]=$epsales;
			$yeardataset[$count]['epsales'][$t.'M']=$epsales;
			// Sales tax
			$salestax=$masterdata->total_sale*$month['sales'][$i]*$pridata->sales_tax;
			if($salestax>0)$salestax=($salestax/10000) ;else $salestax=0;
			$month['salestax'][$i]=$salestax;
			$yeardataset[$count]['salestax'][$t.'M']=$salestax;
			
			// rental 12 month calculation
			$thisraw='12M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='12M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+13){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;
				
				}
			
			}
			$month['12rental'][$i]=$rental;
			$yeardataset[$count]['12rental'][$t.'M']=$rental;
			// rental 24 month calculation
			$thisraw='24M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='24M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+25){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;
				
				}
			
			}
			$month['24rental'][$i]=$rental;
			$yeardataset[$count]['24rental'][$t.'M']=$rental;
			// rental 36 month calculation

			$thisraw='36M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='36M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+37){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;
				
				}
			
			}
			$month['36rental'][$i]=$rental;
			$yeardataset[$count]['36rental'][$t.'M']=$rental;
			// rental 48 month calculation
			$thisraw='48M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='48M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+49){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;
				
				}
			
			}
			$month['48rental'][$i]=$rental;
			$yeardataset[$count]['48rental'][$t.'M']=$rental;
			// rental 60 month calculation
			$thisraw='60M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='60M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+61){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;
				
				}
			
			}
			$month['60rental'][$i]=$rental;
			$yeardataset[$count]['60rental'][$t.'M']=$rental;
			//Monthly Interest Calculation
			$M12='12M';$M24='24M';$M36='36M';$M48='48M';$M60='60M';$M72='72M';$M84='84M';$M96='96M';
			$yeardataset[$count]['12interest'][$t.'M']=$month['12interest'][$i]=$month['12rental'][$i]*$easylist['Income %']->$M12;
			$yeardataset[$count]['24interest'][$t.'M']=$month['24interest'][$i]=$month['24rental'][$i]*$easylist['Income %']->$M24;
			$yeardataset[$count]['36interest'][$t.'M']=$month['36interest'][$i]=$month['36rental'][$i]*$easylist['Income %']->$M36;
			$yeardataset[$count]['48interest'][$t.'M']=$month['48interest'][$i]=$month['48rental'][$i]*$easylist['Income %']->$M48;
			$yeardataset[$count]['60interest'][$t.'M']=$month['60interest'][$i]=$month['60rental'][$i]*$easylist['Income %']->$M60;
			$month['interesttot'][$i]=$month['12interest'][$i]+$month['24interest'][$i]+$month['36interest'][$i]+$month['48interest'][$i]+$month['60interest'][$i];
			$yeardataset[$count]['interesttot'][$t.'M']=$month['interesttot'][$i];
			//total Monthly Rental Calculation
			$month['rentaltot'][$i]=$month['60rental'][$i]+$month['48rental'][$i]+$month['36rental'][$i]+$month['24rental'][$i]+$month['12rental'][$i];      $yeardataset[$count]['rentaltot'][$t.'M']=$month['rentaltot'][$i];
			//Ep Collection Table Data ********************************************************************************************************
			//Ep collection Balance BF
			//$month['epcbalc'][$i]=0;
			if($i==1)$month['epcbalf'][$i]=0;
			else  $month['epcbalf'][$i]=$month['epcbalc'][$i-1];
			$yeardataset[$count]['epcbalf'][$t.'M']=$month['epcbalf'][$i];
			//Ep Current Due
			$month['epccurrentdue'][$i]=$month['rentaltot'][$i];
			$yeardataset[$count]['epccurrentdue'][$t.'M']=$month['epccurrentdue'][$i];
			//Ep Current collection
			$month['epccurrentcollecr'][$i]=$pridata->epsales*$month['epccurrentdue'][$i]/100;
			$yeardataset[$count]['epccurrentcollecr'][$t.'M']=$month['epccurrentcollecr'][$i];
			//Ep Dr collection
			if($i<4)
			$month['epcdrcollecr'][$i]=$pridata->outright*$month['epcbalf'][$i]/100;
			else
			$month['epcdrcollecr'][$i]=$pridata->outright*$month['epcbalf'][$i]/100;
			$yeardataset[$count]['epcdrcollecr'][$t.'M']=$month['epcdrcollecr'][$i];
			//Ep Dr totcollection
			$month['epctot'][$i]=$month['epccurrentcollecr'][$i]+$month['epcdrcollecr'][$i];
			$yeardataset[$count]['epctot'][$t.'M']=$month['epctot'][$i];
			//Ep Closing Balance
			$month['epcbalc'][$i]=$month['epcbalf'][$i]+$month['epccurrentdue'][$i]-$month['epctot'][$i];
			$yeardataset[$count]['epcbalc'][$t.'M']=$month['epcbalc'][$i];
			//Ep Stock table Data Calculation**********************************************************************************************
			//EPS Ballence bf eps
			if($i==1)$month['epsbalf'][$i]=0;
			else  $month['epsbalf'][$i]=$month['epsbalc'][$i-1];
			$yeardataset[$count]['epsbalf'][$t.'M']=$month['epsbalf'][$i];
			//EPS Investment
			 $month['epsinv'][$i]=($masterdata->total_sale*$month['sales'][$i]/100)-$month['outright'][$i]-$month['epdp'][$i];
			 $yeardataset[$count]['epsinv'][$t.'M']=$month['epsinv'][$i];
			 //EPS Investment stock Deplection 
			  $month['epsdeple'][$i]=$month['rentaltot'][$i]-$month['interesttot'][$i];
			  $yeardataset[$count]['epsdeple'][$t.'M']=$month['epsdeple'][$i];
			 $yeardataset[$count]['epsbalc'][$t.'M']=$month['epsbalc'][$i]=$month['epsbalf'][$i]+$month['epsinv'][$i]-$month['epsdeple'][$i];
			  
			//funcding Table calculation*********************************************************************************************************
			//opening balance
			if($i==1)$month['fundbalf'][$i]=0;
			else  $month['fundbalf'][$i]=$month['fundbalc'][$i-1];
			$yeardataset[$count]['fundbalf'][$t.'M']=$month['fundbalf'][$i];
			// monthly reciept calculation
			if($i<=12) $month['fundrecipt'][$i]=$bankloan[$i]; else $month['fundrecipt'][$i]=0;
			$yeardataset[$count]['fundrecipt'][$t.'M']=$month['fundrecipt'][$i];
			// monthly repayment calculation
			//echo $i.'***'.$month['cashflowbalf'][$i].'<br>';
			if($i==1){$month['fundrepayment'][$i]=0;}
			else {
				//echo $i.'***'.$month['cashbalc'][$i-1].'<br>';
				if($month['cashbalc'][$i-1]>0) {
					//echo $month['cashflowbalf'][$i-1];
					if($month['fundbalc'][$i-1]>$month['cashbalc'][$i-1])
					$month['fundrepayment'][$i]=$month['cashbalc'][$i-1];
					else
					$month['fundrepayment'][$i]=$month['fundbalc'][$i-1];
				}
				else $month['fundrepayment'][$i]=0;
			}
			$yeardataset[$count]['fundrepayment'][$t.'M']= $month['fundrepayment'][$i];
			//monthly Closing Balance Calculation
			$month['fundbalc'][$i]=$month['fundbalf'][$i]+$month['fundrecipt'][$i]-$month['fundrepayment'][$i];
			$yeardataset[$count]['fundbalc'][$t.'M']= $month['fundbalc'][$i];
			
			// inflow calculation****************************************************************************************************************
			$yeardataset[$count]['inflowlbloans'][$t.'M']=$month['inflowlbloans'][$i]=$month['fundrecipt'][$i];
			$yeardataset[$count]['infloworsales'][$t.'M']=$month['infloworsales'][$i]=$month['outright'][$i];
			$yeardataset[$count]['inflowepdp'][$t.'M']=$month['inflowepdp'][$i]=$month['epdp'][$i];
			$yeardataset[$count]['inflowrental'][$t.'M']=$month['inflowrental'][$i]=$month['epctot'][$i];
			$yeardataset[$count]['inflowother'][$t.'M']=$month['inflowother'][$i]=0;
			$yeardataset[$count]['inflowtot'][$t.'M']=$month['inflowtot'][$i]=$month['inflowlbloans'][$i]+$month['infloworsales'][$i]+$month['inflowepdp'][$i]+$month['inflowrental'][$i]+$month['inflowother'][$i];
		
			// outfloaw calculation*************************************************************************************************
			if($i<=12)$month['outflowprjx'][$i]=$rawtot[$i];else $month['outflowprjx'][$i]=0;
			$yeardataset[$count]['outflowprjx'][$t.'M']=$month['outflowprjx'][$i];
			$yeardataset[$count]['outflowbloanset'][$t.'M']=$month['outflowbloanset'][$i]=$month['fundrepayment'][$i];
			$yeardataset[$count]['outflowlbloanint'][$t.'M']=$month['outflowlbloanint'][$i]=$pridata->land_bank*$month['fundbalf'][$i]/1200;
			$yeardataset[$count]['outflowsalestax'][$t.'M']=$month['outflowsalestax'][$i]=$month['salestax'][$i];
			$yeardataset[$count]['outflowother'][$t.'M']=$month['outflowother'][$i]=0;
			$yeardataset[$count]['outflowtot'][$t.'M']=$month['outflowtot'][$i]=$month['outflowprjx'][$i]+$month['outflowbloanset'][$i]+$month['outflowlbloanint'][$i]+$month['outflowsalestax'][$i]+$month['outflowother'][$i];
			
		//cashbalance  calculation************************************************************************************
			if($i==1)$month['cashflowbalf'][$i]=0;
			else  $month['cashflowbalf'][$i]=$month['cashbalc'][$i-1];
			$yeardataset[$count]['cashflowbalf'][$t.'M']=$month['cashflowbalf'][$i];
			$yeardataset[$count]['cashnetflow'][$t.'M']=$month['cashnetflow'][$i]=$month['inflowtot'][$i]-$month['outflowtot'][$i];
			$yeardataset[$count]['cashbalc'][$t.'M']=$month['cashbalc'][$i]=$month['cashflowbalf'][$i]+$month['cashnetflow'][$i];
		//	Interest Expenses
			$yeardataset[$count]['intexpLB'][$t.'M']=$month['intexpLB'][$i]=$month['outflowlbloanint'][$i];
			if($month['cashbalc'][$i]<0)$month['intexpBR'][$i]=-($pridata->branch_rate*$month['cashbalc'][$i])/1200;
			else  $month['intexpBR'][$i]=0;
			$yeardataset[$count]['intexpBR'][$t.'M']= $month['intexpBR'][$i];
		//
		  
		   
			
		}
		$count=1;
		for($i=1;$i<=96; $i++)
		{
			
			$t=$j=$i%12;
			
			$t=$i;
			// interest apoinment table calculation
		 $yeardataset[$count]['inalblbal'][$t.'M']=$month['inalblbal'][$i]=$month['fundbalc'][$i];
		   $yeardataset[$count]['inabfbal'][$t.'M']= $month['inabfbal'][$i]=$month['cashbalc'][$i];
			if($i==1 || $i==96) $month['inarepay'][$i]=0;
			else   $month['inarepay'][$i]=$month['inabfbal'][$i]-$month['outflowbloanset'][$i+1];
			 $yeardataset[$count]['inarepay'][$t.'M']=$month['inarepay'][$i];
			 $yeardataset[$count]['inastockbal'][$t.'M']=$month['inastockbal'][$i]=$month['epsbalc'][$i];
			 // Stock funded lbl inalblbal
			 if($month['inastockbal'][$i]>0)
			 {
				 if($month['inalblbal'][$i]>0)
				 {
					 if($month['inastockbal'][$i]<$month['inalblbal'][$i])  $month['inasfundedLBL'][$i]=$month['inastockbal'][$i];
					 else $month['inasfundedLBL'][$i]=$month['inalblbal'][$i];
				 }
				 else  $month['inasfundedLBL'][$i]=0;
			 }
			  else  $month['inasfundedLBL'][$i]=0;
			   $yeardataset[$count]['inasfundedLBL'][$t.'M']=$month['inasfundedLBL'][$i];
			   // Stock Funded BF inasfundedBF
			    if($month['inastockbal'][$i]>0)
				{
					if($month['inasfundedLBL'][$i]<$month['inastockbal'][$i])
					{
						if($month['inarepay'][$i]<($month['inastockbal'][$i]-$month['inasfundedLBL'][$i]))
						$month['inasfundedBF'][$i]=$month['inastockbal'][$i]-$month['inasfundedLBL'][$i]-$month['inarepay'][$i];
						else
						$month['inasfundedBF'][$i]=0;
					}
					else
						$month['inasfundedBF'][$i]=0;
				}
				else
						$month['inasfundedBF'][$i]=0;
						 $yeardataset[$count]['inasfundedBF'][$t.'M']=$month['inasfundedBF'][$i];
			   // Stock Funded BF inasfundedBF
			    $yeardataset[$count]['inasfundedRED'][$t.'M']=$month['inasfundedRED'][$i]=$month['inalblbal'][$i]- $month['inasfundedLBL'][$i];
				//inasfundedEP,inasfundedRED,inasfundedBFI
				//LBLI  on EP
				if($month['inasfundedLBL'][$i]>0)$month['lbliEP'][$i]=$month['inasfundedLBL'][$i]*$pridata->land_bank/1200;
				else $month['lbliEP'][$i]=0;
				 $yeardataset[$count]['lbliEP'][$t.'M']= $month['lbliEP'][$i];
				 //LBLI on RED
				 if($month['inasfundedRED'][$i]>0)$month['lbliRED'][$i]=$month['inasfundedRED'][$i]*$pridata->land_bank/1200;
				else $month['lbliRED'][$i]=0;
				 $yeardataset[$count]['lbliRED'][$t.'M']= $month['lbliRED'][$i];
				 //BFI ON EP
				  if($month['inasfundedBF'][$i]>0)$month['lbliBFI'][$i]=$month['inasfundedBF'][$i]*$pridata->branch_rate/1200;
				else $month['lbliBFI'][$i]=0;
				 $yeardataset[$count]['lbliBFI'][$t.'M']= $month['lbliBFI'][$i];
				 
		}
		$this->hm_feasibility_model->delete_monthlycash($prj_id);
		$t=1;
			$year=array('year'=>$t);
			$data[1]=array_merge(array_merge($mynames[1],$year), $yeardataset[$t]['outright']);
			$data[2]=array_merge(array_merge($mynames[2],$year), $yeardataset[$t]['epdp']);
			$data[3]=array_merge(array_merge($mynames[3],$year), $yeardataset[$t]['epsales']);
			$data[4]=array_merge(array_merge($mynames[4],$year), $yeardataset[$t]['salestax']);
			$data[5]=array_merge(array_merge($mynames[5],$year), $yeardataset[$t]['12rental']);
			$data[6]=array_merge(array_merge($mynames[6],$year), $yeardataset[$t]['24rental']);
			$data[7]=array_merge(array_merge($mynames[7],$year), $yeardataset[$t]['36rental']);
			$data[8]=array_merge(array_merge($mynames[8],$year), $yeardataset[$t]['48rental']);
			$data[9]=array_merge(array_merge($mynames[9],$year), $yeardataset[$t]['60rental']);
			$data[10]=array_merge(array_merge($mynames[10],$year), $yeardataset[$t]['rentaltot']);
			$data[11]=array_merge(array_merge($mynames[11],$year), $yeardataset[$t]['epcbalf']);
			$data[12]=array_merge(array_merge($mynames[12],$year), $yeardataset[$t]['epccurrentdue']);
			$data[13]=array_merge(array_merge($mynames[13],$year), $yeardataset[$t]['epccurrentcollecr']);
			$data[14]=array_merge(array_merge($mynames[14],$year), $yeardataset[$t]['epcdrcollecr']);
			$data[15]=array_merge(array_merge($mynames[15],$year), $yeardataset[$t]['epctot']);
			$data[16]=array_merge(array_merge($mynames[16],$year), $yeardataset[$t]['epcbalc']);
			$data[17]=array_merge(array_merge($mynames[17],$year), $yeardataset[$t]['epsbalf']);
			$data[18]=array_merge(array_merge($mynames[18],$year), $yeardataset[$t]['epsinv']);
			$data[19]=array_merge(array_merge($mynames[19],$year), $yeardataset[$t]['epsdeple']);
			$data[20]=array_merge(array_merge($mynames[20],$year), $yeardataset[$t]['epsbalc']);
			$data[21]=array_merge(array_merge($mynames[21],$year), $yeardataset[$t]['12interest']);
			$data[22]=array_merge(array_merge($mynames[22],$year), $yeardataset[$t]['24interest']);
			$data[23]=array_merge(array_merge($mynames[23],$year), $yeardataset[$t]['36interest']);
			$data[24]=array_merge(array_merge($mynames[24],$year), $yeardataset[$t]['48interest']);
			$data[25]=array_merge(array_merge($mynames[25],$year), $yeardataset[$t]['60interest']);
			$data[26]=array_merge(array_merge($mynames[26],$year), $yeardataset[$t]['interesttot']);
			$data[27]=array_merge(array_merge($mynames[27],$year), $yeardataset[$t]['fundbalf']);
			$data[28]=array_merge(array_merge($mynames[28],$year), $yeardataset[$t]['fundrecipt']);
			$data[29]=array_merge(array_merge($mynames[29],$year), $yeardataset[$t]['fundrepayment']);
			$data[30]=array_merge(array_merge($mynames[30],$year), $yeardataset[$t]['fundbalc']);
			$data[31]=array_merge(array_merge($mynames[31],$year), $yeardataset[$t]['inflowlbloans']);
			$data[32]=array_merge(array_merge($mynames[32],$year), $yeardataset[$t]['infloworsales']);
			$data[33]=array_merge(array_merge($mynames[33],$year), $yeardataset[$t]['inflowepdp']);
			$data[34]=array_merge(array_merge($mynames[34],$year), $yeardataset[$t]['inflowrental']);
			$data[35]=array_merge(array_merge($mynames[35],$year), $yeardataset[$t]['inflowother']);
			$data[36]=array_merge(array_merge($mynames[36],$year), $yeardataset[$t]['inflowtot']);
			$data[37]=array_merge(array_merge($mynames[37],$year), $yeardataset[$t]['outflowprjx']);
			$data[38]=array_merge(array_merge($mynames[38],$year), $yeardataset[$t]['outflowbloanset']);
			$data[39]=array_merge(array_merge($mynames[39],$year), $yeardataset[$t]['outflowlbloanint']);
			$data[40]=array_merge(array_merge($mynames[40],$year), $yeardataset[$t]['outflowsalestax']);
			$data[41]=array_merge(array_merge($mynames[41],$year), $yeardataset[$t]['outflowother']);
			$data[42]=array_merge(array_merge($mynames[42],$year), $yeardataset[$t]['outflowtot']);
			$data[43]=array_merge(array_merge($mynames[43],$year), $yeardataset[$t]['cashflowbalf']);
			$data[44]=array_merge(array_merge($mynames[44],$year), $yeardataset[$t]['cashnetflow']);
			$data[45]=array_merge(array_merge($mynames[45],$year), $yeardataset[$t]['cashbalc']);
			$data[46]=array_merge(array_merge($mynames[46],$year), $yeardataset[$t]['intexpLB']);
			$data[47]=array_merge(array_merge($mynames[47],$year), $yeardataset[$t]['intexpBR']);
			$data[48]=array_merge(array_merge($mynames[48],$year), $yeardataset[$t]['inalblbal']);
			$data[49]=array_merge(array_merge($mynames[49],$year), $yeardataset[$t]['inabfbal']);
			$data[50]=array_merge(array_merge($mynames[50],$year), $yeardataset[$t]['inarepay']);
			$data[51]=array_merge(array_merge($mynames[51],$year), $yeardataset[$t]['inastockbal']);
			$data[52]=array_merge(array_merge($mynames[52],$year), $yeardataset[$t]['inasfundedLBL']);
			$data[53]=array_merge(array_merge($mynames[53],$year), $yeardataset[$t]['inasfundedBF']);
			$data[54]=array_merge(array_merge($mynames[54],$year), $yeardataset[$t]['inasfundedRED']);
			$data[55]=array_merge(array_merge($mynames[55],$year), $yeardataset[$t]['lbliEP']);
			$data[56]=array_merge(array_merge($mynames[56],$year), $yeardataset[$t]['lbliRED']);
			$data[57]=array_merge(array_merge($mynames[57],$year), $yeardataset[$t]['lbliBFI']);
			
			$this->hm_feasibility_model->insert_monthlycash($data);
		
		
		
		
	}
	function evaluation_report()
	{ $mynames=NULL; $month=NULL;$yearvalue=NULL; $yeardataset=NULL; $data=NULL;
		$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
		$encode_id=$this->encryption->encode($prj_id);
		if ( ! check_access('view_evereport'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$this->uri->segment(4));
			return;
		}
		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->project_name.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/project/search';
				$data['tag']='Search project';
				$data['product_code']='LNS';
				for($i=1; $i<=12; $i++)
					{$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
						if($bankloan[$i])
						$bankloan[$i]=$bankloan[$i]->amount;
						else $bankloan[$i]=0;
						$rawtot[$i]=0;
						//echo print_r($tasklist);
					}
					//print_r($bankloan);
		$data['bankloan']=$bankloan;
		$data['saleprice']=$this->hm_feasibility_model->get_salesprice_sum($prj_id);
		$data['totdpcost']=$this->hm_feasibility_model->get_developmentcost_sum($prj_id);
		$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
		$data['developmentcost']=$developmentcost=$this->hm_feasibility_model->get_evereport_task($prj_id);	
		$data['eprates']=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
		$data['rentalchart']=$rentalchart=$this->hm_feasibility_model->get_rentalchart($prj_id);	
		$data['monthsales']=$sales=$this->hm_feasibility_model->get_project_sales_time($prj_id);	
		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);
		foreach($developmentcost as $raw) {
			for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;}
		}
		$cashdata=$this->hm_feasibility_model->get_monthcash($prj_id);
		$count=1;
		$mynames[0]=array('name'=>'Sale %',
		'thiskey'=>'sales');
		for($i=1; $i<=96; $i++)
		{
			$month['sales'][$i]=0;
		}
		foreach($sales as $raw)
		{
			$month['sales'][$raw->month]=$raw->percentage;
		}
		foreach($cashdata as $cashraw)
		{
			$mynames[$count]=array('name'=>$cashraw->name,
		'thiskey'=>$cashraw->thiskey);
				for($i=1; $i<=96; $i++)
				{  
					$rawname=$i.'M';
					$month[$cashraw->thiskey][$i]=$cashraw->$rawname;
				}
				$count++;
		}
		foreach($rentalchart as $rentraw)
		$easylist[$rentraw->raw_name]=$rentraw;
		
		$yeardataset=NULL;
		$count=1;
		 for($t=0; $t<count($mynames);$t++){
	   $key=$mynames[$t]['thiskey'];
		$rawtot=0; 
		for($j=1; $j<=8; $j++) 
		{ $thistot=0;
					for($i=1; $i<=12; $i++)
					{ $rawname=$i.'M';
					  $q=12*($j-1)+$i;
					   $thistot=$thistot+$month[$key][$q];
					}
				$yearvalue[$j][$key]=$thistot;	 
		}
 	 }
		
		for($j=1; $j<=8; $j++) {
			if($j==1) 
			{
			  $yearvalue[$j]['epcbalf']=0 ;
			  $yearvalue[$j]['epsbalf']=0;
			   $yearvalue[$j]['fundbalf']=0;
			   $yearvalue[$j]['cashflowbalf']=0;
			  
			}
			else 
			{
			 $yearvalue[$j]['epcbalf']=$yearvalue[$j-1]["epcbalc"];	
			  $yearvalue[$j]['epsbalf']=$yearvalue[$j-1]["epsbalc"];	
			   $yearvalue[$j]['fundbalf']=$yearvalue[$j-1]["fundbalc"];	
			    $yearvalue[$j]['cashflowbalf']=$yearvalue[$j-1]["cashbalc"];	
			}
									
			$yearvalue[$j]['epcbalc']= $yearvalue[$j]['epcbalf']+ $yearvalue[$j]['epccurrentdue']- $yearvalue[$j]['epctot'];
			$yearvalue[$j]['epsbalc']= $yearvalue[$j]['epsbalf']+ $yearvalue[$j]['epsinv']- $yearvalue[$j]['epsdeple'];
			$yearvalue[$j]['fundbalc']= $yearvalue[$j]['fundbalf']+ $yearvalue[$j]['fundrecipt']- $yearvalue[$j]['fundrepayment'];
			$yearvalue[$j]['cashbalc']= $yearvalue[$j]['cashflowbalf']+ $yearvalue[$j]['cashnetflow'];
		
		 						  
		
		}
		$data['fulldataset']=$month;
		$data['yearvalue']=$yearvalue;
		$data['namelist']=$mynames;
		
		
		$this->load->view('hm/feasibility/evaluation_report',$data);
	}
	
	
	public function evaluation()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/');
			return;
		}
		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery_fiesibility($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->project_name.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/project/search';
				$data['tag']='Search project';
				$data['product_code']='LNS';
				
				
				$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('hm/project/showall');
			$config['uri_segment'] = 4;
		
		$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
		$config['num_links'] = 10;
		$config['per_page'] = $pagination_counter;
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
		$startcounter=($page_count)*$pagination_counter;
		$data['datalist']=$this->hm_project_model->get_all_project_details_feasibility($pagination_counter,$page_count,$this->session->userdata('branchid'));
		$config['total_rows'] = $this->db->count_all('hm_projectms');
			//echo $pagination_counter;
		$this->pagination->initialize($config);
			
		//$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('hm/feasibility/report_list',$data);
		
		
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */