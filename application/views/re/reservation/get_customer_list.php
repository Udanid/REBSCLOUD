
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#cus_code2").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script>
                                <div class="col-sm-3 ">    <select class="form-control" placeholder="Block Number"  id="cus_code2" name="cus_code2"  required >
                    <option value="">Customer Number</option>
                    <? foreach ($cuslist as $raw){ ?>
						
                    <option value="<?=$raw->cus_code?>"  <? if($rescode->cus_code2==$raw->cus_code){?> selected="selected"<? }?>><?=$raw->first_name?>  <?=$raw->last_name?> <?=$raw->id_number?></option>
                    <? }?>
              
					
					</select> </div><div class="col-sm-3 ">   <button type="submit" class="btn btn-primary disabled" >Update</button>
									