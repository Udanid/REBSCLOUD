<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Yearend extends CI_Controller {

	function __construct() {
    	parent::__construct();
		$this->load->model('yearend_model');
		$this->load->model('Ledger_model');
  	}

  	/*public function index(){
		if ( ! check_access('yearend_process'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user/');
			return;
		}
		if($_POST){
			$year = $this->input->post('year');
			$start_date	= $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			
			//check whether the year has a lock
			if($this->yearend_model->check_lock($year)){
				$this->session->set_flashdata('error', 'Account year has been locked.');
				redirect('accounts/yearend');
				return;
			}
			
			//we will check the year in db to avoid duplicate data
			if($this->yearend_model->check_year($year)){
				//$this->session->set_flashdata('error', 'Year end process for '.$year.' has already performed.');
				//redirect('accounts/yearend');
				//return;
				
				//clean previous year data
				$this->yearend_model->clean_data($year);
			}
			
			//now we check whether the process runs on correct date

			
			//check the process run date
			if($this->session->userdata('fy_end') > date('Y-m-d')){
				$this->session->set_flashdata('error', 'Incorrect date to run this process. Please re-try on or after '.$this->session->userdata('fy_end'));
				redirect('accounts/yearend');
				return;
			}
			
			//Now we run the function to get balances and update tables
			if($this->yearend_model->run_yearend_process($year,$start_date,$end_date)){
				$this->session->set_flashdata('msg', 'Year end process completed. Please re-login to affect changes.');
				redirect('accounts/yearend');
				return;
			}else{
				$this->session->set_flashdata('error', 'Something went wrong. Please contact your service provider.');
				redirect('accounts/yearend');
				return;
			}
			
		}else{
			$data['years'] = $this->yearend_model->get_years();
			$data['year_lock'] = $this->yearend_model->check_lock(date('Y',strtotime($this->session->userdata('fy_end').'-1 year')));
			$this->load->view('accounts/yearend',$data);
		}
		
	}*/
	
	public function index(){
		$data['years'] = $this->yearend_model->get_years();
		$data['current_year'] = $this->yearend_model->get_current_year();
		$data['year_lock'] = $this->yearend_model->check_lock(date('Y',strtotime($this->session->userdata('fy_end').'-1 year')));
		$this->load->view('accounts/yearend',$data);
	}
	
	function change_year(){
		$year = $this->uri->segment(4);	
		if($this->yearend_model->change_year($year)){
			 redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	function lock_lastyear($year){
		if($this->yearend_model->lock_year($year)){
			$this->session->set_flashdata('msg', $year.' account database has been locked. Please re-login to proceed.');
			redirect('accounts/yearend');
			return;
		}else{
			$this->session->set_flashdata('error', 'Failed to lock '.$year.' account database.');
			redirect('accounts/yearend');
			return;
		}
	}
	
	function open_new_year($date){
		if($this->yearend_model->open_new_year($date)){
			$this->session->set_flashdata('msg','New year initialised. Please re-login to proceed.');
			redirect('accounts/yearend');
		}else{
			$this->session->set_flashdata('error', 'Failed to open new year.');
			redirect('accounts/yearend');
			return;
		}
	}
	
	function process(){
		if($this->yearend_model->year_end_process_new()){
			$this->session->set_flashdata('msg', 'Year end process completed. Please re-login to affect changes.');
			redirect('accounts/yearend');
		}else{
			$this->session->set_flashdata('error', 'Something went wrong. Please contact your service provider.');
			redirect('accounts/yearend');
		}
	}
	
	
}
