
<script type="text/javascript">
jQuery(document).ready(function() {
  

	$("#to_task_id").chosen({
     allow_single_deselect : true
    });
 
 
	
});</script>
                                    <select class="form-control" placeholder="Document Category"  id="to_task_id" name="to_task_id"  required >
                    <option value="">Task</option>
                    <? foreach ($tasklist as $raw){
						$balance=$raw->new_budget-$raw->tot_payments;
						if($balance <= get_rate('Fund Transfer Limit')){
							$pendingamount=$raw->new_budget-$raw->tot_payments;
							?>
                    <option value="<?=$raw->task_id?>" ><?=$raw->task_name?></option>
                    <? }}?>
              
					
					</select> 
									