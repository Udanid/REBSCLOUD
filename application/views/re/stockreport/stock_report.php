
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
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <?
   if($type == 1)
   	$heading2=' Available Stock Report as at '.$todate;
   else
   	$heading2=' Advanced Stock Report as at '.$todate;

 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
    <h4><?=$heading2?> 
       <span style="float:right"> 
       <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
         <div class="tableFixHead">             
      <table class="table table-bordered" id="table"><thead>
      	<tr><th colspan="5" style="text-align:center;"><?=$heading2?></th></tr>
      	<tr class="success"><th  >Project Name</th><th  >Lot Number</th>
     <th >Stock</th><th >Profit</th><th >Sale Value</th>
        </tr>
       
       </thead>
    <? 
	$fullcost=0;$fullsale=0;$fullprofit=0;$lastlotcount=0;$thislotcount=0;$fulllotcount=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
			if(check_priclist_confirm($prjraw->prj_id,$todate)){//report helper function
			//echo $prjraw->prj_id;
		$prjcost=0;$prjprofit=0;$prjsale=0;$lotcount=0;
			?>
        
        <? if($lotdata[$prjraw->prj_id]){
			?>
            <tr class="active"><td><?=$prjraw->project_name?></td><td></td>
        
        <td></td><td></td><td></td></tr>
            <?
			foreach($lotdata[$prjraw->prj_id] as $raw){
				
				if($type=='01')
				{
					//$check=false;
					$check=check_available_lot($raw->lot_id,$todate);//report helper function
					//	if($raw->status=='PENDING')
					//	$check=true;
				}
				else
				$check=check_advance_lot($raw->lot_id,$todate);//report helper function
				if($check)
				{
					$lotcount++;
					$fulllotcount++;
					$prjcost=$prjcost+$raw->costof_sale;
					$prjprofit=$prjprofit+($raw->sale_val-$raw->costof_sale);
					$prjsale=$prjsale+$raw->sale_val;
					
					$fullcost=$fullcost+$raw->costof_sale;
					$fullprofit=$fullprofit+($raw->sale_val-$raw->costof_sale);
					$fullsale=$fullsale+$raw->sale_val;
				?>
                <tr ><td></td><td><?=$raw->lot_number?></td>
                <td align="right"><?=number_format($raw->costof_sale,2)?></td>
                 <td align="right"><?=number_format($raw->sale_val-$raw->costof_sale,2)?></td>
                  <td align="right"><?=number_format($raw->sale_val,2)?></td>
                </tr>
       		 <? }}}?>
          <?
		
		?>
        <? if($prjcost>0){?>
         <tr class="active"  style="font-weight:bold"><td></td><td><?=$lotcount?></td>
        <td align="right"><?=number_format($prjcost,2)?></td>
         <td align="right"><?=number_format($prjprofit,2)?></td>
          <td align="right"><?=number_format($prjsale,2)?></td>
        </tr><? }?>
        
      <? }} }?>
       <tr class="info" style="font-weight:bold"></td><td></td><td><?=$fulllotcount?></td>
        <td align="right"><?=number_format($fullcost,2)?></td>
         <td align="right"><?=number_format($fullprofit,2)?></td>
          <td align="right"><?=number_format($fullsale,2)?></td>
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
  tableToExcel('table', 'Stock Report', 'stock_report_as_at_<?=$todate?>.xls');
 });
</script>