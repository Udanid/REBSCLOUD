<script type="text/javascript">


function expoet_excel(month,branch)
{
window.open( "<?=base_url()?>accounts/tax/eps_sum_report_excel/"+month+'/'+branch);
}
</script>


<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>ESC TAX CALCULATION
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$year?>','<?=$quoter?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      
     <tr   class="active"><th  > Project Name </th><th >LOT Number</th><th >Settle Date</th><th >Sale Price </th><th >ESC Amount</th></tr>
       
       <? $fulltot=0;?>
       
       <? 
	   $saletot=0;$esptot=0;$esprate=$epsdata->rate/100;
	  if($prjlist){ foreach($prjlist  as $prraw){ 
	    
	     if($advsettlelist[$prraw->prj_id]){
	
			foreach($advsettlelist[$prraw->prj_id] as $raw){
				//print_r($arrearspay[$raw->res_code]);
				
				$espval=$raw->discounted_price*$esprate;
				
				 $saletot= $saletot+$raw->discounted_price;
				  $esptot= $esptot+$espval;
				?>
      	<tr><td><?=$prraw->project_name?></td><td><?=$raw->lot_number?></td>
        <td><?=$raw->last_dpdate?></td>
            
          <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($espval,2)?></td>
          
           
            
            </tr>
	
        <? 

		}}  if($loansettlset[$prraw->prj_id]){
	
			foreach($loansettlset[$prraw->prj_id] as $raw){
				
				$espval=$raw->discounted_price*$esprate;
				
				 $saletot= $saletot+$raw->discounted_price;
				  $esptot= $esptot+$espval;
				
				?>
        
               	<tr><td><?=$prraw->project_name?></td><td><?=$raw->lot_number?></td>
        <td><?=date('Y-m-d',strtotime($raw->apply_date2))?></td>
            
          <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($espval,2)?></td>
            
           
        
        
      <? }}
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  ?>
      <tr class="info" style="font-weight:bold"><td colspan="3">Total</td>
      <td  align="right"><?=number_format($saletot,2)?></td>
      <td align="right"><?=number_format($esptot,2)?></td>
      
      </tr>
       <tr><td colspan="4" class="warning"> <h4>Resold Lots</h4></td></tr>
     <? $reduceesp=0;$redsale=0;
      if($advanceresale){
	
			foreach($advanceresale as $raw){
				//print_r($arrearspay[$raw->res_code]);
					if($raw->discounted_price<=$raw->down_payment){
				$espval=$raw->discounted_price*$esprate;
				
				$redsale= $redsale+$raw->discounted_price;
				//  $esptot= $esptot+$espval;
				?>
      	<tr><td><?=$raw->project_name?></td><td><?=$raw->lot_number?></td>
        <td><?=$raw->confirm_date?></td>
            
          <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($espval,2)?></td>
          
           
            
            </tr>
	
        <? $reduceesp=$reduceesp+$espval;

		}}}  if($loanresale){
	
			foreach($loanresale as $raw){
				if($raw->loan_amount<=$raw->paid_capital){	
				$espval=$raw->discounted_price*$esprate;
				
				 $redsale= $redsale+$raw->discounted_price;
				//  $esptot= $esptot+$espval;
				
				?>
        
               	<tr><td><?=$raw->project_name?></td><td><?=$raw->lot_number?></td>
        <td><?=$raw->confirm_date?></td>
            
          <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($espval,2)?></td>
            
           
        
        
      <?
	  $reduceesp=$reduceesp+$espval;
	   }}}?>
     
     <tr class="info" style="font-weight:bold"><td colspan="3">Total</td>
      <td  align="right"><?=number_format($redsale,2)?></td>
      <td align="right"><?=number_format($reduceesp,2)?></td>
      
      </tr>
     
      <tr class="danger" style="font-weight:bold"><td colspan="3">Net TurnoverTotal</td>
      <td  align="right"><?=number_format($saletot-$redsale,2)?></td>
      <td align="right"><?=number_format($esptot-$reduceesp,2)?></td>
      
      </tr>
         </table>
         
         
         
         
         
         <table  class="table table-bordered" style="width:50%">
         <tr class="info" style="font-weight:bold"><td>TOTAL TURNOVER FOR PERIOD</td> <td  align="right"><?=number_format($saletot-$redsale,2)?></td></tr>
          <tr class="info" style="font-weight:bold"><td>ESC RATE AT</td> <td  align="right"><?=number_format($epsdata->rate,2)?>%</td></tr> 
          <tr class="info" style="font-weight:bold"><td>ESC LIABILITY FOR <?=$epsdata->startdate?> TO  <?=$epsdata->enddate?></td> <td  align="right"><?=number_format(($saletot-$redsale)*$esprate,2)?>%</td></tr>
         </table></div>
    </div> 
    
</div>