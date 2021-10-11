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

		$this->load->model("project_model");
	    $this->load->model("lotdata_model");
		$this->load->model("salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("branch_model");
		$this->load->model("search_model");
		$this->load->model("reservation_model");
		$this->load->model("reservationdiscount_model");
		$this->load->model("eploan_model");
		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->library('Excel');
		$this->load->model("additional_development_model");
		

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
		redirect('re/project/showall');



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
		$data['searchdata']=$inventory=$this->project_model->get_all_project_confirmed(200,0,$this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->project_name.'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/lotdata/search';
				$data['tag']='Search project';
				$data['product_code']='LNS';
					$this->load->library('pagination');

		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */

			$config['base_url'] = site_url('re/lotdata/showall');
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
		$data['datalist']=$this->project_model->get_all_project_confirmed($pagination_counter,$page_count,$this->session->userdata('branchid'));
		$config['total_rows'] =$this->common_model->confirm_count('re_projectms');
			//echo $pagination_counter;
		$this->pagination->initialize($config);

		//$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('re/lotdata/project_list',$data);



	}
	function seach_project_blockplan($id)
	{
		$data['datalist']=$this->project_model->get_all_project_confirmed_search($id);
		$this->load->view('re/lotdata/project_list_search',$data);
	}
	function search()
	{

		$data['planlist']=$planlist=$this->lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist){
		//	print_r($planlist);
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->lotdata_model->get_project_lots_report($this->uri->segment(4),$plnraw->plan_sq)	;
		}}
		//print_r($lotlist);
		$data['lotlist']=$lotlist;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('re/lotdata/search',$data);
	}
	function print_report()
	{

		$data['planlist']=$planlist=$this->lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->lotdata_model->get_project_lots_report($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('re/lotdata/print_report',$data);
	}
	function load_excel()
	{

		$data['planlist']=$planlist=$this->lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->lotdata_model->get_project_lots_report($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('re/lotdata/print_excel',$data);
	}
	function thisfinance_cost()
	{
		$data['details']=$this->lotdata_model->get_finance_cost($this->uri->segment(4));
		$this->load->view('re/lotdata/finance_cost',$data);
	}
	function pending_lots()
	{
		if ( ! check_access('view_lotlist'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/feasibility/showall/'.$encode_id);
			return;
		}
		$data['planlist']=$planlist=$this->lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$this->common_model->delete_curent_tabactivflag('re_prjacblockplane');
		$this->common_model->add_activeflag('re_prjacblockplane',$this->uri->segment(4),'prj_id');
		$session = array('activtable'=>'re_prjacblockplane');
		$this->session->set_userdata($session);
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->lotdata_model->get_project_pending_lots($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('re/lotdata/lotlist',$data);
	}

	function check_pending_lots(){
		$planlist=$this->lotdata_model->get_project_blockplans($this->input->post('id'));
		if($planlist)
			echo 1;
		else
			echo 0;
	}

	function add()
	{
		if ( ! check_access('add_lotdata'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/lotdata/showall/');
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
				if(!$this->lotdata_model->check_blockout($this->input->post('prj_id'),$this->input->post('plan_no')))
				{
						$sqid=$this->lotdata_model->add_blockoutplan($file_name);
				}
				else
				{
					$datasg=$this->lotdata_model->get_plansq($this->input->post('prj_id'),$this->input->post('plan_no'));
					$sqid=$datasg->plan_sq;
				}
				$this->lotdata_model->update_finance_cost($this->input->post('finance_cost'),$this->input->post('prj_id'));
				//$this->lotdata_model->delete_pendinglot($this->input->post('prj_id'));
				$oldblocks=$this->input->post('oldblockcount');
				if($oldblocks==0)
				$blockcount= $this->input->post('blockout_count');
				else
				$blockcount=$oldblocks+$this->input->post('blockout_count')-1;

				$prj_id= $this->input->post('prj_id');
				for($i=1; $i<=$blockcount; $i++)
				{
					if($this->input->post('isselect'.$i)!="YES")
					{

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
						$this->lotdata_model->update_lotdata($lot_id,$prj_id,$plan_sqid,$lot_number,$extend_perch,$price_perch,$sale_val);
						else
						$this->lotdata_model->add_lotdata($prj_id,$plan_sqid,$lot_number,$extend_perch,$price_perch,$sale_val);

					}
					else
					{ $lot_id= $this->input->post('lot_id'.$i);
						if($lot_id!="")
							$this->lotdata_model->delete_pendinglot_lotid($lot_id);

					}

				}
				$details=$this->project_model->get_project_bycode($prj_id);
		if($details->price_status=='PENDING')
		$this->common_model->add_notification('re_prjaclotdata','Price List','re/lotdata/showall/',$prj_id);

		$this->lotdata_model->cost_adjustment($prj_id);
		$this->common_model->delete_activflag('re_prjacblockplane',$this->input->post('prj_id'),'prj_id');
		$this->session->set_flashdata('msg', 'Project Lot Details Successfully Updated ');
		$this->logger->write_message("success", $prj_id.' Project Lot Successfully Updated');
		redirect('re/lotdata/showall/');
	}
	// Lot inquary function list ********************************************************************/
	function lot_inquiry()
	{
			$data=NULL;
		if ( ! check_access('view_reservation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/');
			return;
		}

			//	$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/reservation/search';
				$data['tag']='Search reservation';
				if($this->uri->segment(4))
				$data['cus_code']=$this->uri->segment(4);
				else $data['cus_code']="";
				 if($this->session->userdata('usertype')=='Sales_officer')
				 {
					 $data['prjlist']=$this->salesmen_model->get_all_projectlist_inquary($this->session->userdata('userid'));
					// $data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					//$data['prjlist']=$this->salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
					$data['prjlist']=$this->salesmen_model->get_all_projectlist_inquary($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();

				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				$this->load->view('re/lotdata/lot_inquiry',$data);


	}
	function get_blocklist()
	{
		$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('re/lotdata/blocklist',$data);

	}
	function get_fulldata()
	{
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['loan_data']=NULL;
		$data['settle_data']=NULL;
		$data['cusdata2']=NULL;
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['current_advances']=$current_advances=$this->reservation_model->get_advance_data($current_rescode);
		$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		if($current_res->cus_code2)
		$data['cusdata2']=$this->customer_model->get_customer_bycode($current_res->cus_code2);
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
			if($current_res->pay_type!='Outright')
			{
				$data['loan_data']=$loan_data=$this->reservation_model->get_eploan_data($current_rescode);
			}
			else
			{
				if($current_res->res_status=='SETTLED')
				{
					$data['settle_data']=$current_advances=$this->reservation_model->get_settlemnt_data_with_payment($current_rescode);
				}
			}
			$data['refunddata']=$this->reservation_model->get_customer_refund($current_rescode);

			//2019-12-19 Ticket 943 B.K.Dissanayake
			$data['resevationdiscount']=$this->reservationdiscount_model->get_reservationDiscount_by_lotid_prjid($current_rescode);

		}
		$data['res_his']=$res_his=$this->lotdata_model->get_reservation_historty($this->uri->segment(4));
		$resolelist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$this->lotdata_model->get_resale_by_res_code($raw->res_code);

				}
				else
				$resolelist[$raw->res_code]=$this->lotdata_model->get_epresale_res_code($raw->res_code);

			}
		}
		$data['resolelist']=$resolelist;


		// Added by kalum Ticket 814 2019-10-28

			$data['paylistinq']=NULL;
$data['rebate']=NULL;
			if($data['loan_data']){
				//if($current_advances->loan_type!='EPB'){
					$data['paylistinq']=$this->eploan_model->get_paid_list_inquary_all($loan_data->loan_code);
						if($loan_data->loan_status=='SETTLED')
						$data['rebate']=$this->eploan_model->get_rebate_by_loancode($loan_data->loan_code);

				//}
			}

		// end Ticket 814

		// additonal development in lot inquart
		$data['development_data']=$this->additional_development_model->get_development_data_by_res_code($current_rescode);

		$this->load->view('re/lotdata/full_details',$data);
	}
	function get_fulldata_popup()
	{
		$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
		$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['settle_data']=NULL;
		$data['loan_data']=NULL;
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['current_advances']=$current_advances=$this->reservation_model->get_advance_data($current_rescode);
		$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);

			if($current_res->pay_type!='Outright')
			{
				$data['loan_data']=$current_advances=$this->reservation_model->get_eploan_data($current_rescode);
			}
			else
			{
				if($current_res->res_status=='SETTLED')
				{
					$data['settle_data']=$current_advances=$this->reservation_model->get_settlemnt_data_with_payment($current_rescode);
				}
			}

		$data['refunddata']=$this->reservation_model->get_customer_refund($current_rescode);

			//2019-12-19 Ticket 943 B.K.Dissanayake
			$data['resevationdiscount']=$this->reservationdiscount_model->get_reservationDiscount_by_lotid_prjid($current_rescode);
		}
		$data['res_his']=$res_his=$this->lotdata_model->get_reservation_historty($this->uri->segment(4));
		$resolelist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$this->lotdata_model->get_resale_by_res_code($raw->res_code);

				}
				else
				$resolelist[$raw->res_code]=$this->lotdata_model->get_epresale_res_code($raw->res_code);

			}
		}
		$data['resolelist']=$resolelist;
		$data['development_data']=$this->additional_development_model->get_development_data_by_res_code($current_rescode);

		$this->load->view('re/lotdata/full_details_popup',$data);
	}
	function print_inquary()
	{//Ticket No-2774 | Added By Uvini
				$data['projectdata']=$this->reservation_model->get_project_bycode($this->uri->segment(5));
				$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
				$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
				$data['loan_data']=NULL;
				$data['settle_data']=NULL;
				if($current_rescode)
				{
				$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
				$data['current_advances']=$current_advances=$this->reservation_model->get_advance_data($current_rescode);
				$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
				$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
					if($current_res->pay_type!='Outright')
					{
						$data['loan_data']=$loan_data=$this->reservation_model->get_eploan_data($current_rescode);
					}
					else
					{
						if($current_res->res_status=='SETTLED')
						{
							$data['settle_data']=$current_advances=$this->reservation_model->get_settlemnt_data_with_payment($current_rescode);
						}
					}
					$data['refunddata']=$this->reservation_model->get_customer_refund($current_rescode);

					//2019-12-19 Ticket 943 B.K.Dissanayake
					$data['resevationdiscount']=$this->reservationdiscount_model->get_reservationDiscount_by_lotid_prjid($current_rescode);

				}
				$data['res_his']=$res_his=$this->lotdata_model->get_reservation_historty($this->uri->segment(4));
				$resolelist=NULL;
				if($res_his)
				{
					foreach($res_his as $raw)
					{
						if($raw->pay_type=='Pending')
						{
							$resolelist[$raw->res_code]=$this->lotdata_model->get_resale_by_res_code($raw->res_code);

						}
						else
						$resolelist[$raw->res_code]=$this->lotdata_model->get_epresale_res_code($raw->res_code);

					}
				}
				$data['resolelist']=$resolelist;


				// Added by kalum Ticket 814 2019-10-28

					$data['paylistinq']=NULL;
					$data['rebate']=NULL;
					if($data['loan_data']){
						//if($current_advances->loan_type!='EPB'){
							$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($loan_data->loan_code);
								if($loan_data->loan_status=='SETTLED')
								$data['rebate']=$this->eploan_model->get_rebate_by_loancode($loan_data->loan_code);

						//}
					}

				// end Ticket 814

				// additonal development in lot inquart
				$data['development_data']=$this->additional_development_model->get_development_data_by_res_code($current_rescode);

						// $this->load->view('re/lotdata/lot_inquiry',$data);
			$this->load->view('re/lotdata/print_inquary',$data);
	}




	function edit_lot()
	{
			$data=NULL;
		if ( ! check_access('edit_rslot'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/');
			return;
		}

			//	$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/reservation/search';
				$data['tag']='Search reservation';
				if($this->uri->segment(4))
				$data['cus_code']=$this->uri->segment(4);
				else $data['cus_code']="";
				 if($this->session->userdata('usertype')=='Sales_officer')
				 {
					 $data['prjlist']=$this->salesmen_model->get_salesmen_projectlist($this->session->userdata('userid'));
				 }
				 else
				 {
					//$data['prjlist']=$this->salesmen_model->get_officer_projectlist($this->session->userdata('userid'));
					$data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				 }
				 $data['cuslist']=$this->customer_model->get_all_customer_summery();

				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				$this->load->view('re/lotdata/edit_lot',$data);


	}
	function edit_blocklist()
	{
		$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('re/lotdata/edit_blocklist',$data);

	}

	function edit_rslot()
	{
		if ( ! check_access('edit_rslot'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/lotdata/showall');
			return;
		}
		$editid=$this->lotdata_model->edit_rslot();
		$this->session->set_flashdata('msg', 'Project Lot Details Successfully Updated ');
		$this->logger->write_message("success",' Project Lot Successfully Updated');
		redirect('re/lotdata/edit_lot/');
	}
	public function confirm_price()
	{
		if ( ! check_access('confirm_pricelist'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}

		//check already confirmed
		if($this->project_model->check_price_confirmed($this->uri->segment(4))){
			$this->session->set_flashdata('error', 'Already Confirmed');
			redirect('re/lotdata/showall');
		}

		$id=$this->project_model->confirm_price($this->uri->segment(4));

		$this->common_model->delete_notification('re_prjaclotdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'project Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  project id successfully Confirmed');
		redirect("re/lotdata/showall");

	}

	function get_customerpopup()
	{
		$data['followlist']=$this->common_model->get_followuplist_bycuscode($this->uri->segment(4));
		$data['reservationlist']=$this->search_model->get_customer_reservation_list($this->uri->segment(4));

		$data['cusdata']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['docdata']=$this->document_model->get_customer_handoverdocuments_byres($this->uri->segment(4));//updated by nadee 2741
		$data['type']=$this->uri->segment(5);
		$this->load->view('re/lotdata/customer_popup',$data);
	}
		function get_followup()
	{
		$data['followlist']=$this->common_model->get_followuplist_bycuscode($this->uri->segment(4));

		$this->load->view('re/lotdata/followup_popup',$data);
	}

	function get_resalepayment()
	{
		$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($this->uri->segment(4));
		$data['current_advances']=$current_advances=$this->reservation_model->get_advance_data($this->uri->segment(4));
		$data['loan_status']= $loan_status = $this->lotdata_model->if_loan_excist($this->uri->segment(4));
		$data['charge_payment']=$this->reservation_model->get_charge_payments($resdata->res_code);

		if($loan_status == '0')
		{
					$data['resaledata']=$resaledata=$this->lotdata_model->get_resale_by_res_code($resdata->res_code);
					$data['paylist']=$this->common_model->get_resale_payment($resdata->res_code,'Advance');

		}else
		{
				$data['resaledata']=$resaledata=$this->lotdata_model->get_epresale_res_code($resdata->res_code);
				$data['paylist']=$this->common_model->get_resale_payment($resdata->res_code,'Loan');
				$data['loan_data']=$current_advances=$this->reservation_model->get_eploan_data($resdata->res_code);
		}
		$this->load->view('re/lotdata/resale_popup',$data);
	}

	//2020-01-20 update by nadee ticket number 1064
	function view_nic($nic,$type)
	{
		$data['cusdata']=$this->customer_model->get_customer_bycode($nic);
		$data['type']=$type;
		$this->load->view('re/lotdata/customer_nic_print',$data);
	}

	//2020-01-20 updated by nadee
	function get_blocklist_json()
{
	$prj_id = $this->input->post('prj_id');
	$lotlist=$this->lotdata_model->get_project_all_lots_byprjid($prj_id);
	foreach($lotlist as $data){
		echo '<option value="'.$data->lot_number.'">'.$data->plan_sqid.' - '.$data->lot_number.'</option>';
	}

}

	/*Ticket No:2901 Added By Madushan 2021.06.09*/
	function updateDeedTransfer(){
		$checkedVal = $this->input->post('checkedVal');
		$res_code = $this->input->post('res_code');
		$this->reservation_model->updateDeedTransfer($res_code,$checkedVal);
	}

	

	
/*Ticket No:3291 Added By Madushan 2021.08.15*/
function import_blockout()
{	
	if ( ! check_access('add_lotdata'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/lotdata/showall/');
			return;
		}

	$sqid=$this->lotdata_model->add_blockoutplan_upload('');
	$prj_id= $this->input->post('prj_id_upload');

	if(isset($_FILES['block_file']['name']))
	{	
		$config['upload_path'] = './uploads/blockout_plan/';
		if ( ! file_exists($config['upload_path']) )
		{
			$create = mkdir($config['upload_path'], 0777);

		}
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if($this->upload->do_upload('block_file')){
			$path = $_FILES["block_file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();

				for($row = 2; $row<=$highestRow; $row++)
				{
					$lot_number = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
					$lot_extent = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
					$perch_price = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
					$sales_price = $worksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue();
					
					//echo $sales_price.'<br>';

					$this->lotdata_model->add_lotdata($prj_id,$sqid,$lot_number,$lot_extent,$perch_price,$sales_price);
				}

			}

			$details=$this->project_model->get_project_bycode($prj_id);
			if($details->price_status=='PENDING')
			$this->common_model->add_notification('re_prjaclotdata','Price List','re/lotdata/showall/',$prj_id);

			$this->lotdata_model->cost_adjustment($prj_id);
			$this->common_model->delete_activflag('re_prjacblockplane',$this->input->post('prj_id'),'prj_id');
			$this->session->set_flashdata('msg', 'Project Lot Details Successfully Uploded ');
			$this->logger->write_message("success", $prj_id.' Project Lot Successfully Uploded');
			redirect('re/lotdata/showall/');
		}
		else
		{
			$this->session->set_flashdata('error', 'File not imported please try again');
			redirect('re/lotdata/showall/');
		}
		


	}
	else
	{
		$this->session->set_flashdata('error', 'Select file to import and try again');
			redirect('re/lotdata/showall/');
	}
}


	function delete_blockout()
	{
		$prj_id = $this->uri->segment(4);
		$this->lotdata_model->delete_blockout($prj_id);
		$this->session->set_flashdata('msg', 'Block out plan deleted');
			redirect('re/lotdata/showall/');
	}
	

	/*End Of Ticket No:3291*/

function soldout()
	{
		if ( ! check_access('update_sellingstatus'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/lotdata/showall');
			return;
		}
		$prj_id = $this->uri->segment(4);
		$this->project_model->update_sales_completion($prj_id);
		$this->session->set_flashdata('msg', 'Update Project Selling Status as complete');
			redirect('re/lotdata/showall/');
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
