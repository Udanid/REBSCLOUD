





<style type="text/css">
body{width:100%;
font-size:100%;
font-family:"Times New Roman", Times, serif;
}
.row{
	font-size:100%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	window.location="<?=base_url()?>re/customerletter/update_printstatus/<?=$letter_data->id?>";
    
	window.close();
}
</script>
<body onLoad="print_function()">
<div class="row"  >
	<div  style="padding-left:50px; font-size:16px; width:640px; ">
    <div style="height: 1.75in;"></div>
    <? 	$futureDate=date('Y-m-d',strtotime('+'.intval(3).' months',strtotime($letter_data->create_date)));
	$duedata=date('Y-m-d',strtotime('+14 days',strtotime($letter_data->create_date)));
	?>
   
  <p><?=date('d F Y')?><br><br>
   <?=$customer_data->first_name?> <?=$customer_data->last_name?><br>
   <?=$customer_data->address1?>, <br>
    <?=$customer_data->address2?>,<br>
  <?=$customer_data->address3?>.<br>
 <br>
   
   Dear Sir/ Madam, <br>

<p style="text-align:center"><span  style="font-size:18px; text-align:center; width:100%" ><strong><u>Notice of Agreement Cancellation </u></strong></span></p>
  <br><p style="text-align:justify"> 
  <table  width="100%" style="font-size:14px">
    <tr ><td >Project Name</td><td>:</td><td ><?=$res_data->project_name?></td><td >No of default installments</td><td>:</td><td valign="middle"><?=$letter_data->arrs_ins?></td></tr>
    <tr ><td width="105">Lot No</td><td>:</td><td><?=$res_data->lot_number?></td><td >Default amount</td><td>:</td><td valign="middle"><?=number_format($letter_data->arrs_amount,2)?></td></tr>
    <tr><td width="105">Agreement No</td><td>:</td><td ><?=$details->loan_code?></td><td >Default interest</td><td>:</td><td valign="middle"><?=number_format($letter_data->delay_int,2)?></td></tr>
    <tr ><td width="105">Agreement Date</td><td>:</td><td ><?=$details->start_date?></td><td >Total default amount</td><td>:</td><td valign="middle"><?=number_format($letter_data->delay_int+$letter_data->arrs_amount,2)?></td></tr>

    </table><br>
   Refer to the above rental agreement, we hereby request you to settle the above mentioned total
outstanding amount within 14 days from the date hereof. In case of unsettlement of the said amount
within the given period of time, this agreement will be terminated with effect from  <?=date('d F Y',strtotime($duedata))?>.
</p><br><br>
Thanking you.<br>
Yours sincerely,<br><br>

..............................................<br>
Manager (Real Estate)<br>
 
  </div>
</div>
</body>




