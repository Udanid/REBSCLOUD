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
$to_date_cal = strtotime($to_date);
$from_date_cal= strtotime($from_date);
$datediff = $to_date_cal - $from_date_cal;
$datediff = round($datediff / (60 * 60 * 24));
?>
<h4>Employee Expense Details: <?php echo "From - ".$from_date.", To - ".$to_date; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow" style="background-color:transparent;">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Employee Expense Details: <?php echo "From - ".$from_date.", To - ".$to_date; ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Print"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>

  <div>
    <table>
      <tr>
        <td>Emp No:</td>
        <td><?=$employee_data['emp_no'];?></td>
      </tr>
      <tr>
        <td>Name:</td>
        <td><?=$employee_data['initial'];?><?=$employee_data['surname'];?></td>
      </tr>
      <tr>
        <td>Joint on:</td>
        <td><?=$employee_data['joining_date'];?></td>
      </tr>
    </table>
  </div>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <table class="table" style="border-collapse:collapse;" border="1">
      <thead>
      <tr bgcolor="LightGray">
        <th></th>
        <? if($monthName){
          foreach ($monthName as $key) {?>
            <th><?=$key?></th>
        <?  }
        }
        ?>
        <th>Total</th>
        <th>Avg per Month</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td> Basic Salary</td>
        <? if($basic_salary){
          foreach ($basic_salary as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
        <td><?=number_format(array_sum($basic_salary),2)?></td>
        <td><?=number_format(array_sum($basic_salary)/count($basic_salary),2)?></td>
      </tr>
      <tr>
        <td>Other Allowance</td>
        <? if($allowance){
          foreach ($allowance as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($allowance),2)?></td>
        <td align="right"><?=number_format(array_sum($allowance)/count($allowance),2)?></td>
      </tr>
      <tr>
        <td>Vehicle Rent</td>
        <? if($vehical_rent){
          foreach ($vehical_rent as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($vehical_rent),2)?></td>
        <td align="right"><?=number_format(array_sum($vehical_rent)/count($vehical_rent),2)?></td>
      </tr>
      <tr>
        <td>Commission </td>
        <? if($commition){
          foreach ($commition as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($commition),2)?></td>
        <td align="right"><?=number_format(array_sum($commition)/count($commition),2)?></td>
      </tr>
      <tr>
        <td>Fuel Expense</td>
        <? if($fual_expence){
          foreach ($fual_expence as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($fual_expence),2)?></td>
        <td align="right"><?=number_format(array_sum($fual_expence)/count($fual_expence),2)?></td>
      </tr>
      <tr>
        <td>EPF</td>
        <? if($epf){
          foreach ($epf as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($epf),2)?></td>
        <td align="right"><?=number_format(array_sum($epf)/count($epf),2)?></td>
      </tr>
      <tr>
        <td>ETF</td>
        <? if($etf){
          foreach ($etf as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($etf),2)?></td>
        <td align="right"><?=number_format(array_sum($etf)/count($etf),2)?></td>
      </tr>
      <tr>
        <td>Phone Bill</td>
        <? if($phone_bill){
          foreach ($phone_bill as $key) {?>
            <td align="right"><?=number_format($key,2)?></td>
        <?  }
        }
        ?>
				<td align="right"><?=number_format(array_sum($phone_bill),2)?></td>
        <td align="right"><?=number_format(array_sum($phone_bill)/count($phone_bill),2)?></td>
      </tr>

    </tbody>
	</tfooter>
		<tr bgcolor="LightGray">
			<th></th>
			<? if($emp_sum){
				foreach ($emp_sum as $key) {?>
					<td align="right"><?=number_format($key,2)?></td>
			<?  }
			}
			?>
			<td align="right"><?=number_format(array_sum($emp_sum),2)?></td>
			<td align="right"><?=number_format(array_sum($emp_sum)/count($emp_sum),2)?></td>
		</tr>
		</tfooter>


    </table>
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
        this.download = "Employee_Expense.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});

</script>
