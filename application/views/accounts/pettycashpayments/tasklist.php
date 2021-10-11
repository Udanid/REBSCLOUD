
<script type="text/javascript">
jQuery(document).ready(function() {
  

	$("#task_id_<?=$tag?><?=$counter?>").chosen({
     allow_single_deselect : true
    });
 
 
	
});</script>
                                    <select class="form-control" placeholder="Document Category"  id="task_id_<?=$tag?><?=$counter?>" name="task_id_<?=$tag?><?=$counter?>"  onchange="load_subtasklist(this.value,'<?=$counter?>','<?=$tag?>')"  required >
                    <option value="">Task</option>
                    <? foreach ($tasklist as $raw){
						if($raw->new_budget > $raw->tot_payments){
							$pendingamount=$raw->new_budget-$raw->tot_payments;
							?>
                    <option value="<?=$raw->task_id?>,<?=$pendingamount?>,<?=$raw->new_budget?>" ><?=$raw->task_name?></option>
                    <? }}?>
              
					
					</select> 
									