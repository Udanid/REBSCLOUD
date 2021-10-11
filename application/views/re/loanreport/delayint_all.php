<script type="text/javascript">

function export_excel(branch,type,stdate,enddate)
{
      window.open( "<?=base_url()?>re/loanreport/get_delayint_all_excel/"+branch+'/'+type+'/'+stdate+'/'+enddate);
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
       <span style="float:right"> <a href="javascript:export_excel('<?=$branchid?>','<?=$retype?>','<?=$sartdate?>','<?=$enddate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >

      <table class="table table-bordered">

        <tr   class="active"><th> Project Name </th>
          <th  >Customer Name</th>
          <th  >Contract No</th>
   			
          <th  >LOT Number</th>
         
          <th >Date</th>
        <th ><center>Total Di</center></th>
   		 <th  ><center>Paid Di</center></th>
          <th ><center>Waive off</center></th>
   		
   	  	 </tr>

     

       <? $fulltot=0;?>

       <? 	  $paidpr=$this_collectionpr=$waivopr=0;
			$paidall=$this_collectionall=$waivoall=0;
   	
       if($prjlist){
        
         foreach($prjlist as $prjraw){
			

				 if ($transferlist[$prjraw->prj_id])
				 {
					  ?>
    		   <tr class="active"><td colspan="26"><?=$details[$prjraw->prj_id]->project_name?></tr>
				 <?
      			 $paidpr=$this_collectionpr=$waivopr=0;
	           foreach($transferlist[$prjraw->prj_id] as $raw){
             	    $received_amtwithperiod=0;$debtordue=0;
				    $waivofftot=0; $paidtot=0; $currentdue=0;
		 			$debtorpaid=0; $currentpaid=0;
          
         	 			if($paid[$raw->res_code])
          				 {
          					  $paidtot=$paid[$raw->res_code]->totdi;
							 // echo $raw->old_code.'-'.$paid[$raw->res_code]->totdi.'<br>';
          				}
          				if($waivoff[$raw->res_code])
         				 {
        					   $waivofftot=$waivoff[$raw->res_code]->totdi;
       					 }
		 				 $this_collection= $paidtot+ $waivofftot;
	 					  
					
		
						
		
			//	echo 	 $this_collection;		
		
      
      $di_as_at=get_loan_date_di($raw->loan_code,$enddate);
	  $flag=true;
	  if($raw->loan_status=='SETTLED')
	  $flag=false;
	  if($this_collection>0)
	  $flag=true;
				if( $flag>0) {?>
         <tr><td></td>
           <td><?=$raw->first_name?> <?=$raw->last_name?></td>
           <td><?=$raw->old_code?></td>
      
           <td><?=$raw->lot_number?></td>
          
            <td align="right"></td>
             <td align="right"><?=number_format($this_collection,2)?></td>
                 <td  align="right"><?=number_format($paidtot,2)?></td>
         <td  align="right"><?=number_format($waivofftot,2)?></td>
                  
         </tr>
         <? 		$this_collectionpr=$this_collectionpr+$this_collection;	
			$paidpr=$paidpr+$paidtot;	
			$waivopr=$waivopr+$waivofftot;	
			
			$this_collectionall=$this_collectionall+$this_collection;	
			$paidall=$paidall+$paidtot;	
			$waivoall=$waivoall+$waivofftot;		
			

   		}} ?>
      <tr style="font-weight:bold" class="info"><td colspan="3">Project Total</td>
  			
           <td></td>
           <td></td>
           
           <td align="right"><?=number_format($this_collectionpr,2)?></td>
                 <td  align="right"><?=number_format($paidpr,2)?></td>
         <td  align="right"><?=number_format($waivopr,2)?></td>
           
           
        

  		</tr>
   	<?
  
  }}
  ?>
  <tr style="font-weight:bold"  class="active"><td colspan="3">Total</td>
   
           <td></td>
           <td></td>
           
          <td align="right"><?=number_format($this_collectionall,2)?></td>
                 <td  align="right"><?=number_format($paidall,2)?></td>
         <td  align="right"><?=number_format($waivoall,2)?></td>
  </tr>
  <?
    }
				 ?>

         </table></div>
    </div>

</div>
