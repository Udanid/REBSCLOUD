<?php ob_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class andr_manager extends CI_Controller {

function __construct() {
	//date_default_timezone_set('Asia/Colombo');
	//	header('Content-type/:application/json');
	//	header('content-type text/html charset=utf-8');
        parent::__construct();
		$this->load->model("hm_andr_manager_model"); //load event model
    $this->load->model("user/user_model");
    $this->load->model("message_model");
    $this->load->model("common_model");
    }

	public function index()
	{
      echo json_encode(array('status'=>true,'data'=>'no'));
	}



	public function getbalanceEnquery(){

     $type = $_GET['type'];
     $search = "";
       if($type == 'nic'){

       	$search = $_GET['nic'];
}else if($type == 'phn'){
		$search = $_GET['mobile'];
}




         $query = $this->hm_andr_manager_model->getbalanceEnquery($type,$search);
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
		// $query = $this->hm_andr_manager_model->tests();
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




         $query = $this->hm_andr_manager_model->getbalanceEnquery_new($type,$search);
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
$paid=$this->hm_andr_manager_model->get_paid_details($row1->loan_code);
$arrears=$this->hm_andr_manager_model->get_arrars_details($row1->loan_code);
$balance=$this->hm_andr_manager_model->get_balance_details($row1->loan_code);
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
		// $query = $this->hm_andr_manager_model->tests();
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

           $query = $this->hm_andr_manager_model->updateLoanPayment($loanId,$nic,$paytype,$amt,$timestamp,$user_name,$location,$cheque_number,$bill_num);

          if($query == 1){
  	           echo json_encode(array('status'=>true,'message'=>'the amount successfully updated'));

            }else{
  	           echo json_encode(array('status'=>true,'data'=>'no'));
            }

         }else{
         	echo json_encode(array('status'=>true,'message'=>'Please Add TR/Bill Number'));
         }


	}


	public function gettempdata(){

		$main_arr = array();
	$query = $this->hm_andr_manager_model->gettempdata();


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


		$data = $this->hm_andr_manager_model->block_reservation();

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
      $query = $this->hm_andr_manager_model->insert_block_reservation($projectno,$nic,$blockid,$amt,$timestamp,$customer_name,$mobile,$remark,$bill_num,$user_id);

     if($query == 1){
     echo json_encode(array('status'=>true,'message'=>'successfully Inserted'));
     }else{
     echo json_encode(array('status'=>true,'message'=>'Not Inserted'));
     }
    }else{
    echo json_encode(array('status'=>true,'message'=>'Please Add TR/Bill Number'));
    }



// 	 if(isset($loanId)){

// $query = $this->hm_andr_manager_model->block_reservaton_insert($projectno,$nic,$blockid,$amt,$timestamp,$customer_name,$mobile);
//   if($query == 1){
//   	echo json_encode(array('status'=>true,'message'=>'successfully added'));

//   }else{
//   	echo json_encode(array('status'=>true,'data'=>'no'));
//   }

//          }

    }

    public function advance_block(){

    $nic = $_GET['nic'];
    $data = $this->hm_andr_manager_model->advance_block($nic);
    echo json_encode(array('status'=>true,'data'=>$data));
    }


    public function advance_block_reservation(){

    $data = $this->hm_andr_manager_model->advance_block_reservation();

		echo json_encode(array('status'=>true,'data'=>$data));


	}


	public function app_logout(){
      $user_id = $_GET['user_id'];
      $meta = $_GET['meta'];


       $query = $this->hm_andr_manager_model->app_logout($user_id,$meta);

       if($query == 1){
echo json_encode(array('status'=>true,'message'=>'successfully Logout'));
}else{
echo json_encode(array('status'=>true,'message'=>false));
}


	}


    public function advance_block_for_loans(){
    $data = $this->hm_andr_manager_model->advance_block_for_loans();

		echo json_encode(array('status'=>true,'data'=>$data));
    }


public function insert_cash_advance(){

		$adv_code = ""; //$_GET['adv_code'];
		$book_id = $_GET['book_id'];
		$amount = $_GET['amount'];
		$settledate = $_GET['settledate'];
		$description = $_GET['description'];
	$userid=$_GET['user_id'];;//this should filled with current userid


 		$query = $this->hm_andr_manager_model->add_cash_advance($adv_code,$book_id,$amount,$userid,$settledate,$description);

		if($query == 1){
		echo json_encode(array('status'=>true,'message'=>'successfully Inserted'));
		}else{
		echo json_encode(array('status'=>true,'message'=>'Not Inserted'));
		}



    }


    public function get_project_list(){

    $data = $this->hm_andr_manager_model->get_project_list();

    echo json_encode(array('status'=>true,'data'=>$data));


  }

  public function get_advance(){
    $user_id = $_GET['user_id'];
    $meta = $_GET['meta'];

     $query = $this->hm_andr_manager_model->save_advance($user_id,$meta);
    if($query== 1){
      echo json_encode(array('status'=>true,'message'=>'Successfully Data Send'));
    }elseif($query== 2){
      echo json_encode(array('status'=>true,'message'=>'Username empty'));
    }else{
      echo json_encode(array('status'=>true,'message'=>'Something Went Wrong,Please Try Again'));
    }
  }

  public function cash_deposited(){
    $user_id = $_GET['user_id'];
    $meta = $_GET['meta'];

    $query = $this->hm_andr_manager_model->cash_deposited($user_id,$meta);
    if($query){
      echo json_encode(array('status'=>true,'message'=>'Successfully Cash Deposit Data Send'));
    }else{
      echo json_encode(array('status'=>true,'message'=>'Something Went Wrong,Please Try Again'));
    }
  }

  public function mark_attendance(){
    // date_default_timezone_set('Asia/Colombo');
    // $user_id = $_GET['user_id'];
    // $meta = $_GET['meta'];
    //
    // $access_timein=date("H:i:s", strtotime("08:00:00"));//time send by ticket 456 specialize for first team
    // $access_timeout=date("H:i:s", strtotime("18:00:00"));//time send by ticket 456 specialize for first team
    //
    // $time=date("H:i:s");
    // if (empty($user_id) || empty($meta)) {
    //   echo json_encode(array('status'=>true,'message'=>'Something Went wrong..! Please Try again'));//check data received
    // }else{
    // $js = json_decode($meta);
    // $type=$js->type;
    // $latitude = $js;//$js->latitude;
    // $longitude ='';//$js->longitude;
    // $attendance_details = $this->user_model->get_attendance_details($user_id);//check duty in for mark duty out
    // if($type=='mark_in' && count($attendance_details)==0){//check type and check time for duty in
    //   $mark_attendance = $this->user_model->mark_employee_duty_in($user_id, '',$latitude,$longitude);//duty in time will get from asia/colombo time.
    //   if($mark_attendance){
    //     echo json_encode(array('status'=>true,'message'=>'Successfully Marked Duty In'));
    //   }
    // }elseif($type=='mark_out'){//check type and check time for duty out
    //
    //   $duty_out = $attendance_details['duty_out'];
    //
    //   if(count($attendance_details)>0 && empty($duty_out)){
    //     $mark_out=$this->user_model->mark_employee_duty_out($attendance_details['id'],$latitude,$longitude);//haliday, shot leave add by this function too.
    //     if ($mark_out) {
    //       echo json_encode(array('status'=>true,'message'=>'Successfully Marked Duty Out'));
    //     }
    // }
    //
    // }else{
       echo json_encode(array('status'=>true,'message'=>'Too early'));
    // }


   }

  }



//}
?>
