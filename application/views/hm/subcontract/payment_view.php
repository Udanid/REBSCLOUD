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
		$("#service_id").focus(function() {
			$("#service_id").chosen({
				allow_single_deselect : true
			});
		});
		$("#prj_id").focus(function() {
			$("#prj_id").chosen({
				allow_single_deselect : true
			});
		});

		$( function() {
			$( "#pay_date" ).datepicker({dateFormat: 'yy-mm-dd'});
		} );
	});


	function loadsuppliers(i)
	{
	 //$('#fulldata').show();
	 //alert(change)
	 var id=$('#prj_id').val();
	 var supcode=$('#service_id').val();


	if(id!="" && supcode!=""){

		 $('#suplierlist').delay(1).fadeIn(600);
		 $( "#suplierlist").load( "<?=base_url()?>hm/hm_subcontract/get_contractsuppliers/"+id+"/"+supcode);


	 }
	 else
	 {

		 $('#suplierlist').delay(1).fadeOut(600);

	 }
	}
	function add_suplier()
	{
		var sup_code=$('#contract_id').find(':selected').data('sup');
		$('#supplier_code').val(sup_code)

	}
	function call_confirm(id)
	{
		 document.deletekeyform.deletekey.value=id;

						$('#complexConfirm_confirm').click();


	}
	function call_delete(id)
	{
		 document.deletekeyform.deletekey.value=id;
			$('#complexConfirm').click();


	}
	function payment_edit(id)
	{
		$('#popupform').delay(1).fadeIn(600);
		$( "#popupform" ).load( "<?=base_url()?>hm/hm_subcontract/edit_subcontract_payment/"+id );

	}
	function close_edit(id)
	{
		$('#popupform').delay(1).fadeOut(800);
	}
