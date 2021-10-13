
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#res_code").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="res_code" name="res_code"   required >
                    <option value="ALL">Block Number</option>
                    <? foreach ($reslist as $raw){?>
						
                    <option value="<?=$raw->res_code?>" ><?=$raw->project_name?> - <?=$raw->lot_number?> <?=$raw->first_name?> <?=$raw->last_name?></option>
                    <? }?>
              
					
					</select> 
									