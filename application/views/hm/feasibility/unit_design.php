<script>
// function calculate_salestot(i)
// {
//   //alert("ll")
//   subtot=parseFloat(document.getElementById('tot_val'+i).value);
//   var mytot=0;
//    //document.getElementById('tot'+i).value=subtot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
//   for(t=1; t<= <?=$details->numof_units?>; t++)
//  {
//     subtot=parseFloat(document.getElementById('tot_val'+t).value);
//    mytot=parseFloat(mytot)+parseFloat(subtot);
//  }
//  //alert(mytot)
//  document.getElementById('totalsales_val').value=mytot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
//
// }

</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>hm/feasibility/add_lots" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden"  class="form-control" name="num_of_unit" id="num_of_unit" value="<?=$details->numof_units?>" >
                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4>Design Type</h4>
							</div>
					              <div class="form-body">

                                   <table class="table gridexample"> <thead> <tr> <th >ID</th> <th >Unit Name</th><th width="40%">Design Type </th>
                                   </tr> </thead>
                                   <? $count=1; $tot=0; if($unit_design){
									  foreach($unit_design as $raw) {
										  $tot=$tot+$raw->sale_val;
									   ?>
                                  <tr> <td><?=$count?></td>
                                   <td>
                                     <input type="hidden"  class="form-control" name="unit_id<?=$count?>" id="unit_id<?=$count?>" value="<?=$raw->lot_id?>" >
                                     <div class="form-group has-feedback" ><input type="text"  class="form-control" name="unit_name<?=$count?>" id="unit_name<?=$count?>" value="<?=$raw->lot_number?>" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										                             <span class="help-block with-errors" ></span>
									                   </div>
                                   </td>

                  <td><div class="form-group has-feedback" >

                        <select class="form-control" name="design_id<?=$count?>" id="design_id<?=$count?>" required>
                        <? if($design_type){?>
                                <option value="">-- Select Design Type -- </option><? }?>
                                <? foreach ($design_type as $rw){?>
                                  <option value="<?=$rw->design_id?>" <? if($raw->design_id==$rw->design_id){ echo "Selected";}?>><?=$rw->short_code?> - <?=$rw->design_name?></option>
                                <? }?>
                              </select>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <span class="help-block with-errors" ></span>
                      </div>

                  </td>
                  <!-- <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$count?>" id="tot_val<?=$count?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$raw->sale_val?>" onblur="calculate_salestot('<?=$count?>')"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <span class="help-block with-errors" ></span>
                </div></td> -->
                </tr>
                                   <?  $count++; }
								   if($count-1<$details->numof_units){
									    for($i=$count; $i<=$details->numof_units; $i++){?>
                                  <tr> <td><?=$i?></td>
                                   <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="unit_name<?=$i?>" id="unit_name<?=$i?>" value=""><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>

                  <td>
                    <div class="form-group has-feedback" >
                            <select class="form-control" name="design_id<?=$i?>" id="design_id<?=$i?>" required>
                              <? if($design_type){?>
                                <option value="">-- Select Design Type -- </option><? }?>
                                <? foreach ($design_type as $rw){?>
                                  <option value="<?=$rw->design_id?>"><?=$rw->short_code?> - <?=$rw->design_name?></option>
                                <? }?>
                              </select>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <span class="help-block with-errors" ></span>
                      </div>

                  </td>
                  <!-- <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$i?>" id="tot_val<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"  onblur="calculate_salestot('<?=$i?>')"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                 <span class="help-block with-errors" ></span>
               </div></td> -->
                </tr>
                                   <? }

								   }

								    } else{ for($i=1; $i<=$details->numof_units; $i++){?>
                                 <tr> <td><?=$i?></td>
                                   <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="unit_name<?=$i?>" id="unit_name<?=$i?>"  value=""><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>

                  <td>
                    <div class="form-group has-feedback" >
                      <select class="form-control" name="design_id<?=$i?>" id="design_id<?=$i?>" required>
                              <? if($design_type){?>
                                <option value="">-- Select Design Type -- </option><? }?>
                                <? foreach ($design_type as $rw){?>
                                  <option value="<?=$rw->design_id?>"><?=$rw->short_code?> - <?=$rw->design_name?></option>
                                <? }?>
                              </select>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
               <span class="help-block with-errors" ></span>
                      </div>
                  </td>
                  <!-- <td> <div class="form-group has-feedback" ><input type="text"  class="form-control" name="tot<?=$i?>" id="tot_val<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0"  onblur="calculate_salestot('<?=$i?>')"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                 <span class="help-block with-errors" ></span>
               </div></td> -->
                </tr>
                                   <? }} ?>
                                   <!-- <tr> <td><strong>Total</strong></td>
                                   <td></td><td></td>
                                    <td> <div class="form-group has-feedback" ><input type="text"    class="form-control" name="totalsales" id="totalsales_val"   pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=number_format($tot,2)?>"  data-error="Total Ep rates Must euql to 100" readonly="readonly"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    </tr> -->
                                   </table>

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
