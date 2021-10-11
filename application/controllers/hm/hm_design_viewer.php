<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//2019-12-06
class hm_design_viewer extends CI_Controller {

	 function __construct() {
        parent::__construct();


		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("hm_config_model");
		$this->load->model("Hm_design_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('design view'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		redirect('hm/hm_design_viewer/showall');

	}

	/*edit view design types*/
	function showall()
	{
		if ( ! check_access('design view'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['designtypes']=$this->hm_config_model->get_designtypes_all();
		$this->load->view('hm/design/design_list',$data);
	}
	/*end edit view design types*/

	/*design types*/
	function view_full_design($id)
	{
		if ( ! check_access('design view'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$data['prjtypes']=$this->hm_config_model->get_prjtypes();
		$data['details']=$datalist=$this->hm_config_model->get_designtypes_byid($id);
		$data['designtypeimgs'] = $this->hm_config_model->get_designtype_related_images($id);
		$data['floors'] =$floors= $this->Hm_design_model->get_designtype_rooms($id);
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
		$this->load->view('hm/design/design',$data);
	}
	/* view design types*/

	/*edit view design types*/
	function design_all()
	{
		if ( ! check_access('design view'))//call from access_helper
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['designtypes']=$designtypes=$this->hm_config_model->get_designtypes_all();
		$designtypeimgs=Null;
		if($designtypes){
			foreach ($designtypes as $key => $value) {
				$designtypeimgs[$value->design_id] = $this->hm_config_model->get_designtype_related_images($value->design_id);
			}
		}
		$data['designtypeimgs'] = $designtypeimgs;
		$this->load->view('hm/design/design_all',$data);
	}
	/*end edit view design types*/

}
