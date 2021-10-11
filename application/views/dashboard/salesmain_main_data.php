
              
					
						<p> <br>
                            <div class="form-title">
								<h4>All Branch Sales as at <?=date('Y-m-d')?></h4>
							</div>
                            
                             <br />
                            <div class="row">
                             <div class="col-md-6">
                             
                                  <table class="table table-bordered">
                                  <thead>
                                  <tr class="success"><th>Project Name</th>
                                  <th>Officer Name</th>
                                  <th>Total Blocks</th>
                                  <th>Total Sales</th>
                                  <th>Balance Block</th>
                                   <th>Balance Block %</th>
                                     <th>Balance Block Sale Value</th>
                                   
                                  </tr>
                                  </thead>
                                  <tbody>
                                     <?  if($branchlist)
									 { $COUNT=0;  $full_lots=0;$full_sale=0; $bal_lot=0; $bal_sale=0; $lotval=NULL;$balval=NULL;$lableval=NULL;;
									 foreach($branchlist as $raw)
									 {?>
                                  <?
								  
								  
								    if($prjlist[$raw->branch_code])
									{
										
										foreach($prjlist[$raw->branch_code] as $raw2)
										{  $totlots=0;$totsale=0;$soldlot=0;$soldval=0;
											if($lotcount[$raw2->prj_id])
											{
												 $totlots=$lotcount[$raw2->prj_id]->totlots;
												 $totsale=$lotcount[$raw2->prj_id]->selstot;
											}
											if($sales[$raw2->prj_id])
											{
												 $soldval=$sales[$raw2->prj_id]->selstot;
												 $soldlot=$sales[$raw2->prj_id]->totcount;
											}
											$presentage=0;
											$lotval[$COUNT]=$totlots;
											$balval[$COUNT]=$totlots-$soldlot;
											$lableval[$COUNT]=substr($details[$raw2->prj_id]->project_name,0,10);
											if($totlots>0)
											$presentage=($totlots-$soldlot)/$totlots*100;
											$full_lots=$full_lots+$totlots;
											$full_sale=$full_sale+$totsale; 
											$bal_lot=$bal_lot+($totlots-$soldlot); 
											$bal_sale=$bal_sale+($totsale-$soldval);
											$COUNT++;
											?>
                                         <tr ><th><?=$details[$raw2->prj_id]->project_name?></th>
                                          <td><?=$details[$raw2->prj_id]->surname?></td>
                                          <td><?=$totlots?></td>
                                          <td><?=number_format($totsale,2)?></td>
                                          <td><?=$totlots-$soldlot?></td>
                                           <td><?=number_format($presentage,2)?></td>
                                             <td><?=number_format($totsale-$soldval,2)?></td>
                                   
                                		  </tr>
                                  <? 	}
									}?>
                                  
                                   <? 	}
									}
									
									
									$js_lotval=NULL;$js_balval=NULL;$js_lableval=NULL;
									$js_lotval=json_encode($lotval);
									$js_balval=json_encode($balval);
									$js_lableval=json_encode($lableval);
									?>
                                      <tr class="active"><th>Total</th>
                                  <th></th>
                                  <th><?=$full_lots?></th>
                                  <th><?=number_format($full_sale,2)?></th>
                                  <th><?=$bal_lot?></th>
                                   <th>-</th>
                                     <th><?=number_format($bal_sale,2)?></th>
                                   
                                  </tr>
                                  </tbody>
                                  
                                  </table>
                              </div>
                              <div class="col-md-6">
                               <canvas id="canvas1_allbranch"  width="300"><img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif"></canvas>
                           <script type="text/javascript">
     						    var color = Chart.helpers.color;
    							    var barChartData = {
    							        labels: <?=$js_lableval?>,
    							        datasets: [{
    							            label: 'Total Blocks',
    							            backgroundColor:color(window.chartColors.blue).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.blue,
          							      borderWidth: 1,
         								       data:<?=$js_lotval?>
       									     },{
    							            label: 'Balance Blcoks',
    							            backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.purple,
          							      borderWidth: 1,
         								       data:<?=$js_balval?>
       									     }]
			

       								 };

       				    var ctx = document.getElementById("canvas1_allbranch").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
						   
						   
						  
			

       

      
    </script>
					
                              </div>
                          </div>
                           <div class="form-title">
								<h4> Officers Achievment - month of <?=date("F")?></h4>
							</div>
                            
                             <br />
                            <div class="row">
                             <div class="col-md-6">
                                  <table class="table table-bordered">
                                  <thead>
                                  <tr class="success">
                                  <th>Officer Name</th>
                                  <th>Sale Target</th>
                                  <th>Acheivment</th>
                                  
                                   <th> %</th>
                                  <th>Block Target</th>
                                  <th>Acheivment</th>
                                  
                                   <th> %</th>
                                
                                
                                  </tr>
                                  </thead>
                                  <tbody>
                                   <?  if($branchlist)
									 { $COUNT=0;  $full_lots=0;$full_sale=0; $bal_lot=0; $bal_sale=0;
								   $counter=0;
									 foreach($branchlist as $raw)
									 {?>
                                  <?
								 
								    if($offierlist[$raw->branch_code])
									{
										foreach($offierlist[$raw->branch_code] as $raw3)
										{  $totlots=0;$totsale=0;$soldlot=0;$soldval=0;
											if($target[$raw3->id])
											{
												 $totlots=$target[$raw3->id]->block;
												 $totsale=$target[$raw3->id]->sales;
											}
											if($salesachev[$raw3->id])
											{
												 $soldval=$salesachev[$raw3->id]->selstot;
												 $soldlot=$salesachev[$raw3->id]->totcount;
											}
											$label_sales[$counter]=$raw3->surname;
											$presentage_sale=0;$presentage_lot=0;
											if($totsale>0)
											$presentage_sale=($soldval)/$totsale*100;
											if($totlots>0)
											$presentage_lot=($soldlot)/$totlots*100;
											$full_lots=$full_lots+$totlots;
											$full_sale=$full_sale+$totsale; 
											$bal_lot=$bal_lot+$soldlot; 
											$bal_sale=$bal_sale+$soldval;
											$persentage_s[$counter]=$presentage_sale;
											$counter++;
											?>
                                         <tr ><th> <?=$raw3->initial?> <?=$raw3->surname?> </th>
                                          <td><?=number_format($totsale,2)?></td>
                                            <td><?=number_format($soldval,2)?></td>
                                           <td><?=number_format($presentage_sale,2)?></td>
                                            <td><?=number_format($totlots,2)?></td>
                                            <td><?=number_format($soldlot,2)?></td>
                                           <td><?=number_format($presentage_lot,2)?></td>
                                           
                                   
                                		  </tr>
                                  <? 	}
									}
									$js_label_sales=NULL;$js_persentage_s=NULL;
									$js_label_sales=json_encode($label_sales);
									$js_persentage_s=json_encode($persentage_s);
									?>
                                    
                                       <?  $COUNT++;}
				 }?>
                                    <tr class="active"><th>Total</th>
                                
                                  <th><?=number_format($full_sale,2)?></th>
                                  <th><?=number_format($bal_sale,2)?></th>
                                  
                                   <th>-</th>
                                   <th><?=number_format($full_lots,2)?></th>
                                  <th><?=number_format($bal_lot,2)?></th>
                                     <th></th>
                                   
                                  </tr>
                                  </tbody>
                                  
                                  </table>
                                 
                              </div>
                              <div class="col-md-6">
                              
                                 <canvas id="canvas_allbranch" width="300"></canvas>
                          	<script type="text/javascript">
     						  
						   
						   
						    var config = {
								type: 'pie',
								data: {
									datasets: [{
										data: <?=$js_persentage_s?>,
										backgroundColor: [
										 color(window.chartColors.red).alpha(0.5).rgbString(),
											color(window.chartColors.green).alpha(0.7).rgbString(),
											color(window.chartColors.blue).alpha(0.7).rgbString(),
											color(window.chartColors.yellow).alpha(0.7).rgbString(),
											color(window.chartColors.purple).alpha(0.7).rgbString(),
											color(window.chartColors.blue).alpha(0.7).rgbString()
										],
										label: 'Dataset 1'
									}],
									labels: <?=$js_label_sales?>
								},
								options: {
									responsive: true
								}
   						 };
						   
						    var ctx = document.getElementById("canvas_allbranch").getContext("2d");
         				 new Chart(ctx,  config);
			

       

      
    </script>
					
                              </div>
                          </div>
                        </p> 
                        
                        	
					
				
                     
              