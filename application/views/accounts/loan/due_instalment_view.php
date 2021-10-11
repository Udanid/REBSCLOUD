<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4>Due Instalment
       </h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >

  <table class="table">
    <thead>
      <tr>
        <th>Num</th>
        <th>Name</th>
        <th>Bank</th>
        <th>Loan Amount</th>
        <th>Instalment No</th>
        <th>Capital Instalment</th>
        <th>Interest Instalment</th>
        <th>Total Instalment</th>
        <th>Due date</th>
        <th>Cheque Number</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($duelist){
        $c = 0;
        $count = 1;
        foreach($duelist as $row){
            if($row->pay_status=='PENDING'){?>
              <tr bgcolor="#FF0000">
              <?}else{
          ?>
            <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
          <?}?>

            <td><?php echo $count; ?></td>
            <td><?php echo $row->loan_number; ?></td>
            <td><?=$banknames[$row->bank_code]->BANKNAME;?></td>
            <td class="text-right"><?=number_format($row->loan_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><?php echo $row->instalment; ?></td>
            <td class="text-right"><?=number_format($row->cap_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="text-right"><?=number_format($row->int_amount,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="text-right"><?=number_format($row->tot_instalment,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><?php echo $row->cheque_no; ?></td>
            <td><?php echo $row->deu_date; ?></td>
            <td><?php echo $row->pay_status; ?></td>
            </tr>
            <?php
            $count++;
          }
        } ?>
      </tbody>
    </table>
  </div>
</div>

</div>
