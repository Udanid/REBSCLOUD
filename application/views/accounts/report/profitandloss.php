<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");

$stdate=$this->session->userdata('fy_start');
$enddate=$this->session->userdata('fy_end');

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
 	 $("#month").chosen({
     allow_single_deselect : true
    });
  });
  
function getCSV(){
	var fromdate = $('#fromdate').val();
	var todate = $('#todate').val();
	if(fromdate == '' || todate == ''){
		alert ('Please select "From Date" and "To Date"!');
	}else{
		window.open('<?php echo base_url().'accounts/report/generatecsv/';?>' + fromdate + '/' + todate);
	}
}
</script>
<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Profit And Loss Report</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <div class="form-title">
		<!--<h4><a href="#" onClick="getCSV();"> <i class="fa fa-file-excel-o nav_icon"></i></a></h4>-->

	</div>
       <div class="form-body "><?php
	   
	   	echo form_open('accounts/report/profitandloss_period/' );
		?>
       <div class="form-group">
     	<?			
	//	echo form_submit('submit', 'Show');
	?><div class="col-sm-3 "> 
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
                                            </select></div>   <div class="col-sm-3 ">
                      <input type="text" name="fromdate" id="fromdate" placeholder="From Date" autocomplete="off"  class="form-control" >
                    </div>
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
	$this->load->library('Accountlistpnl');
		$spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table2excel">
    	<thead>
        	<tr>
            	<th></th>
            	<th colspan="2" align="justify">
        			
						<h4 align="center"><?=strtoupper(companyname)?><br>
                        	Profit & Loss Statement<br>
                            <?
                            $sdate = strtotime(FYSTV);
							$newsdate = date('dS F Y',$sdate);
							
							$edate = strtotime(FYENDV);
							$newedate = date('dS F Y',$edate);
							?>
                            For the Period <?=$newsdate?> to <?=$newedate?></h4>
        		</th>
                <th></th>
            </tr>
       </thead>
       <tbody>
       		<tr class="info bold">
            	<td>Ledger</td><td colspan="3">Particular</td>
            </tr>
            <!--Incomes-->
            <tr class="warning bold">
            	<td></td><td colspan="3">Incomes</td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Net Income</td>
            </tr>
            <? 
			//Net Income (Group 19)
			$net_income_total = '';
			$net_income = new Accountlistpnl();
			$net_income->init(19,FYSTV,FYENDV);
			$net_income->account_st_short(0,$type = 'L2');
			$net_income_total = float_ops($net_income_total, $net_income->total, '-');
			?>
            <tr class="linetop">
            	<td></td><td></td><td  style="border-top:2px solid #000;"></td><td align="right"><?=convert_account($net_income_total)?></td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Cost of Goods Sold</td>
            </tr>
            <? 
			//Cost of Goods Sold (Group 21)
			$cost_of_goods_total = '';
			$cost_of_goods = new Accountlistpnl();
			$cost_of_goods->init(21,FYSTV,FYENDV);
			$cost_of_goods->account_st_short(0,$type = 'L2');
			$cost_of_goods_total = float_ops($cost_of_goods_total, $cost_of_goods->total, '+');
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right" style="border-bottom:2px solid #000;">(<?=convert_account($cost_of_goods_total).')';?></td>
            </tr>
            <?
            //Net Income - Cost of Goods Sold
			$gross_income = $net_income_total - $cost_of_goods_total;
			?>
            <tr class="linetop">
            	<td></td><td></td><td></td><td align="right"><?=convert_account($gross_income)?></td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Other Income</td>
            </tr>
            <?
            //Other Income (Group 20)
			$other_income_total = '';
			$other_income = new Accountlistpnl();
			$other_income->init(20,FYSTV,FYENDV);
			$other_income->account_st_short(0,$type = 'L2');
			$other_income_total = float_ops($other_income_total, $other_income->total, '-');
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right" style="border-bottom:2px solid #000;"><?=convert_account($other_income_total)?></td>
            </tr>
            <?
            //Other Income + Gross Income
			$gross_profit = $gross_income + $other_income_total;
			?>
            <tr class="linetop bold warning">
            	<td></td><td>Gross Profit</td><td></td><td class="bold" align="right" style="border-bottom:2px solid #000;"><?=convert_account($gross_profit)?></td>
            </tr>
            <!--Expenses-->
            <tr class="warning bold">
            	<td></td><td colspan="3">Expenses</td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Administrative Expenses</td>
            </tr>
            <? 
			//Administrative Expenses (Group 23)
			$admin_expenses_total = '';
			$admin_expenses = new Accountlistpnl();
			$admin_expenses->init(23,FYSTV,FYENDV);
			$admin_expenses->account_st_short(0,$type = 'L2');
			$admin_expenses_total = float_ops($admin_expenses_total, $admin_expenses->total, '+');
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right"><?=convert_account($admin_expenses_total)?></td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Staff Expenses</td>
            </tr>
            <? 
			//Staff Expenses (Group 41)
			$staff_expenses_total = '';
			$staff_expenses = new Accountlistpnl();
			$staff_expenses->init(41,FYSTV,FYENDV);
			$staff_expenses->account_st_short(0,$type = 'L2');
			$staff_expenses_total = float_ops($staff_expenses_total, $staff_expenses->total, '+');
			
			//Admin & staff expenses
			$adminstaff_expenses = $admin_expenses_total+$staff_expenses_total;
			?>
            <tr class="linetop">
            	<td></td><td></td><td align="right" style="border-bottom:2px solid #000;"></td><td align="right"><?=convert_account($staff_expenses_total)?></td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Selling & Distribution Expenses</td>
            </tr>
            <?
            //Selling & Distribution Expenses (Group 24)
			$selling_expenses_total = '';
			$selling_expenses = new Accountlistpnl();
			$selling_expenses->init(24,FYSTV,FYENDV);
			$selling_expenses->account_st_short(0,$type = 'L2');
			$selling_expenses_total = float_ops($selling_expenses_total, $selling_expenses->total, '+');
			
			//other expenses
			$other_expenses = $adminstaff_expenses+$selling_expenses_total;
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right" style="border-bottom:2px solid #000;"><?=convert_account($selling_expenses_total)?></td>
            </tr>
            <tr class="linetop">
            	<td></td><td></td><td></td><td align="right"><?=convert_account($other_expenses)?></td>
            </tr>
            <tr class="linetop">
            	<td>&nbsp;</td><td></td><td></td><td align="right"></td>
            </tr>
            <!--Net Profit-->
            <?
            $netprofit_beforedep = $gross_profit - $other_expenses;
			?>
            <tr class="linetop success bold">
            	<td></td><td>Net Profit Before Depreciation & Amortization</td><td></td><td align="right"><?=convert_account($netprofit_beforedep)?></td>
            </tr>
            <!--Depreciation-->
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Depreciations</td>
            </tr>
            <?
            //Depreciations (Group 40)
			$depreciations_total = '';
			$depreciations = new Accountlistpnl();
			$depreciations->init(40,FYSTV,FYENDV);
			$depreciations->account_st_short(0,$type = 'L2');
			$depreciations_total = float_ops($depreciations_total, $depreciations->total, '+');
			
			//net profit from operations
			$net_profit_operations = $netprofit_beforedep-$depreciations_total;
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right"><?=convert_account($depreciations_total)?></td>
            </tr>
            <tr class="linetop success bold">
            	<td></td><td>Net Profit from Operations</td><td></td><td align="right"><?=convert_account($net_profit_operations)?></td>
            </tr>
            <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Financial Expenses</td>
            </tr>
            <?
            //Financial Expenses (Group 26)
			$financial_expenses_total = '';
			$financial_expenses = new Accountlistpnl();
			$financial_expenses->init(26,FYSTV,FYENDV);
			$financial_expenses->account_st_short(0,$type = 'L2');
			$financial_expenses_total = float_ops($financial_expenses_total, $financial_expenses->total, '+');
			
			//net profit before tax
			$netprifit_before = $net_profit_operations-$financial_expenses_total;
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right"><?=convert_account($financial_expenses_total)?></td>
            </tr>
            <tr class="linetop success bold">
            	<td></td><td>Net Profit Before Taxation</td><td></td><td align="right"><?=convert_account($netprifit_before)?></td>
            </tr>
          <!--/*/*  <tr class="warning bold">
            	<td></td><td colspan="3"><?=$spacer?>Tax</td>
            </tr>
            <?
            //tax Expenses (Group 42)
			$tax_expenses_total = '';
			$tax_expenses = new Accountlistpnl();
			$tax_expenses->init(42,FYSTV,FYENDV);
			$tax_expenses->account_st_short(0,$type = 'L2');
			$tax_expenses_total = float_ops($tax_expenses_total, $tax_expenses->total, '+');
			
			//net profit before tax
			$netprifit_after = $netprifit_before-$tax_expenses_total;
			?>
            <tr class="linetop">
            	<td></td><td></td><td style="border-bottom:2px solid #000;"></td><td align="right"><?=convert_account($tax_expenses_total).$spacer?></td>
            </tr>
            <tr class="linetop success bold">
            	<td></td><td>Net Profit After Taxation</td><td></td><td align="right"><?=convert_account($netprifit_after).$spacer?></td>
            </tr>*/*/-->
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
