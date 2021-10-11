		<? $mnep_target=0;$mepb_target=0;$mzep_target=0;
				 $mnep_actual=0;$mzep_actual=0;$mepb_actual=0;
				  $ynep_actual=0;$yzep_actual=0;$yepb_actual=0;
				 $mcoll_actual=0;
				 $ycoll_actual=0;$ysales_actual=0;$yincome_actual=0;
                if($mforcast_NEP)
				{
					$mnep_target=$mforcast_NEP->coll_target;
				
				}
				if($mforcast_EPB)
				{
					$mepb_target=$mforcast_EPB->coll_target;
				
				}
				if($mforcast_ZEP)
				{
					$mzep_target=$mforcast_ZEP->coll_target;
				
				}
				if($mactual_NEP)
				{
					$mnep_actual=$mactual_NEP->totcap+$mactual_NEP->totint;
				
				}
				if($mactual_EPB)
				{
					$mepb_actual=$mactual_EPB->totcap;
				
				}
				if($mactual_ZEP)
				{
					$mzep_actual=$mactual_ZEP->totcap;
				
				}
				if($yactual_NEP)
				{
					$ynep_actual=$yactual_NEP->totcap+$mactual_NEP->totint;
				
				}
				if($yactual_EPB)
				{
					$yepb_actual=$yactual_EPB->totcap;
				
				}
				if($yactual_ZEP)
				{
					$yzep_actual=$yactual_ZEP->totcap;
				
				}
				if($mcollection)
				{
					$mcoll_actual=$mcollection->tot;
					
				}
				?>
                 	
				 <div class="col-md-12 grids  widget-shadow " data-example-id="basic-forms" style="margin-right:5px;"> 
                             <div class="form-title">
								<h4>FINANCE SUMMARY </h4>
							</div>
                           
                              <div  class="table-responsive bs-example widget-shadow col-md-6"   >
                              <br />
                              <table class="table table-bordered"> 
                            
                              <tr><th  colspan="2">CASH FLOW FORE CAST FOR THE MONTH </th>
                   
                             </tr>
                               <tr class="active"><th colspan="2">INFLOW  - ACTUAL AS AT DATE</th>
                   
                              </tr>
                            
                               <tr class="info"><td>DOWN PAYMENT </td>
                               <td align="right"><?=number_format($mcoll_actual,2)?></td>
                             
                              </tr>
                              <tr class="danger"><td>NEP </td>
                               <td align="right"><?=number_format($mnep_actual,2)?></td>
                             
                              </tr>
                               <tr class="success"><td>NBL </td>
                               <td align="right"><?=number_format($mepb_actual,2)?></td>
                             
                              </tr>
                                <tr class="warning"><td>NPF </td>
                               <td align="right"><?=number_format($mzep_actual,2)?></td>
                             
                              </tr>
                              
                                <tr class="warning"><td>OUT SIDE BORRWINGS</td>
                               <td align="right"><?=number_format($out_side,2,".",",")?></td>
                             
                              </tr>
                              <? $total_inflow = $out_side+$mzep_actual+$mepb_actual+$mnep_actual+$mcoll_actual?>
                               <tr class=""><td>TOTAL</td>
                               <td align="right"><?=number_format($total_inflow,2,".",",")?></td>
                             
                              </tr>
                              
                             </tr>
                               <tr class="active"><th colspan="2">OUT FLOW  - ACTUAL AS AT DATE</th>
                   
                              </tr>
                                <tr class="success"><td>BALANCE SHEET</td>
                               <td align="right"><?=number_format($balance_sheet,2,".",",")?></td>
                             
                              </tr>
                                <tr class="danger"><td>P & L</td>
                               <td align="right"><?=number_format($profit_loss,2,".",",")?></td>
                             
                              </tr>
                              <tr class=""><td>TOTAL</td>
                               <td align="right"><?=number_format($profit_loss+$balance_sheet,2,".",",")?></td>
                             
                              </tr>
                              <tr class=""><td></td>
                               <td align="right"></td>
                             
                              </tr>
                              <tr class=""><td>NET IN THE MONTH</td>
                               <td align="right"><?=number_format($total_inflow-($profit_loss+$balance_sheet),2,".",",")?></td>
                             
                              </tr>

                                
                              </table>	  
                     
                             </div>
                             
                    </div>
                   
				
            
            