<? if($planlist){
?>
<table class="table"> <thead>

 <tr>  <th>Lot Number</th>  <th>Land Extend</th><th>Perch Price </th> <th>Sale Value </th><th></th></tr> </thead>
 <? foreach($planlist as $rw){?>
 
 <tr class="warning" ><td>Plan No :<?=$rw->plan_no?></td><td>Plan Sequense<?=$rw->plan_sq?></td></tr>
 

<? $c=0;
foreach($lotlist[$rw->plan_sq] as $row){	
	?> <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->plan_sqid?></th> <td><?=$row->lot_number  ?></td> <td> <?=$row->extend_perch  ?></td>
                        <td><?=$row->price_perch?></td> 
                        <td><?=$row->sale_val ?></td>
                        <td align="right"></td>
                         </tr> 

<? }}}?>

 <input type="hidden" name="totalextend" id="totalextend" value="<?=$details->selable_area?>">
  <input type="hidden" name="estimatecost" id="estimatecost" value="<?=$estimateprice?>">
 