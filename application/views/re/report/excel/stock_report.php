

 <?
 if($month!=''){
  $heading2=' Stock Report as at '.$reportdata;
 }
 else{
   $heading2=' Stock Report as at '.$reportdata;
 }
 
 $b='';
$b=$b.'      <table border="1"  width="100%"><tr><td  align="center"  colspan="7"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><th  rowspan="2">Project Name</th><th  rowspan="2">Lot Number</th>
      <th colspan="2"> Number of Lots to sell</th><th rowspan="2">Stock</th><th rowspan="2">Profit</th><th rowspan="2">Sale Value</th>
        </tr>
        <tr >
        <th class="info">This Month</th>
         <th class="info">Last Month</th>
         </tr>';
       
   
	$fullcost=0;$fullsale=0;$fullprofit=0;$lastlotcount=0;$thislotcount=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjcost=0;$prjsale=0;$prjprofit=0;
			$pendinglastmonth=$lastmont[$prjraw->prj_id]+$pendinglot[$prjraw->prj_id];
			if($reslots[$prjraw->prj_id]) {$pending=$pendinglot[$prjraw->prj_id];
			$pendinglastmonth=$lastmont[$prjraw->prj_id]+count($reslots[$prjraw->prj_id])+$pendinglot[$prjraw->prj_id];
			}
			else $pending=$pendinglot[$prjraw->prj_id];
			
			$thislotcount=$thislotcount+$pending;
			$lastlotcount=$lastlotcount+$pendinglastmonth;
			
       
       if($lotdata[$prjraw->prj_id]){
		   
		   
		   $b=$b.'  <tr class="active"><td>'.$prjraw->project_name.'</td><td></td><td>'.$pending.'</td><td>'.$pendinglastmonth.'</td>';
        
      $b=$b.'   <td></td><td></td><td></td></tr>';
			foreach($lotdata[$prjraw->prj_id] as $raw){
				$prjcost=$prjcost+$raw->costof_sale;
				$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
				$prjsale=$prjsale+$raw->sale_val;
				
        $b=$b.' <tr ><td></td><td>'.$raw->lot_number.'</td><td></td><td></td>';
         $b=$b.'<td align="right">'.number_format($raw->costof_sale,2).'</td>';
         $b=$b.' <td align="right">'.number_format($raw->sale_val-$raw->costof_sale,2).'</td>';
          $b=$b.' <td align="right">'.number_format($raw->sale_val,2).'</td>';
        $b=$b.' </tr>';
        }}
         if($reslots[$prjraw->prj_id]){
			foreach($reslots[$prjraw->prj_id] as $raw){
				$prjcost=$prjcost+$raw->costof_sale;
				$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
				$prjsale=$prjsale+$raw->sale_val;
       $b=$b.' <tr class="info"><td></td><td>'.$raw->lot_number.'</td><td></td><td></td>';
       $b=$b.' <td align="right">'.number_format($raw->costof_sale,2).'</td>';
       $b=$b.'  <td align="right">'.number_format($raw->sale_val-$raw->costof_sale,2).'</td>';
         $b=$b.' <td align="right">'.number_format($raw->sale_val,2).'</td>';
       $b=$b.' </tr>';
         }}
		$fullcost=$fullcost+$prjcost;
		$fullprofit=$fullprofit+$prjprofit;
		$fullsale=$fullsale+$prjsale;
		if($prjcost>0){
       $b=$b.'  <tr class="active"><td></td><td></td><td></td><td></td>';
      $b=$b.'  <td align="right">'.number_format($prjcost,2).'</td>';
        $b=$b.' <td align="right">'.number_format($prjprofit,2).'</td>';
       $b=$b.'   <td align="right">'.number_format($prjsale,2).'</td>';
      $b=$b.'  </tr>';}
        
      }}
      $b=$b.' <tr class="active" style="font-weight:bold"><td></td><td></td><td>'.$thislotcount.'</td><td>'.$lastlotcount.'</td>';
      $b=$b.'  <td align="right">'.number_format($fullcost,2).'</td>';
     $b=$b.'    <td align="right">'.number_format($fullprofit,2).'</td>';
     $b=$b.'    <td align="right">'.number_format($fullsale,2).'</td>';
    $b=$b.'    </tr>';
     $b=$b.'    </table>';
	 ob_end_clean();
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Profit_Summery_Report.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	ob_end_clean();
	echo $b;