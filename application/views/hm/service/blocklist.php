
<script type="text/javascript">

jQuery(document).ready(function() {


 $("#lot_id").focus(function() {
			$("#lot_id").chosen({
				allow_single_deselect : true
			});
			});


});


</script>
</hr>

  <select class="form-control lot_id" placeholder="Block Number"  id="lot_id" name="lot_id" onchange="load_sub_cat(this.value)"   required >
    <option value="">Block Number</option>
    <? foreach ($lotlist as $raw){?>

      <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
    <? }?>


  </select>
  