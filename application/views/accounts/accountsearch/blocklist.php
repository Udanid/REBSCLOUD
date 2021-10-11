
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#lot").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="lot" name="lot"   required >
                    <option value="">Block Number</option>
                    <? foreach ($lotlist as $raw){?>
						
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
                    <? }?>
              
					
					</select> 
									