<script type="text/javascript">
	$("#lotid").chosen({
      allow_single_deselect : true
    });
</script>

<label class="control-label">Lot</label>
<select name="lotid" id="lotid" class="form-control"required="required" onChange="loadStages(this.value)"  >
	<option value="all">NO Site</option>
	<?
    foreach($lotlist as $ll)
    {
	?>
    <option value="<?=$ll->lot_id?>"><?=$ll->lot_number?></option>
	<?
    }
	?>
</select>