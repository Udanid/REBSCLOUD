
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>re/report/get_stock_all_print/"+month);

}
function expoet_excel(month,branch)
{


				window.open( "<?=base_url()?>accounts/pettycashpayments/report_data_excel/"+month+'/'+branch);
}

</script>
<style type="text/css">

</style>
 <?
    $heading2=' Cash Advance Report   as at '.$rptdate;

   $fulltot=0;

 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> - <?=$bookdata->name?>
       <span style="float:right"> <a href="javascript:expoet_excel('<?=$rptdate?>','<?=$bookid?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? if($bookdata->pay_type=='CSH'){?><a href="javascript:call_confirm('<?=$rptdate?>','<?=$bookid?>')"><span class="label label-success">Reimbersment </span></a><? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >

          <h4>Reimbursment Details - Direct Payments</h4>

          <table class="table table-bordered"> <thead> <tr><th> No</th><th> Date</th> <th>Officer</th> <th>Supplier name</th><th>Branch</th>  <th>Description</th><th>Payment Added By</th> <th>Confirmed By</th><th>Paid Amount</th></tr> </thead>
                      <?  $directot=0; if($paymentlist){$c =0;
                          foreach($paymentlist as $row){
							  $fulltot=$fulltot+$row->pay_amount;
							   $directot= $directot+$row->pay_amount;;
							  ?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                          <th scope="row"><?=$row->serial_number?><th scope="row"><?=$row->paid_date?></th>
                           <td><?=$row->initial?> <?=$row->surname?></td>
                              <td><?=$row->sup_name ?></td>
                            <td><?=get_officer_branch($row->officer_id);?></td>

                             <td><?=$row->note ?></td>
                             <td><?=get_user_fullname_id($row->paid_by)?></td>
                             <td><?=get_user_fullname_id($row->confirm_by)?></td>

                                 <td><?=number_format($row->pay_amount,2) ?></td>
                               </tr>
                               <? }}?>
                               <tr class="active" style="font-weight:bold">
      	  					 <td align="right" colspan="8">Payment Total</td>
       	  					 <td align="right"><?=number_format($directot,2)?></td>

           						 </tr>
                                 <tr class="active" style="font-weight:bold">
      	  					 <td align="right" colspan="8">Total Reimbursement </td>
       	  					 <td align="right"><?=number_format($fulltot,2)?></td>

           						 </tr>
                                </tbody></table>


         </div>
    </div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >



        <h4>Settled IOU List</h4>
           <table class="table table-bordered">


   <tr> <th >No</th> <th >Cash Advance No</th><th>Requested Date</th> <th>Pay Date</th> <th>Branch</th> <th >Employee Name</th> <th>Project</th><th>Payment Added By</th> <th>Confirmed By</th> <th>Description </th><th>Settled Amount</th><th>Date Variance</th></tr>

       <? $fulltota=0;?>

        <?  if($settledlist){
			foreach($settledlist as $raw){
				?>
         		<tr><td><?=$raw->serial_number?></td><td><?=$raw->adv_code?></td><td><?=$raw->apply_date;?></td><td><?=$raw->pay_date?></td>
          		<td align="right"><?=get_branch_name($raw->branch)?></td>
         		<td align="right"><?=$raw->initial?> <?=$raw->surname?></td>
          		  <td align="right"><?=$raw->project_name?></td>
                 <td><?=get_user_fullname_id($raw->paid_by)?></td>
                <td><?=get_user_fullname_id($raw->check_officerid)?></td>
             	 <td align="right"><?=$raw->description?></td>
             	 <td align="right"><?=number_format($raw->settled_amount,2)?></td>

           		</tr>
		<? 	 $fulltot= $fulltot+$raw->amount;
		}}?>


        <?  if($pendiglist){

			?>
</table>  <h4>Unsettled IOU List</h4>
           <table class="table table-bordered">


   <tr> <th >No</th> <th >Cash Advance No</th><th>Requested Date</th> <th>Pay Date</th> <th>Branch</th> <th >Employee Name</th> <th>Project</th><th>Payment Added By</th> <th>Confirmed By</th> <th>Description </th><th>Actual Amount</th><th>Date Variance</th></tr>
            <?
			foreach($pendiglist as $raw){
				//print_r($arrearspay[$raw->res_code]);
				 $date1=date_create($raw->promiss_date);
					  $date2=date_create($rptdate);
					  $diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
				?>

      	<tr><td><?=$raw->serial_number?></td>
        <td><?=$raw->adv_code?></td>
        <td><?=$raw->apply_date;?></td>
        <td><?=$raw->pay_date?></td>

          <td align="right"><?=get_branch_name($raw->branch)?></td>
         <td align="right"><?=$raw->initial?> <?=$raw->surname?></td>
            <td align="right"><?=$raw->project_name?></td>
             <td><?=get_user_fullname_id($raw->paid_by)?></td>
                <td><?=get_user_fullname_id($raw->check_officerid)?></td>
              <td align="right"><?=$raw->description?></td>
              <td align="right"><?=number_format($raw->amount,2)?></td>
               <td align="right"><?=$dates?></td>



            </tr>
		<? 	 $fulltota= $fulltota+$raw->amount;

		?>


        <?
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>






      <?
	  $fulltot_reim=$fulltot;
	  $physicalbal=get_cashbook_balance($details->id);
	  $bookbalance= $physicalbal+$fulltota


	  ?>
       <input  type="hidden" name='reim_amount' id="reim_amount" value="<?=$fulltot_reim?>" />
			  <input  type="hidden" name='ledger_bal' id="ledger_bal" value="<?=$ledgerbalance?>" />
      <tr class="active" style="font-weight:bold">
         <td align="right" colspan="10">Total</td>
          <td align="right"><?=number_format($fulltota,2)?></td>

                 <td align="right"></td>
            </tr>
         </table>

         <table class="table"  style="width:50%" >
         <tr><td>Direct Payment</td><td align="right"><?=number_format($directot,2)?></td></tr>
          <tr><td>Unsettled IOU</td><td align="right"><?=number_format($fulltota,2)?></td></tr>
            <tr><td>Total Reimbursment</td><td align="right"><?=number_format($fulltot,2)?></td></tr>
            <tr><td>Cash In Hand and Bank</td><td align="right"><?=number_format($ledgerbalance,2)?></td>
              <tr><td>Variance</td><td align="right"><?=number_format($ledgerbalance-$bookbalance,2)?></td></tr>
            
            </table>

         </div>
    </div>

</div>
