<?php ob_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class andr_manager extends CI_Controller {

function __construct() {
	//date_default_timezone_set('Asia/Colombo');
	//	header('Content-type/:application/json');
	//	header('content-type text/html charset=utf-8');
        parent::__construct();
		$this->load->model("andr_manager_model"); //load event model
    $this->load->model("user/user_model");
    $this->load->model("message_model");
    $this->load->model("common_model");
    $this->load->model("eploan_model");
    $this->load->model("cashadvance_model");
    }

	public function index()
	{

    $user_name = $_GET['user_name'];
    $password =  $_GET['password'];
    $emi_no = "";
    $meta = $_GET['meta'];


//------------------------
$query = $this->andr_manager_model->index($user_name,$password,$emi_no,$meta);


if(count($query->result()) > 0){


$json = array();
			foreach ($query->result() as $row){
							$usertype = $row->USRTYPE;
							$username = $row->USRNAME;
							$userid = $row->USRID;
							$usermodule = $row->module;
							$branchid = $row->BRNCODE;
							$branchname = $row->branch_name;
							$shortcode = $row->shortcode;
							$andflg = $row->AND_FLG;
							$json['userid'] = $userid;
							$json['username'] = $username;
							$json['allow'] = $andflg;

							if($andflg != 0){
                            $json['message'] = 'Success';
							}else{
                            $json['message'] = 'Not allowed';
							}

						}




echo json_encode(array('status'=>true,'data'=>$json));
}else{
	$false = array();
	$false['message'] = 'Invalid User';
    echo json_encode(array('status'=>false,'data'=>$false));
}






//------------------------------



 //------------------------------------------------------------------



	}



	public function getbalanceEnquery(){

     $type = $_GET['type'];
     $search = "";
       if($type == 'nic'){

       	$search = $_GET['nic'];
}else if($type == 'phn'){
		$search = $_GET['mobile'];
}




         $query = $this->andr_manager_model->getbalanceEnquery($type,$search);
         if(count($query->result()) > 0){


         $json = array();
         $jsonloan = array();


			foreach ($query->result() as $row){
				$instalment= array();
						    $instalment['installment'] = 0;

							$json['name'] = $row->title.' '.$row->first_name.' '.$row->last_name;
							$json['nic'] = $row->id_number;
							$json['mobile'] = $row->mobile;

                            $jsonloan['paid']['noInstalment'] = $row->paid_ins;
                             $jsonloan['paid']['totalValue'] = $row->paid_tot;


                            $jsonloan['areas']['noInstalment'] =$row->areas_ins;
                            $jsonloan['areas']['totalValue'] = $row->areas_tot;


                            $jsonloan['due']['noInstalment'] =$row->due_ins;
                            $jsonloan['due']['totalValue'] =$row->due_tot;
                            $json['balanceEnquery'] = $jsonloan;


						}




echo json_encode(array('status'=>true,'data'=>$json));

}else{
	echo json_encode(array('status'=>true,'data'=>'no'));
}




//
		// $query = $this->andr_manager_model->tests();
		// echo count($query->result());
	}


	//new

	public function getbalanceEnquery_new(){
 $type = $_GET['type'];
     $search = "";
       if($type == 'nic'){

       	$search = $_GET['nic'];
}else if($type == 'phn'){
		$search = $_GET['mobile'];
}




         $query = $this->andr_manager_model->getbalanceEnquery_new($type,$search);
         if(count($query->result()) > 0){




       $instalment= array();
				$jsonloan = array();
				$json = array();
                $loans =array();

                $main_arr = array();
			foreach ($query->result() as $row){


						    $instalment['installment'] = 0;

							$json['name'] = $row->title.' '.$row->first_name.' '.$row->last_name;
							$json['nic'] = $row->id_number;
							$json['mobile'] = $row->mobile;
              //$json['mobile'] = get_loan_date_di($row->loan_id,date('Y-m-d'));
              $json['di'] = get_loan_date_di($row->loan_id,date('Y-m-d'));
                            $loans['info'] = $json;



        $lns = array();                    //
foreach ($query->result() as $row1){

$ss = array();
$jsonloan1 = array();

// $ss['balanceEnquery'] =
$paid=$this->andr_manager_model->get_paid_details($row1->loan_code);
$arrears=$this->andr_manager_model->get_arrars_details($row1->loan_code);
$balance=$this->andr_manager_model->get_balance_details($row1->loan_code);
                            $jsonloan1['paid']['noInstalment'] =$paid[1];// $row1->paid_ins;
                            $jsonloan1['paid']['totalValue'] = $paid[0];// $row1->paid_tot;


                            $jsonloan1['areas']['noInstalment'] =$arrears[1];// $row1->areas_ins;
                            $jsonloan1['areas']['totalValue'] = $arrears[0];// $row1->areas_tot;


                            $jsonloan1['due']['noInstalment'] =$balance[1];// $row1->due_ins;
                            $jsonloan1['due']['totalValue'] =$balance[0];// $row1->due_tot;

							// $jsonloan1['paid']['noInstalment'] =$row1->paid_ins;
                           // $jsonloan1['paid']['totalValue'] =  $row1->paid_tot;


                           // $jsonloan1['areas']['noInstalment'] = $row1->areas_ins;
                           // $jsonloan1['areas']['totalValue'] =  $row1->areas_tot;


                           // $jsonloan1['due']['noInstalment'] = $row1->due_ins;
                           //$jsonloan1['due']['totalValue'] = $row1->due_tot;

// $ss['loan']=  $jsonloan1;
$ss['loan_code']= $row1->loan_code;
$ss['balanceEnquery']=  $jsonloan1;



$lns[] =$ss;
}

$loans['loans'] = $lns;
                            //




						}




echo json_encode(array('status'=>true,'data'=>$loans));

}else{
	echo json_encode(array('status'=>true,'data'=>'no'));
}




//
		// $query = $this->andr_manager_model->tests();
		// echo count($query->result());

}

public function updateLoanPayment(){
$loanId = $_GET['loan_id'];
//reservation code
//advaced payment or
$nic = $_GET['nic'];
$paytype = $_GET['pay_type'];
$amt = $_GET['amount'];
$timestamp = $_GET['timestamp'];
$user_name = $_GET['user_name'];
$location = $_GET['location'];
$cheque_number = $_GET['cheque_number'];
$bill_num = $_GET['bill_num'];



         if(isset($loanId) && $bill_num!=''){

           $query = $this->andr_manager_model->updateLoanPayment($loanId,$nic,$paytype,$amt,$timestamp,$user_name,$location,$cheque_number,$bill_num);

          if($query){

  	           echo json_encode(array('status'=>true,'message'=>$query,'img_related_id'=>$query));

            }else{
  	           echo json_encode(array('status'=>true,'data'=>'no','img_related_id'=>''));
            }

         }else{
         	echo json_encode(array('status'=>false,'message'=>'Please Add TR/Bill Number','img_related_id'=>''));
         }


	}


	public function gettempdata(){

		$main_arr = array();
	$query = $this->andr_manager_model->gettempdata();


foreach ($query->result() as $row){

	$arr = array();
$arr['loan_id'] = $row->loanId;
$arr['nic'] = $row->nic;
$arr['pay_type'] = $row->paytype;
$arr['lat'] = $row->lat;
$arr['lon'] = $row->lon;
$arr['timestamp'] = $row->timestmp;
$arr['user_name'] = $row->username;

$main_arr[] = $arr;

}

echo json_encode(array('status'=>true,'data'=>$main_arr));


	}


	public function block_reservation(){


		$data = $this->andr_manager_model->block_reservation();

		echo json_encode(array('status'=>true,'data'=>$data));

        // echo $query->num_rows;
        // foreach ($query->result() as $row){

        // }




// $data = array();
// 		$main_arr = array();

// 		for($i=0;$i<5;$i++){
// 			$project = array();

//             $block = array();

// 		$block['land_name'] = '';
// 		$block['block_no'] = '';
// 		$block['extend_of_block'] = '';
// 		$block['selling price'] = '';
// 		$project['block'] = $block;
// 		$main_arr['project'] = $project;
//         $data[] = $main_arr;


// 		}








// 		echo json_encode(array('status'=>true,'data'=>$data));
	}


    public function insert_block_reservation(){

		$projectno = $_GET['projectno'];
		$nic = $_GET['nic'];
		$blockid = $_GET['blockid'];
		$amt = $_GET['amount'];
		$timestamp = $_GET['timestamp'];
		$customer_name = $_GET['customer_name'];
		$mobile = $_GET['mobile'];
		$remark = $_GET['remark'];
    $bill_num = $_GET['bill_num'];
    $user_id = $_GET['user_id'];

    if($bill_num!=""){
      $query = $this->andr_manager_model->insert_block_reservation($projectno,$nic,$blockid,$amt,$timestamp,$customer_name,$mobile,$remark,$bill_num,$user_id);

     if($query){
     echo json_encode(array('status'=>true,'message'=>$query,'img_related_id'=>$query));
     }else{
     echo json_encode(array('status'=>true,'message'=>'Not Inserted','img_related_id'=>''));
     }
    }else{
    echo json_encode(array('status'=>false,'message'=>'Please Add TR/Bill Number','img_related_id'=>''));
    }



// 	 if(isset($loanId)){

// $query = $this->andr_manager_model->block_reservaton_insert($projectno,$nic,$blockid,$amt,$timestamp,$customer_name,$mobile);
//   if($query == 1){
//   	echo json_encode(array('status'=>true,'message'=>'successfully added'));

//   }else{
//   	echo json_encode(array('status'=>true,'data'=>'no'));
//   }

//          }

    }

    public function advance_block(){

    $nic = $_GET['nic'];
    $data = $this->andr_manager_model->advance_block($nic);
    echo json_encode(array('status'=>true,'data'=>$data));
    }


    public function advance_block_reservation(){

    $data = $this->andr_manager_model->advance_block_reservation();

		echo json_encode(array('status'=>true,'data'=>$data));


	}


	public function app_logout(){
      $user_id = $_GET['user_id'];
      $meta = $_GET['meta'];


       $query = $this->andr_manager_model->app_logout($user_id,$meta);

       if($query == 1){
echo json_encode(array('status'=>true,'message'=>'successfully Logout'));
}else{
echo json_encode(array('status'=>true,'message'=>false));
}


	}


    public function advance_block_for_loans(){
    $data = $this->andr_manager_model->advance_block_for_loans();

		echo json_encode(array('status'=>true,'data'=>$data));
    }


public function insert_cash_advance(){

		$adv_code = ""; //$_GET['adv_code'];
		$book_id = $_GET['book_id'];
		$amount = $_GET['amount'];
		$settledate = $_GET['settledate'];
		$description = $_GET['description'];
	$userid=$_GET['user_id'];;//this should filled with current userid


 		$query = $this->andr_manager_model->add_cash_advance($adv_code,$book_id,$amount,$userid,$settledate,$description);

		if($query == 1){
		echo json_encode(array('status'=>true,'message'=>'successfully Inserted'));
		}else{
		echo json_encode(array('status'=>true,'message'=>'Not Inserted'));
		}



    }

    public function mark_attendance(){
      //  $meta = $_GET['meta'];
      //  $data = array('duty_in_lati' =>$meta ,'emp_record_id'=>$_GET['user_id'] );
      //  $test=$this->db->insert('hr_emp_attendance',$data);
      // echo json_encode(array('status'=>true,'message'=>'Too early or late to duty out/duty in'));

      date_default_timezone_set('Asia/Colombo');
      $user_id = $_GET['user_id'];
      $meta = $_GET['meta'];

      $access_timein=date("H:i:s", strtotime("08:00:00"));//time send by ticket 456 specialize for first team
      $access_timeout=date("H:i:s", strtotime("18:00:00"));//time send by ticket 456 specialize for first team

      $time=date("H:i:s");
      if (empty($user_id) || empty($meta)) {
        echo json_encode(array('status'=>true,'message'=>'Something Went wrong..! Please Try again'));//check data received
      }else{
      $js = json_decode($meta);
      $type=$js->type;
      $latitude = $js->latitude;
      $longitude =$js->longitude;
      $attendance_details = $this->user_model->get_attendance_details($user_id);//check duty in for mark duty out
      if($type=='mark_in' && count($attendance_details)==0){//check type and check time for duty in
        $mark_attendance = $this->user_model->mark_employee_duty_in($user_id, '',$latitude,$longitude);//duty in time will get from asia/colombo time.
        if($mark_attendance){
          echo json_encode(array('status'=>true,'message'=>'Successfully Marked Duty In'));
        }
      }elseif($type=='mark_out'){//check type and check time for duty out

        $duty_out = $attendance_details['duty_out'];

        if(count($attendance_details)>0 && empty($duty_out)){
          $mark_out=$this->user_model->mark_employee_duty_out($attendance_details['id'],$latitude,$longitude);//haliday, shot leave add by this function too.
          if ($mark_out) {
            echo json_encode(array('status'=>true,'message'=>'Successfully Marked Duty Out'));
          }
      }

      }else{
         echo json_encode(array('status'=>true,'message'=>'Too early or late to duty out/duty in'));
       }


     }

  	}

    public function leave_request(){
        $user_id = $_GET['user_id'];
        $meta = $_GET['meta'];


         $query = $this->andr_manager_model->leave_request($user_id,$meta);

         if($query == 1){
  echo json_encode(array('status'=>true,'message'=>'Successfully Apply Leave'));
  }else{
  echo json_encode(array('status'=>true,'message'=>'Something Went Wrong,Please Try Again'));
  }


    }

    public function get_project_list(){

    $data = $this->andr_manager_model->get_project_list();

    echo json_encode(array('status'=>true,'data'=>$data));


  }

  public function get_advance(){
    $user_id = "";//$_GET['user_id'];
    $meta = $_GET['meta'];

     $query = $this->andr_manager_model->save_advance($user_id,$meta);
    if($query){
      echo json_encode(array('status'=>true,'message'=>'Successfully Data Send'));
    }else{
      echo json_encode(array('status'=>true,'message'=>'Something Went Wrong,Please Try Again'));
    }
  }




  /////// new code done by terance 2020-3-5 for "master lands" app insert process ///////
    function add_call_sheet(){
     $cusname  = $_GET['user_name']; //cusname coming as 'user_name'
     $location = $_GET['password'];//location coming as 'password'
     $phone    = $_GET['emi_no']; //phone coming as 'uid->emi_no' .. uid turn in to emi_no in HttpUrlTask Class
     $remark   = $_GET['loan_id'];// remark coming as 'loan_id'
     $user_id  = $_GET['user_id'];  // user_id coming as 'user_id'
     $project_id = $_GET['nic']; //project_id coming as 'nic'
     $today    = date("Y-m-d");

     $callsheetarr = array(
      'customer_name' => $cusname,
      'project_id' => $project_id,
      'location' => $location,
      'phone' => $phone,
      'remark' => $remark,
      'added_by' => $user_id,
      'added_date' => $today,
     );

     $insertcallsheet = $this->andr_manager_model->insert_new_callsheet($callsheetarr);
      if($insertcallsheet){
        echo json_encode(array('status'=>true,'data'=>"Call Sheet Added Succesfully"));
      }else{
        echo json_encode(array('status'=>false,'data'=>"Error Adding Call Sheet"));
      }
    }


function get_call_sheets_by_name(){
      $projectid = $_GET['user_name']; //cusname coming as 'user_name'
      //$cusname = $_POST['user_name'];
      $getvalus = $this->andr_manager_model->get_customer_related_callsheets($projectid);
      if($getvalus){
        echo json_encode(array('status'=>true,'data'=>$getvalus));
      }else{
        echo json_encode(array('status'=>false,'data'=>"Sorry This Project Doesn't Have Call Sheets"));
      }
    }



    /*    ****** new functions created by terance perera 2020-7-15 for futureland "meter reading" ******     */

       /*function get_current_user_meter_data(){
         $user_id  = $_GET['user_id'];  // user_id coming as 'user_id'
         $vehicle_type = $_GET['user_name']; // vehicle type coming as 'user_name' in Android Http request
         $getusermeterdata = $this->andr_manager_model->get_user_meter_data($user_id,$vehicle_type);
         if($getusermeterdata){
            echo json_encode(array('status'=>true,'data'=>$getusermeterdata));
          }else{
            echo json_encode(array('status'=>false,'data'=>"Sorry You Dont Have Start Reading and Per 1KM pay Amount"));
          }
       } */

       function get_current_user_meter_data(){
         $json = array();
         $userid  = $_GET['user_id'];  // user_id coming as 'user_id'
         //$vehicle_type = $_GET['user_name']; // vehicle type coming as 'user_name' in Android Http request

         $employee_details = $this->andr_manager_model->get_employee_details($userid);
         $json['employee_details'] = $employee_details;
         $vehicle_type=$employee_details['vehicle_type'];
         if($employee_details['fuel_allowance_status']=="Y"){
           $user_meter_reading_last_record = $this->andr_manager_model->get_user_meter_reading_last_record($userid);
           $json['user_meter_reading_last_record'] = $user_meter_reading_last_record;

           $fuel_allowance_rate = $this->andr_manager_model->get_fuel_allowance_rate($vehicle_type);
           $json['fuel_allowance_rate'] = $fuel_allowance_rate;

           $fuel_allowance_additional_total = $this->andr_manager_model->get_fuel_allowance_additional($userid);
             /* $fuel_allowance_additional_total = 0;
              if($fuel_allowance_additional){
                foreach($fuel_allowance_additional as $fuel_allowance_additional_row){
                $fuel_allowance_additional_total = $fuel_allowance_additional_total + $fuel_allowance_additional_row->approved_amount;
                }
              } */

              $json['fuel_allowance_additional_total'] = $fuel_allowance_additional_total;


           $user_meter_reading_for_month = $this->andr_manager_model->get_user_meter_reading_for_month($userid);
            $amount_count_per_month = 0;
            $exceeded_amount = 0;
            foreach($user_meter_reading_for_month as $meter_reading_for_month_row){
              if($meter_reading_for_month_row->exceed_status == 'Y'){
                $exceeded_amount = $meter_reading_for_month_row->exceeded_amount;
              }
              $amount_count_per_month = $amount_count_per_month + $meter_reading_for_month_row->amount;
            }
            $amount_count_per_month = $amount_count_per_month - $exceeded_amount;
            $json['amount_count_per_month'] = $amount_count_per_month;
            $json['exceeded_amount_per_month'] = $exceeded_amount;


            if(count($user_meter_reading_last_record)>0){
                  $start_reading = $user_meter_reading_last_record['end_reading'];
                }else{
                  $start_reading = $employee_details['initial_meter_reading'];
                }

                $json['start_reading'] = $start_reading;
                $total_fuel_entitled = $employee_details['fuel_allowance_maximum_limit'] + $fuel_allowance_additional_total;
                $json['balance'] = $total_fuel_entitled - $amount_count_per_month;

            echo json_encode(array('status'=>true,'data'=>$json));
         }else{
             echo json_encode(array('status'=>false,'data'=>"You are not entitled for fuel allowancess"));
         }


      }

      /**********Updated by nadee 2020-10-26**************/
      function followup_list(){

        $loans = array('Reminder Send','Customer Call','Customer Visit','Payment Projection');
        echo json_encode(array('status'=>true,'data'=>$loans));

      }

      function save_followups()
      {

        $query =$this->andr_manager_model->add_followups($_GET['loan_id']);

       if($query){
       echo json_encode(array('status'=>true,'message'=>'successfully Inserted'));
       }else{
       echo json_encode(array('status'=>true,'message'=>'Not Inserted'));
       }
      }

      public function cash_deposited(){
  $user_id = $_GET['user_id'];
  $meta = $_GET['meta'];

  $query = $this->andr_manager_model->cash_deposited($user_id,$meta);
  if($query){
    echo json_encode(array('status'=>true,'message'=>$query,'img_related_id'=>$query));
  }else{
    echo json_encode(array('status'=>true,'message'=>'Something Went Wrong,Please Try Again','img_related_id'=>''));
  }
}
 function file_uploads_viaapp()
 {
   // $file_name="";
		// 		$config['upload_path'] = 'uploads/api_uploads/';
   //              $config['allowed_types'] = 'gif|jpg|png|pdf|xls|';
   //              $config['max_size'] = '3000';
   //
   //              $this->load->library('image_lib');
   //              $this->load->library('upload', $config);
   //       		//$this->upload->do_upload('idcopy');
   //          	//$error = $this->upload->display_errors();
   //
		// 					//////////////////////////
		// 					$this->upload->do_upload('name');
		// 							$image_data = $this->upload->data();
		// 							$error = $this->upload->display_errors();
		// 					/////////////
   //
   //          	//$image_data = $this->upload->data();
   //          	//$this->session->set_flashdata('error',  $error );

   $file_path = 'uploads/api_uploads/';
   $upload_docs = basename( $_FILES['uploaded_file']['name']);
   $file_path = $file_path .$upload_docs ;
   if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {

$myArray = explode('=', $upload_docs);
$myArray2 = explode('.', $myArray[2]);
$doc_related=$myArray[0];
$doc_type=$myArray[1];
$doc_id=$myArray2[0];
$user_name=$_GET['user_name'];
//$query = $this->andr_manager_model->document_uploads_update($doc_related,$doc_type,$doc_id,$user_name);


     $zip = new ZipArchive;
     $res = $zip->open($file_path);
     if ($res === TRUE) {
       mkdir("uploads/api_uploads/extract_path/".$query);
  $zip->extractTo('uploads/api_uploads/extract_path/'.$query.'/');
    $zip->close();
$query = $this->andr_manager_model->document_uploads_update($doc_related,$doc_type,$doc_id,$user_name);
  //echo 'woot!';
} else {
  //echo 'doh!';
}

          echo json_encode(array('status'=>true,'message'=>'Successfully uploaded'));
				}else
				{
          echo json_encode(array('status'=>true,'message'=>"Please Try Again"));

				}

 }

 function save_meter_reading()
 {

   $query =$this->andr_manager_model->save_meter_reading($_GET['user_id']);

  if($query){
  echo json_encode(array('status'=>true,'message'=>'successfully Inserted'));
  }else{
  echo json_encode(array('status'=>true,'message'=>'Not Inserted'));
  }
 }

 public function cash_book_data(){


         $adv_code = ""; //$_GET['adv_code'];
         $book_id = $_GET['book_id'];
         $expenses_list=Null;
          $sendexpenses_list=array();
         if($book_id=='CHQ'){
           $data['pay_type']=$pay_type='CHQ';
           $expenses_list = array('Material','Machinery','Labour','Insurance (motor vehicle, personal accident, health)','Other' );


           $n=0;
           foreach($expenses_list as $value) {
             $n++;
             $temp_array=Null;
             $temp_array['name']=$value;
             array_push($sendexpenses_list,$temp_array);
           }
         }else{
           $data['pay_type']=$pay_type='CSH';
           $expenses_list = array("Telephone SLT","Telephone Mobitel",
           "Electricity Expenses","Water Expenses American Premium","Water Expenses NWSDB",
           "Consultants payments","Office Cleaning","Postage & Courier","Printing & Stationery",
           "Advertising Expenses - (Jobs & notices)",
           "Refreshments & Tea","Equipment Repairs & Maintenance",
           "Office Repairs & Maintenance","Building Rent","Rates & Licenses","Donations",
           "Accounting Fees","Office Renovation Expenses","Fines & Surcharges","Secretarial Charges",
           "Annual Subscriptions","Audit Fees","Travelling","Training Expenses","Janitorial",
           "Vehicle Rent","Fuel Expenses","Development Exp.","Legal Exp","Casual Wages",
           "Plan Approval","Site Exp","Land Cleaning","Vehicle Maintenance","Bank Loan Exp.");
           $n=0;
           foreach($expenses_list as $value) {
             $n++;
             $temp_array=Null;
             $temp_array['name']=$value;
             array_push($sendexpenses_list,$temp_array);
           }
         }
         $json['books_data']=$book_data=$this->cashadvance_model->get_all_books($pay_type);
         $json['approvlist']=$this->common_model->get_privilage_officer_list('approve_cashadvance');
          $json['check_list']=$this->common_model->get_privilage_officer_list('check_cashadvance');
          $json['expences_list']=$sendexpenses_list;

         if($book_data){
         echo json_encode(array('status'=>true,'data'=>$json));
         }else{
         echo json_encode(array('status'=>true,'message'=>'Please Select type'));
         }
     }



}
?>
