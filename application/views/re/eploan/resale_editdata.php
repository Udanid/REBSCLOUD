 <h4>Loan Reschedule Details<span style="float:right"><a href="javascript:close_edit('<?=$relsaledata->resale_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
 <script type="text/javascript">
$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );


function change_capital(obj)
{
	//alert('ssss')
	document.getElementById("repay_capital").value=obj;

	var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);

	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");


}
function change_int(obj)
{
	//alert('ssss')
	if(parseFloat(document.getElementById("paid_int").value) >obj)
	{
		document.getElementById("repay_int").value=obj;

		var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);

		document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
	else
	{
		  document.getElementById("checkflagmessage").innerHTML='Refund interest value couldn be greater than the paid interest';
					 $('#flagchertbtn').click();
		document.getElementById("intrefund").value=0.00;
	}

}


 </script>

						<form data-toggle="validator" method="post" action="<?=base_url()?>re/eploan/editdata_resale" enctype="multipart/form-data">
                        <input type="hidden" name="resale_code" id="resale_code" value="<?=$relsaledata->resale_code?>">
                        <input type="hidden" name="loan_code" id="loan_code" value="<?=$relsaledata->loan_code?>">



 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
         <div class="form-title">
								<h5>Loan Details</h5>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                  <? $delaintot=0;
				  $delayrentaltot=0; $arieasins=0; $arreascap=0; $arreasint=0; if($ariastot){foreach($ariastot as $raw)
				  {

					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));
 						$arreascap=$arreascap+$raw->cap_amount-$raw->paid_cap;
					   $arreasint=$arreasint+$raw->int_amount-$raw->paid_int ;
					   $paidtotals=$raw->paid_cap+$raw->paid_int;

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date1 >	 $date2)
					$dates=0-($dates);
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=floatval($details->montly_rental-$paidtotals)*floatval($details->delay_interest)*$delay_date/(100*360);
					 $delaintot= $delaintot+$dalay_int;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;

					}

				  }}?>
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


                           <tr class="table-bordered">
                        <th scope="row">Paid Capital</th><td  align="right"> <?=number_format($totset->totpaidcap,2)  ?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($totset->totpaidint,2) ?></td> <th  >Paid Total</th><td align="right"><?=number_format($totset->totpaidint+$totset->totpaidcap,2)  ?></td>
                         </tr>

                            <?
							$paidpreentage=($totset->totpaidcap/$details->loan_amount)*100;
							$creditcap=0; $creditint=0;
							$delay=0; $ontime=0; if($paylist){foreach($paylist as $row)
				  {

					  $date1=date_create($row->deu_date);
					  $date2=date_create($row->pay_date);
					  $date3=date_create( date("Y-m-d"));
 				$futureDate=date('Y-m-d',strtotime('+1 months',strtotime(date("Y-m-d"))));
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date3<$date1 & $row->deu_date > $futureDate)
					{
						$creditcap=$creditcap+$row->cap_amount;
						$creditint=$creditint+$row->int_amount;
					}
					if($date1< $date2)
					$delay_date=intval($dates)-intval($details->grase_period);
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
                            <? if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='green'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='green'; else $class='green';?>

                         <tr class="warning">
                        <th scope="row">Arrears Capital</th><td> <?=number_format($arreascap,2)  ?> &nbsp; </td><th  align="right">Arrears Interest</th><td><?=number_format($arreasint,2) ?></td> <th  align="right">Arrears Instalments</th><td><?=number_format($arreascap+$arreasint,2)?></td>
                         </tr>
                           <tr class="success">
                       <th >Credit Capital</th><td  align="right"><?=number_format($creditcap,2) ?></td>    <th  >Credit Interest</th><td  align="right"><?=number_format($creditint,2) ?></td>  <th scope="row">Credit Balance</th><td  align="right"> <?=number_format($creditcap+$creditint,2)  ?> &nbsp; </td>
                      </tr>


                          </tbody></table>

                    </div>

							</div>

                           <?
						    $delaintot=get_loan_date_di($details->loan_code,date('Y-m-d'));
						   $balanc=$details->loan_amount-$totset->totpaidcap;
						   $balanceit=$totint-$totset->totpaidint;
						   $type=$details->loan_type;
						   $payableint=$balanceit*10/100;

					//	   echo $delaintot;
						   ?>
                            	<div class="form-body  form-horizontal" >
                               <? if($totset->totpaidcap) $totpaidcap=$totset->totpaidcap; else $totpaidcap=0.00;
							   if($totset->totpaidint) $totpaidint=$totset->totpaidint; else $totpaidint=0.00;

							      //$totamount=$resdetails->down_payment+$totpaidcap-$resdetails->non_refund-$delaintot-$arreasint;
								    $totamount=$resdetails->down_payment+$totpaidcap-$resdetails->non_refund-$delaintot+$creditint-$arreasint;?>
                                   <input type="hidden" name="down_payment" id="down_payment" value="<?=$resdetails->down_payment?>"  >
                             <input type="hidden" name="paid_capital" id="paid_capital" value="<?=$totpaidcap?>"  >
                              <input type="hidden" name="balance_int" id="balance_int"value="<?=$balanceit?>"  >
                                <input type="hidden" name="paid_int" id="paid_int"value="<?=$totpaidint?>"  >
                               <input type="hidden"  name="delay_int" id="delay_int"value="<?=$delaintot?>" >
                                   <input type="hidden"  name="repay_capital" id="repay_capital"value="<?=$relsaledata->repay_capital?>" > <input type="hidden"  name="credit_int" id="credit_int"value="<?=$creditint?>" >

                                     <input type="hidden"  name="repay_int" id="repay_int"value="<?=$relsaledata->repay_int?>" >
                                      <input type="hidden"  name="credit_int" id="credit_int"value="<?=$creditint?>" >
                                      <input type="hidden"  name="arrears_int" id="arrears_int"value="<?=$arreasint?>" >

                           		<div class="form-group">
                     					<label class="col-sm-3 control-label">Paid Capital</label>
										<div class="col-sm-3"><input type="text" class="form-control" name="capital" id="capital"value="<?=number_format($totpaidcap,2)?>"  required readonly="readonly">
                                      </div>
                                         <label class="col-sm-3 control-label" >Paid Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="interest" id="interest"value="<?=number_format($totpaidint,2)?>"  required readonly="readonly">
										</div>
                                       </div>
                                           <div id="loandetails1" >
									 <div class="form-group">

                                      <label class="col-sm-3 control-label" >Down Payment</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="text" class="form-control" name="di_amount" id="di_amount"     required value="<?=number_format($resdetails->down_payment,2) ?>"  >
										</div>



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
									<label class="col-sm-3 control-label">Delay Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="payble_int"    name="payble_int"  value="<?=number_format($relsaledata->delay_int,2) ?>"    data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Payment Refund </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="pay_refund" onchange="change_capital(this.value)"    name="total"   value="<?=number_format($relsaledata->repay_capital,2) ?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                             <div class="form-group ">
									<label class="col-sm-3 control-label">Interest Refund</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="intrefund"  onchange="change_int(this.value)"   name="intrefund"  value="<?=number_format($relsaledata->repay_int,2) ?>"    data-error=""   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Total Refund </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="total"    name="total"   value="<?=number_format($relsaledata->repay_int+$relsaledata->repay_capital,2) ?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                            <div class="form-group ">
								       <label class="col-sm-3 control-label">Request  Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate"   value="<?=$relsaledata->apply_date?>"  data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                          <label class="col-sm-3 control-label">Remark</label>
										<div class="col-sm-3 has-feedback"><select name="remark" id="remark"  class="form-control" required="required">
                                          <option  value="">Select Remark </option>
                                        <option  value="Customer Default" <? if($relsaledata->remark=='Customer Default'){?> selected="selected" <? }?>>Customer Default </option>
                                         <option  value="Title Defect" <? if($relsaledata->remark=='Title Defect'){?> selected="selected" <? }?>>Title Defect</option>
                                          <option  value="Plan Approval Pending"<? if($relsaledata->remark=='Plan Approval Pending'){?> selected="selected" <? }?>> Plan Approval Pending</option>
                                             <option  value="Utility Pending" <? if($relsaledata->remark=='Utility Pending'){?> selected="selected" <? }?>>Utility Pending</option>
                                             <option  value="Data Entry Error" <? if($relsaledata->remark=='Data Entry Error'){?> selected="selected" <? }?>>Data Entry Error</option>
                                             <option  value="Misleading" <? if($relsaledata->remark=='Misleading'){?> selected="selected" <? }?>>Misleading</option>


                                        </select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                        <div class="form-group ">
                                          <label class="col-sm-3 control-label">Documents</label>
                                          <div class="col-sm-3 has-feedback" >
                                            <a href="<?=base_url()?>uploads/resale/documents/<?=$relsaledata->documents?>" target="_blank">&nbsp;&nbsp;&nbsp;<?=$relsaledata->documents?>&nbsp;&nbsp;&nbsp;<i class="fa fa-download nav_icon icon_red"></i></a>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span></div>
                                          </div>




                                       <br /><br /><br />


                    </div>

                    </div>
                    </div>
</div>
</form>
