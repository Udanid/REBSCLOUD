
<script type="text/javascript">

function load_printscrean1(month,prjid,year)
{
			window.open( "<?=base_url()?>re/report_excel/get_stock/"+prjid+'/'+month+'/'+year);
	
}

</script>
 <?
 if($month!=''){
  $heading2=' Stock Report as at '.$reportdata;
 }
 else{
   $heading2=' Stock Report as at '.$reportdata;
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> 
       <a href="javascript:load_printscrean1('<?=$month?>','<?=$prj_id?>','<?=$year?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered"><tr class="success"><th  rowspan="2">Project Name</th><th  rowspan="2">Lot Number</th>
      <th colspan="2"> Number of Lots to sell</th><th rowspan="2">Stock</th><th rowspan="2">Profit</th><th rowspan="2">Sale Value</th>
        </tr>
        <tr >
        <th class="info">This Month</th>
         <th class="info">Last Month</th>
         </tr>
       
    <? 
	$fullcost=0;$fullsale=0;$fullprofit=0;$lastlotcount=0;$thislotcount=0;
	
				//echo $prjraw->prj_id;
			$prjcost=0;$prjsale=0;$prjprofit=0;
			$pendinglastmonth=$lastmont[$prj_id]+$pendinglot[$prj_id];
			if($reslots[$prj_id]) {$pending=$pendinglot[$prj_id];
			$pendinglastmonth=$lastmont[$prj_id]+count($reslots[$prj_id])+$pendinglot[$prj_id];
			}
			else $pending=$pendinglot[$prj_id];
			
			$thislotcount=$thislotcount+$pending;
			$lastlotcount=$lastlotcount+$pendinglastmonth;
			?>
        <tr class="active"><td><?=$details[$prj_id]->project_name?></td><td></td><td><?=$pending?></td><td><?=$pendinglastmonth?></td>
        
        <td></td><td></td><td></td></tr>
        <? if($lotdata[$prj_id]){
			foreach($lotdata[$prj_id] as $raw){
				$prjcost=$prjcost+$raw->costof_sale;
				$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
				$prjsale=$prjsale+$raw->sale_val;
				?>
        <tr><td></td><td><?=$raw->lot_number?></td><td></td><td></td>
        <td align="right"><?=number_format($raw->costof_sale,2)?></td>
         <td align="right"><?=number_format($raw->sale_val-$raw->costof_sale,2)?></td>
          <td align="right"><?=number_format($raw->sale_val,2)?></td>
        </tr>
        <? }}?>
          <? if($reslots[$prj_id]){
			foreach($reslots[$prj_id] as $raw){
				$prjcost=$prjcost+$raw->costof_sale;
				$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
				$prjsale=$prjsale+$raw->sale_val;?>
        <tr><td></td><td><?=$raw->lot_number?></td><td></td><td></td>
        <td align="right"><?=number_format($raw->costof_sale,2)?></td>
         <td align="right"><?=number_format($raw->sale_val-$raw->costof_sale,2)?></td>
          <td align="right"><?=number_format($raw->sale_val,2)?></td>
        </tr>
        <? }}
		$fullcost=$fullcost+$prjcost;
		$fullprofit=$fullprofit+$prjprofit;
		$fullsale=$fullsale+$prjsale;
		?>
         <tr class="active"><td></td><td></td><td></td><td></td>
        <td align="right"><?=number_format($prjcost,2)?></td>
         <td align="right"><?=number_format($prjprofit,2)?></td>
          <td align="right"><?=number_format($prjsale,2)?></td>
        </tr>
        
     
         </table></div>
    </div> 
    
</div>