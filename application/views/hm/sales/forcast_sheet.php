<? if($salselist){?>
<table class="table" style=" width:80%">
<tr><th> Reservation Code</th><th>Lot number</th><th>1st week</th><th>2nd week</th><th>3rd week</th><th>4th week</th><th>5th week</th></tr>
<? foreach($salselist as $raw){
	$week1=0;$week2=0;$week3=0;$week4=0;$week5=0;
	if($monthtarget[$raw->res_code])
	{
	$week1=	$monthtarget[$raw->res_code]->week1;
	$week2=	$monthtarget[$raw->res_code]->week2;
	$week3=	$monthtarget[$raw->res_code]->week3;
	$week4=	$monthtarget[$raw->res_code]->week4;
	$week5=	$monthtarget[$raw->res_code]->week5;
	}
	?><tr>
<td><?=$raw->res_code?></td>
<td><?=$raw->lot_number?> </td>
<td >
  <div class="form-group">
  <input  type="text" name="week1<?=$raw->res_code?>"   class="form-control"   onchange="format_val(this)"   id="week1<?=$raw->res_code?>" value="<?=number_format($week1,2)?>"/>
  
  </div></td>
  <td >
  <div class="form-group">
  <input  type="text" name="week2<?=$raw->res_code?>"   class="form-control"  onchange="format_val(this)"  id="week2<?=$raw->res_code?>" value="<?=number_format($week2,2)?>"/>
  
  </div></td>
  <td >
  <div class="form-group">
  <input  type="text" name="week3<?=$raw->res_code?>"   class="form-control"   onchange="format_val(this)" id="week3<?=$raw->res_code?>" value="<?=number_format($week3,2)?>"/>
  
  </div></td>
  <td >
  <div class="form-group">
  <input  type="text" name="week4<?=$raw->res_code?>"   class="form-control"   onchange="format_val(this)" id="week4<?=$raw->res_code?>" value="<?=number_format($week4,2)?>"/>
  
  </div></td>
  <td >
  <div class="form-group">
  <input  type="text" name="week5<?=$raw->res_code?>"   class="form-control"   onchange="format_val(this)" id="week5<?=$raw->res_code?>" value="<?=number_format($week5,2)?>"/>
  
  </div></td><tr>

<? }?>

</table>
 <div class="form-group">
												
  <button type="submit" class="btn btn-primary disabled" onclick="check_this_market1()">Update</button>
											</div>
<? }?>
