<? if($salselist){?>
<table class="table" style=" width:80%">
<tr><th>Project Officer Name</th><th>Sales Target</th><th>Block target</th></tr>
<? foreach($salselist as $raw){ $target=0;$blocks=0;$sales=0;$income=0;$block=0;
?>
<tr>
<td><?=$raw->initial?> <?=$raw->surname?></td>

<input type="hidden"  name="officer_id" id="officer_id"  value="<?=$raw->id?>" />
<? if($monthtarget[$raw->id]){

//	$target=$monthtarget[$raw->id]->target;
	//$blocks=$monthtarget[$raw->id]->blocks;
	$sales=$monthtarget[$raw->id]->sales;
	$block=$monthtarget[$raw->id]->block;
	
//	$income=$monthtarget[$raw->id]->income;
	
}?> 
<td>
  <div class="form-group">
  <input  type="text" name="sales<?=$raw->id?>"   class="form-control" onchange="format_val(this)"   id="sales<?=$raw->id?>" value="<?=number_format($sales,2)?>"/>
  
  </div></td>
  <td >
  <div class="form-group">
  <input  type="text" name="block<?=$raw->id?>"   class="form-control" onchange="format_val(this)"   id="block<?=$raw->id?>" value="<?=number_format($block,2)?>"/>
  
  </div></td>
 </tr>

<? } ?>

</table>
 <div class="form-group">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_market()">Update</button>
											</div>
                                            
 
<? }?>
