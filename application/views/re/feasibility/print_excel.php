<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:150%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	//window.print();
	//window.close();
}

</script>
<? 
$projectprice=$details->purchase_price*$details->land_extend;
$b='<table class="table"  >
							  <tr bgcolor="#"><th colspan="4"  align="center" >Feasebility Report on Project '.$details->project_name.'</th>
							</table><br><br>';
 	$b=$b.'						
                                   
                                         <label class="control-label" for="inputSuccess1"><strong> Branch :</strong></label> ';
	               
                     foreach($branchlist as $row){
                   if($row->branch_code==$details->branch_code){ $branch=$row->branch_name; }
                    } 
									
                                   
				$b=$b.$branch.'						
 <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Project Officer :</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> ';
									  
                                     if($officerlist) {foreach ($officerlist as $raw){?>
                  <? if($details->officer_code==$raw->id) $name= $raw->initial.' '.$raw->surname;
                    }}
        
                  	$b=$b.$name.' </div> </div>';
                                  
                                    
									
						$b=$b.' 	</div>
                            
                        </div><br><br>
						   <table class="table" border="1">
							  <tr bgcolor="#bbd8f9"><th colspan="2" align="center" >General Information</th></tr>
                             <tr bgcolor="#CCCCCC"><th colspan="2"  > 1. Details of Ownership</th></tr>';
                   	$b=$b.'  <tr><th width="30%">Land Owner</th><td>'.$details->owner_name.'</td></tr>';
                      	$b=$b.'<tr><th width="30%">Address</th><td>'.$printlnddata->address1.' '.$printlnddata->address1.','.$printlnddata->address3.'</td></tr>';
                            $b=$b.'   <tr > <td height="20"></td></tr>
                              <tr><th colspan="2" bgcolor="#CCCCCC"> 2. Introducer Details</th></tr>';
                          $b=$b.'  <tr><th width="30%">Introducer Name</th><td>'.$printitndata->first_name.' '.$printitndata->last_name.'</td></tr>
                              <tr><th width="30%">Address</th><td>'.$printitndata->address1.','.$printitndata->address1.' ,'.$printitndata->address3.'</td></tr>
                           <tr><th width="30%">Telephone</th><td>'.$printitndata->landphone.'</td></tr>
                             <tr><th width="30%">Owners Expected Price</th><td>'.number_format($details->expect_price*$details->land_extend,2).'</td></tr>
                         <tr><th width="30%">Mode of Payment</th><td></td></tr>
                         <tr > <td height="20"></td></tr>';
                        
						 $arc=floor($details->land_extend / 160);
						 $arcprc=$arc*160;
						 $rds=floor(($details->land_extend-$arcprc)/40);
						 $rdsprch=$rds*40;
						 $balprc=$details->land_extend-($arcprc+$rdsprch);
                         
						
                          $b=$b.'<tr><th colspan="2"bgcolor="#CCCCCC"> 3. Details of Land</th></tr>
                            <tr><th width="30%">Land Extent</th><td> <table  class="table"><tr><td>Acs</td><td>Rds</td><td>Pcs</td></tr>
                                <tr><td>'.$arc.'</td>
                                <td>'.$rds.'</td>
                                <td>'.$balprc.'</td>
                                </tr></table></td></tr>
                                 <tr><th width="30%">Negotiated Price per perch</th><td>'.$details->purchase_price.'</td></tr>
                   			        <tr><th width="30%">Total Extent</th><td>'.$details->land_extend.'</td></tr>
                                       <tr><th width="30%">Extent Road Reservation</th><td>'.$details->road_ways.'</td></tr>
                                       <tr><th width="30%">Extent Other Reservation</th><td>'.$details->other_res.'</td></tr>
                                        <tr><th width="30%">Open Space Reservation</th><td>'.$details->open_space.'</td></tr>
                                          <tr><th width="30%">Total Reservation</th><td>'.$details->unselable_area.'</td></tr>
                                           <tr><th width="30%">Salabale Area</th><td>'.$details->selable_area.'</td></tr>
                        <tr > <td height="20"></td></tr>
                           <tr><th colspan="2"bgcolor="#CCCCCC"> 4. Inventory of Value Items</th></tr>
						     <tr><td colspan="2">     <table class="table"> <thead> <tr> <th >ID</th> <th >Description</th>  <th width="20%">Quantity</th><th width="30%">Total Price </th></tr> </thead>
                        ';
                                $count=1; if($valuse_items){
									  foreach($valuse_items as $raw) {
									   
                                $b=$b.'<tr> <td>'.$raw->id.'</td>
                                   <td>'.$raw->name.'</td>
                                    <td>'.$raw->quontity.'</td>
                                     <td>'.$raw->value.'</td></tr>';
                                    $count++; }}
							
                        
                         
                        $b=$b. '</table></td></tr> </table>
						
						  <table class="table"  >
							  <tr bgcolor="#bbd8f9"><th colspan="2" align="center" > Project Cost Estimation </th>
							  <th colspan="2" align="center" ></th></tr>
                          </table>
							    <table class="table" border="1"> <thead> <tr> <th >Task Code</th> <th >Task Name</th>  <th width="20%">Budget</th><th width="30%">Total </th></tr> </thead>';
                                   
                                  $count=1;$taskid=""; $nettotal=0;if($tasklist){
									    foreach($tasklist as $raw1) {
											  $taskid=$taskid.$raw1->task_id.',';
										}
									  foreach($tasklist as $raw) {
										  if($maintaskdata[$raw->task_id]['maintask'])
										  {
											  $tasktot=$maintaskdata[$raw->task_id]['maintask']->budget;
										  }
										  else
										  $tasktot=0;
										 $nettotal=$nettotal+$tasktot;
										
										  $subidlist="";
									   ?>
                                 
                                   <? if($maintaskdata[$raw->task_id]['prjsubtask']){
									   $mylist=NULL; $count=0;
									   foreach($maintaskdata[$raw->task_id]['prjsubtask'] as $subraw)
									   { $mylist[$count]=$subraw->subtask_id; $subidlist=$subidlist.$subraw->subtask_id.",";
									  
                                   $b=$b. ' <tr  style=" padding:0; margin:0" > <td></td>
                                   <td style=" padding:0; margin:0" >'.$subraw->subtask_code.' - '.$subraw->subtask_name.'</td>
                                   
                                    <td style=" padding:0; margin:0" align="right" >'.number_format($subraw->budget,2).'
                                 </td>
                                     <td> </td></tr>';
                                   
                                    $count++; }
								   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw){
									     if(!in_array($myraw->subtask_id,$mylist)){ $subidlist=$subidlist.$myraw->subtask_id.",";  
                                 $b=$b.'<tr> <td style=" padding:0; margin:0"></td>
                                   <td style="padding:0; margin:0">'.$myraw->subtask_code.' - '.$myraw->subtask_name.'</td>
                                   
                                    <td style="padding:0; margin:0" align="right"> 0</td>
                                     <td> </td></tr>';
                                    }}
								   
								   } else { if($maintaskdata[$raw->task_id]['subtask']){
									   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw){$subidlist=$subidlist.$myraw->subtask_id.",";
									  
                                    $b=$b.'  <tr> <td></td>
                                   <td style=" padding:0; margin:0">'.$myraw->subtask_code.' -'.$myraw->subtask_name.'</td>
                                   
                                    <td style=" padding:0; margin:0" align="right">'.number_format($projectprice,2).'</td>
                                     <td> </td></tr>';
                                    }}}$count++;
								   
								 
								   $b=$b.'  <tr class="info"> <td style=" padding:0; margin:0">'.$raw->task_code.'</td>
                                   <td style=" padding:0; margin:0">'.$raw->task_name.'
                                   </td>
                                   
                                    <td style=" padding:0; margin:0"> </td>
                                     <td style=" padding:0; margin:0" align="right">'.number_format($tasktot,2).'</td></tr>';
								   
								
								    }
								 
								   
								    } 
                                     $b=$b.' <tr class="active" style="font-weight:bold"><td colspan="3">Total</td><td align="right">'.number_format($nettotal,2).'</td></tr>
                                    </table>
							
								
                                   
                                  <table class="table"  >
							  <tr bgcolor="#bbd8f9"><th colspan="2" align="center" >Sales Report </th>
							  <th colspan="4" align="center" ></th></tr>
                          </table> 
                                     
                               
                                 <table class="table">
                             <tr><th  > Branch Name</th><td>'.$branch.'</td>
                             <th > Project Name</th><td>'.$details->project_name.'</td></tr>
                       </table>';
                       
