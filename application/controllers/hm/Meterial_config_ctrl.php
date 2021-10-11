<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meterial_config_ctrl extends CI_Controller {

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

        $this->is_logged_in();
	 }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('add_meterials'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home');
			return;
		}
		redirect('hm/meterial_config_ctrl/meterialview');
	
	}

    public function meterialview(){
    	if ( ! check_access('add_meterials'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
    	$this->load->view('hm/config/meterial_view');
    }



}