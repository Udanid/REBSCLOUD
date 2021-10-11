
<script type="text/javascript">

function load_printscrean1(branch,year,month)
{
			window.open( "<?=base_url()?>re/summeryreport/collection_summery_excel/"+year+'/'+branch+'/'+month);
	
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
 if($month!=''){
  $heading2=' Collection Summery Report ';
 }
 else{
   $heading2='  Collection Summery Report From '.$stdate.' To '.$enddate;
 }
 
 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">       
        <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></i></a>
    
      
       
       
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
      <div class="tableFixHead">               
      <table class="table table-bordered" id="table"><thead>
      	<tr><th colspan="6" style="text-align:center"><?=$heading2?></th></tr>
      	<tr class="success"><th >Project Name</th><th>DP Debtor</th><th>ZEP Debtor</th><th >EP Debtor</th>
      <th >EPB Debtor</th><th >Total</th>
        </tr>
        </tr>
       </thead>
       
    <? 
	
	
	if($prjlist){$fulldbdebtor=0;$fullnepdebtor=0;$fullepbdebtor=0; $fulltot=0; $fullprjlastbal=0;$fullzepdebtor=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			$dbdebtor=$advance[$prjraw->prj_id];
			$zepdebtor=$zep[$prjraw->prj_id]->sum_cap+$zep[$prjraw->prj_id]->sum_di;
			
			$nepdebtor=$nep[$prjraw->prj_id]->sum_cap+$nep[$prjraw->prj_id]->sum_int+$nep[$prjraw->prj_id]->sum_di;
			//$epbdebtor=$epb[$prjraw->prj_id]->sum_cap+$epb[$prjraw->prj_id]->sum_int+$epb[$prjraw->prj_id]->sum_di;
			$epbdebtor=$epb[$prjraw->prj_id];//->sum_cap+$epb[$prjraw->prj_id]->sum_int+$epb[$prjraw->prj_id]->sum_di;
			$prjtot=$dbdebtor+$nepdebtor+$epbdebtor +$zepdebtor;
			$fulldbdebtor=$fulldbdebtor+$dbdebtor;
			$fullnepdebtor=$fullnepdebtor+$nepdebtor;
			$fullepbdebtor=$fullepbdebtor+$epbdebtor;
			$fullzepdebtor=$fullzepdebtor+$zepdebtor;
			$fulltot=$fulltot+$prjtot;
			
			?>
        <tr ><td><?=$prjraw->project_name?></td>
        <td align="right"><?=number_format($dbdebtor,2)?></td>
         <td align="right"><?=number_format($zepdebtor,2)?></td>
        <td align="right"><?=number_format($nepdebtor,2)?></td>
        <td  align="right"><?=number_format($epbdebtor,2)?></td>
        
        <td align="right"><?=number_format($prjtot,2)?></td></tr>
       
        <? }}?>
        
        
       <tr class="active" style="font-weight:bold"><td>Total</td>
        <td align="right"><?=number_format($fulldbdebtor,2)?></td>
         <td align="right"><?=number_format($fullzepdebtor,2)?></td>
         <td align="right"><?=number_format($fullnepdebtor,2)?></td>
          <td align="right"><?=number_format($fullepbdebtor,2)?></td>
          <td align="right"><?=number_format($fulltot,2)?></td>
       
         
        </tr>
         </table></div></div>
    </div> 
    
</div>

<script type="text/javascript">
	//Ticket No:3232 Added By Madushan 2021-08-02
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
  tableToExcel('table', 'Collection Summery Report', 'collection_summery_report_from_<?=$stdate?>_to_<?=$enddate?>.xls');
 });    
</script>