<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//2019-12-02
class Hm_purchase_orders extends CI_Controller {

	 function __construct() {
        parent::__construct();

		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("supplier_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_projectpayment_model");
		$this->load->model("hm_purchase_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view po'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		redirect('hm/hm_purchase_orders/showall');



	}

	public function showall()
	{
		$newponmbr = ""; 
		//$this->output->delete_cache();
		$data=NULL;
		if ( ! check_access('view po'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		$data=NULL;

		$data['list']=$list=$this->hm_purchase_model->get_purchase_item();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$data['po_orders']=$this->hm_purchase_model->get_po_request_data();

		/* new code added 2019-12-24 by terance perera.. */
           /* get last po number */
           $lastponmbr=$this->hm_purchase_model->get_last_po_nmbr();
           
           if(sizeof($lastponmbr)>0){
           	$lastpo = $lastponmbr->po_code;
            $fill = 4;
			$newnmbr = $lastpo+1;
			$newponmbr=str_pad($newnmbr, $fill, '0', STR_PAD_LEFT);
		   }else{
           	$newponmbr = "0001";
           }

           $data['newponumber'] = $newponmbr;
           
		/* new code added 2019-12-24 by terance perera.. */

		$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/hm_purchase_orders/purchase_main';


				$data['tag']='Search Document Types';

		$this->load->view('hm/purchase_orders/purchase_items',$data);
	}

	public function purchase_orders()
	{
		$data=NULL;
		if ( ! check_access('add po'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}

		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$courseSelectList="";
				 $count=0;
				$data['prjlist']=$this->hm_project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/hm_purchase_orders/purchase_main';


				$data['tag']='Search Document Types';

		$this->load->view('hm/purchase_orders/purchase_main',$data);
	}

	public function add_purchase()
	{


		if($this->input->post('tot_tot_price')<=0){
      $this->db->trans_rollback();
      $this->session->set_flashdata('error','Please Add Value Items.' );
      redirect("hm/hm_purchase_orders/showall");
    }else{
			$id=$this->hm_purchase_model->add_purchase();
		}
		$this->session->set_flashdata('msg', 'Purchase Order Successfully Inserted ');
		$this->logger->write_message("success", 'Purchase Order  successfully Inserted');
		redirect("hm/hm_purchase_orders/showall");

	}
	public function delete_purchase($id)
	{
		$data=NULL;
		if ( ! check_access('delete po'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		$id=$this->hm_purchase_model->delete_purchase($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Purchase Order  Successfully Deleted ');
		$this->logger->write_message("success", 'Purchase Order  successfully Deleted');
		redirect("hm/hm_purchase_orders/showall");

	}
	public function edit_view()
	{
		$data=NULL;
		if ( ! check_access('edit po'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		$data['id']=$id=$this->uri->segment(4);
		$data['action']=$action=$this->uri->segment(5);
		$data['purchase_list']=$purchase_list=$this->hm_purchase_model->get_purchase_item_byid($id);
		$data['purchase_item_list']=$purchase_item_list=$this->hm_purchase_model->get_purchase_item_list_byid($id);
		$data['po_orders']=$this->hm_purchase_model->get_po_request_data();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();

		$this->load->view('hm/purchase_orders/purchase_details',$data);

	}
	public function approve_purchase()
	{
		$data=NULL;
		if ( ! check_access('confirm po'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		$id=$this->hm_purchase_model->approve_purchase();

		$this->session->set_flashdata('msg', 'Purchase Order  Successfully Approved ');
		$this->logger->write_message("success", 'Purchase Order  successfully Approved');
		redirect("hm/hm_purchase_orders/showall");
	}
	public function edit_purchase()
	{
		if($this->input->post('tot_tot_price')<=0){
      $this->db->trans_rollback();
      $this->session->set_flashdata('error','Please Add Value Items.' );
      redirect("hm/hm_purchase_orders/showall");
    }else{
			$id=$this->hm_purchase_model->edit_purchase();
		}


		$this->session->set_flashdata('msg', 'Purchase Order  Successfully Updated ');
		$this->logger->write_message("success", 'Purchase Order  successfully Updated');
		redirect("hm/hm_purchase_orders/showall");
	}
	function get_suplier_orders()
	{
		$data['supid']=$supid=$this->uri->segment(4);

		$data['po_orders']=$po_orders=$this->hm_purchase_model->get_suplier_orders($supid);
		if(!$po_orders){
			$data['po_orders']=$this->hm_purchase_model->get_po_request_data();
		}

		$this->load->view('hm/purchase_orders/po_table',$data);
	}

	//created by terance 2019-01-09
	function get_data_by_keyword(){
		$data['listkeyval'] = "";
		$keyvalue = $this->uri->segment(4);
		$posearch = $this->hm_purchase_model->get_searchkey_related_data($keyvalue);
		if(!empty($posearch)){
		  $data['listkeyval'] = $posearch;
		}
		$this->load->view('hm/purchase_orders/load_po_by_search_keyword_view',$data);
	}

}
