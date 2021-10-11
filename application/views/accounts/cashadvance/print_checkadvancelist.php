<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Cash Requistoin Form</title>
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
        
        <h3 align="center">Cash Requistoin Form</h3>
         <h4 >Cash Requistion for Daily  Expences <span  style="float:right">Date : <?=date('Y-m-d')?></span></h4>
        <table width="100%" border="1" cellspacing="0" cellpadding="5"><tr>
        <th>No</th>
         <th>EPF No</th>
         <th>Project Officer</th>
           <th>Full Name</th>
           <th>Account Number</th>
           <th>Project Name</th>
             <th>Amount</th></tr>
        
        <? if($details){ $count=1;
			foreach($details as $raw){?>
     <tr>   <th><?=$count?></th>
         <th><?=$raw->emp_no?></th>
         <th><?=$raw->surname?></th>
           <th> <?=$raw->initial?> <?=$raw->surname?></th>
           <th><?=$raw->account_no?></th>
           <th><?=$raw->project_name?></th>
             <th align="right"><?=number_format($raw->amount,2)?></th></tr>
        <? $count++; }}?>
        
        </table>
        	<br /><br /><br /><br /><br /><br />
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center">..................................<br />Checked &amp; Prepared by<br /></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">...........................<br />Approved by</td>
          </tr>
        </table>