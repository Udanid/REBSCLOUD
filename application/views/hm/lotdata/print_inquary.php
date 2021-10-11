<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	window.close();
}
</script>
<body onload="print_function()">
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
    
   <div class="form-title">
		<h4>Lot Number : <?=$lotdetail->lot_number?>-<?=$lotdetail->plan_sqid?> 
       <span style="float:right"> Project : <?=$projectdata->project_name?></span></h4>
	</div>
    <table class="table" border="1" cellspacing="0" cellpadding="0">
    <tr>
    <th align="left">Lot Number</th><td><?=$lotdetail->lot_number?>-<?=$lotdetail->plan_sqid?></td>
    <th align="left">Land Extend</th><td><?=$lotdetail->extend_perch?></td>
     <th align="left">Perch Price</th><td><?=$lotdetail->price_perch?></td>
   
    </tr>
    <tr>
    <th align="left">Selling Price</th><td><?=number_format($lotdetail->sale_val,2)?></td>
    <th align="left">Cost of Sale</th><td><?=number_format($lotdetail->costof_sale,2)?></td>
     <th align="left">Profit</th><td><?=number_format($lotdetail->sale_val-$lotdetail->costof_sale,2)?></td>
   
    </tr>
     <tr>
    <th>Block Status</th><td><?=$lotdetail->status?></td>
   
    </tr>
    </table>
   <? if($current_rescode){?>
    <div class="form-title">
		<h4> <?=$current_res->res_code?>-<?=$current_res->res_seq?>  Current Reservation Details</h4>
	</div>
     <table class="table">
    <tr>
    <th>Customer Name</th><td><?=$current_res->first_name?>-<?=$current_res->last_name?></td>
    <th>Discount</th><td><?=$current_res->discount?></td>
     <th>Discounted Price</th><td><?=number_format($current_res->discounted_price,2)?></td>
   
    </tr>
    <tr>
    <th>Seles Type</th><td><?=$current_res->pay_type?></td>
    <th>Down Payment</th><td><?=number_format($current_res->down_payment ,2)?></td>
     <th>Balance Amount</th><td><?=number_format($current_res->discounted_price-$current_res->down_payment,2)?></td>
    </tr>
    </table>
         <table class="table"> <thead> <tr> <th>Payment Date</th><th>Payment Sequence </th><th>Amount</th><th>%</th><th>Reciept No</th> <th>Profit  Transferd</th></tr> </thead>
                  
    <? if($current_advances){$c=0;$current=0;
		foreach($current_advances as $row){
			$current=$current+$row->pay_amount;
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
    </tbody></table>
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
       <td><?=number_format($resolelist[$raw->res_code]->repay_total,2)?></td>
      <? }else{?>
       <td><?=number_format($raw->down_payment+$resolelist[$raw->res_code]->paid_capital,2)?></td>
       <td><?=number_format($resolelist[$raw->res_code]->repay_capital,2)?></td>
    
      <? }?>
    
    </tr>
    <? }?>
    </table>
    <? }?>
    </div> 
</div>
</body>