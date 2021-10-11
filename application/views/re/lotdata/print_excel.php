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


</script>
<?
$b='';
$b=$b.' <h4>'.$details->project_name.' Blockoout Plans
 </h4>
<br />';

//echo project_expence($details->prj_id);
$count=0;
 if($planlist){
	$count=1;

 $b=$b.'<table class="table" border="1"> <thead>

 <tr> <th>Lot Number</th>  <th>Land Extent</th><th>Selable Extent </th><th>Perch Price </th> <th>Sale Value </th><th>Cost </th><th>Gross Profit </th><th>Lot Status </th><th>Sale Type </th></tr> </thead>';
 foreach($planlist as $rw){
 
 $b=$b.'<tr class="warning"  style="font-weight:bold"><td colspan="2">Plan No :'.$rw->plan_no.'</td><td  colspan="5">Plan Sequense : '.$rw->plan_sq.'</td></tr>';


 $c=0;$totsale=0; $totcostofsale=0;$grostotprofit=0;$totext=0; $selextend=0;
foreach($lotlist[$rw->plan_sq] as $row){
		if($row->status=='PENDING')
	$bgcolor="#b3e8e9";
	if($row->pay_type=='NEP')
	$bgcolor="#FF6";
	if($row->res_status=='SETTLED')
	$bgcolor="#F66";
	if($row->pay_type=='PENDING')
	$bgcolor="#3F6";
	
	if($row->pay_type=='ZEP')
	$bgcolor="#96F";
	if($row->pay_type=='EPB')
	$bgcolor="#966";
	if(!$row->pay_type)
	{
		if($row->status=='SOLD')
		$bgcolor="#F66";
		
	}
	if($row->price_perch==0)
	$bgcolor='';
	if($row->pay_type=='PENDING')
	$paytype='ADVANCE';
	else $paytype=$row->pay_type;
	
	$totsale=$totsale+$row->sale_val;
	$totext=$row->extend_perch+$totext;
	if($row->price_perch>0)  $selextend=$selextend+$row->extend_perch;

		$totcostofsale=$totcostofsale+$row->costof_sale;
		$grostotprofit=$grostotprofit+($row->sale_val-$row->costof_sale);
	 $b=$b.'<tbody> <tr '.$bgcolor.' > 
                        <td scope="row">'.$row->lot_number.'</td>
                         <td>'.$row->extend_perch.'
                         </td>
                         <td> ';
						 if($row->price_perch>0) $sel= $row->extend_perch; else $sel= 0;
                         $b=$b.$sel.'</td>
                         <td align="right"> '.number_format($row->price_perch,2).'</td>
                        <td align="right">'.number_format($row->sale_val,2).'</td> 
                          <td align="right">'.number_format($row->costof_sale,2).'</td> 
                           <td align="right">'.number_format($row->sale_val-$row->costof_sale,2).'</td> 
						    <td align="right">'.$row->status.'</td> 
							 <td align="right">'.$paytype.'</td> 
                       
                       
                         </tr> </tbody>';

$count++; }}
 $b=$b.'<tr  style="font-weight:bold"><td >Total</td><td>'.$totext.'</td><td>'.$selextend.'</td><td></td><td align="right">'.number_format($totsale,2).'</td><td align="right">'.number_format($totcostofsale,2).'</td><td align="right">'.number_format($grostotprofit,2).'</td></tr>
</table>
';


 header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=PriceList.xls");
	echo $b;
}?>
