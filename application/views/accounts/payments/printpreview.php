
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
    <link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
</head>
<script>
    function printfunction()
    {
        window.print() ;
        window.location="<?=base_url()?>index.php/accounts/payments/updateprintlist";
        dwindow.close();
    }
</script>
<style>
    #receipt{


    }
    .address{
        font-size:10px;
    }
    .pagebreak { page-break-before: always; }
</style>

<body onload="printfunction()">
<?php
$currency = $this->config->item('account_currency_symbol');
//echo count($entry_data);
$count=0;
foreach ($entry_data as $chqequedata)
{// print_r($row);
    $count++;
    $s=num2words($chqequedata->dr_total);

    $array=explode(' and ',$s);
    //print_r( $array);
    $value="";
    if(count($array)==1)
    {
        $value=$array[0]."  Only";
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
    ?> <div id="receipt" style="width:900px; <? if($count==1){?> margin-top:-25px;<? }else{?> margin-top:-20px; <? }?> ">
    <table ><tr><td style=" font-size:14px; padding-left:10px;" width="200">
                <br /><br /><br /><?=$chqequedata->CHQNAME?><br /><br /><?=number_format($chqequedata->dr_total, 2, '.', ',')?><br /><br /><?=$chqequedata->date;?><br /><br />
                <? if(strlen($chqequedata->narration)>28) {echo substr($chqequedata->narration,0,28);
                    echo '<br>'.substr($chqequedata->narration,28,28);

                }else echo $chqequedata->narration;?></td><td valign="top" style="padding-left:10px;" >
                <table width="640" cellpadding="0" cellspacing="0" style="margin-top:0"><tr><td align="right" style="font-size:18px" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo  $arr[8].'&nbsp;'.$arr[9].'&nbsp;'.$arr[5].'&nbsp;'.$arr[6].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arr[2].'&nbsp;&nbsp;'.$arr[3];

                            ?></td></tr>
                    <tr><td height="9"></td></tr>
                    <tr><td width="20">&nbsp;</td><td colspan="2" height="57">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <?=$chqequedata->CHQNAME?></td></tr><br />
                    <tr><td width="20">&nbsp;</td><td width="408" style="line-height:25px;" >&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  <?=$value?></td><td valign="middle" style="font-size:16px;padding-top:18px;"> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<?=number_format($chqequedata->dr_total, 2, '.', ',')?></td></tr></table></td></tr></table>
</div>
    <div class="pagebreak"> </div>
    <?
}
?>


</body>
</html>
