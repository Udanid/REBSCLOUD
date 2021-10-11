<? if($salselist){?>
<table class="table" style=" width:80%">
<tr><th> Project Code</th><th> Project Name</th><th>Project Officer Name</th><th>Blocks (Finalized)</th><th>Sales Target</th><th>Cash Target</th><th>Income Target</th></tr>
<? foreach($salselist as $raw){ $target=0;$blocks=0;$sales=0;$income=0;
if(check_pending_lots($raw->prj_id)){?>
<tr>
<td><?=$raw->project_code?></td>
<td><?=$raw->project_name?></td>
<td><?=$raw->initial?> <?=$raw->surname?></td>
<td width="200">
<? if($monthtarget[$raw->prj_id]){

	$target=$monthtarget[$raw->prj_id]->target;
	$blocks=$monthtarget[$raw->prj_id]->blocks;
	$sales=$monthtarget[$raw->prj_id]->sales;
	$income=$monthtarget[$raw->prj_id]->income;
	
}?> 
  <div class="form-group">
  <input  type="text" name="blocks<?=$raw->prj_id?>"   class="form-control" onchange="format_val(this)"   id="blocks<?=$raw->prj_id?>" value="<?=number_format($blocks,2)?>"/>
  
  </div></td>
  <td width="200">
  <div class="form-group">
  <input  type="text" name="sales<?=$raw->prj_id?>"   class="form-control" onchange="format_val(this)"   id="sales<?=$raw->prj_id?>" value="<?=number_format($sales,2)?>"/>
  
  </div></td>
<td width="200">
  <div class="form-group">
  <input  type="text" name="target<?=$raw->prj_id?>"   class="form-control" onchange="format_val(this)"   id="target<?=$raw->prj_id?>" value="<?=number_format($target,2)?>"/>
  
  </div></td>
  <td width="200">
  <div class="form-group">
  <input  type="text" name="income<?=$raw->prj_id?>"   class="form-control" onchange="format_val(this)"   id="income<?=$raw->prj_id?>" value="<?=number_format($income,2)?>"/>
  
  </div></td></tr>

<? } }?>

</table>
 <div class="form-group">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_market()">Update</button>
											</div>
                                            
 
<? }?>
