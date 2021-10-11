
<script type="text/javascript">

function load_printscrean2(id,month,year)
{
		
				window.open( "<?=base_url()?>hm/report_excel/get_posummery/"+id+"/"+month+"/"+year );
}
function load_printscrean3(id,fromdate,todate)
{
			window.open( "<?=base_url()?>hm/report_excel/get_posummery_daterange/"+id+"/"+fromdate+"/"+todate );
	
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

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"><? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean3('<?=$branchid?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
           <a href="javascript:load_printscrean2('<?=$branchid?>','<?=$month?>','<?=$year?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      <tr><th>No</th><th>Officer Name</th><th>Project</th><th>Target</th><th>Actual</th><th>Variance</th><th>%</th>
   </tr>
       
       <? $fulltot=0; $Currentofficercode=''; $otarget=0; $oactual=0; $tottarget=0; $totactual=0; $totcode=''; $branch_code='';$brtarget=0; $bractual=0; ?>
       
       <? if($prjlist){foreach($prjlist  as $prraw){
		   $actual=0;   if($totadvance[$prraw->prj_id])
			   $actual=$actual+$totadvance[$prraw->prj_id]->tot;
			   if($totcapital[$prraw->prj_id])
			   {
				    $actual=$actual+$totcapital[$prraw->prj_id]->captot+$totcapital[$prraw->prj_id]->inttot;
			   }
			  if($target[$prraw->prj_id]>0)
			  $presentage=$actual/$target[$prraw->prj_id]*100;
			  else
			  $presentage=0;
			  
			     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';
			   ?>
			   
			   <? if($totcode!='' & $totcode!=$prraw->officer_code){
				     if( $otarget>0)
			  $opresentage=$oactual/ $otarget*100;
			  else
			  $opresentage=0;
				     if($opresentage>=60) $class='green'; else if($opresentage<60 && $opresentage>=50)  $class='blue'; else if($opresentage<50 && $opresentage>=25)  $class='yellow'; else $class='red';
				   ?>
             <tr  class="info" style="font-weight:bold"><td colspan="3">Total</td>
            <td align="right"><?=number_format($otarget,2)?></td><td align="right"><?=number_format($oactual,2)?></td><td align="right"><?=number_format($otarget-$oactual,2)?></td><td>  <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$opresentage?>%;"></div></td></tr>
            <?  $oactual=0; $otarget=0; }?>
            <? if($branch_code!='' & $branch_code!=$prraw->branch_code){
				     if( $brtarget>0)
			  $bpresentage=$bractual/ $brtarget*100;
			  else
			  $bpresentage=0;
				     if($bpresentage>=60) $class='green'; else if($bpresentage<60 && $bpresentage>=50)  $class='blue'; else if($bpresentage<50 && $bpresentage>=25)  $class='yellow'; else $class='red';
				   ?>
             <tr  class="warning" style="font-weight:bold"><td colspan="3"><?=get_branch_name($branch_code)?> Branch Total</td>
            <td align="right"><?=number_format($brtarget,2)?></td><td align="right"><?=number_format($bractual,2)?></td><td align="right"><?=number_format($brtarget-$bractual,2)?></td><td>  <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$bpresentage?>%;"></div></td></tr>
            <?  $bractual=0; $brtarget=0; } ?>
			   
			   
			   <?
		   if($Currentofficercode!=$prraw->officer_code){
		$Currentofficercode=$prraw->officer_code;
		    ?> 
            <tr  class="active" style="font-weight:bold"><td><?= $prraw->officer_code?></td><td><?= $prraw->initial?> <?=$prraw->surname?></td>
            <td></td><td></td><td></td><td></td></tr>
            <?  } ?>
    <tr><td></td><td></td><td><?=$prraw->project_name?></td><td align="right"><?=number_format($target[$prraw->prj_id],2)?></td>
    <td align="right"><?=number_format($actual,2)?></td> <td align="right"><?=number_format($target[$prraw->prj_id]-$actual,2)?></td>
    <td>
      <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
                        
    
    </td>
    </tr>
	
	
      <? $totcode=$prraw->officer_code;
	  $branch_code=$prraw->branch_code;
	   $otarget=$otarget+$target[$prraw->prj_id];
	    $brtarget=$brtarget+$target[$prraw->prj_id];
		 $bractual=$bractual+ $actual;
			   $oactual=$oactual+ $actual;
			   $totactual=$totactual+$actual;
			    $tottarget=$tottarget+$target[$prraw->prj_id];
	//  $fulltot=$fulltot+$prjexp;
	   }}
	    if( $otarget>0)
			  $opresentage=$oactual/ $otarget*100;
			  else
			  $opresentage=0;
				     if($opresentage>=60) $class='green'; else if($opresentage<60 && $opresentage>=50)  $class='blue'; else if($opresentage<50 && $opresentage>=25)  $class='yellow'; else $class='red';
	  
	  ?>
        <tr  class="info" style="font-weight:bold"><td colspan="3">Total</td>
            <td align="right"><?=number_format($otarget,2)?></td><td align="right"><?=number_format($oactual,2)?></td><td align="right"><?=number_format($otarget-$oactual,2)?></td><td>  <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div  class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$opresentage?>%;"></div></div></td></tr>
                                          <tr class="warning" style="font-weight:bold"><td colspan="3"> <?=get_branch_name($branch_code)?> Branch Total </td>
            <td align="right"><?=number_format($brtarget,2)?></td><td align="right"><?=number_format($bractual,2)?></td><td align="right"><?=number_format($brtarget-$bractual,2)?></td><td>  <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($opresentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									</td></tr>
      <tr class="active" style="font-weight:bold">
         <td align="right">Total </td>
          <td align="right"></td>
           <td align="right"></td>
           <td align="right"><?=number_format($tottarget,2)?></td>
           <td align="right"><?=number_format($totactual,2)?></td>
           <td align="right"><?=number_format($tottarget-$totactual,2)?></td>
           <td align="right"></td>
            </tr>
         </table></div>
    </div> 
    
</div>