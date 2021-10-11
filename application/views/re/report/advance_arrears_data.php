
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month);

}
function expoet_excel(month,branch)
{


				window.open( "<?=base_url()?>re/report/arreas_data_date_excel/"+month+'/'+branch);
}
function expoet_excel2(month,branch)
{


				window.open( "<?=base_url()?>re/report/arreas_data_excel_ins/"+month+'/'+branch);
}
function get_loan_detalis(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}
</script>
<style type="text/css">

</style>
 <?
  $heading2=' Down Payment Arrears Report   as at'.$date;



 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
       <span style="float:right"> <h4><a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a></h4>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >

      <table class="table table-bordered" id="table1">
				<tr >
	 			 <td colspan="26"><center><?=$heading2?></center></td>
	 		 </tr>
     <tr   class="active"><th> Project Name </th><th>LOT Number</th>

			<th> Sales Officer</th>
			 <th>Reservation Date</th>
			 <th>Customer Name</th>
			 <th>Customer Contact Number</th>
			 <th>Land Selling Price</th>
			 <th>Discounted selling price</th>
			 <th>Total Down Payment Amount</th>
			 	<th>Down Payment %</th>
				<th>Sales Type</th>
				<th>Down Payment Repayment Period (Months)</th>
				<th>Arrears Down Payment Amount as at <?=$date?></th>
				<th>Current Month Payment Date</th>
				<th>Current Month Recipt Number</th>
				<th>Recieved Amount During the month</th>
				 	<th>Arrears Amount as at <?=$date?></th>
					<th>Last  Payment Date</th>
					<th>Down Payment Schedule</th>
					<th>No of payment arrears at <?=$date?></th>
					<th>Total Paid Down Payment Amount</th>
					<th>% paid against agreed down payment.</th>
					<th>Balance Down Payment</th>
					<th>Action</th>
					<th>Date</th>
					<th>Customer Feedback</th>
					<th>Officer Feedback or action  & date</th>



		 </tr>

       <? $fulltot=0;?>

       <?
			 $myclass="";
	   $arrtot=0;$renttot=0;$budget=0; $paytot=0; $nextbudgettot=0;$credittot=0;
		 $tot_land=0;
		 $tot_dis=0;
		 $tot_down_pay=0;
		 $tot_arrirs=0;
		 $tot_this_month_pay=0;
		 $tot_paiddown_pay=0;
		 $tot_baldown_pay=0;
	   if($prjlist){foreach($prjlist  as $prraw){ ?>

	<?


			?>
        <?  if($transferlist[$prraw->prj_id]){

			?>
              <tr class="active" style="font-weight:bold"><td><?=$details[$prraw->prj_id]->project_name?></td><td colspan="27"></td></tr>

            <?
			foreach($transferlist[$prraw->prj_id] as $raw){
				//print_r($arrearspay[$raw->res_code]);
				$shedule_count_amount=0;
				if($shedule_count[$raw->res_code]>0){
					$shedule_count_amount=$shedule_count[$raw->res_code];}
				else{
					$shedule_count_amount="1";//migration data should be  show as 1 shedule
				}
				$balance_downpayment=$raw->min_down-$raw->down_payment;
				if($balance_downpayment<0){
					$balance_downpayment=0;
				}
				//$current_month_pay_date=$thispay[$raw->res_code]->entry_date;
				$current_month_pay_date=$thispay[$raw->res_code]->income_date;
				$current_month_receipt_no=$thispay[$raw->res_code]->rct_no;
				$receipts_during_month=$thispay[$raw->res_code]->tot;
				$last_pay_date=get_last_payment_date($raw->res_code);
				$arries_amount=0;
				$arries_ins=0;
				if(isset($shedule_data[$raw->res_code]) && $shedule_count[$raw->res_code]>0){
				foreach ($shedule_data[$raw->res_code] as $key2 => $value2) {
					if(strtotime($date)>strtotime($value2->due_date) && $value2->status=="PENDING"){
						$arries_ins=$arries_ins+1;
						$arries_amount=$arries_amount+($value2->amount-$value2->paid_amount);
					}
					if(strtotime($date)>strtotime($value2->due_date) && strtotime($sartdate)<strtotime($value2->due_date)){
						//$current_month_pay_date=$value2->due_date;
					}
						}
			 }else{
				 if($date>$raw->dp_fulcmpdate){
					 $arries_ins=1;
					 $arries_amount=$balance_downpayment;
				 }
				}?>

      	<tr class="<?=$myclass?>"><td><?=$raw->res_code?>

        &nbsp;&nbsp;<a href="javascript:add_followup_detalis('<?=$raw->res_code?>','<?=$reportdata?>')"><i class="fa fa-phone nav_icon icon_red "></i></a>
        </td><td><?=$raw->lot_number?></td>
				<td><?=get_user_fullname_id($raw->sales_person)?></td>
				<td><?=$raw->res_date?></td>
				<td><?=$raw->first_name?> <?=$raw->last_name?></td>
				<td><?=$raw->mobile?></td>
				<td align="right"><?=number_format($raw->sale_val,2)?></td>
				<td align="right"><?=number_format($raw->discounted_price,2)?></td>
				<td align="right"><?=number_format($raw->min_down,2)?></td>
				<?
				$disdown_presant=($raw->min_down/$raw->discounted_price)*100;
				?>
				<td align="right"><?=number_format($disdown_presant,2)?>%</td>
				<td><?=$raw->pay_type?></td>
				<td><?=$shedule_count_amount?></td>
				<td align="right"><?=number_format($arries_amount,2)?></td>
				<td><?=$current_month_pay_date?></td>
				<td align="right"><?=$current_month_receipt_no?></td>
				<td align="right"><?=number_format($receipts_during_month,2)?></td>
				<td align="right"><?=number_format($arries_amount,2)?></td>
				<td><?=$last_pay_date?></td>

				<td><table><? if(isset($shedule_data[$raw->res_code]) && $shedule_count[$raw->res_code]>0){?>

				<?	foreach ($shedule_data[$raw->res_code] as $key2 => $value2) {?>
					<tr>
						<td><?=$value2->due_date?></td>
						<td align="right"><?=number_format($value2->amount,2)?></td>

					</tr>
				<?	}?>

			<? }else{?>
				<tr>
					<td><?=$raw->dp_fulcmpdate?></td>
				<td align="right"><?=number_format($raw->down_payment,2)?></td>

			</tr>
		<?	}?></table></td>
				<td><?=$arries_ins?></td>

				<td align="right"><?=number_format($raw->down_payment,2)?></td>
				<?
				$down_presant=($raw->down_payment/$raw->min_down)*100;
				?>
				<td align="right"><?=number_format($down_presant,2)?></td>

				<td align="right"><?=number_format($balance_downpayment,2)?></td>

				<td><?=$feedback[$raw->res_code]->contact_media?></td>
				<td><?=$feedback[$raw->res_code]->follow_date?></td>
				<td><?=$feedback[$raw->res_code]->cus_feedback?></td>
				<td><?=$feedback[$raw->res_code]->sales_feedback?></td>

            </tr>
		<? 	?>


        <?
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
	$tot_land=$tot_land+$raw->sale_val;
	$tot_dis=$tot_dis+$raw->discounted_price;
	$tot_down_pay=$tot_down_pay+$raw->min_down;
	$tot_arrirs=$tot_arrirs+$arries_amount;
	$tot_this_month_pay=$tot_this_month_pay+$receipts_during_month;
	$tot_paiddown_pay=$tot_paiddown_pay+$raw->down_payment;
	$tot_baldown_pay=$tot_baldown_pay+$balance_downpayment;
		}}?>






      <?
	//  $fulltot=$fulltot+$prjexp;
	   }}

	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="2">Total</td>

			 			<th></th>
			 			 <th></th>
			 			 <th></th>
			 			 <th></th>
			 			 <th><?=number_format($tot_land,2)?></th>
			 			 <th><?=number_format($tot_dis,2)?></th>
			 			 <th><?=number_format($tot_down_pay,2)?></th>
			 			 	<th></th><th></th><th></th>
			 				<th><?=number_format($tot_arrirs,2)?></th>
			 				<th></th><th></th>
			 				<th><?=number_format($tot_this_month_pay,2)?></th>
			 				 	<th><?=number_format($tot_arrirs,2)?></th>
			 					<th></th><th></th><th></th>
			 					<th><?=number_format($tot_paiddown_pay,2)?></th>
			 					<th></th>
			 					<th><?=number_format($tot_baldown_pay,2)?></th>
			 					<th></th><th></th><th></th><th></th>


			 		 </tr>
         </table>




         </div>
    </div>




         </div>
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
  tableToExcel('table1', 'EP Arrears Report', 'Arrears_Report.xls');
 });

    $('#create_excel_2').click(function(){
  tableToExcel('table2', 'EP Arrears Report Installment wise', 'EP_Arrears_Report_Installment_wise.xls');
 });
</script>
