<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedulechnage extends CI_Controller {

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

		$this->load->model("reservation_model");
		$this->load->model("common_model");
		$this->load->model("project_model");
		$this->load->model("salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
		$this->load->model("dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("schedulechnage_model");

		$this->is_logged_in();

    }

	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('change_shedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}
		
				$this->load->view('re/schedulechnage/home',$data);



	}

	public function shift_schedule()
	{
		$data=NULL;
		if ( ! check_access('change_shedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}
	
	$entry=$this->schedulechnage_model->shift_shedule();
	if($entry)
	{
		$this->session->set_flashdata('msg', $this->input->post('loan_code').'Instalment successfully Shifter');
	}
	else
		{
			$this->session->set_flashdata('error', 'Error Addin Instalment ');
		}
	redirect("re/schedulechnage");



	}
	
	function update_entry()
	{
		$entry=$this->schedulechnage_model->get_update_reciept_entires();
		$entry=$this->schedulechnage_model->get_update_jurnal_entires();
		$entry=$this->schedulechnage_model->untreansfer_settlement();
		$entry=$this->schedulechnage_model->get_update_cancel_entires();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
