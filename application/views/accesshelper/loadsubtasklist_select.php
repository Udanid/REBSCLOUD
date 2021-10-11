 <select class="form-control" placeholder="Task Code"  id="sub_id_cont" name="sub_id_cont"  required  >
                                    
                    <option value="0">Select sub Menu</option>
                    <? foreach ($sublist as $rw){ if($rw->status=='Active'){?>
                    <option value="<?=$rw->sub_id?>"><?=$rw->sub_name?></option>
                    <? }}?>
              
					
					</select> 