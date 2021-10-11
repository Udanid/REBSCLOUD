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
	window.location="<?=base_url()?>hm/customerletter/update_printstatus/<?=$letter_data->id?>";
    
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
   <?=$customer_data->first_name?> <?=$customer_data->last_name?><br>
   <?=$customer_data->address1?>, <br>
    <?=$customer_data->address2?>,<br>
  <?=$customer_data->address3?>.<br>
 <br>
   
   Dear Sir/ Madam, <br>
 <br>
<span  style="font-size:18px"><strong><u>Regarding the resale of Lot No <?=$res_data->lot_number?> of  <?=$res_data->project_name?> Project </u></strong></span> <br>
  <br><p style="text-align:justify">It is regret to inform you that our company has decided to resell the lot number <?=$res_data->lot_number?> of <?=$res_data->project_name?> projectto an another party without any further notice, due to failure of furnish the down
payment/ rental arrears as agreed payment terms &amp; conditions.
</p><br><br>

Thanking you.<br>
Yours sincerely,<br><br>

..............................................<br>
Manager (Real Estate)<br>
 
  </div>
</div>
</body>