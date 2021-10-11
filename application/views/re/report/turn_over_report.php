<!-- Ticket No-2683 | Added By Uvini -->
<script type="text/javascript">


function load_printscrean2(id,month)
{
		
				window.open( "<?=base_url()?>re/report_excel/get_budget/"+id+"/"+month );
			}
function load_printscrean3(prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>re/report_excel/get_budget_daterange/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
 <?
 if($month!=''){
  $heading2=' Turn over report as at '.$todate;
 }
 else{
   $heading2=' Turn over report as at '.$todate;
 }
 
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <div class="form-group" style="margin-left: 100%;">
                        <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
                    </div>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered" id="table">
       <tr><th >Customer Name</th><th >Project Name</th><th>Lot No</th><th >Extent</th>
      <th >Down Payment /<br> Outright</th><th>Six month(ZEP)<br> Loan Value</th><th >NEP Loan Value</th><th>Bank Loan Value (EPB)</th><th>Discounted Selling Price (Total)</th><th> Total Cost</th></tr>
        <?  $outright_amount=$zep_amount = $nep_amount = $epb_amount = 0;
        	$outright_tot=$zep_tot=$nep_tot=$epb_tot=$discounted_tot=0;
        	if($turn_over_report_data){
			foreach($turn_over_report_data as $row){
				if($row->loan_type == 'ZEP'){
					$zep_amount = cal_tot_cap_amount($row->loan_code); //loan_helper 
          $outright_amount = $row->down_payment;
				}
				if($row->loan_type == 'NEP'){
					$nep_amount = cal_tot_cap_amount($row->loan_code); //loan_helper
          $outright_amount = $row->down_payment;
				}
				if($row->loan_type == 'EPB'){
					$epb_amount = cal_tot_cap_amount($row->loan_code); //loan_helper
          $outright_amount = $row->down_payment;
				}
				if($row->loan_type == ''){
					$outright_amount = $row->discounted_price;
				}
				?>
		<tr>
        <td><?=$row->full_name?></td>
        <td><?=$row->project_name?></td><!-- Ticket No-2799|Added By Uvini -->
        <td><?=$row->lot_number?></td>
        <td align="right"><?=$row->extend_perch?></td>
        <td align="right"><?=number_format($outright_amount,2)?></td>
        <td align="right"><?=number_format($zep_amount,2);?></td>
        <td align="right"><?=number_format($nep_amount,2);?></td>
        <td align="right"><?=number_format($epb_amount,2);?></td>
        <td align="right"><?=number_format($row->discounted_price,2)?></td>
        <td align="right"> <?=number_format($row->full_cost,2)?></td>
        </tr>
       
        <? 
        $outright_tot = $outright_tot + $outright_amount;
        $zep_tot = $zep_tot + $zep_amount;
        $nep_tot = $nep_tot + $nep_amount;
        $epb_tot = $epb_tot + $epb_amount;
        $discounted_tot = $discounted_tot + floatval($row->discounted_price);
        $outright_amount=$zep_amount = $nep_amount = $epb_amount = 0;
		}}?>
		<tr>
			<td colspan="3"></td>
			<td align="right" style="border-bottom:1px solid black"><?=number_format($outright_tot,2)?></td>
			<td align="right" style="border-bottom:1px solid black"><?=number_format($zep_tot,2)?></td>
			<td align="right" style="border-bottom:1px solid black"><?=number_format($nep_tot,2)?></td>
			<td align="right" style="border-bottom:1px solid black"><?=number_format($epb_tot,2)?></td>
			<td align="right" style="border-bottom:1px solid black"><?=number_format($discounted_tot,2)?></td>
			<td></td>
		</tr>
         </table></div>
    </div> 
    
</div>

<script type="text/javascript">
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
  tableToExcel('table', 'Turn Over Report', 'Turn_over_report_as_at_<?=$todate;?>.xls');
 });    
</script>