<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:90%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
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
 <div id="receipt" style=" width:100%;height:650px;text-align:center;">
        <h1><?=companyname?></h1><span style="top:5px; position:relative" >
        <h5 ><?=address?><br /><?=web?> &nbsp; Tel :<?=telephone?> &nbsp;Fax: <?=fax?></h5></span>


<br>
 <h4 align="center">Pettycash Settlment Details </h4><br>
 <table class="table ">
 <tr>
 <th width="15%">Advance Number</th><td width="2%">:</td><td><?=$settledata->adv_code?></td>
 <th width="15%">Advance Date</th><td width="2%">:</td><td><?=$settledata->apply_date?></td>
 </tr>
  <tr>
 <th width="15%">Officer Name</th><td width="2%">:</td><td><?=$settledata->initial?> <?=$settledata->surname?></td>
 <th width="15%">Advanced Amount</th><td width="2%">:</td><td><?=number_format($settledata->amount,2)?></td>
 </tr>
 <tr>
 <th width="15%">Settled Date</th><td width="2%">:</td><td> <?=$settledata->settled_date?></td>
 <th width="15%">Settled Amount</th><td width="2%">:</td><td><?=number_format($settledata->settled_amount,2)?></td>
 </tr>
 
 </table>
 
 <? if($list){?>
 
 <table class="table table-bordered" cellpadding="0" cellspacing="0"   border="1" >
 <tr><th>Ledger Account</th><th>Project Name</th><th>Task Name</th><th>Discription </th><th>Amount </th></tr>
 
 <? $tot=0; foreach($list as $raw){$tot=$tot+$raw->settleamount;?>
 <tr>
 <td><?=get_dr_account_name($raw->settle_entry_id)?></td>
  <td><?=$raw->project_name?></td>
   <td><?=$raw->task_name?></td>
    <td><?=$raw->note?></td>
     <td align="right"><?=number_format($raw->settleamount,2)?></td>
 
 </tr>
 
 <? }?>
 <tr style="font-weight:bold">
 <td>Total</td>
  <td></td>
   <td></td>
    <td></td>
     <td align="right"><?=number_format($tot,2)?></td>
 
 </tr>
 </table>
 
 
 
 <? }?>
  </div></body>