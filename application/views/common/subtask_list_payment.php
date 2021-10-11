
<script type="text/javascript">
jQuery(document).ready(function() {
  $("#subtask_id").focus(function() {

	$("#subtask_id").chosen({
     allow_single_deselect : true
    });
 
 });
	
});</script>
                                    <select class="form-control" placeholder="Document Category"  id="subtask_id" name="subtask_id" onchange="load_amount(this.value)" <? if($tasklist){?>   required <? }?>>
                    <option value="">Sub Task</option>
                    <? foreach ($tasklist as $raw){?>
                    <option value="<?=$raw->subtask_id?>,'0'" ><?=$raw->subtask_name?></option>
                    <? }?>
              
					
					</select> 
									