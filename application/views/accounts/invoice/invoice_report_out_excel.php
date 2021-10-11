

<?  if($datalist){?>

<?
 $b='';
$b=$b.'
 <table  border="1"> <thead> <thead> <tr  bgcolor="#dad1cb"> <th> Date</th> <th>Supplier Name</th>  <th>Invoice Type</th> <th>Invoice Number</th><th>Item Description</th> <th>Invocie Amount</th><th>Paid Amount</th><th>Outstanding Amount</th></tr> </thead>';
                       $prjname='';$brcode='';  
					  $suptot=0; $suppaytot=0;
					  $prj_id=''; $brid='';
					  $fulltot=0; $fullpaytot=0;
					  if($datalist){$c=0;
                          foreach($datalist as $row){
							 $b=$b.'  <tbody>';
                      if($prj_id!='' & $prj_id!=$row->supplier_id){
                       $b=$b.' <tr bgcolor="#c3c4be" style="font-weight:bold" > ';
                       $b=$b.' <td scope="row" colspan="5">'.$prjname.' Total</td>';
                        
                       $b=$b.' <td align="right">'.number_format($suptot,2).'</td>';
                             $b=$b.'   <td align="right">'.number_format($suppaytot,2).'</td>';
                                $b=$b.'  <td align="right">'.number_format($suptot-$suppaytot,2).'</td>';
                        $b=$b.'  </tr> ';
                         
                     $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$suppaytot=0;$suptot=0;;
					   }
                         $b=$b.'  <tr > ';
                       $b=$b.'  <td scope="row">'.$row->date.'</td>';
                       $b=$b.' <td> '.$row->first_name.' '.$row->last_name.'</td>';
                      $b=$b.'  <td> '.$row->type .'</td>';
                       $b=$b.' <td>'.$row->inv_no.'</td>';
                       $b=$b.' <td>'.$row->note .'</td>';
                       $b=$b.'  <td align="right">'.number_format($row->total,2).'</td>';
                       $b=$b.'   <td align="right">'.number_format($row->totpay,2).'</td>';
                        $b=$b.'  <td align="right">'.number_format($row->total-$row->totpay,2).'</td>';
                       $b=$b.'   </tr> ';
                       
                        
                                
									$suptot=$suptot+($row->total);
									$suppaytot=$suppaytot+($row->totpay);
								$prj_id=$row->supplier_id;
								$prjname=$row->last_name;
									$fulltot=$fulltot+($row->total);
								$fullpaytot=$fullpaytot+($row->totpay);
								
								
								
								  }} 
                                      $b=$b.'   <tr bgcolor="#c3c4be" style="font-weight:bold">'; 
                        $b=$b.' <td scope="row" colspan="5"> '.$prjname.'Project Total</td>';
                             $b=$b.'   <td align="right">'.number_format($suptot,2).'</td>';
                            $b=$b.'    <td align="right">'.number_format($suppaytot,2).'</td>';
                           $b=$b.'       <td align="right">'.number_format($suptot-$suppaytot,2).'</td>';
                       $b=$b.'   </tr> ';
                         
                       $b=$b.'    <tr class="yellow" style="font-weight:bold"> ';
                       $b=$b.'  <td scope="row" colspan="5"> Total</td>';
                        $b=$b.'       <td align="right">'.number_format($fulltot,2).'</td>';
                        $b=$b.'         <td align="right">'.number_format($fullpaytot,2).'</td>';
                       $b=$b.'           <td align="right">'.number_format($fulltot-$fullpaytot,2).'</td>';
                       $b=$b.'   </tr> ';
                       $b=$b.'    </tbody></table>'; }
					   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Invoice_outstanding_Report.xls");
	echo $b;
					   