<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="<?=base_url()?>media/css/font-awesome.css" rel="stylesheet"> 
<link href="<?=base_url()?>media/css/material-color.css" rel="stylesheet">
<!-- //font-awesome icons -->
 <!-- js-->
<script src="<?=base_url()?>media/js/jquery-1.11.1.min.js"></script>
<script src="<?=base_url()?>media/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="<?=base_url()?>media/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?=base_url()?>media/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- chart -->
<script src="<?=base_url()?>media/js/Chart.js"></script>
<!-- //chart -->
<!--Calender-->
<link rel="stylesheet" href="<?=base_url()?>media/css/clndr.css" type="text/css" />
<script src="<?=base_url()?>media/js/underscore-min.js" type="text/javascript"></script>
<script src= "<?=base_url()?>media/js/moment-2.2.1.js" type="text/javascript"></script>
<script src="<?=base_url()?>media/js/clndr.js" type="text/javascript"></script>
<script src="<?=base_url()?>media/js/site.js" type="text/javascript"></script>
<!--End Calender-->
<!-- Metis Menu -->
<script src="<?=base_url()?>media/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>media/js/custom.js"></script>
<link href="<?=base_url()?>media/css/custom.css" rel="stylesheet">
</head>
<script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>
<body onload="print()">
<?
	 $totamount=floatval($datalist->int_paidamount)+floatval($datalist->delay_int)+ floatval($datalist->balance_capital)- floatval($datalist->credit_tot);
	 $request_date = $datalist->request_date;
	 if($totamount<0)
	 	$totamount = 0;

	 if($loan_details)
	 {		
	 		$deu_data=get_deu_data($loan_details->loan_code,$request_date,$loan_details->loan_type,$loan_details->reschdue_sqn);
	 		$paiddata= loan_inquary_paid_totals($loan_details->loan_code,$request_date,$loan_details->reschdue_sqn);
	 		$arreasint= $deu_data['due_int']-$paiddata['paid_int'];

	 	 	$settlement_date=$deu_data['duedate'];
            $lastdue_date=date_create($settlement_date);
            $requestdate2=date_create($request_date);
            $shedulediff=date_diff($lastdue_date,$requestdate2);
            $due_days_count=$shedulediff->format("%a");
            $cal_due_arreasint_todate=0;
            if($due_days_count>0)
            {
              $next_int=get_next_interest_data($loan_details->loan_code,$request_date,$loan_details->loan_type,$loan_details->reschdue_sqn);
              //get_next_interest_data this function is in reaccount_helper
              $cal_due_arreasint_todate=($next_int/30)*$due_days_count;
              $arreasint=$arreasint+$cal_due_arreasint_todate;
              if($cal_due_arreasint_todate<0)
              	$cal_due_arreasint_todate = 0;
              if($arreasint<0)
              	$arreasint = 0;
            }
	 }
?>
<h4 style="text-align:center;margin-top:60px;"><?=companyname?></h4>
<h4 style="text-align:center;">Early Settlement as at <?=$datalist->apply_date;?></h4>
<div class="container">
	<br>
	<table>
		<tr>
			<th style="text-align: left">Project:</th>
			<th style="text-align: left;"><?=$datalist->project_name;?></th>
		</tr>
		<tr>
			<th style="text-align: left">Lot No:</th>
			<th style="text-align: left;"><?=$datalist->lot_number;?></th>
		</tr>
		<tr>
			<th style="text-align: left">Customer Name:</th>
			<th style="text-align: left;"><?=$datalist->first_name;?> <?=$datalist->last_name;?></th>
		</tr>
		<tr>
			<th style="text-align: left">NIC NO:</th>
			<th style="text-align: left;"><?=$datalist->id_number;?></th>
		</tr>
	</table>
</div>
<br><div>
                          
                           			<table>
                           				<tr>
                           					<td>
                           						<label class="col-sm-3 control-label">Balance Capital</label>
                           					</td>
	                           				<td>
											<input type="text" class="form-control" name="capital" id="capital"value="<?=number_format($datalist->balance_capital,2);?>"   required readonly="readonly"></td>
											<td>
												<label class="col-sm-3 control-label" >Balance Future  Interest</label>
											</td>
											<td>
												<input type="text" class="form-control" name="interest" id="interest"value="<?=number_format($datalist->balance_int,2);?>"  required readonly="readonly">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td> <label class="col-sm-3 control-label">Next Installment Arrears Interest </label></td>
											<td><input  type="text" class="form-control" name="nxtarrears_int_val" id="nxtarrears_int_val"  value="<?=number_format($cal_due_arreasint_todate,2)?>"      required readonly="readonly"  ></td>
										</tr>
										<tr>
											<td> <label class="col-sm-3 control-label">Credit Interest</label></td>
											<td><input  type="text" class="form-control" name="credit_payment" id="credit_payment"  value="<?=number_format($datalist->credit_tot,2);?>"      required readonly="readonly"  ></td>
											<td>
												<label class="col-sm-3 control-label">Arrears  Interest </label>
											</td>
											<td><input  type="text" step="0.01" class="form-control" id="arrears_int_val"    name="arrears_int_val"   value="<?=number_format($arreasint,2)?>"    data-error="" required="required" readonly="readonly" ></td>
										</tr>
										<tr>
											<td>
												 <label class="col-sm-3 control-label">Int Release Percentage</label>
											</td>
											<td>
												<input  type="number" class="form-control" name="int_paidrate" id="int_paidrate" onchange="calculete_int()"    max="100"   required value="<?=number_format($datalist->int_paidrate,2);?>"  >
											</td>
											<td>
												<label class="col-sm-3 control-label">Payable Interest Amount</label>
											</td>
											<td>
												<input  type="text" class="form-control" id="payble_int"    name="payble_int"  value="<?=number_format($datalist->int_paidamount,2)?>"    data-error="" readonly="readonly"   required="required" >
											</td>
										</tr>
										<tr>
											<td>
												 <label class="col-sm-3 control-label" >Delay Interest</label>
											</td>
											<td>
												<input  type="text" class="form-control" name="di_amount" id="di_amount"    onchange="adjust_delayint()"   required value="<?=number_format($datalist->delay_int,2);?>"  >
											</td>
											<td>
												 <label class="col-sm-3 control-label">Aditional Discount </label>
											</td>
											<td>
												<input  type="text" class="form-control number-separator" id="new_discount"    name="new_discount"   value="<?=number_format($datalist->new_discount,2)?>"    data-error="" required="required"  step="0.01">
											</td>
										</tr>
										<tr>
											<td>
												<label class="col-sm-3 control-label">Total Amount Payable </label>
											</td>
											<td>
												<input  type="text" class="form-control" id="total"    name="total"   value="<?=number_format($totamount,2);?>"    data-error="" required="required" >
											</td>
									
										
											<td>
												  <label class="col-sm-3 control-label">Settlement Date</label>
											</td>
											<td>
												<input  type="text" class="form-control" id="settldate"    name="settldate"  value="<?=$datalist->apply_date;?>" readonly="readonly"   data-error="" required="required" >
											</td>
										</tr>
                           			</table>
                           			<br><br><br><br>

 	<table>
 		<tr>
 			<td>&nbsp;&nbsp;.....................................................</td>
 			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
 			<td>..............................................................</td>
 		</tr>
 		<tr>
 			<td>&nbsp;&nbsp;Prepared by</td>
 			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
 			<td>Authorised Signatue</td>
 		</tr>
 		<tr>
 			<td>&nbsp;&nbsp;Finance division</td>
 			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
 			<td>Finance division</td>
 		</tr>
 	</table>
</div>
 </body>                      
