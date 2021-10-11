<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

				$("form#inputform").submit(function(e){
					e.preventDefault();
					var siteUrl = '<?php echo base_url(); ?>';
					var dats = $(this).serializeArray();
					$.ajax({
						url: siteUrl + 'hr/employee/edit_no_pay_leave_list',
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

	});
</script>
<?php
$date = $details['year']."-".$details['month'];
$month= date("F", strtotime($date));
?>
<h4>No Pay Details: <?php echo $month."/".$details['year']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
		<tbody>
			<form data-toggle="validator" id="inputform" name="inputform" method="post">
				<input id="year" name="year" type="hidden" value="<?=$details['year']?>">
				<input id="month" name="month" type="hidden" value="<?=$details['month']?>">
<table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Employee No</th>
                      <th>Name</th>
                      <th>No Pay Leave Count</th>
                    </tr>
                  </thead>

                    <?php
				    if($no_pay_list){
				  	  $c = 0;
					  $count = 1;
				  	  $ci =&get_instance();
					  $ci->load->model('employee_model');
                  	  foreach($no_pay_list as $row){
					    $empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);  ?>
						<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
						  <td><?php echo $count; ?></td>
						  <td>
						    <?php
							echo $empDetails['epf_no'];
							?>
						  </td>
						  <td><?php echo $empDetails['initial']." ".$empDetails['surname']; ?></td>
						  <td><input type="hidden" value="<?=$row->no_pay_leave_master_id?>" id="no_pay_leave_<?=$empDetails['id']?>" name="no_pay_leave_<?=$empDetails['id']?>">
								<input type="hidden" value="<?=$empDetails['id']?>" id="employee_<?=$empDetails['id']?>" name="employee_<?=$empDetails['id']?>">
								<input type="hidden" value="<?=$row->no_pay_count_final?>" id="no_pay_count_<?=$empDetails['id']?>" name="no_pay_count_<?=$empDetails['id']?>">
								<input type="text" value="<?=$row->no_pay_count_final?>" id="edit_no_pay_count_<?=$empDetails['id']?>" name="edit_no_pay_count_<?=$empDetails['id']?>">
							</td>
						</tr>
					  <?php
						$count++;
			          }
				    } ?>

                  </tbody>
                </table>
								<div class="col-md-4">
								  <div class="col-md-12 validation-grids validation-grids-right">
									<div class="" data-example-id="basic-forms">
									  <div class="form-body">
										<div class="form-group">
										  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Submit</button>
										</div>
									  </div>
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
