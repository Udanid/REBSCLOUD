<script type="text/javascript">

jQuery(document).ready(function() {


  $(".contract_id").chosen({
    allow_single_deselect : true
  });



});
</script>
<div class="form-group">
<label class=" control-label col-sm-3 " >Contract Supplier list</label>
<div class="col-sm-3">
<select class="form-control contract_id" placeholder="Supplier list"  id="contract_id" name="contract_id" onchange="add_suplier()">
  <option value="">Supplier List</option>

  <? if($subcontract_list){
  foreach ($subcontract_list as $raw){?>

    <option value="<?=$raw->contract_id?>" data-sup="<?=$raw->sup_code?>"><?=$raw->sup_code?> - <?=$raw->first_name?> <?=$raw->last_name?></option>
  <? }}?>

</select>
</div>
</div>
