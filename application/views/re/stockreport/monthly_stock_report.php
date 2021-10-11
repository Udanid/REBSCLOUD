
<script type="text/javascript">

function load_printscrean1(month,year)
{
			window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month+'/'+year);

}
function load_printscrean2(branch,month,year)
{
			window.open( "<?=base_url()?>re/report_excel/get_stock_all/"+branch+'/'+month+'/'+year);

}

</script>
<script type="text/javascript">
  $(document).ready(function() {
	var tableToExcel = (function() {
	  var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  return function(table, name, fileName) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

		var link = document.createElement("A");
		link.href = uri + base64(format(template, ctx));
		link.download = fileName || 'Workbook.xls';
		link.target = '_blank';
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	  }
	})();
	$('#create_excel').click(function(){
		tableToExcel('dl_table', 'Monthly Stock', 'Monthly_Stock<?=date('Y_m_d');?>.xls');
		// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
	});
  });
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <?

   $heading2=' Stock Report as at '.$todate;


 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
     </h4>
		 <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
 </h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
         <div class="tableFixHead" id="dl_table">
      <table class="table table-bordered"><thead><tr class="success">
				<th  rowspan="3">Project Name</th>
				<th rowspan="3">T. No. Blocks</th>
				<th rowspan="3">Sale Date</th>
				<th rowspan="3">S/No.</th>
				<th  rowspan="3">Lot Number</th>
				<th rowspan="3">Extent</th>
				<th rowspan="3">Price Per Perch</th>
		 		<th rowspan="3">Total Value</th>
				<th colspan="8"><center><?=date("F-y",strtotime($todate))?></center></th>
        </tr>
				<tr class="success">
					<th colspan="2"><center>Sales</center></th>
					<th colspan="2"><center>Purchases</center></th>
					<th colspan="2"><center>Resales</center></th>
					<th colspan="2"><center>Closing stock <?=date("Y-m-t",strtotime($todate))?></center></th>
	        </tr>
					<tr class="success">
						<th >Block</th>
						<th >Value</th>
						<th >Block</th>
						<th >Value</th>
						<th >Block</th>
						<th >Value</th>
						<th >Block</th>
						<th >Value</th>
		        </tr>

       </thead>
    <?
	$fullcost=0;$fullsale=0;$fullprofit=0;$lastlotcount=0;$thislotcount=0;$fulllotcount=0;
	$sale_val_tot_grand=0;
	$perches_val_tot_grand=0;
	$resale_val_tot_grand=0;
	$closing_val_tot_grand=0;
	$befor_monthdate=date("Y-m-t", strtotime("-1 months -5 days",strtotime($todate)));?><!-- /get 05 days because of February-->
	<tr class="active"><td colspan="16">Land Stock for the Month of <?=date("Y-F",strtotime($befor_monthdate))?> </td>
		</tr>

	<?
	if($prjlist){
		foreach($prjlist as $prjraw){
			if(check_priclist_confirm($prjraw->prj_id,$todate)){//report helper function
			//echo $prjraw->prj_id;
		$prjcost=0;$prjprofit=0;$prjsale=0;$lotcount=0;$closing_val_tot=0;
		$sale_val_tot=0;
		$perches_val_tot=0;
		$resale_val_tot=0;
			?>

        <? if($lotdata[$prjraw->prj_id]){
			?>
            <tr class="active"><td><?=$prjraw->project_name?></td>
							<td><?=count($lotdata[$prjraw->prj_id])?></td>

        <td></td><td></td><td colspan="12"></td></tr>
            <?
						$n=0;
			foreach($lotdata[$prjraw->prj_id] as $raw){

			//$check=false;
					$check=check_available_lot($raw->lot_id,$befor_monthdate);//report helper function

				$check2=check_advance_lot($raw->lot_id,$befor_monthdate);//report helper function
				$check3=resale_lot_period($raw->lot_id,$befor_monthdate,$todate);
				$check_for_month=check_advance_lot_period($raw->lot_id,$befor_monthdate,$todate);

				if($check || $check2)
				{
					$n++;
					$lotcount++;
					$fulllotcount++;
					$prjcost=$prjcost+$raw->costof_sale;
					$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
					$prjsale=$prjsale+$raw->sale_val;

					$fullcost=$fullcost+$raw->costof_sale;
					$fullprofit=$fullprofit+($raw->sale_val-$raw->costof_sale);
					$fullsale=$fullsale+$raw->sale_val;
					$closing_value=$raw->sale_val;
				?>
                <tr ><td></td>
									<td></td>
									<td></td>
									<td><?=$n?></td>
									<td><?=$raw->lot_number?></td>
                <td align="right"><?=number_format($raw->extend_perch,2)?></td>
                 <td align="right"><?=number_format($raw->price_perch,2)?></td>
                  <td align="right"><?=number_format($raw->sale_val,2)?></td>
									<? if($check_for_month){
										$closing_value=$closing_value-$raw->sale_val;
										$sale_val_tot=$sale_val_tot+$raw->sale_val;

										?>
										<td class="green"><?=$raw->lot_number?></td>
										<td align="right" class="green"><?=number_format($raw->sale_val,2)?></td>

									<?}else {?>
										<td></td>
										<td align="right"></td>
									<?}?>
									<td></td>
									<td align="right" ></td>
									<? if($check3){
										$closing_value=$closing_value+ $raw->sale_val;
										$resale_val_tot=$resale_val_tot+$raw->sale_val;
										?>
										<td><?=$raw->lot_number?></td>
										<td align="right"><?=number_format($raw->sale_val,2)?></td>

									<?}else {?>
										<td></td>
										<td align="right"></td>
									<?}?>
									<? if($closing_value>0){
										?>
										<td class="purple"><?=$raw->lot_number?></td>
									<td align="right" class="purple"><?=number_format($closing_value,2)?></td><!-- closing stock-->

									<?}else {?>
										<td></td>
										<td align="right"></td>
									<?}?>

                </tr>
       		 <?
					 $closing_val_tot=$closing_val_tot+$closing_value;
					 $sale_val_tot_grand=$sale_val_tot_grand+$sale_val_tot;
				 	$perches_val_tot_grand=$perches_val_tot_grand+$perches_val_tot;
				 	$resale_val_tot_grand=$resale_val_tot_grand+$resale_val_tot;
					$closing_val_tot_grand=$closing_val_tot_grand+$closing_val_tot;
				 }}}?>
          <?

		?>
        <? if($prjcost>0){?>
         <tr class="yellow"  style="font-weight:bold"><td></td><td></td><td></td><td></td><td><?=$lotcount?></td>
					 <td></td>
        <td align="right"></td>
          <td align="right"><?=number_format($prjsale,2)?></td>

						<td></td>
						<td align="right"><?=number_format($sale_val_tot,2)?></td>
						<td></td>
						<td align="right"></td>
						<td></td>
						<td align="right"><?=number_format($resale_val_tot,2)?></td>
						<td></td>
						<td align="right"><?=number_format($closing_val_tot,2)?></td>
        </tr><? }?>

      <? }} }?>
       <tr class="info" style="font-weight:bold"><td></td><td></td><td></td><td></td><td></td><td></td>
        <td align="right"></td>
          <td align="right"><?=number_format($fullsale,2)?></td>
					<td></td>
					<td align="right"><?=number_format($sale_val_tot_grand,2)?></td>
					<td></td>
					<td align="right"></td>
					<td></td>
					<td align="right"><?=number_format($resale_val_tot_grand,2)?></td>
					<td></td>
					<td align="right"><?=number_format($closing_val_tot_grand,2)?></td>
        </tr>
         </table></div>
         </div>
    </div>

</div>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>