$datetime1 = date_create($details->date_prjcommence);
$datetime2 = date_create($details->date_dvpcompletion);
$interval = date_diff($datetime1, $datetime2);
$dpmonths= $interval->format('%m')+1;
$datetime1 = date_create($details->date_dvpcompletion);
$datetime2 = date_create($details->date_prjcompletion);
$interval = date_diff($datetime1, $datetime2);
$salemonths= $details->period-$dpmonths;

                      $b=$b.'   <table class="table" border="1">
                             <tr><th  width="30%" rowspan="2">Extent</th><td  rowspan="2">PCS</td>
                             <td>Reservation</td><td>Salable</td><td>Total</td></tr>
                             <tr><td>'.$details->unselable_area.'</td><td>'.$details->selable_area.'</td><td>'.$details->land_extend.'</td></tr>
                             <tr><th colspan="2" > Date of Purchase</th><td>'.$details->date_prjcommence.'</td><td>DV Months</td><td>'.$dpmonths.'</td><td rowspan="2">Project Months <br>'.$details->period.'</td></tr>
                              <tr> <th colspan="2" > Selling Starts</th><td>'.$details->date_dvpcompletion.'</td><td>Selling Months</td><td>'.$salemonths.'</td></tr>
                       </table>
                     		
                                   <table class="table" border="1"> <thead> <tr> <th >ID</th> <th >Extent Perch</th>  <th >Perch Price</th><th width="30%">Sales Value </th></tr> </thead>';
                                   $count=1; $tot=0; if($perch_price){
									  foreach($perch_price as $raw) {
										  $tot=$tot+$raw->perches_count*$raw->price;
									   
                               $b=$b.'<tr> <td>'.$raw->id.'</td>
                                   <td>'.$raw->perches_count.'</td>
                                    <td>'.$raw->price.'</td>
                                     <td>'.number_format($raw->perches_count*$raw->price,2).'</td></tr>';
                                     $count++; }
								  
                                   
                                  $b=$b.'  <tr> <th><strong>Total</strong></th>
                                   <th>'.$details->selable_area.'</th><td></td>
                                    <th>'.number_format($tot,2).'</th>
                                    </tr>';
                                    
                                    }
									$b=$b.'</table>
                                    </div>
                                    
                                    </div></div>
                                    
                                    <div class="row">
                                    <div class="col-md-6 validation-grids validation-grids">
                         	<div class="form-body">
                           
            <table class="table" border="1">
                            <tr><td>Outright Sales</td><td>'.$details->outright.'</td></tr>
                             <tr><th> Ep Sales</th><td>'.$details->epsales.'</td></tr>
                         </table>
                          <table class="table"  border="1"> <thead> <tr> <th >ID</th> <th >Down Payment</th>  <th >Percentage</th></tr> </thead>';
                                    $count=1; $tot='';if($dplist){
									  foreach($dplist as $raw) {
										  if($dpdata[$raw->dp_id])
										  $value=$dpdata[$raw->dp_id]->percentage;
										  else
										  $value=0;
										  $tot=$tot+$value;
									   
                                 $b=$b.' <tr> <td>'.$count.'</td>
                                   <td>'.$raw->dp_rate.'</td>
                                    <td>'.$value.'</td>
                                    </tr>';
                                   $count++; }
								
								   
								    } 
									$b=$b.'<tr> <td></td>
                                   <td>Total</td>
                                    <td>'.$tot.'</td>
                                    </tr></table>
                                    
                                    
                                 
                                    
                                  
                         </div>
                         </div>
                            <div class="col-md-6 validation-grids validation-grids-right">
                         	<div class="form-body">
                             <table class="table"><tr><td>
                             <table class="table"  border="1"> <thead>   
                                 
                                   <tr  > <th >Month</th> <th >Percentage</th></tr>
                                     </thead>';
                                   $tot=0; for($i=1; $i<=12; $i++){
									    if($salestime[$i])
									 $val=$salestime[$i]->percentage;
									 else 
									 $val=0;
									 $tot=$tot+$val;
                                 $b=$b.'  <tr>
                                   <td>'.str_pad($i, 2, "0", STR_PAD_LEFT).'</td>
                                    <td>
                                   '.$val.'</td></tr>';
                                    }
                                  
                                 
                                  
                                 
                                
								 
								   
								  $b=$b.' </table>
                                   </td>
                                    <td>
                                     <table class="table table-bordered" border="1"> <thead>   
                                 
                                   <tr  > <th >Month</th> <th >Percentage</th></tr>
                                     </thead>';
                                   for($i=13; $i<=24; $i++){
									    if($salestime[$i])
									 $val=$salestime[$i]->percentage;
									 else 
									 $val=0;
									 $tot=$tot+$val;
                                  $b=$b.' <tr>
                                   <td>'.str_pad($i, 2, "0", STR_PAD_LEFT).'</td>
                                    <td>
                                   '.$val.'</td></tr>';
                                    }
                                  
                                 
                                  $b=$b.'  <tr>
                                   <td>Total</td>
                                    <td>
                                    '.$tot.'</td></tr>
                                 
                                
								 
								   
								   </table>
                                      </td></tr></table>
                            
                           
                                
                                  <table class="table"  >
							  <tr bgcolor="#bbd8f9"><th colspan="2" align="center" >Development  Details </th>
							  <th colspan="4" align="center" ></th></tr>
                          </table> 
                                  
                            
                             <table class="table"  border="1"> <thead> <tr  class="info"> <th  rowspan="2">Task Code</th> <th rowspan="2">Task Name</th>  
                                   <th  colspan="'.$details->period.'" align="center">Months</th>
                                   <th  rowspan="2">Raw Total</th>
                                   </tr> 
                                   <tr  class="info">';
								    for($i=1; $i<=$details->period; $i++){
                                   $b=$b.'<th>'.str_pad($i, 2, "0", STR_PAD_LEFT).'</th>';
                                   }
                                   $b=$b.'</tr>
                                   </thead>';
                                   $count=1;  if($tasklist){
									  foreach($tasklist as $raw) {
										$rawtot=0;
									   
                                 
                                  
								    $b=$b.' <tr style="border-bottom:1px solid #CCC;"> <td style=" padding:0; margin:0">'.$raw->task_code.'</td>
                                   <td style=" padding:0; margin:0"> '.$raw->task_name;
                                  for($i=1; $i<=$details->period; $i++){
									 if($timechart[$raw->task_id][$i])
									 $val=$timechart[$raw->task_id][$i]->percentage;
									 else 
									 $val=0;
									 $rawtot=$rawtot+$val;
									
                                    $b=$b.' <td style=" padding:0; margin:0">'.$val.'</td>';
                                     }
                                   
                                   $b=$b.'   <td style=" padding:0; margin:0">'.$rawtot.'</td> </tr>';
								   
								  
								    }
								 
								   
								    } 
									
									$b=$b.' </table>
                                       
                            </div></div></div>';
                            
                           
