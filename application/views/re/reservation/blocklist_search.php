
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#lot_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="lot_id" name="lot_id" >
                    <option value="">Block Number</option>
                    <? foreach ($lotlist as $raw){ ?>
						
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_no?> - <?=$raw->lot_number?></option>
                    <? }?>
              
					
					</select> 
									