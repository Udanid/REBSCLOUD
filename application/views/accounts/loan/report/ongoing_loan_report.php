<script type="text/javascript">

function load_printscrean1()
{
			window.open( "<?=base_url()?>accounts/loan/report_excel/01");

}

</script>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Ongoing External Loan Report
       <span style="float:right"> <a href="javascript:load_printscrean1()"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"><table class="table" border="1">
    <thead>
			<tr>
				<th colspan="18"><center>Loan Detail Reports</center></th>
			</tr>
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

			</tr>
    </thead>
    <tbody>
			<?php
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

			    ?>
			    <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
			      <td><?php echo $count; ?></td>
						<td><?=$banknames[$row->bank_code]->BANKNAME;?></td>
			      <td><?php echo $row->loan_number; ?></td>
			      <td><?php echo $row->loan_date; ?></td>

			      <td class="text-right"><?=number_format($row->loan_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td class="text-right"><?=number_format($row->interest_rate,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			      <td class="text-right"><?=number_format($row->loan_installment_value,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td class="text-right"><?=$row->total_period?></td>
			      <td class="text-right"><?=number_format($row->onetime_charges,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><?php echo $row->loan_date; ?></td>


			      <td><?php
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

			            echo $row->payment_start_date.$th_val." Of Every Month"
			            ?>
			            <?}
			            ?>
			        </td>
							<td class="text-right"><?=number_format($bal_capital,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"><?=number_format($bal_interest,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"><?=number_format($tot_balance,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th><?
	            if($prjName[$row->asset_id]!=''){
								echo $prjName[$row->asset_id]->land_code."-" .$prjName[$row->asset_id]->project_name;
	            } ?></th>
							<th><?php
	            foreach ($blockList[$row->id] as $key => $value) {
								echo $value->lot_no.",";
	            } ?></th>
							<th><?php
	            foreach ($blockList[$row->id] as $key => $value) {
								if($value->statues_active==0){
									echo $value->lot_no.",";
								}
	            } ?></th>
							<th><?php
	            foreach ($blockList[$row->id] as $key => $value) {
								if($value->statues_active==1){
									echo $value->lot_no.",";
								}
	            } ?></th>
			      </tr>
			      <?php
			      $count++;
					}
			}?>

      </tbody>
    </table>
  </div>
</div>

</div>
