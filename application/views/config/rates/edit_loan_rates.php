 <h4>Edit <?=$details->type?> - <?=$details->description?> Rates<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/rates/editdata_loan_rates">
                    
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
                            <div class="form-group has-feedback">
                            <table>
                            <tr><th>Grace Period</th><th>Delay Interest</th><th>Default Annual Interest</th></tr>
                            <tr>
                            <td><input type="text" class="form-control" value="<?=$details->grace_period?>" name="grace_period" id="grace_period" placeholder="Document Name"  required></td>
           <td><input type="text" class="form-control" value="<?=$details->delay_int?>" name="delay_int" id="delay_int" placeholder="Document Name"  required></td>
           <td><input type="text" class="form-control" value="<?=$details->default_int?>" name="default_int" id="default_int" placeholder="Document Name"  required></td>
           
                                </tr>
                            </table>
                             
								  <input type="hidden" class="form-control" value="<?=$details->id?>" name="id" id="id" >
								
									    <span class="help-block with-errors" ></span>
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