$totalsales=$yearvalue[1]['epsales']+$yearvalue[2]['epsales']+$yearvalue[1]['outright']+$yearvalue[2]['outright'];
$totinterest=0;
$totlbliEP=0;
$totlbliBFI=0;

$totlbint=0;
$totbrint=0;
for($i=1; $i<=8; $i++)
{
$totinterest=$totinterest+$yearvalue[$i]['interesttot'];
$totlbliEP=$totlbliEP+$yearvalue[$i]['lbliEP'];
$totlbliBFI=$totlbliBFI+$yearvalue[$i]['lbliBFI'];
$totlbint=$totlbint+$yearvalue[$i]['lbliRED'];
$totbrint=$totbrint+$yearvalue[$i]['intexpBR'];


}
//intexpBR+lbliRED

//$projectcost=$yearvalue[1]['salestax']+$totdpcost;
//WINROWS CHANGE REMOVE SALES TAX FROM PROJECT COST
//$yearvalue[1]['salestax']=0;
$projectcost=$totdpcost-$costofcapital;
//WINROWS CHANGE REMOVE SALES TAX FROM PROJECT COST
//$projectcost=$totdpcost;;

$totfinanceit=0; //$totbrint+$totlbint;
$avgpurchcost=($projectcost)/$details->selable_area;

