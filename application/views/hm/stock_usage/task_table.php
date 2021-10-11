<script type="text/javascript">

jQuery(document).ready(function() {


  $("#task_id").chosen({
    allow_single_deselect : true
  });



});
</script>
<select class="form-control" placeholder="Task List"  id="task_id" name="task_id"    required >
  <option value="">Task List</option>
  <? foreach ($task_list as $raw){?>

    <option value="<?=$raw->id?>" ><?=$raw->id?> - <?=$raw->description?></option>
  <? }?>


</select>
