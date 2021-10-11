
 <?
 if($month!=''){
  $heading2='PO Summary Report -  as at '.$reportdata;
 }
 else{
   $heading2=' PO Summary Report- as at'.$reportdata;
 }
 

 $b='';
                     
  $b=$b.' 
         

                     
     <table border="1"  width="100%"><tr><td  align="center"  colspan="6"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9">
                
     <th>No</th><th>Officer Name</th><th>Project</th><th>Target</th><th>Actual</th><th>Variance</th><th>%</th>
   </tr>';
       
       $fulltot=0; $Currentofficercode=''; $otarget=0; $oactual=0; $tottarget=0; $totactual=0; $totcode=''; $branch_code='';$brtarget=0; $bractual=0; ?>
       
       <? if($prjlist){foreach($prjlist  as $prraw){
		   $actual=0;   if($totadvance[$prraw->prj_id])
			   $actual=$actual+$totadvance[$prraw->prj_id]->tot;
			   if($totcapital[$prraw->prj_id])
			   {
				    $actual=$actual+$totcapital[$prraw->prj_id]->captot+$totcapital[$prraw->prj_id]->inttot;
			   }
			  if($target[$prraw->prj_id]>0)
			  $presentage=$actual/$target[$prraw->prj_id]*100;
			  else
			  $presentage=0;
			  
			     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
			   ?>
			   
			   <? if($totcode!='' & $totcode!=$prraw->officer_code){
				     if( $otarget>0)
			  $opresentage=$oactual/ $otarget*100;
			  else
			  $opresentage=0;
				     if($opresentage>=60) $class='green'; else if($opresentage<60 && $opresentage>=50)  $class='blue'; else if($opresentage<50 && $opresentage>=25)  $class='yellow'; else $class='red';
				   
             $b=$b.' <tr  class="info" style="font-weight:bold"><td colspan="3">Total</td>';
            $b=$b.' <td align="right">'.number_format($otarget,2).'</td><td align="right">'.number_format($oactual,2).'</td><td align="right">'.number_format($otarget-$oactual,2).'</td></tr>';
             $oactual=0; $otarget=0; }?>
            <? if($branch_code!='' & $branch_code!=$prraw->branch_code){
				     if( $brtarget>0)
			  $bpresentage=$bractual/ $brtarget*100;
			  else
			  $bpresentage=0;
				     if($bpresentage>=60) $class='green'; else if($bpresentage<60 && $bpresentage>=50)  $class='blue'; else if($bpresentage<50 && $bpresentage>=25)  $class='yellow'; else $class='red';
				   
           $b=$b.'   <tr  class="warning" style="font-weight:bold"><td colspan="3">'.get_branch_name($branch_code).'Branch Total</td>
            <td align="right">'.number_format($brtarget,2).'</td><td align="right">'.number_format($bractual,2).'</td><td align="right">'.number_format($brtarget-$bractual,2).'</td></tr>';
              $bractual=0; $brtarget=0; } ?>
			   
			   
			   <?
		   if($Currentofficercode!=$prraw->officer_code){
		$Currentofficercode=$prraw->officer_code;
		     
             $b=$b.'<tr  class="active" style="font-weight:bold"><td>'.$prraw->officer_code.'</td><td>'.$prraw->initial.' '.$prraw->surname.'</td>';
             $b=$b.'<td></td><td></td><td></td><td></td></tr>';
              } 
     $b=$b.'<tr><td></td><td></td><td>'.$prraw->project_name.'</td><td align="right">'.number_format($target[$prraw->prj_id],2).'</td>
    <td align="right">'.number_format($actual,2).'</td> <td align="right">'.number_format($target[$prraw->prj_id]-$actual,2).'</td>
    </tr>';
	
	
       $totcode=$prraw->officer_code;
	  $branch_code=$prraw->branch_code;
	   $otarget=$otarget+$target[$prraw->prj_id];
	    $brtarget=$brtarget+$target[$prraw->prj_id];
		 $bractual=$bractual+ $actual;
			   $oactual=$oactual+ $actual;
			   $totactual=$totactual+$actual;
			    $tottarget=$tottarget+$target[$prraw->prj_id];
	//  $fulltot=$fulltot+$prjexp;
	   }}
	    if( $otarget>0)
			  $opresentage=$oactual/ $otarget*100;
			  else
			  $opresentage=0;
				     if($opresentage>=60) $class='green'; else if($opresentage<60 && $opresentage>=50)  $class='blue'; else if($opresentage<50 && $opresentage>=25)  $class='yellow'; else $class='red';
	  
	
     $b=$b.'    <tr  class="info" style="font-weight:bold"><td colspan="3">Total</td>
            <td align="right">'.number_format($otarget,2).'</td><td align="right">'.number_format($oactual,2).'</td><td align="right">'.number_format($otarget-$oactual,2).'</td></tr>';
                                           $b=$b.'<tr class="warning" style="font-weight:bold"><td colspan="3"> '.get_branch_name($branch_code).' Branch Total </td>
            <td align="right">'.number_format($brtarget,2).'</td><td align="right">'.number_format($bractual,2).'</td><td align="right">'.number_format($brtarget-$bractual,2).'</td></tr>
      <tr class="active" style="font-weight:bold">
         <td align="right">Total </td>
          <td align="right"></td>
           <td align="right"></td>';
            $b=$b.'<td align="right">'.number_format($tottarget,2).'</td>';
            $b=$b.'<td align="right">'.number_format($totactual,2).'</td>';
            $b=$b.'<td align="right">'.number_format($tottarget-$totactual,2).'</td>';
           $b=$b.' <td align="right"></td>
            </tr>
         </table>';
		 
		 
 	    //  header("Content-type: application/vnd.ms-excel");
	//header("Content-Disposition: attachment;Filename=Sales_forcast_report.xls");
	echo $b;