$avgsellingprice=$saleprice/$details->selable_area;
$avagprofit=$avgsellingprice-$avgpurchcost;
$purchase_price=$details->purchase_price*$details->land_extend;
$market_price=$details->market_price*$details->selable_area;



						
                     
$b=$b.'<br><br><br><br><table class="table"  >
							  <tr bgcolor="#bbd8f9"><th colspan="2" align="center" >Financial Results</th>
							  <th colspan="7" align="center" ></th></tr>
                          </table> <br><br>
         <table class="table table-bordered"  border="1" >
         <tr class="warning"><td colspan="3"><strong>Total OR Sales</strong></td></tr>
          <tr><td><strong>Year 1</strong></td><td align="right">'.number_format($yearvalue[1]['outright'],2).'</td><td></td></tr>
          <tr><td><strong>Year 2</strong></td><td align="right">'.number_format($yearvalue[2]['outright'],2).'</td>
          <td align="right">'.number_format($yearvalue[1]['outright']+$yearvalue[2]['outright'],2).'</td></tr>
          <tr class="warning"><td colspan="3"><strong>Total Ep Sales</strong></td></tr>
          <tr><td><strong>Year 1</strong></td><td align="right">'.number_format($yearvalue[1]['epsales'],2).'</td><td></td></tr>
          <tr><td><strong>Year 2</strong></td><td align="right">'.number_format($yearvalue[2]['epsales'],2).'</td>
          <td align="right">'.number_format($yearvalue[1]['epsales']+$yearvalue[2]['epsales'],2).'</td></tr>';
        
        $b=$b.'  <tr><td></td><td></td>
          <td align="right"><strong>'.number_format($totalsales,2).'</strong></td></tr>
          <tr><td colspan="4" height="50px;">&nbsp;</td></tr>
          <tr><td colspan="2"><strong>Average Selling Price/Perch</strong></td><td align="right">'.number_format($avgsellingprice,2).'</td></tr>
          <tr><td colspan="2"><strong>Average Cost/Perch</strong></td><td align="right">'.number_format($avgpurchcost,2).'</td></tr>
           <tr><td colspan="2"><strong>Average Profit /Perch</strong></td><td align="right">'.number_format($avagprofit,2).'</td></tr>
         </table>
                            
        </div>
    </div><br>
	<table class="table"  >
							  <tr bgcolor="#CCCCCC"><th colspan="4" align="center" >Real Estate Investment</th>
							</table>
  
        <table class="table table-bordered"   border="1">';
		
		
		$projectcostfinance=$totdpcost-$costofcapital;;
		$totcost_with_finance=$totdpcost;
       $profitbeforcost=$totalsales-$projectcostfinance;
       
	   $newprofitbf_persentage=$profitbeforcost/$totalsales*100;
