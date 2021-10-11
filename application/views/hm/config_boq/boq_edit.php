<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
		$("#design_id").chosen({
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
 <h4>Edit BOQ Category<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->boqcat_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_boqconfig/update_boq" id="mytestform">

                      <div class="col-md-6 validation-grids " data-example-id="basic-forms">
          							<div class="form-body">
															<label>BOQ Category Name</label>
															<div class="form-group">
																<input type="text" name="cat_name" id="cat_name" value="<?=$details->cat_name?>" class="form-control" required>
																<input type="hidden" name="boq_id" id="boq_id" value="<?=$details->boqcat_id?>" class="form-control" required>
															</div>


															<div class="form-group">
																<button type="submit" class="btn btn-primary ">Sumbit</button>
															</div>

          							</div>
          						</div>
          						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
          							<div class="form-body">
													<label>Design Type</label>
													<div class="form-group">
														<select class="form-control" name="design_id" id="design_id">
															<? if($designs){?>
							<option value=""></option><? }?>
							<? foreach ($designs as $rw){
								$des_id=$details->design_id;?>
							<option value="<?=$rw->design_id?>" <? if($des_id==$rw->design_id){echo "selected";}?>><?=$rw->short_code?> - <?=$rw->design_name?></option>
							<? }?>
														</select>

													</div>
          								</div>
          							</div>



					</form></div>
</div>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script  type="text/javascript">
	jQuery(document).ready(function() {

	//validate all fields
  	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$("#mytestform").validate({
			rules: {
					cat_name: {required: true},
					design_id:{required: true},
				},
        messages: {
            cat_name: "Required",
						design_id: "Required",
        }
			});


	});
</script>
