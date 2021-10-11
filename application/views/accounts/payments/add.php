<!DOCTYPE HTML>
<html>
<head>
<?
$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_accounts");
?>

<script>

jQuery(document).ready(function() {
	
	$("#banks").chosen({
     	allow_single_deselect : true,
	 	no_results_text: "Oops, nothing found!",
	 	search_contains: true,
	 	placeholder_text_single: "Select Bank Account"
    });
	
	$("#vouchertypes").chosen({
     	allow_single_deselect : true,
	 	no_results_text: "Oops, nothing found!",
	 	search_contains: true,
	 	placeholder_text_single: "Select Type"
    });

});
    function load_search_data(obj)
    {

        var value1 =obj.value;
       // alert(value1);

        if(value1=='' ){

            document.getElementById("seachlocator").style.display='none';
            document.getElementById("supplierlocator").style.display='none';

        }
        else if(value1==4)
        {
            var id = value1;
             document.getElementById("seachlocator").style.display='block';
            document.getElementById("supplierlocator").style.display='none';
            //popupdetails("accounts/payments/supplier_list",value,'supplierlocator')
           	 $('#seachlocator').load("<?=base_url()?>accounts/payments/voucher_data/"+id);
			  $('#bankaccload').load("<?=base_url()?>accounts/payments/advance_list/");
			  
		
        }
		
        else
        {
			  $('#bankaccload').load("<?=base_url()?>accounts/payments/otherlist_list/");
            //value=value1;
            var id=value1;
            document.getElementById("seachlocator").style.display='block';
            document.getElementById("supplierlocator").style.display='none';
           // popupdetails("accounts/payments/voucher_data",value,'seachlocator')
            $('#seachlocator').load("<?=base_url()?>accounts/payments/voucher_data/"+id);

        }
		setTimeout(function(){
			$("#banks").chosen({
				allow_single_deselect : true,
				no_results_text: "Oops, nothing found!",
				search_contains: true,
				placeholder_text_single: "Select Bank Account"
			});
		},300);
    }
	
    function load_supplier_data(obj)
    {

        var value1 =obj.value;


        if(value1=='' ){

            document.getElementById("seachlocator").style.display='none';
            //ocument.getElementById("supplierlocator").style.display='none';

        }
        else
        {
            var id=3+'/'+value1;
            document.getElementById("seachlocator").style.display='block';
            //document.getElementById("supplierlocator").style.display='none';
            //popupdetails("payments/supplier_voucher_data",value,'seachlocator')
            $('#seachlocator').load("<?=base_url()?>accounts/payments/supplier_voucher_data/"+id);
        }


    }

    function checkAll(obj)
    {


        var rawmatcount=document.myform.rawmatcount.value;
        if(obj.checked){
            for(i=1; i<=rawmatcount; i++)
            {

                totobj=eval("document.myform.isselect"+i);
                totobj.checked=true;

            }
        }
        else{
            for(i=1; i<=rawmatcount; i++)
            {
//alert("ss")
                totobj=eval("document.myform.isselect"+i);
                totobj.checked=false;
//alert(units+avbunits);
            }
        }
        calculatetot();
    }
    function calculatetot()
    {

        var tot=0;

        var rawmatcount=document.myform.rawmatcount.value;

        for(i=1; i<=rawmatcount; i++)
        {

            totobj=eval("document.myform.isselect"+i);

            amount=eval("document.myform.invoiceamount"+i);

            if(totobj.checked)
            {

                tot=parseFloat(tot)+parseFloat(amount.value);

            }

        }

        if(tot!=0)
        {
            document.myform.amount.value=parseFloat(tot).toFixed(2);
        }
        else
        {
            document.myform.amount.value="";
        }
    }
    function loadpayeelist(obj)
    {
        val=obj.value;
        if(val=='2')
        {
            document.getElementById("emp").style.display='block';
            document.getElementById("supp").style.display='none';
            document.getElementById("common").style.display='none';
        }
       
        else
        {
            document.getElementById("emp").style.display='none';
            document.getElementById("common").style.display='block';
            document.getElementById("supp").style.display='none';
        }
    }
    function loadpayeename(obj)
    {
        alert(document.myform)
        document.myform.payeename.value=obj.value;
    }
    function myValidator()
    {
        valeu1=document.myform.amount.value;
        if(valeu1=="")
        {
            //alert('false');
            document.getElementById("error-box").style.display='block';
            return false;
        }
        else
        {
            document.getElementById("error-box").style.display='none';
            return true;
        }
    }