</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">Subcontract Payment</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Subcontract Payment</a></li>
					<li role="presentation" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Subcontract Payment List</a></li>

				</ul>
				<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;min-height:350px">


					<div role="tabpanel" class="tab-pane fade  active in" id="profile" aria-labelledby="profile-tab">
						<p>
							<? if($this->session->flashdata('msg')){?>
							 <div class="alert alert-success" role="alert">
								 <?=$this->session->flashdata('msg')?>
							 </div><? }?>
								<? if($this->session->flashdata('error')){?>
							 <div class="alert alert-danger" role="alert">
								 <?=$this->session->flashdata('error')?>
							 </div><? }?>

							<form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_subcontract/add_subcontract_payment" enctype="multipart/form-data">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>Subcontract Payment</h4>
										</div>
										<div class="form-body form-horizontal">
											<div class="form-group">
											<!-- Project div start-->
											<label class=" control-label col-sm-3 " >Project</label>
											<div class="col-sm-3 ">
												<select class="form-control" placeholder="Qick Search.."   onchange="loadsuppliers(this.value)" id="prj_id" name="prj_id" >
													<option value="">Project Name</option>
													<?    foreach($prjlist as $row){?>
														<option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
													<? }?>
												</select>
											</div>


												<!--service div start-->
												<label class=" control-label col-sm-3 " >Service Type</label>
												<div class="col-sm-3 ">
													<input type="hidden" id="supplier_code" name="supplier_id">
													<select name='service_id' id='service_id' class='form-control' required='required' onchange="loadsuppliers(this.value)">
														<option value=''> Select Service</option >
															<? if($services){
																foreach($services as $dataraw){?>
																	<option value='<?=$dataraw->service_id?>'><?=$dataraw->service_name?></option>
																<? }}?>
															</select>
														</div>
														<!--service div end-->
													</div>
													<div id="suplierlist">
																			<!-- load contract list-->
													</div>
												<div class="form-group">
													<!-- stage div start-->
													<label class=" control-label col-sm-3 " >Stage</label>
													<div class="col-sm-3 ">
														<input type="text" id="stage" name="stage" class="form-control" required='required'>
													</div>

													<!-- percentage div start-->
													<label class=" control-label col-sm-3 " >Percentage</label>
													<div class="col-sm-3 ">
														<input type="text" id="percentage" name="percentage" class="form-control" required='required'>
													</div>
												</div>
												<div class="form-group">
													<!-- stage div start-->
													<label class=" control-label col-sm-3 " >Pay Amount</label>
													<div class="col-sm-3 ">
														<input type="number" step="0.01" id="amount" name="amount" class="form-control" required='required'>
													</div>

													<!-- percentage div start-->
													<label class=" control-label col-sm-3 " >Pay Date</label>
													<div class="col-sm-3 ">
														<input type="text" id="pay_date" name="pay_date" class="form-control pay_date" required='required'>
													</div>
												</div>




															<div ><button type="submit" class="btn btn-primary disabled pull-right" >Add Payment</button>
															</br></br></br></div>

													</div>
												</div>
												</p>
												</form>
											</div>


										</div>
							<div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<table class="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Project</th>
													<th>Service</th>
													<th>Supplier</th>
													<th>Stage</th>
													<th>Paid Amount</th>
													<th>Paid Date</th>
													<th>Voucher</th>
													<th>Statues</th>
													<th></th>
												</tr>
												<? if($datalist){
													foreach ($datalist as $key => $value) {?>
														<tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
															<td><?=$c?></td>
															<td><?=$value->project_name?></td>
															<td><?=$value->service_name?></td>
															<td><?=$value->sup_code?> - <?=$value->first_name?> <?=$value->last_name?></td>
															<td><?=$value->payment_stage?></td>
															<td align="right"><?=number_format($value->pay_amount,2)?></td>
															<td><?=$value->pay_date?></td>
															<td><?=$value->voucher_id?></td>
															<td><?=$value->status?></td>
															<td>
																<? if($value->status=="PENDING"){?>
																<a  href="javascript:call_confirm('<?=$value->pay_id?>')" title="Confirm"><i class="fa fa-check nav_icon icon_green"></i></a>
																<a  href="javascript:payment_edit('<?=$value->pay_id?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>

																 <a  href="javascript:call_delete('<?=$value->pay_id?>')" title="Reject Payment"><i class="fa fa-times nav_icon icon_red"></i></a>

															 <? }?>
															</td>
														</tr>
												<?	}
												}?>
											</thead>
										</tbody>

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
				<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
				</form>
				<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
				<link rel="stylesheet" href="<?=base_url()?>media/css/jquery.fileupload.css">
				<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
				<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
				<script src="<?=base_url()?>media/js/vendor/jquery.ui.widget.js"></script>
				<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
				<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
				<!-- The Canvas to Blob plugin is included for image resizing functionality -->
				<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
				<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
				<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
				<script src="<?=base_url()?>media/js/jquery.iframe-transport.js"></script>
				<!-- The basic File Upload plugin -->
				<script src="<?=base_url()?>media/js/jquery.fileupload.js"></script>
				<!-- The File Upload processing plugin -->
				<script src="<?=base_url()?>media/js/jquery.fileupload-process.js"></script>
				<!-- The File Upload image preview & resize plugin -->
				<script src="<?=base_url()?>media/js/jquery.fileupload-image.js"></script>
				<!-- The File Upload audio preview plugin -->
				<script src="<?=base_url()?>media/js/jquery.fileupload-audio.js"></script>
				<!-- The File Upload video preview plugin -->
				<script src="<?=base_url()?>media/js/jquery.fileupload-video.js"></script>
				<!-- The File Upload validation plugin -->
				<script src="<?=base_url()?>media/js/jquery.fileupload-validate.js"></script>
				<script>
				/*jslint unparam: true, regexp: true */
				/*global window, $ */
				$(function () {


				$("#complexConfirm").confirm({
					title:"Delete confirmation",
					text: "Are You sure you want to delete this ?" ,
					headerClass:"modal-header",
					confirm: function(button) {
						button.fadeOut(2000).fadeIn(2000);
						var code=1
						window.location="<?=base_url()?>hm/hm_subcontract/delete_subcontract_payment/"+document.deletekeyform.deletekey.value;
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

						window.location="<?=base_url()?>hm/hm_subcontract/confirm_subcontract_payment/"+document.deletekeyform.deletekey.value;
					},
					cancel: function(button) {
						button.fadeOut(2000).fadeIn(2000);
						// alert("You aborted the operation.");
					},
					confirmButton: "Yes I am",
					cancelButton: "No"
				});
			});
				$(document).ready(function(){


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
