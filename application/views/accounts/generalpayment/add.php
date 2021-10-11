<?
//echo form_open('paymentvouchers/add','name="myform"');

$fy_start = $this->session->userdata('fy_start');
$fy_end = $this->session->userdata('fy_end');

?>


    <script type="text/javascript">
/*        $( document ).ready(function() {

            $("#banks").focus(function() {
                $("#banks").chosen({
                    allow_single_deselect : true
                });
            });
			$("#applymonth").focus(function() {
                $("#applymonth").chosen({
                    allow_single_deselect : true
                });
            });
			$("#draccount").focus(function() {
                $("#draccount").chosen({
                    allow_single_deselect : true
                });
            });
			$("#bank_account").focus(function() {
                $("#bank_account").chosen({
                    allow_single_deselect : true
                });
            });
        });
       */ $(function() {
	 
        var availableTags = [
		<? if ($customer){ foreach ($customer as $row){
			echo '"'.$row->cus_code.' -'.$row->first_name.' '.$row->last_name.'",';
			}}?>
			""
		
        ];
		
       
		 $( "#payeename" ).autocomplete({
            source: availableTags
        });
   	 });

        $( function() {

            $( "#entry_date" ).datepicker({dateFormat: 'yy-mm-dd',
               minDate: new Date('<?php echo $fy_start; ?>'),
                maxDate: new Date('<?php echo $fy_end; ?>')
            }).attr('readonly','readonly');
            $("#entry_date").datepicker('setDate', new Date());


        } );

        function loadpayeelist(obj)
        {

            val=obj.value;
            //alert(val);
            if(val=='6')
            {
                //document.getElementById("projectlist").style.display='block';
                document.getElementById("subprojectlist").style.display='block';
                setTimeout(function(){
                    $("#subprojectid").chosen({
                        allow_single_deselect : true
                    });}, 300);

                //document.getElementById("common").style.display='none';
            }
            else
            {
                //document.getElementById("projectlist").style.display='none';
                document.getElementById("subprojectlist").style.display='none';
            }
            if(val=='4')
            {

                document.getElementById("subprojectlist").style.display='block';
                setTimeout(function(){
                    $("#subprojectid").chosen({
                        allow_single_deselect : true
                    });}, 300);
            }
        }
		
		function load_refunddata(val)
		{
			if(val=='101')
			{
				 $('#refunddata').delay(1).fadeIn(600);
    			  document.getElementById("refunddata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		 	  $( "#refunddata").load( "<?=base_url()?>accounts/generalpayments/get_resaledata/loan");
				

			}
			if(val=='102')
			{
				 $('#refunddata').delay(1).fadeIn(600);
    			  document.getElementById("refunddata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		 	  $( "#refunddata").load( "<?=base_url()?>accounts/generalpayments/get_resaledata/advance");
				

			}
			
			 $('#draccountid').delay(1).fadeIn(600);
    			  document.getElementById("draccountid").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		 	  $( "#draccountid").load( "<?=base_url()?>accounts/generalpayments/get_draccount/"+val);
		}

function load_activebudle_1(val)
{
	if(val!='')
	{
		 $( "#chequebudledispaly1").load( "<?=base_url()?>accounts/generalpayments/get_chequeboundle/"+val);
	}
	
}
function check_form()
{
	var date= document.getElementById("entry_date").value;
	var vouchertype= document.getElementById("vouchertype").value;
	var payeename= document.getElementById("payeename").value;
	var payeename= document.getElementById("payeename").value;
	var bank_account= document.getElementById("bank_account").value;
	var draccount= document.getElementById("draccount").value;
	var amount= document.getElementById("amount").value;
	//alert(amount)
	var error='';
	if(date=='')
	error=error+' Date Cannot be Blank <br>';
	if(vouchertype=='')
	error=error+' Vauchre Type Cannot be Blank <br>';
	if(payeename=='')
	error=error+' Payee Name Cannot be Blank <br>';
	if(bank_account=='')
	error=error+' Bank Account Cannot be Blank <br>';
	if(draccount=='')
	error=error+' Debit Account Cannot be Blank <br>';
	if(amount=='')
	error=error+' Amount Cannot be Blank <br>';
	amount=amount.replace(/\,/g,'')
	if(isNaN(amount))
	error=error+' Amount should be number <br>';
	//alert(vouchertype)
	if(vouchertype=='101' || vouchertype=='102')
	{
		var resale_code= document.getElementById("resale_code").value;
		if(resale_code=='')
			error=error+' Resale block Cannot be Blank <br>';
	}
	if(error=='')
	{
		document.getElementById("payform").submit();
	}
	else
	{
		  document.getElementById("checkflagmessage").innerHTML=error; 
					 $('#flagchertbtn').click();
	}
	
	
	
}
function format_val(obj)
{
	a=obj.value;
	a=a.replace(/\,/g,'')
	obj.value=parseFloat(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
    </script>

<form data-toggle="validator"  id="payform"  method="post"  action="<?=base_url()?>accounts/generalpayments/add"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%;">
            <div class="form-body">
                <div class="form-inline">
                    <div class="form-group col-md-4" style="width: 25%;">Voucher Data<br/>
                        <div class="col-sm-3 has-feedback">
                            <input type="text" class="form-control" name="entry_date" id="entry_date">
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">Payment Voucher Type<br/>
                        <select name="vouchertype" id="vouchertype" class="form-control" style="width: 100%;"  required onchange="load_refunddata(this.value)" > 
                            <option value="">Select Type</option>
                          
                                <option value="101" >Loan Resale Refund </option>
                                <option value="102" >Advance Resale Refund</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">Document Reference Number<br/>
                        <input type="text" class="form-control" style="width: 100%;" id="refnumber" name="refnumber" required="required">
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">
                        Apply Month<br/>
                        <select name="applymonth" id="applymonth" class="form-control" style="width: 100%;" >
                            <option value="">Select Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <br/>
                    <br>
                    <div class="clearfix"> </div><br>
                    <div class="form-group col-md-4" style="width: 25%;">
                        Payee Name<br/>
                        <div id="emp">
                            <input type="text" name="payeename" id="payeename" class="form-control" style="width: 100%;" value="<?=$name?>" required>
                              
                        </div>
                    </div>
                     
                    <div class="form-group col-md-4" style="width: 25%;">
                        Amount<br/>
                        <? //=form_input($amount)?>
                        <input type="text"   onchange="format_val(this)" class="form-control number-separator" id="amount" name="amount"  style="width: 100%;">
                    </div>
                      <div class="form-group col-md-4" style="width: 25%;">
                        Payment Method<br/>
                      <select class="form-control" name="payment_mode" id="payment_mode" required>
                                                        <option value="CHQ" <? if($payment_mode=="CHQ"){?> selected="selected"<? }?> >CHEQUE</option>
                                                        <option value="CSH" <? if($payment_mode=="CSH"){?> selected="selected"<? }?>>CASH</option>
                                                    </select>&nbsp;&nbsp; Account Pay &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="YES" name="pay_mode"  id="pay_mode" />
                    </div>
                    <div class="form-group col-md-4" style="width: 25%;">
                       
                     
                    </div>
                    <div class="clearfix"> </div><br>
                     <div class="form-group col-md-6" style="width: 50%;">
                      Bank Account<br/>
                         <select class="form-control" name="bank_account" id="bank_account"  onchange="load_activebudle_1(this.value)" required >
                                                                <option value="">Select Bank Account</option>
                                                                <? if($banks){foreach($banks as $raw){?>
                                                                    <option value="<?=$raw->id?>" ><?=$raw->ref_id?> - <?=$raw->name?></option>
                                                                <? }}?>
                                                            </select><div id="chequebudledispaly1"></div>
                     
                    </div>
                    <div class="form-group col-md-6" id="draccountid">
                      Debit Account<br/><? ?>
                         <select class="form-control" name="draccount" id="draccount"  required >
                                                                <option value="">Select Bank Account</option>
                                                                <? 
															
																  foreach ($draccountset as $raw)
																{ 
																//print_r($raw);
																?>
                                                                
                                                                <option value="<?=$raw->id?>"><?=$raw->ref_id?> - <?=$raw->name?></option>
																	
																<? }?>
                                                            </select>
                     
                    </div>
                    <div class="clearfix"> </div><br>
                     <div   class="col-md-12 validation-grids widget-shadow" id="refunddata"  data-example-id="basic-forms" style="  width: 100%; background-color: #eaeaea;">
     				<input type="hidden"  id="resale_code" />
                    
                    </div>
                    <div class="clearfix"> </div><br>
                    <div class="form-group  col-md-6" style="width: 50%;">Payment Description <br/>
                        <textarea class="form-control" id="paymentdes" name="paymentdes" style="width: 100%;"><?//=form_textarea($paymentdes)?></textarea>
                    </div>
                    <div class="clearfix"> </div>
                    <div class="form-group col-md-4">
                    <button type="button"  onclick="check_form()" id="create" class="btn btn-primary " style="width: 70px;">Create</button>
                        <? //=form_submit('submit', 'Create');?>
                    </div>
<br /> <br /> <br /><br /> <br /> <br /><br /> <br /> <br /><br /> <br /> <br />
                </div>
            </div>
        </div>
    </div>
</form>

<?php
//file create by udani 12-09-2013
////`refnumber`, `entryid`, `payeecode`, `payeename`, `vouchertype`, `paymentdes`, `amount`, `applydate`, `confirmdate`, `paymentdate`, `paymenttype`, `status`, `confirmby`SELECT * FROM `ac_payvoucherdata` WHERE 1


//echo form_close();

