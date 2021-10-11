<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deedtransfer extends CI_Controller {

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
		$this->load->model("message_model");
		$this->load->model("deedtransfer_model");
		$this->load->model("reservation_model");
		$this->load->model("lotdata_model");
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
		redirect('re/deedtransfer/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
			$data['prjlist']=$this->deedtransfer_model->get_all_project_confirmed($this->session->userdata('branchid'));
			$data['deedlist']=$this->deedtransfer_model->get_deedtranfers_by_type();
				$courseSelectList="";
					$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customerletter/search';
				$data['tag']='Search Customer letter';
			
				$this->load->view('re/deedtransfer/deed_search',$data);
		
		
		
	}
	function get_blocklist($id)
{
	
		
	$data['lotlist']=$this->deedtransfer_model->get_project_sold_lots($id);
	$this->load->view('re/deedtransfer/blocklist',$data);
}

	public function get_fulldata()
	{
			$data=NULL;
		if ( ! check_access('view_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['current_res']=NULL;
		$data['cus_data']=NULL;
		$data['paydata']=NULL;
		/*Ticket No:2901 Added By Madushan 2021.06.09*/
		$data['loan_data']=NULL;
		$data['lot_id']=$this->uri->segment(4);
		$data['prj_id']=$this->uri->segment(5);
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$lotdata=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['plandata']=$this->deedtransfer_model->get_project_plannumber($this->uri->segment(5),$lotdata->plan_sqid);
		$data['deed_data']=$this->deedtransfer_model->get_deedtranfers_data_byid($this->uri->segment(5),$this->uri->segment(4));
		$data['legal_officer']=$this->deedtransfer_model->get_leagal_officer_list();
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
		/*Ticket No:2901 Added By Madushan 2021.06.09*/
		$data['chargers']=$this->reservation_model->get_charge_data($current_rescode);
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['cus_data']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		$data['status']=$current_res->res_status;
			if($current_res->pay_type=='ZEP' || $current_res->pay_type=='EPB' || $current_res->pay_type=='NEP')
			{
				
				$data['loan_data']=$loandata=$this->reservation_model->get_eploan_data($current_rescode);
				if($loandata)
				{
					$data['status']=$loandata->loan_status;
				$data['paydata']=$loandata=$this->deedtransfer_model->loan_paid_amounts($loandata->loan_code,date('Y-m-d'),$loandata->reschdue_sqn);
				}
			
			}
		
		}
		$this->load->view('re/deedtransfer/deed_data',$data);
		
	}
		public function get_fulldata_popup()
	{
			$data=NULL;
			$data['paydata']=NULL;
		if ( ! check_access('view_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['current_res']=NULL;
		$data['cus_data']=NULL;
		$data['lot_id']=$this->uri->segment(4);
		$data['prj_id']=$this->uri->segment(5);
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$lotdata=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['plandata']=$this->deedtransfer_model->get_project_plannumber($this->uri->segment(5),$lotdata->plan_sqid);
		$data['deed_data']=$this->deedtransfer_model->get_deedtranfers_data_byid($this->uri->segment(5),$this->uri->segment(4));
		$data['legal_officer']=$this->deedtransfer_model->get_leagal_officer_list();
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['cus_data']=$this->customer_model->get_customer_bycode($current_res->cus_code);
			if($current_res->pay_type=='ZEP' || $current_res->pay_type=='EPB' || $current_res->pay_type=='NEP')
			{
				$data['loan_data']=$loandata=$this->reservation_model->get_eploan_data($current_rescode);
				if($loandata)
				$data['paydata']=$loandata=$this->deedtransfer_model->loan_paid_amounts($loandata->loan_code,date('Y-m-d'),$loandata->reschdue_sqn);
			}
		
		}
		$this->load->view('re/deedtransfer/deed_data_popup',$data);
		
	}
	
	function print_lowyercopy()
	{
			$data=NULL;
		$data['paydata']=NULL;
		if ( ! check_access('view_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['lot_id']=$this->uri->segment(4);
		$data['prj_id']=$this->uri->segment(5);
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		
		$data['deed_data']=$this->deedtransfer_model->get_deedtranfers_data_byid($this->uri->segment(5),$this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['cus_data']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		if($current_res->pay_type=='ZEP' || $current_res->pay_type=='EPB' || $current_res->pay_type=='NEP')
			{
				$data['loan_data']=$loandata=$this->reservation_model->get_eploan_data($current_rescode);
				$data['paydata']=$loandata=$this->deedtransfer_model->loan_paid_amounts($loandata->loan_code,date('Y-m-d'),$loandata->reschdue_sqn);
			}
		}
		$this->load->view('re/deedtransfer/print_lawyercopy',$data);
	}
	function print_customer()
	{
			$data=NULL;
		if ( ! check_access('view_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['paydata']=NULL;
		$data['lot_id']=$this->uri->segment(4);
		$data['prj_id']=$this->uri->segment(5);
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		
		$data['deed_data']=$this->deedtransfer_model->get_deedtranfers_data_byid($this->uri->segment(5),$this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['cus_data']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		if($current_res->pay_type=='ZEP' || $current_res->pay_type=='EPB' || $current_res->pay_type=='NEP')
			{
				$data['loan_data']=$loandata=$this->reservation_model->get_eploan_data($current_rescode);
				$data['paydata']=$loandata=$this->deedtransfer_model->loan_paid_amounts($loandata->loan_code,date('Y-m-d'),$loandata->reschdue_sqn);
			}
		}
		$this->load->view('re/deedtransfer/print_customer',$data);
	}
	public function add_transfer()
	{
		if ( ! check_access('add_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}	
		$file_name="";
				$config['upload_path'] = 'uploads/deedtransfer/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
                $config['max_size'] = '5000';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('Affidavit');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
				{
					echo $image_data['file_name']; 
            	$file_name = $image_data['file_name'];
				}
				else
				{
						$this->session->set_flashdata('error', 'Image not Uploaded');
				}
		$id=$this->deedtransfer_model->add($file_name);
		
		$this->common_model->add_notification('re_deedtrn','Deed Transfer','re/deedtransfer',$id);
		$this->session->set_flashdata('msg', 'Deed Transfer Details Successfully Inserted ');
		$this->logger->write_message("success",'Deed Transfer Details successfully Inserted');
		redirect("re/deedtransfer/showall");
		
	}
		public function update_transfer()
	{
		if ( ! check_access('add_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/deedtransfer/showall');
			return;
		}
		$file_name=$this->input->post('old_Affidavit');
				$config['upload_path'] = 'uploads/deedtransfer/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
                $config['max_size'] = '5000';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('Affidavit');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
				{
            	$file_name = $image_data['file_name'];
				}
					
		$id=$this->deedtransfer_model->update_transfer($file_name);
		
		$this->session->set_flashdata('msg', 'Deed Transfer Details Successfully Updated ');
		$this->logger->write_message("success",'Deed Transfer Details successfully Updated');
		redirect("re/deedtransfer/showall");
		
	}
	
	
	public function confirm_transfer()
	{
		if ( ! check_access('confirm_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/deedtransfer/showall');
			return;
		}
		$id=$this->deedtransfer_model->confirm_transfer($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_deedtrn',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Deed Transfer Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Deed Transfer  successfully Confirmed');
		redirect("re/deedtransfer/showall");
		
	}
	public function update_deeddata()
	{
		if ( ! check_access('add_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/deedtransfer/showall');
			return;
		}		
		$id=$this->deedtransfer_model->update_deeddata();
		
		$this->session->set_flashdata('msg', 'Deed  Details Successfully Updated ');
		$this->logger->write_message("success",'Deed  Details successfully Updated');
		redirect("re/deedtransfer/showall");
		
	}
	public function upload_cuscopy()
	{
		if ( ! check_access('add_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/deedtransfer/showall');
			return;
		}	
		$file_name="";
				$config['upload_path'] = 'uploads/deedtransfer/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
                $config['max_size'] = '5000';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('scan_copy');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
				{
            	$file_name = $image_data['file_name'];
				$id=$this->deedtransfer_model->upload_cuscopy($file_name);
				$this->session->set_flashdata('msg', 'Customer Handover  Document successfully Uploaded ');
				$this->logger->write_message("success",'Customer Handover  Document successfully Updated');
				}
				else
				{
				
				$this->session->set_flashdata('error',  $error );
				}	
		
		
		
		redirect("re/deedtransfer/showall");
		
	}
	
	public function confirm_deed()
	{
		if ( ! check_access('confirm_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/deedtransfer/showall');
			return;
		}
		$id=$this->deedtransfer_model->confirm_deed($this->uri->segment(4));
		
		$this->session->set_flashdata('msg', 'Deed  Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Deed   successfully Confirmed');
		redirect("re/deedtransfer/showall");
		
	}
	
		public function delete()
	{
		if ( ! check_access('delete_deedtrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			return;
		}
		$id=$this->customer_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'customer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' customer id successfully Deleted');
		redirect("re/customer/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */