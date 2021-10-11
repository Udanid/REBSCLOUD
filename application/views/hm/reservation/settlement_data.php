 <style>
 	.plc-class::placeholder{
    	color: #F33;
	}
 </style>
 <script type="text/javascript">
$( function() {
	
	setTimeout(function(){ 
		var pay_type = $('#pay_type').val();
		load_epdata(pay_type);
		instalment_cal();
		enableInsedit(pay_type);
	}, 1000);
	
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
function instalment_cal()
{
	//alert('ssss')
	var principle=parseFloat(<?=$resdata->discounted_price-$resdata->down_payment?>);
	var n=parseFloat(document.getElementById("period").value);
	
	var int=parseFloat(document.getElementById("interest").value)
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
	}
	else
	{
		var instal=parseFloat(principle)/ parseFloat(n);
	}
	
	document.getElementById("instalments").value=instal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		value=document.getElementById("pay_type").value;
		if(value=='NEP' || value=='ZEP')
		{
			
		document.getElementById("instalments_val").value=instal;
		document.getElementById("initial_monthlyrental").value=instal.toFixed(2);
		}
		else
		{
			document.getElementById("instalments").value=document.getElementById("finance_amount").value;
		document.getElementById("instalments_val").value=principle;
		document.getElementById("initial_monthlyrental").value=principle.toFixed(2);
		}
		
	
	
	
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
				alert('Total loan amount incorrect. Last instalment should be '+balance);
				$('#instalment'+count).val(balance);
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
	//var number = name.substr(name.length - 1); //get the last character
	var number = parseInt(name.replace ( /[^\d.]/g, '' ))
	var next_number = parseFloat(number)+1;
	$('#instalment'+number).prop('readonly', 'readonly');
	$('#instalment'+next_number).prop('disabled', false); //enable next instalment
}

function checkLastinstallment(val){
		val = val.replace(/\,/g,'');
	
	var installment = val;
	var total_loan = $('#finance_amount').val().replace(',', '');
	var total_loan =total_loan.replace(/\,/g,'');
	//a.replace(/\,/g,'') //remove thousand seperators in finance amount
	var inst_amount = parseFloat($('#instalments_val').val());
	var installments = $('#period').val();
	var inst_amount=parseFloat(document.getElementById("initial_monthlyrental").value);
	
	if(installment > inst_amount){ //we won't allow higher installement value than the current
		alert('Installment value cannot be greater than '+ inst_amount.toFixed(2));
		$('#instalments').val(inst_amount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
		$("#lastpay").css("display", "none");
			$('#lastpaynum').html('');
			$("#lastpayment").val(0);
	}
	else
	{
		if((inst_amount - installment) > 0	){ //check whether the user added different amount , I used .50 because of cents rounding issue. .33, .34 etc
			
			var inst_total = parseFloat(installment)*(parseFloat(installments)-1); 
			
			var remaining = parseFloat(total_loan) - parseFloat(inst_total);
			$('#instalments_val').val(installment);
			
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
								<h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                </h4>
							</div>
							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label">Block Value</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="min_down"  value="<?=number_format($resdata->discounted_price,2) ?>" name="min_down"  readonly="readonly" required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Down Payment</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="down_payment"  name="down_payment"  data-error=""   readonly="readonly" value="<?=number_format($resdata->down_payment) ?>" required>
										</div></div>
                                        <?  $ispending="";
										if($saledata){
										 foreach($saledata as $row){
											  if($row->status=='PENDING')
											  $ispending='true';
										 }}
									if($ispending=="true"){
								//	echo 'Please Receipting  all Advance Payment befor make the settlement';
									?>
                              		         <div class="alert alert-danger" role="alert">
											Please Receipting  all Advance Payment befor make the settlement
											</div>
                                    <?
									}
									$condition='true';
									if($resdata->min_down<=$resdata->down_payment)
									$condition='true';
									else
									{
										?>
                              		         <div class="alert alert-danger" role="alert">
											Not Complete Minimum Down Payment
											</div>
                                    <?
									}
									if(check_access('settlement_withoutfulldown'))
									$condition='true';
									
									if($condition=="false"){
								//	echo 'Please Receipting  all Advance Payment befor make the settlement';
									
									}
										if($condition=='true' && $ispending!="true"){
											$balanc=$resdata->discounted_price-$resdata->down_payment;
											$balrate=($resdata->down_payment/$resdata->discounted_price)*100;
											$type="";
											if($balrate>=60)
											$type='ZEP';
											if($balanc==0)
											$type='Outright';
											$type=$resdata->pay_type;
											?>
                                             <div class="form-group  "><label class="col-sm-3 control-label">Pay Type</label>
										<div class="col-sm-3"><select name="pay_type" id="pay_type" class="form-control" onchange="load_epdata(this.value); enableInsedit(this.value); instalment_cal();" required >
          <option value="">Select</option>
              <?   if($balanc=='0'){  foreach($saletype as $row){
				 if($row->type=='Outright'){?>
				 
					
                       <option value="<?=trim($row->type)?>" <? if(trim($row->type)==$type) {?> selected="selected" <? }?>><?=$row->description?></option>

                   <?
				 }}}else
				 	foreach($saletype as $row){
						{if($row->type!='Outright'){
				 	?>
                    <option value="<?=trim($row->type)?>" <? if(trim($row->type)==$type) {?> selected="selected" <? }?>><?=$row->description?></option>
                    <? }}}?>
                    <? if( check_access('Zero_Interest_Custom')) {?>
                    	<option value="ZEPC">Zero Interest Easy Payment - Custom</option>
                    <? }?>
                    </select>
                                       </div>
                                         <label class="col-sm-3 control-label" >Finance Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="finance_amount" id="finance_amount"value="<?=number_format($balanc,2)?>"  required readonly="readonly">
										</div>
                                       </div>
                                           <div id="loandetails1" <? if($type!='ZEP'){?> style="display:none"<? }?>> 
									 <div class="form-group">
                                      
                                      <label class="col-sm-3 control-label" >Interest Rate (Annual)</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="number"  step="0.0001"class="form-control" name="interest" id="interest"  onblur=" instalment_cal()"   required value="0"  >
										</div>
                                     
                                     <label class="col-sm-3 control-label">Repayment Period (Months)</label>
										<div class="col-sm-3"><input type="number" step="1" name="period" id="period" onchange="changePeriod();enableInsedit();" class="form-control" onblur=" instalment_cal()" required="required"/>
                                     
                                       </div></div>
                                        
                                      </div>
                                         <div class="form-group">
                                         	<label class="col-sm-3 control-label">Sales Officer</label>
			    							<div class="col-sm-3">
                                            	<select name="collection_officer" id="collection_officer" class="form-control" placeholder="Sales Officer" >
                                    				<option value="">Collection officer</option>
                                     				<? foreach ($loan_officer as $raw){?>
                    									<option value="<?=$raw->user_id?>" ><?=$raw->initial?> &nbsp; <?=$raw->surname?></option>
                    								<? }?>
        
                                    			</select>
  											</div>
                                            <label class="col-sm-3 control-label">Agreement Date</label>
											<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate" autocomplete="off" onchange="enableInsedit();"  name="settldate"    data-error="" required="required" >
											<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
											<span class="help-block with-errors" ></span></div>
                                      </div>
                                     	<div class="form-group ">
                                        
                                        	<span id="monthlyinst">
                                                <label class="col-sm-3 control-label">Monthly Instalment</label>
                                                <div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="instalments"    name="instalments"  data-error="" readonly="readonly" onchange="checkLastinstallment(this.value);"  required="required" >
                                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                                <span class="help-block with-errors" ></span></div>
                                            </span>
                                            
                                        	
                                       		<input type="hidden" class="form-control" id="instalments_val"  value="" name="instalments_val"    data-error=""  >
										</div>
                                        <div class="form-group" id="lastpay" style="display:none;">
											<label class="col-sm-3 control-label"><span id="lastpaynum"></span> Instalment</label>
											<div class="col-sm-3 has-feedback"><input  type="text" class="form-control" id="lastpayment"    name="lastpayment"  data-error="" readonly="readonly" >
											<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
											<span class="help-block with-errors" ></span></div>
                                        	
										</div>
                                     </div>
                                      <div class="clearfix"> </div>
                                     <span id="monthlyinstcustom"></span>
                                           <input type="hidden" name="initial_monthlyrental" id="initial_monthlyrental" value=""  >
                           
                                        <div class="form-group"  style="float:right">
                                             
                                         <div class="col-sm-3 has-feedback" id="paymentdateid">  <h3>
												<button type="submit" class="btn btn-primary disabled" onClick="check_befor_submit()">Update</button></h3>
											</div>
                                             </div>
                                      <? }?>
                                       
                                       
                                        <div class="clearfix"> </div>
								
							</div>
                            