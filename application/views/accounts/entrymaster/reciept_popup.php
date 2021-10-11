
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

<body >

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
    
      <?
		$nonerfund=0;
        $final_payment = false; //Ticket No-2779 | Added By Uvini
		$loan_code=''; $downpayment=0;
		if($fulldata){
			$excess=get_excess_byincomeid($incomdedata->id);//reaccount_helper function
         	$project = $fulldata->project_name;
         	$lot = $fulldata->lot_number;
			if($incomdedata->income_type=='Rental Payment' || $incomdedata->income_type=='EP Settlement' )
			{

                    //Ticket No-2779 | Added By Uvini
                    if($fulldata->loan_status == 'SETTLED')
                    {
                        $final_payment = true;
                    }
					$loan_code=$fulldata->unique_code;
			}
			if($incomdedata->income_type=='Advance Payment' )
			{

					$downpayment=$fulldata->down_payment;
					$nonerfund=$fulldata->non_refund ;
                    //Ticket No-2779 | Added By Uvini
                    if($downpayment == $fulldata->discounted_price)
                    {
                        $final_payment = true;
                    }
			}

        }
		?>


        <? // if($fulldata){?>
        	<!--<p style="text-align:center;"><?=$row->narration?></p>-->
        <? // }
		
		$companydata=get_company_all_data();//companyconfig helper function
		$recipetconfig=get_recipet_configuration();//companyconfig helper function
		
		?>
    <div id="receipt" style="text-align:left; padding-left:-30px; font-size:14px;">
    	<? if($recipetconfig->include_header){?>
			<div style="text-align:center">
            <? if($recipetconfig->include_logo){?>
            <img src="<?=base_url()?>media/images/<?=$companydata->company_logo?>"  height="80"/>
            <? }?>
           
             <h1><?=$companydata->company_name?></h1><span style="top:-15px; position:relative" >
                    <h5 ><?=$companydata->address1?>,<?=$companydata->address2?>,<?=$companydata->address3?><br /><?=$companydata->web	?> &nbsp; Tel :<?=$companydata->hotline?> &nbsp;Fax: <?=$companydata->fax?></h5></span></div>
		<? }
		else
		{?>
        <p style="padding-top:30px;">&nbsp;</p>
        <? }?>

      
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="line-height:18px;">
        	<tr>
            	<td>&nbsp;</td>
                <td rowspan="5" valign="top">
                	<strong>Received with thanks from</strong><br />
                    <?=$cusdata->title?>. <?=$row->rcvname?><br />
					<?=$cusdata->address1?><br />
					<?=$cusdata->address2?><br />
					<?=$cusdata->address3?>
          <? if(isset($second_cus)){?>
            <br /><!--updated by nadee 2747"-->
              <?=$second_cus->title?>. <?=$second_cus->first_name.' '.$second_cus->last_name?><br />
    <?=$second_cus->address1?><br />
    <?=$second_cus->address2?><br />
    <?=$second_cus->address3?>
          <?}?>
                </td>
                <td></td>
                <td width="120"><strong>Receipt No: </strong></td>
                <td width="150"><?=$row->RTCBRN?><?=$row->RCTNO?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td><strong>Reference No: </strong></td>
                <td><?=$row->temp_rctno?></td>
                <td>&nbsp;</td>
            </tr>
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
                <td><? if($lot){ echo $lot; }else{ echo 'N/A';}?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td></td>
                <td></td>
                <td><strong>Project :</strong></td>
                <td><? if($project){ echo $project; }else{ echo 'N/A';}?></td>
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
				$count = 8;$currentnonrefund=0;
				if($ledgers){
			   	$total = count($ledgers);
			   	$numrows = count($ledgers);
				  foreach($ledgers as $raw){
					  if($raw->dc=='D') $bankledger=$raw->ledger_id;
					  if($raw->dc=='C'){ if($raw->name=='Trade Debtor EP' || $raw->name=='Trade Debtor ZEP' || $raw->name=='EPB Debtors Lands'){ $name='Rental Payment'; }else{ $name=$raw->name; }
						  if($raw->name=='Advance Received from Customers for Lands')
						  {
							  $balance=0;
							   $prevdown=$downpayment-$raw->amount+$excess;

							  if($prevdown>0)
							  {
								 if($prevdown>$nonerfund)
								 {
									$currentnonrefund=0;
								 }
								else
								{
								 $currentnonrefund=$nonerfund-$prevdown;

								}
							  }
							  else
							  $currentnonrefund=$nonerfund;

							  if($raw->amount >= $currentnonrefund)
							  {
								  $currentnonrefund=$currentnonrefund;
								  $balance=$raw->amount-$currentnonrefund;
							  }
							  else
							  {
								  $currentnonrefund=$raw->amount;
								 $balance=0;
							  }
							   $balance=$balance- $excess;
							    $thispayment=$balance+$currentnonrefund;
							  if($thispayment>0)
							  {?>
							  <tr>
								<td>
                                    <!--Ticket No-2779 | Added By Uvini -->
                                <?if($final_payment){?>
								<td colspan="3">Final Payment</td>
                                <?}else{?>
                                <td colspan="3">Advance Payment</td>
                                    <?};?>
								<td width="18%" align="right" valign="top" style="padding-right:5px;"><?=number_format($thispayment, 2, '.', ',')?></td>
								<td></td>
							</tr>

							  <? $numrows--;
							  }
							
							

						  }
						  else{
						  ?>
							<tr>
								<td>
								<!--Ticket No-2779 | Added By Uvini -->
                                <? if($final_payment && $name=='Rental Payment'){?>
                                    <td colspan="3">Final Payment</td>
                                <? }else{?>
                                    <td colspan="3"><?=$name?>&nbsp;<? if($loan_code!=''){ echo $loan_code; } else if($fulldata){ echo $fulldata->res_code;}?></td>
                                    <? };?>
                                    
                                 <? if($name=='Rental Payment'){?><!--Ticket No-2772 | Added By Uvini-->
                                    <td width="18%" align="right" valign="top" style="padding-right:5px;"><?=number_format(($raw->amount-$excess), 2, '.', ',')?></td>
                                    <? }else{?>
                            <td width="18%" align="right" valign="top" style="padding-right:5px;"><?=number_format($raw->amount-$excess, 2, '.', ',')?></td>
                            <? };?>
								<td></td>
							</tr>
				  <? 				$numrows--;
								  $project = '';
								  $lot =  '';$loan_code='';$advcount=0;
						  }
						}
						$count--;
					}

                             if($excess>0)//Ticket No-2772 | Added By Uvini
                              {?>
                                  <tr>
                                    <td>
                                    <td colspan="3">Excess Pay amount</td>
                                    <td width="18%" align="right" valign="top" style="padding-right:5px;"><?=number_format($excess, 2, '.', ',')?></td>
                                    <td></td>
                                </tr>
                             <?}
				}
			?>
            <tr>
                <td></td>
                <td>
                	 <? if($recipetconfig->nonrefund_include){?>
                	
					  <? if($currentnonrefund>0)
                      {?>
                    	  <strong>Nonerefundable Amount</strong>: <?=number_format($currentnonrefund,2)?><br />
                      <? $count--;
                      }?>
                              
                  <? }?>
                  <? if($recipetconfig->loan_balanceinclude){?> 
                	<? if($loanbalancedata){
						echo '<br />';
						if($loanbalancedata['bal_cap']){
					?>
                    	<strong>Balance Capital</strong>: <?=number_format($loanbalancedata['bal_cap'],2)?><br />
                    <?
						$count--;
						}
						if($loanbalancedata['bal_int']){
					?>
                    	<strong>Balance Interest</strong>: <?=number_format($loanbalancedata['bal_int'],2)?><br />
                    <?
						$count--;
						}
						if($loanbalancedata['arr_int']){
					?>
                    	<strong>Arrears Rental Amount</strong>: <?=number_format($loanbalancedata['arr_int'],2)?>
         			<? $count--;
						}
						}?>
                   <? }?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td>
                	<br /><br />
                	<?

					$bankcode=get_account_bank_code($bankledger);
					if($bankcode)
					echo 'Deposited to ' .getbank_details($bankcode) .' On '.$incomdedata->income_date.'<br>';

					if($row->narration){
						echo $row->narration;
						$count--;
						$count--;
						$count--;
					}



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
                <td><strong>Mode of Collection</strong></td>
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
				<td colspan="2"></td>
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
