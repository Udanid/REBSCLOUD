
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
    <title>Print - Entry Number</title>
    <?php echo link_tag(asset_url() . 'images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
</head>
<script>
    function printfunction()
    {
     	window.print() ;
		setTimeout(function(){
			window.location="<?=base_url()?>accounts/entrymaster/update_print/<?=$entrynumber?>";
      		window.close();
		},200);
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
	
	$advanceflag=false;
	$advancedata=get_advance_data_reciept($row->id);//custom helper;
	if($advancedata)
	$advanceflag=true;
    ?>
    <div id="receipt" style="text-align:left; padding-left:-30px; font-size:14px;">
    	<p style="padding-top:30px;">&nbsp;</p>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="line-height:18px;">
        	<tr>
            	<td>&nbsp;</td>
                <td rowspan="5" valign="top">
                	<strong>Received with thanks from</strong><br />
                    <?=$row->rcvname?>
                </td>
                <td></td>
                <td width="120"><strong>Receipt No: </strong></td>
                <td width="150"><?=$row->RTCBRN?><?=$row->RCTNO?></td>
                <td>&nbsp;</td>
            </tr>
            <? if($advanceflag){
                $advance_type = substr($advancedata->serial_number,0,3);
                ?>
             <tr>
            	<td></td>
                <td></td>
                <?if($advance_type == 'ADV'){?>
                <td><strong>Cash Adv No: </strong></td>
                <?}else{?>
                <td><strong>IOU Number: </strong></td>
                <?}?>
                <td><?=$advancedata->serial_number?></td>
                <td>&nbsp;</td>
            </tr>
            
            <? }else {?>
            <tr>
            	<td></td>
                <td></td>
                <td><strong>Reference No: </strong></td>
                <td><?=$advancedata->temp_rctno?></td>
                <td>&nbsp;</td>
            </tr>
            <? }?>
            <tr>
            	<td></td>
                <td></td>
                <td><strong>Date: </strong></td>
                <td><?=date('Y-m-d',strtotime($row->date))?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td><strong>Lot No: </strong></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td><strong>Project :</strong></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td colspan="4"><strong>A sum of Rupees:</strong> <?=num2words($row->rcvamount)?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td colspan="4"><strong>on account of following</strong></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td colspan="3"><em><strong><u>Descriptions</u></strong></em></td>
                <td align="right"><em><strong><u>Amount - Rs</u></strong></em></td>
                <td>&nbsp;</td>
            </tr>
            <? 
				$count = 8;
                $bank_name = '';
                $payment_date = '';
				if($ledgers){
			   	$total = count($ledgers);
			   	$numrows = count($ledgers);
				  foreach($ledgers as $raw){
					  if($raw->dc=='C'){ if($raw->name=='Trade Debtor EP' || $raw->name=='Trade Debtor ZEP' || $raw->name=='EPB Debtors Lands'){ $name='Rental Payment'; }else if($raw->name=='IOU Advance'){$name='IOU Settlement';}else{ if($raw->name == 'Cash Flout - Rs.500,000/-'){$name="IOU Refund";}else if($raw->name==' Cash Advance Receivable'){$name='Cash Advance Settlement';}else{$name=$raw->name;} }?>
						<tr>
                        	<td>
							<td colspan="3"><?=$name?></td>
							<td width="18%" align="right" valign="top" style="padding-right:5px;"><?=number_format($raw->amount, 2, '.', ',')?></td>
                            <td></td>
						</tr>
			  <? 				$numrows--;
							  $project = '';
							  $lot =  '';$loan_code='';$advcount=0;
						}
						$count--;


                        if($raw->dc == 'D'){
                           if($raw->name != 'Cash in Hand Lands'){
                            $bank_code = get_account_bank_code($raw->ledger_id);//reaccount helper
                           $bank_name = '<strong>Deposited Bank:</strong>'.getbank_details($bank_code); //custom helper
                            $payment_date ='<strong>Payment Date:</strong>'.$row->payment_date;
                            }
                        }
					}
				}
			?>
            <tr>
                <td></td>
                <td>
                	<br /><br />
                	<?
					if(!$advanceflag){
					if($row->narration){
						echo $row->narration;
						$count--;
						$count--;
						$count--;
					}}
					?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>

            <?
				for($x = 1;$x <= $count ; $x++){
			?>
            		<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>&nbsp;</td>
                    </tr>	
            <?
				}
			?>
           <tr>
                <td></td>
                <td><?=$bank_name?></strong></td>
            </tr>
            <tr>
                <td></td>
                <td><?=$payment_date?></strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td><strong>Mode of Colelction</strong></td>
                <td></td>
                <td><strong>TOTAL</strong></td>
                <td style="border-top:solid 1px #000000; border-bottom:#000 double; padding-right:5px;" align="right"><?=number_format($row->rcvamount,2)?></td>
                <td>&nbsp;</td>
            </tr>
			<tr>
				<td></td>
				<td><?
						if($row->CHQNO){
                            echo 'Cheque';
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->CHQNO;
                        }elseif($row->rcvmode == 'CSH'){
                            echo 'Cash';
                        }elseif($row->rcvmode == 'DD'){
                            echo 'Direct Diposit';
                        }elseif($row->rcvmode == 'CREDIT CARD'){
                            echo 'Credit Card';
                        }elseif($row->rcvmode == 'DEBIT CARD'){
                            echo 'Debit Card';
                        }elseif($row->rcvmode == 'FT'){
                            echo 'Fund Transfer';
                        }
					?>
                </td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
            <tr>
				<td></td>
				<td><strong>*Cheques are subject to realisation.</strong></td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
            <tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			</tr>
            <tr>
				<td colspan="2"><? if($row->RCTSTATUS == 'PRINT'){?> <span style="color:#F00; font-weight:bold;">DUPLICATE COPY</span><? }?></td>
				<td></td>
				<td colspan="2" align="right"><div align="center">............................................................<br /><strong>Authorised Signatory</strong></div></td>
				<td>&nbsp;</td>
			</tr>
            <tr>
				<td></td>
				<td colspan="4" align="right">For and on behalf of Home Lands Holdings (Pvt) Ltd</td>
				<td>&nbsp;</td>
			</tr>
        </table>
        
        
        
        
       
    </div>

    <?
}
?>

</body>
</html>
