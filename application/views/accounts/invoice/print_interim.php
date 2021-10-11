<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Print - Interim Payment Certificate</title>
    <?php echo link_tag(asset_url() . 'images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <link type="text/css" rel="stylesheet" href="<?php echo asset_url(); ?>css/printentry.css">
</head>
<script>
    function printfunction()
    {
     	window.print() ;
      	window.close();
    }
</script>
<body onload="printfunction()" style="border:2px solid #000000; padding:20px;">
	<div id="receipt" style="text-align:left; padding-left:-30px; font-size:12px;">
		<img src="<?=base_url()?>media/images/logo.png" style="width:200px;">
        
   		<p><strong>PROJECT: <?=$project->project_name?></strong></p>
        
        <div style="width:100%; border:1px solid #000000; padding: 5px 0px;" align="center"><strong>INTERIM PAYMENT CERTIFICATE</strong></div>
        <br />
        <p align="right"><strong>Date: <?=date('Y-m-d')?></strong></p>
        <br />
        <table width="100%" border="0" cellspacing="10" cellpadding="0">
          <tr>
            <td width="30%">SUPPLIER/SUBCONTRACTOR</td>
            <td width="5%">&nbsp;</td>
            <td><div style="border:1px solid #000000; padding: 5px 10px; text-transform:uppercase;"><?=$invoice->first_name?> <?=$invoice->last_name?></div></td>
          </tr>
          <tr>
            <td>WORK DESCRIPTION</td>
            <td>&nbsp;</td>
            <td><div style="border:1px solid #000000; padding: 5px 10px;"><?=$invoice->note?></div></td>
          </tr>
          <tr>
            <td>BILL NO</td>
            <td>&nbsp;</td>
            <td><div style="border:1px solid #000000; width:50%; padding: 5px 10px;"><?=$invoice->inv_no?></div></td>
          </tr>
          <tr>
            <td>CONTRACT SUM</td>
            <td>&nbsp;</td>
            <td><div style="border:1px solid #000000; width:50%; padding: 5px 10px;">Rs.<!--<?=number_format($invoice->total,2)?>--></div></td>
          </tr>
         <!-- <tr>
            <td>MOBILIZATION ADVANCE PAID</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>-->
        </table>
        <br />
        <?
        $total_pay = $tot_confirmed_payments + $tot_pending_payments;
		$retention = $invoice->total * 0.10;
		?>
        <table width="100%" border="1" cellspacing="0" cellpadding="5">
          <tr style="height:40px;">
            <th>&nbsp;</th>
            <th width="20%" style="text-align:center;"><strong>CUMALATIVE VALUE</strong></th>
            <th width="20%" style="text-align:center;"><strong>PAYABLE VALUE</strong></th>
            <th width="20%" style="text-align:center;"><strong>CUMALATIVE VALUE C/F</strong></th>
          </tr>
          <tr>
            <td>WORK DONE</td>
            <td align="right"></td>
            <td align="right"><?=number_format($invoice->total,2);?></td>
            <td align="right"><?=number_format($invoice->total,2);?></td>
          </tr>
          <tr>
            <td>RETENTION 10%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">(<?=number_format($retention,2);?>)</td>
          </tr>
          <tr>
            <td>PREVIOUS PAYMENT DEDUCTION</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">(<?=number_format($total_pay,2);?>)</td>
          </tr>
          <tr>
            <td>SUB TOTAL - SUPPLY VALUE</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><?=number_format($invoice->total - $total_pay - $retention,2);?></td>
          </tr>
          <tr>
            <td>INPUT V.A.T @ 8%</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">-</td>
          </tr>
          <tr>
            <td><strong>SUB TOTAL GROSS VALUE</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong><?=number_format($invoice->total - $total_pay - $retention,2);?></strong></td>
          </tr>
          <tr>
            <td><strong style="font-size:14px;">NET VALUE PAYABLE</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong style="font-size:14px;"><?=number_format($invoice->total - $total_pay - $retention,2);?></strong></td>
          </tr>
        </table>
		<br /><br /><br /><br /><br /><br />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center">..................................<br />Checked &amp; Prepared by<br />Quantity Surveyor</td>
            <td align="center">.............................<br />Checked by<br />Snr. Quantity Surveyor</td>
            <td align="center">.............................<br />Certified by<br />AGM - Development</td>
            <td align="center">...........................<br />Approved by<br />Snr. AGM (A&amp;O)</td>
          </tr>
        </table>

	</div>
</body>
</html>
