<script type="text/javascript">

function load_printscrean1()
{
			window.open( "<?=base_url()?>accounts/loan/report_excel/02");

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
				<th colspan="17"><center>External Loan Mortgage Report</center></th>
			</tr>
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
					$rowspans=Null;
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

			    ?>
			    <tr>
			      <td rowspan="<?=$rowspans?>"><?php echo $count; ?></td>
						<td rowspan="<?=$rowspans?>"><?=$banknames[$row->bank_code]->BANKNAME;?></td>
			      <td rowspan="<?=$rowspans?>"><?php echo $row->loan_number; ?></td>
			      <td rowspan="<?=$rowspans?>"><?php echo $row->loan_date; ?></td>

			      <td rowspan="<?=$rowspans?>" class="text-right"><?=number_format($row->loan_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td rowspan="<?=$rowspans?>" class="text-right"><?=number_format($bal_capital,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td rowspan="<?=$rowspans?>"><?
						if($prjName[$row->asset_id]!=''){
							echo $prjName[$row->asset_id]->land_code."-" .$prjName[$row->asset_id]->project_name;
						} ?></td>
						<td rowspan="<?=$rowspans?>"><?php
						foreach ($blockList[$row->id] as $key => $value) {
							echo $value->lot_no.",";
						} ?></td>
						<td rowspan="<?=$rowspans?>"><?php
						foreach ($blockList[$row->id] as $key => $value) {
							if($value->statues_active==0){
								echo $value->lot_no.",";
							}
						} ?></td>
						<td rowspan="<?=$rowspans?>"><?php
						foreach ($blockList[$row->id] as $key => $value) {
							if($value->statues_active==1){
								echo $value->lot_no.",";
							}
						} ?></td>
						<?php
						$block_balance=0;
						$perch_per_balance=0;
						$total_block_balance=0;
						if($rowspans==0){?>
							<td rowspan="<?=$rowspans?>" ></td>
							<td rowspan="<?=$rowspans?>" ></td>
							<td rowspan="<?=$rowspans?>" ></td>
							<td rowspan="<?=$rowspans?>" ></td>
							<td rowspan="<?=$rowspans?>" ></td>
							<td rowspan="<?=$rowspans?>" ></td>
							<td rowspan="<?=$rowspans?>" ></td>
						</tr>
					<?	}else{
						$i=0;
						foreach ($blockList[$row->id] as $key => $value) {
							if($value->statues_active==0){

								if($i==0){
									$i=1;}else{?><tr><?}?>

							<td class="text-right"><?=$value->release_at?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"><?=$value->lot_no?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"><?=$value->mortgage_extend?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"><?=number_format($value->value_per_perch,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"><?=number_format($value->value_per_perch*$value->mortgage_extend,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td class="text-right"></td>
							<td class="text-right">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
				<?
				$block_balance=$block_balance+($value->value_per_perch*$value->mortgage_extend);

			}}}
			if($rowspans>0){?>
				<tr>
					<td colspan="14"></td>
					<td class="text-right"><?=$rowspans?><?=number_format($block_balance,2); ?></td>
					<td class="text-right"><?=$bal_capital-$block_balance;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<? if($bal_capital-$block_balance>0 && $value->value_per_perch>0){?>
						<td class="text-right"><?=number_format((($bal_capital-$block_balance)/$value->value_per_perch),1); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<? }else{?>
						<td class="text-right"><?=number_format((0),1); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<?	}?>
				</tr>
		<?	}
			      $count++;
					}
			}}?>
<!--add row for sum total per perch -->
</tbody>
    </table>
  </div>
</div>

</div>
