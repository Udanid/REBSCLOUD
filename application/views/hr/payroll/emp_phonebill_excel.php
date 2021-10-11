
<?
$date = $details['year']."-".$details['month'];
$month= date("F", strtotime($date));
  $heading2='Phone Bill Payments: '.$month."/".$details['year'];
   //$heading2='Phone Bills';

$b='';
$b=$b.'
     <table  border="1"  width="100%"> <tr><td  align="center"  colspan="4"><h2>'.$heading2.'</h2></td></tr>
     <tr>
       <th>No</th>
       <th>Employee</th>
       <th>Phone Number</th>
       <th>Amount</th>
     </tr>';


     if($phonebill_list){
       $c = 0;
       $count = 1;
       $ci =&get_instance();
       $ci->load->model('hr/employee_model');
       $total='';
       foreach($phonebill_list as $row){

       $b=$b.'  <tr ><td>'.$count.'</td>';
       $empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
       $b=$b.'  <td>'.$empDetails['epf_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'].'</td>';

       $b=$b.'  <td>'.$empDetails['office_mobile'].'</td>';
       $b=$b.'  <td>'.$row->bill_value.'</td></tr>';
       $total=$total+$row->bill_value;
        $count++;
      }
    }
           $b=$b.' <tr><td colspan="3">Total</td><td>'.$total.'</td></tr></table>';

		   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename='phone_bill.xls'");
	echo $b;
