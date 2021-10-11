<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rates extends CI_Controller {

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

		$this->load->model("rates_model");
		$this->load->model("common_model");
		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('config/rates/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->rates_model->get_rates();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->rate_id.'">'.$c->name .'-'.$c->rate.'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/rates/search';
				$data['tag']='Search Product Tasks ';


		$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('config/rates/rates_data',$data);



	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['details']=$this->rates_model->get_rates_bycode($this->uri->segment(4));
		$this->load->view('config/rates/search',$data);

	}


	public function add()
	{
		if ( ! check_access('add_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$id=$this->rates_model->add();


		$this->session->set_flashdata('msg', 'Task Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("config/rates/showall");

	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$data['details']=$this->rates_model->get_rates_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('cm_rates',$this->uri->segment(4),'rate_id');
		$session = array('activtable'=>'cm_rates');
		$this->session->set_userdata($session);
		$this->load->view('config/rates/edit',$data);

	}
	function editdata()
	{
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');

			return;
		}
		$id=$this->rates_model->edit();
		//echo $this->input->post('rate_id');

		$this->session->set_flashdata('msg', 'Finance Rate Successfully Updated ');

		$this->common_model->delete_activflag('cm_rates',$this->input->post('rate_id'),'rate_id');
		$this->logger->write_message("success", $this->input->post('rate_id').' Finance Rate successfully Updated');
		redirect("config/rates/showall");

	}


	public function loan_rates()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->rates_model->get_loan_rates();
		$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->id.'">'.$c->type .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/rates/search_loan';
				$data['tag']='Search Product Tasks ';


		$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('config/rates/loan_rates_data',$data);



	}
	public function edit_loan_rates()
	{
			$data=NULL;
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/loan_rates');
			return;
		}
		$data['details']=$this->rates_model->get_loan_rates_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('re_saletype',$this->uri->segment(4),'id');
		$session = array('activtable'=>'re_saletype');
		$this->session->set_userdata($session);
		$this->load->view('config/rates/edit_loan_rates',$data);

	}
		public function edit_config()
	{
			$data=NULL;
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/loan_rates');
			return;
		}

			$this->config->set_item('task_refil_limit',$this->input->post('limit'));
				$this->session->set_flashdata('msg', 'Fund transfer limit Updated ');

		$this->logger->write_message("success",' Fund transfer limit Updated');
		redirect("config/rates/showall");


	}

	function editdata_loan_rates()
	{
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/loan_rates');

			return;
		}
		$id=$this->rates_model->edit_loan_rates();
		//echo $this->input->post('rate_id');

		$this->session->set_flashdata('msg', 'Finance Rate Successfully Updated ');

		$this->common_model->delete_activflag('re_saletype',$this->input->post('id'),'id');
		$this->logger->write_message("success", $this->input->post('id').' Finance Rate successfully Updated');
		redirect("config/rates/loan_rates");

	}

	public function confirm()
	{
		if ( ! check_access('confirm_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$id=$this->rates_model->confirm($this->uri->segment(4));


		$this->session->set_flashdata('msg', 'Task Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Task id successfully Confirmed');
		redirect("config/rates/showall");

	}
		public function delete()
	{
		if ( ! check_access('delete_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$id=$this->rates_model->delete($this->uri->segment(4));


		$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("config/rates/showall");

	}
	public function re_ledgers()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->rates_model->get_loan_rates();
		$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->id.'">'.$c->type .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/rates/search_loan';
				$data['tag']='Search Product Tasks ';


		$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('config/rates/re_ledgers',$data);



	}

	public function hm_ledgers()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->rates_model->get_loan_rates();
		$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->id.'">'.$c->type .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/rates/search_loan';
				$data['tag']='Search Product Tasks ';


		$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('config/rates/hm_ledgers',$data);



	}

	function update_reledger()
	{
		if ( ! check_access('update_ledgers'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$val=$this->rates_model->update_reledgers('re');
		if($val)
		{
			$this->session->set_flashdata('msg', 'Ledgers Successfully Updated ');
				$this->logger->write_message("success", 'Ledgers Successfully Updated ');
		}
		else
		$this->session->set_flashdata('error', 'Error Updating Realestate ledgers ');
		redirect("config/rates/re_ledgers");
	}

	function update_hmledger()
	{
		if ( ! check_access('update_ledgers'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$val=$this->rates_model->update_reledgers('hm');
		if($val)
		{
			$this->session->set_flashdata('msg', 'Ledgers Successfully Updated ');
				$this->logger->write_message("success", 'Ledgers Successfully Updated ');
		}
		else
		$this->session->set_flashdata('error', 'Error Updating Housing ledgers ');
		redirect("config/rates/hm_ledgers");
	}

	function add_grace_period()
	{
		$statues=$this->input->get('statues');
		$type=$this->input->get('type');
		$this->rates_model->add_grace_period($type,$statues);
		echo $type;
	}
	function update_confimation_level()
	{
		
		$id=$this->input->get('id');
		$value=$this->input->get('value');
		//echo $value;
		$data = $this->rates_model->edit_rate_special($id,$value);
		
		if($data)
		{
			echo "updated";
		}
	}
public function print_configuration()
	{
		$data=NULL;
		if ( ! check_access('update_printconfig'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['recipetdata']=$inventory=$this->rates_model->get_recipet_configuration();
		$data['voucherdata']=$inventory=$this->rates_model->get_voucher_configuration();
		$courseSelectList="";
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/rates/search_loan';
				$data['tag']='Search Product Tasks ';


		$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('config/rates/printerconfig',$data);



	}
	function update_printconfig()
	{
		if ( ! check_access('update_printconfig'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$val=$this->rates_model->update_printconfig();
		
			$this->session->set_flashdata('msg', 'Details Successfully Updated ');
				$this->logger->write_message("success", 'Ledgers Successfully Updated ');
		
		redirect("config/rates/print_configuration");
	}

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
