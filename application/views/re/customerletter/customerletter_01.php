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
	?>
   
  <p><?=date('d F Y')?><br><br>
  <?=$customer_data->title?> <?=$customer_data->first_name?> <?=$customer_data->last_name?><br>
   <?=$customer_data->address1?>, <br>
    <?=$customer_data->address2?>,<br>
  <?=$customer_data->address3?>.<br>
 <br>
   
   Dear Sir/ Madam, <br>
 <br>
<span  style="font-size:18px"><strong><u>Down Payment for Lot No <?=$res_data->lot_number?> of  <?=$res_data->project_name?> Project </u></strong></span> <br>
  <br><p style="text-align:justify">We thankful you to reserve lot number <?=$res_data->lot_number?> of <?=$res_data->project_name?> project by paying
advance amount Rs. <?=number_format($res_data->down_payment,2)?> and request you to pay Rs. <?=number_format($res_data->min_down-$res_data->down_payment,2)?> for complete the
minimum balance payment on or before <?=date('d F Y',strtotime($res_data->dp_cmpldate))?>.
</p><br><br>
Thanking you.<br>
Yours sincerely,<br><br>

..............................................<br>
Manager (Real Estate)<br>
 
  </div>
</div>
</body>