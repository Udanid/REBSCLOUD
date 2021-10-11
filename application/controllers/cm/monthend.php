<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monthend extends CI_Controller {

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
		$this->load->model("common_model");
		$this->load->model("monthend_model");
		$this->load->helper("url");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_monthend'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
				$data['searchlist']='';
				$data['searchpath']='cm/customer/edit';
		$data['monthenddata']=$inventory=$this->monthend_model->get_active_period();
			$data['monthedlist']=$inventory=$this->monthend_model->previous_list();
		$this->load->view('cm/monthend/monthend_data',$data);
		
		
	}
	public function close_period()
	{
		$data=NULL;
		if ( ! check_access('close_period'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/');
			return;
		}
		$this->session->set_flashdata('msg', 'Permission Denied');
		$this->monthend_model->close_period($this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Month End Process Successfully Completed ');
		redirect('cm/monthend/');
	
				
		
		
		
	}
	public function init_period()
	{
		$data=NULL;
		if ($this->session->userdata('username')=='accuser')
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/monthend/int_finance_period');
			return;
		}
		$this->session->set_flashdata('msg', 'Permission Denied');
		$this->monthend_model->init_period($this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Inital Finance Period Succesfully Updated ');
		redirect('cm/monthend/int_finance_period');
	
				
		
		
		
	}
	
	public function int_finance_period()
	{
		$data=NULL;
		if ( ! check_access('view_monthend'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
				
		$data['monthenddata']=$inventory=$this->monthend_model->get_current_period();
			$data['monthedlist']=$inventory=$this->monthend_model->previous_list();
				$data['finaceyear']=$inventory=$this->monthend_model->get_finace_year();
			
		$this->load->view('cm/monthend/initial_data',$data);
		
		
	}
	public function init_finance_year()
	{
		$data=NULL;
		if ($this->session->userdata('username')=='accuser')
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/monthend/int_finance_period');
			return;
		}
		$yeare=$this->uri->segment('4');
		$statdate=$this->uri->segment('5');
		$enddate=$this->uri->segment('6');
		$this->session->set_flashdata('msg', 'Permission Denied');
		$this->monthend_model->init_finance_year($yeare,$statdate,$enddate);
		$this->session->set_flashdata('msg', 'Inital Finance Year Succesfully Updated ');
		redirect('cm/monthend/int_finance_period');
	
				
		
		
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */