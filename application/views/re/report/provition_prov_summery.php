
<script type="text/javascript">

function load_printscrean1(branch)
{
			window.open( "<?=base_url()?>re/report_excel/get_provition_summery_budget/"+branch);
}
function load_printscrean2(branch)
{
			window.open( "<?=base_url()?>re/report_excel/get_provition_summery_expence/"+branch);
}
function load_printscrean3(branch)
{
			window.open( "<?=base_url()?>re/report_excel/get_provition_summery_balance/"+branch);
}

</script>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <?
  $heading2='Provision Summary  - Budget '

 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean1('<?=$branchid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow" >
      <div class="tableFixHead">               
      <table class="table table-bordered">
      	<thead>
       <tr><th>Project</th>
       <? foreach($tasklist as $raw){
		   ?>
	     <th  > <?=$raw->task_name?> </th>
	    <?  }?>
     
       
      <th>Total</th>
            </tr>
       </thead>
       
    <? $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
			$dptotp=0; $prjtot=0;
			//$prjbudget=project_expence($prjraw->prj_id);
			if($details[$prjraw->prj_id]->dp_cmp_status!='COMPLETE'){
			?>
             <tr><td><?=$details[$prjraw->prj_id]->project_name?></td>
             
                <? foreach($tasklist as $raw){
				
								 $prjtot= $prjtot+$reservation[$prjraw->prj_id][$raw->task_id];
		   ?>
	     <td   align="right"  > <?=number_format($reservation[$prjraw->prj_id][$raw->task_id],2)?> </th>
	    <? 	
			 }?>
             <td style="font-weight:bold"  align="right" > <?=number_format($prjtot,2)?></td>
      </tr>
            
            <? }}
			
		
			
			
	
		
		
		?>
       
        
        <?
	}
	
			?>
  
      
      
       
       
      
         </table></div></div>
    </div>
    <br /><br />
     <?
  $heading2='Provision Summary Report - Expenses '

 ?>
    <div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean2('<?=$branchid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow" >
        <div class="tableFixHead">             
      <table class="table table-bordered">
      <thead>
       <tr><th>Project</th>
       <? foreach($tasklist as $raw){
		 ?>
	     <th  > <?=$raw->task_name?> </th>
	    <?  }?>
     
       
      <th>Total</th>
            </tr>
       </thead>
       
    <? $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
			if($details[$prjraw->prj_id]->dp_cmp_status!='COMPLETE'){
			$dptotp=0; $prjtot=0;
		
			?>
             <td><?=$details[$prjraw->prj_id]->project_name?></td>
             
                <? foreach($tasklist as $raw){
					 $prjtot= $prjtot+$prevpayment[$prjraw->prj_id][$raw->task_id];
		  ?>
	     <td   align="right"  > <?=number_format($prevpayment[$prjraw->prj_id][$raw->task_id],2)?> </th>
	    <?  }?>
             <td style="font-weight:bold"  align="right" > <?=number_format($prjtot,2)?></td>
      </tr>
            
            <? }}
			
	
		
		
		?>
       
        
        <?
	}
	
			?>
  
      
      
       
       
      
         </table></div></div>
    </div> 
      <br /><br />
     <?
  $heading2='Provision Summary  Report - Balance '

 ?>
    <div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean3('<?=$branchid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow" >
      <div class="tableFixHead">               
      <table class="table table-bordered">
      <thead>
       <tr><th>Project</th>
       <? foreach($tasklist as $raw){
		  ?>
	     <th  > <?=$raw->task_name?> </th>
	    <?  }?>
     
       
      <th>Total</th>
            </tr>
       </thead>
       
    <? $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
		if($details[$prjraw->prj_id]->dp_cmp_status!='COMPLETE'){
			$dptotp=0; $prjtot=0;
			?>
             <td><?=$details[$prjraw->prj_id]->project_name?></td>
             
                <? foreach($tasklist as $raw){
					$balance=$reservation[$prjraw->prj_id][$raw->task_id]-$prevpayment[$prjraw->prj_id][$raw->task_id];
					 $prjtot= $prjtot+$balance;
		  ?>
	     <td   align="right"  > <?=number_format($balance,2)?> </th>
	    <?  }?>
             <td style="font-weight:bold"  align="right" > <?=number_format($prjtot,2)?></td>
      </tr>
            
            <? }
			
		}
		
		
		?>
       
        
        <?
	}
	
			?>
  
      
      
       
       
      
         </table></div></div>
    </div> 
    
</div>