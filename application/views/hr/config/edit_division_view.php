<div id="messageBoard">
  <?php
  if($this->session->flashdata('msg') != ''){ ?>
    <div class="alert alert-success  fade in">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <?php echo $this->session->flashdata('msg'); ?>
    </div>
  <?php
  } ?>
</div>
<h4>Details of <?php echo $details['division_name']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_division">
      <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms">
		  <div class="form-body">
		    <div class="form-group has-feedback">
              <label>Division</label>
              <input type="text" class="form-control" value="<?php echo $details['division_name']; ?>" name="division_name" id="division_name" placeholder="Division" required>
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
