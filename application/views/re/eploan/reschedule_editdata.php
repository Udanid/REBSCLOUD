 <h4>Loan Reschedule Details<span style="float:right"><a href="javascript:close_edit('<?=$reschdata->rsch_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
 <script type="text/javascript">
$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 
 function check_this_totals()
 {  
 	var pendingamount=parseFloat(document.getElementById('pendingamount').value);
   var payamoount=parseFloat(document.getElementById('amount').value);
   if(document.getElementById('task_id').value=="")
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select Task'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
  
   if(payamoount>pendingamount)
   {
	    document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Budget Allocation'; 
					 $('#flagchertbtn').click();
					 document.getElementById('amount').value="";
   }
	
	 
 }


function load_subtasklist(id)
{
	 var prj_id= document.getElementById("prj_id").value;
	 if(id!=""){
	 taskid=id.split(",")[0];
	 
	 document.getElementById("pendingamount").value=id.split(",")[1];
	 
						 $('#subtaskdata').delay(1).fadeIn(600);
    					    document.getElementById("subtaskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#subtaskdata" ).load( "<?=base_url()?>common/get_subtask_list/"+taskid+"/"+ prj_id	);
				
	 
	 
		
 }
	 
}

function loadcurrent_block(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata" ).load( "<?=base_url()?>re/reservation/get_advancedata/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#plandata').delay(1).fadeOut(600);
 }
}

