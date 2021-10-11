<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  	
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "monthlycashflow Report " ,
					filename: "monthlycashflow.xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });
 </script>
<style>


</style> <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
                       <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                      
                      	<table class="table table-bordered table2excel" > <thead> <tr class="info">
                         <th >ID</th> <th >Headline</th>
                        
                         
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
    