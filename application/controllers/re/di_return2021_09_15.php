<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class di_return extends CI_Controller {

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

		$this->load->model("reservation_model");
		$this->load->model("common_model");
		$this->load->model("project_model");
		$this->load->model("salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
		$this->load->model("dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("di_return_model");
		$this->load->model("eploan_model");

		$this->is_logged_in();

    }



	
	function index()
	{
	
			
				$data['reslist']=$data['searchdata']=$inventory=$this->di_return_model->get_all_reservation_summery($this->session->userdata('branchid'));

			
				$courseSelectList="";
				 $count=0;
				$data['searchlist']='';
				$pagination_counter =RAW_COUNT;
				$tab='';
				$page_count = 0;
				$tab='';
				if($this->uri->segment(4))
				{
					$tab='list';
						if($this->uri->segment(4)=='list')
						$tab='list';
						else
						$page_count = (int)$this->uri->segment(4);
				}
				
				$data['tab']=$tab;
				$data['datalist']=$this->di_return_model->get_di_return_list($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservation/showall';
				$tablename='re_direturn';
				$statusfield='res_status';
				$status = array('PROCESSING', 'PENDING');
				$this->pagination($page_count,$siteurl,$tablename);


			$this->load->view('re/di_return/di_return_main',$data);
}

function get_di_payment_data()
{
	$data['paydate']=$paydate=$this->uri->segment(5);
	$res_code=$this->uri->segment(4);
	$data['current_rescode']=$res_code;
	$data['current_res']=$current_res=$this->di_return_model->get_all_reservation_details_bycode($res_code);
	$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
	$data['adance_paylist']=$this->di_return_model->get_adance_payment_data($res_code);
	//print_r($data['adance_paylist']);
	$data['return_tot']=$this->di_return_model->get_di_return_total($res_code);
	$data['loan_paylist']=NULL;
	$data['loan_data']=$loandata=$this->di_return_model->get_eploan_data($res_code);
	if($loandata)
	$data['loan_paylist']=$this->di_return_model->get_loan_payment($loandata->loan_code);
	
	$this->load->view('re/di_return/di_return_data',$data);
	

}
function apply_return()
{
	
	if ( ! check_access('add_di_return'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/di_return/');
			return;
		}
	
		$res_code=$this->input->post('res_code');
		$amount=$this->input->post('return_amount');
		$paydate=$this->input->post('paydate');
		$tot_di=$this->input->post('tot_di');
		$remark=$this->input->post('remark');
			$id=$this->di_return_model->add_di_return($amount,$paydate,$res_code,$tot_di,$remark);
	
		$this->common_model->add_notification('re_direturn',' Loan DI Return Request','re/di_return/index/list',$id);
		$this->session->set_flashdata('msg', ' Di Return Successfully Added');
redirect('re/di_return/');
	
	/*$data['current_res']=$current_res=$this->di_return_model->get_all_reservation_details_bycode($res_code);
	$data['loan_data']=$loandata=$this->di_return_model->get_eploan_data($res_code);
	if($loandata)
	{
		
	}
	else
	{
		
		
	}*/
	
}


function delete_pending_return()
{
	$entry=$this->di_return_model->delete_pending_return($this->uri->segment(4));
	
	
	if($entry)
	{
		$this->session->set_flashdata('msg', 'Di Return successfully Deleted');
		$this->common_model->delete_notification('re_direturn',$this->uri->segment(4));


	}
	else
		{
			$this->session->set_flashdata('error', 'Error deleting Di Return ');
		}
		
		redirect('re/di_return/');

}
function delete_confirm_return()
{
	
	if ( ! check_access('delete_di_return'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/di_return/');
			return;
		}
	$entry=$this->di_return_model->delete_confirm_return($this->uri->segment(4));
	
	
	if($entry)
	{
		$this->session->set_flashdata('msg', 'Di Return successfully Deleted');
		$this->common_model->delete_notification('re_direturn',$this->uri->segment(4));


	}
	else
		{
			$this->session->set_flashdata('error', 'Error deleting Di Return ');
		}
		
		redirect('re/di_return/');

}

public function confirm_di_return()
{
	if ( ! check_access('confirm_di_return'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('re/di_return/');
		return;
	}

	$id=$this->di_return_model->confirm_di_return($this->uri->segment(4));

	$this->common_model->delete_notification('re_direturn',$this->uri->segment(4));
	$this->session->set_flashdata('msg', 'DI return Successfully Applied to the reservation');
	redirect('re/di_return/');

}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
