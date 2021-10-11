
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
$( function() {
    $( "#settledate" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#promiss_date" ).datepicker({dateFormat: 'yy-mm-dd'});
});

jQuery(document).ready(function() {

	$("#invoice_id").chosen({
    	 allow_single_deselect : true,
		 placeholder_text: 'Select Invoice'
    });

    $("#sup_code").chosen({
    	 allow_single_deselect : true,
		 placeholder_text: 'Select Supplier',
		 width:100
    });
	
  	$("#project_id").focus(function() {
	  $("#project_id").chosen({
     		allow_single_deselect : true
    	});
	});
	
	$("#res_code_set").focus(function() {
	  	$("#res_code_set").chosen({
     		allow_single_deselect : true
    	});
	});
});

function check_activeflag(id)
{
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/activeflag_cheker/';?>',
		data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
		success: function(data) {
			if (data) {
				document.getElementById("checkflagmessage").innerHTML=data;
				$('#flagchertbtn').click();
			}
			else
			{
				//alert( "<?=base_url()?>accounts/cashadvance/get_settementdata/"+id)
				$('#popupform').delay(1).fadeIn(600);
				$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/get_settementdata/"+id );
			}
		}
	});
}

function pay_cash(id,bookid)
{
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'accounts/cashadvance/pay_cash';?>',
		data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
		success: function(data) {
			if (data) {
				 document.getElementById("checkflagmessage").innerHTML=data;
				 $('#flagchertbtn').click();
			}
			else
			{
				$('#popupform').delay(1).fadeIn(600);
				$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/denomination/"+bookid );
			}
		}
	});
}

function call_delete(id)
{
	document.deletekeyform.deletekey.value=id;
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/activeflag_cheker/';?>',
		data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
		success: function(data) {
			if (data) {
				document.getElementById("checkflagmessage").innerHTML=data;
				$('#flagchertbtn').click();
			}
			else
			{
				$('#complexConfirm').click();
			}
		}
	});
}

function call_confirm(id)
{
	document.deletekeyform.deletekey.value=id;
	$.ajax({
		cache: false,
		type: 'GET',
		url: '<?php echo base_url().'common/activeflag_cheker/';?>',
		data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
		success: function(data) {
			if (data) {
				 document.getElementById("checkflagmessage").innerHTML=data;
				 $('#flagchertbtn').click();
			}
			else
			{
				$('#complexConfirm_confirm').click();
			}
		}
	});
}

function loadcurrent_block(id)
{
	if(id!=""){
		$('#blocklist').delay(1).fadeIn(600);
    	document.getElementById("blocklist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		$( "#blocklist" ).load( "<?=base_url()?>re/deedtransfer/get_blocklist/"+id );
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
		$('#deedlist').delay(1).fadeOut(600);
		var prj_id= document.getElementById("prj_id").value
	 	$('#fulldata').delay(1).fadeIn(600);
		document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		$( "#fulldata").load( "<?=base_url()?>re/deedtransfer/get_fulldata/"+id+"/"+prj_id );
	 }
}

function load_fulldetails_popup(prj_id,lot_id)
{
	$( "#popupform").load( "<?=base_url()?>re/deedtransfer/get_fulldata_popup/"+lot_id+"/"+prj_id );
	$('#popupform').delay(1).fadeIn(600);
}

function load_prjlist(obj)
{
	if(obj=='Project')
	{
		 $('#prjlistdiv').delay(1).fadeIn(600);
	}
	else
	{
		 $('#prjlistdiv').delay(1).fadeOut(600);
	}
}

function load_tasklist(obj)
{
	if(obj!=''){
		$( "#tasklistdiv").load( "<?=base_url()?>accounts/cashadvance/get_tasklist/"+obj );
	}
	else
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Project';
		$('#flagchertbtn').click();
	}
}

