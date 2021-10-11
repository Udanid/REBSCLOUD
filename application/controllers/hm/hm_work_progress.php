<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hm_work_progress extends CI_Controller {

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
		$this->load->model("hm_inventry_model");
		$this->load->model("hm_grn_model");
		$this->load->model("hm_progress_model");
		$this->load->model("hm_lotdata_model");

		$this->is_logged_in();

    }
  // by terance
	public function index(){
      $data=NULL;
		if ( ! check_access('project progress view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		else{
		  $branchid = $this->session->userdata('branch_code');
		  $data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);
		  $data['relative_code']=$this->hm_config_model->get_relative_code();
			$data['pendingprojectprogress'] = $this->hm_progress_model->get_project_progress_images('','');
			$data['tab']='profile';

	      $this->load->view('hm/work_progress/project_working_progress',$data);
       }
	}
	
	function load_stages(){
		$data = $this->hm_inventry_model->load_stages();
		if($data){
			print_r(json_encode($data));
		}
	}
	
	function hm_project_period(){
		$data=NULL;
		if ( ! check_access('project period update'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		
		if($_POST){
			if($this->hm_inventry_model->update_project_periods()){
				$this->session->set_flashdata('msg', 'Successfully updated.');
			}else{
				$this->session->set_flashdata('error', 'Unable to update');
			}
			redirect('hm/hm_work_progress/hm_project_period/');
		}
		$branchid = $this->session->userdata('branch_code');
		$data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);
		$data['relative_code']=$this->hm_config_model->get_relative_code();
		$this->load->view('hm/work_progress/project_period',$data);
	}
	//eranga
	function get_project_periods(){
		$period = $this->hm_inventry_model->get_project_periods();
		$start_date = '';
		$end_date = '';
		if($period){
			$start_date = $period->start_date;
			$end_date = $period->end_date;
		}
		echo '<div class="form-group col-md-6">
					  <label>Start Date</label><br>
					  <input name="start_date" class="form-control" required="required" autocomplete="off" id="start_date" value="'.$start_date.'">
				</div>
				<div class="form-group col-md-6">
					  <label>End Date</label><br>
					  <input name="end_date" class="form-control" required="required" autocomplete="off" id="end_date" value="'.$end_date.'">
				  
			  </div>
			  <div class="form-group col-md-2">
			  		<input type="submit" class="btn btn-primary" name="submit">
			  </div>';
	}
	
	//eranga 
	function get_stages_with_dates(){
		
		$stages = $this->hm_config_model->get_relative_code();
		$dates = $this->hm_inventry_model->get_project_periods();
		if($stages){
			foreach($stages as $data){
				$dates = $this->hm_inventry_model->get_project_periods_stage($data->code_id);
				if($dates){
					$start_date = $dates->start_date;
					$end_date = $dates->end_date;
				}else{
					$start_date = '';
					$end_date = '';
				}
				echo '<div class="row">
						<div class="col-md-6">
							<input type="hidden" id="stage_id'.$data->code_id.'" value="'.$data->code_id.'" name="stage_id'.$data->code_id.'">
							<label>'.$data->code .'-'. $data->description.'</label>
							<input type="text" name="start_date'.$data->code_id.'" value="'.$start_date.'" autocomplete="off" id="start_date'.$data->code_id.'" onKeyUp="checkEnddate('.$data->code_id.');" placeholder="Start Date" class="form-control">
						</div>
						<div class="col-md-6">
							<label>&nbsp;</label>
							<input type="text" name="end_date'.$data->code_id.'" value="'.$end_date.'" autocomplete="off" id="end_date'.$data->code_id.'" placeholder="End Date" class="form-control">
						</div>
				</div>
				<script>
					function checkEnddate(id){
						var value = $("#start_date"+id).val();
						if(value == ""){
							$("#end_date"+id).attr("required", false);
						}
					}
					
					$("#end_date'.$data->code_id.'").datepicker({ 
						dateFormat: "yy-mm-dd",
						onSelect: function () { },
						onClose: function () { $(this).focus(); }
					  });
				  
				  
					$("#start_date'.$data->code_id.'").datepicker({ 
						dateFormat: "yy-mm-dd",
						onSelect:
						  function (dateText, inst) {
							$("#end_date'.$data->code_id.'").datepicker("option", "minDate", new Date(dateText));
							$("#end_date'.$data->code_id.'").attr("required", true);
						  }
						,
						onClose: function () { $(this).focus(); }
					  });
				</script>
				';
			}
			echo '<div class="form-group col-md-3">
			  		<input type="submit" class="btn btn-primary" name="submit" value="Submit">
			 	 </div>';
		}
		
	}

    // by terance
    function get_current_progress(){
       $prjid =  $this->uri->segment(4);
       $lotid =  $this->uri->segment(5);
       $stageid =  $this->uri->segment(6);
       $data['prgress'] = $this->hm_progress_model->get_current_progress($prjid,$lotid,$stageid);
       $this->load->view('hm/work_progress/current_progress',$data);
    }

    /*function add_project_progress_test(){
      $file_array = $this->input->post('file_array');  // original image names array
      $file_array2 = $this->input->post('file_array2');// removed image names array.
          $filearray = explode(",", $file_array);
          $filearray2 = explode(",", $file_array2);
          $filecount = count($filearray);
          $finarr3 = array();


          for($i=0;$i<$filecount;$i++){
            if(in_array($filearray[$i], $finarr3)){

             }else{
               array_push($finarr3,$filearray[$i]);
             }
          }


          /*  $filecount = count($filearray);
            if($filecount>0){
              for($i=0;$i<$filecount;$i++){

            //check image name in the remove array list
            if(in_array($filearray[$i], $filearray2)){

              // check array has same image name more than one time.
              $vals = array_count_values($filearray);
              //print_r($vals);
              echo "<br>";
              echo "nmber ".$vals[$filearray[$i]];
              echo "<br>";
              // check array has same image name more than one time.

            }else{
              echo "<br><br>";
              echo "normal image insert";
              /*$insertprjprogressimgarr = array(
                   'progress_id' => $lastid,
                   'image' => $filearray[$i]
              );
              $insertprjpprgrsimg=$this->hm_progress_model->insert_progress_master($insertprjprogressimgarr,'hm_prjprogress_img'); */
          /*  }
            //check image name in the remove array list

             }
            } */
   /* }*/


    // by terance
    function add_project_progress(){
        $prjid        = $this->input->post('prjid');
        $lotid        = $this->input->post('lotid');
        $related_code = $this->input->post('related_code');
        $prevprogress = $this->input->post('prevprogress');
        $curprogress  = $this->input->post('curprogress');
        $progress_remark = $this->input->post('progress_remark');
        $file_array = $this->input->post('file_array');  // original image names array
        $file_array2 = $this->input->post('file_array2');// removed image names array.

        $progress_gap = $curprogress-$prevprogress;

        // create one array removing duplicate image names.
        $filearray = explode(",", $file_array);
          $filearray2 = explode(",", $file_array2);
          $filecount = count($filearray);
          $finarr3 = array();


          for($i=0;$i<$filecount;$i++){
            if(in_array($filearray[$i], $finarr3)){

             }else{
               array_push($finarr3,$filearray[$i]);
             }
          }
          // create one array removing duplicate image names.


    	//1. insert 'hm_progress_master' table data.
    	//   1.1 . check prj_id,lot_id,stage_id related data is exist.
    	     $getdata = $this->hm_progress_model->get_current_data($prjid,$lotid,$related_code);

    	     if(empty($getdata)){
             //   1.2 . if data isnt available, insert query works.
    	     	  $insertprogressmsterarr = array(
                    'prj_id' => $prjid,
                    'lot_id' => $lotid,
                    'stage_id' => $related_code,
                    'progress' => $curprogress,
    	     	  );
    	     	  $insertprogressmaster = $this->hm_progress_model->insert_progress_master($insertprogressmsterarr,'hm_progress_master');
    	     }else{
    	     //   1.3 . if record available, related record progress will update.
    	     	$recid = $getdata->id;
    	     	$updprogressmasterarr = array(
                  'progress' => $curprogress
    	     	);
    	     	$updval = $this->hm_progress_model->update_progress_master($updprogressmasterarr,$recid);
    	     }




    	//2. insert 'hm_prjprogress' table data.
    	// 2.1 . get its last insert id.
    	    $insertprojectprogressarr = array(
                    'prj_id' => $prjid,
                    'lot_id' => $lotid,
                    'stage_id' => $related_code,
                    'progress' => $progress_remark,
                    'updated_by' => $this->session->userdata('userid'),
                    'update_date' => date("Y-m-d"),
                    'progress_pressentage' => $progress_gap
    	     	  );
    	    $lastid = $this->hm_progress_model->insert_progress_master($insertprojectprogressarr,'hm_prjprogress');
    	// 2.2 . inert 'hm_prjprogress_img' table with last insert id.

            $filecount = count($finarr3);
            for($i=0;$i<$filecount;$i++){

              $insertprjprogressimgarr = array(
                   'progress_id' => $lastid,
                   'image' => $finarr3[$i]
              );
              $insertprjpprgrsimg=$this->hm_progress_model->insert_progress_master($insertprjprogressimgarr,'hm_prjprogress_img');

            //check image name in the remove array list

    	       }



           if($insertprjpprgrsimg){
           	  $this->session->set_flashdata('msg', 'Progress Updated Succesfully');
	          redirect('hm/hm_work_progress');
	          return;
           }else{
           	  $this->session->set_flashdata('error', 'Error in Progress Updating');
		      redirect('hm/hm_work_progress');
		      return;
           }
    }

    // by terance
    function work_progress_list(){
    	$branchid = $this->session->userdata('branch_code');
	    $data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);
	    $data['relative_code']=$this->hm_config_model->get_relative_code();
        $this->load->view('hm/work_progress/working_progress_list',$data);
    }

    // by terance
    function get_prj_lot_stage_rel_progress(){
    	  $prjid =  $this->uri->segment(4);
        $lotid =  $this->uri->segment(5);
        $stageid =  $this->uri->segment(6);
        $getprogress = $this->hm_progress_model->get_current_progress($prjid,$lotid,$stageid);
        if(empty($getprogress)){
         $data['progressactions'] = "";
         $data['progressproject'] = "";
        }else{
          $fullview = array(
           'prj_id'	         => $getprogress->prj_id,
           'stage_id'	     => $getprogress->stage_id,
		   'end_date' 		 => $getprogress->end_date,
		   'lot_id'	         => $getprogress->lot_id,
           'stage'           => $getprogress->description,
           'curprogress'     => $getprogress->progress
          );
         $data['progressactions'] = $this->hm_progress_model->get_progerss_rel_actions($prjid,$lotid,$stageid);
         $data['progressproject'] = $fullview;
        }

        $this->load->view('hm/work_progress/project_lot_rel_progress_view',$data);
    }

    // by terance
    function get_prj_lot_rel_stages_progress(){
      $prjid =  $this->uri->segment(4);
      $lotid =  $this->uri->segment(5);
      //$prjid =  1;
      //$lotid =  1;
      $finarr2 = array();
      $prgress = "";
      $data['relative_code'] = $relative_code =$this->hm_config_model->get_relative_code();
      //$data['getprogressbylot'] = $getprogressbylot = $this->hm_progress_model->get_lotwise_progress($prjid,$lotid);
      //print_r($relative_code);

      $getworkingprogress = $this->hm_progress_model->get_working_progress($prjid,$lotid);
      if(!empty($getworkingprogress)){
         foreach($getworkingprogress as $rc){
        $prjid = $rc->prj_id;
        $lotid = $rc->lot_id;
        $stageid = $rc->stage_id;
		$end_date = $rc->end_date;
        $shortcodename = $rc->description;
        $progress = $rc->progress;

          $finarr= array(
            'short_code' => $shortcodename,
            'prj_id' => $prjid,
            'lot_id' => $lotid,
			'end_date' => $end_date,
            'progressvalue' => $progress,
            'code_id' => $stageid,
            'progressstages' => $this->hm_progress_model->get_lotwise_progress_for_project($prjid,$lotid,$stageid)
          );

          $finarr2[] = $finarr;
      }
      $data['finarr'] = $finarr2;
      }



      /* foreach($relative_code as $rc){

        $vals=$this->hm_progress_model->get_lotwise_progress($prjid,$lotid,$rc->code_id);
        if(empty($vals)){
         $prgress = 0;
        }else{
         $prgress = $vals->progress;
        }

        $finarr= array(
          'short_code' => $rc->description,
          'code_id' => $rc->code_id,
          'progress' => $prgress
        );

        $finarr2[] = $finarr;

      }
      $data['finarr'] = $finarr2;
      $this->load->view('hm/work_progress/lot_vise_progress_list.php',$data);
      */

      $this->load->view('hm/work_progress/lotwise_progress_list',$data);

    }

    // by terance
    function view_progress_images(){
    	$prj_prgress_id =  $this->uri->segment(4);
    	$stts = "";
    	$data['projectprogressimg'] = $this->hm_progress_model->get_project_progress_images($prj_prgress_id,$stts);
        $this->load->view('hm/work_progress/project_progress_images_view',$data);

    }


    // by terance
    function progress_confirm_list(){
    	$stts = "PENDING";
    	$prj_prgress_id = "";
    	$data['pendingprojectprogress'] = $this->hm_progress_model->get_project_progress_images($prj_prgress_id,$stts);
    	$this->load->view('hm/work_progress/project_progress_confirm_view',$data);
    }

    // by terance
    function progress_approve_disapprove_process(){
    	  $id    = $this->input->get('id');
        $stts  = $this->input->get('stts');
        $today = date("Y-m-d");
        $user  = $this->session->userdata('userid');

        if($stts==1){
        	//approve process
        	//just update approve_date,Approve user id,and Status
        	$updprogressstts = array(
             'progress_status' => 'APPROVED',
             'confirm_date' => $today,
             'confirm_by' => $user
        	);
        	$updstts = $this->hm_progress_model->update_project_progress_tbl($id,$updprogressstts);
        	if($updstts){
        		echo json_encode(1);
        	}else{
        		echo json_encode(0);
        	}
        }else{
        	// cancelled
        	// update cancelled_date,cancelled_user and Status.
            $str_arr = explode ("_", $id);
            $progid = $str_arr[0];
            $progrs = $str_arr[1];

        	$updprogressstts = array(
             'progress_status' => 'CANCELLED',
             'confirm_date' => $today,
             'confirm_by' => $user
        	);

        	$updstts = $this->hm_progress_model->update_project_progress_tbl($progid,$updprogressstts);

          // get progress_master records to update new progress value.
        	$getprojectprogreese = $this->hm_progress_model->get_project_progreses($progid);

            $masterprogid   = $getprojectprogreese->masterprogid;
            $progressmaster = $getprojectprogreese->masterprogress;
            $newmasterprogress = $progressmaster-$progrs;

            $newprogressupdarr = array(
              'progress' => $newmasterprogress
            );
    $updmasterprogress = $this->hm_progress_model->update_progress_master($newprogressupdarr,$masterprogid);


        	if($updstts && $updmasterprogress){
        		echo json_encode(2);
        	}else{
        		echo json_encode(0);
        	}
        	// deduct cancelled presentage from hm_progress_master table.
        }
    }

    /* added 2020-1-2 by terance*/
    public function get_project_rel_lots(){
      $prjid = $this->uri->segment(4);
      $data['lotlist'] = $this->hm_lotdata_model->get_project_all_lots_byprjid_boq($prjid);
      $this->load->view('hm/work_progress/load_lots',$data);
    }

}
