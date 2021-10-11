<h4>Mark Duty Out - Unflag User<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $emp_duty_out_flagged_details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div class="row">
    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/employee/update_emp_unflag">
      <input type="hidden" name="id" value="<?php echo $emp_duty_out_flagged_details['id']; ?>" id="id" />
      <input type="hidden" name="attendance_id" id="attendance_id" value="<?php echo $emp_duty_out_flagged_details['attendance_id']; ?>"  />
	  <div class="col-md-6">
		<div class="form-body">
		  <div class="form-group">
            <div class="col-md-3">
              <label>Hour</label>
              <input type="number" class="form-control" value="" name="hour" id="hour" max="12" placeholder="Hour" required>
			</div>
            <div class="col-md-3">
              <label>Minutes</label>
              <input type="number" class="form-control" value="" name="minutes" id="minutes" max="60" placeholder="Minutes" required>
			</div>
            <div class="col-md-3">
             <label>AM/PM</label>
              <select class="form-control" name="am_pm" id="am_pm" required>
                <option value="AM">AM</option>
                <option value="PM">PM</option>
              </select>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-body">
	      <br>
		  <div class="bottom">
			<div class="form-group">
			  <button type="submit" class="btn btn-primary ">Unflag</button>
			</div>
		   <div class="clearfix"> </div>
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