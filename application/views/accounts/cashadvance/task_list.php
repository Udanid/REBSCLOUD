
<script type="text/javascript">
jQuery(document).ready(function() {
  

	$("#task_id1").chosen({
     allow_single_deselect : true
    });
	$("#task_id2").chosen({
     allow_single_deselect : true
    });
	$("#task_id3").chosen({
     allow_single_deselect : true
    });
	
 
 
	
});</script>  <table  class="table" width="80%"><tr><th>Task</th><th>Amount</th></tr>
                    <tr ><td>
                                    <select class="form-control" placeholder="Document Category"  id="task_id1" name="task_id1"  onchange="load_subtasklist(this.value)"  required >
                    <option value="">Task</option>
                    <? foreach ($tasklist as $raw){
						if($raw->new_budget > $raw->tot_payments){
							$pendingamount=$raw->new_budget-$raw->tot_payments;
							?>
                    <option value="<?=$raw->task_id?>,<?=$pendingamount?>,<?=$raw->new_budget?>" ><?=$raw->task_name?></option>
                    <? }}?>
              
					
					</select></td><td><input  type="text" class="form-control" id="task_amount1"    name="task_amount1"  value=""   data-error=""   placeholder="Advance Number" ></td></tr>
                    
                       <tr><td>
                                    <select class="form-control" placeholder="Document Category"  id="task_id2" name="task_id2"   required >
                    <option value="">Task</option>
                    <? foreach ($tasklist as $raw){
						if($raw->new_budget > $raw->tot_payments){
							$pendingamount=$raw->new_budget-$raw->tot_payments;
							?>
                    <option value="<?=$raw->task_id?>,<?=$pendingamount?>,<?=$raw->new_budget?>" ><?=$raw->task_name?></option>
                    <? }}?>
              
					
					</select></td><td><input  type="text" class="form-control" id="task_amount2"    name="task_amount2"  value=""   data-error="" placeholder="Amount" ></td></tr>
                    
                       <tr><td>
                                    <select class="form-control" placeholder="Document Category"  id="task_id3" name="task_id3"  onchange="load_subtasklist(this.value)"  required >
                    <option value="">Task</option>
                    <? foreach ($tasklist as $raw){
						if($raw->new_budget > $raw->tot_payments){
							$pendingamount=$raw->new_budget-$raw->tot_payments;
							?>
                    <option value="<?=$raw->task_id?>" ><?=$raw->task_name?></option>
                    <? }}?>
              
					
					</select></td><td><input  type="text" class="form-control" id="task_amount3"    name="task_amount3"  value=""   data-error=""   placeholder="Amount" ></td></tr>
                    
                    
                    </table>
									