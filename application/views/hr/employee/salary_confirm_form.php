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
	function load_pdf_empno(id)
	{
		 if(id!="")
		 {
		 	$("#data_letter_type").show();
		 	$("#print_button").hide();
		 	 $('#fulldata').delay(1).fadeIn(600);
	    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
			 $( "#fulldata").load( "<?=base_url()?>hr/letter/get_letters_by_empno/"+id);
		 }
	}

	function load_letter_bytype(id){
		var emp_no= $("#employee").val();
		if(id==5)
		 {
		 	$("#print_button").show();
		 }
		 else{
		 	$("#print_button").hide();
		 }
		 if(id!="")
		 {
		 	$('#fulldata').delay(1).fadeIn(600);
		 	document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
		 	$( "#fulldata").load( "<?=base_url()?>hr/letter/get_letters_by_type/"+emp_no+"/"+id);
		 }

	}

	function create_letter(){
		var emp_no= $("#employee").val();
		var letter_type= $("#letter_type").val();
		
		 if(emp_no!="")
		 {
		 	$("#data_letter_type").show();
		 	$("#print_button").hide();
		 	 $('#fulldata').delay(1).fadeIn(600);
	    	  document.getElementById("fulldata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
			 $( "#fulldata").load( "<?=base_url()?>hr/letter/create_letter/"+emp_no);
		}
	}
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
			<h3 class="title1">Salary Confirmation Letter</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Salary Confirmation Letter</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">

				<div role="tabpanel" class="tab-pane fade active in" id="profile" aria-labelledby="profile-tab">
				  <p>
					<div class="row">
					  <form data-toggle="validator" id="inputform" name="inputform" method="post" action="">
						<div class="form-title">
						</div>

						<div class="col-md-12">
						  <div class="">
							<div class="row" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback col-md-4">
									<label for="month" class="control-label">Employee</label>
								  <select class="form-control" id="employee" name="employee" onchange="load_pdf_empno(this.value)">
									<option value="">--Select Employee --</option>
									<? if($employee_list){foreach ($employee_list as $key => $value) {?>
										<option value="<?=$value->id?>"><?=$value->epf_no?> - <?=$value->initial?><?=$value->surname?></option>
									<? }}?>
								  </select>
								</div>
							  	<div class="form-group has-feedback  col-md-4" style="display: none" id="data_letter_type" >
									<label for="letter_type" class="control-label">Letter Type</label>
								  <select class="form-control" id="letter_type" name="letter_type" onchange="load_letter_bytype(this.value)">
									<option value="">--Select Letter Type --</option>
									<? if($letter_type){foreach ($letter_type as $key => $value) {?>
										<option value="<?=$value->id?>"><?=$value->Name?></option>
									<? }}?>
								  </select>
								</div>
							  </div>
							  <div class="col-md-4" style="display: none" id="print_button">
								  <div class="col-md-12 validation-grids validation-grids-right">
									<div class="" data-example-id="basic-forms">
									  <div class="form-body">
										<div class="form-group">
										  <button type="button" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request" onclick="create_letter()">Print Letter</button>
										</div>
									  </div>
									</div>
								  </div>
								</div>
							</div>
							</div>
						  </div>
						</div>

						<div class="col-md-4" style="display: none" id="print_button">
						  <div class="col-md-12 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <button type="button" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request" onclick="create_letter()">Print Letter</button>
								</div>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-md-12" id="fulldata">
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