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
		$this->load->model("hr/search_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
		$this->load->model("hr/common_hr_model");
		$this->load->model("hr/employee_model");

		//$this->is_logged_in();

    }

	public function index()
	{




	}
	public function searchpanel()
	{

		 $data['countryList'] = countryList(); //country list derived from constants helper
		 $data['maritalStatus'] = maritalStatus();
		 $data['bloodGroup'] = bloodGroup(); //blood groups
		 $data['employment_types'] = $this->common_hr_model->get_employment_type_list();
		 $data['designations'] = $this->common_hr_model->get_designation_list();
		 $data['branches'] = $this->common_hr_model->get_branch_list();
		 $data['divisions'] = $this->common_hr_model->get_division_list();
		 $data['employee_list'] = $this->employee_model->get_employee_list();
		 $data['province'] = province(); //provinces
		 //$data['religion'] = $this->common_hr_model->get_religion_list();
		 //$data['race'] = $this->common_hr_model->get_race_list();
		 //$data['higher_qlfct'] = $this->common_hr_model->get_education_qualification_list();
		 //$data['qlfct_field'] = $this->common_hr_model->get_qualification_field_list();
		 // $data['searchpanel_branchlist']=$this->search_model->get_all_branches_summery();
		 // $data['searchpanel_customerlist']=$this->customer_model->get_all_customer_summery();
		 // $data['searchpanel_prjlist']=$prjlist=$this->search_model->get_all_project_summery('ALL');
		$this->load->view('hr/advancesearch/searchpanel',$data);


	}
	function get_blocklist()
	{
		$data['searchpanel_lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(3));
		$this->load->view('hr/advancesearch/blocklist',$data);

	}
	public function search()//Updated by Madushan
	{
		$data['searchdata']=NULL;
		$data['searchlist']='';
				$data['searchpath']='searhpanel';
		$search_list=$this->input->post('search_list');
		$nationallity=$this->input->post('nationallity');
		$martial_status=$this->input->post('martial_status');
		$religion=$this->input->post('religion');
		$race=$this->input->post('race');
		$blood_group=$this->input->post('blood_group');
		$dob_from_date=$this->input->post('dob_fromdate');
		$dob_to_date=$this->input->post('dob_todate');
		$emp_type=$this->input->post('emp_type');
		$joining_fromdate=$this->input->post('joining_fromdate');
		$joining_todate=$this->input->post('joining_todate');
		$designation=$this->input->post('designation');
		/*Ticket No:2863 Added By Madushan 2021.05.21*/
		$data['branch']=$branch=$this->input->post('branch');
		$division=$this->input->post('division');
		$immediate_manager=$this->input->post('immediate_manager');
		$town=$this->input->post('town');
		$province=$this->input->post('province');
		$education=$this->input->post('education');
		$higher_education=$this->input->post('higher_education');
		$higher_education_area=$this->input->post('higher_education_area');
		$turnover_from=$this->input->post('turn_from');
		$turnover_to=$this->input->post('turn_to');

		/*Ticket No:2863 Added By Madushan 2021.05.21*/
		if($branch == '')
		{
			$branch = 'ALL';
		}

		if($search_list == "1")
		{
			$data['searchpanel_searchdata']=$this->search_model->personal_info_search($nationallity,$martial_status,$religion,$race,$blood_group,$dob_from_date,$dob_to_date,$branch,$division);
			$data['title'] = 'Search by personal information';
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/personal_info',$data);
		}

		if($search_list=='2')
		{
			$data['searchpanel_searchdata']=$this->search_model->employement_info_search($emp_type,$joining_fromdate,$joining_todate,$designation,$branch,$division,$immediate_manager,$town,$province);
				$data['title'] = 'Search by employement information';
			$this->session->set_flashdata('lastq',  $this->db->last_query());
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/personal_info',$data);
		}
		if($search_list=='3')
		{
			$data['title'] = 'Search by educational information';
			if($education == "1")
			{
				$data['searchpanel_searchdata']=$this->search_model->educational_al_info_search($branch,$division);

				$this->session->set_flashdata('lastq',  $this->db->last_query());
				$data['lastq'] =$this->db->last_query();
				$this->load->view('hr/advancesearch/personal_info',$data);
			}

			if($education == "2")
			{
				$data['searchpanel_searchdata']=$this->search_model->educational_ol_info_search($branch,$division);

				$this->session->set_flashdata('lastq',  $this->db->last_query());
				$data['lastq'] =$this->db->last_query();
				$this->load->view('hr/advancesearch/personal_info',$data);
			}

			if($education == "3")
			{
				$data['search_emp_no']=$search_emp_no=$this->search_model->higher_education_search($higher_education,$higher_education_area);
				// foreach($search_emp_no as $row)
				// {
				// 	echo $row.'<br>';
				// }

				// exit;
				$data['branch'] = $branch;
				$this->load->view('hr/advancesearch/personal_info_qlft',$data);
			}
		}
		if($search_list=='4')
		{	 /*Ticket No:2828 Added by Madushan 2021.05.13*/
			$data['searchpanel_searchdata']=$this->search_model->get_all_emp_branch_wise($branch,$division);
			$data['branch_list']=$this->common_hr_model->get_branch_list();
			$this->load->view('hr/advancesearch/age_analysis_report',$data);
		}
		if($search_list=='5')
		{	 /*Ticket No:2828 Added by Madushan 2021.05.13*/
			$data['searchpanel_searchdata']=$this->search_model->get_turnover_searchlist($branch,$turnover_from,$turnover_to,$division);
			$this->load->view('hr/advancesearch/turnover_rate',$data);
		}
		if($search_list=='6')
		{	/*Ticket No:2840 Added by Madushan 2021.05.14*/
			$data['searchpanel_searchdata']=$this->search_model->get_all_emp_branch_wise($branch,$division);
			$data['branch_list']=$this->common_hr_model->get_branch_list();
			$this->load->view('hr/advancesearch/gender_analysis',$data);
		}
		exit;
		if($searchlist=='allresvlist')
		{
			$data['searchpanel_searchdata']=$this->search_model->get_allsearch_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate);
			$this->session->set_flashdata('lastq',  $this->db->last_query());
		$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/reservation_list_all',$data);
		}



	}
	function reservationlist_excel()
	{
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/reservation_list_excel',$data);
	}
	function resalelist_excel()
	{
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/resale_list_excel',$data);
	}
	function outrightlist_excel()
	{
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/outright_list_excel',$data);
	}
	function loanlist_excel()
	{
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/loan_list_excel',$data);
	}
	function reschedulelist_excel()
	{
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/reshedule_list_excel',$data);
	}
	function rebatelist_excel()
	{
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/rebate_list_excel',$data);
	}

	function employee_search_excel()
	{//updated by Madushan
		$query = $this->db->query($this->input->post('lastq'));
		$data['searchpanel_searchdata']=$query->result();
			$data['lastq'] =$this->db->last_query();
			$this->load->view('hr/advancesearch/personal_info_excel',$data);
	}

	/*Ticket No:2863 Added By Madushan 2021.05.21*/
	function get_age_analysis_popup($category,$branch)
	{

		// echo $branch;
		// exit;
		$data['searchpanel_searchdata']=$this->search_model->get_all_emp_branch_wise($branch,"");
		$data['branch_list']=$this->common_hr_model->get_branch_list();

		if($category == '1')
		{
			$data['category'] = '18-30';
		}
		if($category == '2')
		{
			$data['category'] = '31-40';
		}
		if($category == '3')
		{
			$data['category'] = '41-50';
		}
		if($category == '4')
		{
			$data['category'] = '51-Above';
		}
		$this->load->view('hr/advancesearch/age_analysis_popup',$data);
	}

	/*Ticket No:2863 Added By Madushan 2021.05.21*/
	function get_gender_analysis_popup($gender,$branch){

		$data['searchpanel_searchdata']=$this->search_model->get_all_emp_branch_wise($branch,"");
		$data['branch_list']=$this->common_hr_model->get_branch_list();

		if($gender == '1')
		{
			$data['gender'] = 'Female';
		}
		if($gender == '2')
		{
			$data['gender'] = 'Male';
		}
		$this->load->view('hr/advancesearch/gender_analysis_popup',$data);
	}



	}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
