<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class andr_manager_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->library('encryption');
    }
	function index($user_name,$password,$emi_no,$meta) {
		//return $user_name.''.$password.''.$emi_no;

        //$this->db->select('USRNAME');
       // $this->db->where('USRNAME', $user_name);
      //  $query = $this->db->get('cm_userdata');

     //   if ($query->num_rows >0) {
      //  return 'TRUE'; //if matching records go to passowrd validate
       // }
	//	else
		//return 'FALSE'; //if no matching records



      //password

	    $password = $this->encryption->encode($password);
		$this->db->select('cm_userdata.AND_FLG,cm_userdata.USRNAME,cm_userdata.USRID,cm_userdata.USRPW,cm_userdata.USRTYPE,cm_userdata.BRNCODE,cm_usertype.module,cm_branchms.branch_name,cm_branchms.shortcode');
		$this->db->where('USRNAME',$user_name);
		$this->db->join('cm_usertype','cm_userdata.USRTYPE =cm_usertype.usertype','left');
		$this->db->join('cm_branchms','cm_branchms.branch_code =cm_userdata.BRNCODE','left');
		$this->db->where('USRPW',$password );
		//$this->db->where('EMI_NO',$emi_no);

		$query = $this->db->get('cm_userdata');
		if ($query->num_rows >0) {

			 $js = json_decode($meta);
			 $timestamps = $js->time_stamp;

foreach ($query->result() as $row){
    $userid = $row->USRID;
	$insert_attnd = "INSERT INTO `re_attendance_app`( `user_id`, `timestamp`, `date`, `type`) VALUES ('$userid','".$timestamps."','".date('Y-m-d')."','1')";

    $queryinsert = $this->db->query($insert_attnd);

}
			 //if passowrd match return the values

//
			return $query;


		}
		else{
		return $query;
}







    }


    //getbalanceEnquery($type)

function getbalanceEnquery($type,$search) {


// filters
	$data = "";

	if($type == 'nic'){
	$data = "	 '$search'";

}else if($type == 'phn'){
	$data = " rel.loan_code = '$search' ";
}


$sqll = "SELECT re.cus_code,re.first_name,re.title,re.last_name,re.mobile,re.id_number,

(SELECT
ifnull(COUNT(reshdul.tot_instalment),0)

FROM `re_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'paid' and tloan.loan_code = rel.loan_code) as paid_ins,
(SELECT ifnull(sum(tot_payment),0)

FROM `re_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'paid' and tloan.loan_code = rel.loan_code) as paid_tot,

(SELECT
ifnull(COUNT(reshdul.tot_instalment),0)

FROM `re_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date <= curdate()) as areas_ins,
(SELECT
ifnull(sum(tot_payment),0)

FROM `re_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date <= curdate()) as areas_tot,

(SELECT
ifnull(COUNT(reshdul.tot_instalment),0)

FROM `re_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date >= curdate()) as due_ins,
(SELECT
ifnull(sum(tot_instalment),0)

FROM `re_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date >= curdate()) as due_tot




from re_customerms re
inner join re_eploan rel on rel.cus_code = re.cus_code

where $data ";

// 	$this->db->select('re_customerms.cus_code,re_customerms.first_name,re_customerms.title,re_customerms.last_name,re_customerms.mobile,re_customerms.id_number ,(select loan_amount from re_eploan where cus_code = re_customerms.cus_code) as cus');
// if($type == 'nic'){
// 	$this->db->where('id_number',$search);
// }else if($type == 'phn'){
// 	$this->db->where('mobile',$search);
// }


$query = $this->db->query($sqll);

if ($query->num_rows >0) {
	 return $query; //if passowrd match return the values
		}
		else
return $query;
}

