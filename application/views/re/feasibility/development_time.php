<script>

function setmyrawtotal(rawid,colid)
{
	var unselabletot=0;
	for(i=1; i<=colid; i++)
	{
		unselabletot=parseFloat(unselabletot)+parseFloat(document.getElementById('timerange'+rawid+'-'+i).value);
	}
	//alert(unselabletot);
	if(unselabletot==0 || unselabletot==100)
	document.getElementById('rawtotal'+rawid).value=unselabletot;
	else
	document.getElementById('rawtotal'+rawid).value="";
}
</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/add_time" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden" name="prjperiod" id="prjperiod" value="<?=$details->period?>">
                      
                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Development Time</h4>
							</div>
					              <div class="form-body">
								
                                   <table class="table gridexample" > <thead> <tr  class="info"> <th  rowspan="2">Task Code</th> <th rowspan="2">Task Name</th>  
                                   <th  colspan="<?=$details->period?>" align="center">Months</th>
                                   <th  rowspan="2">Raw Total</th>
                                   </tr> 
                                   <tr  class="info"><? for($i=1; $i<=$details->period; $i++){?>
                                   <th><?=str_pad($i, 2, "0", STR_PAD_LEFT);?></th>
                                   <? }?>
                                   </tr>
                                   </thead>
                                   <? $count=1;  if($tasklist){
									  foreach($tasklist as $raw) {
										$rawtot=0;
									   ?>
                                 
                                  
								    <tr style="border-bottom:1px solid #CCC;"> <td style=" padding:0; margin:0"><?=$raw->task_code?></td>
                                   <td style=" padding:0; margin:0"> <?=$raw->task_name?>
                                 <? for($i=1; $i<=$details->period; $i++){
									 if($timechart[$raw->task_id][$i])
									 $val=$timechart[$raw->task_id][$i]->percentage;
									 else 
									 $val=0;
									 $rawtot=$rawtot+$val;
									// echo $raw->task_id;
									 ?>
                                     <td style=" padding:0; margin:0"><div class="form-group" style=" padding:0; margin:0" > <input type="text"    style="width:50px; padding:0px;" class="form-control" id="timerange<?=$raw->task_id.'-'.$i?>" name="timerange<?=$raw->task_id.'-'.$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$val?>" required="required"  onblur="setmyrawtotal('<?=$raw->task_id?>','<?=$details->period?>')"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" style=" padding:0; margin:0"></span>
									</div></td>
                                    <? }?>
                                   
                                     <td style=" padding:0; margin:0"><div class="form-group "  style=" padding:0; margin:0"> <input type="text"  name="rawtotal<?=$raw->task_id?>" style="padding:0px;" id="rawtotal<?=$raw->task_id?>" value="<?=$rawtot?>" class="form-control" data-error=" Raw total must equal to 0 or 100"  required="required"/><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"  style=" padding:0; margin:0"></span>
									</div></td> </tr>
								   
								   <?
								    }
								 
								   
								    } ?></table>
                                       
								   <? if($details->status=='PENDING'){?>
                                    <div class="bottom ">
											
											<div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled"  >Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                                        <? }?>
									
						</div>
                            
                        </div>
                        <div class="clearfix"> </div></div>
                      
                       
                        
					</form>