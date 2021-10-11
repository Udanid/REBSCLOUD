<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>
<?php
$date = $details['year']."-".$details['month'];
$month= date("F", strtotime($date));
?>
<h4>Salary Advance Details: <?php echo $month."/".$details['year']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
<table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Employee No</th>
                      <th>Name</th>
                      <th>Salary Advance(Rs)</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
				    if($salary_advance_list){
				  	  $c = 0;
					  $count = 1;
				  	  $ci =&get_instance();
					  $ci->load->model('employee_model');
                  	  foreach($salary_advance_list as $row){
					    $empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);  ?>
						<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
						  <td><?php echo $count; ?></td>
						  <td>
						    <?php
							echo $empDetails['epf_no'];
							?>
						  </td>
						  <td><?php echo $empDetails['initial']." ".$empDetails['surname']; ?></td>
						  <td><?php echo $row->salary_advance_amount; ?></td>
						  <td align="right">
				    		<?php
						    if($details['status'] == 'P'){ ?>
								<div id="checherflag">
								  <a href="javascript:call_edit_salary_advance('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
								</div>
							<?php
							} ?>

						  </td>
						</tr>
					  <?php
						$count++;
			          }
				    } ?>
                  </tbody>
                </table>
  </div>
</div>



<script>

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_edit_salary_advance(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/emp_payroll/emp_salary_advance_edit/"+id );
	}


</script>
