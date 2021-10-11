<script>
	$(document).ready(function() {

  		//Date of birth picker
  		$("#dobDatepicker").datepicker({
    		minDate: new Date(1900,1-1,1), maxDate: '-18Y',
    		dateFormat: 'dd-MM-yy',
    		defaultDate: new Date(1970,1-1,1),
    		changeMonth: true,
    		changeYear: true,
    		yearRange: '-110:-18'
  		});

  		//datepicker for work experience and higher education
  		$('body').on('focus',".qualificationDatepicker, .weDatepicker", function(){
    		$(this).datepicker({
      			dateFormat: 'dd-MM-yy',
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + new Date().getFullYear()
    		});
  		});

  		$("#emp_joining_date").datepicker({
      		dateFormat: 'dd-MM-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-50' + ':' + '+1'
  		});

		$("#fuel_allowance_status").change(function(){
			var fuel_allowance_status = $('#fuel_allowance_status').val();
			if(fuel_allowance_status == "Y"){
				$("#vehicle_type_div").show();
				$("#initial_meter_reading_div").show();
				$("#fuel_allowance_maximum_limit_div").show();
			}else if(fuel_allowance_status == "N"){
				$("#vehicle_type_div").hide();
				$("#initial_meter_reading_div").hide();
				$("#fuel_allowance_maximum_limit_div").hide();
			}
		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

<script>
	function loadbranchlist(itemcode){
		var code = itemcode.split("-")[0];
		if(code != ''){
			$("#bank_branch_load").load("<?php echo base_url();?>hr/hr_common/get_edit_bank_branchlist/"+itemcode+"/<?php echo $employee_details['id'];?>");
		}
	}
	$(document).ready(function() {
		var bank_itemcode = document.getElementById("bank_code").value;
		loadbranchlist(bank_itemcode);
	});
</script>

<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<div class="row">
		  <!--block which displays the outcome message-->
			<div id="messageBoard">
              <? $this->load->view("includes/flashmessage");?>
				
		   </div>

		  <div class="col-xs-12 form-container">
			<form enctype="multipart/form-data" class="userRegForm form-horizontal" id="inputform" name="inputform" method="post" action="<?=base_url()?>hr/employee/update_otherdatasubmit">
			  <input type="hidden" name="employeeMasterID" id="employeeMasterID" value="<?php echo $employee_details['id']; ?>" />
				<h3 class="title1">Personal Details of <?php echo $employee_details['initial']; ?> <?php echo $employee_details['surname']; ?></h3>

				<div class="form-group">
					<div class="col-xs-10" style="float: right;">
						<a href="<?php echo base_url();?>hr/employee/add_emp_edu_data/<?php echo $employee_details['id'];?>"><button type="button" class="btn btn-danger btn-lg " data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request" style="float: right;">Skip</button></a>
					</div>
				</div>
			  <!--Emergency conatact persons-->
			  <div class="panel panel-default">
				<div class="panel-heading">Emergency Contact</div>
				<div class="panel-body">
<? $person_name='';
	$relationship='';
	$tel_mobile='';
	$tel_home='';
	$add_1='';
	$addr_2='';
	$town='';
	if($emergnecy_contact_details){
	$person_name=$emergnecy_contact_details['person_name'];
	$relationship=$emergnecy_contact_details['relationship'];
	$tel_mobile=$emergnecy_contact_details['tel_mobile'];
	$tel_home=$emergnecy_contact_details['tel_home'];
	$add_1=$emergnecy_contact_details['add_1'];
	$addr_2=$emergnecy_contact_details['addr_2'];
	$town=$emergnecy_contact_details['town'];
	}?>
				  <div class="form-group">
					<label for="name_emg_person" class="control-label col-xs-2">Contact person</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="name_emg_person" name="name_emg_person" value="<?php echo $person_name?>" placeholder="Contact Person Name">
					</div>
				  </div>

				  <div class="form-group">
					<label for="relationship_emg" class="control-label col-xs-2">Relationship</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="relationship_emg" name="relationship_emg" value="<?php echo $relationship ?>" placeholder="Relationship Ex:wife">
					</div>
				  </div>

				  <div class="form-group">
					<label for="contact_mob_emg" class="control-label col-xs-2">Contact No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="contact_mob_emg" name="contact_mob_emg" value="<?php echo $tel_mobile ?>" placeholder="Mobile #">
					</div>

					<div class="col-xs-5">
					  <input type="text" class="form-control" id="contact_tel_emg" name="contact_tel_emg" value="<?php echo $tel_home ?>" placeholder="Telephone #">
					</div>
				  </div>

				  <div class="form-group">
					<label for="addr1_emg" class="control-label col-xs-2">Address</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="addr1_emg" name="addr1_emg" value="<?php echo $add_1 ?>" placeholder="Address line 1">
					</div>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="addr2_emg" name="addr2_emg" value="<?php echo $addr_2; ?>" placeholder="Address line 2 (optional)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="town_emg" class="control-label col-xs-2">Town</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="town_emg" name="town_emg" value="<?php echo $town; ?>" placeholder="Town">
					</div>
				  </div>

				</div>
			  </div>
<? $name_in_account='';
	$bank_code='';
	$account_no='';
	$account_type='';

	if($bank_details){
	$name_in_account=$bank_details['name_in_account'];
	$bank_code=$bank_details['bank_code'];
	$account_no=$bank_details['account_no'];
	$account_type=$bank_details['account_type'];

	}?>
			  <!--Banking information-->
			  <div class="panel panel-default">
				<div class="panel-heading">Banking information</div>
				<div class="panel-body">
				  <div class="form-group">
					<label for="bank_given_name" class="control-label col-xs-2">Given name</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="bank_given_name" name="bank_given_name" value="<?php echo $name_in_account; ?>" placeholder="Name with initials">
					</div>
				  </div>

				  <div class="form-group">
					<label for="bank_code" class="control-label col-xs-2">Bank name</label>
					<div class="col-xs-5">
					  <select class="form-control" id="bank_code" name="bank_code" onChange="loadbranchlist(this.value); document.getElementById('bank_name').value=this.options[this.selectedIndex].text;">
					    <option value="">Bank</option>
						<?php
						foreach($bank_list as $bank_list_row){ ?>
							<option value="<?php echo $bank_list_row->BANKCODE; ?>" <?php if($bank_list_row->BANKCODE == $bank_code){ echo 'selected="selected"';} ?>><?php echo $bank_list_row->BANKNAME; ?></option>
						<?php
						} ?>
					  </select>
					</div>
					<input type="hidden" name="bank_name" id="bank_name" value="" />
				  </div>

				  <div class="form-group">
					<label for="branch_name" class="control-label col-xs-2">Branch</label>
					<div class="col-xs-5" id="bank_branch_load">
					  <select name="bank_branch" id="bank_branch" class="form-control" placeholder="Bank" >
						<option value="">Branch</option>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="account_no" class="control-label col-xs-2">Account No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="account_no" name="account_no" value="<?php echo $account_no; ?>" placeholder="Account #">
					</div>
				  </div>

				  <div class="form-group">
					<label for="account_type" class="control-label col-xs-2">Account type</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="account_type" name="account_type" value="<?php echo $account_type; ?>" placeholder="Account type">
					</div>
				  </div>

				</div>
			  </div>

			  <!--Insurance information-->
			  <div class="panel panel-default">
				<div class="panel-heading">Insurance</div>
				<div class="panel-body">
				  <div class="form-group">
					<label for="insCompany" class="control-label col-xs-2">Company Name</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="insCompany" name="insCompany" value="<?php echo $insurance_details['company_name']; ?>" placeholder="Name of insurance company">
					</div>
				  </div>

				  <div class="form-group">
					<label for="insScheme" class="control-label col-xs-2">Scheme Name</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="insScheme" name="insScheme" value="<?php echo $insurance_details['shcheme_name']; ?>" placeholder="Insurance scheme">
					</div>
				  </div>

				  <div class="form-group">
					<label for="policynumber" class="control-label col-xs-2">Insurance Policy Number</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="policynumber" name="policynumber" value="<?php echo $insurance_details['policy_no']; ?>" placeholder="Insurance policy">
					</div>
				  </div>
				</div>
			  </div>


			  <div class="form-group">
				<div class="col-xs-10">
				  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Update Employee</button>
					</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>

  </div>
</div>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script>
jQuery(document).ready(function() {

//validate all fields
	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
	$("#inputform").validate({
		rules: {
			 name_emg_person: {required: true},
			 relationship_emg:{required: true},
			 contact_mob_emg:{required: true},
			 bank_given_name:{required: true},
			 bank_code:{required: true},

},
			messages: {
					name_emg_person: "Required",
					relationship_emg:"Required",
					contact_mob_emg:"Required",
					bank_given_name:"Required",
					bank_code:"Required",
			}
});


});
</script>
