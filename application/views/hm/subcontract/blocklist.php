
<script type="text/javascript">

jQuery(document).ready(function() {


  $(".lot_id").chosen({
    allow_single_deselect : true
  });


});

function load_task(id,viewlotid,new_subcatview)
{
  var lot_id=$('#lot_id'+viewlotid).val();
  if(id!=""){
  $('#tasklist'+viewlotid+new_subcatview).delay(1).fadeIn(600);
   document.getElementById("tasklist"+viewlotid+new_subcatview).innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
   $( "#tasklist"+viewlotid+new_subcatview).load( "<?=base_url()?>hm/hm_subcontract/get_task_list/"+id+"/"+viewlotid+"/"+new_subcatview+"/"+lot_id);

 }
 else
 {
   $('#subcatlist').delay(1).fadeOut(600);

 }
}
</script>
</hr>
<div class="widget-shadow" data-example-id="basic-forms" style="min-height:150px">
  <div class="form-title">
    <h4><?=$new_lotview?></h4>
  </div>
<label class=" control-label col-sm-3 " >Block Number</label>
<div class="col-sm-3 ">
  <select class="form-control lot_id" placeholder="Block Number"  id="lot_id<?=$new_lotview?>" name="lot_id<?=$new_lotview?>" onchange="load_sub_cat(this.value,<?=$new_lotview?>,1)"   required >
    <option value="">Block Number</option>
    <? foreach ($lotlist as $raw){?>

      <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
    <? }?>


  </select>
  <input type="hidden" id="subcatviewcount<?=$new_lotview?>" name="subcatviewcount<?=$new_lotview?>" value="0">

</div>
<div class="col-sm-2 ">
  <a href="javascript:load_sub_cat('','<?=$new_lotview?>','2')" title="Add New Category"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
  Add More Task
</div>
<div class="row" id="lotsubcatlist<?=$new_lotview?>">

  <!-- load sub cat list-->

</div>


</div>
