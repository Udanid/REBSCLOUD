
<script type="text/javascript">
function view_customer_nic(id,type)
{
	//alert(id) update by nadee ticket number 1064
	window.open( "<?=base_url()?>hm/lotdata/view_nic/"+id+"/"+type);
}
function load_printscrean1(id,prjid)
{
			window.open( "<?=base_url()?>hm/lotdata/print_inquary/"+id+"/"+prjid );

}
function get_loan_detalis(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );

}
function get_charge_details(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>hm/reservation/get_chargerfulldata/"+id );

}
function get_customer_details(id,paytype)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>hm/lotdata/get_customerpopup/"+id+"/"+paytype);

}
function get_resale_paymentdetails(id,paytype)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>hm/lotdata/get_resalepayment/"+id+"/"+paytype);

}
function get_followuphistory(id)
{

		// var vendor_no = src.value;
//alert(id);


					$('#popupform').delay(1).fadeIn(600);

					$( "#popupform" ).load( "<?=base_url()?>hm/lotdata/get_followup/"+id);

}
//2019-10-23 Ticket 807 B.K.Dissanayake
function updateMetOfficer(){
    var cus_id=$("#txtCusId").val();
    var checkedVal=0;

    if ($('#chofficer').is(":checked"))
    {
      checkedVal=$("#chofficer").val();

      $.ajax({
              cache: false,
              type: 'POST',
              url: '<?php echo base_url().'cm/customer/updateMetOfficer/';?>',
              data: {checkedVal: checkedVal ,cus_id:cus_id},
              success: function(data) {
                $('#chofficer').attr('disabled', 'disabled');
              }
          });
    }
}

</script>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Block Details
       <span style="float:right"> <a href="javascript:load_printscrean1('<?=$lotdetail->lot_id?>','<?=$projectdata->prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
