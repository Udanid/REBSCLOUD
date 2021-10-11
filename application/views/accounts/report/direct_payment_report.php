 <?
 if($from == 'all' || $to == 'all')
  $heading ='Direct Cash Payment Report';
else
  $heading = 'Direct Cash Payment Report from '.$from.' to '.$to; 
 ?>
 <div>
   <span style="float:left"> <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
    </span>
 </div>
 <div class="widget-shadow">
 
 <table class="table table-bordered" id="table"> <thead> <tr><th colspan="9" style="text-align:center;"><h4><?=$heading?></h4></th></tr> <tr><th> #</th> <th> Date</th> <th>Officer</th> <th>Supplier</th>  <th>Paid Amount</th> <th>Description</th><th>Payment Added By</th> <th>Confirmed By</th><th> Status</th></tr> </thead>
                      <? if($data_list){$c =0;
                          foreach($data_list as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->serial_number?></th>
                        <th scope="row"><?=$row->paid_date?></th> 
                        <td><?=$row->initial?> <?=$row->surname?></td>
                          <td scope="row"><?=$row->sup_name?></td> 
                            <td><?=number_format($row->pay_amount,2) ?></td>
                            
                        
                             <td><?=$row->note ?></td>
                             <td><?=get_user_fullname_id($row->paid_by)?></td>
                             <td><?=get_user_fullname_id($row->confirm_by)?></td>
                               <td><?=$row->status ?></td>
</tr>
<?}}?>
</tbody>
</table>
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
  tableToExcel('table', 'Direct Payment Report', 'direct_payment_report.xls');
 });   
</script>