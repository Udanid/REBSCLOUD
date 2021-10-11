<script type="text/javascript">
	$("#poid").chosen({
	  allow_single_deselect : true
    });
</script>

<?
 //print_r($polistitem);
?>
<label class="control-label" >PO Number</label>
	<select name="poid" id="poid" class="form-control"required="required" onChange="load_poItems(this.value)"  >
		<option value="">Select PO</option>
		<?
        foreach($polistitem as $pol){
		?>
		<option value="<?=$pol->poid?>"><?=$pol->po_code?>-<?=$pol->poid?></option>
		<?
        }
		?>
	</select>