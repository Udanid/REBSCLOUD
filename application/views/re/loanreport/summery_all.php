<script type="text/javascript">

function export_excel(branch,type,stdate,enddate)
{
      window.open( "<?=base_url()?>re/loanreport/get_collection_all_excel/"+branch+'/'+type+'/'+stdate+'/'+enddate);
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
  $heading2='Summery Report as at '.$reportdata;
 }
 elseif($enddate!=""){
   $heading2='Summery Report as at '.$enddate;
 }
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
       <span style="float:right">
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >

     

       <? $fulltot=0;?>

       <? 	  $debtordueall_NEP=0;$paiddebtall_NEP=0;$currentdueall_NEP=0;$paidcurrentall_NEP=0;$totdueall_NEP=0;
	   $this_collectionall_NEP=0;
	    $debtordueall_ZEP=0;$paiddebtall_ZEP=0;$currentdueall_ZEP=0;$paidcurrentall_ZEP=0;$totdueall_ZEP=0;
	   $this_collectionall_ZEP=0;
	    $debtordueall_EPB=0;$paiddebtall_EPB=0;$currentdueall_EPB=0;$paidcurrentall_EPB=0;$totdueall_EPB=0;
	   $this_collectionall_EPB=0;
   	
       if($prjlist){
        
         foreach($prjlist as $prjraw){
			 ?>
    			 <?

				 if ($transferlist_NEP[$prjraw->prj_id])
				 {
      			 $debtorduepr=0;$paiddebtpr=0;$currentduepr=0;$paidcurrentpr=0;$totduepr=0;$this_collectionpr=0;
	           foreach($transferlist_NEP[$prjraw->prj_id] as $raw){
             	    $received_amtwithperiod=0;$debtordue=0;
				    $received_final=0; $received_start=0; $currentdue=0;
		 			$debtorpaid=0; $currentpaid=0;
          
         	 			if($thispay_NEP[$raw->res_code])
          				 {
          					  $received_start=$thispay_NEP[$raw->res_code]->totcap+$thispay_NEP[$raw->res_code]->totint;
          				}
          				if($lastpay_NEP[$raw->res_code])
         				 {
        					   $received_final=$lastpay_NEP[$raw->res_code]->totcap+$lastpay_NEP[$raw->res_code]->totint;
       					 }
		 				 $this_collection= $received_final- $received_start;
	 					  if($thishedule_NEP[$raw->res_code])
       					  {//from date shedule
       					     $thisshedule_tot_instalment=$thishedule_NEP[$raw->res_code]->arriastot;
       					     $debtordue=$thisshedule_tot_instalment-$received_start;
        				 }
       					  if($lastshedule_NEP[$raw->res_code])
      					 {//to date shedule
          					 $lastshedule_tot_instalment=$lastshedule_NEP[$raw->res_code]->arriastot;
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
       
         <? 		$debtorduepr=$debtorduepr+$debtordue;	
			$paiddebtpr=$paiddebtpr+$paiddebt;	
			$currentduepr=$currentduepr+$currentdue;	
			$paidcurrentpr=$paidcurrentpr+$paidcurrent;	
			$totduepr=$totduepr+$totdue;	
			$this_collectionpr=$this_collectionpr+$this_collection;
			
			$debtordueall_NEP=$debtordueall_NEP+$debtordue;	
			$paiddebtall_NEP=$paiddebtall_NEP+$paiddebt;	
			$currentdueall_NEP=$currentdueall_NEP+$currentdue;	
			$paidcurrentall_NEP=$paidcurrentall_NEP+$paidcurrent;	
			$totdueall_NEP=$totdueall_NEP+$totdue;	
			$this_collectionall_NEP=$this_collectionall_NEP+$this_collection;		
			

   		} } }?>
  <?   if ($transferlist_ZEP[$prjraw->prj_id])
				 {
      			 $debtorduepr=0;$paiddebtpr=0;$currentduepr=0;$paidcurrentpr=0;$totduepr=0;$this_collectionpr=0;
	           foreach($transferlist_ZEP[$prjraw->prj_id] as $raw){
             	    $received_amtwithperiod=0;$debtordue=0;
				    $received_final=0; $received_start=0; $currentdue=0;
		 			$debtorpaid=0; $currentpaid=0;$this_collection=0;
          
         	 			if($thispay_ZEP[$raw->res_code])
          				 {
          					  $received_start=$thispay_ZEP[$raw->res_code]->totcap+$thispay_ZEP[$raw->res_code]->totint;
          				}
          				if($lastpay_ZEP[$raw->res_code])
         				 {
        					   $received_final=$lastpay_ZEP[$raw->res_code]->totcap+$lastpay_ZEP[$raw->res_code]->totint;
       					 }
		 				 $this_collection= $received_final- $received_start;
	 					  
					 $rental_due_date=$raw->start_date;
       				  $no_of_period=$raw->period;
					  $datearr=explode('-',$sartdate);
					   $rental_due_date_d=date('d',strtotime($rental_due_date));
         $periodenddate = date('Y-m-d', strtotime("+".$no_of_period." months", strtotime($rental_due_date)));
		  $paiddebt=0;  $paidcurrent=0;
		 if( $periodenddate>=$sartdate)
		 {
			 $currentdue=$raw->loan_amount-$received_start;
			 $paidcurrent=$this_collection;
		 }
		 else
		 {
			 $debtordue=$raw->loan_amount-$received_start;
			   $paiddebt=$this_collection;
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
       
         <? 	
			
			$debtordueall_ZEP=$debtordueall_ZEP+$debtordue;	
			$paiddebtall_ZEP=$paiddebtall_ZEP+$paiddebt;	
			$currentdueall_ZEP=$currentdueall_ZEP+$currentdue;	
			$paidcurrentall_ZEP=$paidcurrentall_ZEP+$paidcurrent;	
			$totdueall_ZEP=$totdueall_ZEP+$totdue;	
			$this_collectionall_ZEP=$this_collectionall_ZEP+$this_collection;		
			

   		} } }?>
         <?   if ($transferlist_EPB[$prjraw->prj_id])
				 {
      			 $debtorduepr=0;$paiddebtpr=0;$currentduepr=0;$paidcurrentpr=0;$totduepr=0;$this_collectionpr=0;
	           foreach($transferlist_EPB[$prjraw->prj_id] as $raw){
             	    $received_amtwithperiod=0;$debtordue=0;
				    $received_final=0; $received_start=0; $currentdue=0;
		 			$debtorpaid=0; $currentpaid=0;$this_collection=0;
          
         	 			if($thispay_EPB[$raw->res_code])
          				 {
          					  $received_start=$thispay_EPB[$raw->res_code]->totcap+$thispay_EPB[$raw->res_code]->totint;
          				}
          				if($lastpay_EPB[$raw->res_code])
         				 {
        					   $received_final=$lastpay_EPB[$raw->res_code]->totcap+$lastpay_EPB[$raw->res_code]->totint;
       					 }
		 				 $this_collection= $received_final- $received_start;
	 					  
					 $rental_due_date=$raw->start_date;
       				  $no_of_period=$raw->period;
					  $datearr=explode('-',$sartdate);
					   $rental_due_date_d=date('d',strtotime($rental_due_date));
         $periodenddate = date('Y-m-d', strtotime("+".$no_of_period." months", strtotime($rental_due_date)));
		  $paiddebt=0;  $paidcurrent=0;
		 if( $periodenddate>=$sartdate)
		 {
			 $currentdue=$raw->loan_amount-$received_start;
			 $paidcurrent=$this_collection;
		 }
		 else
		 {
			 $debtordue=$raw->loan_amount-$received_start;
			   $paiddebt=$this_collection;
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
       
         <? 	
			
			$debtordueall_EPB=$debtordueall_EPB+$debtordue;	
			$paiddebtall_EPB=$paiddebtall_EPB+$paiddebt;	
			$currentdueall_EPB=$currentdueall_EPB+$currentdue;	
			$paidcurrentall_EPB=$paidcurrentall_EPB+$paidcurrent;	
			$totdueall_EPB=$totdueall_EPB+$totdue;	
			$this_collectionall_EPB=$this_collectionall_EPB+$this_collection;		
			

   		} } }?>
   	<?
  
  
}
  ?>
  <table class="table table-bordered">

        <tr   class="active"><th  rowspan="2"> Loan Type </th>
        
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
  <tr style="font-weight:bold"  class="success"><td >NEP Total</td>
   
          
        
             <td align="right"><?=number_format($debtordueall_NEP,2)?></td>
                 <td  align="right"><?=number_format($paiddebtall_NEP,2)?></td>
        <td  align="right"><?=number_format(($paiddebtall_NEP/$debtordueall_NEP)*100,2)?></td>
           <td  align="right"><?=number_format($currentdueall_NEP,2)?></td>
               <td  align="right"><?=number_format($paidcurrentall_NEP,2)?></td>
               <td  align="right"><?=number_format(($paidcurrentall_NEP/$currentdueall_NEP)*100,2)?></td>
            <td  align="right"><?=number_format($totdueall_NEP,2)?></td>
            <td  align="right"><?=number_format($this_collectionall_NEP,2)?></td>
           <td  align="right"><?=number_format(($this_collectionall_NEP/$totdueall_NEP)*100,2)?></td>

  </tr>
   <tr style="font-weight:bold"  class="warning"><td >Personal Fund Total</td>
   
          
        
             <td align="right"><?=number_format($debtordueall_ZEP,2)?></td>
                 <td  align="right"><?=number_format($paiddebtall_ZEP,2)?></td>
         <td  align="right"><?=number_format(($paiddebtall_ZEP/$debtordueall_ZEP)*100,2)?></td>
           <td  align="right"><?=number_format($currentdueall_ZEP,2)?></td>
               <td  align="right"><?=number_format($paidcurrentall_ZEP,2)?></td>
                  <td  align="right"><?=number_format(($paidcurrentall_ZEP/$currentdueall_ZEP)*100,2)?></td>
            <td  align="right"><?=number_format($totdueall_ZEP,2)?></td>
            <td  align="right"><?=number_format($this_collectionall_ZEP,2)?></td>
              <td  align="right"><?=number_format(($this_collectionall_ZEP/$totdueall_ZEP)*100,2)?></td>
           

  </tr>
   <tr style="font-weight:bold"  class="info"><td >Bank Loan Total</td>
   
          
        
             <td align="right"><?=number_format($debtordueall_EPB,2)?></td>
                 <td  align="right"><?=number_format($paiddebtall_EPB,2)?></td>
         <td  align="right"><?=number_format(($paiddebtall_EPB/$debtordueall_EPB)*100,2)?></td>
           <td  align="right"><?=number_format($currentdueall_EPB,2)?></td>
               <td  align="right"><?=number_format($paidcurrentall_EPB,2)?></td>
                  <td  align="right"><?=number_format(($paidcurrentall_EPB/$currentdueall_EPB)*100,2)?></td>
            <td  align="right"><?=number_format($totdueall_EPB,2)?></td>
            <td  align="right"><?=number_format($this_collectionall_EPB,2)?></td>
             <td  align="right"><?=number_format(($this_collectionall_EPB/$totdueall_EPB)*100,2)?></td>

  </tr>
  <tr style="font-weight:bold"  class="active"><td > Total</td>
   
          <?
          $tot1=$debtordueall_EPB+$debtordueall_ZEP+$debtordueall_NEP;
          $tot2=$paiddebtall_EPB+$paiddebtall_ZEP+$paiddebtall_NEP;
		   $tot3=$currentdueall_EPB+$currentdueall_ZEP+$currentdueall_NEP;
		    $tot4=$paidcurrentall_EPB+$paidcurrentall_ZEP+$paidcurrentall_NEP;
			 $tot5=$totdueall_EPB+$totdueall_ZEP+$totdueall_NEP;
			  $tot6=$this_collectionall_EPB+$this_collectionall_ZEP+$this_collectionall_NEP;
          ?>
        
             <td align="right"><?=number_format( $tot1,2)?></td>
                 <td  align="right"><?=number_format($tot2,2)?></td>
         <td  align="right"><?=number_format(($tot2/ $tot1)*100,2)?></td>
           <td  align="right"><?=number_format( $tot3,2)?></td>
               <td  align="right"><?=number_format( $tot4,2)?></td>
                  <td  align="right"><?=number_format(($tot4/$tot3)*100,2)?></td>
            <td  align="right"><?=number_format($tot5,2)?></td>
            <td  align="right"><?=number_format($tot6,2)?></td>
             <td  align="right"><?=number_format(($tot6/$tot5)*100,2)?></td>

  </tr>
  <?
    }
				 ?>

         </table></div>
    </div>

</div>
