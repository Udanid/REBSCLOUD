<?php
class Letter extends CI_Controller{

	
	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
		$this->load->model('paymentvoucher_model');
		$this->load->model("hr/letter_model");
		$this->load->model("hr/salary_advance_model");
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function salary_confirm_form(){
		$data['employee_list'] = $this->employee_model->get_all_employee_list();
		$data['letter_type'] = $this->letter_model->get_letter_list();
		$this->load->view('includes/header_'.$this->session->userdata('usermodule'));
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/employee/salary_confirm_form', $data);
      	$this->load->view('includes/footer');

	}

	public function create_letter(){
		$employeeMasterID=$this->uri->segment(4);
		$empdetails = $this->employee_model->get_employee_details($employeeMasterID);
		$designation= $this->common_hr_model->get_designation($empdetails["designation"]);
		$salary=$this->salary_advance_model->check_basic_salary($employeeMasterID);


		if($salary){
			$allowances=$this->employee_model->get_employee_allowances_details($employeeMasterID);
			$allowances_total=0;
			if($allowances){
				foreach ($allowances as $row) {
					$allowances_total+=$row->value;
				}
			}

			$title = "";
		   if($empdetails['title']==0){
		    $title = "Mr";
		   }else if($empdetails['title']==1){
		    $title = "Mrs";
		   }else if($empdetails['title']==2){
		    $title = "Ms";
		   }else if($empdetails['title']==3){
		    $title = "Miss";
		   }else if($empdetails['title']==4){
		    $title = "Dr.";
		   }else if($empdetails['title']==5){
		    $title = "Prof.";
		   }else if($empdetails['title']==6){
		    $title = "Rev";
		   }else if($empdetails['title']==7){
		    $title = "Father";
		   }else if($empdetails['title']==8){
		    $title = "Sister";
		   }


		   $html = '<div class="row"  >
		<div  style="padding-left:50px; font-size:15px; width:640px; ">
		   <div style="height: 1.00in;"></div>
		   '.date("F j, Y").',<br><br>
		   '.$title." ".$empdetails['initial']." ".$empdetails['surname'].',<br><br><br>
		    <strong><u>Confirmation Letter </u></strong><br><br>
		    
		    <p>This is to certify that '.$empdetails['initial']." ".$empdetails['surname'].' ('.$empdetails['nic_no'].') is a permanent employee at '.companyname.' and heworking as the '.$designation['designation'].' since '.$salary->effective_from.'. Hispresent emoluments are as follows</p><br><br>

		    Basic Salary 		'.$salary->basic_salary.'<br>
		    Fixed Allowances 		'.$allowances_total.'<br> 
		    Gross salary	'.($salary->basic_salary+$allowances_total).'<br><br>
		    <p>This information is being submitted at the request of  '.$empdetails['initial']." ".$empdetails['surname'].'.</p>
		    Thank You<br>
		    Yours faithfully <br><br><br>
		    .....................<br>
		    Director';



		    $date = date('Y-m-d H-i-s');
		         $filename = $empdetails['emp_no'].'_'.$date.'salary_confirmation.pdf';
		         $pdfroot = "./pdfs/salary_confirmation/".$filename;
		         $fileroot = "pdfs/salary_confirmation/".$filename;

		         //insert letter data ..
		   $data_letter['emp_id']=$empdetails['id'];
		   $data_letter['letter_type']=5;
		   $data_letter['date']=date("Y-m-d");
		   $data_letter['file']=$fileroot;
		   $this->letter_model->insert_letter($data_letter);

		        // Load library
		        $this->load->library('dompdf_gen');
		        // Convert to PDF
		        $this->dompdf->load_html($html);
		        $this->dompdf->render();
		        //$this->dompdf->stream("welcome.pdf");
		        $pdf_string =   $this->dompdf->output();
		        file_put_contents($pdfroot, $pdf_string );
		}
		
		$data['letterslist'] = $this->letter_model->get_letters_by_empno($employeeMasterID);

		$this->load->view('hr/employee/pdf_list', $data);
   		
	}


	public function get_letters_by_empno(){
		$emp_id=$this->uri->segment(4);
		$data['letterslist'] = $this->letter_model->get_letters_by_empno($emp_id);

		$this->load->view('hr/employee/pdf_list', $data);

	}


	public function get_letters_by_type(){
		$letter_type=$this->uri->segment(5);
		$emp_id=$this->uri->segment(4);
		$data['letterslist'] = $this->letter_model->get_letters_by_empno_letter_type($emp_id,$letter_type);

		$this->load->view('hr/employee/pdf_list', $data);
	}
	
}
?>
