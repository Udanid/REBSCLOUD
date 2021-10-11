
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>re/report_excel/get_collection_all/"+branch+'/'+type+'/'+month);

}

</script>
 <?

   $heading2='External Loan Mortgage Report';

$b='';
$b=$b.'
     <table  border="1"  width="100%"> <tr><td  align="center"  colspan="17"><h2>'.$heading2.'</h2></td></tr>
		 <tr>
			 <th rowspan="2"><center>No</center></th>
			 <th rowspan="2"><center>Bank</center></th>
			 <th rowspan="2"><center>Loan Number</center></th>
			 <th rowspan="2"><center>Loan Date</center></th>
			 <th rowspan="2"><center>Loan Amount</center></th>
			 <th rowspan="2"><center>Balance Capital</center></th>
			 <th colspan="4"><center>Mortgage Details</center></th>
			 <th colspan="3"><center>Releasement Details</center></th>
			 <th colspan="4"><center>Capital on Releasement</center></th>

			 </tr>
			 <tr>
			 <th>Project</th>
			 <th>All Blocks Morgaged</th>
			 <th>Realeased Blocks</th>
			 <th>Pending Morgaged</th>
			 <th>Date</th>
			 <th>Block Number</th>
			 <th>Block Extent</th>
			 <th>Per Perch Value</th>
			 <th>Realeased Capital</th>
			 <th>Balance Capital to use for realease</th>
			 <th>Perch can release</th>
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
			$rowspans=Null;
		 	foreach($datalist as $row){
				if($row->loan_type=='mortgage'){
				foreach ($blockList[$row->id] as $key => $value) {
					if($value->statues_active==0){
						$rowspans=$rowspans+1;
					}
				}
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
					$b=$b.'  <td class="text-right">'.number_format($bal_capital,2).'</td>';
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
					$block_balance=0;
					$perch_per_balance=0;
					$total_block_balance=0;
					if($rowspans==0){
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					  $b=$b.'<td rowspan="'.$rowspans.'"></td>';
					$b=$b.'</tr>';
					}else{
						$i=0;
					  foreach ($blockList[$row->id] as $key => $value) {
					    if($value->statues_active==0){

					      if($i==0){
					        $i=1;}else{
					          $b=$b.'<tr>';
										$b=$b.'<td></td>';
										$b=$b.'<td colspan="9"></td>';
					        }

					    $b=$b.'<td class="text-right">'.$value->release_at.'</td>';
					    $b=$b.'<td class="text-right">'.$value->lot_no.'</td>';
					    $b=$b.'<td class="text-right">'.$value->mortgage_extend.'</td>';
					    $b=$b.'<td class="text-right">'.number_format($value->value_per_perch,2).'</td>';
					    $b=$b.'<td class="text-right">'.number_format($value->value_per_perch*$value->mortgage_extend,2).'</td>';
					    $b=$b.'<td class="text-right"></td>';
					    $b=$b.'<td class="text-right"></td></tr>';

					$block_balance=$block_balance+($value->value_per_perch*$value->mortgage_extend);

					}}
				}
				if($rowspans>0){
				$b=$b.'<tr>';
				$b=$b.'<td></td>';
				$b=$b.'<td colspan="13"></td>';
				$b=$b.'<td class="text-right">'.number_format($block_balance,2).'</td>';
				$b=$b.'<td class="text-right">'.number_format($bal_capital-$block_balance,2).'</td>';
				 if($bal_capital-$block_balance>0 && $value->value_per_perch>0){
					$b=$b.'<td class="text-right">'.number_format((($bal_capital-$block_balance)/$value->value_per_perch),1).'</td>';
				 }else{
					$b=$b.'<td class="text-right">'.number_format((0),1).'</td>';
				}
					$b=$b.'</tr>';
				}
		 			$count++;
		 		}
		 }}

           $b=$b.' </table>';

		   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename='ExternalLoanMorgageReport.xls'");
	echo $b;
