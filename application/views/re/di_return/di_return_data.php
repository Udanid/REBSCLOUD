
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
  
   



   <? if($current_rescode){

	   $loanpayment=0;
	 		  if($loan_paylist){

                foreach($loan_paylist as $row){
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
			$lastpaydate=get_last_payment_date($current_res->res_code);
			 $date1=date_create($lastpaydate);
			 $date2=date_create($todate);
			  $diff=date_diff($date1,$date2);
			 $datelast=$diff->format("%a ");
			 //End Modification

	   ?>
    <div class="form-title">
    <h4> <?=$current_res->res_code?>-<?=$current_res->res_seq?>  Current Reservation Details
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
      <th>Discount</th><td><? echo number_format($current_res->seling_price - $current_res->discounted_price,2);?></td>
      <th>Discounted Price</th><td><?=number_format($current_res->discounted_price,2)?></td>
      
    </tr>

    <tr>
      <th>Sales Type</th><td><?=$current_res->pay_type?><? if($current_res->pay_type!='Outright' || $current_res->pay_type!='Pending'){ if($loan_data){?>
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
   
    </table>

    <!-- Added by kalum ticket 814 2019-10-28 -->

   

    <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

        <table class="table table2excel">
          <thead>
            <tr>
              <th>Payment Date</th>
              <th style="text-align: right;">Payment </th>
              <th style="text-align: right;">Capital</th>
              <th style="text-align: right;">Interest</th>
              <th style="text-align: right;">Default Interest </th>
                <th>Receipt No</th>
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

            if($adance_paylist){
              foreach($adance_paylist as $row){
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
                      <td><?=$row->rct_no?></td>
                      
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

            if($loan_paylist){
                $current1=0;
                foreach($loan_paylist as $row){
                  $current1=$current1+$row->tot_cap;
                  if($current_res->discounted_price>0){
                    $presentage=(($current1+$current)/$current_res->discounted_price)*100;
                    $remaining_balance = $current_res->discounted_price - ($current1+$current);
                  ?>

                <tbody>
                  <tr class="">
                    <th scope="row"><?=$row->pay_date?></th>
                    <td align="right"><?=number_format($row->pay_tot+$row->tot_di,2)?></td>
                    <td align="right"><?=number_format($row->tot_cap,2)?></td>
                    <td align="right"><?=number_format($row->tot_int,2)?></td>
                    <td align="right"><?=number_format($row->tot_di,2)?></td>
                      <td><?=$row->RCT?></td>
                   

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
                <td></td>
              </tr><?
			  
			 
           
         ?>

              <!-- end Loan prossing section -->

          </tbody>
        </table>
        
        <?
        
		 $total_delaypay=$total_diamount+$advancetotal_diamount;
		 $avb_return=$total_delaypay-$return_tot;
		 if($avb_return>0)
		 {?>
          <div class="form-group ">
               <label class="col-sm-3 control-label" >Paid DI Amount</label>
                <div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="paid_amount"  name="paid_amount"  data-error=""   readonly="readonly" value="<?=number_format($total_delaypay,2) ?>" required>
               <input type="hidden" class="form-control" id="tot_di"  name="tot_di"  data-error=""   readonly="readonly" value="<?=$avb_return?>" required>
                </div>
                <label class="col-sm-3 control-label" >Retured DI Amount</label>
                <div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="paid_amount"  name="paid_amount"  data-error=""   readonly="readonly" value="<?=number_format($return_tot,2) ?>" required>
                </div>
            </div>
          
             <div class="clearfix"> </div>
               <br />  <br />
            <div class="form-group ">
               <label class="col-sm-3 control-label" >Current Return Amount (Max : <?=number_format($avb_return,2)?>)</label>
                <div class="col-sm-3" id="subtaskdata"><input type="number" step="0.01" class="form-control" id="return_amount"  name="return_amount"  data-error="Return amount cannot be exceed the paid amount"  max="<?=$avb_return?>" value="" required>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                </div>
            
             
             <label class="col-sm-3 control-label" >Remark</label>
              <div class="col-sm-3" id="subtaskdata"><textarea name="remark" class="form-control" id="remark"  data-error="" ></textarea>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                </div>
             <div class="form-group ">
             <div class="col-sm-2 has-feedback" style="float:right"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Return</button>
            </div>
             <br /><br /><br /><br /> <br /><br /><br /><br />
       	 </div>
          
          <? }?>
                                   
                                        
</div>

<!-- End tickect 814 -->

    
    <? }?>
    </div>
</div>
