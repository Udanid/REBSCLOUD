  <div class="form-title">
								<h5>Land Extent (Perch) :<?=$details->land_extend?> <span style="float:right">Salable Area : <?=$details->selable_area?></span></h5>
							</div><br />
<?
$count=0;
 if($planlist){
	$count=1;
?>
<table class="table"> <thead>

 <tr> <th>Lot Number</th>  <th>Lot Extent</th> <th>Perch Price </th><th>Sale Price </th> <th>Remove Select</th></tr> </thead>
 <? foreach($planlist as $rw){?>
 
 <tr class="warning"  style="font-weight:bold"><td colspan="2">Plan No :<?=$rw->plan_no?></td><td  colspan="3">Plan Sequence : <?=$rw->plan_sq?></td></tr>
 

<? $c=0;
foreach($lotlist[$rw->plan_sq] as $row){	
	?> <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <td scope="row"><input type="hidden"    style="width:70px; padding:3px;" class="form-control" id="lot_id<?=$count?>" name="lot_id<?=$count?>" value="<?=$row->lot_id?>" required="required">
                        <input type="text"    style="width:50px; padding:3px;" class="form-control" id="lot_number<?=$count?>" name="lot_number<?=$count?>" value="<?=str_pad($row->lot_number, 2, "0", STR_PAD_LEFT)?>" required="required"></td>
                         <td><div class="form-group has-feedback" ><input type="text"  class="form-control" name="perches_count<?=$count?>" id="perches_count<?=$count?>" value="<?=$row->extend_perch?>" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div>
                         </td>
                         <td> <div class="form-group has-feedback" ><input type="number" step="0.01"  class="form-control" name="price<?=$count?>"  onblur="calculate_salestot('<?=$count?>')"  id="price<?=$count?>" value="<?=round($row->price_perch,2)?>" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div></td>
                        <td><div class="form-group has-feedback" ><input type="text"  class="form-control" name="subtotprice<?=$count?>" id="subtotprice<?=$count?>" value="<?=$row->sale_val?>" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                         <span class="help-block with-errors" ></span></div></td> 
                       
                        <td align="right"><input type="checkbox"  value="YES" name="isselect<?=$count?>"  id="isselect<?=$count?>" >
                        <input type="hidden" name="plansq<?=$count?>" id="plansq<?=$count?>" value="<?=$rw->plan_sq?>"></td>
                         </tr> 

<? $count++; }}}?>
<input type="hidden" name="oldblockcount" id="oldblockcount" value="<?=$count?>">
 <input type="hidden" name="totalextend" id="totalextend" value="<?=$details->land_extend?>">
  <input type="hidden" name="estimatecost" id="estimatecost" value="<?=$estimateprice?>">
 