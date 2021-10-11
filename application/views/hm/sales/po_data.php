 <div class="col-sm-3 "> <select name="officer_code" id="officer_code" class="form-control" placeholder="Introducer" required>
                                    <option value="">Project Officer</option>
                                    
                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" <? if($details->officer_code==$raw->id){?> selected="selected"<? }?> ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>
        
                                    </select></div>
                                  <div class="col-sm-3 ">		 <select name="officer_code2" id="officer_code2" class="form-control" placeholder="Introducer" required>
                                    <option value="">CR Officer</option>
                                    
                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" <? if($details->officer_code2==$raw->id){?> selected="selected"<? }?> ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>
        
                                    </select></div> 
                                      <div class="col-sm-3 ">		 <select name="team_leader" id="team_leader" class="form-control" placeholder="Introducer" >
                                    <option value="">Team Leader</option>
                                    
                                     <? if($officerlist) {foreach ($officerlist as $raw){?>
                    <option value="<?=$raw->id?>" <? if($details->team_leader==$raw->id){?> selected="selected"<? }?> ><?=$raw->initial?>&nbsp; <?=$raw->surname?></option>
                    <? }}?>
        
                                    </select></div> 
                                    
                                       <div class="clearfix"> </div> <br />
                         
                                      <div class="col-sm-3 ">
                                    <input  type="text"	 name="tpo" id="tpo"  value="<?=$details->tpo?>"  class="form-control" placeholder="TPO"/></div>  <button type="submit" class="btn btn-primary " onclick="inner_check_this_totals()">Update</button>
                