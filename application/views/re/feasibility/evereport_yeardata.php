
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){  
      $('#create_excel2').click(function(){ 
	  	
           $(".table2excel2").table2excel({
					exclude: ".noExl",
					name: "Yearlycashflow Report " ,
					filename: "Yearlycashflow.xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });
 </script>
<?
 						  

		
									// $yearvalue[$j]['epcbalc']=0;
									 
									 
									
									
									 ?>

 <a href="#" id="create_excel2" name="create_excel2"> <i class="fa fa-file-excel-o nav_icon"></i></a>

                       <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                      	<table class="table table-bordered table2excel2" > <thead> <tr class="info"> <th ><strong>ID</strong></th>
                         <th  style="min-width:150px" ><strong>Headline</strong></th>
                        <? for ($i=1; $i<=8; $i++){?>
                        <th ><strong>Year <?=$i?></strong></td> 
                       
                        <? }?>
                        
                         <th   rowspan="2"><strong>Total</strong></td></tr>
                        </thead>
                       
                       <tbody> 
                                    <? $count=2; if($namelist){
									   for($t=0; $t<count($namelist);$t++){
									   $key=$namelist[$t]['thiskey'];
									   if($key=='12rental'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>Easy Payment Data</strong></td></tr>
                                       <? }?>
                                       <? if($key=='epcbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td colspan="10"><strong>E/P Collection</strong></td></tr>
                                       <? }?>
                                       <? if($key=='epsbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>E/P Stocks</strong></td></tr>
                                       <? }?>
                                        <? if($key=='12interest'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>E/P Interest</strong></td></tr>
                                       <? }?>
                                        <? if($key=='fundbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td colspan="10"><strong>Funding</strong></td></tr>
                                       <? }?>
                                        <? if($key=='inflowlbloans'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>Cash Flow - Inflow</strong></td></tr>
                                       <? }?>
                                       <? if($key=='outflowprjx'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>Cash Flow - Out Flaw</strong></td></tr>
                                       <? }?>
                                        <? if($key=='cashflowbalf'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td colspan="10"><strong>Cash Flow - Cash Balance</strong></td></tr>
                                       <? }?>
                                       <? if($key=='intexpLB'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>Interest Expenses</strong></td></tr>
                                       <? }?>
                                        <? if($key=='inalblbal'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"><strong>Interest Apportionment</strong></td></tr>
                                       <? }?>
                                         <? if($key=='inasfundedLBL'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"></td></tr>
                                       <? }?>
                                       <? if($key=='lbliEP'){$count=1;
									   ?>
                                       <tr class="info"><td></td><td  colspan="10"></td></tr>
                                       <? }?>
                                       
                                       
                                       
                                       
                                  <tr> <td><?=$count?></td>
                                   <td width="300"> <?=$namelist[$t]['name']?></td>
                                    
                                     <?
									
									  $rawtot=0; for($j=1; $j<=8; $j++) {
									
									
									 
									 ?>
                        				 <td align="right" ><?=number_format(  $yearvalue[$j][$key],2) ?></td>
                       				 <? $rawtot =$rawtot+ $yearvalue[$j][$key]; }?>
                                     <td align="right"><?=number_format($rawtot,2) ?> </td>
                                     </tr>
                                    
                                     
                                   <? $count++; } }
								    ?>
                                   </tbody>
                                 </table>
                                    <? // ob_end_flush() ?>
                                 <br />
                       </div>
    