<?
if($metlist)
{
?>
<label class="control-label">Meterial</label>
<select id="met" name="met" onChange="load_sitestockmat(this.value)" class="form-control" required="required">
	<option value="">select meterial</option>
	<?
     foreach($metlist as $mat){
     	?>
       <option data-qty="<?=$mat->transferbalqty?>" value="<?=$mat->mat_id?>"><?=$mat->mat_name?></option>
     	<?
     }
	?>
</select>
<?
}
?>