</span></h4>
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
     <th>Plan Number</th><td><?=$lotdetail->plan_no?></td>

    </tr>
    </table>
   <? if($current_rescode){
	    $loanpayment=0;
	 		  if($paylistinq){

                foreach($paylistinq as $row){
                  $loanpayment=$loanpayment+$row->tot_cap;
				}
			  }

	   // modification done by udani ticket number 853
			$todate=date('Y-m-d');
			  $date1=date_create($current_res->res_date);
			 $date2=date_create($todate);
			 $diff=date_diff($date1,$date2);
			 $aging=$diff->format("%a ");
			 $tempcode=$current_res->res_code;
			 if($loan_data){
				 $tempcode=$loan_data->loan_code;
			 }
			$lastpaydate=hm_get_last_payment_date($current_res->res_code);
			 $date1=date_create($lastpaydate);
			 $date2=date_create($todate);
			  $diff=date_diff($date1,$date2);
			 $datelast=$diff->format("%a ");
			 //End Modification
	   ?>
    <div class="form-title">
		<h4> <?=$current_res->res_code?>-<?=$current_res->res_seq?>  Current Reservation Details
                             <span style="float:right">
<a href="javascript:get_followuphistory('<?=$current_res->cus_code?>')" title="Follow Up"><i class="fa fa-phone nav_icon "></i></a></span>

        </h4>
	</div>
     <table class="table">
       <? 	// modification done by udani ticket number 853?>
      <tr>
      <th>Reservation Date</th><td><?=$current_res->res_date?></td>
      <th>Aging</th><td><?=$aging?></td>
      <td colspan="2"><strong># days since Last Payment</strong> &nbsp; &nbsp; &nbsp;: <?=$datelast?></td> <td></td>
      <td></td></tr>
      <?	 //End Modification?>
    <tr>
    <th>Customer Name</th><td><?=$current_res->first_name?>-<?=$current_res->last_name?></td>
      <th>Mobile</th><td><?=$cusdata->mobile?></td>
       <th>Address</th><td><?=$cusdata->address1?>, <?=$cusdata->address2?>, <?=$cusdata->address3?></td>
         <th>NIC</th><td><a href="javascript:get_customer_details('<?=$cusdata->cus_code?>','<?=$current_res->pay_type?>')" title="Customer Data"><?=$cusdata->id_number?></a></td></tr>
       <tr>
        <th>Current Selling Price</th><td><?=number_format($current_res->seling_price,2)?></td>
    <th>Discount</th><td><?=$current_res->discount?></td>
     <th>Discounted Price</th><td><?=number_format($current_res->discounted_price,2)?></td>
     <th>Actual Profit</th><td><?=number_format($current_res->discounted_price-$lotdetail->costof_sale,2)?></td>

    </tr>
    <tr>
    <th>Sales Type</th><td><?=$current_res->pay_type?><? if($current_res->pay_type!='Outright' || $current_res->pay_type!='Pending'){ if($loan_data){?>
     <a href="javascript:get_loan_detalis('<?=$loan_data->loan_code?>')"><span class="label label-success">Loan Data</span></a></span>

    <? }}?></td>
    <th>Down Payment</th><td><?=number_format($current_res->down_payment ,2)?></td>
     <th>Balance Amount</th><td><?=number_format($current_res->discounted_price-($current_res->down_payment+$loanpayment),2)?></td>
     <th>Met Legal Officer</th>
      <td>
          <input id="chofficer" type="checkbox" name="chbxMetOfficer" value="1" onchange="updateMetOfficer()" <?php if($cusdata->met_officer ==1) echo " checked disabled" ?>>
          <input type="hidden" name="txtCusId" id="txtCusId" value="<?=$cusdata->cus_code?>">
      </td>
    </tr>
    <tr>
      <th>After Reservation Discount Comment</th>
      <td colspan="4"><?php
          if($resevationdiscount){
              foreach ($resevationdiscount as $row) {
                if($row->resdis_comment != ''){
                  echo($row->resdis_comment);
                  echo "</br>";
                }
              }
          }
           ?>
      </td>
    </tr>
    </table>

    <!-- Added by kalum ticket 814 2019-10-28 -->

    <div class="form-title">
      <h5>Receipt Details
        <span style="float:right"><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
        </span>

      </h5>
    </div>

    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

        <table class="table table2excel">
          <thead>
            <tr>
              <th>Payment Date</th>
              <th style="text-align: right;">Payment </th>
              <th style="text-align: right;">Capital</th>
              <th style="text-align: right;">Interest</th>
              <th style="text-align: right;">Default Interest </th>
              <th style="text-align: right;">%</th>
              <th style="text-align: right;">Remaining Balance</th>
              <th>Receipt No</th>
              <th>Profit Transferred</th>
            </tr>
          </thead>
            <?

                $advancetotal_payamount=0;
                $total_payamount=0;
                $total_capamount=0;
                $total_intamount=0;
                $total_diamount=0;
                $advancetotal_diamount=0;
                $advancetotalpresentage=0;
                $totlal_presentage=0;
                $current=0;
                $remaining_balance = 0;
                $total_advance_cap=0;
                $presentage=0;

            // advance section

            if($current_advances){
              foreach($current_advances as $row){
                $current=$current+$row->pay_amount;
                if($current_res->discounted_price>0){
                    $presentage=($current/$current_res->discounted_price)*100;
                    $remaining_balance = $current_res->discounted_price - $current;
                  ?>

                  <tbody>
                    <tr class="">
                      <th scope="row"><?=$row->pay_date?></th>
                      <td align="right"><?=number_format($row->pay_amount+$row->di_amount,2)?></td>
                      <td align="right"><?=number_format($row->pay_amount,2)?></td>
                      <td align="right">0.00</td>
                      <td align="right"><?=number_format($row->di_amount,2)?></td>
                      <td align="right"> <?=number_format($presentage,2)?>%</td>
                      <td align="right"><?=number_format($remaining_balance,2)?></td>
                      <td><?=$row->rct_no?></td>
                      <td>
                        <div id="checherflag">

                        </div>
                      </td>
                    </tr>
                </tbody>

              <? }

                $advancetotal_payamount+=$row->pay_amount+$row->di_amount;
                $advancetotal_diamount+=$row->di_amount;
                $advancetotalpresentage+=$presentage;
                $total_advance_cap+= $row->pay_amount;
              }
            }
            // end advance section


            // Loan settle section
            if($settle_data){?>
              <td><?=$settle_data->settle_date?></td>
              <td> <?=$settle_data->settle_seq ?></td>
              <td><?=number_format($settle_data->amount,2)?></td>
              <td> %</td>
              <td><?=$settle_data->rct_no?></td>
              <td>
                <div id="checherflag">

                </div>
              </td>

            <? }
          // end Loan settle section

          // Loan prossing section

            if($paylistinq){
                $current1=0;
                foreach($paylistinq as $row){
                  $current1=$current1+$row->tot_cap;
                  if($current_res->discounted_price>0){
                    $presentage=(($current1+$current)/$current_res->discounted_price)*100;
                    $remaining_balance = $current_res->discounted_price - ($current1+$current);
                  ?>

                <tbody>
                  <tr class="">
                    <th scope="row"><?=$row->income_date?></th>
                    <td align="right"><?=number_format($row->tot_cap+$row->tot_int+$row->tot_di,2)?></td>
                    <td align="right"><?=number_format($row->tot_cap,2)?></td>
                    <td align="right"><?=number_format($row->tot_int,2)?></td>
                    <td align="right"><?=number_format($row->tot_di,2)?></td>
                    <td align="right"> <?=number_format($presentage,2)?>%</td>
                    <td align="right"><?=number_format($remaining_balance,2)?></td>
                    <td><?=$row->RCT?></td>
                    <td>
                      
                    </td>

                  </tr>

              <?
                $total_payamount+=$row->pay_tot+$row->tot_di;
                $total_capamount+=$row->tot_cap;
                $total_intamount+=$row->tot_int;
                $total_diamount+=$row->tot_di;

              }}} ?>


              <tr class="" style="background: bisque;">
                <th scope="row">Total</th>
                <td align="right"><?=number_format($total_payamount+$advancetotal_payamount,2)?></td>
                <td align="right"><?=number_format($total_capamount+$total_advance_cap,2)?></td>
                <td align="right"><?=number_format($total_intamount,2)?></td>
                <td align="right"><?=number_format($total_diamount+$advancetotal_diamount,2)?></td>
                <td align="right"><?=number_format($presentage,2)?>%</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <!-- end Loan prossing section -->

          </tbody>
        </table>
</div>

<!-- End tickect 814 -->


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

                      <div class="form-title">
								<h5>Customer Excess Payment Refund</h5>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr> <th>Refund Date</th><th>Amount </th><th>Voucher Number</th><th>Cheque</th> <th>Pay Status </th></tr> </thead>
                      <? if($refunddata){$c=0;
                          foreach($refunddata as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->applydate?></th><td> <?=number_format($row->amount,2) ?></td><td > <?=$row->voucher_id?></td>
                        <td><?=$row->CHQNO?></td>
                        <td><?=$row->status?></td>

                         </tr>

                                <? }} ?>
                          </tbody></table>

                    </div>

    <? }?>
    <? if($res_his){?>
     <div class="form-title">
		<h4> Reservation History </h4>
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
     <td><a href="javascript:get_resale_paymentdetails('<?=$raw->res_code?>')" title="Refund Details"><i class="fa fa-money nav_icon "></i></a></td>
    </tr>
    <? }?>
    </table>
    <? }?>
    </div>
</div>
