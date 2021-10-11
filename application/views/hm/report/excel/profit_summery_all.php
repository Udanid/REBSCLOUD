
<script type="text/javascript">

function load_printscrean1(prjid,month)
{
			window.open( "<?=base_url()?>hm/report/get_profit_all_print/"+prjid+"/"+month );
	
}
function load_printscrean1(branchid,prjid,month)
{
			window.open( "<?=base_url()?>hm/report/get_profit_all_print/"+branchid+"/"+prjid+"/"+month );
	
}

</script>
 <?
 if($month!=''){
 $heading=date('F', mktime(0, 0, 0, intval($month), 10)). ' Month Profit Realization Summery';
  $heading2=date('F', mktime(0, 0, 0, intval($month), 10)). ' Month Profit Realization Details';
 }
 else{
 $heading='Profit Realization Summery of Current Finance Year';
  $heading2='Profit Realization Details of Current Finance Year';
 }
 
  if($prjlist){$counter=0;
		foreach($prjlist as $prjraw){
        $lable[$counter]=$prjraw->project_name;
		$profit[$counter]=0;
		$sale[$counter]=0;
		if($month!=''){
   if($transferlist[$prjraw->prj_id][$month]){
			$sale[$counter]=$transferlist[$prjraw->prj_id][$month]->selstot;
			$profit[$counter]=$transferlist[$prjraw->prj_id][$month]->selstot-$transferlist[$prjraw->prj_id][$month]->costtot;
					}}
	else
		{
			if(isset($fromdate))
			$start=$fromdate;
			else
			$start=date($this->session->userdata('fy_start'));
			if(isset($todate))
			$end=$todate;
			else
				$end=date('Y-m-d');
				while($start<=$end)
				{ 
					$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$stdate=$year.'-'.$month2.'-01';
					$enddate=$year.'-'.$month2.'-31';
					$profit[$counter]=$profit[$counter]+$transferlist[$prjraw->prj_id][$month2]->selstot-$transferlist[$prjraw->prj_id][$month2]->costtot;
					$sale[$counter]=$sale[$counter]+$transferlist[$prjraw->prj_id][$month2]->selstot;
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					
				}
		}
		$fullsale[$counter]=$projecttots[$prjraw->prj_id]->totsale;
		$fullprofit[$counter]=$projecttots[$prjraw->prj_id]->totsale-$projecttots[$prjraw->prj_id]->totcost;
        $counter++;
		}
		
		$js_label=json_encode($lable);
				$js_sale=json_encode($sale);
				$js_profit=json_encode($profit);
				$js_fullsale=json_encode($fullsale);
				$js_fullprofit=json_encode($fullprofit);
		
		}
		
		
		
      
                     
     $b='';
$b=$b. ' <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><th>Project Name</th>';
       $counter=0; if($month!=""){ $counter=1;$projectsale1[0]=0;
					$projectcost1[0]=0;
      $b=$b. '   <th colspan="2">'.date('F', mktime(0, 0, 0, intval($month), 10)).'</th>';
       }else{
        	if(isset($fromdate))
			$start=$fromdate;
			else
			$start=date($this->session->userdata('fy_start'));
			if(isset($todate))
			$end=$todate;
			else
				$end=date('Y-m-d');
				
				while($start<=$end)
				{ 
				$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$projectsale1[$counter]=0;
					$projectcost1[$counter]=0;
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					$counter++;
			
                
                   $b=$b. ' <th colspan="2" >'.date('F', mktime(0, 0, 0, $month2, 10)).'</th>';
                
				}
				     $b=$b. ' <th colspan="2" >Total</th>';
         }
      $b=$b.'   </tr>';
         $b=$b.'<tr ><td></td>';
        for($i=0; $i<$counter; $i++){
        $b=$b.'<th class="info">Total Sale</th>
         <th class="info">Total Profit</th>';
         }
		 if($counter>1){
		  $b=$b.'<th class="info">Total Sale</th>
         <th class="info">Total Profit</th>';}
      $b=$b.'  </tr>';
       
    
	
	
	if($prjlist){
		foreach($prjlist as $prjraw){
       $b=$b.' <tr><td>'.$prjraw->project_name.'</td>';
         if($month!=""){
			 if($transferlist[$prjraw->prj_id][$month]->selstot) $sale=$transferlist[$prjraw->prj_id][$month]->selstot;else $sale=0;
					if($transferlist[$prjraw->prj_id][$month]->costtot)$cost=$sale-$transferlist[$prjraw->prj_id][$month]->costtot ;else $cost=0;
				 $projectsale1[0]= $projectsale1[0]+$sale;
					  $projectcost1[0]= $projectcost1[0]+$cost;
			
       $b=$b.' <td  align="right">'.number_format($sale,2).'</td>';
          $b=$b.' <td align="right" >'.number_format($cost,2).'</td>';
         }else{
        	if(isset($fromdate))
			$start=$fromdate;
			else
			$start=date($this->session->userdata('fy_start'));
			if(isset($todate))
			$end=$todate;
			else
				$end=date('Y-m-d');
				$counter=0;
				$rawsale=0;$rawcost=0;
				
				while($start<=$end)
				{ 
				$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					if($transferlist[$prjraw->prj_id][$month2]->selstot) $sale=$transferlist[$prjraw->prj_id][$month2]->selstot;else $sale=0;
					if($transferlist[$prjraw->prj_id][$month2]->costtot)$cost=$sale-$transferlist[$prjraw->prj_id][$month2]->costtot ;else $cost=0;
					$projectsale1[$counter]= $projectsale1[$counter]+$sale;
					  $projectcost1[$counter]= $projectcost1[$counter]+$cost;
					$rawsale=$rawsale+$sale;
					$rawcost=$rawcost+$cost;
					
                    $b=$b.'  <td align="right" >'.number_format($sale,2).'</td>';
           $b=$b.'<td  align="right">'.number_format($cost,2).'</td>';
                    
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					$counter++;
				
                
                
                
				}
			  $b=$b.'	 <td align="right" >'.number_format($rawsale,2).'</td>';
            $b=$b.' <td  align="right">'.number_format($rawcost,2).'</td>';
         }
     $b=$b.'</tr>';
        
        
         }}
		 
		$b=$b.'  <tr ><td ></td>';
         $totsale=0;$totprofit=0; for($i=0; $i<$counter; $i++){
        $b=$b.'<td class="info" align="right">'.number_format($projectsale1[ $i],2).'</td>';
        $b=$b.' <td class="info" align="right">'.number_format($projectcost1[ $i],2).'</td>';
         $totsale=$totsale+$projectsale1[ $i];
		$totprofit=$totprofit+$projectcost1[ $i];
		}
		if($counter>1){
        $b=$b.' <td class="info" align="right">'.number_format($totsale,2).'</td>';
        $b=$b.' <td class="info" align="right">'.number_format($totprofit,2).'</td>';
       $b=$b.' </tr>';}
         $b=$b.'</table>';
header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Profit_realization-Report.xls");
	echo $b;