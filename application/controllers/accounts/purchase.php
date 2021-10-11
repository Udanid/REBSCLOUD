<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//2018-10-08
class Purchase extends CI_Controller {

	 function __construct() {
        parent::__construct();

		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("supplier_model");
			$this->load->model("project_model");
		$this->load->model("projectpayment_model");
		$this->load->model("purchase_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;

		redirect('accounts/purchase/showall');



	}

	public function showall()
	{
		//$this->output->delete_cache();
		$data=NULL;

		$data['list']=$list=$this->purchase_model->get_purchase_item();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/purchase/purchase_main';


				$data['tag']='Search Document Types';

		$this->load->view('accounts/purchase/purchase_items',$data);
	}

	public function purchase_orders()
	{
		$data=NULL;

		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/purchase/purchase_main';


				$data['tag']='Search Document Types';

		$this->load->view('accounts/purchase/purchase_main',$data);
	}

	public function add_purchase()
	{


		if($this->input->post('tot_tot_price')<=0){
      $this->db->trans_rollback();
      $this->session->set_flashdata('error','Please Add Value Items.' );
      redirect("accounts/purchase/purchase_orders");
    }else{
			$id=$this->purchase_model->add_purchase();
		}
		$this->session->set_flashdata('msg', 'Purchase Order Successfully Inserted ');
		$this->logger->write_message("success", 'Purchase Order  successfully Inserted');
		redirect("accounts/purchase/purchase_orders");

	}
	public function delete_purchase($id)
	{

		$id=$this->purchase_model->delete_purchase($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Purchase Order  Successfully Deleted ');
		$this->logger->write_message("success", 'Purchase Order  successfully Deleted');
		redirect("accounts/purchase/showall");

	}
	public function edit_view()
	{
		$data['id']=$id=$this->uri->segment(4);
		$data['action']=$action=$this->uri->segment(5);
		$data['purchase_list']=$purchase_list=$this->purchase_model->get_purchase_item_byid($id);
		$data['purchase_item_list']=$purchase_item_list=$this->purchase_model->get_purchase_item_list_byid($id);

		$data['suplist']=$this->supplier_model->get_all_supplier_summery();

		$this->load->view('accounts/purchase/purchase_details',$data);

	}
	public function approve_purchase()
	{
		$id=$this->purchase_model->approve_purchase();

		$this->session->set_flashdata('msg', 'Purchase Order  Successfully Approved ');
		$this->logger->write_message("success", 'Purchase Order  successfully Approved');
		redirect("accounts/purchase/showall");
	}
	public function edit_purchase()
	{
		$id=$this->purchase_model->edit_purchase();

		$this->session->set_flashdata('msg', 'Purchase Order  Successfully Updated ');
		$this->logger->write_message("success", 'Purchase Order  successfully Updated');
		redirect("accounts/purchase/showall");
	}

	//Ticket No-2861 | Added By Uvini
	public function get_po_list($sup_code){
		
		$data['po_list']=$this->purchase_model->get_confirmed_po_list($sup_code);
		$this->load->view('accounts/invoice/purchase_order_list',$data);
		
	}

	

}
