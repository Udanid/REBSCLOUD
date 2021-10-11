<?
if($sitestocklist)
{
?>
<label class="control-label">Site Stock meterial</label>
<select id="met" name="met" onChange="load_balanceqty(this.value)" class="form-control" required="required">
	<option value="">select meterial</option>
	<?
     foreach($sitestocklist as $mat){
     	?>
       <option value="<?=$mat->site_stockid?>_<?=$mat->balqty?>_<?=$mat->trans_qty?>_<?=$mat->sitestockunitprice?>">Unit <?=get_unitname($mat->lot_id)?> > GRN <?=$mat->grn_id?> - site Stock <?=$mat->site_stockid?></option>
     	<?
     }
	?>
</select>
<?
}
?>