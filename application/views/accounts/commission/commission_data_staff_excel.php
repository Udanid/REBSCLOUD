
 <?
$b='';
  $b=$b.' <table  border="1"> <thead> <tr bgcolor="#d8d8d8"> <th>Project Name</th> ';
    $staftot=NULL; if($staffsummery){foreach($staffsummery as $stfraw){$staftot[$stfraw->emp_id]=0;
	   
    $b=$b.' <th>'.$stfraw->surname.'</th>';
    }}
    $b=$b.'  <th class="active">Project Total</th>';
  $b=$b.'</tr> </thead>';
                       $prj_tot=0;$prjid='';$tot=0;$ids=''; if($projectsummery){$c=0;
                          foreach($projectsummery as $row){
							  if($prjid!='' & $prjid!=$row->project_name){
							
                              
                               $prj_tot=0; }
							 
							  
                          
                      
                        $b=$b.' <tbody> <tr > ';
                       $b=$b.'  <td scope="row">'.$row->project_name.'</td> ';
                          if($staffsummery){foreach($staffsummery as $stfraw){ $amt=0;
							 if($staffdata[$stfraw->emp_id][$row->project_id])
							 {
								 $amt=$staffdata[$stfraw->emp_id][$row->project_id]->tot;
							 }
							 $staftot[$stfraw->emp_id]=$staftot[$stfraw->emp_id]+$amt;
							 
                        $b=$b.' <td align="right">'.number_format($amt,2) .' </td>';
                               }}
                                $b=$b.' <td class="active" align="right" style=" font-weight:bold">'.number_format($row->current_comm,2).'</td>
                         </tr> ';
                        
                                 }} 
                         
                    $b=$b.' <tr  bgcolor="#ffd3ff"  style="font-weight:bold">'; 
                      $b=$b.'  <th scope="row" >'.$prjid.' Total</td>';
                       
                              $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
								  $staftot=$staftot+$stfraw->month_add;
	   
    $b=$b.' <td align="right">'.number_format($stfraw->month_add,2).'</th>';
   }}  $b=$b.'<td align="right">'.number_format($staftot,2).'</th>';
                        $b=$b.'  </tr> 
                          <tr  bgcolor="#ade3d7" style="font-weight:bold"> 
                        <th scope="row"> This Month Deductions</td>';
                       
                           $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
							  $staftot=$staftot+$stfraw->month_deduct
;	   
    $b=$b.' <td align="right">'.number_format($stfraw->month_deduct,2).'</th>';
    }}$b=$b.' <td align="right">'.number_format($staftot,2).'</th>';
                       $b=$b.'  </tr> 
                           <tr bgcolor="#ff9ed9"  style="font-weight:bold"> 
                        <th scope="row"> Previous Month Deductions</td>';
                       
                          $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
							    $staftot=$staftot+$stfraw->prev_deduct;
	   
   $b=$b.' <td align="right">'.number_format($stfraw->prev_deduct,2).'</th>';
   }}$b=$b.'<td align="right">'.number_format($staftot,2).'</th>';
                    $b=$b.'     </tr> 
                             <tr bgcolor="#e597ff"  style="font-weight:bold"> 
                        <th scope="row"> Total</td>';
                       
                           $staftot=0; if($staffsummery){foreach($staffsummery as $stfraw){
							  $staftot=$staftot+$stfraw->amount;
	   
   $b=$b.' <td align="right">'.number_format($stfraw->amount ,2).'</th>';
    }}$b=$b.'<td align="right">'.number_format($staftot,2).'</th>';
                     $b=$b.'    </tr> 
                     </tbody></table>';
                      
                  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=commission_details-Report_".$year."_".$month.".xls");
	echo $b;