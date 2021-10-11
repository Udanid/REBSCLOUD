
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">
function view_customer_nic(id,type)
{
	//alert(id) update by nadee ticket number 1064
	window.open( "<?=base_url()?>re/lotdata/view_nic/"+id+"/"+type);
}
function load_printscrean1(id,prjid)
{
      window.open( "<?=base_url()?>re/lotdata/print_inquary/"+id+"/"+prjid );

}
function get_loan_detalis(id)
{

  $('#popupform').delay(1).fadeIn(600);
  $( "#popupform" ).load( "<?=base_url()?>re/eploan/get_loanfulldata_popup/"+id );

}
function get_charge_details(id)
{

  $('#popupform').delay(1).fadeIn(600);

  $( "#popupform" ).load( "<?=base_url()?>re/reservation/get_chargerfulldata/"+id );

}
function get_customer_details(id,paytype)
{

  $('#popupform').delay(1).fadeIn(600);

  $( "#popupform" ).load( "<?=base_url()?>re/lotdata/get_customerpopup/"+id+"/"+paytype);

}
function get_resale_paymentdetails(id,paytype)
{

  $('#popupform').delay(1).fadeIn(600);

  $( "#popupform" ).load( "<?=base_url()?>re/lotdata/get_resalepayment/"+id+"/"+paytype);

}
function get_followuphistory(id)
{

  $('#popupform').delay(1).fadeIn(600);

  $( "#popupform" ).load( "<?=base_url()?>re/lotdata/get_followup/"+id);

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

//Madushan 
function updateDeedTransfer(){
    var res_code=$("#resCode").val();
    //alert(res_code);
    var checkedVal=0;

    if ($('#chDeed').is(":checked"))
    {
      checkedVal=$("#chDeed").val();
      
    }

   // alert(checkedVal);
    $.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'re/lotdata/updateDeedTransfer/';?>',
            data: {checkedVal: checkedVal ,res_code:res_code},
            success: function(data) {
              
            }
        });
    
}

</script>

<script type="text/javascript">
  $(document).ready(function(){
      $('#create_excel').click(function(){
          $(".table2excel").table2excel({
          exclude: ".noExl",
          name: "Receipt Details",
          filename: "Receipt_Details.xls",
          fileext: ".xls",
          exclude_img: true,
          exclude_links: true,
          exclude_inputs: true
      });

        });
   });
</script>

