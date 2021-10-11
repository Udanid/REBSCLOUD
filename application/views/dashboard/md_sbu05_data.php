		<? $mcoll_target=0;$msales_target=0;$mincome_target=0;
				 $mcoll_actual_0005=0;$msales_actual_0005=0;$mincome_actual_0005=0;
				 
				 $ycoll_actual_0005=0;$ysales_actual_0005=0;$yincome_actual_0005=0;
                if($mforcast_0005)
				{
					$mcoll_target_0005=$mforcast_0005->coll_target;
					$msales_target_0005=$mforcast_0005->sales_target;
					$mincome_target_0005=$mforcast_0005->income_target;
				}
				if($msales_0005)
				{
					$msales_actual_0005=$msales_0005->selstot;
					$mincome_actual_0005=$msales_0005->selstot-$msales_0005->costtot;
				}
				if($mcollection_0005)
				{
					$mcoll_actual_0005=$mcollection_0005->tot;
					
				}
				if($ysales_0005)
				{
					$ysales_actual_0005=$ysales_0005->selstot;
					$yincome_actual_0005=$ysales_actual_0005-$ysales_0005->costtot;
				}
				if($ycollection_0005)
				{
					$ycoll_actual_0005=$ycollection_0005->tot;
					
				}
				
				?>
                 	
				 <div class="col-md-6 validation-grids  widget-shadow " data-example-id="basic-forms" style="margin-right:5px;"> 
                             <div class="form-title">
								<h4>Yearly  Summery</h4>
							</div>
                           
                              <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($ysales_target_0005>0) $presentage=$ysales_actual_0005/$ysales_target_0005*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr><th width="40%">SALES TARGET </th><td align="right"><?=number_format($ysales_target_0005,2)?></td></tr>
                              <tr><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($ysales_actual_0005,2)?></td></tr>
                               <tr><th>VARIANCE</th><td align="right"><?=number_format($ysales_target_0005-$ysales_actual_0005,2)?></td></tr>
                               <tr><th>PERCENTAGE</th><td align="right"> <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                               <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($ycoll_target_0005>0) $presentage=$ycoll_actual_0005/$ycoll_target_0005*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr><th width="40%">D/P COLLECTION TARGET </th><td align="right"><?=number_format($ycoll_target_0005,2)?></td></tr>
                              <tr><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($ycoll_actual_0005,2)?></td></tr>
                               <tr><th>VARIANCE</th><td align="right"><?=number_format($ycoll_target_0005-$ycoll_actual_0005,2)?></td></tr>
                               <tr><th>PERCENTAGE</th><td align="right"> <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                              <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($yincome_target_0005>0) $presentage=$yincome_actual_0005/$yincome_target_0005*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr><th width="40%">INCOME TARGET </th><td align="right"><?=number_format($yincome_target_0005,2)?></td></tr>
                              <tr><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($yincome_actual_0005,2)?></td></tr>
                               <tr><th>VARIANCE</th><td align="right"><?=number_format($yincome_target_0005-$yincome_actual_0005,2)?></td></tr>
                               <tr><th>PERCENTAGE</th><td align="right"><div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                    </div>
                     <div class="col-md-6 validation-grids  widget-shadow" data-example-id="basic-forms"> 
                             <div class="form-title">
								<h4>Monthly  Summery</h4>
							</div>
                            <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($msales_target_0005>0){ $presentage=$msales_actual_0005/$msales_target_0005*100;}
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr><th width="40%">SALES TARGET </th><td align="right"><?=number_format($msales_target_0005,2)?></td></tr>
                              <tr><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($msales_actual_0005,2)?></td></tr>
                               <tr><th>VARIANCE</th><td align="right"><?=number_format($msales_target_0005-$msales_actual_0005,2)?></td></tr>
                               <tr><th>PERCENTAGE</th><td align="right"> <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                              <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($mcoll_target_0005>0) $presentage=$mcoll_actual_0005/$mcoll_target_0005*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr><th width="40%">D/P COLLECTION TARGET </th><td align="right"><?=number_format($mcoll_target_0005,2)?></td></tr>
                              <tr><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($mcoll_actual_0005,2)?></td></tr>
                               <tr><th>VARIANCE</th><td align="right"><?=number_format($mcoll_target_0005-$mcoll_actual_0005,2)?></td></tr>
                               <tr><th>PERCENTAGE</th><td align="right"> <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  

                     
                             </div>
                              <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($mincome_target_0005>0) $presentage=$mincome_actual_0005/$mincome_target_0005*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr><th width="40%">INCOME TARGET </th><td align="right"><?=number_format($mincome_target_0005,2)?></td></tr>
                              <tr><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($mincome_actual_0005,2)?></td></tr>
                               <tr><th>VARIANCE</th><td align="right"><?=number_format($mincome_target_0005-$mincome_actual_0005,2)?></td></tr>
                               <tr><th>PERCENTAGE</th><td align="right"> <div>
                                    <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                    </div>
				
            
            