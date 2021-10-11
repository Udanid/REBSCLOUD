
<script type="text/javascript">

jQuery(document).ready(function() {
  

	$("#prj_id_<?=$tag?><?=$counter?>").chosen({
     allow_single_deselect : true
    });
 
 
	
});
</script> <div><div class=" emp_rows col-xs-12"> <br />
<? $divname='tasklist1'.$tag.$counter;
$divname2='subtasklist1'.$tag.$counter;?>
<div class="alert alert-danger" style="display:none" role="alert" id="blockerror<?=$tag?><?=$counter?>"></div>
                                  <div class="col-md-3">  <select class="form-control" placeholder="Block Number"  id="prj_id_<?=$tag?><?=$counter?>" name="prj_id_<?=$tag?><?=$counter?>" onchange="load_tasklist(this.value,'<?=$counter?>','<?=$tag?>')"   required >
                    <option value="">Project Name</option>
                    <? foreach ($prjlist as $raw){?>
						
                    <option value="<?=$raw->prj_id?>" ><?=$raw->project_name?> </option>
                    <? }?>
              
					
					</select></div> <div  class="col-md-3" id="<?=$divname?>"><input type="text" name="task" class="form-control" /></div>
                    <div  class="col-md-3" id="<?=$divname2?>"><input type="text" name="subtask" class="form-control"  placeholder="Sub task"/></div>
                   <div class="clearfix"> </div><br />
                    <div class="col-md-3"><input type="text" name="available_<?=$tag?><?=$counter?>" id="available_<?=$tag?><?=$counter?>"  value="" class="form-control" readonly="readonly" placeholder="Available Budget" />
                    <input type="hidden" name="val_available_<?=$tag?><?=$counter?>" id="val_available_<?=$tag?><?=$counter?>"  value="<?=$counter?>" class="form-control"  /></div>
                     <div class= " <?=$tag?><?=$counter?> form-group col-md-3 has-feedback"><input type="text"  name="amount_<?=$tag?><?=$counter?>" id="amount_<?=$tag?><?=$counter?>"  value="" class="form-control number-separator" placeholder="Current Payment" required="required"  onblur="validation()"/><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                     </div> 
                     <div class="col-md-4"><input type="text"  name="dis_<?=$tag?><?=$counter?>" id="dis_<?=$tag?><?=$counter?>"  value="" class="form-control" placeholder="Description" onchange="set_narration(this.value)" />
                     </div><div id="rawremove<?=$tag?><?=$counter?>"> <a href="#" class="remove_field btn btn-danger">-</a></div></div>
                     
                     </div>
                     <div class="clearfix"> </div>
									