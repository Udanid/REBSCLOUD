<h4>Details of <?php echo $details['leave_category_name']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_leave_category">
      <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>Leave Category Name</label>
              <input type="text" class="form-control" value="<?php echo $details['leave_category_name']; ?>" name="leave_category_name" id="leave_category_name" placeholder="Leave Category Name" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Annual Leave</label>
              <input type="number" class="form-control" value="<?php echo $details['annual_leave']; ?>" name="annual_leave" id="annual_leave" placeholder="Annual Leave" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Cassual Leave</label>
              <input type="number" class="form-control" value="<?php echo $details['cassual_leave']; ?>" name="cassual_leave" id="cassual_leave" placeholder="Cassual Leave" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Sick Leave</label>
              <input type="number" class="form-control" value="<?php echo $details['sick_leave']; ?>" name="sick_leave" id="sick_leave" placeholder="Sick Leave" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Maternity Leave</label>
              <input type="number" class="form-control" value="<?php echo $details['maternity_leave']; ?>" name="maternity_leave" id="maternity_leave" placeholder="Maternity Leave" required>
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