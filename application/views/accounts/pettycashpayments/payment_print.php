<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:100%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
.padding{
	margin-bottom: 10px;
}
.padding-withtop{
	margin-bottom: 10px;
	margin-top: 25%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	  setTimeout(function(){
	   window.close();
	   	},100);
}
</script>
<body onLoad="print_function()">
 <div id="receipt" style=" width:100%;height:650px;margin-left:10px;">
        <h3><?=companyname?></h3><span style="top:5px; position:relative" >
        <h5 ><?=address?><br /><?=web?> &nbsp; Tel :<?=telephone?> &nbsp;Fax: <?=fax?></h5></span>


<br>
<table class="table">

<tr>
<th width="75%"></th><th width="10%">PV No</th><td width="2%">:</td><td><?=$settledata->serial_number?></td>
</tr>
<tr>
<th width="75%"></th><th width="10%">Date</th><td width="2%">:</td><td> <?=$settledata->paid_date?></td>
</tr>

</table>
 <h4 align="center">CASH PAYMENT VOUCHER</h4><br>
  <table class="table">

  <tr>
 <th width="15%">Payable To</th><td width="2%">:</td><td>
 <? if($settledata->sup_name)
 echo $settledata->sup_name;
 else
 echo $settledata->emp_no.'-'.$settledata->initial.' '.$settledata->surname;
 ?>
</td>
 </tr>

 </table>

 <? if($list){?>

 <table class="table table-bordered" style='width:90%;'>
 <tr><th>Description</th><th>Account</th><th>Amount</th></tr>

 <? $tot=0; foreach($list as $raw){$tot=$tot+$raw->amount;?>
 <tr>

  <td><? if($raw->project_name){echo $raw->project_name." - ";}?>  <? if($raw->task_name){echo $raw->task_name." - ";}?>  <?=$raw->paymentdes?></td>
	<td><?=get_ledger_name($raw->ledger_id)?></td>
  <td align="right"><?=number_format($raw->amount,2)?></td>

 </tr>

 <? }?>
 <tr style="font-weight:bold">
 <td>Total</td>
    <td></td>
     <td align="right"><?=number_format($tot,2)?></td>

 </tr>
 </table>



 <? }?>
 <table class="table padding-withtop">

 <tr >
 <td width="30%">Amount in words</td><td colspan="2"><input type="text" style='width:90%;' value="<? echo num2words($tot);?>"></td>
 </tr>
 <tr class="padding">
 <td width="30%">Ledger Account</td><td colspan="2"><input type="text" style='width:90%;' value="<?=$settledata->name?>"></td>
 </tr>
</table>
<table class="table padding">
 <tr>
 <td width="15%">Paid By Cash </td>
 <td width="15%"><input type="text" style='width:60%;'></td>
 <td width="15%">Bank</td>
 <td width="15%"><input type="text" style='width:60%;'></td>
 <td width="40%" colspan="2"></td>
</tr>
 <tr class="padding">
 <td width="15%">Cheque</td>
 <td width="15%"><input type="text" style='width:60%;'></td>
 <td width="15%">Cheque No</td>
 <td width="15%"><input type="text" style='width:60%;'></td>
 <td width="15%">Cheque No Date</td>
 <td width="25%"><input type="text" style='width:90%;'></td>
 </tr>
</table>
	  <table class="table padding">

			<tr >
			<td width="30%"><center>&nbsp;&nbsp;&nbsp;</center></td>
			<td width="30%"><center>&nbsp;&nbsp;&nbsp;</center></td>
			<td width="40%"><center>&nbsp;&nbsp;&nbsp;</center></td>
			</tr>
<tr >
<td width="30%"><center>...................................</center></td>
<td width="30%"><center>...................................</center></td>
<td width="40%"><center>...................................</center></td>
</tr>
<tr class="padding">
<td width="30%"><center>Prepared By</center></td>
<td width="30%"><center>Checked By</center></td>
<td width="40%"><center>Approverd By</center></td>
</tr>

 </table>
</hr>
I hereby acknowledge receipt of payment
<table class="table">