<div class="row">
  <div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
    <h4>Block Details
      <span style="float:right"> <a href="javascript:load_printscrean1('<?=$lotdetail->lot_id?>','<?=$projectdata->prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
      </span>
    </h4>
  </div>
           <table class="table  ">
    <tr  style=" padding-left:10px;">
      <th>Block Number</th><td><?=$lotdetail->lot_number?></td>
      <th>Land Extent</th><td><?=$lotdetail->extend_perch?></td>
      <th>Perch Price</th><td><?=number_format($lotdetail->price_perch,2)?></td>
    </tr>

    <tr >
      <th>Land Selling Price</th><td><?=number_format($lotdetail->sale_val,2)?></td>
      <th>Land Cost</th><td><?=number_format($lotdetail->costof_sale,2)?></td>
      <th>Land Profit</th><td><?=number_format($lotdetail->sale_val-$lotdetail->costof_sale,2)?></td>
    </tr>
 <? if($lotdetail->lot_type=='H'){?>
    <tr >
    <th>House Selling Price</th><td><?=number_format($lotdetail->housing_sale,2)?></td>
    <th>House Cost </th><td><?=number_format($lotdetail->housing_cost,2)?></td>
     <th>House Profit</th><td><?=number_format($lotdetail->housing_sale-$lotdetail->housing_cost,2)?></td>
     </tr>
      <tr class="info">
    <th >Total Selling Price</th><td><?=number_format($lotdetail->housing_sale+$lotdetail->sale_val,2)?></td>
    <th>Total Cost </th><td><?=number_format($lotdetail->housing_cost+$lotdetail->costof_sale,2)?></td>
     <th>Total Profit</th><td><?=number_format($lotdetail->housing_sale+$lotdetail->sale_val-$lotdetail->housing_cost-$lotdetail->costof_sale,2)?></td>
     </tr>
   <?
	}
   ?>
    <tr>
      <th>Block Status</th><td><?=$lotdetail->status?></td>
      <th>Plan Number</th><td><?=$lotdetail->plan_no?></td>
      <th>Design</th><td><?=$lotdetail->design_name?></td>
    </tr>
    </table>




   <? if($current_rescode){

	   $loanpayment=0;
	 		  if($paylistinq){

                foreach($paylistinq as $row){
                  $loanpayment=$loanpayment+$row->tot_cap;
				}
			  }
			if($rebate)
			 $loanpayment= $loanpayment+$rebate->balance_capital;
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
			$lastpaydate=get_last_payment_date($current_res->res_code);
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
      <input type="hidden" name="resCode" id="resCode" value="<?=$current_res->res_code?>">
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
      
      <? if($cusdata2){?>
      
       <tr>
      <th>Receipting Customer Name</th><td><?=$cusdata2->first_name?>-<?=$cusdata2->last_name?></td>
      <th>Mobile</th><td><?=$cusdata2->mobile?></td>
      <th>Address</th><td><?=$cusdata2->address1?>, <?=$cusdata2->address2?>, <?=$cusdata2->address3?></td>
      <th>NIC</th><td><a href="javascript:get_customer_details('<?=$cusdata2->cus_code?>','<?=$current_res->pay_type?>')" title="Customer Data"><?=$cusdata2->id_number?></a></td></tr>
      <? }?>
    <tr>
      <th>Current Selling Price</th><td><?=number_format($current_res->seling_price,2)?></td>
      <th>Discount</th><td><? echo number_format($current_res->seling_price - $current_res->discounted_price,2);?></td>
      <th>Discounted Price</th><td><?=number_format($current_res->discounted_price,2)?></td>
      <th>Actual Profit</th><td><?=number_format($current_res->discounted_price-$lotdetail->costof_sale-$lotdetail->housing_cost,2)?></td>
    </tr>
     <? if($lotdetail->lot_type=='H'){?>
    <tr class="info">
    <th>House Selling Price</th><td><?=number_format($current_res->hm_seling_price,2)?></td>
     <th>Discount</th><td><? echo number_format($current_res->hm_seling_price - $current_res->hm_discounted_price,2);?></td>
    <th>Discounted Price</th><td><?=number_format($current_res->hm_discounted_price,2)?></td>
     <th>Actual House Profit</th><td><?=number_format($current_res->hm_discounted_price-$lotdetail->housing_cost,2)?></td>
     </tr>
      <tr >
    <th >Land Selling Price</th><td><?=number_format($current_res->seling_price-$current_res->hm_seling_price,2)?></td>
    <th>Discount </th><td><?=number_format($current_res->seling_price-$current_res->hm_seling_price-$current_res->re_discounted_price,2)?></td>
     <th>Discounted Price</th><td><?=number_format($current_res->re_discounted_price,2)?></td>
         <th>Actual Land Profit</th><td><?=number_format($current_res->re_discounted_price-$lotdetail->costof_sale,2)?></td>

     </tr>
   <?
	}
   ?>
<? 
$restype=$current_res->pay_type;
$sub_type = '';
if($loan_data){
	$restype=$loan_data->loan_type;
}
?>
    <tr>

       <!--Ticket No:2868 Added By Madushan 2021.05.24-->
      <?if($loan_data){
        $sub_type = get_actual_loantype($loan_data->loan_code);//reaccount_helper.php
      }?>


      <th>Sales Type</th><td><?if($sub_type != ''){?><?=$sub_type;}else{?><?=$restype;}?><? if($current_res->pay_type!='Outright' || $current_res->pay_type!='Pending'){ if($loan_data){?>
      <a href="javascript:get_loan_detalis('<?=$loan_data->loan_code?>')"><span class="label label-success">Loan Data</span></a></span>

    <? }}?></td>
      <th>Down Payment</th><td><?=number_format($current_res->down_payment ,2)?></td>
      <th>Balance Amount</th><td><?=number_format($current_res->discounted_price-($current_res->down_payment+$loanpayment),2)?></td>
      <th>Met Legal Officer</th>

      <td>
          <input id="chofficer" type="checkbox" name="chbxMetOfficer" value="1" onchange="updateMetOfficer()" <?php if($cusdata->met_officer ==1) {echo " checked disabled";} ?>>
          <input type="hidden" name="txtCusId" id="txtCusId" value="<?=$cusdata->cus_code?>">
      </td>
    </tr>
    <tr>
      <?if($sub_type != ''){if($sub_type == 'EPB' && check_access('deed_transfer_allow')){?>
      <th>Deed transfer approved</th>
      <td> <input id="chDeed" type="checkbox" name="chbxDeedTransfer" value="1" onchange="updateDeedTransfer()" <?php if($current_res->deed_transfer_status == '1') {echo "checked";} ?>></td>
      <?}}elseif($restype == 'EPB' && check_access('deed_transfer_allow')){?>
        <th>Deed transfer approved</th>
        <td> <input id="chDeed" type="checkbox" name="chbxDeedTransfer" value="1" onchange="updateDeedTransfer()" <?php if($current_res->deed_transfer_status == '1') {echo "checked";} ?>></td>
        <?}?>
    </tr>
    <tr>
      <th>After Reservation Discount Comment</th>
      <td colspan="6"><?php
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
        <span style="float:right"><a href="javascript:get_ledgercard('<?=$current_res->res_code?>')" title="Ledger Card"><i class="fa fa-file nav_icon "></i></a><a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
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
              <th>Receipt Date</th>
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

					$tag='';
					 if($row->enty_type==4)
					 $tag='/DI Return Entry'
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
                      <td><?=$row->rct_no?><?=$tag?></td>
                      <td><?=$row->entry_date;?></td>
                      <td>
                        <div id="checherflag">
                        <? if($row->type=='Cost Trasnfer'){?>
                         YES
                        <? }?>
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

 // end Loan settle section

          // Loan prossing section

            if($paylistinq){
                $current1=0;
                foreach($paylistinq as $row){
                  $current1=$current1+$row->tot_cap;
                  if($current_res->discounted_price>0){
                    $presentage=(($current1+$current)/$current_res->discounted_price)*100;
                    $remaining_balance = $current_res->discounted_price - ($current1+$current);


					$tag='';
					 if($row->enty_type==4)
					 $tag='/DI Return Entry'
                  ?>

                <tbody>
                  <tr class="">
                    <th scope="row"><?=$row->pay_date?></th>
                    <td align="right"><?=number_format($row->pay_tot+$row->tot_di,2)?></td>
                    <td align="right"><?=number_format($row->tot_cap,2)?></td>
                    <td align="right"><?=number_format($row->tot_int,2)?></td>
                    <td align="right"><?=number_format($row->tot_di,2)?></td>
                    <td align="right"> <?=number_format($presentage,2)?>%</td>
                    <td align="right"><?=number_format($remaining_balance,2)?></td>
                    <td><?=$row->RCT?><?=$tag?></td>
                    <td><?=date('Y-m-d',strtotime($row->rct_date));?></td>
                    <td>
                      <div id="checherflag">

                      </div>
                    </td>

                  </tr>

              <?
                $total_payamount+=$row->pay_tot+$row->tot_di;
                $total_capamount+=$row->tot_cap;
                $total_intamount+=$row->tot_int;
                $total_diamount+=$row->tot_di;

              }}} ?>
				<?
                
				 if($rebate)
				 {
					  $current1=$current1+$rebate->balance_capital;
                    $presentage=(($current1+$current)/$current_res->discounted_price)*100;
                    $remaining_balance = $current_res->discounted_price - ($current1+$current);
					?>
                    
                     <tr class="">
                    <th scope="row"><?=$rebate->apply_date?></th>
                    <td align="right"><?=number_format($rebate->int_paidamount+$rebate->delay_int+$rebate->balance_capital,2)?></td>
                    <td align="right"><?=number_format($rebate->balance_capital,2)?></td>
                    <td align="right"><?=number_format($rebate->int_paidamount,2)?></td>
                    <td align="right"><?=number_format($rebate->delay_int,2)?></td>
                    <td align="right"> <?=number_format($presentage,2)?>%</td>
                    <td align="right"><?=number_format($remaining_balance,2)?></td>
                    <td><?=$rebate->rct_no?></td>
                    <td><?=$rebate->entry_date;?></td>
                    <td>
                      <div id="checherflag">

                      </div>
                    </td>

                  </tr>
                    <?
					
					 $total_payamount+=$rebate->int_paidamount+$rebate->delay_int+$rebate->balance_capital;
                $total_capamount+=$rebate->balance_capital;
                $total_intamount+=$rebate->int_paidamount;
                $total_diamount+=$rebate->delay_int;

				 }
				?>

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
              </tr><?
            // Loan settle section
            if($settle_data){?>
              <td><?=$settle_data->settle_date?></td>
              <td> <?=$settle_data->settle_seq ?></td>
              <td><?=number_format($settle_data->amount,2)?></td>
              <td> %</td>
              <td><?=$settle_data->rct_no?></td>
              <td>
                <div id="checherflag">
                  <? if($settle_data->type=='Cost Trasnfer'){?>
                    YES
                  <? }?>
                </div>
              </td>

            <? }
         ?>

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
                <h5>Additional Developments</h5>
              </div>

                      <table class="table"><tr><th>Discription</th><th>Payable Amount</th><th>Paid Amount</th><th>Balance</th></tr>
                      <?
					   $all_payable=0;
					   if($development_data)
					   {foreach($development_data as $raw)
					  {
						  $totpaid=get_paid_amount_code($raw->id);
						  $totalpaybel=$raw->sale_value-$totpaid;

						  ?>

                      <tr>
                      <td><?=$raw->description?></td>
                      <td><?=number_format($raw->sale_value,2)?></td>
                      <td><?=number_format( $totpaid,2)?></td>
                       <td><?=number_format( $totalpaybel,2)?></td>

                      </tr>
                      <?
					  } }?>

                            </table>
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
<script type="text/javascript">
  function get_ledgercard(lotid)
  {

    $('#popupform').delay(1).fadeIn(600);

    $( "#popupform" ).load( "<?=base_url()?>re/eploan/get_ledgercard/"+lotid);

  }
</script>
