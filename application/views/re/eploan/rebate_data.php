 <script type="text/javascript">

$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd',minDate: '<?=$this->session->userdata("current_start")?>',
			maxDate: '<?=$this->session->userdata("current_end")?>'});

  } );


function calculete_int()
{
	//alert('ssss')
	var balance_int=parseFloat(document.getElementById("balance_int").value);

	var n=parseFloat(document.getElementById("int_paidrate").value);

	var paid_int=balance_int*(100-n)/100;
	var arrint=parseFloat(document.getElementById("arrears_int").value);
	var currentint=parseFloat(document.getElementById("this_creditint").value);
	paid_int=parseFloat(paid_int)+parseFloat(arrint)+parseFloat(currentint);
	var total=paid_int+parseFloat(document.getElementById("balance_capital").value)+parseFloat(document.getElementById("delay_int").value)-parseFloat(document.getElementById("credit_tot").value)
	document.getElementById("payble_int").value=paid_int.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("int_paidamount").value=paid_int;
	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");


}
function adjust_creditint()
{
	var current_creditint=document.getElementById("this_creditint").value;
	var payableint=document.getElementById("int_paidamount").value;
	var new_discount=document.getElementById("new_discount").value;
				new_discount=new_discount.replace(/\,/g,'')

	//credit_tot
	if(current_creditint>=0)
	{
		var balance_int=parseFloat(document.getElementById("balance_int").value);

	var n=parseFloat(document.getElementById("int_paidrate").value);

	var paid_int=balance_int*(100-n)/100;
	var arrint=parseFloat(document.getElementById("arrears_int").value);
	paid_int=parseFloat(paid_int)+arrint;
			var totint=parseFloat(current_creditint)+parseFloat(paid_int);
		var total=totint+parseFloat(document.getElementById("balance_capital").value)+parseFloat(document.getElementById("delay_int").value)-parseFloat(document.getElementById("credit_tot").value)-parseFloat(new_discount)

		document.getElementById("int_paidamount").value=totint;
		document.getElementById("payble_int").value=totint.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
}
function adjust_delayint()
{
		var delayint=document.getElementById("di_amount").value;
			delayint=delayint.replace(/\,/g,'')
      if(parseFloat(delayint)<0)
      {
        document.getElementById("di_amount").value=document.getElementById("delay_int").value;
        document.getElementById("checkflagmessage").innerHTML="You can not add minus DI";
       $('#flagchertbtn').click();
       //updated by nadee ticket 3400 2021-09-08

      }else{

		var current_creditint=document.getElementById("this_creditint").value;
	var payableint=document.getElementById("int_paidamount").value;
	var new_discount=document.getElementById("new_discount").value;
	var balance_int=parseFloat(document.getElementById("balance_int").value);
	new_discount=new_discount.replace(/\,/g,'')
	document.getElementById("delay_int").value=parseFloat(delayint);
	var n=parseFloat(document.getElementById("int_paidrate").value);

	var paid_int=balance_int*(100-n)/100;
	var arrint=parseFloat(document.getElementById("arrears_int").value);
	paid_int=parseFloat(paid_int)+arrint;
	var totint=parseFloat(current_creditint)+parseFloat(paid_int);
	var total=totint+parseFloat(document.getElementById("balance_capital").value)+parseFloat(document.getElementById("delay_int").value)-parseFloat(document.getElementById("credit_tot").value)-parseFloat(new_discount)
	document.getElementById("payble_int").value=totint.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("int_paidamount").value=totint;
	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
}
function get_loan_detalis(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}

 </script>




 <div class="form-title">
								<h4>Loan Details</h4>
                                <span style="float:right; margin-top:-15px;">  <a href="javascript:get_loan_detalis('<?=$details->loan_code?>')"><span class="label label-success">Loan Inquiry</span></a></span>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >


                        <table class="table " >

                        <tbody> <tr>
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td>
                         </tr>
                          <tr>
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?> &nbsp; </td><th  align="right">Article Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr>
                            <tr class="table-bordered">
                        <th scope="row">Monthly Rental</th><td align="right"> <?=number_format($details->montly_rental,2)  ?> &nbsp; </td><th  >Period</th><td align="right"> <?=$details->period ?></td> <th  >Interest</th><td align="right"><?=$details->interest ?></td>
                         </tr>
                          <tr class="table-bordered">
                        <th scope="row">Capital</th><td  align="right"> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  >Total Interest</th><td align="right"><?=number_format($totint,2) ?></td> <th  >Agreed value</th><td align="right"><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr>

                            <? $creditint=0;  $creditcap=0;
						$deu_data=get_deu_data($details->loan_code,$request_date,$details->loan_type,$details->reschdue_sqn);
						$paiddata= loan_inquary_paid_totals($details->loan_code,$request_date,$details->reschdue_sqn);
						$arr_cap= $deu_data['due_cap']-$paiddata['paid_cap'];
						$arreasint= $deu_data['due_int']-$paiddata['paid_int'];
            //updated by nadee 2021-03-30 ticket number 2582
            //this modification is for cal interest for last due days after last due installment
            $settlement_date=$deu_data['duedate'];
            $lastdue_date=date_create($settlement_date);
            $requestdate2=date_create($request_date);
            $shedulediff=date_diff($lastdue_date,$requestdate2);
            $due_days_count=$shedulediff->format("%a");
            $cal_due_arreasint_todate=0;
            if($due_days_count>0)
            {
              $next_int=get_next_interest_data($details->loan_code,$request_date,$details->loan_type,$details->reschdue_sqn);
              //get_next_interest_data this function is in reaccount_helper
              $cal_due_arreasint_todate=($next_int/30)*$due_days_count;
              $arreasint=$arreasint+$cal_due_arreasint_todate;
            }
            //updated by nadee 2021-03-30 ticket number 2582 end

						if($arr_cap<0)
						{
							$creditcap=(-1)*$arr_cap; $arr_cap=0;
						}
						if($arreasint<0)
						{
							 $creditint=(-1)*$arreasint; $arreasint=0;
						}
						$delaintot=get_loan_date_di($details->loan_code,$request_date)
						 ?>
                           <tr class="table-bordered">
                        <th scope="row">Paid Capital</th><td  align="right"> <?=number_format($totset->totpaidcap,2)  ?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($totset->totpaidint,2) ?></td> <th  >Paid Total</th><td align="right"><?=number_format($totset->totpaidint+$totset->totpaidcap,2)  ?></td>
                         </tr>
                           <tr class="table-bordered info">
                        <th scope="row">Balance Capital</th><td  align="right"> <?=number_format($details->loan_amount-$totset->totpaidcap,2)  ?> &nbsp; </td><th  >Balance Interest</th><td align="right"><?=number_format($totint-$totset->totpaidint,2) ?></td> <th  >Balance Total</th><td align="right"><?=number_format(($totint+$details->loan_amount)-($totset->totpaidint+$totset->totpaidcap),2)  ?></td>
                         </tr>


                         <tr class="table-bordered info">
                        <th scope="row">Due Capital</th><td  align="right"> <?=number_format($deu_data['due_cap'],2)  ?> &nbsp; </td><th  >Due Interest</th><td align="right"><?=number_format($deu_data['due_int'],2) ?></td> <th  >Due Total</th><td align="right"><?=number_format(($deu_data['due_cap']+$deu_data['due_int']),2)  ?></td>
                         </tr>
                          <tr class="table-bordered info">
                        <th scope="row">Future Capital</th><td  align="right"> <?=number_format($details->loan_amount-$deu_data['due_cap'],2)  ?> &nbsp; </td><th  >Future Interest</th><td align="right"><?=number_format($totint-$deu_data['due_int'],2) ?></td> <th  >Future Total</th><td align="right"><?=number_format(($details->loan_amount-$deu_data['due_cap']+$totint-$deu_data['due_int']),2)  ?></td>
                         </tr>

                          <tr class="warning">
                        <th scope="row">Arrears Capital</th><td align="right"> <?=number_format($arr_cap,2)  ?> &nbsp; </td><th  align="right">Arrears Interest</th><td align="right"><?=number_format($arreasint,2) ?></td> <th  align="right">Arrears Instalment</th><td><?=number_format($arr_cap+$arreasint,2)  ?></td>
                         </tr>

                           <tr class="success">
                   <th  >Credit Capital</th><td align="right"><?=number_format($creditcap,2) ?></td>    <th >Credit Interest</th><td align="right"><?=number_format($creditint,2) ?></td>  <th scope="row">Credit Balance</th><td align="right"> <?=number_format($creditcap+$creditint,2)  ?> &nbsp; </td>
                         </tr>
                          <tr class="table-bordered danger">
                        <th scope="row">Delay Interest  Payments</th><td  align="right"> <?=number_format($paiddata['paid_di'],2)  ?> &nbsp; </td><th >Current DI</th><td><?=number_format($delaintot,2)  ?></td><td></td><td></td></tr>
                         </tr>


                          </tbody></table>
                                            </div>

							</div>

                           <?
						   $nextinstalment=get_next_instalmant($details->loan_code,date("Y-m-d"));
						   $thismonthint=0;
						   if($nextinstalment)
						   {
							   $thismonthint=$nextinstalment->int_amount-$nextinstalment->paid_int;
						   }
		//				   echo $creditint;
							if($creditcap<0)
						   $balanc=$details->loan_amount-$totset->totpaidcap - ((-1)*$creditcap);
						   else
						   $balanc=$details->loan_amount-$totset->totpaidcap;
						   $balanceit=$totint-$totset->totpaidint + $creditint -$arreasint ;
						   $type=$details->loan_type;
						   $payableint=$arreasint;
						     $credittotal= $creditint;
						   $totamount=$payableint+$delaintot+ $balanc- $credittotal;

						   ?>
                            	<div class="form-body  form-horizontal" >
                               <? if($totset->totpaidcap) $totpaidcap=$totset->totpaidcap ; else $totpaidcap=0.00;
							   if($totset->totpaidint) $totpaidint=$totset->totpaidint ; else $totpaidint=0.00; ?>
                             <input type="hidden" name="balance_capital" id="balance_capital" value="<?=$balanc?>"  >
                              <input type="hidden" name="balance_int" id="balance_int"value="<?=$balanceit?>"  >
                               <input type="hidden"  name="delay_int" id="delay_int"value="<?=$delaintot?>" >
                                 <input type="hidden"  name="credit_cap" id="credit_cap"value="<?=$creditcap?>" >
                                   <input type="hidden"  name="credit_int" id="credit_int"value="<?=$creditint?>" >
                                     <input type="hidden"  name="credit_tot" id="credit_tot"value="<?=$credittotal?>" >
                                   <input type="hidden"  name="int_paidamount" id="int_paidamount"value="<?=$payableint?>" >
                                    <input type="hidden"  name="arrears_int" id="arrears_int"value="<?=$arreasint?>" >
                            		<div class="form-group">
                     					<label class="col-sm-3 control-label">Balance Capital</label>
										<div class="col-sm-3"><input type="text" class="form-control" name="capital" id="capital"value="<?=number_format($balanc,2)?>"  required readonly="readonly">
                                      </div>
                                         <label class="col-sm-3 control-label" >Balance Future  Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="interest" id="interest"value="<?=number_format($balanceit,2)?>"  required readonly="readonly">
										</div>
                                       </div>
                                       <div class="form-group">
                                         <label class="col-sm-3 control-label"></label>
                     										<div class="col-sm-3">
                                         </div>
                                        <label class="col-sm-3 control-label">Next Installment Arrears Interest </label>
                    										<div class="col-sm-3"><input  type="text" class="form-control" name="nxtarrears_int_val" id="nxtarrears_int_val"  value="<?=number_format($cal_due_arreasint_todate,2)?>"      required readonly="readonly"  >
                                        </div>
                                        </div>
                                           <div id="loandetails1" >
									 <div class="form-group">
                                        <label class="col-sm-3 control-label">Credit Interest</label>
										<div class="col-sm-3"><input  type="text" class="form-control" name="credit_payment" id="credit_payment"  value="<?=number_format($credittotal,2)?>"      required readonly="readonly"  >
                                       </div>

                                      <label class="col-sm-3 control-label">Arrears  Interest </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" step="0.01" class="form-control" id="arrears_int_val"    name="arrears_int_val"   value="<?=number_format($arreasint,2)?>"    data-error="" required="required" readonly="readonly" ></div>


                                      </div>

                                             <!--     <div class="form-group"><label class="col-sm-3 control-label">Sales Officer</label>
			    									<div class="col-sm-3"><select name="collection_officer" id="collection_officer" class="form-control" placeholder="Sales Officer" >
                                    <option value="">Collection officer</option>
                                     < ? foreach ($loan_officer as $raw){?>
                    <option value="< ?=$raw->user_id?>" >< ?=$raw->initial?> &nbsp; < ?=$raw->surname?></option>
                    < ? }?>

                                    </select>
  		</div>
                                      </div>-->
                                     <div class="form-group ">
                                       <label class="col-sm-3 control-label">Int Release Percentage</label>
										<div class="col-sm-3"><input  type="number" class="form-control" name="int_paidrate" id="int_paidrate" onchange="calculete_int()"    max="100"   required value="100"  >
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span> </div>
									<label class="col-sm-3 control-label">Payable Interest Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="payble_int"    name="payble_int"  value="<?=number_format($payableint,2) ?>"    data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>

                                     		</div>
                                            <div class="form-group ">

                                             <label class="col-sm-3 control-label" >Delay Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="text" class="form-control number-separator disallowminus" name="di_amount" id="di_amount"    onchange="adjust_delayint()"   required value="<?=number_format($delaintot,2) ?>"  >

                                        <input  type="hidden" step="0.01" class="form-control" id="this_creditint"    name="this_creditint"  value="0"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                         <label class="col-sm-3 control-label">Aditional Discount </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control number-separator" id="new_discount"    name="new_discount"   value="0"    data-error=""  onchange="adjust_creditint()" required="required"  step="0.01">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>


                                            <div class="form-group ">
                                             <label class="col-sm-3 control-label">Total Amount Payable </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="total"    name="total"   value="<?=number_format($totamount,2) ?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
								       <label class="col-sm-3 control-label">Settlement Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate"  value="<?=date('Y-m-d')?>" readonly="readonly"   data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>

                                               <div class="form-group" style="float:right; margin-right:10px;">
                                           <h3>
                                         		<button type="submit" class="btn btn-primary disabled" >Settle</button></h3>
											</div>


                                       <br /><br /><br />


                    </div>
