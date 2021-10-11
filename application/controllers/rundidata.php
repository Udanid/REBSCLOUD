<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjobs extends CI_Controller {

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
		
		$this->load->model("message_model");
		$this->load->model("common_model");
		$this->load->model("accountinterface_model");
			
	//	$this->is_logged_in();
		
    }
	
	public function index()
	{
		//$this->message_model->generate_first_remind();
	//	$this->message_model->generate_second_remind();
	//	$this->message_model->generate_third_remind();
	//	$this->message_model->generate_termination_letter();
		 $session = array('accshortcode'=>'HED');
              $this->session->set_userdata($session);
			  echo  $this->session->userdata('accshortcode');
		$data=$this->message_model->get_last_cron();
		if($this->message_model->is_generate_di(date('Y-m-d'))){
		$this->message_model->generate_today_delaint(date('Y-m-d'));
		}
		$addate= $data->lastupdate;
		$todate=date("Y-m-d");
		echo strtotime($todate);
		$start=date('Y-m-d',strtotime('+1 day',strtotime($addate))); 
		while($start<=$todate)
		{
			echo $start;
			transfer_todayint($start);
			$this->message_model->add_cronjob($start);
			$start=date('Y-m-d',strtotime('+1 day',strtotime($start))); 
			
		
		}
		//
		echo 'success';
	//	$dataset=$this->accountinterface_model->get_paid_list('266');
		//$this->accountinterface_model->test_loanpayment('LND0015','NEP','266');
		//print_r($dataset);
		
		
	}
	

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */