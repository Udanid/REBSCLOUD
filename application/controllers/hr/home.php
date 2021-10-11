<?php
class Home extends CI_Controller{

	public function __construct() {
    	parent::__construct();
    	$this->is_logged_in();
  	}

  	public function index(){
    	$data['title'] = "Home";
    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('hr/home');
    	$this->load->view('includes/footer');
  	}

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}
	
	
}
?>
