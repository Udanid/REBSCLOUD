<script type="text/javascript">

jQuery(document).ready(function() {

	 $( "#needdate" ).datepicker({dateFormat: 'yy-mm-dd'});

	$("#meterials").chosen({
     allow_single_deselect : true
    });
});
</script>

<table class="table fullmetqty" width="70%">
	<tr>
		<td width="25%">
			<select class="form-control" id="meterials">
				<option value="">Select Meterial</option>
				<?
                foreach($meterial as $met){
                	?>
                <option value="<?=$met->mat_id?>"><?=$met->mat_name?></option>
                	<?
                }
				?>
			</select>
		</td>
		<td width="10%">
			<input type="text" class="form-control" name="req_qty" placeholder="Qty">
		</td>
		<td width="15%">
			<input type="text" class="form-control" name="needdate" id="needdate" placeholder="Need Date" required>
		</td>
		<td>Remove</td>
		
	</tr>
</table>