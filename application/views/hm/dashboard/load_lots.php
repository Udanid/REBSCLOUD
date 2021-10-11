<label class="control-label">Lot</label>
<select name="lotid" id="lotid2" class="form-control"required="required" onChange="load_dashboard(this.value)"  >
	<option ></option>
	<?
    foreach($lotlist as $ll)
    {
	?>
    <option value="<?=$ll->lot_id?>"><?=$ll->lot_number?></option>
	<?
    }
	?>
</select>
