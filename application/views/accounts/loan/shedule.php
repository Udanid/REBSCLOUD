<h4>Loan No:  <?=$loandata->loan_number;?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$sheduleid?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
<table class="table" id="shedule_table">
  <thead>
    <tr>
      <th>Instalment No</th>
      <th>Capital Instalment</th>
      <th>Interest Instalment</th>
      <th>Total Instalment</th>
      <th>Due date</th>
      <th>Status</th>
      <th>Cheque Number</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $date=date('Y-m-d');
    $totpaid=0.00;
    $topendind=0.00;
    foreach ($shedules as $key => $item) {
      if($item->deu_date<=$date && $item->pay_status=='PENDING'){
        $totpaid=$totpaid+$item->tot_instalment;
      ?>
      <tr bgcolor="#FF0000"><th><?=$item->instalment;?></th>
        <th class="text-right"><?=$item->cap_amount;?></th>
      <th class="text-right"><?=$item->int_amount;?></th>
      <th class="text-right"><?=$item->tot_instalment;?></th>
      <th class="text-right"><?=$item->deu_date;?></th>
      <th><?=$item->pay_status;?></th>
      <th><?=$item->cheque_no;?></th>
    </tr>
  <?  }
else{
  $topendind=$topendind+$item->tot_instalment;
     ?>
     <tr><th><?=$item->instalment;?></th>
       <th class="text-right"><?=$item->cap_amount;?></th>
     <th class="text-right"><?=$item->int_amount;?></th>
     <th class="text-right"><?=$item->tot_instalment;?></th>
     <th class="text-right"><?=$item->deu_date;?></th>
     <th><?=$item->pay_status;?></th>
     <th><?=$item->cheque_no;?></th>
   </tr>
 <?  }
}
    ?>
  </tbody>
</table>
</div>
</div>
