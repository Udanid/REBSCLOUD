<script>
function  calculate_subtotal(id,thiskey)
{
	
	var list=document.getElementById('sublist'+id).value;
	var res = list.split(",");
	//alert('ssssss');
	if(thiskey=='1')
	{var stampfee=10;
	//alert(thiskey);
		//var stampfee=< ?=get_rate('Stamp Fee')?>
		if(document.getElementById('amount2').value==0 || thiskey=='1')
		{
			//alert(thiskey)
		document.getElementById('amount2').value=document.getElementById('amount1').value*document.getElementById('stampfee').value/100;
		document.getElementById('amount2').value=parseFloat(document.getElementById('amount2').value)-1000;
		
		}
		if(document.getElementById('amount4').value==0  || thiskey=='1')
		
		document.getElementById('amount4').value=document.getElementById('amount1').value*document.getElementById('legalfee').value/100;
		if(document.getElementById('amount6').value==0  || thiskey=='1')
		document.getElementById('amount6').value=document.getElementById('amount1').value*document.getElementById('commission').value/100;
	}
	var unselabletot=0;
	for(i=0; i< res.length-1; i++)
	{
		unselabletot=parseFloat(unselabletot)+parseFloat(document.getElementById('amount'+res[i]).value);
	}
	document.getElementById('total'+id).value=unselabletot;
	var mainlist=document.getElementById('maintask').value;
	var res2 = mainlist.split(",");
	//alert()
	var maintot=0;
	
	for(i=0; i< res2.length-1; i++)
	{
		maintot=parseFloat(maintot)+parseFloat(document.getElementById('total'+res2[i]).value);
	}
	document.getElementById('nettotal').value= maintot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	//var unselabletot=parseFloat(document.getElementById('road_ways').value)+parseFloat(document.getElementById('other_res').value)+parseFloat(document.getElementById('open_space').value)+parseFloat(document.getElementById('unselable_area').value);
	//	var seleble=parseFloat(document.getElementById('land_extend').value)-unselabletot;
		//alert(seleble);
	
	
}

</script>
 <? $this->load->view("includes/flashmessage");
 $projectprice=$details->purchase_price*$details->land_extend;
// echo 
 ?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/add_budgut" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden" name="stampfee" id="stampfee" value="<?=get_rate('Stamp Fee')?>">
                        <input type="hidden" name="legalfee" id="legalfee" value="<?=get_rate('Legal Fee')?>">
                         <input type="hidden" name="commission" id="commission" value="<?=get_rate('Introducer  Commission')?>">
                      
                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Project Budjet</h4>
							</div>
					              <div class="form-body">
									<div class="table-responsive bs-example widget-shadow">
                                   <table class="table" border="1"> <thead> <tr> <th >Task Code</th> <th >Task Name</th>  <th width="20%">Budjet</th><th width="30%">Total </th></tr> </thead>
                                   
                                   <? $count=1;$taskid=""; $nettotal=0;if($tasklist){
									    foreach($tasklist as $raw1) {
											  $taskid=$taskid.$raw1->task_id.',';
										}
									  foreach($tasklist as $raw) {
										  if($maintaskdata[$raw->task_id]['maintask'])
										  {
											  $tasktot=$maintaskdata[$raw->task_id]['maintask']->budget;
										  }
										  else
										  $tasktot=0;
										 $nettotal=$nettotal+$tasktot;
										
										  $subidlist="";
									   ?>
                                 
                                   <? if($maintaskdata[$raw->task_id]['prjsubtask']){
									   $mylist=NULL; $count=0;
									   foreach($maintaskdata[$raw->task_id]['prjsubtask'] as $subraw)
									   { $mylist[$count]=$subraw->subtask_id; $subidlist=$subidlist.$subraw->subtask_id.",";
									   ?>
                                    <tr  style=" padding:0; margin:0" > <td></td>
                                   <td style=" padding:0; margin:0" > <?=$subraw->subtask_code?> - <?=$subraw->subtask_name?></td>
                                   
                                    <td style=" padding:0; margin:0" > <div class="form-group" style=" padding:0; margin:0" ><input type="text"    class="form-control"   name="amount<?=$subraw->subtask_id?>" id="amount<?=$subraw->subtask_id?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$subraw->budget?>"  onblur="calculate_subtotal('<?=$raw->task_id?>','<?=$subraw->subtask_id?>')"  required="required"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"  style=" padding:0; margin:0"></span>
									</div></td>
                                     <td> </td></tr>
                                   
                                   <? $count++; }
								   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw){
									     if(!in_array($myraw->subtask_id,$mylist)){ $subidlist=$subidlist.$myraw->subtask_id.",";?>  
                                    <tr> <td style=" padding:0; margin:0"></td>
                                   <td style="padding:0; margin:0"> <?=$myraw->subtask_code?> - <?=$myraw->subtask_name?></td>
                                   
                                    <td style="padding:0; margin:0"> <div class="form-group"  style=" padding:0; margin:0" ><input type="text"    class="form-control" name="amount<?=$myraw->subtask_id?>" id="amount<?=$myraw->subtask_id?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0" onblur="calculate_subtotal('<?=$raw->task_id?>','<?=$myraw->subtask_id?>')" required="required"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" style=" padding:0; margin:0"></span>
									</div></td>
                                     <td> </td></tr>
                                   <?  }}
								   
								   } else { if($maintaskdata[$raw->task_id]['subtask']){
									   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw){$subidlist=$subidlist.$myraw->subtask_id.",";
									   ?>  
                                    <tr> <td></td>
                                   <td style=" padding:0; margin:0"> <?=$myraw->subtask_code?> - <?=$myraw->subtask_name?></td>
                                   
                                    <td style=" padding:0; margin:0"> <div class="form-group " style=" padding:0; margin:0"  ><input type="text"  class="form-control" name="amount<?=$myraw->subtask_id?>"   id="amount<?=$myraw->subtask_id?>" pattern="[0-9]+([\.][0-9]{0,2})?" <? if($myraw->subtask_name=='Purchase Price'){?> value="<?=$projectprice?>" <? }else{?> value="0" <? }?>onblur="calculate_subtotal('<?=$raw->task_id?>','<?=$myraw->subtask_id?>')" required="required"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"  style=" padding:0; margin:0"></span>
									</div></td>
                                     <td> </td></tr>
                                   <?  }}}$count++;
								   
								   ?>
								    <tr class="info"> <td style=" padding:0; margin:0"><?=$raw->task_code?></td>
                                   <td style=" padding:0; margin:0"> <?=$raw->task_name?>
                                   <input type="hidden"  class="form-control" id="sublist<?=$raw->task_id?>" name="sublist<?=$raw->task_id?>" value="<?=$subidlist?>">
                                   </td>
                                   
                                    <td style=" padding:0; margin:0"> </td>
                                     <td style=" padding:0; margin:0"><div class="form-group" style=" padding:0; margin:0"  > <input type="text"  class="form-control" id="total<?=$raw->task_id?>" name="total<?=$raw->task_id?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$tasktot?>" required="required"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" style=" padding:0; margin:0" ></span>
									</div></td></tr>
								   
								   <?
								    }
								 
								   
								    } ?>
                                    <tr class="active" style="font-weight:bold"><td colspan="3">Total</td><td>
                                      <input type="hidden"  class="form-control" id="maintask" name="maintask" value="<?=$taskid?>"> <input type="text"  class="form-control" id="nettotal" name="nettotal"  value="<?=number_format($nettotal,2)?>" readonly="readonly"></td></tr>
                                    </table></div>
                                       
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