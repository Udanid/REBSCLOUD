
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


  } );
  $( function() {
	 $( "#promiss_date" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );
jQuery(document).ready(function() {
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
	$("#ledger_id").chosen({
    		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Ledger"
    	});


});
function check_activeflag(id)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					alert( "<?=base_url()?>accounts/cashadvance/get_settementdata/"+id)
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/get_settementdata/"+id );
				}
            }
        });
}
function pay_cash(id,bookid)
{

		// var vendor_no = src.value;
//alert(id);

		$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'accounts/cashadvance/pay_cash';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
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
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
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
function call_check(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_check').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

}
function call_approve(id)
{
	 document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'ac_cashadvance', id: id,fieldname:'adv_id' },
            success: function(data) {
                if (data) {
					// alert(data);
					  document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirm_approve').click();
				}
            }
        });


//alert(document.testform.deletekey.value);

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
	 {$('#deedlist').delay(1).fadeOut(600);
		 var prj_id= document.getElementById("prj_id").value
	 	 $('#fulldata').delay(1).fadeIn(600);
    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   $( "#fulldata").load( "<?=base_url()?>re/deedtransfer/get_fulldata/"+id+"/"+prj_id );
	 }
}
function load_fulldetails_popup(prj_id,lot_id)
{

		// var prj_id= document.getElementById("prj_id").value



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
		alert(obj)
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
	//alert()
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
	//alert()
	if(val!='')
	{
	var paid = val.split("-")[1];
	if(val.split("-")[1])
	paid = val.split("-")[1];
	else
	paid = 0;
	var total = val.split("-")[2];
	var tot=parseFloat(total)-parseFloat(paid);
	 document.getElementById("invoice_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 document.getElementById("invoice_balv").value=tot
	}
	else
	{
		 document.getElementById("invoice_bal").value=0.00;
		  document.getElementById("invoice_balv").value=0;
	}
}
function validate_amount()
{
	var mypayment=document.getElementById("settleamount").value
	mypayment=mypayment.replace(/\,/g,'');

	var invoicebal=document.getElementById("invoice_balv").value;
	var advancebal=document.getElementById("advance_balv").value;

	if(document.getElementById("invoice_id").value=="")
		{
			//alert(document.getElementById("advance_balv").value);
			if(parseFloat(mypayment) > parseFloat(advancebal))
				{
					document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed cash advance amount';
					$('#flagchertbtn').click();
					 document.getElementById("settleamount").value='';
				}
			else
				{
					document.getElementById("settleamount").value=mypayment;
			}
		}
	else{
		if(parseFloat(mypayment) > parseFloat(invoicebal))
		{
		invoiceid=document.getElementById("invoice_id").value;
		if(invoiceid!='')
		{
		 document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed invoice amount';
					 $('#flagchertbtn').click();
					 document.getElementById("settleamount").value='';
		}
		}
		else if(parseFloat(mypayment) > parseFloat(advancebal))
		{
		 document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed cash advance amount';
					 $('#flagchertbtn').click();
					 document.getElementById("settleamount").value='';
		}
		else
		{
		 document.getElementById("settleamount").value=mypayment;
		}
		}
}
function check_projectselected()
{
	ledger_id=document.getElementById("ledger_id").value;
	if(ledger_id=="")
	{
		document.getElementById("checkflagmessage").innerHTML='Please Select Ledger';
					 $('#flagchertbtn').click();
					 document.getElementById("settleamount").value='';
					 return false
	}
	else
	return true;
	
}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">Cash Advance Settlements</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" <? if($list==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Settle Advance</a></li>
           <li role="presentation" <? if($list=='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Settlement List</a></li>

        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>

                <div role="tabpanel" class="tab-pane fade <? if($list==''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab">
                    <p>

                  <!--   <?=base_url()?>accounts/cashadvance/add_settlment-->
                          <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/cashadvance/add_settlment" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                       <div class="form-title">
								<h4>New Cash Advance </h4>
						</div>
                        <div class="form-body form-horizontal">
                         <div class="form-group"><label class=" control-label col-sm-3 " >Settle Ledger Account</label>
                         <div class="col-sm-3 "> <select name="ledger_id" id="ledger_id" class="form-control"required="required"   ><option value=""></option>
                           <? if($ledgerlist){
							 foreach($ledgerlist as $dataraw)
							 {
								
							 ?>
                        <option value="<?=$dataraw->id?>" > <?=$dataraw->id?> - <?=$dataraw->name?> </option>
											<? }}?>
                         </select></div> </div>
  						<div class="clearfix"> </div>
                          <div class="form-group"><label class=" control-label col-sm-3 " >Advance Number</label><div class="col-sm-3 "> <select name="adv_id" id="adv_id" class="form-control"required="required" onChange="load_advancebalance(this.value)"  ><option value="">Select Advance</option>
                           <? if($advlist){
							 foreach($advlist as $dataraw)
							 {
								 if($dataraw->adv_type=="Other"){
							 ?>
                        <option value="<?=$dataraw->adv_id?>-<?=$dataraw->totpay?>-<?=$dataraw->amount?>" ><?=$dataraw->emp_no?> - <?=$dataraw->adv_code?> - <?=$dataraw->initial?> <?=$dataraw->surname?>-<?=$dataraw->totpay?></option>
											<? }}}?>
                         </select></div> <label class=" control-label col-sm-3 " >Invoice</label>
                         <div class="col-sm-3 "><select name="invoice_id" id="invoice_id" class="form-control" onChange="load_invoice_balance(this.value)"  >
                         <option value="">Select Invoice</option>
                          <? if($invoice){
							 foreach($invoice as $dataraw)
							 { if($dataraw->totpay<$dataraw->total){
							 ?>
                        <option value="<?=$dataraw->id?>-<?=$dataraw->totpay?>-<?=$dataraw->total?>" > <?=$dataraw->total?> - <?=$dataraw->first_name?> <?=$dataraw->last_name?></option>
                         <? }}}?>
                         </select>
                          </div></div>
                           <div class="form-group">
                          <label class=" control-label col-sm-3 " >Advance Balance Amount</label>
                             <div class="col-sm-3 "><input  type="text" class="form-control" id="advance_bal"    name="advance_bal"  value=""   data-error=""    readonly placeholder="Advance Balance Amount" ></div>
                         <label class=" control-label col-sm-3 " >Invoice Balance Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="invoice_bal"    name="invoice_bal"  value=""   data-error=""  readonly placeholder="Invoice Balance Amount" >
                          <input  type="hidden"  id="invoice_balv"    name="invoice_balv"  value="0"  >
                          <input  type="hidden"  id="advance_balv"    name="advance_balv"  value="0"  ></div></div>

                       <div class="form-group">
                       <label class=" control-label col-sm-3 " >Pay Amount</label><div class="col-sm-3 ">  <input  type="number" min="1" step="0.01" class="form-control" id="settleamount"    name="settleamount"  value=""   data-error="" required onChange="validate_amount()"  placeholder="Pay Amount" ></div> <label class=" control-label col-sm-3 " >Settle Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="settledate"    name="settledate"  value=""   data-error="" required  placeholder="Settle Date" ></div>
                       </div>

                          <div class="form-group"> <label class=" control-label col-sm-3 " >Description</label>
                            <div id="tasklistdiv" class="col-sm-6"><input  type="text" class="form-control" id="note"    name="note"  value=""   data-error=""  placeholder="Description" ></div>
								<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" onClick="check_projectselected()" >Make Settlement</button></div></div></div>

                       </div>

                       </div>





					</form>





                   </p>

                </div>
                <div role="tabpanel" class="tab-pane fade  <? if($list=='book'){?>  active in <? }?> " id="list" aria-labelledby="list-tab">
                    <p>
                        <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">

                    </div>



                         <div class="clearfix"> </div>

						<div class=" widget-shadow" data-example-id="basic-forms">
                      <div class="form-title">
								<h4>Settlement List  </h4>
							</div>
                            <br>
                  <table class="table table-bordered"> <thead> <tr> <th> Date</th> <th>Payee</th>  <th>Full Amount</th><th>Settle Amount</th>  <th>Cash Advance No</th><th>Description</th><th>Confirmed By</th><th>Pay Status</th></tr> </thead>
                      <? if($settlelist){$c =0;
                          foreach($settlelist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->settledate?></th> <td><?=$row->initial?> <?=$row->surname?></td>
                            <td><?=number_format($row->amount,2) ?></td>
                             <td><?=number_format($row->settleamount,2)?></td>
                          <td><?=$row->adv_code ?></td>
                             <td><?=$row->note ?></td>
                             <td><?=get_user_fullname_id($row->confirm_by)?></td>
                               <td><?=$row->status ?></td>
                                <td>
                               <? if( $row->status=='PENDING')
							   {?>
                                <a  href="javascript:check_activeflag('<?=$row->id?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
          				        <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                                 <? if (check_access('check_cashadvance')){
									 if($this->session->userdata('userid')==$row->check_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_check('<?=$row->id?>')" title="Check"><i class="fa fa-check nav_icon icon_blue"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                             <? if( $row->status=='CHECKED')
							   {?>
                                
                                 <? if (check_access('confirm_cashadvance')){
									 if($this->session->userdata('userid')==$row->confirm_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
					   
					   			<? }}?>
                    	     <? }?>
                              <? if( $row->status=='CONFIRMED')
							   {?>
                                
                                 <? if (check_access('approve_cashadvance')){
									 if($this->session->userdata('userid')==$row->apprved_officerid  ||   check_access('all_access')){  ?>
              				         <a  href="javascript:call_approve('<?=$row->id?>')" title="Approve"><i class="fa fa-check nav_icon icon_red"></i></a>
					   
					   			<? }}?>
                    	     <? }?></td>

                         </tr>

                                <? }} ?>
                          </tbody></table> </div></div>
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_check" name="complexConfirm_check"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_approve" name="complexConfirm_approve"  value="DELETE"></button>
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
                    window.location="<?=base_url()?>accounts/cashadvance/delete_settlement/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>accounts/cashadvance/confirm_settlement/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			   $("#complexConfirm_check").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to check this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>accounts/cashadvance/check_settlement/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			 $("#complexConfirm_approve").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to Approve this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>accounts/cashadvance/approve_settlement/"+document.deletekeyform.deletekey.value;
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
