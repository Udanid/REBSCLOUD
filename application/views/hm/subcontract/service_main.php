
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
		$('.task_id').chosen({});
		$(".lot_id").focus(function() {
			$(".lot_id").chosen({
				allow_single_deselect : true
			});
		});
		$("#supplier_id").focus(function() {
			$("#supplier_id").chosen({
				allow_single_deselect : true
			});
		});
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
			$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
		} );
	});


	function loadcurrent_block(id,change)
	{
	 //$('#fulldata').show();
	 //alert(change)
	 id=$('#prj_id').val();
	 var lotview=$("#lotviewcount").val();
	 var new_lotview=parseInt(lotview)+1;
	 $("#lotviewcount").val(new_lotview);

	 if(change=='1'){
		 new_lotview=1;
		 $('#blocklist').html('');
	 }
	 $("#lotviewcount").val(new_lotview);
	 $('#blocklist').append('<div class="row" id="blocklist'+new_lotview+'"></div>');
	 if(id!=""){

		 $('#blocklist'+new_lotview).delay(1).fadeIn(600);
		 document.getElementById("blocklist"+new_lotview).innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		 $( "#blocklist"+new_lotview).load( "<?=base_url()?>hm/hm_subcontract/get_blocklist/"+id+"/"+new_lotview);


	 }
	 else
	 {
		 document.getElementById("checkflagmessage").innerHTML='Please Select Project';
    $('#flagchertbtn').click();
		 $('#blocklist'+new_lotview).delay(1).fadeOut(600);

	 }
	}
	function load_sub_cat(id,viewlotid,change)
	{
		id=$("#lot_id"+viewlotid).val();
	  var subcatview=$("#subcatviewcount"+viewlotid).val();
	  var new_subcatview=parseInt(subcatview)+1;

	  if(change=='1'){
	    new_subcatview=1;
	    $('#lotsubcatlist'+viewlotid).html('');
	  }
	  $("#subcatviewcount"+viewlotid).val(new_subcatview);
	  if(id!=""){
	    $('#lotsubcatlist'+viewlotid).append('<div class="row" id="subcatlist'+viewlotid+new_subcatview+'"></div>');
	   $('#subcatlist'+viewlotid+new_subcatview).delay(1).fadeIn(600);
	   document.getElementById("subcatlist"+viewlotid+new_subcatview).innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
	   $( "#subcatlist"+viewlotid+new_subcatview).load( "<?=base_url()?>hm/hm_subcontract/get_category_list/"+id+"/"+viewlotid+"/"+new_subcatview);

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
</script>

<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">



			<h3 class="title1">New Subcontract</h3>

			<div class="widget-shadow">
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation"  class="active"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Subcontract</a></li>
					<li role="presentation" ><a href="#list" role="tab" id="list-tab" data-toggle="tab" aria-controls="list" aria-expanded="true">Subcontract List</a></li>

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

							<form data-toggle="validator" id="sucontracform" method="post" action="<?=base_url()?>hm/hm_subcontract/add_subcontract" enctype="multipart/form-data">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<div class="form-title">
											<h4>New Subcontract</h4>
										</div>
										<div class="form-body form-horizontal">

											<div class="form-group">
												<!--service div start-->
												<label class=" control-label col-sm-3 " >Service Type</label>
												<div class="col-sm-3 ">
													<select name='service_id' id='service_id' class='form-control' required='required' >
														<option value=''> Select Service</option >
															<? if($services){
																foreach($services as $dataraw){?>
																	<option value='<?=$dataraw->service_id?>'><?=$dataraw->service_name?></option>
																<? }}?>
															</select>
														</div>
														<!--service div end-->

														<!--supplier div start-->
														<label class=" control-label col-sm-3 " >Supplier Name</label>
														<div class="col-sm-3 ">
															<select name='supplier_id' id='supplier_id' class='form-control' required='required' >
																<option value=''> Select Supplier</option ><? if($suplist){foreach($suplist as $dataraw){?>
																	<option value='<?=$dataraw->sup_code?>'><?=$dataraw->first_name?> - <?=$dataraw->last_name?></option><? }}?></select>
																</div>
																<!--service div end-->


															</div>
															<div class="form-group">
																<!--Contract start date div start-->
																<label class=" control-label col-sm-3 " > Contract Start Date</label>
																<div class="col-sm-3 ">
																	<input type='text' class='form-control date' id='date'    name='date' required='required'>
																</div>
																<!--Contract start date div end-->

																<!--Contract Period div start-->
																<label class=" control-label col-sm-3 " > Contract Period</label>
																<div class="col-sm-3 ">
																	<input type='text' class='form-control' id='con_period'    name='con_period' required='required'>
																</div>
																<!--Contract Period div start-->
															</div>

															<div class="form-group">
																<!-- Agreed Amount div start-->
																<label class=" control-label col-sm-3 " >Agreed Amount</label>
																<div class="col-sm-3 ">
																	<input type='number' step="0.01" class='form-control' id='agreed_amount'    name='agreed_amount' required='required'>
																</div>
																<!-- Agreed Amount div end-->

																<!--Mobilization Charges div start-->
																<label class=" control-label col-sm-3 " > Mobilization Charges</label>
																<div class="col-sm-3 ">
																	<input type='number' step="0.01" class='form-control' id='mob_charge'    name='mob_charge' required='required'>
																</div>
																<!--Mobilization Charges div start-->
															</div>

															<div class="form-group">
																<!-- Retaining Rate div start-->
																<label class=" control-label col-sm-3 " >Retaining Rate</label>
																<div class="col-sm-3 ">
																	<input type='text' class='form-control' id='retain_rate'    name='retain_rate' required='required'>
																</div>
																<!-- Retaining Rate div end-->

																<!--Retaining Period div start-->
																<label class=" control-label col-sm-3 " > Retaining Period</label>
																<div class="col-sm-3 ">
																	<input type='text' class='form-control' id='retain_period'    name='retain_period' required='required'>
																</div>
																<!--Retaining Period div start-->
															</div>
															<div class="form-group">
																<!-- Project div start-->
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
																 <div class="col-sm-2 ">
																	 <a href="javascript:loadcurrent_block('','2')" title="Add New Lot"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
																	 Add More Lot
																 </div>
																<!-- Project div end-->

															</div>
															<div class="form-group">
															<label class=" control-label col-sm-3 " >Agreement Copy</label>
															<div class="row" style="margin-top:5px;">
															<div class="col-sm-3">

																			<span id="addfile3" class="btn btn-success fileinput-button" style="width:25%;">
																					<i class="glyphicon glyphicon-plus"></i>
																					<span>Add</span>
																					<!-- The file input field used as target for the file upload widget -->
																					<input id="fileupload3" type="file" name="files">
																					<input type="hidden" name="agreement_copy" id="agreement_copy">
																					<div id="upfiles3" class="upfiles3"></div>
																			</span>

																			<!-- The global progress bar -->
																			<div id="progress3" class="progress">
																					<div class="progress-bar progress-bar-success"></div>
																			</div>
																			<!-- The container for the uploaded files -->
																			<div id="files3" class="files" style="width:25%;"></div>
															</div>
															</div>
															</div>
															</div>



																		<div id="blocklist">
																			<!-- load blocks-->

																		</div>




																</hr>
																	<div class=" widget-shadow" data-example-id="basic-forms">

															<div ><button type="submit" id="confirm-but" class="btn btn-primary disabled pull-right" >Add Subcontract</button>
															</br></br></br></div>
														</div>
													</div>
												</div>
												</p>
												</form>
											</div>



							<div role="tabpanel" class="tab-pane fade" id="list" aria-labelledby="list-tab">
								<div class="row">
									<div class=" widget-shadow" data-example-id="basic-forms">
										<table class="table">
											<thead>
												<tr>
													<th>No</th>
													<th>Service</th>
													<th>Supplier</th>
													<th>Start Date</th>
													<th>Period</th>
													<th>Agreed Amount</th>
													<th>Mobilization Charges</th>
													<th>Retaining Period</th>
													<th>Retaining Rate</th>
													<th>Project</th>
												</tr>
											</thead>
										</tbody>
										<? if($datalist){ $c=0;
											foreach ($datalist as $key => $value) {

												?>
												<tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
													<td><?=$c?></td>
													<td><?=$value->service_name?></td>
													<td><?=$value->sup_code?> - <?=$value->first_name?> <?=$value->last_name?></td>
													<td><?=$value->project_name?></td>
													<td><?=$value->lot_id?></td>
													<td align="right"><?=number_format($value->agreed_amount,2)?></td>
													<td align="right"><?=number_format($value->mobilization_charge,2)?></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$value->retaining_period?></td>
													<td><?=$value->retaining_rate?></td>
													<td>
														<? if($unit_data[$value->contract_id]){?>
															<table class="table">
															<?
															foreach ($unit_data[$value->contract_id] as $key2 => $value2) {?>
																<tr>
																	<td>
																		<?=$value2->project_name?> - <?=$value2->lot_number?>
																	</td>
																	<td>
																		<a  href="javascript:viewsubcontract('<?=$value->contract_id?>','<?=$value2->lot_id?>','<?=$value2->id?>')" title="Sub Contract View"><i class="fa fa-eye nav_icon icon_green"></i></a>
																	</td>
																</tr>
															<?}?>
														</table>
														<?
														}?>
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
				<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_advdelete" name="complexConfirm_advdelete"  value="DELETE"></button>

				<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm_deed" name="complexConfirm_confirm_deed"  value="DELETE"></button>

				<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
				<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
				<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
				</form>
				<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
			



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
