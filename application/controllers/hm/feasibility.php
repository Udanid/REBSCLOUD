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
		$this->load->model("common_model");
		$this->load->model("hm_introducer_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_feasibility_model");
		$this->load->model("hm_producttasks_model");
		$this->load->model("hm_dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("hm_config_model");
		$this->load->model("hm_lotdata_model");
			$this->load->model("hm_uploadboq_model");


		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_feasibility'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/feasibility/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_feasibility'))
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
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/feasibility/showall';
				$data['tag']='Search project';
				$data['product_code']='LNS';
				$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
				$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
				$data['valuse_items']=$this->hm_feasibility_model->get_project_valueitems($prj_id);
				$data['dplist']=$dplist=$this->hm_dplevels_model->get_dplevels();
				$data['officerlist']=$this->hm_project_model->get_project_officer_list($this->session->userdata('branchid'));
				$data['land_list']=$this->hm_land_model->get_all_unused_land_summery();
				//$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
				$data['boqlotlist'] = $this->hm_feasibility_model->get_boqunitlots($prj_id);
				 $data['branchlist']=$this->branch_model->get_all_branches_summery();

				 //get boq designs not done units/lots..
				 $data['boqnotdesignunits'] = $this->hm_feasibility_model->boq_not_design_units($prj_id);
				$maintaskdata=NULL;
				$prjduration=$pridata->period;
				$timechart=NULL;
				$tasklist=$this->hm_config_model->get_hmtask_all('Common');
				if($tasklist)
				{
					foreach($tasklist as $raw)
					{
						$maintaskdata[$raw->task_id]['maintask']=$this->hm_feasibility_model->get_project_maintask_forentry($prj_id,$raw->task_id);

						//$maintaskdata[$raw->task_id]['prjsubtask']=$this->hm_feasibility_model->get_project_subtask($prj_id,$raw->task_id);
						//$maintaskdata[$raw->task_id]['subtask']=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);

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
					for($i=1; $i<=12; $i++)
					{
						$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
						//echo print_r($tasklist);
					}
					$data['bankloan']=$bankloan;
				$data['salestime']=$salestime;
				$data['fsbstatus']=$this->hm_feasibility_model->get_fesibilitystatus($prj_id);

				//2019-11-08 nadee
				$data['development_type']=$this->hm_feasibility_model->get_development_type();
				$data['prj_type']=$this->hm_feasibility_model->get_prj_type();
				$data['design_type']=$design_type=$this->hm_feasibility_model->get_designtypes_all_haveboq();
				$data['unit_design']=$unit_design=$this->hm_feasibility_model->get_unit_details($prj_id);
				//$sub_cat_data_boq=Null;
				 //foreach ($unit_design as $diskey => $disvalue) {
				 	//$sub_cat_data_boq[$disvalue->lot_id]=$this->hm_config_model->get_subboq_all_bytask($disvalue->design_id);
				 //}
				 //$data['sub_cat_data_boq']=$sub_cat_data_boq;
				//2020_01_06 updated.

				//$data['common_task']=$this->hm_config_model->get_hmtask_all('Common');

				//2019-11-08 terance
				/* show boqitems */
				$data['sub_cat_data']=$sub_cat_data=$this->hm_config_model->get_subboq_all();
				//$data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_config_model->get_subboq_all_bytask('1');
				$data['hmtask']=$hmtask=$this->hm_config_model->get_hmtask_all('BOQ');
				$data['tot_budget']=$tot_budget=$this->hm_feasibility_model->get_total_budget($prj_id);
				//$boq_data=Null;
				//foreach ($sub_cat_data_boq as $key => $value) {
					//$boq_data[$value->boqsubcat_id]=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
				//}
				//$data['datalist']=$boq_data;
				/* show boqitems */
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
		//$create_boqs=$this->add_unitboq($prj_id);
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
		//$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
		$tasklist=$this->hm_config_model->get_hmtask_all('Common');
		$maintaskdata=NULL;
				if($tasklist)
				{
					foreach($tasklist as $raw)
					{
					$this->hm_feasibility_model->add_budgut_task($prj_id,$raw->task_id,$this->input->post('total'.$raw->task_id));
					$this->hm_feasibility_model->update_prjpayment($prj_id,$raw->task_id,$this->input->post('total'.$raw->task_id));
						// $sublist=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);
						// if($sublist)
						// {
						// 	foreach($sublist as $subraw)
						// 	{
						// 		if($this->input->post('amount'.$subraw->subtask_id)>0)
						// 		{
						// 			$this->hm_feasibility_model->add_budgut_subtask($prj_id,$raw->task_id,$this->input->post('amount'.$subraw->subtask_id),$subraw->subtask_id);
						// 			//echo $this->input->post('amount'.$subraw->subtask_id);
						// 		}
						// 	}
						// }2019-11-11 comment by nadee
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
				for($i=1; $i<=6; $i++){
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
		$count=$this->input->post('num_of_unit');
		$this->hm_feasibility_model->delete_price($prj_id);
		for($i=1; $i<=$count; $i++)
		{
			if($this->input->post('unit_name'.$i))
			{
				$this->hm_feasibility_model->add_price($prj_id,$this->input->post('unit_id'.$i),$this->input->post('tot'.$i));
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
		$tasklist=$this->hm_config_model->get_hmtask_all('Common');
		//$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
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
		if($this->hm_feasibility_model->get_lastupdate($prj_id))
		{
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
			$this->common_model->add_notification('hm_projectms','Projects','hm/feasibility/evaluation',$prj_id);
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
		$mynames[10]=array('prj_id'=>$prj_id,'name'=>'Rental 72M',
		'thiskey'=>'72rental');
		$mynames[11]=array('prj_id'=>$prj_id,'name'=>'Rental 84M',
		'thiskey'=>'84rental');
		$mynames[12]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'rentaltot');

		//epcbalf,epccurrentdue,epccurrentcollecr,epcdrcollecr,epctot,epcbalc
		$mynames[13]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'epcbalf');
		$mynames[14]=array('prj_id'=>$prj_id,'name'=>'Current Due',
		'thiskey'=>'epccurrentdue');
		$mynames[15]=array('prj_id'=>$prj_id,'name'=>'Curr. Collection',
		'thiskey'=>'epccurrentcollecr');
		$mynames[16]=array('prj_id'=>$prj_id,'name'=>'DrCollection',
		'thiskey'=>'epcdrcollecr');
		$mynames[17]=array('prj_id'=>$prj_id,'name'=>'Total Collection',
		'thiskey'=>'epctot');
		$mynames[18]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'epcbalc');
		//epsbalf,epsinv,epsdeple,epsbalc
		$mynames[19]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'epsbalf');
		$mynames[20]=array('prj_id'=>$prj_id,'name'=>'E/P Investment',
		'thiskey'=>'epsinv');
		$mynames[21]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Depletion',
		'thiskey'=>'epsdeple');
		$mynames[22]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'epsbalc');
//epinterest*****************************************

		$mynames[23]=array('prj_id'=>$prj_id,'name'=>'E/P Int 12M',
		'thiskey'=>'12interest');
		$mynames[24]=array('prj_id'=>$prj_id,'name'=>'E/P Int 24M',
		'thiskey'=>'24interest');
		$mynames[25]=array('prj_id'=>$prj_id,'name'=>'E/P Int 36M',
		'thiskey'=>'36interest');
		$mynames[26]=array('prj_id'=>$prj_id,'name'=>'E/P Int 48M',
		'thiskey'=>'48interest');
		$mynames[27]=array('prj_id'=>$prj_id,'name'=>'E/P Int 60M',
		'thiskey'=>'60interest');
		$mynames[28]=array('prj_id'=>$prj_id,'name'=>'E/P Int 72M',
		'thiskey'=>'72interest');
		$mynames[29]=array('prj_id'=>$prj_id,'name'=>'E/P Int 84M',
		'thiskey'=>'84interest');
		$mynames[30]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'interesttot');

		$mynames[31]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'fundbalf');
		$mynames[32]=array('prj_id'=>$prj_id,'name'=>'Receipts',
		'thiskey'=>'fundrecipt');
		$mynames[33]=array('prj_id'=>$prj_id,'name'=>'Repayments',
		'thiskey'=>'fundrepayment');
		$mynames[34]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'fundbalc');

		$mynames[35]=array('prj_id'=>$prj_id,'name'=>'L/B Loans',
		'thiskey'=>'inflowlbloans');
		$mynames[36]=array('prj_id'=>$prj_id,'name'=>'O/R Sales',
		'thiskey'=>'infloworsales');
		$mynames[37]=array('prj_id'=>$prj_id,'name'=>'E/P D/P',
		'thiskey'=>'inflowepdp');
		$mynames[38]=array('prj_id'=>$prj_id,'name'=>'Rentals',
		'thiskey'=>'inflowrental');
		$mynames[39]=array('prj_id'=>$prj_id,'name'=>'Other',
		'thiskey'=>'inflowother');
		$mynames[40]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'inflowtot');
		//outflowprjx,,,,,outflowtot,cashflowbalf,cashnetflow,cashbalc

		$mynames[41]=array('prj_id'=>$prj_id,'name'=>'Project Ex',
		'thiskey'=>'outflowprjx');
		$mynames[42]=array('prj_id'=>$prj_id,'name'=>'L/B Loan Settl',
		'thiskey'=>'outflowbloanset');
		$mynames[43]=array('prj_id'=>$prj_id,'name'=>'L/B Loan Int. - (LBLI)',
		'thiskey'=>'outflowlbloanint');
		$mynames[44]=array('prj_id'=>$prj_id,'name'=>'Sales Tax',
		'thiskey'=>'outflowsalestax');
		$mynames[45]=array('prj_id'=>$prj_id,'name'=>'Other',
		'thiskey'=>'outflowother');
		$mynames[46]=array('prj_id'=>$prj_id,'name'=>'Total',
		'thiskey'=>'outflowtot');
		//outflowprjx,,,,,outflowtot,,,
		$mynames[47]=array('prj_id'=>$prj_id,'name'=>'Bal B/F',
		'thiskey'=>'cashflowbalf');
		$mynames[48]=array('prj_id'=>$prj_id,'name'=>'Net  Inflow',
		'thiskey'=>'cashnetflow');
		$mynames[49]=array('prj_id'=>$prj_id,'name'=>'Bal C/F',
		'thiskey'=>'cashbalc');

		//,
		$mynames[50]=array('prj_id'=>$prj_id,'name'=>'L/B Interest - (LBLI)',
		'thiskey'=>'intexpLB');
		$mynames[51]=array('prj_id'=>$prj_id,'name'=>'Br Fund Interest - (BFI)',
		'thiskey'=>'intexpBR');
		// //inalblbal,inabfbal,inarepay
		$mynames[52]=array('prj_id'=>$prj_id,'name'=>'L/B Loan Balance (LBL Bal)',
		'thiskey'=>'inalblbal');
		$mynames[53]=array('prj_id'=>$prj_id,'name'=>'Br.Fund Balance  (BF Bal)',
		'thiskey'=>'inabfbal');
		$mynames[54]=array('prj_id'=>$prj_id,'name'=>'BFBal.Net of LBL Repayt.   ',
		'thiskey'=>'inarepay');
		$mynames[55]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Balance   ',
		'thiskey'=>'inastockbal');
		$mynames[56]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Funded by LBL   ',
		'thiskey'=>'inasfundedLBL');
		$mynames[57]=array('prj_id'=>$prj_id,'name'=>'E/P Stock Funded by BR  ',
		'thiskey'=>'inasfundedBF');
		$mynames[58]=array('prj_id'=>$prj_id,'name'=>'RED Funded by LBL',
		'thiskey'=>'inasfundedRED');
		$mynames[59]=array('prj_id'=>$prj_id,'name'=>'LBLI on E/P',
		'thiskey'=>'lbliEP');
		$mynames[60]=array('prj_id'=>$prj_id,'name'=>'LBLI on RED',
		'thiskey'=>'lbliRED');
		$mynames[61]=array('prj_id'=>$prj_id,'name'=>'BFI on E/P',
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
			// rental 72 month calculation
			$thisraw='72M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='72M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+73){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;

				}

			}
			$month['72rental'][$i]=$rental;
			$yeardataset[$count]['72rental'][$t.'M']=$rental;
			// rental 84 month calculation
			$thisraw='84M';
			$rental=0;
			if($i>1){
				///echo $i ."ssss";
				$thisraw='84M';
				$rental=0;
				$myrentarr=NULL;
				for($k=$i-1; $k>=1; $k--){
					if($i<($i-$k)+85){
					 $rental=$rental+$easylist['Net Rental']->$thisraw*$month['sales'][$i-$k]/100;}
					 else $rental=0;

				}

			}
			$month['84rental'][$i]=$rental;
			$yeardataset[$count]['84rental'][$t.'M']=$rental;
			//Monthly Interest Calculation
			$M12='12M';$M24='24M';$M36='36M';$M48='48M';$M60='60M';$M72='72M';$M84='84M';$M96='96M';
			$yeardataset[$count]['12interest'][$t.'M']=$month['12interest'][$i]=$month['12rental'][$i]*$easylist['Income %']->$M12;
			$yeardataset[$count]['24interest'][$t.'M']=$month['24interest'][$i]=$month['24rental'][$i]*$easylist['Income %']->$M24;
			$yeardataset[$count]['36interest'][$t.'M']=$month['36interest'][$i]=$month['36rental'][$i]*$easylist['Income %']->$M36;
			$yeardataset[$count]['48interest'][$t.'M']=$month['48interest'][$i]=$month['48rental'][$i]*$easylist['Income %']->$M48;
			$yeardataset[$count]['60interest'][$t.'M']=$month['60interest'][$i]=$month['60rental'][$i]*$easylist['Income %']->$M60;
			$yeardataset[$count]['72interest'][$t.'M']=$month['72interest'][$i]=$month['72rental'][$i]*$easylist['Income %']->$M72;
			$yeardataset[$count]['84interest'][$t.'M']=$month['84interest'][$i]=$month['84rental'][$i]*$easylist['Income %']->$M84;
			$month['interesttot'][$i]=$month['12interest'][$i]+$month['24interest'][$i]+$month['36interest'][$i]+$month['48interest'][$i]+$month['60interest'][$i]+$month['72interest'][$i]+$month['84interest'][$i];;
			$yeardataset[$count]['interesttot'][$t.'M']=$month['interesttot'][$i];
			//total Monthly Rental Calculation
			$month['rentaltot'][$i]=$month['84rental'][$i]+$month['72rental'][$i]+$month['60rental'][$i]+$month['48rental'][$i]+$month['36rental'][$i]+$month['24rental'][$i]+$month['12rental'][$i];      $yeardataset[$count]['rentaltot'][$t.'M']=$month['rentaltot'][$i];
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
			if($i==3)
			$month['epccurrentcollecr'][$i]=$pridata->land_bank*$month['epccurrentdue'][$i]/100;
			else
			$month['epccurrentcollecr'][$i]=$pridata->land_bank*$month['epccurrentdue'][$i]/100;
			$yeardataset[$count]['epccurrentcollecr'][$t.'M']=$month['epccurrentcollecr'][$i];
			//Ep Dr collection
			if($i<4)
			$month['epcdrcollecr'][$i]=$pridata->other_rate*$month['epcbalf'][$i]/100;
			else
			$month['epcdrcollecr'][$i]=$pridata->other_rate*$month['epcbalf'][$i]/100;
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
			$data[10]=array_merge(array_merge($mynames[10],$year), $yeardataset[$t]['72rental']);
			$data[11]=array_merge(array_merge($mynames[11],$year), $yeardataset[$t]['84rental']);
			$data[12]=array_merge(array_merge($mynames[12],$year), $yeardataset[$t]['rentaltot']);
			$data[13]=array_merge(array_merge($mynames[13],$year), $yeardataset[$t]['epcbalf']);
			$data[14]=array_merge(array_merge($mynames[14],$year), $yeardataset[$t]['epccurrentdue']);
			$data[15]=array_merge(array_merge($mynames[15],$year), $yeardataset[$t]['epccurrentcollecr']);
			$data[16]=array_merge(array_merge($mynames[16],$year), $yeardataset[$t]['epcdrcollecr']);
			$data[17]=array_merge(array_merge($mynames[17],$year), $yeardataset[$t]['epctot']);
			$data[18]=array_merge(array_merge($mynames[18],$year), $yeardataset[$t]['epcbalc']);
			$data[19]=array_merge(array_merge($mynames[19],$year), $yeardataset[$t]['epsbalf']);
			$data[20]=array_merge(array_merge($mynames[20],$year), $yeardataset[$t]['epsinv']);
			$data[21]=array_merge(array_merge($mynames[21],$year), $yeardataset[$t]['epsdeple']);
			$data[22]=array_merge(array_merge($mynames[22],$year), $yeardataset[$t]['epsbalc']);
			$data[23]=array_merge(array_merge($mynames[23],$year), $yeardataset[$t]['12interest']);
			$data[24]=array_merge(array_merge($mynames[24],$year), $yeardataset[$t]['24interest']);
			$data[25]=array_merge(array_merge($mynames[25],$year), $yeardataset[$t]['36interest']);
			$data[26]=array_merge(array_merge($mynames[26],$year), $yeardataset[$t]['48interest']);
			$data[27]=array_merge(array_merge($mynames[27],$year), $yeardataset[$t]['60interest']);
			$data[28]=array_merge(array_merge($mynames[28],$year), $yeardataset[$t]['72interest']);
			$data[29]=array_merge(array_merge($mynames[29],$year), $yeardataset[$t]['84interest']);
			$data[30]=array_merge(array_merge($mynames[30],$year), $yeardataset[$t]['interesttot']);
			$data[31]=array_merge(array_merge($mynames[31],$year), $yeardataset[$t]['fundbalf']);
			$data[32]=array_merge(array_merge($mynames[32],$year), $yeardataset[$t]['fundrecipt']);
			$data[33]=array_merge(array_merge($mynames[33],$year), $yeardataset[$t]['fundrepayment']);
			$data[34]=array_merge(array_merge($mynames[34],$year), $yeardataset[$t]['fundbalc']);
			$data[35]=array_merge(array_merge($mynames[35],$year), $yeardataset[$t]['inflowlbloans']);
			$data[36]=array_merge(array_merge($mynames[36],$year), $yeardataset[$t]['infloworsales']);
			$data[37]=array_merge(array_merge($mynames[37],$year), $yeardataset[$t]['inflowepdp']);
			$data[38]=array_merge(array_merge($mynames[38],$year), $yeardataset[$t]['inflowrental']);
			$data[39]=array_merge(array_merge($mynames[39],$year), $yeardataset[$t]['inflowother']);
			$data[40]=array_merge(array_merge($mynames[40],$year), $yeardataset[$t]['inflowtot']);
			$data[41]=array_merge(array_merge($mynames[41],$year), $yeardataset[$t]['outflowprjx']);
			$data[42]=array_merge(array_merge($mynames[42],$year), $yeardataset[$t]['outflowbloanset']);
			$data[43]=array_merge(array_merge($mynames[43],$year), $yeardataset[$t]['outflowlbloanint']);
			$data[44]=array_merge(array_merge($mynames[44],$year), $yeardataset[$t]['outflowsalestax']);
			$data[45]=array_merge(array_merge($mynames[45],$year), $yeardataset[$t]['outflowother']);
			$data[46]=array_merge(array_merge($mynames[46],$year), $yeardataset[$t]['outflowtot']);
			$data[47]=array_merge(array_merge($mynames[47],$year), $yeardataset[$t]['cashflowbalf']);
			$data[48]=array_merge(array_merge($mynames[48],$year), $yeardataset[$t]['cashnetflow']);
			$data[49]=array_merge(array_merge($mynames[49],$year), $yeardataset[$t]['cashbalc']);
			$data[50]=array_merge(array_merge($mynames[50],$year), $yeardataset[$t]['intexpLB']);
			$data[51]=array_merge(array_merge($mynames[51],$year), $yeardataset[$t]['intexpBR']);
			$data[52]=array_merge(array_merge($mynames[52],$year), $yeardataset[$t]['inalblbal']);
			$data[53]=array_merge(array_merge($mynames[53],$year), $yeardataset[$t]['inabfbal']);
			$data[54]=array_merge(array_merge($mynames[54],$year), $yeardataset[$t]['inarepay']);
			$data[55]=array_merge(array_merge($mynames[55],$year), $yeardataset[$t]['inastockbal']);
			$data[56]=array_merge(array_merge($mynames[56],$year), $yeardataset[$t]['inasfundedLBL']);
			$data[57]=array_merge(array_merge($mynames[57],$year), $yeardataset[$t]['inasfundedBF']);
			$data[58]=array_merge(array_merge($mynames[58],$year), $yeardataset[$t]['inasfundedRED']);
			$data[59]=array_merge(array_merge($mynames[59],$year), $yeardataset[$t]['lbliEP']);
			$data[60]=array_merge(array_merge($mynames[60],$year), $yeardataset[$t]['lbliRED']);
			$data[61]=array_merge(array_merge($mynames[61],$year), $yeardataset[$t]['lbliBFI']);

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
		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery_fiesibility($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/feasibility/evaluation_report';
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
		//odiliya modification	
		$data['dpcost_only']=$this->hm_feasibility_model->dpcost_only($prj_id);
		$data['purchascost_only']=$this->hm_feasibility_model->purchasing_price_only($prj_id);
		$data['costofcapital']=$this->hm_feasibility_model->purchasing_cost_of_capital($prj_id);
		$data['marketing_commision']=$this->hm_feasibility_model->marketing_commission($prj_id);
		//end odiliya modification
		$data['developmentcost']=$developmentcost=$this->hm_feasibility_model->get_evereport_task($prj_id);
		$data['eprates']=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
		$data['rentalchart']=$rentalchart=$this->hm_feasibility_model->get_rentalchart($prj_id);
		$data['monthsales']=$sales=$this->hm_feasibility_model->get_project_sales_time($prj_id);
		//get total unit boqs..
		$data['totalunitboq'] = $this->hm_feasibility_model->get_total_unit_boq($prj_id);
		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);


		if($developmentcost){
		foreach($developmentcost as $raw) {
			for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;}
		}}
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
		if ( ! check_access('view_evereport'))
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
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/feasibility/evaluation_report';
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

		public function confirm()
	{
		if ( ! check_access('confirm_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/showall');
			return;
		}
		$dproject=$this->uri->segment(4);
		$encode_id=$this->encryption->encode($dproject);
		//$prj_id=$this->encryption->decode($this->uri->segment(4));
		$prj_id=$dproject;
		//echo $prj_id;
		$id=$this->hm_project_model->confirm($prj_id);


		if($id)
		{
			//$this->add_acboq($prj_id);//2019-11-22 updated by nadee

			$this->add_floors($prj_id);//2019-11-22 updated by nadee

			$this->hm_feasibility_model->add_ledger($prj_id);//2019-11-22 updated by nadee

		$this->common_model->delete_notification('hm_projectms',$prj_id);
		$this->session->set_flashdata('msg', 'project Successfully Confirmed ');
		$this->logger->write_message("success", '  project id successfully Confirmed');
		}
		else
		{
			$this->session->set_flashdata('error', 'Error entering Entires ');
		//$this->logger->write_message("success", $this->uri->segment(4).'  project id successfully Confirmed');
		}
		redirect("hm/feasibility/showall/".$encode_id);

	}
		public function delete()
	{
		if ( ! check_access('delete_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall');
			return;
		}
		//$id=$this->hm_project_model->delete($this->uri->segment(4));

	//	$this->common_model->delete_notification('hm_projectms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'project Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' project id successfully Deleted');
		redirect("hm/feasibility/evaluation");

	}