$newprofitaf_persentage=($profitbeforcost-$costofcapital)/$totalsales*100;

	   
           $b=$b.' <tr  class="active"><td ><strong>Total Or Salse</strong></td><td></td><td align="right">'.number_format($totalsales,2).'</td><td></td></tr>
          <tr><td colspan="4"><strong><u>Less</u></strong></td></td></tr>
        
		
		
          <tr><td>Project Cost</td><td></td><td align="right">'.number_format($projectcost-$taxes,2).'</td></tr>';
		  if($taxes_list)
		  { foreach($taxes_list as $raw)
		  {
             $b=$b.'<tr><td>'.$raw->subtask_name.'</td><td></td><td align="right">'.number_format($raw->budget,2).'</td></tr>';
           }}
		  
		  $b=$b.'
          
            <tr><td>Total Cost</td><td></td><td align="right">'.number_format($projectcostfinance,2).'</td></tr>
          <tr><td><strong>RE Profit Before Finance Cost</strong></td><td></td>
          <td align="right">'.number_format($profitbeforcost,2).'</td><td>'.number_format($newprofitbf_persentage,2).'%</td></tr>
            <tr><td colspan="4"><strong><u>Less : Finance Cost</u></strong></td></td></tr>
          <tr><td>Cost Of capital</td><td align="right">'.number_format($costofcapital,2).'</td><td></td><td></td></tr>
           
            <tr><td><strong>RE Profit After Finance Cost</strong></td><td></td><td align="right">'.number_format($profitbeforcost-$costofcapital,2).'</td><td>'.number_format($newprofitaf_persentage,2).'%</td></tr>
            </table>
         
            	              
        </div><table class="table"  >
							  <tr bgcolor="#CCCCCC"><th colspan="4" align="center" >Land Ep Investment</th>
							   </table> 
      ';
               
			     $totlpbeforfin=$profitbeforcost;
               $totlpfin=$totinterest-($totlbliEP+$totlbliBFI);
			   $totlpfinal= $totlpfin+$totlpbeforfin;
		
			   
			  
        $b=$b.'  <table class="table table-bordered" >
       
          <tr  class="active"><td ><strong>Gross E/P Interest</strong></td><td></td><td align="right">'.number_format($totinterest,2).'</td><td></td></tr>
          <tr><td colspan="4"><strong><u>Less</u></strong></td></td></tr>
        
          <tr><td colspan="2">Land Bank Loan Int. relevent to ep Inv.</td><td align="right">'.number_format($totlbliEP,2).'</td></tr>
          <tr><td colspan="2">Branch Fund Int. relevent to ep Inv.</td><td align="right">'.number_format($totlbliBFI,2).'</td><td></td></tr>
          <tr><td  colspan="2">Ep Interest Net Funding Cost </td><td align="right">'.number_format($totlbliEP+$totlbliBFI,2).'</td>
          <td align="right">'.number_format($totinterest-($totlbliEP+$totlbliBFI),2).'</td></tr>
             <tr class="active"><td colspan="2"><strong>Total Profit/Loss after Finance Cost</strong></td><td></td><td align="right">'.number_format($totlpfinal,2).'</td></tr>
            </table>
            	              
        </div> 
        
   </div>
 </div> ';

