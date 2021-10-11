<script type="text/javascript">
jQuery(document).ready(function() {
	setTimeout(function(){
	  	$("#ledger_id").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});
	  	$("#adv_ledgerid").chosen({
     		allow_single_deselect : true,
			search_contains: true,
	 		no_results_text: "Oops, nothing found!",
	 		placeholder_text_single: "Select a Ledger"
    	});

	 	$.ajaxSetup ({
    	// Disable caching of AJAX responses
    		cache: false
		});
	}, 800);
});
</script>
 <h4>Edit Task<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->task_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_task" id="mytestform">

                      <div class="col-md-6 validation-grids " data-example-id="basic-forms">
          							<div class="form-body">
													<label>Task Code</label>
													<div class="form-group">
														<input type="text"  name="task_code" id="task_code" value="<?=$details->task_code?>" class="form-control" required>
													</div>
													<label>Task Related To</label>
													<div class="form-group">
														<select class="form-control" name="related_code" id="related_code" required>

															<? if($relative_code){?>
																<option value=""></option><? }?>
																<? foreach ($relative_code as $rw){?>
																	<option value="<?=$rw->code?>" <? if($details->relative_code==$rw->code){echo "selected";}?>><?=$rw->code?> - <?=$rw->description?></option>
																<? }?>
														</select>
													</div>

													<label>Task Type</label>
													<div class="form-group">
														<select  name="task_type" id="task_type" class="form-control" required>
															<option value="BOQ" <? if($details->task_type=="BOQ"){echo "selected";}?>>BOQ</option>
															<option value="Common" <? if($details->task_type=="Common"){echo "selected";}?>>Common</option>
														</select>
													</div>

          									<label>Ledger Account</label>
          									<div class="form-group">
          										<select class="form-control" name="ledger_id" id="ledger_id">
          											<? $ledgerlist=get_master_acclist()?>
          											<? if($ledgerlist){?>
          			<option value=""></option><? }?>
          			<? foreach ($ledgerlist as $rw){
                  $led=$details->ledger_id;?>
          			<option value="<?=$rw->id?>" <? if($led==$rw->id){echo "selected";}?>><?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
          			<? }?>
          										</select>

          									</div>


                            <div class="form-group">
                              <button type="submit" class="btn btn-primary disabled">Update</button>
                            </div>

          							</div>
          						</div>
          						<div class="col-md-6 validation-grids " data-example-id="basic-forms">
          							<div class="form-body">
													<label>Task Name</label>
													<div class="form-group">
														<textarea name="task_name" id="task_name" class="form-control" required><?=$details->task_name?></textarea>
														<input type="hidden" name="task_id" id="task_id" value="<?=$details->task_id?>"  class="form-control" required>
													</div>


          									<label>Advance Ledger Account</label>
          									<div class="form-group">
          										<select class="form-control" name="adv_ledgerid" id="adv_ledgerid">
          											<? if($ledgerlist){?>
          			<option value=""></option><? }?>
          			<? foreach ($ledgerlist as $rw){

                  $advled=$details->advance_ledger;?>
          			<option value="<?=$rw->id?>" <? if($advled==$rw->id){echo "selected";}?>><?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
          			<? }?>
          										</select>

          									</div>
          								</div>
          							</div>



					</form></div>
                           </div>
