
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


$date=$this->config->item('account_fy_start');
$year= substr($date,0,4);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Print -Entry Number</title>
    <?php echo link_tag(asset_url() . 'images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
</head>
<? if($reprint != ''){?>
<script>
    function printfunction()
    {
    	window.print() ;
		setTimeout(function(){
	 		window.location="<?=base_url()?>index.php/accounts/paymentvouchers/reprint_newlist";
    		window.close();
		}, 300);
    }
</script>
<? }else {?>
<script>
    function printfunction()
    {
     	window.print() ;
		setTimeout(function(){
    	//	window.location="<?=base_url()?>index.php/accounts/payments/updateprinone/<?=$id?>/<?=$chqno?>";
    		window.close();
		}, 300);
    }
</script>
<? }?>
<style>
    #receipt{


    }
    .address{
        font-size:10px;
    }
</style>

<body onload="printfunction()" style="margin-left:180px;">

<?php
$currency = $this->config->item('account_currency_symbol');
//echo count($entry_data);
foreach ($entry_data as $chqequedata)
{// print_r($row);
    $s=num2words($chqequedata->dr_total);

    $array=explode(' and ',$s);
    //print_r( $array);
    $value="";
    if(count($array)==1)
    {
        $value=$array[0]." Rupees Only";
    }
    else
    {
        $value=$array[0]." Rupees and ".$array[1];
    }
    $chequedate=$chqequedata->date;
    $arr = Array();

    for($i=0;$i<strlen($chequedate);$i++){
        $arr[$i]=substr($chequedate,$i,1).'&nbsp;&nbsp;';
    }
    ?> 
  <div style="width:100px; font-size:14px; position:absolute; margin-top:440px; margin-left:180px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
VALID FOR 180

    </div>
    <? if(strtoupper(trim($chqequedata->ac_pay))=="YES"){?>
       <div style="width:100px; font-size:10px; position:absolute; margin-top:310px; margin-left:180px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
___________________
&nbsp;&nbsp;&nbsp;A/C PAYEE ONLY
-----------------------------

    </div><? }?>
     <div style="width:240px; font-size:13px; position:absolute; margin-top:90px; margin-left:100px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;Home Lands Holding (Pvt) Ltd<br /><br /><br />
<? if($chqequedata->authorized_only=='YES'){?>
------------------------------------------------------<br />
Authorised Signature&nbsp;&nbsp&nbsp;&nbsp;Authorised Signature
<? }
 else {?>
------------------------------------------------------<br />
Director&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorised Signature
<? }?>


    </div>
     <div style="width:200px; font-size:13px; position:absolute; margin-top:720px; margin-left:-48px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
	<?=date('d-m-Y')?>
    </div>
    <div style="width:200px; font-size:12px; position:absolute; margin-top:720px; margin-left:-10px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
	<span style="line-height:20px;"><?=wordwrap($chqequedata->CHQNAME,20,"<br>\n")?></span>
    </div>
    
      <div style="width:170px; font-size:12px; position:absolute; margin-top:730px; margin-left:40px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
  	<span style="line-height:10px;"><?=substr($chqequedata->narration, 0, 50)?></span><br />
	<span style="line-height:20px;"><?=$voucher_ncode;?></span>
    </div>
    
     <div style="width:200px; font-size:12px; position:absolute; margin-top:640px; margin-left:110px; transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */

  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">
	<span style="line-height:20px;"><?=number_format($chqequedata->dr_total, 2, '.', ',')?></span>
    </div>
    
    <div id="receipt" style="margin-top:238px; position:absolute; margin-left:-255px;
    
    transform: rotate(-90deg);

  /* Legacy vendor prefixes that you probably don't need... */
&
  /* Safari */
  -webkit-transform: rotate(-90deg);

  /* Firefox */
  -moz-transform: rotate(-90deg);

  /* IE */
  -ms-transform: rotate(-90deg);

  /* Opera */
  -o-transform: rotate(-90deg);

  /* Internet Explorer */
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);">	
    <table>
    <tr><td style="font-size:14px; padding-left:0.1in;" width="40"></td>
    <td valign="top"style="padding-left:10px; ">
                <table cellpadding="0" cellspacing="0"  style="margin-top:0; width:6in;"><tr><td align="right" style="font-size:18px; padding-right:7px;" colspan="4"><? echo '&nbsp;'. $arr[8].'&nbsp;'.$arr[9].'&nbsp;&nbsp;'.$arr[5].'&nbsp;&nbsp;'.$arr[6].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arr[2].'&nbsp;&nbsp;'.$arr[3];

                            ?></td></tr>
                    <tr><td height="17" colspan="4"></td></tr>
                    <tr><td colspan="2"  height="40" ><div style="position:absolute; margin-top:-10px; margin-left:-20px;"><?=$chqequedata->CHQNAME?></div></td></tr><br />
                    <tr><td style="line-height:25px; width:3.5in" ><div style="position:absolute; margin-top:-0px; margin-left:-20px; max-width:350px;"><?=$value?></div></td><td valign="bottom" style="font-size:16px; padding-top:20px; padding-left:.6in;"><div style="position:absolute; margin-top:18px;"><?=number_format($chqequedata->dr_total, 2, '.', ',')?></div></td></tr></table></td></tr></table>
</div>

    <?
}
?>


</body>
</html>
