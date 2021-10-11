<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stampfee extends CI_Controller {

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
		
		$this->load->model("customer_model");
		$this->load->model("common_model");
		$this->load->model("hm_message_model");
		$this->load->model("hm_deedtransfer_model");
			$this->load->model("hm_stampfee_model");
		$this->load->model("hm_reservation_model");
		$this->load->model("hm_lotdata_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/stampfee/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_stampfee'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
			$data['prjlist']=$this->hm_stampfee_model->get_all_project_confirmed($this->session->userdata('branchid'));
				$data['deedlist']=$this->hm_stampfee_model->get_stampfee_request_list();
				$data['paidlist']=$this->hm_stampfee_model->get_stampfee_paidlist_list();
				
		//	$data['deedlist']=$this->hm_deedtransfer_model->get_deedtranfers_by_type();
				$courseSelectList="";
					$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customerletter/search';
				$data['tag']='Search Customer letter';
			
				$this->load->view('hm/stampfee/stampfee_main',$data);
		
		
		
	}
	function get_blocklist($id)
{
	
		
	$data['lotlist']=$this->hm_stampfee_model->get_stampfeeoaidlist_list($id);
	$this->load->view('hm/stampfee/blocklist',$data);
}

	public function get_fulldata()
	{
			$data=NULL;
		if ( ! check_access('view_stampfee'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['current_res']=NULL;
		$data['cus_data']=NULL;
		$data['paydata']=NULL;
		$data['res_code']=$this->uri->segment(4);
		$data['prj_id']=$this->uri->segment(5);
			$data['current_rescode']=$current_rescode=$this->uri->segment(4);
		$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($current_rescode);
		$data['chargedata']=$this->hm_reservation_model->get_charge_data($current_rescode);
		
		if($current_rescode)
		{
			$data['requestdata']=$this->hm_stampfee_model->get_stampfee_request($current_rescode);
		$data['current_res']=$current_res=$this->hm_reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['cus_data']=$this->customer_model->get_customer_bycode($current_res->cus_code);
			if($current_res->pay_type=='ZEP' || $current_res->pay_type=='EPB' || $current_res->pay_type=='NEP')
			{
				$data['loan_data']=$loandata=$this->hm_reservation_model->get_eploan_data($current_rescode);
				if($loandata)
				$data['paydata']=$loandata=$this->hm_deedtransfer_model->loan_paid_amounts($loandata->loan_code,date('Y-m-d'),$loandata->reschdue_sqn);
				
			}
		
		}
		$this->load->view('hm/stampfee/payment_data',$data);
		
	}
		
	public function add_request()
	{
		if ( ! check_access('add_stampfee_request'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}		
		$id=$this->hm_stampfee_model->add();
		
		$this->common_model->add_notification('hm_charge_stampfee','Stamp Fee Payment Request','hm/stampfee',$id);
		$this->session->set_flashdata('msg', 'Stamp Fee Payment Request Successfully Inserted ');
		$this->logger->write_message("success",'Stamp Fee Payment Request successfully Inserted');
		redirect("hm/stampfee/showall");
		
	}
	public function approved_request()
	{
		if ( ! check_access('confirm_stampfee_request'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}		
		$id=$this->hm_stampfee_model->approved_request();
		
		$this->common_model->delete_notification('hm_charge_stampfee','Stamp Fee Payment Request','hm/stampfee',$id);
		$this->session->set_flashdata('msg', 'Stamp Fee Payment Request Successfully Inserted ');
		$this->logger->write_message("success",'Stamp Fee Payment Request successfully Inserted');
		redirect("hm/stampfee/showall");
		
	}
	
	
	public function delete()
	{
		
		$id=$this->hm_stampfee_model->delete_request($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_charge_stampfee',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Stamp Fee Payment Request Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Stamp Fee Payment Request Successfully Deleted');
		redirect("hm/stampfee/showall");
		
		
	}
	public function report()
	{
		$data=NULL;
		if ( ! check_access('view_deedtrn_report'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
			$data['prjlist']=$this->hm_stampfee_model->get_all_project_confirmed($this->session->userdata('branchid'));
				$data['deedlist']=$this->hm_stampfee_model->get_stampfee_request_list();
				$data['paidlist']=$this->hm_stampfee_model->get_stampfee_paidlist_list();
				
		//	$data['deedlist']=$this->hm_deedtransfer_model->get_deedtranfers_by_type();
				$courseSelectList="";
					$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customerletter/search';
				$data['tag']='Search Customer letter';
			
				$this->load->view('hm/stampfee/stampfee_report',$data);
		
		
		
	}
	function report_fulldata()
	{
		$data['current_res']=NULL;
		$data['cus_data']=NULL;
		$data['paydata']=NULL;
		
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		
		$data['blocklist']=$blocklist=$this->hm_stampfee_model->get_all_blocklist($prj_id);
		//$data['chargedata']=$this->hm_reservation_model->get_charge_data($current_rescode);
		
		
		$this->load->view('hm/stampfee/report_data',$data);
	}
	function report_fulldata_excel()
	{
		$data['current_res']=NULL;
		$data['cus_data']=NULL;
		$data['paydata']=NULL;
		
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		
		$data['blocklist']=$blocklist=$this->hm_stampfee_model->get_all_blocklist($prj_id);
		//$data['chargedata']=$this->hm_reservation_model->get_charge_data($current_rescode);
		
		
		$this->load->view('hm/stampfee/report_data_excel',$data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */