<? $b='';
$b=$b.'  


                
      <table border="1">
      
     <tr  bgcolor="#d99795"><td></td><th  > Project Name </th><th >LOT Number</th><th >Sale Date</th><th >Selling Price</th><th >Extent </th><th >M/V at the date of sale without   Dvp.</th><th >Taxable Supply</th> <th >%</th> <th >Total VAT Payable</th> <th >Advance Received</th>	
       <th >VAT Payable for</th></tr>';
        $fulltot=0;
       
        
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
		   {
          $b=$b.' <tr  bgcolor="#ccc0da" style="font-weight:bold">
        <td></td>';
       $b=$b.' <td>'.$prj_name.' </td>';
       $b=$b.'   <td></td>';
       $b=$b.' <td></td>';
       $b=$b.' <td align="right">'.number_format($prj_sale,2).' </td>';
      $b=$b.'  <td>'.$prj_extent.' </td>';
      $b=$b.'  <td align="right">'.number_format($prj_market,2).' </td>';
            
       $b=$b.'   <td align="right">'.number_format($prj_taxable,2).' </td>';
       $b=$b.'    <td align="right">'.number_format($prj_taxablerate,2).'  %</td>';
        $b=$b.'    <td align="right">'.number_format($prj_vatpayble,2).' </td>';
       $b=$b.'      <td align="right">'.number_format($prj_totrcv,2).' </td>';
        $b=$b.'     <td align="right">'.number_format($prj_vatrcv,2).' </td>';
          
           
            
      $b=$b.'      </tr>';
           
              $prj_taxable=0;$prj_taxablerate=0;$prj_vatpayble=0;$prj_totrcv=0;$prj_vatrcv=0;  $prj_sale=0;$prj_market=0; $prj_extent=0;
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
				
				 
				
      $b=$b.'	<tr>';
       $b=$b.' <td> </td>';
       $b=$b.' <td>'.$prjraw->project_name.' </td>';
       $b=$b.' <td>'.$prjraw->lot_number.' </td>';
       $b=$b.' <td>'.$prjraw->res_date.' </td>';
      $b=$b.'  <td align="right">'.number_format($prjraw->discounted_price,2).' </td>';
      $b=$b.'  <td>'.$prjraw->extend_perch.' </td>';
      $b=$b.'  <td align="right">'.number_format($market,2).' </td>';
            
      $b=$b.'    <td align="right">'.number_format($taxable,2).' </td>';
       $b=$b.'    <td align="right">'.number_format($taxablerate,2).'</td>';
      $b=$b.'      <td align="right">'.number_format($vatpayble,2).' </td>';
      $b=$b.'       <td align="right">'.number_format($totrcv,2).' </td>';
       $b=$b.'      <td align="right">'.number_format($vatrcv,2).' </td>';
          
           
            
       $b=$b.'     </tr>';
	
        
      
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
	  
	 
    $b=$b.'  <tr  bgcolor="#ccc0da" style="font-weight:bold">';
    $b=$b.'    <td></td>';
     $b=$b.'   <td>'.$prj_name.' </td>';
    $b=$b.'    <td></td><td></td>';
    $b=$b.'    <td>'.number_format($prj_sale,2).' </td>';
    $b=$b.'    <td>'.$prj_extent.' </td>';
    $b=$b.'    <td>'.number_format($prj_market,2).' </td>';
            
      $b=$b.'    <td align="right">'.number_format($prj_taxable,2).' </td>';
     $b=$b.'      <td align="right">'.number_format($prj_taxablerate,2).' %</td>';
      $b=$b.'      <td align="right">'.number_format($prj_vatpayble,2).' </td>';
     $b=$b.'       <td align="right">'.number_format($prj_totrcv,2).' </td>';
      $b=$b.'       <td align="right">'.number_format($prj_vatrcv,2).' </td>';
          
           
            
   $b=$b.'         </tr>';
            
      $b=$b.'       <tr style="font-weight:bold"  bgcolor="#d99795">';
 $b=$b.'       <td></td>';
   $b=$b.'     <td>Total</td><td></td>';
    $b=$b.'    <td></td>';
   $b=$b.'     <td align="right">'.number_format($tot_sale,2).' </td>';
   $b=$b.'     <td>'.$tot_extent.' </td>';
     $b=$b.'   <td align="right">'.number_format($tot_market,2).' </td>';
            
    $b=$b.'      <td align="right">'.number_format($tot_taxable,2).' </td>';
     $b=$b.'      <td align="right">'.number_format($tot_taxablerate,2).' %</td>';
     $b=$b.'       <td align="right">'.number_format($tot_vatpayble,2).' </td>';
      $b=$b.'       <td align="right">'.number_format($tot_totrcv,2).' </td>';
       $b=$b.'      <td align="right">'.number_format($tot_vatrcv,2).' </td>';
	   
	   
          $b=$b.'    <tr><td colspan="12" class="warning"> <h4>Resold Lots</h4></td></tr>';
        $resaletot=0;
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
				
				 
	 $b=$b.'	<tr>';
       $b=$b.' <td> </td>';
       $b=$b.' <td>'.$prjraw->project_name.' </td>';
       $b=$b.' <td>'.$prjraw->lot_number.' </td>';
       $b=$b.' <td>'.$prjraw->res_date.' </td>';
      $b=$b.'  <td align="right">'.number_format($prjraw->discounted_price,2).' </td>';
      $b=$b.'  <td>'.$prjraw->extend_perch.' </td>';
      $b=$b.'  <td align="right">'.number_format($market,2).' </td>';
            
      $b=$b.'    <td align="right">'.number_format($taxable,2).' </td>';
       $b=$b.'    <td align="right">'.number_format($taxablerate,2).'</td>';
      $b=$b.'      <td align="right">'.number_format($vatpayble,2).' </td>';
      $b=$b.'       <td align="right">'.number_format($totrcv,2).' </td>';
       $b=$b.'      <td align="right">'.number_format($vatrcv,2).' </td>';
          
           
            
       $b=$b.'     </tr>';
       
       $resaletot=$resaletot+$vatrcv; }} if($loanresale)
			{
				foreach($loanresale as $prjraw){
	   
	   $taxable=0;$taxablerate=0;$vatpayble=0;$totrcv=0;$vatrcv=0;$market=0;
	 if($prjraw->market_val)
	 $market=$prjraw->market_val;
				 $taxable=$prjraw->discounted_price-$market;
				 if($taxable!=0)
				  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
				  $vatpayble=$taxable*$vat;
				  $totrcv=$prjraw->down_payment+$prjraw->totcap;;
				//$espval=$raw->discounted_price*$esprate;
				if($vatpayble>0)
				 $vatrcv= $totrcv*$taxablerate*$vat/100;
				
				
      	 $b=$b.'	<tr>';
       $b=$b.' <td> </td>';
       $b=$b.' <td>'.$prjraw->project_name.' </td>';
       $b=$b.' <td>'.$prjraw->lot_number.' </td>';
       $b=$b.' <td>'.$prjraw->res_date.' </td>';
      $b=$b.'  <td align="right">'.number_format($prjraw->discounted_price,2).' </td>';
      $b=$b.'  <td>'.$prjraw->extend_perch.' </td>';
      $b=$b.'  <td align="right">'.number_format($market,2).' </td>';
            
      $b=$b.'    <td align="right">'.number_format($taxable,2).' </td>';
       $b=$b.'    <td align="right">'.number_format($taxablerate,2).'</td>';
      $b=$b.'      <td align="right">'.number_format($vatpayble,2).' </td>';
      $b=$b.'       <td align="right">'.number_format($totrcv,2).' </td>';
       $b=$b.'      <td align="right">'.number_format($vatrcv,2).' </td>';
          
           
            
       $b=$b.'     </tr>';
	    $resaletot=$resaletot+$vatrcv; }}
		
             $b=$b.' <tr style="font-weight:bold" class="active"><td colspan="11" > Deduct Total</td><td align="right">'.number_format($resaletot,2).'</td></tr> ';
         
           $b=$b.' <tr style="font-weight:bold" class="danger"><td colspan="11" > Net Vat Payable</td><td align="right">'.number_format($tot_vatrcv-$resaletot,2).'</td></tr> ';
          

           
            
      $b=$b.'      </tr>';
     
     $b=$b.'    </table>';
         
     header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=VAT-SCHEDULE.xls");
	echo $b;