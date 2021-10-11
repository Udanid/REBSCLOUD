                   
       <script type="text/javascript">
	   
	   function calculete_brdgettot()
	   {
		  
		   var count=parseFloat(document.getElementById('counter').value)
		   var maintot=0;
		   var curentval=0;
		   for(i=1; i<count; i++)
			{
				
				curentval=document.getElementById('newbdg'+i).value;
				maintot=parseFloat(maintot)+parseFloat(curentval);
				
				document.getElementById('newbdg_display'+i).value=parseFloat(curentval).toLocaleString();
			}
		
			document.getElementById('fulltot').value= maintot.toLocaleString();
	   }
	   </script>             <h3>   <div style="float:right; padding-right:20px;"> <? if($prjdata->budgut_status=='PENDING' & $prjdata->status=='CONFIRMED'){?>
       		<a href="javascript:call_confirm_budget('<?=$prjdata->prj_id?>')"><span class="label label-success">Confirm Budget</span></a>
					<? }?></div></h3><br />
  
                   
                    <table class="table"><tr><th>Task Name</th><th>Last Estimation</th><th>New Budget</th><th>Value</th><th>Total</th></tr>
                    <? $total=0; $count=1;if($details){ foreach ($details as $raw){
							$total=$total+$raw->estimate_budget;
							?>
                 		<tr><td><?=$raw->task_name?></td><td align="right"><?=number_format($raw->estimate_budget,2)?></td>
                        <td>
                        <input type="number" step="0.01" class="form-control" id="newbdg<?=$count?>"  name="newbdg<?=$count?>"  value="<?=$raw->estimate_budget?>"  onblur="calculete_brdgettot()"  data-error=""  required="required" ></td>
                        <td> <input type="text" readonly="readonly" class="form-control" id="newbdg_display<?=$count?>" name="newbdg_display<?=$count?>"  value=""   data-error=""  required="required" >
                        <input type="hidden" name="task_id<?=$count?>" id="task_id<?=$count?>" value="<?=$raw->task_id?>" />
                        <input type="hidden" name="new_budget<?=$count?>" id="new_budget<?=$count?>" value="<?=$raw->new_budget?>" />
                          <input type="hidden" name="estimate<?=$count?>" id="estimate<?=$count?>" value="<?=$raw->estimate_budget?>" />
                         </td>
                      </tr>
                    <? $count++;} }?>
                    <input type="hidden" name="counter" id="counter" value="<?=$count?>" />
                    <tr style="font-weight:bold"><td>Total</td><td align="right"><?=number_format($total,2)?></td><td></td><td><input type="text" readonly="readonly" class="form-control" id="fulltot" name="fulltot"  value=""   data-error=""  required="required" ></td></tr>
              </table>
					
				<div class="form-group validation-grids " style="float:right">
											<? if($prjdata->budgut_status=='PENDING'){?>
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button>
											<? }?>
											
										</div>
									