<h4>Details of <?php echo $details['deduction']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_deduction">
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>Deduction</label>
              <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
              <input type="text" class="form-control" value="<?php echo $details['deduction']; ?>" name="deduction" id="deduction" placeholder="Deduction" required>
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
		    <div class="form-group has-feedback">
              <label>Value</label>
              <input type="number" class="form-control" value="<?php echo $details['value']; ?>" name="value" id="value" placeholder="Value" required>
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
	 document.getElementById('amount_type').onchange = (function(){
		if(this.value=="PRECENTAGE"){
			$("#value").val("");
			document.getElementById('value').max=999;
		}else{
			$("#value").val("");
		 	document.getElementById('value').removeAttribute('max');
		}
	});
</script>