<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//2019-12-06
class hm_stockusage extends CI_Controller {

	 function __construct() {
        parent::__construct();


		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("supplier_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_projectpayment_model");
		$this->load->model("hm_config_model");
		$this->load->model("hm_stockusage_model");
		$this->load->model("hm_feasibility_model");
		$this->load->model("hm_lotdata_model");
			$this->load->model("hm_inventry_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('stock usage'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		redirect('hm/hm_stockusage/showall');



	}

	public function showall()
	{
		//$this->output->delete_cache();
		$data=NULL;
		if ( ! check_access('stock usage'))
		{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('user');
				return;
		}
		$data=NULL;
		$branchid = $this->session->userdata('branch_code');
		$data['branchlist']=$this->branch_model->get_all_branches_summery();
		//$data['prjlist'] = $this->hm_project_model->get_all_project_summery($branchid);
		$data['prjlist'] = $this->hm_inventry_model->get_all_project_summery($branchid);
		$data['meterial']=$this->hm_config_model->get_meterials_all('','','');

		$this->load->view('hm/stock_usage/stock_list',$data);
	}

	function get_dataset()
	{
		$data['grnid']=$grnid=$this->uri->segment(4);

		//$data['stock_batchw']=$stock_batch=$this->hm_stockusage_model->get_stock_dataset($grnid);


		$this->load->view('hm/stock_usage/batchstock_table',$data);
	}

	function get_blocklist()
	{
		$data['lotlist']=$this->hm_lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('hm/stock_usage/blocklist',$data);

	}

	function get_tasklist()
	{
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['lot_id']=$lot_id=$this->uri->segment(5);
		$data['task_list']=$task_list=$this->hm_feasibility_model->get_boqunitlots_bylot($prj_id,$lot_id);//get_boqunitlots_forac($prj_id,$lot_id);


		$this->load->view('hm/stock_usage/task_table',$data);

	}

	function get_boqmaterials()
	{
		$data['task_id']=$task_id=$this->uri->segment(4);
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['lot_id']=$lot_id=$this->uri->segment(6);
		$data['boq_data']=$boq_data=$this->hm_stockusage_model->get_boqunitlots_material($prj_id,$lot_id,$task_id);
		$boq_data_used=Null;
		if($boq_data)
		{
			foreach ($boq_data as $key => $value) {
				$boq_data_used[$value->id]=$boq_data=$this->hm_stockusage_model->get_mat_already_usage($prj_id,$lot_id,$value->mat_id);
				// code...
			}

		}
		$data['boq_data_used']=$boq_data_used;

		$this->load->view('hm/stock_usage/boq_mat_list',$data);

	}
	function get_boqmaterials_view()
	{
		$data['task_id']=$task_id=$this->uri->segment(4);
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['lot_id']=$lot_id=$this->uri->segment(6);
		$data['boq_data']=$boq_data=$this->hm_stockusage_model->get_boqunitlots_material($prj_id,$lot_id,$task_id);
		$boq_data_used=Null;
		if($boq_data)
		{
			foreach ($boq_data as $key => $value) {
				$boq_data_used[$value->id]=$boq_data=$this->hm_stockusage_model->get_mat_already_usage($prj_id,$lot_id,$value->mat_id);
				// code...
			}

		}
		$data['boq_data_used']=$boq_data_used;

		$this->load->view('hm/stock_usage/boq_mat_view',$data);

	}
	function get_stockdata()
	{
		$data['mat_id']=$mat_id=$this->uri->segment(4);
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['lot_id']=$lot_id=$this->uri->segment(6);

		$data['stock_list']=$stock_list=$this->hm_stockusage_model->get_mat_already_usage($prj_id,$lot_id,$mat_id);

		$this->load->view('hm/stock_usage/boq_mat_table',$data);
	}

	function add_meterial_usage()
	{
		$prj_id=$this->input->post('prj_id');
		$lot_id=$this->input->post('lot_id');
		$task_id=$this->input->post('task_id');
		$get_prj_data=$this->hm_project_model->get_project_bycode($prj_id);
		$boq_data=$this->hm_stockusage_model->get_boqunitlots_material($prj_id,$lot_id,$task_id);

		if($boq_data)
		{
			foreach ($boq_data as $key => $value) {
				$boq_data_used[$value->id]=$boq_data=$this->hm_stockusage_model->get_mat_already_usage($prj_id,$lot_id,$value->mat_id);
				if($boq_data_used[$value->id])
	      {
					foreach ($boq_data_used[$value->id] as $key2 => $value2)
					{
						$stock_id=$this->input->post('stock_'.$value2->site_stockid);
						$ussed_qty=$this->input->post('used_'.$value2->site_stockid);
						$new_usage=$this->input->post('new_usage_'.$value2->site_stockid);
						$price=$this->input->post('price_'.$value2->site_stockid);

							$total_usage=$ussed_qty+$new_usage;



						$data = array('site_stockid'=>$stock_id,
							'task_id'=>$value->id,
							'qty'=>$new_usage,
							'update_by'=>$this->session->userdata('userid'),
							'update_date' => date('Y-m-d'), );
							if($new_usage!=0){
								$update=$this->hm_stockusage_model->add_meterial_usage($data,$stock_id,$total_usage);
								$amount=$price*$total_usage;
								$date=date('Y-m-d');
								$ledgerset=hm_get_account_set('Usage Cost Transfer');
								$crlist[0]['ledgerid']=$ledgerset['Cr_account'];
								$crlist[0]['amount']=$crtot=$amount;
								$drlist[0]['ledgerid']=$get_prj_data->ledger_acc;
								$drlist[0]['amount']=$drtot=$amount;
								$narration = 'Added Usage For The Project '.get_prjname($prj_id).' For Stock '.$stock_id.' Cost Tranfer'  ;
								$int_entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,$date,$narration,$prj_id,$lot_id);

							}

					}
				}
			}

		}
		$this->session->set_flashdata('msg', 'Usage Updated Successfully. ');
		redirect("hm/hm_stockusage/showall");


	}

}
