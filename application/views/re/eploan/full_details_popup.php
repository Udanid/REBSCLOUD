
<script type="text/javascript">

function load_printscrean1(id,prjid)
{
			window.open( "<?=base_url()?>re/lotdata/print_inquary/"+id+"/"+prjid );

}
function get_loan_detalis(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}
function get_charge_details(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>re/reservation/get_chargerfulldata/"+id );

}

</script>
<h4>Block Details
       <span style="float:right"> <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a>
</span></h4>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">

	</div>
    <table class="table">
    <tr>
    <th>Block Number</th><td><?=$lotdetail->lot_number?>-<?=$lotdetail->plan_sqid?></td>
    <th>Land Extent</th><td><?=$lotdetail->extend_perch?></td>
     <th>Perch Price</th><td><?=$lotdetail->price_perch?></td>

    </tr>
    <tr>
    <th>Selling Price</th><td><?=number_format($lotdetail->sale_val,2)?></td>
    <th>Cost of Sale</th><td><?=number_format($lotdetail->costof_sale,2)?></td>
     <th>Profit</th><td><?=number_format($lotdetail->sale_val-$lotdetail->costof_sale,2)?></td>

    </tr>
     <tr>
    <th>Block Status</th><td><?=$lotdetail->status?></td>

    </tr>
    </table>
   <? if($current_rescode){?>
    <div class="form-title">
		<h5> <?=$current_res->res_code?>-<?=$current_res->res_seq?>  Current Reservation Details
                             <span style="float:right">
<a href="javascript:get_charge_details('<?=$current_res->res_code?>')" title="Other Chargers"><i class="fa fa-money nav_icon "></i></a></span></h4>

        </h5>
	</div>
     <table class="table">
   <tr>
    <th>Customer Name</th><td><?=$current_res->first_name?>-<?=$current_res->last_name?></td>
      <th>Mobile</th><td><?=$cusdata->mobile?></td>
       <th>Address</th><td><?=$cusdata->address1?>, <?=$cusdata->address2?>, <?=$cusdata->address3?></td>
       <th>NIC</th><td><?=$cusdata->id_number?></td></tr>
       <tr>
        <th>Current Selling Price</th><td><?=number_format($current_res->seling_price,2)?></td>
    <th>Discount</th><td><?=$current_res->discount?></td>
     <th>Discounted Price</th><td><?=number_format($current_res->discounted_price,2)?></td>
      <th>Actual Profit</th><td><?=number_format($current_res->discounted_price-$lotdetail->costof_sale,2)?></td>


    </tr>
    <tr>
    <th>Sales Type</th><td><?=$current_res->pay_type?><? if($current_res->pay_type!='Outright' || $current_res->pay_type!='Pending'){?><?  if($loan_data){?>
     <a href="javascript:get_loan_detalis('<?=$loan_data->loan_code?>')"><span class="label label-success">Loan Data</span></a></span>

    <? } }?></td>
    <th>Down Payment</th><td><?=number_format($current_res->down_payment ,2)?></td>
     <th>Balance Amount</th><td><?=number_format($current_res->discounted_price-$current_res->down_payment,2)?></td>
    </tr>
    </table>
        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Payment Sequence </th><th>Amount</th><th>%</th><th>Receipt No</th> <th>Profit  Transferred</th></tr> </thead>

    <? if($current_advances){$c=0;$current=0;
		foreach($current_advances as $row){
			$current=$current+$row->pay_amount;
			$presentage=0;
			if($current_res->discounted_price>0)
			$presentage=($current/$current_res->discounted_price)*100;

		?>
     <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->pay_seq ?></td>
                        <td  align="right"> <?=number_format($row->pay_amount,2)?></td>
                        <td  align="right"> <?=number_format($presentage,2)?>%</td>
                        <td><?=$row->rct_no?></td>

                        <td><div id="checherflag">
                          <? if($row->type=='Cost Trasnfer'){?>
                          YES
                           <? }?>
                        </div></td>
                         </tr>
    <? } }?>
    <? if($settle_data){?>
     <th scope="row"><?=$settle_data->settle_date?></th><td> <?=$settle_data->settle_seq ?></td>
                        <td  align="right"> <?=number_format($settle_data->amount,2)?></td>
                        <td  align="right"> %</td>
                        <td><?=$settle_data->rct_no?></td>

                        <td><div id="checherflag">
                          <? if($settle_data->type=='Cost Trasnfer'){?>
                          YES
                           <? }?>
                        </div></td
    ><? }?>
    </tbody></table>

     <div class="form-title">
								<h5>Reservation Charge Payment History</h5>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th>Amount</th><th>Receipt No</th> <th>Status </th></tr> </thead>
                      <? if($charge_payment){$c=0;
                          foreach($charge_payment as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->chage_dis ?></td><td  align="right"> <?=number_format($row->pay_amount,2)?></td>
                        <td><?=$row->rct_no?></td>
                        <td><?=$row->status?></td>
                        <td><div id="checherflag">
                          <? if($row->status=='PENDING'){?>
                              <a  href="javascript:call_delete_advance('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr>

                                <? }} ?>
                          </tbody></table>

                    </div>
    <? }?>
    <? if($res_his){?>
     <div class="form-title">
		<h5> Reservation History </h5>
	</div>
      <table class="table"> <thead> <tr> <th>Reservation Code</th><th>Customer Name</th><th>Reservation Date</th><th>Discounted Price</th><th>Paid Total</th> <th>Refund Total</th></tr> </thead>

    <? foreach($res_his as $raw)
	{
	?>
    <tr><td><?=$raw->res_code?></td>
    <td><?=$raw->first_name?>-<?=$raw->last_name?></td>
     <td><?=$raw->res_date?></td>
       <td><?=number_format($raw->discounted_price,2)?></td>
     <? if($raw->pay_type=='Pending'){?>
      <td><?=number_format($raw->down_payment,2)?></td>
       <? if($resolelist[$raw->res_code]){?>

       <td><?=number_format($resolelist[$raw->res_code]->repay_total,2)?></td><? }?>
      <? }else{?>
       <? if($resolelist[$raw->res_code]){?>

       <td><?=number_format($raw->down_payment+$resolelist[$raw->res_code]->paid_capital,2)?></td>
       <td><?=number_format($resolelist[$raw->res_code]->repay_capital,2)?></td><? }?>

      <? }?>
			<? if($raw->pay_type!='Pending'){?>
				<a href="javascript:get_loan_detalis('<?=$resolelist[$raw->res_code]->loan_code?>')"><span class="label label-success">Loan Data</span></a></span>

			<? }?>

    </tr>
    <? }?>
    </table>
    <? }?>
    </div>
</div>
