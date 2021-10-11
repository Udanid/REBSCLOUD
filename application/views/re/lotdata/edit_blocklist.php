
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#lot_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="lot_id" name="lot_id" onchange="load_fulldetails(this.value)"   required >
                    <option value="">Block Number</option>
                    <? foreach ($lotlist as $raw){
						if($raw->status=='RESERVED'){?>
						
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
                    <? }}?>
              
					
					</select> 
									