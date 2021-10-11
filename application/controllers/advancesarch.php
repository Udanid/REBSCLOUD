<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advancesarch extends CI_Controller {

	/**
	 * Index Page for this controller.land
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


		$this->load->model("branch_model");
		$this->load->model("common_model");
		$this->load->model("reservation_model");
		$this->load->model("search_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
	
		//$this->is_logged_in();

    }

	public function index()
	{
		



	}
	public function searchpanel()
	{
		
		 $data['searchpanel_branchlist']=$this->search_model->get_all_branches_summery();
		 $data['searchpanel_customerlist']=$this->customer_model->get_all_customer_summery();
		 $data['searchpanel_prjlist']=$prjlist=$this->search_model->get_all_project_summery('ALL');
		$this->load->view('advancesearch/searchpanel',$data);
			

	}
	function get_blocklist()
	{
		$data['searchpanel_lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(3));
		$this->load->view('advancesearch/blocklist',$data);
		
	}
	public function search()
	{
		$data['searchdata']=NULL;
		$data['searchlist']='';
				$data['searchpath']='searhpanel';
		$searchlist=$this->input->post('searchpanel_search_list');
		$branch_code=$this->input->post('searchpanel_branch_code');
		$prj_id=$this->input->post('searchpanel_prj_id');
		$cus_code=$this->input->post('searchpanel_cus_code');
		$fromdate=$this->input->post('searchpanel_fromdate');
		$todate=$this->input->post('searchpanel_todate');
		$lot_id=$this->input->post('searchpanel_lot_id');
		if($searchlist=='reservation')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_reservation_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/reservation_list',$data);
		}
		if($searchlist=='resale')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_resale_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/resale_list',$data);
		}
		if($searchlist=='outright')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_outright_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/outright_list',$data);
		}
		if($searchlist=='eploan')
		{
			$loantype=$this->input->post('searchpanel_loan_type');
			$data['searchpanel_searchdata']=$this->search_model->get_loan_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate,$loantype);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/loan_list',$data);
		}
		if($searchlist=='reshedule')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_reshedule_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/reshedule_list',$data);
		}
		if($searchlist=='rebate')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_rebate_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/rebate_list',$data);
		}
		if($searchlist=='lresale')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_loanresale_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/loanresale_list',$data);
		}
		if($searchlist=='allresvlist')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_allsearch_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/reservation_list_all',$data);
		}
		 
		
			

	}
	function reservationlist_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['searchpanel_searchdata']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/reservation_list_excel',$data);
	}
	function resalelist_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['searchpanel_searchdata']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/resale_list_excel',$data);
	}
	function outrightlist_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['searchpanel_searchdata']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/outright_list_excel',$data);
	}
	function loanlist_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['searchpanel_searchdata']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/loan_list_excel',$data);
	}
	function reschedulelist_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['searchpanel_searchdata']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/reshedule_list_excel',$data);
	}
	function rebatelist_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['searchpanel_searchdata']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('advancesearch/rebate_list_excel',$data);
	}
	
	}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