function load_advancebalance(val)
{
	var paid = val.split("-")[1];
	if(val.split("-")[1])
	paid = val.split("-")[1];
	else
	paid = 0;
	var total = val.split("-")[2];
	var tot=parseFloat(total)-parseFloat(paid);
	document.getElementById("advance_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("advance_balv").value=tot
}

function load_invoice_balance(val)
{
	$('#payment_type').prop('selectedIndex',0);
	if(val!='')
	{
		var retention = parseFloat(val.split("-")[3]);
		var id = val.split("-")[0];
		var retention_paid = 0;
		var paid = val.split("-")[1];
		if(val.split("-")[1])
			paid = val.split("-")[1];
		else
			paid = 0;
		var total = val.split("-")[2];
	
	
		var tot=parseFloat(total)-parseFloat(paid);
		
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/invoice/get_retention_total_by_id/';?>',
            data: { id: id },
            success: function(data) {
                if (data) {
					retention = retention - data;
					retention_paid = data;
                }
				$('#retention_balv').val(retention);
				if(retention > 0){
					tot = tot - retention;
					$('#retention').css('display','block');
				}
				document.getElementById("invoice_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				document.getElementById("invoice_retention").value=retention.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				document.getElementById("invoice_balv").value=tot
				$('#settleamount').prop('readonly',false);
            }
        });
		
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/invoice/check_pending_payments_by_invoiceid/';?>',
            data: { id: id },
            success: function(data) {
                if (data) {
					//$("select[name=payment_type] option:last").remove();
					$("#payment_type option[value='Retention']").remove();
                }
            }
        });
		
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'accounts/invoice/check_project_invoice/';?>',
            data: { id: id },
            success: function(data) {
                if (data) {
					$("#payment_type option[value='Voucher']").remove();
					$("#payment_type option[value='Retention']").remove();
                }else{
					$("#payment_type option[value='Voucher']").remove();
					$("#payment_type option[value='Retention']").remove();
					$("#payment_type").append(new Option("Voucher", "Voucher"));
					$("#payment_type").append(new Option("Retention", "Retention"));
				}
            }
        });
	}
	else
	{
		document.getElementById("invoice_bal").value=0.00;
		document.getElementById("invoice_balv").value=0;
		document.getElementById("invoice_retention").value=0.00;
	}
}

function validate_amount()
{
	var mypayment=document.getElementById("settleamount").value
	mypayment=mypayment.replace(/\,/g,'');
	var invoicebal=document.getElementById("invoice_balv").value;

	if(parseFloat(mypayment) > parseFloat(invoicebal))
	{
		invoiceid=document.getElementById("invoice_id").value;
		if(invoiceid!='')
		{
		 	document.getElementById("checkflagmessage").innerHTML='Pay amount cannot exceed the invoice amount';
			$('#flagchertbtn').click();
			document.getElementById("settleamount").value='';
		}
	}
	else
	{
		 document.getElementById("settleamount").value=mypayment;
	}
}

