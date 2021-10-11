
<script type="text/javascript">
jQuery(document).ready(function() {

 $("#bank1").focus(function() {
	$("#bank1").chosen({
     allow_single_deselect : true
    });
		});
	$("#pay_type").chosen({
     allow_single_deselect : true
    });
	$("#pay_method").chosen({
     allow_single_deselect : true
    });
  $("#sales_person").chosen({
      allow_single_deselect : true
    });


});
$( function() {
    $( "#dp_cmpldate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
   $( function() {
    $( "#res_date" ).datepicker({dateFormat: 'yy-mm-dd',minDate: '<?=$this->session->userdata("current_start")?>',
			maxDate: '<?=$this->session->userdata("current_end")?>'});

  } );
  $( function() {
    $( "#dp_fulcmpdate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );

function loadbranchlist(itemcode,caller)
{
var code=itemcode.split("-")[0];
//alert(code)
if(code!=''){
	//
	//$('#popupform').delay(1).fadeIn(600);
	$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

}
function callbankdata(id)
{
	// alert(id)
	if(id=='CSH')
	{
		 $('#bankdetails').delay(1).fadeOut(600);
	}
	else
	$('#bankdetails').delay(1).fadeIn(600);
}
function calculate_discunted()
{
	$('#discount_figure').html('');
	$('#discount_figure').hide(100);

//alert(document.getElementById("totprice").value)
var newdiscount=parseFloat(document.getElementById("discount").value)
	if(newdiscount > 100){
		discounted=parseFloat(document.getElementById("totprice").value)-parseFloat(newdiscount);
		var discount_precentage = parseFloat(newdiscount)/parseFloat(document.getElementById("totprice").value)*100;
		$('#discount_figure').show(100);
		$('#discount_figure').html('Discount Percentage: ');
		$('#discount_figure').append(discount_precentage.toFixed(2));
		$('#discount_figure').append(' %');
	}else
	{

	var totldis=parseFloat(document.getElementById("totprice").value)*parseFloat(newdiscount)/100;
	discounted=parseFloat(document.getElementById("totprice").value)-parseFloat(totldis);
		if(newdiscount > 0){
			$('#discount_figure').show(100);
			$('#discount_figure').html('Discount Amount: ');
			$('#discount_figure').append(totldis.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		}
	}
	document.getElementById("discounted_price").value=discounted.toFixed(2);
	var mindown = discounted*parseFloat(document.getElementById("dp_level").value)/100;
	document.getElementById("min_down").value=mindown.toFixed(2);
	//document.getElementById("down_payment").value=discounted*parseFloat(<?=$mindp?>)/100;


}
function calculate_payamount()
{
//alert(document.getElementById("down_payment").value);
//var vatvalue= 0;//parseFloat(document.getElementById("down_payment").value)*parseFloat(document.getElementById("vat").value)/100
//	var totlpayamount=parseFloat(document.getElementById("document_fee").value)+parseFloat(document.getElementById("legal_fee").value)+parseFloat(document.getElementById("plan_charge").value)+parseFloat(document.getElementById("down_payment").value)+parseFloat(vatvalue);
/* document fees and other charges pay from other charges*/
document.getElementById("pay_amount").value=parseFloat(document.getElementById("down_payment").value.replace(/,(?=\d{3})/g, ''));


}
function check_befor_submit()
{

	if(document.getElementById("cus_code").value=="")
	{
				 document.getElementById("checkflagmessage").innerHTML='You Should enter the customer code'
					 $('#flagchertbtn').click();
					 document.getElementById("down_payment").value="";
	}

}
function load_epdata(value)
{
	if(value=='NEP' || value=='ZEP')
	{
		 $('#loandetails').delay(1).fadeIn(600);
	}
	else
	$('#loandetails').delay(1).fadeOut(600);
}
function instalment_cal()
{
	//alert('ssss')
	var int=parseFloat(document.getElementById("interest").value)/100;
	var principle=parseFloat(document.getElementById("discounted_price").value)-parseFloat(document.getElementById("down_payment").value);
	var n=parseFloat(document.getElementById("period").value);
	var i=parseFloat(int)/12;
	var div=((Math.pow(1 + parseFloat(i), parseFloat(n)) - 1));
	var multi=Math.pow(1 + parseFloat(i), parseFloat(n));
	//alert(div);
	//alert(parseFloat(principle));
	var instal=(parseFloat(principle) * parseFloat(i) * parseFloat(multi)) / parseFloat(div);
	document.getElementById("instalments").value=instal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	if(document.getElementById("pay_type").value!='Outright')
	{
		value=document.getElementById("pay_type").value;
		if(value=='NEP' || value=='ZEP')
		{
		document.getElementById("instalments_val").value=instal;
		}
		else
		document.getElementById("instalments_val").value=principle;

	}


}
function change_totselprice(ele)
{
	var perchrice=parseFloat(document.getElementById("price_perch").value)*parseFloat(document.getElementById("extend_perch").value);
	var housing_sale=parseFloat(document.getElementById("hm_seling_price").value);
	var totsale=parseFloat(perchrice)+parseFloat(housing_sale)
	document.getElementById("totprice").value=totsale;
	document.getElementById("discounted_price").value=totsale.toFixed(2);
	document.getElementById("extend_perch1").value=totsale.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	ele.focus();
	ele.blur();
	
}

function updateDates(date){

	var dp_cmpldate = '<?=get_rate("DP complete Period")?>';
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'re/reservation/get_updated_date/';?>',
		data: {date: date, days: dp_cmpldate },
		success: function(data) {
			if (data) {
				$('#dp_cmpldate').val('');
				$('#dp_cmpldate').val(data.trim());
			}

		}
	});

	var dp_fulcmpdate = '<?=get_rate("Completion Period")?>';
	$.ajax({
		cache: false,
		type: 'POST',
		url: '<?php echo base_url().'re/reservation/get_updated_date/';?>',
		data: {date: date, days: dp_fulcmpdate },
		success: function(data) {
			if (data) {
				$('#dp_fulcmpdate').val('');
				$('#dp_fulcmpdate').val(data.trim());
			}

		}
	});


	$('#instdate1').datepicker("destroy");
	$("#instdate1" ).datepicker({dateFormat: 'yy-mm-dd',
					minDate: date,
				setDate :new Date()});

}
</script>

<div class="row">
	<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
		<div class="form-title">
		<h4>Block Price Details</h4>
		</div>
		<div class="form-body">
			<div class="form-group col-md-6"><label>Land Extent</label>
			 <input   type="text" class="form-control" name="extend_perch" id="extend_perch" value="<?=$lotdetail->extend_perch?>" readonly>
             <input type="hidden" name="lot_type"  id="lot_type" value="<?=$lotdetail->lot_type?>" />
			</div>
			<div class="form-group col-md-6"><label>Perch Price</label>
			<input type="text" min="<?=$lotdetail->price_perch?>" class="form-control number-separator" required name="price_perch" id="price_perch" value="<?=$lotdetail->price_perch?>"  onblur="change_totselprice(this)">
			  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
            </div>
             <div class="clearfix"> </div>
             <div class="form-group col-md-6"><label>House Selling Price</label>
			 <input   type="text"  min="<?=$lotdetail->housing_sale?>" class="form-control number-separator" name="hm_seling_price" id="hm_seling_price" value="<?=$lotdetail->housing_sale ?>"  onblur="change_totselprice(this)" <? if($lotdetail->lot_type=='R'){?> readonly="readonly" <? } else{?> required <? }?>>
			</div>
               <input   type="hidden" class="form-control" name="latax" id="latax" value="<?=$lotdetail->latax ?>" readonly>
			<div class="form-group col-md-6"><label>VAT</label>
			<input type="text" class="form-control" name="vat" id="vat" value="<?=get_rate('VAT')?>" readonly>
			</div>
             <div class="clearfix"> </div>
             <div class="form-group col-md-6"><label>Other Tax</label>
			 <input   type="text" class="form-control" name="othertax" id="othertax" value="<?=$lotdetail->othertax?>" readonly>
			</div>
            <?
            $totsel=floatval($lotdetail->extend_perch)*floatval($lotdetail->price_perch);
		//	echo $totsel;
			 $totsel= $totsel+floatval($lotdetail->housing_sale)+floatval($lotdetail->latax)+floatval($lotdetail->vat);
			?><input type="hidden" name="totprice"  id="totprice"  value="<?=$totsel?>" >
             <div class="form-group col-md-6"><label>Total Selling Price</label>
			 <input   type="text" class="form-control" name="extend_perch1" id="extend_perch1" value="<?=number_format($totsel,2)?>" readonly>
			</div>
			 <div class="clearfix"> </div>
          </div>
          <br>
          <div class="form-title">
		<h4>Advance Schedule</h4>
		</div>
		<div class="form-body">
			<table>
				<tr>
					<td><label>Repayment Period (Months)</label></td>
					<td><input type="number" step="1" name="r_period" id="r_period" onchange="enableInsedit();" class="form-control" onblur=" instalment_cal()" required="required"/></td>
				</tr>
			</table>
				 <div id="monthlyinstcustom"></div>
			
			
  				
         	
         	

		</div>


	</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h4>Payment Details</h4>
								</div>
								<div class="form-body">


                                    <div class="form-group has-feedback col-md-6"><label>Purchase Mode</label>
                                     <input type="hidden" class="form-control" name="instalments_val" id="instalments_val" value="0"  required readonly="readonly">

			<select name="pay_type" id="pay_type" class="form-control" required >
            <option value="Pending">Pending</option>
             <?    foreach($saletype as $row){ if($row->type!='Outright'){?>
                    <option value="<?=$row->type?>"><?=$row->description?></option>
                 <? }}?></select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Discount</label>
			<input type="text" class="form-control number-separator" name="discount" id="discount"  required   onblur="calculate_discunted()">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
                                        <span id="discount_figure" style="border:1px solid #36C; display:none; background:#EDF5FC; padding:5px 10px;"></span>
			</div>
      <div class="form-group has-feedback col-md-12"><label>Discount Reason</label>
<textarea class="form-control" name="discount_reason" id="discount_reason"></textarea>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
             <span class="help-block with-errors"></span>
</div>
             <div class="clearfix"> </div>
            <div class="form-group has-feedback col-md-6"><label>DP level</label>
            <select name="dp_level" id="dp_level" class="form-control" required onChange="calculate_discunted()">
              <?    foreach($dplevel as $row){?>
                    <option value="<?=$row->dp_rate?>"<? if($row->dp_rate==$mindp){?> selected="selected"<? }?>><?=$row->dp_rate?></option>
                    <? }?></select>
			<input  type="hidden" class="form-control" name="interest" id="interest"  required value="0"  >
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span></div>
               <div class="form-group has-feedback col-md-6"><label>Non Refundable Amount</label>
			<input type="text" class="form-control number-separator" name="non_refund" id="non_refund"  required  value="<?=get_rate('None Refundable')?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
             <div id="loandetails" style="display:none">
               <div class="form-group has-feedback col-md-6"><label>Repayment Period</label>
			<select name="period" id="period" class="form-control">
                    	<option value="12">12</option>
                    	 <option value="24">24</option>
                     	 <option value="36">36</option>
                         <option value="48">48</option>
                          <option value="60">60</option>
                   </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Monthly Instalment</label>
			<input type="text" class="form-control" name="instalments" id="instalments" value="0"  required readonly="readonly">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
            </div>
             <div class="clearfix"> </div>
             <div class="form-group has-feedback col-md-6"><label>Discounted Price</label>
			 <input   type="text" class="form-control" name="discounted_price" id="discounted_price" value="<?=$totsel?>" required  readonly="readonly">
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>

			<div class="form-group has-feedback col-md-6"><label>Minimum Down Payment</label>
			<input type="text" class="form-control" name="min_down" id="min_down" value=""  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
             <div class="form-group has-feedback col-md-6"><label>Current Payment</label>
			 <input   type="text" class="form-control number-separator" name="down_payment" id="down_payment" onChange="calculate_payamount(),instalment_cal()" required>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Total Pay  Amount</label>
			<input type="text" class="form-control" name="pay_amount" id="pay_amount"  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
              <div class="form-group has-feedback col-md-6"><label>Sales Officer</label>
			    <select name="sales_person" id="sales_person" class="form-control" placeholder="Sales Officer" >
                                    <option value="">Sales officer</option>
                                     <? foreach ($loan_officer as $raw){?>
                    <option value="<?=$raw->id?>" ><?=$raw->emp_no?> - <?=$raw->initials_full?> - <?=$raw->display_name?></option><!-- Ticket No.2502 || Added by Uvini -->
                    <? }?>

                                    </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div><? $futureDate=date('Y-m-d',strtotime('+'.get_rate("DP complete Period").' days',strtotime(date('Y-m-d'))));?>
            <div class="form-group has-feedback col-md-6"><label>Reservation Date</label>
			    <input type="text" name="res_date" id="res_date" readonly="readonly" value="<?=date('Y-m-d')?>" onchange="updateDates(this.value);" class="form-control" required="required" />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="form-group has-feedback col-md-6"><label><?=get_rate("Profit Transfer Rate")?>% Completion Date</label>
			    <input type="text" name="dp_cmpldate" id="dp_cmpldate" value="<?=$futureDate?>" class="form-control" required="required" />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
      <? $futureDate=date('Y-m-d',strtotime('+'.get_rate("Completion Period").' days',strtotime(date('Y-m-d'))));?>
             <div class="form-group has-feedback col-md-6"><label>Full Payment Completion Date</label>
			    <input type="text" name="dp_fulcmpdate" id="dp_fulcmpdate" value="<?=$futureDate?>" class="form-control" required="required" />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
              <div id="bankdetails" style="display:none">
              <div class="form-group has-feedback col-md-6"><label>Payment Method</label>
				<select name="pay_method" id="pay_method" class="form-control" onChange="callbankdata(this.value)">
                    	<option value="CSH">Cash</option>
                    	 <option value="CHQ">Cheque</option>
                     	 <option value="SLIP">Direct Deposit</option>
                   </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>

			<div class="form-group has-feedback col-md-6"><label>Cheque/Slip Number</label>
			<input type="text" class="form-control" name="cheque_no" id="cheque_no"  required >
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
              <div class="form-group has-feedback col-md-6"><label>Bank</label>
			    <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>" ><?=$raw->BANKNAME?></option>
                    <? }?>

                                    </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Branch</label><div  id="branch-1">
			 <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
                                    <option value="">Banch</option>


                                    </select></div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>


				</div>
                 				<div class="bottom ">

											<div class="form-group">
												<button type="submit" id="submit" class="btn btn-primary">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>

								</div>

							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>
<script>
/*Ticket No 2889 Added By Madushan 2021.06.14*/
function activateNextdate(name){
	var number = parseInt(name.replace ( /[^\d.]/g, '' )); //get the last character
	var next_number = parseFloat(number)+1;
	$('#instdate'+next_number).prop('disabled', false); //enable next date
	//$('#instdate'+next_number).prop('readonly', 'readonly'); 
	$('#instdate'+number).datepicker("destroy"); //remove datepicker to avoid user picking date later
	$('#instdate'+number).prop('readonly', 'readonly');
	//set date restrictions

	//Remove res date 
	if(number == 1)
	{
		$('#res_date').datepicker("destroy");
	}

	
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

function getLastinst(val){
	var count = $('#r_period').val();	//no of installments
	//var total_loan = $('#finance_amount').val().replace(',', '');
	var total_loan = $('#min_down').val();
	//var payamount = $('#pay_amount').val();

	// alert(mindown);

	//var total_loan = mindown - payamount;
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
				alert('Total down payment amount incorrect. Last instalment should be '+balance);
				$('#instalment'+count).val(balance);
			}else{
				alert('Invalid Amount for Last Instalment '+balance+'. Please re-enter.');
				enableInsedit();
			}
		}
	}
}

function enableInsedit(){
	$("#monthlyinstcustom").html('');
		
		//we check period to avoid more than 12 installemnts
		if($('#r_period').val() > 36){
			alert('Maximum number of instalments is 12.');
			$('#r_period').val(36);
		}
		var count = $('#r_period').val();	//no of installments
		var i;
		//add custom text boxes for installments
		if(count){
			for (i = 1; i <= count; i++) {
				//addning new fields for installements and dates	
				
				//we see whether the agreement date is empty. if it's empty we won't allow any fields
				var date = new Date();
				var agreemtndate = $('#res_date').val();

				if(agreemtndate == ""){
			  		$("#monthlyinstcustom").append('<label class="col-sm-2 control-label">Instalment '+i+'</label><div class="col-sm-2 has-feedback"><input type="text" disabled autocomplete="off" class="form-control" id="instdate'+i+'" name="instdate'+i+'" data-error="" required="required" placeholder="Date"><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div><div class="col-sm-2 has-feedback"><input type="number" step="0.01" autocomplete="off" placeholder="Amount" class="form-control" id="instalment'+i+'" disabled name="instalment'+i+'" data-error="" onchange="getLastinst(this.name);" required="required" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span><span class="help-block with-errors" ></span></div>');
					
					$("#settldate").attr("placeholder", "Please pick agreement date.");
					$('#settldate').addClass('plc-class');
				}else if(i==1){
					
					$("#monthlyinstcustom").append('<tr><td><label>Instalment '+i+'</label></td><td><input type="text" autocomplete="off" class="form-control" id="instdate'+i+'" name="instdate'+i+'" data-error="" required="required" onchange="activateNextdate(this.name);" placeholder="Date"></td><td><input type="text" autocomplete="off" placeholder="Amount" class="form-control number-separator" id="instalment'+i+'" name="instalment'+i+'" data-error="" onchange="activateNextamount(this.name);getLastinst(this.name);" required="required" ></td><tr>');
				}else{
					
					$("#monthlyinstcustom").append('<tr><td><label>Instalment '+i+'</label></td><td><input type="text" autocomplete="off" class="form-control" id="instdate'+i+'" disabled name="instdate'+i+'" data-error="" required="required" onchange="activateNextdate(this.name);"  placeholder="Date"></td><td><input type="text" disabled autocomplete="off" placeholder="Amount" class="form-control number-separator" id="instalment'+i+'" name="instalment'+i+'" data-error="" onchange="activateNextamount(this.name);getLastinst(this.name);" required="required" ></td></tr>');
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
	/*End of Ticket No 2889*/

</script>