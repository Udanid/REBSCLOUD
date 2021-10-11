<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	window.close();
}
</script>
<body onLoad="print_function()">
<div class="form-title">
								<h4>Loan Details</h4>
							</div>

	 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
	 	<?
	 	$totint=((($loan_data->total_period/12)*$loan_data->interest_rate)/100)*$loan_data->loan_amount;
	 	$bal_cap=$loan_data->loan_amount-$paydata->totcap_amount;
	 	$bal_int=$totint-$paydata->totint_amount;
	 	$bal_tot=$bal_cap+$bal_int;
	 	$paidpreentage=($paydata->totcap_amount/$loan_data->loan_amount)*100;
	 	$creditcap=0; $creditint=0; $thisinsalment=NULL;
	 	$delay=0; $ontime=0;$arreascap=0;$arreasint=0;$arreascount=0;
	 	if($paydetails){
	 		foreach ($shedetails as $key => $value) {
	 			//$thisinsalment[$row->ins_id]['ins_cap']=$row->ins_cap;
	 			//$thisinsalment[$row->ins_id]['ins_int']=$row->ins_int;

	 			$date1=date_create($value->deu_date);
	 			$date2=date_create($value->pay_date);
	 			$date3=date_create( date("Y-m-d"));

	 			$diff=date_diff($date1,$date2);
	 			$dates=$diff->format("%a");
	 			if($date3<$date1)
	 			{
	 				$creditcap=$creditcap+$value->cap_amount;
	 				$creditint=$creditint+$value->int_amount;
	 			}
	 			if($date1<$date3)
	 			{
	 				if($value->pay_status=="PENDING"){
	 					$arreascap=$arreascap+$value->cap_amount;
	 					$arreasint=$arreasint+$value->int_amount;
	 					$arreascount++;
	 				}

	 			}
	 			if($date1< $date2)
	 			$delay_date=intval($dates)-intval($loan_data->grace_period);
	 			else
	 			$delay_date=0;


	 			if($delay_date >0)
	 			{
	 				$delay++;

	 			}
	 			else
	 			{
	 				$ontime++;
	 			}
	 		}}

	 		$totpay=$ontime+$delay;
	 		if($totpay>0)
	 		$payeve=($ontime/$totpay)*100;
	 		else $payeve=0;
	 		?>

	 		<h3> </h3>
	 		<table class="table " >

	 			<tbody>
	 				<tr>
	 					<th scope="row">Loan Number</th><td><?=$loan_data->loan_number;?> &nbsp; </td><th  align="right">Loan Status</th><td><?=$loan_data->loan_status;?></td> <th  align="right">Contract Date</th><td><?=$loan_data->loan_date;?></td>
	 				</tr>
	 				<tr class="table-bordered">
	 					<th scope="row">Monthly Rental</th><td align="right"><?=number_format($loan_data->loan_installment_value,2);?>  &nbsp; </td><th>Period</th><td align="right"><?=$loan_data->total_period;?></td> <th  >Interest</th><td align="right"><?=$loan_data->interest_rate;?></td>
	 				</tr>
	 				<tr class="table-bordered">
	 					<th scope="row">Capital</th><td  align="right"><?=number_format($loan_data->loan_amount,2);?> &nbsp; </td><th scope="row" colspan="4"></th>
	 				</tr>

	 				<tr class="table-bordered">
	 					<th scope="row">Paid Capital</th><td  align="right"><?=number_format($paydata->totcap_amount,2);?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($paydata->totint_amount,2);?></td> <th  >Paid Total</th><td align="right"><?=number_format($paydata->totpay_amount,2);?></td>
	 				</tr>
	 				<tr class="table-bordered info">
	 					<th scope="row">Balance Capital</th><td  align="right"><?=number_format($bal_cap,2);?>  &nbsp; </td><th scope="row" colspan="4"></th>
	 				<tr class="table-bordered">
	 					<th scope="row">Settlement Method</th><td  align="right">
	 						<?
	 						if($loan_data->payment_method=='1'){
	 							echo "Deduct From Bank";
	 						}else if($loan_data->payment_method=='2'){
	 							echo "Dated Cheque Issued";
	 						}else if($loan_data->payment_method=='3'){
	 							echo "Post Dated Cheque";
	 						}
	 						?>
	 					</td>
	 				</tr>
	 				<? if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='green'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='green'; else $class='green';?>
	 					<tr><th>Paid percentage </th><td> <div class="task-info">
	 						<span class="task-desc">Paid percentage</span><span class="percentage"><?=number_format($paidpreentage,2)?>%</span>
	 						<div class="clearfix"></div>
	 					</div>
	 					<div class="progress progress-striped active">
	 						<div class="bar <?=$class?>" style="width:<?=$paidpreentage?>%;"></div>
	 					</div></td><td></td>
	 					<? if($payeve>=60) $class='green'; else if($payeve<60 && 35>=50)  $class='blue'; else if($payeve<50 && $payeve>=25)  $class='yellow'; else $class='red';?>
	 						<th>Payment Evaluation </th><td> <div class="task-info">
	 							<span class="task-desc">Ontime Payments</span><span class="percentage"><?=number_format($payeve,2)?>%</span>
	 							<div class="clearfix"></div>
	 						</div>
	 						<div class="progress progress-striped active">
	 							<div class="bar <?=$class?>" style="width:<?=$payeve?>%;"></div>
	 						</div></td>


	 					</tr>
	 					<tr class="warning">
	 						<th scope="row">Arrears Rental</th><td> <?=number_format($arreascap+$arreasint,2)  ?> &nbsp; </td><th  align="right"></th><td></td> <th  align="right">Arrears Instalments</th><td><?=$arreascount;?></td>
	 					</tr>
	 					<tr class="success">
	 						<th  >Credit Capital</th><td align="right"><?=number_format($creditcap,2) ?></td>    <th >Credit Interest</th><td align="right"><?=number_format($creditint,2) ?></td>  <th scope="row">Credit Balance</th><td align="right"><?=number_format($creditcap+$creditint,2)  ?> &nbsp; </td>
	 					</tr>

	 				</tbody></table>

	 			</div>

	 		</div>

	 		<div class="form-title">
	 			<h4>Payment History
	 			</h4>

	 		</div>
	 		<div class="form-body  form-horizontal" >

	 			<table class="table table-bordered"><tr><th>ID</th><th> Paid Capital</th><th> Paid Interest</th><th> Total Pay Amount</th><th>Payment Type</th><th>Payment Date</th><th>Receipt No </th><th>Receipt Date </th></tr>
	 <?
	 if($paydetails){
	 $i=0;
	 foreach ($paydetails as $key => $value) {
	 	$i++;
	 	?>
	 	<tr >
	 		<td><?=$i;?></td>
	 		<td><?=$value->cap_amount;?></td>
	 		<td><?=$value->int_amount;?></td>
	 		<td><?=$value->pay_amount;?></td>
	 		<td>
	 			<?
	 			if($value->pay_type=='installment'){
	 				echo "Installment";
	 			}else if($value->pay_type=="capital_payment"){
	 				echo "Capital Payment";
	 			}
	 			?>
	 		</td>
	 		<td><?=$value->pay_date;?></td>
	 		<td><?=$value->voucher_id;?></td>
	 		<td></td>

	 	</tr>
	 <?  }
	 }
	 ?>
	 				</table>

	 			</div> <div class="form-body  form-horizontal" >


	 				<!--- <div class="form-title">
	 				<h4>Rental Computation</h4>
	 			</div>
	 			<table class="table table-bordered"><tr><th>Instalment Date</th><th>Loan Capital</th><th>This Month Int</th><th>This Month Payment</th><th>Closing bal</th></tr>
	 			<tr>
	 			<td></td>
	 			<td></td>
	 			<td></td>
	 			<td></td>
	 			<td></td>
	 		</tr>


	 	</table>--->

	 </div>
