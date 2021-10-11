<h4>Details of <?php echo $details['type']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_epf_etf">
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label><?php echo $details['type']; ?></label>
              <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
              <input type="text" class="form-control" value="<?php echo $details['type']; ?>" name="type" id="type" placeholder="EPF/ETF" readonly>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Employee Contribution</label>
              <input type="number" class="form-control" value="<?php echo $details['employee_contribution']; ?>" name="employee_contribution" id="employee_contribution" placeholder="Employee Contribution" max="100" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Employer Contribution</label>
              <input type="number" class="form-control" value="<?php echo $details['employer_contribution']; ?>" name="employer_contribution" id="employer_contribution" placeholder="Employer Contribution" max="100" required>
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