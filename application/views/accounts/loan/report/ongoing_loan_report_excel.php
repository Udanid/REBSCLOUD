
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>re/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);

}

</script>
 <?

   $heading2='Loan Detail Reports';

$b='';
$b=$b.'
     <table  border="1"  width="100%"> <tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr>
		 <tr>
			 <th rowspan="2"><center>No</center></th>
			 <th rowspan="2"><center>Bank</center></th>
			 <th rowspan="2"><center>Loan Number</center></th>
			 <th rowspan="2"><center>Loan Date</center></th>
			 <th rowspan="2"><center>Loan Amount</center></th>
			 <th rowspan="2"><center>Interest Rate</center></th>
			 <th rowspan="2"><center>Installment</center></th>
			 <th rowspan="2"><center>No of Installements</center></th>
			 <th rowspan="2"><center>One time Charges</center></th>
			 <th rowspan="2"><center>Payment Period</center></th>
			 <th rowspan="2"><center>Loan Payment Date</center></th>

			 <th colspan="3"><center>Balance Amount</center></th>
			 <th colspan="4"><center>Mortgage Details</center></th>

		 </tr>
		 <tr>
			 <th>Capital</th>
			 <th>Interest</th>
			 <th>Total</th>
			 <th>Project</th>
			 <th>All Blocks Morgaged</th>
			 <th>Realeased Blocks</th>
			 <th>Pending Morgaged</th>

		 </tr>';
		 if($datalist){
		 	$c = 0;
		 	$count = 1;
		 	$totpay_amount=0.00;
		 	$tot_instalment=0.00;
		 	$tot_capital=0.00;
		 	$tot_interest=0.00;
		 	$tot_amount_due=0.00;
		 	$installment_due=0.00;
		 	$bal_capital=0.00;
		 	$bal_interest=0.00;
		 	$tot_balance=0.00;
		 	foreach($datalist as $row){
		 		$bal_capital=$row->loan_amount;//if payment doesn't start yet balance should be total amount
		 		$tot_balance=$bal_capital+$bal_interest;

		 			if($row->loan_status == "approved"){
		 				if(!empty($paid_details[$row->id]->totpay_amount)){
		 					$totpay_amount=$paid_details[$row->id]->totpay_amount;
		 					$tot_capital=$paid_details[$row->id]->totcap_amount;
		 					$tot_interest=$paid_details[$row->id]->totint_amount;
		 					$bal_capital=$row->loan_amount-$tot_capital;
		 					$bal_interest=0.00;
		 					$tot_balance=$bal_capital+$bal_interest;
		 				}
		 				if(!empty($paid_shedule[$row->id]->tot_instalment)){
		 					$tot_instalment=$paid_shedule[$row->id]->tot_instalment;
		 				}
		 				$tot_amount_due=$row->loan_amount-$totpay_amount;
		 			}

		 		$b=$b.'  <tr ><td>'.$count.'</td>';
		 			$b=$b.'  <td>'.$banknames[$row->bank_code]->BANKNAME.'</td>';
		 			$b=$b.'  <td>'.$row->loan_number.'</td>';
		 			$b=$b.'  <td>'.$row->loan_date.'</td>';

		 			$b=$b.'  <td class="text-right">'.number_format($row->loan_amount,2).'</td>';
		 			$b=$b.'  <td class="text-right">'.number_format($row->interest_rate,2).'</td>';
		 			$b=$b.'  <td class="text-right">'.number_format($row->loan_installment_value,2).'</td>';
		 			$b=$b.'  <td class="text-right">'.$row->total_period.'</td>';
		 			$b=$b.'  <td class="text-right">'.number_format($row->onetime_charges,2).'</td>';
		 			$b=$b.'  <td>'.$row->loan_date.'</td>';



		 					if($row->payment_start_date){
		 						$num=$row->payment_start_date;
		 						$th_val='th';
		 						$num = $num % 100; // protect against large numbers
		 						if($num < 11 || $num > 13){
		 							switch($num % 10){
		 								case 1: $th_val= 'st';
		 								case 2: $th_val= 'nd';
		 								case 3: $th_val= 'rd';
		 							}
		 						}

		 						$b=$b.'<td>'. $row->payment_start_date.$th_val.' Of Every Month</td>';
		 						}

		 				$b=$b.'  <td class="text-right">'.number_format($bal_capital,2).'</td>';
		 				$b=$b.'  <td class="text-right">'.number_format($bal_interest,2).'</td>';
		 				$b=$b.'  <td class="text-right">'.number_format($tot_balance,2).'</td>';
		 				$b=$b.'  <td>';
		 				if($prjName[$row->asset_id]!=''){
		 					$b=$b.$prjName[$row->asset_id]->land_code."-" .$prjName[$row->asset_id]->project_name;
		 				}
		 				$b=$b.' </td><td>';
		 				foreach ($blockList[$row->id] as $key => $value) {
		 					$b=$b.$value->lot_no.",";
		 				}
		 				$b=$b.'<td>';
		 				foreach ($blockList[$row->id] as $key => $value) {
		 					if($value->statues_active==0){
		 						$b=$b.$value->lot_no.",";
		 					}
		 				}
						$b=$b.' </td><td>';
		 				foreach ($blockList[$row->id] as $key => $value) {
		 					if($value->statues_active==1){
		 						$b=$b.$value->lot_no.",";
		 					}
		 				}
		 			$b=$b.' </td></tr>';

		 			$count++;
		 		}
		 }

           $b=$b.' </table>';

		   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename='ExternalLoanReport.xls'");
	echo $b;
