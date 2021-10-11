<div class="form-title">
<h4>Online Payment Details of <?=$from_date?> To <?=$to_date?>
   <span style="float:right">
      <a href="#" id="create_excel" name="create_excel"><i class="fa fa-file-excel-o nav_icon"></i></a>
    </span>
  </h4>
</div>
<table class="table" id="online_payment">
    <thead>

    <tr>
        <th>ID</th>
        <th>Bank</th>
        <th>Transaction No</th>
        <th>Amount</th>
        <th>Drown To</th>
        <th>Narration</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $total=0;
    if ($online_trans){
    $c=0;
    foreach($online_trans as $rowdata){
    ?>

    <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
        <th scope="row"><?=$c?></th>
        <td><?=$rowdata->name ?></td>
        <td><?=$rowdata->CHQNO?></td>
        <td align="right"><?=number_format($rowdata->dr_total,2)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><?=$rowdata->CHQNAME ?></td>
        <td><?=$rowdata->narration ?></td>
        <td><?=$rowdata->date ?></td>

    </tr>
    <?
    $total=$total+$rowdata->dr_total;
    }
    ?>
    <tr>
        <th scope="row">Total</th>
        <td></td>
        <td></td>
        <td align="right"><?=number_format($total,2)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
  <?
  }
    ?>
    </tbody>
</table>
