<h4>Details of Divison Head<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_division_head">
      <input type="hidden" name="id" value="<?php echo $details['id']; ?>" id="id" />
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
	    
		    <div class="form-group has-feedback">
              <label>Select Branch</label>
			  <select class="form-control" id="branch_id" name="branch_id" disabled required>
			    <option value="">--Select Branch--</option>
			    <?php
				foreach($branch_list as $branch){ ?>
					<option value="<?php echo $branch->branch_code; ?>" <?php if($branch->branch_code == $details['branch_id']){ echo "selected"; } ?> ><?php echo $branch->branch_name; ?></option>
				<?php
				} ?>
			  </select>
			  <span class="help-block with-errors"></span>
			</div>
	    
		    <div class="form-group has-feedback">
              <label>Select Division</label>
			  <select class="form-control" id="division_id" name="division_id" disabled required>
			    <option value="">--Select Division--</option>
				<?php
				foreach($division_list as $division){ ?>
					<option value="<?php echo $division->id; ?>" <?php if($division->id == $details['division_id']){ echo "selected"; } ?> ><?php echo $division->division_name; ?></option>
				<?php
				} ?>
			  </select>
			  <span class="help-block with-errors"></span>
			</div>
	    
		    <div class="form-group has-feedback">
              <label>Select Employee</label>
			  <select class="form-control" id="division_head_emp_record_id" name="division_head_emp_record_id" required>
			    <option value="">--Select Employee--</option>
				<?php
				foreach($employee_list as $employee_list_row){
					if($employee_list_row->status == "A" && $employee_list_row->branch == $details['branch_id']){ ?>
						<option value="<?php echo $employee_list_row->id; ?>" <?php if($employee_list_row->id == $details['division_head_emp_record_id']){ echo "selected"; } ?> ><?php echo $employee_list_row->emp_no.' - '.$employee_list_row->surname; ?></option>
					<?php
					}
				} ?>
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
	</form>
  </div>
</div>