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
														<label>Meterial Type</label>
														<div class="form-group">
															<input type="hidden" name="boqtask_id" id="boqtask_id" value="<?=$boq_taskid?>">
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
													<? if($details){?>
												<table class="table table-hover">
													<tr class="info"><th>No</th><th>Meterial Code</th><th>Meterial Name</th><th>Description</th><th>Default Quantity</th></tr>

													<?	$c=0;
														foreach ($details as $key => $value) {
															$c++;
															?>
															<tr><td><?=$c?></td>
																<td><?=$value->mat_code?></td>
																<td><?=$value->mat_name?></td>
																<td><?=$value->description?></td>
																<td><?=$value->default_qnt?></td>

															</tr>
													<?	} ?>
													</table>
													<? }?>

												</div>
												</div>
					</form></div>
                           </div>
