
<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>

	<script type="text/javascript">

	$(document).ready(function(){
		
		
			$("#supplier_id").chosen({
				allow_single_deselect : true
			});
		
			$("#service_id").chosen({
				allow_single_deselect : true
			});
		
			$("#prj_id").chosen({
				allow_single_deselect : true
			});
		
			$("#advance_id").chosen({
				allow_single_deselect : true
			});
		

		
	});

$( function() {
			$( "#payment_date1" ).datepicker({dateFormat: 'yy-mm-dd'});
		} );
	function loadcurrent_block(id,change)
	{
	 //$('#fulldata').show();
	
		 id=$('#prj_id').val();
		 if(id!=""){

		 $('#blocklist1').delay(1).fadeIn(600);
		 document.getElementById("blocklist1").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		  //alert("<?=base_url()?>hm/hm_subcontract/get_blocklist/"+id+"/1")
		 $( "#blocklist1").load( "<?=base_url()?>hm/service/get_blocklist/"+id+"/1");


	 }
	 else
	 {
		 document.getElementById("checkflagmessage").innerHTML='Please Select Project';
   			 $('#flagchertbtn').click();
		 $('#blocklist').delay(1).fadeOut(600);

	 }
	}
	function load_sub_cat(id)
	{
		 
		  if(id!=""){
			$('#subcatlist').delay(1).fadeIn(600);
		   document.getElementById("subcatlist").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		   
		   $( "#subcatlist").load( "<?=base_url()?>hm/service/get_category_list/"+id);
	
		 }
		 else
		 {
			 document.getElementById("checkflagmessage").innerHTML='Please Select Block To Add Task';
			$('#flagchertbtn').click();
			 $('#subcatlist').delay(1).fadeOut(600);
	
		 }
	}
function viewsubcontract(con_id,lot_id,condata_id)
{

 $('#popupform').delay(1).fadeIn(600);
 $( "#popupform" ).load( "<?=base_url()?>hm/hm_subcontract/view_task_data/"+con_id+"/"+lot_id+"/"+condata_id);
}
function close_edit()
{
	$('#popupform').delay(1).fadeOut(600);
}
function load_advancebalance(val)
{
	
	if(val!='')
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
	else
	{
		 document.getElementById("advance_bal").value=0.00;
		  document.getElementById("advance_balv").value=0;
	}
}
function validate_amount()
{
	
	var mypayment=document.getElementById("pay_amount").value
	mypayment=mypayment.replace(/\,/g,'');
	var advancebal=document.getElementById("advance_balv").value;
	
	if(parseFloat(mypayment) > parseFloat(advancebal))
	{
		adv_id=document.getElementById("advance_id").value;
		if(adv_id!=''){
		 document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed cash advance amount'; 
					 $('#flagchertbtn').click();
					 document.getElementById("pay_amount").value='';
		}
	}
	
}
function call_delete(id)
{
	 document.deletekeyform.deletekey.value=id;
	 $('#complexConfirm').click();
				

}

