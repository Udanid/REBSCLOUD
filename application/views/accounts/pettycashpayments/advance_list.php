
<script type="text/javascript">
jQuery(document).ready(function() {
  

	$("#adv_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});</script>

                                 <label class=" control-label col-sm-3 " >Cash Advance</label>   
                                  <div class="col-sm-3 "><select class="form-control" placeholder="Document Category"  id="adv_id" name="adv_id" >
                    <option value="">Select Advance</option>
                    <? foreach ($advancelist as $raw){
					
							?>
                    <option value="<?=$raw->adv_id?>" > <?=$raw->serial_number?> - <?=$raw->initial?> <?=$raw->surname?></option>
                    <? }?>
              
					
					</select> </div>
									