</script>

  <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <h3 class="title1">Make Payment</h3>
                <?php $this->load->view("includes/flashmessage");?>
                <div class="widget-shadow">
                    <div class="  widget-shadow" data-example-id="basic-forms">
                        <div class="clearfix"> </div>
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation"   class="active" >
                                <a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Make Payment</a></li>
                               <li role="presentation">
                                <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="false">Enter Payment</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
                            <div class="form-title">
      <h4>New Payment</h4>
      </div>
            <?php $this->load->view("includes/flashmessage");?>
                <div class="  widget-shadow" data-example-id="basic-forms">
                    <?
                    echo form_open('accounts/payments/make_payment','name="myform" onsubmit="return myValidator()"');
                    ?>
                        <div class="row">
                            <div class="col-md-12 validation-grids widget-shadow" data-example-id="basic-forms" style="width: 100%; min-height:350px;">
                                <div class="form-body">
                                    <div class="form-inline">
                                        <div id="error-box" style="display:none"><ul><li>Total Amount could not be blank</li></ul></div>
                                        <table class="table" >
                                            <tr>
                                                <td>
                                                    <div class="form-group"><label class="col-sm-3 control-label">Payment Type</label>
                                                        <div class="col-sm-3 has-feedback">
                                                            <select class="form-control" name="vouchertypes" id="vouchertypes" onchange="load_search_data(this)">
                                                                <option value=""></option>
                                                                <? if($vouchertypes){foreach($vouchertypes as $raw){ ?>
                                                                    <option value="<?=$raw->typeid?>" <? if($typeid==$raw->typeid){?> selected="selected" <? }?>><?=$raw->typename?></option>
                                                                <? }}?>
                                                                 
                                                            </select>
                                                        </div>
                                                        <label class="col-sm-3 control-label">Bank Account</label>
                                                        <div class="col-sm-3 has-feedback"  id="bankaccload">
                                                            <select class="form-control" name="banks" id="banks"  required >
                                                                <option value=""></option>
                                                                <? if($banks){foreach($banks as $raw){?>
                                                                    <option value="<?=$raw->id?>" ><?=$raw->ref_id?> - <?=$raw->name?></option>
                                                                <? }}?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                     
                                                </td></tr>
                                                <tr> <td colspan="2">
                                                <div id="supplierlocator"></div>
                                                   </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><div id="seachlocator"></div></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? echo form_close(); ?>
                </div>
                            </div>
                      
                            <div role="tabpanel" class="tab-pane fade" id="budget" aria-labelledby="budget-tab">
                                <p>	<?  $this->load->view("accounts/paymentvouchers/add");?> </p>
                            </div>
                           

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
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancel" name="complexConfirm_cancel"  value="DELETE"></button>
            <button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_cancelCheque" name="complexConfirm_cancelCheque"  value="DELETE"></button>
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
                        window.location="<?=base_url()?>accounts/payments/delete/"+document.deletekeyform.deletekey.value;
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

                        window.location="<?=base_url()?>accounts/payments/confirm/"+document.deletekeyform.deletekey.value;
                    },
                    cancel: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        // alert("You aborted the operation.");
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No"
                });
                $("#complexConfirm_cancel").confirm({
                    title:"Record confirmation",
                    text: "Are You sure you want to cancel this ?" ,
                    headerClass:"modal-header",
                    confirm: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        var code=1

                        window.location="<?=base_url()?>accounts/payments/cancelation/"+document.deletekeyform.deletekey.value;
                    },
                    cancel: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        // alert("You aborted the operation.");
                    },
                    confirmButton: "Yes I am",
                    cancelButton: "No"
                });
                $("#complexConfirm_cancelCheque").confirm({
                    title:"Record confirmation",
                    text: "Are You sure you want to cancel this ?" ,
                    headerClass:"modal-header",
                    confirm: function(button) {
                        button.fadeOut(2000).fadeIn(2000);
                        var code=1

                        window.location="<?=base_url()?>accounts/payments/cancelation_cheque/"+document.deletekeyform.deletekey.value;
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
<?
$this->load->view("includes/footer");
?>








<?php
//file create by udani 12-09-2013
////`refnumber`, `entryid`, `payeecode`, `payeename`, `vouchertype`, `paymentdes`, `amount`, `applydate`, `confirmdate`, `paymentdate`, `paymenttype`, `status`, `confirmby`SELECT * FROM `ac_payvoucherdata` WHERE 1




