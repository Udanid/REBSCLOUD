<!DOCTYPE HTML>
<html>
<head>

	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
	?>
	<script src="<?=base_url()?>media/js/jquery.confirm.js"></script>
<script>
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



					<h3 class="title1">Fixed Assets Disposal</h3>

					<div class="widget-shadow">
						<ul id="myTabs" class="nav nav-tabs" role="tablist">

							<? if(check_access('fixed_asset')){?> <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Asset Disposal</a></li>
						<? }?>
						<? if(check_access('fixed_asset')){?> <li role="list"  class=""><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Disposal List</a></li>
					<? }?>
					</ul>
						<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

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

															<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/disposal_asset" enctype="multipart/form-data">
																<div class="row">
																	<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
																		<div class="form-title">
																			<h4>Asset Details</h4>
																		</div>
																		<div class="form-body">
																			<div class="form-group has-feedback"  id="branch">
																				<select name="disposal_id" id="disposal_id" class="form-control" placeholder="Branch" required>
																					<option value="">--Select Asset--</option>
																					<? foreach ($assets as $key => $value) {?>
																						<option value="<?=$value->id?>"><?=$value->asset_code?><?=$value->asset_name?></option>
																						<?
																					}
																					?>

																				</select>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback"  id="branch">
																				<input type='text' name="disposal_value" id="disposal_value" class="form-control" placeholder="Disposal Value" required>

																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>

																	<div class="bottom validation-grids">

																		<div class="form-group">
																			<button type="submit" class="btn btn-primary disabled">Disposal</button>
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
											<? if(check_access('fixed_asset')){?>
												<div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">
													<p>	  <? if($this->session->flashdata('msg')){?>
														<div class="alert alert-success" role="alert">
															<?=$this->session->flashdata('msg')?>
														</div><? }?>
														<? if($this->session->flashdata('error')){?>
															<div class="alert alert-danger" role="alert">
																<?=$this->session->flashdata('error')?>
															</div><? }?>

															</p>

															<table class="table"> <thead> <tr> <th>Asset Code</th><th>Asset Name</th> <th>Asset Category</th><th>Sub Asset Category</th> <th>Asset Value</th><th>Disposal Value</th> <th>Year</th><th>Remarks</th> <th>Status</th><th></th></tr> </thead>
																<tbody>
																	<? foreach ($dispo_assets as $key => $value) {?>
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
																			<th class="text-right"><?=number_format($value->asset_value,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
																			<th class="text-right"><?=number_format($value->disposal_value,2);?>&nbsp;&nbsp;&nbsp;&nbsp;</th><th><?=date('Y', strtotime($value->year));?></th>
																			<th><center><a  href="javascript:view_remarks('<?=$value->id;?>')" title="View"><i class="fa fa-plus-square nav_icon icon_blue"></i></a></center></th>
																			<th><?
																			if($value->statues=='DISPOSAL PENDING'){?>
																				<a  href="javascript:call_delete('<?=$value->id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
																				<? $CI =& get_instance();
																				$user_role = $CI->session->userdata('usertype');
																				 if (  check_access('confirm_disposal')) {?>
																				<a  href="javascript:call_confirm('<?=$value->id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
																				<?}}else if($value->statues=='DISPOSAL'){
																					?>
																					DISPOSAL
																					<?}else{
																						?>
																						<?}?>
																				</th>

																			</tr>
																		<? }?>
																	</tbody></table>
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
										window.location="<?=base_url()?>accounts/Fixedasset/delete_disposal/"+document.deletekeyform.deletekey.value;
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

	                    window.location="<?=base_url()?>accounts/Fixedasset/confirm_disposal/"+document.deletekeyform.deletekey.value;
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
