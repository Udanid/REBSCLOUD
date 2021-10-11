<script>
	$(document).ready(function(){
    $("#rate_end_date_div").hide();
		$("#rate_start_date").datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      minDate: 1
    });
    $("#rate_start_date").change(function() {
      $("#rate_end_date_div").show();
      $("#rate_end_date").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        minDate: $("#rate_start_date").val(),
      });
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
          <h3 class="title1">Fuel Allowance Rate</h3>
          <div class="widget-shadow">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#main" id="main-tab" role="tab" data-toggle="tab" aria-controls="main" aria-expanded="false">Fuel Allowance Rate</a>
              </li>
              <li role="presentation" class="">
                <a href="#monthrate" role="tab" id="monthrate-tab" data-toggle="tab" aria-controls="monthrate" aria-expanded="true">New Fuel Allowance Rate</a>
              </li>
              <li role="presentation">
                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Fuel Allowance Default Rate</a>
              </li>
              <li role="presentation" class="">
                <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Vehicle Type</a>
              </li>
            </ul>

            <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
              <div role="tabpanel" class="tab-pane fade active in" id="main" aria-labelledby="main-tab" >
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Vehicle Type</th>
                      <th>Start Date</th>
                      <th>To Date</th>
                      <th>Rate per KM</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
            if($ratelist){
              $c = 0;
            $count = 1;
                      foreach($ratelist as $row){ ?>
            <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
              <td><?php echo $count; ?></td>
              <td><?php echo $row->vehicle_name; ?></td>
              <td><?php echo $row->start_date; ?></td>
              <td><?php echo $row->to_date; ?></td>
            <td><?php echo $row->rate_per_km; ?></td>

              <td align="right">
                <div id="checherflag">
                <? if(($row->start_date)>date('Y-m-d')){?>
                <a href="javascript:call_delete('<?php echo $row->id; ?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
              <? }?>
                </div>
              </td>
            </tr>
              <?php
            $count++;
                }
            } ?>
                  </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane" id="monthrate" aria-labelledby="monthrate-tab" >
                <p>
                  <div class="row">
                    <form data-toggle="validator" id="inputform2" name="inputform2" method="post" action="<?php echo base_url();?>hr/hr_config/add_fuel_allowance_rate_period">
              <div class="form-title">
              <h4>New Fuel Allowance Rate Form</h4>
            </div>
            <div class="col-md-6 validation-grids validation-grids-right">
              <div class="" data-example-id="basic-forms">
              <div class="form-body">
                <div class="form-group has-feedback">

                <select name="vehicle" id="vehicle" class="form-control" required>
                  <option value="">--Select Vehicle Type--</option>
                  <?php if($datalist){
                    foreach($datalist as $row){ ?>
                      <option value="<?=$row->id?>"><?=$row->vehicle_type?></option>
                  <? }}?>

                </select>
                <span class="help-block with-errors" >Vehicle Type</span>
              </div>
              <div class="form-group has-feedback">
              <input type="text" class="form-control" name="rate_start_date" id="rate_start_date" placeholder="Start Date" required>
              <span class="help-block with-errors" >Start Date</span>
            </div>
            <div id="rate_end_date_div">
            <div class="form-group has-feedback">
            <input type="text" class="form-control" name="rate_end_date" id="rate_end_date" placeholder="End date" required>
            <span class="help-block with-errors" >End Date</span>
          </div>
          </div>
                <div class="form-group has-feedback">
                <input type="text" class="form-control" name="rate_per_km" id="rate_per_km" placeholder="Rate per KM" required>
                <span class="help-block with-errors" >Rate per KM</span>
              </div>
              <div class="bottom">
                <div class="form-group">
                  <button type="submit" name="monthrate_btn" id="monthrate_btn" class="btn btn-primary disabled">Submit</button>
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
              <div role="tabpanel" class="tab-pane" id="home" aria-labelledby="home-tab" >
                <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Vehicle Type</th>
					    <th>Rate per KM</th>
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
						    <td><?php echo $row->vehicle_type; ?></td>
							<td><?php echo $row->rate_per_km; ?></td>
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

              <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                <p>
                  <div class="row">
                    <form data-toggle="validator" id="inputform" name="inputform" method="post" action="<?php echo base_url();?>hr/hr_config/add_fuel_allowance_rate">
				      <div class="form-title">
					    <h4>New Fuel Allowance Rate Form</h4>
					  </div>
					  <div class="col-md-6 validation-grids validation-grids-right">
					    <div class="" data-example-id="basic-forms">
						  <div class="form-body">
						    <div class="form-group has-feedback">
							  <input type="text" class="form-control" name="vehicle_type" id="vehicle_type" placeholder="Vehicle Type" required>
							  <span class="help-block with-errors" >Vehicle Type</span>
							</div>
						    <div class="form-group has-feedback">
							  <input type="text" class="form-control" name="rate_per_km" id="rate_per_km" placeholder="Rate per KM" required>
							  <span class="help-block with-errors" >Rate per KM</span>
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
		$('#popupform').load("<?php echo base_url();?>hr/hr_config/edit_fuel_allowance_rate/"+id );
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
            window.location="<?php echo base_url();?>hr/hr_config/delete_fuel_allowance_rate/"+document.deletekeyform.deletekey.value;
        },
        cancel: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
        },
        confirmButton: "Yes I am",
        cancelButton: "No"
	});
</script>
