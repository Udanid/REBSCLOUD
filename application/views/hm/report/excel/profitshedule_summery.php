<?

 $b='';
                     
  $b=$b.'     <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>Profit Realization Report</h2></td></tr><tr bgcolor="#b2ebf9">

           <th>Res Code</th><th>Lot Number</th><th>Profit Transfer Date</th><th>Selling Price </th><th>Cost of Sale</th>
         <th>Paid Total</th><th>Actual Profit</th><th>Realized Profit</th> <th>Settlement Type</th> <th>Profit  Realized %</th></tr> </thead>';
          if($prjlist){  foreach($prjlist as $prjraw)
		{if($transferlist[$prjraw->prj_id]){
			 
           $b=$b.'   <tr style="font-weight:bold" bgcolor="#f7c4f0"><td colspan="10">'.$prjraw->project_name.'</td></tr>';
                  
    $c=0;$current=0;$paidtotal=0;
		foreach($transferlist[$prjraw->prj_id] as $raw){
			if($lotdata[$prjraw->prj_id][$raw->res_code]->status=='SOLD'){
			//$current=$paidadvance[$raw->res_code]+$paidcap[$raw->res_code];
			$current=$raw->down_payment+$paidcap[$prjraw->prj_id][$raw->res_code];
			$presentage=($current/$raw->discounted_price)*100;
			$paidtotal=$paidtotal+$current;
		$presentage=round((($current)/($raw->discounted_price))*100,2);
   				$b=$b.'  <tbody> <tr >'; 
                         $b=$b.'<th scope="row">'.$raw->res_code.'</th> <th scope="row">'.$lotdata[$prjraw->prj_id][$raw->res_code]->lot_number.'</th> <th scope="row">'.$raw->profit_date.'</th>';
                       $b=$b.' <td  align="right">'.number_format($raw->discounted_price,2).'</td>'; 
                         $b=$b.' <td  align="right">'.number_format($lotdata[$prjraw->prj_id][$raw->res_code]->costof_sale,2).'</td>'; 
                            $b=$b.'<td  align="right">'.number_format($current,2).'</td>'; 
                     
                       $b=$b.' <td  align="right"> '.number_format($raw->discounted_price-$lotdata[$prjraw->prj_id][$raw->res_code]->costof_sale,2).'</td>';
                           $b=$b.' <td  align="right">'.number_format($current-$lotdata[$prjraw->prj_id][$raw->res_code]->costof_sale,2).'</td>'; 
                        
                        $b=$b.'<td>'.$raw->pay_type.'</td>';
						  $b=$b.'<td>'.$presentage.'</td>';
                       
                      
                     $b=$b.'   </tr> ';
    } }}
    
    }}
   $b=$b.' </tbody></table>';
   	  header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Profit_Summery_Report.xls");
	echo $b;
   
 