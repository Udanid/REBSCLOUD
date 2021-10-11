
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>hm/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);
	
}

</script>
 <?
 if($month!=''){
  $heading2=' Down Payment as at '.$reportdata;
 }
 else{
   $heading2=' Down Payment as at '.$reportdata;
 }

$b='';
$b=$b.'
     <table  border="1"  width="100%"> <tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr>
     <tr  bgcolor="#dad1cb"><th >Project Name</th><th  >Lot Number</th>
      <th > Land Value </th><th >Capital Payment as at '.$sartdate.'</th><th >Balance to be Received as at '.$sartdate.' </th>
      <th >Payment</th><th >Balance</th><th >%</th>
        </tr>
        </tr>';
       
       
   
	
	if($prjlist){$fullprjlandval=0;$fullprjprvcap=0;$fullprjbal=0; $fullprjpayment=0; $fullprjlastbal=0;
		foreach($prjlist as $prjraw){
			//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			
       if($type=='01'){   if($reservation[$prjraw->prj_id]){
			foreach($reservation[$prjraw->prj_id] as $raw){
					
			$flag=true; 
				if($raw->res_status=='REPROCESS')
				$flag=false;
				if($raw->loan_code)
						$flag=false;
				if($thispayment[$raw->res_code]>0)
				$flag=true;
					if($raw->discounted_price!=$prevpayment[$raw->res_code]){
						if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$prevpayment[$raw->res_code];
						$prjbal=$prjbal+($raw->discounted_price-$prevpayment[$raw->res_code]);
						$prjpayment=$prjpayment+$thispayment[$raw->res_code];
						$last_bal=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						if($raw->loan_code)
						$last_bal=0;
						if($raw->res_status=='REPROCESS')
							$last_bal=0;
						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						
				
       $b=$b.'  <tr ><td>'.$prjraw->project_name.'</td><td>'.$raw->lot_number.'</td>';
       $b=$b.'  <td align="right">'.number_format($raw->discounted_price,2).'</td>';
       $b=$b.'   <td align="right">'.number_format($prevpayment[$raw->res_code],2).'</td>';
        $b=$b.'   <td align="right">'.number_format($raw->discounted_price-$prevpayment[$raw->res_code],2).'</td>';
         $b=$b.'   <td align="right">'.number_format($thispayment[$raw->res_code],2).'</td>';
        $b=$b.'     <td align="right">'.number_format($last_bal,2).'</td>';
         $b=$b.'    <td>';
            $b=$b.'   </td>';
         $b=$b.'  </tr>';
       }}}} } if($type=='04'){  if($zepreservation[$prjraw->prj_id]){
			foreach($zepreservation[$prjraw->prj_id] as $raw){
				//if($currentlist[$raw->res_code]){
					$zprvpayment=0;$zthispayment=0;
					if($zepprevpayment[$raw->loan_code])
					$zprvpayment=$zepprevpayment[$raw->loan_code]->sum_cap;
					if($zepthispayment[$raw->loan_code])
					$zthispayment=$zepthispayment[$raw->loan_code]->sum_cap;
					$fullpayment=$raw->down_payment+$zprvpayment;
					
						$flag=true; 
				if($raw->loan_status=='SETTLED')
				$flag=false;
				if($zthispayment>0)
				$flag=true;
					if($raw->discounted_price!=$fullpayment){
						if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$fullpayment;
						$prjbal=$prjbal+($raw->discounted_price-$fullpayment);
						$prjpayment=$prjpayment+$zthispayment;
						$last_bal=$raw->discounted_price-$fullpayment-$zthispayment;
						
						
						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$fullpayment-$zthispayment;
						
				
        $b=$b.'   <tr    bgcolor="#fbd4ee" ><td>'.$prjraw->project_name.' '.$raw->loan_code.'</td><td>'.$raw->lot_number.'</td>';
        $b=$b.'   <td align="right">'.number_format($raw->discounted_price,2).'</td>';
         $b=$b.'   <td align="right">'.number_format($fullpayment,2).'</td>';
         $b=$b.'    <td align="right">'.number_format($raw->discounted_price-$fullpayment,2).'</td>';
          $b=$b.'    <td align="right">'.number_format($zthispayment,2).'</td>';
          $b=$b.'     <td align="right">'.number_format($last_bal,2).'</td>';
          $b=$b.'     <td>';
             $b=$b.'  </td>';
          $b=$b.' </tr>';
        }}}} }
        if($prjlandval>0){
           $b=$b.' <tr  bgcolor="#c3c4be" style="font-weight:bold"><td></td><td></td>';
         $b=$b.'  <td align="right">'.number_format($prjlandval,2).'</td>';
        $b=$b.'    <td align="right">'.number_format($prjprvcap,2).'</td>';
         $b=$b.'    <td align="right">'.number_format($prjbal,2).'</td>';
         $b=$b.'    <td align="right">'.number_format($prjpayment,2).'</td>';
        $b=$b.'     <td align="right">'.number_format($prjlastbal,2).'</td>';
         $b=$b.'    <td></td>';
       $b=$b.'    </tr>';}
        
      
	  $fullprjlandval=$fullprjlandval+$prjlandval;
	  $fullprjprvcap=$fullprjprvcap+$prjprvcap;
	  $fullprjbal=$fullprjbal+$prjbal;
	  $fullprjpayment=$fullprjpayment+$prjpayment;
	  $fullprjlastbal=$fullprjlastbal+$prjlastbal;
	  
	   }}
      $b=$b.'    <tr  bgcolor="#c3c4be" style="font-weight:bold"><td></td><td></td>';
       $b=$b.'    <td align="right">'.number_format($fullprjlandval,2).'</td>';
       $b=$b.'     <td align="right">'.number_format($fullprjprvcap,2).'</td>';
       $b=$b.'      <td align="right">'.number_format($fullprjbal,2).'</td>';
       $b=$b.'      <td align="right">'.number_format($fullprjpayment,2).'</td>';
        $b=$b.'     <td align="right">'.number_format($fullprjlastbal,2).'</td>';
       $b=$b.'      <td></td>';
        $b=$b.'   </tr>';
           $b=$b.' </table>';
		   
		   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."-EP-Collection-Report.xls");
	echo $b;