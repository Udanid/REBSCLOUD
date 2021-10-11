
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#lot_id").chosen({
     	allow_single_deselect : true,
		search_contains: true,
	 	no_results_text: "Oops, nothing found!",
	 	placeholder_text_single: "Block Number"
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="lot_id"  onchange="load_fulldetails(this.value)" name="lot_id"   required >
                    <option value=""></option>
                    <? foreach ($lotlist as $raw){?>
						
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
                    <? }?>
              
					
					</select> 
									