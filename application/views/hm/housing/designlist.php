<script type="text/javascript">

jQuery(document).ready(function() {

	$("#design_id").chosen({
      	allow_single_deselect : true,
	  	search_contains: true,
	 	no_results_text: "Oops, nothing found!",
	 	placeholder_text_single: "Select Design"
    });
	
 	<? if($current_design){?>
		load_tasklist('<?=$current_design->design_id?>');
		$('#myform').attr('action', "<?=base_url()?>hm/hm_housing/update/<?=$current_design->lot_id?>");
	<? }?>
 
});
</script>
<? if ($datalist) {?>
	<select class="form-control" placeholder="Design Name"  id="design_id" name="design_id" onchange="load_tasklist(this.value)"   required >
         <option value=""></option>
         <? foreach ($datalist as $raw){ ?>
          	<option <? if($current_design)if($raw->design_id == $current_design->design_id){ ?> selected="selected" <? }?> value="<?=$raw->design_id?>" ><?=$raw->short_code?> - <?=$raw->design_name?></option>
         <? } ?>
     </select> 
<?  }else {
	echo 'No Designs Found';
}?>							