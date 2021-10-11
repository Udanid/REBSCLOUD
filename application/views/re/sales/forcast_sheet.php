<? if($salselist){?>
<table class="table" style=" width:100%">
<tr><th> Loan Code</th><th>Lot number</th><th>Customer Name</th><th>Start Date</th><th>End Date</th><th>Closing  Balance</th><th>Collection</th><th>Collection Date</th></tr>
<? $date=date('Y-m-d');
foreach($salselist as $raw){
	?>
	<script>
    $( function() {
    $( "#Collection_date<?=$raw->loan_code?>" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
    </script>
	
	<?
	$collection=0;$Collection_date='';$paid=0;$totint=0;
	if($monthtarget[$raw->loan_code])
	{
	$collection=$monthtarget[$raw->loan_code]->collection;
	$Collection_date=$monthtarget[$raw->loan_code]->Collection_date;
	}
	if($paidtots[$raw->loan_code])
	{
		$paid=$paidtots[$raw->loan_code]->totcap+$paidtots[$raw->loan_code]->totint;
	}
	if($raw->loan_type=='NEP')
	{
	$lastdate=get_eploan_last_date($raw->loan_code,$raw->reschdue_sqn);
	$stdate=get_eploan_first_date($raw->loan_code,$raw->reschdue_sqn);
	$loantatals=get_eploan_tot($raw->loan_code,$date,$raw->reschdue_sqn);
		if($loantatals) $totint=$loantatals->totint;
		$arrtot=0;
		if($arrears[$raw->loan_code])
		$arrtot=$arrears[$raw->loan_code]->arriastot;
		$balance=$arrtot-$paid+(get_loan_date_di($raw->loan_code,$date))+$raw->montly_rental;
		if($balance<0)$balance=0;
	}
	else
	{
		 $lastdate=date('Y-m-d',strtotime('+'.intval($raw->period).' months',strtotime($raw->start_date)));
		 $stdate=$raw->start_date;
		 $balance=$raw->loan_amount+$totint-$paid+(get_loan_date_di($raw->loan_code,$date));
	}
//	$balance=$raw->loan_amount+$totint-$paid+(get_loan_date_di($raw->loan_code,$date));
	?><tr>
<td><?=$raw->loan_code?></td>
<td><?=$raw->lot_number?> </td>
<td><?=$raw->first_name?> <?=$raw->last_name?> </td>
<td><?=$stdate?> </td>
<td><?=$lastdate?> </td>

<td><?=number_format($balance,2)?> </td>
<td >
  <div class="form-group">
  <input  type="text" name="collection<?=$raw->loan_code?>"   class="form-control"   onchange="format_val(this)"   id="collection<?=$raw->loan_code?>" value="<?=number_format($collection,2)?>"/>
  
  </div></td>
  <td >
  <div class="form-group">
  <input  type="text" name="Collection_date<?=$raw->loan_code?>"   class="form-control"   id="Collection_date<?=$raw->loan_code?>" value="<?=$Collection_date?>"/>
  
  </div></td>
  <td ><?=$raw->initial?> <?=$raw->surname?> 
 </td>
  <tr>

<? }?>

</table>
 <div class="form-group">
												
  <button type="submit" class="btn btn-primary disabled" onclick="check_this_market1()">Update</button>
											</div>
<? }?>
