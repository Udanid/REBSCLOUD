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
       <div class="form-body ">
	    <?php
	   	echo form_open('accounts/report/balancesheet_period/' );
		?>
       <div class="form-group">
     	<?			
	//	echo form_submit('submit', 'Show');
	?><div class="col-sm-6 "> 
    										<div class="col-sm-6 ">
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
		if($todate !="")
		{
			$stdate=$stdate=$this->session->userdata('fy_start');
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
	<table width="100%" border="0" cellspacing="0" id="bstable" cellpadding="0" class="table table-bordered table2excel">
    	<thead>
        	<tr>
            	
            	<th colspan="5" align="justify">
        					<h4 align="center"><?=strtoupper(companyname)?><br>
                            <?
                            $sdate = strtotime(FYSTV);
							$newsdate = date('F d, Y',$sdate);
							
							$edate = strtotime(FYENDV);
							$newedate = date('F d, Y',$edate);
							?>
                            <?=date('Y',strtotime(FYSTV)).'-'.date('Y',strtotime(FYENDV))?> Balance Sheet<br>
                            as at <?=$newedate?></h4>
                            
        		</th>
            </tr>
       </thead>
       <tbody>
            <tr style="background:#A8F185;">
            	<td><strong>ASSETS</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><strong>Non Current Assets</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer;?><strong>Fixed Assets</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?><strong>Free Hold Assets</strong></td>
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
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($freehold_assets_total)?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?><strong>Accumulated Depreciation - Free Hold Assets</strong></td>
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
			$netfreehold = $freehold_assets_total-$acc_depreciation_total
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right" style="border-bottom:1px solid #000;"><strong>(<? echo convert_account($acc_depreciation_total).')';?></strong></td><td></td>
            </tr>
            <tr style="background:#FFC;">
            	<td><?=$spacer;?><strong>Net Free Hold Assets</strong></td>
                <td></td>
                <td></td>
                <td align="right"><strong><?=convert_account($netfreehold)?></strong></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?><strong>Lease Hold Assets</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Lease Hold Assets (Group 69)
			$leasehold_assets_total = '';
			$leasehold_assets = new Accountlistbs();
			$leasehold_assets->init(69,FYSTV,FYENDV);
			$leasehold_assets->account_st_short(0,$type = 'L1');
			$leasehold_assets_total = float_ops($leasehold_assets_total, $leasehold_assets->total, '+');
			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($leasehold_assets_total)?></strong></td><td></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?><strong>Accumulated Depreciation - Lease Hold Assets</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Accumulated Depreciation (Group 41)
			$acc_depreciationlh_total = '';
			$acc_depreciationlh = new Accountlistbs();
			$acc_depreciationlh->init(70,FYSTV,FYENDV);
			$acc_depreciationlh->account_st_short(0,$type = 'L1');
			$acc_depreciationlh_total = float_ops($acc_depreciationlh_total, $acc_depreciationlh->total, '-');
			
			//Net Lease Hold Assets
			$netleasehold = $leasehold_assets_total-$acc_depreciationlh_total;
			

			?>
            <tr class="linetop">
            	<td></td><td style="border-bottom:1px solid #000;"></td><td align="right" style="border-bottom:1px solid #000;"><strong>(<? echo convert_account($acc_depreciationlh_total).')';?></strong></td><td></td>
            </tr>
            <tr style="background:#FFC;">
            	<td><?=$spacer;?><strong>Net Lease Hold Assets</strong></td>
                <td></td>
                <td></td>
                <td align="right"><strong><?=convert_account($netleasehold)?></strong></td>
            </tr>
            <tr>
            	<td><?=$spacer.$spacer;?><strong>Financial Asset</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <? 
			//Financial assets (Group 476)
			$financial_assets_total = '';
			$financial_assets = new Accountlistbs();
			$financial_assets->init(76,FYSTV,FYENDV);
			$financial_assets->account_st_short(0,$type = 'L1');
			$financial_assets_total = float_ops($financial_assets_total, $financial_assets->total, '+');
			
			?>
           <tr style="background:#FFC;">
            	<td><?=$spacer;?><strong>Net Financial Assets</strong></td>
                <td></td>
                <td></td>
                <td align="right"><strong><?=convert_account($financial_assets_total)?></strong></td>
            </tr>
           <?
			//total fixed assets
			$total_fixed_assets = $netfreehold+$netleasehold+$financial_assets_total;
			?>
            
            <tr class="linetop bold ">
            	<td style="background-color:#B9D6EF;"><?=$spacer?><strong>Total Fixed Assets</strong></td><td style="background-color:#B9D6EF;"></td><td style="background-color:#B9D6EF;"></td><td class="bold" align="right" style="border-bottom:1px solid #000; background-color:#B9D6EF; border-top:1px solid #000;"><strong><?=convert_account($total_fixed_assets)?></strong></td>
            </tr>
            
            <? 

			$total_noncurrent = $total_fixed_assets;
			//$total_noncurrent = $total_fixed_assets+$netintangible+$fixed_deposit_total;
			?>
           
            <tr class="linetop bold " style="background-color:#CCC;">
            	<td><strong>Total Non-Current Assets</strong></td><td></td><td></td><td class="bold" align="right" style="border-bottom:1px solid #000; border-top:1px solid #000;"><strong><?=convert_account($total_noncurrent)?></strong></td>
            </tr>
            <tr>
            	<td><strong>Current Assets</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?=$spacer?><strong>Cash & Cash Equivalents</strong></td>
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
							<td><strong><?=$spacer.$spacer.$raw->name?></strong></td>
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
							<td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($current_asset_each)?></strong></td>
						</tr>
						<?
						//Total current assets from parent id 9
						$current_asset_total = $current_asset_total+$current_asset_each;
					
				}
				?>
                <tr>
                  <td><?=$spacer?><strong>Other Current Asset</strong></td>
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
                        <td><strong><?=$spacer.$spacer.$raw->name?></strong></td>
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
                        <td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($current_asset_each)?></strong></td>
                    </tr>
                    <?
					//Total current assets from parent id 9
					$cashequivalent = $cashequivalent+$current_asset_each;
					
				}
				$current_asset_total = $current_asset_total+$cashequivalent;
				
		   ?>
          
            <tr class="linetop bold" style="background:#CCC;">
            	<td><?=$spacer?><strong>Total Current Assets</strong></td><td></td><td></td><td class="bold" align="right" style="border-bottom:1px solid #000; border-top:1px solid #000;"><strong><?=convert_account($current_asset_total)?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#96F;"><strong>TOTAL ASSETS</strong></td><td style="background-color:#96F;"></td><td style="background-color:#96F;"></td><td class="bold" align="right" style="border-bottom:1px double #000; background-color:#96F; border-top:1px solid #000;"><strong><?=convert_account($current_asset_total+$total_noncurrent)?></strong></td>
            </tr>
            <tr style="background:#A8F185;">
            	<td><strong>EQUITY & LIABILITIES</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><strong>Equity</strong></td>
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
			$equity_total = float_ops($equity_total, $equity->total, '-');
			$net_profit = calculate_netprofit(FYSTV,FYENDV);
			$equity_total = float_ops($equity_total, $net_profit, '-');
			?>
            <tr>
                <td><?=$spacer.$spacer.$spacer;?><strong>Net Profit After Taxation</strong></td><td align="right"><?=number_format(abs($net_profit),2); ?></td><td></td><td align="right"></td>
            </tr>
            <tr class="linetop bold" style="background:#CCC;">
            	<td><strong>Total Equity</strong></td><td></td><td></td><td class="bold" align="right" style="border-bottom:1px solid #000; border-top:1px solid #000;"><strong><?=convert_account($equity_total)?></strong></td>
            </tr>
            <tr>
            	<td><strong>Liabilities</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td><?=$spacer;?><strong>Non Current Liabilities</strong></td>
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
					<td><strong><?=$spacer.$spacer.$spacer.$raw->name?></strong></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?
				$noncurrent_liabilities = new Accountlistbs();
				$noncurrent_liabilities->init($raw->id,FYSTV,FYENDV);
				$noncurrent_liabilities->account_st_short(0,$type = 'L2');
				$noncurrent_liabilities_each = float_ops($noncurrent_liabilities_each, $noncurrent_liabilities->total, '-');
				?>
				
				<tr class="linetop">
					<td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($noncurrent_liabilities_each)?></strong></td>
				</tr>
				<?
				//Total non current assets from parent id 13
				$non_current_liabilities_total = $non_current_liabilities_total+$noncurrent_liabilities_each;
				
			}			
			?>
            <tr class="linetop bold " style="background:#CCC;">
            	<td><?=$spacer?><strong>Total Non Current Liabilities</strong></td><td></td><td></td><td class="bold" align="right" style="border-bottom:1px solid #000; border-top:1px solid #000;"><strong><?=convert_account($non_current_liabilities_total)?></strong></td>
            </tr>
            <tr>
            	<td><?=$spacer?><strong>Current Liabilities</strong></td>
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
					<td><strong><?=$spacer.$spacer.$raw->name?></strong></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?
				//if($raw->id!=39){ //we do not print group 39 i.e. project expenses liability
				$current_liabilities = new Accountlistbs();
				$current_liabilities->init($raw->id,FYSTV,FYENDV);
				$current_liabilities->account_st_short(0,$type = 'L2');
				$current_liabilities_each = float_ops($current_liabilities_each, $current_liabilities->total, '-');
				?>
				
				<tr class="linetop">
					<td></td><td></td><td style="border-bottom:1px solid #000;"></td><td align="right"><strong><?=convert_account($current_liabilities_each)?></strong></td>
				</tr>
				<?
				$total_project_expences = 0;
				
				$current_liabilities_total = $current_liabilities_total+$current_liabilities_each;
			}	
			$current_liabilities_total = $current_liabilities_total+$total_project_expences;
			$totalliabilities = $current_liabilities_total+$non_current_liabilities_total;
			?>
            <tr class="linetop bold " style="background:#CCC;">
            	<td><?=$spacer;?><strong>Total Current Liabilities</strong></td><td></td><td></td><td class="bold" align="right" style="border-bottom:1px solid #000;  border-top:1px solid #000;"><strong><?=convert_account($current_liabilities_total)?></strong></td>
            </tr>
            <tr class="linetop bold "  style="background:#CCC;">
            	<td><strong>Total Liabilities</strong></td><td></td><td></td><td class="bold" align="right" style="border-bottom:1px solid #000;  border-top:1px solid #000;"><strong><?=convert_account($totalliabilities)?></strong></td>
            </tr>
            <tr class="linetop bold ">
            	<td style="background-color:#96F;"><strong>TOTAL EQUITY AND LIABILITIES</strong></td><td style="background-color:#96F;"></td><td style="background-color:#96F;"></td><td class="bold" align="right" style="border-bottom:1px double #000; background-color:#96F; border-top:1px solid #000;"><strong><?=convert_account($totalliabilities+$equity_total)?></strong></td>
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

