
<script type="text/javascript">
jQuery(document).ready(function() {


 $("#cat_id").focus(function() {
			$("#cat_id").chosen({
				allow_single_deselect : true
			});
			});


});
</script>
<label class=" control-label col-sm-3 " >Subcategory List</label>
															<div class="row" style="margin-top:5px;">
															<div class="col-sm-3" >

																			

														
  <select class="form-control cat_id" placeholder="Block Number"  id="cat_id" name="cat_id"   required >
    <option value="">Task Category</option>
    <? foreach ($category_data as $raw){?>

      <option value="<?=$raw->boqsubcat_id?>" ><?=$raw->subcat_code?> - <?=$raw->subcat_name?></option>
    <? }?>


  </select>
	</div>
    <div ><button type="submit" id="confirm-but" class="btn btn-primary disabled pull-right" >Add Payment</button>
															</br>