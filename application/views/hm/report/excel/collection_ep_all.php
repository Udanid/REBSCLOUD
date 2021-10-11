
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>hm/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);
	
}

</script>
 <?
 if($month!=''){
  $heading2=' EP Collection as at '.$reportdata;
  $monthname=date('F', mktime(0, 0, 0, intval($month), 10));
 }
 else{
   $heading2=' EP Collection as at '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));
 }
 
 $b='';
$b=$b.'
     <table  border="1"> <tr><td  align="center"  colspan="14"><h2>'.$heading2.'</h2></td></tr>
	 <tr  bgcolor="#dad1cb"><th  rowspan="2">Project Name</th><th  rowspan="2">Loan Code</th><th rowspan="2" >Lot Number</th><th rowspan="2" >Monthly rental</th>
      <th  rowspan="2"> Land Value </th> <th  rowspan="2"> Down Payment </th><th  rowspan="2"> Finance Value </th><th rowspan="2">Interest Due </th><th rowspan="2">Agreed Value </th><th  colspan="3"> Total Payable as at '.$sartdate.'</th><th colspan="4"> Payments of '.$monthname.'</th><th colspan="3" >Balance to be Received as at'.$reportdata.'</th>
        </tr>
        <tr><th>Interest</th><th>Capital</th><th>Balance</th><th>Rental</th><th>Interest</th><th>Capital</th><th>Delay</th><th>Interest</th><th>Capital</th><th>Balance</th>
        </tr>';
       
       
 
	
	if($prjlist){$fprjrental=0;$fprjlandval=0;$fprjdownpay=0;
			$fprjloanval=0;$fprjint=0; $fprjagreed=0; 
			$fprjopbalint=0;
			$fprjopbalcap=0;
			$fprjopbaltot=0;
			$fprjpayint=0;
			$fprjpaycap=0;
			$fprjpaydi=0;
			$fprjpayrent=0;
			$fprjclbalint=0;
			$fprjclbalcap=0;
			$fprjclbaltot=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjrental=0;$prjlandval=0;$prjdownpay=0;
			$prjloanval=0;$prjint=0; $prjagreed=0; 
			$prjopbalint=0;
			$prjopbalcap=0;
			$prjopbaltot=0;
			$prjpayint=0;
			$prjpaycap=0;
			$prjpaydi=0;
			$prjpayrent=0;
			$prjclbalint=0;
			$prjclbalcap=0;
			$prjclbaltot=0;
			
			
        if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
					
			$monthtotcoll=0; $settlecap=0; $settleint=0;
				if($thispayment[$raw->loan_code])
					$monthtotcoll=$thispayment[$raw->loan_code]->sum_di+$thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int;
					if($settlepayment[$raw->loan_code])
					{$monthtotcoll=$monthtotcoll+$settlepayment[$raw->loan_code]->sum_cap+$settlepayment[$raw->loan_code]->sum_int;
					$settlecap=$settlepayment[$raw->loan_code]->sum_cap;
					$settleint=$settlepayment[$raw->loan_code]->sum_int;
					}
					$rptstatus=true;
					if($raw->loan_status=='SETTLED')
					{
						if($monthtotcoll>0)
						$rptstatus=true;
						else
						$rptstatus=false;
					}
					if($rptstatus){				
							
		$opbalcap=$raw->loan_amount-$prevpayment[$raw->loan_code]->sum_cap;
		$opbalint=$inttots[$raw->loan_code]-$prevpayment[$raw->loan_code]->sum_int;
		$opbal=$opbalcap+$opbalint;
		$clbalcap=$opbalcap-$thispayment[$raw->loan_code]->sum_cap-$settlecap;
		$clbalint=$opbalint-$thispayment[$raw->loan_code]->sum_int-$settleint;
		if($raw->loan_status=='SETTLED'){
		$clbalint=0;$clbalcap=0;}
		$clbal=$clbalint+$clbalcap; 
		
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjrental=$prjrental+$raw->montly_rental;
						$prjdownpay=$prjdownpay+$raw->down_payment;
						$prjloanval=$prjloanval+$raw->loan_amount;
						$prjint=$prjint+$inttots[$raw->loan_code];
						$prjagreed=$prjagreed+$raw->loan_amount+$inttots[$raw->loan_code];
						$prjopbalint=$prjopbalint+$opbalint;
						$prjopbalcap=$prjopbalcap+$opbalcap;
						$prjopbaltot=$prjopbaltot+$opbal;
						$prjpayint=$prjpayint+$thispayment[$raw->loan_code]->sum_int+$settleint;
						$prjpaycap=$prjpaycap+$thispayment[$raw->loan_code]->sum_cap+$settlecap;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di;
						$prjpayrent=$prjpayrent+$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
						$prjclbalint=$prjclbalint+$clbalint;
						$prjclbalcap=$prjclbalcap+$clbalcap;
						$prjclbaltot=$prjclbaltot+$clbal;
						
						
				
         $b=$b.' <tr><td>'.$prjraw->project_name.'</td><td>'.$raw->loan_code.'</td><td>'.$raw->lot_number.'</td>';
        $b=$b.'    <td align="right">'.number_format($raw->montly_rental,2).'</td>';
       $b=$b.'   <td align="right">'.number_format($raw->discounted_price,2).'</td>';
         $b=$b.'  <td align="right">'.number_format($raw->down_payment,2).'</td>';
          $b=$b.'  <td align="right">'.number_format($raw->loan_amount,2).'</td>';
           $b=$b.'  <td align="right">'.number_format($inttots[$raw->loan_code],2).'</td>';
           $b=$b.'   <td align="right">'.number_format($raw->loan_amount+$inttots[$raw->loan_code],2).'</td>';
            $b=$b.'   <td align="right">'.number_format($opbalint,2).'</td>';
            $b=$b.'    <td align="right">'.number_format($opbalcap,2).'</td>';
             $b=$b.'     <td align="right">'.number_format($opbal,2).'</td>';
              $b=$b.'         <td align="right">'.number_format($thispayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_int,2).'</td>';
             $b=$b.'   <td align="right">'.number_format($thispayment[$raw->loan_code]->sum_int+$settleint,2).'</td>';
              $b=$b.'    <td align="right">'.number_format($thispayment[$raw->loan_code]->sum_cap+$settlecap,2).'</td>';
               $b=$b.'     <td align="right">'.number_format($thispayment[$raw->loan_code]->sum_di,2).'</td>';
                $b=$b.'       <td align="right">'.number_format($clbalint,2).'</td>';
               $b=$b.'            <td align="right">'.number_format($clbalcap,2).'</td>';
                 $b=$b.'              <td align="right">'.number_format($clbal,2).'</td>';
             
           
         $b=$b.' </tr>';
         }}}
        if($prjrental>0){
         $b=$b.'  <tr  bgcolor="#c3c4be" style="font-weight:bold"><td colspan="2">'.$prjraw->project_name.' Project Total</td><td></td>';
         $b=$b.'    <td align="right">'.number_format($prjrental,2).'</td>';
          $b=$b.'<td align="right">'.number_format($prjlandval,2).'</td>';
           $b=$b.'<td align="right">'.number_format($prjdownpay,2).'</td>';
          $b=$b.'  <td align="right">'.number_format($prjloanval,2).'</td>';
            $b=$b.' <td align="right">'.number_format($prjint,2).'</td>';
              $b=$b.'<td align="right">'.number_format($prjagreed,2).'</td>';
               $b=$b.'<td align="right">'.number_format($prjopbalint,2).'</td>';
                $b=$b.'<td align="right">'.number_format($prjopbalcap,2).'</td>';
                $b=$b.'  <td align="right">'.number_format($prjopbaltot,2).'</td>';
                    $b=$b.'   <td align="right">'.number_format($prjpayrent,2).'</td>';
             $b=$b.'   <td align="right">'.number_format($prjpayint,2).'</td>';
              $b=$b.'    <td align="right">'.number_format($prjpaycap,2).'</td>';
               $b=$b.'     <td align="right">'.number_format($prjpaydi,2).'</td>';
               $b=$b.'        <td align="right">'.number_format($prjclbalint,2).'</td>';
                 $b=$b.'          <td align="right">'.number_format($prjclbalcap,2).'</td>';
                        $b=$b.'         <td align="right">'.number_format($prjclbaltot,2).'</td>';
         $b=$b.' </tr>';}
        
      
						$fprjlandval=$fprjlandval+$prjlandval;
						$fprjrental=$fprjrental+$prjrental;
						$fprjdownpay=$fprjdownpay+$prjdownpay;
						$fprjloanval=$fprjloanval+$prjloanval;
						$fprjint=$fprjint+$prjint;
						$fprjagreed=$fprjagreed+$prjagreed;
						$fprjopbalint=$fprjopbalint+$prjopbalint;
						$fprjopbalcap=$fprjopbalcap+$prjopbalcap;
						$fprjopbaltot=$fprjopbaltot+$prjopbaltot;
						$fprjpayint=$fprjpayint+$prjpayint;
						$fprjpaycap=$fprjpaycap+$prjpaycap;
						$fprjpaydi=$fprjpaydi+$prjpaydi;
						$fprjpayrent=$fprjpayrent+$prjpayrent;
						$fprjclbalint=$fprjclbalint+$prjclbalint;
						$fprjclbalcap=$fprjclbalcap+$prjclbalcap;
						$fprjclbaltot=$fprjclbaltot+$prjclbaltot;
						
	   }}
        $b=$b.' <tr class="active" style="font-weight:bold"><td></td><td></td>';
      $b=$b.'       <td align="right"><'.number_format($fprjrental,2).'</td>';
      $b=$b.'    <td align="right">'.number_format($fprjlandval,2).'</td>';
       $b=$b.'    <td align="right">'.number_format($fprjdownpay,2).'</td>';
        $b=$b.'    <td align="right">'.number_format($fprjloanval,2).'</td>';
        $b=$b.'     <td align="right">'.number_format($fprjint,2).'</td>';
         $b=$b.'     <td align="right">'.number_format($fprjagreed,2).'</td>';
          $b=$b.'     <td align="right">'.number_format($fprjopbalint,2).'</td>';
           $b=$b.'     <td align="right">'.number_format($fprjopbalcap,2).'</td>';
           $b=$b.'       <td align="right">'.number_format($fprjopbaltot,2).'</td>';
           $b=$b.'            <td align="right">'.number_format($fprjpayrent,2).'</td>';
          $b=$b.'      <td align="right">'.number_format($fprjpayint,2).'</td>';
          $b=$b.'        <td align="right">'.number_format($fprjpaycap,2).'</td>';
           $b=$b.'         <td align="right">'.number_format($fprjpaydi,2).'</td>';
            $b=$b.'           <td align="right">'.number_format($fprjclbalint,2).'</td>';
             $b=$b.'              <td align="right">'.number_format($fprjclbalcap,2).'</td>';
              $b=$b.'                 <td align="right">'.number_format($fprjclbaltot,2).'</td>';
        $b=$b.'  </tr>   </table>';
		
		header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."-EP-Collection-Report.xls");
	echo $b;