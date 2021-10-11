<!--//Ticket No:2385-->
<style>
.redtext{ color:#C30; font-style:italic;}
</style>
<h4>Schedule<span  style="float:right; color:#FFF" ><a href="javascript:close_view()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
	<table class="table-striped">
		<tr>
			<th>No</th>
			<th>Installment Amount</th>
			<th>Due Date</th>
		</tr>
		<?
		 $count = 0;	
		 foreach($installementdetails as $shedule)
			{
				echo '<tr>';
				echo '<td>'.($count + 1).'</td>';
				echo '<td>'.number_format((float)$shedule['installment_amount'], 2, '.', '').'</td>';
				echo '<td>'.$shedule['due_date'].'</td>';
				echo '</tr>';
				$count += 1;
			}
		?>
		<tr style="background:#E1F8DC">
			<td><b>Total</b></td>
			<td><b><?= number_format((float)$totval, 2, '.', '')?></b></td>
			<td></td>
		</tr>
	</table>
</div>