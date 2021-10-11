<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
	  	$("#service_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Services"
    	});


	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
});
</script>
 <h4>Add Task Meterial<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$boq_taskid?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/add_taskmat">
											<div class="col-md-6 validation-grids " data-example-id="basic-forms">
												<div class="form-body">
													<input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
													<input type="hidden" name="unitid" id="unitid" value="<?=$unitid?>">
													<label>BOQ Task</label>
													<div class="form-group">

														<select name="fboq_id" id="fboq_id" class="form-control" required>
															<option value=""></option>
															<? if($boq_taskdata){
																foreach ($boq_taskdata as $key => $value) {?>
																	<option value="<?=$value->mat_id?>" ><?=$value->mat_code?> - <?=$value->mat_name?></option>
															<?	}
															}?>
														</select>

													</div>
														<label>Meterial Type</label>
														<div class="form-group">

															<select name="mat_id" id="mat_id" class="form-control" required>
																<option value=""></option>
																<? if($meterial){
																	foreach ($meterial as $key => $value) {?>
																		<option value="<?=$value->mat_id?>" ><?=$value->mat_code?> - <?=$value->mat_name?></option>
																<?	}
																}?>
															</select>

														</div>
														<label>Default Quantity</label>
														<div class="form-group">
															<input type="number" name="default_qnt" id="default_qnt" class="form-control">
														</div>

														<div class="form-group">
															<button type="submit" class="btn btn-primary">Add</button>
														</div>

												</div>
											</div>
											<div class="col-md-6 validation-grids " data-example-id="basic-forms">
												<div class="form-body">


												</div>
												</div>
					</form></div>
                           </div>