$beforfinance= $profitbeforcost;
 if($projectcost>0){
 	 $ovrprofoncost=(($beforfinance)/$projectcostfinance)*100;
 }
 else
	$ovrprofoncost=0;
 
 if($totalsales>0)
 $ovrprofonsale=(($beforfinance)/$totalsales)*100;

 else
 $ovrprofonsale=0;
 // echo $ovrprofoncost/$details->period*12;
 $monthOC=$ovrprofoncost/$details->period;
 $monthOS=$ovrprofonsale/$details->period;
 $annumOC= $monthOC*12;
  $annumOS= $monthOS*12;
 
$reprofitafterfin= $profitbeforcost-$costofcapital;
 if($projectcost>0){
	 $afterFINOC=($reprofitafterfin/($totcost_with_finance))*100;
 }
 else
	$afterFINOC=0;
	
	 if($totalsales>0)
 $afterFINOS=($reprofitafterfin/$totalsales)*100;
 
 else
 $afterFINOS=0;
  $monthFINOC=$afterFINOC/$details->period;
 $monthFINOS=$afterFINOS/$details->period;
 $annumFINOC= $monthFINOC*12;
  $annumFINOS= $monthFINOS*12;
 
 

  if($projectcost>0)
		  $REOverallOC=$beforfinance*100/$projectcost;
  else  $REOverallOC=0;
   if($totalsales>0)
   $REOverallOS=$beforfinance*100/$totalsales;
   else
   $REOverallOS=0;
   $REmonthOC=$REOverallOC/$details->period;
   $REmonthOS=$REOverallOS/$details->period;
   $REyearOC=$REmonthOC*12;
    $REyearOS=$REmonthOS*12;
	
	
	 if($projectcost>0)
		  $REAFOverallOC=$totlpbeforfin*100/$projectcost;
	 else  $REAFOverallOC=0;
	 if($totalsales>0)
		  $REAFOverallOS=$totlpbeforfin*100/$totalsales;
	 else  $REAFOverallOS=0;
   
   $REAFmonthOC=$REAFOverallOC/$details->period;
   $REAFmonthOS=$REAFOverallOS/$details->period;
   $REAFyearOC=$REAFmonthOC*12;
    $REAFyearOS=$REAFmonthOS*12;
  
	 
$b=$b.'<br>
        <div class="task-info">
										
        </div>
        
  </div>
  
  
 <table><tr>
 <td>.....................</td>
 <td>.....................</td>
 <td>.....................</td>
 <td>.....................</td></tr>
 <tr><td>'.get_user_fullname_id($useractiondata->update_by).'</td>
 <td>'.get_user_fullname_id($useractiondata->generate_by).'</td>
 <td>'.get_user_fullname_id($useractiondata->checked_by).'</td>
 <td>'.get_user_fullname_id($useractiondata->confirm_by).'</td></tr>
  <tr><td><strong>Update By</strong></td>
  <td><strong>Generate By</strong></td>
  <td><strong>Checked By</strong></td>
  <td><strong>Confirmed By</strong></td><tr></table>';

 
 header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=ProjectReport.xls");
	echo $b;
 ?>