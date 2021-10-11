
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?> 
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
  

	$("#prj_id").chosen({
     allow_single_deselect : true
    });
	$("#cus_code").chosen({
     allow_single_deselect : true
    });
 
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
	
});
$( function() {
    $( "#dp_cmpldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
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
{  var newdiscount=parseFloat(document.getElementById("discount").value)
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
var vatvalue= parseFloat(document.getElementById("down_payment").value)*parseFloat(document.getElementById("vat").value)/100
	var totlpayamount=parseFloat(document.getElementById("document_fee").value)+parseFloat(document.getElementById("legal_fee").value)+parseFloat(document.getElementById("plan_charge").value)+parseFloat(document.getElementById("down_payment").value)+parseFloat(vatvalue);
document.getElementById("pay_amount").value=totlpayamount;


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
function check_activeflag(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>hm/customer/edit/"+id );
				}
            }
        });
}


function loadcurrent_block(id)
{
 if(id!=""){
	 
							 $('#blocklist').delay(1).fadeIn(600);
    					    document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#blocklist" ).load( "<?=base_url()?>hm/reservation/get_blocklist/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#blocklist').delay(1).fadeOut(600);
	
 }
}

function load_fulldetails(id)
{
	 if(id!="")
	 {
		 var prj_id= document.getElementById("prj_id").value
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		   $( "#fulldata").load( "<?=base_url()?>hm/reservation/get_fulldata/"+id+"/"+prj_id );
	 }
}

function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_projectms', id: id,fieldname:'prj_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'hm_projectms', id: id,fieldname:'prj_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data; 
					 $('#flagchertbtn').click();
             
					//document.getElementById('mylistkkk').style.display='block';
                } 
				else
				{
					$('#complexConfirm_confirm').click();
				}
            }
        });
	
	
