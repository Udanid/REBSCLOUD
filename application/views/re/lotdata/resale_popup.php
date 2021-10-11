
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
<h4>Resale Details of <?=$resdata->res_code?> -     <?=$resdata->first_name?>   <?=$resdata->last_name?>
       <span style="float:right"> <a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a>
</span></h4>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
 
 <?
 if($loan_status == '0')
		{
 
 ?>
 <table class="table table-bordered">
  <tbody style="font-size:12px">
 <tr><th>Discounted Price</th><td><?=number_format($resdata->discounted_price,2)?></td>
<th>Total  Down Payment</th><td><?=number_format($resdata->down_payment,2)?></td>
 <th>Non Refundabale </th><td><?=number_format($resdata->non_refund,2)?></td></tr>

 <tr><th>Refund Total</th><td><?=number_format($resaledata->repay_total,2)?></td></tr>
 </tr>
 </table>
   <table class="table">
     <thead> <th colspan="8" class="info"> Advance Payment Details</th></thead>
      <tbody style="font-size:12px">
        <tr> <th>Payment Date</th><th>Payment Sequence </th><th>Amount</th><th>DI Amount</th><th>%</th><th>Reciept No</th> <th>Profit  Transferd</th></tr>           
    <? if($current_advances){$c=0;$current=0;
		foreach($current_advances as $row){
			$current=$current+$row->pay_amount;
			$presentage=0;
			if($resdata->discounted_price>0)
			$presentage=($current/$resdata->discounted_price)*100;
		
		?>
     <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->pay_seq ?></td>
                        <td  align="right"> <?=number_format($row->pay_amount,2)?></td> 
                         <td  align="right"> <?=number_format($row->di_amount,2)?></td> 
                        <td  align="right"> <?=number_format($presentage,2)?>%</td> 
                        <td><?=$row->rct_no?></td>
                       
                        <td><div id="checherflag">
                          <? if($row->type=='Cost Trasnfer'){?>
                          YES
                           <? }?>
                        </div></td>
                         </tr> 
    <? } }?>
   
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
	<table  class="table table-bordered">
     <thead> <th colspan="8" class="info"> Refund Details</th></thead>
      <tbody style="font-size:12px">
        <tr> <th>Payment Date</th><th>Total Refund</th><th>PV/ CHQ No</th> <th>Payment Status </th></tr>           
    <? if($paylist){$c=0;$current=0;
		foreach($paylist as $row){
			$current=$current+$row->amount;
			$presentage=0;
			
		?>
     <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->applydate?></th>
                       <td  align="right"> <?=number_format($row->amount,2)?></td> 
                        <td> <?=$row->voucher_id ?>/<?=$row->CHQNO ?></td>
                        <td  align="right"> <?=$row->status?></td> 
                        
                         </tr> 
    <? } }?>
   
    </tbody></table>

  	<? } else{?>
    <table class="table table-bordered" align="center">
  <tbody style="font-size:12px">
 <tr><th>Discounted Price</th><td><?=number_format($resdata->discounted_price,2)?></td>
 <th>Total  Down Payment</th><td><?=number_format($resdata->down_payment,2)?></td>
 <th>Non Refundabale </th><td><?=number_format($resdata->non_refund,2)?></td></tr>
 <tr><th>Loan Amount</th><td><?=number_format($resaledata->loan_amount,2) ?></td>
<th>Paid Capital</th><td><?=number_format($resaledata->paid_capital,2) ?></td>
 <th>Paid Interest</th><td><?=number_format($resaledata->paid_int-$resaledata->credit_int,2)  ?></td></tr>
 <tr><th>Credit Interest</th><td><?=number_format($resaledata->credit_int,2)  ?></td></tr>
 </tr>
 </table>
   <table class="table">
     <thead> <th colspan="8" class="info"> Advance Payment Details</th></thead>
      <tbody style="font-size:12px">
        <tr> <th>Payment Date</th><th>Payment Sequence </th><th>Amount</th><th>%</th><th>Reciept No</th> <th>Profit  Transferd</th></tr>           
    <? if($current_advances){$c=0;$current=0;
		foreach($current_advances as $row){
			$current=$current+$row->pay_amount;
			$presentage=0;
			if($resdata->discounted_price>0)
			$presentage=($current/$resdata->discounted_price)*100;
		
		?>
     <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
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
    
	<table  class="table table-bordered">
     <thead> <th colspan="8" class="info"> Refund Details</th></thead>
      <tbody style="font-size:12px">
        <tr> <th>Payment Date</th><th>Total Refund</th><th>PV/ CHQ No</th> <th>Payment Status </th></tr>           
    <? if($paylist){$c=0;$current=0;
		foreach($paylist as $row){
			$current=$current+$row->amount;
			$presentage=0;
			
		?>
     <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->applydate?></th>
                          <td  align="right"> <?=number_format($row->amount,2)?></td> 
                        <td> <?=$row->voucher_id ?>/<?=$row->CHQNO ?></td>
                        <td  align="right"> <?=$row->status?></td> 
                        
                         </tr> 
    <? } }?>
   
    </tbody></table>
    <? }?>
    
  
    </div> 
</div>