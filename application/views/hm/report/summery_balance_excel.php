
 <?
 if($month!=''){
  $heading2=' Balance Summery Report ';
 }
 else{
   $heading2='  Balance Summery Report  ';
 }
  $b='';
 $b=$b.'
                     
      <table  border="1"  width="100%"><tr bgcolor="#dad1cb"><th >Project Name</th><th>Inventory</th><th >DP Debtor</th><th >ZEP Debtor</th>
      <th >EP Debtor</th><th >EPB Debtor</th><th >Total Debtor</th>
        </tr>
        </tr>';
       
       
    
	
	
	if($prjlist){$fulldbdebtor=0;$fullzepdebtor=0;$fullnepdebtor=0;$fullepbdebtor=0; $fulltot=0; $fullinventory=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			$stock=$lots[$prjraw->prj_id]+$soldlots[$prjraw->prj_id];
			$dbdebtor=$advancelist[$prjraw->prj_id];
			$zepdebtor=$zeplist[$prjraw->prj_id];
			$nepdebtor=$eplist[$prjraw->prj_id];
			$epbdebtor=$epblist[$prjraw->prj_id];
			$prjtot=$dbdebtor+$nepdebtor+$epbdebtor+$zepdebtor;
			$fulldbdebtor=$fulldbdebtor+$dbdebtor;
			$fullnepdebtor=$fullnepdebtor+$nepdebtor;
			$fullepbdebtor=$fullepbdebtor+$epbdebtor;
			$fullinventory=$fullinventory+$stock;
			$fulltot=$fulltot+$prjtot;
			$fullzepdebtor=$fullzepdebtor+$zepdebtor;
			
			
       $b=$b.' <tr ><td>'.$prjraw->project_name.'</td>';
          $b=$b.'<td align="right">'.number_format($stock,2).'</td>';
       $b=$b.' <td align="right">'.number_format($dbdebtor,2).'</td>';
	          $b=$b.' <td align="right">'.number_format($zepdebtor,2).'</td>';

       $b=$b.' <td align="right">'.number_format($nepdebtor,2).'</td>';
       $b=$b.' <td  align="right">'.number_format($epbdebtor,2).'</td>';
        
      $b=$b.'  <td align="right">'.number_format($prjtot,2).'</td></tr>';
       
       }}
        
        
      $b=$b.' <tr class="active" style="font-weight:bold"><td>Total</td>';
      $b=$b.'    <td align="right">'.number_format($fullinventory,2).'</td>';
      $b=$b.'  <td align="right">'.number_format($fulldbdebtor,2).'</td>';
	    $b=$b.'  <td align="right">'.number_format($fullzepdebtor,2).'</td>';
      $b=$b.'   <td align="right">'.number_format($fullnepdebtor,2).'</td>';
      $b=$b.'    <td align="right">'.number_format($fullepbdebtor,2).'</td>';
       $b=$b.'   <td align="right">'.number_format($fulltot,2).'</td>';
       
         
      $b=$b.'  </tr>
         </table>';
		  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Balance_summery-Report.xls");
	echo $b;