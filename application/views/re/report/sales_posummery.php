<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  		var date =  document.getElementById('rptdate').value;
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Collection Report " +date,
					filename: "Collection_" + date + ".xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });
function load_printscrean2(id,month,year)
{
		
				window.open( "<?=base_url()?>re/report_excel/get_posummery/"+id+"/"+month+"/"+year );
}
function load_printscrean3(id,fromdate,todate)
{
			window.open( "<?=base_url()?>re/report_excel/get_posummery_daterange/"+id+"/"+fromdate+"/"+todate );
	
}

</script>
<style type="text/css">

</style>
 <?
 if($month!=''){
  $heading2='PO Summary Report -  as at '.$reportdata;
 }
 else{
   $heading2=' PO Summary Report- as at'.$reportdata;
 }
 

 ?>
 <input type="hidden" id="rptdate" value="<?=$reportdata?>">
   
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right">   <span style="float:right">   <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       
       
</span>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
<table class="table table-bordered  table2excel">
      <tr><th>No</th><th>Officer Name</th><th>Project</th>
       <th>Customer Name</th>
                     <th>Contact Number</th>
                     <th>Lot Number</th>
                     <th>Extend</th>
                      <th>Perch Price</th>
                       <th>Total</th>
                        <th>Date of Reservation</th>
                         <th>Payment Mode</th>
                         <th>Down Payment Due Date</th>
                          <th>Collection</th>
                           <th>Collection %</th>
      
      
      <th>Cash Target</th><th>Cash Actual</th><th>Cash Variance</th><th>%</th>
        <th>Sales Target</th><th>Sales Actual</th><th>Sales Variance</th><th>%</th>
  </tr>
       
       <? $fulltot=0; $Currentofficercode='';
	    $otarget=0; $oactual=0; 
		 $ostarget=0; $osactual=0; 
		 $brstarget=0; $brsactual=0;
		 $totstarget=0; $totsactual=0; 
		$tottarget=0; $totactual=0; $totcode=''; $branch_code='';
		$brtarget=0; $bractual=0; 
		?>
       
       <? if($prjlist){foreach($prjlist  as $prraw){
		   $actual=0; $salesac=0;  
		   		if($totdownpayment[$prraw->prj_id])
			 	  $actual=$actual+$totdownpayment[$prraw->prj_id];
			  	 if($totsales[$prraw->prj_id])
			   	$salesac=$salesac+$totsales[$prraw->prj_id];
			   
			 	 if($target[$prraw->prj_id]>0)
					 $presentage=$actual/$target[$prraw->prj_id]*100;
			 	 else
			 	 $presentage=0;
			  
			     if($presentage>=60) $class='green'; 
				 else if($presentage<60 && $presentage>=50)  $class='blue'; 
				 else if($presentage<50 && $presentage>=25)  $class='yellow'; 
				 else $class='red';
				 
				 
			  	 if($totcode!='' & $totcode!=$prraw->officer_code)
				 {
				     if( $otarget>0)
			 			 $opresentage=$oactual/ $otarget*100;
			 			 else
			 			 $opresentage=0;
				     if($opresentage>=60) $class='green'; 
					 else if($opresentage<60 && $opresentage>=50)  $class='blue'; 
					 else if($opresentage<50 && $opresentage>=25)  $class='yellow'; 
					 else $class='red';
				  	 ?>
            		 <tr  class="info" style="font-weight:bold"><td >Total</td><td></td><td></td>
                     <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			  	<td align="right"><?=number_format($otarget,2)?></td>
                        <td align="right"><?=number_format($oactual,2)?></td>
                        <td align="right"><?=number_format($otarget-$oactual,2)?></td>
                        <td>  <div class="task-info">
									<span class="task-desc"></span>
                                   	 <span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
								</div>
								<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$opresentage?>%;"></div>
                                 </div>
                         </td>	
                         <td align="right"><?=number_format($ostarget,2)?></td>
                        <td align="right"><?=number_format($osactual,2)?></td>
                        <td align="right"><?=number_format($ostarget-$osactual,2)?></td>
                        <td> 
                        <?
                         if( $ostarget>0)
			 			 $ospresentage=$osactual/ $ostarget*100;
			 			 else
			 				 $ospresentage=0;
				  		 if($ospresentage>=60) $class='green'; 
						 else if($ospresentage<60 && $ospresentage>=50)  $class='blue'; 
						 else if($ospresentage<50 && $ospresentage>=25)  $class='yellow'; 
						 else $class='red';
						
						?>
                        
                         <div class="task-info">
									<span class="task-desc"></span>
                                   	 <span class="percentage"><?=number_format($ospresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
								</div>
								<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$ospresentage?>%;"></div>
                                 </div>
                         </td>					                         
                      </tr>
           				 <?  $oactual=0; $otarget=0; $ostarget=0; $osactual=0; 
				}?>
           		 <? if($branch_code!='' & $branch_code!=$prraw->branch_code)
				 {
				   		  if( $brtarget>0)
			 			 $bpresentage=$bractual/ $brtarget*100;
			 			 else
			 			 $bpresentage=0;
					     if($bpresentage>=60) $class='green'; 
						 else if($bpresentage<60 && $bpresentage>=50)  $class='blue'; 
						 else if($bpresentage<50 && $bpresentage>=25)  $class='yellow'; 
						 else $class='red';
				   ?>
           			  <tr  class="warning" style="font-weight:bold">
                      <td><?=get_branch_name($branch_code)?> Branch Total</td> <td></td><td></td>
           			 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			  <td align="right"><?=number_format($brtarget,2)?></td>
                      <td align="right"><?=number_format($bractual,2)?></td>
                      <td align="right"><?=number_format($brtarget-$bractual,2)?></td>
                      <td>  <div class="task-info">
									<span class="task-desc"></span>
                                    <span class="percentage"><?=number_format($bpresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$bpresentage?>%;"></div></div>
                       </td>
                       <td align="right"><?=number_format($brstarget,2)?></td>
                      <td align="right"><?=number_format($brsactual,2)?></td>
                      <td align="right"><?=number_format($brstarget-$brsactual,2)?></td>
                      <td> 
                      <?
                        if( $brstarget>0)
			 			 $bpresentage=$brsactual/ $brstarget*100;
			 			 else
			 			 $bpresentage=0;
					     if($bpresentage>=60) $class='green'; 
						 else if($bpresentage<60 && $bpresentage>=50)  $class='blue'; 
						 else if($bpresentage<50 && $bpresentage>=25)  $class='yellow'; 
						 else $class='red';
					  
					  ?> <div class="task-info">
									<span class="task-desc"></span>
                                    <span class="percentage"><?=number_format($bpresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$bpresentage?>%;"></div></div>
                       </td>
                       
                       </tr>
            			<?  $bractual=0; $brtarget=0; $brstarget=0;$brsactual=0;
				  } 
		  		 if($Currentofficercode!=$prraw->officer_code){
					$Currentofficercode=$prraw->officer_code;
		   		 ?> 
          			  <tr  class="active" style="font-weight:bold"><td><?= $prraw->officer_code?></td>
                      <td><?= $prraw->initial?> <?=$prraw->surname?></td>
         			   <td></td><td></td><td></td><td></td></tr>
         	   <?  } ?>
   					 <tr class="success"><td></td><td></td>
                     <td><?=$prraw->project_name?></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			
                     <td align="right"><?=number_format($target[$prraw->prj_id],2)?></td>
  					  <td align="right"><?=number_format($actual,2)?></td> 
                      <td align="right"><?=number_format($target[$prraw->prj_id]-$actual,2)?></td>
   						 <td>
    					 		 <div class="task-info">
									<span class="task-desc"></span>
                                    <span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
                        
    
  						  </td>
                           <td align="right"><?=number_format($sales[$prraw->prj_id],2)?></td>
  						  <td align="right"><?=number_format($salesac,2)?></td> 
                    	  <td align="right"><?=number_format($sales[$prraw->prj_id]-$salesac,2)?></td>
   						 <td>
                         <?
                         if($sales[$prraw->prj_id]>0)
								 $presentage=$salesac/$sales[$prraw->prj_id]*100;
						else
			 	 		$presentage=0;
			  
						 if($presentage>=60) $class='green'; 
						 else if($presentage<60 && $presentage>=50)  $class='blue'; 
						 else if($presentage<50 && $presentage>=25)  $class='yellow'; 
				 		else $class='red';
						 ?>
    					 		 <div class="task-info">
									<span class="task-desc"></span>
                                    <span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
                        
    
  						  </td>
   					 </tr>
                     <? if($reserlist[$prraw->prj_id]){?> 
                     
                    
						<? foreach($reserlist[$prraw->prj_id] as $sraw){
							$rate=0;if($sraw->down_payment>0) $rate=$sraw->down_payment/$sraw->sale_val*100;
							?>
                     		<tr>
                            <td></td>
                               <td></td>
                                  <td></td>
                            <td><?=$sraw->first_name?> <?=$sraw->last_name?></td>
                            <td><?=$sraw->mobile?> </td>
                            <td><?=$sraw->lot_number?> </td>
                            <td><?=$sraw->extend_perch?> </td>
                            <td align="right"><?=number_format($sraw->price_perch,2)?> </td>
                            <td align="right"><?=number_format($sraw->discounted_price,2)?> </td>
                            <td><?=$sraw->res_date?> </td>
                             <td><?=$sraw->pay_type?> </td>
                              <td><?=$sraw->dp_cmpldate?> </td>
                               <td align="right"><?=number_format($sraw->down_payment,2)?> </td>
                                 <td align="right"><?=number_format($rate,2)?> </td>
                                    <td></td>
                                       <td></td>
                                          <td></td>
                            </tr>
                     <? }?>
                    <? }?>
	
	
     			 <? $totcode=$prraw->officer_code;
				  $branch_code=$prraw->branch_code;
			   	$otarget=$otarget+$target[$prraw->prj_id];
				 $oactual=$oactual+ $actual;
			    $brtarget=$brtarget+$target[$prraw->prj_id];
				 $bractual=$bractual+ $actual;
				   $totactual=$totactual+$actual;
			   	 $tottarget=$tottarget+$target[$prraw->prj_id];
				 
				 
				 $ostarget=$ostarget+$sales[$prraw->prj_id];
				 $osactual=$osactual+ $salesac;
			    $brstarget=$brstarget+$sales[$prraw->prj_id];
				 $brsactual=$brsactual+ $salesac;
				   $totsactual=$totsactual+$salesac;
			   	 $totstarget=$totstarget+$sales[$prraw->prj_id];
				 
	//  $fulltot=$fulltot+$prjexp;
	 	  }}
	   		 if( $otarget>0)
			 			 $opresentage=$oactual/ $otarget*100;
			 			 else
			 			 $opresentage=0;
				     if($opresentage>=60) $class='green'; 
					 else if($opresentage<60 && $opresentage>=50)  $class='blue'; 
					 else if($opresentage<50 && $opresentage>=25)  $class='yellow'; 
					 else $class='red';
				  	 ?>
            		 <tr  class="info" style="font-weight:bold"><td >Total</td><td></td><td></td>
                     <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			  	<td align="right"><?=number_format($otarget,2)?></td>
                        <td align="right"><?=number_format($oactual,2)?></td>
                        <td align="right"><?=number_format($otarget-$oactual,2)?></td>
                        <td>  <div class="task-info">
									<span class="task-desc"></span>
                                   	 <span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
								</div>
								<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$opresentage?>%;"></div>
                                 </div>
                         </td>	
                         <td align="right"><?=number_format($ostarget,2)?></td>
                        <td align="right"><?=number_format($osactual,2)?></td>
                        <td align="right"><?=number_format($ostarget-$osactual,2)?></td>
                        <td> 
                        <?
                         if( $ostarget>0)
			 			 $ospresentage=$osactual/ $ostarget*100;
			 			 else
			 				 $ospresentage=0;
				  		 if($ospresentage>=60) $class='green'; 
						 else if($ospresentage<60 && $ospresentage>=50)  $class='blue'; 
						 else if($ospresentage<50 && $ospresentage>=25)  $class='yellow'; 
						 else $class='red';
						
						?>
                        
                         <div class="task-info">
									<span class="task-desc"></span>
                                   	 <span class="percentage"><?=number_format($ospresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
								</div>
								<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$ospresentage?>%;"></div>
                                 </div>
                         </td>					                         
                      </tr>
                      
                      <?
                       if( $brtarget>0)
			 			 $bpresentage=$bractual/ $brtarget*100;
			 			 else
			 			 $bpresentage=0;
					     if($bpresentage>=60) $class='green'; 
						 else if($bpresentage<60 && $bpresentage>=50)  $class='blue'; 
						 else if($bpresentage<50 && $bpresentage>=25)  $class='yellow'; 
						 else $class='red'; 
					  ?>
                  <tr  class="warning" style="font-weight:bold">
                      <td><?=get_branch_name($branch_code)?> Branch Total</td><td></td><td></td>
           			 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			  <td align="right"><?=number_format($brtarget,2)?></td>
                      <td align="right"><?=number_format($bractual,2)?></td>
                      <td align="right"><?=number_format($brtarget-$bractual,2)?></td>
                      <td>  <div class="task-info">
									<span class="task-desc"></span>
                                    <span class="percentage"><?=number_format($bpresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$bpresentage?>%;"></div></div>
                       </td>
                       <td align="right"><?=number_format($brstarget,2)?></td>
                      <td align="right"><?=number_format($brsactual,2)?></td>
                      <td align="right"><?=number_format($brstarget-$brsactual,2)?></td>
                      <td> 
                      <?
                        if( $brstarget>0)
			 			 $bpresentage=$brsactual/ $brstarget*100;
			 			 else
			 			 $bpresentage=0;
					     if($bpresentage>=60) $class='green'; 
						 else if($bpresentage<60 && $bpresentage>=50)  $class='blue'; 
						 else if($bpresentage<50 && $bpresentage>=25)  $class='yellow'; 
						 else $class='red';
					  
					  ?> <div class="task-info">
									<span class="task-desc"></span>
                                    <span class="percentage"><?=number_format($bpresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$bpresentage?>%;"></div></div>
                       </td>
                       
                       </tr>
                  <tr class="active" style="font-weight:bold">
                     <td align="right">Total </td>
                      <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			
                      <td align="right"></td>
                       <td align="right"></td>
                       <td align="right"><?=number_format($tottarget,2)?></td>
                       <td align="right"><?=number_format($totactual,2)?></td>
                       <td align="right"><?=number_format($tottarget-$totactual,2)?></td>
                       <td align="right"></td>
                       <td align="right"><?=number_format($totstarget,2)?></td>
                       <td align="right"><?=number_format($totsactual,2)?></td>
                       <td align="right"><?=number_format($totstarget-$totsactual,2)?></td>
                       <td align="right"></td>
                        </tr>
                     </table></div>
    </div> 
    
</div>