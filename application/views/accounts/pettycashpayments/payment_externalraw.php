
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#ledgerid_<?=$tag?><?=$counter?>").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script> <div><div class=" emp_rows col-xs-12"> 
<div class="alert alert-danger" style="display:none" role="alert" id="blockerror<?=$tag?><?=$counter?>"></div>
<? $divname='tasklist1'.$tag.$counter;
$divname2='subtasklist1'.$tag.$counter;?>
                                  <div class="col-md-3">  <select class="form-control" placeholder="Block Number"  id="ledgerid_<?=$tag?><?=$counter?>" name="ledgerid_<?=$tag?><?=$counter?>"    required >
                                  <option value=""> Select Ledger Account</option>
                     <? if($ledgerlist){
							 foreach($ledgerlist as $dataraw)
							 {
								
							 ?>
                        <option value="<?=$dataraw->id?>" > <?=$dataraw->id?> - <?=$dataraw->name?> </option>
              
						<? }}?>
					</select></div> 
                   
                     <div class= " <?=$tag?><?=$counter?> form-group col-md-3 has-feedback"><input type="text"  name="amount_<?=$tag?><?=$counter?>" id="amount_<?=$tag?><?=$counter?>"  value="" class="form-control number-separator" placeholder="Current Payment" onblur="validation()" required="required" /><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                     </div> 
                     <div class="col-md-4"><input type="text"  name="dis_<?=$tag?><?=$counter?>" id="dis_<?=$tag?><?=$counter?>"  value="" class="form-control" placeholder="Description" onchange="set_narration(this.value)" />
                     </div><div id="rawremove<?=$tag?><?=$counter?>"> <a href="#" class="remove_field btn btn-danger">-</a></div></div>
                     
                     </div>
                     <div class="clearfix"> </div>
									