function call_confirm(id)
{
	 document.deletekeyform.deletekey.value=id;
	 $('#complexConfirm_confirm').click();

}
</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">
		<div class="table">
			<h3 class="title1">Service Payments</h3>
            <div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New  Service Payment</a></li>
					<li role="presentation" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Service Payment List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;min-height:350px">
                <? $this->load->view("includes/flashmessage");?>
					<div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
						<p>
							<form data-toggle="validator" id="sucontracform" method="post" action="<?=base_url()?>hm/service/add_servicepayment" enctype="multipart/form-data">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>New Payment Request</h4>
										</div>
										<div class="form-body form-horizontal">
												<div class="form-group">
											        <label class=" control-label col-sm-3 " >Service Type</label>
                                                    <div class="col-sm-3 ">
                                                        <select name='service_id' id='service_id' class='form-control' required='required' >											<option value=''> Select Service</option >
                                                            <? if($services){
                                                            foreach($services as $dataraw){?>
                                                                <option value='<?=$dataraw->service_id?>'><?=$dataraw->service_name?></option>													<? }}?>
                                                         </select>
                                                    </div>
                                                    <label class=" control-label col-sm-3 " >Supplier Name</label>
                                                    <div class="col-sm-3 ">
                                                        <select name='supplier_id' id='supplier_id' class='form-control'>
                                                                <option value=''> Select Supplier</option >
                                                                <? if($suplist){foreach($suplist as $dataraw){?>
                                                                    <option value='<?=$dataraw->sup_code?>'><?=$dataraw->first_name?> - <?=$dataraw->last_name?></option><? }}?>
                                                         </select>
                                                     </div>
												  </div>
                                                  <div class="form-group">
												     <label class=" control-label col-sm-3 " >Advance List</label>
                                                    <div class="col-sm-3 ">
                                                        <select name='advance_id' id='advance_id'  onChange="load_advancebalance(this.value)"  class='form-control' required='required' >											
                                                        <option value=''> Select Advance</option >
                                                           <? if($advlist){
																   foreach($advlist as $dataraw)
																   { if($dataraw->totpay<$dataraw->amount){
																   ?>
																	<option value="<?=$dataraw->adv_id?>-<?=$dataraw->totpay?>-<?=$dataraw->amount?>" > <?=$dataraw->adv_code?> - <?=$dataraw->initial?> <?=$dataraw->surname?></option>
											 					<? }}}?>
                                                         </select>
                                                    </div>
                                                     <label class=" control-label col-sm-3 " >Advance Balance Amount</label>
                                                    <div class="col-sm-3 "><input  type="text" class="form-control" id="advance_bal"    name="advance_bal"  value=""   data-error=""    readonly placeholder="Advance Balance Amount" >
                                                    <input  type="hidden"  id="advance_balv"    name="advance_balv"  value="0"  >													</div>
												  </div>
													<div class="form-group">
																<label class=" control-label col-sm-3 " >Pay Amount</label>
																<div class="col-sm-3 ">
																	<input type='number' step="0.01" class='form-control' id='pay_amount'    name='pay_amount' required='required' OnChange="validate_amount()">
																</div>
																<label class=" control-label col-sm-3 " > Payment Date</label>
																<div class="col-sm-3 ">
																	<input type='text' class='form-control' id='payment_date1'    name='payment_date1' required='required'>
																</div>
														</div>
														<div class="form-group">
																<label class=" control-label col-sm-3 " >Description</label>
																<div class="col-sm-3 ">
																	<textarea  class='form-control' id='discription'    name='discription' ></textarea>
																</div>
																
															</div>
															
															<div class="form-group">
																<label class=" control-label col-sm-3 " >Project</label>
																<input type="hidden" id="lotviewcount" name="lotviewcount" value="0">
																<div class="col-sm-3 ">
																	<select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value,'1')" id="prj_id" name="prj_id" >
						                    <option value="">Project Name</option>
						                    <?    foreach($prjlist as $row){?>
						                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
						                    <? }?>
						                     </select>
																 </div>
																<label class=" control-label col-sm-3 " >Lot Number</label>
																<div class="col-sm-3 " id="blocklist1"></div>
															</div>
															<div class="form-group" id="subcatlist">
															
															</div>
															</div>
															</div>






																</hr>
																	
												</div>
												</p>
												</form>
                                               <br><br><br><br><br><br>
											</div>



							<div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<table class="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Service</th>
													<th>Project Name</th>
													<th>Lot Number</th>
													<th>Type</th>
													<th>Amount</th>
													<th>Request by</th>
													<th>Request Date</th>
													</tr>
											</thead>
										</tbody>
										<? if($datalist){ $c=0;
											foreach ($datalist as $key => $value) {

												?>
												<tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
													<td><?=$c?></td>
													<td><?=$value->service_name?></td>
													<td><?=$value->project_name?></td>
													<td><?=$value->lot_number?></td>
													<td><?=$value->type?></td>
													<td align="right"><?=number_format($value->pay_amount,2)?></td>
													<td ><?=get_user_fullname_id($value->request_by)?></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$value->request_date?></td>
													<td>
													<? if($value->status=='PENDING'){?>
                            							 <a  href="javascript:call_confirm('<?=$value->id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
                            							 <a  href="javascript:call_delete('<?=$value->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    							<? }?>
													</td>

												</tr>
										<?	}
										}?>
										</tbody>
									</table>
									<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
									</div>
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_budget" name="complexConfirm_confirm_budget"  value="DELETE"></button>

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
                    window.location="<?=base_url()?>hm/service/delete/"+document.deletekeyform.deletekey.value;
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

                    window.location="<?=base_url()?>hm/service/confirm/"+document.deletekeyform.deletekey.value;
                },
                cancel: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
                   // alert("You aborted the operation.");
                },
                confirmButton: "Yes I am",
                cancelButton: "No"
            });
			    $("#complexConfirm_confirm_budget").confirm({
                title:"Record confirmation",
                text: "Are You sure you want to confirm this ?" ,
				headerClass:"modal-header confirmbox_green",
                confirm: function(button) {
                    button.fadeOut(2000).fadeIn(2000);
					var code=1

                    window.location="<?=base_url()?>re/projectpayments/confirm_budget/"+document.deletekeyform.deletekey.value;
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
