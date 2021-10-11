
<!DOCTYPE HTML>
<html>
<head>
	<?
	$this->load->view("includes/header_".$this->session->userdata('usermodule'));
	$this->load->view("includes/topbar_normal");
	?>
	<script>
	$(document).ready(function(){
    $( "#review_date" ).datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,
    changeYear: true,
    showButtonPanel: true});
		$("#nextreview_date").datepicker({dateFormat: 'yy-mm-dd',changeMonth: true,
    changeYear: true,
    showButtonPanel: true});


	});
	function call_delete(id)
	{
		document.deletekeyform.deletekey.value=id;
		$('#complexConfirm').click();
	}

	function call_view(id,emp_no)
	{
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/employee/view_appraisal_marks/"+id );

	}
	function call_print(app_id)//export excel for sales register. ticket number 496
{

	window.open( "<?=base_url()?>hr/employee/employee_appraisal_print/"+app_id);
}
function emp_comment(app_id,emp_no)
{
	$('#popupform').delay(1).fadeIn(600);
	$('#popupform').load("<?php echo base_url();?>hr/employee/emp_appraisal_comment/"+app_id );

}
function close_edit(id)
{
	$('#popupform').delay(1).fadeOut(800);

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
			<h3 class="title1">Employee Appraisal</h3>
			<div class="widget-shadow">
				<div class="  widget-shadow" data-example-id="basic-forms">
					<div class="clearfix"> </div>
					<ul id="myTabs" class="nav nav-tabs" role="tablist">
						<li role="presentation"   class="active" >
							<a href="#main" role="tab" id="main-tab" data-toggle="tab" aria-controls="main" aria-expanded="true">Add Employee Appraisal</a></li>
							<li role="presentation">
								<a href="#holiday" id="budget-tab" role="tab" data-toggle="tab" aria-controls="holiday" aria-expanded="false">Employee Appraisal List</a></li>
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
											<div class="col-md-12 widget-shadow" data-example-id="basic-forms">

												<div class="form-title">
													<h4>Employee Appraisal</h4>

												</div>
									<form data-toggle="validator" method="post" action="<?=base_url()?>hr/employee/add_employee_appraisal" enctype="multipart/form-data">


															<div class="form-body">
																<div class="form-group has-feedback col-md-6" id="emp_id_div">
 							 								<label for="emp_id" class="control-label">Select Employee</label>
 							 								<select class="form-control" id="emp_id" name="emp_id" onChange="load_employment_details(this.value);" required>
 							 								  <option value="">--Select Employee--</option>
 							 								  <?php
 							 								  foreach($employee_list as $employee_list_row){
 							 									if($employee_list_row->status == "A" && $employee_list_row->salary_confirmation == "Y"){ ?>
 							 										<option value="<?php echo $employee_list_row->id; ?>"><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->initial.' '.$employee_list_row->surname; ?></option>
 							 									<?php
 							 									}
 							 								  } ?>
 							 								</select>
 							 								<span class="help-block with-errors" ></span>
 							 							  </div>
															<div class="form-group col-md-6">
																<label>Review Date</label>
																<input class="form-control" type="text" name="review_date" id="review_date" value="<?=date('Y-m-d')?>" required style="z-index: 100">
															</div>
															<div class="col-md-6 validation-grids validation-grids-right">
															 <div class="" data-example-id="basic-forms">
															 <div class="form-body">
																 <div class="form-group has-feedback" id="surname_div">
																 <label for="surname" class="control-label" >Name</label>
																 <input type="text" class="form-control" id="surname" name="surname" value="" placeholder="Name" readonly>
															 </div>

															 <div class="form-group has-feedback" id="branch_div">
																 <label for="branch" class="control-label">EPF No</label>
																 <input type="text" class="form-control" id="epf_no" name="epf_no" value="" placeholder="EPF No" readonly>
															 </div>

															 <div class="form-group has-feedback" id="designation_div">
																 <label for="designation" class="control-label">Current Salary</label>
																 <input type="text" class="form-control" id="basic_salary" name="basic_salary" value="" placeholder="Current Salary" readonly>
															 </div>
															 </div>
														 </div>
														 </div>

														 <div class="col-md-6 validation-grids validation-grids-left">
															 <div class="" data-example-id="basic-forms">
															 <div class="form-body">
																 <div class="form-group" id="nic_no_div">
																 <label for="nic_no" class="control-label">NIC</label>
																 <input type="text" class="form-control" id="nic_no" name="nic_no" value="" placeholder="NIC" readonly>
															 </div>

															 <div class="form-group" id="division_div">
																 <label for="division" class="control-label">Position</label>
																 <input type="text" class="form-control" id="designation" name="designation" value="" placeholder="Division" readonly>
																 <input type="hidden" class="form-control" id="designation_id" name="designation_id" value="" placeholder="Division" readonly>
															 </div>

															 <div class="form-group">
 																<label>Next Review Date</label>
 																<input class="form-control" type="text" name="nextreview_date" id="nextreview_date" value="" placeholder="YYYY-MM-DD" required>
 															</div>
														 </div>
														 </div>
															</div>
															<table class="table">
																<tr>
																<th>Performance Category</th>
																<th>Scores</th>
																<th>Remarks</th>
															</tr>
															<? if($category){
																foreach ($category as $key => $value) {?>
																	<tr>
																	<td><?=$value->performance_category;?></td>
																	<td>
																		<input class="form-control" type="text" name="scorefor<?=$value->id?>" id="scorefor<?=$value->id?>" value="" placeholder="Score" required>
	 																</td>
																	<td>
																		<input class="form-control" type="text" name="remark<?=$value->id?>" id="remark<?=$value->id?>" value="" placeholder="Remark" required>
	 																</td>
																</tr>
														<?		}
															}?>
														</table>
														<div class="form-group">
														 <label>Future Goals Discussed:</label>
														 <textarea class="form-control" type="text" name="future_gols" id="future_gols" required></textarea>
													 </div>
													 <div class="form-group">
													 <label>Supervisor / Appraiser Comments: </label>
													 <textarea class="form-control" type="text" name="appraiser_comment" id="appraiser_comment" required></textarea>
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
										</div>
										<div role="tabpanel" class="tab-pane fade" id="holiday" aria-labelledby="holiday-tab">
											<div class="row">
											<div class="  widget-shadow" data-example-id="basic-forms">
												<table class="table">
													<thead>
														<tr>
															<td>No</td>
															<th>Employee No</th>
															<th>Employee Name</th>
															<th>Review Date</th>
															<th>Employee Position</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<? if($appraisal_data){ $i=0;?>
															<?php foreach ($appraisal_data as $key => $value){ $i=$i+1;?>
																<tr>
																	<td><?=$i?></td>
																	<td><?=$value->epf_no?></td>
																	<td><?=$value->initial?> <?=$value->surname?></td>
																	<td><?=$value->review_date?></td>
																	<td><?=$value->designation?></td>
																	<td>
																<a href="javascript:call_view('<?php echo $value->id;?>', '<?php echo $value->emp_no;?>')" title="View"><i class="fa fa-eye nav_icon icon_blue"></i></a>
																<a  href="javascript:call_print('<?=$value->id?>')" title="Print"><i class="blue-300 fa fa-print nav_icon"></i></a>

																<?php

															 if($value->statues == "Pending"){ ?>
																 <a href="javascript:call_delete('<?php echo $value->id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
																 <a href="javascript:call_confirm('<?php echo $value->id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
																 <a href="javascript:emp_comment('<?php echo $value->id;?>', '<?php echo $value->emp_no;?>')" title="Comments"><i class="fa fa-comments-o nav_icon icon_green"></i></a>

															 <?php
															 }
															 ?>
														 </td>
															 </tr>
													<?	}}?>

														</tbody>
													</table>
													</div>
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
								window.location="<?=base_url()?>hr/employee/appraisal_delete/"+document.deletekeyform.deletekey.value;
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
								window.location="<?=base_url()?>hr/employee/appraisal_confirm/"+document.deletekeyform.deletekey.value;
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

				<script>

					function load_employment_details(emp_id){

						//$('input:checkbox').removeAttr('checked');
						//$('div[id^="allowance_div_"]').hide(500);
					//	document.getElementById("inputform").reset();
						$("#emp_id").val(emp_id);
						//alert(emp_id);
						var siteUrl = '<?php echo base_url(); ?>';

						if(emp_id != ''){
							$.ajax({
								cache: false,
								url: siteUrl + 'hr/employee/get_employee_details',
								type: "POST",
								async: false,
								dataType: 'json',
								data: {emp_id:emp_id},
								success: function(data) {
									$("#surname").val(data.employee_details.initial+' '+data.employee_details.surname);
									$("#nic_no").val(data.employee_details.nic_no);
									$('#epf_no').val(data.employee_details.emp_no);
									$("#designation_id").val(data.employee_details.designation);
									var siteUrl = '<?php echo base_url(); ?>';
									$.ajax({
										cache: false,
										url: siteUrl + 'hr/employee/get_employement_details',
										type: "POST",
										async: false,
										dataType: 'json',
										data: { branch:data.employee_details.branch, division:data.employee_details.division, designation:data.employee_details.designation, employment_type:data.employee_details.employment_type},
										success: function(data) {
											$("#branch").val(data.branch.branch_name);
											$("#division").val(data.division.division_name);
											$("#designation").val(data.designation.designation);
											$("#employment_type").val(data.employment_type.employment_type);

										},
										error: function(e) {
											console.log(e.responseText);
										}
									});
									$.ajax({
										cache: false,
										url: siteUrl + 'hr/emp_payroll/get_employee_salary_details',
										type: "POST",
										async: false,
										dataType: 'json',
										data: {emp_id:emp_id},
										success: function(data) {
											if(data.employee_salary == ""){
												$("#submit_type").val('insert');
												$("#salary_id").val('');
											}else{
												$("#submit_type").val('update');
												$("#salary_id").val(data.employee_salary.id);
											}

											$("#basic_salary").val(data.employee_salary.basic_salary);
											if(data.employee_salary.payee_tax == "Y"){
												$('input[name=paye]').attr('checked', true);
											}
											if(data.employee_salary.epf == "Y"){
												$('input[name=EPF]').attr('checked', true);
											}
											if(data.employee_salary.etf == "Y"){
												$('input[name=ETF]').attr('checked', true);
											}
											var i;
											for(i = 0; i < data.employee_allowances.length; i++){
										  	  //$('input[id=allowance_check_'+data.employee_allowances[i].allowance_id+']').attr("checked", true);
											  $("#allowance_check_"+data.employee_allowances[i].allowance_id).attr("checked", true);
												$("#allowance_div_"+data.employee_allowances[i].allowance_id).show(1000);
												$("#allowance_"+data.employee_allowances[i].allowance_id).val(data.employee_allowances[i].value);
												$("#allowance_"+data.employee_allowances[i].allowance_id).attr('required', true);
											}
											var j;
											for(j = 0; j < data.employee_deductions.length; j++){
										  	  $('input[id=deduction_check_'+data.employee_deductions[j].deduction_id+']').attr("checked", true);
											}
										},
										error: function(e) {
											console.log(e.responseText);
										}
									});
								},
								error: function(e) {
									console.log(e.responseText);
								}
							});
						}else{
							$("#surname").val('');
							$("#nic_no").val('');
							$("#branch").val('');
							$("#division").val('');
							$("#designation").val('');
							$("#employment_type").val('');
							$('#epf_no').val('');
						}
					}
				</script>
				<!--footer-->
				<?
				$this->load->view("includes/footer");
				?>
