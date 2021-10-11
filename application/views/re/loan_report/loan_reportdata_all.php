
<script type="text/javascript">
	$(document).ready(function(){
		  $('#create_excel').click(function(){

					 $(".table2excel").table2excel({
                exclude: ".noExl",
                name: "Loan Report",
                filename: "Provision.xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

      });
 });

</script>
 <?

  $heading2=' Loan Details as at '.$reportdata;


 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?>
       <span style="float:right">
<a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow table2excel"  >

      <table class="table table-bordered">
   <tr class="success" style="font-weight:bold">
    <tr>
         <th>Project name</th>

         <th>Lot Number</th>
         <th>Contract Number</th>
				 <th>Loan Type</th>
				 <th>Loan Capital</th>
         <th>Loan Interest</th>
				 <th>Total Finance Val</th>
         <th>Paid Capital</th>
				 <th>Paid Int</th>
         <th>Paid Total</th>
				 <th>Paid DI</th>
				 <th>Balance Capital</th>
         <th>Balance Interest</th>
				 <th>Balance Total</th>

				 <th>Unrealized Sale</th>
         <th>Unrealized Cost</th>
       </tr>
			 <? 
			 
			  $nonrefund_all=0;
			 			 $ful_loan_amount_tot=0;
						 $ful_int_amount_tot=0;
						 $ful_cap_amount_tot=0;
						 $ful_int_amount_tot=0;
						 $ful_pay_amount_tot=0;
						 $ful_di_amount_tot=0;
						 $ful_bal_cap_tot=0;
						$ful_bal_int_tot=0;
						$ful_bal_tot_tot=0;
						$ful_unrelized_sale_tot=0;
						$ful_unrelized_cost_tot=0;
						$ful_int_amount_tot_loan=0;
			 
			 if($prjlist){
				 foreach ($prjlist as $key => $prjval) {?>
					 <td colspan="15"><?=$prjval->project_name?></td></tr>
					 <? if($report_data[$prjval->prj_id]){
						 $loan_amount_tot=0; $loan_int_amount_tot=0;
						 $int_amount_tot=0;
						 $cap_amount_tot=0;
						 $int_amount_tot=0;
						 $pay_amount_tot=0;
						 $di_amount_tot=0;
						 $bal_cap_tot=0;
						$bal_int_tot=0;
						$bal_tot_tot=0;
						$unrelized_sale_tot=0;
						$unrelized_cost_tot=0;

						 foreach ($report_data[$prjval->prj_id] as $key => $value) {
						
							 $paid_cap=0;$paid_int=0;$paid_di=0;
							  $loanamount=0;$int_amount=0;

							 //calculate sum
							
							 if($paid_data[$value->loan_code])
							 {
								 $paid_cap=$paid_data[$value->loan_code]->cap_amount;
								  $paid_int=$paid_data[$value->loan_code]->int_amount;
								   $paid_di=$paid_data[$value->loan_code]->di_amount;
								 
							 }
							 
							  if($earlysettle[$value->loan_code])
							 {
								    $paid_cap= $paid_cap+$earlysettle[$value->loan_code]->cap_amount;
								  $paid_int=$paid_int+$earlysettle[$value->loan_code]->int_amount;
							 }
							  $loanamount=$value->loan_amount;
							 $int_amount=$value->int_amount;
							  if($resheduledata[$value->loan_code])
							 {
								  $loanamount=$resheduledata[$value->loan_code]['cap'];
								  $int_amount=$resheduledata[$value->loan_code]['int'];
							 }
							 
							  $bal_cap=$loanamount-$paid_cap;
							 $bal_int=$int_amount-$paid_int;
							 
							 if($earlysettle[$value->loan_code])
							{
								
										 $bal_cap=0;
											$bal_int=0;
							}
							 
							  $bal_tot=$bal_cap+$bal_int;
							  $loan_amount_tot=$loan_amount_tot+$loanamount;
							 $loan_int_amount_tot=$loan_int_amount_tot+ $int_amount;
							
							$cap_amount_tot=$cap_amount_tot+$paid_cap;
							$int_amount_tot=$int_amount_tot+$paid_int;
							$pay_amount_tot=$pay_amount_tot+($paid_cap+$paid_int);
							$di_amount_tot=$di_amount_tot+$paid_di;
							
							$bal_cap_tot=$bal_cap_tot+$bal_cap;
							$bal_int_tot=$bal_int_tot+$bal_int;
							
							
							
							$bal_tot_tot=$bal_tot_tot+$bal_tot;
					
							$unrelized_sale_tot=$unrelized_sale_tot+$unrelized_sale[$value->loan_code];
							$unrelized_cost_tot=$unrelized_cost_tot+$unrelized_cost[$value->loan_code];
							
							
							//Full Totals
							 $ful_loan_amount_tot=$ful_loan_amount_tot+$loanamount;
							 $ful_int_amount_tot_loan=$ful_int_amount_tot_loan+$int_amount;
							$ful_cap_amount_tot=$ful_cap_amount_tot+$paid_cap;
							$ful_int_amount_tot=$ful_int_amount_tot+$paid_int;
							$ful_pay_amount_tot=$ful_pay_amount_tot+($paid_cap+$paid_int);
							$ful_di_amount_tot=$ful_di_amount_tot+$paid_di;
							 $nonrefund_all= $nonrefund_all+$nonerefund[$value->loan_code];
							$ful_bal_cap_tot=$ful_bal_cap_tot+$bal_cap;
							$ful_bal_int_tot=$ful_bal_int_tot+$bal_int;
							$ful_bal_tot_tot=$ful_bal_tot_tot+$bal_tot;
					
							$ful_unrelized_sale_tot=$ful_unrelized_sale_tot+$unrelized_sale[$value->loan_code];
							$ful_unrelized_cost_tot=$ful_unrelized_cost_tot+$unrelized_cost[$value->loan_code];
							
							 ?>
							 <tr>
		 			         <th></th>

		 			         <td><?=$value->lot_number?></td>
		 			         <td><?=$value->loan_code?></td>
									 <td><?=$loanamount?></td>
		 							 <th ><?=number_format($loanamount)?></td>
		 			         <td><?=number_format($int_amount,2)?></td>
		 							 <td><?=number_format($loanamount+$int_amount,2)?></td>
		 			         <td><?=number_format($paid_cap,2)?></td>
		 							 <td><?=number_format( $paid_int,2)?></td>

		 			         <td><?=number_format($paid_cap+$paid_int,2)?></td>
									 <td><?=number_format($paid_di,2)?></td>

		 							 <td><?=number_format($bal_cap,2)?></td>
		 			         <td><?=number_format($bal_int,2)?></td>
		 							 <td><?=number_format($bal_tot,2)?></td>
		 							 <td><?=number_format($unrelized_sale[$value->loan_code],2)?></td>
		 			         <td><?=number_format($unrelized_cost[$value->loan_code],2)?></td>
		 			       </tr>
					<?	 }?>

					 <tr>
							 <th>Total</th><td></td><td></td><td></td>
							 <th ><?=number_format($loan_amount_tot,2)?></td>
							 <td><?=number_format($int_amount_tot,2)?></td>
							 <td><?=number_format($loan_amount_tot+$int_amount_tot,2)?></td>
							 <td><?=number_format($cap_amount_tot,2)?></td>
							 <td><?=number_format($int_amount_tot,2)?></td>
							 <td><?=number_format($pay_amount_tot,2)?></td>
							 <td><?=number_format($di_amount_tot,2)?></td>
							 <td><?=number_format($bal_cap_tot,2)?></td>
							 <td><?=number_format($bal_int_tot,2)?></td>
							 <td><?=number_format($bal_tot_tot,2)?></td>
							 <td><?=number_format($unrelized_sale_tot,2)?></td>
							 <td><?=number_format($unrelized_cost_tot,2)?></td>
						 </tr>
				<? }?>


			<?	 }
			 }?>
             <tr>
							 <th>All Total</th><td></td><td></td><td></td>
							 <th ><?=number_format($ful_loan_amount_tot,2)?></td>
							 <td><?=number_format($ful_int_amount_tot_loan,2)?></td>
							 <td><?=number_format($ful_loan_amount_tot+$ful_int_amount_tot_loan,2)?></td>
							 <td><?=number_format($ful_cap_amount_tot,2)?></td>
							 <td><?=number_format($ful_int_amount_tot,2)?></td>
							 <td><?=number_format($ful_pay_amount_tot,2)?></td>
							 <td><?=number_format($ful_di_amount_tot,2)?></td>
							 <td><?=number_format($ful_bal_cap_tot,2)?></td>
							 <td><?=number_format($ful_bal_int_tot,2)?></td>
							 <td><?=number_format($ful_bal_tot_tot,2)?></td>
							 <td><?=number_format($ful_unrelized_sale_tot,2)?></td>
							 <td><?=number_format($ful_unrelized_cost_tot,2)?></td>
						 </tr>
                         <tr>
					 <th>Excess Payment Balance</th><td></td><td></td><td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <th align="right"><?=number_format($nonrefund_all,2)?></th>
					 <td></td>
					 <td></td>
				 </tr>
                  <tr>
					 <th>Ledger Balance</th><td></td><td></td><td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <td></td>
					 <th align="right"><?=number_format($ful_bal_tot_tot-$nonrefund_all,2)?></th>
					 <td></td>
					 <td></td>
				 </tr>

         </table></div>
    </div>

</div>
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>
