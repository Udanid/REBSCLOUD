
<?
$b='';

     $b=$b.' <table width="100%" border="1">
      
     <tr    bgcolor="#98e5f3"><th  > Project Name </th><th >LOT Number</th><th >Monthly Instalment</th>
          <th >Arrears Amount as at '.$sartdate.'</th>
         <th >Recieved Amount During the month</th>
         <th >Arrears Amount as at '.$date.'</th>
          <th >Arrears number of Instalments</th>
		  
          </tr>';
      $fulltot=0;
	  $fstartarrarstot=0;$farrtot=0; $fthismonthpay=0;
	   if($prjlist){foreach($prjlist  as $prraw){ 
		   
		   if($transferlist[$prraw->prj_id]){
			
			
             $b=$b.'   <tr bgcolor="#CCCCCC"style="font-weight:bold"><td>'.$details[$prraw->prj_id]->project_name.'</td><td colspan="27"></td></tr>';
			   
			   foreach($transferlist[$prraw->prj_id] as $raw){
				//print_r($arrearspay[$raw->res_code]);
				$arrearsmonth=0;$thismonthpay=0;$arrinscount=0;$creditmonth=0;$arrtot=0;
                $startarrarstot=0;
                if($arrearspay[$raw->res_code])
                {
                     $startarrarstot=$arrearspay[$raw->res_code]->arriastot-$startpayment[$raw->res_code];
                }
				if($thispay[$raw->res_code])
                {
                   $thismonthpay=$thispay[$raw->res_code]->sum_cap+$thispay[$raw->res_code]->sum_int; 
                }
				  $loanstdatearr=explode('-',$raw->start_date);
                $curentdatearr=explode('-',$date);
                if($curentdatearr[2]>$loanstdatearr[2])
                {
                   
                        $arrtot= ($startarrarstot+$raw->montly_rental)-$thismonthpay;
                   
                   
                }
                else{
                     $arrtot= ($startarrarstot)-$thismonthpay;
                }
                $closins=round($arrtot/$raw->montly_rental,0);
                    $myclass="";
				 if($closins >= 3)
				 $myclass="red";
				   
				   
 $b=$b.' <tr ><td>'.$raw->loan_code.'</td>';
         	 $b=$b.'<td>'.$raw->lot_number.'</td>';
            
         	 $b=$b.' <td align="right">'.number_format($raw->montly_rental,2).'</td>';
         	 $b=$b.'<td align="right">'.number_format($startarrarstot,2).'</td>';
          	 $b=$b.'  <td align="right">'.number_format($thismonthpay,2).'</td>';
            	 $b=$b.'  <td align="right">'.number_format($arrtot,2).'</td>';
             	 $b=$b.'  <td align="right">'.$closins.'</td>';
               
             if($feedback[$raw->res_code]){
			  $b=$b.' <td align="right">'.$feedback[$raw->res_code]->follow_date.'</td>';
			   $b=$b.'<td align="right">'.$feedback[$raw->res_code]->contact_media.'</td>';
			   $b=$b.'<td align="right">'.$feedback[$raw->res_code]->sales_feedback.'</td>';
			   $b=$b.'<td align="right">'.$feedback[$raw->res_code]->cus_feedback.'</td>';
               
            }
          $b=$b.'   </tr>';
		  $fstartarrarstot= $fstartarrarstot+$startarrarstot;
              $farrtot= $farrtot+$arrtot; 
                $fthismonthpay= $fthismonthpay+$thismonthpay; 				   
				   
				   
				   
			   }
			   
		   }
		   
		   
		   
 }}


      $b=$b.' <tr class="active" style="font-weight:bold">';
        $b=$b.'  <td align="right" colspan="2">Total</td>';
          $b=$b.'               <td align="right"></td>';
          $b=$b.'     <td align="right">'.number_format($fstartarrarstot,2).'</td>';
          $b=$b.'   <td align="right">'.number_format($fthismonthpay,2).'</td>';
            $b=$b.'   <td align="right">'.number_format($farrtot,2).'</td>';
            $b=$b.'     <td align="right"></td>';
               
          $b=$b.'    </tr>
         </table>';
          $b=$b.'    </tr>
         </table>';
 	  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=EP-Collection-Report.xls");
	echo $b;
        