


                       <div class="table-responsive bs-example widget-shadow">
                      	<table class="table table-bordered" > <thead> <tr class="info"> <th >ID</th> <th ></th>  
                        <? for($i=12; $i<=96; $i=$i+12){?>
                         <td  align="right"><strong><?=$i?>M</strong></td>
                        <? }?>
                        <td  align="right"><strong>Total</strong></td></tr> </thead>
                                   <? $count=2; if($eprates){
									   ?>
                                  <tr> <td>1</td>
                                   <td> E/P Sales %</td>
                                    
                                     <? for($i=12; $i<=96; $i=$i+12){ $rawname=$i.'M';?>
                         <td align="right" ><?=number_format($eprates->$rawname,2) ?></td>
                       				 <? }?>
                                     <td align="right"> <?=number_format($details->epsales,2)?></td>
                                     </tr>
                                     <? if($rentalchart){
										 foreach($rentalchart as $rentraw){
											 
											 ?>
                                         
                                      <tr> <td><?=$count?></td>
                                      <td><?=$rentraw->raw_name?></td><?
                                      for($i=12; $i<=96; $i=$i+12){ $rawname=$i.'M'; 
										 ?>
                         <td align="right" ><?=number_format($rentraw->$rawname,2) ?></td><? }?>
                                   <td align="right"> <?=number_format($rentraw->raw_total,2) ?></td></tr>
                                     <? $count++ ; }}?>
                                     
                                   <? }
									   
								 
								   
								    ?>
                                   
                                 </table>
                                 <br />
                       </div>
         