
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#searchpanel_lot_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="searchpanel_lot_id" name="searchpanel_lot_id" required >
                    <option value="">Block Number</option>
                    <? foreach ($searchpanel_lotlist as $raw){?>
						
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
                    <? }?>
              
					
					</select> 
									