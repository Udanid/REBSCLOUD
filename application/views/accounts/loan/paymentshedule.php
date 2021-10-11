<div class="form-body  form-horizontal" >
  <table class="table"><tr><th>Instalment</th><th>Capital</th><th>Interest</th><th>Total</th><th>Due Date</th></tr>
<? $delaintot=0;$inslist="";$tot=0;$thisdelayint=0;
foreach ($dataset as $key => $value) {
$tot=$value->cap_amount+$value->int_amount;
  ?>
  <tr>
    <th><?=$value->instalment;?><input type="hidden" id="instalment_no" name="instalment_no" value="<?=$value->instalment;?>"></th>
    <th><?=$value->cap_amount;?><input type="hidden" id="cap_amount" name="cap_amount" value="<?=$value->cap_amount;?>"></th>
    <th><?=$value->int_amount;?><input type="hidden" id="int_amount" name="int_amount" value="<?=$value->int_amount;?>"></th>
    <th><?=$tot;?></th>
    <th><?=$value->deu_date;?></th>
  </tr>

<? }?>
<tr>
  <th colspan="3">Total</th>
  <th><input type="hidden" id="loan_no" name="loan_no" value="<?=$loan_id;?>"><input type="text" id="pay_amount" name="pay_amount" value="<?=$tot;?>"></th>
  <th><input type="hidden" id="leger_id" name="leger_id" value="<?=$leger_id;?>">
    <input type="hidden" id="bank_id" name="bank_id" value="<?=$bank_id;?>">
    <input type="hidden" id="bankname" name="bankname" value="<?=$bankname;?>">

  </th>
</tr>
</table>
<div class="form-group validation-grids" style="float:right">
  <button type="submit" class="btn btn-primary" >Make Payment</button>
</div>
</div>
