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
  $heading2=' Payment Report from '.$fromdate.' to '.$todate;
 
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
       <tr><th >Date</th><th>Voucher No</th><th >Cheque No</th>
      <th >Name</th><th >Description</th><th>Unit no</th><th>Project Name</th><th>Amount
</th></tr>
        <?if($report_data){foreach($report_data as $row){?>
          <tr>
            <td><?=$row->create_date;?></td>
             <td><?=$row->voucher_ncode;?></td>
             <td><?=$row->CHQNO;?></td>
             <td><?=$row->name;?></td>
             <td><?=$row->paymentdes;?></td>
             <td><?=$row->lot_number;?></td>
             <td><?=$row->project_name;?></td>
             <td><?=number_format($row->amount,2);?></td>
          </tr>
          <?}};?>
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
  tableToExcel('table', 'Payment Report', 'HM_payment_Report_from_<?=$fromdate;?>_to_<?=$todate;?>.xls');
 });    
</script>