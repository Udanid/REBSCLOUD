<? 
$b='';
$b=$b.'

                
                        <table  border="1">  <thead> <tr bgcolor="#d5dace"> <th>Reservation Code</th><th>Branch Name</th><th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Down Payment</th><th>Repay Amount</th></tr> </thead>';
                       $prjpaid=0;$prjbmdp=0;
					 $brnpaid=0;$brnbmdp=0;
					  $prj_id=''; $brid='';
					  if($searchpanel_searchdata){$c=0;
                          foreach($searchpanel_searchdata as $row){
							
                      if($prj_id!='' & $prj_id!=$row->prj_id){
                       $b=$b.'<tr  bgcolor="#b0d2fc" style="font-weight:bold"> ';
                       $b=$b.' <td scope="row" colspan="5">Project Total</td>';
                       
                        $b=$b.'<td align="right">'.number_format($prjpaid,2).'</td>';
                        $b=$b.'<td align="right">'.number_format($prjbmdp,2).'</td>';
                        $b=$b.' </tr>'; 
                         
                       $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					   }
                        if($brid!='' & $brid!=$row->branch_code){
                      $b=$b.' <tr bgcolor="#eaf71f" style="font-weight:bold"> ';
                      $b=$b.'  <td scope="row" colspan="5">Branch Total</td>';
                      $b=$b.'      <td align="right">'.number_format($brnpaid,2).'</td>';
                      $b=$b.'  <td align="right">'.number_format($brnbmdp,2).'</td>';
                      $b=$b.'   </tr> ';
                         
                        $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					   }
                     $b=$b.' <tr > ';
                       $b=$b.' <th scope="row">'.$row->res_code.'</td>';
                      $b=$b.' <td scope="row">'.get_branch_name($row->branch_code).'</td>';
                      $b=$b.' <td> '.$row->project_name .'</td>';
                      $b=$b.' <td> '.$row->lot_number .' '.$row->plan_sqid .'</td>';
                      $b=$b.'  <td>'.$row->first_name .''.$row->last_name .'</td>';
                      $b=$b.'  <td align="right">'.number_format($row->down_payment,2).'</td>';
                       $b=$b.' <td align="right">'.number_format($row->repay_total,2).'</td>';
                       $b=$b.' <td align="right"><div id="checherflag">';
                       
                       $b=$b.' </td>
                         </tr> ';
                        
                                
								$prjpaid=$prjpaid+$row->down_payment;
								$prjbmdp=$prjbmdp+($row->repay_total);
								$prj_id=$row->prj_id;
								$brnpaid=$brnpaid+$row->down_payment;
								$brnbmdp=$brnbmdp+($row->repay_total);
								$brid=$row->branch_code;
								
								
								
								  }} 
                                       $b=$b.'<tr  bgcolor="#b0d2fc" style="font-weight:bold"> ';
                       $b=$b.' <td scope="row" colspan="5">Project Total</td>';
                       
                        $b=$b.'<td align="right">'.number_format($prjpaid,2).'</td>';
                        $b=$b.'<td align="right">'.number_format($prjbmdp,2).'</td>';
                        $b=$b.' </tr>'; 
                         
                           $b=$b.' <tr bgcolor="#eaf71f" style="font-weight:bold"> ';
                      $b=$b.'  <td scope="row" colspan="5">Branch Total</td>';
                      $b=$b.'      <td align="right">'.number_format($brnpaid,2).'</td>';
                      $b=$b.'  <td align="right">'.number_format($brnbmdp,2).'</td>';
                      $b=$b.'   </tr> ';
                         $b=$b.' </tbody></table>  ';
                  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Resale_list-Report.xls");
	echo $b;