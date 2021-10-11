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
          <h3 class="title1">Leave Category</h3>
          <div class="widget-shadow">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Leave Category</a>
              </li>
              <li role="presentation" class="">
                <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Leave Category</a>
              </li>
            </ul>

            <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
              <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
                <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Leave Category</th>
					    <th>Annual Leaves</th>
                        <th>Casual Leaves</th>
					    <th>Sick Leaves</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
				      if($datalist){
				  	    $c = 0;
					    $count = 1;
                  	    foreach($datalist as $row){ ?>
						  <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
						    <td><?php echo $count; ?></td>
						    <td><?php echo $row->leave_category_name; ?></td>
						    <td><?php echo $row->annual_leave; ?></td>
						    <td><?php echo $row->cassual_leave; ?></td>
						    <td><?php echo $row->sick_leave; ?></td>
						    <td align="right">
						      <div id="checherflag">
							    <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
<!--							    <a href="javascript:call_delete('<?php echo $row->id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>-->
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
                    <form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/add_leave_category">
                      <div class="form-title">
					    <h4>New Leave Category Form</h4>
					  </div>
					  <div class="col-md-6 validation-grids validation-grids-right">
					    <div class="" data-example-id="basic-forms">
					      <div class="form-body">
						    <div class="form-group has-feedback">
						      <input type="text" class="form-control" name="leave_category_name" id="leave_category_name" placeholder="Leave Category Name" required>
							  <span class="help-block with-errors" >Leave Category Name</span>
						    </div>
						    <div class="form-group has-feedback">
						      <input type="number" class="form-control" name="annual_leave" id="annual_leave" placeholder="Annual Leave" required>
							  <span class="help-block with-errors" >Annual Leave</span>
						    </div>
						    <div class="form-group has-feedback">
						      <input type="number" class="form-control" name="cassual_leave" id="cassual_leave" placeholder="Cassual Leave" required>
							  <span class="help-block with-errors" >Casual Leave</span>
						    </div>
						    <div class="form-group has-feedback">
						      <input type="number" class="form-control" name="sick_leave" id="sick_leave" placeholder="Sick Leave" required>
							  <span class="help-block with-errors" >Sick Leave</span>
						    </div>
						    <div class="form-group has-feedback">
						      <input type="number" class="form-control" name="maternity_leave" id="maternity_leave" placeholder="Maternity Leave" required>
							  <span class="help-block with-errors" >Maternity Leave</span>
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
		$('#popupform').load("<?php echo base_url();?>hr/hr_config/edit_leave_category/"+id );
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
            window.location="<?php echo base_url();?>hr/hr_config/delete_leave_category/"+document.deletekeyform.deletekey.value;
        },
        cancel: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
        },
        confirmButton: "Yes I am",
        cancelButton: "No"
	});
</script>
