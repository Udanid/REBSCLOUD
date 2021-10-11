<h4>Details of paye category<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_paye">
      <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>From Amount</label>
              <input type="number" class="form-control" value="<?php echo $details['from_amount']; ?>" name="from_amount" id="from_amount" placeholder="From Amount" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>To Amount</label>
              <input type="number" class="form-control" value="<?php echo $details['to_amount']; ?>" name="to_amount" id="to_amount" placeholder="To Amount" required>
			  <span class="help-block with-errors"></span>
			</div>
		    <div class="form-group has-feedback">
              <label>Tax Amount</label>
              <input type="number" class="form-control" value="<?php echo $details['tax']; ?>" name="tax" id="tax" placeholder="Tax Amount" required>
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