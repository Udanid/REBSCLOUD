<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lotdata extends CI_Controller {

	/**
	 * Index Page for this controller.land
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


		$this->load->model("common_model");

		$this->load->model("hm_project_model");
	    $this->load->model("hm_lotdata_model");
		$this->load->model("hm_salesmen_model");
		$this->load->model("hm_eploan_model");
		$this->load->model("customer_model");
		$this->load->model("branch_model");
		$this->load->model("search_model");
		$this->load->model("hm_reservation_model");
		$this->load->model("common_model");
		$this->load->model("hm_reservationdiscount_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_lotlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('home');
			return;
		}
		redirect('hm/project/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_lotlist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->hm_project_model->get_all_project_confirmed(100,0,$this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->project_name.'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/lotdata/search';
				$data['tag']='Search project';
				$data['product_code']='LNS';
					$this->load->library('pagination');

		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */

			$config['base_url'] = site_url('hm/lotdata/showall');
			$config['uri_segment'] = 4;

		$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
		$config['num_links'] = 10;
		$config['per_page'] = $pagination_counter;
		$config['full_tag_open'] = '<ul id="pagination-flickr">';
		$config['full_close_open'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_link'] = 'Next &#187;';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&#171; Previous';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$startcounter=($page_count)*$pagination_counter;
		$data['datalist']=$this->hm_project_model->get_all_project_confirmed($pagination_counter,$page_count,$this->session->userdata('branchid'));
		$config['total_rows'] =$this->common_model->confirm_count('hm_projectms');
			//echo $pagination_counter;
		$this->pagination->initialize($config);

		//$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('hm/lotdata/project_list',$data);



	}
	function search()
	{

		$data['planlist']=$planlist=$this->hm_lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist){
		//	print_r($planlist);
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->hm_lotdata_model->get_project_lots_report($this->uri->segment(4),$plnraw->plan_sq)	;
		}}
		//print_r($lotlist);
		$data['lotlist']=$lotlist;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->hm_lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('hm/lotdata/search',$data);
	}
	function print_report()
	{

		$data['planlist']=$planlist=$this->hm_lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->hm_lotdata_model->get_project_lots_report($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->hm_lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('hm/lotdata/print_report',$data);
	}
	function load_excel()
	{

		$data['planlist']=$planlist=$this->hm_lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->hm_lotdata_model->get_project_lots_report($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->hm_lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('hm/lotdata/print_excel',$data);
	}
	function thisfinance_cost()
	{
		$data['details']=$this->hm_lotdata_model->get_finance_cost($this->uri->segment(4));
		$this->load->view('hm/lotdata/finance_cost',$data);
	}
	function pending_lots()
	{
		if ( ! check_access('view_lotlist'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}
		$data['planlist']=$planlist=$this->hm_lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$this->common_model->delete_curent_tabactivflag('hm_prjacblockplane');
		$this->common_model->add_activeflag('hm_prjacblockplane',$this->uri->segment(4),'prj_id');
		$session = array('activtable'=>'hm_prjacblockplane');
		$this->session->set_userdata($session);
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->hm_lotdata_model->get_project_pending_lots($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->hm_lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('hm/lotdata/lotlist',$data);
	}
	function add()
	{
		if ( ! check_access('add_lotdata'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
				 $file_name="";
				$config['upload_path'] = 'uploads/project/blockoutplan/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '300';

                $this->load->library('image_lib');
                $this->load->library('upload', $config);
				$this->upload->do_upload('plan1');
            	$error = $this->upload->display_errors();
				$image_data = $this->upload->data();
				//echo $error;
				if($error==""){
					$file_name=$image_data['file_name'];
				}
				if(!$this->hm_lotdata_model->check_blockout($this->input->post('prj_id'),$this->input->post('plan_no')))
				{
						$sqid=$this->hm_lotdata_model->add_blockoutplan($file_name);
				}
				else
				{
					$datasg=$this->hm_lotdata_model->get_plansq($this->input->post('prj_id'),$this->input->post('plan_no'));
					$sqid=$datasg->plan_sq;
				}
				$this->hm_lotdata_model->update_finance_cost($this->input->post('finance_cost'),$this->input->post('prj_id'));
			//	$this->hm_lotdata_model->delete_pendinglot($this->input->post('prj_id'));
				$oldblocks=$this->input->post('oldblockcount');
				if($oldblocks==0)
				$blockcount= $this->input->post('blockout_count');
				else
				$blockcount=$oldblocks+$this->input->post('blockout_count')-1;
				for($i=1; $i<=$blockcount; $i++)
				{
					if($this->input->post('isselect'.$i)!="YES")
					{
					$prj_id= $this->input->post('prj_id');
					if($this->input->post('plansq'.$i)=="")
					$plan_sqid= $sqid;
					else
					$plan_sqid=$this->input->post('plansq'.$i);
					$lot_number= $this->input->post('lot_number'.$i);
					$extend_perch= $this->input->post('perches_count'.$i);
					$price_perch= $this->input->post('price'.$i);
					$sale_val= $this->input->post('subtotprice'.$i);
					$lot_id= $this->input->post('lot_id'.$i);
						if($lot_id!="")
						$this->hm_lotdata_model->update_lotdata($lot_id,$prj_id,$plan_sqid,$lot_number,$extend_perch,$price_perch,$sale_val);
						else
						$this->hm_lotdata_model->add_lotdata($prj_id,$plan_sqid,$lot_number,$extend_perch,$price_perch,$sale_val);

					}
					else
					{ $lot_id= $this->input->post('lot_id'.$i);
						if($lot_id!="")
							$this->hm_lotdata_model->delete_pendinglot_lotid($lot_id);

					}
				}
		$this->hm_lotdata_model->cost_adjustment($prj_id);
		$this->common_model->delete_activflag('hm_prjacblockplane',$this->input->post('prj_id'),'prj_id');
		$this->session->set_flashdata('msg', 'Project Lot Details Successfully Updated ');
		$this->logger->write_message("success", $prj_id.' Project Lot Successfully Updated');
		redirect('hm/lotdata/showall/');
	}
	// Lot inquary function list ********************************************************************/
	function lot_inquiry()
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
					// $data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					//$data['prjlist']=$this->hm_salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
					$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();

				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				$this->load->view('hm/lotdata/lot_inquiry',$data);


	}
	function get_blocklist()
	{
		$data['lotlist']=$this->hm_lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('hm/lotdata/blocklist',$data);

	}
	function get_fulldata()
	{
		$data['projectdata']=$this->hm_reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->hm_lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->hm_lotdata_model->get_max_resid($this->uri->segment(4));
		$data['loan_data']=NULL;
		$data['settle_data']=NULL;
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->hm_reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['current_advances']=$current_advances=$this->hm_reservation_model->get_advance_data($current_rescode);
		$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($current_rescode);
			if($current_res->pay_type!='Outright')
			{
				$data['loan_data']=$current_advances=$this->hm_reservation_model->get_eploan_data($current_rescode);
			}
			else
			{
				if($current_res->res_status=='SETTLED')
				{
					$data['settle_data']=$current_advances=$this->hm_reservation_model->get_settlemnt_data_with_payment($current_rescode);
				}
			}

			$data['refunddata']=$this->hm_reservation_model->get_customer_refund($current_rescode);

			//2019-12-19 Ticket 943 B.K.Dissanayake
			$data['resevationdiscount']=$this->hm_reservationdiscount_model->get_reservationDiscount_by_lotid_prjid($current_rescode);

			// end
		}
		$data['res_his']=$res_his=$this->hm_lotdata_model->get_reservation_historty($this->uri->segment(4));
		$resolelist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$this->hm_lotdata_model->get_resale_by_res_code($raw->res_code);

				}
				else
				$resolelist[$raw->res_code]=$this->hm_lotdata_model->get_epresale_res_code($raw->res_code);

			}
		}
		$data['resolelist']=$resolelist;

		// Added by kalum Ticket 814 2019-10-28

			$data['paylistinq']=NULL;

			if($data['loan_data']){
				//if($current_advances->loan_type!='EPB'){
					$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($current_advances->loan_code);
				//}
			}

		// end Ticket 814

		$this->load->view('hm/lotdata/full_details',$data);
	}
	function get_fulldata_popup()
	{
		$data['projectdata']=$this->hm_reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->hm_lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->hm_lotdata_model->get_max_resid($this->uri->segment(4));
		$data['settle_data']=NULL;
		$data['loan_data']=NULL;
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->hm_reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['current_advances']=$current_advances=$this->hm_reservation_model->get_advance_data($current_rescode);
		$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($current_rescode);

			if($current_res->pay_type!='Outright')
			{
				$data['loan_data']=$current_advances=$this->hm_reservation_model->get_eploan_data($current_rescode);
			}
			else
			{
				if($current_res->res_status=='SETTLED')
				{
					$data['settle_data']=$current_advances=$this->hm_reservation_model->get_settlemnt_data_with_payment($current_rescode);
				}
			}
		$data['refunddata']=$this->hm_reservation_model->get_customer_refund($current_rescode);

			//2019-12-19 Ticket 943 B.K.Dissanayake
			$data['resevationdiscount']=$this->hm_reservationdiscount_model->get_reservationDiscount_by_lotid_prjid($current_rescode);
		}
		$data['res_his']=$res_his=$this->hm_lotdata_model->get_reservation_historty($this->uri->segment(4));
		$resolelist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$this->hm_lotdata_model->get_resale_by_res_code($raw->res_code);

				}
				else
				$resolelist[$raw->res_code]=$this->hm_lotdata_model->get_epresale_res_code($raw->res_code);

			}
		}
		$data['resolelist']=$resolelist;

		$this->load->view('hm/lotdata/full_details_popup',$data);
	}
	function print_inquary()
	{
		$data['projectdata']=$this->hm_reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->hm_lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->hm_lotdata_model->get_max_resid($this->uri->segment(4));
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->hm_reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['current_advances']=$current_advances=$this->hm_reservation_model->get_advance_data($current_rescode);
		$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		$data['charge_payment']=$this->hm_reservation_model->get_charge_payments($current_rescode);

			if($current_res->pay_type!='Outright')
			{
				$data['loan_data']=$current_advances=$this->hm_reservation_model->get_eploan_data($current_rescode);
			}


		}
		$data['res_his']=$res_his=$this->hm_lotdata_model->get_reservation_historty($this->uri->segment(4));
		$resolelist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$this->hm_lotdata_model->get_resale_by_res_code($raw->res_code);

				}
				else
				$resolelist[$raw->res_code]=$this->hm_lotdata_model->get_epresale_res_code($raw->res_code);

			}
		}
		$data['resolelist']=$resolelist;

		$this->load->view('hm/lotdata/print_inquary',$data);
	}




	function edit_lot()
	{
			$data=NULL;
		if ( ! check_access('edit_rslot'))
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
				$this->load->view('hm/lotdata/edit_lot',$data);


	}
	function edit_blocklist()
	{
		$data['lotlist']=$this->hm_lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('hm/lotdata/edit_blocklist',$data);

	}

	function edit_rslot()
	{
		if ( ! check_access('edit_rslot'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/lotdata/showall');
			return;
		}
		$editid=$this->hm_lotdata_model->edit_rslot();
		$this->session->set_flashdata('msg', 'Project Lot Details Successfully Updated ');
		$this->logger->write_message("success",' Project Lot Successfully Updated');
		redirect('hm/lotdata/edit_lot/');
	}
	public function confirm_price()
	{
		if ( ! check_access('confirm_pricelist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/showall');
			return;
		}

		$id=$this->hm_project_model->confirm_price($this->uri->segment(4));

		$this->common_model->delete_notification('hm_projectms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'project Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  project id successfully Confirmed');
		redirect("hm/lotdata/showall");

	}

	function get_customerpopup()
	{
		$data['followlist']=$this->common_model->get_followuplist_bycuscode($this->uri->segment(4));
		$data['reservationlist']=$this->search_model->get_customer_reservation_list($this->uri->segment(4));

		$data['cusdata']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['type']=$this->uri->segment(5);
		$this->load->view('hm/lotdata/customer_popup',$data);
	}
		function get_followup()
	{
		$data['followlist']=$this->common_model->get_followuplist_bycuscode($this->uri->segment(4));

		$this->load->view('hm/lotdata/followup_popup',$data);
	}

	function get_resalepayment()
	{
		$data['resdata']=$resdata=$this->hm_reservation_model->get_all_reservation_details_bycode($this->uri->segment(4));
		$data['current_advances']=$current_advances=$this->hm_reservation_model->get_advance_data($this->uri->segment(4));
		$data['loan_status']= $loan_status = $this->hm_lotdata_model->if_loan_excist($this->uri->segment(4));
		if($loan_status == '0')
		{
					$data['resaledata']=$resaledata=$this->hm_lotdata_model->get_resale_by_res_code($resdata->res_code);
					$data['paylist']=$this->common_model->get_resale_payment($resaledata->resale_code);

		}else
		{
				$data['resaledata']=$resaledata=$this->hm_lotdata_model->get_epresale_res_code($resdata->res_code);
				$data['paylist']=$this->common_model->get_epresale_payment($resaledata->resale_code);
				$data['loan_data']=$current_advances=$this->hm_reservation_model->get_eploan_data($resdata->res_code);
		}
		$this->load->view('hm/lotdata/resale_popup',$data);
	}

	//2020-01-20 update by nadee ticket number 1064
	function view_nic($nic,$type)
	{
		$data['cusdata']=$this->customer_model->get_customer_bycode($nic);
		$data['type']=$type;
		$this->load->view('re/lotdata/customer_nic_print',$data);
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
