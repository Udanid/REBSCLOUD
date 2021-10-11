<script type="text/javascript">
	$(document).ready(function() {
		$("#employee").chosen({
     		allow_single_deselect : true
    	});
	});
</script>

<select class="form-control" id="employee" name="employee">
  <option value="all">All Employee</option>
  <?php 
  foreach($branch_employee_list as $raw){ ?>
  	<option value="<?php echo $raw->id; ?>" ><?php echo $raw->epf_no.' - '.$raw->initial.' '.$raw->surname; ?></option>
  <?php
  } ?>
</select>							