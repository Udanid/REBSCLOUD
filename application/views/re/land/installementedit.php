<!--//Ticket No:2385-->
<style>
.redtext{ color:#C30; font-style:italic;}
</style>
<h4>Edit<span  style="float:right; color:#FFF" ><a href="javascript:close_view()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow" style="margin-left: 5px;">
	<button class="btn btn-success" id="addbtn" style="margin-left:5px;margin-top:10px;width:65.11px;height:5%;">+ Add</button>
	<hr>
	<form style="margin-top:5px;" action="<?php echo base_url('index.php/re/landpayment_agreement/update')?>" method="POST">
		<input type="hidden" name="agreement_id" value="<?=$agreement_id?>">
		<input type="hidden" name="totval" id="totval" value="<?=$totval?>">
		<table class="table-striped" id='newfield'>
		<tr>
			<th>No</th>
			<th>Installment Amount</th>
			<th>Due date</th>
		</tr>
	<?
	$count = 0;
	foreach($installementdetails as $shedule)
		{
			echo '<tr>';
			echo '<td>'.($count+1).'</td>';
			echo '<td style="width:30%;padding:0"><input type="hidden" value='.$shedule['installment_id'].' name="installment_id[]"><input type="text" step="0.01" name="installment[]" class="form-control number-separator" style="width:60%;height:34px;" value='.$shedule['installment_amount'].'></td>';
			echo '<td><input type="date" name="date[]" class="form-control" style="width:40%;height:34px; margin-left:5px" value='.$shedule['due_date'].'></td>';
			//echo '</div>';
			//echo '<td>'.$shedule['due_date'].'</td>';
			echo '</tr>';

			$count += 1;
			}
		?>
		<!--<div id="newfield"></div>-->
	</table>
		<hr>
		<div class="container" >
			<input type="submit" name="submit" value="Update" class="btn btn-primary" style="margin-bottom: 10px;" onclick="return check()">

		</div>
		<!--<input type="reset" name="reset" value="Reset" class="btn btn-warning">-->
	</form>
</div>

<script type="text/javascript">
	$('#addbtn').click(function(){

		var count = parseInt($('#newfield tr:last').find("td").eq(0).html());

		 $('#newfield').append('<tr><td>'+(count+1)+'</td><td style="width:30%;padding:0"><input type="text" step="0.01" name="installment_new[]" class="form-control number-separator" style="width:60%;height:34px;" ></td><td><input type="date" name="date_new[]" class="form-control" style="width:40%;height:34px; margin-left:5px" ></td></tr>');
	});
</script>
<script type="text/javascript">

	function check()
	{
		var sum_old = 0;
		var totalamount_old = 0;
		var sum_new = 0;
		var totalamount_new = 0;
		var values = $("input[name='installment[]']").map(function(){return $(this).val();}).get();
		var new_values = $("input[name='installment_new[]']").map(function(){return $(this).val();}).get();
		//alert(new_values);
		if(new_values == '')
		{
			var length = values.length;
			for(i = 0 ; i<(length-1);i++)
			{
				sum_old += parseInt(values[i]);

			}

			for(i = 0 ; i<length;i++)
			{
				totalamount_old += parseInt(values[i]);

			}
			// values.forEach(calSum);
			var totalvalue = parseInt($('#totval').val());
			if(totalamount_old == totalvalue)
			{


				return true;
				sum_old = 0;
			}
			else
			{
				var diff = totalvalue - sum_old;
				alert('You are last installment amount must be '+diff);

				//document.getElementById("checkflagmessage").innerHTML='Your last installment amount must be '+diff;
				//$('#flagchertbtn').click();
				sum_old = 0;
				return false;
				totalamount_old = 0;
				//$( "#popupform" ).close();




			}
		}
		else
		{
			var length = values.length;
			// for(i = 0 ; i<(length-1);i++)
			// {
			// 	sum_old += parseInt(values[i]);

			// }

			for(i = 0 ; i<length;i++)
			{
				totalamount_old += parseInt(values[i]);

			}

			var length_new = new_values.length;
			for(i = 0 ; i<(length_new-1);i++)
			{
				sum_new += parseInt(new_values[i]);

			}

			for(i = 0 ; i<length_new;i++)
			{
				totalamount_new += parseInt(new_values[i]);

			}
			// values.forEach(calSum);
			var totalvalue = parseInt($('#totval').val());
			totalamount = totalamount_new + totalamount_old;
			if(totalamount == totalvalue)
			{
				return true;
				sum_new = 0;
				totalamount_old = 0;
			}
			else
			{
				var diff = totalvalue - (sum_new+totalamount_old);
				//alert('You are last installment amount must be '+diff);
				document.getElementById("checkflagmessage").innerHTML='Your last installment amount must be '+diff;
							 $('#flagchertbtn').click();
				sum_new = 0;
				totalamount_old = 0;
				return false;
			}

			//return false;
		 }
		// //return false;

	}


</script>
