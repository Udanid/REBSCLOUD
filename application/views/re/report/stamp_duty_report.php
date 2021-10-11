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

 	if($quarter_range == "")
 	{
 		$heading2=' Stamp Duty Report from '.$fromdate.' to '.$todate;
 		$date_range = $fromdate.' - '.$todate;	
 	}
 	else
 	{
 		$heading2=' Stamp Duty Report '.$quarter_range;
 		$date_range = $quarter_range;
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
       <tr><th >Period</th><th>No of Receipts</th><th >Receipt Amount</th>
      <th >Stamp Duty</th></tr>
		<tr>
        <td><?=$date_range?></td>
        <td align="right"><?=$no_of_rct;?></td>
        <td align="right"><?=number_format(floatval($rct_tot),2);?></td>
        <td align="right"><?=number_format((intval($no_of_rct)*25),2);?></td>
    	</tr>
    	<tr>
        <td colspan="3"> </td>
        <td align="right" style="border-bottom:2px solid black"><?=number_format((intval($no_of_rct)*25),2);?></td>
        </tr>
        <tr>
        <td><b><?=$this->session->userdata('username')?><br>..........................................<br>Prepared By<br>Snr.Accounts Executive</b></td>
        <td><b><br>..........................................<br>Checked By<br>Assistant Accountant</b></td>
        <td></td>
        <td><b><br>..........................................<br>Authorized By<br>AGM - Finance</b></td>
        </tr>
         </table></div>

         <div class="form-title">
         	<h4>Stamp Duty Report Details</h4>
         </div>
         <table class="table table-bordered" id="table_details">
       <tr><th >Receipt No</th><th>Receipt Date</th><th>Amount</th>
      <th >Project</th> <th >Lot No</th></tr>
      <?if($stamp_report_data){foreach($stamp_report_data as $row){?>
		<tr>
        <td><?=$row->rct_no;?></td>
        <td><?=$row->entry_date;?></td>
        <td align="right"><?=number_format($row->pay_amount,2);?></td>
        <td><?=$row->project_name;?></td>
        <td><?=$row->lot_number;?></td>
        </tr>
        <?}};?>
        <tr>
        	<td colspan="2"></td>
        	<td align="right" style="border-bottom:2px solid black"><?=number_format(floatval($rct_tot),2);?></td>
        	<td colspan="2"></td>
        </tr>
        <tr>
        <td><b><?=$this->session->userdata('username')?><br>..........................................<br>Prepared By<br>Snr.Accounts Executive</b></td>
        <td><b><br>..........................................<br>Checked By<br>Assistant Accountant</b></td>
        <td></td>
        <td colspan="2"><b><br>..........................................<br>Authorized By<br>AGM - Finance</b></td>
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
  tableToExcel('table', 'Stamp Duty Report', 'Stamp_duty_report_<?=$date_range;?>.xls');
   tableToExcel('table_details', 'Stamp Duty Report Details', 'Stamp_report_detils_<?=$date_range;?>.xls');
 });    
</script>