

<?
  $heading2=' Profit Summery Report as at ';

 $b='';
$b=$b.'
	
    <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr>
    <tr>
    <th>Project Name</th><td>'.$details->project_name.'</td>
    <th>Town</th><td>'.$details->town.'</td>
     <th>Branch Name</th><td>'.$details->branch_name.'</td> </tr>';
   $c=0;$current=0;$paidtotal=0;$totsale=0;;
   if($transferlist){
		foreach($transferlist as $raw){
			if($lotdata[$raw->res_code]->status=='SOLD'){
			$current=$raw->down_payment+$paidcap[$raw->res_code];
			$presentage=($current/$raw->discounted_price)*100;
			
			
			$paidtotal=($raw->discounted_price-$lotdata[$raw->res_code]->costof_sale)+$paidtotal;
		$totsale=$totsale+$raw->discounted_price;
			}}}
			
 
   
  $b=$b.'  <tr>';
   $b=$b.' <th>Total Selling Price</th><td>'.number_format($projecttots->totsale,2).'</td>';
  $b=$b.'  <th>Cost of Sale</th><td>'.number_format($projecttots->totcost,2).'</td>';
 $b=$b.'    <th>Expected Profit</th><td>'.number_format($projecttots->totsale-$projecttots->totcost,2).'</td>';
  
 $b=$b.'   </tr>';
 $b=$b.'   <tr> <th>Actual Sales</th><td>'.number_format($totsale,2).'</td>';
 $b=$b.'   <th>Realized Profit</th><td>'.number_format($paidtotal,2).'</td>';
 $b=$b.'   
  </tr>
      </table>
          <table border="1"  width="100%" > <thead> <tr  bgcolor="#b2ebf9">  <th>Res Code</th><th>Lot Number</th><th>Profit Transfer Date</th><th>Selling Price </th><th>Cost of Sale</th>
         <th>Paid Total</th><th>Actual Profit</th><th>Realized Profit</th> <th>Settlement Type</th> s</tr> </thead>';
                  
    if($transferlist){$c=0;$current=0;$paidtotal=0;
		foreach($transferlist as $raw){
			if($lotdata[$raw->res_code]->status=='SOLD'){
			//$current=$paidadvance[$raw->res_code]+$paidcap[$raw->res_code];
			$current=$raw->down_payment+$paidcap[$raw->res_code];
			$presentage=($current/$raw->discounted_price)*100;
			$paidtotal=$paidtotal+$current;
	
 $b=$b.'     <tbody> <tr> ';
                         $b=$b.' <th scope="row">'.$raw->res_code.'</th> <th scope="row">'.$lotdata[$raw->res_code]->lot_number.'</th> <th scope="row">'.$raw->profit_date.'</th>';
                       $b=$b.' <td  align="right"> '.number_format($raw->discounted_price,2).'</td>'; 
                       $b=$b.'   <td  align="right">'.number_format($lotdata[$raw->res_code]->costof_sale,2).'</td>'; 
                        $b=$b.'    <td  align="right">'.number_format($current,2).'</td>'; 
                     
                        $b=$b.'<td  align="right">'.number_format($raw->discounted_price-$lotdata[$raw->res_code]->costof_sale,2).'</td>'; 
                           $b=$b.' <td  align="right">'.number_format($current-$lotdata[$raw->res_code]->costof_sale,2).'</td>'; 
                        
                       $b=$b.' <td>'.$raw->pay_type.'</td>';
                       
                      
                       $b=$b.'  </tr> ';
    } }}
    $b=$b.'</tbody></table>';
   
 header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Profit_Summery_Report.xls");
	echo $b;