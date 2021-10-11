
        <? $b='';
$b=$b.'        
      <table border="1">
       <tr style="font-weight:bold"  ><td colspan="5"  rowspan="5"><img src="'.base_url().'media/images/logo.png"> </td></tr>
	   <tr></tr>
	   <tr></tr>
	   <tr></tr>
	   <tr></tr>
	   <tr></tr>
      <tr style="font-weight:bold"  bgcolor="#d99795"><td colspan="5">Winrose Property Developers (Pvt) Ltd</td></tr>
        <tr style="font-weight:bold"  bgcolor="#d99795"><td colspan="5">ESC TAX CALCULATION</td></tr>
         <tr style="font-weight:bold" ><td colspan="2"  bgcolor="#ccc0da">YEAR OF ASSESMENT</td>';
		 
		 $b=$b.'<td  bgcolor="#ffff00" colspan="3">'.$epsdata->year.'</td></tr><tr style="font-weight:bold" ><td colspan="2"  bgcolor="#ccc0da">PERIOD </td><td  colspan="3"  bgcolor="#ffff00">'.$epsdata->quoter.' QUARTER '.$epsdata->startdate.' to  '.$epsdata->enddate.'</td></tr>';
      
     $b=$b.' <tr     bgcolor="#eaeaea"><th  > Project Name </th><th >LOT Number</th><th >Settle Date</th><th >Sale Price </th><th >ESP Amount</th></tr>';
       
      $fulltot=0;
	   $saletot=0;$esptot=0;$esprate=$epsdata->rate/100;
	   if($prjlist){foreach($prjlist  as $prraw){ 
	   
	     if($advsettlelist[$prraw->prj_id]){
	
			foreach($advsettlelist[$prraw->prj_id] as $raw){
				//print_r($arrearspay[$raw->res_code]);
				
				$espval=$raw->discounted_price*$esprate;
				
				 $saletot= $saletot+$raw->discounted_price;
				  $esptot= $esptot+$espval;
				
      	 $b=$b.'<tr><td>'.$prraw->project_name.' </td><td>'.$raw->lot_number.' </td>';
         $b=$b.'<td>'.$raw->last_dpdate.' </td>';
            
          $b=$b.' <td align="right">'.number_format($raw->discounted_price,2).' </td>';
          $b=$b.'<td align="right">'.number_format($espval,2).' </td>';
          
           
            
            $b=$b.' </tr>';
	
        

		}}  if($loansettlset[$prraw->prj_id]){
	
			foreach($loansettlset[$prraw->prj_id] as $raw){
				
				$espval=$raw->discounted_price*$esprate;
				
				 $saletot= $saletot+$raw->discounted_price;
				  $esptot= $esptot+$espval;
				
				
     
                $b=$b.'	<tr><td>'.$prraw->project_name.' </td><td>'.$raw->lot_number.' </td>';
        $b=$b.' <td>'.date('Y-m-d',strtotime($raw->apply_date2)).' </td>';
            
          $b=$b.' <td align="right">'.number_format($raw->discounted_price,2).'</td>';
         $b=$b.' <td align="right">'.number_format($espval,2).'</td>';
              $b=$b.' </tr>';
           
        
        
      }}
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  
       $b=$b.'<tr  bgcolor="#eaeaea"style="font-weight:bold"><td colspan="3">Total</td>';
      $b=$b.' <td  align="right">'.number_format($saletot,2).'</td>';
       $b=$b.'<td align="right">'.number_format($esptot,2).'</td>';
      
      $b=$b.' </tr>
     <tr></tr><tr></tr>';
	 $b=$b.' <tr><td colspan="4" class="warning"> <h4>Resold Lots</h4></td></tr>';
    $reduceesp=0;$redsale=0;
      if($advanceresale){
	
			foreach($advanceresale as $raw){
				//print_r($arrearspay[$raw->res_code]);
				if($raw->discounted_price<=$raw->down_payment){
				$espval=$raw->discounted_price*$esprate;
				
				$redsale= $redsale+$raw->discounted_price;
				//  $esptot= $esptot+$espval;
				
      	 $b=$b.'	<tr><td>'.$raw->project_name.' </td><td>'.$raw->lot_number.' </td>';
        $b=$b.' <td>'.$raw->confirm_date.' </td>';
            
          $b=$b.' <td align="right">'.number_format($raw->discounted_price,2).'</td>';
         $b=$b.' <td align="right">'.number_format($espval,2).'</td>';
              $b=$b.' </tr>';
           
	
         $reduceesp=$reduceesp+$espval;

		}}}  if($loanresale){
	
			foreach($loanresale as $raw){
					if($raw->loan_amount<=$raw->paid_capital){	
				$espval=$raw->discounted_price*$esprate;
				
				 $redsale= $redsale+$raw->discounted_price;
				//  $esptot= $esptot+$espval;
				
        
                $b=$b.'	<tr><td>'.$raw->project_name.' </td><td>'.$raw->lot_number.' </td>';
        $b=$b.' <td>'.$raw->confirm_date.' </td>';
            
          $b=$b.' <td align="right">'.number_format($raw->discounted_price,2).'</td>';
         $b=$b.' <td align="right">'.number_format($espval,2).'</td>';
              $b=$b.' </tr>';
           
            
           
        
        
    
	  $reduceesp=$reduceesp+$espval;
	   }}}
     
    $b=$b.' <tr class="info" style="font-weight:bold"><td colspan="3">Total</td>';
     $b=$b.' <td  align="right">'.number_format($redsale,2).'</td>';
     $b=$b.' <td align="right">'.number_format($reduceesp,2).'</td>';
      
    $b=$b.'  </tr>';
     
   $b=$b.'   <tr class="danger" style="font-weight:bold"><td colspan="3">Net TurnoverTotal</td>';
   $b=$b.'   <td  align="right">'.number_format($saletot-$redsale,2).'</td>';
   $b=$b.'   <td align="right">'.number_format($esptot-$reduceesp,2).'</td>';
      
   $b=$b.'   </tr>';
         
	 
	 
       $b=$b.'  </table>';
         
         $b=$b.' <table border="1" style="width:50%"  bgcolor="#eaeaea">
         <tr class="info" style="font-weight:bold"><td>TOTAL TURNOVER FOR PERIOD</td> <td  align="right">'.number_format($saletot-$redsale,2).'</td></tr>
          <tr class="info" style="font-weight:bold"><td>ESC RATE AT</td> <td  align="right">'.number_format($epsdata->rate,2).'%</td></tr> <tr class="info" style="font-weight:bold"><td>ESC LIABILITY FOR '.$epsdata->startdate.' TO '.$epsdata->enddate.'</td> <td  align="right">'.number_format(($saletot-$redsale)*$esprate,2).'%</td></tr>
         </table>';	
		 
		 header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=EPS-Report.xls");
	echo $b;