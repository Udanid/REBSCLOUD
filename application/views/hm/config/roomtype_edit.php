 <h4>Edit Room Types<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->roomtype_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_roomtypes" id="mytestform">

						<div class="col-md-6 validation-grids " data-example-id="basic-forms">

							<div class="form-body">
                <label>Room Name</label>
                <div class="form-group">
                  <input type="text" name="room_name" id="room_name" class="form-control" value="<?=$details->roomtype_name?>" required>
                    <input type="hidden" name="room_id" id="room_id" class="form-control" value="<?=$details->roomtype_id?>" required>
                </div>
                <label>Length</label>
                <div class="form-group">
                  <input type="number" step="0.01" name="lenth" id="lenth" class="form-control" value="<?=$details->def_length?>" required>
                </div>
                <label>Height</label>
                <div class="form-group">
                  <input type="number" step="0.01" name="height" id="height" class="form-control" value="<?=$details->def_height?>" required>
                </div>
                <label>Width</label>
                <div class="form-group">
                  <input type="number" step="0.01" name="width" id="width" class="form-control" value="<?=$details->def_width?>" required>
                </div>

								 <div class="bottom">

											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Submit</button>
											</div>
											<div class="clearfix"> </div>
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
					room_name: {required: true},
					lenth:{required: true},
					height:{required: true},
					width:{required: true},
				},
        messages: {
            room_name: "Required",
						lenth: "Required",
						height: "Required",
						width: "Required",
        }
});


	});
</script>
