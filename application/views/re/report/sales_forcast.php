
<script type="text/javascript">

function load_printscrean1(branch,month,type,year)
{
			window.open( "<?=base_url()?>re/report_excel/get_forcast_report/"+branch+"/"+month+"/"+type+"/"+year );
	
}

</script>
<style type="text/css">

</style>
 <?
 if($month!=''){
  $heading2=' Collection Forcast Report -  as at '.date('Y-m-d');
 }
 else{
   $heading2=' Collection Forcast Report - as at'.date('Y-m-d');
 }
 $date=date('Y-m-d');
 $week1end=$start=date('Y-m-d',strtotime('+7 days',strtotime($sartdate)));
 $week2end=$start=date('Y-m-d',strtotime('+14 days',strtotime($sartdate)));
 $week3end=$start=date('Y-m-d',strtotime('+21 days',strtotime($sartdate)));
 $week4end=$start=date('Y-m-d',strtotime('+28 days',strtotime($sartdate)));
 $week5end=$reportdata;
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
      <span style="float:right"> <a href="javascript:load_printscrean1('<?=$branchid?>','<?=$month?>','<?=$type?>','<?=$year?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      
  <tr><th>  Project Name</th><th> Loan Code</th><th>Lot number</th><th>Customer Name</th><th>Start Date</th><th>End Date</th><th>Closing  Balance</th><th>Collection Date</th><th>Forcast Collection</th><th>Collection</th><th>%</th><th>Variance</th></tr>

       
       <? $fulltot=0;
	   $brforcast=0;$bractual=0;$brbal=0;
	    $fullforcast=0;$fullactual=0;$fullbal=0;
		$Currentofficercode='';
		 $totcode=''; $branch_code='';
		$branch_code='';
		$prjforcast=0;$prjactual=0;$prjbal=0;
	   ?>
       
       <? if($prjlist){foreach($prjlist  as $prraw){
			
			
			?>
        <?  if($transferlist[$prraw->prj_id]){
			 ?> 
  	<?
			foreach($transferlist[$prraw->prj_id] as $raw){
			
	?>
	
	
	<?
	$collection=0;$Collection_date='';$paid=0;$totint=0;$thiscollection=0;
	if($monthtarget[$raw->loan_code])
	{
	$collection=$monthtarget[$raw->loan_code]->collection;
	$Collection_date=$monthtarget[$raw->loan_code]->Collection_date;
	}
	if($paidtots[$raw->loan_code])
	{
		$paid=$paidtots[$raw->loan_code]->totcap+$paidtots[$raw->loan_code]->totint;
	}
	if($thismonthpay[$raw->loan_code])
	{
		$thiscollection=$thismonthpay[$raw->loan_code]->totcap+$thismonthpay[$raw->loan_code]->totint;
	}
	if($raw->loan_type=='NEP')
	{
	$lastdate=get_eploan_last_date($raw->loan_code,$raw->reschdue_sqn);
	$stdate=get_eploan_first_date($raw->loan_code,$raw->reschdue_sqn);
	$loantatals=get_eploan_tot($raw->loan_code,$date,$raw->reschdue_sqn);
		if($loantatals) $totint=$loantatals->totint;
		$arrtot=0;
		if($arrears[$raw->loan_code])
		$arrtot=$arrears[$raw->loan_code]->arriastot;
		$balance=$arrtot-$paid+(get_loan_date_di($raw->loan_code,$date))+$raw->montly_rental;
		if($balance<0)$balance=0;
	}
	else
	{
		 $lastdate=date('Y-m-d',strtotime('+'.intval($raw->period).' months',strtotime($raw->start_date)));
		 $stdate=$raw->start_date;
		 	$balance=$raw->loan_amount+$totint-$paid+(get_loan_date_di($raw->loan_code,$date));

	}
	$presentage=0;
	if($collection>0)
	$presentage=($thiscollection/$collection)*100;
	$variance=$collection-$thiscollection;
	if($raw->loan_status=='CONFIRMED' || $thiscollection>0){
	?>
     <? if($totcode!='' & $totcode!=$prraw->project_name){
				    	
				   ?>
          					   <tr  class="info" style="font-weight:bold"><td colspan="6">Project Total</td>
                                 <td align="right"><?=number_format($prjbal,2)?></td>
                                  <td></td>
         					   <td align="right"><?=number_format($prjforcast,2)?></td>
                              
          						  <td align="right"><?=number_format($prjactual,2)?></td>
                                   <td></td>
                                     <td><?=number_format($prjforcast-$prjactual,2)?></td>
           							 </tr>
                 <? $prjforcast=0;$prjactual=0;$prjbal=0; }?>
                   <? if($branch_code!='' & $branch_code!=$prraw->branch_code){
				    	
				   ?>
          					   <tr  class="yellow" style="font-weight:bold"><td colspan="6"><?=get_branch_name($branch_code)?> Branch Total</td>
                                 <td align="right"><?=number_format($brbal,2)?></td>
                                  <td></td>
         					   <td align="right"><?=number_format($brforcast,2)?></td>
                              
          						  <td align="right"><?=number_format($bractual,2)?></td>
                                   <td></td>
                                     <td><?=number_format($brforcast-$bractual,2)?></td>
           							</tr>
                 <? $brforcast=0;$bractual=0;$brbal=0; }?>
                 
                 
                  <?
		   if($Currentofficercode!=$prraw->officer_code){
		$Currentofficercode=$prraw->officer_code;
		    ?> 
            <tr  class="active" style="font-weight:bold"><td><?= $prraw->officer_code?></td><td><?= $prraw->initial?> <?=$prraw->surname?></td>
            <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr>
            <?  } ?>
    
    
    <tr>
    <td><?=$details[$prraw->prj_id]->project_name?></td>
<td><?=$raw->unique_code?></td>
<td><?=$raw->lot_number?> </td>
<td><?=$raw->first_name?> <?=$raw->last_name?> </td>
<td><?=$stdate?> </td>
<td><?=$lastdate?> </td>

<td  align="right" ><?=number_format($balance,2)?> </td>
 <td ><?=$Collection_date?></td>
<td  align="right" > <?=number_format($collection,2)?></td>
<td   align="right" > <?=number_format($thiscollection,2)?></td>
<td   align="right" > <?=number_format($presentage,2)?></td>
<td   align="right" > <?=number_format($variance,2)?></td>
 
  </td>
  <tr>

        <? 
		$totcode=$prraw->project_name;
	  $branch_code=$prraw->branch_code;
	 $prjforcast=$prjforcast+$collection;
	  $prjactual=$prjactual+$thiscollection;
	  $prjbal=$prjbal+$balance;
	  
	 $brforcast=$brforcast+$collection;
	 $bractual=$bractual+$thiscollection;
	 $brbal=$brbal+$balance;
	//  $fullforcast=0;$fullactual=0;$fullbal=0;
	  
	  $fullforcast=$fullforcast+$collection;
	  $fullactual=$fullactual+$thiscollection;
	  $fullbal=$fullbal+$balance;
		}}}}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltots;
	  
	  
	  ?>
        <tr  class="info" style="font-weight:bold"><td colspan="6">Project Total</td>
                                 <td align="right"><?=number_format($prjbal,2)?></td>
                                  <td></td>
         					   <td align="right"><?=number_format($prjforcast,2)?></td>
                              
          						  <td align="right"><?=number_format($prjactual,2)?></td>
                                   <td></td>
                                     <td><?=number_format($prjforcast-$prjactual,2)?></td>
           							</tr>
               
          					   <tr  class="yellow" style="font-weight:bold"><td colspan="6"><?=get_branch_name($branch_code)?> Branch Total</td>
                                 <td align="right"><?=number_format($brbal,2)?></td>
                                  <td></td>
         					   <td align="right"><?=number_format($brforcast,2)?></td>
                              
          						  <td align="right"><?=number_format($bractual,2)?></td>
                                   <td></td>
                                     <td><?=number_format($brforcast-$bractual,2)?></td>
           							 </tr>
               
      
     <tr  class="yellow" style="font-weight:bold"><td colspan="6"><?=get_branch_name($branch_code)?> Branch Total</td>
                                 <td align="right"><?=number_format($fullbal,2)?></td>
                                  <td></td>
         					   <td align="right"><?=number_format($fullforcast,2)?></td>
                              
          						  <td align="right"><?=number_format($fullactual,2)?></td>
                                   <td></td>
                                     <td><?=number_format($fullforcast-$fullactual,2)?></td>
           							 </tr>
         </table></div>
    </div> 
    
</div>