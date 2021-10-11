<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({      
				url: siteUrl + 'hr/hr_config/add_division_head',
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {
	                if($.isEmptyObject(data.error)){
	                	location.reload();
	                }else{
						unsuccessfulAttemptAction(data.error);
	                }
				},
				error: function(e) {
					console.log(e.responseText);
				}
			});
		});
		
		function unsuccessfulAttemptAction(errors){
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
	});
	
	function load_employee(branch_id){
		$("#division_head_emp_record_id").find('option').removeAttr("disabled");
		$("#division_head_emp_record_id option[value='"+division_id+"']").attr("disabled","disabled");
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			type: 'POST',
			url: siteUrl + 'hr/hr_config/get_employee_list',
			async: false,
			dataType: 'json',
			success: function(data){
				$('#division_head_emp_record_id').empty();
				for(var i = 0; i < data.employee_list.length; i++) {
					if(data.employee_list[i].branch == branch_id && data.employee_list[i].status == "A"){
						$('#division_head_emp_record_id').append('<option value=' + data.employee_list[i].id + '>' + data.employee_list[i].emp_no + ' - ' + data.employee_list[i].surname + '</option>');
					}
				}
			}
		});
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
          <h3 class="title1">Division Head</h3>	
          <div class="widget-shadow">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Division Head</a>
              </li>
              <li role="presentation" class="">
                <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Division Head</a>
              </li>
            </ul>
            
            <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
              <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >        
                <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  <table class="table"> 
                    <thead> 
                      <tr> 
                        <th>No</th>
                        <th>Branch</th>
					    <th>Division</th>
                        <th>Head</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
				      if($datalist){
				  	    $c = 0;
					    $count = 1;
					    $ci =&get_instance();
					    $ci->load->model('employee_model');
                  	    foreach($datalist as $row){ ?>
						  <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
						    <td><?php echo $count; ?></td>
						    <td>
							  <?php
							  foreach($branch_list as $branch){
								  if($branch->branch_code == $row->branch_id){
									  $branch_name = $branch->branch_name;
								  }
							  }
							  echo $branch_name; 
							  ?>
						    </td>
						    <td>
							  <?php
							  foreach($division_list as $division){
								  if($division->id == $row->division_id){
									  $division_name = $division->division_name;
								  }
							  }
							  echo $division_name; 
							  ?>
						    </td>
						    <td>
						      <?php
							  $empDetails = $ci->employee_model->get_employee_details($row->division_head_emp_record_id);
							  echo $empDetails['emp_no'].' - '.$empDetails['initial'].' '.$empDetails['surname']; 
							  ?>
						    </td>
						    <td align="right">
						      <div id="checherflag">
							    <a href="javascript:call_edit('<?php echo $row->id; ?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
<!--							    <a href="javascript:call_delete('<?php echo $row->id; ?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>-->
						      </div>
						    </td>
						  </tr>
					      <?php
						  $count++;
			            }
				      } ?>
                    </tbody>
                  </table> 
                  <div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
                </div>
              </div>
            
              <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab"> 
                <p>	
                  <div class="row">
                    <form data-toggle="validator" id="inputform" name="inputform" method="post">
				      <div class="form-title">
					    <h4>New Division Head Form</h4>
					  </div>
					  <div class="col-md-6 validation-grids validation-grids-right">
					    <div class="" data-example-id="basic-forms"> 
					      <div class="form-body">
						    <div class="form-group has-feedback">
							  <select class="form-control" id="branch_id" name="branch_id" onChange="load_employee(this.value);" required>
							    <option value="">--Select Branch--</option>
							    <?php
							    foreach($branch_list as $branch){ ?>
								  <option value="<?php echo $branch->branch_code; ?>"><?php echo $branch->branch_name; ?></option>
							    <?php
							    } ?>
							  </select>
							  <span class="help-block with-errors" >Branch</span>
						    </div>
							
						    <div class="form-group has-feedback">
							  <select class="form-control" id="division_id" name="division_id" required>
							    <option value="">--Select Division--</option>
							    <?php
							    foreach($division_list as $division){ ?>
								  <option value="<?php echo $division->id; ?>"><?php echo $division->division_name; ?></option>
							    <?php
							    } ?>
							  </select>
							  <span class="help-block with-errors" >Division</span>
						    </div>
							
						    <div class="form-group has-feedback">
							  <select class="form-control" id="division_head_emp_record_id" name="division_head_emp_record_id" required>
							    <option value="">--Select Employee--</option>
						        <?php
							    foreach($employee_list as $employee_list_row){
								  if($employee_list_row->status == "A"){ ?>
									<option value="<?php echo $employee_list_row->id; ?>"><?php echo $employee_list_row->emp_no.' - '.$employee_list_row->surname; ?></option>
								  <?php
								  }
							    } ?>
							  </select>
							  <span class="help-block with-errors" >Select Employee</span>
						    </div>
						    <div class="bottom">
						      <div class="form-group">
							    <button type="submit" class="btn btn-primary disabled">Submit</button>
							  </div>
							  <div class="clearfix"> </div>
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
	
	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/hr_config/edit_division_head/"+id );
	}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	function call_delete(id){
		document.deletekeyform.deletekey.value = id;
		$('#complexConfirm').click();
	}
	
	$("#complexConfirm").confirm({
    	title:"Delete confirmation",
        text: "Are You sure you want to delete this ?" ,
		headerClass:"modal-header",
        confirm: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
            window.location="<?php echo base_url();?>hr/hr_config/delete_division_head/"+document.deletekeyform.deletekey.value;
        },
        cancel: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
        },
        confirmButton: "Yes I am",
        cancelButton: "No"
	});
</script>
