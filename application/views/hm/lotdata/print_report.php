<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
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
	window.print();
	//window.close();
}
</script>
<body onLoad="print_function()">
<div class="row">
 <h4><?=$details->project_name?> Blockoout Plans
 </h4>
<br />
<?
//echo project_expence($details->prj_id);
$count=0;
 if($planlist){
	$count=1;
?>
 <div class="table-responsive bs-example widget-shadow"  >
<table class="table"> <thead>

 <tr> <th>Lot Number</th>  <th>Land Extent</th><th>Selable Extent </th><th>Perch Price </th> <th>Sale Value </th><th>Cost </th><th>Gross Profit </th></tr> </thead>
 <? foreach($planlist as $rw){?>
 
 <tr class="warning"  style="font-weight:bold"><td colspan="2">Plan No :<?=$rw->plan_no?></td><td  colspan="5">Plan Sequense : <?=$rw->plan_sq?></td></tr>


<? $c=0;$totsale=0; $totcostofsale=0;$grostotprofit=0;$totext=0; $selextend=0;
foreach($lotlist[$rw->plan_sq] as $row){
	$totsale=$totsale+$row->sale_val;
	$totext=$row->extend_perch+$totext;
	if($row->price_perch>0)  $selextend=$selextend+$row->extend_perch;

		$totcostofsale=$totcostofsale+$row->costof_sale;
		$grostotprofit=$grostotprofit+($row->sale_val-$row->costof_sale);
	?> <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <td scope="row"><?=$row->lot_number?></td>
                         <td><?=$row->extend_perch?>
                         </td>
                         <td> <? if($row->price_perch>0) echo $row->extend_perch; else echo 0;?></td>
                         <td align="right"> <?=number_format($row->price_perch,2)?></td>
                        <td align="right"><?=number_format($row->sale_val,2)?></td> 
                          <td align="right"><?=number_format($row->costof_sale,2)?></td> 
                           <td align="right"><?=number_format($row->sale_val-$row->costof_sale,2)?></td> 
                       
                       
                         </tr> </tbody>

<? $count++; }}?>
<tr style="font-weight:bold"><td colspan="1">Total</td><td><?=$totext?></td><td><?=$selextend?></td><td></td><td align="right"><?=number_format($totsale,2)?></td><td align="right"><?=number_format($totcostofsale,2)?></td><td align="right"><?=number_format($grostotprofit,2)?></td></tr>
</table>
</div>
<? }?>
