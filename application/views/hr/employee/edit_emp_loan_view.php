<script>
	$(document).ready(function(){
	var loan_status = '<?php echo $details['status']; ?>';
	if(loan_status == 'Y'){
		$('#edit_form').find('input, textarea, button, select').attr('disabled','disabled');
	}
		
  		$("#internal_loan_start_date").datepicker({
      		dateFormat: 'dd-MM-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-50' + ':' + '+1'
  		});
  		$("#external_loan_start_date").datepicker({
      		dateFormat: 'dd-MM-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-50' + ':' + '+1'
  		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
	});
</script>

<script>
	function load_edit_employment_details(emp_id){
		var siteUrl = '<?php echo base_url(); ?>';
		
		if(emp_id != ''){
			$.ajax({
				cache: false,
				url: siteUrl + 'hr/employee/get_employee_details',
				type: "POST",
				async: false,
				dataType: 'json',
				data: {emp_id:emp_id},
				success: function(data) {
					$("#surname").val(data.employee_details.initial+' '+data.employee_details.surname);
					$("#nic_no").val(data.employee_details.nic_no);
					var siteUrl = '<?php echo base_url(); ?>';
					$.ajax({
						cache: false,
						url: siteUrl + 'hr/employee/get_employement_details',
						type: "POST",
						async: false,
						dataType: 'json',
						data: { branch:data.employee_details.branch, division:data.employee_details.division, designation:data.employee_details.designation, employment_type:data.employee_details.employment_type},
						success: function(data) {
							$("#branch").val(data.branch.branch_name);
							$("#division").val(data.division.division_name);
							$("#designation").val(data.designation.designation);
							$("#employment_type").val(data.employment_type.employment_type);
						},
						error: function(e) {
							console.log(e.responseText);
						}
					});
				},
				error: function(e) {
					console.log(e.responseText);
				}
			});
		}else{
			$("#surname").val('');
			$("#nic_no").val('');
			$("#branch").val('');
			$("#division").val('');
			$("#designation").val('');
			$("#employment_type").val('');
		}
	}
	
	function load_edit_loan_type(loan_type){
		var siteUrl = '<?php echo base_url(); ?>';
		
		if(loan_type != ''){
			if(loan_type == 'internal_loan'){
				$("#external_loan_div").hide();
				$("#internal_loan_div").show();
			}else if(loan_type == 'external_loan'){
				$("#internal_loan_div").hide();
				$("#external_loan_div").show();
			}else if(loan_type == ''){
				$("#internal_loan_div").hide();
				$("#external_loan_div").hide();
			}
		}
	}
	
	function calculate_monthly_deduction(instalments){
		var internal_loan_amount = $('#internal_loan_amount').val();
		var monthly_deduction_amount = internal_loan_amount/instalments;
		$("#internal_monthly_deduction_amount").val(monthly_deduction_amount);
		
	}
	
	function reset_monthly_deduction(){
		$("#internal_monthly_deduction_amount").val("");
		$("#internal_instalments").val("");
	}
	
	function loadbranchlist(itemcode){ 
		var code = itemcode.split("-")[0];
		if(code != ''){
			$("#bank_branch_load").load("<?php echo base_url();?>hr/hr_common/get_bank_branchlist/"+itemcode);
		}
	}
	
</script>
<script>
	$(document).ready(function(){
		
		var emp_record_id = '<?php echo $details['emp_record_id']; ?>';
		load_edit_employment_details(emp_record_id);
		
		var loan_type = '<?php echo $details['loan_type']; ?>';
		load_edit_loan_type(loan_type);
		
		$("form#edit_form").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				cache: false,
				url: siteUrl + 'hr/employee/employee_loan_update',
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {
	                if($.isEmptyObject(data.error)){
	                	location.reload();
	                }else{
						edit_unsuccessfulAttemptAction(data.error);
						$('html, body').animate({scrollTop: '0px'}, 300);
						$('html, body').animate({
							scrollTop: ($('#edit_form').first().offset().top)
						},500);
	                }
				},
				error: function(e) {
					console.log(e.responseText);
				}
			});
		});
		
		function edit_unsuccessfulAttemptAction(errors){
    		$('html, body').animate({scrollTop: '0px'}, 300);//scroll to the top
    		var messageBoardDIV = $('#messageBoard');
    		//empty child elements if exist
			messageBoardDIV.empty();

    		//append error message to the "messageBoard" block
    		$(messageBoardDIV).append('<div class="alert alert-danger  fade in">\
            	<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
            		<span aria-hidden="true">&times;</span>\
                </button>\
                <strong>Please correct the following error(s)!</strong>\
                '+errors+'\
            </div>');
  		}
		
	  	function edit_successfulAttemptAction(successMsg){
    		$('html, body').animate({scrollTop: '0px'}, 300);//scroll to the top
    		var messageBoardDIV = $('#messageBoard');
			messageBoardDIV.empty();

			//append error message to the "messageBoard" block
			$(messageBoardDIV).append('<div class="alert alert-success fade in">\
				<strong>Success!</strong>\
				<div class="row">'+successMsg+'</div>\
				<div class="row">\
					<button type="button" id="close-btn" class="btn btn-primary">Done</button>\
				</div>\
			</div>');
	  	}
		
	});
