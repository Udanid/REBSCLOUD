 <?
 if($details){
 	foreach($details as $det){
 		?>
 		<h4>Meterial Details of <?=$det->mat_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$det->mat_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/meterial_update">
						<div class="col-md-8 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5  style="color:#000">Basic Information :</h5>
							</div>

							
							<div class="form-body">
								    <input type="hidden" name="emetid" id="emetid" value="<?=$det->mat_id?>">
								    <label>Meterial Code</label>
									<div class="form-group">
										<input type="text" class="form-control" value="<?=$det->mat_code?>" name="emeterial_code" id="emeterial_code" placeholder="Branch Name" required>
									</div>

									<label>Meterial Name</label>
									<div class="form-group">
										<input type="text" class="form-control" value="<?=$det->mat_name?>" name="emeterial_name" id="emeterial_name" placeholder="Branch Name" required>
									</div>

                                    <label>Messurement Type</label>
									<div class="form-group">
										<select id="emessure_type" name="emessure_type" class="form-control" required>
					                      <option value="">Select Mesurement</option>
					                      <?
					                      if($messures)
					                      {
					                       foreach($messures as $msrs){
					                       	if($msrs->mt_id==$det->mt_id){
					                       		?>
					                         <option value="<?=$msrs->mt_id;?>" selected><?=$msrs->mt_name;?></option>
					                            <?
					                       	}else{
					                       		?>
					                         <option value="<?=$msrs->mt_id;?>"><?=$msrs->mt_name;?></option>
					                            <?
					                       	 }
					                        }
					                      } 
					                      ?>
					                   </select>
									</div>

									<label>Descryption</label>
									<div class="form-group">
										<textarea name="emeterial_desc" id="emeterial_desc" class="form-control" required rows="4" cols="20"><?=$det->description?></textarea>
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
 }
 ?>
 