<? if($salselist){?>
<table class="table" style=" width:80%">
<tr><th> Project Code</th><th> Project Name</th><th>Project Officer Name</th><th>Monthly Target</th></tr>
<? foreach($salselist as $raw){?>
<tr>
<td><?=$raw->project_code?></td>
<td><?=$raw->project_name?></td>
<td><?=$raw->initial?> <?=$raw->surname?></td>
<td width="200">
  <div class="form-group">
  <input  type="text" name="target<?=$raw->prj_id?>"   class="form-control" onchange="format_val(this)"   id="target<?=$raw->prj_id?>" value="<?=number_format($monthtarget[$raw->prj_id])?>"/>
  
  </div></td></tr>

<? }?>

</table>
 <div class="form-group">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_market()">Update</button>
											</div>
                                            
 
<? }?>
