<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

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
		$this->load->model("hm_helper_model");
		$this->load->model("common_model");
		$this->load->model("hm_introducer_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_feasibility_model");
		$this->load->model("hm_producttasks_model");
		$this->load->model("hm_dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("hm_config_model");
		$this->load->model("hm_inventry_model");
		$this->load->model("hm_grn_model");
		$this->load->model("Hm_design_model");
		$this->load->model("hm_progress_model");
		$this->load->model("hm_reservation_model");
		$this->load->model("hm_lotdata_model");
		$this->load->model("hm_reservationdiscount_model");
		$this->load->model("customer_model");
		$this->load->model("hm_models/housing_model");
		

		$this->is_logged_in();

    }

	public function index(){
     $branchid = $this->session->userdata('branch_code');
	    $data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);	
	    $data['relative_code']=$this->hm_config_model->get_relative_code();
        $this->load->view('hm/dashboard/home',$data);
	}

    function get_current_progress(){
       $prjid =  $this->uri->segment(4);
       $lotid =  $this->uri->segment(5);
       $stageid =  $this->uri->segment(6);
       $data['prgress'] = $this->hm_progress_model->get_current_progress($prjid,$lotid,$stageid);
       $this->load->view('hm/work_progress/current_progress',$data);	
    }

    

    function work_progress_list(){
    	$branchid = $this->session->userdata('branch_code');
	    $data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);	
	    $data['relative_code']=$this->hm_config_model->get_relative_code();
        $this->load->view('hm/work_progress/working_progress_list',$data);
    }

    

    function get_prj_lot_rel_stages_progress(){
		
		 $branchid = $this->session->userdata('branch_code');
	    $data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);	
	    $data['relative_code']=$this->hm_config_model->get_relative_code();
    
      $prjid =  $this->uri->segment(4);
      $lotid =  $this->uri->segment(5);
      $finarr2 = array();
      $prgress = "";
      $data['relative_code'] = $relative_code =$this->hm_config_model->get_relative_code();
      $getworkingprogress = $this->hm_progress_model->get_working_progress($prjid,$lotid);
	  if($getworkingprogress)
	  {
		  foreach($getworkingprogress as $rc){
			$prjid = $rc->prj_id;
			$lotid = $rc->lot_id;
			$stageid = $rc->stage_id;
			$shortcodename = $rc->description;
			$progress = $rc->progress;
	
			  $finarr= array(
				'short_code' => $shortcodename,
				'prj_id' => $prjid,
				'lot_id' => $lotid,
				'progressvalue' => $progress,
				'code_id' => $stageid,
				'start_date' => $rc->start_date,
				'end_date' => $rc->end_date,
				'progressstages' => $this->hm_progress_model->get_lotwise_progress_for_project($prjid,$lotid,$stageid)
			  );
	
			  $finarr2[] = $finarr;
		  }
	  }
      	$data['finarr'] = $finarr2;
	 	$data['projectprogressimg'] = $this->hm_helper_model->get_project_progress_images($prjid,$lotid);
	 
	 	$data['projectdata']=$this->hm_reservation_model->get_project_bycode($this->uri->segment(4));
		$data['lotdetail']=$lotdetail=$this->hm_lotdata_model->get_project_lotdata_id($this->uri->segment(5));
		$data['current_rescode']=$current_rescode=$this->hm_lotdata_model->get_max_resid($this->uri->segment(5));
		$data['loan_data']=NULL;
		$data['settle_data']=NULL;
		if($current_rescode)
		{
			$data['current_res']=$current_res=$this->hm_reservation_model->get_all_reservation_details_bycode($current_rescode);
			$data['current_advances']=$current_advances=$this->hm_reservation_model->get_advance_data($current_rescode);
			$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
			$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($current_rescode);
				
		}
		$data['res_his']=$res_his=$this->hm_lotdata_model->get_reservation_historty($this->uri->segment(5));
		$resolelist=NULL;
		
	 $counter=0;
	 $outflolist=$this->hm_helper_model->get_meterial_list();// $prjid
	 $estimate=NULL;//json_encode($lebal);
	 $lebal=NULL;;
	 $actual=NULL;;
	 $budget=NULL;;
	 $color=NULL;;
	 if($outflolist){
		foreach($outflolist as $row)
		{
			
			$site=get_meterial_site($row->mat_id,$prjid);
		    if($site>0){
			  $lebal[$counter]=$row->mat_name;
			  $boq=get_meterial_boq($row->mat_id,$prjid);
			  $estimate[$counter]= $boq;
			  $actual[$counter]= $site;
			  $budget[$counter]= 0;//$row->new_budget;
			  
			  
			  if($site < $boq)
			  {
				//  echo $site.'-'. $boq.'<br>';
			  $color[$counter]= 'rgb(0, 213, 84)';
			  }
			  else if($site ==  $boq)
			  {
				  $color[$counter]= 'rgb(0, 159, 64)';
			  }
			  else
			  {
				 $color[$counter]= 'rgb(255, 46, 65)';
			  }
			  $counter++;
		}
	
	  }
		$data['js_label']=json_encode($lebal);
				$data['js_estimate']=json_encode($estimate);
				$data['js_actual']=json_encode($actual);
				$data['js_colors']=json_encode($color);
				$data['js_budget']=json_encode($budget);		  
				
	 }
     // get boq related payment details
	 $data['sub_cat_data_boq']=$sub_cat_data_boq=$this->hm_helper_model->get_subboq_by_designid($lotdetail->design_id);
		
	 		$boq_data=Null;
			$boq_material=Null;
			if($sub_cat_data_boq)
			{
				foreach ($sub_cat_data_boq as $key => $value) {
					
					
					$totvalue[$value->boqsubcat_id] = $this->hm_helper_model->get_subcat_total($prjid,$lotid,$value->boqsubcat_id);
		//$boq_data2[$value->boqsubcat_id]=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
					$material[$value->boqsubcat_id] = $this->hm_helper_model->get_meterial_cost($prjid,$lotid,$value->boqsubcat_id);
					$service[$value->boqsubcat_id] = $this->hm_helper_model->get_service_cost($prjid,$lotid,$value->boqsubcat_id);
					$metirallist[$value->boqsubcat_id]=$this->hm_helper_model->get_used_meterial_list($prjid,$lotid,$value->boqsubcat_id);
					$servicelist[$value->boqsubcat_id]=$this->hm_helper_model->get_service_list($prjid,$lotid,$value->boqsubcat_id);
					
				}
			}
				$data['servicelist']=$servicelist;
	 	$data['metirallist']=$metirallist;
	    $data['totvalue']=$totvalue;
		$data['material']=$material;
		$data['service']=$service;
		$design = $this->housing_model->get_current_design($lotid);
		$data['details']=$datalist=$this->hm_config_model->get_designtypes_byid($design->design_id);
		$data['designtypeimgs'] = $this->hm_config_model->get_designtype_related_images($design->design_id);
		$data['floors'] =$floors= $this->Hm_design_model->get_designtype_rooms($design->design_id);
		$rooms=Null;
		$floorimages=Null;
		if($floors)
		{
			foreach ($floors as $key => $value) {
				$rooms[$value->floor_id] = $this->Hm_design_model->get_floor_related_rooms($value->floor_id);
				$floorimages[$value->floor_id] =$floors= $this->hm_config_model->get_floor_related_images($value->floor_id);
			}
		}
		$data['rooms']=$rooms;
		$data['floorimages']=$floorimages;
      $this->load->view('hm/dashboard/project_house_progress',$data);
      
    }

    function view_progress_images(){
    	$prj_prgress_id =  $this->uri->segment(4);
    	$stts = "";
    	$data['projectprogressimg'] = $this->hm_progress_model->get_project_progress_images($prj_prgress_id,$stts);
        $this->load->view('hm/work_progress/project_progress_images_view',$data);
    	
    }



   

   
    /* added 2020-1-2 */
    public function get_project_rel_lots(){
      $prjid = $this->uri->segment(4);
      $data['lotlist'] = $this->hm_lotdata_model->get_project_all_lots_byprjid_boq($prjid);
      $this->load->view('hm/dashboard/load_lots',$data);
    }

}