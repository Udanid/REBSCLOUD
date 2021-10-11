<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
if($month!="0")
{
	if($month=='01' ||$month=='02' || $month=='03')
	{ 
	
	$yeararr=explode('-',$this->session->userdata('fy_end'));
	}
	else
	{
		$yeararr=explode('-',$this->session->userdata('fy_start'));
	}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

	$year=$yeararr[0];
	$stdate=$year.'-'.$month.'-01';
	$enddate=$year.'-'.$month.'-31';
	
}
else if($fromdate !="" &  $todate !="")
{
	$stdate=$fromdate;
	$enddate=$todate;
}
else
{
	$stdate=$this->session->userdata('fy_start');
	$enddate=$this->session->userdata('fy_end');
}

define("FYSTV",$stdate);
define("FYENDV",$enddate);
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

<script type="text/javascript">

 $( function() {
    $( "#fromdate" ).datepicker({dateFormat: 'yy-mm-dd',onSelect: function(selectedDate) {
		$('#todate').datepicker('option', 'minDate', selectedDate); //set todate mindate as fromdate
		date = $(this).datepicker('getDate');
		var maxDate = new Date(date.getTime());
		maxDate.setDate(maxDate.getDate() + 365); //add 31 days to from date
		$('#todate').datepicker('option', 'maxDate', maxDate);
		setTimeout(function() { $('#todate').focus(); }, 0);
	}});
	 $( "#todate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
  $(document).ready(function() {
  $("#ledger_id").chosen({
     allow_single_deselect : true
    });
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
		tableToExcel('gltable', 'General Ledger', 'General_Ledger_<?=date('Y_m_d');?>.xls');
		// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
	});
  });
</script>
<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">General Ledger Statement</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
	</div>
       <div class="form-body ">
              <?php
$page_count = 0;
	//if ( ! $print_preview)
	//{
		echo form_open('accounts/report/generalledger/');
		?>
       <div class="form-group">
          	<div class="col-sm-3"> 
                  <select class="form-control"   placeholder="Select Month" name="month" id="month">
                  	   <option value="00">Select Month</option>
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
                  </select>
             </div>
             
              <div class="col-sm-3 ">
                      <input type="text" name="fromdate" id="fromdate" autocomplete="off" placeholder="From Date"  class="form-control" >
                    </div>
                      <div class="col-sm-3 ">
                      <input type="text" name="todate" id="todate" placeholder="To Date" autocomplete="off"  class="form-control" >
                    </div>
											 <div class="col-sm-3 ">
												<button type="submit" class="btn btn-primary ">Show</button> </div>
											</div>
											<div class="clearfix"> </div><div class="clearfix"> </div><br>	
								
    <?php
		echo "</p>";
		echo form_close();
	if ($fromdate || $todate ||  $month != ''){
	?>
  

    
    <?
		//hard coding ledger group numbers to get listed in right order
		echo "<table class=\"table table-bordered\" id=\"gltable\">";

		echo "<thead>
					<tr>
						<th colspan=\"11\">
							<div class=\"form-title\">
								<h4><?=strtoupper(companyname)?><br>General Ledger Statement from ".FYSTV." to ".FYENDV."</h4>
							</div>
						</th>
					</tr>
					<tr>
						<th>Type</th>
						<th>Date</th>
						<th>No.</th>
						<th>Ledger Name</th>
						<th>Memo</th>
						<th>Project Name </th>
						<th>Lot Number </th>
						<th>Split</th>
						<th>Dr Amount</th>
						<th>Cr Amount</th>
						<th>Balance</th>
		</tr></thead>";
		$odd_even = "odd";
		$cur_drtotal = 0;
		$cur_crtotal = 0;
		$cur_balance = 0;
		
		//$ledger_groups = array(29,43,30,44,7,45,46,53,54,55,31,58,51,50,57,49,56,17,33,60,59,34,15,36,38,61,37,39,52,48);
		$ledger_groups = array(6,7,9,11,15,17,19,20,21,23,24,26,27,29,30,31,33,34,36,37,38,39,40,41,42,43,44,45,46,48,49,50,51,52,53,54,55,56,57,58,59,60,61);
		//$ledger_groups = array(29,43,30,44,7,45); //for testing only
			foreach($ledger_groups as $key=>$value){
				$debit_total = 0;
				$credit_total = 0;
				$group = $this->Ledger_model->get_group($value);
				//get ledgers for each group
				$data = $this->Ledger_model->get_ledgers_by_groupid($value);
					if($data){
						foreach ($data as $ledgers){
							$current_ledger = $this->Ledger_model->getLedgerbyID($ledgers->id);
							//get transactions for ledger
							$ac_ledgerst_q = $this->Ledger_model->get_transactions_by_ledgerid($ledgers->id,FYSTV,FYENDV);
							if ($ac_ledgerst_q)
								foreach ($ac_ledgerst_q as $row){
								$current_entry_type = entry_type_info($row->ac_entries_entry_type);
									echo "<tr class=\"tr-" . $odd_even . "\">";
									echo "<td>";
									echo $current_entry_type['name'];
									echo "</td>";
									echo "<td>";
									echo date('d/m/Y',strtotime($row->ac_entries_date));
									echo "</td>";
									echo "<td>";
									echo anchor('accounts/entry/view/' . $current_entry_type['label'] . '/' . $row->ac_entries_id, full_entry_number($row->ac_entries_entry_type, $row->ac_entries_number), array('title' => 'View ' . ' Entry', 'class' => 'anchor-link-a'));
									echo "</td>";
									echo "<td>";
									echo anchor('accounts/report/ac_ledgerst/'.$current_ledger->id, $current_ledger->name, array('title' => 'View ' . ' Ledger', 'class' => 'anchor-link-a'));							echo "</td>";
									echo "<td>";
									if ($row->ac_entries_narration)
										echo character_limiter($row->ac_entries_narration, 50);
									echo "</td>";
									echo "<td>";
									echo $row->project_name;
									echo "</td>";
									echo "<td>";
									echo $row->lot_number ;
									echo "</td>";
									echo "<td>";
									echo $this->Ledger_model->get_opp_ledger_name($row->ac_entries_id, $current_entry_type['label'], $row->ac_entry_items_dc, 'html');
									echo "</td>";
									if ($row->ac_entry_items_dc == "D")
									{
										$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '+');
										echo "<td align=\"right\">";
										echo convert_amount_dc2($row->ac_entry_items_amount);
										$debit_total = float_ops($debit_total, $row->ac_entry_items_amount, '+');
										$cur_drtotal = float_ops($cur_drtotal, $row->ac_entry_items_amount, '+');
										echo "</td>";
										echo "<td></td>";
									} else {
										$cur_balance = float_ops($cur_balance, $row->ac_entry_items_amount, '-');
										echo "<td></td>";
										echo "<td align=\"right\">";
										echo convert_amount_dc2($row->ac_entry_items_amount);
										$credit_total = float_ops($credit_total, $row->ac_entry_items_amount, '+');
										$cur_crtotal = float_ops($cur_crtotal, $row->ac_entry_items_amount, '+');
										echo "</td>";
									}
									echo "<td align=\"right\">";
									echo convert_amount_dc($cur_balance);
									echo "</td>";
									echo "</tr>";
									$odd_even = ($odd_even == "odd") ? "even" : "odd";
							}
							
						}
						if($debit_total || $credit_total !=0)
						echo "<tr>
							<td colspan=8 style=\"border-top:1px solid #000; background-color:#ccc;\">".$group->name."</td>
							<td align=\"right\" style=\"border-top:1px solid #000; background-color:#ccc;\">".convert_amount_dc2($debit_total)."</td>
							<td align=\"right\" style=\"border-top:1px solid #000; background-color:#ccc;\">".convert_amount_dc2($credit_total)."</td>
							<td align=\"right\" style=\"border-top:1px solid #000; background-color:#ccc;\">".convert_amount_dc($cur_balance)."</td>
						</tr>";
					}
			}
			
		/* Current Page Closing Balance */
			echo "<tr>
				<td colspan=8 style=\"border-top:1px solid #000; background-color:#6699CC;\"><strong>Total</strong></td>
				<td align=\"right\" style=\"border-top:1px solid #000; border-bottom:border-top:1px double #000; background-color:#6699CC;\"><strong>".convert_amount_dc2($cur_drtotal)."</strong></td>
				<td align=\"right\" style=\"border-top:1px solid #000; border-bottom:border-top:1px double #000; background-color:#6699CC;\"><strong>".convert_amount_dc2($cur_crtotal)."</strong></td>
				<td align=\"right\" style=\"border-top:1px solid #000; border-bottom:border-top:1px double #000; background-color:#6699CC;\"><strong>".convert_amount_dc($cur_balance)."</strong></td>
			</tr>";
		echo "</table>";
		}else{
			echo 'Please select a month or date range!';	
		}
	
?>
 

<?php
  //$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
//  echo "<a href='$url'>Back</a>"; 
?></div> </div>
        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
        </div>
        
        
        
        <div class="clearfix"> </div>
    </div>
</div>
		<!--footer-->
<?php
	$this->load->view("includes/footer");
?>