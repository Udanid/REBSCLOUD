<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//2019-12-02
class hm_stockdispatch extends CI_Controller {

	 function __construct() {
        parent::__construct();


		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("supplier_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_projectpayment_model");
		$this->load->model("hm_stockdispatch_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view stock'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		redirect('hm/hm_stockdispatch/showall');



	}

	public function showall()
	{
		//$this->output->delete_cache();
		$data=NULL;
		if ( ! check_access('view stock'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		$data=NULL;
		$branchid = $this->session->userdata('branch_code');
		$data['list']=$list=$this->hm_stockdispatch_model->get_grn_all();
		$data['prjlist'] = $this->hm_project_model->get_all_project_summery($branchid);
		//$data['tranfer_list']=$this->hm_stockdispatch_model->get_site_stock_transfers();

		$pagination_counter =RAW_COUNT;
		$page_count = (int)$this->uri->segment(4);
			if ( !$page_count)
			$page_count = 0;
		$data['tranfer_list']=$this->hm_stockdispatch_model->get_site_stock_transfers($pagination_counter,$page_count);
		$siteurl='hm/hm_stockdispatch/showall';
		$tablename='hm_sitestock';
		$data['tab']='';

			if($page_count)
				$data['tab']='profile';
		$this->pagination($page_count,$siteurl,$tablename);

		$this->load->view('hm/stock/stock_batch_list',$data);
	}

	function get_dataset()
	{

		//$data['grnid']=$grnid=$this->uri->segment(4);

		$data['stock_batch']=$stock_batch=$this->hm_stockdispatch_model->get_stock_dataset();


		$this->load->view('hm/stock/batchstock_table',$data);
	}

	function add_dispatch()
	{
		$stock_batch=$this->hm_stockdispatch_model->get_stock_dataset();
		$prj_id=$this->input->post('prj_id');
		$lot_id=$this->input->post('lot_id');
		foreach ($stock_batch as $key => $value) {
			if($this->input->post('check_'.$value->stock_id)=="YES")
			{
				$newqty=$this->input->post('newqty_'.$value->stock_id);
				$data = array('prj_id'=>$prj_id,
					'lot_id' =>$lot_id,
					'mat_id'=>$this->input->post('mat_'.$value->stock_id),
					'stock_id'=>$this->input->post('stock_'.$value->stock_id),
					'rcv_qty'=>$newqty,
					'price'=>$value->price,
					'rcv_date'=>date('Y-m-d H:i:s'),
					'status'=>"PENDING");
					$amount=$newqty+$value->ussed_qty;
					$stock_insert=$this->hm_stockdispatch_model->add_dispatch($data,$value->stock_id,$amount);
			}

		}
		$this->session->set_flashdata('msg', 'Successfuly Sitestock Transfered');
		redirect('hm/hm_stockdispatch/showall');

	}

	function confirm_stock_tranfer()
	{
		$data['site_stockid']=$site_stockid=$this->uri->segment(4);
		$stock_insert=$this->hm_stockdispatch_model->confirm_dispatch($site_stockid);
		if($stock_insert)
		{
			$this->session->set_flashdata('msg', 'Successfuly Sitestock Transfered');
			redirect('hm/hm_stockdispatch/showall');
		}
		else{
			$this->session->set_flashdata('error', 'Something Went Wrong..! Please Try Again..');
			redirect('hm/hm_stockdispatch/showall');
		}
	}

	function delete_stock_tranfer()
	{
		$data['site_stockid']=$site_stockid=$this->uri->segment(4);
		$stock_insert=$this->hm_stockdispatch_model->delete_dispatch($site_stockid);
		if($stock_insert)
		{
			$this->session->set_flashdata('msg', 'Successfuly Deleted Sitestock');
			redirect('hm/hm_stockdispatch/showall');
		}
		else{
			$this->session->set_flashdata('error', 'Something Went Wrong..! Please Try Again..');
			redirect('hm/hm_stockdispatch/showall');
		}
	}

}
