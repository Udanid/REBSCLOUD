<?
$b='';

     $b=$b.'
                
      <table width="100%" border="1">  <thead> <tr  bgcolor="#98e5f3"> <th rowspan="2">Project Name</th> <th rowspan="2">Lot Number</th> <th rowspan="2">Instruction Received Date </th> 
  <th colspan="4">Stamp Fees</th><th colspan="7">Deed Details</th><th colspan="3">Informed Details</th><th colspan="4">Deed Issued Details</th></tr>
                  <tr bgcolor="#98e5f3"><th>Payable Amount </th> <th>Amount</th> <th>Request Date</th> <th>Paid Date</th><th>Lawyer</th><th>Deed Date</th>
                  <th> Deed No</th> <th>LR Date</th> <th> Daybook no.</th> <th> Received Date</th> <th>Registed Porlio</th> <th>Date</th> <th> By</th><th> Method</th><th> Date</th><th> Issued By</th><th> Issued to</th><th> Remark</th></tr> </thead>';
                     $list=''; if($blocklist){$c=0;$list='';$prj_name='';
                          foreach($blocklist as $row){ 
                       if($prj_name!='' & $prj_name!=$row->project_name){
                     $b=$b.' <tr><td colspan="21" bgcolor="#f8bcff">&nbsp;</td></tr>';
                       } $prj_name=$row->project_name;
                       $b=$b.' <tbody> <tr >'; 
                          $b=$b.'<th scope="row">'.$row->project_name.'</td>';
                          $b=$b.' <td>'.$row->lot_number.'</td>';
                         $b=$b.' <td>'.$row->form_confirm_date.'</td>';
						   $b=$b.'<td align="right">'.number_format($row->stamp_duty,2).'</td>';
                          $b=$b.'<td align="right">'.number_format($row->full_amount,2).'</td>';
                          $b=$b.'  <td>'.$row->need_date.'</td>';
                          $b=$b.'  <td>'.$row->paymend_dondate.'</td>';
                          
                          $b=$b.'   <td>'.$row->attest_by.'</td>';
                            $b=$b.' <td>'.$row->deed_date.'</td>';
                           $b=$b.'  <td>'.$row->deed_number.'</td>';
                            $b=$b.' <td>'.$row->landr_date.'</td>';
                           $b=$b.'  <td>'.$row->day_book_no.'</td>';
                            $b=$b.'  <td>'.$row->rcv_date.'</td>';
                           $b=$b.'  <td>'.$row->register_portfolio.'</td>';
                           
                           $b=$b.'  <td>'.$row->informed_date.'</td>';    
                            $b=$b.' <td>'.get_user_fullname_id($row->inform_by).'</td>';
                              $b=$b.' <td>'.$row->informed_method.'</td>';
                      
                       $b=$b.' <td>'.$row->issue_date.'</td>';   
                              $b=$b.'<td>'.get_user_fullname_id($row->inform_by).'</td>';
                              $b=$b.' <td>'.$row->issue_to.'</td>';
                              $b=$b.'   <td>'.$row->remark.'</td>';
                        $b=$b.'  <td></td>';
                        $b=$b.'   </tr> ';
                        
                                }} 
                                
                          $b=$b.'  </tbody></table>';
						  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Deed-Report.xls");
	echo $b;