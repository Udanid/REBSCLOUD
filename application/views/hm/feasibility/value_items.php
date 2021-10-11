<script>

</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>hm/feasibility/add_valueitems" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                      
                        <div class="row">
						  <div class="  widget-shadow " data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Value Items</h4>
							</div>
					              <div class="form-body">
								
                                   <table class="table"> <thead> <tr> <th >ID</th> <th >Description</th>  <th width="20%">Quantity</th><th width="30%">Total Price </th></tr> </thead>
                                   <? $count=1; if($valuse_items){
									  foreach($valuse_items as $raw) {
									   ?>
                                  <tr> <td><?=$raw->id?></td>
                                   <td> <input type="text"  class="form-control" name="name<?=$count?>" value="<?=$raw->name?>"></td>
                                    <td> <input type="text"  class="form-control" name="quontity<?=$count?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$raw->quontity?>"></td>
                                     <td> <input type="text"  class="form-control" name="value<?=$count?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$raw->value?>"></td></tr>
                                   <?  $count++; }
								   if($count<7){
									    for($i=$count; $i<=7; $i++){?>
                                    <tr> <td><?=$i?></td>
                                   <td> <input type="text"  class="form-control" name="name<?=$i?>"   value=""></td>
                                    <td><div class="form-group has-feedback" > <input type="text"  class="form-control" name="quontity<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     <td> <div class="form-group has-feedback" > <input type="text"  class="form-control" name="value<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0.00" > <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                   <? }
									   
								   }
								   
								    } else{ for($i=1; $i<=7; $i++){?>
                                    <tr> <td><?=$i?></td>
                                   <td> <input type="text"  class="form-control" name="name<?=$i?>"  value=""></td>
                                    <td><div class="form-group has-feedback" > <input type="text"  class="form-control" name="quontity<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     <td> <div class="form-group has-feedback" > <input type="text"  class="form-control" name="value<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0.00" > <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                   <? }} ?></table>
                                       <br />
								  <? if($details->status=='PENDING'){?>
                                    <div class="bottom ">
											
											<div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled" >Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
									<? }?>
						</div>
                            
                        </div>
                        <div class="clearfix"> </div></div>
                      
                       
                        
					</form>