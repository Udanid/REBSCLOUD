
<script type="text/javascript">

function load_printscrean2(id,month)
{
		
				window.open( "<?=base_url()?>hm/report_excel/get_budget/"+month+"/"+branch );
			}
function load_printscrean3(id,fromdate,todate)
{
			window.open( "<?=base_url()?>hm/report_excel/get_unbudget_daterange/"+fromdate+"/"+todate+"/"+id );
	
}
</script>
 <?
 if($month!=''){
  $heading2=' Payment Details of Unbudgeted Projects -  as at '.$reportdata;
 }
 else{
   $heading2=' Payment Details of Unbudgeted Projects - as at'.$reportdata;
 }
 
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('<?=$branchid?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{ $fromdate=date('Y').'-'.$month.'-01';$todate=date('Y').'-'.$month.'-31';?>
       
           <a href="javascript:load_printscrean3('<?=$branchid?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered">
     
      <tr class="success"><th > Project Name </th><th>Category</th><th >Expense</th>
      <th >Description</th><th >Payment Date </th><th>CHQ / Voucher No</th>
       <? $fulltot=0;?>
        </tr>
       <? if($prjlist){foreach($prjlist  as $prraw){ ?> 
       
    <tr><td><?=$details[$prraw->prj_id]->project_name?></td><td></td><td></td><td></td><td></td><td></td></tr>
	
	<?
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
        <?  if($reservation[$prraw->prj_id]){
			foreach($reservation[$prraw->prj_id] as $raw){
						if($raw->new_budget>0){			
				?>
         <? if($currentlist[$raw->id]){foreach($currentlist[$raw->id] as $payraw){?>
			<tr><td></td><td><?=$raw->task_name?></td>
              <td align="right"><?=number_format($payraw->amount,2)?></td>
          <td align="right"><?=$raw->task_name?>- <?=$payraw->subtask_name?></td>
           <td align="right"><?=$payraw->create_date?></td>
            <td align="right"><?=$payraw->voucherid?>/<?=$payraw->CHQNO?></td>

            
            </tr>
		<? }}	?>
    
     
        <? 
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}?>
        
               <tr class="active" style="font-weight:bold">
         <td align="right">Total Project Expense</td>
          <td align="right"></td>
           <td align="right"><?=number_format($prjexp,2)?></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
            </tr>
            
           
        
        
      <?
	  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right">Total Expense</td>
          <td align="right"></td>
           <td align="right"><?=number_format($fulltot,2)?></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
            </tr>
         </table></div>
    </div> 
    
</div>