<script type="text/javascript">

jQuery(document).ready(function() {


  $(".task_id").chosen({
    allow_single_deselect : true
  });



});
</script>
<div class="form-group">
<label class=" control-label col-sm-3 " >Task list</label>
<div class="col-sm-6">
<select class="form-control task_id" placeholder="Task List"  id="task_id<?=$new_lotview?><?=$new_subcatview?>" name="task_id<?=$new_lotview?><?=$new_subcatview?>">
  <option value="">Task List</option>
  <? foreach ($task_list as $raw){?>

    <option value="<?=$raw->id?>" ><?=$raw->id?> - <?=$raw->description?></option>
  <? }?>


</select>
</div>
</div>
