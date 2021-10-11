
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
        window.location="<?=base_url()?>index.php/accounts/entrymaster/updateprintlist";
        window.close();
    }
</script>
<style>
    #receipt{


    }
    .address{
        font-size:10px;
    }
</style>

<body onload="printfunction()">
<?php
$currency = $this->config->item('account_currency_symbol');
//echo count($entry_data);
foreach ($entry_data as $row)
{// print_r($row);
    $s=num2words($row->dr_total);

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
    ?>
    <div id="receipt" style="width:1000px;height:600px;text-align:center;">
        <table width="900" align="center"  border="0" cellpadding="0" cellspacing="0">
            <tr><td rowspan="3"><img src="<?=asset_url()?>images/reporttop.png"  width="900"/>
            <tr></tr>
        </table>
        <br />
        <table width="80%" style="font-weight:bold" align="center"><tr><td align="left">Receipt No : <? echo $year.'/'.$row->RCTNO?></td><td align="right"> Receipt Date :  <?=$row->date?></td></tr>
        </table>
        <br /> <br />
        <table width="80%" align="center">

            <tr height="30"><td align="left" width="150">Recieved From</td><td width="10">:</td><td align="left"><?=$row->rcvname?></td></tr>
            <tr height="30"><td align="left">The Amount Received</td><td  width="10">:</td><td align="left"><?=$value?></td></tr>
            <tr height="30"><td align="left">Reason</td><td  width="10">:</td><td align="left"><?=$row->narration?></td></tr>
            <tr height="30"><td align="left">Cheque No</td><td  width="10">:</td><td align="left"><?=$row->CHQNO?></td></tr>
            <tr height="30"><td align="left">Rs</td><td  width="10">:</td><td align="left"><?=number_format($row->dr_total, 2, '.', ',')?></td></tr>
        </table>
        <div style="margin-left:600px; text-align:center">.....................................
            <br />Signature & Designation</div>
    </div>
    <br /> <br /> <br /> <br /> <br />
    <?
}
?>

</body>
</html>
