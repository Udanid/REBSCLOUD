 <?$this->load->model("loan_model");?>
<script type="text/javascript">

function load_lotinquary(id,prj_id)
{
	 if(id!="")
	 {
		// var prj_id= document.getElementById("prj_id").value
	//	alert("<?=base_url()?>re/lotdata/get_fulldata/"+id+"/"+prj_id)
	 	 $('#popupform').delay(1).fadeIn(600);
   		   $( "#popupform").load( "<?=base_url()?>re/lotdata/get_fulldata_popup/"+id+"/"+prj_id );
	 }
}

</script>
<script>
var $th = $('.tableFixHead').find('thead th')
$('.tableFixHead').on('scroll', function() {
  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
});
</script>
<style>
.tableFixHead { overflow-y: auto; height: 500px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style> 

    <?
 
   $heading2=' Block Details Report as at '.$date;

 ?>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
		 <div class="form-group" style="margin-left: 100%;">
                        <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
                    </div>
       <span style="float:right">     
      <!--  <a href="javascript:load_printscrean1('<?=$branchid?>','<?=$type?>','<?=$fromdate?>','<?=$todate?>','<?=$prj_id?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>   -->
       
       
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
      <div class="tableFixHead">               
      <table class="table table-bordered" id="table_data">
      <thead><tr class="success"><th >Project Name</th><th  >Lot Number</th>
      <th  >Status</th>  <th  >Customer Name</th>
        <th > Reservation Code </th><th > Selling Price </th><th >Discounted Selling Price</th>
      <th >Paid Total</th><th >Balance Amount</th><th ></th>
        </tr>
        </tr>
       </thead>
       <tbody>
       <?if($dataset)
       $selling_price_total = 0;
       $discounted_selling_price_total = 0;
       $paid_total = 0;
       $balance_amount = 0;
       {foreach($dataset as $row){?>
       <tr>
	       <td><?=$row->project_name?></td>
	       <td><a href="javascript:load_lotinquary(<?=$row->lot_id?>)" ><?=$row->lot_number?></a></td>

	       <?if($reservedblock[$row->lot_id]){if($reservedblock[$row->lot_id]->profit_date == ""){?>
	       	 <td>RESERVED</td>
	       <?}else{if($reservedblock[$row->lot_id]->profit_date > $date){?>
	       <td>RESERVED</td>
	       <?}else{?>
	       	<td>SOLD</td>
	       <?}}}else{?>
	       <td><?=$row->status?></td><?};?>

	       <?if($reservedblock[$row->lot_id]){?>
	       <td><?=$reservedblock[$row->lot_id]->full_name?></td>
	       <?}else{?>
	       <td></td><?};?>
	       <?if($reservedblock[$row->lot_id]){?>
	       <td><?=$reservedblock[$row->lot_id]->res_code?></td>
	       <?}else{?>
	       <td></td><?};?>
	       <td style="text-align:right;"><?=number_format($row->sale_val,2)?></td>
	       <?$selling_price_total = floatval($selling_price_total) + floatval($row->sale_val)?>
	       <?if($reservedblock[$row->lot_id]){?>
	       <td style="text-align:right;"><?=number_format($reservedblock[$row->lot_id]->discounted_price,2)?></td>
	       <?$discounted_selling_price_total = floatval($discounted_selling_price_total) + floatval($reservedblock[$row->lot_id]->discounted_price)?>
	       <?}else{?>
	       <td></td><?};?>
	       <?if ($reservedblock[$row->lot_id]){?>
	       	<? $tot = cal_tot_amount($reservedblock[$row->lot_id]->res_code,$date);
	       	$paid_total = floatval($paid_total) + floatval($tot);
	       	?>
	       <td style="text-align:right;"><?=number_format($tot,2)?></td><?}
	       else{?>
		   <td></td><?}?>
		    <? if ($reservedblock[$row->lot_id]){
		    	$balance_amount = floatval($balance_amount) + floatval(($reservedblock[$row->lot_id]->discounted_price-$tot))?>
	       <td style="text-align:right;"><?=number_format(($reservedblock[$row->lot_id]->discounted_price-$tot),2)?></td><? }
	       else{ ?>
		   <td></td><?}?>
   	   </tr>
       <?}};?>
    	<tr>
    		<td colspan="5" style="text-align:center;background-color:#fdfd66;"><strong>Total</strong></td>
    		<td style="text-align:right;background-color:#fdfd66;"><strong><?=number_format($selling_price_total,2)?></strong></td>
    		<td style="text-align:right;background-color:#fdfd66;"><strong><?=number_format($discounted_selling_price_total,2)?></strong></td>
    		<td style="text-align:right;background-color:#fdfd66;"><strong><?=number_format($paid_total,2)?></strong></td>
    		<td style="text-align:right;background-color:#fdfd66;"><strong><?=number_format($balance_amount,2)?></strong></td>
    	</tr>
         </tbody></table></div></div>
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
  tableToExcel('table_data', 'Block Details Report', 'Block_Details_Report_as_at_<?=$date;?>.xls');
 });    
</script>