function getRetention(){
	var val = $('#invoice_id').val();
	var type = $('#payment_type').val();
	var retention = $('#retention_balv').val().replace(/\,/g,'');
	var total = parseFloat($('#invoice_balv').val());
	
	if(total > 0 && type == 'Retention'){
		document.getElementById("checkflagmessage").innerHTML='Invoice balance is greater than retention';
		$('#flagchertbtn').click();
		$('#payment_type').prop('selectedIndex',0);
		return;
	}
	if(type == 'Retention' && retention > 0){
		var tot = parseFloat(retention);
		document.getElementById("invoice_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 	document.getElementById("invoice_balv").value=tot
	}
	if(type != 'Retention' && (total-retention) < 1){
		document.getElementById("invoice_bal").value=0.00;
		document.getElementById("invoice_balv").value=0;
	}
	
}

function addRetention(val){
	var retention = $('#retention_balv').val();
	var inv_balance = $('#invoice_balv').val();
	var new_balance = 0;
	if ($('#add_retention').is(":checked"))
	{
		new_balance = parseFloat(inv_balance) + parseFloat(retention);
		$('#invoice_bal').val(new_balance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"))
		$('#invoice_balv').val(new_balance);
	}else{
		inv_balance = parseFloat(inv_balance) - parseFloat(retention);
		$('#invoice_bal').val(inv_balance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"))
		$('#invoice_balv').val(inv_balance);
	}
}

//Ticket No:3440 Added By Madushan 2021-09-14
function search_invoice_payment()
{
 
 var sup_code = $('#sup_code').val();
 var inv_no = $('#inv_no').val();
 if(inv_no == '')
 	inv_no = 'all';
 // if(sup_code!="all" || inv_no!="all"){

 	// alert(sup_code);
 	// alert(inv_no);
     

             $('#invoice_payment_search').delay(1).fadeIn(600);
                  document.getElementById("invoice_payment_search").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
          $( "#invoice_payment_search" ).load( "<?=base_url()?>accounts/invoice/seach_invoice/"+sup_code+'/'+inv_no );
          



 // }
 
}

</script>
<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">
  	<div class="table">
      <h3 class="title1">Invoice Payments</h3>
      <div class="widget-shadow">
         <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" <? if($list==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add Invoice Payments</a></li>
           <li role="presentation" <? if($list=='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Payment  List</a></li>
      	</ul>
        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
        <? $this->load->view("includes/flashmessage");?>
            <div role="tabpanel" class="tab-pane fade <? if($list==''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab">
                <p>
				<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/invoice/make_payment" enctype="multipart/form-data">
                    <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                     		<div class="form-title">
								<h4>New Invoice Payment </h4>
							</div>
                        	<div class="form-body form-horizontal">
					
                          	<div class="form-group">
                          		
                          
                          		<label class=" control-label col-sm-3 " >Invoice</label>
                         		<div class="col-sm-3 ">
                                	<select name="invoice_id" id="invoice_id" class="form-control" onChange="load_invoice_balance(this.value);"  >
                         				<option value=""></option>
										 <? if($invoice){
                                             foreach($invoice as $dataraw)
                                             {
                                         ?>
                                        <option value="<?=$dataraw->id?>-<?=$dataraw->totpay?>-<?=$dataraw->total?>-<?=$dataraw->retention_amount?>" > <?=$dataraw->inv_no?> - <?=number_format($dataraw->total,2)?> - <?=$dataraw->first_name?> <?=$dataraw->last_name?></option>
                                         <? }}?>
                         			</select>
                          		</div> 
                                <label class=" control-label col-sm-3 " >Payment Type</label>
                          		<div class="col-sm-3 ">
                                    <select name="payment_type" id="payment_type" onChange="getRetention();" required class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="Voucher">Voucher</option>
                                        <option value="Deduction">Deduction</option>
                                        <option value="Retention">Retention</option>
                                    </select>
                          		</div> 
                          
                       		</div>
                       		<div class="form-group">
                          		<label class=" control-label col-sm-3 " >Invoice Balance Amount</label>
                                <div class="col-sm-3 ">
                                	<input  type="text" class="form-control" id="invoice_bal"    name="invoice_bal"  value=""   data-error=""  readonly placeholder="Invoice Balance Amount" >
                                </div>
                          		<label class=" control-label col-sm-3 " >Retention Amount</label>
                                <div class="col-sm-3 ">  
                                	<input  type="text" class="form-control" id="invoice_retention"    name="invoice_retention"  value=""   data-error=""  readonly placeholder="Invoice Retention" >
                                    <span id="retention" style="display:none;">
                                        <br />Include Retention&nbsp;&nbsp;&nbsp;<input type="checkbox" id="add_retention" onclick="addRetention(this.value)" />
                                    </span>
                                </div>
                          		<input type="hidden" id="invoice_balv" name="invoice_balv"  value="0" >
                          		<input type="hidden" id="advance_balv" name="advance_balv"  value="0" >
                                <input type="hidden" id="retention_balv" name="retention_balv"  value="0" >
                       		</div>
                       		<div class="form-group">
                       			<label class=" control-label col-sm-3 " >Pay Amount</label>
                                <div class="col-sm-3 ">
                                	<input  type="text" class="form-control number-separator" id="settleamount" readonly  name="settleamount"  value=""   data-error="" required onChange="validate_amount()"  placeholder="Pay Amount" >
                                </div>
								<label class=" control-label col-sm-3 " >Payment Date</label>
                                <div class="col-sm-3 ">
                                	<input  type="text" class="form-control" id="settledate"    name="settledate"  readonly value="<?=date('Y-m-d')?>" style="background-color: white;"   data-error="" placeholder="Settle Date" >
                                </div>
                       		</div>
                          	<div class="form-group">
                            	<label class=" control-label col-sm-3 " >Description</label>
                            	<div id="tasklistdiv" class="col-sm-3">
                            		<textarea class="form-control" id="note" name="note"></textarea>
                                </div>
                                <div class="col-sm-3"></div>
								<div class="col-sm-3 has-feedback" id="paymentdateid">
                                	<button type="submit" class="btn btn-primary disabled" onClick="check_projectselected()" >Make Payment</button>
                                </div>
                            </div>
						</div>
					</div>
                </form>
                </p>
			</div>
		</div>
        <div role="tabpanel" class="tab-pane fade  <? if($list=='book'){?>  active in <? }?> " id="list" aria-labelledby="list-tab">
            <p>
            <div class="row">
				<div class=" widget-shadow" data-example-id="basic-forms"></div>
				<div class="clearfix"> </div>
				<div class=" widget-shadow" data-example-id="basic-forms">

                <div class="form-title">
					<h4>Payment List  </h4>
				</div>
                <br>

                		    <div class="row">
        <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; margin-top:-40px; background-color: #eaeaea;">
            <div class="form-body">
                <div class="form-inline">

                    <div class="form-group">
                        <select class="form-control" placeholder="Qick Search.."    id="sup_code" name="sup_code" >
                        	<option value='all'>Select Supplier</option>
                    	<?if($suplist){foreach($suplist as $row){?>
                    		<option value="<?=$row->sup_code?>"><?=$row->first_name?> <?=$row->last_name?></option>
                    		<?}}?>

					</select>  </div>

                     <div class="form-group">
                      <input type="text" name="inv_no" id="inv_no" placeholder="Invoice Number"  class="form-control" >
                    </div>

                    <div class="form-group">
                        <button type="button" onclick="search_invoice_payment()"  id="search_payment" class="btn btn-primary " style="margin-bottom: 20px;margin-left: 5px;">Search</button>
                    </div>
                </div>
            </div>

        </div>


    </div>

                <div id="invoice_payment_search">
                <table class="table table-bordered"> 
                	<thead> 
                    	<tr> 
                        	<th>Invoice Date</th> 
                            <th>Supplier Name</th>  
                            <th>Payment Type</th> 
                            <th>Invoice Number</th> 
                            <th>Payment Date</th>
                            <th>Payment Description</th> 
                            <th>Invoice Amount</th>
                            <th>Paid Amount</th>
                            <th>Confirmed By</th>
                            <th>Pay Status</th>
                        </tr> 
					</thead>
                    <? if($datalist){$c =0;
                        	foreach($datalist as $row){
					?>
                    <tbody> 
                    	<tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                            <td scope="row"><?=$row->date?></td> 
                            <td><?=$row->first_name?> <?=$row->last_name?></td>
                            <td><?=$row->type?></td>
                            <td><?=$row->inv_no?></td>
                            <td><?=$row->pay_date?></td>
                            <td><?=$row->note ?></td>
                            <td align="right"><?=number_format($row->total,2) ?></td>
                            <td align="right"><?=number_format($row->pay_amount,2) ?></td>
                            <td><?=get_user_fullname_id($row->aproved_by)?></td>
                            <td><?=$row->pay_status ?></td>
                            <td>
                           <? if( $row->pay_status=='PENDING'){?>
                                <? // if($this->session->userdata('userid')!=$row->officer_id ){?>
                                <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                                <? // }?>
                                <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                <? } if( $row->pay_status=='APPROVED'){?>
                                <a  href="javascript:pay_cash('<?=$row->id?>','<?=$row->book_id?>')" title="Pay Cash"><i class="fa fa-money nav_icon icon_red"></i></a>
                                <? }?>
                           </td>
                       </tr>

                     <? }} ?>
                    </tbody>
                 </table>
                 </div>
              </div>
           </div>
           </p>
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
 <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_advdelete" name="complexConfirm_advdelete"  value="DELETE"></button>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_deed" name="complexConfirm_confirm_deed"  value="DELETE"></button>

<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
<script>
	$("#complexConfirm").confirm({
		title:"Delete confirmation",
		text: "Are you sure you want to delete this?" ,
		headerClass:"modal-header",
		confirm: function(button) {
			button.fadeOut(2000).fadeIn(2000);
			var code=1
			window.location="<?=base_url()?>accounts/invoice/delete_payment/"+document.deletekeyform.deletekey.value;
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
		text: "Are you sure you want to confirm this?" ,
		headerClass:"modal-header confirmbox_green",
		confirm: function(button) {
			button.fadeOut(2000).fadeIn(2000);
			var code=1

			window.location="<?=base_url()?>accounts/invoice/confirm_payment/"+document.deletekeyform.deletekey.value;
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
           <div class="cal1"></div>
        </div>
     	<div class="clearfix"> </div>
    </div>
</div>
<!--footer-->
<?
	$this->load->view("includes/footer");
?>