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

	
});</script>
 <h4>Subtask List of <?=$details->product_code ?><?=$details->task_code ?>-<?=$details->task_name?> <span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>

  <form data-toggle="validator" method="post" action="<?=base_url()?>config/producttasks/editdata" id="mytestform">
  <input type="hidden" name="task_id" id="task_id" value="<?=$details->task_id?>" />
                      
                    <div class="form-title">
								
							</div>
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							<? $ledgerlist=get_master_acclist()?>
							<div class="form-body">
								  <label>Product Code</label>
									<div class="form-group"> <select class="form-control" placeholder="Product Code"  id="product_code" name="product_code"   required >
                                    <? if($activcount>1){?>
                    <option value="">Product Code</option><? }?>
                    <? foreach ($activeprd as $rw){?>
                    <option value="<?=$rw->product_code?>"><?=$rw->product?></option>
                    <? }?>
              
					
					</select> 
									    <span class="help-block with-errors" ></span>
									</div>
                                     <label>Ledger Account</label>
									<div class="form-group"> <select class="form-control" placeholder="Ledger Account"  id="ledger_id" name="ledger_id"  disabled="disabled"  required >
                                    <? if($ledgerlist){?>
                    <option value="">Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>"  <? if($details->ledger_id==$rw->id) {?> selected="selected"<? }?>><?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?>  </option>
                    <? }?>
              
					
					</select> 
									    <span class="help-block with-errors" ></span>
									</div>
									
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
								
								<div class="form-body">
									 <label>Task Name</label>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" name="task_name" id="task_name" placeholder="Task Name"  value="<?=$details->task_name?>" required>
										
										<span class="help-block with-errors" ></span>
									</div>
                                      <label>Advanced Ledger Account</label>
									<div class="form-group"> <select class="form-control" placeholder="Advanced Ledger Account"  id="adv_ledgerid" name="adv_ledgerid" disabled="disabled"   required >
                                    <? if($ledgerlist){?>
                    <option value="">Advanced Ledger Account</option><? }?>
                    <? foreach ($ledgerlist as $rw){?>
                    <option value="<?=$rw->id?>" <? if($details->adv_ledgerid==$rw->id) {?> selected="selected"<? }?>><?=$rw->group_name?> - <?=$rw->ref_id?> - <?=$rw->name?></option>
                    <? }?>
              
					
					</select> 
									    <span class="help-block with-errors" ></span>
									</div>
                                    
										<div class="bottom">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								
								</div>
							</div>
						</div>
					</form>



<div class="table widget-shadow">
<table class="table"> <thead> <tr> <th> Sub Task code</th> <th>Task name</th> <th>Status</th></tr> </thead>
                      <? if($datalist){$c=0;
                          foreach($datalist as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->subtask_code?></th> <td><?=$row->subtask_name?></td> <td><?=$row->status?></td> 
                      
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  



				            
                                    
                                 <br /></div>