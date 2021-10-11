 <h4>Details of <?=$details->document_name ?> <span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/documents/editdata">
                    
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
								<? $catlist=explode(',',DOCUMENTCAT);?>
									<div class="form-group"> 
                                     <label>Document Category</label><select class="form-control" placeholder="Document Category"  <? if($details->status=='CONFIRMED'){?>  disabled="disabled"<? }?> id="category" name="category"   required >
                    <option value="">Document Category</option>
                    <? for ($i=0; $i<count($catlist); $i++){?>
                    <option value="<?=$catlist[$i]?>" <? if($details->category==$catlist[$i]){?> selected="selected"<? }?>><?=$catlist[$i]?></option>
                    <? }?>
              
					
					</select> 
									    <span class="help-block with-errors" ></span>
									</div>
									
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
								
								<div class="form-body">
									
									<div class="form-group has-feedback">
                                     <label>Document Name</label>
                                    <input type="hidden" name="doctype_id"	value="<?=$details->doctype_id?>"	 id="doctype_id" />
                                   <input type="text" class="form-control" value="<?=$details->document_name?>" name="document_name" id="document_name" placeholder="Document Name"  required>
										
										<span class="help-block with-errors" ></span>
									</div>
                                    
										<div class="bottom">
											
										
											<div class="clearfix"> </div>
										</div>
								
								</div>
							</div>
						</div>
					</form></div>



				            
                                    
                                 <br /></div>