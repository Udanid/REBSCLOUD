<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
		$this->load->helper("url");
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
		redirect('cm/customer/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->customer_model->get_all_customer_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->cus_code.'">'.strtoupper($c->first_name) .' '.strtoupper($c->last_name) .' '.$c->id_number .' '.$c->mobile.' '.$c->cus_number.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='cm/customer/edit';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->customer_model->get_all_customer_details($pagination_counter,$page_count);
				$siteurl='cm/customer/showall';
				$tablename='cm_customerms';
				$data['tab']='';
				
					if($page_count)
						$data['tab']='list';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('cm/customer/customer_data',$data);
		
		
		
	}
	public function excel_cusdata()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->customer_model->get_all_customer_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->cus_code.'">'.$c->first_name .' '.$c->last_name .' '.$c->id_number .' - '.$c->mobile.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='cm/customer/edit';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->customer_model->get_all_customer_details_excel();
				$siteurl='cm/customer/showall';
				$tablename='cm_customerms';
				$data['tab']='';
				
					if($page_count)
						$data['tab']='list';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('cm/customer/customer_excel',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/');
			return;
		}
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$this->load->view('cm/customer/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}		
		
		
		$id=$this->customer_model->add();
		
		$this->common_model->add_notification('cm_customerms','customers','cm/customer',$id);
		$this->session->set_flashdata('msg', 'Successfully Created the Customer');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("cm/customer/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		$data['details']= $customer =$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('cm_customerms',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'cm_customerms');
		$this->session->set_userdata($session);
		
		if ($customer->cus_type=='individual'){
			$this->load->view('cm/customer/edit_individual',$data);
		}else if($customer->cus_type=='business'){
			$this->load->view('cm/customer/edit_business',$data);
		}
		
	}
	
	function view(){
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		$data['details']= $customer =$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		if ($customer->cus_type=='individual'){
			$this->load->view('cm/customer/view_individual',$data);
		}else if($customer->cus_type=='business'){
			$this->load->view('cm/customer/view_business',$data);
		}
	}
	
	function editdata()
	{
		if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			
			return;
		}
		
		//check whether there are any pending critical updates
		$pending = $this->customer_model->checkPendingcritical($this->input->post('cus_code'));
		if($pending){
		
			$this->session->set_flashdata('error', 'Please Approve Pending Critical Updates');
		
			$this->common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
			$this->logger->write_message("success", $this->input->post('cus_code').' Please Approve Pending Critical Updates');
			redirect("cm/customer/showall");
			
		}else{
			
			$id=$this->customer_model->edit();
		
			if($id)
			{
				$this->session->set_flashdata('error', 'Critical Details Have Not Updated. Sent for Approval');
				$this->session->set_flashdata('msg', 'Non Critical Customer Details Successfully Updated');
			
			}
			else
			{
				$this->session->set_flashdata('msg', 'Customer Details Successfully Updated');
			}
			
			
		
			$this->common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
			$this->logger->write_message("success", $this->input->post('cus_code').' Customer Details Successfully Updated');
			redirect("cm/customer/showall");
		}
	}
	public function edit_loan()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('cm_customerms',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'cm_customerms');
		$this->session->set_userdata($session);
		$this->load->view('re/reservation/loan_customer',$data);
		
	}
	function editdata_loan()
	{
		if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			
			return;
		}
		$file_name="";
				
		$id=$this->customer_model->edit_loan($file_name);
		
		
		$this->session->set_flashdata('msg', 'customer Details Successfully Updated ');
		
		$this->common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('cus_code').' customer Details successfully Updated');
		redirect("re/reservation/eploans");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		$id=$this->customer_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Successfully Confirmed the Customer');
		$this->logger->write_message("success", $this->uri->segment(4).'  customer id successfully Confirmed');
		redirect("cm/customer/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		$id=$this->customer_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Successfully Deleted the Customer');
		$this->logger->write_message("success", $this->uri->segment(4).' customer id successfully Deleted');
		redirect("cm/customer/showall");
		
	}
	
	public function deleteImage(){
		
		if ( ! check_access('delete_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		$files = array(
			'uploads/customer_ids/'.$this->input->post('image'),
			'uploads/customer_ids/thumbnail/'.$this->input->post('image')
		);
		
		foreach ($files as $file) {
		  if (file_exists($file)) {
			  unlink($file);
			  echo 'Image has been deleted successfully';
		  } else {
			  // File not found.
		  }
		}

	}
	
	function pendingApprovals(){
		if ( ! check_access('view_customerchanges'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/showall');
			return;
		}
		
		/* Pagination setup */
		$this->load->library('pagination');
		
		/*Pagination config*/
		$config['base_url'] = site_url('cm/customer/pendingApprovals');
		$config['uri_segment'] = 5;
		$config['total_rows'] = $this->customer_model->count_all_pendings();
		
		$pagination_counter = $this->config->item('row_count');
		$config['num_links'] = 10;
		$config['per_page'] = 20;
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
		/*end pagination config*/
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$data['pendings'] = $pending =$this->customer_model->get_pendings($config['per_page'],$page);
		
		$data['searchpath']='cm/customer';
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();
		$this->load->view('cm/customer/view_pendings',$data);
		
				
	}
	
	function cancel_changes(){
		
		if ( ! check_access('approve_customerchanges'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('cm/customer/pendingApprovals');
			return;
		}
		
		$this->customer_model->cancel_changes($this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Successfully Cancelled the Changes');
		redirect('cm/customer/pendingApprovals');
		
	}
	
	function approve_changes(){
		
		$data['pendings'] = $this->customer_model->get_pendingsbycustomer($this->uri->segment(4));
		$data['customer'] = $this->customer_model->get_customer_bycode($this->uri->segment(4));
		$this->load->view('cm/customer/get_pendings',$data);
			
	}
	
	function approve_all(){
		$this->customer_model->approve_all($this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Successfully Approved the Changes');
		redirect('cm/customer/pendingApprovals');
	}
	
	function getCustomerbyID(){
		/*Ticket no:2841 Updated by Madushan 2021.05.17*/
		$summary = $this->customer_model->get_customer_bycode($this->input->post('cus_code'));
		echo '<table class="table"> <thead> <tr> <th>Customer Code</th><th>Customer Number</th> <th>Customer Type</th><th>Name</th> <th>Mobile </th><th>Land Phone </th><th>Work Phone </th> <th>E mail</th> <th>Status</th><th></th></tr> </thead>';
		echo '<tbody> <tr> 
				<th>'.$summary->cus_code.'</th> <td>'.$summary->cus_number.'</td><td>'.ucfirst($summary->cus_type).'</td><td>'.strtoupper($summary->first_name).' '.strtoupper($summary->last_name).'</td> <td>'.$summary->mobile.'</td><td>'.$summary->landphone.'</td><td>'.$summary->workphone.'</td>
			<td>'.$summary->email.'</td> 
			<td>'.$summary->status.'</td>
			<td align="right"><div id="checherflag">';
			if(! check_access('all_branch')){ 
					if($summary->cus_branch==$this->session->userdata('branchid')){
						echo '<a  href="javascript:check_activeflag('.$summary->cus_code.')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>';
							if($summary->status=='PENDING'){
							  echo '<a  href="javascript:call_confirm('.$summary->cus_code.')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>';
							  echo '<a  href="javascript:call_delete('.$summary->cus_code.')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>';
					   		}
					}else{
						echo '<a  href="javascript:viewCustomer('.$summary->cus_code.')" title="View"><i class="fa fa-eye nav_icon icon_green"></i></a>';
					}
			}else{
					echo '<a  href="javascript:viewCustomer('.$summary->cus_code.')" title="View"><i class="fa fa-eye nav_icon icon_green"></i></a>';
					echo '<a  href="javascript:check_activeflag('.$summary->cus_code.')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>';
					if($summary->status=='PENDING'){
						 echo '<a  href="javascript:call_confirm('.$summary->cus_code.')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>';
						 echo '<a  href="javascript:call_delete('.$summary->cus_code.')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>';
				   }
			}
			echo '</div></td>
			 </tr> ';
			echo '</tbody></table>';
	}
	
	function deleteDoc(){
		$doc = 	$this->input->post('doc');
		$field = $this->input->post('field');
		$cus_code = $this->input->post('cus_code');

		//delete files
		$files = array(
			'uploads/customer_ids/thumbnail/'.$doc,
			'uploads/customer_ids/'.$doc
		);
		
		foreach ($files as $file) {
		  if (file_exists($file)) {
			  unlink($file);
			  //echo 'Image has been deleted successfully';
		  } else {
			  // File not found.
		  }
		}
		//update database
		$result = $this->customer_model->deleteDoc($field,$cus_code);
		return $result;
	}
	
	function webcam_image(){
		$img = $this->input->post('webcam_image');
		$folderPath = "uploads/temp/";
		$thumb_path = "uploads/temp/thumbnail/";
	  
		$image_parts = explode(";base64,", $img);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
	  
		$image_base64 = base64_decode($image_parts[1]);
		$fileName = $this->generateRandomName() . '.jpg';
	  
		$file = $folderPath . $fileName;
		file_put_contents($file, $image_base64);
		
		//creat thumbnail
		$thumbnail = $thumb_path.$fileName;
		$upload_image = $file;
		$thumb_width = '96';
		$thumb_height = '96';
		list($width,$height) = getimagesize($upload_image);
		$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
		$source = imagecreatefromjpeg($upload_image);
		imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
		imagejpeg($thumb_create,$thumbnail,100);
		echo $fileName;
	}
	
	function generateThumbnail($img, $width, $height, $quality = 90)
	{
		if (is_file($img)) {
			$imagick = new Imagick(realpath($img));
			$imagick->setImageFormat('jpeg');
			$imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
			$imagick->setImageCompressionQuality($quality);
			$imagick->thumbnailImage($width, $height, false, false);
			$filename_no_ext = reset(explode('.', $img));
			if (file_put_contents($filename_no_ext . '_thumb' . '.jpg', $imagick) === false) {
				throw new Exception("Could not put contents.");
			}
			return true;
		}
		else {
			throw new Exception("No valid image provided with {$img}.");
		}
	}
	
	function generateRandomName($length = 15) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	function check_id_number(){
		$id_number = $this->input->post('id_number');	
		$id_type = $this->input->post('id_type');
		if($this->customer_model->check_id_number($id_type,$id_number)){
			echo 'Existing Customer';
		}
	}
	
	/*function split_name(){
		$this->db->select('cus_code,first_name');	
		$query = $this->db->get('cm_customerms'); 
		foreach ($query->result() as $data){
			$str= preg_replace('/\W\w+\s*(\W*)$/', '$1', $data->first_name);
			$data2 = array(
				'first_name' => $str
			);
			$this->db->where('cus_code',$data->cus_code);
			$this->db->update('cm_customerms',$data2);
			$pieces = explode(' ', $data->first_name);
			$last_word = array_pop($pieces);
			$data3 = array(
				'last_name' => $last_word
			);
			$this->db->where('cus_code',$data->cus_code);
			$this->db->update('cm_customerms',$data3);
		}
	}*/

	//2019-10-23 Ticket 807 B.K.Dissanayake
	function updateMetOfficer(){
		$checkedVal=$this->input->post('checkedVal');
		$cus_id=$this->input->post('cus_id');
		$this->customer_model->updateMetOfficer($cus_id,$checkedVal);
	}


	// created by terance perera 2020-3-6 call sheet
	function get_call_sheet_all(){
		$data['callsheets']=NULL;
		//if(isset($_POST['search']))
		//{
			$prj_id='ALL';
			if($this->input->post('prj_id'))
           $prj_id = $this->input->post('prj_id');
           $pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				//$data['datalist']=$this->customer_model->get_all_customer_details($pagination_counter,$page_count);
				$data['projectlist'] = $this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['callsheets'] = $this->customer_model->get_call_sheets($prj_id,$pagination_counter,$page_count);
				$siteurl='cm/customer/get_call_sheet_all';
				$tablename='re_call_sheet';
				$data['tab']='';
				
					if($page_count)
						$data['tab']='list';
				$this->pagination($page_count,$siteurl,$tablename);
           
           $this->load->view('cm/customer/call_sheet_list_view',$data);
		//}
		//else{
	//	   $this->load->view('cm/customer/call_sheet_list_view',$data);
		//}
    }

	
    function view_related_remark(){
    	$callsheetid = $this->uri->segment(4);
    	$data['remark'] = $this->customer_model->get_remarks($callsheetid);
		$data['loanfollow'] = $this->customer_model->get_callsheetfollowlist($callsheetid);
    	$this->load->view('cm/customer/call_sheet_remark_view',$data);
    }
	function callsheetfollowups()
	{
		$callsheetid = $this->uri->segment(4);
		$data['details'] = $this->customer_model->get_remarks($callsheetid);
		$data['loanfollow'] = $this->customer_model->get_callsheetfollowlist($callsheetid);
		
    	$this->load->view('cm/customer/callsheetfollowups_popup',$data);
	}
	function add_callhefollowups()
	{
		$this->customer_model->add_followups();
		$this->session->set_flashdata('msg', 'Successfully add');
		redirect('cm/customer/get_call_sheet_all');
		
	}
	function print_callsheet(){
    	$callsheetid = $this->uri->segment(4);
    	$data['remark'] = $this->customer_model->get_remarks($callsheetid);
		$data['loanfollow'] = $this->customer_model->get_callsheetfollowlist($callsheetid);
    	$this->load->view('cm/customer/print_callsheet',$data);
    }
	function delete_callsheet()
	{
		$callsheetid = $this->uri->segment(4);
		$this->customer_model->delete_callsheet($callsheetid);
		$this->session->set_flashdata('msg', 'Successfully deleted');
		redirect('cm/customer/get_call_sheet_all');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */