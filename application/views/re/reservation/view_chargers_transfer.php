<h4>Transfer Details<span  style="float:right; color:#FFF" ><a href="javascript:close_view()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
<table class="table">
	<thead>
		<th>Description</th>
		<th>Value</th>
	</thead>
<?if($transfer_data){foreach($transfer_data as $row){?>
	<?if($row->charge_type == 'document_fee'){?>
	<td>Draft Checking Fee</td>
	<?}?>
	<?if($row->charge_type == 'stamp_duty'){?>
	<td>Stamp Duty</td>
	<?}?>
	<?if($row->charge_type == 'leagal_fee'){?>
	<td>Legal Fee</td>
	<?}?>
	<?if($row->charge_type == 'other_charges'){?>
	<td>Plan Fee</td>
	<?}?>
	<?if($row->charge_type == 'other_charge2'){?>
	<td>P/R Fee</td>
	<?}?>
	<?if($row->charge_type == 'opinion_fee'){?>
	<td>Opinion Fee/td>
	<?}?>
	<?if($row->charge_type == 'document_chargers'){?>
	<td>Document Chargers</td>
	<?}?>
	<?if($row->charge_type == 'ep_document_chargers'){?>
	<td>EP Document Chargers</td>
	<?}?>
	<td><?=$row->value;?></td>
<?}}?>
</table>
</div>
