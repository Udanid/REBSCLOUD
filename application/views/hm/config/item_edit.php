 <script  type="text/javascript">
 $(function() {
	var availableTagsDecs = [
		<? if ($brandlist) foreach ($brandlist as $row){
			echo '"'.$row->brand_name.'",';
		}?>
		""
	];
	
   
	 $( "#brand_name" ).autocomplete({
		source: availableTagsDecs
	});
});
 </script>
 
 <?
 if($details){
	 $statues=check_foreign_key('hm_prjf_boqitems',$details->item_id,'item_id');
 		?>
 		<h4>Item Details of <?=$details->item_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->mat_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_items">
						<div class="col-md-8 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5  style="color:#000">Basic Information :</h5>
							</div>

							
							<div class="form-body">
								    <input type="hidden" name="item_id" id="item_id" value="<?=$details->item_id?>">
								
									<label>Item Name</label>
									<div class="form-group">
										<input type="text" class="form-control" <? if(!$statues){?> readonly="readonly"<? }?> value="<?=$details->item_name?>" name="item_name" id="item_name" placeholder="Item Name" required>
									</div>

                                    <label>Messurement Type</label>
									<div class="form-group">
										<input type="text" class="form-control" <? if(!$statues){?> readonly="readonly"<? }?> value="<?=$details->brand_name?>" name="brand_name" id="brand_name" placeholder="Item Name" required>
									</div>


									<label>Unit_rate</label>
									<div class="form-group">
									     <input type="text" name="unit_rate" id="unit_rate"  value="<?=$details->unit_rate?>"class="form-control" required>
                 						</div>

									<div class="form-group">
				                    <button type="submit" class="btn btn-primary">Update</button>
				                    </div>
							 
							</div>
						</div>
					</form></div>
<br /><br /><br /><br /></div>
 		<?
 	
 }
 ?>
 