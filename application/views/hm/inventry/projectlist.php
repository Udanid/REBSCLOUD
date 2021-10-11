
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#prj_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>

<select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
    <option value="">Project Name</option>
    <option value="all">Main Stock</option>
    <?    foreach($prjlist as $row){?>
    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
    <? }?>
</select>
									