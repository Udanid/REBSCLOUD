
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
	<link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
  </head>
  <script>
    function printfunction(){
	window.print() ;
	  setTimeout(function(){
	   window.close();
	   	},100);

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
	$ci =&get_instance();
	$ci->load->model('common_model');
	$ci->load->model('paymentvoucher_model');
	$ci->load->model('projectpayment_model');


	$currency = $this->config->item('account_currency_symbol');
	//echo count($entry_data);
	foreach($entry_data as $chqequedata){
		// print_r($row);
		$s = num2words($chqequedata->amount);
 		$array = explode(' and ',$s);
 		//print_r( $array);
 		$value = "";

 		if(count($array) == 1){
			$value = $array[0]." Rupees Only";
 		}else{
			 $value = $array[0]." Rupees and ".$array[1];
		} ?>


		<?
        
		$companydata=get_company_all_data();//companyconfig helper function
		$voucherconfig=get_voucher_configuration();//companyconfig helper function
		
		?>
        <div id="receipt" style="height:650px;text-align:center;">
      <? if($voucherconfig->include_header){?>
			<div style="text-align:center">
            <? if($voucherconfig->include_logo){?>
            <img src="<?=base_url()?>media/images/<?=$companydata->company_logo?>"  height="80"/>
            <? }?>
           
             <h1><?=$companydata->company_name?></h1><span style="top:-15px; position:relative" >
                    <h5 ><?=$companydata->address1?>,<?=$companydata->address2?>,<?=$companydata->address3?><br /><?=$companydata->web	?> &nbsp; Tel :<?=$companydata->hotline?> &nbsp;Fax: <?=$companydata->fax?></h5></span></div>
		<? }
		else
		{?>
        <p style="padding-top:30px;">&nbsp;</p>
        <? }?>



          <table width="100%" cellpadding="0" cellspacing="0" style="font-weight:bold" align="center">
          <tr ><td  colspan="3" rowspan="4"  valign="top">CHEQUE/CASH PAYMENT VOUCHER</td>

              <td style="border:1px solid; "  align="left">Voucher Number</td>
              <td  style="border:1px solid; " width="10">:</td>
              <td  style="border:1px solid; "align="left"><? echo $voucher_ncode; ?></td>
            </tr>
            <tr>
              <td align="left"  style="border:1px solid; ">Cheque NO</td>
              <td width="10"  style="border:1px solid; ">:</td>
              <td align="left"  style="border:1px solid; "><? echo $chqequedata->CHQNO; ?></td></tr>
            <tr>

              <td align="left"  style="border:1px solid; ">Date</td>
              <td width="10"  style="border:1px solid; ">:</td>
              <td align="left"  style="border:1px solid; "><? echo date('d-m-Y', strtotime($chqequedata->applydate)); ?></td></tr>
            <?

			 if($chqequedata->ac_pay=='YES')
			$status='A/C Payee';
			else $status='Open';?>

              <tr>
              <td align="left"  style="border:1px solid; ">CHQ Status</td>
              <td width="10"  style="border:1px solid; ">:</td>
              <td align="left"  style="border:1px solid; "><? echo $status; ?></td></tr>
            <tr >
              <td align="left" colspan="6"  style="border:1px solid; ">Payment Details</td></tr>
              <tr>
              <td align="left"  style="border:1px solid;">Payee Name</td>
              <td width="10" style="border:1px solid;">:</td>
              <td align="left"  style="border:1px solid; " colspan="4"><? echo $chqequedata->CHQNAME; ?></td></tr>
              <tr>
       		  <td align="left"  style="border:1px solid;" >Bank</td>
              <td width="10"  style="border:1px solid;">:</td>
              <td align="left"  style="border:1px solid;"  colspan="4"><? echo $bank_name; ?></td>
            </tr>

          </table>
          <br /> <br />

                <table align="center" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: left; min-height:60px; font-size:11px;"  border="1">
				  <tr style="font-weight:bold" height="30">

				    <td>Description</td>
					<td>GL Name </td>
				<!--	<td>Project</td>
                    <td>Payee Name</td>
				-->	<td>Amount</td>
				  </tr>
                <?
				$payment_vouchre_data = $ci->paymentvoucher_model->get_paymentvouchres_ledgers_by_entryid($chqequedata->id);
			    $dataset = $this->Ledger_model->get_ledgerdata_for_vouchers($chqequedata->id, $chqequedata->entry_type);
				$prjpaymentcount=0;
				if($dataset){
					$record_count = 0;
					foreach($payment_vouchre_data as $row){
						$payment_details = $ci->projectpayment_model->get_payment_details($row->voucherid);
						$stamplist=$ci->paymentvoucher_model->get_voucher_stampfeelist($row->voucherid);
						if($stamplist)
						$dis=$stamplist;
						else
						$dis=$row->paymentdes;
						if($dis=='Project Payments')
						{
							if($prjpaymentcount==0)
							{
								$dis=$chqequedata->narration;
								$prjpaymentcount++;
							}
							else $dis='';
						}
						if(count($payment_details)>0){
							$project_details = $ci->projectpayment_model->get_project_details($payment_details['prj_id']);
							$project_name = $project_details['project_name'];
						}else{
							$project_details = $ci->projectpayment_model->get_project_details($row->prj_id);
							if($project_details)
								$project_name = $project_details['project_name'];
							else
								$project_name = '';
						}

						if($dataset)
								foreach($dataset as $ledger){
								 	$ledgername= $ledger->name.'<br>';
								}

						?>

						<tr>

						  <td><?php echo $dis; ?></td>
						  <td><?
								 	echo $ledgername;
								?></td>
						<!--  <td>< ?php echo $project_name; ?></td>
                          <td>< ?php echo  $row->payeename; ?></td>
						-->  <td align="right" ><?php echo number_format($row->amount,2,'.', ','); ?></td>
						</tr>
					<?php
						$record_count++;
						if($record_count == 40){
							break;
						}
					}
				} ?>
                <tr style="font-weight:bold" >
                <td colspan="2"><?=$value?></td>
                <td align="right"> <? echo number_format($chqequedata->amount, 2, '.', ','); ?></td></tr>
                </table>
                <br>
                <div style="text-align:left"><b>Project Name:</b><?=$project_name?></div>
          <br/> <br/>
          <table width="100%" style="font-weight:bold" align="center">

              <tr height="30">
              <td align="cenre"><?=$this->session->userdata('display_name')?>
              <br />................................</td>
               <td  width="10px">&nbsp; </td>
              <td align="left"> <br />...........................................</td>
              <td width="10px">&nbsp; </td>

              <td align="left"> <br />.............................................</td>
            </tr>
             <tr height="30">
              <td align="cenre">Generate By</td>
               <td  width="10px">&nbsp; </td>
              <td align="cenre"> Checked By</td>
              <td width="10px">&nbsp; </td>

              <td align="cenre"> Approved By</td>
            </tr>
            <tr > <td colspan="6">  <hr /></td></tr>
            </table>
<? ?>

<? if($voucherconfig->include_acknowledge){?>
            <table  width="100%"  align="center">
         <tr > <td colspan="6" align="left">  I hereby acknowledge the receipt of above payment</td></tr>
            <tr height="30">
              <td align="left">Name</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
              <td align="left" width="10%"></td>
			  <td align="left">NIC No</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
            </tr>
            <tr height="30">
              <td align="left">Date</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
              <td align="left" width="10%"></td>
			  <td align="left">Signature</td>
              <td width="10">:</td>
              <td align="left">.............................................</td>
            </tr>
             <tr > <td colspan="6">  <hr /></td></tr>
          </table>
         <? }?>
        </div><br /><br /><br /><br />
    <?
	} ?>

  </body>
</html>
