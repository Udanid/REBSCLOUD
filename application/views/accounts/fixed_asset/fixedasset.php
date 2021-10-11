
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
		$( "#popupform" ).load( "<?=base_url()?>accounts/Fixedasset/edit_category/"+id );

	}
	function close_edit(id)
	{

		// var vendor_no = src.value;
		//alert(id);

		$.ajax({
			cache: false,
			type: 'GET',
			url: '<?php echo base_url().'common/delete_activflag/';?>',
			data: {table: 'cm_supplierms', id: id,fieldname:'sup_code' },
			success: function(data) {
				if (data) {
					$('#popupform').delay(1).fadeOut(800);

					//document.getElementById('mylistkkk').style.display='block';
				}
				else
				{
					document.getElementById("checkflagmessage").innerHTML='Unagle to Close Active session. Please Contact System Admin ';
					$('#flagchertbtn').click();

				}
			}
		});
	}
	var deleteid="";
	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
		$.ajax({
			cache: false,
			type: 'GET',
			url: '<?php echo base_url().'common/activeflag_cheker/';?>',
			data: {table: 'cm_supplierms', id: id,fieldname:'sup_code' },
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
			data: {table: 'cm_supplierms', id: id,fieldname:'sup_code' },
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



					<h3 class="title1">Fixed Assets Category Details</h3>

					<div class="widget-shadow">
						<ul id="myTabs" class="nav nav-tabs" role="tablist">

							<? if(check_access('fixed_asset')){?> <li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add New Fixed Asset Category</a></li>
						<? }?><? if(check_access('fixed_asset')){?> <li role="presentation"  class=""><a href="#sub_category" role="tab" id="sub_category-tab" data-toggle="tab" aria-controls="sub_category" aria-expanded="true">Add Sub Asset Category</a></li>
					<? }?><li role="presentation"  <? if(check_access('fixed_asset')){?>class=""<? }else {?>class="active"<? }?>>
							<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Fixed Assets Category List</a></li>
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

											<table class="table"> <thead> <tr> <th>Asset category</th> <th>Depreciation Presantage</th> <th>Leger Account </th> <th>Depreciation Account</th> <th>Edit</th><th></th></tr> </thead>
												<tbody>
													<? foreach ($asset_cat_data as $key => $value) {?>
														<?
														$leger_id='';$leger_name='';$depre_acc_id='';$depre_acc_name='';$provi_acc_id='';$provi_acc_name='';$dispo_acc_id='';$dispo_acc_name='';
														if($value->leger_acc){
															$leger_id=$leger_acc[$value->leger_acc]->id;
															$leger_name=$leger_acc[$value->leger_acc]->name;
														}
														if($value->depreciation_acc){
															$depre_acc_id=$depre_acc[$value->depreciation_acc]->id;
															$depre_acc_name=$depre_acc[$value->depreciation_acc]->name;
														}
														if($value->provision_acc){
															$provi_acc_id=$provi_acc[$value->provision_acc]->id;
															$provi_acc_name=$provi_acc[$value->provision_acc]->name;
														}
														if($value->disposal_acc){
															$dispo_acc_id=$dispo_acc[$value->disposal_acc]->id;
															$dispo_acc_name=$dispo_acc[$value->disposal_acc]->name;
														}

														?>
														<tr> <th><?=$value->asset_category;?></th> <th><center><?=$value->depreciation_presantage;?>%</center></th> <th><?=$leger_id;?>-<?=$leger_name;?></th> <th><?=$depre_acc_id;?>-<?=$depre_acc_name;?></th>
															<th><a  href="javascript:check_activeflag('<?=$value->id;?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a></th></tr>
														<? }?>
													</tbody></table>
													<div id="pagination-container"></div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="sub_category" aria-labelledby="sub_category-tab" >
												<div class=" widget-shadow bs-example" data-example-id="contextual-table" >
													<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/addSub_cat" enctype="multipart/form-data">
														<div class="row">
															<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
																<div class="form-title">
																	<h4>Sub Category Details</h4>
																</div>
																<div class="form-body">
																	<div class="form-group has-feedback"  id="asset_type">
																		<select name="assetcat_type" id="assetcat_type" class="form-control" placeholder="Asset Type" required>
																			<option value="">--Select Asset Category--</option>
																			<? foreach ($asset_cat_data as $key => $value) {?>
																				<option value="<?=$value->id;?>"><?=$value->asset_category;?></option>
																			<? }?>
																		</select>
																	</div>
																	<div class="form-group has-feedback">
																		<input type="text" class="form-control" name="assetsub_cat_name" id="assetsub_cat_name" placeholder="Sub asset category name" data-error="" required>
																		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																		<span class="help-block with-errors" ></span>
																	</div>
																	<div class="form-group has-feedback">
																		<input type="text" class="form-control" name="assetsub_cat_code" id="assetsub_cat_code" placeholder="Sub asset category code" data-error="" required>
																		<input type="hidden" class="form-control" name="hiddensub_cat_code" id="hiddensub_cat_code" placeholder="Asset category name" data-error="">
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
																</form>
															</br></br></br>
																<table class="table" id="subassaet_table">
																	<thead>
																	<tr><th></th><th>Sub Asset Name</th><th>Sub Asset code</th>
																	</tr>
																</thead>
																		<tbody>
																	</tbody>
																</table>
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

															<form data-toggle="validator" method="post" action="<?=base_url()?>accounts/Fixedasset/add" enctype="multipart/form-data">
																<div class="row">
																	<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
																		<div class="form-title">
																			<h4>Category Details</h4>
																		</div>
																		<div class="form-body">
																			<div class="form-group has-feedback"  id="asset_type">
																				<select name="asset_type" id="asset_type" class="form-control" placeholder="Asset Type" required>
																					<option value="">--Select Asset Type--</option>
																					<option value="0">Fixed Asset</option>
																					<option value="1">Intangible Asset</option>


																				</select>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group has-feedback">
																				<input type="text" class="form-control" name="asset_cat_name" id="asset_cat_name" placeholder="Asset category name" data-error="" required>
																				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																				<span class="help-block with-errors" ></span>
																			</div>
																			<div class="form-group">
																				<input type="number" class="form-control" name="dep_presantage" id="dep_presantage" placeholder="Asset depreciation precentage" data-error="">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-6 validation-grids validation-grids-right">
																		<div class="widget-shadow" data-example-id="basic-forms">
																			<div class="form-title">
																				<h4>Account Details:</h4>
																			</div>
																			<div class="form-body">


																				<div class="form-group has-feedback">
																					<select name="leger_acc" id="leger_acc" class="form-control" placeholder="Leger Account" required>
																						<option value="">-- Leger Account --</option>
																						<?
																						foreach ($legers as $key => $value) {?>
																							<option value="<?=$value->id?>"><?=$value->id?> - <?=$value->name?></option>
																							<?
																						}
																						?>

																					</select>
																					<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
																					<span class="help-block with-errors" ></span>
																				</div>
																				<div class="form-group">
																					<select name="depre_acc" id="depre_acc" class="form-control" placeholder="Depreciation Account" >
																						<option value="">--Depreciation Account--</option>
																						<?
																						foreach ($legers as $key => $value) {?>
																							<option value="<?=$value->id?>"><?=$value->id?> - <?=$value->name?></option>
																							<?
																						}
																						?>
																					</select>
																				</div>
																				<div class="form-group">
																					<select name="provi_acc" id="provi_acc" class="form-control" placeholder="Provision Account" >
																						<option value="">--Provision Account--</option>
																						<?
																						foreach ($legers as $key => $value) {?>
																							<option value="<?=$value->id?>"><?=$value->id?> - <?=$value->name?></option>
																							<?
																						}
																						?>
																					</select>
																				</div>
																				<div class="form-group">
																					<select name="dispo_acc" id="dispo_acc" class="form-control" placeholder="Disposal Account" >
																						<option value="">--Disposal Account--</option>
																						<?
																						foreach ($legers as $key => $value) {?>
																							<option value="<?=$value->id?>"><?=$value->id?> - <?=$value->name?></option>
																							<?
																						}
																						?>
																					</select>
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

										$(document).ready(function(){

										  $( "#assetcat_type" ).change(function() {
										  var id=$( "#assetcat_type" ).val();
											$( "#subassaet_table tbody tr" ).remove();
										    $.ajax({
										      headers: {
										        Accept: 'application/json'
										      },
										      type: 'post',
										      url: '<?=base_url()?>accounts/Fixedasset/sub_asset_data',
										      data: {id: id},
										      dataType: "json",
										            success: function(result){

										              jQuery.each(result, function(index, item) {

										                $( "#subassaet_table tbody" ).append('<tr><th></th><th>'+item.sub_cat_name+'</th><th>'+item.sub_cat_code+'</th></tr>');

										            });
										            },
										            error: function() {
																	$( "#subassaet_table tbody" ).append('<tr><th></th><th></th><th></th></tr>');

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
