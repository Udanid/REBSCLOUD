<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
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
		tableToExcel('cftable', 'Cash Flows', 'Cash_Flows_<?=date('Y_m_d');?>.xls');
		// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
	});
  });
</script>

<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Cash Flow</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
       <div class="form-body ">
	    <?php
	   	echo form_open('accounts/report/cashflow_period/' );
		?>
       <div class="form-group">
     	<?			
	//	echo form_submit('submit', 'Show');
	?><!--<div class="col-sm-3 "> 
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
                                            </div>-->
                                              <div class="col-sm-3 ">
                                              <input type="text" name="todate" id="todate" placeholder="To Date"  autocomplete="off" class="form-control" >
                                            </div>
											 <div class="col-sm-3 ">
												<button type="submit" class="btn btn-primary ">Show</button> </div>
											</div>
											<div class="clearfix"> </div><div class="clearfix"> </div><br>	
								
    <?
		echo "</p>";
		echo form_close();
		$this->load->library('Accountlistcf');
		$spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		if($month!="")
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
		  else if($todate !="")
		  {
			  $stdate=$this->session->userdata('fy_start');
			  $enddate=$todate;
		  }
		  else
		  {
			  $stdate=$this->session->userdata('fy_start');
			  $enddate=$this->session->userdata('fy_end');
		  }
		  
		  $date = strtotime($stdate.'-1 year');
		  $lastyear = date('Y-m-d',$date);
		  
		  define("FYSTV",$stdate);
		  define("FYENDV",$enddate);

	?>
	<table width="100%" border="0" cellspacing="0" id="cftable" cellpadding="0" class="table table-bordered table2excel">
    	<thead>
        	<tr>
            	
            	<th colspan="2" align="justify">
        					<h4 align="center"><?=strtoupper(companyname)?>. <?=date('Y',strtotime("-1 year", time())).'-'.date('Y')?><br>
                            Statement of Cash Flows<br>
                            <?
                            $sdate = strtotime(FYSTV);
							$newsdate = date('F Y',$sdate);
							
							$edate = strtotime(FYENDV);
							$newedate = date('F Y',$edate);
							?>
                            <?=$newsdate?> Through <?=$newedate?></h4>
        		</th>
            </tr>
       </thead>
       <tbody>
            <tr>
            	<td>OPERATING ACTIVITIES</td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer;?>Net Income (Loss)</td>
                <td align="right"><? 
					//Net Income (Group 19)
					//$net_income_total = '';
					//$net_income = new Accountlistcf();
					//$net_income->init(19,FYSTV,FYENDV);
					//$net_income->account_st_short(0,$type = 'L2');
					//$net_income_total = float_ops($net_income_total, $net_income->total, '-');
					$net_income_total = calculate_netprofit(FYSTV,FYENDV);
					if($net_income_total < 0){
						$net_income_total = $net_income_total * -1;
					}
					if($net_income_total > 0){
						echo convert_account($net_income_total).$spacer;
					}else{
						echo '('.convert_account($net_income_total).')'.$spacer;
					}
					?>
            	</td>
            </tr>
            <tr>
            	<td><?=$spacer;?>Adjustments to reconcile Net Income to net cash provided by operations:</td>
                <td></td>
            </tr>
            <? 
			/*lst year calculations*/
			//Debtor (Group 10)
			$debtors_total = '';
			$debtors = new Accountlistcf();
			$debtors->init(71,$lastyear,$stdate);
			//$debtors->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$debtors_total = float_ops($debtors_total, $debtors->total, '+');
			$debtors2 = new Accountlistcf();
			$debtors2->init(54,$lastyear,$stdate);
			//$debtors->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$debtors_total = float_ops($debtors_total, $debtors2->total, '+');
			$debtors3 = new Accountlistcf();
			$debtors3->init(63,$lastyear,$stdate);
			//$debtors->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$debtors_total = float_ops($debtors_total, $debtors3->total, '+');
			
			//Provision for RE Project (Group 39)
			$provisionforre_total = '';
			$provisionforre = new Accountlistcf();
			$provisionforre->init(66,$lastyear,$stdate);
			//$provisionforre->account_st_short(0,$type = 'L3',$color='');
			
			$provisionforre_total = float_ops($provisionforre_total, $provisionforre->total, '+');
		
			
		
			$provisionforre2 = new Accountlistcf();
			$provisionforre2->init(39,$lastyear,$stdate);
			//$provisionforre->account_st_short(0,$type = 'L3',$color='');
			
			$provisionforre_total = float_ops($provisionforre_total, $provisionforre2->total, '+');
			
			//stock (Group 53)
			$stock_total = '';
			$stock = new Accountlistcf();
			$stock->init(53,$lastyear,$stdate);
			//$stock->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$stock_total = float_ops($stock_total, $stock->total, '+');
			
			//Unrealised(Group 62)
			$unrealised_total = '';
			$unrealised = new Accountlistcf();
			$unrealised->init(62,$lastyear,$stdate);
			//$stock->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$unrealised_total = float_ops($unrealised_total, $unrealised->total, '+');
			
			//Deposits & Pre-payments CL (Group 51)
			$deposit_total = '';
			$deposit = new Accountlistcf();
			$deposit->init(51,$lastyear,$stdate);
			//$deposit->account_st_short(0,$type = 'L1',$color='');
			$deposit_total = float_ops($deposit_total, $deposit->total, '+');
			
			//Advance on Lands (Group 31)
			$advanceonlands_total = '';
			$advanceonlands = new Accountlistcf();
			$advanceonlands->init(31,$lastyear,$stdate);
			//$advanceonlands->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$advanceonlands_total = float_ops($advanceonlands_total, $advanceonlands->total, '+');
			
			//Other Advance Payment (Group 58)
			$otheradvance_total = '';
			$otheradvance = new Accountlistcf();
			$otheradvance->init(58,$lastyear,$stdate);
			//$otheradvance->account_st_short(0,$type = 'L1',$color='');
			$otheradvance_total = float_ops($otheradvance_total, $otheradvance->total, '+');
			
			$current_aasets_total = $debtors_total+$provisionforre_total+$stock_total+$deposit_total+$advanceonlands_total+$otheradvance_total+$unrealised_total;
			
			//Directors' current ACCOUNT (Group 36)
			$directors_curetna_acc_total = '';
			$directors_curetna_acc = new Accountlistcf();
			$directors_curetna_acc->init(36,$lastyear,$stdate);
			//$directors_curetna_acc->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$directors_curetna_acc_total = float_ops($directors_curetna_acc_total, $directors_curetna_acc->total, '+');
			
			//Other payable CL (Group 48)
			$other_payable_total = '';
			$other_payable = new Accountlistcf();
			$other_payable->init(48,$lastyear,$stdate);
			//$other_payable->account_st_short(0,$type = 'L3',$color='');
			$other_payable_total = float_ops($other_payable_total, $other_payable->total, '+');
			
			//Short Term Borrowings (Group 37)
			$shortterm_borrowings_total = '';
			$shortterm_borrowings = new Accountlistcf();
			$shortterm_borrowings->init(37,$lastyear,$stdate);
			//$shortterm_borrowings->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$shortterm_borrowings_total = float_ops($other_payable_total, $shortterm_borrowings->total, '+');
			
			//Statutory Payables (Group 52)
			$statutory_payables_total = '';
			$statutory_payables = new Accountlistcf();
			$statutory_payables->init(52,$lastyear,$stdate);
			//$statutory_payables->account_st_short(0,$type = 'L3',$color='');
			$statutory_payables_total = float_ops($statutory_payables_total, $shortterm_borrowings->total, '+');
			
			//Customer Advance Received (Group 38)
			$customer_advance_total = '';
			$customer_advance = new Accountlistcf();
			$customer_advance->init(38,$lastyear,$stdate);
			//$customer_advance->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$customer_advance_total = float_ops($customer_advance_total, $customer_advance->total, '+');
			
			//Other Payable CL (Group 48)
			$other_payable_cl_total = '';
			$other_payable_cl = new Accountlistcf();
			$other_payable_cl->init(48,$lastyear,$stdate);
			//$other_payable_cl->account_st_short(0,$type = 'L3',$color='');
			$other_payable_cl_total = float_ops($other_payable_cl_total, $other_payable_cl->total, '+');
			
			
			$current_liabilities_total = $shortterm_borrowings_total+$other_payable_total+$shortterm_borrowings_total+$statutory_payables_total+$customer_advance_total+$other_payable_cl_total;
			
			//Net cash from operating activities
            $net_cashfrom_oa = $current_aasets_total+$current_liabilities_total;
		
            //Free Hold Assets (Group 29)
			$freehold_assets_total = '';
			$freehold_assets = new Accountlistcf();
			$freehold_assets->init(29,$lastyear,$stdate);
			//$freehold_assets->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$freehold_assets_total = float_ops($freehold_assets_total, $freehold_assets->total, '+');
			
			//Accumulated Depreciation FH (Group 43)
			$acc_depreciation_fa_total = '';
			$acc_depreciation_fa = new Accountlistcf();
			$acc_depreciation_fa->init(43,$lastyear,$stdate);
			//$acc_depreciation_fa->account_st_short(0,$type = 'L2',$color='');
			$acc_depreciation_fa_total = float_ops($acc_depreciation_fa_total, $acc_depreciation_fa->total, '+');
			
			//Lease Hold Assets (Group 30)
			$leasehold_assets_total = '';
			$leasehold_assets = new Accountlistcf();
			$leasehold_assets->init(69,$lastyear,$stdate);
			//$leasehold_assets->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$leasehold_assets_total = float_ops($leasehold_assets_total, $leasehold_assets->total, '+');
			
			//Accumulated Depreciation LH (Group 44)
			$acc_depreciation_la_total = '';
			$acc_depreciation_la = new Accountlistcf();
			$acc_depreciation_la->init(70,$lastyear,$stdate);
			//$acc_depreciation_la->account_st_short(0,$type = 'L2',$color='');
			$acc_depreciation_la_total = float_ops($acc_depreciation_la_total, $acc_depreciation_la->total, '+');
			
			//Intangible Assets (Group 7)
			$intangible_assets_total = '';
			$intangible_assets = new Accountlistcf();
			$intangible_assets->init(73,$lastyear,$stdate);
			//$intangible_assets->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$intangible_assets_total = float_ops($intangible_assets_total, $intangible_assets->total, '+');
			
			//Amortisation Cost (Group 45)
			$amortisation_cost_total = '';
			$amortisation_cost = new Accountlistcf();
			$amortisation_cost->init(75,$lastyear,$stdate);
			//$amortisation_cost->account_st_short(0,$type = 'L3',$color='');
			$amortisation_cost_total = float_ops($amortisation_cost_total, $amortisation_cost->total, '+');
			
			$financial_assets_total = '';
			$financial_assets = new Accountlistcf();
			$financial_assets->init(76,$lastyear,$stdate);
			//$amortisation_cost->account_st_short(0,$type = 'L3',$color='');
			$financial_assets_total = float_ops($financial_assets_total, $financial_assets->total, '+');
			
			$loans_bank_total = '';
			$loans_bank = new Accountlistcf();
			$loans_bank->init(77,$lastyear,$stdate);
			//$amortisation_cost->account_st_short(0,$type = 'L3',$color='');
			$loans_bank_total = float_ops($loans_bank_total, $loans_bank->total, '+');
			
			
			$non_current_assets_total = $freehold_assets_total+$acc_depreciation_fa_total+$leasehold_assets_total+$acc_depreciation_la_total+$intangible_assets_total+$amortisation_cost_total+$loans_bank_total+$financial_assets_total;
			
			//Net cash from operating activities
            $net_cashfrom_ia = $non_current_assets_total;
			
            //Loans from Banks (Group 33)
			$bank_loans_total = '';
			$bank_loans = new Accountlistcf();
			$bank_loans->init(33,$lastyear,$stdate);
			//$bank_loans->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$bank_loans_total = float_ops($bank_loans_total, $bank_loans->total, '+');
			
			//Temporary Loans (Group 61)
			$temp_loans_total = '';
			$temp_loans = new Accountlistcf();
			$temp_loans->init(61,$lastyear,$stdate);
			//$temp_loans->account_st_short(0,$type = 'L3',$color='');
			$temp_loans_total = float_ops($temp_loans_total, $temp_loans->total, '+');
			
			//Non Current Liabilities (Group 13)
			$other_noncurrent_total = '';
			$other_noncurrent = new Accountlistcf();
			$other_noncurrent->init(13,$lastyear,$stdate);
			//$other_noncurrent->account_st_short(0,$type = 'L4',$colors[array_rand($colors, 1)]);
			$other_noncurrent_total = float_ops($other_noncurrent_total, $other_noncurrent->total, '+');
			
			//Equity (Group 17)
			$equity_total = '';
			$equity = new Accountlistcf();
			$equity->init(17,$lastyear,$stdate);
			//$equity->account_st_short(0,$type = 'L4',$color='');
			$equity_total = float_ops($equity_total, $equity->total, '+');
			
			
			$fa_total = $bank_loans_total+$temp_loans_total+$other_noncurrent_total+$equity_total;
			
			//Net cash from finacial activities
            $net_cashfrom_fa = $fa_total;
			
			$cash_increase_lastyear = $net_cashfrom_oa+$net_cashfrom_ia+$net_cashfrom_fa;
			/*End last year calculations*/	
			
			$colors = array("#E5E5E5", "#FAD1D1", "#F5CCA3", "#F5E7A3","#C7F075","#D1FAD8","#A3F5F5","#FAD1F3","#D6C2C5");
			//Debtor (Group 10)
			$debtors_total = '';
			$debtors = new Accountlistcf();
			$debtors->init(71,FYSTV,FYENDV);
			$debtors->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$debtors_total = float_ops($debtors_total, $debtors->total, '-');
				$debtors2 = new Accountlistcf();
			$debtors2->init(54,FYSTV,FYENDV);
			$debtors2->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$debtors_total = float_ops($debtors_total, $debtors2->total, '-');
			$debtors3 = new Accountlistcf();
			$debtors3->init(63,FYSTV,FYENDV);
			$debtors3->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$debtors_total = float_ops($debtors_total, $debtors3->total, '-');
			
			
			//Provision for RE Project (Group 39)
			$provisionforre_total = '';
			$provisionforre = new Accountlistcf();
			$provisionforre->init(66,FYSTV,FYENDV);
			$provisionforre->account_st_short(0,$type = 'L3',$color='');
			$provisionforre_total = float_ops($provisionforre_total, $provisionforre->total, '-');
		
			$provisionforre2 = new Accountlistcf();
			$provisionforre2->init(39,FYSTV,FYENDV);
			$provisionforre2->account_st_short(0,$type = 'L3',$color='');
			$provisionforre_total = float_ops($provisionforre_total, $provisionforre2->total, '-');
			
			//stock (Group 53)
			$stock_total = '';
			$stock = new Accountlistcf();
			$stock->init(53,FYSTV,FYENDV);
			$stock->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$stock_total = float_ops($stock_total, $stock->total, '-');
			
			//stock (Group 53)
			$unrealised_total = '';
			$unrealised = new Accountlistcf();
			$unrealised->init(62,FYSTV,FYENDV);
			$unrealised->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$unrealised_total = float_ops($unrealised_total, $unrealised->total, '-');
			
			//Deposits & Pre-payments CL (Group 51)
			$deposit_total = '';
			$deposit = new Accountlistcf();
			$deposit->init(51,FYSTV,FYENDV);
			$deposit->account_st_short(0,$type = 'L1',$color='');
			$deposit_total = float_ops($deposit_total, $deposit->total, '-');
			
			//Advance on Lands (Group 31)
			$advanceonlands_total = '';
			$advanceonlands = new Accountlistcf();
			$advanceonlands->init(31,FYSTV,FYENDV);
			$advanceonlands->account_st_short(0,$type = 'L1',$colors[array_rand($colors, 1)]);
			$advanceonlands_total = float_ops($advanceonlands_total, $advanceonlands->total, '-');
			
			//Other Advance Payment (Group 58)
			$otheradvance_total = '';
			$otheradvance = new Accountlistcf();
			$otheradvance->init(58,FYSTV,FYENDV);
			$otheradvance->account_st_short(0,$type = 'L1',$color='');
			$otheradvance_total = float_ops($otheradvance_total, $otheradvance->total, '-');
			
			$current_aasets_total = $debtors_total+$provisionforre_total+$stock_total+$deposit_total+$advanceonlands_total+$otheradvance_total+$unrealised_total;
			
			//Directors' current ACCOUNT (Group 36)
			$directors_curetna_acc_total = '';
			$directors_curetna_acc = new Accountlistcf();
			$directors_curetna_acc->init(36,FYSTV,FYENDV);
			$directors_curetna_acc->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$directors_curetna_acc_total = float_ops($directors_curetna_acc_total, $directors_curetna_acc->total, '-');
			
			//Other payable CL (Group 48)
			$other_payable_total = '';
			$other_payable = new Accountlistcf();
			$other_payable->init(48,FYSTV,FYENDV);
			$other_payable->account_st_short(0,$type = 'L3',$color='');
			$other_payable_total = float_ops($other_payable_total, $other_payable->total, '-');
			
			//Short Term Borrowings (Group 37)
			$shortterm_borrowings_total = '';
			$shortterm_borrowings = new Accountlistcf();
			$shortterm_borrowings->init(37,FYSTV,FYENDV);
			$shortterm_borrowings->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$shortterm_borrowings_total = float_ops($other_payable_total, $shortterm_borrowings->total, '-');
			
			//Statutory Payables (Group 52)
			$statutory_payables_total = '';
			$statutory_payables = new Accountlistcf();
			$statutory_payables->init(52,FYSTV,FYENDV);
			$statutory_payables->account_st_short(0,$type = 'L3',$color='');
			$statutory_payables_total = float_ops($statutory_payables_total, $shortterm_borrowings->total, '-');
			
			//Customer Advance Received (Group 38)
			$customer_advance_total = '';
			$customer_advance = new Accountlistcf();
			$customer_advance->init(38,FYSTV,FYENDV);
			$customer_advance->account_st_short(0,$type = 'L3',$colors[array_rand($colors, 1)]);
			$customer_advance_total = float_ops($customer_advance_total, $customer_advance->total, '-');
			
			//Other Payable CL (Group 48)
			$other_payable_cl_total = '';
			$other_payable_cl = new Accountlistcf();
			$other_payable_cl->init(48,FYSTV,FYENDV);
			$other_payable_cl->account_st_short(0,$type = 'L3',$color='');
			$other_payable_cl_total = float_ops($other_payable_cl_total, $other_payable_cl->total, '-');
			
			
			$current_liabilities_total = $shortterm_borrowings_total+$other_payable_total+$shortterm_borrowings_total+$statutory_payables_total+$customer_advance_total+$other_payable_cl_total;
			
			//Net cash from operating activities
            $net_cashfrom_oa = $current_aasets_total+$current_liabilities_total;
			?>
            <tr class="linetop">
            	<td style="background-color:#99F;">Net Cash Provided by Operating Activities</td><td style="background-color:#99F;" align="right"><?=convert_account($net_cashfrom_oa).$spacer?></td>
            </tr>
             <tr>
            	<td>INVESTING ACTIVITIES</td>
                <td></td>
            </tr>
            <?
            //Free Hold Assets (Group 29)
			$freehold_assets_total = '';
			$freehold_assets = new Accountlistcf();
			$freehold_assets->init(29,FYSTV,FYENDV);
			$freehold_assets->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$freehold_assets_total = float_ops($freehold_assets_total, $freehold_assets->total, '-');
			
			//Accumulated Depreciation FH (Group 43)
			$acc_depreciation_fa_total = '';
			$acc_depreciation_fa = new Accountlistcf();
			$acc_depreciation_fa->init(43,FYSTV,FYENDV);
			$acc_depreciation_fa->account_st_short(0,$type = 'L2',$color='');
			$acc_depreciation_fa_total = float_ops($acc_depreciation_fa_total, $acc_depreciation_fa->total, '-');
			
			//Lease Hold Assets (Group 69)
			$leasehold_assets_total = '';
			$leasehold_assets = new Accountlistcf();
			$leasehold_assets->init(69,FYSTV,FYENDV);
			$leasehold_assets->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$leasehold_assets_total = float_ops($leasehold_assets_total, $leasehold_assets->total, '-');
			
			//Accumulated Depreciation LH (Group 70)
			$acc_depreciation_la_total = '';
			$acc_depreciation_la = new Accountlistcf();
			$acc_depreciation_la->init(70,FYSTV,FYENDV);
			$acc_depreciation_la->account_st_short(0,$type = 'L2',$color='');
			$acc_depreciation_la_total = float_ops($acc_depreciation_la_total, $acc_depreciation_la->total, '-');
			
			//Intangible Assets (Group 73)
			$intangible_assets_total = '';
			$intangible_assets = new Accountlistcf();
			$intangible_assets->init(73,FYSTV,FYENDV);
			$intangible_assets->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$intangible_assets_total = float_ops($intangible_assets_total, $intangible_assets->total, '-');
			
			// Deferred Tax Asset (Group 74)
			$difftax_assets_total = '';
			$difftax_assets = new Accountlistcf();
			$difftax_assets->init(74,FYSTV,FYENDV);
			$difftax_assets->account_st_short(0,$type = 'L2',$color='');
			$difftax_assets_total = float_ops($difftax_assets_total, $difftax_assets->total, '-');
			
			//Amortisation Cost (Group 75)
			$amortisation_cost_total = '';
			$amortisation_cost = new Accountlistcf();
			$amortisation_cost->init(75,FYSTV,FYENDV);
			$amortisation_cost->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$amortisation_cost_total = float_ops($amortisation_cost_total, $amortisation_cost->total, '-');
			
			//Financial Asset (Group 76)
			$financial_assets_total = '';
			$financial_assets = new Accountlistcf();
			$financial_assets->init(76,FYSTV,FYENDV);
			$financial_assets->account_st_short(0,$type = 'L2',$color='');
			$financial_assets_total = float_ops($financial_assets_total, $financial_assets->total, '-');
			
			
			$non_current_assets_total = $freehold_assets_total+$acc_depreciation_fa_total+$leasehold_assets_total+$acc_depreciation_la_total+$intangible_assets_total+$amortisation_cost_total+$difftax_assets_total+$financial_assets_total;
			
			//Net cash from operating activities
            $net_cashfrom_ia = $non_current_assets_total;
			?>
            <tr class="linetop">
            	<td style="background-color:#99F;">Net Cash Provided by Investing Activities</td><td style="background-color:#99F;" align="right"><?=convert_account($net_cashfrom_ia).$spacer?></td>
            </tr>
             <tr>
            	<td>FINANCING ACTIVITIES</td>
                <td></td>
            </tr>
            <?
            //Loans from Banks (Group 77)
			$bank_loans_total = '';
			$bank_loans = new Accountlistcf();
			$bank_loans->init(77,FYSTV,FYENDV);
			$bank_loans->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$bank_loans_total = float_ops($bank_loans_total, $bank_loans->total, '-');
			
			//Loans from Finance Companies (Group 60)
			$temp_loans_total = '';
			$temp_loans = new Accountlistcf();
			$temp_loans->init(60,FYSTV,FYENDV);
			$temp_loans->account_st_short(0,$type = 'L2',$color='');
			$temp_loans_total = float_ops($temp_loans_total, $temp_loans->total, '-');
			
			//Finance Lease (Group 59)
			$finance_lease_total = '';
			$finance_lease = new Accountlistcf();
			$finance_lease->init(59,FYSTV,FYENDV);
			$finance_lease->account_st_short(0,$type = 'L2',$colors[array_rand($colors, 1)]);
			$finance_lease_total = float_ops($finance_lease_total, $finance_lease->total, '-');
			
			//Equity (Group 17)
			$equity_total = '';
			$equity = new Accountlistcf();
			$equity->init(17,FYSTV,FYENDV);
			$equity->account_st_short(0,$type = 'L3',$color='');
			$equity_total = float_ops($equity_total, $equity->total, '-');
			
			
			$fa_total = $bank_loans_total+$temp_loans_total+$finance_lease_total+$equity_total;
			
			//Net cash from operating activities
            $net_cashfrom_fa = $fa_total;
			
			$cash_increase = $net_cashfrom_oa-$net_cashfrom_ia+$net_cashfrom_fa+$net_income_total;
			$cash_at_beginning = $cash_increase_lastyear;
			$cash_at_end = $cash_increase+$cash_at_beginning;
			?>
            <tr class="linetop">
            	<td style="background-color:#99F;"><?=$spacer;?>Net Cash Provided by Financing Activities</td><td style="background-color:#99F; border-top:1px solid #000;" align="right"><?=convert_account($net_cashfrom_fa).$spacer?></td>
            </tr>
            <tr class="linetop">
            	<td style="background-color:#999;"><?=$spacer;?>Net Cash Increase/Decrease for Period</td><td style="background-color:#999; border-top:1px solid #000;" align="right"><?=convert_account($cash_increase).$spacer?></td>
            </tr>
            <tr class="linetop">
            	<td style="background-color:#999;"><?=$spacer;?>Cash at Beginning of Period</td><td style="background-color:#999; border-bottom:1px solid #000;" align="right"><?=convert_account($cash_at_beginning).$spacer?></td>
            </tr>
            <tr class="linetop">
            	<td style="background-color:#999;">Cash at End of Period</td><td style="background-color:#999; border-bottom:1px double #000;" align="right"><?=convert_account($cash_at_end).$spacer?></td>
            </tr>
       </tbody>
    </table>
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

