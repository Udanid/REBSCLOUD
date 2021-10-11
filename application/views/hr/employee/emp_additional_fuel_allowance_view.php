<h4>Additional Fuel Allowance Request<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/employee/confirm_additional_fuel_request">
      <input type="hidden" name="id" id="id" value="<?php echo $details['id']; ?>" />
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>Requested Amount</label>
              <input type="number" class="form-control" value="<?php echo $details['requested_amount']; ?>" name="requested_amount" id="requested_amount" placeholder="Amount" readonly>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Approved Amount</label>
              <input type="number" class="form-control" value="" name="approved_amount" id="approved_amount" placeholder="Approved Amount" required>
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