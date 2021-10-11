<?
$totint=((($loan_data->total_period/12)*$loan_data->interest_rate)/100)*$loan_data->loan_amount;
$bal_cap=$loan_data->loan_amount-$paydata->totcap_amount;
$bal_int=$totint-$paydata->totint_amount;
$bal_tot=$bal_cap+$bal_int;
$paidpreentage=($paydata->totcap_amount/$loan_data->loan_amount)*100;
$creditcap=0; $creditint=0; $thisinsalment=NULL;
$delay=0; $ontime=0;$arreascap=0;$arreasint=0;$arreascount=0;
if($paydetails){
  foreach ($shedetails as $key => $value) {
    //$thisinsalment[$row->ins_id]['ins_cap']=$row->ins_cap;
    //$thisinsalment[$row->ins_id]['ins_int']=$row->ins_int;

    $date1=date_create($value->deu_date);
    $date2=date_create($value->pay_date);
    $date3=date_create( date("Y-m-d"));

    $diff=date_diff($date1,$date2);
    $dates=$diff->format("%a");
    if($date3<$date1)
    {
      $creditcap=$creditcap+$value->cap_amount;
      $creditint=$creditint+$value->int_amount;
    }
    if($date1<$date3)
    {
      if($value->pay_status=="PENDING"){
        $arreascap=$arreascap+$value->cap_amount;
        $arreasint=$arreasint+$value->int_amount;
        $arreascount++;
      }

    }
    if($date1< $date2)
    $delay_date=intval($dates)-intval($loan_data->grace_period);
    else
    $delay_date=0;


    if($delay_date >0)
    {
      $delay++;

    }
    else
    {
      $ontime++;
    }
  }}

  $totpay=$ontime+$delay;
  if($totpay>0)
  $payeve=($ontime/$totpay)*100;
  else $payeve=0;
  $b='';
$b=$b.' <h3> </h3>
          <table class="table "   border="1">
         <tr  bgcolor="#caf5f7"><th colspan="6"><h2>Loan Details</h2></th></tr>
          <tbody> <tr>
          <th scope="row">Loan Number</th><td> '.$loan_data->loan_number.' &nbsp; </td><th  align="right">Loan Status</th><td>'.$loan_data->loan_status.'</td>

            <th scope="row">Contract Date</th><td>'.$loan_data->loan_date.'</td>
           </tr>
              <tr class="table-bordered">
          <th scope="row">Monthly Rental</th><td align="right">'.number_format($loan_data->loan_installment_value,2).' &nbsp; </td><th  >Period</th><td align="right">'.$loan_data->total_period.'</td> <th  >Interest</th><td align="right">'.$loan_data->interest_rate.'</td>
           </tr>
            <tr class="table-bordered">
          <th scope="row">Capital</th><td  align="right">'.number_format($paydata->totcap_amount,2) .' &nbsp; </td> </td><th scope="row" colspan="4"></th>
           </tr>';
$b=$b.'  <tr class="table-bordered">
          <th scope="row">Paid Capital</th><td  align="right">'.number_format($paydata->totcap_amount,2) .' &nbsp; </td><th  >Paid Interest</th><td align="right">'.number_format($paydata->totint_amount,2) .'</td> <th  >Paid Total</th><td align="right">'.number_format($paydata->totpay_amount,2).'</td>
           </tr>
            <tr class="table-bordered info">
          <th scope="row">Balance Capital</th><td  align="right"> '.number_format($bal_cap,2) .' &nbsp; </td> </td><th scope="row" colspan="4"></th>
           </tr> ';
           $method="";
           if($loan_data->payment_method=='1'){
             $method= "Deduct From Bank";
           }else if($loan_data->payment_method=='2'){
             $method= "Dated Cheque Issued";
           }else if($loan_data->payment_method=='3'){
             $method= "Post Dated Cheque";
           }
          $b=$b.' <tr class="table-bordered">
      <th scope="row">Settlement Method</th><td  align="right">'.$method.'  </td></tr>';
          $b=$b.'</table>';
          $b=$b.'	<h4>
                     </h4>

<table class="table table-bordered"  border="1">   <tr><th colspan="9"  bgcolor="#caf5f7"><h2>Payment History</h2></th></tr><tr bgcolor="#cfd0d0"><th>ID</th><th> Paid Capital</th><th> Paid Interest</th><th> Total Pay Amount</th><th>Payment Type</th><th>Payment Date</th><th>Receipt No </th><th>Receipt Date </th></tr>';
if($paydetails){
$i=0;
$pay_type='';
foreach ($paydetails as $key => $value) {
 $i++;
 if($value->pay_type=='installment'){
   $pay_type="Installment";
 }else if($value->pay_type=="capital_payment"){
   $pay_type="Capital Payment";
 }
 $b=$b.' <tr ><td>'.$i.'</td>';
 $b=$b.' <td>'.number_format($value->cap_amount,2) .'</td>';
 $b=$b.' <td>'.number_format($value->int_amount,2) .'</td>';
 $b=$b.'  <td>'.number_format($value->pay_amount,2) .'</td>';
 $b=$b.'   <td>'.$pay_type.'</td>';
 $b=$b.'   <td>'.$value->pay_date.'</td>';
 $b=$b.'     <td>'.$value->voucher_id.'</td>';
 $b=$b.'  <td></td></tr>';
}
}

         						    header("Content-type: application/vnd.ms-excel");
         	header("Content-Disposition: attachment;Filename=Loan_details.xls");
         	echo $b;
