<?php ob_start();
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class andr_manager extends CI_Controller {

function __construct() {
	//date_default_timezone_set('Asia/Colombo');
	//	header('Content-type/:application/json');
	//	header('content-type text/html charset=utf-8');
        parent::__construct();
		$this->load->model("andr_manager_model"); //load event model
    }

	public function index()
	{

    $user_name = $_GET['user_name'];
    $password =  $_GET['password'];
    $emi_no = $_GET['emi_no']; 
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
                            $loans['info'] = $json;
                            


        $lns = array();                    //
foreach ($query->result() as $row1){

$ss = array();
$jsonloan1 = array();

// $ss['balanceEnquery'] = 
                            $jsonloan1['paid']['noInstalment'] = $row1->paid_ins;
                            $jsonloan1['paid']['totalValue'] = $row1->paid_tot;


                            $jsonloan1['areas']['noInstalment'] =$row1->areas_ins;
                            $jsonloan1['areas']['totalValue'] = $row1->areas_tot;


                            $jsonloan1['due']['noInstalment'] =$row1->due_ins;
                            $jsonloan1['due']['totalValue'] =$row1->due_tot;

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



         if(isset($loanId)){

  $query = $this->andr_manager_model->updateLoanPayment($loanId,$nic,$paytype,$amt,$timestamp,$user_name,$location,$cheque_number);

  if($query == 1){
  	echo json_encode(array('status'=>true,'message'=>'the amount successfully updated'));	

  }else{
  	echo json_encode(array('status'=>true,'data'=>'no'));	
  }

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


 $query = $this->andr_manager_model->insert_block_reservation($projectno,$nic,$blockid,$amt,$timestamp,$customer_name,$mobile,$remark);

if($query == 1){
echo json_encode(array('status'=>true,'message'=>'successfully Inserted'));
}else{
echo json_encode(array('status'=>true,'message'=>'Not Inserted'));	
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




	}
public function insert_cash_advance(){
		
		$adv_code = $_GET['adv_code'];
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





	
}
?>

