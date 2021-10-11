<script type="text/javascript">


function expoet_excel(year,month,m_half)
{
window.open( "<?=base_url()?>accounts/tax/vat_schedule_excel/"+year+'/'+month+'/'+m_half);
}
</script>


<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>VAT SCHEDULE
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$year?>','<?=$month?>','<?=$m_half?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      
     <tr   class="active"><td></td><th  > Project Name </th><th >LOT Number</th><th >Sale Date</th><th >Selling Price</th><th >Extent </th><th >M/V at the date of sale without   Dvp.</th><th >Taxable Supply</th> <th >%</th> <th >Total VAT Payable</th> <th >Advance Received</th>	
       <th >VAT Payable for</th></tr>
       <? $fulltot=0;?>
       
       <? 
	   $vat=$epsdata->rate/100;
	   $tot_sale=0;$tot_market=0; $tot_extent=0;
	    $prj_sale=0;$prj_market=0; $prj_extent=0;
	   $tot_taxable=0;$tot_taxablerate=0;$tot_vatpayble=0;$tot_totrcv=0;$tot_vatrcv=0;$prj_name='';
	    $prj_taxable=0;$prj_taxablerate=0;$prj_vatpayble=0;$prj_totrcv=0;$prj_vatrcv=0;$res_code='';
	  if($reserv)
			{
				foreach($reserv as $prjraw){
	   if($total[$prjraw->res_code]>0){
		  if($res_code!=$prjraw->res_code) {
		   $res_code=$prjraw->res_code;
		   
		   if($prj_name!='' & $prj_name!=$prjraw->project_name)
		   {?>
           <tr class="info">
        <td></td>
        <td><?=$prj_name?></td><td></td>
        <td></td>
        <td align="right"><?=number_format($prj_sale,2)?></td>
        <td><?=$prj_extent?></td>
        <td align="right"><?=number_format($prj_market,2)?></td>
            
          <td align="right"><?=number_format($prj_taxable,2)?></td>
           <td align="right"><?=number_format($prj_taxablerate,2)?> %</td>
            <td align="right"><?=number_format($prj_vatpayble,2)?> </td>
             <td align="right"><?=number_format($prj_totrcv,2)?> </td>
             <td align="right"><?=number_format($prj_vatrcv,2)?> </td>
          
           
            
            </tr>
           
           <?    $prj_taxable=0;$prj_taxablerate=0;$prj_vatpayble=0;$prj_totrcv=0;$prj_vatrcv=0;  $prj_sale=0;$prj_market=0; $prj_extent=0;
		   }$prj_name=$prjraw->project_name;
		   
		   
	 $taxable=0;$taxablerate=0;$vatpayble=0;$totrcv=0;$vatrcv=0;$market=0;
	 if($prjraw->market_val)
	 $market=$prjraw->market_val;
				 $taxable=$prjraw->discounted_price-$market;
				 if($taxable!=0)
				  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
				  $vatpayble=$taxable*$vat;
				  $totrcv=$total[$prjraw->res_code];
				//$espval=$raw->discounted_price*$esprate;
				if($vatpayble>0)
				 $vatrcv= $totrcv*$taxablerate*$vat/100;
				
				 
				?>
      	<tr>
        <td></td>
        <td><?=$prjraw->project_name?></td><td><?=$prjraw->lot_number?></td>
        <td><?=$prjraw->res_date?></td>
        <td align="right"><?=number_format($prjraw->discounted_price,2)?></td>
        <td><?=$prjraw->extend_perch?></td>
        <td align="right"><?=number_format($market,2)?></td>
            
          <td align="right"><?=number_format($taxable,2)?></td>
           <td align="right"><?=number_format($taxablerate,2)?> %</td>
            <td align="right"><?=number_format($vatpayble,2)?> </td>
             <td align="right"><?=number_format($totrcv,2)?> </td>
             <td align="right"><?=number_format($vatrcv,2)?> </td>
          
           
            
            </tr>
	
        
      <? 
	  $prj_taxable=$prj_taxable+$taxable;
	  $prj_taxablerate=0;
	  $prj_vatpayble= $prj_vatpayble+$vatpayble;
	  $prj_totrcv= $prj_totrcv+$totrcv;
	  $prj_vatrcv=$prj_vatrcv+$vatrcv;
	   $prj_sale=$prj_sale+$prjraw->discounted_price;
	   $prj_market=$prj_market+$market; 
	   $prj_extent= $prj_extent+$prjraw->extend_perch;
	   
	    $tot_taxable=$tot_taxable+$taxable;
	  $tot_taxablerate=0;
	  $tot_vatpayble= $tot_vatpayble+$vatpayble;
	  $tot_totrcv= $tot_totrcv+$totrcv;
	  $tot_vatrcv=$tot_vatrcv+$vatrcv;
	   $tot_sale=$tot_sale+$prjraw->discounted_price;
	   $tot_market=$tot_market+$market; 
	   $tot_extent= $tot_extent+$prjraw->extend_perch;
	//  $fulltot=$fulltot+$prjexp;
	   }}}}
	  
	  ?>
      <tr class="info">
        <td></td>
        <td><?=$prj_name?></td><td></td>
        <td></td>
        <td><?=number_format($prj_sale,2)?></td>
        <td><?=$prj_extent?></td>
        <td><?=number_format($prj_market,2)?></td>
            
          <td align="right"><?=number_format($prj_taxable,2)?></td>
           <td align="right"><?=number_format($prj_taxablerate,2)?> %</td>
            <td align="right"><?=number_format($prj_vatpayble,2)?> </td>
             <td align="right"><?=number_format($prj_totrcv,2)?> </td>
             <td align="right"><?=number_format($prj_vatrcv,2)?> </td>
          
           
            
            </tr>
            
             <tr class="active">
        <td></td>
        <td>Total</td><td></td>
        <td></td>
        <td align="right"><?=number_format($tot_sale,2)?></td>
        <td><?=$tot_extent?></td>
        <td align="right"><?=number_format($tot_market,2)?></td>
            
          <td align="right"><?=number_format($tot_taxable,2)?></td>
           <td align="right"><?=number_format($tot_taxablerate,2)?> %</td>
            <td align="right"><?=number_format($tot_vatpayble,2)?> </td>
             <td align="right"><?=number_format($tot_totrcv,2)?> </td>
             <td align="right"><?=number_format($tot_vatrcv,2)?> </td>
          
           
            
            </tr>
     
        <tr><td colspan="12" class="warning"> <h4>Resold Lots</h4></td></tr>
       <?  $resaletot=0;
	    if($advanceresale)
			{
				foreach($advanceresale as $prjraw){
	   
	   $taxable=0;$taxablerate=0;$vatpayble=0;$totrcv=0;$vatrcv=0;$market=0;
	 if($prjraw->market_val)
	 $market=$prjraw->market_val;
				 $taxable=$prjraw->discounted_price-$market;
				 if($taxable!=0)
				  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
				  $vatpayble=$taxable*$vat;
				  $totrcv=$prjraw->down_payment;
				//$espval=$raw->discounted_price*$esprate;
				if($vatpayble>0)
				 $vatrcv= $totrcv*$taxablerate*$vat/100;
				
				 
				?>
      	<tr>
        <td></td>
        <td><?=$prjraw->project_name?></td><td><?=$prjraw->lot_number?></td>
        <td><?=$prjraw->res_date?></td>
        <td align="right"><?=number_format($prjraw->discounted_price,2)?></td>
        <td><?=$prjraw->extend_perch?></td>
        <td align="right"><?=number_format($market,2)?></td>
            
          <td align="right"><?=number_format($taxable,2)?></td>
           <td align="right"><?=number_format($taxablerate,2)?> %</td>
            <td align="right"><?=number_format($vatpayble,2)?> </td>
             <td align="right"><?=number_format($totrcv,2)?> </td>
             <td align="right"><?=number_format($vatrcv,2)?> </td>
          
           
            
            </tr>
       
       <? $resaletot=$resaletot+$vatrcv; }} if($loanresale)
			{
				foreach($loanresale as $prjraw){
	   
	   $taxable=0;$taxablerate=0;$vatpayble=0;$totrcv=0;$vatrcv=0;$market=0;
	 if($prjraw->market_val)
	 $market=$prjraw->market_val;
				 $taxable=$prjraw->discounted_price-$market;
				 if($taxable!=0)
				  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
				  $vatpayble=$taxable*$vat;
				  $totrcv=$prjraw->down_payment+$prjraw->totcap;
				//$espval=$raw->discounted_price*$esprate;
				if($vatpayble>0)
				 $vatrcv= $totrcv*$taxablerate*$vat/100;
				
				 
				?>
      	<tr>
        <td></td>
        <td><?=$prjraw->project_name?></td><td><?=$prjraw->lot_number?></td>
        <td><?=$prjraw->res_date?></td>
        <td align="right"><?=number_format($prjraw->discounted_price,2)?></td>
        <td><?=$prjraw->extend_perch?></td>
        <td align="right"><?=number_format($market,2)?></td>
            
          <td align="right"><?=number_format($taxable,2)?></td>
           <td align="right"><?=number_format($taxablerate,2)?> %</td>
            <td align="right"><?=number_format($vatpayble,2)?> </td>
             <td align="right"><?=number_format($totrcv,2)?> </td>
             <td align="right"><?=number_format($vatrcv,2)?> </td>
          
           
            
            </tr><?  $resaletot=$resaletot+$vatrcv; }}?>
             <tr style="font-weight:bold" class="active"><td colspan="11" > Deduct Total</td><td align="right"><?=number_format($resaletot,2)?></td></tr> 
         
           <tr style="font-weight:bold" class="danger"><td colspan="11" > Net Vat Payable</td><td align="right"><?=number_format($tot_vatrcv-$resaletot,2)?></td></tr> 
          
       </table>
         
        </div>
    </div> 
    
</div>