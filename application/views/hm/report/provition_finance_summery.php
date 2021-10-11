
<script type="text/javascript">

function load_printscrean1(branchid)
{
			window.open( "<?=base_url()?>hm/report_excel/get_finance_summery/"+branchid);
	
}

</script>
 <?
  $heading2='Finance Cost Summary  Report'

 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean1('<?=$branchid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered">
     <tr class="success" style="font-weight:bold"><td colspan="7"  align="center"></td></tr>
       <tr><th rowspan="2" >Project</th><th rowspan="2" > Total Project Cost </th><th rowspan="2" >Collection as % cost Cover</th><th colspan="3" >Finance Cost</th>
             </tr>
             <tr><th>Budgeted</th><th>Actual</th><th>Balance/Excess</th></tr>
       
       
    <? $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	$totfinance2=0;
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
			$prjbudget=project_expence($prjraw->prj_id);
			$presentage=0;
			if($prjbudget>0)
			$presentage=($dpcollect[$prjraw->prj_id]/$prjbudget)*100;
			if($presentage<100){
				$totfinance=$totfinance+$prjbudget;
				$totfinance2=$totfinance2+$financecost[$prjraw->prj_id];
				$totbudget=$totbudget+$prjbudget;
				$totactual=$totactual+$intcostfull[$prjraw->prj_id];
				$finance=$financecost[$prjraw->prj_id];
			?>
             <td><?=$details[$prjraw->prj_id]->project_name?></td>
        <td align="right"><?=number_format($prjbudget,2)?></td>
        <td align="right"><?=number_format($presentage,2)?>%</td>
        <td align="right"> <?=number_format($finance,2)?></td>
         <td align="right"> <?=number_format($intcostfull[$prjraw->prj_id],2)?></td>
            <td align="right"><?=number_format($finance-$intcostfull[$prjraw->prj_id],2)?></td></tr>
            
            <? }
			
		}
		
		
		?>
          <tr class="active" style="font-weight:bold"><td >Total</td>
        <td align="right"><?=number_format($totfinance,2)?></td></td>
          <td align="right"></td></td>
           <td align="right"><?=number_format($totfinance2,2)?></td></td>
            <td align="right"><?=number_format($totactual,2)?></td></td>
             <td align="right"><?=number_format($totfinance2-$totactual,2)?></td></td></tr>
        
        <?
	}
	
			?>
  
      
      
       
       
      
         </table></div>
    </div> 
    
</div>