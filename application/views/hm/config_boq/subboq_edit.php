<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
		$("#boqcat_id").chosen({
			allow_single_deselect : true,
		search_contains: true,
		no_results_text: "Oops, nothing found!",
		placeholder_text_single: "Select A Design Type"
		});

	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
});
</script>
 <h4>Edit BOQ Sub Category<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->boqsubcat_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/update_subboq" id="mytestform">
											<div class="col-md-6 validation-grids " data-example-id="basic-forms">
												<div class="form-body">
														<label>BOQ Sub Category Name</label>
														<div class="form-group">
															<input type="text" name="subcat_name" id="subcat_name" value="<?=$details->subcat_name?>" class="form-control" required>
															<input type="hidden" name="boqsubcat_id" id="boqsubcat_id" value="<?=$details->boqsubcat_id?>" class="form-control" required>
														</div>
														<label>Design Type</label>
														<div class="form-group">
															<select class="form-control design_id" name="design_id" id="design_id" required>
																<? if($designs){?>
																	<option value=""></option>
																	<? foreach ($designs as $rw){
																		$m_des=$details->design_id;
																		?>
																		<option value="<?=$rw->design_id?>" <? if($m_des==$rw->design_id){echo "selected";}?>><?=$rw->short_code?> - <?=$rw->design_name?></option>
																	<? }?>
																	<? }?>
																</select>

														</div>
														<label>BOQ Main Category</label>
														<div class="form-group">
															<select class="form-control" name="boqcat_id" id="boqcat_id">
																<? if($main_boq){?>
																	<? foreach ($main_boq as $rw){
																		$m_boq=$details->boqcat_id;
																		?>
																		<option value="<?=$rw->boqcat_id?>" <? if($m_boq==$rw->boqcat_id){echo "selected";}?>><?=$rw->cat_name?></option>
																<? }}?>
															</select>

														</div>


														<div class="form-group">
															<button type="submit" class="btn btn-primary disabled">Sumbit</button>
														</div>

												</div>
											</div>
											<div class="col-md-6 validation-grids " data-example-id="basic-forms">
												<div class="form-body">
													<label>BOQ Sub Category Code</label>
													<div class="form-group">
														<input type="text" name="subcat_code" id="subcat_code" value="<?=$details->subcat_code?>" class="form-control" required>
													</div>

													</div>
												</div>
					</form></div><script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
					<script  type="text/javascript">
						jQuery(document).ready(function() {

							//$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
							$.validator.setDefaults({ignore: [] });
							$("#mytestform").validate({
								rules: {
										subcat_name: {required: true},
										boqcat_id:{required: true},
										subcat_code:{required: true},
									},
					        messages: {
					            subcat_name: "Required",
											boqcat_id: "Required",
											subcat_code: "Required",
					        }
					});
					$('#design_id').change(function(){

						var des_id=$('#design_id').val();
							$("#boqcat_id").chosen({
					       allow_single_deselect : false
					    });
						$('#boqcat_id').find('option').remove();
						$('#boqcat_id').append('<option value=""></option>');
						$.ajax({
											cache: false,
											type: 'POST',
											url: '<?php echo base_url().'hm/hm_boqconfig/get_main_boqtask_bydesign';?>',
											data: {des_id:des_id},
											dataType: "json",
											success: function(data) {

													if (data) {

														jQuery.each(data, function(index, item) {

															$('#boqcat_id').append('<option value="'+item.boqcat_id+'">'+item.cat_name+'</option>');
														});
														$('#boqcat_id').trigger("chosen:updated");
													}
									else
									{
										//$('#complexConfirm').click();
									}
											}
									});
					});

						});
					</script>
</div>
