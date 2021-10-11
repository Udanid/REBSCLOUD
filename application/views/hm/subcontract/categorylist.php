
<script type="text/javascript">
jQuery(document).ready(function() {


  $(".cat_id").chosen({
    allow_single_deselect : true
  });


});
</script>
<div class="form-group">
<label class=" control-label col-sm-3 " >Task Category</label>
<div class="col-sm-3">
  <select class="form-control cat_id" placeholder="Block Number"  id="cat_id<?=$new_lotview?><?=$new_subcatview?>" name="cat_id<?=$new_lotview?><?=$new_subcatview?>" onchange="load_task(this.value,<?=$new_lotview?>,<?=$new_subcatview?>)"   required >
    <option value="">Task Category</option>
    <? foreach ($category_data as $raw){?>

      <option value="<?=$raw->boqsubcat_id?>" ><?=$raw->subcat_code?> - <?=$raw->subcat_name?></option>
    <? }?>


  </select>
</div>
<div class="form-group">
  <label class="control-label col-sm-3 " >Agreed amount</label>
  <div class="col-sm-3">
  <input type="text" class="form-control" placeholder="Agreed Amount"  id="task_ageed_amt<?=$new_lotview?><?=$new_subcatview?>" name="task_ageed_amt<?=$new_lotview?><?=$new_subcatview?>"   required >
  </div>
</div>
</div>

<div class="row" id="tasklist<?=$new_lotview?><?=$new_subcatview?>">
  <!-- load tast list by sub cat-->

</div>
