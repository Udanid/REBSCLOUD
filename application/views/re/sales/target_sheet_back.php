<? if($salselist){?>
<table class="table" style=" width:80%">
<tr><th> User ID</th><th>Sales Officer Name</th><th>Monthly Target</th></tr>
<? foreach($salselist as $raw){?>
<tr>
<td><?=$raw->user_id?></td>
<td><?=$raw->initial?> <?=$raw->surname?></td>
<td width="200">
  <div class="form-group">
  <input  type="text" name="target<?=$raw->user_id?>"   class="form-control"   id="target<?=$raw->user_id?>" value="<?=$monthtarget[$raw->user_id]?>"/>
  
  </div></td></tr>

<? }?>

</table>
 <div class="form-group">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_market()">Update</button>
											</div>
                                            
 
<? }?>
