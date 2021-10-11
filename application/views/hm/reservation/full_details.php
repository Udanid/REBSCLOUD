
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
    $( "#res_date" ).datepicker({dateFormat: 'yy-mm-dd'});

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
//alert(document.getElementById("totprice").value)
var newdiscount=parseFloat(document.getElementById("discount").value)
	if(newdiscount > 100)
	discounted=parseFloat(document.getElementById("totprice").value)-parseFloat(newdiscount);
	else
	{  var totldis=parseFloat(document.getElementById("totprice").value)*parseFloat(newdiscount)/100;
	discounted=parseFloat(document.getElementById("totprice").value)-parseFloat(totldis)
	}
	document.getElementById("discounted_price").value=discounted;
	document.getElementById("min_down").value=discounted*parseFloat(document.getElementById("dp_level").value)/100;
	//document.getElementById("down_payment").value=discounted*parseFloat(<?=$mindp?>)/100;


}
function calculate_payamount()
{
//alert(document.getElementById("down_payment").value);
//var vatvalue= 0;//parseFloat(document.getElementById("down_payment").value)*parseFloat(document.getElementById("vat").value)/100
//	var totlpayamount=parseFloat(document.getElementById("document_fee").value)+parseFloat(document.getElementById("legal_fee").value)+parseFloat(document.getElementById("plan_charge").value)+parseFloat(document.getElementById("down_payment").value)+parseFloat(vatvalue);
/* document fees and other charges pay from other charges*/
document.getElementById("pay_amount").value=parseFloat(document.getElementById("down_payment").value);


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
function change_totselprice()
{
	var perchrice=parseFloat(document.getElementById("price_perch").value)*parseFloat(document.getElementById("extend_perch").value);
	document.getElementById("totprice").value=perchrice;
	document.getElementById("discounted_price").value=perchrice;
	document.getElementById("extend_perch1").value=perchrice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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
			</div>
			<div class="form-group col-md-6"><label>Perch Price</label>
			<input type="number" step="0.01"  min="<?=$lotdetail->price_perch?>" class="form-control" name="price_perch" id="price_perch" value="<?=$lotdetail->price_perch?>"  onblur="change_totselprice()">
			</div>
             <div class="clearfix"> </div>
             <div class="form-group col-md-6"><label>LA Tax</label>
			 <input   type="text" class="form-control" name="latax" id="latax" value="<?=$lotdetail->latax ?>" readonly>
			</div>
			<div class="form-group col-md-6"><label>VAT</label>
			<input type="text" class="form-control" name="vat" id="vat" value="<?=get_rate('VAT')?>" readonly>
			</div>
             <div class="clearfix"> </div>
             <div class="form-group col-md-6"><label>Other Tax</label>
			 <input   type="text" class="form-control" name="othertax" id="othertax" value="<?=$lotdetail->othertax?>" readonly>
			</div>
            <?
            $totsel=floatval($lotdetail->extend_perch)*floatval($lotdetail->price_perch);
			 $totsel= $totsel+floatval($lotdetail->latax)+floatval($lotdetail->vat)+floatval($lotdetail->othertax);
			?><input type="hidden" name="totprice"  id="totprice"  value="<?=$totsel?>" >
             <div class="form-group col-md-6"><label>Total Selling Price</label>
			 <input   type="text" class="form-control" name="extend_perch1" id="extend_perch1" value="<?=number_format($totsel,2)?>" readonly>
			</div>
			 <div class="clearfix"> </div>
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
             <?     foreach($saletype as $row){
				  if($row->type!='Outright'){?>
                 <option value="<?=$row->type?>"><?=$row->description?></option>
                   <? }}?></select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Discount</label>
			<input type="number" class="form-control" name="discount" id="discount"  required   onblur="calculate_discunted()">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
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
			<input type="number" class="form-control" name="non_refund" id="non_refund"  required  value="25000">
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
			 <input   type="number" class="form-control" name="down_payment" id="down_payment" value="0" onChange="calculate_payamount(),instalment_cal()" required>
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
			    <select name="sales_person" id="sales_person" class="form-control" placeholder="Sales Officer" required="required"  >
                                    <option value="">Sales officer</option>
                                     <? foreach ($loan_officer as $raw){?>
                    <option value="<?=$raw->user_id?>" ><?=$raw->initial?> &nbsp; <?=$raw->surname?></option>
                    <? }?>

                                    </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div><? $futureDate=date('Y-m-d',strtotime('+21 days',strtotime(date('Y-m-d'))));?>
            <div class="form-group has-feedback col-md-6"><label>Reservation Date</label>
			    <input type="text" name="res_date" id="res_date" value="<?=date('Y-m-d')?>" class="form-control" required="required" />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="form-group has-feedback col-md-6"><label>40% Completion Date</label>
			    <input type="text" name="dp_cmpldate" id="dp_cmpldate" value="<?=$futureDate?>" class="form-control" required="required" />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
      <? $futureDate=date('Y-m-d',strtotime('+2 months',strtotime(date('Y-m-d'))));?>
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
												<button type="submit" class="btn btn-primary disabled" onClick="check_befor_submit()">Sumbit</button>
											</div>
											<div class="clearfix"> </div>
										</div>

								</div>

							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>
