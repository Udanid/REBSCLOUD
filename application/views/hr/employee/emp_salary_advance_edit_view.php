<h4>Edit Salary Advance Amount<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $salary_advance_details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/employee/update_emp_salary_advance_amount">
      <input type="hidden" name="id" value="<?php echo $salary_advance_details['id']; ?>" id="id" />
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>Amount</label>
              <input type="text" class="form-control" value="<?php echo $salary_advance_details['salary_advance_amount']; ?>" name="salary_advance_amount" id="salary_advance_amount" placeholder="Amount" required>
			  <span class="help-block with-errors"></span>
			</div>
			<div class="bottom">
			  <div class="form-group">
			    <button type="submit" class="btn btn-primary ">Submit</button>
			  </div>
			  <div class="clearfix"> </div>
			</div>
		  </div>
		</div>
	  </div>
	</form>
  </div>
</div>


<script>
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	
</script>