
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#lot_id2").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="lot_id2" name="lot_id2" onchange="load_housedetails(this.value)"   required >
                    <option value="">Block Number</option>
                    <? foreach ($lotlist as $raw){ if($raw->price_perch>0){?>
						
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_no?> - <?=$raw->lot_number?></option>
                    <? }}?>
              
					
					</select> 
									