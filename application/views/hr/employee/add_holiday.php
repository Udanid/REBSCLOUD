
<!DOCTYPE HTML>
<html>
<head>
	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
	?>
	<script>
	$(document).ready(function(){
    $( "#holiday_date" ).datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,
    changeYear: true,
    showButtonPanel: true});


	});
	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
		$('#complexConfirm').click();
	}
</script>
<!-- //header-ends -->
<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div class="table">
			<h3 class="title1">Add Calender</h3>
			<div class="widget-shadow">
				<div class="  widget-shadow" data-example-id="basic-forms">
					<div class="clearfix"> </div>
					<ul id="myTabs" class="nav nav-tabs" role="tablist">
						<li role="presentation"   class="active" >
							<a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Add holidays</a></li>
							<li role="presentation">
								<a href="#holiday" id="budget-tab" role="tab" data-toggle="tab" aria-controls="holiday" aria-expanded="false">Holidays list</a></li>
							</ul>

							<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
								<div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab">
									<? if($this->session->flashdata('msg')){?>
										<div class="alert alert-success" role="alert">
											<?=$this->session->flashdata('msg')?>
										</div><? }?>
										<? if($this->session->flashdata('error')){?>
											<div class="alert alert-danger" role="alert">
												<?=$this->session->flashdata('error')?>
											</div><? }?>
											<div class="row">
											<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">

												<div class="form-title">
													<h4>Add Holidays</h4>

												</div>
									<form data-toggle="validator" method="post" action="<?=base_url()?>hr/employee/holidays_add" enctype="multipart/form-data">


															<div class="form-body">
																<div class="form-group">
																	<label>Date</label>
																	<input class="form-control" type="text" name="holiday_date" id="holiday_date" value="" required style="z-index: 100">
																</div>
																<div class="form-group">
																	<label>Reason</label>
																	<input class="form-control" type="text" name="reason" id="reason" value="" required>
																</div>
															</div>
															<div class="form-body">

																<div class="form-group">
																	<button type="submit" name="holidays" id="holidays" class="btn btn-primary">Submit</button>
																</div>
																<div class="clearfix"> </div>
															</div>


													</form>
													</div>

										</div>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="holiday" aria-labelledby="holiday-tab">
											<div class="  widget-shadow" data-example-id="basic-forms">
												<table class="table">
													<thead>
														<tr>
															<th>No</th>
															<th>Date</th>
															<th>Reason</th>
															<th>Delete</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$i=0;
														if($holidays){
															foreach ($holidays as $key => $value) {
																$i=$i+1;
																?>
																<tr>
																	<td><?=$i;?></td>
																	<td><?=$value->holiday_date;?></td>
																	<td><?=$value->holiday_reason;?></td>
																	<td>	<?php if($value->holiday_date>date('Y-m-d')){?><a  href="javascript:call_delete('<?=$value->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
																	<?php }?></td>
																</tr>

															<?php }	}?>
														</tbody>
													</table>
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
						<script>

						$("#complexConfirm").confirm({
							title:"Delete confirmation",
							text: "Are You sure you want to delete this ?" ,
							headerClass:"modal-header",
							confirm: function(button) {
								button.fadeOut(2000).fadeIn(2000);
								var code=1
								window.location="<?=base_url()?>hr/employee/holiday_delete/"+document.deletekeyform.deletekey.value;
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