function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}
function load_epdata(value)
{
	
	if(value!='Outright')
	{
		
		 $('#loandetails1').delay(1).fadeIn(600);
		   if(value=='EPB')
		{
		document.getElementById("period").value=3;
		document.getElementById("interest").value=20;
		}
		if(value=='ZEP')
		{
		document.getElementById("period").value=6;
		document.getElementById("interest").value=0;
		}
		if(value=='NEP')
		{
		document.getElementById("interest").value=18;
		}
		
	}
	else
	{
		
	$('#loandetails1').delay(1).fadeOut(600);
	document.getElementById("instalments").value=document.getElementById("finance_amount").value
	}
}
function instalment_cal()
{
	//alert('ssss')
	var principle=parseFloat(document.getElementById("new_cap").value);
	
	var n=parseFloat(document.getElementById("period").value);
	
	var int=parseFloat(document.getElementById("interest").value)
	var totint=0;
	if(int>0)
	{
		var int=parseFloat(document.getElementById("interest").value)/100;
		var i=parseFloat(int)/12;
		var years=parseFloat(n)/12;
		var totint=parseFloat(principle)*int*years;
		//var div=((Math.pow(1 + parseFloat(i), parseFloat(n)) - 1));
		//var multi=Math.pow(1 + parseFloat(i), parseFloat(n));
	//alert(div);
	//alert(parseFloat(principle));
		var instal=(parseFloat(principle) +parseFloat(totint) )/ parseFloat(n);
		totint=(parseFloat(instal) * parseFloat(n))-parseFloat(principle)
	}
	else
	{
		var instal=parseFloat(principle)/ parseFloat(n);
	}
	
	document.getElementById("instalments").value=instal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		value=document.getElementById("pay_type").value;
		if(value=='NEP' || value=='ZEP')
		{
			
		document.getElementById("instalments_val").value=instal.toFixed(2);
		}
		else
		{
			document.getElementById("instalments").value=document.getElementById("finance_amount").value;
		document.getElementById("instalments_val").value=principle.toFixed(2);
		}
		document.getElementById("totint_val").value=parseFloat(totint).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("new_totint").value=parseFloat(totint);
		document.getElementById("agreed_val").value=(parseFloat(principle)+parseFloat(totint)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	
	
}
function padDigits(number, digits) {
    return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
}
function repayment_shedule()
{	if(document.getElementById('settldate').value!=""){
		 var date1 = new Date(document.getElementById('settldate').value);
	  	 var starttime=date1.getTime();  
		 var html='<h4>Repayment Schedule<span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>';
 html= html+'<table class="table" width="50%" align="center"><tr><th></th><th>Date</th><th>Amount</th></tr>';
		 for(i=1; i<=6; i++)
		 {
			 dpcomplete=parseFloat(starttime)+ parseFloat(i)*1000 * 3600 * 24*30;
			   var date_dvpcompletion=new Date(dpcomplete);
			    var day = date_dvpcompletion.getDate();
 				var monthIndex = date_dvpcompletion.getMonth()+1;
					monthIndex= padDigits(monthIndex,2);
		 		 var year = date_dvpcompletion.getFullYear();
		  			day = padDigits(day,2);
					var nextday=year+'-'+monthIndex+'-'+day;
					html=html+'<tr><td>'+i+'</td><td>'+nextday+'</td><td>'+document.getElementById("instalments").value+'</td></tr>'
	 	 }
	 html=html+'</table>'
	 $('#popupform').delay(1).fadeIn(600);
	//$( "#popupform" ).load( "< ?=base_url().$searchpath?>/"+code );
	 document.getElementById('popupform').innerHTML=html;
	}
	else
	{
		document.getElementById("checkflagmessage").innerHTML='Please Ender the Settlement Date'; 
					 $('#flagchertbtn').click();
	}
	
}

 </script>
 
						<form data-toggle="validator" method="post" action="<?=base_url()?>re/eploan/editdata_reschedule" enctype="multipart/form-data">
                        <input type="hidden" name="rsch_code" id="rsch_code" value="<?=$reschdata->rsch_code?>">
 
						
							
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <? $delaintot=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));
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
                        <th scope="row">Monthly Rental</th><td align="right"> <?=number_format($reschdata->loan_prevrental,2)  ?> &nbsp; </td><th  >Period</th><td align="right"> <?=$reschdata->loan_previnstalments ?></td> <th  >Interest</th><td align="right"><?=$reschdata->loan_previntrate ?></td>
                         </tr> 
                          <tr class="table-bordered"> 
                        <th scope="row">Capital</th><td  align="right"> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  >Total Interest</th><td align="right"><?=number_format($totint,2) ?></td> <th  >Agreed value</th><td align="right"><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr>
                       
                           
                           <tr class="table-bordered"> 
                        <th scope="row">Paid Capital</th><td  align="right"> <?=number_format($totset->totpaidcap,2)  ?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($totset->totpaidint,2) ?></td> <th  >Paid Total</th><td align="right"><?=number_format($totset->totpaidint+$totset->totpaidcap,2)  ?></td>
                         </tr> 
                          <tr class="table-bordered info"> 
                        <th scope="row">Balance Capital</th><td  align="right"> <?=number_format($details->loan_amount-$totset->totpaidcap,2)  ?> &nbsp; </td><th  >Balance Interest</th><td align="right"><?=number_format($totint-$totset->totpaidint,2) ?></td> <th  >Balance Total</th><td align="right"><?=number_format(($totint+$details->loan_amount)-($totset->totpaidint+$totset->totpaidcap),2)  ?></td>
                         </tr> 
                            <? 
							$paidpreentage=($totset->totpaidcap/$details->loan_amount)*100;
							$creditcap=0; $creditint=0;
							$delay=0; $ontime=0; if($paylist){foreach($paylist as $row)
				  {
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create($row->pay_date);
					  $date3=date_create( date("Y-m-d"));

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date3<$date1)
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
							
							$delaintot=get_loan_date_di($details->loan_code,date('Y-m-d'));
							?>
                            <? if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='green'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='green'; else $class='green';?>

                          <tr class="warning"> 
                        <th scope="row">Arrears Rental</th><td> <?=number_format($delayrentaltot,2)  ?> &nbsp; </td><th  align="right">Delay Interest</th><td><?=number_format($delaintot,2) ?></td> <th  align="right">Arrears Instalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                         
                        
                            
                          </tbody></table>  
                          
                   
                         
                           <? $balanc=$details->loan_amount-$totset->totpaidcap-$creditint;
						   $type=$reschdata->new_type;
						   $period=$reschdata->new_period;
						   ?>
                           <? if($totset->totpaidcap) $totpaidcap=$totset->totpaidcap; else $totpaidcap=0.00;
							   if($totset->totpaidint) $totpaidint=$totset->totpaidint-$creditint; else $totpaidint=0.00; ?>
                            	<div class="form-body  form-horizontal" >
                             <input type="hidden" name="new_cap" id="new_cap" value="<?=$balanc?>"  >
                              <input type="hidden" name="loan_paidcap" id="loan_paidcap"value="<?=$totpaidcap?>"  >
                               <input type="hidden"  name="loan_paidint" id="loan_paidint"value="<?=$totpaidint?>" >
                                  <input type="hidden" name="loan_paidcrint" id="loan_paidcrint"value="<?=$creditint?>"  >
                                <input type="hidden" name="loan_stcap" id="loan_stcap"value="<?=$details->loan_amount?>"  >
                               <input type="hidden"  name="loan_stinttot" id="loan_stinttot"value="<?=$totint?>"  >
                               <input type="hidden"  name="loan_previntrate" id="loan_previntrate"value="<?=$details->interest?>"  >
                               <input type="hidden"  name="loan_previnstalments" id="loan_previnstalments"value="<?=$details->instalments?>"  >
                                <input type="hidden"  name="loan_prevrental" id="loan_prevrental"value="<?=$details->montly_rental?>"  >
                               
                               
                               
 <div class="form-group  "><label class="col-sm-3 control-label">Pay Type</label>
										<div class="col-sm-3"><select name="pay_type" id="pay_type" class="form-control" onchange="load_epdata(this.value)" onblur=" instalment_cal()" required >
          <option value="">Select</option>
             <?    foreach($saletype as $row){ if(trim($row->type)!='Outright'){?>
                    <option value="<?=trim($row->type)?>" <? if(trim($row->type)==$type) {?> selected="selected" <? }?>><?=$row->description?></option>
                    <? }}?></select>
                                       </div>
                                         <label class="col-sm-3 control-label" >Finance Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="finance_amount" id="finance_amount"value="<?=number_format($balanc,2)?>"  required readonly="readonly">
										</div>
                                       </div>
                                           <div id="loandetails1" > 
									 <div class="form-group">
                                      
                                      <label class="col-sm-3 control-label" >Interest Rate</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="number" class="form-control" name="interest" id="interest"   onblur=" instalment_cal()"   required value="<?=$reschdata->new_intrate?>"  >
										</div>
                                     
                                     <label class="col-sm-3 control-label">Repayment Period</label>
										<div class="col-sm-3">
                                        <input type="number" step="1" name="period" id="period" class="form-control" value="<?=$period?>" onblur=" instalment_cal()" required="required"/>
                                     
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
									<label class="col-sm-3 control-label">Monthly Instalment</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="instalments"  value="<?=number_format($reschdata->new_rental,2)?>"   name="instalments"     data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Agreement Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"   value="<?=$reschdata->resch_date?>"   name="settldate"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                               <div class="form-group ">
									<label class="col-sm-3 control-label">Total Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="totint_val"  value="<?=number_format($reschdata->new_totint,2)?>"  name="totint_val"     data-error="" readonly="readonly"   required="required" >
                                        <input  type="hidden" class="form-control" id="new_totint"    name="new_totint"  value="<?=$reschdata->new_totint?>"   data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Agreed value</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="agreed_val"  value="<?=number_format($reschdata->new_totint+$reschdata->new_cap,2)?>"  name="agreed_val"    data-error=""  readonly="readonly">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                       <input type="hidden" class="form-control" id="instalments_val"  value="<?=$reschdata->new_rental?>" name="instalments_val"    data-error=""  >
							
											</div>
                                        		
                                               <div class="form-group" style="float:right; margin-right:10px;">
                                           <h3> 	
                                         	</div>
                                             
                                    
                                       <br /><br /><br />
                        
                       
                    </div> 
                    </div>
</div>
</form>