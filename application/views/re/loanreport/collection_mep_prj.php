<script type="text/javascript">

function export_excel(prj_id,type,stdate,enddate)
{
      window.open( "<?=base_url()?>re/loanreport/get_collection_excel/"+prj_id+'/'+type+'/'+stdate+'/'+enddate);
}

</script>
<style type="text/css">

</style>
 <?
  $a_date = $sartdate;
$date = new DateTime($a_date);
$date->modify('last day of this month');
$reportdata=$date->format('Y-m-d');
 if($month!=''){
  $heading2=$reName.' Report as at '.$reportdata;
 }
 elseif($enddate!=""){
   $heading2=$reName.' Report as at '.$enddate;
 }
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
       <span style="float:right"> <a href="javascript:export_excel('<?=$prj_id?>','<?=$retype?>','<?=$sartdate?>','<?=$enddate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >

      <table class="table table-bordered">

        <tr   class="active"><th  rowspan="2"> Project Name </th>
          <th  rowspan="2">Customer Name</th>
          <th  rowspan="2">Contract No</th>
   			
          <th  rowspan="2">LOT Number</th>
          <th  rowspan="2">EP Rental</th>
          <th  rowspan="2">Rental Due Date</th>
        <th  colspan="3"><center>Debtor COllection</center></th>
   		 <th  colspan="3"><center>Current Collections</center></th>
          <th  colspan="3"><center>Total Collections</center></th>
   		
   	  	 </tr>

      <tr>
   		 <th >Debtor as at <?=$sartdate?></th>
 		 <th>Debtor Collections</th>
          <th class="success">%</th>
   		 <th>Current Due</th>
         <th>Current Collections</th>
   		 <th class="success">%</th>
 <th>Total Due</th>
         <th>Total Collections</th>
   		 <th class="success">%</th>
 
       
   	 </tr>

       <? $fulltot=0;?>

       <? 	  $debtordueall=0;$paiddebtall=0;$currentdueall=0;$paidcurrentall=0;$totdueall=0;$this_collectionall=0;
   	
  	 ?>
    		   <tr class="active"><td colspan="26"><?=$details[$prj_id]->project_name?></tr>
				 <?

				 if ($transferlist[$prj_id])
				 {
      			 $debtorduepr=0;$paiddebtpr=0;$currentduepr=0;$paidcurrentpr=0;$totduepr=0;$this_collectionpr=0;
	           foreach($transferlist[$prj_id] as $raw){
             	    $received_amtwithperiod=0;$debtordue=0;
				    $received_final=0; $received_start=0; $currentdue=0;
		 			$debtorpaid=0; $currentpaid=0;
          
         	 			if($thispay[$raw->res_code])
          				 {
          					  $received_start=$thispay[$raw->res_code]->totcap+$thispay[$raw->res_code]->totint;
          				}
          				if($lastpay[$raw->res_code])
         				 {
        					   $received_final=$lastpay[$raw->res_code]->totcap+$lastpay[$raw->res_code]->totint;
       					 }
		 				 $this_collection= $received_final- $received_start;
	 					  if($thishedule[$raw->res_code])
       					  {//from date shedule
       					     $thisshedule_tot_instalment=$thishedule[$raw->res_code]->arriastot;
       					     $debtordue=$thisshedule_tot_instalment-$received_start;
        				 }
       					  if($lastshedule[$raw->res_code])
      					 {//to date shedule
          					 $lastshedule_tot_instalment=$lastshedule[$raw->res_code]->arriastot;
         					$currentdue=$lastshedule_tot_instalment- $received_start;
		 				 }
					 $rental_due_date=$raw->start_date;
       				  $no_of_period=$raw->period;
					  $datearr=explode('-',$sartdate);
					   $rental_due_date_d=date('d',strtotime($rental_due_date));
        // $periodenddate = date('Y-m-d', strtotime("+".$no_of_period." months", strtotime($rental_due_date)));
        				$rental_date=$datearr['0'].'-'.$datearr[1].'-'. $rental_due_date_d;
 				
		
							 if( $debtordue<0)  $debtordue=0 ; 
								 else $currentdue=$currentdue-$debtordue;
							  if( $currentdue<0)  $currentdue=0 ;
		
								  $paiddebt=0;  $paidcurrent=0;
        					  if($this_collection<=$debtordue)
									  $paiddebt=$this_collection;
		 					 else
								  {
									   $paiddebt=$debtordue;
			 							$paidcurrent=$this_collection-$debtordue;
								  }
		    $totcollections=$paidcurrent+$paiddebt;
		  $debtorpr=0;$curentpr=0; $totpr=0;
		  $totdue=$currentdue+$debtordue;
		  if($debtordue>0) $debtorpr= $paiddebt/$debtordue*100;
		   if($currentdue>0) $curentpr= $paidcurrent/$currentdue*100;
		    if($totdue>0) $totpr= $totcollections/($currentdue+$debtordue)*100;
      
      $di_as_at=get_loan_date_di($raw->loan_code,$enddate);
	  $flag=true;
	  if($raw->loan_status=='SETTLED')
	  $flag=false;
	  if($totcollections>0)
	  $flag=true;
				if( $flag>0) {?>
         <tr><td></td>
           <td><?=$raw->first_name?> <?=$raw->last_name?></td>
           <td><?=$raw->old_code?></td>
           <td><?=$raw->lot_number?></td>
             <td align="right"><?=number_format($raw->montly_rental,2)?></td>
            <td align="right"><?=$rental_date?></td>
             <td align="right"><?=number_format($debtordue,2)?></td>
                 <td  align="right"><?=number_format($paiddebt,2)?></td>
         <td  align="right" class="success"><?=number_format($debtorpr,2)?>%</td>
           <td  align="right"><?=number_format($currentdue,2)?></td>
               <td  align="right"><?=number_format($paidcurrent,2)?></td>
                <td  align="right" class="success"><?=number_format($curentpr,2)?>%</td>
            <td  align="right"><?=number_format($totdue,2)?></td>
            <td  align="right"><?=number_format($this_collection,2)?></td>
            <td  align="right" class="success"><?=number_format($totpr,2)?>%</td>
           
         </tr>
         <? 		$debtorduepr=$debtorduepr+$debtordue;	
			$paiddebtpr=$paiddebtpr+$paiddebt;	
			$currentduepr=$currentduepr+$currentdue;	
			$paidcurrentpr=$paidcurrentpr+$paidcurrent;	
			$totduepr=$totduepr+$totdue;	
			$this_collectionpr=$this_collectionpr+$this_collection;
			
			$debtordueall=$debtordueall+$debtordue;	
			$paiddebtall=$paiddebtall+$paiddebt;	
			$currentdueall=$currentdueall+$currentdue;	
			$paidcurrentall=$paidcurrentall+$paidcurrent;	
			$totdueall=$totdueall+$totdue;	
			$this_collectionall=$this_collectionall+$this_collection;		
			

   		} }?>
      <tr style="font-weight:bold" class="info"><td colspan="4">Project Total</td>
  			
           <td></td>
           
            <td align="right"></td>
             <td align="right"><?=number_format($debtorduepr,2)?></td>
                 <td  align="right"><?=number_format($paiddebtpr,2)?></td>
                 <? if($debtorduepr>0){?>
          <td  align="right"><?=number_format(($paiddebtpr/$debtorduepr)*100,2)?></td>
          <? }else {?><td></td><? }?>
           <td  align="right"><?=number_format($currentduepr,2)?></td>
               <td  align="right"><?=number_format($paidcurrentpr,2)?></td>
                 <? if($currentduepr>0){?>
                 <td  align="right"><?=number_format(($paidcurrentpr/$currentduepr)*100,2)?></td>
                    <? }else {?><td></td><? }?>
            <td  align="right"><?=number_format($totduepr,2)?></td>
            <td  align="right"><?=number_format($this_collectionpr,2)?></td>
              <? if($totduepr>0){?>
             <td  align="right"><?=number_format(($this_collectionpr/$totduepr)*100,2)?></td>
                <? }else {?><td></td><? }?>
        

  	
           
        

  		</tr>
   	<?
  
  }

 ?>

         </table></div>
    </div>

</div>
