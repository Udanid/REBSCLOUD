<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
		$("#task_id").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select a Task"
		});
		$("#boqsubcat_id").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select a Sub Category"
		});

		$.ajaxSetup ({
			// Disable caching of AJAX responses
			cache: false
		});
	}, 800);
});
</script>
<h4>Edit BOQ Task<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->boqtask_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
	<div class="row">
		<form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/update_boqtask" id="mytestform">
			<div class="col-md-8 validation-grids " data-example-id="basic-forms">
				<div class="form-body">
					<input type="hidden" name="boqtask_id" id="boqtask_id" value="<?=$details->boqtask_id?>">
					<label>Design Type</label>
					<div class="form-group">
						<select class="form-control design_id" name="design_id" id="design_id" required>
							<? if($design_type){?>
								<option value=""></option>
								<? foreach ($design_type as $rw){
									$m_des=$details->design_id;
									?>
									<option value="<?=$rw->design_id?>" <? if($m_des==$rw->design_id){echo "selected";}?>><?=$rw->short_code?> - <?=$rw->design_name?></option>
								<? }?>
								<? }?>
							</select>

					</div>
					<label>BOQ Main Category</label>
					<div class="form-group">
						<select class="form-control" name="boqcat_id" id="boqcat_id" required>
								<? if($main_boq){?>
									<? foreach ($main_boq as $rw){
										$m_boq=$details->boqcat_id;
										?>
										<option value="<?=$rw->boqcat_id?>" <? if($m_boq==$rw->boqcat_id){echo "selected";}?>><?=$rw->cat_name?></option>
								<? }}?>
							</select>


					</div>
					<label>Sub Category</label>
					<div class="form-group">

						<select type="text" name="boqsubcat_id" id="boqsubcat_id" class="form-control" required>
							<option value=""></option>
							<? if($sub_cat_data){
								$sub_cat=$details->boqsubcat_id;
								foreach ($sub_cat_data as $key => $value) {?>
									<option value="<?=$value->boqsubcat_id?>" <? if($sub_cat==$value->boqsubcat_id){echo "selected";}?>><?=$value->subcat_code?> - <?=$value->subcat_name?></option>
								<?	}
							}?>
						</select>

					</div>
					<label>Task </label>
					<div class="form-group">
						<select  name="task_id" id="task_id" class="form-control" required>
							<option value=""></option>
							<? if($hmtask){
								$task=$details->task_id;
								foreach ($hmtask as $key => $value) {?>
									<option value="<?=$value->task_id?>" data-des="<?=$value->task_name?>"
										<? if($task==$value->task_id){echo "selected";}?>
										><?=$value->task_code?> - <?=$value->task_name?></option>
									<?	}
								}?>
							</select>
						</div>

					<label>Description</label>
					<div class="form-group">
						<textarea type="text" name="description" id="description"   class="form-control" required><?=$details->description?>
						</textarea>

					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Sumbit</button>
					</div>

				</div>
			</div>
			<div class="col-md-4 validation-grids " data-example-id="basic-forms">
				<div class="form-body">
					<label>Unit</label>
					<div class="form-group">
						<input type="text" name="unit" id="unit" class="form-control" value="<?=$details->unit?>" required>

					</div>

						<label>Quantity</label>
						<div class="form-group">
							<input type="number" step="0.01" name="qty" id="qty" class="form-control" value="<?=$details->qty?>" required>

						</div>

						<label>Rate</label>
						<div class="form-group">
							<input type="number" step="0.01" name="rate" id="rate" class="form-control" value="<?=$details->rate?>" required>

						</div>
						<label>Amount</label>
						<div class="form-group">
							<input type="number" step="0.01" name="amount" id="amount" value="<?=$details->amount?>" class="form-control" required>
						</div>
					</div>
				</div>
			</form></div>
		</div>
		<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
		<script  type="text/javascript">
		jQuery(document).ready(function() {

			//validate all fields
			//$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
			$.validator.setDefaults({ignore: [] });
			$("#mytestform").validate({
				rules: {
					boqcat_id:{required: true},
					design_id:{required: true},
					boqsubcat_id: {required: true},
					description:{required: true},
					unit:{required: true},
					amount:{required: true},
					task_id:{required: true},
					qty:{required: true},
					rate:{required: true},
				},
				messages: {
					boqcat_id:"Required",
					design_id:"Required",
					boqsubcat_id: "Required",
					description: "Required",
					unit: "Required",
					amount: "Required",
					task_id:"Required",
					qty:"Required",
					rate:"Required",
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

			$('#boqcat_id').change(function(){

				var boq_id=$('#boqcat_id').val();
				$("#boqsubcat_id").chosen({
					allow_single_deselect : false
				});
				$('#boqsubcat_id').find('option').remove();
				$('#boqsubcat_id').append('<option value=""></option>');
				$.ajax({
					cache: false,
					type: 'POST',
					url: '<?php echo base_url().'hm/hm_boqconfig/get_sub_boqtask_bydesign';?>',
					data: {boq_id:boq_id},
					dataType: "json",
					success: function(data) {
						//alert(data)
						if (data) {

							jQuery.each(data, function(index, item) {

								$('#boqsubcat_id').append('<option value="'+item.boqsubcat_id+'">'+item.subcat_code+' -'+item.subcat_name+'</option>');

							});
							$('#boqsubcat_id').trigger("chosen:updated");
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
