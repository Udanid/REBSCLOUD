<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cus_hand_overdocs extends CI_Controller {

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
		$this->load->model("project_model");
		$this->load->model("document_model");
		$this->load->model("lotdata_model");
		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/home');
			return;
		}
		redirect('re/cus_hand_overdocs/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/cus_hand_overdocs/');
			return;
		}
			$data['prjlist']=$this->project_model->get_all_project_confirmed(150,0,$this->session->userdata('branchid'));
			$data['deedlist']="";
				$courseSelectList="";
					$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customerletter/search';
				$data['tag']='Search Customer letter';

				$this->load->view('re/customer_docs/customer_docs_main',$data);

	}
	function get_blocklist()
	{
		$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('re/customer_docs/blocklist',$data);

	}
	function get_reslist()
	{

		$data['cuslist']=$cuslist=$this->document_model->get_customer_all_bylotid($this->uri->segment(4));
		//print_r($cuslist);
		$this->load->view('re/customer_docs/customerlist',$data);

	}

	function get_docsfulldata()
	{

		$id=$this->uri->segment(4);
		$lot_id=$this->uri->segment(5);
		$prj_id=$this->uri->segment(6);

		$submitted_doc_list=Null;
		$data['doctypes']=$doctypes=$this->document_model->get_document_bycategory('CUSTOMER HAND OVER DOC');
		foreach ($doctypes as $key => $value) {
			$submitted_doc_list[$value->doctype_id]=$this->document_model->get_customer_handoverdocuments($prj_id,$lot_id,$id,$value->doctype_id);
		}
		$data['submitted_doc_list']=$submitted_doc_list;
		$this->load->view('re/customer_docs/customer_docs_upload',$data);


	}

	public function add()
	{

		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/cus_hand_overdocs/showall');
			return;
		}
			$uoloaderro="";
	//$id=2;
		$file_name="";
				$config['upload_path'] = 'uploads/customer_docs/';
								$config['allowed_types'] = 'gif|jpg|png|pdf';
								$config['max_size'] = '30000';

								$this->load->library('image_lib');
								$this->load->library('upload', $config);
			$doctypes=$this->document_model->get_document_bycategory('CUSTOMER HAND OVER DOC');

			foreach($doctypes as $docraw)
			{
				if($_FILES['document'.$docraw->doctype_id]['name']){
				$error="";
				$this->upload->do_upload('document'.$docraw->doctype_id);
							$error = $this->upload->display_errors();
				//echo $error;
				if($error==""){
					$image_data = $this->upload->data();
					$filename=$image_data['file_name'];
					$this->document_model->add_cusdocuments($docraw->doctype_id,$filename);

				}
				else
				$uoloaderro=$uoloaderro.$docraw->document_name.' Not Uploaded<br>';
			}
		}


		$this->session->set_flashdata('msg', ' Successfully Inserted ');
		$this->session->set_flashdata('error', $uoloaderro);
		$this->logger->write_message("success", ' successfully Inserted');
		redirect("re/cus_hand_overdocs/showall");

	}

	function delete()
	{
		if ( ! check_access('delete_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/cus_hand_overdocs/showall');
			return;
		}
		$id=$this->document_model->cus_hand_overdocsdelete($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'customer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' customer id successfully Deleted');
		redirect("re/cus_hand_overdocs/showall");

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
