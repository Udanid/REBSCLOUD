<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hm_inventry extends CI_Controller {

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

		$this->is_logged_in();

    }

	public function index(){
      $data=NULL;
		if ( ! check_access('meterial_request'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/Hm_inventry/showall');
	}

    public function showall(){
    	$branchid = $this->session->userdata('branch_code');
    	$data['branchlist']=$this->branch_model->get_all_branches_summery();
    	$data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);
    	$data['meterial']=$this->hm_config_model->get_meterials_all('','','');
       	  
    	$this->load->view('hm/inventry/meterial_request_view',$data);
    }

    public function show_all_pending_po_request(){
      $data=NULL;
    if ( ! check_access('meterial_request'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('user');
      return;
    }else{
    
    //code for getting pending po requests
     $pagination_counter = $page_count = "";
     $pagination_counter =RAW_COUNT;
      $page_count = (int)$this->uri->segment(4);
        if ( !$page_count){
          $page_count = 0;
        }
      $data['meterialrequestlist'] = $this->hm_inventry_model->get_meterial_request($pagination_counter,$page_count,1);
      $siteurl='hm/hm_inventry/show_all_pending_po_request';
      $tablename='hm_po_request';
      $data['tab']='';

      if($page_count){
        $data['tab']='listConfirm';
      }
      
      $this->pagination($page_count,$siteurl,$tablename);
      $this->load->view('hm/inventry/meterial_request_Pending_view',$data);
     //code for getting pending po requests
     }
    }

    public function show_all_po_request(){
       $data=NULL;
    if ( ! check_access('meterial_request'))
    {
      $this->session->set_flashdata('error', 'Permission Denied');
      redirect('user');
      return;
    }
    else{
    //code for getting pending po requests
     $pagination_counter = $page_count = "";
        
        $pagination_counter =RAW_COUNT;
      $page_count = (int)$this->uri->segment(4);
        if ( !$page_count){
          $page_count = 0;
        }
      //$data['meterialrequestlist'] = $this->hm_inventry_model->get_meterial_request($pagination_counter,$page_count,1);
      $data['meterialrequestlist2'] = $this->hm_inventry_model->get_meterial_request($pagination_counter,$page_count,"");
      $siteurl='hm/hm_inventry/show_all_po_request';
      $tablename='hm_po_request';
      $data['tab']='';

      if($page_count){
        $data['tab']='list';
      }

        $this->pagination($page_count,$siteurl,$tablename);
      $this->load->view('hm/inventry/material_request_full_list_view',$data);
     }
    }

    public function get_projectsby_branch(){
    	$data['prjlist']=$this->hm_inventry_model->get_all_project_summery($this->uri->segment(4));
		$this->load->view('hm/inventry/projectlist',$data);
    }

    public function get_fulldata(){
    	$data['meterial']=$this->hm_config_model->get_meterials_all('','','');
    	$this->load->view('hm/inventry/loadfulldata',$data);
    }



    public function add_request_meterials(){
    	$prj_id = $this->input->post('prj_id');
    	$lot_id = $this->input->post('lot_id');
      if($lot_id==""){
          $lot_id=0;
      }
        $metcount = $this->input->post('formcount');
        
        for($i=0;$i<$metcount;$i++){
        	$meterialid = $_POST['metrequest'][$i]['meterials'];
            $matqty = $_POST['metrequest'][$i]['req_qty'];
            $needdate = $_POST['metrequest'][$i]['needdate'];
            
            $insertmetrequestarr = array(
              'prj_id' => $prj_id,
              'lot_id' => $lot_id,
              'mat_id' => $meterialid,
              'qty' => $matqty,
              'req_date' => $needdate,
              'request_by' => $this->session->userdata('userid'),
              'entered_date' => date("Y-m-d")
            );
            
            $insertval = $this->hm_inventry_model->insert_meterial_requests($insertmetrequestarr);
        }
        
        if($insertval){
          $this->session->set_flashdata('msg', 'Meterial Request Added Succesfully');
          redirect('hm/hm_inventry/showall');
          return;
        }else{
         $this->session->set_flashdata('error', 'Error in Adding');
         redirect('hm/hm_inventry/showall');
         return;
        } 

    }

    function upd_request_meterial_stts(){
    	$reqid = $this->input->post('id');
    	$stts = $this->input->post('stts');
    	$updarr = array(
          'status' => $stts,
          'confirm_by' => $this->session->userdata('userid'),
          'confirmed_date' => date("Y-m-d")
    	);

    	$updstts=$this->hm_inventry_model->update_meterial_request_status($reqid,$updarr);
    	if($updstts){
    		echo json_encode($stts);
    	}else{
    		echo json_encode(false);
    	}
    }

    function meterialreqlist(){
      $pagination_counter = $page_count = "";
      $pagination_counter =RAW_COUNT;
      $data['meterialrequestlist2'] = $this->hm_inventry_model->get_meterial_request($pagination_counter,$page_count,"");
      $this->load->view('hm/inventry/meterial_request_list_view',$data);
    }

    function get_data_by_keyword(){
      $keyvalue = $this->uri->segment(4);
      $status = $this->uri->segment(5);
      if($status==1)
      {
    $data['meterialrequestlist'] = $this->hm_inventry_model->get_searchkey_related_data($keyvalue,1);
    $data['meterialrequestlist2'] = "";     
      }
      else
      {
    $data['meterialrequestlist'] = "";   
    $data['meterialrequestlist2'] = $this->hm_inventry_model->get_searchkey_related_data($keyvalue,2);
      }
     
      $this->load->view('hm/inventry/meterial_request_list_searchlist',$data);
    }



}	