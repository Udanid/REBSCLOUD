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
       
       <? if($salselist){foreach($salselist  as $prraw){
		   $actual=0; $salesac=0;  
		     if( $sales[$prraw->id]>0)
			 $salesac= $sales[$prraw->id];
		  
		    		 	 if($totcode!='' & $totcode!=$prraw->id)
				 {
				     if( $sales[$prraw->id]>0)
			 			 $opresentage=$oactual/ $sales[$prraw->id]*100;
			 			 else
			 			 $opresentage=0;
				     if($opresentage>=60) $class='green'; 
					 else if($opresentage<60 && $opresentage>=50)  $class='blue'; 
					 else if($opresentage<50 && $opresentage>=25)  $class='yellow'; 
					 else $class='red';
				  	 ?>
            		 <tr  class="info" style="font-weight:bold"><td >Total</td><td></td><td></td>
                     <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			  	<td align="right"><?=number_format($sales[$prraw->id],2)?></td>
                        <td align="right"><?=number_format($oactual,2)?></td>
                        <td align="right"><?=number_format($sales[$prraw->id]-$oactual,2)?></td>
                        <td>  <div class="task-info">
									<span class="task-desc"></span>
                                   	 <span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
								</div>
								<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$opresentage?>%;"></div>
                                 </div>
                         </td>	
                       					                         
                      </tr>
           				 <?  $oactual=0; $otarget=0; $ostarget=0; $osactual=0; 
				}
           		$totcode=$prraw->id;
		  		 if($Currentofficercode!=$prraw->id){
					$Currentofficercode=$prraw->id;
		   		 ?> 
          			  <tr  class="active" style="font-weight:bold"><td><?= $prraw->id?></td>
                      <td><?= $prraw->initial?> <?=$prraw->surname?></td>
         			   <td></td> <td></td> <td></td> <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
         	   <?  } ?>
   					
                     <? if($reslist[$prraw->id]){?> 
                     
                    
						<? foreach($reslist[$prraw->id] as $sraw){
							$rate=0;if($sraw->down_payment>0) $rate=$sraw->down_payment/$sraw->sale_val*100;
							 $oactual= $oactual+$sraw->discounted_price;
							 $totactual=$totactual+$sraw->discounted_price;;
							?>
                     		<tr>
                            <td></td>
                               <td></td>
                                  <td><?=$sraw->project_name?></td>
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
                                       <td></td><td></td>
                                          <td></td>
                            </tr>
                     <? }?>
                    <? }?>
	
	
     			 <? 
				 
	//  $fulltot=$fulltot+$prjexp;
	
			 $fulltot=$fulltot+$salesac;
		  
			
	 	  }}
	   		 if( $sales[$prraw->id]>0)
			 			 $opresentage=$oactual/ $sales[$prraw->id]*100;
			 			 else
			 			 $opresentage=0;
				     if($opresentage>=60) $class='green'; 
					 else if($opresentage<60 && $opresentage>=50)  $class='blue'; 
					 else if($opresentage<50 && $opresentage>=25)  $class='yellow'; 
					 else $class='red';
				  	 ?>
            		 <tr  class="info" style="font-weight:bold"><td >Total</td><td></td><td></td>
                     <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			  	<td align="right"><?=number_format($sales[$prraw->id],2)?></td>
                        <td align="right"><?=number_format($oactual,2)?></td>
                        <td align="right"><?=number_format($sales[$prraw->id]-$oactual,2)?></td>
                        <td>  <div class="task-info">
									<span class="task-desc"></span>
                                   	 <span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
								</div>
								<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$opresentage?>%;"></div>
                                 </div>
                         </td>	
                       				                         
                      </tr>
                      
                     
                  <tr class="active" style="font-weight:bold">
                     <td align="right">Total </td>
                      <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
         			
                      <td align="right"></td>
                       <td align="right"></td>
                       <td align="right"><?=number_format($fulltot,2)?></td>
                       <td align="right"><?=number_format($totactual,2)?></td>
                       <td align="right"><?=number_format($fulltot-$totactual,2)?></td>
                       <td align="right"></td>
                     
                        </tr>
                     </table></div>
    </div> 
    
</div>