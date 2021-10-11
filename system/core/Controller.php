<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
//$this->load->model("common_model");
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->output->set_header("HTTP/1.0 200 OK");
$this->output->set_header("HTTP/1.1 200 OK");
$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache");
		date_default_timezone_set('Asia/Colombo');
		$this->load->initialize();
		
		
		if ($this->session->userdata('companycode')){
			
		//	echo $this->session->userdata('companycode');
				
			
         $this->db=$this->load->database($this->session->userdata('companycode'), TRUE);
        }
        else
        {
		//	echo 'ssssssssssssssss'. $this->session->userdata('companycode');
            $this->db=$this->load->database('default', TRUE);
        }
	
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
	function is_logged_in() {
		if($this->session->userdata('activtable')!=NULL)
		{
			$this->common_model->delete_curent_tabactivflag($this->session->userdata('activtable'));
		}
        $is_logged_in = $this->session->userdata('username');
		$is_usertype = $this->session->userdata('usertype');
        if ((!isset($is_logged_in) || $is_logged_in == "")) {
            $this->session->set_flashdata('return_url', current_url());
			$this->common_model->release_user_activeflag($this->session->userdata('userid'));
            redirect('login/index');
        }
		else if($is_usertype=="user")
		{
			$this->session->set_flashdata('return_url', current_url());
			  redirect('login/index');
		}
		else
		{
			$data=get_current_period();
			if($data)
			{
			$session = array('current_start'=>$data->start_date, 'current_end'=>$data->end_date);
			}
			else
			{
				$session = array('current_start'=>date('Y-m-d'), 'current_end'=>date('Y-m-d'));
			}
			$this->session->set_userdata($session);
			$this->session->set_flashdata('return_url', current_url());
		}
		
		
    }
	function pagination($pagecount,$siteurl,$tablename)
	{
			$this->load->library('pagination');
			$config['base_url'] = site_url($siteurl);
			$config['uri_segment'] = 4;
			$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
			$config['num_links'] = 10;
			$config['per_page'] = $pagination_counter;
			$config['full_tag_open'] = '<ul id="pagination-flickr">';
			$config['full_close_open'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active">';
			$config['cur_tag_close'] = '</li>';
			$config['next_link'] = 'Next &#187;';
			$config['next_tag_open'] = '<li class="next">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&#171; Previous';
			$config['prev_tag_open'] = '<li class="previous">';
			$config['prev_tag_close'] = '</li>';
			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li class="first">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li class="last">';
			$config['last_tag_close'] = '</li>';
			$startcounter=($pagecount)*$pagination_counter;
		
			$config['total_rows'] = $this->db->count_all($tablename);
			//echo $pagination_counter;
			$this->pagination->initialize($config);
	}
	function pagination_entries($pagecount,$siteurl,$type)
	{
			$this->load->library('pagination');
			$config['base_url'] = site_url($siteurl);
			$config['uri_segment'] = 5;
			$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
			$config['num_links'] = 10;
			$config['per_page'] = $pagination_counter;
			$config['full_tag_open'] = '<ul id="pagination-flickr">';
			$config['full_close_open'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active">';
			$config['cur_tag_close'] = '</li>';
			$config['next_link'] = 'Next &#187;';
			$config['next_tag_open'] = '<li class="next">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&#171; Previous';
			$config['prev_tag_open'] = '<li class="previous">';
			$config['prev_tag_close'] = '</li>';
			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li class="first">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li class="last">';
			$config['last_tag_close'] = '</li>';
			$startcounter=($pagecount)*$pagination_counter;
		
			 $this->db->select('*');
			 $this->db->where('entry_type',$type);
			 $query = $this->db->get('ac_entries');
			$config['total_rows'] =$query->num_rows();
			//echo $pagination_counter;
			$this->pagination->initialize($config);
	}
	function pagination_status($pagecount,$siteurl,$tablename,$statusfield,$status)
	{
			$this->load->library('pagination');
			$config['base_url'] = site_url($siteurl);
			$config['uri_segment'] = 4;
			$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
			$config['num_links'] = 10;
			$config['per_page'] = $pagination_counter;
			$config['full_tag_open'] = '<ul id="pagination-flickr">';
			$config['full_close_open'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active">';
			$config['cur_tag_close'] = '</li>';
			$config['next_link'] = 'Next &#187;';
			$config['next_tag_open'] = '<li class="next">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&#171; Previous';
			$config['prev_tag_open'] = '<li class="previous">';
			$config['prev_tag_close'] = '</li>';
			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li class="first">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li class="last">';
			$config['last_tag_close'] = '</li>';
			$startcounter=($pagecount)*$pagination_counter;
		
			 $this->db->select('*');
			 $this->db->where($statusfield,$status);
			 $query = $this->db->get($tablename);
			$config['total_rows'] =$query->num_rows();
			//echo $pagination_counter;
			$this->pagination->initialize($config);
	}
	function pagination_status_double($pagecount,$siteurl,$tablename,$statusfield,$status)
	{
			$this->load->library('pagination');
			$config['base_url'] = site_url($siteurl);
			$config['uri_segment'] = 4;
			$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
			$config['num_links'] = 10;
			$config['per_page'] = $pagination_counter;
			$config['full_tag_open'] = '<ul id="pagination-flickr">';
			$config['full_close_open'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active">';
			$config['cur_tag_close'] = '</li>';
			$config['next_link'] = 'Next &#187;';
			$config['next_tag_open'] = '<li class="next">';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&#171; Previous';
			$config['prev_tag_open'] = '<li class="previous">';
			$config['prev_tag_close'] = '</li>';
			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li class="first">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li class="last">';
			$config['last_tag_close'] = '</li>';
			$startcounter=($pagecount)*$pagination_counter;
		
		
			 $this->db->select('*');
			 $this->db->where_in($statusfield,$status);
			 $query = $this->db->get($tablename);
			$config['total_rows'] =$query->num_rows();
			//$config['total_rows'] = $this->db->count_all($tablename);
			//echo $pagination_counter;
			$this->pagination->initialize($config);
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */