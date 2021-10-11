
<style>


</style>
                       <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                      	<table class="table table-bordered" > <thead> <tr class="info"> <th  rowspan="2">ID</th> <th rowspan="2" style="min-width:150px" >Headline</th>
                        <td colspan="12">Year 1</td> 
                        <td colspan="12">Year 2</td>
                        <td colspan="12">Year 3</td>
                        <td colspan="12">Year 4</td> 
                        <td colspan="12">Year 5</td>
                        
                         <td   rowspan="2"><strong>Total</strong></td></tr>
                        <tr class="info">
                         
                        <? $headerstring='';for($i=1; $i<=96; $i++){
							$t=$i%12; if($t==0)$t=12;?>
                         <td  align="right"><strong><?=$t?>M</strong></td>
                         
                        <?  $headerstring=$headerstring.'<td  align="right"><strong>'.$t.'M</strong></td>'; }?>
                       </tr> </thead>
                       
                       <tbody> 
                                    <? $count=2; if($namelist){
									   for($t=0; $t<count($namelist);$t++){
									   $key=$namelist[$t]['thiskey'];
									   if($key=='12rental'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Easy Payment Data</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                       <? if($key=='epcbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>E/P Collection</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                       <? if($key=='epsbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>E/P Stocks</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                        <? if($key=='12interest'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>E/P Interest</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                        <? if($key=='fundbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Funding</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                        <? if($key=='inflowlbloans'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Cash Flow - Inflow</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                       <? if($key=='outflowprjx'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Cash Flow - Out Flaw</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                        <? if($key=='cashflowbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Cash Flow - Cash Balance</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                       <? if($key=='intexpLB'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Interest Expenses</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                        <? if($key=='inalblbal'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ><strong>Interest Apportionment</strong></td><?= $headerstring?></tr>
                                       <? }?>
                                         <? if($key=='inasfundedLBL'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ></td><?= $headerstring?></tr>
                                       <? }?>
                                       <? if($key=='lbliEP'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td ></td><?= $headerstring?></tr>
                                       <? }?>
                                       
                                       
                                       
                                       
                                  <tr> <td><?=$count?></td>
                                   <td width="300"> <?=$namelist[$t]['name']?></td>
                                    
                                     <? for($i=1; $i<=96; $i++){ $rawname=$i.'M';?>
                         <td align="right" ><?=number_format($fulldataset[$key][$i],2) ?></td>
                       				 <? }?>
                                     <td align="right"> </td>
                                     </tr>
                                    
                                     
                                   <? $count++; } }
								    ?>
                                   </tbody>
                                 </table>
                                    <? // ob_end_flush() ?>
                                 <br />
                       </div>
    