<h4>Details of <?php echo $details['allowance']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_allowance">
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>Allowance</label>
              <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
              <input type="text" class="form-control" value="<?php echo $details['allowance']; ?>" name="allowance" id="allowance" placeholder="Allowance" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Amount Type</label>
			  <select class="form-control" id="amount_type" name="amount_type" required>
			    <option value="">--Select Amount Type--</option>
				<option value="AMOUNT" <?php if($details['amount_type'] == 'AMOUNT'){ echo "selected";} ?>>Amount</option>
				<option value="PRECENTAGE" <?php if($details['amount_type'] == 'PRECENTAGE'){ echo "selected";} ?>>Precentage</option>
			  </select>
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
	  
	  <div class="col-md-6 validation-grids validation-grids-left">
		<div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
			  <label>Tax Applicable</label>
			  <select class="form-control" id="tax_applicable" name="tax_applicable" required>
			    <option value="">--Select Applicability--</option>
				<option value="Yes" <?php if($details['tax_applicable'] == 'Yes'){ echo "selected";} ?>>Yes</option>
				<option value="No" <?php if($details['tax_applicable'] == 'No'){ echo "selected";} ?>>No</option>
			  </select>
			  <span class="help-block with-errors" ></span>
			</div>
			<div class="form-group has-feedback">
			  <label>Tax Free Amount</label>
			  <input type="number" class="form-control" name="tax_free_amount" id="tax_free_amount" value="<?php echo $details['tax_free_amount']; ?>" placeholder="Tax Free Amount">
			  <span class="help-block with-errors" ></span>
			</div>
		  </div>
		</div>
	  </div>
	</form>
  </div>
</div>