
<?

   $heading2='Leave Pending Leave List';

$b='';
$b=$b.'
     <table  border="1"  width="100%"> <tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr>
     <tr>
       <th>No</th>
       <th>Employee</th>
       <th>Pending Leave Date</th>
       <th>updated Time</th>
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
       $b=$b.'  <td>'.$row->start_date.'</td>';
       $b=$b.'   <td>'.$row->lastupdate.'</td>';

        $count++;
      }
    }
           $b=$b.' </table>';

		   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename='leavelist.xls'");
	echo $b;
