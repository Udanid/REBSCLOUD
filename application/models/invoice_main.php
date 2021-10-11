
<!DOCTYPE HTML>
<html>
<head>

<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
$this->load->view("includes/topbar_normal");
?>
<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script type="text/javascript">
$( function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#promiss_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
	
	//set validation options
    $("#invForm").validate();
	
});

jQuery(document).ready(function() {
 	setTimeout(function(){
	  $("#ledger_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});
		$("#supplier_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Supplier"
    	});

    	$("#purchase_order").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Supplier"
    	});
		
				
	}, 500);


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
					$('#popupform').delay(1).fadeIn(600);
					$( "#popupform" ).load( "<?=base_url()?>accounts/cashadvance/get_cashadvance/"+id );
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
            url: '<?php echo base_url().'accounts/cashadvance/delete_chercker/';?>',
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
function check_projectselected()
{
	var type = document.getElementById("adv_type").value;
	if(obj=='Project')
	{
		var project=document.getElementById("project_id").value;
		if(project=='')
		{
			document.getElementById("checkflagmessage").innerHTML='Please Select Project';
					 $('#flagchertbtn').click();
					 document.getElementById("amount").value='';
		}
	}
}
function load_fixed_assetlist()
{
	var type = document.getElementById("type").value;
	if(type=='F')
	{
		$('#assetlisdiv').delay(1).fadeIn(600);
	}
	else{
		$('#assetlisdiv').delay(1).fadeOut(600);
	}
	
	if(type=='P'){
		$('#prjlistdiv').delay(1).fadeIn(600);
		$("#project_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
			width:'100%',
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select Project"
    	});

		$('#project_id').attr('required', 'required');
		$('#ledger_id').removeAttr('required');
	}else{
		$('#project_id').removeAttr('required');
		$('#ledger_id').attr('required', 'required');
		$('#prjlistdiv').delay(1).fadeOut(600);
	}
	
}
function calculatetot(id)
{
//	alert(id)
		var list=document.getElementById('allasstlist').value;
		var selectlist='';
		var unselabletot=0;
	if(list!="")
	{
		var res = list.split(",");
		alert(list)
		for(i=0; i< res.length-1; i++)
		{
			if(document.getElementById("isselect"+res[i]).checked){
			unselabletot=parseFloat(unselabletot)+parseFloat(document.getElementById('assetamount'+res[i]).value);
			selectlist=selectlist+res[i];
			}

		}



	}
	document.getElementById('amount').value=unselabletot;
	document.getElementById('selectasstlist').value=unselabletot;
}
function check_allselected()
{

	var type = document.getElementById("type").value;
	if(type=='O')
	{
		if(document.getElementById("ledger_id").value=='')
		{
				document.getElementById("checkflagmessage").innerHTML='Please Select Ledger Account';
					 $('#flagchertbtn').click();
					 document.getElementById("amount").value='';
		}
	}
	if(type=='F')
	{
			if(document.getElementById("selectasstlist").value=='')
		{

				document.getElementById("checkflagmessage").innerHTML='Please Select At leaset one fixed asset';
					 $('#flagchertbtn').click();
					 document.getElementById("amount").value='';
		}
	}

}
function displaymyvat()
{
	//var isvat=document.getElementById('isvat');
	var isvat=document.getElementById('isvat');
		if(isvat.checked)
			{
				 $('#vatallow').delay(1).fadeIn(600);
			}
			else
			{
				 $('#vatallow').delay(1).fadeOut(600);
			}

}

//Ticket No-2861|Added By Uvini
function load_purchase_order(sup_code)
{
	//document.getElementById("purchase_order_list").innerHTML = sup_code;
	$('#purchase_order_list').load("<?=base_url()?>accounts/purchase/get_po_list/"+sup_code)
}
</script>

		<!-- //header-ends -->
		<!-- main content start-->
