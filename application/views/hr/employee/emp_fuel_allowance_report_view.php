<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
	});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h4>STATEMENT OF FUEL EXPENSESS: <?php echo "From - $start_date, To - $end_date"; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>STATEMENT OF FUEL EXPENSESS: <?php echo "From - $start_date, To - $end_date"; ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Re Print Payment Entry"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <table class="table" style="border-collapse:collapse;" border="1"> 
      <thead> 
        <tr> 
          <th colspan="5">Name: <?php echo $employee_details['initial']." ".$employee_details['surname'] ?></th>
          <th colspan="2">From: <?php echo $start_date; ?> To: <?php echo $end_date; ?></th>
        </tr>
        <tr>
		  	<th rowspan="2">Date</th>
		  	<th colspan="2" style="text-align: center;">Speedometer Reading</th>
		  	<th colspan="2" style="text-align: center;">Mileage</th>
		  	<th rowspan="2" colspan="2" style="text-align: center;">Details of Journey</th>
        </tr>
        <tr>
		  	<th>In</th>
		  	<th>Out</th>
		  	<th>Office</th>
		  	<th>Private</th>
        </tr>
      </thead>
      
	  <tbody>
        <?php
		$c = 0;
		$official_count = 0;
		$private_count = 0;
		foreach($view_emp_fuel_allowance_report as $row){ 
		  $official_count = $official_count + $row->official; 
		  $private_count = $private_count + $row->private;
		  ?>
			<tr>
			  <td><?php echo $row->effective_date; ?></td>
			  <td><?php echo $row->start_reading; ?></td>
			  <td><?php echo $row->end_reading; ?></td>
			  <td><?php echo $row->official; ?></td>
			  <td><?php echo $row->private; ?></td>
			  <td colspan="2">
			    <?php
				if($row->location1 != ""){
					echo $row->location1;
				}
				if($row->description1 != ""){
					echo " - ".$row->description1;
				}
				if($row->location2 != ""){
					echo "<br>".$row->location2;
				}
				if($row->description2 != ""){
					echo " - ".$row->description2;
				}
				if($row->location3 != ""){
					echo "<br>".$row->location3;
				}
				if($row->description3 != ""){
					echo " - ".$row->description3;
				}
				if($row->location4 != ""){
					echo "<br>".$row->location4;
				}
				if($row->description4 != ""){
					echo " - ".$row->description4;
				}
				if($row->location5 != ""){
					echo "<br>".$row->location5;
				}
				if($row->description5 != ""){
					echo " - ".$row->description5;
				}

				?>
			  </td>
			</tr>
		<?php  
	    } ?>   
		<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
		  <td colspan="3"><b>Total</b></td>
		  <td><b><?php echo $official_count; ?></b></td>
		  <td><b><?php echo $private_count; ?></b></td>
		  <td colspan="2" style="text-align: center;"><b><?php echo $official_count + $private_count; ?></b></td>
	    </tr>    
      </tbody>  
    </table>
	<div>
	  <?php 
	  $first_day = "";
	  $last_day = "";
	  foreach($view_emp_fuel_allowance_report as $element) {
		if ($element === reset($view_emp_fuel_allowance_report)){
			$first_day = $element->start_reading;
		}
			
		if ($element === end($view_emp_fuel_allowance_report)){
			$last_day = $element->end_reading;
		}
			
	  } ?>
	  <b>Meter Reading</b>
	  <p>Last Day : <?php echo $last_day; ?></p>
	  <p>First Day : <?php echo $first_day; ?></p>
	  <p>Total : <?php echo $official_count + $private_count; ?></p>
	  <p>Signature Of Traveller : __________________________</p>
	  <br>
	</div>
  </div>
</div>



<script>
	
	function close_edit(){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	function sent_to_print(){
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').hide();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		$('body').empty().html(printcontent);
		window.print();
		$('#print_title').hide();
		$('#print_icon').show();
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
        this.download = "fuel_allowance_statement.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});
	
</script>