// function print_report()
// 	{ $mynames=NULL; $month=NULL;$yearvalue=NULL; $yeardataset=NULL; $data=NULL;
// 		$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
// 		$encode_id=$this->encryption->encode($prj_id);
// 		if ( ! check_access('view_evereport'))
// 		{
//
// 			$this->session->set_flashdata('error', 'Permission Denied');
// 			redirect('hm/feasibility/showall/'.$this->uri->segment(4));
// 			return;
// 		}
// 		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery_fiesibility($this->session->userdata('branchid'));
// 				$courseSelectList="";
// 				 $count=0;
// 				foreach($inventory as $c)
//       			  {
//            			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
//            			 $count++;
//        			 }
// 				$data['searchlist']=$courseSelectList;
// 				$data['searchpath']='hm/feasibility/evaluation_report';
// 				$data['tag']='Search project';
// 				$data['product_code']='LNS';
// 				for($i=1; $i<=12; $i++)
// 					{$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
// 						if($bankloan[$i])
// 						$bankloan[$i]=$bankloan[$i]->amount;
// 						else $bankloan[$i]=0;
// 						$rawtot[$i]=0;
// 						//echo print_r($tasklist);
// 					}
// 					//print_r($bankloan);
// 		$data['bankloan']=$bankloan;
// 		$data['saleprice']=$this->hm_feasibility_model->get_salesprice_sum($prj_id);
// 		$data['totdpcost']=$this->hm_feasibility_model->get_developmentcost_sum($prj_id);
// 		$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
// 		$data['developmentcost']=$developmentcost=$this->hm_feasibility_model->get_evereport_task($prj_id);
// 		$data['eprates']=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
// 		$data['rentalchart']=$rentalchart=$this->hm_feasibility_model->get_rentalchart($prj_id);
// 		$data['monthsales']=$sales=$this->hm_feasibility_model->get_project_sales_time($prj_id);
// 		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);
// 		if($developmentcost){
// 		foreach($developmentcost as $raw) {
// 			for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;}
// 		}}
// 		$cashdata=$this->hm_feasibility_model->get_monthcash($prj_id);
// 		$count=1;
// 		$mynames[0]=array('name'=>'Sale %',
// 		'thiskey'=>'sales');
// 		for($i=1; $i<=96; $i++)
// 		{
// 			$month['sales'][$i]=0;
// 		}
// 		foreach($sales as $raw)
// 		{
// 			$month['sales'][$raw->month]=$raw->percentage;
// 		}
// 		foreach($cashdata as $cashraw)
// 		{
// 			$mynames[$count]=array('name'=>$cashraw->name,
// 		'thiskey'=>$cashraw->thiskey);
// 				for($i=1; $i<=96; $i++)
// 				{
// 					$rawname=$i.'M';
// 					$month[$cashraw->thiskey][$i]=$cashraw->$rawname;
// 				}
// 				$count++;
// 		}
// 		foreach($rentalchart as $rentraw)
// 		$easylist[$rentraw->raw_name]=$rentraw;
//
// 		$yeardataset=NULL;
// 		$count=1;
// 		 for($t=0; $t<count($mynames);$t++){
// 	   $key=$mynames[$t]['thiskey'];
// 		$rawtot=0;
// 		for($j=1; $j<=8; $j++)
// 		{ $thistot=0;
// 					for($i=1; $i<=12; $i++)
// 					{ $rawname=$i.'M';
// 					  $q=12*($j-1)+$i;
// 					   $thistot=$thistot+$month[$key][$q];
// 					}
// 				$yearvalue[$j][$key]=$thistot;
// 		}
//  	 }
//
// 		for($j=1; $j<=8; $j++) {
// 			if($j==1)
// 			{
// 			  $yearvalue[$j]['epcbalf']=0 ;
// 			  $yearvalue[$j]['epsbalf']=0;
// 			   $yearvalue[$j]['fundbalf']=0;
// 			   $yearvalue[$j]['cashflowbalf']=0;
//
// 			}
// 			else
// 			{
// 			 $yearvalue[$j]['epcbalf']=$yearvalue[$j-1]["epcbalc"];
// 			  $yearvalue[$j]['epsbalf']=$yearvalue[$j-1]["epsbalc"];
// 			   $yearvalue[$j]['fundbalf']=$yearvalue[$j-1]["fundbalc"];
// 			    $yearvalue[$j]['cashflowbalf']=$yearvalue[$j-1]["cashbalc"];
// 			}
//
// 			$yearvalue[$j]['epcbalc']= $yearvalue[$j]['epcbalf']+ $yearvalue[$j]['epccurrentdue']- $yearvalue[$j]['epctot'];
// 			$yearvalue[$j]['epsbalc']= $yearvalue[$j]['epsbalf']+ $yearvalue[$j]['epsinv']- $yearvalue[$j]['epsdeple'];
// 			$yearvalue[$j]['fundbalc']= $yearvalue[$j]['fundbalf']+ $yearvalue[$j]['fundrecipt']- $yearvalue[$j]['fundrepayment'];
// 			$yearvalue[$j]['cashbalc']= $yearvalue[$j]['cashflowbalf']+ $yearvalue[$j]['cashnetflow'];
//
//
//
// 		}
// 		$data['fulldataset']=$month;
// 		$data['yearvalue']=$yearvalue;
// 		$data['namelist']=$mynames;
// 				$data['valuse_items']=$this->hm_feasibility_model->get_project_valueitems($prj_id);
// 				$data['dplist']=$dplist=$this->hm_dplevels_model->get_dplevels();
// 				$data['officerlist']=$this->hm_project_model->get_project_officer_list($this->session->userdata('branchid'));
// 				$data['land_list']=$this->hm_land_model->get_all_unused_land_summery();
// 				$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
// 				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
// 				$maintaskdata=NULL;
// 				$prjduration=$pridata->period;
// 				$timechart=NULL;
// 				if($tasklist)
// 				{
// 					foreach($tasklist as $raw)
// 					{
// 						$maintaskdata[$raw->task_id]['maintask']=$this->hm_feasibility_model->get_project_maintask_forentry($prj_id,$raw->task_id);
//
// 						$maintaskdata[$raw->task_id]['prjsubtask']=$this->hm_feasibility_model->get_project_subtask($prj_id,$raw->task_id);
// 						$maintaskdata[$raw->task_id]['subtask']=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);
//
// 					for($i=1; $i<=$prjduration; $i++)
// 					{
// 						$timechart[$raw->task_id][$i]=$this->hm_feasibility_model->get_month_task_percentage($prj_id,$raw->task_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					}
// 				}
// 				$data['timechart']=$timechart;
// 				$data['maintaskdata']=$maintaskdata;
// 				$data['tasklist']=$tasklist;
// 				$dpdata=NULL;
// 				if($dplist)
// 				{
//
// 					foreach($dplist as $dpraw)
// 					{
// 						$dpdata[$dpraw->dp_id]=$this->hm_feasibility_model->get_project_dprates_bydpid($prj_id,$dpraw->dp_id);
// 					}
// 				}
// 				$data['dpdata']=$dpdata;
// 				$data['epchart']=$this->hm_feasibility_model->get_project_epchart($prj_id);
// 				$data['perch_price']=$this->hm_feasibility_model->get_project_perch_price($prj_id);
// 				$salestime=NULL;
// 				$bankloan=NULL;
// 				for($i=1; $i<=24; $i++)
// 					{
// 						$salestime[$i]=$this->hm_feasibility_model->get_salestime_month($prj_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					for($i=1; $i<=12; $i++)
// 					{
// 						$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					$data['bankloan']=$bankloan;
// 				$data['salestime']=$salestime;
// 				$data['fsbstatus']=$this->hm_feasibility_model->get_fesibilitystatus($prj_id);
// 				$data['printlnddata']=$lnd=$this->hm_land_model->get_land_bycode($pridata->land_code);
// 				$data['printitndata']=$this->hm_introducer_model->get_intorducer_bycode($lnd->intro_code);
//
// 			$this->load->view('hm/feasibility/print_main',$data);
// 	}
// 	function load_excel()
// 	{ $mynames=NULL; $month=NULL;$yearvalue=NULL; $yeardataset=NULL; $data=NULL;
// 		$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
// 		$encode_id=$this->encryption->encode($prj_id);
// 		if ( ! check_access('view_evereport'))
// 		{
//
// 			$this->session->set_flashdata('error', 'Permission Denied');
// 			redirect('hm/feasibility/showall/'.$this->uri->segment(4));
// 			return;
// 		}
// 		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery_fiesibility($this->session->userdata('branchid'));
// 				$courseSelectList="";
// 				 $count=0;
// 				foreach($inventory as $c)
//       			  {
//            			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
//            			 $count++;
//        			 }
// 				$data['searchlist']=$courseSelectList;
// 				$data['searchpath']='hm/feasibility/evaluation_report';
// 				$data['tag']='Search project';
// 				$data['product_code']='LNS';
// 				for($i=1; $i<=12; $i++)
// 					{$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
// 						if($bankloan[$i])
// 						$bankloan[$i]=$bankloan[$i]->amount;
// 						else $bankloan[$i]=0;
// 						$rawtot[$i]=0;
// 						//echo print_r($tasklist);
// 					}
// 					//print_r($bankloan);
// 		$data['bankloan']=$bankloan;
// 		$data['saleprice']=$this->hm_feasibility_model->get_salesprice_sum($prj_id);
// 		$data['totdpcost']=$this->hm_feasibility_model->get_developmentcost_sum($prj_id);
// 		$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
// 		$data['developmentcost']=$developmentcost=$this->hm_feasibility_model->get_evereport_task($prj_id);
// 		$data['eprates']=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
// 		$data['rentalchart']=$rentalchart=$this->hm_feasibility_model->get_rentalchart($prj_id);
// 		$data['monthsales']=$sales=$this->hm_feasibility_model->get_project_sales_time($prj_id);
// 		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);
// 		if($developmentcost){
// 		foreach($developmentcost as $raw) {
// 			for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;}
// 		}}
// 		$cashdata=$this->hm_feasibility_model->get_monthcash($prj_id);
// 		$count=1;
// 		$mynames[0]=array('name'=>'Sale %',
// 		'thiskey'=>'sales');
// 		for($i=1; $i<=96; $i++)
// 		{
// 			$month['sales'][$i]=0;
// 		}
// 		foreach($sales as $raw)
// 		{
// 			$month['sales'][$raw->month]=$raw->percentage;
// 		}
// 		foreach($cashdata as $cashraw)
// 		{
// 			$mynames[$count]=array('name'=>$cashraw->name,
// 		'thiskey'=>$cashraw->thiskey);
// 				for($i=1; $i<=96; $i++)
// 				{
// 					$rawname=$i.'M';
// 					$month[$cashraw->thiskey][$i]=$cashraw->$rawname;
// 				}
// 				$count++;
// 		}
// 		foreach($rentalchart as $rentraw)
// 		$easylist[$rentraw->raw_name]=$rentraw;
//
// 		$yeardataset=NULL;
// 		$count=1;
// 		 for($t=0; $t<count($mynames);$t++){
// 	   $key=$mynames[$t]['thiskey'];
// 		$rawtot=0;
// 		for($j=1; $j<=8; $j++)
// 		{ $thistot=0;
// 					for($i=1; $i<=12; $i++)
// 					{ $rawname=$i.'M';
// 					  $q=12*($j-1)+$i;
// 					   $thistot=$thistot+$month[$key][$q];
// 					}
// 				$yearvalue[$j][$key]=$thistot;
// 		}
//  	 }
//
// 		for($j=1; $j<=8; $j++) {
// 			if($j==1)
// 			{
// 			  $yearvalue[$j]['epcbalf']=0 ;
// 			  $yearvalue[$j]['epsbalf']=0;
// 			   $yearvalue[$j]['fundbalf']=0;
// 			   $yearvalue[$j]['cashflowbalf']=0;
//
// 			}
// 			else
// 			{
// 			 $yearvalue[$j]['epcbalf']=$yearvalue[$j-1]["epcbalc"];
// 			  $yearvalue[$j]['epsbalf']=$yearvalue[$j-1]["epsbalc"];
// 			   $yearvalue[$j]['fundbalf']=$yearvalue[$j-1]["fundbalc"];
// 			    $yearvalue[$j]['cashflowbalf']=$yearvalue[$j-1]["cashbalc"];
// 			}
//
// 			$yearvalue[$j]['epcbalc']= $yearvalue[$j]['epcbalf']+ $yearvalue[$j]['epccurrentdue']- $yearvalue[$j]['epctot'];
// 			$yearvalue[$j]['epsbalc']= $yearvalue[$j]['epsbalf']+ $yearvalue[$j]['epsinv']- $yearvalue[$j]['epsdeple'];
// 			$yearvalue[$j]['fundbalc']= $yearvalue[$j]['fundbalf']+ $yearvalue[$j]['fundrecipt']- $yearvalue[$j]['fundrepayment'];
// 			$yearvalue[$j]['cashbalc']= $yearvalue[$j]['cashflowbalf']+ $yearvalue[$j]['cashnetflow'];
//
//
//
// 		}
// 		$data['fulldataset']=$month;
// 		$data['yearvalue']=$yearvalue;
// 		$data['namelist']=$mynames;
// 				$data['valuse_items']=$this->hm_feasibility_model->get_project_valueitems($prj_id);
// 				$data['dplist']=$dplist=$this->hm_dplevels_model->get_dplevels();
// 				$data['officerlist']=$this->hm_project_model->get_project_officer_list($this->session->userdata('branchid'));
// 				$data['land_list']=$this->hm_land_model->get_all_unused_land_summery();
// 				$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
// 				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
// 				$maintaskdata=NULL;
// 				$prjduration=$pridata->period;
// 				$timechart=NULL;
// 				if($tasklist)
// 				{
// 					foreach($tasklist as $raw)
// 					{
// 						$maintaskdata[$raw->task_id]['maintask']=$this->hm_feasibility_model->get_project_maintask_forentry($prj_id,$raw->task_id);
//
// 						$maintaskdata[$raw->task_id]['prjsubtask']=$this->hm_feasibility_model->get_project_subtask($prj_id,$raw->task_id);
// 						$maintaskdata[$raw->task_id]['subtask']=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);
//
// 					for($i=1; $i<=$prjduration; $i++)
// 					{
// 						$timechart[$raw->task_id][$i]=$this->hm_feasibility_model->get_month_task_percentage($prj_id,$raw->task_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					}
// 				}
// 				$data['timechart']=$timechart;
// 				$data['maintaskdata']=$maintaskdata;
// 				$data['tasklist']=$tasklist;
// 				$dpdata=NULL;
// 				if($dplist)
// 				{
//
// 					foreach($dplist as $dpraw)
// 					{
// 						$dpdata[$dpraw->dp_id]=$this->hm_feasibility_model->get_project_dprates_bydpid($prj_id,$dpraw->dp_id);
// 					}
// 				}
// 				$data['dpdata']=$dpdata;
// 				$data['epchart']=$this->hm_feasibility_model->get_project_epchart($prj_id);
// 				$data['perch_price']=$this->hm_feasibility_model->get_project_perch_price($prj_id);
// 				$salestime=NULL;
// 				$bankloan=NULL;
// 				for($i=1; $i<=24; $i++)
// 					{
// 						$salestime[$i]=$this->hm_feasibility_model->get_salestime_month($prj_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					for($i=1; $i<=12; $i++)
// 					{
// 						$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					$data['bankloan']=$bankloan;
// 				$data['salestime']=$salestime;
// 				$data['fsbstatus']=$this->hm_feasibility_model->get_fesibilitystatus($prj_id);
// 				$data['printlnddata']=$lnd=$this->hm_land_model->get_land_bycode($pridata->land_code);
// 				$data['printitndata']=$this->hm_introducer_model->get_intorducer_bycode($lnd->intro_code);
//
// 			$this->load->view('hm/feasibility/print_excel',$data);
// 	}
// 	function load_pdf()
// 	{ $mynames=NULL; $month=NULL;$yearvalue=NULL; $yeardataset=NULL; $data=NULL;
// 		$data['prj_id']=$prj_id=$this->encryption->decode($this->uri->segment(4));
// 		$encode_id=$this->encryption->encode($prj_id);
// 		if ( ! check_access('view_evereport'))
// 		{
//
// 			$this->session->set_flashdata('error', 'Permission Denied');
// 			redirect('hm/feasibility/showall/'.$this->uri->segment(4));
// 			return;
// 		}
// 		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_summery_fiesibility($this->session->userdata('branchid'));
// 				$courseSelectList="";
// 				 $count=0;
// 				foreach($inventory as $c)
//       			  {
//            			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
//            			 $count++;
//        			 }
// 				$data['searchlist']=$courseSelectList;
// 				$data['searchpath']='hm/feasibility/evaluation_report';
// 				$data['tag']='Search project';
// 				$data['product_code']='LNS';
// 				for($i=1; $i<=12; $i++)
// 					{$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
// 						if($bankloan[$i])
// 						$bankloan[$i]=$bankloan[$i]->amount;
// 						else $bankloan[$i]=0;
// 						$rawtot[$i]=0;
// 						//echo print_r($tasklist);
// 					}
// 					//print_r($bankloan);
// 		$data['bankloan']=$bankloan;
// 		$data['saleprice']=$this->hm_feasibility_model->get_salesprice_sum($prj_id);
// 		$data['totdpcost']=$this->hm_feasibility_model->get_developmentcost_sum($prj_id);
// 		$data['details']=$pridata=$this->hm_project_model->get_project_bycode($prj_id);
// 		$data['developmentcost']=$developmentcost=$this->hm_feasibility_model->get_evereport_task($prj_id);
// 		$data['eprates']=$this->hm_feasibility_model->get_evereport_eprates($prj_id);
// 		$data['rentalchart']=$rentalchart=$this->hm_feasibility_model->get_rentalchart($prj_id);
// 		$data['monthsales']=$sales=$this->hm_feasibility_model->get_project_sales_time($prj_id);
// 		$masterdata=$this->hm_feasibility_model->get_evereport_masterdata($prj_id);
// 		if($developmentcost){
// 		foreach($developmentcost as $raw) {
// 			for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;}
// 		}}
// 		$cashdata=$this->hm_feasibility_model->get_monthcash($prj_id);
// 		$count=1;
// 		$mynames[0]=array('name'=>'Sale %',
// 		'thiskey'=>'sales');
// 		for($i=1; $i<=96; $i++)
// 		{
// 			$month['sales'][$i]=0;
// 		}
// 		foreach($sales as $raw)
// 		{
// 			$month['sales'][$raw->month]=$raw->percentage;
// 		}
// 		foreach($cashdata as $cashraw)
// 		{
// 			$mynames[$count]=array('name'=>$cashraw->name,
// 		'thiskey'=>$cashraw->thiskey);
// 				for($i=1; $i<=96; $i++)
// 				{
// 					$rawname=$i.'M';
// 					$month[$cashraw->thiskey][$i]=$cashraw->$rawname;
// 				}
// 				$count++;
// 		}
// 		foreach($rentalchart as $rentraw)
// 		$easylist[$rentraw->raw_name]=$rentraw;
//
// 		$yeardataset=NULL;
// 		$count=1;
// 		 for($t=0; $t<count($mynames);$t++){
// 	   $key=$mynames[$t]['thiskey'];
// 		$rawtot=0;
// 		for($j=1; $j<=8; $j++)
// 		{ $thistot=0;
// 					for($i=1; $i<=12; $i++)
// 					{ $rawname=$i.'M';
// 					  $q=12*($j-1)+$i;
// 					   $thistot=$thistot+$month[$key][$q];
// 					}
// 				$yearvalue[$j][$key]=$thistot;
// 		}
//  	 }
//
// 		for($j=1; $j<=8; $j++) {
// 			if($j==1)
// 			{
// 			  $yearvalue[$j]['epcbalf']=0 ;
// 			  $yearvalue[$j]['epsbalf']=0;
// 			   $yearvalue[$j]['fundbalf']=0;
// 			   $yearvalue[$j]['cashflowbalf']=0;
//
// 			}
// 			else
// 			{
// 			 $yearvalue[$j]['epcbalf']=$yearvalue[$j-1]["epcbalc"];
// 			  $yearvalue[$j]['epsbalf']=$yearvalue[$j-1]["epsbalc"];
// 			   $yearvalue[$j]['fundbalf']=$yearvalue[$j-1]["fundbalc"];
// 			    $yearvalue[$j]['cashflowbalf']=$yearvalue[$j-1]["cashbalc"];
// 			}
//
// 			$yearvalue[$j]['epcbalc']= $yearvalue[$j]['epcbalf']+ $yearvalue[$j]['epccurrentdue']- $yearvalue[$j]['epctot'];
// 			$yearvalue[$j]['epsbalc']= $yearvalue[$j]['epsbalf']+ $yearvalue[$j]['epsinv']- $yearvalue[$j]['epsdeple'];
// 			$yearvalue[$j]['fundbalc']= $yearvalue[$j]['fundbalf']+ $yearvalue[$j]['fundrecipt']- $yearvalue[$j]['fundrepayment'];
// 			$yearvalue[$j]['cashbalc']= $yearvalue[$j]['cashflowbalf']+ $yearvalue[$j]['cashnetflow'];
//
//
//
// 		}
// 		$data['fulldataset']=$month;
// 		$data['yearvalue']=$yearvalue;
// 		$data['namelist']=$mynames;
// 				$data['valuse_items']=$this->hm_feasibility_model->get_project_valueitems($prj_id);
// 				$data['dplist']=$dplist=$this->hm_dplevels_model->get_dplevels();
// 				$data['officerlist']=$this->hm_project_model->get_project_officer_list($this->session->userdata('branchid'));
// 				$data['land_list']=$this->hm_land_model->get_all_unused_land_summery();
// 				$tasklist=$this->hm_producttasks_model->get_tasks_product_code('LNS');
// 				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
// 				$maintaskdata=NULL;
// 				$prjduration=$pridata->period;
// 				$timechart=NULL;
// 				if($tasklist)
// 				{
// 					foreach($tasklist as $raw)
// 					{
// 						$maintaskdata[$raw->task_id]['maintask']=$this->hm_feasibility_model->get_project_maintask_forentry($prj_id,$raw->task_id);
//
// 						$maintaskdata[$raw->task_id]['prjsubtask']=$this->hm_feasibility_model->get_project_subtask($prj_id,$raw->task_id);
// 						$maintaskdata[$raw->task_id]['subtask']=$this->hm_producttasks_model->get_confirmed_subtask_bytask($raw->task_id);
//
// 					for($i=1; $i<=$prjduration; $i++)
// 					{
// 						$timechart[$raw->task_id][$i]=$this->hm_feasibility_model->get_month_task_percentage($prj_id,$raw->task_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					}
// 				}
// 				$data['timechart']=$timechart;
// 				$data['maintaskdata']=$maintaskdata;
// 				$data['tasklist']=$tasklist;
// 				$dpdata=NULL;
// 				if($dplist)
// 				{
//
// 					foreach($dplist as $dpraw)
// 					{
// 						$dpdata[$dpraw->dp_id]=$this->hm_feasibility_model->get_project_dprates_bydpid($prj_id,$dpraw->dp_id);
// 					}
// 				}
// 				$data['dpdata']=$dpdata;
// 				$data['epchart']=$this->hm_feasibility_model->get_project_epchart($prj_id);
// 				$data['perch_price']=$this->hm_feasibility_model->get_project_perch_price($prj_id);
// 				$salestime=NULL;
// 				$bankloan=NULL;
// 				for($i=1; $i<=24; $i++)
// 					{
// 						$salestime[$i]=$this->hm_feasibility_model->get_salestime_month($prj_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					for($i=1; $i<=12; $i++)
// 					{
// 						$bankloan[$i]=$this->hm_feasibility_model->get_bankloan_month($prj_id,$i);
// 						//echo print_r($tasklist);
// 					}
// 					$data['bankloan']=$bankloan;
// 				$data['salestime']=$salestime;
// 				$data['fsbstatus']=$this->hm_feasibility_model->get_fesibilitystatus($prj_id);
// 				$data['printlnddata']=$lnd=$this->hm_land_model->get_land_bycode($pridata->land_code);
// 				$data['printitndata']=$this->hm_introducer_model->get_intorducer_bycode($lnd->intro_code);
//
// 			$this->load->view('hm/feasibility/print_pdf',$data);
// 	}
//2019-11-20 added by nadee
	function add_lots()
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
			$count=$this->input->post('num_of_unit');
			//$this->hm_feasibility_model->delete_lots($prj_id);
			$planid=$this->hm_lotdata_model->getmaincode('plan_sq', $prj_id,'hm_prjacblockplane');
			$add_blockoutplan=$this->hm_feasibility_model->add_blockoutplan($prj_id,$count,$planid);
			for($i=1; $i<=$count; $i++)
			{
				if(!$this->input->post('unit_id'.$i))
				{
					$lot_id=$this->hm_feasibility_model->add_lot($prj_id,$this->input->post('unit_name'.$i),$this->input->post('design_id'.$i));
					if($lot_id){
						$this->add_unitboq($prj_id,$lot_id,$this->input->post('design_id'.$i));
						//$this->add_floors($prj_id,$lot_id,$this->input->post('design_id'.$i));
					}
				}
				else{
					$lot=$this->input->post('unit_id'.$i);
					$lot_id=$this->hm_feasibility_model->update_lot($lot,$prj_id,$this->input->post('unit_name'.$i),$this->input->post('design_id'.$i),0);
					if($lot_id){
						$this->add_unitboq($prj_id,$lot,$this->input->post('design_id'.$i));
						//$this->add_floors($prj_id,$lot_id,$this->input->post('design_id'.$i));
					}
				}
			}
			$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'des_type');
			$this->hm_feasibility_model->update_feasibilitystatus($prj_id,'boq');

			$this->hm_feasibility_model->last_update($prj_id);
			$this->session->set_flashdata('tab', 'design');
			$this->session->set_flashdata('msg', 'Unit Data Added Successfully Updated ');
			$this->logger->write_message("success", $prj_id.' Unit Data Added Successfully Updated');
			redirect('hm/feasibility/showall/'.$encode_id);
	}

	function add_floors($prj_id)
	{
		$unit_design=$this->hm_feasibility_model->get_unit_details($prj_id);
		if($unit_design){
		foreach ($unit_design as $key => $value) {
			$design_type=$value->design_id;
			$floors=$this->hm_config_model->get_floor_bydesign($design_type);
			if($floors){
			foreach ($floors as $key2 => $value2) {
				$dataset1 = array('prj_id'=>$prj_id,
				'lot_id'=>$value->lot_id,
				'design_id'=>$value->design_id,
				'floor_name'=>$value2->floor_name,
				'num_of_bedrooms'=>$value2->num_of_bedrooms,
				'num_of_bathrooms'=>$value2->num_of_bathrooms,
				'tot_ext'=>$value2->tot_ext,
				'floor_id'=>$value2->floor_id,);

				$floor_insert=$this->hm_feasibility_model->insertdesign_floors($dataset1);
				if($floor_insert)
				{
					$floors_rooms=$this->hm_config_model->get_floor_related_roomitemslist($value2->floor_id);
					foreach ($floors_rooms as $key3 => $value3) {
						$dataset2= array('prj_id'=>$prj_id,
						'lot_id'=>$value->lot_id,
						'roomtype_id'=>$value3->roomtype_id,
						'floor_id'=>$value3->floor_id,
						'room_id'=>$value3->room_id,
						'width'=>$value3->width,
						'height'=>$value3->height,
						'length'=>$value3->length,
						'tot_extent'=>$value3->tot_extent,
						'doors'=>$value3->doors,
						'windows'=>$value3->windows);

						$floors_rooms_insert=$this->hm_feasibility_model->insertdesign_floorrooms($dataset2);

					}
				}
			}
		}
	}
		}
	}

	function add_acboq($prj_id)// add feacibility budget to actual table
	{
		$boqlotlist= $this->hm_feasibility_model->get_boqunitlots_forac($prj_id);
		if($boqlotlist){
		foreach ($boqlotlist as $key => $value) {
			$dataset1 = array('prj_id'=>$prj_id,
			'lot_id'=>$value->lot_id,
			//'boqtask_id'=>$value->boqtask_id,
			'task_id'=>$value->boqtask_id,//$value->task_id,
			'boqsubcat_id'=>$value->boqsubcat_id,
			'description'=>$value->description,
			
			'qty'=>$value->qty,
			'unit'=>$value->unit,
			'rate'=>$value->rate,
			'amount'=>$value->amount,
			'budgeted_amount'=>$value->amount,);

			$floor_insert=$this->hm_feasibility_model->add_acboq($dataset1);
		}
	}
	}

	//2019-11-20 added by nadee end
	//201911-20 added by terance

	/* add new boq units records for each  project
	if project have 6 units, this enters 6 times..
	*/
	public function add_unitboq($prj_id,$lotid,$design_id){
		//delete if BOQ
		
			// end lot loop

		// }
		//
		//
		// $encode_id=$this->encryption->encode($prj_id);
		// $this->session->set_flashdata('msg', 'Boq Task units Created Succesfully');
		// redirect('hm/feasibility/showall/'.$encode_id);



	}

	 /* view added boq unit list.every project have its unique boq unit record sets. */
	 function get_boq_unit_lists(){
		 $data['prj_id'] =$prjid = $this->uri->segment(4);
		 $data['unitid'] = $unitid = $this->uri->segment(5);
		 $prj_data=$this->hm_project_model->get_project_bycode($prjid);//get project data
		 $data['projname'] =$prj_data->project_name ;
			 $data['noofunits'] = $this->uri->segment(6);
			 $roots = $this->uri->segment(7);
			 $data['designid']=$designid = $this->uri->segment(8);

			 /* get assigned project unit boq by task and subtask*/
			 $data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_config_model->get_subboq_all_bytask($designid);
			 $boq_data=Null;
	 foreach ($sub_cat_data_boq as $key => $value) {
	 //$boq_data2[$value->boqsubcat_id]=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
	 $boq_data[$value->boqsubcat_id] = $this->hm_feasibility_model->get_project_unit_boq($prjid,$unitid,$value->boqsubcat_id);
	 }
	 $data['datalist']=$boq_data;
			 /* get assigned project unit boq by task and subtask*/

			 /* root says which view must be load.if root 1 then load boq_lot_list_view.php  .else load boq_lot_list_edit.php */
			 if($roots==1){
				 $this->load->view('hm/feasibility/boq_lot_list_view',$data);
			 }else{
				 $this->load->view('hm/feasibility/boq_lot_list_edit',$data);
			 }


	 }

	 function update_unitboq(){
			$prj_id = $this->input->post('prj_id');
			$lotid = $this->input->post('lotid');
			$desid = $this->input->post('designid');

			$data['sub_cat_data']=$sub_cat_data=$this->hm_config_model->get_subboq_all();
			$data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_config_model->get_subboq_all_bytask($desid);
			$data['hmtask']=$hmtask=$this->hm_config_model->get_hmtask_all('BOQ');
			// loop boq lots
				foreach ($sub_cat_data_boq as $key => $value) {

			 $boqtasks=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
			 foreach($boqtasks as $bqt){
				 $qty = $this->input->post($bqt->boqtask_id.'qty');
				 $unit = $this->input->post($bqt->boqtask_id.'unit');
				 $rate = $this->input->post($bqt->boqtask_id.'rate');
				 $amttotal = $this->input->post($bqt->boqtask_id.'amt');
				 $desk = $this->input->post($bqt->boqtask_id.'desk');
				 $subcatid = $this->input->post($bqt->boqtask_id.'subcatid');


					 $insertarr = array(
										 'prj_id'      => $prj_id,
										 'lot_id'      => $lotid,
										 'boqsubcat_id' => $subcatid,
										 'boqtask_id'  => $bqt->boqtask_id,
										 'description' => $desk,
										 'qty'         => $qty,
										 'unit'        => $unit,
										 'rate'        => $rate,
										 'amount'      => $amttotal
					 );
									 /* update new booq unit data set.. */
					 $inst = $this->hm_feasibility_model->update_prjboqval($insertarr,$prj_id,$lotid,$bqt->boqtask_id);
			 }

		 }
			// loop boq lots

		 $encode_id=$this->encryption->encode($prj_id);
		 $this->session->set_flashdata('msg', 'Boq Task units Updated Succesfully');
		 redirect('hm/feasibility/showall/'.$encode_id);

	 }



	 /* update project boqunit  */
	 /* function update_unitboq2(){
		 $prj_id = $this->input->post('prj_id');
		 //delete all data related project id in hm_prjfboq table
			$deleteprjboqunitsall = $this->hm_feasibility_model->delete_prj_boq_units_all($prj_id);
			if($deleteprjboqunitsall){

		 //get common boq details
					 $data['sub_cat_data']=$sub_cat_data=$this->hm_config_model->get_subboq_all();
		 $data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_config_model->get_subboq_all_bytask();
		 $data['hmtask']=$hmtask=$this->hm_config_model->get_hmtask_all();
		 $boq_data=Null;
					 // project id sending from view(input type hidden)
					 $prj_id = $this->input->post('prj_id');
					 //get current project no of lots
					 $getlots = $this->hm_feasibility_model->get_no_of_lots($prj_id);
					 //loop lots
					 $lotscount = $getlots->numof_units;
					 for($rw=1;$rw<=$lotscount;$rw++){

						 //lot loop
						 foreach ($sub_cat_data_boq as $key => $value) {

			 $boqtasks=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
			 foreach($boqtasks as $bqt){
				 $qty = $this->input->post($bqt->boqtask_id.'qty');
				 $unit = $this->input->post($bqt->boqtask_id.'unit');
					 $rate = $this->input->post($bqt->boqtask_id.'rate');
									 $amttotal = $this->input->post($bqt->boqtask_id.'amt');
									 $desk = $this->input->post($bqt->boqtask_id.'desk');
									 $subcatid = $this->input->post($bqt->boqtask_id.'subcatid');
					 $insertarr = array(
										 'prj_id'      => $prj_id,
										 'lot_id'      => $rw,
										 'boqsubcat_id' => $subcatid,
										 'boqtask_id'  => $bqt->boqtask_id,
										 'description' => $desk,
										 'qty'         => $qty,
										 'unit'        => $unit,
										 'rate'        => $rate,
										 'amount'      => $amttotal
					 );

					 $inst = $this->hm_feasibility_model->insert_prjboqval($insertarr);
			 }

		 }
						 // end lot loop

					 }


		 $encode_id=$this->encryption->encode($prj_id);
		 $this->session->set_flashdata('msg', 'Boq Task units Updated Succesfully');
		 redirect('hm/feasibility/showall/'.$encode_id);



			}else{
					$encode_id=$this->encryption->encode($prj_id);
		 $this->session->set_flashdata('error', 'Cant Update Records.please Contact System Administrator');
		 redirect('hm/feasibility/showall/'.$encode_id);
			}

	 }

	*/

	//2019-11-25 dev nadee
	function get_boq_unit_mat()
	{
		$data['prjid']=$prjid = $this->uri->segment(4);
		$data['unitid'] = $unitid = $this->uri->segment(5);
		$prj_data=$this->hm_project_model->get_project_bycode($prjid);//get project data
		$data['projname'] =$prj_data->project_name ;
			$data['designid']=$designid = $this->uri->segment(6);

			/* get assigned project unit boq by task and subtask*/

			$data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_config_model->get_subboq_all_bytask($designid);
			$boq_data=Null;
			$boq_material=Null;
			foreach ($sub_cat_data_boq as $key => $value) {
	//$boq_data2[$value->boqsubcat_id]=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
		$boq_data[$value->boqsubcat_id] = $this->hm_feasibility_model->get_project_unit_boq($prjid,$unitid,$value->boqsubcat_id);
		if($boq_data[$value->boqsubcat_id]){
			foreach ($boq_data[$value->boqsubcat_id] as $boqkey => $boqvalue) {
				$boq_material[$boqvalue->id] = $this->hm_feasibility_model->get_project_unit_boq_material($prjid,$unitid,$boqvalue->id);
			}
		}
		}
		$data['datalist']=$boq_data;
		$data['matdata']=$boq_material;
			/* get assigned project unit boq by task and subtask*/

			//$data['datalist']=$datalist=$this->hm_feasibility_model->get_boqunitlots_bylot($prjid,$unitid);
			$data['boq_taskdata']=$boq_taskdata=$this->hm_feasibility_model->get_boqunitlots_bylot($prjid,$unitid);
			$data['mat_list']=$mat_list=$this->hm_config_model->get_meterials_all('',"","");

			/* root says which view must be load.if root 1 then load boq_lot_list_view.php  .else load boq_lot_list_edit.php */
		$this->load->view('hm/feasibility/boq_lot_list_material',$data);


	}

	//2019-11-26 dev nadee
	function update_unitboqmaterial()
	{
		$prj_id = $this->input->post('prj_id');
		$lotid = $this->input->post('lotid');
		$designid=$this->input->post('designid');

		/*delete old material*/
		$del_material=$this->hm_feasibility_model->delete_meterials($prj_id,$lotid);

		/*get config details*/
		$data['mat_list']=$mat_list=$this->hm_config_model->get_meterials_all('',"","");
		$data['sub_cat_data']=$sub_cat_data=$this->hm_config_model->get_subboq_all();
	$data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_config_model->get_subboq_all_bytask($designid);
	$data['hmtask']=$hmtask=$this->hm_config_model->get_hmtask_all('BOQ');
		// loop boq lots
			foreach ($sub_cat_data_boq as $key => $value) {

		 //$boqtasks=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
		 $boqtasks=$this->hm_feasibility_model->get_project_unit_boq($prj_id,$lotid,$value->boqsubcat_id);
		 foreach($boqtasks as $bqt){

			 if($mat_list){
				 foreach ($mat_list as $matkey => $matvalue) {
					 if($this->input->post($bqt->id.$matvalue->mat_id.'amt')>0){
						 $insertmat = array(
							 'prj_id'      => $prj_id,
	  									 'lot_id'  => $lotid,
	  									 'fboq_id' => $bqt->id,
	  									 'mat_id'  => $matvalue->mat_id,
											 'value'=>$this->input->post($bqt->id.$matvalue->mat_id.'amt'),
	  									 'last_update' => date('Y-m-d H:i:s'),
	  									 'update_by'   => $this->session->userdata('userid'),
	  				 );
	  								 /* update new booq unit data set.. */
	  				 $inst = $this->hm_feasibility_model->add_material_boq($insertmat);

					 }

					 //print_r($insertmat);echo "</br>";break;exit;

				 }
			 }



		 }

	 }
		// loop boq lots

	 $encode_id=$this->encryption->encode($prj_id);
	 $this->session->set_flashdata('msg', 'Boq Task units Updated Succesfully');
	 redirect('hm/feasibility/showall/'.$encode_id);
	}

