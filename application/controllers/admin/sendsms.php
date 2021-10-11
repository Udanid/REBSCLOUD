<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendsms extends CI_Controller {

	/**
	 * Index Page for this controller.
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
		$this->load->library('sms');
		
    }
	
	public function index()
	{
		$number = '0773670896';
		$message = 'Dear Customer, please settle the overdue amount of Rs. on Contract No. at your earliest. Ignore if already settled. Thank you. First Team Real Estate.';

		$sms = new Sms();
		echo ($sms->send_sms($number,$message));
		
	}

}
