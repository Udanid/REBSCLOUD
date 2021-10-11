
 <? $b='';
$b=$b.'   

      <table border="1">
      
     <tr   style="font-weight:bold"  bgcolor="#d99795"><td></td><th  > Invoice Date </th><th >Tax Invoice Number</th>
     <th >Suppliers TIN</th><th >Name of the Supplier</th><th >Description</th><th >Value of purchase </th><th >VAT Amount</th> </tr>';
        $fulltot=0;
       
     
	   $vat=$epsdata->rate/100;
	   $tot_sale=0;
	  if($reserv)
			{
				foreach($reserv as $prjraw){
	
		   


	
				
				 
				
      	$b=$b.'<tr>';
        $b=$b.'<td></td>';
       $b=$b.' <td>'.$prjraw->date.' </td>';
        $b=$b.'<td>'.$prjraw->inv_no.' </td>';
        $b=$b.'<td>'.$prjraw->sup_tin.' </td>';
       $b=$b.' <td >'.$prjraw->first_name.' '.$prjraw->last_name.' </td>';
       $b=$b.' <td>'.$prjraw->note.' </td>';
       $b=$b.' <td align="right">'.number_format($prjraw->total,2).' </td>';
            
         $b=$b.' <td align="right">'.number_format($prjraw->vat_amount,2).' </td>';
         
          
           
            
           $b=$b.' </tr>';
	
        
     
	  $tot_sale=$tot_sale+$prjraw->vat_amount;
	  
	//  $fulltot=$fulltot+$prjexp;
	  }}
	  
	
    
            
        $b=$b.'     <tr style="font-weight:bold"  bgcolor="#d99795">
        <td></td>
        <td colspan="4">Total</td><td></td>
        <td></td>';
       $b=$b.' <td align="right">'.number_format($tot_sale,2).' </td>';
     
           
            
           $b=$b.' </tr>
     
         </table>';
         	 header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=INPUT-VAT-Report.xls");
	echo $b;
      