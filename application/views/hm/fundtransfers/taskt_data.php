                   
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
  
                   
                    <table class="table  table-bordered"><tr><th>Task Name</th><th> Estmate Budget</th><th>Current Budget</th><th>Total Expences</th><th>Balance</th></tr>
                    <? $total=0; $count=1;if($details){ foreach ($details as $raw){
						$balance=$raw->new_budget-$raw->tot_payments;
						if($balance>0)
							$total=$total+$raw->new_budget-$raw->tot_payments;
							?>
                 		<tr><td><?=$raw->task_name?></td>
                        <td align="right"><?=number_format($raw->estimate_budget,2)?></td>
                        <td  align="right"><?=number_format($raw->new_budget,2)?></td>
                        <td  align="right"> <?=number_format($raw->tot_payments,2)?> </td>
                          <td align="right"> <?=number_format($raw->new_budget-$raw->tot_payments,2)?> </td>
                      </tr>
                    <? $count++;} }?>
                   
                    <tr style="font-weight:bold"><td> Transable Amount for Project Income</td><td colspan="3"></td><td align="right"><?=number_format($total,2)?></td></tr>
              </table>
					
				<div class="form-group validation-grids " style="float:right">
											
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Complete Project</button>
											
											
										</div>
									