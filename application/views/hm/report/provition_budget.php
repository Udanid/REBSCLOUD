
<script type="text/javascript">


function load_printscrean2(id,month)
{
		
				window.open( "<?=base_url()?>hm/report_excel/get_budget/"+id+"/"+month );
			}
function load_printscrean3(prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>hm/report_excel/get_budget_daterange/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
 <?
 if($month!=''){
  $heading2=' Budget Report as at '.$reportdata;
 }
 else{
   $heading2=' Budget Report as at '.$reportdata;
 }
 
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">  <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('0','<?=$prj_id?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
           <a href="javascript:load_printscrean2('<?=$prj_id?>','<?=$month?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered">
     <tr class="success" style="font-weight:bold"><td colspan="4"  align="center"><?=$details[$prj_id]->project_name?></td></tr>
       <tr><th > Category </th><th>Total Budget</th><th >Expense</th>
      <th >Balance</th>
        
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
        <td align="right"><?=number_format($raw->new_budget,2)?></td>
        <td align="right"><?=number_format($raw->tot_payments,2)?></td>
        <td align="right"> <?=number_format($raw->new_budget-$raw->tot_payments,2)?></td></tr>
        
       
        <? 
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}?>
         <tr class="info" style="font-weight:bold">
         <td align="right">Total</td>
            <td align="right"><?=number_format($prjbujet,2)?></td>
          <td align="right"><?=number_format($prjexp,2)?></td>
         <td align="right"><?=number_format($prjbujet-$prjexp,2)?></td>
            
           
                   </tr>
           
           
      <?
	 
	  
	  ?>
      
         </table></div>
    </div> 
    
</div>