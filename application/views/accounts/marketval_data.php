 							
<?
$count=0;
 if($details){
	$count=1;
?>
<table class="table"> <thead>

 <tr> <th>Lot Number</th>  <th>Lot Extent</th> <th>Perch Price </th><th>Sale Price </th> <th>Cost</th></tr> </thead>

 

<? $c=0;
foreach($details as $row){	
	?> <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <td scope="row"><?=str_pad($row->lot_number, 2, "0", STR_PAD_LEFT)?>-<?=str_pad($row->plan_sqid, 2, "0", STR_PAD_LEFT)?></td>
                         <td><div class="form-group has-feedback" ><?=$row->extend_perch?><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div>
                         </td>
                         <td> <div class="form-group has-feedback" ><?=$row->price_perch?><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div></td>
                        <td><div class="form-group has-feedback" ><?=$row->sale_val?><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div></td> 
                         
                       <? $marketval=0; if($row->costof_sale) $marketval=$row->costof_sale;?>
                        <td align="right"><div class="form-group has-feedback" ><input type="number"  class="form-control"  step="0.01"name="marketprice<?=$row->lot_id?>" id="marketprice<?=$row->lot_id?>" value="<?=$marketval?>" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div></td>
                           </tr> 

<? $count++; }}?></tbody></table>	<div class="col-sm-4 has-feedback" id="paymentdateid" style="float:right"><button type="submit" class="btn btn-primary disabled" >Add Market Price</button></div>
