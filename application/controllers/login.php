<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
    	parent::__construct();
    	$this->load->model("login_model"); //load event model
    	$this->load->model("common_model");
		$this->load->model("message_model");
			$this->load->model("accesshelper_model");
		$this->load->model("user/user_model");
  	}

  	public function index(){
		$data = array(
            	'widget' => $this->recaptcha->getWidget(),
            	'script' => $this->recaptcha->getScriptTag(),
				'main_content' => 'login/main_page',
				'msgu' => ''
        	);
			$data['company_code']=$this->uri->segment(3);
			$dataset=$this->login_model->validate_company($this->uri->segment(3));
			$data['logo']=NULL;
			if($dataset)
			{
				$data['logo']=$dataset->company_logo;
		//	if($this->message_model->is_generate_di(date('Y-m-d'))){
			//$this->message_model->generate_today_delaint(date('Y-m-d'));
			//}
			$this->load->view('login', $data);
			}
	}

	public function getResponse($str){

		$response = $this->recaptcha->verifyResponse($str);
		if ($response['success'])
		{
			return true;
        }
        else
        {
			$this->form_validation->set_message('getResponse', '%s '. var_dump($response) );
			return false;
        }
    }
	function login_initialte()
	{
		$companycode=$this->input->post('companycode');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$dataset=$this->login_model->validate_company($companycode);
		//echo $companycode;
		if($dataset){
			
			if($dataset->Active_flag==1)
			{
			$session = array('username'=>$username, 'password'=>$password, 'companycode'=>$companycode);
									$this->session->set_userdata($session);
									redirect('login/login_check');
			}
			else
			{
				$this->session->set_flashdata('error',"Your company account not activated . Please contact solution Provider");
									redirect('login');
			}
		}
		else
		{
			$this->session->set_flashdata('error',"Invalid Company Code");
									redirect('login');
		}
	}
  	public function login_check(){
    				
		
		$username=$this->session->userdata('username');
		$password=$this->session->userdata('password');
		
		
		
					if($username != ''){
					if($this->login_model->validate_username($username)){//if valid username check for password
						// echo "ssss";
						//Ticket No-2502 | Added By Uvini
						$displayname = $this->login_model->getdisplayname($username);
						foreach($displayname as $row)
						{
							$displayname =  $row['display_name'];
							if($displayname == ""){
								$displayname = $row['initial'].' '.$row['surname']; //Ticket No-2502 | Added By Uvini
							}

						}
						if($password != ''){
							$dataquery = $this->login_model->validate_password($password); //valid for password
							$count = 0;
					/*					echo  $password;
					echo $this->db->last_query();
					print_r($dataquery);
					exit;*/
							$count = count($dataquery);
							if($count>0){//if login success redirect to alert page
								foreach($dataquery as $row){
									$usertype = $row->USRTYPE;
									$username = $row->USRNAME;
									$userid = $row->USRID;
									$usermodule = $row->module;
									$branchid = $row->BRNCODE;
									$branchname = $row->branch_name;
									$shortcode = $row->shortcode;
								}

								$validate_user = $this->user_model->validate_user_by_user_name($username);
								if($validate_user['active_flag'] == 0){
									$emp_duty_out_flag_status = $this->user_model->emp_duty_out_flag_status($validate_user['USRID']);
									if(count($emp_duty_out_flag_status)>0){
										$this->session->set_flashdata('error',"You haven't marked Duty Out last day, so your account has been disabled. Please contact the system administrator");
										redirect('login');
									}

									$this->session->set_flashdata('error',"You've entered the wrong password too many times, your account has been disabled. Please contact the system administrator");
									redirect('login');
								}

								$this->user_model->reset_login_attempt_count($userid);
								$financeyear = $this->common_model->get_finance_year();
								$all_branch=false;
								if($this->accesshelper_model->get_controller_1('all_branch',$usertype))
								$all_branch=true;
								if($usermodule)
								$usermodule=$usermodule;
								else
								$usermodule='accounts';
								//echo $usermodule.'ccc';
								//Check for valid  cashier point
								if($usertype == 'user'){
									$cshid = "";
									$this->load->library('session'); //Load session library
									$session = array('username'=>$username, 'usermodule'=>$usermodule, 'usertype'=>$usertype, 'display_name'=>$displayname, 'cshid'=>$cshid, 'userid'=>$userid, 'branchid'=>$branchid, 'branchname'=>$branchname, 'shortcode'=>$shortcode, 'accshortcode'=>'HED', 'accbranchid'=>'0001' ,'fy_start'=>$financeyear->fy_start, 'fy_end'=>$financeyear->fy_end,'all_branch'=>$all_branch);
									$this->session->set_userdata($session); //set session
									redirect(base_url()."home");
								}else{
									$cshid = "";
									$this->load->library('session'); //Load session library
									$session = array('username'=>$username, 'usermodule'=>$usermodule, 'usertype'=>$usertype, 'display_name'=>$displayname, 'userid'=>$userid, 'branchid'=>$branchid, 'branchname'=>$branchname, 'shortcode'=>$shortcode, 'accshortcode'=>'HED', 'accbranchid'=>'0001', 'fy_start'=>$financeyear->fy_start, 'fy_end'=>$financeyear->fy_end,'all_branch'=>$all_branch);
									$this->session->set_userdata($session);

									date_default_timezone_set('Asia/Colombo');
									$user_details = $this->user_model->get_employee_details($userid);


									if(chaeck_pending_settlements_officer($userid,date("Y-m-d"))){

													$this->session->set_flashdata('error',"You Have pending cash advance to settle. please contact finance devision");
													redirect('login');

											}
									if($user_details['status'] != 'D'){
										if($user_details['attendance_type'] == 'S'){
											$emp_attendance_last_record = $this->user_model->emp_attendance_last_record($userid);
											if(count($emp_attendance_last_record)>0){
												if(empty($emp_attendance_last_record['duty_out'])){
													$employee_flag = $this->user_model->employee_flag_for_duty_out($userid, $emp_attendance_last_record['id']);
													$this->session->set_flashdata('error',"You haven't marked Duty Out last day, so your account has been disabled. Please contact the system administrator");
													redirect('login');
												}
											}
											$attendance_details = $this->user_model->get_attendance_details($userid);
											if(!count($attendance_details)>0){
												$this->user_model->mark_employee_duty_in($userid, $username,'','');
											}

										}

										if($user_details['fuel_allowance_status'] == "Y"){
											$last_meter_reading = $this->user_model->get_user_meter_reading_last_record($userid);
											if(count($last_meter_reading)>0){
												if($last_meter_reading['date'] == date('Y-m-d')){
													redirect(base_url()."user");
												}else{
													redirect(base_url()."user/meter_reading");
												}
											}else{
												redirect(base_url()."user/meter_reading");
											}
										}
									}
									//if($usertype=='re_manager')
									//redirect("http://124.43.129.97/winroseaudit/user");
									//else
									redirect(base_url()."user");
								}
							}else{
								$user_name = $this->input->post('username');
								$validate_user = $this->user_model->validate_user_by_user_name($user_name);

								$emp_duty_out_flag_status = $this->user_model->emp_duty_out_flag_status($validate_user['USRID']);
								if(count($emp_duty_out_flag_status)>0){
									$this->session->set_flashdata('error',"You haven't marked Duty Out last day, so your account has been disabled. Please contact the system administrator");
									redirect('login');
								}

								if($validate_user['active_flag'] == 0){
									$this->session->set_flashdata('error',"You've entered the wrong password too many times, your account has been disabled. Please contact the system administrator");
									redirect('login');
								}
								$this->user_model->validate_password_attempts($user_name);
								$this->session->set_flashdata('error',"Incorrect Password");
								redirect('login');
							}
						}else{
							$this->session->set_flashdata('error',"Please enter password");
							redirect('login');
						}
					}else{
						$this->session->set_flashdata('error',"Incorrect username");
						redirect('login');
					}
				}else{
					$this->session->set_flashdata('error',"Please enter username");
					redirect('login');
				}
			//}
		//}else{
			//$this->session->set_userdata('thisusername', $this->input->post('username'));
			//$this->session->set_userdata('password', $this->input->post('password'));
			//$this->session->set_flashdata('error', 'Please check the captcha box!');
			//redirect('login');
		//}
  	}

	function logout(){
		$this->common_model->release_user_activeflag($this->session->userdata('userid'));
		$companycode=$this->session->userdata('companycode');
		$this->session->sess_destroy();
		redirect('login/index/'.$companycode);
	}

	function password_reset() {
    	$data['title'] = "Password Reset";

		$viewData['userid'] = $this->session->userdata('userid');
		$data['searchpath'] = '';

    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('user/password_reset_view', $viewData);
    	$this->load->view('includes/footer');
  	}

  	function submit_password_reset() {
	    $emp_id = $this->input->post('emp_id', TRUE);
		$validate_current_password = $this->user_model->validate_current_password($emp_id);
		$current_password = $this->input->post('current_password', TRUE);
		$current_password = $this->encryption->encode($current_password);
		if($current_password == $validate_current_password['USRPW']){
			$new_password = $this->input->post('new_password', TRUE);
			$confirm_new_password = $this->input->post('confirm_new_password', TRUE);
			if($new_password == $confirm_new_password){
				$this->user_model->reset_password($emp_id);
				$this->session->set_flashdata('msg',"Password reset successfull");
				echo json_encode(['success'=>'<br>Password reset successfull <br>']);
				die();
			}else{
				echo json_encode(['error'=>'<br>Password confirmation is incorrect <br>']);
				die();
			}
		}else{
			echo json_encode(['error'=>'<br>Your current password is incorrect <br>']);
			die();
		}

	}
	function recover(){

		if(!$_POST){
			$data = array(
            	//'widget' => $this->recaptcha->getWidget(),
            	//'script' => $this->recaptcha->getScriptTag(),
				'main_content' => 'login/main_page',
				'msgu' => ''
        	);
			$this->load->view('signinhelp',$data);
		}else{
			/*$recaptcha = $this->input->post('g-recaptcha-response');
			if (!empty($recaptcha)) {
				$response = $this->recaptcha->verifyResponse($recaptcha);
				if (isset($response['success']) and $response['success'] === true) {*/
					$user = $this->login_model->recover();
					//$email = substr($user[0], 0, 3).'****'.substr($user[0], strpos($user[0], "@"));
					//$subject = 'Rainbow Honey | New Password';
					//$reply = 'info@rainbowhoney.net.nz';
					//$message = 'Your new password is <h2>'.$user[1].'</h2>';

					if($user){
						//$this->sendemails($user[0],$subject,$message,$reply);
						$data=array('table_name'=>'cm_passwordreset',
						'notification'=>'Pending Password Reset Request.',
						'branch_code'=>$user->BRNCODE,
						'record_key'=>$user->USRID,
						'create_date'=>date("Y-m-d h:i:s"),
						'module'=>'login/reset_userpassword'
						); //Main Admin's email ***** Required *****
						$insert = $this->db->insert('cm_notification', $data);
						$this->session->set_flashdata('msg', 'Successfully sent a password reset request to Admin');
						redirect('login');
					}else{
						$this->session->set_flashdata('error', 'Unknown username!');
						redirect('login/recover');
					}

			/*	}
			}else{
				$this->session->set_userdata('thisusername', $this->input->post('username'));
				$this->session->set_flashdata('error', 'Please check the captcha box!');
				redirect('login/recover');
			}*/
		}
	}

	function reset_userpassword(){
		if ( ! check_access('view_reset_userpassword'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user/');
			return;
		}
		if(!$_POST){
			$viewData['requests'] =$requests = $this->user_model->get_allpassword_reset_requests();
			if($requests){
				$data['title'] = "User Password Reset";

				$data['searchpath'] = '';

				$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
				$this->load->view('includes/topbar_notsearch');
				$this->load->view('user/reset_user_passwords', $viewData);
				$this->load->view('includes/footer');
			}else{
				$this->session->set_flashdata('error', 'No Pending Requests');
				redirect('user/');
			}
		}else{
			$this->user_model->reset_password($this->input->post('requests'));
			$this->user_model->reset_password_resetrequests($this->input->post('requests'));
			$this->session->set_flashdata('msg', 'Successfully Reset the Password');
			redirect('login/reset_userpassword');
		}
	}

}
