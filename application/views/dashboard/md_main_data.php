		<? $mcoll_target=0;$msales_target=0;$mincome_target=0;
				 $mcoll_actual=0;$msales_actual=0;$mincome_actual=0;
				 
				 $ycoll_actual=0;$ysales_actual=0;$yincome_actual=0;
				 $y_epincomeact=0; $m_epincomeact=0; $y_epincomefor=0; $m_epincomefor=0;
                if($mforcast)
				{
					$mcoll_target=$mforcast->coll_target;
					$msales_target=$mforcast->sales_target;
					$mincome_target=$mforcast->income_target;
				}
				if($msales)
				{
					$msales_actual=$msales->selstot;
					$mincome_actual=$msales_actual-$msales->costtot;
				}
				if($mcollection)
				{
					$mcoll_actual=$mcollection->tot;
					
				}
				if($mepincome)
				{
					$m_epincomeact=$mepincome->inttot;
					
				}
				if($yepincome)
				{
					$y_epincomeact=$yepincome->inttot;
					
				}
				if($mepincomeforcast)
				{
					$m_epincomefor=$mepincomeforcast->inttot-($mepincomeforcast->paidint-$m_epincomeact);
					
				}
				if($ysales)
				{
					$ysales_actual=$ysales->selstot;
					$yincome_actual=$ysales_actual-$ysales->costtot;
				}
				if($ycollection)
				{
					$ycoll_actual=$ycollection->tot;
					
				}
				
				?>
                 	
				 
                     <div class="col-md-12  widget-shadow" data-example-id="basic-forms"> 
                             <div class="form-title">
								<h4>Monthly  Summery</h4>
							</div>
                            <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($msales_target>0){ $presentage=$msales_actual/$msales_target*100;}
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">SALES TARGET </th><td align="right"><?=number_format($msales_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($msales_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($msales_target-$msales_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">  <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                                  <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($mincome_target>0) $presentage=$mincome_actual/$mincome_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">INCOME TARGET </th><td align="right"><?=number_format($mincome_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($mincome_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($mincome_target-$mincome_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">  <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                                  <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($m_epincomefor>0) $presentage=$m_epincomeact/$m_epincomefor*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">EP INCOME TARGET </th><td align="right"><?=number_format($m_epincomefor,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($m_epincomeact,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($m_epincomefor-$m_epincomeact,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">  <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  
                     
                             </div>
                              <div  class="table-responsive bs-example widget-shadow"   >
                              <? $presentage=100; if($mcoll_target>0) $presentage=$mcoll_actual/$mcoll_target*100;
							   if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
							  ?>
                              <table class="table table-bordered"> 
                              <tr class="warning"><th width="40%">D/P COLLECTION TARGET </th><td align="right"><?=number_format($mcoll_target,2)?></td></tr>
                              <tr class="success"><th>ACHIVEMENT UP TO THE MONTH</th><td align="right"><?=number_format($mcoll_actual,2)?></td></tr>
                               <tr class="danger"><th>VARIANCE</th><td align="right"><?=number_format($mcoll_target-$mcoll_actual,2)?></td></tr>
                               <tr class="info"><th>PERCENTAGE</th><td align="right">  <div class="col-sm-9">
                                    		<div  class="progress progress-striped active">
										 		<div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3"><span class="percentage"><?=number_format($presentage,2)?>%</span></div>
                                  </div></td></tr>
                              </table>	  

                     
                             </div>
                         
                    </div>
				
            
            