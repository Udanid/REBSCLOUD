<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
	});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
$date = $details['year']."-".$details['month']; 
$month= date("F", strtotime($date)); 
?>
<h4>Fuel Allowance Details: <?php echo $month."/".$details['year']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Fuel Allowance Details: <?php echo $month."/".$details['year']; ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Re Print Payment Entry"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
<table class="table"> 
                  <thead> 
                    <tr> 
                      <th>No</th>
                      <th>Employee No</th>
                      <th>Name</th>
                      <th>Fuel Maximum Limit</th>
					  <th>Additional Fuel</th>
                      <th>Official(KM)</th>
                      <th>Private(KM)</th>
					  <th>Total(KM)</th>
                      <th>Total Amount</th>
                      <th>Exceeded Amount</th>
                      <th>Total Amount Payable</th>
                      <th name="display_edit_icon_th" id="display_edit_icon_th"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
				    if($fuel_allowance_payment_list){
				  	  $c = 0;
					  $count = 1;
				  	  $ci =&get_instance();
					  $ci->load->model('employee_model');
                  	  foreach($fuel_allowance_payment_list as $row){
					    $empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);  ?>
						<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
						  <td><?php echo $count; ?></td>
						  <td>
						    <?php
							echo $empDetails['epf_no']; 
							?>
						  </td>
						  <td><?php echo $empDetails['initial']." ".$empDetails['surname']; ?></td>
						  <td><?php echo $row->max_limit; ?></td>
						  <td><?php echo $row->additional_fuel; ?></td>
						  <td><?php echo $row->official_km; ?></td>
						  <td><?php echo $row->private_km; ?></td>
						  <td><?php echo $row->total_km; ?></td>
						  <td><?php echo $row->total_amount; ?></td>
						  <td><?php echo $row->exceeded_amount; ?></td>
						  <td><?php echo $row->total_amount_payable; ?></td>
						  <td align="right" class="display_edit_icon">
						    <div id="checherflag">
							  <a href="javascript:call_emp_fuel_report('<?php echo $details['id']; ?>','<?php echo $row->emp_record_id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
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
</div>



<script>
	function call_emp_fuel_report(master_id, emp_id){
		$('#popupform').fadeIn(10);
		$('#popupform').load("<?php echo base_url();?>hr/employee/emp_fuel_allowance_report/"+master_id+"/"+emp_id );
	}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	function sent_to_print(){
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').hide();
		$(".display_edit_icon").css("display", "none");
		$('#display_edit_icon_th').hide();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		$('body').empty().html(printcontent);
		window.print();
		$('#print_title').hide();
		$('#print_icon').show();
		$('#display_edit_icon').show();
		$('#display_edit_icon_th').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	}
	
	$("#generate_excel_icon").click(function (e) {
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').empty();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		var contents = $('body').empty().html(printcontent);
		//window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html()));
		var result = 'data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html());
        this.href = result;
        this.download = "fuel_allowance_report.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});
	
</script>
