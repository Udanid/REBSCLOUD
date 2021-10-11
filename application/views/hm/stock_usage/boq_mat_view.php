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
<table class="table" >
  <thead class="success">
  <tr>
    <th></th>
    <th>Material Name</th>
    <th>Material BOQ</th>
    <th>Material Usage</th>
    <th colspan="4"></th>

  </tr>
  <thead>
  <? if($boq_data){$c=0;
    foreach ($boq_data as $key => $value) {
      $c++;
      ?>
      <tr class="<? echo ($c<0) ? 0 : ($c % 2 == 1) ? 'info' : ''; ?>">
        <td></td>
        <td><?=$value->mat_name?> </td>
        <td><?=$value->value?>&nbsp; <?=$value->mt_name?></td>
        <td><? if($value->used_qty>0){ echo $value->used_qty; echo " "; echo $value->mt_name;}?></td>
        <td ></td>

      </tr>
    <? }
  }?>
</table>
