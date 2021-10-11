<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
	  
	 $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		$('#todate').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
		date = $(this).datepicker('getDate');
		var maxDate = new Date(date.getTime());
		maxDate.setDate(maxDate.getDate() + 365); //add 31 days to from date
		$('#todate').datepicker('option', 'maxDate', maxDate);
		setTimeout(function() { $('#todate').focus(); }, 0);
	}});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	  
 	 $("#month").chosen({
     allow_single_deselect : true
    });
	
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
		tableToExcel('tbtable', 'Trial Balance', 'Trial_Balance_<?=date('Y_m_d');?>.xls');
		// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
	}); 
  });
</script>

<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Trial Balance</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
       <div class="form-body ">
	   <?php
	   	echo form_open('accounts/report/trialbalance_period/' );
		?>
       <div class="form-group">
     	<?			
	//	echo form_submit('submit', 'Show');
	?><div class="col-sm-3 "> 
    										<select class="form-control"   placeholder="Select Month" name="month" id="month">
                                            <option value="">Select Month</option>
                                             <option value="01">January</option>
                                             <option value="02">February</option>
                                             <option value="03">March</option>
                                             <option value="04">April</option>
                                             <option value="05">May</option>
                                             <option value="06">June</option>
                                             <option value="07">July</option>
                                             <option value="08">August</option>
                                             <option value="09">September</option>
                                             <option value="10">October</option>
                                              <option value="11">November</option>
                                              <option value="12">December</option>
                                            </select></div>
                                            <div class="col-sm-3 ">
                                              <input type="text" name="fromdate" id="fromdate" placeholder="From Date" autocomplete="off"  class="form-control" >
                                            </div>
                                              <div class="col-sm-3 ">
                                              <input type="text" name="todate" id="todate" placeholder="To Date" autocomplete="off"  class="form-control" >
                                            </div>
											 <div class="col-sm-3 ">
												<button type="submit" class="btn btn-primary ">Show</button> </div>
											</div>
											<div class="clearfix"> </div><div class="clearfix"> </div><br>	
								
    <?
		echo "</p>";
		echo form_close();
	
// Modification done by udani Date : 12-09-2013
	$temp_dr_total = 0;
	$temp_cr_total = 0;
	$op_dr_total = 0;
	$op_cr_total = 0;
	$cl_dr_total = 0;
	$cl_cr_total = 0;

	echo "<table border=0 id=\"tbtable\" cellpadding=5 class=\"simple-table trial-balance-table\">";
	?>
    <thead>
        <tr>
            <th></th>
            <th align="justify">
                
                    <p style="font-size:14px;"><?=strtoupper(companyname)?>. <?=date('Y', strtotime('-1 year'))?>-<?=date('Y')?> Trial Balance As of <?=date('M d, Y')?></p>
   
            </th>
            <th></th>
            <th></th>
        </tr>
   </thead>
    <?php
	echo "<tr><td style='border-bottom:1px solid #000; border-top:1px solid #000;'><strong>Ledger Code</strong></td><td style='border-bottom:1px solid #000; border-top:1px solid #000;'><strong>Ledger Name</strong></td><td style='text-align:right; border-bottom:1px solid #000; border-top:1px solid #000;'><strong>Debit</strong></td><td style='text-align:right; border-bottom:1px solid #000; border-top:1px solid #000;'><strong>Credit</strong></td></tr>";
	$this->load->model('Ledger_model');
	$all_ac_ledgers = $this->Ledger_model->get_all_ac_ledgers_fortb();
	$odd_even = "odd";
	foreach ($all_ac_ledgers as $ledger_id => $ledger_name)
	{
		if ($ledger_id == "0") continue; // modaification done by udani . Reasone : allow string ladger ids
		echo "<tr class=\"tr-" . $odd_even . "\">";
		$array=explode('#',$ledger_name);
		$name = trim($array[0]);
		$group=explode('-',$array[1]);
		
		echo "<td>";
		echo  anchor('accounts/report/ac_ledgerst/' . $ledger_id,$ledger_id, array('title' => $array[0] . ' Ledger Statement', 'class' => 'anchor-link-a','target' => '_blank'));
		//echo  $ledger_id;
		echo "</td>";
		echo "<td>";
		echo  substr($array[1].':'.$name,0, -10);
		echo "</td>";

		
		echo "<td align=right>";
		$dr_total = $this->Ledger_model->get_dr_total($ledger_id);
		if ($dr_total)
		{
			echo number_format($dr_total,2,'.',',');
			$temp_dr_total = float_ops($temp_dr_total, $dr_total, '+');
		} else {
			echo "0";
		}
		echo "</td>";
		echo "<td align=right>";
		$cr_total = $this->Ledger_model->get_cr_total($ledger_id);
		if ($cr_total)
		{
			echo number_format($cr_total,2,'.',',');
			$temp_cr_total = float_ops($temp_cr_total, $cr_total, '+');
		} else {
			echo "0";
		}
		echo "</td>";
			
		echo "</tr>";
		$odd_even = ($odd_even == "odd") ? "even" : "odd";
	}
	if($temp_dr_total < $temp_cr_total){
		echo "<tr><td colspan=2>Suspense Amount ";
		echo "</td<td></td><td align=right>Dr " . number_format(convert_cur($temp_cr_total-$temp_dr_total),2,'.',',') . "</td><td></td></tr>";
	}
	if($temp_dr_total > $temp_cr_total){
		echo "<tr><td colspan=2>Suspense Amount ";
		echo "</td><td></td><td align=right>Cr " . number_format(convert_cur($temp_dr_total-$temp_cr_total),2,'.',',') . "</td></tr>";
	}
	echo "<tr class=\"tr-total\"><td colspan=2>TOTAL ";
	if (float_ops($temp_dr_total, $temp_cr_total, '=='))
		echo "<img src=\"" . asset_url() . "images/icons/match.png\">";
	else
		echo "<img src=\"" . asset_url() . "images/icons/nomatch.png\">";
	echo "</td><td style='border-top:1px solid #000; border-bottom:double 1px #000000;'>Dr " . number_format(convert_cur($temp_dr_total),2,'.',',') . "</td><td  style='border-top:1px solid #000; border-bottom:double 1px #000000;'>Cr " . number_format(convert_cur($temp_cr_total),2,'.',',') . "</td></tr>";
	echo "</table>";

?>
	
	</div> </div>
        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
        </div>
        
        
        
        <div class="clearfix"> </div>
    </div>
</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>

