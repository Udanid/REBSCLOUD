<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hm_boqconfig extends CI_Controller {

	 function __construct() {
        parent::__construct();

		$this->load->model("customer_model");
		$this->load->model("hm_common_model");
		$this->load->model("common_model");
    $this->load->model("hm_config_model");
		$this->is_logged_in();

    }

    /*show boq*/
    function config_boq()
    {
    	if ( ! check_access('config_boq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$pagination_counter =RAW_COUNT;
     $page_count = (int)$this->uri->segment(4);
    	 if ( !$page_count){
    		 $page_count = 0;
    	 }
    $data['designs']=$this->hm_config_model->get_designtypes_all();
     $data['datalist']=$datalist=$this->hm_config_model->get_boq($pagination_counter,$page_count);
     $siteurl='hm/hm_boqconfig/config_boq';
     $tablename='hm_config_boqcat';
     $data['tab']='';

    	 if($page_count){
    		 $data['tab']='home';
    	 }

     $this->pagination($page_count,$siteurl,$tablename);
    	//$data['datalist']=$this->hm_config_model->get_designtypes();
    		$this->load->view('hm/config_boq/boq_data',$data);
    }
    /*end show boq*/

    /*add boq*/
    function add_boq()
    {
    	if ( ! check_access('config_boq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$insert=$this->hm_config_model->add_boq();
    	if($insert){
    		$this->session->set_flashdata('msg', 'New BOQ Category Successfully Inserted');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_boq");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Insert Error');
    		redirect("hm/hm_boqconfig/config_boq");
    	}
    }
    /*end add boq*/

    /*edit view boq*/
    function edit_boq($id)
    {
     if ( ! check_access('config_boq'))//call from access_helper
     {
    	 $this->session->set_flashdata('error', 'Permission Denied');
    	 redirect('user');
    	 return;
     }
     $data['designs']=$this->hm_config_model->get_designtypes_all();
     $data['details']=$datalist=$this->hm_config_model->get_boq_byid($id);
     $this->load->view('hm/config_boq/boq_edit',$data);
    }
    /*end edit view boq*/

    /*update boq*/
    function update_boq()
    {
    	if ( ! check_access('config_boq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$insert=$this->hm_config_model->update_boq();
    	if($insert){
    		$this->session->set_flashdata('msg', 'BOQ Category Successfully Updated');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_boq");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Insert Error');
    		redirect("hm/hm_boqconfig/config_boq");
    	}
    }
    /*end update boq*/

    /*delete boq*/
    function boq_delete($id)
    {
    	if ( ! check_access('config_boq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$delete=$this->hm_config_model->delete_boq($id);
    	if($delete){
    		$this->session->set_flashdata('msg', 'BOQ Category Successfully Deleted ');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_boq");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Delete Error');
    		redirect("hm/hm_boqconfig/config_boq");
    	}
    }
    /*end delete boq*/

    /*show subboq*/
    function config_subboq()
    {
    	if ( ! check_access('config_subboq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$pagination_counter =RAW_COUNT;
     $page_count = (int)$this->uri->segment(4);
    	 if ( !$page_count){
    		 $page_count = 0;
    	 }
    $data['main_boq']=$this->hm_config_model->get_boq_all();
		$data['designs']=$this->hm_config_model->get_designtypes_all();
     $data['datalist']=$datalist=$this->hm_config_model->get_subboq($pagination_counter,$page_count);
     $siteurl='hm/hm_boqconfig/config_subboq';
     $tablename='hm_config_boqcat';
     $data['tab']='';

    	 if($page_count){
    		 $data['tab']='home';
    	 }

     $this->pagination($page_count,$siteurl,$tablename);
    	//$data['datalist']=$this->hm_config_model->get_designtypes();
    		$this->load->view('hm/config_boq/subboq_data',$data);
    }
    /*end show subboq*/

    /*add subboq*/
    function add_subboq()
    {
    	if ( ! check_access('config_subboq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$insert=$this->hm_config_model->add_subboq();
    	if($insert){
    		$this->session->set_flashdata('msg', 'New BOQ Sub Category Successfully Inserted');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_subboq");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Insert Error');
    		redirect("hm/hm_boqconfig/config_subboq");
    	}
    }
    /*end add subboq*/

    /*edit view subboq*/
    function edit_subboq($id)
    {
     if ( ! check_access('config_subboq'))//call from access_helper
     {
    	 $this->session->set_flashdata('error', 'Permission Denied');
    	 redirect('user');
    	 return;
     }
     $data['main_boq']=$this->hm_config_model->get_boq_all();
		 $data['designs']=$this->hm_config_model->get_designtypes_all();
     $data['details']=$datalist=$this->hm_config_model->get_subboq_byid($id);
     $this->load->view('hm/config_boq/subboq_edit',$data);
    }
    /*end edit view subboq*/

    /*update subboq*/
    function update_subboq()
    {
    	if ( ! check_access('config_subboq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$insert=$this->hm_config_model->update_subboq();
    	if($insert){
    		$this->session->set_flashdata('msg', 'BOQ Sub Category Successfully Updated');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_subboq");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Insert Error');
    		redirect("hm/hm_boqconfig/config_subboq");
    	}
    }
    /*end update subboq*/

    /*delete subboq*/
    function boq_subdelete($id)
    {
    	if ( ! check_access('config_subboq'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$delete=$this->hm_config_model->delete_subboq($id);
    	if($delete){
    		$this->session->set_flashdata('msg', 'BOQ Sub Category Successfully Deleted ');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_subboq");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Delete Error');
    		redirect("hm/hm_boqconfig/config_subboq");
    	}
    }
    /*end delete subboq*/

    /*show boqtask*/
    function config_boqtask()
    {
    	if ( ! check_access('config_boqtask'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}

			$data['sub_cat_data']=$sub_cat_data=$this->hm_config_model->get_subboq_all();
			$data['hmtask']=$hmtask=$this->hm_config_model->get_hmtask_all('BOQ');
			$data['design_type']=$design_type=$this->hm_config_model->get_designtypes_all();

			$boq_data=Null;
			$sub_cat_data_boq_array=Null;
			if($design_type){
			foreach ($design_type as $key2 => $value2) {
				$sub_cat_data_boq_array[$value2->design_id]=$this->hm_config_model->get_subboq_all_bytask($value2->design_id);

				if($sub_cat_data_boq_array[$value2->design_id]){
				foreach ($sub_cat_data_boq_array[$value2->design_id] as $key => $value) {
					$boq_data[$value->boqsubcat_id]=$this->hm_config_model->get_boqtask_bysubcat($value->boqsubcat_id);
				}
			}

			}
		}
		$data['sub_cat_data_boq']=$sub_cat_data_boq_array;
			$data['datalist']=$boq_data;


    		$this->load->view('hm/config_boq/boqtask_data',$data);
    }
    /*end show boqtask*/

    /*add boqtask*/
    function add_boqtask()
    {
    	if ( ! check_access('config_boqtask'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$insert=$this->hm_config_model->add_boqtask();
    	if($insert){
    		$this->session->set_flashdata('msg', 'New BOQ Task Successfully Inserted');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_boqtask");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Insert Error');
    		redirect("hm/hm_boqconfig/config_boqtask");
    	}
    }
    /*end add boqtask*/

    /*edit view boqtask*/
    function edit_boqtask($id)
    {
     if ( ! check_access('config_boqtask'))//call from access_helper
     {
    	 $this->session->set_flashdata('error', 'Permission Denied');
    	 redirect('user');
    	 return;
     }
		 $data['sub_cat_data']=$sub_cat_data=$this->hm_config_model->get_subboq_all();
		 $data['design_type']=$design_type=$this->hm_config_model->get_designtypes_all();
		 $data['main_boq']=$this->hm_config_model->get_boq_all();
		 $data['hmtask']=$hmtask=$this->hm_config_model->get_hmtask_all('BOQ');
     $data['details']=$datalist=$this->hm_config_model->get_boqtask_byid($id);
     $this->load->view('hm/config_boq/boqtask_edit',$data);
    }
    /*end edit view boqtask*/

    /*update boqtask*/
    function update_boqtask()
    {
    	if ( ! check_access('config_boqtask'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$insert=$this->hm_config_model->update_boqtask();
    	if($insert){
    		$this->session->set_flashdata('msg', 'Task Successfully Updated');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_boqtask");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Insert Error');
    		redirect("hm/hm_boqconfig/config_boqtask");
    	}
    }
    /*end update boqtask*/

    /*delete boqtask*/
    function task_boqdelete($id)
    {
    	if ( ! check_access('config_boqtask'))//call from access_helper
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('user');
    		return;
    	}
    	$delete=$this->hm_config_model->delete_boqtask($id);
    	if($delete){
    		$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
    		$this->logger->write_message("success",'  successfully deleted');
    		redirect("hm/hm_boqconfig/config_boqtask");
    	}else{
    		$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
    		$this->logger->write_message("error",' Delete Error');
    		redirect("hm/hm_boqconfig/config_boqtask");
    	}
    }
    /*end delete boqtask*/

		/*edit view boqtask*/
    function add_taskser_view($id)
    {
     if ( ! check_access('config_boqtask'))//call from access_helper
     {
    	 $this->session->set_flashdata('error', 'Permission Denied');
    	 redirect('user');
    	 return;
     }
		 $data['boq_taskid']=$id;
		 $data['services']=$services=$this->hm_config_model->get_services_all();
     $data['details']=$datalist=$this->hm_config_model->get_services_bytask($id);
     $this->load->view('hm/config_boq/sertask_edit',$data);
    }
    /*end edit view boqtask*/

		/*add taskser*/
		function add_taskser()
		{
			if ( ! check_access('config_taskser'))//call from access_helper
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
			}
			$insert=$this->hm_config_model->add_taskser();
			if($insert){
				$this->session->set_flashdata('msg', 'New Services Asign To Task Successfully Inserted');
				$this->logger->write_message("success",'  successfully deleted');
				redirect("hm/hm_boqconfig/config_boqtask");
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
				$this->logger->write_message("error",' Insert Error');
				redirect("hm/hm_boqconfig/config_boqtask");
			}
		}
		/*end add taskser*/


		/*delete taskser*/
		function taskser_delete($id)
		{
			if ( ! check_access('config_taskmat'))//call from access_helper
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
			}
			$delete=$this->hm_config_model->delete_taskser($id);
			if($delete){
				$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
				$this->logger->write_message("success",'  successfully deleted');
				redirect("hm/hm_boqconfig/config_boqtask");
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
				$this->logger->write_message("error",' Delete Error');
				redirect("hm/hm_boqconfig/config_boqtask");
			}
		}
		/*end delete taskser*/

		/*edit view boqtask*/
    function add_taskmat_view($id)
    {
     if ( ! check_access('config_boqtask'))//call from access_helper
     {
    	 $this->session->set_flashdata('error', 'Permission Denied');
    	 redirect('user');
    	 return;
     }
		 $data['boq_taskid']=$id;
		 $matid=$pagination_counter=$page_count="";
		 $data['meterial']=$meterial=$this->hm_config_model->get_meterials_all($matid,$pagination_counter,$page_count);
     $data['details']=$datalist=$this->hm_config_model->get_meterials_bytask($id);
     $this->load->view('hm/config_boq/mattask_edit',$data);
    }
    /*end edit view boqtask*/

		/*add taskmat*/
		function add_taskmat()
		{
			if ( ! check_access('config_taskser'))//call from access_helper
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
			}
			$insert=$this->hm_config_model->add_taskmat();
			if($insert){
				$this->session->set_flashdata('msg', 'New Material Asign To Task Successfully Inserted');
				$this->logger->write_message("success",'  successfully deleted');
				redirect("hm/hm_boqconfig/config_boqtask");
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
				$this->logger->write_message("error",' Insert Error');
				redirect("hm/hm_boqconfig/config_boqtask");
			}
		}
		/*end add taskser*/


		/*delete taskser*/
		function taskmat_delete($id)
		{
			if ( ! check_access('config_taskser'))//call from access_helper
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
			}
			$delete=$this->hm_config_model->delete_taskmat($id);
			if($delete){
				$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
				$this->logger->write_message("success",'  successfully deleted');
				redirect("hm/hm_boqconfig/config_boqtask");
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
				$this->logger->write_message("error",' Delete Error');
				redirect("hm/hm_boqconfig/config_boqtask");
			}
		}
		/*end delete taskser*/

        /* boq excel file upload process.. */
         public function uploadData(){
            if(isset($_POST['submit'])){
            $designtype = $this->input->post('design_id');
            //echo $designtype;
            $path = 'uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error)){
              if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;

            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $flag = true;
                $i=0;

                $group = array();


                foreach ($allDataInSheet as $value) {
                  if($flag){
                    $flag =false;
                    continue;
                  }

                if(in_array($value['D'], $value)){
                   $group[$value['B']][] = $value;
                }

                  $i++;

                }
                //sending created array for processing..
                $returnval=$this->get_sub_cat($group,$designtype);
                //echo $returnval;
               /* if($returnval){
                  $this->session->set_flashdata('msg', 'BOQ Uploaded Succesfully !!');
                  redirect('hm/hm_boqconfig/config_boq');
                  return;
                }else{
                  $this->session->set_flashdata('error', 'Error in Uploading');
                  redirect('hm/hm_boqconfig/config_boq');
                  return;
                }
               */


          } catch (Exception $e) {
               die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' .$e->getMessage());
            }
          }else{
              echo $error['error'];
            }


          }


         }
        /* boq excel file upload process.. */


        /* boq excel data insert process */
        function get_sub_cat($group,$designtype){

        foreach($group as $key => $value){
        /*echo "array size ".sizeof($value)."<br><br>";
        echo $key . "->".$value[0]['C']; */
        /* 1.$key is the boq category name.send this value to "hm_config_boqcat_copy" table.return its insert id. */

        /* check cat and subcat exist.. */
        $catnameval=$this->check_categoryname($key,$designtype);

        /* check category name is exist or not */
        if(sizeof($catnameval)>0){

            //if cateogry name exist get category id
             $last_id = $catnameval->boqcat_id;
            //check subcat exist or not
            $subcatnameval=$this->check_subcategoryname($value[0]['C'],$designtype);
             //if subcaegory data not there..
             if(sizeof($subcatnameval)>0){

             }else{
                if($value[0]['C']!==""){
                 $boqsubcatarr = array(
                  'boqcat_id' => $last_id,
                  'subcat_name' => $value[0]['C'],
                  'subcat_code' => $value[0]['A']
                 );

                 $insert_subcat = $this->hm_config_model->insert_boqsubcat($boqsubcatarr);
                }

                /* 2.$value[0]['C'] is the boq sub category name.send this value to "hm_config_boqsubcat" with boq category insert id.*/
                  //loop current sub category rel array size.
                  for($i=0;$i<sizeof($value);$i++){

                    //check config tasks already exist or not..
                    //used regular expression for remove/replace ascii characters..
                    $ctaskname = preg_replace('/[^a-zA-Z0-9.]/',' ',iconv('UTF-8', 'ASCII//TRANSLIT',$value[$i]['D']));
                    $configtaskval=$this->check_configtask_exist($ctaskname);
                    //if check_configtask_exist function not return values..
                    if(sizeof($configtaskval)>0){
                       $lastinsertid=$configtaskval->task_id;
                    }else{
                       //insert new config task
                       $conftaskarr = array(
                         'task_name' => $ctaskname,
                         'task_code' => $value[$i]['A']
                       );
                       $lastinsertid=$this->hm_config_model->insert_configtask($conftaskarr);
                    }


                    //insert boq task data..
                    $boqtaskarr = array(
                      'boqsubcat_id' => $insert_subcat,
                      'task_id' => $lastinsertid,
                      'description' => $ctaskname,
                      'qty' => $value[$i]['E'],
                      'unit' => $value[$i]['F'],
                      'rate' => $value[$i]['G'],
                      'amount' => $value[$i]['H']
                    );

                    $insertstts=$this->hm_config_model->insert_boqtask($boqtaskarr);
                  }
             }

        }else{
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           if($key!==""){
             $instboqcatarr = array(
            'cat_name' => $key,
            'design_id' => $designtype,
            'create_by' => $this->session->userdata('userid'),
            'create_date' => date("Y-m-d")
            );
            $last_id=$this->hm_config_model->insert_boqcats($instboqcatarr);
             $subcatnameval=$this->check_subcategoryname($value[0]['C'],$designtype);
             if(sizeof($subcatnameval)>0){

             }else{
                if($value[0]['C']!==""){
                 $boqsubcatarr = array(
                  'boqcat_id' => $last_id,
                  'subcat_name' => $value[0]['C'],
                  'subcat_code' => $value[0]['A']
                 );

                 $insert_subcat = $this->hm_config_model->insert_boqsubcat($boqsubcatarr);
                }

                /* 2.$value[0]['C'] is the boq sub category name.send this value to "hm_config_boqsubcat" with boq category insert id.*/

                  for($i=0;$i<sizeof($value);$i++){

                    //check config tasks already exist or not..
                    //used regular expression for remove/replace ascii characters..
                    $ctaskname = preg_replace('/[^a-zA-Z0-9.]/',' ',iconv('UTF-8', 'ASCII//TRANSLIT',$value[$i]['D']));
                    $configtaskval=$this->check_configtask_exist($ctaskname);
                    if(sizeof($configtaskval)>0){
                       $lastinsertid=$configtaskval->task_id;
                    }else{
                       $conftaskarr = array(
                         'task_name' => $ctaskname,
                         'task_code' => $value[$i]['A']
                       );
                      $lastinsertid=$this->hm_config_model->insert_configtask($conftaskarr);
                    }

                    $boqtaskarr = array(
                      'boqsubcat_id' => $insert_subcat,
                      'task_id' => $lastinsertid,
                      'description' => $ctaskname,
                      'qty' => $value[$i]['E'],
                      'unit' => $value[$i]['F'],
                      'rate' => $value[$i]['G'],
                      'amount' => $value[$i]['H']
                    );

                    $insertstts=$this->hm_config_model->insert_boqtask($boqtaskarr);
                  }


             }

          }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }

    }

                if($insertstts){
                  $this->session->set_flashdata('msg', 'BOQ Uploaded Succesfully !!');
                  redirect('hm/hm_boqconfig/config_boq');
                  return;
                }else{
                  $this->session->set_flashdata('error', 'Error in Uploading.Data Might be Upload Earlier.');
                  redirect('hm/hm_boqconfig/config_boq');
                  return;
                }

  }

  /* function returns category name exist or not */
  function check_categoryname($catname,$designtype){
     return $this->hm_config_model->check_catnameexist($catname,$designtype);
  }

  /* function returns sub category names exist otr not */
  function check_subcategoryname($subcatname,$designtype){
    return $this->hm_config_model->check_subcatnameexist($subcatname,$designtype);
  }

  /* function returns counfig tasks are exits or not.. */
  function check_configtask_exist($conftaskname){
    return $this->hm_config_model->check_configtasknameexist($conftaskname);
  }


        /* boq excel data insert process */

	//2020_01_06 dev nadee
	function get_main_boqtask_bydesign()
	{
		$design_id=$this->input->post('des_id');
		if($design_id){
			$main_task=$this->hm_config_model->get_main_boqtask_bydesign($design_id);
			echo json_encode($main_task);
		}
	}

	function get_sub_boqtask_bydesign()
	{
		$boq_id=$this->input->post('boq_id');
		if($boq_id){
			$main_task=$this->hm_config_model->get_sub_boqtask_bydesign($boq_id);
			echo json_encode($main_task);
		}
	}

	/*end 2020-01-09 boq search functions*/
	/*dev nadee*/
	function search_boq()
	{
		$search=$this->input->post('string');
		$boqs=$this->hm_config_model->search_boq($search);
		if($boqs){$c=0;
			foreach ($boqs as $key => $row) {
				//$c++;
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";

				echo "<td>".$row->short_code." - ".$row->design_name."</td>";
				echo "<td>".$row->cat_name."</td>";


				echo "<td align='right'>";
				$statues=check_foreign_key('hm_config_boqsubcat',$row->boqcat_id,'boqcat_id');//call from hmconfig_helper
				if($statues){
					echo "<a  href='javascript:call_delete('".$row->boqcat_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
					echo "<a  href='javascript:check_activeflag('".$row->boqcat_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a>";

		}
				echo "</td></tr>";
		}
	}else{
		echo "<tr><th colspan='4'>No Result Found...!</th><tr>";
	}
	}

	/*dev nadee*/
	function search_subboq()
	{
		$search=$this->input->post('string');
		$subboqs=$this->hm_config_model->search_subboq($search);
		if($subboqs){$c=0;
			foreach ($subboqs as $key => $row) {
				//$c++;
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";

				echo "<td>".$row->short_code." - ".$row->design_name."</td>";
				echo "<td>".$row->cat_name."</td>";
				echo "<td>".$row->subcat_code."</td>";
				echo "<td>".$row->subcat_name." </td>";


				echo "<td align='right'>";
				$statues=check_foreign_key('hm_config_boqtask',$row->boqsubcat_id,'boqsubcat_id');//call from hmconfig_helper
				if($statues){
					echo "<a  href='javascript:call_delete('".$row->boqsubcat_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
					echo "<a  href='javascript:check_activeflag('".$row->boqsubcat_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a>";
				}
				echo "</td></tr>";
		}
	}else{
		echo "<tr><th colspan='4'>No Result Found...!</th><tr>";
	}
	}

}
