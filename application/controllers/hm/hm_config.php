<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hm_config extends CI_Controller {

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

		$this->load->model("customer_model");
		$this->load->model("hm_common_model");
		$this->load->model("hm_config_model");
		$this->load->model("common_model");
		$this->is_logged_in();

	}

	public function index()
	{
		if ( ! check_access('view_hm_config'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/hm_config/showall');

	}
	/*show messure types*/
	function showall()
	{
		if ( ! check_access('messuretype'))//call from access_helper
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
		$data['datalist']=$datalist=$this->hm_config_model->get_messures($pagination_counter,$page_count);
		$data['itemlist']=$datalist=$this->hm_config_model->get_items();
		$data['brandlist']=$datalist=$this->hm_config_model->get_brands();
		$siteurl='hm/hm_config/showall';
		$tablename='hm_config_messuretype';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		//$data['datalist']=$datalist=$this->hm_config_model->get_messures();

		$this->load->view('hm/config/messure_data',$data);
	}
	/* end show messure types*/

	/* add  messure types*/
	function add_messuretype()
	{
		if ( ! check_access('messuretype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->hm_config_model->add_messuretype();
		if($id){
			$this->session->set_flashdata('msg', 'New Messure Type Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('messure_name').'  successfully Inserted');
			redirect("hm/hm_config/showall");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error", $this->input->post('messure_name').' Insert Error');
			redirect("hm/hm_config/showall");
		}

	}
	/*end add  messure types*/

	/*edit view messure types*/
	function edit_messuretype($id)
	{
		if ( ! check_access('messuretype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$data['details']=$datalist=$this->hm_config_model->get_messures_byid($id);
		$this->load->view('hm/config/messure_edit',$data);
	}
	/* end edit view  messure types*/

	/* update  messure types*/
	function update_messuretype()
	{
		if ( ! check_access('messuretype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->hm_config_model->update_messuretype();
		if($id){
			$this->session->set_flashdata('msg', 'Messure Type Successfully Updated ');
			$this->logger->write_message("success", $this->input->post('messure_name').'  successfully Inserted');
			redirect("hm/hm_config/showall");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error", $this->input->post('messure_name').' Insert Error');
			redirect("hm/hm_config/showall");
		}

	}
	/*end update  messure types*/

	/* delete  messure types*/
	function messuretype_delete($id)
	{
		$delete=$this->hm_config_model->delete_messuretype($id);
		if($delete){
			$this->session->set_flashdata('msg', 'Messure Type Successfully Deleted ');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/showall");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Delete Error');
			redirect("hm/hm_config/showall");
		}
	}
	/*end delete  messure types*/

	/*show services types*/
	function config_services()
	{
		if ( ! check_access('config_services'))//call from access_helper
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
		$data['datalist']=$datalist=$this->hm_config_model->get_services($pagination_counter,$page_count);
		$siteurl='hm/hm_config/config_services';
		$tablename='hm_config_services';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		//$data['datalist']=$this->hm_config_model->get_services();
		$this->load->view('hm/config/services_data',$data);
	}
	/*end show services types*/

	/*add services types*/
	function add_services()
	{
		if ( ! check_access('config_services'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->add_services();
		if($insert){
			$this->session->set_flashdata('msg', 'Services Successfully Inserted');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_services");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_services");
		}
	}
	/*end add services types*/

	/*edit view services types*/
	function edit_services($id)
	{
		if ( ! check_access('config_services'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$data['details']=$datalist=$this->hm_config_model->get_services_byid($id);
		$this->load->view('hm/config/services_edit',$data);
	}
	/*end edit view services types*/

	/*update services types*/
	function update_services()
	{
		if ( ! check_access('config_services'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->update_services();
		if($insert){
			$this->session->set_flashdata('msg', 'Services Successfully Updated');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_services");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_services");
		}
	}
	/*end update services types*/

	/*delete services types*/
	function servicetype_delete($id)
	{
		if ( ! check_access('config_services'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$delete=$this->hm_config_model->delete_servicetype($id);
		if($delete){
			$this->session->set_flashdata('msg', 'Service Type Successfully Deleted ');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_services");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Delete Error');
			redirect("hm/hm_config/config_services");
		}
	}
	/*end delete services types*/

	/*show room types*/
	function config_roomtypes()
	{
		if ( ! check_access('config_roomtype'))//call from access_helper
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
		$data['datalist']=$datalist=$this->hm_config_model->get_roomtypes($pagination_counter,$page_count);
		$siteurl='hm/hm_config/config_roomtypes';
		$tablename='hm_config_roomtypes';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		//$data['datalist']=$this->hm_config_model->get_roomtypes();
		$this->load->view('hm/config/roomtype_data',$data);
	}
	/*end show room types*/

	/*add room types*/
	function add_roomtypes()
	{
		if ( ! check_access('config_roomtype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->add_roomtypes();
		if($insert){
			$this->session->set_flashdata('msg', 'Room Types Successfully Inserted');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_roomtypes");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_roomtypes");
		}
	}
	/*end add room types*/

	/*edit view room types*/
	function edit_roomtypes($id)
	{
		if ( ! check_access('config_roomtype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$data['details']=$datalist=$this->hm_config_model->get_roomtypes_byid($id);
		$this->load->view('hm/config/roomtype_edit',$data);
	}
	/*end edit room types*/

	/*update room types*/
	function update_roomtypes()
	{
		if ( ! check_access('config_roomtype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->update_roomtypes();
		if($insert){
			$this->session->set_flashdata('msg', 'Room Types Successfully Updated');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_roomtypes");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_roomtypes");
		}
	}
	/*end update room types*/

	/*delete room types*/
	function roomtypes_delete($id)
	{
		if ( ! check_access('config_roomtype'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$delete=$this->hm_config_model->delete_roomtypes($id);
		if($delete){
			$this->session->set_flashdata('msg', 'Room Type Successfully Deleted ');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_roomtypes");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Delete Error');
			redirect("hm/hm_config/config_roomtypes");
		}
	}
	/*end delete room types*/

	/*show design types*/
	function config_designtypes()
	{
		if ( ! check_access('config_designtypes'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['prjtypes']=$this->hm_config_model->get_prjtypes();
		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['datalist']=$datalist=$this->hm_config_model->get_designtypes($pagination_counter,$page_count);
		$siteurl='hm/hm_config/config_designtypes';
		$tablename='hm_config_designtype';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		//$data['datalist']=$this->hm_config_model->get_designtypes();
		$this->load->view('hm/config/designtype_data',$data);
	}
	/*end show design types*/

	/*add design types*/
	function add_designtypes()
	{
		if ( ! check_access('config_designtypes'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->add_designtypes();
		if($insert){
			$this->session->set_flashdata('msg', 'Design Types Successfully Inserted');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_designtypes");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_designtypes");
		}
	}
	/*end add design types*/

	/*edit view design types*/
	function edit_designtypes($id)
	{
		if ( ! check_access('config_designtypes'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['prjtypes']=$this->hm_config_model->get_prjtypes();
		$data['details']=$datalist=$this->hm_config_model->get_designtypes_byid($id);
		$data['designtypeimgs'] = $this->hm_config_model->get_designtype_related_images($id);
		$this->load->view('hm/config/designtype_edit',$data);
	}
	/*end edit view design types*/

	/*update design types*/
	function update_designtypes()
	{
		if ( ! check_access('config_designtypes'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->update_designtypes();
		if($insert){
			$this->session->set_flashdata('msg', 'Design Types Successfully Updated');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_designtypes");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_designtypes");
		}
	}
	/*end update design types*/

	/*delete design types*/
	function designtypes_delete($id)
	{
		if ( ! check_access('config_designtypes'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$delete=$this->hm_config_model->delete_designtypes($id);
		if($delete){
			$this->session->set_flashdata('msg', 'Design Type Successfully Deleted ');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_designtypes");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Delete Error');
			redirect("hm/hm_config/config_designtypes");
		}
	}
	/*end delete design types*/

	/*show task*/
	function config_task()
	{
		if ( ! check_access('config_task'))//call from access_helper
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
		$data['relative_code']=$this->hm_config_model->get_relative_code();
		$data['datalist']=$datalist=$this->hm_config_model->get_hmtask($pagination_counter,$page_count);
		$siteurl='hm/hm_config/config_task';
		$tablename='hm_config_task';
		$data['tab']='';

		if($page_count){
			$data['tab']='home';
		}

		$this->pagination($page_count,$siteurl,$tablename);
		//$data['datalist']=$this->hm_config_model->get_designtypes();
		$this->load->view('hm/config/task_data',$data);
	}
	/*end show task*/

	/*add task*/
	function add_task()
	{
		if ( ! check_access('config_task'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->add_hmtask();
		if($insert){
			$this->session->set_flashdata('msg', 'New Task Successfully Inserted');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_task");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_task");
		}
	}
	/*end add task*/

	/*edit view task*/
	function edit_task($id)
	{
		if ( ! check_access('config_task'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['relative_code']=$this->hm_config_model->get_relative_code();
		$data['details']=$datalist=$this->hm_config_model->get_hmtask_byid($id);
		$this->load->view('hm/config/task_edit',$data);
	}
	/*end edit view task*/

	/*update task*/
	function update_task()
	{
		if ( ! check_access('config_task'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$insert=$this->hm_config_model->update_hmtask();
		if($insert){
			$this->session->set_flashdata('msg', 'Task Successfully Updated');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_task");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Insert Error');
			redirect("hm/hm_config/config_task");
		}
	}
	/*end update task*/

	/*delete task*/
	function task_delete($id)
	{
		if ( ! check_access('config_task'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$delete=$this->hm_config_model->task_delete($id);
		if($delete){
			$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
			$this->logger->write_message("success",'  successfully deleted');
			redirect("hm/hm_config/config_task");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error",' Delete Error');
			redirect("hm/hm_config/config_task");
		}
	}
	/*end delete task*/



	/*................................. terrance controller coding............................. */

	//view all meterials
	function meterialview(){
		if ( ! check_access('add_meterials'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id="";
		$data['messures'] = $messures = $this->hm_config_model->get_all_mesurements();

		$id2 = $pagination_counter2 = $page_count2 = "";
		$data['floorlist'] = $this->hm_config_model->get_floor_list($id2,$pagination_counter2,$page_count2);
		$data['roomtypelist'] = $this->hm_config_model->get_roomtypes_all();
		//set pagination
		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['meterial']=$this->hm_config_model->get_meterials_all($id,$pagination_counter,$page_count);
		$data['fllorroomslist'] = $this->hm_config_model->get_floorrooms_all($id,$pagination_counter,$page_count);
		$siteurl='hm/hm_config/meterialview';
		$tablename='hm_config_material';
		$data['tab']='';

		if($page_count){
			$data['tab']='list';
		}
		$this->pagination($page_count,$siteurl,$tablename);
		//end set pagination
		//$data['meterial'] = $meterial = $this->hm_config_model->get_meterials_all($id);

		$this->load->view('hm/config/meterial_view',$data);

	}

	//end meterials view function

	//meterial add function..
	//request coming from views/hm/config/meterial_view.php
	function add_new_meterial(){
		if ( ! check_access('add_meterials'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$today = date("Y_m-d");
		$meterial_code = $this->input->post('meterial_code');
		$meterial_name = $this->input->post('meterial_name');
		$messure_type = $this->input->post('messure_type');
		$meterial_desc = $this->input->post('meterial_desc');

		$metrial_inst_arr = array(
			'mat_code' => $meterial_code,
			'mat_name' => $meterial_name,
			'mt_id' => $messure_type,
			'description' => $meterial_desc,
			'create_by' => $this->session->userdata('userid'),
			'create_date' => $today
		);

		$insertval = $this->hm_config_model->add_new_meterials($metrial_inst_arr);
		if($insertval){
			$this->session->set_flashdata('msg', 'Meterial Added Succesfully');
			redirect('hm/hm_config/meterialview');
			return;
		}else{
			$this->session->set_flashdata('error', 'Error in Adding');
			redirect('hm/hm_config/meterialview');
			return;
		}

	}


	//meterial edit form load function..
	//request coming from views/hm/config/meterial_view.php(update_meterial() function)
	public function meterial_edits(){
		if ( ! check_access('add_meterials'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$pagination_counter="";
		$page_count="";
		$data['messures'] = $messures = $this->hm_config_model->get_all_mesurements();
		$data['details']=$this->hm_config_model->get_meterials_all($this->uri->segment(4),$pagination_counter,$page_count);
		$this->load->view('hm/config/meterial_edit',$data);
	}

	// meterial update function.
	//data sending from views/hm/config/meterial_edit.php
	function meterial_update(){

		if ( ! check_access('add_meterials'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$today          = date("Y_m-d");
		$emetid         = $this->input->post('emetid');
		$emeterial_code = $this->input->post('emeterial_code');
		$emeterial_name = $this->input->post('emeterial_name');
		$emessure_type  = $this->input->post('emessure_type');
		$emeterial_desc = $this->input->post('emeterial_desc');

		$metrial_upd_arr = array(
			'mat_code'    => $emeterial_code,
			'mat_name'    => $emeterial_name,
			'mt_id'       => $emessure_type,
			'description' => $emeterial_desc,
			'create_by'   => $this->session->userdata('userid'),
			'create_date' => $today
		);

		$updval = $this->hm_config_model->update_meterials($metrial_upd_arr,$emetid);
		if($updval){
			$this->session->set_flashdata('msg', 'Meterial Updated Succesfully');
			redirect('hm/hm_config/meterialview');
			return;
		}else{
			$this->session->set_flashdata('error', 'Error in Updating');
			redirect('hm/hm_config/meterialview');
			return;
		}

	}


	/*floor view function.list all floors*/
	public function showfloor(){
		if ( ! check_access('add_floor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['roomtypelist'] = $this->hm_config_model->get_roomtypes_all();
		$data['designtypes'] = $this->hm_config_model->get_designtypes_all();
		$id="";
		//set pagination
		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}


		$data['floorlist'] = $this->hm_config_model->get_floor_list($id,$pagination_counter,$page_count);

		$siteurl='hm/hm_config/showfloor';
		$tablename='hm_config_floors';
		$data['tab']='';

		if($page_count){
			$data['tab']='list';
		}
		$this->pagination($page_count,$siteurl,$tablename);
		//end set pagination

		$this->load->view('hm/config/view_floors',$data);
	}
	
	function get_room_dimensions(){
		$roomn_id = $this->input->post('room_id');
		if($room_data = $this->hm_config_model->get_roomtypes_byid($roomn_id)){
			echo '<label>Width(ft)</label>
				  <div class="form-group">
				  <input type="text" name="floorroom[0][fwidth]" value="'.$room_data->def_width.'" id="fwidth" class="form-control" required>
				  </div>

				  <label>Height(ft)</label>
				  <div class="form-group">
				  <input type="text" name="floorroom[0][fheight]" id="fheight" value="'.$room_data->def_height.'" class="form-control" required>
				  </div>

				  <label>Length(ft)</label>
				  <div class="form-group">
				  <input type="text" name="floorroom[0][flenght]" id="flenght" value="'.$room_data->def_length.'" class="form-control" required>
				  </div>';	
		}
	}


	/* add new floor */
	function add_floors(){

		if ( ! check_access('add_floor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}


		$designtype = $this->input->post('designtype');
		$floorname = $this->input->post('floorname');
		$noof_bedrooms = $this->input->post('noof_bedrooms');
		$noof_bathrooms = $this->input->post('noof_bathrooms');
		$totext = $this->input->post('totext');
		$formcount = $this->input->post('formcount');
		$file_array = $this->input->post('file_array');

		$insertfloorarr = array(
			'design_id' => $designtype,
			'floor_name' => $floorname,
			'num_of_bedrooms' => $noof_bedrooms,
			'num_of_bathrooms' => $noof_bathrooms,
			'tot_ext' => $totext
		);

		$insertid = $this->hm_config_model->insert_floor($insertfloorarr);

		//insert floor rooms ..
		for($i=0; $i<$formcount; $i++)
		{
			$froomtypes= $_POST['floorroom'][$i]['froomtypes'];
			$fwidth= $_POST['floorroom'][$i]['fwidth'];
			$fheight= $_POST['floorroom'][$i]['fheight'];
			$flenght= $_POST['floorroom'][$i]['flenght'];
			$ftotext= $_POST['floorroom'][$i]['ftotext'];
			$fdoors= $_POST['floorroom'][$i]['fdoors'];
			$fwindows= $_POST['floorroom'][$i]['fwindows'];

			$floorroomarr = array(
				'roomtype_id' => $froomtypes,
				'floor_id'    => $insertid,
				'width'       => $fwidth,
				'height'      => $fheight,
				'length'      => $flenght,
				'tot_extent'  => $ftotext,
				'doors'       => $fdoors,
				'windows'     => $fwindows
			);

			$insertfllorrooms = $this->hm_config_model->insert_new_fllorrooms($floorroomarr);

		}


		$filearray = explode(",", $file_array);
		$filecount = count($filearray);

		for($i=0;$i<$filecount;$i++){

			$imageinsrtarr = array(
				'floor_id' => $insertid,
				'floor_image' => $filearray[$i]
			);

			$insertfiles = $this->hm_config_model->inserting_files($imageinsrtarr);

		}

		if($insertfiles){
			$this->session->set_flashdata('msg', 'Floor Added Succesfully');
			redirect('hm/hm_config/showfloor');
			return;
		}else{
			$this->session->set_flashdata('error', 'Error in Adding');
			redirect('hm/hm_config/showfloor');
			return;
		}


	}

	/* show all uploaded images according to the floor id*/
	function view_floor_images(){
		if ( ! check_access('add_floor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		//$data['floorimgs'] = $this->hm_config_model->get_floor_related_images($this->uri->segment(4));
		$pagination_counter="";
		$page_count="";
		$data['floorlist'] = $this->hm_config_model->get_floor_list($this->uri->segment(4),$pagination_counter,$page_count);
		$data['designtypes'] = $this->hm_config_model->get_designtypes_all();
		$data['floorimgs'] = $this->hm_config_model->get_floor_related_images($this->uri->segment(4));
		$data['floorroomslist'] = $this->hm_config_model->get_floor_related_roomitemslist($this->uri->segment(4));
		//$data['floorroomslist'] = $this->hm_config_model->get_floorrooms_all($this->uri->segment(4),$pagination_counter,$page_count);
		$data['roomtypelist'] = $this->hm_config_model->get_roomtypes_all();
		$data['designtypes'] = $this->hm_config_model->get_designtypes_all();

		//$data['flrname'] = $this->uri->segment(5);
		$this->load->view('hm/config/view_floor_images',$data);
	}


	/* loading update form for Floors */
	function floor_edits(){
		if ( ! check_access('add_floor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}


		$pagination_counter="";
		$page_count="";
		$data['floorlist'] = $this->hm_config_model->get_floor_list($this->uri->segment(4),$pagination_counter,$page_count);
		$data['designtypes'] = $this->hm_config_model->get_designtypes_all();
		$data['floorimgs'] = $this->hm_config_model->get_floor_related_images($this->uri->segment(4));
		$data['floorroomslist'] = $this->hm_config_model->get_floor_related_roomitemslist($this->uri->segment(4));
		$data['roomtypelist'] = $this->hm_config_model->get_roomtypes_all();
		$data['designtypes'] = $this->hm_config_model->get_designtypes_all();
		$this->load->view('hm/config/floor_edit',$data);
	}


	/* update code for flooring .upload images also */
	function update_floors(){
		if ( ! check_access('add_floor'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$flrid = $this->input->post('flrid');
		$edesigntype = $this->input->post('edesigntype');
		$efloorname = $this->input->post('efloorname');
		$enoof_bedrooms = $this->input->post('enoof_bedrooms');
		$enoof_bathrooms = $this->input->post('enoof_bathrooms');
		$etotext = $this->input->post('etotext');

		/*
		formcount is used to get new floorroom form count.
		formcounto is used to get new floorroom form count/got by size of array..
		*/
		$formcount = $this->input->post('formcount');
		$formcounto = $this->input->post('formcounto');

		$file_array_upd = $this->input->post('file_array_upd');
		$file_array = $this->input->post('file_array');

		//update floor records..
		$updfloorarr = array(
			'design_id' => $edesigntype,
			'floor_name' => $efloorname,
			'num_of_bedrooms' => $enoof_bedrooms,
			'num_of_bathrooms' => $enoof_bathrooms,
			'tot_ext' => $etotext
		);
		$updfloordetails = $this->hm_config_model->update_floor_details($updfloorarr,$flrid);

		/* .................................existing floorroom details update................................... */
		//check if the records empty or not
		if($formcounto!==""){
			for($i=0; $i<$formcounto; $i++)
			{
				$froomtypes= $_POST['floorroomo'][$i]['froomtypes'];
				$fwidth= $_POST['floorroomo'][$i]['fwidth'];
				$fheight= $_POST['floorroomo'][$i]['fheight'];
				$flenght= $_POST['floorroomo'][$i]['flenght'];
				$ftotext= $_POST['floorroomo'][$i]['ftotext'];
				$fdoors= $_POST['floorroomo'][$i]['fdoors'];
				$fwindows= $_POST['floorroomo'][$i]['fwindows'];

				$oldroomid = $_POST['floorroomo'][$i]['oldroomid'];

				$floorroomarr = array(
					'roomtype_id' => $froomtypes,
					'floor_id'    => $flrid,
					'width'       => $fwidth,
					'height'      => $fheight,
					'length'      => $flenght,
					'tot_extent'  => $ftotext,
					'doors'       => $fdoors,
					'windows'     => $fwindows
				);
				//existing data update model process
				$this->hm_config_model->update_room_rel_floorrooms($floorroomarr,$oldroomid);
			}
		}
		/* .................................end existing floorroom details update............................... */


		/* .................................New floorroom details insert................................... */
		//check new floor room records are available or not..
		if($formcount!==""){
			for($i=0; $i<$formcounto; $i++)
			{
				$froomtypes= $_POST['floorroom'][$i]['froomtypes'];
				$fwidth= $_POST['floorroom'][$i]['fwidth'];
				$fheight= $_POST['floorroom'][$i]['fheight'];
				$flenght= $_POST['floorroom'][$i]['flenght'];
				$ftotext= $_POST['floorroom'][$i]['ftotext'];
				$fdoors= $_POST['floorroom'][$i]['fdoors'];
				$fwindows= $_POST['floorroom'][$i]['fwindows'];

				$floorroomarr = array(
					'roomtype_id' => $froomtypes,
					'floor_id'    => $flrid,
					'width'       => $fwidth,
					'height'      => $fheight,
					'length'      => $flenght,
					'tot_extent'  => $ftotext,
					'doors'       => $fdoors,
					'windows'     => $fwindows
				);
				//insert all new floor room records..
				$insertfllorrooms = $this->hm_config_model->insert_new_fllorrooms($floorroomarr);
			}
		}
		/* .................................end New floorroom details insert............................... */

		//prepare for image add to the database..
		$filearrayold = explode(",", $file_array_upd);
		//echo sizeof($file_array);
		/* check new images are uploaded or not.if not image upload process not works*/
		if($file_array!==""){
			$filearraynew = explode(",", $file_array);
			$finalarr=array_merge($filearrayold,$filearraynew);

			//delete pervious added images..
			$deleteoldimages = $this->hm_config_model->delete_previous_imges($flrid);

			$filecountall = count($finalarr);
			for($img=1;$img<=$filecountall-1;$img++){

				$imageinsrtarr = array(
					'floor_id' => $flrid,
					'floor_image' => $finalarr[$img]
				);

				$insertfiles = $this->hm_config_model->inserting_files($imageinsrtarr);
			}


		}
		// end prepare for image add to the database..
		if($updfloordetails){
			$this->session->set_flashdata('msg', 'Floor Updated Succesfully');
			redirect('hm/hm_config/showfloor');
			return;
		}else{
			$this->session->set_flashdata('error', 'Error in Updating');
			redirect('hm/hm_config/showfloor');
			return;
		}


	}

	/* function for view/list all floor rooms */
	function view_floorrooms(){
		if ( ! check_access('floorroom'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id2 = $pagination_counter2 = $page_count2 = "";
		$data['floorlist'] = $this->hm_config_model->get_floor_list($id2,$pagination_counter2,$page_count2);
		$data['roomtypelist'] = $this->hm_config_model->get_roomtypes_all();

		//set pagination
		$id = "";
		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
		if ( !$page_count){
			$page_count = 0;
		}
		$data['fllorroomslist'] = $this->hm_config_model->get_floorrooms_all($id,$pagination_counter,$page_count);
		$siteurl='hm/hm_config/view_floorrooms';
		$tablename='hm_config_floorrooms';
		$data['tab']='';

		if($page_count){
			$data['tab']='list';
		}
		$this->pagination($page_count,$siteurl,$tablename);
		//end set pagination

		$this->load->view('hm/config/view_floor_rooms',$data);
	}


	/* add new floor Rooms */
	function add_new_floorrooms(){

		if ( ! check_access('floorroom'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$froomtypes = $this->input->post('froomtypes');
		$fflortype = $this->input->post('fflortype');
		$fwidth = $this->input->post('fwidth');
		$fheight = $this->input->post('fheight');
		$flenght = $this->input->post('flenght');
		$ftotext = $this->input->post('ftotext');
		$fdoors = $this->input->post('fdoors');
		$fwindows = $this->input->post('fwindows');

		$floorroomarr = array(
			'roomtype_id' => $froomtypes,
			'floor_id'    => $fflortype,
			'width'       => $fwidth,
			'height'      => $fheight,
			'length'      => $flenght,
			'tot_extent'  => $ftotext,
			'doors'       => $fdoors,
			'windows'     => $fwindows
		);

		$insertfllorrooms = $this->hm_config_model->insert_new_fllorrooms($floorroomarr);
		if($insertfllorrooms){
			$this->session->set_flashdata('msg', 'Floor Rooms Added Succesfully');
			redirect('hm/hm_config/view_floorrooms');
			return;
		}else{
			$this->session->set_flashdata('error', 'Error in Adding');
			redirect('hm/hm_config/view_floorrooms');
			return;
		}
	}

	/* function for load edit floor rooms*/
	function floorrooms_edits(){

		if ( ! check_access('floorroom'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id = $pagination_counter = $page_count = "";
		$data['floorlist'] = $this->hm_config_model->get_floor_list($id,$pagination_counter,$page_count);
		$data['roomtypelist'] = $this->hm_config_model->get_roomtypes_all();
		$data['floorroomslist'] = $this->hm_config_model->get_floorrooms_all($this->uri->segment(4),$pagination_counter,$page_count);
		$this->load->view('hm/config/floorroom_edit',$data);
	}


	/* floor room update function.. */
	function floorrooms_update(){

		if ( ! check_access('floorroom'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$eflrroomid = $this->input->post('eflrroomid');
		$froomtypes = $this->input->post('froomtypes');
		$fflortype = $this->input->post('fflortype');
		$fwidth = $this->input->post('fwidth');
		$fheight = $this->input->post('fheight');
		$flenght = $this->input->post('flenght');
		$ftotext = $this->input->post('ftotext');
		$fdoors = $this->input->post('fdoors');
		$fwindows = $this->input->post('fwindows');

		$floorroomarr = array(
			'roomtype_id' => $froomtypes,
			'floor_id'    => $fflortype,
			'width'       => $fwidth,
			'height'      => $fheight,
			'length'      => $flenght,
			'tot_extent'  => $ftotext,
			'doors'       => $fdoors,
			'windows'     => $fwindows
		);

		$updfloorroomdetails = $this->hm_config_model->update_floor_room_details($floorroomarr,$eflrroomid);
		if($updfloorroomdetails){
			$this->session->set_flashdata('msg', 'Floor Rooms Updated Succesfully');
			redirect('hm/hm_config/view_floorrooms');
			return;
		}else{
			$this->session->set_flashdata('error', 'Error in updating');
			redirect('hm/hm_config/view_floorrooms');
			return;
		}
	}

	/*................................. terrance controller coding............................. */


	function view_designtype_images(){
		if ( ! check_access('config_designtypes'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->uri->segment(4);
		//$data['designtypeimgs'] = $this->hm_config_model->get_designtype_related_images($this->uri->segment(4));
		$data['prjtypes']=$this->hm_config_model->get_prjtypes();
		$data['details']=$datalist=$this->hm_config_model->get_designtypes_byid($id);
		$data['designtypeimgs'] = $this->hm_config_model->get_designtype_related_images($id);
		$this->load->view('hm/config/view_designtype_images',$data);
	}

	/*2020-01-09 search functions*/
	/*dev nadee*/
	function search_material()
	{
		$search=$this->input->post('string');
		$meterial=$this->hm_config_model->search_material($search);
		if($meterial){$c=0;
			foreach ($meterial as $key => $met) {
				//$c++;
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<td>".$met->mat_code."</td>";
				echo "<td>".$met->mat_name."</td>";
				echo "<td>".$met->mt_name."</td>";
				echo "<td>".$met->description."</td>";
				echo "<td align='right'>";
				$statues=check_foreign_key('cm_suppliermaterial',$met->mat_id,'mat_id');//call from hmconfig_helper
				$statues2=check_foreign_key('hm_config_taskmat',$met->mat_id,'mat_id');//call from hmconfig_helper
				$statues3=check_foreign_key('hm_prjfboqmaterial',$met->mat_id,'mat_id');//call from hmconfig_helper
				$statues4=check_foreign_key('hm_po_request',$met->mat_id,'mat_id');//call from hmconfig_helper
				if($statues && $statues2 && $statues3 && $statues4){
					echo "<a  href='javascript:update_meterial('".$met->mat_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a></td>";
				}
				echo "</tr>";
			}
		}else{
			echo "<tr><th colspan='6'>No Result Found...!</th><tr>";
		}
	}

	/*dev nadee*/
	function search_messure()
	{
		$search=$this->input->post('string');
		$messures=$this->hm_config_model->search_messure($search);
		if($messures){$c=0;
			foreach ($messures as $key => $row) {
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<td>".$row->mt_name."</td>";
				$statues=check_foreign_key('hm_config_material',$row->mt_id,'mt_id');
				if($statues)
				{
					echo "<a  href='javascript:check_activeflag('".$row->mt_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a>";
					echo 	"<a  href='javascript:call_delete('".$row->mt_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
				}
			}
		}else{
			echo "<tr><th colspan='3'>No Result Found...!</th><tr>";
		}
	}

	/*dev nadee*/
	function search_services()
	{
		$search=$this->input->post('string');
		$services=$this->hm_config_model->search_services($search);
		if($services){$c=0;
			foreach ($services as $key => $row) {
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<th>".$row->service_name."</th>";
				echo "<th>".$row->pay_type."</th>";
				echo "<th>".$row->pay_rate."</th>";
				echo "<th align='right'>";
				$statues=check_foreign_key('hm_config_taskserv',$row->service_id,'service_id');//call from hmconfig_helper
				if($statues){
					echo "<a  href='javascript:check_activeflag('".$row->service_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a>";
					echo "<a  href='javascript:call_delete('".$row->service_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
				}
				echo "</th>";
				echo "</tr>";
			}
		}else{
			echo "<tr><th colspan='3'>No Result Found...!</th><tr>";
		}
	}

	/*dev nadee*/
	function search_design()
	{
		$search=$this->input->post('string');
		$designs=$this->hm_config_model->search_design($search);
		if($designs){$c=0;
			foreach ($designs as $key => $row) {
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<td>".$row->design_name."</td>";
				echo "<td>".$row->short_code."</td>";
				echo "<td>".$row->prjtype_name."</td>";
				echo "<td>".$row->description."</td>";
				echo "<td>".$row->num_of_floors."</td>";
				echo "<td>".$row->tot_ext."</td>";

				echo "<td align='right'>";

				echo "<a  href='javascript:viewdesigntypeimages('".$row->design_id."')' title='Design Type View'><i class='fa fa-eye nav_icon icon_green'></i></a>";

				$statues=check_foreign_key('hm_config_floors',$row->design_id,'design_id');
				//call from hmconfig_helper
				if($statues){
					echo "<a  href='javascript:check_activeflag('".$row->design_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a>";
					echo "<a  href='javascript:call_delete('".$row->design_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
				}
				echo "</td></tr>";
			}
		}
	}

	/*dev nadee*/
	function search_floors()
	{
		$search=$this->input->post('string');
		$floors=$this->hm_config_model->search_floors($search);
		if($floors){$c=0;
			foreach ($floors as $key => $fl) {
				//$c++;
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<td>".$fl->short_code." - ".$fl->design_name."</td>";
				echo "<td>".$fl->floor_name."</td>";
				echo "<td>".$fl->num_of_bedrooms."</td>";
				echo "<td>".$fl->num_of_bathrooms."</td>";
				echo "<td>".$fl->tot_ext."</td>";
				echo "<td align='right'>";

				echo "<a  href='javascript:viewfloorimages('".$fl->floor_id."')' title='Floor View'><i class='fa fa-eye nav_icon icon_green'></i></a>";
				$statues=check_foreign_key('hm_config_boqcat',$fl->design_id,'design_id');//call from hmconfig_helper
				if($statues){
					echo "<a  href='javascript:update_floor('".$fl->floor_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a></td>";
				}
				echo "</tr>";
			}
		}else{
			echo "<tr><th colspan='6'>No Result Found...!</th><tr>";
		}
	}

	/*dev nadee*/
	function search_rooms()
	{
		$search=$this->input->post('string');
		$rooms=$this->hm_config_model->search_rooms($search);
		if($rooms){$c=0;
			foreach ($rooms as $key => $row) {
				//$c++;
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<td>".$row->roomtype_name."</td>";
				echo "<td>".$row->def_length."</td>";
				echo "<td>".$row->def_height."</td>";
				echo "<td>".$row->def_width."</td>";

				echo "<td align='right'>";
				$statues=check_foreign_key('hm_config_floorrooms',$row->roomtype_id,'roomtype_id');//call from hmconfig_helper
				 if($statues){
					echo "<a  href='javascript:check_activeflag('".$row->roomtype_id."')'><i class='fa fa-edit nav_icon icon_blue'></i></a>";
					echo "<a  href='javascript:call_delete('".$row->roomtype_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
		 }
				echo "</td></tr>";
			}
		}else{
			echo "<tr><th colspan='6'>No Result Found...!</th><tr>";
		}
	}

	/*dev nadee*/
	function search_task()
	{
		$search=$this->input->post('string');
		$tasks=$this->hm_config_model->search_task($search);
		if($tasks){$c=0;
			foreach ($tasks as $key => $row) {
				//$c++;
				echo "<tr class='";
				echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : '';
				echo "'><th scope='row'>".$c."</th>";
				echo "<td>".$row->task_code."</td>";
				echo "<td>".$row->relative_code."</td>";
				echo "<td>".$row->task_name."</td>";

				echo "<td align='right'> ";
				$statues=check_foreign_key('hm_config_boqtask',$row->task_id,'task_id');
				$statues2=check_foreign_key('hm_prjftask',$row->task_id,'task_id');//call from hmconfig_helper
				if($statues && $statues2){
					echo "<a  href='javascript:call_delete('".$row->task_id."')' title='Delete'><i class='fa fa-times nav_icon icon_red'></i></a>";
					echo "<a  href='javascript:check_activeflag('".$row->task_id."')'><i class='fa fa-edit nav_icon icon_red'></i></a>";
		}

				echo "</td></tr>";
		}
	}else{
		echo "<tr><th colspan='6'>No Result Found...!</th><tr>";
	}
	}
	/*end 2020-01-09 search functions*/
	
	// new functions added by udani
	function add_new_items()
	{
		if ( ! check_access('add_items'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->hm_config_model->insert_item_data();
		if($id){
			$this->session->set_flashdata('msg', 'New Iteme Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('messure_name').'  successfully Inserted');
			redirect("hm/hm_config/showall");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error", $this->input->post('messure_name').' Insert Error');
			redirect("hm/hm_config/showall");
		}

	}
	function item_edits()
	{
		if ( ! check_access('update_items'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$pagination_counter="";
		$page_count="";
		$this->common_model->add_activeflag('hm_config_items',$this->uri->segment(4),'item_id');
		$data['brandlist']=$datalist=$this->hm_config_model->get_brands();
		$data['details']=$this->hm_config_model->get_item_data($this->uri->segment(4));
		$this->load->view('hm/config/item_edit',$data);

	}
	function update_items()
	{
		if ( ! check_access('update_items'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->hm_config_model->update_item_data();
		$this->common_model->delete_activflag('hm_config_items',$this->input->post('item_id'),'item_id');
		
		if($id){
			$this->session->set_flashdata('msg', 'New Iteme Successfully updated ');
			$this->logger->write_message("success", $this->input->post('messure_name').'  successfully Inserted');
			redirect("hm/hm_config/showall");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please Try Again ...! ');
			$this->logger->write_message("error", $this->input->post('messure_name').' Insert Error');
			redirect("hm/hm_config/showall");
		}

	}


}
