
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
jQuery(document).ready(function() {
$("#mat_code").focus(function() {
	$("#mat_code").chosen({
     allow_single_deselect : true
  });
});
});
</script>
<? if($boq_data){?>
<div class="form-group">
<div class="col-sm-8">
<select class="form-control" onchange="load_fulldetails(this.value)" placeholder="Select Material" id="mat_code" name="mat_code" >
<option value="">Search here..</option>
<?    foreach($boq_data as $row){?>
<option value="<?=$row->mat_id?>" <? if(!$boq_data_used[$row->id]){ echo "disabled";}?>><?=$row->mat_code?> <?=$row->mat_name?></option>
<? }?>
</select>
</div>
</div>
<? }?>
