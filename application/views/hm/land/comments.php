 <h4>  <?=$details->property_name?> - <?=$details->district ?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->land_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">        
  <form data-toggle="validator" method="post" action="<?=base_url()?>hm/land/commetnadd" enctype="multipart/form-data">
 <input type="hidden" name="land_code" id="land_code" value="<?=$details->land_code?>">
                         
						     <div class="widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5 style="background-color:none;">Land Comments</h5>
							</div>
							<div class="form-body">
								<? if($comments){
									foreach($comments as $raw){ 
									if($raw->comment_type=='Higer Auth'){?>
                                    <div class="form-group has-feedback">
									<label>High Auth Comment</label>
								<textarea class="form-control" id="high_auth" name="high_auth" <? if(!check_access('high_auth_comment')){?>  readonly="readonly"<? }?>placeholder=""   > <?=$raw->comment?></textarea></div>
								<? } else{?>
                                 <div class="form-group has-feedback">
								<label>Manager Comment</label>
								<textarea class="form-control" id="manager" name="manager"  <? if(!check_access('manager_comment')){?>  readonly="readonly"<? }?>  placeholder="" data-error="Invalid number"  > <?=$raw->comment?></textarea></div>
								
								<? } } } else{?>
                                 <div class="form-group has-feedback">
									<label>High Auth Comment</label>
								<textarea class="form-control" id="high_auth" name="high_auth" <? if(!check_access('high_auth_comment')){?>  readonly="readonly"<? }?>placeholder=""   > </textarea></div>
                                 <div class="form-group has-feedback">
                                 <label>Manager Comment</label>
								<textarea class="form-control" id="manager" name="manager"  <? if(!check_access('manager_comment')){?>  readonly="readonly"<? }?>  placeholder="" data-error="Invalid number"  > </textarea>
                                 </div>
                                
                                
                                <? }?>
                                   <div class="bottom ">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								</div>
                   
                        <div class="clearfix"> </div>
                        <br>
                     
                        
                        
                        
					</form></div>



				            
                                    
                                    <br /><br /><br /><br /></div>