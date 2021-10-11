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
 <h4>Add Task Servies<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$boq_taskid?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/add_taskser">
											<div class="col-md-6 validation-grids " data-example-id="basic-forms">
												<div class="form-body">
														<label>Services Type</label>
														<div class="form-group">
															<input type="hidden" name="boq_taskid" id="boq_taskid" value="<?=$boq_taskid?>">
															<select name="service_id" id="service_id" class="form-control" required>
																<option value=""></option>
																<? if($services){
																	foreach ($services as $key => $value) {?>
																		<option value="<?=$value->service_id?>" ><?=$value->service_name?></option>
																<?	}
																}?>
															</select>

														</div>

														<div class="form-group">
															<button type="submit" class="btn btn-primary">Add</button>
														</div>

												</div>
											</div>
											<div class="col-md-6 validation-grids " data-example-id="basic-forms">
												<div class="form-body">
												<table class="table table-hover">
													<? if($details){?>
													<tr class="info"><th>No</th><th>Services</th><th>Pay Type</th><th>Pay Rate</th></tr>

													<?	$c=0;
														foreach ($details as $key => $value) {
															$c++;
															?>
															<tr><td><?=$c?></td>
																<td><?=$value->service_name?></td>
																<td><?=$value->pay_type?></td>
																<td><?=$value->pay_rate?></td>
															</tr>
													<?	} ?>
													</table>
												<?	}?>
												</div>
												</div>
					</form></div>
                           </div>