<div id="page-wrapper">
 <div class="main-page">

  <div class="table">



      <h3 class="title1">New Invoice</h3>

      <div class="widget-shadow">
          <ul id="myTabs" class="nav nav-tabs" role="tablist">
           <li role="presentation" <? if($list==''){?> class="active"<? }?>><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add Invoice</a></li>
           <li role="presentation" <? if($list=='book'){?> class="active"<? }?>><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Invoice List</a></li>

        </ul>
           <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
          <? $this->load->view("includes/flashmessage");?>

                <div role="tabpanel" class="tab-pane fade <? if($list==''){?>  active in <? }?>" id="profile" aria-labelledby="profile-tab">
                    <p>


                          <form data-toggle="validator" method="post" id="invForm" action="<?=base_url()?>accounts/invoice/add_invoice" enctype="multipart/form-data">
                       <div class="row">
						<div class=" widget-shadow" data-example-id="basic-forms">
                       <div class="form-title">
								<h4>New Invoice </h4>
						</div>
                        <div class="form-body form-horizontal">

                          <div class="form-group"> <label class=" control-label col-sm-3 " >Supplier Name</label>
                             <div class="col-sm-3 "><select name="supplier_id" id="supplier_id" class="form-control chosen-select" required="required" onchange="load_purchase_order(this.value)"  >
                              <option value=""></option >
                         <? if($suplist){
							 foreach($suplist as $dataraw)
							 {
							 ?>
                        <option value="<?=$dataraw->sup_code?>"><?=$dataraw->first_name?> - <?=$dataraw->last_name?></option>
                         <? }}?>

                         </select></div> <label class=" control-label col-sm-3 " >Invoice Type</label>
                         <div class="col-sm-3 "><select name="type" id="type" class="form-control"required="required" onChange="load_fixed_assetlist(this.value)"  >
                         <option value=""> Invoice type</option>
                          <option value="P"> Project</option>
                          <option value="F"> Fixed Asset</option>
                           <option value="O"> Other</option>
                         </select>
                          </div></div>

                          <!-- Ticket No-2861|Added By Uvini -->
                          <div id="purchase_order_list"> </div>
                          
                           <div class="form-group">
                          
                           
                            <label class=" control-label col-sm-3 " >VAT Invoice</label>
                             <div class="col-sm-3 "><input type="checkbox" name="isvat" id="isvat" value="YES" onClick="displaymyvat()"></div>
                        <div id="vatallow"  style="display:none"> 
                        	<label class=" control-label col-sm-3 " >VAT Amount</label>
                            <div class="col-sm-3 ">  
                            	<input  type="text" class="form-control" id="vat_amount"    name="vat_amount"  value="0"   data-error="" required  placeholder="Invoice Amount" >
                            </div>
                            
                       </div>
                        </div>
                             <div class="clearfix"> </div><br>
                               <div class="form-group">
                          <label class=" control-label col-sm-3 " >Expense Account</label>
                             <div class="col-sm-3 "><select name="ledger_id" id="ledger_id" class="form-control chosen-select" required="required"  >
                              <option value=""> Ledger Account</option>
                         <? if($ledgerlist){
							 foreach($ledgerlist as $dataraw)
							 {
							 ?>
                        <option value="<?=$dataraw->id?>"><?=$dataraw->ref_id?> - <?=$dataraw->name?></option>
                         <? }}?>

                         </select></div>
                         <label class=" control-label col-sm-3 " >Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control number-separator" id="amount"    name="amount"  value=""   data-error="" required  placeholder="Invoice Amount" ></div></div>
                             <div class="clearfix"> </div><br>
                             <div id="assetlisdiv" style="display:none">
                          <label class=" control-label col-sm-3 " >Select Asset</label> <div id="fixedlist" class="col-sm-8" >
                         <table class="table table-bordered"><tr><th>Asset Name</th><th>Category</th><th>Amount</th><th>select</th></tr>
                           <?  $alllist='';if($assetlist){
							 foreach($assetlist as $dataraw)
							 {$alllist=$dataraw->id.','.$alllist;
							 ?>
                      <tr><td><?=$dataraw->asset_code?> <?=$dataraw->asset_name?> <?=$dataraw->remarks?> </td>
                      <td><?=$dataraw->asset_category?></td>
                       <td><?=number_format($dataraw->asset_value,2)?></td>
                         <td><input class="form-control" type="checkbox" value="Yes" name="isselect<?=$dataraw->id?>" id="isselect<?=$dataraw->id?>"  onclick="calculatetot('<?=$dataraw->id?>')"/></td></tr>
  <input type="hidden"  name="assetamount<?=$dataraw->id?>" id="assetamount<?=$dataraw->id?>" value="<?=$dataraw->asset_value?>">

                         <? }}?>
                        </table>


                         </div></div>
                         <input type="hidden"  name="allasstlist" id="allasstlist" value="<?=$alllist?>">
                         <input type="hidden"  name="selectasstlist" id="selectasstlist" value="">
                             

                       <div class="form-group">
                       <label class=" control-label col-sm-3 " >Invoice Date</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="date"    name="date"   data-error="" readonly value="<?=date('Y-m-d')?>"  placeholder="Invoice Date" style="background-color: white;"></div> 
											 <label class=" control-label col-sm-3 " >Invoice Number</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="inv_no"    name="inv_no"  value=""   data-error="" required  placeholder="Invoice Number" ></div>
                       </div>
                        <div class="form-group">
                       <label class=" control-label col-sm-3 " >Description</label><div class="col-sm-3 ">  <textarea  type="text" class="form-control" id="note"    name="note"  value=""   data-error="" required  placeholder="" ></textarea></div>
                       <div id="prjlistdiv" style="display:none">   <label class=" control-label col-sm-3 " >Project</label>
                             <div class="col-sm-3 "><select name="project_id" id="project_id" class="form-control chosen-select" >
                              <option value=""></option>
                         <? if($prjlist){
							 foreach($prjlist as $raw)
							 {
							 ?>
                        <option value="<?=$raw->prj_id?>"><?=$raw->project_name?></option>
                         <? }}?>

                         </select></div></div>
                         <label class=" control-label col-sm-3 " >Retention Applicable</label>
                            <div class="col-sm-3 ">  
                            	<input type="checkbox" name="retention" id="retention" checked  value="YES">
                            </div>
                           <div class="clearfix"> </div><br>

                         <div class="clearfix"> </div><br>
                          <div class="form-group"><div class="col-sm-3"></div>
                            <div id="tasklistdiv" class="col-sm-6"></div>
								<div class="col-sm-3 has-feedback" id="paymentdateid"><button type="submit" class="btn btn-primary disabled" onClick="check_allselected()" >Create Invoice</button></div></div></div>

                       </div>

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
								<h4>Invoice  List  </h4>
							</div>
                            <br>
                  <table class="table table-bordered"> <thead> <tr> <th> Date</th> <th>Supplier Name</th>  <th>Invoice Type</th> <th>Invoice Number</th><th>Item Description</th> <th>Invoice Amount</th><th>Paid Amount</th><th>Retention</th><th>Confirmed By</th><th>Pay Status</th><th></th></tr> </thead>
                      <? if($datalist){$c =0;
                          foreach($datalist as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->date?></th> <td><?=$row->first_name?> <?=$row->last_name?></td>
                        <td><?=$row->type?></td>
                        <td><?=$row->inv_no?></td>
                           <td><?=$row->note ?></td>
                            <td align="right"><?=number_format($row->total,2) ?></td>
                           <td align="right"><?=number_format($row->totpay,2) ?></td>
                           <td align="right"><?=number_format($row->retention_amount,2) ?></td>
                          <td align="center"><?=get_user_fullname_id($row->aprove_by)?></td>
                               <td><?=$row->paystatus ?></td>
                                <td>
                               <? if( $row->status=='PENDING'){?>

                      <? // if($this->session->userdata('userid')!=$row->officer_id ){?>
                       <a  href="javascript:call_confirm('<?=$row->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                      <? // }?>
                       <a  href="javascript:call_delete('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>

					<? }else if($row->type == 'P'){?>
                    	<a href=<?=base_url().'accounts/invoice/printinterim/'.$row->id;?> target="_blank" title="Interim Payment Certificate"><i class="fa fa-print nav_icon icon_blue"></i></a>	
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
                    window.location="<?=base_url()?>accounts/invoice/delete_invoice/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>accounts/invoice/confirm_invoice/"+document.deletekeyform.deletekey.value;
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
