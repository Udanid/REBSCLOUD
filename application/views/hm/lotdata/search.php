
	<script type="text/javascript">

function load_printscrean1(id)
{
			window.open( "<?=base_url()?>hm/lotdata/print_report/"+id);
	
}
function load_pdf(id)
{
			window.open( "<?=base_url()?>hm/lotdata/load_pdf/"+id);
	
}
function load_excel(id)
{
			window.open( "<?=base_url()?>hm/lotdata/load_excel/"+id);
	
}
</script>
 <h4><?=$details->project_name?> Block Out Plans<span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span>
  <span style="float:right"> <a href="javascript:load_printscrean1('<?=$details->prj_id?>')"> <i class="fa fa-print nav_icon"></i></a>
           <a href="javascript:load_excel('<?=$details->prj_id?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>

</span> 
 </h4>
<br />
<?
//echo project_expence($details->prj_id);
$count=0;
 if($planlist){
	$count=1;
?>
 <div class="table-responsive bs-example widget-shadow"  style="font-size:80%">
<table class="table"> <thead>

 <tr> <th>Lot Number</th>  <th>Land Extent</th><th>Salable Extent </th><th>Perch Price </th> <th>Sale Value </th><th>Cost </th><th>Gross Profit </th><th>Lot Status </th><th>Sale Type </th></tr> </thead>
 
 <? $totsale=0; $totcostofsale=0;$grostotprofit=0;$totext=0; $selextend=0;
 foreach($planlist as $rw){?>
 
 <tr class="warning"  style="font-weight:bold"><td colspan="4">Plan No :<?=$rw->plan_no?></td><td  colspan="5">Plan Sequence : <?=$rw->plan_sq?></td></tr>


<? $c=0;$class="";
foreach($lotlist[$rw->plan_sq] as $row){
	//if($row->res_status!='REPROCESS'){
	if($row->status=='PENDING')
	$class='info';
	if($row->pay_type=='NEP')
	$class='yellow';
	if($row->res_status=='SETTLED')
	$class='red';
	if($row->pay_type=='PENDING')
	$class='green';
	
	if($row->pay_type=='ZEP')
	$class='purple';
	if($row->pay_type=='EPB')
	$class='brown';
	if(!$row->pay_type)
	{
		if($row->status=='SOLD')
		$class='red';
		
	}
	if($row->price_perch==0)
	$class='';
	if($row->pay_type=='PENDING')
	$paytype='ADVANCE';
	else $paytype=$row->pay_type;
	$totsale=$totsale+$row->sale_val;
	$totext=$row->extend_perch+$totext;
	if($row->price_perch>0)  $selextend=$selextend+$row->extend_perch;
		$totcostofsale=$totcostofsale+$row->costof_sale;
		$grostotprofit=$grostotprofit+($row->sale_val-$row->costof_sale);
		
	?> <tbody> <tr class="<?=$class?>"> 
                        <td scope="row"><?=$row->lot_number?></td>
                         <td><?=$row->extend_perch?>
                         </td>
                         <td> <? if($row->price_perch>0) echo $row->extend_perch; else echo 0;?></td>
                         <td align="right"> <?=number_format($row->price_perch,2)?></td>
                        <td align="right"><?=number_format($row->sale_val,2)?></td> 
                          <td align="right"><?=number_format($row->costof_sale,2)?></td> 
                           <td align="right"><?=number_format($row->sale_val-$row->costof_sale,2)?></td> 
                            <td align="right"><?=$row->status?></td>
                            <td align="right"><?=$paytype?></td> 
                       
                       
                         </tr> </tbody>

<? $count++; }}?>
<tr style="font-weight:bold"><td colspan="1">Total</td><td><?=$totext?></td><td><?=$selextend?></td><td></td><td align="right"><?=number_format($totsale,2)?></td><td align="right"><?=number_format($totcostofsale,2)?></td><td align="right"><?=number_format($grostotprofit,2)?></td></tr>
</table>
</div>
<? }?>
