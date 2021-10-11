
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#advance_lot_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                    <select class="form-control" placeholder="Block Number"  id="advance_lot_id" name="advance_lot_id" onchange="advance_fulldata(this.value)"   required >
                    <option value="">Block Number</option>
                    <? foreach ($lotlist as $raw){
                        if(!check_loan_created($raw->lot_id)){//Common Helper
                        ?>
					
                    <option value="<?=$raw->lot_id?>" ><?=$raw->plan_sqid?> - <?=$raw->lot_number?></option>
                    <? }}?>
              
					
					</select> 
									