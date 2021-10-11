		<? $mnep_target=0;$mepb_target=0;$mzep_target=0;
				 $mnep_actual=0;$mzep_actual=0;$mepb_actual=0;
				  $ynep_actual=0;$yzep_actual=0;$yepb_actual=0;
				 
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
				
				?>
                 	
				 <div class="col-md-12 grids  widget-shadow " data-example-id="basic-forms" style="margin-right:5px;"> 
                             <div class="form-title">
								<h4>COLLECTION SUMMARY </h4>
							</div>
                           
                              <div  class="table-responsive bs-example widget-shadow"   >
                              <? $neppresentage=100; if($mnep_target>0) $neppresentage=$mnep_actual/$mnep_target*100;
							   if($neppresentage>=60) $nepclass='green'; else if($neppresentage<60 && $neppresentage>=50)  $nepclass='blue'; else if($neppresentage<50 && $neppresentage>=25)  $nepclass='yellow'; else $nepclass='red';
							    $epbpresentage=100; if($mepb_target>0) $epbpresentage=$mepb_actual/$mepb_target*100;
							   if($epbpresentage>=60) $epbclass='green'; else if($epbpresentage<60 && $epbpresentage>=50)  $epbclass='blue'; else if($epbpresentage<50 && $epbpresentage>=25)  $epbclass='yellow'; else $epbclass='red';
							    $zeppresentage=100; if($mzep_target>0) $zeppresentage=$mzep_actual/$mzep_target*100;
							   if($zeppresentage>=60) $zepclass='green'; else if($zeppresentage<60 && $zeppresentage>=50)  $zepclass='blue'; else if($zeppresentage<50 && $zeppresentage>=25)  $zepclass='yellow'; else $zepclass='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="active"><th></th><th>NEP</th><th>NPF</th><th>MBL</th></tr>
                              <tr><th width="40%">FORECAST FOR THE MONTH </th>
                              <td align="right"><?=number_format($mnep_target,2)?></td>
                              <td align="right"><?=number_format($mzep_target,2)?></td>
                              <td align="right"><?=number_format($mepb_target,2)?></td></tr>
                              <tr><th>ACTUAL AS AT DATE </th>
                               <td align="right"><?=number_format($mnep_actual,2)?></td>
                              <td align="right"><?=number_format($mzep_actual,2)?></td>
                              <td align="right"><?=number_format($mepb_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE </th>
                               <td align="right"><?=number_format($mnep_target-$mnep_actual,2)?></td>
                               <td align="right"><?=number_format($mzep_target-$mzep_actual,2)?></td>
                               <td align="right"><?=number_format($mepb_target-$mepb_actual,2)?></td>
                              </tr>
                               <tr><th>PERCENTAGE</th>
                               <td align="right"> <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($neppresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$nepclass?>" style="width:<?=$neppresentage?>%;"></div></td>
                                          <td align="right"> <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($zeppresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$zepclass?>" style="width:<?=$zeppresentage?>%;"></div></td>
                                          <td align="right"> <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($epbpresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$epbclass?>" style="width:<?=$epbpresentage?>%;"></div></td></tr>
                                         <tr><th colspan="4"></th></tr>
                                         
                                          <tr class="yellow"><th>TOTAL COLLECTION AS AT DATE  FOR THE YEAR</th>
                               <td align="right"><?=number_format($ynep_actual,2)?></td>
                              <td align="right"><?=number_format($yzep_actual,2)?></td>
                              <td align="right"><?=number_format($yepb_actual,2)?></td></tr>
                                <tr><th colspan="4"></th></tr>
                                         
                                          <tr class="info"><th>NO OF CONTRACT SUMMERY</th>
                               <td align="right"><?=$count_NEP?></td>
                              <td align="right"><?=$count_ZEP?></td>
                              <td align="right"><?=$count_EPB?></td></tr>
                              </table>	  
                     
                             </div>
                             
                    </div>
                   
				
            
            