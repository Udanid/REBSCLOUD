
<script type="text/javascript">
jQuery(document).ready(function() {
  $("#subtask_id_<?=$tag?><?=$counter?>").focus(function() {

	$("#subtask_id_<?=$tag?><?=$counter?>").chosen({
     allow_single_deselect : true
    });
 
 });
	
});</script>
                                    <select class="form-control" placeholder="Subtask"  id="subtask_id_<?=$tag?><?=$counter?>" name="subtask_id_<?=$tag?><?=$counter?>"  <? if($tasklist){?>   required <? }?>>
                    <option value="">Sub Task</option>
                    <? foreach ($tasklist as $raw){?>
                    <option value="<?=$raw->subtask_id?>,<?=$raw->budget?>" ><?=$raw->subtask_name?></option>
                    <? }?>
              
					
					</select> 
									