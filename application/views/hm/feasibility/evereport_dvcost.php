					  <div class="  widget-shadow" data-example-id="basic-forms"> 
                          <div class="table-responsive bs-example widget-shadow">
						<table class="table table-bordered"> <thead> <tr class="info"> <th >ID</th> <th >Task Name</th>  <th >Total Budget</th>
                        <? for($i=1; $i<=12; $i++){ $rawtot[$i]=0?>
                         <th ><?=$i?>M</th>
                        <? } ?>
                        </tr> </thead>
                                   <? $count=1; if($developmentcost){
									  foreach($developmentcost as $raw) {
										 
									   ?>
                                  <tr> <td><?=$count?></td>
                                   <td> <?=$raw->task_name?></td>
                                    <td align="right"> <?=number_format($raw->budget,2)?></td>
                                     <? for($i=1; $i<=12; $i++){ $rawname=$i.'M';  $rawtot[$i]= $rawtot[$i]+$raw->$rawname;?>
                         <td align="right" ><?=number_format($raw->$rawname,2) ?></td>
                       				 <? }?></tr>
                                  
                                   <? $count++ ;}
									   
								   }
								   
								    ?>
                                    <?  $salestot=0; $loantot=0;$fulltot=0;for($i=1; $i<=12; $i++){ ;
									$salestot=$salestot+$fulldataset['salestax'][$i];
									$loantot=$loantot+$bankloan[$i];
									$rawtot[$i]=$rawtot[$i];//+$fulldataset['salestax'][$i];
									$fulltot=$fulltot+$rawtot[$i];
									}?>
                                    <tr><td><?=$count?></td><td>Sales Tax</td>
                                    <td align="right" ><?=number_format($salestot,2) ?></td>
                                    <? for($i=1; $i<=12; $i++){ ;?>
                         <td align="right" ><?=number_format($fulldataset['salestax'][$i],2) ?></td><? }?>
                                    </tr>
                                     <tr class="warning"><td></td><td>Total</td>
                                    <td align="right" ><?=number_format($fulltot,2) ?></td>
                                    <? for($i=1; $i<=12; $i++){ ;?>
                         <td align="right" ><?=number_format($rawtot[$i],2) ?></td><? }?>
                                    </tr>
                                    <tr class="success"><td></td><td>Land Bank loan Receipts</td>
                                    <td align="right" ><?=number_format($loantot,2) ?></td>
                                    <? for($i=1; $i<=12; $i++){ ;?>
                         <td align="right" ><?=number_format($bankloan[$i],2) ?></td><? }?>
                                    </tr>
                                   
                                 </table>
                                 
                                 </div>
									
				
                        </div>
                     
                      
                       
         