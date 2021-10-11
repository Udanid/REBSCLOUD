<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Land extends CI_Controller {

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

		$this->load->model("land_model");
		$this->load->model("common_model");
		$this->load->model("introducer_model");
		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('re/land/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/');
			return;
		}
		$data['searchdata']=$inventory=$this->land_model->get_all_land_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->land_code.'">'.$c->property_name.'-'.$c->district .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/land/search';
				$data['tag']='Search land';
				$data['product_code']='LNS';
				$data['district_list']=$this->common_model->distict_list();
				$data['council_list']=$this->common_model->council_list();
				$data['town_list']=$this->common_model->town_list();
				$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();

				$this->load->library('pagination');

		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */

			$config['base_url'] = site_url('re/land/showall');
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
		$data['datalist']=$this->land_model->get_all_land_details($pagination_counter,$page_count);
		$data['landnames']=$this->land_model->get_all_land_names();
		$config['total_rows'] = $this->db->count_all('re_landms');
			//echo $pagination_counter;
		$this->pagination->initialize($config);
		$data['tab']='';
			if($page_count)
						$data['tab']='list';
		//$data['datalist']=$inventory;

			//echo $pagination_counter;

	$this->load->view('re/land/land_data',$data);



	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/');
			return;
		}
		$data['details']=$this->land_model->get_land_bycode($this->uri->segment(4));
		$data['product_code']='LNS';
				$data['district_list']=$this->common_model->distict_list();
				$data['council_list']=$this->common_model->council_list();
				$data['town_list']=$this->common_model->town_list();
				$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$this->load->view('re/land/search',$data);

	}


	public function add()
	{
		if ( ! check_access('add_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}		$file_name="";
				$config['upload_path'] = 'uploads/land/documents/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
                $config['max_size'] = '3500';

                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('plan_copy');
            	$error = $this->upload->display_errors();

            	$image_data = $this->upload->data();
				$plan_copy="";$deed_copy ="";
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
            	$plan_copy = $image_data['file_name'];
				else
				$this->session->set_flashdata('error',  $error );

				$this->upload->do_upload('deed_copy');
            	$error = $this->upload->display_errors();

            	$image_data = $this->upload->data();
				if($error=="")
            	$deed_copy = $image_data['file_name'];
				else
				$this->session->set_flashdata('error',  $error );
		$id=$this->land_model->add($plan_copy,$deed_copy);
	//	print_r($_POST);
		//print_r($_FILES);
		$this->land_model->add_owners($id, $this->input->post('owner_name'),$this->input->post('owner_address'),$this->input->post('owner_nic'));
		$this->land_model->add_documents($id,$this->input->post('plan_no'),$this->input->post('deed_no'),$this->input->post('drawn_by'),$this->input->post('drawn_date'),$this->input->post('attest_by'),$this->input->post('attest_date'),$plan_copy,$deed_copy);
		for($i=1; $i<=4; $i++)
		{
			if(isset($_POST['ordinary_level'][$i]))
			{
			$name= $_POST['ordinary_level'][$i]['name'];
			$address= $_POST['ordinary_level'][$i]['address'];
			$nic=$_POST['ordinary_level'][$i]['nic'];
			if($name!="")
				$this->land_model->add_owners($id,$name,$address,$nic);

			//print_r($_POST['ordinary_level'][$i]);
			}
			if(isset($_POST['advance_level'][$i]))
			{
			$plan_no= $_POST['advance_level'][$i]['plan_no'];
			$deed_no= $_POST['advance_level'][$i]['deed_no'];
			$drawn_by= $_POST['advance_level'][$i]['drawn_by'];
			$drawn_date= $_POST['advance_level'][$i]['drawn_date'];
			$attest_by= $_POST['advance_level'][$i]['attest_by'];
			$attest_date= $_POST['advance_level'][$i]['attest_date'];
			if($plan_no!=""){
				//echo $i;
				$this->upload->do_upload('plan_copy'.$i);
            	$error = $this->upload->display_errors();
				$image_data = $this->upload->data();
				$plan_copy="";$deed_copy ="";
			//echo $error;
            	if($error=="")
            	$plan_copy = $image_data['file_name'];
				$this->upload->do_upload('deed_copy'.$i);
            	$error = $this->upload->display_errors();
				$image_data = $this->upload->data();
				if($error=="")
            	$deed_copy =$image_data['file_name'];
				$this->land_model->add_documents($id,$plan_no,$deed_no,$drawn_by,$drawn_date,$attest_by,$attest_date,$plan_copy,$deed_copy );



			}
			//print_r($_POST['ordinary_level'][$i]);
			}
			//if($name!="")
				//
		}
		$this->common_model->add_notification('re_landms','lands','re/land',$id);
		$this->session->set_flashdata('msg', 'Land land Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/land/showall");

	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}
		$data['details']=$this->land_model->get_land_bycode($this->uri->segment(4));
		$data['owners']=$this->land_model->get_land_owners($this->uri->segment(4));
		$data['docs']=$this->land_model->get_land_documents($this->uri->segment(4));
		$data['product_code']='LNS';
				$data['district_list']=$this->common_model->distict_list();
				$data['council_list']=$this->common_model->council_list();
				$data['town_list']=$this->common_model->town_list();
				$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$this->common_model->add_activeflag('re_landms',$this->uri->segment(4),'land_code');
		$data['landnames']=$this->land_model->get_all_land_names();
		$session = array('activtable'=>'re_landms');
		$this->session->set_userdata($session);
		$this->load->view('re/land/edit',$data);

	}
	function comments()
	{
		$data=NULL;
		if ( ! check_access('view_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}
		$data['details']=$this->land_model->get_land_bycode($this->uri->segment(4));
		$data['comments']=$this->land_model->get_land_comments($this->uri->segment(4));

		$this->load->view('re/land/comments',$data);

	}
	function commetnadd()
	{
		if ( ! check_access('view_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}
		$id=$this->land_model->commetnadd();
		redirect('re/land/showall');
	}
	function editdata()
	{
		if ( ! check_access('edit_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');

			return;
		}
		$file_name="";
				$file_name="";
				$config['upload_path'] = 'uploads/land/documents/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '300';

                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('plan_copy');
            	$error = $this->upload->display_errors();

            	$image_data = $this->upload->data();
				$plan_copy="";$deed_copy ="";
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
            	$plan_copy = $image_data['file_name'];
				else
				$plan_copy=$this->input->post('plan');

				$this->upload->do_upload('deed_copy');
            	$error = $this->upload->display_errors();

            	$image_data = $this->upload->data();
				if($error=="")
            	$deed_copy = $image_data['file_name'];
				else
				$deed_copy=$this->input->post('deed');

			$id=$this->land_model->edit($plan_copy,$deed_copy);
			$id=$this->input->post('land_code');
			$this->land_model->delete_owners($id);
			for($i=1; $i<=10; $i++)
			{
			$name= $this->input->post('owner_name'.$i);
			$address= $this->input->post('address'.$i);
			$nic=$this->input->post('nic'.$i);
			if($name!="")
				$this->land_model->add_owners($id,$name,$address,$nic);

			//print_r($_POST['ordinary_level'][$i]);

		}

		$this->session->set_flashdata('msg', 'land Details Successfully Updated ');

		$this->common_model->delete_activflag('re_landms',$this->input->post('land_code'),'land_code');
		$this->logger->write_message("success", $this->input->post('land_code').' land Details successfully Updated');
		redirect("re/land/showall");

	}

	public function confirm()
	{
		if ( ! check_access('confirm_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}
		$id=$this->land_model->confirm($this->uri->segment(4));

		$this->common_model->delete_notification('re_landms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'land Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  land id successfully Confirmed');
		redirect("re/land/showall");

	}
		public function delete()
	{
		if ( ! check_access('delete_land'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}
		$id=$this->land_model->delete($this->uri->segment(4));

		$this->common_model->delete_notification('re_landms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'land Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' land id successfully Deleted');
		redirect("re/land/showall");

	}
	public function view()
{
		$data=NULL;
	if ( ! check_access('view_land'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('re/land/showall');
		return;
	}
	$data['details']=$this->land_model->get_land_bycode($this->uri->segment(4));
	$data['owners']=$this->land_model->get_land_owners($this->uri->segment(4));
	$data['docs']=$this->land_model->get_land_documents($this->uri->segment(4));
	$data['product_code']='LNS';
			$data['district_list']=$this->common_model->distict_list();
			$data['council_list']=$this->common_model->council_list();
			$data['town_list']=$this->common_model->town_list();
			$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
	$this->common_model->add_activeflag('re_landms',$this->uri->segment(4),'land_code');

	$session = array('activtable'=>'re_landms');
	$this->session->set_userdata($session);
	$this->load->view('re/land/view',$data);

}
	function get_postal_code(){
		$postal_code = $this->common_model->get_postal_code();
		echo $postal_code;
	}

	//Ticket No:2689 Added By Madushan 2021.04.20
	function seach_land_data(){
		$land_code = $this->uri->segment(4);
		$data['datalist']=$this->land_model->get_all_land_details_search($land_code);
		$this->load->view('re/land/land_data_search',$data);
	}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
