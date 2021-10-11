<? 
$b='';
$b=$b.'
                
                        <table  border="1" > <thead> <tr bgcolor="#d5dace"> <th>Reservation Code</th><th>Branch Name</th><th>Project Name</th><th>Lot Number</th> <th>Customer Name </th><th>Reserve Date</th><th>Estimated Price</th><th>Discount</th><th>Sale Value</th><th>MDP</th><th>Paid Amount</th> </thead>';
                    $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					  $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					  $prj_id=''; $brid='';
					  if($searchpanel_searchdata){$c=0;
                          foreach($searchpanel_searchdata as $row){
							 
                           $b=$b.'  <tbody>';
                      if($prj_id!='' & $prj_id!=$row->prj_id){
                      $b=$b.' <tr bgcolor="#b0d2fc" style="font-weight:bold">'; 
                       $b=$b.' <td scope="row" colspan="6">Project Total</td>';
                       $b=$b.'  <td>'.number_format($prjes,2).'</td>';
                        $b=$b.'   <td>'.number_format($prjdis,2).'</td>';
                      $b=$b.'  <td>'.number_format($prjsale,2).'</td>';
                       
                       $b=$b.' <td align="right">'.number_format($prjmdp,2).'</td>';
                      $b=$b.'  <td align="right">'.number_format($prjpaid,2).'</td>';
                       $b=$b.'  </tr> ';
                         
                      $prjes=0;$prjdis=0;$prjsale=0; $prjmdp=0;$prjpaid=0;$prjbmdp=0;
					   }
                         if($brid!='' & $brid!=$row->branch_code){
                       $b=$b.'<tr   bgcolor="#eaf71f" style="font-weight:bold"> ';
                       $b=$b.' <td scope="row" colspan="6">Branch Total</td>';
                       $b=$b.'  <td>'.number_format($brnes,2).'</td>';
                        $b=$b.'   <td>'.number_format($brndis,2).'</td>';
                       $b=$b.' <td>'.number_format($brnsale,2).'</td>';
                       
                       $b=$b.' <td align="right">'.number_format($brnmdp,2).'</td>';
                       $b=$b.' <td align="right">'.number_format($brnpaid,2).'</td>';
                        $b=$b.'  </tr> ';
                         
                       $brnes=0;$brndis=0;$brnsale=0; $brnmdp=0;$brnpaid=0;$brnbmdp=0;
					   }
                       $b=$b.'<tr >';
                       $b=$b.' <td scope="row">'.$row->res_code.'</td>';
                      $b=$b.'  <td scope="row">'.get_branch_name($row->branch_code).'</td>';
                      $b=$b.'  <td> '.$row->project_name .'</td>';
                       $b=$b.' <td>'.$row->lot_number.' '.$row->plan_sqid .'</td>';
                       $b=$b.' <td>'.$row->first_name.' '.$row->last_name .'</td>';
                       $b=$b.'  <td>'.$row->res_date.'</td>';
                        $b=$b.' <td>'.number_format($row->seling_price,2).'</td>';
                        $b=$b.'   <td>'.number_format($row->discount,2).'</td>';
                       $b=$b.' <td>'.number_format($row->discounted_price,2).'</td>';
                       
                      $b=$b.' <td align="right">'.number_format($row->min_down,2).'</td>';
                      $b=$b.'  <td align="right">'.number_format($row->down_payment,2).'</td>';
                       $b=$b.'  </tr> ';
                        
                              
								$prjes=$prjes+$row->seling_price;
								$prjdis=$prjdis+$row->discount;
								$prjsale=$prjsale+$row->discounted_price;
								$prjmdp=$prjmdp+$row->min_down;
								$prjpaid=$prjpaid+$row->down_payment;
								$prjbmdp=$prjbmdp+($row->min_down-$row->down_payment);
								$prj_id=$row->prj_id;
								$brnes=$brnes+$row->seling_price;
								$brndis=$brndis+$row->discount;
								$brnsale=$brnsale+$row->discounted_price;
								$brnmdp=$brnmdp+$row->min_down;
								$brnpaid=$brnpaid+$row->down_payment;
								$brnbmdp=$brnbmdp+($row->min_down-$row->down_payment);
								$brid=$row->branch_code;
								
								
								
								  }} 
                                 $b=$b.'    <tr bgcolor="#b0d2fc" style="font-weight:bold"> ';
                       $b=$b.' <td scope="row" colspan="6">Project Total</td>';
                       $b=$b.'  <td>'.number_format($prjes,2).'</td>';
                       $b=$b.'    <td>'.number_format($prjdis,2).'</td>';
                       $b=$b.' <td>'.number_format($prjsale,2).'</td>';
                       
                       $b=$b.' <td align="right">'.number_format($prjmdp,2).'</td>';
                       $b=$b.' <td align="right">'.number_format($prjpaid,2).'</td>';
                        $b=$b.' </tr> ';
                         
                         $b=$b.' <tr bgcolor="#eaf71f"style="font-weight:bold">'; 
                       $b=$b.' <td scope="row" colspan="6">Branch Total</td>';
                        $b=$b.' <td>'.number_format($brnes,2).'</td>';
                         $b=$b.'  <td>'.number_format($brndis,2).'</td>';
                       $b=$b.' <td>'.number_format($brnsale,2).'</td>';
                       
                       $b=$b.' <td align="right">'.number_format($brnmdp,2).'</td>';
                        $b=$b.'<td align="right">'.number_format($brnpaid,2).'</td>';
                       $b=$b.'  </tr> 
                          </tbody></table> '; 
               	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Outrightlist-Report.xls");
	echo $b;