function getbalanceEnquery_new($type,$search) {
// filters

// filters
	$data = "";

	if($type == 'nic'){
	$data = " re.id_number = '$search'";

}else if($type == 'phn'){
	$data = " rel.unique_code = '$search' ";
}


$sqll = "SELECT re.cus_code,re.first_name,re.title,re.last_name,re.mobile,re.id_number,rel.unique_code as loan_code,rel.loan_code as loan_id,

(SELECT
ifnull(COUNT(reshdul.tot_instalment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'paid' and tloan.loan_code = rel.loan_code) as paid_ins,
(SELECT ifnull(sum(tot_payment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'paid' and tloan.loan_code = rel.loan_code) as paid_tot,

(SELECT
ifnull(COUNT(reshdul.tot_instalment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date <= curdate()) as areas_ins,
(SELECT
ifnull(sum(tot_payment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date <= curdate()) as areas_tot,

(SELECT
ifnull(COUNT(reshdul.tot_instalment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date >= curdate()) as due_ins,
(SELECT
ifnull(sum(tot_instalment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date >= curdate()) as due_tot,

(SELECT
ifnull(sum(tot_instalment),0)

FROM `cm_customerms` tc
inner join re_eploan tloan on tloan.cus_code = tc.cus_code
inner join re_eploanshedule reshdul on reshdul.loan_code = tloan.loan_code

WHERE reshdul.pay_status = 'pending' and tloan.loan_code = rel.loan_code and reshdul.deu_date <= curdate()) as arrin




from cm_customerms re
inner join re_eploan rel on rel.cus_code = re.cus_code

where $data ";

// 	$this->db->select('cm_customerms.cus_code,cm_customerms.first_name,cm_customerms.title,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number ,(select loan_amount from re_eploan where cus_code = cm_customerms.cus_code) as cus');
// if($type == 'nic'){
// 	$this->db->where('id_number',$search);
// }else if($type == 'phn'){
// 	$this->db->where('mobile',$search);
// }


$query = $this->db->query($sqll);

if ($query->num_rows >0) {
	 return $query; //if passowrd match return the values
		}
		else
return $query;

}




function updateLoanPayment($loanId,$nic,$paytype,$amt,$timestamp,$user_name,$location,$chqno,$bill_num){



     $js = json_decode($location);
if(!empty($location)){
     $lat = $js->lat;
     $lon = $js->lon;
}else{
	 $lat = 0;
     $lon = 0;
}





	$insert = "INSERT INTO `temp_table_andr`(`loanId`,`nic`, `paytype`, `amt`, `timestmp`, `username`, `lat`,`lon`,`chq_no`,`bill_num`) VALUES
	           ('$loanId','$nic','$paytype','$amt','$timestamp','$user_name','$lat','$lon','$chqno','$bill_num')";


    $queryinsert = $this->db->query($insert);

    if($queryinsert == 1){
     return 1;
    }
	else{
		return 2;
	}


}

function gettempdata(){

	$sl = "select * from temp_table_andr";
    return $query = $this->db->query($sl);



}

function block_reservation(){

$prog = "SELECT p.`prj_id`,p.project_code FROM `re_projectms` p
inner join re_prjaclotdata rpd on rpd.prj_id = p.`prj_id`
WHERE p.price_status = 'CONFIRMED' and rpd.status = 'PENDING' and rpd.price_perch !=0 group by  p.`prj_id`";
$query1 = $this->db->query($prog);
$data = array();
$main_arr = array();

foreach ($query1->result() as $row1){



 $sql = "SELECT rp.`project_name`,rp.`project_code`,
rpd.sale_val,rpd.lot_number,rpd.lot_id,rpd.extend_perch
FROM `re_projectms` rp
inner join re_prjaclotdata rpd on rpd.prj_id = rp.`prj_id`
WHERE rp.price_status = 'CONFIRMED' and rpd.status = 'PENDING' and rpd.price_perch !=0 and rp.`prj_id` = '".$row1->prj_id."' order by rpd.lot_id";
$query2 = $this->db->query($sql);
$project1 = array();

foreach ($query2->result() as $row2){

$project = array();


$block = array();
$main_arr['project_name'] = $row2->project_name;
$main_arr['project_code'] = $row2->project_code;

	    $block['block_id'] = $row2->lot_id;
		$block['block_no'] = $row2->lot_number;
		$block['extend_of_block'] = $row2->extend_perch;
		$block['selling price'] = $row2->sale_val;


      $project['block'] = $block;

      $project1[] =$project;
$main_arr['project'] = $project1;

;

}
$data[] = $main_arr;






        }

return $data;

}
function res_code_by_lot_project($projectno,$blockid){
		$this->db->select('res_code');
		$this->db->join('re_projectms', 're_projectms.prj_id=re_resevation.prj_id');
		$this->db->where('re_projectms.project_code', $projectno);
		$this->db->where('re_resevation.lot_id', $blockid);
		$this->db->where('re_resevation.res_status !=', 'REPROCESS');
		$query = $this->db->get('re_resevation');

		 if ($query->num_rows() > 0) {

			$data= $query->row();
			return $data->res_code;

        }
		else return $projectno.'-'.$blockid;
    }

function insert_block_reservation($projectno,$nic,$blockid,$amt,$timestamp,$customer_name,$mobile,$remark,$bill_no,$user_id){

 if($remark==0){
   $insert = "INSERT INTO `temp_reserve_andr`(`projectno`,`nic`, `blockid`, `amt`, `timedata`, `customer_name`, `mobile`,`remark`,`bill_num`,`username`) VALUES
	          ('$projectno','$nic','$blockid','$amt','$timestamp','$customer_name','$mobile','$remark','$bill_no','$user_id')";
 // ('$projectno','$nic','$blockid','$amt','$timestamp','$customer_name','$mobile','$remark')";

 }
 else{
	$res_code=$this->res_code_by_lot_project($projectno,$blockid);

	$insert = "INSERT INTO `temp_table_andr`(`loanId`,`nic`, `paytype`, `amt`, `timestmp`, `username`, `lat`,`lon`,`chq_no`,`bill_num`) VALUES
	           ('$res_code','$nic','','$amt','$timestamp','$user_id','','','','$bill_no')";
 }

$queryinsert = $this->db->query($insert);
    if($queryinsert == 1){
     return 1;
    }
	else{
		return 2;
	}

}

function advance_block($nic){
$data1 = array();
$main_arr = array();
$main_arr1 = array();
$pr = array();

$sql = "SELECT rc.`cus_code`,concat(rc.title,' ',rc.first_name,' ',rc.last_name)  as name FROM  cm_customerms rc where rc.id_number = '$nic' ";
$query1 = $this->db->query($sql);


$sql1 = "SELECT rr.`prj_id`,

(SELECT ms.project_code FROM re_projectms ms where ms.prj_id = rr.prj_id) project_code,
(SELECT ms.project_name FROM re_projectms ms where ms.prj_id = rr.prj_id) project_name

FROM `re_resevation` rr
inner join cm_customerms rc on rr.`cus_code` = rc.cus_code
inner join re_projectms rp on rp.prj_id = rr.`prj_id`
where rc.id_number = '$nic'  and rr.`res_status` = 'PROCESSING' GROUP by rp.prj_id ";


$query2 = $this->db->query($sql1);



foreach ($query2->result() as $row2){
$main_arr1['project_code'] = $row2->project_code;
$main_arr1['project_name'] = $row2->project_name;


$block1 = array();
$sql2 = "SELECT
rr.`res_code`,
(SELECT rpp.lot_number from re_prjaclotdata rpp where rpp.lot_id = rr.`lot_id`) lot_number,rr.`lot_id`


FROM `re_resevation` rr
inner join cm_customerms rc on rr.`cus_code` = rc.cus_code
inner join re_projectms rp on rp.prj_id = rr.`prj_id`
where rc.id_number = '$nic' and rp.prj_id = '".$row2->prj_id."' and rr.`res_status` = 'PROCESSING'
GROUP by rr.`lot_id`   order by   rr.`lot_id`";
$query3 = $this->db->query($sql2);

foreach ($query3->result() as $row3){
$block = array();

$block['res_code'] = $row3->res_code;
$block['lot_number'] = $row3->lot_number;
$block['lot_id'] = $row3->lot_id;
$block1[] = $block;
$main_arr1['block'] = $block1;
}

$data1[] = $main_arr1;


}




$data=array();
foreach ($query1->result() as $row1){
$main_arr['cus_code'] = $row1->cus_code;
$main_arr['name'] = $row1->name;
$main_arr['projects'] = $data1;





$data[] = $main_arr;


}
return $data;

}



function advance_block_reservation(){

$prog = "SELECT rp.`prj_id`,rp.`project_name`,rp.`project_code`
FROM `re_projectms` rp
inner join re_resevation re  on re.prj_id = rp.prj_id

WHERE re.`res_status` = 'PROCESSING'  group by  rp.`prj_id`";
$query1 = $this->db->query($prog);
$data = array();
$main_arr = array();

foreach ($query1->result() as $row1){



 $sql = "SELECT rp.`prj_id`,rp.`project_name`,rp.`project_code`,
rpd.sale_val,rpd.lot_number,rpd.lot_id,rpd.extend_perch,
(SELECT rm.`full_name` FROM `cm_customerms` rm  where  rm.cus_code =  re.cus_code) as full_name,
(SELECT rm.`mobile` FROM `cm_customerms` rm  where  rm.cus_code =  re.cus_code) as mobile,
(SELECT rm.`id_number` FROM `cm_customerms` rm  where  rm.cus_code =  re.cus_code) as id_number


FROM `re_projectms` rp
inner join re_prjaclotdata rpd on rpd.prj_id = rp.`prj_id`
inner join re_resevation re  on re.lot_id = rpd.lot_id

WHERE re.`res_status` = 'PROCESSING' and re.prj_id = rpd.prj_id  and rpd.price_perch !=0  and rp.`prj_id` = '".$row1->prj_id."'";

$query2 = $this->db->query($sql);
$project1 = array();

foreach ($query2->result() as $row2){

$project = array();


$block = array();
$main_arr['project_name'] = $row2->project_name;
$main_arr['project_code'] = $row2->project_code;

	    $block['block_id'] = $row2->lot_id;
		$block['block_no'] = $row2->lot_number;
		$block['extend_of_block'] = $row2->extend_perch;
		$block['selling price'] = $row2->sale_val;
		$block['name'] = $row2->full_name;
		$block['nic'] = $row2->id_number;
		$block['mobile'] = $row2->mobile;


      $project['block'] = $block;

      $project1[] =$project;
$main_arr['project'] = $project1;

;

}
$data[] = $main_arr;






        }

return $data;

}


function app_logout($user_id,$meta){

    $js = json_decode($meta);
			 $timestamps = $js->time_stamp;


   $insert_attnd = "INSERT INTO `re_attendance_app`( `user_id`, `timestamp`, `date`, `type`) VALUES ('$user_id','".$timestamps."','".date('Y-m-d')."','2')";

    $queryinsert = $this->db->query($insert_attnd);

    if($queryinsert == 1){
     return 1;
    }
	else{
		return 2;
	}

}


function advance_block_for_loans(){


$prog = "SELECT rp.`prj_id`,rp.`project_name`,rp.`project_code`
FROM `re_projectms` rp
inner join re_resevation re  on re.prj_id = rp.prj_id
inner join cm_customerms rr on rr.`cus_code` = re.cus_code
inner join re_eploan rel on rel.cus_code = rr.cus_code
  group by  rp.`prj_id`";
$query1 = $this->db->query($prog);
$data = array();
$main_arr = array();

foreach ($query1->result() as $row1){



 $sql = "SELECT rp.`prj_id`,rp.`project_name`,rp.`project_code`,
rpd.sale_val,rpd.lot_number,rpd.lot_id,rpd.extend_perch,
 rr.`full_name`,rr.`mobile`,
rr.`id_number`,rel.loan_code,rel.unique_code


FROM `re_projectms` rp
inner join re_resevation re  on re.prj_id = rp.prj_id
inner join re_prjaclotdata rpd on rpd.lot_id = re.`lot_id`

inner join cm_customerms rr on rr.`cus_code` = re.cus_code
inner join re_eploan rel on rel.res_code = re.res_code

WHERE  re.prj_id = rpd.prj_id  and rpd.price_perch !=0  and rel.loan_status!='SETTLED' and rp.`prj_id` = '".$row1->prj_id."' order by rpd.lot_id";

$query2 = $this->db->query($sql);
$project1 = array();

foreach ($query2->result() as $row2){

$project = array();


$block = array();
$main_arr['project_name'] = $row2->project_name;
$main_arr['project_code'] = $row2->project_code;

	    $block['block_id'] = $row2->lot_id;
		$block['block_no'] = $row2->lot_number;
		$block['extend_of_block'] = $row2->extend_perch;
		$block['selling price'] = $row2->sale_val;
		$block['name'] = $row2->full_name;
		$block['nic'] = $row2->id_number;
		$block['mobile'] = $row2->mobile;
		$block['loan_code'] = $row2->unique_code;


      $project['block'] = $block;

      $project1[] =$project;
$main_arr['project'] = $project1;

;

}
$data[] = $main_arr;






        }

return $data;


}
function get_employee_data_by_id($officerid){
		$this->db->select('*');
		//$this->db->where('status', 'A');
		$this->db->where('id', $officerid);
		$query = $this->db->get('hr_empmastr');

		 if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
    }
function add_cash_advance($adv_code,$book_id,$amount,$userid,$settledate,$description)
	{
		$officerid=$userid;
		$empcode=$this->get_employee_data_by_id($officerid);
		$prifix=$empcode->epf_no.'-';
		$adv_code=$this->get_advance_code('adv_code',$prifix,'ac_cashadvance',$officerid);
		 $data=array(
			'adv_code' => $adv_code,
			'adv_type' => 'Other',
			'book_id' => $book_id,
			'amount' => $amount,
			'apply_date' => date('Y-m-d'),
			'promiss_date' => $settledate,

			'description' => $description,
			'status' => 'PENDING',
			'officer_id' => $userid,


				);
			if ( ! $this->db->insert('ac_cashadvance', $data))
			{
				  return 2;
			} else {
			  return 1;
			}
	}
function get_advance_code($idfield,$prifix,$table,$officerid)
	{

 	$query = $this->db->query("SELECT COUNT(".$idfield.") as id  FROM ".$table." where officer_id='".$officerid."'");

		$newid="";

        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);


			 }
			 else{
			// $prjid=substr($prjid,4,5);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 5, "0", STR_PAD_LEFT);


			 }
        }
		else
		{

		$newid=$prifix.str_pad(1, 5, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;

	}
function get_project_list(){


$prog = "SELECT rp.`prj_id`,rp.`project_name`,rp.`project_code`
FROM `re_projectms` rp";
$query1 = $this->db->query($prog);
$data = array();
$main_arr = array();

foreach ($query1->result() as $row1){

$main_arr['project_name'] = $row1->project_name;
$main_arr['project_code'] = $row1->project_code;
$main_arr['project_id'] = $row1->prj_id;
$data[] = $main_arr;
}


return $data;


}


// function save_advance($user_id,$meta){
//   /*if (empty($user_id) || empty($meta)) {
//     if(empty($user_id)){
//       return 2;
//     }else{
//       return 3;
//     }
//   }else{*/
//     $save_advance_data=0;
//     $emp_id = $user_id;
//     $js = json_decode($meta);
//
//     $request_advance_type = $js->request_advance_type;
//     if($request_advance_type=="salary_advance"){
//
//       $data1['year'] = date('Y');
//       $data1['month'] = date('m');
//       $data1['amount'] = $js->amount;
//       $data1['user_id'] = $js->user_id;
//       $data1['request_date'] = date('Y-m-d H:i:s');
//
//
//       $this->db->trans_start();
//       $this->db->insert('hr_emp_salary_advance_request', $data1);
//       $save_advance_data=1;
//       $this->db->trans_complete();
//     }elseif($request_advance_type=="cash_settlement"){
//       $save_advance_data=1;
//     }elseif($request_advance_type=="cash_advance"){
// if($js->type=='Development') $book_id=2;
// else $book_id=1;
// $data3['adv_code'] =$js->advance_number;
// $data3['officer_id'] =1;
// $data3['adv_type'] ="Project";
// $data3['book_type'] =$js->type;
// $data3['book_id'] =$book_id;
// $data3['amount'] =$js->amount;
// $data3['apply_date'] = date('Y-m-d H:i:s');
// $data3['project_id'] =$js->project;
// $data3['description'] =$js->description;
// $data3['status'] ="PENDING";
//
// $this->db->trans_start();
// $this->db->insert('ac_cashadvance', $data3);
// $save_advance_data=1;
// $this->db->trans_complete();
//     }
//     return $save_advance_data;
//   //}
// }
function get_loan_data($loancode)
{
		$this->db->select('*');
		//$this->db->where('status', 'A');
		$this->db->where('unique_code', $loancode);
		$query = $this->db->get('re_eploan');

		 if ($query->num_rows() > 0) {

			return $query->row();

        }
		else return false;
}
function get_paid_details($loancode)
{
	$loandata=$this->get_loan_data($loancode);
	$dataarr=array(0,0);
	if($loandata)
	{
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('re_eploanshedule.loan_code',$loandata->loan_code);
		$this->db->where('re_eploanshedule.reschdue_sqn',$loandata->reschdue_sqn);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
		//$this->db->where('re_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		$data= $query->row();
		if($data->totpay>0){
		$dataarr[0]=$paidtot=$data->totpay;
		$dataarr[1]=$paindins=round($data->totpay/$loandata->montly_rental,0);}
		}


	}
	return $dataarr;
}
function get_arrars_details($loancode)
{
	$loandata=$this->get_loan_data($loancode);
	$dataarr=array(0,0);
	if($loandata)
	{
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('re_eploanshedule.loan_code',$loandata->loan_code);
		$this->db->where('re_eploanshedule.reschdue_sqn',$loandata->reschdue_sqn);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
		$this->db->where('re_eploanshedule.deu_date <',date('Y-m-d'));
		//$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		$data= $query->row();
		$dataarr[0]=$paidtot=$data->arriastot-$data->totpay;
		$dataarr[1]=$paindins=round($paidtot/$loandata->montly_rental,0);
		}
		//else

	}
	return $dataarr;
}
function get_balance_details($loancode)
{
	$loandata=$this->get_loan_data($loancode);
	$dataarr=array(0,0);
	if($loandata)
	{
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('re_eploanshedule.loan_code',$loandata->loan_code);
		$this->db->where('re_eploanshedule.reschdue_sqn',$loandata->reschdue_sqn);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
		//$this->db->where('re_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		$data= $query->row();
		$dataarr[0]=$paidtot=$data->arriastot-$data->totpay;
		$dataarr[1]=$paindins=round($paidtot/$loandata->montly_rental,0);
		}
		//else

	}
	return $dataarr;
}

function app_attendant($user_id,$meta)
  {
    if (empty($user_id) || empty($meta)) {
      return 2;
    }
	else
	{
			$js = json_decode($meta);
			$type=$js->type;
			$timestamps=time();
			$out_time=date('Y-m-d H:i:s', $timestamps);
			$in_time=date('Y-m-d H:i:s', $timestamps);
			$date=date('Y-m-d', $timestamps);
			if($type=='mark_in'){
			  $data = array('emp_record_id' =>$user_id ,
			  'date'=>$date,
			  'duty_in'=>$in_time
			);
			$queryinsert=$this->db->insert("hr_emp_attendance",$data);

			if($queryinsert){
			  return 3;
			}
			else{
			  return 2;
			}
		  }elseif($type=='mark_out')
			$data = array('duty_out' =>$out_time);
			$this->db->where('emp_record_id',$user_id);
			$this->db->where('date',$date);
			$queryupdate=$this->db->update("hr_emp_attendance",$data);

			if($queryupdate){
			  return 3;
			}
			else{
			  return 2;
			}
  }
}
function leave_request($user_id,$meta)
{
  date_default_timezone_set('Asia/Colombo');
  if (empty($user_id) || empty($meta)) {
    return 2;
  }else{
    $emp_id = $user_id;
    $js = json_decode($meta);
    $leave_type = $js->leave_type;
    $timestamps = date('Y-m-d',strtotime($js->leave_date));
    $timestamps_todate = date('Y-m-d',strtotime($js->leave_todate));
    $no_of_days=0;
    $leave_add=2;
    if($leave_type=="day_off"){

      $data2['emp_record_id'] = $emp_id;
      $data2['start_date'] = $timestamps;
      $data2['end_date'] = $timestamps_todate;
      $data2['request_date'] = date("Y-m-d");
      $this->db->trans_start();
        $this->db->insert('hr_emp_leave_offdays', $data2);
      $this->db->trans_complete();
    }else{

      if($leave_type=="half_day_m" || $leave_type=="half_day_e")
      {
        $leave_type="half_day";
        $no_of_days='0.5';
      }else{
        $leave_type="Personal";
        $no_of_days=1;
      }

      if($leave_type != "half_day" && $leave_type != "short_leave"){
        $data['emp_record_id'] = $emp_id;
        $data['leave_type'] = $leave_type;
        $start_date=$timestamps;
        $end_date=$start_date;
        if($timestamps_todate){
          $end_date=$timestamps_todate;
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['no_of_days'] = $no_of_days;
        $data['officer_in_charge'] = '';
        $data['approval']='P';
        $data['reason'] = $js->description;
        $data['created'] = date('Y-m-d H:i:s');

        $this->db->trans_start();
        $this->db->insert('hr_emp_leave_records', $data);
        $leave_add=1;
        $this->db->trans_complete();
      }else{
        if($leave_type == "half_day"){
          $leave_duration = 0.5;
          $leave_reason = "Half Day";
        }else if($leave_type == "short_leave"){
          $leave_duration = 0.25;
          $leave_reason = "Short Leave";
        }

        $this->db->select('*');
        $this->db->where('id', $emp_id);
        $query = $this->db->get('hr_empmastr');
        $employee_details = $query->row_array();

        $leave_category_id = $employee_details['leave_category'];
        $leave_category_details = $this->user_model->get_leave_category_details($leave_category_id);
        $active_user_leave_records = $this->user_model->get_user_active_leave_records($emp_id);

        $annual_leave_count = 0;
        $cassual_leave_count = 0;

        $entitled_annual_leave = $leave_category_details['annual_leave'];
        $entitled_cassual_leave  = $leave_category_details['cassual_leave'];

        if(count($active_user_leave_records)>0){
          foreach($active_user_leave_records as $user_leave_record){
            if($user_leave_record->approval == "A" && $user_leave_record->active_record == "Y"){
              if($user_leave_record->leave_type == "annual"){
                $annual_leave_count = $annual_leave_count + $user_leave_record->no_of_days;
              }else if($user_leave_record->leave_type == "cassual"){
                $cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
              }
            }
          }
        }

        if(($annual_leave_count + $leave_duration) < $entitled_annual_leave){
          $data1['leave_type'] = "annual";
        }else if(($cassual_leave_count + $leave_duration) < $entitled_cassual_leave){
          $data1['leave_type'] = "cassual";
        }else{
          $data1['leave_type'] = "no_pay";
          $data1['no_pay_status'] = "Y";
          $data1['no_pay_days'] = $leave_duration;
        }
        $start_date=$timestamps;
        $end_date=$start_date;
        if($timestamps_todate){
          $end_date=$timestamps_todate;
        }
        $data1['emp_record_id'] = $emp_id;
        $data1['start_date'] = $start_date;
        $data1['end_date'] = $end_date;
        $data1['no_of_days'] = $leave_duration;
        $data1['approval']='P';
        $data1['reason'] = $js->description;
        $data1['created'] = date('Y-m-d H:i:s');

        $this->db->trans_start();
        $this->db->insert('hr_emp_leave_records', $data1);
        $leave_add=1;
        $this->db->trans_complete();
      }
      return $leave_add;
    }
    }


}


 function insert_new_callsheet($callsheetarr){
   	$this->db->insert('re_call_sheet',$callsheetarr);
   	if ($this->db->affected_rows() > 0) {
        return true;
      }else{
        return false;
      }
   }


   function get_customer_related_callsheets($project_id){
    $this->db->select("*");
    $this->db->from("re_call_sheet");
    $this->db->join("re_projectms","re_call_sheet.project_id=re_projectms.prj_id");
    $this->db->like("project_id",$project_id);
    $query = $this->db->get();
    $data = array();
      foreach ($query->result() as $row1){
      $main_arr['project_name'] = $row1->project_name;
    $main_arr['customer_name'] = $row1->customer_name;
    $main_arr['location'] = $row1->location;
    $main_arr['phone'] = $row1->phone;
    $main_arr['remark'] = $row1->remark;
    $main_arr['added_date'] = $row1->added_date;
    $data[] = $main_arr;
    }
   return $data;
   }


   /*    ****** new functions created by terance perera 2020-7-15 for futureland "meter reading" ******     */

     function get_user_meter_data($userid,$vehicle_type){

       $data = array();
       //$main_arr['employee_details'] = $this->get_employee_details($userid);
       //$main_arr['user_meter_reading_last_record'] = $this->get_user_meter_reading_last_record($userid);


       //$main_arr['fuel_allowance_rate'] = $this->get_fuel_allowance_rate($vehicle_type);

       //$main_arr['fuel_allowance_additional_total'] = $this->get_fuel_allowance_additional($userid);



       $user_meter_reading_for_month = $this->get_user_meter_reading_for_month($userid);
       $amount_count_per_month = 0;
      $exceeded_amount = 0;
      foreach($user_meter_reading_for_month as $meter_reading_for_month_row){
        if($meter_reading_for_month_row->exceed_status == 'Y'){
          $exceeded_amount = $meter_reading_for_month_row->exceeded_amount;
        }
        $amount_count_per_month = $amount_count_per_month + $meter_reading_for_month_row->amount;
      }
      $amount_count_per_month = $amount_count_per_month - $exceeded_amount;
      $main_arr['amount_count_per_month'] = $amount_count_per_month;
      $main_arr['exceeded_amount_per_month'] = $exceeded_amount;

       $data[] = $main_arr;
       return $data;
     }

     function get_employee_details($userid){
       $this->db->select('hr_empmastr.id,hr_empmastr.emp_no,hr_empmastr.fuel_allowance_status,hr_empmastr.vehicle_type,
        hr_empmastr.initial_meter_reading,hr_empmastr.fuel_allowance_maximum_limit');
     $this->db->where('id', $userid);
     $query = $this->db->get('hr_empmastr');
     return $query->row_array();
     }

     function get_user_meter_reading_last_record($userid){
       $this->db->select('hr_emp_meter_reading.effective_date,hr_emp_meter_reading.end_reading');
     $this->db->where('emp_record_id', $userid);
     $this->db->where('end_reading !=', 'NULL');
     $this->db->order_by('id',"desc")->limit(1);
     $query = $this->db->get('hr_emp_meter_reading');
     return $query->row_array();
     }

     function get_fuel_allowance_rate($id){
      $this->db->select('hr_fuel_allowance_rates.vehicle_type,hr_fuel_allowance_rates.rate_per_km');
      $this->db->where('id', $id);
      $query = $this->db->get('hr_fuel_allowance_rates');
      return $query->row_array();
    }

    function get_fuel_allowance_additional($emp_id){
      date_default_timezone_set('Asia/Colombo');
      $this->db->select('*');
      $this->db->where('emp_record_id', $emp_id);
      $this->db->where('MONTH(date)', date('m'));
      $this->db->where('YEAR(date)', date('Y'));
      $this->db->where('status', 'Y');
      $query = $this->db->get('hr_emp_fuel_allowance_additional');

      $fuel_allowance_additional_total = 0;
      foreach($query->result() as $fuel_allowance_additional_row){
        $fuel_allowance_additional_total = $fuel_allowance_additional_total + $fuel_allowance_additional_row->approved_amount;
      }
      return $fuel_allowance_additional_total;
    }

    function get_user_meter_reading_for_month($emp_id){
      date_default_timezone_set('Asia/Colombo');
      $this->db->select('*');
      $this->db->where('emp_record_id', $emp_id);
      $this->db->where('MONTH(effective_date)', date('m'));
      $this->db->where('YEAR(effective_date)', date('Y'));
      $query = $this->db->get('hr_emp_meter_reading');
      return $query->result();
    }

/*2020-11-05 updated by nadee */
function add_followups($loancode)
{
 $loan_code=$this->get_loan_data($loancode);
 $resdata=$this->eploan_model->get_eploan_data($loan_code->loan_code);
    $insert_data = array(
   'loan_code' => $resdata->loan_code,
   'cus_code' =>$resdata->cus_code,
   'emp_code' => $resdata->collection_officer,
   'follow_date' =>date('Y-m-d',strtotime($_GET['follow_up_date'])),
   'cus_feedback' => $_GET['customer_feedback'],
   'sales_feedback' => $_GET['officer_feedback'],
   'todate_arreas'=>0,
   'contact_media'=>$_GET['follow_up_type'],
   'promissed_date'=>date('Y-m-d',strtotime($_GET['payment_promised_date'])),
   'promissed_amount'=>$_GET['amount'],
   'create_date'=>date('Y-m-d'),
   'create_by '=>$_GET['user_name'],

   );
           //	$this->db->where('id',$thisdata->id);
   if ( ! $this->db->insert('re_epfollowups', $insert_data))
   {
   $this->db->trans_rollback();
   return false;
   }
   else
   return true;


}

function cash_deposited($user_id,$meta){
 $save_cash_deposited_data=0;
 $emp_id = $user_id;
 $js = json_decode($meta);
 $lastid="";

 if($js){

   $data1['deposite_user'] = $emp_id;
   $data1['deposite_date'] = date('Y-m-d H:i:s');
   $data1['amount'] = $js->amount;
   $data1['bank'] = $js->bank_name;
   $data1['branch'] =$js->bank_branch;
   $data1['description'] =$js->description;
   $this->db->trans_start();
   $this->db->insert('temp_bank_andr', $data1);
   $lastid = $this->db->insert_id();
   $save_cash_deposited_data=$lastid;
   $this->db->trans_complete();
 }
 //$this->common_model->add_notification('temp_bank_andr','Mobile Notify For Bank Deposit','accounts/mobilepay/get_reservations',$lastid);
 return $save_cash_deposited_data;
//}
}

function save_meter_reading($user_id){

 $js =$arrayName = array();
 $js =$_GET['locationArray'];
 $source = str_replace('/', '-', $_GET['eff_date']);
 //$date = new DateTime($source);
 //$new_d=$date->format('Y-m-d');


$user_meter_reading_last_record = $this->get_user_meter_reading_last_record($user_id);
 $data = array('emp_record_id'=>$user_id,
'date'=>date('Y-m-d'),
'effective_date'=>date('Y-m-d',strtotime($source)),
'start_reading'=>$user_meter_reading_last_record['end_reading'],
'end_reading'=>$_GET['end_reading'],
'difference'=>$_GET['end_reading']-$user_meter_reading_last_record['end_reading'],
'private'=>$_GET['private_reading'],
'official'=>$_GET['total_km'],
'amount'=>$_GET['total_amount'],
// 'exceed_status'=>"N",
// 'exceeded_amount'=>0,
'location1'=>$js,
//'description1'=>$location_name,
//'location2'=>$_GET['eff_date'],
// 'description2'=>"",
// 'location3'=>"",
// 'description3'=>"",
// 'location4'=>"",
// 'description4'=>"",
// 'location5'=>"",
// 'description5'=>"",
'created'=>date('Y-m-d'),);
$insert=$this->db->insert('hr_emp_meter_reading',$data);
#
$locations = json_decode($js, true);
$count= count($locations);
$add_id=$this->db->insert_id();
for ($i=0; $i < $count; $i++)
{
 $n=$i+1;
 $data2 = array(
      'location'.$n => $locations[$i]["location"],
      'description'.$n => $locations[$i]["description"],
  );
  $this->db->where('id',$add_id);
  $insert=$this->db->update('hr_emp_meter_reading',$data2);
  //print_r($data);
}


//foreach ($js as $key) {
 //$add_id=$this->db->insert_id();
 //$data2 = array('description1' =>$js , );
 //$this->db->where('id',$add_id);
 //$this->db->update('hr_emp_meter_reading',$data2);
 // code...
//}


return $insert;
//}
}

function document_uploads_update($doc_related,$doc_type,$doc_id,$user_name){
 $data = array('doc_related'=>$doc_related ,
'temp_id'=>$doc_id ,
'doc_type'=>$doc_type ,
'added_by'=>$user_name,
'added_at' =>date('Y-m-d H:i:s') , );

 $query=$this->db->insert('temp_document_uploads',$data);
 if($query){
   return $this->db->insert_id();
 }else{
   return false;
 }

}

function save_advance($user_id,$meta){
  $js = json_decode($meta);
  $officerid=$js->user_id;
  $empcode=$this->cashadvance_model->get_employee_data_by_id($officerid);
  $prifix=$empcode->epf_no.'-';
  $adv_code=$this->cashadvance_model->get_advance_code('adv_code',$prifix,'ac_cashadvance',$officerid);
  $serial_code=$this->cashadvance_model->get_serial_code('serial_number',$prifix,'ac_cashadvance',$js->book_id);
  $confirm_officerid="";
  if($officerid=='22')
  $confirm_officerid=$this->cashadvance_model->get_designation_officer_list('Audit Executive');

  if($officerid=='12')
  $confirm_officerid=$this->cashadvance_model->get_designation_officer_list('Intern');

$date =date('Y-m-d');
$project_data=$js->project_details;
$adv_type="Other";
if($project_data->project_id!="")
{
  $adv_type="Project";
}else{
  $adv_type="Other";
}
   $data=array(
    'adv_code' =>$adv_code,
    'adv_type' => $adv_type,
    'book_id' => $js->book_id,
    'amount' => $js->amount,
    'apply_date' => $date,
    'promiss_date' =>date('Y-m-d', strtotime($date. ' + 14 days')),
    'project_id' => $project_data->project_id,
    'description' => $js->description." ".$js->expences_list_value,
    'expence_type' => $js->expences_list_value,
    'check_officerid' => $js->check_list_id,
    'apprved_officerid' => $js->approv_id,
     'confirm_officerid' => $confirm_officerid,
     'status' => 'PENDING',
     'officer_id' => $officerid,
     'serial_number'=>$serial_code


      );
      $insert = $this->db->insert('ac_cashadvance', $data);
      //$entry_id = $this->db->insert_id();

  //$row = $this->db->query('SELECT MAX(adv_id) AS `maxid` FROM `ac_cashadvance`')->row();
  return true;
  }






}
