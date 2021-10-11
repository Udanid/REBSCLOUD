
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>hm/report/get_stock_all_print/"+month);
	
}
function load_printscrean2(prjid,month)
{
			window.open( "<?=base_url()?>hm/report_excel/get_provition/"+prjid+'/'+month);
	
}
function load_printscrean3(prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>hm/report_excel/get_provition_daterange/"+prjid+'/'+fromdate+'/'+todate);
	
}

</script>
 <?
 if($month!=''){
  $heading2=' Provision Report as at '.$reportdata;
 }
 else{
   $heading2=' Provision Report as at '.$reportdata;
 }
 
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">
       
        <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('<?=$prj_id?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
           <a href="javascript:load_printscrean2('<?=$prj_id?>','<?=$month?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a><? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered">
   <tr class="success" style="font-weight:bold"><td colspan="7"  align="center"><?=$details[$prj_id]->project_name?></td></tr>
       <tr ><th colspan="2">Budget</th><th colspan="4">Actual</th><th>%</th></tr>
      <tr><th > Category </th><th width="50">Total Budget</th><th width="50" >Expense</th>
      <th >Description</th><th >Payment Date </th><th>CHQ / Voucher No</th><th >%</th>
       
        </tr>
       
       
    <? 
	
	
		//echo $prjraw->prj_id;
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
        <?  if($reservation[$prj_id]){
			foreach($reservation[$prj_id] as $raw){
						if($raw->new_budget>0){			
				?>
        <tr><td><?=$raw->task_name?></td>
        <td align="right"><?=number_format($raw->estimate_budget,2)?></td><td></td><td></td><td></td><td></td></tr>
        <? if($currentlist[$raw->id]){foreach($currentlist[$raw->id] as $payraw){?>
			<tr><td></td><td></td>
              <td align="right"><?=number_format($payraw->amount,2)?></td>
          <td align="right"><?=$payraw->name?>- <?=$payraw->subtask_name?></td>
           <td align="right"><?=$payraw->create_date?></td>
            <td align="right"><?=$payraw->voucherid?>/<?=$payraw->CHQNO?></td>

            
            </tr>
		<? }}	?>
        <tr class="active" style="font-weight:bold">
         <td align="right">Total Expense</td>
          <td align="right"></td>
           <td align="right"><?=number_format($raw->tot_payments,2)?></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
             <td rowspan="2">
            
            
            <? $presentage=0;if($raw->estimate_budget>0)$presentage=round(($raw->tot_payments)/$raw->estimate_budget*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
            </td>
        </tr>
         <tr class="active" style="font-weight:bold">
         <td align="right">Available Budget</td>
          <td align="right"><?=number_format($raw->estimate_budget-$raw->tot_payments,2)?></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
           
           
           </tr>
        <? 
		$prjbujet=$prjbujet+$raw->estimate_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}?>
         <tr class="info" style="font-weight:bold">
         <td align="right">Total Project Expens</td>
            <td align="right"></td>
          <td align="right"><?=number_format($prjexp,2)?></td>
        
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
           
           
            <td rowspan="3">
            
            
            <? 
			$presentage=0;
			if($prjbujet>0)
			$presentage=round(($prjexp)/$prjbujet*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
            </td>
           </tr>
           
            <tr class="info" style="font-weight:bold">
         <td align="right">Available Project Budget</td>
           
          <td align="right"><?=number_format($prjbujet-$prjexp,2)?></td>
         <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td></tr>
           
          <tr class="info" style="font-weight:bold">
         <td align="right">Total Budgeted Amount</td>
           
          <td align="right"><?=number_format($prjbujet,2)?></td>
         <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
           
           </tr>
        
      <?
	 
	  
	  ?>
      
         </table></div>
    </div> 
    
</div>