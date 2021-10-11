<script type="text/javascript">

function export_excel(branch,type,stdate,enddate)
{
      window.open( "<?=base_url()?>re/loanreport/get_collection_all_excel/"+branch+'/'+type+'/'+stdate+'/'+enddate);
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
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
  $heading2=$reName.'Follow up List as at '.$reportdata;
 }
 elseif($enddate!=""){
   $heading2=$reName.' Follow up List as at '.$enddate;
 }
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
       </h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:600px; overflow:scroll" >

      <table class="table table-bordered">

        <tr   class="active"><th > Project Name </th>
          <th >Customer Name</th>
           <th  >Contact  Number</th>
          <th  >Contract No</th>
   			
          <th  >LOT Number</th>
          <th  >Finance Amount</th>
          <th  >Due Date</th>
           <th  >Outstanding Amount</th>
           
    		
   	  	 </tr>

     

       <? $fulltot=0;?>

       <? 	  $debtordueall=0;$paiddebtall=0;$currentdueall=0;$paidcurrentall=0;$totdueall=0;$this_collectionall=0;
   	
      		 ?>
    		    <?

				 if ($transferlist)
				 {
      			 $debtorduepr=0;$paiddebtpr=0;$currentduepr=0;$paidcurrentpr=0;$totduepr=0;$this_collectionpr=0;
	           foreach($transferlist as $raw){
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
	 					  
					 $rental_due_date=$raw->start_date;
       				  $no_of_period=$raw->period;
					  $datearr=explode('-',$sartdate);
					   $rental_due_date_d=date('d',strtotime($rental_due_date));
         $periodenddate = date('Y-m-d', strtotime("+".$no_of_period." months", strtotime($rental_due_date)));
		  $paiddebt=0;  $paidcurrent=0;
		
			 $debtordue=$raw->loan_amount-$received_start;
			   $paiddebt=$this_collection;
		
        			
		
						
		
							
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
				?>
         <tr><td><?=$raw->project_name?></td>
           <td><?=$raw->first_name?> <?=$raw->last_name?></td>
             <td> <a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->old_code?></a></td>
           <td><?=$raw->mobile?></td>
      
           <td><?=$raw->lot_number?></td>
             <td align="right"><?=number_format($raw->loan_amount,2)?></td>
            <td align="right"><?=$periodenddate?></td>
             <td align="right"><?=number_format($debtordue,2)?></td>
              
           
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
			

   		?>
     
   	<?
  
  }
				 }
  ?>
  
  <?
    
				 ?>

         </table></div>
    </div>

</div>
