<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashadvance extends CI_Controller {

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

		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("project_model");
		$this->load->model("projectpayment_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		$data=NULL;

		redirect('accounts/cashadvance/showall');



	}
	public function showall()
	{
		//$this->output->delete_cache();
		if ( ! check_access('view_cashebook_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data=NULL;

		$data['list']=$list=$this->uri->segment(4);
		$data['searchdata']=$inventory=$this->cashadvance_model->get_allbook_types();
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['ledgerlist']=$inventory=$this->cashadvance_model->get_all_ledgers();
			$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;

				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/cashadvance/cashbook_config';
				$data['tag']='Search Document Types';

	$this->load->view('accounts/cashadvance/cashbook_config',$data);



	}



	public function add_type()
	{

		if ( ! check_access('add_cashebook_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->cashadvance_model->add_type();

		$this->session->set_flashdata('msg', 'Cash Book Type Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('type_name').'  successfully Inserted');
		redirect("accounts/cashadvance/showall");

	}
	function delete_chercker(){
		//$this->load->model("config_model");
		$id=$this->input->get('id');
		if($this->cashadvance_model->check_booktype_used($id))
		{

			echo "This Cash Book Type Already Used";

			//echo "This record already open ";
		}
		//echo "This record already open ";
	//	$data['divisionlist']=$this->config_model->get_division_byzone($zondata->ZONENAME);
		//$this->load->view('manage/common/divisions', $data);
	}
	public function delete_type()
	{if ( ! check_access('delete_cashebook_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->delete_type($this->uri->segment(4));

			$this->session->set_flashdata('msg', 'Cashook Type Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  successfully Deleted');
		redirect("accounts/cashadvance/showall");

	}
	public function add_book()
	{
		if ( ! check_access('add_cashebook_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->add_book();

		$this->session->set_flashdata('msg', 'Cash Book  Successfully Inserted ');
		$this->logger->write_message("success", 'Cash Book  successfully Inserted');
		redirect("accounts/cashadvance/showall/book");

	}
	public function cashbooks()
	{
		//$this->output->delete_cache();
		if ( ! check_access('view_cashebook'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data=NULL;

		$data['list']=$list=$this->uri->segment(4);
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;

				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/cashadvance/cashbook_config';
				$data['tag']='Search Document Types';

		$this->load->view('accounts/cashadvance/cashbook_main',$data);



	}

	function denomination()
	{
		$data=NULL;

		$data['list']=$list=$this->uri->segment(4);
		$data['details']=$details=$this->cashadvance_model->get_cashbook_data($this->uri->segment(4));
		$data['advancedata']=$inventory=$this->cashadvance_model->get_cashbook_advancedata($this->uri->segment(4));
			$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($details->ledger_id);


		$this->load->view('accounts/cashadvance/denomination',$data);
	}
	function update_denomination()
	{
		if ( ! check_access('update_denomination'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
			$id=$this->cashadvance_model->update_denomination();

		$this->session->set_flashdata('msg', 'Cash Book Denomination  Successfully Updates ');
		$this->logger->write_message("success", 'Cash Book  successfully Inserted');
		redirect("accounts/cashadvance/cashbooks");

	}
	public function advancelist()
	{
		if ( ! check_access('view_cashadvance_list'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		//$this->output->delete_cache();

		$data=NULL;
		$data['pay_type']=$pay_type='CHQ';
		 /* Pagination setup */
        $this->load->library('pagination');

		$config = array();
        $config["base_url"] = base_url() . "accounts/cashadvance/advancelist";
        $config["per_page"] = 20;
		$config["num_links"] = 10;
        $config["uri_segment"] = 4;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';



		$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['list']=$list=$this->uri->segment(4);
		if ($page != 0){
			$data['list']='book';
		}

		$data['mylist']=$mylist='test';
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books($pay_type);
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
        $data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['approvlist']=$this->common_model->get_privilage_officer_list('approve_cashadvance');
		 $data['check_list']=$this->common_model->get_privilage_officer_list('check_cashadvance');

				$courseSelectList="";
				 $count=0;
					$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/cashadvance/cashbook_config';
				if (  check_access('all_cashadvances'))
				{
					//echo "sss";
					$data['officersettlflag']=false;
					$data['advlist']=$this->cashadvance_model->get_all_cash_advancedata($config["per_page"],$page,$pay_type);
					$config["total_rows"] = $this->cashadvance_model->count_cash_advancedata_all();
				}
				else
				{
					$data['officersettlflag']=$this->cashadvance_model->check_officer_unsettled_advance($this->session->userdata('userid'));

					$data['advlist']=$this->cashadvance_model->get_officers_cash_advancedata($this->session->userdata('userid'),$config["per_page"],$page,$pay_type);
					$config["total_rows"] = $this->cashadvance_model->count_cash_advancedata_officer($this->session->userdata('userid'));
				}

				$data['tag']='Search Document Types';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('accounts/cashadvance/cashadvance_main',$data);
	}
		public function iou()
	{
		if ( ! check_access('view_cashadvance_list'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		//$this->output->delete_cache();
		$data=NULL;
		 /* Pagination setup */
		 $data['pay_type']=$pay_type='CSH';
        $this->load->library('pagination');

		$config = array();
        $config["base_url"] = base_url() . "accounts/cashadvance/iou";
        $config["per_page"] = 20;
		$config["num_links"] = 10;
        $config["uri_segment"] = 4;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';



		$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['list']=$list=$this->uri->segment(4);
		if ($page != 0){
			$data['list']='book';
		}

		$data['mylist']=$mylist='test';
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books($pay_type);
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
        $data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['approvlist']=$this->common_model->get_privilage_officer_list('approve_cashadvance');
		 $data['check_list']=$this->common_model->get_privilage_officer_list('check_cashadvance');

				$courseSelectList="";
				 $count=0;
					$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/cashadvance/cashbook_config';
				if (  check_access('all_cashadvances'))
				{
					//echo "sss";
					$data['officersettlflag']=false;
					$data['advlist']=$this->cashadvance_model->get_all_cash_advancedata($config["per_page"],$page,$pay_type);
					$config["total_rows"] = $this->cashadvance_model->count_cash_advancedata_all();
				}
				else
				{

				$data['officersettlflag']=$this->cashadvance_model->check_officer_unsettled_advance($this->session->userdata('userid'));
					$data['advlist']=$this->cashadvance_model->get_officers_cash_advancedata($this->session->userdata('userid'),$config["per_page"],$page,$pay_type);
					$config["total_rows"] = $this->cashadvance_model->count_cash_advancedata_officer($this->session->userdata('userid'));
				}

				$data['tag']='Search Document Types';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('accounts/cashadvance/cashadvance_main',$data);
	}
	function search(){


		//$allsearch = $advance_no.$name.$amountsearch.$pay_status;



		//$this->output->delete_cache();
		$data=NULL;
		 /* Pagination setup */
        $this->load->library('pagination');

		$config = array();
        $config["base_url"] = base_url() . "accounts/cashadvance/search";
        $config["per_page"] = 200;
		$config["num_links"] = 10;
        $config["uri_segment"] = 4;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';



		$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['list']='book';
		if ($page != 0){
			$data['list']='book';
		}

		$data['mylist']=$mylist='test';
			$data['pay_type']=$pay_type=$this->input->post('pay_type');
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books($pay_type);
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
        $data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['approvlist']=$this->common_model->get_privilage_officer_list('approve_cashadvance');
		 $data['check_list']=$this->common_model->get_privilage_officer_list('check_cashadvance');

		$courseSelectList="";
		$count=0;
		$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['searchlist']=$courseSelectList;
		$data['searchpath']='accounts/cashadvance/cashbook_config';
		if (check_access('confirm_cashadvance'))
		{
			$data['officersettlflag']=false;
			$data['advlist']=$this->cashadvance_model->get_all_cash_advancedata_search($config["per_page"],$page);
			$config["total_rows"] = 200;
		}
		else
		{
			$data['officersettlflag']=$this->cashadvance_model->check_officer_unsettled_advance($this->session->userdata('userid'));
			$data['advlist']=$this->cashadvance_model->get_officers_cash_advancedata_search($this->session->userdata('userid'),$config["per_page"],$page);
			$config["total_rows"] = 200;
		}
		$data['tag']='Search Document Types';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$this->load->view('accounts/cashadvance/cashadvance_main',$data);
	}

	function set_cashbook(){
		$bookid = $this->input->post('bookid');
		echo $bookid;
		if($bookid=='all'){
			$this->session->set_userdata('cashbookid', '');
		}else{
			$this->session->set_userdata('cashbookid', $bookid);
		}
	}

	public function get_tasklist()
	{
			$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));

		$this->load->view('accounts/cashadvance/task_list',$data);
	}
	public function add_advance()
	{

		if ( ! check_access('add_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->cashadvance_model->add_advance();

		$aprofficer=$this->input->post('check_officerid');
		$this->common_model->add_notification_officer('ac_cashadvance','Cash Advance to check','accounts/cashadvance/advancelist/book',$id,$aprofficer);

		$this->session->set_flashdata('msg', 'Cash Advance  Successfully Inserted ');
		$this->logger->write_message("success", 'Cash Advance  successfully Inserted');
		$pay_type=get_booktype_by_advanceid($id);
		if($pay_type=='CHQ')
		{
			$this->common_model->add_notification_officer('ac_cashadvance','Cash Advance to check','accounts/cashadvance/advancelist/book',$id,$aprofficer);
		redirect("accounts/cashadvance/advancelist");
		}
		else
		{
			$this->common_model->add_notification_officer('ac_cashadvance','IOU Request to check','accounts/cashadvance/iou/book',$id,$aprofficer);
		redirect("accounts/cashadvance/iou");
		}
	}
	public function delete_advance($id)
	{
		if ( ! check_access('delete_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$pay_type=get_booktype_by_advanceid($this->uri->segment(4));
		$id=$this->cashadvance_model->delete_advance($this->uri->segment(4));

		$this->common_model->delete_notification('ac_cashadvance',$this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Cash Advance  Successfully Deleted ');
		$this->logger->write_message("success", 'Cash Advance  successfully Deleted');

		if($pay_type=='CHQ')
		redirect("accounts/cashadvance/advancelist");
		else
		redirect("accounts/cashadvance/iou");

	}

	public function check_advance()
	{
		if ( ! check_access('check_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->check_advance($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashadvance',$this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Cash Advance  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance  successfully Confirmed');
		$advancedata=$this->cashadvance_model->get_cashadvancedata($this->uri->segment(4));
		$aprofficer=$advancedata->apprved_officerid;


		$pay_type=get_booktype_by_advanceid($this->uri->segment(4));
		if($pay_type=='CHQ')
		{
			$this->common_model->add_notification_officer('ac_cashadvance','Cash Advance To Approve','accounts/cashadvance/advancelist/book',$this->uri->segment(4),$aprofficer);
		redirect("accounts/cashadvance/advancelist");
		}
		else
		{
			$this->common_model->add_notification_officer('ac_cashadvance','IOU Request To Approve','accounts/cashadvance/iou/book',$this->uri->segment(4),$aprofficer);
		redirect("accounts/cashadvance/iou");
		}

	}

	public function confirm_advance()
	{
		if ( ! check_access('approve_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->confirm_advance($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashadvance',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Cash Advance  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance  successfully Confirmed');
		$pay_type=get_booktype_by_advanceid($this->uri->segment(4));
		if($pay_type=='CHQ')
		redirect("accounts/cashadvance/advancelist");
		else
		redirect("accounts/cashadvance/iou");

	}
	public function get_cashadvance()
	{

		$data['details']=$this->cashadvance_model->get_cashadvancedata($this->uri->segment(4));
		$data['tasklist']=$this->cashadvance_model->get_cashadvance_taskdata($this->uri->segment(4));
		$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));


			$this->load->view('accounts/cashadvance/cashadvance_edit',$data);

	}
	public function edit_advancedata()
	{
		if ( ! check_access('edit_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->edit_advancedata();


		$this->session->set_flashdata('msg', 'Cash Advance  Successfully Edited ');
		$this->logger->write_message("success", 'Cash Advance  successfully Edited');
		$pay_type=get_booktype_by_advanceid($this->input->post('adv_id'));
		if($pay_type=='CHQ')
		redirect("accounts/cashadvance/advancelist");
		else
		redirect("accounts/cashadvance/iou");

	}
	public function pay_cash()
	{
		$id=$this->input->get('id');
		$id=$this->cashadvance_model->pay_cash($id);
		if(!$id)
		{
			echo 'Could not make payment for this cash advance'		;	
		}


	}
	public function refund_cash()
	{
		$id=$this->input->get('id');
		if($this->cashadvance_model->chaeck_pending_settlements_id($id))
		{
		echo "Please Settle all Pending vouchers before cash refund" ;

		}
		else

		$id=$this->cashadvance_model->refund_cash($id);


	}

	public function settlement()
	{

		if ( ! check_access('view_cash_settlements'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data=NULL;

		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']='';
				$data['searchpath']='accounts/cashadvance/cashbook_config';
    		  if (check_access('all_cashadvances'))
				{
					$data['advlist']=$this->cashadvance_model->get_Paid_advancedata();
                    $data['settlelist']=$this->cashadvance_model->get_fullsettlmentdata();
				}
				else
				{
					//$prjlist=$this->cashadvance_model->project_managers_prjlist($this->session->userdata('branchid'));
					//if($prjlist){
					//	$data['advlist']=$this->cashadvance_model->get_managers_cash_advancedata($prjlist);
				//	}
				//	else
					$data['advlist']=$this->cashadvance_model->get_Paid_advancedata_officer($this->session->userdata('userid'));
                     $data['settlelist']=$this->cashadvance_model->get_fullsettlmentdata_officer($this->session->userdata('userid'));
				}
				$data['ledgerlist']=$this->cashadvance_model->get_active_ledgerlist();
				$data['invoice']=$this->invoice_model->get_not_paid_invoices_project();



				$data['tag']='Search Document Types';

		$this->load->view('accounts/cashadvance/settlement_main',$data);

	}
	public function add_settlment()
	{
		if ( ! check_access('add_cash_settlements'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->cashadvance_model->add_settlment();
	//	echo $id;
		$advid=explode('-', $this->input->post('adv_id'));
		$advancedata=$this->cashadvance_model->get_cashadvancedata($advid['0']);
		$aprofficer=$advancedata->check_officerid;
		$this->common_model->add_notification_officer('ac_cashsettlement','Cash Advance Settlement to  Check','accounts/cashadvance/settlement/book',$id,$aprofficer);

		$this->session->set_flashdata('msg', 'Cash Advance  Successfully Inserted ');
		$this->logger->write_message("success", 'Cash Advance  successfully Inserted');
		redirect("accounts/cashadvance/settlement");

	}
	public function get_settementdata($id)
	{

			$data['advlist']=$this->cashadvance_model->get_Paid_advancedata();
				$data['invoice']=$this->invoice_model->get_not_paid_invoices_project();
				$data['settledata']=$settledata=$this->cashadvance_model->get_settlmentdata($id);
				print_r($id);


			$this->load->view('accounts/cashadvance/settlement_edit',$data);

	}


	public function check_settlement()
	{
		if ( ! check_access('check_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}



		$id=$this->cashadvance_model->check_settlement($this->uri->segment(4));

		$this->common_model->delete_notification('ac_cashsettlement',$this->uri->segment(4));

		$settledata=$this->cashadvance_model->get_settlmentdata($this->uri->segment(4));
		$advancedata=$this->cashadvance_model->get_cashadvancedata($settledata->adv_id);
		$aprofficer=$advancedata->confirm_officerid;

				$this->common_model->add_notification_officer('ac_cashsettlement','Cash Advance Settlement to  Confirm','accounts/cashadvance/settlement/book',$this->uri->segment(4),$aprofficer);





		$this->session->set_flashdata('msg', 'Cash Advance Settlement  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Confirmed');
			redirect("accounts/cashadvance/settlement");

	}
	public function confirm_settlement()
	{
		if ( ! check_access('confirm_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->confirm_settlment($this->uri->segment(4));
				$this->common_model->delete_notification('ac_cashsettlement',$this->uri->segment(4));


				$settledata=$this->cashadvance_model->get_settlmentdata($this->uri->segment(4));
		$advancedata=$this->cashadvance_model->get_cashadvancedata($settledata->adv_id);
		$aprofficer=$advancedata->apprved_officerid;

		$this->common_model->add_notification_officer('ac_cashsettlement','Cash Advance Settlement to  Approve','accounts/cashadvance/settlement/book',$this->uri->segment(4),$aprofficer);

		$this->session->set_flashdata('msg', 'Cash Advance Settlement  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Confirmed');
			redirect("accounts/cashadvance/settlement");

	}
	public function approve_settlement()
	{
		if ( ! check_access('approve_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->cashadvance_model->approved_settlment($this->uri->segment(4));
				$this->common_model->delete_notification('ac_cashsettlement',$this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Cash Advance Settlement  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Confirmed');
			redirect("accounts/cashadvance/settlement");

	}
	public function delete_settlement()
	{

		$id=$this->cashadvance_model->delete_settlement($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashsettlement',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Cash Advance Settlement  Successfully Deleted ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Deleted');
			redirect("accounts/cashadvance/settlement");

	}
	function test($id)
	{
	$id=$this->cashadvance_model->delete_cashadvance_onpayment($this->uri->segment(4));
	}
	function cash_advance_report()
	{

		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
					$data['searchlist']='';
				$data['searchpath']='accounts/cashadvance/cashbook_config';
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();

				$data['tag']='Search Document Types';

		$this->load->view('accounts/cashadvance/report_main',$data);
	}
	function report_data()
	{
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->get_settlement_data_bybook($bookid,$rptdate);
		$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
		$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);

		$this->load->view('accounts/cashadvance/report_data',$data);
	}
		function report_data_excel()
	{
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->get_settlement_data_bybook($bookid,$rptdate);
		$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
		$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);

		$this->load->view('accounts/cashadvance/report_data_excel',$data);
	}
	function confirm_report()
	{
		if ( ! check_access('confirm_advance_report_data'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		//$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->confirm_settlement_data_bybook($bookid,$rptdate);
	//	$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
	//	$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);
$this->session->set_flashdata('msg', 'Cash Advance Reimbersment successfully Updated ');
		//$this->logger->write_message("success", 'Cash Advance Settlement  successfully Deleted');
			//redirect("accounts/cashadvance/settlement");
			redirect("accounts/cashadvance/cash_advance_report");
	}
	function check_officer_unsettled_advance(){

		$officer_id = $this->input->post('officer_id');
		$data=$this->cashadvance_model->check_officer_unsettled_advance($officer_id);
		if($data)
		echo 'This officer has unsettled cash advances';
	}


	public function report()
{
	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
	$data['tasklist']=$this->cashadvance_model->all_tasklist();
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	//Uvini
	$data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['booklist']=$inventory=$this->cashadvance_model->get_all_books();


	$this->load->view('accounts/cashadvance/settlement_report_main',$data);
}
function full_report()
{
	$reportnames=$this->input->post('reportnames');
	//Ticket No:3074 Added By Madushan 2021-07-12
	$book_type=$this->input->post('book_id1');
	//Uvini
	$branch=$this->input->post('branch');
	$fromdate=$this->input->post('fromdate');
	$todate=$this->input->post('todate');
	$officer_id=$this->input->post('officer_id');
	$amount=$this->input->post('amount');
	$prj_id=$this->input->post('prj_id');
	$task_id=$this->input->post('task_id');
	$book_id=$this->input->post('book_id');
	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
	$data['tasklist']=$this->cashadvance_model->all_tasklist();
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	if($reportnames=='01') //Ticket No-2800 | Added By Uvini
	$this->cashadvance_data($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,'CHQ',$branch);
	else if($reportnames=='04') //Ticket No-2800 | Added By Uvini
	$this->cashadvance_data($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,'CSH',$branch);
	else if($reportnames=='05') //Ticket No-2800 | Added By Uvini
	$this->iou_settlement_report($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,$book_id,$branch);
	// else if($reportnames=='02')
	// $this->unsettlement_report_data($fromdate,$todate,$officer_id,$amount);
	else if($reportnames=='03')
	$this->unsettlement_report_data_timeexceed($officer_id,$book_type,$branch);
	else
	$this->settlement_report();

}
function settlement_report_data($fromdate,$todate,$officer_id,$amount)
{

	//$data['fromdate']=$fromdate=$this->uri->segment(4);
//	$data['todate']=$todate=$this->uri->segment(5);
//	$data['officer_id']=$officer_id=$this->uri->segment(4);
	$data['settledlist']=$settledlist=$this->cashadvance_model->get_settlement_data($fromdate,$todate,$officer_id,$amount);
	$ledger_data=Null;
	//print_r($settledlist);
	$task_data=Null;
	if($settledlist){
		foreach ($settledlist as $key => $value) {
			$ledger_data[$value->adv_id]=null;
			if($value->payvoucher_id)
			{
				$ledger_data[$value->adv_id]=$this->cashadvance_model->get_ledgerdata_byvoucher($value->voucher_id);

			}
			$task_data[$value->adv_id]=$this->cashadvance_model->get_project_paymeny_advanceid($value->adv_id);
		}
	}

	$data['fromdate']=$fromdate;
	$data['todate']=$todate;
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
	$data['tasklist']=$this->cashadvance_model->all_tasklist();
		$data['booklist']=$inventory=$this->cashadvance_model->get_all_books();
	$data['task_data']=$task_data;
	$data['ledger_data']=$ledger_data;
	//print_r($ledger_data);
	$this->load->view('accounts/cashadvance/settlement_report_data',$data);

}//ticket end 1322
//ticketnumber 1520 updated by nadee
function unsettlement_report_data($fromdate,$todate,$officer_id,$amount)
{
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
//	$data['todate']=$todate=$this->uri->segment(5);
//	$data['officer_id']=$officer_id=$this->uri->segment(4);
	$data['settledlist']=$settledlist=$this->cashadvance_model->get_unsettlement_data($fromdate,$todate,$officer_id,$amount);
	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
	$data['tasklist']=$this->cashadvance_model->all_tasklist();
		$data['booklist']=$inventory=$this->cashadvance_model->get_all_books();
//print_r($settledlist);
	//print_r($ledger_data);
	$settled_data=Null;
	if($settledlist)
	{
		foreach ($settledlist as $key => $raw) {
			$bal=$raw->amount-$raw->settled_amount-$raw->refund_amount;

			$unsettled_data[$raw->adv_id]=$this->cashadvance_model->get_settlement_details($raw->adv_id);

		}
	}
	$data['fromdate']=$fromdate;
	$data['todate']=$todate;
	$data['unsettled_data']=$unsettled_data;
	$this->load->view('accounts/cashadvance/unsettlement_report_data',$data);

}
//Ticket No:3074 Updated By Madushan 2021-07-12
function unsettlement_report_data_timeexceed($officer_id,$book_type,$branch)
{
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
	$data['tasklist']=$this->cashadvance_model->all_tasklist();
		$data['booklist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['branchlist']=$this->branch_model->get_all_branches_summery();
//	$data['todate']=$todate=$this->uri->segment(5);
//	$data['officer_id']=$officer_id=$this->uri->segment(4);
	$data['settledlist']=$settledlist=$this->cashadvance_model->get_unsettlement_data_time_exceed($officer_id,$book_type,$branch);
//print_r($settledlist);
	//print_r($ledger_data);
	$unsettled_data=Null;
	if($settledlist)
	{
		foreach ($settledlist as $key => $raw) {
			$bal=$raw->amount-$raw->settled_amount-$raw->refund_amount;

			$unsettled_data[$raw->adv_id]=$this->cashadvance_model->get_settlement_details($raw->adv_id);

		}
	}
	$data['fromdate']='';
	$data['todate']=date('Y-m-d');
	$data['book_type'] = $book_type;
	$data['unsettled_data']=$unsettled_data;
	$this->load->view('accounts/cashadvance/unsettlement_report_data',$data);

}

function print_checklist()
{


		$data['details']=$this->cashadvance_model->get_checked_cashadvancelist();


			$this->load->view('accounts/cashadvance/print_checkadvancelist',$data);


}

//Ticket No-2800 | Added By Uvini
function cashadvance_data($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,$pay_type,$branch)
{
	$data['settledlist']=$settledlist=$this->cashadvance_model->cashadvance_data_report($fromdate,$todate,$officer_id,$amount,$prj_id,$pay_type,$branch);
	$ledger_data=Null;
	//print_r($settledlist);
	$task_data=Null;
	if($settledlist){
		foreach ($settledlist as $key => $value) {
			$ledger_data[$value->adv_id]=null;
			if($value->payvoucher_id)
			{
				$ledger_data[$value->adv_id]=$this->cashadvance_model->get_ledgerdata_byvoucher($value->voucher_id);

			}
			$task_data[$value->adv_id]=$this->cashadvance_model->get_project_paymeny_advanceid($value->adv_id);
		}
	}

	$unsettled_data=Null;
	if($settledlist)
	{
		foreach ($settledlist as $key => $raw) {
			$bal=$raw->amount-$raw->settled_amount-$raw->refund_amount;

			$unsettled_data[$raw->adv_id]=$this->cashadvance_model->get_settlement_details_task($raw->adv_id,$prj_id,$task_id);

		}
	}

$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
	$data['tasklist']=$this->cashadvance_model->all_tasklist();
	$data['fromdate']=$fromdate;
	$data['todate']=$todate;
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['booklist']=$inventory=$this->cashadvance_model->get_all_books();
	$data['task_data']=$task_data;
	$data['ledger_data']=$ledger_data;
	$data['unsettled_data']=$unsettled_data;
	//uvini
	$data['branchlist']=$this->branch_model->get_all_branches_summery();
	//print_r($ledger_data);
	$this->load->view('accounts/cashadvance/settlement_report',$data);
}

// cash advance settlment date edit  ticket number 2883
public function edit_settledate_cashadvance()
	{

		$data['details']=$this->cashadvance_model->get_cashadvancedata($this->uri->segment(4));
		$data['tasklist']=$this->cashadvance_model->get_cashadvance_taskdata($this->uri->segment(4));
		$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));


			$this->load->view('accounts/cashadvance/cashadvance_edit_settledate',$data);

	}
	public function edit_settledate()
	{
		$adv_id=$this->input->post('adv_id');

			$id=$this->cashadvance_model->add_dateextend();
			$advancedata=$this->cashadvance_model->get_cashadvancedata($adv_id);
		$aprofficer=$advancedata->apprved_officerid;



		$pay_type=get_booktype_by_advanceid($adv_id);
		if($pay_type=='CHQ')
		{
			$this->common_model->add_notification_officer('ac_cashadvance','Settelment Date Extend to  Approve','accounts/cashadvance/advancelist/book',$adv_id,$aprofficer);
		redirect("accounts/cashadvance/advancelist");
		}
		else
		{
			$this->common_model->add_notification_officer('ac_cashadvance','Settelment Date Extend to  Approve','accounts/cashadvance/iou/book',$adv_id,$aprofficer);
		redirect("accounts/cashadvance/iou");
		}

	}
	public function confirm_dateextend()
	{
		if ( ! check_access('approve_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}


			$id=$this->cashadvance_model->confirm_dateextend($this->uri->segment(4));
				$this->common_model->delete_notification('ac_cashadvance',$this->uri->segment(4));

				$pay_type=get_booktype_by_advanceid($this->uri->segment(4));
		if($pay_type=='CHQ')
		{

		redirect("accounts/cashadvance/advancelist");
		}
		else
		{

		redirect("accounts/cashadvance/iou");
		}



	}
	function iou_settlement_report($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,$book_id,$branch)
	{
		$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['tasklist']=$this->cashadvance_model->all_tasklist();
		$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['booklist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['todate']=$todate=$todate;
		$data['fromdate']=$fromdate=$fromdate;
		$data['branchlist']=$this->branch_model->get_all_branches_summery();
		// $settlemet = array();
		// $payments = array();
		//$data['unsettled_data']=$unsettled_data;
		$data['settledata']=$settledata=$this->cashadvance_model->iou_settlementdata($fromdate,$todate,$officer_id,$amount,$prj_id,$task_id,$book_id,$branch);
		if($settledata)
		{
			foreach($settledata as $raw)
			{
				$settlemet[$raw->adv_id]=$this->cashadvance_model->get_settlement_details_iou($raw->adv_id,$prj_id,$task_id);
				$pyments[$raw->adv_id]=$this->cashadvance_model->get_payment_details_IOU($raw->adv_id,$prj_id,$task_id);
			}

			$data['settlemet']=$settlemet;
			$data['pyments']=$pyments;
		}

	//print_r($ledger_data);
		$this->load->view('accounts/cashadvance/iou_settlement_report',$data);

	}

	public function check_balance()
	{//ticket 3234
		$id=$this->input->get('id');
		$bookid=$this->input->get('bookid');
		$advancedata=$this->cashadvance_model->get_cashadvancedata($id);
		$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$ledgerbalance=get_cashbook_balance($bookid);;
		if($advancedata->amount<$ledgerbalance){
			echo json_encode('false');
		}else{
			echo json_encode('true');
		}

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
