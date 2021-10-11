
<?

   $heading2='Leave List';

$b='';
$b=$b.'
     <table  border="1"  width="100%"> <tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr>
     <tr>
       <th>No</th>
       <th>Employee</th>
       <th>Leave Type</th>
       <th>Start From</th>
       <th>No Of Days</th>
       <th>Reason</th>
       <th>Approved By</th>
       <th>Status</th>
       <th>System Record</th>
     </tr>';


     if($datalist){
       $c = 0;
       $count = 1;
       $ci =&get_instance();
       $ci->load->model('hr/employee_model');
       foreach($datalist as $row){

       $b=$b.'  <tr ><td>'.$count.'</td>';
       $empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
       $b=$b.'  <td>'.$empDetails['epf_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'].'</td>';
       $b=$b.'  <td>'.$row->leave_type.'</td>';
       $b=$b.'   <td>'.$row->start_date.'</td>';
        $b=$b.'   <td >'.$row->no_of_days.'</td>';
        $b=$b.'   <td >'.$row->reason.'</td>';
        $b=$b.'   <td >'.get_user_fullname($row->approval_by).'</td>';
        if($row->approval == "P"){
          $status = "Pending";
        }else if($row->approval == "A"){
          $status = "Approved";
        }else if($row->approval == "D"){
          $status = "Disapproved";
        }else if($row->approval == "W"){
          $status = "Pending(Officer In Charge)";
        }else{
          $status ="";
        }
        $b=$b.'   <td >'.$status.'</td>';
        if($row->sytem_record == "Y"){
          $status = "Yes";
        }else{
          $status ="No";
        }

        $b=$b.'   <td >'.$status.'</td>';
        $count++;
      }
    }
           $b=$b.' </table>';

		   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename='leavelist.xls'");
	echo $b;
