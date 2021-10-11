 <style>
 	.plc-class::placeholder{
    	color: #F33;
	}
 </style>
<script type="text/javascript">
$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
	setTimeout(function(){ 
		var pay_type = $('#pay_type').val();
		load_epdata(pay_type);
		instalment_cal();
		enableInsedit(pay_type);
	}, 1000);
	
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
		if(value=='ZEP' || value=='ZEPC')
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
function change_di_value()
{
	var int_di=parseFloat(document.getElementById("init_di").value);
	var current_di=parseFloat(document.getElementById("di_amount").value);
	if(int_di>=current_di)
	{
		var balance_cap=parseFloat(document.getElementById("bal_cap").value);
		var creditint=parseFloat(document.getElementById("loan_paidcrint").value);
		var financetot=parseFloat(balance_cap)-parseFloat(creditint)+parseFloat(current_di)
		document.getElementById("new_cap").value=financetot;
		document.getElementById("finance_amount").value=financetot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		changePeriod()
		instalment_cal();
		
	}
	else
	{
		document.getElementById("di_amount").value=int_di;
		document.getElementById("checkflagmessage").innerHTML='Delay Interest value couldn increas to '+int_di; 
					 $('#flagchertbtn').click();
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
		//alert(value);
		if(value=='NEP' || value=='ZEP' || value=='ZEPC')
		{
			
		document.getElementById("instalments_val").value=instal.toFixed(2);
		document.getElementById("initial_monthlyrental").value=instal.toFixed(2);
		
		}
		else
		{
			document.getElementById("instalments").value=document.getElementById("finance_amount").value;
		document.getElementById("instalments_val").value=principle.toFixed(2);
		document.getElementById("initial_monthlyrental").value=principle.toFixed(2);
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
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );
			
}
function reset_financeval(val)
{ val=val.replace(/\,/g,'')
		var principle=parseFloat(document.getElementById("new_cap").value);
		document.getElementById("new_cap").value=val;
		document.getElementById("finance_amount").value=val.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
		
}
function changePeriod(){
	$("#lastpay").css("display", "none");
	$('#lastpaynum').html('');
	$("#lastpayment").val(0);
}

function enableInsedit(){
	$("#monthlyinstcustom").html('');
	var val = $('#pay_type').val();
	var total_loan = $('#finance_amount').val().replace(',', '');
	if(val=='ZEP'){
		$("#monthlyinst").css("display", "block");	//show monthly installment field
		$('#instalments').prop("readonly", false);	
		$('#interest').prop("readonly", true);
	}else{
		$("#lastpay").css("display", "none");	
		$('#instalments').prop("readonly", true);
		$('#interest').prop("readonly", false);
	}
	if(val=='ZEPC'){
		$("#monthlyinst").css("display", "none");	//remove monthly installment field
		$("#period").attr({
		   "max" : 12, //in case if something went wrong
		});
		
		//we check period to avoid more than 12 installemnts
		if($('#period').val() > 12){
			alert('Maximum number of instalments is 12.');
			$('#period').val(12);
		}
		var count = $('#period').val();	//no of installments
		var i;
		//add custom text boxes for installments
		if(count){
			for (i = 1; i <= count; i++) {
				//addning new fields for installements and dates	
				
				//we see whether the agreement date is empty. if it's empty we won't allow any fields
				var agreemtndate = $('#settldate').val();
				if(agreemtndate == ""){
			  		$("#monthlyinstcustom").append('<label class="col-sm-2 control-label">Instalment '+i+'</label><div class="col-sm-2 has-feedback"><input type="text" disabled autocomplete="off" class="form-control" id="instdate'+i+'" name="instdate'+i+'" data-error="" required="required" placeholder="Date"><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div><div class="col-sm-2 has-feedback"><input type="number" step="0.01" autocomplete="off" placeholder="Amount" class="form-control" id="instalment'+i+'" disabled name="instalment'+i+'" data-error="" onchange="getLastinst(this.name);" required="required" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div>');
					
					$("#settldate").attr("placeholder", "Please pick agreement date.");
					$('#settldate').addClass('plc-class');
				}else if(i==1){
					
					$("#monthlyinstcustom").append('<label class="col-sm-2 control-label">Instalment '+i+'</label><div class="col-sm-2 has-feedback"><input type="text" autocomplete="off" class="form-control" id="instdate'+i+'" name="instdate'+i+'" data-error="" required="required" onchange="activateNextdate(this.name);" placeholder="Date"><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div><div class="col-sm-2 has-feedback"><input type="number" step="0.01" autocomplete="off" placeholder="Amount" class="form-control" id="instalment'+i+'" name="instalment'+i+'" data-error="" onchange="activateNextamount(this.name);getLastinst(this.name);" required="required" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div>');
				}else{
					
					$("#monthlyinstcustom").append('<label class="col-sm-2 control-label">Instalment '+i+'</label><div class="col-sm-2 has-feedback"><input type="text" autocomplete="off" class="form-control" id="instdate'+i+'" disabled name="instdate'+i+'" data-error="" required="required" onchange="activateNextdate(this.name);"  placeholder="Date"><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div><div class="col-sm-2 has-feedback"><input type="number" step="0.01" disabled autocomplete="off" placeholder="Amount" class="form-control" id="instalment'+i+'" name="instalment'+i+'" data-error="" onchange="activateNextamount(this.name);getLastinst(this.name);" required="required" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div>');
				}
				
				//add date pickers
				$("#instdate"+i ).datepicker({dateFormat: 'yy-mm-dd',
					minDate: agreemtndate,
				setDate :new Date()});
				$("#cheque_date").datepicker('setDate', new Date());
				$("#instdate"+i ).keypress(function(e) {
					e.preventDefault();
				});
			}
		}
	}
}

function getLastinst(val){
	var count = $('#period').val();	//no of installments
	var total_loan = $('#finance_amount').val().replace(',', '');
	var total_loan = total_loan.replace(/\,/g,'');
	if(val == 'instalment'+count){
		var i;
		var value = 0;
		for (i = 1; i <= count; i++) {
			
			if($('#instalment'+i).val()){
				value = value + parseFloat($('#instalment'+i).val());
			}
			
		}
		if(value != total_loan){
			var balance = total_loan - (value - parseFloat($('#instalment'+count).val()));
			
			if(balance > 0){
				alert('Total loan amount incorrect. Last instalment should be '+balance.toFixed(2));
				$('#instalment'+count).val(balance.toFixed(2));
			}else{
				alert('Invalid Amount for Last Instalment '+balance+'. Please re-enter.');
				enableInsedit();
			}
		}
	}
}

function activateNextdate(name){
	var number = parseInt(name.replace ( /[^\d.]/g, '' )); //get the last character
	var next_number = parseFloat(number)+1;
	$('#instdate'+next_number).prop('disabled', false); //enable next date
	//$('#instdate'+next_number).prop('readonly', 'readonly'); 
	$('#instdate'+number).datepicker("destroy"); //remove datepicker to avoid user picking date later
	$('#instdate'+number).prop('readonly', 'readonly');
	//set date restrictions
	var datepick = $('#instdate'+number).val();
	date = new Date(datepick); //get date
	date.setDate(date.getDate() + 1);  //add a day
	var dateEnd = date.getFullYear() + '-' + ("0" + (date.getMonth()+1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2);
	$('#instdate'+next_number).datepicker("destroy");
	$('#instdate'+next_number).datepicker({dateFormat: 'yy-mm-dd',
		minDate: dateEnd,
	});
	$('#instdate'+next_number).datepicker("refresh");
}

function activateNextamount(name){
//	var number = name.substr(name.length - 1); //get the last character
	var number = parseInt(name.replace ( /[^\d.]/g, '' ))
	var next_number = parseFloat(number)+1;
	$('#instalment'+number).prop('readonly', 'readonly');
	$('#instalment'+next_number).prop('disabled', false); //enable next instalment
}

function checkLastinstallment(val){
		val = val.replace(/\,/g,'')
	
	var installment = val;
	var total_loan = $('#finance_amount').val().replace(',', '');
	var total_loan =document.getElementById("new_cap").value;
	//a.replace(/\,/g,'') //remove thousand seperators in finance amount
	var inst_amount = parseFloat($('#instalments_val').val());
	var installments = $('#period').val();
	var inst_amount=parseFloat(document.getElementById("initial_monthlyrental").value);
	//alert(inst_amount)
	if(installment > inst_amount){ //we won't allow higher installement value than the current
		alert('Installment value cannot be greater than '+ inst_amount.toFixed(2));
		$('#instalments').val(inst_amount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		$("#lastpay").css("display", "none");
			$('#lastpaynum').html('');
			$("#lastpayment").val(0);
	}
	else{
		if((inst_amount-installment) > 0.50){ //check whether the user added different amount , I used .50 because of cents rounding issue. .33, .34 etc
			
			
			var inst_total = parseFloat(installment)*(parseFloat(installments)-1); 
			
			var remaining = parseFloat(total_loan) - parseFloat(inst_total);
			$('#instalments_val').val(installment);
		//	alert(remaining)
			$("#lastpay").css("display", "block");
			$('#lastpaynum').html(ordinal_suffix_of(installments));
			$("#lastpayment").val(formatNumber(remaining.toFixed(2)));
		}else{
			$("#lastpay").css("display", "none");
			$('#lastpaynum').html('');
			$("#lastpayment").val(0);
		}
	}
}

function ordinal_suffix_of(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
}
function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
 </script>
 
						
                    
							
 <div class="form-title">
								<h4>Loan Details <span style="float:right; margin-top:-1px;">  <a href="javascript:get_loan_detalis('<?=$details->loan_code?>')"><span class="label label-success">Loan Inquiry</span></a></span></h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                   <?
				  if($details->loan_type!='EPB'){
				  
				   $delaintot=0;$thisdelayint=0;$arreascap=0; $arreasint=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
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
					$dalay_int=($thisdelayint+floatval($details->montly_rental-$paidtotals))*floatval($details->delay_interest)/(100);
						$thisdelayint=$thisdelayint+$dalay_int;
						$currentdi=round($dalay_int,2)-$raw->balance_di;
						 if($currentdi<0)
					  $currentdi=0;
					   $delaintot=$delaintot+$currentdi;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					
					}
						
				  }}}else {?>
					  
				  <?
 $futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=date('Y-m-d');
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
					  $date1=date_create($loanstart_date);
					  $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;
					$inttot=0;
					$dates=$diff->format("%m ");
					$thismonthint=0;
					$dates=$dates+1;
					if($dates>=1)
					{
					for($i=1; $i<=$dates; $i++)
					{
						
						$thismonthint=0;
						$prvdate=$futureDate;
						$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						
						if($i>$details->period)
						$thismonthint=round(($current_cap*$typedata->default_int)/(12*100),2);
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$balance=$current_cap+$thismonthint - $this_payment;
						$arrayintlist[$i]['date']=$prvdate;
						$arrayintlist[$i]['int']=$thismonthint;
						$arrayintlist[$i]['payment']=$this_payment;
						$arrayintlist[$i]['balance']=$balance;
						?>
                        <?
						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
						
					}
					
					}
					else
					{
						$prvdate=$current_date;
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$current_cap=$current_cap-$this_payment;
					}
					$lastint=0; 
					if($end_date < $current_date)
					{
						//echo $current_date;
					 $date1=date_create($futureDate);
					 $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
				
					$dates=$diff->format("%a ");
					$lastint=round(($current_cap*$dates*$typedata->default_int)/(12*100*360),2);
					}
					$uptodateint=$thismonthint+$lastint;
					$inttot=$inttot+$lastint;
					$last_bal=$current_cap+$lastint;
					$totint=$inttot;
					$totalout=$last_bal;
					 $delaintot=$inttot*$typedata->delay_int/100;
					 $arieasins=0;
 $delayrentaltot=$totint-$totset->totpaidint;
 ?>  
					  
				<?  }?>
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
                        <th scope="row">Capital</th><td  align="right"> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  >Total Interest</th><td align="right"><?=number_format($totint,2) ?></td> <th>Agreed value</th><td align="right"><?=number_format($totint+$details->loan_amount,2)  ?></td>
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
  					$futureDate=date('Y-m-d',strtotime('+1 months',strtotime(date("Y-m-d"))));
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
					}}$delaintot=get_loan_date_di($details->loan_code,date('Y-m-d'));
					
							$totpay=$ontime+$delay;
							if($totpay>0)
							$payeve=($ontime/$totpay)*100;
							else $payeve=0;
							?>
                            <? if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='green'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='green'; else $class='green';?>

                          <tr class="warning"> 
                        <th scope="row">Arrears Rental</th><td> <?=number_format($delayrentaltot,2)  ?> &nbsp; </td><th  align="right">Delay Interest</th><td><?=number_format($delaintot,2) ?></td> <th  align="right">Arrears Instalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                         
                           <tr class="success"> 
                   <th  >Credit Capital</th><td align="right"><?=number_format($creditcap,2) ?></td>    <th >Credit Interest</th><td align="right"><?=number_format($creditint,2) ?></td>  <th scope="row">Credit Balance</th><td align="right"> <?=number_format($creditcap+$creditint,2)  ?> &nbsp; </td>
                         </tr> 
                          <tr class="table-bordered danger"> 
                        <th scope="row">Delay Interest  Payments</th><td  align="right"> <?=number_format($totset->totpaiddi,2)  ?> &nbsp; </td><td colspan="4"></td>
                         </tr> 
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>  
                         
                           <? $balanc=$details->loan_amount-$totset->totpaidcap;//+$arreasint;
						   $financeamount=$details->loan_amount-$totset->totpaidcap-$creditint+$delaintot;
						   $type=$details->loan_type;
						   //loan_paidcrint
						   ?>
                            	<div class="form-body  form-horizontal" >
                               <? if($totset->totpaidcap) $totpaidcap=$totset->totpaidcap; else $totpaidcap=0.00;
							   if($totset->totpaidint) $totpaidint=$totset->totpaidint-$creditint; else $totpaidint=0.00; ?>
                                  <input type="hidden" name="init_di" id="init_di" value="<?=$delaintot?>"  >
                                    <input type="hidden" name="bal_cap" id="bal_cap" value="<?=$balanc?>"  >
                             <input type="hidden" name="new_cap" id="new_cap" value="<?=$financeamount?>"  >
                              <input type="hidden" name="loan_paidcap" id="loan_paidcap"value="<?=$totpaidcap?>"  >
                               <input type="hidden" name="loan_paidcrint" id="loan_paidcrint"value="<?=$creditint?>"  >
                               <input type="hidden"  name="loan_paidint" id="loan_paidint"value="<?=$totpaidint?>" >
                               <input type="hidden" name="loan_stcap" id="loan_stcap"value="<?=$details->loan_amount?>"  >
                               <input type="hidden"  name="loan_stinttot" id="loan_stinttot"value="<?=$totint?>"  >
                               <input type="hidden"  name="loan_previntrate" id="loan_previntrate"value="<?=$details->interest?>"  >
                               <input type="hidden"  name="loan_previnstalments" id="loan_previnstalments"value="<?=$details->instalments?>"  >
                                <input type="hidden"  name="loan_prevrental" id="loan_prevrental"value="<?=$details->montly_rental?>"  >
                               
                                       <input type="hidden" name="initial_monthlyrental" id="initial_monthlyrental" value=""  >
                           
                               
 <div class="form-group  "><label class="col-sm-3 control-label">Pay Type</label>
										<div class="col-sm-3">
                                        	<select name="pay_type" id="pay_type" class="form-control" onchange="load_epdata(this.value); enableInsedit(this.value); instalment_cal(); "  required >
          										<option value="">Select</option>
             									<?    foreach($saletype as $row){ if(trim($row->type)!='Outright'){?>
                    								<option value="<?=trim($row->type)?>" <? if(trim($row->type)==$type) {?> selected="selected" <? }?>><?=$row->description?></option>
                    							<? }}?>
                                                <?   if( check_access('Zero_Interest_Custom')){?>
                                                    <option value="ZEPC">Zero Interest Easy Payment - Custom</option>
                                                <? }?>
                                       		</select>
                                       </div>
                                         <label class="col-sm-3 control-label" >Balance Capital</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="balace_capital" id="balace_capital"value="<?=number_format($balanc,2)?>"  required  <?  if( !check_access('change_finance_amount')){?> readonly="readonly"<? }?> onchange="reset_financeval(this.value)">
										</div>
                                       </div>
                                        <div class="form-group  "> <label class="col-sm-3 control-label">Di Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input <? if(!check_access('Reschedule DI Change')){?> readonly="readonly"<? }?>  type="number"  onchange="change_di_value()" step="0.01"class="form-control" id="di_amount"    name="di_amount"    data-error="" value="<?=$delaintot?>"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                         <label class="col-sm-3 control-label" >Finance Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="finance_amount" id="finance_amount"value="<?=number_format($financeamount,2)?>"  required  <? if(!check_access('change_finance_amount')){?> readonly="readonly"<? }?> onchange="reset_financeval(this.value)">
										</div>
                                       </div>
                                           <div id="loandetails1" > 
									 <div class="form-group">
                                      
                                      <label class="col-sm-3 control-label" >Interest Rate</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="number" class="form-control" name="interest" id="interest"  onblur=" instalment_cal()"   required value="0"  >
										</div>
                                     
                                     <label class="col-sm-3 control-label">Repayment Period</label>
										<div class="col-sm-3"><input type="number" step="1" name="period" id="period" class="form-control" onchange="changePeriod();enableInsedit();" onblur=" instalment_cal()" required="required"/>
                                     
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
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="instalments"    name="instalments"     data-error="" readonly="readonly" onchange="checkLastinstallment(this.value);"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Agreement Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"  onchange="enableInsedit();"  name="settldate"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                               <div class="form-group ">
									<label class="col-sm-3 control-label">Total Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="totint_val"    name="totint_val"     data-error="" readonly="readonly"   required="required" >
                                        <input  type="hidden" class="form-control" id="new_totint"    name="new_totint"     data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Agreed value</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="agreed_val"    name="agreed_val"    data-error=""  readonly="readonly">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                       <input type="hidden" class="form-control" id="instalments_val"  value="0.00" name="instalments_val"    data-error=""  >
							
											</div>
                                            <div class="form-group" id="lastpay" style="display:none;">
											<label class="col-sm-3 control-label"><span id="lastpaynum"></span> Instalment</label>
											<div class="col-sm-3 has-feedback"><input  type="text" class="form-control" id="lastpayment"    name="lastpayment"  data-error="" readonly="readonly" >
											<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
											<span class="help-block with-errors" ></span></div>
                                        	
										</div>
                                        <div class="clearfix"> </div>
                                        <span id="monthlyinstcustom"></span>
                                        		
                                               <div class="form-group" style="float:right; margin:10px" >
                                               
                                          
                                           
												<button type="submit" class="btn btn-primary disabled" onClick="check_befor_submit()">Update</button></h3>
											</div>
                                             
                                    
                                       <br /><br /><br />
                        
                       
                    </div> 
                    