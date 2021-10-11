<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {

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
		 $this->load->library('Spreadsheet_Excel_Reader');
   
		$this->load->model("hm_reservation_model");
		$this->load->model("hm_common_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("hm_lotdata_model");
		$this->load->model("hm_dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("hm_eploan_model");
		$this->load->model("hm_accountinterface_model");
		$this->load->model("hm_deedtransfer_model");
		$this->load->model("common_model");
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/reservation/newreservation');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('add_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		
		$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->hm_reservation_model->get_all__not_complete_reservation_summery($this->session->userdata('branchid'));
		
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/showall';
				$tablename='hm_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);
					
				$this->load->view('hm/reservation/reservation_list',$data);
		
		
	}
	function payments()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		
		$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->hm_reservation_model->get_all__not_complete_reservation_summery($this->session->userdata('branchid'));
		
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/showall';
				$tablename='hm_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);
					
				$this->load->view('hm/reservation/payments',$data);
		
	}
	public function newreservation()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/');
			return;
		}
		
			//	$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/reservation/search';
				$data['tag']='Search reservation';
				if($this->uri->segment(4))
				$data['cus_code']=$this->uri->segment(4);
				else $data['cus_code']="";
				 if($this->session->userdata('usertype')=='Sales_officer')
				 {
					 $data['prjlist']=$this->hm_salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					//$data['prjlist']=$this->hm_salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
					$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();
				
				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				 	$data['searchlist']='';
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
				$data['tab']='';
					if ( !$page_count)
					$page_count = 0;
					if($page_count)
						$data['tab']='list';
					

				$data['datalist']=$this->hm_reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/newreservation';
				$tablename='hm_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);
			
				$this->load->view('hm/reservation/reservation_data',$data);
		
		
		
	}
	function get_blocklist()
	{
		$data['lotlist']=$this->hm_lotdata_model->get_project_pending_lots_byprjid($this->uri->segment(4));
		$this->load->view('hm/reservation/blocklist',$data);
		
	}
	function get_fulldata()
	{
		$data['lotdetail']=$this->hm_lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['projectdata']=$this->hm_reservation_model->get_project_bycode($this->uri->segment(5));
		$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($this->uri->segment(5));
		$data['saletype']=$this->hm_reservation_model->get_purchase_type();
		$data['mindp']=30;//$this->hm_reservation_model->get_mindp_level();
		 $data['dplevel']=$this->hm_dplevels_model->get_dplevels();
		 $data['banklist']=$this->hm_common_model->getbanklist();
		
		$this->load->view('hm/reservation/full_details',$data);
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/');
			return;
		}
		$data['bankdata']=$this->hm_reservation_model->get_reservation_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->hm_common_model->getbanklist();
		$data['details']=$this->hm_reservation_model->get_resevationdata($this->uri->segment(4));
		$this->load->view('hm/reservation/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}		
		$id=$this->hm_reservation_model->add();
		
		$this->hm_common_model->add_notification('hm_resevation','reservations','hm/reservation',$id);
		$this->session->set_flashdata('msg', 'Land reservation Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("hm/reservation/add_data/".$id);
		
	}
	public function add_data()
	{
		$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/');
			return;
		}
		$res_code=$this->uri->segment(4);
		
			//	$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/reservation/search';
				$data['tag']='Search reservation';
				
				
				
				 if($this->session->userdata('usertype')=='Sales_officer')
				 {
					 $data['prjlist']=$this->hm_salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					$data['prjlist']=$this->hm_salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();
				
				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				 $data['resdata']=$resdata=$this->hm_reservation_model->get_resevationdata($res_code);
				 $data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				 $data['loandata']=$this->hm_reservation_model->get_eploan_data($res_code);
				 $data['lotdetail']=$this->hm_lotdata_model->get_project_lotdata_id($resdata->lot_id);
				$data['projectdata']=$this->hm_reservation_model->get_project_bycode($resdata->prj_id);
				$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
				$data['lotlist']=$this->hm_lotdata_model->get_project_pending_onhold_lots_byprjid($resdata->prj_id);
				$data['saletype']=$this->hm_reservation_model->get_purchase_type();
				$data['mindp']=$this->hm_reservation_model->get_mindp_level();
				$data['dplevel']=$this->hm_dplevels_model->get_dplevels();
		 		$data['banklist']=$this->hm_common_model->getbanklist();
				$this->load->view('hm/reservation/reservation_addata',$data);
		
		
		
	}
	function get_settlments()
	{
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->hm_reservation_model->get_purchase_type();
				$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
			
				$this->load->view('hm/reservation/settlement_data',$data);
	}
	
	function add_settlement()
	{
		if ( ! check_access('add_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_reservation_model->add_settilemt();
		
		$paytype=trim($this->input->post('pay_type'));
		if($paytype=='Outright')
			$this->hm_common_model->add_notification('hm_settlement','Outright Land sale','hm/reservation/sold',$this->input->post('res_code_set'));
		else
			$this->hm_common_model->add_notification('hm_eploan','New EP Loan','hm/reservation/eploans',$this->input->post('res_code_set'));
		$this->session->set_flashdata('msg', 'Reservation Completed ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Reservation Completed');
		if($paytype=='Outright')
		redirect("hm/reservation/sold/");
		else
		redirect("hm/reservation/eploans/");
	}
	
	function get_advancedata()
	{			$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				$this->load->view('hm/reservation/advance_data',$data);
	}
	
	function add_advance()
	{
		if ( ! check_access('add_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_reservation_model->add_advance();
		
		
		$this->session->set_flashdata('msg', 'Advance payment successfully Inserted ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		redirect("hm/reservation/payments/");
	}
	function delete_advance()
	{
		if ( ! check_access('delete_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		$id=$this->hm_reservation_model->delete_advance($this->uri->segment(4));
				$this->session->set_flashdata('msg', 'advance payment Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance payment  successfully Deleted');
		redirect("hm/reservation/payments");
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		$data['details']=$this->hm_reservation_model->get_reservation_bycode($this->uri->segment(4));
		$data['bankdata']=$this->hm_reservation_model->get_resevationdata($this->uri->segment(4));
		$data['banklist']=$this->hm_common_model->getbanklist();
		$this->hm_common_model->add_activeflag('hm_resevation',$this->uri->segment(4),'res_code');
		$session = array('activtable'=>'hm_reservationms');
		$this->session->set_userdata($session);
		$this->load->view('hm/reservation/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_reservation_model->edit();
		
		
		$this->session->set_flashdata('msg', 'reservation Details Successfully Updated ');
		
		//$this->hm_common_model->delete_activflag('hm_reservationms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('res_code').' reservation Details successfully Updated');
		redirect("hm/reservation/add_data/".$id);
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		$data['details']=$res_data=$this->hm_reservation_model->get_resevationdata($this->uri->segment(4));
		$lotdetail=$this->hm_lotdata_model->get_project_lotdata_id($res_data->lot_id);
		if(floatval($lotdetail->sale_val) > floatval($res_data->discounted_price))
		{
			if ( ! check_access('confirm_discountedreservation'))
			{
				$this->session->set_flashdata('error', 'Please Contact Head of Customer care to Confirm this reservation');
				redirect("hm/reservation/newreservation");
				return;
				
			}
			else
			{
				$id=$this->hm_reservation_model->confirm($this->uri->segment(4));
				$this->hm_common_model->delete_notification('hm_resevation',$this->uri->segment(4));
				$this->session->set_flashdata('msg', $this->uri->segment(4).'reservation Successfully Confirmed ');
				$this->logger->write_message("success", $this->uri->segment(4).'  reservation id successfully Confirmed');
				redirect("hm/reservation/newreservation");
			}
			
		}
		else{
		$id=$this->hm_reservation_model->confirm($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_resevation',$this->uri->segment(4));
		$this->session->set_flashdata('msg', $this->uri->segment(4).'reservation Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  reservation id successfully Confirmed');
		redirect("hm/reservation/newreservation");
		}
		
		
	}
	public function delete()
	{
		if ( ! check_access('delete_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		$id=$this->hm_reservation_model->delete_reservation_new($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_reservation',$this->uri->segment(4));
		$this->session->set_flashdata('msg', $this->uri->segment(4). ' reservation Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' reservation id successfully Deleted');
		redirect("hm/reservation/newreservation");
		
	}
	public function sold()
	{
		$data=NULL;
		if ( ! check_access('view_outright_list'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_settlments_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_reservation_model->get_all_reservation_settlments($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/sold';
				$tablename='hm_settlement';
				$statusfield='res_status';
				$status='COMPLETE';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/reservation/complete_list',$data);
		
		
		
	}
	public function eploans()
	{
		$data=NULL;
		if ( ! check_access('view_pending_loanlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_reservation_model->get_all_reservation_eploan_pending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/eploans';
				$tablename='hm_eploan';
				$this->pagination_status($page_count,$siteurl,$tablename,'loan_status','PENDING');
	
				$this->load->view('hm/reservation/loan_list',$data);
		
		
		
	}
		


function edit_complete()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->hm_reservation_model->get_purchase_type();
				 $data['loandata']=$this->hm_reservation_model->get_eploan_data($res_code);
				  $data['settledata']=$this->hm_reservation_model->get_settlemnt_data($res_code);
				  $data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
		$this->hm_common_model->add_activeflag('hm_resevation',$this->uri->segment(4),'res_code');
		$session = array('activtable'=>'hm_resevation');
		$this->session->set_userdata($session);
		$this->load->view('hm/reservation/edit_complete',$data);
		
	}
	function editdata_compete()
	{
		if ( ! check_access('edit_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_reservation_model->edit_settlment();
		$data=$this->hm_reservation_model->get_all_reservation_details_bycode($this->input->post('res_code_set'));
		
		$this->session->set_flashdata('msg', 'reservation Details Successfully Updated ');
		$this->hm_common_model->delete_activflag('hm_resevation',$this->input->post('res_code_set'),'res_code');
		//$this->hm_common_model->delete_activflag('hm_reservationms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('res_code_set').' reservation Details successfully Updated');
		if($data->pay_type=='Outright')
		redirect("hm/reservation/sold/");
		else
		redirect("hm/reservation/eploans/");
		
	}
	
	public function confirm_settlement()
	{
		if ( ! check_access('confirm_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		
		$id=$this->hm_reservation_model->confirm_settlment($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_settlement',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Land successfully Soldout ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Land successfully Sold out');
		redirect("hm/reservation/sold");
		
	}
	public function delete_settlement()
	{
		if ( ! check_access('delete_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		
		$id=$this->hm_reservation_model->delete_settlment($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_settlement',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Settlement Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Settlement Successfully Deleted');
		redirect("hm/reservation/sold");
		
	}
	public function delete_loan()
	{
		if ( ! check_access('delete_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		
		$id=$this->hm_reservation_model->delete_loan_rescode($this->uri->segment(4));
		
		$this->session->set_flashdata('msg', 'Settlement Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Settlement Successfully Deleted');
		redirect("hm/reservation/eploans");
		
	}
	// 
		public function confirm_loan()
	{
		if ( ! check_access('confirm_epagreement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		
		
		
				
		$loandata=$this->hm_reservation_model->get_eploan_data($this->uri->segment(4));
		$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($this->uri->segment(4));
		$lot_data=$this->hm_accountinterface_model->get_lotdata($resdata->lot_id);
		//Realized Sale value Transfers
		$realized_sale=$resdata->down_payment;
		$realized_cost=($resdata->down_payment/$resdata->discounted_price)*$lot_data->costof_sale;
		$unrealised_sale=$resdata->discounted_price-$resdata->down_payment;
		$unrealized_cost=round($lot_data->costof_sale-$realized_cost,2);
		//Transfer Realized Sale
		$ledgerset=$this->hm_accountinterface_model->get_account_set('Transfer Sale');
		$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
			$crlist[0]['amount']=$crtot=$realized_sale;
			$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
			$drlist[0]['amount']=$drtot=$realized_sale;
			$narration = $resdata->res_code.' Transfer Sale';
			$entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id);
		//Transfer Cost	
		$ledgerset=$this->hm_accountinterface_model->get_account_set('Transfer Cost');
		$uncost=$this->hm_accountinterface_model->get_account_set('Unrealized Cost');
		$unsale=$this->hm_accountinterface_model->get_account_set('Unrealized Sale');
					$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
					$crlist[0]['amount']=$crtot=$lot_data->costof_sale;
					$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
					$drlist[0]['amount']=$drtot=$realized_cost;
					$drlist[1]['ledgerid']=$uncost['Dr_account'];
					$drlist[1]['amount']=$drtot=$unrealized_cost;
					$drtot=$lot_data->costof_sale;
					$narration = $resdata->res_code.' Cost  Trasnfer  '  ;
					$int_entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id);
			
			if($resdata->pay_type=='ZEP'){
				$ledgerset=$this->hm_accountinterface_model->get_account_set('EP creation');
				$draccount=$ledgerset['Dr_account'];
			}
			if($resdata->pay_type=='EPB'){
				$ledgerset=$this->hm_accountinterface_model->get_account_set('EP creation');
				$draccount=$ledgerset['Dr_account'];
			}
			if($resdata->pay_type=='NEP'){
				$ledgerset=$this->hm_accountinterface_model->get_account_set('EP creation');
				$draccount=$ledgerset['Dr_account'];
			}
		//transfer Unrealized Sale
		$drlist=NULL;
		$crlist=NULL;
					$crlist[0]['ledgerid']=$unsale['Cr_account'];
					$crlist[0]['amount']=$crtot=$unrealised_sale;
					$drlist[0]['ledgerid']=$draccount;
					$drlist[0]['amount']=$drtot=$unrealised_sale;
					$narration = $resdata->res_code.' Unrialized Sale  Trasnfer  '  ;
					$int_entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id);
		
		//NEP Interest Transfer
		if($resdata->pay_type=='NEP'){
			$ledgerset=$this->hm_accountinterface_model->get_account_set('EP Creation Interest');
			$totint=$this->hm_eploan_model->get_int_total($loandata->loan_code);
			$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
			$crlist[0]['amount']=$crtot=$totint;
			$drlist[0]['ledgerid']=$ledgerset['Dr_account'];
			$drlist[0]['amount']=$drtot=$totint;
			$narration = $loandata->loan_code.' EP Loan Interest transfer';
		   $entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,date("Y-m-d"),$narration,$resdata->prj_id,$resdata->lot_id);
			
		}
		$method=$resdata->pay_type.' Agreement Creation';
		hm_insert_unrealizedsale($resdata->prj_id,$resdata->res_code,$resdata->discounted_price,$lot_data->costof_sale,$unrealised_sale,$unrealized_cost,date("Y-m-d"),$method);
		hm_insert_unrdata($resdata->res_code,'','',date("Y-m-d"),$realized_sale,$realized_cost,$method);
				$insert_data=array('status'=>'SOLD');
					$this->db->where('lot_id',$resdata->lot_id);
						if ( ! $this->db->update('hm_prjaclotdata', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
							 $insert_data=array('profit_status'=>'TRANSFERD','profit_date'=>date('Y-m-d'));
						$this->db->where('res_code',$resdata->res_code);
						if ( ! $this->db->update('hm_resevation', $insert_data))
							{
							 	 $this->db->trans_rollback();
								 $this->messages->add('Error addding Entry.', 'error');
		  		
						 return;
							 } 
		
		
		if($entry)
		{
		$id=$this->hm_reservation_model->confirm_loan($this->uri->segment(4));
		$msg=' Your Loan  successfully Approved and your loan number is'.$loandata->loan_code;
		if($resdata->pay_type=='NEP')
		{
		hm_create_letter($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$loandata->loan_code,'','02',$msg,$loandata->loan_amount);
		}
		else
		{
		//create_letter($resdata->branch_code,$resdata->cus_code,$resdata->res_code,$loandata->loan_code,'','03',$msg,$loandata->loan_amount);
		}
		$this->common_model->delete_notification('hm_eploan',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Loan successfully Confirmed');
		}
		else
		{
			$this->session->set_flashdata('error', 'Error updating Confirmation Entry ');
		}
		redirect("hm/reservation/eploans");
		
	}
 
function repayment_schedule()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$this->load->view('hm/reservation/loan_schedule',$data);
}
function resale()
{
	if ( ! check_access('view_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
			
					$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_summery_resale($this->session->userdata('branchid'));
		
			
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				 foreach($inventory as $c)
      			 {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchlist']=$courseSelectList;
				$data['tab']='list';
				
					if($page_count)
						$data['tab']='list';
				$siteurl='hm/reservation/resale';
				$tablename='hm_adresale';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->hm_reservation_model->get_resale($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$this->load->view('hm/reservation/resale_main',$data);
}
function add_resale()
	{
		if ( ! check_access('add_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_reservation_model->add_resale();
		
		$this->hm_common_model->add_notification('hm_adresale',' Advance Repossess Request','hm/reservation/resale',$id);
		
		$this->session->set_flashdata('msg', ' Advance Reprocess Request Sent ');
		$this->logger->write_message("success", $this->input->post('res_code').' Advance Repossess Request Sent');
		
		redirect("hm/reservation/resale/");
	}
	function delete_resale()
	{
		if ( ! check_access('delete_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/resale');
			return;
		}
		$id=$this->hm_reservation_model->delete_resale($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_adresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Advance Reprocess Request Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance Repossess Request successfully Deleted');
		redirect("hm/reservation/resale");
	}
	function edit_resale()
	{
	$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
		$data['relsaledata']=$this->hm_reservation_model->get_resale_bycode($this->uri->segment(5));
		$this->hm_common_model->add_activeflag('hm_epresale',$this->uri->segment(5),'resale_code');
			
	$this->load->view('hm/reservation/resale_editdata',$data);
	}
	function editdata_resale()
	{
		if ( ! check_access('edit_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedule');
			
			return;
		}
		$id=$this->hm_reservation_model->edit_resale();
		
		
		$this->session->set_flashdata('msg', 'Reprocess Details  Successfully Updated ');
		
		$this->hm_common_model->delete_activflag('hm_adresale',$this->input->post('resale_code'),'resale_code');
		$this->logger->write_message("success", $this->input->post('resale_code').' Reprocess Details  Updated');
		redirect("hm/reservation/resale");
		
	}
	function confirm_resale()
	{
		if ( ! check_access('confirm_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/resale');
			return;
		}
		$id=$this->hm_reservation_model->confirm_resale($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_adresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Advance Repossess Request Confirmed');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance Reprocess Request successfully Confirmed');
		redirect("hm/reservation/resale");
	}
function get_resaledata()
{
				$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['deed_data']=$this->hm_deedtransfer_model->get_deedtranfers_data_res_code($res_code);
		
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				//$this->load->view('hm/reservation/advance_data',$data);
			
	$this->load->view('hm/reservation/resale_data',$data);
}
//reservation chargets
function chargers()
	{
		$data=NULL;
		if ( ! check_access('view_charges'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		
		$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->hm_reservation_model->get_all_reservation_summery_withoutreprocess($this->session->userdata('branchid'));
		
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/showall';
				$tablename='hm_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);
					
				$this->load->view('hm/reservation/chargers',$data);
		
	}
function get_chargelist()
	{			$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['charge_data']=$this->hm_reservation_model->get_charge_data($res_code);
				$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($res_code);
				
				$this->load->view('hm/reservation/charge_data',$data);
	}
	function add_charges()
	{
		if ( ! check_access('add_charges'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/payments');
			
			return;
		}
	
		$id=$this->hm_reservation_model->add_charges();
		$this->session->set_flashdata('msg', 'Reservation Charges successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		redirect("hm/reservation/chargers/");
	}
	function get_chargerfulldata($id)
	{			$res_code=$id;
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['charge_data']=$this->hm_reservation_model->get_charge_data($res_code);
				$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($res_code);
				
				$this->load->view('hm/reservation/charge_fulldata',$data);
	}
	
	// Odiliya New Modification Added By Udani
	function get_settlments_shedu()
	{
		$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->hm_reservation_model->get_advance_data($res_code);
				$data['saletype']=$this->hm_reservation_model->get_purchase_type();
				$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
			
				$this->load->view('hm/reservation/settlement_data_shedu',$data);
	}
		function add_settlement_shedule()
	{
		if ( ! check_access('add_epagreemnet'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
			 $config['allowed_types'] = 'xls|xlsx|csv';
   			 $config['max_size'] = '5000';
				$config['upload_path'] = 'uploads/eploan/';
   

   			 $this->load->library('upload', $config);
  			  $this->upload->do_upload('shedule_file');
  			  $error = $this->upload->display_errors();

  			  $image_data = $this->upload->data();
    //$this->session->set_flashdata('error',  $error );
  			  if($error=="")
			  {
				  $loancode=$this->hm_reservation_model->add_new_shedule_loan();
				 $file_name = $image_data['file_name'];
				 $this->load->library('Spreadsheet_Excel_Reader');
				// Read the spreadsheet via a relative path to the document
				// for example $this->excel_reader->read('./uploads/file.xls');
			 	$excel = new Spreadsheet_Excel_Reader();
				$excel->read("uploads/eploan/".$file_name); // set the excel file name here   
				$counter=0;
					$data['data_excell']=$data_excell=$excel->sheets[0]['cells'];//echo $data['file_name'];
				$counter=0;$details=NULL;
   				 if($data_excell){
					$top_row=($data_excell[1][1]);
					 if(preg_match('/[a-z]/',$top_row)){
   						    array_shift($data_excell);
    				  }$couner=0;
     				  foreach ($data_excell as $key => $value) {
						 if (is_numeric($value[2]) && isset($value[2])) {
       					  		 $date=date("Y-m-d",strtotime(str_replace('/','-',$value[1])));
       					 		 $counter++;
								 $data=array(
								   'loan_code'=> $loancode,
								  'instalment'=>$counter,
								  'cap_amount'=>$value[2],
								   'int_amount'=>$value[3],
								   'tot_instalment'=>$value[4],
									 'deu_date'=>$date,
								);
								 $this->hm_reservation_model->add_new_shedule_loan_repayment($data);
								 print_r($data);
									echo '<br>';
        					}
       					
     				 }
   				 }
			  
			  			$paytype=trim($this->input->post('pay_type'));
						$this->hm_common_model->add_notification('hm_eploan','New EP Loan','hm/reservation/eploans',$this->input->post('res_code_set'));
						$this->session->set_flashdata('msg', 'Reservation Completed ');
		
						$this->logger->write_message("success", $this->input->post('res_code').' Reservation Completed');
						redirect("hm/reservation/eploans/");
			  }
 			   else
 			   {

 			    $this->session->set_flashdata('error',  $error );
				redirect('hm/reservation/showall');
  			  }
	
	}
	public function Update_reciepting_customer()
	{
		
		
		$data['searchdata']=$inventory=$this->hm_reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
		$data['chargedata']=$chargedata=$this->hm_reservation_model->get_all__not_complete_reservation_summery($this->session->userdata('branchid'));
		
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_reservation_model->get_all_reservation_details_withpending($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/reservation/showall';
				$tablename='hm_resevation';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination_status_double($page_count,$siteurl,$tablename,$statusfield,$status);
					
				$this->load->view('hm/reservation/receipt_customer',$data);
		
		
	}
	function get_customer_list($res_code)
	{
		$data['cuslist']=$this->customer_model->get_all_customer_summery();
		$data['rescode']=$this->hm_reservation_model->get_all_reservation_details_bycode($this->uri->segment(4));
		$this->load->view('hm/reservation/get_customer_list',$data);
	}
	function update_customer_data()
	{
		$res_code=$this->input->post('res_code_charge');;
		
		$cuscode=$this->input->post('cus_code2');
		$data['cuslist']=$this->hm_reservation_model->update_receipt_customer($res_code,$cuscode);
		$this->session->set_flashdata('msg', 'Receipting Customer successfully Inserted ');
		redirect("hm/reservation/Update_reciepting_customer/");
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */