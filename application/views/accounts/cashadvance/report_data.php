
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month);
	
}
function expoet_excel(month,branch)
{
		
		
				window.open( "<?=base_url()?>accounts/cashadvance/report_data_excel/"+month+'/'+branch);
}

</script>
<style type="text/css">

</style>
 <?
    $heading2=' Cash Advance Report   as at '.$rptdate;

 
 
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> - <?=$bookdata->name?>
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$rptdate?>','<?=$bookid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? if($bookdata->pay_type=='CSH'){?><a href="javascript:call_confirm('<?=$rptdate?>','<?=$bookid?>')"><span class="label label-success">Reimbersment </span></a><? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
            <h4>Reimbursment Details</h4>    
      <table class="table table-bordered">
      
   
   <tr>  <th >Cash Advance No</th><th >Requested Date</th> <th>Settlement Date</th> <th>Branch</th> <th >Employee Name</th> <th>Project</th> <th>Description </th><th>Payment Added By</th> <th>Confirmed By</th><th>Actual Amount</th><th>PV No</th></tr>
       
       <? $fulltot=0;?>
       
     
        <?  if($settledlist){
			
			?>
            
            <?
			foreach($settledlist as $raw){
				//print_r($arrearspay[$raw->res_code]);
				
				?>
                
      	<tr><td><?=$raw->adv_code?></td><td><?=$raw->apply_date;?></td><td><?=$raw->settled_date?></td>
            
          <td align="right"><?=get_branch_name($raw->branch)?></td>
         <td align="right"><?=$raw->initial?> <?=$raw->surname?></td>
            <td align="right"><?=$raw->project_name?></td>
              <td align="right"><?=$raw->description?></td>
               <td><?=get_user_fullname_id($raw->paid_by)?></td>
                <td><?=get_user_fullname_id($raw->check_officerid)?></td>
              <td align="right"><?=number_format($raw->settled_amount,2)?></td>
               <td align="right"><?=$raw->voucher_id?></td>
              
           
            
            </tr>
		<? 	 $fulltot= $fulltot+$raw->settled_amount;?>
    
     
        <? 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="9">Total</td>
          <td align="right"><?=number_format($fulltot,2)?></td>
            
                 <td align="right"></td>
            </tr>
         </table>
         
         
         
         
         </div>
    </div> 
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
         
	
  
        <h4>Advance List</h4>    
           <table class="table table-bordered">
      
   
   <tr>  <th >Cash Advance No</th><th >Requested Date</th> <th>Settlement Date</th> <th>Branch</th> <th >Employee Name</th> <th>Project</th> <th>Description </th><th>Payment Added By</th> <th>Confirmed By</th><th>Actual Amount</th><th>Date Variance</th></tr>
       
       <? $fulltota=0;?>
       
     
        <?  if($pendiglist){
			
			?>
            
            <?
			foreach($pendiglist as $raw){
				//print_r($arrearspay[$raw->res_code]);
				 $date1=date_create($raw->promiss_date);
					  $date2=date_create($rptdate);
					  $diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
				?>
                
      	<tr><td><?=$raw->adv_code?></td><td><?=$raw->apply_date;?></td><td><?=$raw->pay_date?></td>
            
          <td align="right"><?=get_branch_name($raw->branch)?></td>
         <td align="right"><?=$raw->initial?> <?=$raw->surname?></td>
            <td align="right"><?=$raw->project_name?></td>
              <td align="right"><?=$raw->description?></td>
              <td><?=get_user_fullname_id($raw->paid_by)?></td>
                <td><?=get_user_fullname_id($raw->check_officerid)?></td>
              <td align="right"><?=number_format($raw->amount,2)?></td>
               <td align="right"><?=$dates?></td>
              
           
            
            </tr>
		<? 	 $fulltota= $fulltota+$raw->amount;?>
    
     
        <? 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="9">Total</td>
          <td align="right"><?=number_format($fulltota,2)?></td>
            
                 <td align="right"></td>
            </tr>
         </table>
         
         <table class="table"  style="width:50%" >
         <tr><td>Settled Cash Advance</td><td align="right"><?=number_format($fulltot,2)?></td></tr>
          <tr><td>Unsettled Cash Advance</td><td align="right"><?=number_format($fulltota,2)?></td></tr>
            <tr><td>Cash In Hand and Bank</td><td align="right"><?=number_format(get_cashbook_balance($bookdata->id),2)?></td></tr></table>
         
         </div>
    </div> 
    
</div> 
            
                
				