<tr>
<td width="50%">Name : ..............................................</td>
<td width="50%">Nic No :..............................................</td>
</tr>
<tr>
<td width="50%">Signature : ..............................................</td>
<td width="50%">Date :..............................................</td>
</tr>
</table>

  </div></body>
	<?
	function num2words($num, $c=1) {
	    $ZERO = 'zero';
	    //$num='100000.908';

	    $MINUS = 'minus';
	    $lowName = array(
	        /* zero is shown as "" since it is never used in combined forms */
	        /* 0 .. 19 */
	        "", "One", "Two", "Three", "Four", "Five",
	        "Six", "Seven", "Eight", "Nine", "Ten",
	        "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen",
	        "Sixteen", "Seventeen", "Eighteen", "Nineteen");

	    $tys = array(
	        /* 0, 10, 20, 30 ... 90 */
	        "", "", "Twenty", "Thirty", "Forty", "Fifty",
	        "Sixty", "Seventy", "Eighty", "Ninety");

	    $groupName = array(
	        /* We only need up to a quintillion, since a long is about 9 * 10 ^ 18 */
	        /* American: unit, hundred, thousand, million, billion, trillion, quadrillion, quintillion */
	        "", "Hundred", "Thousand", "Million", "Billion",
	        "Trillion", "Quadrillion", "Quintillion");

	    $divisor = array(
	        /* How many of this group is needed to form one of the succeeding group. */
	        /* American: unit, hundred, thousand, million, billion, trillion, quadrillion, quintillion */
	        100, 10, 1000, 1000, 1000, 1000,1000,1000) ;
	    $num = str_replace(",","",$num);

	    $num = number_format($num,2,'.','');

	    $cents = substr($num,strlen($num)-2,strlen($num)-1);
	    $num = (int)$num;

	    $s = "";
	    if ( $num == 0 ) $s = $ZERO;
	    $negative = ($num < 0 );
	    if ( $negative ) $num = -$num;
	    // Work least significant digit to most, right to left.
	    // until high order part is all 0s.
	    for ( $i=0; $num>0; $i++ ) {
	        $remdr = (int)($num % $divisor[$i]);
	        $num = $num / $divisor[$i];

	        // check for 1100 .. 1999, 2100..2999, ... 5200..5999
	        // but not 1000..1099,  2000..2099, ...
	        // Special case written as fifty-nine hundred.
	        // e.g. thousands digit is 1..5 and hundreds digit is 1..9
	        // Only when no further higher order.
	        if ( $i == 1 /* doing hundreds */ && 1 <= $num && $num <= 1	 ){
	            if ( $remdr > 0 ){
	                $remdr = ($num * 10);
	                $num = 0;
	            } // end if
	        } // end if
	        if ( $remdr == 0 ){
	            continue;
	        }
	        $t = "";
	        if ( $remdr < 20 ){
	            $t = $lowName[$remdr];
	        }
	        else if ( $remdr < 100 ){
	            $units = (int)$remdr % 10;
	            $tens = (int)$remdr / 10;
	            $t = $tys [$tens];
	            if ( $units != 0 ){
	                $t .= "-" . $lowName[$units];
	            }
	        }else {
	            // echo "oooo".$remdr."****";
	            $t = num2words($remdr , 1);
	        }
	        $s = $t." ".$groupName[$i]." ".$s;
	        $num = (int)$num;
	    } // end for
	    $s = trim($s);
	    if ( $negative ){
	        $s = $MINUS . " " . $s;
	    }
	    //  if ($c == 1) $s .= " and $cents/100";
	    //$s .= " Rupees";
	    if ($c == 1) {
	        if ($cents == 0) { $s .= " "; } else {
	            if($cents<20)
	            {$cents=(int)$cents;
	                $centavos = $lowName[$cents];
	                $diez_centavos ="";
	            }
	            else
	            {
	                $pence = (int)substr("$cents",1);
	                $centavos = $lowName[$pence];
	                $dimes = (int)substr("$cents",0,1);
	                $diez_centavos = $tys[$dimes];
	            }
	            $s .= " and $diez_centavos $centavos Cents Only";
	        }
	    }
	    return $s;
	}


	?>
