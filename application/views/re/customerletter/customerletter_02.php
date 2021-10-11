<style type="text/css">
body{width:100%;
font-size:100%;
font-family:"Times New Roman", Times, serif;
}
.row{
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
	<div  style="padding-left:50px; font-size:14px; width:640px; ">
    <div style="height: 1.55in;"></div>
    <? 	$futureDate=date('Y-m-d',strtotime('+'.intval(3).' months',strtotime($letter_data->create_date)));
	?>
   
  <p><?=date('d F Y')?><br><br>
  <?=$customer_data->title?>  <?=$customer_data->first_name?> <?=$customer_data->last_name?><br>
   <?=$customer_data->address1?>, <br>
    <?=$customer_data->address2?>,<br>
  <?=$customer_data->address3?>.<br>
 <br>
   
   Dear Sir/ Madam, <br> <br>

<span  style="font-size:16px"><strong><u>Easy payment facility - Agreement No <?=$details->loan_code?></u></strong></span> <br>
  <br><p style="text-align:justify">We are pleasure to grant you an Easy Payment facility for lot no  <?=$res_data->lot_number?> of <?=$res_data->project_name?> project.

Given below are the particulars subject to further terms and conditions of the aforesaid agreement.
  <table>
  <tr><td>Loan amount</td><td>:</td><td><?=number_format($details->loan_amount,2)?></td></tr>
  <tr><td>Monthly installment</td><td>:</td><td><?=number_format($details->montly_rental,2)?></td></tr>
  <tr><td>Term </td><td>:</td><td><?=$details->period?></td></tr>
  <tr><td>Date of first installment due</td><td>:</td><td><?=$currentins->deu_date?></td></tr></table>
  Date of monthly installment due – on or before <?=date('d',strtotime($currentins->deu_date))?> of each and every month.<br>
<ul><li>Please obtain a receipt for every payment, and use the above agreement number for every
transaction.</li>
<li> Default interest will be charged 6% p.m. on amount outstanding after the date specified above.</li>
<li> Your monthly installment can be paid either by cash or cheque.</li>
<li>Your installments can be paid to our any branch.</li>
<li> Your installments can be either deposited by inserting your agreement number in your deposit slip</li>
from below mentioned banks.
<li> You are possible to send the bank slip to the office with mentioning the lot no and the project
name via E mail or fax.</li></ul>
<table style="font-size:12px" width="100%">
<tr><td>Sampatha Bank</td><td>:</td><td>000610011268</td><td>Commercial Bank </td><td>:</td><td>1122013600</td></tr>
<tr><td>Pan Asia Bank</td><td>:</td><td>101211000512</td><td>Hatton National Bank </td><td>:</td><td>224010003192</td></tr>

<tr><td>DFCC Bank</td><td>:</td><td>005001015629</td><td>Seylan Bank </td><td>:</td><td>018034413165001</td></tr>

<tr><td>Bank of Ceylon</td><td>:</td><td>0076421287</td><td>Nation Trust Bank </td><td>:</td><td>100780002907</td></tr>
<tr><td>Peoples Bank</td><td>:</td><td>012100150044791</td><td>Union Bank </td><td>:</td><td>0090101000004540</td></tr>
<tr><td>Cargills Bank</td><td>:</td><td>009950000106</td><td>Standard Chartered Bank </td><td>:</td><td>01501966001</td></tr>

</table>
 <br>
If you need any further clarification about the agreement, please contact us with the following contact
numbers. We would much appreciate your great support and cooperation.
  
  
  </table>

</p>
Thanking you.<br>
Yours sincerely,<br><br>

..............................................<br>
Manager (Real Estate)<br>

  </div>
</div>
</body>



