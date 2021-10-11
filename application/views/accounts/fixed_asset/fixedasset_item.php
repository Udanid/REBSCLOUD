
<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function() {


		$("#leger_acc").chosen({
			allow_single_deselect : true
		});
		$("#depre_acc").chosen({
			allow_single_deselect : true
		});
		$("#provi_acc").chosen({
			allow_single_deselect : true
		});
		$("#dispo_acc").chosen({
			allow_single_deselect : true
		});



	});

	function check_activeflag(id)
	{

		$('#popupform').delay(1).fadeIn(600);
		$("#popupform").load( "<?=base_url()?>accounts/Fixedasset/edit/"+id );

	}
	function view_remarks(id)
	{

		$('#popupform').delay(1).fadeIn(600);
		$("#popupform").load( "<?=base_url()?>accounts/Fixedasset/remarks/"+id );

	}
	function close_edit(id)
	{
		$('#popupform').delay(1).fadeOut(800);

	}
	var deleteid="";
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
	function loadbranchlist(itemcode,caller)
	{
		var code=itemcode.split("-")[0];
		if(code!=''){
			//alert(code)
			//$('#popupform').delay(1).fadeIn(600);
			$( "#branch-"+caller ).load( "<?=base_url()?>common/get_bank_branchlist/"+itemcode+"/"+caller );}

		}
		</script>

		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">

				<div class="table">



					<h3 class="title1">Fixed Assets Details</h3>

					<div class="widget-shadow">
						<ul id="myTabs" class="nav nav-tabs" role="tablist">

							<? if(check_access('fixed_asset')){?> <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New Asset</a></li>
						<? }?><li role="presentation"  <? if(check_access('fixed_asset')){?>class=""<? }else {?>class="active"<? }?>>
							<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Fixed Assets List</a></li>
						</ul>
						<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

							<div role="tabpanel" class="tab-pane fade   <? if(check_access('fixed_asset')){?><? }else {?>active in<? }?>" id="home" aria-labelledby="home-tab" >
								<br>
								<? if($this->session->flashdata('msg')){?>
									<div class="alert alert-success" role="alert">
										<?=$this->session->flashdata('msg')?>
									</div><? }?>
									<? if($this->session->flashdata('error')){?>
										<div class="alert alert-danger" role="alert">
											<?=$this->session->flashdata('error')?>
										</div><? }?>

										<div class=" widget-shadow bs-example" data-example-id="contextual-table" >

											<table class="table"> <thead> <tr> <th>Asset Code</th><th>Asset Name</th> <th>Asset Category</th><th>Sub Asset Category</th> <th>Asset Value</th> <th>Year</th><th>Remarks</th> <th>Status</th><th></th></tr> </thead>
												<tbody>
													<? foreach ($assets as $key => $value) {?>
														<tr> <th><?=$value->asset_code;?></th>
															<th><?=$value->asset_name;?></th> <th>
																<?
																if($value->category_id!=""){echo $category_name[$value->category_id]->asset_category;}
																?>
															</th>

															<th>
																<?
																if($value->sub_cat_id!=""){echo $subcategory_name[$value->sub_cat_id]->sub_cat_name;}
																?>
															</th>
															<th class="text-right"><?=number_format($value->asset_value,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th> <th><?=date('Y', strtotime($value->year));?></th>
															<th><center><a  href="javascript:view_remarks('<?=$value->id;?>')" title="View"><i class="fa fa-plus-square nav_icon icon_blue"></i></a></center></th>
															<th><?
															if($value->statues=='PENDING'){?>
																<a  href="javascript:check_activeflag('<?=$value->id;?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
																<a  href="javascript:call_delete('<?=$value->id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
																<? $CI =& get_instance();
																$user_role = $CI->session->userdata('usertype');
																if(check_access('confirm_fixed_asset')){?>
																<a  href="javascript:call_confirm('<?=$value->id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
																<?}}else{ echo $value->statues; }?>
																</th>

															</tr>
														<? }?>
													</tbody></table>
													<div id="pagination-container"></div>
												</div>
											</div>
											<? if(check_access('fixed_asset')){?>
												<div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
													<p>	  <? if($this->session->flashdata('msg')){?>
														<div class="alert alert-success" role="alert">
															<?=$this->session->flashdata('msg')?>
														</div><? }?>
														<? if($this->session->flashdata('error')){?>
															<div class="alert alert-danger" role="alert">
																<?=$this->session->flashdata('error')?>
															</div><? }?>

															<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/add_asset" enctype="multipart/form-data">
																<div class="row">
																	<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
																		<div class="form-title">
																			<h4>Asset Details</h4>
																		</div>
																		<div class="form-body">
																			<div class="form-group has-feedback"  id="branch">
																				<select name="branch_code" id="branch_code" class="form-control" placeholder="Branch" required>
																					<option value="">--Select Branch--</option>

																					<?
																					foreach ($branches as $key => $value) {?>
																						<option value="<?=$value->branch_code?>"><?=$value->branch_name?></option>
																						<?
																					}
																					?>

																				</select>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback"  id="division">
																				<select name="division_code" id="division_code" class="form-control" placeholder="Division" required>
																					<option value="">--Select Division--</option>

																					<?
																					foreach ($division as $key => $value) {?>
																						<option value="<?=$value->id?>"><?=$value->division_name?></option>
																						<?
																					}
																					?>

																				</select>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback"  id="asset_type">
																				<select name="asset_cat" id="asset_cat" class="form-control" placeholder="Asset Type" required>
																					<option value="">--Select Asset Category--</option>

																					<?
																					foreach ($categories as $key => $value) {?>
																						<option value="<?=$value->id?>"><?=$value->asset_category?></option>
																						<?
																					}
																					?>

																				</select>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback"  id="asset_type">
																				<select name="assetsub_cat" id="assetsub_cat" class="form-control" placeholder="Asset Type" required>
																					<option value="">--Select Sub Asset Category--</option>

																				</select>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback">
																				<input type="text" class="form-control" name="asset_code" id="asset_code" placeholder="Asset Code" data-error="" required>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback">
																				<input type="text" class="form-control" name="asset_name" id="asset_name" placeholder="Asset Name" data-error="" required>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback">
																				<input type="text" class="form-control" name="asset_brand" id="asset_brand" placeholder="Asset Brand" data-error="" required>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback">
																				<input type="text" class="form-control" name="serial_no" id="serial_no" placeholder="Serial Number" data-error="" required>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback">
																				<input type="text" class="form-control" name="asset_val" id="asset_val" placeholder="Asset Value" data-error="" required>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>

																			<!--
																			<div class="form-group">
																			<input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" data-error="">
																			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																			<span class="help-block with-errors" ></span>
																		</div>
																	-->
																	<div class="form-group">
																		<input type="date" class="form-control" name="year" id="year" placeholder="Year" data-error="">
																	</div>
																	<div class="form-group has-feedback"  id="user">
																		<select name="user_code" id="user_code" class="form-control" placeholder="User" required>
																			<option value="">--Select User--</option>

																			<?
																			foreach ($employees as $key => $value) {?>
																				<option value="<?=$value->id?>"><?=$value->initial?> <?=$value->surname?></option>
																				<?
																			}
																			?>

																		</select>
																		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																		<span class="help-block with-errors" ></span>
																	</div>
																	<div class="form-group has-feedback"  id="asset_type">
																		<select name="purchase" id="purchase" class="form-control" placeholder="Purchase Type" required>
																			<option value="">--Select Purchase Method--</option>
																			<option value="Credit">Purchase By Credit</option>
																			<option value="Cash">Purchase by Cash</option>
																			<option value="Lease">Purchase by Lease</option>

																		</select>
																		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																		<span class="help-block with-errors" ></span>
																	</div>
																	<div class="form-group">
																		<textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" data-error=""></textarea>
																	</div>
																	<div class="form-group has-feedback">
																		Attachments<input type="file" class="form-control" name="asset_attach" id="asset_attach" placeholder="Attachments" data-error="">
																		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																		<span class="help-block with-errors" ></span>
																	</div>
																	<div class="bottom validation-grids">

																		<div class="form-group">
																			<button type="submit" class="btn btn-primary disabled">Submit</button>
																		</div>
																		<div class="clearfix"> </div>
																	</div>
																</div>
															</div>


														</div>
														<div class="clearfix"> </div>
														<br>

													</form></p>
												</div>
											<? }?>
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
										window.location="<?=base_url()?>accounts/Fixedasset/delete/"+document.deletekeyform.deletekey.value;
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

	                    window.location="<?=base_url()?>accounts/Fixedasset/confirm/"+document.deletekeyform.deletekey.value;
	                },
	                cancel: function(button) {
	                    button.fadeOut(2000).fadeIn(2000);
	                   // alert("You aborted the operation.");
	                },
	                confirmButton: "Yes I am",
	                cancelButton: "No"
	            });

$(document).ready(function(){

	$( "#asset_cat" ).change(function() {
	var id=$( "#asset_cat" ).val();
	$( "#assetsub_cat option" ).remove();
		$.ajax({
			headers: {
				Accept: 'application/json'
			},
			type: 'post',
			url: '<?=base_url()?>accounts/Fixedasset/sub_asset_data',
			data: {id: id},
			dataType: "json",
						success: function(result){
							$( "#assetsub_cat" ).append('<option value="">--Select Sub Asset Category--</option>');
							jQuery.each(result, function(index, item) {

								$( "#assetsub_cat" ).append('<option value="'+item.sub_cat_id+'">'+item.sub_cat_name+'-'+item.sub_cat_code+'</option>');

						});
						},
						error: function() {
							$( "#assetsub_cat" ).append('<option></option>');

						}

				});
	});

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
