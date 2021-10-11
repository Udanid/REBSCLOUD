
<script>
function  calculate_subtotal(id,thiskey)
{

	var list=document.getElementById('sublist'+id).value;
	if(list!="")
	{
			var res = list.split(",");
			var a=document.getElementById('amount_val'+thiskey).value

			a=a.replace(/\,/g,'')
			document.getElementById('amount'+thiskey).value=a;
			document.getElementById('amount_val'+thiskey).value=parseFloat(a).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			//alert(a);
			//alert('ssssss');

			//alert(list);
			var unselabletot=0;
			for(i=0; i< res.length-1; i++)
			{
				unselabletot=parseFloat(unselabletot)+parseFloat(document.getElementById('amount'+res[i]).value);
			}
			document.getElementById('total'+id).value=unselabletot;
			document.getElementById('total_val'+id).value=parseFloat(unselabletot).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		//	alert(document.getElementById('total'+id).value);
	}
	else
	{
		document.getElementById('total'+id).value=document.getElementById('total_val'+id).value;
		document.getElementById('total_val'+id).value=parseFloat(document.getElementById('total_val'+id).value).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
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
 function change_thistot(val,key)
 {
	 a=val.replace(/\,/g,'');
	 document.getElementById('total'+key).value=a;
	 var mainlist=document.getElementById('maintask').value;
	var res2 = mainlist.split(",");
	//alert()
	var maintot=0;

	for(i=0; i< res2.length-1; i++)
	{
		maintot=parseFloat(maintot)+parseFloat(document.getElementById('total'+res2[i]).value);
	}
	document.getElementById('nettotal').value= maintot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 //alert(a)
 }
</script>
 <? $this->load->view("includes/flashmessage");
	 $projectprice=$details->purchase_price*$details->land_extend;
// echo  $projectprice;
 ?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/add_budgut" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden" name="stampfee" id="stampfee" value="<?=get_rate('Stamp Fee')?>">
                        <input type="hidden" name="legalfee" id="legalfee" value="<?=get_rate('Legal Fee')?>">
                         <input type="hidden" name="commission" id="commission" value="<?=get_rate('Introducer  Commission')?>">

                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h4>Project Budget</h4>
							</div>
					              <div class="form-body">
									<div class="table-responsive bs-example widget-shadow">
                                   <table class="table gridexample" border="1"> <thead> <tr> <th >Task Code</th> <th >Task Name</th>  <th width="20%">Budget</th><th width="30%">Total </th></tr> </thead>

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

                                    <td style=" padding:0; margin:0" > <div class="form-group" style=" padding:0; margin:0" ><input type="text"    class="form-control number-separator"   style="text-align:right"   name="amount_val<?=$subraw->subtask_id?>" id="amount_val<?=$subraw->subtask_id?>" value="<?=number_format($subraw->budget,2)?>"  onblur="calculate_subtotal('<?=$raw->task_id?>','<?=$subraw->subtask_id?>')"  required="required">
                                    <input type="hidden"    class="form-control"   name="amount<?=$subraw->subtask_id?>" id="amount<?=$subraw->subtask_id?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$subraw->budget?>"   required="required">
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"  style=" padding:0; margin:0"></span>
									</div></td>
                                     <td> </td></tr>

                                   <? $count++; }
								   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw){
									     if(!in_array($myraw->subtask_id,$mylist)){ $subidlist=$subidlist.$myraw->subtask_id.",";?>
                                    <tr> <td style=" padding:0; margin:0"></td>
                                   <td style="padding:0; margin:0"> <?=$myraw->subtask_code?> - <?=$myraw->subtask_name?></td>

                                    <td style="padding:0; margin:0"> <div class="form-group"  style=" padding:0; margin:0" ><input type="text"     class="form-control number-separator" name="amount_val<?=$myraw->subtask_id?>"  id="amount_val<?=$myraw->subtask_id?>" value="0" onblur="calculate_subtotal('<?=$raw->task_id?>','<?=$myraw->subtask_id?>')" required="required">
                                    <input type="hidden"    class="form-control" name="amount<?=$myraw->subtask_id?>" id="amount<?=$myraw->subtask_id?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0" required="required"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" style=" padding:0; margin:0"></span>
									</div></td>
                                     <td> </td></tr>
                                   <?  }}

								   } else { $maintot_val=0;if($maintaskdata[$raw->task_id]['subtask']){
									   foreach($maintaskdata[$raw->task_id]['subtask'] as $myraw){$subidlist=$subidlist.$myraw->subtask_id.",";
									   ?>
                                    <tr> <td></td>
                                   <td style=" padding:0; margin:0"> <?=$myraw->subtask_code?> - <?=$myraw->subtask_name?></td>

                                   <? $subvalue=0; if($myraw->subtask_name=='Purchase Price')$subvalue=$projectprice;
								//   if(trim($myraw->subtask_name)=='Commission')$subvalue=$projectprice*0.01;
								   		if($myraw->subtask_name=='Stamp Fees')
										{

										$subvalue=($projectprice*get_rate('Stamp Fee')/100)-1000;

										}
										if($myraw->subtask_name=='Legal Fees')
										$subvalue=($projectprice*get_rate('Legal Fee')/100);
										if($myraw->subtask_name=='Introducer Commission')
										$subvalue=($projectprice*get_rate('Introducer  Commission')/100);

										if($myraw->subtask_name=='1% tax')
										$subvalue=($projectprice*get_rate('Other Tax')/100);

										$maintot_val=$maintot_val+$subvalue;

								   ?>
                                    <td style=" padding:0; margin:0" align="right"><div class="form-group " style=" padding:0; margin:0; text-align:right"  >
                                     <input type="text"   style="text-align:right"  class="form-control number-separator" name="amount_val<?=$myraw->subtask_id?>"   value="<?=number_format($subvalue,2)?>"  id="amount_val<?=$myraw->subtask_id?>"  onblur="calculate_subtotal('<?=$raw->task_id?>','<?=$myraw->subtask_id?>')" required="required">

                                    <input type="hidden"  class="form-control" name="amount<?=$myraw->subtask_id?>"   id="amount<?=$myraw->subtask_id?>" pattern="[0-9]+([\.][0-9]{0,2})?"  value="<?=$subvalue?>"  required="required">

                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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
                                    <?
                                     if($tasktot==0){
																			 $tasktot=$maintot_val;
										 if($raw->task_name=='Land perchasing ')
									 	{
											$tasktot=$projectprice;
										 }
										  if($raw->task_name=='Stamp Fees')
									 	{
											$tasktot=$projectprice*.04;
										 }


									}

									//if($raw->task_id==15 || $raw->task_id==14)
									//$tasktot=0;
									?>
                                     <td style=" padding:0; margin:0"><div class="form-group" style=" padding:0; margin:0"  > <input type="text"  class="form-control number-separator" id="total_val<?=$raw->task_id?>" name="total_val<?=$raw->task_id?>"   onblur="change_thistot(this.value,'<?=$raw->task_id?>')"  <? if($raw->task_id==15 || $raw->task_id==14) {?> readonly="readonly"<? }?>	value="<?=number_format($tasktot,2)?>" required="required">
                                     <input type="hidden"  class="form-control" id="total<?=$raw->task_id?>" name="total<?=$raw->task_id?>"   value="<?=$tasktot?>"  required="required"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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



					</form><script	src="jquery.formnavigation.js"></script>