//alert(document.testform.deletekey.value);
	
}
</script>
	
		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
        
  <div class="table">

                 
 
      <h3 class="title1">New Reservation</h3>
     			
      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
          
           <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Reservation Data</a></li> 
        
        </ul>	
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          
            
             
                <div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab"> 
                   	<? $this->load->view("includes/flashmessage");?>
                  
                       <form data-toggle="validator" method="post" action="<?=base_url()?>hm/reservation/editdata" enctype="multipart/form-data">
                       <input type="hidden" name="res_code"  id="res_code"  value="<?=$resdata->res_code?>" >
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms"> 
                       <div class="form-title">
								<h4>Basic Information </h4>
						</div>
                        <div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group">
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."  <? if(! check_access('all_branch')){?> disabled <? }?>  id="branch_code" name="branch_code" >
                    <option value="">Search here..</option>
                    <?    foreach($branchlist as $row){?>
                    <option value="<?=$row->branch_code?>,<?=$row->shortcode?>" <? if($row->branch_code==$resdata->branch_code){?> selected<? }?>><?=$row->branch_name?></option>
                    <? }?>
             
					</select> </div>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   id="cus_code" name="cus_code" >
                    <option value="">Customer Name</option>
                    <?    foreach($cuslist as $row){?>
                    <option value="<?=$row->cus_code?>" <? if($row->cus_code==$resdata->cus_code){?> selected<? }?>><?=$row->first_name?> <?=$row->last_name?></option>
                    <? }?>
             
					</select> </div>
                    <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Project Name</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>" <? if($row->prj_id==$resdata->prj_id){?> selected<? }?>><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div>
                     <div class="col-sm-3 " id="blocklist"> <select class="form-control" placeholder="Block Number"  id="lot_id" name="lot_id"   required >
                    <? foreach ($lotlist as $raw){
						if(trim($raw->lot_id)==trim($resdata->lot_id)){?>
						
                    <option value="<?=$raw->lot_id?>"  <? if(trim($raw->lot_id)==trim($resdata->lot_id)){?> selected<? }?>><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
                    <? }}?>
              
					
					</select>   </div>
                          </div><? }?></div>
                        
                        
                       </div></div>
                       <div id="fulldata" style="min-height:100px;">
                       
                       <div class="row">
	<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
		<div class="form-title">
		<h4>Lot Price Details</h4>
		</div>
		<div class="form-body">
        <? 
		$sellprice=$resdata->seling_price;
		$perchprice=$sellprice/$lotdetail->extend_perch;
		
		?>
			<div class="form-group col-md-6"><label>Land Extend</label>
			 <input   type="text" class="form-control" name="extend_perch" id="extend_perch" value="<?=$lotdetail->extend_perch?>" readonly>
			</div>
			<div class="form-group col-md-6"><label>Perch Price</label>
			<input  type="number" step="0.01"  min="<?=$lotdetail->price_perch?>" class="form-control" name="price_perch" id="price_perch" value="<?=$perchprice?>" readonly>
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
            $totsel=$sellprice;
			 $totsel= $totsel+floatval($lotdetail->latax)+floatval($lotdetail->vat)+floatval($lotdetail->othertax);
			?><input type="hidden" name="totprice"  id="totprice"  value="<?=$totsel?>" >
             <div class="form-group col-md-6"><label>Total Selling Price</label>
			 <input   type="text" class="form-control" name="extend_perch" id="extend_perch" value="<?=number_format($totsel,2)?>" readonly>
			</div>
			 <div class="clearfix"> </div>
          </div>
          <div class="form-title">
			<h4>Other Charges</h4>
		  </div>
          <div class="form-body">
			<div class="form-group has-feedback col-md-6"><label>Document Fee</label>
			 <input   type="text" class="form-control" name="document_fee" id="document_fee" value="<?=$resdata->document_fee?>" required >
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Leagel Fee</label>
			<input type="text" class="form-control" name="legal_fee" id="legal_fee" value="<?=$resdata->legal_fee?>"  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
             <div class="form-group has-feedback col-md-6"><label>Plan Copy Charge</label>
			 <input   type="text" class="form-control" name="plan_charge" id="plan_charge" value="<?=$resdata->plan_copy?>"  required>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Other Charges</label>
			<input type="text" class="form-control" name="other_charges" id="other_charges" value="<?=$resdata->other_charges?>"  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
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
                                  
			<select name="pay_type" id="pay_type" class="form-control" required>
             <option value="Pending">Pending</option>
            
             <?    foreach($saletype as $row){
				 if($row->type!='Outright'){
				 ?>
             
                   <option value="<?=$row->type?>" <? if($row->type==$resdata->pay_type){?> selected<? }?>><?=$row->description?></option>
                 <? }}?></select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Discount</label>
			<input type="number" class="form-control" name="discount" id="discount"  value="<?=$resdata->discount?>"  required  onChange="calculate_discunted()">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
             <div id="loandetails"   style="display:none" >
               <div class="form-group has-feedback col-md-6"><label>Repayment Period</label>
			<select name="period" id="period" class="form-control" onChange="instalment_cal()">
                    	<option value="12">12</option>
                    	 <option value="24" >24</option>
                     	 <option value="36" >36</option>
                         <option value="48" >48</option>
                          <option value="60">60</option>
                   </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Monthly Instalment</label>
			<input type="text" class="form-control" name="instalments" id="instalments"  value=""   required readonly>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
            </div>
            <div class="clearfix"> </div>
            <div class="form-group has-feedback col-md-6"><label>DP level</label>
            <select name="dp_level" id="dp_level" class="form-control" required onChange="calculate_discunted()">
              <?    foreach($dplevel as $row){?>
                    <option value="<?=$row->dp_rate?>"<? if($row->dp_rate==$resdata->dp_level){?> selected="selected"<? }?>><?=$row->dp_rate?></option>
                    <? }?></select>
			<input  type="hidden" class="form-control" name="interest" id="interest"  required value="0"  >
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span></div>
               <div class="form-group has-feedback col-md-6"><label>Non Refundable Amount</label>
			<input type="number" class="form-control" name="non_refund" id="non_refund"  required  value="<?=$resdata->non_refund?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>                         
			</div>
             <div class="clearfix"> </div>
             <div class="form-group has-feedback col-md-6"><label>Discounted Price</label>
			 <input   type="text" class="form-control" name="discounted_price" id="discounted_price" value="<?=$resdata->discounted_price?>" required  readonly>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Minimum Down Payment</label>
			<input type="text" class="form-control" name="min_down" id="min_down" value="<?=$resdata->min_down?>"  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
             <div class="form-group has-feedback col-md-6"><label>Down Payment</label>
			 <input   type="number" class="form-control" name="down_payment" id="down_payment" value="<?=$resdata->down_payment?>" onChange="calculate_payamount()" required>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
			<div class="form-group has-feedback col-md-6"><label>Total Pay  Amount</label>
			<input type="text" class="form-control" name="pay_amount" id="pay_amount" value="<?=$resdata->pay_amount?>"  required>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
             <div class="form-group has-feedback col-md-6"><label>Sales Officer</label>
			    <select name="sales_person" id="sales_person" class="form-control" placeholder="Sales Officer" >
                                    <option value="">Sales officer</option>
                                     <? foreach ($loan_officer as $raw){?>
                    <option value="<?=$raw->user_id?>" <? if($raw->user_id==$resdata->sales_person){?> selected<? }?>><?=$raw->initial?> &nbsp; <?=$raw->surname?></option>
                    <? }?>
        
                                    </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
            <div class="form-group has-feedback col-md-6"><label>Reservation Date</label>
			    <input type="text" name="res_date" id="res_date" value="<?=$resdata->res_date?>" class="form-control" required />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
            <div class="form-group has-feedback col-md-6"><label>Down Payment Completion Date</label>
			    <input type="text" name="dp_cmpldate" id="dp_cmpldate" value="<?=$resdata->dp_cmpldate?>" class="form-control" />
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
              <div id="bankdetails"  style="display:none">
              <div class="form-group has-feedback col-md-6"><label>Payment Method</label>
				<select name="pay_method" id="pay_method" class="form-control" onChange="callbankdata(this.value)">
                    	<option value="CSH" <? if($saledata->pay_method=='CSH'){?> selected<? }?>>Cash</option>
                    	 <option value="CHQ" <? if($saledata->pay_method=='CHQ'){?> selected<? }?>>Cheque</option>
                     	 <option value="SLIP" <? if($saledata->pay_method=='SLIP'){?> selected<? }?>>Direct Deposit</option>
                   </select>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
           
			<div class="form-group has-feedback col-md-6"><label>Cheque/Slip Number</label>
			<input type="text" class="form-control" name="cheque_no" id="cheque_no"  required   value="<?=$saledata->cheque_no?>">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
			</div>
             <div class="clearfix"> </div>
              
								
				</div>	
                 				<div class="bottom ">
											
										
											<div class="clearfix"> </div>
										</div>	
								
								</div>
                                	
							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>
                    
                       
                       
                       
                       
                       </div>    
                        
                        	<div class="form-group"  style="float:right"><? if($resdata->res_status=='PENDING'){?>
                                           <h3> <a href="javascript:call_confirm('<?=$resdata->res_code?>')"><span class="label label-success">Confirm</span></a>
							<a href="javascript:call_delete('<?=$resdata->res_code?>')"><span class="label label-danger">Delete</span></a>
												<button type="submit" class="btn btn-primary disabled" onClick="check_befor_submit()">Update</button></h3><? }?>
											</div>
                        
					</form></p> 
                </div>
              
            </div>
         </div>
      </div>
        
        
        
         <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content"> 
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4> 
									</div> 
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
                    
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
							<script>
            $("#complexConfirm").confirm({
                title:"Delete confirmation",
                text: "Are You sure you want to delete this ?" ,
				headerClass:"modal-header",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
                    window.location="<?=base_url()?>hm/reservation/delete/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            
              $("#complexConfirm_confirm").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1
					
                    window.location="<?=base_url()?>hm/reservation/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
            </script> 
            
            
        
        <div class="row calender widget-shadow"  style="display:none">
            <h4 class="title">Calender</h4>
            <div class="cal1">
                
            </div>
        </div>
        
        
        
        <div class="clearfix"> </div>
    </div>
</div>
		<!--footer-->
<?
	$this->load->view("includes/footer");
?>