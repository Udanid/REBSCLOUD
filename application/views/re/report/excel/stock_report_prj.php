

 <?
 if($month!=''){
  $heading2=' Stock Report as at '.$reportdata;
 }
 else{
   $heading2=' Stock Report as at '.$reportdata;
 }
 
  $heading2=' Profit Summery Report as at ';

 $b='';
                     
  $b=$b.'     <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><th  rowspan="2">Project Name</th><th  rowspan="2">Lot Number</th>
      <th colspan="2"> Number of Lots to sell</th><th rowspan="2">Stock</th><th rowspan="2">Profit</th><th rowspan="2">Sale Value</th>
        </tr>
        <tr >
        <th class="info">This Month</th>
         <th class="info">Last Month</th>
         </tr>';
       
  
	$fullcost=0;$fullsale=0;$fullprofit=0;$lastlotcount=0;$thislotcount=0;
	
				//echo $prjraw->prj_id;
			$prjcost=0;$prjsale=0;$prjprofit=0;
			$pendinglastmonth=$lastmont[$prj_id]+$pendinglot[$prj_id];
			if($reslots[$prj_id]) {$pending=$pendinglot[$prj_id];
			$pendinglastmonth=$lastmont[$prj_id]+count($reslots[$prj_id])+$pendinglot[$prj_id];
			}
			else $pending=$pendinglot[$prj_id];
			
			$thislotcount=$thislotcount+$pending;
			$lastlotcount=$lastlotcount+$pendinglastmonth;
		
     $b=$b.'   <tr class="active"><td>'.$details[$prj_id]->project_name.'</td><td></td><td>'.$pending.'</td><td>'.$pendinglastmonth.'</td>
        
        <td></td><td></td><td></td></tr>';
        if($lotdata[$prj_id]){
			foreach($lotdata[$prj_id] as $raw){
				$prjcost=$prjcost+$raw->costof_sale;
				$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
				$prjsale=$prjsale+$raw->sale_val;
			
    $b=$b.'    <tr><td></td><td>'.$raw->lot_number.'</td><td></td><td></td>';
     $b=$b.'   <td align="right">'.number_format($raw->costof_sale,2).'</td>';
      $b=$b.'   <td align="right">'.number_format($raw->sale_val-$raw->costof_sale,2).'</td>';
     $b=$b.'     <td align="right">'.number_format($raw->sale_val,2).'</td>';
     $b=$b.'   </tr>';
     }}
        if($reslots[$prj_id]){
			foreach($reslots[$prj_id] as $raw){
				$prjcost=$prjcost+$raw->costof_sale;
				$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
				$prjsale=$prjsale+$raw->sale_val;
        $b=$b.'<tr><td></td><td>'.$raw->lot_number.'</td><td></td><td></td>';
        $b=$b.'<td align="right">'.number_format($raw->costof_sale,2).'</td>';
         $b=$b.'<td align="right">'.number_format($raw->sale_val-$raw->costof_sale,2).'</td>';
          $b=$b.'<td align="right">'.number_format($raw->sale_val,2).'</td>';
        $b=$b.'</tr>';
         }}
		$fullcost=$fullcost+$prjcost;
		$fullprofit=$fullprofit+$prjprofit;
		$fullsale=$fullsale+$prjsale;
		
        $b=$b.' <tr class="active"><td></td><td></td><td></td><td></td>';
        $b=$b.'<td align="right">'.number_format($prjcost,2).'</td>';
        $b=$b.' <td align="right">'.number_format($prjprofit,2).'</td>';
        $b=$b.'  <td align="right">'.number_format($prjsale,2).'</td>';
        $b=$b.'</tr>';
        
     
        $b=$b.' </table>';
	ob_end_clean();
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Profit_Summery_Report.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	ob_end_clean();
	echo $b;