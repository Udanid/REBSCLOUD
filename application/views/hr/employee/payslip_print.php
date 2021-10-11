<style>
  #popupform {
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:1000;
  }
</style>
<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){

			var id=$("#payroll").val();
			var emp=$("#employee").val();
			if(id!='' && emp!=''){
				var win = window.open("<?=base_url()?>hr/employee/print_payslip_all/"+id+"/"+emp, '_blank');
		    win.focus();
			}

		});

	});
</script>

<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<!--block which displays the outcome message-->
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

		  <div class="table">
			<h3 class="title1">Print Pay Slip</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Print Pay Slip</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

				<div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
				  <p>
					<div class="row">
					  <form data-toggle="validator" id="inputform" name="inputform" method="post">
						<div class="form-title">
						</div>

						<div class="col-md-8">
						  <div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
									<label for="month" class="control-label">Employee</label>
								  <select class="form-control" id="employee" name="employee">
									<option value="">--Select Employee --</option>
									<? foreach ($employee_list as $key => $value) {?>
										<option value="<?=$value->id?>"><?=$value->epf_no?> - <?=$value->initial?><?=$value->surname?></option>
									<? }?>
								  </select>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
								  <label for="month" class="control-label">Payroll Number</label>
								  <select class="form-control" id="payroll" name="payroll">
										<option value="">--Select Year/Month --</option>
										<? foreach ($payroll as $key => $value) {?>
											<option value="<?=$value->id?>"><?=$value->year?> / <?=$value->month?></option>
										<? }?>

								  </select>
								</div>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-md-4">
						  <div class="col-md-12 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Print Payslip</button>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </form>
					</div>
				  </p>
				</div>
			  </div>
			</div>
		  </div>
	  </div>
	</div>

	<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
	<form name="deletekeyform">
	  <input name="deletekey" id="deletekey" value="0" type="hidden">
	</form>

  </div>
</div>

<script>


  function call_print(id){
    var win = window.open("<?=base_url()?>hr/employee/print_payslip_all/"+id, '_blank');
    win.focus();

  }
</script>