// new functions added by udani
// modification done 2020-01-17
function upload_unitboq_excel(){

		 	/* upload boq excel file upload process */
	if(isset($_POST['submit'])){
	$lotid = $this->input->post('lotid');
	$designtype = $this->input->post('designids');
	$prjid = $this->input->post('prjid');
	$encode_id=$this->encryption->encode($prjid);
		
	$path = 'uploads/';
	$config['upload_path'] = $path;
	$config['allowed_types'] = 'csv|xls';
	$config['remove_spaces'] = TRUE;
	$this->load->library('upload', $config);
	$this->upload->initialize($config);
		if (!$this->upload->do_upload('uploadFile')) {
			$error = array('error' => $this->upload->display_errors());
		} 
		else {
			$data = array('upload_data' => $this->upload->data());
		}
		if(empty($error)){
			  if (!empty($data['upload_data']['file_name'])) {
				$import_xls_file = $data['upload_data']['file_name'];
				} 
				else {
				$import_xls_file = 0;
				}
			$inputFileName = $path . $import_xls_file;

		// csv read function
			$csvfile=base_url().$inputFileName;
			$file_handle = fopen($csvfile, 'r');
			$counter=0;
			$checkmasterboq=$this->hm_uploadboq_model->is_check_customized_design($designtype);
			if($checkmasterboq)
			{
				//echo 'yes this is costomdesign';
				$this->hm_uploadboq_model->delete_all_boq_masterdata($designtype);
			}
	 		$this->hm_uploadboq_model->delete_lot_boqtask($lotid);
			 $newdesignid=$this->hm_uploadboq_model->add_newcustom_designing($lotid);
			 
			 if($newdesignid)
			 {
				while(!feof($file_handle))
				{
					 $myarr[$counter] = fgetcsv($file_handle, 1024);
						$counter++;
				}
				//echo '<table border="1">';
				$newcounter=0; $subtot=0;
				$fulltot=0;
				$flag=true;
				$subcatname=$catname='';
				 foreach ($myarr as $line)
				{
						$crval=0;$drval=0;
						if($line[3]=='Summary of Bill')
						$flag=false;
						if($flag){
						//	echo '<tr><td>'.$newcounter.'</td>';
							$dateil="";
							if($line[1]=='' & $line[2]=='')
							{
								if( preg_match('/^[^a-z]+$/', $line[3]))
								{
								$catname=$line[3];
								$catid=$this->hm_uploadboq_model->add_boq_cat($catname,$newdesignid);
								$dateil="add category";
								}
								else
								{
									
									$dateil="task_categarization";
								}
							}
							if($line[1]!='' & $line[2]=='')
							{
								$subcatid=$this->hm_uploadboq_model->add_boq_sub_cat($line[1],$line[3],$catid);
								$subcatname='add new sub cat';
								$dateil="add sub category";
							}
							if($newcounter==0)
							{
								for($i=11; $i<=37; $i++)
								{
									if($line[$i]!="")
									$mat[$i]=$this->hm_uploadboq_model->add_boq_material_types($line[$i]);
								}
							}
							
							if($newcounter>1)
							{	
									if($line[1]!='' & $line[2]!='' & $line[5]!='')
								{
									$taskid=$this->hm_uploadboq_model->add_boq_task($line[1],$line[2],$line[3],$subcatid,$line[4],$line[5],$line[6],$line[7],$prjid,$lotid);
									
									for($i=11; $i<=37; $i++)
									{
										if($line[$i]!='')
										{
											//$prj_id,$lotid,$fboqid,$matid,$amount
										$this->hm_uploadboq_model->add_boq_materials($prjid,$lotid,$taskid,$mat[$i],$line[$i]);
										}
									}
									//$addcategory
								}
							
								/*echo '<td>'.$dateil.'--'.$subcatid.'--'.$line[3].'</td>';
								echo '<td>'.$line[7].'</td>';
								echo '<td>'.$fulltot.'</td>';
								echo '<td>'.$line[1].'</td>';
								echo '<td>'.$line[2].'</td>';
								*/
								
							}
							
						 $newcounter++;
						}
						
				}
			
				$this->session->set_flashdata('tab', 'boqlist');
			$this->session->set_flashdata('msg', 'BOQ successfully Updated');
			 }
		 else
		 {
			$this->session->set_flashdata('tab', 'boqlist');
			$this->session->set_flashdata('error', 'Couldnt add new designing . Please check the file');
			
		 }// end insert new design check;
   		
   
   
			   
		}
		else
		{
			$this->session->set_flashdata('tab', 'boqlist');
			$this->session->set_flashdata('error', 'Couldnt Upload the file');
			
		}
	}
	redirect('hm/feasibility/showall/'.$encode_id);
//end submit function check
		 	
 }

 function update_boq_items(){
		 $data['prj_id'] =$prjid = $this->uri->segment(4);
		 $data['unitid'] = $unitid = $this->uri->segment(5);
		 $data['prj_data'] = $prj_data=$this->hm_project_model->get_project_bycode($prjid);//get project data
		 $data['projname'] =$prj_data->project_name ;
		 $data['noofunits'] = $this->uri->segment(6);
		  $roots = $this->uri->segment(7);
		  $data['designid']=$designid = $this->uri->segment(8);
		 $data['itemlist']=$sub_cat_data_boq=$this->hm_config_model->get_items();
		 $data['boqitems']=$this->hm_feasibility_model->get_fisibility_boqitems($prjid,$unitid);
		// $this->hm_uploadboq_model->getmaincode('mat_code','MAT','hm_config_material');
		// $this->hm_uploadboq_model->testing('mat_code','MAT','hm_config_material');
			 $boq_data=Null;
	//echo 'test';
		 $data['datalist']=$boq_data;
		$this->load->view('hm/feasibility/boq_item_view',$data);
			

	 }

 function add_boq_items()
 {
	 	  $item_id=$this->input->get('item_id');
		  $unit_rate=$this->input->get('unit_rate');
		  $qty=$this->input->get('qty');
		  $prj_id=$this->input->get('prj_id');
		  $lot_id=$this->input->get('lot_id');
		  $data['prj_data'] = $prj_data=$this->hm_project_model->get_project_bycode($prj_id);//get project data
		 
		   $itemdata=$this->hm_feasibility_model->add_fisibility_boqitems($item_id,$unit_rate,$qty,$prj_id,$lot_id);
		   if( $itemdata)
		   {
				$data['boqitems']=$boqitems=$this->hm_feasibility_model->get_fisibility_boqitems($prj_id,$lot_id);
				
				$br=' <table  class="table table-bordered" id="boqtbls">';
				$br=$br.'<thead> <tr>';
				$br=$br.'<th>Item</th>';
				$br=$br.'<th>Qty</th>';
				$br=$br.'<th>Unit Price</th>';
				$br=$br.'<th>Total</th>';
				$br=$br.'<th></th></tr> ';
				$br=$br.'</thead>';
				$br=$br.'<tbody>';
			 	 if($boqitems)
				 { $c=0;$total_tot=0;
				  	foreach($boqitems as $row){
						$total_tot=$total_tot+$row->total;
						$br=$br.' <tr>';
						$br=$br.' <td  >'.$row->item_name.' '.$row->brand_name.' </td>';
						$br=$br.' <td  >'.$row->qty .' </th>';
						$br=$br.'<td style="text-align:right">'.number_format($row->unit_rate,2).' </td>';
						$br=$br.'<td style="text-align:right">'.number_format($row->total,2).' </td>';
						$br=$br.'<td>';
						if($prj_data->status=='PENDING'){
							 $br=$br.' <a  href="javascript:call_delete_item('.$row->boq_itemid.')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>';
						}
						$br=$br.'</td>';
						$br=$br.'</tr>';
					 
					 }
					 $br=$br.'  <tr class="info total_total"><th  colspan="3">Total</td> <th style="text-align:right">'.number_format($total_tot,2).'</th></tr>';
       
				 } 
				 $br=$br.'</tbody></table>';
				 echo $br;
		   }
		 
 }
 function call_delete_item()
 {
	// echo 'test';
	  $id=$this->input->get('id');
	  $boqdata=$this->hm_feasibility_model->get_boq_itemby_id($id);
		 $data['prj_data'] = $prj_data=$this->hm_project_model->get_project_bycode($boqdata->prj_id);//get project data
		 
	    $itemdata=$this->hm_feasibility_model->delete_fisibility_boqitems($id);
		if( $itemdata)
		   {
				$data['boqitems']=$boqitems=$this->hm_feasibility_model->get_fisibility_boqitems($boqdata->prj_id,$boqdata->lot_id);
				
				
				$br=' <table  class="table table-bordered" id="boqtbls">';
				$br=$br.'<thead> <tr>';
				$br=$br.'<th>Item</th>';
				$br=$br.'<th>Qty</th>';
				$br=$br.'<th>Unit Price</th>';
				$br=$br.'<th>Total</th>';
				$br=$br.'<th></th></tr> ';
				$br=$br.'</thead>';
				$br=$br.'<tbody>';
			 	 if($boqitems)
				 { $c=0;$total_tot=0;
				  	foreach($boqitems as $row){
						$total_tot=$total_tot+$row->total;
						$br=$br.' <tr>';
						$br=$br.' <td  >'.$row->item_name.' '.$row->brand_name.' </td>';
						$br=$br.' <td  >'.$row->qty .' </th>';
						$br=$br.'<td style="text-align:right">'.number_format($row->unit_rate,2).' </td>';
						$br=$br.'<td style="text-align:right">'.number_format($row->total,2).' </td>';
						$br=$br.'<td>';
						if($prj_data->status=='PENDING'){
							 $br=$br.' <a  href="javascript:call_delete_item('.$row->boq_itemid.')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>';
						}
						$br=$br.'</td>';
						$br=$br.'</tr>';
					 
					 }
					 $br=$br.'  <tr class="info total_total"><th  colspan="3">Total</td> <th style="text-align:right">'.number_format($total_tot,2).'</th></tr>';
       
				 } 
				 $br=$br.'</tbody></table>';
				 echo $br;
		   }
		
 }
}



/*2019-12-19 add ledger by nadee*/
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
