<script type="text/javascript">
	$(document).ready(function() {
		$("#bank_branch").chosen({
     		allow_single_deselect : true
    	});
	});
</script>

<select class="form-control" placeholder="Document Category" id="bank_branch" name="bank_branch" onChange="document.getElementById('bank_branch_name').value=this.options[this.selectedIndex].text;">
  <option value="">Branch List</option>
  <?php  $bankcode=''; $branchcode='';
  if($bank_details)
  {
  $bankcode=$bank_details['bank_code'];
  $branchcode=$bank_details['branch_code'];
  }
  foreach($branch_list as $raw){ ?>
  	<option value="<?php echo $raw->BRANCHCODE; ?>" <?php if($raw->BANKCODE == $bankcode && $raw->BRANCHCODE ==$branchcode ){ echo 'selected="selected"';} ?> ><?php echo $raw->BRANCHNAME; ?></option>
  <?php
  } ?>
</select>
<input type="hidden" name="bank_branch_name" id="bank_branch_name" value="" />								