</script>


<h4>Loan Details<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <form data-toggle="validator" id="edit_form" name="edit_form" method="post">
      <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $details['emp_record_id']; ?>" />
      <input type="hidden" name="loan_type" id="loan_type" value="<?php echo $details['loan_type']; ?>" />
      <input type="hidden" name="loan_form_submit_type" id="loan_form_submit_type" value="update" />
      <input type="hidden" name="loan_record_id" id="loan_record_id" value="<?php echo $details['id']; ?>" />
				
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
            <div class="form-group" id="surname_div">
              <label for="surname" class="control-label">Name</label>
              <input type="text" class="form-control" id="surname" name="surname" value="" placeholder="Name" readonly>
            </div>
				  
            <div class="form-group" id="branch_div">
              <label for="branch" class="control-label">Branch</label>
              <input type="text" class="form-control" id="branch" name="branch" value="" placeholder="Branch" readonly>
            </div>
				  
            <div class="form-group" id="designation_div">
              <label for="designation" class="control-label">Designation</label>
              <input type="text" class="form-control" id="designation" name="designation" value="" placeholder="Designation" readonly>
            </div>
          </div>
        </div>
	  </div>
				
	  <div class="col-md-6 validation-grids validation-grids-left">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
            <div class="form-group" id="nic_no_div">
              <label for="nic_no" class="control-label">NIC</label>
              <input type="text" class="form-control" id="nic_no" name="nic_no" value="" placeholder="NIC" readonly>
            </div>
				  
            <div class="form-group" id="division_div">
              <label for="division" class="control-label">Division</label>
              <input type="text" class="form-control" id="division" name="division" value="" placeholder="Division" readonly>
            </div>
				  
            <div class="form-group" id="employment_type_div">
              <label for="employment_type" class="control-label">Employment Type</label>
              <input type="text" class="form-control" id="employment_type" name="employment_type" value="" placeholder="Employment Type" readonly>
            </div>
		  </div>
        </div>
	  </div>
			  
	  <div class="col-xs-12"><hr></div>
              
	  <div id="internal_loan_div" style="display: none;">
	    <div class="col-md-6 validation-grids validation-grids-right">
	      <div class="" data-example-id="basic-forms"> 
		    <div class="form-body">
              <div class="form-group">
                <label for="internal_loan_id" class="control-label">Select Loan</label>
                <select class="form-control" id="internal_loan_id" name="internal_loan_id" onChange=" (this.value);">
				  <option value="">--Select Loan--</option>
                  <?php
                  foreach($internal_loans as $internal_loan_row){ ?>
				  	<option value="<?php echo $internal_loan_row->id; ?>" <?php if($details['loan_id'] == $internal_loan_row->id){ echo "selected"; } ?>><?php echo $internal_loan_row->loan; ?></option>
				  <?php
                  } ?>
                </select>
              </div>
              
              <div class="form-group">
                <label for="internal_instalments" class="control-label">Instalments</label>
                <input type="number" onchange="calculate_monthly_deduction(this.value);" class="form-control" id="internal_instalments" name="internal_instalments" value="<?php echo $details['instalments']; ?>" placeholder="Instalments" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
              </div>
              
		      <div class="form-group">
			    <label for="internal_loan_start_date" class="control-label">Start Date</label>
			    <input type="text" class="form-control" id="internal_loan_start_date" name="internal_loan_start_date" value="<?php echo $details['start_date']; ?>" placeholder="DD/MM/YYYY" readonly/>
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
			</div>
		  </div>
		</div>
			    
	    <div class="col-md-6 validation-grids validation-grids-left">
	      <div class="" data-example-id="basic-forms"> 
		    <div class="form-body">
              <div class="form-group">
                <label for="internal_loan_amount" class="control-label">Loan Amount</label>
                <input type="number" onchange="reset_monthly_deduction();" class="form-control" id="internal_loan_amount" name="internal_loan_amount" value="<?php echo $details['loan_amount']; ?>" placeholder="Loan Amount" min="0">
              </div>
              
              <div class="form-group">
                <label for="internal_monthly_deduction_amount" class="control-label">Monthly Deduction Amount</label>
                <input type="number" class="form-control" id="internal_monthly_deduction_amount" name="internal_monthly_deduction_amount" value="<?php echo $details['monthly_deduction_amount']; ?>" placeholder="Monthly Deduction Amount" readonly>
              </div>
			</div>
          </div>
		</div>
	
		<div class="col-xs-12"><hr></div>	
	  </div>
             
	  <div id="external_loan_div" style="display: none;">
	    <div class="col-md-6 validation-grids validation-grids-right">
	      <div class="" data-example-id="basic-forms"> 
		    <div class="form-body">
              <div class="form-group">
                <label for="external_monthly_deduction_amount" class="control-label">Monthly Deduction Amount</label>
                <input type="number" class="form-control" id="external_monthly_deduction_amount" name="external_monthly_deduction_amount" value="<?php echo $details['monthly_deduction_amount']; ?>" placeholder="Monthly Deduction Amount" min="0">
              </div>
              
			  <div class="form-group">
			    <label for="external_loan_start_date" class="control-label">Start Date</label>
				<input type="text" class="form-control" id="external_loan_start_date" name="external_loan_start_date" value="<?php echo $details['start_date']; ?>" placeholder="DD/MM/YYYY" readonly/>
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
			</div>
		  </div>
		</div>
			    
	    <div class="col-md-6 validation-grids validation-grids-left">
	      <div class="" data-example-id="basic-forms"> 
		    <div class="form-body">
              <div class="form-group">
                <label for="external_instalments" class="control-label">Instalments</label>
                <input type="number" class="form-control" id="external_instalments" name="external_instalments" value="<?php echo $details['instalments']; ?>" placeholder="Instalments" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
              </div>
            </div>
          </div>
		</div>
			  	
	    <div class="col-xs-12"></div>
			  	
	    <div class="col-md-6 validation-grids validation-grids-right">
	      <div class="" data-example-id="basic-forms"> 
		    <div class="form-body">
		      <div class="form-group">
			    <label for="bank_code" class="control-label">Bank name</label>
				<select class="form-control" id="bank_code" name="bank_code" onChange="loadbranchlist(this.value); document.getElementById('bank_name').value=this.options[this.selectedIndex].text;">
				  <option value="">Bank</option>
				  <?php
				  foreach($bank_list as $bank_list_row){ ?>
				  	<option value=<?php echo $bank_list_row->BANKCODE; ?> <?php if($details['bank_code'] == $bank_list_row->BANKCODE){ echo "selected"; } ?> ><?php echo $bank_list_row->BANKNAME; ?></option>
				  <?php
				  } ?>
				</select>
				<input type="hidden" name="bank_name" id="bank_name" value="<?php echo $details['bank_name']; ?>" />
		      </div>
		      
			  <div class="form-group">
			    <label for="account_no" class="control-label">Account No.</label>
				<input type="text" class="form-control" id="account_no" name="account_no" value="<?php echo $details['account_no']; ?>" placeholder="Account #">
			  </div>
			</div>
		  </div>
		</div>
			  	
	    <div class="col-md-6 validation-grids validation-grids-left">
	      <div class="" data-example-id="basic-forms"> 
		    <div class="form-body">
		      <div class="form-group">
			    <label for="branch_name" class="control-label">Branch</label>
				<div id="bank_branch_load">
				  <select name="bank_branch" id="bank_branch" class="form-control" placeholder="Bank" onclick="loadbranchlist('<?php echo $details['bank_code']; ?>');">
					<option value="<?php echo $details['branch_id']; ?>" selected><?php echo $details['branch_name']; ?></option>
			      </select>
				  <input type="hidden" name="bank_branch_name" id="bank_branch_name" value="<?php echo $details['branch_name']; ?>" />
			    </div>
			  </div>
			  
			  <div class="form-group">
			    <label for="account_type" class="control-label">Account type</label>
			    <input type="text" class="form-control" id="account_type" name="account_type" value="<?php echo $details['account_type']; ?>" placeholder="Account type">
			  </div>
			</div>
		  </div>
		</div>

		<div class="col-xs-12"><hr></div>
	  </div>

      <div class="col-md-6 validation-grids validation-grids-right">
        <div class="form-group">
           <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>