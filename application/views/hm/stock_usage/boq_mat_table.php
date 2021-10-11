<? //print_r($boq_data);
//echo $prj_id."1</br>";
//echo $lot_id."2</br>";
//echo $task_id;

?>
<script>
function cal_balance(amount,stock_id){
  var bal_usage=$('#bal_usage_'+stock_id).val();
  var rcv_qty=$('#rcv_'+stock_id).val();
  var usage=$('#used_'+stock_id).val();
  var trans=$('#trans_'+stock_id).val();
  var new_usage=$('#new_usage_'+stock_id).val();
  var tot=rcv_qty-(usage-trans);
  var amt=tot-amount;
  if(amt<0 || rcv_qty<amt){

    $('#bal_usage_'+stock_id).val(tot);
    $('#new_usage_'+stock_id).val(0);
    document.getElementById("checkflagmessage").innerHTML='You can not exceed request amount';
    $('#flagchertbtn').click();
  }else{
    $('#bal_usage_'+stock_id).val(amt);
  }






}


</script>
<? if($stock_list)
      {
        $c=1;
        //print_r($boq_data_used[$value->id])
        ?><table class="table">
          <tr  class="<? echo ($c<0) ? 0 : ($c % 2 == 1) ? 'info' : ''; ?>">
            <th>Batch Code</th>
            <th>Stock Qty</th>
            <th>Usage Qty</th>
            <th>Transfers Qty</th>
            <th>New Usage</th>
            <th>Qty Balanace</th>
          </tr>
          <?
        foreach ($stock_list as $key2 => $value2) {
          $mat_data=get_meterials_all($value2->mat_id);
          $c++;
          ?>
          <tr  class="<? echo ($c<0) ? 0 : ($c % 2 == 1) ? 'info' : ''; ?>">
            <td><?=$value2->batch_code?></td>
            <td><?=$value2->rcv_qty?> <?=$mat_data->mt_name?></td>
            <td><?=$value2->ussed_qty?> <?=$mat_data->mt_name?></td>
            <td><?=$value2->trans_qty?> <?=$mat_data->mt_name?></td>
            <td>
              <input type="hidden" id="stock_<?=$value2->site_stockid?>" name="stock_<?=$value2->site_stockid?>" value="<?=$value2->site_stockid?>">
              <input type="hidden" id="rcv_<?=$value2->site_stockid?>" name="rcv_<?=$value2->site_stockid?>" value="<?=$value2->rcv_qty?>">

              <input type="hidden" id="used_<?=$value2->site_stockid?>" name="used_<?=$value2->site_stockid?>" value="<?=$value2->ussed_qty?>">
              <input type="hidden" id="trans_<?=$value2->site_stockid?>" name="trans_<?=$value2->site_stockid?>" value="<?=$value2->trans_qty?>">

              <input type="hidden" id="price_<?=$value2->site_stockid?>" name="price_<?=$value2->site_stockid?>" value="<?=$value2->price?>">

              <input type="number" max="<?=$value2->balqty?>" min="<?=(-$value2->rcv_qty)?>"  id="new_usage_<?=$value2->site_stockid?>" name="new_usage_<?=$value2->site_stockid?>" value="0.00" onchange="cal_balance(this.value,<?=$value2->site_stockid?>)">
            </td>
            <td>

              <input type="text" id="bal_usage_<?=$value2->site_stockid?>" name="bal_usage_<?=$value2->site_stockid?>" readonly value="<?=number_format($value2->balqty,2)?>"></td>
          </tr>
      <?  }
?>
</table>
<?
      }?>

      <div><button type="submit" class="btn btn-primary disabled pull-right" >Update Usage</button>
      </div>
