<!DOCTYPE HTML>
<html>
<head>

<?
$this->load->model('Ledger_model');
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<?
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
		tableToExcel('bstable', 'Balance Sheet', 'Balance_Sheet_<?=date('Y_m_d');?>.xls');
		// util.tablesToExcel(['table-data'], ['ReportCoin'], 'ReportCoin_${project}_${deviceType}.xls');
	});
  });
</script>

<div id="page-wrapper">
 <div class="main-page">
  <h3 class="title1">Balance Sheet</h3>
       <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
        <div class="form-title">
		<h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
</h4>
	</div>
       <div class="form-body "><?php
	   
	   	echo form_open('accounts/report/balancesheet_period/' );
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
                                              <input type="text" name="todate" id="todate" placeholder="To Date"  autocomplete="off" class="form-control" >
                                            </div>
											 <div class="col-sm-3 ">
												<button type="submit" class="btn btn-primary ">Show</button> </div>
											</div>
											<div class="clearfix"> </div><div class="clearfix"> </div><br>	
								
    <?
		echo "</p>";
		echo form_close();
		$this->load->library('accountlistbs');
		$spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	?>
	<table width="100%" border="0" cellspacing="0" id="bstable" cellpadding="0" class="table table-bordered table2excel">
    	<thead>
        	<tr>
            	
            	<th colspan="3" align="justify">
        					<h4 align="center"><?=strtoupper(companyname)?><br>
                            <?
                            $sdate = strtotime(FYSTV);
							$newsdate = date('F d, Y',$sdate);
							
							$edate = strtotime(FYENDV);
							$newedate = date('F d, Y',$edate);
							?>
                            <?=date('Y',strtotime(FYSTV)).'-'.date('Y',strtotime(FYENDV))?> Balance Sheet<br>
                            As of <?=$newedate?></h4>
        		</th>
                <th></th>
            </tr>
       </thead>
       <tbody>
            <tr>
            	<td>ASSETS</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td>Non Current Assets</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer;?>Fixed Assets</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?>Free Hold Assets</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Free Hold Assets (Group 29)
			$freehold_assets_total = '';
			$freehold_assets = new Accountlistbs();
			$freehold_assets->init(29,FYSTV,FYENDV);
			$freehold_assets->account_st_short(0,$type = 'L1');
			$freehold_assets_total = float_ops($freehold_assets_total, $freehold_assets->total, '+');
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($freehold_assets_total).$spacer?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer.$spacer.$spacer;?>Accumulated Depreciation</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Accumulated Depreciation (Group 40)
			$acc_depreciation_total = '';
			$acc_depreciation = new Accountlistbs();
			$acc_depreciation->init(43,FYSTV,FYENDV);
			$acc_depreciation->account_st_short(0,$type = 'L1');
			$acc_depreciation_total = float_ops($acc_depreciation_total, $acc_depreciation->total, '-');
			
			//Net Free Hold Assets
			$netfreehold = $freehold_assets_total+$acc_depreciation_total
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right" style="border-bottom:1px solid #000;"><strong>(<? echo convert_account($acc_depreciation_total).')'.$spacer;?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer.$spacer;?>Net Free Hold Assets</td>
                <td></td>
                <td></td>
                <td align="right"><strong><?=convert_account($netfreehold).$spacer?></strong></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?>Lease Hold Assets</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Lease Hold Assets (Group 29)
			$leasehold_assets_total = '';
			$leasehold_assets = new Accountlistbs();
			$leasehold_assets->init(30,FYSTV,FYENDV);
			$leasehold_assets->account_st_short(0,$type = 'L1');
			$leasehold_assets_total = float_ops($leasehold_assets_total, $leasehold_assets->total, '+');
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($leasehold_assets_total).$spacer?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer.$spacer.$spacer;?>Accumulated Depreciation</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Accumulated Depreciation (Group 41)
			$acc_depreciationlh_total = '';
			$acc_depreciationlh = new Accountlistbs();
			$acc_depreciationlh->init(44,FYSTV,FYENDV);
			$acc_depreciationlh->account_st_short(0,$type = 'L1');
			$acc_depreciationlh_total = float_ops($acc_depreciationlh_total, $acc_depreciationlh->total, '-');
			
			//Net Lease Hold Assets
			$netleasehold = $leasehold_assets_total+$acc_depreciationlh_total;
			
			//total fixed assets
			$total_fixed_assets = $netfreehold+$netleasehold;
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right" style="border-bottom:1px solid #000;"><strong>(<? echo convert_account($acc_depreciationlh_total).')'.$spacer;?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer.$spacer;?>Net Lease Hold Assets</td>
                <td></td>
                <td></td>
                <td align="right"><strong><?=convert_account($netleasehold).$spacer?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#B9D6EF;"><?=$spacer?>Total Fixed Assets</td><td style="background-color:#B9D6EF;"></td><td style="background-color:#B9D6EF;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#B9D6EF; border-top:1px solid #000;"><strong><?=convert_account($total_fixed_assets).$spacer?></strong></td>
            </tr>
            <tr>
            	<td>Intangible Asset</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Intangible Assets (Group 7)
			$intangible_assets_total = '';
			$intangible_assets = new Accountlistbs();
			$intangible_assets->init(7,FYSTV,FYENDV);
			$intangible_assets->account_st_short(0,$type = 'L1');
			$intangible_assets_total = float_ops($intangible_assets_total, $intangible_assets->total, '+');
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><? echo convert_account($intangible_assets_total).$spacer;?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer.$spacer.$spacer;?>Amortisation Cost</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Amortisation Cost (Group 42)
			$amortisation_cost_total = '';
			$amortisation_cost = new Accountlistbs();
			$amortisation_cost->init(45,FYSTV,FYENDV);
			$amortisation_cost->account_st_short(0,$type = 'L1');
			$amortisation_cost_total = float_ops($amortisation_cost_total, $amortisation_cost->total, '-');
			
			$netintangible = $intangible_assets_total-$amortisation_cost_total;
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right" style="border-bottom:1px solid #000;"><strong>(<? echo convert_account($amortisation_cost_total).')'.$spacer;?></strong></td><td></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#B9D6EF;"><?=$spacer.$spacer;?>Net Intangible Assets</td><td style="background-color:#B9D6EF;"></td><td style="background-color:#B9D6EF;"></td><td class="bold" align="right" style="background-color:#B9D6EF;"><strong><?=convert_account($netintangible).$spacer?></strong></td>
            </tr>
            <tr>
            	<td>Financial Asset</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Fixed Deposit (Group 43)
			$fixed_deposit_total = '';
			$fixed_deposit = new Accountlistbs();
			$fixed_deposit->init(46,FYSTV,FYENDV);
			$fixed_deposit->account_st_short(0,$type = 'L2');
			$fixed_deposit_total = float_ops($fixed_deposit_total, $fixed_deposit->total, '-');
			
			$total_noncurrent = $total_fixed_assets+$netintangible+$fixed_deposit_total;
			?>
            <tr class="linetop bold ">
            	<td style="background-color:#B9D6EF;"><?=$spacer.$spacer;?>Total Financial Asset</td><td style="background-color:#B9D6EF;"></td><td style="background-color:#B9D6EF; border-top:1px solid #000;"></td><td class="bold" align="right" style="background-color:#B9D6EF; border-top:1px solid #000;"><strong><?=convert_account($fixed_deposit_total).$spacer?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#999;"><?=$spacer?>Total Non-Current Assets</td><td style="background-color:#999;"></td><td style="background-color:#999;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#999; border-top:1px solid #000;"><strong><?=convert_account($total_noncurrent).$spacer?></strong></td>
            </tr>
            <tr>
            	<td>Current Assets</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
           <?
           		$CI =& get_instance();
    			$data = $CI->getAccgroups(9) ;
				$current_asset_total = 0;
				
				foreach ($data as $raw){
					$current_asset='';
					$current_asset_each = '';
					?>
					<tr>
                        <td><?=$spacer.$raw->name?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?
					$current_asset = new Accountlistbs();
					$current_asset->init($raw->id,FYSTV,FYENDV);
					$current_asset->account_st_short(0,$type = 'L2');
					$current_asset_each = float_ops($current_asset_each, $current_asset->total, '+');
					?>
                    
                    <tr class="linetop">
                        <td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($current_asset_each).$spacer?></strong></td>
                    </tr>
                    <?
					//Total current assets from parent id 9
					$current_asset_total = $current_asset_total+$current_asset_each;
					
				}
				?>
				<tr>
                    <td><?=$spacer?>Cash & Cash Equivalents</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
				<?
				$CI =& get_instance();
    			$data2 = $CI->getAccgroups(11) ;
				$cashequivalent = 0;
				
				foreach ($data2 as $raw){
					$current_asset='';
					$current_asset_each = '';
					?>
					<tr>
                        <td><?=$spacer.$spacer.$spacer.$raw->name?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?
					$current_asset = new Accountlistbs();
					$current_asset->init($raw->id,FYSTV,FYENDV);
					$current_asset->account_st_short(0,$type = 'L2');
					$current_asset_each = float_ops($current_asset_each, $current_asset->total, '+');
					?>
                    
                    <tr class="linetop">
                        <td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($current_asset_each).$spacer?></strong></td>
                    </tr>
                    <?
					//Total current assets from parent id 9
					$cashequivalent = $cashequivalent+$current_asset_each;
					
				}
				$current_asset_total = $current_asset_total+$cashequivalent;
		   ?>
           <tr class="linetop bold ">
            	<td style="background-color:#B9D6EF;"><?=$spacer.$spacer;?>Total Cash & Cash Equivalents</td><td style="background-color:#B9D6EF;"></td><td style="background-color:#B9D6EF; border-top:1px solid #000;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#B9D6EF; border-top:1px solid #000;"><strong><?=convert_account($cashequivalent).$spacer?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#999;"><?=$spacer?>Total Current Assets</td><td style="background-color:#999;"></td><td style="background-color:#999;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#999; border-top:1px solid #000;"><strong><?=convert_account($current_asset_total).$spacer?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#96F;">TOTAL ASSETS</td><td style="background-color:#96F;"></td><td style="background-color:#96F;"></td><td class="bold" align="right" style="border-bottom:1px double #000; background-color:#96F; border-top:1px solid #000;"><strong><?=convert_account($current_asset_total+$total_noncurrent).$spacer?></strong></td>
            </tr>
            <tr>
            	<td>EQUITY & LIABILITIES</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer?>Equity</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Quity (Group 17)
			$equity_total = '';
			$equity = new Accountlistbs();
			$equity->init(17,FYSTV,FYENDV);
			$equity->account_st_short(0,$type = 'L1');
			$equity_total = float_ops($equity_total, $equity->total, '+');
			?>
            <tr class="linetop bold ">
            	<td style="background-color:#999;"><?=$spacer?>Total Equitys</td><td style="background-color:#999;"></td><td style="background-color:#999;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#999; border-top:1px solid #000;"><strong><?=convert_account($equity_total).$spacer?></strong></td>
            </tr>
            <tr>
            	<td><?=$spacer?>Liabilities</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer?>Non Current Liabilities</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?
			$CI =& get_instance();
			$data = $CI->getAccgroups(13) ;
			$non_current_liabilities_total = 0;
			
			foreach ($data as $raw){
				$noncurrent_liabilities ='';
				$noncurrent_liabilities_each = '';
				?>
				<tr>
					<td><?=$spacer.$spacer.$spacer.$raw->name?></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?
				$noncurrent_liabilities = new Accountlistbs();
				$noncurrent_liabilities->init($raw->id,FYSTV,FYENDV);
				$noncurrent_liabilities->account_st_short(0,$type = 'L2');
				$noncurrent_liabilities_each = float_ops($noncurrent_liabilities_each, $noncurrent_liabilities->total, '+');
				?>
				
				<tr class="linetop">
					<td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($noncurrent_liabilities_each).$spacer?></strong></td>
				</tr>
				<?
				//Total non current assets from parent id 13
				$non_current_liabilities_total = $non_current_liabilities_total+$noncurrent_liabilities_each;
				
			}			
			?>
            <tr class="linetop bold ">
            	<td style="background-color:#999;"><?=$spacer.$spacer?>Total Non Current Liabilities</td><td style="background-color:#999;"></td><td style="background-color:#999;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#999; border-top:1px solid #000;"><strong><?=convert_account($non_current_liabilities_total).$spacer?></strong></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer?>Current Liabilities</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?
			$CI =& get_instance();
			$data = $CI->getAccgroups(14) ;
			$current_liabilities_total = 0;
			foreach ($data as $raw){
				$current_liabilities ='';
				$current_liabilities_each = '';
				?>
				<tr>
					<td><?=$spacer.$spacer.$spacer.$raw->name?></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?
				$current_liabilities = new Accountlistbs();
				$current_liabilities->init($raw->id,FYSTV,FYENDV);
				$current_liabilities->account_st_short(0,$type = 'L2');
				$current_liabilities_each = float_ops($current_liabilities_each, $current_liabilities->total, '+');
				?>
				
				<tr class="linetop">
					<td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($current_liabilities_each).$spacer?></strong></td>
				</tr>
				<?
				//Total non current assets from parent id 13
				$current_liabilities_total = $current_liabilities_total+$current_liabilities_each;
				
			}	
			$totalliabilities = $current_liabilities_total+$non_current_liabilities_total;
			?>
            <tr class="linetop bold ">
            	<td style="background-color:#999;"><?=$spacer.$spacer?>Total Current Liabilities</td><td style="background-color:#999;"></td><td style="background-color:#999;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#999; border-top:1px solid #000;"><strong><?=convert_account($current_liabilities_total).$spacer?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#999;"><?=$spacer?>Total Liabilities</td><td style="background-color:#999;"></td><td style="background-color:#999;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#999; border-top:1px solid #000;"><strong><?=convert_account($totalliabilities).$spacer?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#96F;">TOTAL EQUITY AND LIABILITIES</td><td style="background-color:#96F;"></td><td style="background-color:#96F;"></td><td class="bold" align="right" style="border-bottom:1px double #000; background-color:#96F; border-top:1px solid #000;"><strong><?=convert_account($totalliabilities+$equity_total).$spacer?></strong></td>
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

