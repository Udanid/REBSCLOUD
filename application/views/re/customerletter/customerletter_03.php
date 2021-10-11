
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
 //   
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
  <?=$customer_data->title?>  <?=$customer_data->first_name?> <?=$customer_data->last_name?><br>
   <?=$customer_data->address1?>, <br>
    <?=$customer_data->address2?>,<br>
  <?=$customer_data->address3?>.<br>
 <br>
   
   Dear Sir/ Madam, <br>
 <br>
<span  style="font-size:18px"><strong><u>Notification of installing a boundary fence</u></strong></span> <br>
  <br><p style="text-align:justify">We thankful to you and glad to inform you that you have completed making the total payment/ rental
payment for the lot no <?=$res_data->lot_number?> under <?=$res_data->project_name?> project and kindly request you to install a boundary
fence as in attached diagram herewith for the avoidance of issues arising out of real boundary marked
by the surveyor.<br><br>
* This letter serves as official notice for inform you to install a boundary fence for the avoidance of
loss and removal of boundary marks and boundary posts in future.
</p><br><br>
Thanking you.<br>
Yours sincerely,<br><br>

..............................................<br>
Manager (Real Estate)<br>
 
  </div>
</div>
</body>
